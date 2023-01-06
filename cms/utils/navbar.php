<nav class="navbar navbar-expand-lg navColor fixed-top bg-primary">
    <div class="container-fluid ">
      <a class="navbar-brand darkname" href="../welcome/welcome.php"> Nelson Novais</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link a night" aria-current="page" href="../inicio/listarInicio.php">Inicio</a>
          </li>
          <?php if($_SESSION["tipo"]==1){?>
          <li class="nav-item">
            <a class="nav-link night" href="../users/listarUsers.php">Utilizadores</a>
          </li>
          <?php }?>
          <li class="nav-item">
            <a class="nav-link night" href="../projetos/listarProj.php">Projetos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="../sobremim/listarSobremim.php">Sobre mim</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="../certificacoes/listarCertificacao.php">Certificações</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="../softSkills/listarSoftSkills.php">Soft Skills</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="../hardSkills/listarHardskills.php">Hard Skills</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="../idiomas/listarIdioma.php">Idiomas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="../contactos/listarContactos.php">Contactos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="../percurso/listarPercurso.php">Percurso</a>
          </li>
          <li class="nav-item">
            <a class="nav-link night" href="../mensagens/listarMensagens.php">Mensagens</a>
          </li>
          <?php if(isset($_SESSION["loggedin"])) { ?>
          <li class="nav-item">
            <a class="nav-link night" href="..\..\..">Site</a>
          </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle night" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <?php echo $username ?>
          </a>
          <ul class="dropdown-menu">
            
            <li><a class="dropdown-item" href="../..\auth\logout.php">Sair</a></li>
          </ul>
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