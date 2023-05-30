<?php 

require_once('../config.php');

$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$status = $_POST['status'];

if($status == 'Sim'){
	$status_serv = 'Pagas ';
}else if($status == 'Não'){
	$status_serv = 'Pendentes';

}else{
	$status_serv = '';
}

//ALIMENTAR OS DADOS NO RELATÓRIO
$html = file_get_contents(ROOT_URL."rel/relContasPagar.php?dataInicial=$dataInicial&dataFinal=$dataFinal&status=$status");

if($relatorio_pdf != 'SIM'){
	echo $html;
	exit();
}

//CARREGAR DOMPDF
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);

$pdf = new DOMPDF($options);

//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait'); //caso queira a folha em paisagem use landscape em vez de portrait

//CARREGAR O CONTEÚDO HTML
$pdf->load_html($html);

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
	'Contas_'.$status_serv.'_'.$dataInicial.'_à_'.$dataFinal.'.pdf',
	array("Attachment" => false)
);


