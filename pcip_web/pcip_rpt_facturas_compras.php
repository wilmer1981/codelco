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
<title>Consulta Facturas</title>
<style type="text/css">
s
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
		        if(f.CmbTipo.value=='1' && f.CmbFactura.value=='-1')
				{
					alert("Debe seleccionar un Tipo Factura");
					f.CmbFactura.focus();
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
					var OptInfChecked='';
					for(i=0;i<=6;i++)
					{
						if(f.OptInf[i].checked==true)
							OptInfChecked=OptInfChecked+f.OptInf[i].value+"~";
					}
					if(OptInfChecked!='')
						OptInfChecked=OptInfChecked.substr(0,OptInfChecked.length-1);
					f.action = "pcip_rpt_facturas_compras.php?Buscar=S&OptInfChecked="+OptInfChecked;
					f.submit();
				}
				else
					alert("A�o Desde No Puede ser Mayor a A�o Hasta")	
		break;
		case "E"://GENERA EXCEL
			var OptInfChecked='';var Factura='';var DeCre='';
			for(i=0;i<=6;i++)
			{
				if(f.OptInf[i].checked==true)
					OptInfChecked=OptInfChecked+f.OptInf[i].value+"~";
			}
			if(OptInfChecked!='')
			if(f.CmbTipo.value=='1')
			     Factura=f.CmbFactura.value;
			if(f.CmbTipo.value=='2')
			     DeCre=f.CmbDeCre.value;
				OptInfChecked=OptInfChecked.substr(0,OptInfChecked.length-1);
			URL='pcip_rpt_facturas_compras_excel.php?&CmbContrato='+f.CmbContrato.value+'&CmbTipo='+f.CmbTipo.value+'&CmbProd='+f.CmbProd.value+'&CmbDeCre='+DeCre+'&CmbFactura='+Factura+'&CmbNumFact='+f.CmbNumFact.value+'&CmbTipoContrato='+f.CmbTipoContrato.value+'&OptInfChecked='+OptInfChecked+'&Ano='+f.Ano.value+'&Mes='+f.Mes.value+'&AnoFin='+f.AnoFin.value+'&MesFin='+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;				
		case "R":
			f.action = "pcip_rpt_facturas_compras.php";
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
 <?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'mant_rpt_facturas_compra.png')
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
   <td width="73" height="17" class='formulario2'>Contrato</td>
   <td class="formulario2" colspan="7"><select name="CmbContrato" onChange="Proceso('R')">
   <option value="T" class="NoSelec">Todos</option>
   <?
   $Consulta ="select distinct t1.cod_contrato,t2.nom_cliente from pcip_fac_compra t1 inner join pcip_fac_contratos_compra t2 on t1.cod_contrato=t2.cod_contrato and t1.rut_proveedor=t2.rut_proveedor";	 	
   $Resp=mysqli_query($link, $Consulta);
   while ($Fila=mysql_fetch_array($Resp))
   {
		if ($CmbContrato==$Fila["cod_contrato"])
			echo "<option selected value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$Fila["nom_cliente"]."</option>\n";
		else
			echo "<option value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$Fila["nom_cliente"]."</option>\n";
   }
   ?>
   </select><? //echo $CmbContrato;?>   
   </td>
  </tr>
  <tr> 
   <td width="73" height="17" class='formulario2'>Tipo Factura</td>
   <td width="247"  class="formulario2"><select name="CmbTipo" onChange="Proceso('R')">
   <option value="T" selected="selected">Todos</option>
   <?
   $Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31018'";			
   $Resp=mysqli_query($link, $Consulta);
   while ($Fila=mysql_fetch_array($Resp))
	   {
		if ($CmbTipo==$Fila["cod_subclase"])
			echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
		else
			echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
	   }	
   ?>
   </select><? //echo $CmbTipo;?>
    <?
	  if($CmbTipo=='1')
	  {
	?>
     <select name="CmbFactura">
       <option value="T" selected="selected">Todos</option>
       <?
	   $Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31031'";			
	   $Resp=mysqli_query($link, $Consulta);
	   while ($Fila=mysql_fetch_array($Resp))
		   {
			if ($CmbFactura==$Fila["cod_subclase"])
				echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
		   }	
	   ?>
     </select> <? //echo $CmbFactura;?>
	<?
	 }
	?>   
    <?
	  if($CmbTipo=='2')
	  {
	?>
		<select name="CmbDeCre">
       <option value="T" selected="selected">Todos</option>
		  <?
		switch($CmbDeCre)
		{
			case "1":
				echo "<option value='1' selected>Debito</option>";
				echo "<option value='2'>Credito</option>";
			break;
			case "2":
				echo "<option value='1'>Debito</option>";
				echo "<option value='2' selected>Credito</option>";
			break;
			default:
				echo "<option value='1'>Debito</option>";
				echo "<option value='2'>Credito</option>";
			break;	
		}
		?>
		</select><? //echo $CmbDeCre;?>
	<?
	 }
	?>   
	 </td>
	
    <td width="90" height="17" class='formulario2'>Numero&nbsp;Factura </td>
    <td width="89" class="formulario2"><select name="CmbNumFact" onChange="Proceso('R')">
	<option value="T" class="NoSelec">Todos</option>
	<?
	$Consulta = "select t1.num_factura from pcip_fac_compra t1  ";
	$Resp=mysqli_query($link, $Consulta);		
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($CmbNumFact==$Fila["num_factura"])
			echo "<option selected value='".$Fila["num_factura"]."'>".ucfirst(strtolower($Fila["num_factura"]))."</option>\n";
		else
			echo "<option value='".$Fila["num_factura"]."'>".ucfirst(strtolower($Fila["num_factura"]))."</option>\n";
	}
	?>
	</select><? //echo $Consulta;?>    
	</td>
   <td width="117"  class="formulario2" >Producto Minero</td>  
   <td width="98" height="17" class='formulario2'><select name="CmbProd" onChange="Proceso('R')">
     <option value="T" class="NoSelec">Todos</option>
       <?
	   $Consulta = "select cod_producto,nom_producto from pcip_fac_productos_facturas";
	   $Resp=mysqli_query($link, $Consulta);
	   while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$Fila["cod_producto"])
				echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst(strtolower($Fila["nom_producto"]))."</option>\n";
			else
				echo "<option value='".$Fila["cod_producto"]."'>".ucfirst(strtolower($Fila["nom_producto"]))."</option>\n";
		}
	   ?>
   </select></td>	
	<td width="87" class="formulario2">Tipo Contrato</td>
	<td width="85" class="formulariosimple" >
	<select name="CmbTipoContrato" onChange="Proceso('R')">
	<option value="T" class="NoSelec">Todos</option>
	   <?
		$Consulta = "select distinct(cod_subclase),nombre_subclase from pcip_fac_compra t2 inner join";
		$Consulta.= " proyecto_modernizacion.sub_clase t1 where t1.cod_clase='31017' and t2.tipo=t1.cod_subclase";							
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoContrato==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
	   ?>
	</select>	</td>	
</tr>	
  <tr>
    <td height="25" class='formulario2'>Periodo</td>
    <td colspan="8" class='formulario2'>Desde 
	  			<select name="Ano" id="Ano">
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
      		</select>		</td> 
	 </tr>
	 <tr>
		<td width="73" height="17" class='formulario2'>Informaci�n</td>
		<td class="formulario2" colspan="7">
		<?
			$CheckCont='';$CheckDeduc='';
			$Datos=explode('~',$OptInfChecked);
			while(list($c,$v)=each($Datos))
			{
				switch($v)
				{
					case "1":
						$CheckCont='checked';
					break;
					case "2":
						$CheckFinos='checked';
					break;
					case "3":
						$CheckPrecio='checked';
					break;
					case "4":
						$CheckPagable='checked';
					break;
					case "5":
						$CheckSeco='checked';
					break;
					case "6":
						$CheckHumedo='checked';
					break;					
					case "7":
					case "8":
					case "9":
					case "10":
					case "11":
					case "12":
					case "13":
						$CheckDeduc='checked';
					break;
				}
			
			}
		?>
		 Contenido<input name="OptInf" type="checkbox" class="SinBorde" value="1" <? echo $CheckCont;?>>&nbsp;&nbsp;Finos Pagables<input name="OptInf" type="checkbox" class="SinBorde" value="2" <? echo $CheckFinos;?>>&nbsp;&nbsp;Precio<input name="OptInf" type="checkbox" class="SinBorde" value="3" <? echo $CheckPrecio;?>>
		 Pagable<input name="OptInf" type="checkbox" class="SinBorde" value="4" <? echo $CheckPagable;?>>&nbsp;&nbsp;Peso Seco<input name="OptInf" type="checkbox" class="SinBorde" value="5" <? echo $CheckSeco;?>>&nbsp;&nbsp;Peso Humedo<input name="OptInf" type="checkbox" class="SinBorde" value="6" <? echo $CheckHumedo;?>>
		 Deducciones<input name="OptInf" type="checkbox" class="SinBorde" value="7~8~9~10~11~12~13" <? echo $CheckDeduc;?>>
		</td>
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
        <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td width="7%" rowspan="3"  align="center" class="TituloTablaVerde">Fecha</td>
              <td width="6%" rowspan="3" align="center" class="TituloTablaVerde">N� Fact.</td>
              <td width="5%" rowspan="3" align="center" class="TituloTablaVerde"> NC / ND </td>
              <td width="7%" rowspan="3"  align="center" class="TituloTablaVerde">Cuota Mes </td>
              <td width="5%"  align="center" class="TituloTablaVerde" colspan="3">Fact. US$</td>
			  <?
			  if($OptInfChecked!='')
			  {
				$ContCol=1;
				$Datos=explode('~',$OptInfChecked);
				while(list($c,$v)=each($Datos))
				{
					$ContCol++;
				}
				echo "<td colspan='".($ContCol*10)."'width='5%' align='center' class='TituloTablaVerde'>Informaci�n</td>";			  
			  }
			  ?>
            </tr>
            <tr>
              <td width="5%" rowspan="2" align="center" class="TituloTablaVerde">Valor Neto</td>
              <td width="5%" rowspan="2" align="center" class="TituloTablaVerde">Iva</td>			  
              <td width="5%" rowspan="2" align="center" class="TituloTablaVerde">Total</td>
			  <?
				$Datos=explode('~',$OptInfChecked);
				while(list($c,$v)=each($Datos))
				{
				   $Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31000' and cod_subclase='".$v."'";			
				   $Resp=mysqli_query($link, $Consulta);
				   while ($Fila=mysql_fetch_array($Resp))
				   {
						if($v=='5'||$v=='6'||$v=='7'||$v=='8'||$v=='9'||$v=='10'||$v=='11'||$v=='12'||$v=='13')
							echo "<td width='5%' align='center' colspan='2' class='TituloTablaVerde'>".ucfirst($Fila["nombre_subclase"])."</td>";
						else	
							echo "<td width='5%' align='center' colspan='10' class='TituloTablaVerde'>".ucfirst($Fila["nombre_subclase"])."</td>";
				   }	
				}
			  ?>
            </tr>
            <tr>
			<?			
			if($OptInfChecked!='')
			{
				$Datos=explode('~',$OptInfChecked);
				while(list($c,$v)=each($Datos))
				{
					// echo $v."<br>";
					 if($v=='5'||$v=='6'||$v=='7'||$v=='8'||$v=='9'||$v=='10'||$v=='11'||$v=='12'||$v=='13')
					 {
					   $Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31000' and cod_subclase='".$v."'";			
					   $Resp=mysqli_query($link, $Consulta);
					   while ($Fila=mysql_fetch_array($Resp))
					   {
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>".ucfirst($Fila["nombre_subclase"])."</td>";	
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Un.</td>";
					   }	  
					 }
					 else
					 {
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Cobre</td>";	
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Un.</td>";	
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Plata</td>";
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Un.</td>";
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Oro</td>";
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Un.</td>";	
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Otros</td>";
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Un.</td>";	
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Otros 2</td>";
						  echo"<td width='5%' align='center' class='TituloTablaVerde'>Un.</td>";	
					}
				}
			}
			?>
			</tr>
            <?
		  	if($Buscar=='S')
			{   			     
			    $TotalNetoCobre=0;$TotalNetoPlata=0;$TotalNetoOro=0;
				$Consulta="select t1.cod_contrato,t1.estado_actual,t2.tipo_factura as tipo_fac,t3.tipo_factura,t1.codigo,t1.cod_producto,t1.fecha_emision,t1.num_factura,t1.cuota,t2.cod_contenido,t2.valor,t2.cod_unidad,t1.tipo as TipoCtto,";
				$Consulta.=" t3.valor_neto,t3.iva,t3.valor_total,t3.correlativo,t3.numero,t3.tipo_nota,t4.acuerdo_contractual_au,t4.acuerdo_contractual_cu ";
				$Consulta.=" from pcip_fac_compra t1 inner join pcip_fac_compra_finos t2";
				$Consulta.=" on t1.codigo=t2.codigo left join pcip_fac_compra_finos_relacion t3 on t1.codigo=t3.codigo";
				$Consulta.=" inner join pcip_fac_contratos_compra t4 on t1.cod_contrato=t4.cod_contrato";				
				$Consulta.=" where t1.cod_contrato<>'' ";
				if($CmbContrato!='T')			
					$Consulta.=" and t1.cod_contrato='".$CmbContrato."'";
				if($CmbTipo!='T')
				    $Consulta.=" and t3.tipo_factura='".$CmbTipo."'";
				if($CmbProd!='T')
				   	$Consulta.=" and t1.cod_producto='".$CmbProd."'";
				if($CmbNumFact!='T')
					$Consulta.=" and t1.num_factura='".$CmbNumFact."'";
				if($CmbTipoContrato!='T')	
					$Consulta.=" and t1.tipo='".$CmbTipoContrato."' ";	
				if($CmbTipo=='2')
				{
					if($CmbDeCre!='T')	
						$Consulta.=" and t3.tipo_nota='".$CmbDeCre."' ";	
				}														
				$FechaInicio=$Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."-01";
				$FechaTermino=$AnoFin."-".str_pad($MesFin,2,"0",STR_PAD_LEFT)."-31";
				if(isset($CmbFactura)&&($CmbFactura=='2'||$CmbFactura=='3'))
					$Consulta.=" and t1.estado_actual = 1";
				else
					$Consulta.=" and t1.fecha_emision BETWEEN '".$FechaInicio."' AND '".$FechaTermino."'";
				$Consulta.=" group by t1.codigo,t3.correlativo";
				$Consulta.=" order by t1.fecha_emision,t1.num_factura";
				$Resp=mysqli_query($link, $Consulta);				
				//echo $Consulta."<br><br>";
				while($Fila=mysql_fetch_array($Resp))
				{						
				    $Cod=$Fila["codigo"];
				    $Mostrar='S';
					$Cuota=$Fila["cuota"];
					if($Fila["tipo_factura"]=='1')//SI ES PROVISORIA
					{
						switch($CmbFactura)
						{
							case "1"://FINALIZADAS
								if($Fila["estado_actual"]=='2')
									$Mostrar='N';	
								break;
							case "2"://VENCIDAS
								if($Fila["estado_actual"]=='1')
								{
									if($Fila[TipoCtto]=='2')//MAQUILA
										$Acuerdo=intval($Fila["acuerdo_contractual_au"]);
									else
										$Acuerdo=intval($Fila["acuerdo_contractual_cu"]);
									$FechaFactura=explode('-',$Fila[fecha_emision]);
									$FechaAVencer=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1])+$Acuerdo,$FechaFactura[2],$FechaFactura[0]));
									//echo $Acuerdo."<br>";
									//echo $FechaAVencer."<br>";
									//echo $FechaInicio."<br>";
									//echo "DIF:".resta_fechas($FechaAVencer,$FechaTermino)."<BR><br>";
									if(resta_fechas($FechaAVencer,$FechaTermino)>=0)
										$Mostrar='N';	
								}
								else
									$Mostrar='N';	
								break;
							case "3"://SIN VENCER
								if($Fila["estado_actual"]=='1')
								{
									$FechaFactura=explode('-',$Fila[fecha_emision]);
									$FechaFactura=$FechaFactura[0]."-".$FechaFactura[1]."-01";
									if(resta_fechas($FechaInicio,$FechaFactura)>=0)
									{
										if($Fila[TipoCtto]=='2')//MAQUILA
											$Acuerdo=intval($Fila["acuerdo_contractual_au"]);
										else
											$Acuerdo=intval($Fila["acuerdo_contractual_cu"]);
										$FechaFactura=explode('-',$Fila[fecha_emision]);
										$FechaAVencer=date( "Y-m-d", mktime(0,0,0,intval($FechaFactura[1])+$Acuerdo,$FechaFactura[2],$FechaFactura[0]));
										//echo $FechaAVencer."<br>";
										//echo $FechaInicio."<br>";
										//echo "DIF:".resta_fechas($FechaAVencer,$FechaTermino)."<BR>";
										if(resta_fechas($FechaAVencer,$FechaTermino)<0)
											$Mostrar='N';	
									}
									else
										$Mostrar='N';
								}
								else
									$Mostrar='N';	
								break;
						}
					}

					if($Mostrar=='S')
					{  
					?>
					<tr>
					  <td align="center"><? echo $Fila[fecha_emision];?>&nbsp; </td>				  				 
					  <td align="right"><? echo $Fila[num_factura];?>&nbsp; </td>
                      <?
					   if($Fila["tipo_factura"]=='1')
					   {					   
					  ?> 
					   <td align="center"><? echo "-";?>&nbsp;</td>
					  <?
					   }
					   else
					   {
						$DatoNC='';$DatoND='';$NC_ND='';
						$DatoNC=RetornaNC_ND($Cod,'2');
						$DatoND=RetornaNC_ND($Cod,'1');	
						if($DatoNC<>'')
						   $NC_ND="NC:".$DatoNC." ";
						if($DatoND<>'')
						   $NC_ND=$NC_ND."ND:".$DatoND;
					  ?>
					  <td align="left"><? echo $NC_ND;?>&nbsp;</td>					    
					  <?
					   }
					  ?>					  
					  <td align="center"><? echo substr($Cuota,0,4)." ". $Meses[intval(substr($Cuota,4)-1)];?>&nbsp; </td>
					  <? 
					   $Var=ValoresIn($Fila[codigo],$Fila[correlativo],'1','1','1');
					   $Var1=ValoresIn($Fila[codigo],$Fila[correlativo],'2','1','1');
					   $Var2=ValoresIn($Fila[codigo],$Fila[correlativo],'1','2','1');
					   $Var3=ValoresIn($Fila[codigo],$Fila[correlativo],'2','2','1');
					   $Var4=ValoresIn($Fila[codigo],$Fila[correlativo],'1','3','1');
					   $Var5=ValoresIn($Fila[codigo],$Fila[correlativo],'2','3','1');
					  						
						$Var_Precio=ValorPrecioCompra($Ano,$Mes,'1');
						$Var_Precio1=ValorPrecioCompra($Ano,$Mes,'2');
						$Var_Precio2=ValorPrecioCompra($Ano,$Mes,'3');
						$TotalNetoCobre=$Var_Precio*$Var1; 
						$TotalNetoPlata=$Var_Precio1*$Var3; 
						$TotalNetoOro=$Var_Precio2*$Var5;               
					 ?>																																  
					  <td align="right"><? echo number_format($Fila[valor_neto],2,',','.');?>&nbsp; </td>				  
					  <td align="right"><? echo number_format($Fila[iva],2,',','.');?>&nbsp; </td>
					  <td align="right"><? echo number_format($Fila[valor_total],2,',','.');?>&nbsp; </td>
					  <?
					    if($CmbTipo=='2')
					    {
							 if($OptInfChecked!='')
							 {
								$Datos=explode('~',$OptInfChecked);
								while(list($c,$v)=each($Datos))
								{
								  //echo $v."<br>";
								   if($v=='5'||$v=='6'||$v=='7'||$v=='8'||$v=='9'||$v=='10'||$v=='11'||$v=='12'||$v=='13')
								   {
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2',''),2,',','.')."</td>";					
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','')."</td>";																
								   }
								   else
								   {
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','1'),2,',','.')."</td>";
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','1')."</td>";					
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','2'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','2')."</td>";					
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','3'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','3')."</td>";					
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','4'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','4')."</td>";					
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','5'),2,',','.')."</td>";
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,'2','5')."</td>";																
								   }	
								}	
							 }	
						}
						else
						{
							if($OptInfChecked!='')
							{
								$Datos=explode('~',$OptInfChecked);
								while(list($c,$v)=each($Datos))
								{
								//echo $v."<br>";
								   if($v=='5'||$v=='6'||$v=='7'||$v=='8'||$v=='9'||$v=='10'||$v=='11'||$v=='12'||$v=='13')
								   {
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],''),2,',','.')."</td>";					
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'')."</td>";																
								   }
								   else
								   {
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'1'),2,',','.')."</td>";					
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'1')."</td>";																
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'2'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'2')."</td>";																
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'3'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'3')."</td>";																
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'4'),2,',','.')."</td>";								
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'4')."</td>";																
									echo"<td align='right'>".number_format(Contenido($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_factura],'5'),2,',','.')."</td>";											
									echo"<td>".Unidad($OptInfChecked,$Fila[codigo],$Fila[correlativo],$Fila[numero],$v,$Fila[tipo_fac],'5')."</td>";																
								   }
								}	
							}
						}		
					  ?>					  					  
					</tr>
					<?
					}	
					$TotalNeto=$TotalNeto+$Fila[valor_neto];
					$TotalIva=$TotalIva+$Fila[iva];
					$TotalTotal=$TotalTotal+$Fila[valor_total];
				 }
				 
				?>
				<tr>
				 <td class="TituloTablaVerde" align="right" colspan="4">TOTAL</td>
				 <td class="TituloTablaVerde" align="right"><? echo number_format($TotalNeto,2,',','.');?></td>
				 <td class="TituloTablaVerde" align="right"><? echo number_format($TotalIva,2,',','.');?></td>
				 <td class="TituloTablaVerde" align="right"><? echo number_format($TotalTotal,2,',','.');?></td>
				 </tr>
				<?				 
				 
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
function Contenido($OptInfChecked,$Codigo,$Correlativo,$Numero,$Contenido,$TipoFac,$Fino)
{
	$ConsultaValor =" select valor,nombre_subclase as nom_unidad from pcip_fac_compra_finos t1 left join";
	$ConsultaValor.=" proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31013' and t1.cod_unidad=t2.cod_subclase where codigo='".$Codigo."' and correlativo='".$Correlativo."' and numero='".$Numero."'";
	$ConsultaValor.=" and tipo_factura='".$TipoFac."' and cod_contenido='".$Contenido."'";
	if($Fino!='')
		$ConsultaValor.=" and cod_fino='".$Fino."'";
	$RespValor=mysql_query($ConsultaValor);				
	//echo $ConsultaValor."<br><br>";
	if($FilaValor=mysql_fetch_array($RespValor))
	{
	  $Valor=$FilaValor[valor];
	  return($Valor);
	}
	else
	{
	  $Valor=0;
	  return($Valor);
	}
}
function Unidad($OptInfChecked,$Codigo,$Correlativo,$Numero,$Contenido,$TipoFac,$Fino)
{
	$ConsultaValor =" select valor,nombre_subclase as nom_unidad from pcip_fac_compra_finos t1 left join";
	$ConsultaValor.=" proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31013' and t1.cod_unidad=t2.cod_subclase where codigo='".$Codigo."' and correlativo='".$Correlativo."' and numero='".$Numero."'";
	$ConsultaValor.=" and tipo_factura='".$TipoFac."' and cod_contenido='".$Contenido."'";
	if($Fino!='')
		$ConsultaValor.=" and cod_fino='".$Fino."'";
	$RespValor=mysql_query($ConsultaValor);				
	//echo $ConsultaValor."<br><br>";
	if($FilaValor=mysql_fetch_array($RespValor))
	{
	  $Unidad=$FilaValor[nom_unidad];
	  return($Unidad);
	}
	else
	{
	  $Unidad='&nbsp;';
	  return($Unidad);
	}
}
function ValoresIn($Codigo,$Correlativo,$Contenido,$Fino,$Unidad)
{
	$Valor=0;
	$Consulta="select sum(t1.valor) as total ";
	$Consulta.="from pcip_fac_compra_finos t1 where t1.codigo='".$Codigo."'";
	$Consulta.=" and t1.correlativo='".$Correlativo."'";
	$Consulta.=" and t1.cod_contenido='".$Contenido."'";	
	$Consulta.=" and t1.cod_fino='".$Fino."'";
	$Consulta.=" and t1.cod_unidad='".$Unidad."'";
	//echo $Consulta."<br>";
	$Respaux=mysqli_query($link, $Consulta);
	if($Filaaux=mysql_fetch_array($Respaux))
	{
		$Valor=$Filaaux["total"];		
	}
	return($Valor);
}

function ValorPrecioCompra($Ano1,$Mes1,$Fino)
{
	$ValorPre=0;
	$Consulta1="select t1.valor";
	$Consulta1.=" from pcip_fac_compra_precios t1 where t1.ano='".$Ano1."'";
	$Consulta1.=" and t1.mes='".$Mes1."'";	
	$Consulta1.=" and t1.cod_fino='".$Fino."'";
	//echo $Consulta1."<br>";
	$Respaux1=mysql_query($Consulta1);
	if($Filaaux1=mysql_fetch_array($Respaux1))
	{
		$ValorPre=$Filaaux1[valor];		
	}
	return($ValorPre);
}

function RetornaNC_ND($Codigo,$Tipo)
{
  $Numero='';
  $ConsultaNC_ND="select numero from pcip_fac_compra_finos_relacion where codigo='".$Codigo."' and tipo_nota='".$Tipo."'";
  //echo $ConsultaNC_ND."<br>";
  $RespNC_ND=mysql_query($ConsultaNC_ND);  
  while($FilaNC_ND=mysql_fetch_array($RespNC_ND))
  {
    $Numero=$Numero.$FilaNC_ND[numero].", ";
  }
  if($Numero!='')
  	$Numero=substr($Numero,0,strlen($Numero)-2);
  return($Numero);	
}
?>