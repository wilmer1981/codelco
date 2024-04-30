<?php
	include("../principal/conectar_principal.php");

	$Proceso   = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Dia    = isset($_REQUEST["Dia"])?$_REQUEST["Dia"]:"";
	$Mes    = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:"";
	$Ano    = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
	$Valores= isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";

	switch ($Proceso)
	{
		case "G":
			//CONCEPTO = A1
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '1'";
			$Consulta.= " and cod_concepto = 'A'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_A1."' ";
				$Actualizar.= " ,desc_parcial = '".$DP."' "; 
				$Actualizar.= " ,electro_win = '".$EW."' "; 
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '1'";
				$Actualizar.= " and cod_concepto = 'A'";
				//echo $Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '1', 'A', '".$G_A1."', '".$DP."', '".$EW."')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			//CONCEPTO = A2
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '2'";
			$Consulta.= " and cod_concepto = 'A'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_A2."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '2'";
				$Actualizar.= " and cod_concepto = 'A'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '2', 'A', '".$G_A2."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			/*CONCEPTO = A3*/
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '3'";
			$Consulta.= " and cod_concepto = 'A'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_A3."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '3'";
				$Actualizar.= " and cod_concepto = 'A'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '3', 'A', '".$G_A3."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			
			//CONCEPTO = B1
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '4'";
			$Consulta.= " and cod_concepto = 'B'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_B1."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '4'";
				$Actualizar.= " and cod_concepto = 'B'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '4', 'B', '".$G_B1."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			//CONCEPTO = B2
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '5'";
			$Consulta.= " and cod_concepto = 'B'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_B2."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '5'";
				$Actualizar.= " and cod_concepto = 'B'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '5', 'B', '".$G_B2."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			
			/*CONCEPTO = B3*/
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '6'";
			$Consulta.= " and cod_concepto = 'B'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_B3."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '6'";
				$Actualizar.= " and cod_concepto = 'B'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '6', 'B', '".$G_B3."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			//concepto = C1
			
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '7'";
			$Consulta.= " and cod_concepto = 'C'";
			
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_C1."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '7'";
				$Actualizar.= " and cod_concepto = 'C'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '7', 'C', '".$G_C1."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
	//concepto = C2
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '8'";
			$Consulta.= " and cod_concepto = 'C'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_C2."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '8'";
				$Actualizar.= " and cod_concepto = 'C'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '8', 'C', '".$G_C2."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}

			//concepto c3
				
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '9'";
			$Consulta.= " and cod_concepto = 'C'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_C3."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '9'";
				$Actualizar.= " and cod_concepto = 'C'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '9', 'C', '".$G_C3."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			//CONCEPTO = D1
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '10'";
			$Consulta.= " and cod_concepto = 'D'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_D1."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '10'";
				$Actualizar.= " and cod_concepto = 'D'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '10', 'D', '".$G_D1."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			//CONCEPTO = D2
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '11'";
			$Consulta.= " and cod_concepto = 'D'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_D2."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '11'";
				$Actualizar.= " and cod_concepto = 'D'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '11', 'D', '".$G_D2."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>"; 
			}
			//CONCEPTO = D3
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '12'";
			$Consulta.= " and cod_concepto = 'D'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_D3."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '12'";
				$Actualizar.= " and cod_concepto = 'D'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '12', 'D', '".$G_D3."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
			
			$FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '13'";
			$Consulta.= " and cod_concepto = 'D'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_D4."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '13'";
				$Actualizar.= " and cod_concepto = 'D'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '13', 'D', '".$G_D4."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
		  $FechaRenovacion = $Ano."-".$Mes."-01";
		  $Consulta = "select * from sec_web.renovacion_prog_prod ";
		  $Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
		  $Consulta.= " and dia_renovacion = '".intval($Dia)."'";
		  $Consulta.= " and fila_renovacion = '14'";
		  $Consulta.= " and cod_concepto = 'D'";
		  $Respuesta = mysqli_query($link, $Consulta);
		  if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_D5."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '14'";
				$Actualizar.= " and cod_concepto = 'D'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '14', 'D', '".$G_D5."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}
		  $FechaRenovacion = $Ano."-".$Mes."-01";
			$Consulta = "select * from sec_web.renovacion_prog_prod ";
			$Consulta.= " where fecha_renovacion = '".$FechaRenovacion."'";
			$Consulta.= " and dia_renovacion = '".intval($Dia)."'";
			$Consulta.= " and fila_renovacion = '15'";
			$Consulta.= " and cod_concepto = 'D'";
			$Respuesta = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Respuesta))
			{
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " cod_grupo = '".$G_D6."' ";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '15'";
				$Actualizar.= " and cod_concepto = 'D'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
			}
			else
			{			
				$Insertar = "INSERT INTO sec_web.renovacion_prog_prod ";
				$Insertar.= " (fecha_renovacion, dia_renovacion, fila_renovacion, cod_concepto, ";
				$Insertar.= " cod_grupo, desc_parcial, electro_win) ";
				$Insertar.= " VALUES ('".$FechaRenovacion."', '".intval($Dia)."', ";
				$Insertar.= " '15', 'D', '".$G_D6."', '', '')";
				mysqli_query($link, $Insertar);
				//echo $Insertar."<br>";
			}	
			header("location:ref_ing_ren_prog_prod.php?Proceso=M&Dia=".intval($Dia)."&Mes=".intval($Mes)."&Ano=".intval($Ano));
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action = 'Renovacion_grupos.php?opcion=H';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close();";
			echo "</script>";
			break;
		case "MT":
			$FechaRenovacion = $ano1."-".$mes1."-01";
			$Datos=explode('//',$Valores);
			foreach($Dat as $c => $v)
			{
				$Datos2=explode('~',$v);
				$Dia=$Datos2[0];
				for($i=1;$i<=12;$i++)
				{
					$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
					$Actualizar.= " cod_grupo = '".$Datos2[$i]."' ";
					$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
					$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
					$Actualizar.= " and fila_renovacion = '".$i."'";
					if($i<=3)
						$Actualizar.= " and cod_concepto = 'A'";
					if($i>3&&$i<=6)
						$Actualizar.= " and cod_concepto = 'B'";
					if($i>6&&$i<=9)
						$Actualizar.= " and cod_concepto = 'C'";
					if($i>9&&$i<=12)
						$Actualizar.= " and cod_concepto = 'D'";
					//echo $Actualizar."<br>";
					mysqli_query($link, $Actualizar);
				}
				$DescParcial='';$EW='';
				if($Datos2[13]!='')
					$DescParcial="PARCIAL ".intval($Datos2[13]);
				if($Datos2[14]!='')
					$EW="E.W. ".intval($Datos2[14]);
				$Actualizar = "UPDATE sec_web.renovacion_prog_prod set ";
				$Actualizar.= " desc_parcial='".$DescParcial."',electro_win='".$EW."'";
				$Actualizar.= " where fecha_renovacion = '".$FechaRenovacion."'";
				$Actualizar.= " and dia_renovacion = '".intval($Dia)."'";
				$Actualizar.= " and fila_renovacion = '1'";
				mysqli_query($link, $Actualizar);
			}
			header("location:Renovacion_grupos2.php?opcion=H&mes1=".intval($mes1)."&ano1=".intval($ano1));
			break;	
	}
?>