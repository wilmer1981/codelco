<?php
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 25;
	include("../principal/conectar_principal.php");

	$sql = "select * from leyes order by cod_leyes";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_array($result))
	{
		$valor = intval($row["cod_leyes"]);
		$Leyes[$valor] = $row["nombre_leyes"];
	}
	include("../principal/cerrar_principal.php");
    $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$Buscar      = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$CmbDia       = isset($_REQUEST["CmbDia"])?$_REQUEST["CmbDia"]:date("d");
	$CmbMes       = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno       = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");

?>	
<html>
<head>
<title>Sistema Planta Acido</title>
<link href="../principal/estilos/css_imp_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmIngLeyes;
	var Valores="";
	for (i=1;i<Frm.CheckLeyes.length;i++)
	{
		if (Frm.CheckLeyes[i].checked==true)
		{
			Valores=Valores + Frm.CheckLeyes[i].value+"/";
		}
	}
	return(Valores);
}	
function CheckearTodo()
{
	var Frm=document.FrmIngLeyes;
	try
	{
		Frm.CheckLeyes[0];
		for (i=1;i<Frm.CheckLeyes.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckLeyes[i].checked=true;
			}
			else
			{
				Frm.CheckLeyes[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmIngLeyes;
	var CantCheck=0;
	for (i=1;i<Frm.CheckLeyes.length;i++)
	{
		if (Frm.CheckLeyes[i].checked==true)
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
	var Frm=document.FrmIngLeyes;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckLeyes.length;i++)
	{
		if (Frm.CheckLeyes[i].checked==true)
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
function Proceso(Proceso)
{
	var Frm=document.FrmIngLeyes;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("pac_ing_leyes_esp02.php?Proceso="+Proceso,"","top=170,left=30,width=650,height=180,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("pac_ing_leyes_esp02.php?Proceso="+Proceso +"&Valores="+Valores,"","top=170,left=30,width=650,height=180,scrollbars=no,resizable = no");
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
					Frm.action="pac_ing_leyes_esp01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}
function Recarga()
{
	var Frm=document.FrmIngLeyes;
	Frm.action="pac_ing_leyes_esp.php?Buscar=S";
	Frm.submit();
}

function Salir()
{
	var Frm=document.FrmIngLeyes;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9";
	Frm.submit();
}

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="FrmIngLeyes" action="" method="post">
<?php 
	include("../principal/encabezado.php");
	include("../principal/conectar_pac_web.php");
?>
  <table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
  <tr>
	  <td height="380">
	  <div style="position:absolute;width:720px;height:40px;top:55px;left:17px;;overflow:auto"> 
		<table width="720" height="25" border="1" cellpadding="0" align="center" cellspacing="0" class='tablainterior'>
		  <tr align="center" valign="middle"> 
			<td>
            <?php
			echo "Fecha:&nbsp;&nbsp;<select name='CmbDia' id='select7' size='1' style='width:40px;'>";
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDia))
				{
					if ($i==$CmbDia)
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
			echo "</select>";
			echo "<select name='CmbMes' size='1' style='width:90px;'>";
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
			echo "<select name='CmbAno' size='1' style='width:70px;'>";
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
		echo "</select>&nbsp;&nbsp;";
		echo "<input type='button' name='BtnBuscar' style='width:60' value='Buscar' onclick='Recarga()'>";
		?>
		</td>
		  </tr>
		</table>
	  </div>
	  <div style="position:absolute;width:720px;height:25px;top:85px;left:17px;;overflow:auto"> 
		<table width="720" height="25" border="1" cellpadding="0" align="center" cellspacing="0">
		  <tr align="center" valign="middle" class="ColorTabla01"> 
			<td width="10"><input type='checkbox' name='CheckTodos' onClick="CheckearTodo()"></td>
			<td width="30" align="center"><strong>EK</strong></td>
			<td width="70" align="center"><strong>Fecha</strong></td>
			<td width="150" align="center"><strong>Descripci&oacute;n</strong></td>
			<td width="35" align="center"><strong>Valor</strong></td>
			<td width="40" align="center"><strong>Unidad</strong></td>
		  </tr>
		</table>
	  </div>
      <div style="position:absolute;width:735px;height:275px;top:110px;left:18px;overflow:auto"> 
      <table width="715" border="1" cellpadding="0" align="center" cellspacing="0">        
	  <?php
		$Fecha=$CmbAno."-".$CmbMes."-".$CmbDia;
		$Consulta="select t1.correlativo,t4.nombre_subclase as estanque,t2.abreviatura as cod_ley,t1.fecha,t1.valor,t2.nombre_leyes,t2.abreviatura,t3.abreviatura from pac_web.leyes_por_estanques t1 ";
		$Consulta.="left join proyecto_modernizacion.leyes t2 on t1.cod_leyes=t2.cod_leyes left join proyecto_modernizacion.unidades t3 ";
		$Consulta.="on t1.cod_unidad=t3.cod_unidad left join proyecto_modernizacion.sub_clase t4 on t1.cod_estanque=t4.cod_subclase and t4.cod_clase='9001' ";
		if (isset($Buscar))
		{
			$Consulta.="where t1.fecha='".$Fecha."'";
		}
		$Respuesta=mysqli_query($link, $Consulta);
		echo "<td width='15'><input type='hidden' name='CheckLeyes'></td>";
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
			echo "<td width='10'><input type='checkbox' name='CheckLeyes' value='$Fila[correlativo]'></td>";
			echo "<td width='30' align='center'>".$Fila["estanque"]."</td>";
			echo "<td width='70' align='center'>".$Fila["fecha"]."</td>";
			echo "<td width='150'>&nbsp;".$Fila["nombre_leyes"]."&nbsp;(".$Fila["cod_ley"].")</td>";
			echo "<td width='35' align='right'>".$Fila["valor"]."</td>";
			echo "<td width='40'>".$Fila["abreviatura"]."</td>";
			echo "</tr>";
		}
      ?>		
      </table>
      </div>
      <div style="position:absolute; width:720px; top:390px; left:17px; height: 18px;"> 
      <?php
		echo "<table width='720' border=0 align='center' cellpadding=2 cellspacing=0 class='tablainterior'>\n";
		echo "<tr>";
		echo "<td align='center'><input type='button' name='BtnNuevo' value='Nueva Ley' style='width:80px' onClick=Proceso('N');>&nbsp;";
		echo "<input type='button' name='BtnModificar' value='Modificar' style='width:80px' onClick=Proceso('M');>&nbsp;";
		echo "<input type='button' name='BtnEliminar' value='Eliminar' style='width:80px' onClick=Proceso('E');>&nbsp;";
		echo "<input type='button' name='BtnSalir' value='Salir' style='width:80px' onClick=Salir();></td>";
		echo "</tr>\n";
		echo "</table>\n";
      ?>
      </div>
	  </td>
    </tr>
  </table>
<?php include("../principal/pie_pagina.php");?>
</form>
</body>
</html>