<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	if(!isset($Ano))
 		$Ano=date('Y');
	if(!isset($Mes))
		$Mes=date('m');
?>
<html>
<head>
<title>Mantenedor Facturas Suministros</title>
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
			var URL = "../pcip_web/pcip_mantenedor_facturas_suministros_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=750,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
			if(SoloUnElemento(f.name,'CheckSumi','M'))
			{
				Valores=Recuperar(f.name,'CheckSumi');
				if (Valores=="")
				{
					alert("Debe Seleccionar un Elemento para Modoficar");
					return;
				}
				else
				{
					URL="../pcip_web/pcip_mantenedor_facturas_suministros_proceso.php?Opcion=M&Corr="+Valores;
					window.open(URL,"","top=30,left=30,width=750,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":
			f.action = "pcip_mantenedor_facturas_suministros.php?Buscar=S";
			f.submit();
		break;
		case "R":
			f.action = "pcip_mantenedor_facturas_suministros.php";
			f.submit();
		break;
		case "E"://ELIMINAR
			var Valores="";
			Valores=Recuperar(f.name,'CheckSumi');
			if (Valores=="")
			{
				alert("Debe Seleccionar un Elemento para Eliminar");
				return;
			}
			else
			{
				if (confirm("�Desea Eliminar las Facturas Seleccionadas?"))
				{
					f.action = "pcip_mantenedor_facturas_suministros_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=7";
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
 EncabezadoPagina($IP_SERV,'suministros_facturas.png')
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
    <td width="16%" height="17" class='formulario2'>A&ntilde;o</td>
    <td width="18%" class='formulario2'><select name="Ano" id="Ano">
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
    <td width="7%" class='formulario2'>Mes    
    <td width="59%" class='formulario2'>
	<select name="Mes" id="Mes">
	<option value="T" selected="selected">Todos</option>
      <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$Mes)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
?>
    </select>  </tr>
  <tr>
    <td height="17" class='formulario2'>Grupo Suministro</td>
    <td class='formulario2'><select name="CmbGrupoSuministro" onChange="Procesos('R')">
      <option value="-1" class="NoSelec">Todos</option>
      <?
	  $Consulta = "select * from pcip_eec_suministros_grupos where cod_suministro_grupo in ('1','2','3') order by nom_agrupacion ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbGrupoSuministro==$FilaTC["cod_suministro_grupo"])
				echo "<option selected value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
		}
			?>
    </select>      
    <td class='formulario2'>Suministro    
    <td class='formulario2'><select name="CmbSuministro">
      <option value="-1" class="NoSelec">Todos</option>
      <?
	    $Consulta = "select t1.cod_suministro,t2.nom_suministro from pcip_eec_suministros_por_grupos t1 inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
	    $Consulta.= "where t1.cod_suministro_grupo='".$CmbGrupoSuministro."' order by t2.nom_suministro ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSuministro==$FilaTC["cod_suministro"])
				echo "<option selected value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
		}
			?>
    </select> <? //echo $CmbSuministro ;?>  </tr>
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
<td width="6%" class="TituloTablaVerde" align="center" >&nbsp;</td>
<td width="11%" class="TituloTablaVerde" align="center" >A&ntilde;o</td>
<td width="11%" class="TituloTablaVerde" align="center" >Mes</td>
<td width="19%" class="TituloTablaVerde" align="center" >Suministro</td>
<td width="27%" class="TituloTablaVerde"align="center">Fecha Ingreso</td>
<td width="11%" class="TituloTablaVerde" align="center">Valor Total US$</td>
<td width="11%" class="TituloTablaVerde" align="center">Precio</td>
<td width="4%" class="TituloTablaVerde" align="center" >Un.</td>
</tr>
<?
  echo "<input type='hidden' name='CheckSumi'>";
  if($Buscar=='S')
  { 
	$Consulta="select t1.corr,t1.ano,t1.mes,t2.nom_suministro,t2.cod_suministro,t1.fecha,t1.valor_total,t1.precio,t2.cod_unidad";
	$Consulta.=" from pcip_eec_facturas_suministros t1 inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
	$Consulta.="where t1.ano='".$Ano."'  ";
	if($Mes!='T')
		$Consulta.= " and mes='".$Mes."' ";	
	if($CmbSuministro!='-1')
		$Consulta.= " and t1.cod_suministro='".$CmbSuministro."'  ";
	$Resp=mysql_query($Consulta);	
	//echo $Consulta;
	$Cont=1;$ValorTotal=0;$ValorPrecio=0;
	while($Fila=mysql_fetch_array($Resp))
	{	    
		if($Fila[precio]=='0')
		{
			$ValorPrecio=CalculaPrecio($Ano,$Fila[mes],$Fila[cod_suministro],$Fila[valor_total]);
			$ValorPrecio=number_format($ValorPrecio,5,',','.');
		}
		else
		{		
			$ValorPrecio=$Fila[precio];
			$ValorPrecio=number_format($ValorPrecio,2,',','.');
		}
		if($Fila[valor_total]=='0')
		{
			$ValorTotal=CalculaTotal($Ano,$Fila[mes],$Fila[cod_suministro],$Fila[precio]);
			$ValorTotal=number_format($ValorTotal,2,',','.');
		}
		else
		{
			$ValorTotal=$Fila[valor_total];
			$ValorTotal=number_format($ValorTotal,2,',','.');
		}
		?>
		<td align="center"><input type="checkbox" name='CheckSumi' class="SinBorde" value="<? echo $Fila["corr"]; ?>"></td>
		<td align="center"><? echo $Fila[ano];?></td>
		<td align="center"><? echo $Meses[$Fila[mes]-1];?></td>
		<td align="center"><? echo $Fila[nom_suministro]; ?></td>
		<td align="center"><? echo $Fila[fecha]; ?></td>
		<td align="right"><? echo $ValorTotal; ?></td>
		<td align="right"><? echo $ValorPrecio; ?></td>
		<td align="center">US$/<? echo $Fila[cod_unidad]; ?></td>
		</tr>
	    <?
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
		echo "alert('Facturas(s) Eliminado(s) Correctamente');";
	echo "</script>";	
?>	
</body>
</html>
<?
function CalculaPrecio($Ano,$Mes,$Suministro,$Valor)//EL VALOR INGRESADO EN VALOR TOTAL Y LO DIVIDE POR LA SUMA DE TODOS LOS SUMINISTROS
{ 
	$ValorSalida=0;
	$Consulta=" select cod_suministro,sum(valor) as Valor from pcip_eec_suministros_detalle where cod_suministro<>''";
	$Consulta.=" and cod_suministro='".$Suministro."'";
	$Consulta.=" and ano='".$Ano."' and mes='".$Mes."' and tipo='S' group by cod_suministro";
	$Resp=mysql_query($Consulta);	
	//echo $Consulta."<br>";
	if($Fila=mysql_fetch_array($Resp))
	{
		if($Fila[Valor]>0)	 
			$ValorSalida=$Valor/$Fila[Valor];
		else
		    $ValorSalida;	
	}
	return($ValorSalida);
}
function CalculaTotal($Ano,$Mes,$Suministro,$Valor)//EL VALOR INGRESADO EN PRECIO Y LO MULTIPLICA POR LA SUMA DE TODOS LOS SUMINISTROS
{ 
	$ValorSalida=0;
	$Consulta=" select cod_suministro,sum(valor) as Valor from pcip_eec_suministros_detalle where cod_suministro<>''";
	$Consulta.=" and cod_suministro='".$Suministro."'";
	$Consulta.=" and ano='".$Ano."' and mes='".$Mes."' and tipo='S' group by cod_suministro";
	$Resp=mysql_query($Consulta);	
	//echo $Consulta."<br>";
	if($Fila=mysql_fetch_array($Resp))
	{
			$ValorSalida=$Valor*$Fila[Valor];
	}
	return($ValorSalida);
}
?>