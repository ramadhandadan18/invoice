<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Client_m extends CI_Model
{

    public function get_data()
    {
        $dt = $this->db
            ->select('client_id, nmcomp, nmperson, email, phonecomp, phoneperson')
            ->from('client')
            ->order_by('client_id', 'ASC')
            ->get()
            ->result_array();
        // echo $this->db->last_query();die;
        return $dt;
    }

    public function cek_nama($nmcomp)
    {
        $dt = $this->db
            ->select('nmcomp')
            ->from('client')
            ->where('UPPER(REPLACE(nmcomp," ","")) = ', $nmcomp)
            ->get()
            ->result_array();
        return $dt;
    }

    public function save_add($data)
    {
        $result = $this->db->insert('client', $data);
        return $result;
    }

    public function get_data_by_id($id)
    {

        $qy = "
            SELECT
                *
            from
                client
            where 
                client_id = '" . $id . "'
        ";
        $result = $this->db->query($qy)->row();
        return $result;
    }

    public function save_edit($data, $id)
    {
        $this->db->where('client_id', $id);
        $result = $this->db->update('client_id', $data);
        return $result;
    }

    public function deleted_data($id)
    {
        $this->db->where('client_id', $id);
        return $this->db->delete('client');
    }
}
