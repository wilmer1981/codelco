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
<form name="PrinElectPLata" method="post"><br />
<table width="32%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr class="TituloCabeceraAzul">
    <td colspan='11' align="center">Producci&oacute;n &Aacute;nodos D&oacute;re </td>
  </tr>	
  <tr class="TituloCabeceraAzul">
    <td width="41%" colspan="3" align="left">Mes - A&ntilde;o</td>
    <td width="59%" colspan="8" align="left"><?php echo $Meses[$Mes-1]." - ".$Ano;?>&nbsp;</td>
  </tr>
</table>
<br />
  <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td width="6%" rowspan="2" align="center">D&iacute;a</td>
      <td width="7%" rowspan="2" align="center">Te Ppm </td>
      <td width="7%" rowspan="2" align="center">Se Ppm </td>
      <td width="7%" rowspan="2" align="center">Cu Ppm </td>
      <td width="9%" rowspan="2" align="center" >N&deg; Hornada </td>
      <td width="10%" rowspan="2" align="center" >Cantidad<br>anodos (Um) </td>
      <td width="9%" rowspan="2" align="center" >Peso<br>Hornada (Kg) </td>
      <td width="10%" rowspan="2" align="center" >Gas Natural<br>Inicio (M3) </td>
      <td width="10%" rowspan="2" align="center" >Consumo Gas<br>Natural Final (M3) </td>
      <td width="7%" align="center">Color</td>
      <td align="center">Personal</td>
    </tr>
    <tr>
      <td width="7%" align="center">Anodos</td>
      <td width="11%" align="center">Jefe de Turno </td>
    </tr>
    <?php
		$Buscar='S';
	  if($Buscar=='S')
	  {
		  for($K=1;$K<=31;$K++)
		  {
		  	//echo $K."<br>";		
		  
				$Fecha=	$Ano."-".$Mes."-".$K;
				$ConsultaP = "select * from pmn_web.produccion_horno_trof ";
				$ConsultaP.= " where fecha ='".$Fecha."'";
				//$Consulta.= " and hornada = '".$Hornada."'";
				//echo $ConsultaP."<br>";
				$RespuestaP = mysqli_query($link, $ConsultaP);
				while ($Filas = mysqli_fetch_array($RespuestaP))
				{
					$Fecha=explode('-',$Filas["fecha"]);
					$Ano=$Fecha[0];
					$Mes=$Fecha[1];
					$Dia=$Fecha[2];
		
					$Hornada = $Filas["hornada"];
					$Obs = $Filas["observacion"];
					$GasIni = $Filas[gas_natural_ini];
					$GasFin = $Filas[gas_natural_fin];
					$NumAnodos = $Filas[num_anodos];
					$Peso = $Filas["peso"];
					$Operador = $Filas[operador];
					$Color = $Filas[color];
					
					$Consulta1 = "select t1.cod_leyes, t2.abreviatura, t1.muestra01";
					$Consulta1.= " from pmn_web.leyes_prod_horno_trof t1 inner join proyecto_modernizacion.leyes t2 on ";
					$Consulta1.= " t1.cod_leyes = t2.cod_leyes ";
					$Consulta1.=" inner join proyecto_modernizacion.unidades t3 on t2.cod_unidad = t3.cod_unidad  ";
					$Consulta1.= " where fecha = '".$Filas["fecha"]."'";
					$Consulta1.= " and hornada = '".$Filas["hornada"]."'";
					$Consulta1.= " order by cod_leyes";
					//echo $Consulta1."<br>";
					$Respuesta = mysqli_query($link, $Consulta1);
					$i=1;$ValorCU='';$ValorSE='';$ValorTE='';
					while ($Row1 = mysqli_fetch_array($Respuesta))
					{
						if($Row1["cod_leyes"]=='02')
							$ValorCU=$Row1[muestra01];
						if($Row1["cod_leyes"]=='40')
							$ValorSE=$Row1[muestra01];
						if($Row1["cod_leyes"]=='44')
							$ValorTE=$Row1[muestra01];
					}
					?>
					<tr>
					  <td align="center"><?php echo $Dia;?></td>
					  <td align="right"><?php echo $ValorTE;?></td>
					  <td align="right"><?php echo $ValorSE;?></td>
					  <td align="right"><?php echo $ValorCU;?></td>
					  <td align="center" class="TituloCabeceraOz"><?php echo $Hornada;?></td>
					  <td align="right"><?php echo number_format($NumAnodos,0,',','.');?></td>
					  <td align="right"><?php echo number_format($Peso,4,',','.');?></td>
					  <td align="right"><?php echo number_format($GasIni,2,',','.');?></td>
					  <td align="right"><?php echo number_format($GasFin,2,',','.');?></td>
					  <?php
					$Consulta3 = "select * from proyecto_modernizacion.sub_clase where cod_clase = 6001 and cod_subclase='".$Color."' order by cod_subclase ";
					$Respuesta3 = mysqli_query($link, $Consulta3);
					if ($Row3 = mysqli_fetch_array($Respuesta3))
						$Color=$Row3["nombre_subclase"]
					?>
					  <td align="center" ><?php echo $Color;?></td>
					  <?php
					$sql = "select * from proyecto_modernizacion.funcionarios where rut = '".$Filas[operador]."'";
					$result2 = mysqli_query($link, $sql);
					if ($row2=mysqli_fetch_array($result2))
						$TxtOperador = ucwords(strtolower(substr($row2["nombres"],0,1).". ".$row2["apellido_paterno"]));
					else	$TxtOperador = "No Encontrado";
					?>
					  <td align='left' valign='middle'><?php echo $TxtOperador;?></td>
					</tr>
					<?php
					$TotaleAnod=$TotaleAnod+$NumAnodos;
					$TotalePeso=$TotalePeso+$Peso;
				}
		  }	
		  ?>
		  <tr>
		  	  <td colspan="5" align='right'>Totales</td>
		  	  <td align='right'><?php echo number_format($TotaleAnod,0,',','.');?></td>
		  	  <td align='right'><?php echo number_format($TotalePeso,4,',','.');?></td>
		  	  <td colspan="4">&nbsp;</td>
		  </tr>
		  <?php	
	  }	
	  ?>
  </table>
  <p>&nbsp;</p>
</form>
