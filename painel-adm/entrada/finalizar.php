<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');


require_once("../../conexao.php");
@session_start();

$fornecedor = $_POST['fornecedor'];

//PUXAR DADOS DO BANCO
$query = $pdo->query("SELECT * FROM itens_entrada ORDER BY id DESC");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id_produto'];
        $custo = $res[$i]['custo'];
        $qntd_conferida = $res[$i]['qntd_conferida'];

        $queryP = $pdo->query("SELECT * FROM produtos WHERE id = '$id'");
        $resP = $queryP->fetchAll(PDO::FETCH_ASSOC);

        $novo_estoque = $resP[0]['quantidade'] + $qntd_conferida;


        $resf = $pdo->prepare("UPDATE produtos SET quantidade = :novo_estoque, custo = :custo, fornecedor = :fornecedor WHERE id = :id");
        $resf->bindValue(":id", $id);
        $resf->bindValue(":novo_estoque", $novo_estoque);
        $resf->bindValue(":custo", $custo);
        $resf->bindValue(":fornecedor", $fornecedor);
        $resf->execute();
    }

    $query = $pdo->query("TRUNCATE TABLE itens_entrada");

    echo 'Salvo com Sucesso!';

} else {

    echo 'Nenhum produto foi conferido!';
}
