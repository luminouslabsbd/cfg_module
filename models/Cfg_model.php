<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cfg_model extends App_Model
{
    public function __construct()
    {
       parent::__construct();
    }

    // Custom Fields Create 
    public function add($data)
    {

        $this->db->insert(db_prefix().'cfg_manage', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return $insert_id;
        }
        return false;
    }

    public function edit($id)
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get(db_prefix().'cfg_manage')->row();
        }

        return $this->db->get(db_prefix().'cfg_manage')->result_array();

    }

    /**
     * Delete customer group
     * @param  mixed $id group id
     * @return boolean
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix().'cfg_manage');
        if ($this->db->affected_rows() > 0) {
            $this->db->where('groupid', $id);
            $this->db->delete(db_prefix().'cfg_manage');

            return true;
        }

        return false;
    }

    public function update_group($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'cfg_manage', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    

}
