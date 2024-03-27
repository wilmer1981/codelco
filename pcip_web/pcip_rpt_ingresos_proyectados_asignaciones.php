<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbContr))
	$CmbContr='-1';		
?>
<html>
<head>
<title>Reporte Ingresos Proyectados Asignaciones</title>
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
function Proceso(TipoProceso)
{
	var f = document.frmPrincipal;
	switch(TipoProceso)
	{
		case "C":
			f.action = "pcip_rpt_ingresos_proyectados_asignaciones.php?Buscar=S";
			f.submit();
		break;
		case "E"://GENERA EXCEL
			URL='pcip_rpt_ingresos_proyectados_asignaciones_excel.php?CmbProducto='+f.CmbProducto.value+'&Ano='+f.Ano.value+'&Mes='+f.Mes.value+'&MesFin='+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;				
		case "R":
			f.action = "pcip_rpt_ingresos_proyectados_asignaciones.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
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
 EncabezadoPagina($IP_SERV,'ingresos_proyectados_report_asignacion.png')
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
		<td width="82%" align="left" class='formulario2'><img src="archivos/images/interior/t_buscadorGlobal4.png"></td>
	    <td width="18%" align="right" class='formulario2'>
		<a href="JavaScript:Proceso('C')"><span class="formulario2"></span></a><a href="JavaScript:Proceso('C')"><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a> 
		<a href="JavaScript:Proceso('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> 
		<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a></td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
   <tr>
   <td width="94" height="17" class='formulario2'>Productos</td>
   <td width="833" class="formulario2"><select name="CmbProducto" onChange="Proceso('R')">
   <option value="T" class="NoSelec">Todos</option>
   <?
	$Consulta = "select distinct(t2.cod_subclase),t2.nombre_subclase from pcip_inp_asignacion t1 left join";
	$Consulta.= " proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31029' and t1.cod_producto=t2.cod_subclase order by nombre_subclase ";			
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysql_fetch_array($Resp))
	{
		if ($CmbProducto==$Fila["cod_subclase"])
			echo "<option selected value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
		else
			echo "<option value='".$Fila["cod_subclase"]."'>".ucfirst($Fila["nombre_subclase"])."</option>\n";
	}
   ?>
   </select><? //echo $Consulta;?>   </td>
   </tr>
   <tr>
    <td height="25" class='formulario2'>Periodo</td>
    <td colspan="5" class='formulario2'>A&ntilde;o &nbsp;&nbsp;&nbsp;
      <select name="Ano" id="Ano">
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
      &nbsp;Desde 
	   </select>
		<select name="Mes" id="Mes">
		<?
		for ($i=1;$i<=12;$i++)
		{
			if ($i==$Mes)
				echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
			else
				echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
		}
		?>
		</select>      
		Hasta
	   </select>
		<select name="MesFin">
		<?
			for ($i=1;$i<=12;$i++)
			{
				if ($i==$MesFin)
					echo "<option selected value=\"".$i."\">".$Meses[$i-1]."</option>\n";
				else
					echo "<option value=\"".$i."\">".$Meses[$i-1]."</option>\n";
			}
		?>
		</select>	</td> 
	</tr>	 
 </table>  
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
        <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
        <td><table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
          <tr>
            <td width="20%" class="TituloTablaVerde" align="center" rowspan="2">Asignaciones Divisi&oacute;n Ventanas</td>	
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			?>
            <td width="7%" class="TituloTablaVerde"align="center" colspan="2"><? echo $Meses[$i-1]?></td>
            <?	
			}
			?>            
          </tr>
          <tr>
            <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			?>
            <td width="7%" class="TituloTablaVerde" align="center" >Real</td>
            <td width="7%" class="TituloTablaVerde" align="center">Proyectado</td>
            <?	
			}
			?>
          </tr>
          <?		
  			 if($Buscar=='S')
			 {	
				$Consulta ="select distinct(t2.nombre_subclase) ,t2.cod_subclase  from pcip_inp_asignacion t1";
				$Consulta.=" left join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='31029' and t2.cod_subclase=t1.cod_producto";
				$Consulta.=" where t1.cod_producto<>''";	
				if($CmbProducto!='T')
					$Consulta.=" and t1.cod_producto='".$CmbProducto."'";	
				//echo $Consulta."<br>"; 	
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					$NomProducto=$Fila["nombre_subclase"];
					$CodProducto=$Fila["cod_subclase"];
					?>
					  <tr class="Formulario2">
						<td rowspan="1" colspan="25" align="left"><?  echo $NomProducto;?></td>
					  </tr>		
					<?
						$Consulta1 ="select nombre_subclase,cod_subclase from proyecto_modernizacion.sub_clase where cod_clase='31030' and valor_subclase1='".$CodProducto."'";						
						//if($CmbProveedores!='T')
							//$Consulta1.=" and cod_subclase='".$CmbProveedores."'";												
						//echo $Consulta1; 	
						$Resp1=mysql_query($Consulta1);
						while($Fila1=mysql_fetch_array($Resp1))
						{
							$NomProveedor=$Fila1["nombre_subclase"];
							$CodProveedor=$Fila1["cod_subclase"];							
							?>
							  <tr class="FilaAbeja">
								<td rowspan="1" align="left"><?  echo $NomProveedor;?></td>
								<?
								for($i=$Mes;$i<=$MesFin;$i++)
								{
								?>
								<td rowspan="1" align="right"><?  echo number_format(DatosProyectadosSVP($CodProducto,$CodProveedor,$Ano,$i),0,',','.');?>&nbsp;</td>
								<td rowspan="1" align="right"><?  echo number_format(DatosProyectadosPPC($CodProducto,$CodProveedor,$Ano,$i),0,',','.');?>&nbsp;</td>
								<?
								}
								?>
							  </tr>		
							<?														
						}
					?>  						
		     <?				       
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
function DatosProyectadosSVP($Producto,$Proveedor,$Ano,$Mes)
{
   $Consulta="select Vporden,Vptm,VPmaterial,Vptipinv,VPordenrel,Vpordes from pcip_inp_asignacion";
   $Consulta.=" where cod_producto='".$Producto."' and cod_proveedor='".$Proveedor."' and dato='1'";
   //echo $Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);  
   if($Fila=mysql_fetch_array($Resp))
   {
     $Orden=$Fila[Vporden];
     $Tm=$Fila[Vptm];
     $Material=$Fila[VPmaterial];
     $Tipinv=$Fila[Vptipinv];
	 $OrdenRel=$Fila[VPordenrel];
     $Ordes=$Fila[Vpordes]; 	 	 	 	 
   }       
	$Consulta1 =" select VPcantidad from pcip_svp_valorizacproduccion ";
	$Consulta1.=" where VPorden='".$Orden."' and VPtm='".$Tm."' and VPmaterial='".$Material."' and VPtipinv='".$Tipinv."' and VPordenrel='".$OrdenRel."' and VPordes='".$Ordes."' and VPa�o='".$Ano."' and VPmes='".$Mes."'";
	//echo $Consulta1."<br>";
	$RespAux=mysql_query($Consulta1);
	if($FilaAux=mysql_fetch_array($RespAux))
	{
		$Datos1=$FilaAux[VPcantidad];
		//echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
		//$Datos2=$FilaAux[ValorPresupuestado];
		//echo "Valor datos consyulta 2   ".$Datos2."<br>";
	}
		return($Datos1);	
}
function DatosProyectadosPPC($Producto,$Proveedor,$Ano,$Mes)
{
   $Datos2=0;
   $Consulta="select Vporden,Vptm,VPmaterial,Vptipinv from pcip_inp_asignacion";
   $Consulta.=" where cod_producto='".$Producto."' and cod_proveedor='".$Proveedor."' and dato='2'";
   //echo $Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);  
   while($Fila=mysql_fetch_array($Resp))
   {
		$Asignacion=$Fila[Vporden];
		$Procedencia=$Fila[Vptm];
		$Negocio=$Fila[VPmaterial];
		$Titulo=$Fila[Vptipinv];
		
		$Consulta2 =" select valor from pcip_ppc_detalle ";
		$Consulta2.=" where ano='".$Ano."' and mes='".$Mes."' and cod_asignacion='".$Asignacion."' and cod_procedencia='".$Procedencia."' and cod_negocio='".$Negocio."' and cod_titulo='".$Titulo."'";
		//echo $Consulta2."<br>";
		$RespAux1=mysql_query($Consulta2);
		if($FilaAux1=mysql_fetch_array($RespAux1))
		{
			$Datos2=$Datos2+$FilaAux1[valor];
			//echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
			//$Datos2=$FilaAux[ValorPresupuestado];
			//echo "Valor datos consyulta 2   ".$Datos2."<br>";
		}
	}
	return($Datos2);	
}
?>
