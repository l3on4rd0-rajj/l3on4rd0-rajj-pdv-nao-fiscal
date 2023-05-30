<?php 

require_once("../conexao.php");

$id = $_POST['id-perfil'];
$telefone = $_POST['telefone-perfil'];
$email = $_POST['email-perfil'];
$senha = $_POST['senha-perfil'];


//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s').'-'.@$_FILES['foto-perfil']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../img/usuarios/' .$nome_img;
if (@$_FILES['foto-perfil']['name'] == ""){
	$imagem = "sem-foto.jpg";
}else{
	$imagem = $nome_img;
}

$imagem_temp = @$_FILES['foto-perfil']['tmp_name']; 
$ext = pathinfo($imagem, PATHINFO_EXTENSION);   
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
	move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}



if ($imagem != "sem-foto.jpg") {
	$res = $pdo->prepare("UPDATE usuarios SET telefone = :telefone, email = :email, senha = :senha, foto = :foto WHERE id = :id");
	$res->bindValue(":foto", $imagem);
} else {
	$res = $pdo->prepare("UPDATE usuarios SET telefone = :telefone, email = :email, senha = :senha WHERE id = :id");
}


$res->bindValue(":id", $id);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);
$res->bindValue(":senha", $senha);
$res->execute();

echo "Salvo com Sucesso!";

?>