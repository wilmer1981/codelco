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
<title>Reporte Ingresos Proyectados Precios Dor�</title>
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
			f.action = "pcip_rpt_ingresos_proyectados_dore.php?Buscar=S";
			f.submit();
		break;
		case "E"://GENERA EXCEL
			URL='pcip_rpt_ingresos_proyectados_dore_excel.php?&Ano='+f.Ano.value+'&Mes='+f.Mes.value+'&MesFin='+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;				
		case "R":
			f.action = "pcip_rpt_ingresos_proyectados_dore.php";
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
 EncabezadoPagina($IP_SERV,'mant_rpt_dore.png')
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
    <td width="94" height="25" class='formulario2'>Periodo</td>
    <td class='formulario2'>A&ntilde;o &nbsp;&nbsp;&nbsp;
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
		&nbsp;Hasta
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
            <td width="20%" class="TituloTablaVerde" align="center" rowspan="2">INGRESOS HORNO DOR&Eacute; (ESCORIAS PLATA Y ORO, VENTA A M&Eacute;XICO)</td>	
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
			$ArrTotalReal[$i][0]=0;
			$ArrTotalPpto[$i][0]=0;
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
				  $Consulta1="select cod_subclase,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31046'";
				  //echo $Consulta1."<br>";
				  $Resp1=mysql_query($Consulta1);
				  while($Fila1=mysql_fetch_array($Resp1))
				  {
				  ?>
					  <tr class="Formulario2">
						<td rowspan="1" colspan="25" align="left"><? echo $Fila1["nombre_subclase"];?></td>
					  </tr>	
				  <?	
					  $Consulta="select distinct t1.cod_subclase,t1.nombre_subclase from proyecto_modernizacion.sub_clase t1 inner join proyecto_modernizacion.sub_clase t2";
					  $Consulta.=" on t1.cod_clase='31020' and t2.cod_subclase=t1.valor_subclase1 where  t2.cod_subclase='".$Fila1["cod_subclase"]."' order by t1.cod_subclase";
					  $Resp=mysqli_query($link, $Consulta);
					  //echo $Consulta."<br>";
					  while($Fila=mysql_fetch_array($Resp))
					  {
						?>
						  <tr class="FilaAbeja">
							<td rowspan="1" align="left"><? echo $Fila["nombre_subclase"];?></td>
							<?
							for($i=$Mes;$i<=$MesFin;$i++)
							{
							    if($Fila["cod_subclase"]=='2')//SECO
								{
									$Real=DatosProyectadosTratam($Ano,$i,'4','22','NULL','R');
									$Ppto=DatosProyectadosTratam($Ano,$i,'4','22','NULL','P');
								}
							    if($Fila["cod_subclase"]=='3')//PLATA
								{
									$Real=DatosProyectadosTratam($Ano,$i,'4','22','PLATA','R');
									$Ppto=DatosProyectadosTratam($Ano,$i,'4','22','PLATA','P');
								}								
							    if($Fila["cod_subclase"]=='4')//ORO
								{
									$Real=DatosProyectadosTratam($Ano,$i,'4','22','ORO','R');
									$Ppto=DatosProyectadosTratam($Ano,$i,'4','22','ORO','P');
								}								
							    if($Fila["cod_subclase"]=='5')//PRECIO AG
								{
									$Real=DatosProyectadosDore('2',$Ano,$i,'R');
									$Ppto=DatosProyectadosDore('2',$Ano,$i,'P');
								}								
							    if($Fila["cod_subclase"]=='6')//PRECIO AU
								{
									$Real=DatosProyectadosDore('3',$Ano,$i,'R');
									$Ppto=DatosProyectadosDore('3',$Ano,$i,'P');
								}								
							    if($Fila["cod_subclase"]=='8')//PLATA - PAGABLE
								{
									$DatoPlataEscoriaReal=DatosProyectadosTratam($Ano,$i,'4','22','PLATA','R');
									$DatoDeduccionReal=DatosPreciosDore($Ano,'6','44');
									$ValorPlataPagableReal=($DatoPlataEscoriaReal*(100-$DatoDeduccionReal))/100;
									
									$DatoPlataEscoriaPpto=DatosProyectadosTratam($Ano,$i,'4','22','PLATA','P');						
									$DatoDeduccionPpto=DatosPreciosDore($Ano,'6','44');
									$ValorPlataPagablePpto=($DatoPlataEscoriaPpto*(100-$DatoDeduccionPpto))/100;
								
									$Real=$ValorPlataPagableReal;
									$Ppto=$ValorPlataPagablePpto;
								}								
							    if($Fila["cod_subclase"]=='9')//ORO - PAGABLE
								{
									$DatoOroEscoriaReal=DatosProyectadosTratam($Ano,$i,'4','22','ORO','R');
									$DatoDeduccionReal=DatosPreciosDore($Ano,'6','45');
									//echo $DatoDeduccionReal."<br>";
									$ValorOroPagableReal=($DatoOroEscoriaReal*(100-$DatoDeduccionReal))/100;
									
									$DatoOroEscoriaPpto=DatosProyectadosTratam($Ano,$i,'4','22','ORO','P');
									$DatoDeduccionPpto=DatosPreciosDore($Ano,$i,'6','45');
									$ValorOroPagablePpto=($DatoOroEscoriaPpto*(100-$DatoDeduccionPpto))/100;
								
									$Real=$ValorOroPagableReal;
									$Ppto=$ValorOroPagablePpto;
								}								
							    if($Fila["cod_subclase"]=='11')//PLATA - INGRESOS VENTAS
								{
									$DatoPrecioAgReal=DatosProyectadosDore('2',$Ano,$i,'R');//D23 precio AG R
									$DatoPrecioAgPpto=DatosProyectadosDore('2',$Ano,$i,'P');//D23 precio AG P
									$DatoDeduccion=DatosPreciosDore($Ano,'6','42');
									
									$DatoPlataEscoriaReal=DatosProyectadosTratam($Ano,$i,'4','22','PLATA','R');																		
									$ValorPlataPagableReal=($DatoPlataEscoriaReal*(100-$DatoDeduccionReal))/100;
									
									$DatoPlataEscoriaPpto=DatosProyectadosTratam($Ano,$i,'4','22','PLATA','P');						
									$ValorPlataPagablePpto=($DatoPlataEscoriaPpto*(100-$DatoDeduccionPpto))/100;						
																																																			
									//echo $ValorPlataIngresoReal."=".$ValorPlataPagableReal."*(".$DatoPrecioAgReal."-".$DatoDeduccion.")/31.1<br>";
									$ValorPlataIngresoReal=$ValorPlataPagableReal*($DatoPrecioAgReal-$DatoDeduccion)/31.1;
									//echo $ValorPlataIngresoReal."<br>";
									//echo $ValorPlataIngresoPpto."=".$ValorPlataPagablePpto."*(".$DatoPrecioAgPpto."-".$DatoDeduccion.")/31.1<br>";
									$ValorPlataIngresoPpto=$ValorPlataPagablePpto*($DatoPrecioAgPpto-$DatoDeduccion)/31.1;
									$Real=$ValorPlataIngresoReal;
									$Ppto=$ValorPlataIngresoPpto;

									$ArrTotalReal[$i][0]=$ArrTotalReal[$i][0]+$Real;
									$ArrTotalPpto[$i][0]=$ArrTotalPpto[$i][0]+$Ppto;
								}								
							    if($Fila["cod_subclase"]=='12')//ORO - INGRESOS VENTAS
								{
									$DatoPrecioAuReal=DatosProyectadosDore('3',$Ano,$i,'R');
									$DatoPrecioAuPpto=DatosProyectadosDore('3',$Ano,$i,'P');
								    $DatoDeduccion=DatosPreciosDore($Ano,'6','43');
									
									$DatoOroEscoriaReal=DatosProyectadosTratam($Ano,$i,'4','22','ORO','R');									
									$ValorOroPagableReal=($DatoOroEscoriaReal*(100-$DatoDeduccionReal))/100;
									
									$DatoOroEscoriaPpto=DatosProyectadosTratam($Ano,$i,'4','22','ORO','P');									
									$ValorOroPagablePpto=($DatoOroEscoriaPpto*(100-$DatoDeduccionPpto))/100;
									
									//echo $ValorOroIngresoReal."=".$ValorOroPagableReal."*(".$DatoPrecioAuReal."-".$DatoDeduccion.")/31.1<br>";								
									$ValorOroIngresoReal=$ValorOroPagableReal*($DatoPrecioAuReal-$DatoDeduccion)/31.1;
									$ValorOroIngresoPpto=$ValorOroPagablePpto*($DatoPrecioAuPpto-$DatoDeduccion)/31.1;
								
									$Real=$ValorOroIngresoReal;
									$Ppto=$ValorOroIngresoPpto;
									
									$ArrTotalReal[$i][0]=$ArrTotalReal[$i][0]+$Real;
									$ArrTotalPpto[$i][0]=$ArrTotalPpto[$i][0]+$Ppto;
								}								
							    if($Fila["cod_subclase"]=='13')//TC - INGRESOS VENTAS
								{
									$DatoDeduccion=DatosPreciosDore($Ano,'6','41');
									$DatoReal=DatosProyectadosTratam($Ano,$i,'4','22','NULL','R');
									$DatoPpto=DatosProyectadosTratam($Ano,$i,'4','22','NULL','P');
									
									$ValorTCReal=-$DatoDeduccion*$DatoReal/1000;
									$ValorTCPpto=-$DatoDeduccion*$DatoPpto/1000;
								
									$Real=$ValorTCReal;
									$Ppto=$ValorTCPpto;

									$ArrTotalReal[$i][0]=$ArrTotalReal[$i][0]+$Real;
									$ArrTotalPpto[$i][0]=$ArrTotalPpto[$i][0]+$Ppto;
								}								
								?>
									<td rowspan="1" align="right"><? echo number_format($Real,0,',','.');?></td>
									<td rowspan="1" align="right"><? echo number_format($Ppto,0,',','.');?></td>
								<?	
							}
					  }	
				  }
				  ?>
					<tr class="TituloTablaVerde">
					<td rowspan="1"  align="left">TOTAL</td>
					<?
					$Numero=0.7;$TotalReal=0;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$TotalReal=$ArrTotalReal[$i][0]*$Numero;
					$TotalPpto=$ArrTotalPpto[$i][0]*$Numero;
					?>
					<td rowspan="1" align="right"><? echo number_format($TotalReal,0,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><? echo number_format($TotalPpto,0,',','.');?>&nbsp;</td>
					<?
					}
					?>
				  </tr>	
				  <tr class="TituloTablaVerde">
					<td rowspan="1"  align="left">PRECIO FINAL [kUS$/kg] (Incluye 70%)</td>
					<?
					$Numero=0.7;
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					$DatoPrecioReal=DatosProyectadosTratam($Ano,$i,'4','22','NULL','R');
					$DatoPrecioPpto=DatosProyectadosTratam($Ano,$i,'4','22','NULL','P');
					
					$TotalReal=$ArrTotalReal[$i][0]*$Numero;
					$TotalPpto=$ArrTotalPpto[$i][0]*$Numero;
					
					if($DatoPrecioReal>0)
						$PrecioFinalReal=$TotalReal*1000/$DatoPrecioReal;
					else
						$DatoPrecioReal=0;	
					if($DatoPrecioPpto>0)	
						$PrecioFinalPpto=$TotalPpto*1000/$DatoPrecioPpto;
					else
						$DatoPrecioPpto=0;	
					?>
					<td rowspan="1" align="right"><? echo number_format($PrecioFinalReal,2,',','.');?>&nbsp;</td>
					<td rowspan="1" align="right"><? echo number_format($PrecioFinalPpto,2,',','.');?>&nbsp;</td>
					<?
					}
					?>
				  </tr>	
			   <?																	 
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
function DatosProyectadosTratam($Ano,$Mes,$Area,$Division,$Producto,$Tipo)
{
   $Datos1=0;$Datos2=0;
   $Consulta="select valor_real as ValorReal,valor_presupuestado as ValorPresupuestado from pcip_inp_tratam";
   $Consulta.=" where ano='".$Ano."' and mes='".$Mes."' and nom_area='".$Area."' and nom_division='".$Division."' and cod_producto='".$Producto."'";
   //echo $Consulta."<br>";
   $Resp=mysqli_query($link, $Consulta);  
   if($Fila=mysql_fetch_array($Resp))
   {
    $Datos1=$Fila[ValorReal];
    //echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
    $Datos2=$Fila[ValorPresupuestado];
    //echo "Valor datos consyulta 2   ".$Datos2."<br>";
   }
   if($Tipo=='R')	
	return($Datos1);
   if($Tipo=='P')	    
	return($Datos2);	
}

function DatosProyectadosDore($Producto,$Ano,$Mes,$Tipo)
{
    $Dato1=0;$Dato2=0;
	$Consulta1 =" select valor_real, valor_ppto from pcip_inp_precios_dore ";
	$Consulta1.=" where cod_producto='".$Producto."' and ano='".$Ano."' and mes='".$Mes."'";
	//echo $Consulta1."<br>";
	$RespAux=mysql_query($Consulta1);
	if($FilaAux=mysql_fetch_array($RespAux))
	{
		$Dato1=$FilaAux[valor_real];
		$Dato2=$FilaAux[valor_ppto];
	}
	if($Tipo=='R')   
		return($Dato1);	
	if($Tipo=='P')   
		return($Dato2);	
}
function DatosPreciosDore($Ano,$Prod,$Deduc)
{
	$Valor=0;
	$Consulta2 =" select valor from pcip_inp_precios ";
	$Consulta2.=" where cod_producto='".$Prod."' and ano='".$Ano."' and cod_deduccion='".$Deduc."'";
	//echo $Consulta2."<br>";
	$RespAux1=mysql_query($Consulta2);
	if($FilaAux1=mysql_fetch_array($RespAux1))
	{
		$Valor=$FilaAux1[valor];
		//echo $Valor;
	}
	return($Valor);
}?>
