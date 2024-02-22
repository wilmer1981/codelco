<?
	include('conectar_ori.php');
	include('funciones/siper_funciones.php');	

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
<? echo DescripOrganica2($CodSelTarea);?>
<table width="90%" border="0" cellpadding="0" cellspacing="4">
  <tr>
	<td height="36" align="left"><img src="imagenes/LblCriterios.png" width="168" height="28"></td>
	<td height="36" align="left">&nbsp;</td>
	<td height="36" align="left">&nbsp;</td>
	<td width="23%" align="right"><a href="javascript:window.print();"><img src="imagenes/btn_imprimir.png" width="30" height="30" border="0" alt="Imprimir"></a></td>
  </tr>
  <tr>
	<td width="22%" align="left" class="formulario">Rutinaria:&nbsp;<? echo $OptRut;?></td>
	<td width="16%" align="left" class="formulario">Identificado:&nbsp;<? echo $OptIdent;?></td>
	<td width="39%" align="left" class="formulario">Validado:&nbsp;<? echo $OptVal;?></td>
	<td width="23%" align="right">&nbsp;</td>
  </tr>
  <tr>
	<td colspan="4" align="left" class="formulario">Peligros:
	  <?
			if($CodPel!='T')
			{
				$Consulta="SELECT NCONTACTO from sgrs_codcontactos where CCONTACTO='".$CodPel."'";
				//echo $Consulta;
				$Resp=mysql_query($Consulta);
				$Fila=mysql_fetch_array($Resp);
				echo $Fila[NCONTACTO];
			}
			else
				echo "TODOS";
	  ?>
	  </td>
	</tr>
  <tr>
	<td align="left" class="formulario">MR:
	  <?
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
	  
	  ?>
</td>
	<td colspan="2" align="left" class="formulario">Controles:
		<?
			if($Control!='T')
			{
				$Consulta="SELECT NCONTROL from sgrs_codcontroles where CCONTROL='".$Control."'";
				$Resp=mysql_query($Consulta);
				$Fila=mysql_fetch_array($Resp);
				echo $Fila[NCONTROL];
			}
			else
				echo "TODOS";	 
	  ?>
</td>
	<td align="left" class="formulario">Control:
		<?
			if($TipoControl!='T')
			{
				$Consulta="SELECT NTCONTROLES from sgrs_tipo_controles where CTCONTROLES='".$TipoControl."'";
				$Resp=mysql_query($Consulta);
				$Fila=mysql_fetch_array($Resp);
				echo $Fila[NTCONTROLES];
			}
			else
				echo "TODOS";
	  ?>
	  </td>
  </tr>
</table>
	<table width="90%" border="1" cellpadding="0" cellspacing="0">

	</table>

	 <table width="100%" border="1" cellpadding="0" cellspacing="0">
	 <? 
			$CODAREA=ObtenerCodParent($CodSelTarea);
			$Consulta="SELECT t1.CTAREA from sgrs_areaorg t1 where t1.CAREA = '".$CODAREA."'";
			$Resultado=mysql_query($Consulta);
			$Fila=mysql_fetch_array($Resultado);
			$CodTarea=$Fila[CTAREA];
			if($CodTarea==8)
				$Filtro="t1.CAREA='".$CODAREA."'";
			else
				$Filtro="t1.CPARENT like '".$CodSelTarea."%'";				
			$Consulta="SELECT t1.NAREA,t1.CAREA,t1.CPARENT from sgrs_areaorg t1 inner join sgrs_siperoperaciones t2 on t1.CAREA=t2.CAREA ";
			$Consulta.=" inner join sgrs_siperpeligros t3 on t1.CAREA=t3.CAREA inner join sgrs_sipercontroles t7 on t3.CPELIGRO=t7.CPELIGRO inner join sgrs_codcontroles t5 on t7.CCONTROL=t5.CCONTROL ";
			$Consulta.="where t3.MVIGENTE<>'0' and t1.CTAREA='8' and ".$Filtro;
			if($OptRut=='S')
				$Consulta2.=" and  t2.MRUTINARIA='1' ";
			if($OptIdent=='S')
				$Consulta2.=" and t2.MIDENTIFICADO='1' ";
			if($OptVal=='S')
				$Consulta2.=" and t2.MVALIDADO='1' ";
			if($CodPel!='T')
				$Consulta2.=" and t3.CCONTACTO='".$CodPel."' ";
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
			}
			if($Control!='T')
				$Consulta2.=" and t7.CCONTROL='".$Control."' and t7.MCONTROL<>0 ";
			if($TipoControl!='T')
				$Consulta2.=" and t7.MCONTROL='".$TipoControl."' ";
			//$Consulta2.=" group by t1.CAREA ";	
			$Consulta=$Consulta.$Consulta2." group by t1.CAREA ";
			//echo $Consulta;
			$Resp=mysql_query($Consulta);$TotTarea=0;$TotPel=0;
			while($Fila=mysql_fetch_array($Resp))
			{
				echo "<tr>";
				$RutaOri=OrigenOrg($Fila[CPARENT],&$Ruta);
				echo "<td align='left' colspan='9' class='titulo_azul'>".strtoupper($Fila[NAREA])."&nbsp;&nbsp;<img src='imagenes/vineta.gif' border='0'>&nbsp;<label class='titulo_cafe_claro'>".$Ruta."<label></td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td align='center' width='29%' class='TituloCabecera' >Peligro</td>";
				echo "<td align='center' width='3%' class='TituloCabecera' >MR</td>";
				//echo "<td align='center' width='25%' class='TituloCabecera' >Obs/Comentario</td>";
				echo "<td align='center' width='45%' class='TituloCabecera' >";
				echo "<table width='96%' border='0' cellspacing='0' cellpadding='0'>";
				echo "<tr>";
				echo "<td colspan='2' align='center' width='70%' class='TituloCabecera'>Controles</td>";
				echo "<td align='center' width='30%' class='TituloCabecera'>Verificadores Operacionales</td>";
				echo "</tr>";
				echo "</table>";
				echo "</td>";
				//echo "<td align='center' width='25%' class='TituloCabecera' >Verificadores Operacionales</td>";
				/*echo "<td align='center' width='3%' class='TituloCabecera' >PH</td>";
				echo "<td align='center' width='3%' class='TituloCabecera' >CH</td>";
				echo "<td align='center' width='3%' class='TituloCabecera' >PC</td>";
				echo "<td align='center' width='3%' class='TituloCabecera'>CC</td>";*/
				echo "<td align='center' width='3%' class='TituloCabecera' >MR</td>";
				echo "<td align='center' width='6%' class='TituloCabecera' >Validado</td>";
				echo "</tr>";
				$Consulta="SELECT t6.NCONTACTO,t3.TOBSERVACION,t3.CPELIGRO,t3.CCONTACTO,t3.MVALIDADO from sgrs_areaorg t1 inner join sgrs_siperoperaciones t2 on t1.CAREA=t2.CAREA ";
				$Consulta.=" inner join sgrs_siperpeligros t3 on t1.CAREA=t3.CAREA inner join sgrs_codcontactos t6 on t3.CCONTACTO=t6.CCONTACTO left join sgrs_sipercontroles t7 on t3.CPELIGRO=t7.CPELIGRO ";
				$Consulta.="where t1.CTAREA='8' and t1.CAREA = '".$Fila[CAREA]."' and t3.MVIGENTE <> 0";
				if($MR=='S')
					$Consulta=$Consulta.$Consulta3." group by t3.CPELIGRO ";
				else
					$Consulta=$Consulta.$Consulta2." group by t3.CPELIGRO ";
				//echo $Consulta;
				$Resp2=mysql_query($Consulta);
				while($Fila2=mysql_fetch_array($Resp2))
				{
					$PH='';$CH='';$PC='';$CC='';$Validado='';
					if($Fila2[MVALIDADO]=='1')
						$Validado='SI';
					CalculoMR($Fila2[CCONTACTO],$Fila2[CPELIGRO],&$PH,&$CH,&$MRi,&$PC,&$CC,&$MR,&$Descrip,&$Semaforo);						
					echo "<tr>";
					echo "<td align='left' width='30%'>".$Fila2[CCONTACTO]." - ".$Fila2[NCONTACTO]."</td>";
					echo "<td align='center' width='3%'><img src='imagenes/$Semaforo' border=0 width='18' height='30'></td>";
					//echo "<td align='center' width='25%'><textarea rows='2' cols='50' readonly>".$Fila2[TOBSERVACION]."</textarea></td>";
					echo "<td align='left' width='30%'>&nbsp;";
					if($Descrip!="ACEPTABLE"&&$Descrip!="MODERADO"&&$Descrip!="INACEPTABLE")
						echo $Descrip;
					echo "<table width='96%' border='0' cellspacing='0' cellpadding='0'>";
					$Consulta="SELECT t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES,t1.TOBSERVACION from sgrs_sipercontroles t1 inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES where t1.CPELIGRO ='".$Fila2[CPELIGRO]."'";
					$RespCtrl=mysql_query($Consulta);
					while($FilaCtrl=mysql_fetch_array($RespCtrl))
					{
						echo "<tr>";
						echo "<td align='left' width='60%'>&nbsp;".$FilaCtrl[CCONTROL]." - ".$FilaCtrl[NCONTROL]."</td>";
						echo "<td align='left' width='10%'>&nbsp;".$FilaCtrl[ATCONTROLES]."</td>";
						echo "<td align='left' width='30%'>&nbsp;".$FilaCtrl[TOBSERVACION]."</td>";
						echo "</tr>";
					}
					echo "</table>";
					echo "</td>";
					//echo "<td align='center' width='5%'>".$PH."</td>";
					//echo "<td align='center' width='5%'>".$CH."</td>";
					//echo "<td align='center' width='5%'>".$PC."&nbsp;</td>";
					//echo "<td align='center' width='5%'>".$CC."&nbsp;</td>";
					echo "<td align='center' width='3%'><img src='imagenes/$Semaforo' border=0 width='18' height='30'></td>";
					echo "<td align='center' width='7%'>".$Validado."&nbsp;</td>";
					echo "</tr>";
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