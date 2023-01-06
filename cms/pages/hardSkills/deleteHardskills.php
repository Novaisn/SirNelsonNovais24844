<?php 
session_start();
include "../../db/connection.php";
$pdo = pdo_connect_mysql();
    
    if(!empty($_GET['id'])){
        $INSTRUCAO = $pdo->prepare('SELECT * from hardskills');
        $INSTRUCAO->execute();
        # definir o fetch mode
        $INSTRUCAO->setFetchMode(PDO::FETCH_ASSOC);
        if($INSTRUCAO->rowCount()>0){
            $delete = $pdo->prepare('Delete from hardskills where id=:id');
            $delete->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $delete->execute();
            $delete->fetch(PDO::FETCH_ASSOC);
        }
    }
    header('Location: listarHardskills.php');
?>