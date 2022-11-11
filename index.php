<?php $projectName = explode('\\', dirname(__FILE__));
include_once $_SERVER['DOCUMENT_ROOT']."/".end($projectName)."/configs/configs.php" ?>
<?php
    if (!empty($_POST)) { // verificar se o formulário enviou os dados como POST
        $username = $_POST['username']; // pega os dados do formulário com o nome setado no atributo "name" do input
        $password = $_POST['password']; // pega os dados do formulário com o nome setado no atributo "name" do input

        $query = mysqli_query($conn, "SELECT * FROM USERS WHERE username = '{$username}'");
        if ($query->num_rows > 0) {
            $user = $query->fetch_assoc();
            if ($user['active'] == 1) {
                if (password_verify($password, $user['password'])) { //verificar se a senha informada corresponde com a salva no banco (isso já com codificação de senha)
                    $_SESSION['user'] = $user;
                    setSessionTimeout(30);
                    redirect("Usuário logado com sucesso!", 1, $UrlBase."users/index");
                }else{
                    message("Senha incorreta!", 0);
                }
            }else{
                message("Usuário desativado!", 0);
            }
        }else {
            message("Usuário não existe!", 0);
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
    <div class="row">
        <form class="form form-login col-6 offset-3 mt-3" method="post">
            <div class="mb-3 text-center">
                <span class="fw-bold fs-6">Informe seu usuário e senha: </span>
            </div>
            <div class="mb-3 required">
                <label for="username" class="form-label">Usuário</label>
                <input type="text" name="username" id="username" class="form-control" required value="<?= isset($_POST['username']) ? $_POST['username']: "";?>">
            </div>
            <div class="mb-3 required">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-success" value="Acessar">
            </div>
        </form>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/projetinho/templates/footer.php" ?>