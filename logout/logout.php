<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require $_SERVER["DOCUMENT_ROOT"].'/users/classes/logout.php';
$result = array('status'=>false,'info'=>'','data'=>'');
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $input_data = json_decode(file_get_contents('php://input'), true);
    $params = array('user_name', 'user_id');
    $error = '';
    $session_id = isset($_SERVER["HTTP_SESSION_ID"])?$_SERVER["HTTP_SESSION_ID"]:'';
    if($session_id == "")
    {
        $result['info'] = "akses ditolak, session_id kosong. ";
        echo json_encode($result);
        die;
    }
    foreach ($params as $row)
    {
        if(!isset($input_data[$row]) || $input_data[$row] == "" || $input_data[$row] == null)
        {
            $error .= $row." kosong <br>";
        }
    }
    if($error !== "")
    {
        $result['info'] .= $error;
        echo json_encode($result);
        die;    
    }
    $class_register = new logout(base64_decode($session_id), $input_data);
}
else
{
    $result['info'] = "method harus POST";
    echo json_encode($result);
}
?>