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

    $server->register('getAllPurchasesByClientId',
        array('hostName' => 'xsd:string',
                'dbName' => 'xsd:string',
                'user' => 'xsd:string',
                'password' => 'xsd:string',
                'table' => 'xsd:string',
                'userIdColumn' => 'xsd:string',
                'idUser' => 'xsd:int'
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

    $server->register('registerProduct',
        array('hostName' => 'xsd:string',
                'dbName' => 'xsd:string',
                'user' => 'xsd:string',
                'password' => 'xsd:string', 
                'name' => 'xsd:string',
                'cost' => 'xsd:int',
                'description' => 'xsd:string',
                'availability' => 'xsd:int',
                'stock' => 'xsd:int',
                'image' => 'xsd:string'
            ),
        array('return' => 'xsd:string'),
        $miURL
    );  

    $server->register('getSessionById',
        array('hostName' => 'xsd:string',
                'dbName' => 'xsd:string',
                'user' => 'xsd:string',
                'password' => 'xsd:string', 
                'id' => 'xsd:int',
                'idAdmin' => 'xsd:int'
            ),
        array('return' => 'xsd:string'),
        $miURL
    );  

    $server->register('deleteById',
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

    $server->register('deletePurchases',
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
        

    $server->register('addPurchase',
        array('hostName' => 'xsd:string',
                'dbName' => 'xsd:string',
                'user' => 'xsd:string',
                'password' => 'xsd:string', 
                'table' => 'xsd:string', 
                'idUser' => 'xsd:int',
                'idProduct' => 'xsd:int',
                'productName' => 'xsd:string', 
                'cost' => 'xsd:int',
                'image' => 'xsd:string' 
            ),
        array('return' => 'xsd:string'),
        $miURL
    );  

    $server->register('buyByUserEmail',
        array('hostName' => 'xsd:string',
                'dbName' => 'xsd:string',
                'user' => 'xsd:string',
                'password' => 'xsd:string', 
                'table' => 'xsd:string', 
                'costColumn' => 'xsd:string', 
                'idUserColumn' => 'xsd:string', 
                'idUser' => 'xsd:int',
                'userEmail' => 'xsd:string',
                'resultAlias' => 'xsd:string'
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

    function getAllPurchasesByClientId($hostName,  $dbName,  $user,  $password, $table, $userIdColumn, $idUser){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $query = $cn->query("SELECT * FROM ".$table." WHERE ".$userIdColumn."=".$idUser);
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

    function getByEmail($hostName,  $dbName,  $user,  $password, $table, $email){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $query = $cn->query("SELECT * FROM ".$table." WHERE email = '".$email."'");
        $data = [];
        while ($row = mysqli_fetch_array($query,MYSQLI_ASSOC)) {
            $data[] = $row ;
        }
        return json_encode($data);
    }

    function buyByUserEmail($hostName,  $dbName,  $user,  $password, $table, $costColumn, $idUserColumn, $idUser, $userEmail, $resultAlias){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $query = $cn->query("SELECT sum(".$costColumn.") as ".$resultAlias." from ".$table." where ".$idUserColumn."=".$idUser);
        $data = [];
        while ($row = mysqli_fetch_array($query,MYSQLI_ASSOC)) {
            $data[] = $row ;
        }
        $data = json_encode($data);
        $resultado = json_decode($data, true);

        $total = $resultado[0]['compra'];

        $to      = $userEmail;
        $subject = 'recibo de compra';
        $message = 'TeniStore le hace llegar su monto a pagar; un total de: '.$total.' pesos';
        $headers = 'From: tenistore@store.com' . "\r\n" .
            'Reply-To: tenistore@store.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    function authenticate($hostName,  $dbName,  $user,  $password, $table, $field, $passwordField,$fieldVal,$passwordVal){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $queryField = $cn->query("SELECT ".$field." FROM ".$table." WHERE ".$field." = '".$fieldVal."'");
        $cn2 = mysqli_connect($hostName,$user,$password,$dbName);
        $queryPass = $cn->query("SELECT ".$passwordField." FROM ".$table." WHERE ".$field." = '".$fieldVal."'");


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

    function registerProduct($hostName,  $dbName,  $user,  $password, $name, $cost ,$description, $availability, $stock, $image){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $query = $cn->query("INSERT INTO product(name,cost,description,availability,stock,image) VALUES('$name',$cost,'$description',$availability,$stock,'$image');");
        mysqli_fetch_array($query,MYSQLI_ASSOC);
        return 'true';
    }

    function getSessionById($hostName,  $dbName,  $user,  $password, $id, $idAdmin){
        if($id == $idAdmin){
            return 'true';
        } else {
            return 'false';
        }
    }

    function deleteById($hostName,  $dbName,  $user,  $password, $table, $id){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $query = $cn->query("DELETE FROM ".$table." WHERE id = ".$id);
        mysqli_fetch_array($query,MYSQLI_ASSOC);
        return 'true';
    }

    function deletePurchases($hostName,  $dbName,  $user,  $password, $table, $id){
        $cn = mysqli_connect($hostName,$user,$password,$dbName);
        $query = $cn->query("DELETE FROM ".$table." WHERE idUser = ".$id);
        mysqli_fetch_array($query,MYSQLI_ASSOC);
        return 'true';
    }

    function addPurchase($hostName,  $dbName,  $user,  $password, $table, $idUser, $idProduct, $productName, $cost, $image){
        $conn = new mysqli($hostName,$user,$password,$dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO ".$table." (idUser,idProduct,name,cost,image) VALUES ('$idUser','$idProduct','$productName','$cost','$image')";
        
        if ($conn->query($sql) === TRUE) {
            return "New record created successfully";
        } else {
          return "Error: " . $sql . "<br>" . $conn->error;
        }

          $conn->close();
    }
        
        /*$data = [];
        while ($row = mysqli_fetch_array($query,MYSQLI_ASSOC)) {
            $data[] = $row ;
        }
        return json_encode($data);*/


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if(!isset($HTTP_RAW_POST_DATA))
    {
        $HTTP_RAW_POST_DATA = file_get_contents('php://input');
    }
    $server->service($HTTP_RAW_POST_DATA);
    
?>





    