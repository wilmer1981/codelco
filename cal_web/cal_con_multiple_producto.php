<?php 

if(isset($_REQUEST["Opcion"])) {
	$Opcion = $_REQUEST["Opcion"];
}else{
	$Opcion =  "";
}
if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar =  "";
}
if(isset($_REQUEST["Enabal"])) {
	$Enabal = $_REQUEST["Enabal"];
}else{
	$Enabal =  "";
}
if(isset($_REQUEST["Leyes"])) {
	$Leyes = $_REQUEST["Leyes"];
}else{
	$Leyes =  "";
}
if(isset($_REQUEST["CodLeyes"])) {
	$CodLeyes = $_REQUEST["CodLeyes"];
}else{
	$CodLeyes =  "";
}
if(isset($_REQUEST["CmbProductos"])) {
	$CmbProductos = $_REQUEST["CmbProductos"];
}else{
	$CmbProductos =  "";
}
if(isset($_REQUEST["CmbSubProducto"])) {
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
}else{
	$CmbSubProducto =  "";
}
if(isset($_REQUEST["CmbPeriodo"])) {
	$CmbPeriodo = $_REQUEST["CmbPeriodo"];
}else{
	$CmbPeriodo =  "";
}
if(isset($_REQUEST["CmbTipo"])) {
	$CmbTipo = $_REQUEST["CmbTipo"];
}else{
	$CmbTipo =  "";
}
if(isset($_REQUEST["CmbTipoAnalisis"])) {
	$CmbTipoAnalisis = $_REQUEST["CmbTipoAnalisis"];
}else{
	$CmbTipoAnalisis =  "";
}
if(isset($_REQUEST["TxtLeyes"])) {
	$TxtLeyes = $_REQUEST["TxtLeyes"];
}else{
	$TxtLeyes =  "";
}
if(isset($_REQUEST["RadioEnabal"])) {
	$RadioEnabal = $_REQUEST["RadioEnabal"];
}else{
	$RadioEnabal =  "";
}
if(isset($_REQUEST["TxtProducto"])) {
	$TxtProducto = $_REQUEST["TxtProducto"];
}else{
	$TxtProducto =  "";
}
if(isset($_REQUEST["TxtSubProducto"])) {
	$TxtSubProducto = $_REQUEST["TxtSubProducto"];
}else{
	$TxtSubProducto =  "";
}
if(isset($_REQUEST["LeyesSola"])) {
	$LeyesSola = $_REQUEST["LeyesSola"];
}else{
	$LeyesSola =  "";
}
if(isset($_REQUEST["TxtProSubPro"])) {
	$TxtProSubPro = $_REQUEST["TxtProSubPro"];
}else{
	$TxtProSubPro =  "";
}
	




if(isset($_REQUEST["CmbDias"])) {
	$CmbDias = $_REQUEST["CmbDias"];
}else{
	$CmbDias =  date("d");
}
if(isset($_REQUEST["CmbMes"])) {
	$CmbMes = $_REQUEST["CmbMes"];
}else{
	$CmbMes =  date("m");
}
if(isset($_REQUEST["CmbAno"])) {
	$CmbAno = $_REQUEST["CmbAno"];
}else{
	$CmbAno =  date("Y");
}


if(isset($_REQUEST["CmbDiasT"])) {
	$CmbDiasT = $_REQUEST["CmbDiasT"];
}else{
	$CmbDiasT =  date("d");
}
if(isset($_REQUEST["CmbMesT"])) {
	$CmbMesT = $_REQUEST["CmbMesT"];
}else{
	$CmbMesT =  date("m");
}
if(isset($_REQUEST["CmbAnoT"])) {
	$CmbAnoT = $_REQUEST["CmbAnoT"];
}else{
	$CmbAnoT =  date("Y");
}

if(isset($_REQUEST["Productito"])) {
	$Productito = $_REQUEST["Productito"];
}else{
	$Productito =  "";
}
if(isset($_REQUEST["SubProductito"])) {
	$SubProductito = $_REQUEST["SubProductito"];
}else{
	$SubProductito =  "";
}
if(isset($_REQUEST["SubProductito"])) {
	$SubProductito = $_REQUEST["SubProductito"];
}else{
	$SubProductito =  "";
}




if (($Opcion=='S')||($Opcion=='K'))
{
	$CmbProductos=46;
	$CmbSubProducto=1;

}
$CodigoDeSistema = 1;
$CodigoDePantalla = 20;

$CookieRut= $_COOKIE["CookieRut"];

include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Consulta ="SELECT nivel FROM proyecto_modernizacion.sistemas_por_usuario WHERE rut='".$CookieRut."' and cod_sistema =1";
$Respuesta = mysqli_query($link, $Consulta);
$Fila=mysqli_fetch_array($Respuesta);
$Nivel=$Fila["nivel"];
$Rut =$CookieRut;

?>
<html>
<head>
<title>Consulta Por Productos</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Proceso(Opcion,E)
{
	var frm=document.FrmConsulta;
	switch (Opcion)
	{
		case "R":
			frm.action="cal_con_multiple_producto.php?TxtProducto=" + frm.TxtProducto.value + "&TxtSubProducto=" + frm.TxtSubProducto.value + "&Enabal="+E;
			frm.submit();
			break;
		case "A":
			Asignar(E);
			break;
		case "S":
			Salir();
			break;
		case "G":
			Generar();
			break;	
		case "E":
			Eliminar(E);
			break;
	}
}	
function Recarga(E)
{
	var frm=document.FrmConsulta;
	if (frm.RadioEnabal.checked)
	{
		frm.action="cal_con_multiple_producto.php?TxtProducto=" + frm.TxtProducto.value + "&TxtSubProducto=" + frm.TxtSubProducto.value + "&LeyesSola=" + frm.TxtLeyesH.value + "&Enabal=S";
		frm.submit();
	}
	else
	{
		frm.action="cal_con_multiple_producto.php?TxtProducto=" + frm.TxtProducto.value + "&TxtSubProducto=" + frm.TxtSubProducto.value + "&LeyesSola=" + frm.TxtLeyesH.value;
		frm.submit();
	}
}
function Eliminar(E)
{
	var frm=document.FrmConsulta;
	var LargoForm = frm.elements.length;
	var ValoresSA="";
	var P="";
	var S="";
	var Producto="";
	var SubProducto="";
	var TxtProducto="";
	var TxtSubProducto="";
	for (i=0;i < LargoForm; i++)
	{ 	
		if ((frm.elements[i].name == "checkAtender") && (frm.elements[i].checked == true))
		{	
			Producto = frm.elements[i+1].value;
			SubProducto = frm.elements[i+2].value;
			P = frm.TxtProducto.value.split('-');
			S = frm.TxtSubProducto.value.split('-');
			Largo = P.length;
			frm.TxtProducto.value = "";
			frm.TxtSubProducto.value = "";
			frm.TxtProSubPro.value = "";
			for (j=0;j<Largo;j++)
			{
				if ((P[j] == Producto) && (S[j] == SubProducto))
				{
					//NADA
				} 
				else
				{
					if (P[j] != "")
						frm.TxtProducto.value = frm.TxtProducto.value + P[j] + "-";					
					if (S[j] != "")
						frm.TxtSubProducto.value = frm.TxtSubProducto.value + S[j] + "-";
					if (P[j] != "")
						frm.TxtProSubPro.value = frm.TxtProSubPro.value + P[j] + "~~" + S[j] + "//";
				}
			}
		}		
	}
	//para limpiar el hidden y no se caiga en la respuesta
	frm.TxtCodLeyes.value="";
	frm.TxtLeyesH.value="";
	
	frm.action="cal_con_multiple_producto.php?TxtProducto=" + frm.TxtProducto.value + "&TxtSubProducto=" + frm.TxtSubProducto.value + "&TxtProSubPro=" + frm.TxtProSubPro.value +  "&LeyesSola=" + frm.TxtLeyesH.value + "&Mostrar=S&Enabal="+E;
	frm.submit();
}
function Asignar(E)
{
	var frm=document.FrmConsulta;
	var P="";
	var S="";
	var Encontro=false;
	if (frm.CmbProductos.value == "-1")
	{
		alert ("Debe Seleccionar Producto");
		frm.CmbProductos.focus();
		return;
	}
	if (frm.CmbSubProducto.value == "-1")
	{
		alert ("Debe Seleccionar SubProducto");
		frm.CmbSubProducto.focus();
		return;
	}
	///////////////////
	P = frm.TxtProducto.value.split('-');
	S = frm.TxtSubProducto.value.split('-');
	Largo = P.length;
	for (j=0;j<Largo;j++)
	{
		if ((P[j] == frm.CmbProductos.value) && (S[j] == frm.CmbSubProducto.value))
		{
			alert("Este Producto fue ingresado");
			Encontro=true;
		} 
	}
	/////////////
	if (Encontro ==false)
	{
		if (frm.TxtProducto.value == "")
		{
			frm.TxtProducto.value = frm.CmbProductos.value;
			frm.TxtProSubPro.value = frm.CmbProductos.value + "~~";
		}
		else 
		{
			frm.TxtProducto.value = frm.TxtProducto.value + "-" + frm.CmbProductos.value;
			frm.TxtProSubPro.value = frm.TxtProSubPro.value + frm.CmbProductos.value + "~~";
		}	
		if (frm.TxtSubProducto.value == "")
		{
			frm.TxtSubProducto.value = frm.CmbSubProducto.value;
			frm.TxtProSubPro.value = frm.TxtProSubPro.value + frm.CmbSubProducto.value + "//";
		}
		else
		{
			frm.TxtSubProducto.value = frm.TxtSubProducto.value + "-" + frm.CmbSubProducto.value;
			frm.TxtProSubPro.value = frm.TxtProSubPro.value + frm.CmbSubProducto.value + "//";
		}
		frm.action="cal_con_multiple_producto.php?TxtProducto=" + frm.TxtProducto.value + "&TxtSubProducto=" + frm.TxtSubProducto.value + "&LeyesSola=" + frm.TxtLeyesH.value + "&Enabal="+E ;
		frm.submit();
	}
}
function Leyes()
{
	var frm=document.FrmConsulta;
	if (frm.CmbProductos.value == "-1")
	{
		alert ("Debe Seleccionar Producto");
		frm.CmbProductos.focus();
		return;
	}
	if (frm.CmbSubProducto.value == "-1")
	{
		alert ("Debe Seleccionar SubProducto");
		frm.CmbSubProducto.focus();
		return;
	}
	if (frm.CmbPeriodo.value == "-1")
	{
		alert ("Debe Seleccionar Periodo");
		frm.CmbPeriodo.focus();
		return;
	}
	FechaI=frm.CmbAno.value + "-" + frm.CmbMes.value + "-" + frm.CmbDias.value ;
	FechaT=frm.CmbAnoT.value + "-" + frm.CmbMesT.value + "-" + frm.CmbDiasT.value;
	var TotalDiasT=0;
	var CantDiasI=0;
	var CantDiasT=0;
	var TotalDiasI=0;
	var DifDias=0;
	var Mostrar =1;
	CantDiasI=365*parseInt(frm.CmbAno.value);
	TotalDiasI=parseInt(CantDiasI)+(31*parseInt(frm.CmbMes.value))+parseInt(frm.CmbDias.value);
	CantDiasT=365*parseInt(frm.CmbAno.value);
	TotalDiasT=CantDiasT+(31*parseInt(frm.CmbMesT.value))+parseInt(frm.CmbDiasT.value);
	DifDias=TotalDiasT-TotalDiasI;
	if (DifDias > 65)
	{
		alert("Rango de busqueda debe ser 2 meses aprox.")
		Mostrar=2;
		return;
	}
	if (frm.CmbAnoT.value==frm.CmbAno.value)
	{
		if ((frm.CmbMesT.value-frm.CmbMes.value)>2)
		{
			alert("El rango de fecha debe ser menor o igual a 2 meses");
			Mostrar=2;
			return;
		}
	}
	if (Mostrar == 1)
	{
		if (frm.RadioEnabal.checked)
		{
			window.open("cal_con_leyes_producto.php?ProSubPro="+frm.TxtProSubPro.value + "&Producto01="+frm.TxtProducto.value + "&SubProducto01=" + frm.TxtSubProducto.value+ "&Periodo=" + frm.CmbPeriodo.value + "&Tipo="+frm.CmbTipo.value + "&Analisis="+frm.CmbTipoAnalisis.value + "&FechaI="+FechaI + "&FechaT="+FechaT+ "&Producto=" + frm.CmbProductos.value +"&SubProducto=" + frm.CmbSubProducto.value +"&Dia=" + frm.CmbDias.value +"&Mes=" + frm.CmbMes.value+"&Ano=" + frm.CmbAno.value+"&DiaT=" + frm.CmbDiasT.value +"&MesT=" + frm.CmbMesT.value+"&AnoT=" + frm.CmbAnoT.value  +"&Enabal=S","","top=200,left=0,width=780,height=400,scrollbars=no,resizable = yes");								
		}
		else
		{
			window.open("cal_con_leyes_producto.php?ProSubPro="+frm.TxtProSubPro.value + "&Producto01="+frm.TxtProducto.value + "&SubProducto01=" + frm.TxtSubProducto.value+ "&Periodo=" + frm.CmbPeriodo.value + "&Tipo="+frm.CmbTipo.value + "&Analisis="+frm.CmbTipoAnalisis.value + "&FechaI="+FechaI + "&FechaT="+FechaT+ "&Producto=" + frm.CmbProductos.value +"&SubProducto=" + frm.CmbSubProducto.value +"&Dia=" + frm.CmbDias.value +"&Mes=" + frm.CmbMes.value+"&Ano=" + frm.CmbAno.value+"&DiaT=" + frm.CmbDiasT.value +"&MesT=" + frm.CmbMesT.value+"&AnoT=" + frm.CmbAnoT.value,"","top=200,left=0,width=780,height=400,scrollbars=no,resizable = yes");					
		}
	}
}
function Guardar(PS)
{
	var frm=document.FrmConsulta;
	var fila = 14; //Posicion Inicial de la Fila.
	var col = 2;
	var ProSubPro= "";
	pos = fila; //Posicion del Primer Checkbox del formulario + 1, (Indica la fila).
	largo = frm.elements.length;
	if (frm.RadioEnabal.checked)
	{
		window.open("cal_guardar_consulta.php?ProSubPro="+PS + "&Enabal=S","","top=200,left=175,width=410,height=230,scrollbars=no,resizable = no");	
	}
	else
	{
		window.open("cal_guardar_consulta.php?ProSubPro="+PS,"","top=200,left=175,width=410,height=230,scrollbars=no,resizable = no");		
	}
}
function VerConsulta()
{
	var frm=document.FrmConsulta;
	if (frm.RadioEnabal.checked)
	{
		window.open("cal_ver_consulta.php?Enabal=S","","top=50,left=50,width=700,height=300,scrollbars=yes,resizable = no");	
	}
	else
	{
		window.open("cal_ver_consulta.php","","top=50,left=50,width=700,height=300,scrollbars=yes,resizable = no");	
	}
	//frm.action="cal_guardar_consulta.php?ProSubPro="+frm.TxtProSubPro.value;
	//frm.submit();
}

function Salir()
{
	var frm=document.FrmConsulta;
	frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	frm.submit();
}
function Generar(Ley,Ena)//las leyes y enabal
{
	var frm=document.FrmConsulta;
	if (frm.CmbProductos.value == "-1")
	{
		alert ("Debe Seleccionar Producto");
		frm.CmbProductos.focus();
		return;
	}
	if (frm.CmbSubProducto.value == "-1")
	{
		alert ("Debe Seleccionar SubProducto");
		frm.CmbSubProducto.focus();
		return;
	}
	if (frm.CmbPeriodo.value == "-1")
	{
		alert ("Debe Seleccionar Periodo");
		frm.CmbPeriodo.focus();
		return;
	}
	if (frm.TxtLeyes.value == " ")
	{
		alert ("Debe Seleccionar Leyes");
		frm.BtnLeyes.focus();
		return;
	}
	if (Ley == " ")
	{
		alert ("Debe Seleccionar Leyes");
		frm.BtnLeyes.focus();
		return;
	}
	Periodo=frm.CmbPeriodo.value;
	FechaI=frm.CmbAno.value + "-" + frm.CmbMes.value + "-" + frm.CmbDias.value ;
	FechaT=frm.CmbAnoT.value + "-" + frm.CmbMesT.value + "-" + frm.CmbDiasT.value;
	Producto=frm.TxtProducto.value;
	SubProducto=frm.TxtSubProducto.value;
	CodLeyes=frm.TxtCodLeyes.value;
	AbrevLey=frm.TxtLeyesAbrev.value; 
	//alert(Ena);
	if (Ena=="S")
	{
		frm.action="cal_con_multiple_producto_respuesta.php?ProSubPro="+frm.TxtProSubPro.value + "&Periodo="+frm.CmbPeriodo.value + "&Tipo="+frm.CmbTipo.value + "&Analisis="+frm.CmbTipoAnalisis.value + "&Producto=" + frm.TxtProducto.value + "&SubProducto=" + frm.TxtSubProducto.value + "&FechaI=" +FechaI+ "&FechaT=" +FechaT + "&CodLeyes=" + frm.TxtCodLeyes.value + "&AbrevLey=" + frm.TxtLeyesAbrev.value + "&Enabal="+Ena ;
		frm.submit();
	}
	else
	{
	frm.action="cal_con_multiple_producto_respuesta.php?ProSubPro="+frm.TxtProSubPro.value + "&Periodo="+frm.CmbPeriodo.value + "&Tipo="+frm.CmbTipo.value + "&Analisis="+frm.CmbTipoAnalisis.value + "&Producto=" + frm.TxtProducto.value + "&SubProducto=" + frm.TxtSubProducto.value + "&FechaI=" +FechaI+ "&FechaT=" +FechaT + "&CodLeyes=" + frm.TxtCodLeyes.value + "&AbrevLey=" + frm.TxtLeyesAbrev.value;
	frm.submit();
	}
}
function Excel()
{
	var frm=document.FrmConsulta;
	if (frm.CmbProductos.value == "-1")
	{
		alert ("Debe Seleccionar Producto");
		frm.CmbProductos.focus();
		return;
	}
	if (frm.CmbSubProducto.value == "-1")
	{
		alert ("Debe Seleccionar SubProducto");
		frm.CmbSubProducto.focus();
		return;
	}
	if (frm.CmbPeriodo.value == "-1")
	{
		alert ("Debe Seleccionar Periodo");
		frm.CmbPeriodo.focus();
		return;
	}
	Periodo=frm.CmbPeriodo.value;
	Tipo=frm.CmbTipo.value;
	Analisis=frm.CmbTipoAnalisis.value;
	FechaI=frm.CmbAno.value + "-" + frm.CmbMes.value + "-" + frm.CmbDias.value ;
	FechaT=frm.CmbAnoT.value + "-" + frm.CmbMesT.value + "-" + frm.CmbDiasT.value;
	Producto=frm.TxtProducto.value;
	SubProducto=frm.TxtSubProducto.value;
	CodLeyes=frm.TxtCodLeyes.value;
	AbrevLey=frm.TxtLeyesAbrev.value; 
	if (frm.RadioEnabal.checked)
	{
		frm.action="cal_con_multiple_producto_respuesta_excel.php?ProSubPro="+frm.TxtProSubPro.value + "&Periodo="+frm.CmbPeriodo.value + "&Tipo="+frm.CmbTipo.value + "&Analisis="+frm.CmbTipoAnalisis.value + "&Producto=" + frm.TxtProducto.value + "&SubProducto=" + frm.TxtSubProducto.value + "&FechaI=" +FechaI+ "&FechaT=" +FechaT + "&CodLeyes=" + frm.TxtCodLeyes.value + "&AbrevLey=" + frm.TxtLeyesAbrev.value + "&Enabal=S";
		frm.submit();
	}
	else
	{
		frm.action="cal_con_multiple_producto_respuesta_excel.php?ProSubPro="+frm.TxtProSubPro.value + "&Periodo="+frm.CmbPeriodo.value + "&Tipo="+frm.CmbTipo.value + "&Analisis="+frm.CmbTipoAnalisis.value + "&Producto=" + frm.TxtProducto.value + "&SubProducto=" + frm.TxtSubProducto.value + "&FechaI=" +FechaI+ "&FechaT=" +FechaT + "&CodLeyes=" + frm.TxtCodLeyes.value + "&AbrevLey=" + frm.TxtLeyesAbrev.value;
		frm.submit();
	}
}
function Activar()
{
	
	var frm=document.FrmConsulta;
	var LargoForm = frm.elements.length;
	for (i=0; i< LargoForm; i++ )

	{
	if (frm.elements[i].name == "checkAtender") 
		{
			if (frm.checkTodos.checked == true)
			{
			frm.elements[i].checked = true;
			}
			else 
			{
			frm.elements[i].checked = false;		
			}
		}
	}
}

</script>
</head>
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="FrmConsulta" method="post" action="">
    <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="776"><font size="1"><font size="1"><font size="2"> </font></font></font> 
        <table width="758" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="5"><div align="center"></div></td>
          </tr>
          <tr> 
            <td colspan="2"><font size="1"><font size="2"> Producto&nbsp;&nbsp;&nbsp;&nbsp;</font><font size="1"><font size="2"><strong> 
              <select name="CmbProductos" style="width:250" onChange="Proceso('R','<?php echo $Enabal;  ?>');">
                <option value='-1' selected>Seleccionar</option>
                <?php 
					if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5')||($Nivel=='8'))
					{
						$Consulta="SELECT cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
					}
					else
					{
						$Consulta="SELECT cod_producto,descripcion from proyecto_modernizacion.productos  order by descripcion"; 
					}
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
						{
							echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
						else
						{
							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
					}
				?>
              </select>
              </strong></font></font><font size="2"><strong></strong></font></font></td>
            <td colspan="2"><div align="left"><font size="1"><font size="2"><font size="1"><font size="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></font></font></font></div>
              <font size="1"><font size="1"><font size="2">Sub Producto</font><font size="1"><font size="2"><strong>&nbsp;&nbsp;&nbsp; 
              <select name="CmbSubProducto" style="width:250">
                <option value="-1" selected>Seleccionar</option>
                <?php
				//Pregunta si el valor del Combo es 1 osea Productos mineros si es 1 despliega como proveedor
				if ($CmbProductos == '1')
				{
					if (($Nivel=='13')||($Nivel=='1')||($Nivel=='2')||($Nivel=='3')||($Nivel=='5'))
					{
						$Consulta="SELECT cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' and ((mostrar <> 16) or (mostrar <> 17)) "; 
					}
					else
					{
						if ($CmbProductos=='1')
						{
							$Consulta="SELECT cod_subproducto,descripcion from subproducto where cod_producto = '1' and cod_subproducto='92' "; 											
							//$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' and ((mostrar <> 16) or (mostrar <> 17)) "; 					
						}
						else
						{
							$Consulta="SELECT cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' and ((mostrar <> 16) or (mostrar <> 17)) "; 					
												
						}
					}
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
						{
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						}
						else
						{
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}	
					}
				}
				else
				{
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
						{
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						}
						else
						{
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}	
					}
				}
				?>
              </select>
              </strong></font></font></font></font></td>
            <td><div align="left"><font size="1"><font size="1"><font size="2"><font size="1"><font size="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input name="BtnOk2" type="button" id="BtnOk22" value="Ok" onClick="Proceso('A','<?php echo $Enabal;  ?>');"  >
                </font></font></font></font></font></font></div></td>
          </tr>
          <tr> 
            <td><font size="1"><font size="2"><strong> </strong></font><font size="1"><font size="1"><font size="2">Fecha 
              Inicio</font></font><font size="2"><strong> </strong>&nbsp;</font></font><font size="2"><strong> 
              </strong></font></font></td>
            <td><font size="1"><font size="2"><font size="2"> </font><font size="1"><font size="2"><font size="1"><font size="1"><font size="2"><strong> 
              </strong></font></font></font></font></font><font size="2"> 
              <select name="CmbDias" id="select" size="1" style="font-face:verdana;font-size:10">
                <?php
				
			for ($i=1;$i<=31;$i++)
			{
				if (isset($CmbDias))
				{
					if ($i==$CmbDias)
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}
				else
				{
					if ($i==date("j"))
					{
						echo "<option selected value= '".$i."'>".$i."</option>";
					}
					else
					{
					  echo "<option value='".$i."'>".$i."</option>";
					}
				}	
			  }
			?>
              </select>
              <select name="CmbMes" size="1" id="select2" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
		  for($i=1;$i<13;$i++)
		  {
				if (isset($CmbMes))
				{
					if ($i==$CmbMes)
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				
				}	
				else
				{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}
				}	
			}
		    ?>
              </select>
              <select name="CmbAno" size="1" id="select3" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (isset($CmbAno))
				{
					if ($i==$CmbAno)
						{
							echo "<option selected value ='".$i."'>".$i."</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}
				else
				{
					if ($i==date("Y"))
						{
							echo "<option selected value ='".$i."'>".$i."</option>";
						}
					else	
						{
							echo "<option value='".$i."'>".$i."</option>";
						}
				}		
			}
			
			?>
              </select>
              </font></font></font></td>
            <td><font size="1"><font size="1"><font size="2">Fecha Termino</font></font></font></td>
            <td width="250"><font size="1"><font size="1"><font size="2"> 
              <select name="CmbDiasT" id="select7" size="1" style="font-face:verdana;font-size:10">
                <?php
				for ($i=1;$i<=31;$i++)
				{
					if (isset($CmbDiasT))
					{
						if ($i==$CmbDiasT)
						{
							echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{
						  echo "<option value='".$i."'>".$i."</option>";
						}
					}
					else
					{
						if ($i==date("j"))
						{
							echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{
						  echo "<option value='".$i."'>".$i."</option>";
						}
					}	
				}
				?>
              </select>
              <select name="CmbMesT" size="1" id="select8" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
				  for($i=1;$i<13;$i++)
				  {
						if (isset($CmbMesT))
						{
							if ($i==$CmbMesT)
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						
						}	
						else
						{
							if ($i==date("n"))
							{
								echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
							}
							else
							{
								echo "<option value='$i'>".$meses[$i-1]."</option>\n";
							}
						}	
				   }
			   ?>
              </select>
              <select name="CmbAnoT" size="1" id="select9" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if (isset($CmbAnoT))
					{
						if ($i==$CmbAnoT)
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}
					else
					{
						if ($i==date("Y"))
							{
								echo "<option selected value ='$i'>$i</option>";
							}
						else	
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
					}		
				}
			?>
              </select>
              </font></font></font></td>
            <td width="61"><div align="center"><font size="1"><font size="1"><font size="2"><font size="1"><font size="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></font></font></font></font></font></div></td>
          </tr>
          <tr>
            <td><font size="1"><font size="2"><font size="1">Periodo</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></font></font></td>
            <td><font size="1"><font size="2"><font size="1"><font size="1"><font size="2"><strong> 
              <select name="CmbPeriodo" style="width:130" onChange="Recarga('<?php echo $Enabal;  ?>');">
                <option value ='-1' selected>Seleccionar</option>\n";
                
             	 
                <?php 
				$Consulta = "select * from sub_clase where cod_clase = 2 order by valor_subclase1";
				$Respuesta= mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Respuesta))
					{
						if($CmbPeriodo==$Fila["cod_subclase"])
						{
							echo "<option value = '".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";					
						}
						else
						{
							echo "<option value = '".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
						}
					}
				?>
              </select>
              </strong></font><font size="1"><font size="2"><font size="1"><font size="1"><font size="1"><font size="2">
              <?php
			//Reemplaza las abreviatura de la ley concatenadas con ~~ las reemplaza por - 			 
			 $Ley=str_replace("~~","-",$Leyes);
			 //corta el ultimo caracter - del string
			if ($Mostrar!='S')
			{
			 $LeyesSola=substr($Ley,0,strlen($Ley)-1);
			}
			 //Codleyes= contiene los coddigos de las leyes asociados  
			 //echo $CodLeyes."<br>";
			 ?>
              <!--Asigna el valor de la leyes concatenadas con ~~ al hidden para poder enviarlo al ola pag de genracion de la consulta       -->
              <input name="TxtCodLeyes" type="hidden" value="<?php echo $CodLeyes ?>">
              <!--Asigna el valor de las abreviaturas de las leyes concatenadas con ~~ al hidden para poder enviarlo al ola pag de genracion de la consulta       -->
              <input name="TxtLeyesAbrev" type="hidden" value="<?php echo $Leyes ?>">
              </font></font></font></font></font></font><font size="2"><strong> 
              </strong></font></font></font></font></font></td>
            <td><font size="1"><font size="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Enabal</font></font></font></td>
            <td colspan="2">
              <?php
				if ($Enabal=='S')
				{
					echo "<input name='RadioEnabal' type='checkbox' id='RadioEnabal' value='S' checked>";
              	}
				else
				{
					echo "<input name='RadioEnabal' type='checkbox' id='RadioEnabal' value='S' >";
				}	
				?>
            </td>
          </tr>
          <tr> 
            <td width="75"><font size="2">Tipo Muestreo</font></td>
            <td width="253">
			<select name='CmbTipo' style='width:110'>";
			<option value = '-1' selected>Todos</option>\n";
			<?php
			$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase=1005 order by cod_subclase";
			$Respuesta=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($Fila["cod_subclase"]== $CmbTipo)
				{
					echo "<option value =".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";				
				}
				else
				{
					echo "<option value =".$Fila["cod_subclase"].">".$Fila["nombre_subclase"]."</option>";
				}	
			}?>
			</select>
			</td>
            <td width="86"><div align="left"><font size="1"><font size="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font><font size="1"><font size="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Tipo 
                Analisis </font></font></font></font></font></div></td>
            <td colspan="2">
			 <select name='CmbTipoAnalisis' style='width:120'>";
    	    <option value = '-1' selected>Todos</option>\n";
			<?php
			$Consulta= "select * from sub_clase where cod_clase = 1000";
			$Respuesta= mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbTipoAnalisis == $Fila["cod_subclase"])
				{
					echo "<option value ='".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 			
				}
				else			
				{	
					if ($Fila["cod_subclase"]=='1')
					{
						echo "<option value ='".$Fila["cod_subclase"]."' >".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
					}
					else
					{
						echo "<option value ='".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n"; 
					}
				}
			}
			?>
			</select>
			</td>
          </tr>
          <tr> 
            <td><div align="left"><font size="1"><font size="1">Leyes </font></font></div></td>
            <td colspan="3"><font size="1"><font size="1"><font size="2"> </font><font size="2"> 
              </font></font><font size="1"><font size="2"><font size="1"><font size="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></font></font></font><font size="2"> </font><font size="1"><font size="1"><font size="1"><font size="2"> 
              <input name="TxtLeyes" type="text" id="TxtLeyes3" readonly style="width:600" value="<?php echo $LeyesSola; ?> ">
              <?php 
					$TxtLeyesS=$LeyesSola;
					//echo "leyes".$TxtLeyesS."<br>";
				?>
              <input name="TxtLeyesH" type="hidden" value="<?php echo $TxtLeyesS   ?>">
              <?php //echo "leyesoculta".$TxtLeyesH."<br>";   ?>
              </font></font></font></font><font size="2"> </font></font> <div align="center"><font size="1"><font size="1"> 
                </font></font> </div>
              <font size="1"><font size="1"> </font></font></td>
            <td><font size="1"><font size="1"> 
              <input name="BtnLeyes" type="button" id="Btn Leyes3" value="Leyes" onClick="Leyes('');">
              </font></font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="1"><font size="1"><font size="2"> </font><font size="1"><font size="2"> 
              </font></font><font size="2"><strong> </strong></font></font></font></td>
            <td><div align="center"><font size="1"><font size="1"> </font></font> 
              </div></td>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="758" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td width="20"><div align="left"><font size="1"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input name="checkTodos" type="checkbox" onClick="JavaScript:Activar();" value="checkbox">
                </font></font></font></div></td>
            <td width="352"><div align="center">Producto</div></td>
            <td width="360"><div align="center">Sub-Producto</div></td>
          </tr>
           <?php
			if ($Opcion=='S' )
			{
				$TxtProducto = $Productito;
				$TxtSubProducto = $SubProductito;
			}
			//elimina - en la variable y los asigna a un arreglo   
			$ArrayProducto = explode("-",$TxtProducto);
			$ArraySubProducto = explode("-",$TxtSubProducto);
			//cuenta los elementos del arreglo y los asigna a una variable 
			$LargoArray = count($ArrayProducto);
			//echo $LargoArray."<br>";
			for ($i = 0; $i < $LargoArray; $i++)
			{
				if(($ArrayProducto[$i]!="") && ($ArraySubProducto[$i]!=""))
				{
					echo "<tr>\n";
					$Consulta = "select descripcion from proyecto_modernizacion.productos where cod_producto =".$ArrayProducto[$i]." ";
					$Respuesta=mysqli_query($link, $Consulta); 
					if ($Fila=mysqli_fetch_array($Respuesta)) 
					{
						echo "<td><input type='checkbox' name ='checkAtender' value='".$CmbProductos.'-'.$CmbSubProducto."'></td>";
						echo "<td>".$Fila["descripcion"]."<input name='AP' type='hidden' value='".$ArrayProducto[$i]."'></td>";
					}
					$Consulta = "select descripcion as DesSubProducto from proyecto_modernizacion.subproducto where cod_producto =".$ArrayProducto[$i]." and cod_subproducto =".$ArraySubProducto[$i]." ";
					$Respuesta1=mysqli_query($link, $Consulta); 
					if($Fila1=mysqli_fetch_array($Respuesta1)) 
					{
						echo "<td>".$Fila1["DesSubProducto"]."<input name='ASP' type='hidden' value='".$ArraySubProducto[$i]."'></td>";	
					}	
					echo "</tr>\n";		
					//$ProdSub=$ProdSub.$ArrayProducto[$i].'~~'.$ArraySubProducto[$i].'//'; //desactivado WSO
					$ProdSub=$ArrayProducto[$i].'~~'.$ArraySubProducto[$i].'//';
				}
			}				
			//$help1=$TxtProducto;
			//$help2=$TxtSubProducto;
			?>
		   <input name="TxtProSubPro" type="hidden" value="<?php echo $ProdSub; ?>">
		   <input name="TxtProducto" type="hidden" value="<?php echo $TxtProducto; ?>">
		  
          <input name="TxtSubProducto" type="hidden" value="<?php echo $TxtSubProducto; ?>">
    	</table>
        <br>
        <table width="758" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="167"> <div align="center"> </div>
              <div align="center"> </div></td>
            <td width="476"><div align="center"> 
                <input name="BtnEliminar" type="button" id="BtnEliminar" value="Eliminar" style="width:60" onClick="Proceso('E','<?php echo $Enabal;  ?>');">
                &nbsp; 
                <input name="BtnConsulrat" type="button" id="BtnConsulrat" value="Generar" style="width:60" onClick="Generar('<?php echo $LeyesSola;  ?>','<?php echo $Enabal;  ?>');">
                &nbsp; 
                <input name="BtnExcel" type="button" id="BtnExcel" value="Excel" style="width:60" onClick="Excel('');">
                &nbsp; 
                <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:60" onClick="Proceso('S');">
                &nbsp;
                <input name="BtnGuardar" type="button" id="BtnGuardar" value="Guardar" onClick="Guardar('<?php echo $ProdSub;  ?>');">
                &nbsp; 
                <input name="BtnVer" type="button" id="BtnVer" value="Ver Consulta" onClick="VerConsulta();">
              </div></td>
            <td width="94">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
