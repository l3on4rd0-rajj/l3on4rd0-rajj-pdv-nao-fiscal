<?php 

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');



$entradas = 0;
$saidas = 0;
$saldo = 0;

$entradasF = 0;
$saidasF = 0;
$saldoF = 0;

$query = $pdo->query("SELECT * from movimentacoes where data = curDate() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){ 

  for($i=0; $i < $total_reg; $i++){
    foreach ($res[$i] as $key => $value){ }


      if($res[$i]['tipo'] == 'Entrada'){

        $entradas += $res[$i]['valor'];

      }else{

        $saidas += $res[$i]['valor'];
        
      }

      $saldo = $entradas - $saidas;

      $entradasF = number_format($entradas, 2, ',', '.');
      $saidasF = number_format($saidas, 2, ',', '.');
      $saldoF = number_format($saldo, 2, ',', '.');

      if($saldo < 0){
        $classeSaldo = 'text-danger';
      }else{
        $classeSaldo = 'text-success';
      }

    }

  }

  ?>

  <div class="container-fluid pt-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-4 pb-3 d-flex justify-content-between container-fluid">
              <h6 class="text-white ps-3">Movimentações</h6>

                  <div>
                    <span class="mx-2 font-weight-bold text-white">Entradas de Hoje : <span class="text-success">R$ <?php echo $entradasF ?></span></span>
                    <span class="mx-2 font-weight-bold text-white">Saídas de Hoje : <span class="text-danger"> R$ <?php echo $saidasF ?></span></span>
                    <span class="mx-2 font-weight-bold text-white">Saldo do Dia : <span class="<?php echo $classeSaldo ?>">R$ <?php echo $saldoF ?></span></span>
                  </div>

            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">

              <?php 

            //PUXAR DADOS DO BANCO
              $query = $pdo->query("SELECT * FROM movimentacoes ORDER BY id DESC");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $total_reg = @count($res);
              if ($total_reg > 0) {

                ?>

                <table id="table" class="table table-hover align-items-center mb-0">

                  <thead>
                    <tr>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descrição</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Valor</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuário</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Data</th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php 

                    for($i=0; $i < $total_reg; $i++){
                      foreach ($res[$i] as $key => $value)
                        {     }

                      $id_usuario = $res[$i]['usuario'];
                      $query_p = $pdo->query("SELECT * from usuarios where id = '$id_usuario'");
                      $res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
                      $nome_usuario = $res_p[0]['nome'];


                      if($res[$i]['tipo'] == 'Entrada'){
                        $classe = 'fas fa-circle text-success';
                        $tipo = 'Entrada';
                      }else{
                        $classe = 'fas fa-circle text-danger';
                        $tipo = 'Saída';
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
                          <p class="text-center text-xs font-weight-bold mb-0 text-uppercase"><?php echo $res[$i]['descricao'] ?></p>
                        </td>

                        <td>
                          <p class="text-center text-xs font-weight-bold mb-0">R$ <?php echo number_format($res[$i]['valor'], 2, ',', '.'); ?></p>
                        </td>

                        <td>
                          <p class="text-center text-xs font-weight-bold mb-0"><?php echo $nome_usuario ?></p>
                        </td>

                        <td>
                          <p class="text-center text-xs font-weight-bold mb-0"><?php echo implode('/', array_reverse(explode('-', $res[$i]['data']))); ?></p>
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