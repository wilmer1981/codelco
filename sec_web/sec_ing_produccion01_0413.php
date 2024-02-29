<?php
	include("../principal/conectar_sec_web.php");
	
	//Asigna a un arreglo los codigos de paqutes.
	$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 3004";

	$rs = mysqli_query($link, $consulta);
	$cod_paq = array();
	while ($row = mysqli_fetch_array($rs))
	{
		$cod_paq[$row["cod_subclase"]] = $row["nombre_subclase"];
	}	      

	if ($proceso == "B") //Busqueda de Recepciones.
	{
		$fecha = $ano.'-'.$mes.'-'.$dia;
						//'".str_pad($txtlote,8,'0',STR_PAD_LEFT)."'
		$consulta = "SELECT * FROM sec_web.recepcion_catodo_externo";
		$consulta.= " WHERE lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND recargo = '".$txtrecargo."'";
		//echo "CCCC".$consulta;
		$rs = mysqli_query($link, $consulta);
		//echo $consulta."<br>";
		
		if ($row = mysqli_fetch_array($rs))
		{
			$linea = "existe_sec=S&existe_rec=S&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo;
			//$linea.= "&txtpeso=".$row[peso_recepcion]."&txtguia=".$row["num_guia"]."&txtpatente=".$row[patente_camion]."&txtorigen=".$row[peso_origen];
			//$linea.= "&txtrut=".$row["rut_proveedor"];
		}
		else
		{ 
			$consulta = "SELECT * FROM sipa_web.recepciones";
			$consulta.= " WHERE lote = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND recargo = '".$txtrecargo."' AND cod_subproducto = '18'";
			//echo $consulta."<br>";
			
			$rs1 = mysqli_query($link, $consulta);
			if ($row1 = mysqli_fetch_array($rs1))
			{
				$linea = "existe_rec=S&existe_sec=N&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo;
				$linea.= "&txtguia=".$row1["guia_despacho"]."&txtpatente=".$row1[patente]."&txtorigen=".$row1["peso_neto"];
				$linea.= "&txtrut=".$row1["rut_prv"];
			}
			else			
				$linea = "existe_sec=N&existe_rec=N&mensaje=El Lote No Existe";
				
		}
	
		$linea.= "&recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.="&cmbsubproducto=".$cmbsubproducto."&mostrar=S&ano=".$ano."&mes=".$mes."&dia=".$dia;
		$linea.= "&peso_auto=".$peso_auto."&hh=".$hh."&mm=".$mm;
		header("Location:sec_ing_produccion_0413.php?".$linea);
	}
	
	if ($proceso == "B2") //Busqueda de recepciones. (Para Modificar por Lote).
	{
					
		$consulta = "SELECT * FROM sec_web.recepcion_catodo_externo";		
		$consulta.= " WHERE lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."'";
		
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		$fecha = explode("-",$row[fecha_recepcion]); //0: año, 1:mes, 2: dia.
						
		$linea.= "txtpeso=".$row[peso_recepcion]."&txtguia=".$row["num_guia"]."&txtpatente=".$row[patente_camion]."&txtrecargo=".$row["recargo"];
		$linea.= "&txtorigen=".$row[peso_origen]."&txtrut=".$row["rut_proveedor"]."&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtzuncho=".$row[peso_zuncho];
		$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.= "&cmbsubproducto=".$cmbsubproducto."&mostrar=S&ano=".$fecha[0]."&mes=".$fecha[1]."&dia=".$fecha[2];
		$linea.= "&opcion=M&tipo_reg=L";
		header("Location:sec_ing_produccion_0413.php?".$linea);	
	}
	
	if ($proceso == "B3") //Busqueda de recepciones. (Para Modificar por Paquetes de Lote de Origen).
	{	
		//echo $parametros."<br>";
		
		$vector = explode("/",$parametros); //0: lote_origen, 1: cod_paquete, 2: num_paquete, 3: fecha_creacion, 4: recargo. 
		$fecha = explode("-",$vector[3]); //0: ano, 1: mes, 2: dia.
		
		$consulta = "SELECT t1.lote_origen, t1.recargo, t1.cod_paquete, t1.num_paquete, t2.num_unidades,t2.peso_paquetes,t2.cod_estado,t2.hora";
		$consulta.= " FROM sec_web.paquete_catodo_externo AS t1";
		$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
		$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete";
		$consulta.= " AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
		$consulta.= " AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto"; 		
		$consulta.= " WHERE t1.cod_paquete = '".$vector[1]."' AND t1.num_paquete = '".$vector[2]."'";
		$consulta.= " AND t1.fecha_creacion_paquete = '".$vector[3]."' AND t1.lote_origen = '".$vector[0]."' AND t1.recargo = '".$vector[4]."'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		
		$hh_mm = explode(':', $row[hora]); //0: hora, 1: minuto.
		
		$linea = "";
		
		//consulta la instruccion.
		$consulta = "SELECT * FROM sec_web.lote_catodo";
		$consulta.= " WHERE cod_paquete = '".$vector[1]."' AND num_paquete = '".$vector[2]."' AND cod_estado = 'a'";
		$rs1 = mysqli_query($link, $consulta);
		if ($row1 = mysqli_fetch_array($rs1))
			$linea = "cmbinstruccion=".$row1["corr_enm"]."&txtmarca=".$row1["cod_marca"]."&cmbcodlote=".$row1["cod_bulto"]."&txtnumlote=".$row1["num_bulto"];
		
		//Consulta el peso programado de la Instruccion.
		$consulta = "SELECT * FROM sec_web.programa_codelco";
		$consulta.= " WHERE corr_codelco = '".$row1["corr_enm"]."' AND estado1 = 'R' AND estado2 != 'C'"; //****** Falta condicion, para saber si esta activo � no la Instruccion.
		//echo $consulta."<br>";
		
		$rs2 = mysqli_query($link, $consulta);
		if ($row2 = mysqli_fetch_array($rs2)) //Codelco.
		{
			$linea.= "&txtpesoprog=".($row2["cantidad_programada"] * 1000)."&listar_ie=P";
		}
		else 
		{	
			$consulta = "SELECT * FROM sec_web.programa_enami";
			$consulta.= " WHERE corr_enm = '".$row1["corr_enm"]."' AND estado1 = 'R' AND estado2 != 'C'"; //****** Falta condicion, para saber si esta activo � no la Instruccion.

			$rs3 = mysqli_query($link, $consulta);
			
			if ($row3 = mysqli_fetch_array($rs3)) //Enami.
				$linea.= "&txtpesoprog=".($row3[cantidad_embarque] * 1000)."&listar_ie=P";
			else
			{	
				$consulta = "SELECT * FROM sec_web.instruccion_virtual";
				$consulta.= " WHERE corr_virtual = '".$row1["corr_enm"]."'";
				//echo $consulta."<br>";
				$rs4 = mysqli_query($link, $consulta);
				$row4 = mysqli_fetch_array($rs4);
				
				$linea.= "&txtpesoprog=".$row4["peso_programado"]."&listar_ie=V";
			}
		}										
						
		$linea.= "&txtlote=".$vector[0]."&txtrecargo=".$vector[4]."&cmbcodpaq=".$vector[1]."&txtnumpaq=".$vector[2]."&ano=".$fecha[0]."&mes=".$fecha[1]."&dia=".$fecha[2];
		$linea.= "&txtunidades=".$row["num_unidades"]."&txtpeso=".$row["peso_paquetes"];
		$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&recargapag4=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.= "&cmbsubproducto=".$cmbsubproducto."&mostrar=S&encontro_ie=S";
		$linea.= "&opcion=M&tipo_reg=P&hh=".$hh_mm[0]."&mm=".$hh_mm[1];
		header("Location:sec_ing_produccion_0413.php?".$linea);		
	}
	
	if ($proceso == "B4") //Busqueda de Produccion. (Para Modificar Muestra).
	{		
		$vector = explode("/",$parametros); //0: cod_grupo, 1: fecha.
		$fecha = explode("-",$vector[1]); //0: ano, 1: mes, 2: dia.
		$ano= $fecha[0];
		$mes= $fecha[1];
		$dia = $fecha[2];
		
		$Fecha2 =date("Y-m-d", mktime(1,0,0,$mes,($dia + 1),$ano));	
		
	
		
	//echo "FE2".$Fecha2."<br>";
	$Fecha2 = "$Fecha2 07:59:59"; 
		
		
		
		$consulta = "SELECT * FROM sec_web.produccion_catodo";
		$consulta.= " WHERE cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND fecha_produccion =  '".$vector[1]."'  AND cod_grupo = '".$vector[0]."'";

		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		
		$hh_mm = explode(':', $row[hora]); //0: hora, 1:minuto.
		
		$linea = "txtgrupo=".$vector[0]."&txtmuestra=".$row[cod_muestra]."&txtpeso=".$row["peso_produccion"];
		$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.= "&ano=".$fecha[0]."&mes=".$fecha[1]."&dia=".$fecha[2];
		$linea.= "&cmbsubproducto=".$cmbsubproducto."&mostrar=S";
		$linea.= "&opcion=M&hh=".$hh_mm[0]."&mm=".$hh_mm[1];		
		//echo "LL".$linea;
		header("Location:sec_ing_produccion_0413.php?".$linea);
	}
	
	if ($proceso == "B5") //Busqueda de Produccion. (Para Modificar grupo-cuba-lado).
	{
		//echo $parametros."<br>";
		
		$vector = explode("/",$parametros); //0: cod_grupo, 1: cuba, 2: lado, 3: fecha.
		$fecha = explode("-",$vector[3]); //0: ano, 1: mes, 2: dia.
		
		if ($vector[0] == 99)
		{
			$consulta = "SELECT * FROM sec_web.produccion_desc_normal";
			$consulta.= " WHERE cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$consulta.= " AND fecha_produccion = '".$vector[3]."' AND cod_grupo = '".$vector[0]."'";
			$consulta.= " AND cod_cuba = '".$vector[1]."' AND cod_lado = '".$vector[2]."'";		
		}
		else
		{
			$consulta = "SELECT * FROM sec_web.produccion_catodo";
			$consulta.= " WHERE cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			$consulta.= " AND fecha_produccion = '".$vector[3]."' AND cod_grupo = '".$vector[0]."'";
			$consulta.= " AND cod_cuba = '".$vector[1]."' AND cod_lado = '".$vector[2]."'";
		}
		
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);

		$hh_mm = explode(':', $row[hora]); //0: hora, 1:minuto.		
		
		$linea = "txtgrupo=".$vector[0]."&txtmuestra=".$row[cod_muestra]."&txtpeso=".$row["peso_produccion"]."&txtcuba=".$row[cod_cuba];
		$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;		
		$linea.= "&ano=".$fecha[0]."&mes=".$fecha[1]."&dia=".$fecha[2];
		$linea.= "&cmbsubproducto=".$cmbsubproducto."&mostrar=S&txtlado=".$row["cod_lado"];
		$linea.= "&opcion=M&hh=".$hh_mm[0]."&mm=".$hh_mm[1];
		header("Location:sec_ing_produccion_0413.php?".$linea);		
	}
	
	if ($proceso == "B6") //Busqueda de Paquetes. (Para Modificar Paquetes).
	{	
		//echo $parametros."<br>";
			
		$vector = explode("/",$parametros); //0: cod_paquete, 1: num_paquete, 2: fecha.
		$fecha = explode("-",$vector[2]); //0: ano, 1: mes, 2: dia.
		
		$consulta = "SELECT * FROM sec_web.paquete_catodo";
		$consulta.= " WHERE cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND cod_paquete = '".$vector[0]."' AND num_paquete = '".$vector[1]."'";
		$consulta.= " AND fecha_creacion_paquete = '".$vector[2]."'";
		//echo $consulta."<br>";
		
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		
		$hh_mm = explode(':', $row[hora]); //0: hora, 1:minuto.
				
		$linea.= "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;		
		$linea.= "&ano=".$fecha[0]."&mes=".$fecha[1]."&dia=".$fecha[2];
		$linea.= "&cmbsubproducto=".$cmbsubproducto."&mostrar=S";
		$linea.= "&opcion=M&hh=".$hh_mm[0]."&mm=".$hh_mm[1];
		$linea.= "&cmbcodpaq=".$vector[0]."&txtnumpaq=".$vector[1]."&cmbgrupo=".$row["cod_grupo"]."&cmbcuba=".$row[cod_cuba];		
		$linea.= "&txtunidades=".$row["num_unidades"]."&txtpeso=".$row["peso_paquetes"];
		header("Location:sec_ing_produccion_0413.php?".$linea);		
	}
	
	
	if ($proceso == "B7") //Busca I.E en programa_enami � programa_codelco � Virtual.
	{
		if ($listar_ie == "P")
		{		
			//Primero, Si existe en Programa_enami. (Para seguir agregando paquetes).		
			$consulta = "SELECT * FROM sec_web.programa_enami";
			$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado1 = 'R' AND (estado2 = 'P' OR estado2 = 'A' OR estado2 = 'M')";
			$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";			
			// echo "111".$consulta."<br>";
		
			$rs2 = mysqli_query($link, $consulta);
			if ($row2 = mysqli_fetch_array($rs2))
			{	
				//mostrar datos y el paquete correlativo correspondiente.
				$linea = "txtpesoprog=".($row2[cantidad_embarque] * 1000)."&encontro_ie=S&mensaje=".$row2["descripcion"];
				
				//consulta el ultimo paquete de la I.E.
				$consulta = "SELECT * FROM sec_web.lote_catodo";
				$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND disponibilidad = 'P'";
				$consulta.= " ORDER BY num_paquete DESC";
				$consulta.= " LIMIT 0,1";
				
				// echo "222".$consulta;
				$rs4 = mysqli_query($link, $consulta);
				$row4 = mysqli_fetch_array($rs4);
				
				$linea.= "&cmbcodlote=".$row4["cod_bulto"]."&txtnumlote=".$row4["num_bulto"]."&cmbcodpaq=".$row4["cod_paquete"]."&txtnumpaq=".($row4["num_paquete"]+1);
				$linea.= "&txtmarca=".$row4["cod_marca"]."&agrega_paq=S"; //Solo si existe.
				
				if ($cmbproducto == 64 and ($cmbsubproducto == 8 or $cmbsubproducto == 7))
				{
					$linea.= "&activa_sipa=S"; 
					
					//Unidad.
					$consulta = "SELECT cod_subclase FROM sec_web.lote_catodo AS t1";
					$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
					$consulta.= " ON t1.unidad = t2.cod_subclase";
					$consulta.= " WHERE t2.cod_clase = '3015' AND corr_enm = '".$cmbinstruccion."'";
					$consulta.= " AND cod_bulto = '".$row4["cod_bulto"]."' AND num_bulto = '".$row4["num_bulto"]."' AND disponibilidad = 'P'";
					$consulta.= " LIMIT 0,1";
					// echo "333".$consulta."<br>";
					$rs5 = mysqli_query($link, $consulta);
					if ($row5 = mysqli_fetch_array($rs5))
					{
						$linea.= "&cmbmedida=".$row5["cod_subclase"];
					}
				}				
			}
			else
			{	
				//Primero, Si existe en Programa_codelco. (Para seguir agregando paquetes).		
				$consulta = "SELECT * FROM sec_web.programa_codelco";
				$consulta.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado1 = 'R' AND (estado2 = 'P' OR estado2 = 'A' OR estado2 = 'M')";
				$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";		
				// echo "444".$consulta."<br>";
				$rs3 = mysqli_query($link, $consulta);
				if ($row3 = mysqli_fetch_array($rs3))
				{
					//mostrar datos y el paquete correlativo correspondiente.
					$linea = "txtpesoprog=".($row3["cantidad_programada"] * 1000)."&encontro_ie=S&mensaje=".$row3["descripcion"];
					
					//consulta el ultimo paquete de la I.E.
					$consulta = "SELECT * FROM sec_web.lote_catodo";
					$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND disponibilidad = 'P'";
					$consulta.= " ORDER BY num_paquete DESC";
					$consulta.= " LIMIT 0,1";
					
					// echo "555".$consulta;
					$rs4 = mysqli_query($link, $consulta);
					$row4 = mysqli_fetch_array($rs4);
					
					$linea.= "&cmbcodlote=".$row4["cod_bulto"]."&txtnumlote=".$row4["num_bulto"]."&cmbcodpaq=".$row4["cod_paquete"]."&txtnumpaq=".($row4["num_paquete"]+1);
					$linea.= "&txtmarca=".$row4["cod_marca"]."&agrega_paq=S"; //Solo si existe.
					
					if ($cmbproducto == 64 and ($cmbsubproducto == 8 or $cmbsubproducto == 7))
					{
						$linea.= "&activa_sipa=S"; 
					}					
				}
				else
				{
					//Verifica si es nuevo en el programa.
				
					$consulta = "SELECT * FROM sec_web.programa_enami";
					$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado1 = '' AND estado2 NOT IN ('A','C') AND NOT ISNULL(num_prog_loteo)";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					// echo "666".$consulta."<br>";
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs)) //Existe en Enami.
					{
						$linea = "txtpesoprog=".($row[cantidad_embarque] * 1000)."&encontro_ie=S&mensaje=".$row["descripcion"];
					}
					else	
					{
						$consulta = "SELECT * FROM sec_web.programa_codelco";
						$consulta.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado1 = '' AND estado2 NOT IN ('A','C') AND NOT ISNULL(num_prog_loteo)";
						$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
						// echo "777".$consulta."<br>";
						$rs1 = mysqli_query($link, $consulta);
						if ($row1 = mysqli_fetch_array($rs1)) //Existe en Codelco.
						{
							$linea = "txtpesoprog=".($row1["cantidad_programada"] * 1000)."&encontro_ie=S&mensaje=".$row1["descripcion"];
						}
						else //No Existe.
						{
							$linea.= "txtpesoprog=&encontro_ie=N";
						}			
					}				
				}			
			}
			
			$linea.= "&tipo_ie=P"; //Del Programa.
		}
		else //Virtual.
		{
			$consulta = "SELECT * FROM sec_web.instruccion_virtual";
			$consulta.= " WHERE corr_virtual = '".$cmbinstruccion."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
			// echo "888".$consulta."<br>";
			$rs = mysqli_query($link, $consulta);
			if ($row = mysqli_fetch_array($rs))
			{
				//mostrar datos y el paquete correlativo correspondiente.
				$linea = "txtpesoprog=".$row["peso_programado"]."&encontro_ie=S";
	
				if ($cmbproducto == 64 and ($cmbsubproducto == 8 or $cmbsubproducto == 7))
				{
					$linea.= "&activa_sipa=S"; 

					//Unidad.
					$consulta = "SELECT cod_subclase FROM sec_web.lote_catodo AS t1";
					$consulta.= " INNER JOIN proyecto_modernizacion.sub_clase AS t2";
					$consulta.= " ON t1.unidad = t2.cod_subclase";
					$consulta.= " WHERE t2.cod_clase = '3015' AND corr_enm = '".$cmbinstruccion."'";
					$consulta.= " AND cod_bulto = '".$row4["cod_bulto"]."' AND num_bulto = '".$row4["num_bulto"]."' AND disponibilidad = 'P'";
					$consulta.= " LIMIT 0,1";
					// echo "999".$consulta."<br>";
					$rs5 = mysqli_query($link, $consulta);
					if ($row5 = mysqli_fetch_array($rs5))
					{
						$linea.= "&cmbmedida=".$row5["cod_subclase"];
					}					
				}
					
				//consulta el ultimo paquete de la I.E.
				$consulta = "SELECT * FROM sec_web.lote_catodo";
				$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND disponibilidad = 'P'";
				$consulta.= " ORDER BY num_paquete DESC";
				$consulta.= " LIMIT 0,1";
				
				// echo "000".$consulta;
				$rs4 = mysqli_query($link, $consulta);
				if ($row4 = mysqli_fetch_array($rs4))
				{
					$linea.= "&cmbcodlote=".$row4["cod_bulto"]."&txtnumlote=".$row4["num_bulto"]."&cmbcodpaq=".$row4["cod_paquete"]."&txtnumpaq=".($row4["num_paquete"]+1);
					$linea.= "&txtmarca=".$row4["cod_marca"]."&agrega_paq=S"; //Solo si existe.	
					// echo "lin 1".$linea;		
				}
			}
			else 
			{
				$linea.= "txtpesoprog=&encontro_ie=N";
			}		
			
			$linea.= "&tipo_ie=V"; //Virtual.
			// echo "lin 2".$linea;
		}
			
		$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.="&cmbsubproducto=".$cmbsubproducto."&mostrar=S&ano=".$ano."&mes=".$mes."&dia=".$dia;
		$linea.= "&peso_auto=".$peso_auto."&hh=".$hh."&mm=".$mm."&cmbinstruccion=".$cmbinstruccion."&listar_ie=".$listar_ie."&recargapag4=S";
		
		if ($cmbmovimiento == 1) 
		//'".str_pad($txtlote,8,'0',STR_PAD_LEFT)."'
			$linea.= "&tipo_reg=P&txtlote=".STR_PAD($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo."&existe_sec=".$existe_sec."&existe_rec=".$existe_rec;
			
		header("Location:sec_ing_produccion_0413.php?".$linea);
	}
	
	
	if ($proceso == "B8") //Valida el Lote.
	{	
		$consulta = "SELECT * FROM sec_web.lote_catodo";
		$consulta.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
		$consulta.= " AND YEAR(fecha_creacion_lote) = YEAR(NOW())";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs)) //Existe el Lote en el año.
		{
			$mensaje = "El Lote Ya Existe";
			
			//*****//
			//mostrar el mensaje y devolver con java.

			echo '<script language="JavaScript">';
			echo 'alert("'.$mensaje.'");';
			echo 'window.history.back()';
			echo '</script>';
			break;			
		}
		else
		{	
			$linea = "txtnumpaq=".$txtnumlote."&cmbcodpaq=".$cod_paq[$cmbcodlote];
		}
		$linea.= "&tipo_ie=".$listar_ie; //Del Programa � Virtual.		
		//echo $tipo_ie."<br>";
		$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.="&cmbsubproducto=".$cmbsubproducto."&mostrar=S&ano=".$ano."&mes=".$mes."&dia=".$dia;
		$linea.= "&peso_auto=".$peso_auto."&hh=".$hh."&mm=".$mm."&cmbinstruccion=".$cmbinstruccion."&encontro_ie=".$encontro_ie;
		$linea.= "&txtpesoprog=".$txtpesoprog."&txtnumlote=".$txtnumlote."&genera_lote=S";
		$linea.= "&paq_inicial=S&peso_prog_ok=".$peso_prog_ok."&cmbcodlote=".$cod_paq[$cmbcodlote];
		$linea.= "&listar_ie=".$listar_ie."&recargapag4=S";
		
		if ($cmbmovimiento == 1)
		
			$linea.= "&tipo_reg=P&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo."&existe_sec=".$existe_sec."&existe_rec=".$existe_rec;
			
		if (($cmbmovimiento == 3) and ($cmbproducto == 57))
		{			
			//echo "aqui:".$etapa;
			$linea.= "&etapa=".$etapa;
		}
		
		if ($cmbproducto == 64 and ($cmbsubproducto == 8 or $cmbsubproducto == 7))
		{
			$linea.= "&activa_sipa=S"; 
		}
					
		header("Location:sec_ing_produccion_0413.php?".$linea);				
	}
	
	//---.
	if ($proceso == "B9") //Busca I.E en programa_enami � programa_codelco � Virtual (Solo para los Lodos).
	{	
		if ($listar_ie == "P")
		{
			$consulta = "SELECT *";
			$consulta.= " FROM sec_web.pesaje_lodos";
			$consulta.= " WHERE corr_ie = '".$cmbinstruccion."'";
			$consulta.= " AND cod_estado = 'P'";
			$consulta.= " GROUP BY corr_ie,cod_bulto,num_bulto,cod_paquete,num_paquete";
			$consulta.= " HAVING COUNT(*) = 1";
			$consulta.= " ORDER BY cod_paquete,num_paquete";
			$consulta.= " LIMIT 0,1";
			$rs1 = mysqli_query($link, $consulta);
			//echo $consulta."<br>";
			if ($row1 = mysqli_fetch_array($rs1))
			{
				$linea.= "cmbcodlote=".$row1["cod_bulto"]."&txtnumlote=".$row1["num_bulto"]."&txtmarca=".$row1["marca"];
				$linea.= "&cmbcodpaq=".$row1["cod_paquete"]."&numpaq=".$row1["num_paquete"]."&fecha_pesaje_lodo=".$row1[fecha_pesaje];
				$linea.= "&txtunidades=".$row1["unidades"]."&txtpesotara=".$row1["peso_tara"]."&txtpesoneto=".$row1["peso_neto"];
				$linea.= "&opcion=L"; //Modifica el peso del Lodo.(2� Pesaje)
				$linea.= "&tipo_ie=P"; //Virtual.
			}					
		}
		else //Virtual.
		{				
			$consulta = "SELECT *";
			$consulta.= " FROM sec_web.pesaje_lodos";
			$consulta.= " WHERE corr_ie = '".$cmbinstruccion."'";
			$consulta.= " AND cod_estado = 'V'";
			$consulta.= " GROUP BY corr_ie,cod_bulto,num_bulto,cod_paquete,num_paquete";
			$consulta.= " HAVING COUNT(*) = 1";
			$consulta.= " ORDER BY cod_paquete,num_paquete";
			$consulta.= " LIMIT 0,1";
			$rs1 = mysqli_query($link, $consulta);
			//echo $consulta."<br>";
			if ($row1 = mysqli_fetch_array($rs1))
			{
				$linea.= "cmbcodlote=".$row1["cod_bulto"]."&txtnumlote=".$row1["num_bulto"]."&txtmarca=".$row1["marca"];
				$linea.= "&cmbcodpaq=".$row1["cod_paquete"]."&numpaq=".$row1["num_paquete"]."&fecha_pesaje_lodo=".$row1[fecha_pesaje];
				$linea.= "&txtunidades=".$row1["unidades"]."&txtpesotara=".$row1["peso_tara"]."&txtpesoneto=".$row1["peso_neto"];
				$linea.= "&opcion=L"; //Modifica el peso del Lodo.(2� Pesaje).
				$linea.= "&tipo_ie=V"; //Virtual.				
			}							
		}
			
		$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.="&cmbsubproducto=".$cmbsubproducto."&mostrar=S&ano=".$ano."&mes=".$mes."&dia=".$dia."&encontro_ie=S";
		$linea.= "&peso_auto=".$peso_auto."&hh=".$hh."&mm=".$mm."&cmbinstruccion=".$cmbinstruccion."&listar_ie=".$listar_ie."&recargapag4=S";
		
		if ($cmbmovimiento == 1) 
		
			$linea.= "&tipo_reg=P&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo."&existe_sec=".$existe_sec."&existe_rec=".$existe_rec;
			
		header("Location:sec_ing_produccion_0413.php?".$linea);
	}
	//---.
	
	if ($proceso == "B10")
	{
		$vector = explode("/",$parametros); //0: fecha, 1:hora.
		$fecha = explode("-",$vector[0]); //0:ano, 1:mes, 2:dia.
		
		$linea.= "recargapag1=S&recargapag2=S&recargapag3=S";
		$linea.= "&cmbmovimiento=2&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto;
		$linea.= "&ano=".$fecha[0]."&mes=".$fecha[1]."&dia=".$fecha[2]."&hora_aux=".$vector[1]."&mostrar=S&opcion=M";
		
		$consulta = "SELECT * FROM sec_web.produccion_catodo";
		$consulta.= " WHERE cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND fecha_produccion = '".$vector[0]."' AND hora = '".$vector[1]."'";
		//echo "Con".$consulta;
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$linea.= "&txtpeso=".$row["peso_produccion"];
			
			if (($cmbproducto == 57) or ($cmbproducto == 64) or ($cmbproducto == 66))
				$linea.= "&txtpesotara=".$row["peso_tara"];
		}

		header("Location:sec_ing_produccion_0413.php?".$linea);
	}
	
	//Busca Serie de la 2� Pesada de los Lodos.
	if ($proceso == "B11")
	{		
		//Verifica en lote_catodo si el paquete pertenece al Lote.
		$consulta = "SELECT * FROM sec_web.lote_catodo";
		$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";		
		$consulta.= " AND cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."' AND cod_estado = 'a'";
		//echo $consulta."<br>";
		
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			//Entrega Datos para la 2� Pesada.

			$consulta = "SELECT *";
			$consulta.= " FROM sec_web.pesaje_lodos";
			$consulta.= " WHERE corr_ie = '".$cmbinstruccion."'";
			$consulta.= " AND cod_bulto = '".$row["cod_bulto"]."' AND num_bulto = '".$row["num_bulto"]."'";
			$consulta.= " AND cod_paquete = '".$row["cod_paquete"]."' AND num_paquete = '".$row["num_paquete"]."'";
			$consulta.= " GROUP BY corr_ie,cod_bulto,num_bulto,cod_paquete,num_paquete";
			$consulta.= " HAVING COUNT(*) = 1";
			$consulta.= " ORDER BY cod_paquete,num_paquete";
			$consulta.= " LIMIT 0,1";
			//echo $consulta."<br>";
			
			$rs1 = mysqli_query($link, $consulta);
			if ($row1 = mysqli_fetch_array($rs1))
			{
				$linea.= "cmbcodlote=".$row1["cod_bulto"]."&txtnumlote=".$row1["num_bulto"]."&txtmarca=".$row1["marca"];
				$linea.= "&cmbcodpaq=".$row1["cod_paquete"]."&numpaq=".$row1["num_paquete"]."&fecha_pesaje_lodo=".$row1[fecha_pesaje];
				$linea.= "&txtunidades=".$row1["unidades"]."&txtpesotara=".$row1["peso_tara"]."&txtpesoneto=".$row1["peso_neto"];
				$linea.= "&opcion=L"; //Modifica el peso del Lodo.(2� Pesaje)
				
				$linea.= "&cmbinstruccion=".$row1["corr_ie"];		
			}
			else
			{
				//La 2� Pesada ya se realizo.
				$mensaje = "Ya Se Realizo La 2� Pesada De Esta Serie";
				
				echo '<script language="JavaScript">';
				echo 'alert("'.$mensaje.'");';
				echo 'window.history.back()';
				echo '</script>';
				break;
			}
			
			$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			$linea.="&cmbsubproducto=".$cmbsubproducto."&mostrar=S&ano=".$ano."&mes=".$mes."&dia=".$dia;
			$linea.= "&peso_auto=".$peso_auto."&hh=".$hh."&mm=".$mm."&listar_ie=".$listar_ie."&recargapag4=S&encontro_ie=S";

			header("Location:sec_ing_produccion_0413.php?".$linea);	
		}
		else 
		{
			$mensaje = "La Serie del Paquete No Existe en la Confeccion del Lote";
			
			echo '<script language="JavaScript">';
			echo 'alert("'.$mensaje.'");';
			echo 'window.history.back()';
			echo '</script>';
			break;			
		} 	
	}		
	
	if ($proceso == "B12")
	{
		//Cambiar estados en lote_catodo.
		$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = 'T'";
		$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."' AND corr_enm= '".$cmbinstruccion."'";
		$actualizar.= " AND disponibilidad = 'P' AND cod_estado = 'a'";
		mysqli_query($link, $actualizar);		
		//echo $actualizar."<br>";
		
		//Calcular el Peso de la I.E.
		$consulta = "SELECT IFNULL(round(SUM(peso_paquetes)/1000,3),0) AS total FROM sec_web.lote_catodo AS t1";
		$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
		$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete";
		$consulta.= " AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
		$consulta.= " WHERE t1.corr_enm = '".$cmbinstruccion."' AND t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
		$consulta.= " AND t1.disponibilidad = 'T' AND t1.cod_estado = 'a'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
			
		//Canbiar Estados en programa_enami.
		$actualizar = "UPDATE sec_web.programa_enami SET estado2 = 'C', cantidad_embarque = '".$row["total"]."'";
		$actualizar.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado1 = 'R' AND estado2 = 'P'";
		mysqli_query($link, $actualizar);
		//echo $actualizar."<br>";
		
		$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=3&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto;
		header("Location:sec_ing_produccion_0413.php?".$linea);
	}
	
	
	//-----------------------// Graba solamente Lodos.
	if ($proceso == "GL")
	{
		$fecha = $ano.'-'.$mes.'-'.$dia;
			
		//Verifica en lote_catodo si el paquete pertenece al Lote.
		$consulta = "SELECT * FROM sec_web.lote_catodo";
		$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";		
		$consulta.= " AND cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."' AND cod_estado = 'a'";
		//echo $consulta."<br>";
		
		$rs2 = mysqli_query($link, $consulta);
		if ($row2 = mysqli_fetch_array($rs2))
		{
				
			$insertar = "INSERT INTO sec_web.pesaje_lodos (num_pesada,cod_producto,cod_subproducto,corr_ie,cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_pesaje,peso_tara,cod_estado,marca,peso_neto,peso_bruto, unidades)";
			$insertar.= " VALUES ('2','".$cmbproducto."','".$cmbsubproducto."','".$cmbinstruccion."','".$cod_paq[$cmbcodlote]."','".$txtnumlote."','".$cod_paq[$cmbcodpaq]."','".$txtnumpaq."','".$fecha."','".$txtpesotara."','".$listar_ie."','".$txtmarca."','".$txtpesoneto."','".$txtpeso."','".$txtunidades."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);
			
			
			/*
			//Actualiza en Paquete Catodo.
			$consulta = "SELECT * FROM sec_web.paquete_catodo";
			$consulta.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."' AND fecha_creacion_paquete = '".$fecha_lodo."'";		
			//echo $consulta."<br>";			
			
			$rs = mysqli_query($link, $consulta);
			if ($row = mysqli_fetch_array($rs))
			{	
				$actualizar = "UPDATE sec_web.paquete_catodo SET peso_paquetes = '".$txtpeso."'";
				$actualizar.= " WHERE cod_paquete = '".$row["cod_paquete"]."' AND num_paquete = '".$row["num_paquete"]."' AND fecha_creacion_paquete = '".$row[fecha_creacion_paquete]."'";
				//echo $actualizar."<br>";
				mysqli_query($link, $actualizar);
			}
			*/
	
			//Da la Serie consecutiva faltante.		
			$consulta = "SELECT *";
			$consulta.= " FROM sec_web.pesaje_lodos";
			$consulta.= " WHERE corr_ie = '".$cmbinstruccion."'";
			$consulta.= " GROUP BY corr_ie,cod_bulto,num_bulto,cod_paquete,num_paquete";
			$consulta.= " HAVING COUNT(*) = 1";
			$consulta.= " ORDER BY cod_paquete,num_paquete";
			$consulta.= " LIMIT 0,1";
			//echo $consulta."<br>";
			
			$rs1 = mysqli_query($link, $consulta);
			if ($row1 = mysqli_fetch_array($rs1))
			{
				$linea.= "cmbcodlote=".$row1["cod_bulto"]."&txtnumlote=".$row1["num_bulto"]."&txtmarca=".$row1["marca"];
				$linea.= "&cmbcodpaq=".$row1["cod_paquete"]."&numpaq=".$row1["num_paquete"]."&fecha_pesaje_lodo=".$row1[fecha_pesaje];
				$linea.= "&txtunidades=".$row1["unidades"]."&txtpesotara=".$row1["peso_tara"]."&txtpesoneto=".$row1["peso_neto"];
				$linea.= "&opcion=L"; //Modifica el peso del Lodo.(2� Pesaje)
				
				$linea.= "&cmbinstruccion=".$row1["corr_ie"];		
			}
			$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			$linea.="&cmbsubproducto=".$cmbsubproducto."&mostrar=S&ano=".$ano."&mes=".$mes."&dia=".$dia;
			$linea.= "&peso_auto=".$peso_auto."&hh=".$hh."&mm=".$mm."&listar_ie=".$listar_ie."&recargapag4=S&encontro_ie=S";		
			
			header("Location:sec_ing_produccion_0413.php?".$linea);		
		}
		else
		{
			$mensaje = "La Serie del Paquete No Existe en la Confeccion del Lote";
			
			echo '<script language="JavaScript">';
			echo 'alert("'.$mensaje.'");';
			echo 'window.history.back()';
			echo '</script>';
			break;		
		}				
	}
	
	if ($proceso == "ML")
	{
		$fecha = $ano.'-'.$mes.'-'.$dia;
	
		//Primera Pesada.
		if ($cmbsubproducto == '11')
		{
			$actualizar = "UPDATE sec_web.pesaje_lodos SET ";
			$actualizar.= " peso_tara = '".$txtpesotara."',";
			$actualizar.= " peso_bruto = '".$txtpeso."',";
			$actualizar.= " peso_neto = '".$txtpesoneto."',";
			$actualizar.= " unidades = '".$txtunidades."',";
			$actualizar.= " fecha_pesaje = '".$fecha."'";
			$actualizar.= " WHERE cod_producto = '57' AND cod_subproducto = '11' AND num_pesada = '1'";
			$actualizar.= " AND cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
			$actualizar.= " AND cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
			$actualizar.= " AND fecha_pesaje = '".$fecha_aux."'";
			//echo $actualizar."<br>";						
			mysqli_query($link, $actualizar);
		}
		else
		{
			//Segunda Pesada.
			$actualizar = "UPDATE sec_web.pesaje_lodos SET ";
			$actualizar.= " peso_tara = '".$txtpesotara."',";
			$actualizar.= " peso_bruto = '".$txtpeso."',";
			$actualziar.= " peso_neto = '".$txtpesoneto."',";
			$actualziar.= " unidades = '".$txtunidades."'";
			$actualizar.= " WHERE cod_producto = '57' AND cod_subproducto = '12' AND num_pesada = '2'";
			$actualizar.= " AND cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
			$actualizar.= " AND cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
			$actualizar.= " AND fecha_pesaje = '".$fecha_aux."'";
			//echo $actualizar."<br>";			
			mysqli_query($link, $actualizar);
		}
		
		//Paquete Catodo.
		$actualizar = "UPDATE sec_web.paquete_catodo SET ";
		$actualizar.= " fecha_creacion_paquete = '".$fecha."',";
		$actualizar.= " num_unidades = '".$txtunidades."',";
		$actualizar.= " peso_paquetes = '".$txtpesoneto."'";
		$actualizar.= " WHERE cod_producto = '57' AND cod_subproducto = '11'";
		$actualizar.= " AND cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
		$actualizar.= " AND fecha_creacion_paquete = '".$fecha_aux."'";
		//echo $actualizar."<br>";		
		mysqli_query($link, $actualizar);
		
		$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.= "&cmbsubproducto=".$cmbsubproducto;
		$linea.= "&peso_auto=checked";			
		header("Location:sec_ing_produccion_0413.php?".$linea);		
	}
	//------------------------//
	
	
	if ($proceso == "G")
	{
		$fecha = $ano.'-'.$mes.'-'.$dia;
		$hora = date("H").':'.date("i").':'.date("s");
		$flujo = "";
		//echo $cmbproducto."<br>";
		
		if ($cmbmovimiento == "2") //PRODUCCION.
		{		
			if (($cmbproducto == "18") or ($cmbproducto == "48" and $cmbsubproducto != 8 and $cmbsubproducto != 9 and $cmbsubproducto != 3 and $cmbsubproducto != 6 and $cmbsubproducto != 10)) //Catodos y Despuntes y Laminas.
			{
				if (($cmbproducto == "18") and ($cmbsubproducto == "3") and ($txtgrupo == "99"))
				{
					$consulta = "SELECT * FROM sec_web.produccion_desc_normal";
					$consulta.= " WHERE fecha_produccion = '".$fecha."' AND cod_grupo = '".$txtgrupo."' AND cod_cuba = '".$txtcuba."' AND cod_lado = '".$txtlado."'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'"; 
					//echo $consulta."<br>";				
				}
				else
				{
					$consulta = "SELECT * FROM sec_web.produccion_catodo";
					$consulta.= " WHERE fecha_produccion = '".$fecha."' AND cod_grupo = '".$txtgrupo."' AND cod_cuba = '".$txtcuba."' AND cod_lado = '".$txtlado."'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'"; 
					//echo $consulta."<br>";
				}
			}
			else if (($cmbproducto == "57") or ($cmbproducto == "64") or ($cmbproducto == "66") or ($cmbproducto == "48" and ($cmbsubproducto == 8 or $cmbsubproducto == 9 or $cmbsubproducto == 3 or $cmbsubproducto == 6 or $cmbsubproducto == 10))) //Sales � Laminas Aprobadas N.E.
				{
					$consulta = "SELECT * FROM sec_web.produccion_catodo";
					$consulta.= " WHERE fecha_produccion = '".$fecha."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";		
					$consulta.= " AND hora = '".$hora."'";
					//echo $consulta."<br>";
				}
	
			//echo $consulta."<br>";
				
			$rs = mysqli_query($link, $consulta);			
			if ($row = mysqli_fetch_array($rs))
			{				
				$mensaje = "Los Datos Ingresados Ya Existen";
				
				echo '<script language="JavaScript">';
				echo 'alert("'.$mensaje.'");';
				echo 'window.history.back()';
				echo '</script>';
				break;								
			}
			else
			{
				if (($cmbproducto == "18") or ($cmbproducto == "48" and $cmbsubproducto == "2")) //Catodos y Despuntes y Laminas.
				{
					if ($txtcuba != 'F')
					{
						if (($cmbproducto == "18") and ($cmbsubproducto == "3") and ($txtgrupo == "99"))
						{
							$insertar = "INSERT INTO sec_web.produccion_desc_normal (cod_producto,cod_subproducto,fecha_produccion,";
							$insertar.= "cod_grupo,cod_cuba,cod_muestra,cod_lado,peso_produccion,hora)";
							$insertar.= " VALUES ('".$cmbproducto."','".$cmbsubproducto."','".$fecha."','".$txtgrupo."','".$txtcuba."',";
							$insertar.= "'".$txtmuestra."','".$txtlado."','".$txtpeso."','".$hora."')";
							//echo $insertar."<br>";
							mysqli_query($link, $insertar);
						}
						else 
						{
							$insertar = "INSERT INTO sec_web.produccion_catodo (cod_existencia,cod_producto,cod_subproducto,fecha_produccion,";
							$insertar.= "cod_grupo,cod_cuba,cod_muestra,cod_lado,peso_produccion,cod_correlativo,hora)";
							$insertar.= " VALUES ('02','".$cmbproducto."','".$cmbsubproducto."','".$fecha."','".$txtgrupo."','".$txtcuba."',";
							$insertar.= "'".$txtmuestra."','".$txtlado."','".$txtpeso."','000','".$hora."')";
							//echo $insertar."<br>";
							mysqli_query($link, $insertar);						
						}
					}
					else
					{
						$insertar = "INSERT INTO sec_web.control_grupo_pesaje (fecha,grupo) VALUES ('".$fecha."','".$txtgrupo."')";
						//echo $insertar."<br>";
						mysqli_query($link, $insertar);
					}
				}
				else if (($cmbproducto == "57") or ($cmbproducto == "64") or ($cmbproducto == "66") or ($cmbproducto == "48" and $cmbsubproducto != "2")) //Sales � Laminas Aprobadas N.E.
					{
						$insertar = "INSERT INTO sec_web.produccion_catodo (cod_existencia,cod_producto,cod_subproducto,fecha_produccion,";
						$insertar.= "peso_produccion,hora,peso_tara)";
						$insertar.= " VALUES ('02','".$cmbproducto."','".$cmbsubproducto."','".$fecha."','".$txtpeso."','".$hora."', '".$txtpesotara."')";
						mysqli_query($link, $insertar);
						//echo $insertar."<br>";
					}
				
				$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
				$linea.= "&cmbsubproducto=".$cmbsubproducto;
				$linea.= "&peso_auto=".$peso_auto;				
				header("Location:sec_ing_produccion_0413.php?".$linea);				
			}
		}
		
		

		if ($cmbmovimiento == "1") //RECEPCION.
		{	
			$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			
			$linea.= "&cmbsubproducto=".$cmbsubproducto."&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo;
			$linea.= "&existe_sec=S&existe_rec=S&tipo_ie=".$tipo_ie;
			$linea.= "&peso_auto=".$peso_auto;
			//echo "LINEA".$existe_sec;
			if ($existe_sec == "N") 
			{
				$linea.= "&tipo_reg=L";
				
				$insertar = "INSERT INTO sec_web.recepcion_catodo_externo (cod_existencia,cod_producto,cod_subproducto,fecha_recepcion,patente_camion,num_guia,lote_origen,recargo,rut_proveedor,peso_origen,peso_recepcion,peso_zuncho,cod_estado,hora)";	
				$insertar.= " VALUES ('05','".$cmbproducto."','".$cmbsubproducto."','".$fecha."','".$txtpatente."','".$txtguia."','".str_pad($txtlote,8,'0',STR_PAD_LEFT)."','".$txtrecargo."','".$txtrut."','".$txtorigen."','".$txtpeso."','".$txtzuncho."','P','".$hora."')";
																																
				//poly 25-06-2008  $insertar.= " VALUES ('05','".$cmbproducto."','".$cmbsubproducto."','".$fecha."','".$txtpatente."','".$txtguia."','".$txtlote."','".$txtrecargo."','".$txtrut."','".$txtorigen."','".$txtpeso."','".$txtzuncho."','P','".$hora."')";
				//echo $insertar."<br>";			
				mysqli_query($link, $insertar);
				
				//Crea Variable se Sesion para manejar el Peso Zuncho.
				session_start();
				session_register("ses_promedio"); 
				session_register("ses_quitar"); //Descontar al registro.
				session_register("ses_resto"); //Sobrante.
				session_register("ses_numero"); //N� de Paquete. 
				
				$ses_promedio = ($txtzuncho / $txtpaquete);				
				$ses_quitar = floor($ses_promedio);
				$ses_resto = ($txtzuncho - ($ses_quitar * ($txtpaquete - 1)));
				$ses_numero = $txtpaquete;
			}
			else
			{
				//Consulta si existe paquete en el año.
				$consulta = "SELECT * FROM sec_web.paquete_catodo";
				$consulta.= " WHERE cod_paquete = '".$cod_paq[$cmbcodigo]."' AND num_paquete = '".$txtnumero."'";
				//$consulta.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";

				$consulta.= " AND YEAR(fecha_creacion_paquete) = YEAR(NOW())";
				//echo "CCC".$consulta;
				$rs1 = mysqli_query($link, $consulta);
				
				if ($row1 = mysqli_fetch_array($rs1))
				{
					$mensaje = "El Paquete Ya Existe";
					
					echo '<script language="JavaScript">';
					echo 'alert("'.$mensaje.'");';
					echo 'window.history.back()';
					echo '</script>';
					break;			
				}
				else
				{			
					//Consulta si hay un paquete abierto el año anterior, con este codigo.
					$consulta = "SELECT * FROM sec_web.paquete_catodo";
					$consulta.= " WHERE cod_paquete = '".$cod_paq[$cmbcodigo]."' AND num_paquete = '".$txtnumero."'";
					
					//$consulta.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";

					$consulta.= " and cod_producto ='".$cmbproducto."' and cod_subproducto = '".$cmbsubproducto."'";
					$consulta.= " AND cod_estado = 'a' AND YEAR(fecha_creacion_paquete) = YEAR(SUBDATE(NOW(), INTERVAL 1 YEAR))";
					//echo "PPPPP".$consulta;
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs))
					{
						$mensaje = "El Paquete Ya Existe Con Estado Abierto, Del A�o ".substr($row[fecha_creacion_paquete],0,4);
						
						echo '<script language="JavaScript">';
						echo 'alert("'.$mensaje.'");';
						echo 'window.history.back()';
						echo '</script>';
						break;			
					}  
					else
					{
					
						session_register("ses_promedio"); 
						session_register("ses_quitar"); //Descontar al registro.
						session_register("ses_resto"); //Sobrante.
						session_register("ses_numero"); //N� de Paquete.	
						
						
						//$ses_numero = $txtpaquete;
						
						//Ses_numero = 0; entonces el lote completo de pesar los paquetes.					
						if ($ses_numero == 0 and $ses_numero !="") 
						{
						//echo "SSS---".$ses_numero;
							$mensaje = "El Lote Recepcionado,esta Completo no seguir  Pesando Los Paquetes";
							
							echo '<script language="JavaScript">';
							echo 'alert("'.$mensaje.'");';
							echo 'window.history.back()';
							echo '</script>';
							break;						
						}
												
						
						if ($ses_numero == 1)
						{
							$txtpeso = $txtpeso - $ses_resto;
							$ses_numero = $ses_numero - 1;							
						}
						else if ($ses_numero > 1)
							{						
								$txtpeso = $txtpeso - $ses_quitar;
								$ses_numero = $ses_numero - 1;
							}
							
										
						//-------//
						//Consulta lo acumulado y compara con el peso prog. (diferencia de 500 kilos inferior al peso prog.)
						$consulta = "SELECT (IFNULL(SUM(peso_paquetes),0) + ".$txtpeso.") AS peso FROM sec_web.lote_catodo AS t1";
						$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
						$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete";
						$consulta.= " AND t1.cod_estado = t2.cod_estado AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
						$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
						$consulta.= " AND t2.cod_estado = 'a'";
	//echo "RRR".$consulta;
						$rs2 = mysqli_query($link, $consulta); 
						$row2 = mysqli_fetch_array($rs2);
						
						if ($row2["peso"] > $txtpesoprog) 
						{
							
							//Si el peso del paquete no se suma a la misma instruccion entonces devolver el peso en la variables de session. 
							if ($ses_numero == 0)
							{
								$txtpeso = $txtpeso + $ses_resto;
								$ses_numero = $ses_numero + 1;							
							}
							else if ($ses_numero > 0)
								{						
									$txtpeso = $txtpeso + $ses_quitar;
									$ses_numero = $ses_numero + 1;
								}														
							
							
							$mensaje = "El Peso Acumulado Sobrepasa Al Peso Programa";
							
							echo '<script language="JavaScript">';
							echo 'alert("'.$mensaje.'");';
							echo 'window.history.back()';
							echo '</script>';
							break;						
						}						
						else
						{	
							//Si inserto el primer paquete actualizar en I.E (estado1 = R).
							//---					
							if (($txtpeso == $row2["peso"]) and ($listar_ie == "P"))
							{	
								$actualizar = "UPDATE sec_web.programa_codelco SET estado1 = 'R', estado2 = 'P'";
								$actualizar.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado2 <> 'C'";
								//echo $actualizar."<br>";
								mysqli_query($link, $actualizar);
								
								$actualizar = "UPDATE sec_web.programa_enami SET estado1 = 'R', estado2 = 'P'";
								$actualizar.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado2 <> 'C'";
								mysqli_query($link, $actualizar);
								//echo $actualizar."<br>";								
							}	
							
							if (($txtpeso == $row2["peso"]) and ($listar_ie == "V"))
							{
								$actualizar = "UPDATE sec_web.instruccion_virtual SET estado = 'P'";
								$actualizar.= " WHERE corr_virtual = '".$cmbinstruccion."'";
								mysqli_query($link, $actualizar);	
							}
							//---
												
						$insertar = "INSERT INTO sec_web.paquete_catodo_externo (cod_existencia,cod_paquete,num_paquete,fecha_creacion_paquete,cod_producto,cod_subproducto,cod_estado,num_unidades,peso_paquete,lote_origen,recargo,hora)";
						$insertar.= " VALUES ('05','".$cod_paq[$cmbcodpaq]."','".$txtnumpaq."','".$fecha."','".$cmbproducto."','".$cmbsubproducto."','a','".$txtunidades."','".$txtpeso."','".str_pad($txtlote,8,'0',STR_PAD_LEFT)."','".$txtrecargo."','".$hora."')";
						mysqli_query($link, $insertar);
							//echo $insertar."<br>";
												
						$insertar = "INSERT INTO sec_web.paquete_catodo (cod_existencia,cod_paquete,num_paquete,fecha_creacion_paquete,cod_producto,cod_subproducto,cod_estado,num_unidades,peso_paquetes,hora)";				
						$insertar.= " VALUES ('05','".$cod_paq[$cmbcodpaq]."','".$txtnumpaq."','".$fecha."','".$cmbproducto."','".$cmbsubproducto."','a','".$txtunidades."','".$txtpeso."','".$hora."')";
							//echo $insertar."<br>";
						mysqli_query($link, $insertar);
							
							//consulta la fecha de lote si ya hay datos.
						$consulta = "SELECT * FROM sec_web.lote_catodo";
						$consulta.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
						$consulta.= " AND disponibilidad = 'P'";
							//echo $consulta;
							$rs3 = mysqli_query($link, $consulta);
							if ($row3 = mysqli_fetch_array($rs3))
								$fecha_lote = $row3["fecha_creacion_lote"];
							else
								$fecha_lote = $fecha;
							//consulta el cliente (en Enami).
							$consulta = "SELECT * FROM sec_web.programa_enami";
							$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado1 = 'R' AND estado2 <> 'C'";
							$rs4 = mysqli_query($link, $consulta);
							if ($row4 = mysqli_fetch_array($rs4))
							{	
								$cliente = $row4["cod_cliente"];
							}
							else
							{	
								$consulta = "SELECT * FROM sec_web.programa_codelco";
								$consulta.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado1 = 'R' AND estado2 <> 'C'";
								$rs5 = mysqli_query($link, $consulta);
								if ($row5 = mysqli_fetch_array($rs5))
									$cliente = $row5["cod_cliente"];
								else 
									$cliente = "";
							}
							$insertar = "INSERT INTO sec_web.lote_catodo (cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,cod_marca,corr_enm,cod_estado,disponibilidad,cod_cliente,fecha_creacion_paquete)";
							$insertar.= " VALUES ('".$cod_paq[$cmbcodlote]."','".$txtnumlote."','".$cod_paq[$cmbcodpaq]."','".$txtnumpaq."','".$fecha_lote."','".$txtmarca."','".$cmbinstruccion."','a','P','".$cliente."', '".$fecha."')";
							mysqli_query($link, $insertar);
							//echo $insertar."<br>";							
														
							if ($row2["peso"] >= ($txtpesoprog - 500))
							{
								//Actualizar disponibilidad con T.
								$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = 'T'";
								$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
								$actualizar.= " AND corr_enm = '".$cmbinstruccion."'";
								//echo $actualizar."<br>";					
								mysqli_query($link, $actualizar);
																
								if ($listar_ie == "P")
								{
									$actualizar = "UPDATE sec_web.programa_codelco SET estado2 = 'T'";
									$actualizar.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
									//echo $actualizar."<br>";
									mysqli_query($link, $actualizar);
									$actualizar = "UPDATE sec_web.programa_enami SET estado2 = 'T'";
									$actualizar.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
									mysqli_query($link, $actualizar);							
									//echo $actualizar."<br>";
								}
								if ($listar_ie == "V")
								{
									$actualizar = "UPDATE sec_web.instruccion_virtual SET estado = 'T'";
									$actualizar.= " WHERE corr_virtual = '".$cmbinstruccion."'";
									mysqli_query($link, $actualizar);
								}
								$mensaje = "La I.E Completo con el Peso Programado";
							}														
							
							//Ses_numero = 0; entonces el lote completo de pesar los paquetes, Se Cierra el Lote en Recepcion_Catodo.
							if ($ses_numero == 0)
							{
								$actualizar = "UPDATE sec_web.recepcion_catodo_externo SET cod_estado = 'C'";						
								$actualizar.= " WHERE lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND recargo = '".$txtrecargo."'";
																   
								//poly 25-06-2008$actualizar.= " WHERE lote_origen = '".$txtlote."' AND recargo = '".$txtrecargo."'";
								mysqli_query($link, $actualizar);
							}
							
							$linea.= "&encontro_ie=".$encontro_ie."&cmbinstruccion=".$cmbinstruccion."&txtnumlote=".$txtnumlote."&txtrecargo=".$txtrecargo."&cmbcodlote=".$cmbcodlote;
							$linea.= "&txtpesoprog=".$txtpesoprog."&txtmarca=".$txtmarca."&mensaje=".$mensaje;
							$linea.= "&listar_ie=".$listar_ie."&recargapag4=S&tipo_reg=P";
							
							//if (($agrega_paq == "S") and (!isset($mensaje)))
							if (!isset($mensaje))
							{
								$linea.= "&agrega_paq=S&cmbcodpaq=".$cmbcodpaq."&txtnumpaq=".($txtnumpaq + 1);
							}
							else 
								$linea.= "&agrega_paq=N"; 														
						}																														
					}
				}
			}			
						
			header("Location:sec_ing_produccion_0413.php?".$linea);
		}
		
		
		
		if ($cmbmovimiento == "3") //PAQUETE.
		{						
			//Consulta si existe paquete en el año.
			$consulta = "SELECT * FROM sec_web.paquete_catodo";
			$consulta.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
			$consulta.= " AND YEAR(fecha_creacion_paquete) = YEAR(NOW())";
			$rs1 = mysqli_query($link, $consulta);
			if (($row1 = mysqli_fetch_array($rs1)) and ($etapa == 1))
			{
				$mensaje = "El Paquete Ya Existe";
				
				echo '<script language="JavaScript">';
				echo 'alert("'.$mensaje.'");';
				echo 'window.history.back()';
				echo '</script>';
				break;			
			}
			else
			{			
				//Consulta si hay un paquete abierto el año anterior, con este codigo.
				$consulta = "SELECT * FROM sec_web.paquete_catodo";
				$consulta.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
				$consulta.= " and cod_producto ='".$cmbproducto."' and cod_subproducto = '".$cmbsubproducto."'";
				$consulta.= " AND cod_estado = 'a' AND YEAR(fecha_creacion_paquete) = YEAR(SUBDATE(NOW(), INTERVAL 1 YEAR))";
				//echo $consulta;
				$rs = mysqli_query($link, $consulta);
				if (($row = mysqli_fetch_array($rs)) and ($etapa == 1))
				{
					$mensaje = "El Paquete Ya Existe Con Estado Abierto, Del A�o ".substr($row[fecha_creacion_paquete],0,4);
					echo '<script language="JavaScript">';
					echo 'alert("'.$mensaje.'");';
					echo 'window.history.back()';
					echo '</script>';
					break;			
				}
				else 
				{	
					//Consulta lo acumulado y compara con el peso prog. (diferencia de 500 kilos inferior al peso prog.)
					$consulta = "SELECT (IFNULL(SUM(peso_paquetes),0) + ".$txtpeso.") AS peso FROM sec_web.lote_catodo AS t1";
					$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
					$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete";
					$consulta.= " AND t1.cod_estado = t2.cod_estado AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
					$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
					$consulta.= "  AND t2.cod_estado = 'a'";
					//echo $consulta."<br>";
					$rs2 = mysqli_query($link, $consulta); 
					$row2 = mysqli_fetch_array($rs2);
					if ($row2["peso"] > $txtpesoprog) 
					{
						$mensaje = "El Peso Acumulado Sobrepasa Al Peso Programa";
				
						echo '<script language="JavaScript">';
						echo 'alert("'.$mensaje.'");';
						echo 'window.history.back()';
						echo '</script>';
						break;										
					}
					else
					{
						//Si inserto el primer paquete actualizar en I.E (estado1 = R).
						//---											
						if (($txtpeso == $row2["peso"]) and ($listar_ie == "P")) //Instruccion del Programa.
						{	
							$actualizar = "UPDATE sec_web.programa_codelco SET estado1 = 'R', estado2 = 'P'";
							$actualizar.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado2 <> 'C'";
							//echo $actualizar."<br>";
							mysqli_query($link, $actualizar);
							
							$actualizar = "UPDATE sec_web.programa_enami SET estado1 = 'R', estado2 = 'P'";
							$actualizar.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado2 <> 'C'";
							mysqli_query($link, $actualizar);
							//echo $actualizar."<br>";
						}
						if (($txtpeso == $row2["peso"]) and ($listar_ie == "V")) //Instruccion Virtual.
						{
							$actualizar = "UPDATE sec_web.instruccion_virtual SET estado = 'P'";
							$actualizar.= " WHERE corr_virtual = '".$cmbinstruccion."'";
							mysqli_query($link, $actualizar);							
						}
						//---
										
						if ($cmbproducto == 57) //Lodos.
						{
							if ($cmbsubproducto == 11)
							{
								//Paquete Catodo.	
								$insertar = "INSERT INTO sec_web.paquete_catodo (cod_existencia,cod_paquete,num_paquete,fecha_creacion_paquete,cod_producto,cod_subproducto,cod_estado,num_unidades,peso_paquetes,hora)";
								$insertar.= " VALUES ('05', '".$cod_paq[$cmbcodpaq]."', '".$txtnumpaq."', '".$fecha."', '".$cmbproducto."', '".$cmbsubproducto."', 'a', '".$txtunidades."', '".$txtpesoneto."','".$hora."')";
								//echo $insertar."<br>";
								mysqli_query($link, $insertar);
								//Pesaje Lodos.								
								$insertar = "INSERT INTO sec_web.pesaje_lodos (num_pesada,cod_producto,cod_subproducto,corr_ie,cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_pesaje,peso_tara,cod_estado,marca,peso_neto,peso_bruto, unidades)";
								$insertar.= " VALUES ('1','".$cmbproducto."','".$cmbsubproducto."','".$cmbinstruccion."','".$cod_paq[$cmbcodlote]."','".$txtnumlote."','".$cod_paq[$cmbcodpaq]."','".$txtnumpaq."','".$fecha."','".$txtpesotara."','".$listar_ie."','".$txtmarca."','".$txtpesoneto."','".$txtpeso."','".$txtunidades."')";
								//echo $insertar."<br>";
								mysqli_query($link, $insertar)."<br>";
							}							
						}
						else
						{
							$insertar = "INSERT INTO sec_web.paquete_catodo (cod_existencia,cod_paquete,num_paquete,fecha_creacion_paquete,cod_producto,cod_subproducto,cod_estado,num_unidades,peso_paquetes,cod_grupo,cod_cuba,hora)";
							$insertar.= " VALUES ('05', '".$cod_paq[$cmbcodpaq]."', '".$txtnumpaq."', '".$fecha."', '".$cmbproducto."', '".$cmbsubproducto."', '".a."','".$txtunidades."', '".$txtpeso."', '".$txtgrupo."', '".$txtcuba."','".$hora."')";
							//echo $insertar."<br>";
							mysqli_query($link, $insertar);
						}
						//consulta la fecha de lote si ya hay datos.
						$consulta = "SELECT * FROM sec_web.lote_catodo";
						$consulta.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
						$consulta.= " AND disponibilidad = 'P'";
						//echo $consulta;
						$rs3 = mysqli_query($link, $consulta);
						if ($row3 = mysqli_fetch_array($rs3))
							$fecha_lote = $row3["fecha_creacion_lote"];
						else
							$fecha_lote = $fecha;
						//consulta el cliente (en Enami).
						$consulta = "SELECT * FROM sec_web.programa_enami";
						$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado1 = 'R' AND estado2 <> 'C'";
						$rs4 = mysqli_query($link, $consulta);
						if ($row4 = mysqli_fetch_array($rs4))
						{	
							$cliente = $row4["cod_cliente"];
						}
						else
						{	
							$consulta = "SELECT * FROM sec_web.programa_codelco";
							$consulta.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado1 = 'R' AND estado2 <> 'C'";
							$rs5 = mysqli_query($link, $consulta);
							if ($row5 = mysqli_fetch_array($rs5))
								$cliente = $row5["cod_cliente"];
							else 
								$cliente = "";
						}						
						if ($cmbproducto == 57) //Lodos.
						{
							if ($cmbsubproducto == 11)
							{
								$insertar = "INSERT INTO sec_web.lote_catodo (cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,cod_marca,corr_enm,cod_estado,disponibilidad,cod_cliente,fecha_creacion_paquete,unidad)";
								$insertar.= " VALUES ('".$cod_paq[$cmbcodlote]."','".$txtnumlote."','".$cod_paq[$cmbcodpaq]."','".$txtnumpaq."','".$fecha_lote."','".$txtmarca."','".$cmbinstruccion."','a','P','".$cliente."', '".$fecha."','3')";
								mysqli_query($link, $insertar);
								//echo $insertar."<br>";						
							}
						}
						else
						{
							$insertar = "INSERT INTO sec_web.lote_catodo (cod_bulto,num_bulto,cod_paquete,num_paquete,fecha_creacion_lote,cod_marca,corr_enm,cod_estado,disponibilidad,cod_cliente,fecha_creacion_paquete,unidad)";
							$insertar.= " VALUES ('".$cod_paq[$cmbcodlote]."','".$txtnumlote."','".$cod_paq[$cmbcodpaq]."','".$txtnumpaq."','".$fecha_lote."','".$txtmarca."','".$cmbinstruccion."','a','P','".$cliente."', '".$fecha."','".$cmbmedida."')";
							mysqli_query($link, $insertar);
							//echo $insertar."<br>";
						}
						
						if (($row2["peso"] >= ($txtpesoprog - 500)) and ($etapa != 2))
						{
							//Actualizar disponibilidad con T.
							$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = 'T'";
							$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
							$actualizar.= " AND corr_enm = '".$cmbinstruccion."'";
							//echo $actualizar."<br>";					
							mysqli_query($link, $actualizar);
							
							if ($listar_ie == "P") //Del Programa.
							{
								$actualizar = "UPDATE sec_web.programa_codelco SET estado2 = 'T'";
								$actualizar.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
								//echo $actualizar."<br>";
								mysqli_query($link, $actualizar);
								
								$actualizar = "UPDATE sec_web.programa_enami SET estado2 = 'T'";
								$actualizar.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
								mysqli_query($link, $actualizar);							
								//echo $actualizar."<br>";
							}
							
							if ($listar_ie == "V") //Virtual.
							{
								$actualizar = "UPDATE sec_web.instruccion_virtual SET estado = 'T'";
								$actualizar.= " WHERE corr_virtual = '".$cmbinstruccion."'";
								//echo $actualizar."<br>";
								mysqli_query($link, $actualizar);															
							}
							
							$mensaje = "La I.E Completo con el Peso Programado";
						}						
					}
				}
			}
			
			$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			$linea.= "&cmbsubproducto=".$cmbsubproducto."&mensaje=".$mensaje;
			$linea.= "&peso_auto=".$peso_auto."&accion=G";
			$linea.= "&mostrar=S&ano=".$ano."&mes=".$mes."&dia=".$dia."&hh=".date("H")."&mm=".date("i");
			if ($activa_sipa == "S")
			{
				$linea.= "&activa_sipa=S";
			}
			if ($cmbproducto == 64)
			{
				$linea.= "&cmbmedida=".$cmbmedida; 
			}
			//if ($cmbproducto != 57) //Distinto de Lodos.
			//{
				$linea.= "&encontro_ie=".$encontro_ie."&cmbinstruccion=".$cmbinstruccion."&txtnumlote=".$txtnumlote."&cmbcodlote=".$cod_paq[$cmbcodlote];
				$linea.= "&txtpesoprog=".$txtpesoprog."&txtmarca=".$txtmarca."&tipo_ie=".$tipo_ie;
				$linea.= "&listar_ie=".$listar_ie."&recargapag4=S&txtgrupo=".$txtgrupo;
				
				//if (($agrega_paq == "S") and (!isset($mensaje)))
				if (!isset($mensaje))
				{
					$linea.= "&agrega_paq=S&cmbcodpaq=".$cod_paq[$cmbcodpaq]."&txtnumpaq=".($txtnumpaq + 1);
				}
				else 
					$linea.= "&agrega_paq=N"; 
			//}
			header("Location:sec_ing_produccion_0413.php?".$linea);
		}				
	}
	if ($proceso == "M")
	{
		$fecha = $ano.'-'.$mes.'-'.$dia;
		
		if ($cmbmovimiento == "1") //RECEPCION.
		{			
			if ($tipo_reg == "L") //Modifica Lote.
			{								
				$actualizar = "UPDATE sec_web.recepcion_catodo_externo SET fecha_recepcion = '".$fecha."',";
				$actualizar.= "patente_camion = '".$txtpatente."', num_guia = '".$txtguia."', rut_proveedor = '".$txtrut."',";
				$actualizar.= "peso_recepcion = '".$txtpeso."', peso_zuncho = '".$txtzuncho."'";

				$actualizar.= " WHERE lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND recargo = '".$txtrecargo."' AND fecha_recepcion = '".$fecha_aux."'";
				//echo $actualizar."<br>";
				mysqli_query($link, $actualizar);				
			}
			else //Modifica Paquete.
			{
				$actualizar = "UPDATE sec_web.paquete_catodo_externo SET fecha_creacion_paquete = '".$fecha."',";
				$actualizar.= "num_unidades = '".$txtunidades."', peso_paquete = '".$txtpeso."'";
				$actualizar.= " WHERE lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND recargo = '".$txtrecargo."' AND fecha_creacion_paquete = '".$fecha_aux."'";
				$actualizar.= " AND cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
				mysqli_query($link, $actualizar);
				//echo $actualizar."<br>";
				
				$actualizar = "UPDATE sec_web.paquete_catodo SET fecha_creacion_paquete = '".$fecha."',";
				$actualizar.= "num_unidades = '".$txtunidades."', peso_paquetes = '".$txtpeso."'";
				$actualizar.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
				$actualizar.= " AND fecha_creacion_paquete = '".$fecha_aux."'";
				mysqli_query($link, $actualizar);				
				//echo $actualizar."<br>";
				$actualizar = "UPDATE sec_web.lote_catodo SET fecha_creacion_paquete = '".$fecha."'";
				$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
				$actualizar.= " AND cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
				$actualizar.= " AND fecha_creacion_paquete = '".$fecha_aux."'";
				//echo $actualizar."<br>";
				mysqli_query($link, $actualizar);
				//----.
				$peso_prog = 0;
				//Consulta el peso programado de I.E.
				if ($listar_ie == "P") //Del Programa.
				{
					$consulta = "SELECT * FROM sec_web.programa_enami";
					$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado1 = 'R'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs))
					{
						$peso_prog = ($row[cantidad_embarque] * 1000);
					}
					else
					{	
						$consulta = "SELECT * FROM sec_web.programa_codelco";
						$consulta.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado1 = 'R'";
						$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
										
						$rs1 = mysqli_query($link, $consulta);				
						if ($row1 = mysqli_fetch_array($rs1))
							$peso_prog = ($row1["cantidad_programada"] * 1000);
						else
							$peso_prog = 0;	
					}
				}
				else //Virtual.
				{
					$consulta = "SELECT * FROM sec_web.instruccion_virtual";
					$consulta.= " WHERE corr_virtual = '".$cmbinstruccion."'";
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs))
						$peso_prog = $row["peso_programado"];
					else
						$peso_prog = 0;				
				}	
				//Si el peso cambia, verificar los estados de los paquete (P � T) y de las I.E (P � T) segun peso programado.
				$consulta = "SELECT IFNULL(SUM(peso_paquetes),0) AS peso FROM sec_web.lote_catodo AS t1";
				$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
				$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete";
				$consulta.= " AND t1.cod_estado = t2.cod_estado AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
				$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
				$consulta.= "  AND t2.cod_estado = 'a'";
				//echo $consulta."<br>";
				$rs2 = mysqli_query($link, $consulta);
				$row2 = mysqli_fetch_array($rs2);
				if ($row2["peso"] >= ($peso_prog - 500))
				{
					$disponibilidad = 'T';
					$estado2 = 'T';
				} 
				else
				{	
					$disponibilidad = 'P';
					$estado2 = 'P';
				}
				//Actualizar los estados.
				if ($listar_ie == "P") //Del Programa.						
				{
					//Actualizar disponibilidad.
					$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = '".$disponibilidad."'";
					$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
					$actualizar.= " AND corr_enm = '".$cmbinstruccion."'";
					mysqli_query($link, $actualizar);
						
					//Actualiza Programa.			
					$actualizar = "UPDATE sec_web.programa_codelco SET estado2 = '".$estado2."'";
					$actualizar.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
					//echo $actualizar."<br>";
					mysqli_query($link, $actualizar);
					
					$actualizar = "UPDATE sec_web.programa_enami SET estado2 = '".$estado2."'";
					$actualizar.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
					mysqli_query($link, $actualizar);							
					//echo $actualizar."<br>";			
				}
				else //Virtual.
				{
					//Actualizar disponibilidad.
					$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = '".$disponibilidad."'";
					$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
					$actualizar.= " AND corr_enm = '".$cmbinstruccion."'";
					mysqli_query($link, $actualizar);				
					//Actualiza Programa.				
					$actualizar = "UPDATE sec_web.instruccion_virtual SET estado = '".$estado2."'";
					$actualizar.= " WHERE corr_virtual = '".$cmbinstruccion."'";
					//echo $actualizar."<br>";
					mysqli_query($link, $actualizar);				
				}											
			}
			$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			$linea.= "&cmbsubproducto=".$cmbsubproducto."&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo;
			$linea.= "&peso_auto=checked";
			header("Location:sec_ing_produccion_0413.php?".$linea);			
		}		
		if ($cmbmovimiento == "2") //PRODUCCION.
		{
			if (($cmbproducto == 18) or ($cmbproducto == "48" and $cmbsubproducto != 8 and $cmbsubproducto != 9 and $cmbsubproducto != 3 and $cmbsubproducto != 6 and $cmbsubproducto != 10)) //Catodos y Despuntes y Laminas.
			{
				if (($cmbproducto == 18) and ($cmbsubproducto == 3) and ($txtgrupo == 99))
				{
					$actualizar = "UPDATE sec_web.produccion_desc_normal SET fecha_produccion = '".$fecha."', peso_produccion = '".$txtpeso."'";
					$actualizar.= " WHERE fecha_produccion = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$actualizar.= " AND cod_grupo = '".$txtgrupo."' AND cod_muestra = '".$txtmuestra."'";
					$actualizar.= " AND cod_cuba = '".$txtcuba."' AND cod_lado = '".$txtlado."'";
					mysqli_query($link, $actualizar);
					//echo $actualizar."<br>";
				}
				else
				{
					$actualizar = "UPDATE sec_web.produccion_catodo SET fecha_produccion = '".$fecha."', peso_produccion = '".$txtpeso."'";
					$actualizar.= " WHERE fecha_produccion = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$actualizar.= " AND cod_grupo = '".$txtgrupo."' AND cod_muestra = '".$txtmuestra."'";
					$actualizar.= " AND cod_cuba = '".$txtcuba."' AND cod_lado = '".$txtlado."'";
					mysqli_query($link, $actualizar);
					//echo $actualizar."<br>";				
				}						
			}
			else if (($cmbproducto == "57") or ($cmbproducto == 64) or ($cmbproducto == 66) or ($cmbproducto == "48" and ($cmbsubproducto == "8" or $cmbsubproducto == "9" or $cmbsubproducto == "3" or $cmbsubproducto == "6" or $cmbsubproducto == "10")))
				{	
					$actualizar = "UPDATE sec_web.produccion_catodo SET fecha_produccion = '".$fecha."', peso_produccion = '".$txtpeso."', peso_tara = '".$txtpesotara."'";		
					$actualizar.= " WHERE fecha_produccion = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$actualizar.= " AND hora = '".$hora_aux."'";
					mysqli_query($link, $actualizar);
					//echo $actualizar."<br>";
				}
			$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			$linea.= "&cmbsubproducto=".$cmbsubproducto;
			$linea.= "&peso_auto=checked";			
			header("Location:sec_ing_produccion_0413.php?".$linea);			
		}
		
		if ($cmbmovimiento == "3") //PAQUETES.
		{
			$actualizar = "UPDATE sec_web.paquete_catodo SET fecha_creacion_paquete = '".$fecha."'";
			$actualizar.= ", num_unidades = '".$txtunidades."', peso_paquetes = '".$txtpeso."'";
			$actualizar.= " WHERE fecha_creacion_paquete = '".$fecha_aux."' AND cod_paquete = '".$cod_paq[$cmbcodpaq]."'";
			$actualizar.= " AND num_paquete = '".$txtnumpaq."' AND cod_estado = 'a'";
			mysqli_query($link, $actualizar);
			//echo $actualizar."<br>";
			$actualizar = "UPDATE sec_web.lote_catodo SET fecha_creacion_paquete = '".$fecha."'";;
			$actualizar.= " WHERE fecha_creacion_paquete = '".$fecha_aux."' AND cod_paquete = '".$cod_paq[$cmbcodpaq]."'";
			$actualizar.= " AND num_paquete = '".$txtnumpaq."' AND corr_enm = '".$cmbinstruccion."'";
			$actualizar.= " AND cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
			mysqli_query($link, $actualizar);
			$peso_prog = 0;
			//Consulta el peso programado de I.E.
			if ($listar_ie == "P") //Del Programa.
			{
				$consulta = "SELECT * FROM sec_web.programa_enami";
				$consulta.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado1 = 'R'";
				$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
				$rs = mysqli_query($link, $consulta);
				if ($row = mysqli_fetch_array($rs))
				{
					$peso_prog = ($row[cantidad_embarque] * 1000);
				}
				else
				{	
					$consulta = "SELECT * FROM sec_web.programa_codelco";
					$consulta.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado1 = 'R'";
					$consulta.= " AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
									
					$rs1 = mysqli_query($link, $consulta);				
					if ($row1 = mysqli_fetch_array($rs1))
						$peso_prog = ($row1["cantidad_programada"] * 1000);
					else
						$peso_prog = 0;	
				}
			}
			else //Virtual.
			{
				$consulta = "SELECT * FROM sec_web.instruccion_virtual";
				$consulta.= " WHERE corr_virtual = '".$cmbinstruccion."'";
				$rs = mysqli_query($link, $consulta);
				if ($row = mysqli_fetch_array($rs))
					$peso_prog = $row["peso_programado"];
				else
					$peso_prog = 0;				
			}						
			//Si el peso cambia, verificar los estados de los paquete (P � T) y de las I.E (P � T) segun peso programado.
			$consulta = "SELECT IFNULL(SUM(peso_paquetes),0) AS peso FROM sec_web.lote_catodo AS t1";
			$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
			$consulta.= " ON t1.cod_paquete = t2.cod_paquete AND t1.num_paquete = t2.num_paquete";
			$consulta.= " AND t1.cod_estado = t2.cod_estado AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
			$consulta.= " WHERE t1.cod_bulto = '".$cod_paq[$cmbcodlote]."' AND t1.num_bulto = '".$txtnumlote."'";
			$consulta.= "  AND t2.cod_estado = 'a'";
			//echo $consulta."<br>";
			$rs2 = mysqli_query($link, $consulta);
			$row2 = mysqli_fetch_array($rs2);
			
			if ($row2["peso"] >= ($peso_prog - 500))
			{
				$disponibilidad = 'T';
				$estado2 = 'T';
			} 
			else
			{	
				$disponibilidad = 'P';
				$estado2 = 'P';
			}
			//Actualizar los estados.
			if ($listar_ie == "P") //Del Programa.						
			{
				//Actualizar disponibilidad.
				$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = '".$disponibilidad."'";
				$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
				$actualizar.= " AND corr_enm = '".$cmbinstruccion."'";
				mysqli_query($link, $actualizar);
				//Actualiza Programa.			
				$actualizar = "UPDATE sec_web.programa_codelco SET estado2 = '".$estado2."'";
				$actualizar.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
				//echo $actualizar."<br>";
				mysqli_query($link, $actualizar);
				$actualizar = "UPDATE sec_web.programa_enami SET estado2 = '".$estado2."'";
				$actualizar.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
				mysqli_query($link, $actualizar);							
				//echo $actualizar."<br>";			
			}
			else //Virtual.
			{
				//Actualizar disponibilidad.
				$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = '".$disponibilidad."'";
				$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
				$actualizar.= " AND corr_enm = '".$cmbinstruccion."'";
				mysqli_query($link, $actualizar);				
				//Actualiza Programa.				
				$actualizar = "UPDATE sec_web.instruccion_virtual SET estado = '".$estado2."'";
				$actualizar.= " WHERE corr_virtual = '".$cmbinstruccion."'";
				//echo $actualizar."<br>";
				mysqli_query($link, $actualizar);				
			}
			$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			$linea.= "&cmbsubproducto=".$cmbsubproducto;
			$linea.= "&peso_auto=checked";			
			header("Location:sec_ing_produccion_0413.php?".$linea);
		}
	}
	
	
	/*
		if ($proceso == "E")
		{           
			if ($cmbmovimiento == "1") //RECEPCION.
			{
				if ($tipo_reg == "L") //Elimina el lote y sus paquetes asociados.
				{					
					//Consultar los paqutes del lote, si uno esta cerrado no se puede eliminar.
					$consulta = "SELECT * FROM sec_web.paquete_catodo_externo AS t1";
					$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
					$consulta.= " ON t1.cod_paquete = t2.cod_paquete ";
					$consulta.= " AND t1.num_paquete = t2.num_paquete";
					$consulta.= " AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
				 	$consulta.= " WHERE t1.lote_origen = '"$txtlote."' AND t1.recargo = '".$txtrecargo."' AND t2.cod_estado = 'c'";                                                                                        
					echo $consulta."<br>";
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs))
					{                       
						$mensaje = "No Se Puede Eliminar El Lote, Hay Un Paquete Cerrado";
						echo '<script language="JavaScript">';
						echo 'alert("'.$mensaje.'");';
						echo 'window.history.back()';
						echo '</script>';
						break;                                                  
					}
					else 
					{
						$consulta = "SELECT * FROM sec_web.paquete_catodo_externo";
						$consulta.= " WHERE lote_origen = '".$txtlote."' AND recargo = '".$txtrecargo."'";
						$consulta.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
						$consulta.= " AND fecha_creacion_paquete = '".$fecha_aux."' AND cod_estado = 'a'";                                   
						echo $consulta."<br>";
						$rs1 = mysqli_query($link, $consulta);
						while ($row1 = mysqli_fetch_array($rs1))
						{
							$eliminar = "DELETE FROM sec_web.paquete_catodo";
							$eliminar.= " WHERE cod_paquete = '".$row1["cod_paquete"]."' AND num_paquete = '".$row1["num_paquete"]."'";
							$eliminar.= " AND fecha_creacion_paquete = '".$row1[fecha_creacion_paquete]."' AND cod_estado = 'a'";
							$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
							$eliminar.= " AND fecha_creacion_paquete = '".$fecha_aux."' AND cod_estado = 'a'";       
							echo "PAQ".$eliminar."<br>";
							//mysqli_query($link, $eliminar);
							$eliminar = "DELETE FROM sec_web.paquete_catodo_externo";
							$eliminar.= " WHERE cod_paquete = '".$row1["cod_paquete"]."' AND num_paquete = '".$row1["num_paquete"]."'";
							$eliminar.= " AND fecha_creacion_paquete = '".$row1[fecha_creacion_paquete]."' AND cod_estado = 'a'";
							$eliminar.= " AND lote_origen = '".$txtlote."' AND recargo = '".$txtrecargo."'";
							$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
							$eliminar.= " AND fecha_creacion_paquete = '".$fecha_aux."' AND cod_estado = 'a'";       
							echo "PAQEXT".$eliminar."<br>";
							//mysqli_query($link, $eliminar);
							$eliminar = "DELETE FROM sec_web.lote_catodo";
							$eliminar.= " WHERE cod_paquete = '".$row1["cod_paquete"]."' AND num_paquete = '".$row1["num_paquete"]."'";
							$eliminar.= " AND cod_estado = 'a' AND fecha_creacion_paquete = '".$row1[fecha_creacion_paquete]."'";
							echo "LOTE".$eliminar."<br>";
							 //mysqli_query($link, $eliminar);                                                                                                                                                                                                                  
						}
						$eliminar = "DELETE FROM sec_web.recepcion_catodo_externo";
						$eliminar.= " WHERE lote_origen = '".$txtlote."' AND recargo = '".$txtrecargo."'";
						$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
						$eliminar.= " AND fecha_recepcion = '".$fecha_aux."' AND cod_estado = 'a'";       
						echo "RECP".$eliminar."<br>";
						//mysqli_query($link, $eliminar);
					}                                  
				}
				else
				{
					 //Consulta si el paquete esta abierto se puede eliminar.                                                                          
					$consulta = "SELECT * FROM sec_web.paquete_catodo";
					//$consulta.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
					$consulta.= " WHERE cod_paquete = '".$cmbcodpaq."' AND num_paquete = '".$txtnumpaq."'";
					$consulta.= " AND fecha_creacion_paquete = '".$fecha_aux."' AND cod_estado = 'a'";                              
					$consulta.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";  
					//echo "SELPAQ".$consulta."<br>";
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs))
					{                       
						$eliminar = "DELETE FROM sec_web.paquete_catodo";
						$eliminar.= " WHERE cod_paquete = '".$cmbcodpaq."' AND num_paquete = '".$txtnumpaq."'";
						$eliminar.= " AND fecha_creacion_paquete = '".$fecha_aux."' AND cod_estado = 'a'";
						$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";  
						mysqli_query($link, $eliminar);
						$eliminar = "DELETE FROM sec_web.lote_catodo";
						$eliminar.= " WHERE cod_paquete = '".$cmbcodpaq."' AND num_paquete = '".$txtnumpaq."'";
						$eliminar.= " AND cod_estado = 'a' AND fecha_creacion_paquete = '".$fecha_aux."'";
						mysqli_query($link, $eliminar);                                    
						//echo "ELILOTE".$eliminar."<br>";        
						$eliminar = "DELETE FROM sec_web.paquete_catodo_externo";
						$eliminar.= " WHERE cod_paquete = '".$cmbcodpaq."' AND num_paquete = '".$txtnumpaq."'";
						$eliminar.= " AND fecha_creacion_paquete = '".$fecha_aux."'";
						$eliminar.= " AND lote_origen = '".$txtlote."' AND recargo = '".$txtrecargo."'";
						$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";  
						mysqli_query($link, $eliminar);                                                                                                           
						//echo "ELIPAQEXT".$eliminar."<br>";
					}
					else
					{
						$mensaje = "El Paquete Esta Cerradooooooooooooo, No Se Puede Eliminar";
						echo '<script language="JavaScript">';
						echo 'alert("'.$mensaje.'");';
						echo 'window.history.back()';
						break;
					}
				}
				$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
				$linea.= "&cmbsubproducto=".$cmbsubproducto."&txtlote=".$txtlote."&txtrecargo=".$txtrecargo;
				$linea.= "&peso_auto=checked";                                   
				//header("Location:sec_ing_produccion.php?".$linea);
		} 


*/

if ($proceso == "E")
	{	
		if ($cmbmovimiento == "1") //RECEPCION.
		{
			if ($tipo_reg == "L") //Elimina el lote y sus paquetes asociados.
			{
				//Consultar los paqutes del lote, si uno esta cerrado no se puede eliminar.
				$consulta = "SELECT * FROM sec_web.paquete_catodo_externo AS t1";
				$consulta.= " INNER JOIN sec_web.paquete_catodo AS t2";
				$consulta.= " ON t1.cod_paquete = t2.cod_paquete ";
				$consulta.= " AND t1.num_paquete = t2.num_paquete";
				$consulta.= " AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
				$consulta.= " WHERE t1.lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND t1.recargo = '".$txtrecargo."' AND t2.cod_estado = 'c'";								
			//echo "Consulta paq_ext".$consulta."<br>";
				$rs = mysqli_query($link, $consulta);
				if ($row = mysqli_fetch_array($rs))
				{		
					$mensaje = "No Se Puede Eliminar El Lote, Hay Un Paquete Cerrado";
					echo '<script language="JavaScript">';
					echo 'alert("'.$mensaje.'");';
					echo 'window.history.back()';
					echo '</script>';
					break;					
				}
				else 
				{
					$consulta = "SELECT * FROM sec_web.paquete_catodo_externo";
					$consulta.= " WHERE lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND recargo = '".$txtrecargo."'";
					$consulta.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$rs1 = mysqli_query($link, $consulta);
					//echo "Consulta Paquetes ext".$consulta."<br>";
					while ($row1 = mysqli_fetch_array($rs1))
					{
						$eliminar = "DELETE FROM sec_web.paquete_catodo";
						$eliminar.= " WHERE cod_paquete = '".$row1["cod_paquete"]."' AND num_paquete = '".$row1["num_paquete"]."'";
						$eliminar.= " AND fecha_creacion_paquete = '".$row1[fecha_creacion_paquete]."' AND cod_estado = 'a'";
						$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
						//echo "PAQ".$eliminar."<br>";
						mysqli_query($link, $eliminar);
						
						$eliminar = "DELETE FROM sec_web.paquete_catodo_externo";
						$eliminar.= " WHERE cod_paquete = '".$row1["cod_paquete"]."' AND num_paquete = '".$row1["num_paquete"]."'";
						$eliminar.= " AND fecha_creacion_paquete = '".$row1[fecha_creacion_paquete]."' AND cod_estado = 'a'";
						$eliminar.= " AND lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND recargo = '".$txtrecargo."'";
						$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
						//echo "PAQEXT".$eliminar."<br>";
						mysqli_query($link, $eliminar);
						$eliminar = "DELETE FROM sec_web.lote_catodo";
						$eliminar.= " WHERE cod_paquete = '".$row1["cod_paquete"]."' AND num_paquete = '".$row1["num_paquete"]."'";
						$eliminar.= " AND cod_estado = 'a' AND fecha_creacion_paquete = '".$row1[fecha_creacion_paquete]."'";
						//echo "LOTE".$eliminar."<br>";
						mysqli_query($link, $eliminar);																		
					}
					
					$eliminar = "DELETE FROM sec_web.recepcion_catodo_externo";
					$eliminar.= " WHERE lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND recargo = '".$txtrecargo."'";
					$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$eliminar.= " AND fecha_recepcion = '".$fecha_aux."'"; 
					//echo "RECEP".$eliminar."<br>";
					mysqli_query($link, $eliminar);
				}			
			}
			else
			{
				//Consulta si el paquete esta abierto se puede eliminar.							
				$consulta = "SELECT * FROM sec_web.paquete_catodo";
				$consulta.= " WHERE cod_paquete = '".$cmbcodpaq."' AND num_paquete = '".$txtnumpaq."'";
				$consulta.= " AND fecha_creacion_paquete = '".$fecha_aux."' AND cod_estado = 'a'";		
				$consulta.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'"; 	
				//echo "consulta paq".$consulta;
					
				$rs = mysqli_query($link, $consulta);
				if ($row = mysqli_fetch_array($rs))
				{								
					$eliminar = "DELETE FROM sec_web.paquete_catodo";
					$eliminar.= " WHERE cod_paquete = '".$cmbcodpaq."' AND num_paquete = '".$txtnumpaq."'";
					$eliminar.= " AND fecha_creacion_paquete = '".$fecha_aux."' AND cod_estado = 'a'";
					$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					mysqli_query($link, $eliminar);
					//echo "uno borra paquete".$eliminar."<br>";
					$eliminar = "DELETE FROM sec_web.lote_catodo";
					$eliminar.= " WHERE cod_paquete = '".$cmbcodpaq."' AND num_paquete = '".$txtnumpaq."'";
					$eliminar.= " AND cod_estado = 'a' AND fecha_creacion_paquete = '".$fecha_aux."'";
					mysqli_query($link, $eliminar);					
					//echo "dos elim lote".$eliminar."<br>";
					$eliminar = "DELETE FROM sec_web.paquete_catodo_externo";
					$eliminar.= " WHERE cod_paquete = '".$cmbcodpaq."' AND num_paquete = '".$txtnumpaq."'";
					$eliminar.= " AND fecha_creacion_paquete = '".$fecha_aux."'";
					$eliminar.= " AND lote_origen = '".str_pad($txtlote,8,'0',STR_PAD_LEFT)."' AND recargo = '".$txtrecargo."'";
					$eliminar.= " and cod_producto  = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'"; 
					mysqli_query($link, $eliminar);										
					//echo "elimina paq ext".$eliminar."<br>";
				}
				else
				{
					$mensaje = "El Paquete Esta Cerrado, No Se Puede Eliminar";
					echo '<script language="JavaScript">';
					echo 'alert("'.$mensaje.'");';
					echo 'window.history.back()';
					echo '</script>';
					break;
				}
			}
			$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			$linea.= "&cmbsubproducto=".$cmbsubproducto."&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo;
			$linea.= "&peso_auto=checked";			
			header("Location:sec_ing_produccion_0413.php?".$linea);
		}
		
		if ($cmbmovimiento == "2") //PRODUCCION.		
		{	
			if (($cmbproducto == 18) or ($cmbproducto == "48" and $cmbsubproducto != 8 and $cmbsubproducto != 9 and $cmbsubproducto != 3 and $cmbsubproducto != 6 and $cmbsubproducto != 10)) //Catodos y Despuntes y Laminas.
			{	
				if (($cmbproducto == 18) and ($cmbsubproducto == 3) and ($txtgrupo == 99))
				{
					$eliminar = "DELETE FROM sec_web.produccion_desc_normal";
					$eliminar.= " WHERE fecha_produccion = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$eliminar.= " AND cod_grupo = '".$txtgrupo."' AND cod_cuba = '".$txtcuba."' AND cod_muestra = '".$txtmuestra."'";
					$eliminar.= " AND cod_lado = '".$txtlado."'";
					//echo $eliminar."<br>";
					mysqli_query($link, $eliminar);
				}
				else
				{
					$eliminar = "DELETE FROM sec_web.produccion_catodo";
					$eliminar.= " WHERE fecha_produccion = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$eliminar.= " AND cod_grupo = '".$txtgrupo."' AND cod_cuba = '".$txtcuba."' AND cod_muestra = '".$txtmuestra."'";
					$eliminar.= " AND cod_lado = '".$txtlado."'";
					//echo $eliminar."<br>";
					mysqli_query($link, $eliminar);					
				}
			}
			else if (($cmbproducto == "57") or ($cmbproducto == 64) or ($cmbproducto == 66) or ($cmbproducto == "48" and ($cmbsubproducto == 8 or $cmbsubproducto == 9 or $cmbsubproducto == 3 or $cmbsubproducto == 6 or $cmbsubproducto == 10)))
				{
					$eliminar = "DELETE FROM sec_web.produccion_catodo";
					$eliminar.= " WHERE fecha_produccion = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					$eliminar.= " AND hora = '".$hora_aux."'";
					mysqli_query($link, $eliminar);
				}
			$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			$linea.= "&cmbsubproducto=".$cmbsubproducto;
			$linea.= "&peso_auto=checked";			
			header("Location:sec_ing_produccion_0413.php?".$linea);	
		}
		
		if ($cmbmovimiento == "3") //PAQUETES.
		{
			if ($cmbproducto != 57)
			{								
				$eliminar = "DELETE FROM sec_web.paquete_catodo";
				$eliminar.= " WHERE fecha_creacion_paquete = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
				$eliminar.= " AND cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."' AND cod_estado = 'a'";
				//echo $eliminar."<br>";
				mysqli_query($link, $eliminar);
				
				$eliminar = "DELETE FROM sec_web.lote_catodo";
				$eliminar.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
				$eliminar.= " AND cod_estado = 'a' AND fecha_creacion_paquete = '".$fecha_aux."'";
				mysqli_query($link, $eliminar);			
			}
			else
			{
				if ($cmbsubproducto == 12) //2� Pesada.
				{
					//Eliminar en pesaje_lodo.
					$eliminar = "DELETE FROM sec_web.pesaje_lodos";
					$eliminar.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
					$eliminar.= " AND num_pesada = '2' AND fecha_pesaje = '".$fecha_aux."'";
					//echo $eliminar."<br>";
					mysqli_query($link, $eliminar);										
				}
				else
				{
					//Si la Serie tiene la 2� Pesada, NO SE ELIMINA.
					$consulta = "SELECT * FROM sec_web.pesaje_lodos";
					$consulta.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
					$consulta.= " AND cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
					$consulta.= " AND corr_ie = '".$cmbinstruccion."' AND num_pesada = '2' AND fecha_pesaje >= '".$fecha_aux."'";
					//echo $consulta."<br>";
					
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs))
					{
						$mensaje = "No Se Puede Eliminar, Debe Eliminar La 2� Pesada.";
						
						echo '<script language="JavaScript">';
						echo 'alert("'.$mensaje.'");';
						echo 'window.history.back()';
						echo '</script>';
						break;
					}
					else
					{					
						//Elimnar en paquete_catodo.
						$eliminar = "DELETE FROM sec_web.paquete_catodo";
						$eliminar.= " WHERE fecha_creacion_paquete = '".$fecha_aux."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '11'";
						$eliminar.= " AND cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."' AND cod_estado = 'a'";						
						//echo $eliminar."<br>";
						mysqli_query($link, $eliminar);
											
						//Eliminar en lote_catodo.
						$eliminar = "DELETE FROM sec_web.lote_catodo";
						$eliminar.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
						$eliminar.= " AND cod_estado = 'a' AND fecha_creacion_paquete = '".$fecha_aux."'";
						//echo $eliminar."<br>";
						mysqli_query($link, $eliminar);								
						//Eliminar en pesaje_lodo.
						$eliminar = "DELETE FROM sec_web.pesaje_lodos";
						$eliminar.= " WHERE cod_paquete = '".$cod_paq[$cmbcodpaq]."' AND num_paquete = '".$txtnumpaq."'";
						$eliminar.= " AND num_pesada = '1' AND fecha_pesaje = '".$fecha_aux."'";					
						mysqli_query($link, $eliminar);
						//echo $eliminar."<br>";					
					}
				}				
			}
			//Cambiar Estado de la I.E, y la disponibilidad en lote_catodo.			
			//Actualizar los estados.
			if ((($cmbproducto == 57) and ($cmbsubproducto == 11)) or ($cmbproducto != 57))
			{						
				if ($listar_ie == "P") //Del Programa.						
				{
					$consulta = "SELECT IFNULL(COUNT(*),0) AS total";
					$consulta.= " FROM sec_web.lote_catodo";					
					$consulta.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
					$consulta.= " AND corr_enm = '".$cmbinstruccion."' AND cod_estado = 'a'";
					$rs = mysqli_query($link, $consulta);
					$row = mysqli_fetch_array($rs);
					if ($row["total"] == 0)
					{
						$estado2_aux = "N";
						$estado1_aux = "";
					}
					else
					{
						$estado2_aux = "P";
						$estado1_aux = "R";
						
						//Actualizar disponibilidad.
						$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = 'P'";
						$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
						$actualizar.= " AND corr_enm = '".$cmbinstruccion."' AND cod_estado = 'a'";
						mysqli_query($link, $actualizar);
						//echo $actualizar."<br>";						
					}
					//Actualiza Programa.			
					$actualizar = "UPDATE sec_web.programa_codelco SET estado2 = '".$estado2_aux."', estado1 = '".$estado1_aux."'";
					$actualizar.= " WHERE corr_codelco = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
					//echo $actualizar."<br>";
					mysqli_query($link, $actualizar);
					
					$actualizar = "UPDATE sec_web.programa_enami SET estado2 = '".$estado2_aux."', estado1 = '".$estado1_aux."'";
					$actualizar.= " WHERE corr_enm = '".$cmbinstruccion."' AND estado2 NOT IN ('C','A')";
					mysqli_query($link, $actualizar);							
					//echo $actualizar."<br>";			
				}
				else //Virtual.
				{
					$consulta = "SELECT IFNULL(COUNT(*),0) AS total";
					$consulta.= " FROM sec_web.lote_catodo";
					$consulta.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
					$consulta.= " AND corr_enm = '".$cmbinstruccion."' AND cod_estado = 'a'";
					$rs = mysqli_query($link, $consulta);
					$row = mysqli_fetch_array($rs);
					if ($row["total"] == 0)
						$estado_aux = "N";
					else
					{
						$estado_aux = "P";
						//Actualizar disponibilidad.
						$actualizar = "UPDATE sec_web.lote_catodo SET disponibilidad = '".$estado_aux."'";
						$actualizar.= " WHERE cod_bulto = '".$cod_paq[$cmbcodlote]."' AND num_bulto = '".$txtnumlote."'";
						$actualizar.= " AND corr_enm = '".$cmbinstruccion."' AND cod_estado = 'a'";
						//echo $actualizar."<br>";
						mysqli_query($link, $actualizar);					
					}					
					//Actualiza Programa.				
					$actualizar = "UPDATE sec_web.instruccion_virtual SET estado = '".$estado_aux."'";
					$actualizar.= " WHERE corr_virtual = '".$cmbinstruccion."'";
					//echo $actualizar."<br>";
					mysqli_query($link, $actualizar);				
				}
			}
			$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
			$linea.= "&cmbsubproducto=".$cmbsubproducto;
			$linea.= "&peso_auto=checked";			
			header("Location:sec_ing_produccion_0413.php?".$linea);			
		}
	}
	if ($proceso == "T") //Traspaso de Paquetes.
	{	
		reset($checkbox);
		while (list($c,$v) = each($checkbox))
		{							
			//Replica el Registro en paquete_catodo.
			$consulta = "SELECT * FROM sec_web.paquete_catodo_externo";
			$consulta.= " WHERE cod_paquete = '".$cod_paquete[$c]."' AND num_paquete = '".$num_paquete[$c]."'";
			$consulta.= " AND fecha_creacion_paquete = '".$fecha_creacion[$c]."' AND cod_estado = 'p'";
			$rs = mysqli_query($link, $consulta);
			$row = mysqli_fetch_array($rs);
			
			$insertar = "INSERT INTO sec_web.paquete_catodo (cod_existencia,cod_paquete,num_paquete,fecha_creacion_paquete,cod_producto,cod_subproducto,cod_lugar,cod_estado,num_unidades,peso_paquetes,cod_grupo,cod_cuba,hora)";
			$insertar.= " VALUES ('05', '".$cod_paquete[$c]."', '".$num_paquete[$c]."', '".$fecha_creacion[$c]."', '".$row["cod_producto"]."', '".$row["cod_subproducto"]."',";
			$insertar.= " '".$row[cod_lugar]."','a', '".$row["num_unidades"]."', '".$row[peso_paquete]."', '".$row["cod_grupo"]."', '".$row[cod_cuba]."','".$row[hora]."')";
			//echo $insertar."<br>";
			mysqli_query($link, $insertar);
			
			//Actualiza el estado en paquete_catodo_externo.			
			$actualizar = "UPDATE sec_web.paquete_catodo_externo SET cod_estado = 'c'";
			$actualizar.= " WHERE cod_paquete = '".$cod_paquete[$c]."' AND num_paquete = '".$num_paquete[$c]."'";
			$actualizar.= " AND fecha_creacion_paquete = '".$fecha_creacion[$c]."' AND cod_estado = 'p'";
			//echo $actualizar."<br>";
			mysqli_query($link, $actualizar);
		}
		
		header("Location:sec_ing_produccion_popup_traspaso.php");
	}
	if ($proceso == "V") //Crea Virtual.
	{	
		$consulta = "SELECT CASE WHEN IFNULL(MAX(corr_virtual),0) = 0 THEN 900000 ELSE (MAX(corr_virtual) + 1) END AS instruccion_virtual";
		$consulta.= " FROM sec_web.instruccion_virtual";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		$fecha_emb = date("Y").'-12-31';
		$insertar = "INSERT INTO sec_web.instruccion_virtual (corr_virtual,fecha_embarque,cod_producto,cod_subproducto,descripcion,estado)";
		$insertar.= " VALUES ('".$row[instruccion_virtual]."', '".$fecha_emb."', '".$cmbproducto."', '".$cmbsubproducto."', 'PSJE', 'N')"; 
		//echo $insertar."<br>";
		mysqli_query($link, $insertar);
		$linea.= "tipo_ie=V"; //Virtual.
		$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.="&cmbsubproducto=".$cmbsubproducto."&mostrar=S&ano=".$ano."&mes=".$mes."&dia=".$dia;
		$linea.= "&peso_auto=".$peso_auto."&hh=".$hh."&mm=".$mm."&cmbinstruccion=".$row[instruccion_virtual];
		$linea.= "&encontro_ie=S&listar_ie=V&recargapag4=S";
		if ($cmbmovimiento == 1)
		{	
		
			$linea.= "&tipo_reg=P&existe_sec=S&existe_rec=S&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo;
		}
		
		if ($cmbproducto == 57) //Lodos
			$linea.= "&etapa=1";
		header("Location:sec_ing_produccion_0413.php?".$linea);
	}
	if ($proceso == "AP") //Agrega el Peso de la I.E. Virtual.
	{
		$actualizar = "UPDATE sec_web.instruccion_virtual SET peso_programado = '".$txtpesoprog."'";
		$actualizar.= " WHERE corr_virtual = '".$cmbinstruccion."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		mysqli_query($link, $actualizar);
		//echo $actualizar."<br>";
		$linea.= "tipo_ie=V"; //Virtual.
		$linea.= "&recargapag1=S&recargapag2=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto;
		$linea.="&cmbsubproducto=".$cmbsubproducto."&mostrar=S&ano=".$ano."&mes=".$mes."&dia=".$dia;
		$linea.= "&peso_auto=".$peso_auto."&hh=".$hh."&mm=".$mm."&cmbinstruccion=".$cmbinstruccion;
		$linea.= "&encontro_ie=S&txtpesoprog=".$txtpesoprog."&peso_prog_ok=S&listar_ie=".$listar_ie."&recargapag4=S";
		if ($cmbmovimiento == 1)
		{	
		
			$linea.= "&tipo_reg=P&existe_sec=S&existe_rec=S&txtlote=".str_pad($txtlote,8,'0',STR_PAD_LEFT)."&txtrecargo=".$txtrecargo;
		}
		if ($cmbproducto == 57) //Lodos
			$linea.= "&etapa=".$etapa;		
		header("Location:sec_ing_produccion_0413.php?".$linea);	
	}
	include("../principal/conectar_sec_web.php");
?>
