<?
if($Buscar=='')
{
	$TxtRut='';
	$TxtApePat='';
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
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script  language="JavaScript" src="funciones/funciones_java.js"></script>
<script  language="JavaScript" src="funciones/siper_funciones.js"></script>
<script language="javascript">
function MedPersExcel()
{
	var f=document.Mantenedor;
	var Cod="";
	var Opcion='';
	
	if(f.OptAccion.checked==true)
		Opcion='checked';
	else
		Opcion='';	
	
	Cod="Buscar="+f.Buscar.value+"&TxtRut="+f.TxtRut.value+"&TxtApePat="+f.TxtApePat.value+"&CmbAgentes="+f.CmbAgentes.value+"&CmbOcupacion="+f.CmbOcupacion.value+"&CmbMr="+f.CmbMr.value+"&TxtFechaIni="+f.TxtFechaIni.value+"&TxtFechaFin="+f.TxtFechaFin.value+"&TxtMag="+f.TxtMag.value+"&TxtMag2="+f.TxtMag2.value+"&SelTarea="+f.SelTarea.value+'&CheckAccion='+Opcion;

	URL='consulta_mediciones_personales_excel.php?'+Cod;
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
		/*case "F":
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
		break;*/
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
<table width="101%" border="0" cellpadding="0"cellspacing="0">
<tr>
	<td width="5" background="imagenes/tab_separator.gif"></td>
	<td width="1221" align="center"><table width="95%" border="0" cellpadding="0" cellspacing="4">
      <tr>
        <td height="36" align="left"><img src="imagenes/LblCriterios.png" width="168" height="28"></td>
        <td width="18%" height="36" align="right" class="formulario">Area Organizacional: </td>
        <td width="45%" rowspan="5" align="left" valign="top"><br>
		<div style='position:absolute; visibility:visible; width:355px; height:147px; OVERFLOW:auto;' id='OrganicaHI'>
		<table border='0' cellpadding='0' cellspacing='0' >
	    <?
		 CrearArbolHI($Navega,$Estado,$SelTarea,'');
	    ?>
	    </table></div></td>
        <td height="36" align="left">&nbsp;</td>
        <td height="36" align="right">&nbsp;<a href="JavaScript:BuscarGen('BG')"><img src="imagenes/btn_buscar.gif" border="0" alt="Buscar General"></a>&nbsp;<a href="javascript:window.print()"><img src="imagenes/btn_imprimir.png" alt='Imprimir' border="0" align="absmiddle"></a>&nbsp;<a href="javascript:MedPersExcel()"><img src="imagenes/btn_excel.png" alt='Excel' border="0" align="absmiddle"></a></td>
      </tr>
      <tr>
        <td width="15%" height="28" align="right" class="formulario">Rut:</td>
        <td align="left"><span class="formulario">
          <input name="TxtRut" type="text" value="<? echo $TxtRut;?>">
        </span></td>
        <td width="9%" align="right" nowrap="nowrap" class="formulario">Agente:		</td>
	    <td width="13%" align="left" nowrap="nowrap">
		  <SELECT name="CmbAgentes" style="width:120px" onChange="MostrarLPP()">
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
	  </SELECT><? //echo $Consulta;?>&nbsp;
		&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right" class="formulario">Apellido Paterno:</td>
        <td align="left"><span class="formulario">
          <input name="TxtApePat" type="text" value="<? echo $TxtApePat;?>">
        </span></td>
        <td align="right" class="formulario">Rango  Magnitud:</td>
        <td align="left">
		<input name="TxtMag" type="text" size="10" value="<? echo $TxtMag; ?>" onKeyDown="TeclaPulsada(true)" maxlength="5" onBlur="ValidarRango()">&nbsp;Y&nbsp;
		<input name="TxtMag2" type="text" size="10" value="<? echo $TxtMag2; ?>" onKeyDown="TeclaPulsada(true)" maxlength="5" onBlur="ValidarRango()">
		&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="right" class="formulario">Ocupacion:</td>
        <td align="left"><SELECT name="CmbOcupacion" style="width:170px">
          <option value="T" SELECTed>Todas</option>
          <?
					$Consulta="SELECT * from sgrs_ocupaciones order by NOCUPACION ";
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
        <td align="right" class="formulario">MR: </td>
        <td align="left"><span class="formulario">
          <SELECT name="CmbMr">
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
          </SELECT>
        </span></td>
      </tr>
      <tr>
        <td height="25" align="right" class="formulario">Rango de Fechas:</td>
        <td align="left"><span class="formulario">Desde<input name="TxtFechaIni" type="text" class="InputCen" value="<? echo $TxtFechaIni; ?>" size="8" maxlength="10" onBlur="DateFormat(this,this.value,event,true,'3',Mantenedor,'DIF')" onKeyUp="DateFormat(this,this.value,event,false,'3')"  onFocus="javascript:vDateType='3'">&nbsp;Hasta<input name="TxtFechaFin" type="text" class="InputCen" value="<? echo $TxtFechaFin; ?>" size="8" maxlength="10" onBlur="DateFormat(this,this.value,event,true,'3',Mantenedor,'DIF')" onKeyUp="DateFormat(this,this.value,event,false,'3')"  onFocus="javascript:vDateType='3'">
        </span></td>
        <td align="right" class="formulario">
		<?
			if($Nivel=='6')
				echo "Con Obs. de Gesti&oacute;n";
		?>
		</td>
        <td align="left">&nbsp;&nbsp;
		<?
		if($Nivel=='6')
		{	
		?>
		<input type="checkbox" name="OptAccion" value="checkbox" <? echo $CheckAccion;?> class="SinBorde">
		<?
		}
		else
		{
		?>
      	<input type="hidden" name="OptAccion" value="checkbox" <? echo $CheckAccion;?> class="SinBorde">
		<?
		}
		?>
		</td>
	  </tr>
    </table>
	<br>
		  <table width="95%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width="13%" class="TituloCabecera" align="center">Area Organ.</td>
			<td width="22%" class="TituloCabecera" align="center">Persona</td>
			<td width="8%" class="TituloCabecera" align="center">Agente</td>
			<td width="5%" class="TituloCabecera" align="center">Magnitud</td>
			<td width="4%" class="TituloCabecera" align="center">LPP</td>
			<td width="4%" class="TituloCabecera" align="center">Unid.</td>
			<td width="4%" class="TituloCabecera" align="center">Dosis</td>
			<td width="3%" class="TituloCabecera" align="center">MR</td>
			<td width="1%" class="TituloCabecera" align="center">&nbsp;</td>
			<td width="13%" class="TituloCabecera" align="center">Ocupaci�n</td>
			<td width="8%" class="TituloCabecera" align="center">Fecha Inicio</td>
			<td width="8%" class="TituloCabecera" align="center">Fecha T�rmino</td>
			<td width="10%" class="TituloCabecera" align="center">Informe</td>
			<?
			if($Nivel=='6')
				echo "<td width='10%' class='TituloCabecera' align='center'>Acci�n Tomada</td>";
			?>
		 </tr>
		 <? 
			if($Buscar!='')
			{
				$Consulta="SELECT t1.REGACCIONES,t7.CPARENT,t7.NAREA,t3.QLPP,t5.TNARCHIVO,t5.CVINFORME,t1.CMEDPERSONAL,t1.QMEDICION,t1.QMR,t1.QDOSIS,t1.FINICIO,t1.FTERMINO,t4.NOCUPACION,t2.rut,t2.ape_paterno,t2.ape_materno,t2.nombres,T3.NAGENTE,t6.AUNIDAD from sgrs_medpersonales t1 inner join uca_web.uca_personas t2 on t1.CRUT=t2.RUT and t2.estado='A'";
				$Consulta.="inner join sgrs_cagentes t3 on t1.CAGENTE=t3.CAGENTE inner join sgrs_unidades t6 on t3.CUNIDAD=t6.CUNIDAD inner join sgrs_ocupaciones t4 on t1.COCUPACION=t4.COCUPACION inner join sgrs_informes t5 on t1.CINFORME=t5.CINFORME inner join sgrs_areaorg t7 on t1.CAREA=t7.CAREA where t1.CRUT <> 0 ";
				switch($Buscar)
				{
					case "BG"://BUSCAR GENERAL
						if($SelTarea!='')
						{
							$CodNivel=ObtenerCodParent($SelTarea);
							$Consulta.=" and (t7.CPARENT like '%".$CodNivel."%' or t1.CAREA='".$CodNivel."') ";
						}
						if($TxtRut!='')
							$Consulta.=" and t1.CRUT like '".$TxtRut."%'";
						if($TxtApePat!='')
							$Consulta.=" and  t2.ape_paterno like '".$TxtApePat."%' ";
						if($CmbAgentes!='T')
							$Consulta.=" and  t1.CAGENTE = '".$CmbAgentes."%' ";
						if($CmbOcupacion!='T')
							$Consulta.=" and  t1.COCUPACION = '".$CmbOcupacion."%' ";
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
				$Consulta.="group by t2.rut,t1.CMEDPERSONAL order by t2.ape_paterno";
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
					echo "<td align='left'>&nbsp;".str_pad($Fila["rut"],10,'0',STR_PAD_LEFT)." - ".$Fila[ape_paterno]." ".$Fila[ape_materno]." ".$Fila["nombres"]."</td>";
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
					echo "<td align='center' class='formulario'>".substr($Fila[QMR],0,1)."</td>";
					echo "<td><img src='imagenes/".$Semaforo."' border=0 width='18' height='30'></td>";
					echo "<td align='left'>".$Fila[NOCUPACION]."</td>";
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
	<td width="15" background="imagenes/tab_separator.gif"></td>
</tr>
</table>
</html>