<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<title>Mantenedor Asignaciones</title>
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
			var URL = "../pcip_web/pcip_mantenedor_asignaciones_proceso.php?Opcion=N";
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
				   //alert(Valores);
					URL="../pcip_web/pcip_mantenedor_asignaciones_proceso.php?Opcion=M&Codigos="+Valores;
					window.open(URL,"","top=30,left=30,width=850,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":
			f.action = "pcip_mantenedor_asignaciones.php?Buscar=S";
			f.submit();
		break;
		case "E"://ELIMINAR
			var Valores="";
			Valores=Recuperar(f.name,'CheckAsig','E');
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
					f.CodigoEnviar.value=Valores;
					f.action ="pcip_mantenedor_asignaciones_proceso01.php?Opcion=E";
					f.submit();					
				}
			}
			break;
		case "D"://Cambiar de A�o Algunos registros o todos
//			var Valores="";
//			Valores=Recuperar(f.name,'CheckAsig','D');
//			if (Valores=="")
//			{
//				alert("Debe Seleccionar un Elemento para Cambiar A�o");
//				return;
//			}
//			else
//			{
//				if (confirm("�Desea Cambiar el A�o a los Registros Seleccionados?"))
//				{
//					Valores = Valores+"//";	
//					Valores=Valores.substr(0,Valores.length-2);						
//				    //alert(Valores);
					URL="../pcip_web/pcip_mantenedor_asignaciones_proceso_ano.php?Opcion=D";
					window.open(URL,"","top=240,left=360,width=470,height=200,status=yes,menubar=no,resizable=yes,scrollbars=yes");
//				}
//			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_mantenedor_asignaciones.php";
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
<input type="hidden" name="CodigoEnviar" value="">
<?
 $IP_SERV = $HTTP_HOST;
 EncabezadoPagina($IP_SERV,'asignaciones.png')
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
		<a href="JavaScript:Procesos('D')"><img src="archivos/duplicar.png"  border="0"  alt="Cambiar A�o" align="absmiddle" /></a>&nbsp;  
		<a href="JavaScript:Procesos('N')"><img src="archivos/nuevo2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Procesos('M')"><img src="archivos/btn_modificar3.png"  alt="Modificar " align="absmiddle" border="0"></a><a href="JavaScript:Procesos('E')"><img src="archivos/elim_hito2.png"  alt="Eliminar " align="absmiddle" border="0"></a>&nbsp;
		<a href="JavaScript:Procesos('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
    <table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
      <tr>
        <td width="9%" height="17" class='formulario2'>Asignaci&oacute;n</td>
        <td class="formulario2" ><label>
          <select name="CmbProd" onChange="Procesos('R')">
            <option value="-1" selected="selected">Todos</option>
            <?
	    $Consulta = "select * from pcip_svp_asignacion order by nom_asignacion ";			
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$Fila["cod_asignacion"])
				echo "<option selected value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_asignacion"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
		}
			?>
          </select>
        </label>        </tr>
      <tr>
        <td height="25" class='formulario2'> Producto </td>
        <td class='formulario2'><select name="CmbAsig" >
            <option value="-1" class="NoSelec">Todos</option>
            <?
	    $Consulta = "select * from pcip_svp_asignaciones_productos where cod_asignacion='".$CmbProd."'";			
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbAsig==$Fila["cod_producto"])
				echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
			else
				echo "<option value='".$Fila["cod_producto"]."'>".ucfirst($Fila["nom_asignacion"])."</option>\n";
		}
			?>
          </select>          
	    </tr>
    <tr>
	<td width="9%" class='formulario2'>A&ntilde;o
    <td width="91%" class='formulario2'><select name="Ano" id="Ano">
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
<td width="4%" class="TituloTablaVerde" align="center" ><input class='SinBorde' type="checkbox" name="CheckTodos" value="" onClick="CheckearTodo(this.form,'CheckAsig','CheckTodos');"></td>
<td width="10%" class="TituloTablaVerde" align="center" >Origen</td>
<td width="10%" class="TituloTablaVerde" align="center" >A�o</td>
<td width="10%" class="TituloTablaVerde" align="center" >Asignaci&oacute;n</td>
<td width="20%" class="TituloTablaVerde" align="center" >Producto</td>
<td width="20%" class="TituloTablaVerde" align="center" >Negocio</td>
<td width="20%" class="TituloTablaVerde" align="center" >Titulo Reporte</td>
<td width="10%" class="TituloTablaVerde"align="center" >N&ordm; Orden </td>
<td width="10%" class="TituloTablaVerde" align="center" >N&ordm; Orden Rel. </td>
<td width="10%" class="TituloTablaVerde" align="center">Material</td>
<td width="10%" class="TituloTablaVerde" align="center">Consumo Interno</td>
<td width="10%" class="TituloTablaVerde" align="center">VPtm</td>
<td width="10%" class="TituloTablaVerde" align="center">Signo</td>
<td width="10%" class="TituloTablaVerde" align="center">Factor</td>
<td width="10%" class="TituloTablaVerde" align="center">Nodo</td>
</tr>
<?
  if($Buscar=='S')
  {
	$Consulta="select t1.correlativo,t1.ano,t1.origen,t5.nom_titulo as titulo,t1.cod_asignacion,t1.cod_procedencia,t1.nodo,t1.cod_negocio,t1.num_orden,t1.num_orden_relacionada,";
	$Consulta.=" t1.cod_material,t1.consumo_interno,t2.nom_asignacion,t3.nom_asignacion as prod,t4.nom_negocio,t1.vptm,t1.signo,t1.factor"; 
	$Consulta.=" from pcip_svp_productos_procedencias t1 inner join pcip_svp_asignaciones_productos t2 on t1.cod_procedencia=t2.cod_producto inner join pcip_svp_asignacion t3 on t1.cod_asignacion=t3.cod_asignacion inner join pcip_svp_negocios t4 ";
	$Consulta.=" on t1.cod_negocio=t4.cod_negocio inner join pcip_svp_asignaciones_titulos t5 on t5.cod_asignacion=t1.cod_asignacion and t1.cod_titulo=t5.cod_titulo where t1.cod_asignacion <>''";
	if($CmbProd!='-1')
		$Consulta.="and t1.cod_asignacion='".$CmbProd."'";
	if($CmbAsig!='-1')
		$Consulta.="and t1.cod_procedencia='".$CmbAsig."'";	
	if($Ano!='-1')
		$Consulta.="and t1.ano='".$Ano."'";	
	$Consulta.=" order by t1.correlativo,t1.cod_asignacion";
	$Resp=mysqli_query($link, $Consulta);$Cont=0;
	//echo $Consulta."<br>";
	echo "<input name='CheckAsig' type='hidden'>";
	while($Fila=mysql_fetch_array($Resp))
	{
		if($Fila[origen]=='ENA'||$Fila[origen]=='PMN')
		{
			if($Fila[num_orden_relacionada]=='1')
				$Fila[num_orden_relacionada]='COBRE';
			if($Fila[num_orden_relacionada]=='2')
				$Fila[num_orden_relacionada]='PLATA';
			if($Fila[num_orden_relacionada]=='3')
				$Fila[num_orden_relacionada]='ORO';
			if($Fila["nodo"]=='2')
				$Fila["nodo"]='FLUJO';
			else
				$Fila["nodo"]='EXISTENCIA';				
		}		
  		$Cod=$Fila[correlativo]."~".$Fila[cod_asignacion]."~".$Fila[cod_procedencia]."~".$Fila[cod_negocio]."~".$Fila[num_orden]."~".$Fila[num_orden_relacionada]."~".$Fila[origen]."~".$Fila[vptm];
		echo "<tr>";
		echo "<td align='center'><input name='CheckAsig' type='checkbox' value='".$Cod."' class='SinBorde' ></td>";
		echo "<td align='center'>".$Fila[origen]."</td>";
		echo "<td align='center'>".$Fila[ano]."</td>";
		echo "<td>".$Fila[prod]."</td>";
		echo "<td>".$Fila[nom_asignacion]."</td>";
		echo "<td>".$Fila[nom_negocio]."</td>";
		echo "<td>".$Fila[titulo]."</td>";
		echo "<td align='center'>".$Fila[num_orden]."&nbsp;</td>";
		echo "<td align='center'>".$Fila[num_orden_relacionada]."&nbsp;</td>";
		echo "<td align='center'>".$Fila[cod_material]."&nbsp;</td>";
		echo "<td align='center'>".$Fila[consumo_interno]."&nbsp;</td>";
		echo "<td align='center'>".$Fila[vptm]."&nbsp;</td>";
		echo "<td align='center'>".$Fila["signo"]."&nbsp;</td>";
		echo "<td align='center'>".number_format($Fila[factor],4,',','.')."&nbsp;</td>";
		echo "<td align='center'>".$Fila["nodo"]."&nbsp;</td>";
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
	if($Mensaje!='1'&&$Cont==0&&$Buscar=='S')
		echo "alert('Informaci�n de Asignacion No Encontrada');";
	echo "</script>";
?>	
</body>
</html>
