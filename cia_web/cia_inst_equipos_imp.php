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
		$Resp = mysqli_query($link, $Consulta);
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
		$Resp=mysqli_query($link, $Consulta);
		//echo $Consulta;
		if ($Fila =mysql_fetch_array($Resp))
		{
			$CmbUser=$Fila["usuario"];			
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
<script language="javascript">
function Imprimir()
{
	var f=document.frmPrincipal;
	f.BtnImprimir.style.visibility='hidden';
	window.print();
	f.BtnImprimir.style.visibility=''
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
<table width="630" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaInterior">
      <tr align="center">
        <td colspan="2">&nbsp;</td>
		<td colspan="2">INSTALACION DE EQUIPOS </td>
		<td colspan="2" align="right"><input name="BtnImprimir" type="button" value="Imprimir" onClick="Imprimir()"></td>
      </tr>
      <tr>
        <td width="94" rowspan="2">Usuario:</td>
        <td colspan="5">
        <?
		$link = mysql_connect("10.56.11.6","user_conect","perfil7");
		mysql_select_db("bd_rrhh", $link);
		$Consulta = "select * from bd_rrhh.antecedentes_personales where rut='$CmbUser' order by apellido_paterno, apellido_materno, nombres";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			echo $Fila["APELLIDO_PATERNO"]." ".$Fila["APELLIDO_MATERNO"]." ".$Fila["NOMBRES"];
		}
		mysql_close($link);
		?>
		<input type="hidden" name="TxtCodEquipo" value="<? echo $TxtCodEquipo; ?>"></td>
        </tr>
      <tr>
        <td colspan="5"><? echo $TxtUser; ?>
          (otro)</td>
        </tr>
      <tr>
        <td>C.  Costo:</td>
        <td colspan="5">
		<?
			$link = mysql_connect("10.56.11.6","user_conect","perfil7");
			mysql_select_db("bd_rrhh", $link);
			//CONSULTA CC DEL USUARIO
			$Consulta = "select * from bd_rrhh.antecedentes_personales where rut='".$CmbUser."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila=mysql_fetch_array($Resp))
			{
				$CmbCC=$Fila["COD_CENTRO_COSTO"];
			}
			//-----------------------
			$Consulta = "select * from bd_rrhh.centros where COD_CENTRO_COSTO='$CmbCC' order by cod_centro_costo";
			$Resp = mysqli_query($link, $Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				echo $Fila["COD_CENTRO_COSTO"]." - ".$Fila["NOMBRE_CENTRO_COSTO"];
			}
			mysql_close($link);
		?>		
        </td>
        </tr>
      <tr>
        <td>F. de Inst.:</td>
        <td colspan="3"><? echo $TxtFechaIni; ?>&nbsp;</td>
        <td width="93">F. de Retiro: </td>
        <td width="134"><? echo $TxtFechaFin; ?>&nbsp;</td>
      </tr>
      <tr>
        <td>Realizada por:</td>
        <td colspan="3"><? echo $TxtRealizador; ?>&nbsp;</td>
        <td>Internet:</td>
        <td>
<?
	switch ($ChkInternet)
	{
		case "S":
			echo "Si";
			break;
		case "N":
			echo "No";
			break;
	}		
?>
</td>
      </tr>
      <tr>
        <td>Ip:</td>
        <td colspan="3"><? echo $TxtIP; ?>&nbsp;</td>
        <td>Nom. PC:</td>
        <td><? echo $TxtNomPC; ?>&nbsp;</td>
      </tr>
      <tr>
        <td>Nom. User:</td>
        <td colspan="3"><? echo $TxtNomUser; ?>&nbsp;</td>
        <td>Correo:</td>
        <td><? echo $TxtCorreo; ?>&nbsp;</td>
      </tr>
      <tr>
        <td>Pass.Bios.Adm: </td>
        <td width="70"><? echo $TxtBiosAdm; ?>&nbsp;</td>
        <td width="94">Pass.Bios User:</td>
        <td width="76"><? echo $TxtBiosUser; ?>&nbsp;</td>
        <td>Pass. Red User: </td>
        <td><? echo $TxtRedUser; ?></td>
      </tr>
      <tr>
        <td height="26">Configuracion:</td>
        <td align="left" colspan="5">CPU:
          <? echo $TxtCpu; ?>
          (MHZ)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RAM:
          <? echo $TxtRam; ?>
          (MB)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HDD:
          <? echo $TxtHdd; ?>
          (GB)</td>
      </tr>
		<tr>
        <td height="26">Observacion:</td>
        <td colspan="5"><textarea name="TxtObservacion" cols="90" rows="6" wrap="VIRTUAL" class="InputIzq" id="TxtObservacion"><? echo $TxtObservacion; ?></textarea></td>
        </tr>
    </table>
      <br>
      <table width="630" border="1" align="center" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF" class="TablaInterior">
	<?	
		if (isset($TxtCodEquipo) && $TxtCodEquipo!="")
		{
	?>			
        <tr align="center">
          <td width="80">ITEM</td>
          <td width="165">MARCA</td>
          <td width="165">Modelo</td>
          <td width="140">N&deg; SERIE </td>
          <td width="80">UNO</td>
        </tr>
<?	
	include("../principal/conectar_principal.php");
	$Consulta = "select * from ins_equipo.detalle_equipo t1 inner join proyecto_modernizacion.sub_clase t2 on t1.cod_clase=t2.cod_clase and t1.cod_subclase=t2.cod_subclase ";
	$Consulta.= "where t1.cod_equipo='".$TxtCodEquipo."' order by t1.cod_clase";
	$Resp = mysqli_query($link, $Consulta);	
	echo "<input name='ChkDetalle' type='hidden'><input name='TxtSerie' type='hidden'><input name='TxtUno' type='hidden'>";
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Consulta = "select t1.cod_clase, t2.cod_subclase, t1.nombre_clase, t2.nombre_subclase, t2.valor_subclase1";
		$Consulta.= " from proyecto_modernizacion.clase t1 inner join proyecto_modernizacion.sub_clase t2 ";
		$Consulta.= " on t1.cod_clase=t2.cod_clase ";
		$Consulta.= " where t1.cod_clase='".$Fila["cod_clase"]."' and t2.cod_subclase='".$Fila["cod_subclase"]."'";
		$RespAux = mysqli_query($link, $Consulta);
		if ($FilaAux =mysql_fetch_array($RespAux))
		{
			$NomClase=$FilaAux["nombre_clase"];
			$NomSubClase=$FilaAux["nombre_subclase"];
			$ValorSubClase_1=$FilaAux["valor_subclase1"];
		}
		echo "<tr align=\"center\" valign=\"middle\">\n";
		echo "<td>".strtoupper($NomClase)."</td>\n";
		echo "<td>".strtoupper($NomSubClase)."</td>\n";
		echo "<td>".strtoupper($ValorSubClase_1)."</td>\n";
		if($Fila[campo1]=='')
			echo "<td align='left'>$Fila["valor_subclase2"]&nbsp;</td>\n";
		else
			echo "<td align='left'>$Fila[campo1]&nbsp;</td>\n";
		if($Fila["campo2"]=='')
			echo "<td align='left'>$Fila[valor_subclase3]&nbsp;</td>\n";
		else
			echo "<td align='left'>$Fila["campo2"]&nbsp;</td>\n";
		echo "</tr>\n";
	}
	include("../principal/cerrar_principal.php");
?>		
      </table>
      <br>
<?
	}
?>
</form>
</body>
</html>
