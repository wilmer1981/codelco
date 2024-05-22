<?php 	
	$CodigoDeSistema = 99;
	$CodigoDePantalla = 11;
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
    $CmbMes   = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('n');	
    $CmbAno   = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');	
    $EncontroRelacion   = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:false;
	
?>
<html>
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngProdSubprod;
	var Valores="";

	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
		{
			Valores=Valores + Frm.CheckCod[i].value+"//";
		}
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngProdSubprod;
	try
	{
		Frm.CheckCod[0];
		for (i=1;i<Frm.CheckCod.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckCod[i].checked=true;
			}
			else
			{
				Frm.CheckCod[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngProdSubprod;
	var CantCheck=0;
	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
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
	var Frm=document.FrmIngProdSubprod;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckCod.length;i++)
	{
		if (Frm.CheckCod[i].checked==true)
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
	var Frm=document.FrmIngProdSubprod;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "NC":
		  window.open("ingreso_prod_subprod_proceso.php?Proceso="+Proceso,"","top=175,left=120,width=550,height=230,scrollbars=no,resizable = no");
		break;
		case "MC":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("ingreso_prod_subprod_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=175,left=120,width=550,height=230,scrollbars=no,resizable = no");		
				}	
			}	
			break;
		case "MS":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					
					window.open("ingreso_prod_subprod_proceso2.php?Proceso=NS&Valores="+Valores,"","top=125,left=120,width=575,height=500,scrollbars=no,resizable = no");	
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
					Frm.action="ingreso_prod_subprod_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}
function Recarga()
{
	var Frm=document.FrmIngProdSubprod;
	Frm.action="ingreso_prod_subprod.php";
	Frm.submit();
}
function Detalle(Valores)
{
	window.open("ingreso_prod_subprod_detalle.php?Valores="+Valores,"","top=120,left=120,width=550,height=350,scrollbars=yes,resizable = no");		
}
function Salir()
{
	var Frm=document.FrmIngProdSubprod;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=99";
	Frm.submit();
}
</script>
<title>Ingreso de Productos</title>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngProdSubprod" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top" > 
	  	<table width='760' border='1' cellpadding='1' cellspacing='0' >
		<td width='40' align='center'>Versi&oacute;n 1</td>
		<td align='center'>
		
		<input type="button" name="BtnNuevo" value="Agregar Producto" style="width:100" onClick="MostrarPopupProceso('NC');"> 
        <input type="button" name="BtnModificar" value="Modif.Producto" style="width:100" onClick="MostrarPopupProceso('MC');">	    
        <input type="button" name="BtnEliminar" value="Eliminar" style="width:100" onClick="MostrarPopupProceso('E');">
		<input type="button" name="BtnNuevo2" value="Agregar/Modificar SubProducto " style="width:204" onClick="MostrarPopupProceso('MS');"> 
		<input type="button" name="BtnSalir" value="Salir" style="width:100" onClick="Salir();">
		</td>
		</tr>
		</table><br>
		<?php
		echo "<table width='740' border='1' cellpadding='2' cellspacing='0' >";
		echo "<tr class='ColorTabla01'>"; 
		echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
		echo "<td width='40' align='center'>Codigo</td>";
		echo "<td width='400' align='center'>Descripcion</td>";
		echo "<td width='100' align='center'>Abreviatura</td>";
		echo "<td width='100' align='center'>Balance</td>";
		echo "</tr>";
		
		$Consulta="select * from proyecto_modernizacion.productos order by cod_producto";
		
		$Resultado=mysqli_query($link, $Consulta);
		echo "<input type='hidden' name='CheckCod'>";
		while ($Fila=mysqli_fetch_array($Resultado))
		{
			echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">"; 
			echo "<td align='left'><input type='checkbox' name='CheckCod' value='".$Fila["cod_producto"]."' onclick=\"CCA(this,'CL03')\"></td>";
			echo "<td align='right'>".$Fila["cod_producto"]."</td>";
			echo "<td align='left'><a href=JavaScript:Detalle('".$Fila["cod_producto"]."')>".$Fila["descripcion"]."</a></td>";
			echo "<td align='left'>".$Fila["abreviatura"]."&nbsp;</td>";
			echo "<td align='left'>".$Fila["balance_sec"]."&nbsp;</td>";
			echo "</tr>";
		}
		echo "</table>";
		?>
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if ($EncontroRelacion==true)
	{
		echo "<script languaje='javascript'>";
		echo "alert('Algunos Elementos No Fueron Eliminados por Tener SubProductos Asociads');";
		echo "</script>";
	}
?>