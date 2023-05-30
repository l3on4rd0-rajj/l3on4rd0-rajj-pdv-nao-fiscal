<?php

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');

// VARIAVEIS DO MENU ADMINISTRATIVO
$menu1 = 'dashboard';
$menu2 = 'contas_pagar';
$menu3 = 'contas_receber';
$menu4 = 'movimentacoes';
$menu5 = 'vendas';
$menu6 = 'compras';

$pagina = @$_GET['pagina'];

//RECUPERAR DADOS DO USUÁRIO
$query = $pdo->query("SELECT * from usuarios WHERE id = '$_SESSION[id_usuario]'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_usu = $res[0]['id'];
$nome_usu = $res[0]['nome'];
$cpf_usu = $res[0]['cpf'];
$telefone_usu = $res[0]['telefone'];
$email_usu = $res[0]['email'];
$login_usu = $res[0]['login'];
$senha_usu = $res[0]['senha'];
$nivel_usu = $res[0]['nivel'];
$foto_usu = $res[0]['foto'];

?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo SISTEMA ?></title>

	<!-- JQuery -->
	<script type="text/javascript" src="../vendor/jquery/jquery-3.6.0.min.js"></script>

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	<!-- Script para Mascaras -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
	<script type="text/javascript" src="../vendor/js/mascaras.js"></script>

	<!-- Plugin de Notificações -->
	<script type="text/javascript" src="../vendor/js/plugins/notify.min.js"></script>

	<!-- Font Awesome -->
	<link href="../vendor/fontawesome/css/all.css" rel="stylesheet">

	<!-- FONTS -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../vendor/css/main.css">
</head>

<body class="g-sidenav-show  bg-gray-200">

	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-lg navbar-ligth bg-ligth d-flex justify-content-between">
		<div class="d-flex align-items-center">
			<i class="fa fa-user me-sm-1"></i>
			<span class="d-sm-inline d-none me-sm-5 mx-1" style="text-transform: uppercase;" ><?php echo $login_usu ?>  /  CPF: <?php echo $cpf_usu ?></span>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="mx-4" id="navbarNavDropdown">
				<ul class="navbar-nav">

					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="index.php?pagina=<?php echo $menu1 ?>">Dashboard</a>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Títulos
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<li><a class="dropdown-item" href="index.php?pagina=<?php echo $menu2 ?>">Contas à Pagar</a></li>
							<li><a class="dropdown-item" href="index.php?pagina=<?php echo $menu3 ?>">Contas à Receber</a></li>
						</ul>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="index.php?pagina=<?php echo $menu4 ?>">Movimentações</a>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Relatórios
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalRelMov">Movimentações</a></li>
							<li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#ModalRelContasPagar">Contas</a></li>
						</ul>
					</li>

					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							Painel
						</a>
						<ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<li><a class="dropdown-item" href="../painel-adm">Administrativo</a></li>
							<li><a class="dropdown-item" href="../painel-pdv">PDV</a></li>
						</ul>
					</li>

				</ul>
			</div>
		</div>

		<div class="justify-content-end">
			<a href="../logout.php" title="Sair"><i class="fas fa-sign-out-alt"></i></a>
		</div>

	</nav>
	<!-- FINAL NAVBAR -->

	<!-- CONTAINER PARA CARREGAMENTO DAS PÁGINAS -->

	<nav aria-label="breadcrumb" class="py-2 px-4">
		<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
			<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Painel Financeiro</a></li>
			<li class="breadcrumb-item text-sm text-dark active font-weight-bolder" aria-current="page"><?php echo $pagina ?></li>
		</ol>
	</nav>


	<?php

	if (@$_GET['pagina'] == $menu1) {
		require_once($menu1.'.php');
	}

	elseif (@$_GET['pagina'] == $menu2) {
		require_once($menu2.'.php');
	}

	elseif (@$_GET['pagina'] == $menu3) {
		require_once($menu3.'.php');
	}

	elseif (@$_GET['pagina'] == $menu4) {
		require_once($menu4.'.php');
	}

	elseif (@$_GET['pagina'] == $menu5) {
		require_once($menu5.'.php');
	}

	elseif (@$_GET['pagina'] == $menu6) {
		require_once($menu6.'.php');
	}

	else {
		require_once($menu1.'.php');
	}

	?>

	<!-- ------------------------ -->

	<!-- MENU PERFIL -->

	<div class="fixed-plugin">
		<a class="fixed-plugin-button text-dark position-fixed px-3 py-2"><i class="fas fa-user"></i></a>
		<div class="card shadow-lg">
			<div class="card-header pb-0 pt-3">
				<div class="float-start">
					<h5 class="mt-2 mb-0 text-capitalize"><?php echo $nome_usu ?></h5>
					<p><?php echo $nivel_usu ?></p>
				</div>
				<div class="float-end mt-2">
					<button class="btn btn-link text-dark p-0 fixed-plugin-close-button text-lg">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>

			<div class="card-body py-0 mt-0">
				<hr>
				<div class="w-100 mb-3 text-center">
					<img src="../img/usuarios/<?php echo $foto_usu ?>" class="border-radius-lg w-70 mb-2" style="border: 7px solid #889;" >
					<p class="mb-0"><?php echo $email_usu ?></p>
					<p ><?php echo $telefone_usu ?></p>
				</div>
				<hr>
				<div class="d-flex flex-column text-center">

					<?php if ( $login_usu != "root" ) { ?>

						<a href="" data-bs-toggle="modal" data-bs-target="#modalPerfil" type="button" class="mb-3"><i class="fas fa-user-edit"></i>   Editar Perfil</a>

					<?php } ?>

					<a href="../logout.php" type="button" class="mb-0"><i class="fas fa-sign-out-alt"></i>  Sair</a>
				</div>
			</div>
		</div>
	</div>

	<footer class="footer pb-2">
		<div class="container-fluid">
			<div class="row align-items-center justify-content-lg-between">
				<div class="col-lg-6 mb-lg-0 mb-4">
					<div class="copyright text-center text-sm text-muted text-lg-start">
						© <script>
							document.write(new Date().getFullYear())
						</script>.
						Desenvolvido com <i class="fa fa-heart"></i> por
						<a href="https://www.rajjesh.com.br" class="font-weight-bold" target="_blank">rajjesh</a>.
					</div>
				</div>
			</div>
		</div>
	</footer>

	<script src="../vendor/js/plugins/perfect-scrollbar.min.js"></script>
	<script src="../vendor/js/plugins/smooth-scrollbar.min.js"></script>
	<script src="../vendor/js/plugins/chartjs.min.js"></script>



	<script>
		var win = navigator.platform.indexOf('Win') > -1;
		if (win && document.querySelector('#sidenav-scrollbar')) {
			var options = {
				damping: '0.5'
			}
			Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
		}
	</script>

	<script src="../vendor/js/main.min.js"></script>

</body>
</html>



<div class="modal fade" tabindex="-1" id="modalPerfil" data-bs-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Editar Perfil</h5>
				<button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
			</div>

			<form method="POST" id="form-perfil">
				<div class="modal-body">

					<p>Para alterar mais informações solicite o Administrador</p>

					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Telefone</label>
								<input type="text" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="telefone-perfil" name="telefone-perfil" value="<?php echo @$telefone_usu ?>" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">E-mail</label>
								<input type="email" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="email-perfil" name="email-perfil" value="<?php echo @$email_usu ?>" required>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="mb-3">
								<label class="form-label">Senha</label>
								<input type="password" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="senha-perfil" name="senha-perfil" value="<?php echo @$senha_usu ?>" required>
							</div>
						</div>
					</div>

					<div class="mb-3">
						<label class="form-label">Foto</label>
						<input type="file" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="foto-perfil" name="foto-perfil" value="<?php echo @$foto_usu ?>">
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" id="btn-fechar-perfil" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button name="btn-salvar-perfil" id="btn-salvar-perfil" type="submit" class="btn btn-primary">Salvar</button>

					<input type="hidden" name="id-perfil" value="<?php echo @$id_usu ?>">
				</div>

			</form>

		</div>
	</div>
</div>



<!--  Modal Rel-->
<div class="modal fade" tabindex="-1" id="ModalRelMov" data-bs-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Relatório de Movimentações</h5>
				<button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
			</div>
			<form action="../rel/relMov_class.php" method="POST" target="_blank">

				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label>Data Inicial</label>
								<input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="dataInicial" >
							</div>
						</div>
						<div class="col-md-4">

							<div class="form-group mb-3">
								<label>Data Final</label>
								<input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="dataFinal" >
							</div>


						</div>

						<div class="col-md-4">
							<div class="form-group mb-3">
								<label>Status</label>
								<select class="form-select px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="status">
									<option value="">Todas</option>
									<option value="Entrada">Entradas</option>
									<option value="Saída">Saídas</option>
								</select>
							</div>
						</div>
					</div>   

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" >Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>



<!--  Modal Rel-->
<div class="modal fade" tabindex="-1" id="ModalRelContasPagar" data-bs-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Relatório de Contas</h5>
				<button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
			</div>
			<form action="../rel/relContasPagar_class.php" method="POST" target="_blank">

				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label>Data Inicial</label>
								<input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="dataInicial" >
							</div>
						</div>
						<div class="col-md-4">

							<div class="form-group mb-3">
								<label>Data Final</label>
								<input value="<?php echo date('Y-m-d') ?>" type="date" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="dataFinal" >
							</div>


						</div>

						<div class="col-md-4">
							<div class="form-group mb-3">
								<label>Status</label>
								<select class="form-select px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="status">
									<option value="">Todas</option>
									<option value="Sim">Pagas</option>
									<option value="Não">Pendentes</option>
								</select>
							</div>
						</div>
					</div>   

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" >Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
	$("#form-perfil").submit(function () {
		var pag = "<?=$pagina?>";
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-perfil.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {

				if (mensagem.trim() == "Salvo com Sucesso!") {

					$('#btn-fechar-perfil').click();
					window.location = "index.php?pagina="+pag;

				} else {

					$.notify( mensagem, "error" );

				}
			},

			cache: false,
			contentType: false,
			processData: false,
            xhr: function () {  // Custom XMLHttpRequest
            	var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                	myXhr.upload.addEventListener('progress', function () {
                		/* faz alguma coisa durante o progresso do upload */
                	}, false);
                }
                return myXhr;
            }
        });
	});
</script>