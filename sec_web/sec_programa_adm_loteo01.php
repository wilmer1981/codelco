<?php 	
	include("../principal/conectar_sec_web.php");	

	$Proceso        = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
	$Valores        = isset($_REQUEST["Valores"])?$_REQUEST["Valores"]:"";
	$ElimVirtual    = isset($_REQUEST["ElimVirtual"])?$_REQUEST["ElimVirtual"]:"";
	$CorrEnmVirElim = isset($_REQUEST["CorrEnmVirElim"])?$_REQUEST["CorrEnmVirElim"]:"";
	$Cierra         = isset($_REQUEST["Cierra"])?$_REQUEST["Cierra"]:"";

	$Datos=explode('//',$Valores);
	$CodLote = "";
	$NumLote = "";
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$IE                = $Datos2[0];
		$NombreProducto    = $Datos2[1];
		$NombreSubProducto = $Datos2[2];
		$CodProducto   = $Datos2[3];    
		$CodSubProducto= $Datos2[4];
		$Peso          = $Datos2[5];
		$TipoIE        = $Datos2[6];
		$CodLote       = $Datos2[8];
		$NumLote       = $Datos2[9];
		$PesoPreparado = $Datos2[7];
		$Marca         = $Datos2[10];
		if ($PesoPreparado=='')
		{
			$PesoPreparado=0;
		}
	}
	
//RENE PARA ELIMINAR INTRUCCIONES VIRTUALES SIN PRODUCTO
if($ElimVirtual=='S')
{
	$Eliminar="delete from instruccion_virtual where corr_virtual='".$CorrEnmVirElim."'";
	//echo $Eliminar;
	mysqli_query($link, $Eliminar);
	
	header("location:sec_programa_adm_loteo.php?TipoIE=Virtual&Msj=Intrucci�n Eliminada con �xito.");
}	
else
{
	//poly Lote Despachado//
	if (($CodLote == "") || ($NumLote == "") && ($Proceso == 'F'))
	{
		//echo "hola".$Proceso;
		$Error = 'N';
		$Consulta="select * from sec_web.embarque_ventana where corr_enm ='".$IE."' ";
		//echo "1". $Consulta."<br>";
		$RespuestaF=mysqli_query($link, $Consulta);
		if($FilaF=mysqli_fetch_array($RespuestaF))
		{
			if($FilaF["bulto_paquetes"]==$FilaF["despacho_paquetes"] && $FilaF["bulto_peso"]==$FilaF["despacho_peso"])
			{
				$Consulta="select * from sec_web.programa_codelco where corr_codelco ='".$IE."'  ";
				//echo "EEE!".$Consulta;
				$ResP=mysqli_query($link, $Consulta);
				if($FilaP=mysqli_fetch_array($ResP))
				{
					if($FilaP["estado2"]=='P')
					{
						$Actualizar="UPDATE sec_web.programa_codelco set estado2='T' where corr_codelco=".$IE;
						mysqli_query($link, $Actualizar);
					//	echo $Actualizar."<br>";
					}
					$Consulta="select  count(t1.cod_paquete) as paquetes, sum(t1.peso_paquetes) as peso   from paquete_catodo t1, lote_catodo t2";
					$Consulta.= " where t2.cod_bulto = '".$FilaF["cod_bulto"]."' and t2.num_bulto = '".$FilaF["num_bulto"]."' and t2.corr_enm = '".$IE."' and ";
					$Consulta.= " t1.cod_paquete = t2.cod_paquete and  t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
					$Consulta.= " and t1.cod_estado = 'c' and t1.cod_estado = t2.cod_estado and disponibilidad = 'P'";
				//	echo "6". $Consulta."<br>";
					$RespuestaL=mysqli_query($link, $Consulta);
					if($FilaL=mysqli_fetch_array($RespuestaL))
					{
						if($FilaF["bulto_paquetes"]==$FilaL["paquetes"] && $FilaF["bulto_peso"]==$FilaL["peso"])
						{
							$Actualizar="UPDATE sec_web.lote_catodo set disponibilidad='T' where corr_enm=".$IE;
							$Actualizar.= " and cod_bulto = '".$FilaF["cod_bulto"]."' and num_bulto = '".$FilaF["num_bulto"]."'";
							mysqli_query($link, $Actualizar);
						}
					} 
				}
			}	
		}
	
	 header("location:sec_programa_adm_loteo.php?TipoIE=Normal&Proceso=F");	
							
	}
	
	//poly//
	
	if (($CodLote == "") || ($NumLote == ""))
	{
			if($Cierra=='Cerrar')
			{
				$Msj="";
				$Consulta="select * from sec_web.embarque_ventana where corr_enm ='".$IE."' ";
				//echo "1". $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				if($Fila=mysqli_fetch_array($Respuesta))
				{
					if($Fila["bulto_paquetes"]==$Fila["despacho_paquetes"] && $Fila["bulto_peso"]==$Fila["despacho_peso"])
					{
						$Consulta="select * from sec_web.programa_codelco where corr_codelco ='".$IE."'  ";
						//echo "EEE!".$Consulta;
						$Resp=mysqli_query($link, $Consulta);
						if($Fila2=mysqli_fetch_array($Resp))
						{
							if($Fila2["estado2"]=='T')
							{
								
								$Actualizar="UPDATE sec_web.programa_codelco set estado2='C' where corr_codelco=".$IE;
								mysqli_query($link, $Actualizar);
								//echo $Actualizar."<br>";
								$Encontro=true;
							}
						}
					   
					}
					else
					{
						$Consulta="select  count(t1.cod_paquete) as paquetes, sum(t1.peso_paquetes) as peso   from paquete_catodo t1, lote_catodo t2";
						$Consulta.= " where t2.cod_bulto = '".$Fila["cod_bulto"]."' and t2.num_bulto = '".$Fila["num_bulto"]."' and t2.corr_enm = '".$IE."' and ";
						$Consulta.= " t1.cod_paquete = t2.cod_paquete and  t1.num_paquete=t2.num_paquete and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete ";
						$Consulta.= " and t1.cod_estado = 'c' and t1.cod_estado = t2.cod_estado";
						//echo "6". $Consulta."<br>";
						$Respuesta=mysqli_query($link, $Consulta);
						if($Fila2=mysqli_fetch_array($Respuesta))
						{
						
							if($Fila["bulto_paquetes"]==$Fila2["paquetes"] && $Fila["bulto_peso"]==$Fila2["peso"])
							{
							
							
								$Actualizar="UPDATE sec_web.embarque_ventana  set despacho_paquetes= '".$Fila["bulto_paquetes"]."',despacho_peso = '".$Fila["bulto_peso"]."' ";
								$Actualizar.= " where corr_enm='".$IE."' and  cod_bulto = '".$Fila["cod_bulto"]."' and num_bulto ='".$Fila["num_bulto"]."'"; 
								mysqli_query($link, $Actualizar);
								//echo $Actualizar."<br>";
								
								
								$Actualizar="UPDATE sec_web.programa_codelco set estado2='C' where corr_codelco=".$IE;
								mysqli_query($link, $Actualizar);
								//echo $Actualizar."<br>";
	
							}	
						}
						else
							$Msj='El envio no ha sido despachado completamente';
					}
				}
				else
					$Msj='La IE no tiene Nnumeo de envio asociado';
					header("location:sec_programa_adm_loteo.php?TipoIE=Completas&Msj=".$Msj);	
						//header("location:sec_programa_adm_loteo.php?TipoIE=Completas");	
			}
			else
				if ($Proceso =='F')
					header("location:sec_programa_adm_loteo.php?TipoIE=Normal&Error=N");
				else	
					header("location:sec_programa_adm_loteo.php?TipoIE=Normal&Error=S");
				 
		}
		else
		{
			if($Cierra=='Cerrar')
			{
				$ano = date("Y");
				$ano1 = ano -1;
				$Msj="";
				$Consulta="select * from sec_web.embarque_ventana where corr_enm ='".$IE."' and (year(fecha_envio) = '".$ano."' or '".$ano1."')";
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				if($Fila=mysqli_fetch_array($Respuesta))
				{
					if($Fila["bulto_paquetes"]==$Fila["despacho_paquetes"] && $Fila["bulto_peso"]==$Fila["despacho_peso"])
					{
						$Consulta="select * from sec_web.programa_codelco where corr_codelco ='".$IE."'  ";
						$Resp=mysqli_query($link, $Consulta);
						if($Fila2=mysqli_fetch_array($Resp))
						{
							if($Fila2["estado2"]=='T')
							{
								$Actualizar="UPDATE sec_web.programa_codelco set estado2='C' where corr_codelco='".$IE."' and  and (year(fecha_programacion) = '".$ano."' or '".$ano1."')";;
								mysqli_query($link, $Actualizar);
								//echo $Actualizar."<br>";
								$Encontro=true;
							}
						}
					}
				}
				else
					$Msj='La IE no tiene Numero de envio asociado';
					
				 header("location:sec_programa_adm_loteo.php?TipoIE=Completas&Msj=".$Msj);	
				//header("location:sec_programa_adm_loteo.php?TipoIE=Completas");	
			}
			else
			{
				switch ($TipoIE)
				{
					case "E":
						$Actualizar="UPDATE sec_web.programa_enami set estado1='R',estado2='T' where corr_enm=".$IE;
						mysqli_query($link, $Actualizar);
						break;
					case "C":
						$Actualizar="UPDATE sec_web.programa_codelco set estado1='R',estado2='T' where corr_codelco=".$IE;
						mysqli_query($link, $Actualizar);
						break;
				}
			 header("location:sec_programa_adm_loteo.php?TipoIE=Normal");	
			}
		}	
}		
?>	