<?php
	include("../principal/conectar_fac_web.php");
	$MarcaCatodo=$TxtMarca;
	$Desceipcion=$TxtDes;
	$Descripcion1=$TxtDes1;
	switch ($Proceso)
	{
		case "N":
			$Consulta="SELECT * from sec_web.marca_catodos where cod_marca='".$MarcaCatodo."'";
			$Respuesta=mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Respuesta))
			{
				$Mensaje='Marca Catodo ya Existe';
				$Variables="Mensaje=".$Mensaje."&TxtMarca=".$TxtMarca."&TxtDes=".$TxtDes;
				header("location:sec_ingreso_marca_proceso.php?Proceso=N&".$Variables);
			}
			else
			{
				$Consulta="SELECT * from sec_web.marca_catodos where ";
				$Insertar="insert into sec_web.marca_catodos (cod_marca,descripcion,descripcion_ingles) values (";
				$Insertar = $Insertar."'$TxtMarca','$TxtDes','$TxtDes1')";
				mysqli_query($link, $Insertar);
			}	
			break;
	}
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmProceso.action='sec_adm_lotes.php';";
		echo "window.opener.document.FrmProceso.submit();";
		echo "window.close();";
		echo "</script>";	
	
?>
