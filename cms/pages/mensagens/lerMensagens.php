<?php 
session_start();
include "../../db/connection.php";
$pdo = pdo_connect_mysql();
    
    if(!empty($_GET['id'])){
        $INSTRUCAO = $pdo->prepare('SELECT * from mensagens');
        $INSTRUCAO->execute();
        # definir o fetch mode
        $INSTRUCAO->setFetchMode(PDO::FETCH_ASSOC);
        if($INSTRUCAO->rowCount()>0){
            
            $update = $pdo->prepare('Update mensagens set estado = 1  where id=:id');
            $update->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $update->execute();
            $update->fetch(PDO::FETCH_ASSOC);
            
        }
    }
    header('Location: listarMensagens.php');
?>