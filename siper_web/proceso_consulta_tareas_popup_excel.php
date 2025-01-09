<?php
	include('conectar_consulta.php');
	include('funciones/siper_funciones.php');	

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
	
	$CheckeadoRut='checked';
	$CheckeadoIdent='';
	$CheckeadoVal='';
	$CheckeadoTareasNivel='';
	$OptRut  = isset($_REQUEST["OptRut"])?$_REQUEST["OptRut"]:"";
	$OptIdent  = isset($_REQUEST["OptIdent"])?$_REQUEST["OptIdent"]:"";
	$OptVal  = isset($_REQUEST["OptVal"])?$_REQUEST["OptVal"]:"";
	$OptSoloTareaNivel  = isset($_REQUEST["OptSoloTareaNivel"])?$_REQUEST["OptSoloTareaNivel"]:"";
	$CmbRut   = isset($_REQUEST["CmbRut"])?$_REQUEST["CmbRut"]:"";
	$CmbIdent = isset($_REQUEST["CmbIdent"])?$_REQUEST["CmbIdent"]:"";
	$CmbValidado = isset($_REQUEST["CmbValidado"])?$_REQUEST["CmbValidado"]:"";
	
	if($OptRut=='N')
		$CheckeadoRut='';
	if($OptIdent=='S')
		$CheckeadoIdent='checked';
	if($OptVal=='S')
		$CheckeadoVal='checked';			
	if($OptSoloTareaNivel=='S')
		$CheckeadoTareasNivel='checked';			
	set_time_limit('3000');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Consultas</title>
<style type="text/css">
<!--
.Estilo7 {font-size: 12px}
-->
</style>
</head>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<body>
<form name="MantenedorPel" method="post">
	<table width="90%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td width="19%" align="left" class="formulario"><b>Rutinaria:<?php echo $CmbRut;?></b></td>
        <td width="14%" align="left" class="formulario"><b>Identificado:<?php echo $CmbIdent;?></b></td>
        <td width="17%" align="left" class="formulario"><b>Validado:<?php echo $CmbValidado;?></b></td>
        <td width="41%" align="right">&nbsp;</td>
      </tr>
    </table>
	<table width="90%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%" class="TituloCabecera" > <div align="center">Descripci&oacute;n</div></td>
			<td width="10%" class="TituloCabecera" ><div align="center">N&ordm; Peligros</div></td>
			<td width="10%" class="TituloCabecera" ><div align="center">N° Especificación de Controles</div></td>
			<td width="10%" class="TituloCabecera" ><div align="center">N° Especificación de Verificadores</div></td>
			<td width="10%" class="TituloCabecera" ><div align="center">Fecha Ultima Validación</div></td>
	  </tr>
  </table>
		 <table width="100%" border="1" cellpadding="0" cellspacing="0">
		 <?php 
				$Consulta="select t1.CAREA,t1.NAREA,t1.FAREA,t1.CPARENT from sgrs_areaorg t1 inner join sgrs_siperoperaciones t2 on t1.CAREA=t2.CAREA where t1.MVIGENTE=1 and t1.CTAREA='8' ";
				if($OptSoloTareaNivel=='S')
					$Consulta.=" and t1.CPARENT = '".$CodSelTarea."' ";
				else
					$Consulta.=" and t1.CPARENT like '".$CodSelTarea."%'";
				if($CmbRut!='T')
					$Consulta.=" and  t2.MRUTINARIA='".$CmbRut."' ";
				if($CmbIdent!='T')
					$Consulta.=" and t2.MIDENTIFICADO='".$CmbIdent."' ";
				if($CmbValidado!='T')
					$Consulta.=" and t2.MVALIDADO='".$CmbValidado."' ";
				$Consulta.=" order by t1.FAREA desc";	
				//echo $Consulta;
				$Resp=mysqli_query($link,$Consulta);$TotTarea=0;$TotPel=0;$TotPelCtrl=0;
				while($Fila=mysqli_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td width='50%' align='left' class='titulo_azul'>&nbsp;".strtoupper($Fila["NAREA"])."</td>";
					$Consulta="select ifnull(count(*),0) as cant_pel from sgrs_siperpeligros where MVIGENTE <> 0 and CAREA='".$Fila["CAREA"]."' group by CAREA";	
					//echo $Consulta."<br>";
					$RespPel=mysqli_query($link,$Consulta);
					$FilaPel=mysqli_fetch_array($RespPel);
					if(is_null($FilaPel["cant_pel"]))
						$CantPel=0;
					else
						$CantPel=$FilaPel["cant_pel"];
					$TotPel=$TotPel+$CantPel;	
					$Consulta="select * from sgrs_siperpeligros where MVIGENTE <> 0 and CAREA='".$Fila["CAREA"]."'";	
					//echo $Consulta."<br>";
					$RespPel=mysqli_query($link,$Consulta);$CantPelVeri=0;$CantPelCtrl=0;
					while($FilaPel=mysqli_fetch_array($RespPel))					
					{
						//$Consulta="select ifnull(count(*),0) as cant_pel from sgrs_siperpeligros where MVIGENTE <> 0 and CPELIGRO='".$FilaPel[CPELIGRO]."' and NOT ISNULL(QPC)  group by CAREA";	
						$Consulta="select * from sgrs_sipercontroles_obs where CPELIGRO='".$FilaPel["CPELIGRO"]."'";	
						//echo $Consulta."<br>";
						$RespPelCtrl=mysqli_query($link,$Consulta);
						while($FilaPelCtrl=mysqli_fetch_array($RespPelCtrl))
							$CantPelCtrl=$CantPelCtrl+1;
							
						
						//$ConsulVeri="select * from sgrs_siperverificadores t1 inner join sgrs_siperverificadores_obs t2 on t1.CAREA=t2.CAREA where t1.CPELIGRO='".$FilaPel[CPELIGRO]."' group by t2.CIDVERIFICADOR";
						$ConsulVeri="select * from sgrs_siperverificadores_obs where CPELIGRO='".$FilaPel["CPELIGRO"]."'";
						//echo $ConsulVeri."<br>";
						$RespVeri=mysqli_query($link,$ConsulVeri);
						while($FilaVeri=mysqli_fetch_array($RespVeri))
							$CantPelVeri=$CantPelVeri+1;
					}	
					$TotPelCtrl=$TotPelCtrl+$CantPelCtrl;					
					$TotPelVeri=$TotPelVeri+$CantPelVeri;
					echo "<td width='10%'>".$CantPel."</td>";
					echo "<td width='10%'>".$CantPelCtrl."</td>";
					echo "<td width='10%'>".$CantPelVeri."</td>";
					
					$Conhist="select * from sgrs_siperoperaciones where CAREA='".$Fila["CAREA"]."'";
					//echo $Conhist."<br>";
					$Resphist=mysqli_query($link,$Conhist);
					$Filahist=mysqli_fetch_array($Resphist);
					$Fecha=	$Filahist["FECHA_HORA_VAL"];				
					echo "<td width='10%'>".$Fecha."&nbsp;</td>";			
					echo "</tr>";
					$TotTarea++;
				}
				echo "<tr>";
				echo "<td>TOTALES Tareas (".number_format($TotTarea,0,'','.').")</td>";
				echo "<td>".number_format($TotPel,0,'','.')."</td>";
				echo "<td>".number_format($TotPelCtrl,0,'','.')."</td>";
				echo "<td>".number_format($TotPelVeri,0,'','.')."</td>";
				echo "<td>&nbsp;</td>";
				echo "</tr>";
		 
/*				$Consulta="select t1.CAREA,t1.NAREA,t1.FAREA from sgrs_areaorg t1 inner join sgrs_siperoperaciones t2 on t1.CAREA=t2.CAREA where t1.MVIGENTE=1 and t1.CTAREA='8' ";
				if($OptSoloTareaNivel=='S')
					$Consulta.=" and t1.CPARENT = '".$CodSelTarea."' ";
				else
					$Consulta.=" and t1.CPARENT like '".$CodSelTarea."%'";
				if($CmbRut!='T')
					$Consulta.=" and  t2.MRUTINARIA='".$CmbRut."' ";
				if($CmbIdent!='T')
					$Consulta.=" and t2.MIDENTIFICADO='".$CmbIdent."' ";
				if($CmbValidado!='T')
					$Consulta.=" and t2.MVALIDADO='".$CmbValidado."' ";
				//echo $Consulta;
				$Resp=mysqli_query($Consulta);$TotTarea=0;$TotPel=0;$TotPelCtrl=0;
				while($Fila=mysqli_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td width='55%' align='left' class='titulo_azul'>&nbsp;".strtoupper($Fila[NAREA])."</td>";
					$Consulta="select ifnull(count(*),0) as cant_pel from sgrs_siperpeligros where MVIGENTE <> 0 and CAREA='".$Fila[CAREA]."' group by CAREA";	
					//echo $Consulta."<br>";
					$RespPel=mysqli_query($Consulta);
					$FilaPel=mysqli_fetch_array($RespPel);
					if(is_null($FilaPel[cant_pel]))
						$CantPel=0;
					else
						$CantPel=$FilaPel[cant_pel];
					$TotPel=$TotPel+$CantPel;	
					$Consulta="select ifnull(count(*),0) as cant_pel from sgrs_siperpeligros where MVIGENTE <> 0 and CAREA='".$Fila[CAREA]."' and NOT ISNULL(QPC)  group by CAREA";	
					//echo $Consulta."<br>";
					$RespPelCtrl=mysqli_query($Consulta);
					$FilaPelCtrl=mysqli_fetch_array($RespPelCtrl);
					if(is_null($FilaPelCtrl[cant_pel]))
						$CantPelCtrl=0;
					else
						$CantPelCtrl=$FilaPelCtrl[cant_pel];
					$TotPelCtrl=$TotPelCtrl+$CantPelCtrl;
					echo "<td width='15%'>".$CantPel."</td>";
					echo "<td width='15%'>".$CantPelCtrl."</td>";
					echo "<td width='15%'>".$Fila[FAREA]."</td>";			
					echo "</tr>";
					$TotTarea++;
				}
				echo "<tr>";
				echo "<td class='titulo_azul'>TOTALES Tareas (".number_format($TotTarea,0,'','.').")</td>";
				echo "<td class='titulo_azul'>".number_format($TotPel,0,'','.')."</td>";
				echo "<td class='titulo_azul'>".number_format($TotPelCtrl,0,'','.')."</td>";
				echo "<td>&nbsp;</td>";
				echo "</tr>";
*/		 ?>
	    </table>
</form>
</body>
</html>