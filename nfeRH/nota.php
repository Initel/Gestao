<?php
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'NOTA FISCAL', 0, 1, 'C');
        $this->Ln(10);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Dados do cliente
    $cliente = $_POST['cliente'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    
    // Dados dos produtos
    $produtos = $_POST['produtos'];
    $quantidades = $_POST['quantidades'];
    $valores_unit = $_POST['valores'];
    
    // Calcula os valores totais por item e total geral
    $valores_totais = array();
    $total_geral = 0;
    for($i = 0; $i < count($produtos); $i++) {
        $valores_totais[$i] = $quantidades[$i] * $valores_unit[$i];
        $total_geral += $valores_totais[$i];
    }
    
    // Cria PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    // Informações do Cliente
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Dados do Cliente:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Nome: ' . $cliente, 0, 1);
    $pdf->Cell(0, 10, 'CPF: ' . $cpf, 0, 1);
    $pdf->Cell(0, 10, 'E-mail: ' . $email, 0, 1);
    $pdf->Cell(0, 10, 'Telefone: ' . $telefone, 0, 1);
    
    // Tabela de Produtos
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(80, 10, 'Produto', 1);
    $pdf->Cell(25, 10, 'Qtd', 1);
    $pdf->Cell(40, 10, 'Valor Unit.', 1);
    $pdf->Cell(45, 10, 'Valor Total', 1);
    $pdf->Ln();
    
    $pdf->SetFont('Arial', '', 12);
    for($i = 0; $i < count($produtos); $i++) {
        $pdf->Cell(80, 10, $produtos[$i], 1);
        $pdf->Cell(25, 10, $quantidades[$i], 1);
        $pdf->Cell(40, 10, 'R$ ' . number_format($valores_unit[$i], 2, ',', '.'), 1);
        $pdf->Cell(45, 10, 'R$ ' . number_format($valores_totais[$i], 2, ',', '.'), 1);
        $pdf->Ln();
    }
    
    // Total
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(145, 10, 'Total:', 1);
    $pdf->Cell(45, 10, 'R$ ' . number_format($total_geral, 2, ',', '.'), 1);
    
    $pdf->Output('nota_fiscal.pdf', 'D');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emissão de Nota Fiscal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .produto-item {
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Emissão de Nota Fiscal</h2>
        <form method="POST" id="formNotaFiscal">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Dados do Cliente</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cliente" class="form-label">Nome do Cliente</label>
                            <input type="text" class="form-control" id="cliente" name="cliente" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" name="telefone" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Produtos</h5>
                    <div id="produtos-container">
                        <div class="produto-item">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Produto</label>
                                    <input type="text" class="form-control" name="produtos[]" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Quantidade</label>
                                    <input type="number" class="form-control" name="quantidades[]" min="1" step="1" value="1" required onchange="calcularTotal(this)">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Valor Unitário</label>
                                    <input type="number" class="form-control" name="valores[]" step="0.01" required onchange="calcularTotal(this)">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-end mb-0">
                                        <strong>Total do item: R$ </strong>
                                        <span class="total-item">0,00</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" onclick="adicionarProduto()">
                        Adicionar Produto
                    </button>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="text-end">
                        Total Geral: R$ <span id="total-geral">0,00</span>
                    </h5>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-2">Gerar Nota Fiscal</button>
            <a type="button" class="btn btn-secondary ml-5 mb-2" href="?page=home">Voltar</a>
        </form>
    </div>

    <script>
        function formatarTelefone(input) {
            let valor = input.value.replace(/\D/g, '');
            if (valor.length > 11) valor = valor.slice(0, 11);
            
            if (valor.length > 2) {
                if (valor.length > 7) {
                    valor = `(${valor.slice(0, 2)}) ${valor.slice(2, 7)}-${valor.slice(7)}`;
                } else {
                    valor = `(${valor.slice(0, 2)}) ${valor.slice(2)}`;
                }
            }
            
            input.value = valor;
        }

        function formatarCPF(input) {
            let valor = input.value.replace(/\D/g, '');
            if (valor.length > 11) valor = valor.slice(0, 11);
            
            if (valor.length > 3) {
                if (valor.length > 6) {
                    if (valor.length > 9) {
                        valor = `${valor.slice(0, 3)}.${valor.slice(3, 6)}.${valor.slice(6, 9)}-${valor.slice(9)}`;
                    } else {
                        valor = `${valor.slice(0, 3)}.${valor.slice(3, 6)}.${valor.slice(6)}`;
                    }
                } else {
                    valor = `${valor.slice(0, 3)}.${valor.slice(3)}`;
                }
            }
            
            input.value = valor;
        }

        document.getElementById('telefone').addEventListener('input', function() {
            formatarTelefone(this);
        });

        document.getElementById('cpf').addEventListener('input', function() {
            formatarCPF(this);
        });

        function calcularTotal(input) {
            const produtoItem = input.closest('.produto-item');
            const quantidade = parseFloat(produtoItem.querySelector('input[name="quantidades[]"]').value) || 0;
            const valorUnit = parseFloat(produtoItem.querySelector('input[name="valores[]"]').value) || 0;
            const totalItem = quantidade * valorUnit;
            
            produtoItem.querySelector('.total-item').textContent = totalItem.toFixed(2);
            
            calcularTotalGeral();
        }

        function calcularTotalGeral() {
            const totais = Array.from(document.querySelectorAll('.total-item'))
                .map(el => parseFloat(el.textContent) || 0);
            const totalGeral = totais.reduce((acc, curr) => acc + curr, 0);
            document.getElementById('total-geral').textContent = totalGeral.toFixed(2);
        }

        function adicionarProduto() {
            const container = document.getElementById('produtos-container');
            const novoProduto = document.createElement('div');
            novoProduto.className = 'produto-item';
            novoProduto.innerHTML = `
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Produto</label>
                        <input type="text" class="form-control" name="produtos[]" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Quantidade</label>
                        <input type="number" class="form-control" name="quantidades[]" min="1" step="1" value="1" required onchange="calcularTotal(this)">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Valor Unitário</label>
                        <input type="number" class="form-control" name="valores[]" step="0.01" required onchange="calcularTotal(this)">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-end mb-0">
                            <strong>Total do item: R$ </strong>
                            <span class="total-item">0,00</span>
                        </p>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removerProduto(this)">
                    Remover
                </button>
            `;
            container.appendChild(novoProduto);
        }

        function removerProduto(button) {
            button.closest('.produto-item').remove();
            calcularTotalGeral();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>