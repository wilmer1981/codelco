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
<form name="PrinElectPLata" method="post">
  <table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tr>
      <td width="4%" colspan="11" align="left" >Carga Electrolisis de Plata (Mov de Anodos)</td>
    </tr>
  </table>		
	
  <table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tr>
      <td width="4%" colspan="11" align="left" >Mes - A&ntilde;o </td>
    </tr>
    <tr>
      <td width="4%" rowspan="2" align="center" >D&iacute;a</td>
      <td width="7%" rowspan="2" align="center">Turno </td>
      <td width="7%" rowspan="2" align="center">Grupo M </td>
      <td width="9%" rowspan="2" align="center">Electrol. N&deg; </td>
      <td width="7%" rowspan="2" align="center" >Correl Homog. </td>
      <td colspan="3" align="center" >Anodos de Carga </td>
      <td colspan="2" align="center">Personal</td>
      <td width="7%" rowspan="2" align="center">Aditivos ISO </td>
    </tr>
    <tr>
      <td width="7%" align="center" >N&deg;</td>
      <td width="7%" align="center" >Hornada</td>
      <td width="8%" align="center" >Peso</td>
      <td width="18%" align="center">Jefe de Tueno </td>
      <td width="16%" align="center">Operador E-Ag </td>
    </tr>
    <?php
		$Buscar='S';
	  if($Buscar=='S')
	  {
	  	?>
			<tr>
			  <td colspan="11" align="left" class="titulo_azul"><?php echo $Meses[$Mes-1]." - ".$Ano;?></td>
			</tr>
	    <?php
		  for($K=1;$K<=31;$K++)
		  {
				$Fecha=	$Ano."-".$Mes."-".$K;
				$Consulta = "select * from pmn_web.carga_electrolisis_plata ";
				$Consulta.= " where fecha ='".$Fecha."'";	  
				$Consulta.= " group by fecha  order by fecha asc, turno, grupo, num_electrolisis, hornada, correlativo";
				//echo $Consulta;
				$Respuesta = mysqli_query($link, $Consulta);
				$i=1;
				while ($Row = mysqli_fetch_array($Respuesta))
				{
					$Fecha=explode('-',$Row["fecha"]);
					$Ano=$Fecha[0];
					$Mes=$Fecha[1];
					$Dia=$Fecha[2];
		
					$Consulta1 = "select * from pmn_web.carga_electrolisis_plata ";
					$Consulta1.= " where fecha='".$Row["fecha"]."'";	  
					$Consulta1.= " order by turno, grupo, num_electrolisis, hornada, correlativo";
					$Respuesta1 = mysqli_query($link, $Consulta1);
					$Cont=0;
					while ($Row1 = mysqli_fetch_array($Respuesta1))
						$Cont=$Cont+1;
					?>
    <tr >
      <td rowspan="<?php echo $Cont;?>" align="center"><?php echo $Dia;?></td>
      <?php
					$Consulta2 = "select * from pmn_web.carga_electrolisis_plata ";
					$Consulta2.= " where fecha='".$Row["fecha"]."'";	  
					$Consulta2.= " order by turno, grupo, num_electrolisis, hornada, correlativo";			
					$Respuesta2 = mysqli_query($link, $Consulta2);
					$i=1;$Total=0;
					while ($Row2= mysqli_fetch_array($Respuesta2))
					{
						$Consulta3 = "select * from proyecto_modernizacion.sub_clase where cod_clase = 1 and cod_subclase = ".$Row2[turno];
						$Resp3 = mysqli_query($link, $Consulta3);
						if ($Row3 = mysqli_fetch_array($Resp3))
						{
							?>
      <td align="center"><?php echo strtoupper($Row3["nombre_subclase"]);?></td>
      <?php
						}
						else
						{
							?>
      <td>&nbsp;</td>
      <?php
						}
						?>
      <td align="right"><?php echo $Row2["grupo"];?></td>
      <td align="right"><?php echo $Row2[num_electrolisis];?></td>
      <td align="right"><?php echo $Row2[correlativo];?></td>
      <td align="right"><?php echo $Row2[cant_anodos];?></td>
      <td align="right" class="TituloTablaNaranjaSuave"><?php echo $Row2["hornada"];?></td>
      <td align="right"><?php echo $Row2[peso_anodos];?></td>
      <?php
						//echo "PEso:   ".$Row2[peso_anodos]."<br>";
						$Total=$Total+$Row2[peso_anodos];
						
						$Jefe = "select rut, apellido_paterno, apellido_materno, nombres from proyecto_modernizacion.funcionarios  where rut='".$Row2[jefe_turno]."' ";
						//echo $Jefe."<br>";
						$resJefe = mysqli_query($link, $Jefe);
						if ($rowJefe = mysqli_fetch_array($resJefe))
						{
							?>
      <td><?php echo $Nombre = ucwords(strtolower($rowJefe["apellido_paterno"]." ".$rowJefe["apellido_materno"]." ".$rowJefe["nombres"]));?></td>
      <?php
						}
						else
						{
							?>
      <td>&nbsp;</td>
      <?php
						}	
						?>
      <?php
						$Jefe = "select rut, apellido_paterno, apellido_materno, nombres from proyecto_modernizacion.funcionarios  where rut='".$Row2[operador]."' ";
						//echo $Jefe."<br>";
						$resJefe = mysqli_query($link, $Jefe);
						if ($rowJefe = mysqli_fetch_array($resJefe))
						{
							?>
      <td width="2%"><?php echo $Nombre = ucwords(strtolower($rowJefe["apellido_paterno"]." ".$rowJefe["apellido_materno"]." ".$rowJefe["nombres"]));?></td>
      <?php
						}
						else
						{
							?>
      <td width="0%">&nbsp;</td>
      <?php
						}	
						?>
      <td width="1%" align="center">-</td>
    </tr>
    <?php
					}
					?>
    <tr>
      <td colspan="7" align="right" class="titulo_azul">Peso Total: </td>
      <td align="right" class="TituloCabeceraAzul"><?php echo $Total;?></td>
      <td colspan="3" align="center">&nbsp;</td>
      <?php
				}
			}
	  }		
	  ?>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
