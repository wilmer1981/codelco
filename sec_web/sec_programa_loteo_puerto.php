<?php 	
	include("../principal/conectar_principal.php");
	$NombreBtn='Grabar';

	if(isset($_REQUEST["Buscar"])){
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = 'N';
	}
	$CmbPtoDestino = isset($_REQUEST["CmbPtoDestino"])?$_REQUEST["CmbPtoDestino"]:"";
	$OptClienteNave = isset($_REQUEST["OptClienteNave"])?$_REQUEST["OptClienteNave"]:"C";
	$TxtCodPuerto = isset($_REQUEST["TxtCodPuerto"])?$_REQUEST["TxtCodPuerto"]:"";
	$TxtNomPuerto = isset($_REQUEST["TxtNomPuerto"])?$_REQUEST["TxtNomPuerto"]:"";
	$TxtCodTransp = isset($_REQUEST["TxtCodTransp"])?$_REQUEST["TxtCodTransp"]:"";
	$TxtCodPtoCentral = isset($_REQUEST["TxtCodPtoCentral"])?$_REQUEST["TxtCodPtoCentral"]:"";
	$TxtCodCiudad = isset($_REQUEST["TxtCodCiudad"])?$_REQUEST["TxtCodCiudad"]:"";
	$TxtCodPais = isset($_REQUEST["TxtCodPais"])?$_REQUEST["TxtCodPais"]:"";
	$TxtEta     = isset($_REQUEST["TxtEta"])?$_REQUEST["TxtEta"]:"";

	if($Buscar=='S')
	{
		$Consulta = "select * from sec_web.puertos where cod_puerto='$CmbPtoDestino'";
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Resp))
		{
			$TxtCodPuerto=$Fila["cod_puerto"];
			$TxtNomPuerto=$Fila["nom_aero_puerto"];
			$TxtCodTransp=$Fila["cod_v_transp"];
			$TxtCodCiudad=$Fila["cod_ciudad"];
			$TxtCodPtoCentral=$Fila["cod_puerto_central"];
			$TxtCodPais=$Fila["cod_pais"];			
			$TxtEta=$Fila["eta_programada"];			
		}
		$NombreBtn='Modificar';
		$Proceso='M';
	}
	else
	{	
		$CmbPtoDestino='S';
		$TxtCodPuerto='';$TxtNomPuerto='';$TxtCodTransp='';$TxtCodCiudad='';$TxtCodPtoCentral='';
		$TxtCodPais='';$TxtEta='';	
		$Proceso='G';
	}	
?>
<html>
<head>
<title>Nuevo - Puerto Destino</title>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style>
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmNaveCliente;
	switch (opt)
	{
		case "G":
			if (f.TxtCodPuerto.value=='')
			{
				alert ("Debe Ingresar Codigo Puerto");
				f.TxtCodPuerto.focus();
				return;
			}
			if(f.TxtNomPuerto.value!='')
			{
				f.action="sec_programa_loteo_puerto01.php?Proceso=G";
				f.submit();
			}
			else
			{
				alert('Debe Ingresar Nombre Puerto');
				f.TxtNomPuerto.focus();
				return;
			}
			break;
		case "M":
			if(f.TxtNomPuerto.value!='')
			{
				f.action="sec_programa_loteo_Puerto01.php?Proceso=M";
				f.submit();
			}
			else
			{
				alert('Debe Ingresar Nombre Puerto');
				f.TxtNomPuerto.focus();
				return;
			}
			break;
		case "S":
			window.opener.document.frmProceso.action="sec_programa_loteo_orden_emb.php";
			window.opener.document.frmProceso.submit();
			window.close();
			break;
		case "E":
			if(f.CmbPtoDestino.value!='S')
			{
				if(confirm('Esta Seguro de Eliminar Puerto'))
				{
					f.action="sec_programa_loteo_puerto01.php?Proceso=E";
					f.submit();
				}	
			}
			else
			{
				alert('Debe Seleccionar Puerto para Eliminar');
				f.CmbPtoDestino.focus();
				return;
			}
			break;
	}
}
function Recarga(Opt)
{
	var f=document.frmNaveCliente;
	f.action="sec_programa_loteo_puerto.php?Buscar="+Opt;
	f.submit();
		
}
</script>
</head>

<body onload='window.document.frmNaveCliente.TxtCodPuerto.focus();'>
<form name="frmNaveCliente" action="" method="post" >
<table width="500"  border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
  <tr align="center" bgcolor="#FFFFFF" class="ColorTabla01">
    <td colspan="2">
	PUERTO DESTINO </td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td width="108" height="20">Pto. Exist.:</td>
    <td width="378" height="20">	<select name="CmbPtoDestino" id="select3" onkeydown="TeclaPulsada2('S',false,this.form,'TxtDescripcion');" onChange="Recarga('S')">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
				$Consulta = "select * from sec_web.puertos order by trim(nom_aero_puerto) ";
				$Resp=mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Resp))
				{
					if ($Fila["cod_puerto"]==$CmbPtoDestino)
						echo "<option selected value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]." - ".strtoupper($Fila["nom_aero_puerto"])."</option>\n";
					else
						echo "<option value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]." - ".strtoupper($Fila["nom_aero_puerto"])."</option>\n";
				}
			?>
    </select></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Cod. Puerto: </td>
    <td height="20">
	<?php
	if($Proceso=='M')
	{
	?>
		<input type="text" name="TxtCodPuerto" value="<?php echo $TxtCodPuerto;?>" size="10" readonly="true">
	<?php
	}
	else
	{
	?>
	<input type="text" name="TxtCodPuerto" value="<?php echo $TxtCodPuerto;?>" size="10">
	<?php
	}
	?>	
		</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Nombre Puerto:</td>
    <td height="20"><input name="TxtNomPuerto" type="text" value="<?php echo $TxtNomPuerto; ?>" size="60"> 
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Cod. Puerto Central: </td>
    <td height="20"><input name="TxtCodPtoCentral" type="text"  value="<?php echo $TxtCodPtoCentral; ?>" size="10" maxlength="10"> 
    * </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Cod. Transp : </td>
    <td height="20"><input name="TxtCodTransp" type="text"  value="<?php echo $TxtCodTransp; ?>" size="10" maxlength="10"> 
      <strong>*</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Cod Ciudad:</td>
    <td height="20"><input name="TxtCodCiudad" type="text" value="<?php echo $TxtCodCiudad; ?>" size="10" maxlength="10">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Cod. Pais :</td>
    <td height="20"><input name="TxtCodPais" type="text" value="<?php echo $TxtCodPais; ?>" size="10" maxlength="10">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Eta Programada  :</td>
    <td height="20"><input name="TxtEta" type="text" value="<?php echo $TxtEta; ?>" size="10" maxlength="10">
    *</td>
  </tr>

  <tr bgcolor="#FFFFFF">
    <td height="20">&nbsp;</td>
    <td height="20">(* Datos no obligatorios)</td>
  </tr>
  <tr align="center" bgcolor="#efefef">
    <td height="20" colspan="2">
	<input style="width:70px " name="BtnGrabar" type="button" value="<?php echo $NombreBtn?>" onClick="Proceso('<?php echo $Proceso;?>')">
    <input style="width:70px " name="BtnEliminar" type="button" value="Eliminar" onClick="Proceso('E')">
	<input style="width:70px " name="BtnCancelar" type="button" value="Cancelar" onClick="Recarga()">
	<input style="width:70px " name="BtnCerrar" type="button" value="Cerrar" onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
