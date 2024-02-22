<? 
	include("../principal/conectar_sget_web.php");
	include("funciones/sget_funciones.php");
	$Fecha_Creacion= date("Y-m-d G:i:s");

	switch($Opcion)
	{
		case "G"://MODIFICAR BONO
		/*	$Consulta = "SELECT * from tmp_cert";
			$Resp = mysql_query($Consulta);
			while ($Fila=mysql_fetch_array($Resp))
			{
				$Actualizar1="Update sget_personal set num_cert_antecedentes = '".$Fila[certificado]."' ";
				$Actualizar1.= " where rut = '".$Fila["rut"]."'";
				mysql_query($Actualizar1);
				echo "WW".$Actualizar1;
			}*/
			
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~~',$v);
				$Actualizar="Update sget_personal set num_cert_antecedentes = '".$Datos2[1]."' ";
				$Actualizar.= " where rut = '".$Datos2[0]."'";
				mysql_query($Actualizar);
				echo "SS".$Actualizar;
			}
			header("location:sget_mantenedor_antecedentes.php?Buscar=S&TxtApellido=".$TxtApellido."");  

			/*echo "<script languaje='JavaScript'>";
			echo "window.opener.document.FrmPrincipal.action='sget_mantenedor_antecedentes.php?Buscar=S';";
			echo "window.opener.document.FrmPrincipal.submit();";
			echo "window.close();</script>";*/
		break;
	}
?>
