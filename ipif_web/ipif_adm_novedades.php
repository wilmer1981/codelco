<?  session_start();
	session_register('NumNov');
	$NumNov='';
	include("../principal/conectar_ipif_web.php");
	include("funciones/ipif_funciones.php");
	$FechaSist=date("d/m/Y");
	if(!isset($TxtFecha))
	$TxtFecha=date("d-m-Y");
	
	
	$CODIGOCLASE=CODIGOCLASE();
	
		
?>
<title>
Novedades Diarias
</title>
<link href="estilos/ipif_style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/ipif_funciones.js"></script>
<script language="javascript">

function CambiaFecha(op)
{
	var f=document.FrmProceso;
	
 
		var fecha1 = new fecha(f.TxtFecha.value)  
		var miFecha1 = new Date(  fecha1.dia, fecha1.mes-1,fecha1.anio )
		switch(op)
		{
			case '+':
				var suma=miFecha1.getTime()+(1*24*60*60*1000)
			break;
			case '-':
				var suma=miFecha1.getTime()-(1*24*60*60*1000)
			break;
		}	
		var miF= new Date()
		miFecha1.setTime(suma)
		var diastring =miFecha1.toLocaleString()
		//alert(diastring);
		var FechaNueva=FechaCorta(diastring)
		f.TxtFecha.value=FechaNueva;	


}
function Mod(NS)
{
	var URL="ipif_solicitud01.php?Opt=MS&NV="+NS;
	var opciones='top=0,left=2,toolbar=0,resizable=1,menubar=0,status=1,width=1050,height=600,scrollbars=1';
	window.open(URL,'',opciones)

}

function Proceso(Opt)
{
	var f=document.FrmProceso;
	switch (Opt)
	{
		case "B":
			f.action='ipif_adm_novedades.php?Buscar=S';
			f.submit();
		break;
		case "ADM":
			var URL="ipif_adm_sistema.php";
			var opciones='top=0,left=2,toolbar=0,resizable=1,menubar=0,status=1,width=1050,height=480,scrollbars=1';
			window.open(URL,'',opciones)
		break;
		case "Rpt":
			var URL="ipif_rpt_diario.php";
			var opciones='top=0,left=2,toolbar=0,resizable=1,menubar=0,status=1,width=1050,height=480,scrollbars=1';
			window.open(URL,'',opciones)
		break;
		case "AC":
			f.action='ipif_adm_novedades.php?Buscar=S';
			f.submit();
		break;
		case "N":
			var URL="ipif_solicitud01.php?Opt=IS";
			var opciones='top=0,left=2,toolbar=0,resizable=1,menubar=0,status=1,width=1100,height=600,scrollbars=1';
			window.open(URL,'',opciones)
		break;
		case "E":	
			if(SoloUnElemento(f.name,'Check','E'))
			{
				Datos=Recuperar(f.name,'Check');
				f.action="ipif_solicitud01.php?Opt=EM&NumVarios="+Datos;
				f.submit();
			}
		break;
		case "I":
			window.print();
			break;
		case "S":
		if(f.Pmn.value=='S')
		{
			f.action='../pmn_web/pmn_principal.php';
			f.submit();		
		}
		else
		{
			f.action="ipif_solicitud01.php?Opt=SSAL";
			f.submit();
		}
		break;
	}
}
function Cierre(Nov,Es)
{
	var f=document.FrmProceso;
	if(Es=='1')
		Es=2;
	else
		Es=1;
	f.action='ipif_solicitud01.php?Opt=CD&NV='+Nov+'&Es='+Es;
	f.submit();
}
</script>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=180 scrolling=no height=180></IFRAME></DIV>
<form name="FrmProceso" action="" method="post" ENCTYPE="multipart/form-data">
<input type="hidden" name="Pmn" value="<? echo $Pmn;?>">
 <?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'novedades_diarias.png',$CookieRut)
 ?>
  <table width="970" align="center"  border="0" cellpadding="0"  cellspacing="0"  class="TablaPricipalColor" >
  <tr>
	<td height="15"><img src="archivos/images/interior/esq01.png" width="15" height="15"></td>
	<td width="970" height="15"background="archivos/images/interior/form_arriba0.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq02.png" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq0.png">&nbsp;</td>
   <td><table width="100%" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">

     <tr>
       <td width="259" align="left" height="8" class="formulario" > 
	<? 
		/*echo "***************************"."<br>";
		echo "COOKIERUT ".$CookieRut."<br>";*/
		$Cuenta=CuentaRut($CookieRut);
		/*echo "***************************"."<br>";
		echo "Cuenta_2  ".$Cuenta2."<br>";*/
		$ADMINISTRADOR=CODIGOADMINISTRADOR();
		/*echo "***************************"."<br>";
		echo "ADMINISTRADOR".$ADMINISTRADOR."<br>";*/
 		$Consulta = "select * from  ipif_ceco_solicitante where cuenta_solicitante='".$Cuenta."' and cod_perfil='".$ADMINISTRADOR."' ";
		$Resp=mysql_query($Consulta);
		/*echo "***************************"."<br>";
		echo $Consulta."<br>";;*/
		if ($FilaT=mysql_fetch_array($Resp))
			{?> <a  href="JavaScript:Proceso('ADM')"><img src="archivos/mantenedor2.png"  border="0"  alt="Adm. Novedades" align="absmiddle" /></a><? }?>
	   <a  href="JavaScript:Proceso('Rpt')"><img src="archivos/reportes.png"  border="0"  alt="Reporte Diario" align="absmiddle" /></a>
	     </td>
       <td colspan="2" class="formulario" >&nbsp;</td>
       <td width="362" colspan="2" align="right" >
	   	<a  href="JavaScript:Proceso('N')"><img src="archivos/nuevo.png"  border="0"  alt="Nueva Novedad" align="absmiddle" /></a>
	    <a href="JavaScript:Proceso('AC')"><img src="archivos/actualizar.png"  border="0" alt="Refrescar Pantalla" align="absmiddle"></a>
		<a href="JavaScript:Proceso('E')"><img src="archivos/eliminar.png"  border="0" alt="Eliminar" align="absmiddle"></a>  
		<a href="JavaScript:Proceso('I')"><img src="archivos/impresora.png" border="0" alt="Imprimir" align="absmiddle" /></a> 
	    <a href="JavaScript:Proceso('S','<? echo $Pmn;?>')"><img src="archivos/volver.png"  alt="Volver " border="0" align="absmiddle" /></a>	   </td>
       </tr>
     <tr>
       <td align="left" class="formulario" >
	   <label>
	   <a  href="JavaScript:CambiaFecha('-')"><img src="archivos/retroceder.png"  border="0"  alt="Retroceder Fecha" align="absmiddle" /></a>
	   <input name="TxtFecha" type="text" style="width:70" id="TxtFecha" value="<? echo $TxtFecha; ?>" />
	   <img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false">
	   <a  href="JavaScript:CambiaFecha('+')"><img src="archivos/avanzar.png"  border="0"  alt="Avanzar Fecha" align="absmiddle" /></a>
	   </label>
	   &nbsp;&nbsp;&nbsp; </td>
       <td width="44"  align="left" class="formulario" >Turno</td>
       <td colspan="3" ><select name="CmbTurno">
         <option value="-1" class="NoSelec">Todos</option>
         <?
			$Consulta = "select * from  proyecto_modernizacion.sub_clase where cod_clase=1 order by valor_subclase1";
			$Resp=mysql_query($Consulta);
			while ($FilaT=mysql_fetch_array($Resp))
				{
					if ($CmbTurno==$FilaT["cod_subclase"])
					echo "<option selected value='".$FilaT["cod_subclase"]."'>".ucfirst($FilaT["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaT["cod_subclase"]."'>".ucfirst($FilaT["nombre_subclase"])."</option>\n";
				}
			
?>
       </select><a href="JavaScript:Proceso('B')"><img src="archivos/Find.png"  border="0" alt="Buscar" align="absmiddle"></a></td>
       </tr>
       </table>
	 <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
		<tr >
		<? 
		$Cuenta=CuentaRut($CookieRut);
		$Ceco=CECOFuncionario($Cuenta);
		//echo "cuenta_".$CookieRut;
		$DEsc=DescripcionCeco($Ceco);
		
		?>
		  <td height="22" colspan="8" class="TituloTablaNaranja" ><? echo 	$DEsc; ?>&nbsp;</td>
		  </tr>
		<tr class="TituloCabecera">
		<td width="20" height="22" class="formulario" >&nbsp;		</td>
		<td width="75"  class="TituloCabecera" >N&deg; Novedad </td>
		<td width="73" class="TituloCabecera"  >Turno</td>
		<td width="73" class="TituloCabecera"  >Fecha</td>
		<td width="418"  class="TituloCabecera" >Novedad</td>
		<td width="172"  class="TituloCabecera" >Originador</td>
		<td width="42" class="TituloCabecera"  >&nbsp;</td>
		<td width="37" class="TituloCabecera"  >&nbsp;</td>
		</tr>
		<?
		$FB=FechaAMD($TxtFecha);
		if($Buscar=='S')
		{
			
			$Consulta="select * from ipif_novedades where fecha_ingreso='".$FB."'  and estado >=1  and ceco_origen='".$Ceco."' ";
			if($CmbTurno != '-1')
				$Consulta.=" and turno='".$CmbTurno."'";
			$RespSolp=mysql_query($Consulta);
			//echo $Consulta;
			echo "<input name='Check' class='SinBorde' type='hidden'  value=''>";
			while($FilaSolp=mysql_fetch_array($RespSolp))
			{
				$TxtFecha=$FilaSolp[fecha_ingreso];
				$textnovedad=$FilaSolp["observacion"];
				$InfGer=$FilaSolp[informe_gerencia];
				$Dia=substr($FilaSolp[fecha_ingreso],8,2);
				$T='T'.Turno($FilaSolp[turno]);
				$Hora=substr($FilaSolp[hora],0,5);
				$Codigo=$Dia.'-'.$T.'-'.$Hora;
				$Candado=$FilaSolp[estado];
				if($Candado==1)
					$Candado=1;
				else	
					$Candado=2;
			?>
			<tr >
			<td ><input name='Check' class='SinBorde' type='checkbox'  value='<? echo $FilaSolp["nro_solicitud"];?>'></td>
			<td ><? echo $FilaSolp["nro_solicitud"]; ?></a>&nbsp;</td>
			<td ><? echo $Codigo; ?>&nbsp;</td>
			<td >
			 <?
			 echo FechaAMD($FilaSolp[fecha_ingreso]);
			?>&nbsp;
			</td>
			<td ><? echo $FilaSolp["observacion"]; ?>&nbsp;</td>
			<td ><? echo NombreOrig($FilaSolp[rut_originador]); ?>&nbsp;</td>
			<td align="center">
			<?
			if($Candado == '1')
			{
				?>
				<a href="JavaScript:Cierre('<? echo $FilaSolp["nro_solicitud"];?>','<? echo $Candado;?>')"><img src="archivos/candado_abierto.png"  border="0" alt="Cerrar Novedad" align="absmiddle"></a>
			<?
			}
			else
			{
				?>
				<a href="JavaScript:Cierre('<? echo $FilaSolp["nro_solicitud"];?>','<? echo $Candado;?>')"><img src="archivos/candado_cerrado.gif"  border="0" alt="Abrir Novedad" align="absmiddle"></a>
				
			<?
			}
			?>			</td>
			<td ><a href="JavaScript:Mod('<? echo $FilaSolp["nro_solicitud"];?>')"><img src="archivos/Find.png"  border="0" alt="Buscar" align="absmiddle"></a></td>
			</tr>
			<?
			}
		}	
		 
	?>
   </table>
   <table width="100%" border="1" align="center" cellpadding="1" cellspacing="0" bgcolor="#FFFBFB">
		<tr class="TituloCabecera">
		<td height="22" colspan="8" class="formulario" >Pendientes</td>
		</tr>
		<?
		if($Buscar=='S')
		{
			$Consulta="select * from ipif_novedades where fecha_ingreso  < '".$FB."' and estado >= 1 and estado <> 2 and ceco_origen='".$Ceco."'";
			if($CmbTurno != '-1')
				$Consulta.=" and turno='".$CmbTurno."'";
			$RespSolp=mysql_query($Consulta);
			//echo $Consulta;
			echo "<input name='Check' class='SinBorde' type='hidden'  value=''>";
			while($FilaSolp=mysql_fetch_array($RespSolp))
			{
				$TxtFecha=$FilaSolp[fecha_ingreso];
				$textnovedad=$FilaSolp["observacion"];
				$InfGer=$FilaSolp[informe_gerencia];
				$Dia=substr($FilaSolp[fecha_ingreso],8,2);
				$T='T'.Turno($FilaSolp[turno]);
				$Hora=substr($FilaSolp[hora],0,5);
				$Codigo=$Dia.'-'.$T.'-'.$Hora;
				$Candado=$FilaSolp[estado];
				if($Candado==1)
					$Candado=1;
				else	
					$Candado=2;
			?>
			<tr >
			<td width="20" ><input name='Check' class='SinBorde' type='checkbox'  value='<? echo $FilaSolp["nro_solicitud"];?>'></td>
			<td width="75" ><? echo $FilaSolp["nro_solicitud"]; ?></a>&nbsp;</td>
			<td width="73" ><? echo $Codigo; ?>&nbsp;</td>
			<td width="73" >
			 <?
			 echo FechaAMD($FilaSolp[fecha_ingreso]);
			?>&nbsp;
			</td>
			<td width="418" ><? echo $FilaSolp["observacion"]; ?>&nbsp;</td>
			<td width="172" ><? echo NombreOrig($FilaSolp[rut_originador]); ?>&nbsp;</td>
			<td width="42" align="center">
			<?
			if($Candado == '1')
			{
				?>
				<a href="JavaScript:Cierre('<? echo $FilaSolp["nro_solicitud"];?>','<? echo $Candado;?>')"><img src="archivos/candado_abierto.png"  border="0" alt="Cerrar Novedad" align="absmiddle"></a>
			<?
			}
			else
			{
				?>
				<a href="JavaScript:Cierre('<? echo $FilaSolp["nro_solicitud"];?>','<? echo $Candado;?>')"><img src="archivos/candado_cerrado.gif"  border="0" alt="Abrir Novedad" align="absmiddle"></a>
				
			<?
			}
			?>			</td>
			<td width="37" ><a href="JavaScript:Mod('<? echo $FilaSolp["nro_solicitud"];?>')"><img src="archivos/Find.png"  border="0" alt="Buscar" align="absmiddle"></a></td>
			</tr>
			<?
			}
		}	
		 
	?>
   </table>
   
   </td>
   <td  width="15" background="archivos/images/interior/form_der0.png">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq03.png" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo0.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq04.png" width="15" height="15" /></td>
  </tr>
  </table>
  <?
  
  
  CierreEncabezado()
  
  
  ?>
</form>
</body>
