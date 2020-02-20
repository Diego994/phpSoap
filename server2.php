<?php
    require_once("lib/nusoap.php");
    $miURL = "http://localhost/pwsdl/server2.php";
    $server = new soap_server();
    $server->configureWSDL('WSDLTST',$miURL);
    $server->wsdl->schemaTargetNamespace=$miURL;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    $server->register('saludar',
        array('nombre' => 'xsd:string', 
                'apellido' => 'xsd:string'
            ),
        array('return' => 'xsd:string'),
        $miURL
    );

    $server->register('getAll',
        array('hostName' => 'xsd:string',
                'dbName' => 'xsd:string',
                'user' => 'xsd:string',
                'password' => 'xsd:string',
                'table' => 'xsd:string'
            ),
        array('return' => 'xsd:string'),
        $miURL
    );

    $server->register('getById',
        array('hostName' => 'xsd:string',
                'dbName' => 'xsd:string',
                'user' => 'xsd:string',
                'password' => 'xsd:string', 
                'table' => 'xsd:string', 
                'id' => 'xsd:int'
            ),
        array('return' => 'xsd:string'),
        $miURL
    );

    $server->register('getByEmail',
        array('hostName' => 'xsd:string',
                'dbName' => 'xsd:string',
                'user' => 'xsd:string',
                'password' => 'xsd:string', 
                'table' => 'xsd:string', 
                'email' => 'xsd:string'
            ),
        array('return' => 'xsd:string'),
        $miURL
    );

    $server->register('authenticate',
        array('hostName' => 'xsd:string',
                'dbName' => 'xsd:string',
                'user' => 'xsd:string',
                'password' => 'xsd:string', 
                'table' => 'xsd:string', 
                'field' => 'xsd:string',
                'passwordField' => 'xsd:string',
                'fieldVal' => 'xsd:string',
                'passwordVal' => 'xsd:string'
            ),
        array('return' => 'xsd:string'),
        $miURL
    );  

    

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function saludar($nombre, $apellido){
        $msg="hola ".$nombre." ".$apellido;
        return new soapval ('return', 'xsd:string', $msg);
    }

    function getAll($hostName,  $dbName,  $user,  $password, $table){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $query = $cn->query("SELECT * FROM ".$table);
        $data = [];
        while ($row = mysqli_fetch_array($query,MYSQLI_ASSOC)) {
            $data[] = $row ;
        }
        return json_encode($data);
    }

    function getById($hostName,  $dbName,  $user,  $password, $table, $id){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $query = $cn->query("SELECT * FROM ".$table." WHERE id = ".$id);
        $data = [];
        while ($row = mysqli_fetch_array($query,MYSQLI_ASSOC)) {
            $data[] = $row ;
        }
        return json_encode($data);
    }

    function getByEmail($hostName,  $dbName,  $user,  $password, $table, $id){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $query = $cn->query("SELECT * FROM ".$table." WHERE email = ".$email);
        $data = [];
        while ($row = mysqli_fetch_array($query,MYSQLI_ASSOC)) {
            $data[] = $row ;
        }
        return json_encode($data);
    }

    function authenticate($hostName,  $dbName,  $user,  $password, $table, $field, $passwordField,$fieldVal,$passwordVal){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $queryField = $cn->query("SELECT ".$field." FROM ".$table." WHERE ".$field." = ".$fieldVal);
        $cn2 = mysqli_connect($hostName,$user,$password,$dbName);
        $queryPass = $cn->query("SELECT ".$passwordField." FROM ".$table." WHERE ".$field." = ".$fieldVal);


        $data = '';
        while ($row = mysqli_fetch_array($queryField,MYSQLI_ASSOC)) {
            $data = $row ;
        }
        $data = json_encode($data);
        $data = json_decode($data);

        $data2 = '';
        while ($row = mysqli_fetch_array($queryPass,MYSQLI_ASSOC)) {
            $data2 = $row ;
        }

        $data2 = json_encode($data2);
        $data2 = json_decode($data2);


        if(strcmp($fieldVal,$data->email) == 0 && $dataEmail !== '')
        {
            if(strcmp($passwordVal,$data2->password) == 0 && $dataPassword !== ''){
                return 'true';
            } else{
                return 'false';
            }
        } else {
            return 'false';
        }
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if(!isset($HTTP_RAW_POST_DATA))
    {
        $HTTP_RAW_POST_DATA = file_get_contents('php://input');
    }
    $server->service($HTTP_RAW_POST_DATA);
    
?>





    