<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbMostrar))
	$CmbMostrar='P';			
?>
<html>
<head>
<title>Reporte Balance</title>
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

function Procesos(TipoProceso)
{
	var f = document.frmPrincipal;
	var Agrupados='N';
	switch(TipoProceso)
	{
		case "C"://BUSCA DISPONIBILIDAD EQUIPOS
			if(f.CmbProducto.value=='-1')
			{
				alert("Debe seleccionar Producto");
				f.CmbProducto.focus();
				Res=false;
				return;
			}
			if(f.CmbNegocio.value=='-1')
			{
				alert("Debe seleccionar Negocio");
				f.CmbNegocio.focus();
				Res=false;
				return;
			}
			f.action = "pcip_rpt_balance_mensual_nuevo_svp.php?Buscar=S";
			f.submit();
		break;
		case "E":
			URL='pcip_rpt_balance_mensual_nuevo_svp_excel.php?CmbProducto='+f.CmbProducto.value+"&CmbNegocio="+f.CmbNegocio.value+"&CmbTitulo="+f.CmbTitulo.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_balance_mensual_nuevo_svp.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=8";
		break;
	
	}
	
}

</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 11px}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'balance_mensual.png')
?>
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
		<td width="81%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="19%" align="right" class='formulario2'>
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span></a>
		<a href="JavaScript:Procesos('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> <a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td width="16%" height="17" class='formulario2'>Producto</td>
    <td width="84%" class="formulario2" >
	<select name="CmbProducto">
        <option value="-1" selected="selected">Seleccionar</option>
        <?
	    $Consulta = "select distinct t2.nombre_subclase,t2.cod_subclase from pcip_svp_balance_mensual t1 inner join proyecto_modernizacion.sub_clase t2 where t2.cod_clase='31054'";			
		$Consulta.= " and t1.cod_producto=t2.cod_subclase";
		$Resp=mysql_query($Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbProducto==$Fila["cod_subclase"])
				echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
		}
		?>
      </select></td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Negocio</td>
    <td class="formulario2" >
	<select name="CmbNegocio" onChange="Procesos('R')">
      <option value="-1" selected="selected">Seleccionar</option>
      <?
	    $ConsultaN = "select  distinct t2.nombre_subclase,t2.cod_subclase from pcip_svp_balance_mensual t1 inner join proyecto_modernizacion.sub_clase t2 where t2.cod_clase='31056'";			
		$ConsultaN.= " and t1.cod_negocio=t2.cod_subclase";
		$RespN=mysql_query($ConsultaN);
		while ($FilaN=mysql_fetch_array($RespN))
		{
			if ($CmbNegocio==$FilaN["cod_subclase"])
				echo "<option selected value='".$FilaN["cod_subclase"]."'>".ucfirst($FilaN["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaN["cod_subclase"]."'>".ucfirst($FilaN["nombre_subclase"])."</option>\n";
		}
			?>
    </select></td>
  </tr>
	 <tr>
	   <td height="25" class="formulario2">Titulos</td>
	   <td class="FilaAbeja2">
	   <select name="CmbTitulo">
		<option value="T" selected="selected">Todos</option>			 
		<?
	    $Consulta = "select  distinct t2.nombre_subclase,t2.cod_subclase from pcip_svp_balance_mensual t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31057'";			
		$Consulta.= " and t1.cod_titulo=t2.cod_subclase where valor_subclase1='".$CmbNegocio."'";
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTitulo==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
		?>
	   </select>
		</td>
	 </tr>		 
  <tr>
    <td height="25" class='formulario2'>Periodo</td>
    <td class='formulario2'>A&ntilde;o
      <select name="Ano" id="Ano">
      <?
		for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
		{
			if ($i==$Ano)
				echo "<option selected value=\"".$i."\">".$i."</option>\n";
			else
				echo "<option value=\"".$i."\">".$i."</option>\n";
		}
	  ?>
    </select>
      Mes 
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
  </tr>
 </table>  </td>
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
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0" >
		  <?
		  	if($Buscar=='S')
			{	
				$Consulta = "select * from pcip_svp_balance_mensual t1";			
				$Consulta.=" left join pcip_svp_ordenesproduccion t2 on t1.orden=t2.OPorden where orden<>''";
				if($CmbProducto!='-1')
					$Consulta.= " and t1.cod_producto='".$CmbProducto."'";	
				if($CmbNegocio!='-1')
					$Consulta.= " and t1.cod_negocio='".$CmbNegocio."'";
				if($CmbTitulo!='T')
					$Consulta.= " and t1.cod_titulo='".$CmbTitulo."'";
				$Consulta.= "  order by orden ";		
				$RespBal=mysql_query($Consulta);
				while ($FilaBal=mysql_fetch_array($RespBal))
				{
					echo "<tr class='TituloTablaNaranja'>";
						echo "<td align='center' colspan='3' >F".$FilaBal[orden]."&nbsp;".$FilaBal[OPdescripcion]."</td>";
					echo "</tr>";
					//CONSULTA TIPOS INICIALES NOMBRES SUBCLASE
					$ConsultaInv=" select * from proyecto_modernizacion.sub_clase where cod_clase='31058'";
					$RespInv=mysql_query($ConsultaInv);
					while($FilaInv=mysql_fetch_array($RespInv))
					{
						echo "<tr>";
							if($FilaInv["cod_subclase"]==1)
							{
								echo "<td align='left' class='pie_tabla_bold'>".$FilaInv["nombre_subclase"]."</td>";
								echo "<td align='center' class='pie_tabla_bold'>Unidad [TMF]</td>";
								echo "<td align='center' class='pie_tabla_bold'>Costo [US$]</td>";
							}
							else
								echo "<td align='left' colspan='3' class='pie_tabla_bold'>".$FilaInv["nombre_subclase"]."</td>";
						echo "</tr>";
						$VPTM=explode(",",$FilaInv["valor_subclase1"]);
						while(list($c,$v)=each($VPTM))
						{
							if($v==1)//Vptm 1 que extraera los valores de los VPTM 25 de mes pasado
							{
								$ConsultaVptm=" select* from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
								$RespVptm=mysql_query($ConsultaVptm);
								if($FilaVptm=mysql_fetch_array($RespVptm))
								{	
									$NomVPTM=$FilaVptm["nombre_subclase"];
									echo "<tr class='texto_bold'>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									$MesMenos=$Mes-1;
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_tiposinventarios t3 on t1.VPtipinv=t3.TIcodigo";
									$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$MesMenos."' and VPtm='25' ";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
									//CONSULTA VPTM NOMBRES SUBCLASE
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[TIdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
							if($v==4||$v==5)//Tratado o Ajuste VPTM sin Material o Tipo inventario
							{
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								//echo $Consulta2."<br>";
								$Resp2=mysql_query($Consulta2);
								while($Fila2=mysql_fetch_array($Resp2))
								{	
									//CONSULTA VPTM NOMBRES SUBCLASE
									$ConsultaVptm=" select * from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
									$RespVptm=mysql_query($ConsultaVptm);
									if($FilaVptm=mysql_fetch_array($RespVptm))
									{	
										$NomVPTM=$FilaVptm["nombre_subclase"];
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;".$NomVPTM."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
							if($FilaInv["cod_subclase"]=='2')//recibidos
							{
								if($v==6)//ordenes anteriores
								{
									$NomVPTM="Ordenes Anteriores";
									echo "<tr class='texto_bold'>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
									$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPorden=t3.OPorden";
									$Consulta2.=" where VPordenrel='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='11'";
									//echo $Consulta2."<br>";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPorden]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}	
								}
								if($v==12)//ajuste ordenes anteriores
								{
									$NomVPTM="Ajuste Ordenes Anteriores";
									echo "<tr class='texto_bold'>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
									$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPorden=t3.OPorden";
									$Consulta2.=" where VPordenrel='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='12'";
									//echo $Consulta2."<br>";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPorden]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}	
								}
								if($v==8||$v==9)//Recirculados con y sin ajuste
								{
									if($v==8)												
										$NomVPTM="Recirculados";
									else
										$NomVPTM="Recirculados Ajuste";
									echo "<tr class='texto_bold'>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
									$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPordenrel=t3.OPorden";
									$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
									//echo $Consulta2."<br>";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPordenrel]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}	
								}
							}
							if($v==13||$v==14)//Recirculados
							{
								if($v==13)	
								{
									$v=8;											
									$NomVPTM="Recirculados";
								}
								else
								{
									$v=9;
									$NomVPTM="Recirculados Ajuste";
								}
								echo "<tr class='texto_bold'>";
									echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
								echo "</tr>";
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
								$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPorden=t3.OPorden";
								$Consulta2.=" where VPordenrel='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								//echo $Consulta2."<br>";
								$Resp2=mysql_query($Consulta2);
								if($Fila2=mysql_fetch_array($Resp2))
								{	
									echo "<tr>";
										echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPorden]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
										echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
										echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
									echo "</tr>";
									$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
									$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
								}	
							}
							if($v==11||$v==12)//VPTM 
							{
								if($v==11)												
									$NomVPTM="A Ordenes Siguientes";
								else
									$NomVPTM="A Ordenes Siguientes Ajuste";	
								echo "<tr class='texto_bold'>";
									echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
								echo "</tr>";
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" left join pcip_svp_materiales t2 on t1.VPmaterial=t2.MAcodigo";
								$Consulta2.=" left join pcip_svp_ordenesproduccion t3 on t1.VPordenrel=t3.OPorden";
								$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								//echo $Consulta2."<br>";
								$Resp2=mysql_query($Consulta2);
								while($Fila2=mysql_fetch_array($Resp2))
								{	
									echo "<tr>";
										echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[VPordenrel]."&nbsp;".$Fila2[OPdescripcion]."&nbsp;&nbsp;&nbsp;   Material:  ".$Fila2[MAdescripcion]."</td>";										
										echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
										echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
									echo "</tr>";
									$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
									$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
								}	
							}
							if($v==21||$v==22)//VPTM 8 y sus materiales
							{
								if($v==21)												
									$NomVPTM="Consumo Interno";
								else
								   	$NomVPTM="Consumo Interno Ajuste";
								echo "<tr class='texto_bold'>";
									echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
								echo "</tr>";
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" left join pcip_svp_ordenesdestino t3 on t1.VPordes=t3.ODorden";
								$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								//echo $Consulta2."<br>";
								$Resp2=mysql_query($Consulta2);
								while($Fila2=mysql_fetch_array($Resp2))
								{	
									echo "<tr>";
										echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[ODorden]."&nbsp;".ucfirst($Fila2[ODdescripcion])."&nbsp;</td>";										
										echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
										echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
									echo "</tr>";
									$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
									$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
								}	
							}
							if($v==24)//24 vptm.
							{
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								$Resp2=mysql_query($Consulta2);
								if($Fila2=mysql_fetch_array($Resp2))
								{	
									//CONSULTA VPTM NOMBRES SUBCLASE
									$ConsultaVptm=" select * from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
									$RespVptm=mysql_query($ConsultaVptm);
									if($FilaVptm=mysql_fetch_array($RespVptm))
									{	
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;P&eacute;rdidas</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
							if($v==15||$v==16)//15 16.
							{
								$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
								$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."'";
								$Resp2=mysql_query($Consulta2);
								if($Fila2=mysql_fetch_array($Resp2))
								{	
									//CONSULTA VPTM NOMBRES SUBCLASE
									$ConsultaVptm=" select * from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
									$RespVptm=mysql_query($ConsultaVptm);
									if($FilaVptm=mysql_fetch_array($RespVptm))
									{	
										if($v==15)
											$NomVPtm="A Ventas";
										else
											$NomVPtm="A Ventas Ajuste";	
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;".$NomVPtm."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
							if($v==25)//Vptm ! que extraera los valores de los VPTM 25 de mes pasado
							{
								$ConsultaVptm=" select* from proyecto_modernizacion.sub_clase where cod_clase='31059' and valor_subclase1='".$v."'";
								$RespVptm=mysql_query($ConsultaVptm);
								if($FilaVptm=mysql_fetch_array($RespVptm))
								{	
									$NomVPTM=$FilaVptm["nombre_subclase"];
									echo "<tr class='texto_bold'>";
										echo "<td align='left' colspan='3'>&nbsp;&nbsp;".$NomVPTM."</td>";										
									echo "</tr>";
									
									$MesMenos=$Mes-1;
									$Consulta2=" select * from pcip_svp_valorizacproduccion t1 ";
									$Consulta2.=" left join pcip_svp_tiposinventarios t3 on t1.VPtipinv=t3.TIcodigo";
									$Consulta2.=" where VPorden='".$FilaBal[orden]."' and VPa�o='".$Ano."' and VPmes='".$Mes."' and VPtm='".$v."' ";
									$Resp2=mysql_query($Consulta2);
									while($Fila2=mysql_fetch_array($Resp2))
									{	
									//CONSULTA VPTM NOMBRES SUBCLASE
										echo "<tr>";
											echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;".$Fila2[TIdescripcion]."</td>";										
											echo "<td align='right'>".$Fila2[VPcantidad]."</td>";
											echo "<td align='right'>".$Fila2[VPvalor]."</td>";										
										echo "</tr>";									
										$ArrCantidad[0]=$ArrCantidad[0]+$Fila2[VPcantidad];
										$ArrValor[0]=$ArrValor[0]+$Fila2[VPvalor];
									}
								}	
							}
						}
						$TotalCantidad=$ArrCantidad[0];
						$TotalValor=$ArrValor[0];
						echo "<tr class='TitulotablaVerde'>";//total
							echo "<td align='left'>Totales&nbsp;".$FilaInv["nombre_subclase"]."</td>";										
							echo "<td align='right'>".number_format($TotalCantidad,2,',','.')."</td>";
							echo "<td align='right'>".number_format($TotalValor,2,',','.')."</td>";										
						echo "</tr>";	
						$ArrCantidad[0]=0;
						$ArrValor[0]=0;								
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