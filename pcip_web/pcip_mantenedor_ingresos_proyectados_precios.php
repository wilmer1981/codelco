<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<title>Mantenedor Precios-Gener Barro</title>
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
			var URL = "../pcip_web/pcip_mantenedor_ingresos_proyectados_precios_proceso.php?Opcion=N";
			window.open(URL,"","top=30,left=30,width=1200,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
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
					URL="../pcip_web/pcip_mantenedor_ingresos_proyectados_precios_proceso.php?Opcion=M&Codigos="+Valores;
					window.open(URL,"","top=30,left=30,width=1200,height=550,status=yes,menubar=no,resizable=yes,scrollbars=yes");
				}
			}
		break;
		case "C":
			f.action = "pcip_mantenedor_ingresos_proyectados_precios.php?Buscar=S";
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
				if (confirm("�Desea Eliminar los Precios de Suministros Seleccionados?"))
				{
					f.action = "pcip_mantenedor_ingresos_proyectados_precios_proceso01.php?Opcion=E&Valores="+Valores;
					f.submit();
				}
			}
			break;
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_mantenedor_ingresos_proyectados_precios.php";
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
 EncabezadoPagina($IP_SERV,'precio_ingreso_proyectado.png')
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
           <td width="180" class="formulario2">Seleccionar Proveniencia </td>
           <td class="FilaAbeja2">
			<select name="CmbDatos" onChange="Procesos('R')">			
			<?
			 switch($CmbDatos)
			 {
			 	case "1":
				        echo"<option value='1' selected>PRECIOS</option>";
						echo"<option value='2' >GENER BARRO</option>";  
				break;
			 	case "2":
				        echo"<option value='1' >PRECIOS</option>";
						echo"<option value='2' selected>GENER BARRO</option>";  
				break;
			 	default:
				        echo"<option value='1' selected>PRECIOS</option>";
						echo"<option value='2' >GENER BARRO</option>";  
				break;				
			 }
			?>
		    </select>		  
			</td>
		 </tr>
      <tr>
        <td width="16%" height="17" class='formulario2'>Producto</td>
        <td class="formulario2" ><label>
          <select name="CmbProducto" onChange="Procesos('R')">
            <option value="T" class="NoSelec">Todos</option>
            <?
			$Consulta = "select distinct t1.cod_producto,t2.nombre_subclase from pcip_inp_precios_dore t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31032'";
			$Consulta.= " and t1.cod_producto=t2.cod_subclase where t1.dato='".$CmbDatos."'";			
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbProducto==$FilaTC["cod_producto"])
				{
					echo "<option selected value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";					
				}
				else
					echo "<option value='".$FilaTC["cod_producto"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
			?>
          </select>
          </label>          
		  </tr>
      <tr>
        <td height="25" class='formulario2'>A&ntilde;o</td>
        <td class='formulario2'><select name="Ano" onChange="Procesos('R')">
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
<td width="4%" class="TituloTablaVerde" align="center" rowspan="2"><input class='SinBorde' type="checkbox" name="CheckSumi" value="" onClick="CheckearTodo(this.form,'CheckDisp','CheckSumi');"></td>
<td width="6%" class="TituloTablaVerde" align="center" rowspan="2">Datos Provenientes</td>
<td width="6%" class="TituloTablaVerde" align="center" rowspan="2">Producto</td>
<td width="6%" class="TituloTablaVerde"align="center" colspan="2">Ene</td>
<td width="6%" class="TituloTablaVerde" align="center" colspan="2">Feb</td>
<td width="6%" class="TituloTablaVerde" align="center"colspan="2">Mar</td>
<td width="6%" class="TituloTablaVerde" align="center" colspan="2">Abr</td>
<td width="6%" class="TituloTablaVerde"align="center" colspan="2">Mayo</td>
<td width="6%" class="TituloTablaVerde"align="center" colspan="2">Jun</td>
<td width="6%" class="TituloTablaVerde"align="center" colspan="2">Jul</td>
<td width="6%" class="TituloTablaVerde"align="center" colspan="2">Ago</td>
<td width="6%" class="TituloTablaVerde"align="center" colspan="2">Sep</td>
<td width="6%" class="TituloTablaVerde"align="center" colspan="2">Oct</td>
<td width="6%" class="TituloTablaVerde"align="center" colspan="2">Nov</td>
<td width="6%" class="TituloTablaVerde"align="center" colspan="2">Dic</td>
</tr>
 <tr align="center">
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
	<td width="7%" class="TituloTablaVerde">Real</td>
	<td width="7%" class="TituloTablaVerde">Ppto</td>
 </tr>

<?
  if($Buscar=='S')
  {  
	$Consulta ="select t1.dato,t1.cod_producto,t2.nombre_subclase as nom_producto,t1.valor_real,t1.valor_ppto,t1.ano,t1.mes,t2.valor_subclase1 from pcip_inp_precios_dore t1 inner join";
	$Consulta.=" proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31032' and t1.cod_producto=t2.cod_subclase where cod_producto<>'' and dato='".$CmbDatos."'";			
	if($CmbProducto!='T')
		$Consulta.=" and cod_producto='".$CmbProducto."'"; 	
	if($Ano!='-1')
		$Consulta.=" and ano='".$Ano."'"; 	
	$Consulta.=" group by cod_producto"; 
	//echo 	$Consulta."<br>";		
	$Resp=mysqli_query($link, $Consulta);
	echo "<input type='hidden' name='CheckSumi'>";	
	while($Fila=mysql_fetch_array($Resp))
	{
	        $Dato=$Fila[dato];
	        $CodProducto=$Fila["cod_producto"];
			$Producto=$Fila["nom_producto"];
			$Ano=$Fila[ano];
			$Mes=$Fila[mes];
			$ValorReal=$Fila[valor_real];
			$ValorPpto=$Fila[valor_ppto];
			$Cod=$Dato."~".$CodProducto."~".$Ano;
			
			$Consulta2 = "select distinct(t1.cod_subclase),t1.nombre_subclase,t2.nombre_subclase as nom_unidad from proyecto_modernizacion.sub_clase t1";
			$Consulta2.= " inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31013' and t1.valor_subclase1=t2.cod_subclase";	
			$Consulta2.= " where t1.cod_clase='31032' and t1.valor_subclase1='".$Fila["valor_subclase1"]."' order by cod_subclase"; 	
			$Resp2=mysql_query($Consulta2);
			while($Fila2=mysql_fetch_array($Resp2))
			{
			 	$Unidad=$Fila2[nom_unidad];
			}
				if($Dato=='1')
					$Dato='PRECIOS';
				else
					$Dato='Gener Barro';
				?>
				<tr class="<? echo $Estilo;?>">
				<td align="center"><input type="checkbox" name='CheckSumi' class="SinBorde" value="<? echo $Cod; ?>"> </td>
				<td align="center"><? echo $Dato;?></td>
				<td align="left"><? echo $Producto."&nbsp;&nbsp;".$Unidad;?></td>
				<?
				 for($i=1;$i<=12;$i++)
				 {
					$Consulta1 ="select * from pcip_inp_precios_dore where cod_producto<>''";
					if($CodProducto!='T')				
						$Consulta1.=" and cod_producto='".$CodProducto."'";
					if($Ano!='-1')				
						$Consulta1.=" and ano='".$Ano."' and Mes='".$i."'";
					//echo $Consulta1;
					$RespMes=mysql_query($Consulta1);
					if($FilaMes=mysql_fetch_array($RespMes))
					{
						?>	
						<td align="right">
						<? 
						echo number_format($FilaMes[valor_real],2,',','.');
						?>
						</td>
						<td align="right">
						<? 
						echo number_format($FilaMes[valor_ppto],2,',','.');
						?>
						</td>
				 <?	
					}
				 }
				 ?>
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
		echo "alert('Registro Eliminado Correctamente');";
	echo "</script>";
?>	
</body>
</html>