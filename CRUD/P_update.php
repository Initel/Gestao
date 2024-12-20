<?php
include_once("./Crud.php");
?>

<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3">    
    <h1 class="text-center">Atualizar Usuário</h1>
      <form action="" method="post">
        <div class="form-group">
          <label for="email_atual" class="mt-2">Email atual:</label>
          <input type="email" id="email_atual" name="email_atual" class="form-control">
        </div>
        <div class="form-group">
          <label for="senha_atual" class="mt-2">Senha atual:</label>
          <input type="password" id="senha_atual" name="senha_atual" class="form-control">
        </div>
        <div class="form-group">
          <label for="nome" class="mt-2">Novo nome:</label>
          <input type="text" id="nome" name="nome" class="form-control">
        </div>
        <div class="form-group">
          <label for="email" class="mt-2">Novo email:</label>
          <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="form-group">
          <label for="senha" class="mt-2">Nova senha:</label>
          <input type="password" id="senha" name="senha" class="form-control">
        </div>
        <button type="submit" name="atualizar" class="btn btn-primary mt-3">Atualizar</button>
      </form>
    </div>
  </div>
</div>