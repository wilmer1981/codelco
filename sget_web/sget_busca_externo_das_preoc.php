<?	
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
?>
<html>
<head>
<title>Ingreso Fecha Charla DAS / Ex�menes</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opt,M,D)
{
	var f=document.FrmSelContrat;
	switch (Opt)
	{
		case 'S':
			window.close();
		break; 
		case 'B':
				if(f.TxtNombre.value=='' && f.TxtPaterno.value=='' && f.TxtMaterno.value=='')
				{
					if(f.CmbEmpresa.value=='-1')
					{
						alert('Debe Seleccionar Empresa para Busqueda.')
						f.CmbEmpresa.focus();
						return;
					}
				}
				f.action="sget_busca_externo_das_preoc.php?Buscar=S";
				f.submit();
		break;
		case "G":
			//DatosFechas=Recuperar6(f.name,'ChkDatos');
			var Datos='';
			for(i=0;i<f.elements.length;i++)
			{
				if(f.TxtFechaDASMasiva.value!='' && f.TxtFechaPreoMasiva.value!='' && f.TxtFechaVigPreoc.value!='')
				{
					if(f.elements[i].name=='CheckConduc' && f.elements[i].checked==true)
						Datos= Datos+f.elements[i].value+"~"+f.TxtFechaDASMasiva.value+"~"+f.TxtFechaPreoMasiva.value+"~"+f.TxtFechaVigPreoc.value+'//';
				}	
				if(f.TxtFechaDASMasiva.value!='' && f.TxtFechaPreoMasiva.value=='' && f.TxtFechaVigPreoc.value=='')
				{
					if(f.elements[i].name=='CheckConduc' && f.elements[i].checked==true)
						Datos= Datos+f.elements[i].value+"~"+f.TxtFechaDASMasiva.value+"~"+f.elements[i+2].value+"~"+f.elements[i+3].value+'//';
				}	
				if(f.TxtFechaDASMasiva.value=='' && f.TxtFechaPreoMasiva.value!='' && f.TxtFechaVigPreoc.value=='')
				{
					if(f.elements[i].name=='CheckConduc' && f.elements[i].checked==true)
						Datos= Datos+f.elements[i].value+"~"+f.elements[i+1].value+"~"+f.TxtFechaPreoMasiva.value+"~"+f.elements[i+3].value+'//';
				}	
				if(f.TxtFechaDASMasiva.value=='' && f.TxtFechaPreoMasiva.value=='' && f.TxtFechaVigPreoc.value=='')
				{
					if(f.elements[i].name=='CheckConduc' && f.elements[i].checked==true)
						Datos= Datos+f.elements[i].value+"~"+f.elements[i+1].value+"~"+f.elements[i+2].value+"~"+f.elements[i+3].value+'//';
				}
				if(f.TxtFechaDASMasiva.value=='' && f.TxtFechaPreoMasiva.value=='' && f.TxtFechaVigPreoc.value!='')
				{
					if(f.elements[i].name=='CheckConduc' && f.elements[i].checked==true)
						Datos= Datos+f.elements[i].value+"~"+f.elements[i+1].value+"~"+f.elements[i+2].value+"~"+f.TxtFechaVigPreoc.value+'//';
				}
			}
			if(Datos=='')
			{
				alert('Debe Seleccionar Personal para Grabar')
				return;
			}
			Datos=Datos.substr(0,Datos.length-2);
			f.DatosFechasPersonal.value=Datos;
			f.action='sget_busca_externo_das_preoc01.php?Proceso=G';
			f.submit();
		break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		
	}
}
function Recarga(Opt) 
{
	var f=document.FrmSelContrat;
	f.action='sget_busca_externo_das_preoc.php';
	f.submit();
}
</script>
</head>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmSelContrat" method="post" action="">
<textarea name="DatosFechasPersonal" style="visibility:hidden;" cols="200"></textarea>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="74%" align="left"><img src="archivos/sub_tit_das_preoc.png" /></td>
    <td align="right"><a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png" align="absmiddle" border="0"></a>
	<a href="JavaScript:Proceso('I')"><img src="archivos/Impresora.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>
      <a href="JavaScript:Proceso('S')"><img src="archivos/close.png" align="absmiddle" border="0"></a>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="3"align="center" class="TituloTablaVerde"></td>
  </tr>
  <tr>
    <td width="1%" align="center" class="TituloTablaVerde"></td>
    <td align="center"><table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0" class="BordeTabla">
      <tr>
        <td class="formulario2">Empresa</td>
        <td class="formulariosimple">&nbsp;</td>
        <td colspan="5" class="formulariosimple"><span class="formulario">
          <SELECT name="CmbEmpresa" id="SELECT" style="width:450" onChange="Recarga('<? echo $Opt;?>');" >
            <option value="-1" class="NoSelec">Seleccionar Empresa</option>
            <?
				$Consulta = "SELECT * from sget_contratistas order by razon_social ";
				$Resp=mysql_query($Consulta);
				while ($FilaTC=mysql_fetch_array($Resp))
				{
					if ($CmbEmpresa==$FilaTC["rut_empresa"])
					{
						echo "<option SELECTed value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
						$Rut=$FilaTC[rut_empresa];
						$Domicilio=$FilaTC[calle];
						$Fono=$FilaTC[telefono_comercial];
						$EMail=$FilaTC[mail_empresa];
						$CodMutual=$FilaTC[cod_mutual_seguridad];
						$FechaVenc=$FilaTC[fecha_ven_cert];
						
					}
					else
						echo "<option value='".$FilaTC["rut_empresa"]."'>".ucfirst($FilaTC["razon_social"])."</option>\n";
				}
				?>
            <option value="*">---SubContratistas---</option>
            <?
				$Consulta1 = "SELECT t2.rut_empresa,t1.razon_social from sget_contratistas t1 inner join sget_sub_contratistas t2 ";
				$Consulta1.= "on t1.rut_empresa=t2.rut_empresa where t2.cod_contrato ='".$CmbContrato."'order by razon_social ";
				$RespSub=mysql_query($Consulta1);
				while ($FilaSub=mysql_fetch_array($RespSub))
				{
					if ($CmbEmpresa==$FilaSub["rut_empresa"])
					{
						echo "<option SELECTed value='".$FilaSub["rut_empresa"]."'>".ucfirst($FilaSub["razon_social"])."</option>\n";
						$Rut=$FilaSub[rut_empresa];
						$Domicilio=$FilaSub[calle];
						$Fono=$FilaSub[telefono_comercial];
						$EMail=$FilaSub[mail_empresa];
						$CodMutual=$FilaSub[cod_mutual_seguridad];
						$FechaVenc=$FilaSub[fecha_ven_cert];
						
					}
					else
						echo "<option value='".$FilaSub["rut_empresa"]."'>".ucfirst($FilaSub["razon_social"])."</option>\n";
				}
				?>
          </SELECT>
        </span></td>
        <td width="19%" rowspan="6" class="BordeBajo"><div align="center"><a href="JavaScript:Proceso('B','<? echo $Masivo; ?>','<? echo $Datos; ?>')"><img src="archivos/buscar_grande.png"  border="0" align="absmiddle" class="formulariosimple"></a> &nbsp;</div></td>
      </tr>
      <tr>
        <td class="formulario2">Contrato</td>
        <td class="formulariosimple">&nbsp;</td>
        <td colspan="5" class="formulariosimple"><span class="formulario">
          <SELECT name="CmbContrato" style="width:450" onChange="Recarga('<? echo $Opt;?>');">
            <option value="S" SELECTed="SELECTed">Todos</option>
            <?
		$FechaActual=date("Y")."-".date("m")."-".date("d");
		$Consulta="SELECT * from sget_contratos where fecha_termino >= '".$FechaActual."'";
		if($CmbEmpresa!='-1')
			$Consulta.=" and rut_empresa='".$CmbEmpresa."'";
		$Consulta.=" order by fecha_termino desc";
		$RespCtto=mysql_query($Consulta);
		while($FilaCtto=mysql_fetch_array($RespCtto))
		{
			if ($FechaActual > $FilaCtto[fecha_termino])
				$Color="red";
			else
				$Color='white';
			if(strtoupper($FilaCtto["cod_contrato"])==strtoupper($CmbContrato))
			{
				echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."' SELECTed>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
				if($TxtFechaCtto==''||$TxtFechaCtto=='0000-00-00')
					$TxtFechaCtto=$FilaCtto[fecha_termino];
				$FechaIniCtto=$FilaCtto[fecha_inicio];
				$FechaFinCtto=$FilaCtto[fecha_termino];
				$AdmCodelco=$FilaCtto["cod_contrato"];
				$AdmContratista=$FilaCtto["cod_contrato"];
				$AreaTrabajo=$FilaCtto[area_trabajo];
				$TipoCtto=$FilaCtto[cod_tipo_contrato];
				$RutPrev=$FilaCtto[rut_prev];
			}	
			else
				echo "<option style='background:".$Color."' value='".$FilaCtto["cod_contrato"]."'>".$FilaCtto["cod_contrato"]."--->".strtoupper($FilaCtto["descripcion"])."</option>";
		}
		?>
          </SELECT>
        </span></td>
      </tr>
      <tr>
        <td width="7%" class="formulario2">Nombres</td>
        <td width="1%" class="formulariosimple">&nbsp;</td>
        <td colspan="5" class="formulariosimple"><input name="TxtNombre" type="text" id="TxtNombre" size="50" value="<? echo $TxtNombre; ?>" maxlength="100"></td>
      </tr>
      <tr>
        <td class="formulario2">Paterno</td>
        <td class="formulariosimple">&nbsp;</td>
        <td colspan="5" class="formulariosimple"><input name="TxtPaterno" type="text" id="TxtPaterno" size="50" value="<? echo $TxtPaterno; ?>" maxlength="100">
          <tr>
            <td class="formulario2">Materno</td>
            <td class="formulariosimple">&nbsp;</td>
            <td colspan="5" class="formulariosimple"><input name="TxtMaterno" type="text" id="TxtMaterno" size="50" value="<? echo $TxtMaterno; ?>" maxlength="100">
      </table>
	  
	  </td>
    <td width="0%" align="center" class="TituloTablaVerde"></td>
  </tr>
   <tr>
	 <td  colspan="3" class="TituloTablaVerde"  align="center">Detalle</td>
   </tr>
	 <td class="TituloTablaVerde" align="center"></td>
	 <td>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="BordeTabla">
  <tr>
    <td width="22"  align="center" class="TituloTablaNaranja"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckConduc','ChkTodos');" /></td>
    <td width="29"  align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">N�</td>
	<td width="81"  align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">Rut</td>
	<td width="173" align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">Nombre</td>
    <td width="277" align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">Empresa</td>
    <td width="104"  align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">Contrato</td>
    <td width="118" align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">Fecha&nbsp;Inicio DAS 
	<input name="TxtFechaDASMasiva" type="text"  size="12" maxlength="12" readonly >
	<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaDASMasiva,TxtFechaDASMasiva,popCal,'S');return false">
	</td>
    <td width="89" align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">Fecha&nbsp;Venc. DAS </td>
    <td width="86" align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">Fecha&nbsp;Venc. Preoc. </td>
    <td width="123" align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">Fecha&nbsp;Inicio Ocup.
	  <input name="TxtFechaPreoMasiva" type="text"  size="12" maxlength="12" readonly >
	<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaPreoMasiva,TxtFechaPreoMasiva,popCal,'S');return false">
	</td>
    <td width="151" align="center" class="TituloTablaNaranja" style="border-left-color:#FFFFFF; border-left-style:solid; border-left-width:thin;">Fecha&nbsp;Venc. Ocupa.
	  <input name="TxtFechaVigPreoc" type="text"  size="12" maxlength="12" readonly >
	<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaVigPreoc,TxtFechaVigPreoc,popCal,'S');return false">
	</td>
  </tr>
  <tr>
<?

if($Buscar=='S')
{
	$Encontro=false;
	$Cont=0;
	$FechaActual=date("Y")."-".date("m")."-".date("d");
	$Consulta = "SELECT t1.fecha_termino_curso,t1.rut,t1.cod_contrato,t1.ape_paterno,t1.ape_materno,t1.nombres,t3.razon_social,t1.fecha_das,t1.fecha_vigencia_exa_preo,t1.fecha_exa_ocup,t1.fecha_vig_exa_ocup from sget_personal t1 inner join sget_contratos t2 ";
	$Consulta.= " on t1.cod_contrato=t2.cod_contrato  ";
	$Consulta.= " inner join sget_contratistas t3  on  t3.rut_empresa=t1.rut_empresa ";
	$Consulta.= " where t2.fecha_termino >= '".$FechaActual."' and t1.estado='A' ";
	if($CmbContrato <> 'S')
		$Consulta.= " and   t1.cod_contrato='".$CmbContrato."' ";
	if($CmbEmpresa <> '-1')
		$Consulta.= " and   t1.rut_empresa='".$CmbEmpresa."' ";
	if($TxtPaterno != '')
		$Consulta.=" and t1.ape_paterno like '%".trim($TxtPaterno)."%' ";	
	if($TxtMaterno != '')
		$Consulta.=" and t1.ape_materno like '%".trim($TxtMaterno)."%' ";	
	if($TxtNombre!='')
		$Consulta.=" and t1.nombres like '%".trim($TxtNombre)."%' ";	
	//echo $Consulta;
	$Consulta.=" order by ape_paterno asc ";		
	echo "<input name='CheckConduc' type='hidden'  value=''>";
	$cont=1;
	$Resp = mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Cont++;
		$Campos=$Cont;
		$FechaTerminoDAS='';$FechaPreoExpi='';
		if($Fila[fecha_das]!='0000-00-00' || $Fila[fecha_exa_ocup]!='0000-00-00')
		{
			$Checked='';
			$ConsultaC="SELECT valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
			$RC=mysql_query($ConsultaC);
			$FC=mysql_fetch_array($RC);
			$AnoDAS=$FC["valor_subclase1"];
			$PreocupaAno=$FC["valor_subclase2"];
			$Ano2Ocu=$FC[valor_subclase3];
			
			$FechaDAS=explode('-',$Fila[fecha_das]);
			if($FechaDAS[0]!='' && $FechaDAS[0]!='0000')
			{
				$FechaDAS[0]=$FechaDAS[0]+$AnoDAS;
				$FechaTerminoDAS=$FechaDAS[0]."-".$FechaDAS[1]."-".$FechaDAS[2];
			}
			else
				$FechaTerminoDAS='';
		    $FechaExa=$Fila[fecha_vigencia_exa_preo];
	  	    $FechaTerminoOcupacional='';
		    if($FechaExa!='' && $FechaExa!='0000-00-00')
		    { 
			  $FechaTerminoOcupacional=explode('-',$FechaExa);
			  $AnoPreo=$FechaTerminoOcupacional[0]+$PreocupaAno;
			  $FechaTerminoOcupacional=$AnoPreo."-".$FechaTerminoOcupacional[1]."-".$FechaTerminoOcupacional[2];
		    }	
				
			if($Fila[fecha_vig_exa_ocup]=='' && $Fila[fecha_vig_exa_ocup]=='0000-00-00')	
			{
				$FechaOcupa=explode('-',$Fila[fecha_exa_ocup]);
				if($FechaOcupa[0]!='' & $FechaOcupa[0]!='0000')
				{
					$FechaOcupa[0]=$FechaOcupa[0]+$Ano2Ocu;
					$FechaOcupaExpi=$FechaOcupa[0]."-".$FechaOcupa[1]."-".$FechaOcupa[2];
				}
				else
					$FechaOcupaExpi='';
			}
			else
				$FechaOcupaExpi=$Fila[fecha_vig_exa_ocup];
				
			if($FechaTerminoDAS< date('Y-m-d') || $FechaOcupaExpi< date('Y-m-d'))
				$Checked='checked=checked';	
			if($FechaTerminoDAS< date('Y-m-d'))	
				$FechaTerminoDAS="<span class='InputRojo'>".$FechaTerminoDAS."</span>";
			else
				$FechaTerminoDAS=$FechaTerminoDAS;	
			if($FechaTerminoOcupacional< date('Y-m-d'))	
				$FechaTerminoOcupacional="<span class='InputRojo'>".$FechaTerminoOcupacional."</span>";
			else
				$FechaTerminoOcupacional=$FechaTerminoOcupacional;	
			if($FechaOcupaExpi< date('Y-m-d'))	
				$FechaOcupaExpi=$FechaOcupaExpi;
			else
				$FechaOcupaExpi=$FechaOcupaExpi;	
		}	
		$Checked='';
		if($Fila[fecha_das]=='0000-00-00' && $Fila[fecha_exa_ocup]=='0000-00-00' || ($Fila[fecha_das]=='' && $Fila[fecha_exa_ocup]==''))	
			$Checked='checked=checked';
		$Ingresado='';	
		if($Fila[fecha_das]!='0000-00-00' && $Fila[fecha_exa_ocup]!='0000-00-00')	
			$Ingresado='bgcolor="#C1FF84"';
			
		if($Fila[fecha_das]=='0000-00-00')	
			$FechaDasIni='';
		else
			$FechaDasIni=$Fila[fecha_das];	
		?>
	<tr align='center' class='BordeBajo'>
		<!--<td align='center' class='BordeBajo'><? echo $Cont;?> </td>-->	
		<td  align='center' class='BordeBajo' <? echo $Ingresado;?>><input type='checkbox' name='CheckConduc' value='<? echo $Fila["rut"];?>' class='SinBorde' <? echo $Checked;?>></td>
		<td  align='center' class='BordeBajo' <? echo $Ingresado;?>><? echo $Cont;?></td>
		<td  align='left' class='BordeBajo' <? echo $Ingresado;?>><? echo $Fila["rut"]; ?>&nbsp;</td>
		<td  class='BordeBajo' align="left" <? echo $Ingresado;?>><? echo FormatearNombre($Fila[ape_paterno]).' '.FormatearNombre($Fila[ape_materno]).' '.FormatearNombre($Fila["nombres"]); ?></td>
		<td  class='BordeBajo' align="left" <? echo $Ingresado;?>><? echo substr(FormatearNombre($Fila[razon_social]),0,40); ?></td>
		<td  class='BordeBajo' <? echo $Ingresado;?>><?  echo $Fila["cod_contrato"];?>&nbsp;</td>	
	    <td  class='BordeBajo' align="center" <? echo $Ingresado;?>>
		<input name="TxtFechaDAS<? echo $Campos; ?>" type="text" value="<? echo $FechaDasIni; ?>" size="12" maxlength="12" readonly >
		<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaDAS<? echo $Campos; ?>,TxtFechaDAS<? echo $Campos; ?>,popCal,'N');return false">
		</td>
		<td  class='BordeBajo' align="center" <? echo $Ingresado;?>><? echo $FechaTerminoDAS;?>&nbsp;</td>
		<td  class='BordeBajo' align="center" <? echo $Ingresado;?>><? echo $FechaTerminoOcupacional;?>&nbsp;</td>
	    <td  class='BordeBajo' align="center" <? echo $Ingresado;?>>
		<input name="TxtFechaPreoc<? echo $Campos; ?>" type="text" value="<? echo $Fila[fecha_exa_ocup]; ?>" size="12" maxlength="12" readonly >
		<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaPreoc<? echo $Campos; ?>,TxtFechaPreoc<? echo $Campos; ?>,popCal,'N');return false">
		</td>
		<td  class='BordeBajo' align="center" <? echo $Ingresado;?>>
		<input name="TxtFechaVigOcup<? echo $Campos; ?>" type="text" value="<? echo $FechaOcupaExpi; ?>" size="12" maxlength="12" readonly >
		<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaVigOcup<? echo $Campos; ?>,TxtFechaVigOcup<? echo $Campos; ?>,popCal,'N');return false">
		&nbsp;</td>
	</tr>
		<?
	}
}
	?>
  </tr>
</table>	 
	 </td>
<td width="0%" class="TituloTablaVerde" align="center"></td>	 
   </tr>

  <tr>
    <td colspan="3"align="center" class="TituloTablaVerde"></td>
  </tr>
</table>
<br>

</form>
</body>
</html>
