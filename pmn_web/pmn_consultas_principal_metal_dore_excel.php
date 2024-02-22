<?php
	include("../principal/conectar_pmn_web.php");	
	include("pmn_funciones.php");	
	
ob_end_clean();
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
?>

<br />
<table width="32%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr class="TituloCabeceraAzul">
    <td colspan='8' align="center">Existencia Metal Dore</td>
  </tr>	
  <tr class="TituloCabeceraAzul">
    <td width="41%" align="left">Mes - Ao</td>
    <td width="59%" colspan="7" align="left"><?php echo $Meses[$MesM-1]." - ".$AnoM;?>&nbsp;</td>
  </tr>
  <tr class="TituloCabeceraAzul">
    <td align="left">Existencia</td>
    <td align="left" colspan="7"><?php echo number_format($Exist,2,',','.');?></td>
  </tr>	
</table>
<br />
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr class="TituloCabeceraAzul">
    <td rowspan="2" align="center">D&iacute;a</td>
    <td colspan="3" align="center">Ingreso Anodos</td>
    <td colspan="3" align="center">Salida Anodos</td>
    <td colspan="3" align="center">Existencia de Anodos</td>
  </tr>
  <tr class="TituloCabeceraAzul">
    <td align="center">Codelco</td>
    <td align="center">Repr.</td>
    <td align="center">Circ.</td>
    <td align="center">Codelco</td>
    <td align="center">Repr.</td>
    <td align="center">Circ.</td>
    <td align="center">Codelco</td>
    <td align="center">Repr.</td>
    <td align="center">Circ.</td>
  </tr>
  <?php
		  for($i=1;$i<=31;$i++)
		  {		
				$Fecha=	$AnoM."-".$MesM."-".$i;
			$Consulta = "select * from pmn_web.produccion_horno_trof ";
			$Consulta.= " where fecha='".$Fecha."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);$Cont=1;$Pasa1='N';
			if($Row = mysqli_fetch_array($Respuesta))
				$Pasa1='S';
			$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
			$Consulta.= " where fecha='".$Fecha."'";
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);$Cont=1;$Pasa2='N';
			if($Row = mysqli_fetch_array($Respuesta))
				$Pasa2='S';	
			if($Pasa1=='S' || $Pasa2=='S')				
			{
				//echo $i."<br>";
				$Consulta = "select * from pmn_web.produccion_horno_trof ";
				$Consulta.= " where fecha='".$Fecha."'";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);$Rows=0;
				while($Row = mysqli_fetch_array($Respuesta))
					$Rows=$Rows+1;
				?>
  <tr>
    <td align="center" ><?php echo $i;?></td>
    <?php		
				//ENTRADAS DE ANODOS
				$Consulta = "select sum(num_anodos) as ProdAnodos from pmn_web.produccion_horno_trof ";
				$Consulta.= " where fecha='".$Fecha."'";
				//echo $Consulta."<br>";
				$Respuesta = mysqli_query($link, $Consulta);$Cont=1;$AnodosProd=0;
				if($Row = mysqli_fetch_array($Respuesta))
				{
					$AnodosProd=$AnodosProd+$Row[ProdAnodos];
					if($AnodosProd=='')
						$AnodosProd=0;	
				}
				else
					$AnodosProd=0;	

				//SALIDA DE ANODOS
				$Consulta2 = "select sum(cant_anodos) as SalidaAnodos from pmn_web.carga_electrolisis_plata ";
				$Consulta2.= " where fecha='".$Fecha."'";
				//echo $Consulta2."<br>";
				$Respuesta2 = mysqli_query($link, $Consulta2);$Cont=1;$AnodosSalida=0;
				if($Row2 = mysqli_fetch_array($Respuesta2))
				{
					$AnodosSalida=$Row2[SalidaAnodos];
					if($AnodosSalida=='')
						$AnodosSalida=0;	
				}	
				else
					$AnodosSalida=0;
					
				$ExistenciaAux=$Exist;
				//echo $ExistenciaAux."+".$AnodosProd."-".$AnodosSalida."<br>";
				$ExistIniF=$ExistenciaAux+$AnodosProd-$AnodosSalida;
				?>
    <td align="right"><?php echo number_format($AnodosProd,2,',','.');?></td>
    <td align="center">-</td>
    <td align="center">-</td>
    <td align="right"><?php echo number_format($AnodosSalida,2,',','.');?></td>
    <td align="center">-</td>
    <td align="center">-</td>
    <td align="right"><?php echo number_format($ExistIniF,2,',','.');?></td>
    <td align="center">-</td>
    <td align="center">-</td>
  </tr>
  <?php
				$Exist=$ExistIniF;
		    }		
		 }
	   ?>
</table>
<p>&nbsp;</p>
