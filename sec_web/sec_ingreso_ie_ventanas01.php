<?php 	
	include("../principal/conectar_sec_web.php");

	$Proceso     = $_REQUEST["Proceso"];
	$Confeccion  = $_REQUEST["Confeccion"];
	$CmbContrato = $_REQUEST["CmbContrato"];
	$CmbDestino  = $_REQUEST["CmbDestino"];
	$TxtIE       = $_REQUEST["TxtIE"];
	$TxtPeso     = $_REQUEST["TxtPeso"];
	$Valores2    = $_REQUEST["Valores2"];
	
	switch ($Proceso)
	{
		case "G":
			$Fecha =date('Y-m-d');
			$Fecha2=date('Y-m-d',mktime(0,0,0,date('n'),date('j')+3,date('Y')));
			$Valor =explode('~~',$CmbContrato);
			$NumContrato   =$Valor[0];
			$NumSubContrato=$Valor[1];
			$CodProducto   =$Valor[2];
			$CodSubProducto=$Valor[3];
			$Consulta="SELECT t1.cod_cliente,t3.rut,t2.confeccion from sec_web.contrato t1 inner join  sec_web.det_contrato t2 on t1.num_contrato=t2.num_contrato ";
			$Consulta.="inner join cliente_venta t3 on t1.cod_cliente=t3.cod_cliente ";
			$Consulta.="where t1.num_contrato=".$NumContrato." and t2.num_subcontrato=".$NumSubContrato." and t2.cod_producto='".$CodProducto."' and t2.cod_subproducto='".$CodSubProducto."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$CodCliente=$Fila["cod_cliente"];
			$Confeccion=$Fila["confeccion"];
			$RutCliente=$Fila["rut"];
			$Insertar="insert into sec_web.programa_enami (corr_enm,cod_producto,cod_subproducto,";
			$Insertar=$Insertar."eta_programada,fecha_disponible,cod_contrato,cod_cliente,cantidad_embarque,cod_marca,num_prog_loteo,estado1,estado2,tipo,tipo_pesada) values(";
			$Insertar=$Insertar."$TxtIE,'$CodProducto','$CodSubProducto','$Fecha','$Fecha2',$NumContrato,'$CodCliente','".str_replace(',','.',$TxtPeso)."','ENM',0,'','N','V','$Confeccion')";
			mysqli_query($link, $Insertar);
			$Destino='';
			if ($CmbDestino!='-1')
			{
				$DestinoCarga=explode('~~',$CmbDestino);
				$Destino=$DestinoCarga[1];
			}
			$Insertar="insert into sec_web.det_contrato_por_ie(num_contrato,num_subcontrato,cod_producto,cod_subproducto,corr_ie,peso,cod_sub_cliente) values (";
			$Insertar.="'$NumContrato','$NumSubContrato','$CodProducto','$CodSubProducto','$TxtIE','".str_replace(',','.',$TxtPeso)."','$Destino')";
			mysqli_query($link, $Insertar);
			if ($Confeccion=='G')
			{
				$cod_puerto='';
				$cod_agente='';
				$cod_estiba='';
				$cod_acopio='';
				$cod_nave='';
				$num_viaje='';
				if ($Destino=='')
				{
					$CodSubCliente='*';
				}
				else
				{
					$CodSubCliente=$Destino;
				}
				$Consulta = "SELECT ifnull(max(num_envio),0)+1 as mayor  from sec_web.embarque_ventana where tipo='V'";
				$Resultado = mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Resultado);
				$TxtNumEnvio=$Fila["mayor"];
				$FechaEnvio=date('Y-m-d');
				$Insertar="insert into sec_web.embarque_ventana (num_envio,corr_enm,cod_bulto,num_bulto, ";
				$Insertar.=" fecha_embarque,fecha_programacion,bulto_paquetes,bulto_peso,cod_marca,cod_producto";
				$Insertar.=",cod_subproducto,cod_cliente,cod_puerto,cod_agente,cod_estiba,cod_acopio,cod_confirmado,";
				$Insertar.=" tipo_embarque,tipo_enm_code,cod_nave,num_viaje,cod_sub_cliente,rut_cliente,fecha_envio,tipo) values(";
				$Insertar.="'".$TxtNumEnvio."','".$TxtIE."','','0','".$Fecha."','".$Fecha2."', ";
				$Insertar.=" '','','01BL','".$CodProducto."','".$CodSubProducto."','".$CodCliente."' ";
				$Insertar.=",'".$cod_puerto."','".$cod_agente."','".$cod_estiba."','".$cod_acopio."','C','T','E','".$cod_nave."','".$num_viaje."','".$CodSubCliente."','".$RutCliente."','".$FechaEnvio."','V')";
				mysqli_query($link, $Insertar);
				$Fecha3 = date("Y-m-d");
				$Datos3=explode('//',$Valores2);
				foreach($Datos3 as $Clave1 => $Valor3)
				{
					$RutTrasp=$Valor3;
					$Insertar="insert into sec_web.relacion_transporte_inst_embarque ";	
					$Insertar.="(rut_transportista,corr_enm,fecha)  ";
					$Insertar.= " values ('".$RutTrasp."','".$TxtIE."','".$Fecha3."')";
					mysqli_query($link, $Insertar);
					$Entrar=true;
				}	
				$Actualizar="UPDATE sec_web.programa_enami set estado2='C' where corr_enm=".$TxtIE;
				mysqli_query($link, $Actualizar);
			}
			break; 
	}
	if ($Entrar==true)
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmProceso.action='sec_ingreso_ie_ventanas.php?CmbContrato=".$CmbContrato."';";
		echo "window.opener.document.FrmProceso.submit();";
		echo "window.close();";
		echo "</script>";
	}
	else
	{
		header('location:sec_ingreso_ie_ventanas.php?CmbContrato='.$CmbContrato);
	}	
?>