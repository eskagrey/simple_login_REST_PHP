<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once $_SERVER["DOCUMENT_ROOT"].'/users/classes/login.php';
$result = array('status'=>false,'info'=>'','data'=>'');
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $input_data = json_decode(file_get_contents('php://input'), true);
    $params = array('user_name', 'user_password');
    $error = '';
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

    $class_login = new login($input_data);
}
else
{
    $result['info'] = "method harus POST";
    echo json_encode($result);
}
?>