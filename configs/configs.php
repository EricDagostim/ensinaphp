<?php
    $projectName = explode('\\', dirname(__FILE__));
    $UrlBase = "http://".$_SERVER['HTTP_HOST']."/".$projectName[count($projectName) - 2]."/"; //é só pra ter uma variável padrão, para poder usar nos lugares que tem um link absoluto

    $user = "root";
    $pass = "";
    

    
    $conn = mysqli_connect("localhost", $user, $pass, "projeto"); //conexão com o banco de dados ainda utilizando mysqli ao invés de PDO (recomendo leitura sobre)

    session_start(); // isso é para inicializar a session para podermos trabalhar com o login do usuário e as mensagens do sistema

    function message(String $message, int $type) { // serve para criar a mensagem e o tipo na session; 0 = error | 1 = success

        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }

    function show_message() { // sempre que esta função é chamada, ela mostra a mensagem que foi gerada pela function message(); para que funcione, é necessário que tenha no começo de cada bloco, uma verificação se a session onde a mensagem fica armazenada está vazia ou não, se não estiver, ele ativa essa function

        if ($_SESSION['message_type'] == 1){ // mensagem positiva / sucesso / verde
            echo "
                <div class='alert alert-success mt-3 mb-3'>{$_SESSION['message']}</div>
            ";
        }else { //mensagem negativa / erro / vermelha
            echo "
                <div class='alert alert-danger mt-3 mb-3'>{$_SESSION['message']}</div>
            ";
        }

        // após mostrar mensagem, é retirada da session
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }

    function setSessionTimeout(int $minutes) { //setar ou aumentar o tempo para ser deslogado do sistema

        $_SESSION['timeout'] = strtotime("+ {$minutes} minutes");
    }

    function verifySessionTimeout() { // verificar se o usuário logado ainda tem uma session válida pelo tempo, se não tiver, desloga o usuário e o encaminha para a página inicial

        if ($_SESSION['timeout'] < time()) {
            unset($_SESSION['user']);
            unset($_SESSION['timeout']);
            redirect("Sessão expirada!", 0, $UrlBase."index");
        }else{
            setSessionTimeout(30);
        }
    }

    function redirect($message, $message_type, $link) { // function para redirecionar após alguma ação, junto também é possível passar a mensagem e o tipo da mesma, que chama a função message()
        if ($message != null && $message_type != null)
            message($message, $message_type);

        header("Location: ".$link);
    }