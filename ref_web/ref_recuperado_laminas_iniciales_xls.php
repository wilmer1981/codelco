<?php
    header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_principal.php");
	if (!isset($DiaIni))
	{
		$DiaIni = date("d");
		$MesIni = date("m");
		$AnoIni = date("Y");
		$DiaFin = date("d");
		$MesFin = date("m");
		$AnoFin = date("Y");
	}
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Informe Clasificacion Catodos Conerciales</title>
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	if (opcion=='S')
	   {f.action = "ref_clasificacion_catodos_comerciales.php?cmbcircuito="+f.cmbcircuito.value+"&Buscar=S"+"&DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value;}
		f.submit();
}
function Imprimir(f)
{
	window.print();
}
function Salir(f)
{
 window.close();
}
function Grafico(f)
{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	
	var URL ="../ref_web/ref_grafico_clasificacion_cat_com_global.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=930 height=650 scrollbars=no");
}	
function Excel(f)

{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	document.location = "ref_globales_selec_catodos_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value;
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
</script>
</head>
<form name="frmPrincipal" action="" method="post">
  <table width="632" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="7" class="ColorTabla01"><strong>Informe Rechazo Laminas Iniciales 
        (Recuperado) </strong></td>
    </tr>
    <tr> 
      <td width="90" class="Detalle02"><strong>Fecha Inicio:</strong></td>
      <td width="84" class="detalle01"><strong><?php echo $FechaInicio;?></strong>
	  <input name="AnoIni" type="hidden" value="<?php echo $AnoIni;?>">
	  <input name="MesIni" type="hidden" value="<?php echo $MesIni;?>">
	  <input name="DiaIni" type="hidden" value="<?php echo $DiaIni;?>"></td>
      <td width="51"></td>
      <td width="89" class="Detalle02"><strong>Fecha Termino:</strong></td>
      <td width="78" class="detalle01"><strong><?php echo $FechaTermino;?></strong>
	  <input name="AnoFin" type="hidden" value="<?php echo $AnoFin;?>">
	  <input name="MesFin" type="hidden" value="<?php echo $MesFin;?>">
	  <input name="DiaFin" type="hidden" value="<?php echo $DiaFin;?>"></td>
      <td width="47" ></td>
      <td width="162"></td>
    </tr>
  </table>
  <table width="594" border="2" align="center" cellpadding="2" cellspacing="2" bordercolor="#b26c4a" class="TablaDetalle">
  	<tr bgcolor="#FFFFFF" class="ColorTabla01"> 
	<td width="87" align="center"><strong>Fecha</strong><strong></strong></td>
	  <td width="128" align="center"><strong>Recuperado</strong></td>
	  <td width="98" align="center"><strong>Recuperado (%)</strong></td>
	</tr>
    <?php
	  $consulta="select * from ref_web.recuperado where fecha between '".$FechaInicio."' and '".$FechaTermino."' ";
	  $respuesta=mysqli_query($link, $consulta);
	  while ($row=mysqli_fetch_array($respuesta))
	      {
		    echo "<tr>\n";
		    echo "<td align='center' class=detalle01>".$row["fecha"]."</td>\n";
			echo "<td align='center' class=detalle01>".$row[recuperado]."</td>\n";
			$consulta_fecha="select cod_grupo,max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <=  '".$row["fecha"]."' and cod_grupo in ('01','02','07','08') group by cod_grupo";
		    $respuesta_fecha = mysqli_query($link, $consulta_fecha);
			$produccion=0;
		    while ($row_fecha = mysqli_fetch_array($respuesta_fecha))
			       {
		             $consulta_datos_grupo =  "select max(fecha) as fecha,cod_grupo,cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
		             $consulta_datos_grupo.= " where fecha = '".$row_fecha["fecha"]."' and cod_grupo='".$row_fecha["cod_grupo"]."'  group by cod_grupo ";
		             $respuesta_datos_grupo = mysqli_query($link, $consulta_datos_grupo);
	   	             $row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
		             $produccion=$produccion+(($row_datos_grupo["hojas_madres"]*$row_datos_grupo[num_catodos_celdas])*2);
                    }
			$porcentaje_recuperado=number_format(($row[recuperado]/$produccion)*100,"2",".",".");		
			echo "<td align='center' class=detalle01>".$porcentaje_recuperado."</td>\n";


		  
		  
		  }
	
	
      echo '</table>';
         
	?>
  </table>
  <p></p>
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel(this.form)"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
  </tr>
</table>
</form>
</html>

