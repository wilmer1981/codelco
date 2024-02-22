<?php
	include("../principal/conectar_pmn_web.php");

		
	//Valida Contrasea.
	$consulta = "select  * from proyecto_modernizacion.funcionarios where rut = '".$CookieRut."'";
	$consulta.= " and password2=md5('".strtoupper(trim($txtpassword))."')";
	$rs3 = mysqli_query($link, $consulta);		
	if ($row3 = mysqli_fetch_array($rs3))
	{
		//Abre el anexo para ser modificado.
		if ($proceso == 'AA')
		{
			//Actualiza el campo bloqueado de la tabla existencia_nodos a cero (0).
			$actualizar = "UPDATE pmn_web.existencia_nodo SET bloqueado = '0'";
			$actualizar.= " WHERE ano = '".$ano."' AND mes = '".$mes."'";
			mysqli_query($link, $actualizar);			
			
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmPrincipal.action = 'pmn_con_balance_anexo.php?Proceso=S';";
			echo "window.opener.document.frmPrincipal.submit();";
			echo "window.close()";
			echo "</script>";
		}
		
		//Abre el listado para ser modificado.
		if ($proceso == 'AL')
		{
			$actualizar = "UPDATE pmn_web.resultado_productos SET bloqueado = 'N'";
			$actualizar.= " WHERE tipo_mov = '".$cmbmovimiento."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."' ";
			
			if (($cmbproducto == '25') and ($cmbsubproducto == '1') and ($cmbmovimiento == '1'))			
				$actualizar.= " AND lote = '".$ano1."-".str_pad($mes,2,'0',STR_PAD_LEFT)."-01'";
			else
				$actualizar.= " AND YEAR(fecha) = '".$ano1."' AND MONTH(fecha) = '".$mes1."'";
			//echo $actualizar."<br>";
			mysqli_query($link, $actualizar);
		
			$linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=".$cmbmovimiento."&cmbproducto=".$cmbproducto."&cmbsubproducto=".$cmbsubproducto;
			$linea.= "&ano1=".$ano1."&mes1=".$mes1;
			
			echo "<script languaje='JavaScript'>";
			echo "window.opener.document.frmListado.action = 'pmn_con_tipo_movimiento.php?".$linea."';";
			echo "window.opener.document.frmListado.submit();";
			echo "window.close()";
			echo "</script>";							
		}										
	}
	else
	{
		//Mensaje.
		$mensaje = "La Password No Es Correcta";
		$linea = "mensaje=".$mensaje."&ano=".$ano."&mes=".$mes."&Sistema=PMN";
		
		header("Location:ing_cierra_mes_popup.php?".$linea);		
	}

?>