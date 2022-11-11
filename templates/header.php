<?php
    $projectName = explode('\\', dirname(__FILE__));
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/configs/configs.php";
    /**
     * Aqui pode ser feita toda a parte de importação de arquivos externos que precisam ser visualizados pelo projeto todo, tipo bootstrap e jquery e também onde seria feito o layout do header em sí.
     */
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="<?= $UrlBase."css/style.css?".time()?>">
<header class="containder-fluid">
    <div class="col-12">
        <div class="col-12 p-2 pb-0">
            <img src="<?= $UrlBase."img/dona.jpg"?>" alt="Donatello the best AWPer of Criciúma" class="img-responsive logo">
        </div>
        <?php if(!empty($_SESSION) && isset($_SESSION['user'])): //if para verificar se existe uma session e se também existe um usuário logado, para mostrar o nome e o botão sair?>
            <div class="col-12 pb-4">
                <span><?= $_SESSION['user']['name']?></span>
            </div>
            <div class="col-12 pb-4">
                <a href="<?= $UrlBase."users/logout"?>" class="btn btn-success btn-sm btn-logout">Sair</a>
            </div>
        <?php endif; ?>
    </div>
</header>
