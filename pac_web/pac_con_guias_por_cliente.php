<?php
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var Frm=document.FrmConsultaGuiasClientes;
	switch (opt)
	{
		case "W":
			Frm.action = "pac_con_guias_por_cliente.php";
			Frm.submit();
			break;
		case "E":
			Frm.action = "pac_xls_guias_por_cliente.php?Mostrar=S";
			Frm.submit();
			break;
		case "I":
			window.print();			
	}
}
function Recarga()
{
	var Frm=document.FrmConsultaGuiasClientes;
	
	if (Frm.CmbClientes.value=='-1')
	{
		alert("Debe Seleccionar Clientes");
		Frm.CmbClientes.focus();
		return;	
	}
	Frm.action = "pac_con_guias_por_cliente.php?Mostrar=S";
	Frm.submit();

}
function Historial(NG)
{
	var Frm=document.FrmGuia;
	var Valores="";
	window.open("pac_guia_despacho02.php?Valores="+NG,"","top=50,left=10,width=700,height=340,scrollbars=no,resizable = yes");
}
function Salir()
{
	var Frm=document.FrmConsultaGuiasClientes;
	
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=15";
	Frm.submit();

}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="FrmConsultaGuiasClientes" action="" method="post">
  <table width="750" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr> 
      <td width="101"> Inicio Consulta:</td>
      <td width="231"><font size="2"> 
        <select name="CmbDias" style="width:40px;">
          <?php
				
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
			?>
        </select>
        </font> <font size="2"> 
        <select name="CmbMes" style="width:90px;">
          <?php
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
		    ?>
        </select>
        </font> <select name="CmbAno" style="width:70px;">
          <?php
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
			?>
        </select></td>
      <td width="54">Termino Consulta:</td>
      <td><select name="CmbDiasT" style="width:40px;">
          <?php
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
			?>
        </select> <select name="CmbMesT" style="width:90px;">
          <?php
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
		   ?>
        </select> <select name="CmbAnoT" style="width:70px;">
          <?php
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
			?>
        </select></td>
      <td width="80">&nbsp;</td>
    </tr>
    <tr align="center"> 
      <td> <div align="left">Cliente</div></td>
      <td><div align="left">
          <select name="CmbClientes" style="width:250">
          <option value="-1" selected>Seleccionar</option>
		  <?php
			  $Consulta="select distinct t1.rut_cliente,t2.nombre from pac_web.guia_despacho t1 left join clientes t2 on t1.rut_cliente=t2.rut_cliente";
			  $Respuesta=mysqli_query($link, $Consulta);			  
			  while($Fila=mysqli_fetch_array($Respuesta))
			  {
				if ($CmbClientes==$Fila[rut_cliente])
				{
					echo "<option value='".$Fila[rut_cliente]."' selected>".$Fila["nombre"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila[rut_cliente]."'>".$Fila["nombre"]."</option>";
				}		  
			  }
		  ?>
		  </select>
        </div></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr align="center"> 
      <td colspan="5"><input name="BtnConsulta" type="button" value="Consultar" style="width:70px;" onClick="Recarga();"> 
        <input name="BtnExcel" type="button" value="Excel" style="width:70px;" onClick="Proceso('E');"> 
        <input name="BtnImprimir" type="button" value="Imprimir" style="width:70px;" onClick="Proceso('I');"> 
		<input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="Salir();"> 
      </td>
    </tr>
  </table>
  <br>
  <table width='750' border='0' cellpadding='3' cellspacing='0' bordercolor='#b26c4a' class='TablaDetalle'>
    <tr class='ColorTabla01'> 
      <td width='50' align="center">Guia</td>
      <td width='50' align='center'>Patente</td>
      <td width='130' align='center'>Fecha</td>
	  <td width='60' align='center'>EK Origen</td>
      <td width='60' align='center'>Toneladas</td>
    </tr>
    <?php	
		if ($Mostrar=='S')
		{
			  $FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
			  $FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
			  $Consulta="select t1.num_guia,t1.nro_patente,t1.fecha_hora,t2.nombre_subclase as estanque,t1.toneladas ";
			  $Consulta=$Consulta."from pac_web.guia_despacho t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase=9001 and t2.cod_subclase=t1.cod_estanque where rut_cliente='".$CmbClientes."' and fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'";
			  $Respuesta=mysqli_query($link, $Consulta);			  
			  while($Fila=mysqli_fetch_array($Respuesta))
			  {
				  echo "<tr>";
				  echo "<td width='50' align='center'><a href=\"JavaScript:Historial('".$Fila["num_guia"]."')\">".$Fila["num_guia"]."</td>";
				  echo "<td width='50' align='center'>".$Fila["nro_patente"]."</td>";
				  echo "<td width='130' align='center'>".$Fila["fecha_hora"]."</td>";
				  echo "<td width='60' align='center'>".$Fila[estanque]."</td>";
				  echo "<td width='60' align='center'>".$Fila[toneladas]."</td>";
				  echo "</tr>";				  
			  } 	
		}		
	?>
  </table>		
</form>		
</body>
</html>
