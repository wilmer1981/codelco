<?php
$CodigoDeSistema=15;
$CodigoDePantalla=5;
set_time_limit(1000); 
include("../principal/conectar_principal.php");
include("../age_web/age_funciones.php");

$Buscar         = isset($_REQUEST['Buscar']) ? $_REQUEST['Buscar'] : '';
$CmbSubProducto = isset($_REQUEST['CmbSubProducto']) ? $_REQUEST['CmbSubProducto'] : '';
$CmbContrato    = isset($_REQUEST['CmbContrato']) ? $_REQUEST['CmbContrato'] : '';
$CmbProveedor   = isset($_REQUEST['CmbProveedor']) ? $_REQUEST['CmbProveedor'] : '';
$Ano            = isset($_REQUEST['Ano']) ? $_REQUEST['Ano'] : date("Y");
$ChkTipoProg    = isset($_REQUEST['ChkTipoProg']) ? $_REQUEST['ChkTipoProg'] : '00';

$TipoProg       = isset($_REQUEST['TipoProg']) ? $_REQUEST['TipoProg'] : '';

if($Buscar=='S')
{
	$ArregloRecep=array();
	for ($Cont=1;$Cont<=3;$Cont++)
	{
		switch ($Cont)
		{
			case 1:
				$Grupo="P";
				break;
			case 2:
				$Grupo="V";
				break;
			case 3:
				$Grupo="";
				break;
		}		
		if ($Grupo!="")
		{
			$Consulta = "select * ";
			$Consulta.= " from age_web.programa_recepcion t1 ";
			$Consulta.= " left join rec_web.proved t2 on t1.rut_proveedor = t2.rutprv_a ";
			$Consulta.= " left join age_web.relaciones t3 on t1.rut_proveedor = t3.rut_proveedor ";
			$Consulta.= " and t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
			$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."' ";
			$Consulta.= " and t1.ano='".$Ano."' and t1.cod_contrato='".$CmbContrato."'";// ";
			$Consulta.= " and t1.tipo_programa='".$ChkTipoProg."'";
			if($CmbProveedor!='S')
				$Consulta.="and t1.rut_proveedor='".$CmbProveedor."'";
			$Consulta.="and t3.grupo='".$Grupo."'";
		}
		else
		{			
			$Consulta = "select * ";
			$Consulta.= " from rec_web.proved t2  ";
			$Consulta.= " left join age_web.relaciones t3 on t2.rutprv_a = t3.rut_proveedor ";
			$Consulta.= " where t3.cod_producto='1' and t3.cod_subproducto='".$CmbSubProducto."' ";
			if($CmbProveedor!='S')
				$Consulta.="and t3.rut_proveedor='".$CmbProveedor."'";
			$Consulta.="and (t3.grupo='' or isnull(t3.grupo))";
		}
		//echo $Consulta."<br>";
		$ContVueltas=1;
		$Resp = mysqli_query($link, $Consulta);
		$TotPSecoProg=0;
		while($Fila=mysqli_fetch_array($Resp))
		{
			$rut_proveedor = isset($Fila['rut_proveedor'])?$Fila['rut_proveedor']:"";
			switch ($Fila["grupo"])
			{
				case "P":
					$Clave1=$rut_proveedor."P";//PROGRAMADO
					$Clave2=$rut_proveedor."R";//REAL
					$Clave3=$rut_proveedor."D";//DIFERENCIA
					break;
				case "V":
					$Clave1="99999999-9"."P";//PROGRAMADO
					$Clave2="99999999-9"."R";//REAL
					$Clave3="99999999-9"."D";//DIFERENCIA
					break;
				default:
					$Clave1="99999999-8"."P";//PROGRAMADO
					$Clave2="99999999-8"."R";//REAL
					$Clave3="99999999-8"."D";//DIFERENCIA
					break;
			}			
			//echo $Clave1."<br>";
			if ($Grupo=="P" || $Grupo=="V")
			{   $ArregloRecepClave11 = isset($ArregloRecep[$Clave1][1])?$ArregloRecep[$Clave1][1]:0;
				$ArregloRecepClave12 = isset($ArregloRecep[$Clave1][2])?$ArregloRecep[$Clave1][2]:0;
				$ArregloRecepClave13 = isset($ArregloRecep[$Clave1][3])?$ArregloRecep[$Clave1][3]:0;
				$ArregloRecepClave14 = isset($ArregloRecep[$Clave1][4])?$ArregloRecep[$Clave1][4]:0;
				$ArregloRecepClave15 = isset($ArregloRecep[$Clave1][5])?$ArregloRecep[$Clave1][5]:0;
				$ArregloRecepClave16 = isset($ArregloRecep[$Clave1][6])?$ArregloRecep[$Clave1][6]:0;
				$ArregloRecepClave17 = isset($ArregloRecep[$Clave1][7])?$ArregloRecep[$Clave1][7]:0;
				$ArregloRecepClave18 = isset($ArregloRecep[$Clave1][8])?$ArregloRecep[$Clave1][8]:0;
				$ArregloRecepClave19 = isset($ArregloRecep[$Clave1][9])?$ArregloRecep[$Clave1][9]:0;
				$ArregloRecepClave110 = isset($ArregloRecep[$Clave1][10])?$ArregloRecep[$Clave1][10]:0;
				$ArregloRecepClave111 = isset($ArregloRecep[$Clave1][11])?$ArregloRecep[$Clave1][11]:0;
				$ArregloRecepClave112 = isset($ArregloRecep[$Clave1][12])?$ArregloRecep[$Clave1][12]:0;
				$ArregloRecepClave114 = isset($ArregloRecep[$Clave1][14])?$ArregloRecep[$Clave1][14]:0;
				
			    $Filaene  = isset($Fila["ene"])?$Fila["ene"]:0;
				$ArregloRecep[$Clave1][1] = $ArregloRecepClave11 + $Filaene;
				$ArregloRecep[$Clave1][2] = $ArregloRecepClave12 + $Fila["feb"];
				$ArregloRecep[$Clave1][3] = $ArregloRecepClave13 + $Fila["mar"];
				$ArregloRecep[$Clave1][4] = $ArregloRecepClave14 + $Fila["abr"];
				$ArregloRecep[$Clave1][5] = $ArregloRecepClave15 + $Fila["may"];
				$ArregloRecep[$Clave1][6] = $ArregloRecepClave16 + $Fila["jun"];
				$ArregloRecep[$Clave1][7] = $ArregloRecepClave17 + $Fila["jul"];
				$ArregloRecep[$Clave1][8] = $ArregloRecepClave18 + $Fila["ago"];
				$ArregloRecep[$Clave1][9] = $ArregloRecepClave19 + $Fila["sep"];
				$ArregloRecep[$Clave1][10] = $ArregloRecepClave110 + $Fila["oct"];
				$ArregloRecep[$Clave1][11] = $ArregloRecepClave111 + $Fila["nov"];
				$ArregloRecep[$Clave1][12] = $ArregloRecepClave112 + $Fila["dic"];
				$TotPSecoProg= $Fila["ene"]+$Fila["feb"]+$Fila["mar"]+$Fila["abr"]+$Fila["may"]+$Fila["jun"]+$Fila["jul"]+$Fila["ago"]+$Fila["sep"]+$Fila["oct"]+$Fila["nov"]+$Fila["dic"];
				$ArregloRecep[$Clave1][14]=$ArregloRecepClave114 + $TotPSecoProg;
			}
			else
			{
				if ($ContVueltas==1)
				{
					$Consulta = "select * ";
					$Consulta.= " from age_web.programa_recepcion t1 ";
					$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."' ";
					$Consulta.= " and t1.ano='".$Ano."' and t1.cod_contrato='".$CmbContrato."'";// ";
					$Consulta.= " and t1.tipo_programa='".$ChkTipoProg."'";
					$Consulta.="and t1.rut_proveedor='99999999-9'";
					$RespAux=mysqli_query($link, $Consulta);
					if ($FilaAux = mysqli_fetch_array($RespAux))
					{	$ArregloRecepClave11 = isset($ArregloRecep[$Clave1][1])?$ArregloRecep[$Clave1][1]:0;
						$ArregloRecepClave12 = isset($ArregloRecep[$Clave1][2])?$ArregloRecep[$Clave1][2]:0;
						$ArregloRecepClave13 = isset($ArregloRecep[$Clave1][3])?$ArregloRecep[$Clave1][3]:0;
						$ArregloRecepClave14 = isset($ArregloRecep[$Clave1][4])?$ArregloRecep[$Clave1][4]:0;
						$ArregloRecepClave15 = isset($ArregloRecep[$Clave1][5])?$ArregloRecep[$Clave1][5]:0;
						$ArregloRecepClave16 = isset($ArregloRecep[$Clave1][6])?$ArregloRecep[$Clave1][6]:0;
						$ArregloRecepClave17 = isset($ArregloRecep[$Clave1][7])?$ArregloRecep[$Clave1][7]:0;
						$ArregloRecepClave18 = isset($ArregloRecep[$Clave1][8])?$ArregloRecep[$Clave1][8]:0;
						$ArregloRecepClave19 = isset($ArregloRecep[$Clave1][9])?$ArregloRecep[$Clave1][9]:0;
						$ArregloRecepClave110= isset($ArregloRecep[$Clave1][10])?$ArregloRecep[$Clave1][10]:0;
						$ArregloRecepClave111= isset($ArregloRecep[$Clave1][11])?$ArregloRecep[$Clave1][11]:0;
						$ArregloRecepClave112= isset($ArregloRecep[$Clave1][12])?$ArregloRecep[$Clave1][12]:0;
						$ArregloRecepClave114= isset($ArregloRecep[$Clave1][14])?$ArregloRecep[$Clave1][14]:0;
						$FilaAuxene  = isset($FilaAux["ene"])?$FilaAux["ene"]:0;
						$ArregloRecep[$Clave1][1] = $ArregloRecepClave11 + $FilaAuxene;
						$ArregloRecep[$Clave1][2] = $ArregloRecepClave12 + $FilaAux["feb"];
						$ArregloRecep[$Clave1][3] = $ArregloRecepClave13 + $FilaAux["mar"];
						$ArregloRecep[$Clave1][4] = $ArregloRecepClave14 + $FilaAux["abr"];
						$ArregloRecep[$Clave1][5] = $ArregloRecepClave15 + $FilaAux["may"];
						$ArregloRecep[$Clave1][6] = $ArregloRecepClave16 + $FilaAux["jun"];
						$ArregloRecep[$Clave1][7] = $ArregloRecepClave17 + $FilaAux["jul"];
						$ArregloRecep[$Clave1][8] = $ArregloRecepClave18 + $FilaAux["ago"];
						$ArregloRecep[$Clave1][9] = $ArregloRecepClave19 + $FilaAux["sep"];
						$ArregloRecep[$Clave1][10] = $ArregloRecepClave110 + $FilaAux["oct"];
						$ArregloRecep[$Clave1][11] = $ArregloRecepClave111 + $FilaAux["nov"];
						$ArregloRecep[$Clave1][12] = $ArregloRecepClave112 + $FilaAux["dic"];
						$TotPSecoProg= $FilaAux["ene"]+$FilaAux["feb"]+$FilaAux["mar"]+$FilaAux["abr"]+$FilaAux["may"]+$FilaAux["jun"]+$FilaAux["jul"]+$FilaAux["ago"]+$FilaAux["sep"]+$FilaAux["oct"]+$FilaAux["nov"]+$FilaAux["dic"];
						$ArregloRecep[$Clave1][14]=$ArregloRecepClave114 + $TotPSecoProg;
					}
				}
			}
			$ArregloRecep[$Clave1][13]="===PROGRAMADO";			
			$ArregloRecep[$Clave1][15]="";
			$ArregloRecep[$Clave1][16]="";
			$TotPSecoRecep=0;
			for($i=1;$i<=12;$i++)
			{
				$PesoSecoRecep=0;
				$FechaIni=$Ano."-".str_pad($i,2,'0',STR_PAD_LEFT)."-01";
				$FechaFin=$Ano."-".str_pad($i,2,'0',STR_PAD_LEFT)."-31";
				$Consulta = "select lote ";
				$Consulta.= " from age_web.lotes where estado_lote <>'6' and cod_producto='1' ";
				$Consulta.= " and cod_subproducto='".$CmbSubProducto."' ";
				$Consulta.= " and rut_proveedor='".$rut_proveedor."' ";
				$Consulta.= " and fecha_recepcion between '".$FechaIni."' and '".$FechaFin."'";
				$RespLote=mysqli_query($link, $Consulta);
				//echo $Consulta."<br>";
				$Petalo= 'L'; //Leyes
				while($FilaLote=mysqli_fetch_array($RespLote))
				{
					$DatosLote= array();
					$ArrLeyes=array();
					$DatosLote["lote"]=$FilaLote["lote"];
					//consultamos Leyes
					$ArrLeyes  = LeyesLote($DatosLote,$ArrLeyes,"N","N","S","","","",$Petalo,$link);
					//consultamos Lotes
					$DatosLote = LeyesLote($DatosLote,$ArrLeyes,"N","N","S","","","","",$link);
					//echo "GRUPO=".$Grupo." / TIPO PROG=".$ChkTipoProg."<br>";
					switch($ChkTipoProg)
					{
						case "00"://PESO SECO
							$PesoSecoRecep=$PesoSecoRecep+round(($DatosLote["peso_seco"]/1000),0);
							break;
						case "02"://FINO COBRE
							$PesoSecoRecep=$PesoSecoRecep+round($ArrLeyes["02"][23]/1000,0);				
							break;
						case "04"://FINO PLATA
							$PesoSecoRecep=$PesoSecoRecep+round($ArrLeyes["04"][23]/1000,0);
							break;
						case "05"://FINO ORO
							$PesoSecoRecep=$PesoSecoRecep+round($ArrLeyes["05"][23]/1000,3);
							break;
					}
				}
				$ArregloRecepClave2=isset($ArregloRecep[$Clave2][$i])?$ArregloRecep[$Clave2][$i]:0;
				$ArregloRecep[$Clave2][$i]=$ArregloRecepClave2+$PesoSecoRecep;
				//$ArregloRecep[$Clave2][$i]=$ArregloRecep[$Clave2][$i]+$PesoSecoRecep;
				$TotPSecoRecep=$TotPSecoRecep+$PesoSecoRecep;
			}
			if($TotPSecoProg!=0)
				$PorcPSecoRecep=($TotPSecoRecep*100)/$TotPSecoProg;
			else
				$PorcPSecoRecep=0;	

			$ArregloRecepClave214=isset($ArregloRecep[$Clave2][14])?$ArregloRecep[$Clave2][14]:0;
			$ArregloRecep[$Clave2][13]='===RECEPCIONADO (%) '.number_format($PorcPSecoRecep,2,',','.');
			$ArregloRecep[$Clave2][14]=$ArregloRecepClave214 + $TotPSecoRecep;
			$ArregloRecep[$Clave2][15]='';
			$ArregloRecep[$Clave2][16]='';
			$TotPSecoDif=0;
			for($i=1;$i<=12;$i++)
			{
				$ArregloRecepClave1  = isset($ArregloRecep[$Clave1][$i])?$ArregloRecep[$Clave1][$i]:0;
				$ArregloRecepClave2  = isset($ArregloRecep[$Clave2][$i])?$ArregloRecep[$Clave2][$i]:0;

				$ArregloRecep[$Clave3][$i]=$ArregloRecepClave1 - $ArregloRecepClave2;
				$TotPSecoDif  = $TotPSecoDif + $ArregloRecepClave1 - $ArregloRecepClave2;
			}
			for($i=1;$i<12;$i++)
			{
				$ArregloRecep[$Clave3][$i+1]=$ArregloRecep[$Clave3][$i]+$ArregloRecep[$Clave3][$i+1];
			}
			switch ($Fila["grupo"])
			{
				case "P":
					$ArregloRecep[$Clave3][13]=$Fila["NOMPRV_A"];
					break;
				case "V":
					$ArregloRecep[$Clave3][13]="PROV. VARIOS";
					break;
				default:
					$ArregloRecep[$Clave3][13]="OTROS PROV.";
					break;
			}			
			$ArregloRecep[$Clave3][14]=$TotPSecoDif;
			$ArregloRecep[$Clave3][15]="class='Detalle02'";
			$ArregloRecep[$Clave3][16]="style='background:#FFFFCC'";
			$ContVueltas++;
		}
		//PARA OBTENER LOS TOTALES DEL CONTRATO
		$Total_PSecoRecep=0;$TotPSecoDif=0;$Total_PSecoProg=0;
		$ArregloTotales=array();
		$Consulta="select sum(t1.ene) as ene,sum(t1.feb) as feb,sum(t1.mar) as mar,sum(t1.abr) as abr,sum(t1.may) as may,sum(t1.jun) as jun,";
		$Consulta.="sum(t1.jul) as jul,sum(t1.ago) as ago,sum(t1.sep) as sep,sum(t1.oct) as octu,sum(t1.nov) as nov,sum(t1.dic) as dic ";
		$Consulta.="from age_web.programa_recepcion t1 left join rec_web.proved t2 on t1.rut_proveedor = t2.rutprv_a ";
		$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."' ";
		$Consulta.= " and t1.ano='".$Ano."' and t1.cod_contrato='".$CmbContrato."'";
		$Consulta.= " and t1.tipo_programa='$ChkTipoProg' GROUP BY t1.cod_contrato";
		$Resp = mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Resp);
		$ene = isset($Fila["ene"])?$Fila["ene"]:0;
		$feb = isset($Fila["feb"])?$Fila["feb"]:0;
		$mar = isset($Fila["mar"])?$Fila["mar"]:0;
		$abr = isset($Fila["abr"])?$Fila["abr"]:0;
		$may = isset($Fila["may"])?$Fila["may"]:0;
		$jun = isset($Fila["jun"])?$Fila["jun"]:0;
		$jul = isset($Fila["jul"])?$Fila["jul"]:0;
		$ago = isset($Fila["ago"])?$Fila["ago"]:0;
		$sep = isset($Fila["sep"])?$Fila["sep"]:0;
		$octu = isset($Fila["oct"])?$Fila["octu"]:0;
		$nov = isset($Fila["nov"])?$Fila["nov"]:0;
		$dic = isset($Fila["dic"])?$Fila["dic"]:0;

		$ArregloTotales["TOTP"][1]=$ene;
		$ArregloTotales["TOTP"][2]=$feb;
		$ArregloTotales["TOTP"][3]=$mar;
		$ArregloTotales["TOTP"][4]=$abr;
		$ArregloTotales["TOTP"][5]=$may;
		$ArregloTotales["TOTP"][6]=$jun;
		$ArregloTotales["TOTP"][7]=$jul;
		$ArregloTotales["TOTP"][8]=$ago;
		$ArregloTotales["TOTP"][9]=$sep;
		$ArregloTotales["TOTP"][10]=$octu;
		$ArregloTotales["TOTP"][11]=$nov;
		$ArregloTotales["TOTP"][12]=$dic;
		//$Total_PSecoProg=$Fila["ene"]+$Fila["feb"]+$Fila["mar"]+$Fila["abr"]+$Fila["may"]+$Fila["jun"]+$Fila["jul"]+$Fila["ago"]+$Fila["sep"]+$Fila["octu"]+$Fila["nov"]+$Fila["dic"];

		$Total_PSecoProg = $ene + $feb + $mar + $abr + $may + $jun + $jul + $ago + $sep + $octu + $nov + $dic;
		for($i=1;$i<=12;$i++)
		{
			$PesoSecoRecep=0;
			$FechaIni=$Ano."-".str_pad($i,2,'0',STR_PAD_LEFT)."-01";
			$FechaFin=$Ano."-".str_pad($i,2,'0',STR_PAD_LEFT)."-31";
			$Consulta="select lote from age_web.programa_recepcion t1 inner join age_web.lotes t2 on ";
			$Consulta.="t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_proveedor=t2.rut_proveedor ";
			$Consulta.="where t1.ano='".$Ano."' and t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."' and t1.cod_contrato='".$CmbContrato."' ";
			$Consulta.="and fecha_recepcion between '".$FechaIni."' and '".$FechaFin."' and t1.tipo_programa='$ChkTipoProg'";
			$RespLote=mysqli_query($link, $Consulta);
			$Petalo='L';
			while($FilaLote=mysqli_fetch_array($RespLote))
			{
				$DatosLote= array();
				$ArrLeyes=array();
				$DatosLote["lote"]=$FilaLote["lote"];
				$ArrLeyes  = LeyesLote($DatosLote,$ArrLeyes,"N","N","S","","","",$Petalo,$link);
				$DatosLote = LeyesLote($DatosLote,$ArrLeyes,"N","N","S","","","","",$link);
				switch($ChkTipoProg)
				{
					case "00"://PESO SECO
						$PesoSecoRecep=$PesoSecoRecep+round(($DatosLote["peso_seco"]/1000),0);
						break;
					case "02"://FINO COBRE
						$PesoSecoRecep=$PesoSecoRecep+round($ArrLeyes["02"][23]/1000,0);				
						break;
					case "04"://FINO PLATA
						$PesoSecoRecep=$PesoSecoRecep+round($ArrLeyes["04"][23]/1000,0);
						break;
					case "05"://FINO ORO
						$PesoSecoRecep=$PesoSecoRecep+round($ArrLeyes["05"][23]/1000,3);
						break;
				}
			}
			$ArregloTotales["TOTR"][$i]=$PesoSecoRecep;
			$Total_PSecoRecep=$Total_PSecoRecep+$PesoSecoRecep;
		}
		for($i=1;$i<=12;$i++)
		{
			$ArregloTotales["TOTT"][$i]=$ArregloTotales["TOTP"][$i]-$ArregloTotales["TOTR"][$i];
			$TotPSecoDif=$TotPSecoDif+$ArregloTotales["TOTP"][$i]-$ArregloTotales["TOTR"][$i];
		}
		for($i=1;$i<12;$i++)
		{
			$ArregloTotales["TOTT"][$i+1]=$ArregloTotales["TOTT"][$i]+$ArregloTotales["TOTT"][$i+1];
		}
		if($Total_PSecoProg!=0)
			$PorcPSecoRecep=($Total_PSecoRecep*100)/$Total_PSecoProg;
		else
			$PorcPSecoRecep=0;
		$ArregloTotales["TOTP"][13]="TOT.CONTRATO PROG";
		$ArregloTotales["TOTP"][14]=$Total_PSecoProg;
		$ArregloTotales["TOTR"][13]="TOT.CONTRATO RECEP (%) ".number_format($PorcPSecoRecep,2,',','.');
		$ArregloTotales["TOTR"][14]=$Total_PSecoRecep;
		$ArregloTotales["TOTT"][13]="DIFERENCIA";
		$ArregloTotales["TOTT"][14]=$TotPSecoDif;
	}	
}	
?>	
<html>
<head>
<title>AGE-Consulta Programa v/s Real</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt,opt1)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "B":
			if (f.CmbSubProducto.value == "S")
			{
				alert("Debe Seleccionar un SubProducto");
				f.CmbSubProducto.focus();
				return;
			}
			if (f.CmbContrato.value == "S")
			{
				alert("Debe Seleccionar o Ingresar un Contrato");
				f.CmbContrato.focus();
				return;
			}
			f.action = "age_con_programa_vs_real.php?Buscar=S";
			f.submit();
			break;
		case "R":
			f.action = "age_con_programa_vs_real.php";
			f.submit();
			break;
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=15&CodPantalla=2&Nivel=1";
			f.submit();
			break;
		case "RS":
			f.ChkSelec.value=opt1.value;
			break;
		case "I":
			window.print();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body background="../principal/imagenes/fondo3.gif">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<input type="hidden" name="ChkSelec" value="">
<input type='hidden' name='TipoProg' value='<?php echo $TipoProg; ?>'>
<table width="600" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
  <tr class="Detalle02">
	<td width="97">&gt;&gt;A&ntilde;o:</td>
	<td width="237" ><select name="Ano" onChange="Proceso('R')">
	<?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (isset($Ano))
			{
				if ($Ano==$i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if (date("Y")==$i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";			
			}
		}
	?>			
	</select></td>
	<td width="158" >&nbsp;</td>
  </tr>
  <tr class="Detalle02">
	<td height="28">&gt;&gt;SubProducto:</td>
	<td height="28"><select name="CmbSubProducto" style="width:300" onChange="Proceso('R')">
	  <option class="NoSelec" value="S">SELECCIONAR</option>
	  <?php
		$Consulta = "select cod_subproducto, descripcion, ";
		$Consulta.= " case when length(cod_subproducto)<2 then concat('0',cod_subproducto) else cod_subproducto end as orden ";
		$Consulta.= " from proyecto_modernizacion.subproducto ";
		$Consulta.= " where cod_producto='1' and recepcion<>'PMN'";
		$Consulta.= " order by orden ";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($CmbSubProducto == $Fila["cod_subproducto"])
				echo "<option selected value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
			else
				echo "<option value='".$Fila["cod_subproducto"]."'>".str_pad($Fila["cod_subproducto"],2,"0",STR_PAD_LEFT)." - ".strtoupper($Fila["descripcion"])."</option>";
		}
	  ?>
	</select></td>
	<td>&nbsp;</td>
  </tr>
  <tr class="Detalle02">
	<td height="20">&gt;&gt;Contrato:</td>
	<td height="20"><select name="CmbContrato" style="width:300" onChange="Proceso('R')">
	<option class="NoSelec" value="S">SELECCIONAR</option>
	<?php
		$Consulta = "select * from age_web.contratos ";
		$Consulta.= " where cod_producto='1' and cod_subproducto='".$CmbSubProducto."'";
		$Consulta.= " order by cod_producto, cod_subproducto, cod_contrato ";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($CmbContrato==$Fila["cod_contrato"])
				echo "<option selected value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]." - ".$Fila["descripcion"]."</option>\n";
			else
				echo "<option value='".$Fila["cod_contrato"]."'>".$Fila["cod_contrato"]." - ".$Fila["descripcion"]."</option>\n";
		}
	?>			
	</select></td>
	<td>&nbsp;</td>
  </tr>
  <tr class="Detalle02">
	<td height="30">&gt;&gt;Proveedor:</td>
	<td height="30"><select name="CmbProveedor" style="width:300">
	  <option class="NoSelec" value="S">TODOS</option>
	  <?php
		$Consulta="select distinct t1.rut_proveedor, t3.nomprv_a from age_web.programa_recepcion t1 inner join age_web.relaciones t2 ";
		$Consulta.="on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto and t1.rut_proveedor=t2.rut_proveedor ";
		$Consulta.="left join rec_web.proved t3 on t2.rut_proveedor = t3.rutprv_a  ";
		$Consulta.="where t1.cod_producto='1' and t1.cod_subproducto= '".$CmbSubProducto."' and t1.cod_contrato ='".$CmbContrato."' order by t3.nomprv_a";
		$Resp = mysqli_query($link, $Consulta);
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($CmbProveedor == $Fila["rut_proveedor"])
				echo "<option selected value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
			else
				echo "<option value='".$Fila["rut_proveedor"]."'>".str_pad($Fila["rut_proveedor"],10,"0",STR_PAD_LEFT)."-".$Fila["nomprv_a"]."</option>";
		}
	?>
	</select></td>
	<td>&nbsp;</td>
  </tr>
  <tr>
	<td colspan="3" align="center"><input name="BtnBuscar" type="button" value="Buscar" onClick="Proceso('B')" style="width:100px ">
	  <input name="BtnImprimir" type="button" id="BtnEliminar" value="Imprimir" onClick="Proceso('I')" style="width:70px ">
	  <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Proceso('S')" style="width:70px "></td>
  </tr>
<?php		
$Consulta = "select * from age_web.programa_recepcion t1 left join rec_web.proved t2 on t1.rut_proveedor = t2.rutprv_a ";
$Consulta.= " where t1.cod_producto='1' and t1.cod_subproducto='".$CmbSubProducto."' ";
$Consulta.= " and t1.ano='".$Ano."' and t1.cod_contrato='".$CmbContrato."' ";
$Consulta.= " and t1.tipo_programa='00'";
$Resp = mysqli_query($link, $Consulta);
if ($Fila = mysqli_fetch_array($Resp))  	
{	
	echo "<tr valign='middle' class='Detalle01'>\n";
	echo "<td height='30'>Trabajando Con: </td>\n";
	echo "<td height='30' colspan='2'>\n";
	switch ($ChkTipoProg)
	{
		case "00":
			echo "<input checked name='ChkTipoProg' type='radio' value='00' onClick=\"Proceso('R')\">Peso (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='02' onClick=\"Proceso('R')\">Cu (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='04' onClick=\"Proceso('R')\">Ag (Kg)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='05' onClick=\"Proceso('R')\">Au (Kg)";
			break;
		case "02":
			echo "<input name='ChkTipoProg' type='radio' value='00' onClick=\"Proceso('R')\">Peso (Ton)&nbsp;&nbsp;";
			echo "<input checked name='ChkTipoProg' type='radio' value='02' onClick=\"Proceso('R')\">Cu (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='04' onClick=\"Proceso('R')\">Ag (Kg)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='05' onClick=\"Proceso('R')\">Au (Kg)";
			break;
		case "04":
			echo "<input name='ChkTipoProg' type='radio' value='00' onClick=\"Proceso('R')\">Peso (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='02' onClick=\"Proceso('R')\">Cu (Ton)&nbsp;&nbsp;";
			echo "<input checked name='ChkTipoProg' type='radio' value='04' onClick=\"Proceso('R')\">Ag (Kg)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='05' onClick=\"Proceso('R')\">Au (Kg)";
			break;
		case "05":
			echo "<input name='ChkTipoProg' type='radio' value='00' onClick=\"Proceso('R')\">Peso (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='02' onClick=\"Proceso('R')\">Cu (Ton)&nbsp;&nbsp;";
			echo "<input name='ChkTipoProg' type='radio' value='04' onClick=\"Proceso('R')\">Ag (Kg)&nbsp;&nbsp;";
			echo "<input checked name='ChkTipoProg' type='radio' value='05' onClick=\"Proceso('R')\">Au (Kg)";
			break;
	}
	echo "</td>\n";
    echo "</tr>\n";
}
?>			
</table><br>
<table width="850" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
  <tr align="center" class="ColorTabla01">
	<td width="100">Proveedor</td>
	<td >Total</td>
	<td >Ene</td>
	<td >Feb</td>
	<td >Mar</td>
	<td >Abr</td>
	<td >May</td>
	<td >Jun</td>
	<td >Jul</td>
	<td >Ago</td>
	<td >Sep</td>
	<td >Oct</td>
	<td >Nov</td>
	<td >Dic</td>
  </tr>
	<?php		
	if($Buscar=='S')
	{
		$ClaseColum1='';$ClaseColum2='';$ClaseColum3='';$ClaseColum4='';$ClaseColum5='';$ClaseColum6='';
		$ClaseColum7='';$ClaseColum8='';$ClaseColum9='';$ClaseColum10='';$ClaseColum11='';$ClaseColum12='';
		switch (intval(date('m')))
		{
			case "1":
				$ClaseColum1="class=\"Detalle03\"";
				break;
			case "2":
				$ClaseColum2="class=\"Detalle03\"";
				break;
			case "3":
				$ClaseColum3="class=\"Detalle03\"";
				break;
			case "4":
				$ClaseColum4="class=\"Detalle03\"";
				break;
			case "5":
				$ClaseColum5="class=\"Detalle03\"";
				break;
			case "6":
				$ClaseColum6="class=\"Detalle03\"";
				break;
			case "7":
				$ClaseColum7="class=\"Detalle03\"";
				break;
			case "8":
				$ClaseColum8="class=\"Detalle03\"";
				break;
			case "9":
				$ClaseColum9="class=\"Detalle03\"";
				break;
			case "10":
				$ClaseColum10="class=\"Detalle03\"";
				break;
			case "11":
				$ClaseColum11="class=\"Detalle03\"";
				break;
			case "12":
				$ClaseColum12="class=\"Detalle03\"";
				break;
		}
		//reset($ArregloRecep); //ASgregado WSO
		if(count($ArregloRecep)==0){
			echo "<td>SIN DATOS</td>"	;
		};
		foreach($ArregloRecep as $c => $v )	
		{	
			$v1=isset($v[1])?$v[1]:0; 			$v2=isset($v[2])?$v[2]:0;
			$v3=isset($v[3])?$v[3]:0; 			$v4=isset($v[4])?$v[4]:0;
			$v5=isset($v[5])?$v[5]:0; 			$v6=isset($v[6])?$v[6]:0;
			$v7=isset($v[7])?$v[7]:0; 			$v8=isset($v[8])?$v[8]:0;
			$v9=isset($v[9])?$v[9]:0; 			$v10=isset($v[10])?$v[10]:0;
			$v11=isset($v[11])?$v[11]:0; 		$v12=isset($v[12])?$v[12]:0;
			$v13=isset($v[13])?$v[13]:0; 		$v14=isset($v[14])?$v[14]:0;
			$v15=isset($v[15])?$v[15]:0; 
			echo "<tr align=\"center\" $v15>\n";
			echo "<td align=\"left\">&nbsp;".$v13."</td>";
			echo "<td align=\"right\">".$v14."</td>";
			echo "<td align=\"right\" $ClaseColum1>".$v1."</td>";
			echo "<td align=\"right\" $ClaseColum2>".$v2."</td>";
			echo "<td align=\"right\" $ClaseColum3>".$v3."</td>";
			echo "<td align=\"right\" $ClaseColum4>".$v4."</td>";
			echo "<td align=\"right\" $ClaseColum5>".$v5."</td>";
			echo "<td align=\"right\" $ClaseColum6>".$v6."</td>";
			echo "<td align=\"right\" $ClaseColum7>".$v7."</td>";
			echo "<td align=\"right\" $ClaseColum8>".$v8."</td>";
			echo "<td align=\"right\" $ClaseColum9>".$v9."</td>";
			echo "<td align=\"right\" $ClaseColum10>".$v10."</td>";
			echo "<td align=\"right\" $ClaseColum11>".$v11."</td>";
			echo "<td align=\"right\" $ClaseColum12>".$v12."</td>";
			echo "</tr>\n";
		}
		//MUESTRA LOS TOTALES DEL CONTRATO
		reset($ArregloTotales);
		foreach($ArregloTotales as $c => $v )	
		{	
			echo "<tr align=\"center\" class=\"Detalle01\">\n";
			echo "<td align=\"left\">".$v[13]."</td>";
			echo "<td align=\"right\">".$v[14]."</td>";
			echo "<td align=\"right\" $ClaseColum1>".$v[1]."</td>";
			echo "<td align=\"right\" $ClaseColum2>".$v[2]."</td>";
			echo "<td align=\"right\" $ClaseColum3>".$v[3]."</td>";
			echo "<td align=\"right\" $ClaseColum4>".$v[4]."</td>";
			echo "<td align=\"right\" $ClaseColum5>".$v[5]."</td>";
			echo "<td align=\"right\" $ClaseColum6>".$v[6]."</td>";
			echo "<td align=\"right\" $ClaseColum7>".$v[7]."</td>";
			echo "<td align=\"right\" $ClaseColum8>".$v[8]."</td>";
			echo "<td align=\"right\" $ClaseColum9>".$v[9]."</td>";
			echo "<td align=\"right\" $ClaseColum10>".$v[10]."</td>";
			echo "<td align=\"right\" $ClaseColum11>".$v[11]."</td>";
			echo "<td align=\"right\" $ClaseColum12>".$v[12]."</td>";
			echo "</tr>\n";
		}	
	}	
	?>		  
</table>
</form>
</body>
</html>