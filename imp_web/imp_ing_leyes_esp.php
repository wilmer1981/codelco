<?php
	$CodigoDeSistema = 5;
	$CodigoDePantalla = 3;
	include("../principal/conectar_principal.php");
	$sql = "SELECT * from leyes order by cod_leyes";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		$valor = intval($row["cod_leyes"]);
		$Leyes[$valor] = $row["nombre_leyes"];
	}
	include("../principal/cerrar_principal.php");


	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else {
		$Proceso = "";
	}

	if(isset($_REQUEST["Producto"])){
		$Producto = $_REQUEST["Producto"];
	}else {
		$Producto = "";
	}
	if(isset($_REQUEST["Ley"])){
		$Ley = $_REQUEST["Ley"];
	}else {
		$Ley = "";
	}

	if(isset($_REQUEST["Proveedor"])){
		$Proveedor = $_REQUEST["Proveedor"];
	}else {
		$Proveedor = "";
	}

	if(isset($_REQUEST["NomBuscado"])){
		$NomBuscado = $_REQUEST["NomBuscado"];
	}else {
		$NomBuscado = "";
	}
	if(isset($_REQUEST["Carga"])){
		$Carga = $_REQUEST["Carga"];
	}else {
		$Carga = "";
	}
	if(isset($_REQUEST["ID"])){
		$ID = $_REQUEST["ID"];
	}else {
		$ID = "";
	}
?>	
<html>
<head>
<title>Sistema de Impurezas</title>
<link href="../principal/estilos/css_imp_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
<!--
function Salir()
{
	document.frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=5";
	document.frmPrincipal.submit();
}

function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "CAN":
			f.action="imp_ing_leyes_esp01.php?Proceso=REC";
			f.submit();
			break
		case "C":   //CARGAR LEYES
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.Proveedor.value == "S")
			{
				alert("Debe seleccionar Proveedor");
				f.Proveedor.focus();
				return;
			}
			if (f.ID.value == "")
			{
				alert("Debe ingresar ID Muestra");
				f.ID.focus();
				return;
			}
			f.action="imp_ing_leyes_esp.php?Carga=S";
			f.submit();
			break 
		case "BN":   //BUSCAR POR NOMBRE DE PROVEEDOR
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Producto.focus();
				return;
			}
			f.action="imp_ing_leyes_esp.php";
			f.submit();
			break 
		case "NL":    //NUEVA LEY
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.Proveedor.value == "S")
			{
				alert("Debe seleccionar Proveedor");
				f.Proveedor.focus();
				return;
			}
			if (f.ID.value == "")
			{
				alert("Debe ingresar ID. de Muestra");
				f.ID.focus();
				return;
			}
			else
			{
				URL="imp_ing_leyes_esp02.php?Id_Muestra=" + f.ID.value + "&Fecha=" + f.FechaMuestra.value + "&Producto=" + f.Producto.value + "&Proveedor=" + f.Proveedor.value;
				window.open(URL,"","top=320px,left=120px, width=600px, height=200px, menubar=no, resizable=yes, scrollbars=NO");
			}
			break
		case "ML":   //MODIFICAR LEY
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.Proveedor.value == "S")
			{
				alert("Debe seleccionar Proveedor");
				f.Proveedor.focus();
				return;
			}
			if (f.ID.value == "")
			{
				alert("Debe ingresar ID. de Muestra");
				f.ID.focus();
				return;
			}
			var Valor="";
			for (i=0;i<f.length;i++)
			{
				if ((f.elements[i].name=="CodLeyes") && (f.elements[i].checked==true))
				{
					Valor = f.elements[i].value;
				}	
			}
			if (Valor!="")
			{
				URL="imp_ing_leyes_esp02.php?Id_Muestra=" + f.ID.value + "&Fecha=" + f.FechaMuestra.value + "&Proceso=ML&Producto=" + f.Producto.value + "&Proveedor=" + f.Proveedor.value + "&Ley=" + Valor;
				window.open(URL,"","top=350px,left=120px, width=600px, height=200px, menubar=no, resizable=yes, scrollbars=NO");				
			}
			else
			{
				alert("Debe seleccionar un registro para Modificar.");
				return;
			}						
			break
		case "EL":   //ELIMINAR LEY
		if (f.Producto.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Producto.focus();
				return;
			}
			if (f.Proveedor.value == "S")
			{
				alert("Debe seleccionar Proveedor");
				f.Proveedor.focus();
				return;
			}
			if (f.ID.value == "")
			{
				alert("Debe ingresar ID Muestra");
				f.ID.focus();
				return;
			}
			var Valor="";
			for (i=0;i<f.length;i++)
			{
				if ((f.elements[i].name=="CodLeyes") && (f.elements[i].checked==true))
				{
					Valor = f.elements[i].value;
				}	
			}
			if (Valor!="")
			{
				var msg=confirm("Seguro que desea eliminar este registro?");			
				if (msg==true)
				{
					f.action="imp_ing_leyes_esp01.php?Proceso=EL&Ley=" + Valor;
					f.submit();
				}
				else
				{
					return;
				}	
			}
			else
			{
				alert("Debe seleccionar un registro para Eliminar.");
				return;
			}						
			break
		case "S":  //SALIR
			f.action="../principal/sistemas_usuario.php?CodSistema=5";
			f.submit();
			break 			 			 			
	}
}
//-->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">

body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php 
	include("../principal/encabezado.php");
	include("../principal/conectar_imp_web.php");
?>
  <table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td height="380">&nbsp;</td>
    </tr>
  </table>
  <div style="position:absolute; left: 1px; top: 31px;"></div>
<div style="position:absolute; left: 105px; top: 54px; width: 650px; height: 27px;"> 
	<table width="602" height="25" border="0" cellpadding="1" cellspacing="1" class="TablaInterior">
	  <tr> 
		<td width="15" height="23" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"> 
		</td>
		<td width="55">Producto</td>
		<td width="371"><SELECT name="Producto" style="width:350">
			<option SELECTed value="S">Seleccionar</option>
                    <?php
						$Consulta = "SELECT * from productos order by tipo_producto";
						$result = mysqli_query($link, $Consulta);
						while ($Row = mysqli_fetch_array($result))
						{
							if ($Producto == $Row["tipo_producto"])
							{
								echo "<option SELECTed value='".$Row["tipo_producto"]."'>".$Row["tipo_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["nombre"]))."</option>\n";
							}
							else
							{
								echo "<option value='".$Row["tipo_producto"]."'>".$Row["tipo_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["nombre"]))."</option>\n";
							}
						}
					?>
		  </SELECT>
		</td>
		<td width="222" align="center" valign="middle"><input type="button" name="BtnSalir" value="Salir" onClick="Salir();" style="width:70px"></td>
	  </tr>
	</table>
</div>
<div style="position:absolute; left: 104px; top: 87px; width: 649px; height: 48px;">
	<table width="603" height="48" border="0" cellpadding="1" cellspacing="1" class="TablaInterior">
      <tr> 
        <td width="12"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"></td>
        <td width="365">Rut 
          <SELECT name="Proveedor" style="width:300px">
            <option value='S'>Seleccionar</option>
            <?php
			if ($Producto != "S")
			{
				$sql = "SELECT * from proveedores ";
				$sql.= " where tipo_producto = '".$Producto."'";
				$sql.= " AND rut_proveedor <> '000000000'";
				if ($NomBuscado != "*")
				{
					$sql.= " and nombre like '%".$NomBuscado."%'";
				}
				$sql.= " order by nombre";
				$result = mysqli_query($link, $sql);
				while ($row = mysqli_fetch_array($result))
				{
					if ($Proveedor == $row["rut_proveedor"])
					{
						echo "<option SELECTed value='".$row["rut_proveedor"]."'>".$row["rut_proveedor"]." - ".ucwords(strtolower($row["nombre"]))."</option>\n";
					}
					else
					{
						echo "<option value='".$row["rut_proveedor"]."'>".$row["rut_proveedor"]." - ".ucwords(strtolower($row["nombre"]))."</option>\n";
					}
				}
			}
			?>
          </SELECT> </td>
        <td width="214" rowspan="2" align="center" valign="middle"> <table width="90%" border="0" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr> 
              <td><div align="center"><strong>Cargar Lista de Proveedores</strong></div></td>
            </tr>
            <tr> 
              <td align="center"><input name="NomBuscado" type="text" value="<?php echo $NomBuscado;?>" size="15"> 
                &nbsp; <input type="Button" name="BtnBuscarNombre" value="Buscar" onClick="Proceso('BN')">
                <strong><br>
                [*] = Todos</strong></td>
            </tr>
          </table></td>
      </tr>
      <tr> 
        <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"></td>
        <td>ID Muestra : &nbsp;
          <?php
		  if ($Carga=="S")
		  {
		  	$sql="SELECT distinct(fecha) as fecha, id_muestra from leyes_especiales where id_muestra = '".$ID."'";
			$result = mysqli_query($link, $sql);
			if ($row=mysqli_fetch_array($result))
			{
				echo strtoupper($row["id_muestra"])."&nbsp;Fecha :&nbsp;";
				echo substr($row["fecha"],8,2)."-".substr($row["fecha"],5,2)."-".substr($row["fecha"],0,4)."&nbsp;&nbsp;";
				echo "<input name='ID' type='hidden' value='".$ID."'>";
				echo "<input type='hidden' name='FechaMuestra' value='".$row["fecha"]."'>";
				echo "<input type='button' name='BtnCan' value='Cancelar' onClick=Proceso('CAN');>\n";
			}
			else
			{
				echo strtoupper($ID)."&nbsp;Fecha :&nbsp;";
				echo date("d-m-Y")."&nbsp;&nbsp;";
				echo "<input name='ID' type='hidden' value='".$ID."'>";
				echo "<input type='hidden' name='FechaMuestra' value='".date("Y-m-d")."'>";
				echo "<input type='button' name='BtnCan' value='Cancelar' onClick=Proceso('CAN');>\n";
			}
		  }
		  else
		  {				
				echo "<input name='ID' type='text' value='".$ID."'>&nbsp;";
				echo "Fecha : ".date("d-m-Y")."&nbsp;&nbsp;";
				echo "<input type='hidden' name='FechaMuestra' value='".date("Y-m-d")."'>";
				echo "<input type='button' name='BtnOK' value='OK' onClick=Proceso('C');>\n";			  	
		  }
		  ?> </td>
      </tr>
    </table>
</div>
<div style="position:absolute;width:600px;height:22px;top:154px;left:137px;;overflow:auto">
    <table width="547" height="20" border="0" align="left" cellpadding="3" cellspacing="0" id="TablaDetalle">
      <tr align="center" valign="middle" class="ColorTabla01"> 
        <td width="34" height="18">&nbsp;</td>
        <td width="59"><strong>C&oacute;digo</strong></td>
        <td width="240"><strong>Descripci&oacute;n</strong></td>
        <td width="97"><strong>Valor</strong></td>
        <td width="85"><strong>Unidad</strong></td>
      </tr>
    </table>
</div>
<div style="position:absolute;width:593px;height:184px;top:175px;left:137px;overflow:auto">
    <table width="547" border="1" cellpadding="0" align="left" cellspacing="0" id="TablaDetalle">        
<?php
	if ((isset($Producto)) && (isset($Proveedor)) && (isset($ID)))
	{
		$sql = "SELECT * from leyes_especiales ";
		$sql.= " where id_muestra = '".$ID."' and tipo_producto = '".$Producto."' ";
		$sql.= " and rut_proveedor = '".$Proveedor."'";
		$sql.= " order by fecha, cod_leyes, valor";
		$result = mysqli_query($link, $sql);
		while ($row = mysqli_fetch_array($result))
		{
			echo "<tr bgcolor='".$ColorTabla2."'>\n";
			echo "<td width=34 align='center'><input type='radio' name='CodLeyes' value='".$row["cod_leyes"]."'></td>\n";
			$CodLey = intval($row["cod_leyes"]);
			echo "<td width=59><font color='#FFFF33'>".$row["cod_leyes"]."&nbsp;</font></td>\n";
			echo "<td width=240><font color='#FFFF33'>".ucwords(strtolower($Leyes[$CodLey]))."&nbsp;</font></td>\n";
			echo "<td width=97 align='right'><font color='#FFFF33'>".number_format($row["valor"],4,',','.')."&nbsp;</font></td>\n";
			$sql = "SELECT * from proyecto_modernizacion.unidades where cod_unidad = '".$row["cod_unidad"]."'";			
			$result2 = mysqli_query($link, $sql);
			if ($row2 = mysqli_fetch_array($result2))
			{
				echo "<td width=85 align='center'><font color='#FFFF33'>".strtoupper($row2["abreviatura"])."</font></td>";
			}
			else
			{
				echo "<td width=85 align='center'>&nbsp;</td>";
			}
			echo "</tr>\n";
		}
	}
?>		
    </table>
</div>
<div style="position:absolute;width:600px;top:398px;left:102px">
<?php
	if ($Carga == "S")
	{
		echo "<table width=400 border=0 align='center' cellpadding=2 cellspacing=0>\n";
		echo "<tr align='center' valign='middle'>\n";
		echo "<td><input type='button' name='BtnNuevaLey' value='Nueva Ley' style='width:80px' onClick=Proceso('NL');></td>\n";
		echo "<td><input type='button' name='BtnModificar' value='Modificar' style='width:80px' onClick=Proceso('ML');></td>\n";
		echo "<td><input type='button' name='BtnEliminar' value='Eliminar' style='width:80px' onClick=Proceso('EL');></td>\n";
		echo "<td><input type='button' name='BtnSalir' value='Salir' style='width:80px' onClick=Proceso('S');></td>\n";
		echo "</tr>\n";
		echo "</table>\n";
	}
?>
</div>
<?php include("../principal/pie_pagina.php");?>
</form>
</body>
</html>
