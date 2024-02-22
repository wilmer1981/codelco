<?php
switch($Opt)
{
	case "Procesar":
		include("../principal/conectar_principal.php");
		$FechaActual = $FechaSeleccionada;
		$YearMonthDay = explode('-',$FechaActual);
		$HoraActual = date('G:i:s');		  
		$Fechahora = $FechaActual." ".$HoraActual;		  
		$Num_Paquete=$NumPaquete;
		$Cod_Paquete=$CodPaquete;
		$PesoProd = $PesoProdIngresado;
		   
		//-------------------------------
		//DESPUNTES Y LAMINAS (BARRIDO N.E.).
		$Consulta = "SELECT IFNULL(count(*),0) AS unidades, IFNULL(sum(peso_produccion),0) AS peso FROM sec_web.produccion_catodo";
		$Consulta = $Consulta . " WHERE cod_producto = '48' AND cod_subproducto = '10'";
		$Consulta = $Consulta . " AND fecha_produccion = '" . $FechaActual . "' and peso_produccion='". $PesoProd ."'";
echo $Consulta."<br>";
		$result_set = mysqli_query($link, $Consulta);
		if($FilaP=mysqli_fetch_assoc($result_set))
		{	
echo "entro ".$FilaP["unidades"]."<br>";
			    if($FilaP["unidades"] <> 0)
				{
					//Obtener la serie para generar la hornada.
					$Consulta = "SELECT cod_subclase, nombre_subclase FROM proyecto_modernizacion.sub_clase";
					$Consulta = $Consulta . " WHERE cod_clase = '3004' AND cod_subclase = Month('".$FechaActual."')";
					$result_set2 = mysqli_query($link, $Consulta);
					if($Fila=mysqli_fetch_assoc($result_set2))
					{
						$Cod_Paquete = $Fila["nombre_subclase"];
					
						//Serie de Incio.
						$Consulta = "SELECT valor_subclase1 AS valor1, valor_subclase2 AS valor2";
						$Consulta = $Consulta . " FROM proyecto_modernizacion.sub_clase";
						$Consulta = $Consulta . " WHERE cod_clase = '3013' AND cod_subclase = '3'";
						$result_set3 = mysqli_query($link, $Consulta);
						if($Fila4=mysqli_fetch_assoc($result_set3))
						{
							$Consulta = "SELECT CASE WHEN IFNULL(MAX(num_paquete),0) = 0 THEN " . $Fila4["valor1"] . " ELSE (MAX(num_paquete)+1) END AS num_paquete ";
							$Consulta = $Consulta . " FROM sec_web.paquete_catodo";
							$Consulta = $Consulta . " WHERE SUBSTRING(fecha_creacion_paquete,1,4) = SUBSTRING('".$FechaActual."',1,4)";
							$Consulta = $Consulta . " AND cod_paquete = '" . $Cod_Paquete . "'";
							$Consulta = $Consulta . " AND num_paquete BETWEEN '" . $Fila4["valor1"] . "' AND '" . $Fila4["valor2"] . "'";
							echo $Consulta."<br>";
							$result_set4 = mysqli_query($link, $Consulta);
							if($Fila=mysqli_fetch_assoc($result_set4))
								$Num_Paquete = $Fila["num_paquete"];
						}
					}
			
					//$Num_Paquete=1039;
					//$Cod_Paquete="B";
					$Num_Paquete=$NumPaquete;
					$Cod_Paquete=$CodPaquete;
					//Genera Hornada.
					$Hornada = $YearMonthDay[0].$YearMonthDay[1].$Num_Paquete.$YearMonthDay[1];
					
					//Inserta en Lote Catodo.
					$Insertar = "INSERT INTO sec_web.lote_catodo (cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,fecha_creacion_paquete,corr_enm,cod_estado,disponibilidad)";
					$Insertar = $Insertar . " VALUES ('" . $Cod_Paquete . "','" . $Num_Paquete . "','" . $Cod_Paquete . "','" . $Num_Paquete."'";
					$Insertar = $Insertar . ",'" . $FechaActual . "','" . $FechaActual . "','" . $Hornada . "','c','T')";
					echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
					
					//Inserta en Paquete Catodo.
					$Insertar = "INSERT INTO sec_web.paquete_catodo (cod_existencia,cod_paquete,num_paquete,fecha_creacion_paquete,cod_producto,cod_subproducto,cod_estado,num_unidades,peso_paquetes,hora)";
					$Insertar = $Insertar . " VALUES ('05','" . $Cod_Paquete . "','" . $Num_Paquete . "','" . $FechaActual . "','48','10','c','" . $FilaP["unidades"] . "','" . $FilaP["peso"] . "','" . $HoraActual . "')";
					echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
					
					//Insertar en Traspaso (Unico Producto con Traspaso Director a Raf).
					$Insertar = "INSERT INTO sec_web.traspaso (hornada, fecha_traspaso, peso, unidades, fecha_creacion_lote, cod_producto, cod_subproducto, cod_bulto, num_bulto, sw)";
					$Insertar = $Insertar . " VALUES ('" . $Hornada . "','" . $FechaActual . "','" . $FilaP["peso"]."'";
					$Insertar = $Insertar . ",'" . $FilaP["unidades"] . "','" . $FechaActual . "','48','10'";
					$Insertar = $Insertar . ",'" . $Cod_Paquete . "','" . $Num_Paquete . "','1')";
					echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
					
					$Insertar = "INSERT INTO sec_web.det_traspaso (hornada,cod_paquete,num_paquete,fecha_creacion_paquete,peso_paquete)";
					$Insertar = $Insertar . " VALUES ('" . $Hornada . "','" . $Cod_Paquete . "','" . $Num_Paquete . "','" . $FechaActual . "','" . $FilaP["peso"] . "')";
					echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
					
					//Insertar en movimientos del sea(Unico producto con traspaso directo a raf)
					$Insertar = "INSERT INTO sea_web.movimientos (tipo_movimiento,cod_producto,cod_subproducto,hornada,numero_recarga,fecha_movimiento,campo1,campo2,unidades,flujo,peso,hora)";
					$Insertar = $Insertar . " VALUES ('1','48','10','" . $Hornada . "','0','" . $FechaActual . "','9999','9999','" . $FilaP["unidades"] . "','442','" . $FilaP["peso"] . "','" . $Fechahora . "')";
					echo $Insertar."<br>";
					mysqli_query($link, $Insertar);				
			}
					
		}
else
{ echo "No hay coincidentes";}	
	break;
	default:
		?>
        <script>
		function Procesa(){
		var f = document.Frm;
		f.action = "traspaso_cobre_sucio.php?Opt=Procesar";
		f.submit();}
		</script>
        <DIV id=popCal style=" background-color:#FFF;BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
        BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute; z-index:12;" onclick=event.cancelBubble=true>
        <IFRAME name=popFrame src="../principal/popcjs.htm" frameBorder=0 width=170 scrolling=no height=180></IFRAME></DIV>
		<form name="Frm" id="Frm" action="" method="post">	
            <div align="center">Traspaso CU Sucio</div>
            <div align="center"><br />
            <label for="FechaSeleccionada">Fecha a Procesar</label>
            <input type="text" size="9" readonly maxlength="10" name="FechaSeleccionada" id="FechaSeleccionada"  class="InputDer" value='<?php echo $FechaSeleccionada?>' onClick="popFrame.fPopCalendar(FechaSeleccionada,FechaSeleccionada,popCal);return false"/>
            </div>
            <div align="center">
            <label for="COD PAQUETE">COD. PAQUETE</label>
            <input type="text" size="9" maxlength="10" name="CodPaquete" id="CodPaquete"  class="InputDer"/>
            </div>
            <div align="center">
            <label for="NUM PAQUETE">NUM. PAQUETE</label>
            <input type="text" size="9" maxlength="10" name="NumPaquete" id="NumPaquete"  class="InputDer"/>
            </div>
            <div align="center">
            <label for="PesoProdSeleccionado">Peso a Procesar</label>
            <input type="text" size="9" maxlength="10" name="PesoProdIngresado" id="PesoProdIngresado"  class="InputDer"/>
            </div>
            <div align="center"><br /><button type="button" onclick="Procesa();">Procesar</button></div>
		</form>
		<?php
	break;
}
?>