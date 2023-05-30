<?php

require_once('../conexao.php');

$id = $_GET['id'];

//BUSCAR AS INFORMAÇÕES DO PEDIDO
$res = $pdo->query("SELECT * from vendas where id = '$id' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$hora = $dados[0]['hora'];
$total_venda = $dados[0]['valor'];
$tipo_pgto = $dados[0]['forma_pgto'];
$status = $dados[0]['status'];
$data = $dados[0]['data'];
$operador = $dados[0]['operador'];
$cliente =  $dados[0]['cliente'];

$data2 = implode('/', array_reverse(explode('-', $data)));

$res = $pdo->query("SELECT * from forma_pgtos where codigo = '$tipo_pgto' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_pgto = $dados[0]['nome'];

$res = $pdo->query("SELECT * from usuarios where id = '$operador' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_operador = $dados[0]['nome'];

//BUSCAR AS INFORMAÇÕES DO CLIENTE
$res = $pdo->query("SELECT * from clientes where id = '$cliente' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_cliente = $dados[0]['nome'];
$doc_cliente = $dados[0]['doc'];
$telefone_cliente = $dados[0]['telefone'];
$endereco_cliente = $dados[0]['endereco'];

?>


<style type="text/css">
	* {
		margin: 0px;
		padding: 5px;
		background-color: #f7fccc;

	}

	.text {
		text-align: center;
	}

	.ttu {
		text-transform: uppercase;
		font-weight: bold;
		font-size: 1.2em;
	}

	.printer-ticket {
		display: table !important;
		width: 100%;
		max-width: 400px;
		font-weight: light;
		line-height: 1.3em;
		padding: 5px;
		font-family: Tahoma, Geneva, sans-serif;
		font-size: 12px;



	}

	th {
		font-weight: inherit;
		padding: 5px;
		text-align: center;
		border-bottom: 1px dashed #BCBCBC;
	}

	.cor {
		color: #BCBCBC;
	}


	.title {
		font-size: 1.5em;
	}

	.margem-superior {
		padding-top: 25px;
	}
</style>



<table class="printer-ticket">

	<tr>
		<th class="title" colspan="3"><?php echo NOME_EMPRESA ?> - <?php echo CNPJ_EMPRESA ?></th>

	</tr>
	<tr>
		<th colspan="3">
			Endereço: <?php echo ENDERECO_EMPRESA ?> <br />
			Telefone <?php echo TELEFONE_EMPRESA ?>
		</th>
	</tr>
	<tr>
		<th colspan="3"><?php echo $data2 ?> - <?php echo $hora ?></th>
	</tr>
	<tr>
		<th class="ttu margem-superior" colspan="3">
			Não tem valor fiscal
		</th>
	</tr>

	<tbody>

		<?php

		$res = $pdo->query("SELECT * from itens_venda where venda = '$id' order by id asc");
		$dados = $res->fetchAll(PDO::FETCH_ASSOC);
		$linhas = count($dados);

		$sub_tot;
		for ($i = 0; $i < count($dados); $i++) {
			foreach ($dados[$i] as $key => $value) {
			}

			$id_produto = $dados[$i]['produto'];
			$quantidade = $dados[$i]['quantidade'];
			$id_item = $dados[$i]['id'];


			$res_p = $pdo->query("SELECT * from produtos where id = '$id_produto' ");
			$dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
			$nome_produto = $dados_p[0]['nome'];
			$valor = $dados_p[0]['venda'];


			$total_item = $valor * $quantidade;


		?>

			<tr>

				<td style="text-transform: capitalize;" colspan="2" width="50%"><?php echo $quantidade ?> - <?php echo $nome_produto ?>

				</td>


				<td align="right">R$
					<?php

					@$total_item;
					@$sub_tot = @$sub_tot + @$total_item;
					$sub_total = $sub_tot;


					$sub_total = number_format($sub_total, 2, ',', '.');
					$total_item = number_format($total_item, 2, ',', '.');
					$total = number_format($total_venda, 2, ',', '.');


					echo $total_item;
					?>
				</td>
			</tr>

		<?php }

		$valor_recebido = number_format($valor_recebido, 2, ',', '.');
		$troco = number_format($troco, 2, ',', '.');
		?>

	</tbody>
	<tfoot>

		<tr>
			<td colspan="3" class="cor" style="border-bottom: 1px dashed #BCBCBC;">

			</td>
		</tr>


		<tr>
			<td colspan="2">Sub-total</td>
			<td align="right">R$ <?php echo @$sub_total ?></td>
		</tr>

		<tr>
			<td colspan="2">Total</td>
			<td align="right">R$ <?php echo $total ?></td>
		</tr>


		<tr>
			<td colspan="3" class="cor" style="border-bottom: 1px dashed #BCBCBC;">
				
			</td>
		</tr>

	
		<tr>
			<td colspan="2">Forma de Pagamento</td>
			<td align="right"><?php echo $nome_pgto ?></td>
		</tr>

		<tr>
			<td colspan="3" class="cor" style="border-bottom: 1px dashed #BCBCBC;">
				
			</td>
		</tr>

		<tr>
			<td align="center" class="ttu" colspan="3">
				dados do cliente
			</td>

		</tr>

		<tr>
			<td colspan="1">Cliente:</td>
			<td style="text-transform: capitalize;"><?php echo $nome_cliente ?></td>
		</tr>
		<tr>
			<td colspan="1">CPF / CNPJ:</td>
			<td ><?php echo $doc_cliente ?></td>
		</tr>
		<tr>
			<td colspan="1">Endereço:</td>
			<td style="text-transform: capitalize;" ><?php echo $endereco_cliente ?></td>
		</tr>



		<tr>
			<td colspan="3" class="cor" style="border-bottom: 1px dashed #BCBCBC;">
				
			</td>
		</tr>

		<tr>
			<td colspan="3" align="center">
				ERP. Desenvolvido por Rafael Sales / www.rafasales.com.br
			</td>
		</tr>
	</tfoot>
</table>