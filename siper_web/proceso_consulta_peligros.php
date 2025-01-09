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
	$CmbVerificador = isset($_REQUEST["CmbVerificador"])?$_REQUEST["CmbVerificador"]:"";
	$CmbPeligros = isset($_REQUEST["CmbPeligros"])?$_REQUEST["CmbPeligros"]:"";
	$CmbControles = isset($_REQUEST["CmbControles"])?$_REQUEST["CmbControles"]:"";
	$CmbMRi = isset($_REQUEST["CmbMRi"])?$_REQUEST["CmbMRi"]:"";
	$CmbMR  = isset($_REQUEST["CmbMR"])?$_REQUEST["CmbMR"]:"";
	$CodSelTarea  = isset($_REQUEST["CodSelTarea"])?$_REQUEST["CodSelTarea"]:"";
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
	var CodSelTarea=top.frames['Organica'].document.FrmOrganica.SelTarea.value;
	var OptRut='N';
	var OptIdent='N';
	var OptVal='N';
	var OptSoloTareaNivel='N';
	var CodPel=top.frames['Procesos'].document.Mantenedor.CmbPeligros.value;
	var MR=top.frames['Procesos'].document.Mantenedor.CmbMR.value;;
	var Control=top.frames['Procesos'].document.Mantenedor.CmbControles.value;
	var TipoVerifi=top.frames['Procesos'].document.Mantenedor.CmbVerificador.value;
	var MRi=top.frames['Procesos'].document.Mantenedor.CmbMRi.value;
	var f=document.Mantenedor;
	if(top.frames['Organica'].document.FrmOrganica.SelTarea.value=='')
	{
		alert('Debe Seleccionar Nivel del Item a Consultar');
		return;
	}
	CmbRut=f.CmbRut.value;
	CmbIdent=f.CmbIdent.value;
	CmbValidado=f.CmbValidado.value;
	if(top.frames['Procesos'].document.Mantenedor.CheckTareasNivel.checked==true)
		OptSoloTareaNivel='S';
		
	if(Opt=='W')						
		URL='proceso_consulta_peligros_popup.php?CodSelTarea='+CodSelTarea+'&CmbRut='+CmbRut+'&CmbIdent='+CmbIdent+'&CmbValidado='+CmbValidado+'&OptSoloTareaNivel='+OptSoloTareaNivel+'&CodPel='+CodPel+'&MR='+MR+'&Control='+Control+'&TipoVerif='+TipoVerifi+'&MRiCC='+MRi;
	else
		URL='proceso_consulta_peligros_popup_excel.php?CodSelTarea='+CodSelTarea+'&CmbRut='+CmbRut+'&CmbIdent='+CmbIdent+'&CmbValidado='+CmbValidado+'&OptSoloTareaNivel='+OptSoloTareaNivel+'&CodPel='+CodPel+'&MR='+MR+'&Control='+Control+'&TipoVerif='+TipoVerifi+'&MRiCC='+MRi;
		
	//alert(URL);
	window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");

	//top.frames['Procesos'].location='procesos_consultas_peligros_popup.php?TipoPestana='+Pestana+'&Buscar=S&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&OptRut='+OptRut+'&OptIdent='+OptIdent+'&OptVal='+OptVal;

}
function Recarga(Opc,Parent)
{
	var CodPel=top.frames['Procesos'].document.Mantenedor.CmbPeligros.value;
	var Opcion=top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value;
	top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value=Opcion;
	top.frames['Procesos'].location='procesos_consultas.php?TipoPestana='+Opcion+'&MostrarCmb=S&CodSelTarea='+top.frames['Organica'].document.FrmOrganica.SelTarea.value+'&CmbPeligros='+CodPel;
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
<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td width="5" background="imagenes/tab_separator.gif"></td>
	<td align="center">
	<div id='Resumen'  style='overflow:auto;WIDTH: 90%; height:360px;left: 15px; top: 85px;'>
	<table width="90%" border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td height="36%" align="left"><?php echo DescripOrganica2($CodSelTarea,$link);?></td>
        <td height="36%" align="left">&nbsp;</td>
        <td height="36%" colspan="2" align="left">&nbsp;</td>
        <td width="24%" rowspan="2" align="right"><a href="javascript:Consultar('W')"><img src="imagenes/btn_buscar.gif" width="30" height="30" border="0" alt="Buscar"></a>&nbsp;<a href="javascript:Consultar('E')"><img src="imagenes/btn_excel.png" width="30" height="30" border="0" alt="Excel"></a></td>
      </tr>
      <tr>
        <td height="25%" align="left"><img src="imagenes/LblCriterios.png" width="168" height="28"></td>
        <td height="25%" align="left">&nbsp;</td>
        <td height="25%" colspan="2" align="left">&nbsp;</td>
        </tr>
      <tr>
        <td width="23%" align="left" class="formulario">Rutinaria:
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
		<!--<input name="CheckRut" type="checkbox" class="SinBorde" value="checkbox" <?php //echo $CheckeadoRut;?>>-->		</td>
        <td width="28%" align="left" class="formulario">Identificado:
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
		<!--<input type="checkbox" name="CheckIdent" value="checkbox" class="SinBorde" <?php //echo $CheckeadoIdent;?>>-->		</td>
        <td width="21%" align="left" class="formulario">Validado:
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
		<!--<input type="checkbox" name="CheckVal" value="checkbox" class="SinBorde" <?php //echo $CheckeadoVal;?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->		</td>
        <td colspan="2" align="left" class="formulario"><span class="formulario">Solo Tareas del Nivel:
            <input type="checkbox" name="CheckTareasNivel" value="checkbox" class="SinBorde" <?php echo $CheckeadoTareasNivel;?> />
        </span></td>
        </tr>
      <tr>
        <td align="left" class="formulario">Peligros:
          <label></label></td><?php //echo $CodSelTarea;
		  
		  $CODAREA=ObtenerCodParent($CodSelTarea);
 				$Consulta1="select * from sgrs_areaorg ";
				$Consulta1.=" where CAREA ='".$CODAREA."'";
				//echo $Consulta1."<br>";
				$Resp1=mysqli_query($link,$Consulta1);
				if($Fila1=mysqli_fetch_array($Resp1))
					$CTAREA=$Fila1["CTAREA"];
				//echo 	$CTAREA."<br>";	
		  ?>
        <td colspan="4" align="left" class="formulario"><select name="CmbPeligros" onchange="Recarga('R','<?php echo $CodSelTarea;?>')">
          <option value="T">Todos</option>
          <?php
				
				$CODAREA=ObtenerCodParent($CodSelTarea);
				$Consulta="select distinct t4.CCONTACTO,t4.NCONTACTO,t4.CCONTACTO as orden,t3.CPELIGRO,t3.CAREA from sgrs_areaorg t1 inner join sgrs_siperoperaciones t2 on t1.CAREA=t2.CAREA ";
				$Consulta.=" inner join sgrs_siperpeligros t3 on t1.CAREA=t3.CAREA inner join sgrs_codcontactos t4 on t3.CCONTACTO=t4.ccontacto ";
				if($CTAREA=='8')
					$Consulta.="where t1.CTAREA='8' and t1.CAREA ='".$CODAREA."' group by t4.CCONTACTO order by orden ";
				else	
					$Consulta.=" where t1.CTAREA='8' and t1.CPARENT like '".$CodSelTarea."%' group by t4.CCONTACTO order by orden ";
				if($OptRut=='S')
					$Consulta.=" and  t2.MRUTINARIA='1' ";
				if($OptIdent=='S')
					$Consulta.=" and t2.MIDENTIFICADO='1' ";
				if($OptVal=='S')
					$Consulta.=" and t2.MVALIDADO='1' ";
				//echo $Consulta;
				$Resp=mysqli_query($link,$Consulta);$TotTarea=0;$TotPel=0;
				while($Fila=mysqli_fetch_array($Resp))
				{
					if($CmbPeligros==$Fila["CPELIGRO"])
					{
						$CAREA2=$Fila["CAREA"];
						echo "<option value='".$Fila["CPELIGRO"]."' selected>".$Fila["NCONTACTO"]."</option>";
					}	
					else
						echo "<option value='".$Fila["CPELIGRO"]."'>".$Fila["NCONTACTO"]."</option>";
				}
		  ?>
        </select>
          <?php //echo $CAREA2;?></td>
        </tr>
      <tr>
        <td align="left" class="formulario">MRi:</td>
        <td colspan="3" align="left" class="formulario"><select name="CmbMRi">
          <?php
		  	switch($CmbMRi)
			{
				case "T";
					echo "<option value='T' >TODOS</option>";
					echo "<option value='1' selected>ACEPTABLE</option>";
					echo "<option value='2' >MODERADO</option>";
					echo "<option value='3' >INACEPTABLE</option>";
				break;
				case "1";
					echo "<option value='T' >TODOS</option>";
					echo "<option value='1' >ACEPTABLE</option>";
					echo "<option value='2' selected>MODERADO</option>";
					echo "<option value='3' >INACEPTABLE</option>";
				break;
				case "2";
					echo "<option value='T' >TODOS</option>";
					echo "<option value='1' >ACEPTABLE</option>";
					echo "<option value='2' >MODERADO</option>";
					echo "<option value='3' selected>INACEPTABLE</option>";
				break;
				case "3";
					echo "<option value='T' >TODOS</option>";
					echo "<option value='1' >ACEPTABLE</option>";
					echo "<option value='2' >MODERADO</option>";
					echo "<option value='3' >INACEPTABLE</option>";
				break;

				default:
					echo "<option value='T' selected>TODOS</option>";
					echo "<option value='1' >ACEPTABLE</option>";
					echo "<option value='2' >MODERADO</option>";
					echo "<option value='3' >INACEPTABLE</option>";
				break;												
			}
		  
		  ?>
        </select></td>
        <td align="left" class="formulario">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" class="formulario">          MRr:          </td>
        <td colspan="3" align="left" class="formulario"><select name="CmbMR">
            <?php
		  	switch($CmbMR)
			{
				case "A";
					echo "<option value='T' >TODOS</option>";
					echo "<option value='A' selected>ACEPTABLE</option>";
					echo "<option value='M' >MODERADO</option>";
					echo "<option value='I' >INACEPTABLE</option>";
				break;
				case "M";
					echo "<option value='T' >TODOS</option>";
					echo "<option value='A' >ACEPTABLE</option>";
					echo "<option value='M' selected>MODERADO</option>";
					echo "<option value='I' >INACEPTABLE</option>";
				break;
				case "I";
					echo "<option value='T' >TODOS</option>";
					echo "<option value='A' >ACEPTABLE</option>";
					echo "<option value='M' >MODERADO</option>";
					echo "<option value='I' selected>INACEPTABLE</option>";
				break;
				case "I";
					echo "<option value='T' >TODOS</option>";
					echo "<option value='A' >ACEPTABLE</option>";
					echo "<option value='M' >MODERADO</option>";
					echo "<option value='I' >INACEPTABLE</option>";
				break;

				default:
					echo "<option value='T' selected>TODOS</option>";
					echo "<option value='A' >ACEPTABLE</option>";
					echo "<option value='M' >MODERADO</option>";
					echo "<option value='I' >INACEPTABLE</option>";
				break;												
			}
		  
		  ?>
          </select></td>
        <td align="left" class="formulario">&nbsp;</td>
      </tr>
      <tr><?php if($CmbPeligros=="") $CmbPeligros='T';?>
        <td align="left" class="formulario">Controles:          </td>
        <td colspan="3" align="left" class="formulario"><select name="CmbControles">
          <option value="T">Todos</option>
          <?php
				$Consulta="select t3.NCONTROL,t2.CCONTROL from sgrs_areaorg t1 inner join sgrs_sipercontroles t2 on t1.CAREA=t2.CAREA ";
				$Consulta.=" inner join sgrs_codcontroles t3 on t2.CCONTROL=t3.CCONTROL ";
				if($CTAREA!='8')
					$Consulta.=" where t1.CPARENT like '%".$CODAREA."%'";
				else
					$Consulta.=" where t1.CAREA='".$CODAREA."'";	
				if($CmbPeligros!='T')
					$Consulta.=" and t2.CPELIGRO='".$CmbPeligros."'";
				$Consulta.=" group by t2.CCONTROL";	
				/*$Consulta="select t2.NCONTROL,t1.CCONTROL,t3.ATCONTROLES from sgrs_sipercontroles t1";
				$Consulta.=" inner join sgrs_codcontroles t2 on t1.CCONTROL=t2.CCONTROL inner join sgrs_tipo_controles t3 on t1.MCONTROL=t3.CTCONTROLES";
				//$Consulta.=" left join sgrs_tipo_verificador t4 on t1.VERIFICADOR_OPER=t4.COD_VERIFICADOR";
				if($CTAREA!='8')
					$Consulta.=" where t1.CAREA='".$CAREA2."'";
				else
					$Consulta.=" where t1.CAREA='".$CODAREA."'";	
				if($CmbPeligros!='T')
					$Consulta.=" and t1.CPELIGRO='".$CmbPeligros."'";
				$Consulta.=" group by t1.CCONTROL";*/	

				//$Consulta.=" where t1.CAREA='".$CODAREA."' and t1.CPELIGRO ='".$CmbPeligros."'";
				$RespCtrl=mysqli_query($link,$Consulta);
				while($FilaCtrl=mysqli_fetch_array($RespCtrl))
				{
					if($CmbControles==$FilaCtrl["CCONTROL"])
						echo "<option value='".$FilaCtrl["CCONTROL"]."' selected>".$FilaCtrl["NCONTROL"]."</option>";
					else
						echo "<option value='".$FilaCtrl["CCONTROL"]."'>".$FilaCtrl["NCONTROL"]."</option>";
				}
		  ?>
        </select>
          <?php //echo $Consulta;?></td>
        <td align="left" class="formulario">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" class="formulario">Verificadores:          </td>
        <td colspan="3" align="left" class="formulario"><?php if($CmbPeligros=="") $CmbPeligros='T';?>
		<select name="CmbVerificador">
          <option value="T">Todos</option>
          <?php
				$Consulta="select t3.COD_VERIFICADOR,t3.DESCRIP_VERIFICADOR from sgrs_areaorg t1 inner join sgrs_siperverificadores t2 on t1.CAREA=t2.CAREA ";
				$Consulta.=" inner join sgrs_tipo_verificador t3 on t2.COD_VERIFICADOR=t3.COD_VERIFICADOR ";
				if($CTAREA!='8')
					$Consulta.=" where t1.CPARENT like '%".$CODAREA."%'";
				else
					$Consulta.=" where t1.CAREA='".$CODAREA."'";
				if($CmbPeligros!='T')
					$Consulta.=" and t2.CPELIGRO ='".$CmbPeligros."'";	
				$Consulta.=" group by t3.COD_VERIFICADOR order by t3.COD_VERIFICADOR";
				
				/*$Consulta="select * from sgrs_tipo_verificador t1 inner join sgrs_siperverificadores t2 on t1.COD_VERIFICADOR=t2.COD_VERIFICADOR where ";
				$Consulta.="CAREA='".$CODAREA."'";
				if($CmbPeligros!='T')
					$Consulta.=" and t2.CPELIGRO ='".$CmbPeligros."'";	
				$Consulta.=" group by t1.COD_VERIFICADOR order by t1.COD_VERIFICADOR";*/
				$Resp=mysqli_query($link,$Consulta);
				while($Fila=mysqli_fetch_array($Resp))
				{
					if($CmbVerificador==$Fila["COD_VERIFICADOR"])
						echo "<option value='".$Fila["COD_VERIFICADOR"]."' selected>".$Fila["DESCRIP_VERIFICADOR"]."</option>";
					else
						echo "<option value='".$Fila["COD_VERIFICADOR"]."'>".$Fila["DESCRIP_VERIFICADOR"]."</option>";
				}
		  ?>
        </select><?php //echo $Consulta;?></td>
        <td align="left" class="formulario">&nbsp;</td>
      </tr>
    </table>
	</div>
	</td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>