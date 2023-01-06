<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../auth/login.php");
    exit;
}

function template_header($title) {
	$username  = $_SESSION["username"];

echo <<<HTML
<html>
<nav class="navbar navbar-expand-lg navColor fixed-top bg-primary">
    <div class="container-fluid ">
      <a class="navbar-brand darkname" href="#"> Nelson Novais</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
            <a class="nav-link night" href="cms\pages\listarUsers.php">Backoffice</a>
          </li>  
          <?php } else { ?>
            <li class="nav-item">
              <a class="nav-link night" href="cms\auth\login.php">Login</a>
            </li>  
          <?php } ?>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo $username ?>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="./editar.php">Editar</a></li>
            <li><a class="dropdown-item" href="..\auth\logout.php">Sair</a></li>
          </ul>
        </li>
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
  </html>
  OUTPUT;
}

?>