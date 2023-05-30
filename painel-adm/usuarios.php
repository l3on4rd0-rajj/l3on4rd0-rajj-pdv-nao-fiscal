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
            <h6 class="text-white text-capitalize ps-3">Usuários Cadastrados</h6>
            <a href="index.php?pagina=<?php echo $pagina ?>&funcao=novo" type="button" class="btn btn-outline-light btn-sm mb-0">Novo Cadastro</a>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">

            <?php 

            //PUXAR DADOS DO BANCO
            $query = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total_reg = @count($res);
            if ($total_reg > 1) {

              ?>

              <table id="table" class="table table-hover align-items-center mb-0">

                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuário</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Login</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contato</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nível</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>

                <tbody>

                  <?php 

                  for($i=0; $i < $total_reg; $i++){
                    foreach ($res[$i] as $key => $value)
                      {     }

                    ?>

                    <?php if ( $res[$i]['login'] != "root") { ?>

                      <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div>
                              <img src="../img/<?php echo $pagina ?>/<?php echo $res[$i]['foto'] ?>" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm text-capitalize"><?php echo $res[$i]['nome'] ?></h6>
                              <p class="text-xs text-secondary mb-0">CPF: <?php echo $res[$i]['cpf'] ?></p>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0 text-uppercase"><?php echo $res[$i]['login'] ?></p>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0"><?php echo $res[$i]['telefone'] ?></p>
                          <p class="text-xs text-secondary mb-0"><?php echo $res[$i]['email'] ?></p>
                        </td>
                        <td class="align-middle text-center text-sm">
                          <span class="badge badge-sm bg-gradient-success"><?php echo $res[$i]['nivel'] ?></span>
                        </td>
                        <td class="align-middle">
                          <a href="index.php?pagina=<?php echo $pagina ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>" title="Editar Registro"><i class="fas fa-user-edit mx-3"></i></a>

                          <?php if ( $res[$i]['login'] != $login_usu ) { ?>

                            <a href="index.php?pagina=<?php echo $pagina ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>" title="Excluir Registro"><i class="fas fa-trash-alt"></i></a>

                          <?php } ?>

                        </td>
                      </tr>

                    <?php } ?>

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
  $query = $pdo->query("SELECT * FROM usuarios WHERE id = '$_GET[id]'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_reg = @count($res);
  if ($total_reg > 0) {
    $nome = $res[0]['nome'];
    $cpf = $res[0]['cpf'];
    $telefone = $res[0]['telefone'];
    $email = $res[0]['email'];
    $login = $res[0]['login'];
    $pass = $res[0]['senha'];
    $nivel = $res[0]['nivel'];
    $foto = $res[0]['foto'];
  }

} else {
  $titulo_modal = 'Inserir Registro';
}

?>



<div class="modal fade" tabindex="-1" id="modalCadastrar" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
        <button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" id="form">
        <div class="modal-body">

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nome Completo</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm text-capitalize" style="border: 1px solid #ccc;" id="nome" name="nome" value="<?php echo @$nome ?>" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">CPF</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="cpf" name="cpf" value="<?php echo @$cpf ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="telefone" name="telefone" value="<?php echo @$telefone ?>" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="email" name="email" value="<?php echo @$email ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Login</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm text-uppercase" style="border: 1px solid #ccc;" id="login" name="login" value="<?php echo @$login ?>" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="senha" name="senha" value="<?php echo @$pass ?>" required>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nível</label>
            <select class="form-select px-2 border-radius-lg text-sm" style="border: 1px solid #ccc;" aria-label="Default select example" name="nivel">

              <option <?php if(@$nivel == 'Operador'){ ?> selected <?php } ?>  value="Operador">Operador</option>

              <option <?php if(@$nivel == 'Administrador'){ ?> selected <?php } ?>  value="Administrador">Administrador</option>

              <option <?php if(@$nivel == 'Tesoureiro'){ ?> selected <?php } ?>  value="Tesoureiro">Tesoureiro</option>

            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="foto" name="foto" value="<?php echo @$foto ?>">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>

          <input type="hidden" name="id" value="<?php echo @$_GET['id'] ?>">

          <input type="hidden" name="antigo" value="<?php echo @$cpf ?>">

          <input type="hidden" name="antigo2" value="<?php echo @$login ?>">
        </div>
      </form>

    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="modalDeletar" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" id="form-excluir">
        <div class="modal-body">

          <p>Deseja realmente excluir o registro?</p>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

          <input type="hidden" name="id" value="<?php echo @$_GET['id'] ?>">

        </div>
      </form>

    </div>
  </div>
</div>



<!-- ABRIR MODAL CADASTRAR -->
<?php 
if (@$_GET['funcao'] == "novo") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>


<!-- ABRIR MODAL EDITAR -->
<?php 
if (@$_GET['funcao'] == "editar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>


<!-- ABRIR MODAL DELETAR -->
<?php 
if (@$_GET['funcao'] == "deletar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Salvo com Sucesso!") {

          $('#btn-fechar').click();
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
  $("#form-excluir").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/excluir.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Excluido com Sucesso!") {

          $('#btn-fechar').click();
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