﻿<?php 
	//include("../principal/conectar_sec_web.php");
	require("../principal/conectar_index.php");
	include("funciones_interfaces_codelco.php");
	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 7;
	//$REMOTE_ADDR  = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$IP          = getenv("REMOTE_ADDR");
	$movimientos = array(1=>"RECEPCION", 2=> "PRODUCCION", 3=> "PAQUETE");
	$productos = array(18=>"CATODOS", 64=> "SALES", 48=> "DESPUNTES Y LAMINAS", 57=> "BARROS REFINERIA", 66=> "OTROS PESAJES", 19=> "RESTOS ANODOS", 17=> "ANODOS");
	//echo "SA__uno__".$SA_C_STD2."<br>";	
	//echo $tipo_ie;	
	$accion      = isset($_REQUEST["accion"])?$_REQUEST["accion"]:"";
	$opcion      = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$SA_C_STD    = isset($_REQUEST["SA_C_STD"])?$_REQUEST["SA_C_STD"]:"";
	$SA_C_STD2   = isset($_REQUEST["SA_C_STD2"])?$_REQUEST["SA_C_STD2"]:"";
	
	$encontro_ie    = isset($_REQUEST["encontro_ie"])?$_REQUEST["encontro_ie"]:"";
	$activa_sipa    = isset($_REQUEST["activa_sipa"])?$_REQUEST["activa_sipa"]:"";
	$mensaje        = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
	
	$recargapag1 = isset($_REQUEST["recargapag1"])?$_REQUEST["recargapag1"]:"";
	$recargapag2 = isset($_REQUEST["recargapag2"])?$_REQUEST["recargapag2"]:"";
	$recargapag3 = isset($_REQUEST["recargapag3"])?$_REQUEST["recargapag3"]:"";
	$recargapag4 = isset($_REQUEST["recargapag4"])?$_REQUEST["recargapag4"]:"";
	$recargapag5 = isset($_REQUEST["recargapag5"])?$_REQUEST["recargapag5"]:"";
	$cmbmovimiento  = isset($_REQUEST["cmbmovimiento"])?$_REQUEST["cmbmovimiento"]:"";
	$cmbproducto    = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"";
	$cmbsubproducto = isset($_REQUEST["cmbsubproducto"])?$_REQUEST["cmbsubproducto"]:"";
	$peso_auto   = isset($_REQUEST["peso_auto"])?$_REQUEST["peso_auto"]:"";
	$mostrar     = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	
	$ano    = isset($_REQUEST["ano"])?$_REQUEST["ano"]:"";
	$mes    = isset($_REQUEST["mes"])?$_REQUEST["mes"]:"";
	$dia    = isset($_REQUEST["dia"])?$_REQUEST["dia"]:"";
	$hh     = isset($_REQUEST["hh"])?$_REQUEST["hh"]:"";
	$mm     = isset($_REQUEST["mm"])?$_REQUEST["mm"]:"";
	$ano2   = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:"";
	$mes2   = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:"";
	$dia2   = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:"";
	
	$cmbinstruccion = isset($_REQUEST["cmbinstruccion"])?$_REQUEST["cmbinstruccion"]:"";
	$paq_inicial    = isset($_REQUEST["paq_inicial"])?$_REQUEST["paq_inicial"]:"";
	$agrega_paq     = isset($_REQUEST["agrega_paq"])?$_REQUEST["agrega_paq"]:"";
	$txtpesoprog   = isset($_REQUEST["txtpesoprog"])?$_REQUEST["txtpesoprog"]:"";
	$txtnumlote    = isset($_REQUEST["txtnumlote"])?$_REQUEST["txtnumlote"]:"";
	$txtnumpaq     = isset($_REQUEST["txtnumpaq"])?$_REQUEST["txtnumpaq"]:"";
	$cmbcodpaq     = isset($_REQUEST["cmbcodpaq"])?$_REQUEST["cmbcodpaq"]:"";
	$tipo_ie        = isset($_REQUEST["tipo_ie"])?$_REQUEST["tipo_ie"]:"";
	$genera_lote    = isset($_REQUEST["genera_lote"])?$_REQUEST["genera_lote"]:"";
	$peso_prog_ok   = isset($_REQUEST["peso_prog_ok"])?$_REQUEST["peso_prog_ok"]:"";
	$cmbcodlote = isset($_REQUEST["cmbcodlote"])?$_REQUEST["cmbcodlote"]:"";
	$listar_ie  = isset($_REQUEST["listar_ie"])?$_REQUEST["listar_ie"]:"";
	$tipo_reg   = isset($_REQUEST["tipo_reg"])?$_REQUEST["tipo_reg"]:"";
	$txtlote    = isset($_REQUEST["txtlote"])?$_REQUEST["txtlote"]:"";
	$txtrecargo = isset($_REQUEST["txtrecargo"])?$_REQUEST["txtrecargo"]:"";
	$existe_sec = isset($_REQUEST["existe_sec"])?$_REQUEST["existe_sec"]:"";
	$existe_rec = isset($_REQUEST["existe_rec"])?$_REQUEST["existe_rec"]:"";
	$fecha_pesaje_lodo  = isset($_REQUEST["fecha_pesaje_lodo"])?$_REQUEST["fecha_pesaje_lodo"]:"";
	$hora_aux           = isset($_REQUEST["hora_aux"])?$_REQUEST["hora_aux"]:"";
	$txtunidades    = isset($_REQUEST["txtunidades"])?$_REQUEST["txtunidades"]:"";
	$txtpesobolsa  = isset($_REQUEST["txtpesobolsa"])?$_REQUEST["txtpesobolsa"]:"";
	$txtpesotara   = isset($_REQUEST["txtpesotara"])?$_REQUEST["txtpesotara"]:"";
	$txtpesoneto   = isset($_REQUEST["txtpesoneto"])?$_REQUEST["txtpesoneto"]:"";
	$txtpeso       = isset($_REQUEST["txtpeso"])?$_REQUEST["txtpeso"]:"";
	$txtcuba       = isset($_REQUEST["txtcuba"])?$_REQUEST["txtcuba"]:"";
	$txtguia       = isset($_REQUEST["txtguia"])?$_REQUEST["txtguia"]:"";
	$txtpatente    = isset($_REQUEST["txtpatente"])?$_REQUEST["txtpatente"]:"";
	$txtorigen     = isset($_REQUEST["txtorigen"])?$_REQUEST["txtorigen"]:"";
	$txtrut        = isset($_REQUEST["txtrut"])?$_REQUEST["txtrut"]:"";
	$txtmarca      = isset($_REQUEST["txtmarca"])?$_REQUEST["txtmarca"]:"";
	$txtzuncho     = isset($_REQUEST["txtzuncho"])?$_REQUEST["txtzuncho"]:0;
	$txtpaquete    = isset($_REQUEST["txtpaquete"])?$_REQUEST["txtpaquete"]:0;
	$txtmuestra    = isset($_REQUEST["txtmuestra"])?$_REQUEST["txtmuestra"]:"";
    $txtgrupo      = isset($_REQUEST["txtgrupo"])?$_REQUEST["txtgrupo"]:"";
	$cmbmedida     = isset($_REQUEST["cmbmedida"])?$_REQUEST["cmbmedida"]:"";
	$fecha_aux     = isset($_REQUEST["fecha_aux"])?$_REQUEST["fecha_aux"]:"";
	$txtlado       = isset($_REQUEST["txtlado"])?$_REQUEST["txtlado"]:"";
	
	$id_paquete    = isset($_REQUEST["id_paquete"])?$_REQUEST["id_paquete"]:"";
	$id_lote       = isset($_REQUEST["id_lote"])?$_REQUEST["id_lote"]:"";
	$leyes_grupo   = isset($_REQUEST["leyes_grupo"])?$_REQUEST["leyes_grupo"]:"";
	$NroSA         = isset($_REQUEST["NroSA"])?$_REQUEST["NroSA"]:"";    
	$from	   = isset($_REQUEST["from"])?$_REQUEST["from"]:"";
	$pesotara  = isset($_REQUEST["pesotara"])?$_REQUEST["pesotara"]:"";
	$pesoneto  = isset($_REQUEST["pesoneto"])?$_REQUEST["pesoneto"]:"";	
	$codlote   = isset($_REQUEST["codlote"])?$_REQUEST["codlote"]:"";
	$numlote   = isset($_REQUEST["numlote"])?$_REQUEST["numlote"]:"";
	$codpaq    = isset($_REQUEST["codpaq"])?$_REQUEST["codpaq"]:"";
	$numpaq    = isset($_REQUEST["numpaq"])?$_REQUEST["numpaq"]:"";
	$marca       = isset($_REQUEST["marca"])?$_REQUEST["marca"]:"";
	$instruccion = isset($_REQUEST["instruccion"])?$_REQUEST["instruccion"]:"";
	$pesoprog    = isset($_REQUEST["pesoprog"])?$_REQUEST["pesoprog"]:"";
	$grupo       = isset($_REQUEST["grupo"])?$_REQUEST["grupo"]:"";
	$unidades    = isset($_REQUEST["unidades"])?$_REQUEST["unidades"]:"";
	$peso        = isset($_REQUEST["peso"])?$_REQUEST["peso"]:"";
	$cuba        = isset($_REQUEST["cuba"])?$_REQUEST["cuba"]:"";
	$etapa       = isset($_REQUEST["etapa"])?$_REQUEST["etapa"]:"";
	$medida      = isset($_REQUEST["medida"])?$_REQUEST["medida"]:"";
    $codigopaquete = isset($_REQUEST["codigopaquete"])?$_REQUEST["codigopaquete"]:"";

echo "IP: ".$IP; 

$ROMANA = LeerRomana($IP,$link); 

echo "<br>ROMANA: ".$ROMANA;
/*
$numero = 2;
$fecha = DateTime::createFromFormat('!m', $numero);
$mes = $fecha->format('F'); 

$ultimoDia = mktime(0, 0, 0, $numero, 0, date("Y"));
$ultDia = date('d', $ultimoDia);
echo '<br>Last day in '.$mes.' '.date("Y").' is: ', $ultDia;
*/
?>

<html>
<head>
<title>Ingreso Pesaje Producción</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../principal/funciones/funciones_java.js" language="javascript"></script>
<script language="JavaScript">

let valor22;
//valor22 = setInterval(CapturaPeso,1000);
//console.log(valor22);

function str_pad (input, pad_length, pad_string, pad_type) {
    // Returns input string padded on the left or right to specified length with pad_string  
    // 
    // version: 1103.1210
    // discuss at: http://phpjs.org/functions/str_pad    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + namespaced by: Michael White (http://getsprink.com)
    // +      input by: Marco van Oort
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: str_pad('Kevin van Zonneveld', 30, '-=', 'STR_PAD_LEFT');    // *     returns 1: '-=-=-=-=-=-Kevin van Zonneveld'
    // *     example 2: str_pad('Kevin van Zonneveld', 30, '-', 'STR_PAD_BOTH');
    // *     returns 2: '------Kevin van Zonneveld-----'
    var half = '',
        pad_to_go; 
    var str_pad_repeater = function (s, len) {
        var collect = '',
            i;
         while (collect.length < len) {
            collect += s;
        }
        collect = collect.substr(0, len);
         return collect;
    };
 
    input += '';
    pad_string = pad_string !== undefined ? pad_string : ' '; 
    if (pad_type != 'STR_PAD_LEFT' && pad_type != 'STR_PAD_RIGHT' && pad_type != 'STR_PAD_BOTH') {
        pad_type = 'STR_PAD_RIGHT';
    }
    if ((pad_to_go = pad_length - input.length) > 0) {        if (pad_type == 'STR_PAD_LEFT') {
            input = str_pad_repeater(pad_string, pad_to_go) + input;
        } else if (pad_type == 'STR_PAD_RIGHT') {
            input = input + str_pad_repeater(pad_string, pad_to_go);
        } else if (pad_type == 'STR_PAD_BOTH') {            half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
            input = half + input + half;
            input = input.substr(0, pad_length);
        }
    } 
    return input;
}
function PesoAutomatico()
 {
	setTimeout("CapturaPeso()",500);
}	
/*****************/
function CapturaPeso()
{
	var f = document.frm1;	
	var Romana    = f.TxtNumRomana.value;  //Romana seleccionada
	var Carpeta   = 'configuracion_pesaje'; //Carpeta de los PesoMatic
	var PesoMatic = 'PesoMatic_'+Romana+'.txt'; //creamos el nombre del archivo PesoMatic segun la Romana seleccionada
	var Peso  =0;
	var VPeso =0;
	if($("#checkpeso").length != 0) {
		VPeso = f.txtpeso.value;
		if (f.checkpeso.checked == true)
		{  	//f.txtpeso.value = LeerArchivo(f.txtpeso.value);
			console.log("Romana:"+Romana);
			console.log("Carpeta:"+Carpeta);
			console.log("PesoMatic:"+PesoMatic);
			console.log("VPeso:"+VPeso);		
			Peso  = LeerArchivo(Carpeta,PesoMatic,VPeso);
			f.txtpeso.value = Peso;
		}else{
			f.txtpeso.value = VPeso;
		}
		setTimeout("CapturaPeso()",200);	
	}else{
		f.txtpeso.value = VPeso;
	}
	
	//setInterval(CapturaPeso,200);
}
/****************/
function Recarga1()
{
	var f = document.frm1;
	
	if (f.cmbmovimiento.value == -1)
		f.action = "sec_ing_produccion.php";
	else 
		f.action = "sec_ing_produccion.php?recargapag1=S";
		
	f.submit();
}
/***************/
function Recarga2()
{
	var f = document.frm1;
	
	if (f.cmbproducto.value == -1)
		linea = "recargapag1=S";
	else
		linea = "recargapag1=S&recargapag2=S";

	linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto="	+ f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	document.location = "sec_ing_produccion.php?" + linea;
			
//	f.action = "sec_ing_produccion.php?" + linea;
//	f.submit();	
}
/*****************/
function Recarga3()
{	
	var f = document.frm1;
	
	if (f.cmbsubproducto.value == -1)
		linea = "recargapag1=S&recargapag2=S";
	else
		linea = "recargapag1=S&recargapag2=S&recargapag3=S&peso_auto=checked";
	
	linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto="	+ f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	document.location = "sec_ing_produccion.php?" + linea;
// 	f.action = "sec_ing_produccion.php?" + linea;
//	f.submit();
}
/****************/
function RecargaSipa()
{
	var f = document.frm1;
	var vector = f.cmbsipa.value.split('~'); //0:fecha, 1:hora, 2:patente, 3:psso.
	
	if (f.cmbsipa.value == -1)
		f.txtpeso.value = ""
	else
		f.txtpeso.value = vector[3];
}
/****************/
function AjustarPeso()
{

	var f = document.frm1;
	
	if (f.agrega_paq.value != "S")
	{
		alert("La I.E. No Tiene Paquetes Pesados");
		return;
	}
	
	if (confirm("Esta Seguro De Ajustar El Peso De La I.E."))
	{	
		linea = 'cmbcodlote=' + f.cmbcodlote.value + '&txtnumlote=' + f.txtnumlote.value; 
		linea = linea + '';
		
	
		f.action = "sec_ing_produccion01.php?proceso=B12";
		f.submit();
	}
}
function numDias(d,m,a)
{  
	m = (m + 9) % 12; 
 	a = a - Math.floor(m/10); 
 	return 365*a+Math.floor(a/4)-Math.floor(a/100)+Math.floor(a/400)+Math.floor((m*306+5)/10)+d-1 
}
 
function difDias(d1,m1,a1,d2,m2,a2)
{  

dia1=numDias(d2,m2,a2);
dia2=numDias(d1,m1,a1);

Total=(dia1-dia2);

return (Total)
}


function CalculaDias(FechaInicio,FechaTermino)
{
	Matriz1= FechaInicio.split("/");
	Matriz2= FechaTermino.split("/");
	dia=parseFloat(Matriz1[0]);//dias
	mes=parseFloat(Matriz1[1]);//mes
	ano=parseFloat(Matriz1[2]);//año
	dia2=parseFloat(Matriz2[0]);//dias
	mes2=parseFloat(Matriz2[1]);//mes
	ano2=parseFloat(Matriz2[2]);//año
	var Dif=0;
	F1=numDias(dia,mes,ano)
	F2=numDias(dia2,mes2,ano2)
	//alert(dia+","+mes+","+ano+" = "+F1)
	//alert(dia2+","+mes2+","+ano2+" = "+F2)
	Dif=(F2-F1)
	return(Dif)
}/****************/

/****************/
function ValidaCampos()
{
	var f = document.frm1;
	fa='<?php echo date('d/m/Y');?>';
	fe=f.dia.value+"/"+f.mes.value+"/"+f.ano.value;
	dif=CalculaDias(fa,fe);
	if(dif>=1)
	{
		alert("La Fecha de Pesaje, No puede ser mayor a la actual");
		return false;
	}
	if (f.cmbmovimiento.value == -1)
	{
		alert("Debe Seleccionar el Tipo de Movimiento");
		return false;
	}
	
	if (f.cmbproducto.value == -1)
	{
		alert("Debe Seleccionar el Producto");
		return false;
	}
	
	if (f.cmbsubproducto.value == -1)
	{
		alert("Debe Seleccionar el Sub-Producto");
		return false;
	}
	
	if (f.cmbmovimiento.value == 1)
	{
		if (ValidaCampos1() == false)
			return false;
	}
	
	if (f.cmbmovimiento.value == 2)
	{
		if (ValidaCampos2() == false)
			return false;
	}
	
	if (f.cmbmovimiento.value == 3)		
	{
		if (ValidaCampos3() == false)
			return false;
	}
		
	return true;
}
/***************/
function ValidaCampos1() //Para Recepcion.
{
	var f = document.frm1;
	
	if (f.txtlote.value == "")
	{
		alert("Debe Ingresar El Lote");
		return false;
	}	
	
	if (f.existe_rec.value == "N")
	{
		alert("Debe Buscar El Lote");
		return false;
	}
	
	if (f.existe_sec.value == "N")
	{
		if (f.txtpaquete.value == "")
		{	
			alert("Debe Ingresar El Nº de Paquetes");
			return false;
		}
		
		if (f.txtzuncho.value == "")
		{
			alert("Debe Ingresar El Peso Zuncho");
			return false;
		}
	}
	
	if (f.existe_sec.value == "S")
	{
		if (f.cmbinstruccion.value == -1)
		{	
			alert("Debe Seleccionar I.E.");
			return false;
		}		
		
		if (f.txtnumlote.value == "")
		{
			alert("Debe Ingresar Lote Inicial");
			return false;
		}
		
		if (f.cmbcodpaq.value == -1)
		{	
			alert("Debe Seleccionar El Codigo de Serie");
			return false;
		}
			
		if (f.txtnumpaq.value == "")
		{	
			alert("El Nº de Serie No Es Valido");
			return false;
		}
		
		if (f.txtunidades.value == "")
		{
			alert("Debe Ingresar Las Unidades");
			return false;
		}
		
		if (f.txtmarca.value == "")
		{
			alert("Debe Ingresar La Marca");
			return false;
		}
	
		
		if (f.txtpeso.value == "")
		{
			alert("Debe Ingresar El Peso Producto");
			return false;
		}
	}
	//return false;
	return true;
}
/***************/
function ValidaCampos2() //Para Produccion.
{
	var f = document.frm1;
	
	if ((f.cmbproducto.value != 57) && (f.cmbproducto.value != 64) && (f.cmbproducto.value != 66) && !(f.cmbproducto.value == 48 && (f.cmbsubproducto.value == 8 || f.cmbsubproducto.value == 9 || f.cmbsubproducto.value == 3 || f.cmbsubproducto.value == 6 || f.cmbsubproducto.value == 10)))
	{
		if (f.txtgrupo.value == "")
		{
			alert("Debe Ingresar El Grupo");
			f.txtgrupo.focus();
			return false;
		}				
	}
	
	if (f.cmbproducto.value == 48)
	{
		/*
		if (f.cmbsubproducto.value == 1) //Despuntes y Laminas.
		{
			if ((f.txtgrupo.value != '01') && (f.txtgrupo.value != '02'))
			{
				alert("El Grupo Ingresado No Corresponde Al Producto");
				f.txtgrupo.focus();
				return false;
			}
		}
		*/
		if (f.cmbsubproducto.value == 2) //Despuntes Orejas.
		{	
			if ((!((f.txtgrupo.value >= 'A') && (f.txtgrupo.value <= 'M'))) || (f.txtgrupo.value == 'K'))
			{
				alert("Letra Del Mes No Valida");
				f.txtgrupo.focus();
				return;
			}			
			
		}
		/*
		if (f.cmbsubproducto.value == 6)
		{
			if (f.txtgrupo.value != '04')
			{
				alert("El Grupo Ingresado No Corresponde Al Producto");
				f.txtgrupo.focus();				
				return false;			
			}
		}
		*/
	}
	
	if (f.cmbproducto.value == 18)
	{
		if (f.txtmuestra.value == "N")
		{
			if (f.txtcuba.value == "")
			{
				alert("Debe Ingresar la Cuba");
				f.txtcuba.focus();
				return false;		
			}	
			
			if (f.txtlado.value == "")
			{
				alert("Debe Ingresar el Lado");
				f.txtlado.focus();
				return false;
			}		
		}
		
		if (f.txtmuestra.value == "")
		{
			alert("Debe Ingresar la Muestra");
			f.txtmuestra.focus();
			return false;
		}	
	}
	
	if ((f.cmbproducto.value == 57) || (f.cmbproducto.value == 66))
	{
		if (isNaN(parseInt(f.txtpesotara.value)))
		{
			alert("El Peso Tara No Es Valido");
			f.txtpesotara.focus();
			return false;
		}
	}		
		
	if (isNaN(parseInt(f.txtpeso.value)))
	{
		alert("El Peso Ingresado No Es Valido");
		f.txtpeso.focus();
		return false;
	}
	
	return true;
}
/***************/
function ValidaCampos3() //Para Paquete.
{
	var f = document.frm1;	

	//-------AGREGADO POR RENE-------
	if (f.cmbmovimiento.value == 3)
	{
		if(f.PregSA.value=='S')
		{			
			if(f.SA_C_STD.value=='')
			{	
             	alert('MF Va a VALIDAR analisis 3');
				alert('Debe Ingresar Solicitud Analisis.')
				f.SA_C_STD.focus();
				return false;
			}
		}	
	}
	if (f.cmbinstruccion.value == -1)
	{	
		alert("Debe Seleccionar I.E.");
		return false;
	}

	if (f.txtnumlote.value == "")
	{
		alert("Debe Ingresar Lote Inicial");
		return false;
	}

	if (f.txtmarca.value == "")
	{	
		alert("Debe Ingresar La Marca");
		return false;
	}	

	if (f.cmbcodpaq.value == -1)
	{	
		alert("Debe Selecionar el Codigo de Serie");
		return false;
	}
	
	if (f.txtnumpaq.value == "")
	{	
		alert("Debe Ingresar el N° de Serie");
		return false;
	}
	
	if (isNaN(parseInt(f.txtnumpaq.value)))
	{
		alert("El N° de Serie No Es Valido");
		return false;
	}			
	/*var FechaValPeso = new Date();
	var MesActual=FechaValPeso.getMonth()+1;
	if(f.cmbcodlote.value != MesActual)
	{
		alert('Codigo del Lote no pertenece al mes');
		return false;
	}
	if(f.cmbcodpaq.value!=MesActual)
	{
		alert('Codigo del Paquete no pertenece al mes');
		return false;
	}*/
		
	if (f.cmbproducto.value == 18)
	{
        if ((f.cmbsubproducto.value != 42) && (f.cmbsubproducto.value != 43) && (f.cmbsubproducto.value != 44))
        {
		    if (f.txtgrupo.value == "")
		    {
			   alert("Debe Ingresar El Grupo");
			   return false;
		    }
        }
		/*if ((f.cmbsubproducto.value == 42) || (f.cmbsubproducto.value == 43) || (f.cmbsubproducto == 44))
		{
			if (f.txtcuba.value == "")
			{
				alert("Debe Ingresar la Cuba");
				return false;
			}
		}*/
        if ((f.cmbsubproducto.value != 42) && (f.cmbsubproducto.value != 43) && (f.cmbsubproducto.value != 44))
        {
		    if (f.txtcuba.value >= 80)
		    {
		 	    alert("Suficientes Paquetes Para El Grupo");
			    return false;
		    }
		}
		if (f.txtunidades.value == "")
		{
			alert("Debe Ingresar Las Unidades");
			return false;
		}		
	}
	
	if (f.cmbproducto.value == 57)	
	{
		if (f.txtunidades.value == "")
		{
			alert("Debe Ingresar La Cantidad De Bolsas");
			return false;
		}
		
		if (f.txtpesotara.value == "")
		{
			alert("Debe Ingrsar El Peso De La Tara");
			return false;
		}
		
		if (f.txtpesoneto.value == "")
		{
			alert("Debe Ingresar el Peso Neto");
			return false;
		}
	}
	
	if (f.cmbproducto.value == 64 /*&& (f.cmbsubproducto.value == 8 || f.cmbsubproducto.value == 7)*/)
	{	
		if (f.cmbmedida.value == -1)
		{
			alert("Debe Selecionar La Unidad De Medida")
			return false;
		}
	}
	

	if (f.txtpeso.value == "")
	{
		alert("Debe Ingresar el Peso");
		return false;		
	}
	
	if (isNaN(parseInt(f.txtpeso.value)))
	{
		alert("El Peso Ingresado No Es Valido");
		return false;
	}	
}
/***************/
function ValidaLote()
{	
	var f = document.frm1;
		
	if (f.tipo_ie.value == "V")
	{
		if (f.peso_prog_ok.value != "S")
		{
			alert("Debe Ingresar Peso Programado");
			f.txtnumlote.value = "";
			return false;
		}
	}	

/*
	if (f.tipo_ie.value == "P")
	{
		if (f.encontro_ie.value == "S")
		{	
			alert("El Lote Ya Existe");
			return;
		}	
	}
*/	
		
	if (f.txtnumlote.value == "")
	{	
		alert("Debe Ingresar El Lote Inicial");
		return false;
	}
	
	if ((f.pesoacumulado.value != "") && (f.pesoacumulado.value != 0))
		return;
	
	linea = '';
	if (f.radio[0].checked == true)
		linea = "&listar_ie=P";
	else if (f.radio[1].checked == true)	
			linea = "&listar_ie=V";	
	
	if (f.checkpeso.checked == true)
		linea = linea + "&peso_auto=checked";
	else 
		linea = linea + "&peso_auto=";
	
	if (f.cmbmovimiento.value == 3)
	{
		if(f.cmbsubproducto.value =='16' || f.cmbsubproducto.value =='17' || f.cmbsubproducto.value =='49')
			f.action = "sec_ing_produccion01.php?proceso=B8" + linea+"&NroSolAnalisis="+f.SA_C_STD.value;
		else
			f.action = "sec_ing_produccion01.php?proceso=B8" + linea;
	}
	else
		f.action = "sec_ing_produccion01.php?proceso=B8" + linea;
	f.submit();
}
/***************/
function CreaVirtual()
{
	var f = document.frm1;

	linea = '';
	if (f.checkpeso.checked == true)
		linea = linea + "&peso_auto=checked";
	else 
		linea = linea + "&peso_auto=";	
	
	f.action = "sec_ing_produccion01.php?proceso=V" + linea;
	f.submit();	
}
function AgregaPeso()
{
	var f = document.frm1;

	linea = '';
	if (f.radio[0].checked == true)
		linea = "&listar_ie=P";
	else if (f.radio[1].checked == true)	
			linea = "&listar_ie=V";	

	if (f.checkpeso.checked == true)
		linea = linea + "&peso_auto=checked";
	else 
		linea = linea + "&peso_auto=";
	if(f.cmbmovimiento.value == 3)
	{
		if(f.cmbsubproducto.value =='16' || f.cmbsubproducto.value =='17' || f.cmbsubproducto.value =='49')
			f.action = "sec_ing_produccion01.php?proceso=AP&SA_C_STD="+f.SA_C_STD.value+ linea;
		else
			f.action = "sec_ing_produccion01.php?proceso=AP"+ linea;
	}
	else
		f.action = "sec_ing_produccion01.php?proceso=AP"+ linea;
	f.submit();	
}
/***************/
function CalculaPromedio()
{	
	var f = document.frm1;
	
	if (f.txtcantidad.value != "")	
	{
	 	f.txtpromedio.value = Math.round((f.pesofaltante.value / f.txtcantidad.value));
	}
}
/***************/
function Bloquea2()
{
	var f = document.frm1;
	
	if (f.txtmuestra.value == "S")
	{
		f.txtcuba.disabled = true;
		f.txtlado.disabled = true;
	}
	else 
	{
		f.txtcuba.disabled = false;
		f.txtlado.disabled = false;	
	}
}
/***************/
function Bloquea3()
{
	var f = document.frm1;
	
	if (f.cmbmovimiento.value == 1)
	{
		if (f.cmbproducto.value == 18)
		{	
			if (f.pantalla.value == "P")
			{
				f.radio[0].disabled = true;
				f.radio[1].disabled = true;			
				f.btnok2.disabled = true;
				f.txtpesoprog.disabled = true;
				f.Button.disabled = true;
				f.txtmarca.disabled = true;
				f.cmbcodlote.disabled = true;
				f.txtnumlote.disabled = true;	
				f.cmbcodpaq.disabled = true;
				f.txtnumpaq.disabled = true;
			}
		}
	}
	
	if (f.cmbmovimiento.value == 3)
	{	
		if (f.cmbproducto.value == 18)
		{	
			f.dia.disabled=true;
			f.mes.disabled=true;
			f.ano.disabled=true;
			f.hh.disabled=true;
			f.mm.disabled=true;
		
			f.radio[0].disabled = true;
			f.radio[1].disabled = true;
			f.btnok2.disabled = true;
			f.txtpesoprog.disabled = true;
			f.Button.disabled = true;
			f.txtmarca.disabled = true;
			f.cmbcodlote.disabled = true;
			f.txtnumlote.disabled = true;
			f.cmbcodpaq.disabled = true;
			f.txtnumpaq.disabled = true;
			
			if ((f.cmbsubproducto.value != 42) && (f.cmbsubproducto.value != 43) && (f.cmbsubproducto.value != 44))
			{
				f.txtgrupo.disabled = true;
				f.txtcuba.disabled = true;
			}
		}
	}
}
/***************/
function Grabar()
{
	var f = document.frm1;	
	var StrPaquetePeso='';
	if (f.cmbproducto.value==48)
		f.txtunidades.value = 1;
	if (ValidaCampos())
	{
		linea = "";
		if (f.cmbmovimiento.value == 2)
		{			
			if (f.cmbproducto.value == 18)
			{
				if (f.txtmuestra.value == "S") 
					linea = "&txtcuba=00";
			}
		}
		
		if (f.cmbmovimiento.value == 3)
		{				
			if (f.cmbproducto.value == 18)
			{
                if ((f.cmbsubproducto.value != 42) && (f.cmbsubproducto.value != 43) && (f.cmbsubproducto.value != 44))
                {
				    if (f.txtcuba.disabled == true)
				    {
					    linea = "&cmbcuba=00";
				    }
                 }
			}
			
			if (f.radio[0].checked == true)
				linea = "&listar_ie=P";
			else if (f.radio[1].checked == true)	
					linea = "&listar_ie=V";				
		}
		
		if (f.cmbmovimiento.value == 1)		
		{			
			if (f.tipo_reg.value == "P")
			{
				if (f.radio[0].checked == true)
					linea = "&listar_ie=P";
				else if (f.radio[1].checked == true)	
						linea = "&listar_ie=V";							
			}
		}
		if (f.checkpeso.checked == true)
			linea = linea + "&peso_auto=checked";
		else 
			linea = linea + "&peso_auto=";		

		if (f.cmbproducto.value == 64 && (f.cmbsubproducto.value == 8 || f.cmbsubproducto.value == 7))
		{
			linea = linea + '&activa_sipa=S';
		}
		
		if (f.cmbmovimiento.value == 3)
		{					
			if(f.cmbcodpaq.value!='-1')
			{			
				StrPaquetePeso = f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"\r\n"+f.txtpeso.value;	
				//fwrite_x('c:/','datos.txt',StrPaquetePeso,1);
				ruta    = '';
				archivo = 'datos.txt';	
				EscribirArchivo(ruta,archivo,StrPaquetePeso);
				// MF alert("MF escribio paquete peso ....");
				  // MF alert(f.cmbproducto.value);
				  
				if(f.cmbproducto.value==18||f.cmbproducto.value==48)//ETIQUETAS SOLO PARA CATODOS Y LAMINAS
				{	
				  /*	
				   Comentado por Manuel Fuentes 06-08-2019 por solicitud de Mantención Axity.			
					if(f.cmbproducto.value==18&&f.leyes_grupo.value=='')//PARA CATODOS OBLIGACION LEYES DEL GRUPO
					{
						alert('No hay Leyes para el grupo Ingresado');
						return;
					}
				  */
					StrDatosEtiqueta=f.SubProdEtiq.value+"*"+f.cmbcodlote.options[f.cmbcodlote.selectedIndex].text+"-"+str_pad (f.txtnumlote.value, 5, '0','STR_PAD_LEFT')+"*";
					//alert(f.cmbproducto.value);
					switch(f.cmbproducto.value)
					{
						case '48'://LAMINAS NO SE CONSIDERA UNIDADES
							//StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"*"+f.txtmarca.value+"*"+f.txtunid48.value+"*"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"*"+f.txtpeso.value+"*"+""+"*"+f.id_paquete.value+"*"+f.id_lote.value+"*"+f.leyes_grupo.value;
							StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+str_pad (f.txtnumpaq.value, 5, '0','STR_PAD_LEFT')+"*"+f.txtmarca.value+"*"+f.txtunid48.value+"*"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"*"+f.txtpeso.value+"*"+""+"*"+f.id_paquete.value+"*"+f.id_lote.value+"*"+f.leyes_grupo.value;
							break;
						default:
							//StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"*"+f.txtmarca.value+"*"+f.txtunidades.value+"*"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"*"+(f.txtpeso.value-1)+"*"+f.txtgrupo.value+"*"+f.id_paquete.value+"*"+f.id_lote.value+"*"+f.leyes_grupo.value;						
							StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+str_pad (f.txtnumpaq.value, 5, '0','STR_PAD_LEFT')+"*"+f.txtmarca.value+"*"+f.txtunidades.value+"*"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"*"+(f.txtpeso.value-1)+"*"+f.txtgrupo.value+"*"+f.id_paquete.value+"*"+f.id_lote.value+"*"+f.leyes_grupo.value;						
							break;
					}
					//fwrite_x('c:/','etiquetas.txt',StrDatosEtiqueta,1);
					ruta    = '';
					archivo = 'etiquetas.txt';	
					EscribirArchivo(ruta,archivo,StrDatosEtiqueta);	
					//f.id_paquete.value='';
					//f.id_lote.value='';
					//f.leyes_grupo.value=''				
					//EjecEtiqueta();	
				}
			} 
		}	
			
		// Esto se agrego para recepcion catodo 22-02-2007
		try
		{
			if (f.cmbmovimiento.value == 1)
			{
				//StrPaquetePeso=f.txtlote.value+"-"+f.txtrecargo.value+"\r\n"+f.txtpeso.value;
				StrPaquetePeso=f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"\r\n"+f.txtpeso.value;
				//fwrite_x('c:/','datos.txt',StrPaquetePeso,1);
				ruta    = '';
				archivo = 'datos.txt';	
				EscribirArchivo(ruta,archivo,StrPaquetePeso);	

				/*StrDatosEtiqueta=f.SubProdEtiq.value+"\r\n"+f.cmbcodlote.options[f.cmbcodlote.selectedIndex].text+"-"+f.txtnumlote.value+"\r\n";
				StrPaquetePeso=f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"\r\n"+f.txtpeso.value;
				fwrite_x('c:/','datos.txt',StrPaquetePeso,1);
				StrDatosEtiqueta=f.SubProdEtiq.value+"\r\n"+f.cmbcodlote.options[f.cmbcodlote.selectedIndex].text+"-"+f.txtnumlote.value+"\r\n";
				switch(f.cmbproducto.value)
				{
					case '48'://LAMINAS NO SE CONSIDERA UNIDADES
						StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"\r\n"+f.txtmarca.value+"\r\n"+f.txtunid48.value+"\r\n"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"\r\n"+f.txtpeso.value+"\r\n"+""+"\r\n"+f.txtnommarca.value;
						break;
					case '64'://SALES NO CONSIDERA GRUPOS
						StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"\r\n"+f.txtmarca.value+"\r\n"+f.txtunidades.value+"\r\n"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"\r\n"+f.txtpeso.value+"\r\n"+""+"\r\n"+f.txtnommarca.value;						
						break;								
					default:
						StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"\r\n"+f.txtmarca.value+"\r\n"+f.txtunidades.value+"\r\n"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"\r\n"+f.txtpeso.value+"\r\n"+f.txtgrupo.value+"\r\n"+f.txtnommarca.value;						
						break;
				}
				//alert (StrDatosEtiqueta);
				fwrite_x('c:/','etiquetas.txt',StrDatosEtiqueta,1);*/
				//EjecEtiqueta();
				//alert('PRUEBA 2 INFORMATICA');						
			}
		}
		catch (e)
		{
		}	
	
		if ((f.cmbmovimiento.value == 3) && (f.cmbproducto.value == 57) && (f.cmbsubproducto.value == 12))
			f.action = "sec_ing_produccion01.php?proceso=GL" + linea;
		else 
			if(f.cmbmovimiento.value == 3)
			{
				/*
				Comentado por Luis Castillo 08-07-2019 por solicitud de Mantención Axity.
				
				if(f.cmbsubproducto.value =='16' || f.cmbsubproducto.value =='17' || f.cmbsubproducto.value =='49' || f.cmbsubproducto.value =='57')
				{
					f.action = "sec_ing_produccion01.php?proceso=G" + linea+"&NroSolAnalisis="+f.SA_C_STD.value
				}
				else*/
					f.action = "sec_ing_produccion01.php?proceso=G" + linea;
			}
			else
				f.action = "sec_ing_produccion01.php?proceso=G" + linea;
		//alert(linea)		
		//alert(f.action);		
			
		f.submit();
	}	
}  /*   
function fwrite_x(folder,filename,data,mode)//crea archivo de texto para visor
{ //fwrite_x v1.0 byScriptman
//modes: 0:si no existe, regresa false ;1: sobreescribe; 2:append.
var fso = new ActiveXObject("Scripting.FileSystemObject");

filename=folder+filename;
if(fso.FileExists(filename) == false&&mode==0) return false;
if(fso.FileExists(filename) != false&&mode==2) {
tf = fso.OpenTextFile(filename,1);
var dataold = tf.readall(); tf.close(); }
else dataold="";
var tf = fso.CreateTextFile(filename,2);
tf.write(dataold+data);
tf.close();
return true;
}*/
/***************/
function Etiqueta()
{
	var f = document.frm1;		
	linea = '';
	if ((f.cmbmovimiento.value == 3) || (f.cmbmovimiento.value == 1))
	{
		/*if(f.ModPesoLoteSN.value=='T')
		{
			alert('No se Puede Modificar Peso de Paquete, Instrucción de Embarque se Encuentra Terminada.')
			return;
		}
		if (parseInt(f.txtpeso.value) > (parseInt(f.pesofaltante.value) + parseInt(f.peso_aux.value)))
		{
			alert("El Peso Del Paquete No Puede Ser Mayor Al Peso Faltante");
			return;
		}		
		*/		
		linea = '&cmbcodpaq=' + f.cmbcodpaq.value + '&txtnumpaq=' + f.txtnumpaq.value;
		linea = linea + '&cmbcodlote=' + f.cmbcodlote.value + '&txtnumlote=' + f.txtnumlote.value;
		
		if (f.radio[0].checked == true)
			linea = linea + "&listar_ie=P";
		else if (f.radio[1].checked == true)	
				linea = linea + "&listar_ie=V";
				//StrDatosEtiqueta=f.SubProdEtiq.value+"\r\n"+f.cmbcodlote.options[f.cmbcodlote.selectedIndex].text+"-"+f.txtnumlote.value+"\r\n";
				var StrPaquetePeso=f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"\r\n"+f.txtpeso.value;
				//alert(StrPaquetePeso);
				//fwrite_x('c:/','datos.txt',StrPaquetePeso,1);
				ruta    = '';
				archivo = 'datos.txt';	
				EscribirArchivo(ruta,archivo,StrPaquetePeso);	
				
				if(f.cmbproducto.value==18||f.cmbproducto.value==48)//ETIQUETAS SOLO PARA CATODOS Y LAMINAS
				{
					/*if(f.cmbproducto.value==18&&f.leyes_grupo.value=='')//PARA CATODOS OBLIGACION LEYES DEL GRUPO
					{
						alert('No hay Leyes para el Grupo Ingresado');
						return;
					}*/
					StrDatosEtiqueta=f.SubProdEtiq.value+"*"+f.cmbcodlote.options[f.cmbcodlote.selectedIndex].text+"-"+f.txtnumlote.value+"*";
					//alert(f.cmbproducto.value);
					switch(f.cmbproducto.value)
					{
						case '48'://LAMINAS NO SE CONSIDERA UNIDADES
							StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"*"+f.txtmarca.value+"*"+f.txtunid48.value+"*"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"*"+f.txtpeso.value+"*"+""+"*"+f.id_paquete.value+"*"+f.id_lote.value+"*"+f.leyes_grupo.value;
							break;
						default:
							StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"*"+f.txtmarca.value+"*"+f.txtunidades.value+"*"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"*"+f.txtpeso.value+"*"+f.txtgrupo.value+"*"+f.id_paquete.value+"*"+f.id_lote.value+"*"+f.leyes_grupo.value;						
							break;
					}
					//alert(StrDatosEtiqueta);
					//fwrite_x('c:/','etiquetas.txt',StrDatosEtiqueta,1);
					ruta    = '';
					archivo = 'etiquetas.txt';	
					EscribirArchivo(ruta,archivo,StrDatosEtiqueta);
					//f.id_paquete.value='';
					//f.id_lote.value='';
					//f.leyes_grupo.value=''				
					//-EjecEtiqueta();
				}
	}
	var a=setTimeout("alert('Impresion Realizada ')",2000);
	
	
}
function Writex()
{
	var f = document.frm1;	
	StrDatosEtiqueta=f.SubProdEtiq.value+"*"+f.cmbcodlote.options[f.cmbcodlote.selectedIndex].text+"-"+f.txtnumlote.value+"*";
	//alert("StrDatosEtiqueta:"+StrDatosEtiqueta);
	ruta    = '';
	archivo = 'etiquetas.txt';	
	EscribirArchivo(ruta,archivo,StrDatosEtiqueta);
}

function Modificar()
{
	var f = document.frm1;		
		
	linea = '';
	if (f.cmbmovimiento.value == 2) //Produccion.
	{		
		if (f.cmbproducto.value == 18)
		{
			linea = "&txtgrupo=" + f.txtgrupo.value + "&txtmuestra=" + f.txtmuestra.value;
			if (f.txtmuestra.value == "S")
			 	linea = linea + "&txtlado=" + "&txtcuba=00";
			else
				linea = linea + "&txtlado=" + f.txtlado.value + "&txtcuba=" + f.txtcuba.value;
		}
		
		if ((f.cmbproducto.value == 48) && (f.cmbsubproducto.value == 2))
		{	
			linea = "&txtgrupo=" + f.txtgrupo.value + "&txtcuba=" + f.txtcuba.value;
		}				
	}
	
	if ((f.cmbmovimiento.value == 3))
	{
		var FechaValPeso = new Date();
		var MesActual=FechaValPeso.getMonth()+1;
		if(f.cmbcodpaq.value != MesActual)
		{
			alert('No se Puede Modificar Peso del Paquete, ya que el Codigo de Serie del Paquete no esta dentro del Mes Actual');
			return;
		}
		/*if(parseInt(f.cmbcodpaq.value) <> (parseInt(MesActual))
		(
			alert('No se Puede Modificar Peso del Paquete, ya que el Codigo de Serie del Paquete no esta dentro del Mes Actual');
			return;
		)*/
		if(f.ModPesoLoteSN.value=='T')
		{
			alert('No se Puede Modificar Peso de Paquete, Instrucción de Embarque se Encuentra Terminada.')
			return;
		}
		if (parseInt(f.txtpeso.value) > (parseInt(f.pesofaltante.value) + parseInt(f.peso_aux.value)))
		{
			alert("El Peso Del Paquete No Puede Ser Mayor Al Peso Faltante");
			return;
		}		
		linea = '&cmbcodpaq=' + f.cmbcodpaq.value + '&txtnumpaq=' + f.txtnumpaq.value;
		linea = linea + '&cmbcodlote=' + f.cmbcodlote.value + '&txtnumlote=' + f.txtnumlote.value;
		
		if (f.radio[0].checked == true)
			linea = linea + "&listar_ie=P";
		else if (f.radio[1].checked == true)	
	
				linea = linea + "&listar_ie=V";
				//StrDatosEtiqueta=f.SubProdEtiq.value+"\r\n"+f.cmbcodlote.options[f.cmbcodlote.selectedIndex].text+"-"+f.txtnumlote.value+"\r\n";
				StrPaquetePeso=f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"\r\n"+f.txtpeso.value;
				
				//fwrite_x('c:/','datos.txt',StrPaquetePeso,1);
				ruta    = '';
				archivo = 'datos.txt';	
				EscribirArchivo(ruta,archivo,StrPaquetePeso);
				
				if(f.cmbproducto.value==18||f.cmbproducto.value==48)//ETIQUETAS SOLO PARA CATODOS Y LAMINAS
				{
					/*	
				   Comentado por Manuel Fuentes 06-08-2019 por solicitud de Mantención Axity.	
					if(f.cmbproducto.value==18&&f.leyes_grupo.value=='')//PARA CATODOS OBLIGACION LEYES DEL GRUPO
					{
						alert('No hay Leyes para el Grupo Ingresado');
						return;
					}
					*/
					
					StrDatosEtiqueta=f.SubProdEtiq.value+"*"+f.cmbcodlote.options[f.cmbcodlote.selectedIndex].text+"-"+f.txtnumlote.value+"*";
					//alert(f.cmbproducto.value);
					switch(f.cmbproducto.value)
					{
						case '48'://LAMINAS NO SE CONSIDERA UNIDADES
							StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"*"+f.txtmarca.value+"*"+f.txtunid48.value+"*"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"*"+f.txtpeso.value+"*"+""+"*"+f.id_paquete.value+"*"+f.id_lote.value+"*"+f.leyes_grupo.value;
							break;
						default:
							StrDatosEtiqueta=StrDatosEtiqueta+f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text+"-"+f.txtnumpaq.value+"*"+f.txtmarca.value+"*"+f.txtunidades.value+"*"+f.dia.value+"-"+f.mes.value+"-"+f.ano.value+" "+f.hh.value+":"+f.mm.value+"*"+f.txtpeso.value+"*"+f.txtgrupo.value+"*"+f.id_paquete.value+"*"+f.id_lote.value+"*"+f.leyes_grupo.value;						
							break;
					}
					//alert (StrDatosEtiqueta);
					//fwrite_x('c:/','etiquetas.txt',StrDatosEtiqueta,1);
					ruta    = '';
					archivo = 'etiquetas.txt';	
					EscribirArchivo(ruta,archivo,StrDatosEtiqueta);	
					//alert("Write:" + write);
					//f.id_paquete.value='';
					//f.id_lote.value='';
					//f.leyes_grupo.value=''				
					//EjecEtiqueta();
				}
	}
	
	if ((f.cmbmovimiento.value == 3) && (f.cmbproducto.value == 57))
		f.action = "sec_ing_produccion01.php?proceso=ML" + linea;
	else
	{
		if(f.cmbmovimiento.value == 3)
		{
			/*	
				   Comentado por Manuel Fuentes 06-08-2019 por solicitud de Mantención Axity.	
			if(f.cmbsubproducto.value =='16' || f.cmbsubproducto.value =='17' || f.cmbsubproducto.value =='49' || f.cmbsubproducto.value =='57')
			{
				f.action = "sec_ing_produccion01.php?proceso=M" + linea+"&NroSolAnalisis="+f.SA_C_STD.value
			}
			else
			*/
			//alert('Linea = ' + linea);
			
				f.action = "sec_ing_produccion01.php?proceso=M" + linea;
		}
		else
			f.action = "sec_ing_produccion01.php?proceso=M" + linea;
	}		
	f.submit();

}
/***************/
function Eliminar()
{
	var f = document.frm1;		
	var registro = "";
	//alert(f.tipo_reg.value);

	if ((f.cmbmovimiento.value == "1") && (f.tipo_reg.value == "L"))
	    {
	    var registro = "L";
		mensaje = "Esta Seguro De Eliminar la Recepcion y Todos Sus Paquetes";
	    }
	if ((f.cmbmovimiento.value == "1") && (f.tipo_reg.value == "P"))
	    {
	    var registro = "P";
		var codigopaquete = f.codigopaquete.value;
		var paquete =f.txtnumpaq.value;
			//alert (codigopaquete);
			//alert (paquete);
		mensaje = "Esta Seguro De Eliminar Este Paquete";
		}
	if (f.cmbmovimiento.value == "2")
		mensaje = "Esta Seguro De Eliminar El Registro De Produccion";
		
	if (f.cmbmovimiento.value == "3") 
		mensaje = "Esta Seguro De Eliminar El Paquete";
	
	if (confirm(mensaje))
	{
		linea = '';
		if (f.cmbmovimiento.value == 2) //Produccion.
		{			
			if (f.cmbproducto.value == 18)
			{
			
				linea = "&txtgrupo=" + f.txtgrupo.value + "&txtmuestra=" + f.txtmuestra.value;
				if (f.txtmuestra.value == "S")
					linea = linea + "&txtlado=" + "&txtcuba=00";
				else
					linea = linea + "&txtlado=" + f.txtlado.value + "&txtcuba=" + f.txtcuba.value;
			}
			
			
			if ((f.cmbproducto.value == 48) && (f.cmbsubproducto.value == 2))
			{	
				linea = "&txtgrupo=" + f.txtgrupo.value + "&txtcuba=" + f.txtcuba.value;
			}
		}
		
		if (f.cmbmovimiento.value == 3) //Paquete.
		{
			linea = '&cmbcodlote=' + f.cmbcodlote.value +'&txtnumlote=' + f.txtnumlote.value+'&cmbcodpaq=' + f.cmbcodpaq.value + '&txtnumpaq=' + f.txtnumpaq.value;	
		}
		
		if (((f.cmbmovimiento.value == 3) || (f.cmbmovimiento.value == 1)) && (registro=="P"))
		{			

			if (f.radio[0].checked == true)
				linea = linea + "&listar_ie=P";
			else if (f.radio[1].checked == true)	
				linea = linea + "&listar_ie=V"+ "&cmbcodpaq=" + codigopaquete + "&txtnumpaq=" + paquete ;		
		}
				
		if (((f.cmbmovimiento.value == 3) || (f.cmbmovimiento.value == 1)) && (registro=="L"))
		{
			alert ("Procede a Borrar Lote y sus Paquetes");			
		}	
		//alert(linea);
		f.action = "sec_ing_produccion01.php?proceso=E" + linea;
		f.submit();					

	}
}
/***************/
function Buscar()
{
	var f = document.frm1;	
	
	if (f.cmbsubproducto.value == -1)	
	{
		alert("Debe Selecionar el Sub-Producto");
		return;
	}
	
	if (f.txtlote.value == "")
	{	
		alert("Debe Ingresar el Lote");
		return;
	}
	
	if (f.txtrecargo.value == "")
	{
		alert("Debe Ingresar Recargo");
		return;
	}
	
	linea = '';
	if (f.checkpeso.checked == true)
		linea = linea + "&peso_auto=checked";
	else 
		linea = linea + "&peso_auto=";
	
	f.action = "sec_ing_produccion01.php?proceso=B" + linea;
	f.submit();
}
/***************/
function BuscarIE()
{	
	var f = document.frm1;
		
	if (f.radio[0].checked == true)
		linea = "&listar_ie=P";
	else if (f.radio[1].checked == true)	
			linea = "&listar_ie=V";		
			
	if (f.checkpeso.checked == true)
		linea = linea + "&peso_auto=checked";
	else 
		linea = linea + "&peso_auto=";			
		
	linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	if(f.cmbsubproducto.value =='16' || f.cmbsubproducto.value =='17' || f.cmbsubproducto.value =='49')
		linea = linea + "&recargapag1=S&recargapag2=S&SA_C_STD="+f.SA_C_STD.value+"&recargapag3=S";	
	else
		linea = linea + "&recargapag1=S&recargapag2=S&recargapag3=S";	
	//linea = linea + "&recargapag1=S&recargapag2=S&recargapag3=S";	
	linea = linea + "&cmbinstruccion=" + f.cmbinstruccion.value;
	linea = linea + "&ano=" + f.ano.value + "&mes=" + f.mes.value + "&dia=" + f.dia.value + "&hh=" + f.hh.value + "&mm=" + f.mm.value;
	//para recepcion.
	if (f.cmbmovimiento.value == 1)	
	{
		linea = linea + "&existe_rec=" + f.existe_rec.value + "&existe_sec=" + f.existe_sec.value + "&tipo_reg=P";
		linea = linea + "&txtlote=" + f.txtlote.value + "&txtrecargo=" + f.txtrecargo.value;		
	}
	
	document.location = "sec_ing_produccion01.php?proceso=B7" + linea;
}
/***************/
function BuscarIE_Lodo() //Solo para los Lodos.
{
	var f = document.frm1;
		
	if (f.radio[0].checked == true)
		linea = "&listar_ie=P";
	else if (f.radio[1].checked == true)	
			linea = "&listar_ie=V";		
			
	if (f.checkpeso.checked == true)
		linea = linea + "&peso_auto=checked";
	else 
		linea = linea + "&peso_auto=";			
		
	linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	linea = linea + "&recargapag1=S&recargapag2=S&recargapag3=S";	
	linea = linea + "&cmbinstruccion=" + f.cmbinstruccion.value;
	linea = linea + "&ano=" + f.ano.value + "&mes=" + f.mes.value + "&dia=" + f.dia.value + "&hh=" + f.hh.value + "&mm=" + f.mm.value;	
	
	//document.location = "sec_ing_produccion01.php?proceso=B7" + linea;
	document.location = "sec_ing_produccion01.php?proceso=B9" + linea;
}
/***************/
function BusarSerieLodo()
{
	var f = document.frm1;

	if (f.radio[0].checked == true)
		linea = "&listar_ie=P";
	else if (f.radio[1].checked == true)	
			linea = "&listar_ie=V";		
			
	if (f.checkpeso.checked == true)
		linea = linea + "&peso_auto=checked";
	else 
		linea = linea + "&peso_auto=";
		
	linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	linea = linea + "&recargapag1=S&recargapag2=S&recargapag3=S";	
	linea = linea + "&cmbinstruccion=" + f.cmbinstruccion.value;
	linea = linea + "&ano=" + f.ano.value + "&mes=" + f.mes.value + "&dia=" + f.dia.value + "&hh=" + f.hh.value + "&mm=" + f.mm.value;	
	
	//document.location = "sec_ing_produccion01.php?proceso=B11" + linea;			
	f.action = "sec_ing_produccion01.php?proceso=B11" + linea;
	f.submit();
}
/***************/
function VerDatos()
{	
	var f = document.frm1;	

	if (f.cmbmovimiento.value == -1)
	{	
		alert("Debe Seleccionar Tipo Movimiento");
		return;
	}
	
	if (f.cmbproducto.value == -1)
	{	
		alert("Debe Seleccionar Producto");
		return;
	}
	
	if (f.cmbsubproducto.value == -1)
	{	
		alert("Debe Seleccionar Sub-Producto");
		return;
	}

	linea = 'cmbproducto=' + f.cmbproducto.value + '&cmbsubproducto='  + f.cmbsubproducto.value;
		
	switch (f.cmbmovimiento.value)
	{
		case '1' :  window.open("sec_ing_produccion_popup1.php?"+linea,"","top=195,left=180,width=540,height=350,scrollbars=no,resizable=no");
					break;
		case '2' :  window.open("sec_ing_produccion_popup2.php?"+linea,"","top=195,left=180,width=540,height=350,scrollbars=no,resizable=no");
					break;
		case '3' :
			/*if(f.cmbsubproducto.value =='16' || f.cmbsubproducto.value =='17' || f.cmbsubproducto.value =='49')
			{
				//alert("if");
				window.open("sec_ing_produccion_popup3.php?"+linea+"&SA_C_STD="+f.SA_C_STD.value,"","top=195,left=180,width=540,height=360,scrollbars=no,resizable=no");
			}
			else
			{
				//alert("else");*/
				window.open("sec_ing_produccion_popup3.php?"+linea,"","top=195,left=180,width=540,height=360,scrollbars=no,resizable=no");
			/*}*/
		break;
					
	}
}
/***************/
function VerMarca()
{	
	window.open("sec_asignar_marca2.php?",""," fullscreen=no,width=700,height=400,scrollbars=yes,resizable = yes");
}
/***************/
function DesbloqueCheck()
{
	var f = document.frm1;	
	
	if (f.checkbox.checked == false)
	{	
		f.txtlote.readonly = true;
	}
}
/***************/
function Traspaso()
{
	linea = '';
	window.open("sec_ing_produccion_popup_traspaso.php?"+linea,"","top=195,left=180,width=540,height=350,scrollbars=no,resizable=no");	
}
/***************/
function TeclaPulsada (salto) 
{ 
	var f = document.frm1;
	var teclaCodigo = event.keyCode; 
	
	if (teclaCodigo == 13)
	{
		switch (salto) {
			case 1: 
					if (f.cmbproducto.value == 18 )
					{
						if (f.txtmuestra.value == "S")
							f.txtmuestra.focus();
						else
							f.txtcuba.focus();
					}
					else
						f.txtcuba.focus();
						
					break;
			case 2: 
					if (f.cmbproducto.value == 18)
						f.txtlado.focus();
					else
						f.btngrabar.focus();
						
					break;
			case 3: f.txtmuestra.focus();
					break;
			case 4: f.btngrabar.focus();
					break;
		}		
	}
}
/****************/
function TeclaPulsada3(salto)
{
	var f = document.frm1;
	var teclaCodigo = event.keyCode; 
	
	if (teclaCodigo == 13)
	{
		switch (salto) {
			case 1: f.txtcuba.focus();
					break;
			case 2: f.txtunidades.focus();
					break;
			case 3: f.txtpeso.focus();
					break;
			case 4: f.btngrabar.focus();
					break;
		}
	}
}
/***************/
function Limpiar()
{
	document.location = "sec_ing_produccion.php";	
}
/***************/
function Salir()
{		
	document.location = "../principal/sistemas_usuario.php?CodSistema=3";
}
/**************/
function Posicionar()
{	
	var f = document.frm1;
	
	if (f.cmbmovimiento.value == 2)
	{
		if ((f.cmbproducto.value == 18) && (f.cmbsubproducto.value != -1))
		{
			if (f.txtgrupo.disabled == true)
				f.txtpeso.focus();
			else 
				f.txtgrupo.focus();
			return;
		}
		
		if (((f.cmbproducto.value == 64) && (f.cmbsubproducto.value != -1)) || ((f.cmbproducto.value == 48) && (f.cmbsubproducto.value == 11)))
		{
			f.txtpeso.focus();
			return;		
		}
		
		if ((f.cmbproducto.value == 48) && (f.cmbsubproducto.value != -1) && (f.cmbsubproducto.value == 2))
		{
			if (f.txtgrupo.disabled == true)
				f.txtpeso.focus();
			else 
				f.txtgrupo.focus();		
		}
	}		
}
/*************/
function Posicionar3()
{
	var f = document.frm1;
	if ((f.cmbproducto.value == 18) && (f.cmbsubproducto.value != -1))
	{
		if ((f.cmbsubproducto.value != 42) && (f.cmbsubproducto.value != 43) && (f.cmbsubproducto.value != 44))
			f.txtgrupo.focus();
	}
}
/*************/
function ValGrupo()
{	
	var f = document.frm1;
	
	if  (f.txtgrupo.value == "")
		return;
	
	if ((f.cmbproducto.value == '48') && (f.cmbsubproducto.value == '2'))
	{
		f.txtgrupo.value = f.txtgrupo.value.toUpperCase();
		if ((!((f.txtgrupo.value >= 'A') && (f.txtgrupo.value <= 'M'))) || (f.txtgrupo.value == 'K'))
		{
			alert("Letra Del Mes No Valida");
			f.txtgrupo.focus();
			return;
		}
		return;
	}

	if (isNaN(parseInt(f.txtgrupo.value)))
	{
		alert("El Grupo No Es Valido");
		f.txtgrupo.value="";
		f.txtgrupo.focus();
		return false;
	}
	
	if ((parseInt(Number(f.txtgrupo.value)) != 99) && ((parseInt(Number(f.txtgrupo.value)) < 1) || (parseInt(Number(f.txtgrupo.value)) > 49)))
	{	
		alert("El Grupo Esta Fuera del Rango 1 al 49");
		f.txtgrupo.focus();
		return false;
	}
	else
	{
		if (f.txtgrupo.value.length == 1) 
			f.txtgrupo.value = '0' + f.txtgrupo.value;
			
		if (f.cmbproducto.value == 18)
			PoneDatos();
	}				
}
function PoneDatos()
{	
	try{
		var f = document.frm1;		
		var encontro = "N";
		
		for (i=0; i < f.valores.length; i++)
		{
			vector = f.valores[i].value.split('-'); //Grupo-Cuba-Lado.
			if (f.txtgrupo.value == vector[0])
			{
				f.txtcuba.value = vector[1];
				f.txtlado.value = vector[2];
				encontro = 'S';
			}
		}		
		if (encontro == 'N')
		{
			f.txtcuba.value = "";
			f.txtlado.value = "";
		}
	}catch(e){
		alert("malo");
	}
}
/*************/
function ValCuba()
{	
	var f = document.frm1;
	
	if (f.txtcuba.value == "")
		return;
		
	if (f.cmbmovimiento == '2' && f.cmbproducto.value == '48' && f.cmbsubproducto.value)		
	{
		if (f.txtcuba.value.length == 1) 
			f.txtcuba.value = '0' + f.txtcuba.value;		
		return false;
	}		
	
	if ((f.txtcuba.value != 'f') && (f.txtcuba.value != 'F'))
	{
		if (isNaN(parseInt(f.txtcuba.value)))
		{			
			<?php
			if ($cmbmovimiento == '2' and $cmbproducto == '48' and $cmbsubproducto == '2')
				echo "alert('El Correlativo No Es Valido');";
			else
				echo "alert('La Cuba No Es Valido');";
			?>	
			f.txtcuba.value="";			
			f.txtcuba.focus();
			return false;
		}

		<?php
			if ($cmbmovimiento == '2' and $cmbproducto == '48' and $cmbsubproducto == '2')
			{
					echo "if (f.txtcuba.value.length == 1) ";
						echo "f.txtcuba.value = '0' + f.txtcuba.value;";
			}
			else
			{
				if ($cmbmovimiento == '2' and $cmbproducto == '18' and $cmbsubproducto == '1'){
					echo "if (parseInt(Number(f.txtgrupo.value)) == 49){"; 
						echo "if ((parseInt(Number(f.txtcuba.value)) < 1) || (parseInt(Number(f.txtcuba.value)) > 60)){";
						echo "alert('La Cuba Esta Fuera del Rango 1 al 60');";
						echo "f.txtcuba.focus();";
						echo "return;}";
					echo "}";
					echo "else{";
						echo "if ((parseInt(Number(f.txtcuba.value)) < 1) || (parseInt(Number(f.txtcuba.value)) > 48)){";
						echo "alert('La Cuba Esta Fuera del Rango 1 al 42');";
						echo "f.txtcuba.focus();";
						echo "return;}";
					echo "}";

				}else{
				
				echo "if ((parseInt(Number(f.txtcuba.value)) < 1) || (parseInt(Number(f.txtcuba.value)) > 48)){";
					echo "alert('La Cuba Esta Fuera del Rango 1 al 42');";
					echo "f.txtcuba.focus();";
					echo "return;}";
				echo "else{";
					echo "if (f.txtcuba.value.length == 1) ";
						echo "f.txtcuba.value = '0' + f.txtcuba.value;}";
				}
			}
		?>							
	}
	else
		f.txtcuba.value = 'F';
}
/*************/
function ValLado()
{
	var f = document.frm1;
	
	if (f.txtlado.value == "")
		return false;

	if ((f.cmbmovimiento.value == 2) && (f.cmbproducto.value == 18) && (f.cmbsubproducto.value == 3) && (f.txtgrupo.value == 99))
	{
		if ((f.txtlado.value.toUpperCase() != "A") && (f.txtlado.value.toUpperCase() != "B") && (f.txtlado.value.toUpperCase() != "R"))
		{
			alert("Debe Ingresar A: (Grado A), B: (B-115), R: (Rechazado)")
			f.txtlado.focus();
			return false;			
		}
		else
			f.txtlado.value = f.txtlado.value.toUpperCase();
	}	
	else if ((f.txtlado.value.toUpperCase() != "P") && (f.txtlado.value.toUpperCase() != "T"))
		{
			alert("El Lado No Es Valido");
			f.txtlado.value="";
			f.txtlado.focus();
			return false;
		}
		else 
			f.txtlado.value = f.txtlado.value.toUpperCase();
}
/*************/
function ValMuestra()
{	
	var f = document.frm1;
	
	if (f.txtmuestra.value == "")
		return;	

	if ((f.txtmuestra.value.toUpperCase() != "S") && (f.txtmuestra.value.toUpperCase() != "N"))
	{
		alert("El Valor No Es Valido");
		f.txtmuestra.value="";
		f.txtmuestra.focus();
		return false;
	}
	else
	{ 
		f.txtmuestra.value = f.txtmuestra.value.toUpperCase();	
		Bloquea2();
	}
}
/*****************/
function Listar_IE(valor)
{
	var f = document.frm1;

	linea = "recargapag1=S&recargapag2=S&recargapag3=S&recargapag4=S";
	linea = linea + "&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value
	linea = linea + "&listar_ie=" + valor;
	//para recepcion.
	if (f.cmbmovimiento.value == 1)
	{
		linea = linea + "&existe_rec=" + f.existe_rec.value + "&existe_sec=" + f.existe_sec.value + "&tipo_reg=P";
		linea = linea + "&txtlote=" + f.txtlote.value + "&txtrecargo=" + f.txtrecargo.value;
	}
	
	if (f.checkpeso.checked == true)
		linea = linea + "&peso_auto=checked";
	else 
		linea = linea + "&peso_auto=";	
	
	document.location = "sec_ing_produccion.php?" + linea;
}
/***************/
function RecargaGrupo()
{
	var f = document.frm1;
	
	if (f.cmbproducto.value != 18)
	{
		return;
	}
	if (f.txtgrupo.value == "")	
		return;
	
	if (isNaN(parseInt(f.txtgrupo.value)))
	{
		alert("El Grupo No ES Valido");
		return;
	}	/*
var select = document.getElementById('provincia');
select.addEventListener('change',
  function(){
    var selectedOption = this.options[select.selectedIndex];	
	*/
	if (f.txtgrupo.value.length == 1) 
		f.txtgrupo.value = '0' + f.txtgrupo.value;
	linea = "recargapag1=S&recargapag2=S&recargapag3=S&recargapag4=S&recargapag5=S&accion=N&opcion=<?php echo $opcion;?>";
	linea = linea +	"&ano2=" + f.ano.value + "&mes2=" + f.mes.value + "&dia2=" + f.dia.value;
	linea = linea +	"&codlote=" + f.cmbcodlote.options[f.cmbcodlote.selectedIndex].text + "&numlote=" + f.txtnumlote.value + "&codpaq=" + f.cmbcodpaq.options[f.cmbcodpaq.selectedIndex].text + "&numpaq=" + f.txtnumpaq.value;
	linea = linea + "&tipo_ie=" + f.tipo_ie.value + "&mostrar=S" + "&instruccion=" + f.cmbinstruccion.value + "&encontro_ie=" + f.encontro_ie.value;
	linea = linea + "&pesoprog=" + f.txtpesoprog.value + "&genera_lote=" + f.genera_lote.value;
	linea = linea + "&peso_prog_ok=" + f.peso_prog_ok.value + "&marca=" + f.txtmarca.value + "&paq_inicial=" + f.paq_inicial.value + "&cmbinstruccion=" + f.cmbinstruccion.value 
	+ "&grupo=" + f.txtgrupo.value + "&unidades=" + f.txtunidades.value + "&peso=" + f.txtpeso.value + "&cuba=" + f.txtcuba.value + "&SA_C_STD2=" + f.SA_C_STD.value;
	
			
	if (f.radio[0].checked == true)
		linea = linea + "&listar_ie=P";
	else if (f.radio[1].checked == true)
			linea = linea + "&listar_ie=V";

	if (f.checkpeso.checked == true)
		linea = linea + "&peso_auto=checked";
	else 
		linea = linea + "&peso_auto=";
	

	f.action = "sec_ing_produccion.php?" + linea;
	f.submit();
}
/************/
function CalculaPesoBolsa()
{	
	var f = document.frm1;
	
	if (isNaN(parseInt(f.txtunidades.value)))	
	{
		alert("Debe Ingresar Las Unidades");
		return;
	}
			
	var valor = (parseFloat(f.txtunidades.value) * parseFloat(f.txtpesounitario.value));
	f.txtpesobolsa.value = Math.round(valor);
	
	CalculaPesoNetoLodo();
}
/***************/
function CalculaPesoNetoLodo()
{
	var f = document.frm1;
	
	if (isNaN(parseInt(f.txtpeso.value)) || isNaN(parseInt(f.txtpesotara.value)))
		f.txtpesoneto.value = 0;
	else
		f.txtpesoneto.value =  parseInt(f.txtpeso.value) - parseInt(f.txtpesotara.value);
}
/***************/
function ReCalculaCajon()
{
	var f = document.frm1;
	
	if (!isNaN(parseInt(f.txtpeso.value)) && !isNaN(parseInt(f.txtpesoneto.value)))
	{
		f.txtpesotara.value = parseInt(f.txtpeso.value) - parseInt(f.txtpesoneto.value);
	}
}
function EjecEtiqueta()
{
	window.open("ejecutar_etiqueta.php",""," fullscreen=no,width=1,height=1,scrollbars=yes,resizable = yes");
}

</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0" onLoad="Posicionar()">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php");?>
<input type="hidden" name="TxtNumRomana" class="InputCen" value="<?php echo $ROMANA;?>" size="2" readonly >
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="top">
	   
  <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
  <tr></tr>
    <td> Version 3 </td>
  </tr>
          <tr> 
		  	
            <td width="262"> Tipo Movimiento</td>
            <td width="326">            <SELECT name="cmbmovimiento" onChange="Recarga1()">
              <option value="-1">SELECCIONAR</option>
              <?php		  
		  	foreach($movimientos as $clave => $valor)
		  	{
          		if (($clave == $cmbmovimiento) and ($recargapag1 == "S"))
					echo '<option value="'.$clave.'" SELECTed>'.$valor.'</option>';
				else 
					echo '<option value="'.$clave.'">'.$valor.'</option>';
			}		
		?>
            </SELECT></td>
          </tr>
          <tr>
            <td>Producto</td>
            <td><SELECT name="cmbproducto" onChange="Recarga2()">
			<option value="-1">SELECCIONAR</option>
			<?php
			if ($recargapag1 == "S")
			{
				foreach($productos as $clave => $valor)
				{
					if (($clave == $cmbproducto) and ($recargapag2 == "S"))
						echo '<option value="'.$clave.'" SELECTed>'.$valor.'</option>';
					else 
						echo '<option value="'.$clave.'">'.$valor.'</option>';
				}	
			}
			?>			
              </SELECT></td>
          </tr>
          <tr> 
            <td>Sub-Producto</td>
            <td> 
              <SELECT name="cmbsubproducto" onChange="Recarga3()">
                <option value="-1">SELECCIONAR</option>
                <?php	
			$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = '".$cmbproducto."' AND tipo_mov LIKE '%".$cmbmovimiento."%'";
			//echo '<option value="-1">'.$consulta.'</option>';
			$var1 = $consulta;
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				$codigo = $row["cod_subproducto"];
				$descripcion = $row["descripcion"];
				if (($cmbmovimiento == 3) and ($cmbproducto == 48) and ($codigo == 1))	
					$descripcion = "LAMINAS";
			
				if (($codigo == $cmbsubproducto) and ($recargapag3 == "S"))
					echo '<option value="'.$codigo.'" SELECTed>'.$descripcion.'</option>';
				else
					echo '<option value="'.$codigo.'">'.$descripcion.'</option>';
			}						
		?>
           </SELECT>
  <?php //echo "Con".$consulta; ?> 		   </td>
          </tr>
        </table><br>
<?php
//CONSULTO POR NOMBRES PARA ETIQUETAS DE IMPRESION
$consulta = "SELECT abreviatura_etiqueta_sec FROM proyecto_modernizacion.subproducto WHERE cod_producto = '".$cmbproducto."' and cod_subproducto='".$cmbsubproducto."'";
//echo '<option value="-1">'.$consulta.'</option>';
$var1 = $consulta;
$rs = mysqli_query($link, $consulta);
if ($row = mysqli_fetch_array($rs))
{
	if($row["abreviatura_etiqueta_sec"]!='')
		$descripcion_etiq=$row["abreviatura_etiqueta_sec"];
	else
		$descripcion_etiq=$descripcion;
	echo "<input type='hidden' name='SubProdEtiq' value='".$descripcion_etiq."'>";

}
//echo $cmbmovimiento."<br>";
	if ($recargapag3 == "S") {	
		switch ($cmbmovimiento) {
			case 1:
				include("sec_ing_produccion_1.php");
				break;
			case 2:
				include("sec_ing_produccion_2.php");
				break;
			case 3:
				if ($cmbproducto == '57') //Lodos
					//include("sec_ing_produccion_4.php");	
					include("sec_ing_produccion_5.php");	
				else
					include("sec_ing_produccion_3.php");	
				break;
		}	 
	}
?>  
  <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr>
            <td align="center"> 
              <?php
	  	if ($opcion == "M")
		{
			if($cmbmovimiento =='3')
				echo '<input name="btngrabar" type="button"  value="Etiqueta" style="width:70" onClick="Etiqueta()">&nbsp;';
			echo '<input name="btngrabar" type="button"  value="Modificar" style="width:70" onClick="Modificar()">&nbsp;';
			echo '<input name="btngrabar" type="button"  value="Eliminar" style="width:70" onClick="Eliminar()">&nbsp;';
		}
		else 
			echo '<input name="btngrabar" type="button"  value="Grabar" style="width:70" onClick="Grabar()">&nbsp;';
			
			
		if ($activa_sipa == "S")
		{
			echo '<input name="btnajustar" type="button" style="width:70" value="Ajustar" onClick="AjustarPeso()">&nbsp;'; 			
		}

		echo '<input name="btnver" type="button" style="width:70" value="Ver Datos" onClick="VerDatos()">&nbsp;'; 
        echo '<input name="btnlimpiar" type="button" value="Limpiar" style="width:70" onClick="Limpiar()">&nbsp;';
        echo '<input name="btnsalir" type="button"   value="Salir" style="width:70" onClick="Salir()"></td>&nbsp;';
		//echo '<input name="btnwrite" type="button"   value="Write" style="width:70" onClick="Writex()"></td>&nbsp;';
	?>          
          </tr>
  </table></td>
</tr>
</table>

<?php
	if (($cmbproducto == "18") and ($recargapag3 == "S") and ($cmbmovimiento == "2") and ($opcion != "M"))
	{
		echo '<script language="JavaScript"> Bloquea2(); </script>';		
	}
	
	
	//********//
	if ($opcion == "M")
		echo '<script language="JavaScript"> Bloquea3(); </script>';	
		
	if ($accion == "G")
		echo '<script language="JavaScript"> Posicionar3(); </script>';	
?>

<?php include("../principal/pie_pagina.php")?>  
</form>

</body>
</html>

<?php include("../principal/cerrar_sec_web.php") ?>
<?php
	if (isset($mensaje) and ($mensaje != ""))
		echo '<script language="JavaScript"> alert("'.$mensaje.'") </script>';
		
	if (($encontro_ie == "N") and ($recargapag3 == "S"))
		echo '<script language="JavaScript"> alert("La I.E No Existe ó No Esta En Estado Para Ingresar Paquetes") </script>';
?>
