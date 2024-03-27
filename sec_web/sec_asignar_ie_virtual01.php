<?php 	
	include("../principal/conectar_sec_web.php");
	//echo $Valores."<br>";
	//echo $Valores2."<br>";

	$Valores        = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$Valores2       = isset($_REQUEST["Valores2"])?$_REQUEST["Valores2"]:"";
	$CmbLoteInicial = isset($_REQUEST["CmbLoteInicial"])?$_REQUEST["CmbLoteInicial"]:"";

	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$IE=$Datos2[0];
		$NombreProducto=$Datos2[1];
		$NombreSubProducto=$Datos2[2];
		$CodProducto=$Datos2[3];
		$CodSubProducto=$Datos2[4];
		$Peso=$Datos2[5];
		$TipoIE=$Datos2[6];
		$PesoPreparado=$Datos2[7];
		$Marca=$Datos2[10];
		if ($PesoPreparado=='')
		{
			$PesoPreparado=0;
		}
	}
	switch ($TipoIE)
	{
		case "E":
			$Actualizar="UPDATE sec_web.programa_enami set estado1='R',estado2='P' where corr_enm='".$IE."' ";
			mysqli_query($link, $Actualizar);
			break;
		case "C":
			$Actualizar="UPDATE sec_web.programa_codelco set estado1='R',estado2='P' where corr_codelco='".$IE."' ";
			mysqli_query($link, $Actualizar);
			break;
	}		
	$IEBorrarVirtual=array();
	//RECUPERA EL LOTE INICIAL SELECCIONADO EN EL CMBLOTEINICIAL
	$Lote=explode('~~',$CmbLoteInicial);
	
	$CodBultoInicial=$Lote[0];
	$NumBultoInicial=$Lote[1];
	//CAMBIO REALIZADO POR DVS 14_05_2012 - LF
	$Consulta="SELECT fecha_creacion_lote from sec_web.lote_catodo  ";
	$Consulta.="where cod_bulto='".$CodBultoInicial."' and num_bulto='".$NumBultoInicial."' and cod_estado='a' order by fecha_creacion_lote desc ";
	$RespFec=mysqli_query($link, $Consulta);
	if($FilaFec=mysqli_fetch_assoc($RespFec))
		$FechaCreaLote=$FilaFec["fecha_creacion_lote"];
	else
		$FechaCreaLote=date('Y-m-d');
	//FIN CAMBIO DVS 14_05_2012 - LF
	//SE ACTUALIZA EN CASO QUE YA LA IE TENGA ASIGNADO UN LOTE Y ESTE NO SEA EL SELECCIONADO
	//PARA USARLO COMO LOTE PRINCIPAL, SI NO QUE EL DE LA IE VIRTUAL
	$Actualizar="UPDATE sec_web.lote_catodo set cod_bulto='".$CodBultoInicial."',num_bulto=".$NumBultoInicial;
	$Actualizar= $Actualizar." where corr_enm=".$IE." and cod_estado='a'";
	mysqli_query($link, $Actualizar);
	
	$Datos=explode('//',$Valores2);
	if ($PesoPreparado==0)
	{
		$CodMarca=$Lote[2];
		$PesoVirtual=0;
	}
	else
	{
		$CodMarca=$Marca;
		$PesoVirtual=$PesoPreparado;
	}
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$IEVirtual=$Datos2[0];
		$Consulta="SELECT t1.cod_bulto,t1.num_bulto,t1.cod_paquete,t1.num_paquete,t2.peso_paquetes";
		$Consulta=$Consulta." from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
		$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
		$Consulta=$Consulta." where t1.corr_enm='".$IEVirtual."' and t1.cod_estado='a' and t2.cod_estado='a' order by t1.num_paquete";
		//$Consulta=$Consulta." where t1.corr_enm=".$IEVirtual." order by t1.num_paquete";
		$Respuesta=mysqli_query($link, $Consulta);
		while ($Fila=mysqli_fetch_array($Respuesta))
		{
			$PesoVirtual=$PesoVirtual+$Fila["peso_paquetes"];
			if ($Peso>=$PesoVirtual)
			{
				/*if (((($Peso-500) <= $PesoVirtual) && ($Peso >= $PesoVirtual)) || ($AsignaMenosPeso == "S"))
				{*/
					switch ($TipoIE)
					{
						case "E":
							$Actualizar = "UPDATE sec_web.programa_enami set ";
							$Actualizar.= " estado2 = 'T' ";
							$Actualizar.= " where corr_enm=".$IE;
							mysqli_query($link, $Actualizar);
							break;
						case "C":
							$Actualizar = "UPDATE sec_web.programa_codelco set ";
							$Actualizar.= " estado2 = 'T' ";
							$Actualizar.= " where corr_codelco=".$IE;
							mysqli_query($link, $Actualizar);
							break;
					}
					$CompletoPeso=true;
				//}
				//AGREGA ACTUALIZA FECHA CREACION LOTE DVS 14_05_2012 - LF
				$Actualizar = "UPDATE sec_web.lote_catodo set ";
				$Actualizar.= " cod_bulto='".$CodBultoInicial."',num_bulto=".$NumBultoInicial.",corr_enm=".$IE.",fecha_creacion_lote='".$FechaCreaLote."' ";
				$Actualizar.= " where corr_enm=".$IEVirtual." and cod_bulto='".$Fila["cod_bulto"]."'";
				$Actualizar.= " and num_bulto=".$Fila["num_bulto"]." and cod_paquete='".$Fila["cod_paquete"]."' ";
				$Actualizar.= " and num_paquete=".$Fila["num_paquete"];
				mysqli_query($link, $Actualizar);
				
				$Actualizar = "UPDATE sec_web.pesaje_lodos set ";
				$Actualizar.= " cod_bulto='".$CodBultoInicial."',num_bulto=".$NumBultoInicial.",corr_ie=".$IE." ";
				$Actualizar.= " where corr_ie=".$IEVirtual." and cod_bulto='".$Fila["cod_bulto"]."'";
				$Actualizar.= " and num_bulto=".$Fila["num_bulto"]." and cod_paquete='".$Fila["cod_paquete"]."' ";
				$Actualizar.= " and num_paquete=".$Fila["num_paquete"];
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
				$IEBorrarVirtual[$IEVirtual]=$IEVirtual;
				/*if ($CompletoPeso==true)
				{
					$Actualizar="UPDATE sec_web.lote_catodo set disponibilidad='T',cod_marca='$CodMarca' where corr_enm=".$IE." and cod_estado='a'"; 
					//$Actualizar="UPDATE sec_web.lote_catodo set disponibilidad='T',cod_marca='$CodMarca' where corr_enm=".$IE; 
					mysqli_query($link, $Actualizar);
					$IEVirtual='';
				}*/
			}
			else
			{
				$PesoVirtual=$PesoVirtual-$Fila["peso_paquetes"];
			}	
		}
	}
	//Actualiza LOTE CATODO (el codigo fue sacado desde arriba)
	if ($CompletoPeso==true)
	{
		$Actualizar="UPDATE sec_web.lote_catodo set disponibilidad='T',cod_marca='$CodMarca' where corr_enm=".$IE." and cod_estado='a'"; 
		//$Actualizar="UPDATE sec_web.lote_catodo set disponibilidad='T',cod_marca='$CodMarca' where corr_enm=".$IE; 
		mysqli_query($link, $Actualizar);
		$IEVirtual='';
	}
	if ($IEVirtual!='')
	{
		$Consulta="SELECT min(num_paquete) as lote_inicio";
		$Consulta=$Consulta." from sec_web.lote_catodo where corr_enm=".$IEVirtual." and cod_estado='a'";
		//$Consulta=$Consulta." from sec_web.lote_catodo where corr_enm=".$IEVirtual;
		$Respuesta=mysqli_query($link, $Consulta);
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$Actualizar="UPDATE sec_web.lote_catodo set num_bulto=".$Fila["lote_inicio"]." where corr_enm=".$IEVirtual;
			mysqli_query($link, $Actualizar);
			$Actualizar = "UPDATE sec_web.pesaje_lodos set num_bulto=".$NumBultoInicial." where corr_ie=".$IEVirtual."'"; 
			mysqli_query($link, $Actualizar);
			$Consulta="SELECT t1.cod_bulto,t1.num_bulto,sum(t2.peso_paquetes) as peso_preparado from sec_web.lote_catodo t1 inner";
			$Consulta=$Consulta." join sec_web.paquete_catodo t2 on ";
			$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
			$Consulta=$Consulta." where t1.corr_enm=".$IEVirtual." and t1.cod_estado='a' and t2.cod_estado='a'"; 
			//$Consulta=$Consulta." where t1.corr_enm=".$IEVirtual; 
			$Consulta=$Consulta."group by t1.corr_enm,t1.cod_bulto,t1.num_bulto";
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);
			$Peso=$Fila2["peso_preparado"];
			$Actualizar="UPDATE sec_web.instruccion_virtual set peso_programado=".$Peso.",estado='T' where corr_virtual=".$IEVirtual;
			mysqli_query($link, $Actualizar);
		}
		else
		{
			$IEVirtual='';
		}
	}	
	//while (list($Clave,$Valor)=each($IEBorrarVirtual))
	foreach($IEBorrarVirtual as $Clave => $Valor)
	{
		$IE=$Valor;
		if ($IE!=$IEVirtual)
		{
			$Eliminar="delete from sec_web.instruccion_virtual where corr_virtual=".$IE;
			mysqli_query($link, $Eliminar);
		}	
	}		
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.FrmAsigVirtual.action='sec_asignar_ie_virtual.php?Salir=S';";
	echo "window.opener.document.FrmAsigVirtual.submit();";
	//echo "window.close();";
	echo "</script>";
?>
