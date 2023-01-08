<?php 
session_start();
include "../../db/connection.php";
$pdo = pdo_connect_mysql();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ..\..\auth\login.php");
  exit;
}
$username = $_SESSION["username"];

$INSTRUCAO = $pdo->prepare('SELECT id, titulo,descricao,link, estado  from projetos');
  
  $INSTRUCAO->execute();
  # definir o fetch mode
  $INSTRUCAO->setFetchMode(PDO::FETCH_ASSOC);




  
$titulo = $descricao = $link = $file = "";
$titulo_err = $descricao_err = $link_err = $file_err ="";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["titulo"]))){
        $titulo_err = "Please fill titulo.";
    } 
   
    else{
        $titulo = trim($_POST["titulo"]);
    }
    
    if(empty(trim($_POST["descricao"]))){
        $descricao_err = "Pelase fill descricao.";     
    } 
    else{
        $descricao = trim($_POST["descricao"]);
    }
    
    if(empty(trim($_POST["link"]))){
        $link_err = "Please fill link.";     
    }
    else{
      $link = trim($_POST["link"]);
    }
$target_dir = $_SERVER['DOCUMENT_ROOT'] .'/ApresentacaoSirNelsonNovais24844/assets/';
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
echo "ECHO".$target_file;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}


// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    $file = $_FILES["fileToUpload"]["name"];
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
  
}
    if(empty($titulo_err) && empty($descricao_err) && empty($link_err) && $uploadOk != 0){
        
        $sql = "INSERT INTO projetos (titulo, descricao, link, img) VALUES (:titulo, :descricao,:link, :img)";
         
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":titulo", $param_titulo, PDO::PARAM_STR);
            $stmt->bindParam(":descricao", $param_descricao, PDO::PARAM_STR);
            $stmt->bindParam(":link", $param_link, PDO::PARAM_STR);
            $stmt->bindParam(":img", $param_img, PDO::PARAM_STR);
            $param_titulo = $titulo;
            $param_descricao = $descricao;
            $param_link = $link;
            $param_img = $file;
            if($stmt->execute()){
                header("location: listarProj.php");
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
          <div class="display-4">Listar Projetos</div>
      </div>
    </div>
    
    <div class="row my-5">
      <div class="col-12">
        <div class="list-group">
          
          <table class='table'>
          <thead class='table-dark'>
            <tr>
                <th scope="col">Estado</th>
                <th scope="col">Projetos</th>
                <th scope="col">Editar</th>
                <th scope="col">Apagar</th>
      
            </tr>
          </thead>
          <tbody>
            <tr>
          <?php
          while($row = $INSTRUCAO->fetch()) {
          ?>
            <?php if($row['estado'] == 0){
              echo "<th>";?>
            <a href="ativarProj.php?id=<?php echo $row['id'];?>">
            <button type="button" class="btn btn-danger"><i class="fa-solid fa-circle-xmark"></i></button></a>
          <?php echo "</th>";?>
              <?php 
              echo "<th>",$row['titulo'],"</th>";?>
              <th>
              <a href="editarProj.php?id=<?php echo $row['id'];?>">
              <button type="button" class="btn btn-primary"><i class="fa-solid fa-square-pen"></i></button></a></th><th> <a href="deleteProj.php?id=<?php echo $row['id'];?>">
              <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a></th>

          <?php
          }
          ?>
          <?php if($row['estado'] == 1){ echo "<th>";?>

            <a href="DesativarProj.php?id=<?php echo $row['id'];?>"><button type="button" class="btn btn-success"><i class="fa-solid fa-circle-check"></i></button></a>
        <?php echo "</th>";?>
            <?php 
            echo "<th>",$row['titulo'],"</th>";?>
            <th>
            <a href="editarProj.php?id=<?php echo $row['id'];?>">
            <button type="button" class="btn btn-primary"><i class="fa-solid fa-square-pen"></i></button>
          </a></th><th> <a href="deleteProj.php?id=<?php echo $row['id'];?>">
            <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a></th>

        <?php
        
        }echo "</tr>";}
          ?>
          
          </tbody>
        </table>
        </div>
      </div>
    </div>

  </div>
  </section>


  <section class="vh-100 backColor">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-7">
                    <div class="card borderRadius">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-12 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                        <h5 class="fw-normal mb-3 pb-3 letterSp">Novo Projeto</h5>
                                    
                                        <!-- username input -->
                                        <div class="form-outline mb-4">
                                            <input type="text" name="titulo" class="form-control form-control-lg <?php echo (!empty($titulo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $titulo; ?>">
                                            <span class="invalid-feedback"><?php echo $titulo_err; ?></span>
                                            <label class="form-label" for="form3Example3">Titulo</label>
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-3">
                                            <input type="text" name="descricao" class="form-control form-control-lg <?php echo (!empty($descricao_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $descricao; ?>">
                                            <span class="invalid-feedback"><?php echo $descricao_err; ?></span>
                                            <label class="form-label" for="form3Example4">Descricao</label>
                                        </div>

                                        <!-- Password repeat input -->
                                        <div class="form-outline mb-3">
                                            <input type="text" name="link" class="form-control form-control-lg <?php echo (!empty($link_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $link; ?>">
                                            <span class="invalid-feedback"><?php echo $link_err; ?></span>
                                            <label class="form-label" for="form3Example4">Link</label>
                                        </div>
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