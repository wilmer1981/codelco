<?php
$CodigoDeSistema=18;
$CodigoDePantalla=1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<!--------------------------------------- Estilos ----------------------------------------->
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color:#FFFF00;
	text-align:center;
	text-decoration:none;
}

a:link{
	color:#FFFF00;
}	

a:hover{
	color:#FFFF00;
}

a:visited{
	color:#FFFF00;
}

a:active{
	color:#FFFFFF;
}
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>CIA WEB</title>
<!--------------------------------------- JavaScript -------------------------------------->
<script language="JavaScript">
function validar()
{
	//se validan los datos ingresados
	var f=document.frmIngresoEquipo;
	if(f.tipo.value==0)
	{
		alert("Debe seleccionar el tipo de equipo");
		f.tipo.focus();
		return false;
	}
	if(f.nro_serie.value=="")
	{
		alert("Debe ingresar el Número de Serie del equipo");
		f.nro_serie.focus();
		return false;
	}
	if(f.cmbMarca.value==0)
	{
		alert("Debe ingresar la Marca del equipo");
		f.cmbMarca.focus();
		return false;
	}
	if(f.cmbModelo.value==0)
	{
		alert("Debe ingresar el Modelo del equipo");
		f.cmbModelo.focus();
		return false;
	}
	/*if(f.fecha_compra.value!="")
	{
		//se valida la fecha
		var dia,mes,ano,foobar;
		foobar=new Array();
		foobar=f.fecha_compra.value.split("-");
		dia=foobar[0];
		mes=foobar[1];
		ano=foobar[2];
		if(isNaN(dia) || dia < 1 || dia.toString().length > 2)
		{
			alert("El dia ingresado no es valido");
			f.fecha_compra.focus();
			return false;
		}
		if(isNaN(mes) || mes < 1 || mes.toString().length > 2)
		{
			alert("El mes ingresado no es valido");
			f.fecha_compra.focus();
			return false;
		}
		if(isNaN(ano) || ano < 1 || ano.toString().length < 4)
		{
			alert("El año ingresado no es valido");
			f.fecha_compra.focus();
			return false;
		}
	}
	else
	{
		alert("Debe ingresar una Fecha de Compra");
		f.fecha_compra.focus();
		return false;
	}*/
	/*if(f.rut_proveedor.value=="0")
	{
		alert("Debe seleccionar un Proveedor");
		f.rut_proveedor.focus();
		return false;
	}*/
	if(f.p_garantia.value!="")
	{
		var m;
		m=parseInt(f.p_garantia.value);
		if(isNaN(m) || m < 0)
		{
			alert("Debe ingresar una cantidad de meses validos");
			f.p_garantia.focus();
			return false;
		}
	}
	else
		f.p_garantia.value=0;
	//se llevan todos los campos a mayusculas
	f.cmbMarca.value=f.cmbMarca.value.toUpperCase();
	f.cmbModelo.value=f.cmbModelo.value.toUpperCase();
	f.nro_serie.value=f.nro_serie.value.toUpperCase();
	f.nro_factura.value=f.nro_factura.value.toUpperCase();
	f.nro_guia.value=f.nro_guia.value.toUpperCase();
	f.observaciones.value=f.observaciones.value.toUpperCase();
	f.cod_activo_fijo.value=f.cod_activo_fijo.value.toUpperCase();
	
	//si es un computador o un Notebook,  se pasa a la pagina de ingreso de perifericos
	if((f.tipo.value=='CMP;EQUIPO') || (f.tipo.value=='NBK;EQUIPO')){
		f.action="info_adicional_cmp.php";
		f.submit();
	}
	else{
		f.action="ingreso_datos.php?op=1";
		f.submit();
	}
}
</script>
<script type="text/javascript" src="funciones.js"></script>
</head>

<body onLoad="javascript:frmIngresoEquipo.tipo.focus();">
<form name="frmIngresoEquipo" method="post">
  <!-------------------------------- cabecera de la pagina ------------------------------------>
<?php
include("../principal/encabezado.php");
?>
  <!---------------------------------- cuerpo de la pagina ------------------------------------->
  <table width="770" class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table width="600" border="0" class="TablaInterior" align="center">
	<tr>
		<td align="center" class="ColorTabla01"><strong>Informaci&oacute;n del Equipo </strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
		<table width="550" border="0" cellpadding="0" cellspacing="2" align="center">
		<tr>
			<td width="200" style="border:solid 1px #666666;">Tipo de Equipo:</td>
			<td>&nbsp;&nbsp;
			<select name="tipo" tabindex="1">
			<option value="0" selected>Seleccione el Tipo de Equipo</option>
			<?php
			$query="select nombre_subclase as nombre,valor_subclase1 as valor1,valor_subclase3 as valor3";
			$query.=" from sub_clase where cod_clase=18003 and valor_subclase2 <> 'N';";
			$result=mysql_db_query("proyecto_modernizacion",$query);
			while($resp=mysql_fetch_array($result))
				echo '<option value="'.$resp["valor1"].';'.$resp["valor3"].'">'.$resp["nombre"].'</option>';
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">N&uacute;mero de Serie:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="nro_serie" maxlength="20" size="22" tabindex="2"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Marca:</td>
			<td>&nbsp;&nbsp; 
			<select name="cmbMarca" style="visibility: 'visible'; width: 150px;">
            <option value="0" selected>Seleccione una Marca</option>
            <?php
	           //se recuperan todas las marcas
		 		$query="select marca";
				$query.=" from hardware where  marca<> '' group by marca;";
				$result=mysql_db_query("cia_web",$query);
				while($resp=mysql_fetch_array($result))
					echo '<option value="'.$resp["marca"].'">'.$resp["marca"].'</option>';
					
			?>	
		   
        </select> 
		                    </td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Modelo:</td>
			      <td>&nbsp;&nbsp; 
                    <select name="cmbModelo" style="visibility: 'visible'; width: 150px;">
            <option value="0" selected>Seleccione Modelo</option>
            <?php
	           //se recuperan todas las marcas
		 	     $query="select distinct(modelo)";
			     $query.=" from hardware where tipo= 'EQUIPO' and modelo <> '' group by modelo;";
			     $result=mysql_db_query("cia_web",$query);
			     while($resp=mysql_fetch_array($result))
			     echo '<option value="'.$resp["modelo"].'">'.$resp["modelo"].'</option>';
					
			?>	
		   
        </select>
                  </td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Fecha de Compra:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="fecha_compra" maxlength="10" size="12" tabindex="5">&nbsp;&nbsp;Formato: dd-mm-yyyy</td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Periodo Garantia:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="p_garantia" maxlength="5" size="12" tabindex="6">
                    &nbsp;Meses</td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">N&uacute;mero de Factura:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="nro_factura" maxlength="20" size="22" tabindex="7"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">N&uacute;mero de Guia:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="nro_guia" maxlength="20" size="22" tabindex="8"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Codigo Activo Fijo:</td>
			<td>&nbsp;&nbsp;&nbsp;<input type="text" name="cod_activo_fijo" maxlength="12" size="15" tabindex="9"></td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Proveedor:</td>
			<td>&nbsp;&nbsp;
			<select name="rut_proveedor" tabindex="10">
			<option value="0" selected>Seleccione un Proveedor</option>
			<?php
			$query="select rut,razon_social from proveedor;";
			$result=mysql_db_query("cia_web",$query);
			while($row=mysql_fetch_array($result))
				echo '<option value="'.$row["rut"].'">'.$row["razon_social"].'</option>';
			?>
			</select>
			</td>
		</tr>
		<tr>
			<td style="border:solid 1px #666666;">Observaciones:</td>
			<td>
			&nbsp;&nbsp;
			<textarea name="observaciones" cols="30" rows="3" tabindex="11"></textarea></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		</table>
		</td>
	</tr>
	</table>
	</td>

<tr align="center">
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
	<input type="reset" name="limpiar" value="Limpiar" style="width: 80px;" tabindex="12">
	&nbsp;&nbsp;&nbsp;
	<input type="submit" name="Enviar" onClick="validar()" tabindex="13" value="Ingresar" style="width: 80px;">
	&nbsp;&nbsp;&nbsp;
	<input type="button" name="volver" value="Salir" tabindex="14" style="width: 80px;" onClick="salir()">
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
</tr>
</td>
</tr>
</table>
<!--------------------------------------- pie de pagina ------------------------------------>
<?php
include("../principal/pie_pagina.php");
mysql_close();
?>

</form>
</body>
</html>
