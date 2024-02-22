<?
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	

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
<title>Reporte Ingresos Proyectados</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<form name="frmPrincipal" action="" method="post">
  <?
		  switch($CmbProductos)
		  {
		  	case "1":
				include('pcip_rpt_ingresos_proyectados_cucuns.php');
			break;
		  	case "2":
				include('pcip_rpt_ingresos_proyectados_anodos.php');
			break;
		  	case "3":
				include('pcip_rpt_ingresos_proyectados_scrap.php');
			break;
			
		  }
		  ?>
</form>
</body>
</html>
<?
function DatosProyectados($Prv,$Area,$Ano,$Mes,$Prod,$Tipo)
{
	$Datos1=0;$Datos2=0;
	$Consulta1 =" select valor_real as ValorReal,valor_presupuestado as ValorPresupuestado from pcip_inp_tratam ";
	$Consulta1.=" where nom_area='".$Area."' and nom_division='".$Prv."' and cod_producto='".$Prod."' and ano='".$Ano."' and mes='".$Mes."'";
	//echo $Consulta1."<br>";
	$RespAux=mysql_query($Consulta1);
	if($FilaAux=mysql_fetch_array($RespAux))
	{
		$Datos1=$FilaAux[ValorReal];
		//echo "Valor datos consyulta 1   ".$Datos1."&nbsp;";
		$Datos2=$FilaAux[ValorPresupuestado];
		//echo "Valor datos consyulta 2   ".$Datos2."<br>";
	}
	if($Tipo=='R')	
		return($Datos1);
	if($Tipo=='P')	    
		return($Datos2);	
}
function DatosPrecios($AnoAux,$MesAux,$Prod,$Tipo)
{
	$Valor=0;
	$Consulta2 =" select valor from pcip_inp_precios ";
	$Consulta2.=" where cod_producto='".$Prod."' and ano='".$AnoAux."' and mes='".$MesAux."' and cod_deduccion='".$Tipo."'";
	//echo $Consulta2."<br>";
	$RespAux1=mysql_query($Consulta2);
	if($FilaAux1=mysql_fetch_array($RespAux1))
	{
		$Valor=$FilaAux1[valor];
		//echo $Valor;
	}
	return($Valor);
}
?>
