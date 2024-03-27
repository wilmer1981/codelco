<? include("../principal/conectar_sget_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			
			$Consulta = "SELECT ifnull(max(cod_mutual),0) as mayor from sget_mutuales_seg"; 
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysql_fetch_array($Respuesta);
			$Mayor=$Fila["mayor"] + 1;			
			
			$Inserta="INSERT INTO sget_mutuales_seg (cod_mutual,descripcion,abreviatura,estado)";
			$Inserta.=" values('".$Mayor."','".strtoupper($Descri)."', '".strtoupper($TxtAbreviatura)."','".$CmbEstado."')";
			mysql_query($Inserta);
			//echo 	$Inserta;
			if($Volver=='S')
			{
			
					echo "<script languaje='JavaScript'>";		
					echo " window.opener.document.FrmProceso.action='sget_mantenedor_empresas_proceso.php?Mutuales=$Mayor';";
					echo " window.opener.document.FrmProceso.submit();";		
					echo " window.close();</script>";
			
			}
			else
			{	
					echo "<script languaje='JavaScript'>";		
					//echo "window.opener.document.frmPrincipal.action='sget_mantenedor_personal.php?BuscarRut=S&MostrarInact=N&Rut=".str_pad(trim($TxtRut),10,'0',STR_PAD_LEFT)."';";

					echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_mutuales.php?Buscar=S';";
					echo " window.opener.document.FrmPrincipal.submit();";		
					echo " window.close();</script>";
			}		
			
			
		break;
		case "M":
		
				
				$Actualizar="UPDATE sget_mutuales_seg set descripcion='".strtoupper($Descri)."',abreviatura='".strtoupper($TxtAbreviatura)."',estado='".$CmbEstado."' ";
				$Actualizar.=" where cod_mutual='".$Codigo."'";	
				mysql_query($Actualizar);
				
			if($Volver=='S')
			{
			
					echo "<script languaje='JavaScript'>";		
					echo " window.opener.document.FrmProceso.action='sget_mantenedor_empresas_proceso.php?Mutuales=$Codigo';";
					echo " window.opener.document.FrmProceso.submit();";		
					echo " window.close();</script>";
			
			}
			else
			{	
					echo "<script languaje='JavaScript'>";		
					echo " window.opener.document.FrmPrincipal.action='sget_mantenedor_mutuales.php?Buscar=S';";
					echo " window.opener.document.FrmPrincipal.submit();";		
					echo " window.close();</script>";
			}		
				
			
		break;
		
		case "E":
			$Mensaje='N';
			echo "$Eliminar";
			$Datos = explode("//",$Valor);
			foreach($Datos as $clave => $Codigo)
			{

				$Consulta="SELECT * from sget_contratistas where cod_mutual_seguridad='".$Codigo."'";
				$Respuesta=mysqli_query($link, $Consulta);
				if(!$Fila=mysql_fetch_array($Respuesta))
				{
					$Eliminar="delete from sget_mutuales_seg where cod_mutual='".$Codigo."'";
					mysql_query($Eliminar);
				}
				else
				{
					$Mensaje='S';
				}	
			}
			header("location:sget_mantenedor_mutuales.php?Mensaje=".$Mensaje."&Buscar=S");
		break;
	
	}
?>
