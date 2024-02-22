<?
	$CodigoDeSistema = 13;
	$CodigoDePantalla =3; 
	include("../principal/conectar_sef_web.php");
	$ConsultaPeso = false;
	if (isset($C_Equipo))
	{
		$Equipo = $C_Equipo;
		$ConsultaPeso = true;
	}
	if (isset($C_Producto))
	{
		$Producto = $C_Producto;
		$ConsultaPeso = true;
	}
	if ($ConsultaPeso)
	{
		
		$Consulta = "SELECT * from sef.producto_por_equipo ";
		$Consulta.= " where Cod_equipo = '".intval($Equipo)."'";
		$Consulta.= " and Cod_Producto = '".intval($Producto)."'";
		$Respuesta = mysql_query($Consulta);
		if ($Fila = mysql_fetch_array($Respuesta))
		{
			$PesoOlla = $Fila["Peso_base"];
		}
	}
?>
<html>
<head>
<title>Sistema Estadistico de Catodos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "CAN":	
			f.action =	"sef_ing_peso_ollas01.php?Proceso=CAN";
			f.submit();
			break;
		case "G":
			if (f.Equipo.value == "S")
			{
				alert("Debe seleccionar Equipo");
				f.Equipo.focus();
				return;
			}		
			if (f.Producto.value == "S")
			{
				alert("Debe seleccionar Producto");
				f.Producto.focus();
				return;
			}	
			if (f.PesoOlla.value == "S")
			{
				alert("Debe ingresar el Peso de la Olla");
				f.PesoOlla.focus();
				return;
			}			
			f.action =	"sef_ing_peso_ollas01.php?Proceso=G";
			f.submit();	
			break;	
		case "M":
			var Valores="";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ID" && f.elements[i].checked)
				{
					var Valores = f.elements[i].value;
				}
			}
			if (Valores=="")
			{
				alert("No hay ningun elemento seleccionado para Modificar");
				return;
			}
			else
			{				
				var CodEquipo = Valores.substring(0,3);
				var CodProducto = Valores.substring(3,6);				
				/*alert(Valores);
				alert(CodEquipo);
				alert(CodProducto);*/
				f.action =	"sef_ing_peso_ollas.php?C_Equipo=" + CodEquipo + "&C_Producto=" + CodProducto;
				f.submit();			
			}
			break;
		case "E":	
			var Valores="";
			for (i=0;i<f.elements.length;i++)
			{
				if (f.elements[i].name=="ID" && f.elements[i].checked)
				{
					var Valores = f.elements[i].value;
				}
			}
			if (Valores=="")
			{
				alert("No hay ningun elemento seleccionado para Eliminar");
				return;
			}
			else
			{				
				var CodEquipo = parseInt(Valores.substring(0,3));
				var CodProducto = parseInt(Valores.substring(3,6));				
				f.action =	"sef_ing_peso_ollas01.php?Proceso=E&C_Equipo=" + CodEquipo + "&C_Producto=" + CodProducto;
				f.submit();
			}			
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=13";
			f.submit();
			break;
	}
}

function Recarga()
{
	var f = document.frmPrincipal;
	f.action = "sef_con_generica.php";
	f.submit();
}
</script>
</head>

<body leftmargin="3" topmargin="2" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<? 
	include("../principal/encabezado.php"); 
	include("../principal/cerrar_principal.php");
	include("../principal/conectar_sef_web.php");
?>
  <table width="770" height="315" border="0" cellpadding="3" cellspacing="3" class="TablaPrincipal">
    <tr>
      <td valign="top">
<table width="650" height="74" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="67" height="26">Equipo:</td>
            <td colspan="4"><SELECT name="Equipo" style="width:250px ">
			<option value="S">SELECCIONAR</option>
                <?
					$Consulta = "SELECT * from sef.equipos order by Cod_equipo";
					$Respuesta = mysql_query($Consulta);
					while ($Fila = mysql_fetch_array($Respuesta))
					{
						if ($Equipo == $Fila["Cod_equipo"])						
							echo "<option SELECTed value='".$Fila["Cod_equipo"]."'>".strtoupper($Fila["Nombre_equipo"])."</option>\n";
						else
							echo "<option value='".$Fila["Cod_equipo"]."'>".strtoupper($Fila["Nombre_equipo"])."</option>\n";
					}
				?>				
              </SELECT></td>
          </tr>
          <tr>
            <td height="24">Producto:</td>
            <td width="298"><SELECT name="Producto"  style="width:250px ">
			<option value="S">SELECCIONAR</option>
  				<?
					$Consulta = "SELECT * from sef.productos order by Cod_Producto";
					$Respuesta = mysql_query($Consulta);
					while ($Fila = mysql_fetch_array($Respuesta))
					{
						if ($Producto == $Fila["Cod_Producto"])						
							echo "<option SELECTed value='".$Fila["Cod_Producto"]."'>".strtoupper($Fila["Nom_Producto"])."</option>\n";
						else
							echo "<option value='".$Fila["Cod_Producto"]."'>".strtoupper($Fila["Nom_Producto"])."</option>\n";
					}
				?>	
				</SELECT></td>
            <td width="69" align="right"> Peso:              </td>
            <td width="82"><input name="PesoOlla" type="text"  value="<? echo $PesoOlla; ?>" size="15">            </td>
            <td width="111"><input name="BtnGrabar" type="button" id="BtnGrabar3" style="width:70px" onClick="Proceso('G');" value="Grabar"></td>
          </tr>
          <tr> 
            <td colspan="5" align="center">&nbsp;              </td>
          </tr>
        </table>
      <br>
      <table width="650" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
        <tr align="center">
          <td colspan="4"><input name="BtnModificar" type="button" id="BtnModificar2" style="width:70px" onClick="Proceso('M');" value="Modificar">
            <input name="BtnEliminar" type="button" id="BtnEliminar" style="width:70px" onClick="Proceso('E');" value="Eliminar">
            <input name="BtnCancelar" type="button" id="BtnModificar" style="width:70px" onClick="Proceso('CAN');" value="Cancelar">
            <input name="BtnSalir" type="button" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
          </tr>
        <tr align="center" class="ColorTabla01">
          <td>SELEC</td>
          <td>EQUIPO</td>
          <td>PRODUCTO</td>
          <td>PESO OLLA </td>
        </tr>
<?		
	$Consulta = "SELECT t1.Cod_equipo, t1.Cod_producto, t1.Peso_base, t2.Nombre_equipo, t3.Nom_Producto ";
	$Consulta.= " from sef.producto_por_equipo t1 inner join sef.equipos t2 on t1.Cod_equipo = t2.Cod_equipo ";
	$Consulta.= " inner join sef.productos t3 on t1.Cod_producto = t3.Cod_producto ";
	$Consulta.= " order by t1.Cod_equipo, t1.Cod_producto ";
	$Respuesta = mysql_query($Consulta);
	while ($Fila = mysql_fetch_array($Respuesta))
	{
		echo "<tr align='center'>\n";
		echo "<td><input name='ID' type='radio' value='".str_pad($Fila["Cod_equipo"],3,"0",STR_PAD_LEFT)."".str_pad($Fila["Cod_producto"],3,"0",STR_PAD_LEFT)."'></td>\n";
		echo "<td>".strtoupper($Fila["Nombre_equipo"])."</td>\n";
		echo "<td>".strtoupper($Fila["Nom_Producto"])."</td>\n";
		echo "<td>".number_format($Fila["Peso_base"],2,",",".")."</td>\n";
		echo "</tr>\n";
	}
?>		
      </table>
      </td>
    </tr>
</table>
<? 
	include("../principal/pie_pagina.php"); 
	include("../principal/cerrar_sef_web.php");
?>
</form>
</body>
</html>
