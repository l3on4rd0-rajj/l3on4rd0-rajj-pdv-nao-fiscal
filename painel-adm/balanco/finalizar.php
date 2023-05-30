<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');


require_once("../../conexao.php");
@session_start();


//PUXAR DADOS DO BANCO
$query = $pdo->query("SELECT * FROM itens_balanco ORDER BY id DESC");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

    for ($i = 0; $i < $total_reg; $i++) {
        foreach ($res[$i] as $key => $value) {
        }

        $id = $res[$i]['id_produto'];
        $qntd_conferida = $res[$i]['qntd_conferida'];

        $novo_estoque = $qntd_conferida;


        $resf = $pdo->prepare("UPDATE produtos SET quantidade = :novo_estoque WHERE id = :id");
        $resf->bindValue(":id", $id);
        $resf->bindValue(":novo_estoque", $novo_estoque);
        $resf->execute();
    }

    $query = $pdo->query("TRUNCATE TABLE itens_balanco");

    echo 'Salvo com Sucesso!';

} else {

    echo 'Nenhum produto foi conferido!';
}
