<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<title>Mantenedor Suministros</title>
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
			var URL = "../pcip_web/pcip_mantenedor_suministro_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
			break;
		case "M":
			if(SoloUnElemento(f.name,'CheckSumi','M'))
			{
				Valores=Recuperar(f.name,'CheckSumi');
				if (Valores=="")
				{
					alert("Debe Seleccionar un Elemento para Modificar");
					return;
				}
				else
				{
					URL="../pcip_web/pcip_mantenedor_suministro_proceso.php?Opcion=M&Codigos="+Valores;
					window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":
			f.action = "pcip_mantenedor_suministro.php?Buscar=S";
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
				if (confirm("�Desea Eliminar los Suministros Seleccionados?"))
				{
					f.action = "pcip_mantenedor_suministro_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_mantenedor_suministro.php";
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
		<a href="JavaScript:Procesos('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		<a href="JavaScript:Procesos('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a><a href="JavaScript:Procesos('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
    <table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
      <tr>
        <td width="16%" height="17" class='formulario2'>Grupo Suministro</td>
        <td class="formulario2" ><label>
          <select name="CmbGrupoSuministro" onChange="Procesos('R')">
            <option value="-1" class="NoSelec">Seleccionar</option>
            <?
	  $Consulta = "select * from pcip_eec_suministros_grupos order by nom_agrupacion ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbGrupoSuministro==$FilaTC["cod_suministro_grupo"])
				echo "<option selected value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_suministro_grupo"]."'>".ucfirst($FilaTC["nom_agrupacion"])."</option>\n";
		}
			?>
          </select>
          </label>          </tr>
      <tr>
        <td height="25" class='formulario2'> Suministro </td>
        <td class='formulario2'><select name="CmbSuministro" >
            <option value="-1" class="NoSelec">Seleccionar</option>
            <?
	    $Consulta = "select t1.cod_suministro,t2.nom_suministro from pcip_eec_suministros_por_grupos t1 inner join pcip_eec_suministros t2 on t1.cod_suministro=t2.cod_suministro ";
	    $Consulta.= "where t1.cod_suministro_grupo='".$CmbGrupoSuministro."' order by t2.nom_suministro ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSuministro==$FilaTC["cod_suministro"])
				echo "<option selected value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_suministro"]."'>".ucfirst($FilaTC["nom_suministro"])."</option>\n";
		}
			?>
          </select>       </tr>
      <tr>
        <td height="25" class='formulario2'>A&ntilde;o</td>
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
          </select>          </tr>
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
<td width="9%" class="TituloTablaVerde" align="center" >Tipo</td>
<td width="9%" class="TituloTablaVerde" align="center" >CC</td>
<td width="6%" class="TituloTablaVerde" align="center" >Unid.</td>
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
  echo "<input type='hidden' name='CheckSumi'>";
  if($Buscar=='S')
  {
	$Consulta="select cod_cc,cod_unidad from pcip_eec_suministros_detalle where cod_suministro='".$CmbSuministro."' and  ano='".$Ano."' group by cod_cc order by cod_cc";
	//echo $Consulta; 	
	$Resp=mysqli_query($link, $Consulta);
	$Cont=0;	
	while($Fila=mysql_fetch_array($Resp))
	{
		 for($j=1;$j<=2;$j++)
		 {
			switch($j)
			{
				case "1":
					$NomTipo="Sumistro";
					$Tipo='S';
					$Unidad=$Fila["cod_unidad"];
					$Estilo='FilaAbeja';
				break;	
				case "2":
					$NomTipo="Cantidad Ppto";
					$Tipo='P';
					$Unidad=$Fila["cod_unidad"];
					$Estilo='FilaAbeja2';
				break;
			}
			$Cod=$CmbGrupoSuministro."~".$CmbSuministro."~".$Ano."~".$Fila[cod_cc]."~".$Tipo;
			?>
			<tr class="<? echo $Estilo;?>">
			<td><input type="checkbox" name='CheckSumi' class="SinBorde" value="<? echo $Cod; ?>"> </td>
			<td><? echo $NomTipo;?></td>
			<?
			 if($Fila[cod_cc]=='')
			 	$Fila[cod_cc]='SIN CC.';
			?>
			<td align="center"><? echo $Fila[cod_cc];?></td>
			<td align="center"><? echo $Unidad;?></td>
			<?
			 $Acum=0;
			 for($i=1;$i<=12;$i++)
			 {
				$Consulta="select * from pcip_eec_suministros_detalle where cod_suministro='".$CmbSuministro."' and  ano='".$Ano."' and mes='".$i."' and cod_cc='".$Fila[cod_cc]."' and tipo='".$Tipo."'";
				$RespMes=mysqli_query($link, $Consulta);
				if($FilaMes=mysql_fetch_array($RespMes))
				{
					$Cont++;
				?>	
				<td align="right">
				<? 
				echo number_format($FilaMes[valor],0,'','.');
				$Acum=$Acum+$FilaMes[valor];
				?>
				</td>
				<?
				}else{		
				?>
				<td align="right">0</td>
				<?
				}	
			 }
			 ?>
			 <td align="right"><? echo number_format($Acum,0,'','.');?></td>
			 <?
		}
		?>
		</tr>
	<?
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
		echo "alert('Suministros (s) Eliminado(s) Correctamente');";
	if($Cont==0&&$Buscar=='S')
		echo "alert('Informaci�n de Suministros No Encontrada');";	
	echo "</script>";
?>	
</body>
</html>