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
            <h6 class="text-white ps-3">Contas à Receber</h6>
            <a href="index.php?pagina=<?php echo $pagina ?>&funcao=novo" type="button" class="btn btn-outline-light btn-sm mb-0">Nova Conta</a>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">

            <?php 

            //PUXAR DADOS DO BANCO
            $query = $pdo->query("SELECT * FROM contas_receber ORDER BY id DESC");
            $res = $query->fetchAll(PDO::FETCH_ASSOC);
            $total_reg = @count($res);
            if ($total_reg > 0) {

              ?>

              <table id="table" class="table table-hover align-items-center mb-0">

                <thead>
                  <tr>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sintuação</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descrição</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Valor</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuário</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vencimento</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Arquivo</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                  </tr>
                </thead>

                <tbody>

                  <?php 

                  for($i=0; $i < $total_reg; $i++){
                    foreach ($res[$i] as $key => $value)
                      {     }

                    $id_usu = $res[$i]['usuario'];
                    $query_p = $pdo->query("SELECT * from usuarios where id = '$id_usu'");
                    $res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
                    $nome_usu = $res_p[0]['nome'];


                    if($res[$i]['pago'] == 'Sim'){
                      $classe = 'fas fa-circle text-success';
                    }else{
                      $classe = 'fas fa-circle text-danger';
                    }

                    $extensao = strchr($res[$i]['arquivo'], '.');
                    if($extensao == '.pdf'){
                      $arquivo_pasta = 'pdf.png';
                    }else{
                      $arquivo_pasta = $res[$i]['arquivo'];
                    }

                    ?>

                    <tr>
                      <td>
                        <div class="text-center">
                          <i class="<?php echo $classe ?>"></i>
                        </div>
                      </td>

                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0 text-uppercase"><?php echo $res[$i]['descricao'] ?></p>
                      </td>

                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0">R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></p>
                      </td>

                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?php echo $nome_usu ?></p>
                      </td>

                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?php echo implode('/', array_reverse(explode('-', $res[$i]['vencimento']))); ?></p>
                      </td>

                      <td>
                        <div class="text-center">
                          <a href="../img/<?php echo $pagina ?>/<?php echo $res[$i]['arquivo'] ?>" title="Ver Arquivo" target="_blank">
                            <img src="../img/<?php echo $pagina ?>/<?php echo $arquivo_pasta ?>" class="me-3 border-radius-lg" width="40">
                          </a>
                        </div>
                      </td>

                      <td>
                        <?php if($res[$i]['pago'] != 'Sim'){ ?>

                          <a href="index.php?pagina=<?php echo $pagina ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>" title="Editar Registro"><i class="fas fa-edit"></i></a>

                          <a href="index.php?pagina=<?php echo $pagina ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>" title="Excluir Registro"><i class="fas fa-trash-alt mx-3"></i></a>

                          <a href="index.php?pagina=<?php echo $pagina ?>&funcao=baixar&id=<?php echo $res[$i]['id'] ?>" title="Baixar Registro"><i class="fas fa-dollar-sign"></i></a>

                        <?php } ?>
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

if(@$_GET['funcao'] == "editar"){
  $titulo_modal = 'Editar Registro';
  $query = $pdo->query("SELECT * from contas_receber where id = '$_GET[id]'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_reg = @count($res);
  if($total_reg > 0){ 
    $valor = $res[0]['valor'];
    $descricao = $res[0]['descricao'];
    $arquivo = $res[0]['arquivo'];
    $vencimento = $res[0]['vencimento'];


    $extensao2 = strchr($arquivo, '.');
    if($extensao2 == '.pdf'){
      $arquivo_pasta2 = 'pdf.png';
    }else{
      $arquivo_pasta2 = $arquivo;
    }

  }
}else{
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


          <div class="mb-3">
            <label class="form-label">Descrição</label>
            <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm text-uppercase" style="border: 1px solid #ccc;"  id="descricao" name="descricao" value="<?php echo @$descricao ?>" required>
          </div> 

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Valor</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;"  id="valor" name="valor" value="<?php echo @$valor ?>" required>
              </div>  
            </div>
            

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Vencimento</label>
                <input type="date" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;"  id="vencimento" name="vencimento" value="<?php echo @$vencimento ?>" required>
              </div> 
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Arquivo</label>
            <input type="file" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="arquivo" name="arquivo" value="<?php echo @$arquivo ?>" onChange="carregarImg();">
          </div>

          <div id="divImgConta" class="mt-4">
            <?php if(@$arquivo != ""){ ?>
              <img src="../img/<?php echo $pagina ?>/<?php echo @$arquivo_pasta2 ?>"  width="200px" id="target">
            <?php  }else{ ?>
              <img src="../img/<?php echo $pagina ?>/sem-foto.jpg" width="200px" id="target">
            <?php } ?>
          </div>
          
        </div>
        
        <div class="modal-footer">
          <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>

          <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">
          
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



<div class="modal fade" tabindex="-1" id="modalBaixar" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Baixar Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="form-baixar">
        <div class="modal-body">

          <p>Deseja confirmar o recebimento desta conta?</p>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-baixar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-baixar" id="btn-baixar" type="submit" class="btn btn-primary">Sim</button>

          <input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

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



<?php 
if(@$_GET['funcao'] == "baixar"){ ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalBaixar'), {

    })
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



<!--AJAX PARA BAIXAR CONTA -->
<script type="text/javascript">
  $("#form-baixar").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/baixar.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Baixado com Sucesso!") {

          $('#btn-fechar-baixar').click();
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



<!--SCRIPT PARA CARREGAR IMAGEM -->
<script type="text/javascript">

  function carregarImg() {

    var target = document.getElementById('target');
    var file = document.querySelector("input[type=file]").files[0];

    var arquivo = file['name'];
    resultado = arquivo.split(".", 2);

        if(resultado[1] === 'pdf'){
          $('#target').attr('src', "../img/contas_pagar/pdf.png");
          return;
        }

        var reader = new FileReader();

        reader.onloadend = function () {
          target.src = reader.result;
        };

        if (file) {
          reader.readAsDataURL(file);


        } else {
          target.src = "";
        }
      }

</script>