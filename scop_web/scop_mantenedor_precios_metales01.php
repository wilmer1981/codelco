<?  
	include("../principal/conectar_scop_web.php");
	include("funciones/scop_funciones.php");	
	$Encontro=false;
	//ENVIO DE CORREOS
	switch($Opcion)
	{
		case "NP":		
			$TxtValorCu=str_replace(",",".",$TxtValorCu);
			$TxtValorAg=str_replace(",",".",$TxtValorAg);	
			$TxtValorAu=str_replace(",",".",$TxtValorAu);
			$Consulta="select cod_ley from scop_precios_metales where ano='".$Ano."' and mes='".$Mes."'";
			$Resp=mysqli_query($link, $Consulta);
			if(!$Fila=mysql_fetch_array($Resp))
			{
				for($i=1;$i<=3;$i++)
				{
					$Insertar="INSERT INTO scop_precios_metales (ano,mes,cod_ley) values('".$Ano."','".$Mes."','".$i."')";
					mysql_query($Insertar);
					
					if($i=='1')
					{						
						$Actualizar="UPDATE scop_precios_metales set valor='".$TxtValorCu."',cod_unidad='".$UniCu."' where ano='".$Ano."' and mes='".$Mes."' and cod_ley='".$i."'";
						mysql_query($Actualizar);
					}
					if($i=='2')
					{
						$Actualizar="UPDATE scop_precios_metales set valor='".$TxtValorAg."',cod_unidad='".$UniAg."' where ano='".$Ano."' and mes='".$Mes."' and cod_ley='".$i."'";
						mysql_query($Actualizar);
					}
					if($i=='3')
					{					
						$Actualizar="UPDATE scop_precios_metales set valor='".$TxtValorAu."',cod_unidad='".$UniAu."' where ano='".$Ano."' and mes='".$Mes."' and cod_ley='".$i."'";
						mysql_query($Actualizar);
					}	
				}
				//ENVIO DE CORREO FUNCION	Para que Carry Cost Valide Precios. 				
				$Consulta="select * from proyecto_modernizacion.sub_clase";
				$Consulta.=" where cod_clase='33007' and nombre_subclase<>''  and not isnull(nombre_subclase) and valor_subclase1='3'";
				//echo $Consulta."<br>";
				$RespCorreo=mysqli_query($link, $Consulta);
				while($FilaCorreo=mysql_fetch_array($RespCorreo))
						EnvioCorreo($FilaCorreo["nombre_subclase"],'4','',$Ano,$Mes,$Meses,'CA','','','','','','');	//ENVIO CORREO GRABA CARRY COST ESTADO 4
				
				$Envio='N';
				$Consulta="select * from proyecto_modernizacion.sub_clase";
				$Consulta.=" where cod_clase='33007' and nombre_subclase<>''  and not isnull(nombre_subclase) and valor_subclase1='3'";
				//echo $Consulta."<br>";
				$RespCorreo=mysqli_query($link, $Consulta);
				if($FilaCorreo=mysql_fetch_array($RespCorreo))
					$Envio='S';
				
				$Mensaje='1';
				header('location:scop_mantenedor_precios_metales.php?Opc=NP&Mensaje='.$Mensaje);												
			}	
			else
			{
				$Mensaje='2';
				$Cod=$Ano."~".$Mes;	
				header('location:scop_mantenedor_precios_metales.php?Opc=MP&Mensaje='.$Mensaje.'&Valores='.$Cod);				
			}
		break;
		case "MP":
			$TxtValorCu=str_replace(".","",$TxtValorCu);
			$TxtValorCu=str_replace(",",".",$TxtValorCu);
			$TxtValorAg=str_replace(".","",$TxtValorAg);	
			$TxtValorAg=str_replace(",",".",$TxtValorAg);	
			$TxtValorAu=str_replace(".","",$TxtValorAu);
			$TxtValorAu=str_replace(",",".",$TxtValorAu);
			
			for($i=1;$i<=3;$i++)
			{
				if($i=='1')
				{						
					$Actualizar="UPDATE scop_precios_metales set valor='".$TxtValorCu."',cod_unidad='".$UniCu."' where ano='".$Ano."' and mes='".$Mes."' and cod_ley='".$i."'";
					mysql_query($Actualizar);
				}
				if($i=='2')
				{
					$Actualizar="UPDATE scop_precios_metales set valor='".$TxtValorAg."',cod_unidad='".$UniAg."' where ano='".$Ano."' and mes='".$Mes."' and cod_ley='".$i."'";
					mysql_query($Actualizar);
				}
				if($i=='3')
				{					
					$Actualizar="UPDATE scop_precios_metales set valor='".$TxtValorAu."',cod_unidad='".$UniAu."' where ano='".$Ano."' and mes='".$Mes."' and cod_ley='".$i."'";
					mysql_query($Actualizar);
				}	
			}
			$Mensaje='3';
			header('location:scop_mantenedor_precios_metales.php?Opc=NP&Mensaje='.$Mensaje);	
		break;		
		case "EP":
			$Datos=explode("~",$Valores);			
			
			for($i=1;$i<=3;$i++)
			{
				$Eliminar="delete from scop_precios_metales where ano='".$Datos[0]."' and mes='".$Datos[1]."' and cod_ley='".$i."'";
				//echo $Eliminar;
				mysql_query($Eliminar);
			}	
			$Mensaje="4";
			header('location:scop_mantenedor_precios_metales.php?Opc=NP&Mensaje='.$Mensaje);		
		break;
	}
?>
