<?phpphp
include("../principal/conectar_principal.php"); 


$NroGuiaEnami = isset($_REQUEST["NroGuiaEnami"])?$_REQUEST["NroGuiaEnami"]:"";

$Consulta="SELECT nro_guia,url_gde from sec_web.sec_logs where tipo='E' and nro_guia='".$NroGuiaEnami."'";
$Respuesta3 = mysqli_query($link, $Consulta);
$base_64="";
if ($Fila3 = mysqli_fetch_array($Respuesta3))
{
	$base_64=base64_decode($Fila3["url_gde"]);
}
$filename    = "Enami_GDE_".$NroGuiaEnami.".pdf";
header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename='.$filename);
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . strlen($base_64));
ob_clean();
flush();
echo $base_64;



?>