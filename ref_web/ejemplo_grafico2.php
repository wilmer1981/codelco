<?php 

	include("../principal/conectar_ref_web.php");
	
	
?>
<html>
<head>
<script language="JavaScript">
function Buscar()
{
	var  f=document.form1;

	f.action='ref_ing_circuitos2.php?mostrar=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10";
}
function Excel()
{
	var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;


	document.location = "../ref_web/ref_web_xls.php?fecha="+fecha;
}
function Grafico()
{
    var  f=document.form1;
	var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;
	document.location="../ref_web/ejemplo_grafico.php?fecha="+fecha;

}
</script>
<title>Sistema GYC Nave Electrolitica</title>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="" method="post" name="form1">
<?php include("../principal/encabezado.php"); ?>
<?php
?>
 <table width="772" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
 <tr>
 <td width="760" align="center" valign="middle">
          <table width="750" border="0" cellpadding="3" class="TablaInterior">
            <tr>
              <td width="80">Informe del:</td>
              <td colspan="2">
			  <select name="dia1" size="1" >
				<?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{
						if (($mostrar == "S") && ($i == $dia1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("j")) and ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select> <select name="mes1" size="1" id="mes1">
		       	<?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';
					}
				?>
                </select> <select name="ano1" size="1" id="select4">
        		<?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
                </select>&nbsp;&nbsp;<input name="buscar" type="button" value="buscar" onClick="Buscar()" ></td>
            </tr>
          </table>
		  <BR>
		<table width="747" height="61" border="1"  align="center" cellpadding="2" cellspacing="0">
<?php
  $Consulta =  "select max(t2.fecha) as fecha,sum(t1.peso_produccion) as produccion,t2.cod_grupo,t2.cod_circuito from sec_web.produccion_catodo as t1 ";
	$Consulta = $Consulta." inner join sec_web.grupo_electrolitico2 as t2 on t1.cod_grupo=t2.cod_grupo";
	$Consulta = $Consulta." where t1.fecha_produccion = '".$fecha."' and t1.cod_grupo not in ('01','02','07') and t2.fecha <= '".$fecha."'group by t1.cod_grupo";
	
	$Respuesta = mysqli_query($link, $Consulta);
	$total_prod=0;
	$total_rec=0;
	$total_rech=0;
	$total_cuba=0;
	while ($Fila = mysqli_fetch_array($Respuesta))
	{
	   	$Consulta_turno="select turno as turno1 from cal_web.rechazo_catodos as t1 where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
		$respuesta_turno= mysqli_query($link, $Consulta_turno);
		$row_turno = mysqli_fetch_array($respuesta_turno);
		$produccion=number_format($Fila["produccion"],"",",",".");
		
/****************************************************************************************************************************************/
		$Consulta20="select fecha as fecha_fila from sec_web.grupo_electrolitico2 where cod_grupo='".$Fila["cod_grupo"]."' order by fecha asc";
		$respuesta20=mysqli_query($link, $Consulta20);
		$sw=0;
		while ($fila20=mysqli_fetch_array($respuesta20) and ($sw==0))
			{
				if ($fila20[fecha_fila] <= $fecha) 
			 		{$fecha_aux=$fila20[fecha_fila];}
			 else {$sw=1;}
			 }
	/****************************************************************************************************************************************/		
		$Consulta ="select ifnull(unid_recup,0) as recuperado_tot, ifnull(estampa,0) as ne, ifnull(dispersos,0) as nd, ifnull(rayado,0) as ra, ";
		$Consulta =$Consulta."ifnull(cordon_superior,0) as cs, ifnull(cordon_lateral,0) as cl, ifnull(otros,0) as ot from cal_web.rechazo_catodos as t1 " ;
		$Consulta = $Consulta."where t1.fecha = '".$fecha."' and t1.grupo = '".$Fila["cod_grupo"]."'";
	
		$Respuesta2 = mysqli_query($link, $Consulta);
		$Fila2 = mysqli_fetch_array($Respuesta2);
		$total_ne=$total_ne+$Fila2["ne"];
		$total_nd=$total_nd+$Fila2["nd"];
		$total_ra=$total_ra+$Fila2["ra"];
		$total_cl=$total_cl+$Fila2["cl"];
		$total_cs=$total_cs+$Fila2["cs"];
		$total_ot=$total_ot+$Fila2["ot"];
		$total_rechazos=$total_ne+$total_nd+$total_ra+$total_cl+$total_cs+$total_ot;
			
		
		$arreglo=array($total_ne,$total_nd,$total_ra,$total_cl,$total_cs,$total_ot);
		
	}


include("phpchartdir.php");

#The data for the line chart
$data = $arreglo;

#The labels for the line chart
$labels = array("1", "", "", "2", "", "", "3", "", "", "4", "", "", "5","", "", "6", "", "", "7", "", "", "8", "", "", "9","","","10","","","11","","","12","","","14","","","15");

#Create a XYChart object of size 300 x 280 pixels
$c = new XYChart(900, 400);

#Set the plotarea at (45, 30) and of size 200 x 200 pixels
$c->setPlotArea(45, 30, 750, 300);

#Add a title to the chart using 12 pts Arial Bold Italic font
$c->addTitle("Grafico Historia Rechazo (Ultimos 15 dias)", "arialbi.ttf", 12);

#Add a title to the y axis
$c->yAxis->setTitle("Total de Rechazos");

#Add a title to the x axis
$c->xAxis->setTitle("Dias");

#Add a blue (0x6666ff) 3D line chart layer using the give data
$lineLayerObj = $c->addLineLayer($data, 0x6666ff);
$lineLayerObj->set3D();

#Set the x axis labels using the given labels
$c->xAxis->setLabels($labels);

#output the chart in PNG format
header("Content-type: image/png");
print($c->makeChart2(PNG));



	
?>
          <tr align="center"> 
            <td width="740" height="59"> <p>&nbsp;</p>
              <p>&nbsp; </p>
              <p>&nbsp; </p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p> 
                <input type="button" name="btnsalir" value="salir" onClick="Salir()">
              </p>
              <p>&nbsp; </p></td>
          </tr>
        </table>
</table>
<?php include("../principal/pie_pagina.php");?>
</form>
</body>
</html>
