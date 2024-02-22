<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

$CC=explode('~',DatosCC($CmbCC));
$CodCC=$CC[3];
$NomCC=$CC[2];
$Sumi=explode('~',DatosSumistros($CmbSuministro));
$NomSuministro=$Sumi[1];
$Unidad=$Sumi[2];	
?>
<html>
<head>
<title>Reporte Suministro Centro de COstos</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.close();
		break;
	
	}
	
}

</script>
<style type="text/css">
<!--
.Estilo7 {font-size: 16px}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top"><table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td width="81%" align="center" class='formulario2 Estilo7'>Informe Centros Costos <? echo $Ano;?></td>
	    <td width="19%" align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span></a><a href="JavaScript:Procesos('C')"></a><a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> <a href="JavaScript:Procesos('S')"><img src="archivos/Close2.png" alt="Volver" width="27" height="25" border="0" align="absmiddle"></a></td>
	</tr>
</table>
   </td>
   <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
    <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
        <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
        <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
      </tr>
      <tr>
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td><br>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="10%" class="formulario2">Codigo:</td>
              <td width="14%" class="formulario2"><? echo $CodCC?>&nbsp;</td>
              <td width="7%" align="left" class="formulario2">Descripci&oacute;n:</td>
              <td width="69%" class="formulario2"><? echo $NomCC;?>&nbsp;</td>
            </tr>
            <tr>
              <td class="formulario2">Suministro:</td>
              <td class="formulario2"><? echo $NomSuministro;?>&nbsp;</td>
              <td class="formulario2">Unidad:</td>
              <td class="formulario2"><? echo $Unidad;?></td>
            </tr>
          </table>
          <br>
          <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%" align="center" class="TituloTablaVerde">Mes</td>
              <td width="20%" align="center" class="TituloTablaVerde">Real</td>
              <td width="20%" align="center" class="TituloTablaVerde">Programado</td>
			  <td width="20%" align="center" class="TituloTablaVerde">Dif</td>
			  <td width="20%" align="center" class="TituloTablaVerde">%</td>
            </tr>
			<?
				$TotalProy=0;$TotalProy=0;
				while(list($c,$v)=each($Meses))
				{
					echo "<tr>";
					echo "<td class='formulario2'>".$v."</td>";
					$ValorReal=ConsumoMes('S',$CmbSuministro,$Ano,$c+1,$CodCC);
					$ValorProy=ConsumoMes('P',$CmbSuministro,$Ano,$c+1,$CodCC);
					echo "<td align='right'>".number_format($ValorReal,0,',','.')."</td>";
					echo "<td align='right'>".number_format($ValorProy,0,',','.')."</td>";
					echo "<td align='right'>".number_format($ValorReal-$ValorProy,0,',','.')."</td>";
					if($ValorProy>0)
						$Porc=($ValorReal*100)/$ValorProy;
					else
						$Porc='';	
					echo "<td align='right'>".number_format($Porc,0,',','.')."</td>";
					echo "</tr>";
					$TotalReal=$TotalReal+$ValorReal;
					$TotalProy=$TotalProy+$ValorProy;
				}
			?>
            <tr>
              <td class="pie_tabla_bold2">Total</td>
              <td class="pie_tabla_bold2" align="right"><? echo number_format($TotalReal,0,',','.');?>&nbsp;</td>
              <td class="pie_tabla_bold2" align="right"><? echo number_format($TotalProy,0,',','.');?>&nbsp;</td>
			  <td class="pie_tabla_bold2" colspan="2">&nbsp;</td>
            </tr>
          </table>
          <br>
          <br><br></td>
        <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
      </tr>
      <tr>
        <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
        <td height="15"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
        <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
      </tr>
    </table>
	<br></td>
 </tr>
  </table>
	</form>
</body>
</html>
<?
function ConsumoMes($TipoSumi,$CmbSuministro,$Ano,$Mes,$CC)
{
	$Consulta = "select valor from pcip_eec_suministros_detalle where tipo='".$TipoSumi."' and cod_suministro='".$CmbSuministro."' and ano='".$Ano."' and mes='".$Mes."' and cod_cc='".$CC."'";
	//echo $Consulta;		
	$Resp=mysql_query($Consulta);
	if ($Fila=mysql_fetch_array($Resp))
		$Consumo=$Fila[valor];
	return($Consumo);	
}

?>