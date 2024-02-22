<?php 	
	include("../principal/conectar_principal.php");
	$Regiones=array('I','II','III','IV','V','VI','VII','VIII','IX','XI','XII','RM');	
	$EstTxtCodCliente='';
	$NombreBtn='Grabar';

	if(isset($_REQUEST["Buscar"])){
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = 'N';
	}
	if(isset($_REQUEST["CmbCliente"])){
		$CmbCliente = $_REQUEST["CmbCliente"];
	}else{
		$CmbCliente = "";
	}
	if(isset($_REQUEST["OptClienteNave"])){
		$OptClienteNave = $_REQUEST["OptClienteNave"];
	}else{
		$OptClienteNave = "C";
	}
	/*
	if (!isset($OptClienteNave))
		$OptClienteNave="C";
	*/
	if($Buscar=='S')
	{
		$Consulta = "SELECT * FROM sec_web.cliente_venta WHERE cod_cliente='$CmbCliente'";
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Resp))
		{
			$TxtCodCliente=$Fila["cod_cliente"];
			$TxtSiglaCliente=$Fila["sigla_cliente"];
			$TxtCodRep=$Fila["cod_represent_cliente"];
			$TxtNomRepre=$Fila["nombre_cliente"];
			$TxtRut=$Fila["rut"];
			$TxtDireccion1=$Fila["direccion"];
			$TxtDireccion2=$Fila["direccion2"];
			$TxtFono1=$Fila["fono1"];
			$TxtFono2=$Fila["fono2"];
			$TxtFax=$Fila["fax"];
			$CmbPais=$Fila["cod_pais"];
			$CmbRegion=$Fila["region"];
			$TxtCiudad=$Fila["cod_ciudad"];
			$TxtComuna=$Fila["comuna"];
			$TxtNomContacto=$Fila["nombre_contacto"];
			$TxtObs=$Fila["observacion"];
			$EstTxtCodCliente='readonly';
		}
		$NombreBtn='Modificar';
		$Proceso='M';
	}
	else
	{	
		$CmbNave='S';
		$TxtCodCliente='';$TxtSiglaCliente='';$TxtCodRep='';$TxtNomRepre='';$TxtRut='';
		$TxtDireccion1='';$TxtDireccion2='';$TxtFono1='';$TxtFono2='';$TxtFax='';
		$CmbPais='S';$CmbRegion='S';$TxtCiudad='';$TxtComuna='';$TxtNomContacto='';$TxtObs='';
		$Proceso='G';
	}	
	
?>
<html>
<head>
<title>Nueva - Nave/Cliente</title>
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
			if(f.TxtCodCliente.value!='')
			{
				f.action="sec_programa_loteo_cliente01.php?Proceso=G";
				f.submit();
			}
			else
			{
				alert('Debe Ingresar Codigo Cliente');
				f.TxtNomNave.focus();
				return;
			}
			break;
		case "M":
			if(f.TxtSiglaCliente.value!='')
			{
				f.action="sec_programa_loteo_cliente01.php?Proceso=M";
				f.submit();
			}
			else
			{
				alert('Debe Ingresar Nombre cliente');
				f.TxtNomNave.focus();
				return;
			}
			break;
		case "S":
			window.opener.document.frmProceso.action="sec_programa_loteo_orden_emb.php";
			window.opener.document.frmProceso.submit();
			window.close();
			break;
		case "E":
			if(f.CmbCliente.value!='S')
			{
				if(confirm('Esta Seguro de Eliminar El Cliente'))
				{
					f.action="sec_programa_loteo_cliente01.php?Proceso=E";
					f.submit();
				}	
			}
			else
			{
				alert('Debe Seleccionar Cliente para Eliminar');
				f.CmbNave.focus();
				return;
			}
			break;
	}
}
function Recarga(Opt)
{
	var f=document.frmNaveCliente;
	f.action="sec_programa_loteo_cliente.php?Buscar="+Opt;
	f.submit();
		
}
</script>
</head>
<?php
if($Buscar=='S')
{
?>
<body onload='window.document.frmNaveCliente.TxtSiglaCliente.focus();'>
<?php
}
else
{
?>
<body onload='window.document.frmNaveCliente.TxtCodCliente.focus();'>
<?php
}
?>
<form name="frmNaveCliente" action="" method="post">
<table width="500"  border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
  <tr align="center" bgcolor="#FFFFFF" class="ColorTabla01">
    <td colspan="2">
	CLIENTES</td>
    </tr>
  <tr bgcolor="#FFFFFF">

    <td width="100" height="20">Clientes Exist.:</td>
    <td width="400" height="20"><select name="CmbCliente" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbPtoEmbarque');" onChange="Recarga('S');">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
					$Consulta = "select * from sec_web.cliente_venta where cod_cliente<>'' order by trim(sigla_cliente) ";
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resp))
					{
						if ($Fila["cod_cliente"]==$CmbCliente)
							echo "<option selected value='".$Fila["cod_cliente"]."'>".$Fila["cod_cliente"]." - ".strtoupper($Fila["sigla_cliente"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_cliente"]."'>".$Fila["cod_cliente"]." - ".strtoupper($Fila["sigla_cliente"])."</option>\n";
					}								
			?>
    </select></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">CodCliente:</td>
    <td height="20"><input type="text" name="TxtCodCliente" value="<?php echo $TxtCodCliente;?>" <?php echo $TxtCodCliente;?>></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Sigla Cliente:</td>
    <td height="20"><input type="text" name="TxtSiglaCliente" value="<?php echo $TxtSiglaCliente;?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Cod. Repres_Clie:</td>
    <td height="20"><input type="text" name="TxtCodRep" value="<?php echo $TxtCodRep;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Nombre Cliente :</td>
    <td height="20"><input type="text" name="TxtNomRepre" value="<?php echo $TxtNomRepre;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Rut:</td>
    <td height="20"><input type="text" name="TxtRut" value="<?php echo $TxtRut;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Direcci&oacute;n 1:</td>
    <td height="20"><input type="text" name="TxtDireccion1" value="<?php echo $TxtDireccion1;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Direcci&oacute;n 2:</td>
    <td height="20"><input type="text" name="TxtDireccion2" value="<?php echo $TxtDireccion2;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Fono 1:</td>
    <td height="20"><input type="text" name="TxtFono1" value="<?php echo $TxtFono1;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Fono 2:</td>
    <td height="20"><input type="text" name="TxtFono2" value="<?php echo $TxtFono2;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Fax:</td>
    <td height="20"><input type="text" name="TxtFax" value="<?php echo $TxtFax;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Pais:</td>
    <td height="20">
	<select name="CmbPais" >
	<option value="S" selected>Seleccionar</option>
	<?php
		$Consulta="select * from sec_web.paises order by nombre_pais";
		$RespPais=mysqli_query($link, $Consulta);
		while($FilaPais=mysqli_fetch_array($RespPais))
		{
			if($FilaPais["cod_pais"]==$CmbPais)
				echo "<option value='".$FilaPais["cod_pais"]."' selected>".$FilaPais["nombre_pais"]."</option>";
			else
				echo "<option value='".$FilaPais["cod_pais"]."'>".$FilaPais["nombre_pais"]."</option>";	
		}
	?>
    </select>
	*</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Regi&oacute;n:</td>
    <td height="20">
	<select name="CmbRegion">
	<option value="S" selected>Seleccionar</option>
	<?php
		foreach($Regiones as $c => $v)
		{
			$Codigo=$c+1;
			if($CmbRegion==$Codigo)
				echo "<option value='".$Codigo."' selected>".$v."</option>";
			else
				echo "<option value='".$Codigo."'>".$v."</option>";
		}
	?>
	</select>
	*
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Ciudad:</td>
    <td height="20"><input type="text" name="TxtCiudad" value="<?php echo $TxtCiudad;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Comuna:</td>
    <td height="20"><input type="text" name="TxtComuna" value="<?php echo $TxtComuna;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Nombre Contacto:</td>
    <td height="20"><input type="text" name="TxtNomContacto" value="<?php echo $TxtNomContacto;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Observacion:</td>
    <td height="20"><input type="text" name="TxtObs" size="70" value="<?php echo $TxtObs;?>">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">&nbsp;</td>
    <td height="20">(* Datos no obligatorio ) </td>
  </tr>
  <tr align="center" bgcolor="#efefef">
    <td height="20" colspan="2"><input style="width:70px " name="BtnGrabar" type="button" value="<?php echo $NombreBtn;?>" onClick="Proceso('<?php echo $Proceso;?>')">
      <input style="width:70px " name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" onClick="Proceso('E')">
	      <input style="width:70px " name="BtnCancelar" type="button" value="Cancelar" onClick="Recarga()">
	      <input style="width:70px " name="BtnCerrar" type="button" id="BtnCerrar" value="Cerrar" onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
