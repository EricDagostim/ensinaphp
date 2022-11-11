<?php
    $projectName = explode('\\', dirname(__FILE__));
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/configs/configs.php";

    // a página de login apenas remove o login e o timeout do usuário logado e faz ele retornar para a home
    unset($_SESSION['user']);
    unset($_SESSION['timeout']);

    redirect(null, null, $UrlBase."users/index");
?>