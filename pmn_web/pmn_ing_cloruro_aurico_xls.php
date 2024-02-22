<?php 
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
	include("../principal/conectar_pmn_web.php");
	include("funciones/pmn_funciones.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<link href="estilos/pmn_style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="3" topmargin="2">
<form name="frmPrincipalTeluro" action="" method="post">
  <table width="83%" border="0" cellpadding="0" cellspacing="0" class="TituloCabeceraOz">
    <tr>
      <td colspan="2" valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="2" class="TablaInterior">
          <tr>
            <td width="166" class="titulo_azul">Fecha</td>
            <td width="923"><?php echo $Meses[$MesCA-1]." - ".intval($AnoCA)?></td>
            <!--<td>
			<input name="BtnConsultar" type="button" id="BtnConsultar3" onClick="Proceso('C');" value="Consultar"></td>-->
            <?php
			  $StockIni=0;
			 $FechaAnt=date('Y-m-d',mktime(0,0,0,$MesCA,'0',$AnoCA)) ;
			 $Consulta="select stockFin_V from cloruro_aurico where fecha='".$FechaAnt."'";
			 $Resp2=mysqli_query($link, $Consulta);
			 if($Filas2=mysqli_fetch_assoc($Resp2))
				 $StockIni=$Filas2[stockFin_V];
				 
			$UltimoDia=ultimoDiaMes($MesCA,$AnoCA); 
			?>
          </tr>
            <tr>
              <td width="166" height="26" class="TituloCabeceraOz">Stock Inicial:</td>
			  <td width="923"><label>
                  <?php echo number_format($StockIni,2,',','.')?>
              </label></td>
            </tr>
          </table>
        <br>
          <table width="100%" border="1" cellspacing="0" cellpadding="2" class="TablaInterior">
            <tr>
              <td colspan="7" align="center" class="TituloTablaNaranja">Producci&oacute;n de Cloruros &Aacute;uricos y Preparaci&oacute;n de Soluci&oacute;n Concentrada</td>
            </tr>
            <tr>
              <td width="47" align="center" class="titulo_azul">D&iacute;as</td>
              <td width="125" align="center" class="titulo_azul">Stock Inicial </td>
              <td width="302" align="center" class="titulo_azul">Producci&oacute;n C.A </td>
              <td width="188" align="center" class="titulo_azul">C.A a Proceso </td>
              <td width="183" align="center" class="titulo_azul">Stock C.A Boveda </td>
              <td width="185" align="center" class="titulo_azul">Muestras a Proceso </td>
              <td width="214" align="center" class="titulo_azul">Catodos Au a Proceso </td>
              <!--<td>
			<input name="BtnConsultar" type="button" id="BtnConsultar3" onClick="Proceso('C');" value="Consultar"></td>-->
            </tr>
            <?php
			  $Total1=0;
			  $Total2=0;
			  $Total3=0;
			  $Total4=0;$Vuelta='1';
			  for($i=1;$i<=$UltimoDia;$i++)
			  {			  
				  $Consulta="select *,day(fecha) as dia,month(fecha) as mes,year(fecha) as ano from cloruro_aurico where year(fecha)='".$AnoCA."' and month(fecha)='".$MesCA."' and day(fecha)='".$i."' group by day(fecha) order by day(fecha) asc";
				  $Resp=mysqli_query($link, $Consulta);
				  if($Filas=mysqli_fetch_assoc($Resp))
				  {
						$FEC=$Filas[ano]."-".$Filas[mes]."-".$Filas[dia];
						if($Vuelta=='1')
						{
							$StockIni=$StockIni;
							$StockFinal=$StockIni+$Filas[prod_ca_V]-$Filas[ca_a_prod_V];
						}	
						else
						{
							$StockIni=$StockFinAnterior;	
							$StockFinal=$StockIni+$Filas[prod_ca_V]-$Filas[ca_a_prod_V];
						}	
						?>
						<tr>
						  <td align="center" class="texto_bold" ><?php echo $Filas[dia];?>&nbsp;</td>
						  <td align="right" bgcolor="#CCFFFF"><?php echo number_format($StockIni,4,',','.')?>&nbsp;</td>
						  <td align="right" class="texto_bold"><?php echo number_format($Filas[prod_ca_V],4,',','.');?>&nbsp;</td>
						  <td align="right" class="texto_bold"><?php echo number_format($Filas[ca_a_prod_V],4,',','.');?></td>
						  <td align="right" bgcolor="#CCFFFF"><?php echo number_format($StockFinal,4,',','.');?>&nbsp;</td>
						  <td align="right" bgcolor="#F2DDDC"><?php echo number_format($Filas[mue_a_proc_V],4,',','.');?>&nbsp;</td>
						  <td align="right" bgcolor="#F2DDDC"><?php echo number_format($Filas[cat_a_proc_V],4,',','.');?>&nbsp;</td>
						</tr>
						<?php
						$Total1=$Total1+$Filas[prod_ca_V];
						$Total2=$Total2+$Filas[ca_a_prod_V];
						$Total3=$Total3+$Filas[mue_a_proc_V];
						$Total4=$Total4+$Filas[cat_a_proc_V];
						$StockFinAnterior=$StockFinal;
				  }
				  else
				  {
				  	?>
            <tr>
              <td align="center" class="texto_bold" ><?php echo $i;?>&nbsp;</td>
              <td align="right" bgcolor="#CCFFFF"><?php echo number_format($StockIni,4,',','.')?> &nbsp;</td>
              <td align="right" class="texto_bold"><?php echo number_format($Filas[prod_ca_V],4,',','.');?> &nbsp;</td>
              <td align="right" class="texto_bold"><?php echo number_format($Filas[ca_a_prod_V],4,',','.');?>&nbsp;</td>
              <td align="right" bgcolor="#CCFFFF"><?php echo number_format($Filas[stockFin_V],4,',','.');?>&nbsp;</td>
              <td align="right" bgcolor="#F2DDDC"><?php echo number_format($Filas[mue_a_proc_V],4,',','.');?>&nbsp;</td>
              <td align="right" bgcolor="#F2DDDC"><?php echo number_format($Filas[cat_a_proc_V],4,',','.');?>&nbsp;</td>
            </tr>
            <?php
				  }
				  $Vuelta++;
			  }
				?>
            <tr>
              <td align="right" class="Text_Titulo_Etapa" colspan="2">Totales:</td>
              <td align="right" class="TituloCabeceraAzul"><?php echo number_format($Total1,4,',','.');?>&nbsp;</td>
              <td align="right" class="TituloCabeceraAzul"><?php echo number_format($Total2,4,',','.');?>&nbsp;</td>
              <td align="right">&nbsp;</td>
              <td align="right" bgcolor="#F2DDDC" class="TituloCabeceraAzul"><strong><?php echo number_format($Total3,4,',','.');?></strong>&nbsp;</td>
              <td align="right" bgcolor="#F2DDDC" class="TituloCabeceraAzul"><strong><?php echo number_format($Total4,4,',','.');?></strong>&nbsp;</td>
            </tr>
        </table></td>
    </tr>
    <tr>
      <td width="609" valign="top">&nbsp;</td>
      <td width="139" valign="top">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
function ultimoDiaMes($mes,$año) 
{ 
  for ($dia=28;$dia<=31;$dia++) 
	 if(checkdate($mes,$dia,$año)) $fecha="$dia"; 
  return $fecha; 
} 

?>