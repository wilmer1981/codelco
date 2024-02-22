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
<title>Reporte Ingresos Proyectados</title>
<style type="text/css">s
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
			if(f.CmbProductos.value=='-1')
			{
				alert("Debe seleccionar Producto");
				f.CmbProductos.focus();
				return;
			}
			if(f.CmbResumen.value=='-1')
			{
				alert("Debe seleccionar Resumen");
				f.CmbResumen.focus();
				return;
			}							
			f.action = "pcip_rpt_ingresos_proyectados.php?Buscar=S";
			f.submit();
		break;
		case "E"://GENERA EXCEL
			URL='pcip_rpt_ingresos_proyectados_excel.php?&CmbProductos='+f.CmbProductos.value+'&CmbDivision='+f.CmbDivision.value+'&CmbResumen='+f.CmbResumen.value+'&Ano='+f.Ano.value+'&Mes='+f.Mes.value+'&MesFin='+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;				
		case "R":
			f.action = "pcip_rpt_ingresos_proyectados.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=14";
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
 EncabezadoPagina($IP_SERV,'ingresos_proyectados_report.pn')
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
   <td width="77" height="17" class='formulario2'>Productos</td>
   <td class="formulario2"><select name="CmbProductos" onChange="Proceso('R')">
   <option value="-1" class="NoSelec">Seleccionar</option>
   <?
   $Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase='31021' and cod_subclase in ('1','2','3') order by cod_subclase ";	 	
   $Resp=mysql_query($Consulta);
   while ($Fila=mysql_fetch_array($Resp))
   {
		if ($CmbProductos==$Fila["cod_subclase"])
			echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
		else
			echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
   }
   ?>
   </select><? //echo $Consulta;?>   
   </td>
   </tr>
   <!--<tr>
   <td width="77" height="17" class='formulario2'>&Aacute;rea</td>
   <td class="formulario2"><select name="CmbArea" onChange="Proceso('R')">
   <option value="-1" class="NoSelec">Seleccionar</option>
   <?
//   $Consulta ="select * from proyecto_modernizacion.sub_clase where cod_clase='31023' order by nombre_subclase ";	 	
//   $Resp=mysql_query($Consulta);
//   while ($Fila=mysql_fetch_array($Resp))
//   {
//		if ($CmbArea==$Fila["cod_subclase"])
//			echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
//		else
//			echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst(strtolower($Fila["nombre_subclase"]))."</option>\n";
//   }
   ?>
   </select><? //echo $Consulta;?>   
   </td>
   </tr>-->
   <tr>
   <td width="77" height="17" class='formulario2'>Proveedor</td>
   <td width="833" height="17"  class="formulario2" ><select name="CmbDivision" onChange="Proceso('R')">
   <option value="T" selected="selected">Todos</option>
   <?
   $Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31024' ";	   
   if($CmbProductos=='1')
   		$Consulta.= " and cod_subclase in('1','2','3','4','5','7')";
   if($CmbProductos=='2')
   		$Consulta.= " and cod_subclase in('1','2','3','7','8')";
   if($CmbProductos=='3')
   		$Consulta.= " and cod_subclase in('3')";		
   $Resp=mysql_query($Consulta);
   while ($Fila=mysql_fetch_array($Resp))
	   {
		 /*if($CmbProductos=='2')
		 {
			 if($Fila["cod_subclase"]=='1')
			   $Fila["nombre_subclase"]="Enami, �nodos";
			 if($Fila["cod_subclase"]=='2')
			   $Fila["nombre_subclase"]="Sur Andes, �nodos";
			 if($Fila["cod_subclase"]=='3')
			   $Fila["nombre_subclase"]="Teniente, �nodos";
			 if($Fila["cod_subclase"]=='7')
			   $Fila["nombre_subclase"]="Blister CODELCO";
			 if($Fila["cod_subclase"]=='8')
			   $Fila["nombre_subclase"]="Sur andes, �nodos (catodos rechazados: L�minas y Despuntes)";
			 if($Fila["cod_subclase"]=='9')
			   $Fila["nombre_subclase"]="Sur Andes, �nodos (C�todos Est�ndar)";
		 } */	
		 if($CmbProductos=='3')
		 {
			 if($Fila["cod_subclase"]=='3')
			   $Fila["nombre_subclase"]="Teniente, Scrap";		  
		 }			 	
		if ($CmbDivision==$Fila["cod_subclase"])
			echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
		else
			echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
	   }	
   ?>
   </select>   
   </td>
   </tr>
   <tr>
	<td width="94" class="formulario2">Mostrar Por</td>
	<td width="348" class="formulariosimple">
	<select name="CmbResumen" onChange="Proceso('R')">
	<option value="-1" class="NoSelec">Seleccionar</option>
	<?
	$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31027' ";			
	$Resp=mysql_query($Consulta);
	while ($FilaTC=mysql_fetch_array($Resp))
	{
		if ($CmbResumen==$FilaTC["cod_subclase"])
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
    <td colspan="5" class='formulario2'>A&ntilde;o &nbsp;&nbsp;&nbsp;
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
      &nbsp;Desde 
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
		</select>  
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
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
          <td>
		  <?
		  switch($CmbProductos)
		  {
		  	case "1":
				include('pcip_rpt_ingresos_proyectados_cucuns.php');
			break;
		  	case "2":
				include('pcip_rpt_ingresos_proyectados_anodos.php');
			break;
		  	case "3":
				include('pcip_rpt_ingresos_proyectados_scrap.php');
			break;
			
		  }
		  ?>
		  &nbsp;</td>
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
function DatosProyectados($Prv,$Area,$Ano,$Mes,$Prod,$Tipo)
{
	$Datos1=0;$Datos2=0;
	$Consulta1 =" select valor_real as ValorReal,valor_presupuestado as ValorPresupuestado from pcip_inp_tratam ";
	$Consulta1.=" where nom_area='".$Area."' and nom_division='".$Prv."' and cod_producto='".$Prod."' and ano='".$Ano."' and mes='".$Mes."'";
	//echo $Consulta1."<br>";
	$RespAux=mysql_query($Consulta1);
	if($FilaAux=mysql_fetch_array($RespAux))
	{
		$Datos1=$FilaAux[ValorReal];
		//echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
		$Datos2=$FilaAux[ValorPresupuestado];
		//echo "Valor datos consyulta 2   ".$Datos2."<br>";
	}
	if($Tipo=='R')	
		return($Datos1);
	if($Tipo=='P')	    
		return($Datos2);	
}
function DatosPrecios($AnoAux,$MesAux,$Prod,$Tipo)
{
	$Valor=0;
	$Consulta2 =" select valor from pcip_inp_precios ";
	$Consulta2.=" where cod_producto='".$Prod."' and ano='".$AnoAux."' and cod_deduccion='".$Tipo."'";
	//echo $Consulta2."<br>";
	$RespAux1=mysql_query($Consulta2);
	if($FilaAux1=mysql_fetch_array($RespAux1))
	{
		$Valor=$FilaAux1[valor];
		//echo $Valor;
	}
	return($Valor);
}
function DatosPreciosPena($AnoAux,$MesAux,$Prod,$Tipo)
{
	$Valor=0;
	$Consulta2 =" select valor_pena from pcip_inp_precios ";
	$Consulta2.=" where cod_producto='".$Prod."' and ano='".$AnoAux."' and cod_deduccion='".$Tipo."'";
	//echo $Consulta2."<br>";
	$RespAux1=mysql_query($Consulta2);
	if($FilaAux1=mysql_fetch_array($RespAux1))
	{
		$Valor=$FilaAux1[valor_pena];
		//echo $Valor;
	}
	return($Valor);
}
?>
