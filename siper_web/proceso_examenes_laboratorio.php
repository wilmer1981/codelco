
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/siper_funciones.js"></script>
<script language="javascript">
function NuevoExaLab(Opcion)
{
	var f=document.Mantenedor;
	f.Proceso.value=Opcion;
	f.Navega.value='';
	//DivBtnProc.style.visibility='visible';
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=N&LimpiarForm=S';
	f.submit();	
}
function ModExaLab(Opcion)
{
	var f=document.Mantenedor;
	if(SoloUnElemento(f.name,'CheckRut','M'))
	{
		DatosMed=Recuperar(f.name,'CheckRut');
		//DivBtnProc.style.visibility='visible';
		f.Navega.value='';
		f.Proceso.value=Opcion;
		f.DatosMed.value=DatosMed;
		f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=S&Proceso=MMP&DatosMed='+DatosMed;
		f.submit();	
	}
}
function EliExaLab(Opcion)
{
	var f=document.Mantenedor;
	
	if(SoloUnElemento(f.name,'CheckRut','E'))
	{
		mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
		if(mensaje==true)
		{
			DatosMedPer=Recuperar(f.name,'CheckRut');
			f.DatosMed.value=DatosMedPer;
			Cod='ProcesoAux='+Opcion+'&DatosExaLab='+DatosMedPer;
			f.action='procesos.php?'+Cod;
			f.submit();
		}
	}	
}
function Cerrar()
{
	var f=document.Mantenedor;
	f.Proceso.value='';
	f.Proceso.value='';
	f.Navega.value='';
	f.Estado.value='';
	f.SelTarea.value='';
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value;
	f.submit();	
}
function Grabar(Opcion)
{
	var f=document.Mantenedor;
	
	switch(Opcion)
	{
		case "NEL":
		if(f.CmbFun.value=='S')
		{
			alert('Debe Seleccionar Funcionario');
			//f.CmbFun.focus();
			return;
		}
		break;
		case "MEL":
		break;
		default:
		break;
	}
	if(f.CmbTipoExamen.value=='S')
	{
		alert('Debe Seleccionar Tipo Examen');
		return;	
	}
	if(f.CmbEvaluacion.value=='S')
	{
		alert('Debe Seleccionar Evaluaci�n');
		return;	
	}
	if(f.TxtValor.value=='')
	{
		alert('Debe Ingresar Valor');
		return;	
	}
	if(f.TxtFechaIni.value=='')
	{
		alert('Debe Ingresar Fecha Toma de la muestra');
		return;	
	}
	if(f.TxtPeriocidad.value=='')
	{
		alert('Debe Ingresar Periocidad');
		return;	
	}	
	Cod='Proceso='+f.Proceso.value;
	f.action='procesos.php?'+Cod;
	f.submit();

}
function MostrarOrg()
{
	OrganicaHI.style.visibility = 'visible';
}
function MostrarParam()
{
	var f=document.Mantenedor;
	
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=S&Recarga=S';
	f.submit();
}
function FiltrarApePat()
{
	var f=document.Mantenedor;
	var Filtro='';
	
	if(f.Opt[0].checked==true)
		Filtro='A';
	else
		Filtro='R';	
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=S&FiltrarApePat='+Filtro;
	f.submit();
}
function Buscar(Opt)
{
	var f=document.Mantenedor;
	
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&Buscar='+Opt;
	f.submit();	

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
<body>
<form name="MantenedorPel" method="post" >
<?
$Nivel=ObtieneNivelUsuario($CookieRut);
$EstDivBtnProc='hidden';
if($Proceso=='NEL'||$Proceso=='MEL')
	$EstDivBtnProc='visible';
?>
<table width="100%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td width="5" background="imagenes/tab_separator.gif"></td>
	<td align="center"><table width="90%" border="0" cellpadding="0" cellspacing="4">
      <tr>
        <td height="36" colspan="5" align="left"><img src="imagenes/LblCriterios.png" width="168" height="28"></td>
      </tr>
      <tr>
        <td width="9%" height="28" align="right" class="formulario">Rut:</td>
        <td width="19%" align="left"><input name="TxtRut" type="text" value="<? echo $TxtRut;?>"><a href="JavaScript:Buscar('R')"><img src="imagenes/btn_buscar.gif" width="19" height="18" border="0"></a></td>
        <td width="14%" align="right" class="formulario">Apellido Paterno:</td>
        <td width="41%" align="left"><input name="TxtApePat" type="text" value="<? echo $TxtApePat;?>"><a href="JavaScript:Buscar('A')"><img src="imagenes/btn_buscar.gif" width="19" height="18" border="0"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="formulario">Trabajo/Cargo:
          <input name="TxtOcup" type="text" value="<? echo $TxtOcup;?>" />
          <a href="JavaScript:Buscar('O')"><img src="imagenes/btn_buscar.gif" width="19" height="18" border="0" /></a></span></td>
        <td width="17%" align="right" nowrap="nowrap"><div id="DivBtnProc" style="visibility:<? echo $EstDivBtnProc;?>; FILTER: alpha(opacity=100); position:absolute; width:auto; height:auto"><table border='0' width="80px" height="30px"><tr><td>&nbsp;</td></tr></table></div>
		<a href="javascript:NuevoExaLab('NEL')"><img src="imagenes/btn_agregar.png" alt='Agregar Examenes Laboratorio' border="0" align="absmiddle"></a>
		<a href="javascript:ModExaLab('MEL')"><img src='imagenes/btn_modificar.png' alt='Modificar Examenes Laboratorio' border='0' width='25' align='absmiddle' /></a>
      	<a href="javascript:EliExaLab('EEL')"><img src='imagenes/btn_eliminar2.png' alt='Eliminar Examenes Laboratorio' border='0' width='25' align='absmiddle' /></a></td>
	  </tr>
      <tr>
        <td height="25" align="right" class="formulario"></td>
        <td align="left"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
		  <div id='Resumen'  style='overflow:auto;WIDTH: 90%; height:260px;left: 15px; top: 65px;'>
		  <table width="95%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="5%" class="TituloCabecera" align="center">Sel.</td>
			<td width="30%" class="TituloCabecera" align="center">Persona</td>
			<td width="10%" class="TituloCabecera" align="center">Ex�men</td>
			<td width="9%" class="TituloCabecera" align="center">Resultado</td>
			<td width="10%" class="TituloCabecera" align="center">P�rametro</td>
			<td width="3%" class="TituloCabecera" align="center">Unid.</td>
			<td width="5%" class="TituloCabecera" align="center">Evaluaci�n</td>
			<td width="1%" class="TituloCabecera" align="center">&nbsp;</td>
			<td width="10%" class="TituloCabecera" align="center">Ocupaci�n</td>
			<td width="13%" class="TituloCabecera" align="center">Fecha</td>
			<td width="10%" class="TituloCabecera" align="center">Informe</td>
			<?
			if($Nivel=='6')
				echo "<td width='10%' class='TituloCabecera' align='center'>Acci�n Tomada</td>";
			?>
		 </tr>
		 <? 
			echo "<input type='hidden' name='CheckRut'>";
			if($Buscar!='')
			{
				$Consulta="SELECT t1.REGACCIONES,t1.CEXAMEN,t1.QVALOR,t1.FEXAMEN,t1.CEVALUACION,t6.CVINFORME,t6.TNARCHIVO,t2.rut,t2.ape_paterno,t2.ape_materno,t2.nombres,t3.NEXAMEN,t3.QPARAMETRO,t4.NOCUPACION,t5.AUNIDAD from sgrs_exlaboratorio t1 inner join uca_web.uca_personas t2 on t1.CRUT=t2.rut and t2.estado='A'";
				$Consulta.="inner join sgrs_codexlaboratorio t3 on t1.CTEXAMEN=t3.CTEXAMEN inner join sgrs_unidades t5 on t3.CUNIDAD=T5.CUNIDAD left join sgrs_ocupaciones t4 on t1.COCUPACION=t4.COCUPACION left join sgrs_informes t6 on t1.CINFORME=t6.CINFORME where t1.CRUT <> 0 ";
				switch($Buscar)
				{
					case "R":
						$Consulta.=" and t1.CRUT like '".$TxtRut."%'";
					break;
					case "A":
						$Consulta.=" and  t2.ape_paterno like '".$TxtApePat."%' ";
					break;
					case "O":
						$Consulta.=" and  t4.NOCUPACION like '".$TxtOcup."%' ";
					break;
					
				}
				$Consulta.="group by t2.rut,t1.CEXAMEN order by t2.ape_paterno";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td align='center'><input type='checkbox' name='CheckRut' class='SinBorde' value='".$Fila[CEXAMEN]."'></td>";
					echo "<td align='left'>&nbsp;".str_pad($Fila["rut"],8,'0',STR_PAD_LEFT)." - ".$Fila[ape_paterno]." ".$Fila[ape_materno]." ".$Fila["nombres"]."</td>";
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
	    </table>
		</div>
	</td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
  <?  
  		
		if($MostrarDivMed=='S')
			$Visible='visible';
  		else
			$Visible='hidden';
		switch($Proceso)
		{
			case "NEL":
				$TituloProceso="Agregar Ex�menes Laboratorio";
				if($LimpiarForm=='S')
				{
					$CmbFun='S';$TxtBuscApePaterno='';$CodNivel='';$CmbTipoExamen='S';$CmbEvaluacion='S';$TxtFechaIni='';$CmbOcupacion='S';$CmbInformes='S';
					$TxtValor='';$TxtPeriocidad='';$TxtObs='';$TxtAccion='';
				}
				break;
			case "MEL":
				$TituloProceso="Modificar Ex�menes Laboratorio";
				$Consulta="SELECT * from sgrs_exlaboratorio where CEXAMEN='".$DatosMed."'";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);
				$Fila=mysql_fetch_array($Resp);
				$CodMedPers=$DatosMed;
				$Rut=$Fila[CRUT];
				if($Recarga!='S')
				{
					$CmbTipoExamen=$Fila[CTEXAMEN];
					$CmbEvaluacion=$Fila[CEVALUACION];
					$TxtFechaIni=FormatoFechaDDMMAAAA($Fila[FEXAMEN]);
					$TxtValor=$Fila[QVALOR];
					$TxtPeriocidad=$Fila[QPERIODICIDAD];
					$TxtObs=$Fila[TOBSERVACION];
					$Consulta="SELECT TNARCHIVO from sgrs_informes where CINFORME='".$Fila[CINFORME]."'";
					$RespInf=mysqli_query($link, $Consulta);
					$FilaInf=mysql_fetch_array($RespInf);
					$CmbInformes=$Fila[CINFORME]."~#".$FilaInf[TNARCHIVO];
					$CmbOcupacion=$Fila[COCUPACION];
					$TxtAccion=$Fila[REGACCIONES];
				}	
				break;	
		}	
			
  ?>
  <div id='DivMedPers'  style='FILTER: alpha(opacity=100); overflow:auto; VISIBILITY: <? echo $Visible;?>; WIDTH: 80%; height:450px; POSITION: absolute; moz-opacity: .75; opacity: .75;  left: 154px; top: 8px;'>
	<table width="100%" height="85%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td width="1%" height="1%"><img src="imagenes/interior/esq1.gif"></td>
        <td width="97%" height="1%" background="imagenes/interior/form_arriba.gif"><img src="imagenes/interior/transparent.gif"></td>
        <td width="1%" height="1%"><img src="imagenes/interior/esq2.gif" /></td>
      </tr>
      <tr>
        <td width="1%" height="99%" background="imagenes/interior/form_izq.gif"></td>
        <td width="97%" height="99%" valign="top" align="center">
		<table width="98%" height="31" border="0" align="center" cellpadding="2" cellspacing="0" >
            <tr>
              <td><p align="left" class="titulo_azul"><img src="imagenes/vineta.gif" border="0" /><span class="Estilo7"><? echo $TituloProceso;?></span></p></td>
              <td align="right" ><a href="JavaScript:Grabar('<? echo $Proceso;?>')"><img src="imagenes/btn_guardar.png" height="20" alt="Guardar" width="20" border="0" align="absmiddle" /></a> <a href="JavaScript:Cerrar()"><img src="imagenes/cerrar1.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle" /></a> </td>
            </tr>
            <tr>
              <td colspan="2" align='center' ></td>
            </tr>
          </table>
		<table width="680" border="0">
			<tr>
			  <td width="84" rowspan="2" align="left" class="formulario">&nbsp;Funcionario:</td>
			  <td align="left" colspan="3">
			  <?
			  if($Proceso=='NEL')
			  {
			  ?>
			  Buscar 
		      <input name="TxtBuscApePaterno" type="text" size="12">&nbsp;Ape.Paterno<input type="radio" name="Opt" class="SinBorde" checked="checked">&nbsp;Rut<input type="radio" name="Opt" class="SinBorde"><a href="JavaScript:FiltrarApePat()"><img src="imagenes/btn_buscar.gif" width="19" height="18" border="0"></a>
			  <?
			  }
			  ?>			  </td>
		    </tr>
			<tr>
			  <td colspan="3" align="left">
			  <?
			  if($Proceso=='NEL')
			  {
			  ?>
			  <SELECT name="CmbFun">
			  <option value="S" SELECTed>Seleccionar</option>
			  <?
			  	$Consulta="SELECT * from uca_web.uca_personas where estado<>'I' and nombres <> 'S/N' ";
				if($FiltrarApePat=='A')
					$Consulta.=" and ape_paterno like '".$TxtBuscApePaterno."%'";
				if($FiltrarApePat=='R')
					$Consulta.=" and rut like '".$TxtBuscApePaterno."%'";	
				$Consulta.="group by rut order by ape_paterno";
				
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					if($Fila["rut"]==$CmbFun)
						echo "<option value='".$Fila["rut"]."' SELECTed>".str_pad($Fila["rut"],10,'0',STR_PAD_LEFT)." -  ".ucwords(strtolower($Fila[ape_paterno]))." ".ucwords(strtolower($Fila[ape_materno]))." ".ucwords(strtolower($Fila["nombres"]))."</option>";
					else
						echo "<option value='".$Fila["rut"]."'>".str_pad($Fila["rut"],10,'0',STR_PAD_LEFT)." -  ".ucwords(strtolower($Fila[ape_paterno]))." ".ucwords(strtolower($Fila[ape_materno]))." ".ucwords(strtolower($Fila["nombres"]))."</option>";
				}
			  ?>
			  </SELECT>
			  <?
			  }
			  else
			  {
				$Consulta="SELECT * from uca_web.uca_personas where rut='".$Rut."'";
				$Resp=mysqli_query($link, $Consulta);
				$Fila=mysql_fetch_array($Resp);
				echo "<span class='Estilo7'>".ucwords(strtolower($Fila[ape_paterno]))." ".ucwords(strtolower($Fila[ape_materno]))." ".ucwords(strtolower($Fila["nombres"]))."</span>";
				
		  		
			  ?>
			  		<input type="hidden" name="CodMedPers" value="<? echo $CodMedPers;?>">
			  <?
			  }
			  ?>			  </td>
			</tr>			  
			<tr>
			  <td width="84" align="left" class="formulario">&nbsp;Ex�men</td>
			  <td width="241" align="left">
				<SELECT name="CmbTipoExamen" style="width:100px" onchange="MostrarParam()">
				<option value='S' SELECTed>Seleccionar</option>
				  <?
					$Consulta="SELECT t1.CTEXAMEN,t1.NEXAMEN,t1.QPARAMETRO,t2.AUNIDAD from sgrs_codexlaboratorio t1 inner join sgrs_unidades t2 on t1.CUNIDAD=t2.CUNIDAD where t1.MVIGENTE='1' order by t1.NEXAMEN ";
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						if($CmbTipoExamen==$Fila[CTEXAMEN])
						{
							echo "<option value='".$Fila[CTEXAMEN]."' SELECTed>".$Fila[NEXAMEN]."</option>";
							$PARAM=$Fila[QPARAMETRO];
							$Unidad=$Fila[AUNIDAD];
						}
						else
							echo "<option value='".$Fila[CTEXAMEN]."'>".$Fila[NEXAMEN]."</option>";	
					}
				  ?>
			  </SELECT></td>
			  <td align="left" class="formulario"></td>
			  <td align="left"></td>
			  
			</tr>
			<tr>
			  <td height="27" align="left" class="formulario">&nbsp;Resultado: </td>
			  <td align="left"><input name="TxtValor" type="text" size="10" value="<? echo $TxtValor; ?>" onKeyDown="TeclaPulsada(true)" maxlength="5"></td>
			  <td colspan="2" align="left"class="formulario">P�rametro:&nbsp;&nbsp;&nbsp;<? echo $PARAM." ".strtolower($Unidad);?></td>
			</tr>
			<tr>
			  <td align="left" class="formulario">&nbsp;Fecha de Toma Evaluaci�n:</td>
			  <td align="left"><input name="TxtFechaIni" type="text" class="InputCen" value="<? echo $TxtFechaIni; ?>" size="10" maxlength="10" onBlur="DateFormat(this,this.value,event,true,'3',Mantenedor,'')" onKeyUp="DateFormat(this,this.value,event,false,'3')"  onfocus="javascript:vDateType='3'"></td>
			  <td width="140" align="left" class="formulario"></td>
			  <td width="110" align="left"></td>
			</tr>
			<tr>
			  <td width="84" align="left" class="formulario">&nbsp;Evaluaci�n:</td>
			  <td width="241" align="left">
				<SELECT name="CmbEvaluacion" style="width:100px" onchange="Accion()">
				<option value='S' SELECTed>Seleccionar</option>
				  <?
						switch($CmbEvaluacion)
						{
							case "0":
								echo "<option value='0' SELECTed>NORMAL</option>";
								echo "<option value='2'>MODERADO</option>";
								echo "<option value='1'>ALTERADO</option>";
							break;
							case "1":
								echo "<option value='0' >NORMAL</option>";
								echo "<option value='2'>MODERADO</option>";
								echo "<option value='1' SELECTed>ALTERADO</option>";
							break;
							case "2":
								echo "<option value='0' >NORMAL</option>";
								echo "<option value='2' SELECTed>MODERADO</option>";
								echo "<option value='1' >ALTERADO</option>";
							break;
							default:
								echo "<option value='0'>NORMAL</option>";
								echo "<option value='2'>MODERADO</option>";
								echo "<option value='1'>ALTERADO</option>";
							break;
						}
				  ?>
			  </SELECT><? //echo $Consulta;?></td>
			  <td width="140" align="left" class="formulario"></td>
			  <td align="left"></td>
			</tr>
			<tr>
			  <td height="27" align="left" class="formulario">&nbsp;Periocidad:</td>
			  <td align="left"><input name="TxtPeriocidad" type="text" value="<? echo $TxtPeriocidad;?>" size="3" maxlength="3" onKeyDown="TeclaPulsada()">&nbsp;<label class="formulario">Meses</label></td>
			  <td align="left" class="formulario"></td>
			  <td align="left"></td>
			</tr>
			<tr>
			  <td height="27" align="left" class="formulario">&nbsp;Observaci�n:</td>
			  <td height="27" colspan="3" align="left"><textarea name="TxtObs" cols="80" rows="3"><? echo $TxtObs;?></textarea></td>
			</tr>
			<tr>
			  <td height="27" align="left" class="formulario">&nbsp;Informe:</td>
			  <td align="left">
			  <SELECT name="CmbInformes" style="width:250px">
			  <option value="S">Seleccionar</option>
			  <?
				$Consulta="SELECT * from sgrs_informes order by CVINFORME";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					if($CmbInformes==$Fila[CINFORME]."~#".$Fila[TNARCHIVO])
						echo "<option value='".$Fila[CINFORME]."~#".$Fila[TNARCHIVO]."' SELECTed>".$Fila[CVINFORME]."</option>";
					else
						echo "<option value='".$Fila[CINFORME]."~#".$Fila[TNARCHIVO]."'>".$Fila[CVINFORME]."</option>";	
				}
			  
			  ?>
			  </SELECT><a href="JavaScript:Adjunto();"><img src="imagenes/btn_adjuntar2.png" height="20" alt="Ver Informe Adjunto" width="20" border="0" align="absmiddle" /></a></td>
			</tr>
			<tr>
			  <td width="162" align="left" class="formulario">&nbsp;Ocupaci&oacute;n:</td>
			  <td width="168" align="left">
				<SELECT name="CmbOcupacion" style="width:250px">
				<option value="1" SELECTed>SIN DEFINIR</option>
				
				  <?
					$Consulta="SELECT * from sgrs_ocupaciones where COCUPACION <>'1' order by NOCUPACION ";
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						if($CmbOcupacion==$Fila[COCUPACION])
							echo "<option value='".$Fila[COCUPACION]."' SELECTed>".$Fila[NOCUPACION]."</option>";
						else
							echo "<option value='".$Fila[COCUPACION]."'>".$Fila[NOCUPACION]."</option>";	
					}
				  ?>
			  </SELECT></td>
			</tr>
			<tr>
			  <td height="27" align="left" class="formulario">
			  &nbsp;
				<?
				if($Nivel=='6'&&$CmbEvaluacion=='1')
				{
				?>
			    <input name="TxtNomAccion" type="text" value="Acciones Tomadas" readonly="true" class="SinBorde2">
				<?
				}
				else
				{
				?>
				<input name="TxtNomAccion" type="text" value="Acciones Tomadas" readonly="true" class="SinBorde2" style="visibility:hidden">
				<?
				}
				?>
			  </td>
			  <td height="27" colspan="3"align="left">
				<?
				if($Nivel=='6'&&$CmbEvaluacion=='1')
				{
				?>
				  <textarea name="TxtAccion" cols="100" rows="5"><? echo $TxtAccion;?></textarea>
				<?
				}
				else
				{
				?>
					<textarea name="TxtAccion" cols="100" rows="5" style="visibility:hidden"><? echo $TxtAccion;?></textarea>
				<?
				}
				?>
			  </td>
			</tr>

		  </table>
</td>
        <td width="1%" height="99%" background="imagenes/interior/form_der.gif"></td>
      </tr>
      <tr>
        <td width="1%" height="1%"><img src="imagenes/interior/esq3.gif"></td>
        <td width="1%" height="1%" background="imagenes/interior/form_abajo.gif"><img src="imagenes/interior/transparent.gif"></td>
        <td width="1%" height="1%"><img src="imagenes/interior/esq4.gif"></td>
      </tr>
    </table>
  </div>
  <div id='BloqueaIzq'  style='FILTER: alpha(opacity=50); overflow:auto; VISIBILITY: hidden; WIDTH: 100px; height:450px; POSITION:absolute; moz-opacity: .75; opacity: .75;  left: 50px; top: 50px;'>
  <table border="0" width="100%" height="80%">
  <tr><td></td></tr>
  </table>
  </div>	   
  <div id='BloqueaDer'  style='FILTER: alpha(opacity=50); overflow:auto; VISIBILITY: hidden; WIDTH: 100px; height:450px; POSITION:absolute; moz-opacity: .75; opacity: .75;  left: 800px; top: 50px;'>
  <table border="0" width="100%" height="80%">
  <tr><td></td></tr>
  </table>
  </div>

</form>
</body>
</html>