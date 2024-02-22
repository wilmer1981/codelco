<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');	
if(!isset($CmbTipoInforme))
	$CmbTipoInforme=1;
?>
<html>
<head>
<title>Reporte Suministros</title>
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
		case "C"://BUSCA SUMINISTROS
			if(f.CmbGrupoSuministro.value=='-1')
			{
				alert('Debe Seleccionar Grupo Suministro');
				f.CmbGrupoSuministro.focus();
				return;
			}	
			if(f.CmbSuministro.value=='-1')
			{
				alert('Debe Seleccionar Suministro');
				f.CmbSuministro.focus();
				return;
			}	
			switch(f.CmbTipoInforme.value)
			{
				case "1":
					URL='pcip_rpt_suministro_informe.php?CmbGrupoSuministro='+f.CmbGrupoSuministro.value+'&CmbSuministro='+f.CmbSuministro.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value;
					window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				break;
				case "2":
					if(f.CmbCC.value=='-1')
					{
						alert('Debe Seleccionar Centro Costo');
						f.CmbCC.focus();
						return;
					}	
					URL='pcip_rpt_suministro_cc.php?CmbSuministro='+f.CmbSuministro.value+"&Ano="+f.Ano.value+"&CmbCC="+f.CmbCC.value;
					window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				break;
				case "3":
					URL='pcip_rpt_suministro_div.php?CmbGrupoSuministro='+f.CmbGrupoSuministro.value+'&CmbSuministro='+f.CmbSuministro.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value;
					window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				break;
			}
		break;
		case "E"://BUSCA SUMINISTROS EXCEL
			if(f.CmbGrupoSuministro.value=='-1')
			{
				alert('Debe Seleccionar Grupo Suministro');
				f.CmbGrupoSuministro.focus();
				return;
			}	
			if(f.CmbSuministro.value=='-1')
			{
				alert('Debe Seleccionar Suministro');
				f.CmbSuministro.focus();
				return;
			}	
			switch(f.CmbTipoInforme.value)
			{
				case "1":
					URL='pcip_rpt_suministro_informe_excel.php?CmbGrupoSuministro='+f.CmbGrupoSuministro.value+'&CmbSuministro='+f.CmbSuministro.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value;
					window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
				break;
				case "2":
					if(f.CmbCC.value=='-1')
					{
						alert('Debe Seleccionar Centro Costo');
						f.CmbCC.focus();
						return;
					}	
					URL='pcip_rpt_suministro_cc_excel.php?CmbSuministro='+f.CmbSuministro.value+"&Ano="+f.Ano.value+"&CmbCC="+f.CmbCC.value;
					window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
				break;
				case "3":
					URL='pcip_rpt_suministro_div_excel.php?CmbSuministro='+f.CmbSuministro.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value;
					window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
				break;
			}
		break;
		case "R":
			f.action = "pcip_rpt_suministro.php";
			f.submit();
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
 EncabezadoPagina($IP_SERV,'suministros.png')
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
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span></a><a href="JavaScript:Procesos('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Procesos('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp; <a href="JavaScript:Procesos('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> <a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
    <td height="25" class='formulario2'>Mostrar por</td>
    <td class='formulario2'><select name="CmbTipoInforme" style="width:250" onChange="Procesos('R')">
        <?
	  switch($CmbTipoInforme)
	  {
	  	case "1":
			echo "<option value='1' selected>Informe</option>";
			echo "<option value='2' >Centro Costos</option>";
			echo "<option value='3' >Total División</option>";
		break;
	  	case "2":
			echo "<option value='1' >Informe</option>";
			echo "<option value='2' selected>Centro Costos</option>";
			echo "<option value='3' >Total División</option>";
		break;
	  	case "3":
			echo "<option value='1' >Informe</option>";
			echo "<option value='2' >Centro Costos</option>";
			echo "<option value='3' selected>Total División</option>";
		break;
		default:
			echo "<option value='1' selected>Informe</option>";
			echo "<option value='2' >Centro Costos</option>";
			echo "<option value='3' >Total División</option>";
		break;
	  }
	  ?>
      </select>  </tr>

  <tr>
    <td width="16%" height="17" class='formulario2'>Grupo Suministro</td>
    <td class="formulario2" ><label>
      <select name="CmbGrupoSuministro" onChange="Procesos('R')">
        <?
		if(isset($CmbTipoInforme)&&$CmbTipoInforme=='3')
			echo "<option value='T' class='NoSelec'>Todos</option>";
		else
			echo "<option value='-1' class='NoSelec'>Seleccionar</option>";	
	    $Consulta = "select * from pcip_eec_suministros_grupos ";
 	    if($CmbTipoInforme=='1')
			$Consulta.= "where cod_suministro_grupo not in ('4','5','6')";
 	    if($CmbTipoInforme!='1')
			$Consulta.= "where cod_suministro_grupo not in ('6')";
		$Consulta.= " order by nom_agrupacion ";	
					
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbGrupoSuministro==$FilaTC["cod_suministro_grupo"])
				echo "<option selected value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
		}
			?>
      </select><? //echo $Consulta;?>
    </label>    </tr>
  <tr>
    <td height="25" class='formulario2'> Suministro </td>
    <td class='formulario2'><select name="CmbSuministro" >
      <?
		if(isset($CmbTipoInforme)&&($CmbTipoInforme=='3'||$CmbTipoInforme=='1'))
			echo "<option value='T' class='NoSelec'>Todos</option>";
		else
			echo "<option value='-1' class='NoSelec'>Seleccionar</option>";	
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
    </select>  </tr>
  <tr>
    <td height="25" class='formulario2'>A&ntilde;o </td>
    <td class='formulario2'><select name="Ano">
      <?
	for ($i=date("Y")-3;$i<=date("Y")+1;$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>  </tr>
  <?
  if($CmbTipoInforme=='1'||$CmbTipoInforme=='3')
  {
  ?>	  
  <tr>
    <td height="25" class='formulario2'>Mes</td>
    <td class='formulario2'><select name="Mes">
      <?
	for ($i=1;$i<=12;$i++)
	{
		if ($i==$Mes)
			echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		else
			echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
	}
    ?>
    </select>	</tr>
	<?
	}
	?>
  <?
  if($CmbTipoInforme=='2')
  {
  ?>	  
  <tr>
    <td height="25" class='formulario2'>Centro Costo</td>
    <td class='formulario2'><select name="CmbCC">
      <option value="-1" selected="selected">Seleccionar</option>
      <?
			$Consulta="select distinct cod_cc from pcip_eec_suministros_detalle where cod_cc<>'' order by cod_cc";			
			$Resp=mysql_query($Consulta);
			while($Fila=mysql_fetch_array($Resp))
			{
				echo "<option value=".$Fila[cod_cc]." >".$Fila[cod_cc]."</option>";
			
			}
			?>
    </select> <? //echo $Consulta."<br>";?>   </tr>
	<?
	}
	?>
 </table>  </td>
  <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
    </tr>
    <tr>
      <td width="15" ><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
      <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
      <td width="15" ><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
    </tr>
  </table>	
    <br></td>
 </tr>
  </table>
	<? include("pie_pagina.php")?>

</form>
</body>
</html>