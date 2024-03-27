<?
if($Buscar=='')
{
	$CmbUnidOpe='T';
	$CmbLugares='T';
	$CmbAgentes='T';
	$CmbMr='T';
	$TxtFechaIni='';
	$TxtFechaFin='';
	$TxtMag='';
	$TxtMag2='';
}
$Nivel=ObtieneNivelUsuario($CookieRut);
if(!isset($CheckAccion))
	$CheckAccion='';
?><head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/siper_funciones.js"></script>
<script language="javascript">
function MedExcel()
{
	var f=document.Mantenedor;
	var Cod="";
	var Opcion='';
	
	if(f.OptAccion.checked==true)
		Opcion='checked';
	else
		Opcion='';	
	
	Cod="Buscar="+f.Buscar.value+"&CmbLugares="+f.CmbLugares.value+"&CmbUnidOpe="+f.CmbUnidOpe.value+"&CmbAgentes="+f.CmbAgentes.value+"&CmbMr="+f.CmbMr.value+"&TxtFechaIni="+f.TxtFechaIni.value+"&TxtFechaFin="+f.TxtFechaFin.value+"&TxtMag="+f.TxtMag.value+"&TxtMag2="+f.TxtMag2.value+"&SelTarea="+f.SelTarea.value+'&CheckAccion='+Opcion;
	URL='consulta_mediciones_ambientales_excel.php?'+Cod;
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
				f.TxtFechaFin.value=f.TxtFechaIni.value
				//alert('Debe Ingresar Fecha T�rmino');
				//return;
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
	/*if(f.TxtFechaIni.value=='')
	{
		alert('Debe Ingresar Fecha Inicio');
		return;
	}*/
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
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) 
		{
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 40 ");
		}
	}
}

function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
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
	<table width="96%" border="0" cellpadding="0" cellspacing="4">
      <tr>
        <td width="15%" height="36" align="left"><img src="imagenes/LblCriterios.png" width="168" height="28"></td>
        <td width="19%" height="36" align="right"><span class="formulario">Area Organizacional:</span></td>
        <td width="41%" rowspan="5" align="left" valign="top"><br>
		<div style='position:absolute; visibility:visible; width:380px; height:159px; OVERFLOW:auto;' id='OrganicaHI'>
          <table border='0' cellpadding='0' cellspacing='0' >
            <?
		 CrearArbolHI($Navega,$Estado,$SelTarea,'');
	    ?>
          </table>
        </div></td>
        <td height="36" align="left">&nbsp;</td>
        <td height="36" align="right"><a href="JavaScript:BuscarGen('BG')"><img src="imagenes/btn_buscar.gif" border="0" alt="Buscar General"></a>&nbsp;<a href="javascript:window.print()"><img src="imagenes/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle"></a>&nbsp;<a href="javascript:MedExcel()"><img src="imagenes/btn_excel.png" alt='Excel' border="0" align="absmiddle"></a></td>
      </tr>
      <tr>
        <td height="28" colspan="2" align="left" class="formulario">Lugar de Medici&oacute;n:		  
          <SELECT name="CmbLugares" style="width:280px">
            <option value='T' SELECTed>Todos</option>
            <?
			$Consulta="SELECT * from sgrs_lugares order by NLUGAR ";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				if($CmbLugares==$Fila[CLUGAR])
					echo "<option value='".$Fila[CLUGAR]."' SELECTed>".$Fila[NLUGAR]."  -> CORD_XYZ (".$Fila[CCORDX].",".$Fila[CCORDY].",".$Fila[CCORDZ].")</option>";
				else
					echo "<option value='".$Fila[CLUGAR]."'>".$Fila[NLUGAR]."  -> CORD_XYZ (".$Fila[CCORDX].",".$Fila[CCORDY].",".$Fila[CCORDZ].")</option>";	
			}
		  ?>
            </SELECT></td>
        <td width="8%" align="right" nowrap="nowrap" class="formulario">Agente: </td>
        <td width="17%" align="left" nowrap="nowrap"><SELECT name="CmbAgentes" style="width:100px" onChange="MostrarLPP()">
            <option value='T' SELECTed>Todos</option>
            <?
			$Consulta="SELECT t1.CAGENTE,t1.NAGENTE,t1.QLPP,t2.NUNIDAD from sgrs_cagentes t1 inner join sgrs_unidades t2 on t1.CUNIDAD=t2.CUNIDAD where t1.MVIGENTE='1' order by t1.NAGENTE";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				if($CmbAgentes==$Fila[CAGENTE])
					echo "<option value='".$Fila[CAGENTE]."' SELECTed>".$Fila[NAGENTE]."</option>";
				else
					echo "<option value='".$Fila[CAGENTE]."'>".$Fila[NAGENTE]."</option>";	
			}
		  ?>
          </SELECT>          </td>
      </tr>
      <tr>
        <td height="25" colspan="2" align="left" class="formulario">Unidad Operativa:
          <SELECT name="CmbUnidOpe" style="width:280px">
            <option value='T' SELECTed>Todos</option>
            <?
			$Consulta="SELECT t1.CAREA,t1.NAREA from sgrs_areaorg t1 where t1.CTAREA='5' order by t1.NAREA";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				if($CmbUnidOpe==$Fila[CAREA])
					echo "<option value='".$Fila[CAREA]."' SELECTed>".$Fila[NAREA]."</option>";
				else
					echo "<option value='".$Fila[CAREA]."'>".$Fila[NAREA]."</option>";	
			}
		  ?>
            </SELECT></td>
        <td align="right" class="formulario"> Valor Magnitud:</td>
        <td align="left"><input name="TxtMag" type="text" size="8" value="<? echo $TxtMag; ?>" onKeyDown="TeclaPulsada(true)" maxlength="5" onBlur="ValidarRango()">
          &nbsp;Y&nbsp;
          <input name="TxtMag2" type="text" size="8" value="<? echo $TxtMag2; ?>" onKeyDown="TeclaPulsada(true)" maxlength="5" onBlur="ValidarRango()">         </td>
      </tr>
      <tr>
        <td height="25" colspan="2" align="left" class="formulario">Rango de Fechas:<span class="formulario">Desde</span>
          <input name="TxtFechaIni" type="text" class="InputCen" value="<? echo $TxtFechaIni; ?>" size="10" maxlength="10" onblur="DateFormat(this,this.value,event,true,'3',Mantenedor,'DIF')" onkeyup="DateFormat(this,this.value,event,false,'3')"  onfocus="javascript:vDateType='3'" />
          <span class="formulario">Hasta</span>
          <input name="TxtFechaFin" type="text" class="InputCen" value="<? echo $TxtFechaFin; ?>" size="10" maxlength="10" onblur="DateFormat(this,this.value,event,true,'3',Mantenedor,'DIF')" onkeyup="DateFormat(this,this.value,event,false,'3')"  onfocus="javascript:vDateType='3'" /></td>
        <td align="right" class="formulario">MR:</td>
        <td align="left"><SELECT name="CmbMr">
          <option value="T" SELECTed>Todos</option>
          <?
			switch($CmbMr)
			{
				case "ACEPTABLE":
					echo "<option value='ACEPTABLE' SELECTed>Aceptable</option>";
					echo "<option value='MODERADO'>Moderado</option>";
					echo "<option value='INACEPTABLE'>Inaceptable</option>";
				break;
				case "MODERADO":
					echo "<option value='ACEPTABLE'>Aceptable</option>";
					echo "<option value='MODERADO' SELECTed>Moderado</option>";
					echo "<option value='INACEPTABLE'>Inaceptable</option>";
				break;
				case "INACEPTABLE":
					echo "<option value='ACEPTABLE'>Aceptable</option>";
					echo "<option value='MODERADO'>Moderado</option>";
					echo "<option value='INACEPTABLE' SELECTed>Inaceptable</option>";
				break;
				default:
					echo "<option value='ACEPTABLE'>Aceptable</option>";
					echo "<option value='MODERADO'>Moderado</option>";
					echo "<option value='INACEPTABLE'>Inaceptable</option>";
				break;
			}
		?>
        </SELECT></td>
      </tr>
      <tr>
        <td height="36" align="right" class="formulario">&nbsp;</td>
        <td align="left">&nbsp;</td>
        <td align="right" class="formulario"><?
		if($Nivel=='6')
			echo "Con Obs. de Gesti&oacute;n";	
		?></td>
        <td align="left">&nbsp;&nbsp;
          <?
		if($Nivel=='6')
		{	
		?>
          <input type="checkbox" name="OptAccion" value="checkbox" <? echo $CheckAccion;?> class="SinBorde" />
          <?
		}
		else
		{
		?>
          <input type="hidden" name="OptAccion" value="checkbox" <? echo $CheckAccion;?> class="SinBorde" />
          <?
		}
		?></td>
      </tr>
    </table>
	<br>
		  <table width="95%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="20%" class="TituloCabecera" align="center">Area organizacional</td>
			<td width="15%" class="TituloCabecera" align="center">Lugar de Medici&oacute;n </td>
			<td width="2%" class="TituloCabecera" align="center">X</td>
			<td width="2%" class="TituloCabecera" align="center">Y</td>
			<td width="2%" class="TituloCabecera" align="center">Z</td>
			<td width="3%" class="TituloCabecera" align="center">Agente</td>
			<td width="3%" class="TituloCabecera" align="center">Magnitud</td>
			<td width="3%" class="TituloCabecera" align="center">LPP</td>
			<td width="3%" class="TituloCabecera" align="center">Unid.</td>
			<td width="3%" class="TituloCabecera" align="center">Dosis</td>
			<td width="3%" class="TituloCabecera" align="center">MR</td>
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
			if($Buscar!='')
			{
				$Consulta="SELECT t1.REGACCIONES,t7.CPARENT,t7.NAREA,t5.TNARCHIVO,t5.CVINFORME,t1.CMEDAMB,t1.QMR,t1.QDOSIS,t1.QMEDICION,t1.FINICIO,t1.FTERMINO,t2.NAREA,t4.NLUGAR,t3.NAGENTE,t3.QLPP,t4.CCORDX,t4.CCORDY,t4.CCORDZ,t6.AUNIDAD from sgrs_medambientes t1 inner join sgrs_areaorg t2 on t1.CAREA=t2.CAREA ";
				$Consulta.="inner join sgrs_cagentes t3 on t1.CAGENTE=t3.CAGENTE inner join sgrs_unidades t6 on t3.CUNIDAD=t6.CUNIDAD inner join sgrs_lugares t4 on t1.CLUGAR = t4.CLUGAR inner join sgrs_informes t5 on t1.CINFORME=t5.CINFORME inner join sgrs_areaorg t7 on t1.CAREA=t7.CAREA where t1.CMEDAMB <> 0 ";
				switch($Buscar)
				{
					case "BG"://BUSCAR GENERAL
						if($SelTarea!='')
						{
							$CodNivel=ObtenerCodParent($SelTarea);
							$Consulta.=" and (t7.CPARENT like '%".$CodNivel."%' or t1.CAREA='".$CodNivel."') ";
						}
						if($CmbUnidOpe!='T')
							$Consulta.=" and t1.CAREA = '".$CmbUnidOpe."'";
						if($CmbLugares!='T')
							$Consulta.=" and  t4.CLUGAR = '".$CmbLugares."' ";
						if($CmbAgentes!='T')
							$Consulta.=" and  t1.CAGENTE = '".$CmbAgentes."%' ";
						if($CmbMr!='T')
							$Consulta.=" and  t1.QMR like '".$CmbMr."%' ";
						if($TxtFechaIni!=''&&$TxtFechaFin!='')
							$Consulta.=" and  t1.FINICIO >= '".FormatoFechaAAAAMMDD($TxtFechaIni)." 00:00:00'  and t1.FTERMINO <='".FormatoFechaAAAAMMDD($TxtFechaFin)." 23:59:59'";
						if($TxtMag!=''&&$TxtMag2!='')
							$Consulta.=" and  t1.QMEDICION >= '".str_replace(',','.',$TxtMag)."' and t1.QMEDICION <= '".str_replace(',','.',$TxtMag2)."'";	
						if($CheckAccion=='checked')
							$Consulta.=" and REGACCIONES <>''";	
						break;
	
				}
				$Consulta.="order by t4.NLUGAR";
				//echo $Consulta;
				$Resp=mysqli_query($link, $Consulta);$Cont=0;
				while($Fila=mysql_fetch_array($Resp))
				{
					echo "<tr>";
					OrigenOrg($Fila[CPARENT],&$Ruta);
					echo "<td align=\"left\"  onMouseOver='JavaScript:muestra(".$Cont.");' onMouseOut='JavaScript:oculta(".$Cont.");' >";
					echo "<div id='Txt".$Cont."'  style= 'position:Absolute; background-color:#ffffff; visibility:hidden; border:solid 1px Black;width:800px'>\n";
					echo "<font face='courier' color='#000000' size=1 class='formulario'>".$Ruta."</font></div> "; 
					echo $Fila[NAREA]."</td>";
					echo "<td align='left'>&nbsp;".$Fila[NLUGAR]."</td>";
					echo "<td>".$Fila[CCORDX]."&nbsp;</td>";
					echo "<td>".$Fila[CCORDY]."&nbsp;</td>";
					echo "<td>".$Fila[CCORDZ]."&nbsp;</td>";
					echo "<td align='left'>&nbsp;".$Fila[NAGENTE]."</td>";
					echo "<td>".$Fila[QMEDICION]."</td>";
					echo "<td>".$Fila[QLPP]."</td>";
					echo "<td>".$Fila[AUNIDAD]."</td>";
					/*if($Fila[AUNIDAD]!='DB')
					{
						$Dosis=round(($Fila[QMEDICION]/$Fila[QLPP])*100)/100;
						$Actualizar="UPDATE sgrs_medambientes set QDOSIS=".$Dosis." where CMEDAMB='".$Fila[CMEDAMB]."'";
						mysql_query($Actualizar);
						echo $Fila[QMEDICION]."    ".$Fila[QLPP]."<br>";
						echo $Actualizar."<br>";
					}*/
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
					echo "<td class='formulario'>".substr($Fila[QMR],0,1)."</td>";
					echo "<td><img src='imagenes/".$Semaforo."' border=0 width='18' height='30'></td>";
					echo "<td>&nbsp;".$Fila[FINICIO]."</td>";
					echo "<td>&nbsp;".$Fila[FTERMINO]."</td>";
					echo "<td align='left'><a href='informes/".$Fila["TNARCHIVO"]."' target='_blank'><img src='imagenes/btn_adjuntar2.png' height='20' alt='Ver Informe Adjunto' width='20' border='0' align='absmiddle'>".$Fila["CVINFORME"]."</a></td>";
					if($Nivel=='6')
						echo "<td align='center'><textarea name='TxtMuestraAccion' cols='35' Rows='2'>".$Fila[REGACCIONES]."</textarea></td>";
					echo "</tr>";
					$Cont++;
				}
		 	}
		 ?>
	    </table><br>
	</td>
	<td width="5" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
</html>