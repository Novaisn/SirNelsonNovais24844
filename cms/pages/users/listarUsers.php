<?php
  session_start();

  require('../../db/connection.php');
  $pdo = pdo_connect_mysql();
  # podemos utilizar diretamente o método ->query() uma vez que, ainda, não estamos a utilizar varíaveis na instrução SQL
  $INSTRUCAO = $pdo->prepare('SELECT id, username from users WHERE id != :id');
  $INSTRUCAO->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
  $INSTRUCAO->execute();
  # definir o fetch mode
  $INSTRUCAO->setFetchMode(PDO::FETCH_ASSOC);
  $username = $_SESSION["username"];

    if($_SESSION["tipo"]==0){
        header("location: ../welcome/welcome.php");
    }

  #criar utilizador 
  $usernamenew = $passwordnew = $tiponew = $confirm_password = "";
$username_err = $password_err = $tipo_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please fill username.";
    } 
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Wrong username pattern!";
    } 
    else{
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "Username already exists!";
                } 
                else{
                    $usernamenew = trim($_POST["username"]);
                }
            } 
            else{
                echo "Ups! Try again please.";
            }

            unset($stmt);
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Pelase fill password.";     
    } 
    elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password need to be at least 6 chareters.";
    } 
    else{
        $passwordnew = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please fill confirm password.";     
    }
    else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($passwordnew != $confirm_password)){
            $confirm_password_err = "Passwords missmatch!";
        }
    }
    
        $tiponew = trim($_POST["tipo"]);
    
    
    if(empty($username_err) && empty($password_err)&& empty($tipo_err) && empty($confirm_password_err)){
        
        $sql = "INSERT INTO users (username, password, tipo) VALUES (:username, :password,:tipo)";
         
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":tipo", $param_tipo, PDO::PARAM_STR);
            $param_username = $usernamenew;
            $param_tipo = $tiponew;
            $param_password = password_hash($passwordnew, PASSWORD_DEFAULT); // Creates a password hash
            
            if($stmt->execute()){
                header("location: listarUsers.php");
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
    <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>welcome</title>
    <!-- CSS only -->
    <link rel="stylesheet" type="text/css" href="../../../Style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>
<script src="../../../sir.js"></script>
<?php require_once "../../utils/navbar.php"; ?>
<div class="container">
<div class="row mt-5 pt-5">
      <div class="col-12">
          <div class="display-4">Listar Utilizadores</div>
      </div>
    </div>
    
    <div class="row my-5">
      <div class="col-12">
        <div class="list-group">
          
          <table class='table'>
          <thead class='table-dark'>
            <tr>
                <th scope="col">Nome de Utilizadores</th>
                <th scope="col">Editar</th>
                <th scope="col">Apagar</th>
      
            </tr>
          </thead>
          <tbody>
          <?php
          if($INSTRUCAO->rowCount() > 0) {
            while($row = $INSTRUCAO->fetch()) {
                ?>
                    <?php
                    
                    echo "<tr>";
                    echo "<th>",$row['username'],"</th>";
               echo "<th>";
               ?><a href='editaruser.php?id=<?php echo $row['id'];?>'>
               <button type="button" class="btn btn-primary"><i class="fa-solid fa-square-pen"></i></button></a><?php
              echo "</th>";
              echo "<th>"; ?> <a href="apagaruser.php?id=<?php echo $row['id'];?>">
                <button type="button" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></button></a> <?php
              echo "</th>";
              echo "</tr>";
            }
          } else {
            echo "Não existem utilizadores";
          }
          ?>
          </tbody>
        </table>
        </div>
      </div>
    </div>
    </div>
    <section class="vh-100 backColor">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-7">
                    <div class="card borderRadius">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-12 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <h5 class="fw-normal mb-3 pb-3 letterSp">Novo Utilizador</h5>
                                    
                                        <!-- username input -->
                                        <div class="form-outline mb-4">
                                            <input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $usernamenew; ?>">
                                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                                            <label class="form-label" for="form3Example3">Nome de Utilizador</label>
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-outline mb-3">
                                            <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $passwordnew; ?>">
                                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                                            <label class="form-label" for="form3Example4">Palavra-Passe</label>
                                        </div>

                                        <!-- Password repeat input -->
                                        <div class="form-outline mb-3">
                                            <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                                            <label class="form-label" for="form3Example4">Confirmação de Palavra-Passe</label>
                                        </div>
                                        <select name="tipo"class="form-select form-control form-control-lg <?php echo (!empty($tipo_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tiponew; ?>" aria-label="Default select example">
                                            <option>Selecione o Tipo de utilizador</option>
                                            <option value="0">Manager</option>
                                            <option value="1">Admin</option> 
                                        </select>
                                        <div class="text-center text-lg-start mt-4 pt-2">
                                            <input type="submit" class="btn btn-primary" value="Criar">
                                        </div>
                                        <?php echo $tipo_err;?>
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
