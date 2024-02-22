<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");	

	if(isset($_REQUEST["Ano"])){
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = "";
	}
	if(isset($_REQUEST["Mes"])){
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = "";
	}
	
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename="";
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
?>
<form name="PrinElectPLata" method="post">
<table width="32%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr class="TituloCabeceraAzul">
    <td colspan='9' align="center">Produccin Barro Anodico Descobrizado</td>
  </tr>	
  <tr class="TituloCabeceraAzul">
    <td width="41%" colspan="3" align="left">Mes - A�o</td>
    <td width="59%" colspan="6" align="left"><?php echo $Meses[$Mes-1]." - ".$Ano;?>&nbsp;</td>
  </tr>
</table><br />
  <table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tr bordercolor="#333333">
      <td width="4%" rowspan="2" align="center">D&iacute;a</td>
      <td width="4%" rowspan="2" align="center">Turno</td>
      <td width="9%" align="center" >Lixiviaci&oacute;n</td>
      <td colspan="2" align="center" >Carga</td>
      <td width="8%" align="center">Acido</td>
      <td width="8%" align="center">Filtrado</td>
      <td width="9%" align="center">Producci&oacute;n</td>
      <td width="13%" align="center" rowspan="2">Operador Lixiviaci&oacute;n </td>
    </tr>
    <tr>
      <td align="center">N&deg;</td>
      <td width="7%" align="center">D&iacute;a</td>
      <td width="6%" align="center">Hora</td>
      <td align="center">Lts</td>
      <td align="center">Hora</td>
      <td align="center">Peso H20 </td>
    </tr>
    <?php
		$Buscar='S';
	  if($Buscar=='S')
	  {
	  	?>
    <tr>
      <td colspan="13" align="left"><?php echo $Meses[$Mes-1]." - ".$Ano;?></td>
    </tr>
    <?php
	 $Total=0;
		  for($i=1;$i<=31;$i++)
		  {		
		  		$Fecha=	$Ano."-".$Mes."-".$i;
				$sql = "select fecha from lixiviacion_barro_anodico";
				$sql.= " where fecha='".$Fecha."'";
				$sql.= " group by fecha order by fecha asc,turno";
				//echo $sql."<br>"; 
				$result = mysqli_query($link, $sql);$Conteo='0';
				if ($Fila = mysqli_fetch_array($result))
				{
					//echo " fecha:   ".$Fila["fecha"]."<br>"; 
					$Fecha=explode('-',$Fila["fecha"]);
					$Ano=$Fecha[0];
					$Mes=$Fecha[1];
					$Dia=$Fecha[2];
					//echo " fecha:   ".$Fila["fecha"]."<br>";
					$sqlDes = "select * from lixiviacion_barro_anodico";
					$sqlDes.= " where fecha='".$Fila["fecha"]."' ";
					$sqlDes.= " order by fecha asc,turno";
					//echo $sqlDes."<br>"; 
					$resultDes = mysqli_query($link, $sqlDes);$Cont='0';
					while ($rowDes = mysqli_fetch_array($resultDes))
							$Cont=$Cont+1;
					?>
    <tr>
      <td align='center' rowspan="<?php echo $Cont;?>" valign='middle'><?php echo $Dia;?></td>
      <?php
					$sqlDes = "select * from lixiviacion_barro_anodico";
					$sqlDes.= " where fecha='".$Fila["fecha"]."' ";
					$sqlDes.= " order by fecha asc,turno";
					//echo $sqlDes."<br>"; 
					$resultDes = mysqli_query($link, $sqlDes);$Conteo2='0';
					while ($rowDes = mysqli_fetch_array($resultDes))
					{
						$Fecha2=explode('-',$rowDes["fecha"]);
						$Ano=$Fecha2[0];
						$Mes=$Fecha2[1];
						$Dia=$Fecha2[2];
		
							
							$sql = "select * from proyecto_modernizacion.sub_clase where cod_clase=1 and cod_subclase=".$rowDes["turno"];
							$result2 = mysqli_query($link, $sql);
							if ($row2=mysqli_fetch_array($result2))
								$TxtTurno = strtoupper($row2["nombre_subclase"]);
							else	$TxtTurno = "N";
							
							?>
      <td align='center' valign='middle'><?php echo $TxtTurno;?></td>
      <td align='center' valign='middle' class="TituloCabeceraOz"><?php echo $rowDes["num_lixiviacion"];?></td>
      <td align='center' valign='middle'><?php echo $rowDes["dia_carga"];?></td>
      <td align='center' valign='middle'><?php echo $rowDes["hora_carga"];?></td>
      <td align='right' valign='middle'><?php echo number_format($rowDes["acidc"],2,',','.');?></td>
      <td align='center' valign='middle'><?php echo $rowDes["hora_filtracion"];?></td>
      <td align='right' valign='middle'><?php echo number_format($rowDes["bad"],2,',','.');?></td>
      <?php
							$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$rowDes["operador"]."'";
							$result2 = mysqli_query($link, $sql);
							if ($row2=mysqli_fetch_array($result2))
								$TxtOperador = ucwords(strtolower(substr($row2["nombres"],0,1).". ".$row2["apellido_paterno"]));
							else	$TxtOperador = "No Encontrado";
							?>
      <td align='left' valign='middle'><?php echo $TxtOperador;?></td>
    </tr>
    <?php		
		$Total=$Total+$rowDes["bad"];
					}
				}
		  }	
		  ?>
		  <tr  class="TituloCabecera">
		  	<td colspan="7" align="right">Total</td>
		  	<td align="right" ><?php echo number_format($Total,2,',','.');?></td>
		  	<td>&nbsp;</td>
		  </tr>
		  <?php
	 }	
	  ?>
  </table>
  <p>&nbsp;</p>
</form>
