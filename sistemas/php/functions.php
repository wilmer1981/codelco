<?php
class functions{
	
	function obtienePerfil($CodPerfil){
		global $dataBaseMysql;
		$Consulta = "SELECT *";
		$Consulta.= " FROM sict_ope_perfil";
		$Consulta.=" WHERE cod_perfil<>''";
		if ($CodPerfil!='') {
			$Consulta.=" AND cod_perfil='".$CodPerfil."'";
		}
		$Retorno = $dataBaseMysql->consulta($Consulta);
		return $Retorno;
	}

	function dataCampamento($Id,$isResumen){
		
		global $dataBaseMysql;
		$Consulta = "SELECT *";
		$Consulta.= " FROM agua_campamento";
		$Consulta.=" WHERE id_campamento<>''";
		if ($Id!='') {
			$Consulta.=" AND id_campamento='".$Id."'";
		}
		if ($_SESSION["CookieCodPerfil"]!='' && $_SESSION["CookieCodPerfil"] != '1') {
			$Consulta.=" AND cod_perfil='".$_SESSION["CookieCodPerfil"]."'";
		}		
		if ($isResumen=='S') {
			$Consulta.=" AND isResumen1='".$isResumen."'";
		}
		
		$Retorno = $dataBaseMysql->consulta($Consulta);
 	
		return $Retorno;
	}

	//ID1 Corresponde al Id del Planta o Edificio
	//ID2 Corresponde al ID de la Campamento
	function dataPlantaedificio($Id1,$Id2){
		
		global $dataBaseMysql;

		$Consulta = "SELECT T1.*,T2.nombre as NombreCampamento,t2.color";
		$Consulta.= " FROM agua_plantaedificio T1 INNER JOIN agua_campamento T2 ON T1.id_campamento=T2.id_campamento";
		$Consulta.=" WHERE T1.id_planedif<>''";
		if ($Id1!='') {
			$Consulta.=" AND T1.id_planedif='".$Id1."'";
		}
		if ($Id2!='') {
			$Consulta.=" AND T2.id_campamento='".$Id2."'";
		}
		//if ($_SESSION["CookieCodPerfil"]!='' && $_SESSION["CookieCodPerfil"] != '1') {
		//	$Consulta.=" AND cod_perfil='".$_SESSION["CookieCodPerfil"]."'";
			if ($_SESSION["tipoPerfil"] == 'operador') {
				$Consulta.=" AND cod_perfil='".$_SESSION["CookieCodPerfil"]."'";
		}		
		$Consulta.=" order by T2.id_campamento";
		//echo $Consulta; 
		$Retorno = $dataBaseMysql->consulta($Consulta);

		return $Retorno;
	}

	function dataRelacionMuestraHoraPlantaCampamento($IdCampamento,$IdPlanEdif){
		global $dataBaseMysql;
		$Consulta = "SELECT T3.id_hora,T4.id_muestra";
		$Consulta.= " FROM agua_campamento T1 INNER JOIN agua_plantaedificio T2 ON T1.id_campamento=T2.id_campamento INNER JOIN agua_horas T3 ON T1.id_campamento=T3.id_campamento AND T3.agua_plantaedificio_tipo=T2.tipo INNER JOIN agua_rel_planta_muestra T4 ON T2.id_planedif=T4.id_planedif";
		$Consulta.=" WHERE T1.id_campamento='".$IdCampamento."' AND T2.id_planedif='".$IdPlanEdif."'";
		//echo $Consulta;
		$Retorno = $dataBaseMysql->consulta($Consulta);
		return $Retorno;
	}

	function dataValores($IdHora, $IdMuestra, $IdPlanEdif, $IdValor){
		global $dataBaseMysql;
		$Consulta = "SELECT *";
		$Consulta.= " FROM agua_valores";
		$Consulta.=" WHERE id_hora='".$IdHora."' AND id_muestra='".$IdMuestra."' AND id_planedif='".$IdPlanEdif."'";
		if ($IdValor!='') {
			$Consulta.=" AND id_valor='".$IdValor."'";
		}	
		//echo $Consulta."<br>";
		$Retorno = $dataBaseMysql->consulta($Consulta);
		return $Retorno;
	}

	function dataRelacionPLanEdifMuestra($Id,$IdMuestra,$IdPLanEdif){
		
		global $dataBaseMysql;
		$Consulta = "SELECT t1.*,t2.nombre as nomPLanEdif,t3.nombre as nomTipoMuestra";
		$Consulta.= " FROM agua_rel_planta_muestra t1 
		inner join agua_plantaedificio t2 on t1.id_planedif=t2.id_planedif
		inner join agua_tipo_muestra t3 on t1.id_muestra=t3.id_muestra";
		$Consulta.=" WHERE id_relacion<>'' and t1.id_muestra <> 0";
		if ($Id!='') {
			$Consulta.=" AND t1.id_relacion='".$Id."'";
		}
		if ($IdMuestra!='') {
			$Consulta.=" AND t1.id_muestra='".$IdMuestra."'";
		}
		if ($IdPLanEdif!='') {
			$Consulta.=" AND t1.id_planedif='".$IdPLanEdif."'";
		}
		//echo $Consulta;
		$Retorno = $dataBaseMysql->consulta($Consulta);
		return $Retorno;
	}

	//ID1 Corresponde al ID de la Hora de la muestra
	//ID2 Corresponde al ID de Campamento
	function dataHoras($Id1,$ID2,$Tipo){
		global $dataBaseMysql;
		$Consulta = "SELECT T1.*,T2.nombre";
		$Consulta.= " FROM agua_horas T1 INNER JOIN agua_campamento T2 on T1.id_campamento=T2.id_campamento";
		$Consulta.=" WHERE T1.id_hora<>''";
		if ($Id1!='') {
			$Consulta.=" AND T1.id_hora='".$Id1."'";
		}
		if ($ID2!='') {
			$Consulta.=" AND T1.id_campamento='".$ID2."'";
		}
		if ($Tipo!='') {
			$Consulta.=" AND T1.agua_plantaedificio_tipo='".$Tipo."'";
		}
		//echo $Consulta;
		$Retorno = $dataBaseMysql->consulta($Consulta);

		return $Retorno;
	}
	function dataTipomuestra($Id1){
		global $dataBaseMysql;
		$Consulta = "SELECT *";
		$Consulta.= " FROM agua_tipo_muestra";
		$Consulta.=" WHERE id_muestra<>''";
		if ($Id1!='') {
			$Consulta.=" AND id_muestra='".$Id1."'";
		}
		//echo $Consulta;
		$Retorno = $dataBaseMysql->consulta($Consulta);
		return $Retorno;
	}

	function nombreTipoEdificioPLanta($Tipo)
	{
		switch($Tipo)
		{
			case "E":
				return "Edificio";
			break;
			default:
				return "Planta";
			break;
		}
	}

	function ObteneLinks()
	{
		$Query = "SELECT t3.* from sict_ope_link_por_perfil t1 inner join sict_ope_link t2 on t1.cod_link=t2.cod_link inner join system_access t3 on t2.sistema=t3.sigla where cod_perfil = '".$_SESSION["CookieCodPerfil"]."' group by sistema";
		return $Query;
	}

	function ObtieneSistemasAsociados()
	{
		$Query = "SELECT t3.* from sict_ope_link_por_perfil t1 inner join sict_ope_link t2 on t1.cod_link=t2.cod_link inner join system_access t3 on t2.sistema=t3.sigla where cod_perfil = '".$_SESSION["CookieCodPerfil"]."' group by sistema";
		return $Query;
		echo $Query;
	}	
	function tiempoBloqueo($rut,$tiempo)
	{
		global $dataBaseMysql;
		$rut = explode('-',$rut);
		$Consulta = "SELECT bloqueo,fecha_bloqueo_pass FROM sict_ope_usuario WHERE rut = '".$rut[0]."'";
		//echo  $Consulta."<br>";
		$Resp = $dataBaseMysql->consulta($Consulta);
		if($Fila = mysqli_fetch_assoc($Resp))
		{
			if($Fila[bloqueo]=='S') //Revisa la fecha si pwd está bloqueada.
			{	
				$ahora = date('Y-m-d H:i:s');
				$fechaBloq = strtotime($Fila[fecha_bloqueo_pass]);
				$fechaAhora = strtotime($ahora);
				$intervalo = round(($fechaAhora - $fechaBloq ) / 60,2);
				//echo round(($fechaAhora - $fechaBloq ) / 60,2). " minutos<br>";
				if ($intervalo>$tiempo)
				{
					$Actualizar = " UPDATE sict_ope_usuario set ";
								$Actualizar.= " bloqueo='N' ";
								$Actualizar.= " where rut='".$rut[0]."'";
								$dataBaseMysql->QueryAction($Actualizar);
				}
				else
					$_SESSION["minutos"]=$tiempo-round($intervalo);
			}
				
		}
	}	
}
?>