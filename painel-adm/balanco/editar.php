<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');


require_once("../../conexao.php");
@session_start();

$id = $_POST['id'];
$quantidade = $_POST['quantidade'];


$res = $pdo->prepare("UPDATE itens_balanco SET qntd_conferida = :quantidade WHERE id = :id");
$res->bindValue(":quantidade", $quantidade);
$res->bindValue(":id", $id);
$res->execute();

echo 'Salvo com Sucesso!';