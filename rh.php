<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; // seu usuário do MySQL
$password = ""; // sua senha do MySQL
$dbname = "rh"; // seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Cadastro de Funcionários
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])) {
    $nome = $_POST['nome'];
    $salario = $_POST['salario'];
    $funcao = $_POST['funcao'];
    $data_admissao = $_POST['data_admissao'];

    $sql = "INSERT INTO funcionarios (nome, salario, funcao, data_admissao) VALUES ('$nome', '$salario', '$funcao', '$data_admissao')";
    $conn->query($sql);
}

// Gerar PDF da Folha de Pagamento
if (isset($_POST['gerar_pdf'])) {
    require('fpdf/fpdf.php');
    
    $funcionario_id = $_POST['funcionario_id'];
    $result = $conn->query("SELECT * FROM funcionarios WHERE id = $funcionario_id");
    $funcionario = $result->fetch_assoc();

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Folha de Pagamento');
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'Nome: ' . $funcionario['nome']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Salario: R$ ' . number_format($funcionario['salario'], 2, ',', '.'));
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Funcao: ' . $funcionario['funcao']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Data de Admissao: ' . date('d/m/Y', strtotime($funcionario['data_admissao'])));
    
    $pdf->Output('D', 'folha_pagamento.pdf');
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Módulo de RH</title>
</head>
<body>
<div class="container mt-5">
    <h2>Cadastro de Funcionários</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="salario">Salário</label>
            <input type="number" class="form-control" id="salario" name="salario" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="funcao">Função</label>
            <input type="text" class="form-control" id="funcao" name="funcao" required>
        </div>
        <div class="form-group">
            <label for="data_admissao">Data de Admissão</label>
            <input type="date" class="form-control" id="data_admissao" name="data_admissao" required>
        </div>
        <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
    </form>

    <hr>

    <h2>Folha de Pagamento</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="funcionario_id">Selecione o Funcionário</label>
            <select class="form-control" id="funcionario_id" name="funcionario_id" required>
                <?php
                // Reabrir a conexão para listar os funcionários
                $conn = new mysqli($servername, $username, $password, $dbname);
                $result = $conn->query("SELECT * FROM funcionarios");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                $conn->close();
                ?>
            </select>
        </div>
        <button type="submit" name="gerar_pdf" class="btn btn-success">Gerar PDF</button>
        <a type="button" class="btn btn-secondary ml-5 mb-2" href="home.php">Voltar</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>