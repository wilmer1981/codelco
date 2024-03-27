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
<title>Mantenedor Disponibilidad Programada</title>
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
			var URL = "../pcip_web/pcip_mantenedor_disponibilidad_proyectada_proceso.php?Opcion=N";
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
					URL="../pcip_web/pcip_mantenedor_disponibilidad_proyectada_proceso.php?Opcion=M&Codigos="+Valores;
					window.open(URL,"","top=30,left=30,width=900,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":
			f.action = "pcip_mantenedor_disponibilidad_proyectada.php?Buscar=S";
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
					f.action = "pcip_mantenedor_disponibilidad_proyectada_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_mantenedor_disponibilidad_proyectada.php";
			f.submit();
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
 EncabezadoPagina($IP_SERV,'disponibilidad_proyectada.png')
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
    <td width="16%" height="17" class='formulario2'>Sistema</td>
    <td colspan="3" class="formulario2" ><select name="CmbSistema" onChange="Procesos('R')">
      <option value="-1" selected="selected">Todos</option>
      <?
	  $Consulta = "select cod_sistema,nom_sistema from pcip_eec_sistemas where vigente='S' and mostrar='S' order by nom_sistema ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSistema==$FilaTC["cod_sistema"])
				echo "<option selected value='".$FilaTC["cod_sistema"]."'>".ucfirst($FilaTC["nom_sistema"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_sistema"]."'>".ucfirst($FilaTC["nom_sistema"])."</option>\n";
		}
			?>
    </select>  </tr>
  <tr>
    <td height="17" class='formulario2'>Equipos</td>
    <td width="12%" class='formulario2'><select name="CmbEquipos">
        <option value="-1" selected="selected">Todos</option>
        <?
	  $Consulta = "select t1.cod_equipo,t2.nom_equipo from pcip_eec_equipos_por_sistema t1 inner join pcip_eec_equipos t2 on t1.cod_equipo=t2.cod_equipo where t1.cod_sistema='".$CmbSistema."' order by t2.nom_equipo ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEquipos==$FilaTC["cod_equipo"])
				echo "<option selected value='".$FilaTC["cod_equipo"]."'>".ucfirst($FilaTC["nom_equipo"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_equipo"]."'>".ucfirst($FilaTC["nom_equipo"])."</option>\n";
		}
			?>
      </select>
    <td width="9%" align="right" class='formulario2'>A&ntilde;o
    <td width="63%" class='formulario2'><select name="Ano" id="Ano">
      <?
	for ($i=2003;$i<=date("Y");$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>      </tr>
  <tr>
    <td height="17" class='formulario2'>&nbsp;</td>
    <td colspan="3" class='formulario2'>  </tr>
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
<td width="4%" class="TituloTablaVerde" align="center" >&nbsp;</td>
<td width="9%" class="TituloTablaVerde" align="center" >Sistema</td>
<td width="9%" class="TituloTablaVerde" align="center" >Equipo</td>
<td width="6%" class="TituloTablaVerde" align="center" >A&ntilde;o</td>
<td width="6%" class="TituloTablaVerde" align="center" >Tipo Valor</td>
<td width="6%" class="TituloTablaVerde"align="center" >Ene</td>
<td width="6%" class="TituloTablaVerde" align="center" >Feb</td>
<td width="6%" class="TituloTablaVerde" align="center">Mar</td>
<td width="6%" class="TituloTablaVerde" align="center">Abr</td>
<td width="6%" class="TituloTablaVerde"align="center">Mayo</td>
<td width="6%" class="TituloTablaVerde"align="center">Jun</td>
<td width="6%" class="TituloTablaVerde"align="center">Jul</td>
<td width="6%" class="TituloTablaVerde"align="center">Ago</td>
<td width="6%" class="TituloTablaVerde"align="center">Sep</td>
<td width="6%" class="TituloTablaVerde"align="center">Oct</td>
<td width="6%" class="TituloTablaVerde"align="center">Nov</td>
<td width="6%" class="TituloTablaVerde"align="center">Dic</td>
<td width="6%" class="TituloTablaVerde"align="center">Acum</td>
</tr>
<?
  echo "<input type='hidden' name='CheckDisp'>";
  if($Buscar=='S')
  {
	$Consulta="select t1.cod_sistema,t1.cod_equipo,t1.ano,t2.nom_sistema,t3.nom_equipo from pcip_eec_disponibilidades t1 inner join pcip_eec_sistemas t2 on t1.cod_sistema=t2.cod_sistema ";
	$Consulta.="inner join pcip_eec_equipos t3 on t1.cod_equipo=t3.cod_equipo where t1.tipo_disponibilidad='P' and  ano='".$Ano."'";
	if($CmbSistema!='-1')
		$Consulta.= " and t1.cod_sistema='".$CmbSistema."' ";
	if($CmbEquipos!='-1')
		$Consulta.= " and t1.cod_equipo='".$CmbEquipos."' ";
	$Consulta.= " group by t1.cod_sistema,t1.cod_equipo,t1.tipo_disponibilidad,t1.ano ";	
	//echo $Consulta; 	
	$Resp=mysqli_query($link, $Consulta);
	$Linea=1;
	while($Fila=mysql_fetch_array($Resp))
	{
		$Sistema=$Fila[nom_sistema];
		$Equipo=$Fila[nom_equipo];
		$A�o=$Fila[ano];
		$Cod=$Fila[cod_sistema]."~".$Fila[cod_equipo]."~".$Fila[ano];
		if($Linea=='1')
		{
		?>
		<tr class="FilaAbeja">
		<td rowspan="4"><input type="checkbox" name='CheckDisp' class="SinBorde" value="<? echo $Cod; ?>"> </td>
		<td rowspan="4"><? echo $Sistema;?></td>
		<td rowspan="4" ><? echo $Equipo;?></td>
		<td rowspan="4" align="center"><? echo $A�o;?></td>
		<?
		}
		//DatosDispProyectada(1,$Fila[cod_sistema],$Fila[cod_equipo],$Fila[ano],&$Acum,&$Cont);
		DatosDispProyectada(2,$Fila[cod_sistema],$Fila[cod_equipo],$Fila[ano],&$Acum,&$Cont);
		DatosDispProyectada(3,$Fila[cod_sistema],$Fila[cod_equipo],$Fila[ano],&$Acum,&$Cont);
		DatosDispProyectada(4,$Fila[cod_sistema],$Fila[cod_equipo],$Fila[ano],&$Acum,&$Cont);
		//$Linea++;			
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
		echo "alert('Disponibilidad (s) Eliminado(s) Correctamente');";
	echo "</script>";
function DatosDispProyectada($Linea,$CodSistema,$CodEquipo,$A�o,$Acum,$Cont)
{
	$Acum=0;$Cont=0;
	switch($Linea)
	{
		case "1":
			$Consulta="select valor as valor ";
			echo "<td align='left'>Valor Ingreso</td>";
		break;
		case "2":
			$Consulta="select hrs_oper_d as valor ";
			echo "<tr class='FilaAbeja2'><td align='left'>Hrs.Oper.Diaria</td>";
		break;
		case "3":
			$Consulta="select hrs_mant_men as valor ";
			echo "<tr  class='FilaAbeja2'><td align='left'>Hrs.Mant.Men</td>";
		break;
		case "4":
			$Consulta="select hrs_mant_may as valor ";
			echo "<tr class='FilaAbeja2'><td align='left'>Hrs.Mant.May</td>";
		break;
	}
	 $Consulta.=" from pcip_eec_disponibilidades where tipo_disponibilidad='P' and cod_sistema='".$CodSistema."' and cod_equipo='".$CodEquipo."' and ano='".$A�o."' ";
	 for($i=1;$i<=12;$i++)
	 {
		$Consulta2=" and mes='".$i."'";
		$Consulta3=$Consulta.$Consulta2;
		$RespMes=mysql_query($Consulta3);
		if($FilaMes=mysql_fetch_array($RespMes))
		{
			if($FilaMes[valor]!=0)
				echo "<td align='right'>".number_format($FilaMes[valor],3,',','.')."</td>";
			else
				echo "<td align='right'>0</td>";
			$Acum=$Acum+$FilaMes[valor];
			$Cont++;
		}
		else
		{		
			echo "<td>0</td>";
		}	
	 }
	?>
	<td align="right"><? echo number_format($Acum,3,',','.');?></td>
	</tr>
	<? 
}	
?>	
</body>
</html>