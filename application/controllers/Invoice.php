<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Invoice_m');

        if (!$this->session->userdata('is_login') == true) {
            redirect('login');
        }
    }

    public function index()
    {

        $this->load->view('templates/bar');

        $this->load->view('view_Invoice');
        $this->load->view('templates/footer');
    }

    public function index_invoice()
    {

        $this->load->view('templates/bar');

        $this->load->view('view_invoice_all');
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
        $_POST['no_inv'] = $fill_1;
        $_POST['client'] = $fill_2;
        $_POST['doc_status'] = $fill_3;
        $_POST['date_inv'] = $fill_4;
        $_POST['due_date'] = $fill_5;
        // $this->echopre($_POST);

        $transaksi = $this->Invoice_m->get_data($_POST);
        // $this->echopre($_POST);

        $i = 0;
        if (!empty($transaksi)) {
            foreach ($transaksi as $k => $v) {
                $dt_final[$i]['id_inv'] = $v['id_inv'];
                $dt_final[$i]['no_inv'] = $v['no_inv'];
                $dt_final[$i]['client'] = strtoupper($v['client ']);
                $dt_final[$i]['doc_status'] = $v['doc_status'];
                $dt_final[$i]['payment_status'] = $v['payment_status'];
                $dt_final[$i]['amount'] = number_format($v['amount']);
                $dt_final[$i]['outstanding'] = number_format($v['outstanding']);
                $dt_final[$i]['date_inv'] = $v['date_inv'];
                $dt_final[$i]['date_due'] = $v['date_due'];
                $i++;
            }
        } else {
            $dt_final[$i]['id_inv'] = '';
            $dt_final[$i]['no_inv'] = '';
            $dt_final[$i]['client'] = '';
            $dt_final[$i]['doc_status'] = 'Data is null';
            $dt_final[$i]['payment_status'] = '';
            $dt_final[$i]['amount'] = '';
            $dt_final[$i]['outstanding'] = '';
            $dt_final[$i]['date_inv'] = '';
            $dt_final[$i]['date_fue'] = '';
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

    public function get_data_by_id($id_inv)
    {

        $invoice = $this->Invoice_m->get_data_by_id($id_inv);
        foreach ($invoice as $key => $value) {
            $data['id_inv'] = $value['id_inv'];
            $data['no_inv'] = $value['no_inv'];
            $data['client'] = $value['client'];
            $data['doc_status'] = $value['doc_status'];
            $data['payment_status'] = $value['payment_status'];
            $data['amount'] = $value['amount'];
            $data['outstanding'] = $value['outstanding'];
            $data['date_inv'] = $value['date_inv'];
            $data['date_due'] = $value['date_due'];
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
            'id_inv' => $this->input->post('id_inv'),
            'no_inv' => $this->input->post('no_inv'),
            'client' => $this->input->post('client'),
            'doc_status' => $this->input->post('doc_status'),
            'payment_status' => $this->input->post('payment_status'),
            'amount' => $this->input->post('amount'),
            'outstanding' => $this->input->post('outstanding'),
            'date_inv' => $this->input->post('date_inv'),
            'due_date' => $this->input->post('due_date'),
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
}
