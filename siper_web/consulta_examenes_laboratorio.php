<?php
if($Buscar=='')
{
	$TxtRut='';
	$TxtApePat='';
	$CmbTipoExamen='T';
	$CmbEvaluacion='T';
	$TxtFechaIni='';
	$TxtFechaFin='';
	$TxtMag='';
	$TxtMag2='';
}
$Nivel=ObtieneNivelUsuario($CookieRut);
if(!isset($CheckAccion))
	$CheckAccion='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/siper_funciones.js"></script>
<script language="javascript">
function ExamExcel()
{
	var f=document.Mantenedor;
	var Cod="";
	var Opcion='';
	
	if(f.OptAccion.checked==true)
		Opcion='checked';
	else
		Opcion='';	
	
	Cod="Buscar="+f.Buscar.value+"&TxtRut="+f.TxtRut.value+"&TxtApePat="+f.TxtApePat.value+"&CmbTipoExamen="+f.CmbTipoExamen.value+"&CmbEvaluacion="+f.CmbEvaluacion.value+"&TxtFechaIni="+f.TxtFechaIni.value+"&TxtFechaFin="+f.TxtFechaFin.value+"&TxtMag="+f.TxtMag.value+"&TxtMag2="+f.TxtMag2.value+"&TxtOcup="+f.TxtOcup.value+'&CheckAccion='+Opcion;

	URL='consulta_examenes_laboratorio_excel.php?'+Cod;
	window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");

}
function Buscar(Opt)
{
	var f=document.Mantenedor;
	
	switch(Opt)
	{
		case "RV":
			ValidarRango();
		break;
		case "F":
			if(f.TxtFechaIni.value=='')
			{
				alert('Debe Ingresar Fecha Inicio');
				return;
			}
			if(f.TxtFechaFin.value=='')
			{
				alert('Debe Ingresar Fecha Término');
				return;
			}	
		break;
	}
	f.Buscar.value=Opt;
	f.action='consultas_hi.php?TipoPestana='+f.PestanaActiva.value+'&Buscar='+Opt;
	f.submit();	

}
function BuscarGen(Opt)
{
	var f=document.Mantenedor;
	var Opcion='';
	
	if(f.TxtMag.value!=''&&f.TxtMag2.value!='')
		ValidarRango();
	if(f.TxtFechaFin.value=='')
	{
		f.TxtFechaFin.value=f.TxtFechaIni.value;
	}	
	f.Buscar.value=Opt;
	if(f.OptAccion.checked==true)
		Opcion='checked';
	else
		Opcion='';	

	f.action='consultas_hi.php?TipoPestana='+f.PestanaActiva.value+'&Buscar='+Opt+'&CheckAccion='+Opcion;
	f.submit();	

}

function ValidarRango()
{
	var f=document.Mantenedor;
	
	if(f.TxtMag.value!=''&&f.TxtMag2.value!='')
	{
		if(f.TxtMag.value>f.TxtMag2.value)
		{
			alert('Rango Inicial debe ser Menor a Rango Final');
		}
	
	}
	
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo7 {font-size: 12px}
-->
</style>
</head>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td width="5" background="imagenes/tab_separator.gif"></td>
	<td align="center">
	<table width="95%" border="0" cellpadding="0" cellspacing="4">
      <tr>
        <td height="36" align="left"><img src="imagenes/LblCriterios.png" width="168" height="28" /></td>
        <td height="36" align="left">&nbsp;</td>
        <td height="36" align="right" class="formulario">Trabajo/Cargo:</td>
        <td height="36" align="left"><input name="TxtOcup" type="text" value="<?php echo $TxtOcup;?>"></td>
        <td height="36" align="left"><span class="formulario">
          <?php
		if($Nivel=='6')
			echo "Con Obs. de Gesti&oacute;n";	
		?>
        </span>&nbsp;&nbsp;
        <?php
		if($Nivel=='6')
		{	
		?>
        <input type="checkbox" name="OptAccion" value="checkbox" <?php echo $CheckAccion;?> class="SinBorde" />
        <?php
		}
		else
		{
		?>
        <input type="hidden" name="OptAccion" value="checkbox" <?php echo $CheckAccion;?> class="SinBorde" />
        <?php
		}
		?></td>
        <td height="36" align="right"><a href="JavaScript:BuscarGen('BG')"><img src="imagenes/btn_buscar.gif" border="0" alt="Buscar General"></a>&nbsp;<a href="javascript:window.print()"><img src="imagenes/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle" /></a>&nbsp;<a href="javascript:ExamExcel()"><img src="imagenes/btn_excel.png" alt='Excel' border="0" align="absmiddle" /></a></td>
      </tr>
      <tr>
        <td width="20%" height="28" align="right" class="formulario">Rut:</td>
        <td width="14%" align="left"><input name="TxtRut" type="text" value="<?php echo $TxtRut;?>"></td>
        <td width="12%" align="right" class="formulario">Apellido Paterno:</td>
        <td width="22%" align="left"><input name="TxtApePat" type="text" value="<?php echo $TxtApePat;?>"></td>
        <td width="14%" align="right" nowrap="nowrap" class="formulario">Tipo Examen : </td>
        <td width="18%" align="left" nowrap="nowrap">
		<select name="CmbTipoExamen" style="width:100px">
				<option value='T' selected>Todos</option>
				  <?php
					$Consulta="select t1.CTEXAMEN,t1.NEXAMEN,t1.QPARAMETRO,t2.NUNIDAD from sgrs_codexlaboratorio t1 inner join sgrs_unidades t2 on t1.CUNIDAD=t2.CUNIDAD where t1.MVIGENTE='1' order by t1.NEXAMEN ";
					$Resp=mysqli_query($link,$Consulta);
					while($Fila=mysqli_fetch_array($Resp))
					{
						if($CmbTipoExamen==$Fila[CTEXAMEN])
						{
							echo "<option value='".$Fila[CTEXAMEN]."' selected>".$Fila[NEXAMEN]."</option>";
							$PARAM=$Fila[QPARAMETRO];
							$Unidad=$Fila[NUNIDAD];
						}
						else
							echo "<option value='".$Fila[CTEXAMEN]."'>".$Fila[NEXAMEN]."</option>";	
					}
				  ?>
		    </select>
          </td>
      </tr>
      <tr>
        <td height="25" align="right" class="formulario">Evaluaci&oacute;n:</td>
        <td align="left"><select name="CmbEvaluacion" style="width:100px">
		<option value='T' selected>Todos</option>
		  <?php
				switch($CmbEvaluacion)
				{
					case "0":
						echo "<option value='0' selected>NORMAL</option>";
						echo "<option value='2'>MODERADO</option>";
						echo "<option value='1'>ALTERADO</option>";
					break;
					case "1":
						echo "<option value='0' >NORMAL</option>";
						echo "<option value='2'>MODERADO</option>";
						echo "<option value='1' selected>ALTERADO</option>";
					break;
					case "2":
						echo "<option value='0' >NORMAL</option>";
						echo "<option value='2' selected>MODERADO</option>";
						echo "<option value='1' >ALTERADO</option>";
					break;
					default:
						echo "<option value='0'>NORMAL</option>";
						echo "<option value='2'>MODERADO</option>";
						echo "<option value='1'>ALTERADO</option>";
					break;
				}
		  ?>
	  </select>
          &nbsp;</td>
        <td align="right" class="formulario"> Fecha Toma: </td>
        <td align="left"> Desde
          <input name="TxtFechaIni" type="text" class="InputCen" value="<?php echo $TxtFechaIni; ?>" size="10" maxlength="10" onblur="DateFormat(this,this.value,event,true,'3',Mantenedor,'DIF')" onkeyup="DateFormat(this,this.value,event,false,'3')"  onfocus="javascript:vDateType='3'" />
          Hasta
          <input name="TxtFechaFin" type="text" class="InputCen" value="<?php echo $TxtFechaFin; ?>" size="10" maxlength="10" onblur="DateFormat(this,this.value,event,true,'3',Mantenedor,'DIF')" onkeyup="DateFormat(this,this.value,event,false,'3')"  onfocus="javascript:vDateType='3'" />
          &nbsp;</td>
        <td align="right" class="formulario">Rango de Valor:</td>
        <td align="left"><input name="TxtMag" type="text" size="10" value="<?php echo $TxtMag; ?>" onkeydown="TeclaPulsada(true)" maxlength="5" onblur="ValidarRango()" />
          &nbsp;Y&nbsp;
          <input name="TxtMag2" type="text" size="10" value="<?php echo $TxtMag2; ?>" onkeydown="TeclaPulsada(true)" maxlength="5" onblur="ValidarRango()" /></td>
      </tr>
    </table>
	<br>
	<table width="95%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="38%" class="TituloCabecera" align="center">Persona</td>
			<td width="10%" class="TituloCabecera" align="center">Examen</td>
			<td width="9%" class="TituloCabecera" align="center">Resultado</td>
			<td width="10%" class="TituloCabecera" align="center">Parametro</td>
			<td width="8%" class="TituloCabecera" align="center">Unid.</td>
			<td width="5%" class="TituloCabecera" align="center">Evaluacion</td>
			<td width="1%" class="TituloCabecera" align="center">&nbsp;</td>
			<td width="10%" class="TituloCabecera" align="center">Ocupación</td>
			<td width="13%" class="TituloCabecera" align="center">Fecha Toma </td>
			<td width="10%" class="TituloCabecera" align="center">Informe</td>
			<?php
			if($Nivel=='6')
				echo "<td width='10%' class='TituloCabecera' align='center'>Acción Tomada</td>";
			?>
	    </tr>
		 <?php 
			if($Buscar!='')
			{
				$Consulta="select t1.REGACCIONES,t1.CEXAMEN,t1.QVALOR,t1.FEXAMEN,t1.CEVALUACION,t7.CVINFORME,t7.TNARCHIVO,t4.NOCUPACION,t2.rut,t2.ape_paterno,t2.ape_materno,t2.nombres,t3.NEXAMEN,t3.QPARAMETRO,t6.AUNIDAD from sgrs_exlaboratorio t1 inner join uca_web.uca_personas t2 on t1.CRUT=t2.rut ";
				$Consulta.="inner join sgrs_codexlaboratorio t3 on t1.CTEXAMEN=t3.CTEXAMEN left join sgrs_ocupaciones t4 on t1.COCUPACION=t4.COCUPACION left join sgrs_informes t7 on t1.CINFORME=t7.CINFORME inner join sgrs_unidades t6 on t3.CUNIDAD=t6.CUNIDAD where t1.CRUT <> 0 ";
				switch($Buscar)
				{
					case "BG"://BUSCAR GENERAL
						if($TxtRut!='')
							$Consulta.=" and t1.CRUT like '".$TxtRut."%'";
						if($TxtApePat!='')
							$Consulta.=" and  t2.ape_paterno like '".$TxtApePat."%' ";
						if($CmbTipoExamen!='T')
							$Consulta.=" and  t1.CTEXAMEN = '".$CmbTipoExamen."' ";
						if($CmbEvaluacion!='T')
							$Consulta.=" and  t1.CEVALUACION = '".$CmbEvaluacion."' ";
						if($TxtFechaIni!=''&&$TxtFechaFin!='')
							$Consulta.=" and  t1.FEXAMEN between '".FormatoFechaAAAAMMDD($TxtFechaIni)."' and '".FormatoFechaAAAAMMDD($TxtFechaFin)."'";
						if($TxtMag!=''&&$TxtMag2!='')
							$Consulta.=" and  t1.QVALOR>= '".str_replace(',','.',$TxtMag)."' and t1.QVALOR <= '".str_replace(',','.',$TxtMag2)."'";
						if($TxtOcup!='')
							$Consulta.=" and  t4.NOCUPACION like '".$TxtOcup."%' ";	
						if($CheckAccion=='checked')
							$Consulta.=" and REGACCIONES <>''";	
					break;
				}
				$Consulta.="group by t2.rut,t1.CEXAMEN order by t2.ape_paterno";
				//echo $Consulta;
				$Resp=mysqli_query($link,$Consulta);echo "<input type='hidden' name='CheckRut'>";
				while($Fila=mysqli_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td align='left'>&nbsp;".str_pad($Fila[rut],8,'0',STR_PAD_LEFT)." - ".$Fila[ape_paterno]." ".$Fila[ape_materno]." ".$Fila[nombres]."</td>";
					echo "<td align='left'>&nbsp;".$Fila[NEXAMEN]."</td>";
					echo "<td>".$Fila[QVALOR]."</td>";
					echo "<td>".$Fila[QPARAMETRO]."</td>";
					echo "<td>".$Fila[AUNIDAD]."</td>";
					switch($Fila[CEVALUACION])
					{
						case "0":
							echo "<td align='left'>NORMAL</td>";
							$Semaforo='semaforo_verde.jpg';
						break;
						case "2":
							echo "<td align='left'>MODERADO</td>";
							$Semaforo='semaforo_amarillo.jpg';
						break;
						case "1":
							echo "<td align='left'>ALTERADO</td>";
							$Semaforo='semaforo_rojo.jpg';
						break;
					}
					echo "<td><img src='imagenes/".$Semaforo."' border=0 width='18' height='30'></td>";
					echo "<td align='left'>".$Fila[NOCUPACION]."&nbsp;</td>";
					echo "<td align='center'>&nbsp;".$Fila[FEXAMEN]."</td>";
					if(is_null($Fila["CVINFORME"]))
						echo "<td align='left'>&nbsp;</td>";
					else
						echo "<td align='left'><a href='informes/".$Fila["TNARCHIVO"]."' target='_blank'><img src='imagenes/btn_adjuntar2.png' height='20' alt='Ver Informe Adjunto' width='20' border='0' align='absmiddle'>".$Fila["CVINFORME"]."</a></td>";
					if($Nivel=='6')
						echo "<td align='center'><textarea name='TxtMuestraAccion' cols='35' Rows='2'>".$Fila[REGACCIONES]."</textarea></td>";
					echo "</tr>";
				}
			}	
		 ?>
      </table><br>
	</td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
</html>