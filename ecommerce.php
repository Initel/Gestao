<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "estoque_compra";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {die("Erro de conexão: " . $conn->connect_error);}


function cadastrarProduto($produto, $quantidade, $valor_unitario) {
  global $conn;
  
  // Verificar se o produto já existe
  $sql = "SELECT * FROM estoque WHERE produto = '$produto'";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    // Produto já existe, atualizar quantidade e valor unitário
    $row = $result->fetch_assoc();
    $nova_quantidade = $row["quantidade"] + $quantidade;
    $sql = "UPDATE estoque SET quantidade = '$nova_quantidade', valor_unitario = '$valor_unitario' WHERE produto = '$produto'";
    if ($conn->query($sql) === TRUE) {
      $message = "Produto atualizado com sucesso!";
    } else {
      $message = "Erro ao atualizar produto: " . $conn->error;
    }
  } else {
    // Produto não existe, inserir novo produto
    $sql = "INSERT INTO estoque (produto, quantidade, valor_unitario) VALUES ('$produto', '$quantidade', '$valor_unitario')";
    if ($conn->query($sql) === TRUE) {
      $message = "Produto cadastrado com sucesso!";
    } else {
      $message = "Erro ao cadastrar produto: " . $conn->error;
    }
  }  
  // Exibir mensagem de resultado
  ?>
  <script>
    alert("<?php echo $message; ?>");
  </script>
  <?php
}

function verificarEstoqueBaixo() {
  global $conn;
  $sql = "SELECT produto FROM estoque WHERE quantidade <= 0";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $produto = $row["produto"];
      echo "<script>alert('O produto $produto está sem estoque!');</script>";
    }
  }
}

function realizarCompra($data, $produto, $quantidade) {
  global $conn;
  // $id_compra = uniqid(); // gerar um ID único para a compra
  
  // foreach ($produtos as $produto => $quantidade) {
    
  // }
  $sql = "SELECT quantidade, valor_unitario FROM estoque WHERE produto = '$produto'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $quantidade_estoque = $row["quantidade"];
      $valor_unitario = $row["valor_unitario"];
      if ($quantidade <= $quantidade_estoque) {
        $valor_total = $quantidade * $valor_unitario;
        $sql = "INSERT INTO compras (data, produto, quantidade, valor_total) VALUES ('$data', '$produto', '$quantidade', '$valor_total')";
        if ($conn->query($sql) === TRUE) {
          $sql = "UPDATE estoque SET quantidade = quantidade - '$quantidade' WHERE produto = '$produto'";
          $conn->query($sql);
        } else {
          $message = "Erro ao realizar compra: " . $conn->error;
        }
      } else {
        $message = "Quantidade de produto insuficiente no estoque!";
      }
    } else {
      $message = "Produto não encontrado no estoque!";
    }
  // Exibir mensagem de resultado
  ?>
  <script>
    alert("<?php echo $message; ?>");
  </script>
  <?php
}

function realizarCompra1($data, $produto, $quantidade) {
  global $conn;
  $sql = "SELECT quantidade, valor_unitario FROM estoque WHERE produto = '$produto'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $quantidade_estoque = $row["quantidade"];
    $valor_unitario = $row["valor_unitario"];
    if ($quantidade <= $quantidade_estoque) {
      $valor_total = $quantidade * $valor_unitario;
      $sql = "INSERT INTO compras (data, produto, quantidade, valor_total) VALUES ('$data', '$produto', '$quantidade', '$valor_total')";
      if ($conn->query($sql) === TRUE) {
        $sql = "UPDATE estoque SET quantidade = quantidade - '$quantidade' WHERE produto = '$produto'";
        $conn->query($sql);
        // echo "Compra realizada com sucesso!";
      } else {
        $message = "Erro ao realizar compra: " . $conn->error;
      }
    } else {
      $message = "Quantidade de produto insuficiente no estoque!";
    }
  } else {
    $message = "Produto não encontrado no estoque!"; ?>
    <script>
      alert("<?php echo $message; ?>");
    </script><?php
  }
}

function mostrarEstoque() {
  global $conn;
  $sql = "SELECT * FROM estoque";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    ?>
    <div class="container">
      <!-- <h2>Estoque</h2> -->
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Unitário</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($row = $result->fetch_assoc()) {
            ?>
            <tr>
              <td><?php echo $row["produto"]; ?></td>
              <td><?php echo $row["quantidade"]; ?></td>
              <td>R$ <?php echo number_format($row["valor_unitario"], 2, ',', '.'); ?></td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php
  } else {
    echo "Nenhum produto encontrado no estoque!";
  }
}

function financeiro1() {
  global $conn;
  $sql = "SELECT SUM(valor_total) AS entrada FROM compras";
  $result = $conn->query($sql);
  $entrada = $result->fetch_assoc()["entrada"];
  
  $sql = "SELECT SUM(valor_unitario * quantidade) AS saida FROM estoque";
  $result = $conn->query($sql);
  $saida = $result->fetch_assoc()["saida"];
  
  // Inclua a biblioteca do Google Charts
  echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>';
  
  // Crie o gráfico de pizza
  echo '<div id="chart_div"></div>';
  echo '<script>';
  echo 'google.charts.load("current", {packages:["corechart"]});';
  echo 'google.charts.setOnLoadCallback(drawChart);';
  echo 'function drawChart() {';
  echo '  var data = google.visualization.arrayToDataTable([';
  echo '    ["Categoria", "Valor"],';
  echo '    ["Entrada", ' . $entrada . '],';
  echo '    ["Saída", ' . $saida . ']';
  echo '  ]);';
  echo '  var options = {';
  echo '    title: "Financeiro",';
  echo '    pieHole: 0.4,';
  echo '    width: 800,';
  echo '    height: 600,';
  echo '    legend: { position: "bottom" },';
  echo '    colors: ["#3366cc", "#dc3912"]';
  echo '  };';
  echo '  var chart = new google.visualization.PieChart(document.getElementById("chart_div"));';
  echo '  chart.draw(data, options);';
  echo '}';
  echo '</script>';
}

function mostrarCompras() {
  global $conn;
  $sql = "SELECT * FROM compras";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    ?>
    <div class="container">
      <!-- <h2>Compras Realizadas</h2> -->
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Data</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Valor Total</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($row = $result->fetch_assoc()) {
            ?>
            <tr>
              <td><?php echo $row["data"]; ?></td>
              <td><?php echo $row["produto"]; ?></td>
              <td><?php echo $row["quantidade"]; ?></td>
              <td>R$ <?php echo number_format($row["valor_total"], 2, ',', '.'); ?></td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
    <?php
  } else {
    echo "Nenhuma compra realizada!";
  }
}

function financeiro() {
  global $conn;
  $sql = "SELECT SUM(valor_total) AS entrada FROM compras";
  $result = $conn->query($sql);
  $entrada = $result->fetch_assoc()["entrada"];
  
  $sql = "SELECT SUM(valor_unitario * quantidade) AS saida FROM estoque";
  $result = $conn->query($sql);
  $saida = $result->fetch_assoc()["saida"];
  
  ?>
  <div class="container">
    <!-- <h2>Financeiro</h2> -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Entrada</th>
          <th>Saída</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>R$ <?php echo number_format($entrada, 2, ',', '.'); ?></td>
          <td>R$ <?php echo number_format($saida, 2, ',', '.'); ?></td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php
}

if (isset($_POST["cadastrar_produto"])) {
  $produto = $_POST["produto"];
  $quantidade = $_POST["quantidade"];
  $valor_unitario = $_POST["valor_unitario"];
  cadastrarProduto($produto, $quantidade, $valor_unitario);
  $message = "Produto cadastrado com sucesso!";
  ?>
<script>
  alert("<?php echo $message; ?>");
</script>
<?php
}

if (isset($_POST["realizar_compra"])) {
  $data = $_POST["data"];
  $produto = $_POST["produto"];
  $quantidade = $_POST["quantidade"];
  realizarCompra($data, $produto, $quantidade);
  $message = "Compra realizada com sucesso!";
  ?>
  <script>
    alert("<?php echo $message; ?>");
  </script>
  <?php
}
?>