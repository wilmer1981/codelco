<?php 
include("../principal/conectar_principal.php");

$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$Valores   = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
  		
$Datos = explode("//",$Valores);
$SubPC = isset($Datos[0])?$Datos[0]:"";
$SubPB = isset($Datos[1])?$Datos[1]:"";
$LoteC = isset($Datos[2])?$Datos[2]:"";
$LoteB = isset($Datos[3])?$Datos[3]:"";
$FechaB= isset($Datos[4])?$Datos[4]:"0000-00-00";
    
if ($Proceso=="G")
{
	$okey = 0;
	$Existe = 0;
	$Consulta1="Select * from age_web.lotes where lote ='".$LoteB."'";
	$Resp1=mysqli_query($link, $Consulta1);
	if($Fila1=mysqli_fetch_array($Resp1))
	{
		$Existe=1;
	}
	$Consulta ="Select *  from age_web.lotes where lote = '".$LoteC."' and cod_subproducto = '".$SubPC."'";
	$Resp = mysqli_query($link, $Consulta);
	if ($Fila = mysqli_fetch_array($Resp))
	{
		if ($Existe==0)
		{
			$Insertar = "Insert into age_web.lotes (lote, cod_producto, cod_subproducto,rut_proveedor,fecha_recepcion,";
			$Insertar.="clase_producto,num_conjunto,remuestreo,tipo_remuestreo,num_lote_remuestreo,estado_lote,mostrar_lote,";
			$Insertar.="modificado,peso_muestra,peso_retalla,cancha,fecha_vence_padron, canjeable,contrato, muestra_paralela,";
			$Insertar.="cod_recepcion_enm, laboratorio_externo, orden_ensaye, fecha_sol_pqts)";
			$Insertar.=" Values('".$LoteB."','".$Fila["cod_producto"]."','".$SubPB."','".$Fila["rut_proveedor"]."','".$FechaB."',";
			$Insertar.="'".$Fila["clase_producto"]."','".$Fila["num_conjunto"]."','".$Fila["remuestreo"]."','".$Fila["tipo_remuestreo"]."',";
			$Insertar.="'".$Fila["num_lote_remuestreo"]."','".$Fila["estado_lote"]."','".$Fila["mostrar_lote"]."','".$Fila["modificado"]."',";
			$Insertar.="'".$Fila["peso_muestra"]."','".$Fila["peso_retalla"]."','".$Fila["cancha"]."','".$Fila["fecha_vence_padron"]."',";
			$Insertar.="'".$Fila["canjeable"]."','".$Fila["contrato"]."','".$Fila["muestra_paralela"]."','".$Fila["cod_recepcion_enm"]."',";
			$Insertar.=" '".$Fila["laboratorio_externo"]."','".$Fila["orden_ensaye"]."','".$Fila["fecha_sol_pqts"]."')";
			//echo "inserto 1".$Insertar."</br>";
		     mysqli_query($link, $Insertar);
		}
	}
	$Existe=0;
	$ConsultaD="Select * from age_web.detalle_lotes where lote = '".$LoteB."'";
	$RespD=mysqli_query($link, $ConsultaD);
	if($FilaD=mysqli_fetch_array($RespD))
	{
		$Existe = 1;
	}
	if($Existe==0)
	{
		$Consulta2 = "Select * from  age_web.detalle_lotes where lote = '".$LoteC."' ";
		$Resp2 = mysqli_query($link, $Consulta2);
		while ($Fila2 = mysqli_fetch_array($Resp2))
		{
			$InsertarD ="Insert into age_web.detalle_lotes (lote, recargo, folio, corr,fecha_recepcion,hora_entrada,";
			$InsertarD.="hora_salida,fin_lote,peso_bruto, peso_tara, peso_neto, guia_despacho, patente, autorizado,";
			$InsertarD.="estado_recargo, mostrar_recargo,modificado,rut_romanero, bascula1, bascula, cod_descarga,observacion,";
			$InsertarD.="pastas, impurezas)";
			$InsertarD.=" values('".$LoteB."','".$Fila2["recargo"]."','".$Fila2["folio"]."','".$Fila2["corr"]."','".$FechaB."',";
			$InsertarD.="'".$Fila2["hora_entrada"]."','".$Fila2["hora_salida"]."','".$Fila2["fin_lote"]."','".$Fila2["peso_bruto"]."',";
			$InsertarD.="'".$Fila2["peso_tara"]."','".$Fila2["peso_neto"]."','".$Fila2["guia_despacho"]."','".$Fila2["patente"]."',";
			$InsertarD.="'N','".$Fila2["estado_recargo"]."','".$Fila2["mostrar_recargo"]."','".$Fila2["modificado"]."',";
			$InsertarD.=" '".$Fila2["rut_romanero"]."','".$Fila2["bascula1"]."','".$Fila2["bascula"]."','".$Fila2["cod_descarga"]."',";
			$InsertarD.="'".$Fila2["observacion"]."','".$Fila2["pastas"]."','".$Fila2["impurezas"]."')";
				//echo "inserto 2".$InsertarD."</br>";
			 mysqli_query($link, $InsertarD);
		}
	}
	$ExisteLey=0;
	$NSolicitud=0;
	$ConsultaSA = "Select  * from cal_web.solicitud_analisis  where id_muestra = '".$LoteC."'";
	$rspSA = mysqli_query($link, $ConsultaSA);
	if ($FilaSA = mysqli_fetch_array($rspSA))
	{
		$ExisteLey = 1;
		$NSolicitud = $FilaSA["nro_solicitud"];
		$actualiza = "UPDATE cal_web.solicitud_analisis set id_muestra = '".$LoteB."', fecha_muestra = '".$FechaB."'";
		$actualiza.=" where id_muestra = '".$LoteC."' and  nro_solicitud = '".$FilaSA["nro_solicitud"]."'";
		mysqli_query($link, $actualiza);
	}
	if($ExisteLey==1)
	{
		$ConsultaLey = "Select * from cal_web.leyes_por_solicitud where id_muestra = '".$LoteC."' and nro_solicitud = '".$NSolicitud."'";
		$rspLey = mysqli_query($link, $ConsultaLey);
		while($FilaLey = mysqli_fetch_array($rspLey))
		{
			$actualizaS = "UPDATE cal_web.leyes_por_solicitud set id_muestra = '".$LoteB."' where id_muestra = '".$LoteC."'";
			$actualizaS.=" and nro_solicitud = '".$NSolicitud."'";
			mysqli_query($link, $actualizaS);
		} 
	}
	if($SubPC==18)
	{	
		$encuentro = 0;
		$ConsultaSec ="Select * from sec_web.paquete_catodo_externo";
		$ConsultaSec.=" where lote_origen = '".$LoteC."' and cod_producto = '".$SubPC."'";
		$RespSec = mysqli_query($link, $ConsultaSec);
		if($FSec = mysqli_fetch_array($RespSec))
		{
			$encuentro = 1;
		}
		if ($encuentro==1)
		{	
			$actualiza3="UPDATE sec_web.paquete_catodo_externo set lote_origen = '".$LoteB."' ";
			$actualiza3.=" where  lote_origen = '".$LoteC."' and cod_producto ='".$SubPC."'";
			mysqli_query($link, $actualiza3);
		}
	} 
		
}
header("Location:age_con_cambio_lote.php"); 


?>