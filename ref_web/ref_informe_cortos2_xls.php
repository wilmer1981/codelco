<?php
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename = "";
if ( preg_match( '/MSIE/i', $userBrowser ) ) {
$filename = urlencode($filename);
}
$filename = iconv('UTF-8', 'gb2312', $filename);
$file_name = str_replace(".php", "", $file_name);
header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");    
header("content-disposition: attachment;filename={$file_name}");
header( "Cache-Control: public" );
header( "Pragma: public" );
header( "Content-type: text/csv" ) ;
header( "Content-Dis; filename={$file_name}" ) ;
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../principal/conectar_ref_web.php");
	
	$circuito = isset($_REQUEST["circuito"])?$_REQUEST["circuito"]:""; 
	$mostrar     = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:""; 

	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 

	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;

 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Informe Impurezas</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" > 
      <td colspan="4" class="ColorTabla01"><strong>INFORME CORTOCIRCUITOS</strong></td>
  </tr>
  <tr> 
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr> 
    <td width="92">Fecha Inicio:<?php echo $AnoIni.'-'.$MesIni.'-'.$DiaIni;?></td>
    
	 
    <td width="112">Fecha Termino:<?php echo $AnoFin.'-'.$MesFin.'-'.$DiaFin;?></td>
	
  </tr>
    <tr align="center"> 
      <td height="10" colspan="4">
<table width="738" height="68" border="0">
          <tr> 
            <td width="355" height="41" rowspan="2">Circuito:<?php echo $circuito?> 
              
            </td>
            <td width="373">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><strong>SR: Sin Renovacion</strong></td>
          </tr>
        </table>
	  </p>
        </td>
  </tr>
</table>
<table width="955" align="center">
 <?php $consulta="select distinct cod_grupo from ref_web.grupo_electrolitico2 where cod_circuito='".$circuito."' order by cod_grupo";
	$rs = mysqli_query($link, $consulta);
	$cont=0;
	while ($row = mysqli_fetch_array($rs))
	    {
		  if ($cont==4)
		   {echo '<tr>';}
		  echo '<td>';
		  echo '<table width="200" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
          echo '<tr bgcolor="#FFFFFF" class="ColorTabla01">'; 
          echo '<td colspan="4" align="center"><strong>Grupo '.$row["cod_grupo"].'</strong></td>';
          echo '</tr>';
          echo '<tr bgcolor="#FFFFFF" class="ColorTabla01"> ';
		  echo '<td width="200" align="center"><strong>Fecha</strong><strong></strong></td>';
          echo '<td width="20" align="center"><strong>Dias</strong><strong></strong></td>';
          echo '<td width="20" align="center">Anodo Nuevo</td>';
          echo '<td width="20" align="center">Semi Anodo</td>';
          echo '</tr>';
		  $consulta_cortos="select cortos_nuevo, cortos_semi, cont_dia, fecha from ref_web.cortocircuitos where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."' and cod_circuito='".$circuito."' and cod_grupo='".$row["cod_grupo"]."'";
		  $respuesta_cortos = mysqli_query($link, $consulta_cortos);
	 	  while ($row_cortos = mysqli_fetch_array($respuesta_cortos))
		        {
				  echo '<tr>';
				  echo '<td width="257" align="center">'.$row_cortos["fecha"].'</td>';
				  if ($row_cortos["cont_dia"]==0)
				      {
					   echo '<td width="20" align="center" class=detalle02>SR</td>';
					  }
				  else {
				        echo '<td width="20" align="center" class=detalle01>'.$row_cortos["cont_dia"].'</td>';
					   }	
				  echo '<td width="20" align="center">'.$row_cortos["cortos_nuevo"].'</td>';
				  echo '<td width="20" align="center">'.$row_cortos["cortos_semi"].'</td>';
				  echo '</tr>';
				}  
		  $cont++;
          echo '</table>';
          echo '</td>';
		}       
 ?> 
</table>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
      <td align="center">&nbsp; </td>
  </tr>
</table>
</form>
</body>
</html>
