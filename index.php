<?php
    include_once("./CRUD/Funcoes/loginout.php");
    include_once("./Crud.php")
?>

<html lang="pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #f5f5f5;
      }
      .container {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
      }
      .login-form, .cadastro-form {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        margin: 0 20px;
        height: 400px;
        max-height: 500px;
      }

      .blur {
        filter: blur(5px);
        opacity: 0.5;
        pointer-events: none;
      }
    </style>
  </head>
  <body>

    <!-- Formulário de login -->
    <div class="container">
      <div class="col-md-4 login-form" id="login-form">
        <h1 class="text-center">Login</h1>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" class="form-horizontal">
          <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email:</label>
            <div class="col-sm-10">
              <input type="email" id="email" name="email" class="form-control" placeholder="Digite seu email">
            </div>
          </div>
          <div class="form-group">
            <label for="senha" class="col-sm-2 control-label mt-2">Senha:</label>
            <div class="col-sm-10">
              <input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" name="login" value="Login" class="btn btn-primary mt-3 w-100">
            </div>
          </div>
        </form>
      </div>

      <!-- Formulário de cadastro -->
      <div class="col-md-4 cadastro-form" id="cadastro-form">
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

    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
  const container = document.querySelector(".container");
  const loginForm = document.getElementById("login-form");
  const cadastroForm = document.getElementById("cadastro-form");
  let currentForm = null;

  container.addEventListener("click", function(event) {
    if (event.target === loginForm || event.target.parentNode === loginForm) {
      toggleBlur(loginForm, cadastroForm);
    } else if (event.target === cadastroForm || event.target.parentNode === cadastroForm) {
      toggleBlur(cadastroForm, loginForm);
    }
  });

  function toggleBlur(form, otherForm) {
    if (currentForm === form) {
      form.classList.remove("blur");
      currentForm = null;
    } else {
      if (currentForm) {
        currentForm.classList.remove("blur");
      }
      form.classList.remove("blur");
      otherForm.classList.add("blur");
      currentForm = form;
    }
  }
});

  //   document.addEventListener("DOMContentLoaded", function() {
  //   const container = document.querySelector(".container");
  //   const loginForm = document.getElementById("login-form");
  //   const cadastroForm = document.getElementById("cadastro-form");

  //   container.addEventListener("click", function(event) {
  //     if (event.target === loginForm || event.target.parentNode === loginForm) {
  //       cadastroForm.classList.add("blur");
  //       loginForm.classList.remove("blur");
  //     } else if (event.target === cadastroForm || event.target.parentNode === cadastroForm) {
  //       loginForm.classList.add("blur");
  //       cadastroForm.classList.remove("blur");
  //     }
  //   });
  // });
  </script>
  </body>
</html>