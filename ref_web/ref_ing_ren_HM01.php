<?php
	include("../principal/conectar_ref_web.php");
	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Dia    = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:"";
	$Mes    = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:"";
	$Ano    = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
	$fechas_comercial= isset($_REQUEST["fechas_comercial"])?$_REQUEST["fechas_comercial"]:"";
	$fechas_s_ren    = isset($_REQUEST["fechas_s_ren"])?$_REQUEST["fechas_s_ren"]:"";
	$cubas    = isset($_REQUEST["cubas"])?$_REQUEST["cubas"]:"";
	$grupos   = isset($_REQUEST["grupos"])?$_REQUEST["grupos"]:"";
	


	switch ($Proceso)
	{
		case "C":
		        $borrar="delete from ref_web.renovacion_hm where fecha between '".$Ano.'-'.$Mes.'-01'."' and '".$Ano.'-'.$Mes.'-31'."'";
				mysqli_query($link, $borrar);
				$arreglo = explode("~~",$fechas_comercial); //Separa los parametros en un array.
				reset($arreglo);					
				foreach($arreglo as $clave => $valor)
				{		
					$detalle = explode("//",$valor); //check - turno - circuito - volumen. 
					$Fechacomercial=$detalle[2].'-'.$detalle[1].'-'.$detalle[0];
					$Consulta = "select * from ref_web.renovacion_hm ";
					$Consulta.= " where fecha = '".$Fechacomercial."' ";
					$Consulta.= " and cod_grupo = '08'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila = mysqli_fetch_array($Respuesta))
					{
						$Actualizar = "UPDATE ref_web.renovacion_HM set ";
						$Actualizar.= " cod_grupo = '".$Grupo1."' ";
						$Actualizar.= " ,cubas_renovacion = 'Renovacion Grupo 8 Comercial' "; 
						$Actualizar.= " ,anodos_a_renovar = '".$Anodos_a_renovar."' ";
						$Actualizar.= " ,inicio_renovacion = '08' ";  
						$Actualizar.= " where fecha = '".$Fechacomercial."'";
						$Actualizar.= " and cod_grupo = '08'";
						mysqli_query($link, $Actualizar);
					}
					else
						{   
							$consulta="select * from ref_web.renovacion_hm where fecha='".$Fechacomercial."' ";
							//echo $consulta;
							$Respuesta = mysqli_query($link, $consulta);
							while ($Fila = mysqli_fetch_array($Respuesta))
								{
									$Insertar = "INSERT INTO ref_web.renovacion_HM_temp ";
									$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
									$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
									$Insertar.= " VALUES ('".$Fila["fecha"]."','".$Fila["cod_grupo"]."','".$Fila["cubas_renovacion"]."', ";
									$Insertar.= " '".$Fila["anodos_a_renovar"]."', '".$Fila["inicio_renovacion"]."')";
									mysqli_query($link, $Insertar);	   
									$borrar="delete from ref_web.renovacion_hm where fecha='".$Fechacomercial."' ";
									mysqli_query($link, $borrar);
								}
							$Insertar = "INSERT INTO ref_web.renovacion_HM ";
							$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
							$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
							$Insertar.= " VALUES ('".$Fechacomercial."','08','Renovacion Grupo 8 Comercial', ";
							$Insertar.= " '".$Anodos_a_renovar."', '08')";
							mysqli_query($link, $Insertar);
						}
					} 
					$arreglo = explode("~~",$fechas_s_ren); //Separa los parametros en un array.
					reset($arreglo);					
					foreach($arreglo as $clave => $valor)
						{		
							$detalle = explode("//",$valor); //check - turno - circuito - volumen. 
							$Fechasn=$detalle[2].'-'.$detalle[1].'-'.$detalle[0];
							$Consulta = "select * from ref_web.renovacion_hm ";
							$Consulta.= " where fecha = '".$Fechasn."'";
							$Consulta.= " and cod_grupo = 'SR'";
							$Respuesta = mysqli_query($link, $Consulta);
							if ($Fila = mysqli_fetch_array($Respuesta))
								{
									$Actualizar = "UPDATE ref_web.renovacion_HM set ";
									$Actualizar.= " cod_grupo = 'SR' ";
									$Actualizar.= " ,cubas_renovacion = 'SIN RENOVACION' "; 
									$Actualizar.= " ,anodos_a_renovar = ' ' ";
									$Actualizar.= " ,inicio_renovacion = ' ' ";  
									$Actualizar.= " where fecha = '".$Fechasn."'";
									$Actualizar.= " and cod_grupo = ' '";
									mysqli_query($link, $Actualizar);
								}
							else
								{  
									$consulta="select * from ref_web.renovacion_hm where fecha='".$Fechasn."' ";
									$Respuesta = mysqli_query($link, $consulta);
									while ($Fila = mysqli_fetch_array($Respuesta))
										{
											$Insertar = "INSERT INTO ref_web.renovacion_HM_temp ";
											$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
											$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
											$Insertar.= " VALUES ('".$Fila["fecha"]."','".$Fila["cod_grupo"]."','".$Fila["cubas_renovacion"]."', ";
											$Insertar.= " '".$Fila["anodos_a_renovar"]."', '".$Fila["inicio_renovacion"]."')";
											mysqli_query($link, $Insertar);
											$borrar="delete from ref_web.renovacion_hm where fecha='".$Fechasn."' ";
											mysqli_query($link, $borrar);
										} 
									$Insertar = "INSERT INTO ref_web.renovacion_HM ";
									$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
									$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
									$Insertar.= " VALUES ('".$Fechasn."','SR','SIN RENOVACION', ";
									$Insertar.= " ' ', ' ')";
									mysqli_query($link, $Insertar);
								}
							}
					

				$arreglo_cubas = explode("~",$cubas); //Separa los parametros en un array.
				$Cubas1=$arreglo_cubas[0];
				$Cubas2=$arreglo_cubas[1];
				$Cubas3=$arreglo_cubas[2];
				$Cubas4=$arreglo_cubas[3];
				$Cubas5=$arreglo_cubas[4];
				$Cubas6=$arreglo_cubas[5];
				$Cubas7=$arreglo_cubas[6];
				$Cubas8=$arreglo_cubas[7];
				$Cubas9=$arreglo_cubas[8];
				$Cubas10=$arreglo_cubas[9];
				$Cubas11=$arreglo_cubas[10];
				$Cubas12=$arreglo_cubas[11];
				$Cubas13=$arreglo_cubas[12];
				$Cubas14=$arreglo_cubas[13];
				$Cubas15=$arreglo_cubas[14];
				$Cubas16=$arreglo_cubas[15];
				$Cubas17=$arreglo_cubas[16];
				$Cubas18=$arreglo_cubas[17];
				$Cubas19=$arreglo_cubas[18];
				$Cubas20=$arreglo_cubas[19];
				$Cubas21=$arreglo_cubas[20];
				$Cubas22=$arreglo_cubas[21];
				
				$arreglo_grupos = explode("~",$grupos);
				$Grupos1=$arreglo_grupos[0];
				$Grupos2=$arreglo_grupos[1];
				$Grupos3=$arreglo_grupos[2];
				$Grupos4=$arreglo_grupos[3];
				$Grupos5=$arreglo_grupos[4];
				$Grupos6=$arreglo_grupos[5];
				$Grupos7=$arreglo_grupos[6];
				$Grupos8=$arreglo_grupos[7];
				$Grupos9=$arreglo_grupos[8];
				$Grupos10=$arreglo_grupos[9];
				$Grupos11=$arreglo_grupos[10];
				$Grupos12=$arreglo_grupos[11];
				$Grupos13=$arreglo_grupos[12];
				$Grupos14=$arreglo_grupos[13];
				$Grupos15=$arreglo_grupos[14];
				$Grupos16=$arreglo_grupos[15];
				$Grupos17=$arreglo_grupos[16];
				$Grupos18=$arreglo_grupos[17];
				$Grupos19=$arreglo_grupos[18];
				$Grupos20=$arreglo_grupos[19];
				$Grupos21=$arreglo_grupos[20];
				$Grupos22=$arreglo_grupos[21];

				if ($Mes=='02')
				{
					$ano_aux=intval($Ano);
					$mes_aux=intval($Mes);	
					$calculo=$ano_aux/4;
					$calculo2=number_format($calculo,"0","","");
					$resto=$calculo2-$calculo;
					if ($resto==0)
						{
							$bisiesto='S';
							$fin_ciclo=28;
						}
					else {
							$bisiesto='N';
							$fin_ciclo=29;
						}
				}
				else if (($Mes=='01')or ($Mes=='03')or ($Mes=='05')or ($Mes=='07')or ($Mes=='08')or ($Mes=='10')or ($Mes=='12'))    	
						{
							$fin_ciclo=31;
						}
					else {
							$fin_ciclo=30;
						}	  
				$i=1;
				$fecha_inicio= $Ano.'-'.$Mes.'-01';
				$fecha_termino= $Ano.'-'.$Mes.'-'.$fin_ciclo;
				while ($i <= $fin_ciclo)
					{
						if (strlen($i)==1)
							{
								$i='0'.$i;  
							}
						$yes='N';   
						while ($yes=='N')
						{   
							$fecha= $Ano.'-'.$Mes.'-'.$i;   
							$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION')";   
							$Respuesta = mysqli_query($link, $consulta);
							if (!$Fila = mysqli_fetch_array($Respuesta))
								{
									$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas1."'";
									$Respuesta = mysqli_query($link, $consulta);
									$Fila = mysqli_fetch_array($Respuesta);
									$Insertar = "INSERT INTO ref_web.renovacion_HM ";
									$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
									$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
									$Insertar.= " VALUES ('".$fecha."','".$Grupos1."','".$Cubas1."', ";
									$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos1."')";
									mysqli_query($link, $Insertar);
									$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas2."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
									$Respuesta = mysqli_query($link, $consulta);
									$Fila = mysqli_fetch_array($Respuesta);
									$Insertar = "INSERT INTO ref_web.renovacion_HM ";
									$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
									$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
									$Insertar.= " VALUES ('".$fecha."','".$Grupos2."','".$Cubas2."', ";
									$Insertar.= " '".$Anodos_a_renovar."', ' ')";
									mysqli_query($link, $Insertar);
									$i=$i+1;
									$yes='S';
								}
							else {
									$i=$i+1;
									$yes='N';
								}	 
					}
					if (strlen($i)==1)
						{
							$i='0'.$i;  
						}
					$yes='N';   
					while ($yes=='N')
					{   			
						$fecha= $Ano.'-'.$Mes.'-'.$i;
						$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION')"; 
						$Respuesta = mysqli_query($link, $consulta);
						if (!$Fila = mysqli_fetch_array($Respuesta))
							{
								$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas3."'";
								$Respuesta = mysqli_query($link, $consulta);
								$Fila = mysqli_fetch_array($Respuesta);
								$Insertar = "INSERT INTO ref_web.renovacion_HM ";
								$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
								$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
								$Insertar.= " VALUES ('".$fecha."','".$Grupos3."','".$Cubas3."', ";
								$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos3."')";
								mysqli_query($link, $Insertar);
								$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas4."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
								$Respuesta = mysqli_query($link, $consulta);
								$Fila = mysqli_fetch_array($Respuesta);
								$Insertar = "INSERT INTO ref_web.renovacion_HM ";
								$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
								$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
								$Insertar.= " VALUES ('".$fecha."','".$Grupos4."','".$Cubas4."', ";
								$Insertar.= " '".$Anodos_a_renovar."', ' ')";
								mysqli_query($link, $Insertar);
								$i=$i+1;
								$yes='S';
							}
						else {
								$i=$i+1;
								$yes='N';
							 }	 
					} 
					$yes='N';  
					if (strlen($i)==1)
						{
							$i='0'.$i;  
						} 
					while ($yes=='N')
						{   		 
							$fecha= $Ano.'-'.$Mes.'-'.$i;
							$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION')"; 
							//echo $consulta."<br>";  
							$Respuesta = mysqli_query($link, $consulta);
							if (!$Fila = mysqli_fetch_array($Respuesta))
								{
									$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas5."'";
									$Respuesta = mysqli_query($link, $consulta);
									$Fila = mysqli_fetch_array($Respuesta);
									$Insertar = "INSERT INTO ref_web.renovacion_HM ";
									$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
									$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
									$Insertar.= " VALUES ('".$fecha."','".$Grupos5."','".$Cubas5."', ";
									$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos5."')";
									mysqli_query($link, $Insertar);
									$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas6."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
									$Respuesta = mysqli_query($link, $consulta);
									$Fila = mysqli_fetch_array($Respuesta);
									$Insertar = "INSERT INTO ref_web.renovacion_HM ";
									$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
									$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
									$Insertar.= " VALUES ('".$fecha."','".$Grupos6."','".$Cubas6."', ";
									$Insertar.= " '".$Anodos_a_renovar."', ' ')";
									mysqli_query($link, $Insertar);
									$i=$i+1;
									$yes='S';
								} 
							else {
									$i=$i+1;
									$yes='N';
								}	 
						} 
					$yes='N'; 
					if (strlen($i)==1)
						{
							$i='0'.$i;  
						}  
					while ($yes=='N')
						{   	  
							$fecha= $Ano.'-'.$Mes.'-'.$i;
							$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION')";  
							$Respuesta = mysqli_query($link, $consulta);
							if (!$Fila = mysqli_fetch_array($Respuesta))
								{
									$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas7."'";
									$Respuesta = mysqli_query($link, $consulta);
									$Fila = mysqli_fetch_array($Respuesta);
									$Insertar = "INSERT INTO ref_web.renovacion_HM ";
									$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
									$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
									$Insertar.= " VALUES ('".$fecha."','".$Grupos7."','".$Cubas7."', ";
									$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos7."')";
									mysqli_query($link, $Insertar);
									$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas8."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
									$Respuesta = mysqli_query($link, $consulta);
									$Fila = mysqli_fetch_array($Respuesta);
									$Insertar = "INSERT INTO ref_web.renovacion_HM ";
									$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
									$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
									$Insertar.= " VALUES ('".$fecha."','".$Grupos8."','".$Cubas8."', ";
									$Insertar.= " '".$Anodos_a_renovar."', ' ')";
									mysqli_query($link, $Insertar);
									$i=$i+1;
									$yes='S';
								} 
							else {
									$i=$i+1;
									$yes='N';
								}	 
						} 
					$yes='N';
					if (strlen($i)==1)
						{
							$i='0'.$i;  
						}   
					while ($yes=='N')
						{   	  		
							$fecha= $Ano.'-'.$Mes.'-'.$i;
							$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION')";  
							$Respuesta = mysqli_query($link, $consulta);
							if (!$Fila = mysqli_fetch_array($Respuesta))
							{
							$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas9."'";
							$Respuesta = mysqli_query($link, $consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							$Insertar = "INSERT INTO ref_web.renovacion_HM ";
							$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
							$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
							$Insertar.= " VALUES ('".$fecha."','".$Grupos9."','".$Cubas9."', ";
							$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos9."')";
							mysqli_query($link, $Insertar);
							$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas10."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
							$Respuesta = mysqli_query($link, $consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							$Insertar = "INSERT INTO ref_web.renovacion_HM ";
							$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
							$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
							$Insertar.= " VALUES ('".$fecha."','".$Grupos10."','".$Cubas10."', ";
							$Insertar.= " '".$Anodos_a_renovar."', ' ')";
							mysqli_query($link, $Insertar);
							$i=$i+1;
							$yes='S';
						}
					else {
							$i=$i+1;
							$yes='N';
						}	 
				} 
			$yes='N';  
			if (strlen($i)==1)
				{
					$i='0'.$i;  
				} 
			while ($yes=='N')
				{   	  		 
					$fecha= $Ano.'-'.$Mes.'-'.$i;
					$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION')";   
					$Respuesta = mysqli_query($link, $consulta);
					if (!$Fila = mysqli_fetch_array($Respuesta))
						{
							$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas11."'";
							$Respuesta = mysqli_query($link, $consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							$Insertar = "INSERT INTO ref_web.renovacion_HM ";
							$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
							$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
							$Insertar.= " VALUES ('".$fecha."','".$Grupos11."','".$Cubas11."', ";
							$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos12."')";
							mysqli_query($link, $Insertar);
							$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas12."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
							$Respuesta = mysqli_query($link, $consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							$Insertar = "INSERT INTO ref_web.renovacion_HM ";
							$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
							$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
							$Insertar.= " VALUES ('".$fecha."','".$Grupos12."','".$Cubas12."', ";
							$Insertar.= " '".$Anodos_a_renovar."', ' ')";
							mysqli_query($link, $Insertar);
							$i=$i+1;
							$yes='S';
						}
					else {
							$i=$i+1;
							$yes='N';
						}	 
				} 
			$yes='N'; 
			if (strlen($i)==1)
				{
					$i='0'.$i;  
				}  
			while ($yes=='N')
				{   	  		 
					$fecha= $Ano.'-'.$Mes.'-'.$i;
					$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION')";   
					//echo $consulta."<br>";
					$Respuesta = mysqli_query($link, $consulta);
					if (!$Fila = mysqli_fetch_array($Respuesta))
						{
							$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas13."'";
							$Respuesta = mysqli_query($link, $consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							$Insertar = "INSERT INTO ref_web.renovacion_HM ";
							$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
							$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
							$Insertar.= " VALUES ('".$fecha."','".$Grupos13."','".$Cubas13."', ";
							$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos13."')";
							//echo $Insertar."<br>";
							mysqli_query($link, $Insertar);
							$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas14."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
							$Respuesta = mysqli_query($link, $consulta);
							$Fila = mysqli_fetch_array($Respuesta);
							$Insertar = "INSERT INTO ref_web.renovacion_HM ";
							$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
							$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
							$Insertar.= " VALUES ('".$fecha."','".$Grupos14."','".$Cubas14."', ";
							$Insertar.= " '".$Anodos_a_renovar."', ' ')";
							//echo $Insertar."<br>";
							mysqli_query($link, $Insertar);
							$i=$i+1;
							$yes='S';
						}
					else {
							$i=$i+1;
							$yes='N';
						}	 
				}
			$yes='N'; 
			if (strlen($i)==1)
				{
					$i='0'.$i;  
				}    
			while ($yes=='N')
				{   	   	 
					$fecha= $Ano.'-'.$Mes.'-'.$i;
					$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION') ";
					//echo $consulta."<br>";   
					$Respuesta = mysqli_query($link, $consulta);
					if (!$Fila = mysqli_fetch_array($Respuesta))
					{
					$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas15."'";
					$Respuesta = mysqli_query($link, $consulta);
					$Fila = mysqli_fetch_array($Respuesta);						
					$Insertar = "INSERT INTO ref_web.renovacion_HM ";
					$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
					$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
					$Insertar.= " VALUES ('".$fecha."','".$Grupos15."','".$Cubas15."', ";
					$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos15."')";
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
					$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas16."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
					$Respuesta = mysqli_query($link, $consulta);
					$Fila = mysqli_fetch_array($Respuesta);						 
					$Insertar = "INSERT INTO ref_web.renovacion_HM ";
					$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
					$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
					$Insertar.= " VALUES ('".$fecha."','".$Grupos16."','".$Cubas16."', ";
					$Insertar.= " '".$Anodos_a_renovar."', ' ')";
					//echo $Insertar."<br>";
					mysqli_query($link, $Insertar);
					$i=$i+1;
					$yes='S';
				}
			else {
					$i=$i+1;
					$yes='N';
				}	 
		} 
		
		$yes='N'; 
		if (strlen($i)==1)
			{
				$i='0'.$i;  
			}    
		while ($yes=='N')
			{   	   	 
				$fecha= $Ano.'-'.$Mes.'-'.$i;
				$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION') ";
				//echo $consulta."<br>";   
				$Respuesta = mysqli_query($link, $consulta);
				if (!$Fila = mysqli_fetch_array($Respuesta))
					{
						$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas17."'";
						$Respuesta = mysqli_query($link, $consulta);
						$Fila = mysqli_fetch_array($Respuesta);						
						$Insertar = "INSERT INTO ref_web.renovacion_HM ";
						$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
						$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
						$Insertar.= " VALUES ('".$fecha."','".$Grupos17."','".$Cubas17."', ";
						$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos17."')";
						//echo $Insertar."<br>";
						mysqli_query($link, $Insertar);
						$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas18."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
						$Respuesta = mysqli_query($link, $consulta);
						$Fila = mysqli_fetch_array($Respuesta);						 
						$Insertar = "INSERT INTO ref_web.renovacion_HM ";
						$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
						$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
						$Insertar.= " VALUES ('".$fecha."','".$Grupos18."','".$Cubas18."', ";
						$Insertar.= " '".$Anodos_a_renovar."', ' ')";
						//echo $Insertar."<br>";
						mysqli_query($link, $Insertar);
						$i=$i+1;
						$yes='S';
					}
				else {
						$i=$i+1;
						$yes='N';
					}	 
			} 
		
		$yes='N'; 
		if (strlen($i)==1)
			{
				$i='0'.$i;  
			}    
		while ($yes=='N')
			{   	   	 
				$fecha= $Ano.'-'.$Mes.'-'.$i;
				$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION') ";
				//echo $consulta."<br>";   
				$Respuesta = mysqli_query($link, $consulta);
				if (!$Fila = mysqli_fetch_array($Respuesta))
					{
						$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas19."'";
						$Respuesta = mysqli_query($link, $consulta);
						$Fila = mysqli_fetch_array($Respuesta);						
						$Insertar = "INSERT INTO ref_web.renovacion_HM ";
						$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
						$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
						$Insertar.= " VALUES ('".$fecha."','".$Grupos19."','".$Cubas19."', ";
						$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos19."')";
						//echo $Insertar."<br>";
						mysqli_query($link, $Insertar);
						$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas20."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
						$Respuesta = mysqli_query($link, $consulta);
						$Fila = mysqli_fetch_array($Respuesta);						 
						$Insertar = "INSERT INTO ref_web.renovacion_HM ";
						$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
						$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
						$Insertar.= " VALUES ('".$fecha."','".$Grupos20."','".$Cubas20."', ";
						$Insertar.= " '".$Anodos_a_renovar."', ' ')";
						//echo $Insertar."<br>";
						mysqli_query($link, $Insertar);
						$i=$i+1;
						$yes='S';
					}
				else {
						$i=$i+1;
						$yes='N';
					}	 
			} 
		$yes='N'; 
		if (strlen($i)==1)
			{
				$i='0'.$i;  
			}    
		while ($yes=='N')
			{   	   	 
				$fecha= $Ano.'-'.$Mes.'-'.$i;
				$consulta="select * from ref_web.renovacion_hm where fecha='".$fecha."' and (cubas_renovacion='Renovacion Grupo 8 Comercial' or cubas_renovacion='SIN RENOVACION') ";
				//echo $consulta."<br>";   
				$Respuesta = mysqli_query($link, $consulta);
				if (!$Fila = mysqli_fetch_array($Respuesta))
					{
						$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas21."'";
						$Respuesta = mysqli_query($link, $consulta);
						$Fila = mysqli_fetch_array($Respuesta);						
						$Insertar = "INSERT INTO ref_web.renovacion_HM ";
						$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
						$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
						$Insertar.= " VALUES ('".$fecha."','".$Grupos21."','".$Cubas21."', ";
						$Insertar.= " '".$Anodos_a_renovar."', '".$Grupos21."')";
						//echo $Insertar."<br>";
						mysqli_query($link, $Insertar);
						$consulta="select distinct cod_grupo from ref_web.renovacion_hm where cubas_renovacion='".$Cubas22."' and cod_grupo not in ('".$Fila["cod_grupo"]."')";
						$Respuesta = mysqli_query($link, $consulta);
						$Fila = mysqli_fetch_array($Respuesta);						 
						$Insertar = "INSERT INTO ref_web.renovacion_HM ";
						$Insertar.= " (fecha,cod_grupo,cubas_renovacion, ";
						$Insertar.= " anodos_a_renovar,inicio_renovacion) ";
						$Insertar.= " VALUES ('".$fecha."','".$Grupos22."','".$Cubas22."', ";
						$Insertar.= " '".$Anodos_a_renovar."', ' ')";
						//echo $Insertar."<br>";
						mysqli_query($link, $Insertar);
						$i=$i+1;
						$yes='S';
					}
				else {
						$i=$i+1;
						$yes='N';
					}	 
			} 
		}
		
		break;	

		
	}
	header("location:ref_ing_ren_HM2.php?Proceso=M&Dia=".intval($Dia)."&Mes=".intval($Mes)."&Ano=".intval($Ano));
	echo "<script languaje='JavaScript'>";
	echo "window.opener.document.frmPrincipal.action = 'Renovacion_HM.php?opcion=H';";
	echo "window.opener.document.frmPrincipal.submit();";
	echo "window.close();";
	echo "</script>"; 
			   
			
		
?>