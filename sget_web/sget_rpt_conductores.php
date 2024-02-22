<?
		include("../principal/conectar_sget_web.php");
		include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

 $CodigoDeSistema = 27;
 $CodigoDePantalla = 7;
 if(!isset($CmbSexo))
 	$CmbSexo="-1";
if(!isset($CmbEmpresa))
	$CmbEmpresa='-1';
?>
<html>
<head>
<title>Consulta Conductores</title>
<style type="text/css">
<!--
body {
	background-image: url(archivos/f1.gif);
}
-->
</style>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">

function Procesos(TipoProceso,cod)
{
	var f = document.frmconductores;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "R":	
			f.action ="sget_rpt_conductores.php?Recarga=S";
			f.submit();
		break;
		case "C"://BUSCA EMPRESA EN SISTEMA CONTRATOS VENTANAS Y LOS EXPORTA HACIA SISTEMA UCAS
			f.action = "sget_rpt_conductores.php?Buscar=S";
			f.submit();
		break;
		case "E"://EXCEL
			URL='sget_rpt_conductores_excel.php?TxtPat='+f.TxtPat.value+"&TxtMat="+f.TxtMat.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=22";
		break;
		case "muestra":
			URL='sget_rpt_conductores_muestra.php?&Opc=M&CorrCond='+cod;
			window.open(URL,"","top=30,left=30,width=1000,height=450,status=yes,menubar=no,resizable=yes,scrollbars=yes");
		break;
	}
}
</script>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>

<form name="frmconductores" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'rpt_conductores.png')
 ?>
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
    <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		
		   	  	<a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
	<a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>
		
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td width="116" height="17" class='formulario2'>Apellido Paterno </td>
    <td width="288" class='formulario2'><input name="TxtPat" type="text" id="TxtApellido"  size="45">      
    <td width="115" class='formulario2'>Apellido Materno    
    <td width="383" class='formulario2'><input name="TxtMat" type="text" id="TxtMat"  size="45">  </tr>
  <tr>
    <td height="17" class='formulario2'>Rut Empresa</td>
    <td class='formulario2'><input name="TxtRutEMP" type="text" id="TxtRutEMP"  size="12">  
    <td class='formulario2'>Empresa
    <td class='formulario2'><input name="TxtNomEMP" type="text" id="TxtNomEMP"  size="45">  </tr>
  <tr>
    <td height="17" class='formulario2'>Validado</td>
    <td class='formulario2'><span class="FilaAbeja2">
      <SELECT name="Val">
        <?
		  switch($Val)
		  {
			case "N":
					?>
					<option value="T">Todos</option>
					<option value="S">Validado</option>
					<option value="N" SELECTed="SELECTed">No Validado</option>
			        <?
			break;
			case "S":
					?>
					<option value="T">Todos</option>
					<option value="S" SELECTed="SELECTed">Validado</option>
					<option value="N">No Validado</option>
			        <?
			break;
			default:
					?>
					<option value="T" SELECTed="SELECTed">Todos</option>
					<option value="S">Validado</option>
					<option value="N">No Validado</option>
			        <?
			break;
		  }
		?>
      </SELECT>
    </span>  
    <td class='formulario2'>  
    <td class='formulario2'>  
  </tr>
</table>
  </td>
   <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
  </tr>
  <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
  <?
	if($Buscar=='S')
	{
		?>
		<table width="1024" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
		<tr>
		  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
		  <td width="920" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
		  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
    	</tr>
		<tr>
		<td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
		<td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td align="center" class="TituloTablaVerde">Rut</td>
            <td align="center" class="TituloTablaVerde">Nombre</td>
            <td align="center" class="TituloTablaVerde">Tipo Veh�culo </td>
            <td align="center" class="TituloTablaVerde">Tipo Licencias </td>
            <td align="center" class="TituloTablaVerde">Restricci&oacute;n</td>
            <td align="center" class="TituloTablaVerde">Fecha&nbsp;Vig. Licencia  Municipal</td>
            <td align="center" class="TituloTablaVerde">Vig.&nbsp;Examenes Preoc.</td>
            <td align="center" class="TituloTablaVerde">Vig.&nbsp;Examenes psico-senso-tecnico</td>
            <td align="center" class="TituloTablaVerde">Instituci�n&nbsp;que&nbsp;realiza examen psico-senso-tecnico</td>
            <td width="11%" align="center" class="TituloTablaVerde">Fecha&nbsp;Curso Manejo&nbsp;Defensivo</td>
            <td width="11%" align="center" class="TituloTablaVerde">Fecha&nbsp;Hoja Vida Conductor</td>
            <td width="11%" align="center" class="TituloTablaVerde">N�&nbsp;Hoja de Vida Conductor</td>
            <td width="11%" align="center" class="TituloTablaVerde">Observaci�n</td>
            <td align="center" class="TituloTablaVerde">Empresa</td>
            <td align="center" class="TituloTablaVerde">N&deg; Contrato </td>
            <td align="center" class="TituloTablaVerde">Fec.&nbsp;Ini.&nbsp;Ctto.</td>
            <td align="center" class="TituloTablaVerde">Fec.&nbsp;Fin.&nbsp;Ctto.</td>
            <td align="center" class="TituloTablaVerde">Validado</td>
          </tr>
          <?
				$Consulta="SELECT *,t1.rut from sget_conductores t1 left join sget_personal t2 on t1.rut=t2.rut where corr_conductor<>''";
				if($TxtPat!='')
					$Consulta.=" and t1.apellido_paterno like '%".$TxtPat."%'";
				if($TxtMat!='')
					$Consulta.=" and t1.apellido_materno like '%".$TxtMat."%'";
				if($TxtRutEMP!='')	
					$Consulta.=" and t2.rut_empresa='".$TxtRutEMP."'";
				if($TxtNomEMP!='')	
					$Consulta.=" and t1.empresa like '%".$TxtNomEMP."%'";
				if($Val!='T')	
					$Consulta.=" and t1.validado='".$Val."'";
				$Consulta.=" order by t1.apellido_paterno,t1.apellido_materno,t1.nombres";	
				$Resp = mysql_query($Consulta);
				echo "<input name='CheckConduc' type='hidden'  value=''>";
				$Cont=1;
				while ($Fila=mysql_fetch_array($Resp))
				{
					?>
				  <tr>
					<td ><a href="JavaScript:Procesos('muestra','<? echo $Fila["corr_conductor"]?>')" class="SinBorde"><? echo $Fila["rut"]; ?></a></td>
					<td ><? echo ucwords(strtolower($Fila["apellido_paterno"]." ".$Fila["apellido_materno"]." ".$Fila["nombres"])); ?></td>
					<td align="center"><? 
					if(strtoupper($Fila["tipo_vehiculo"])=='VL') 
					  		echo "Veh&iacute;culo Liviano";
					if(strtoupper($Fila["tipo_vehiculo"])=='EP') 
					  		echo "Veh&iacute;culo Pesado";			
					?>&nbsp;</td>
					<td align="left" >
					<? $Tipo='';
					$ConsulTip="SELECT tipo_licencia from sget_conductores_licencias where corr_conductor='".$Fila["corr_conductor"]."'";	
					$RespTip=mysql_query($ConsulTip);
					while($FilasTip=mysql_fetch_array($RespTip))
					{
					  	$Tipo=$Tipo.$FilasTip["tipo_licencia"].", "; 					  	
					}
					echo substr($Tipo,0,strlen($Tipo)-2);
					?>
					&nbsp;</td>
					<td ><textarea name="Restriccion" cols="30"><? echo $Fila["restriccion_licencia"]?></textarea></td>
					<td align="center" ><? echo $Fila["fecha_vig_licencia"]; ?></td>
					<td align="center" ><? echo $Fila["fecha_exa_preoc"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["fecha_exa_pst"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["institu_realiza_exam_pst"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["fecha_curso_manejo"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["fecha_hoja_vida"]."&nbsp;"; ?></td>
					<td align="center"><? echo $Fila["hoja_vida_n_docu"]."&nbsp;"; ?></td>
					<td ><textarea name="observacion" cols="30" readonly="readonly"><? echo $Fila["observacion"]?></textarea></td>
					<td align="left"><? echo $Fila["rut_empresa"]." - ".$Fila["empresa"]."&nbsp;"; ?></td>
					<td ><? echo $Fila["contrato"]."&nbsp;"; ?></td>
					<td align="center" ><? echo $Fila["fec_ini_ctto"]."&nbsp;"; ?></td>
					<td align="center" ><? echo $Fila["fec_fin_ctto"]."&nbsp;"; ?></td>
				    <td align="center" >
				    <? 
						if($Fila[validado]=='N')
							echo "<img src='archivos/proceso.png' class='SinBorde' alt='Conductor No Validado'>";
						else
							echo "<img src='archivos/acepta.png' class='SinBorde' alt='Conductor Validado'>";	
				    ?></td>
				  </tr>
				  <?		$Cont++;
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
  </table>
	<? 
	
	}	
CierreEncabezado()
?>
</form>


</body>
</html>