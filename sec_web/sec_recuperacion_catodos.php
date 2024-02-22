<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 6;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
?>
<html>
<head>
<script language="JavaScript">
function RecuperarValoresCheckeado()
{
	var Frm=document.FrmParamProducto;
	var Valores="";

	for (i=1;i<Frm.CheckSubProducto.length;i++)
	{
		if (Frm.CheckSubProducto[i].checked==true)
		{
			Valores=Valores + Frm.TxtSubProductoO[i].value + "~~" + Frm.TxtCorrO[i].value+"//";
		}
	}
	return(Valores);	
}
function CheckearTodo()
{
	var Frm=document.FrmParamProducto;
	try
	{
		Frm.CheckSubProducto[0];
		for (i=1;i<Frm.CheckSubProducto.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.CheckSubProducto[i].checked=true;
			}
			else
			{
				Frm.CheckSubProducto[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}
function SoloUnElementoCheck()
{
	var Frm=document.FrmParamProducto;
	var CantCheck=0;
	for (i=1;i<Frm.CheckSubProducto.length;i++)
	{
		if (Frm.CheckSubProducto[i].checked==true)
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
	var Frm=document.FrmParamProducto;
	var Encontro="";
	
	Encontro=false; 
	for (i=1;i<Frm.CheckSubProducto.length;i++)
	{
		if (Frm.CheckSubProducto[i].checked==true)
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
	var Frm=document.FrmParamProducto;
	var Valores="";
	var Resp="";
	switch (Proceso)
	{
		case "N":
			window.open("sec_parametros_productos_proceso.php?Proceso="+Proceso,"","top=195,left=130,width=515,height=220,scrollbars=no,resizable = no");
			break;
		case "M":
			if (SeleccionoCheck()) 
			{
				if (SoloUnElementoCheck())
				{
					Valores=RecuperarValoresCheckeado();
					window.open("sec_parametros_productos_proceso.php?Proceso="+Proceso+"&Valores="+Valores,"","top=195,left=130,width=515,height=220,scrollbars=no,resizable = no");		
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
					Frm.action="sec_parametros_productos_proceso01.php?Proceso="+Proceso+"&Valores="+Valores;
					Frm.submit();
				}			
			}	
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmParamProducto;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
	
}
</script>
<title>Ingreso Parametros Productos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmParamProducto" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center"><table width="760" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td>Fecha Desde: 
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
					for ($i=date("Y");$i<=date("Y");$i++)
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
	    			echo "</select>";
					?>
            </td>
            <td>Fecha Hasta:
              <?php
				echo "<select name='CmbDiasT'>";
				for ($i=1;$i<=31;$i++)
				{
					if (isset($CmbDiasT))
					{
						if ($i==$CmbDiasT)
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
				  echo "<select name='CmbMesT'>";
				  for($i=1;$i<13;$i++)
				  {
						if (isset($CmbMesT))
						{
							if ($i==$CmbMesT)
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
				   echo "<select name='CmbAnoT'>";
				   for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAnoT))
						{
							if ($i==$CmbAnoT)
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
				    echo "</select>";
				?>
            </td>
          </tr>
        </table>
        <br>
	  <table width="750" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="106">Fecha Prod.</td>
            <td width="39">Grupo</td>
            <td width="80">Unidad</td>
            <td width="93">Peso Producto</td>
            <td width="132">Unidad Seleccionada</td>
            <td width="127">Unidad Recuperada</td>
            <td width="131">Unidad Rechazo</td>
          </tr>
        </table>
		<?php
			echo "<table width='750' border='0' class='tablainterior'>";
			$Consulta = "select t1.cod_subproducto,t1.cod_correlativo,t1.procedencia,t1.peso_promedio,t1.peso_valido,t1.descripcion_ingles,t2.descripcion from sec_web.parametros_productos t1 inner join proyecto_modernizacion.subproducto t2 on t2.cod_producto = '18' and t1.cod_subproducto = t2.cod_subproducto order by t1.cod_subproducto";
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='CheckSubProducto'><input type='hidden' name ='TxtSubProductoO'><input type='hidden' name ='TxtCorrO'>";
			while ($Fila=mysqli_fetch_array($Resultado))
			{
				echo "<tr>"; 
				echo "<td width='67'><input type='checkbox' name='CheckSubProducto' value='checkbox'></td>";
				echo "<td width='40'>".$Fila["cod_subproducto"]."<input type='hidden' name ='TxtSubProductoO' value ='".$Fila["cod_subproducto"]."'><input type='hidden' name ='TxtCorrO' value='".$Fila["cod_correlativo"]."'></td>";
				echo "<td width='211'>".$Fila["descripcion"]."</td>";
				echo "<td width='50'>".$Fila["cod_correlativo"]."</td>";
				echo "<td width='72'>".$Fila["peso_promedio"]."</td>";
				if ($Fila["peso_valido"]=='1')
				{
					echo "<td width='76'>Ventana</td>";
				}
				else
				{
					echo "<td width='76'>Origen</td>";
				}
				echo "<td width='192'>".$Fila["descripcion_ingles"]."</td>";
				echo "</tr>";
			}
			echo "</table>";
		?>
        <br>
        <table width="750" border="0" class="tablainterior">
          <tr> 
            <td align="right"> <div align="center"> 
                <input type="button" name="BtnNuevo" value="Nuevo" style="width:60" onClick="MostrarPopupProceso('N');">
                <input type="button" name="BtnModificar" value="Modificar" style="width:60" onClick="MostrarPopupProceso('M');">
                <input type="button" name="BtnEliminar" value="Eliminar" style="width:60" onClick="MostrarPopupProceso('E');">
                <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              </div></td>
          </tr>
        </table>
        <br></td>
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
