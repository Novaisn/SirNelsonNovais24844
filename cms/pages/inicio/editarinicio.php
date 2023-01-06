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
    $sql = "SELECT * FROM telaprincipal WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $inicio = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirect to the list of users
    header('Location: listarInicio.php');
    exit();
}

// If the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # criar uma mensagem de erro
    $nome_err = $curso_err = $localidade_err = "";
    
    // Check if the username that was submitted, is already taken by another user
    
    
    
        // If after all validations, there are no errors
        // We are ready to update the user
        if(empty($nome_err)) {
            
            $sql = "UPDATE telaprincipal SET nome=:nome, curso=:curso, localidade=:localidade WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $_POST['nome'], PDO::PARAM_STR);
            $stmt->bindParam(':curso', $_POST['curso'], PDO::PARAM_STR);
            $stmt->bindParam(':localidade', $_POST['localidade'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            
            // If the query was executed successfully
            if($stmt->execute()) {
                // Redirect to the list of users
                header('Location: listarInicio.php');
                exit();
            } else {
                die("Something went wrong. Please try again later.");
            }
        } else {
            die("Error: $username_err");
        }
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar</title>
    <!-- CSS only -->
    <link rel="stylesheet" type="text/css" href="../../Style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
<script src="../../../sir.js"></script> 
<?php require_once "../../utils/navbar.php"; ?>
<section class="vh-100 backColor">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-7">
                <div class="card borderRadius">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-12 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <button onclick="window.location.href='listarInicio.php'" class="btn btn-primary w-25 mb-5">
                                    Voltar
                                </button>

                                <form action="editarinicio.php?id=<?php echo $_GET['id']; ?>" method="post">
                                    <h5 class="fw-normal mb-3 pb-3 letterSp">Edit User</h5>
                                    
                                    <!-- username input -->
                                    <div class="form-outline mb-4">
                                        <input type="text" name="nome" class="form-control form-control-lg <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inicio['nome']; ?>" required>
                                        <label class="form-label" for="form3Example3">Nome</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" name="curso" class="form-control form-control-lg <?php echo (!empty($curso_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inicio['curso']; ?>" required>
                                        <label class="form-label" for="form3Example3">Curso</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" name="localidade" class="form-control form-control-lg <?php echo (!empty($localidade_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inicio['localidade']; ?>" required>
                                        <label class="form-label" for="form3Example3">Localidade</label>
                                    </div>
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