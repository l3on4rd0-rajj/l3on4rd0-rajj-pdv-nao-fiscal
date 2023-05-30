<?php

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');

$listado = '';

?>

<!--  MODAL ALERTA CAIXA -->
<div class="modal fade" tabindex="-1" id="ModalAlert" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Caixa Fechado</h5>
      </div>

      <form action="index.php">

        <div class="modal-body">
          <span>Nenhum caixa aberto.</span>
          <span>É preciso abrir para acessar o PDV!</span>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Ok</button>
        </div>

      </form>

    </div>
  </div>
</div>

<?php

//VERIFICAR SE O CAIXA ESTÁ ABERTO
$query = $pdo->query("SELECT * from caixa where status = 'Aberto' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
  echo "<script>var myModal = new bootstrap.Modal(document.getElementById('ModalAlert'), {backdrop: 'static'});myModal.show();</script>";
} else {
  $nome_caixa = $res[0]['caixa'];
}

if ($desconto_porcentagem == 'SIM') {
  $desc = '%';
} else {
  $desc = 'R$';
}

?>

<style type="text/css">
  /*--------------------
Checkout
---------------------*/

  .checkout {
    margin: 0 auto;
    width: 100%;
    height: auto;
    padding: 5px;

  }

  .order {
    width: 100%;
    height: 100%;
    background-color: #eee;
  }

  /*--------------------
Payment
---------------------*/

  .payment {
    z-index: 0;
    background: #eee;

  }

  .background {
    background-color: #04053b;
    color: #FFF;
    padding: 0px 10px;
    margin-bottom: 0;
  }
</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg">
      <div class="card px-2">
        <div class="card-body">

          <?php

          if (@$_GET['funcao'] == "get") {
            $query = $pdo->query("SELECT * FROM produtos WHERE id = '$_GET[id]'");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total_reg = @count($res);
            if ($total_reg > 0) {
              $id = $res[0]['id'];
              $codigo = $res[0]['codigo'];
              $nome = $res[0]['nome'];
              $apresentacao = $res[0]['apresentacao'];
              $venda = $res[0]['venda'];

              $listado = 'SIM';
            }
          }

          ?>

          <div class='checkout'>
            <div class="row">

              <div id='payment' class='payment col-md-7 py-2'>
                <form method="post" id="form-buscar">
                  <div class="row">
                    <div class="col-md-7">
                      <p class="background">CÓDIGO</p>
                      <input type="text" class="form-control px-2 py-1 mb-2 text-sm text-uppercase bg-white" style="border: 1px solid #04053b;; border-radius: inherit;" id="codigo" name="codigo" value="<?php echo @$codigo ?>">

                      <p class="background">PRODUTO</p>
                      <input type="text" class="form-control px-2 py-1 mb-2 text-sm text-uppercase bg-white" style="border: 1px solid #04053b;; border-radius: inherit;" id="produto" name="produto" value="<?php echo @$nome ?>">

                      <p class="background">APRESENTAÇÃO</p>
                      <input type="text" class="form-control px-2 py-1 mb-2 text-sm text-uppercase bg-white" style="border: 1px solid #04053b;; border-radius: inherit;" id="apresentacao" name="apresentacao" value="<?php echo @$apresentacao ?>">

                      <hr>

                      <a class="px-4" href="" data-bs-toggle="modal" data-bs-target="#FinalizarVenda"><i class="fa-solid fa-forward-step"></i> Finalizar Venda</a>

                      <p class="mt-6">F2 - Buscar Produto / ENTER - Incluir Produto</p>

                    </div>

                    <div class="col-md-5">

                      <p class="background">QUANTIDADE</p>
                      <input type="text" class="form-control px-2 py-1 mb-2 text-sm text-uppercase bg-white" style="border: 1px solid #04053b;; border-radius: inherit;" id="quantidade" name="quantidade" placeholder="Quantidade">

                      <p class="background">VALOR UNITÁRIO  (R$)</p>
                      <input type="text" class="form-control px-2 py-1 mb-2 text-sm text-uppercase bg-white" style="border: 1px solid #04053b;; border-radius: inherit;" id="valor_unitario" name="valor_unitario" value="<?php echo @$venda ?>">

                      <p class="background">C/ DESCONTO  (R$)</p>
                      <input type="text" class="form-control px-2 py-1 mb-2 text-sm text-uppercase bg-white" style="border: 1px solid #04053b;; border-radius: inherit;" id="desconto" name="desconto">

                      <hr>

                      <div class="row">

                        <?php

                        $total_venda = 0;
                        $total_vendaF = '0,00';
                        $query_con = $pdo->query("SELECT * FROM itens_venda WHERE venda = 0 order by id desc");
                        $res = $query_con->fetchAll(PDO::FETCH_ASSOC);
                        $total_reg = @count($res);
                        if ($total_reg > 0) {
                          for ($i = 0; $i < $total_reg; $i++) {
                            foreach ($res[$i] as $key => $value) {
                            }



                            $valor_total_item = $res[$i]['valor_total'];
                            $valor_total_itemF =  number_format($valor_total_item, 2, ',', '.');

                            $total_venda += $valor_total_item;
                            $total_vendaF =  number_format($total_venda, 2, ',', '.');
                          }
                        }

                        ?>


                        <h6>Caixa - <?php echo $nome_caixa ?></h6>
                        <h4>Total da venda:</h4>
                        <h2>R$ <?php echo $total_vendaF ?></h2>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <div class="col-md-5 col-sm-12">
                <div class='order py-2 px-2'>
                  <p class="background">ITENS DA VENDA</p>
                  <table class="w-100">

                    <thead>
                      <tr>
                        <th style="width: 10%; text-align: center;">QTD.</th>
                        <th style="width: 50%;">PRODUTO</th>
                        <th style="width: 20%; text-align: center;">UNITÁRIO</th>
                        <th style="width: 20%; text-align: center;">TOTAL</th>
                      </tr>
                    </thead>

                    <tbody id='listar'>

                    </tbody>

                  </table>
                </div>
              </div>

            </div>
          </div>





        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="buscarProduto" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buscar Produto</h5>
        <button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body min-height-400 max-height-400" style="overflow: scroll;">

        <div class="w-100">
          <input type="text" class="w-100 border-radius-lg px-2 text-uppercase" style="border: 1px solid #ccc;" name="busca" id="busca" autofocus>
        </div>

        <table id="table" class="table align-items-center mt-3 table-striped table-hover">

          <thead>
            <tr>
              <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;"></th>
              <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Código</th>
              <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Nome</th>
              <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Apresentação</th>
              <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Estoque</th>
              <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Categoria</th>
              <th class="text-uppercase text-xs font-weight-bolder text-dark" style="border: 1px solid #ccc;">Fabricante</th>
            </tr>
          </thead>

          <tbody id="result"></tbody>

        </table>

      </div>
    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="modalDeletar">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="form-excluir">
        <div class="modal-body">

          <p>Deseja exluir este item da venda?</p>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
          <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Sim</button>

          <input name="id" type="hidden" id="id_deletar_item">

        </div>
      </form>
    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="FinalizarVenda" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Finalizar Venda</h5>
        <button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
      </div>


      <form method="post" id="form-finalizar">


        <div class="modal-body">

        <h6>Total da Venda: R$ <?php echo $total_vendaF ?></h6>

        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Selecione um cliente</label>
          <select class="form-select px-2 border-radius-lg text-sm" style="border: 1px solid #ccc;" aria-label="Default select example" name="cliente" id="cliente">

            <?php
            $query_c = $pdo->query("SELECT * from clientes order by nome asc");
            $res_c = $query_c->fetchAll(PDO::FETCH_ASSOC);
            $total_reg_c = @count($res_c);
            if ($total_reg_c > 0) {

              for ($i = 0; $i < $total_reg_c; $i++) {
                foreach ($res_c[$i] as $key => $value) {
                }
            ?>

                <option value="<?php echo $res_c[$i]['id'] ?>"><?php echo $res_c[$i]['nome'] ?> - <?php echo $res_c[$i]['doc'] ?></option>

            <?php }
            } else {
              echo '<option value="">Cadastre um cliente</option>';
            } ?>

          </select>
        </div>

        <div class="mb-3">
          <label for="exampleFormControlInput1" class="form-label">Selecione uma forma de pagamento</label>
          <select class="form-select px-2 border-radius-lg text-sm" style="border: 1px solid #ccc;" aria-label="Default select example" name="forma_pgto" id="forma_pgto">

            <?php
            $query = $pdo->query("SELECT * from forma_pgtos order by id asc");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total_reg = @count($res);
            if ($total_reg > 0) {

              for ($i = 0; $i < $total_reg; $i++) {
                foreach ($res[$i] as $key => $value) {
                }
            ?>

                <option value="<?php echo $res[$i]['codigo'] ?>"><?php echo $res[$i]['nome'] ?></option>

            <?php }
            } else {
              echo '<option value="">Cadastre uma Forma de Pagamento</option>';
            } ?>

          </select>
        </div>



    </div>

    <div class="modal-footer">
      <button type="button" id="btn-fechar-final" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      <button name="btn-final" id="btn-final" type="submit" class="btn btn-primary">Finalizar</button>
    </div>


    </form>

  </div>
</div>
</div>



<script type="text/javascript">
  $(document).ready(function() {
    listarProdutos();
    document.getElementById('quantidade').value = '1';

    var listado = "<?= $listado ?>";

    if (listado == 'SIM') {
      document.getElementById('quantidade').focus();
    } else {
      document.getElementById('codigo').focus();
    }


  });
</script>


<script type="text/javascript">
  var pag = "<?= $pagina ?>";

  function buscarDados() {
    $.ajax({
      url: pag + "/buscar-dados.php",
      method: 'POST',
      data: $('#form-buscar').serialize(),
      dataType: "html",

      success: function(mensagem) {

        if (mensagem.trim() != "Produto não cadastrado!") {

          window.location = 'index.php?pagina=pdv&funcao=get&id=' + mensagem;

        } else {
          $.notify(mensagem);
        }
      }
    });
  }
</script>



<script type="text/javascript">
  var pag = "<?= $pagina ?>";

  function incluirProduto() {
    $.ajax({
      url: pag + "/incluir-produto.php",
      method: 'POST',
      data: $('#form-buscar').serialize(),
      dataType: "html",

      success: function(mensagem) {

        if (mensagem.trim() == "") {

          window.location = 'index.php?pagina=pdv';

        } else {
          $.notify(mensagem);
        }
      }
    });
  }
</script>




<!--AJAX PARA MOSTRAR OS PRODUTOS NA VENDA -->
<script type="text/javascript">
  var pag = "<?= $pagina ?>";

  function listarProdutos() {
    $.ajax({
      url: pag + "/listar-produtos.php",
      method: 'POST',
      data: $('#form-buscar').serialize(),
      dataType: "html",

      success: function(result) {
        $("#listar").html(result);
      }

    });
  }
</script>



<!-- EXIBIR RESULTADO DA BUSCA -->
<script type="text/javascript">
  $('#busca').keyup(function() {
    var busca = $('#busca').val();
    $.post('buscar-produto.php', {
      busca: busca
    }, function(data) {
      $('#result').html(data);
    });
  });
</script>


<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
  $("#form-excluir").submit(function() {
    var pag = "<?= $pagina ?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/excluir-item.php",
      type: 'POST',
      data: formData,

      success: function(mensagem) {

        if (mensagem.trim() == "Excluído com Sucesso!") {

          $('#btn-fechar').click();
          window.location = "index.php?pagina=pdv";

        } else {

          $.notify(mensagem);

        }

      },

      cache: false,
      contentType: false,
      processData: false,

    });
  });
</script>


<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form-finalizar").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: "./finalizar.php",
      type: 'POST',
      data: formData,

      success:function(result){

        var array = result.split("&-/z");

        if(array[0] === "Venda Salva!"){
          
          $('#btn-fechar-venda').click();
          
          urlComprovante = "comprovante_class.php?id=" + array[1];
          window.open(urlComprovante, '_blank');
          window.location = "./index.php?pagina=pdv";
          return;

        } else {

          $.notify( result, "error" );

        }
      },

      cache: false,
      contentType: false,
      processData: false,
            xhr: function () {  // Custom XMLHttpRequest
              var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                  myXhr.upload.addEventListener('progress', function () {
                    /* faz alguma coisa durante o progresso do upload */
                  }, false);
                }
                return myXhr;
              }
            });
  });
</script>



<script type="text/javascript">
  function modalExcluir(id) {
    event.preventDefault();

    document.getElementById('id_deletar_item').value = id;


    var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {

    })

    myModal.show();
  }
</script>



<!-- ATALHOS DO TECLADO -->
<script type="text/javascript">
  document.body.addEventListener('keydown', function(event) {
    const KeyCode = event.keyCode;

    // BUSCAR PRODUTO PELA MODAL
    if (KeyCode == 113) {
      var myModal = new bootstrap.Modal(document.getElementById('buscarProduto'), {
        backdrop: 'static'
      });
      myModal.show();
    }

    // INSERIR PRODUTO NA VENDA
    if (KeyCode == 13) {
      incluirProduto();
    }

  });
</script>