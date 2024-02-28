<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");

if(isset($RutBus))
	$TxtRut=$RutBus;

if(!isset($TxtFechaD))	
	$TxtFechaD=date('Y-m-d');
if(!isset($TxtFechaH))	
	$TxtFechaH=date('Y-m-d');
if($RecupFecha=='S')
{
	$TxtFechaD=$FechaD;
	$TxtFechaH=$FechaH;
}	
?>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opc,CodVisita)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			if(f.TxtFechaD.value!='' && f.TxtFechaH.value=='')
			{
				alert('Debe Seleccionar Fecha Hasta')
				f.TxtFechaH.focus();
				return;	
			}				
			f.action='sget_mantenedor_visitas.php?Cons=S';
			f.submit();
			break;
		case "N":
			URL="sget_mantenedor_visitas_proceso.php?Opc="+Opc;
			opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=850,height=700,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo((screen.width - 640)/2,0);
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckVisita','M'))
			{
				Datos=Recuperar(f.name,'CheckVisita');
				//alert (Datos);
				URL="sget_mantenedor_visitas_proceso.php?Opc="+Opc+"&CorrV="+Datos+"&MuestraS=S";
				opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=850,height=700,scrollbars=1';
				popup=window.open(URL,"",opciones);
				popup.focus();
				popup.moveTo((screen.width - 640)/2,0);
			}	
		break;
		case "E":
			if(SoloUnElemento(f.name,'CheckVisita','E'))
			{
				mensaje=confirm("Esta Seguro de Eliminar estos Registros?");
				if(mensaje==true)
				{
					Datos=Recuperar(f.name,'CheckVisita');
					//alert(Datos)
					f.action='sget_mantenedor_visitas_proceso01.php?Opcion=E&Valor='+Datos;
					f.submit();
				}	
			}
		break;
		case "ReObs":
			eval("Txt" + CodVisita + ".style.visibility = 'visible'");
			eval("Txt" + CodVisita + ".style.left = 100 ");
		break;
		case "ReObsCerrar":
			eval("Txt" + CodVisita + ".style.visibility = 'hidden'");
		break;
		case "R"://RECHAZA LAS VISITAS
			if(SoloUnElemento(f.name,'CheckVisita','Autoriza'))
			{
				Datos=Recuperar(f.name,'CheckVisita');
				var mensaje=confirm('Est seguro de rechazar Visita(s)?')
				if(mensaje==true)
				{
					f.RechazaVis.value=Datos;
					URL="sget_mantenedor_auto_visita_proceso.php?RechazaVis="+Datos;
					opciones='top=30,toolbar=0,resizable=0,menubar=0,status=1,width=650,height=250,scrollbars=1';
					popup=window.open(URL,"",opciones);
					popup.focus();
					popup.moveTo((screen.width - 640)/2,0);
				}
			}
		break;
		case "EX":
			URL="sget_mantenedor_visitas_excel.php?Borra=S";
			opciones='top=30,toolbar=0,resizable=1,menubar=0,status=1,width=960,height=500,scrollbars=1';
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo(screen.width - 1024);
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=1";
		break;
	}	
}
function VerMsj(Msj)
{
	if (Msj=='E')
		alert('Registro eliminado exitosamente');
	if(Msj=='ReIng')	
		alert('Visita ReIngresada para validacion');
}

</script>
<title>Mantenedor de Visitas</title>
<?
if(isset($Msj))
{
?>
<body onLoad="VerMsj('<? echo $Msj?>')">
<?
}
else
{
?>
<body>
<?
}
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmPrincipal" method="post" action="" >
<input type="hidden" name="RechazaVis" size="200" />
  <table width="1024" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\mant_visitas.png"></td>
              <td width="179" align="right"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">Servidor 
                <? 
				$IP_SERV = $HTTP_HOST;
				echo $IP_SERV;?>
              </font></font></td>
              <td width="304" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
                </font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
                <? 
				//$Fecha_Hora = date("d-m-Y h:i");
				$FechaFor=FechaHoraActual();
				echo $FechaFor." hrs";
				?>
                </font></td>
            </tr>
        </table></td>
    </tr>
  </table>
  <table width="1020"  border="0" align="center"  cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td><table width="1020" align="center"  cellspacing="0">
          <tr>
            <td height="35" colspan="4" align="left" class="FilaAbeja2"   ><img src="archivos/images/interior/t_buscadorGlobal4.png" /> </td>
            <td colspan="2" align="right" class="FilaAbeja2" >
			<a href="archivos/Guia_de_Uso_Mantenedor_de_Visitas_SGET.pdf" target="_blank"><img src="archivos/Adobe2.png"   alt="Gu�a Usuario ingreso Visitas"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar por Criterios de Bsqueda"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:Proceso('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>
			<a href="JavaScript:Proceso('M')"><img src="archivos/btn_modificar3.png" border="0" alt="Modificar" align="absmiddle"></a>
			<!--<a href="JavaScript:Proceso('R')"><img src="archivos/rechazado3.png"  alt="Rechaza Visitas" width="25" height="24"  border="0" align="absmiddle" /></a>-->
			<a href="JavaScript:Proceso('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>
			<a href="JavaScript:Proceso('EX')"><img src="archivos/Cexec.png"  alt="Procesa Excel (Visitas)"  border="0" align="absmiddle" /></a>&nbsp;
			<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a></td>
          </tr>
          <tr>
            <td width="13%" class="FilaAbeja2"> Fecha Ingreso</td>
            <td width="32%" class="FilaAbeja2">Desde
              <input name="TxtFechaD" type="text" id="TxtFechaD"   size="10" readonly="readonly" value='<? echo $TxtFechaD;?>'/>
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaD,TxtFechaD,popCal);return false" /> &nbsp;Hasta
<input name="TxtFechaH" type="text" id="TxtFechaH"   size="10" readonly="readonly" value='<? echo $TxtFechaH;?>'/>
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaH,TxtFechaH,popCal);return false" /> </td>
            <td width="13%" class="FilaAbeja2">Rut Visita</td>
            <td width="17%" class="FilaAbeja2"><input name="TxtRut" type="text" id="TxtRut"  size="16" value="<? echo $TxtRut;?>"></td>
            <td width="12%" class="FilaAbeja2">&nbsp;</td>
            <td width="13%" class="FilaAbeja2">&nbsp;</td>
          </tr>
          <tr>
            <td width="13%" class="FilaAbeja2">Apellido Paterno </td>
            <td width="32%" class="FilaAbeja2"><input name="TxtPat" type="text" id="TxtPat"  size="30" value="<? echo $TxtPat;?>"></td>
            <td width="13%" class="FilaAbeja2">Apellido Materno </td>
            <td width="17%" class="FilaAbeja2"><input name="TxtMat" type="text" id="TxtMat" value="<? echo $TxtMat;?>"></td>
            <td width="12%" class="FilaAbeja2">&nbsp;</td>
            <td width="13%" class="FilaAbeja2">&nbsp;</td>
          </tr>
          <tr>
            <td class="FilaAbeja2">Empresa</td>
            <td class="FilaAbeja2"><input name="TxtEMP" type="text" id="TxtEMP"  size="50" value="<? echo $TxtEMP;?>"></td>
            <td class="FilaAbeja2">&nbsp;</td>
            <td colspan="3" class="FilaAbeja2">&nbsp;</td>
            </tr>
          <tr>
            <td class="FilaAbeja2">Estado Visitas </td>
            <td class="FilaAbeja2"><SELECT name="Estado">
              <?
				    switch($Estado)
					{
						case "1":
								?>
              <option value="T">Todos</option>
              <option value="1" SELECTed="SELECTed">En Proceso</option>
              <option value="2">Terminadas</option>
              <?							
						break;
						case "2":
								?>
              <option value="T">Todos</option>
              <option value="1">En Proceso</option>
              <option value="2" SELECTed="SELECTed">Terminadas</option>
              <?							
						break;
						default:
								?>
              <option value="T" SELECTed="SELECTed">Todos</option>
              <option value="1">En Proceso</option>
              <option value="2">Terminadas</option>
              <?							
						break;
					}
				  ?>
            </SELECT></td>
            <td colspan="4" class="FilaAbeja2"><font face="Arial, Helvetica, sans-serif" color="#FF0000"><!--* Visitas con icono <img src="archivos/rechazado3.png"  alt="Rechaza Visitas" width="25" height="24"  border="0" align="absmiddle" /> Rechazadas.--></font></td>
            </tr>
      </table></td>
      <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>
  <br/>
  <table width="1020"   border="0" align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
    <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
    <tr>
      <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td><table width="1020" border="1" align="center" cellpadding="2" cellspacing="0">
            <tr>
              <td width="3%" align="center" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckVisita','ChkTodos');" /></td>
              <td width="7%" align="center" class="TituloTablaVerde">Fecha&nbsp;Ingr.</td>
              <td width="7%" align="center" class="TituloTablaVerde">Rut&nbsp; o N&nbsp;Pasaporte</td>
			  <td width="8%" align="center" class="TituloTablaVerde">Nombre</td>
              <td width="9%" align="center" class="TituloTablaVerde">Ctto / OC</td>
			  <td width="9%" align="center" class="TituloTablaVerde">Empresa o Instituci&oacute;n </td>
              <td width="9%" align="center" class="TituloTablaVerde">&Aacute;rea a Visitar</td>
              <td width="8%" align="center" class="TituloTablaVerde">Visita Solicitada Por</td>
              <td width="7%" align="center" class="TituloTablaVerde">Fecha&nbsp;DAS. (Inicio)</td>
              <td width="7%" align="center" class="TituloTablaVerde">Fecha&nbsp;DAS. (Venc.)</td>
              <td width="7%" align="center" class="TituloTablaVerde">Hora Entrada </td>
              <td width="7%" align="center" class="TituloTablaVerde">Hora Salida  </td>
              <td width="14%" align="center" class="TituloTablaVerde">Motivo </td>
              <td width="14%" align="center" class="TituloTablaVerde">Observacin </td>
            </tr>
            <?
			if($Cons=='S')
			{
				//OBTENEMOSW LOS DATOS DE SUMA DE AOS PARA LA FECHA DAS Y FECHA PREOCUPACIONAL.
				$ConsultaC="SELECT valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
				$RC=mysql_query($ConsultaC);
				$FC=mysql_fetch_array($RC);
				$AnoDAS=$FC["valor_subclase1"];
				//$AnoPreo=$FC["valor_subclase2"];
				//$Ano2Ocu=$FC["valor_subclase3"];

				$Consulta="SELECT * from sget_visitas where corr_visita<>''";
				if($Cod!='')
					$Consulta.=" and corr_visita='".$Cod."'";	
				if($CookieRut!='')
					$Consulta.=" and rut_registro_solicita='".$CookieRut."'";	
				if($TxtRut!='')
					$Consulta.=" and rut='".$TxtRut."'";	
				if($TxtEMP!='')
					$Consulta.=" and empresa like'%".$TxtEMP."%'";	
				if($TxtPat!='')
					$Consulta.=" and apellido_paterno like '%".$TxtPat."%'";	
				if($TxtMat!='')
					$Consulta.=" and apellido_materno like '%".$TxtMat."%'";
				if($TxtFechaD!='' && $TxtFechaH!='')		
					$Consulta.=" and fecha_ingreso between '".$TxtFechaD."' and '".$TxtFechaH."'";
				if($Estado!='T')
				{	
					if($Estado=='1')//En Proceso.
						$Consulta.=" and (hora_entrada='0:00:00' or (hora_entrada<>'0:00:00' and hora_salida='0:00:00'))";	
					if($Estado=='2')//Terminada.
						$Consulta.=" and hora_entrada<>'0:00:00' and hora_salida<>'0:00:00'";	
				}
				$Consulta.=" order by fecha_ingreso desc, apellido_paterno,apellido_materno,nombres";	
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				echo "<input name='CheckVisita' type='hidden'  value=''>";
				$Cont=1;
				while ($Fila=mysql_fetch_array($Resp))
				{
					$Color='';
					if($Fila[fecha_das]=='0000-00-00')
					{
						 //$FechaDAS="<span class='InputRojo'>Sin DAS</span>";
						 //$FechaTerminoDAS="<span class='InputRojo'>Sin DAS</span>";
						 $FechaDAS="";
						 $FechaTerminoDAS="";
					}
					else
					{
						$FechaDAS=$Fila[fecha_das];
						$FechaDASAux=explode('-',$Fila[fecha_das]);
						$FechaDASAux[0]=$FechaDASAux[0]+$AnoDAS;
						$FechaTerminoDAS=$FechaDASAux[0]."-".$FechaDASAux[1]."-".$FechaDASAux[2];
						
						$FechaPreo=explode('-',$Fila[fecha_vigencia_exa_preo]);
						$FechaPreo[0]=$FechaPreo[0]+$Ano2Ocu;
						$FechaPreoExpi=$FechaPreo[0]."-".$FechaPreo[1]."-".$FechaPreo[2];
						if($FechaTerminoDAS< date('Y-m-d') || $FechaPreoExpi< date('Y-m-d'))
							$Checked='checked=checked';	
						if($FechaTerminoDAS< date('Y-m-d'))	
							$FechaTerminoDAS="<span class='InputRojo'>".$FechaTerminoDAS."</span>";
						else
							$FechaTerminoDAS=$FechaTerminoDAS;	
					}
					if($Fila["hora_entrada"]!='00:00:00'&&$Fila["hora_salida"]!='00:00:00')
						$ColorEstado='bgcolor="#C1FF84"';
					else
						$ColorEstado='bgcolor="#FFFFFF"';	
							
					/*if($Fila["hora_entrada"]!='00:00:00'&&$Fila["hora_entrada"]!='00:00:00')
						$ColorEstado='bgcolor="#C1FF84"';
					else
					{
						if($Fila["estado"]=='R')
							$ColorEstado='class="Rechazado"';
						else
							$ColorEstado='bgcolor="#FFFFFF"';	
					}*/
				?>				
						<tr>
						  <td width="6%" align="center">
						  <?
						  if($Fila["hora_entrada"]=='00:00:00')
						  	echo "<input name='CheckVisita' class='SinBorde' type='checkbox'  value='".$Fila["corr_visita"]."'>";
						  /*if($Fila["estado"]=='R')
						  {
						  	echo '<a href=JavaScript:Proceso("ReObs","'.$Fila["corr_visita"].'") class="SinBorde"><img src="archivos/rechazado2.png" border="0" alt="" width="20" height="20" align="absmiddle"></a>';	
							echo "<div id='Txt".$Fila["corr_visita"]."' ";
							echo " style=\"FILTER: alpha(opacity=95);  background-color:#fff4cf; VISIBILITY: hidden; WIDTH: 400px; POSITION: absolute; moz-opacity: .75; opacity: .75; border:solid 1px Black\">";
							echo "<table border=1 cellpadding=0 cellspacing=0>";
							echo "<tr>";
							echo "<td class='FilaAbeja2'>Motivo de Rechazo de Autorizaci&oacute;n</td>";
							echo "<td class='FilaAbeja2' align='center'><a href=JavaScript:Proceso('ReObsCerrar','".$Fila["corr_visita"]."') class='SinBorde'>Cerrar</a></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td colspan='2'><textarea name='Motivo' cols='80' rows='5' readonly='readonly'>".$Fila["observacion_autoriza"]."</textarea></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td colspan='2'>&nbsp;</td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td class='FilaAbeja2' colspan='2'>Visita rechazada, Modifique para volver a solicitar autorizaci&oacute;n</td>";
							echo "</tr>";
							echo "</table>";
							echo "</div>";						  
						  }*/
						  /*if($Fila["estado"]=='V')
						  	 echo '<img src="archivos/btn_aceptar2.png" border="0" alt="Visita Validada." width="19" height="19" align="absmiddle">';	*/
						  ?>
						  &nbsp;</td>
						  <td width="7%"  <? echo $ColorEstado;?>align="center"><? echo $Fila["fecha_ingreso"];?></td>
						  <td width="7%"  <? echo $ColorEstado;?>align="left"><? echo $Fila["rut"];?></td>
						  <td width="8%"  <? echo $ColorEstado;?>align="left"><? echo ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"]));?></td>
						  <td width="9%"  <? echo $ColorEstado;?>align="left"><? echo $Fila["contrato_orden"];?>&nbsp;</td>
						  <td width="9%"  <? echo $ColorEstado;?>align="left"><? echo ucwords(strtolower($Fila["empresa"]));?></td>
						  <td width="9%"  <? echo $ColorEstado;?>align="left"><? echo ucwords(strtolower($Fila["area"]));?></td>
						  <td width="8%"  <? echo $ColorEstado;?>align="left"><? echo ucwords(strtolower($Fila["solicitada_por"]));?>&nbsp;</td>
						  <td width="7%" <? echo $ColorEstado;?> align="center"><? echo $FechaDAS;?>&nbsp;</td>
						  <td width="7%" <? echo $ColorEstado;?> align="center"><? echo $FechaTerminoDAS;?>&nbsp;</td>
						  <td width="7%" <? echo $ColorEstado;?> align="center"><? echo $Fila["hora_entrada"];?>&nbsp;</td>
						  <td width="7%" <? echo $ColorEstado;?> align="center"><? echo $Fila["hora_salida"];?>&nbsp;</td>
						  <td width="14%"  <? echo $ColorEstado;?> align="center"><textarea name="Motivo" cols="30" readonly="readonly"><? echo $Fila["motivo"];?></textarea></td>
						  <td width="14%"  <? echo $ColorEstado;?> align="center"><textarea name="Obs" cols="30" readonly="readonly"><? echo $Fila["observacion"];?></textarea></td>
						</tr>
					<?		$Cont++;
				}
			
			}
			?>
        </table></td>
      <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
    </tr>
    <tr>
      <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
      <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
    </tr>
  </table>  <p>
  </td>
    </tr>
  </table>
</form>