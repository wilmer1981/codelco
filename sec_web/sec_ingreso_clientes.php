<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 47;
	//include("../principal/conectar_fac_web.php");
	include("../principal/conectar_principal.php");
	
	$CmbOpcion        = isset($_REQUEST["CmbOpcion"])?$_REQUEST["CmbOpcion"]:"V";
	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";

?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngCliente;
	var Valores="";

	for (i=1;i<Frm.CheckCliente.length;i++)
	{
		if (Frm.CheckCliente[i].checked==true)
		{
			Valores=Valores + Frm.TxtCodigoO[i].value+"//";
		}
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngCliente;
	try
	{
		Frm.CheckCliente[0];
		for (i=1;i<Frm.CheckCliente.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckCliente[i].checked=true;
			}
			else
			{
				Frm.CheckCliente[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngCliente;
	var CantCheck=0;
	for (i=1;i<Frm.CheckCliente.length;i++)
	{
		if (Frm.CheckCliente[i].checked==true)
		{
			CantCheck=CantCheck+1;
		}
	}
	if (CantCheck > 1)
	{
		alert("Debe Seleccionar solo un Elemento");
		return(false);
	}
	else
	{
		return(true);
	}
}
function SeleccionoCheck()
{
	var Frm=document.FrmIngCliente;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckCliente.length;i++)
	{
		if (Frm.CheckCliente[i].checked==true)
		{
			Encontro=true;
			break;
		}
	}
	if (Encontro==false)
	{
		alert("Debe Seleccionar un Elemento");
		return(false);
	}
	else
	{
		return(true);
	}
}

function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmIngCliente;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("sec_ingreso_clientes_proceso.php?Proceso="+Proceso,"","top=80,left=180,width=430,height=400,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("sec_ingreso_clientes_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=80,left=180,width=430,height=400,scrollbars=no,resizable = no");		
				}	
			}	
			break;
		case "E":
			if (SeleccionoCheck()) 
			{
				Resp=confirm("Esta seguro de Eliminar los Datos Seleccionados");
				if (Resp==true)
				{
					Valores=RecuperarValoresCheckeado();
					Frm.action="sec_ingreso_clientes_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
		case "S":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("sec_ing_destino.php?Valores="+Valores,"","top=115,left=120,width=500,height=370,scrollbars=no");		
				}	
			}	
			break;

	} 
}

function Historial(val)
{
	window.open("../sec_web/sec_con_popup.php?Rut="+ val,"","top=125,left=50,width=650,height=200,scrollbars=yes,resizable = yes");					
}
function Recarga()
{
	var Frm=document.FrmIngCliente;
	Frm.action="sec_ingreso_clientes.php";
	Frm.submit();
}
function Salir()
{
	var Frm=document.FrmIngCliente;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=46";
	Frm.submit();
}
</script>
<title>Ingreso de Clientes Venta</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngCliente" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="350" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td valign="top"><br> 
        <?php
			echo "<table width='743' border='1' cellpadding='0' cellspacing='0'>";
			echo "<tr class='tablainterior'>";
			echo "<td align='center'>";
			echo "<SELECT name='CmbOpcion' style='width:250' onchange='Recarga()'>";
			switch ($CmbOpcion)
			{
				case "V":
					echo "<option value='V' SELECTed>Clientes Ventas Directas</option>";
					echo "<option value='S'>Clientes Ventas Santiago</option>";
					echo "<option value='T'>Todos</option>";
					break;
				case "S":
					echo "<option value='V'>Clientes Ventas Ventanas</option>";
					echo "<option value='S' SELECTed>Clientes Ventas Santiago</option>";
					echo "<option value='T'>Todos</option>";
					break;
				case "T":
					echo "<option value='V'>Clientes Ventas Ventanas</option>";
					echo "<option value='S'>Clientes Ventas Santiago</option>";
					echo "<option value='T' SELECTed>Todos</option>";
					break;
			}
			echo "</SELECT>";
			echo "</td>";
			echo "</tr>";
			echo "</table><br>";  
			echo "<table width='743' border='0' cellpadding='0' cellspacing='0'>";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='10' align='center'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='90' align='center'>Rut</td>";
			echo "<td width='200' align='center'>Nombre</td>";
			echo "<td width='200' align='center'>Direccion</td>";
			echo "<td width='123' align='center'>Ciudad</td>";
			echo "<td width='60' align='center'>Tel 1</td>";
			echo "<td width='60' align='center'>Tel 2</td>";
			echo "</tr>";
			echo "</table>";
			$Consulta = "SELECT * from sec_web.cliente_venta ";
			switch ($CmbOpcion)
			{
				case "V":
					$Consulta.= "where tipo='V' order by nombre_cliente";
					break;
				case "S":
					$Consulta.= "where tipo<>'V' and cod_cliente like '%LX%' order by nombre_cliente";
					break;
				case "T":
					$Consulta.= "where cod_cliente like '%LX%' or cod_cliente like '%VD%' order by nombre_cliente";
					break;
				default:
					$Consulta.= "where cod_cliente like '%LX%' or cod_cliente like '%VD%' order by nombre_cliente";
					break;	
			}	
			$Resultado=mysqli_query($link, $Consulta);
			echo "<div style='position:absolute; left: 10px; top: 130px; width: 760px; height: 215px; OVERFLOW: auto;' id='div2'>";
			echo "<table width='743' border='1' cellpadding='0' cellspacing='0' class='tablainterior'>";
			echo "<input type='hidden' name='CheckCliente'><input type='hidden' name ='TxtCodigoO'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td width='10' align='center'><input type='checkbox' name='CheckCliente' value='checkbox'></td>";
				echo "<td width='90' align='right'><a href=\"JavaScript:Historial('".$Fila["rut"]."')\">".$Fila["rut"]."</a>&nbsp;<input type='hidden' name ='TxtCodigoO' value ='".$Fila["cod_cliente"]."'></td>";
				echo "<td width='200' align='left'>".$Fila["nombre_cliente"]."</td>";
				echo "<td width='200' align='left'>".$Fila["direccion2"]."&nbsp;</td>";
				echo "<td width='123' align='left'>".$Fila["ciudad"]."&nbsp;</td>";
				echo "<td width='60' align='right'>".$Fila["fono1"]."&nbsp;</td>";
				echo "<td width='60' align='right'>".$Fila["fono2"]."&nbsp;</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "</div>";
		?>
        <br>
		<div style='position:absolute; left: 15px; top: 365px; width: 750px; height: 31px; OVERFLOW: auto;' id='div2'> 
          <table width="750" border="0" class="tablainterior">
          <tr> 
            <td align="center"> <input type="button" name="BtnNuevo" value="Nuevo Cliente" style="width:90" onClick="MostrarPopupProceso('N');"> 
              <input type="button" name="BtnSubCliente" value="Destinos" style="width:80" onClick="MostrarPopupProceso('S');"> 
              <input type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="MostrarPopupProceso('M');"> 
			    <?php
			  		if ($CmbOpcion=='V')
					{
						echo "<input type='button' name='BtnEliminar' value='Eliminar' style='width:60' onClick=MostrarPopupProceso('E')>";
					}	
			    ?>
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();"></td>
          </tr>
        </table>
		</div>
        <br>
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($EncontroRelacion!="")
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
?>
