<?
	if (!isset($TxtIP) || $TxtIP=="")
		$TxtIP="192.168.5";
	if (!isset($TxtFechaIni) || $TxtFechaIni=="")
		$TxtFechaIni=date("Y-m-d");
	if (!isset($TxtRealizador) || $TxtRealizador=="")
		$TxtRealizador="D.V.S. Ingenieria Ltda.";
	if ($TxtNomUser=="" && $CmbUser!="S")
	{
		$link = mysql_connect("10.56.11.6","user_conect","perfil7");
		mysql_select_db("bd_rrhh", $link);
		$Consulta = "select * from bd_rrhh.antecedentes_personales where rut='".$CmbUser."' order by apellido_paterno, apellido_materno, nombres";
		$Resp = mysql_query($Consulta);
		if ($Fila=mysql_fetch_array($Resp))
		{
			$TxtNomUser=strtoupper(substr($Fila["NOMBRES"],0,1).$Fila["APELLIDO_PATERNO"]);
			if ($TxtNomPC=="")
				$TxtNomPC=$TxtNomUser;
			if ($TxtCorreo=="")
				$TxtCorreo=$TxtNomUser;
		}
		mysql_close($link);
	}
	if ($TxtCodEquipo!="" && isset($TxtCodEquipo))
	{
		include("../principal/conectar_principal.php");
		$Consulta = "SELECT * FROM ins_equipo.`equipo` where cod_equipo='".$TxtCodEquipo."'";
		$Resp=mysql_query($Consulta);
		//echo $Consulta;
		if ($Fila =mysql_fetch_array($Resp))
		{
			$CmbUser=$Fila["usuario"];
			$TxtUser=$Fila["usuario"];
			$ChkValida=$Fila["validado"];				
			$CmbCC=$Fila["centro_costo"];
			$TxtFechaIni=$Fila["fecha_instalacion"];
			$TxtRealizador=$Fila["realizador"];
			$TxtIP=$Fila["ip"];
			$TxtNomPC=$Fila["nom_pc"];
			$TxtNomUser=$Fila["nom_user"];
			$TxtCorreo=$Fila["correo"];
			$TxtBiosAdm=$Fila["pass_bios_adm"];
			$TxtBiosUser=$Fila["pass_bios_user"];
			$TxtRedUser=$Fila["pass_red_user"];
			$TxtObservacion=$Fila["observacion"];
			$TxtFechaFin=$Fila["fecha_retiro"];			
			$ChkInternet=$Fila["internet"];
			$TxtCpu=$Fila["cpu"];			
			$TxtRam=$Fila["ram"];			
			$TxtHdd=$Fila["hdd"];						
		}
		include("../principal/cerrar_principal.php");
	}
	
?>
<html>
<head>
<title>Instalacion de Equipos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="javascript">
function AgregaDetalle()
{
	var f=document.frmPrincipal;
	window.open("cia_inst_equipos_agrega_det.php?CodEquipo="+f.TxtCodEquipo.value,"","top=120,left=100, width=450, height=300,scrollbars=yes,resizable=yes");
}
function BuscarEquipo()
{
	var f=document.frmPrincipal;
	window.open("cia_inst_equipos_buscar.php?Valida=T","","top=50,left=50, width=600px, height=450,scrollbars=yes,resizable=yes");
}
function Imprimir()
{
	var f=document.frmPrincipal;
	window.open("cia_inst_equipos_imp.php?TxtCodEquipo="+f.TxtCodEquipo.value,"","top=5,left=5, width=650px, height=550,scrollbars=yes,resizable=yes");
}

function Recarga()
{
	var f=document.frmPrincipal;
	window.location="cia_inst_equipos.php?CmbUser="+f.CmbUser.value;
	//f.submit();
}


function GrabaDetalle()
{
	var f=document.frmPrincipal;
	var Valores='';
	
	if (f.CmbUser.value=="S" && f.TxtUser.value=="")
	{
		alert("Debe Seleccionar un Usuario o Ingresarlo si no Existe/nO debe Seleccionar si esta de BAJA o en Espera de Asignacion");
		f.CmbUser.focus();
		return;
	}
	for(i=1;i<f.ChkDetalle.length;i++)
	{
		Valores=Valores+f.ChkDetalle[i].value+"~"+f.TxtSerie[i].value+"~"+f.TxtUno[i].value+"//";
	}
	Valores=Valores.substr(0,Valores.length-2);
	//alert(Valores);	
	f.action="cia_inst_equipos01.php?Proceso=GD&Valores="+Valores;
	f.submit();
}

function GrabaCabecera()
{
	var f=document.frmPrincipal;
	if (f.CmbUser.value=="S" && f.TxtUser.value=="")
	{
		alert("Debe Seleccionar un Usuario o Ingresarlo si no Existe/nO debe Seleccionar si esta de BAJA o en Espera de Asignacion");
		f.CmbUser.focus();
		return;
	}
	f.action="cia_inst_equipos01.php?Proceso=G";
	f.submit();
}

function Salir()
{
	var f=document.frmPrincipal;
	window.location="../principal/sistemas_usuario.php?CodSistema=18&Nivel=0";
}
function EliminarReg()
{
	var f=document.frmPrincipal;
	
	if (f.ChkSelec.value=="")
	{
		alert("No hay nada Seleccionado para ELIMINAR");
		return;
	}
	if (confirm("�Seguro que desea Eliminar?"))
	{
		f.action = "cia_inst_equipos01.php?Proceso=E&Valores="+f.ChkSelec.value;
		f.submit();
	}
	else
	{
		return;
	}
}
function Seleccionar(obj)
{
	var f=document.frmPrincipal;
	f.ChkSelec.value=obj.value;
}
</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="ChkSelec" value="">
<table width="720" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaPrincipal">
  <tr>
    <td><table width="700" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaInterior">
      <tr align="center">
        <td colspan="6" class="ColorTabla01">INSTALACION DE EQUIPOS </td>
      </tr>
      <tr>
        <td width="99" rowspan="2">Usuario:</td>
        <td colspan="3"><select name="CmbUser" onChange="Recarga()" style="width:300px ">
          <option value="S">SELECCIONAR</option>
          <?
	$link = mysql_connect("10.56.11.6","user_conect","perfil7");
	mysql_select_db("bd_rrhh", $link);
	$Consulta = "select * from bd_rrhh.antecedentes_personales order by apellido_paterno, apellido_materno, nombres";
	$Resp = mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($CmbUser==$Fila["RUT"])	
			echo "<option selected value='".$Fila["RUT"]."'>".$Fila["APELLIDO_PATERNO"]." ".$Fila["APELLIDO_MATERNO"]." ".$Fila["NOMBRES"]."</option>\n";
		else
			echo "<option value='".$Fila["RUT"]."'>".$Fila["APELLIDO_PATERNO"]." ".$Fila["APELLIDO_MATERNO"]." ".$Fila["NOMBRES"]."</option>\n";
	}
	mysql_close($link);
?>
        </select><input type="hidden" name="TxtCodEquipo" value="<? echo $TxtCodEquipo; ?>"></td>
        <td rowspan="3">Datos Validados: </td>
        <td rowspan="3">
<?
	switch ($ChkValida)
	{
		case "S":
			echo "<input checked name=\"ChkValida\" type=\"radio\" value=\"S\">SI<br>";
			echo "<input name=\"ChkValida\" type=\"radio\" value=\"\">NO<br>";
			echo "<input name=\"ChkValida\" type=\"radio\" value=\"P\">OBSERVACION";
			break;
		case "":
			echo "<input name=\"ChkValida\" type=\"radio\" value=\"S\">SI<br>";
			echo "<input checked name=\"ChkValida\" type=\"radio\" value=\"\">NO<br>";
			echo "<input name=\"ChkValida\" type=\"radio\" value=\"P\">OBSERVACION";
			break;
		case "P":
			echo "<input name=\"ChkValida\" type=\"radio\" value=\"S\">SI<br>";
			echo "<input name=\"ChkValida\" type=\"radio\" value=\"\">NO<br>";
			echo "<input checked name=\"ChkValida\" type=\"radio\" value=\"P\">OBSERVACION";
			break;
		default:
			echo "<input checked name=\"ChkValida\" type=\"radio\" value=\"S\">SI<br>";
			echo "<input name=\"ChkValida\" type=\"radio\" value=\"\">NO<br>";
			echo "<input name=\"ChkValida\" type=\"radio\" value=\"P\">OBSERVACION";
			break;
	}
?>
		  </td>
      </tr>
      <tr>
        <td colspan="3"><input name="TxtUser" type="text" class="InputDer" id="TxtUser" value="<? echo $TxtUser; ?>" size="50">
          (otro)</td>
        </tr>
      <tr>
        <td>C.  Costo:</td>
        <td colspan="3"><select name="CmbCC" style="width:300px ">
		<option value="S">SELECCIONAR</option>
<?
	$link = mysql_connect("10.56.11.6","user_conect","perfil7");
	mysql_select_db("bd_rrhh", $link);
	//CONSULTA CC DEL USUARIO
	$Consulta = "select * from bd_rrhh.antecedentes_personales where rut='".$CmbUser."'";
	$Resp = mysql_query($Consulta);
	if ($Fila=mysql_fetch_array($Resp))
	{
		$CmbCC=$Fila["COD_CENTRO_COSTO"];
	}
	//-----------------------
	$Consulta = "select * from bd_rrhh.centros order by cod_centro_costo";
	$Resp = mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($CmbCC==$Fila["COD_CENTRO_COSTO"])	
			echo "<option selected value='".$Fila["COD_CENTRO_COSTO"]."'>".$Fila["COD_CENTRO_COSTO"]." - ".$Fila["NOMBRE_CENTRO_COSTO"]."</option>\n";
		else
			echo "<option value='".$Fila["COD_CENTRO_COSTO"]."'>".$Fila["COD_CENTRO_COSTO"]." - ".$Fila["NOMBRE_CENTRO_COSTO"]."</option>\n";
	}
	mysql_close($link);
?>		
        </select></td>
        </tr>
      <tr>
        <td>F. de Inst.:</td>
        <td colspan="3"><input name="TxtFechaIni" type="text" class="InputCen" value="<? echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
          <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> </td>
        <td width="89">F. de Retiro: </td>
        <td width="167"><input name="TxtFechaFin" type="text" class="InputCen" value="<? echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
          <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false"> </td>
      </tr>
      <tr>
        <td>Realizada por:</td>
        <td colspan="3"><input name="TxtRealizador" type="text" class="InputIzq" id="TxtRealizador" value="<? echo $TxtRealizador; ?>" size="50" maxlength="100"></td>
        <td>Internet:</td>
        <td>
<?
	switch ($ChkInternet)
	{
		case "S":
			echo "<input checked name=\"ChkInternet\" type=\"radio\" value=\"S\">Si&nbsp;&nbsp;";
			echo "<input name=\"ChkInternet\" type=\"radio\" value=\"N\">No";
			break;
		case "N":
			echo "<input name=\"ChkInternet\" type=\"radio\" value=\"S\">Si&nbsp;&nbsp;";
			echo "<input name=\"ChkInternet\" type=\"radio\" value=\"N\" checked>No";
			break;
		case "":
			echo "<input name=\"ChkInternet\" type=\"radio\" value=\"S\">Si&nbsp;&nbsp;";
			echo "<input name=\"ChkInternet\" type=\"radio\" value=\"N\" checked>No";
			break;
	}		
?>
</td>
      </tr>
      <tr>
        <td>Ip:</td>
        <td colspan="3"><input name="TxtIP" type="text" class="InputCen" id="TxtIP" value="<? echo $TxtIP; ?>"></td>
        <td>Nom. PC:</td>
        <td><input name="TxtNomPC" type="text" class="InputIzq" id="TxtNomPC" value="<? echo $TxtNomPC; ?>" size="35"></td>
      </tr>
      <tr>
        <td>Nom. User:</td>
        <td colspan="3"><input name="TxtNomUser" type="text" class="InputIzq" id="TxtNomUser" value="<? echo $TxtNomUser; ?>" size="50"></td>
        <td>Correo:</td>
        <td><input name="TxtCorreo" type="text" class="InputIzq" id="TxtCorreo" value="<? echo $TxtCorreo; ?>" size="35"></td>
      </tr>
      <tr>
        <td>Pass.Bios.Adm: </td>
        <td width="94"><input name="TxtBiosAdm" type="text" class="InputIzq" id="TxtBiosAdm" value="<? echo $TxtBiosAdm; ?>" size="12" maxlength="10"></td>
        <td width="125">Pass.Bios User </td>
        <td width="87"><input name="TxtBiosUser" type="text" class="InputIzq" id="TxtBiosUser2" value="<? echo $TxtBiosUser; ?>" size="12" maxlength="10"></td>
        <td>Pass. Red User: </td>
        <td>          <input name="TxtRedUser" type="text" class="InputIzq" id="TxtRedUser" value="<? echo $TxtRedUser; ?>" size="14" maxlength="13"></td>
      </tr>
      <tr class="Detalle03">
        <td height="26">Configuracion:</td>
        <td align="center" colspan="5">CPU:
          <input name="TxtCpu" type="text" class="InputDer" value="<? echo $TxtCpu; ?>" size="6" maxlength="4">
          (MHZ)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RAM:
          <input name="TxtRam" type="text" class="InputDer" value="<? echo $TxtRam; ?>" size="4" maxlength="4">
          (MB)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HDD:
          <input name="TxtHdd" type="text" class="InputDer" value="<? echo $TxtHdd; ?>" size="4" maxlength="4">
          (GB)</td>
      </tr>
		<tr>
        <td height="26">Observacion:</td>
        <td colspan="5"><textarea name="TxtObservacion" cols="90" rows="4" wrap="VIRTUAL" class="InputIzq" id="TxtObservacion"><? echo $TxtObservacion; ?></textarea></td>
        </tr>
    </table>
      <br>
      <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaInterior">
        <tr align="center">
		    <td colspan="6">
			<input name="BtnGrabar" type="button" value="Grabar Cabecera" onClick="GrabaCabecera()" style="width:110px ">            
			<input name="BtnGrabar" type="button" value="Grabar Detalle" onClick="GrabaDetalle()" style="width:110px ">
			<input name="BtnBuscar" type="button" value="Buscar" onClick="BuscarEquipo()" style="width:70px ">
			<input name="BtnImprimir" type="button" value="Imprimir" onClick="Imprimir()" style="width:70px ">            
<?	
	if (isset($TxtCodEquipo) && $TxtCodEquipo!="")
	{	
		echo "<input name=\"BtnAgregar\" type=\"button\" value=\"Agregar\" onClick=\"AgregaDetalle()\" style=\"width:70px\">";
		echo "<input name=\"BtnEliminar\" type=\"button\" value=\"Eliminar\" style=\"width:70px\" onClick=\"EliminarReg()\">";
	}
?>			
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Salir()"></td>
        </tr>
<?	
	if (isset($TxtCodEquipo) && $TxtCodEquipo!="")
	{
?>			
        <tr align="center" class="ColorTabla01">
          <td width="12">&nbsp;</td>
          <td width="108">ITEM</td>
          <td width="125">MARCA</td>
          <td width="115">MODELO</td>
          <td width="150">DATO 1 </td>
          <td width="104">DATO 2 </td>
        </tr>
<?	
	include("../principal/conectar_principal.php");
	$Consulta = "select * from ins_equipo.detalle_equipo t1 inner join proyecto_modernizacion.sub_clase t2 on t1.cod_clase=t2.cod_clase and t1.cod_subclase=t2.cod_subclase ";
	$Consulta.= "where t1.cod_equipo='".$TxtCodEquipo."' order by t1.cod_clase";
	$Resp = mysql_query($Consulta);	
	echo "<input name='ChkDetalle' type='hidden'><input name='TxtSerie' type='hidden'><input name='TxtUno' type='hidden'>";
	while ($Fila=mysql_fetch_array($Resp))
	{
		$ValorRadio=$Fila[cod_equipo].'~'.$Fila[cod_clase].'~'.$Fila["cod_subclase"];
		$Consulta = "select t1.cod_clase, t2.cod_subclase, t1.nombre_clase, t2.nombre_subclase, t2.valor_subclase1";
		$Consulta.= " from proyecto_modernizacion.clase t1 inner join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t1.cod_clase=t2.cod_clase ";
		$Consulta.= " where t1.cod_clase='".$Fila["cod_clase"]."' and t2.cod_subclase='".$Fila["cod_subclase"]."'";
		$RespAux = mysql_query($Consulta);
		if ($FilaAux =mysql_fetch_array($RespAux))
		{
			$NomClase=$FilaAux["nombre_clase"];
			$NomSubClase=$FilaAux["nombre_subclase"];
			$ValorSubClase_1=$FilaAux["valor_subclase1"];
		}
		echo "<tr align=\"center\" valign=\"middle\">\n";
		echo "<td><input name=\"ChkDetalle\" type=\"radio\" value=\"".$ValorRadio."\" onClick=\"Seleccionar(this)\"></td>\n";
		echo "<td>".strtoupper($NomClase)."</td>\n";
		echo "<td>".strtoupper($NomSubClase)."</td>\n";
		echo "<td>".strtoupper($ValorSubClase_1)."</td>\n";
		if($Fila[campo1]=='')
			echo "<td><input name=\"TxtSerie\" type=\"text\" class=\"InputIzq\" size=\"22\" maxlength=\"30\" value='$Fila[valor_subclase2]'></td>\n";
		else
			echo "<td><input name=\"TxtSerie\" type=\"text\" class=\"InputIzq\" size=\"22\" maxlength=\"30\" value='$Fila[campo1]'></td>\n";
		if($Fila["campo2"]=='')
			echo "<td><input name=\"TxtUno\" type=\"text\" class=\"InputIzq\" size=\"15\" maxlength=\"30\" value='$Fila[valor_subclase3]'></td>\n";
		else
			echo "<td><input name=\"TxtUno\" type=\"text\" class=\"InputIzq\" size=\"15\" maxlength=\"30\" value='$Fila["campo2"]'></td>\n";
		echo "</tr>\n";
	}
	include("../principal/cerrar_principal.php");
?>		
      </table>
      <br>      </td>
  </tr>
</table>
<?
	}
?>
</form>
</body>
</html>
