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
	var Frm = document.FrmConsultaMov;
	switch (opt)
	{
		case "W":
			if (Frm.CmbEstado=='-1')
			{
				alert('Debe Seleccionar Movimiento');
				Frm.CmbEstado.focus();
				return;
			}
			Frm.action = "pac_con_estanque_estaticos.php?Mostrar=S";
			Frm.submit();
			break;
		case "E":
			Frm.action = "pac_xls_estanque_estaticos.php?Mostrar=S";
			Frm.submit();
			break;
		case "I":
			window.print();			
	}
}
function  Salir()
{
	var Frm = document.FrmConsultaMov; 
	Frm.action = "../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=15";
	Frm.submit();
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="FrmConsultaMov" action="" method="post">
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
      <td width="120">Termino Consulta:</td>
      <td width="210"><select name="CmbDiasT" style="width:40px;">
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
      <td width="58">&nbsp;</td>
    </tr>
    <tr align="center"> 
      <td> <div align="left">Estanques</div></td>
      <td colspan="4"><div align="left"> 
          <select name="CmbEK">
            <option value="-1" selected>Todos</option>
            <?php
			  $Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase ='9001' and cod_subclase <> '5'";
			  $Respuesta=mysqli_query($link, $Consulta);			  
			  while($Fila=mysqli_fetch_array($Respuesta))
			  {
				if ($CmbEK==$Fila["cod_subclase"])
				{
					echo "<option value='".$Fila["cod_subclase"]."' selected>".$Fila["nombre_subclase"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila["cod_subclase"]."'>".$Fila["nombre_subclase"]."</option>";
				}		  
			  }
		  ?>
          </select>
          &nbsp;&nbsp;<strong>(Max. 2 Dias Sin Movimiento)</strong> </div></td>
    </tr>
    <tr align="center"> 
      <td colspan="5"><input name="BtnConsulta" type="button" value="Consultar" style="width:70px;" onClick="Proceso('W');"> 
        <input name="BtnExcel" type="button" value="Excel" style="width:70px;" onClick="Proceso('E');"> 
        <input name="BtnImprimir" type="button" value="Imprimir" style="width:70px;" onClick="Proceso('I');"> 
        <input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="Salir();"> 
      </td>
    </tr>
  </table>
  <br>
  <table width='750' border='0' cellpadding='3' cellspacing='0' bordercolor='#b26c4a' class='TablaDetalle'>
    <tr class='ColorTabla01'> 
      <td width='40'  align="center">EK</td>
      <td width='140' align='center'>Fecha Movimiento Anterior</td>
      <td width='140' align='left'>Tipo Movimiento Anterior</td>
	  <td width='140' align='left'>Fecha Movimiento Siguiente</td>
      <td width='140' align='center'>Tipo Movimiento Siguiente</td>
	  <td width='60'  align='center'>Dif.Dias</td>
    </tr>
    <?php
		if ($Mostrar=='S')
		{
			if ($CmbEK=='-1')
			{
				$Filtro='';
			}
			else
			{
				$Filtro= " and (cod_estanque_origen='".$CmbEK."' or cod_estanque_destino='".$CmbEK."')";
			}
			$FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
			$FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
			$Consulta="select t1.fecha_hora,t1.tipo_movimiento,if(isnull(t1.cod_estanque_origen),t3.nombre_subclase,t2.nombre_subclase)as estanque from pac_web.movimientos t1 ";
			$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase=9001 and t1.cod_estanque_origen = t2.cod_subclase ";
			$Consulta=$Consulta." left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase=9001 and t1.cod_estanque_destino = t3.cod_subclase ";
			$Consulta=$Consulta." where fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'".$Filtro." order by estanque,fecha_hora";
			$Respuesta=mysqli_query($link, $Consulta);
			$FechaAnt=0;
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				$FechaReal=$Fila["fecha_hora"];
				$Consulta="select (DAYOFYEAR('".$FechaReal."')-DAYOFYEAR('".$FechaAnt."')) as difdia";
				$RespuestaDif=mysqli_query($link, $Consulta);
				$FilaDif=mysqli_fetch_array($RespuestaDif);
				if ((!is_null($FilaDif[difdia]))&&($FilaDif[difdia]>2))
				{
					$Consulta="select nombre_subclase as mov from proyecto_modernizacion.sub_clase where cod_clase=9000 and cod_subclase=".$MovAnt;
					$RespuestaMov=mysqli_query($link, $Consulta);
					$FilaMov=mysqli_fetch_array($RespuestaMov);
					$DescripMov1=$FilaMov[mov];
					$Consulta="select nombre_subclase as mov from proyecto_modernizacion.sub_clase where cod_clase=9000 and cod_subclase=".$Fila[tipo_movimiento];
					$RespuestaMov=mysqli_query($link, $Consulta);
					$FilaMov=mysqli_fetch_array($RespuestaMov);
					$DescripMov2=$FilaMov[mov];
					echo "<tr>";
					echo "<td width='40' align='center'>".$Fila[estanque]."</td>";
					echo "<td width='140'  align='center'>".$Fecha2."</td>";
					echo "<td width='140'  align='left'>".$DescripMov1."</td>";
					echo "<td width='140'  align='center'>".$Fila["fecha_hora"]."</td>";
					echo "<td width='140'  align='left'>".$DescripMov2."</td>";
					echo "<td width='60'   align='right'>".$FilaDif[difdia]."</td>";
					echo "</tr>";
				}
				$FechaAnt=$Fila["fecha_hora"];	
				$Fecha2=$Fila["fecha_hora"];
				$MovAnt=$Fila[tipo_movimiento];
			}
		}				
	?>
  </table>		
</form>		
</body>
</html>
