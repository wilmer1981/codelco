<?php 

ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename = "";
if ( preg_match( '/MSIE/i', $userBrowser ) ) {
	$filename = urlencode($filename);
}
$filename = iconv('UTF-8', 'gb2312', $filename);
$file_name = str_replace(".php", "", $file_name);
header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");    
header("content-disposition: attachment;filename={$file_name}");
header( "Cache-Control: public" );
header( "Pragma: public" );
header( "Content-type: text/csv" ) ;
header( "Content-Dis; filename={$file_name}" ) ;
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
include("../principal/conectar_ref_web.php");

$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");

$fecha  = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$turno  = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";
$grupo  = isset($_REQUEST["grupo"])?$_REQUEST["grupo"]:"";


		
 ?>
<html>
<head>
<title>Rechazo Catodos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function ValidaSeleccion(Nombre)
{
	var f = frmPoPup;
	var LargoForm = f.elements.length;
	var valor = "";
	var rs;
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			valor = f.elements[i].value;		
		//	rs = f.elements[i].value;			
		}
	}
//	alert(rs);
	return valor;
}
//*********************//
function Eliminar_Datos(f)
{
	var valor = ValidaSeleccion('radio');
	var f = frmPoPup;
	var valores;
	
//	alert(valor);
	if(valor != '')
	{
		valores = "&Fecha=" + f.ano.value + "-" + f.mes.value + "-" + f.dia.value + "&turno=" + f.turno.value + "&grupo=" + f.grupo.value  + "&cuba_aux=" + valor;
	    f.action="cal_rechazo_catodos02.php?Proceso=E"+valores;
		f.submit();
    }
	else
	{
		alert('No hay Seleccionado');
		return
    }
}

function Modificar_Datos(f)
{
	var valor = ValidaSeleccion('radio');
	var f = frmPoPup;
	var valores;
	
	if(valor != '')
	{
		valores = "&Fecha=" + f.ano.value + "-" + f.mes.value + "-" + f.dia.value + "&turno=" + f.turno.value + "&grupo=" + f.grupo.value  + "&cuba_aux=" + valor;
		window.opener.document.formulario.action = "cal_rechazo_catodos.php?Proceso=M"+valores;
		window.opener.document.formulario.submit();
		self.close()
	}
	else
	{
		alert('No hay Seleccionado');
		return
    }
}


</script>
<link href="file:///G|/principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <table width="670" border="0" cellspacing="0" cellpadding="0" align="center" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <td colspan="8" align="center">Datos Ingresados</td>
    </tr>
    <tr> 
      <td colspan="8" align="center">&nbsp;</td>
    </tr>
    <tr class="ColorTabla02"> 
      <td width="46"><strong>Fecha: &nbsp;</strong></td>
      <td width="129">
	  <?php
	  if(strlen($dia) == 1)
		 $dia="0".$dia;
	  if(strlen($mes) == 1)
		 $mes="0".$mes;
			
	   echo $fecha;
	   /*echo '<input type="hidden" name="ano" value="'.$ano.'">';
	   echo '<input type="hidden" name="mes" value="'.$mes.'">';
	   echo '<input type="hidden" name="dia" value="'.$dia.'">';*/
	   ?>
	  </td>
      <td width="65"><strong>Grupo: &nbsp;</strong></td>
      <td width="55">
	  <?php 
	  		echo $grupo;
			echo '<input type="hidden" name="grupo" value="'.$grupo.'">';
	  ?>
	  </td>
      <td width="60"><strong>Turno: &nbsp;</strong></td>
      <td width="35">
	  <?php 
	  		echo $turno;
			echo '<input type="hidden" name="turno" value="'.$turno.'">';
	  ?>
	  </td>
      <td width="66"><strong>Inspector:&nbsp; </strong></td>
      <td width="211">
	  <?php
		$Consulta = "SELECT inspector FROM cal_web.rechazo_catodos WHERE fecha = '$fecha' AND turno = '$turno' AND grupo = $grupo";
		$rs = mysqli_query($link, $Consulta);

		if($row = mysqli_fetch_array($rs))
		{
			echo $row["inspector"];
		}
	  ?>
	  </td>
    </tr>
    <tr> 
      <td colspan="8" align="center">&nbsp;</td>
    </tr>
  </table>
  <br>
  <table width="670" border="1" cellspacing="0" cellpadding="0" align="center" class="TablaDetalle">
	<tr class="ColorTabla01">
		<td width="10%" align="center">Lado</td>
		<td width="5%" align="center">Cuba</td>
		<td width="10%" align="center">Recup.</td>
		<td width="10%" align="center">Rec. Menor</td>
		<td width="10%" align="center">Muestra</td>
		<td width="10%" align="center">N. Estampa</td>
		<td width="10%" align="center">N. Dispes.</td>
		<td width="10%" align="center">Rayado</td>
		<td width="10%" align="center">C. Superior</td>
		<td width="10%" align="center">C.Lateral</td>
		<td width="10%" align="center">Otros</td>
	</tr>
<?php
	
	$Consulta = "SELECT * FROM cal_web.rechazo_catodos WHERE fecha = '$fecha' AND turno = '$turno' AND grupo = $grupo ORDER BY cuba";
	$rs = mysqli_query($link, $Consulta);

	$recup = 0;	
	$recup_menor = 0;	
	$muestra = 0;	
	$estampa = 0;	
	$dispersos = 0;	
	$rayado = 0;	
	$c_superior = 0;	
	$c_lateral = 0;	
	$otros = 0;	

	while($row = mysqli_fetch_array($rs))
	{
		 echo'<tr>'; 
		 	echo '<td align="center">'.$row["lado"].'</td>';		
			/*echo '<td><input type="radio" name="radio" value="'.$row["cuba"].'">&nbsp;&nbsp;'.$row["lado"].'</td>';
			echo '<input type="hidden" name="lado" value="'.$row["lado"].'">';*/

			echo '<td align="center">'.$row["cuba"].'</td>';
			echo '<input type="hidden" name="cuba" value="'.$row["cuba"].'">';

			echo '<td align="center">'.$row["unid_recup"].'</td>';
			echo '<input type="hidden" name="unid_recup" value="'.$row["unid_recup"].'">';

			echo '<td align="center">'.$row["recup_menor"].'</td>';
			echo '<input type="hidden" name="recup_menor" value="'.$row["recup_menor"].'">';

			echo '<td align="center">'.$row["muestra"].'</td>';
			echo '<input type="hidden" name="muestra" value="'.$row["muestra"].'">';

			echo '<td align="center">'.$row["estampa"].'</td>';
			echo '<input type="hidden" name="estampa" value="'.$row["estampa"].'">';

			echo '<td align="center">'.$row["dispersos"].'</td>';
			echo '<input type="hidden" name="dispersos" value="'.$row["dispersos"].'">';

			echo '<td align="center">'.$row["rayado"].'</td>';
			echo '<input type="hidden" name="rayado" value="'.$row["rayado"].'">';

			echo '<td align="center">'.$row["cordon_superior"].'</td>';
			echo '<input type="hidden" name="cordon_superior" value="'.$row["cordon_superior"].'">';

			echo '<td align="center">'.$row["cordon_lateral"].'</td>';
			echo '<input type="hidden" name="cordon_lateral" value="'.$row["cordon_lateral"].'">';

			echo '<td align="center">'.$row["otros"].'</td>';
			echo '<input type="hidden" name="otros" value="'.$row["otros"].'">';
		echo'</tr>';			
				
			$recup = $recup + $row["unid_recup"];	
			$recup_menor = $recup_menor + $row["recup_menor"];	
			$muestra = $muestra + $row["muestra"];	
			$estampa = $estampa + $row["estampa"];	
			$dispersos = $dispersos + $row["dispersos"];	
			$rayado = $rayado + $row["rayado"];	
			$c_superior = $c_superior + $row["cordon_superior"];	
			$c_lateral = $c_lateral + $row["cordon_lateral"];	
			$otros = $otros + $row["otros"];	
	}
		echo'<tr class="Detalle02">';
			echo'<td colspan="2">Totales</td>'; 
			echo'<td align="center">'.$recup.'</td>'; 
			echo'<td align="center">'.$recup_menor.'</td>'; 
			echo'<td align="center">'.$muestra.'</td>'; 
			echo'<td align="center">'.$estampa.'</td>'; 
			echo'<td align="center">'.$dispersos.'</td>'; 
			echo'<td align="center">'.$rayado.'</td>'; 
			echo'<td align="center">'.$c_superior.'</td>'; 
			echo'<td align="center">'.$c_lateral.'</td>'; 
			echo'<td align="center">'.$otros.'</td>'; 
		echo'</tr>';			

?>
  </table>
  <br>
  <table width="670" border="" cellspacing="0" cellpadding="0" align="center" class="TablaDetalle">
	<tr>
		
      <td align="center">
	  <input type="button" name="btnexcel3" value="Excel" style="width:70" onClick="Excel()" > 
        <input type="button" name="salir" value="Salir" style="width:70" Onclick="self.close()">
		</td>
	</tr>
  </table>			
</form>
</body>
</html>