<?php
	//include("../principal/conectar_comet_web.php");	
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["sistema"])){
		$sistema=$_REQUEST["sistema"];
	}else{
		$sistema="";
	}
	if(isset($_REQUEST["nodo"])){
		$nodo=$_REQUEST["nodo"];
	}else{
		$nodo="";
	}
?>
<html>
<head>
<title>Detalle Flujos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
	//alert(numero);
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 355 ");
			//eval("Txt" + numero + ".style.top = document.checkTodos.top ");
			//eval("Txt" + numero + ".style.top = window.event.y ");
		}
	}
}
/*****************/
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<br>
<strong>&nbsp;&nbsp;DETALLE DEL NODO: 
<?php 
	echo $nodo;
	
	$consulta = "SELECT * FROM proyecto_modernizacion.nodos";
	$consulta.= " WHERE cod_nodo = '".$nodo."' AND sistema = '".$sistema."'";
	$rs = mysqli_query($link, $consulta);
	if ($row = mysqli_fetch_array($rs))
		echo " - ".$row["descripcion"];
?>
</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
<br>
<table width="596" border="1" cellspacing="0" cellpadding="3">
  <tr class="ColorTabla01"> 
    <td width="45" rowspan="2" align="center">FLUJO</td>
    <td width="243" rowspan="2" align="center">DESCRICION</td>
    <td width="34" rowspan="2" align="center">TIPO FLUJO</td>
    <td colspan="3" align="center">ANEXO PMN</td>
  </tr>
  <tr class="ColorTabla01"> 
    <td width="50" align="center"> CALCULA</td>
    <td width="84" align="center">F. SUMA</td>
    <td width="90" align="center">F.RESTA</td>
  </tr>
  <?php  
  	$consulta = "SELECT nodo, cod_flujo, descripcion, tipo, tipo_calculo, nodo_relacion, flujo_relacion, relacion_sistema, esflujo, mostrar,";
	$consulta.= " calcular, suma, resta, nombre_subclase";
	$consulta.= " FROM proyecto_modernizacion.flujos AS t1";
	$consulta.= " LEFT JOIN proyecto_modernizacion.sub_clase AS t2";
	$consulta.= " ON t1.tipo_calculo = t2.cod_subclase AND cod_clase = '14000'";
	$consulta.= " WHERE nodo = '".$nodo."' AND sistema = '".$sistema."'";
	$consulta.= " ORDER BY tipo, t1.orden2,orden";
	$rs = mysqli_query($link, $consulta);
	$Cont=0;
	while($row = mysqli_fetch_array($rs))	
	{
		$Cont++;
		echo '<tr>';
		echo '<td align="center">'.$row["cod_flujo"].'</td>';
		echo '<td align="laft">'.$row["descripcion"].'</td>';
		echo '<td align="center">'.$row["tipo"].'&nbsp;</td>';
		echo '<td align="center">'.$row["calcular"].'&nbsp;</td>';
		echo '<td align="center">'.$row["suma"].'&nbsp;</td>';
		echo '<td align="center">'.$row["resta"].'&nbsp;</td>';				
		echo '</tr>';
	}
?>
</table>
<br>
<br>
</body>
</html>
