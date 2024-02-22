<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<title>Mantenedor Ingreso Proyectado Asignacion</title>
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
		case 'N'://GRABAR
			var URL = "../pcip_web/pcip_mantenedor_ingreso_proyectado_asignacion_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
			if(SoloUnElemento(f.name,'CheckAsig','M'))
			{
				Valores=Recuperar(f.name,'CheckAsig');
				if (Valores=="")
				{
					alert("Debe Seleccionar un Elemento para Modificar");
					return;
				}
				else
				{
					URL="../pcip_web/pcip_mantenedor_ingreso_proyectado_asignacion_proceso.php?Opcion=M&Codigos="+Valores;
					window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":
			f.action = "pcip_mantenedor_ingreso_proyectado_asignacion.php?Buscar=S";
			f.submit();
		break;
		case "E"://ELIMINAR
			var Valores="";
			Valores=Recuperar(f.name,'CheckAsig');
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("�Desea Eliminar las Asignaciones Seleccionadas?"))
				{
				    //alert(Valores);
					f.action = "pcip_mantenedor_ingreso_proyectado_asignacion_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_mantenedor_ingreso_proyectado_asignacion.php";
			f.submit();
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
 EncabezadoPagina($IP_SERV,'ingreso_proyectado_asignacion.png')
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
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		<a href="JavaScript:Procesos('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a><a href="JavaScript:Procesos('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
    <table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
      <tr>
        <td width="16%" height="17" class='formulario2'>Productos</td>
        <td class="formulario2" ><label>
          <select name="CmbProducto" onChange="Procesos('R')">
            <option value="T" selected="selected">Todos</option>
            <?
			$Consulta = "select distinct(t2.cod_subclase),t2.nombre_subclase from pcip_inp_asignacion t1";
			$Consulta.= " inner join proyecto_modernizacion.sub_clase t2 where t2.cod_clase='31029' and t1.cod_producto=t2.cod_subclase order by t2.cod_subclase";			
			$Resp=mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbProducto==$Fila["cod_subclase"])
					echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
			}
			?>
          </select>
        </label>        </tr>
      <tr>
        <td height="25" class='formulario2'>Proveedores </td>
        <td class='formulario2'><select name="CmbProveedores" >
            <option value="T" class="NoSelec">Todos</option>
            <?
			$Consulta = "select distinct t2.cod_subclase,t2.nombre_subclase from pcip_inp_asignacion t1";
			$Consulta.= " inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31030' and t1.cod_proveedor=t2.cod_subclase where cod_producto<>''";
			if($CmbProducto!='T')
				$Consulta.= " and cod_producto='".$CmbProducto."'";
			$Resp=mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				if ($CmbProveedores==$Fila["cod_subclase"])
					echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
			}
			?>
          </select>          
		 </tr>
    </table></td>
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
<td width="1%" colspan="10" class="titulo_rojo" align="center" >Datos SVP Para Obtener Valor Real</td>
</tr>
<tr>
<td width="1%" class="TituloTablaVerde" align="center" >&nbsp;</td>
<td width="6%" class="TituloTablaVerde" align="center" >Datos SVP</td>
<td width="20%" class="TituloTablaVerde" align="center" >Productos</td>
<td width="14%" class="TituloTablaVerde" align="center" >Proveedores</td>
<td width="8%" class="TituloTablaVerde" align="center" >N&ordm; Orden</td>
<td width="9%" class="TituloTablaVerde"align="center" >N&ordm; Orden Rel.</td>
<td width="8%" class="TituloTablaVerde" align="center" >VPtipinv</td>
<td width="10%" class="TituloTablaVerde" align="center">Material</td>
<td width="8%" class="TituloTablaVerde" align="center">VPordes</td>
<td width="16%" class="TituloTablaVerde" align="center">VPtm</td>
</tr>
<?
  if($Buscar=='S')
  {
    $Consulta =" select t1.dato,t1.cod_producto,t1.cod_proveedor,t1.VPorden,t1.VPtm,t1.VPmaterial,t1.Vptipinv,t1.VPordenrel,t1.VPordes,t2.nombre_subclase as nom_productos,t3.nombre_subclase as nom_proveedor";
	$Consulta.=" from pcip_inp_asignacion t1";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31029' and t1.cod_producto=t2.cod_subclase";	
    $Consulta.=" inner join proyecto_modernizacion.sub_clase t3 where t3.cod_clase='31030' and t1.cod_proveedor=t3.cod_subclase and t1.dato='1'";	
	if($CmbProducto!='T')
		$Consulta.=" and t1.cod_producto='".$CmbProducto."'";
	if($CmbProveedores!='T')
		$Consulta.=" and t1.cod_proveedor='".$CmbProveedores."'";	
	//echo $Consulta;
	$Resp=mysql_query($Consulta);$Cont=0;
	echo "<input name='CheckAsig' type='hidden'>";
	while($Fila=mysql_fetch_array($Resp))
	{
  		$Cod=$Fila[dato]."~".$Fila["cod_producto"]."~".$Fila[cod_proveedor]."~".$Fila[VPorden]."~".$Fila[VPtm]."~".$Fila[VPmaterial]."~".$Fila[Vptipinv];
		if($Fila[dato]=='1')
			$Fila[dato]="SVP";
		echo "<tr>";
		echo "<td align='center'><input name='CheckAsig' type='checkbox' value='".$Cod."' class='SinBorde' ></td>";
		echo "<td align='center'>".$Fila[dato]."</td>";
		echo "<td align='left'>".$Fila[nom_productos]."</td>";
		echo "<td align='left'>".$Fila[nom_proveedor]."</td>";
		echo "<td align='right'>".$Fila[VPorden]."</td>";
		echo "<td align='right'>".$Fila[VPordenrel]."</td>";
		echo "<td align='right'>".$Fila[Vptipinv]."</td>";
		echo "<td align='right'>".$Fila[VPmaterial]."&nbsp;</td>";
		echo "<td align='right'>".$Fila[VPordes]."&nbsp;</td>";
		echo "<td align='right'>".$Fila[VPtm]."&nbsp;</td>";
		echo "</tr>";
		$Cont++;
	}
  
  }
?>	
<tr>
<td width="1%" colspan="10" class="titulo_rojo" align="center" >Datos PPC Para Obtener Valor Presupuestado</td>
</tr>
<tr>
<td width="1%" class="TituloTablaVerde" align="center" >&nbsp;</td>
<td width="6%" class="TituloTablaVerde" align="center" >Datos PPC</td>
<td width="20%" class="TituloTablaVerde" align="center" >Productos</td>
<td width="14%" class="TituloTablaVerde" align="center" >Proveedores</td>
<td width="8%" class="TituloTablaVerde" align="center" >Asignaci�n</td>
<td width="9%" class="TituloTablaVerde"align="center" >Producto</td>
<td width="8%" class="TituloTablaVerde" align="center" >Negocio</td>
<td width="10%" class="TituloTablaVerde" align="center">Titulo</td>
</tr>
<?
  if($Buscar=='S')
  {
    $Consulta =" select t1.dato,t1.cod_producto,t1.cod_proveedor,t1.VPorden,t1.VPtm,t1.VPmaterial,t1.Vptipinv,t2.nombre_subclase as nom_productos,t3.nombre_subclase as nom_proveedor,";
    $Consulta.=" t4.nom_asignacion,t5.nom_asignacion as nom_producto,t6.nom_negocio,t7.nom_titulo";
	$Consulta.=" from pcip_inp_asignacion t1";
	$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31029' and t1.cod_producto=t2.cod_subclase";	
    $Consulta.=" inner join proyecto_modernizacion.sub_clase t3 ";
	$Consulta.=" inner join pcip_svp_asignacion t4 on t1.VPorden=t4.cod_asignacion";
	$Consulta.=" inner join pcip_svp_asignaciones_productos t5 on t1.VPorden=t5.cod_asignacion and t1.VPtm=t5.cod_producto ";		
	$Consulta.=" inner join pcip_svp_negocios t6 on t1.VPmaterial=t6.cod_negocio ";
	$Consulta.=" inner join pcip_svp_asignaciones_titulos t7 on t7.cod_asignacion=t1.VPorden and t1.Vptipinv=t7.cod_titulo";
	$Consulta.=" where t3.cod_clase='31030' and t1.cod_proveedor=t3.cod_subclase and t1.dato='2'";
	if($CmbProducto!='T')
		$Consulta.=" and t1.cod_producto='".$CmbProducto."'";
	if($CmbProveedores!='T')
		$Consulta.=" and t1.cod_proveedor='".$CmbProveedores."'";	
	//echo $Consulta;
	$Resp=mysql_query($Consulta);$Cont=0;
	echo "<input name='CheckAsig' type='hidden'>";
	while($Fila=mysql_fetch_array($Resp))
	{
  		$Cod=$Fila[dato]."~".$Fila["cod_producto"]."~".$Fila[cod_proveedor]."~".$Fila[VPorden]."~".$Fila[VPtm]."~".$Fila[VPmaterial]."~".$Fila[Vptipinv];
		//echo $Cod; 
		if($Fila[dato]=='2')
		    $Fila[dato]="PPC";		
		echo "<tr>";
		echo "<td align='center'><input name='CheckAsig' type='checkbox' value='".$Cod."' class='SinBorde' ></td>";
		echo "<td align='center'>".$Fila[dato]."</td>";
		echo "<td align='left'>".$Fila[nom_productos]."</td>";
		echo "<td align='left'>".$Fila[nom_proveedor]."</td>";
		echo "<td align='left'>".$Fila[nom_asignacion]."</td>";
		echo "<td align='left'>".$Fila["nom_producto"]."</td>";
		echo "<td align='left'>".$Fila[nom_negocio]."</td>";
		echo "<td align='left'>".$Fila[nom_titulo]."&nbsp;</td>";
		echo "</tr>";	
		$Cont++;	
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
		echo "alert('Asignaciones (s) Eliminado(s) Correctamente');";
//	if($Mensaje!='1'&&$Cont==0&&$Buscar=='S')
//		echo "alert('Informaci�n No Encontrada');";	
	echo "</script>";
?>	
</body>
</html>