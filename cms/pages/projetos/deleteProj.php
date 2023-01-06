<?php 
session_start();
include "../../db/connection.php";
$pdo = pdo_connect_mysql();
    
    if(!empty($_GET['id'])){
        $INSTRUCAO = $pdo->prepare('SELECT * from projetos where id=:id');
        $INSTRUCAO->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $INSTRUCAO->execute();
        $INSTRUCAO1 = $INSTRUCAO->fetch(PDO::FETCH_ASSOC);

        $file_pointer = $_SERVER['DOCUMENT_ROOT'] .'/ApresentacaoSirNelsonNovais24844/assets/'.$INSTRUCAO1['img'];
  
        // Use unlink() function to delete a file
            if (!unlink($file_pointer)) {
                echo ("$file_pointer cannot be deleted due to an error");

            }
            else {
                echo ("$file_pointer has been deleted");
            }
        # definir o fetch mode
        $INSTRUCAO->setFetchMode(PDO::FETCH_ASSOC);
        if($INSTRUCAO->rowCount()>0){
            $delete = $pdo->prepare('Delete from projetos where id=:id');
            $delete->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            $delete->execute();
            $delete->fetch(PDO::FETCH_ASSOC);
        }
    }
    header('Location: listarProj.php');
?>