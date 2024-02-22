<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
//if(!isset($Mes))
// 	$Mes=date('m');	
?>
<html>
<head>
<title>Variaciones Inventario PPTO</title>
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
	var Agrupados='N';
	switch(TipoProceso)
	{
		case 'N'://GRABAR
			var URL = "../pcip_web/pcip_mantenedor_variaciones_inventarios_ppto_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=900,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
			if(SoloUnElemento(f.name,'CheckDisp','M'))
			{
				Valores=Recuperar(f.name,'CheckDisp');
				if (Valores=="")
				{
				    
					alert("Debe Seleccionar un Elemento para Modificar");
					return;
				}
				else
				{   
				    //alert(Valores);
					URL="../pcip_web/pcip_mantenedor_variaciones_inventarios_ppto_proceso.php?Opcion=M&Cod="+Valores;
					window.open(URL,"","top=30,left=30,width=900,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":
			if(f.CmbGrupo.value=='-1')
			{
				alert("Debe seleccionar Grupo Asignaci�n");
				f.CmbGrupo.focus();
				return;
			}					
			if(f.CmbAsig.value=='-1')
			{
				alert("Debe seleccionar Asignaci�n");
				f.CmbAsig.focus();
				return;
			}							
			f.action = "pcip_mantenedor_variaciones_inventarios_ppto.php?Buscar=S";
			f.submit();
		break;
		case "E"://ELIMINAR
			var Valores="";
			Valores=Recuperar(f.name,'CheckDisp');
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("�Desea Eliminar las Disponibilidades Seleccionados?"))
				{
				    //alert(Valores);
					f.action = "pcip_mantenedor_variaciones_inventarios_ppto_proceso01.php?Opcion=E&Cod="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_mantenedor_variaciones_inventarios_ppto.php";
			f.submit();
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=8";
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
 EncabezadoPagina($IP_SERV,'mant_variacion_inventario_ppto.png')
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
		<a href="JavaScript:Proceso('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		<a href="JavaScript:Proceso('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a><a href="JavaScript:Proceso('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
<tr>
<td width="16%" height="17" class='formulario2'>Grupo Asignaci�n</td>
<td width="84%" class="formulario2" colspan="3"><select name="CmbGrupo" onChange="Proceso('R')">
  <option value="-1" selected="selected">Seleccionar</option>
  <?
	$Consulta = "select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31044'order by cod_subclase ";			
	$Resp=mysql_query($Consulta);
	while ($FilaTC=mysql_fetch_array($Resp))
	{
		if ($CmbGrupo==$FilaTC["cod_subclase"])
			echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		else
			echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
	}
  ?>
  </select></tr> 
  <tr>
    <td width="16%" height="17" class='formulario2'>Asignaci&oacute;n</td>
    <td colspan="3" class="formulario2"> <select name="CmbAsig" onChange="Proceso('R')">
	  <option value="-1" selected="selected">Seleccionar</option>
	  <?
		$Consulta = "select distinct t1.cod_subclase,t1.nombre_subclase from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.sub_clase t2";
		$Consulta.= " on t1.cod_clase='31045' and t2.cod_subclase=t1.valor_subclase1 where t1.valor_subclase1='".$CmbGrupo."' order by t1.cod_subclase ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbAsig==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
	  ?>
	  </select>  </tr>
  <tr>
    <td height="17" class='formulario2'>Area</td>
    <td width="12%" class='formulario2' colspan="3"><select name="CmbArea" onChange="Proceso('R')">
	   <option value="-1" class="NoSelec">Todos</option>
	   <?
		$Consulta = "select distinct(t2.cod_area),t1.nombre_subclase";
		$Consulta.=" from proyecto_modernizacion.sub_clase t1 left join pcip_svp_variacion_inventario_ppto t2 on t1.cod_clase='31009'";
		$Consulta.=" and t1.cod_subclase=t2.cod_area where cod_asignacion<>''";
		if($CmbAsig!='-1')
			$Consulta.=" and cod_asignacion='".$CmbAsig."'";											
		$Resp=mysql_query($Consulta);		
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbArea==$FilaTC["cod_area"])
				echo "<option selected value='".$FilaTC["cod_area"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_area"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
	   ?>
      </select>
	</td>
	</tr> 
    <tr>
		<td height="17" class='formulario2'>Maquila</td>
		<td colspan="3" class='formulario2'><select name="CmbMaqui" onChange="Proceso('R')">
		   <option value="-1" class="NoSelec">Todos</option>
	   <?
		$Consulta = "select distinct(t2.cod_maquila),t1.nombre_subclase";
		$Consulta.=" from proyecto_modernizacion.sub_clase t1 left join pcip_svp_variacion_inventario_ppto t2 on t1.cod_clase='31010'";
		$Consulta.=" and t1.cod_subclase=t2.cod_maquila where cod_area<>''";
		if($CmbArea!='-1')
			$Consulta.=" and cod_area='".$CmbArea."'";						
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbMaqui==$FilaTC["cod_maquila"])
				echo "<option selected value='".$FilaTC["cod_maquila"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_maquila"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
	   ?>
		  </select>    
	    </td>
	 </tr>
	   <tr>
		<td height="17" class='formulario2'> Productos</td>
		<td class='formulario2'><select name="CmbProd" onChange="Proceso('R')">
		   <option value="-1" class="NoSelec">Todos</option>
		   <?
			$Consulta ="select distinct(t1.cod_producto),t2.nom_producto from pcip_svp_variacion_inventario_ppto t1 left join pcip_svp_productos_inventarios t2";
			$Consulta.=" on t1.cod_producto=t2.cod_producto where cod_maquila<>''";	
			if($CmbMaqui!='-1')
				$Consulta.=" and cod_maquila='".$CmbMaqui."'";	
			$Resp=mysql_query($Consulta);							
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbProd==$FilaTC["cod_producto"])
					echo "<option selected value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
				else
					echo "<option value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nom_producto"])."</option>\n";
			}
		   ?>
		  </select>     
	   <td width="9%" align="right" class='formulario2'>A&ntilde;o
	   <td width="63%" class='formulario2'><select name="Ano" id="Ano">
	   <option value="T" selected="selected" onChange="Proceso('R')">Todos</option>
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
	 </tr>
  <tr>
    <td height="17" class='formulario2'>&nbsp;</td>
    <td colspan="6" class='formulario2'>  </tr>
 </table>
  </td>
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
	 <table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
		<tr>
		<td width="3%" class="TituloTablaVerde" align="center" >&nbsp;</td>
		<td width="7%" class="TituloTablaVerde" align="center" >Asignaci&oacute;n</td>
		<td width="5%" class="TituloTablaVerde" align="center" >&Aacute;rea</td>
		<td width="5%" class="TituloTablaVerde" align="center" >Maquila</td>
		<td width="6%" class="TituloTablaVerde" align="center" >Producto</td>
		<td width="4%" class="TituloTablaVerde" align="center" >A&ntilde;o</td>
		<td width="5%" class="TituloTablaVerde"align="center" >Ene</td>
		<td width="5%" class="TituloTablaVerde" align="center" >Feb</td>
		<td width="5%" class="TituloTablaVerde" align="center">Mar</td>
		<td width="5%" class="TituloTablaVerde" align="center">Abr</td>
		<td width="5%" class="TituloTablaVerde"align="center">Mayo</td>
		<td width="5%" class="TituloTablaVerde"align="center">Jun</td>
		<td width="5%" class="TituloTablaVerde"align="center">Jul</td>
		<td width="5%" class="TituloTablaVerde"align="center">Ago</td>
		<td width="5%" class="TituloTablaVerde"align="center">Sep</td>
		<td width="5%" class="TituloTablaVerde"align="center">Oct</td>
		<td width="5%" class="TituloTablaVerde"align="center">Nov</td>
		<td width="5%" class="TituloTablaVerde"align="center">Dic</td>
		<td width="5%" class="TituloTablaVerde"align="center">Acum</td>
		</tr>
			<?
			  if($Buscar=='S')
			  {
				$Consulta="select t5.nombre_subclase as nom_maquila,t4.nombre_subclase as nom_area,t2.nom_asignacion,t1.ano,t3.nom_producto,";
				$Consulta.=" t1.cod_asignacion,t1.cod_area,t1.cod_maquila,t1.cod_producto ";
				$Consulta.=" from pcip_svp_variacion_inventario_ppto t1 inner join pcip_svp_asignacion t2 on t1.cod_asignacion=t2.cod_asignacion";
				$Consulta.=" inner join pcip_svp_productos_inventarios t3 on t1.cod_producto=t3.cod_producto";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31009' and t4.cod_subclase=t1.cod_area ";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31010' and t5.cod_subclase=t1.cod_maquila	";
				$Consulta.=" where t2.cod_asignacion='".$CmbAsig."' ";
				if($CmbArea!='-1')
					$Consulta.= " and t1.cod_area='".$CmbArea."' ";
				if($CmbMaqui!='-1')
					$Consulta.= " and t1.cod_maquila='".$CmbMaqui."' ";
				if($CmbProd!='-1')
					$Consulta.= " and t3.cod_producto='".$CmbProd."' ";
				if($Ano!='T')
					$Consulta.= " and t1.ano='".$Ano."' ";
					
				$Consulta.= " group by t1.cod_asignacion,t1.cod_area,t1.ano,t1.cod_maquila,t1.cod_producto ";	
				//echo $Consulta; 	
				$Resp=mysql_query($Consulta);
				echo "<input type='hidden' name='CheckDisp'>";$Linea=1;
				while($Fila=mysql_fetch_array($Resp))
				{
					$Asig=$Fila[nom_asignacion];
					$Area=$Fila[nom_area];
					$Maquila=$Fila[nom_maquila];
					$Prod=$Fila["nom_producto"];
					$Ano=$Fila[ano];
			        $Cod=$Fila["cod_asignacion"]."~".$Fila["cod_area"]."~".$Fila["cod_maquila"]."~".$Fila["cod_producto"]."~".$Fila["ano"]; 
			       	if($Linea=='1')
		            { 
					?>
					<tr class="FilaAbeja">
					<td rowspan="1"><input type="checkbox" name='CheckDisp' class="SinBorde" value="<? echo $Cod; ?>"> </td>
					<td rowspan="1"><? echo $Asig;?></td>
					<td rowspan="1" ><? echo $Area;?></td>
					<td rowspan="1" ><? echo $Maquila;?></td>
					<td rowspan="1" ><? echo $Prod;?></td>				
					<td rowspan="1" align="center"><? echo $Ano;?></td>
					<?	
					}
					DatosVariaInven($Fila[cod_asignacion],$Fila[cod_area],$Fila[cod_maquila],$Fila["cod_producto"],$Fila[ano]);
					?><tr><?
					}
			 }
			?>	
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
 </td>
</tr>
</table>
	<? include("pie_pagina.php")?>

</form>
<? 
    echo "<script languaje='JavaScript'>";
	if ($Mensaje=='1')
		echo "alert('Variaciones Inventario (s) Eliminado(s) Correctamente');";
	echo "</script>";
function DatosVariaInven($Asig,$Area,$Maquila,$Prod,$Ano)
{
	 $Acum=0;$Cont=0;
	 for($i=1;$i<=12;$i++)
	 {
	    $Consulta="select valor_ppto from pcip_svp_variacion_inventario_ppto where cod_asignacion='".$Asig."' and cod_area='".$Area."' and cod_maquila='".$Maquila."' and cod_producto='".$Prod."' and ano='".$Ano."' ";
		$Consulta.=" and mes='".$i."'";
		//echo $Consulta."<br>";
		$RespMes=mysql_query($Consulta);
		if($FilaMes=mysql_fetch_array($RespMes))
		{
			echo "<td align='right' class='FilaAbeja2'>".number_format($FilaMes[valor_ppto],2,'','.')."</td>";
			$Acum=$Acum+$FilaMes[valor_ppto];
			$Cont++;
		}
		else
		{		
			echo "<td align='right' class='FilaAbeja2'>0</td>";
		}	
	 }
	?>
	<td align="right" class='FilaAbeja2'><? echo number_format($Acum,2,'','.');?></td>
	</tr>
	<? 
}	
?>	
</body>
</html>