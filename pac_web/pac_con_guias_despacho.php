 <?php
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

	$Mostrar = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$CmbDias       = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:date("d");
	$CmbMes       = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno       = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbDiasT      = isset($_REQUEST["CmbDiasT"])?$_REQUEST["CmbDiasT"]:date("d");
	$CmbMesT       = isset($_REQUEST["CmbMesT"])?$_REQUEST["CmbMesT"]:date("m");
	$CmbAnoT      = isset($_REQUEST["CmbAnoT"])?$_REQUEST["CmbAnoT"]:date("Y");

	$CmbGuias      = isset($_REQUEST["CmbGuias"])?$_REQUEST["CmbGuias"]:"";

?>
<html>
<head>
<title>Planta de &Aacute;cido</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var Frm = document.FrmConsultaGuias;
	switch (opt)
	{
		case "W":
			if (Frm.CmbEstado=='-1')
			{
				alert('Debe Seleccionar Movimiento');
				Frm.CmbEstado.focus();
				return;
			}
			Frm.action = "pac_con_guias_despacho.php?Mostrar=S";
			Frm.submit();
			break;
		case "E":
			Frm.action = "pac_xls_guias_despacho.php?Mostrar=S";
			Frm.submit();
			break;
		case "I":
			window.print();			
	}
}
function Historial(NG)
{
	var Frm=document.FrmGuia;
	var Valores="";
	window.open("pac_guia_despacho02.php?Valores="+NG,"","top=110,left=10,width=700,height=335,scrollbars=no,resizable = yes");
}
function  Salir()
{
	var Frm = document.FrmConsultaGuias; 
	Frm.action = "../principal/sistemas_usuario.php?CodSistema=9&Nivel=1&CodPantalla=15";
	Frm.submit();
}
</script>
</head>

<body background="../Principal/imagenes/fondo3.gif">
<form name="FrmConsultaGuias" action="" method="post">
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
      <td> <div align="left">Guias</div></td>
      <td><div align="left">
          <select name="CmbGuias">
          <option value="-1" selected>Todos</option>
		  <?php
			if ($CmbGuias=='C')
			{
				echo "<option value='C' selected>Camiones</option>";
				echo "<option value='B'>Buques</option>";
			}
			else
			{
				if ($CmbGuias=='B')
				{
					echo "<option value='C'>Camiones</option>";
					echo "<option value='B' selected>Buques</option>";
				}
				else
				{
					echo "<option value='C'>Camiones</option>";
					echo "<option value='B'>Buques</option>";
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
      <td colspan="5"><input name="BtnConsulta" type="button" value="Consultar" style="width:70px;" onClick="Proceso('W');"> 
        <input name="BtnExcel" type="button" value="Excel" style="width:70px;" onClick="Proceso('E');">
		<input name="BtnImprimir" type="button" value="Imprimir" style="width:70px;" onClick="Proceso('I');"> 
        <input name="BtnSalir" type="button" value="Salir" style="width:70px;" onClick="Salir();"> 
      </td>
    </tr>
  </table>
  <br>
  <table width='750' border='1' cellpadding='3' cellspacing='0' class='TablaDetalle'>
    <tr class='ColorTabla01'> 
      <td width='125' align="center">Fecha</td>
      <td width='60'  align='center'>Guia</td>
      <td width='60'  align='center'>Patente</td>
      <td width='125'  align='left'>Cliente</td>
      <td width='50'  align='center'>Toneladas</td>
	  <td width='50'  align='center'>V.Unitario</td>
      <td width='50'  align='left'>Tipo</td>
      <td width='110' align='left'>Operador</td>
    </tr>
    <?php
		if ($Mostrar=='S')
		{
			if ($CmbGuias=='-1')
			{
				$Filtro='';
			}
			else
			{
				$Filtro= " and t1.tipo_guia='".$CmbGuias."'";
			}
			$FechaInicio=$CmbAno."-".$CmbMes."-".$CmbDias." 00:00:01";
			$FechaTermino=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT." 23:59:59";
			$Consulta="select t1.fecha_hora,t1.num_guia,t1.nro_patente,t1.toneladas,t2.nombre,t1.tipo_guia,t3.valor_subclase1 as operador,t1.valor_unitario ";
			$Consulta=$Consulta." from pac_web.guia_despacho t1 left join pac_web.clientes t2 on t1.rut_cliente = t2.rut_cliente";
			$Consulta=$Consulta." left join  proyecto_modernizacion.sub_clase t3 on t3.cod_clase=9002 and t1.rut_funcionario =t3.nombre_subclase ";
			$Consulta=$Consulta." where fecha_hora between '".$FechaInicio."' and '".$FechaTermino."'".$Filtro;
			$Respuesta=mysqli_query($link, $Consulta);
			$Total=0;
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
				echo "<td width='125' align='center'>".$Fila["fecha_hora"]."</td>";
				echo "<td width='50' align='center'><a href=\"JavaScript:Historial('".$Fila["num_guia"]."')\">".$Fila["num_guia"]."</td>";
				echo "<td width='60'  align='center'>".$Fila["nro_patente"]."</td>";
				echo "<td width='125'  align='left'>".$Fila["nombre"]."</td>";
				echo "<td width='50'  align='right'>".$Fila["toneladas"]."</td>";
				echo "<td width='50'  align='right'>".$Fila["valor_unitario"]."</td>";
				if ($Fila[tipo_guia]=='C')
				{
					echo "<td width='50'  align='center'>Camion</td>";
				}
				else
				{
					echo "<td width='50'  align='center'>Buque</td>";
				}
				echo "<td width='110' align='left'>".$Fila["operador"]."</td>";
				echo "</tr>";
				$Total=$Total+$Fila["toneladas"];
			}
			echo "<tr class='Detalle01'>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>Total</td>";
			echo "<td align='right'>".number_format($Total,'2',',','.')."</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
		}				
	?>
  </table>		
</form>		
</body>
</html>
