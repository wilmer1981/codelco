<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 41;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Rut =$CookieRut;
	$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '3'";
	$Respuesta =mysqli_query($link, $Consulta);
	if($Fila =mysqli_fetch_array($Respuesta))
	{
		$Nivel = $Fila["nivel"];
	}
	if (!isset($CmbAno))
	{
		$CmbAno=date('Y');
	}
	if (!isset($CmbMes))
	{
		$CmbMes=date('n');
	}
	else
	{
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase=3004 and cod_subclase =".$CmbMes;
		$Respuesta =mysqli_query($link, $Consulta);
		if($Fila =mysqli_fetch_array($Respuesta))
		{
			$Letra=$Fila["nombre_subclase"];
		}		
	}
	
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
function MostrarPaquetes(cod_bulto,num_bulto,ie)
{
	window.open("sec_paquetes_series.php?CodBulto="+cod_bulto+"&NumBulto="+num_bulto+"&IE="+ie,"","top=110,left=3,width=770,height=340,scrollbars=no,resizable = yes");
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
function RecuperarValores()
{
	var Frm=document.FrmStockSec;
	var Valores=new String();
	
	for (i=1;i<Frm.TxtStockFinal.length;i++)
	{
		Valores=Valores + Frm.TxtStockFinal[i].value +"~~"+Frm.TxtCodProducto[i].value+"~~"+Frm.TxtCodSubProducto[i].value+"//";
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		Valores="";
		return(Valores);	
	}	
} 

function Recarga()
{
	var Frm=document.FrmStockSec;
	
	Frm.action="sec_stock_disponible.php?Buscar=S";
	Frm.submit();
	
}
function Imprimir()
{
	window.print();	
}

function Excel()
{
	var Frm=document.FrmStockSec;
	
	Frm.action="sec_stock_disponible_excel.php";
	Frm.submit();
	
}

function Grabar()
{
	var Frm=document.FrmStockSec;
	var Valores="";
	
	if (confirm('Esta Seguro de Grabar los Datos'))
	{
		Valores=RecuperarValores();
		Frm.action="sec_stock_disponible01.php?Valores="+Valores;
		Frm.submit();
	}	
}

function Salir()
{
	var Frm=document.FrmStockSec;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
	Frm.submit();
	
}
</script>
<title>Stock Catodos Productos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmStockSec" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
  <tr>
      <td align="center"><br>
	  <table width="730" border="0" class="tablainterior">
	  <tr>
	  <td>&nbsp;&nbsp;Mes Consulta:&nbsp;&nbsp;
	  <?php
		echo"<select name='CmbMes' onchange='Recarga()'>";
		for($i=1;$i<13;$i++)
		{
			if (isset($CmbMes))
			{
				if ($i==$CmbMes)
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
			}	
			else
			{
				if ($i==date("n"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
			}	
		}
		echo "</select>";
		echo "<select name='CmbAno' onchange='Recarga()'>";
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (isset($CmbAno))
			{
				if ($i==$CmbAno)
						echo "<option selected value ='$i'>$i</option>";
				else	
						echo "<option value='".$i."'>".$i."</option>";
			}
			else
			{
				if ($i==date("Y"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}		
		}
		echo "</select>&nbsp;&nbsp;";
		echo "<input type='button' name='BtnRecarga' value='Ok' style='width:35' onClick='Recarga();'>";			
	  ?>
	  </td>
	  </tr>
	  </table><br>	  
	  <table width="730" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01">
		    <td align="center">&nbsp;</td>
			<td width='60' align="center">Existencia</td>
			<td colspan="3" width='' align="center">&nbsp;</td>
			<td width='' align="center">Existencia</td>
			<td width='' align="center">Comprometido</td>
			<td width='' align="center">Embarques</td>
			<td width='' align="center">Stock</td>
          </tr>
          <tr class="ColorTabla01">
		    <td align="center">Tipo Producto</td>
			<td width='60' align="center">Inicial</td>
			<td width='' align="center">Paquetes</td>
			<td width='' align="center">Traspaso</td>
			<td width='' align="center">Embarques</td>
			<td width='' align="center">Final</td>
			<td width='' align="center">Mes</td>
			<td width='' align="center">Mes</td>
			<td width='' align="center">Disponible</td>
			
          </tr>
		  <?php
			if($Buscar=='S')
			{
				if (strlen($CmbMes)==1)
					$CmbMes="0".$CmbMes;
				$FechaInicio=$CmbAno."-".$CmbMes."-01";
				$FechaTermino=$CmbAno."-".$CmbMes."-31";
				$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='3103' order by cod_subclase";
				$Respuesta3=mysqli_query($link, $Consulta);
				$TotalInicial=0;
				$TotalPaquetes=0;
				$TotalTraspaso=0;
				$TotalEmbarque=0;
				$TotalFinal=0;
				while ($Fila3=mysqli_fetch_array($Respuesta3))
				{
					echo "<tr>";
					echo "<td colspan='9' class='detalle01'><strong>".$Fila3["nombre_subclase"]."</STRONG></td>";
					echo "</tr>";	
					$Consulta="select cod_producto,cod_subproducto,abreviatura as nombre from proyecto_modernizacion.subproducto where stock_sec='".$Fila3["cod_subclase"]."' order by orden_stock_sec";
					$Respuesta=mysqli_query($link, $Consulta);
					echo "<input type='hidden' name='TxtCodProducto'><input type='hidden' name='TxtCodSubProducto'><input type='hidden' name='TxtStockFinal'>";
					$SubTotalInicial=0;
					$SubTotalPaquetes=0;
					$SubTotalTraspaso=0;
					$SubTotalEmbarque=0;
					$SubTotalFinal=0;
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						$StockFinal=0;
						echo "<tr>";
						echo "<td width='200'>".$Fila["nombre"]."</td>";
						//STOCK INICIAL
						$Consulta="select peso as peso_inicial from sec_web.stock_final where tipo='2' and cod_producto='".$Fila["cod_producto"]."'";
						$Consulta=$Consulta." and cod_subproducto ='".$Fila["cod_subproducto"]."' and fecha ";
						$Consulta=$Consulta." between subdate('$FechaInicio',interval 1 month) and subdate('$FechaTermino',interval 1 month)"; 
						$Respuesta2=mysqli_query($link, $Consulta);
						if ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							echo "<td class='detalle01' width='60' align='right'>".number_format($Fila2[peso_inicial],0,',','.')."</td>";
							$StockFinal=$StockFinal+$Fila2[peso_inicial];
							$SubTotalInicial=$SubTotalInicial+$Fila2[peso_inicial];
							$TotalInicial=$TotalInicial+$Fila2[peso_inicial];
						}
						else
							echo "<td class='detalle01' width='60' align='right'>0</td>";
						//STOCK PAQUETES
						$Paquetes=0;
						$Consulta="select sum(peso_paquetes) as peso_paquetes  from sec_web.paquete_catodo where cod_producto='".$Fila["cod_producto"]."'";
						$Consulta=$Consulta." and cod_subproducto ='".$Fila["cod_subproducto"]."' and cod_paquete='".$Letra."' and year(fecha_creacion_paquete)=".$CmbAno;
						$Consulta=$Consulta." group by cod_producto,cod_subproducto"; 
						$Respuesta2=mysqli_query($link, $Consulta);
						if ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							echo "<td width='60' align='right'>".number_format($Fila2["peso_paquetes"],0,',','.')."</td>";
							$StockFinal=$StockFinal+$Fila2["peso_paquetes"];
							$SubTotalPaquetes=$SubTotalPaquetes+$Fila2["peso_paquetes"];
							$TotalPaquetes=$TotalPaquetes+$Fila2["peso_paquetes"];
							$Paquetes=$Fila2["peso_paquetes"];
						}
						else
						{
							echo "<td width='60' align='right'>0</td>";
						}
						//STOCK TRASPASO
						$Consulta="select sum(peso) as peso_traspaso  from sec_web.traspaso where cod_producto='".$Fila["cod_producto"]."'";
						$Consulta=$Consulta." and cod_subproducto ='".$Fila["cod_subproducto"]."' and fecha_traspaso ";
						$Consulta=$Consulta." between '$FechaInicio' and '$FechaTermino'";
						$Consulta=$Consulta." group by cod_producto,cod_subproducto"; 
						$Respuesta2=mysqli_query($link, $Consulta);
						if ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							echo "<td width='60' align='right'>".number_format($Fila2["peso_traspaso"],0,',','.')."</td>";
							$StockFinal=abs($StockFinal-$Fila2["peso_traspaso"]);
							$SubTotalTraspaso=$SubTotalTraspaso+$Fila2["peso_traspaso"];
							$TotalTraspaso=$TotalTraspaso+$Fila2[peso_traspaso];
						}
						else
							echo "<td width='60' align='right'>0</td>";
						//STOCK EMBARQUE
						$Consulta = "select sum(t2.peso_paquetes) as peso_embarque  ";
						$Consulta.= "from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2  ";
						$Consulta.= "on t1.num_guia=t2.num_guia ";
						$Consulta.= "where (t1.cod_estado <>'A') and (t1.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."')";
						$Consulta.= " and (t2.cod_estado = 'c') and (t2.cod_producto='".$Fila["cod_producto"]."' and t2.cod_subproducto ='".$Fila["cod_subproducto"]."')";
						$Consulta.= "group by t2.cod_producto, t2.cod_subproducto ";
						//echo $Consulta."<br>";
						$Respuesta2=mysqli_query($link, $Consulta);
						if ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							echo "<td width='60' align='right'>".number_format($Fila2[peso_embarque],0,',','.')."</td>";
							$StockFinal=abs($StockFinal-$Fila2[peso_embarque]);
							$SubTotalEmbarque=$SubTotalEmbarque+$Fila2[peso_embarque];
							$TotalEmbarque=$TotalEmbarque+$Fila2[peso_embarque];
						}
						else
							echo "<td width='60' align='right'>0</td>";
						echo "<td class='detalle01' width='60' align='right'>".number_format($StockFinal,0,',','.')."</td>";
						$SubTotalFinal=$SubTotalFinal+$StockFinal;
						$TotalFinal=$TotalFinal+$StockFinal;
						echo "<input type='hidden' name='TxtCodProducto' value='".$Fila["cod_producto"]."'><input type='hidden' name='TxtCodSubProducto' value='".$Fila["cod_subproducto"]."'><input type='hidden' name='TxtStockFinal' value='".$StockFinal."'>";				
						//STOCK COMPROMETIDO
						$Consulta="select sum(cantidad_programada*1000) as comprometido from sec_web.programa_codelco where cod_contrato_maquila not in ('COMP_VEN') and corr_codelco <='13000' and fecha_programacion between '".$FechaInicio."' and '".$FechaTermino."' and estado2 not in ('A') and ";
						$Consulta.="cod_producto='".$Fila["cod_producto"]."' and cod_subproducto ='".$Fila["cod_subproducto"]."' group by cod_producto, cod_subproducto";					
						//echo $Consulta."<br>";
						$Respuesta2=mysqli_query($link, $Consulta);
						if ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							echo "<td class='detalle02' width='60' align='right'>".number_format($Fila2[comprometido],0,',','.')."</td>";
							$Comprometido=$Fila2[comprometido];
							//$StockFinal=$StockFinal+$Fila2[peso_inicial];
							$SubTotalComprometido=$SubTotalComprometido+$Fila2[comprometido];
							$TotalComprometido=$TotalComprometido+$Fila2[comprometido];
						}
						else
							echo "<td class='detalle02' width='60' align='right'>0</td>";
						//STOCK EMBARQUE MES	
						$Consulta = "select sum(t2.peso_paquetes) as peso_embarque  ";
						$Consulta.= "from sec_web.guia_despacho_emb t1 inner join sec_web.paquete_catodo t2  ";
						$Consulta.= "on t1.num_guia=t2.num_guia ";
						$Consulta.= "inner join sec_web.programa_codelco t3 on t1.corr_enm=t3.corr_codelco and t3.cod_contrato_maquila not in ('COMP_VEN') and t3.corr_codelco <='13000' and t3.fecha_programacion between '".$FechaInicio."' and '".$FechaTermino."' and t3.estado2 not in ('A') ";
						$Consulta.= "where (t1.cod_estado <>'A') and (t1.fecha_guia between '".$FechaInicio."' and '".$FechaTermino."')";
						$Consulta.= " and (t2.cod_estado = 'c') and (t2.cod_producto='".$Fila["cod_producto"]."' and t2.cod_subproducto ='".$Fila["cod_subproducto"]."')";
						$Consulta.= "group by t2.cod_producto, t2.cod_subproducto ";
						//echo $Consulta."<br>";
						$Respuesta2=mysqli_query($link, $Consulta);
						if ($Fila2=mysqli_fetch_array($Respuesta2))
						{
							echo "<td class='detalle02' width='60' align='right'>".number_format($Fila2[peso_embarque],0,',','.')."</td>";
							//$StockFinal=abs($StockFinal-$Fila2[peso_embarque]);
							$SubTotalEmbarqueMes=$SubTotalEmbarqueMes+$Fila2[peso_embarque];
							$TotalEmbarqueMes=$TotalEmbarqueMes+$Fila2[peso_embarque];
						}
						else
							echo "<td class='detalle02' width='60' align='right'>0</td>";
						echo "<td class='detalle02' width='60' align='right'>".number_format(abs($Comprometido-$Fila2[peso_embarque]),0,',','.')."</td>";
						$SubTotalStockDisp=$SubTotalStockDisp+abs($Comprometido-$Fila2[peso_embarque]);
						$TotalStockDisp=$TotalStockDisp+abs($Comprometido-$Fila2[peso_embarque]);
						$Comprometido=0;
						echo "</tr>";
					}
					echo "<tr>";
					echo "<td class='detalle01'>SUB-TOTAL</td>";
					echo "<td class='detalle01' width='60' align='right'>".number_format($SubTotalInicial,0,',','.')."</td>";
					echo "<td class='detalle01' width='60' align='right'>".number_format($SubTotalPaquetes,0,',','.')."</td>";
					echo "<td class='detalle01' width='60' align='right'>".number_format($SubTotalTraspaso,0,',','.')."</td>";
					echo "<td class='detalle01' width='60' align='right'>".number_format($SubTotalEmbarque,0,',','.')."</td>";
					echo "<td class='detalle01' width='60' align='right'>".number_format($SubTotalFinal,0,',','.')."</td>";
					echo "<td class='detalle02' width='60' align='right'>".number_format($SubTotalComprometido,0,',','.')."</td>";
					echo "<td class='detalle02' width='60' align='right'>".number_format($SubTotalEmbarqueMes,0,',','.')."</td>";
					echo "<td class='detalle02' width='60' align='right'>".number_format($SubTotalStockDisp,0,',','.')."</td>";			
					$SubTotalInicial=0;$SubTotalPaquetes=0;$SubTotalTraspaso=0;$SubTotalEmbarque=0;$SubTotalFinal=0;$SubTotalComprometido=0;$SubTotalEmbarqueMes=0;$SubTotalStockDisp=0;
					echo "</tr>";	
				}	
				echo "<td class='detalle01' width='60' align='left'><strong>TOTALES</strong></td>";
				echo "<td class='detalle01' width='60' align='right'><strong>".number_format($TotalInicial,0,',','.')."</td>";
				echo "<td class='detalle01' width='60' align='right'><strong>".number_format($TotalPaquetes,0,',','.')."</td>";
				echo "<td class='detalle01' width='60' align='right'><strong>".number_format($TotalTraspaso,0,',','.')."</td>";
				echo "<td class='detalle01' width='60' align='right'><strong>".number_format($TotalEmbarque,0,',','.')."</td>";
				echo "<td class='detalle01' width='60' align='right'><strong>".number_format($TotalFinal,0,',','.')."</strong></td>";
				echo "<td class='detalle01' width='60' align='right'>".number_format($TotalComprometido,0,',','.')."</td>";
				echo "<td class='detalle01' width='60' align='right'>".number_format($TotalEmbarqueMes,0,',','.')."</td>";
				echo "<td class='detalle01' width='60' align='right'>".number_format($TotalStockDisp,0,',','.')."</td>";
			}			
		  ?>
		  
        </table>
        <br>
          <table width="730" border="0" class="tablainterior">
          <tr>
              <td align="center">
			  <?php
				if (($Nivel=='1')||($Nivel=='6'))
					echo "<input type='button' name='BtnGrabar' value='Grabar' style='width:90' onClick='Grabar();'>";
			  ?>
                <input type="button" name="BtnImprimir" value="Imprimir" style="width:90" onClick="Imprimir();">
				<input type="button" name="BtnExcel" value="Excel" style="width:90" onClick="Excel();">
				<input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">
			</td>
          </tr>
        </table>
      </td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
