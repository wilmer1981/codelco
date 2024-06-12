<?php
include("../principal/conectar_pmn_web.php");	


function AccionBitacora($Accion)
{
	$Retorno='Sin Acción';
	switch($Accion)
	{
		case "I":
			$Retorno='Ingreso';
		break;
		case "M":
			$Retorno='Modificación';
		break;
		case "E":
			$Retorno='Eliminación';
		break;
	}
	return($Retorno);
}
function ObtengoDatosPaletAB($Lote,$PaletAB,$Null,$link)
{
	$Consulta2 = "select * from pmn_web.pmn_pesa_bad_detalle ";
	$Consulta2.= " where lote='".$Lote."'";
	if($Null=='S')
		$Consulta2.= " and correlativo_sipa is null";
	else
		$Consulta2.= " and correlativo_sipa is not null";	
	if($PaletAB=='A')
		$Consulta2.= " and recargo in ('1','2','3','4')";
	if($PaletAB=='B')
		$Consulta2.= " and recargo >=5";
	//$Consulta2.= " group by recargo";	
	$Respuesta2 = mysqli_query($link, $Consulta2);$PesoNeto='0';$CorrSI='';
	while($Row2 = mysqli_fetch_array($Respuesta2))
	{
		$PesoNeto=$PesoNeto+$Row2["pneto"];
		$CorrSI=$Row2["correlativo_sipa"];
	}	
	$Consulta2 = "select * from pmn_web.pmn_pesa_bad_detalle ";
	$Consulta2.= " where lote='".$Lote."'";
	if($Null=='S')
		$Consulta2.= " and correlativo_sipa is null";
	else
		$Consulta2.= " and correlativo_sipa is not null";	
	if($PaletAB=='A')
		$Consulta2.= " and recargo in ('1','2','3','4')";
	if($PaletAB=='B')
		$Consulta2.= " and recargo >=5";
	$Consulta2.= " group by recargo";	
	$Respuesta2 = mysqli_query($link, $Consulta2);$Tambores='0';
	while($Row2 = mysqli_fetch_array($Respuesta2))
		$Tambores=$Tambores+1;
	
	$valores=$PesoNeto."-:-".$Tambores."-:-".$CorrSI;
	return($valores);		
}
function CantidadLixPorTambor($Lote,$Recargo,$link)
{
	$Consulta2 = "select * from pmn_web.pmn_pesa_bad_detalle ";
	$Consulta2.= " where lote='".$Lote."' and recargo='".$Recargo."'";
	$Respuesta2 = mysqli_query($link, $Consulta2);$ValorLix='';$Lixiviaciones='';
	while($Row2 = mysqli_fetch_array($Respuesta2))
	{
		$Lixiviaciones=$Lixiviaciones.$Row2["num_lixiviacion"].";";
		$ValorLix=$ValorLix+$Row2["pneto"];
	}	
	$Lixiviaciones=substr($Lixiviaciones,0,strlen($Lixiviaciones)-1);
	$valores=$Lixiviaciones."-:-".$ValorLix;
	return($valores);		
}
function modificaStock($Lote,$Lixiviacion,$Recargo,$PesoNeto,$Tipo,$PesoAnterior,$link)
{
	$LEyes="select * from pmn_web.lixiviacion_barro_anodico where num_lixiviacion='".$Lixiviacion."'";	
	$RESP=mysqli_query($link, $LEyes);$Valores='';
	$Filas=mysqli_fetch_assoc($RESP);
	
	if($Tipo=='E')//SIGNIFICA QUE RESTARA AL STOCK QUE TIENE LA LIXIVIACION
	{
		$stockBad=$Filas["stock_bad"];
		$valorFinal=$stockBad+$PesoAnterior;
		$valorFinal=$valorFinal-$PesoNeto;
	}
	if($Tipo=='S')//SIGNIFICA QUE SUMAR� AL STOCK QUE TIENE LA LIXIVIACION
	{
		$stockBad=$Filas["stock_bad"];
		$valorFinal=$stockBad+$PesoNeto;
	}
	$Actualiza="UPDATE pmn_web.lixiviacion_barro_anodico set stock_bad='".$valorFinal."' where num_lixiviacion='".$Lixiviacion."'";
	mysqli_query($link, $Actualiza);
}
function NombreUnidad($Cod,$link)
{
	$Unidad="select * from proyecto_modernizacion.unidades where cod_unidad='".$Cod."'";	
	$RESPUNi=mysqli_query($link, $Unidad);
	$Valores='';
	if($FilasUni=mysqli_fetch_assoc($RESPUNi))
		$Valores=$FilasUni["abreviatura"];
	return($Valores);	
}
function ObtenerLeyes2($SA,$Ley,$link)
{
	$LEyes="select * from cal_web.leyes_por_solicitud where nro_solicitud='".$SA."' and cod_leyes='".$Ley."'";	
	$RESP=mysqli_query($link, $LEyes);
	$Valores=0;
	if($Filas=mysqli_fetch_assoc($RESP))
		$Valores=$Valores.$Filas["valor"]."~".$Filas["signo"]."~".NombreUnidad($Filas["cod_unidad"],$link);
	return($Valores);
}
function ObtenerLeyes($SA,$link)
{
	$LEyes="select * from cal_web.leyes_por_solicitud where nro_solicitud='".$SA."' order by cod_leyes";	
	$RESP=mysqli_query($link, $LEyes);$Valores='';
	while($Filas=mysqli_fetch_assoc($RESP))
	{
			$Valores=$Valores.FuncNomLey($Filas["cod_leyes"],$link).",";
	}
	return($Valores);
}
function ObtenerLeyesProy($link)
{
	$LEyes="select abreviatura,cod_leyes from proyecto_modernizacion.leyes where cod_leyes in('01','02','04','05','08','09','11','26','27','37','38','39','40','44')";	
	$RESP=mysqli_query($link, $LEyes);$Valores='';
	while($Filas=mysqli_fetch_assoc($RESP))
	{
			$Valores=$Valores.$Filas["cod_leyes"]."~".$Filas["abreviatura"]."//";
	}
	$Valores=substr($Valores,0,strlen($Valores)-2);
	return($Valores);
}
function ObtenerLeyesH20yCuAgAu($SA,$link)
{
	$LEyes="SELECT * from cal_web.leyes_por_solicitud where nro_solicitud='".$SA."' and cod_leyes in('01','02','04','05') order by cod_leyes";	
	$RESP=mysqli_query($link, $LEyes);
	$Valores='';
	while($Filas=mysqli_fetch_assoc($RESP))
	{
			$Valores=$Valores.number_format($Filas["valor"],2,',','')."//";
	}
	$Valores=substr($Valores,0,strlen($Valores)-2);
	return($Valores);
}
function ObtenerTambores($Lote,$link)
{
	$TotTamb="select count(lote) as Cant from pmn_web.pmn_pesa_bad_detalle where lote='".$Lote."'";	
	$RESP=mysqli_query($link, $TotTamb);$Valores='';
	if($Filas=mysqli_fetch_assoc($RESP))
		$Valores=$Filas["Cant"];
	return($Valores);
}
function TotalNetoLote($Lote,$link)
{
	$TotNeto="select sum(pneto) as total from pmn_web.pmn_pesa_bad_detalle where lote='".$Lote."'";	
	$RESP=mysqli_query($link, $TotNeto);$Valores='';
	if($Filas=mysqli_fetch_assoc($RESP))
		$Valores=$Filas["total"];
	return($Valores);
}
function FuncNomLey($CodLey,$link)
{
	$LEyes="select * from proyecto_modernizacion.leyes where cod_leyes='".$CodLey."'";	
	$RESP=mysqli_query($link, $LEyes);$NomLey='';
	if($Filas=mysqli_fetch_assoc($RESP))
	{
		$NomLey=$Filas["abreviatura"];
	}
	return($NomLey);
}

function Bitacora($Lote,$Recargo,$Fecha,$Lixiviacion,$PesoBruto,$PesoTara,$PesoNeto,$SInt,$SExt,$Obs,$Accion,$CorrSipa,$SA,$PesoPalet,$OtroCampo4,$link)
{
	global $CookieRut;
	$Insertar = "INSERT INTO pmn_web.pmn_bad_bitacora ";
	$Insertar.= "(accion,fecha_hora_bita,rut_realizo,lote, recargo, fecha_hora,num_lixiviacion,pbruto,ptara,pneto,sint,sext,obs,correlativo_sipa,nro_solicitud,peso_palet)";
	$Insertar.= "values('".$Accion."','".date('Y-m-d G:i:s')."','".$CookieRut."','".$Lote."'";
	if($Recargo!='')
	{	$Insertar.= ",'".$Recargo."'";}else{$Insertar.= ",null";}
	if($Fecha!='')
	{	$Insertar.= ",'".$Fecha."'";}else{$Insertar.= ",null";}
	if($Lixiviacion!='')
	{	$Insertar.= ",'".$Lixiviacion."'";}else{$Insertar.= ",null";}
	if($PesoBruto!='')
	{	$Insertar.= ",'".$PesoBruto."'";}else{$Insertar.= ",null";}
	if($PesoTara!='')
	{	$Insertar.= ",'".$PesoTara."'";}else{$Insertar.= ",null";}
	if($PesoNeto!='')
	{	$Insertar.= ",'".$PesoNeto."'";}else{$Insertar.= ",null";}
	if($SInt!='')
	{	$Insertar.= ",'".$SInt."'";}else{$Insertar.= ",null";}
	if($SExt!='')
	{	$Insertar.= ",'".$SExt."'";}else{$Insertar.= ",null";}
	if($Obs!='')
	{	$Insertar.= ",'".$Obs."'";}else{$Insertar.= ",null";}
	if($CorrSipa!='')
	{	$Insertar.= ",'".$CorrSipa."'";}else{$Insertar.= ",null";}
	if($SA!='')
	{	$Insertar.= ",'".$SA."'";}else{$Insertar.= ",null";}
	if($PesoPalet!='')
	{	$Insertar.= ",'".$PesoPalet."')";}else{$Insertar.= ",null)";}
	//echo $Insertar."<br>";
	mysqli_query($link, $Insertar);
}
function ObtengoMaximo($Tabla,$Campo,$CampoWhere,$link)
{
	$Maximo="SELECT ifnull(max($Campo)+1,1) as maximo from $Tabla ";
	if($CampoWhere!='')
		$Maximo.=" where $CampoWhere";
	$RespMax=mysqli_query($link, $Maximo);
	if($FilaMax=mysqli_fetch_assoc($RespMax))
	{
		if($FilaMax["maximo"]=='')
			$TxtCodigo=1;
		else		
			$TxtCodigo=$FilaMax["maximo"];
	}
	return($TxtCodigo);
}

function NomUsuario($Rut,$link)
{
	$Consulta = "select * from proyecto_modernizacion.funcionarios where rut='".$Rut."'"; 
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Nom=ucfirst(strtolower($Fila["nombres"]))." ".ucfirst(strtolower($Fila["apellido_paterno"]))." ".ucfirst(strtolower($Fila["apellido_materno"]));
	}
	return($Nom);
}
function NomProducto($Cod,$link)
{
	$Consulta = "select * from proyecto_modernizacion.productos where cod_producto='".$Cod."'"; 
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Nom=ucfirst(strtolower($Fila["descripcion"]));
	}
	return($Nom);
}
function NomSubProducto($Cod,$CodSub,$link)
{
	$Consulta = "select * from proyecto_modernizacion.subproducto where cod_producto='".$Cod."' and cod_subproducto='".$CodSub."'"; 
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Nom=ucfirst(strtolower($Fila["descripcion"]));
	}
	return($Nom);
}
function NomPerfil($Rut,$link)
{
	$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut='".$Rut."' and cod_sistema='6'"; 
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Nivel=$Fila["nivel"];
		$Consulta1 = "select * from proyecto_modernizacion.niveles_por_sistema where cod_sistema='6' and nivel='".$Nivel."'"; 
		$Resp=mysqli_query($link, $Consulta1);
		if($Fila=mysqli_fetch_array($Resp))
			$Nom=$Fila["descripcion"];
		
	}
	return($Nom);
}
function Nivel($Rut,$link)
{
	$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut='".$Rut."' and cod_sistema='6'"; 
	$Resp=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Resp))
	{
		$Nivel=$Fila["nivel"];
	}
	return($Nivel);
}

?>