<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
?>
<html>
<head>
<title>Reporte Venta Productos Comerciales</title>
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
	var URL='';
	switch(TipoProceso)
	{
		case "C":
			if(f.Ano.value=='T')
			{
				alert("Debe seleccionar A�o");
				f.Ano.focus();
				return;
			}							
			f.action = "pcip_rpt_productos_ventas.php?Buscar=S";
			f.submit();
		break;
		case "E"://GENERA EXCEL
			URL='pcip_rpt_productos_ventas_excel.php?Ano='+f.Ano.value+'&Mes='+f.Mes.value+'&MesFin='+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;		
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_rpt_productos_ventas.php";
			f.submit();
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=12";
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
 EncabezadoPagina($IP_SERV,'ventas_ productos_comerciales_report.png')
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
		<a href="JavaScript:Proceso('C')"><span class="formulario2"></span><img src="archivos/Find2.png"   alt="Buscar"  border="0" align="absmiddle" /></a>    
		<a href="JavaScript:Proceso('E')"><img src="archivos/ico_excel5.jpg"   alt="Excel"  border="0" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('I')"><img src="archivos/Impresora2.png"  border="0"  alt="Nuevo" align="absmiddle" /></a>&nbsp;
		<a href="JavaScript:Proceso('S')"><img src="archivos/volver2.png" align="absmiddle" alt="Volver" border="0"></a>		</td>
	</tr>
</table>
<table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
  <tr>
	   <td width="7%" align="left" class='formulario2'>A&ntilde;o
	   <td width="93%" class='formulario2'><select name="Ano" id="Ano">
	   <option value="T" selected="selected" onChange="Proceso('R')">Todos</option>
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
	  <tr>
		<td height="17" class='formulario2'> Periodo</td>
		<td class='formulario2'>Desde 
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
		</select>  
	</tr>	 
  <tr>
    <td colspan="6" class='formulario2'>  </tr>
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
		<td width="20%" class="TituloTablaVerde" align="center" >Producto/Mes<br>
		  <? echo $Ano;?></td>
		  <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
		  	?>
			<td width="7%" class="TituloTablaVerde"align="center" ><? echo $Meses[$i-1]?></td>
			<?	
			}
		  ?>
		<td width="6%" class="TituloTablaVerde"align="center">Acum</td>		
		</tr>
			<?
			?>
			<tr><td class="Formulario2" colspan="14">1. Cobre</td></tr>
			<?
			
			  if($Buscar=='S')
			  {			    
				$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
				$Consulta.=" where cod_clase='31014' and valor_subclase1='C'";
				$Consulta.= " group by cod_grupo";	
				//echo $Consulta; 	
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
					$NomGrupo=$Fila[nom_grupo];
					$CodGrupo=$Fila["cod_grupo"];
					?>
					<tr class="FilaAbeja">
					<td rowspan="1" align="left"><? echo $NomGrupo;?></td>
					<?
					$Acum=0;$ContMes=0;	
					for($i=$Mes;$i<=$MesFin;$i++)
					{
						
						$Consulta =" select sum(kilos_finos) as KiloFino,sum(valor_cif_neto) as ValorNeto from pcip_cdv_productos_ventas_por_grupo t1 inner join pcip_cdv_cuadro_diario_ventas t2 on t1.cod_producto=t2.cod_producto ";
						$Consulta.=" where t1.cod_grupo='".$CodGrupo."' and t2.ano='".$Ano."' and mes='".$i."' and ajuste='N'";
						$Consulta.=" group by t1.cod_grupo ";
						//if($CodGrupo=='1'&&$i==1)
						//	echo $Consulta."<br>";
						$Resp2=mysql_query($Consulta);
						if($Fila2=mysql_fetch_array($Resp2))
						{
							if($Fila2[KiloFino]<>0)
							{
								$ContMes++;
								switch($CodGrupo)
								{
									case "1":
									case "2":
									case "3":
									//if($CodGrupo=='1'&&$i==1)
									//	 echo 	$Fila2[ValorNeto]."   ".$Fila2[KiloFino]."<br>";
									$Valor=1000*($Fila2[ValorNeto]/$Fila2[KiloFino]);
									break;
									default:
										$Valor=$Fila2[ValorNeto]/$Fila2[KiloFino];
									break;
								}		
							}
							else
								$Valor=0;
						}
						else
							$Valor=0;
						echo "<td align='right'>".number_format($Valor,2,',','.')."</td>";
						$Acum=$Acum+$Valor;	
					}
					if($ContMes>0)
						$Acum=$Acum/$ContMes;					    
					echo "<td align='right'>".number_format($Acum,2,',','.')."</td>";							    
					?>
					</tr>
					<?
				}
				    ?>
					<tr><td class="Formulario2" colspan="14">3. SubProductos</td></tr>
   				    <?
							$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
							$Consulta.=" where cod_clase='31014' and valor_subclase1='S'";
							$Consulta.= " group by cod_grupo";	
							//echo $Consulta; 	
							$Resp=mysql_query($Consulta);
							while($Fila=mysql_fetch_array($Resp))
							{
								$NomGrupo=$Fila[nom_grupo];
								$CodGrupo=$Fila["cod_grupo"];
								?>
								<tr class="FilaAbeja">
								 <td rowspan="1" align="left"><? echo $NomGrupo;?></td>
								<?	
								$Acum2=0;$ContMes=0;	
								for($i=$Mes;$i<=$MesFin;$i++)
								{
									
									$Consulta =" select sum(kilos_finos) as KiloFino,sum(valor_cif_neto) as ValorNeto from pcip_cdv_productos_ventas_por_grupo t1 inner join pcip_cdv_cuadro_diario_ventas t2 on t1.cod_producto=t2.cod_producto ";
									$Consulta.=" where t1.cod_grupo='".$CodGrupo."' and t2.ano='".$Ano."' and mes='".$i."' and ajuste='N'";
									$Consulta.=" group by t1.cod_grupo ";
									$Resp2=mysql_query($Consulta);
									if($Fila2=mysql_fetch_array($Resp2))
									{
										if($Fila2[KiloFino]>0)
										{
											$ContMes++;
											switch($CodGrupo)
											{
												case "1":
												case "11":
												case "13":
													$Valor=1000*($Fila2[ValorNeto]/$Fila2[KiloFino]);
												break;
												case "14":
												case "15":
													$Valor=($Fila2[ValorNeto]/$Fila2[KiloFino])*(1/35.2739619);
												break;
												default:
													$Valor=$Fila2[ValorNeto]/$Fila2[KiloFino];
												break;
											}		
										}
										else
											$Valor=0;
									}
									else
										$Valor=0;
									echo "<td align='right'>".number_format($Valor,2,',','.')."</td>";	
									$Acum2=$Acum2+$Valor;
								}	
								if($ContMes>0)
									$Acum2=$Acum2/$ContMes;					    
								 
								 echo "<td align='right'>".number_format($Acum2,2,',','.')."</td>";							    
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
		echo "alert('Variaciones Inventario (s) Eliminado(s) Correctamente');";
	echo "</script>";
?>	
</body>
</html>