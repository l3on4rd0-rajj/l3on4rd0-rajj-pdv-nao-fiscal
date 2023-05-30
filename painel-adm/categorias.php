<?php 

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php')

?>

<div class="container-fluid pt-4">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-4 pb-3 d-flex justify-content-between container-fluid">
            <h6 class="text-white text-capitalize ps-3">Categorias Cadastradas</h6>
            <a href="index.php?pagina=<?php echo $pagina ?>&funcao=novo" type="button" class="btn btn-outline-light btn-sm mb-0">Novo Cadastro</a>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">

            <?php 

            //PUXAR DADOS DO BANCO
            $query = $pdo->query("SELECT * FROM categorias ORDER BY id DESC");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total_reg = @count($res);
            if ($total_reg > 0) {

              ?>

              <table id="table" class="table table-hover align-items-center mb-0">

                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Categoria</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Qntd. Produtos Cadastrados</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>

                <tbody>

                  <?php 

                  for($i=0; $i < $total_reg; $i++){
                    foreach ($res[$i] as $key => $value)
                      {     }


                    $id_cat = $res[$i]['id'];
                    $query_p = $pdo->query("SELECT * from produtos where categoria = '$id_cat'");
                    $res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
                    $produtos = @count($res_p);

                    ?>

                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm text-uppercase"><?php echo $res[$i]['nome'] ?></h6>
                          </div>
                        </div>
                      </td>
                      
                      <td>
                        <p class="text-xs font-weight-bold mb-0 text-center"><?php echo $produtos ?></p>
                      </td>

                      <td class="align-middle">
                        <a href="index.php?pagina=<?php echo $pagina ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>" title="Editar Registro"><i class="fas fa-edit mx-3"></i></a>

                        <a href="index.php?pagina=<?php echo $pagina ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>" title="Excluir Registro"><i class="fas fa-trash-alt"></i></a>

                      </td>
                    </tr>

                  <?php } ?>

                </tbody>
              </table>

            <?php } else {
              echo '<p class="mx-4" >Não existem dados cadastrados para serem exibidos!</p>';
            } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 

if (@$_GET['funcao'] == "editar") {
  $titulo_modal = 'Editar Registro';
  $query = $pdo->query("SELECT * FROM categorias WHERE id = '$_GET[id]'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_reg = @count($res);
  if ($total_reg > 0) {
    $nome = $res[0]['nome'];
    $produtos = $res[0]['qtd_produtos'];
  }

} else {
  $titulo_modal = 'Inserir Registro';
}

?>



<div class="modal fade" tabindex="-1" id="modalCadastrar-categoria" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
        <button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" id="form-categoria">
        <div class="modal-body">

          <div class="row">
            <div class="mb-3">
              <label class="form-label">Nome</label>
              <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm text-uppercase" style="border: 1px solid #ccc;" id="nome-categoria" name="nome-categoria" value="<?php echo @$nome ?>" required>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-categoria" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-salvar-categoria" id="btn-salvar-categoria" type="submit" class="btn btn-primary">Salvar</button>

          <input type="hidden" name="id-categoria" value="<?php echo @$_GET['id'] ?>">

          <input type="hidden" name="antigo-categoria" value="<?php echo @$nome ?>">

        </div>
      </form>

    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="modalDeletar-categoria" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" id="form-excluir-categoria">
        <div class="modal-body">

          <p>Deseja realmente excluir o registro?</p>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-categoria" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-excluir-categoria" id="btn-excluir-categoria" type="submit" class="btn btn-danger">Excluir</button>

          <input type="hidden" name="id-categoria" value="<?php echo @$_GET['id'] ?>">

        </div>
      </form>

    </div>
  </div>
</div>




<!-- ABRIR MODAL CADASTRAR -->
<?php 
if (@$_GET['funcao'] == "novo") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar-categoria'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>


<!-- ABRIR MODAL EDITAR -->
<?php 
if (@$_GET['funcao'] == "editar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar-categoria'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>


<!-- ABRIR MODAL DELETAR -->
<?php 
if (@$_GET['funcao'] == "deletar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalDeletar-categoria'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form-categoria").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Salvo com Sucesso!") {

          $('#btn-fechar-categoria').click();
          window.location = "index.php?pagina="+pag;

        } else {

          $.notify( mensagem, "error" );

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



<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
  $("#form-excluir-categoria").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/excluir.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Excluido com Sucesso!") {

          $('#btn-fechar-categoria').click();
          window.location = "index.php?pagina="+pag;

        } else {

          $.notify( mensagem, "error" );

        }
      },

      cache: false,
      contentType: false,
      processData: false
    });
  });
</script>