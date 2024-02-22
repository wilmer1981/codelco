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
		$TxtDir=$Fila["direccion"];
		$TxtFono1=$Fila[telefono1];
		$TxtFono2=$Fila[telefono2];
		$TxtTarj=$Fila[nro_tarjeta];
		$Tipo=$Fila["tipo"];
		$Consulta="SELECT * from sget_contratistas where rut_empresa='".$Fila[rut_empresa]."'";
		$RespEmp=mysql_query($Consulta);
		if($FilaEmp=mysql_fetch_array($RespEmp))
			$Empresa=$FilaEmp[razon_social];
		$Consulta="SELECT * from sget_contratos where cod_contrato='".$Fila["cod_contrato"]."' and rut_empresa!=''";
		$RespCtto=mysql_query($Consulta);
		if($FilaCtto=mysql_fetch_array($RespCtto))
			$Contrato=$FilaCtto["cod_contrato"]."   ".strtoupper($FilaCtto[descrip_contrato]);
		if($Fila["estado"]=='A')
			$Estado='ACTIVO';
		else
			$Estado='INACTIVO';
		$TxtObs=$Fila["observacion"];	
	}
?>
<html>
<head>
<title>Detalle Persona</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="validarut.js"></script>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Salir()
{
	window.close();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Proceso" value="<? echo $Proceso;?>">
<input type="hidden" name="Valores" value="<? echo $Valores;?>">
	    
	    <br>
	    <table width="70%"  border="0" align="center" cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
          <tr>
            <td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15" /></td>
            <td height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
            <td width="15" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15" /></td>
          </tr>
          <tr>
            <td width="15" background="archivos/images/interior/form_izq.gif">&nbsp;</td>
            <td align="center">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="74%" align="left"><img src="archivos/sub_tit_deta_pers.png"></td>
                  <td align="right"><a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a> </td>
                </tr>
              </table>
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
                <tr>
                  <td colspan="3"align="center" class="TituloTablaVerde"></td>
                </tr>
                <tr>
                  <td width="1%" align="center" class="TituloTablaVerde"></td>
                  <td align="center"><table width="100%" border="1" cellspacing="0" cellpadding="1">
                    <tr>
                      <td colspan="2" rowspan="11" align="center" valign="middle" class="formulario2">
					  <?
					  $Foto="fotos/".$Rut.".jpg";
					  if(is_file($Foto))
						$Imagen=$Foto;
					  else
						$Imagen="archivos/usuario.png";
					  ?>
					  <img src='<? echo $Imagen;?>' width='140' height='126' border='0' align='absmiddle'>&nbsp;</td>
                      <td width="89" align="left" class="formulario2">Rut:</td>
                      <td width="413" colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $TxtRut;?>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Nombres:</td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $TxtNom;?></td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Apell.Paterno: </td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $TxtPat;?></td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Apell. Materno: </td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $TxtMat;?></td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Direcci&oacute;n:</td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $TxtDir;?></td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Telefono(1):</td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $TxtFono1;?>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Telefono(2):</td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $TxtFono2;?>&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Nro.Tarjeta:</td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $TxtTarj;?></td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Empresa:</td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $Empresa;?></td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Contrato:</td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $Contrato;?></td>
                    </tr>
                    <tr>
                      <td align="left" class="formulario2">Estado:</td>
                      <td colspan="3" bgcolor="#FFFFFF" class="formulariosimple"><? echo $Estado;?></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="right" class="formulario2">Observaci&oacute;n:</td>
                      <td colspan="4" align="center" bgcolor="#FFFFFF" class="formulario2"><textarea name="textarea" cols="90" rows="5" readonly><? echo $TxtObs?></textarea></td>
                    </tr>
                  </table></td>
                  <td width="0%" align="center" class="TituloTablaVerde"></td>
                </tr>
                <tr>
                  <td colspan="3"align="center" class="TituloTablaVerde"></td>
                </tr>
              </table>
              <br></td>
            <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
          </tr>
          <tr>
            <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
            <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
            <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
          </tr>
  </table>
	    </td>
 </tr>
</table>
</form>
</body>
</html>