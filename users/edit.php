<?php
    $projectName = explode('\\', dirname(__FILE__));
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/configs/configs.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/templates/header.php";
?>
<div class="container">
    <?php
        if (!empty($_SESSION['message'])) {
            show_message(); // se tiver alguma mensagem para mostrar, será mostrada nessa parte do código
        }
        
        $types = [
            1 => "Administrador",
            2 => "Gerente",
            3 => "Usuário"
        ];

        if (empty($_GET['id'])) {
            redirect("Usuário não encontrado!", 0, $UrlBase."users/index");
        }else{
            $id = intval($_GET['id']);
            $select = mysqli_query($conn, "SELECT * FROM users WHERE id = {$_GET['id']}");
            
            if ($select->num_rows > 0){
                $user = mysqli_fetch_assoc($select);
            } else {
                redirect("Usuário não encontrado!", 0, $UrlBase."users/index");
            }
        }

        if (!empty($_POST) && isset($_POST['name'])) {
            $name = trim($_POST['name']);
            $username = trim($_POST['username']);
            if (isset($_POST['password']) && trim($_POST['password']) != "") {
                $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
            }
            $type = intval($_POST['type']);
            $now = date("Y-m-d H:i:s");

            if($name != "" && $username != "") {
                if (isset($password)) {
                    $query = mysqli_query($conn, "UPDATE users SET name = '{$name}', username = '{$username}', password = '{$password}' WHERE id = {$id}");
                } else {
                    $query = mysqli_query($conn, "UPDATE users SET name = '{$name}', username = '{$username}' WHERE id = {$id}");
                }

                if ($query) {
                    redirect("Usuário atualizado com sucesso!", 1, "users/index");
                }else {
                    message("Ocorreu um erro! Por favor, tente novamente", 0);
                }
            }
        }
    ?>
    <div class="row">
        <form class="form form-login col-6 offset-3 mt-3" method="post">
            <div class="mb-3 text-center">
                <span class="fw-bold fs-6">Editar usuário: </span>
            </div>
            <div class="mb-3 required">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" id="name" class="form-control" required value="<?= $user['name'];?>">
            </div>
            <div class="mb-3 required">
                <label for="username" class="form-label">Usuário</label>
                <input type="text" name="username" id="username" class="form-control" required value="<?= $user['username'];?>">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mb-3 required">
                <label for="type" class="form-label">Nível usuário</label>
                <select class="form-select" aria-label="Default select example" name="type" id="type" required>
                    <option selected>Selecionar</option>
                    <?php foreach ($types as $i => $type): ?>
                        <option value="<?= $i?>" <?= $i == $user['type'] ? "selected" : "";?>><?= $type?></option>
                    <?php endforeach;?>

                </select>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-success" value="Salvar">
                <a href="<?= $UrlBase. 'users/index'?>" class="btn btn-secondary">Voltar</a>
            </div>

            <?php if (!empty($_GET['id'])): ?>
                <input type="hidden" value="<?= intval($id)?>">
            <?php endif;?>
        </form>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/projetinho/templates/footer.php" ?>