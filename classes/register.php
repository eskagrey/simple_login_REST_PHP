<?php
require $_SERVER["DOCUMENT_ROOT"].'/users/db_cstr.php';
class register
{
    function __construct($input_data)
    {   
        $cls_db_cstr = new db_cstr();
        $result = array('status'=>false,'info'=>'','data'=>'');
        $cls_db_cstr->pdo_cstr()->beginTransaction();
        try
        {
            $query_check = "select user_name from tbl_users where user_name = '".$input_data['user_name']."'";
            $process_check = $cls_db_cstr->pdo_cstr()->query($query_check)->fetch(PDO::FETCH_ASSOC);
            if($process_check['user_name'] == $input_data['user_name'])
            {
                $result['info'] = 'user name sudah ada';
            }
            else
            {
                $query_input = "insert into tbl_users (user_name, user_address, user_phone, user_email, user_password, register_dt)
                            values ('".$input_data['user_name']."','".$input_data['user_address']."','".$input_data['user_phone']."',
                            '".$input_data['user_email']."','".$input_data['user_password']."',(select now()))";
                $process_input = $cls_db_cstr->pdo_cstr()->prepare($query_input)->execute();
                if($process_input == true)
                {
                    $result['status'] = true;
                    $result['info'] = 'registrasi berhasil';
                }
                else
                {
                    $result['info'] = 'registrasi gagal';
                }
            }
            echo json_encode($result);
        }
        catch (PDOException $e)
        {
            $result['info'] = $e->getMessage();
            echo json_encode($result);
        }
    }
}
?>