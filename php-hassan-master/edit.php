<?php

require_once("db.php");
try {
    $data  = json_decode(file_get_contents('php://input'),true);
    // $pdo_statement=$pdo_conn->prepare("update todo set title='" . $_POST[ 'title' ] . "', description='" . $_POST[ 'description' ]. "' where id=" . $_GET["id"]);
    $pdo_statement=$pdo_conn->prepare("update todo set  etat='terminated'  where id=" . $data["id"]);
    $result = $pdo_statement->execute();
} catch( PDOException $Exception ) {
    return "error";
   // throw new MyDatabaseException( $Exception->getMessage( ) , $Exception->getCode( ) );
}
return "success";