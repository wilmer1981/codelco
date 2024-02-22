<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");	
	
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
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
?>
<style type="text/css">
<!--
.Estilo7 {font-size: 14px}
-->
</style>
<form name="PrinElectPLata" method="post">
<table width="32%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr class="TituloCabeceraAzul">
    <td colspan='6' align="center">Existencia Metal Dor</td>
  </tr>	
  <tr class="TituloCabeceraAzul">
    <td width="41%" colspan="2" align="left">Mes - Ao</td>
    <td width="59%" colspan="4" align="left"><?php echo $Meses[$Mes-1]." - ".$Ano;?>&nbsp;</td>
  </tr>
</table>
<br />
  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="6%" align="center">D&iacute;a</td>
      <td width="9%" align="center">Hora</td>
      <td width="25%" align="center">Producto</td>
      <td width="27%" align="center">Subproducto</td>
      <td width="9%" align="center">valor</td>
      <td width="24%" align="center">Funcionario</td>
    </tr>
    <?php
		$Buscar='S';
	  if($Buscar=='S')
	  {
		  for($K=1;$K<=31;$K++)
		  {
		  	//echo $K."<br>";		
		  
				$Fecha=	$Ano."-".$Mes."-".$K;
				$ConsultaP = "select * from pmn_web.produccion_circulantes_oxidos ";
				$ConsultaP.= " where year(fecha)='".$Ano."' and month(fecha)='".$Mes."' and day(fecha)='".$K."' and cod_producto<>'39' and cod_subproducto<>'11'";
				//echo $ConsultaP."<br>";
				//echo $ConsultaP."<br>";
				$RespuestaP = mysqli_query($link, $ConsultaP);
				while ($Filas = mysqli_fetch_array($RespuestaP))
				{
					$Dia=substr($Filas["fecha"],0,10);
					$Dia=explode('-',$Dia);
					$Hora=substr($Filas["fecha"],11,20);		
					?>
					<tr>
					  <td align="center"><?php echo $Dia[2];?></td>
					  <td align="center"><?php echo $Hora;?></td>
					  <?php
					$Consulta3 = "select * from proyecto_modernizacion.productos where cod_producto ='".$Filas["cod_producto"]."'";
					//echo "producto:     ".$Consulta3."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Producto=$Row3["descripcion"]
					?>
					  <td align="left"><?php echo ucwords(strtolower($Producto));?>&nbsp;</td>
					  <?php
					$Consulta3 = "select * from proyecto_modernizacion.subproducto where cod_producto ='".$Filas["cod_producto"]."' and cod_subproducto='".$Filas["cod_subproducto"]."'";
					//echo "Subproducto:     ".$Consulta3."<br>";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Subproducto=$Row3["descripcion"]
					?>
					  <td align="left"><?php echo ucwords(strtolower($Subproducto));?></td>
					  <td align="right"><?php echo number_format($Filas["valor"],2,',','.');?></td>
					  <?php
					$Consulta3 = "select * from proyecto_modernizacion.funcionarios where rut ='".$Filas[rut]."'";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Funcionario=$Row3["apellido_paterno"]." ".$Row3["apellido_materno"]." ".$Row3["nombres"]
					?>
					  <td align="left"><?php echo ucwords(strtolower($Funcionario));?></td>
					</tr>
					<?php
				}
		  }		
	  }	
	  ?>
  </table>
  <p>&nbsp;</p>
</form>
