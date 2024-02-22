
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../../principal/estilos/css_principal.css" type="text/css" rel="stylesheet">
<style>
<!--
.LINK{
	font:Arial, Helvetica, sans-serif;
	color:#FFFF00;
	text-align:center;
	text-decoration:none;
}

a:link{
	color:#FFFF00;
}	

a:hover{
	color:#FFFF00;
}

a:visited{
	color:#FFFF00;
}

a:active{
	color:#FFFFFF;
}

.CELDA{
	border: solid 1px #333333;
	text-align: center;
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cia Web</title>
<script language="JavaScript">
function mostrar()
{
	var f=document.frmFiltroListado;
	switch(f.filtro.value)
	{                                                                                            
		case 'todos':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";
			f.buscar3.style.width="0px"; f.buscar3.style.visibility="hidden";
			f.cmbMarcaE.style.width="0px"; f.cmbMarcaE.style.visibility="hidden";
            f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="0px"; f.cmbModeloE.style.visibility="hidden";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
            f.cmbDetalle.style.width="0px"; f.cmbDetalle.style.visibility="hidden";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";			
			f.cmbProveedor.style.width="0px";f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
			f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.opcion_p[0].style.visibility="hidden";
			f.opcion_p[1].style.visibility="hidden";
			f.opcion[0].style.visibility="";
			f.opcion[1].style.visibility="";
			f.opcion[2].style.visibility="";
			f.NomTodos.style.visibility="";
			f.NomEquipo.style.visibility="";
			f.NomParte.style.visibility="";
			f.Nomequipo_s.style.visibility="hidden";
			f.Nomparte_s.style.visibility="hidden";
			
			break;
		case 't_equipo':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";
			f.buscar3.style.width="0px"; f.buscar3.style.visibility="hidden";
			//f.cmbEstado.style.width="0px"; f.cmbEstado.style.visibility="hidden";
			f.cmbMarcaE.style.width="0px"; f.cmbMarcaE.style.visibility="hidden";
			f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="0px"; f.cmbModeloE.style.visibility="hidden";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
			f.cmbDetalle.style.width="0px"; f.cmbDetalle.style.visibility="hidden";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";
			f.cmbProveedor.style.width="0px"; f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="200px";f.cmbTipo.style.visibility="visible";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
			f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.opcion_p[0].style.visibility="hidden";
			f.opcion_p[1].style.visibility="hidden";
			f.opcion[0].style.visibility="hidden";
			f.opcion[1].style.visibility="hidden";
			f.opcion[2].style.visibility="hidden";
			f.NomTodos.style.visibility="hidden";
			f.NomEquipo.style.visibility="hidden";
			f.NomParte.style.visibility="hidden";
			f.Nomequipo_s.style.visibility="hidden";
			f.Nomparte_s.style.visibility="hidden";
			f.cmbTipo.focus();
			break;
		case 'marca':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";
			f.buscar3.style.width="0px"; f.buscar3.style.visibility="hidden";
			f.cmbMarcaE.style.width="150px"; f.cmbMarcaE.style.visibility="";
			f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="0px"; f.cmbModeloE.style.visibility="hidden";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
			//f.cmbEstado.style.width="180px"; f.cmbEstado.style.visibility="visible";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";
			f.cmbDetalle.style.width="0px"; f.cmbDetalle.style.visibility="hidden";			
			f.cmbProveedor.style.width="0px";f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
			f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.opcion_p[0].style.visibility="";
			f.opcion_p[1].style.visibility="";
			f.opcion[0].style.visibility="hidden";
			f.opcion[1].style.visibility="hidden";
			f.opcion[2].style.visibility="hidden";
			f.NomTodos.style.visibility="hidden";
			f.NomEquipo.style.visibility="hidden";
			f.NomParte.style.visibility="hidden";
			f.Nomequipo_s.style.visibility="";
			f.Nomparte_s.style.visibility="";
			
			//f.cmbEstado.focus();
			break;
		case 'proveedor':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";
			f.buscar3.style.width="0px"; f.buscar3.style.visibility="hidden";
			f.cmbMarcaE.style.width="0px"; f.cmbMarcaE.style.visibility="hidden";
			f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="0px"; f.cmbModeloE.style.visibility="hidden";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbDetalle.style.width="0px"; f.cmbDetalle.style.visibility="hidden";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";			
			f.cmbProveedor.style.width="200px";f.cmbProveedor.style.visibility="";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
            f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
			f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.opcion_p[0].style.visibility="hidden";
			f.opcion_p[1].style.visibility="hidden";
			f.opcion[0].style.visibility="";
			f.opcion[1].style.visibility="";
			f.opcion[2].style.visibility="";
			f.NomTodos.style.visibility="";
			f.NomEquipo.style.visibility="";
			f.NomParte.style.visibility="";
			f.Nomequipo_s.style.visibility="hidden";
			f.Nomparte_s.style.visibility="hidden";
			f.cmbProveedor.focus();
			break;
		case 'usuario':
			f.buscar.style.width="150px"; f.buscar.style.visibility="visible";
			f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";
			f.buscar3.style.width="0px"; f.buscar3.style.visibility="hidden";
			f.cmbMarcaE.style.width="0px"; f.cmbMarcaE.style.visibility="hidden";
			f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="0px"; f.cmbModeloE.style.visibility="hidden";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
			//f.cmbEstado.style.width="0px"; f.cmbEstado.style.visibility="hidden";
			f.cmbUsuario.style.width="130px"; f.cmbUsuario.style.visibility="visible";
			f.cmbProveedor.style.width="0px"; f.cmbProveedor.style.visibility="hidden";
			f.cmbDetalle.style.width="0px"; f.cmbDetalle.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
			f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.opcion_p[0].style.visibility="hidden";
			f.opcion_p[1].style.visibility="hidden";
			f.opcion[0].style.visibility="";
			f.opcion[1].style.visibility="";
			f.opcion[2].style.visibility="";
			f.NomTodos.style.visibility="";
			f.NomEquipo.style.visibility="";
			f.NomParte.style.visibility="";
			f.Nomequipo_s.style.visibility="hidden";
			f.Nomparte_s.style.visibility="hidden";
			f.buscar.value=""; f.buscar.focus();
			break;
            case 'modelo':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";
			f.buscar3.style.width="0px"; f.buscar3.style.visibility="hidden";
			f.cmbMarcaE.style.width="0px"; f.cmbMarcaE.style.visibility="hidden";
			f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="250px"; f.cmbModeloE.style.visibility="";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
			//f.cmbEstado.style.width="180px"; f.cmbEstado.style.visibility="visible";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";
			f.cmbDetalle.style.width="0px"; f.cmbDetalle.style.visibility="hidden";			
			f.cmbProveedor.style.width="0px";f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
			f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.opcion_p[0].style.visibility="";
			f.opcion_p[1].style.visibility="";
			f.opcion[0].style.visibility="hidden";
			f.opcion[1].style.visibility="hidden";
			f.opcion[2].style.visibility="hidden";
			f.NomTodos.style.visibility="hidden";
			f.NomEquipo.style.visibility="hidden";
			f.NomParte.style.visibility="hidden";
			f.Nomequipo_s.style.visibility="";
			f.Nomparte_s.style.visibility="";
			
			//f.cmbEstado.focus();
			break;


		case 'ubi':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";
			f.buscar3.style.width="0px"; f.buscar3.style.visibility="hidden";
			f.cmbDetalle.style.width="0px"; f.cmbDetalle.style.visibility="hidden";
			f.cmbMarcaE.style.width="0px"; f.cmbMarcaE.style.visibility="hidden";
			f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="0px"; f.cmbModeloE.style.visibility="hidden";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
			//f.cmbEstado.style.width="0px"; f.cmbEstado.style.visibility="hidden";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";			
			f.cmbProveedor.style.width="0px";f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="300px";f.cmbUbicacion.style.visibility="visible";
			f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
			f.opcion_p[0].style.visibility="hidden";
			f.opcion_p[1].style.visibility="hidden";
			f.opcion[0].style.visibility="";
			f.opcion[1].style.visibility="";
			f.opcion[2].style.visibility="";
			f.NomTodos.style.visibility="";
			f.NomEquipo.style.visibility="";
			f.NomParte.style.visibility="";
			f.Nomequipo_s.style.visibility="hidden";
			f.Nomparte_s.style.visibility="hidden";
			f.cmbUbicacion.focus();
			break;
		case 'detalle_equipo':
			f.buscar.style.width="150px"; f.buscar.style.visibility="visible";
			f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";
			f.buscar3.style.width="0px"; f.buscar3.style.visibility="hidden";
			f.cmbDetalle.style.width="130px"; f.cmbDetalle.style.visibility="visible";
            f.cmbMarcaE.style.width="0px"; f.cmbMarcaE.style.visibility="hidden";
            f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="0px"; f.cmbModeloE.style.visibility="hidden";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
			//f.cmbEstado.style.width="0px"; f.cmbEstado.style.visibility="hidden";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";			
			f.cmbProveedor.style.width="0px";f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
			f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.opcion_p[0].style.visibility="hidden";
			f.opcion_p[1].style.visibility="hidden";
			f.opcion[0].style.visibility="hidden";
			f.opcion[1].style.visibility="hidden";
			f.opcion[2].style.visibility="hidden";
			f.NomTodos.style.visibility="hidden";
			f.NomEquipo.style.visibility="hidden";
			f.NomParte.style.visibility="hidden";
			f.Nomequipo_s.style.visibility="hidden";
			f.Nomparte_s.style.visibility="hidden";
			f.buscar.focus();
			break;				
		case 'nro_serie':
			f.buscar.style.width="0px"; f.buscar.style.visibility="hidden";
			f.buscar2.style.width="150px"; f.buscar2.style.visibility="";
			f.cmbSerie.style.width="150px";f.cmbSerie.style.visibility="";
			f.cmbDetalle.style.width="0px"; f.cmbDetalle.style.visibility="hidden";
            f.cmbMarcaE.style.width="0px"; f.cmbMarcaE.style.visibility="hidden";
            f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="0px"; f.cmbModeloE.style.visibility="hidden";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
			//f.cmbEstado.style.width="0px"; f.cmbEstado.style.visibility="hidden";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";			
			f.cmbProveedor.style.width="0px";f.cmbProveedor.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
       		f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.opcion_p[0].style.visibility="";
			f.opcion_p[1].style.visibility="";
			f.opcion[0].style.visibility="hidden";
			f.opcion[1].style.visibility="hidden";
			f.opcion[2].style.visibility="hidden";
			f.NomTodos.style.visibility="hidden";
			f.NomEquipo.style.visibility="hidden";
			f.NomParte.style.visibility="hidden";
			f.Nomequipo_s.style.visibility="";
			f.Nomparte_s.style.visibility="";
			f.opcion[1].checked = true;
		    f.buscar2.focus();
			break;	
		
		default:
			f.buscar.style.width="150px"; f.buscar.style.visibility="";
			f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";
			f.buscar3.style.width="0px"; f.buscar3.style.visibility="hidden";
			f.cmbMarcaE.style.width="0px"; f.cmbMarcaE.style.visibility="hidden";
            f.cmbMarcaP.style.width="0px"; f.cmbMarcaP.style.visibility="hidden";
			f.cmbModeloE.style.width="0px"; f.cmbModeloE.style.visibility="hidden";
            f.cmbModeloP.style.width="0px"; f.cmbModeloP.style.visibility="hidden";
			//f.cmbEstado.style.width="0px"; f.cmbEstado.style.visibility="hidden";
			f.cmbUsuario.style.width="0px"; f.cmbUsuario.style.visibility="hidden";
			f.cmbTipo.style.width="0px";f.cmbTipo.style.visibility="hidden";
			f.cmbDetalle.style.width="0px"; f.cmbDetalle.style.visibility="hidden";
			f.cmbProveedor.style.width="0px"; f.cmbProveedor.style.visibility="hidden";
			f.cmbUbicacion.style.width="0px";f.cmbUbicacion.style.visibility="hidden";
			f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
            f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
			f.opcion_p[0].style.visibility="hidden";
			f.opcion_p[1].style.visibility="hidden";
			f.opcion[0].style.visibility="hidden";
			f.opcion[1].style.visibility="hidden";
			f.opcion[2].style.visibility="hidden";
			f.NomTodos.style.visibility="hidden";
			f.NomEquipo.style.visibility="hidden";
			f.NomParte.style.visibility="hidden";
			f.Nomequipo_s.style.visibility="hidden";
			f.Nomparte_s.style.visibility="hidden";
			//f.buscar.value=""; 
			
			f.buscar.focus();
			break;
	}
}

function ver_todos(opcion)
{
	var f=document.frmFiltroListado;
	switch(opcion)
	{
		case 1:
			f.codigo.checked=f.codigo.disabled=f.todos_equipos.checked;
			f.marca.checked=f.marca.disabled=f.todos_equipos.checked;
			f.modelo.checked=f.modelo.disabled=f.todos_equipos.checked;
			f.nro_serie.checked=f.nro_serie.disabled=f.todos_equipos.checked;
			f.fecha_compra.checked=f.fecha_compra.disabled=f.todos_equipos.checked;
			f.p_garantia.checked=f.p_garantia.disabled=f.todos_equipos.checked;
			f.nro_factura.checked=f.nro_factura.disabled=f.todos_equipos.checked;
			f.nro_guia.checked=f.nro_guia.disabled=f.todos_equipos.checked;
			//f.estado.checked=f.estado.disabled=f.todos_equipos.checked;
			f.observaciones.checked=f.observaciones.disabled=f.todos_equipos.checked;
			f.tipo.checked=f.tipo.disabled=f.todos_equipos.checked;
			f.ubi.checked=f.ubi.disabled=f.todos_equipos.checked;
			f.cod_activo_fijo.checked=f.cod_activo_fijo.disabled=f.todos_equipos.checked;
			break;
		case 2:
			f.rut_p.checked=f.rut_p.disabled=f.todos_proveedor.checked;
			f.razon_social.checked=f.razon_social.disabled=f.todos_proveedor.checked;
			f.nombre_fantasia.checked=f.nombre_fantasia.disabled=f.todos_proveedor.checked;
			f.contacto_1.checked=f.contacto_1.disabled=f.todos_proveedor.checked;
			f.contacto_2.checked=f.contacto_2.disabled=f.todos_proveedor.checked;
			f.fono_1.checked=f.fono_1.disabled=f.todos_proveedor.checked;
			f.fono_2.checked=f.fono_2.disabled=f.todos_proveedor.checked;
			f.fax.checked=f.fax.disabled=f.todos_proveedor.checked;
			break;
		case 3:
			f.rut_u.checked=f.rut_u.disabled=f.todos_usuario.checked;
			f.nombres.checked=f.nombres.disabled=f.todos_usuario.checked;
			f.apellido_paterno.checked=f.apellido_paterno.disabled=f.todos_usuario.checked;
			f.apellido_materno.checked=f.apellido_materno.disabled=f.todos_usuario.checked;
			f.cc_user.checked=f.cc_user.disabled=f.todos_usuario.checked;
			break;
		case 4:
			f.procesador.checked=f.procesador.disabled=f.todos_detalle.checked;
			f.ram.checked=f.ram.disabled=f.todos_detalle.checked;
			f.disco_duro.checked=f.disco_duro.disabled=f.todos_detalle.checked;
			f.cant_seriales.checked=f.cant_seriales.disabled=f.todos_detalle.checked;
			f.cant_paralelos.checked=f.cant_paralelos.disabled=f.todos_detalle.checked;
			break;
		case 5:
			f.asignado.checked=f.asignado.disabled=f.todos_estado.checked;
			f.debaja.checked=f.debaja.disabled=f.todos_estado.checked;
			f.parabaja.checked=f.parabaja.disabled=f.todos_estado.checked;
			f.disponible.checked=f.disponible.disabled=f.todos_estado.checked;
			break;
		case 6:
		    f.debaja.disabled=f.asignado.checked;
			f.parabaja.disabled=f.asignado.checked;
			f.disponible.disabled=f.asignado.checked;
			break;
		case 7:
		    f.asignado.disabled=f.parabaja.checked;
			f.debaja.disabled=f.parabaja.checked;
			f.disponible.disabled=f.parabaja.checked;
			break;
		case 8:
		    f.asignado.disabled=f.debaja.checked;
			f.parabaja.disabled=f.debaja.checked;
			f.disponible.disabled=f.debaja.checked;
			break;
		case 9:
		    f.asignado.disabled=f.disponible.checked;
			f.parabaja.disabled=f.disponible.checked;
			f.debaja.disabled=f.disponible.checked;
			break;
	}
}

function validar()
{
	var f=document.frmFiltroListado;
	if(f.filtro.value!="todos")
	{
		switch(f.filtro.value)
		{
			case 't_equipo':		//tipo de equipo
				if(f.cmbTipo.value==0)
				{
					alert("Debe seleccionar un Tipo de Equipo");
					f.cmbTipo.focus();
					return false;
				}
				break;
			case 'estado':		//estado
				if(f.cmbEstado.value==0)
				{
					alert("Debe seleccionar un Estado");
					f.cmbEstado.focus();
					return false;
				}
				break;
			
			case 'marca':   //Marca
				if(f.cmbMarcaE.value==0 && f.cmbMarcaP.value ==0 )
				{
					alert("Debe seleccionar una Marca");
					//f.cmbSerie.focus();
					return false;
				}
				break;
				
			
			case 'modelo':   //Modelo
				if(f.cmbModeloE.value=="seleccione" && f.cmbModeloP.value =="seleccione")
				{
					alert("Debe seleccionar un Modelo");
					//f.cmbSerie.focus();
					return false;
				}
				break;
			case 'proveedor':		//Proveedor
				if(f.cmbProveedor.value==0)
				{
					alert("Debe seleccionar un Proveedor");
					f.cmbProveedor.focus();
					return false;
				}
				break;
			case 'ubi':		//ubicacion
				if(f.cmbUbicacion.value==0)
				{
					alert("Debe seleccionar una Ubicacion");
					f.cmbUbicacion.focus();
					return false;
				}
				break;
			case 'nro_serie':   //Número de serie
				if(f.cmbSerie.value==0 && f.CmbSerie_P.value ==0 && f.buscar2.value == "" && f.buscar3.value == "")
				{
					alert("Debe seleccionar un Número de Serie");
					//f.cmbSerie.focus();
					return false;
				}
				break;

			
			
			default:
				if(f.buscar.value=="")
				{
					alert("Debe ingresar algún parametro para realizar la busqueda");
					//f.buscar.focus();
					return false;
				}
				break;
		}
	}
	
	if(!f.codigo.checked && !f.marca.checked && !f.modelo.checked && !f.nro_serie.checked &&
		!f.fecha_compra.checked && !f.p_garantia.checked && !f.nro_factura.checked &&
		!f.nro_guia.checked && !f.observaciones.checked && !f.tipo.checked &&
		!f.ubi.checked && !f.cod_activo_fijo.checked)
	{
		alert("Debe seleccionar por lo menos un campo de EQUIPO para poder realizar la consulta");
		return false;
	}
	return true;
}

function ver()
{
	var f=document.frmFiltroListado;
	if(validar())
	{	
		//se habilitan momentaneamente los checkbox
		if(f.todos_equipos.checked)
		{
			f.codigo.disabled=f.marca.disabled=f.modelo.disabled=f.nro_serie.disabled=
			f.fecha_compra.disabled=f.p_garantia.disabled=f.nro_factura.disabled=
			f.nro_guia.disabled=f.observaciones.disabled=f.tipo.disabled=
			f.ubi.disabled=f.cod_activo_fijo.disabled=false;
		}
		if(f.todos_proveedor.checked)
		{
			f.rut_p.disabled=f.razon_social.disabled=f.nombre_fantasia.disabled=f.contacto_1.disabled=
			f.contacto_2.disabled=f.fono_1.disabled=f.fono_2.disabled=f.fax.disabled=false;
		}
		if(f.todos_usuario.checked)
		{
			f.rut_u.disabled=f.apellido_paterno.disabled=f.apellido_materno.disabled=
			f.nombres.disabled=f.cc_user.disabled=false;
		}
		if(f.todos_detalle.checked)
		{
			f.procesador.disabled=f.ram.disabled=f.disco_duro.disabled=
			f.cant_seriales.disabled=f.cant_paralelos.disabled=false;
		}
		if(f.todos_estado.checked)
		{
			f.asignado.disabled=f.debaja.disabled=f.parabaja.disabled=
			f.disponible.disabled=false;
		}
		if(f.asignado.checked)
		{
			f.debaja.disabled=f.parabaja.disabled=
			f.disponible.disabled=false;
		}
		if(f.debaja.checked)
		{
			f.asignado.disabled=f.parabaja.disabled=
			f.disponible.disabled=false;
		}
		if(f.parabaja.checked)
		{
			f.debaja.disabled=f.asignado.disabled=
			f.disponible.disabled=false;
		}
		if(f.disponible.checked)
		{
			f.debaja.disabled=f.parabaja.disabled=
			f.asignado.disabled=false;
		}
		f.action="../resultado.php?op=1";
		f.submit();
		window.resizeTo(parseInt(screen.availWidth),parseInt(screen.availHeight));
		window.moveTo(0,0);
		//se desabilitan los checkbox
		if(f.todos_equipos.checked)
		{
			f.codigo.disabled=f.marca.disabled=f.modelo.disabled=f.nro_serie.disabled=
			f.fecha_compra.disabled=f.p_garantia.disabled=f.nro_factura.disabled=
			f.nro_guia.disabled=f.observaciones.disabled=f.tipo.disabled=
			f.ubi.disabled=f.cod_activo_fijo.disabled=true;
		}
		if(f.todos_proveedor.checked)
		{
			f.rut_p.disabled=f.razon_social.disabled=f.nombre_fantasia.disabled=f.contacto_1.disabled=
			f.contacto_2.disabled=f.fono_1.disabled=f.fono_2.disabled=f.fax.disabled=true;
		}
		if(f.todos_usuario.checked)
		{
			f.rut_u.disabled=f.apellido_paterno.disabled=f.apellido_materno.disabled=
			f.nombres.disabled=f.cc_user.disabled=true;
		}
		if(f.todos_detalle.checked)
		{
			f.procesador.disabled=f.ram.disabled=f.disco_duro.disabled=
			f.cant_seriales.disabled=f.cant_paralelos.disabled=true;
		}
	if(f.todos_detalle.checked)
		{
			f.procesador.disabled=f.ram.disabled=f.disco_duro.disabled=
			f.cant_seriales.disabled=f.cant_paralelos.disabled=true;
		}if(f.todos_detalle.checked)
		{
			f.procesador.disabled=f.ram.disabled=f.disco_duro.disabled=
			f.cant_seriales.disabled=f.cant_paralelos.disabled=true;
		}if(f.todos_detalle.checked)
		{
			f.procesador.disabled=f.ram.disabled=f.disco_duro.disabled=
			f.cant_seriales.disabled=f.cant_paralelos.disabled=true;
		}if(f.todos_estado.checked)
		{
			f.asignado.disabled=f.debaja.disabled=f.parabaja.disabled=
			f.disponible.disabled=true;
			
		}if(f.asignado.checked)
		{
			f.debaja.disabled=f.parabaja.disabled=
			f.disponible.disabled=true;
			
		}if(f.debaja.checked)
		{
			f.asignado.disabled=f.parabaja.disabled=
			f.disponible.disabled=true;
			
		}if(f.parabaja.checked)
		{
			f.asignado.disabled=f.debaja.disabled=
			f.disponible.disabled=true;
			
		}if(f.disponible.checked)
		{
			f.asignado.disabled=f.debaja.disabled=f.parabaja.disabled= true;
			
		}
	
	}

}
function HabilitarCmb(Opt)
{
	var f=document.frmFiltroListado;

		switch (Opt)
	{
		case "E":
			f.opcion[0].checked = false;
			f.opcion[1].checked = true;
			f.opcion[2].checked = false;
			break;
		case "P":
			f.opcion[0].checked = false;
			f.opcion[1].checked = false;
			f.opcion[2].checked = true;
			
			break;
	}	
	switch(Opt)
	{
		case"E":
		
			if (f.filtro.value =="nro_serie"){
			        f.CmbSerie_P.style.width="0px";f.CmbSerie_P.style.visibility="hidden";
					f.cmbSerie.style.width="150px";f.cmbSerie.style.visibility="";
					f.buscar3.style.width="0px";f.buscar3.style.visibility="hidden";
					f.buscar2.style.width="150px";f.buscar2.style.visibility="";}
			
			
			else{ 
			      if(f.filtro.value=="marca")
			         {
			         f.cmbMarcaP.style.width="0px";f.cmbMarcaP.style.visibility="hidden";
				     f.cmbMarcaE.style.width="150px";f.cmbMarcaE.style.visibility="";
					 } 	
			      else
				     {  
					 f.cmbModeloP.style.width="0px";f.cmbModeloP.style.visibility="hidden";
				     f.cmbModeloE.style.width="250px";f.cmbModeloE.style.visibility="";
					 } 	
                }
			break;
		case"P":
		if (f.filtro.value =="nro_serie"){
					f.CmbSerie_P.style.width="150px";f.CmbSerie_P.style.visibility="";
					f.cmbSerie.style.width="0px";f.cmbSerie.style.visibility="hidden";
					f.buscar3.style.width="150px"; f.buscar3.style.visibility="";
					f.buscar2.style.width="0px"; f.buscar2.style.visibility="hidden";}
		 else  {  
		            if(f.filtro.value=="marca")
			           {
					   f.cmbMarcaE.style.width="0px";f.cmbMarcaE.style.visibility="hidden";
				       f.cmbMarcaP.style.width="150px";f.cmbMarcaP.style.visibility="";             
			           }
                    else
					   {
					    f.cmbModeloE.style.width="0px";f.cmbModeloE.style.visibility="hidden";
				        f.cmbModeloP.style.width="250px";f.cmbModeloP.style.visibility="";             
			           }			
			   }
			return false;
			break;
		default:		
		 return false;
		 break;
	}	
}
</script>
</head>

<body bgcolor="#CCCCCC">
<?php
include("../../principal/conectar_principal.php");
?>
<form name="frmFiltroListado" method="post">
<!---------------------------------- cuerpo de la pagina ------------------------------------->
<table class="TablaPrincipal" cellpadding="0" cellspacing="0" border="0" width="628" align="center">
<tr>
	<td width="626">&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="450" cellspacing="2">
	<tr>
	    <td class="ColorTabla01" align="center"><strong>Filtros de Busqueda</strong></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="center">
		
                <select name="filtro" onChange="mostrar()">
                  <option value="todos" selected>Mostrar Todos</option>
                  <option value="t_equipo">Tipo de Equipo</option>
                  <option value="proveedor">Proveedor</option>
                  <option value="usuario">Usuario</option>
                  <option value="ubi">Ubicaci&oacute;n</option>
                  <option value="detalle_equipo">Detalle de Equipos (CMP O NBK)</option>
                  <option value="codigo">Codigo</option>
                  <option value="marca">Marca</option>
                  <option value="modelo">Modelo</option>
                  <option value="nro_serie">Nro Serie</option>
                  <option value="cod_activo_fijo">Cod Activo Fijo</option>
                </select>
            </td>
	</tr>
	<tr>
            <td ALIGN="CENTER" bordercolor="#999999">
			
                <input name="opcion_p" type="radio" style="visibility:hidden;" value="E" checked onclick=HabilitarCmb('E')>
                <input type="text" name="Nomequipo_s" size="7" value="EQUIPO" style="visibility:hidden ;border:solid 0px "  class="TablaPrincipal"  ;>
                <input name="opcion_p" type="radio" style="visibility:hidden " value="P" onClick=HabilitarCmb('P')>                
                <input type="text" name="Nomparte_s" size="7" value="PARTE" class="TablaPrincipal" style="visibility:hidden ;border:solid 0px " ;>
            </td></tr>
	<tr>
		    <td height="90" align="center" valign="top"> <p> 
                
				<select name="cmbUsuario" style="visibility: 'hidden'; width: 0px;">
                  <option value="RUT" selected>Rut</option>
                  <option value="APELLIDO_PATERNO">Apellido Paterno</option>
                  <option value="APELLIDO_MATERNO">Apellido Materno</option>
                  <option value="NOMBRES">Nombres</option>
                </select>
                <select name="cmbDetalle" style="visibility: 'hidden'; width: 0px;">
                  <option value="procesador" selected>Procesador</option>
                  <option value="ram">Ram</option>
                  <option value="disco_duro">Disco Duro</option>
                  <option value="cant_seriales">Cant. Seriales</option>
                  <option value="cant_paralelos">Cant. Paralelos</option>
                </select>
                <input type="text" name="buscar" maxlength="35" size="30" style="visibility: hidden; width: 0px;">
                <select name="cmbProveedor" style="visibility: 'hidden'; width: 0px;">
                 <option value="0" selected>Seleccione un Proveedor</option>
                  <?php
	                  //se recuperan todos los proveedores
		                $query="select rut,razon_social from proveedor order by (razon_social);";
						$res_tmp=mysql_db_query("cia_web",$query,$link);
						while($r=mysql_fetch_array($res_tmp))
							echo '<option value="'.$r["rut"].'">'.$r["razon_social"].'</option>';
						if(mysql_num_rows($res_tmp))
							mysql_free_result($res_tmp);
						else
							echo '<option value="1">NO HAY PROVEEDORES</option>';
				?>
                </select>
                <select name="cmbUbicacion" style="visibility: 'hidden'; width: 0px;">
                  <option value="0" selected>Seleccione una ubicaci&oacute;n</option>
                  <?php
					//se cargan todos los centros de costo
					$query="select centro_costo,descripcion from centro_costo order by(centro_costo);";
					$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
					while($r=mysql_fetch_array($res_tmp))
						echo '<option value="'.$r["centro_costo"].'">'.$r["centro_costo"].' - '.$r["descripcion"].'</option>';
					if(mysql_num_rows($res_tmp))
						mysql_free_result($res_tmp);
					else
						echo '<option value="1">NO HAY CENTROS DE COSTO</option>';
				?>
                </select>
                <select name="cmbTipo" style="visibility: 'hidden'; width: 0px;">
                  <option value="0" selected>Seleccione un Tipo de Equipo</option>
                  <?php
				//se cargan todos los tipos de hardware
					$query="select nombre_subclase as nom,valor_subclase1 as val from sub_clase where cod_clase=18003 order by(nom);";
					$res_tmp=mysql_db_query("proyecto_modernizacion",$query,$link);
					while($r=mysql_fetch_array($res_tmp))
						echo '<option value="'.$r["val"].'">'.$r["nom"].'</option>';
					if(mysql_num_rows($res_tmp))
						mysql_free_result($res_tmp);
					else
						echo '<option value="1">NO HAY TIPOS DE HW REGISTRADOS</option>';
	  			?>
                </select>
                <select name="cmbMarcaE" style="visibility: 'hidden'; width: 0px;">
                  <option value="0" selected>Seleccione una Marca</option>
                  <?php
				//se cargan todos los tipos de hardware
					$query="select distinct(marca) from hardware where marca <> '' and tipo='EQUIPO' order by(marca)";
					$res_tmp=mysql_db_query("cia_web",$query,$link);
					while($r=mysql_fetch_array($res_tmp))
						echo '<option value="'.$r["marca"].'">'.$r["marca"].'</option>';
					if(mysql_num_rows($res_tmp))
						mysql_free_result($res_tmp);
					else
						echo '<option value="1">NO HAY MARCAS</option>';
	  			?>
                </select>
                <select name="cmbMarcaP" style="visibility: 'hidden'; width: 0px;">
                  <option value="0" selected>Seleccione una Marca</option>
                  <?php
				//se cargan todos los tipos de hardware
					$query="select distinct(marca) from hardware where marca <> '' and tipo='PARTE' order by(marca)";
					$res_tmp=mysql_db_query("cia_web",$query,$link);
					while($r=mysql_fetch_array($res_tmp))
						echo '<option value="'.$r["marca"].'">'.$r["marca"].'</option>';
					if(mysql_num_rows($res_tmp))
						mysql_free_result($res_tmp);
					else
						echo '<option value="1">NO HAY MARCAS</option>';
	  			?>
                </select>
                <select name="cmbModeloE" style="visibility: 'hidden'; width: 0px;">
                  <option value="seleccione" selected>Seleccione un Modelo</option>
                  <?php
				//se cargan todos los tipos de hardware
					$query="select distinct(marca),modelo from hardware where modelo <> '' and tipo='EQUIPO' order by marca";
					$res_tmp=mysql_db_query("cia_web",$query,$link);
					while($r=mysql_fetch_array($res_tmp))
					echo '<option value="'.$r["modelo"].'">'.$r["marca"].' - '.$r["modelo"].'</option>';
					if(mysql_num_rows($res_tmp))
						mysql_free_result($res_tmp);
					else
						echo '<option value="1">NO HAY MODELO</option>';
	  			?>
                </select>
                <select name="cmbModeloP" style="visibility: 'hidden'; width: 0px;">
                  <option value="seleccione" selected>Seleccione un Modelo</option>
                  <?php
				//se cargan todos los tipos de hardware
					$query="select distinct(marca),modelo from hardware where modelo <> '' and tipo='PARTE' order by marca";
					$res_tmp=mysql_db_query("cia_web",$query,$link);
					while($r=mysql_fetch_array($res_tmp))
						echo '<option value="'.$r["modelo"].'">'.$r["marca"].' - '.$r["modelo"].'</option>';
						//'<option value="'.$r["modelo"].'">''</option>';
					if(mysql_num_rows($res_tmp))
						mysql_free_result($res_tmp);
					else
						echo '<option value="1">NO HAY MODELO</option>';
			    ?>
                </select>
                <select name="CmbSerie_P" style="visibility: 'hidden'; width: 0px;">
                  <option value="0" selected>N° de Serie por Parte</option>
                  <?php
					$query="select distinct nro_serie from cia_web.hardware where tipo='PARTE' and nro_serie <> '' order by nro_serie";
					$result=mysql_query($query);
					while($resp=mysql_fetch_array($result))
						echo '<option value="'.$resp["nro_serie"].'">'.$resp["nro_serie"].'</option>';
					mysql_free_result($result);
				?>
                </select>
                <input type="text" name="buscar3" maxlength="10" size="10" style="visibility: hidden; width: 0px;">
                <select name="cmbSerie" style="visibility: 'hidden'; width: 0px;">
                  <option value="0" selected>N° de Serie por Equipo</option>
                  <?php
					$query="select distinct nro_serie from cia_web.hardware where tipo='EQUIPO' and nro_serie <> '' order by nro_serie";
					$result=mysql_query($query);
					while($resp=mysql_fetch_array($result))
						echo '<option value="'.$resp["nro_serie"].'">'.$resp["nro_serie"].'</option>';
					mysql_free_result($result);
				?>
                </select>
                <input type="text" name="buscar2" maxlength="10" size="10" style="visibility: hidden; width: 0px;">
              </p>
                <p> 
                <input type="radio" name="opcion" value="all" style="visibility: '';">
                <input type="text" name="NomTodos" size="7" value="TODOS" class="TablaPrincipal" style="border:solid 0px " ;>
                <input type="radio" name="opcion" value="EQUIPO" style="visibility: '';">
                <input type="text" name="NomEquipo" size="7" value="EQUIPO" class="TablaPrincipal" style="border:solid 0px " ; >
                <input type="radio" name="opcion" value="PARTE" style="visibility: '';">
                <input type="text" name="NomParte" size="7" value="PARTE" class="TablaPrincipal" style="border:solid 0px  "; >
                </p>
				</td>
	</tr>
 	</table>


<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>
	<table border="0" class="TablaInterior" align="center" width="595" cellspacing="2">
	<tr>
	    <td width="586" align="center" class="ColorTabla01"><strong>Datos a Mostrar</strong></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td align="center">
		<table width="540" align="center" border="0" cellpadding="0" cellspacing="2">
		<tr>
			<td  align="center" style="border:solid 1px #666666; color: #0000cc;" bgcolor="#CCCCCC">Equipos</td>
			<td  align="center" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC">Proveedor</td>
			<td  align="center" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC">Usuario</td>
			<td align="center" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC">Detalle Equipos</td>
			<td align="center" style="border:solid 1px #666666; color: #0000CC;" bgcolor="#CCCCCC">Estado</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="codigo">Codigo</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="rut_p">Rut</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="rut_u">Rut</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="procesador">Procesador</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="asignado" onClick=" ver_todos(6)">Asignado</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="tipo">Tipo</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="razon_social">Raz&oacute;n Social</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="nombres">Nombres</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="ram">Ram</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="parabaja" onClick="ver_todos(7)">Para Baja</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="marca">Marca</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="nombre_fantasia">Nombre Fantasia</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="apellido_paterno">Apellido Paterno</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="disco_duro">Disco Duro</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="debaja" onClick="ver_todos(8)">De Baja</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="modelo">Modelo</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="contacto_1">Contacto 1</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="apellido_materno">Apellido Materno</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="cant_seriales">Cant. Seriales</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="disponible" onClick="ver_todos(9)">Disponible</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="nro_serie">Nro Serie</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="contacto_2">Contacto 2</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="cc_user">Centro de Costo</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="cant_paralelos">Cant. Paralelos</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="fecha_compra">Fecha Compra</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="fono_1">Fono 1</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="nro_factura">Nro Factura</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="fono_2">Fono 2</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="nro_guia">Nro Guia</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="fax">Fax</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="cod_activo_fijo">Cod Activo Fijo</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="observaciones">Observaciones</td>
			      <td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="p_garantia">Per. Garantia</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="ubi">Ubicaci&oacute;n</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
		</tr>
		<tr>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
			<td align="left">&nbsp;</td>
		</tr>
		<tr>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="todos_equipos" onClick="ver_todos(1)">
                    Ver Todos</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="todos_proveedor" onClick="ver_todos(2)">Ver Todos</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="todos_usuario" onClick="ver_todos(3)">Ver Todos</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="todos_detalle" onClick="ver_todos(4)">Ver Todos</td>
			<td align="left" style="border:solid 1px #666666;"><input type="checkbox" name="todos_estado" onClick="ver_todos(5)">Ver Todos</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	</table>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr>
	<td align="center">
	<input type="button" name="Ver" value="Ver" style="width: 80px;" onClick="ver()">
	&nbsp;&nbsp;&nbsp;
	<input type="button" name="Cerrar" value="Cerrar" style="width: 80px;" onClick="javascript: window.close();">
	</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>

</form>
</body>
</html>
