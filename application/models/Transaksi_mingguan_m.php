<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_mingguan_m extends CI_Model
{

    public function get_data($dt)
    {
        if ($dt['pegawai'] != 'ALL') {
            $this->db->where('B.pegawai_no', $dt['pegawai']);
        }

        if ($dt['tahun'] != 'ALL') {
            $this->db->where('substr(A.tgl_transaksi,1,4)', $dt['tahun']);
        } else {
            $this->db->where('substr(A.tgl_transaksi,1,4)', date('Y'));
        }
        if ($dt['bulan'] != 'ALL') {
            $this->db->where('substr(A.tgl_transaksi,6,2)', $dt['bulan']);
        } else {
            $this->db->where('substr(A.tgl_transaksi,6,2)', date('m'));
        }

        if ($dt['minggu'] != 'ALL') {
            $this->db->where('A.mingguan', $dt['minggu']);
        }

        if ($dt['kategori'] != 'ALL') {
            $this->db->where('A.kategori', $dt['kategori']);
        }

        $dt = $this->db
            ->select('A.id, A.pegawai_id,A.tanggal,A.mingguan,A.tgl_transaksi,A.harga,A.kategori,A.deskripsi,B.pegawai_no,B.pegawai_nama,A.qty, (A.qty * A.harga) as total')
            ->from('transaksi A')
            ->join('master_pegawai B', 'A.pegawai_id = B.pegawai_no', 'LEFT')
            ->where("A.pegawai_id IS NOT NULL")
            ->order_by('A.id', 'ASC')
            ->get()
            ->result_array();
        // echo($this->db->last_query());die;
        return $dt;
    }

    public function data_tahunan($dt)
    {
        if ($dt['pegawai'] != 'ALL') {
            $this->db->where('B.pegawai_no', $dt['pegawai']);
        }

        if ($dt['tahun'] != 'ALL') {
            $this->db->where('substr(A.tgl_transaksi,1,4)', $dt['tahun']);
        } else {
            $this->db->where('substr(A.tgl_transaksi,1,4)', date('Y'));
        }

        $dt = $this->db
            ->select('substr(A.tgl_transaksi,6,2) as bulan,sum(A.qty*A.harga) value,B.pegawai_no,B.pegawai_nama')
            ->from('transaksi A')
            ->join('master_pegawai B', 'A.pegawai_id = B.pegawai_no', 'LEFT')
            ->where("A.pegawai_id IS NOT NULL")
            ->order_by('B.pegawai_nama', 'ASC')
            ->group_by('substr(A.tgl_transaksi,6,2),B.pegawai_no,B.pegawai_nama')
            ->get()
            ->result_array();
        // echo($this->db->last_query());die;
        return $dt;
    }
    public function data_bulanan($dt)
    {
        if ($dt['pegawai'] != 'ALL') {
            $this->db->where('B.pegawai_no', $dt['pegawai']);
        }
        if ($dt['tahun'] != 'ALL') {
            $this->db->where('substr(A.tgl_transaksi,1,4)', $dt['tahun']);
        } else {
            $this->db->where('substr(A.tgl_transaksi,1,4)', date('Y'));
        }
        if ($dt['bulan'] != 'ALL') {
            $this->db->where('substr(A.tgl_transaksi,6,2)', $dt['bulan']);
        } else {
            $this->db->where('substr(A.tgl_transaksi,6,2)', date('m'));
        }
        $dt = $this->db
            ->select('substr(A.tgl_transaksi,6,2) as bulan,sum(A.harga*A.qty) as total,B.pegawai_no,B.pegawai_nama,A.mingguan')
            ->from('transaksi A')
            ->join('master_pegawai B', 'A.pegawai_id = B.pegawai_no', 'LEFT')
            ->where("A.kategori != 'GARASI'")
            ->where("A.pegawai_id IS NOT NULL")
            ->order_by('B.pegawai_nama', 'ASC')
            ->group_by('substr(A.tgl_transaksi,6,2),B.pegawai_no,B.pegawai_nama,A.mingguan')
            ->get()
            ->result_array();
        // echo($this->db->last_query());die;

        return $dt;
    }

    public function data_bulanan_garasi($dt)
    {
        if ($dt['pegawai'] != 'ALL') {
            $this->db->where('B.pegawai_no', $dt['pegawai']);
        }
        if ($dt['tahun'] != 'ALL') {
            $this->db->where('substr(A.tgl_transaksi,1,4)', $dt['tahun']);
        } else {
            $this->db->where('substr(A.tgl_transaksi,1,4)', date('Y'));
        }
        if ($dt['bulan'] != 'ALL') {
            $this->db->where('substr(A.tgl_transaksi,6,2)', $dt['bulan']);
        } else {
            $this->db->where('substr(A.tgl_transaksi,6,2)', date('m'));
        }
        $dt = $this->db
            ->select('substr(A.tgl_transaksi,6,2) as bulan,sum(A.harga*A.qty) as total,B.pegawai_no,B.pegawai_nama,A.mingguan')
            ->from('transaksi A')
            ->join('master_pegawai B', 'A.pegawai_id = B.pegawai_no', 'LEFT')
            ->where('A.kategori', 'GARASI')
            ->where("A.pegawai_id IS NOT NULL")
            ->order_by('B.pegawai_nama', 'ASC')
            ->group_by('substr(A.tgl_transaksi,6,2),B.pegawai_no,B.pegawai_nama,A.mingguan')
            ->get()
            ->result_array();
        // echo($this->db->last_query());die;

        return $dt;
    }

    public function data_gaji($dt)
    {
        if ($dt['pegawai'] != 'ALL') {
            $this->db->where('B.pegawai_no', $dt['pegawai']);
        }
        if ($dt['tahun'] != 'ALL') {
            $this->db->where('substr(A.tanggal,1,4)', $dt['tahun']);
        } else {
            $this->db->where('substr(A.tanggal,1,4)', date('Y'));
        }
        if (isset($dt['bulan'])) {
            if ($dt['bulan'] != 'ALL') {
                $this->db->where('substr(A.tanggal,6,2)', $dt['bulan']);
            } else {
                $this->db->where('substr(A.tanggal,6,2)', date('m'));
            }
        }

        $dt = $this->db
            ->select('substr(A.tanggal,6,2) as bulan,sum(A.gaji) as total,B.pegawai_no,B.pegawai_nama')
            ->from('master_gaji A')
            ->join('master_pegawai B', 'A.pegawai_id = B.pegawai_no', 'LEFT')
            ->order_by('B.pegawai_nama', 'ASC')
            ->group_by('substr(A.tanggal,6,2),B.pegawai_no,B.pegawai_nama')
            ->get()
            ->result_array();
        // echo($this->db->last_query());die;

        return $dt;
    }

    public function data_gaji_2($dt)
    {
        if ($dt['pegawai'] != 'ALL') {
            $this->db->where('B.pegawai_no', $dt['pegawai']);
        }
        if ($dt['tahun'] != 'ALL') {
            $this->db->where('substr(A.tanggal,1,4)', $dt['tahun']);
        } else {
            $this->db->where('substr(A.tanggal,1,4)', date('Y'));
        }

        $dt = $this->db
            ->select('substr(A.tanggal,1,4) as tahun,sum(A.gaji) as total,B.pegawai_no,B.pegawai_nama')
            ->from('master_gaji A')
            ->join('master_pegawai B', 'A.pegawai_id = B.pegawai_no', 'LEFT')
            ->order_by('B.pegawai_nama', 'ASC')
            ->group_by('substr(A.tanggal,1,4),B.pegawai_no,B.pegawai_nama')
            ->get()
            ->result_array();
        // echo($this->db->last_query());die;

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
