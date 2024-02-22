<?php 	
	include("../principal/conectar_principal.php");
	
	$AnoActual=date('Y');
	$Error='';
	switch($Proceso)
	{
		case "G":
			$FechaRelacion=date('Y-m-d');
			$Insertar="insert into sec_web.relacion_lote_enami_codelco(corr_ie,cod_lote,num_lote,fecha_relacion,cantidad_paquetes,peso_lote,marca,cod_cliente,cod_tipo,cod_estado) values(";
			$Insertar=$Insertar."$TxtIE,'$LetraLote',$TxtNumLote,'$FechaRelacion',$TxtCantPaquete,$TxtPesoLote,'$CodMarcaLote','$CodCliente','E','A')";
			mysqli_query($link, $Insertar);
			$Actualizar="UPDATE sec_web.lote_catodo set corr_enm=$TxtIE,cod_cliente='$CodCliente' where cod_bulto='$LetraLote' and num_bulto=".$TxtNumLote." and substring(fecha_creacion_lote,1,4)=$AnoActual";
			mysqli_query($link, $Actualizar);
			break;
		case "V1"://VALIDAR IE(INSTRUCCION DE EMBARQUE)
			$Consulta = "select t1.cantidad_embarque,t1.fecha_embarque,t2.nombre_cliente,t1.cod_cliente from sec_web.programa_enami t1";
			$Consulta=$Consulta." left join sec_web.cliente_venta t2 on t1.cod_cliente = t2.cod_cliente "; 
			$Consulta=$Consulta." where t1.corr_ie=".$TxtIE." and t1.estado='P'";
			$Resultado = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Resultado))
			{
				$FechaEmb=$Fila["fecha_embarque"];
				$CantEmb=$Fila[cantidad_embarque];
				$NombreCliente=$Fila["nombre_cliente"];
				$CodCliente=$Fila["cod_cliente"];
			}
			else
			{
				$Error='Instruccion de Embarque esta Asignada a un lote o no existe';
			}
			break;
		case "V2"://VALIDAR NL(NUMERO LOTE)
			$Consulta = "select t1.cantidad_embarque,t1.fecha_embarque,t2.nombre_cliente,t1.cod_cliente from sec_web.programa_enami t1";
			$Consulta=$Consulta." left join sec_web.cliente_venta t2 on t1.cod_cliente = t2.cod_cliente "; 
			$Consulta=$Consulta." where t1.corr_ie=".$TxtIE." and t1.estado='P'";
			$Resultado = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Resultado))
			{
				$FechaEmb=$Fila["fecha_embarque"];
				$CantEmb=$Fila[cantidad_embarque];
				$NombreCliente=$Fila["nombre_cliente"];
				$CodCliente=$Fila["cod_cliente"];
				$Consulta = "select * from sec_web.relacion_lote_enami_codelco where cod_lote='".$LetraLote."' and num_lote=".$TxtNumLote;
				$Respuesta= mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
				{
					$Error='Lote Ingresado ya fue Asignado a una IE';			
				}
				else
				{
					$Consulta = "select count(*) as CantPaquetes from sec_web.lote_catodo where cod_bulto='".$LetraLote."' and num_bulto=".$TxtNumLote." and substring(fecha_creacion_lote,1,4)=$AnoActual";
					$Resultado = mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Resultado);
					if ($Fila[CantPaquetes]!=0)
					{
						$CantPaquetes=$Fila[CantPaquetes];
						$Consulta="select t1.cod_marca,sum(t2.peso_paquetes) as peso_lote,sum(t2.num_unidades) as unidad_paquete from sec_web.lote_catodo t1";
						$Consulta=$Consulta." inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete";
						$Consulta=$Consulta." where t1.cod_bulto='".$LetraLote."' and t1.num_bulto=".$TxtNumLote." and substring(t1.fecha_creacion_lote,1,4)=$AnoActual group by t1.cod_bulto,t1.num_bulto";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$PesoLote=$Fila[peso_lote];
						$UnidadPaquete=$Fila[unidad_paquete];
						$CodMarca=$Fila["cod_marca"];
						$Consulta="select descripcion from sec_web.marca_catodos where cod_marca='".$CodMarca."'";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$MarcaLote=$Fila["descripcion"];
					}
					else
					{
						$Error='Lote Ingresado no Existe';
					}
				}
			}
			else
			{
				$Error='Instruccion de Embarque esta Asignada a un lote o no existe';
			}
			break;
		case "E":
			$Datos=explode('~~',$Valores);
			foreach($Datos as $Clave => $Valor)
			{
				$IE=$Valor;
				$Consulta="select cod_lote,num_lote from sec_web.relacion_lote_enami_codelco where corr_ie=".$IE;
				$Respuesta=mysqli_query($link, $Consulta);
				$Fila=mysqli_fetch_array($Respuesta);
				$Actualizar="UPDATE sec_web.lote_catodo set corr_enm='',cod_cliente='' where cod_bulto='$Fila[cod_lote]' and num_bulto=$Fila[num_lote] and substring(fecha_creacion_lote,1,4)=$AnoActual";
				mysqli_query($link, $Actualizar);
				$Eliminar="delete from sec_web.relacion_lote_enami_codelco where corr_ie=".$IE;
				mysqli_query($link, $Eliminar);
			}	
			break;	
	}
	switch ($Proceso)
	{	
		case "E":
			header("location:sec_relacion_instruccion_emb_lote.php");
			break;
		case "V1":
			if ($Error=='')
			{
				header("location:sec_relacion_instruccion_emb_lote_proceso.php?CodIE=".$TxtIE."&FechaEmb=".$FechaEmb."&CantEmb=".$CantEmb."&NombreCliente=".$NombreCliente."&CodCliente=".$CodCliente);
			}
			else
			{
				header("location:sec_relacion_instruccion_emb_lote_proceso.php?CodIE=".$TxtIE."&FechaEmb=".$FechaEmb."&CantEmb=".$CantEmb."&Error=".$Error);
			}
			break;
		case "V2":
			if ($Error=='')
			{
				header("location:sec_relacion_instruccion_emb_lote_proceso.php?CodIE=".$TxtIE."&FechaEmb=".$FechaEmb."&CantEmb=".$CantEmb."&NombreCliente=".$NombreCliente."&MesSelec=".$MesLote."&NumLote=".$TxtNumLote."&CantPaquetes=".$CantPaquetes."&PesoLote=".$PesoLote."&UnidadPaquete=".$UnidadPaquete."&MesActual=N&MarcaLote=".$MarcaLote."&CodMarca=".$CodMarca."&CodCliente=".$CodCliente);
			}
			else
			{
				header("location:sec_relacion_instruccion_emb_lote_proceso.php?FechaEmb=".$FechaEmb."&CantEmb=".$CantEmb."&Error=".$Error);
			}
			break;
		default:		
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmRelacIELote.action='sec_relacion_instruccion_emb_lote.php';";
			echo "window.opener.document.FrmRelacIELote.submit();";
			echo "window.close();";
			echo "</script>";
	}	
?>
