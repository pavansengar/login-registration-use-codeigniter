<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * ****************************************************************
 * Class : Dbquery
 * Purpose : Execute all query ie(select,update and delete)
 * Created : 26-Aug-2019
 * Author : Pavan
 * ****************************************************************
 */
class Dbquery extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function insert($tbl, $data)
    {
        $data = $this->security->xss_clean($data);
        $this->db->insert($tbl, $data);
        return $this->db->insert_id();
    }

    /**
     * ****************************************************************
     * Function : update
     * Purpose : Execute all query ie(update) // added xss_clean to avoid sql injection
     * Created : 26-Aug-2019
     * Author : Pavan
     * ****************************************************************
     */
    function update($tblName, $wCondArr, $dataArr)
    {
        $wCondArr = $this->security->xss_clean($wCondArr);
        $dataArr = $this->security->xss_clean($dataArr);
        $this->db->where($wCondArr);
        $this->db->update($tblName, $dataArr);
        // echo $this->db->last_query(); die();
        return $this->db->affected_rows();
    }

    /**
     * ****************************************************************
     * Function : delete
     * Purpose : Execute all query ie(delete) // added xss_clean to avoid sql injection
     * Created : 26-Aug-2019
     * Author : Pavan
     * ****************************************************************
     */
    function delete($tblName, $wCondArr)
    {
        $wCondArr = $this->security->xss_clean($wCondArr);
        $this->db->where($wCondArr);
        $this->db->delete($tblName);
        // echo $this->db->last_query(); die();
        return $this->db->affected_rows();
    }

/**
 * ************************END CODE***********************************
 */
}