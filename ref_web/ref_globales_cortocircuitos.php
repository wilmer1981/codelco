<?php
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
<title>Informe de Cortocircuitos Globales </title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	if (opcion=='S')
	  // {f.action = "cortes2_aux.php?recarga=S"+"&dia1="+f.dia1.value+"&mes1="+f.mes1.value+"&ano1="+f.ano1.value+"&circuito="+f.cmbcircuito.value+"&mostrar=S&Buscar=N";}
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
	
	var URL ="ref_grafico_globales_all.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value;
    window.open(URL,"","menubar=no resizable=yes top=50 left=200 width=930 height=650 scrollbars=yes");
}	
function Excel(f)

{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	document.location = "ref_globales_cortocircuitos_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value;
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="632" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="7" class="ColorTabla01"><strong>INFORME DE GLOBAL DE CORTOCIRCUITOS</strong></td>
    </tr>
    <tr> 
      <td width="90" class="Detalle02"><strong>Fecha Inicio:</strong></td>
      <td width="84" class="detalle01"><strong><?php echo $FechaInicio;?></strong>
	  <input name="AnoIni" type="hidden" value="<?php echo $AnoIni;?>">
	  <input name="MesIni" type="hidden" value="<?php echo $MesIni;?>">
	  <input name="DiaIni" type="hidden" value="<?php echo $DiaIni;?>"></td>
      <td width="51">&nbsp;</td>
      <td width="136" class="Detalle02"><strong>Fecha Termino:</strong></td>
      <td width="101" class="detalle01"><strong><?php echo $FechaTermino;?></strong>
	  <input name="AnoFin" type="hidden" value="<?php echo $AnoFin;?>">
	  <input name="MesFin" type="hidden" value="<?php echo $MesFin;?>">
	  <input name="DiaFin" type="hidden" value="<?php echo $DiaFin;?>"></td>
      <td width="29" >&nbsp;</td>
      <td width="113"><input name="graficar" type="button" value="Grafico" onClick="Grafico(this.form)" ></td>
    </tr>
  </table>
  <table width="764" border="2" align="center" cellpadding="2" cellspacing="2" bordercolor="#b26c4a" class="TablaDetalle">
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td width="104" align="center"><strong>Fecha</strong><strong></strong></td>
      <td width="96" align="center"><strong>Circuito 1</strong></td>
      <td width="98" align="center"><strong>Circuito 2</strong></td>
      <td width="98" align="center"><strong>Circuito 3</strong></td>
      <td width="94" align="center"><strong>Circuito 4</strong></td>
      <td width="104" align="center"><strong>Circuito 5</strong></td>
      <td width="108" align="center"><strong>Circuito 6</strong></td>
    </tr>
    <?php
	   $consulta_fecha="select distinct(fecha) as fecha from ref_web.cortocircuitos where fecha between '".$FechaInicio."' and '".$FechaTermino."'";
	   $respuesta_fecha=mysqli_query($link, $consulta_fecha);
	   while ($row_fecha=mysqli_fetch_array($respuesta_fecha))
	          { ?>
			   <tr onMouseOver="if(!this.contains(event.fromElement)){this.bgColor='class=ColorTabla02';} if(!document.all){style.cursor='pointer'};style.cursor='hand';" onMouseOut="if(!this.contains(event.toElement)){this.bgColor=''; }" >
			  <?php 
			   echo '<td width="104" align="center" class=detalle01>'.$row_fecha["fecha"].'</td>';
			   $consulta_circuito="select distinct(cod_circuito) from sec_web.circuitos order by cod_circuito asc";
			   $respuesta_circuito=mysqli_query($link, $consulta_circuito);
			   while ($row_circuito=mysqli_fetch_array($respuesta_circuito))
			         {
						$consulta_datos="select fecha,ifnull((sum(cortos_nuevo)+sum(cortos_semi)),0) as suma ";
						$consulta_datos.="from ref_web.cortocircuitos  ";
						$consulta_datos.="where fecha ='".$row_fecha["fecha"]."' and cod_circuito='".$row_circuito[cod_circuito]."' ";
						$consulta_datos.="group by fecha, cod_circuito ";
						$consulta_datos.="order by fecha,cod_circuito,cod_grupo";
						$respuesta_datos=mysqli_query($link, $consulta_datos);
						while ($row_datos=mysqli_fetch_array($respuesta_datos))
						      {
							   echo '<td width="96" align="center">'.$row_datos[suma].'</td>';
							  }
					 }	
			  
			  }
	   
	
	 
	?>
  </table>
  <p>&nbsp;</p>
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel(this.form)"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
  </tr>
</table>
</form>
</body>
</html>

