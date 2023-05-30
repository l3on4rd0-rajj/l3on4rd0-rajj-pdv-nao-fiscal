<?php 

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');

$busca = $_POST['busca'];

$query = $pdo->query("SELECT * FROM produtos WHERE nome LIKE '%$busca%' OR codigo = '$busca' order by nome ASC");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value)
			{     }

			$quantidade = $res[$i]['quantidade'];

			if ($quantidade == '') {
				$quantidade = 0;
			}


		$id_cat = $res[$i]['categoria'];
		$query_c = $pdo->query("SELECT * FROM categorias WHERE id = '$id_cat' ");
		$res_c = $query_c->fetchAll(PDO::FETCH_ASSOC);

		$nome_cat = $res_c[0]['nome'];

		echo '<tr>

		<td class="align-middle text-center" style="border: 1px solid #ccc;">
		<a href="index.php?pagina=balanco&funcao=get&id='.$res[$i]['id'].'" title="Selecionar" class="text-info"><i class="fas fa-check"></i></a>
		</td>

		<td class="align-middle text-center" style="border: 1px solid #ccc; color: #000;">
		<p class="mb-0">'.$res[$i]['codigo'].'</p>
		</td>

		<td class="align-middle text-center text-uppercase" style="border: 1px solid #ccc; color: #000;">
		<p class="mb-0">'.$res[$i]['nome'].'</p>
		</td>

		<td class="align-middle text-center text-uppercase" style="border: 1px solid #ccc; color: #000;">
		<p class="mb-0">'.$res[$i]['apresentacao'].'</p>
		</td>

		<td class="align-middle text-center" style="border: 1px solid #ccc; color: #000;">
		<p class="mb-0">'.$quantidade.'</p>
		</td>

		<td class="align-middle text-center text-uppercase" style="border: 1px solid #ccc; color: #000;">
		<p class="mb-0">'.$nome_cat.'</p>
		</td>

		<td class="align-middle text-center text-uppercase" style="border: 1px solid #ccc; color: #000;">
		<p class="mb-0">'.$res[$i]['fabricante'].'</p>
		</td>

		</tr>';

	}

} else {
	
	echo '<div style="position: absolute; width: 97%" class="text-center p-5"><h6>Nenhum produto encontrado!</h6></div>';
}

?>


