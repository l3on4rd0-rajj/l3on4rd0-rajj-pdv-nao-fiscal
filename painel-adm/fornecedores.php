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
            <h6 class="text-white text-capitalize ps-3">Fornecedores Cadastrados</h6>
            <a href="index.php?pagina=<?php echo $pagina ?>&funcao=novo" type="button" class="btn btn-outline-light btn-sm mb-0">Novo Cadastro</a>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">

            <?php 

            //PUXAR DADOS DO BANCO
            $query = $pdo->query("SELECT * FROM fornecedores ORDER BY id DESC");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total_reg = @count($res);
            if ($total_reg > 0) {

              ?>

              <table id="table" class="table table-hover align-items-center mb-0">

                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fornecedor</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contato</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Endereço</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>

                <tbody>

                  <?php 

                  for($i=0; $i < $total_reg; $i++){
                    foreach ($res[$i] as $key => $value)
                      {     }

                    ?>

                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm text-capitalize"><?php echo $res[$i]['nome'] ?></h6>
                            <p class="text-xs text-secondary mb-0">CNPJ: <?php echo $res[$i]['cnpj'] ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $res[$i]['telefone'] ?></p>
                        <p class="text-xs text-secondary mb-0"><?php echo $res[$i]['email'] ?></p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="badge badge-sm bg-gradient-secondary"><?php echo $res[$i]['endereco'] ?></span>
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
  $query = $pdo->query("SELECT * FROM fornecedores WHERE id = '$_GET[id]'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_reg = @count($res);
  if ($total_reg > 0) {
    $nome = $res[0]['nome'];
    $cnpj = $res[0]['cnpj'];
    $telefone = $res[0]['telefone'];
    $email = $res[0]['email'];
    $endereco = $res[0]['endereco'];
  }

} else {
  $titulo_modal = 'Inserir Registro';
}

?>



<div class="modal fade" tabindex="-1" id="modalCadastrar-fornecedor" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
        <button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" id="form-fornecedor">
        <div class="modal-body">

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm text-capitalize" style="border: 1px solid #ccc;" id="nome-fornecedor" name="nome-fornecedor" value="<?php echo @$nome ?>" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">CNPJ</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="cnpj-fornecedor" name="cnpj-fornecedor" value="<?php echo @$cnpj ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="telefone-fornecedor" name="telefone-fornecedor" value="<?php echo @$telefone ?>" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="email-fornecedor" name="email-fornecedor" value="<?php echo @$email ?>" required>
              </div>
            </div>
          </div>

          
          <div class="mb-3">
            <label class="form-label">Endereço</label>
            <textarea class="form-control px-2 py-1 border-radius-lg text-sm text-uppercase" style="border: 1px solid #ccc;" id="endereco-fornecedor" name="endereco-fornecedor" style="overflow: hidden;"><?php echo @$endereco ?></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-fornecedor" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-salvar-fornecedor" id="btn-salvar-fornecedor" type="submit" class="btn btn-primary">Salvar</button>

          <input type="hidden" name="id-fornecedor" value="<?php echo @$_GET['id'] ?>">

          <input type="hidden" name="antigo-fornecedor" value="<?php echo @$cnpj ?>">

        </div>
      </form>

    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="modalDeletar-fornecedor" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" id="form-excluir-fornecedor">
        <div class="modal-body">

          <p>Deseja realmente excluir o registro?</p>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-fornecedor" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-excluir-fornecedor" id="btn-excluir-fornecedor" type="submit" class="btn btn-danger">Excluir</button>

          <input type="hidden" name="id-fornecedor" value="<?php echo @$_GET['id'] ?>">

        </div>
      </form>

    </div>
  </div>
</div>




<!-- ABRIR MODAL CADASTRAR -->
<?php 
if (@$_GET['funcao'] == "novo") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar-fornecedor'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>


<!-- ABRIR MODAL EDITAR -->
<?php 
if (@$_GET['funcao'] == "editar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar-fornecedor'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>


<!-- ABRIR MODAL DELETAR -->
<?php 
if (@$_GET['funcao'] == "deletar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalDeletar-fornecedor'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form-fornecedor").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Salvo com Sucesso!") {

          $('#btn-fechar-fornecedor').click();
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
  $("#form-excluir-fornecedor").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/excluir.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Excluido com Sucesso!") {

          $('#btn-fechar-fornecedor').click();
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