<?php
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
set_time_limit(1000);
//echo "MENSAJE:".$Mensaje;
$Consulta="Select t2.email,t1.rut_empresa,t1.cod_contrato,t1.fecha_inicio,t1.fecha_termino,t1.rut_adm_contratista from sget_contratos t1 left join sget_administrador_contratistas t2 on t1.rut_adm_contratista=t2.rut_adm_contratista where t1.cod_contrato='".$Ctto."' and t1.rut_empresa='".$Empresa."'";
$Resp1= mysql_query($Consulta);
if($Fila1 = mysql_fetch_array($Resp1))
{
	$RutEmpresa=$Fila1[rut_empresa];
	$Contrato=$Fila1["cod_contrato"];
	$AdmContratista=$Fila1[rut_adm_contratista];
	$FechaInicio=$Fila1[fecha_inicio];
	$FechaTermino=$Fila1[fecha_termino];
	$VarEmp=DescripEmpresa($Fila1[rut_empresa]);
	$array=explode('~',$VarEmp);
	$RazonSocial=FormatearNombre($array[1]);
	$EMail=strtolower($Fila1[email]);
	
}
$Borrar="delete from sget_datos_excel";
mysql_query($Borrar);
$Contrato=str_replace('/','',$Contrato);
//$Contrato=str_replace(""\"",'',$Contrato);
$Insertar="INSERT INTO sget_datos_excel(rut_empresa,cod_contrato,razon_social,fecha_inicio,fecha_termino)";
$Insertar.="value('".$RutEmpresa."','".trim($Contrato)."','".$RazonSocial."','".$FechaInicio."','".$FechaTermino."')";
mysql_query($Insertar);
//echo $Insertar;
$Consulta="Select * from sget_ruta_archivo where rut='".$CookieRut."'";
$Resp0= mysql_query($Consulta);
if($Fila0 = mysql_fetch_array($Resp0))
{
$RutaOrigen=$Fila0["origen"];//'C:\SGEPVB';
$RutaDestino=$Fila0[destino];
//'Z:\Apache2\htdocs\proyecto\sget_web\archivos';
}
 
if(!isset($Mensaje))
{
?>
<script language="vbscript">
set taskmgr = GetObject("winmgmts:{impersonationLevel=impersonate}").ExecQuery ("SELECT * from Win32_Process")//Obtienes acceso a los procesos
For each process in taskmgr 
//Document.Write(Lcase(process.name)+"<br>")
If Lcase(process.name) = "EXCEL.EXE" or Lcase(process.name) = "excel.exe" then
	Process.terminate
End If 
Next

Set WShell = CreateObject("WScript.Shell")
WShell.Run "<? echo $RutaOrigen."\GeneraExcel.exe";?>"
</script>
<?
}
?>
<script language="JavaScript">
function Procesos(TipoProceso)
{
var f= document.frmgeneraexcel;
	switch(TipoProceso)
	{
		case "S":
			window.close();
		break;
			case "EV":
		        f.action="sget_genera_excel01.php";
	            f.submit();
		break;
	}
}
</script><head><title>Envio Excel</title></head>	

<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">		
<form name="frmgeneraexcel" action="" method="post">
<input name="Ctto" type="hidden" id="Ctto" value="<? echo $Ctto; ?>"> 
<input name="Empresa" type="hidden" id="Empresa" value="<? echo $Empresa; ?>"> 
 <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="1196" height="15"background="archivos/images/interior/form_arriba.gif"> <img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>

   <td>
		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		<td align="right"><a href="JavaScript:Procesos('S')"><img src="archivos/close.png" alt="Salir" border="0" align="absmiddle" ></a></td>
		</tr>
		<tr>
		<td>
		
		</td>
		</tr>
		<tr>
		<td><span class="LinkPestana">Contrato <? echo $Contrato;?></span></td>
		</tr>
		<tr>
		<td><span class="LinkPestana">Contrase&ntilde;a de Red 
		  <label>
		  <input name="txtpassword" type="password" class="InputIni" value="<? echo $txtpassword;?>" size="15" maxlength="15">
		  </label>
		</span></td>
		</tr>

		<tr>
		<td>
		<?
	   $VarContratista=AdmCttoContratista($Ctto);
	   $array=explode('~',$VarContratista);
		?>
		<span class="LinkPestana">Enviar archivo a <? echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);  ?>, Correo</span> 
		  <input name="EMail" type="text" id="EMail" value="<? echo $EMail; ?>" size="70">&nbsp;<a href="JavaScript:Procesos('EV')"><img src="archivos/email.png" alt="Enviar por Correo" border="0" align="absmiddle" ></a></td>
		</tr>
		<tr>
		<td><span class="LinkPestana">Descargar Archivo</span>&nbsp;<a href="<? echo "excel_generado/".$Contrato.".xls";?>"><img src="archivos/excel.png" alt="Descargar Excel" border="0" align="absmiddle"></a></td>
		</tr>
	  </table>
  </td>
  <td width="20" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="20" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
</table>
</form>
<? 
if($Mensaje!='')
{
?>
<script language="JavaScript">
alert('<? echo $Mensaje;?>');
window.close();
</script>
<?
}
?>