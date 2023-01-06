<?php 
session_start();
include "../../db/connection.php";
$pdo = pdo_connect_mysql();
    
    if(!empty($_GET['id'])){
        $INSTRUCAO = $pdo->prepare('SELECT * from sobremim');
        $INSTRUCAO->execute();
        # definir o fetch mode
        $INSTRUCAO->setFetchMode(PDO::FETCH_ASSOC);
        if($INSTRUCAO->rowCount()>0){
            $update1 = $pdo->prepare('Update sobremim set estado = 0  where estado=1');
            $update1->execute();
            $update1->fetch(PDO::FETCH_ASSOC);

            $update = $pdo->prepare('Update sobremim set estado = 1  where id=:id');
            $update->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $update->execute();
            $update->fetch(PDO::FETCH_ASSOC);
            
        }
    }
    header('Location: listarSobremim.php');
?>