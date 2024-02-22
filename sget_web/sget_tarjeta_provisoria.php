<?
	//echo "PROCESO:".$Proceso;
	include("../principal/conectar_sget_web.php");
	$Consulta="SELECT * from sget_personal where rut='$Rut'";
	$Resp=mysql_query($Consulta);
	//echo $Consulta;
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtRut=$Fila["rut"];					
		$TxtNom=$Fila["nombres"];
		$TxtPat=$Fila[ape_paterno];
		$TxtMat=$Fila[ape_materno];
		$Consulta="SELECT * from sget_contratistas where rut_empresa='".$Fila[rut_empresa]."'";
		$RespEmp=mysql_query($Consulta);
		if($FilaEmp=mysql_fetch_array($RespEmp))
			$Empresa=$FilaEmp[razon_social];
		$Consulta="SELECT * from sget_contratos where cod_contrato='".$Fila["cod_contrato"]."' and rut_empresa!=''";
		$RespCtto=mysql_query($Consulta);
		if($FilaCtto=mysql_fetch_array($RespCtto))
		{
			$Contrato=$FilaCtto["cod_contrato"]."   ".strtoupper($FilaCtto[descrip_contrato]);
			$TxtVig=$FilaCtto[fecha_termino];
		}	
	}
?>
<html>
<head>
<title>Tarjeta Provisoria</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Procesos(TipoProceso)
{
	var Frm = document.frmPrincipal;

	switch(TipoProceso)
	{
		case 'I'://IMPRIMIR
			Frm.BtnImprimir.style.visibility='hidden';
			window.print();
			Frm.BtnImprimir.style.visibility='';			
			break;
	}		
}
</script>
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proceso" value="<? echo $Proceso;?>">
<input type="hidden" name="Valores" value="<? echo $Valores;?>">
	    <table width="400" border="2" cellspacing="2" cellpadding="2">
          <tr>
            <td colspan="6" class="ColorTabla01">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" rowspan="5" align="center" valign="middle"><img src='fotos/<? echo $Rut;?>.jpg' width='92' height='91' border='0' align='absmiddle'>&nbsp;</td>
            <td colspan="4" align="right"><div align="center"><img src='../principal/imagenes/logo_codelco.jpg' width='80' height='35' border='0' align='absmiddle'>&nbsp;</div></td>
          </tr>
          <tr>
            <td width="69" align="right" class="ColorTabla02">Empresa:</td>
            <td width="233" colspan="3" bgcolor="#FFFFFF"><? echo $Empresa;?></td>
          </tr>
          <tr>
            <td align="right" class="ColorTabla02">Nombre:</td>
            <td colspan="3" bgcolor="#FFFFFF"><? echo $TxtNom." ".$TxtPat." ".$TxtMat;?></td>
          </tr>
          <tr>
            <td align="right" class="ColorTabla02">Vigencia:</td>
            <td colspan="3" bgcolor="#FFFFFF"><? echo $TxtVig;?></td>
          </tr>
          <tr>
            <td rowspan="2" align="right" class="ColorTabla02">N&deg; Contrato:</td>
            <td colspan="3" rowspan="2" bgcolor="#FFFFFF"><? echo $Contrato;?></td>
          </tr>
          <tr>
            <td height="75" colspan="2" align="center" valign="bottom">V&deg;B&deg; Jefe D.P.I </td>
          </tr>
        </table>
	    <br>
		<table width="400" border="0" cellpadding="0" cellspacing="0">		  
          <tr align="center">
            <td colspan="2">
			<input name="BtnImprimir" type="button" style="width:70px;" value="Imprimir" onClick="Procesos('I')"></td></tr>
  </table>
	    <br>
	    <br></td>
 </tr>
</table>
</form>
</body>
</html>