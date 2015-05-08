<?php

function conn_mysql() {

    $servidor = 'br-cdbr-azure-south-a.cloudapp.net';
    $porta = 3306;
    $banco = "dawyearAEQ9qf0FM";
    $usuario = "bf56cf36c59b3a";
    $senha = "79bb0c91";

    $conn = new PDO("mysql:host=$servidor;
        port=$porta;
        dbname=$banco", $usuario, $senha, 
            array(PDO::ATTR_PERSISTENT => true)
    );
    return $conn;
}

?>