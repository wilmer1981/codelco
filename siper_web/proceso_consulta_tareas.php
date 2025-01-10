<?php
	$CheckeadoRut='checked';
	$CheckeadoIdent='checked';
	$CheckeadoVal='';
	$CheckeadoTareasNivel='';
	$OptRut  = isset($_REQUEST["OptRut"])?$_REQUEST["OptRut"]:"";
	$OptIdent  = isset($_REQUEST["OptIdent"])?$_REQUEST["OptIdent"]:"";
	$OptVal  = isset($_REQUEST["OptVal"])?$_REQUEST["OptVal"]:"";
	$OptSoloTareaNivel  = isset($_REQUEST["OptSoloTareaNivel"])?$_REQUEST["OptSoloTareaNivel"]:"";
	$CmbRut   = isset($_REQUEST["CmbRut"])?$_REQUEST["CmbRut"]:"";
	$CmbIdent = isset($_REQUEST["CmbIdent"])?$_REQUEST["CmbIdent"]:"";
	$CmbValidado = isset($_REQUEST["CmbValidado"])?$_REQUEST["CmbValidado"]:"";
	
	$Consulta = isset($_REQUEST["Consulta"])?$_REQUEST["Consulta"]:"";	
	if($OptRut=='N')
		$CheckeadoRut='';
	if($OptIdent=='S')
		$CheckeadoIdent='checked';
	if($OptVal=='S')
		$CheckeadoVal='checked';			
	if($OptSoloTareaNivel=='S')
		$CheckeadoTareasNivel='checked';			
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script language="javascript">
function Consultar(Opt)
{
    var f=document.Mantenedor;
	var Pestana=top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value;
	var CmbRut='N';
	var CmbIdent='N';
	var CmbValidado='N';
	var OptSoloTareaNivel='N';
	
	if(top.frames['Organica'].document.FrmOrganica.SelTarea.value=='')
	{
		alert('Debe Seleccionar Nivel del Item a Consultar');
		return;
	}
	CmbRut=f.CmbRut.value;
	CmbIdent=f.CmbIdent.value;
	CmbValidado=f.CmbValidado.value;
/*	if(top.frames['Procesos'].document.Mantenedor.CheckIdent.checked==true)
		OptIdent='S';
	if(top.frames['Procesos'].document.Mantenedor.CheckVal.checked==true)
		OptVal='S';*/
	if(top.frames['Procesos'].document.Mantenedor.CheckTareasNivel.checked==true)
		OptSoloTareaNivel='S';

	if(Opt=='W')	
		top.frames['Procesos'].location='procesos_consultas.php?TipoPestana='+Pestana+'&Consulta=S&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&CmbRut='+CmbRut+'&CmbIdent='+CmbIdent+'&CmbValidado='+CmbValidado+'&OptSoloTareaNivel='+OptSoloTareaNivel;
	else
	{
		URL='proceso_consulta_tareas_popup_excel.php?CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&CmbRut='+CmbRut+'&CmbIdent='+CmbIdent+'&CmbValidado='+CmbValidado+'&OptSoloTareaNivel='+OptSoloTareaNivel;
		window.open(URL,"","top=30,left=30,width=800,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
	}	
}
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
<form name="MantenedorPel" method="post">
<input type="hidden" name="DatosObsPel" size="200">
<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td width="5" background="imagenes/tab_separator.gif"></td>
	<td align="center">
	<table width="90%" border="0" cellpadding="0" cellspacing="4">
      <tr>
        <td height="36" align="left"><img src="imagenes/LblCriterios.png" width="168" height="28"></td>
        <td height="30" align="left">&nbsp;</td>
        <td height="30" align="left">&nbsp;</td>
		<td height="30" align="left">&nbsp;</td>
        <td width="18%" rowspan="2" align="right"><a href="javascript:Consultar('W')"><img src="imagenes/btn_buscar.gif" width="30" height="30" border="0" alt="Buscar"></a>&nbsp;<a href="javascript:Consultar('E')"><img src="imagenes/btn_excel.png" width="30" height="30" border="0" alt="Excel"></a></td>
      </tr>
      <tr>
        <td width="22%" align="left" class="formulario">Rutinaria:
		 <select name="CmbRut">
		<?php			
		  switch($CmbRut)
		  {
		  	case "1":
				echo "<option value='T'>Todos</option>";
				echo "<option value='1' selected>Rutinaria</option>";
				echo "<option value='0'>No Rutinaria</option>";
			break;
		  	case "0":
				echo "<option value='T'>Todos</option>";
				echo "<option value='1'>Rutinaria</option>";
				echo "<option value='0' selected>No Rutinaria</option>";
			break;
			default:
				echo "<option value='T' selected>Todos</option>";
				echo "<option value='1'>Rutinaria</option>";
				echo "<option value='0'>No Rutinaria</option>";
			break;
		  }
		?>
		</select>
		<!--<input name="CheckRut" type="checkbox" class="SinBorde" value="checkbox" <?php //echo $CheckeadoRut;?>>-->
		</td>
        <td width="23%" align="left" class="formulario">Identificado:
		 <select name="CmbIdent">
		<?php			
		  switch($CmbIdent)
		  {
		  	case "1":
				echo "<option value='T'>Todos</option>";
				echo "<option value='1' selected>Identificado</option>";
				echo "<option value='0'>No Identificado</option>";
			break;
		  	case "0":
				echo "<option value='T'>Todos</option>";
				echo "<option value='1'>Identificado</option>";
				echo "<option value='0' selected>No Identificado</option>";
			break;
			default:
				echo "<option value='T' selected>Todos</option>";
				echo "<option value='1'>Identificado</option>";
				echo "<option value='0'>No Identificado</option>";
			break;
		  }
		?>
		</select>
		<!--<input type="checkbox" name="CheckIdent" value="checkbox" class="SinBorde" <?php //echo $CheckeadoIdent;?>>-->
	</td>
        <td width="18%" align="left" class="formulario">Validado:
		 <select name="CmbValidado">
		<?php			
		  switch($CmbValidado)
		  {
		  	case "1":
				echo "<option value='T'>Todos</option>";
				echo "<option value='1' selected>Validado</option>";
				echo "<option value='0'>No Validado</option>";
			break;
		  	case "0":
				echo "<option value='T'>Todos</option>";
				echo "<option value='1'>Validado</option>";
				echo "<option value='0' selected>No Validado</option>";
			break;
			default:
				echo "<option value='T' selected>Todos</option>";
				echo "<option value='1'>Validado</option>";
				echo "<option value='0'>No Validado</option>";
			break;
		  }
		?>
		</select>
		
		<!--<input type="checkbox" name="CheckVal" value="checkbox" class="SinBorde" <?php //echo $CheckeadoVal;?>>-->
		</td>
		<td width="19%" align="left" class="formulario">Solo Tareas del Nivel:
		  <input type="checkbox" name="CheckTareasNivel" value="checkbox" class="SinBorde" <?php echo $CheckeadoTareasNivel;?>></td>
        </tr>
    </table>
	<table width="90%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="50%" class="TituloCabecera" > <div align="center">Descripci&oacute;n</div></td>
			<td width="10%" class="TituloCabecera" ><div align="center">N&ordm; Peligros</div></td>
			<td width="10%" class="TituloCabecera" ><div align="center">N&deg; Especificaci&oacute;n de Controles</div></td>
			<td width="10%" class="TituloCabecera" ><div align="center">N&deg; Especificaci&oacute;n de Verificadores</div></td>
			<td width="10%" class="TituloCabecera" ><div align="center">Fecha Ultima Validaci&oacute;n</div></td>
		 </tr>
	    </table>
		 <div id='Resumen22'  style='overflow:auto;WIDTH: 90%; height:260px;left: 15px; top: 85px;'>
		 <table width="100%" border="1" cellpadding="0" cellspacing="0">
		 <?php //echo $CmbValidado."<br>";
			if($Consulta=='S')
			{
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
				$Resp=mysqli_query($link,$Consulta);$TotTarea=0;$TotPel=0;$TotPelCtrl=0;$TotPelVeri=0;
				while($Fila=mysqli_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td width='50%' align='left' class='titulo_azul'>&nbsp;".strtoupper($Fila["NAREA"])."</td>";
					$Consulta="select ifnull(count(*),0) as cant_pel from sgrs_siperpeligros where MVIGENTE <> 0 and CAREA='".$Fila["CAREA"]."' group by CAREA";	
					//echo $Consulta."<br>";
					$RespPel=mysqli_query($link,$Consulta);
					$FilaPel=mysqli_fetch_array($RespPel);
					$cant_pel = isset($FilaPel["cant_pel"])?$FilaPel["cant_pel"]:"";
					if($cant_pel=="")
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
				echo "<td class='titulo_azul'>TOTALES Tareas (".number_format($TotTarea,0,'','.').")</td>";
				echo "<td class='titulo_azul'>".number_format($TotPel,0,'','.')."</td>";
				echo "<td class='titulo_azul'>".number_format($TotPelCtrl,0,'','.')."</td>";
				echo "<td class='titulo_azul'>".number_format($TotPelVeri,0,'','.')."</td>";
				echo "<td>&nbsp;</td>";
				echo "</tr>";
			}
		 ?>
	    </table>
		</div>
	</td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
</form>
</body>
</html>