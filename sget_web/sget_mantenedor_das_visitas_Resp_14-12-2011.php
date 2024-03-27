<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");

if(!isset($TxtFecha))
	$TxtFecha=date('Y-m-d');
if(!isset($TxtFechaH))
	$TxtFechaH=date('Y-m-d');

if(isset($RutBus))
	$TxtRut=$RutBus;
?>
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="javascript">
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
			f.action="sget_mantenedor_das_visitas.php?Cons=S";
			f.submit();
		break;
		case "M":
			if(SoloUnElemento(f.name,'CheckVisita','E'))
			{
				Datos=Recuperar(f.name,'CheckVisita');
				//alert (Datos);
				if(f.TxtFechaD.value=='')
				{
					alert('Debe seleccionar Fecha DAS');
					f.TxtFechaD.focus();
					return;
				}
				f.action="sget_mantenedor_visitas_proceso01.php?Opcion=ModDAS&CorrV="+Datos;
				f.submit();
			}	
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30";
		break;
	}	
}
function VerMsj(Msj)
{
	if (Msj=='DASact')
		alert('Fecha DAS Actualizada con �xito');
}

</script>
<title>Mantenedor Charla Das Visitas</title>
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
 <? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\mant_charla_das.png"></td>
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
  <table width="950"  border="0" align="center"  cellpadding="0"  cellspacing="0" bgcolor="#FFFBFB">
    <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
    <tr>
      <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
      <td><table width="940" align="center"  cellspacing="0">
          <tr>
            <td height="35" colspan="4" align="left" class="FilaAbeja2"   ><img src="archivos/images/interior/t_buscadorGlobal4.png" /> </td>
            <td colspan="2" align="right" class="FilaAbeja2" >
			<a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>&nbsp;&nbsp;<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png"  border="0"  alt=" Volver " align="absmiddle"></a>            </td>
          </tr>
          <tr>
            <td width="14%" class="FilaAbeja2">Fecha de Busqueda</td>
            <td width="31%" class="FilaAbeja2">Desde&nbsp;
              <input name="TxtFecha" type="text" readonly="readonly"   size="10"  value="<? echo $TxtFecha; ?>">
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false" /> &nbsp;&nbsp;Hasta&nbsp;
<input name="TxtFechaH" type="text" readonly="readonly"   size="10"  value="<? echo $TxtFechaH; ?>">
&nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaH,TxtFechaH,popCal);return false" />&nbsp;</td>
            <td width="13%" class="FilaAbeja2">Rut Visita</td>
            <td width="17%" class="FilaAbeja2"><input name="TxtRut" type="text" id="TxtRut"  size="12" value='<? echo $TxtRut?>'/></td>
            <td width="12%" class="FilaAbeja2">&nbsp;</td>
            <td width="13%" class="FilaAbeja2">&nbsp;</td>
          </tr>
          <tr>
            <td width="14%" class="FilaAbeja2">Apellido Paterno </td>
            <td width="31%" class="FilaAbeja2"><input name="TxtPat" type="text" id="TxtPat" value='<? echo $TxtPat?>' size="30" /></td>
            <td width="13%" class="FilaAbeja2">Apellido Materno </td>
            <td width="17%" class="FilaAbeja2"><input name="TxtMat" type="text" id="TxtMat" value='<? echo $TxtMat?>'/></td>
            <td width="12%" class="FilaAbeja2">&nbsp;</td>
            <td width="13%" class="FilaAbeja2">&nbsp;</td>
          </tr>
          <tr>
            <td class="FilaAbeja2">Empresa o Instituci&oacute;n </td>
            <td class="FilaAbeja2"><input name="TxtEMP" type="text" id="TxtEMP"  size="50" value='<? echo $TxtEMP?>'/></td>
            <td class="FilaAbeja2">Contrato/OC</td>
            <td colspan="3" class="FilaAbeja2"><input name="TxtCttoOC" type="text" size="30" maxlength="25" value="<? echo $TxtCttoOC;?>"></td>
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
  <table width="955"   border="0" align="center" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
    <tr>
      <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
      <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
      <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    </tr>
    <tr>
      <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
      <td><table width="940" border="1" align="center" cellpadding="2" cellspacing="0">
            <tr>
              <td colspan="2" align="center" class="TituloTablaVerde">Fecha DAS (Inicio):</td>
              <td colspan="6" align="left" class="FilaAbeja2"><input name="TxtFechaD" type="text" id="TxtFechaD"   size="10" readonly="readonly" /> <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaD,TxtFechaD,popCal);return false" />&nbsp;&nbsp;
			  <a href="JavaScript:Proceso('M')"><img src="archivos/btn_guardar.png" border="0" alt="Modificar Fecha DAS" align="absmiddle"></a></td>
			</tr>
            <tr>
              <td width="3%" align="center" class="TituloTablaVerde"><input class='SinBorde' type="checkbox" name="ChkTodos" value="" onClick="CheckearTodo(this.form,'CheckVisita','ChkTodos');" /></td>
              <td width="10%" align="center" class="TituloTablaVerde">Ult Fecha&nbsp;Ingr.</td>
              <td width="7%" align="center" class="TituloTablaVerde">Rut</td>
			  <td width="12%" align="center" class="TituloTablaVerde">Nombre</td>
              <td width="21%" align="center" class="TituloTablaVerde">Empresa o Instituci&oacute;n </td>
			  <td width="21%" align="center" class="TituloTablaVerde">Contrato/OC</td>
              <td width="11%" align="center" class="TituloTablaVerde">Fecha&nbsp;DAS. (Inicio)</td>
              <td width="15%" align="center" class="TituloTablaVerde">Fecha&nbsp;DAS. (Venc.)</td>
              </tr>
            <?
			if($Cons=='S')
			{
				//OBTENEMOSW LOS DATOS DE SUMA DE A�OS PARA LA FECHA DAS Y FECHA PREOCUPACIONAL.
				$ConsultaC="SELECT valor_subclase1,valor_subclase2,valor_subclase3 from proyecto_modernizacion.sub_clase where cod_clase='30024'";
				$RC=mysql_query($ConsultaC);
				$FC=mysql_fetch_array($RC);
				$AnoDAS=$FC["valor_subclase1"];

				$Consulta="SELECT * from sget_visitas where corr_visita<>'' and estado='V'";
				if($TxtFecha!='')
					$Consulta.=" and fecha_ingreso between '".$TxtFecha."' and '".$TxtFechaH."'";	
				if($TxtRut!='')
					$Consulta.=" and rut='".$TxtRut."'";	
				if($TxtEMP!='')
					$Consulta.=" and empresa like'%".$TxtEMP."%'";
				if($TxtCttoOC!='')
					$Consulta.=" and contrato_orden like '%".$TxtCttoOC."%'";		
				if($TxtPat!='')
					$Consulta.=" and apellido_paterno like '%".$TxtPat."%'";	
				if($TxtMat!='')
					$Consulta.=" and apellido_materno like '%".$TxtMat."%'";
				$Consulta.=" group by rut order by fecha_ingreso desc,empresa,apellido_paterno,apellido_materno,nombres";	
				$Resp = mysqli_query($link, $Consulta);
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
						if($FechaTerminoDAS< date('Y-m-d') || $FechaPreoExpi< date('Y-m-d'))
							$Checked='checked=checked';	
						if($FechaTerminoDAS< date('Y-m-d'))	
							$FechaTerminoDAS="<span class='InputRojo'>".$FechaTerminoDAS."</span>";
						else
							$FechaTerminoDAS=$FechaTerminoDAS;	
					}

					if($Fila["fecha_das"]<=date('Y-m-d'))
						$Color="bgcolor=#FF0000";
					else
					{
						if($Fila["hora_entrada"]!='00:00:00'&&$Fila["hora_entrada"]!='00:00:00')
							$Color='bgcolor="#C1FF84"';
						else
							$Color='bgcolor="#FFFFFF"';							
					}	
					if($Fila["hora_entrada"]!='00:00:00'&&$Fila["hora_entrada"]!='00:00:00')
						$ColorEstado='bgcolor="#C1FF84"';
					else
						$ColorEstado='bgcolor="#FFFFFF"';	
				?>				
						<tr>
						  <td width="3%" align="center" <? echo $ColorEstado;?>><? echo "<input name='CheckVisita' class='SinBorde' type='checkbox'  value='".$Fila["corr_visita"]."'>" ?></td>
						  <td width="10%"  <? echo $ColorEstado;?>align="center"><? echo $Fila["fecha_ingreso"];?></td>
						  <td width="7%"  <? echo $ColorEstado;?>align="left"><? echo $Fila["rut"];?></td>
						  <td width="12%"  <? echo $ColorEstado;?>align="left"><? echo ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"]));?>&nbsp;</td>
						  <td width="21%"  <? echo $ColorEstado;?>align="left"><? echo ucwords(strtolower($Fila["empresa"]));?>&nbsp;</td>
						  <td width="21%"  <? echo $ColorEstado;?>align="left"><? echo $Fila["contrato_orden"];?>&nbsp;</td>
						  <td width="11%" <? echo $ColorEstado;?> align="center"><? echo $FechaDAS;?>&nbsp;</td>
						  <td width="15%" <? echo $ColorEstado;?> align="center"><? echo $FechaTerminoDAS;?>&nbsp;</td>
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
	<? include("pie_pagina.php")?>
</form>