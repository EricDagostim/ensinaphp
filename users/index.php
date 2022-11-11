<?php
    $projectName = explode('\\', dirname(__FILE__));
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/configs/configs.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/templates/header.php";
?>
<?php
    if (empty($_SESSION['user'])) { //if para verificar se existe um usuário logado, se não existir, volta para o início, se existir ele verifica se o tempo do timeout não passou ainda
        redirect(null,null, $UrlBase."index");
    }else{
        verifySessionTimeout();
    }
    /*
     * não foi feito paginação pq tô meio sem tempo, mas seria possível fazer a paginação dessa página, o select mudaria pq incluiria o "LIMIT X, Y" onde X é a "página", e Y é a quantidade de elementos por página, também seria preciso fazer uma lista com os números para a paginação
     */
    $query = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC;"); // select para listar todos os usuários

    $types = [
        1 => "Administrador",
        2 => "Gerente",
        3 => "Usuário"
    ];


    if (isset($_GET) && count($_GET) > 0) { //verificar se foi enviado alguma informação por GET, que no caso aqui seria a busca
        $search = trim($_GET['search']);

        $auxQuery = mysqli_query($conn, "SELECT * FROM users WHERE name like '%{$search}%' ORDER BY id DESC;"); // select feito somente no nome
        if ($auxQuery->num_rows > 0) {
            $query = $auxQuery;
        }
    }
?>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/projetinho/templates/header.php" ?>
<div class="container">
    <?php
        if (!empty($_SESSION['message'])) {
            show_message(); // se tiver alguma mensagem para mostrar, será mostrada nessa parte do código
        }
    ?>
    <div class="row  pt-3 pb-2">
        <div class="col-10">
            <h2>Listagem de usuários</h2>
        </div>
        <div class="col-2 text-end pt-1">
            <a href="<?= $UrlBase."users/add"?>" class="btn btn-sm btn-success">Adicionar</a>
        </div>
    </div>
    <div class="row">
        <form method="get" class="form col-2 offset-10">
            <div class="d-flex">
                <input type="text" name="search" placeholder="Pesquisar" class="form-control">
                <button class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered col-12">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Nível</th>
                    <th>Ativo</th>
                    <th class="th-actions">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($user = mysqli_fetch_array($query)): ?>
                    <?php
                        if ($user['active'] == 1) {
                            $typeBtnDesactivate = "btn-danger";
                            $msgBtnDesactivate = "Desativar";
                        }else {
                            $typeBtnDesactivate = "btn-success";
                            $msgBtnDesactivate = "Ativar";
                        }
                    ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $types[$user['type']]; ?></td>
                        <td><?= $user['active'] == 1 ? "Sim": "Não";// isso é um If ternário, é possível fazer um if em uma linha só se for uma condição simples ?></td>
                        <td class="td-actions">
                            <a href="<?= $UrlBase. "users/edit/{$user['id']}" ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="<?= $UrlBase. "users/view/{$user['id']}" ?>" class="btn btn-sm btn-info">Ver</a>
                            <a href="<?= $UrlBase. "users/disable/{$user['id']}" ?>" onclick="if(!confirm('Deseja excluir o usuário <?= $user['name']?>?')){return false;};" class="btn btn-sm <?= $typeBtnDesactivate?>"><?= $msgBtnDesactivate?></a>
                        </td>
                    </tr>
                <?php endwhile;?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/projetinho/templates/footer.php" ?>