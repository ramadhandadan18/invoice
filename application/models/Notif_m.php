<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Notif_m extends CI_Model
{

    public function get_data($dt)
    {
        if ($dt['pegawai'] != 'ALL') {
            $this->db->where('B.pegawai_no', $dt['pegawai']);
        }

        if ($dt['tahun'] != 'ALL') {
            $this->db->where('substr(A.tgl_transaksi,1,4)', $dt['tahun']);
        }

        if ($dt['bulan'] != 'ALL') {
            $this->db->where('substr(A.tgl_transaksi,6,2)', $dt['bulan']);
        }

        if ($dt['minggu'] != 'ALL') {
            $this->db->where('A.mingguan', $dt['minggu']);
        }

        // if ($dt['status'] != 'ALL') {
        //     $this->db->where('A.status', $dt['status']);
        // }

        $dt = $this->db
            ->select('A.id, A.pegawai_id,A.tanggal,A.mingguan,A.tgl_transaksi,A.harga,A.kategori,A.status,B.pegawai_no,B.pegawai_nama')
            ->from('transaksi A')
            ->join('master_pegawai B', 'A.pegawai_id = B.pegawai_no', 'LEFT')
            ->where('A.kategori', 'OLI', 'DESC')
            ->get()
            ->result_array();
        // echo ($this->db->last_query());
        // die;
        return $dt;
    }

    public function get_data_by_id($id)
    {

        $qy = "
            SELECT
                *
            from
                transaksi
            where 
                id = '" . $id . "'
        ";
        $result = $this->db->query($qy)->result_array();
        return $result;
    }

    public function get_data_status()
    {
        $dt = $this->db
            ->from('transaksi')
            ->order_by('status', 'ASC')
            ->get()
            ->result();
        return $dt;
    }

    public function save_edit($data, $id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('transaksi', $data);
        return $result;
    }
}
