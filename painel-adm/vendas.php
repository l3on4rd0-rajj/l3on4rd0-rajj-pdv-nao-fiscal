<?php 

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');



$vendas = 0;
$aprazos = 0;
$vendasF = 0;
$aprazosF = 0;


$query = $pdo->query("SELECT * from vendas where data = curDate() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){ 

  for($i=0; $i < $total_reg; $i++){
    foreach ($res[$i] as $key => $value){ }


      if($res[$i]['forma_pgto'] != 5){

        $vendas += $res[$i]['valor'];

      }else{

        $aprazos += $res[$i]['valor'];
        
      }

      $vendasF = number_format($vendas, 2, ',', '.');
      $aprazosF = number_format($aprazos, 2, ',', '.');


    }

  }

  ?>

  <div class="container-fluid pt-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-4 pb-3 d-flex justify-content-between container-fluid">
              <h6 class="text-white ps-3">Lista de Vendas</h6>

                  <div>
                    <span class="mx-2 font-weight-bold text-white">Faturado Hoje : <span class="text-success">R$ <?php echo $vendasF ?></span></span>
                  </div>

            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">

              <?php 

            //PUXAR DADOS DO BANCO
              $query = $pdo->query("SELECT * FROM vendas ORDER BY id DESC");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $total_reg = @count($res);
              if ($total_reg > 0) {

                ?>

                <table id="table" class="table table-hover align-items-center mb-0">

                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Valor</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Data</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hora</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vendedor</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Forma Pgto</th>
                      <th class="text-center text-uppercase"></th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php 

                    for($i=0; $i < $total_reg; $i++){
                      foreach ($res[$i] as $key => $value)
                        {     }

                      $id_usuario = $res[$i]['operador'];
                      $id_pgto = $res[$i]['forma_pgto'];


                      $query_p = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");
                      $res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
                      $operador = $res_p[0]['nome'];

                      $query_p = $pdo->query("SELECT * from forma_pgtos where id = '$id_pgto'");
                      $res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
                      $forma_pgto = $res_p[0]['nome'];


                      if($res[$i]['status'] == 'Concluída'){
                        $classe = 'fas fa-circle text-success';
                        $tipo = 'Concluída';
                        $btnCancelarVisibility = true;
                      }else{
                        $classe = 'fas fa-circle text-danger';
                        $tipo = 'Cancelada';
                        $btnCancelarVisibility = false;
                      }

                      ?>

                      <tr>
                        <td>
                          <div class="text-center">
                            <i class="<?php echo $classe ?>"></i>
                            <span><?php echo $tipo ?></span>
                          </div>
                        </td>

                        <td>
                        <p class="text-center text-xs font-weight-bold mb-0">R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></p>
                        </td>

                        <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?php echo implode('/', array_reverse(explode('-', $res[$i]['data']))); ?></p>
                        </td>

                        <td>
                          <p class="text-center text-xs font-weight-bold mb-0"><?php echo $res[$i]['hora'] ?></p>
                        </td>

                        <td>
                          <p class="text-center text-capitalize text-xs font-weight-bold mb-0"><?php echo $operador ?></p>
                        </td>

                        <td>
                          <p class="text-center text-xs font-weight-bold mb-0"><?php echo $forma_pgto ?></p>
                        </td>

                        <td>
                          <a href="./comprovante_class.php?id=<?php echo $res[$i]['id'] ?>" target="_blank" title="Ver Cupom"><i class="fa-solid fa-receipt mx-3"></i></a>

                          <?php if ($btnCancelarVisibility == true) { ?>
                            <a href="index.php?pagina=<?php echo $pagina ?>&funcao=cancelar&id=<?php echo $res[$i]['id'] ?>" title="Cancelar Venda"><i class="fa-solid fa-ban"></i></a>
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



  <div class="modal fade" tabindex="-1" id="modalCancelarVenda" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cancelar Venda</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" id="form-cancelar">
        <div class="modal-body">

          <p>Confirma o cancelamento desta venda? Os produtos retornaram ao estoque e a movimentação financeira será alterada!</p>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-cancelar" id="btn-cancelar" type="submit" class="btn btn-danger">Confirmar</button>

          <input type="hidden" name="id" value="<?php echo @$_GET['id'] ?>">

        </div>
      </form>

    </div>
  </div>
</div>



<!-- ABRIR MODAL CANCELAR VENDA -->
<?php 
if (@$_GET['funcao'] == "cancelar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalCancelarVenda'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form-cancelar").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: "./cancelar-venda.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Sucesso!") {

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
