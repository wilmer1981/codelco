<?php
	include("../principal/conectar_sec_web.php");

	$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Codigo  = isset($_REQUEST["Codigo"])?$_REQUEST["Codigo"]:"";
	$Ano     = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
	$Numero  = isset($_REQUEST["Numero"])?$_REQUEST["Numero"]:"";
	$Marca   = isset($_REQUEST["Marca"])?$_REQUEST["Marca"]:"";
	$IE      = isset($_REQUEST["IE"])?$_REQUEST["IE"]:"";

	$CmbGrupo = isset($_REQUEST["CmbGrupo"])?$_REQUEST["CmbGrupo"]:"";

	/******* cambio grupo *********/
	$ValoresAux = isset($_REQUEST["ValoresAux"])?$_REQUEST["ValoresAux"]:"";
	$AnoAux     = isset($_REQUEST["AnoAux"])?$_REQUEST["AnoAux"]:"";
	$NumIAux     = isset($_REQUEST["NumIAux"])?$_REQUEST["NumIAux"]:"";
	$NumFAux     = isset($_REQUEST["NumFAux"])?$_REQUEST["NumFAux"]:"";
	$MesIAux     = isset($_REQUEST["MesIAux"])?$_REQUEST["MesIAux"]:"";
	$CodLote     = isset($_REQUEST["CodLote"])?$_REQUEST["CodLote"]:"";
	$NumLote     = isset($_REQUEST["NumLote"])?$_REQUEST["NumLote"]:"";
	/*********************************** */

	$CodBulto = isset($_REQUEST["CodBulto"])?$_REQUEST["CodBulto"]:"";
	$NumBulto = isset($_REQUEST["NumBulto"])?$_REQUEST["NumBulto"]:"";
	$Valores  = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$AnoLote  = isset($_REQUEST["AnoLote"])?$_REQUEST["AnoLote"]:"";

	$FechaCreacion= date("Y-m-d");
	//$Ano=date("Y");
	$CookieRut     = $_COOKIE["CookieRut"];
	$Rut           = $CookieRut;
	//$FechaConsulta = substr($FechaO,0,4);

	switch ($Proceso)	
	{
		case "Asignar":
			$Consulta="select * from sec_web.lote_catodo ";
			$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto = '".$NumBulto."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			//echo $Valores."<br>";
			$datos = explode("@@",$Valores);//Separa los parametros en un array.	
			//echo $datos[0]."<br>"; 
			//echo $datos[1]."<br>"; 
			reset($datos); 
			//foreach($datos as $clave => $valor)
			foreach ($datos as $clave => $valor)
			{
				$arreglo=explode("//",$valor);//CodBulto//NumBulto
				$insertar="insert into sec_web.lote_catodo  ";
				$insertar.="(cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,  ";
				$insertar.=" cod_marca,corr_enm,cod_estado)";
				$insertar.= " values ('".$CodBulto."','".$NumBulto."','".$arreglo[0]."',";
				$insertar.=" '".$arreglo[1]."','".$Fila["fecha_creacion_lote"]."','".$Fila["cod_marca"]."','".$Fila["corr_enm"]."','A')";
				//echo $insertar."<br>";
				mysqli_query($link, $insertar);
				//echo "1".$arreglo[0]."<br>";
				//echo "2".$arreglo[1]."<br>";
			}
					
		break;
		case "CambiarMarca":
			$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='3004' and nombre_subclase='".$Codigo."' ";
			$Respuesta0=mysqli_query($link, $Consulta);
			$Fila0=mysqli_fetch_array($Respuesta0);
			$Mes=$Fila0["cod_subclase"];
			$Consulta="SELECT count(*) as cantidad from sec_web.lote_catodo where  ";
			$Consulta.=" cod_bulto='".$Codigo."' and num_bulto='".$Numero."' and left(fecha_creacion_lote,4)='".$Ano."' and cod_estado='c'		";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$Mensaje3="";
			if($Fila["cantidad"]>0)
			{
				$Mensaje3="No se puede Modificar la Marca por que el Lote se despacho ";			
			}
			else
			{
				$Actualizar="UPDATE sec_web.lote_catodo set cod_marca ='".$Marca."' where substring(fecha_creacion_lote,1,4)='".$Ano."'";
				$Actualizar.=" and cod_bulto='".$Codigo."' and num_bulto='".$Numero."' ";
				mysqli_query($link, $Actualizar);
				
				$FechaEmbIni=$Ano."-01-01";
				$FechaEmbFin=(intval($Ano)+1)."-12-01";
				$Actualizar="UPDATE sec_web.embarque_ventana set cod_marca ='".$Marca."' WHERE fecha_embarque between '".$FechaEmbIni."' and '".$FechaEmbFin."'";
				$Actualizar.=" and cod_bulto='".$Codigo."' and num_bulto='".$Numero."' and corr_enm='".$IE."'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar;
			}
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProceso.action='sec_adm_lotes.php?CmbAno=".$Ano."&Mes=".$Mes."&CmbCodBulto=".$Mes."&NumBulto=".$Numero."&Mensaje3=".$Mensaje3."';";
			echo "window.opener.document.FrmProceso.submit();";
			echo "window.close();";
			echo "</script>";
		break;
		case "C":
			header ("location:sec_conf_inicial_lotes.php");
		break;
		case "QuitarRelacion":
			$Consulta = "SELECT * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '3'  ";
			$Respuesta =mysqli_query($link, $Consulta);
			if($Fila =mysqli_fetch_array($Respuesta))
			{
				$Nivel = $Fila["nivel"];
			}
			if ($Nivel=="1")
			{
					$datos = explode("//",$Valores);
					reset($datos); 
					//foreach($datos as $clave => $valor) //arreglo[0]:cod_paquete;arreglo[1]:num_paquete;arreglo[2]:Fecha_creacion_paquete
					foreach ($datos as $clave => $valor)
					{
						$AnoActual=date("Y");
						$Consulta="SELECT max(corr_virtual) as numero from sec_web.instruccion_virtual ";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						if($Fila["numero"]=='')
						{
							$IEVirtual=900000;	
						}
						else
						{
							$IEVirtual=$Fila["numero"]+1;
						}
						$arreglo=explode("~",$valor);
						$Consulta="SELECT t2.cod_producto,t2.cod_subproducto,sum(peso_paquetes) as suma_paquetes,t1.corr_enm,t1.cod_bulto,t1.num_bulto,t1.fecha_creacion_lote,disponibilidad from sec_web.lote_catodo t1";
						$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
						$Consulta.=" and t1.cod_estado=t2.cod_estado ";
						$Consulta.=" where cod_bulto='".$Codigo."' and num_bulto='".$Numero."' and left(fecha_creacion_lote,4)='".$AnoLote."'	";
						$Consulta.=" and t2.cod_paquete='".$arreglo[0]."' and t2.num_paquete between '".$arreglo[1]."'	and '".$arreglo[3]."'";
						$Consulta.=" group by t2.cod_producto,t2.cod_subproducto";
						$Respuesta1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Respuesta1);
						$Suma          =isset($Fila1["suma_paquetes"])?$Fila1["suma_paquetes"]:"";
						$IE            =isset($Fila1["corr_enm"])?$Fila1["corr_enm"]:"";
						$Disponibilidad=isset($Fila1["disponibilidad"])?$Fila1["disponibilidad"]:"";
						$Consulta="select * from sec_web.programa_enami where corr_enm='".$IE."'";
						$Respuesta2=mysqli_query($link, $Consulta);
						//echo $Consulta."<br>";
						if($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$Cantidad=($Fila2["cantidad_embarque"]*1000);
							$Estado=$Fila2["estado2"];
							if ($Fila2["estado2"]=="A")
							{
								$Actualizar="UPDATE sec_web.programa_enami set estado1='' where corr_enm='".$IE." '";
							}	
							else
							{
								$Actualizar="UPDATE sec_web.programa_enami set estado2='',estado1='' where corr_enm='".$IE." '";
							}	
							mysqli_query($link, $Actualizar);
								
						}
						else
						{
							$Consulta="select * from sec_web.programa_codelco where corr_codelco='".$IE."'";
							$Respuesta2=mysqli_query($link, $Consulta);
							$Fila2=mysqli_fetch_array($Respuesta2);
							//echo $Consulta;
							$cantidad_programada = isset($Fila2["cantidad_programada"])?$Fila2["cantidad_programada"]:0;
							$Cantidad=($cantidad_programada*1000);
							$Estado  = isset($Fila2["estado2"])?$Fila2["estado2"]:"";	
							if ($Estado=="A")
							{
								$Actualizar="UPDATE sec_web.programa_codelco set estado1='' where corr_codelco='".$IE." '";
							}
							else
							{
								$Actualizar="UPDATE sec_web.programa_codelco set estado2='',estado1='' where corr_codelco='".$IE." '";
							}
							mysqli_query($link, $Actualizar);
						}
						$cod_producto    = isset($Fila1["cod_producto"])?$Fila1["cod_producto"]:"";
						$cod_subproducto = isset($Fila1["cod_subproducto"])?$Fila1["cod_subproducto"]:"";
						$cod_bulto       = isset($Fila1["cod_bulto"])?$Fila1["cod_bulto"]:"";
						$num_bulto       = isset($Fila1["num_bulto"])?$Fila1["num_bulto"]:"";
						$fecha_creacion_lote  = isset($Fila1["fecha_creacion_lote"])?$Fila1["fecha_creacion_lote"]:"";

						$insertar="insert into sec_web.instruccion_virtual ";
						$insertar.="(corr_virtual,fecha_embarque,cod_producto,cod_subproducto,peso_programado,descripcion,estado)  ";
						$insertar.= " values ('".$IEVirtual."','".$AnoActual."-12-31','".$cod_producto."','".$cod_subproducto."',";
						$insertar.=" '".$Cantidad."','ADM','".$Disponibilidad."') ";
						mysqli_query($link, $insertar);
						//echo $insertar."<br>";
						$Actualizar="UPDATE sec_web.lote_catodo set corr_enm ='$IEVirtual',cod_bulto='$arreglo[0]',num_bulto='$arreglo[1]'  "; 
						$Actualizar.=" WHERE cod_bulto='".$cod_bulto."' and num_bulto='".$num_bulto."' ";
						$Actualizar.=" AND fecha_creacion_lote='".$fecha_creacion_lote."' and corr_enm='".$IE."'	";
						$Actualizar.=" AND cod_paquete='".$arreglo[0]."' and num_paquete between '".$arreglo[1]."'	and '".$arreglo[3]."' ";
						//echo $Actualizar."<br>";
						mysqli_query($link, $Actualizar);
					}
			
			}
			else
			{
				$Consulta="select count(*) as cantidad from sec_web.lote_catodo where  ";
				$Consulta.=" cod_bulto='".$Codigo."' and num_bulto='".$Numero."' and left(fecha_creacion_lote,4)='".$AnoLote."'	and cod_estado='c'";
				$Respuesta0=mysqli_query($link, $Consulta);
				$Fila0=mysqli_fetch_array($Respuesta0);
				if($Fila0["cantidad"] > 0)
				{
					$Mensaje2="S";
				}
				else	
				{
					$datos = explode("//",$Valores);
					reset($datos); 
					//foreach($datos as $clave => $valor)//arreglo[0]:cod_paquete;arreglo[1]:num_paquete;arreglo[2]:Fecha_creacion_paquete
					foreach ($datos as $clave => $valor)
					{
						$AnoActual=date("Y");
						$Consulta="select max(corr_virtual) as numero from sec_web.instruccion_virtual ";
						$Respuesta=mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						if($Fila["numero"]=='')
						{
							$IEVirtual=900000;	
						}
						else
						{
							$IEVirtual=$Fila["numero"]+1;
						}
						$arreglo=explode("~",$valor);
						$Consulta="SELECT t2.cod_producto,t2.cod_subproducto,sum(peso_paquetes) as suma_paquetes,t1.corr_enm,t1.cod_bulto,t1.num_bulto,t1.fecha_creacion_lote,disponibilidad from sec_web.lote_catodo t1";
						$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
						$Consulta.=" and t1.cod_estado=t2.cod_estado ";
						$Consulta.=" where cod_bulto='".$Codigo."' and num_bulto='".$Numero."' and left(fecha_creacion_lote,4)='".$AnoLote."'	";
						$Consulta.=" and t2.cod_paquete='".$arreglo[0]."' and t2.num_paquete between '".$arreglo[1]."'	and '".$arreglo[3]."'";
						$Consulta.=" group by t2.cod_producto,t2.cod_subproducto";
						$Respuesta1=mysqli_query($link, $Consulta);
						$Fila1=mysqli_fetch_array($Respuesta1);
						$Suma=($Fila1["suma_paquetes"]);
						$IE=$Fila1["corr_enm"];
						$Disponibilidad=$Fila1["disponibilidad"];
						$Consulta="SELECT * from sec_web.programa_enami where corr_enm='".$IE."'";
						$Respuesta2=mysqli_query($link, $Consulta);
						//echo $Consulta."<br>";
						if($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$Cantidad=($Fila2["cantidad_embarque"]*1000);
							$Estado=$Fila2["estado2"];
							if ($Fila2["estado2"]=="A")
							{
								$Actualizar="UPDATE sec_web.programa_enami set estado1='' where corr_enm='".$IE." '";
							}	
							else
							{
								$Actualizar="UPDATE sec_web.programa_enami set estado2='',estado1='' where corr_enm='".$IE." '";
							}	
							mysqli_query($link, $Actualizar);
								
						}
						else
						{
							$Consulta="select * from sec_web.programa_codelco where corr_codelco='".$IE."'";
							$Respuesta2=mysqli_query($link, $Consulta);
							$Fila2=mysqli_fetch_array($Respuesta2);
							//echo $Consulta;
							$Cantidad=($Fila2["cantidad_programada"]*1000);
							$Estado=$Fila2["estado2"];	
							if ($Fila2["estado2"]=="A")
							{
								$Actualizar="UPDATE sec_web.programa_codelco set estado1='' where corr_codelco='".$IE." '";
							}
							else
							{
								$Actualizar="UPDATE sec_web.programa_codelco set estado2='',estado1='' where corr_codelco='".$IE." '";
							}
							mysqli_query($link, $Actualizar);
						}
						$insertar="insert into sec_web.instruccion_virtual ";
						$insertar.="(corr_virtual,fecha_embarque,cod_producto,cod_subproducto,peso_programado,descripcion,estado)  ";
						$insertar.= " values ('".$IEVirtual."','".$AnoActual."-12-31','".$Fila1["cod_producto"]."','".$Fila1["cod_subproducto"]."',";
						$insertar.=" '".$Cantidad."','ADM','".$Disponibilidad."') ";
						mysqli_query($link, $insertar);
						//echo $insertar."<br>";
						$Actualizar="UPDATE sec_web.lote_catodo set corr_enm ='".$IEVirtual."',cod_bulto='".$arreglo[0]."',num_bulto='".$arreglo[1]."'  "; 
						$Actualizar.=" where cod_bulto='".$Fila1["cod_bulto"]."' and num_bulto=".$Fila1["num_bulto"]."	";
						$Actualizar.=" and fecha_creacion_lote='".$Fila1["fecha_creacion_lote"]."' and corr_enm='".$IE."'	";
						$Actualizar.=" and cod_paquete='".$arreglo[0]."' and num_paquete between '".$arreglo[1]."'	and '".$arreglo[3]."'		";
						//echo $Actualizar."<br>";
						mysqli_query($link, $Actualizar);
					}
				}
			}	
			header("location:sec_adm_lotes.php?CmbAno=".$AnoLote."&Mostrar=S&Mensaje=".$Mensaje."&Mensaje2=".$Mensaje2."&Mes=".$CmbCodBulto."&Mostrar2=S");
		break;
		case "CambioGrupo":
			$datos = explode("@@",$ValoresAux);
			reset($datos); 
			//foreach($datos as $clave => $valor)//arreglo[0]:cod_paquete;arreglo[1]:num_paquete;arreglo[2]:Fecha_creacion_paquete
			foreach ($datos as $clave => $valor)
			{
				$arreglo=explode("//",$valor);
				$Actualizar="UPDATE sec_web.paquete_catodo set cod_grupo='".$CmbGrupo."'  ";			
				$Actualizar.="	where cod_paquete='".$arreglo[0]."' and num_paquete='".$arreglo[1]."' and fecha_creacion_paquete='".$arreglo[2]."'	";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
				echo "<script languaje='JavaScript'>";
				echo "window.opener.document.frmConsulta.action='sec_detalle_paquete.php?Ano=".$AnoAux."&NumI=".$NumIAux."&NumF=".$NumFAux."&MesI=".$MesIAux."&Codigo=".$CodLote."&Numero=".$NumLote."&Mostrar=S';";
				echo "window.opener.document.frmConsulta.submit();";
				echo "window.close();";
				echo "</script>";
			}
			
		break;
		case "MarcaCatodos":
			/*echo "mesuno".$Mes01."<br>";
			echo "Cod Bulto".$NumBulto01."<br>";
			echo "mesdos".$Mes02."<br>";
			echo "paquete i".$NumPaqueteI01."<br>";
			echo "paquete f".$NumPaqueteF01."<br>";*/
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmProceso.action='sec_conf_inicial_lotes.php?Mostrar=S&Marquita=".$Marca."&Mes01=".$Mes01."&NumBulto01=".$NumBulto01."&Mes02=".$Mes02."&NumPaqueteI01=".$NumPaqueteI01."&NumPaqueteF01=".$NumPaqueteF01."&Ver=N';";
			echo "window.opener.document.FrmProceso.submit();";
			echo "window.close();";
			echo "</script>";
		break;
	}		
?>