<?php
include_once("./Crud.php");
?>

<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">
    <h1 class="text-center">Excluir Usuário</h1>
      <form action="" method="post">
        <div class="form-group mt-2">
          <label for="email ">Email:</label>
          <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="form-group mt-2">
          <label for="senha">Senha:</label>
          <input type="password" id="senha" name="senha" class="form-control">
        </div>
        <button type="submit" name="excluir" class="btn btn-danger mt-3">Excluir</button>
      </form>
    </div>
  </div>
</div>