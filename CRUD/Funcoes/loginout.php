<?php

session_start();

include("./connect.php");

// Função para verificar o login
function verificar_login($email, $senha) {
    global $conn;
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["id"] = $row["id"];
        $_SESSION["nome"] = $row["nome"];
        $_SESSION["email"] = $row["email"];
        if ($row["id"] == 1) { // Verifica se o ID é 1 (admin)
            header("Location: homeAdmin.php");
        } else {
            header("Location: home.php");
        }
        exit;
    } else {
        echo "Erro: Email ou senha incorretos!";
    }
}

// Verificar se o formulário de login foi submetido
if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    verificar_login($email, $senha);
}


?>