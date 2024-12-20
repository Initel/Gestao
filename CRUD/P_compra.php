<?php
include_once("./ecommerce.php")
?>

<div class="container">
  <h2 class="text-center">Realizar Compra</h2>
  <form method="post" action="" class="needs-validation">
    <div class="form-group">
      <label for="data" class="col-sm-2 col-form-label">Data:</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" id="data" name="data" required>
        <div class="invalid-feedback">Please enter a date.</div>
      </div>
    </div>
    <div class="form-group">
      <label for="produtos" class="col-sm-2 col-form-label">Produtos:</label>
      <div class="col-sm-10">
        <table id="produtos_table">
          <tr>
            <th>Produto</th>
            <th>Quantidade</th>
          </tr>
          <tr>
            <td>
              <input type="text" class="form-control" id="produto_1" name="produto" required>
              <div class="invalid-feedback">Please enter a product name.</div>
            </td>
            <td>
              <input type="number" class="form-control" id="quantidade_1" name="quantidade" required>
              <div class="invalid-feedback">Please enter a quantity.</div>
            </td>
          </tr>
        </table>
        <!-- <button type="button" class="btn btn-secondary mt-4 ml-4" id="add_produto" style="background-color: #34C759; color: #ffffff; border-color: #34C759;">Adicionar Produto</button> -->
      </div>
    </div>
    <button type="submit" name="realizar_compra" class="btn btn-primary mt-4">Realizar Compra</button>
    <a type="button" class="btn btn-secondary mt-4 ml-4" href="?page=home">Voltar</a>
  </form>
</div>

<!-- <script>
  $(document).ready(function() {
    var produto_count = 1;
    $("#add_produto").click(function() {
      produto_count++;
      $("#produtos_table").append(`
        <tr>
          <td>
            <input type="text" class="form-control" id="produto_${produto_count}" name="produto[]" required>
            <div class="invalid-feedback">Please enter a product name.</div>
          </td>
          <td>
            <input type="number" class="form-control" id="quantidade_${produto_count}" name="quantidade[]" required>
            <div class="invalid-feedback">Please enter a quantity.</div>
          </td>
        </tr>
      `);
    });
  });
</script> -->