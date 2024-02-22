<?php
	include("../principal/conectar_principal.php");
	$Consulta = "select distinct t1.ano, t1.mes, t1.cod_producto, t1.cod_subproducto, ";
	$Consulta.= " t1.lote, t1.rut_proveedor, t2.c_faen_a from age_web.historico t1 inner join sipa_web.recepciones t2 on t1.lote=t2.lote";
 	$Consulta.= " where ano in(2002,2003,2004,2005) and cod_subproducto<>'22' ";
 	$Consulta.= " and cod_producto='1'";
 	$Consulta.= " order by lote";
    $Resp = mysqli_query($link, $Consulta);
	$i = 1;
    while ($RstAux = mysqli_fetch_array($Resp))
	{
		$Actualizar = "UPDATE age_web.historico set cod_faena='".$RstAux["c_faen_a"]."' ";
		$Actualizar.= " where ano='".$RstAux["ano"]."' and mes='".$RstAux["mes"]."' ";
		$Actualizar.= " and cod_producto='1' and cod_subproducto='".$RstAux["cod_subproducto"]."' ";
		$Actualizar.= " and lote='".$RstAux["lote"]."' and rut_proveedor='".$RstAux["rut_proveedor"]."'";
		mysqli_query($link, $Actualizar);		
		echo $i.".-".$Actualizar."<br>";
		$i++;
    }
?>