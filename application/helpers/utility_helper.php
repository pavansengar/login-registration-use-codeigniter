<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * *******************************************************
 * Action : utility_helper
 * Purpose : Contain all function which are related to commonly used
 * Created : 26-Aug-2019
 * Author : Pavan
 * Formating: Pavan
 * ******************************************************
 */

/**
 * ****************************************************************
 * Function : send_email
 * Purpose : This function used for send mail
 * Created : 26-Aug-2019
 * Author : Pavan
 * ****************************************************************
 */
if (! function_exists('sendEmail')) {

    function send_email($subject, $template_message, $mail_to, $mail_cc = "", $mail_bcc = "", $from = "", $from_name = "")
    {
        $obj = & get_instance();

        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $headers = "From: pavan.sengar@veebrij.com\r\n";
            $headers .= "Reply-To:pavan.sengar@veebrij.com\r\n";

            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            mail($mail_to, $subject, $template_message, $headers);
        } else {

            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'extvendor1@gmail.com',
                'smtp_pass' => '!QAZxdr5',
                'priority' => 1,
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
                'wordwrap' => TRUE
            );
            $obj->load->library('email', $config);
            $obj->email->set_mailtype("html");

            if (! empty($from)) {
                $from = $from;
            } else {
                $from = 'pavan9212@gmail.com';
            }
            if (! empty($from_name)) {
                $from_name = 'Testing Development-' . $from_name;
            } else {
                $from_name = 'Testing Development Team';
            }

            $obj->email->from($from, $from_name);

            if ($from != "") {
                $obj->email->reply_to($from, $from_name);
            }

            $obj->email->to($mail_to);
            if ($mail_cc != "") {
                $obj->email->cc($mail_cc);
            }
            if ($mail_bcc != "") {
                $obj->email->bcc($mail_bcc);
            }
            $obj->email->subject($subject);
            $obj->email->message($template_message);
            $obj->email->send();
            /*
             * if ($obj->email->send()) {
             * echo "Email has been sent.";
             * } else {
             * show_error($obj->email->print_debugger());
             * }
             */
        }
    }
}

/**
 * ****************************************************************
 * Function : get_email_template
 * Purpose : to get email template based on template name
 * Created : 26-Aug-2019
 * Author : Pavan
 * ****************************************************************
 */
if (! function_exists('get_email_template')) {

    function get_email_template($template_name)
    {
        $obj = & get_instance();
        $obj->db->select('*');
        $obj->db->where('template_name', $template_name);
        $query = $obj->db->get('th_email_template');
        return $query->row();
    }
}

/**
 * ****************************************************************
 * Function : get_register_user_detail_through_email
 * Purpose : return array of register user through email address
 * Created : 26-Aug-2019
 * Author : Pavan
 * ****************************************************************
 */
if (! function_exists('get_register_user_detail_through_email')) {

    function get_register_user_detail_through_email($email)
    {
        $obj = & get_instance();
        $obj->db->select('user_id,role_id,user_email_address,user_status');
        $obj->db->where('user_email_address', $email);
        $query = $obj->db->get('th_registration');
        $row = $query->num_rows();
        if ($row > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
}

/*
 * ****************************************************************
 * Function : return_single_row_of_table
 * Purpose : For getting single row of from any table based on condition
 * Created : 26-Aug-2019
 * Author : Pavan
 * ****************************************************************
 */
if (! function_exists('return_single_row_of_table')) {

    function return_single_row_of_table($tbl_name, $w_codition_array)
    {
        $obj = & get_instance();
        $obj->db->select('*');
        $obj->db->where($w_codition_array);
        $query = $obj->db->get($tbl_name);
        if (! empty($query->result())) {
            return $query->row();
        } else {
            return array();
        }
    }
}

/*
 * ****************************************************************
 * Function : get_single_value
 * Purpose : For getting single value of from any table based on condition
 * Created : 26-Aug-2019
 * Author : Pavan
 * ****************************************************************
 */
if (! function_exists('get_single_value')) {

    function get_single_value($tbl_name, $select_field_name, $w_codition_array)
    {
        $obj = & get_instance();
        $obj->db->select($select_field_name);
        $obj->db->where($w_codition_array);
        $qry = $obj->db->get($tbl_name);
        $data = $qry->first_row();
        return @$data->$select_field_name;
    }
}
/*
 * ****************************************************************
 * Function : return_multiple_row_of_table
 * Purpose : For getting multiple row of from any table based on condition
 * Created : 26-Aug-2019
 * Author : Pavan
 * ****************************************************************
 */
if (! function_exists('return_multiple_row_of_table')) {

    function return_multiple_row_of_table($tbl_name, $w_codition_array)
    {
        $obj = & get_instance();
        $obj->db->select('*');
        $obj->db->where($w_codition_array);
        $query = $obj->db->get($tbl_name);
        if (! empty($query->result())) {
            return $query->result();
        } else {
            return array();
        }
    }
}
/*
 * ****************************************************************
 * Function : get_sum_single_value
 * Purpose : For getting single value sum of from any table based on condition
 * Created : 26-Aug-2019
 * Author : Pavan
 * ****************************************************************
 */
if (! function_exists('get_sum_single_value')) {

    function get_sum_single_value($tbl_name, $select_field_name, $w_codition_array)
    {
        $obj = & get_instance();
        $obj->db->select('SUM(' . $select_field_name . ')');
        // $obj->db->select((SUM($select_field_name)));
        $obj->db->where($w_codition_array);
        $qry = $obj->db->get($tbl_name);
        $data = $qry->first_row();
        return @$data->$select_field_name;
    }
}

?>

