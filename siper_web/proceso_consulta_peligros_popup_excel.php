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

	set_time_limit(2000);
	$CookieRut   = isset($_COOKIE['CookieRut'])?$_COOKIE['CookieRut']:"";
	$CmbRut   = isset($_REQUEST["CmbRut"])?$_REQUEST["CmbRut"]:"";
	$CmbIdent = isset($_REQUEST["CmbIdent"])?$_REQUEST["CmbIdent"]:"";
	$CmbValidado = isset($_REQUEST["CmbValidado"])?$_REQUEST["CmbValidado"]:"";	
	$CodSelTarea = isset($_REQUEST["CodSelTarea"])?$_REQUEST["CodSelTarea"]:"";
	$OptSoloTareaNivel  = isset($_REQUEST["OptSoloTareaNivel"])?$_REQUEST["OptSoloTareaNivel"]:"";
	$CodPel  = isset($_REQUEST["CodPel"])?$_REQUEST["CodPel"]:"";
	$MR  = isset($_REQUEST["MR"])?$_REQUEST["MR"]:"";
	$Control  = isset($_REQUEST["Control"])?$_REQUEST["Control"]:"";
	$TipoVerif  = isset($_REQUEST["TipoVerif"])?$_REQUEST["TipoVerif"]:"";
	$MRiCC  = isset($_REQUEST["MRiCC"])?$_REQUEST["MRiCC"]:"";
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">

</script>
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
<form name="ConsultaPel" method="post">
<b><?php echo DescripOrganica2($CodSelTarea,$link);?></b>
<table width="90%" border="0" cellpadding="0" cellspacing="4">
  <tr>
	<td width="19%" align="left" class="formulario"><b>Rutinaria:&nbsp;<?php if($CmbRut=='0') echo "NO"; if($CmbRut=='1') echo "SI"; if($CmbRut=='T') echo "TODOS";?></b></td>
	<td width="21%" align="left" class="formulario"><b>Identificado:&nbsp;<?php if($CmbIdent=='0') echo "NO"; if($CmbIdent=='1') echo "SI"; if($CmbIdent=='T') echo "TODOS";?></b>&nbsp;&nbsp;&nbsp;&nbsp;<b>Validado:&nbsp;<?php if($CmbValidado=='0') echo "NO"; if($CmbValidado=='1') echo "SI"; if($CmbValidado=='T') echo "TODOS";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
	<td width="32%" align="left" class="formulario"><b>Solo Tarea Nivel:&nbsp;<?php echo $OptSoloTareaNivel;?></b></td>
	<td width="22%" align="right">&nbsp;</td>
  </tr>
  <tr>
	<td colspan="4" align="left" class="formulario"><b>Peligros:
	  <?php
			if($CodPel!='T')
			{
				$Consulta="select t1.CCONTACTO,NCONTACTO from sgrs_siperpeligros t1 inner join sgrs_codcontactos t2 on t1.CCONTACTO=t2.CCONTACTO where CPELIGRO='".$CodPel."'";
				$Resp=mysqli_query($Consulta);
				$Fila=mysqli_fetch_array($Resp);
				echo $Fila["NCONTACTO"];
				$CodPel1=$Fila["CCONTACTO"];
			}
			else
				echo "TODOS";
	  ?>	  </b></td>
	</tr>
  <tr>
	<td align="left" class="formulario"><b>MR:
	  <?php
		switch($MR)
		{
			case "A";
				echo "ACEPTABLE";
			break;
			case "M";
				echo "MODERADO";
			break;
			case "I";
				echo "INACEPTABLE";
			break;
			case "S";
				echo "SIN CONTROLES ASOCIADOS";
			break;
			default:
				echo "TODOS";
			break;												
		}
	  
	  ?></b></td>
	<td align="left" class="formulario"><b>MRi:
	  <?php
		switch($MRiCC)
		{
			case "1";
				echo "ACEPTABLE";
			break;
			case "2";
				echo "MODERADO";
			break;
			case "3";
				echo "INACEPTABLE";
			break;
			default:
				echo "TODOS";
			break;												
		}
	  
	  ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<b>Controles:
		<?php
			if($Control!='T')
			{
				$Consulta="select NCONTROL from sgrs_codcontroles where CCONTROL='".$Control."'";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				echo $Fila["NCONTROL"];
			}
			else
				echo "TODOS";	 
	  ?></b></td>
	<td colspan="2" align="left" class="formulario">&nbsp;</td>
	<td width="0%" align="left" class="formulario">&nbsp;</td>
	<td width="6%" align="left" class="formulario"><b>Verificador:
		<?php
			if($TipoVerif!='T')
			{
				$Consulta="select DESCRIP_VERIFICADOR from sgrs_tipo_verificador where COD_VERIFICADOR='".$TipoVerif."'";
				$Resp=mysqli_query($link,$Consulta);
				$Fila=mysqli_fetch_array($Resp);
				echo $Fila["DESCRIP_VERIFICADOR"];
			}
			else
				echo "TODOS";
	  ?>
	  </b></td>
  </tr>
</table>
	 <table width="100%" border="1" cellpadding="0" cellspacing="0">
	 <?php 
			$CODAREA=ObtenerCodParent($CodSelTarea);
			$Consulta="select t1.CTAREA,t1.CPARENT from sgrs_areaorg t1 where t1.CAREA = '".$CODAREA."'";
			$Resultado=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Resultado);
			$CodTarea=$Fila["CTAREA"];
			$RutaCompleta=$Fila["CPARENT"];
			$Filtro="";
			if($CodTarea==8)
				$Filtro="t1.CAREA='".$CODAREA."'";
			else
				if($OptSoloTareaNivel=='S')
					$Filtro.=" t1.CPARENT = '".$CodSelTarea."' ";
				else
					$Filtro.=" t1.CPARENT like '".$CodSelTarea."%'";
			/*$Consulta="select t1.NAREA,t1.CAREA,t1.CPARENT from sgrs_areaorg t1 inner join sgrs_siperoperaciones t2 on t1.CAREA=t2.CAREA ";
			$Consulta.=" left join sgrs_siperpeligros t3 on t1.CAREA=t3.CAREA left join sgrs_siperverificadores t7 on t3.CPELIGRO=t7.CPELIGRO";
			$Consulta.=" left join sgrs_sipercontroles t5 on t7.CPELIGRO=t5.CPELIGRO";
			$Consulta.=" where t3.MVIGENTE<>'0' and t1.CTAREA='8' and ".$Filtro;
			if($OptRut=='S')
				$Consulta2.=" and  t2.MRUTINARIA='1' ";
			if($OptIdent=='S')
				$Consulta2.=" and t2.MIDENTIFICADO='1' ";
			if($OptVal=='S')
				$Consulta2.=" and t2.MVALIDADO='1' ";
			if($CodPel!='T')
				$Consulta2.=" and t3.CCONTACTO='".$CodPel1."' ";
			if($MR!='T')
			{
				switch($MR)
				{
					case "A":
						$Consulta2.=" and (t3.QMR >=1 and t3.QMR<=4) ";	
					break;
					case "M":
						$Consulta2.=" and (t3.QMR >=8 and t3.QMR<=16) ";	
					break;
					case "I":
						$Consulta2.=" and (t3.QMR >=32 and t3.QMR<=64) ";	
					break;
					case "S":
						$Consulta3.=" and (t3.QMR=0 and t3.QPC=0 and t3.QCC=0) ";	
					break;
					
				}
			}*/
			
			$Consulta="select t1.NAREA,t1.CAREA,t1.CPARENT 	from sgrs_areaorg t1 ";
			$Consulta.="inner join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA and t2.MVIGENTE<>'0'";
			$Consulta.="inner join sgrs_siperoperaciones t3 on t2.CAREA=t3.CAREA ";
			$Consulta.="left join sgrs_siperverificadores t7 on t2.CPELIGRO=t7.CPELIGRO "; 
			$Consulta.="left join sgrs_sipercontroles t5 on t2.CPELIGRO=t5.CPELIGRO ";			
			
			$Consulta.=" where t1.MVIGENTE='1' and t1.CTAREA='8' and ".$Filtro;
			$Consulta2="";
			if($CmbRut!='T')
				$Consulta.=" and  t3.MRUTINARIA='".$CmbRut."' ";
			if($CmbIdent!='T')
				$Consulta.=" and t3.MIDENTIFICADO='".$CmbIdent."' ";
			if($CmbValidado!='T')
				$Consulta.=" and t3.MVALIDADO='".$CmbValidado."' ";
			if($CodPel!='T')
				$Consulta2.=" and t2.CCONTACTO='".$CodPel1."' ";
/*			if($MR!='T')
			{
				switch($MR)
				{
					case "A":
						$Consulta2.=" and (t2.QMR >=1 and t2.QMR<=4) ";	
					break;
					case "M":
						$Consulta2.=" and (t2.QMR >=8 and t2.QMR<=16) ";	
					break;
					case "I":
						$Consulta2.=" and (t2.QMR >=32 and t2.QMR<=64) ";	
					break;
					case "S":
						$Consulta3.=" and (t2.QMR=0 and t2.QPC=0 and t2.QCC=0) ";	
					break;

				}
			}*/

			
			if($Control!='T')
				$Consulta2.=" and t5.CCONTROL='".$Control."' and t5.MCONTROL<>0 ";
			//$Consulta2.=" and t5.MCONTROL='1' ";
			if($TipoVerif!='T')
				$Consulta2.=" and t7.COD_VERIFICADOR='".$TipoVerif."' ";
			//$Consulta2.=" group by t1.CAREA ";	
			$Consulta=$Consulta.$Consulta2." group by t1.CAREA ";
			//echo $Consulta;
			$MRAux=$MR;	
			$Resp=mysqli_query($link,$Consulta);$TotTarea=0;$TotPel=0;
			while($Fila=mysqli_fetch_array($Resp))
			{
				echo "<tr>";
				$Ruta = "";
				$Ruta = OrigenOrg($Fila["CPARENT"],$Ruta,$link);
				echo "<td align='left' colspan='10' class='titulo_azul'><b>".strtoupper($Fila["NAREA"])."&nbsp;&nbsp;->&nbsp;<label class='titulo_cafe_claro'>".utf8_decode($Ruta)."<label></b></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td align='center' width='30%' class='TituloCabecera' ><b>Peligro</b></td>";
				echo "<td align='center' width='20%' class='TituloCabecera' ><b>Descripci&oacute;n</b></td>";
				echo "<td align='center' width='5%' class='TituloCabecera' ><b>P</b></td>";
				echo "<td align='center' width='5%' class='TituloCabecera' ><b>C</b></td>";
				echo "<td align='center' width='3%' class='TituloCabecera' ><b>MRi</b></td>";
				//echo "<td align='center' width='25%' class='TituloCabecera' ><b>Obs/Comentario</b></td>";
				echo "<td align='left' width='30%' class='TituloCabecera' ><table width='96%' border='1' cellspacing='0' cellpadding='0'><td><b>Familia de Controles </b></td><td><b>Especificaci&oacute;n del Control </b></td></table></td>";
				//echo "<td align='left' width='30%' class='TituloCabecera' ><table width='96%' border='1' cellspacing='0' cellpadding='0'><td><b>Familia del Verificadores </b></td><td><b>Especificación del Verificador </b></td></table></td>";
				echo "<td align='center' width='5%' class='TituloCabecera' ><b>P</b></td>";
				echo "<td align='center' width='5%' class='TituloCabecera'><b>C</b></td>";
				echo "<td align='center' width='3%' class='TituloCabecera' ><b>MRr</b></td>";
				echo "<td align='center' width='3%' class='TituloCabecera' ><b>Validado</b></td>";
				//echo "<td align='center' width='7%' class='TituloCabecera' ><b>Validado</b></td>";
				echo "</tr>";
				/*$Consulta="select t6.NCONTACTO,t3.TOBSERVACION,t3.CPELIGRO,t3.CCONTACTO,t3.MVALIDADO,t3.MR1,t3.MR2,t3.QPROBHIST,t3.QCONSECHIST from sgrs_areaorg t1 inner join sgrs_siperoperaciones t2 on t1.CAREA=t2.CAREA ";
				$Consulta.=" left join sgrs_siperpeligros t3 on t1.CAREA=t3.CAREA inner join sgrs_codcontactos t6 on t3.CCONTACTO=t6.CCONTACTO left join sgrs_siperverificadores t7 on t3.CPELIGRO=t7.CPELIGRO";
				$Consulta.=" left join sgrs_sipercontroles t5 on t7.CPELIGRO=t5.CPELIGRO";
				$Consulta.=" where t1.CTAREA='8' and t1.CAREA = '".$Fila[CAREA]."' and t3.MVIGENTE <> 0";
				if($MR=='S')
					$Consulta=$Consulta.$Consulta3." group by t3.CPELIGRO ";
				else
					$Consulta=$Consulta.$Consulta2." group by t3.CPELIGRO ";*/

				$Consulta="select t6.NCONTACTO,t2.TOBSERVACION,t2.CPELIGRO,t2.CCONTACTO,t2.MVALIDADO,t2.MR1,t2.MR2,t2.QPROBHIST,t2.QCONSECHIST 	from sgrs_areaorg t1 ";
				$Consulta.="inner join sgrs_siperpeligros t2 on t1.CAREA=t2.CAREA ";
				$Consulta.="left join sgrs_siperoperaciones t3 on t2.CAREA=t3.CAREA ";
				$Consulta.="inner join sgrs_codcontactos t6 on t2.CCONTACTO=t6.CCONTACTO ";
				$Consulta.="left join sgrs_siperverificadores t7 on t2.CPELIGRO=t7.CPELIGRO "; 
				$Consulta.="left join sgrs_sipercontroles t5 on t2.CPELIGRO=t5.CPELIGRO ";			
				$Consulta.=" where t1.CTAREA='8' and t1.CAREA = '".$Fila["CAREA"]."' and t2.MVIGENTE <> 0";
				if($MR=='S')
					$Consulta=$Consulta.$Consulta3." group by t2.CPELIGRO ";
				else
					$Consulta=$Consulta.$Consulta2." group by t2.CPELIGRO ";

					
				//echo $Consulta;
				$Resp2=mysqli_query($link,$Consulta);
				while($Fila2=mysqli_fetch_array($Resp2))
				{
					$PH='';$CH='';$PC='';$CC='';$Validado='';
					if($Fila2["MVALIDADO"]=='1')
						$Validado='SI';
					else
						$Validado='NO';	
					//CalculoMR($Fila2[CCONTACTO],$Fila2[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);						
					//CalculoMRI($Fila2[QPROBHIST],$Fila2[QCONSECHIST],&$DESMRI,&$SEMAMRI);	
					$DESMRI="";$SEMAMRI="";$NMRi="";
					$Result = CalculoMRIConsulta($Fila2["QPROBHIST"],$Fila2["QCONSECHIST"],$DESMRI,$SEMAMRI,$NMRi);
					$valor  = explode('**',$Result);
					$DESMRI = $valor[0];
					$SEMAMRI= $valor[1];
					$NMRi   = $valor[2];
					
					if($MRiCC=='T')
						$Most_PelMRi='S';
					else
						if($MRiCC==$NMRi)
							$Most_PelMRi='S';
						else
							$Most_PelMRi='N';
					if($MRAux=='T')
						$Most_PelMRr='S';
					else
					{
						//echo $Fila2[MR1]."            ".$Fila2[MR2];
						if($Fila2["MR1"]==1&&$Fila2["MR2"]==1)//PUEDE SER 1=1. 
						{
							if($MRAux=='A')
								$Most_PelMRr='S';
							else
								$Most_PelMRr='N'; 
						}	
						else
							$Most_PelMRr='N';
						if($Fila2["MR1"]==2&&$Fila2["MR2"]==2)//PUEDE SER 2=2. 
						{
							if($MRAux=='M')
								$Most_PelMRr='S';
							else
								$Most_PelMRr='N';
						}	
						else
							$Most_PelMRr='N';
						if($Fila2["MR1"]==3&&$Fila2["MR2"]==3)//PUEDE SER 3=3.
						{
							//echo "aca<br>";
							if($MRAux=='I')
								$Most_PelMRr='S';
							else
								$Most_PelMRr='N';
						}	
						else
							$Most_PelMRr='N';
					}		
					//echo $MRiCC." ".$MRAux." ".$Most_PelMRi." ".$Most_PelMRr."<br>"; 				
					if($Most_PelMRi=='S'&&$Most_PelMRr=='S')
					{
						echo "<tr>";
						echo "<td align='left' width='30%'>".utf8_decode($Fila2["NCONTACTO"])."</td>";
						echo "<td align='left'>".utf8_decode($Fila2["TOBSERVACION"])."</td>";
						echo "<td align='center' width='5%'>".$Fila2["QPROBHIST"]."</td>";
						echo "<td align='center' width='5%'>".$Fila2["QCONSECHIST"]."</td>";
						//if($Descrip!='NO CALCULADO')
							echo "<td align='left'>".$DESMRI."</td>";
						//else
							//echo "<td align='left'>&nbsp;</td>";	
						//echo "<td align='center' width='25%'>".$Fila2[TOBSERVACION]."</td>";
						echo "<td align='left' width='30%' >";
						$Consulta="select t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES from sgrs_sipercontroles t1";
						$Consulta.=" inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES";
						$Consulta.=" where t1.CPELIGRO ='".$Fila2["CPELIGRO"]."'";
						if($Control!='T')
							$Consulta.=" and t1.CCONTROL='".$Control."' and t1.MCONTROL<>0 ";					
						//echo $Consulta."<br>";
						$RespCtrl=mysqli_query($link,$Consulta);
						if($FilaCtrl=mysqli_fetch_array($RespCtrl))
						{
							echo "<table width='96%' border='1' cellspacing='0' cellpadding='0' style='top:auto;'>";
							$Consulta="select t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES from sgrs_sipercontroles t1";
							$Consulta.=" inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES";
							$Consulta.=" where t1.CPELIGRO ='".$Fila2["CPELIGRO"]."'";
							if($Control!='T')
								$Consulta.=" and t1.CCONTROL='".$Control."' and t1.MCONTROL<>0 ";					
							//echo $Consulta."<br>";
							$RespCtrl=mysqli_query($link,$Consulta);
							while($FilaCtrl=mysqli_fetch_array($RespCtrl))
							{
								$ConsuOBS="select * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila2["CPELIGRO"]."' and CCONTROL='".$FilaCtrl["CCONTROL"]."'";
								$RespOBS=mysqli_query($link,$ConsuOBS);$Rows=0;
								while($FilaOBS=mysqli_fetch_array($RespOBS))
									$Rows=$Rows+1;
								echo "<tr>";
								echo "<td rowspan='".$Rows."' align='left' width='70%'>".utf8_decode($FilaCtrl["NCONTROL"])."&nbsp;&nbsp;&nbsp;</td>";
								$ConsuOBS="select * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila2["CPELIGRO"]."' and CCONTROL='".$FilaCtrl["CCONTROL"]."'";
								$RespOBS=mysqli_query($link,$ConsuOBS);
								if($FilaOBS=mysqli_fetch_array($RespOBS))
								{
									$ConsuOBS="select * from sgrs_sipercontroles_obs where CPELIGRO='".$Fila2["CPELIGRO"]."' and CCONTROL='".$FilaCtrl["CCONTROL"]."'";
									$RespOBS=mysqli_query($link,$ConsuOBS);
									while($FilaOBS=mysqli_fetch_array($RespOBS))
									{
										echo "<td align='left' width='30%'>&nbsp;".utf8_decode($FilaOBS["TOBSERVACION"])."</td>";
										echo "</tr>";
									}	
								}
								else
									echo "<td align='left' width='30%'>Sin Controles Asociados</td>";
							}
							echo "</table>";
							echo "</td>";
						}
						else
							echo "SIN CONTROLES";
						/*echo "<td><br>";
						$ConsuVeri="select * from sgrs_siperverificadores t1 inner join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila2[CPELIGRO]."' order by t1.COD_VERIFICADOR";
						$RespVeri=mysqli_query($ConsuVeri);
						if($FilaVeri=mysqli_fetch_array($RespVeri))
						{
							echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>";														
							$ConsuVeri="select * from sgrs_siperverificadores t1 left join sgrs_tipo_verificador t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where CPELIGRO='".$Fila2[CPELIGRO]."'";
							if($TipoVerif!='T')
								$ConsuVeri.=" and t2.COD_VERIFICADOR='".$TipoVerif."' ";
							$ConsuVeri.=" order by t1.COD_VERIFICADOR";	
							$RespVeri=mysqli_query($ConsuVeri);
							while($FilaVeri=mysqli_fetch_array($RespVeri))
							{
								echo "<tr>";
								$ConsuOBS="select * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila2[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
								$RespOBS=mysqli_query($ConsuOBS);$Rows=0;
								while($FilaOBS=mysqli_fetch_array($RespOBS))
									$Rows=$Rows+1;
								$ConsuOBS="select * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila2[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
								$RespOBS=mysqli_query($ConsuOBS);
								if($FilaOBS=mysqli_fetch_array($RespOBS))
								{								
									echo "<td rowspan='".$Rows."' align='left' width='70%'>".$FilaVeri[DESCRIP_VERIFICADOR]."&nbsp;&nbsp;&nbsp;</td>";
									$ConsuOBS="select * from sgrs_siperverificadores_obs where CPELIGRO='".$Fila2[CPELIGRO]."' and COD_VERIFICADOR='".$FilaVeri[COD_VERIFICADOR]."'";
									$RespOBS=mysqli_query($ConsuOBS);
									while($FilaOBS=mysqli_fetch_array($RespOBS))
									{
										echo "<td align='left' width='30%'>&nbsp;".$FilaOBS[TOBSERVACION]."</td>";
										echo "</tr>";
									}	
								}
								else
									echo "<td align='left' width='30%'>Sin Verificadores Asociados</td>";
							}
							echo "</table>";	
						}
						else
						{
							echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";														
							echo "<tr>";
							echo "<td coslpan='2'>SIN VERIFICADORES</td>";
							echo "</tr>";
							echo "</table>";
						}					
						echo "</td>";*/
						if($Validado=='SI')//cuando este validado el peligro muestra el PC y CH
						{
							echo "<td align='center' width='5%'>".$PC."&nbsp;</td>";
							echo "<td align='center' width='5%'>".$CC."&nbsp;</td>";
							if($Fila2["MR1"]==$Fila2["MR2"]&&$Fila2["MR1"]!=0&&$Fila2["MR2"]!=0)// SI SON IGUALES
							{
								if($Fila2["MR1"]==1&&$Fila2["MR2"]==1)// SI SON IGUALES VERDE
									$SEMAMRI="Aceptable";
								if($Fila2["MR1"]==2&&$Fila2["MR2"]==2)// SI SON IGUALES AMARILLO
									$SEMAMRI="Moderado";
								if($Fila2["MR1"]==3&&$Fila2["MR2"]==3)// SI SON IGUALES ORJO
									$SEMAMRI="Inaceptable";
							}
							else
							{
								$SEMAMRI="";
							}	
						}
						else
						{
							echo "<td align='center' width='5%'>&nbsp;</td>";
							echo "<td align='center' width='5%'>&nbsp;</td>";
							$SEMAMRI="";
						}
						echo "<td align='center'>".$SEMAMRI."</td>";
						echo "<td align='center'>".$Validado."</td>";
						//echo "<td align='center' width='3%'>".$Descrip."</td>";
						//echo "<td align='center' width='7%'>".$Validado."&nbsp;</td>";
						echo "</tr>";
					}
				}					
				$TotTarea++;
			}
			echo "<tr>";
			echo "<td class='titulo_azul'>TOTALES Tareas (".number_format($TotTarea,0,'','.').")</td>";
			echo "<td colspan='8'>&nbsp;</td>";
			echo "</tr>";
	 ?>
	</table>
</form>
</body>
</html>
<?php
$CODAREA=ObtenerCodParent($CodSelTarea);
//echo $CODAREA."<br>";
//$Datos=explode('//',$DatosPel);
$Consulta="select * from sgrs_areaorg where CAREA='".$CODAREA."'";
$Resp=mysqli_query($link,$Consulta);
$Fila=mysqli_fetch_array($Resp);
$NOMAREA      = $Fila["NAREA"];
$RutaCompleta = $RutaCompleta.$CODAREA.',';
$Ruta="";
$Ruta      = OrigenOrg($RutaCompleta,$Ruta,$link);
//echo "SSS:".$RutaCompleta."<br>";
$Obs='Consulta Peligros realizada en el nivel '.$Ruta;
InsertaHistorico($CookieRut,'28',$Obs,'',$RutaCompleta,'',$link);//REGISTRA ACCESO A CONSULTA COMO HISTORICO
?>