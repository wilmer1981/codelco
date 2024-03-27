<?
	include("../principal/conectar_pcip_web.php");
	include("funciones/pcip_funciones.php");

if(!isset($Ano))
 	$Ano=date('Y');
if(!isset($Mes))
 	$Mes=date('m');
if(!isset($AnoFin))
 	$AnoFin=date('Y');
if(!isset($MesFin))
 	$MesFin=date('m');
if(!isset($CmbMostrar))
	$CmbMostrar='P';			
?>
<html>
<head>
<title>Consulta Cuadro Diario Kg - US$</title>
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
		case "C"://BUSCA DISPONIBILIDAD EQUIPOS
			if(f.CmbConAjuste.value=='-1')
			{
			  alert("Debe Seleccionar Ajuste");
			  f.CmbConAjuste.focus();
			  return;
			} 		
			var mesdesde=parseInt(f.Mes.value);
			var meshasta=parseInt(f.MesFin.value);
			if(mesdesde>meshasta)		
			{
				alert("Mes Desde No Puede Ser Mayor a Mes Hasta");
				return;	
			}
			f.action = "pcip_rpt_cuadro_diario_ventas_kg_dolares.php?Buscar=S";
			f.submit();
		break;
		case "E":
			URL='pcip_rpt_cuadro_diario_ventas_kg_dolares_excel.php?CmbProd='+f.CmbProd.value+'&CmbMostrar='+f.CmbMostrar.value+"&Ano="+f.Ano.value+"&Mes="+f.Mes.value+"&MesFin="+f.MesFin.value;
			window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
		break;
		case "R":
			f.action = "pcip_rpt_cuadro_diario_ventas_kg_dolares.php";
			f.submit();
			break;	
		case "I"://IMPRIMIR
			window.print();
			break;			
		case "S":
			window.location="../principal/sistemas_usuario.php?CodSistema=31&Nivel=1&CodPantalla=12";
		break;
	
	}
	
}

</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 11px}
-->
</style>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="archivos/popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<body>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
 <? include("encabezado.php")?>

 <table width="970" height="330" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5"  >
 <tr> 
 <td width="958" valign="top">
 <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
              <td width="271"><img src="archivos\Titulos\rpt_cuadro_diario_kg_us.png"></td>
              <td width="179" align="right"><font color="#9E5B3B">&nbsp;<font face="Times New Roman, Times, serif" size="2">Servidor 
                <? 
				$IP_SERV = $HTTP_HOST;
				echo $IP_SERV;?>
              </font></font></td>
              <td width="304" align="right"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
                </font><font color="#9E5B3B" face="Times New Roman, Times, serif">&nbsp; 
                <? 
				//$Fecha_Hora = date("d-m-Y h:i");
				$FechaFor=FechaHoraActual();
				echo $FechaFor." hrs";
				?>
                </font></td>
            </tr>
        </table></td>
    </tr>
  </table>
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
    <td width="16%" height="17" class='formulario2'>Productos </td>
    <td class="formulario2" colspan="3"><select name="CmbProd" onChange="Procesos('R')" >
      <option value="T" selected="selected">Todos</option>
        <?
		$Consulta ="select distinct(t1.cod_producto),t1.nom_producto from ";
		$Consulta.=" pcip_cdv_productos_ventas t1 inner join pcip_cdv_cuadro_diario_ventas t2 on t1.cod_producto=t2.cod_producto ";
		$Resp=mysqli_query($link, $Consulta);
		while ($Fila=mysql_fetch_array($Resp))
		{
			if ($CmbProd==$Fila["cod_producto"])
				echo "<option selected value='".$Fila["cod_producto"]."'>".ucfirst(strtolower($Fila["nom_producto"]))."</option>\n";
			else
				echo "<option value='".$Fila["cod_producto"]."'>".ucfirst(strtolower($Fila["nom_producto"]))."</option>\n";
		}
		?>
    </select></td>
  </tr>
  <tr>
    <td width="16%" height="17" class='formulario2'>Mostrar Por </td>
    <td width="28%" class="formulario2" >
	<select name="CmbMostrar">
      <option value="T" selected="selected">Todos</option>
	  <?
	  	switch($CmbMostrar)
		{
			case "1":
				echo "<option value='1' selected>Kg</option>";
				echo "<option value='2'>US$</option>";
			break;
			case "2":
				echo "<option value='1'>Kg</option>";
				echo "<option value='2' selected>US$</option>";
			break;
			default:
				echo "<option value='1'>Kg</option>";
				echo "<option value='2'>US$</option>";
			break;
		}
	  ?>	
    </select>	
	</td>
	   <td width="8%" class="formulario2">Ajuste</td>
	   <td width="48%" class="formulariosimple">
		   <select name="CmbConAjuste" >
		   <option value="-1" class="NoSelec">Seleccionar</option>
		   <?
			$Consulta = "select nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='31007' ";			
			$Resp=mysqli_query($link, $Consulta);
			while ($FilaTC=mysql_fetch_array($Resp))
			{
				if ($CmbConAjuste==$FilaTC["nombre_subclase"])
					echo "<option selected value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
				else
					echo "<option value='".$FilaTC["nombre_subclase"]."'>".ucfirst($FilaTC["nombre_subclase"])."</option>\n";
			}
		   ?>
	   </select>
	  </td>
  </tr>	  
  <tr>
    <td height="25" class='formulario2'>A&ntilde;o</td>
    <td class='formulario2' colspan="3"><select name="Ano" id="Ano">
      <?
	for ($i=2003;$i<=date("Y");$i++)
	{
		if ($i==$Ano)
			echo "<option selected value=\"".$i."\">".$i."</option>\n";
		else
			echo "<option value=\"".$i."\">".$i."</option>\n";
	}
?>
    </select>  </tr>
  <tr>
    <td height="25" class='formulario2'>Periodo</td>
    <td class='formulario2' colspan="3">
Desde
  
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
</select></tr>
 </table>  </td>
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
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0" >
          <tr class="TituloTablaVerde">
            <td width="5%" align="center" rowspan="2"><span class="Estilo9">Codigo</span></td>
            <td width="3%"align="center" rowspan="2"><span class="Estilo9">Nombre Producto</span></td>
			<?
			for($i=$Mes;$i<=$MesFin;$i++)
			{
			    if($CmbMostrar=='T')
				     $Colspan='2';
				else
				   	 $Colspan='1';
		       	echo"<td width='2%' align='center' colspan=".$Colspan."><span class='Estilo9'>".substr($Meses[$i-1],0,3)."</span></td>";
			}
				if($CmbMostrar=='T')
				{
				//echo "enreo a T  ";
			        echo"<tr class='TituloTablaVerde'>";
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					echo"<td align='center' class='Estilo9'><span class='Estilo9'>Valor Kg</span></td>";
					echo"<td align='center' class='Estilo9'><span class='Estilo9'>Valor US$</span></td>";
					}
					echo"</tr>";
				}
				if($CmbMostrar=='1')
				{
				//echo "entro a 1";
				    echo"<tr class='TituloTablaVerde'>";
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					echo"<td align='center'><span class='Estilo9'>Valor Kg</span></td>";
					}
					echo"</tr>";
				}
				if($CmbMostrar=='2')
				{
				// echo "entro a 2";
			 		echo"<tr class='TituloTablaVerde'>";
					for($i=$Mes;$i<=$MesFin;$i++)
					{
					echo"<td align='center'><span class='Estilo9'>Valor US$</span></td>";
					}
					echo"</tr>";
				}
			?>
          </tr>
		  <?
		  	if($Buscar=='S')
			{
				$Consulta = "select nombre_subclase as ajuste from proyecto_modernizacion.sub_clase where cod_clase='31007' ";
				if($CmbConAjuste=='S')
					$Consulta.= " and nombre_subclase in('N','S')";			
				else
					$Consulta.= " and nombre_subclase in('N')";	
				$Consulta.= "order by ajuste";			
				$RespTC=mysqli_query($link, $Consulta);
				while ($FilaTC=mysql_fetch_array($RespTC))
				{
					$Totales=array();
					$Consulta = "select distinct t1.cod_producto,t2.nom_producto";
					$Consulta.= " from pcip_cdv_cuadro_diario_ventas t1";
					$Consulta.= " inner join pcip_cdv_productos_ventas t2 on t1.cod_producto=t2.cod_producto";
					$Consulta.= " where t1.cod_producto<>'' ";
					if($CmbProd!='T')
						$Consulta.= "and  t1.cod_producto='".$CmbProd."'";
					$Consulta.=" and t1.ano='".$Ano."' and t1.mes between '".$Mes."' and '".$MesFin."'";						
					$Consulta.= " order by t1.cod_producto ";
					//echo $Consulta."<br>";			
					$Resp=mysqli_query($link, $Consulta);
					while($Fila=mysql_fetch_array($Resp))
					{
						$Total=0;
						echo "<tr>";
						echo "<td align='center'><span class='Estilo9'>".$Fila["cod_producto"]."</span></td>";
						echo "<td align='left'><span class='Estilo9'>".$Fila["nom_producto"]."&nbsp;</span></td>";
						for($i=$Mes;$i<=$MesFin;$i++)
						{
							$Consulta1 = "select t1.cod_producto,t2.nom_producto";
							if($CmbMostrar=='T')
								$Consulta1.= " ,sum(t1.kilos_finos) as kilos_finos,sum(t1.valor_cif_neto) as valor_cif_neto";
							if($CmbMostrar=='1')
								$Consulta1.= " ,sum(t1.kilos_finos) as kilos_finos";
							if($CmbMostrar=='2')
								$Consulta1.= " ,sum(t1.valor_cif_neto) as valor_cif_neto";    	
							$Consulta1.= " from pcip_cdv_cuadro_diario_ventas t1";
							$Consulta1.= " inner join pcip_cdv_productos_ventas t2 on t1.cod_producto=t2.cod_producto";
							$Consulta1.= " where t1.cod_producto<>'' ";
							$Consulta1.= "and  t1.cod_producto='".$Fila["cod_producto"]."'";
							$Consulta1.=" and t1.ano='".$Ano."' and t1.mes='".$i."' and ajuste='".$FilaTC[ajuste]."'";	
							$Consulta1.=" group by t1.cod_producto";		
							echo $Consulta1."<br>";	
							$Resp1=mysql_query($Consulta1);
							if($Fila1=mysql_fetch_array($Resp1))
							{						
								if($CmbMostrar=='T')
								{
									echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[kilos_finos],0,',','.')."</span></td>";
									echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[valor_cif_neto],0,',','.')."</span></td>";
								}
								if($CmbMostrar=='1')
								{
									echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[kilos_finos],0,',','.')."</span></td>";
								}
								if($CmbMostrar=='2')
								{
									echo "<td align='right'><span class='Estilo9'>".number_format($Fila1[valor_cif_neto],0,',','.')."</span></td>";
								}
								$Encontro=='S';
							}
							else
							{
								if($CmbMostrar=='T')
								{
									echo "<td align='right'>0</td>";
									echo "<td align='right'>0</td>";
								}
								else
									echo "<td align='right'>0</td>";
							}
						}			
						echo "</tr>";
					}
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