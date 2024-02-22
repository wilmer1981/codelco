<?php
function SapValidos($ProdAux, $AnoAux, $MesAux, $link)
{
	$fec_control = date("Y-m-d");
	$Mes_control = date("m");
	$largo = strlen($Mes_control);
	if ($largo==1)
	{
		$Mes_control = "0$Mes_control";
	}		
	$Ano_control = date("Y");
	$anito = substr($AnoAux,2,2);
	$lar = strlen($MesAux);
	if ($lar==1)
	{
		$MesAux="0$MesAux";
	}
	$Delete ="delete from interfaces_codelco.tmp_control_pas";
	mysqli_query($link, $Delete);
	$Consulta = "select  t0.corr_enm, tt.fecha_disponible, tt.cod_producto, tt.cod_subproducto, tt.cod_contrato_maquila ";
	$Consulta.=" from interfaces_codelco.asignaciones t inner join sec_web.programa_codelco tt on t.asignacion=tt.cod_contrato_maquila ";
	$Consulta.= " inner join sec_web.lote_catodo t0 on tt.corr_codelco=t0.corr_enm ";
	$Consulta.= " inner join sec_web.paquete_catodo t1 ";
	$Consulta.= " ON t0.cod_paquete=t1.cod_paquete and t0.num_paquete=t1.num_paquete ";
	$Consulta.= " and t0.fecha_creacion_paquete=t1.fecha_creacion_paquete ";
	$Consulta.= " left join sec_web.guia_despacho_emb t2 on t1.num_guia=t2.num_guia ";
	$Consulta.= " inner join proyecto_modernizacion.subproducto t3 on tt.cod_producto=t3.cod_producto and tt.cod_subproducto=t3.cod_subproducto ";
	$Consulta.= " inner join sec_web.marca_catodos t4 on t0.cod_marca=t4.cod_marca ";
	$Consulta.= " where tt.fecha_disponible between '".$AnoAux."-".$MesAux."-01' and '".$AnoAux."-".$MesAux."-31' ";
	$Consulta.= " and t.salida<>'' and tt.estado2 IN ('C','T')";
	$Consulta.= " and (tt.cod_producto = '18' or tt.cod_producto = '48') ";
	$Consulta.= " group by tt.cod_producto,tt.cod_subproducto, t0.cod_bulto,t0.num_bulto";	
	$Consulta.= " order by tt.cod_producto,tt.cod_subproducto,t0.corr_enm ";
	$RespAux = mysqli_query($link, $Consulta);
	while ($FilaAux = mysqli_fetch_array($RespAux))
	{
			$Referencia = "";
			$Referencia ="$anito$MesAux$FilaAux["corr_enm"]";
			$Inserta = "insert into interfaces_codelco.tmp_control_pas (ano,mes,referencia) ";
			$Inserta.=" values(".$AnoAux.",".$MesAux.",'".$Referencia."')";
			mysqli_query($link, $Inserta);
	}
}
?>
