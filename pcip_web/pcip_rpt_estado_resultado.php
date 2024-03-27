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

?>
<html>
<head>
<title>Reporte Estado Resultado</title>
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
function oculta(numero) 
{

	var f=document.frmPrincipal;
			eval(numero + ".style.visibility = 'hidden'");
}
function muestra(numero) 
{
 	var f=document.frmPrincipal;
		eval(numero + ".style.visibility = 'visible'");
		
	
/*	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	
	{
		if (ie4)
		{
			eval(numero + ".style.visibility = 'visible'");
		
		}
	}*/
	//eval("f.Obs.value=f.ObsHito_"+ Hito +".value");
}
function Proceso(TipoProceso)
{
	var f = document.frmPrincipal;
	var URL='';
	var numero;
	switch(TipoProceso)
	{
		case "C":
			if(f.Ano.value=='T')
			{
				alert("Debe seleccionar A�o");
				f.Ano.focus();
				return;
			}
			if(parseInt(f.Mes.value)>parseInt(f.MesFin.value))
			{
				alert('Mes Hasta debe ser menor o igual Mes Desde');
				return;
			}
			f.action = "pcip_rpt_estado_resultado.php?Buscar=S";
			f.submit();
		break;
		case "E"://GENERA EXCEL
			URL='pcip_rpt_estado_resultado_excel.php?Ano='+f.Ano.value+'&Mes='+f.Mes.value+'&MesFin='+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;		
		case "I"://IMPRIMIR
			window.print();
			break;
		case "R":
			f.action = "pcip_rpt_estado_resultado.php";
			f.submit();
		break;
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=11";
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
 EncabezadoPagina($IP_SERV,'rpt_estado_resultado.png')
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
	   <td width="12%" align="right" class='formulario2'>A&ntilde;o
	   <td width="88%" class='formulario2'><select name="Ano" id="Ano">
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
	   </select>	 </tr>
	  <tr>
		<td height="17" class='formulario2'> Periodo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desde</td>
		<td class='formulario2'></select>
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
		</select>	</tr>	 
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
		<td width="26%" class="TituloTablaVerde" align="center" >Resumen por Producto </td>
		  <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
		  ?>
			<td class="TituloTablaVerde"align="center" colspan="3"><? echo $Meses[$i-1];?></td>
		  <?	
			}
		  ?>
			<td class="TituloTablaVerde"align="center" colspan="3">Acumulado</td>
		</tr>
		<tr>
		<td width="26%" class="TituloTablaVerde"align="center" >&nbsp;</td>
		  <?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
		  ?>
			<td width="12%" class="TituloTablaVerde" align="center" >Ingreso</td>
			<td width="12%" class="TituloTablaVerde" align="center">Costos</td>
			<td width="24%" class="TituloTablaVerde" align="center">Margen</td>
		  <?	
			}
		  ?>
			<td width="8%" class="TituloTablaVerde" align="center" >Ingreso</td>
			<td width="10%" class="TituloTablaVerde" align="center">Costos</td>
			<td width="8%" class="TituloTablaVerde" align="center">Margen</td>
		</tr>
			<?
			?>
			<tr><td class="Formulario2" colspan="37">1. Cobre</td>			
			</tr>
			<?			
			 if($Buscar=='S')
			 {			    
				$ArrayTot=array();$ArrayTotalCobre1=array();$ArrayTotalCobre2=array();$ArrayTotalCobre3=array();$ValorMaquilas=array();				
				$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
				$Consulta.=" where cod_clase='31019' and valor_subclase1='C' and cod_subclase not in ('21','23','24','25')";
				$Consulta.= " group by cod_grupo";	
				//echo $Consulta; 	
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{
						$NomGrupo=$Fila[nom_grupo];
						$CodGrupo=$Fila["cod_grupo"];
						?>
						<tr class="FilaAbeja">
						<td rowspan="1" align="left"><? echo $NomGrupo;?></td>
						<?
						for($i=$Mes;$i<=$MesFin;$i++)
						{						
							$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
							$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
							$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes='".$i."' ";
							$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes='".$i."' ";
							$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
							$Consulta.=" group by t2.cod_grupo ";
							//if($CodGrupo=='19'&&$i==1)
							//echo $Consulta."<br>";
							$Valor=0;$Valor1=0;$Valor2=0;
							$Resp2=mysqli_query($link, $Consulta); 
							if($Fila2=mysql_fetch_array($Resp2))
							{
								$Valor=$Fila2[ValorIngreso];
								$Valor1=$Fila2[ValorCosto];
								$Valor2=$Fila2[ValorIngreso]+$Fila2[ValorCosto];
								$ArrayTot[$i][1]=$ArrayTot[$i][1]+$Valor;
								$ArrayTot[$i][2]=$ArrayTot[$i][2]+$Valor1;
								$ArrayTot[$i][3]=$ArrayTot[$i][3]+$Valor2;
								echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
								echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";	
							}
							else
							{	$Valor=0;
								echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
								echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";		
							}		
						}		
							$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
							$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
							$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes between '1' and '".$MesFin."'";
							$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes between '1' and '".$MesFin."' ";
							$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
							$Consulta.=" group by t2.cod_grupo ";
							//if($CodGrupo=='19'&&$i==1)
							//echo $Consulta."<br>";
							$ValorAcumulado1=0;$ValorAcumulado2=0;$ValorAcumuladoMargen=0;
							$Resp2=mysqli_query($link, $Consulta); 
							if($Fila2=mysql_fetch_array($Resp2))
							{
							   $ValorAcumulado1=$Fila2[ValorIngreso];
							   $ValorAcumulado2=$Fila2[ValorCosto];
							   $ValorAcumuladoMargen=$Fila2[ValorIngreso]+$Fila2[ValorCosto];							   
						       //MARGEN
								echo "<td align='right'>".number_format($ValorAcumulado1,0,',','.')."</td>";
								echo "<td align='right'>".number_format($ValorAcumulado2,0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($ValorAcumuladoMargen,0,',','.')."&nbsp;</td>";	
								$TotalCobre1=$TotalCobre1+$ValorAcumulado1;
								$TotalCobre2=$TotalCobre2+$ValorAcumulado2;
								$TotalCobre3=$TotalCobre3+$ValorAcumuladoMargen;
							}	
					?>
					</tr>
				 <?
				 }  
				 ?>
					<tr class="TituloTablaVerde"><td>Total Cobre</td>
					<?
					reset($ArrayTot);
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					?>						
						<td align='right'><? echo number_format($ArrayTot[$i][1],0,',','.');?></td>
						<td align='right'><? echo number_format($ArrayTot[$i][2],0,',','.');?>.&nbsp;</td>
						<td align='right'><? echo number_format($ArrayTot[$i][3],0,',','.');?>.&nbsp;</td>
					<?
					}	
					   //MARGEN
					 ?>  
						<td align='right'><? echo number_format($TotalCobre1,0,',','.');?></td>
						<td align='right'><? echo number_format($TotalCobre2,0,',','.');?>&nbsp;</td>
						<td align='right'><? echo number_format($TotalCobre3,0,',','.');?>&nbsp;</td>	
					 <?	
						$ArrayTotalCobre1[$i][0]=$ArrayTotalCobre1[$i][0]+$TotalCobre1;
						$ArrayTotalCobre2[$i][0]=$ArrayTotalCobre2[$i][0]+$TotalCobre2;
						$ArrayTotalCobre3[$i][0]=$ArrayTotalCobre3[$i][0]+$TotalCobre3;	
					?>
					</tr>
					<? //ELEMENTOS AGREGADOS DESPUES ANTES DE SERVICIOS DE MAQUILA
					$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
					$Consulta.=" where cod_clase='31019' and valor_subclase1='C' and cod_subclase in ('23','24','25')";
					$Consulta.= " group by cod_grupo";	
					//echo $Consulta; 	
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
							$NomGrupo=$Fila[nom_grupo];
							$CodGrupo=$Fila["cod_grupo"];
							?>
							<tr class="FilaAbeja">
							<td rowspan="1" align="left"><? echo $NomGrupo;?></td>
							<?
							for($i=$Mes;$i<=$MesFin;$i++)
							{						
								$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
								$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
								$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes='".$i."' ";
								$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes='".$i."' ";
								$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
								$Consulta.=" group by t2.cod_grupo ";
								//if($CodGrupo=='19'&&$i==1)
								//echo $Consulta."<br>";
								$Valor=0;$Valor1=0;$Valor2=0;
								$Resp2=mysqli_query($link, $Consulta); 
								if($Fila2=mysql_fetch_array($Resp2))
								{
									$Valor=$Fila2[ValorIngreso];
									$Valor1=$Fila2[ValorCosto];
									$Valor2=$Fila2[ValorIngreso]+$Fila2[ValorCosto];
									$ArrayTot[$i][1]=$ArrayTot[$i][1]+$Valor;
									$ArrayTot[$i][2]=$ArrayTot[$i][2]+$Valor1;
									$ArrayTot[$i][3]=$ArrayTot[$i][3]+$Valor2;
									$ValorMaquilas[$i][1]=$ValorMaquilas[$i][1]+$Valor;
									$ValorMaquilas[$i][2]=$ValorMaquilas[$i][2]+$Valor1;
									$ValorMaquilas[$i][3]=$ValorMaquilas[$i][3]+$Valor2;
									echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
									echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
									echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";	
								}
								else
								{	$Valor=0;
									echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
									echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
									echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";		
								}		
							}		
								$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
								$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
								$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes between '1' and '".$MesFin."'";
								$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes between '1' and '".$MesFin."' ";
								$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
								$Consulta.=" group by t2.cod_grupo ";
								//if($CodGrupo=='19'&&$i==1)
								//echo $Consulta."<br>";
								$ValorAcumulado1=0;$ValorAcumulado2=0;$ValorAcumuladoMargen=0;
								$Resp2=mysqli_query($link, $Consulta); 
								if($Fila2=mysql_fetch_array($Resp2))
								{
								   $ValorAcumulado1=$Fila2[ValorIngreso];
								   $ValorAcumulado2=$Fila2[ValorCosto];
								   $ValorAcumuladoMargen=$Fila2[ValorIngreso]+$Fila2[ValorCosto];
								   $ValorAcumulado[$i][1]=$ValorAcumulado[$i][1]+$ValorAcumulado1;							   
								   $ValorAcumulado[$i][2]=$ValorAcumulado[$i][2]+$ValorAcumulado2;						   
								   $ValorAcumulado[$i][3]=$ValorAcumulado[$i][3]+$ValorAcumuladoMargen;							   
								   //MARGEN
								   ?>
									<td align='right'><? echo number_format($ValorAcumulado1,0,',','.');?>&nbsp;</td>
									<td align='right'><? echo number_format($ValorAcumulado2,0,',','.');?>&nbsp;</td>
									<td align='right'><? echo number_format($ValorAcumuladoMargen,0,',','.');?>&nbsp;</td>	
								   <?
									$TotalCobre1=$TotalCobre1+$ValorAcumulado1;
									$TotalCobre2=$TotalCobre2+$ValorAcumulado2;
									$TotalCobre3=$TotalCobre3+$ValorAcumuladoMargen;								
								}
								else
								{
								   ?>
									<td align='right'><? echo number_format($ValorAcumulado1,0,',','.');?>&nbsp;</td>
									<td align='right'><? echo number_format($ValorAcumulado2,0,',','.');?>&nbsp;</td>
									<td align='right'><? echo number_format($ValorAcumuladoMargen,0,',','.');?>&nbsp;</td>	
								   <?

								}	
						?>
						</tr>
					 <?
					 }  
					 ?>
					<? /*servicio de maquila*/
					$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
					$Consulta.=" where cod_clase='31019' and valor_subclase1='C' and cod_subclase in ('21')";
					$Consulta.= " group by cod_grupo";	
					//echo $Consulta; 	
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
							$NomGrupo=$Fila[nom_grupo];
							$CodGrupo=$Fila["cod_grupo"];
							?>
							<tr  class="TituloTablaVerde">
							<td rowspan="1" align="left"><? echo $NomGrupo;?></td>
							<?
							for($i=$Mes;$i<=$MesFin;$i++)
							{						
									$Valor=$Valor+$ValorMaquilas[$i][1];
									$Valor1=$Valor1+$ValorMaquilas[$i][2];
									$Valor2=$Valor2+$ValorMaquilas[$i][3];
									echo "<td align='right'>".number_format($Valor,0,',','.')."</td>";
									echo "<td align='right'>".number_format($Valor1,0,',','.')."&nbsp;</td>";
									echo "<td align='right'>".number_format($Valor2,0,',','.')."&nbsp;</td>";		

							}
								   $ValorAcumulado1=$ValorAcumulado[$i][1];
								   $ValorAcumulado2=$ValorAcumulado[$i][2];
								   $ValorAcumuladoMargen=$ValorAcumulado[$i][3];							   
								   //MARGEN
									echo "<td align='right'>".number_format($ValorAcumulado1,0,',','.')."</td>";
									echo "<td align='right'>".number_format($ValorAcumulado2,0,',','.')."&nbsp;</td>";
									echo "<td align='right'>".number_format($ValorAcumuladoMargen,0,',','.')."&nbsp;</td>";	
									$ArrayTotalCobre1[$i][0]=$ArrayTotalCobre1[$i][0]+$ValorAcumulado1;
									$ArrayTotalCobre2[$i][0]=$ArrayTotalCobre2[$i][0]+$ValorAcumulado2;
									$ArrayTotalCobre3[$i][0]=$ArrayTotalCobre3[$i][0]+$ValorAcumuladoMargen;	

								$TotalCobreAbajo1=$ArrayTotalCobre1[$i][0];
								$TotalCobreAbajo2=$ArrayTotalCobre2[$i][0];
								$TotalCobreAbajo3=$ArrayTotalCobre3[$i][0];
								//echo 	"arriba   ".$TotalCobre1."<br>";
						?>
						</tr>
					 <?
					 }  
					 ?>
					<tr><td class="Formulario2" colspan="37">3. SubProductos</td></tr>
   				    <?
					        $ArrayTot2=array();$ArrayTot3=array();
							$Consulta ="select nombre_subclase  as nom_grupo,cod_subclase as cod_grupo from proyecto_modernizacion.sub_clase";
							$Consulta.=" where cod_clase='31019' and valor_subclase1='S'";
							$Consulta.= " group by cod_grupo";	
							//echo $Consulta; 	
							$Resp=mysqli_query($link, $Consulta);
							while($Fila=mysql_fetch_array($Resp))
							{
								$NomGrupo=$Fila[nom_grupo];
								$CodGrupo=$Fila["cod_grupo"];
								?>
								<tr class="FilaAbeja">
								 <td rowspan="1" align="left"><? echo $NomGrupo;?></td>
								<?	
								for($i=$Mes;$i<=$MesFin;$i++)
								{
									$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
									$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
									$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes='".$i."' ";
									$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes='".$i."' ";
									$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
									$Consulta.=" group by t2.cod_grupo ";
									//if($i==1&&$CodGrupo=='7')
									//	echo $Consulta;
								    $ValorS=0;$ValorS1=0;$ValorS2=0;						
									$Resp2=mysqli_query($link, $Consulta);
									if($Fila2=mysql_fetch_array($Resp2))
									{
										$ValorS=$Fila2[ValorIngreso];
										$ValorS1=$Fila2[ValorCosto];
										$ValorS2=$Fila2[ValorIngreso]+$Fila2[ValorCosto];
										$ArrayTot2[$i][1]=$ArrayTot2[$i][1]+$ValorS;
										$ArrayTot2[$i][2]=$ArrayTot2[$i][2]+$ValorS1;
										$ArrayTot2[$i][3]=$ArrayTot2[$i][3]+$ValorS2;
										echo "<td align='right'>".number_format($ValorS,0,',','.')."</td>";
										echo "<td align='right'>".number_format($ValorS1,0,',','.')."&nbsp;</td>";
										echo "<td align='right'>".number_format($ValorS2,0,',','.')."&nbsp;</td>";	
										$TotalSuno=$TotalSuno+$ValorS;
										$TotalSdos=$TotalSdos+$ValorS1;
										$TotalStres=$TotalStres+$ValorS2;
									}
									else
									{
								        $ValorS=0;$ValorS1=0;$ValorS2=0;						
										echo "<td align='right'>".number_format($ValorS,0,',','.')."</td>";
										echo "<td align='right'>".number_format($ValorS1,0,',','.')."&nbsp;</td>";
										echo "<td align='right'>".number_format($ValorS2,0,',','.')."&nbsp;</td>";	
									}	
								}
									$Consulta =" select sum(t3.valor) as ValorIngreso,sum(t4.valor) as ValorCosto from pcip_ere_productos t1";
									$Consulta.=" inner join pcip_ere_productos_por_grupo t2 on t1.cod_producto=t2.cod_producto ";
									$Consulta.=" left join pcip_ere_estado_resultado t3 on  t1.cuenta_ingreso=t3.cod_cuenta and t3.ano='".$Ano."' and t3.mes between '1' and '".$MesFin."'";
									$Consulta.=" left join pcip_ere_estado_resultado t4 on  t1.cuenta_costos=t4.cod_cuenta and t4.ano='".$Ano."' and t4.mes between '1' and '".$MesFin."' ";
									$Consulta.=" where t2.cod_grupo='".$CodGrupo."' ";
									$Consulta.=" group by t2.cod_grupo ";
									//if($CodGrupo=='19'&&$i==1)
									//echo $Consulta."<br>";
									$ValorAcumulado1=0;$ValorAcumulado2=0;$ValorAcumuladoMargen=0;
									$Resp2=mysqli_query($link, $Consulta); 
									if($Fila2=mysql_fetch_array($Resp2))
									{
									   $ValorAcumulado1=$Fila2[ValorIngreso];
									   $ValorAcumulado2=$Fila2[ValorCosto];
									   $ValorAcumuladoMargen=$Fila2[ValorIngreso]+$Fila2[ValorCosto];							   
									   //MARGEN
										echo "<td align='right'>".number_format($ValorAcumulado1,0,',','.')."</td>";
										echo "<td align='right'>".number_format($ValorAcumulado2,0,',','.')."&nbsp;</td>";
										echo "<td align='right'>".number_format($ValorAcumuladoMargen,0,',','.')."&nbsp;</td>";	
										$TotalSubPro1=$TotalSubPro1+$ValorAcumulado1;
										$TotalSubPro2=$TotalSubPro2+$ValorAcumulado2;
										$TotalSubPro3=$TotalSubPro3+$ValorAcumuladoMargen;
									}	
								?>
								</tr>
								<?
							}
						
						?>
						<tr  class="TituloTablaVerde"><td>Total Subproductos</td>						
						<?
						reset($ArrayTot2);
						for($i=$Mes;$i<=$MesFin;$i++)
						{						
								echo "<td align='right'>".number_format($ArrayTot2[$i][1],0,',','.')."</td>";
								echo "<td align='right'>".number_format($ArrayTot2[$i][2],0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($ArrayTot2[$i][3],0,',','.')."&nbsp;</td>";		
						}
								//MARGEN
								echo "<td align='right'>".number_format($TotalSubPro1,0,',','.')."</td>";
								echo "<td align='right'>".number_format($TotalSubPro2,0,',','.')."&nbsp;</td>";
								echo "<td align='right'>".number_format($TotalSubPro3,0,',','.')."&nbsp;</td>";	
						?>
						</tr>
						<tr  class="Formulario2"><td>Total Margen Explotaci&oacute;n</td>												
			 <?	
						for($i=$Mes;$i<=$MesFin;$i++)
						{				
						   	$ArrayTot3[$i][1]=$ArrayTot2[$i][1]+$ArrayTot[$i][1];
							$ArrayTot3[$i][2]=$ArrayTot2[$i][2]+$ArrayTot[$i][2];
							$ArrayTot3[$i][3]=$ArrayTot2[$i][3]+$ArrayTot[$i][3];
							echo "<td align='right'>".number_format($ArrayTot3[$i][1],0,',','.')."</td>";
							echo "<td align='right'>".number_format($ArrayTot3[$i][2],0,',','.')."&nbsp;</td>";
							echo "<td align='right'>".number_format($ArrayTot3[$i][3],0,',','.')."&nbsp;</td>";	
							$TotalMar1=$TotalCobreAbajo1+$TotalSubPro1;
							$TotalMar2=$TotalCobreAbajo2+$TotalSubPro2;
							$TotalMar3=$TotalCobreAbajo3+$TotalSubPro3;
						}	
							//MARGEN
							echo "<td align='right'>".number_format($TotalMar1,0,',','.')."</td>";
							echo "<td align='right'>".number_format($TotalMar2,0,',','.')."&nbsp;</td>";
							echo "<td align='right'>".number_format($TotalMar3,0,',','.')."&nbsp;</td>";	
			 }
			 ?>	
			</tr>
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
<?
if($Buscar=='S')
{			    
	$Cuenta1='';$Cuenta2='';
	$Consulta ="select distinct cod_cuenta from pcip_ere_estado_resultado where ano='".$Ano."' and mes between '".$Mes."' and '".$MesFin."'";
	//echo $Consulta; 	
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$Cuenta=$Fila[cod_cuenta];
		$Consulta1 ="select * from pcip_ere_productos where cuenta_ingreso='".$Cuenta."' or cuenta_costos='".$Cuenta."'";
		//echo $Consulta1."<br>"; 	
		$Resp1=mysql_query($Consulta1);
		if(!$Fila1=mysql_fetch_array($Resp1))
		{
			 $Cuenta1=$Cuenta1.$Cuenta."~";
			 //echo $Cuenta1."<br>";
			 
		}
		$Consulta1 ="select * from pcip_ere_productos where cuenta_ingreso='".$Cuenta."' or cuenta_costos='".$Cuenta."'";
		//echo $Consulta; 	
		$Resp1=mysql_query($Consulta1);
		if($Fila1=mysql_fetch_array($Resp1))
		{
			$Consulta1 ="select * from pcip_ere_productos_por_grupo t1 inner join pcip_ere_productos t2 on t1.cod_producto=t2.cod_producto where t2.cuenta_ingreso='".$Cuenta."' or cuenta_costos='".$Cuenta."'";
			//echo $Consulta1; 	
			$Resp1=mysql_query($Consulta1);
			if(!$Fila1=mysql_fetch_array($Resp1))
			{
				$Cuenta2=$Cuenta2.$Cuenta."~";
				//echo $Cuenta2."<br>";
			}
		} 
	}
	if($Cuenta1!='')
		$Cuenta1=substr($Cuenta1,0,strlen($Cuenta1)-1);
	if($Cuenta2!='')
		$Cuenta2=substr($Cuenta2,0,strlen($Cuenta2)-1);

}	
?>
<?
if($Cuenta1!='' || $Cuenta2!='')
{
?>
<div id='IDI'  style='FILTER: alpha(opacity=100); overflow:scroll; VISIBILITY: visible; WIDTH:  327px; height:200px; POSITION: absolute; moz-opacity: .75; opacity: .100;  left: 509px; top: 233px; background-color:#FFFF99'>
<table width='100%' border='1' align='center' cellpadding='2' cellspacing='0'>
<tr><td width='20%' align='left'><a href="JavaScript:oculta('IDI')"><img src="archivos/cerrar2.png" width="25" height="25" border="0" alt="Cerrar" align="right"></a></td></tr>
<td width='20%' class='TituloTablaVerde' align='center'>Cuentas Cargadas Sin Productos Mantenedor</td>
<?
	$Datos1=explode('~',$Cuenta1);
	while(list($c,$v)=each($Datos1))
	{
	?>
	  <tr>
	   <td width='7%' align='center' colspan='3'><? echo "<span class='Estile9'>".$v."</span>"?></td>
 	  </tr>
	<?
	}
?>
<td width='20%' class='TituloTablaVerde' align='center'>Cuentas Cargadas Sin Agrupar</td>
<?
	$Datos2=explode('~',$Cuenta2);
	while(list($c,$v)=each($Datos2))
	{
	?>
	  <tr> 
	   <td width='7%' align='center' colspan='3'><? echo "<span class='Estile9'>".$v."</span>"?></td>
	  </tr>
 	<?
 	}
 ?>
</table>
<?
}
?>
</div>
</form>
</body>
</html>