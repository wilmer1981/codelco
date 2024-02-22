<?php
include("../principal/conectar_principal.php");
$val_estado='5';

if ($todos_estado=='on') 
    {$val_estado='5';}
else {	
		if ($asignado=='on')
			  $val_estado='1';					
		if ($parabaja=='on')
			  $val_estado='2';
		if ($debaja=='on')
			  $val_estado='3';
		if ($disponible=='on')
			  $val_estado='4';
      }

					
if(!isset($opcion))
	$opcion='all';
	
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
					   		{
					     	$query.=" where estado ='".$val_estado."' and marca = '".$cmbMarcaE."' and tipo='EQUIPO'";
							}
							
						if ($opcion =='PARTE')
					     	{		
					      	$query.=" where estado ='".$val_estado."' and  marca = '".$cmbMarcaP."' and tipo='PARTE'";
					        }   
						}						 
					 if  ($val_estado=='5')
					   { 
						if ($opcion=='EQUIPO' or $opcion=='all')
					   		{
					    	 $query.=" where  marca='".$cmbMarcaE."' and tipo='EQUIPO'";
							}
						if ($opcion =='PARTE')
					   	    {		
					      	$query.=" where   marca='".$cmbMarcaP."' and tipo='PARTE'";
					       	}   
							
							}	 	
					break; 
				case "modelo":
				    if  ($val_estado!='5')
					   { 
						if ($opcion=='EQUIPO' or $opcion=='all' )
					   		{
					     	$query.=" where estado ='".$val_estado."' and modelo = '".$cmbModeloE."' and tipo='EQUIPO'";
							}
							
						if ($opcion =='PARTE')
					     	{		
					      	$query.=" where estado ='".$val_estado."' and  modelo = '".$cmbModeloP."' and tipo='PARTE'";
					        }   
						}						 
					 if  ($val_estado=='5')
					   { 
						if ($opcion=='EQUIPO' or $opcion=='all')
					   		{
					    	 $query.=" where  modelo='".$cmbModeloE."' and tipo='EQUIPO'";
							}
						if ($opcion =='PARTE')
					   	    {		
					      	$query.=" where   modelo='".$cmbModeloP."' and tipo='PARTE'";
					       	}   
							
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
								$query.=" where rut_usuario='".$buscar."'  and fecha_termino is null and estado_asoc=1 UNION select cod_parte from";
								$query.=" cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc in ";
								$query.="(select nro_asoc from cia_web.asoc_equipos_usuarios where";
								$query.=" rut_usuario='".$buscar."'  and fecha_termino is null and estado_asoc=1))";
					        }
					   
						  else
					        {
							    $query.=" where estado_asoc=1 and rut_usuario in (select RUT from bd_rrhh.antecedentes_personales";
						        $query.=" where ".$cmbUsuario." like '%".$buscar."%') UNION";
						        $query.=" select cod_parte from cia_web.asoc_partes_equipos where estado_asoc=1 and fecha_termino is null and nro_asoc_eq_user";
						        $query.=" in (select nro_asoc from cia_web.asoc_equipos_usuarios where estado_asoc=1 and fecha_termino is null and";
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
								$query.=" rut_usuario='".$buscar."'  and fecha_termino is null and estado_asoc=1))";
					        }
					   
						  else
					        {
							    $query.=" where estado_asoc=1 and rut_usuario in (select RUT from bd_rrhh.antecedentes_personales";
						        $query.=" where ".$cmbUsuario." like '%".$buscar."%') UNION";
						        $query.=" select cod_parte from cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc_eq_user";
						        $query.=" in (select nro_asoc from cia_web.asoc_equipos_usuarios where estado_asoc=1 and fecha_termino is null and";
						        $query.=" rut_usuario in (select RUT from bd_rrhh.antecedentes_personales where";
						        $query.=" ".$cmbUsuario." like '%".$buscar."%')))";
					        }
					  }
					break;
				case "ubi":
				    if  ($val_estado!='5') 
						{
						 $query.=" where estado ='".$val_estado."' and codigo in ";
						 $query.="(select cod_equipo from cia_web.asoc_equipos_usuarios";
						 $query.=" where cc_ubicacion='".$cmbUbicacion."' and fecha_termino is null and estado_asoc=1 UNION";
						 $query.=" select cod_parte from cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc_eq_user";
						 $query.=" in (select nro_asoc from cia_web.asoc_equipos_usuarios where";
						 $query.=" cc_ubicacion='".$cmbUbicacion."'))";
						}
				    if  ($val_estado=='5') 
						{
						 $query.=" where  codigo in ";
						 $query.="(select cod_equipo from cia_web.asoc_equipos_usuarios";
						 $query.=" where cc_ubicacion='".$cmbUbicacion."' and fecha_termino is null  and estado_asoc=1 UNION";
						 $query.=" select cod_parte from cia_web.asoc_partes_equipos where estado_asoc=1 and nro_asoc_eq_user";
						 $query.=" in (select nro_asoc from cia_web.asoc_equipos_usuarios where";
						 $query.=" cc_ubicacion='".$cmbUbicacion."'))";
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
						     	{
                                	 $query.=" where   nro_serie='".$CmbSerie_P."'";
					         	}   
								 	else
								     	{
									  	$query.=" where  and nro_serie like '".$buscar3."%'";
							         	}
							}	 	
						 }
 					  	 
					break; 
				
				default:
					if  ($val_estado!='5')
					  {
					   $query.=" where estado ='".$val_estado."' and ".$filtro." like '%".$buscar."%' and estado ='".$val_estado."'";
					  }
					 if  ($val_estado=='5')
					  {
					   $query.=" where ".$filtro." like '%".$buscar."%'";
					  } 
					break;
			}
			if($opcion!="all")
			     {
				 if  ($val_estado!='5')
				 	$query.=" and tipo='".$opcion."'";
				 if  ($val_estado=='5')
				     $query.=" and tipo='".$opcion."'";
				}	 
		}
		else if($filtro=="todos")
		{ //echo('oooooooo');
			if(($opcion!="all") &&($val_estado!='5'))
			 	$query.=" where tipo= '".$opcion."' and estado ='".$val_estado."'";
 		    if(($opcion!="all") &&($val_estado=='5'))
				$query.=" where tipo='".$opcion."'";
		}
		$query.=" order by codigo;";
		break;
}

$result=mysql_query($query,$link);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color: #b26c4a;
	text-align:center;
}

a:link{
	color: #b26c4a;
}	

a:hover{
	color: #b26c4a;
	background-color: #FFFFFF;
}

a:visited{
	color: #b26c4a;
}

a:active{
	color: #b26c4a;
}

.TD{
	border:solid 1px #666666;
	text-align:center;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script type="text/javascript" src="file:///D|/cia_web/funciones.js"></script>
<script language="JavaScript" type="text/javascript">
function to_excel(op,estado)
{
	var f=document.frmResultado;
	if(confirm("Desea incluir equipos asociados"))
		f.action="ToExcel/resultado_excel.php?asoc=si&op="+op+"&val_estado="+estado;
		         
	else
		f.action="ToExcel/resultado_excel.php?asoc=no&op="+op+"&val_estado="+estado;
	f.submit();
}
</script>
</head>

<?php
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
		//if($estado=="on") $col_eq++;
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
<body bgcolor="#CCCCCC">
<form name="frmResultado" method="post" action="">
<?php
//se crean los hidden para poder llevar el resultado a excel
switch($op)
{
	case 1:
		echo '<input type="hidden" name="filtro" value="'.$filtro.'">';
		echo '<input type="hidden" name="cmbTipo" value="'.$cmbTipo.'">';
		//echo '<input type="hidden" name="cmbEstado" value="'.$cmbEstado.'">';
		echo '<input type="hidden" name="cmbProveedor" value="'.$cmbProveedor.'">';
		echo '<input type="hidden" name="cmbDetalle" value="'.$cmbDetalle.'">';
		echo '<input type="hidden" name="buscar" value="'.$buscar.'">';
		echo '<input type="hidden" name="buscar2" value="'.$buscar2.'">';
		echo '<input type="hidden" name="buscar3" value="'.$buscar3.'">';
		echo '<input type="hidden" name="cmbUsuario" value="'.$cmbUsuario.'">';
		echo '<input type="hidden" name="cmbUbicacion" value="'.$cmbUbicacion.'">';
		echo '<input type="hidden" name="cmbMarcaE" value="'.$cmbMarcaE.'">';
		echo '<input type="hidden" name="cmbMarcaP" value="'.$cmbMarcaP.'">';
		echo '<input type="hidden" name="CmbSerie_P" value="'.$CmbSerie_P.'">';
		echo '<input type="hidden" name="cmbSerie" value="'.$cmbSerie.'">';
		echo '<input type="hidden" name="cmbModeloE" value="'.$cmbModeloE.'">';
		echo '<input type="hidden" name="cmbModeloP" value="'.$cmbModeloP.'">';
		echo '<input type="hidden" name="opcion" value="'.$opcion.'">';
		//los checkbox
		echo '<input type="hidden" name="codigo" value="'.$codigo.'">';
		echo '<input type="hidden" name="marca" value="'.$marca.'">';
		echo '<input type="hidden" name="modelo" value="'.$modelo.'">';
		echo '<input type="hidden" name="nro_serie" value="'.$nro_serie.'">';
		echo '<input type="hidden" name="fecha_compra" value="'.$fecha_compra.'">';
		echo '<input type="hidden" name="p_garantia" value="'.$p_garantia.'">';
		echo '<input type="hidden" name="nro_factura" value="'.$nro_factura.'">';
		echo '<input type="hidden" name="nro_guia" value="'.$nro_guia.'">';
		echo '<input type="hidden" name="cod_activo_fijo" value="'.$cod_activo_fijo.'">';
		//echo '<input type="hidden" name="estado" value="'.$estado.'">';
		echo '<input type="hidden" name="observaciones" value="'.$observaciones.'">';
		echo '<input type="hidden" name="tipo" value="'.$tipo.'">';
		echo '<input type="hidden" name="ubi" value="'.$ubi.'">';
		echo '<input type="hidden" name="rut_p" value="'.$rut_p.'">';
		echo '<input type="hidden" name="razon_social" value="'.$razon_social.'">';
		echo '<input type="hidden" name="nombre_fantasia" value="'.$nombre_fantasia.'">';
		echo '<input type="hidden" name="contacto_1" value="'.$contacto_1.'">';
		echo '<input type="hidden" name="contacto_2" value="'.$contacto_2.'">';
		echo '<input type="hidden" name="fono_1" value="'.$fono_1.'">';
		echo '<input type="hidden" name="fono_2" value="'.$fono_2.'">';
		echo '<input type="hidden" name="fax" value="'.$fax.'">';
		echo '<input type="hidden" name="rut_u" value="'.$rut_u.'">';
		echo '<input type="hidden" name="nombres" value="'.$nombres.'">';
		echo '<input type="hidden" name="apellido_paterno" value="'.$apellido_paterno.'">';
		echo '<input type="hidden" name="apellido_materno" value="'.$apellido_materno.'">';
		echo '<input type="hidden" name="cc_user" value="'.$cc_user.'">';
		echo '<input type="hidden" name="procesador" value="'.$procesador.'">';
		echo '<input type="hidden" name="ram" value="'.$ram.'">';
		echo '<input type="hidden" name="disco_duro" value="'.$disco_duro.'">';
		echo '<input type="hidden" name="cant_seriales" value="'.$cant_seriales.'">';
		echo '<input type="hidden" name="cant_paralelos" value="'.$cant_paralelos.'">';
		echo '<input type="hidden" name="asignado" value="'.$val_estado.'">';
		echo '<input type="hidden" name="parabaja" value="'.$parabaja.'">';
		echo '<input type="hidden" name="debaja" value="'.$debaja.'">';
		echo '<input type="hidden" name="disponible" value="'.$disponible.'">';
		break;
}
?>
  <!---------------------------------- cuerpo de la pagina ------------------------------------->
<table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	  <td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="93%">
	<tr>
		<td class="ColorTabla01" align="center"><strong>Resultados de la Busqueda.</strong></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>
	
	<!--        TABLA DE RESULTADOS -->
	<table border="0" cellpadding="0" cellspacing="2" width="95%" align="center">
	<tr>
		<td class="TD"><strong>Se han encontrado <font color="#FF0000"><?php echo mysql_num_rows($result);?></font> coincidencias.</strong></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<?php
	if(mysql_num_rows($result))
	{
	?>
	<tr>
		<td>
		<!--      TABLA DETALLE DE RESULTADOS  -->
		<table border="0" cellpadding="0" cellspacing="2" align="center">
		<?php
		switch($op)
		{
			case 1:		//listado completo
				//se construye la primera fila
				echo '<tr bgcolor="#00CCFF">';
				if($col_eq!=0) echo '<td class="TD" colspan="'.$col_eq.'"><strong>EQUIPO</strong></td>';
				if($col_det!=0) echo '<td class="TD" colspan="'.$col_det.'"><strong>DETALLE EQUIPO</strong></td>';
				if($col_prov!=0) echo '<td class="TD" colspan="'.$col_prov.'"><strong>PROVEEDOR</strong></td>';
				if($col_user!=0) echo '<td class="TD" colspan="'.$col_user.'"><strong>USUARIO</strong></td>';
				echo '<td class="TD" colspan="'.$col_est.'"><strong>ESTADO</strong></td>';
				echo '</tr>';
				//se construye la cabecera de la tabla
				echo '<tr bgcolor="#CCCCCC">';
				//los datos del equipo
				if($codigo=="on") echo '<td class="TD" style="color: #0000CC;" width="80">Codigo</td>';
				if($tipo=="on") echo '<td class="TD" style="color: #0000CC;">Tipo</td>';
				if($marca=="on") echo '<td class="TD" style="color: #0000CC;">Marca</td>';
				if($modelo=="on") echo '<td class="TD" style="color: #0000CC;">Modelo</td>';
				if($nro_serie=="on") echo '<td class="TD" style="color: #0000CC;">Nro Serie</td>';
				if($fecha_compra=="on") echo '<td class="TD" style="color: #0000CC;" width="100">Fecha Compra</td>';
				if($p_garantia=="on") echo '<td class="TD" style="color: #0000CC;">Per. Garantia</td>';
				if($nro_factura=="on") echo '<td class="TD" style="color: #0000CC;">Nro. Factura</td>';
				if($nro_guia=="on") echo '<td class="TD" style="color: #0000CC;">Nro. Guia</td>';
				if($cod_activo_fijo=="on") echo '<td class="TD" style="color: #0000CC;">Cod Act Fijo</td>';
				//if($estado=="on") echo '<td class="TD" style="color: #0000CC;">Estado</td>';
				if($observaciones=="on") echo '<td class="TD" style="color: #0000CC;">Observaciones</td>';
				if($ubi=="on") echo '<td class="TD" style="color: #0000CC;">Ubicaci&oacute;n</td>';
				//los datos del detalle del equipo
				if($procesador=="on") echo '<td class="TD" style="color: #0000CC;">Procesador</td>';
				if($ram=="on") echo '<td class="TD" style="color: #0000CC;">Ram</td>';
				if($disco_duro=="on") echo '<td class="TD" style="color: #0000CC;">Disco Duro</td>';
				if($cant_seriales=="on") echo '<td class="TD" style="color: #0000CC;">Cant. Seriales</td>';
				if($cant_paralelos=="on") echo '<td class="TD" style="color: #0000CC;">Cant. Paralelos</td>';
				//los datos del proveedor
				if($rut_p=="on") echo '<td class="TD" style="color: #0000CC;" width="100">Rut</td>';
				if($razon_social=="on") echo '<td class="TD" style="color: #0000CC;">Razon Social</td>';
				if($nombre_fantasia=="on") echo '<td class="TD" style="color: #0000CC;">Nombre Fantasia</td>';
				if($contacto_1=="on") echo '<td class="TD" style="color: #0000CC;">Contacto 1</td>';
				if($contacto_2=="on") echo '<td class="TD" style="color: #0000CC;">Contacto 2</td>';
				if($fono_1=="on") echo '<td class="TD" style="color: #0000CC;">Fono 1</td>';
				if($fono_2=="on") echo '<td class="TD" style="color: #0000CC;">Fono 2</td>';
				if($fax=="on") echo '<td class="TD" style="color: #0000CC;">Fax</td>';
				//los datos del usuario
				if($rut_u=="on") echo '<td class="TD" style="color: #0000CC;" width="100">Rut</td>';
				if($nombres=="on") echo '<td class="TD" style="color: #0000CC;">Nombres</td>';
				if($apellido_paterno=="on") echo '<td class="TD" style="color: #0000CC;">Ape. Paterno</td>';
				if($apellido_materno=="on") echo '<td class="TD" style="color: #0000CC;">Ape. Materno</td>';
				if($cc_user=="on") echo '<td class="TD" style="color: #0000CC;">Centro Costo</td>';
				//los datos del estado
				echo '<td class="TD" style="color: #0000CC;" width="100">Estado</td>';
				echo '</tr>';
				//ahora se muestran los datos
				while($r=mysql_fetch_array($result))
				{
					echo '<tr>';
					//los datos del equipo
					if($codigo=="on") echo '<td class="TD">'.$r["codigo"].'</td>';
					if($tipo=="on")
					{
						//se recupera el tipo de equipo
						$tip=substr($r["codigo"],0,3);
						$query="select nombre_subclase as nom from sub_clase where valor_subclase1='".$tip."';";
						$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
						$r_tmp=mysql_fetch_array($res_tmp);
						
						echo '<td class="TD">&nbsp;'.$r_tmp["nom"].'</td>';
					}
					if($marca=="on") echo '<td class="TD">&nbsp;'.$r["marca"].'</td>';
					if($modelo=="on") echo '<td class="TD">&nbsp;'.$r["modelo"].'</td>';
					if($nro_serie=="on") echo '<td class="TD">&nbsp;'.$r["nro_serie"].'</td>';
					$fecha=explode("-",$r["fecha_compra"]);
					$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
					if($fecha_compra=="on") echo '<td class="TD">&nbsp;'.$fecha.'</td>';
					if($p_garantia=="on") echo '<td class="TD">&nbsp;'.$r["p_garantia"].'</td>';
					if($nro_factura=="on") echo '<td class="TD">&nbsp;'.$r["nro_factura"].'</td>';
					if($nro_guia=="on") echo '<td class="TD">&nbsp;'.$r["nro_guia"].'</td>';
					if($cod_activo_fijo=="on") echo '<td class="TD">&nbsp;'.$r["cod_activo_fijo"].'</td>';
					if($observaciones=="on") echo '<td class="TD">&nbsp;'.$r["observaciones"].'</td>';
					if($ubi=="on")
					{
						if($r["nro_asociacion_activa"]!=0)
						{
							//se recupera la ubicacion del equipo
							$query="select cc_ubicacion from asoc_equipos_usuarios where";
							if($r["tipo"]=="EQUIPO")
								$query.=" fecha_termino is null and nro_asoc=".$r["nro_asociacion_activa"].";";
							else
							{
								$query.=" nro_asoc in (select nro_asoc_eq_user from asoc_partes_equipos";
								$query.=" where and fecha_termino is null and nro_asoc=".$r["nro_asociacion_activa"].");";
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
							$query.=" and  t1.estado_asoc='0' group by t2.cod_equipo";
							
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
							{
								$query.=" nro_asoc=".$r["nro_asociacion_activa"].");";
								
							}	
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
		</td>
	</tr>
	<?php
	}
	?>
	</table>
	<!--         FIN TABLA DE RESULTADOS  -->
	
	</td></tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td align="center">
	<?php
	if(mysql_num_rows($result))
		echo '<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="javascript: to_excel('.$op.','.$val_estado.')">&nbsp;&nbsp;&nbsp;';
	?>
	<input type="button" name="Out" value="Cerrar" onClick="Javascript: window.close()" style="width: 80px;">
	</td>
</tr>		
<tr>
	<td>&nbsp;</td>
</tr>
</table>

</form>
</body>
</html>
