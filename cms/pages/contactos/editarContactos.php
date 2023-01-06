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
    $sql = "SELECT * FROM contactos WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $inicio = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirect to the list of users
    header('Location: listarContactos.php');
    exit();
}

// If the form has been submitted
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # criar uma mensagem de erro
    $tipo_err = $icon_err = $descricao_err = $link_err = "";
    
    // Check if the username that was submitted, is already taken by another user
    
    
    
        // If after all validations, there are no errors
        // We are ready to update the user
        if(empty($descricao_err)) {
            
            $sql = "UPDATE contactos SET tipo=:tipo, icon=:icon, descricao=:descricao, link=:link WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':tipo', $_POST['tipo'], PDO::PARAM_STR);
            $stmt->bindParam(':icon', $_POST['icon'], PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $_POST['descricao'], PDO::PARAM_STR);
            $stmt->bindParam(':link', $_POST['link'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
            
            // If the query was executed successfully
            if($stmt->execute()) {
                // Redirect to the list of users
                header('Location: listarContactos.php');
                exit();
            } else {
                die("Something went wrong. Please try again later.");
            }
        } else {
            die("Error: $descricao_err");
        }
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TP de SIR</title>
    <!-- CSS only -->
    <link rel="stylesheet" type="text/css" href="../../../Style.css">
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
                                <button onclick="window.location.href='listarContactos.php'" class="btn btn-primary w-25 mb-5">
                                    Voltar
                                </button>

                                <form action="editarContactos.php?id=<?php echo $_GET['id']; ?>" method="post">
                                    <h5 class="fw-normal mb-3 pb-3 letterSp">Editar Contacto</h5>
                                    
                                    <!-- username input -->
                                    <div class="form-outline mb-4">
                                        <input type="text" name="descricao" class="form-control form-control-lg <?php echo (!empty($descricao_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inicio['descricao']; ?>" required>
                                        <label class="form-label" for="form3Example3">Contacto</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" name="icon" class="form-control form-control-lg <?php echo (!empty($icon_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inicio['icon']; ?>" required>
                                        <label class="form-label" for="form3Example3">Icon</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" name="link" class="form-control form-control-lg <?php echo (!empty($link_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $inicio['link']; ?>" required>
                                        <label class="form-label" for="form3Example3">Ligação</label>
                                    </div>
                                    <select name="tipo"class="form-select form-control form-control-lg" aria-label="Default select example" required>
                                        <option disabled>Selecione o tipo</option>
                                        <?php
                                            
                                        for($i = 0; $i <= 2; $i++) {
                                            if($i == $user['tipo']) {
                                                if($i == 0) {
                                                    echo "<option value='$i' selected>Nº telefone</option>";
                                                } if($i == 1) {
                                                    echo "<option value='$i' selected>Mail</option>";
                                                }else{
                                                    echo "<option value='$i' selected>Link</option>";
                                                }
                                            } else {
                                                if($i == 0) {
                                                    echo "<option value='$i'>Nº telefone</option>";
                                                } if($i == 1) {
                                                    echo "<option value='$i'>Mail</option>";
                                                }else{
                                                    echo "<option value='$i'>Link</option>";
                                                }
                                            }
                                        }
                                            
                                        ?>
                                    </select>
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