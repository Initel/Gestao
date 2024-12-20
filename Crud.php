<?php

include_once("./connect.php");

// Função para cadastrar usuário
function cadastrar($nome, $email, $senha) {
    global $conn;
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        ?>
        <div class="alert alert-danger" role="alert">
            Erro: E-mail já cadastrado!
        </div>
        <?php
    } else {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if ($conn->query($sql) === TRUE) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário: " . $conn->error;
        }
    }
}

// Função para excluir usuário
function excluir($email, $senha) {
    global $conn;
    $sql = "SELECT id FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_usuario = $row["id"];
        if ($id_usuario == 1) {
            echo "Não é permitido excluir o usuário administrador!";
        } else {
            $sql = "DELETE FROM usuarios WHERE email = '$email' AND senha = '$senha'";
            if ($conn->query($sql) === TRUE) {
                ?>
                <div class="alert alert-success" role="alert">
                    Usuário excluído com sucesso!
                </div>
                <?php
            } else {
                echo "Erro ao excluir usuário: " . $conn->error;
            }
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
//testecorrigido@gmail.com 4321 Teste

// Função para atualizar usuário
function atualizar($email_atual, $senha_atual, $nome, $email, $senha) {
    global $conn;
    $sql = "SELECT id FROM usuarios WHERE email = '$email_atual' AND senha = '$senha_atual'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_usuario = $row["id"];
        if ($id_usuario == 1) {
            echo "Não é permitido atualizar o usuário administrador!";
        } else {
            $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senha' WHERE email = '$email_atual' AND senha = '$senha_atual'";
            if ($conn->query($sql) === TRUE) {
                echo "Usuário atualizado com sucesso!";
            } else {
                echo "Erro ao atualizar usuário: " . $conn->error;
            }
        }
    } else {
        echo "Usuário não encontrado!";
    }
}

// Função para ler usuários
function ler() {
    global $conn;
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        ?>
        <div class="container">
            <h2>Usuários</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["nome"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["senha"]; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="email" value="<?php echo $row["email"]; ?>">
                                    <input type="hidden" name="senha" value="<?php echo $row["senha"]; ?>">
                                    <button type="submit" name="excluir" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    } else {
        echo "Nenhum usuário encontrado!";
    }
}

// Formulário para cadastrar usuário
if (isset($_POST["cadastrar"])) {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    cadastrar($nome, $email, $senha);
}

// Formulário para excluir usuário
if (isset($_POST["excluir"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    excluir($email, $senha);
}

// Formulário para atualizar usuário
if (isset($_POST["atualizar"])) {
    $email_atual = $_POST["email_atual"];
    $senha_atual = $_POST["senha_atual"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    atualizar($email_atual, $senha_atual, $nome, $email, $senha);
}
?>