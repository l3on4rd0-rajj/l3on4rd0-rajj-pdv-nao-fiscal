<?php

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');

?>

<div class="container-fluid pt-4">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-4 pb-3 d-flex justify-content-between container-fluid">
            <h6 class="text-white text-capitalize ps-3">Cadasatro de Produtos</h6>
            <a href="index.php?pagina=<?php echo $pagina ?>&funcao=buscar" type="button" class="btn btn-outline-light btn-sm mb-0">Buscar</a>
          </div>
        </div>

        <div class="card card-body ">
          <div class="row gx-4 mb-2">

            <?php

            $quantidade = 0;

            if (@$_GET['funcao'] == "get") {
              $query = $pdo->query("SELECT * FROM produtos WHERE id = '$_GET[id]'");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $total_reg = @count($res);
              if ($total_reg > 0) {
                $id = $res[0]['id'];
                $codigo = $res[0]['codigo'];
                $nome = $res[0]['nome'];
                $apresentacao = $res[0]['apresentacao'];
                $fabricante = $res[0]['fabricante'];
                $categoria = $res[0]['categoria'];
                $custo = $res[0]['custo'];
                $lucro = $res[0]['lucro'];
                $venda = $res[0]['venda'];
                $quantidade = $res[0]['quantidade'];

                if ($quantidade == '') {
                  $quantidade = 0;
                }

                $valor_estoque = $custo * $quantidade;
                $venda_estoque = $venda * $quantidade;

                $valor_estoqueF = number_format($valor_estoque, 2, ',', '.');
                $venda_estoqueF = number_format($venda_estoque, 2, ',', '.');

                // BUSCAR OS DADOS DOS FORNECEDORES
                $id_forn = $res[0]['fornecedor'];
                $query_f = $pdo->query("SELECT * FROM fornecedores WHERE id = '$id_forn'");
                $res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);

                $total_reg_f = @count($res_f);

                if ($total_reg_f > 0) {
                  $nome_forn = $res_f[0]['nome'];
                } else {
                  $nome_forn = 'Desconhecido';
                }
              }
            }

            ?>

            <form method="POST" id="form-produto">
              <div class="modal-body">

                <div class="row">
                  <div class="col-md-4 p-0">
                    <label class="font-weight-bold w-30">Código</label>
                    <input type="number" class="px-2 py-1 border-radius-lg w-60 text-sm" style="border: 1px solid #000;" name="codigo" id="codigo" value="<?php echo @$codigo ?>" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Produto</label>
                    <input type="text" class="px-2 py-1 border-radius-lg w-70 text-sm text-uppercase" style="border: 1px solid #000;" name="nome-produto" id="nome-produto" value="<?php echo @$nome ?>" required>
                  </div>

                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Apresentação</label>
                    <input type="text" class="px-2 py-1 border-radius-lg w-70 text-sm text-uppercase" style="border: 1px solid #000;" name="apresentacao" id="apresentacao" value="<?php echo @$apresentacao ?>" required>
                  </div>
                </div>

                <hr>

                <div class="row">
                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Fabricante</label>
                    <input type="text" class="px-2 py-1 border-radius-lg w-70 text-sm text-uppercase" style="border: 1px solid #000;" name="fabricante" id="fabricante" value="<?php echo @$fabricante ?>" required>
                  </div>

                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Preço Custo</label>
                    <input type="text" class="px-2 py-1 border-radius-lg w-30 text-sm" style="border: 1px solid #000;" name="custo" id="custo" value="<?php echo @$custo ?>" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Fornecedor</label>
                    <input type="text" class="px-2 py-1 border-radius-lg w-70 text-sm text-uppercase" style="border: 1px solid #000;" name="fornecedor" id="fornecedor" value="<?php echo @$nome_forn ?>" disabled="disabled">
                  </div>

                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Preço Venda</label>
                    <input type="text" class="px-2 py-1 border-radius-lg w-30 text-sm" style="border: 1px solid #000;" name="venda" id="venda" value="<?php echo @$venda ?>" required>
                  </div>

                </div>

                <div class="row">
                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Categoria</label>
                    <select class="px-2 py-1 border-radius-lg w-70 text-sm text-uppercase bg-light" name="categoria">

                      <?php

                      $query = $pdo->query("SELECT * FROM categorias ORDER BY nome ASC");
                      $res = $query->fetchAll(PDO::FETCH_ASSOC);
                      $total_reg = @count($res);
                      if ($total_reg > 0) {

                        for ($i = 0; $i < $total_reg; $i++) {
                          foreach ($res[$i] as $key => $value) {
                          }

                      ?>

                          <option <?php if (@$categoria == $res[$i]['id']) { ?> selected <?php } ?> value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

                      <?php }
                      } else {

                        echo '<option value="">Cadastre uma categoria</option>';
                      } ?>

                    </select>
                  </div>

                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Custo Estoque</label>
                    <input type="text" class="px-2 py-1 border-radius-lg w-30 text-sm" style="border: 1px solid #000;" name="valor-estoque" id="valor-estoque" value="R$ <?php echo @$valor_estoqueF ?>" disabled="disabled">
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Quantidade</label>
                    <input type="text" class="px-2 py-1 border-radius-lg w-30 text-sm" style="border: 1px solid #000;" name="quantidade" id="quantidade" value="<?php echo @$quantidade ?> unid." disabled="disabled">
                  </div>


                  <div class="col-md-6 p-0">
                    <label class="font-weight-bold w-20">Valor Estoque</label>
                    <input type="text" class="px-2 py-1 border-radius-lg w-30 text-sm" style="border: 1px solid #000;" name="venda-estoque" id="venda-estoque" value="R$ <?php echo @$venda_estoqueF ?>" disabled="disabled">
                  </div>

                </div>

              </div>
              <div class="modal-footer">

                <?php if (@$_GET['funcao'] == "get") { ?>

                  <a href="index.php?pagina=<?php echo $pagina ?>&funcao=deletar&id=<?php echo @$id; ?>" type="button" class="btn btn-danger">Excluir</a>

                <?php } ?>

                <button name="btn-salvar-produto" id="btn-salvar-produto" type="submit" class="btn btn-primary">Salvar</button>

                <input type="hidden" name="id-produto" value="<?php echo @$_GET['id'] ?>">

                <input type="hidden" name="antigo-produto" value="<?php echo @$codigo ?>">

              </div>
            </form>


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
          <input type="text" class="w-100 border-radius-lg px-2" style="border: 1px solid #ccc;" name="busca" id="busca" autofocus>
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



<div class="modal fade" tabindex="-1" id="modalDeletar-produto" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" id="form-excluir-produto">
        <div class="modal-body">

          <p>Deseja realmente excluir o registro?</p>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-produto" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-excluir-produto" id="btn-excluir-produto" type="submit" class="btn btn-danger">Excluir</button>

          <input type="hidden" name="id-produto" value="<?php echo @$_GET['id'] ?>">

        </div>
      </form>

    </div>
  </div>
</div>



<!-- ABRIR MODAL BUSCAR PRODUTO -->
<?php
if (@$_GET['funcao'] == "buscar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('buscarProduto'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>



<!-- ABRIR MODAL DELETAR -->
<?php
if (@$_GET['funcao'] == "deletar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalDeletar-produto'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>



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



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form-produto").submit(function() {
    var pag = "<?= $pagina ?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir.php",
      type: 'POST',
      data: formData,

      success: function(mensagem) {

        if (mensagem.trim() == "Salvo com Sucesso!") {

          $('#btn-fechar-produto').click();
          window.location = "index.php?pagina=" + pag;

        } else {

          $.notify(mensagem, "error");

        }
      },

      cache: false,
      contentType: false,
      processData: false,
      xhr: function() { // Custom XMLHttpRequest
        var myXhr = $.ajaxSettings.xhr();
        if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
          myXhr.upload.addEventListener('progress', function() {
            /* faz alguma coisa durante o progresso do upload */
          }, false);
        }
        return myXhr;
      }
    });
  });
</script>



<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
  $("#form-excluir-produto").submit(function() {
    var pag = "<?= $pagina ?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/excluir.php",
      type: 'POST',
      data: formData,

      success: function(mensagem) {

        if (mensagem.trim() == "Excluido com Sucesso!") {

          $('#btn-fechar-produto').click();
          window.location = "index.php?pagina=" + pag;

        } else {

          $.notify(mensagem, "error");

        }
      },

      cache: false,
      contentType: false,
      processData: false
    });
  });
</script>