<?php 	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 6;
	include("../principal/conectar_pac_web.php");
?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngEnvioRef;
	var Valores="";

	for (i=1;i<Frm.CheckMov.length;i++)
	{
		if (Frm.CheckMov[i].checked==true)
		{
			Valores=Valores + Frm.TxtFechaHora[i].value+"//";
		}
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmIngEnvioRef;
	try
	{
		Frm.CheckMov[0];
		for (i=1;i<Frm.CheckMov.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckMov[i].checked=true;
			}
			else
			{
				Frm.CheckMov[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngEnvioRef;
	var CantCheck=0;
	for (i=1;i<Frm.CheckMov.length;i++)
	{
		if (Frm.CheckMov[i].checked==true)
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
	var Frm=document.FrmIngEnvioRef;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckMov.length;i++)
	{
		if (Frm.CheckMov[i].checked==true)
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
	var Frm=document.FrmIngEnvioRef;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_ingreso_envio_refineria_proceso.php?Proceso="+Proceso,"","top=110,left=140,width=520,height=330,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pac_ingreso_envio_refineria_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=110,left=140,width=520,height=330,scrollbars=no,resizable = no");		
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
					Frm.action="pac_ingreso_envio_refineria_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmIngEnvioRef;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=11";
	Frm.submit();
}
</script>
<title>Ingreso Envio a Refineria</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmIngEnvioRef" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="316" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td align="center" valign="top"><br> 
        <?php
			echo "<table width='750' border='0' cellpadding='3' cellspacing='0' bordercolor='#b26c4a' class='TablaDetalle'>";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='20'><input type='checkbox' name='CheckTodos' value='checkbox' onClick='CheckearTodo();'></td>";
			echo "<td width='125' align='center'>Fecha</td>";
			echo "<td width='80' align='left'>Cant(Ton)</td>";
			echo "<td width='50' align='left'>Hra.Ini</td>";
			echo "<td width='50' align='left'>Hra.Ter</td>";
			echo "<td width='50' align='left'>Estanque</td>";
			echo "<td width='90' align='left'>Operario</td>";
			//echo "<td width='90' align='center'>Tipo Mov.</td>";
			echo "</tr>";
			$Consulta = "select t1.fecha_hora,t1.toneladas,t1.hora_inicio,t1.hora_final,t2.nombre_subclase as estanque,t3.valor_subclase1 as operario,t4.nombre_subclase as movimiento " ;
			$Consulta = $Consulta." from pac_web.movimientos t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase=9001 and t1.cod_estanque_origen=t2.cod_subclase";
			$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t3 on t1.rut_funcionario = t3.nombre_subclase and t3.cod_clase=9002 ";
			$Consulta = $Consulta." inner join proyecto_modernizacion.sub_clase t4 on t1.tipo_movimiento=t4.cod_subclase and t4.cod_clase=9000 and t4.cod_subclase=1 order by fecha_hora";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckMov'><input type='hidden' name ='TxtFechaHora'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td align='left'><input type='checkbox' name='CheckMov' value='checkbox'></td>";
				echo "<td width='125' align='right'>".$Fila["fecha_hora"]."<input type='hidden' name ='TxtFechaHora' value ='".$Fila["fecha_hora"]."'></td>";
				echo "<td width='90' align='left'>".str_replace(".",",",$Fila["toneladas"])."</td>";
				echo "<td width='70' align='left'>".$Fila["hora_inicio"]."</td>";
				echo "<td width='70' align='left'>".$Fila["hora_final"]."</td>";
				echo "<td width='50' align='left'>".$Fila["estanque"]."</td>";
				echo "<td width='90' align='left'>".$Fila["operario"]."</td>";
				//echo "<td width='90' align='right'>".$Fila["movimiento"]."</td>";				
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
