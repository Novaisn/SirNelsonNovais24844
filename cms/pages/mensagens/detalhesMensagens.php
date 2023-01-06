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
    $sql = "SELECT * FROM mensagens WHERE id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $inicio = $stmt->fetch(PDO::FETCH_ASSOC);
    $nome=$inicio['nome'];
    $email=$inicio['email'];
    $assunto=$inicio['assunto'];
    $mensagem=$inicio['mensagem'];
} else {
    // Redirect to the list of users
    header('Location: listarMensagens.php');
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detalhes</title>
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
    <div class="container py-5 h-100 mt-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-xl-7">
                <div class="card borderRadius">
                    <div class="row g-0">
                        <div class="col-md-6 col-lg-12 d-flex align-items-center">
                            <div class="card-body p-4 p-lg-5 text-black">
                                <button onclick="window.location.href='listarMensagens.php'" class="btn btn-primary w-25 mb-5">
                                    Voltar
                                </button>

                                <form action="lerMensagens.php?id=<?php echo $_GET['id']; ?>" method="post">
                                    <h5 class="fw-normal mb-3 pb-3 letterSp">Detalhes</h5>
                                    
                                    <!-- username input -->
                                    <div class="form-outline mb-4">
                                        <label type="text" name="descricao" class="form-control form-control-lg"><?php echo $nome; ?></label>
                                        <label class="form-label" for="form3Example3">Nome</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label type="text" name="icon" class="form-control form-control-lg"><?php echo $email; ?></label>
                                        <label class="form-label" for="form3Example3">Email</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label type="text" name="link" class="form-control form-control-lg"><?php echo $assunto; ?></label>
                                        <label class="form-label" for="form3Example3">Assunto</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <label type="text" name="link" class="form-control form-control-lg"><?php echo $mensagem; ?></label>
                                        <label class="form-label" for="form3Example3">Mensagem</label>
                                    </div>
                                    
                                    <div class="text-center text-lg-start mt-4 pt-2">
                                        <input type="submit" class="btn btn-primary" value="Lido">
                                        <a href="mailto:<?php echo $email;?>">
                                        <button  type="button" class="btn btn-primary">Responder</button>
                                        </a>
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