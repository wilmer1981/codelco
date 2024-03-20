<? 	
	$CodigoDeSistema = 12;
	$CodigoDePantalla = 1;
	$fechac = date("Y-m-d");
	$Fecha2 = date("Y-m-d", mktime(0,0,0,intval(substr($fechac, 5, 2)) ,intval(substr($fechac, 8, 2)) - 3 ,intval(substr($fechac, 0, 4))));


	include("../principal/conectar_pac_web.php");
	$Eliminar = "DROP TABLE IF EXIST raf_web.tmp_table";
  	mysql_query($Eliminar);
	if($Proceso == "B")
	{
        $DiaTer = 31;
		$fecha_i = date("Y-m-d",mktime(7,59,59,($MesTer - 1),1,$AnoTer));
		$DiaIni = substr($fecha_i,8,2);
		$MesIni = substr($fecha_i,5,2);		
		$AnoIni = substr($fecha_i,0,4);		
					
	}

	if($Proceso == "B" AND $Circ_Unid == '' AND $Circ_Peso == '' AND $Blister_Unid == '' AND $Blister_Peso == '')
	{
		$TotalUnid = 0;
		$TotalPeso = 0;
	}
     	
	if($Proceso == "H")
	{
		//blister liquido
	  	/*if($BlisterPeso == '')
		{*/

			$Consulta = "SELECT * FROM raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = ".$Hornada."";
			else
				$Consulta.= " WHERE right(hornada,5) = ".$Hornada."";
			$Consulta.= " AND cod_producto = 16 ";
			$Consulta.=" and left(hornada,4) = '".$AnoTer."'";
			$Consulta.= " AND turno = '".$cmbturno."'";
			//echo "xx".$Consulta;		
			$rs = mysql_query($Consulta);
			while($Fila = mysql_fetch_array($rs))
			{
				if($Fila[cod_subproducto] == 40)
				{
					$BlistCps = $Fila["unidades"];
					$Peso_BlistCps = $Fila["peso"];
				}

				if($Fila[cod_subproducto] == 41)
				{
					$BlistBasc = $Fila["unidades"];
					$Peso_BlistBasc = $Fila["peso"];
				}
	
				if($Fila[cod_subproducto] == 42)
				{
					$BlistReten = $Fila["unidades"];
					$Peso_BlistReten = $Fila["peso"];
				}	
			}		

			$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = $Hornada";
			else
				$Consulta.= " WHERE right(hornada,5) = $Hornada";
			$Consulta.= " AND cod_producto = 16 AND cod_subproducto IN ('40','41','42')";
			$Consulta.=" and left(hornada,4) = '".$AnoTer."'";
			$Consulta.= " AND turno = '".$cmbturno."' ";
			//echo "xxx".$Consulta;
			$resp = mysql_query($Consulta);		
			$row = mysql_fetch_array($resp);
			$BlisterUnid = $row["unidades"];
			$BlisterPeso = $row["peso"];
	  	//}	
		
		//Circulantes RAF 	
			$Consulta = "SELECT * FROM raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = ".$Hornada."";
			else
				$Consulta.= " WHERE right(hornada,5) = ".$Hornada."";
			$Consulta.= " AND cod_producto IN(42)";
			$Consulta.= " AND cod_subproducto IN(16,31,39,43,69,70,73,74,75,76,77,78)";
			$Consulta.=" and left(hornada,4) = '".$AnoTer."'";
			$Consulta.= " AND turno = '".$cmbturno."' ";
//echo "xxxx".$Consulta."<br>";
			$rs = mysql_query($Consulta);
			while($Fila = mysql_fetch_array($rs))
			{
				if($Fila[cod_subproducto] == 43)
				{
					$Tallarines = $Fila["unidades"];
					$Peso_Tallarines = $Fila["peso"];
				}
	
				if($Fila[cod_subproducto] == 75)
				{
					$CuRecup = $Fila["unidades"];
					$Peso_CuRecup = $Fila["peso"];
				}
					
				if($Fila[cod_subproducto] == 39)
				{
					$Queques = $Fila["unidades"];
					$Peso_Queques = $Fila["peso"];
				}
				
				if($Fila[cod_subproducto] == 76)
				{
					$BoteAlb = $Fila["unidades"];
					$Peso_BoteAlb = $Fila["peso"];
				}
				
				if($Fila[cod_subproducto] == 73)
				{	
					$Moldes = $Fila["unidades"];
					$Peso_Moldes = $Fila["peso"];
				}
				
				if($Fila[cod_subproducto] == 70)
				{
					$BoteOxid = $Fila["unidades"];
					$Peso_BoteOxid = $Fila["peso"];
				}
				
				if($Fila[cod_subproducto] == 74)
				{
					$AnodCirc = $Fila["unidades"];
					$Peso_AnodCirc = $Fila["peso"];	
				}
				
				if($Fila[cod_subproducto] == 31)
				{
					$Maceteros = $Fila["unidades"];
					$Peso_Maceteros = $Fila["peso"];
				}
				
				if($Fila[cod_subproducto] == 69)
				{
					$Rebalses = $Fila["unidades"];
					$Peso_Rebalses = $Fila["peso"];
				}
				
				if($Fila[cod_subproducto] == 16)
				{
					$Chatarra = $Fila["unidades"];				
					$Peso_Chatarra = $Fila["peso"];				
				}
				
				if($Fila[cod_subproducto] == 77)
				{
					$Placas = $Fila["unidades"];				
					$Peso_Placas = $Fila["peso"];				
				}
				
				if($Fila[cod_subproducto] == 78)
				{
					$CuPiso = $Fila["unidades"];				
					$Peso_CuPiso = $Fila["peso"];				
				}

			}
			//Circulantes REF 	
			$Consulta = "SELECT * FROM raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = ".$Hornada."";
			else
				$Consulta.= " WHERE right(hornada,5) = ".$Hornada."";
			$Consulta.= " AND (cod_producto=29 and cod_subproducto=1 ";
			$Consulta.= " OR cod_producto=48 and cod_subproducto=10 ";
			$Consulta.= " OR cod_producto=49 and cod_subproducto=4)";
			$Consulta.=" and left(hornada,4) = '".$AnoTer."'";
			$Consulta.= " AND turno = '".$cmbturno."'";
//echo "xxxxx".$Consulta."<br>";
			$rs = mysql_query($Consulta);
			while($Fila = mysql_fetch_array($rs))
			{
				if($Fila["cod_producto"] == 49 && $Fila[cod_subproducto] == 4)
				{
					$BarroAnod = $Fila["unidades"];				
					$Peso_BarroAnod = $Fila["peso"];				
				}
				if($Fila["cod_producto"] == 48 && $Fila[cod_subproducto] == 10)
				{
					$BarridoCu = $Fila["unidades"];				
					$Peso_BarridoCu = $Fila["peso"];				
				}
				if($Fila["cod_producto"] == 29 && $Fila[cod_subproducto] == 1)
				{
					$GranaCu = $Fila["unidades"];				
					$Peso_GranaCu = $Fila["peso"];				
				}

			}
			//Circulantes PMN 	
			$Consulta = "SELECT * FROM raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = ".$Hornada."";
			else
				$Consulta.= " WHERE right(hornada,5) = ".$Hornada."";
			$Consulta.= " AND (cod_producto=22 and cod_subproducto=6 ";
			$Consulta.= " OR cod_producto=39 and cod_subproducto=6 ";
			$Consulta.= " OR cod_producto=42 and cod_subproducto=21)";
			$Consulta.=" and left(hornada,4) = '".$AnoTer."'";
			$Consulta.= " AND turno = '".$cmbturno."'";
//echo "xxxxxx".$Consulta."<br>";
			$rs = mysql_query($Consulta);
			while($Fila = mysql_fetch_array($rs))
			{
				if($Fila["cod_producto"] == 42 AND $Fila[cod_subproducto] == 21)
				{
					$EscFus = $Fila["unidades"];				
					$Peso_EscFus = $Fila["peso"];				
				}
			
				if($Fila["cod_producto"] == 22 AND $Fila[cod_subproducto] == 6)
				{
					$EscOxid = $Fila["unidades"];				
					$Peso_EscOxid = $Fila["peso"];				
				}
				if($Fila["cod_producto"] == 39 AND $Fila[cod_subproducto] == 6)
				{
					$LadrTrof = $Fila["unidades"];				
					$Peso_LadrTrof = $Fila["peso"];				
				}

			}
			//CIRCULANTES RAF
			$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = ".$Hornada."";
			else
				$Consulta.= " WHERE right(hornada,5) = ".$Hornada."";
			$Consulta.= " AND cod_producto IN(42)";
			$Consulta.= " AND cod_subproducto IN(16,31,39,43,69,70,73,74,75,76,77,78)";
			$Consulta.=" and left(hornada,4) = '".$AnoTer."'";
			$Consulta.= " AND turno = '".$cmbturno."' ";
//echo "xxxxxxx".$Consulta."<br>";
			$resp = mysql_query($Consulta);		
			$row = mysql_fetch_array($resp);
			$CircRafUnid = $row["unidades"];
			$CircRafPeso = $row["peso"];
			
			//CIRCULANTES REF
			$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = ".$Hornada."";
			else
				$Consulta.= " WHERE right(hornada,5) = ".$Hornada."";
			$Consulta.= " AND (cod_producto=29 and cod_subproducto=1 ";
			$Consulta.= " OR cod_producto=48 and cod_subproducto=10 ";
			$Consulta.= " OR cod_producto=49 and cod_subproducto=4)";
			$Consulta.=" and left(hornada,4) = '".$AnoTer."'";
			$Consulta.= " AND turno = '".$cmbturno."'";
//echo "xxxxxxxx".$Consulta."<br>";
			$resp = mysql_query($Consulta);		
			$row = mysql_fetch_array($resp);
			$CircRefUnid = $row["unidades"];
			$CircRefPeso = $row["peso"];
			
			//CIRCULANTES PMN
			$Consulta = "select sum(unidades) as unidades, sum(peso) as peso from raf_web.movimientos";
			if(strlen($Hornada) == 4)
				$Consulta.= " WHERE right(hornada,4) = ".$Hornada."";
			else
				$Consulta.= " WHERE right(hornada,5) = ".$Hornada."";
			$Consulta.= " AND (cod_producto=22 and cod_subproducto=6 ";
			$Consulta.= " OR cod_producto=39 and cod_subproducto=6 ";
			$Consulta.= " OR cod_producto=42 and cod_subproducto=21)";
			$Consulta.=" and left(hornada,4) = '".$AnoTer."'";
			$Consulta.= " AND turno = '".$cmbturno."' ";
//echo "xxxxxxxxx".$Consulta."<br>";
			$resp = mysql_query($Consulta);		
			$row = mysql_fetch_array($resp);
			$CircPmnUnid = $row["unidades"];
			$CircPmnPeso = $row["peso"];
			
	  	//}
		
		$Consulta = "select * from raf_web.movimientos";
		if(strlen($Hornada) == 4)
			$Consulta.= " WHERE right(hornada,4) = ".$Hornada."";
		else
			$Consulta.= " WHERE right(hornada,5) = ".$Hornada."";
		if($cmbturno != -1)		
			$Consulta.= " AND turno = '".$cmbturno."'";
		$Consulta.=" and left(hornada,4) = '".$AnoTer."'";

//echo "xxxxxxxss".$Consulta."<br>";
		$res = mysql_query($Consulta);		
		$Row = mysql_fetch_array($res);
		$Solera = $Row[solera];
//		$cmbturno = $Row[turno];
		
		$Consulta2 = "select sum(unidades) as unid,sum(peso) as peso from raf_web.movimientos";
		if(strlen($Hornada) == 4)
			$Consulta2.= " WHERE right(hornada,4) = ".$Hornada."";
		else
			$Consulta2.= " WHERE right(hornada,5) = ".$Hornada."";
		if($cmbturno != -1)
			$Consulta2.= " AND turno = '".$cmbturno."'";
		$Consulta2.=" and left(hornada,4) = '".$AnoTer."'";
	
//echo "xxxxxxxmm".$Consulta2."<br>";
		$res2 = mysql_query($Consulta2);
		$Row2 = mysql_fetch_array($res2);
		$UnidEst = $Row2[unid];		
		$PesoEst = $Row2["peso"];
		$TotalUnid = $Row2[unid];
		$TotalPeso = $Row2["peso"];
		if($TotalPeso != '' AND $TotalPeso != 0)
		{
			$Dia = substr($Row[fecha_carga],8,2);
			$Ano = substr($Row[fecha_carga],0,4);
			$Mes = substr($Row[fecha_carga],5,2);		
			//Fechas De Registro De Busqueda
			$DiaIni = substr($Row["fecha_ini"],8,2);
			$AnoIni = substr($Row["fecha_ini"],0,4);
			$MesIni = substr($Row["fecha_ini"],5,2);		
			$DiaTer = substr($Row["fecha_ter"],8,2);
			$AnoTer = substr($Row["fecha_ter"],0,4);
			$MesTer = substr($Row["fecha_ter"],5,2);		
		}				


		if($cmbturno == -1)		
			$Proceso = 'B';
	}

//Datos Provenientes de PopUp
	if($Blister_Unid != '')
	{
		$BlisterUnid = $Blister_Unid;
		$TotalUnid = $Total_Unid;
	}

	if($Blister_Peso != '')
	{
		/*$BlisterPeso = 0;
		$TotalPeso = 0;
		$BlistCps = 0;
		$Peso_BlistCps = 0;
		$BlistBasc = 0;
		$Peso_BlistBasc = 0;
		$BlistReten = 0;
		$Peso_BlistReten = 0;*/
		if (isset($Blister_Peso))
		{
			$BlisterPeso = $Blister_Peso;
			$TotalPeso = $Total_Peso;
		}
		if (isset($blistcps))
		{
			$BlistCps = $blistcps;
			$Peso_BlistCps = $peso_blistcps;
		}
		if (isset($blistbasc))
		{
			$BlistBasc = $blistbasc;
			$Peso_BlistBasc = $peso_blistbasc;
		}
		if (isset($blistreten))
		{
			$BlistReten = $blistreten;
			$Peso_BlistReten = $peso_blistreten;
		}
	}

	if($Circ_Unid != '')
	{
		$CircUnid = $Circ_Unid;
		$TotalUnid = $Total_Unid;
	}

	if($Circ_Peso != '')
	{
		$CircPeso = $Circ_Peso;
		$TotalPeso = $Total_Peso;
		//raf
		/*$Tallarines = 0;
		$Peso_Tallarines = 0;
		$CuRecup = 0;
		$Peso_CuRecup = 0;
		$Queques = 0;
		$Peso_Queques = 0;
		$BoteAlb = 0;
		$Peso_BoteAlb = 0;
		$Moldes = 0;
		$Peso_Moldes = 0;
		$BoteOxid = 0;
		$Peso_BoteOxid = 0;
		$AnodCirc = 0;
		$Peso_AnodCirc = 0;	
		$Maceteros = 0;
		$Peso_Maceteros = 0;
		$Rebalses = 0;
		$Peso_Rebalses = 0;
		$Chatarra = 0;				
		$Peso_Chatarra = 0;				
		$Placas = 0;				
		$Peso_Placas = 0;				
		$CuPiso = 0;				
		$Peso_CuPiso = 0;				
		//ref
		$BarroAnod = 0;				
		$Peso_BarroAnod = 0;				
		$BarridoCu = 0;				
		$Peso_BarridoCu = 0;				
		$GranaCu = 0;				
		$Peso_GranaCu = 0;				
		//pmn
		$EscFus = 0;				
		$Peso_EscFus = 0;				
		$EscOxid = 0;				
		$Peso_EscOxid = 0;				
		$LadrTrof = 0;				
		$Peso_LadrTrof = 0;*/				
				
		//asigna valores raf
		if (isset($tallarines))
		{
			$Tallarines = $tallarines;
			$Peso_Tallarines = $peso_tallarines;
		}
		if (isset($curecup))
		{
			$CuRecup = $curecup;
			$Peso_CuRecup = $peso_curecup;
		}
		if (isset($queques))
		{
			$Queques = $queques;
			$Peso_Queques = $peso_queques;
		}
		if (isset($botealb))
		{
			$BoteAlb = $botealb;
			$Peso_BoteAlb = $peso_botealb;
		}
		if (isset($moldes))
		{
			$Moldes = $moldes;
			$Peso_Moldes = $peso_moldes;
		}
		if (isset($boteoxid))
		{
			$BoteOxid = $boteoxid;
			$Peso_BoteOxid = $peso_boteoxid;
		}
		if (isset($anodcirc))
		{
			$AnodCirc = $anodcirc;
			$Peso_AnodCirc = $peso_anodcirc;	
		}
		if (isset($maceteros))
		{
			$Maceteros = $maceteros;
			$Peso_Maceteros = $peso_maceteros;
		}
		if (isset($rebalses))
		{
			$Rebalses = $rebalses;
			$Peso_Rebalses = $peso_rebalses;
		}
		if (isset($chatarra))
		{
			$Chatarra = $chatarra;				
			$Peso_Chatarra = $peso_chatarra;	
		}
		if (isset($placas))
		{			
			$Placas = $placas;				
			$Peso_Placas = $peso_placas;		
		}
		if (isset($cupiso))
		{		
			$CuPiso = $cupiso;				
			$Peso_CuPiso = $peso_cupiso;
		}
		
		$CircRafUnid = $Tallarines + $CuRecup + $Queques + $BoteAlb + $Moldes + $BoteOxid + $AnodCirc + $Maceteros + $Rebalses + $Chatarra + $Placas + $CuPiso;
		$CircRafPeso = $Peso_Tallarines + $Peso_CuRecup + $Peso_Queques + $Peso_BoteAlb + $Peso_Moldes + $Peso_BoteOxid + $Peso_AnodCirc + $Peso_Maceteros + $Peso_Rebalses + $Peso_Chatarra + $Peso_Placas + $Peso_CuPiso;
		
		//asigna valores ref	
		if (isset($barroanod))
		{	
			$BarroAnod = $barroanod;
			$Peso_BarroAnod = $peso_barroanod;
		}
		if (isset($barridocu))
		{	
			$BarridoCu = $barridocu;
			$Peso_BarridoCu = $peso_barridocu;
		}
		if (isset($granacu))
		{
			$GranaCu = $granacu;
			$Peso_GranaCu = $peso_granacu;
		}
		
		$CircRefUnid = $BarroAnod + $BarridoCu  + $GranaCu;
		$CircRefPeso = $Peso_BarroAnod + $Peso_BarridoCu + $Peso_GranaCu;
		
		//asigna valores pmn
		if (isset($escfus))
		{
			$EscFus = $escfus;
			$Peso_EscFus = $peso_escfus;
		}
		if (isset($escoxid))
		{
			$EscOxid = $escoxid;
			$Peso_EscOxid = $peso_escoxid;
		}
		if (isset($ladrtrof))
		{
			$LadrTrof = $ladrtrof;
			$Peso_LadrTrof = $peso_ladrtrof;
		}
		
		$CircPmnUnid = $EscFus + $EscOxid + $LadrTrof;
		$CircPmnPeso = $Peso_EscFus + $Peso_EscOxid + $Peso_LadrTrof;
	}


?>
<html>
<head>
<script language="JavaScript">
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
			eval("Txt" + numero + ".style.left = 100 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4) 
		{
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}

function calcular()
{
var f = FrmPrincipal;

	if(f.UnidCirc.value == '')
	{
		f.TotalUnid.value = f.TotalUnidAnt.value * 1;	
	}
	else
	{		
		f.TotalUnid.value = f.TotalUnidAnt.value * 1 +  f.UnidCirc.value * 1;
	}

	if(f.PesoCirc.value == '')
	{
		f.TotalPeso.value = f.TotalPesoAnt.value * 1;
	}
	else
	{
		f.TotalPeso.value = f.TotalPesoAnt.value * 1 +  f.PesoCirc.value *1;	
	}

	 if((f.PesoEst.value - f.TotalPeso.value) < 0)
 		alert("Sobrepaso El Peso Estimado");
	
}

function calcula1(f,i,cont)
{
var f = FrmPrincipal;
var posi = i;
//var tope = i;
var peso_prom = 0;
var porcent = 0;
var unidades = 0;
var peso = 0;

if(f.TotalUnid.value == '')
	 f.TotalUnid.value = 0;

if(f.TotalPeso.value == '')
	 f.TotalPeso.value = 0;


peso_prom = f.elements[posi - 1].value/f.elements[posi - 2].value;

//peso
f.elements[posi + 1].value = Math.round(f.elements[posi].value * peso_prom);

//porcent
f.elements[posi + 2].value = Math.round((f.elements[posi + 1].value * 100)/f.elements[posi - 1].value);

//verifica si sobrepaso el 100% 
if(parseInt(f.elements[posi].value) > parseInt(f.elements[posi - 2].value))
{
	alert("Sobrepaso el Maximo de Existencia");
    f.elements[posi].value = "";
	f.elements[posi + 1].value = "";
    f.elements[posi + 2].value = "";
    f.elements[posi].focus();
}

	if(f.elements[posi].value == '')
		unidades = 0;
	else
		unidades = f.elements[posi].value;

	if(f.elements[posi + 1].value == '')
		peso = 0;
	else
		peso = f.elements[posi + 1].value;

	if(f.elements[posi + 3].value != '' && f.elements[posi + 4].value != '')
	{
		f.TotalUnid.value = Math.round(parseInt(f.TotalUnid.value) - parseInt(f.elements[posi + 3].value))
		f.TotalPeso.value = Math.round(parseInt(f.TotalPeso.value) - parseInt(f.elements[posi + 4].value))
    }

	if(f.elements[posi].value != '' && f.elements[posi + 1].value != '')
	f.elements[posi + 3].value = f.elements[posi].value;
	f.elements[posi + 4].value = f.elements[posi + 1].value;

					
	f.TotalUnid.value = Math.round(parseInt(f.TotalUnid.value) + parseInt(unidades));			
	f.TotalPeso.value = Math.round(parseInt(f.TotalPeso.value) + parseInt(peso));

	f.TotalUnidAnt.value = Math.round(parseInt(f.TotalUnid.value));			
	f.TotalPesoAnt.value = Math.round(parseInt(f.TotalPeso.value));


 if((f.PesoEst.value - f.TotalPeso.value) < 0)
 	alert("Sobrepaso El Peso Estimado");

}

function calcula2(f,i)
{
var f = FrmPrincipal;
var posi = i;
//var tope = i;
var peso_prom = 0;
var porcent = 0;
var unidades = 0;
var peso = 0;

if(f.TotalUnid.value == '')
	 f.TotalUnid.value = 0;

if(f.TotalPeso.value == '')
	 f.TotalPeso.value = 0;


peso_prom = f.elements[posi - 2].value/f.elements[posi - 3].value;

//unidades
f.elements[posi - 1].value = Math.round(f.elements[posi].value / peso_prom);

//porcent
f.elements[posi + 1].value = Math.round((f.elements[posi].value * 100)/f.elements[posi - 2].value);

//verifica si sobrepaso la existencia
if(parseInt(f.elements[posi - 1].value) > parseInt(f.elements[posi - 3].value))
{
	alert("Sobrepaso el Maximo de Existencia");
	f.elements[posi - 1].value = "";
    f.elements[posi].value = "";
    f.elements[posi + 1].value = "";
    f.elements[posi].focus();
}

	if(f.elements[posi].value == '')
	{
		f.elements[posi - 1].value = f.elements[posi - 3].value
		unidades = f.elements[posi - 3].value;
	}
	else
	{
		unidades = f.elements[posi - 1].value;
	}
	if(f.elements[posi].value == '')
	{
		f.elements[posi].value = f.elements[posi - 2].value
		peso = f.elements[posi - 2].value;
	}
	else
	{
		peso = f.elements[posi].value;
	}
	
	//porcent
	f.elements[posi + 1].value = Math.round((f.elements[posi].value * 100)/f.elements[posi - 2].value);

	if(f.elements[posi + 2].value != '' && f.elements[posi + 3].value != '')
	{
		f.TotalUnid.value = Math.round(parseInt(f.TotalUnid.value) - parseInt(f.elements[posi + 2].value))
		f.TotalPeso.value = Math.round(parseInt(f.TotalPeso.value) - parseInt(f.elements[posi + 3].value))
    }

	if(f.elements[posi].value != '' && f.elements[posi - 1].value != '')
	{
		f.elements[posi + 3].value = f.elements[posi].value;
		f.elements[posi + 2].value = f.elements[posi - 1].value;
	}

	f.TotalUnid.value = Math.round(parseInt(f.TotalUnid.value) + parseInt(unidades));			
	f.TotalPeso.value = Math.round(parseInt(f.TotalPeso.value) + parseInt(peso));

	f.TotalUnidAnt.value = Math.round(parseInt(f.TotalUnid.value));			
	f.TotalPesoAnt.value = Math.round(parseInt(f.TotalPeso.value));
 
 if((f.PesoEst.value - f.TotalPeso.value) < 0)
 	alert("Sobrepaso El Peso Estimado");

}


function calcula3(f,i)
{
var f = FrmPrincipal;
var posi = i;
var peso_prom = 0;
var unidades = 0;

	if(f.TotalUnid.value == '')
		 f.TotalUnid.value = 0;
	
	if(f.TotalPeso.value == '')
		 f.TotalPeso.value = 0;
 
	peso_prom = f.elements[posi - 3].value/f.elements[posi - 4].value;

	
	f.elements[posi - 2].value = Math.round((f.elements[posi - 4].value * f.elements[posi].value)/100);

	//peso
	f.elements[posi - 1].value = Math.round(f.elements[posi - 2].value * peso_prom);

posi = posi - 2;	
//verifica si sobrepaso el 100% 
if(parseInt(f.elements[posi].value) > parseInt(f.elements[posi - 2].value))
{
	alert("Sobrepaso el Maximo de Existencia");
    f.elements[posi].value = "";
	f.elements[posi - 1].value = "";
    f.elements[posi - 2].value = "";
    f.elements[posi].focus();
}

	if(f.elements[posi].value == '')
		unidades = 0;
	else
		unidades = f.elements[posi].value;

	if(f.elements[posi + 1].value == '')
		peso = 0;
	else
		peso = f.elements[posi + 1].value;

	if(f.elements[posi + 3].value != '' && f.elements[posi + 4].value != '')
	{
		f.TotalUnid.value = Math.round(parseInt(f.TotalUnid.value) - parseInt(f.elements[posi + 3].value))
		f.TotalPeso.value = Math.round(parseInt(f.TotalPeso.value) - parseInt(f.elements[posi + 4].value))
    }

	if(f.elements[posi].value != '' && f.elements[posi + 1].value != '')
	f.elements[posi + 3].value = f.elements[posi].value;
	f.elements[posi + 4].value = f.elements[posi + 1].value;

					
	f.TotalUnid.value = Math.round(parseInt(f.TotalUnid.value) + parseInt(unidades));			
	f.TotalPeso.value = Math.round(parseInt(f.TotalPeso.value) + parseInt(peso));

	f.TotalUnidAnt.value = Math.round(parseInt(f.TotalUnid.value));			
	f.TotalPesoAnt.value = Math.round(parseInt(f.TotalPeso.value));

 if((f.PesoEst.value - f.TotalPeso.value) < 0)
 	alert("Sobrepaso El Peso Estimado");

}


function MostrarPopupProceso(Proceso)
{
	var Frm=document.FrmPrincipal;
	var Valores="";
	var NumContrato="";
	var Resp="";
	var LargoForm = Frm.elements.length;

	switch (Proceso)
	{

		case "B":
			Frm.action = "raf_ingreso_carga_preparacion01.php?Proceso=B";
			Frm.submit();	
			break;

		case "H":
			if(Frm.Hornada.value == '')
			{
				alert("Debe Ingresar Nro De Hornada");
				Frm.Hornada.focus();	 
				return
		    }

			Frm.action = "raf_ingreso_carga_preparacion_res1.php?Proceso=H" ;
			Frm.submit();	
			break;

		case "M":
			if(Frm.Hornada.value == '')
			{
				alert("Debe Ingresar Nro De Hornada");
				Frm.Hornada.focus();	 
				return
		    }

			if(Frm.Solera.value == '')
			{
				alert("Debe Ingresar Nro De Solera");
				Frm.Solera.focus();	 
				return
		    }

			if(Frm.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				Frm.cmbturno.focus();	 
				return
		    }

			if(Frm.PesoEst.value == '')
			{
				alert("Debe Ingresar Peso Estimado");
				Frm.PesoEst.focus();	 
				return
		    }

			if(Frm.tope.value == 2006)
			{
				alert("No hay Datos Para Ingresar");
				return
			}

			Frm.action = "raf_ingreso_carga_preparacion01.php?Proceso=M" ;
			Frm.submit();
			break;
//			window.open("raf_control_mod.php?Proceso=M","","top=0,left=180,width=405,height=210,scrollbars=no,resizable = no");		
//			break;

		case "G":
			if(Frm.Hornada.value == '')
			{
				alert("Debe Ingresar Nro De Hornada");
				Frm.Hornada.focus();	 
				return
		    }

			if(Frm.Solera.value == '')
			{
				alert("Debe Ingresar Nro De Solera");
				Frm.Solera.focus();	 
				return
		    }

			if(Frm.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				Frm.cmbturno.focus();	 
				return
		    }

			if(Frm.PesoEst.value == '')
			{
				alert("Debe Ingresar Peso Estimado");
				Frm.PesoEst.focus();	 
				return
		    }

			if(Frm.tope.value == 2006)
			{
				alert("No hay Datos Para Ingresar");
				return
			}

			Frm.action = "raf_ingreso_carga_preparacion01.php?Proceso=G" ;
			Frm.submit();
			break;

		case "C":
			if(Frm.Hornada.value == '')
			{
				alert("Debe Ingresar Nro De Hornada");
				Frm.Hornada.focus();	 
				return
		    }

			if(Frm.Solera.value == '')
			{
				alert("Debe Ingresar Nro De Solera");
				Frm.Solera.focus();	 
				return
		    }

			if(Frm.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				Frm.cmbturno.focus();	 
				return
		    }

			if(Frm.PesoEst.value == '')
			{
				alert("Debe Ingresar Peso Estimado");
				Frm.PesoEst.focus();	 
				return
		    }		
			valores = "?Ano=" + Frm.Ano.value + "&Mes=" + Frm.Mes.value + "&Dia=" + Frm.Dia.value;
			valores = valores + "&AnoIni="  + Frm.AnoIni.value + "&MesIni=" + Frm.MesIni.value + "&DiaIni=" + Frm.DiaIni.value;
			valores = valores + "&AnoTer="  + Frm.AnoTer.value + "&MesTer=" + Frm.MesTer.value + "&DiaTer=" + Frm.DiaTer.value;
			valores = valores + "&cmbturno="  + Frm.cmbturno.value;
			valores = valores + "&Hornada="  + Frm.Hornada.value;
			valores = valores + "&Encargado="  + Frm.encargado.value;
			valores = valores + "&Solera="  + Frm.Solera.value;
			valores = valores + "&Peso_Estimado="  + Frm.PesoEst.value;
			valores = valores + "&TotalUnid="  + Frm.TotalUnid.value;
			valores = valores + "&TotalPeso="  + Frm.TotalPeso.value;
			valores = valores + "&TotalUnidCircRaf="  + Frm.CircRafUnid.value;
			valores = valores + "&TotalPesoCircRaf="  + Frm.CircRafPeso.value;
			window.open("raf_ingreso_circulantes_raf.php"+valores,"","top=0,left=180,width=450,height=420,scrollbars=no,resizable = no");		
			break;

		case "C2":
			if(Frm.Hornada.value == '')
			{
				alert("Debe Ingresar Nro De Hornada");
				Frm.Hornada.focus();	 
				return
		    }

			if(Frm.Solera.value == '')
			{
				alert("Debe Ingresar Nro De Solera");
				Frm.Solera.focus();	 
				return
		    }

			if(Frm.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				Frm.cmbturno.focus();	 
				return
		    }

			if(Frm.PesoEst.value == '')
			{
				alert("Debe Ingresar Peso Estimado");
				Frm.PesoEst.focus();	 
				return
		    }		
			valores = "?Ano=" + Frm.Ano.value + "&Mes=" + Frm.Mes.value + "&Dia=" + Frm.Dia.value;
			valores = valores + "&AnoIni="  + Frm.AnoIni.value + "&MesIni=" + Frm.MesIni.value + "&DiaIni=" + Frm.DiaIni.value;
			valores = valores + "&AnoTer="  + Frm.AnoTer.value + "&MesTer=" + Frm.MesTer.value + "&DiaTer=" + Frm.DiaTer.value;
			valores = valores + "&cmbturno="  + Frm.cmbturno.value;
			valores = valores + "&Hornada="  + Frm.Hornada.value;
			valores = valores + "&Encargado="  + Frm.encargado.value;
			valores = valores + "&Solera="  + Frm.Solera.value;
			valores = valores + "&Peso_Estimado="  + Frm.PesoEst.value;
			valores = valores + "&TotalUnid="  + Frm.TotalUnid.value;
			valores = valores + "&TotalPeso="  + Frm.TotalPeso.value;
			valores = valores + "&TotalUnidCircRef="  + Frm.CircRefUnid.value;
			valores = valores + "&TotalPesoCircRef="  + Frm.CircRefPeso.value;
			window.open("raf_ingreso_circulantes_ref.php"+valores,"","top=0,left=180,width=430,height=270,scrollbars=no,resizable = no");		
			break;


		case "C3":
			if(Frm.Hornada.value == '')
			{
				alert("Debe Ingresar Nro De Hornada");
				Frm.Hornada.focus();	 
				return
		    }

			if(Frm.Solera.value == '')
			{
				alert("Debe Ingresar Nro De Solera");
				Frm.Solera.focus();	 
				return
		    }

			if(Frm.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				Frm.cmbturno.focus();	 
				return
		    }

			if(Frm.PesoEst.value == '')
			{
				alert("Debe Ingresar Peso Estimado");
				Frm.PesoEst.focus();	 
				return
		    }		
			valores = "?Ano=" + Frm.Ano.value + "&Mes=" + Frm.Mes.value + "&Dia=" + Frm.Dia.value;
			valores = valores + "&AnoIni="  + Frm.AnoIni.value + "&MesIni=" + Frm.MesIni.value + "&DiaIni=" + Frm.DiaIni.value;
			valores = valores + "&AnoTer="  + Frm.AnoTer.value + "&MesTer=" + Frm.MesTer.value + "&DiaTer=" + Frm.DiaTer.value;
			valores = valores + "&cmbturno="  + Frm.cmbturno.value;
			valores = valores + "&Hornada="  + Frm.Hornada.value;
			valores = valores + "&Encargado="  + Frm.encargado.value;
			valores = valores + "&Solera="  + Frm.Solera.value;
			valores = valores + "&Peso_Estimado="  + Frm.PesoEst.value;
			valores = valores + "&TotalUnid="  + Frm.TotalUnid.value;
			valores = valores + "&TotalPeso="  + Frm.TotalPeso.value;
			valores = valores + "&TotalUnidCircPmn="  + Frm.CircPmnUnid.value;
			valores = valores + "&TotalPesoCircPmn="  + Frm.CircPmnPeso.value;
			window.open("raf_ingreso_circulantes_pmn.php"+valores,"","top=0,left=180,width=450,height=270,scrollbars=no,resizable = no");		
			break;

		case "V":
				if(Frm.Hornada.value == '')
				{
					alert("Debe Ingresar Nro De Hornada");
					Frm.Hornada.focus();	 
					return
				}

				valores = "?Valor=1&Hornada="  + Frm.Hornada.value;
				window.open("raf_con_carga_programada.php"+valores,"","top=0,left=180,width=550,height=520,scrollbars=yes,resizable = no");		
				break;
		

		case "P":
			if(Frm.Hornada.value == '')
			{
				alert("Debe Ingresar Nro De Hornada");
				Frm.Hornada.focus();	 
				return
		    }

			if(Frm.Solera.value == '')
			{
				alert("Debe Ingresar Nro De Solera");
				Frm.Solera.focus();	 
				return
		    }

			if(Frm.cmbturno.value == -1)
			{
				alert("Debe Seleccionar Turno");
				Frm.cmbturno.focus();	 
				return
		    }

			if(Frm.PesoEst.value == '')
			{
				alert("Debe Ingresar Peso Estimado");
				Frm.PesoEst.focus();	 
				return
		    }		
			valores = "?Ano=" + Frm.Ano.value + "&Mes=" + Frm.Mes.value + "&Dia=" + Frm.Dia.value;
			valores = valores + "&AnoIni="  + Frm.AnoIni.value + "&MesIni=" + Frm.MesIni.value + "&DiaIni=" + Frm.DiaIni.value;
			valores = valores + "&AnoTer="  + Frm.AnoTer.value + "&MesTer=" + Frm.MesTer.value + "&DiaTer=" + Frm.DiaTer.value;
			valores = valores + "&cmbturno="  + Frm.cmbturno.value;
			valores = valores + "&Hornada="  + Frm.Hornada.value;
			valores = valores + "&Encargado="  + Frm.encargado.value;
			valores = valores + "&Solera="  + Frm.Solera.value;
			valores = valores + "&Peso_Estimado="  + Frm.PesoEst.value;
			valores = valores + "&TotalUnid="  + Frm.TotalUnid.value;
			valores = valores + "&TotalPeso="  + Frm.TotalPeso.value;
			valores = valores + "&TotalUnidBlister="  + Frm.BlisterUnid.value;
			valores = valores + "&TotalPesoBlister="  + Frm.BlisterPeso.value;
			window.open("raf_ingreso_circulantes_blister.php"+valores,"","top=100,left=180,width=400,height=230,scrollbars=no,resizable = no");		
			break;

		case "I":
			window.print();
			break;

		case "E":

			window.open("raf_control_mod.php?Proceso=E","","top=0,left=180,width=405,height=210,scrollbars=no,resizable = no");		
			break;
			break;	
	} 
}

function Salir()
{
	var Frm=document.FrmPrincipal;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=12";
	Frm.submit();
}
</script>
<title>Preparacion Carga A Horno</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style><body>
<form name="FrmPrincipal" method="post" action="">
  <? include("../principal/encabezado.php")?>
  <table width="770" height="450" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5">
    <tr> 
      <td valign="top">
		<table width='759' border='0' cellpadding='0' cellspacing='0' class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td width="66"><b>Encargado:</b></td>
            <td width="248">&nbsp; 
              <? $Consulta = "SELECT * FROM proyecto_modernizacion.funcionarios WHERE rut = '$CookieRut'";
			   $rs = mysql_query($Consulta);
			   $fil = mysql_fetch_array($rs);
			   echo ucwords(strtoupper($fil["nombres"])).' '.ucwords(strtoupper($fil["apellido_paterno"])).' '.ucwords(strtoupper($fil["apellido_materno"]));				
			   echo '<input type="hidden" name="encargado" value="'.$CookieRut.'">';
			?>
              &nbsp;</td>
            <td width="34"> <b>Hora :</b> </td>
            <td width="69">&nbsp; 
              <?
				echo date("H:i");
			?>
            </td>
            <td width="118"><b>Ultimas Hornadas</b></td>
			<?
				$Consulta = "SELECT MAX(hornada) as ref_1 FROM raf_web.movimientos";
				$Consulta.= " WHERE  right(hornada,4) like '10%'";
//echo "xxxxxxxll".$Consulta."<br>";
				$rs = mysql_query($Consulta);
				$row = mysql_fetch_array($rs);
				$Ref_1 = $row[ref_1];
			?>
            <td width="221">
			<? echo "<b>Ref 1:</b> ".substr($Ref_1,6,4); ?>&nbsp;&nbsp;&nbsp;
			<?
				$Consulta = "SELECT MAX(hornada) as ref_2 FROM raf_web.movimientos";
				$Consulta.= " WHERE  right(hornada,4) like '2%'";
//echo "xxxxxxxaa".$Consulta."<br>";
				$rs = mysql_query($Consulta);
				$row = mysql_fetch_array($rs);
				$Ref_2 = $row[ref_2];
			?>
			<? echo "<b>Ref 2:</b> ".substr($Ref_2,6,4); ?></td>
          </tr>
        </table>
		<table width='760' border='0' cellpadding='0' cellspacing='0' class="TablaInterior">
          <tr> 
            <td width="123"> <input name="DiaIni" type="hidden" size="5" value="<? echo $DiaIni ?>"> 
              <input name="MesIni" type="hidden" size="5" value="<? echo $MesIni ?>"> 
              <input name="AnoIni" type="hidden" size="5" value="<? echo $AnoIni ?>">
              Fecha Busqueda</td>
            <td width="179"> <input name="DiaTer" type="hidden" size="5" value="<? echo $DiaTer ?>"> 
              <select name="MesTer" style="width:90px;">
                <?
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($MesTer))
					{
						if ($MesTer == $i)
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </select> <select name="AnoTer" style="width:60px;">
                <?
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($AnoTer))
					{
						if ($AnoTer == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
				?>
              </select> </td>
            <td width="180"> &nbsp; <input type="button" name="BtnBuscar" value="Buscar" style="width:60" onClick="MostrarPopupProceso('B');"> 
            </td>
            <td width="275">Ver Preparación 
              <input type="button" name="BtnVer" value="Ver" style="width:30" onClick="MostrarPopupProceso('V');"></td>
          </tr>
        </table>
		<br>  		  
		<table width='760' border='0' cellpadding='0' cellspacing='0' class="TablaInterior">
          <tr> 
            <td width="72">Fecha Carga</td>
            <td width="222"> <select name="Dia" style="width:50px;">
                <?
				for ($i = 1;$i <= 31; $i++)
				{
					if (isset($Dia))
					{
						if ($Dia == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("j"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			  ?>
              </select> <select name="Mes" style="width:90px;">
                <?
                $Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
				for ($i = 1;$i <= 12; $i++)
				{
					if (isset($Mes))
					{
						if ($Mes == $i)
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					}
				}
				?>
              </select> <select name="Ano" style="width:60px;">
                <?
				for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
				{
					if (isset($Ano))
					{
						if ($Ano == $i)
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option selected value='".$i."'>".$i."</option>\n";
						else	echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
				?>
              </select> </td>
            <td width="75">Hornada</td>
            <td width="55"><input name="Hornada" size="10" value="<? echo $Hornada?>">
            </td>
            <td width="71">Turno</td>
            <td width="113">
            <select name="cmbturno">
            <?
				echo"<option value='-1' selected>Turnos</option>";
				echo"<option value='0'>-------</option>";
				if($cmbturno == "A")
					echo"<option value='A' selected>Turno A</option>";
				else
					echo"<option value='A'>Turno A</option>";
				if($cmbturno == "B")
					echo"<option value='B' selected>Turno B</option>";
				else
					echo"<option value='B'>Turno B</option>";
				if($cmbturno == "C")
					echo"<option value='C' selected>Turno C</option>";
				else
					echo"<option value='C'>Turno C</option>";
				
			?>
            </select>
            <input type="button" name="BtnBuscar2" value="Ok" style="width:30" onClick="MostrarPopupProceso('H');"></td>
            <td width="43">Muro</td>
            <td width="106"> 
              <input name="Solera" size="10" value="<? echo $Solera?>"> </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Peso Total</td>
            <td><input name="PesoEst" size="10" style="background:#00CCFF" value="<? echo $PesoEst?>"></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <?

			echo "<table width='740' border='1' cellpadding='0' cellspacing='0'>";
			echo "<tr class='ColorTabla01'>"; 
			echo "<td width='10%' align='center'>Fecha</td>";
			echo "<td width='17%' align='center'>Producto</td>";
			echo "<td width='5%' align='center'>Grupo</td>";
			echo "<td width='8%' align='center'>As</td>";
			echo "<td width='8%' align='center'>Sb</td>";
			echo "<td width='8%' align='center'>Fe</td>";
			echo "<td width='9%' align='center'>Exist Unid.</td>";
			echo "<td width='9%' align='center'>Exist Peso</td>";
                                                                                                                                                                        			echo "<td width='12%' align='center'>Carga Unid.</td>";
			echo "<td width='12%' align='center'>Carga Peso</td>";
			echo "<td width='10%' align='center'>Porcent</td>";
			echo "</tr>";
			echo "</table>";
			
			if($Proceso == "B")
			{			
				echo "<div style='position:absolute; left: 10px; top: 169px; width: 760px; height: 157px; OVERFLOW: auto;' id='div2'>";
				echo "<table width='740' border='1' cellpadding='0' cellspacing='0' class='TablaInterior'>";
							
			    $FechaIni = $AnoIni.'-'.$MesIni.'-'.$DiaIni;
			    $FechaTer = $AnoTer.'-'.$MesTer.'-'.$DiaTer;
				

				$Crear_Tabla = "CREATE TEMPORARY TABLE raf_web.tmp_table as SELECT fecha_movimiento,hora,cod_producto,cod_subproducto,hornada,campo2,fecha_benef,unidades,peso";				
				$Crear_Tabla.= " FROM sea_web.movimientos WHERE tipo_movimiento = 4";
				$Crear_Tabla.= " AND fecha_movimiento BETWEEN '".$FechaIni."' AND '".$FechaTer."'";
				mysql_query($Crear_Tabla);
			
				$Consulta = "select distinct fecha_movimiento, cod_producto, cod_subproducto, hornada, (campo2 * 1) as campo2 from raf_web.tmp_table";
				$Consulta.= " WHERE fecha_movimiento BETWEEN '".$FechaIni."' AND '".$FechaTer."' order by campo2 ASC,fecha_movimiento ASC,cod_producto,cod_subproducto";
//echo "xxxxxxxdd".$Consulta."<br>";
				$Resultado=mysql_query($Consulta);

				$pos = 16;
				$i=0;
				while ($Fila=mysql_fetch_array($Resultado))
				{

					if($Fila["cod_producto"] != 19)
					{
						$Consulta = "SELECT fecha_movimiento as fecha_benef, hornada, hora FROM raf_web.tmp_table";
						$Consulta.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
						$Consulta.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta.= " AND hornada = '".$Fila["hornada"]."'";
//echo "xxxxxxxff".$Consulta."<br>";
						$Res = mysql_query($Consulta);
						$Fil = mysql_fetch_array($Res);

						$Consulta2 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.tmp_table";
						$Consulta2.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
						$Consulta2.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta2.= " AND hornada = '".$Fila["hornada"]."'";
//echo "xxxxxxxhh".$Consulta2."<br>";
						$rs1 = mysql_query($Consulta2);
						$row = mysql_fetch_array($rs1);
						
						$Consulta3 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.movimientos";
						$Consulta3.= " WHERE fecha_sea = '".$Fila[fecha_movimiento]."'";
						$Consulta3.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta3.= " AND hornada_sea = '".$Fila["hornada"]."'";
//echo "xxxxxxxgg".$Consulta3."<br>";
						$rs2 = mysql_query($Consulta3);
						$row2 = mysql_fetch_array($rs2);
					}
					else
					{
						$Consulta = "SELECT fecha_movimiento as fecha_benef, hornada, hora FROM raf_web.tmp_table";
						$Consulta.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
						$Consulta.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta.= " AND campo2 = ".$Fila[campo2];
						$Consulta.= " AND hornada = '".$Fila["hornada"]."'";
//echo "xxxxxxxww".$Consulta."<br>";
						$Res = mysql_query($Consulta);
						$Fil = mysql_fetch_array($Res);

						$Consulta2 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.tmp_table";
						$Consulta2.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
						$Consulta2.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta2.= " AND campo2 = ".$Fila[campo2];
						$Consulta2.= " AND hornada = '".$Fila["hornada"]."'";
//echo "xxxxxxxtt".$Consulta2."<br>";
						$rs1 = mysql_query($Consulta2);
						$row = mysql_fetch_array($rs1);

						$Consulta3 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.movimientos";
						$Consulta3.= " WHERE fecha_sea = '".$Fil[fecha_benef]."'";
						$Consulta3.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta3.= " AND grupo = ".$Fila[campo2];
						$Consulta3.= " AND hornada_sea = '".$Fila["hornada"]."'";
//echo "xxxxxxxpp".$Consulta3."<br>";
						$rs2 = mysql_query($Consulta3);
						$row2 = mysql_fetch_array($rs2);
					}
					$dif_unid = $row[unid] - $row2[unid];						
					$dif_peso =	$row["peso"] - $row2["peso"];
					//echo "UNID .=".$row[unid]." - ".$row2[unid]."<br>";
					//echo "PESO .=".$row["peso"]." - ".$row2["peso"]."<br>";

					if($dif_peso > 0 && $dif_unid >= 0)//si es menor a 0 no muestra dato
					{
						if($Fila["cod_producto"] == 19)
				        	$fecha = $Fil[fecha_benef]; 
						else
				        	$fecha = $Fila[fecha_movimiento]; 
							
							$i++;
							$Cont2++;
	  					    $pos = $pos + 9;				
							echo "<tr>"; 
							echo'<input name="a['.$i.']" type="hidden" size="8">';

							echo "<td width='10%' align='left' onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>".$fecha;
							echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:250px'>\n";
							echo "<font face='courier' color='#000000' size=1><b>Fecha Traspaso:&nbsp;</b>".$fecha."</font><br>";
							echo "<font face='courier' color='#000000' size=1><b>Fecha Realizado:&nbsp;</b>".$Fil[hora]."</font><br>";
							echo "</div></td>";			

							//echo "<td width='10%' align='left'>".$fecha."</td>";				
							echo'<input name="fecha['.$i.']" type="hidden" size="10" value="'.$fecha.'">';					

							$Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto"; 
							$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"];
							$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
							$rs = mysql_query($Consulta);
							$fila = mysql_fetch_array($rs);
							 
							echo"<td width='15%' align='left' bgcolor='#cccccc'>".$fila["abreviatura"]."</td>";				
							echo'<input name="cod_producto['.$i.']" type="hidden" size="2" value="'.$Fila["cod_producto"].'">';
							echo'<input name="cod_subproducto['.$i.']" type="hidden" size="2" value="'.$Fila[cod_subproducto].'">';
		
							echo "<td width='5%' align='center'>".$Fila[campo2]."&nbsp;</td>";
							echo '<input type="hidden" name="grupo['.$i.']" value="'.$Fila[campo2].'" size="10">';
							echo '<input type="hidden" name="hornada_sea['.$i.']" value="'.$Fil["hornada"].'" size="20">';
	
							$Consulta = "SELECT valor, cod_leyes FROM sea_web.leyes_por_hornada ";
							$Consulta.= " WHERE cod_producto = '".$Fila["cod_producto"]."'";
							$Consulta.= " AND cod_subproducto = '".$Fila[cod_subproducto]."'";
							$Consulta.= " AND hornada = '".$Fil["hornada"]."'";
							$Consulta.= " AND (cod_leyes = '08' or cod_leyes ='09' or cod_leyes = '31') ";
//echo "xxxxxxx99".$Consulta."<br>";	
							$resp = mysql_query($Consulta);
							$As = '';
							$Sb = '';
							$Fe = '';
							while($fila1 = mysql_fetch_array($resp))
							{
								if($fila1["cod_leyes"] == '08')
									$As = $fila1["valor"];
								if($fila1["cod_leyes"] == '09')
									$Sb = $fila1["valor"];

								if($fila1["cod_leyes"] == '31')
									$Fe = $fila1["valor"];
							}
							echo "<td width='8%' align='center'>".number_format($As,0,'','')."&nbsp;</td>";	
							echo "<td width='8%' align='center'>".number_format($Sb,0,'','')."&nbsp;</td>";
							echo "<td width='8%' align='center'>".number_format($Fe,0,'','')."&nbsp;</td>";
						if($row2["peso"] != '')
						{
							echo "<td width='9%' align='right'><font color='#FF3333'>".$dif_unid."&nbsp;</font></td>";
							echo'<input name="unid['.$i.']" type="hidden" size="8" value="'.$dif_unid.'">';		
							echo "<td width='9%' align='right'><font color='#FF3333'>".$dif_peso."&nbsp;</font></td>";
							echo'<input name="pes['.$i.']" type="hidden" size="8" value="'.$dif_peso.'">';
						}
						else
						{
							echo "<td width='9%' align='right'>".$dif_unid."&nbsp;</td>";
							echo'<input name="unid['.$i.']" type="hidden" size="8" value="'.$dif_unid.'">';		
							echo "<td width='9%' align='right'>".$dif_peso."&nbsp;</td>";
							echo'<input name="pes['.$i.']" type="hidden" size="8" value="'.$dif_peso.'">';
						}
							echo "<td width='12%' align='center'><input type='text' name='unidades[".$i."]' size='10' value='$unidades[$i]' onBlur='calcula1(this.form,".($pos).")'></td>";
							echo "<td width='12%' align='center'><input type='text' name='peso[".$i."]' size='10' value='$peso[$i]' style='background:#FFFFCC' onBlur='calcula2(this.form,".($pos + 1).")'></td>";						
							echo "<td width='10%' align='center'><input type='text' name='porcent[".$i."]' size='3' value='$porcent[$i]' onBlur='calcula3(this.form,".($pos + 2).")'>%</td>";
							//guarda el valor anterior
							echo'<input name="ActualUnid[".$i."]" type="hidden" size="10" value="">';
							echo'<input name="ActualPeso[".$i."]" type="hidden" size="10" value="">';
	
							echo "</tr>";
							
							//Acummuladores 
							$AcumUnid = $AcumUnid + $dif_unid;
							$AcumPeso = $AcumPeso + $dif_peso;
							$pos = $pos + 4;																	

					}

				}				
				echo "</table>";
				echo "</div>";				
			}
			
			$HornadaAux = $Ano.str_pad($Mes,2,"0",STR_PAD_LEFT).$Hornada;
			if($Proceso == "H" AND ($TotalPeso != '' AND $TotalPeso != 0))
			{								
				echo "<div style='position:absolute; left: 10px; top: 169px; width: 760px; height: 157px; OVERFLOW: auto;' id='div2'>";
				echo "<table width='740' border='1' cellpadding='0' cellspacing='0' class='TablaInterior'>";

			    $FechaIni = $AnoIni.'-'.$MesIni.'-'.$DiaIni;
			    $FechaTer = $AnoTer.'-'.$MesTer.'-'.$DiaTer;
				$Fecha = $Ano.'-'.$Mes.'-'.$Dia;
				$Crear_Tabla = "CREATE TEMPORARY TABLE raf_web.tmp_table as SELECT fecha_movimiento,hora,cod_producto,cod_subproducto,hornada,campo2,fecha_benef,unidades,peso";				
				$Crear_Tabla.= " FROM sea_web.movimientos WHERE tipo_movimiento = 4";
				$Crear_Tabla.= " AND fecha_movimiento BETWEEN '".$FechaIni."' AND '".$FechaTer."'";
				mysql_query($Crear_Tabla);
				//echo $Crear_Tabla;
							
				$Consulta = "select distinct fecha_movimiento, cod_producto, cod_subproducto, hornada, (campo2 * 1) as campo2 from raf_web.tmp_table";
				$Consulta.= " WHERE fecha_movimiento BETWEEN '".$FechaIni."' AND '".$FechaTer."' order by campo2 ASC,fecha_movimiento ASC,cod_producto,cod_subproducto";
				$Resultado=mysql_query($Consulta);
				$Respuesta = mysql_query($Consulta);
				$pos = 16;
				$i=0;
				while($Fila = mysql_fetch_array($Respuesta))
				{	
					//VERIFICA QUE LA HORNADA NO HAYA SIDO CARGADA COMPLETAMENTE
					if($Fila["cod_producto"] != 19)
					{
						$Consulta = "SELECT fecha_movimiento as fecha, hornada, hora FROM raf_web.tmp_table";
						$Consulta.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
						$Consulta.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta.= " AND hornada = '".$Fila["hornada"]."'";		
//echo "xxxxxxxii".$Consulta."<br>";
						$Res = mysql_query($Consulta);
						$Fil = mysql_fetch_array($Res);
						
						$Consulta2 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.tmp_table";
						$Consulta2.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
						$Consulta2.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta2.= " AND hornada = '".$Fila["hornada"]."'";
//echo "xxxxxxxyy".$Consulta2."<br>";
						$rs1 = mysql_query($Consulta2);
						$row = mysql_fetch_array($rs1);
						
						$Consulta3 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.movimientos";
						$Consulta3.= " WHERE fecha_sea = '".$Fila[fecha_movimiento]."'";
						$Consulta3.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						//$Consulta3.= " AND (hornada <> '".$HornadaAux."' AND turno <> '".$cmbturno."')";	
						$Consulta3.= " AND (hornada <> '".$HornadaAux."')";	
						$Consulta3.= " AND hornada_sea = '".$Fila["hornada"]."'";						
//echo "xxxxxxxxxxxxxxxxcc".$Consulta3."<br>";
						$rs2 = mysql_query($Consulta3);
						$row2 = mysql_fetch_array($rs2);
					}
					else
					{		
						$Consulta = "SELECT fecha_movimiento as fecha_benef, hornada, hora FROM raf_web.tmp_table";
						$Consulta.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
						$Consulta.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta.= " AND campo2 = ".$Fila[campo2];
						$Consulta.= " AND hornada = '".$Fila["hornada"]."'";
//echo "xxxxxxxvv".$Consulta."<br>";
						$Res = mysql_query($Consulta);
						$Fil = mysql_fetch_array($Res);
												
						$Consulta2 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.tmp_table";
						$Consulta2.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
						$Consulta2.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta2.= " AND campo2 = ".$Fila[campo2];
						$Consulta2.= " AND hornada = '".$Fila["hornada"]."'";
//echo "xxxxxxxzz".$Consulta2."<br>";
						$rs1 = mysql_query($Consulta2);
						$row = mysql_fetch_array($rs1);

						$Consulta3 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.movimientos";
						$Consulta3.= " WHERE fecha_sea = '".$Fil[fecha_benef]."'";
						$Consulta3.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
						$Consulta3.= " AND grupo = ".$Fila[campo2];
						//$Consulta3.= " AND (hornada <> '".$HornadaAux."' AND turno <> '".$cmbturno."')";							
						$Consulta3.= " AND (hornada <> '".$HornadaAux."')";							
						$Consulta3.= " AND hornada_sea = '".$Fila["hornada"]."'";
//echo "xxxxxx22".$Consulta3."<br>";
						$rs2 = mysql_query($Consulta3);
						$row2 = mysql_fetch_array($rs2);
					}
					$dif_unid_aux = $row[unid] - $row2[unid];						
					$dif_peso_aux =	$row["peso"] - $row2["peso"];
					//echo "UNID ".$dif_unid_aux. " del grupo $Fila[campo2].=".$row[unid]." - ".$row2[unid]."<br>";
					//echo "PESO ".$dif_peso_aux. " del grupo $Fila[campo2].=".$row["peso"]." - ".$row2["peso"]."<br>";

					if($dif_peso_aux > 0 && $dif_unid_aux >= 0)//si es menor a 0 no muestra dato
					{					
						if($Fila["cod_producto"] != 19)
						{
							$Consulta = "SELECT fecha_movimiento as fecha, hornada, hora FROM raf_web.tmp_table";
							$Consulta.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
							$Consulta.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
							$Consulta.= " AND hornada = '".$Fila["hornada"]."'";						
//echo "xxxxxxx33".$Consulta."<br>";
							$Res = mysql_query($Consulta);
							$Fil = mysql_fetch_array($Res);
	
							$Consulta2 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.tmp_table";
							$Consulta2.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
							$Consulta2.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
							$Consulta2.= " AND hornada = '".$Fila["hornada"]."'";						
//echo "xxxxxxx44".$Consulta."<br>";
							$rs1 = mysql_query($Consulta2);
							$row = mysql_fetch_array($rs1);
							
						}
						else
						{
							$Consulta = "SELECT fecha_movimiento as fecha, hornada, hora FROM raf_web.tmp_table";
							$Consulta.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
							$Consulta.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
							$Consulta.= " AND campo2 = ".$Fila[campo2];
							$Consulta.= " AND hornada = '".$Fila["hornada"]."'";
//echo "xxxxxxx55".$Consulta."<br>";
							$Res = mysql_query($Consulta);
							$Fil = mysql_fetch_array($Res);
	
							$Consulta2 = "select sum(unidades) as unid, sum(peso) as peso from raf_web.tmp_table";
							$Consulta2.= " WHERE fecha_movimiento = '".$Fila[fecha_movimiento]."'";
							$Consulta2.= " AND cod_producto = ".$Fila["cod_producto"]." AND cod_subproducto = ".$Fila[cod_subproducto];
							$Consulta2.= " AND campo2 = ".$Fila[campo2];
							$Consulta2.= " AND hornada = '".$Fila["hornada"]."'";
//echo "xxxxxxx66".$Consulta2."<br>";
							$rs1 = mysql_query($Consulta2);
							$row = mysql_fetch_array($rs1);
	
						}
	
						//suma unid y peso en movimientos raf
						$fecha = $Fil["fecha"];
						$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as peso FROM raf_web.movimientos";
						if(strlen($Hornada) == 4)
							$Consulta.= " WHERE hornada = ".$HornadaAux."";
						else
							$Consulta.= " WHERE right(hornada,5) = ".$HornadaAux."";
						if($cmbturno != -1)
							$Consulta.= " AND turno = '".$cmbturno."'";
						$Consulta.= " AND left(fecha_carga,10) = '".$Fecha."'";
						$Consulta.= " AND fecha_sea = '".$fecha."'";
						$Consulta.= " AND cod_producto = ".$Fila["cod_producto"]."";
						$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto]."";
						$Consulta.= " AND hornada_sea = '".$Fila["hornada"]."'";
						if($Fila[campo2] != '')
							$Consulta.= " AND grupo = ".$Fila[campo2]."";		
//echo "xxxxxxx77".$Consulta."<br>";
						$resp = mysql_query($Consulta);
						$row9 = mysql_fetch_array($resp);					
	
						$dif_unid = $row[unid] - $row9[unid];						
						$dif_peso =	$row["peso"] - $row9["peso"];	
												
						if($row["peso"]  != 0 && $row9["peso"] != 0)
						{
							$porcent =	round((($row9["peso"]*100)/$row["peso"]),0);
						}
						else
						{
							$porcent = 0;
						}
	
						$i++;
						$Cont2++;
						$pos = $pos + 9;				
						echo "<tr>"; 
						echo'<input name="a['.$i.']" type="hidden" size="8">';
					
						echo "<td width='10%' align='left' onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>".$Fil["fecha"];
						echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:250px'>\n";
						echo "<font face='courier' color='#000000' size=1><b>Fecha Traspaso:&nbsp;</b>".$Fil["fecha"]."</font><br>";
						echo "<font face='courier' color='#000000' size=1><b>Fecha Realizado:&nbsp;</b>".$Fil[hora]."</font><br>";
						echo "</div></td>";			
						
						//echo "<td width='10%' align='left'>".$Fil["fecha"]."</td>";				
						echo'<input name="fecha['.$i.']" type="hidden" size="10" value="'.$Fil["fecha"].'">';					
						$Consulta = "SELECT abreviatura FROM proyecto_modernizacion.subproducto"; 
						$Consulta.= " WHERE cod_producto = ".$Fila["cod_producto"];
						$Consulta.= " AND cod_subproducto = ".$Fila[cod_subproducto];
						$rs = mysql_query($Consulta);
						$fila = mysql_fetch_array($rs);
						 
						echo"<td width='15%' align='left' bgcolor='#cccccc'>".$fila["abreviatura"]."</td>";				
						echo'<input name="cod_producto['.$i.']" type="hidden" size="2" value="'.$Fila["cod_producto"].'">';
						echo'<input name="cod_subproducto['.$i.']" type="hidden" size="2" value="'.$Fila[cod_subproducto].'">';
	
						echo "<td width='5%' align='center'>".$Fila[campo2]."&nbsp;</td>";
						echo '<input type="hidden" name="grupo['.$i.']" value="'.$Fila[campo2].'" size="10">';
						echo '<input type="hidden" name="hornada_sea['.$i.']" value="'.$Fil["hornada"].'" size="20">';
	
						$Consulta = "SELECT valor, cod_leyes FROM sea_web.leyes_por_hornada ";
						$Consulta.= " WHERE cod_producto = '".$Fila["cod_producto"]."'";
						$Consulta.= " AND cod_subproducto = '".$Fila[cod_subproducto]."'";
						$Consulta.= " AND hornada = '".$Fil["hornada"]."'";
						$Consulta.= " AND (cod_leyes = '08' or cod_leyes ='09' or cod_leyes = '31') ";
//echo "xxxxxxx88".$Consulta."<br>";
						$resp = mysql_query($Consulta);
						$As = '';
						$Sb = '';
						$Fe = '';
						while($fila1 = mysql_fetch_array($resp))
						{
							if($fila1["cod_leyes"] == '08')
								$As = $fila1["valor"];
							if($fila1["cod_leyes"] == '09')
								$Sb = $fila1["valor"];
	
							if($fila1["cod_leyes"] == '31')
								$Fe = $fila1["valor"];
						}
						echo "<td width='8%' align='center'>".number_format($As,0,'','')."&nbsp;</td>";	
						echo "<td width='8%' align='center'>".number_format($Sb,0,'','')."&nbsp;</td>";
						echo "<td width='8%' align='center'>".number_format($Fe,0,'','')."&nbsp;</td>";
	
						echo "<td width='9%' align='right'>".$dif_unid."&nbsp;</td>";
						echo'<input name="unid['.$i.']" type="hidden" size="8" value="'.$row[unid].'">';
	
						echo "<td width='9%' align='right'>".$dif_peso."&nbsp;</td>";
						echo'<input name="pes['.$i.']" type="hidden" size="8" value="'.$row["peso"].'">';
						echo "<td width='12%' align='center'><input type='text' name='unidades[".$i."]' size='10' value='".$row9[unid]."' onBlur='calcula1(this.form,".($pos).")'></td>";
						echo "<td width='12%' align='center'><input type='text' name='peso[".$i."]' size='10' value='".$row9["peso"]."' style='background:#FFFFCC' onBlur='calcula2(this.form,".($pos + 1).")'></td>";						
						echo "<td width='10%' align='center'><input type='text' name='porcent[".$i."]' value='".$porcent."' size='3' onBlur='calcula3(this.form,".($pos + 2).")'>%</td>";
						//guarda el valor anterior
						echo"<input name='ActualUnid[".$i."]' type='hidden' size='10' value='".$row9[unid]."'>";
						echo"<input name='ActualPeso[".$i."]' type='hidden' size='10' value='".$row9["peso"]."'>";
	
						echo "</tr>";
						
						//Acummuladores 
						$AcumUnid = $AcumUnid + $dif_unid;
						$AcumPeso = $AcumPeso + $dif_peso;
						$pos = $pos + 4;	
					}				
				}
				echo "</table>";
				echo "</div>";				

				if($AcumPeso != '' AND $AcumPeso != 0)
					$TotalPorcent = ($TotalPeso * 100)/$AcumPeso;

		}
								
				echo'<input name="tope" type="hidden" size="10" value="'.$i.'">';
				echo'<input name="ActualUnid" type="hidden" size="10" value="$TotalUnid">';
				echo'<input name="ActualPeso" type="hidden" size="10" value="$TotalPeso">';
		?>
        <br>
		<div style='position:absolute; left: 10px; top: 330px; width: 750px; height: 115px; OVERFLOW: auto;' id='div2'> 
        <table width="740" border='1' cellpadding='0' cellspacing='0' class="TablaInterior">
          <tr> 
            <td width="53%"><strong>Circulante Raf </strong></td> 
			<td width="9%" align="right">&nbsp;</td>
			<td width="9%" align="right">&nbsp;</td>
			<td width="12%" align="center"><input type="text" name="CircRafUnid" value="<? echo $CircRafUnid ?>" size="10" readonly></td>
			<td width="12%" align="center"><input type="text" name="CircRafPeso" value="<? echo $CircRafPeso ?>" size="10" style="background:#FFFFCC" readonly></td>
			<td width="10%" align="center">&nbsp;</td>
		  </tr>	
          <tr>
            <td><strong>Circulante Ref. Electrolitica </strong></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center"><input type="text" name="CircRefUnid" value="<? echo $CircRefUnid ?>" size="10" readonly></td>
            <td align="center"><input type="text" name="CircRefPeso" value="<? echo $CircRefPeso ?>" size="10" readonly></td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td><strong>Circulante Plamen </strong></td>
            <td align="right">&nbsp;</td>
            <td align="right">&nbsp;</td>
            <td align="center"><input type="text" name="CircPmnUnid" value="<? echo $CircPmnUnid ?>" size="10" readonly></td>
            <td align="center"><input type="text" name="CircPmnPeso" value="<? echo $CircPmnPeso ?>" size="10" readonly></td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr> 
            <td width="53%"><strong>Blister Liquido</strong></td> 
			<td width="9%" align="right">&nbsp;</td>
			<td width="9%" align="right">&nbsp;</td>
			<td width="12%" align="center"><input type="text" name="BlisterUnid" value="<? echo $BlisterUnid ?>" size="10" readonly></td>
			<td width="12%" align="center"><input type="text" name="BlisterPeso" value="<? echo $BlisterPeso ?>" size="10" style="background:#FFFFCC" readonly></td>
			<td width="10%" align="center">&nbsp;</td>
		  </tr>	
          <tr> 
            <td width="53%"><strong>Totales</strong></td> 
			<td width="9%" align="right"><? echo $AcumUnid?>&nbsp;</td>
			<td width="9%" align="right"><? echo $AcumPeso?>&nbsp;<input type="hidden" name="AcumPeso" size="10" value="<? echo $AcumPeso ?>" ></td>
			<input type="hidden" name="TotalUnidAnt" size="10" value="<? echo $TotalUnid;?>" style="background:#00CCFF" >
			<td width="12%" align="center"><input type="text" name="TotalUnid" size="10" value="<? echo $TotalUnid;?>" style="background:#00CCFF" readonly></td>
			<input type="hidden" name="TotalPesoAnt" size="10" value="<? echo $TotalPeso;?>" style="background:#00CCFF">
			<td width="12%" align="center"><input type="text" name="TotalPeso" size="10" value="<? echo $TotalPeso;?>" style="background:#00CCFF" readonly></td>
			  <td width="10%" align="center">&nbsp;</td>
		  </tr> 	
        </table>
		<input type="hidden" name="BlistCps" value="<? echo $BlistCps;?>" size="10">
		<input type="hidden" name="Peso_BlistCps" value="<? echo $Peso_BlistCps;?>" size="10">

		<input type="hidden" name="BlistBasc" value="<? echo $BlistBasc;?>" size="10">
		<input type="hidden" name="Peso_BlistBasc" value="<? echo $Peso_BlistBasc;?>" size="10">

		<input type="hidden" name="BlistReten" value="<? echo $BlistReten;?>" size="10">
		<input type="hidden" name="Peso_BlistReten" value="<? echo $Peso_BlistReten;?>" size="10">

		<input type="hidden" name="Tallarines" value="<? echo $Tallarines;?>" size="10">
		<input type="hidden" name="Peso_Tallarines" value="<? echo $Peso_Tallarines;?>" size="10">

		<input type="hidden" name="Rebalses" value="<? echo $Rebalses;?>" size="10">
		<input type="hidden" name="Peso_Rebalses" value="<? echo $Peso_Rebalses;?>" size="10">

		<input type="hidden" name="Queques" value="<? echo $Queques;?>" size="10">
		<input type="hidden" name="Peso_Queques" value="<? echo $Peso_Queques;?>" size="10">

		<input type="hidden" name="Maceteros" value="<? echo $Maceteros;?>" size="10">
		<input type="hidden" name="Peso_Maceteros" value="<? echo $Peso_Maceteros;?>" size="10">

		<input type="hidden" name="BoteOxid" value="<? echo $BoteOxid;?>" size="10">
		<input type="hidden" name="Peso_BoteOxid" value="<? echo $Peso_BoteOxid;?>" size="10">

		<input type="hidden" name="Chatarra" value="<? echo $Chatarra;?>" size="10">
		<input type="hidden" name="Peso_Chatarra" value="<? echo $Peso_Chatarra;?>" size="10">

		<input type="hidden" name="CuRecup" value="<? echo $CuRecup;?>" size="10">
		<input type="hidden" name="Peso_CuRecup" value="<? echo $Peso_CuRecup;?>" size="10">

		<input type="hidden" name="BoteAlb" value="<? echo $BoteAlb;?>" size="10">
		<input type="hidden" name="Peso_BoteAlb" value="<? echo $Peso_BoteAlb;?>" size="10">

		<input type="hidden" name="Moldes" value="<? echo $Moldes;?>" size="10">
		<input type="hidden" name="Peso_Moldes" value="<? echo $Peso_Moldes;?>" size="10">

		<input type="hidden" name="AnodCirc" value="<? echo $AnodCirc;?>" size="10">
		<input type="hidden" name="Peso_AnodCirc" value="<? echo $Peso_AnodCirc;?>" size="10">

		<input type="hidden" name="Placas" value="<? echo $Placas;?>" size="10">
		<input type="hidden" name="Peso_Placas" value="<? echo $Peso_Placas;?>" size="10">

		<input type="hidden" name="CuPiso" value="<? echo $CuPiso;?>" size="10">
		<input type="hidden" name="Peso_CuPiso" value="<? echo $Peso_CuPiso;?>" size="10">

		<input type="hidden" name="BarroAnod" value="<? echo $BarroAnod;?>" size="10">
		<input type="hidden" name="Peso_BarroAnod" value="<? echo $Peso_BarroAnod;?>" size="10">

		<input type="hidden" name="BarridoCu" value="<? echo $BarridoCu;?>" size="10">
		<input type="hidden" name="Peso_BarridoCu" value="<? echo $Peso_BarridoCu;?>" size="10">

		<input type="hidden" name="GranaCu" value="<? echo $GranaCu;?>" size="10">
		<input type="hidden" name="Peso_GranaCu" value="<? echo $Peso_GranaCu;?>" size="10">

		<input type="hidden" name="EscFus" value="<? echo $EscFus;?>" size="10">
		<input type="hidden" name="Peso_EscFus" value="<? echo $Peso_EscFus;?>" size="10">

		<input type="hidden" name="EscOxid" value="<? echo $EscOxid;?>" size="10">
		<input type="hidden" name="Peso_EscOxid" value="<? echo $Peso_EscOxid;?>" size="10">

		<input type="hidden" name="LadrTrof" value="<? echo $LadrTrof;?>" size="10">
		<input type="hidden" name="Peso_LadrTrof" value="<? echo $Peso_LadrTrof;?>" size="10">
		</div>

		<div style='position:absolute; left: 10px; top: 445px; width: 750px; height: 100px; OVERFLOW: auto;' id='div2'> 
        <table width="750" border="0" class="tablainterior">
          <tr> 
              <td align="center"> 
                <input type="button" name="BtnCirculantesRaf" value="Circul. Raf" style="width:95px" onClick="MostrarPopupProceso('C');">
                <input type="button" name="BtnCirculantesRef" value="Circul. Ref Elec." style="width:95px" onClick="MostrarPopupProceso('C2');">
                <input type="button" name="BtnCirculantesPmn" value="Circul. Pmn" style="width:95px" onClick="MostrarPopupProceso('C3');">
                <input type="button" name="BtnBlister" value="Blist. Liqui." style="width:95px" onClick="MostrarPopupProceso('P');"> 
			  </td>
		  </tr>	  	
          <tr> 
              <td align="center"> 
			  <?
                if($Proceso != "H")
				{
			  ?>	
			  <input type="button" name="BtnCrear" value="Graba Hornada" style="width:95px" onClick="MostrarPopupProceso('G');"> 
			  <?	
				}
                if($Proceso == "H")
				{
			  ?>
			  <input type="button" name="BtnModificar" value="Modif Hornada" style="width:95" onClick="MostrarPopupProceso('M');">
              <input type="button" name="BtnEliminar" value="Eliminar" style="width:95px" onClick="MostrarPopupProceso('E');">
                <? }?>
              <input type="button" name="BtnImprimir" value="Imprimir" style="width:95px" onClick="MostrarPopupProceso('I');"> 
              <input type="button" name="BtnSalir" value="Salir" style="width:95px" onClick="Salir();"></td>
          </tr>
        </table>
		</div>
        <br>
      </td>
    </tr>
  </table>
  <?
  $Eliminar = "DROP TABLE IF EXIST raf_web.tmp_table";
  mysql_query($Eliminar);
  include("../principal/pie_pagina.php")
  ?>
</form>
</body>
</html>
