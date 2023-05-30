<?php

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');

$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual . "-" . $mes_atual . "-01";

$entradasF = 0;
$saidasF = 0;
$saldoF = 0;
$valorMov = 0;
$descricaoMov = '';
$saldoMesF = 0;
$pagarMesF = 0;
$receberMesF = 0;
$totalVendasMF = 0;

$entradas = 0;
$saidas = 0;
$saldo = 0;
$classeIconeSaldo = 'bg-gradient-success shadow-success';
$classeIconeSaldoM = 'bg-gradient-success shadow-success';

$query = $pdo->query("SELECT * from movimentacoes where data = curDate() order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

  for ($i = 0; $i < $total_reg; $i++) {
    foreach ($res[$i] as $key => $value) {
    }


    if ($res[$i]['tipo'] == 'Entrada') {

      $entradas += $res[$i]['valor'];
    } else {

      $saidas += $res[$i]['valor'];
    }

    $saldo = $entradas - $saidas;

    $entradasF = number_format($entradas, 2, ',', '.');
    $saidasF = number_format($saidas, 2, ',', '.');
    $saldoF = number_format($saldo, 2, ',', '.');

    if ($saldo < 0) {
      $classeSaldo = 'text-danger';
      $classeIconeSaldo = 'bg-gradient-danger shadow-danger';
    } else {
      $classeSaldo = 'text-success';
      $classeIconeSaldo = 'bg-gradient-success shadow-success';
    }
  }
}



$query = $pdo->query("SELECT * from movimentacoes order by id desc limit 1");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$valorMov = $res[0]['valor'];
$descricaoMov = $res[0]['descricao'];
$tipoMov = $res[0]['tipo'];
$valorMov = number_format($valorMov, 2, ',', '.');
if ($tipoMov == 'Entrada') {
  $classeMov = 'text-success';
} else {
  $classeMov = 'text-danger';
}


$query = $pdo->query("SELECT * from contas_receber where vencimento < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_receber_vencidas = @count($res);


$query = $pdo->query("SELECT * from contas_receber where vencimento = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_receber_hoje = @count($res);


$query = $pdo->query("SELECT * from contas_pagar where vencimento < curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_pagar_vencidas = @count($res);


$query = $pdo->query("SELECT * from contas_pagar where vencimento = curDate() and pago != 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$contas_pagar_hoje = @count($res);





$entradasM = 0;
$saidasM = 0;
$saldoM = 0;
$query = $pdo->query("SELECT * from movimentacoes where data >= '$dataInicioMes' and data <= curDate() ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

  for ($i = 0; $i < $total_reg; $i++) {
    foreach ($res[$i] as $key => $value) {
    }


    if ($res[$i]['tipo'] == 'Entrada') {

      $entradasM += $res[$i]['valor'];
    } else {

      $saidasM += $res[$i]['valor'];
    }

    $saldoMes = $entradasM - $saidasM;

    $entradasMF = number_format($entradasM, 2, ',', '.');
    $saidasMF = number_format($saidasM, 2, ',', '.');
    $saldoMesF = number_format($saldoMes, 2, ',', '.');

    if ($saldoMesF < 0) {
      $classeSaldoM = 'text-danger';
      $classeIconeSaldoM = 'bg-gradient-danger shadow-danger';
    } else {
      $classeSaldoM = 'text-success';
      $classeIconeSaldoM = 'bg-gradient-success shadow-success';
    }
  }
}



$totalPagarM = 0;
$query = $pdo->query("SELECT * from contas_pagar where data >= '$dataInicioMes' and data <= curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$pagarMes = @count($res);
$total_reg = @count($res);
if ($total_reg > 0) {

  for ($i = 0; $i < $total_reg; $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $totalPagarM += $res[$i]['valor'];
    $pagarMesF = number_format($totalPagarM, 2, ',', '.');
  }
}


$totalReceberM = 0;
$query = $pdo->query("SELECT * from contas_receber where data >= '$dataInicioMes' and data <= curDate()");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$receberMes = @count($res);
$total_reg = @count($res);
if ($total_reg > 0) {

  for ($i = 0; $i < $total_reg; $i++) {
    foreach ($res[$i] as $key => $value) {
    }

    $totalReceberM += $res[$i]['valor'];
    $receberMesF = number_format($totalReceberM, 2, ',', '.');
  }
}

?>

<div class="container-fluid pt-4 pb-3">

  <div class="row">

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-coins"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0">Entrada de Hoje</p>
            <h4 class="mb-0">R$ <?php echo @$entradasF ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">...</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-file-invoice-dollar"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 ">Saída de Hoje</p>
            <h4 class="mb-0">R$ <?php echo @$saidasF ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">...</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape <?php echo $classeIconeSaldo ?> text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-balance-scale"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0">Saldo de Hoje</p>
            <h4 class="mb-0 <?php echo @$classeSaldo ?>">R$ <?php echo @$saldoF ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0">Total arrecadado no dia</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-calendar-day"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0">Contas Vencendo Hoje</p>
            <h4 class="mb-0"><?php echo @$contas_pagar_hoje ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0">Pendentes de pagamento</p>
        </div>
      </div>
    </div>

  </div>

  <div class="row mt-4">

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-coins"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0">Entradas do Mês</p>
            <h4 class="mb-0">R$ <?php echo @$entradasMF ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">...</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-file-invoice-dollar"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 ">Saídas do Mês</p>
            <h4 class="mb-0">R$ <?php echo @$saidasMF ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">...</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape <?php echo $classeIconeSaldoM ?> text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-balance-scale"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0">Saldo Total</p>
            <h4 class="mb-0 <?php echo @$classeSaldoM ?>">R$ <?php echo @$saldoMesF ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0">Total arrecadado no mês</p>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-calendar-times"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0">Contas Vencidas</p>
            <h4 class="mb-0"><?php echo @$contas_pagar_vencidas ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0">Pendentes de pagamento</p>
        </div>
      </div>
    </div>

  </div>
</div>