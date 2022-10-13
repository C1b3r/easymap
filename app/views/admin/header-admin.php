<?php defined('ROOT_PATH') or exit('Direct access forbidden'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="<?php echo $this->robots; ?>">
    <title><?php echo $this->title; ?></title>
    <link href="<?php echo PUBLIC_WEB_PATH.'css/styles-ref.css';?>" rel="stylesheet">
    <link href="<?php echo PUBLIC_WEB_PATH.'css/styles-root.css';?>" rel="stylesheet">
    <link href="<?php echo PUBLIC_WEB_PATH.'css/styles-ad.css';?>" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"> -->
    <link rel="icon" type="image/png" href="<?php echo PUBLIC_WEB_PATH;?>images/icons/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="<?php echo PUBLIC_WEB_PATH;?>images/icons/favicon-32x32.png" sizes="32x32">

</head>
<body class="">
<div class="flash-message-container">
  <?php Helper::getFlash(); ?>
</div>
<?php if(isset($this->message) && !empty($this->message)):?>
    <div class="alert alert-<?php echo $this->message['type']; ?> alert-dismissible fade show" role="alert">
        <?php echo $this->message['mensaje']; ?>
    </div>
<?php endif;?>
    <?php if (isset($_SESSION['id_user']) && !empty($_SESSION['id_user'])):?>
<nav class="navbar navbar-light p-3 border-bottom border-white">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand" class="logo__link" href="#">
                Admin panel
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="col-12 col-md-4 col-lg-2">
            <input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search">
        </div>
        <div class="col-12 col-md-5 col-lg-8 d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            <div class="me-1 mt-1">
              <button type="button" id="btn-dark-light-theme" class="btn btn-light" title="Tema oscuro-Tema claro">
                <i class="btn-light-theme bi bi-brightness-high"></i>
                <i class="btn-dark-theme bi bi-brightness-high-fill"></i>
               </button>
            </div>
            <div class="dropdown ms-1">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                  Hola, <?php echo $_SESSION['username']; ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="<?php echo COMPLETE_WEB_PATH_ADMIN;?>users/edit/<?php echo $_SESSION['id_user'];?>">Settings</a></li>
                  <li><a class="dropdown-item" href="#">Messages</a></li>
                  <li><a class="dropdown-item" noprefetch href="<?php echo COMPLETE_WEB_PATH_ADMIN;?>logout">Cerrar sesión</a></li>
                </ul>
             </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse border-end border-white">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                          <a class="nav-link active text__link" aria-current="page" href="<?php echo Helper::$urlGeneration->route('Adminhome');  ?>">
                            <i class="bi bi-house-door"></i>
                            <span class="ms-2">Inicio</span>
                          </a>
                        </li>
                        <li class="nav-item dropdown">
                          <a class="nav-link text__link dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-map"></i>
                            <span class="ms-2">Mapas</span>
                          </a>
                         <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                          <li><a class="dropdown-item" href="#">Crear mapa</a></li>
                          <li><a class="dropdown-item" href="#">Ver todos</a></li>
                          <li><a class="dropdown-item" href="#">Filtros</a></li>
                         </ul>
                        </li>

                       
                        <li class="nav-item">
                            <a class="btn btn-sm btn-secondary ms-3 mt-2" href="#">
                                <i class="bi bi-book"></i>
                                <span class="ms-2">Read tutorial</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-warning ms-3 mt-2" href="https://github.com/C1b3r/easymap">
                            <i class="bi bi-github"></i> Easymap github
                            </a>
                        </li>
                      </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

           <?php echo \Helper::breadcrumb(''); ?>
           
<?php endif;


                
      