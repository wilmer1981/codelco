<?php
include('conectar_ori.php');
include('funciones/siper_funciones.php');

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
if($VisibleDivProceso=='S')
$VisibleDiv='hidden';

if(!isset($FDesde))
	$FDesde=date('Y-m-d');
if(!isset($FHasta))
	$FHasta=date('Y-m-d');
?>
<html>
<head>
<title>Consulta Histórica</title>
<form name="FrmPrincipal" method="post" action="">
<br>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td width="20%" align="center" class="TituloCabecera">Funcionario</td>
    <td width="15%" align="center" class="TituloCabecera">Fecha</td>
    <td width="15%" align="center" class="TituloCabecera">Tipo Proceso</td>
    <td width="30%" align="center" class="TituloCabecera">Observaci&oacute;n</td>
    <td width="30%" align="center" class="TituloCabecera">Observaci&oacute;n (Solo Modificaci&oacute;n)</td>
    <td width="20%" align="center" class="TituloCabecera">Observación (Eliminación)</td>
    <td width="20%" align="center" class="TituloCabecera">Observación (Sustitución)</td>
  </tr>
  <?php
			$FDesde=$FDesde." 00:00:00";
			$FHasta=$FHasta." 23:59:59";

			$Consulta = "select * from sgrs_registro_historico t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='29000' and valor_subclase2='S' and t1.tipo_proceso=t2.cod_subclase";
			$Consulta.= " where rut_funcionario<>'' and fecha_registro between '".$FDesde."' and '".$FHasta."'";
			if($CmbFuncionario!='T')
				$Consulta.=" and rut_funcionario='".$CmbFuncionario."'";
			if($CmbTipoProceso!='T')
				$Consulta.=" and tipo_proceso='".$CmbTipoProceso."'";
			if($SelTarea!='')
				$Consulta.=" and parent like '%".$SelTarea."%'";					
			$Consulta.=" order by fecha_registro";	
			//echo $Consulta."<br>";
			$Resp = mysqli_query($link,$Consulta);
			while ($Fila=mysqli_fetch_array($Resp))
			{
				$Consulta1="select * from proyecto_modernizacion.funcionarios where rut='".$Fila[rut_funcionario]."'";
				//echo $Consulta;
				$Resultado=mysqli_query($link,$Consulta1);
				if($Fila1=mysqli_fetch_array($Resultado))
					$Nombre=$Fila1[apellido_paterno]." ".$Fila1[apellido_materno]." ".$Fila1[nombres];
					
				if($Fila[observacion2]=='')
					$Obs2='';
				else
					$Obs2=$Fila[observacion2];	
				if($Fila[obs_elimina]=='')
				{
					$Obs3="<td align='center' >&nbsp;</td>
						   <td align='center' >&nbsp;</td>";		
				}
				else
				{
					if($Fila[Tipo_Eli_Sust]!='')
					{
						if($Fila[Tipo_Eli_Sust]==1)//ELIMINACIÓN
						{
							$Obs3="<td align='left' >".$Fila[obs_elimina]."</td>
								   <td align='center' >&nbsp;</td>";		
						}	
						if($Fila[Tipo_Eli_Sust]==2)//SUSTITUCION
						{
							$Obs3="<td align='center' >&nbsp;</td>
								   <td align='left' >".$Fila[obs_elimina]."</td>";
						}	
					}	
				}	
					?>
			  <tr>
				<td ><?php echo $Fila[rut_funcionario]." ".$Nombre; ?></td>
				<td align="center" ><?php echo $Fila[fecha_registro]; ?>&nbsp;</td>
				<td align="center" ><?php echo $Fila[nombre_subclase]; ?>&nbsp;</td>
				<td align="center" ><?php echo $Fila[observacion];?>
				  &nbsp;</td>
				<td align="center" ><?php echo $Obs2;?>&nbsp;</td>
				<?php echo $Obs3;?>
			  </tr>
			  <?php		
			}
?>
</table>
</form>
</body>
</html>
