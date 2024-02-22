<?php
include("../principal/conectar_pmn_web.php");
$Ano='2012';

for($i=1;$i<=12;$i++)
{
	BarroAnodico('25','1',$Ano,$i);//BAD VENTANAS
	//Calcina('36','1',$Ano,$i);
	//Anodos('44','1',$Ano,$i);//PRODUCCION: HORNO TROF, BENEFICIO:
	//DescargaElectrosilis('19','17',$Ano,$i);//PRODUCCION: HORNO TROF, BENEFICIO:
}	
OxidoPlataCobre($Ano);//PRODUCCION: oxido plata, BENEFICIO: carga horno trof
	
function OxidoPlataCobre($Ano)
{
	$Consulta="select cod_producto,cod_subproducto from pmn_web.produccion_circulantes_oxidos where year(fecha)='".$Ano."' group by cod_producto,cod_subproducto";
	$RespP=mysqli_query($link, $Consulta);
	while($FilasPrin=mysqli_fetch_assoc($RespP))
	{
		$Prod=$FilasPrin["cod_producto"];
		$SubProd=$FilasPrin["cod_subproducto"];
		for($i=1;$i<=12;$i++)
		{
			$Consulta="select sum(valor) as Produccion from pmn_web.produccion_circulantes_oxidos where year(fecha)='".$Ano."' and month(fecha)='".$i."' and cod_producto='".$FilasPrin["cod_producto"]."' and cod_subproducto='".$FilasPrin["cod_subproducto"]."'";
			$Resp=mysqli_query($link, $Consulta);
			if($Filas=mysqli_fetch_assoc($Resp))
			{
				$Produccion=$Filas[Produccion];
			}	
			$Consulta2="select sum(cantidad) as Beneficio from pmn_web.carga_horno_trof where year(fecha)='".$Ano."' and month(fecha)='".$i."' and cod_producto='".$FilasPrin["cod_producto"]."' and cod_subproducto='".$FilasPrin["cod_subproducto"]."'";
			$Resp2=mysqli_query($link, $Consulta2);
			if($Filas2=mysqli_fetch_assoc($Resp2))
			{
				$Beneficio=$Filas2[Beneficio];
			}	
			if($Produccion=='')
				$Produccion=0;
			if($Beneficio=='')
				$Beneficio=0;
			MantenedorInicialExistencia($Ano,$i,$Prod,$SubProd,$Produccion,$Beneficio,0,0);
		}
	}
}
function DescargaElectrosilis($Prod,$SubProd,$Ano,$Mes)
{
	$Consulta="select sum(peso_resto) as Produccion,sum(cant_orejas)as produccionC from pmn_web.descarga_electrolisis_plata where year(fecha)='".$Ano."' and month(fecha)='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Filas=mysqli_fetch_assoc($Resp))
	{
		$Produccion=$Filas[Produccion];
	}	
	$Consulta="select sum(cantidad) as Beneficio from pmn_web.carga_horno_trof where year(fecha)='".$Ano."' and month(fecha)='".$Mes."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Filas=mysqli_fetch_assoc($Resp))
	{
		$Beneficio=$Filas[Beneficio];
	}	
	if($Produccion=='')
		$Produccion=0;
	if($Beneficio=='')
		$Beneficio=0;
	MantenedorInicialExistencia($Ano,$Mes,$Prod,$SubProd,$Produccion,$Beneficio,0,0);
}
function Anodos($Prod,$SubProd,$Ano,$Mes)
{
	$Consulta="select sum(peso) as Produccion,sum(num_anodos)as produccionC from pmn_web.produccion_horno_trof where year(fecha)='".$Ano."' and month(fecha)='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Filas=mysqli_fetch_assoc($Resp))
	{
		$Produccion=$Filas[Produccion];
		$ProduccionC=$Filas[produccionC];
	}	
	$Consulta="select sum(peso_anodos) as Beneficio,sum(cant_anodos) as BeneficioC from pmn_web.carga_electrolisis_plata where year(fecha)='".$Ano."' and month(fecha)='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Filas=mysqli_fetch_assoc($Resp))
	{
		$Beneficio=$Filas[Beneficio];
		$BeneficioC=$Filas[BeneficioC];
	}	
	if($Produccion=='')
		$Produccion=0;
	if($Beneficio=='')
		$Beneficio=0;
	if($ProduccionC=='')
		$ProduccionC=0;
	if($BeneficioC=='')
		$BeneficioC=0;
	MantenedorInicialExistencia($Ano,$Mes,$Prod,$SubProd,$Produccion,$Beneficio,$ProduccionC,$BeneficioC);
}
function Calcina($Prod,$SubProd,$Ano,$Mes)
{
	$Consulta="select sum(prod_calcina) as Produccion from pmn_web.deselenizacion where year(fecha)='".$Ano."' and month(fecha)='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Filas=mysqli_fetch_assoc($Resp))
		$Produccion=$Filas[Produccion];
		
	$Consulta="select sum(cantidad) as Beneficio from pmn_web.carga_horno_trof where year(fecha)='".$Ano."' and month(fecha)='".$Mes."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Filas=mysqli_fetch_assoc($Resp))
		$Beneficio=$Filas[Beneficio];

	if($Produccion=='')
		$Produccion=0;
	if($Beneficio=='')
		$Beneficio=0;
	MantenedorInicialExistencia($Ano,$Mes,$Prod,$SubProd,$Produccion,$Beneficio,0,0);
}
function BarroAnodico($Prod,$SubProd,$Ano,$Mes)
{
	$Consulta="select sum(bad) as Produccion from pmn_web.lixiviacion_barro_anodico where year(fecha)='".$Ano."' and month(fecha)='".$Mes."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Filas=mysqli_fetch_assoc($Resp))
		$ProduccionBAD=$Filas[Produccion];
		
	$Consulta="select sum(C.bad) as Beneficio from pmn_web.lixiviacion_barro_anodico L";
	$Consulta.=" inner join pmn_web.detalle_deselenizacion C on L.num_lixiviacion=C.referencia";
	$Consulta.=" where year(L.fecha)='".$Ano."' and month(L.fecha)='".$Mes."' ";
	$Resp=mysqli_query($link, $Consulta);
	if($Filas=mysqli_fetch_assoc($Resp))
		$BeneficioBAD=$Filas[Beneficio];
		
	if($ProduccionBAD=='')
		$ProduccionBAD=0;
	if($BeneficioBAD=='')
		$BeneficioBAD=0;
	MantenedorInicialExistencia($Ano,$Mes,$Prod,$SubProd,$ProduccionBAD,$BeneficioBAD,0,0);
}

function MantenedorInicialExistencia($Ano,$Mes,$Prod,$SubProd,$ValorProd,$ValorBene,$ValorCant,$ValorBeneCant)
{
	//Stock final del mes anterior
	$AnoMesAtras=explode('-',date('Y-m',mktime(0,0,0,$Mes-1,1,$Ano)));
	$Consulta="select sf_p,sf_c from pmn_web.stock_pmn where ano='".$AnoMesAtras[0]."' and mes='".$AnoMesAtras[1]."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_assoc($Resp))
	{
		$StockInicialP=$Fila[sf_p];
		$StockInicialC=$Fila[sf_c];
	}	
	if($StockInicialP=='')
		$StockInicialP=0;
	if($StockInicialC=='')
		$StockInicialC=0;
	$StockFinalP=$StockInicialP+$ValorProd-$ValorBene;
	$StockFinalC=$StockInicialC+$ValorCant-$ValorBeneCant;

	if($ValorProd==0 && $ValorBene==0)
	{
		$StockInicialP=0;$StockFinalP=0;
	}
	if($ValorCant==0 && $ValorBeneCant==0)
	{
		$StockInicialC=0;$StockFinalC=0;
	}
	$Consulta="select * from pmn_web.stock_pmn where ano='".$Ano."' and mes='".$Mes."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
	$Resp=mysqli_query($link, $Consulta);
	if(!$Fila=mysqli_fetch_assoc($Resp))
	{
			
		$Inserta="INSERT INTO pmn_web.stock_pmn (ano,mes,cod_producto,cod_subproducto,si_p,pr_p,bn_p,sf_p,si_c,pr_c,bn_c,sf_c)";
		$Inserta.=" values('".$Ano."','".$Mes."','".$Prod."','".$SubProd."','".$StockInicialP."','".$ValorProd."','".$ValorBene."','".$StockFinalP."','".$StockInicialC."','".$ValorCant."','".$ValorBeneCant."','".$StockFinalC."')";
		mysqli_query($link, $Inserta);
	}
	else
	{
		$Actualiza="UPDATE pmn_web.stock_pmn set si_p='".$StockInicialP."',pr_p='".$ValorProd."',bn_p='".$ValorBene."',sf_p='".$StockFinalP."',si_c='".$StockInicialC."',pr_c='".$ValorCant."',bn_c='".$ValorBeneCant."',sf_c='".$StockFinalC."'";
		$Actualiza.=" where ano='".$Ano."' and mes='".$Mes."' and cod_producto='".$Prod."' and cod_subproducto='".$SubProd."'";
		//echo $Actualiza."<br>";
		mysqli_query($link, $Actualiza);
	}
}
echo "----------PROCESO TERMINADO-----------";
?>