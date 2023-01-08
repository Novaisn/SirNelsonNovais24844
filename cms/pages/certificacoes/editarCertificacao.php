<?php

# começar a sessão
session_start();
# conetar à base de dados
require('../../db/connection.php');
$pdo = pdo_connect_mysql();
$username = $_SESSION["username"];
// Get the id of the user to be edited
if(isset($_GET['id'])) {
    // Get all the informations about that user
    $sql = "SELECT * FROM certificacoes WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $inicio = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirect to the list of users
    header('Location: listarCertificacao.php');
    exit();
}

// If the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # criar uma mensagem de erro
    
    $titulo_err ="";
    
    
    if(empty($_FILES["fileToUpload"]["name"])){

        if(empty($$titulo_err)) {
            
            $sql = "UPDATE certificacoes SET titulo=:titulo WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':titulo', $_POST['titulo'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            
            
            
            if($stmt->execute()) {
                
                header('Location: listarCertificacao.php');
                exit();
            } else {
                die("Something went wrong. Please try again later.");
            }
        } else {
            die("Error: $titulo_err");
        }
    }else{
// Check if the username that was submitted, is already taken by another user

$file_pointer = $_SERVER['DOCUMENT_ROOT'] .'/ApresentacaoSirNelsonNovais24844/assets/'.$inicio['img'];

    // Use unlink() function to delete a file
        if (!unlink($file_pointer)) {
            echo ("$file_pointer cannot be deleted due to an error");

        }
        else {
            echo ("$file_pointer has been deleted");
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
    
        
        if(empty($$titulo_err)) {
            
            $sql = "UPDATE certificacoes SET titulo=:titulo, img=:img WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':titulo', $_POST['titulo'], PDO::PARAM_STR);
            $stmt->bindParam(':img', $file, PDO::PARAM_STR);
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            
            
            
            if($stmt->execute()) {
                
                header('Location: listarCertificacao.php');
                exit();
            } else {
                die("Something went wrong. Please try again later.");
            }
        } else {
            die("Error: $titulo_err");
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar</title>
    <!-- CSS only -->
    <link rel="stylesheet" type="text/css" href="../../../Style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
<script src="../../sir.js"></script> 
<?php require_once "../../utils/navbar.php"; ?>
<section class="vh-100 backColor">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-7">
                <div class="card borderRadius">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-12 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <button onclick="window.location.href='listarCertificacao.php'" class="btn btn-primary w-25 mb-5">
                                    Voltar
                                </button>

                                <form action="editarCertificacao.php?id=<?php echo $_GET['id']; ?>" method="post">
                                    <h5 class="fw-normal mb-3 pb-3 letterSp">Editar Certificação</h5>
                                    
                                    
                                    <div class="form-outline mb-4">
                                        <input type="text" name="titulo" class="form-control form-control-lg <?php echo (!empty($titulo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inicio['titulo']; ?>" required>
                                        <label class="form-label" for="form3Example3">Titulo</label>
                                    </div>
                                    <input class="form-control" type="file" id="fileToUpload">
                                    <div class="text-center text-lg-start mt-4 pt-2">
                                        <input type="submit" class="btn btn-primary" value="Editar">
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