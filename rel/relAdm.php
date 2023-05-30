<?php

require_once("../conexao.php");

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

?>

<!DOCTYPE html>
<html>

<head>
	<title>Catálogo Administrativo</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>
		@page {
			margin: 0px;

		}

		.footer {
			margin-top: 20px;
			width: 100%;
			background-color: #ebebeb;
			padding: 10px;
			position: absolute;
			bottom: 0;
		}

		.cabecalho-topo {
			background-color: #ebebeb;
			padding: 10px;
			margin-bottom: 30px;
			width: 100%;
			height: 100px;
		}

		.cabecalho {
			padding: 10px;
			margin-bottom: 30px;
			width: 100%;
			font-family: Times, "Times New Roman", Georgia, serif;
		}

		.titulo {
			margin: 0;
			font-size: 28px;
			font-family: Arial, Helvetica, sans-serif;
			color: #6e6d6d;

		}

		.subtitulo {
			margin: 0;
			font-size: 12px;
			font-family: Arial, Helvetica, sans-serif;
			color: #6e6d6d;
		}

		.areaTotais {
			border: 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right: 25px;
			margin-left: 25px;
			position: absolute;
			right: 20;
		}

		.areaTotal {
			border: 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right: 25px;
			margin-left: 25px;
			background-color: #f9f9f9;
			margin-top: 2px;
		}

		.pgto {
			margin: 1px;
		}

		.fonte13 {
			font-size: 13px;
		}

		.esquerda {
			display: inline;
			width: 50%;
			float: left;
		}

		.direita {
			display: inline;
			width: 50%;
			float: right;
		}

		.table {
			padding: 15px;
			font-family: Verdana, sans-serif;
			margin-top: 20px;
		}

		.texto-tabela {
			font-size: 12px;
		}


		.esquerda_float {

			margin-bottom: 10px;
			float: left;
			display: inline;
		}


		.titulos {
			margin-top: 10px;
		}

		.image {
			margin-top: -10px;
		}

		.margem-direita {
			margin-right: 80px;
		}

		.margem-direita50 {
			margin-right: 50px;
		}

		hr {
			margin: 8px;
			padding: 1px;
		}


		.titulorel {
			margin: 0;
			font-size: 25px;
			font-family: Arial, Helvetica, sans-serif;
			color: #6e6d6d;

		}

		.margem-superior {
			margin-top: 30px;
		}

		.areaSubtituloCab {
			margin-top: 15px;
			margin-bottom: 15px;
		}

		.area-cab {

			display: block;
			width: 100%;
			height: 10px;

		}


		.coluna {
			margin: 0px;
			float: left;
			height: 30px;
		}

		.area-tab {
			display: block;
			width: 100%;
			height: 40px;
			overflow: hidden;
		}
	</style>

</head>


<body>

	<?php if ($cabecalho_img_rel == 'SIM') { ?>

		<div class="img-cabecalho my-4">
			<img src="<?php echo ROOT_URL ?>img/topo-relatorio.jpg" width="100%">
		</div>

	<?php } else { ?>

		<!-- CABEÇALHO EM HTML -->

	<?php } ?>

	<div class="container">


		<div align="center">
			<span class="titulorel">Catálogo Administrativo</span>
		</div>
		<hr>
		<div class="mx-2" style="padding-top:15px ">

			<small>
				<section class="area-tab" style="background-color: #f5f5f5;">

					<div class="linha-cab" style="padding-top: 5px;">
						<div class="coluna" style="width:15%">CÓDIGO</div>
						<div class="coluna" style="width:20%">NOME</div>
						<div class="coluna" style="width:25%">DESCRIÇÃO</div>
						<div class="coluna" style="width:10%; text-align: center;">ESTOQUE</div>
						<div class="coluna" style="width:15%; text-align: center;">CUSTO</div>
						<div class="coluna" style="width:15%; text-align: center;">VALOR FINAL</div>
					</div>

				</section>

				<div class="cabecalho mb-1" style="border-bottom: solid 1px #e3e3e3;"></div>

				<?php

				$query = $pdo->query("SELECT * FROM produtos  order by codigo asc");
				$res = $query->fetchAll(PDO::FETCH_ASSOC);
				$totalItens = @count($res);
				$total_estoque = 0;

				for ($i = 0; $i < @count($res); $i++) {
					foreach ($res[$i] as $key => $value) {
					}
					$codigo = $res[$i]['codigo'];
					$nome = $res[$i]['nome'];
					$descricao = $res[$i]['apresentacao'];
					$valor_compra = $res[$i]['custo'];
					$valor_venda = $res[$i]['venda'];
					$estoque = $res[$i]['quantidade'];

					if ($estoque == '') {
						$estoque = 0;
					} else {
						$total_estoque += $estoque;

						$custo_total += $valor_compra * $estoque; 
						$valor_total += $valor_venda * $estoque;
					}

					$id = $res[$i]['id'];


					$valor_compra = number_format($valor_compra, 2, ',', '.');
					$valor_venda = number_format($valor_venda, 2, ',', '.');
				?>


					<section class="area-tab" style="padding-top:5px">
						<div class="linha-cab">
							<div class="coluna" style="width:15%"><?php echo $codigo ?> </div>
							<div class="coluna text-uppercase" style="width:20%"><?php echo $nome ?> </div>
							<div class="coluna text-uppercase" style="width:25%"><?php echo $descricao ?></div>
							<div class="coluna" style="width:10%; text-align: center;"><?php echo $estoque ?></div>
							<div class="coluna" style="width:15%; text-align: center;">R$ <?php echo $valor_compra ?></div>
							<div class="coluna" style="width:15%; text-align: center;">R$ <?php echo $valor_venda ?></div>
						</div>
					</section>


					<div class="cabecalho" style="border-bottom: solid 1px #e3e3e3;">
					</div>

				<?php } ?>
			</small>
		</div>


		<div class="cabecalho mt-3" style="border-bottom: solid 1px #0340a3">
		</div>

		<hr>

		<small>
			<div class="row margem-superior">
				<div class="col-md-12">
					<div class="" align="right">
						<span class=""> <b> Total de Cadastros : <?php echo $totalItens ?> </b> </span>

						<span class=""> <b> Produtos em Estoque : <?php echo $total_estoque ?> </b> </span>
					</div>
				</div>
			</div>
		</small>

		<hr>

		<small>
			<div class="row">
				<div class="col-md-12">
					<div class="" align="right">
						<span class=""> <b> Custo Total do Estoque : R$ <?php echo number_format($custo_total, 2, ',', '.'); ?> </b> </span>

						<span class=""> <b> Valor de Venda : R$ <?php echo number_format($valor_total, 2, ',', '.'); ?> </b> </span>
					</div>
				</div>
			</div>
		</small>

		<hr>

		<small>
			<div class="row">
				<div class="col-sm-6 direita" align="right">
					<span class=""> <b> Gerado : <?php echo $data_hoje ?>  </b>  </span>
				</div>
			</div>
		</small>

		<hr>

	</div>

	<div class="footer">
		<p style="font-size:14px" align="center"><?php echo $rodape_relatorios ?></p>
	</div>

</body>

</html>