<?php
include_once("./Crud.php");
?>
<!-- Formulário para cadastrar usuário -->
<div class="container">
  <h1 class="text-center">Cadastrar Usuários</h1>
  <form action="" method="post" class="form-horizontal">
    <div class="form-group">
      <label for="nome" class="col-sm-2 control-label">Nome:</label>
      <div class="col-sm-10">
        <input type="text" id="nome" name="nome" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label for="email" class="col-sm-2 control-label mt-2">Email:</label>
      <div class="col-sm-10">
        <input type="email" id="email" name="email" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <label for="senha" class="col-sm-2 control-label mt-2">Senha:</label>
      <div class="col-sm-10">
        <input type="password" id="senha" name="senha" class="form-control">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" name="cadastrar" value="Cadastrar" class="btn btn-primary mt-4">
      </div>
    </div>
  </form>
</div>