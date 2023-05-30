<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');


require_once("../../conexao.php");
@session_start();

$id = $_POST['id'];
$custo = $_POST['custo'];
$custo = str_replace(',', '.', $custo);
$quantidade = $_POST['quantidade'];


$res = $pdo->prepare("UPDATE itens_entrada SET qntd_conferida = :quantidade, custo = :custo WHERE id = :id");
$res->bindValue(":custo", $custo);
$res->bindValue(":quantidade", $quantidade);
$res->bindValue(":id", $id);
$res->execute();

echo 'Salvo com Sucesso!';