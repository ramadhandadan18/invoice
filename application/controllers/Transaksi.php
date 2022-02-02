<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_m');

        if (!$this->session->userdata('is_login') == true) {
            redirect('login');
        }
    }

    public function index()
    {

        $this->load->view('templates/bar');

        $this->load->view('view_Transaksi');
        $this->load->view('templates/footer');
    }

    function echopre($dt)
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
        $_POST['kategori'] = $fill_5;
        // $this->echopre($_POST);

        $transaksi = $this->Transaksi_m->get_data($_POST);
        // $this->echopre($_POST);

        $i = 0;
        if (!empty($transaksi)) {
            foreach ($transaksi as $k => $v) {
                $dt_final[$i]['id'] = $v['id'];
                $dt_final[$i]['pegawai_no'] = $v['pegawai_no'];
                $dt_final[$i]['pegawai_nama'] = strtoupper($v['pegawai_nama']);
                $dt_final[$i]['tanggal'] = $v['tanggal'];
                $dt_final[$i]['mingguan'] = $v['mingguan'];
                $dt_final[$i]['qty'] = $v['qty'];
                $dt_final[$i]['tgl_transaksi'] = $v['tgl_transaksi'];
                $dt_final[$i]['kategori'] = $v['kategori'];
                $dt_final[$i]['deskripsi'] = $v['deskripsi'];
                $dt_final[$i]['harga'] = number_format($v['harga']);
                $dt_final[$i]['total'] = number_format($v['qty'] * $v['harga']);
                $i++;
            }
        } else {
            $dt_final[$i]['id'] = '';
            $dt_final[$i]['pegawai_id'] = '';
            $dt_final[$i]['pegawai_no'] = '';
            $dt_final[$i]['pegawai_nama'] = 'Data is null';
            $dt_final[$i]['tanggal'] = '';
            $dt_final[$i]['mingguan'] = '';
            $dt_final[$i]['qty'] = '';
            $dt_final[$i]['tgl_transaksi'] = '';
            $dt_final[$i]['kategori'] = '';
            $dt_final[$i]['deskripsi'] = '';
            $dt_final[$i]['harga'] = '';
            $dt_final[$i]['total'] = '';
        }
        $object = json_decode(json_encode($dt_final), FALSE);
        echo json_encode(array('response' => $object));
    }

    public function get_data_pegawai()
    {
        $pegawai = $this->Transaksi_m->get_data_pegawai();
        $dt_pegawai[0]['pegawai_id'] = 'ALL';
        $dt_pegawai[0]['pegawai_nama'] = 'ALL';
        $i = 1;
        foreach ($pegawai as $key => $value) {
            $dt_pegawai[$i]['pegawai_id'] = $value['pegawai_no'];
            $dt_pegawai[$i]['pegawai_nama'] = $value['pegawai_nama'];
            $i++;
        }

        $object = json_decode(json_encode($dt_pegawai), FALSE);
        echo json_encode($object);
    }

    public function get_data_pegawai_2()
    {
        $pegawai = $this->Transaksi_m->get_data_pegawai();
        $i = 0;
        foreach ($pegawai as $key => $value) {
            $dt_pegawai[$i]['pegawai_id'] = $value['pegawai_no'];
            $dt_pegawai[$i]['pegawai_nama'] = $value['pegawai_nama'];
            $i++;
        }

        $object = json_decode(json_encode($dt_pegawai), FALSE);
        echo json_encode($object);
    }

    public function get_data_kategori()
    {
        $kategori = $this->Transaksi_m->get_data_kategori();
        $dt_kategori[0]['kategori_id'] = 'ALL';
        $dt_kategori[0]['kategori_nama'] = 'ALL';
        $i = 1;
        foreach ($kategori as $key => $value) {
            $dt_kategori[$i]['kategori_id'] = $value['kategori_no'];
            $dt_kategori[$i]['kategori_nama'] = $value['kategori_nama'];
            $i++;
        }

        $object = json_decode(json_encode($dt_kategori), FALSE);
        echo json_encode($object);
    }

    public function save_add()
    {
        // $this->echopre($_POST);
        // die;
        if (isset($_POST['tgl_transaksi']) || isset($_POST['kategori']) || isset($_POST['harga'])) {
            foreach ($_POST['tgl_transaksi'] as $key => $value) {
                $data = array();
                $data = array(
                    'pegawai_id' => $this->input->post('pegawai_id'),
                    'tanggal' => $this->input->post('tanggal'),
                    'mingguan' => $this->input->post('mingguan'),
                    'tgl_transaksi' => $value,
                    'kategori' => $_POST['kategori'][$key],
                    'deskripsi' => $_POST['deskripsi'][$key],
                    'harga' => $_POST['harga'][$key],
                    'qty' => $_POST['qty'][$key],
                );
                $result = $this->Transaksi_m->save_add($data);
            }
            if ($result) {
                echo json_encode(1);
            } else {
                echo json_encode('Insert data failed');
            }
        } else {
            echo json_encode('Isi data barang dan harga');
        }
    }

    public function get_data_by_id($id)
    {

        $transaksi = $this->Transaksi_m->get_data_by_id($id);
        foreach ($transaksi as $key => $value) {
            $data['id'] = $value['id'];
            $data['pegawai_id'] = $value['pegawai_id'];
            $data['tanggal'] = $value['tanggal'];
            $data['mingguan'] = $value['mingguan'];
            $data['qty'] = $value['qty'];
            $data['tgl_transaksi'] = $value['tgl_transaksi'];
            $data['kategori'] = $value['kategori'];
            $data['deskripsi'] = $value['deskripsi'];
            $data['harga'] = $value['harga'];
        }
        $data_obj = (object)$data;
        // $this->echopre($data_obj);
        // die;
        echo json_encode($data_obj);
    }

    public function save_edit()
    {
        $id = $this->input->post('id');
        $data = array(
            'pegawai_id' => $this->input->post('pegawai_id'),
            'tanggal' => $this->input->post('tanggal'),
            'mingguan' => $this->input->post('mingguan'),
            'qty' => $this->input->post('qty'),
            'tgl_transaksi' => $this->input->post('tgl_transaksi'),
            'kategori' => $this->input->post('kategori'),
            'deskripsi' => $this->input->post('deskripsi'),
            'harga' => $this->input->post('harga'),
        );

        // $this->echopre($_POST);
        // die;
        $result = $this->Transaksi_m->save_edit($data, $id);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function save_delete()
    {
        $id = $this->input->post('id');
        $result = $this->Transaksi_m->deleted_data($id);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function get_data_kategori_select()
    {
        $kategori = $this->Transaksi_m->get_data_kategori();
        $output = '';
        foreach ($kategori as $key => $value) {
            $output .= '<option value="' . $value['kategori_no'] . '">' . $value['kategori_nama'] . '</option>';
        }
        return $output;
    }
}
