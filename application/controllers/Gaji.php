<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gaji extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gaji_m');

        if (!$this->session->userdata('is_login') == true) {
            redirect('login');
        }
    }

    public function index()
    {

        $this->load->view('templates/bar');

        $this->load->view('view_Gaji');
        $this->load->view('templates/footer');
    }

    function echopre($dt)
    {
        echo "<pre>";
        print_r($dt);
        echo "</pre>";
    }

    public function get_data($fill_1, $fill_2, $fill_3)
    {
        $_POST['pegawai'] = $fill_1;
        $_POST['tahun'] = $fill_2;
        $_POST['bulan'] = $fill_3;
        // $this->echopre($_POST);

        $gaji = $this->Gaji_m->get_data($_POST);
        // $this->echopre($_POST);

        $i = 0;
        if (!empty($gaji)) {
            foreach ($gaji as $k => $v) {
                $dt_final[$i]['id'] = $v['id'];
                $dt_final[$i]['pegawai_id'] = $v['pegawai_id'];
                $dt_final[$i]['pegawai_nama'] = strtoupper($v['pegawai_nama']);
                $date = date_create($v['tanggal']);
                $dt_final[$i]['month'] = date_format($date, "F");
                $dt_final[$i]['gaji'] = number_format($v['gaji']);
                $i++;
            }
        } else {
            $dt_final[$i]['id'] = '';
            $dt_final[$i]['pegawai_id'] = '';
            $dt_final[$i]['pegawai_nama'] = 'Data is null';
            $dt_final[$i]['month'] = '';
            $dt_final[$i]['gaji'] = '';
        }
        $object = json_decode(json_encode($dt_final), FALSE);
        echo json_encode(array('response' => $object));
    }

    public function get_data_pegawai()
    {
        $pegawai = $this->Gaji_m->get_data_pegawai();
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

    public function save_add()
    {
        $data = array(
            'pegawai_id' => $this->input->post('pegawai_id'),
            'tanggal' => $this->input->post('tanggal'),
            'gaji' => $this->input->post('gaji'),
        );

        $result = $this->Gaji_m->save_add_2($data);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function get_data_by_id($id)
    {

        $Gaji = $this->Gaji_m->get_data_by_id($id);
        foreach ($Gaji as $key => $value) {
            $data['id'] = $value['id'];
            $data['pegawai_id'] = $value['pegawai_id'];
            $data['tanggal'] = $value['tanggal'];
            $data['gaji'] = $value['gaji'];
            $data['pegawai_nama'] = $value['pegawai_nama'];
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
            'gaji' => $this->input->post('gaji'),
        );
        // $this->echopre($_POST);
        // die;
        $result = $this->Gaji_m->save_edit($data, $id);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function save_delete()
    {
        $id = $this->input->post('id');
        $result = $this->Gaji_m->deleted_data($id);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }
}
