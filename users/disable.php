<?php
    $projectName = explode('\\', dirname(__FILE__));
    include_once $_SERVER['DOCUMENT_ROOT']."/".$projectName[count($projectName) - 2]."/configs/configs.php";
?>
<?php
    if (empty($_SESSION['user'])) { //if para verificar se existe um usuário logado, se não existir, volta para o início, se existir ele verifica se o tempo do timeout não passou ainda
        redirect(null,null, $UrlBase."index");
    }else{
        verifySessionTimeout();
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
        $user = mysqli_fetch_assoc($select);

        $active = $user['active'] == 1 ? 0 : 1; // se o usuário estiver como 1 (ativado) ele recebe 0 (desativado)
        $msg = $user['active'] == 1 ? "des" : ""; // mesma ideia, só que para setar a mensagem correta

        $query = mysqli_query($conn, "UPDATE users SET active = $active WHERE id = {$id}");

        if ($query) {
            redirect("Usuário {$msg}ativado com sucesso!", 1, "users/index");
        }else {
            redirect("Ocorreu um erro! Por favor, tente novamente", 0, "users/index");
        }
    }
?>