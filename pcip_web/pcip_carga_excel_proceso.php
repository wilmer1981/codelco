<? 
include("../principal/conectar_pcip_web.php");
include("funciones/pcip_funciones.php");

if(isset($Opcion)&&$Opcion=='M')
{
	$Datos=explode('~',$Valores);
	$Actualizar="UPDATE pcip_lista_excel set nom_excel='".$Datos[0]."',orden='".intval($Datos[1])."',vigente='".$Datos[2]."',tipo_carga='".$Datos[3]."',ini_fil_cc='".intval($Datos[4])."',";
	$Actualizar.="ini_col_cc='".intval($Datos[5])."',hoja='".intval($Datos[6])."',tipo_excel='".$Datos[7]."',corta_mes='".$Datos[8]."' where cod_excel='".$CmbExcel."'";
	//echo $Actualizar;
	mysql_query($Actualizar);
}	
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Modificar(Cod)
{
	var f= document.FrmPopupProceso;
	var Valores="";
	
	Valores=f.TxtNombre.value+"~"+f.TxtOrden.value+"~"+f.CmbVigente.value+"~"+f.CmbTipoCarga.value+"~"+f.TxtIniFil.value+"~"+f.TxtIniCol.value+"~"+f.TxtHoja.value+"~"+f.CmbTipoExcel.value+"~"+f.CmbCortaMes.value;
	//alert(Valores);
	f.action = "pcip_carga_excel_proceso.php?Opcion=M&Valores="+Valores+"&CmbExcel="+f.CmbExcel.value;
	f.submit();

}
function Recarga(Opt) 
{
	var f=document.FrmPopupProceso;
	f.action='pcip_carga_excel_proceso.php?Recarga=S';
	f.submit();
}
function Salir()
{
	window.close();
}
</script>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #F9F9F9;
}
.Estilo8 {font-size: 11px}
-->
</style></head>

<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPopupProceso" method="post" action="">
<table align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
    <td width="955" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
    <td height="15"><img src="archivos/images/interior/esq2x.gif" width="15" height="15"></td>
  </tr>
  <tr>
    <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="74%" align="left"><img src="archivos/sub_tit_conf_excel.png" width="450" height="40"></td>
        <td align="right">
		<a href=JavaScript:Modificar()><img src='archivos/btn_modificar.png' alt='Modifica Configuraci�n Excel'  border='0' align='absmiddle'></a>
		<a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a>
		</td>
      </tr>
    </table>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td colspan="3"align="center" class="TituloTablaVerde"></td>
          </tr>
          <tr>
            <td width="1%" align="center" class="TituloTablaVerde"></td>
            <td align="center"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" class="ColorTabla02" >
                <tr>
                  <td width="49" class="formulario2">Excel</td>
                  <td width="977" class="FilaAbeja2"><span class="formulario2">
                    <select name="CmbExcel" style="width:250" onchange="Recarga();" >
                      <option value="-1" class="NoSelec">Seleccionar</option>
                      <?
	  	$Consulta = "select * from pcip_lista_excel where tipo_excel in('S','P') order by orden ";
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbExcel==$FilaTC["cod_excel"])
				echo "<option selected value='".$FilaTC["cod_excel"]."'>".ucfirst($FilaTC["nom_excel"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_excel"]."'>".ucfirst($FilaTC["nom_excel"])."</option>\n";
		}
		?>
                    </select>
                  </span></td>
                </tr>
                <tr>
                  <td height="14" colspan="2" class="formulario2"><table width="100%" border="1" cellpadding="0" cellspacing="0" >
                      <tr class="TituloTablaVerde">
                        <td align="center" width="25%"><span class="Estilo8">Nombre Excel </span></td>
                        <td align="center" width="5%"><span class="Estilo8">Orden</span></td>
                        <td align="center" width="5%"><span class="Estilo8">Vigente</span></td>
                        <td align="center" width="5%"><span class="Estilo8">Tipo Carga </span></td>
                        <td align="center" width="5%"><span class="Estilo8">Inicio Fila CC </span></td>
                        <td align="center" width="5%"><span class="Estilo8">Inicio Col. CC </span></td>
                        <td align="center" width="5%"><span class="Estilo8">N&ordm; Hoja </span></td>
                        <td align="center" width="5%"><span class="Estilo8">Tipo Excel </span></td>
                        <td align="center" width="5%"><span class="Estilo8">Corta Mes </span></td>
                      </tr>
                      <?
				$Consulta = "select * from pcip_lista_excel where cod_excel='".$CmbExcel."'order by orden ";
				$Resp=mysql_query($Consulta);
				while ($Fila=mysql_fetch_array($Resp))
				{
					echo "<tr class='FilaAbeja'>";
					echo "<td align='center'><input type='text' name='TxtNombre' value='".$Fila[nom_excel]."' size='90' ></td>";
					echo "<td align='center'><input type='text' name='TxtOrden' value='".$Fila[orden]."' size='3' ></td>";
					echo "<td align='center'>";
					echo "<select name='CmbVigente'>";
					switch($Fila[vigente])
					{
						case "S":
							echo "<option value='S' selected>S</option>";
							echo "<option value='N'>N</option>";
						break;
						case "N":
							echo "<option value='S' >S</option>";
							echo "<option value='N' selected>N</option>";
						break;
						default:
							echo "<option value='S' selected>S</option>";
							echo "<option value='N'>N</option>";
					}
					echo "</select></td>";
					echo "<td align='center'>";
					echo "<select name='CmbTipoCarga'>";
					switch($Fila[tipo_carga])
					{
						case "A":
							echo "<option value='A' selected>Anual</option>";
							echo "<option value='M'>Mensual</option>";
						break;
						case "M":
							echo "<option value='A' >Anual</option>";
							echo "<option value='M' selected>Mensual</option>";
						break;
						default:
							echo "<option value='A' selected>Anual</option>";
							echo "<option value='M'>Mensual</option>";
					}
					echo "</select></td>";
					echo "<td align='center'><input type='text' name='TxtIniFil' value='".$Fila[ini_fil_cc]."' size='3' onkeydown='TeclaPulsada(false)' maxlength='3'></td>";
					echo "<td align='center'><input type='text' name='TxtIniCol' value='".$Fila[ini_col_cc]."' size='3' onkeydown='TeclaPulsada(false)' maxlength='3'></td>";
					echo "<td align='center'><input type='text' name='TxtHoja' value='".$Fila[hoja]."' size='3' onkeydown='TeclaPulsada(false)' maxlength='1'></td>";
					echo "<td align='center'>";
					echo "<select name='CmbTipoExcel'>";
					switch($Fila[tipo_excel])
					{
						case "S":
							echo "<option value='S' selected>Suministro</option>";
							echo "<option value='P'>Pre-Suministro</option>";
						break;
						case "P":
							echo "<option value='S' >Suministro</option>";
							echo "<option value='P' selected>Pre-Suministro</option>";
						break;
						default:
							echo "<option value='S' selected>Suministro</option>";
							echo "<option value='P'>Pre-Suministro</option>";
					}
					echo "</select></td>";
					echo "<td align='center'>";
					echo "<select name='CmbCortaMes'>";
					switch($Fila[corta_mes])
					{
						case "S":
							echo "<option value='S' selected>S</option>";
							echo "<option value='N'>N</option>";
						break;
						case "N":
							echo "<option value='S' >S</option>";
							echo "<option value='N' selected>N</option>";
						break;
						default:
							echo "<option value='S' selected>S</option>";
							echo "<option value='N'>N</option>";
					}
					echo "</select></td>";
					echo "</tr>";
				}
			  ?>
                  </table></td>
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
    <td height="1" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
</table>
</form>		
</body>
</html>
