<?php
//esta pagina sirve para mostrar la informacion que se desea obtener por medio de los distintos buscadores
include("../principal/conectar_principal.php");
//$ver_todos="all";
switch($op)
{
	case 1:		//proveedores
		//se verifica si se debe realizar busqueda o mostrar todos los registros
		if($ver_todos!="on")	//se debe realizar busqueda
		{
			$query_ppal="select * from cia_web.proveedor where ";
			if($buscar_campo=="contacto")
				$query_ppal.="contacto_1 like '%".$buscar."%' or contacto_2 like '%".$buscar."%'";
			else{
				if($buscar_campo=="fono")
					$query_ppal.="fono_1 like '%".$buscar."%' or fono_2 like '%".$buscar."%'";
				else
					$query_ppal.=$buscar_campo." like '%".$buscar."%'";
			}
		}
		else	//se deben mostrar todos
			$query_ppal="select * from cia_web.proveedor";			
		break;
	case 2:		//softwares
		// se verifica si se debe realizar busqueda o mostrar todos los registros
		if($ver_todos!="on")	//se debe realizar busqueda
		{
			//caso especial el de proveedores por RS o NF
			if($buscar_campo=="proveedor")
			{
				$query_ppal="SELECT * from cia_web.software where rut_proveedor IN ";
				$query_ppal.="(SELECT rut from cia_web.proveedor where razon_social like '%".$buscar."%'";
				$query_ppal.="or nombre_fantasia like '%".$buscar."%')";
			}
			else	//busqueda normal
				$query_ppal="select * from cia_web.software where ".$buscar_campo." like '%".$buscar."%'";
		}
		else	//se deben mostrar todos los registros
			$query_ppal="select * from cia_web.software";
		break;
	case 3://equipos
		//se verifica si se desea hacer una busqueda
		$query_ppal="select distinct t4.codigo,t2.cc_ubicacion,t1.RUT,t7.nombre_subclase as desc_equipo,t8.nombre_subclase as nom_estado,t4.tipo,t4.rut_proveedor,t6.razon_social,t4.marca,t4.modelo,t4.fecha_compra,t4.nro_serie,t2.cc_ubicacion,t3.DESCRIPCION,concat(t1.nombres,' ',t1.apellido_paterno,' ',t1.apellido_materno) as nombre,t4.estado "; 
		$query_ppal.="from cia_web.hardware t4 left join cia_web.asoc_equipos_usuarios t2 on t2.nro_asoc=t4.nro_asociacion_activa  left join bd_rrhh.antecedentes_personales t1 on t1.RUT=t2.rut_usuario ";
		if($opcion=="PARTE")
			$query_ppal.="left join  cia_web.asoc_partes_equipos t5 on t2.nro_asoc=t5.nro_asoc_eq_user and t2.cod_equipo=t5.cod_equipo ";
		$query_ppal.="left join proyecto_modernizacion.centro_costo t3 on t2.cc_ubicacion=t3.CENTRO_COSTO  ";
		$query_ppal.="left join cia_web.proveedor t6 on t4.rut_proveedor=t6.rut ";
		$query_ppal.="inner join proyecto_modernizacion.sub_clase t7 ";
		$query_ppal.="on t7.cod_clase='18003' and t4.tipo=t7.valor_subclase3 and left(t4.codigo,3)=t7.valor_subclase1 " ;
		$query_ppal.="inner join proyecto_modernizacion.sub_clase t8 ";
		$query_ppal.="on t8.cod_clase='18001' and t4.estado=t8.cod_subclase " ;
		if($ver_todos!="on")
		{
			$query_ppal.="where t4.tipo= '".$opcion."' ";   
			switch($buscar_por)
			{
				case "codigo"://POR CODIGO
					$query_ppal.="and t4.codigo like '%".$buscar."%' ";
					break;
				case "marca"://POR MARCA
					$query_ppal.="and t4.marca like '%".$buscar."%' ";
					//echo($query_ppal);
					break;
				case "modelo"://POR MODELO
					$query_ppal.="and t4.modelo like '%".$buscar."%' ";
					break;
				case "usuario":		//buscar por usuario
					switch($cmbUsuario)
					{
						case "RUT":
							$query_ppal.="and t1.RUT='".$buscar."' ";
							break;
						case "APELLIDO_PATERNO":
							$query_ppal.="and t1.APELLIDO_PATERNO like '%".$buscar."%' ";
							break;
						case "APELLIDO_MATERNO":
							$query_ppal.="and t1.APELLIDO_MATERNO like '%".$buscar."%' ";
							break;
						case "NOMBRES":
							$query_ppal.="and t1.nombres like '%".$buscar."%' ";
							break;
					}
					break;
			    case "nro_serie"://POR NUMERO DE SERIE
					$query_ppal.="and t4.nro_serie like '%".$buscar."%' ";
					break;
				case "p_garantia"://POR PERIODO DE GARANTIA
					$query_ppal.="and t4.p_garantia like '%".$buscar."%' ";
					break;
                case "nro_factura"://POR NUMERO DE FACTURA
					$query_ppal.="and t4.nro_factura like '%".$buscar."%' ";
					break;
				case "nro_guia"://POR NUMERO DE GUIA
					$query_ppal.="and t4.nro_guia like '%".$buscar."%' ";
					break;
				case "fecha_compra"://POR FECHA DE COMPRA
			        $fecha=explode("-",$buscar);
					$FechaCompra=$fecha[2]."-".$fecha[1]."-".$fecha[0];
					$query_ppal.="and t4.fecha_compra = '".$FechaCompra."'";
		           	break;
                case "cod_activo_fijo"://POR CODIGO ACTIVO FIJO
					$query_ppal.="and t4.cod_activo_fijo like '%".$buscar."%' ";
					break;
				case "proveedor":	//busqueda por proveedor
					$query_ppal.="and t4.rut_proveedor = '".$cmbProveedor."' ";
					break;
				case "ubicacion":	//busqueda por ubicacion
					$query_ppal.="and t2.cc_ubicacion = '".$cmbUbicacion."' ";
					break;
				case "tipo"://POR TIPO DE EQUIPO
					$query_ppal.="and t4.codigo like '%".$cmbTipo."%' ";
					break;
				default:	//todos los otros casos
					$query_ppal="select * from cia_web.hardware where ";
					if($buscar_por=="fecha_compra")
   					{
						$fecha=explode("-",$buscar);
					    $buscar=$fecha[2]."-".$fecha[1]."-".$fecha[0];
				    }
				    $query_ppal.=$buscar_por." like '%".$buscar."%' ";
					 break;
			}
           
		}
		if ($ver_todos=="all") 
		{		
		   $query_ppal="select t2.cc_ubicacion,t1.RUT,t7.nombre_subclase as desc_equipo,t8.nombre_subclase as nom_estado,t4.codigo,t4.tipo,t4.rut_proveedor,t6.razon_social,t4.marca,t4.modelo,t4.fecha_compra,t4.nro_serie,t2.cc_ubicacion,t3.DESCRIPCION,concat(t1.nombres,' ',t1.apellido_paterno,' ',t1.apellido_materno) as nombre,t4.estado "; 
		$query_ppal.="from cia_web.hardware t4 left join cia_web.asoc_equipos_usuarios t2 on t2.nro_asoc=t4.nro_asociacion_activa  left join bd_rrhh.antecedentes_personales t1 on t1.RUT=t2.rut_usuario ";
		if($opcion=="PARTE")
			$query_ppal.="left join  cia_web.asoc_partes_equipos t5 on t2.nro_asoc=t5.nro_asoc_eq_user and t2.cod_equipo=t5.cod_equipo ";
		$query_ppal.="left join proyecto_modernizacion.centro_costo t3 on t2.cc_ubicacion=t3.CENTRO_COSTO  ";
		$query_ppal.="left join cia_web.proveedor t6 on t4.rut_proveedor=t6.rut ";
		$query_ppal.="inner join proyecto_modernizacion.sub_clase t7 ";
		$query_ppal.="on t7.cod_clase='18003' and t4.tipo=t7.valor_subclase3 and left(t4.codigo,3)=t7.valor_subclase1 " ;
		$query_ppal.="inner join proyecto_modernizacion.sub_clase t8 ";
		$query_ppal.="on t8.cod_clase='18001' and t4.estado=t8.cod_subclase";
		break;
		}
    }

//se realiza la consulta
$result=mysql_query($query_ppal,$link);
//echo($query_ppal);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
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
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script type="text/javascript" src="funciones.js"></script>
<script language="JavaScript">
var popup=0;	//referencia para el popup con los detalles

function volver(op)
{
	var f=document.frmVerDatos;
	switch(op)
	{
		case 1:
			f.action="consultar_proveedores.php";
			f.submit();
			break;
		case 2:
			f.action="consultar_sw.php";
			f.submit();
			break;
		case 3:
			f.action="consultar_equipos.php";
			f.submit();
			break;
	}
}

function to_excel(op,To_Excel)
{
	var URL,opciones;
	URL="ToExcel/ver_datos_excel.php?op=" + op + "&To_Excel=" + To_Excel;
	opciones="toolbar=0,resizable=0,menubar=1,status=1";
	verificar_popup(popup);
	popup=window.open(URL,"",opciones);
	popup.focus();
	popup.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
	popup.moveTo(0,0);
	 
}

function inicia()
{
	window.moveTo(0,0);
	window.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
}


function ir(opcion,cant)
{
	var f=document.frmVerDatos,i;
	//se valida la seleccion
	if(cant==1)
	{
		if(!f.enlace.checked)
		{
			alert("Debe Marcar una de las casillas para poder ver su Detalle");
			return false;
		}
			
	}
	else
	{
		for(i=0;i< f.enlace.length;i++)
		{
			if(f.enlace[i].checked)
				break;
		}
		if(i==f.enlace.length)
		{
			alert("Debe Marcar una de las casillas para poder ver su Detalle");
			return false;
		}
	}
	//se levanta un popup con la informacion solicitada
	var URL,opciones;
	opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=565,height=700,status=1';
	switch(opcion)
	{
		case 1:	//ver detalle de equipo
			URL="ver_equipo.php?valor=";
			if(cant==1)
			 	URL+=f.enlace.value;
			else
				URL+=f.enlace[i].value;
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo(0,0);
			break;
		case 2:	//ver detalle de proveedor
			var foo;
			if(cant==1)
			 	foo=f.enlace.value.split(";");
			else
				foo=f.enlace[i].value.split(";");
			//0if(foo[2]=="")
			//{
			//	alert("Este equipo no tiene un Proveedor Asignado");
			//	return false;
			//}
			URL="ver_proveedor.php?valor="; 
			if(cant==1)
			 	URL+=f.enlace.value;
			else
				URL+=f.enlace[i].value;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=565,height=420,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo(0,0);
			break;
		case 3:	//ver detalle del usuario
			//se analiza si hay un usuario
			var foo;
			if(cant==1)
			 	foo=f.enlace.value;
				//.split(";")
						
			else
				foo=f.enlace[i].value;
				//.split(";");
			//if(foo[3]=="")
			//{
			//	alert("Este equipo no tiene un Usuario Asignado");
			//	return false;
			//}
			URL="ver_usuario.php?valor="; 
			if(cant==1)
			 	URL+=f.enlace.value;
			else
				URL+=f.enlace[i].value;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=565,height=300,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo(0,0);
			break;
			
		case 4:	//Ver Nuevo Reporte de Falla
			//URL="ing_reporte_falla.php";
		    URL="ing_reporte_falla.php?valor=";
			if(cant==1)
			 	URL+=f.enlace.value;
			else
				URL+=f.enlace[i].value;
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo(0,0);
			break;
               
				
		case 5:	//ver fallas del equipo
			//se analiza si hay fallas
			var foo;
			if(cant==1)
			 	foo=f.enlace.value.split(";");
				
			else
				foo=f.enlace[i].value.split(";");
			if(foo[5]=="")
			{
				alert("Este equipo no tiene fallas asociadas");
				return false;
			}
			URL="det_fallas.php?valor="; 
			if(cant==1)
			 	URL+=f.enlace.value;
			else
				URL+=f.enlace[i].value;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=565,height=300,status=1';
			//verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo(0,0);
			break;
			
	}
	return true;
}

function modificar(opcion,cant)
{
	var f=document.frmVerDatos,i;
	//se valida la seleccion
	if(cant==1)
	{
		if(!f.enlace.checked)
		{
			alert("Debe Marcar una de las casillas para poder modificar");
			return false;
		}
			
	}
	else
	{
		for(i=0;i< f.enlace.length;i++)
		{
			if(f.enlace[i].checked)
				break;
		}
		if(i==f.enlace.length)
		{
			alert("Debe Marcar una de las casillas para poder modificar");
			return false;
		}
	}
	//se levanta un popup con la informacion solicitada
	var URL,opciones;
	switch(opcion)
	{
		case 1:	//modificar proveedor
			URL="ver_proveedor.php?valor="; 
			if(cant==1)
			 	URL+=";;" + f.enlace.value;
			else
				URL+=";;" + f.enlace[i].value;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=565,height=420,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo(0,0);
			break;
		case 2:	//modificar software
			URL="ver_sw.php?codigo="; 
			if(cant==1)
			 	URL+=f.enlace.value;
			else
				URL+=f.enlace[i].value;
			opciones='resizable=0,toolbar=0,scrollbars=1,menubar=0,width=565,height=480,status=1';
			verificar_popup(popup);
			popup=window.open(URL,"",opciones);
			popup.focus();
			popup.moveTo(0,0);
			break;
	}
}

function sort_by(opcion)
{
	document.frmVerDatos.action="ver_datos.php?order_by=" + opcion;
	document.frmVerDatos.submit();
}
</script>
</head>

<body bgcolor="#CCCCCC" onLoad="inicia()" onUnload="verificar_popup(popup)">
<form name="frmVerDatos" method="post">
<input type="hidden" name="ver_todos" value="<?php echo $ver_todos;?>">
<input type="hidden" name="buscar" value="<?php echo $buscar;?>">
<input type="hidden" name="buscar_por" value="<?php echo $buscar_por;?>">
<input type="hidden" name="buscar_campo" value="<?php echo $buscar_campo;?>">
<input type="hidden" name="cmbEstado" value="<?php echo $cmbEstado;?>">
<input type="hidden" name="cmbTipo" value="<?php echo $cmbTipo;?>">
<input type="hidden" name="cmbUbicacion" value="<?php echo $cmbUbicacion;?>">
<input type="hidden" name="opcion" value="<?php echo $opcion;?>">
<input type="hidden" name="cmbUsuario" value="<?php echo $cmbUsuario;?>">
<input type="hidden" name="cmbProveedor" value="<?php echo $cmbProveedor;?>">
<input type="hidden" name="op" value="<?php echo $op;?>">
<?php
//se construye el string para llevar la tabla a excel
$to_excel=$ver_todos.";".$order_by.";".$buscar;
if($op==3)
	$to_excel.=";".$buscar_por.";".$opcion.";".$cmbEstado.";".$cmbTipo.";".$cmbUbicacion.";".$cmbUsuario.";".$cmbProveedor;
else
	$to_excel.=";".$buscar_campo;
?>
  <!---------------------------------- cuerpo de la pagina ------------------------------------->
  <table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" width="900" align="center">
<tr>
	  <td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="870">
	<tr>
		<td class="ColorTabla01" align="center"><strong>Resultados de la Busqueda.</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
		<?php
		if($op==3 && mysql_num_rows($result))
		{
			$var=mysql_num_rows($result);
			echo '<tr><td align="center">';
			echo '<table width="700" style="border:solid 1px #666666;">';
			echo '<tr><td align="center">';
			
			echo '<input type="button" name="det_equipo" value="Detalle Equipo" style="width: 110px;" onClick="ir(1,'.$var.')">&nbsp;&nbsp;&nbsp;';
			echo '<input type="button" name="det_prov" value="Detalle Proveedor" style="width: 110px;" onClick="ir(2,'.$var.')">&nbsp;&nbsp;&nbsp;';
			echo '<input type="button" name="det_user" value="Detalle Usuario" style="width: 110px;" onClick="ir(3,'.$var.')">&nbsp;&nbsp;&nbsp;';
			echo '<input type="button" name="rep_fallas" value="Reporte de Fallas" style="width: 110px;" onClick="ir(4,'.$var.')">&nbsp;&nbsp;&nbsp;';
			echo '<input type="button" name="his_fallas" value="Historial de Fallas" style="width: 110px;" onClick="ir(5,'.$var.')">&nbsp;&nbsp;&nbsp;';	
			echo '</td></tr>';
			echo '</table>';
			echo '</td></tr>';
			echo '<tr><td>&nbsp;</td></tr>';
		}
		if($op==1 && mysql_num_rows($result))
		{
			$var=mysql_num_rows($result);
			echo '<tr><td align="center">';
			echo '<table width="500" style="border:solid 1px #666666;">';
			echo '<tr><td align="center">';
			echo '<input type="button" name="mod" value="Modificar" style="width: 110px;" onClick="modificar(1,'.$var.')">';
			echo '</td></tr>';
			echo '</table>';
			echo '</td></tr>';
			echo '<tr><td>&nbsp;</td></tr>';
		}
		if($op==2 && mysql_num_rows($result))
		{
			$var=mysql_num_rows($result);
			echo '<tr><td align="center">';
			echo '<table width="500" style="border:solid 1px #666666;">';
			echo '<tr><td align="center">';
			echo '<input type="button" name="mod" value="Modificar" style="width: 110px;" onClick="modificar(2,'.$var.')">';
			echo '</td></tr>';
			echo '</table>';
			echo '</td></tr>';
			echo '<tr><td>&nbsp;</td></tr>';
		}
		?>
	<tr>
		<td>
		<table cellpadding="0" cellspacing="2" align="center" width="850" >
		<?php
		//se verifica si se obtuvieron resultados de la consulta
		if(mysql_num_rows($result)==0) 
		{
			echo "<tr>";
			echo '<td align="center" width="830" bgcolor="#999999"><font color="#FFFFFF"><strong>No se encontraron resultados</strong></font></td>';
			echo "</tr>";
		}
		else
		{
		//se muestra el resultado segun la opcion ($op) y los campos seleccionados
		switch($op)
		{
			case 1:		//proveedores
				echo "<tr>";
				echo '<td width="30">&nbsp;</td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;" width="80"><a href="javascript: sort_by(\'rut\');" class="LINK">RUT</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'razon_social\');" class="LINK">RAZ. SOCIAL</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'nombre_fantasia\');" class="LINK">NOM. FANTASIA</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'contacto_1\');" class="LINK">CONTACTO 1</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'contacto_2\');" class="LINK">CONTACTO 2</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'fono_1\');" class="LINK">FONO 1</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'fono_2\');" class="LINK">FONO 2</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'fax\');" class="LINK">FAX</a></td>';
				echo "</tr>";
				
				//ahora se muestran los datos
				while($resp=mysql_fetch_array($result))
				{
					echo "<tr>";
					//enlace para edicion
					echo '<td align="center" style="border:solid 1px #666666;">';
					echo '<input type="radio" name="enlace" value="'.$resp["RUT"].'"></td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["rut"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["razon_social"].'&nbsp;</td>';	
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["nombre_fantasia"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["contacto_1"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["contacto_2"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["fono_1"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["fono_2"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["fax"].'&nbsp;</td>';
					echo "</tr>";
				}
				break;
			case 2:		//software
				echo "<tr>";
				echo '<td width="30">&nbsp;</td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;" width="80"><a href="javascript: sort_by(\'codigo\');" class="LINK">CODIGO</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'marca\');" class="LINK">MARCA</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'nombre\');" class="LINK">NOMBRE</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'version_sw\');" class="LINK">VERSION</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'tipo\');" class="LINK">TIPO</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;" width="80"><a href="javascript: sort_by(\'fecha_compra\');" class="LINK">FECHA COMPRA</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'nro_factura\');" class="LINK">NRO. FACTURA</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'rut_proveedor\');" class="LINK">PROVEEDOR</a></td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;"><a href="javascript: sort_by(\'descripcion\');" class="LINK">DESCRIPCION</a></td>';				
				echo "</tr>";
				
				//ahora se muestran los datos
				while($resp=mysql_fetch_array($result))
				{
					echo "<tr>";
					echo '<td align="center" style="border:solid 1px #666666;">';
					echo '<input type="radio" name="enlace" value="'.$resp["codigo"].'"></td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["codigo"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["marca"].'&nbsp;</td>';	
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["nombre"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["version_sw"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["tipo"].'&nbsp;</td>';
					$fecha=explode("-",$resp["fecha_compra"]);
					$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
					echo '<td align="center" style="border:solid 1px #666666;">'.$fecha.'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["nro_factura"].'&nbsp;</td>';
					//se muestra el proveedor
					echo '<td align="center" style="border:solid 1px #666666;">';
					$query="select razon_social as rs from proveedor where rut='".$resp["rut_proveedor"]."';";
					$res_tmp=mysql_db_query("cia_web",$query,$link);
					$r_tmp=mysql_fetch_array($res_tmp);
					echo $r_tmp["rs"].'&nbsp;</td>';
					mysql_free_result($res_tmp);
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["descripcion"].'&nbsp;</td>';
					echo "</tr>";
				}
				break;
			case 3:		//equipos
				echo "<tr>";
				echo '<td width="30">&nbsp;</td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;" width="80">CODIGO</td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">TIPO EQUIPO</td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">MARCA</td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">MODELO</td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">NRO SERIE</td>';
				echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">ESTADO</td>';
				while($resp=mysql_fetch_array($result))
				{
					echo "<tr>";
					echo '<td align="center" style="border:solid 1px #666666;">';
					echo '<input type="radio" name="enlace" value="';
					echo $resp["codigo"].';'.$resp["tipo"].';'.$resp["proveedor"].';'.$resp["RUT"].'"></td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["codigo"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["desc_equipo"];
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["marca"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["modelo"].'&nbsp;</td>';	
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["nro_serie"].'&nbsp;</td>';
					echo '<td align="center" style="border:solid 1px #666666;">'.$resp["nom_estado"].'&nbsp </td>';
				}
				break;
		}
		}		
		?>
		</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td align="center">
	<?php
	if(mysql_num_rows($result))
		echo '<input type="button" name="ToExcel" value="Excel" style="width: 80px;" onClick="javascript: to_excel('.$op.',\''.$to_excel.'\')">&nbsp;&nbsp;&nbsp;';
	?>
	<input type="button" name="Salir" value="Volver" onClick="javascript: volver(<?php echo $op;?>);" style="width: 80px;">
	&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="button" name="Out" value="Salir" onClick="salir()" style="width: 80px;">
	</td>
</tr>
<tr>
	  <td>&nbsp;</td>
</tr>
</table>

</form>
</body>
</html>
