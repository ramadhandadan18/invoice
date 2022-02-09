<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_m extends CI_Model
{

    public function get_data($dt)
    {
        if ($dt['no_inv'] != 'ALL') {
            $this->db->where('no_inv', $dt['no_inv']);
        }

        if ($dt['client'] != 'ALL') {
            $this->db->where('client', $dt['client']);
        }

        if ($dt['doc_status'] != 'ALL') {
            $this->db->where('doc_status', $dt['doc_status']);
        }

        if ($dt['date_inv'] != 'ALL') {
            $this->db->where('date_inv', $dt['date_inv']);
        }

        if ($dt['date_due'] != 'ALL') {
            $this->db->where('date_due', $dt['date_due']);
        }

        $dt = $this->db
            ->select('')
            ->from('invoice')
            ->order_by('id_inv', 'ASC')
            ->get()
            ->result_array();
        // echo ($this->db->last_query());
        // die;
        return $dt;
    }


    public function get_max_id()
    {
        $dt = $this->db
            ->select('MAX(kategori_id) as kategori_id')
            ->from('master_kategori')
            ->order_by('kategori_id', 'ASC')
            ->get()
            ->row()->Kategori_id;
        return $dt;
    }

    public function save_add($data)
    {
        $result = $this->db->insert('invoice', $data);
        return $result;
    }

    public function get_data_by_id($id)
    {

        $qy = "
            SELECT
                *
            from
                invoice
            where 
                id = '" . $id . "'
        ";
        // echo ($this->db->last_query($id));
        // die;
        $result = $this->db->query($qy)->row();
        return $result;
    }

    public function save_edit($data, $id)
    {
        $this->db->where('id_inv', $id);
        $result = $this->db->update('invoice', $data);
        return $result;
    }

    public function deleted_data($id)
    {
        $this->db->where('id_inv', $id);
        return $this->db->delete('invoice');
    }
}
