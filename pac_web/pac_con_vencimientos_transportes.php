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
	var Frm=document.FrmConsultaVencimientos;
	switch (opt)
	{
		case "E":
			Frm.action = "pac_xls_vencimientos_transportes.php?Mostrar=S";
			Frm.submit();
			break;
		case "I":
			window.print();			
	}
}
function Recarga()
{
	var Frm=document.FrmConsultaVencimientos;
	
	Frm.action = "pac_con_vencimientos_transportes.php?Mostrar=S";
	Frm.submit();

}
function Salir()
{
	var Frm=document.FrmConsultaVencimientos;
	
	Frm.action="../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=15";
	Frm.submit();

}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="FrmConsultaVencimientos" action="" method="post">
  <table width="750" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr> 
      <td width="116">Fecha de Consulta</td>
      <td colspan="4"><font size="2"> 
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
    </tr>
    <tr align="center"> 
      <td> <div align="left">Tipo Transporte</div></td>
      <td colspan="4"><div align="left">
          <select name="CmbTransporte" style="width:150">
          <option value="-1" selected>Todos</option>
		  <?php
		  	if (isset($CmbTransporte))
			{
				switch ($CmbTransporte)
				{
					case "C";
						echo "<option value='C'selected>Camion</option>";
						echo "<option value='R'>Rampla</option>";
						break;
					case "R":
						echo "<option value='C'>Camion</option>";
						echo "<option value='R' selected>Rampla</option>";
						break;
					default:
						echo "<option value='C'>Camion</option>";
						echo "<option value='R'>Rampla</option>";
						break;
				}	
			}	
			else
			{
				echo "<option value='C'>Camion</option>";
				echo "<option value='R'>Rampla</option>";
			}
		  ?>
		  </select>
        </div></td>
    </tr>
    <tr align="center"> 
      <td> <div align="left">&nbsp;</div></td>
      <td colspan="4"><div align="left"> 
		&nbsp;
        </div></td>
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
      <td width='70' align="center">Patente</td>
	  <td width='70' align="center">Tipo</td>
      <td width='100' align='center'>Marca</td>
      <td width='100' align='center'>Modelo</td>
	  <td width='110' align='center'>Fecha Rev.Tecnica</td>
      <td width='110' align='center'>Fecha Cert. EK</td>
    </tr>
    <?php	
		if ($Mostrar=='S')
		{
			  if (strlen($CmbDias) == 1)
			      $CmbDias = '0'.$CmbDias;
			  if (strlen($CmbMes) == 1)	  
			      $CmbMes = '0'.$CmbMes;
			  
			  $FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias;
			  
			  switch ($CmbTransporte)
			  {
			  		case "-1":
						$Filtro="where tipo <> 'B' ";					
						break;
			  		case "C":
						$Filtro="where tipo = 'C' ";										
						break;
			  		case "R":
						$Filtro="where tipo = 'R' ";										
						break;
			  }
			  $Consulta="select distinct(nro_patente),marca,modelo,fecha_rev_tecnica,fecha_cert_estanque,tipo,(case when tipo='C' then 'Camion' else 'Rampla' end) as tipotransp from pac_web.camiones_por_transportista ".$Filtro." order by tipo,nro_patente";
			  $Respuesta=mysqli_query($link, $Consulta);			  
			  while($Fila=mysqli_fetch_array($Respuesta))
			  {
  				  
				  //echo "patente:".$Fila["nro_patente"]." tipo:".$Fila[tipo]." fecha:".$Fila[fecha_rev_tecnica]."<".date($FechaInicio);
				  if (($Fila[tipo]=='C')&&(date($Fila[fecha_rev_tecnica])<date($FechaInicio)))
				  {
					  echo "<tr>";
					  echo "<td width='70' align='left'>".$Fila["nro_patente"]."</td>";
					  echo "<td width='70' align='left'>".$Fila[tipotransp]."</td>";
					  echo "<td width='100' align='left'>".$Fila[marca]."</td>";
					  echo "<td width='100' align='left'>".$Fila[modelo]."</td>";
					  echo "<td width='110' align='center'><strong><font color='red'>".$Fila[fecha_rev_tecnica]."</font></strong></td>";
	   				  echo "<td width='110'>&nbsp;</td>";
					  echo "</tr>";
				   }  				  
				  if (($Fila[tipo]=='R')&&((date($Fila[fecha_rev_tecnica])<date($FechaInicio))||(date($Fila[fecha_cert_estanque])<date($FechaInicio))))
				  {
					  echo "<tr>";
					  echo "<td width='70' align='left'>".$Fila["nro_patente"]."</td>";
					  echo "<td width='70' align='left'>".$Fila[tipotransp]."</td>";
					  echo "<td width='100' align='left'>".$Fila[marca]."</td>";
					  echo "<td width='100' align='left'>".$Fila[modelo]."</td>";
					  if (date($Fila[fecha_rev_tecnica])<date($FechaInicio))
					  {
					  	echo "<td width='110' align='center'><strong><font color='red'>".$Fila[fecha_rev_tecnica]."</font></strong></td>";
					  }
					  else
					  {
					  	echo "<td width='110' align='center'><strong><font color='green'>".$Fila[fecha_rev_tecnica]."</font></strong></td>";
					  }
					  if (date($Fila[fecha_cert_estanque])<date($FechaInicio))
					  {
  					  	echo "<td width='110' align='center'><strong><font color='red'>".$Fila[fecha_cert_estanque]."</font></strong></td>";
					  }
					  else
					  {
					  	echo "<td width='110' align='center'><strong><font color='green'>".$Fila[fecha_cert_estanque]."</font></strong></td>";	
					  } 	
					  echo "</tr>";
				   }  				  
			  } 	
		}		
	?>
  </table>		
</form>		
</body>
</html>
