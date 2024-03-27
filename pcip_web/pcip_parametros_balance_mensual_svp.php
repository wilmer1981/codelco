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
<title>Mantenedor Parametros Balanace Mensual</title>
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
			if(f.CmbTipoNegocio.value=='-1')
			{
				alert('Debe Seleccionar Negocio');
				f.CmbTipoNegocio.focus();
				return;
			}
			/*if(f.CmbProd.value=='-1')
			{
				alert('Debe Seleccionar Producto');
				f.CmbProd.focus();
				return;
			}*/
			f.action = "pcip_parametros_balance_mensual_svp.php?Buscar=S";
			f.submit();
		break;
		case 'N'://GRABAR
			var URL = "../pcip_web/pcip_parametros_balance_mensual_svp_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
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
					URL="../pcip_web/pcip_parametros_balance_mensual_svp_proceso.php?Opcion=M&Codigos="+Valores;
					window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
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
					f.action = "pcip_parametros_balance_mensual_svp_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		
		case "R":
			f.action = "pcip_parametros_balance_mensual_svp.php";
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
 <? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\balance_mensual.png" width="240" height="16"></td>
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
    <td width="16%" height="17" class='formulario2'>Negocio</td>
    <td colspan="4" class="formulario2" ><select name="CmbTipoNegocio" >
        <option value="-1" selected="selected">Seleccionar</option>
        <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31005' order by cod_subclase ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoNegocio==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
		?>
      </select></td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Etapa</td>
    <td colspan="4" class="formulario2" ><select name="CmbEtapa">
      <option value="T" selected="selected">Todos</option>
      <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31004' order by cod_subclase ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEtapa==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
    </select></td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Tipo Informe</td>
    <td width="31%" class="formulario2" ><select name="CmbTipoInforme" onChange="Procesos('R')" >
      <option value="T" selected="selected">Todos</option>
      <?
	    $Consulta = "select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31002' order by cod_subclase ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbTipoInforme==$FilaTC["cod_subclase"])
				echo "<option selected value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
		}
			?>
    </select></td>
    <td width="10%" class="formulario2" >Producto</td>
    <td width="35%" class="formulario2" ><select name="CmbProd" >
      <option value="T" selected="selected">Todos</option>
      <?
	    $Consulta = "select * from pcip_svp_productos_etapas ";
		if($CmbTipoInforme!='T')
			$Consulta.= "where cod_tipo_balance='".$CmbTipoInforme."' ";
		$Consulta.= "order by cod_producto_etapa ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$FilaTC["cod_producto_etapa"])
				echo "<option selected value='".$FilaTC["cod_producto_etapa"]."'>".ucfirst($FilaTC["nom_producto_etapa"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_producto_etapa"]."'>".ucfirst($FilaTC["nom_producto_etapa"])."</option>\n";
		}
			?>
    </select></td>
    <td width="8%" class="formulario2" >&nbsp;</td>
  </tr>	  	  
  <tr>

    <td height="25" class='formulario2'>&nbsp;</td>
    <td colspan="4" class='formulario2'>  </tr>
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
          <tr class="TituloTablaVerde">
            <td width="1%" align="center"><span class="Estilo9">&nbsp;</span></td>
			<td width="20%" align="center"><span class="Estilo9">Etapa</span></td>
			<td width="15%" align="center"><span class="Estilo9">Producto</span></td>
			<td width="8%" align="center"><span class="Estilo9">Tipo Informe</span></td>
			<td width="8%" align="center"><span class="Estilo9">Tipo Balance</span></td>
			<td width="15%" align="center"><span class="Estilo9">Orden</span></td>
			<td width="15%" align="center"><span class="Estilo9">Orden Relacionada</span></td>
			<td width="5%" align="center"><span class="Estilo9">Tr.</span></td>
			<td width="5%" align="center"><span class="Estilo9">Tipo Inv.</span></td>
			<td width="5%" align="center"><span class="Estilo9">Material</span></td>
			<td width="5%" align="center"><span class="Estilo9">Ordes</span></td>
          </tr>
		  <?
		  	if($Buscar=='S')
			{	
				$Consulta="select t1.ordes,t1.cod_etapa,t1.cod_tipo_negocio,t1.cod_producto_etapa,t1.cod_tipo_informe,t1.cod_tipo_balance,t1.tramo,t1.tipo_inventario,t1.cod_material,t1.num_orden,t2.OPdescripcion as NumOrden,t1.num_orden_relacionada,t7.OPdescripcion as NumOrdenRel,t3.nombre_subclase as nom_etapa,";
				$Consulta.="t4.nom_producto_etapa,t5.nombre_subclase as nom_tipo_informe,t6.nombre_subclase as nom_tipo_balance from pcip_svp_balance_mensual t1 ";
				$Consulta.="inner join pcip_svp_ordenesproduccion t2 on t1.num_orden=t2.OPorden ";
				$Consulta.="left join pcip_svp_ordenesproduccion t7 on t1.num_orden_relacionada=t7.OPorden ";
				$Consulta.="inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31004' and t1.cod_etapa=t3.cod_subclase  ";
				$Consulta.="inner join pcip_svp_productos_etapas t4 on t1.cod_producto_etapa=t4.cod_producto_etapa ";
				$Consulta.="inner join proyecto_modernizacion.sub_clase t5 on t5.cod_clase='31002' and t1.cod_tipo_informe=t5.cod_subclase ";
				$Consulta.="inner join proyecto_modernizacion.sub_clase t6 on t6.cod_clase='31003' and t1.cod_tipo_balance=t6.cod_subclase ";
				$Consulta.="where t1.cod_tipo_negocio='".$CmbTipoNegocio."' "; 
				if($CmbEtapa!='T')
					$Consulta.="and t1.cod_etapa='".$CmbEtapa."'";
				if($CmbProd!='T')
					$Consulta.="and t1.cod_producto_etapa ='".$CmbProd."'";
				if($CmbTipoInforme!='T')
					$Consulta.="and t1.cod_tipo_informe='".$CmbTipoInforme."'";
				//echo $Consulta."<br>";
				echo "<input type='hidden' name='Check'>";
				$RespBal=mysqli_query($link, $Consulta);
				while($FilaBal=mysql_fetch_array($RespBal))
				{
					$Cod=$FilaBal[cod_etapa]."~".$FilaBal[cod_tipo_negocio]."~".$FilaBal[cod_producto_etapa]."~".$FilaBal[cod_tipo_informe]."~".$FilaBal[cod_tipo_balance]."~".$FilaBal[num_orden]."~".$FilaBal[tipo_inventario];
					echo "<tr>";
					echo "<td align='center'><input type='checkbox' name='Check' class='SinBorde' value=".$Cod."></td>";
					echo "<td>".$FilaBal[nom_etapa]."</td>";
					echo "<td>".$FilaBal[nom_producto_etapa]."</td>";
					echo "<td>".$FilaBal[nom_tipo_informe]."</td>";
					echo "<td>".$FilaBal[nom_tipo_balance]."</td>";
					echo "<td>".$FilaBal[num_orden]." ".$FilaBal[NumOrden]."</td>";
					if($FilaBal[num_orden_relacionada]!=0)
						echo "<td>".$FilaBal[num_orden_relacionada]." ".$FilaBal[NumOrdenRel]."&nbsp;</td>";
					else
						echo "<td>&nbsp;</td>";	
					echo "<td align='center'>".$FilaBal[tramo]."&nbsp;</td>";
					echo "<td align='center'>".$FilaBal[tipo_inventario]."</td>";
					echo "<td align='right'>".$FilaBal[cod_material]."</td>";
					echo "<td align='right'>".$FilaBal[ordes]."&nbsp;</td>";
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