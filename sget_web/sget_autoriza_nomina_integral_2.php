<?
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$Fecha_Sistema= date("Y-m-d");
	
?>

<title>Autorizaci�n de Gestion de Riesgos</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opt)
{
	var f=document.FrmAut;
	var Mi="";
	switch (Opt)
	{
		case "EHRuta"://envia correo de las personas que son eliminadas de la hoja de ruta.
			Datos=Recuperar(f.name,'ChkDatos','E');
			f.RutsERuta.value=Datos;
			if(Datos=='')
			{
				alert('Debe Seleccionar Personas para Anularlas en Hoja de Ruta')
				return;
			}
			else
			{
				Cuenta=0;
				for(i=0;i<f.elements.length;i++)
				{
					if(f.elements[i].name=='ChkDatos' && f.elements[i].checked==true)
						Cuenta++;
				}
				var mensaje=confirm('�Est� Seguro de Eliminar '+Cuenta+' Persona(s) Seleccionada(s) en Hoja de Ruta?')
				if(mensaje==true)
				{
					//f.action='sget_autoriza_nomina_integral01.php?Proceso=EHRuta';
					//f.action=';
					URL="sget_autoriza_nomina_integral_2_elimina.php?Proceso=EHRuta&PersonasE="+Datos+"&NumHoja="+f.NumHoja.value;
					opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=900,height=350,scrollbars=1';
					popup=window.open(URL,"",opciones);
					popup.focus();
					//f.submit();
				}	
			}
		break;
		case "G":
		//Datos=Recuperar(f.name,'ChkDatos','AN');
		//DatosFechas=Recuperar7(f.name,'ChkDatos');
		//alert(DatosFechas);
		var DRECU='';
		for(i=0;i<f.elements.length;i++)
		{
			if(f.TxtFechaMDAS.value!='' && f.TxtFechaMPreo.value!='')
			{
				if(f.elements[i].name=='ChkDatos' && f.elements[i].checked==true)
				{
					if(f.TxtFechaMDAS.value!='' || f.TxtFechaMPreo.value!='')
						DRECU= DRECU+f.elements[i].value+"~A~"+f.TxtFechaMDAS.value+"~"+f.TxtFechaMPreo.value+'//';
					else
					{
						alert('Debe Seleccionar Fechas para Grabar')
						return;
					}	
				}	
			}	
			if(f.TxtFechaMDAS.value!='' && f.TxtFechaMPreo.value=='')
			{
				if(f.elements[i].name=='ChkDatos' && f.elements[i].checked==true)
				{
					if(f.TxtFechaMDAS.value!='' || f.elements[i+2].value!='')
						DRECU= DRECU+f.elements[i].value+"~A~"+f.TxtFechaMDAS.value+"~"+f.elements[i+2].value+'//';
					else
					{
						alert('Debe Seleccionar Fechas para Grabar')
						return;
					}	
				}
			}	
			if(f.TxtFechaMDAS.value=='' && f.TxtFechaMPreo.value!='')
			{
				if(f.elements[i].name=='ChkDatos' && f.elements[i].checked==true)
				{
					if(f.elements[i+1].value!='' || f.TxtFechaMPreo.value!='')
						DRECU= DRECU+f.elements[i].value+"~A~"+f.elements[i+1].value+"~"+f.TxtFechaMPreo.value+'//';
					else
					{
						alert('Debe Seleccionar Fechas para Grabar')
						return;
					}	
				}
			}	
			if(f.TxtFechaMDAS.value=='' && f.TxtFechaMPreo.value=='')
			{
				if(f.elements[i].name=='ChkDatos' && f.elements[i].checked==true)
				{
					if(f.elements[i+1].value!='' || f.elements[i+2].value!='')
						DRECU= DRECU+f.elements[i].value+"~A~"+f.elements[i+1].value+"~"+f.elements[i+2].value+'//';
					else
					{
						alert('Debe Seleccionar Fechas para Grabar')
						return;
					}
				}
			}
		}		
		if(DRECU=='')
		{
			alert('Debe Seleccionar Personal para Grabar')
			return;
		}
		else
		{
			//alert(DRECU)
			DRECU=DRECU.substr(0,DRECU.length-2);
			f.Valores.value=DRECU;
			f.Valores2.value=DRECU;
			//alert(f.Valores.value);
			//alert(f.Valores2.value);
			//f.action='sget_autoriza_nomina_integral01.php?Proceso=G&Valores='+Datos+'&Valores2='+DatosFechas;
			f.action='sget_autoriza_nomina_integral01.php?Proceso=G';
			f.submit();
		}
		break;
		case "S":
			window.close();
			break;
		case "I":
		window.print()
		
		break;	
	}
}
function Obs(H,HR,Mos)
{
	var f=document.FrmAut;
	URL="sget_detalle_obs_hito.php?H="+H+"&NumHoja="+HR+"&CodSistema="+f.CodSistema.value+"&CodPantalla="+f.CodPantalla.value+"&Mos="+Mos;
	opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=700,height=350,scrollbars=1';
	popup=window.open(URL,"",opciones);
	popup.focus();
}
function Auto(H,HR) 
{
	var f=document.FrmAut;
	f.action='sget_autorizacion_adm_ctto01.php?H='+H+'&NumHoja='+HR+'&Proceso=A&NoPant=S';
	f.submit();
}
</script>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
.Estilo2 {color: #000000}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs_valida.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmAut" action="" method="post">
<input name="CodSistema" type="hidden" value="<? echo $CodSistema; ?>">
<input name="CodPantalla" type="hidden" value="<? echo $CodPantalla; ?>">
<input name="CodHito" type="hidden" value="<? echo $H; ?>">
<input name="NumHoja" type="hidden" value="<? echo $NumHoja; ?>">
<input name="CmbEmpresa" type="hidden" value="<? echo $CmbEmpresa; ?>">
<input name="CmbContrato" type="hidden" value="<? echo $CmbContrato; ?>">
<input name="TxtHoja" type="hidden" value="<? echo $TxtHoja; ?>">
<input name="CmbAno" type="hidden" value="<? echo $CmbAno; ?>">
<input name="CmbEstado" type="hidden" value="<? echo $CmbEstado; ?>">
<input name="Valores" type="hidden" size="200"value="<? echo $Valores; ?>">
<input name="Valores2" type="hidden" size="200" value="<? echo $Valores2; ?>">
<textarea name="RutsERuta" style="visibility:hidden;"></textarea>
<table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td width="15" height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="933" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td width="17" height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="38%" align="left" class="Estilo5"><img src="archivos/sub_tit_charla_oblig_epp.png" /></td>
    <td width="38%" align="center" class="Estilo5"><font size="2" class="LinkPestana">N&deg; Hoja de Ruta:&nbsp;<? echo $NumHoja;?></font></td>
    <td width="24%" align="right">
	<? 
	$IcoObs2=CantObs($NumHoja,$H);
	$Consulta = "SELECT descrip_hito from sget_hitos ";
	$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'  ";
	$RespHD = mysql_query($Consulta);$Descrip_hito='';
	if($FilaHD=mysql_fetch_array($RespHD))
	{
		$Descrip_hito=$FilaHD[descrip_hito];
	}
	
	$Entro='N';
	$Consulta="SELECT * ";
	$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas  ";
	$Consulta.=" where num_hoja_ruta ='".$NumHoja."' and cod_hito='".$H."' and aprob_rechazo='A' ";
	$RespDet2=mysql_query($Consulta);
	if($FilaDet2=mysql_fetch_array($RespDet2))
		$Entro='S';
	if($Entro=='S')
	{	
		$Consulta = "SELECT * from sget_hitos ";
		$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'  ";
		//echo $Consulta;
		$RespHD = mysql_query($Consulta);
		while ($FilaHD=mysql_fetch_array($RespHD))
		{
			?>
			<a href="JavaScript:Obs('<? echo $H; ?>','<? echo $NumHoja; ?>')"><img src="archivos/<? echo $IcoObs2;  ?>"  border="0"  alt="Ingreso Observaci�n " align=	"absmiddle" /></a> 
			<?
			$Consulta2="SELECT * from sget_hoja_ruta_nomina_hitos_personas";
			$Consulta2.=" where num_hoja_ruta ='".$NumHoja."' and cod_hito='".$FilaHD[cod_hito]."' and aprob_rechazo='R'";								
			$RespDet3=mysql_query($Consulta2);
			if($FilaDet3=mysql_fetch_array($RespDet3))
			{
				?>
				<!--<a href="JavaScript:Auto('<? //echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')">--><img src="archivos/proceso.png" border="0" alt="No se Puede Aprobar Hoja Ruta, Faltan Registros por Completar" 	align="absmiddle"><!--</a>-->
				<?
			}
			else
			{	
				$Consulta2="SELECT * from sget_hoja_ruta_nomina_hitos_personas t1 inner join sget_personal t2 on t1.rut_personal=t2.rut";
				$Consulta2.=" where num_hoja_ruta ='".$NumHoja."' and  (t2.fecha_das is null or t2.fecha_das='0000-00-00' or t2.fecha_vigencia_exa_preo is null or t2.fecha_vigencia_exa_preo='0000-00-00')";//and cod_hito='".$FilaHD[cod_hito]."'  								
				//echo $Consulta2."<br>";
				$RespDet3=mysql_query($Consulta2);
				if($FilaDet3=mysql_fetch_array($RespDet3))
				{
					?>
					<!--<a href="JavaScript:Auto('<? //echo $FilaHD[cod_hito]; ?>','<? echo $Fila["num_hoja_ruta"]; ?>')">--><img src="archivos/proceso.png" border="0" alt="No se Puede Aprobar Hoja Ruta, Faltan Registros por Completar" 	align="absmiddle"><!--</a>-->
					<?
				}
				else
				{
					?>
					<a href="JavaScript:Auto('<? echo $H; ?>','<? echo $NumHoja; ?>')"><img src="archivos/proceso.png" border="0" alt="Aprobar Hoja Ruta" 	align="absmiddle" /></a>
					<?
				}
			}
			?>
<!--			<a href="JavaScript:Obs('<? //echo $H; ?>','<? //echo $NumHoja; ?>')"><img src="archivos/<? //echo $IcoObs2;  ?>"  border="0"  alt="Ingreso Observaci�n <? //echo $Descrip_hito;  ?>" align=	"absmiddle" /></a> 
			<a href="JavaScript:Auto('<? //echo $H; ?>','<? //echo $NumHoja; ?>')"><img src="archivos/proceso.png" border="0" alt="<? //echo $Descrip_hito;  ?>" 	align="absmiddle" /></a>
-->			<?
		}
	}
	?>
  &nbsp;<a href="JavaScript:Proceso('EHRuta')"><img src="archivos/sin_user_nomina.png"  border="0"  alt="Elimina Personas Rechazadas Hoja de Ruta" align="absmiddle"></a>
  &nbsp;<a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png"  border="0"  alt=" Guardar " align="absmiddle"></a>
  <a href="JavaScript:Proceso('I')"><img src="archivos/Impresora.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>

  <a href="JavaScript:Proceso('S')"><img src="archivos/close.png" alt="Cerrar" border="0" align="absmiddle" ></a></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td colspan="3"align="center" class="TituloTablaVerde"></td>
  </tr>
  <tr>
    <td width="1%" align="center" class="TituloTablaVerde"></td>
    <td align="center"><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
      <tr>
        <td width="9%" align='center' class="TituloTablaNaranja" >Seleccionar Todos<br>
          <input class='SinBorde' type="checkbox" name="ChkTodos" value="" onclick="CheckearTodo(this.form,'ChkDatos','ChkTodos');" />&nbsp;&nbsp;</td>
		<td width="20%" align='center' class="TituloTablaNaranja" >Nombre</td>
        <td width="24%" align='center' class="TituloTablaNaranja" >Cargo</td>
      <?
		  	$Consulta = "SELECT * from sget_hitos ";
			$Consulta.=" where cod_sistema='".$CodSistema."' and cod_pantalla='".$CodPantalla."'  and personal='S' ";
			$RespH = mysql_query($Consulta);
			$LargoArreglo = 0;
			while ($FilaH=mysql_fetch_array($RespH))
			{
				//echo $FilaH[abrev_hito]; 
				$ArregloLeyes[$LargoArreglo][0] = $FilaH[cod_hito];
				$ArregloLeyes[$LargoArreglo][1] = $FilaH[abrev_hito];
				$LargoArreglo++;
				$Consulta="SELECT distinct(fecha) ";
				$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas  ";
				$Consulta.=" where num_hoja_ruta ='".$NumHoja."' and cod_hito='".$FilaH[cod_hito]."' ";
				$Resp1=mysql_query($Consulta);
				$Fila1=mysql_fetch_array($Resp1);
					$TxtFecha=$Fila1["fecha"];
			}
			?>
        <td width="13%" align='center' class="TituloTablaNaranja" >Fecha DAS (Ini.) <br>
        &nbsp;<input name="TxtFechaMDAS" type="text" readonly="readonly"   size="12" value="<? echo $TxtFechaMDAS; ?>" /> <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaMDAS,TxtFechaMDAS,popCal,'N');return false" />&nbsp;</td>
		<td width="10%" align='center' class="TituloTablaNaranja" >Fecha DAS. (Venc.)</td>
		<td width="13%" align='center' class="TituloTablaNaranja" >Inicio  Exa. Preo<br>
        &nbsp;<input name="TxtFechaMPreo" type="text" readonly="readonly"   size="12" value="<? echo $TxtFechaMPreo; ?>" /> <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaMPreo,TxtFechaMPreo,popCal,'N');return false" />&nbsp;</td>
		<td width="11%" align='center' class="TituloTablaNaranja" >Venc.  Exa. Preo</td>
      </tr>
      <?
$Consulta="SELECT t2.nombres,t2.ape_paterno,t2.ape_materno,t3.descrip_cargo,t2.rut,t1.num_hoja_ruta,t2.fecha_termino_curso,t2.fecha_das,t2.fecha_vigencia_exa_preo ";
$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas t1 inner join sget_personal t2 on t1.rut_personal=t2.rut ";
$Consulta.=" left join sget_cargos t3 on t3.cod_cargo=t2.cargo";
$Consulta.=" where t1.num_hoja_ruta ='".$NumHoja."' and cod_hito='2' and aprob_rechazo='A' order by t2.ape_paterno";
echo "<input name='ChkDatos' type='hidden'  value=''>";
echo "<input name='Elim' type='hidden'  value=''>";
$RespDet=mysql_query($Consulta);
$Cont=0;
//echo $Consulta;
while($FilaDet=mysql_fetch_array($RespDet))
{
		  $Cont++;
		  $Campos=$Cont;
		  $FechaT=$FilaDet[fecha_termino_curso];
		  $FechaDas=$FilaDet[fecha_das];
		  $FechaExa=$FilaDet[fecha_vigencia_exa_preo];
	  	  $FechaTerminoOcupacional='';
		  if($FechaExa!='' && $FechaExa!='0000-00-00')
		  { 
			  $Con="SELECT valor_subclase2 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
			  $RAno=mysql_query($Con);
			  $FAno=mysql_fetch_assoc($RAno);
			  $PreocupaAno=$FAno["valor_subclase2"];
		  
			  $FechaTerminoOcupacional=explode('-',$FilaDet[fecha_vigencia_exa_preo]);
			  //$FechaTerminoOcupacional=explode('-',$FilaDet[fecha_vigencia_exa_preo]);
			  $AnoPreo=$FechaTerminoOcupacional[0]+$PreocupaAno;
			  $FechaTerminoOcupacional=$AnoPreo."-".$FechaTerminoOcupacional[1]."-".$FechaTerminoOcupacional[2];
		  }	
			if($FechaDas!='0000-00-00')
				$FechaDas=$FechaDas;
			else
			{
				$FechaDas='';
				$ConVisita="SELECT fecha_das from sget_visitas where rut='".$FilaDet["rut"]."'";
				$RVisita=mysql_query($ConVisita);
				if($FVis=mysql_fetch_assoc($RVisita))
					$FechaDas=$FVis[fecha_das];
			}	
		  		  
		  if(is_null($FechaT) || $FechaT =='' || $FechaT <= $Fecha_Sistema || $FechaTerminoOcupacional <= $Fecha_Sistema)
		  {
		  	?>
	      <tr bgcolor="#FFFF66">
        <?
		  }
		  else
		  {
		  	?>
      </tr>
      <tr b="b">
        <?
		  }
		  ?>
		<td align="center">
		<?
		for ($i = 0; $i < $LargoArreglo; $i++)
		{
			$Consulta="SELECT * ";
			$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas  ";
			$Consulta.=" where num_hoja_ruta ='".$FilaDet[num_hoja_ruta]."' and cod_hito='".$ArregloLeyes[$i][0]."' and aprob_rechazo='A' and rut_personal='".$FilaDet["rut"]."' ";
			$RespDet2=mysql_query($Consulta);
			if($FilaDet2=mysql_fetch_array($RespDet2))
			{
				if($FilaDet2[aprob_rechazo] =='A')
				{
					?>
					<input class='SinBorde' type="checkbox" name="ChkDatos" value="<? echo $FilaDet[num_hoja_ruta].'~'.$FilaDet["rut"].'~'.$ArregloLeyes[$i][0]; ?>" />
					<?
				}
				else
				{
					?>
					<input class='SinBorde' type="checkbox" name="ChkDatos" value="<? echo $FilaDet[num_hoja_ruta].'~'.$FilaDet["rut"].'~'.$ArregloLeyes[$i][0]; ?>">
					<?
				}
			}
			else
			{
				?>
				<input class='SinBorde' type="checkbox" name="ChkDatos" value="<? echo $FilaDet[num_hoja_ruta].'~'.$FilaDet["rut"].'~'.$ArregloLeyes[$i][0]; ?>">
				<?
			}
		}
		echo $Cont;
		/*$Consulta="SELECT * ";
		$Consulta.=" from sget_hoja_ruta_nomina_hitos_personas  ";
		$Consulta.=" where num_hoja_ruta ='".$FilaDet[num_hoja_ruta]."' and cod_hito='4' and rut_personal='".$FilaDet["rut"]."' ";
		//echo $Consulta;
		$RespDet2=mysql_query($Consulta);
		if($FilaDet2=mysql_fetch_array($RespDet2))
		{
			if($FilaDet2[aprob_rechazo] !='A')
			{*/
			?>
				<!--<input type="checkbox" name="Elim" value="<? //echo $FilaDet["rut"];?>" class="SinBorde"/>-->
			<?
			/*}
			else
			{
				echo "&nbsp;";
			}
	
		}	*/
		?>		</td>  
        <td align='left' class='BordeBajo'><? echo $FilaDet["rut"]." - ";?><? echo FormatearNombre($FilaDet[ape_paterno]).' '.FormatearNombre($FilaDet[ape_materno]).' '.FormatearNombre($FilaDet["nombres"]);   ?> &nbsp;</td>
        <td align='left' class="BordeBajo" ><? echo $FilaDet[descrip_cargo]; ?>&nbsp;</td>
        <?
		if($FechaExa=='0000-00-00')
			$FechaExa='';
		if($FechaT=='0000-00-00')
			$FechaT='';	
		?>
        <td align='center' class="BordeBajo" ><input name="TxtFechaDas<? echo $Campos; ?>" type="text" value="<? echo trim($FechaDas) ?>" size="12" maxlength="12" readonly="readonly" />
          <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaDas<? echo $Campos; ?>,TxtFechaDas<? echo $Campos; ?>,popCal,'N');return false" /> </td>
        <td align='center' class="BordeBajo" ><? echo $FechaT ?>&nbsp;</td>
        <td align='center' class="BordeBajo" ><input name="TxtFechaExa<? echo $Campos; ?>" type="text" value="<? echo trim($FechaExa) ?>" size="12" maxlength="12" readonly="readonly" />
          <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onclick="popFrame.fPopCalendar(TxtFechaExa<? echo $Campos; ?>,TxtFechaExa<? echo $Campos; ?>,popCal,'N');return false" /> </td>
        <td align='center' class="BordeBajo" ><? echo $FechaTerminoOcupacional; ?>&nbsp;</td>
      </tr>
      <?
}
?>
    </table></td>
    <td width="0%" align="center" class="TituloTablaVerde"></td>
  </tr>
  <tr>
    <td colspan="3"align="center" class="TituloTablaVerde"></td>
  </tr>
  
   <tr>
    <td colspan="3"align="center" class="InputRojo"><br>      (*) En Amarillo Personal Con  Charla Das o Preocupacional Vencida</td>
  </tr>
</table>
<br></td>
   <td  background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td  height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td  height="15"><img src="archivos/images/interior/esq4.gif" ></td>
  </tr>
  </table>	
</form>
