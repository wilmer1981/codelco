<?
set_time_limit(3000);
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");


 $CodigoDeSistema = 27;
 $CodigoDePantalla = 7;
 if(isset($CodCtto))
 	$TxtBuscaCod=$CodCtto;
if(!isset($CmbEmpresa))
	$CmbEmpresa='-1';
	
if(!isset($CmbEstado))
	$CmbEstado='-1';
//if(!isset($Buscar))
//{
	if(!isset($TxtFecha))
		$TxtFecha=date('Y')."-".date('m')."-01";
	if(!isset($TxtFechaH))
		$TxtFechaH=date('Y-m-d');
//}	
$HHMens=ObtieneHHMens();
	
?>
<html>
<head>
<title>Reporte Empresas Consolidado</title>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">

function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;

	switch(TipoProceso)
	{
		case "R":	
			f.action ="sget_rpt_empresas_consolidado.php?Recarga=S";
			f.submit();
		break;
		case "C"://
			if(compare_dates(f.TxtFecha.value, f.TxtFechaH.value))
			{
				alert('Fecha desde debe ser menor o igual a fecha hasta');
				return;
			} 
			var xMonth=f.TxtFecha.value.substring(5, 7);
			var yMonth=f.TxtFechaH.value.substring(5, 7);
			var xYear=f.TxtFecha.value.substring(0,4);
			var yYear=f.TxtFechaH.value.substring(0,4);
			//alert(xYear+" "+yYear);   
			if (parseInt(xYear)<parseInt(yYear)) 
			{
				if(parseInt(xMonth)<=parseInt(yMonth))
				{
					alert('El rango de fechas no puede ser mayor a un A�o');
					return;
				}
			}
			//calculaMeses();
			f.action = "sget_rpt_empresas_consolidado.php?Buscar=S";
			f.submit();
		break;
		case "E"://EXCEL
			URL='sget_rpt_empresas_consolidado_excel.php?TxtRutPrv='+f.TxtRutPrv.value+"&TxtDv="+f.TxtDv.value+"&TxtRazonSocial="+f.TxtRazonSocial.value+"&CmbEstado="+f.CmbEstado.value+"&CmbEstado2="+f.CmbEstado2.value+"&TxtFecha="+f.TxtFecha.value+"&TxtFechaH="+f.TxtFechaH.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=22";
		break;
	}
}
function Detalle(Tipo,RutEmp,Ctto,Run,Est)
{
	var f = document.frmPrincipal;
	URL='sget_rpt_empresas_consolidado_detalle.php?Tipo='+Tipo+"&RutEmp="+RutEmp+"&Ctto="+Ctto+"&Run="+Run+"&Estado="+Est+"&TxtFecha="+f.TxtFecha.value+"&TxtFechaH="+f.TxtFechaH.value;
	window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
}
function compare_dates(fecha, fecha2)   
{   
	//alert(fecha+"  -   "+fecha2)
    var xMonth=fecha.substring(5, 7);   
    var xDay=fecha.substring(8, 10);   
    var xYear=fecha.substring(0,4);   
    var yMonth=fecha2.substring(5, 7);   
    var yDay=fecha2.substring(8, 10);   
    var yYear=fecha2.substring(0,4); 
    if (xYear> yYear)   
    {   
        return(true)   
    }   
    else  
    {   
      if (xYear == yYear)   
      {  
        if (xMonth> yMonth)   
        {   
            return(true)   
        }   
        else  
        {    
          if (xMonth == yMonth)   
          {   
            if (xDay> yDay)
			{
              return(true);   
			}
            else  
              return(false);   
          }   
          else  
            return(false);   
        }   
      }   
      else  
	  {
        return(false);   
	  }
    }   
}  
   function cerosIzq(sVal, nPos){
    var sRes = sVal;
    for (var i = sVal.length; i < nPos; i++)
     sRes = "0" + sRes;
    return sRes;
   }

   function armaFecha(nDia, nMes, nAno){
    var sRes = cerosIzq(String(nDia), 2);
    sRes = sRes + "/" + cerosIzq(String(nMes), 2);
    sRes = sRes + "/" + cerosIzq(String(nAno), 4);
    return sRes;
   }

   function sumaMes(nDia, nMes, nAno, nSum){
    if (nSum >= 0){
     for (var i = 0; i < Math.abs(nSum); i++){
      if (nMes == 12){
       nMes = 1;
       nAno += 1;
      } else nMes += 1;
     }
    } else {
     for (var i = 0; i < Math.abs(nSum); i++){
      if (nMes == 1){
       nMes = 12;
       nAno -= 1;
      } else nMes -= 1;
     }
    }
    return armaFecha(nDia, nMes, nAno);
   }

   function esBisiesto(nAno){
    var bRes = true;
    res = bRes && (nAno % 4 == 0);
    res = bRes && (nAno % 100 != 0);
    res = bRes || (nAno % 400 == 0);
    return bRes;
   }

   function finMes(nMes, nAno){
    var nRes = 0;
    switch (nMes){
     case 1: nRes = 31; break;
     case 2: nRes = 28; break;
     case 3: nRes = 31; break;
     case 4: nRes = 30; break;
     case 5: nRes = 31; break;
     case 6: nRes = 30; break;
     case 7: nRes = 31; break;
     case 8: nRes = 31; break;
     case 9: nRes = 30; break;
     case 10: nRes = 31; break;
     case 11: nRes = 30; break;
     case 12: nRes = 31; break;
    }
    return nRes + (((nMes == 2) && esBisiesto(nAno))? 1: 0);
   }

   function diasDelAno(nAno){
    var nRes = 365;
    if (esBisiesto(nAno)) nRes++;
    return nRes;
   }

   function anosEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1)
   {
	    var nRes = Math.max(0, nAn1 - nAn0 - 1);
	    if (nAn1 != nAn0)
	     if ((nMe1 > nMe0) || ((nMe1 == nMe0) && (nDi1 >= nDi0)))
	      nRes++;
	    return nRes;
   }

   function mesesEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1)
   {
	    var nRes;
	    if ((nMe1 < nMe0) || ((nMe1 == nMe0) && (nDi1 < nDi0))) nMe1 += 12;
	    nRes = Math.max(0, nMe1 - nMe0 - 1);
	    if ((nDi1 > nDi0) && (nMe1 != nMe0)) nRes++;
	    return nRes;
   }

   function diasEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1)
   {
	    var nRes;
	    if (nDi1 < nDi0) nDi1 += finMes(nMe0, nAn0);
	    nRes = Math.max(0, nDi1 - nDi0);
	    return nRes;
   }

   function mayorOIgual(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1)
   {
	    var bRes = false;
	    bRes = bRes || (nAn1 > nAn0);
	    bRes = bRes || ((nAn1 == nAn0) && (nMe1 > nMe0));
	    bRes = bRes || ((nAn1 == nAn0) && (nMe1 == nMe0) && (nDi1 >= nDi0));
	    return bRes;
   }

   function calculaMeses()
   {
	    var sFc0 = document.frmPrincipal.TxtFecha.value; // Se asume v�lida
	    var sFc1 = document.frmPrincipal.TxtFechaH.value; // Se asume v�lida
	    var nDi0 = parseInt(sFc0.substr(8, 2), 10);
	    var nMe0 = parseInt(sFc0.substr(5, 2), 10);
	    var nAn0 = parseInt(sFc0.substr(0, 4), 10);
		
	    var nDi1 = parseInt(sFc1.substr(8, 2), 10);
	    var nMe1 = parseInt(sFc1.substr(5, 2), 10);
	    var nAn1 = parseInt(sFc1.substr(0, 4), 10);
	    if (mayorOIgual(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1))
		{
		     var nAno = anosEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1);
		     var nMes = mesesEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1);
		     var nDia = diasEntre(nDi0, nMe0, nAn0, nDi1, nMe1, nAn1);
		     var nTtM = nAno * 12 + nMes;
		     var nTtD = nDia;
		     for (var i = nAn0; i < nAn0 + nAno; i++) nTtD += diasDelAno(nAno);
		     for (var j = nMe0; j < nMe0 + nMes; j++) nTtD += finMes(j, nAn1);
		     var nTSS = Math.floor(nTtD / 7);
		     var nTSD = nTtD % 7;
		     //alert(nTtM+" "+nDia);
			 if(parseInt(nTtM)>12)
			 {
			 	alert('El rango de fechas no puede ser mayor a un A�o');
			 }
			 //alert(String(nTtM) + " meses, " + String(nDia) + " d�as");
			 //document.frmPrincipal.difDMA.value = String(nAno) + " años, " + String(nMes) + " meses, " + String(nDia) + " d�as";
		     //document.frmPrincipal.difDM.value = String(nTtM) + " meses, " + String(nDia) + " d�as";
		     //document.frmPrincipal.difD.value = String(nTtD) + " d�as";
		     //document.frmPrincipal.difSD.value = String(nTSS) + " semanas, " + String(nTSD) + " d�as";
			 //alert(String(nTSS));
	    } else alert("Error en rango");
   }

</script>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>

<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 //EncabezadoPagina($IP_SERV,'rpt_empresas.png')
 ?>
<table width="980" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
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
    <td height="17" class='formulario2'>Rut Empresa </td>
    <td colspan="2" class="formulario2" >
	
<input name='TxtRutPrv' type='text'   value='<? $TxtRutPrv;?>' size='12' maxlength='8' onBlur=CalculaDv(this.form,'TxtRutPrv','TxtDv') onKeyDown="ValidaIngreso('S',false,this.form,'TxtDv')">-<input name="TxtDv" type="text"  id="TxtDv" value="<? $TxtDv;?>"  size="3" maxlength="1">  </tr>
  <tr>
    <td height="17" class='formulario2'>Raz&oacute;n Social </td>
    <td colspan="2" class='formulario2'><input name="TxtRazonSocial" type="text" id="TxtRazonSocial" value="<? echo $TxtRazonSocial; ?>" size="65">  </tr><tr>
    <td width="123"class='formulario2'>Estado Contrato </td>
    <td width="97" class='formulario2' ><SELECT name="CmbEstado" >
      <option value="-1" class="NoSelec">Todos</option>
      <?
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEstado==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
    </SELECT>        
    <td width="686" class='formulario2' >Estado Trabajador
      <SELECT name="CmbEstado2" >
      <option value="-1" class="NoSelec">Todos</option>
      <?
	    $Consulta = "SELECT cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='30007' ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEstado2==$FilaTC["cod_subclase"])
				echo "<option SELECTed value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
    </SELECT>    
    </tr>
  <tr>
    <td class='formulario2'><span class="FilaAbeja2">Fecha de Busqueda</span></td>
    <td colspan="2" class='formulario2' >
Desde&nbsp;
				  <input name="TxtFecha" type="text" readonly   size="10"  value="<? echo $TxtFecha; ?>" >
				  &nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFecha,TxtFecha,popCal);return false">
				  &nbsp;&nbsp;Hasta&nbsp;<input name="TxtFechaH" type="text" readonly   size="10"  value="<? echo $TxtFechaH; ?>" >
				  &nbsp;<img src="archivos/calendario.gif" alt="Pulse Aqui ParaSeleccionar Fecha" width="22" height="18" border="0" align="absmiddle" onClick="popFrame.fPopCalendar(TxtFechaH,TxtFechaH,popCal);return false"></td>  
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
  </table><br>	
  <table width="980" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
	<tr>
	  <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
	  <td width="1188" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
	  <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
	</tr>
	<tr>
	<td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
	<td>
	<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	<tr>
	<td width="20" align="center" class="TituloTablaVerde">Empresa</td>
	<td width="14" align="center" class="TituloTablaVerde" >Rut</td>
	<td width="20" class="TituloTablaVerde" align="center">Contrato</td>
	<td width="15" class="TituloTablaVerde" align="center">Nro&nbsp;Contrato</td>
	<td width="15" class="TituloTablaVerde" align="center">Fec.Ini.Ctto.</td>
	<td width="15" class="TituloTablaVerde" align="center">Fec.Ter.Ctto.</td>
	<td width="15" class="TituloTablaVerde" align="center">Tipo Ctto.</td>
	<td width="8" class="TituloTablaVerde" align="center">Centro&nbsp;Costo </td>
	<td width="10" class="TituloTablaVerde" align="center">Funcionario</td>
	<td width="14" class="TituloTablaVerde" align="center">Run</td>
	<td width="8" class="TituloTablaVerde" align="center">Nro.Tarjeta</td>
	<td width="8" class="TituloTablaVerde" align="center">Activo</td>
	<td width="8" class="TituloTablaVerde" align="center">Genero</td>
	<td width="8" class="TituloTablaVerde" align="center">Turno</td>
	<td width="2" class="TituloTablaVerde" align="center">E</td>
	<td width="2" class="TituloTablaVerde" align="center">S</td>
	<td width="3" class="TituloTablaVerde" align="center">Total<br>HH</td>
	</tr>
  <?
  if($Buscar=='S')
  {
		$TotEnt=0;$TotSal=0;$TotHH=0;
		$Consulta="SELECT t2.cod_tipo_contrato,t2.fecha_inicio,t2.fecha_termino,t1.rut_empresa, t1.razon_social,t2.cod_contrato,t2.descripcion as NomCtto,cod_area,t3.rut,t3.nro_tarjeta,";
		$Consulta.=" t3.nombres,t3.ape_paterno,t3.ape_materno,t3.sexo,t3.cod_turno,t4.descrip_turno,t5.activo from sget_contratistas t1  ";
		$Consulta.=" inner join  sget_contratos t2 on t1.rut_empresa=t2.rut_empresa ";
		$Consulta.=" inner join sget_personal_historia t5 on t2.rut_empresa=t5.rut_empresa and t2.cod_contrato=t5.cod_contrato ";
		$Consulta.=" inner join sget_personal t3 on t5.rut=t3.rut ";
		$Consulta.=" left join  sget_turnos t4 on t4.cod_turno=t3.cod_turno ";
		//$Consulta.=" inner join sget_personal_historia as t5 on t1.rut=t5.rut ";
		//$Consulta.=" and (t1.fechahora >= concat(t5.fecha_ingreso,' 00:00:00') and t1.fechahora <= concat(t5.fecha_termino,' 23:59:59'))"; 
		
		$Consulta.="  where t1.rut_empresa<>'' ";
		if($TxtRutPrv!='')
			$Consulta.= " and t1.rut_empresa= '".str_pad($TxtRutPrv,8,'0',l_pad)."-".$TxtDv."' ";
		if($TxtRazonSocial!='')
			$Consulta.= " and upper(t1.razon_social) like ('%".strtoupper(trim($TxtRazonSocial))."%') ";
		if($CmbEstado!='-1')	
			$Consulta.="  and  t2.estado='".$CmbEstado."' ";
		if($CmbEstado2!='-1'&&$CmbEstado!='2')
		{	
			if($CmbEstado2=='1')
				$Consulta.="  and  t5.activo='S' ";
			else
				$Consulta.="  and  t5.activo='N' ";	
		}
		//$Consulta.=" group by t1.rut_empresa";
		$Consulta.=" order by t1.razon_social,NomCtto,t3.ape_paterno,t3.ape_materno,t3.nombres,t5.fecha_termino desc";
		//echo $Consulta."<br>";
		$RespMod=mysql_query($Consulta);
		$Cont=0;$DatosRegMostrados='';
		while($FilaMod=mysql_fetch_array($RespMod))
		{
			$MuestraReg=BuscaMarcas($FilaMod[rut_empresa],$FilaMod["cod_contrato"],$FilaMod["rut"],$CmbEstado2,$TxtFecha,$TxtFechaH);
			if($MuestraReg>0)
			{
				$Par=($Cont % 2);
				if($Par==1)
				{
					?>
					<tr class="FilaAbeja">
					<?
				}
				else
				{
					?>
					<tr class="FilaAbeja">
					<? 
				}
				$CC=DescripcionArea($FilaMod["cod_area"]);
				?>
				<td><? echo FormatearNombre($FilaMod[razon_social]); ?>&nbsp;</td>
				<td><a href="sget_info_empresa.php?Emp=<? echo $FilaMod[rut_empresa];?>" target="_blank"><? echo FormatearRun($FilaMod[rut_empresa]); ?></a></td>
				<td><? echo ucwords(strtolower($FilaMod[NomCtto])); ?>&nbsp;</td>
				<td><a href="sget_info_ctto_ac.php?Ctto=<? echo $FilaMod["cod_contrato"];?>" target="_blank"><? echo $FilaMod["cod_contrato"]; ?></a></td>
				<td><? echo $FilaMod[fecha_inicio]; ?>&nbsp;</td>
				<td><? echo $FilaMod[fecha_termino]; ?>&nbsp;</td>
				<td>
				<? 
				if($FilaMod[cod_tipo_contrato]=='P')
					echo "Permanente"; 
				else
					echo "No Permanente"; 
				?>&nbsp;
				</td>
				<td><? echo $CC; ?>&nbsp;</td>
				<td><? echo ucwords(strtolower($FilaMod[ape_paterno]." ".$FilaMod[ape_materno]." ".$FilaMod["nombres"]));?>&nbsp;</td>
				<td><? echo $FilaMod["rut"]; ?>&nbsp;</td>
				<td align="center"><? echo $FilaMod[nro_tarjeta]; ?>&nbsp;</td>
				<td align="center"><? echo $FilaMod["activo"]; ?>&nbsp;</td>
				<td align="center"><? echo $FilaMod[sexo]; ?>&nbsp;</td>
				<td align="center">
				<? 
					if($FilaMod[descrip_turno]!='')
						echo substr($FilaMod[descrip_turno],0,5);
					else
						echo "Sin Turno";
				?>
				&nbsp;</td>
				<?
					$Entradas=CalculaES_HH('E',$FilaMod["rut"],$FilaMod[nro_tarjeta],$FilaMod[cod_turno],$TxtFecha,$TxtFechaH);
					$Salidas=CalculaES_HH('S',$FilaMod["rut"],$FilaMod[nro_tarjeta],$FilaMod[cod_turno],$TxtFecha,$TxtFechaH);
					//$HH=CalculaES_HH('HH',$FilaMod["rut"],$FilaMod[nro_tarjeta],$FDesde,$FHasta);
					$HH=HHxTurno($FilaMod[cod_turno],$Entradas);
					$TotEnt=$TotEnt+$Entradas;
					$TotSal=$TotSal+$Salidas;
					$TotHH=$TotHH+$HH;
					$CantMeses=DifMeses($TxtFecha,$TxtFechaH);
					$TopeCantMesHH=$CantMeses*$HHMens;
					
						
					
				?>
				<td align="right"><a href="JavaScript:Detalle('E','<? echo $FilaMod[rut_empresa];?>','<? echo $FilaMod["cod_contrato"];?>','<? echo $FilaMod["rut"]?>','<? echo $CmbEstado2;?>')"><? echo number_format($Entradas,0,'','.');?></a></td>
				<td align="right"><a href="JavaScript:Detalle('S','<? echo $FilaMod[rut_empresa];?>','<? echo $FilaMod["cod_contrato"];?>','<? echo $FilaMod["rut"]?>','<? echo $CmbEstado2;?>')"><? echo number_format($Salidas,0,'','.');?></a></td>
				<td align="right">
				<?
					if($TopeCantMesHH<$HH)
					{
						echo "<span style='color:#FF0000'>".number_format($HH,0,'','.')."</span>";
					}
					else
					{
						echo number_format($HH,0,'','.');
					}	
				?>
				</td>
				</tr>
			<?
				$Cont++;
			   }
		}
		?>
		<tr>
			<td align="left" colspan="14">Cantidad de Registros:&nbsp;<? echo $Cont;?></td> 
			<td align="right"><? echo number_format($TotEnt,0,'','.');?></td>
			<td align="right"><? echo number_format($TotSal,0,'','.');?></td>
			<td align="right"><? echo number_format($TotHH,0,'','.');?></td>
		</tr>
	  </table>
	  </td>
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
function CalculaES_HH($Tipo,$Rut,$Tarjeta,$Turno,$FDesde,$FHasta)
{
	$Cant=0;$ContHrs=0;
	switch($Tipo)
	{
		case "E":
		case "S":
			$Consulta="SELECT ifnull(count(*),0) as cant from uca_web.uca_accesos_personas where rut='".$Rut."' and tipo='".$Tipo."' ";
			//$Consulta.="and nro_tarjeta='".$Tarjeta."' ";
			$Consulta.="and fechahora between '".$FDesde." 00:00:00' and '".$FHasta." 23:59:59'";
			$RespCalc=mysql_query($Consulta);
			$FilaCalc=mysql_fetch_array($RespCalc);
			//if($Rut=='13850949-4')
			//	echo $Consulta."<br>";
			$Cant=$FilaCalc["cant"];
		break;
	
	}
	return($Cant);
}
function HHxTurno($CodTurno,$Entradas)
{
	switch($CodTurno)
	{
		case "1"://ADMINISTRATIVO
			$HH=$Entradas*9;
		break;
		case "2"://TURNOS A
			$HH=$Entradas*8;
		break;
		case "3"://TURNOS AB
			$HH=$Entradas*8;
		break;
		case "4"://TURNOS ABC
			$HH=$Entradas*12;
		break;
		default:
			$HH=$Entradas*9;//SIN TURNO ASIGNADO
		break;
	}
	return($HH);

}
function BuscaMarcas($RutEmp,$CodCtto,$Rut,$Estado,$FDesde,$FHasta)
{
	global $DatosRegMostrados;
	
	$MuestraReg=0;
	/*$Consulta = "SELECT distinct t3.rut_empresa, t1.rut, t3.razon_social from ";
	$Consulta.= " uca_web.uca_accesos_personas as t1 inner join sget_personal as t2 on t1.rut=t2.rut ";
	$Consulta.= " inner join sget_personal_historia as t5 on t1.rut=t5.rut ";
	$Consulta.= " and (t1.fechahora >= concat(t5.fecha_ingreso,' 00:00:00') and t1.fechahora <= concat(t5.fecha_termino,' 23:59:59'))"; 
	$Consulta.= " inner join sget_contratistas as t3 on t2.rut_empresa=t3.rut_empresa";
	$Consulta.= " where t1.rut='".$Rut."' and t1.fechahora between '".$FDesde." 00:00:00' and '".$FHasta." 23:59:59' and t2.rut_empresa <> '61704000-k'";
	$Consulta.= " and t2.rut_empresa = '".$RutEmp."' and t2.cod_contrato = '".$CodCtto."'";
	$Consulta.=" and t2.nro_tarjeta<>'00000000' and t2.estado<>'I' ";*/
	
	$Consulta = "SELECT count(*) as cant_reg from sget_personal as t1 ";
	$Consulta.= "inner join sget_personal_historia as t2 on t1.rut=t2.rut and t2.rut_empresa = '".$RutEmp."' and t2.cod_contrato = '".$CodCtto."' ";
	switch($Estado)
	{
		case "1":
			$Consulta.=" and t2.activo='S' ";
		break;
		case "2":
			$Consulta.=" and t2.activo='N' ";
		break;
	}
	$Consulta.= "inner join uca_web.uca_accesos_personas as t3 on t2.rut=t3.rut ";
	$Consulta.= "and (t3.fechahora >= concat(t2.fecha_ingreso,' 00:00:00') and t3.fechahora <= concat(t2.fecha_termino,' 23:59:59'))"; 
	$Consulta.= "where t1.rut='".$Rut."' and (t3.fechahora between '".$FDesde." 00:00:00' and '".$FHasta." 23:59:59') ";
	$Consulta.= "group by t1.rut,t2.cod_contrato,t2.rut_empresa ";
	$RespMarcas=mysql_query($Consulta);
	//if($Rut=='13850949-4')
	//	echo $Consulta."<br>";
	if($FilaMarcas=mysql_fetch_array($RespMarcas))
	{
		$MuestraReg=$FilaMarcas["cant_reg"];
		//PARA TRABAJADORES QUE TIENEN 2 HISTORIAL DENTRO DEL MISMO CONTRATO Y RANGO DE FECHAS
		if($DatosRegMostrados!='')
		{
			$Datos=explode('~',$DatosRegMostrados);
			
			if($Datos[0]==$CodCtto&&$Datos[1]==$Rut&&$Datos[2]>=$FDesde&&$Datos[3]<=$FHasta)
			{
				//echo "if(".$Datos[0]."==".$CodCtto."&&".$Datos[1]."==".$Rut."&&".$Datos[2].">=".$FDesde."&&".$Datos[3]."<=".$FHasta.")<br>";
				$MuestraReg=0;
			}
		}
		$DatosRegMostrados=$CodCtto."~".$Rut."~".$FDesde."~".$FHasta;
	}
	return($MuestraReg);
}
function DifMeses($FecIni,$FecFin)
{

//$fechaInicio ="13-01-2011"; 
//$fechaActual = "12-02-2011"; 

$diaActual = substr($FecFin, 8, 2); 
$mesActual = substr($FecFin, 5, 2); 
$anioActual = substr($FecFin, 0, 4); 
$diaInicio = substr($FecIni, 8, 2); 
$mesInicio = substr($FecIni, 5, 2); 
$anioInicio = substr($FecIni, 0, 4); 

$b = 0; 
$mes = $mesInicio-1; 
if($mes==2)
{ 
	if(($anioActual%4==0 && $anioActual%100!=0) || $anioActual%400==0)
	{ 
		$b = 29; 
	}
	else
	{ 
		$b = 28; 
	} 
} 
else 
	if($mes<=7)
	{ 
		if($mes==0)
		{ 
			$b = 31; 
		} 

	else if($mes%2==0){ 

$b = 30; 

} 

else{ 

$b = 31; 

} 

} 

else if($mes>7){ 

if($mes%2==0){ 

$b = 31; 

} 

else{ 

$b = 30; 

} 

} 

if(($anioInicio>$anioActual) || ($anioInicio==$anioActual && $mesInicio>$mesActual) || 

($anioInicio==$anioActual && $mesInicio == $mesActual && $diaInicio>$diaActual)){ 

echo "La fecha de inicio ha de ser anterior a la fecha Actual"; 

}else{ 

if($mesInicio <= $mesActual){ 

$anios = $anioActual - $anioInicio; 

if($diaInicio <= $diaActual){ 

$meses = $mesActual - $mesInicio; 

$dies = $diaActual - $diaInicio; 

}else{ 

if($mesActual == $mesInicio){ 

$anios = $anios - 1; 

} 

$meses = ($mesActual - $mesInicio - 1 + 12) % 12; 

$dies = $b-($diaInicio-$diaActual); 

} 

}
else
{ 
	$anios = $anioActual - $anioInicio - 1; 
	
	if($diaInicio > $diaActual){ 
	
	$meses = $mesActual - $mesInicio -1 +12; 
	
	$dies = $b - ($diaInicio-$diaActual); 
	
	}
	else
	{ 
	$meses = $mesActual - $mesInicio + 12; 
	$dies = $diaActual - $diaInicio; 
	} 

}
} 
//echo "MESES:".(intval($meses)+1);
return(intval($meses)+1);

/*echo "A�os: ".$anios." <br />"; 

echo "Meses: ".$meses." <br />"; 

echo "D�as: ".$dies." <br />"; */


}
function ObtieneHHMens()
{
	    $HHMens=180;//DEFAULT
		$Consulta = "SELECT valor_subclase1 as cant_hh from proyecto_modernizacion.sub_clase where cod_clase='30026' and cod_subclase='1'";			
		$RespSC=mysql_query($Consulta);
		if ($FilaSC=mysql_fetch_array($RespSC))
		{
			$HHMens=$FilaSC[cant_hh];
			//echo "HH MENS: ".$HHMens;
		}
		return($HHMens);
}
?>
</form>
</body>
</html>