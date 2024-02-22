<?php 	
	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 10;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
?>
<html>
<head>
<script language="JavaScript">
function Buscar()
{
	var Frm=document.FrmProgLoteo;
	
	Frm.action="sec_programa_loteo.php";
	Frm.submit();

}
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmProgLoteo;
	var Valores="";

	for (i=1;i<Frm.CheckProgLoteo.length;i++)
	{
		if (Frm.CheckProgLoteo[i].checked==true)
		{
			Valores=Valores + Frm.TxtCodigoO[i].value + "~~" + Frm.TxtDescripcionO[i].value+"//";
		}
	}
	return(Valores);	
} 
function CheckearTodo()
{
	var Frm=document.FrmProgLoteo;
	try
	{
		Frm.CheckProgLoteo[0];
		for (i=1;i<Frm.CheckProgLoteo.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckProgLoteo[i].checked=true;
			}
			else
			{
				Frm.CheckProgLoteo[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmProgLoteo;
	var CantCheck=0;
	for (i=1;i<Frm.CheckProgLoteo.length;i++)
	{
		if (Frm.CheckProgLoteo[i].checked==true)
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
	var Frm=document.FrmProgLoteo;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckProgLoteo.length;i++)
	{
		if (Frm.CheckProgLoteo[i].checked==true)
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
	var Frm=document.FrmProgLoteo;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("sec_programa_loteo_proceso.php?Proceso="+Proceso,"","top=195,left=180,width=410,height=165,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("sec_programa_loteo_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=195,left=180,width=410,height=165,scrollbars=no,resizable = no");		
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
					Frm.action="sec_programa_loteo_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmProgLoteo;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
	
}
</script>
<title>Programa de Loteo Enami</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" height="350" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center"><br>
	  <div style="position:absolute; left: 15px; top: 55px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0">
	  <tr>
	  <td align="center">
	  <?php
			echo "<select name='CmbDias'>";
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDias))
				{
					if ($i==$CmbDias)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
				{
					if ($i==date("j"))
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			}
			echo"</select>";
			echo"<select name='CmbMes'>";
			for($i=1;$i<13;$i++)
			{
				if (isset($CmbMes))
				{
					if ($i==$CmbMes)
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				
				}	
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
			}
			echo "</select>";
			echo "<select name='CmbAno'>";
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}
				else
				{
					if ($i==date("Y"))
						{
							echo "<option selected value ='$i'>$i</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}
			echo "</select>&nbsp;<input type='button' name='TxtBuscar' value='Buscar' style='width:60' onclick='Buscar()'>";
	  ?>
	  </td>
	  </tr>
	  </table></div><br>
	  <div style="position:absolute; left: 15px; top: 85px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="20"><input type="checkbox" name="CheckTodos" value="checkbox" onClick="CheckearTodo();"></td>
            <td width='130'>SubProducto</td>
            <td width='100'>Puerto Embarque</td>
			<td width='100'>Puerto Destino</td>
			<td width='100'>Nave/Cliente</td>
			<td width='100'>Fecha Progr</td>
			<td width='60'>Instruccion Embarque</td>
			<td width='60'>Peso(Kg)Programado</td>
			<td width='60'>Programa Loteo N�</td>
          </tr>
        </table></div>
		<div style="position:absolute; left: 15px; top: 120px; width: 750px; height: 240px; OVERFLOW: auto;" id="div2">
		<?php
			
			echo "<table width='730' border='0' class='tablainterior'>";
			if (isset($CmbAno))
			{
				$FechaTope=$CmbAno."-".$CmbMes."-".$CmbDias;
			}
			else
			{	
				$FechaTope=date('Y')."-".date('n')."-".date('j');
			}	
			$Consulta = "select t2.descripcion as subproducto,t3.nom_aero_puerto as pto_emb,t4.nom_aero_puerto as pto_destino,t5.nombre_nave,";
			$Consulta=$Consulta."t1.eta_programada,t1.corr_enum,t1.cantidad_embarque ";
			$Consulta=$Consulta." from sec_web.programa_enami t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta=$Consulta." left join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto=t4.cod_puerto ";
			$Consulta=$Consulta." left join sec_web.nave t5 on t1.cod_nave=t5.cod_nave ";
			$Consulta=$Consulta." where t1.eta_programada <='".$FechaTope."'";
			$Consulta=$Consulta." order by t1.eta_programada,t1.cod_nave";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckProgLoteo'><input type='hidden' name ='TxtCodigoO'><input type='hidden' name ='TxtDescripcionO'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td width='20'><input type='checkbox' name='CheckProgLoteo' value='checkbox'></td>";
				echo "<td width='130'>".$Fila["subproducto"]."&nbsp;</td>";
				echo "<td width='100'>".$Fila["pto_emb"]."</td>";
				echo "<td width='100'>".$Fila["pto_destino"]."</td>";
				echo "<td width='100'>".$Fila["nombre_nave"]."</td>";
				echo "<td width='100'>".$Fila["eta_programada"]."</td>";
				echo "<td width='60' >".$Fila[corr_enum]."</td>";
				echo "<td width='60' >".$Fila[cantidad_embarque]."</td>";
				echo "<td width='60' >".$Fila[num_solicitud]."&nbsp;</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
		</div>
        <br>
		<div style="position:absolute; left: 15px; top: 370px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
        <table width="730" border="0" class="tablainterior">
          <tr>
            <td align="center">
			<input type="button" name="BtnNuevo" value="Nuevo" style="width:60" onClick="MostrarPopupProceso('N');"> 
			<input type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="MostrarPopupProceso('M');">
			<input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="MostrarPopupProceso('E');"> 
			<input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
			</td>
          </tr>
        </table></div><br></td>
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
