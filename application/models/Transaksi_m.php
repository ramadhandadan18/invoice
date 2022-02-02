<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_m extends CI_Model
{

    public function get_data($dt)
    {
        if ($dt['pegawai'] != 'ALL') {
            $this->db->where('B.pegawai_no', $dt['pegawai']);
        }

        if ($dt['tahun'] != 'ALL') {
            $this->db->where('substr(A.tanggal,1,4)', $dt['tahun']);
        }

        if ($dt['bulan'] != 'ALL') {
            $this->db->where('substr(A.tanggal,6,2)', $dt['bulan']);
        }

        if ($dt['minggu'] != 'ALL') {
            $this->db->where('A.mingguan', $dt['minggu']);
        }

        if ($dt['kategori'] != 'ALL') {
            $this->db->where('A.kategori', $dt['kategori']);
        }

        $dt = $this->db
            ->select('A.id, A.pegawai_id,A.tanggal,A.mingguan,A.qty,A.tgl_transaksi,A.harga,A.kategori,A.deskripsi,B.pegawai_no,B.pegawai_nama')
            ->from('transaksi A')
            ->join('master_pegawai B', 'A.pegawai_id = B.pegawai_no', 'LEFT')
            ->order_by('A.id', 'ASC')
            ->get()
            ->result_array();
        // echo ($this->db->last_query());
        // die;
        return $dt;
    }

    public function get_data_pegawai()
    {
        $dt = $this->db
            ->from('master_pegawai')
            ->order_by('pegawai_id', 'ASC')
            ->get()
            ->result_array();
        return $dt;
    }

    public function get_data_kategori()
    {
        $dt = $this->db
            ->from('master_kategori')
            ->order_by('kategori_id', 'ASC')
            ->get()
            ->result();
        return $dt;
    }

    public function save_add($data)
    {
        $result = $this->db->insert('transaksi', $data);
        return $result;
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

    public function save_edit($data, $id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('transaksi', $data);
        return $result;
    }

    public function deleted_data($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('transaksi');
    }
}
