<?php
	include("../principal/conectar_principal.php");  
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 16;
	$CookieRut= $_COOKIE["CookieRut"];

	if(isset($_REQUEST["recargapag"])) {
		$recargapag = $_REQUEST["recargapag"];
	}else{
		$recargapag =  "";
	}
	if(isset($_REQUEST["verificatabla"])) {
		$verificatabla = $_REQUEST["verificatabla"];
	}else{
		$verificatabla =  "";
	}
	if(isset($_REQUEST["agregafila"])) {
		$agregafila = $_REQUEST["agregafila"];
	}else{
		$agregafila =  "";
	}
	if(isset($_REQUEST["numero"])) {
		$numero = $_REQUEST["numero"];
	}else{
		$numero =  "";
	}
	if(isset($_REQUEST["parametros"])) {
		$parametros = $_REQUEST["parametros"];
	}else{
		$parametros =  "";
	}
	if(isset($_REQUEST["buscar"])) {
		$buscar = $_REQUEST["buscar"];
	}else{
		$buscar =  "";
	}
	if(isset($_REQUEST["mostrar"])) {
		$mostrar = $_REQUEST["mostrar"];
	}else{
		$mostrar =  "";
	}
	if(isset($_REQUEST["txtbuscar"])) {
		$txtbuscar = $_REQUEST["txtbuscar"];
	}else{
		$txtbuscar =  "";
	}
	if(isset($_REQUEST["txthornada"])) {
		$txthornada = $_REQUEST["txthornada"];
	}else{
		$txthornada =  "";
	}
	
	if(isset($_REQUEST["textfield"])) {
		$textfield = $_REQUEST["textfield"];
	}else{
		$textfield =  "";
	}
	
	if(isset($_REQUEST["cmbhornada"])) {
		$cmbhornada = $_REQUEST["cmbhornada"];
	}else{
		$cmbhornada =  "";
	}

	if(isset($_REQUEST["recup1"])) {
		$recup1 = $_REQUEST["recup1"];
	}else{
		$recup1 =  "";
	}
	if(isset($_REQUEST["recup2"])) {
		$recup2 = $_REQUEST["recup2"];
	}else{
		$recup2 =  "";
	}
	if(isset($_REQUEST["recup3"])) {
		$recup3 = $_REQUEST["recup3"];
	}else{
		$recup3 =  "";
	}
	if(isset($_REQUEST["recup4"])) {
		$recup4 = $_REQUEST["recup4"];
	}else{
		$recup4 =  "";
	}

	if(isset($_REQUEST["recha1"])) {
		$recha1 = $_REQUEST["recha1"];
	}else{
		$recha1 =  "";
	}
	if(isset($_REQUEST["recha2"])) {
		$recha2 = $_REQUEST["recha2"];
	}else{
		$recha2 =  "";
	}
	if(isset($_REQUEST["recha3"])) {
		$recha3 = $_REQUEST["recha3"];
	}else{
		$recha3 =  "";
	}
	if(isset($_REQUEST["recha4"])) {
		$recha4 = $_REQUEST["recha4"];
	}else{
		$recha4 =  "";
	}

	if(isset($_REQUEST["prod1"])) {
		$prod1 = $_REQUEST["prod1"];
	}else{
		$prod1 =  "";
	}
	if(isset($_REQUEST["prod2"])) {
		$prod2 = $_REQUEST["prod2"];
	}else{
		$prod2 =  "";
	}
	if(isset($_REQUEST["prod3"])) {
		$prod3 = $_REQUEST["prod3"];
	}else{
		$prod3 =  "";
	}
	if(isset($_REQUEST["prod4"])) {
		$prod4 = $_REQUEST["prod4"];
	}else{
		$prod4 =  "";
	}
	

	if(isset($_REQUEST["dia1"])) {
		$dia1 = $_REQUEST["dia1"];
	}else{
		$dia1 =  date("d");
	}
	if(isset($_REQUEST["mes1"])) {
		$mes1 = $_REQUEST["mes1"];
	}else{
		$mes1 =  date("m");
	}
	if(isset($_REQUEST["ano1"])) {
		$ano1 = $_REQUEST["ano1"];
	}else{
		$ano1 =  date("Y");
	}

	if(isset($_REQUEST["dia2"])) {
		$dia2 = $_REQUEST["dia2"];
	}else{
		$dia2 =  date("d");
	}
	if(isset($_REQUEST["mes2"])) {
		$mes2 = $_REQUEST["mes2"];
	}else{
		$mes2 =  date("m");
	}
	if(isset($_REQUEST["ano2"])) {
		$ano2 = $_REQUEST["ano2"];
	}else{
		$ano2 =  date("Y");
	}
	if(isset($_REQUEST["hr1"])) {
		$hr1 = $_REQUEST["hr1"];
	}else{
		$hr1 =  date("H");
	}
	if(isset($_REQUEST["mm1"])) {
		$mm1 = $_REQUEST["mm1"];
	}else{
		$mm1 =  date("i");
	}

	if(isset($_REQUEST["hr2"])) {
		$hr2 = $_REQUEST["hr2"];
	}else{
		$hr2 =  date("H");
	}
	if(isset($_REQUEST["mm2"])) {
		$mm2 = $_REQUEST["mm2"];
	}else{
		$mm2 =  date("i");
	}

	if(isset($_REQUEST["mensaje"])) {
		$mensaje = $_REQUEST["mensaje"];
	}else{
		$mensaje =  "";
	}


	$consulta ="SELECT * FROM proyecto_modernizacion.sistemas_por_usuario WHERE rut = '".$CookieRut."'";	
	$rs = mysqli_query($link, $consulta); 
	$Acceso="S";
	if($row = mysqli_fetch_array($rs))
	{
		if($row["nivel"] != 1 && $row["nivel"] != 2)
		{
			$Acceso = 'N';
		}
	}	
	//$cmbhornada = substr($cmbhornada, 1);
	//echo "HORNADAI:".$cmbhornada;
	//$cmbhornada = substr($cmbhornada, 0, -2);
	//echo "HORNADAF:".$cmbhornada;


	
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">
function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
			Valores = "v";
	}
	return Valores;
}
/*********************/
function ValidaFilas(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";	
		
/*	for(i=0; i< LargoForm; i++)
	{
		alert(i+ '  '+f.elements[i].name);
	}	
*/		
	i = 31; //numero de elemento, en el que se ubica el checkbox.	
	if (f.elements[i].name == Nombre)
	{
		while ((i < LargoForm) && (f.elements[i].name == Nombre))
		{
			j = i;
			if (f.elements[j].checked) //Verifica si el checkbox esta marcado
				Valores = Valores + 1 + '-'; //Marcado
			else 
				Valores = Valores + 0 + '-'; //No marcado
			
			j++;
			Valores = Valores + f.elements[j].value + '-'; //Select del tipo de defecto
			j++;

			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '-';
			else
				Valores = Valores + f.elements[j].value + '-'; //text rueda1, recuperables
			j++;
			
			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '-';
			else
				Valores = Valores + f.elements[j].value + '-'; // text rueda2, recuperables
			j++;
			
			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '-';
			else
				Valores = Valores + f.elements[j].value + '-'; // text H.M, recuperables
			j++;
			
			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '-';
			else
				Valores = Valores + f.elements[j].value + '-'; // text total, recuperables
			j++;
			
			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '-';
			else
				Valores = Valores + f.elements[j].value + '-'; // text rueda1, rechazados
			j++;
			
			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '-';
			else
				Valores = Valores + f.elements[j].value + '-'; // text rueda2, rechazados
			j++;
			
			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '-';
			else
				Valores = Valores + f.elements[j].value + '-'; // text H.M, rechazados
			j++;
			
			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '/';
			else
				Valores = Valores + f.elements[j].value + '/'; // text total, rechazados																								
			i = i + 10;
		}
	}
	return Valores;
}
/*******************/
function Agregar(f)
{	
	if (f.cmbhornada.value == -1)
	{
		alert("Debe Seleccionar la Hornada");
		return;
	}
	else
	{
		parametros = ValidaFilas(f,'checkbox');
		if (isNaN(parseInt(f.filas.value)))
			filas = 1;
		else
			filas = parseInt(f.filas.value) + 1;
	
		linea = "recargapag=S&verificatabla=S&agregafila=S&numero=" + filas + "&parametros=" + parametros + "&buscar=S&mostrar=S";
		linea = linea + "&cmbhornada=" + f.cmbhornada.value + "&ano1=" + f.ano1.value + "&mes1=" + "&dia1=" + f.dia1.value;
		linea = linea + "&hr1=" + f.hr1.value + "&mm1=" + f.mm1.value + "&ano2=" + f.ano2.value + "&mes2=" + f.mes2.value + "&dia2=" + f.dia2.value; 
		linea = linea + "&hr2=" + f.hr2.value + "&mm2=" + f.mm2.value;
		linea = linea + "&recup4=" + f.recup4.value + "&recha4=" + f.recha4.value + "&prod4=" + f.prod4.value;
		f.action = "sea_ing_rechazos_anodos_ven.php?" + linea;
		f.submit();
	}
}
/*******************/
function ValidaCampos(f)
{
	if (f.cmbhornada.value == -1)
	{
		alert("Debe Seleccionar la Hornada");		
		return false;
	}

/*********/
	if (isNaN(parseInt(f.prod1.value)))
		valor1 = 0
	else 
		valor1 = parseInt(f.prod1.value);
		
		
	if (!isNaN(parseInt(f.prod2.value)))
		valor1 = valor1 + parseInt(f.prod2.value);

	if (!isNaN(parseInt(f.prod3.value)))
		valor2 = parseInt(f.prod3.value);			
	else 
		valor2 = 0;

	if (valor1 != parseInt(f.unid_cor.value))
	{
		alert("La Produccion de la Ruedas No es Valida");
		return false;
	}
	
	if (valor2 != parseInt(f.unid_hm.value))
	{
		alert("La Produccion de H.M. No es Valida");
		return false;
	}

/********/
	

	valores = ValidaFilas(f,'checkbox'); //Valida si hay alguna fila.
	if (valores == "")
	{
		alert("No Hay detalle a Ingresar");
		return false;
	}
	
	arreglo1 = valores.split('/') // Valida si algun tipo de defecto no esta seleccionado.
	for (i=0; i < arreglo1.length - 1; i++)
	{
		arreglo2 = arreglo1[i].split('-');
		if (arreglo2[1] == 'R')
		{
			alert("Debe Seleccionar el Tipo de Defecto");
			return false;
		}
	}
	
	return true;
}
/******************/
function Grabar(f)
{
	if (ValidaCampos(f))
	{
		parametros = ValidaFilas(f,'checkbox');
		parametros = parametros.substring(0,parametros.length - 1);
		
		linea = "proceso=G&parametros=" + parametros;
		linea = linea + "&recup4=" + f.recup4.value + "&recha4=" + f.recha4.value + "&prod4=" + f.prod4.value;
		f.action = "sea_ing_rechazos_anodos_ven01.php?" + linea; 
		f.submit();		
	}
}
/*******************/
function Borrar(f)
{
	if (f.filas.value == 0)
		return;
		
	if (ValidaSeleccion(f,'checkbox') == "")
	{
		alert("Debe Seleccionar una Casilla");
		return;
	}
		
	filas = parseInt(f.filas.value);
	if (filas != 0)
	{
		parametros = ValidaFilas(f,'checkbox');

		linea = "recargapag=S&verificatabla=S&agregafila=N&numero=" + filas + "&parametros=" + parametros + "&buscar=S&mostrar=S";;
		linea = linea + "&recup4=" + f.recup4.value + "&recha4=" + f.recha4.value + "&prod4=" + f.prod4.value;
		f.action = "sea_ing_rechazos_anodos_ven.php?" + linea;
		f.submit();
	}
}
/******************/
function Calcular(f,Nombre)
{
	var LargoForm = f.elements.length;	
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == Nombre)
		{				
			var r1 = parseInt(document.frm1.elements[i].value);
			if (isNaN(r1))
				r1 = 0;
				
			var r2 = parseInt(document.frm1.elements[i+1].value);
			if (isNaN(r2))
				r2 = 0;
			
			var hm = parseInt(document.frm1.elements[i+2].value);
			if (isNaN(hm))	
				hm = 0;
				
			total = r1 + r2 + hm;
			document.frm1.elements[i+3].value = total;										
		}
	}
}
/*************************/
function Verifica(f,t)
{
	if (parseInt(t.value) < 0)	
	{
		alert("El Valor No Es Valido")
		t.focus();
		return;
	}
	else
		Calcular(f,'var');
}
/***********************/
function Limpiar()
{
	document.location = "sea_ing_rechazos_anodos_ven.php";
}
/******************/
function Verifica2(f,t)
{
	if (parseInt(t.value) < 0)	
	{
		alert("El Valor No Es Valido");
		t.focus();
		return;
	}
	else
	{
		if ((t.name == 'recup1') || (t.name == 'recup2') || (t.name == 'recup3'))
			Calcular(f,'recup1');
		else if ((t.name == 'recha1') || (t.name == 'recha2') || (t.name == 'recha3'))
				Calcular(f,'recha1');
			else if ((t.name == 'prod1') || (t.name == 'prod2') || (t.name == 'prod3'))
					Calcular(f,'prod1');
	}
}
/****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=15";
}
/**************/
function Buscar(f)
{
	f.action = "sea_ing_rechazos_anodos_ven.php?buscar=S&txtbuscar=" + f.txtbuscar.value;
	f.submit();

}
/**************/
function BuscarRechazo(f)
{
	//alert(f.cmbhornada.value);
	//if (f.cmbhornada.value != -1){
		f.action = "sea_ing_rechazos_anodos_ven01.php?proceso=B";
	//}else{
	//	f.actino = "sea_ing_rechazos_anodos_ven.php?buscar=S&txtbuscar=" + f.txtbuscar.value;
	//}
	f.submit();
}
/***************/
function Eliminar(f)
{
	if (f.cmbhornada.value == -1)
	{
		alert("Debe Seleccionar una Hornada");
		return;
	}
	if (confirm("Esta Seguro que Quiere Eliminar los Rechazos Asociados a esta Hornada"))
	{
		f.action = "sea_ing_rechazos_anodos_ven01.php?proceso=E";
		f.submit();
	}
}
</script>
</head>

<body leftmargin="3" topmargin="5">
<?php
	if ($mensaje!="")
		echo '<script langueage="JavaScript"> alert("'.$mensaje.'") </script>';
?>

<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" background="../principal/imagenes/fondo3.gif" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">

<table width="750" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td height="20">Fecha Inicio</td>
            <td colspan="3"> <select name="dia1" size="1" id="dia1">
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{	
						if (($recargapag == "S") && ($i == $dia1))			
							echo '<option selected value="'.$i.'">'.$i.'</option>';				
						//else if (($i == date("d")) and ($recargapag != "S")) 
						else if (($i == $dia1) and ($recargapag != "S")) 
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else					
							echo '<option value="'.$i.'">'.$i.'</option>';												
					}		
				?>
              </select> <select name="mes1" size="1" id="select">
                <?php
					for($i=1;$i<13;$i++)
					{
						if (($recargapag == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						//else if (($i == date("m")) && ($recargapag != "S"))
						else if (($i == $mes1) && ($recargapag != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';			
					}		  
				?>
              </select> <select name="ano1" size="1" id="ano1">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($recargapag == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						//else if (($i == date("Y")) && ($recargapag != "S"))
						else if (($i == $ano1) && ($recargapag != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else	
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select> </td>
            <td width="101">Hora Inicio</td>
            <td width="129"><select name="hr1" id="select5">
                <?php
					for($i=0; $i<=23; $i++)
					{
						if (($recargapag == "S") && ($i == $hr1))
							echo '<option selected value ="'.$i.'">'.$i.'</option>';
						else if (($i == date("H")) && ($recargapag != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else	
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select>
              : 
              <select name="mm1" id="select6">
                <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($recargapag == "S") && ($i == $mm1))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($recargapag != "S"))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
              </select></td>
            <td>&nbsp; </td>
          </tr>
          <tr> 
            <td width="105">Fecha Termino</td>
            <td colspan="3"> <select name="dia2" size="1" id="dia2">
                <?php
					for ($i=1; $i<=31; $i++)
					{	
						if (($recargapag == "S") && ($i == $dia2))			
							echo '<option selected value="'.$i.'">'.$i.'</option>';				
						//else if (($i == date("d")) and ($recargapag != "S"))
						else if (($i == $dia2) and ($recargapag != "S")) 
								echo '<option selected value="'.$i.'">'.$i.'</option>';											
						else					
							echo '<option value="'.$i.'">'.$i.'</option>';
					}		
				?>
              </select> <select name="mes2" size="1" id="select4">
                <?php
					for($i=1; $i<13; $i++)
					{
						if (($recargapag == "S") && ($i == $mes2))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						//else if (($i == date("m")) && ($recargapag != "S"))
						else if (($i == $mes2) && ($recargapag != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';			
					}		  
				?>
              </select> <select name="ano2" size="1" id="ano2">
                <?php
					for ($i=date("Y")-1; $i<=date("Y")+1; $i++)
					{
						if (($recargapag == "S") && ($i == $ano2))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						//else if (($i == date("Y")) && ($recargapag != "S"))
						else if (($i == $ano2) && ($recargapag != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else	
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select> </td>
            <td>Hora Termino</td>
            <td><select name="hr2" id="select7">
                <?php
		 	for($i=0; $i<24; $i++)
			{
				if (($recargapag == "S") && ($i == $hr2))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($recargapag != "S"))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
              </select>
              : 
              <select name="mm2" id="select8">
                <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($recargapag == "S") && ($i == $mm2))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($recargapag != "S"))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
              </select></td>
            <td width="142">&nbsp; </td>
          </tr>
          <tr> 
            <td>Buscar Hornada</td>
            <td width="94"> 
              <?php
				echo '<input name="txtbuscar" type="text" id="txtbuscar" size="10">';
				echo '<input name="txthornada" type="hidden" value="'.$txtbuscar.'">';
			?>
              <input name="btnok" type="button" value="OK" onClick="JavaScript:Buscar(this.form)"></td>
            <td width="63">Hornadas</td>
            <td colspan="4">
				<select name="cmbhornada" onChange="JavaScript:BuscarRechazo(this.form)">
                <option value="-1">SELECCIONAR</option>
                <?php
					if ($buscar == "S")
					{
						include("../principal/conectar_sea_web.php");
						$consulta = "SELECT DISTINCT hornada_ventana FROM sea_web.hornadas WHERE cod_producto = 17 AND cod_subproducto in (4,8,11)";
//						if ($mostrar == "S")
						//$consulta = $consulta." AND hornada_ventana = '".$cmbhornada."' ";
//						else
							$consulta = $consulta." AND RIGHT(hornada_ventana,4) LIKE '".$txtbuscar."%' ORDER BY hornada_ventana ASC";
							//$consulta = $consulta." AND RIGHT(hornada_ventana,4) LIKE '".$txtbuscar."' ORDER BY hornada_ventana ASC";
						//echo "CONSULTA:".$consulta;
						$rs2 = mysqli_query($link, $consulta);
						while ($row2 = mysqli_fetch_array($rs2))
						{
							//echo "CMBHORMNADA:".$cmbhornada;
							//$cmbhornada = rtrim($cmbhornada,"'");
							//echo "<br>cmhornada:".$cmbhornada;

							if ($row2["hornada_ventana"] == $cmbhornada)
								echo '<option value="'.$row2["hornada_ventana"].'" selected>'.substr($row2["hornada_ventana"],6,4).'</option>';
							else
								echo '<option value="'.$row2["hornada_ventana"].'">'.substr($row2["hornada_ventana"],6,4).'</option>';
						}
						
						include("../principal/cerrar_sea_web.php");
					}
				?>
              </select>
			  	<?php
					if ($mostrar == "S")
	              		echo '<input name="textfield" type="text" size="10" value="'.substr($cmbhornada,4,2).'/'.substr($cmbhornada,0,4).'" disabled>';
					else 
						echo '<input name="textfield" type="text" size="10" value="" disabled>';
				?>
				</td>
          </tr>
        </table>
        <br>		
          <table width="500" border="0" cellspacing="0" cellpadding="3" class="ColorTabla01">
            <tr> 
              <td height="20" align="center">Producto</td>
              
            <td align="center">Unidades Producidas</td>
            </tr>
          </table>
        <table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="229">Anodos Corrientes</td>
            <td width="507" align="center">
			<?php
				include("../principal/conectar_sea_web.php");
				
				if ($mostrar == "S")
				{
					//$cmbhornada1 = substr($cmbhornada, 0, -1);
					$consulta = "SELECT * FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = 4 AND hornada_ventana = ".$cmbhornada;
					//echo "CONSULTA2: ".$consulta;
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs))
						echo '<input name="unid_cor" type="text" size="10" value="'.$row["unidades"].'" disabled>';
					else
						echo '<input name="unid_cor" type="text" size="10" value="0" disabled>';
				}
				else
					echo '<input name="unid_cor" type="text" size="10" value="0" disabled>';
					
				include("../principal/cerrar_sea_web.php");				
			?>
			</td>
          </tr>
          <tr> 
            <td>Anodos Hojas Madres</td>
            <td align="center">
			<?php
				include("../principal/conectar_sea_web.php");
				
				if ($mostrar == "S")
				{
					$consulta = "SELECT * FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = 8 AND hornada_ventana = ".$cmbhornada;
					$rs1 = mysqli_query($link, $consulta);
					if ($row1 = mysqli_fetch_array($rs1)) 
						echo '<input name="unid_hm" type="text" size="10" value="'.$row1["unidades"].'" disabled>';
					else 
						echo '<input name="unid_hm" type="text" size="10" value="0" disabled>';
				}
				else 
					echo '<input name="unid_hm" type="text" size="10" value="0" disabled>';
					
				include("../principal/cerrar_sea_web.php");
			?>
			</td>
          </tr>
        </table>
        <br>
        <br>
        <br>
        <div style="position:absolute; left: 161; top: 240px; width: 604px; height: 22px;">
        <table width="600" border="0" cellspacing="0" cellpadding="0" class="ColorTabla01">
          <tr> 
            <td width="148" height="20" align="center">Rueda N&deg; 1</td>
            <td width="148" align="center">Rueda N&deg; 2</td>
            <td width="147" align="center">Hojas Madres</td>
            <td width="147" align="center">Totales</td>
          </tr>
		</table>
		</div>

<table width="750" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">	  
          <tr> 
            <td height="20">Anodos Recuperables</td>
            <td align="center">
				<?php 
					if ($mostrar == "S")
						echo '<input name="recup1" type="text" value="'.$recup1.'" onBlur="JavaScritp:Verifica2(this.form,this)" size="10">';
					else 
						echo '<input name="recup1" type="text" value="" size="10">';
				?>
			</td>
            <td align="center">
				<?php 
					if ($mostrar == "S")
						echo '<input name="recup2" type="text" value="'.$recup2.'" onBlur="JavaScritp:Verifica2(this.form,this)" size="10">';
					else 
						echo '<input name="recup2" type="text" value="" size="10">'; 
				?>
			</td>
            <td align="center">
				<?php 
					if ($mostrar == "S")
						echo '<input name="recup3" type="text" value="'.$recup3.'" onBlur="JavaScritp:Verifica2(this.form,this)" size="10">';
					else 
						echo '<input name="recup3" type="text" value="" size="10">';
				?>
			</td>
            <td align="center">
				<?php 
					if ($mostrar == "S")
						echo '<input name="recup4" type="text" disabled value="'.$recup4.'" onBlur="JavaScritp:Verifica2(this.form,this)" size="10">';
					else 
						echo '<input name="recup4" type="text" disabled value="" size="10">';	
				?>
			</td>
          </tr>
          <tr>
            <td height="20">Anodos Rechazados</td>
            <td align="center">
			<?php 
				if ($mostrar == "S")
					echo '<input name="recha1" type="text" value="'.$recha1.'" onBlur="JavaScritp:Verifica2(this.form,this)" size="10">';
				else 
					echo '<input name="recha1" type="text" value="" size="10">'; 
			?></td>
            <td align="center">
			<?php 
				if ($mostrar == "S")
					echo '<input name="recha2" type="text" value="'.$recha2.'" onBlur="JavaScript:Verifica2(this.form,this)" size="10">';
				else
					echo '<input name="recha2" type="text" value="" size="10">';
			?></td>
            <td align="center">
			<?php 	
				if ($mostrar == "S")
					echo '<input name="recha3" type="text" value="'.$recha3.'" onBlur="JavaScript:Verifica2(this.form,this)" size="10">';
				else 
					echo '<input name="recha3" type="text" value="" size="10">';
			?></td>
            <td align="center">
			<?php 
				if ($mostrar == "S")
					echo '<input name="recha4" type="text" disabled value="'.$recha4.'" onBlur="JavaScript:Verifica2(this.form,this)" size="10">';
				else 
					echo '<input name="recha4" type="text" disabled value="" size="10">';
			 ?></td>
          </tr>
          <tr> 
            <td width="150" height="20">Total Produccion (Unidades)</td>
            <td width="150" align="center"> 
              	<?php 
			  		if ($mostrar == "S")
			  			echo '<input name="prod1" type="text" value="'.$prod1.'" size="10" onBlur="JavaScript:Verifica2(this.form,this)">';
					else 
						echo '<input name="prod1" type="text" value="" size="10">';						
				?>
            </td>
            <td width="150" align="center"> 
              	<?php 
			  		if ($mostrar == "S")
						echo '<input name="prod2" type="text" value="'.$prod2.'" size="10" onBlur="JavaScript:Verifica2(this.form,this)">';
					else 
						echo '<input name="prod2" type="text" value="" size="10">';
				?>
            </td>
            <td width="150" align="center"> 
              	<?php 
			  		if ($mostrar == "S")
			  			echo '<input name="prod3" type="text" value="'.$prod3.'" size="10" onBlur="JavaScript:Verifica2(this.form,this)">';
					else 
						echo '<input name="prod3" type="text" value="" size="10">';
				?>
            </td>
            <td width="150" align="center"> 
              <?php echo '<input name="prod4" type="text" value="'.$prod4.'" size="10" disabled>' ?>
            </td>
          </tr>
        </table>
        <br>
        <table width="751" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><input name="btnagregar" type="button" value="Agregar Detalle" style="width:100" onClick="JavaScript:Agregar(this.form)"> 
              <input name="btnborrar" type="button" value="Eliminar Detalle" style="width:100" onClick="JavaScript:Borrar(this.form)"></td>
          </tr>
        </table>
        <br>

<table width="750" border="1" cellspacing="0" cellpadding="3">
  <tr> 
            <td width="148" rowspan="2" align="center">Tipo Defecto&nbsp; </td>
    <td height="20" colspan="4" align="center">Recuperables</td>
    <td colspan="4" align="center">Rechazo</td>
  </tr>
  <tr> 
    <td width="67" height="20" align="center">Rueda 1</td>
    <td width="66" align="center">Rueda 2 </td>
    <td width="65" align="center">H. Madres</td>
    <td width="67" align="center">Total</td>
    <td width="65" align="center">Rueda1</td>
    <td width="65" align="center">Rueda 2 </td>
    <td width="65" align="center">H.Madres</td>
    <td width="68" align="center">Total</td>
  </tr>
</table><br> 
<?php  
	include("../principal/conectar_principal.php");
	
	if ($verificatabla == "S")
	{
		echo '<table width="750" border="1" cellspacing="0" cellpadding="0" class="ColorTabla02">';
    	$j = 0;
		$largo = strlen($parametros);
		while (($j < $numero) and ($largo != 0))
		{
			//Separa los parametros. (cod_defecto - recuperables - rechazos)
			for ($i=0; $i < $largo; $i++)
			{
				if (substr($parametros,$i,1) == "/")
				{				
					$valor = explode("-",substr($parametros,0,$i)); //checkbox - select - text - text.
																 
					$parametros = substr($parametros,$i+1);
					$i = 0;			

					if ($valor[0] == 0) //Si es 1, la fila fue eliminada.
					{
						//Genera las filas que ya fueron ingresadas.
					  	echo '<tr>';
				   		echo '<td width="155"><input type="checkbox" name="checkbox" value="checkbox">';
						echo '<select name="select">';
					    echo '<option value="R">SELECCIONAR</option>';

						$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2008 ORDER BY cod_clase";
						$rs = mysqli_query($link, $consulta);
						while ($row = mysqli_fetch_array($rs))
						{
							if ($row["cod_subclase"] == $valor[1])
							    echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
							else
						    	echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
	
						}
						echo '</select></td>';
			    		echo '<td width="72" align="center"><input type="text" name="var"  value="'.$valor[2].'" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
			    		echo '<td width="73" align="center"><input type="text" name="text" value="'.$valor[3].'" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
				   		echo '<td width="73" align="center"><input type="text" name="text" value="'.$valor[4].'" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
	    				echo '<td width="76" align="center"><input type="text" name="text" value="'.$valor[5].'" size="8" disabled></td>';
    					echo '<td width="73" align="center"><input type="text" name="var"  value="'.$valor[6].'" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
    					echo '<td width="73" align="center"><input type="text" name="text" value="'.$valor[7].'" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
			    		echo '<td width="73" align="center"><input type="text" name="text" value="'.$valor[8].'" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
					    echo '<td width="76" align="center"><input type="text" name="text" value="'.$valor[9].'" size="8" disabled></td>';
					    echo '</tr>';					
					}				
					else 
						$numero = $numero - 1;
				}			
			}
			$j++;
	  	}
		if ($agregafila == "S")
		{
			//Genra la fila nueva.
		  	echo '<tr>';
    		echo '<td width="155"><input type="checkbox" name="checkbox" value="checkbox">';
			echo '<select name="select">';
		    echo '<option value="R">SELECCIONAR</option>';
		
			$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2008 ORDER BY cod_clase";
			$rs1 = mysqli_query($link, $consulta);
			while ($row1 = mysqli_fetch_array($rs1))
			{
			    echo '<option value="'.$row1["cod_subclase"].'">'.$row1["nombre_subclase"].'</option>';
			}		
			echo '</select></td>';

    		echo '<td width="72" align="center"><input type="text" name="var"  size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
    		echo '<td width="73" align="center"><input type="text" name="text" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
    		echo '<td width="73" align="center"><input type="text" name="text" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
    		echo '<td width="76" align="center"><input type="text" name="text" size="8" disabled></td>';
    		echo '<td width="73" align="center"><input type="text" name="var"  size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
    		echo '<td width="73" align="center"><input type="text" name="text" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
    		echo '<td width="73" align="center"><input type="text" name="text" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
		    echo '<td width="76" align="center"><input type="text" name="text" size="8" disabled></td>';
			echo '</tr>';
		}  
		echo '</table><br>';	
	}
	
	include("../principal/cerrar_principal.php");
?>
        <?php
	//Campo Oculto.
	//Guarda la cantidas de filas.

	echo '<input type="hidden" name="filas" value="'.$numero.'">';
?>
        <table width="750" border="0" cellspacing="0" cellpadding="3">
    <tr> 
      <td align="center"><input name="btngrabar" type="button" value="Grabar" style="width:60" onClick="JavaScript:Grabar(this.form)"> 
        <?php
			if($Acceso != "N")
				echo '<input name="btneliminar" type="button"  value="Eliminar" style="width:60" onClick="JavaScript:Eliminar(this.form)">';
		?>
              <input name="btnlimpiar" type="button"  value="Limpiar" style="width:60" onClick="JavaScript:Limpiar()">
              <input name="btnsalir" type="button" style="width:60" value="Salir" onClick="JavaScript:Salir()"></td>
    </tr>
  </table>
    
</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>    
</form>
</body>
</html>
