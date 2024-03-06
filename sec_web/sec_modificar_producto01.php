<?php
	include("../principal/conectar_principal.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
	//$Mes     = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:"";
	$Codigo  = isset($_REQUEST["Codigo"])?$_REQUEST["Codigo"]:"";
	$Numero  = isset($_REQUEST["Numero"])?$_REQUEST["Numero"]:"";
	$CmbProductos    = isset($_REQUEST["CmbProductos"])?$_REQUEST["CmbProductos"]:"";
	$cmbsubproducto  = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"";
	$Valores     = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$CodigoLote  = isset($_REQUEST["CodigoLote"])?$_REQUEST["CodigoLote"]:"";
	$NumeroLote  = isset($_REQUEST["NumeroLote"])?$_REQUEST["NumeroLote"]:"";

	switch ($Proceso)
	{
		case "G":
			$Consulta="select * from proyecto_modernizacion.sub_clase ";
			$Consulta.=" where cod_clase='3004' and nombre_subclase='".$Codigo."'";
			$Respuesta=mysqli_query($link, $Consulta);
			//echo "Comnsulta:".$Consulta;
			$Mes="";
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				$Mes=$Fila["cod_subclase"];
			}		
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				$MesPaqueteI=$Datos2[0];
				$NumPaqueteI=$Datos2[1];
				$NumPaqueteF=$Datos2[3];
				$Actualizar="UPDATE sec_web.paquete_catodo set cod_producto='$CmbProductos',cod_subproducto='$cmbsubproducto' ";
				$Actualizar.=" where (cod_paquete='".$MesPaqueteI."' and num_paquete between '".$NumPaqueteI."' and '".$NumPaqueteF."') and LEFT(fecha_creacion_paquete,4)='".$Ano."'";
				mysqli_query($link, $Actualizar);
				
				$Actualizar="UPDATE sec_web.paquete_catodo_externo set cod_producto='$CmbProductos',cod_subproducto='$cmbsubproducto' ";
				$Actualizar.=" where (cod_paquete='".$MesPaqueteI."' and num_paquete between '".$NumPaqueteI."' and '".$NumPaqueteF."') and LEFT(fecha_creacion_paquete,4)='".$Ano."'";
				mysqli_query($link, $Actualizar);

				$Consulta="SELECT corr_enm,cod_producto,cod_subproducto from sec_web.lote_catodo t1  ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.fecha_creacion_paquete=t2.fecha_creacion_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where (t1.cod_paquete='".$MesPaqueteI."' and t1.num_paquete between '".$NumPaqueteI."' and '".$NumPaqueteF."') and LEFT(t2.fecha_creacion_paquete,4)='".$Ano."'  and  cod_bulto='".$CodigoLote."' and num_bulto='".$NumeroLote."' group by t1.corr_enm";
				$Respuesta=mysqli_query($link, $Consulta);
				//echo $Consulta;
				$Correlativo="";
				if($Fila=mysqli_fetch_array($Respuesta))
				{
					$Correlativo=$Fila["corr_enm"];
					$AUXCmbProductos=$Fila["cod_producto"];
					$Auxcmbsubproducto=$Fila["cod_subproducto"];
				}	

				$Actualizar="UPDATE sec_web.instruccion_virtual set cod_producto='$CmbProductos',cod_subproducto='$cmbsubproducto' ";
				$Actualizar.=" where  corr_virtual='".$Correlativo."' ";
				mysqli_query($link, $Actualizar);
				/*echo $Actualizar."<br>";*/
				/*$Actualizar="UPDATE sec_web.programa_codelco set cod_producto='$CmbProductos',cod_subproducto='$cmbsubproducto' ";
				$Actualizar.=" where cod_producto='".$AUXCmbProductos."' and cod_subproducto='".$Auxcmbsubproducto."' and  corr_codelco='".$Correlativo."' ";
				mysqli_query($link, $Actualizar);

				$Actualizar="UPDATE sec_web.programa_enami set cod_producto='$CmbProductos',cod_subproducto='$cmbsubproducto' ";
				$Actualizar.=" where cod_producto='".$AUXCmbProductos."' and cod_subproducto='".$Auxcmbsubproducto."' and  corr_enm='".$Correlativo."' ";
				mysqli_query($link, $Actualizar);
				
				$Actualizar="UPDATE sec_web.programa_enami_codelco set cod_producto='$CmbProductos',cod_subproducto='$cmbsubproducto' ";
				$Actualizar.=" where cod_producto='".$AUXCmbProductos."' and cod_subproducto='".$Auxcmbsubproducto."' and  corr_ie='".$Correlativo."' ";
				mysqli_query($link, $Actualizar);
				echo $Actualizar."<br>";*/
				/*$Actualizar="UPDATE sec_web.lote_catodo set cod_producto='$CmbProductos',cod_subproducto='$cmbsubproducto' ";
				$Actualizar.=" where (cod_paquete='".$MesPaqueteI."' and num_paquete between '".$NumPaqueteI."' and '".$NumPaqueteF."') and LEFT(fecha_creacion_paquete,4)='".$Ano."'";
				mysqli_query($link, $Actualizar);*/
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.FrmProceso.action='sec_adm_lotes.php?Mostrar=S&Mostrar2=S&CodBulto=".$Codigo."&NumBulto=".$Numero."&Ano=".$Ano."&Mes=".$Mes."';";
				echo "window.opener.document.FrmProceso.submit();";
				echo "window.close();";
				echo "</script>";				
			}
			break;			
	}
?>