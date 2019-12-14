<?php
require $_SERVER["DOCUMENT_ROOT"].'/users/db_cstr.php';
class login
{
    function __construct($input_data)
    {        
        $result = array('status'=>false,'info'=>'','data'=>'');
        try
        {
            $cls_db_cstr = new db_cstr();
            $cls_db_cstr->pdo_cstr()->beginTransaction();
            $query_select = "select user_id, user_name, user_address, user_phone, user_email from users where user_name = '".$input_data['user_name']."' and user_password = '".$input_data['user_password']."'";
            $query_process = $cls_db_cstr->pdo_cstr()->query($query_select)->fetch(PDO::FETCH_ASSOC);
            if($query_process !== false)
            {
                $update_session = "update tbl_users set session_id = '".$this->get_session($query_process['user_name'])."'";
                $cls_db_cstr->pdo_cstr()->prepare($update_session)->execute();
                $query_session = "select session_id from tbl_users where user_name = '".$input_data['user_name']."'";
                $session_process = $cls_db_cstr->pdo_cstr()->query($query_session)->fetch(PDO::FETCH_ASSOC);
                header("session_id:".base64_encode($session_process['session_id']));
                $result['status'] = true;
                $result['info'] = 'login berhasil';
                $result['data'] = $query_process;
            }
            else
            {
                $result['info'] = 'login gagal, username atau password salah';
            }
        }
        catch (PDOException $e)
        {
            $result['info'] = $e; 
        }
        echo json_encode($result);
    }

    function get_session($username)
    {
        $session = $username.date('ymdHis');
        return $session;
    }
}
?>