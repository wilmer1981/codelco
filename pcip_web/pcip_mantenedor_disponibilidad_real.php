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
<title>Mantenedor Disponibilidad Real</title>
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
			var URL = "../pcip_web/pcip_mantenedor_disponibilidad_real_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
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
					URL="../pcip_web/pcip_mantenedor_disponibilidad_real_proceso.php?Opcion=M&Codigos="+Valores;
					window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":
			f.action = "pcip_mantenedor_disponibilidad_real.php?Buscar=S";
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
				if (confirm("¿Desea Eliminar las Disponibilidades Seleccionados?"))
				{
					f.action = "pcip_mantenedor_disponibilidad_real_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_mantenedor_disponibilidad_real.php";
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
 EncabezadoPagina($IP_SERV,'disponibilidad_real.png')
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
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbSistema==$FilaTC["cod_sistema"])
				echo "<option selected value='".$FilaTC["cod_sistema"]."'>".ucfirst(strtolower($FilaTC["nom_sistema"]))."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_sistema"]."'>".ucfirst(strtolower($FilaTC["nom_sistema"]))."</option>\n";
		}
			?>
    </select>  </tr>
  <tr>
    <td height="17" class='formulario2'>Equipos</td>
    <td colspan="3" class='formulario2'><select name="CmbEquipos">
        <option value="-1" selected="selected">Todos</option>
        <?
	  	$Consulta = "select t1.cod_equipo,t2.nom_equipo from pcip_eec_equipos_por_sistema t1 inner join pcip_eec_equipos t2 on t1.cod_equipo=t2.cod_equipo where t1.cod_sistema='".$CmbSistema."' order by t2.nom_equipo ";			
		$Resp=mysql_query($Consulta);
		while ($FilaTC=mysql_fetch_array($Resp))
		{
			if ($CmbEquipos==$FilaTC["cod_equipo"])
				echo "<option selected value='".$FilaTC["cod_equipo"]."'>".ucfirst(strtolower($FilaTC["nom_equipo"]))."</option>\n";
			else
				echo "<option value='".$FilaTC["cod_equipo"]."'>".ucfirst(strtolower($FilaTC["nom_equipo"]))."</option>\n";
		}
			?>
      </select> <? //echo $Consulta;?>
	  </tr>
  <tr>
    <td height="17" class='formulario2'>A&ntilde;o </td>
    <td width="12%" class='formulario2'><select name="Ano" id="Ano">
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
    <td width="9%" class='formulario2'>Mes    
    <td width="63%" class='formulario2'><select name="Mes" id="Mes">
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
    </select>        </tr>
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
<td width="5%" class="TituloTablaVerde" align="center" >&nbsp;</td>
<td width="15%" class="TituloTablaVerde" align="center" >Sistema</td>
<td width="15%" class="TituloTablaVerde" align="center" >Equipo</td>
<td width="5%" class="TituloTablaVerde" align="center" >A&ntilde;o</td>
<td width="15%" class="TituloTablaVerde"align="center" >Mes</td>
<td width="15%" class="TituloTablaVerde" align="center" >Horas Disponibles</td>
<td width="15%" class="TituloTablaVerde" align="center">Horas Reales</td>
<td width="15%" class="TituloTablaVerde" align="center">Disponibilidad [%] </td>
</tr>
<?
  echo "<input type='hidden' name='CheckDisp'>";
  if($Buscar=='S')
  {
	$Consulta="select t1.cod_sistema,t1.cod_equipo,t1.ano,t2.nom_sistema,t3.nom_equipo,t1.valor,t1.valor_real,t1.mes from pcip_eec_disponibilidades t1 inner join pcip_eec_sistemas t2 on t1.cod_sistema=t2.cod_sistema ";
	$Consulta.="inner join pcip_eec_equipos t3 on t1.cod_equipo=t3.cod_equipo where t1.tipo_disponibilidad='R' and  ano='".$Ano."'";
	if($Mes!='T')
		$Consulta.= " and t1.mes='".$Mes."' ";
	if($CmbSistema!='-1')
		$Consulta.= " and t1.cod_sistema='".$CmbSistema."' ";
	if($CmbEquipos!='-1')
		$Consulta.= " and t1.cod_equipo='".$CmbEquipos."' ";
	//$Consulta.= " group by t1.cod_sistema,t1.cod_equipo,t1.tipo_disponibilidad,t1.ano ";	
	//echo $Consulta; 	
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$Sistema=$Fila[nom_sistema];
		$Equipo=$Fila[nom_equipo];
		$Año=$Fila[ano];
		$Mes=$Meses[$Fila[mes]-1];
		$Cod=$Fila[cod_sistema]."~".$Fila[cod_equipo]."~".$Fila[ano]."~".$Fila[mes];
		$Valor=$Fila[valor];
		$ValorReal=$Fila[valor_real];
		?>
		<tr class="FilaAbeja">
		<td><input type="checkbox" name='CheckDisp' class="SinBorde" value="<? echo $Cod; ?>"> </td>
		<td><? echo $Sistema;?></td>
		<td><? echo $Equipo;?></td>
		<td align="center"><? echo $Año;?></td>
		<td align="center"><? echo $Mes;?></td>
		<td align="center"><? echo number_format($Valor,2,',','.');?></td>
		<td align="right"><? echo number_format($ValorReal,2,',','.');?></td>
		<?
		if($Valor>0)
			$Disp=($ValorReal/$Valor)*100;
		else
			$Disp=0;
		?>
		<td align="right"><? echo number_format($Disp,2,',','.');?></td>
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
		echo "alert('Disponibilidad Real(s) Eliminado(s) Correctamente');";
	echo "</script>";
?>	
</body>
</html>