<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

switch($op)
{
	case 1:		//listado completo de equipos
		$query="select * from cia_web.hardware";
		if($filtro!="todos")
		{
			switch($filtro)
			{
				case "marca":
				    if  ($val_estado!='5')
					   { 
						if ($opcion=='EQUIPO' or $opcion=='all' )
					   	  	$query.=" where estado ='".$val_estado."' and marca = '".$cmbMarcaE."' and tipo='EQUIPO'";
											
						if ($opcion =='PARTE')
					      	$query.=" where estado ='".$val_estado."' and  marca = '".$cmbMarcaP."' and tipo='PARTE'";
						}						 
					 if  ($val_estado=='5')
					   { 
						if ($opcion=='EQUIPO' or $opcion=='all')
					     	$query.=" where  marca='".$cmbMarcaE."' and tipo='EQUIPO'";
						
						if ($opcion =='PARTE')
					   	   	$query.=" where   marca='".$cmbMarcaP."' and tipo='PARTE'";
					       	   
					   }	
								 	
		        break; 
				case "modelo":
				    if  ($val_estado!='5')
					   { 
						if ($opcion=='EQUIPO' or $opcion=='all' )
					   		$query.=" where estado ='".$val_estado."' and modelo = '".$cmbModeloE."' and tipo='EQUIPO'";
											
						if ($opcion =='PARTE')
					       	$query.=" where estado ='".$val_estado."' and  modelo = '".$cmbModeloP."' and tipo='PARTE'";
					   }	
					           
					if  ($val_estado=='5')
					   { 
						if ($opcion=='EQUIPO' or $opcion=='all')
					    	$query.=" where  modelo='".$cmbModeloE."' and tipo='EQUIPO'";
							
						if ($opcion =='PARTE')
					   	   	$query.=" where   modelo='".$cmbModeloP."' and tipo='PARTE'";
    	   
							
					   }	 	
				break; 
				
				case "t_equipo":
			
					if  ($val_estado!='5')
					  $query.=" where codigo like '%".$cmbTipo."%' and estado ='".$val_estado."'";
					if  ($val_estado=='5')
					   $query.=" where codigo like '%".$cmbTipo."%'";
				break;
				
				case "proveedor":
			
					if  ($val_estado!='5')
					$query.=" where rut_proveedor='".$cmbProveedor."' and estado ='".$val_estado."'";
			     	if  ($val_estado=='5')
				    $query.=" where rut_proveedor='".$cmbProveedor."'"; 
				break;
				
				case "detalle_equipo":
					if  ($val_estado!='5')  
				   	   {
						 $query.=" where estado ='".$val_estado."' and codigo in (select cod_equipo from cia_web.detalle_equipos ";
				    	 $query.=" where ".$cmbDetalle." like '%".$buscar."%')";
					   }	 
				   if  ($val_estado=='5')
				       {
				    	 $query.=" where  codigo in (select cod_equipo from cia_web.detalle_equipos ";
				    	 $query.=" where ".$cmbDetalle." like '%".$buscar."%')";	
					   }				
				break;
				
				case "usuario":
					if  ($val_estado=='5') 
				       {  
					     $query.=" where  codigo in ";
						 $query.="(select cod_equipo from cia_web.asoc_equipos_usuarios";
					      if($cmbUsuario=="rut_usuario")
					        {
								$query.=" where rut_usuario='".$buscar."' and estado_asoc=1 UNION select cod_parte from";
								$query.=" cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc in ";
								$query.="(select nro_asoc from cia_web.asoc_equipos_usuarios where";
								$query.=" rut_usuario='".$buscar."' and estado_asoc=1))";
					        }
					   
						  else
					        {
							    $query.=" where estado_asoc=1 and rut_usuario in (select RUT from bd_rrhh.antecedentes_personales";
						        $query.=" where ".$cmbUsuario." like '%".$buscar."%') UNION";
						        $query.=" select cod_parte from cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc_eq_user";
						        $query.=" in (select nro_asoc from cia_web.asoc_equipos_usuarios where estado_asoc=1 and";
						        $query.=" rut_usuario in (select RUT from bd_rrhh.antecedentes_personales where";
						        $query.=" ".$cmbUsuario." like '%".$buscar."%')))";
					        }
					  }
					if  ($val_estado!='5') 
				       {  
					     $query.=" where estado ='".$val_estado."' and codigo in ";
						 $query.="(select cod_equipo from cia_web.asoc_equipos_usuarios";
					      if($cmbUsuario=="rut")
					        {
								$query.=" where rut_usuario='".$buscar."' and estado_asoc=1 UNION select cod_parte from";
								$query.=" cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc_eq_user in ";
								$query.="(select nro_asoc from cia_web.asoc_equipos_usuarios where";
								$query.=" rut_usuario='".$buscar."' and estado_asoc=1))";
					        }
						  else
					        {
							    $query.=" where estado_asoc=1 and rut_usuario in (select RUT from bd_rrhh.antecedentes_personales";
						        $query.=" where ".$cmbUsuario." like '%".$buscar."%') UNION";
						        $query.=" select cod_parte from cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc_eq_user";
						        $query.=" in (select nro_asoc from cia_web.asoc_equipos_usuarios where estado_asoc=1 and";
						        $query.=" rut_usuario in (select RUT from bd_rrhh.antecedentes_personales where";
						        $query.=" ".$cmbUsuario." like '%".$buscar."%')))";
					        }
					  }
				break;
				case "nro_serie":
					if  ($val_estado!='5')
					   { 
						if ($opcion=='EQUIPO')
					   		{
					    	if ($buscar2=="")
				    	   	{
								  $query.=" where estado ='".$val_estado."' and nro_serie='".$cmbSerie."'";
						   	}	
								else
							    	{
								 	$query.=" where estado ='".$val_estado."' and nro_serie like '".$buscar2."%'";
							   		}
							}
						if ($opcion =='PARTE')
					   	{		
					      	if ($buscar3=="")
						     	{
                                	 $query.=" where estado ='".$val_estado."' and  nro_serie='".$CmbSerie_P."'";
					         	}   
								 	else
								     	{
									  	$query.=" where estado ='".$val_estado."' and nro_serie like '".$buscar3."%'";
							         	}
							}	 	
						 }
					 if  ($val_estado=='5')
					   { 
						if ($opcion=='EQUIPO')
					   		{
					    	if ($buscar2=="")
				    	   	{
								  $query.=" where  nro_serie='".$cmbSerie."'";
						   	}	
								else
							    	{
								 	$query.=" where  nro_serie like '".$buscar2."%'";
							   		}
							}
						if ($opcion =='PARTE')
					   	{		
					      	if ($buscar3=="")
                               	 $query.=" where   nro_serie='".$CmbSerie_P."'";
							else
							  	$query.=" where  and nro_serie like '".$buscar3."%'";
						}
					}
				break; 
				case "ubi":
					if  ($val_estado!='5') 
						{
						 $query.=" where estado ='".$val_estado."' and codigo in ";
						 $query.="(select cod_equipo from cia_web.asoc_equipos_usuarios";
						 $query.=" where cc_ubicacion='".$cmbUbicacion."' and estado_asoc=1 UNION";
						 $query.=" select cod_parte from cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc_eq_user";
						 $query.=" in (select nro_asoc from cia_web.asoc_equipos_usuarios where";
						 $query.=" cc_ubicacion='".$cmbUbicacion."'))";
						}
				    if  ($val_estado=='5') 
						{
						 $query.=" where  codigo in ";
						 $query.="(select cod_equipo from cia_web.asoc_equipos_usuarios";
						 $query.=" where cc_ubicacion='".$cmbUbicacion."' and estado_asoc=1 UNION";
						 $query.=" select cod_parte from cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc_eq_user";
						 $query.=" in (select nro_asoc from cia_web.asoc_equipos_usuarios where";
						 $query.=" cc_ubicacion='".$cmbUbicacion."'))";
						}					
				break;
				default:
					if  ($val_estado!='5')
						$query.=" where estado ='".$val_estado."' and ".$filtro." = '".$buscar."'";
					if  ($val_estado=='5')
						$query.=" where ".$filtro." = '".$buscar."'";
				break;
			}
			if($opcion!="all")
				$query.=" and tipo='".$opcion."'";
		}
		else if($filtro=="todos")
		{ 
			if(($opcion!="all") &&($val_estado!='5'))
			 	$query.=" where tipo= '".$opcion."' and estado ='".$val_estado."'";
			if(($opcion!="all") &&($val_estado=='5'))
				$query.=" where tipo='".$opcion."'";
		}
		$query.=" order by codigo;";
		break;
}
$result=mysql_query($query);
//se preparan los datos para ser mostrados
switch($op)
{
	case 1:
		//primero se cuentan la cantidad de columnas que tendra la tabla
		$col_eq=$col_user=$col_prov=$col_det=0;
		//las columnas para el equipo
		if($codigo=="on") $col_eq++;
		if($marca=="on") $col_eq++;
		if($modelo=="on") $col_eq++;
		if($nro_serie=="on") $col_eq++;
		if($fecha_compra=="on") $col_eq++;
		if($p_garantia=="on") $col_eq++;
		if($nro_factura=="on") $col_eq++;
		if($nro_guia=="on") $col_eq++;
		if($observaciones=="on") $col_eq++;
		if($tipo=="on") $col_eq++;
		if($ubi=="on") $col_eq++;
		if($cod_activo_fijo=="on") $col_eq++;
		//las columnas para el proveedor
		if($rut_p=="on") $col_prov++;
		if($razon_social=="on") $col_prov++;
		if($nombre_fantasia=="on") $col_prov++;
		if($contacto_1=="on") $col_prov++;
		if($contacto_2=="on") $col_prov++;
		if($fono_1=="on") $col_prov++;
		if($fono_2=="on") $col_prov++;
		if($fax=="on") $col_prov++;
		//las columnas para el usuario
		if($rut_u=="on") $col_user++;
		if($nombres=="on") $col_user++;
		if($apellido_paterno=="on") $col_user++;
		if($apellido_materno=="on") $col_user++;
		if($cc_user=="on") $col_user++;
		//las columnas para el detalle del equipo
		if($procesador=="on") $col_det++;
		if($ram=="on") $col_det++;
		if($disco_duro=="on") $col_det++;
		if($cant_seriales=="on") $col_det++;
		if($cant_paralelos=="on") $col_det++;
		break;
		//las columnas para el estado
		if($asignado=="on") $col_est++;
		if($parabaja=="on") $col_est++;
		if($debaja=="on") $col_est++;
		if($disponible=="on") $col_est++;
		break;
}

?>
<html>
<body>
<!--      TABLA DETALLE DE RESULTADOS  -->
<table border="1" cellpadding="0" cellspacing="2" align="left">
<?php
switch($op)
{
	case 1:		//listado completo
		//se construye la primera fila
		echo '<tr bgcolor="#999999">';
		if($col_eq!=0) echo '<td align="center" colspan="'.$col_eq.'"><strong>EQUIPO</strong></td>';
		if($col_det!=0) echo '<td align="center" colspan="'.$col_det.'"><strong>DETALLE EQUIPO</strong></td>';
		if($col_prov!=0) echo '<td align="center" colspan="'.$col_prov.'"><strong>PROVEEDOR</strong></td>';
		if($col_user!=0) echo '<td align="center" colspan="'.$col_user.'"><strong>USUARIO</strong></td>';
		echo '<td align="center" colspan="1"><strong>ESTADO</strong></td>';
		if($asoc=='si')	echo '<td align="center" colspan="5"><strong>EQUIPOS ASOCIADOS</strong></td>';
		echo '</tr>';
		
		//se construye la cabecera de la tabla
		
		echo '<tr bgcolor="#CCCCCC">';
		
		//los datos del equipo
		if($codigo=="on") echo '<td align="center"><strong>Codigo</strong></td>';
		if($tipo=="on") echo '<td align="center"><strong>Tipo</strong></td>';
		if($marca=="on") echo '<td align="center"><strong>Marca</strong></td>';
		if($modelo=="on") echo '<td align="center"><strong>Modelo</strong></td>';
		if($nro_serie=="on") echo '<td align="center"><strong>Nro Serie</strong></td>';
		if($fecha_compra=="on") echo '<td align="center" ><strong>Fecha Compra</strong></td>';
		if($p_garantia=="on") echo '<td align="center"><strong>Per. Garantia</strong></td>';
		if($nro_factura=="on") echo '<td align="center" ><strong>Nro. Factura</strong></td>';
		if($nro_guia=="on") echo '<td align="center" ><strong>Nro. Guia</strong></td>';
		if($cod_activo_fijo=="on") echo '<td><strong>Cod Act Fijo</strong></td>';
		if($observaciones=="on") echo '<td align="center" ><strong>Observaciones</strong></td>';
		if($ubi=="on") echo '<td align="center" ><strong>Ubicaci&oacute;n</strong></td>';
		
		//los datos del detalle del equipo
		if($procesador=="on") echo '<td align="center" ><strong>Procesador</strong></td>';
		if($ram=="on") echo '<td align="center" ><strong>Ram</strong></td>';
		if($disco_duro=="on") echo '<td align="center" ><strong>Disco Duro</strong></td>';
		if($cant_seriales=="on") echo '<td align="center" ><strong>Cant. Seriales</strong></td>';
		if($cant_paralelos=="on") echo '<td align="center" ><strong>Cant. Paralelos</strong></td>';
		
		//los datos del proveedor
		if($rut_p=="on") echo '<td align="center" ><strong>Rut</strong></td>';
		if($razon_social=="on") echo '<td align="center" ><strong>Razon Social</strong></td>';
		if($nombre_fantasia=="on") echo '<td align="center" ><strong>Nombre Fantasia</strong></td>';
		if($contacto_1=="on") echo '<td align="center" ><strong>Contacto 1</strong></td>';
		if($contacto_2=="on") echo '<td align="center" ><strong>Contacto 2</strong></td>';
		if($fono_1=="on") echo '<td align="center" ><strong>Fono 1</strong></td>';
		if($fono_2=="on") echo '<td align="center" ><strong>Fono 2</strong></td>';
		if($fax=="on") echo '<td align="center" ><strong>Fax</strong></td>';
		
		//los datos del usuario
		if($rut_u=="on") echo '<td align="center" ><strong>Rut</strong></td>';
		if($nombres=="on") echo '<td align="center" ><strong>Nombres</strong></td>';
		if($apellido_paterno=="on") echo '<td align="center"><strong>Ape. Paterno</strong></td>';
		if($apellido_materno=="on") echo '<td align="center"><strong>Ape. Materno</strong></td>';
		if($cc_user=="on") echo '<td align="center"><strong>Centro Costo</strong></td>';
		
		//el estado
		echo '<td align="center" ><strong>Estado</strong></td>';
		
		//equipos asociados
		if($asoc=='si')
		  {
			echo '<td align="center"><strong>Codigo</strong></td>';
			echo '<td align="center"><strong>Tipo</strong></td>';
			echo '<td align="center"><strong>Marca</strong></td>';
			echo '<td align="center"><strong>Modelo</strong></td>';
			echo '<td align="center"><strong>Nro Serie</strong></td>';
		  }
		echo '</tr>';
		//ahora se muestran los datos
		while($r=mysql_fetch_array($result))
		{
			echo '<tr bgcolor="#E8FDD9">';
			//los datos del equipo
			if($codigo=="on") echo '<td align="center">'.$r["codigo"].'</td>';
			if($tipo=="on")
			{
				//se recupera el tipo de equipo
				$tip=substr($r["codigo"],0,3);
				$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
				$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
				$r_tmp=mysql_fetch_array($res_tmp);
				echo '<td align="center" >&nbsp;'.$r_tmp["nom"].'</td>';
			}
			if($marca=="on") echo '<td align="center">&nbsp;'.$r["marca"].'</td>';
			if($modelo=="on") echo '<td align="center">&nbsp;'.$r["modelo"].'</td>';
			if($nro_serie=="on") echo '<td align="center">&nbsp;'.$r["nro_serie"].'</td>';
			$fecha=explode("-",$r["fecha_compra"]);
			$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
			if($fecha_compra=="on") echo '<td align="center">&nbsp;'.$fecha.'</td>';
			if($p_garantia=="on") echo '<td align="center">&nbsp;'.$r["p_garantia"].'</td>';
			if($nro_factura=="on") echo '<td align="center">&nbsp;'.$r["nro_factura"].'</td>';
			if($nro_guia=="on") echo '<td align="center">&nbsp;'.$r["nro_guia"].'</td>';
			if($cod_activo_fijo=="on") echo '<td>&nbsp;'.$r["cod_activo_fijo"].'</td>';
	        if($observaciones=="on") echo '<td align="center">&nbsp;'.$r["observaciones"].'</td>';
			if($ubi=="on")
					{
						if($r["nro_asociacion_activa"]!=0)
						{
							//se recupera la ubicacion del equipo
							$query="select cc_ubicacion from asoc_equipos_usuarios where";
							if($r["tipo"]=="EQUIPO")
								$query.=" nro_asoc=".$r["nro_asociacion_activa"].";";
							else
							{
								$query.=" nro_asoc in (select nro_asoc_eq_user from asoc_partes_equipos";
								$query.=" where nro_asoc=".$r["nro_asociacion_activa"].");";
							}
							//se obtiene el codigo del centro de costo
							$res_tmp=mysql_db_query("cia_web",$query,$link);
							$r_tmp=mysql_fetch_array($res_tmp);
							$cc=$r_tmp["cc_ubicacion"];
							mysql_free_result($res_tmp);
							//se obtiene la descripcion del centro de costo
							$query="select descripcion from centro_costo where centro_costo='".$r_tmp["cc_ubicacion"]."';";
							$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
							$r_tmp=mysql_fetch_array($res_tmp);
							mysql_free_result($res_tmp);
							$desc = $r_tmp["descripcion"];
							//$desc.=" - ".$r_tmp["descripcion"];
						}
						else
						{
							//se recupera la ubicacion del equipo
							$query="select max(t1.fecha_termino),t1.rut_usuario,t1.cc_ubicacion from cia_web.asoc_equipos_usuarios t1 ";
							$query.="left join  cia_web.asoc_partes_equipos t2 on t1.cod_equipo=t2.cod_equipo where ";
							if($r["tipo"]=="EQUIPO")
								$query.="t2.cod_equipo='".$r["codigo"]."' ";
							else
								$query.="t2.cod_parte='".$r["codigo"]."' ";
							$query.="  and  t1.estado_asoc='0' group by t2.cod_equipo";
							//se obtiene el codigo del centro de costo
							$res_tmp=mysql_db_query("cia_web",$query,$link);
							$r_tmp=mysql_fetch_array($res_tmp);
							$cc=$r_tmp["cc_ubicacion"];
							mysql_free_result($res_tmp);
							//se obtiene la descripcion del centro de costo
							$query="select descripcion from centro_costo where centro_costo='".$r_tmp["cc_ubicacion"]."';";
							$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
							$r_tmp=mysql_fetch_array($res_tmp);
							mysql_free_result($res_tmp);
							$desc = $r_tmp["descripcion"];
						}
							//$desc=" ";
						//se muestra la informacion del centro de costo
						echo '<td class="TD">&nbsp;'.$desc.'</td>';
					}
					//se muestran los datos del detalle del equipo
					if($col_det!=0)
					{
						if(substr($r["codigo"],0,3)=="CMP" || substr($r["codigo"],0,3)=="NBK")
						{
							$query="select * from detalle_equipos where cod_equipo='".$r["codigo"]."';";
							$res_tmp=mysql_db_query("cia_web",$query,$link);
							$r_tmp=mysql_fetch_array($res_tmp);
							mysql_free_result($res_tmp);
							if($procesador=="on") echo '<td class="TD">&nbsp;'.$r_tmp["procesador"].'</td>';
							if($ram=="on") echo '<td class="TD">&nbsp;'.$r_tmp["ram"].'</td>';
							if($disco_duro=="on") echo '<td class="TD">&nbsp;'.$r_tmp["disco_duro"].'</td>';
							if($cant_seriales=="on") echo '<td class="TD">&nbsp;'.$r_tmp["cant_seriales"].'</td>';
							if($cant_paralelos=="on") echo '<td class="TD">&nbsp;'.$r_tmp["cant_paralelos"].'</td>';
						}
						else
							echo '<td class="TD" colspan="'.$col_det.'">&nbsp;</td>';
					}
					
					//se muestran los datos del proveedor
					if($col_prov!=0)
					{
						$query="select * from proveedor where rut='".$r["rut_proveedor"]."';";
						$res_tmp=mysql_db_query("cia_web",$query,$link);
						$r_tmp=mysql_fetch_array($res_tmp);
						mysql_free_result($res_tmp);
						
						if($rut_p=="on") echo '<td class="TD">&nbsp;'.$r_tmp["rut"].'</td>';
						if($razon_social=="on") echo '<td class="TD">&nbsp;'.$r_tmp["razon_social"].'</td>';
						if($nombre_fantasia=="on") echo '<td class="TD">&nbsp;'.$r_tmp["nombre_fantasia"].'</td>';
						if($contacto_1=="on") echo '<td class="TD">&nbsp;'.$r_tmp["contacto_1"].'</td>';
						if($contacto_2=="on") echo '<td class="TD">&nbsp;'.$r_tmp["contacto_2"].'</td>';
						if($fono_1=="on") echo '<td class="TD">&nbsp;'.$r_tmp["fono_1"].'</td>';
						if($fono_2=="on") echo '<td class="TD">&nbsp;'.$r_tmp["fono_2"].'</td>';
						if($fax=="on") echo '<td class="TD">&nbsp;'.$r_tmp["fax"].'</td>';
					}
					
					//se muestran los datos del usuario
					if($col_user!=0)
					{
						//echo "NUM_ASOC_ACTIVA:".$r["nro_asociacion_activa"]."<BR>";
						if($r["nro_asociacion_activa"]!=0)
						{
							$query="select * from bd_rrhh.antecedentes_personales where rut";
							$query.=" in (select rut_usuario from cia_web.asoc_equipos_usuarios where";
							if($r["tipo"]=="EQUIPO")
								$query.=" nro_asoc=".$r["nro_asociacion_activa"].");";
							else
							{
								$query.=" nro_asoc in (select nro_asoc_eq_user from cia_web.asoc_partes_equipos";
								$query.=" where nro_asoc=".$r["nro_asociacion_activa"]."));";
							}
							$res_tmp=mysql_query($query,$link);
							$r_tmp=mysql_fetch_array($res_tmp);
							mysql_free_result($res_tmp);
							if($rut_u=="on") echo '<td class="TD">&nbsp;'.$r_tmp["RUT"].'</td>';
							if($nombres=="on") echo '<td class="TD">&nbsp;'.$r_tmp["NOMBRES"].'</td>';
							if($apellido_paterno=="on") echo '<td class="TD">&nbsp;'.$r_tmp["APELLIDO_PATERNO"].'</td>';
							if($apellido_materno=="on") echo '<td class="TD">&nbsp;'.$r_tmp["APELLIDO_MATERNO"].'</td>';
							if($cc_user=="on")
							{
								$cc=substr($r_tmp["COD_CENTRO_COSTO"],3,5);
								$cc=explode(".",$cc);
								$cc=$cc[0].$cc[1];
								//se obtiene la descripcion del centro de costo
								$query="select descripcion from centro_costo where centro_costo='".$cc."';";
								$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
								$r_tmp=mysql_fetch_array($res_tmp);
								mysql_free_result($res_tmp);
								echo '<td class="TD">&nbsp;'.$cc.'</td>';
							}
						}
						else
						{
							$query="select max(t1.fecha_termino),t1.rut_usuario,RUT,COD_CENTRO_COSTO,NOMBRES,APELLIDO_PATERNO,APELLIDO_MATERNO from cia_web.asoc_equipos_usuarios t1 ";
							$query.="left join  cia_web.asoc_partes_equipos t2 on t1.cod_equipo=t2.cod_equipo ";
							$query.="left join bd_rrhh.antecedentes_personales t3 on t1.rut_usuario=t3.rut where ";
							if($r["tipo"]=="EQUIPO")
								$query.="t2.cod_equipo='".$r["codigo"]."' ";
							else
								$query.="t2.cod_parte='".$r["codigo"]."' ";
							$query.="  and  t1.estado_asoc='0' group by t2.cod_equipo";
							//echo $query."<br>";
							$res_tmp=mysql_query($query,$link);
							$r_tmp=mysql_fetch_array($res_tmp);
							mysql_free_result($res_tmp);
							if($rut_u=="on") echo '<td class="TD">&nbsp;'.$r_tmp["RUT"].'</td>';
							if($nombres=="on") echo '<td class="TD">&nbsp;'.$r_tmp["NOMBRES"].'</td>';
							if($apellido_paterno=="on") echo '<td class="TD">&nbsp;'.$r_tmp["APELLIDO_PATERNO"].'</td>';
							if($apellido_materno=="on") echo '<td class="TD">&nbsp;'.$r_tmp["APELLIDO_MATERNO"].'</td>';
							if($cc_user=="on")
							{
								$cc=substr($r_tmp["COD_CENTRO_COSTO"],3,5);
								$cc=explode(".",$cc);
								$cc=$cc[0].$cc[1];
								//se obtiene la descripcion del centro de costo
								$query="select descripcion from centro_costo where centro_costo='".$cc."';";
								$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
								$r_tmp=mysql_fetch_array($res_tmp);
								mysql_free_result($res_tmp);
								echo '<td class="TD">&nbsp;'.$cc.'</td>';
							}
						}
							//echo '<td class="TD" colspan="'.$col_user.'">&nbsp;</td>';
					}
					if ($r["estado"]== '1')
						$tipo_est='ASIGNADO';
					if ($r["estado"]== '2')
						$tipo_est='PARA BAJA';
					if ($r["estado"]== '3')
						$tipo_est='DE BAJA';
					if ($r["estado"]== '4')
						$tipo_est='DISPONIBLE';	
				   echo '<td class="TD">'.$tipo_est.'&nbsp;</td>';
				   echo '</tr>';
				}
				break;
		}
		?>	
</table>
<!--      FIN TABLA DETALLE DE RESULTADOS  -->
</body>
</html>
