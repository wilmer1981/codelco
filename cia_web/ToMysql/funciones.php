<?php
function FixCodigo($codigo)
{
	$tipo=substr($codigo,0,3);
	$num=substr($codigo,3,(strlen($codigo)-3));
	$tipo=strtoupper($tipo);
	if(strlen($num)<5)
	{
		for($i=0;$i<(5-strlen($num));$i++)
			$num="0".$num;
	}
	if(strlen($num)>5)
		$num=substr($num,(strlen($num)-5),5);
	$codigo=$tipo.$num;
	return $codigo;
}

function FixRut($rut)
{
	if($rut!="")
	{
		$var=explode("-",$rut);
		$part1=$var[0];
		$verificador=strtoupper($var[1]);
		if(strlen($part1)<8)
		{
			for($i=0;$i<(8 - strlen($part1));$i++)
				$part1="0".$part1;
		}
		if(strlen($part1)>8)
			$part1=substr($part1,(strlen($part1) - 8),8);
		$rut=$part1."-".$verificador;
	}
	return $rut;
}

//requiere tener una conexion abierta con la base de datos
function CheckDataHardware($codigo,$conexion)
{
	$query="select codigo from hardware_access where codigo='".$codigo."';";
	if($res_tmp=mysql_db_query("cia_web_access",$query))
		return mysql_num_rows($res_tmp);
	else
		return 0;
}

function CheckDataProveedor($rut,$razon_social,$conexion)
{
	$query="select rut from proveedor_access where rut='".$rut."' and razon_social='".$rut."';";
	if($res_tmp=mysql_db_query("cia_web_access",$query,$conexion))
		return mysql_num_rows($res_tmp);
	else
		return 0;
}

function CheckProveedor($rut,$conexion)
{
	$query="select razon_social from proveedor where rut='".$rut."';";
	$res_tmp=mysql_db_query("cia_web_access",$query,$conexion);
	if(mysql_num_rows($res_tmp)==0)
		return false;
	else
		return true;
	mysql_free_result($res_tmp);
}

function CheckSoftware($cod_sw,$conexion)
{
	$query="select codigo from software_access where cod_antiguo='".$cod_sw."';";
	$res_tmp=mysql_db_query("cia_web_access",$query,$conexion);
	if(mysql_num_rows($res_tmp)==0)
		return 'NONE';
	else
	{
		$r=mysql_fetch_array($res_tmp);
		return $r["codigo"];
	}
	mysql_free_result($res_tmp);
}

function CheckComputador($cod_equipo,$conexion)
{
	$query="select marca from hardware where codigo='".$cod_equipo."';";
	$res_tmp=mysql_db_query("cia_web_access",$query,$conexion);
	if(!mysql_num_rows($res_tmp))
		return false;
	else
		return true;
	mysql_free_result($res_tmp);
}

function CheckUser($rut,$conexion)
{
	$query="select * from funcionarios where rut='".$rut."';";
	$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$conexion);
	if(mysql_num_rows($res_tmp)==0)
		return false;
	else
		return true;
	mysql_free_result($res_tmp);
}

function CheckUbi($cc,$conexion)
{
	$query="select centro_costo from centro_costo where centro_costo='".$cc."';";
	$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$conexion);
	if(mysql_num_rows($res_tmp)==0)
		return false;
	else
		return true;
	mysql_free_result($res_tmp);
}

function CheckTipo($codigo,$link)
{
	$tipo=substr($codigo,0,3);
	$query="select valor_subclase3 from sub_clase where cod_clase=18003 ";
	$query.="and valor_subclase1='".$tipo."';";
	$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
	$r=mysql_fetch_array($res_tmp);
	if($r["valor_subclase3"]=="")
		return 'NONE';
	mysql_free_result($res_tmp);
	return $r["valor_subclase3"];
}

function MakeEstadoEquipo($cc,$ubi,$rut_user)
{
	if($cc=='9999' || $ubi=='9999')
		return 2;	//para baja
	if($cc=='9998' || $ubi=='9998')
		return 3;	//de baja
	if($cc=='9997' || $ubi=='9997')
		return 5;	//Cabildo
	if(($cc=='0' && strlen($ubi)<4) || strlen($rut_user)<10 )
		return 4;	//disponible
	return 1;	//asignado
}

function MakeEstadoParte($ubi,$cc)
{
	$cant=strlen($ubi);
	if($cc=='9999' || $ubi=='9999')
		return 2;	//para baja
	if($cc=='9998' || $ubi=='9998')
		return 3;	//de baja
	if($cc=='9997' || $ubi=='9997')
		return 5;	//Cabildo
	if($cant==8)
		return 1;	//asignado
	return 4;	//disponible
}

function MakeCodigo($tipo,$link)
{
	//se obtiene la cantidad actual de ese tipo de equipos
	$query="select count(codigo) as cant from";
	if($tipo=="SWF")
		$query.=" software";
	else
		$query.=" hardware";
	$query.=" where codigo like '".$tipo."%';";
	$result=mysql_db_query("cia_web_access",$query,$link);
	$resp=mysql_fetch_array($result);
	//se construye el string con el nuevo codigo
	$codigo=$tipo;
	$new_number=$resp["cant"]+1;
	$var=5-strlen($new_number);
	for($i=0;$i<$var;$i++)
		$codigo.="0";
	$codigo.=$new_number;
	return $codigo;
}
?>