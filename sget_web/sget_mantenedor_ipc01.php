<? 
	include("../principal/conectar_sget_web.php");
	$Encontro=false;
	switch($Opcion)
	{
		case "N":
			$Valor=explode('~',$Valores);
			for($i=1;$i<=12;$i++)
			{
				if($Valor[$i-1]!='')
					$ValorIng=$Valor[$i-1];
				else
					$ValorIng=0;	
				$Inserta="INSERT INTO sget_ipc (ano,mes,valor)";
				$Inserta.=" values('".$CmbAno."','".$i."','".str_replace(',','.',$ValorIng)."')";
				//echo $Inserta."<br>";
				mysql_query($Inserta);
			}
			//echo 	$Inserta;
			echo "<script languaje='JavaScript'>";		
			echo " window.opener.document.FrmPrincipal.action=\"sget_mantenedor_ipc.php\";";
			echo " window.opener.document.FrmPrincipal.submit();";		
			echo " window.close();</script>";
		break;
		case "M":
				//echo $Valores;
				$Valor=explode('~',$Valores);
				for($i=1;$i<=12;$i++)
				{
					if($Valor[$i-1]!='')
						$ValorIng=$Valor[$i-1];
					else
						$ValorIng=0;	
					$Actualizar="UPDATE sget_ipc set valor='".str_replace(',','.',$ValorIng)."' ";
					$Actualizar.=" where ano='".$Codigo."' and mes='".$i."'";	
					//echo $Actualizar."<br>";
					mysql_query($Actualizar);
				}
				echo "<script languaje='JavaScript'>";		
				echo " window.opener.document.FrmPrincipal.action=\"sget_mantenedor_ipc.php\";";
				echo " window.opener.document.FrmPrincipal.submit();";		
				echo " window.close();</script>";
		break;
		case "E":
			$Mensaje='N';
			echo "$Eliminar";
			$Datos = explode("//",$Valor);
			foreach($Datos as $clave => $Codigo)
			{
				$Eliminar="delete from sget_ipc where ano='".$Codigo."'";
				mysql_query($Eliminar);
			}
			header("location:sget_mantenedor_ipc.php?Pagina=".$Pagina."&Mensaje=".$Mensaje);
		break;
	}
?>
