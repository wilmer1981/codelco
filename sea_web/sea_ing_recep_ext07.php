<?php 
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Proceso"])) {
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso =  "";
	}
	if(isset($_REQUEST["cmbproductos"])) {
		$cmbproductos = $_REQUEST["cmbproductos"];
	}else{
		$cmbproductos =  "";
	}
	if(isset($_REQUEST["Todos"])) {
		$Todos = $_REQUEST["Todos"];
	}else{
		$Todos =  "";
	}
	if(isset($_REQUEST["TxtFechaIni"])) {
		$TxtFechaIni = $_REQUEST["TxtFechaIni"];
	}else{
		$TxtFechaIni = date("Y-m-d");
	}
	if(isset($_REQUEST["TxtFechaFin"])) {
		$TxtFechaFin = $_REQUEST["TxtFechaFin"];
	}else{
		$TxtFechaFin = date("Y-m-d");
	}

?>

<html>
<head>
<title>Recepci&oacute;n de Productos Externos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript">
function Datos_Excel()
{
	var f = frmPoPup;
	var valores;
 
 	valores = "&TxtFechaIni="+ f.TxtFechaIni.value+"&TxtFechaFin="+ f.TxtFechaFin.value+"&cmbproductos=" + f.cmbproductos.value;    
    window.open("sea_ing_recep_ext07_xls.php?Proceso=B"+valores);
}

function buscar_guia()
{
var f = frmPoPup;

    f.action="sea_ing_recep_ext07.php?Proceso=B";
	f.submit();
}

function Imprimir()
{
	window.print();
}
function Salir()
{
	var f = frmPoPup;
	f.action = "../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}

</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=165 scrolling=no height=185></IFRAME></DIV>
<form name="frmPoPup" method="post" action="">
<?php
	echo'<center><img src="../principal/imagenes/letrasenami.gif" width="120" height="30"></center>';
	echo'<center><font size="7">Fecha: '.date('Y-m-d').'</font></center><br>';	

 echo'<table cellpadding="3" cellspacing="0" width="630" border="0" bordercolor="#b26c4a" class="TablaPrincipal" align="center">
      <tr class="ColorTabla02"> 
        <td colspan="3"><div align="center">Busqueda de Datos</div></td>
      </tr>
      <tr> 
        <td width="108" height="32">Fecha Busqueda</td>
        <td width="300"colspan="2">'; 
		?>
			<input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaIni,TxtFechaIni,popCal);return false"> Al 
              <input name="TxtFechaFin" type="text" class="InputCen" id="TxtFechaFin" value="<?php echo $TxtFechaFin; ?>" size="15" maxlength="10" readOnly>
              <img src="../principal/imagenes/ico_cal.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="16" height="16" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaFin,TxtFechaFin,popCal);return false">		
		<?php
	  echo'</td>
      </tr>
      <tr> 
        <td>Tipo Producto</td>
        <td>';
		 echo '<SELECT name="cmbproductos" style="width:200">
            <option  value = "-1" SELECTed>Todos</option>';
			$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' AND cod_subproducto IN(2)";
   	        include("../principal/conectar_principal.php");
			$rs = mysqli_query($link, $consulta);

			while ($row = mysqli_fetch_array($rs))
			{			
			if ($row['cod_subproducto'] == $cmbproductos and ($Proceso == 'B'))
				echo '<option value="'.$row['cod_subproducto'].'" SELECTed>'.$row['descripcion'].'</option>';
			else 
				echo '<option value="'.$row['cod_subproducto'].'">'.$row['descripcion'].'</option>';
			}
			 echo'</SELECT></td>';
	   echo'</td>
        <td>
		    <input name="buscar" type="button" style="width:70" value="Ver Datos" onClick="buscar_guia();">
		    <input name="btnexcel" type="button" style="width:70;" value="Ver Excel" onClick="Datos_Excel();"> 			
		</td>           
      </tr>
    </table><br>';	
?>	

<?php
if($cmbproductos =="-1")
	$Todos = "S";

if($Proceso == "B")
{
	
	echo'<div align="center"><table cellpadding="3" cellspacing="0" width="630" border="1" bordercolor="#b26c4a" class="TablaPrincipal" align="center">
      	<tr class="ColorTabla02"> 
        	<td colspan="7"><div align="center"><strong>Recepci&oacute;n de Productos de Terceros</strong></div></td>
      	</tr>
		</table><br>';
}
if(($Todos == "S" || $cmbproductos == "2") && $Proceso =="B")
{
	$cmbproductos = "2";
	$total_unidades = 0;
	$total_peso = 0;
	echo'<div align="center"><table cellpadding="0" cellspacing="0"  width="630" border="1" bordercolor="#b26c4a" class="TablaPrincipal" align="center">
    <tr class="ColorTabla02"><td colspan="10"><div align="center">&Aacute;nodos Teniente</div></td></tr>
    <tr class="ColorTabla01"> 
        <td><div align="center">Guia</div></td>
		<td><div align="center">Lote Origen</div></td>
        <td><div align="center">Lote Ventana</div></td>
        <td><div align="center">Marca</div></td>
        <td><div align="center">Peso Origen</div></td>
        <td><div align="center">Peso Recep.</div></td>
        <td><div align="center">Piezas Origen</div></td>
		<td><div align="center">Piezas Recep.</div></td>
		<td><div align="center">Estado Guia</div></td>
    </tr>';
   // $fecha = $ano.'-'.$mes.'-'.$dia;
	$Consulta="SELECT * from sea_web.recepcion_externa where fecha between '".$TxtFechaIni."' and '".$TxtFechaFin."' order by guia,fecha_guia";
	//echo $Consulta;
	$RespGuias=mysqli_query($link, $Consulta);
	while($FilaGuias=mysqli_fetch_array($RespGuias))
	{
		echo "<tr>";
		echo "<td align='center'>".$FilaGuias["guia"]."</td>";
		echo "<td align='center'>".$FilaGuias["lote_origen"]."</td>";
		echo "<td align='center'>".$FilaGuias["lote_ventana"]."</td>";
		echo "<td align='center'>".$FilaGuias["marca"]."</td>";
		echo "<td align='right'>".number_format($FilaGuias["peso"],0,'','.')."</td>";
		echo "<td align='right'>".number_format($FilaGuias["peso_recep"],0,'','.')."</td>";
		echo "<td align='right'>".number_format($FilaGuias["piezas"],0,'','.')."</td>";
		echo "<td align='right'>".number_format($FilaGuias["piezas_recep"],0,'','.')."</td>";
		if(($FilaGuias["estado"]=='C') || ($FilaGuias["estado"]!='X' && intval($FilaGuias["peso"])==intval($FilaGuias["peso_recep"])))
		{
			echo "<td align='center'>C</td>";
			$total_unidades = $total_unidades+$FilaGuias["peso_recep"];
			$total_peso = $total_peso+$FilaGuias["piezas_recep"];
		}	
		else
			if($FilaGuias["estado"]=='X')
				echo "<td align='center'>Anulada</td>";
			else
				echo "<td align='center'>A</td>";
		echo "</tr>";
	}
    echo'<tr>'; 
      		echo'<td colspan="5"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td><div align="right">'.number_format($total_unidades,0,'','.').'</div></td>';
			echo'<td><div align="center">&nbsp;</div></td>';
      		echo'<td><div align="right">'.number_format($total_peso,0,'','.').'</div></td>';
			echo'<td><div align="center">&nbsp;</div></td>';
    echo'</tr>
	</table></div><br>';  
}
?>
		<br><table cellpadding="3" cellspacing="0" width="520" border="0" align="center">
		  <tr>
			<td> <div align="center">
				<input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
				<input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
			  </div></td>
		  </tr>
		</table>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
