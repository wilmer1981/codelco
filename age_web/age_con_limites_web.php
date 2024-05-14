<?php
	include("../principal/conectar_principal.php");
	include("age_funciones.php");
	
	$TxtFiltroPrv  = isset($_REQUEST["TxtFiltroPrv"])?$_REQUEST["TxtFiltroPrv"]:"";
	$SubProducto   = isset($_REQUEST["SubProducto"])?$_REQUEST["SubProducto"]:"S";
	$Proveedor     = isset($_REQUEST["Proveedor"])?$_REQUEST["Proveedor"]:"S";
	$CmbMes        = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:"";
	$CmbAno        = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:"";
	$Plantilla     = isset($_REQUEST["Plantilla"])?$_REQUEST["Plantilla"]:"";

	//COLORES DE LIMITES
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15007'";
	$Resp=mysqli_query($link, $Consulta);
	while ($Fila=mysqli_fetch_array($Resp))
	{
		switch ($Fila["cod_subclase"])
		{
			case 1:
				$BajoMin=$Fila["valor_subclase1"];
				break;
			case 2:
				$SobreMax=$Fila["valor_subclase1"];
				break;
		}
	}
	//ARREGLO DE LIMITES
	$ArrLimites=array();
	if ($Plantilla!="S")
	{		
		$Consulta = "select * from age_web.limites where cod_plantilla='".$Plantilla."'";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			$ArrLimites[$Fila["cod_leyes"]]["min"]=$Fila["limite_minimo"];
			$ArrLimites[$Fila["cod_leyes"]]["med"]=$Fila["limite_medio"];
			$ArrLimites[$Fila["cod_leyes"]]["max"]=$Fila["limite_maximo"];
			$ArrLimites[$Fila["cod_leyes"]]["fecha"]=$Fila["anomes"];
			$ArrLimites[$Fila["cod_leyes"]]["usada"]="S";
		}
	}	
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
var OK;
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			//eval("Txt" + numero + ".style.left = 50 ");
		}
	}
}

function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}

function Proceso(opt)
{
	var f = document.frmPrincipal;
	switch (opt)
	{
		case "I": //VER LISTADO DE PLANTILLAS
			f.BtnImprimir.style.visibility = "hidden";
			f.BtnSalir.style.visibility = "hidden";
			window.print();
			f.BtnImprimir.style.visibility = "visible";
			f.BtnSalir.style.visibility = "visible";
			break
		case "S": //SALIR
			f.action = "age_con_limites.php";
			f.submit();
			break;		
	}	
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<table width="600"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" >
    <td colspan="2" class="Detalle01"><strong>Consulta de Limites </strong></td>
  </tr>
  <tr>
    <td>SubProducto:</td>
    <td width="491">
        <?php
			if ($SubProducto=="S")
			{
				echo "TODOS";				
			}
			else
			{						
				$Consulta = "select cod_subproducto, descripcion, ";
				$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
				$Consulta.= " from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto='1' ";
				$Consulta.= " and cod_subproducto='".$SubProducto."' ";
				$Consulta.= " order by orden ";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					echo str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"]);
				}
			}
			  ?>
    </td>
  </tr>
  <tr>
    <td>Proveedor:</td>
    <td>
        <?php
			if ($Proveedor=="S")
			{
				echo "TODOS";				
			}
			else
			{		
				$Consulta = "select * from rec_web.proved t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rutprv_a=t2.rut_proveedor ";
				$Consulta.= " where t2.cod_producto='1' and t2.cod_subproducto='".$SubProducto."'";
				$Consulta.= " and t1.rutprv_a='".$Proveedor."'";
				$Consulta.= " order by t1.nomprv_a";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					echo str_pad($Fila["RUTPRV_A"],10,"0",STR_PAD_LEFT)." - ".$Fila["NOMPRV_A"];
				}
			}
			?>
    </td>
  </tr>
  <tr>
    <td>Plantilla: </td>
    <td>
        <?php
		        $FechaAux = $CmbAno.str_pad($CmbMes,2,'0',STR_PAD_LEFT);
			  	//BUSCO PLANTILLA PARA SUBPRODUCTO PROVEEDOR
				$Consulta = "select DISTINCT cod_plantilla, descripcion ";
				$Consulta.= " from age_web.limites ";
				$Consulta.= " where cod_plantilla='".$Plantilla."'";
				$Consulta.= " and anomes <= '".$FechaAux."'";
				$Consulta.= " order by descripcion ";
				$Resp = mysqli_query($link, $Consulta);
				$Encontro=false;
				if ($Fila = mysqli_fetch_array($Resp))
				{
					$Encontro=true;
					echo strtoupper($Fila["descripcion"]);
				}	
				if (!$Encontro)
					echo "SIN PLANTILLA";				
			  ?>
    </td>
  </tr>
  <tr>
    <td height="18">Periodo:</td>
    <td height="18"><?php echo strtoupper($Meses[$CmbMes-1])."/".$CmbAno; ?></td>
  </tr>
  <tr align="center">
    <td colspan="2"><table width="200" border="1" cellpadding="2" cellspacing="0" class="TablaInterior">
      <tr align="center">
        <td width="100" bgcolor="<?php echo $BajoMin; ?>">Bajo Min. </td>
        <td width="100" bgcolor="<?php echo $SobreMax; ?>">Sobre Max </td>
      </tr>
    </table></td>
  </tr>
  <tr align="center">
    <td height="35" colspan="2">
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="Proceso('I')">
    <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px " onClick="Proceso('S')">    </td>
  </tr>
</table>
<br>
<?php
	if ($CmbAno<2006)
	{
		$LoteIni = substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."000";
		$LoteFin = substr($CmbAno,3,1).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."999";
	}
	else
	{
		$LoteIni = substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."0000";
		$LoteFin = substr($CmbAno,2,2).str_pad($CmbMes,2,'0',STR_PAD_LEFT)."9999";
	}
	//$FechaAux = $CmbAno.str_pad($CmbMes,2,'0',STR_PAD_LEFT);
	$ArrLeyes = array();
	$ArrTotalLeyes = array();
	$ArrLote = array();
	$ArrLeyes["01"][0]="01";
	$ArrLeyes["01"][1]="H2O";
	$Consulta = "select distinct t1.cod_leyes, t2.abreviatura ";
	$Consulta.= " from age_web.lotes t0 inner join age_web.leyes_por_lote t1 on t0.lote=t1.lote ";
	$Consulta.= " inner join proyecto_modernizacion.leyes t2 ";
	$Consulta.= " on t1.cod_leyes=t2.cod_leyes ";
	$Consulta.= " where t0.cod_producto='1' ";
	$Consulta.= " and t0.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t0.rut_proveedor='".$Proveedor."'";
	$Consulta.= " and t0.lote between '".$LoteIni."' and '".$LoteFin."'  and t0.estado_lote <>'6' ";
	$Consulta.= " order by t1.cod_leyes ";
	//echo "uno".$Consulta;
	$Resp = mysqli_query($link, $Consulta);
	$CantLeyes=0;
	while ($Fila = mysqli_fetch_array($Resp))
	{
		$ArrLeyes[$Fila["cod_leyes"]][0] = $Fila["cod_leyes"];
		$ArrLeyes[$Fila["cod_leyes"]][1] = $Fila["abreviatura"];
		$CantLeyes++;
	}
	$LargoTabla=210+(50*$CantLeyes);
	
	echo "<table width='".$LargoTabla."' border='1' align='center' cellpadding='2' cellspacing='0' class='TablaDetalle'>\n";
	$Consulta = "select t1.lote, t2.descripcion as nom_subprod, t1.rut_proveedor, t3.nomprv_a as nom_proveedor ";
	$Consulta.= " from age_web.lotes t1 inner join proyecto_modernizacion.subproducto t2 on ";
	$Consulta.= " t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
	$Consulta.= " left join rec_web.proved t3 on t1.rut_proveedor=t3.rutprv_a ";
	$Consulta.= " where t1.cod_producto='1'  and t1.estado_lote <>'6' ";
	$Consulta.= " and t1.cod_subproducto='".$SubProducto."'";
	if ($Proveedor!="S")
		$Consulta.= " and t1.rut_proveedor='".$Proveedor."'";
	$Consulta.= " and t1.lote between '".$LoteIni."' and '".$LoteFin."'";
	$Consulta.= " order by lpad(t1.cod_subproducto,3,'0'), t1.rut_proveedor, t1.lote ";
	//echo "dos".$Consulta;
	$Resp=mysqli_query($link, $Consulta);
	$ProvAnt="";
	$TotalPesoHum=0;
	$TotalPesoSeco=0;
	$EntreMin=0;
	$EntreMax=0;
	while ($Fila=mysqli_fetch_array($Resp))
	{
		if ($ProvAnt!=$Fila["rut_proveedor"])
		{			
			if ($ProvAnt!="")
				TotalProv($TotalPesoHum, $TotalPesoSeco, $ArrTotalLeyes, $ArrLimites, $BajoMin, $EntreMin, $EntreMax, $SobreMax);
			Titulo($Fila["rut_proveedor"], $Fila["nom_proveedor"], $ArrLeyes, $ArrLimites);
		}
		$ArrLote["lote"]=$Fila["lote"];
		LeyesLote($ArrLote,$ArrLeyes,"N","S","S","","","",$link);
		echo "<tr align='right'>\n";
		echo "<td align=\"center\">".$ArrLote["lote"]."</td>\n";
		echo "<td>".number_format($ArrLote["peso_humedo"],0,",",".")."</td>\n";
		echo "<td>".number_format($ArrLote["peso_seco"],0,",",".")."</td>\n";
		reset($ArrLeyes);
		do {	
			$Fino=0;	
			$Ley=0;	 
			$key = key ($ArrLeyes);
			if ($ArrLote["peso_humedo"] > 0 && $ArrLeyes[$key][2]>0 && $ArrLeyes[$key][5]>0)
			{
				$Fino = ($ArrLote["peso_humedo"]*$ArrLeyes[$key][2])/$ArrLeyes[$key][5];
				$Ley = ($Fino/$ArrLote["peso_humedo"])*$ArrLeyes[$key][34];
			}			
			$Color="";
			AsignaColor("", $key, $Ley, $ArrLimites, $Color, $BajoMin, $EntreMin, $EntreMax, $SobreMax);
			echo "<td width='50' bgcolor='".$Color."'>".number_format($Ley,$ArrLeyes[$key][35],",",".")."</td>\n";
			$ArrLeyes[$key][2] = "";
			$ArrTotalLeyes[$key][2] = $ArrTotalLeyes[$key][2]+$Fino;
			$ArrTotalLeyes[$key][34] = $ArrLeyes[$key][34];
			$ArrTotalLeyes[$key][35] = $ArrLeyes[$key][35];
		} while (next($ArrLeyes));	
		echo "</tr>\n";
		$ProvAnt=$Fila["rut_proveedor"];
		$TotalPesoHum = $TotalPesoHum + $ArrLote["peso_humedo"];
		$TotalPesoSeco = $TotalPesoSeco + $ArrLote["peso_seco"];
	}
	TotalProv($TotalPesoHum, $TotalPesoSeco, $ArrTotalLeyes, $ArrLimites, $BajoMin, $EntreMin, $EntreMax, $SobreMax);

function AsignaColor($Tipo, $CodLey, $Valor, $Limites, $BgColor, $BajoMin, $EntreMin, $EntreMax, $SobreMax)
{
	$Lim_CodLey_usa = isset($Limites[$CodLey]["usada"])?$Limites[$CodLey]["usada"]:0;
	if ($Lim_CodLey_usa == "S")
	{
		switch ($Tipo)
		{
			case "": //LAS DEL MES				
				if ($Valor<$Limites[$CodLey]["min"])
				{
					$BgColor=$BajoMin;
				}				
				else
				{
					if ($Valor>$Limites[$CodLey]["max"] && $Limites[$CodLey]["max"]!=0)
					{
						$BgColor=$SobreMax;
					}
				}				
				break;
			case "PROM": //EL PROMEDIO DEL MES
				if ($Limites[$CodLey]["med"]!=0)
				{
					if ($Valor<$Limites[$CodLey]["med"])
					{
						$BgColor=$BajoMin;
					}				
					else
					{
						if ($Valor>$Limites[$CodLey]["med"])
						{
							$BgColor=$SobreMax;
						}
					}	
				}
				break;
		}	
	}//FIN USADA
}
	
function TotalProv($PesoHum, $PesoSeco, $ArrTotal, $ArrLimites, $BajoMin, $EntreMin, $EntreMax, $SobreMax)
{	
	//TOTALES
	echo "<tr align='right' class='Detalle01'>\n";
	echo "<td>TOTAL</td>\n";
	echo "<td>".number_format($PesoHum,0,",",".")."</td>\n";
	echo "<td>".number_format($PesoSeco,0,",",".")."</td>\n";	
	reset($ArrTotal);
	do {			 
		$key = key ($ArrTotal);
		$Ley=0;
		if ($PesoHum>0 && $ArrTotal[$key][2]>0 && $ArrTotal[$key][34]>0)
			$Ley=($ArrTotal[$key][2]/$PesoHum)*$ArrTotal[$key][34];
		$Color="";
		AsignaColor("PROM", $key, $Ley, $ArrLimites, $Color, $BajoMin, $EntreMin, $EntreMax, $SobreMax);
		$ArrTotal35 = isset($ArrTotal[$key][35])?$ArrTotal[$key][35]:0;
		echo "<td width='50' bgcolor='".$Color."'>".number_format($Ley,$ArrTotal35,",",".")."</td>\n";
		$ArrTotal[$key][2] = "";
	} while (next($ArrTotal));	
	echo "</tr>\n";
	$PesoHum=0;
	$PesoSeco=0;
}

function Titulo($RutProv, $Prov, $Leyes, $Limites)
{
	echo "<tr align=\"center\" class=\"ColorTabla01\">\n";
	echo "<td colspan=\"".(count($Leyes)+3)."\">".str_pad($RutProv,10,'0',STR_PAD_LEFT)." - ".strtoupper($Prov)."</td>\n";
	echo "</tr>\n";
	echo "<tr align=\"center\" class=\"ColorTabla01\">\n";
	echo "<td width=\"60\">LOTE</td>\n";
	echo "<td width=\"75\">P.HUMEDO</td>\n";
	echo "<td width=\"75\">P.SECO</td>\n";
	reset($Leyes);
	foreach($Leyes as $k=>$v)
	{
		if ($Limites[$v[0]]["usada"]=="S")
		{
			echo "<td onMouseOver=\"JavaScript:muestra('".str_replace("-","",$RutProv).$v[1]."');\" onMouseOut=\"JavaScript:oculta('".str_replace("-","",$RutProv).$v[1]."');\">";
			echo "<div id='Txt".str_replace("-","",$RutProv).$v[1]."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:140px'>\n";
			echo "<table width='140' border='1' cellpadding='2' cellspacing='0' class='TablaInterior'>";
			echo "<tr class='ColorTabla01'><td colspan=\"3\" align='center'><strong>".$v[1]."</strong></td></tr>";
			echo "<tr align='center'><td width='70'>Min.</td><td width='70'>Max.</td></tr>";
			echo "<tr align='center' class='Detalle01'><td>".$Limites[$v[0]]["min"]."</td><td>".$Limites[$v[0]]["max"]."</td></tr>";
			echo "<tr align='center'><td colspan='2'>Prom.Mes</td></tr>";
			echo "<tr align='center' class='Detalle01'><td colspan='2'>".$Limites[$v[0]]["med"]."</td></tr>";
			echo "</table></div>";
		}
		else
		{
			echo "<td >";
		}
		echo $v[1]."</td>";
	}	
	echo "</tr>\n";
}
?>  
</form>
</table>
</body>
</html>
