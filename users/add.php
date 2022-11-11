<?php
    $projectName = explode('\\', dirname(__FILE__));
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/configs/configs.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/templates/header.php";

    if (empty($_SESSION['user'])) { //if para verificar se existe um usuário logado, se não existir, volta para o início, se existir ele verifica se o tempo do timeout não passou ainda
        redirect(null,null, $UrlBase."index");
    }else{
        verifySessionTimeout();
    }
    if (!empty($_SESSION['message'])) {
        show_message(); // se tiver alguma mensagem para mostrar, será mostrada nessa parte do código
    }

    $types = [
        1 => "Administrador",
        2 => "Gerente",
        3 => "Usuário"
    ];

    if (!empty($_POST)) {
        $name = trim($_POST['name']);
        $username = trim($_POST['username']);
        $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
        $type = intval($_POST['type']);
        $now = date("Y-m-d H:i:s");

        if($name != "" && $username != "" && $password != "") {
            $query = mysqli_query($conn, "INSERT INTO users (name, username, password, type, created_at, modified_at) VALUES ('{$name}', '{$username}', '{$password}', $type, '{$now}', '{$now}')");
            if ($query) {
                message("Usuário cadastrado com sucesso!", 1);
                header("Location: {$UrlBase}users/index");
            }else {
                message("Ocorreu um erro! Por favor, tente novamente", 0);
            }
        }
    }
?>
<div class="container">
    <div class="row">
        <form class="form form-login col-6 offset-3 mt-3" method="post">
            <div class="mb-3 text-center">
                <span class="fw-bold fs-6">Adicionar usuário: </span>
            </div>
            <div class="mb-3 required">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control" required value="<?= isset($_POST['name']) ? $_POST['name']: "";?>">
            </div>
            <div class="mb-3 required">
                <label for="username" class="form-label">Usuário</label>
                <input type="text" name="username" id="username" class="form-control" required value="<?= isset($_POST['username']) ? $_POST['username']: "";?>">
            </div>
            <div class="mb-3 required">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3 required">
                <label for="type" class="form-label">Nível usuário</label>
                <select class="form-select" aria-label="Default select example" name="type" id="type" required>
                    <option selected>Selecionar</option>
                    <?php foreach ($types as $i => $type): ?>
                        <option value="<?= $i?>"><?= $type?></option>
                    <?php endforeach;?>

                </select>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-success" value="Salvar">
                <a href="<?= $UrlBase. 'users/index'?>" class="btn btn-danger">Voltar</a>
            </div>
        </form>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/projeto/templates/footer.php" ?>