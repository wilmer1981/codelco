<?php  ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
if ( preg_match( '/MSIE/i', $userBrowser ) ) 
{
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
	include("../principal/conectar_pmn_web.php");
?>
<html>
<head>
<title>Planta de Metales Nobles</title>
<?php	
	//<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
?>
<script language="JavaScript">
function Proceso(opt)
{
	var f= document.frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.history.back();
			break;
	}
}
function Excel(FechaI,FechaT,T)
{
	var f=document.frmPrincipal;
	f.action="pmn_xls_carga_barro_aurifero_crudo.php?FechaIni="+FechaI + "&FechaFin="+FechaT + "&Turno="+T;
	f.submit();
}

</script>
</head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form action="" method="post" name="frmPrincipal">

  <table width="711" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td width="456" align="center" valign="middle" colspan="7"><strong>PRODUCCION BARRO AURIFERO CRUDO
        </strong></td>
      <td width="85" align="center" valign="middle"><input name="BtnExcel" type="button" style="width:70px" value="Excel" onClick="Excel('<?php echo $FechaIni; ?>','<?php echo $FechaFin; ?>','<?php echo $Turno;  ?>');"></td>
      <td width="152" align="center" valign="middle"> 
        <input name="BtnImprimir" type="button" style="width:70px" onClick="Proceso('I');" value="Imprimir">
        &nbsp; 
        <input type="button" name="BtnSalir" value="Salir" style="width:70px" onClick="Proceso('S');"></td>
    </tr>
  </table>
<strong> <br>
<br>
</strong> 
  <table width="586" border="1" cellspacing="0" cellpadding="3" class="TablaDetalle">
    <tr align="center" valign="middle" class="ColorTabla01"> 
      <td width="36" rowspan="2">FECHA</td>
      <td width="41" rowspan="2">TURNO</td>
      <td colspan="5">BARROS AURIFEROS CRUDOS</td>
    </tr>
    <tr class="ColorTabla01"> 
      <td width="80" align="center" valign="middle">PESO</td>
      <td width="72">N&deg;ELECTROLISIS</td>
      <td width="99" align="center" valign="middle">GRUPO</td>
      <td width="64">J.TURNO</td>
      <td> <div align="center">OPERADOR</div>
      </td>
    </tr>
    <?php 
	$Consulta = "select *,t2.nombre_subclase from pmn_web.barro_aurifero_crudo t1";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t1.turno = t2.cod_subclase and cod_clase ='1'   ";
	$Consulta.= " where fecha between '".$FechaIni."' and '".$FechaFin."' ";
	if ($Turno != "S")
		$Consulta.= " and turno = '".$Turno."'";
	$Consulta.= " order by t1.fecha,valor_subclase1 ";
	$Respuesta = mysqli_query($link, $Consulta);
	$FechaAnt = "";
	while ($Row = mysqli_fetch_array($Respuesta))
	{
		echo "<tr>";
			echo "<td align='left'>".substr($Row["fecha"],8,2)."/".substr($Row["fecha"],5,2)."/".substr($Row["fecha"],0,4)."&nbsp;</td>\n";
			echo "<td>".$Row["nombre_subclase"]."</td>";
			$Consulta="select * from pmn_web.detalle_barro_aurifero_crudo t1  " ;
			$Consulta.=" inner join barro_aurifero_crudo t2 on t1.rut = t2.rut and " ;
            $Consulta.=" t1.fecha = t2.fecha and t1.num_electrolisis = t2.num_electrolisis"   ;
            $Consulta.=" and t1.turno = t2.turno and t1.fecha =' " .$Row["fecha"]."'";
			$Respuesta1= mysqli_query($link, $Consulta);
			echo "<td>";
			while ($Fila=mysqli_fetch_array($Respuesta1))
			{
				$Porc=($Fila[porc_humedad]/100);
				$Calculo=($Fila[peso_humedo]*$Porc);
				echo number_format($Calculo,3,",","")."<br>";
			}
			echo "</td>";
			echo "<td>".$Row[num_electrolisis]."</td>";
			echo "<td>".$Row["grupo"]."</td>";
			echo "<td>&nbsp;</td>";			
			$Consulta="select * from proyecto_modernizacion.funcionarios where rut = '".$Row[operador]."' ";
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);	
			echo "<td align='left'>".strtoupper(substr($Fila2["nombres"],0,1)).". ".ucwords(strtolower($Fila2["apellido_paterno"]))."</td>\n";
		echo "</tr>";
	}
?>
  </table>
</form>
</body>
</html>
