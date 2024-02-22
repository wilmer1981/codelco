<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbContr))
	$CmbContr='-1';		
?>
<html>
<head>
<title>Consulta Previsi�n</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-color: #f9f9f9;
}
-->
</style>
<link href="estilos/css_pcip_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="funciones/pcip_funciones.js"></script>
<script language="JavaScript">
function Proceso(TipoProceso)
{
	var f = document.frmPrincipal;
	switch(TipoProceso)
	{
		case "C":
			if(f.CmbProveedor.value=='-1')
			{
				alert("Debe seleccionar Proveedor");
				f.CmbProveedor.focus();
				return;
			}		
			if(f.Ano.value<=f.AnoFin.value)
			{
				var mesdesde=parseInt(f.Mes.value);
				var meshasta=parseInt(f.MesFin.value);
				if(f.Ano.value==f.AnoFin.value&&mesdesde>meshasta)		
				{
					alert("Mes Desde No Puede Ser Mayor a Mes Hasta");
					return;	
				}
				f.action = "pcip_rpt_facturas_compras_provision.php?Buscar=S";
				f.submit();
			}
			else
				alert("A�o Desde No Puede ser Mayor a A�o Hasta")	
		break;
		case "E"://GENERA EXCEL
			URL='pcip_rpt_facturas_compras_provision_excel.php?&CmbProveedor='+f.CmbProveedor.value+'&CmbProducto='+f.CmbProducto.value+'&CmbMostrar='+f.CmbMostrar.value+'&Ano='+f.Ano.value+'&Mes='+f.Mes.value+'&AnoFin='+f.AnoFin.value+'&MesFin='+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;				
		case "R":
			f.action = "pcip_rpt_facturas_compras_provision.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=10";
		break;
	
	}
	
}

</script>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
 <? include("encabezado.php")?>
 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\mant_rpt_facturas_compra_provision.png"></td>
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
<table width="950" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
   <tr>
      <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
      <td width="920" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
    </tr>
  <tr>
   <td  width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
   <td>
	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
	<tr>
		<td width="82%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="18%" align="right" class='formulario2'>
		<a href="JavaScript:Proceso('C')"><span class="formulario2"></span></a><a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> 
		<a href="JavaScript:Proceso('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
		<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">	
<tr>
	<td width="159" height="17" class='formulario2'>Rut&nbsp;Proveedor</td>
	<td width="225"  class="formulario2" ><select name="CmbProveedor" onChange="Proceso('R')">
	<option value="-1" selected="selected">Seleccionar</option>
	<?
	$Consulta = "select rut_proveedor,nom_proveedor from pcip_fac_proveedores order by rut_proveedor ";			
	$Resp=mysql_query($Consulta);
	while ($FilaTC=mysql_fetch_array($Resp))
	{
		if ($CmbProveedor==$FilaTC["rut_proveedor"])
			echo "<option selected value='".$FilaTC["rut_proveedor"]."'>".str_pad($FilaTC["rut_proveedor"],10,'0',STR_PAD_LEFT)." ".$FilaTC["nom_proveedor"]."</option>\n";
		else
			echo "<option value='".$FilaTC["rut_proveedor"]."'>".str_pad($FilaTC["rut_proveedor"],10,'0',STR_PAD_LEFT)." ".$FilaTC["nom_proveedor"]."</option>\n";
	}
		?>
	</select>	</td>
   <td width="54" class="formulario2">&nbsp;&nbsp;Producto</td>
   <td width="464" class="formulariosimple" >
   <select name="CmbProducto" >
   <option value="T" class="NoSelec">Todos</option>
		   <?
			$Consulta = "select t1.cod_producto,t2.nom_producto from pcip_fac_productos_por_proveedores t1";
			$Consulta.= " inner join pcip_fac_productos_facturas t2 on t1.cod_producto=t2.cod_producto where t1.rut_proveedor='".$CmbProveedor."'";			
			$Resp=mysql_query($Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbProducto==$FilaTC["cod_producto"])
					echo "<option selected value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
				else
					echo "<option value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
			}
		   ?>
   </select>
   <?  //echo $Consulta; ?>   </td>	
   </tr>		
	<tr>
	   <td width="159" class="formulario2">Mostrar Por</td>
	   <td class="formulariosimple" colspan="7">
	   <select name="CmbMostrar">
	   <option value="T" class="NoSelec">Todos</option>
		   <?
			$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31012' and cod_subclase in ('1','2','3')";			
			$Resp=mysql_query($Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbMostrar==$FilaTC["cod_subclase"])
					echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
		   ?>
	   </select>
	   <?  //echo $Consulta; ?>   
	   </td>			
	</tr>	 
  <tr>
    <td height="25" class='formulario2'>Periodo</td>
	<td class='formulario2' colspan="6">
	&nbsp;Desde
      <select name="Ano" id="select">
		<?
		for ($i=2003;$i<=date("Y");$i++)
		{
			if ($i==$Ano)
				echo "<option selected value=\"".$i."\">".$i."</option>\n";
			else
				echo "<option value=\"".$i."\">".$i."</option>\n";
		}
		?>
       </select>
      <select name="Mes" id="Mes">
		<?
		for ($i=1;$i<=12;$i++)
		{
			if ($i==$Mes)
				echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
			else
				echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		}
		?>
       </select>
		Hasta
		<select name="AnoFin">
		<?
		for ($i=2003;$i<=date("Y");$i++)
		{
			if ($i==$AnoFin)
				echo "<option selected value=\"".$i."\">".$i."</option>\n";
			else
				echo "<option value=\"".$i."\">".$i."</option>\n";
		}
		?>
		</select>
		<select name="MesFin">
		<?
		for ($i=1;$i<=12;$i++)
		{
			if ($i==$MesFin)
				echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
			else
				echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		}
		?>
		</select></td>
    </tr>
 </table>  
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br>
    <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
      <tr>
        <td ><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
        <td width="935" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
        <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
      </tr>
      <tr>
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td>
		<table width="100%"  border="1" cellpadding="2" cellspacing="0" > 		
		<? 
		if($Buscar=='S')
		{
			$TOTALES=0;
			if($Mes<10)
				$Mes="0".$Mes;
			if($MesFin<10)
				$MesFin="0".$MesFin;
			$FechaDesde=$Ano."-".$Mes."-01";
			$FechaHasta=$AnoFin."-".$MesFin."-31";
			$ContMeses=intval(resta_fechas($FechaHasta,$FechaDesde)/30);
			
			$Consulta="select t3.cod_subclase,t3.nombre_subclase from  pcip_fac_compra t1 ";
			$Consulta.=" inner join pcip_fac_compra_finos t2 on t1.codigo=t2.codigo ";
			$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31012' and t2.cod_fino=t3.cod_subclase and t3.cod_subclase in('1','2','3')";
			$Consulta.=" where t1.rut_proveedor<>'' ";
			if($CmbMostrar!='T')
				$Consulta.=" and t3.cod_subclase='".$CmbMostrar."'";
			if($CmbProveedor!='-1')
				$Consulta.=" and t1.rut_proveedor='".$CmbProveedor."'";
			if($CmbProducto!='T')
				$Consulta.=" and t1.cod_producto='".$CmbProducto."'";
			$Consulta.=" and t1.estado_actual='1'";
			$Consulta.=" and t1.fecha_emision BETWEEN '".$FechaDesde."' and '".$FechaHasta."'";
			$Consulta.=" group by t3.cod_subclase";			
			$Resp=mysql_query($Consulta);$ArrayTot=array();				
			//echo $Consulta."<br>";
			while($Fila=mysql_fetch_array($Resp))
			{
				$Fino=$Fila["cod_subclase"];
				$NomFino=$Fila["nombre_subclase"];
				MuestraFino($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbProducto,$NomFino,$Meses,$MesFin); 
				MuestraMeses($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbProducto,$Meses);
				MuestraFactura($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbProducto);
				MuestraPrecio($Ano,$Mes,$ContMeses,$NomFino,$Fino,$CmbProveedor,$CmbProducto,&$ArrayTot);
				MuestraPagable($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbProducto,'2',$NomFino,&$ArrayTot);
				MuestraMesPago($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbProducto,$Meses);
				MuestraPrecioPago($Ano,$Mes,$ContMeses,$Fino,$CmbProveedor,$CmbProducto,$Meses,$NomFino,&$ArrayTot);
				MuestraValorFactura($ArrayTot);
				MuestraValorLiquidacion($ArrayTot);
				MuestraDebCred($ArrayTot);
				reset($ArrayTot);
				while(list($c,$v)=each($ArrayTot))
				{
					$ArrayTot[$c][0]=0;
					$ArrayTot[$c][1]=0;
					$ArrayTot[$c][2]=0;
				}		
			}
		}			 
		?>			
		</table></td>
			<td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
			<td height="15"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
			<td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
		  </tr>
    </table></td>
 </tr>
  </table>
	<? include("pie_pagina.php")?>

</form>
</body>
</html>
<?
function MuestraFino($Ano,$Mes,$ContMeses,$Fino,$Prv,$CodProd,$NomFino,$Meses,$MesFin)
{
	$CantCol=1;
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		$CantCol=$CantCol+RetornaColSpan($Fino,$Prv,$CodProd,$FechaInicio,$FechaFin);		 	
		$k=$k+1;
	}
	$FechaFactura=explode('-',$FechaFin);
	$FechaAVencer=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1]),$FechaFactura[2],$FechaFactura[0]));
	$FechaAVencer=explode('-',$FechaAVencer);
	echo "<tr><td align='center' class='TituloTablaVerde' colspan='".$CantCol."'>".$NomFino."</td>";
	echo "<td align='center' class='TituloTablaVerde'>Provisi&oacute;n a ".$Meses[intval($FechaAVencer[1])-1]."&nbsp;".$Anodesde."</td>";
	echo "</tr>";
}

function MuestraMeses($Ano,$Mes,$ContMeses,$Fino,$Prv,$CodProd,$Meses)
{
	echo "<tr><td class='FilaAbeja2'>Mes Entrega</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		$CantCol=RetornaColSpan($Fino,$Prv,$CodProd,$FechaInicio,$FechaFin);
		$k=$k+1;
		if($CantCol!=0)
		{
		?>
		<td align="center" colspan="<? echo $CantCol;?>" class="<? echo $Clase;?>"> <? echo $Meses[$k]."&nbsp;".$Anodesde; ?></td>
		<?
		}
	}
		echo "<td align='center'>&nbsp;</td>";
	echo "</tr>"; 

}
function MuestraFactura($Ano,$Mes,$ContMeses,$Fino,$Prv,$CodProd)
{
	echo "<tr><td class='FilaAbeja2'>Facturas</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";

		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		$k=$k+1;
		
		$Consulta1 ="select distinct num_factura from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
			$Consulta1.=" and t1.cod_producto='".$CodProd."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{			     
			$Facturas=$Fila1[num_factura];			
			//echo $Facturas."<br>";
			echo "<td align='center' class=".$Clase.">".$Facturas."</td>";
		}			
	}
			echo "<td align='center' class=".$Clase.">&nbsp;</td>";
	echo "</tr>"; 
}

function RetornaColSpan($Fino,$Prv,$CodProd,$FechaInicio,$FechaFin)
{
	//COLSPAN PARA LOS MESES
	$Cant=0;
	$Consulta1 ="select distinct num_factura from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
	$Consulta1.=" on t1.codigo=t2.codigo where rut_proveedor<>'' and t2.cod_fino='".$Fino."'";//estado_actual='1'";
	if($Prv!='-1')
		$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
	if($CodProd!='T')
		$Consulta1.=" and t1.cod_producto='".$CodProd."'";
	$Consulta1.=" and t1.estado_actual='1'";
	$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
	$Resp1=mysql_query($Consulta1);				
	//echo $Consulta1."<br><br>";
	while($Fila1=mysql_fetch_array($Resp1))
		$Cant++;
	return($Cant);
}

function MuestraPrecio($Ano,$Mes,$ContMeses,$NomFino,$Fino,$Prv,$CodProd,$ArrayTot)
{
   	echo "<tr><td class='FilaAbeja2'>Precio ".$NomFino." (US$/TMS)</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		$k=$k+1;
							
		$Consulta1 ="select distinct num_factura,fecha_emision from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
			$Consulta1.=" and t1.cod_producto='".$CodProd."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{	
			$Facturas=$Fila1[num_factura];			
			$AnoPrecio=substr($Fila1[fecha_emision],0,4);
			$MesPrecio=intval(substr($Fila1[fecha_emision],5,2));	
			$ConsultaPrecio=" select valor from pcip_fac_compra_precios where ano='".$AnoPrecio."' and mes='".$MesPrecio."' and cod_fino='".$Fino."'";
			$RespPrecio=mysql_query($ConsultaPrecio);
			//echo $ConsultaPrecio."<br>";
			if($FilaPrecio=mysql_fetch_array($RespPrecio))
				$Precio=$FilaPrecio[valor];	
			else
				$Precio="";
			//echo $Facturas."<br>";
			$ArrayTot[$Fila1[num_factura]][0]=$Precio;
			echo "<td  align='right' class=".$Clase.">".number_format($Precio,2,',','.')."</td>";
		}
	}	
			echo "<td align='center' class=".$Clase.">&nbsp;</td>";
	echo "</tr>"; 
}

function MuestraPagable($Ano,$Mes,$ContMeses,$Fino,$Prv,$CodProd,$Pagable,$NomFino,$ArrayTot)
{
    echo "<tr><td class='FilaAbeja2'>Pagable ".$NomFino." (TMF)</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
			
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";
		$k=$k+1;	
		
		$Consulta1 ="select distinct num_factura,fecha_emision from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
			$Consulta1.=" and t1.cod_producto='".$CodProd."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{					    
			$ConsultaPagable ="select t2.valor from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
			$ConsultaPagable.=" on t1.codigo=t2.codigo where t1.rut_proveedor<>'' and t1.num_factura='".$Fila1[num_factura]."' and t2.cod_fino='".$Fino."' and cod_contenido='".$Pagable."'";
			if($Prv!='-1')
				$ConsultaPagable.=" and t1.rut_proveedor='".$Prv."'";
			if($CodProd!='T')
				$ConsultaPagable.=" and t1.cod_producto='".$CodProd."'";
			$ConsultaPagable.=" and t1.estado_actual='1'";
			$ConsultaPagable.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
			$ConsultaPagable.=" group by t1.codigo";
			$RespPagable=mysql_query($ConsultaPagable);				
			//echo $ConsultaPagable."<br>";
			if($FilaPagable=mysql_fetch_array($RespPagable))
				$ValorPagable=$FilaPagable[valor];
			$ArrayTot[$Fila1[num_factura]][1]=$ValorPagable;	
			echo "<td class=".$Clase." align='right'>".number_format($ValorPagable,2,',','.')."</td>";
		}
 	}
			echo "<td align='center' class=".$Clase.">&nbsp;</td>";			
	echo "</tr>";
}

function MuestraMesPago($Ano,$Mes,$ContMeses,$Fino,$Prv,$CodProd,$Meses)
{
    echo "<tr><td class='FilaAbeja2'>Mes Pago</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";

		$Consulta1 ="select distinct t1.num_factura,t1.fecha_emision,t1.tipo as TipoCtto,t3.acuerdo_contractual_au,t3.acuerdo_contractual_cu from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo inner join pcip_fac_contratos_compra t3 on t1.cod_contrato=t3.cod_contrato";
		$Consulta1.=" where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
			$Consulta1.=" and t1.cod_producto='".$CodProd."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{	
		   	
			if($Fila1[TipoCtto]=='2')//MAQUILA
				$Acuerdo=intval($Fila1["acuerdo_contractual_au"]);
			else
				$Acuerdo=intval($Fila1["acuerdo_contractual_cu"]);
				
			$FechaFactura=explode('-',$Fila1[fecha_emision]);
			$FechaPago=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1])+$Acuerdo,$FechaFactura[2],$FechaFactura[0]));
			$FechaPago=explode('-',$FechaPago);			
			$AnoPago=$FechaPago[0];
			$MesPago=intval($FechaPago[1]);
			echo "<td  align='center' class=".$Clase.">".$Meses[$MesPago]."&nbsp;".$AnoPago."</td>";
		}		
		$k=$k+1;	
	}			
			echo "<td align='center' class=".$Clase.">&nbsp;</td>";			
	echo "</tr>";

}

function MuestraPrecioPago($Ano,$Mes,$ContMeses,$Fino,$Prv,$CodProd,$Meses,$NomFino,$ArrayTot)
{
    echo "<tr><td class='formulario4'>Precio ".$NomFino."</td>";
	$Anodesde=$Ano;
	$a=intval($Mes);
	$Aux=$a+$ContMeses;
	$k=$a-1;$Clase='';
	for($i=$a;$i<$Aux;$i++)
	{
		if($k>=12)
		{
			$k=0;
			$Anodesde=$Ano+1;
		}
		if($Clase=="TituloCabeceraOz")
			$Clase="TituloCabeceraOz";
		else
			$Clase="TituloCabeceraOz";
		$FechaInicio=$Anodesde."-".($k+1)."-1";
		$FechaFin=$Anodesde."-".($k+1)."-31";

		$Consulta1 ="select distinct t1.num_factura,t1.fecha_emision,t1.tipo as TipoCtto,t3.acuerdo_contractual_au,t3.acuerdo_contractual_cu from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
		$Consulta1.=" on t1.codigo=t2.codigo inner join pcip_fac_contratos_compra t3 on t1.cod_contrato=t3.cod_contrato";
		$Consulta1.=" where t1.rut_proveedor<>'' and t2.cod_fino='".$Fino."'";
		if($Prv!='-1')
			$Consulta1.=" and t1.rut_proveedor='".$Prv."'";
		if($CodProd!='T')
			$Consulta1.=" and t1.cod_producto='".$CodProd."'";
		$Consulta1.=" and t1.estado_actual='1'";
		$Consulta1.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' and '".$FechaFin."'";
		$Consulta1.=" group by t1.codigo";
		$Resp1=mysql_query($Consulta1);				
		//echo $Consulta1."<br>";
		while($Fila1=mysql_fetch_array($Resp1))
		{	
			if($Fila1[TipoCtto]=='2')//MAQUILA
				$Acuerdo=intval($Fila1["acuerdo_contractual_au"]);
			else
				$Acuerdo=intval($Fila1["acuerdo_contractual_cu"]);
				   					
			$FechaFactura=explode('-',$Fila1[fecha_emision]);
			$FechaPago=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1])+$Acuerdo,$FechaFactura[2],$FechaFactura[0]));
			$FechaPago=explode('-',$FechaPago);			            					
			$AnoPrecio=$FechaPago[0];
			$MesPrecio=intval($FechaPago[1]);	
			$ConsultaPrecio=" select valor from pcip_fac_compra_precios where ano='".$AnoPrecio."' and mes='".$MesPrecio."' and cod_fino='".$Fino."'";
			$RespPrecio=mysql_query($ConsultaPrecio);
			//echo $ConsultaPrecio."<br>";
			if($FilaPrecio=mysql_fetch_array($RespPrecio))
				$PrecioPago=$FilaPrecio[valor];	
			else
				$PrecioPago="";
			$ArrayTot[$Fila1[num_factura]][2]=$PrecioPago;	
			//echo $Facturas."<br>";
			echo "<td  align='right' class='formulario4'>".number_format($PrecioPago,2,',','.')."</td>";
		}			
		$k=$k+1;
	}	
			echo "<td  align='right' class='formulario4'>&nbsp;</td>";
	echo "</tr>";		
}

function MuestraValorFactura($ArrayTot)
{
	echo "<tr><td class='FilaAbeja2'>Valor Factura</td>";

	if($Clase=="TituloCabeceraOz")
		$Clase="TituloCabeceraOz";
	else
		$Clase="TituloCabeceraOz";		
	reset($ArrayTot);
	while(list($c,$v)=each($ArrayTot))
	{
	    $ValorFactura=$ArrayTot[$c][0]*$ArrayTot[$c][1];
		echo "<td  align='right' class=".$Clase.">".number_format($ValorFactura,2,',','.')."</td>";
		
	    $ValorEstimado=$ValorEstimado+$ValorFactura;
	}	    
		echo "<td align='center' class=".$Clase.">".number_format($ValorEstimado,2,',','.')."</td>";		
	echo "</tr>";
}

function MuestraValorLiquidacion($ArrayTot)
{
	echo "<tr><td class='FilaAbeja2'>Valor Liquidaci�n</td>";

	if($Clase=="TituloCabeceraOz")
		$Clase="TituloCabeceraOz";
	else
		$Clase="TituloCabeceraOz";		
	reset($ArrayTot);
	while(list($c,$v)=each($ArrayTot))
	{
	    $ValorLiquidacion=$ArrayTot[$c][1]*$ArrayTot[$c][2];
		echo "<td  align='right' class=".$Clase.">".number_format($ValorLiquidacion,2,',','.')."</td>";
		
		$ValorEstimadoLiqui=$ValorEstimadoLiqui+$ValorLiquidacion;
	}
		echo "<td align='center' class=".$Clase.">".number_format($ValorEstimadoLiqui,2,',','.')."</td>";
	echo "</tr>";
}

function MuestraDebCred($ArrayTot)
{
	echo "<tr><td class='formulario4'>DEB/CREDITO</td>";

	if($Clase=="TituloCabeceraOz")
		$Clase="TituloCabeceraOz";
	else
		$Clase="TituloCabeceraOz";
	reset($ArrayTot);
	while(list($c,$v)=each($ArrayTot))
	{
		$ValorFact=$ArrayTot[$c][0]*$ArrayTot[$c][1];
		$ValorLiq=$ArrayTot[$c][1]*$ArrayTot[$c][2];
		$DecCred=$ValorFact-$ValorLiq;
		echo "<td  align='right' class='formulario4'>".number_format($DecCred,2,',','.')."</td>";
		
		$ValorEstimadoDebCred=$ValorEstimadoDebCred+$DecCred;
	}
		echo "<td align='center' class='formulario4'>".number_format($ValorEstimadoDebCred,2,',','.')."</td>";
	echo "</tr>";
}

?>