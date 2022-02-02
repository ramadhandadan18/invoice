<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gaji_m extends CI_Model
{

    public function get_data($dt)
    {
        if ($dt['pegawai'] != 'ALL') {
            $this->db->where('B.pegawai_no', $dt['pegawai']);
        }

        if ($dt['tahun'] != 'ALL') {
            $this->db->where('substr(A.tanggal,1,4)', $dt['tahun']);
        } else {
            $this->db->where('substr(A.tanggal,1,4)', date('Y'));
        }
        if ($dt['bulan'] != 'ALL') {
            $this->db->where('substr(A.tanggal,6,2)', $dt['bulan']);
        } else {
            $this->db->where('substr(A.tanggal,6,2)', date('m'));
        }

        $dt = $this->db
            ->select('A.id,A.pegawai_id,A.tanggal,A.gaji,B.pegawai_no,B.pegawai_nama')
            ->from('master_gaji A')
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

    function echopre($dt)
    {
        echo "<pre>";
        print_r($dt);
        echo "</pre>";
    }

    public function save_add_2($data)
    {
        $check = $this->db
            ->from('master_gaji')
            ->where('pegawai_id', $data['pegawai_id'])
            ->where('substr(tanggal,1,7)', substr($data['tanggal'], 0, 7))
            ->get()
            ->result_array();
        if (!empty($check)) {
            //update
            $this->db->where('pegawai_id', $data['pegawai_id']);
            $this->db->where('substr(tanggal,1,7)', substr($data['tanggal'], 0, 7));
            $result = $this->db->update('master_gaji', $data);
            return $result;
        } else {
            //insert
            $result = $this->db->insert('master_gaji', $data);
            return $result;
        }
    }

    public function save_add($data)
    {
        $result = $this->db->insert('master_gaji', $data);
        return $result;
    }

    public function get_data_by_id($id)
    {

        $qy = "
            SELECT
                A.*,B.pegawai_nama
            from
                master_gaji A
            left join master_pegawai B on A.pegawai_id = B.pegawai_no
            where 
                A.id = '" . $id . "'
        ";
        $result = $this->db->query($qy)->result_array();
        return $result;
    }

    public function save_edit($data, $id)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('master_gaji', $data);
        return $result;
    }

    public function deleted_data($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('master_gaji');
    }
}
