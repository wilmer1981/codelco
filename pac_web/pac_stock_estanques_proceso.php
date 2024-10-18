<?php 	
	include("../principal/conectar_pac_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut =$CookieRut;

	$EncontroRelacion = isset($_REQUEST["EncontroRelacion"])?$_REQUEST["EncontroRelacion"]:"";
	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");

	$Ano    =isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:date("Y");
	$Mes    =isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:date("m");
	
	$CheckEK         = isset($_REQUEST["CheckEK"])?$_REQUEST["CheckEK"]:"";
	$TxtStockInicial = isset($_REQUEST["TxtStockInicial"])?$_REQUEST["TxtStockInicial"]:"";
	$TxtStockActual  = isset($_REQUEST["TxtStockActual"])?$_REQUEST["TxtStockActual"]:"";
	$TxtRecepcion = isset($_REQUEST["TxtRecepcion"])?$_REQUEST["TxtRecepcion"]:"";
	$TxtEnvio     = isset($_REQUEST["TxtEnvio"])?$_REQUEST["TxtEnvio"]:"";
	$CmbSigno     = isset($_REQUEST["CmbSigno"])?$_REQUEST["CmbSigno"]:"";
	$TxtAjuste    = isset($_REQUEST["TxtAjuste"])?$_REQUEST["TxtAjuste"]:"";

	switch($Proceso)
	{
		case "N":
			break;
		case "M":
			$Datos=$Valores;
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					
					$AnoMes =substr($Datos,0,$i);
					$Ano    =substr($AnoMes,0,4);
					$Mes    =substr($AnoMes,4);
					break;
				}
			}
			break;	
	}	

?>
<html>
<head>
<script language="JavaScript">

function TeclaPulsada1 () 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	var CantComas =0;
	
	if (teclaCodigo == 13)
	{
		//Frm.CmbHoraInicio.focus();
	}
	else
	{
		if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo !=9))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		else
		{
			/*CantComas=Frm.TxtStockInicial[1].value.search(',');
			if (CantComas!=-1)
			{
				event.keyCode=46;
				return;
			}
			if ((Frm.TxtStockInicial[1].value.substr(Frm.TxtStockInicial[1].value.length-1,1)==",")||(Frm.TxtStockInicial[1].value.substr(Frm.TxtStockInicial[1].value.length-1,1)==""))
			{
				if ((teclaCodigo != 37)&&(teclaCodigo != 39))
				{
					event.keyCode=46;
				}	
			}*/
		}
	}	
} 

function Grabar(Proceso,Valores,CmbAno,CmbMes)
{
	var Frm=document.FrmProceso;
	Frm.action="pac_stock_estanques_proceso01.php?Proceso="+Proceso+"&Valores="+Valores+"&CmbAno="+CmbAno+"&CmbMes="+CmbMes;
	Frm.submit();						
	
}
function Recarga(Proceso)
{
	var Frm=document.FrmProceso;

	Frm.action="pac_stock_estanques_proceso.php?CmbAno="+Frm.CmbAno.value+"&CmbMes="+Frm.CmbMes.value+"&Proceso="+Proceso;
	Frm.submit();						
}

function Salir()
{
	window.close();
	
}
function Todos(F,Proceso)
{
	var Fila = 0; //Posicion Inicial de la Fila.
	var Col = 7;

	if (Proceso=="N")
	{
		Fila=4;
	}
	else
	{
		Fila=1;
	}
	if (F.CheckTodos.checked == true)
		valor = true
	else valor = false;		

	pos = Fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = F.elements.length;
	for (i=pos; i<largo; i=i+Col)
	{	
		if (F.elements[i].type != 'checkbox')
			return;
		else 
			F.elements[i].checked = valor;
	}	
}
function Calcula(J)
{
	var Frm=document.FrmProceso;
	
	/*alert(Frm.elements[J+5].name);
	alert(Frm.elements[J+5].value);*/
	Frm.elements[J+5].value=Number(Frm.elements[J].value)+Number(Frm.elements[J+1].value)-Number(Frm.elements[J+2].value);
	if (Frm.elements[J+3].value=='+')
	{
		Frm.elements[J+5].value=Number(Frm.elements[J+5].value)+Number(Frm.elements[J+4].value);
	}
	else
	{
		Frm.elements[J+5].value=Number(Frm.elements[J+5].value)-Number(Frm.elements[J+4].value);
	}
	return;	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<?php
	if ($Proceso=='N')
	{
		//echo "<body onload='document.FrmProceso.CmbAno.focus()' background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
	}
	else
	{
		echo "<body  background='../principal/imagenes/fondo3.gif' leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";	
	}
?>

<form name="FrmProceso" method="post" action="">
  <table width="600" height="245" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td valign="top">
<table width="590" border="0" align="center" cellpadding="5" class="TablaInterior">
          <tr> 
            <td> Año 
              <?php
				if ($Proceso!="M")
				{
					echo "<select name='CmbAno' size='1' style='width:70px;'>";
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($CmbAno))
						{
							if ($i==$CmbAno)
								{
									echo "<option selected value ='$i'>$i</option>";
									$Ano=$i;
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}/*
						else
						{
							if ($i==date("Y"))
								{
									echo "<option selected value ='$i'>$i</option>";
									$Ano=$i;
								}
							else	
								{
									echo "<option value='".$i."'>".$i."</option>";
								}
						}*/		
					}
				    echo "</select>";
			    }
			    else
			    {
				echo $Ano;
			    }   
				
			?>
              Mes 
              <?php
				if ($Proceso!="M")
				{	
				  echo "<select name='CmbMes' size='1' style='width:90px;' >";
				  for($i=1;$i<13;$i++)
				  {
						if (isset($CmbMes))
						{
							if ($i==$CmbMes)
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
								$Mes=$i;
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
								$Mes=$i;
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						}	
				   }
				   echo "</select>";
				   echo "<input type='Button' name='TxtOk' value='Ok' onClick=Recarga('$Proceso');></td>";
				}
				else
				{
					echo $meses[$Mes-1];
				}   
		  	 ?>
               
          </tr>
        </table>
        <BR>
        <?php
			echo "<table width='590' border='1' cellpadding='3' cellspacing='0' >";
			echo "<tr class='ColorTabla01'>";
			echo "<td width='40'><input type='checkbox' name='CheckTodos' value='checkbox' onClick=\"Todos(this.form,'$Proceso');\"></td>";
			echo "<td width='100' align='center'>Stock-Inicial(Ton)</td>";
			echo "<td width='100' align='center'>Prod.-Prest.(Ton)</td>";
			echo "<td width='100' align='center'>Envio-Trasp.(Ton)</td>";
			echo "<td width='100' align='center'>Ajustes(Ton)</td>";
			echo "<td width='100' align='center'>Stock-Actual(Ton)</td>";
			echo "</tr>";
			//$Consulta="select count(*) as TotalRegistro from pac_web.stock_estanques t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase = '9001' and t1.cod_estanque=t2.cod_subclase where ano=".$Ano." and mes=".$Mes;
			$Consulta=" SELECT count(*) as TotalRegistro from pac_web.stock_estanques t1";
			$Consulta.=" LEFT JOIN proyecto_modernizacion.sub_clase t2 on t2.cod_clase = '9001' and t1.cod_estanque=t2.cod_subclase ";
			$Consulta.=" WHERE EXTRACT(YEAR FROM t1.fecha)='".$Ano."' AND EXTRACT(MONTH FROM t1.fecha)='".$Mes."' ";	
			//echo $Consulta;	
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			if ($Fila["TotalRegistro"] > 0 )
			{
				$FechaDesde=$Ano."-".$Mes."-01 00:00:01";
				$FechaHasta=$Ano."-".$Mes."-31 23:59:59";
				//$Consulta="select * from pac_web.stock_estanques t1 left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase = 9001 and t1.cod_estanque=t2.cod_subclase where ano=".$Ano." and mes=".$Mes." and t2.cod_subclase <> '5' order by t1.cod_estanque";
				$Consulta="SELECT * from pac_web.stock_estanques t1 ";
				$Consulta.=" LEFT JOIN proyecto_modernizacion.sub_clase t2 on t2.cod_clase = '9001' and t1.cod_estanque=t2.cod_subclase";
				$Consulta.=" WHERE EXTRACT(YEAR FROM t1.fecha)='".$Ano."' AND EXTRACT(MONTH FROM t1.fecha)='".$Mes."' AND t2.cod_subclase <> '5'";
				$Consulta.=" ORDER BY t1.cod_estanque";				
				$Respuesta=mysqli_query($link, $Consulta);
				$i=1;
				if ($Proceso=='M')
				{
					$J=1;
				}
				else
				{
					$J=4;
				}
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					echo "<tr>";
					$StockActual=0;
					$StockActual2=0;//wso
					echo "<td width='40'><input type='checkbox' name='CheckEK[".$i."]' value='".$Fila["cod_estanque"]."'>".$Fila["nombre_subclase"]."</td>";
					if ($Fila["stock_inicial"]!=0)
					{
						echo "<td width='100' align='center'><input type='text' style='width:70' name ='TxtStockInicial[".$i."]' value ='".$Fila["stock_inicial"]."' maxlength='9' onBlur=\"Calcula(".($J+1).");\" onKeyDown='TeclaPulsada1()';></td>";
						$MesAux='A';//Actual
					}
					else
					{
						if($Mes=='1')
						{
							$AnoStock=$Ano-1;
							$MesStock=12;								
						}
						else
						{
							$AnoStock=$Ano;
							$MesStock=$Mes-1;								
						}
						//$Consulta="select stock_actual from pac_web.stock_estanques where ano=".$AnoStock." and mes=".$MesStock." and cod_estanque=".$Fila["cod_estanque"];						
						
						$Consulta="SELECT stock_actual from pac_web.stock_estanques";						
						$Consulta.=" WHERE EXTRACT(YEAR FROM fecha)='".$AnoStock."' AND EXTRACT(MONTH FROM fecha)='".$MesStock."' AND cod_estanque='".$Fila["cod_estanque"]."' ";						
						
						$RespuestaStock=mysqli_query($link, $Consulta);
						if ($FilaStock=mysqli_fetch_array($RespuestaStock))
						{	
							echo "<td width='100' align='center'><input type='text' style='width:70' name ='TxtStockInicial[".$i."]' value ='".$FilaStock["stock_actual"]."' maxlength='9' onKeyDown='TeclaPulsada1()';></td>";
							$StockActual2=$FilaStock["stock_actual"];
						}
						else
						{
							echo "<td width='100' align='center'><input type='text' style='width:70' name ='TxtStockInicial[".$i."]' value ='0' maxlength='9' onKeyDown='TeclaPulsada1()';></td>";						
							$StockActual2=0;
						}
						$MesAux='D';//DIFERENTE AL ACTUAL

					}	
					$Recepcion=0;
					$Consulta="select * from pac_web.movimientos where (tipo_movimiento=2 or tipo_movimiento=6  or tipo_movimiento=4) and fecha_hora between '".$FechaDesde."' and '".$FechaHasta."' and cod_estanque_destino = ".$Fila["cod_estanque"];
					$Respuesta2=mysqli_query($link, $Consulta);
					while ($Fila2=mysqli_fetch_array($Respuesta2))
					{
						$Recepcion=$Recepcion+$Fila2["toneladas"];	
					}
					$StockActual = $Fila["stock_inicial"]+$Recepcion;
					$StockActual2= $StockActual2 + $Recepcion;
					echo "<td width='100' align='center'><input type='text' style='width:70' name ='TxtRecepcion[".$i."]' value ='".$Recepcion."' readonly></td>";
					$Envio=0;
					$Consulta="select * from pac_web.movimientos where (tipo_movimiento=1 or tipo_movimiento=4 or tipo_movimiento=5 or tipo_movimiento=7) and fecha_hora between '".$FechaDesde."' and '".$FechaHasta."' and cod_estanque_origen = ".$Fila["cod_estanque"];
					$Respuesta2=mysqli_query($link, $Consulta);
					while ($Fila2=mysqli_fetch_array($Respuesta2))
					{
						$Envio=$Envio+$Fila2["toneladas"];	
					}
					$StockActual=abs($StockActual-$Envio);
					$StockActual2=abs($StockActual2-$Envio);
					echo "<td width='100' align='center'><input type='text' style='width:70' name ='TxtEnvio[".$i."]' value ='".$Envio."' readonly></td>";
					echo "<td width='100' align='center'>";
					echo "<select name='CmbSigno[".$i."]' size='1' style='width:35px;' >";
					if ($Fila["signo"]=='+')
					{
						echo "<option value='+' selected>+</option>";
						echo "<option value='-' >-</option>";
						$StockActual=$StockActual+$Fila["ajuste"];
						$StockActual2=$StockActual2+$Fila["ajuste"];
					}
					else
					{
						echo "<option value='-' selected>-</option>";
						echo "<option value='+' >+</option>";
						$StockActual=$StockActual-$Fila["ajuste"];
						$StockActual2=$StockActual2-$Fila["ajuste"];
					}
					echo "</select>";
					//echo $StockActual2;
					echo "<input type='text' style='width:65' name ='TxtAjuste[".$i."]' value ='".$Fila["ajuste"]."' maxlength='9' onBlur=\"Calcula(".($J+1).");\" onKeyDown='TeclaPulsada1()'>";
					echo "</td>";
					if ($MesAux=='A')
					{
						echo "<td width='100' align='center'><input type='text' style='width:70' name ='TxtStockActual[".$i."]' value ='".$StockActual."' readonly></td>";
					}
					else
					{
						echo "<td width='100' align='center'><input type='text' style='width:70' name ='TxtStockActual[".$i."]' value ='".$StockActual2."' readonly></td>";					
					}	
					$i=$i+1;
					$J=$J+7;
					echo "</tr>";
				}	
			}
			else
			{
				echo "<script languaje='javascript'>";
				echo "var Frm=document.FrmProceso;";
				echo "Frm.action='pac_stock_estanques_proceso01.php?Proceso=N';";
				echo "Frm.submit();";
				echo "</script>";
			}
			echo "</table>";
		?>
        <br>
        <table width="590" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('M','<?php echo $Valores;?>','<?php echo $Ano;?>','<?php echo $Mes;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> 
      </td>
  </tr>
</table>
  </form>
</body>
</html>
