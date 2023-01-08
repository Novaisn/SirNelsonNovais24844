<?php 
session_start();
include "../../db/connection.php";
$pdo = pdo_connect_mysql();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ..\..\auth\login.php");
  exit;
}
$username = $_SESSION["username"];

$INSTRUCAO = $pdo->prepare('SELECT id, nome ,email,assunto,mensagem,estado  from mensagens');
  
  $INSTRUCAO->execute();
  # definir o fetch mode
  $INSTRUCAO->setFetchMode(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">

<head>
  <title>TP de DIR</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="TP de SIR">
  <meta name="author" content="Nelson Novais">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="../../../Style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
<script src="../../../sir.js"></script>

<?php require_once "../../utils/navbar.php"; ?>
  <section>
  <div class="container">


    <div class="row mt-5 pt-5">
      <div class="col-12">
          <div class="display-4">Listar Mensagens</div>
      </div>
    </div>
    
    <div class="row my-5">
      <div class="col-12">
        <div class="list-group">
        <table class='table'>
          <thead class='table-dark'>
            <tr>
                <th scope="col">Estado</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Assunto</th>
                <th scope="col">Detalhes</th>
                <th scope="col">Apagar</th>
            </tr>
          </thead>
          <tbody>
            <tr>

          <?php
          while($row = $INSTRUCAO->fetch()) {
          ?>
            <?php if($row['estado'] == 0){?>
            
          <?php?>
              <?php 
              echo "<th>","Não Lido","</th>";
              echo "<th>",$row['nome'],"</th>";
              echo "<th>",$row['email'],"</th>";
              echo "<th>",$row['assunto'],"</th>";?><th>
              <a href="detalhesMensagens.php?id=<?php echo $row['id'];?>">
              <button  type="button" class="btn btn-primary"><i class="fa-solid fa-circle-info"></i></button></a></th>
              <th><a href="deleteMensagens.php?id=<?php echo $row['id'];?>">
              <button  type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a></th>

          <?php
          }
          ?>
          <?php if($row['estado'] == 1){?>
            
        <?php?>
            <?php  
            echo "<th>","Lido","</th>";
            echo "<th>",$row['nome'],"</th>";
            echo "<th>",$row['email'],"</th>";
            echo "<th>",$row['assunto'],"</th>";?><th>
            <a href="detalhesMensagens.php?id=<?php echo $row['id'];?>">
            <button  type="button" class="btn btn-primary"><i class="fa-solid fa-circle-info"></i></button></a></th>
            <th><a href="deleteMensagens.php?id=<?php echo $row['id'];?>">
            <button  type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a></th>

        <?php
        
        } echo "</tr>";}
          ?>
          </th>
          </tbody>
        </table>
        </div>
      </div>
    </div>

  </div>
  </section>

  

</body>

</html>