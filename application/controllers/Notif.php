<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Notif extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notif_m');

        if (!$this->session->userdata('is_login') == true) {
            redirect('login');
        }
    }

    public function index()
    {

        $this->load->view('templates/bar');

        $this->load->view('view_Notif');
        $this->load->view('templates/footer');
    }

    public function echopre($dt)
    {
        echo "<pre>";
        print_r($dt);
        echo "</pre>";
    }

    public function get_data($fill_1, $fill_2, $fill_3, $fill_4, $fill_5)
    {
        $_POST['pegawai'] = $fill_1;
        $_POST['tahun'] = $fill_2;
        $_POST['bulan'] = $fill_3;
        $_POST['minggu'] = $fill_4;
        $_POST['status'] = $fill_5;
        // $this->echopre($_POST);
        // die;
        $notif = $this->Notif_m->get_data($_POST);

        $i = 0;
        if (!empty($notif)) {
            foreach ($notif as $k => $v) {
                $dt_final[$i]['id'] = $v['id'];
                $dt_final[$i]['pegawai_id'] = $v['pegawai_id'];

                $dt_final[$i]['tanggal'] = $v['tanggal'];
                $dt_final[$i]['mingguan'] = $v['mingguan'];
                $dt_final[$i]['tgl_transaksi'] = $v['tgl_transaksi'];
                $startDate = $v['tgl_transaksi']; // select date in Y-m-d format
                $nMonths = 6; // choose how many months you want to move ahead
                $final = $this->endCycle($startDate, $nMonths); // output: 2014-07-02
                $dt_final[$i]['tgl_end'] = $final;

                //flag
                if (empty($v['status'])) {
                    $y_month = substr(str_replace("-", '', $final), 0, 6);
                    $y_month_1 = $y_month - 1;
                    $date_now = date('Ym');
                    // $dt_final[$i]['status'] = $date_now;
                    if ($y_month == $date_now) {
                        $dt_final[$i]['status'] = 'Ganti';
                        $dt_final[$i]['status_id'] = '01';
                    } //bulan sama
                    else if ($date_now  == $y_month_1) {
                        $dt_final[$i]['status_id'] = '02';
                        $dt_final[$i]['status'] = 'Siap siap Ganti';
                    } //H-1 bulan ganti
                    else if ($date_now > $y_month) {
                        $dt_final[$i]['status_id'] = '03';
                        $dt_final[$i]['status'] = 'Harus Ganti';
                    } else {
                        $dt_final[$i]['status_id'] = '04';
                        $dt_final[$i]['status'] = 'Normal';
                    }
                } else {
                    if ($v['status'] == 1) {
                        $dt_final[$i]['status_id'] = '05';
                        $dt_final[$i]['status'] = 'Sudah Ganti Oli';
                    }
                }
                $i++;
            }
        } else {
            $dt_final[$i]['pegawai_id'] = '';
            $dt_final[$i]['pegawai_no'] = '';
            $dt_final[$i]['tanggal'] = '';
            $dt_final[$i]['mingguan'] = '';
            $dt_final[$i]['tgl_transaksi'] = '';
            $dt_final[$i]['tgl_end'] = '';
            $dt_final[$i]['status'] = '';
        }

        $dt = array();
        $i = 0;
        foreach ($dt_final as $key => $value) {
            if ($_POST['status'] != 'ALL') {
                if ($value['status_id'] == $_POST['status']) {
                    $dt[$i] = $value;
                }
            } else
                $dt[$i] = $value;
            $i++;
        }
        // $this->echopre($dt);
        // die;
        $object = json_decode(json_encode($dt), FALSE);
        echo json_encode(array('response' => $object));
    }

    function add_months($months, DateTime $dateObject)
    {
        $next = new DateTime($dateObject->format('Y-m-d'));
        $next->modify('last day of +' . $months . ' month');

        if ($dateObject->format('d') > $next->format('d')) {
            return $dateObject->diff($next);
        } else {
            return new DateInterval('P' . $months . 'M');
        }
    }

    function endCycle($d1, $months)
    {
        $date = new DateTime($d1);

        // call second function to add the months
        $newDate = $date->add($this->add_months($months, $date));

        // goes back 1 day from date, remove if you want same day of month
        $newDate->sub(new DateInterval('P1D'));

        //formats final date to Y-m-d form
        $dateReturned = $newDate->format('Y-m-d');

        return $dateReturned;
    }

    public function get_data_by_id($id)
    {

        $transaksi = $this->Notif_m->get_data_by_id($id);
        foreach ($transaksi as $key => $value) {
            $data['id'] = $value['id'];
            $data['pegawai_id'] = $value['pegawai_id'];
            // $data['tanggal'] = $value['tanggal'];
            $startDate = $value['tgl_transaksi']; // select date in Y-m-d format
            $nMonths = 6; // choose how many months you want to move ahead
            $final = $this->endCycle($startDate, $nMonths); // output: 2014-07-02

            $data['tgl_end'] = $final;
            $data['tgl_transaksi'] = $value['tgl_transaksi'];
            $data['kategori'] = $value['kategori'];
            $data['status'] = $value['status'];
        }
        $data_obj = (object)$data;
        // $this->echopre($data_obj);
        // die;
        echo json_encode($data_obj);
    }

    public function get_data_status()
    {
        $data[0]['status'] = 'ALL';
        $data[0]['status_desc'] = 'ALL';

        $data[1]['status'] = '01';
        $data[1]['status_desc'] = 'Ganti';
        $data[2]['status'] = '02';
        $data[2]['status_desc'] = 'Siap siap ganti';
        $data[3]['status'] = '03';
        $data[3]['status_desc'] = 'Harus ganti';
        $data[4]['status'] = '04';
        $data[4]['status_desc'] = 'Normal';
        $data[5]['status'] = '05';
        $data[5]['status_desc'] = 'Sudah Ganti Oli';

        $object = json_decode(json_encode($data), FALSE);
        echo json_encode($object);
    }

    public function save_edit()
    {
        $id = $this->input->post('id');
        $data = array(
            'pegawai_id' => $this->input->post('pegawai_id'),
            'tgl_transaksi' => $this->input->post('tgl_transaksi'),
            'status' => $this->input->post('status'),
        );
        // $this->echopre($_POST);
        // die;
        $result = $this->Notif_m->save_edit($data, $id);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }
}
