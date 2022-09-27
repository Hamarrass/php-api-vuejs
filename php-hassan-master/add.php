<?php

require_once("db.php");
try {
    $data  = json_decode(file_get_contents('php://input'),true);
    $toto = json_decode($data["todo"]);
    foreach($toto as $value){
        var_dump($value->title);
        $sql = "INSERT INTO todo ( title, description ,etat ) VALUES ( :title, :description,:etat )";
        $pdo_statement = $pdo_conn->prepare( $sql );
        $result = $pdo_statement->execute( array( ':title'=>$value->title, ':description'=>$value->description,':etat'=>'active' ) );
    }
    
} catch( PDOException $Exception ) {
    return "error";
   // throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
}
return "success";
