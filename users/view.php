<?php
    $projectName = explode('\\', dirname(__FILE__));
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/configs/configs.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/templates/header.php";

    if (empty($_SESSION['user'])) { //if para verificar se existe um usuário logado, se não existir, volta para o início, se existir ele verifica se o tempo do timeout não passou ainda
        redirect(null,null, $UrlBase."index");
    }else{
        verifySessionTimeout();
    }

    if (empty($_GET['id'])) {
        redirect("Usuário não encontrado!", 0, $UrlBase."users/index");
        header("Location: {$UrlBase}users/index");
    }else{
        $id = intval($_GET['id']);
        $select = mysqli_query($conn, "SELECT * FROM users WHERE id = {$_GET['id']}");
        if ($select->num_rows > 0){
            $user = mysqli_fetch_assoc($select);
        } else {
            redirect("Usuário não encontrado!", 0, $UrlBase."users/index");
        }

    }

    $types = [
        1 => "Administrador",
        2 => "Gerente",
        3 => "Usuário"
    ];
?>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/projetinho/templates/header.php" ?>
<div class="container">
    <?php
        if (!empty($_SESSION['message'])) {
            show_message(); // se tiver alguma mensagem para mostrar, será mostrada nessa parte do código
        }
    ?>
    <h2>Dados do usuário</h2>
    <div class="col-12 text-end pb-3">
        <a href="<?= $UrlBase."users/index"?>" class="btn btn-sm btn-secondary">Voltar</a>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered col-12">
                <tbody>
                    <tr>
                        <th>Id</th>
                        <td><?= $user['id']?></td>
                    </tr>
                    <tr>
                        <th>Nome</th>
                        <td><?= $user['name']?></td>
                    </tr>
                    <tr>
                        <th>Usuário</th>
                        <td><?= $user['username']?></td>
                    </tr>
                    <tr>
                        <th>Nível</th>
                        <td><?= $types[$user['type']]?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/projetinho/templates/footer.php" ?>