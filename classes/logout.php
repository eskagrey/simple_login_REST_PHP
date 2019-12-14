<?php
require $_SERVER["DOCUMENT_ROOT"].'/users/db_cstr.php';
class logout
{
    function __construct($session_id, $input_data)
    {        
        $result = array('status'=>false,'info'=>'');
        try
        {
            $cls_db_cstr = new db_cstr();
            $query_session = "select session_id from tbl_users where session_id = '".$session_id."'";
            $query_process = $cls_db_cstr->pdo_cstr()->query($query_session)->fetch(PDO::FETCH_ASSOC);
            if($query_process !== false)
            {
                $query_update = "update tbl_users set session_id = '' where user_name = '".$input_data['user_name']."' and user_id = ".$input_data["user_id"]."";
                $cls_db_cstr->pdo_cstr()->prepare($query_update)->execute();
                $result['status'] = true;
                $result['info'] = 'berhasil logout';
            }
            else
            {
                $result['info'] = "invalid session";
            }
        }
        catch (PDOException $e)
        {
            $result['info'] = $e; 
        }
        echo json_encode($result);
    }
}
?>