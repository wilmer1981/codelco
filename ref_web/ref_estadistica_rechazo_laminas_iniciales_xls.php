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
<title>Informe Rechazo Laminas Iniciales</title>
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	if (opcion=='S')
	   {f.action = "ref_estadistica_rechazo_laminas_iniciales.php?cmbgrupo="+f.cmbgrupo.value+"&Buscar=S"+"&DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value;}
	f.submit();
}
function Imprimir(f)
{
	window.print();
}
function Salir(f)
{
 f.action ="../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
 f.submit();
}
function Grafico(f)
{
	var fecha1=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var fecha2=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;
	
	var URL ="ref_grafico_rechazo_lam_iniciales.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value+"&cmbgrupo="+f.cmbgrupo.value;
    window.open(URL,"","menubar=no resizable=no top=50 left=200 width=930 height=650 scrollbars=no");
}	
function Excel(f)

{
	document.location = "refestadistica_rechazo_laminas_iniciales_xls.php?DiaIni="+f.DiaIni.value+"&MesIni="+f.MesIni.value+"&AnoIni="+f.AnoIni.value+"&DiaFin="+f.DiaFin.value+"&MesFin="+f.MesFin.value+"&AnoFin="+f.AnoFin.value+"&cmbgrupo="+f.cmbgrupo.value+"&mostrar=S";
}
function detalle_anodos(fecha,grupo)
{
	var Frm=document.form1;
	window.open("Detalle_carga_anodos.php?fecha="+ fecha+"&grupo="+grupo,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
	
}
function Globales()
{
	var f=document.frmPrincipal;
	var FechaInicio=f.AnoIni.value+"-"+f.MesIni.value+"-"+f.DiaIni.value;
	var FechaTermino=f.AnoFin.value+"-"+f.MesFin.value+"-"+f.DiaFin.value;

	var URL ="ref_global_rechazo_laminas_iniciales.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value;
    window.open(URL,"","menubar=no resizable=yes top=50 left=200 width=700 height=200 scrollbars=yes");
}
function Recuperado() 
{
 var f=document.frmPrincipal;
 window.open("ref_recuperado_laminas_iniciales.php?AnoIni="+f.AnoIni.value+"&MesIni="+f.MesIni.value+"&DiaIni="+f.DiaIni.value+"&AnoFin="+f.AnoFin.value+"&MesFin="+f.MesFin.value+"&DiaFin="+f.DiaFin.value,"","top=50,left=10,width=740,height=300,scrollbars=yes,resizable = yes");					
}
</script>
</head>
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="5" class="ColorTabla01"><strong>INFORME DE RECHAZO LAMINAS 
        INICIALES </strong></td>
    </tr>
    <tr> 
      <td width="100">Fecha Inicio:<?php echo $FechaInicio;?>Fecha Termino:<?php echo $FechaTermino;?></td>
	 </tr>
	 <tr>
	   <td>Grupo<?php echo $cmbgrupo;?></td>
    </tr>
    <tr align="center"> 
      <td height="10" colspan="5"></td>
    </tr>
  </table>
<?php if ($cmbgrupo<>'99')
   //echo '<table width="753" border="2" cellspacing="2" align="center" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
   {?>
  <tr>
    <td></td>
  </tr>
    <table width="753" border="1" cellspacing="0" cellpadding="3">
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td width="117" align="center"><strong>Grupo <?php echo $cmbgrupo; ?></strong></td>
      <td colspan="5" align="center"><div align="center"><strong>Rechazo</strong></div></td>
    </tr>
    <tr bgcolor="#FFFFFF" class="ColorTabla01"> 
      <td align="center"><div align="center"><strong>Fecha</strong></div></td>
      <td width="69" align="center"><div align="center"><strong>Delgadas</strong></div></td>
      <td width="82" align="center"><div align="center"><strong>Granuladas</strong></div></td>
      <td width="75" align="center"><div align="center"><strong>Gruesas</strong></div></td>
      <td width="65" align="center"><div align="center"><strong>Total</strong></div></td>
      <td width="85" align="center"><div align="center"><strong>%</strong></div></td>
    </tr>
    <?php
	   $cmbgrupo=intval($cmbgrupo);
	   $consulta="select ifnull(sum(rechazo_delgadas),0) as rechazo_delgadas, ifnull(sum(rechazo_granuladas),0) as rechazo_granuladas,";
	   $consulta.=" ifnull(sum(rechazo_gruesas),0) as rechazo_gruezas, fecha as fecha from ref_web.produccion where cod_grupo='".$cmbgrupo."' and fecha between '".$FechaInicio."' and '".$FechaTermino."'";
	   $consulta.=" group by cod_grupo,fecha ";
	   //echo $consulta;
	   $respuesta=mysqli_query($link, $consulta);
	   while ($row=mysqli_fetch_array($respuesta))
	   {
	   	    $rechazo_delgadas = intval($row[rechazo_delgadas]);
	   	    $rechazo_granuladas = intval($row[rechazo_granuladas]);
	   	    $rechazo_gruesas = intval($row[rechazo_gruesas]);
		   echo "<tr>\n";
		   echo "<td align='center' class=detalle01>".$row["fecha"]."&nbsp</td>\n";
		   echo "<td align='right'>".$rechazo_delgadas."</td>\n";
		   echo "<td align='right'>".$rechazo_granuladas."</td>\n";
		   echo "<td align='right'>".$rechazo_gruesas."</td>\n";
		   $total_rechazo=$row[rechazo_delgadas]+$row[rechazo_granuladas]+$row[rechazo_gruesas];
		   echo "<td align='right'>".$total_rechazo."</td>\n";
		   $consulta_fecha="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <=  '".$row["fecha"]."' and cod_grupo ='0".$cmbgrupo."' group by cod_grupo";
		   $respuesta_fecha = mysqli_query($link, $consulta_fecha);
		   $row_fecha = mysqli_fetch_array($respuesta_fecha);
		   $consulta_datos_grupo =  "select max(fecha) as fecha,cod_grupo,cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
		   $consulta_datos_grupo.= " where fecha = '".$row_fecha["fecha"]."' and cod_grupo ='0".$cmbgrupo."' group by cod_grupo ";
		   $respuesta_datos_grupo = mysqli_query($link, $consulta_datos_grupo);
	   	   $row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
		   $produccion=(($row_datos_grupo[hojas_madres]*$row_datos_grupo[num_catodos_celdas])*2);
		   $porcentaje_rechazado=number_format(($total_rechazo/$produccion)*100,"2",".",".");
		   echo "<td align='right'>".$porcentaje_rechazado."</td>\n";
		  
		  }
	?>
  </table>
  <?php } 
  else { ?>
  <?php 
		  $consulta_grupo="select distinct cod_grupo from ref_web.grupo_electrolitico2 where hojas_madres<>'0' order by cod_grupo";
		  $respuesta_grupo=mysqli_query($link, $consulta_grupo);
		  while ($row_grupo=mysqli_fetch_array($respuesta_grupo))
			  {
			     
				     echo '<tr>';
					 echo '<td>&nbsp;</td>';
					 echo '</tr>';
					 echo '<table width="753" border="2" cellspacing="2" align="center" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
					 echo '<tr bgcolor="#FFFFFF" class="ColorTabla01"> ';
					 echo '<td width="117" align="center"><strong>Grupo '.$row_grupo["cod_grupo"].'</strong></td>';
					 echo '<td colspan="5" align="center"><strong>Rechazo</strong></td>';
					 echo '</tr>';
					 echo '<tr bgcolor="#FFFFFF" class="ColorTabla01"> ';
					 echo ' <td align="center"><strong>Fecha</strong></td>';
					 echo '<td width="69" align="center"><strong>Delgadas</strong></td>';
					 echo '<td width="82" align="center"><strong>Granuladas</strong></td>';
					 echo '<td width="75" align="center"><strong>Gruesas</strong></td>';
					 echo '<td width="65" align="center"><strong>Total</strong></td>';
					 echo '<td width="85" align="center"><strong>%</strong></td>';
					 echo '</tr>';
					 $row_grupo["cod_grupo"]=intval($row_grupo["cod_grupo"]);
					 $consulta="select * from ref_web.produccion where cod_grupo='".$row_grupo["cod_grupo"]."' and fecha between '".$FechaInicio."' and '".$FechaTermino."'";
					 $respuesta=mysqli_query($link, $consulta);
 				     while ($row=mysqli_fetch_array($respuesta))
						  {
						   echo "<tr>\n";
						   echo "<td align='center' class=detalle01>".$row["fecha"]."&nbsp</td>\n";
						   echo "<td align='right'>".$row[rechazo_delgadas]."</td>\n";
						   echo "<td align='right'>".$row[rechazo_granuladas]."</td>\n";
						   echo "<td align='right'>".$row[rechazo_gruesas]."</td>\n";
						   $total_rechazo=$row[rechazo_delgadas]+$row[rechazo_granuladas]+$row[rechazo_gruesas];
						   echo "<td align='right'>".$total_rechazo."</td>\n";
						   $consulta_fecha="select max(fecha) as fecha from ref_web.grupo_electrolitico2 where fecha <=  '".$row["fecha"]."' and cod_grupo ='0".$row_grupo["cod_grupo"]."' group by cod_grupo";
						   $respuesta_fecha = mysqli_query($link, $consulta_fecha);
						   $row_fecha = mysqli_fetch_array($respuesta_fecha);
						   $consulta_datos_grupo =  "select max(fecha) as fecha,cod_grupo,cod_circuito,hojas_madres,num_catodos_celdas from ref_web.grupo_electrolitico2 ";
						   $consulta_datos_grupo.= " where fecha = '".$row_fecha["fecha"]."' and cod_grupo ='0".$row_grupo["cod_grupo"]."' group by cod_grupo ";
						   $respuesta_datos_grupo = mysqli_query($link, $consulta_datos_grupo);
						   $row_datos_grupo = mysqli_fetch_array($respuesta_datos_grupo);
						   $produccion=(($row_datos_grupo[hojas_madres]*$row_datos_grupo[num_catodos_celdas])*2);
						   $porcentaje_rechazado=number_format(($total_rechazo/$produccion)*100,"2",".",".");
						   echo "<td align='right'>".$porcentaje_rechazado."</td>\n";
						   
						 }
					 echo '</table>';
					 echo '<tr>';
					 echo '<td>&nbsp;</td>';
					 echo '</tr>';
			 }
  }
  ?>
</form>
</html>
