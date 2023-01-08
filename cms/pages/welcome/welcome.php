<?php 
    session_start();

    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: ..\..\auth\login.php");
        exit;
    }


    $username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>welcome</title>
    <!-- CSS only -->
    <link rel="stylesheet" type="text/css" href="../../../Style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <!-- <script src="../../../sir.js"></script> -->
    <script src="js.js"></script>
</head>
<body>
<?php require_once "../../utils/navbar.php"; ?>
<h1 class="olaUser text-center"> Olá <?php echo $username ?></h1>
<h2 class="text-center">Calculadora de Salário</h2>
<div  class="container pt-5">
        <div class="row">
          
          <div class="col-md-6 meio ">
            
                <div class="mb-3 mt-3">
                    <label for="base" class="form-label">Vencimento base</label>
                    <input type="number" class="form-control" id="base"  required>
                
                </div>
                <div class="mb-3">
                    <label for="tiporefeicao" class="form-label">Tipo de Subsídio</label>
                    <select name="tiporefeicao" class="form-select form-control form-control-lg" id="tiporefeicao" required>
                        <option value="nenhum">Nenhum</option>
                        <option value="cartao">Cartão</option>
                        <option value="dinheiro">Dinheiro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="valorSub" class="form-label">Valor do Subsídio de refeição</label>
                    <input type="number" class="form-control" id="valorSub" disabled required>
                </div>  
                <div class="mb-3">
                    <label for="dias" class="form-label">Dias de Trabalho</label>
                    <input type="number" min="1" max="31" class="form-control" id="dias" disabled required>
                </div>
                <div class="text-center text-lg-start mt-4 pt-2 mb-2">
                        <input type="submit" class="btn btn-primary" id="salarioButton" value="Criar">
                </div>
            
          </div>
          <div class="col-md-5 meio me-auto ">
            <div class="card">
                <div class="card-body">
                    Salário Bruto: <span id="salarioBruto"></span>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    Impostos: <span id="impostos"></span>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    Subsídio de Alimentação: <span id="subAlimentacao"></span>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    Descontos IRS: <span id="descIrs"></span>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    Descontos Segurança Social: <span id="descSs"></span>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    Salário líquido: <span id="salarioLiquido"></span>
                </div>
            </div>
          </div>
        </div>
      </div>
</body>
</html>
 
