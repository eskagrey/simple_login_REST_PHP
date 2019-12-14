<?php
class db_cstr
{
    function pdo_cstr()
    {
        $pdo_cstr   = new PDO("mysql:host=;dbname=user_account","administrator","ngadimin");
        $pdo_cstr->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo_cstr;
    }
}
?>