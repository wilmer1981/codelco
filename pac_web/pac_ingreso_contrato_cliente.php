<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 22;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$Proceso  = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$EncontroRelacion  = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	
?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngContrato;
	var Valores="";

	for (i=1;i<Frm.CheckContrato.length;i++)
	{
		if (Frm.CheckContrato[i].checked==true)
		{
			Valores=Valores + Frm.TxtRutCliente0[i].value+"~~"+Frm.TxtNroContrato0[i].value+"//";
		}
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngContrato;
	try
	{
		Frm.CheckContrato[0];
		for (i=1;i<Frm.CheckContrato.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckContrato[i].checked=true;
			}
			else
			{
				Frm.CheckContrato[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngContrato;
	var CantCheck=0;
	for (i=1;i<Frm.CheckContrato.length;i++)
	{
		if (Frm.CheckContrato[i].checked==true)
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
	var Frm=document.FrmIngContrato;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckContrato.length;i++)
	{
		if (Frm.CheckContrato[i].checked==true)
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
	var Frm=document.FrmIngContrato;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_ingreso_contrato_cliente_proceso.php?Proceso="+Proceso,"","top=110,left=20,width=710,height=330,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pac_ingreso_contrato_cliente_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=20,width=710,height=330,scrollbars=no,resizable = no");		
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
					Frm.action="pac_ingreso_contrato_cliente_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmIngContrato;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9";
	Frm.submit();
}
</script>
<title>Ingreso Contrato Clientes</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngContrato" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"><br> 
        <?php
			echo "<table width='750' border='0' cellpadding='3' cellspacing='0' bordercolor='#b26c4a' class='TablaDetalle'>";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='90' align='center'>Rut</td>";
			echo "<td width='150' align='left'>Nombre</td>";
			echo "<td width='150' align='center'>Contrato</td>";
			echo "<td width='150' align='center'>Nro. Cuotas</td>";
			echo "<td width='60' align='right'>Toneladas</td>";
			echo "<td width='60' align='left'>Mes Inicio</td>";
			echo "<td width='60' align='left'>Mes Final</td>";
			echo "</tr>";
			$Consulta = "select * from pac_web.contrato_cliente t1 inner join pac_web.clientes t2 on t1.rut_cliente=t2.rut_cliente order by t1.nro_contrato";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckContrato'><input type='hidden' name='TxtRutCliente0'><input type='hidden' name='TxtNroContrato0'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckContrato' value='checkbox'><input type='hidden' name='TxtRutCliente0' value='".$Fila["rut_cliente"]."'><input type='hidden' name='TxtNroContrato0' value='".$Fila["nro_contrato"]."'></td>";
				echo "<td width='90' align='right'>".$Fila["rut_cliente"]."</td>";
				echo "<td width='150' align='center'>".$Fila["nombre"]."</td>";
				echo "<td width='150' align='center'>".$Fila["nro_contrato"]."</td>";
				echo "<td width='150' align='center'>".$Fila["nro_cuotas"]."</td>";
				echo "<td width='60' align='right'>".str_replace(".",",",$Fila["toneladas"])."</td>";
				echo "<td width='60' align='left'>".$meses[$Fila["mes_inicio"]-1]."</td>";
				echo "<td width='60' align='left'>".$meses[$Fila["mes_final"]-1]."</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
        <br> <table width="750" border="0" class="tablainterior">
          <tr> 
            <td align="center"> <input type="button" name="BtnNuevo" value="Nuevo" style="width:60" onClick="MostrarPopupProceso('N');"> 
              <input type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="MostrarPopupProceso('M');"> 
              <input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="MostrarPopupProceso('E');"> 
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();"></td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php
	if (isset($EncontroRelacion))
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
?>
