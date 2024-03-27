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
<title>Mantenedor Balanace</title>
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
			f.action = "pcip_parametros_balance_mensual_nuevo_svp.php?Buscar=S";
			f.submit();
		break;
		case 'N'://GRABAR
			var URL = "../pcip_web/pcip_parametros_balance_mensual_nuevo_svp_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=230,width=850,height=400,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
			if(SoloUnElemento(f.name,'Check','M'))
			{
				Valores=Recuperar(f.name,'Check');
				if (Valores=="")
				{
					alert("Debe Seleccionar un Elemento para Modificar");
					return;
				}
				else
				{
					URL="../pcip_web/pcip_parametros_balance_mensual_nuevo_svp_proceso.php?Opcion=M&Codigos="+Valores;
					window.open(URL,"","top=30,left=230,width=850,height=400,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "E"://ELIMINAR
			var Valores="";
			Valores=Recuperar(f.name,'Check');
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("�Desea Eliminar los Parametros Seleccionados?"))
				{
					f.action = "pcip_parametros_balance_mensual_nuevo_svp_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		
		case "R":
			f.action = "pcip_parametros_balance_mensual_nuevo_svp.php";
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
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span></a><a href="JavaScript:Procesos('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>
		<a href="JavaScript:Procesos('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a>
		<a href="JavaScript:Procesos('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a>
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td width="16%" height="17" class='formulario2'>Producto</td>
    <td width="84%" class="formulario2" >
	<select name="CmbProducto">
        <option value="T" selected="selected">Todos</option>
        <?
	    $Consulta = "select distinct t2.nombre_subclase,t2.cod_subclase from pcip_svp_balance_mensual t1 inner join proyecto_modernizacion.sub_clase t2 where t2.cod_clase='31054'";			
		$Consulta.= " and t1.cod_producto=t2.cod_subclase";
		$Resp=mysqli_query($link, $Consulta);
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
	<select name="CmbNegocio">
      <option value="T" selected="selected">Todos</option>
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
        <td>
		 <table width="100%" border="1" cellpadding="0" cellspacing="0" >
          <tr class="TituloTablaVerde">
            <td width="1%" align="center"><span class="Estilo9">&nbsp;</span></td>
			<td width="10%" align="center"><span class="Estilo9">Producto</span></td>
			<td width="15%" align="center"><span class="Estilo9">SubProducto</span></td>
			<td width="20%" align="center"><span class="Estilo9">Negocio</span></td>
			<td width="15%" align="center"><span class="Estilo9">Titulo</span></td>
			<td width="30%" align="center"><span class="Estilo9">Orden</span></td>
          </tr>
		  <?
		  	if($Buscar=='S')
			{	
				$Consulta="select t1.cod_producto,t1.cod_negocio,t2.nombre_subclase as nom_producto,t3.nombre_subclase as nom_subproducto,t4.nombre_subclase as nom_negocio,t5.nombre_subclase as nom_titulo,t1.orden,t6.OPdescripcion";
				$Consulta.=" from pcip_svp_balance_mensual t1 ";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31054' and t1.cod_producto=t2.cod_subclase ";
				$Consulta.=" left join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31055' and t1.cod_subproducto=t3.cod_subclase ";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t4 on t4.cod_clase='31056' and t1.cod_negocio=t4.cod_subclase ";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31057' and t1.cod_titulo=t5.cod_subclase ";
				$Consulta.=" inner join pcip_svp_ordenesproduccion t6 on t1.orden=t6.OPorden ";
				$Consulta.="where t1.cod_producto<>''"; 
				if($CmbProducto!='T')
					$Consulta.=" and t1.cod_producto='".$CmbProducto."'";
				if($CmbNegocio!='T')
					$Consulta.=" and t1.cod_negocio='".$CmbNegocio."'";
				$Consulta.=" order by cod_producto";	
				//echo $Consulta."<br>";
				echo "<input type='hidden' name='Check'>";
				$RespBal=mysqli_query($link, $Consulta);
				while($FilaBal=mysql_fetch_array($RespBal))
				{
					$Cod=$FilaBal["cod_producto"]."~".$FilaBal[cod_negocio]."~".$FilaBal[orden];
					echo "<tr>";
					echo "<td align='center'><input type='checkbox' name='Check' class='SinBorde' value=".$Cod."></td>";
					echo "<td align='left'>".$FilaBal["nom_producto"]."&nbsp;</td>";
					echo "<td align='left'>".$FilaBal[nom_subproducto]."&nbsp;</td>";
					echo "<td align='left'>".$FilaBal[nom_negocio]."&nbsp;</td>";
					echo "<td align='left'>".$FilaBal[nom_titulo]."&nbsp;</td>";
					echo "<td align='left'>".$FilaBal[orden]."&nbsp;".$FilaBal[OPdescripcion]."</td>";
					echo "</tr>";
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
echo "<script languaje='JavaScript'>";
	if ($Mensaje)
		echo "alert('".$Mensaje."');";
	echo "</script>";

?>