<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/siper_funciones.js"></script>
<script language="javascript">
function NuevoMedAmb(Opcion)
{
	var f=document.Mantenedor;
	f.Proceso.value=Opcion;
	f.Navega.value='';
	//DivBtnProc.style.visibility='visible';
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=N&LimpiarForm=S';
	f.submit();	
}
function ModMedAmb(Opcion)
{
	var f=document.Mantenedor;
	if(SoloUnElemento(f.name,'CheckRut','M'))
	{
		DatosMed=Recuperar(f.name,'CheckRut','M');
		//DivBtnProc.style.visibility='visible';
		f.Navega.value='';
		f.Proceso.value=Opcion;
		f.DatosMed.value=DatosMed;
		f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=S&DatosMed='+DatosMed;
		f.submit();	
	}
}
function EliMedAmb(Opcion)
{
	var f=document.Mantenedor;
	
	if(SoloUnElemento(f.name,'CheckRut','E'))
	{
		mensaje=confirm("�Esta Seguro de Eliminar estos Registros?");
		if(mensaje==true)
		{
			DatosMedAmb=Recuperar(f.name,'CheckRut');
			Cod='ProcesoAux='+Opcion+'&DatosMedAmb='+DatosMedAmb;
			f.action='procesos.php?'+Cod;
			f.submit();
		}
	}	
}
function Cerrar()
{
	var f=document.Mantenedor;
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
		case "NMA":
		if(f.CodNivel.value=='')
		{
			alert('Debe Seleccionar �rea Organizacional');
			return;
		}
		if(f.CmbLugares.value=='S')
		{
			alert('Debe Seleccionar Lugar');
			//f.CmbFun.focus();
			return;
		}
		break;
		case "MMA":
		break;
		default:
		break;
	}
	if(f.CmbAgentes.value=='S')
	{
		alert('Debe Seleccionar Agente');
		return;	
	}
	if(f.TxtFechaIni.value=='')
	{
		alert('Debe Ingresar Fecha Inicio');
		return;	
	}
	if(f.TxtHoraIni.value=='')
	{
		alert('Debe Ingresar Hora Inicio');
		return;	
	}
	if(f.TxtFechaFin.value=='')
	{
		alert('Debe Ingresar Fecha T�rmino');
		return;	
	}
	if(f.TxtHoraFin.value=='')
	{
		alert('Debe Ingresar Hora T�rmino');
		return;	
	}
	ValidaDifFecha();
	ValidarHora('I');
	ValidarHora('F');
	if(f.TxtMag.value=='')
	{
		alert('Debe Ingresar Magnitud');
		return;	
	}
	if(f.TxtDosis.value==''&&f.Unidad.value=='DB')
	{
		alert('Debe Ingresar Dosis');
		return;	
	}
	
	if(f.CmbInformes.value=='S')
	{
		alert('Debe Seleccionar Informes');
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
function MostrarLPP()
{
	var f=document.Mantenedor;
	
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=S&Recarga=S';
	f.submit();
}
function FiltrarApePat()
{
	var f=document.Mantenedor;
	
	f.action='procesos_hi.php?TipoPestana='+f.PestanaActiva.value+'&MostrarDivMed=S&MostrarDivOrg=S&FiltrarApePat=S';
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
<form name="FrnMedAmb" method="post">
<input type="hidden" name="CodMedAmb" value="<? echo $CodMedAmb;?>">
<?
$Nivel=ObtieneNivelUsuario($CookieRut);
$EstDivBtnProc='hidden';
if($Proceso=='NMA'||$Proceso=='MMA')
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
        <td width="9%" height="28" align="right" class="formulario">Area Organiz.:</td>
        <td width="19%" align="left"><input name="TxtArea" type="text" value="<? echo $TxtArea;?>"><a href="JavaScript:Buscar('A')"><img src="imagenes/btn_buscar.gif" width="19" height="18" border="0"></a></td>
        <td width="14%" align="right" class="formulario">Lugar de Medici�n:</td>
        <td width="17%" align="left"><input name="TxtLugar" type="text" value="<? echo $TxtLugar;?>"><a href="JavaScript:Buscar('L')"><img src="imagenes/btn_buscar.gif" width="19" height="18" border="0"></a></td>
        <td width="41%" align="right" nowrap="nowrap"><div id="DivBtnProc" style="visibility:<? echo $EstDivBtnProc;?>; FILTER: alpha(opacity=100); position:absolute; width:auto; height:auto"><table border='0' width="80px" height="30px"><tr><td>&nbsp;</td></tr></table></div>
		<a href="javascript:NuevoMedAmb('NMA')"><img src="imagenes/btn_agregar.png" alt='Agregar Medicion Ambiental' border="0" align="absmiddle"></a>
		<a href="javascript:ModMedAmb('MMA')"><img src='imagenes/btn_modificar.png' alt='Modificar Mediciones Ambiental' border='0' width='25' align='absmiddle' /></a>
      	<a href="javascript:EliMedAmb('EMA')"><img src='imagenes/btn_eliminar2.png' alt='Eliminar Mediciones Ambiental' border='0' width='25' align='absmiddle' /></a></td>
	  </tr>
      <tr>
        <td height="25" align="right" class="formulario">&nbsp;</td>
        <td align="left"></td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right">&nbsp;</td>
      </tr>
    </table>
		  <div id='Resumen'  style='overflow:auto;WIDTH: 90%; height:260px;left: 15px; top: 65px;'>
		  <table width="95%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="4%" class="TituloCabecera" align="center">Sel.</td>
			<td width="20%" class="TituloCabecera" align="center">Area Organizacional</td>
			<td width="15%" class="TituloCabecera" align="center">Lugar</td>
			<td width="2%" class="TituloCabecera" align="center">X</td>
			<td width="2%" class="TituloCabecera" align="center">Y</td>
			<td width="2%" class="TituloCabecera" align="center">Z</td>
			<td width="8%" class="TituloCabecera" align="center">Agente</td>
			<td width="8%" class="TituloCabecera" align="center">Magnitud</td>
			<td width="8%" class="TituloCabecera" align="center">LPP</td>
			<td width="3%" class="TituloCabecera" align="center">Unid.</td>
			<td width="5%" class="TituloCabecera" align="center">Dosis</td>
			<td width="8%" class="TituloCabecera" align="center">MR</td>
			<td width="1%" class="TituloCabecera" align="center">&nbsp;</td>
			<td width="10%" class="TituloCabecera" align="center">Fecha Inicio</td>
			<td width="10%" class="TituloCabecera" align="center">Fecha T�rmino</td>
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
				$Consulta="SELECT t1.REGACCIONES,t1.QDOSIS,t6.CVINFORME,t6.TNARCHIVO,t1.CMEDAMB,t1.QMR,t1.QMEDICION,t1.FINICIO,t1.FTERMINO,t2.NAREA,t4.NLUGAR,t3.NAGENTE,t3.QLPP,t4.CCORDX,t4.CCORDY,t4.CCORDZ,t5.AUNIDAD from sgrs_medambientes t1 inner join sgrs_areaorg t2 on t1.CAREA=t2.CAREA ";
				$Consulta.="inner join sgrs_cagentes t3 on t1.CAGENTE=t3.CAGENTE inner join sgrs_unidades t5 on t3.CUNIDAD=T5.CUNIDAD inner join sgrs_lugares t4 on t1.CLUGAR = t4.CLUGAR inner join sgrs_informes t6 on t1.CINFORME=t6.CINFORME where t1.CMEDAMB <> 0 ";
				switch($Buscar)
				{
					case "A":
						$Consulta.=" and t2.NAREA like '".$TxtArea."%'";
					break;
					case "L":
						$Consulta.=" and  t4.NLUGAR like '".$TxtLugar."%' ";
					break;
				}
				$Consulta.="order by t4.NLUGAR";
				//echo $Consulta;
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					echo "<tr>";
					echo "<td align='center'><input type='checkbox' name='CheckRut' class='SinBorde' value='".$Fila[CMEDAMB]."'></td>";
					echo "<td align='left'>&nbsp;".$Fila[NAREA]."</td>";
					echo "<td align='left'>&nbsp;".$Fila[NLUGAR]."</td>";
					echo "<td>".$Fila[CCORDX]."&nbsp;</td>";
					echo "<td>".$Fila[CCORDY]."&nbsp;</td>";
					echo "<td>".$Fila[CCORDZ]."&nbsp;</td>";
					echo "<td align='left'>&nbsp;".$Fila[NAGENTE]."</td>";
					echo "<td>".$Fila[QMEDICION]."</td>";
					echo "<td>".$Fila[QLPP]."</td>";
					echo "<td>".$Fila[AUNIDAD]."</td>";
					echo "<td>".$Fila[QDOSIS]."&nbsp;</td>";
					switch($Fila[QMR])
					{
						case "ACEPTABLE":
							$Semaforo='semaforo_verde.jpg';
							//$QMR='A';
							break;
						case "MODERADO":
							$Semaforo='semaforo_amarillo.jpg';
							//$QMR='M';
							break;
						case "INACEPTABLE":
							$Semaforo='semaforo_rojo.jpg';
							//$QMR='Intolerable';
							break;		
					
					}
					echo "<td>".$Fila[QMR]."</td>";
					echo "<td><img src='imagenes/".$Semaforo."' border=0 width='18' height='30'></td>";
					echo "<td>&nbsp;".$Fila[FINICIO]."</td>";
					echo "<td>&nbsp;".$Fila[FTERMINO]."</td>";
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
			case "NMA":
				$TituloProceso="Agregar Mediciones Ambientales";
				if($LimpiarForm=='S')
				{
					$CodNivel='';$CmbLugares='S';$CmbAgentes='S';$LPP='';$TxtFechaIni='';$TxtHoraIni='';$TxtFechaFin='';$TxtHoraFin='';
					$TxtDuracion='';$TxtMag='';$MR='';$TxtDosis='';$CmbInformes='S';$TxtObs='';$TxtDosis='';$TxtAccion='';
				}
				break;
			case "MMA":
				$TituloProceso="Modificar Mediciones Ambientales";
				$Consulta="SELECT * from sgrs_medambientes where CMEDAMB='".$DatosMed."'";
				//echo $Consulta;
				$Resp=mysql_query($Consulta);
				$Fila=mysql_fetch_array($Resp);
				$CodMedPers=$DatosMed;
				$Rut=$Fila[CRUT];
				$Consulta="SELECT CPARENT from sgrs_areaorg where CAREA='".$Fila[CAREA]."'";
				$RespArea=mysql_query($Consulta);
				$FilaArea=mysql_fetch_array($RespArea);
				if($CambiaOrg=='S')
					$NOSE='';
					//$SelTarea=$FilaArea[CPARENT].",".$Fila[CAREA].",";	
				else
					$CodNivel=$Fila[CAREA];
				if($Recarga!='S')
				{
					$CmbLugares=$Fila[CLUGAR];
					$CmbAgentes=$Fila[CAGENTE];
					$Consulta="SELECT TNARCHIVO from sgrs_informes where CINFORME='".$Fila[CINFORME]."'";
					$RespInf=mysql_query($Consulta);
					$FilaInf=mysql_fetch_array($RespInf);
					$CmbInformes=$Fila[CINFORME]."~#".$FilaInf[TNARCHIVO];
					$FechaHoraIni=explode(' ',$Fila[FINICIO]);
					$TxtFechaIni=FormatoFechaDDMMAAAA($FechaHoraIni[0]);
					$TxtHoraIni=substr($FechaHoraIni[1],0,5);
					$FechaHoraFin=explode(' ',$Fila[FTERMINO]);
					$TxtFechaFin=FormatoFechaDDMMAAAA($FechaHoraFin[0]);
					$TxtHoraFin=substr($FechaHoraFin[1],0,5);
					$TxtMag=$Fila[QMEDICION];
					$MR=$Fila[QMR];
					$TxtDosis=$Fila[QDOSIS];
					$TxtObs=$Fila[TOBSERVACION];
					$TxtAccion=$Fila[REGACCIONES];
					//$CodNivel=$Fila[CAREA];
				}	
				break;	
			default:
					$CodNivel='';$CmbLugares='S';$CmbAgentes='S';$LPP='';$TxtFechaIni='';$TxtHoraIni='';$TxtFechaFin='';$TxtHoraFin='';
					$TxtDuracion='';$TxtMag='';$TxtDosis='';$MR='';$CmbInformes='S';$TxtObs='';$TxtAccion='';
		}	
		switch($MR)
		{
			case "ACEPTABLE":
				$DivVisV='visible';
				$DivVisA='hidden';	
				$DivVisR='hidden';
				break;
			case "MODERADO":
				$DivVisV='hidden';
				$DivVisA='visible';	
				$DivVisR='hidden';
				break;
			case "INTOLERABLE":
				$DivVisV='hidden';
				$DivVisA='hidden';	
				$DivVisR='visible';
				break;
			default:
				$DivVisV='hidden';
				$DivVisA='hidden';	
				$DivVisR='hidden';
				break;		
		}
  ?>
  <div id='DivMedAmb'  style='FILTER: alpha(opacity=100); overflow:auto; VISIBILITY: <? echo $Visible;?>; WIDTH: 80%; height:490px; POSITION: absolute; moz-opacity: .75; opacity: .75;  left: 153px; top: 9px;'>
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
			<table width="690" border="0">
			<tr>
			  <td width="194" rowspan="12" align="left" valign="top" class="formulario">
			  <div style='position:absolute; visibility:visible;left:20px; top:60px; width:200px; height:300px; OVERFLOW:auto;' id='OrganicaHI'>
			  <table border='0' cellpadding='0' cellspacing='0' >
			  <?
				 CrearArbolHI($Navega,$Estado,$SelTarea,'');
			   ?>
			  </table></div></td>
			  <td width="1" background="imagenes/tab_separator.gif" rowspan="13" align="left" valign="top" class="formulario"></td>
			  </tr>			  
			<tr>
			  <td height="24" align="left" class="formulario">&nbsp;Area Organiz.:</td>
			  <td colspan="3" align="left"><img src="imagenes/arbol.gif" height="18" alt="Organica" width="18" border="0" align="bottom">
		  	  <?
				if(!isset($CodNivel))
					$CodNivel=ObtenerCodParent($SelTarea);
			  ?>
		      <input name="CodNivel" type="hidden" value="<? echo $CodNivel;?>" size="2"><label class='InputAzul'><? echo strtoupper(DescripOrganica3($CodNivel));?></label></td>
			</tr>
			<tr>
			  <td width="162" align="left" class="formulario">&nbsp;Lugar de Medici�n:</td>
			  <td width="168" align="left" colspan="3">
				<SELECT name="CmbLugares" style="width:300px">
				<option value='S' SELECTed>Seleccionar</option>
				  <?
					$Consulta="SELECT * from sgrs_lugares where CAREA='".$CodNivel."' order by NLUGAR ";
					$Resp=mysql_query($Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						if($CmbLugares==$Fila[CLUGAR])
							echo "<option value='".$Fila[CLUGAR]."' SELECTed>".$Fila[NLUGAR]."  -> CORD_XYZ (".$Fila[CCORDX].",".$Fila[CCORDY].",".$Fila[CCORDZ].")</option>";
						else
							echo "<option value='".$Fila[CLUGAR]."'>".$Fila[NLUGAR]."  -> CORD_XYZ (".$Fila[CCORDX].",".$Fila[CCORDY].",".$Fila[CCORDZ].")</option>";	
					}
				  ?>
			  </SELECT></td>
			</tr>
			
			<tr>
			  <td width="162" align="left" class="formulario">&nbsp;Agente:</td>
			  <td width="168" align="left">
				<SELECT name="CmbAgentes" style="width:100px" onchange="MostrarLPP()">
				<option value='S' SELECTed>Seleccionar</option>
				  <?
					$QLPP='';$Unidad='';
					$Consulta="SELECT t1.CAGENTE,t1.NAGENTE,t1.QLPP,t2.AUNIDAD from sgrs_cagentes t1 inner join sgrs_unidades t2 on t1.CUNIDAD=t2.CUNIDAD where t1.MVIGENTE='1' order by t1.NAGENTE";
					$Resp=mysql_query($Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						if($CmbAgentes==$Fila[CAGENTE])
						{
							echo "<option value='".$Fila[CAGENTE]."' SELECTed>".$Fila[NAGENTE]."</option>";
							$QLPP=$Fila[QLPP];
							$Unidad=$Fila[AUNIDAD];
						}
						else
							echo "<option value='".$Fila[CAGENTE]."'>".$Fila[NAGENTE]."</option>";	
					}
				  ?>
			  </SELECT><? //echo $Consulta;?></td>
			  <td width="98" align="left" class="formulario">LPP:&nbsp;&nbsp;&nbsp;<? echo $QLPP." ".strtolower($Unidad);?><input name="LPP" type="hidden" value="<? echo $QLPP;?>" onBlur="CalculoMR()"><input name="Unidad" type="hidden" value="<? echo $Unidad;?>"></td>
			  <td align="left"></td>
			</tr>
			<tr>
			  <td align="left" class="formulario">&nbsp;Fecha de Inicio:</td>
			  <td align="left"><input name="TxtFechaIni" type="text" class="InputCen" value="<? echo $TxtFechaIni; ?>" size="10" maxlength="10" onBlur="DateFormat(this,this.value,event,true,'3',Mantenedor,'DIF')" onKeyUp="DateFormat(this,this.value,event,false,'3')"  onfocus="javascript:vDateType='3'"></td>
			  <td width="98" align="left" class="formulario">Hora de Inicio:</td>
			  <td width="77" align="left"><input name="TxtHoraIni" type="text" value="<? echo $TxtHoraIni;?>" size="5" onblur="ValidarHora('I')" maxlength="5"></td>
			</tr>
			<tr>
			  <td align="left" class="formulario">&nbsp;Fecha de T�rmino:</td>
			  <td align="left"><input name="TxtFechaFin" type="text" class="InputCen" value="<? echo $TxtFechaFin; ?>" size="10" maxlength="10" onBlur="DateFormat(this,this.value,event,true,'3',Mantenedor,'DIF')" onKeyUp="DateFormat(this,this.value,event,false,'3')"  onfocus="javascript:vDateType='3'"></td>
			  <td align="left" class="formulario">Hora de T�rmino:</td>
			  <td align="left"><input name="TxtHoraFin" type="text" size="5"  value="<? echo $TxtHoraFin;?>" maxlength="5" onblur="ValidarHora('F')"></td>
			</tr>
			<tr>
			  <td height="24" align="left" class="formulario">&nbsp;Duraci�n:</td>
			  <td colspan="2" align="left"><input name="TxtDuracion" type="text" size="10" value="<? echo $TxtDuracion;?>" readonly></td>
			  <td align="left">&nbsp;</td>
			</tr>
			<tr>
			  <td height="27" align="left" class="formulario">&nbsp;Magnitud: </td>
			  <td align="left"><input name="TxtMag" type="text" size="10" value="<? echo $TxtMag; ?>" onKeyDown="TeclaPulsada(true)" maxlength="10" onBlur="CalculoMR()"></td>
			  <td align="left" class="formulario">Dosis</td>
			  <td align="left">
			  <?
			  	//if($Unidad=='DB')
					$DosisRead='';
				//else
				//	$DosisRead='readonly';	
			  ?>
			  <input name="TxtDosis" type="text" size="10" value="<? echo $TxtDosis;?>" <? echo $DosisRead;?> onKeyDown="TeclaPulsada(true)" onblur="CalculoMag()" maxlength="10">
			  </td>
			</tr>
			<tr>
			  <td height="27" align="left" class="formulario">&nbsp;MR:</td>
			  <td align="left" nowrap="nowrap"><input name="MR" type="text" value="<? echo $MR;?>" readonly="true" class="SinBorde2">
			  <div id="DivSemVerde" style="visibility:<? echo $DivVisV;?>; position:absolute; ">
			  <img src='imagenes/semaforo_verde.jpg' border=0 width='18' height='30'>
			  </div>
			  <div id="DivSemAmarillo" style="visibility:<? echo $DivVisA;?>; position:absolute;">
			  <img src='imagenes/semaforo_amarillo.jpg' border=0 width='18' height='30'>
			  </div>
			  <div id="DivSemRojo" style="visibility:<? echo $DivVisR;?>; position:absolute; ">
			  <img src='imagenes/semaforo_rojo.jpg' border=0 width='18' height='30'>
			  </div>
			  </td>
			  <td align="left" class="formulario"></td>
			  <td align="left">
			  </td>
			</tr>
			<tr>
			  <td height="27" align="left" class="formulario">&nbsp;Informe:</td>
			  <td align="left" colspan="3">
			  <SELECT name="CmbInformes" style="width:250px">
			  <option value="S">Seleccionar</option>
			  <?
				$Consulta="SELECT * from sgrs_informes order by CVINFORME";
				$Resp=mysql_query($Consulta);
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
			  <td height="27" align="left" class="formulario">&nbsp;Observaci�n:</td>
			  <td height="27" colspan="3" align="left"><textarea name="TxtObs" cols="80" rows="3"><? echo $TxtObs;?></textarea></td>
			</tr>
			<tr>
			  <td height="27" align="left" class="formulario">
			  &nbsp;
				<?
				if($Nivel=='6'&&$MR=='INACEPTABLE')
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
				if($Nivel=='6'&&$MR=='INACEPTABLE')
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
<?
	echo "<script languaje='javascript'>";
	echo "CalculoMR();";
	echo "ValidarHora();";
	echo "</script>";
?>
