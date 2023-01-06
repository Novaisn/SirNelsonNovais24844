<?php
session_start();
include "./cms/db/connection.php";
$pdo = pdo_connect_mysql();

$nome = $assunto=$email=$mensagem = "";
$nome_err = $assunto_err = $email_err = $mensagem_err="";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["nome"]))){
      $nome_err = "Please fill nome.";
    } 
   
    else{
        
        $nome = trim($_POST["nome"]);
    }
    
    if(empty(trim($_POST["assunto"]))){
        $assunto_err = "Pelase fill assunto.";     
    } 
    else{
        $assunto = trim($_POST["assunto"]);
    }
    if(empty(trim($_POST["email"]))){
      $email_err = "Pelase fill email.";     
    } 
    else{
      $email = trim($_POST["email"]);
    }
    if(empty(trim($_POST["mensagem"]))){
      $mensagem_err = "Pelase fill mensagem.";     
    } 
    else{
      $mensagem = trim($_POST["mensagem"]);
    }


    if(empty($nome_err) && empty($assunto_err) && empty($email_err) && empty($mensagem_err)){
        
        $sql = "INSERT INTO mensagens (nome, assunto, email, mensagem) VALUES (:nome, :assunto, :email,:mensagem)";
         
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":assunto", $assunto, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":mensagem", $mensagem, PDO::PARAM_STR);
            if($stmt->execute()){
                header("location: Index.php");
            } 
            else{
                echo "Ups! Try again please.";
            }

            unset($stmt);
        }
    }
    
    unset($pdo);
}

$sql = "SELECT * FROM telaprincipal where estado=1";
$stmt1 = $pdo->prepare($sql);
$stmt1->execute();
$inicio = $stmt1->fetch(PDO::FETCH_ASSOC);
$nometelaprincipal=$inicio['nome'];
$cursotelaprincipal=$inicio['curso'];
$imgtelaprincipal=$inicio['img'];
$localidadetelaprincipal=$inicio['localidade'];

$sqls = "select * from sobremim where estado=1";
$stmts = $pdo->prepare($sqls);
$stmts->execute();
$sobremim = $stmts->fetch(PDO::FETCH_ASSOC);

/*$sqlp = "select * from projetos where estado=1";
$stmtp = $pdo->prepare($sqlp);
$stmtp->execute();
$projetos = $stmtp->fetch(PDO::FETCH_ASSOC);*/

$projetos = $pdo->prepare('select * from projetos where estado=1');
$projetos->execute();

$percursoacademico = $pdo->prepare('select * from percursoacademico where estado=1');
$percursoacademico->execute();

$cerificacoes = $pdo->prepare('select * from certificacoes where estado=1');
$cerificacoes->execute();

$softSkills = $pdo->prepare('select * from softSkills where estado=1');
$softSkills->execute();

$hardskills = $pdo->prepare('select * from hardskills where estado=1');
$hardskills->execute();

$idiomas = $pdo->prepare('select * from idiomas where estado=1');
$idiomas->execute();

$contactos = $pdo->prepare('select * from contactos where estado=1');
$contactos->execute();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nelson Novais</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="Style.css">
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
  <script src="./sir.js"></script>
  <nav class="navbar navbar-expand-lg navColor fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand darkname" href="#"> Nelson Novais</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link a night" aria-current="page" href="#">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="#about">Sobre mim</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="#lprog">Projetos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link night" href="#certificacao">Certificações</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="#soft">Soft Skills</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="#idiomas">Idiomas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="#contactos">Contactos</a>
          </li>
          <?php if(isset($_SESSION["loggedin"])) { ?>
          <li class="nav-item">
            <a class="nav-link night" href="cms\pages\users\listarUsers.php">Backoffice</a>
          </li>
          <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link night" href="cms\auth\login.php">Login</a>
          </li>
          <?php } ?>
        </ul>
        <form class="d-flex formmod">
          <div class="form-check form-switch checkbox pad">
            <input class="form-check-input chepad" type="checkbox" role="switch" id="darkcheck" onclick="setDarkMode()">
            <label class="form-check-label night modpad" for="darkcheck">Modo Escuro</label>
          </div>
        </form>
      </div>
    </div>
  </nav>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
    crossorigin="anonymous"></script>
  <header id="head" class="masthead backColor text-white text-center ecraTodo">
    <div class="container d-flex align-items-center flex-column">

      <img class="img-fluid" rel="styles" id="me" src="cms/pages/inicio/upload/<?php echo $inicio['img'];?>"
        alt="Nelson Novais" />

      <h1 class="masthead-heading text-uppercase mb-0">
        <?php echo $inicio['nome'];?>
      </h1>

      <div class="divider-custom divider-light text-white">
        <div class="divider-custom-line bg-light"></div>
        <i class="fa-solid fa-code marginIcon"></i>
        <div class="divider-custom-line bg-light"></div>
      </div>

      <p id="ei_ipvc" class="masthead-subheading font-weight-light">
        <?php echo $inicio['curso'];?>
      </p>
      <p id="ei_ipvc" class="masthead-subheading font-weight-light">
        <?php echo $inicio['localidade'];?>
      </p>
    </div>
  </header>
  <section class="page-section" id="about">
    <div class="container">

      <h2 class="page-section-heading text-center text-uppercase padding">Sobre mim</h2>

      <div class="divider-custom">
        <div class="divider-custom-line linhas"></div>
        <i class="fa-solid fa-code marginIcon"></i>
        <div class="divider-custom-line linhas"></div>
      </div>

      <div class="row">
        <!--<div class="col-lg-4 ms-auto">-->
        <p class="lead">
          <?php echo $sobremim['texto'] ?>
        </p>
        <!--</div>
        <div class="col-lg-4 me-auto">
          <p class="lead">Conclui o secundário em Ciências e Tecnologias no ano de 2020, no mesmo ano em
            outubro entrei para licenciatura em engenharia Informática no IPVC.
            Nos tempos livres gosto de jogar videojogos, ver séries, filmes, música,ver e jogar de futebol,
            andar de bicicleta, etc...</p>
        </div>-->
      </div>

    </div>
  </section>


  <section class="page-section pb-3">
    <div id="lprog" class="backColor bg-gradient">
      <div>
        <h2 class="page-section-heading text-center text-uppercase padding text-white">Projetos</h2>

        <div class="divider-custom divider-light text-white">
          <div class="divider-custom-line bg-light"></div>
          <i class="fa-solid fa-code marginIcon"></i>
          <div class="divider-custom-line bg-light"></div>
        </div>
        <div class="container text-center">
          <div class="row row-cols-1 row-cols-lg-3 g-1 g-lg-3">
          <?php
          while($row = $projetos->fetch()) {
          ?>
          <div class="col">
              <a href="<?php echo $row['link'];?>" target="_blank" class=" cardLink">
                <div class="card p-3 border bg-light ">
                  <img src="assets/c.png" class="card-img-top imgCard" alt="<?php echo $row['titulo'];?>">
                  <div class="card-body  cardBottomC">
                    <h5 class="card-title text-center"><?php echo $row['titulo'];?>Projetos desenvolvidos em C</h5>
                    <p class="card-text text-center"><?php echo $row['descricao'];?></p>

                  </div>
                </div>
              </a>
            </div>
            <?php } ?>
          </div>
        </div>

      </div>
    </div>
  </section>

  <section class="percurso">
    <div id="certificacao">
      <h2 class="page-section-heading text-center text-uppercase padding">Percurso Académico e Certificações</h2>

      <div class="divider-custom divider-light">
        <div class="divider-custom-line linhas"></div>
        <i class="fa-solid fa-code marginIcon"></i>
        <div class="divider-custom-line linhas"></div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="container">

              <div class="row">
                <div class="col">
                  <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
                  <?php  while($row = $percursoacademico->fetch()) { ?>
                    <div class="timeline-step">
                      <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top"
                        data-original-title="<?php echo $row['ano']?>">
                        <div class="inner-circle"></div>
                        <p class="h6 mt-3 mb-1"><?php echo $row['ano']?></p>
                        <p class="h6 text-muted mb-0 mb-lg-0"><?php echo $row['descricao']?></p>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <?php  while($row = $cerificacoes->fetch()) { ?>
      <div class="align-items-center">
        <img src="assets/<?php echo $row['img'] ?>" id="certificado" class="rounded mx-auto d-block " alt="<?php echo $row['titulo'] ?>">
      </div>
      <?php } ?>
    </div>
  </section>
  <section class="page-section backColor bg-gradient">
    <div id="soft">
      <h2 class="page-section-heading text-center text-uppercase padding text-white">Skills</h2>

      <div class="divider-custom divider-light text-white">
        <div class="divider-custom-line bg-light"></div>
        <i class="fa-solid fa-code marginIcon"></i>
        <div class="divider-custom-line bg-light"></div>
      </div>
      <div class="container text-center skills">
        <div class="row">
          <div class="col">
            <h3 class="text-white">Soft Skills</h3>
            <ul class="list-group sombra">
              <?php while($row = $softSkills->fetch()) { ?>
              <li class="list-group-item"><?php echo $row['softskill'];?></li>
              <?php } ?>
            </ul>
          </div>

        </div>
      </div>
      <div class="container text-center skills1">
        <div class="row">
          <div class="col ">
            <h3 class="text-white">Hard Skills</h3>
            <ul class="list-group sombra">
             <?php while($row = $hardskills->fetch()) { ?>
              <li class="list-group-item"><?php echo $row['titulo'];?>
                <div class="progress">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    aria-label="Animated striped example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                    style="width: <?php echo $row['percentagem'];?>%"></div>
                </div>
              </li>
              <?php } ?>
              
            </ul>
          </div>

        </div>
      </div>
    </div>

  </section>
  <section>
    <div id="idiomas" class="padding">
      <h2 class="page-section-heading text-center text-uppercase padding">Idiomas</h2>

      <div class="divider-custom divider-light">
        <div class="divider-custom-line linhas"></div>
        <i class="fa-solid fa-code marginIcon"></i>
        <div class="divider-custom-line linhas"></div>
      </div>
      <div class="container text-center skills1">
        <div class="row">
          <div class="col">
            <ul class="list-group sombra ">
            <?php while($row = $idiomas->fetch()) { ?>
              <li class="list-group-item  backColor text-white"><?php echo $row['titulo'];?>
                <div class="progress">
                  <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar"
                    aria-label="Animated striped example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                    style="width: <?php echo $row['percentagem'];?>%"></div>
                </div>
              </li>
              <?php } ?>

            </ul>
          </div>

        </div>
      </div>
    </div>
  </section>
  <section class="page-section backColor bg-gradient pb-3">
    <div id="contactos">
      <div>
        <h2 class="page-section-heading text-center text-uppercase padding text-white">Contactos</h2>

        <div class="divider-custom divider-light text-white">
          <div class="divider-custom-line bg-light"></div>
          <i class="fa-solid fa-code marginIcon"></i>
          <div class="divider-custom-line bg-light"></div>
        </div>

      </div>

      <div class="container">
        <div class="row">

          <div class="col-md-5 bg-light meio">
            <div class="container text-center skills marginContacto">
            <?php while($row = $contactos->fetch()) { 
              if($row['tipo']==1){
              ?>
              
              <div class="row mt-1">
                <div class="col contactoCol">

                  <a href="mailto:<?php echo $row['link']; ?>">
                    <i class="<?php echo $row['icon']; ?> contactoTam"></i>

                  </a>
                  <p class="pr-4"><?php echo $row['descricao']; ?></p>
                </div>
              </div>
              <?php } 
              if($row['tipo']==0) {?>
              <div class="row mt-1">
                <div class="col contactoCol">
                  <a href="tel:<?php echo $row['link']; ?>">
                  <i class="<?php echo $row['icon']; ?> contactoTam"></i>

                  </a>
                  <p><?php echo $row['descricao']; ?>/p>
                </div>
              </div>
              <?php }
              if($row['tipo']==2) { ?>
              <div class="row mt-1">
                <div class="col contactoCol">

                  <a href="<?php echo $row['link']; ?>" target="_blank">
                    <i class="<?php echo $row['icon']; ?> contactoTam"></i>

                  </a>
                  <p><?php echo $row['descricao']; ?></p>
                </div>
              </div>
              <?php } ?>
              <?php } ?>
            </div>
          </div>
          <div class="col-md-6 bg-light meio me-auto">
            <form class="padTop" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
              enctype="multipart/form-data">
              <h4 class="pb-2">Fale Comigo</h4>
              <div class="mb-1 marg pt-1">
                <label for="InputNome" class="form-label">Nome </label>
                <input type="text" name="nome" class="form-control" id="InputNome" required>

              </div>
              <div class="mb-2 marg">
                <label for="exampleInputEmail1" class="form-label">Email </label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                  aria-describedby="emailHelp" required>

              </div>
              <div class="mb-3 marg">
                <label for="InputAssunto" class="form-label">Assunto</label>
                <input type="text" name="assunto" class="form-control" id="InputAssunto">
              </div>
              <div class="mb-3 marg">
                <label for="InputMSG" class="form-label">Mensagem</label>
                <textarea id="Msg" name="mensagem" type="text" class="form-control" id="InputMSG" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary mb-3">Enviar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

</body>

</html>