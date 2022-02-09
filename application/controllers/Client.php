<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Client extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Client_m');

        if (!$this->session->userdata('is_login') == true) {
            redirect('login');
        }
    }

    public function index()
    {

        $this->load->view('templates/bar');

        $this->load->view('view_Client');
        $this->load->view('templates/footer');
    }

    public function echopre($dt)
    {
        echo "<pre>";
        print_r($dt);
        echo "</pre>";
    }

    public function get_data()
    {
        $client = $this->Client_m->get_data();

        $i = 0;
        if (!empty($client)) {
            foreach ($client as $k => $v) {
                $dt_final[$i]['client_id'] = $v['client_id'];
                $dt_final[$i]['nmcomp'] = strtoupper($v['nmcomp']);
                $dt_final[$i]['nmperson'] = strtoupper($v['nmperson']);
                $dt_final[$i]['email'] = $v['email'];
                $dt_final[$i]['phonecomp'] = $v['phonecomp'];
                $dt_final[$i]['phoneperson'] = $v['phoneperson'];
                $i++;
            }
        } else {
            $dt_final[$i]['client_id'] = '';
            $dt_final[$i]['nmcomp'] = '';
            $dt_final[$i]['nmperson'] = "Data is null";
            $dt_final[$i]['email'] = '';
            $dt_final[$i]['phonecomp'] = '';
            $dt_final[$i]['phoneperson'] = '';
        }
        $object = json_decode(json_encode($dt_final), FALSE);
        // $this->echopre($object);
        // die;
        echo json_encode(array('response' => $object));
    }

    public function save_add()
    {
        // $this->echopre($_POST);
        // die;
        if (isset($_POST['nmcomp']) || isset($_POST['nmperson']) || isset($_POST['email'])) {
            foreach ($_POST['nmcomp'] as $key => $value) {
                $data = array();
                $data = array(
                    'client_id' => $this->input->post('client_id'),
                    'nmcomp' => $value,
                    'nmperson' => $_POST['nmperson'][$key],
                    'email' => $_POST['email'][$key],
                    'phonecomp' => $_POST['phonecomp'][$key],
                    'phoneperson' => $_POST['phoneperson'][$key],
                );
                $result = $this->Client_m->save_add($data);
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

        $client = $this->Client_m->get_data_by_id($id);

        echo json_encode($client);
    }

    public function save_edit()
    {
        $id = $this->input->post('id');
        $data = array(
            'client_id' => $this->input->post('client_id'),
            'nmcomp' => $this->input->post('nmcomp'),
            'nmperson' => $this->input->post('nmperson'),
            'email' => $this->input->post('email'),
            'phonecomp' => $this->input->post('phonecomp'),
            'phoneperson' => $this->input->post('phoneperson'),
        );

        // $this->echopre($_POST);
        // die;
        $result = $this->Client_m->save_edit($data, $id);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function save_delete()
    {
        $id = $this->input->post('id');
        $result = $this->Client_m->deleted_data($id);

        if ($result) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }
}
