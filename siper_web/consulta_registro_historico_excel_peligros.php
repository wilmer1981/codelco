<?
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
<title>Consulta peligros por usuarios</title>
<form name="FrmPrincipal" method="post" action="">
<br>
<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
  <?
	$FDesde=$FDesde." 00:00:00";
	$FHasta=$FHasta." 23:59:59";

  if($CmbVer=='D')
  {
  ?>
  <tr>
    <td width="20%" align="center" class="TituloCabecera">Funcionario</td>
    <td width="15%" align="center" class="TituloCabecera">Fecha</td>
    <td width="15%" align="center" class="TituloCabecera">Tipo Proceso</td>
    <td width="30%" align="center" class="TituloCabecera">Arbol Organizacional</td>
  </tr>
  <?

			$Consulta = "SELECT * from sgrs_registro_historico t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='29000' and valor_subclase3='S' and t1.tipo_proceso=t2.cod_subclase";
			$Consulta.= " where rut_funcionario<>'' and fecha_registro between '".$FDesde."' and '".$FHasta."'";
			if($CmbFuncionario!='T')
				$Consulta.=" and rut_funcionario='".$CmbFuncionario."'";
			if($CmbTipoProceso!='T')
				$Consulta.=" and tipo_proceso='".$CmbTipoProceso."'";
			if($SelTarea!='')
				$Consulta.=" and parent like '%".$SelTarea."%'";					
			$Consulta.=" order by fecha_registro";	
			//echo $Consulta."<br>";
			$Resp = mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				$Consulta1="SELECT * from proyecto_modernizacion.funcionarios where rut='".$Fila["rut_funcionario"]."'";
				//echo $Consulta;
				$Resultado=mysql_query($Consulta1);
				if($Fila1=mysql_fetch_array($Resultado))
					$Nombre=$Fila1["apellido_paterno"]." ".$Fila1["apellido_materno"]." ".$Fila1["nombres"];
					
					?>
			  <tr>
				<td ><? echo $Fila["rut_funcionario"]." ".$Nombre; ?></td>
				<td align="center" ><? echo $Fila[fecha_registro]; ?>&nbsp;</td>
				<td align="center" ><? echo $Fila["nombre_subclase"]; ?>&nbsp;</td>
				<td align="center" ><? echo $Fila["observacion"];?> &nbsp;</td>
			  </tr>
			  <?		
			}
		}
		else
		{
		?>		
	    <tr>
	    <td width="18%" align="center" class="TituloCabecera">Gerencia</td>
		<td width="18%" align="center" class="TituloCabecera">SuperIntendencia</td>
		<td width="18%" align="center" class="TituloCabecera">Area</td>
		<td width="18%" align="center" class="TituloCabecera">Proceso</td>
		<td width="18%" align="center" class="TituloCabecera">Nombre Tarea</td>
		<td width="10%" align="center" class="TituloCabecera">N� Consultas</td>
        </tr>
		<?
			$Consulta = "SELECT parent as cod,count(*) as cant_reg from sgrs_registro_historico t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='29000' and t1.tipo_proceso=t2.cod_subclase and t2.valor_subclase3='S'";
			$Consulta.= " where rut_funcionario<>'' and fecha_registro between '".$FDesde."' and '".$FHasta."'";
			if($CmbFuncionario!='T')
				$Consulta.=" and rut_funcionario='".$CmbFuncionario."'";
			if($CmbTipoProceso!='T')
				$Consulta.=" and tipo_proceso='".$CmbTipoProceso."'";
			if($SelTarea!=''||isset($SelTarea))
				$Consulta.=" and parent like '%".$SelTarea."%'";	
			$Consulta.=" group by parent order by fecha_registro";
			//echo 	$Consulta."<br>";
			$Resp = mysql_query($Consulta);$CantReg=0;
			while ($Fila=mysql_fetch_array($Resp))
			{
				$CantReg=$CantReg+$Fila["cant_reg"];
				$Organica=explode(',',$Fila[cod]);
				echo "<tr>";$NomOrganica1='&nbsp;';$NomOrganica2='&nbsp;';$NomOrganica3='&nbsp;';$NomOrganica4='&nbsp;';$NomOrganica8='&nbsp;';
				while(list($c,$v)=each($Organica))
				{
					$Nivel=ObtenerNivel($v);
					$NomOrganica=DescripOrganica3($v);
					switch($Nivel)
					{
						case "1":
							$NomOrganica1=$NomOrganica;	
						break;
						case "2":
							$NomOrganica2=$NomOrganica;	
						break;
						case "3":
							$NomOrganica3=$NomOrganica;		
						break;
						case "4":
							$NomOrganica4=$NomOrganica;	
						break;
						case "8":
							$NomOrganica8=$NomOrganica;		
						break;
					}
				}
				echo "<td align='left'>".$NomOrganica1."</td>";
				echo "<td align='left'>".$NomOrganica2."</td>";
				echo "<td align='left'>".$NomOrganica3."</td>";
				echo "<td align='left'>".$NomOrganica4."</td>";
				echo "<td align='left'>".$NomOrganica8."</td>";
				echo "<td align='right'>".$Fila["cant_reg"]."&nbsp;</td>";
				echo "</tr>";
			}
			?>
			 	<tr>
				<td align="right" class="TituloCabecera" colspan="5">Total&nbsp;&nbsp;</td>
				<td align="right" class="TituloCabecera"><? echo number_format($CantReg,0,'','.'); ?>&nbsp;</td>
			    </tr>
			<?	
		}	
?>
</table>
</form>
</body>
</html>
