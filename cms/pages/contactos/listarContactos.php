<?php 
session_start();
include "../../db/connection.php";
$pdo = pdo_connect_mysql();

$username = $_SESSION["username"];

$INSTRUCAO = $pdo->prepare('SELECT id, link,tipo,descricao,icon,estado  from contactos');
  
  $INSTRUCAO->execute();
  # definir o fetch mode
  $INSTRUCAO->setFetchMode(PDO::FETCH_ASSOC);




  
$link = $tipo = $descricao = $icon = "";
$link_err = $tipo_err = $descricao_err = $icon_err ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["descricao"]))){
        $descricao_err = "Please fill descricao.";
    } 
   
    else{
        
        $descricao = trim($_POST["descricao"]);
    }
    
    if(empty(trim($_POST["link"]))){
        $link_err = "Pelase fill curso.";     
    } 
    else{
        $link = trim($_POST["link"]);
    }
    
    
      $tipo = trim($_POST["tipo"]);
    
    if(empty(trim($_POST["icon"]))){
      $icon_err = "Please fill icon.";     
  }
  else{
    $icon = trim($_POST["icon"]);
  }

    if(empty($descricao_err) && empty($tipo_err) && empty($link_err) && empty($icon_err)){
        
        $sql = "INSERT INTO contactos (descricao, tipo, link, icon) VALUES (:descricao, :tipo,:link, :icon)";
         
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":descricao", $param_descricao, PDO::PARAM_STR);
            $stmt->bindParam(":tipo", $param_tipo, PDO::PARAM_STR);
            $stmt->bindParam(":link", $param_link, PDO::PARAM_STR);
            $stmt->bindParam(":icon", $param_icon, PDO::PARAM_STR);
            $param_descricao = $descricao;
            $param_tipo = $tipo;
            $param_link = $link;
            $param_icon = $icon;
            if($stmt->execute()){
                header("location: listarContactos.php");
            } 
            else{
                echo "Ups! Try again please.";
            }

            unset($stmt);
        }
    }
    
    unset($pdo);
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>TP de SIR</title>
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
          <div class="display-4">Listar Contactos</div>
      </div>
    </div>
    
    <div class="row my-5">
      <div class="col-12">
        <div class="list-group">
        <table class='table'>
          <thead class='table-dark'>
            <tr>
                <th scope="col">Estado</th>
                <th scope="col">Contacto</th>
                <th scope="col">Editar</th>
                <th scope="col">Apagar</th>
      
            </tr>
          </thead>
          <tbody>
            <tr>
          <?php
          while($row = $INSTRUCAO->fetch()) {
          ?>
            <?php if($row['estado'] == 0){echo "<th>";?>
            <a href="ativarContactos.php?id=<?php echo $row['id'];?>">
            <button type="button" class="btn btn-danger"><i class="fa-solid fa-circle-xmark"></i></button></a>
          <?php echo "</th>";?>
              <?php 
              echo "<th>",$row['descricao'],"</th>";?>
              <th>
              <a href="editarContactos.php?id=<?php echo $row['id'];?>">
              <button type="button" class="btn btn-primary"><i class="fa-solid fa-square-pen"></i></button></a></th>
              <th><a href="deleteContactos.php?id=<?php echo $row['id'];?>">
              <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a></th>

          <?php
          }
          ?>
          <?php if($row['estado'] == 1){
            echo "<th>";?>
            <a href="DesativarContactos.php?id=<?php echo $row['id'];?>">
            <button type="button" class="btn btn-success"><i class="fa-solid fa-circle-check"></i></button></a>
        <?php echo "</th>";?>
            <?php 
            echo "<th>",$row['descricao'],"</th>";?><th>
            <a href="editarContactos.php?id=<?php echo $row['id'];?>">
            <button type="button" class="btn btn-primary"><i class="fa-solid fa-square-pen"></i></button>
            </a></th>
              <th><a href="deleteContactos.php?id=<?php echo $row['id'];?>">
              <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a></th>

        <?php
        
        }echo "</tr>";}
          ?>
          </th>
          </tbody>
        </table>
        </div>
      </div>
    </div>

  </div>
  </section>


  <section class="vh-100 backColor">
  <section class="vh-100 ">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-7">
                    <div class="card borderRadius">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-12 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                        <h5 class="fw-normal mb-3 pb-3 letterSp">Criar Contactos</h5>
                                    
                                        <!-- username input -->
                                        <div class="form-outline mb-4">
                                            <input type="text" name="descricao" class="form-control form-control-lg <?php echo (!empty($descricao_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $descricao; ?>">
                                            <span class="invalid-feedback"><?php echo $descricao_err; ?></span>
                                            <label class="form-label" for="form3Example3">Contacto</label>
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-3">
                                            <input type="text" name="link" class="form-control form-control-lg <?php echo (!empty($link_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $link; ?>">
                                            <span class="invalid-feedback"><?php echo $link_err; ?></span>
                                            <label class="form-label" for="form3Example4">Ligação</label>
                                        </div>

                                        <!-- Password repeat input -->
                                        <div class="form-outline mb-3">
                                            <input name="icon" class="form-control form-control-lg <?php echo (!empty($icon_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $icon; ?>">
                                            <span class="invalid-feedback"><?php echo $icon_err; ?></span>
                                            <label class="form-label" for="form3Example4">Icon</label>
                                        </div>
                                        <select name="tipo"class="form-select form-control form-control-lg <?php echo (!empty($tipo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tipo; ?>" aria-label="Default select example">
                                            <option>Selecione o Tipo</option>
                                            <option value=0>NºTelefone</option>
                                            <option value=1>Mail</option>
                                            <option value=2>Link</option> 
                                        </select>

                                        <div class="form-outline mb-3">
                                          <input type="file" name="fileToUpload" id="fileToUpload">
                                        </div>
                                        
                                        
                                        <div class="text-center text-lg-start mt-4 pt-2">
                                            <input type="submit" class="btn btn-primary" value="Criar">

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
 

</body>

</html>