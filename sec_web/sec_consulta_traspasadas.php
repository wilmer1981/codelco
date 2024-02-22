<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 37;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$CmbDias = isset($_REQUEST["CmbDias"])?$_REQUEST["CmbDias"]:date('d');
	$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('m');
	$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');
	$CmbDiasT = isset($_REQUEST["CmbDiasT"])?$_REQUEST["CmbDiasT"]:date('d');
	$CmbMesT = isset($_REQUEST["CmbMesT"])?$_REQUEST["CmbMesT"]:date('m');
	$CmbAnoT = isset($_REQUEST["CmbAnoT"])?$_REQUEST["CmbAnoT"]:date('Y');

	$TipoIE = isset($_REQUEST["TipoIE"])?$_REQUEST["TipoIE"]:"";


?>
<html>
<head>
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 100 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4) 
		{
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function MostrarPaquetes(cod_bulto,num_bulto,ie)
{
	
	window.open("sec_paquetes_series.php?Proceso=T&CodBulto="+cod_bulto+"&NumBulto="+num_bulto+"&IE="+ie,"","top=110,left=3,width=770,height=340,scrollbars=no,resizable = yes");

}
function Recarga()
{
	var Frm=document.FrmProgLoteo;
	
	Frm.action="sec_consulta_traspasadas.php";
	Frm.submit();
	
}

function Imprimir()
{
	var Frm=document.FrmProgLoteo;
	
	window.print();	
}
function Excel(Tipo)
{
	var Frm=document.FrmProgLoteo;
	
	Frm.action="sec_consulta_traspasadas_excel.php";
	Frm.submit();

}
function Eliminar()
{
	var Frm=document.FrmProgLoteo;
	var Datos='';
	var Verificar='';
	
	if(confirm('Esta Seguro de Eliminar Movimiento'))
	{
		for(i=0;i<=Frm.OptTraspaso.length-1;i++)
		{
			if(Frm.OptTraspaso[i].checked)
			{
				Datos=Frm.OptTraspaso[i].value;
				break;
			}	
		}
		Verificar=Datos.split('|');
		if(Verificar[6]=='N')
		{
			Frm.action="sec_consulta_traspasadas_proceso01.php?Proceso=E&Valores="+Datos;
			Frm.submit();
		}
		else
		{
			alert('No se puede Eliminar Esta en RAF');
		}
	}	
}
function Modificar()
{
	var Frm=document.FrmProgLoteo;
	var Datos='';
	
	for(i=0;i<=Frm.OptTraspaso.length-1;i++)
	{
		if(Frm.OptTraspaso[i].checked)
		{
			Datos=Frm.OptTraspaso[i].value;
			break;
		}	
	}
	
	if(Datos!='')
		window.open("sec_consulta_traspasadas_proceso.php?Valores="+Datos,"","top=195,left=180,width=500,height=250,scrollbars=yes,resizable = yes");
}
function Salir()
{
	var Frm=document.FrmProgLoteo;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
	Frm.submit();
	
}
</script>
<title>Consulta Lotes Traspasados a RAF</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProgLoteo" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  	<table width="770" height="350" border="0" class="TablaPrincipal" left="6" cellpadding="6" cellspacing="0">
	<tr>
      <td align="center" valign="top"><br>
	  <table width="730" border="0">
	  <tr align="center">
	  <td>Fecha Inicio:&nbsp;
	  <?php
		echo "<SELECT name='CmbDias' onchange='Recarga()'>";
		for ($i=1;$i<=31;$i++)
		{
			if (isset($CmbDias))
			{
				if ($i==$CmbDias)
				{ 
					echo "<option SELECTed value= '".$i."'>".$i."</option>";
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
					echo "<option SELECTed value= '".$i."'>".$i."</option>";
				}
				else
				{
				  echo "<option value='".$i."'>".$i."</option>";
				}
			}	
		}
		echo"</SELECT>";
		echo"<SELECT name='CmbMes' onchange='Recarga()'>";
		for($i=1;$i<13;$i++)
		{
			if (isset($CmbMes))
			{
				if ($i==$CmbMes)
				{
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}
				else
				{
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
			}	
		}
		echo "</SELECT>";
		echo "<SELECT name='CmbAno' onchange='Recarga()'>";
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (isset($CmbAno))
			{
				if ($i==$CmbAno)
					{
						echo "<option SELECTed value ='$i'>$i</option>";
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
						echo "<option SELECTed value ='$i'>$i</option>";
					}
				else	
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
			}		
		}
		echo "</SELECT>&nbsp;&nbsp;Fecha Termino:&nbsp;";
		echo "<SELECT name='CmbDiasT' onchange='Recarga()'>";
		for ($i=1;$i<=31;$i++)
		{
			if (isset($CmbDiasT))
			{
				if ($i==$CmbDiasT)
				{
					echo "<option SELECTed value= '".$i."'>".$i."</option>";
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
					echo "<option SELECTed value= '".$i."'>".$i."</option>";
				}
				else
				{
				  echo "<option value='".$i."'>".$i."</option>";
				}
			}	
		}
		echo"</SELECT>";
		echo"<SELECT name='CmbMesT' onchange='Recarga()'>";
		for($i=1;$i<13;$i++)
		{
			if (isset($CmbMesT))
			{
				if ($i==$CmbMesT)
				{
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}
				else
				{
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
			}	
		}
		echo "</SELECT>";
		echo "<SELECT name='CmbAnoT' onchange='Recarga()'>";
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (isset($CmbAnoT))
			{
				if ($i==$CmbAnoT)
					{
						echo "<option SELECTed value ='$i'>$i</option>";
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
						echo "<option SELECTed value ='$i'>$i</option>";
					}
				else	
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
			}		
		}
		echo "</SELECT>&nbsp;&nbsp;";
		echo "<input type='button' name='BtnBuscar' value='Buscar' onclick='Recarga();'>";	  
	  
	  ?>
	  </td>
	  </tr>
	  </table><br>
	  <table width="730" border="0" class="tablainterior">
        <tr>
          <td align="center">
            <input type="button" name="BtnImprimir2" value="Imprimir" style="width:90" onClick="Imprimir();">
            <input type="button" name="BtnExcel2" value="Excel" style="width:90" onClick="Excel('<?php echo $TipoIE;?>');">
			<input type="button" name="BtnElimnar" value="Eliminar Traspaso" style="width:120" onClick="Eliminar();">
			<input type="button" name="BtnModFecha" value="Mod.Fecha Trasp." style="width:120" onClick="Modificar();">
            <input type="button" name="BtnSalir2" value="Salir" style="width:90" onClick="Salir();">
          </td>
        </tr>
      </table>	  <br>
	  <table width="730" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01">
		  <?php
			echo "<td width='10' align='center'>&nbsp;</td>";
			echo "<td width='50' align='center'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hornada</td>";
			echo "<td width='220' align='center'>SubProducto</td>";
			echo "<td width='90' align='center'>&nbsp;Fecha Traspaso</td>";
			echo "<td width='60' align='center'>Peso</td>";
			echo "<td width='60' align='center'>Paquetes</td>";
			echo "<td width='60' align='center'>N� Lote</td>";
			/*poly 29.04.2004*/
			echo "<td width='60' align='center'>Destino</td>";
		  ?>	
          </tr>
        </table></div>
		<?php
			if (strlen($CmbMes)==1)
			{
				$CmbMes="0".$CmbMes;
			}
			if (strlen($CmbDias)==1)
			{
				$CmbDias="0".$CmbDias;
			}
			if (strlen($CmbMesT)==1)
			{
				$CmbMesT="0".$CmbMesT;
			}
			if (strlen($CmbDiasT)==1)
			{
				$CmbDiasT="0".$CmbDiasT;
			}
			$FechaTraspaso=$CmbAno."-".$CmbMes."-".$CmbDias;
			$FechaTraspasoT=$CmbAnoT."-".$CmbMesT."-".$CmbDiasT;
			echo "<table width='730' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			/*$Consulta="SELECT t1.hornada,t1.fecha_traspaso,t1.peso,t1.unidades,t1.cod_bulto,t1.num_bulto,";
			$Consulta=$Consulta." t2.descripcion as producto,t3.descripcion as subproducto from sec_web.traspaso t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
			$Consulta=$Consulta." where t1.fecha_traspaso between  '".$FechaTraspaso."' and '".$FechaTraspasoT."'";*/
			$Total=0;
			$TotalUnid=0;
			$Consulta="SELECT t1.cod_producto,t1.cod_subproducto,t1.sw from sec_web.traspaso t1";
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
			$Consulta=$Consulta." where t1.fecha_traspaso between  '".$FechaTraspaso."' and '".$FechaTraspasoT."'";
			$Consulta=$Consulta." group by t1.cod_producto,t1.cod_subproducto,sw";
			
			$Resultado=mysqli_query($link, $Consulta);
			echo "<input type='hidden' name='OptTraspaso'>";
			while($Fila=mysqli_fetch_array($Resultado))
			{
				$TotalPeso=0;
				$CantUnid=0;
				$Consulta="SELECT t1.hornada,t1.fecha_traspaso,t1.peso,t1.unidades,t1.cod_bulto,t1.num_bulto,";
				$Consulta=$Consulta." t2.descripcion as producto,t3.descripcion as subproducto from sec_web.traspaso t1";
				$Consulta=$Consulta." left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
				$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
				$Consulta=$Consulta." where t1.fecha_traspaso between  '".$FechaTraspaso."' and '".$FechaTraspasoT."'";
				$Consulta=$Consulta." and t1.cod_producto='".$Fila["cod_producto"]."' and t1.cod_subproducto='".$Fila["cod_subproducto"]."' and t1.sw='".$Fila["sw"]."'";
				
				$Resultado2=mysqli_query($link, $Consulta);
				while($Fila2=mysqli_fetch_array($Resultado2))  
				{
					$EstaEnRaf='N';
					$Consulta="SELECT * from sea_web.movimientos where tipo_movimiento='4' and hornada='".$Fila2["hornada"]."' and cod_producto='".$Fila["cod_producto"]."' and cod_subproducto='".$Fila["cod_subproducto"]."'";
					//echo $Consulta."<br>";
					$Resultado3=mysqli_query($link, $Consulta);
					if($Fila3=mysqli_fetch_array($Resultado3))
						$EstaEnRaf='S';
					echo "<tr>";
					$Cont2++;
					$Valores=$Fila2["hornada"]."|".$Fila2["fecha_traspaso"]."|".$Fila["cod_producto"]."|".$Fila["cod_subproducto"]."|".$Fila2["peso"]."|".$Fila2["subproducto"]."|".$EstaEnRaf;
					echo "<td width='10' ><input type='radio' name='OptTraspaso' value='".$Valores."'></td>";
					echo "<td width='40'  onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>";
					echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:550px'>\n";
					echo "<font face='courier' color='#000000' size=1><b>Producto:&nbsp;</b>".$Fila2["producto"]."&nbsp;<b>Sub-Producto:&nbsp;</b>".$Fila2["subproducto"]." </font><br>";
					echo "</div>".$Fila2["hornada"]."</td>";
					echo "<td width='180'>".$Fila2["subproducto"]."&nbsp;</td>";
					echo "<td width='80' align='center'>".$Fila2["fecha_traspaso"]."&nbsp;</td>";
					echo "<td width='60' align='right'>".number_format($Fila2["peso"],0,',','.')."</td>";
					echo "<td width='60' align='right'>".$Fila2["unidades"]."&nbsp;</td>";
					echo "<td width='60' align='left'><a href=\"JavaScript:MostrarPaquetes('".$Fila2["cod_bulto"]."','".$Fila2["num_bulto"]."','".$Fila2["hornada"]."')\">\n";
					/*poly echo $Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</a></td>\n";*/
					 echo $Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."</a></td>\n";
					 if ($Fila["sw"] == 1)
					 	{
							$destino ="RAF";
							echo "<td width='60' align='center'><em><strong>".$destino."&nbsp;</em></strong></td>";
						}
					if ($Fila["sw"] == 2)
						{
							$destino ="PMN";
							echo "<td width='60' align='center'><em><strong>".$destino."&nbsp;</em></strong></td>";
						}
										if ($Fila["sw"] == 3)
						{
							$destino ="REFINERIA ELECTROLITICA";
							echo "<td width='60' align='center'><em><strong>".$destino."&nbsp;</em></strong></td>";
						}
					//echo "<td width='60' align='center'><em><strong>".$EstaEnRaf."&nbsp;</em></strong></td>";
					 /*poly*/	
					echo "</tr>";
					$TotalPeso=$TotalPeso+$Fila2["peso"];
					$CantUnid=$CantUnid+$Fila2["unidades"];
					$Total=$Total+$Fila2["peso"];
					$TotalUnid=$TotalUnid+$Fila2["unidades"];
				}
				echo "<tr class='detalle01'>";
				echo "<td colspan='4'><strong>SUB-TOTAL</strong></td>";  
				//echo "<td>&nbsp;</strong></td>";
				//echo "<td>&nbsp;</strong></td>";
				echo "<td width='60' align='right'><strong>".number_format($TotalPeso,0,',','.')."</strong></td>";
				echo "<td width='60' align='right'><strong>".number_format($CantUnid,0,',','.')."&nbsp;</strong></td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo"</tr>";
					
			}
			echo "<tr class='detalle01'>";
			echo "<td colspan='4'><strong>TOTAL</strong></td>";
			//echo "<td>&nbsp;</strong></td>";
			//echo "<td>&nbsp;</strong></td>";
			echo "<td  width='60' align='right'><strong>".number_format($Total,0,',','.')."</strong></td>";
			echo "<td  width='60' align='right'><strong>".number_format($TotalUnid,0,',','.')."&nbsp;</strong></td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo"</tr>";
			echo "</table>";	
		?>
		<br>
		<table width="730" border="0" class="tablainterior">
          <tr>
              <td align="center">
			   	<input type="button" name="BtnImprimir" value="Imprimir" style="width:90" onClick="Imprimir();">
				<input type="button" name="BtnExcel" value="Excel" style="width:90" onClick="Excel('<?php echo $TipoIE;?>');">		
                <input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">
			</td>
          </tr>
        </table><br>
      </td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
