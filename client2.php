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
        array('hostName' => $conexion->hostName,'dbName' => $conexion->dbName,'user' => $conexion->user,'password' => $conexion->password, 'table' => 'user', 'id' => 2),
        "uri:$serverURL"
    );

    $users = json_decode($users);
    echo "<ul>";
    foreach ($users as $user) {
        echo "<li>".$user->name."</li>";
        echo "<li>".$user->lastName."</li>";
        echo "<li>".$user->password."</li>";
        echo "<li>".$user->email."</li>";
    };
    echo "</ul>";

    $email = $cliente->call(
        "getByEmail",
        array('hostName' => $conexion->hostName,'dbName' => $conexion->dbName,'user' => $conexion->user,'password' => $conexion->password, 'table' => 'user', 'email' => 'dguerrero@storecheck.com'),
        "uri:$serverURL"
    );

    $auth = $cliente->call(
        "authenticate",
        array('hostName' => '192.168.100.18','dbName' => $conexion->dbName,'user' => $conexion->user,'password' => $conexion->password, 'table' => 'user', 'field' => 'email', 'passwordField' => 'password', 'fieldVal' => 'dguerrero@storecheck.com', 'passwordVal' => '12345678'),
        "uri:$serverURL"
    );




    //echo $auth;

    $arrayUser = json_decode($email, true);
    echo $arrayUser[0]['id'];
    

    //print_r($regis);


    /*$session = $cliente->call(
        "getSessionById",
        array('hostName' => $conexion->hostName,'dbName' => $conexion->dbName,'user' => $conexion->user,'password' => $conexion->password, 'id' => 1, 'idAdmin' => 1),
        "uri:$serverURL"
    );*/

    $compra = $cliente->call(
        "buyByUserEmail",
        array('hostName' => $conexion->hostName,'dbName' => $conexion->dbName,'user' => $conexion->user,'password' => $conexion->password, 'table' => 'shopping', 'costColumn' => 'cost', 'idUserColumn' => 'idUser', 'idUser' => 17, 'userEmail' => 'diegoguerrero994@gmail.com', 'resultAlias' => 'compra'),
        "uri:$serverURL"
    );


    $resultado = json_decode($compra, true);

    echo $resultado[0]['compra'];

    
    
?>