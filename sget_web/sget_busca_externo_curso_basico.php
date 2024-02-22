<?	
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
?>
<html>
<head>
<title>Ingreso de Curso Basico</title>
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
				f.action="sget_busca_externo_curso_basico.php?Buscar=S";
				f.submit();
		break;
		case "G":
			DatosFechas=Recuperar6(f.name,'ChkDatos');
			var Largo=DatosFechas.length;
			DatosFechas=DatosFechas.substring(0,Largo-2);
			f.action='sget_busca_externo_curso_basico01.php?Proceso=G&Valores2='+DatosFechas;
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
	f.action='sget_busca_externo_curso_basico.php';
	f.submit();
}
</script>
</head>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs_valida.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="FrmSelContrat" method="post" action="">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="74%" align="left"><img src="archivos/sub_tit_curso_basico.png" /></td>
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
            <option value="-1" class="NoSelec">Todos</option>
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
<table width="670" border="0" align="center" cellpadding="2" cellspacing="0" class="BordeTabla">
  <tr>
    <td width="30"  align="center" class="TituloTablaNaranja">N�</td>
	<td width="70"  align="center" class="TituloTablaNaranja">Rut</td>
	<td width="165" align="center" class="TituloTablaNaranja">Nombre</td>
    <td width="210" align="center" class="TituloTablaNaranja">Empresa</td>
    <td width="65"  align="center" class="TituloTablaNaranja">Contrato</td>
    <td width="110" align="center" class="TituloTablaNaranja">Term.Curso b�sico</td>
  </tr>
  <tr>
<?

if($Buscar=='S')
{
	$Encontro=false;
	$Cont=0;
	$FechaActual=date("Y")."-".date("m")."-".date("d");
	$Consulta = "SELECT t1.fecha_termino_curso,t1.rut,t1.cod_contrato,t1.ape_paterno,t1.ape_materno,t1.nombres,t3.razon_social from sget_personal t1 inner join sget_contratos t2 ";
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
	echo "<input name='ChkDatos' type='hidden'  value=''>";
	$cont=1;
	$Resp = mysql_query($Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		$Cont++;
		$Campos=$Cont;
		?>
	<tr align='center' class='BordeBajo'>
		<!--<td align='center' class='BordeBajo'><? echo $Cont;?> </td>-->	
		<td  align='center' class='BordeBajo'><? echo $Cont;?> <input type='hidden' name='ChkDatos' value='<? echo $Fila["rut"];?>' class='SinBorde' )></td>
		<td  align='left' class='BordeBajo'><? echo $Fila["rut"]; ?>&nbsp;</td>
		<td  class='BordeBajo' align="left"><? echo FormatearNombre($Fila[ape_paterno]).' '.FormatearNombre($Fila[ape_materno]).' '.FormatearNombre($Fila["nombres"]); ?></td>
		<td  class='BordeBajo' align="left"><? echo FormatearNombre($Fila[razon_social]); ?></td>
		<td  class='BordeBajo'><?  echo $Fila["cod_contrato"];?>&nbsp;</td>	
	    <td  class='BordeBajo' align="center">
		<input name="TxtFechaT<? echo $Campos; ?>" type="text" value="<? echo $Fila[fecha_termino_curso]; ?>" size="12" maxlength="12" readonly >
		<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaT<? echo $Campos; ?>,TxtFechaT<? echo $Campos; ?>,popCal,'N');return false">
		</td>
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
