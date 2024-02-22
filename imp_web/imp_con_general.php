<?php 
	$CodigoDeSistema = 5;
	$CodigoDePantalla = 1;

	
	if(isset($_POST["BusquedaRut"])){
		$BusquedaRut = $_POST["BusquedaRut"];
	}else{
		$BusquedaRut = "";
	}

	if(isset($_POST["Busqueda"])){
		$Busqueda = $_POST["Busqueda"];
	}else{
		$Busqueda = "";
	}


	if(isset($_POST["Productos"])){
		$Productos = $_POST["Productos"];
	}else{
		$Productos = "";
	}
	if(isset($_POST["TipoCons"])){
		$TipoCons = $_POST["TipoCons"];
	}else{
		$TipoCons = "";
	}
	

	

	if(isset($_GET["mostrar"])){
		$mostrar = $_GET["mostrar"];
	}else{
		$mostrar = "";
	}
	if(isset($_GET["BusPor"])){
		$BusPor = $_GET["BusPor"];
	}else{
		$BusPor = "";
	}


?>
<html>
<head>
<title>Sistema de Impurezas</title>
<link href="../principal/estilos/css_imp_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function Salir()
{
	document.frmPrincipal.action = "../principal/sistemas_usuario.php?CodSistema=5";
	document.frmPrincipal.submit();
}
function Recarga(opcion)
{
	var f = document.frmPrincipal;
//	f.BusquedaRut.value = f.BusquedaRut.value.toUpperCase();
	f.Busqueda.value = f.Busqueda.value.toUpperCase();
	if (f.Productos.value == "S")
	{
		alert("Debe seleccionar un Producto");
		f.Productos.focus();
		return;
	}
	switch (opcion)
	{
		case "R":
			if (f.BusquedaRut.value == "")
			{
				alert("Debe ingresar un rut ó (*) para todos");
				f.BusquedaRut.focus();
				return;
			}
			f.Busqueda.value = "";
			break;
		case "D":
			if (f.Busqueda.value == "")
			{
				alert("Debe ingresar una descripción ó (*) para todas");
				f.Busqueda.focus();
				return;
			}
			f.BusquedaRut.value = "";
			break;
	}	
	f.action = "imp_con_general.php?mostrar=S&BusPor=" + opcion;
	f.submit();
}

function Detalle(proveedor)
{
	var f = document.frmPrincipal;
	var URL = "imp_con_leyes_prov.php?TipoProd=" + f.Productos.value + "&RutProv=" + proveedor;
	window.open(URL,"","top=30,left=20,width=700,height=450,menubar=no,resizable=yes,scrollbars=yes");
}
function Muestras(proveedor)
{
	var f = document.frmPrincipal;
	var URL = "imp_con_leyes_esp.php?TipoProd=" + f.Productos.value + "&RutProv=" + proveedor;
	window.open(URL,"","top=30,left=20,width=700,height=450,menubar=no,resizable=yes,scrollbars=yes");
}
//-->
</script><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>

<body bgcolor="FFFFFF" leftmargin="3" topmargin="2" marginwidth="0" marginheight="0" link="#FFFF33" vlink="#FFFF33" alink="#FFFF33">
<form name="frmPrincipal" action="" method="post">
<?php 
	include("../principal/encabezado.php");
	include("../principal/conectar_imp_web.php");
?>
  <table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    <tr>
      <td height="300"><div style="position:absolute; left: 20px; top: 55px;">
          <table width="730" height="74" border="0" cellpadding="1" cellspacing="1" class="TablaInterior">
            <tr> 
              <td width="38" height="22" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"> 
              </td>
              <td width="47">Producto</td>
              <td colspan="4"><select name="Productos" style="width:350">
                  <option selected value="S">SELECCIONE</option>
                  <?php
	$Consulta = "select * from productos order by tipo_producto";
	$result = mysqli_query($link, $Consulta);
	while ($Row = mysqli_fetch_array($result))
	{
		if ($Productos == $Row["tipo_producto"])
		{
			echo "<option selected value='".$Row["tipo_producto"]."'>".$Row["tipo_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["nombre"]))."</option>\n";
		}
		else
		{
			echo "<option value='".$Row["tipo_producto"]."'>".$Row["tipo_producto"]."&nbsp;-&nbsp;".ucwords(strtolower($Row["nombre"]))."</option>\n";
		}
	}
?>
                </select></td>
              <td width="104" rowspan="3" align="center" valign="middle"><input type="button" name="BtnSalir" value="Salir" onClick="Salir();" style="width:70px"></td>
            </tr>
            <tr> 
              <td height="22" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"></td>
              <td height="22">Rut</td>
              <td width="127">
			  <input name="BusquedaRut" type="text" value="<?php echo $BusquedaRut; ?>"> 	
			  <!--<input name="BusquedaRut" type="text" id="BusquedaRut3" value="<?php echo $BusquedaRut; ?>">--> 
              </td>
              <td width="197" rowspan="2" align="center" valign="middle"> 
                <?php
				  if (isset($TipoCons))
				  {
				  	if ($TipoCons == "N")
					{
				  		echo "<input type='radio' checked name='TipoCons' value='N'>Normal&nbsp;&nbsp;\n";
                    	echo "<input type='radio' name='TipoCons' value='M'>Muestra\n";
					}
					else
					{
						echo "<input type='radio' name='TipoCons' value='N'>Normal&nbsp;&nbsp;\n";
                    	echo "<input type='radio' checked name='TipoCons' value='M'>Muestra\n";
					}
				  }
				  else
				  {
				  	echo "<input type='radio' checked name='TipoCons' value='N'>Normal&nbsp;&nbsp;\n";
                    echo "<input type='radio' name='TipoCons' value='M'>Muestra\n";
				  }
                  
				  ?>
              </td>
              <td width="144" align="center" valign="middle"><input type="button" name="btnBuscarRut" value="Buscar" onClick="JavaScript:Recarga('R');"></td>
              <td width="104">&nbsp;</td>
            </tr>
            <tr> 
              <td height="26" align="right"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11"></td>
              <td height="26">Descripción</td>
              <td width="127"><input name="Busqueda" type="text" size="30" maxlength="30" value="<?php echo $Busqueda; ?>"> 
              </td>
              <td width="144" align="center" valign="middle"> <input type="button" name="BtnConsultar" value="Buscar" onClick="JavaScript:Recarga('D');"></td>
              <td width="104"><strong>[*] = Todos</strong></td>
            </tr>
          </table>
        </div>
        <br> <div id="cabecera" style="position:absolute; width: 636px; height: 25px; left: 94px; top: 140px;"> 
          <table width="630" border="1" bordercolor="#CCCCCC" cellpadding="0" cellspacing="0">
            <!--<tr bgcolor="<?php echo $ColorTabla1; ?>"> -->
			<tr class="ColorTabla01">
              <td width="100"><strong>RUT</strong></td>
              <td width="435"><strong>NOMBRE</strong></td>
            </tr>
          </table>
        </div>
        <div id="detalle" style="position:absolute; width: 649px; height: 170px; left: 94px; top: 155px; overflow:auto;"> 
          <table width="630" border="1" bordercolor="#CCCCCC" cellpadding="2" cellspacing="0">
            <?php  
switch ($mostrar) 
{
   case "S":
   		if (($TipoCons == "N") || (!isset($TipoCons)))
		{
			$Consulta = "select * from proveedores ";
			$Consulta.= " where tipo_producto = '".$Productos."'";
			switch ($BusPor)
			{
				case "R":
					if ($BusquedaRut != "*")
						$Consulta.= " and rut_proveedor like '".$BusquedaRut."%'";
					$Consulta.= " order by rut_proveedor";
					break;
				case "D":
					if ($Busqueda != "*")
						$Consulta.= " and nombre like '%".$Busqueda."%'";
					$Consulta.= " order by rut_proveedor";
					break;
			}		
		}
		else
		{
			$Consulta = "select distinct(t1.rut_proveedor), t2.nombre  ";
			$Consulta.= " from leyes_especiales t1, proveedores t2 ";
			$Consulta.= " where t1.tipo_producto = '".$Productos."'";
			$Consulta.= " and t1.tipo_producto = t2.tipo_producto ";
			$Consulta.= " and t1.rut_proveedor = t2.rut_proveedor ";
			switch ($BusPor)
			{
				case "R":
					if ($BusquedaRut != "*")
						$Consulta.= " and t1.rut_proveedor like '".$BusquedaRut."%'";
					$Consulta.= " order by t1.rut_proveedor";
					break;
				case "D":
					if ($Busqueda != "*")
						$Consulta.= " and t2.nombre like '%".$Busqueda."%'";
					$Consulta.= " order by t2.rut_proveedor";
					break;
			}		
		}
		//echo $Consulta."</br>";
		$result = mysqli_query($link, $Consulta);
		$Color = $ColorTabla3;
		while ($Row = mysqli_fetch_array($result))
		{
			if ($Color == $ColorTabla3)
			{
				$Color = $ColorTabla2;
				echo "<tr bgcolor='".$ColorTabla2."'>\n";
			}
			else
			{
				$Color = $ColorTabla3;
				echo "<tr bgcolor='".$ColorTabla3."'>\n";			
			}
			if (($TipoCons == "N") || (!isset($TipoCons)))
			{
				echo "<td width=100 align='right'><a href=JavaScript:Detalle('".$Row["rut_proveedor"]."')>";
			}
			else
			{
				echo "<td width=100 align='right'><a href=JavaScript:Muestras('".$Row["rut_proveedor"]."')>";
			}
			echo number_format(substr($Row["rut_proveedor"],0,8),0,',','.')."-".substr($Row["rut_proveedor"],8,1);
			echo "</td>\n";
			echo "<td width=435><font color='#FFFF33'>".ucwords(strtolower($Row["nombre"]))."</font></td>\n";
			echo "</tr>\n";
		}
		break;
	default:
		echo "<tr>\n";
		echo "<td>&nbsp;</td>\n";
		echo "<td>&nbsp;</td>\n";
		echo "</tr>\n";
		break;
}
?>
          </table>
        </div></td>
    </tr>
  </table>
<?php include("../principal/pie_pagina.php");?>
  </form>
</body>
</html>
