<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 10;
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:false;

?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmStockEstanques;
	var Valores="";

	for (i=1;i<Frm.CheckStock.length;i++)
	{
		if (Frm.CheckStock[i].checked==true)
		{
			Valores=Valores + Frm.TxtAno[i].value+Frm.TxtMes[i].value+"//";
		}
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmStockEstanques;
	try
	{
		Frm.CheckStock[0];
		for (i=1;i<Frm.CheckStock.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckStock[i].checked=true;
			}
			else
			{
				Frm.CheckStock[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmStockEstanques;
	var CantCheck=0;
	for (i=1;i<Frm.CheckStock.length;i++)
	{
		if (Frm.CheckStock[i].checked==true)
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
	var Frm=document.FrmStockEstanques;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckStock.length;i++)
	{
		if (Frm.CheckStock[i].checked==true)
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
	var Frm=document.FrmStockEstanques;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_stock_estanques_proceso.php?Proceso="+Proceso,"","top=190,left=80,width=605,height=250,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pac_stock_estanques_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=190,left=80,width=605,height=250,scrollbars=no,resizable = no");		
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
					Frm.action="pac_stock_estanques_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmStockEstanques;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9";
	Frm.submit();
}
</script>
<title>Definicion de Stock Estanques</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmStockEstanques" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"><br> 
        <?php
			echo "<table width='750' border='1' cellpadding='3' cellspacing='0' >";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='40' align='center'>Año</td>";
			echo "<td width='40' align='center'>Mes</td>";
			echo "<td width='50' align='center'>Estanque</td>";
			echo "<td width='90' align='center'>Stock Ini.</td>";
			echo "<td width='90' align='center'>Prod.-Prest.</td>";
			echo "<td width='90' align='center'>Envio-Trasp.</td>";
			echo "<td width='50' align='center'>Ajustes</td>";
			echo "<td width='90' align='center'>Stock Actual</td>";
			echo "</tr>";
			$AnoMes=0;
			//$Consulta = "SELECT t1.ano, t1.mes, t1.stock_inicial, t1.recepcion, t1.envio, t1.signo, t1.ajuste, t1.stock_actual, t2.nombre_subclase as estanque " ;
			$Consulta = "SELECT EXTRACT(YEAR FROM t1.fecha) as ano, EXTRACT(MONTH FROM t1.fecha) as mes, t1.stock_inicial, t1.recepcion, t1.envio, t1.signo, t1.ajuste, t1.stock_actual, t2.nombre_subclase as estanque " ;
			$Consulta.=" FROM pac_web.stock_estanques t1";
			$Consulta.=" LEFT JOIN proyecto_modernizacion.sub_clase t2 ON t2.cod_clase='9001' and t1.cod_estanque=t2.cod_subclase";
			$Consulta.=" WHERE t2.cod_subclase <> '5' ";
			$Consulta.=" ORDER BY ano, mes,t1.cod_estanque";	
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckStock'><input type='hidden' name ='TxtAno'><input type='hidden' name ='TxtMes'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				$AnoMesAux=$Fila["ano"].$Fila["mes"];
				if ($AnoMes!=$AnoMesAux)
				{
					echo "<tr>"; 
					echo "<td with='20' align='left'><input type='checkbox' name='CheckStock' value='checkbox'><input type='hidden' name='TxtAno' value='".$Fila["ano"]."'><input type='hidden' name='TxtMes' value='".$Fila["mes"]."'></td>";
					echo "<td width='40' align='center'><strong>".$Fila["ano"]."</strong></td>";
					echo "<td width='40' align='center'><strong>".$meses[$Fila["mes"]-1]."</strong></td>";
					echo "<td width='60' align='center'>&nbsp;</td>";
					echo "<td width='90' align='left'>&nbsp;</td>";
					echo "<td width='60' align='left'>&nbsp;</td>";
					echo "<td width='50' align='left'>&nbsp;</td>";
					echo "<td width='50' align='left'>&nbsp;</td>";
					echo "<td width='90' align='left'>&nbsp;</td>";
					echo "</tr>"; 
					echo "<tr>";
					echo "<td width='20' align='center'>&nbsp;</td>";
					echo "<td width='40' align='center'>&nbsp;</td>";
					echo "<td width='40' align='center'>&nbsp;</td>";
					echo "<td width='60' align='center'>".str_replace(".",",",$Fila["estanque"])."</td>";
					echo "<td width='90' align='right' class='detalle01'>".str_replace(".",",",$Fila["stock_inicial"])."</td>";
					echo "<td width='90' align='right'>".str_replace(".",",",$Fila["recepcion"])."</td>";
					echo "<td width='90' align='right'>".str_replace(".",",",$Fila["envio"])."</td>";
					if (($Fila["signo"]=='+') || ($Fila["ajuste"]==0))
					{
						echo "<td width='50' align='right'>".str_replace(".",",",$Fila["ajuste"])."</td>";
					}
					else
					{
						echo "<td width='50' align='right'>".$Fila["signo"].str_replace(".",",",$Fila["ajuste"])."</td>";
					}	
					echo "<td width='90' align='right' class='detalle01'>".str_replace(".",",",$Fila["stock_actual"])."</td>";
					echo "</tr>";
					$AnoMes=$Fila["ano"].$Fila["mes"];
				}
				else
				{
					echo "<tr>";
					echo "<td width='20' align='center'>&nbsp;</td>";
					echo "<td width='40' align='center'>&nbsp;</td>";
					echo "<td width='40' align='center'>&nbsp;</td>";
					echo "<td width='60' align='center'>".str_replace(".",",",$Fila["estanque"])."</td>";
					echo "<td width='90' align='right' class='detalle01'>".str_replace(".",",",$Fila["stock_inicial"])."</td>";
					echo "<td width='90' align='right'>".str_replace(".",",",$Fila["recepcion"])."</td>";
					echo "<td width='90' align='right'>".str_replace(".",",",$Fila["envio"])."</td>";
					if (($Fila["signo"]=='+') || ($Fila["ajuste"]==0))
					{
						echo "<td width='50' align='right'>".str_replace(".",",",$Fila["ajuste"])."</td>";
					}
					else
					{
						echo "<td width='50' align='right'>".$Fila["signo"].str_replace(".",",",$Fila["ajuste"])."</td>";
					}
					echo "<td width='90' align='right' class='detalle01'>".str_replace(".",",",$Fila["stock_actual"])."</td>";
					echo "</tr>";
				}	
			}
			echo "</table>";
		?>
        <br> <table width="750" border="0" class="tablainterior">
          <tr> 
            <td align="center">
				<input type="button" name="BtnNuevo" value="Nuevo" style="width:60" onClick="MostrarPopupProceso('N');"> 
            	<input type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="MostrarPopupProceso('M');"> 
            	<input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="MostrarPopupProceso('E');"> 
            	<input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
			</td>
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
	if ($EncontroRelacion)
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
?>
