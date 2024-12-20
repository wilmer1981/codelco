<?php 	
	include("../principal/conectar_principal.php");
	$NombreBtn='Grabar';

	if(isset($_REQUEST["Buscar"])){
		$Buscar = $_REQUEST["Buscar"];
	}else{
		$Buscar = 'N';
	}
	if(isset($_REQUEST["CmbNave"])){
		$CmbNave = $_REQUEST["CmbNave"];
	}else{
		$CmbNave = "";
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
		$Consulta = "SELECT * from sec_web.nave where cod_nave='$CmbNave'";
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Resp))
		{
			$TxtCodNave=$Fila["cod_nave"];
			$TxtNomNave=$Fila["nombre_nave"];
			$TxtCodNaviera=$Fila["cod_naviera"];
			$TxtViaTrans=$Fila["cod_via_transporte"];
			$TxtCodBandera=$Fila["cod_bandera"];
			$TxtAnoConstruccion=$Fila["ano_construccion"];			
		}
		$NombreBtn='Modificar';
		$Proceso='M';
	}
	else
	{	
		$CmbNave='S';
		$TxtCodNave='';$TxtNomNave='';$TxtCodNaviera='';$TxtViaTrans='';$TxtCodBandera='';$TxtAnoConstruccion='';
		$Consulta = "SELECT max(cod_nave)+1 as codigo from sec_web.nave";
		$Resp=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);
		$TxtCodNave=$Fila["codigo"];
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
			var digitos = (f.TxtCodNaviera.value).length;
			 
			if (digitos > 4)
			{
				alert ("Debe Ingresar Codigo con max. 4 digitos");
				f.TxtCodNaviera.focus();
				return;
			}
			if (f.TxtViaTrans.value=='')
			{
				alert ("Debe Ingresar Via de Transporte");
				f.TxtViaTrans.focus();
				return;
			}
			
			if(f.TxtNomNave.value!='')
			{
				f.action="sec_programa_loteo_nave01.php?Proceso=G";
				f.submit();
			}
			else
			{
				alert('Debe Ingresar Nombre Nave');
				f.TxtNomNave.focus();
				return;
			}
			break;
		case "M":
		   var digitos = (f.TxtCodNaviera.value).length;
			 
			if (digitos > 4)
			{
				alert ("Debe Ingresar Codigo con max. 4 digitos");
				f.TxtCodNaviera.focus();
				return;
			}
			if(f.TxtNomNave.value!='')
			{
				f.action="sec_programa_loteo_nave01.php?Proceso=M";
				f.submit();
			}
			else
			{
				alert('Debe Ingresar Nombre Nave');
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
			if(f.CmbNave.value!='S')
			{
				if(confirm('Esta Seguro de Eliminar la Nave'))
				{
					f.action="sec_programa_loteo_nave01.php?Proceso=E";
					f.submit();
				}	
			}
			else
			{
				alert('Debe Seleccionar Nave para Eliminar');
				f.CmbNave.focus();
				return;
			}
			break;
	}
}
function Recarga(Opt)
{
	var f=document.frmNaveCliente;
	f.action="sec_programa_loteo_nave.php?Buscar="+Opt;
	f.submit();
		
}
</script>
</head>

<body onload='window.document.frmNaveCliente.TxtNomNave.focus();'>
<form name="frmNaveCliente" action="" method="post" >
<table width="500"  border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333" class="TablaInterior">
  <tr align="center" bgcolor="#FFFFFF" class="ColorTabla01">
    <td colspan="2">
	NAVE</td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td width="100" height="20">Naves Exist.:</td>
    <td width="400" height="20">
	<select name="CmbNave" onKeyDown="TeclaPulsada2('S',false,this.form,'CmbPtoEmbarque');" onChange="Recarga('S')">
      <option value="S" class="NoSelec">SELECCIONAR</option>
      <?php
					$Consulta = "SELECT * from sec_web.nave where cod_nave<>'' order by trim(nombre_nave) ";
					$Resp=mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Resp))
					{
						if ($Fila["cod_nave"]==$CmbNave)
							echo "<option selected value='".$Fila["cod_nave"]."'>".str_pad($Fila["cod_nave"],4,0,STR_PAD_LEFT)." - ".strtoupper($Fila["nombre_nave"])."</option>\n";
						else
							echo "<option value='".$Fila["cod_nave"]."'>".str_pad($Fila["cod_nave"],4,0,STR_PAD_LEFT)." - ".strtoupper($Fila["nombre_nave"])."</option>\n";
					}
				
			?>
    </select></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Cod. Nave: </td>
    <td height="20"><input type="text" name="TxtCodNave" value="<?php echo $TxtCodNave;?>" size="10" readonly="true"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Nombre Nave:</td>
    <td height="20"><input name="TxtNomNave" type="text" id="TxtNomNave" value="<?php echo $TxtNomNave; ?>" size="60"> 
    </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Cod. Naviera: </td>
    <td height="20"><input name="TxtCodNaviera" type="text" id="TxtCodNaviera" value="<?php echo $TxtCodNaviera; ?>" size="10" maxlength="10"> 
    * </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Via Transporte: </td>
    <td height="20"><input name="TxtViaTrans" type="text" id="TxtViaTrans" value="<?php echo $TxtViaTrans; ?>" size="10" maxlength="10"> 
      <strong>(01) 
      </strong></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">Cod Bandera:</td>
    <td height="20"><input name="TxtCodBandera" type="text" id="TxtCodBandera" value="<?php echo $TxtCodBandera; ?>" size="10" maxlength="10">
    *</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="20">A&ntilde;o Construcci&oacute;n:</td>
    <td height="20"><input name="TxtAnoConstruccion" type="text" id="TxtAnoConstruccion" value="<?php echo $TxtAnoConstruccion; ?>" size="10" maxlength="10">
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
