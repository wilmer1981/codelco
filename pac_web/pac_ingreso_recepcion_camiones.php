<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 13;
	include("../principal/conectar_pac_web.php");
?>
<html>
<head>
<script language="JavaScript">
var TipoRecep="";
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngRecepCamiones;
	var Valores="";

	for (i=1;i<Frm.CheckRecep.length;i++)
	{
		if (Frm.CheckRecep[i].checked==true)
		{
			Valores=Valores + Frm.TxtFechaHora[i].value+"//";
			TipoRecep=Frm.TxtTipoRecep[i].value;//se usa solo para modificar
		}
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngRecepCamiones;
	try
	{
		Frm.CheckRecep[0];
		for (i=1;i<Frm.CheckRecep.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckRecep[i].checked=true;
			}
			else
			{
				Frm.CheckRecep[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngRecepCamiones;
	var CantCheck=0;
	for (i=1;i<Frm.CheckRecep.length;i++)
	{
		if (Frm.CheckRecep[i].checked==true)
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
	var Frm=document.FrmIngRecepCamiones;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckRecep.length;i++)
	{
		if (Frm.CheckRecep[i].checked==true)
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

function MostrarPopupProceso(Proceso,Tipo)
{
	var Frm=document.FrmIngRecepCamiones;
	var Valores="";
	var Resp="";

	switch (Proceso)
	{
		case "N":
			if (Tipo==1)
			{
				window.open("pac_ingreso_recepcion_camiones_ser_proceso.php?Proceso="+Proceso,"","top=110,left=140,width=520,height=330,scrollbars=no,resizable = no");
				break;
			}
			else
			{
				window.open("pac_ingreso_recepcion_camiones_dev_proceso.php?Proceso="+Proceso,"","top=110,left=140,width=520,height=330,scrollbars=no,resizable = no");
				break;
			}	
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					if (TipoRecep==1)
					{
						window.open("pac_ingreso_recepcion_camiones_ser_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=140,width=520,height=330,scrollbars=no,resizable = no");		
					}
					else
					{
						window.open("pac_ingreso_recepcion_camiones_dev_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=140,width=520,height=330,scrollbars=no,resizable = no");							
					}	
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
					Frm.action="pac_ingreso_recepcion_camiones_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmIngRecepCamiones;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=11";
	Frm.submit();
}
</script>
<title>Ingreso Recepcion de Camiones</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngRecepCamiones" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"><br> 
        <?php
			echo "<table width='750' border='0' cellpadding='3' cellspacing='0' bordercolor='#b26c4a' class='TablaDetalle'>";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='70' align='center'>Fecha</td>";
			echo "<td width='50' align='left'>Patente</td>";
			echo "<td width='70' align='left'>Transportista</td>";
			echo "<td width='60' align='center'>Peso Rec.(Ton)</td>";
			echo "<td width='50' align='center'>EK Dest.</td>";
			echo "<td width='50' align='center'>Guia</td>";
			echo "<td width='80' align='left'>Tipo Recep.</td>";
			echo "<td width='80' align='left'>Movimiento</td>";
			echo "</tr>";
			$Consulta = "select t1.fecha_hora,t1.num_guia,t2.cod_subclase as estanque,t1.tipo_recepcion,t1.nro_patente,t1.volumen,t1.rut_transportista,t3.nombre,t4.nombre_subclase as movimiento " ;
			$Consulta = $Consulta." from pac_web.recepcion_camiones t1 inner join proyecto_modernizacion.sub_clase t2 on t1.cod_estanque=t2.cod_subclase and t2.cod_clase = 9001";
			$Consulta = $Consulta." inner join pac_web.transportista t3 on t1.rut_transportista = t3.rut_transportista ";
			$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t4 on t1.tipo_movimiento=t4.cod_subclase and t4.cod_clase=9000 and t4.cod_subclase=6 order by fecha_hora";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckRecep'><input type='hidden' name ='TxtFechaHora'><input type='hidden' name ='TxtTipoRecep'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckRecep' value='checkbox'></td>";
				echo "<td width='70' align='right'>".$Fila["fecha_hora"]."<input type='hidden' name ='TxtFechaHora' value ='".$Fila["fecha_hora"]."'></td>";
				echo "<td width='50' align='left'>".$Fila["nro_patente"]."</td>";
				echo "<td width='80' align='left'>".$Fila["rut_transportista"]." ".$Fila["nombre"]."</td>";
				echo "<td width='60' align='right'>".str_replace(".",",",$Fila["volumen"])."</td>";
				echo "<td width='50' align='center'>".$Fila["estanque"]."</td>";
				echo "<td width='60' align='center'>".$Fila["num_guia"]."</td>";
				if ($Fila["tipo_recepcion"]==0)
				{
					echo "<td width='50' align='left'>Devolucion<input type='hidden' name ='TxtTipoRecep' value='$Fila[tipo_recepcion]'></td>";
				}
				else
				{
					echo "<td width='50' align='left'>Servicio<input type='hidden' name ='TxtTipoRecep' value='$Fila[tipo_recepcion]'></td>";
				}
				echo "<td width='60' align='left'>".$Fila["movimiento"]."</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
        <br> <table width="750" border="0" class="tablainterior">
          <tr> 
            <td align="center"><input type="button" name="BtnNuevo2" value="Recep.Clientes" style="width:85" onClick="MostrarPopupProceso('N','1');"> 
              <input type="button" name="BtnNuevo" value="Devolucion-Prestamo" style="width:125" onClick="MostrarPopupProceso('N','0');"> 
              <input type="button" name="BtnModificar" value="Modificar" style="width:85" onClick="MostrarPopupProceso('M');"> 
              <input type="button" name="BtnEliminar" value="Eliminar" style="width:85" onClick="MostrarPopupProceso('E');"> 
              <input type="button" name="BtnSalir" value="Salir" style="width:85" onClick="Salir();"></td>
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
