<?php
include_once("./ecommerce.php")
?>

<div class="container">
  <h2 class="text-center">Cadastro de Produto</h2>
  <form method="post" action="" class="needs-validation">
    <div class="form-group">
      <label for="produto" class="col-sm-2 col-form-label">Nome do Produto:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="produto" name="produto" required>
        <div class="invalid-feedback">Please enter a product name.</div>
      </div>
    </div>
    <div class="form-group">
      <label for="quantidade" class="col-sm-2 col-form-label">Quantidade:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="quantidade" name="quantidade" required>
        <div class="invalid-feedback">Please enter a quantity.</div>
      </div>
    </div>
    <div class="form-group">
      <label for="valor_unitario" class="col-sm-2 col-form-label">Valor Unitário:</label>
      <div class="col-sm-10">
        <input type="number" step="0.01" class="form-control" id="valor_unitario" name="valor_unitario" required>
        <div class="invalid-feedback">Please enter a unit value.</div>
      </div>
    </div>
    <button type="submit" name="cadastrar_produto" class="btn btn-primary mt-4">Cadastrar</button>
    <a type="button" class="btn btn-secondary mt-4 ml-4"  href="?page=home">Voltar</a>
  </form>
</div>