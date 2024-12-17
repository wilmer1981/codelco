<?php
class functions{


	function CambiaPosFecha($String)
	{
		$String = explode(' ',$String);
		$String = str_replace('/','-',$String[0]);
		if(strlen($String)>10)
		{
			$String=substr($String,0,10);
		}
		$Fecha=explode('-',$String);
		$FechaSalida=$Fecha[2]."-".$Fecha[1]."-".$Fecha[0];
		
		return($FechaSalida);
	}

	function nombreSistema($Id,$Sistema){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM system_access";
		$Consulta.=" WHERE id<>''";
		if ($Id!='') {
			$Consulta.=" AND id='".$Id."'";
		}
		if ($Sistema!='') {
			$Consulta.=" AND sigla='".$Sistema."'";
		}
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;		
	}

	  function obtenerMaxNroSa(){
	  	global $mysqli;
	  	$Consulta = "select max(nro_solicitud) as NroMayor from cal_web.solicitud_analisis";
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;
	  
	  }

	function obtenerSolicitudAnalisis($CodProducto,$CodSubProducto,$IdMuestra,$FechaHora,$Rut){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " from cal_web.solicitud_analisis";
		//$Consulta.=" WHERE   cod_producto<>'' and cod_subproducto<>'' and fecha_hora<>'' ";
		$Consulta.=" WHERE   cod_producto<>'' and cod_subproducto<>'' ";
		 
		if ($CodProducto!='') {
			$Consulta.=" AND cod_producto='".$CodProducto."'";
		}
		if ($CodSubProducto!='') {
			$Consulta.=" AND cod_subproducto='".$CodSubProducto."'";
		}
		if ($Rut!='') {
			$Consulta.=" AND rut_funcionario = '".$Rut."'";
		}
		if ($IdMuestra!='') {
			$Consulta.=" AND id_muestra LIKE '%".$IdMuestra."%'";
		}
		if ($FechaHora!='') {
			$Consulta.=" AND fecha_hora='".$FechaHora."'";
		}
		//echo $Consulta;
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

	}

  	function insertarSolicitud($Fila,$cantidad,$FechaHora){
  		global $CookieRut;
  		global $mysqli;
  		//print_r($Fila);
  		$Insertar = "insert into cal_web.solicitud_analisis(rut_funcionario,fecha_hora,id_muestra,cod_producto,cod_subproducto,";
		$Insertar = $Insertar."cod_analisis,cod_tipo_muestra,tipo_solicitud,agrupacion,tipo,enabal,cod_ccosto,cod_area,leyes,impurezas) values ('";
		$Insertar = $Insertar.$CookieRut."','";
		$Insertar = $Insertar.$FechaHora."','";
		$Insertar = $Insertar.$Fila[id_muestra]."~".$cantidad."','";	
		$Insertar = $Insertar.$Fila[cod_producto]."','";					
		$Insertar = $Insertar.$Fila[cod_subproducto]."','";			
		$Insertar = $Insertar.$Fila[cod_analisis]."','";
		$Insertar = $Insertar.$Fila[cod_tipo_muestra]."','";
		$Insertar = $Insertar.$Fila[tipo_solicitud]."','";
		$Insertar = $Insertar.$Fila[agrupacion]."','";
		$Insertar = $Insertar.$Fila[tipo]."','";
		$Insertar = $Insertar.$Fila[enabal]."','";			
		$Insertar = $Insertar.$Fila[cod_ccosto]."',";			
		$Insertar = $Insertar.$Fila[cod_area].",'";
		$Insertar = $Insertar.$Fila[leyes]."','";
		$Insertar = $Insertar.$Fila[impurezas]."')";	
		//echo $Insertar;
		$Retorno = $mysqli->QueryAction($Insertar);
  	}
  
 	function obtenerSistema($CodSistema){
 		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.sistemas";
		$Consulta.=" WHERE cod_sistema<>''";
		if ($CodSistema!='') {
			$Consulta.=" AND cod_sistema='".$CodSistema."'";
		}
		//echo $Consulta;
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

 	}

 	function obtenerUnidades($CodUnidades){
 		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.unidades";
		$Consulta.=" WHERE cod_unidad <> '' ";
		if ($CodUnidades!='') {
			$Consulta.=" AND cod_unidad='".$CodUnidades."'";
		}
		//echo $Consulta;
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

 	}

 	function obtenerLeyes($CodLeyes){
 		global $mysqli;
		$Consulta = "SELECT *,t1.abreviatura AS abreviaturaLey";
		$Consulta.= " FROM proyecto_modernizacion.leyes t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad";
		$Consulta.=" WHERE t1.tipo_leyes = 0 ";
		if ($CodLeyes!='') {
			$Consulta.=" AND cod_leyes='".$CodLeyes."'";
		}
		//echo $Consulta;
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;
 	}

 	function obtenerImpureza($CodImpureza){
 		global $mysqli;
		$Consulta = "SELECT *,t1.abreviatura AS abreviaturaLey";
		$Consulta.= " FROM proyecto_modernizacion.leyes t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad";
		$Consulta.=" WHERE t1.tipo_leyes = 1 ";
		if ($CodImpureza!='') {
			$Consulta.=" AND cod_leyes='".$CodImpureza."'";
		}
		$Consulta.=" ORDER BY t1.abreviatura ASC ";
		//echo $Consulta;
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;
 	}

 	function obtenerLeyesFisicas($CodLeyesFisica){
 		global $mysqli;
		$Consulta = "SELECT *,t1.abreviatura AS abreviaturaLey";
		$Consulta.= " FROM proyecto_modernizacion.leyes t1 inner join proyecto_modernizacion.unidades t2 on t1.cod_unidad = t2.cod_unidad";
		$Consulta.=" WHERE t1.tipo_leyes = 3 ";
		if ($CodLeyesFisica!='') {
			$Consulta.=" AND cod_leyes='".$CodLeyesFisica."'";
		}
		$Consulta.=" ORDER BY t1.abreviatura ASC ";
		//echo $Consulta;
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;
 	}


	function obtenerPlantillas($CodSistema,$CodProducto,$CodSubProducto,$IdMuestra){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM plantilla_solicitud_analisis";
		$Consulta.=" WHERE cod_sistema<>'' and cod_producto<>'' and cod_subproducto<>''";
		if ($CodSistema!='') {
			$Consulta.=" AND cod_sistema='".$CodSistema."'";
		}
		if ($CodProducto!='') {
			$Consulta.=" AND cod_producto='".$CodProducto."'";
		}
		if ($CodSubProducto!='') {
			$Consulta.=" AND cod_subproducto='".$CodSubProducto."'";
		}
		if ($IdMuestra!='') {
			$Consulta.=" AND id_muestra='".$IdMuestra."'";
		}
		//echo $Consulta;
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;
	}

	function obtenerProducto($CodProducto){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.productos";
		$Consulta.=" WHERE cod_producto<>''";
		if ($CodProducto!='') {
			$Consulta.=" AND cod_producto='".$CodProducto."'";
		}
		$Consulta.=" ORDER BY descripcion ASC ";
		$Retorno = $mysqli->consulta($Consulta);

		
		//echo $Consulta;
		return $Retorno;
	}

	function obtenerSubProducto($CodProducto,$CodSubProducto){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.subproducto";
		$Consulta.=" WHERE cod_producto<>'' and cod_subproducto<>''";
		if ($CodProducto!='') {
			$Consulta.=" AND cod_producto='".$CodProducto."'";
		}
		if ($CodSubProducto!='') {
			$Consulta.=" AND cod_subproducto='".$CodSubProducto."'";
		}
		$Consulta.=" ORDER BY descripcion ASC ";
		
		//echo $Consulta;
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;
	}

	function obtenerPeriodo($id){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.sub_clase";
		$Consulta.=" WHERE cod_clase ='2'";
		if ($id!='') {
			$Consulta.=" AND cod_subclase='".$id."'";
		}
		$Consulta.=" ORDER BY nombre_subclase ASC ";
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

	}

	function obtenerTipoAnalisis($id){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.sub_clase";
		$Consulta.=" WHERE cod_clase ='1000'";
		if ($id!='') {
			$Consulta.=" AND cod_subclase='".$id."'";
		}
		$Consulta.=" ORDER BY nombre_subclase ASC ";
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

	}
	function obtenerAgrupacion($id){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.sub_clase";
		$Consulta.=" WHERE cod_clase ='1004'";
		if ($id!='') {
			$Consulta.=" AND cod_subclase='".$id."'";
		}
		$Consulta.=" ORDER BY nombre_subclase ASC ";
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

	}


	function obtenerTipo($id){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.sub_clase";
		$Consulta.=" WHERE cod_clase ='1005'";
		if ($id!='') {
			$Consulta.=" AND cod_subclase='".$id."'";
		}
		$Consulta.=" ORDER BY nombre_subclase ASC ";
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

	}

	function obtenerMuestra($id){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.sub_clase";
		$Consulta.=" WHERE cod_clase ='1005'";
		if ($id!='') {
			$Consulta.=" AND cod_subclase='".$id."'";
		}
		$Consulta.=" ORDER BY nombre_subclase ASC ";
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

	}

	
	function obtenerCentroCosto($IdCeCos){
		global $mysqli;
		$Consulta = "SELECT *";
		$Consulta.= " FROM proyecto_modernizacion.centro_costo";
		$Consulta.=" WHERE CENTRO_COSTO<>'' ";
		if ($IdCeCos!='') {
			$Consulta.=" AND CENTRO_COSTO='".$IdCeCos."'";
		}
		$Consulta.=" ORDER BY DESCRIPCION ASC ";
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

	}
 	function obtenerArea($id){
		global $mysqli;
		$Consulta = "SELECT  nombre_subclase as AREA, cod_subclase as COD_AREA";
		$Consulta.= " FROM proyecto_modernizacion.sub_clase";
		$Consulta.=" WHERE cod_clase ='3'";
		if ($id!='') {
			$Consulta.=" AND cod_subclase='".$id."'";
		}
		$Consulta.=" ORDER BY nombre_subclase ASC ";
		//echo $Consulta;
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;

	}
	
	function obtenerPlantillaDetalles($CodSistema){
		//global $mysqli;
		global $mysqli;
		$Consulta = "SELECT T1.*,T1.id_muestra,T1.descripcion as nombre_plantilla,T2.descripcion as nombre_producto, T3.descripcion as nombre_subproducto";
		$Consulta.= " FROM plantilla_solicitud_analisis T1";
		$Consulta.= " INNER JOIN proyecto_modernizacion.productos T2 ON T1.cod_producto=T2.cod_producto";
		$Consulta.= " INNER JOIN proyecto_modernizacion.subproducto T3 ON T1.cod_subproducto=T3.cod_subproducto and T1.cod_producto=T3.cod_producto";
		$Consulta.=" WHERE cod_sistema<>''";
		if ($CodSistema!='') {
			$Consulta.=" AND cod_sistema='".$CodSistema."'";
		}
		//$Retorno = $mysqli->consulta($mysqli,$Consulta);
		$Retorno = $mysqli->consulta($Consulta);
		return $Retorno;
	}

    function mail_send($from, $to, $subject, $message) 
    {
      $headers = "From: ".$from;
      $headers .= "\ncc: ".$from;
      $semi_rand = md5(time()); 
      $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
      $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

      $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
      $message .= "--{$mime_boundary}\n";
      if (count($files)>0){
        foreach ($files as $file) {
          try{
             $filename = end(explode("/",$file));  
            $data = file_get_contents($file);

            $data = chunk_split(base64_encode($data));

            $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$file\"\n" .
              "Content-Disposition: attachment;\n" . " filename=\"$filename\"\n" .
              "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            $message .= "--{$mime_boundary}\n";
          }catch (Exception $e) {
              echo 'Excepción capturada: ',  $e->getMessage(), "\n";
          }
         }

      }
      return (@mail($to, $subject, $message, $headers, '-f'.$from)); 
    }	

}
?>