<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<title>Mantenedor Programa Producción</title>
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
			var URL = "../pcip_web/pcip_mantenedor_ppc_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case 'NV'://GRABAR
			var URL = "../pcip_web/pcip_mantenedor_versiones_ppc.php?Opcion=N";
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
					URL="../pcip_web/pcip_mantenedor_ppc_proceso.php?Opcion=M&Codigos="+Valores;
					window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":
			if(f.CmbVersion.value=='-1')
			{
				alert('Debe Seleccionar Versión');
				f.CmbVersion.focus();
				return;
			}
			f.action = "pcip_mantenedor_ppc.php?Buscar=S";
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
				if (confirm("¿Desea Eliminar las Asignaciones Seleccionadas?"))
				{
					f.action = "pcip_mantenedor_ppc_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_mantenedor_ppc.php";
			f.submit();
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=9";
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
 EncabezadoPagina($IP_SERV,'mant_ppc.png')
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
		<a href="JavaScript:Procesos('NV')"><img src="archivos/btn_ingreso_obs2.png"  border="0"  alt="Nueva Versión" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a><a href="JavaScript:Procesos('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
    <table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
      <tr>
        <td height="25" class='formulario2'>A&ntilde;o</td>
        <td class='formulario2'><select name="Ano" onChange="Procesos('R')">
          <?
	for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
        </select>      </tr>

      <tr>
        <td width="16%" height="17" class='formulario2'>Versi&oacute;n</td>
        <td class="formulario2" ><label></label>        <span class="FilaAbeja2">
          <select name="CmbVersion" onChange="Procesos('R')">
            <option value="-1" selected="selected">Seleccionar</option>
            <?
	    $Consulta = "select * from pcip_ppc_version where ano='".$Ano."'order by version ";			
		$Resp=mysql_query($Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($Fila["ult_version"]=='S')
				$Color="#339900";
			else
				$Color="";
			if ($CmbVersion==$Fila["version"])
			{	
				echo "<option style='background:".$Color."' selected value='".$Fila["version"]."'>Version:".$Fila["version"]." A&ntilde;o:".$Fila["ano"]." Mes:".$Meses[$Fila["mes"]-1]."</option>\n";
				$Obs=$Fila["descripcion"];
			}
			else
				echo "<option style='background:".$Color."' value='".$Fila["version"]."'>Version:".$Fila["version"]." A&ntilde;o:".$Fila["ano"]." Mes:".$Meses[$Fila["mes"]-1]."</option>\n";
		}
			?>
          </select>
          <input type="text" name="textfield" style='background:"#339900"' size="2">&nbsp;&nbsp;Ultima Versión
          <label></label>
        </span></tr>
      <tr>
        <td height="25" class='formulario2'>Descripcion Versi&oacute;n </td>
        <td class='formulario2'><span class="FilaAbeja2">
          <textarea readonly="readonly" name="textarea" cols="75" rows="3"><? echo $Obs;?></textarea></span></td>
      </tr>
      <tr>
        <td height="25" class='formulario2'>Material</td>
        <td class='formulario2'><select name="CmbProd" onChange="Procesos('R')">
          <option value="-1" selected="selected">Todos</option>
          <?
	    $Consulta = "select * from pcip_svp_asignacion where mostrar_ppc='1' order by nom_asignacion ";			
		$Resp=mysql_query($Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$Fila["cod_asignacion"])
				echo "<option selected value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
		}
			?>
        </select>      </tr>
      <tr>
        <td height="25" class='formulario2'>Producto</td>
        <td class='formulario2'><select name="CmbAsig" >
          <option value="-1" class="NoSelec">Todos</option>
          <?
	    $Consulta = "select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."' and mostrar_ppc='1'";			
		$Resp=mysql_query($Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbAsig==$Fila["cod_producto"])
				echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
		}
			?>
        </select>      </tr>
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
<td width="4%" class="TituloTablaVerde" align="center" >&nbsp;</td>
<td width="10%" class="TituloTablaVerde"align="center" >Año</td>
<td width="10%" class="TituloTablaVerde" align="center" >Asignaci&oacute;n</td>
<td width="20%" class="TituloTablaVerde" align="center" >Producto</td>
<td width="20%" class="TituloTablaVerde" align="center" >Negocio</td>
<td width="20%" class="TituloTablaVerde" align="center" >Titulo Reporte</td>
<?
for($i=0;$i<12;$i++)
{
?>
<td width="6%" class="TituloTablaVerde"align="center" ><? echo substr(strtoupper($Meses[$i]),0,3);?>&nbsp;</td>
<?
}
?>
<td width="6%" class="TituloTablaVerde"align="center" >TOTAL</td>
</tr>
<?
  if($Buscar=='S')
  {
	$Consulta="select t1.version,t1.cod_asignacion,t1.cod_procedencia,t1.cod_negocio,t1.cod_titulo,t1.tipo,t2.nom_asignacion as nom_asignacion,t3.nom_asignacion as prod,t4.nom_negocio,t5.nom_titulo,t1.ano ";
	$Consulta.="from pcip_ppc_detalle t1 inner join pcip_svp_asignaciones_productos t2 on t1.cod_procedencia=t2.cod_producto inner join pcip_svp_asignacion t3 on t1.cod_asignacion=t3.cod_asignacion left join pcip_svp_negocios t4 ";
	$Consulta.=" on t1.cod_negocio=t4.cod_negocio left join pcip_svp_asignaciones_titulos t5 on t5.cod_asignacion=t1.cod_asignacion and t1.cod_titulo=t5.cod_titulo where t1.cod_asignacion <>'' and t1.version='".$CmbVersion."' and t1.ano='".$Ano."' and t5.mostrar_ppc='1'";
	if($CmbProd!='-1')
		$Consulta.="and t1.cod_asignacion='".$CmbProd."'";
	if($CmbAsig!='-1')
		$Consulta.="and t1.cod_procedencia='".$CmbAsig."'";	
		
	$Consulta.="group by t1.version,t1.cod_asignacion,t1.cod_procedencia,t1.cod_negocio,t1.ano,t1.tipo,t1.cod_titulo";	
	$Resp=mysql_query($Consulta);$Cont=0;
	//echo $Consulta;
	echo "<input name='CheckAsig' type='hidden'>";
	while($Fila=mysql_fetch_array($Resp))
	{
  		$Cod=$Fila[version]."~".$Fila[ano]."~".$Fila[cod_asignacion]."~".$Fila[cod_procedencia]."~".$Fila[cod_negocio]."~".$Fila[tipo]."~".$Fila[cod_titulo];
		echo "<tr>";
		echo "<td align='center'><input name='CheckAsig' type='checkbox' value='".$Cod."' class='SinBorde' ></td>";
		echo "<td>".$Fila[ano]."</td>";
		echo "<td>".$Fila[prod]."</td>";
		echo "<td>".$Fila[nom_asignacion]."</td>";
		echo "<td>".$Fila[nom_negocio]."&nbsp;</td>";
		echo "<td>".$Fila[nom_titulo]."&nbsp;</td>";
		$Total=0;
		for($i=1;$i<=12;$i++)
		{
			$Consulta="select valor from pcip_ppc_detalle where version='".$Fila[version]."' and ano='".$Fila[ano]."' and cod_asignacion='".$Fila[cod_asignacion]."' and cod_procedencia='".$Fila[cod_procedencia]."' and cod_negocio='".$Fila[cod_negocio]."' and tipo='".$Fila[tipo]."' and cod_titulo='".$Fila[cod_titulo]."' and mes='".$i."'";
			//echo $Consulta."<br>";
			$RespValor=mysql_query($Consulta);
			if($FilaValor=mysql_fetch_array($RespValor))
				echo "<td align='right'>".number_format($FilaValor[valor],0,',','.')."</td>";
			else
				echo "<td align='center'>&nbsp;</td>";	

		    $Total=$Total+$FilaValor[valor];
		}
		$Cont++;
	 		echo "<td align='center'>".number_format($Total,2,',','.')."</td>";
		echo "</tr>";
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
	if($Mensaje!='1'&&$Cont==0&&$Buscar=='S')
		echo "alert('Información de Asignacion No Encontrada');";	
	echo "</script>";
?>	
</body>
</html>