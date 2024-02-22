<?php
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include ("../../principal/conectar_principal.php");

//se inicializan las variables en base a los parametros entregados
$foobar=explode(";",$To_Excel);

$ver_todos=$foobar[0];
$order_by=$foobar[1];
$buscar=$foobar[2];
if($op==3)
{
	$buscar_por=$foobar[3];
	$opcion=$foobar[4];
	$cmbEstado=$foobar[5];
	$cmbTipo=$foobar[6];
	$cmbUbicacion=$foobar[7];
	$cmbUsuario=$foobar[8];
	$cmbProveedor=$foobar[9];
}
else
	$buscar_campo=$foobar[3];

//se construye la consulta
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
		$query_ppal="select t2.cc_ubicacion,t1.RUT,t7.nombre_subclase as desc_equipo,t8.nombre_subclase as nom_estado,t4.codigo,t4.tipo,t4.rut_proveedor,t6.razon_social,t4.marca,t4.modelo,t4.fecha_compra,t4.nro_serie,t2.cc_ubicacion,t3.DESCRIPCION,concat(t1.nombres,' ',t1.apellido_paterno,' ',t1.apellido_materno) as nombre,t4.estado "; 
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
					$query_ppal.="and t1.cod_activo_fijo like '%".$buscar."%' ";
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
		break;
}
//se realiza la consulta
$result=mysql_query($query_ppal,$link);

?>
<html>
<body>
<?php
if($op==1)
{
?>
<table border="1" align="left">
<tr bgcolor="#999999">
	<th align="center" colspan="8">RESULTADOS DE LA BUSQUEDA (opcion: Proveedores)</th>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Rut</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Raz&oacute;n Social</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Nombre Fantasia</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Contacto 1</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Contacto 2</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Fono 1</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Fono 2</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Fax</strong></td>
</tr>
<?php
while($resp=mysql_fetch_array($result))
{
	echo '<tr bgcolor="#E8FDD9">';
	echo '<td align="center">'.$resp["rut"].'&nbsp;</td>';
	echo '<td align="center">'.$resp["razon_social"].'&nbsp;</td>';	
	echo '<td align="center">'.$resp["nombre_fantasia"].'&nbsp;</td>';
	echo '<td align="center">'.$resp["contacto_1"].'&nbsp;</td>';
	echo '<td align="center">'.$resp["contacto_2"].'&nbsp;</td>';
	echo '<td align="center">'.$resp["fono_1"].'&nbsp;</td>';
	echo '<td align="center">'.$resp["fono_2"].'&nbsp;</td>';
	echo '<td align="center">'.$resp["fax"].'&nbsp;</td>';
	echo "</tr>";
}
?>
</table>
<?php
}
if($op==2)
{
?>
<table border="1" align="left">
<tr bgcolor="#999999">
	<th align="center" colspan="9">RESULTADOS DE LA BUSQUEDA (opcion: Software)</th>
</tr>
<tr>
	<td align="center" bgcolor="#CCCCCC"><strong>Codigo</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Marca</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Nombre</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Versi&oacute;n</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Tipo</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Fecha Compra</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Nro Factura</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Proveedor</strong></td>
	<td align="center" bgcolor="#CCCCCC"><strong>Descripci&oacute;n</strong></td>
</tr>
<?php
while($resp=mysql_fetch_array($result))
{
	echo '<tr bgcolor="#E8FDD9">';
	echo '<td align="center">'.$resp["codigo"].'&nbsp;</td>';
	echo '<td align="center">'.$resp["marca"].'&nbsp;</td>';	
	echo '<td align="center">'.$resp["nombre"].'&nbsp;</td>';
	echo '<td align="center">'.$resp["version_sw"].'&nbsp;</td>';
	echo '<td align="center">'.$resp["tipo"].'&nbsp;</td>';
	$fecha=explode("-",$resp["fecha_compra"]);
	$fecha=$fecha[2]."-".$fecha[1]."-".$fecha[0];
	echo '<td align="center">'.$fecha.'&nbsp;</td>';
	echo '<td align="center">'.$resp["nro_factura"].'&nbsp;</td>';
	//se muestra el proveedor
	echo '<td align="center">';
	$query="select razon_social as rs from proveedor where rut='".$resp["rut_proveedor"]."';";
	$res_tmp=mysql_db_query("cia_web",$query,$link);
	$r_tmp=mysql_fetch_array($res_tmp);
	echo $r_tmp["rs"]."</td>";
	mysql_free_result($res_tmp);
	echo '<td align="center">'.$resp["descripcion"].'&nbsp;</td>';
	echo "</tr>";
}
?>
</table>
<?php
}
if($op==3)
{
?>
<table border="1" align="left">
<tr bgcolor="#999999">
	<th align="center" colspan="6">RESULTADOS DE LA BUSQUEDA (opcion: Hardware)</th>
</tr>
<?php
	echo "<tr>";
	echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;" width="80">CODIGO</td>';
	echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">TIPO EQUIPO</td>';
	echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">MARCA</td>';
	echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">MODELO</td>';
	echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">NRO SERIE</td>';
	echo '<td align="center" bgcolor="#CCCCCC" style="border:solid 1px #666666;">ESTADO</td>';
	echo "</tr>";
	while($resp=mysql_fetch_array($result))
	{
		echo "<tr>";
		echo '<td align="center" style="border:solid 1px #666666;">'.$resp["codigo"].'&nbsp;</td>';
		echo '<td align="center" style="border:solid 1px #666666;">'.$resp["desc_equipo"];
		echo '<td align="center" style="border:solid 1px #666666;">'.$resp["marca"].'&nbsp;</td>';
		echo '<td align="center" style="border:solid 1px #666666;">'.$resp["modelo"].'&nbsp;</td>';	
		echo '<td align="center" style="border:solid 1px #666666;">'.$resp["nro_serie"].'&nbsp;</td>';
		echo '<td align="center" style="border:solid 1px #666666;">'.$resp["nom_estado"].'&nbsp </td>';
		echo "</tr>";
	}
?>
</table>
<?php
}
?>
</body>
</html>
