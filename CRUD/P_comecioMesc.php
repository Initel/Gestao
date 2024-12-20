<?php
include_once("./ecommerce.php");
verificarEstoqueBaixo();
?>


<div class="container">
  <div class="row" style="margin-bottom: 20px;">
    <div class="col-md-6">
      <a type="button" class="btn btn-lg btn-primary" href="?page=compras">Compra</a>
    </div>

    <div class="col-md-6">
      <a type="button" class="btn btn-lg btn-success" href="?page=vendas">Produtos</a>
    </div>
  </div>

  <div class="accordion" id="accordionExample">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Financeiro
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <?php financeiro(); 
                  financeiro1();
            ?>
        </div>
      </div>
    </div>
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Estoque
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <?php mostrarEstoque(); ?>
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Vendas Realizadas
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <?php mostrarCompras(); ?>
        </div>
      </div>
    </div>

    <div class="col-md-6 mt-4">
      <a type="button" class="btn btn-lg btn-warning" href="?page=nota">Emitir nota</a>
    </div>

    <div class="col-md-6 mt-4">
      <a type="button" class="btn btn-lg btn-danger" href="rh.php">Recursos Humanos</a>
    </div>

  </div>
</div>