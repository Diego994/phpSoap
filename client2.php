<?php 
    require_once("lib/nusoap.php");

    $serverURL = 'http://localhost/pwsdl/server2.php';
    $cliente = new nusoap_client("$serverURL?wsdl",'wsdl');

    $conexion = array('hostName' => 'localhost','dbName' => 'webServices','user' => 'root','password' => 'admin');
    $conexion = json_encode($conexion);
    $conexion = json_decode($conexion);



    
    $result = $cliente->call(
        "saludar", 
        array('nombre' => 'Juan','apellido'=>'Guerrero'),
        "uri:$serverURL"
    );

    $users = $cliente->call(
        "getById",
        array('hostName' => $conexion->hostName,'dbName' => $conexion->dbName,'user' => $conexion->user,'password' => $conexion->password, 'table' => 'user', 'id' => 1),
        "uri:$serverURL"
    );

    $users = json_decode($users);


    $auth = $cliente->call(
        "authenticate",
        array('hostName' => $conexion->hostName,'dbName' => $conexion->dbName,'user' => $conexion->user,'password' => $conexion->password, 'table' => 'user', 'field' => 'email', 'passwordField' => 'password', 'fieldVal' => 'dguerrero@storecheck.com', 'passwordVal' => '12345678'),
        "uri:$serverURL"
    );

    echo $auth;

    

    echo "<ul>";
    foreach ($users as $user) {
        echo "<li>".$user->name."</li>";
    }
    echo "</ul>";

    
?>