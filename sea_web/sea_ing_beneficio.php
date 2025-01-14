<?php 
	include ("funciones.php");
 
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 4;
	$HoraAux=date('G');
	$MinAux=date('i');
	
	if(isset($_REQUEST["cmbtipo"])) {
		$cmbtipo = $_REQUEST["cmbtipo"];
	}else{
		$cmbtipo = "";
	}
	if(isset($_REQUEST["cmbgrupo"])) {
		$cmbgrupo = $_REQUEST["cmbgrupo"];
	}else{
		$cmbgrupo = "";
	}
	if(isset($_REQUEST["cmbproducto"])) {
		$cmbproducto = $_REQUEST["cmbproducto"];
	}else{
		$cmbproducto = "";
	}
	if(isset($_REQUEST["mostrar"])) {
		$mostrar = $_REQUEST["mostrar"];
	}else{
		$mostrar = "";
	}
	if(isset($_REQUEST["recargapag1"])) {
		$recargapag1 = $_REQUEST["recargapag1"];
	}else{
		$recargapag1 = "";
	}
	if(isset($_REQUEST["recargapag2"])) {
		$recargapag2 = $_REQUEST["recargapag2"];
	}else{
		$recargapag2 = "";
	}
	if(isset($_REQUEST["recargapag3"])) {
		$recargapag3 = $_REQUEST["recargapag3"];
	}else{
		$recargapag3 = "";
	}
	if(isset($_REQUEST["recargapag4"])) {
		$recargapag4 = $_REQUEST["recargapag4"];
	}else{
		$recargapag4 = "";
	}
	if(isset($_REQUEST["activa_fecha2"])) {
		$activa_fecha2 = $_REQUEST["activa_fecha2"];
	}else{
		$activa_fecha2 = "";
	}
	if(isset($_REQUEST["dia"])) {
		$dia = $_REQUEST["dia"];
	}else{
		$dia = date("d");
	}
	if(isset($_REQUEST["mes"])) {
		$mes = $_REQUEST["mes"];
	}else{
		$mes =  date("m");
	}
	if(isset($_REQUEST["ano"])) {
		$ano = $_REQUEST["ano"];
	}else{
		$ano =  date("Y");
	}
	if(isset($_REQUEST["Hora"])) {
		$Hora = $_REQUEST["Hora"];
	}else{
		$Hora = date("G");
	}
	if(isset($_REQUEST["Minutos"])) {
		$Minutos = $_REQUEST["Minutos"];
	}else{
		$Minutos = date("i");
	}

	if(isset($_REQUEST["cmbhornada"])) {
		$cmbhornada = $_REQUEST["cmbhornada"];
	}else{
		$cmbhornada = "";
	}

	if(isset($_REQUEST["unid_rech"])) {
		$unid_rech = $_REQUEST["unid_rech"];
	}else{
		$unid_rech = 0;
	}
	if(isset($_REQUEST["peso_rc"])) {
		$peso_rc = $_REQUEST["peso_rc"];
	}else{
		$peso_rc = 0;
	}
	if(isset($_REQUEST["peso_rech"])) {
		$peso_rech = $_REQUEST["peso_rech"];
	}else{
		$peso_rech = 0;
	}
	if(isset($_REQUEST["peso_faltante"])) {
		$peso_faltante = $_REQUEST["peso_faltante"];
	}else{
		$peso_faltante = "";
	}
	if(isset($_REQUEST["campo1"])) {
		$campo1 = $_REQUEST["campo1"];
	}else{
		$campo1 = "";
	}
	if(isset($_REQUEST["txtunidstock"])) {
		$txtunidstock = $_REQUEST["txtunidstock"];
	}else{
		$txtunidstock = "";
	}

	if(isset($_REQUEST["pesopromedio"])) {
		$pesopromedio = $_REQUEST["pesopromedio"];
	}else{
		$pesopromedio = "";
	}	
	//echo "PESO PROMEDIO:".$pesopromedio;
	if(isset($_REQUEST["dia2"])) {
		$dia2 = $_REQUEST["dia2"];
	}else{
		$dia2 = "";
	}
	if(isset($_REQUEST["mes2"])) {
		$mes2 = $_REQUEST["mes2"];
	}else{
		$mes2 = "";
	}
	if(isset($_REQUEST["ano2"])) {
		$ano2 = $_REQUEST["ano2"];
	}else{
		$ano2 = "";
	}
	if(isset($_REQUEST["unidad_raf"])) {
		$unidad_raf = $_REQUEST["unidad_raf"];
	}else{
		$unidad_raf = 0;
	}
	if(isset($_REQUEST["peso_raf"])) {
		$peso_raf = $_REQUEST["peso_raf"];
	}else{
		$peso_raf = 0;
	}

	if(isset($_REQUEST["txtunidsaldo"])) {
		$txtunidsaldo = $_REQUEST["txtunidsaldo"];
	}else{
		$txtunidsaldo = 0;
	}
	
	if($Hora=="")
	{
		if(intval($HoraAux)>=0&&intval($HoraAux)<8)
		{
			$Hora="07";
			$Minutos="59";
		}
		if(intval($HoraAux)>=8&&intval($HoraAux)<16)
		{
			$Hora="15";
			$Minutos="59";
		}
		if(intval($HoraAux)>=16&&intval($HoraAux)<=23)
		{
			$Hora="23";
			$Minutos="59";
		}
	}	
	
?>

<html>
<head>
<title>Sistema de Anodos</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">
function Recarga1(f)
{
	f.action = "sea_ing_beneficio.php?recargapag1=S&cmbtipo=" + f.cmbtipo.value;
	f.submit()	
}
/****************/
function Recarga2(f)
{
	parametros = "recargapag1=S&recargapag2=S&cmbtipo=" + f.cmbtipo.value + "&cmbproducto=" + f.cmbproducto.value;
	f.action = "sea_ing_beneficio.php?" + parametros;
	f.submit();
}
function Recarga4(f)
{
	if (f.cmbhornada.value == -1)
	{
		alert("Debe Seleccionar la Hornada");
		return;
	}
	
	parametros = "recargapag1=S&recargapag2=S&recargapag3=S&recargapag4=S&cmbtipo=" + f.cmbtipo.value + "&cmbproducto=" + f.cmbproducto.value;
	parametros = parametros + "&cmbgrupo=" + f.cmbgrupo.value + "&txtunidstock=" + f.txtunidstock.value + "&txtpesostock=" + f.txtpesostock.value;
	parametros = parametros + "&unid_rech=" + f.unid_rech.value;
	//alert (parametros);
	f.action = "sea_ing_beneficio.php?" + parametros;
	f.submit();	
}
/******************/
function Recarga5(f)
{
	if (f.checkbox.checked == true)	
	{
		parametros = "activa_fecha2=S";
		parametros = parametros + "&recargapag1=S&recargapag2=S&cmbtipo=" + f.cmbtipo.value + "&cmbproducto=" + f.cmbproducto.value;
		parametros = parametros + "&dia2=" + f.dia.value + "&mes2=" + f.mes.value + "&ano2=" + f.ano.value;		
		//alert (parametros);
		f.action = "sea_ing_beneficio.php?" + parametros;
		f.submit();		
	}
	else
	{
		parametros = "activa_fecha2=N";
		parametros = parametros + "&recargapag1=S&recargapag2=S&cmbtipo=" + f.cmbtipo.value + "&cmbproducto=" + f.cmbproducto.value;
		parametros = parametros + "&dia=" + f.dia.value + "&mes=" + f.mes.value + "&ano=" + f.ano.value;
		document.location = "sea_ing_beneficio.php?" + parametros;
	}
	

}
/******************/
function Buscar(f)
{
	if (f.cmbhornada.value != -1)
	{
		//alert ("por aca");
		f.action = "sea_ing_beneficio01.php?proceso=B";
		f.submit();
	}
	else 
	{
		parametros = "recargapag1=S&recargapag2=S&cmbtipo=" + f.cmbtipo.value + "&cmbproducto=" + f.cmbproducto.value;
		//alert (parametros);
		//alert (f.cmhornada.value);
		f.action = "sea_ing_beneficio.php?" + parametros;
		f.submit();
	}
	
}
/*****************/
function Buscar2(f)
{
	if (f.txthornada.value == "")
	{
		alert("Debe Ingrsar la Hornada")
		return;
	}
	else 
	{
		f.action = "sea_ing_beneficio01.php?proceso=B";
		f.submit();
	}		
}
/*******************/
function Calcula(f)
{
	var valor2 = 0;
	if (parseInt(f.txtunidbenef.value) == parseInt(f.txtunidstock.value))
		document.frmBeneficio.txtpesobenef.value = f.txtpesostock.value;
	else 
		document.frmBeneficio.txtpesobenef.value = Math.round(f.pesopromedio.value * f.txtunidbenef.value);
		
	if (parseInt(f.txtunidbenef.value) > parseInt(f.txtunidstock.value))	
	{
		valor2 = 1; 
		valor = 0
	}
	else  
		valor = (parseInt(f.txtunidstock.value) - parseInt(f.txtunidbenef.value));


	document.frmBeneficio.txtunidsaldo.value = valor;
	if (valor==0)
		document.frmBeneficio.txtpesosaldo.value = valor;
		else
		document.frmBeneficio.txtpesosaldo.value = parseInt(f.txtpesostock.value) - parseInt(f.txtpesobenef.value);

	if (valor2==0)
	{
		document.frmBeneficio.txtunidsaldor.value = f.unid_rech.value;
		document.frmBeneficio.txtpesosaldor.value = f.peso_rech.value;
	}
	else
	{
		valor2 = parseInt(f.txtunidbenef.value) - parseInt(f.txtunidstock.value);
		document.frmBeneficio.txtunidsaldor.value = f.unid_rech.value - valor2;
		document.frmBeneficio.txtpesosaldor.value = parseInt((f.unid_rech.value - valor2) * f.textfield.value);
	}
}
/******************/
function Verifica(f)
{
	if (f.txtunidbenef.value == "")
		return;
	
	var unidades = parseInt(f.txtunidbenef.value * 1);	//Unidades a Beneficiar.
	var tope_unidades = parseInt(f.txtunidstock.value * 1) + parseInt(f.unid_rech.value * 1); //Unidaes Tope (StockActual + StockRechazo);
	var diferencia = unidades - parseInt(f.txtunidstock.value * 1);

	if (!isNaN(unidades) && (unidades > 0) && (unidades <= tope_unidades))
	{
		if (f.cmbtipo.value == 2) //Valida las H.M. (Max. 42 Unidades)
		{
			if (unidades <= 34)
			{
				if (unidades > parseInt(f.txtunidstock.value))
					alert("Se Moveran " + diferencia + " Unidad(es) de las Rechazadas");

				Calcula(f);
			}
			else
			{
				alert("No Se Puede Beneficiar Sobre 34 Unidades");
				return;
			}
		}
		else //Valida Cttes. (Max. 756 Unidades) se cambia Max 819 por acercamiento de anodos
		{
		
			if (unidades <= 819)
			{	
				if (unidades > parseInt(f.txtunidstock.value))
					alert("Se Moveran " + diferencia + " Unidad(es) de las Rechazadas");
					 
				Calcula(f);
			}
			else
			{
				alert("No noo Se Puede Beneficiar Sobre 819 Unidades");
				return;
			}
		}	
	}
	else
	{ 
		alert("Cantidad a Beneficiar No es Valida");
		return;
	}
		
}
/*****************/
function Limpiar(f)
{
	document.location = "sea_ing_beneficio.php";
}
/****************/
function ValidaCampos(f)
{
	if (f.cmbtipo.value == -1)
	{
		alert("Debe Selecionar el Tipo de Anodo");
		return false;		 
	}
	
	if (f.cmbproducto.value == -1)
	{
		alert("Debe Seleccionar el Tipo de SubProducto");
		return false;		
	}
	
	if (f.cmbhornada.value == -1)
	{
		alert("Debe Seleccionar la Hornada");
		return false;		
	}
	
	if (f.cmbgrupo.value == -1)
	{
		alert("Debe Seleccionar el Grupo");
		return false;
	}
	
	if (f.cmbtipo.value == 2) //H.M.
	{
		if (f.campo1.value == -1)
		{	
			alert("Debe Seleccionar la Cuba");
			return false;
		}
	}
	else 
	{
		/*if(f.cmbgrupo.value==49&&f.campo1.value != -1)
		{
			alert("Grupo Seleccionado no Posee Lado Dejar en SELECCIONAR");
			return false;
		}*/
		//if (f.campo1.value == -1&&f.cmbgrupo.value!=49)
		if (f.campo1.value == -1)
		{
			alert("Debe Seleccionar Lado");
			return false;
		}
	}
	
	
	if (f.txtunidbenef.value == "")
	{	
		alert("Debe Ingresar las Unidades a Beneficiar");
		return false;
	}
	
	var unidades = parseInt(f.txtunidbenef.value * 1);	//Unidades a Beneficiar.
	var tope_unidades = parseInt(f.txtunidstock.value * 1) + parseInt(f.unid_rech.value * 1); //Unidaes Tope (StockActual + StockRechazo);
	if (isNaN(unidades) || (unidades <= 0) || (unidades > tope_unidades))
	{
		alert("Cantidad a Beneficiar No es Valida");
		return false;
	}
	
	if (f.cmbtipo.value == 2) //Valida las H.M. (Max. 42 Unidades)
	{
		if (unidades > 34)
		{
			alert("No Se Puede Beneficiar Sobre 34 Unidades");
			return false;
		}
	}
	else //Valida Cttes. (Max. 756 Unidades) se aumentan unidades por acercamiento de anodos
	{
		if (unidades > 819)
		{
			alert("Noooo Se Puede Beneficiar Sobre 777 Unidades");
			return false;
		}
	}	
	if(f.Hora.value=='S')
	{
		alert("Debe Seleccionar Hora Valida");
		return false;
	}
	if(f.Minutos.value=='S')
	{
		alert("Debe Seleccionar Minutos Validos");
		return false;
	}
	return true;
}
/***************/
function Grabar(f)
{
	if (ValidaCampos(f))
	{
		linea = "proceso=G&txtunidstock=" + f.txtunidstock.value + "&unid_rech=" + f.unid_rech.value;
		linea = linea + "&peso_benef=" + f.txtpesobenef.value + "&unidad_benef=" + f.txtunidbenef.value;
		//alert (linea);
		f.action = "sea_ing_beneficio01.php?" + linea;
		f.submit();
	}
}
/*****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2";
}
/***************/
function Existe(f, hornada)
{

	for (i=1; i< f.cmbhornada.options.length; i++)
	{
	
		if ((f.cmbhornada.options[i].value.substr(6,4)) == hornada)
		{
			f.cmbhornada.value = f.cmbhornada.options[i].value;
			
			return true;
		}
	}
	
	return false;
}
/****************/
function Posicionar(f)
{   
    var f = document.frmBeneficio;
	hornada = f.txthornada.value;
	if(hornada=="" || hornada==0)
	{
		alert ("Hornada invalida reeingrese");
		return;
	}
	if (Existe(f, hornada))
	{
		Buscar(f);
	}
	else
	{

		if (hornada == "")
		{
			alert ("La Hornada Ingresada No Es Valida");
			return;
		}
	}
}
/**************/
function VerDatos(f)
{
	if (f.cmbproducto.value == -1)
	{
		alert("Debe Selecionar el Sub-Producto");
		return;
	}
	window.open("sea_con_beneficios.php?subproducto=" + f.cmbproducto.value, "","menubar=no resizable=no width=640 height=380 scrollbars=yes");
}
//***** Modif. Manue Fuentes -- Intellego ***
function ModDatoss(f)
{
  //var f = frmPrincipal;	
  
  	hornada = f.cmbhornada.value;
	if(hornada=="" || hornada==0 || hornada==-1)
	 { 
		alert ("Hornada invalida reeingrese");
		return;
	 }
    else
	 {
  		linea = "proceso=P&txthornada=" + f.cmbhornada.value + "&producto=17&subproducto=" + f.cmbproducto.value;
		
   	window.open("sea_ing_beneficio_mod_datos.php?" + linea, "","menubar=no resizable=no Top=200 Left=610 width=550 height=300 scrollbars=no");
	 }
	
}
//***** Modif. Manue Fuentes -- Intellego ***

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>

<form name="frmBeneficio" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="776" align="center" valign="top">

    <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr> 
        <td width="250">Tipo Anodo</td>
        <td width="250"><select name="cmbtipo" id="cmbtipo" onChange="JavaScript:Recarga1(this.form)">
            <?php
			if ($cmbtipo == "-1")
				echo '<option value="-1" selected>SELECCIONAR</option>';
			else 
				echo '<option value="-1">SELECCIONAR</option>';
		  	if ($cmbtipo == "1")
		  		echo '<option value="1" selected>ANODOS CORRIENTE</option>';
			else 
				echo '<option value="1">ANODOS CORRIENTE</option>';
			if ($cmbtipo == "2")	
				echo '<option value="2" selected>ANODOS HOJAS MADRES</option>';
			else 
				echo '<option value="2">ANODOS HOJAS MADRES</option>';
			if ($cmbtipo == "3")	
				echo '<option value="3" selected>ANODOS ESPECIALES</option>';
			else 
				echo '<option value="3">ANODOS ESPECIALES</option>';							
		?>
          </select></td>
      </tr>
      <tr> 
        <td width="250">Tipo Subproducto</td>
        <td width="250"><select name="cmbproducto" id="cmbproducto" onChange="JavaScript:Recarga2(this.form)">
            <option value="-1">SELECCIONAR</option>
            <?php
			if (($recargapag1 == "S") and ($cmbtipo != -1))
			{		
				include("../principal/conectar_principal.php");
				
				if ($cmbtipo == 1) //Corrientes
					$consulta = "SELECT valor_subclase1 AS valor FROM sub_clase WHERE cod_clase = 2002";
				else if ($cmbtipo == 2) //H. Madres
						$consulta = "SELECT valor_subclase2 AS valor FROM sub_clase WHERE cod_clase = 2002";
				else if ($cmbtipo == 3) //Especiales
						$consulta = "SELECT valor_subclase3 AS valor FROM sub_clase WHERE cod_clase = 2002";
					
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					$consulta = "SELECT * FROM subproducto WHERE cod_producto = 17 AND cod_subproducto = '".$row["valor"]."' AND mostrar_sea = 'S'";
					$rs1 = mysqli_query($link, $consulta);					
					if ($row1 = mysqli_fetch_array($rs1))
					{
						if ($row1["cod_subproducto"] == $cmbproducto)
							echo '<option value="'.$row1["cod_subproducto"].'" selected>'.$row1["descripcion"].'</option>';
						else
							echo '<option value="'.$row1["cod_subproducto"].'">'.$row1["descripcion"].'</option>';
					}
				}
				
				include("../principal/cerrar_sea_web.php");
			}
		?>
          </select></td>
      </tr>
    </table><br>


<?php 
	if (($cmbtipo == 1) or ($cmbtipo == 2) or ($cmbtipo == 3)) //Muestra la Segunda Tabla 
	{ 
?>


        <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td colspan="2">Fecha Beneficio		    </td>
          <td>
            <select name="dia" size="1">
              <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($recargapag2 == "S") && ($i == $dia))			
					echo "<option selected value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($recargapag2 != "S")) 
						echo "<option selected value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
            </select>
            <select name="mes" size="1" id="select">
              <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($recargapag2 == "S") && ($i == $mes))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($recargapag2 != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
            </select>
            <select name="ano" size="1">
              <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($recargapag2 == "S") && ($i == $ano))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($recargapag2 != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
            </select>
            <font size="1"><font size="2">
            <select name="Hora">
			<option value="S">S</option>
              <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if ($Hora!="")
					{	
						if ($Hora == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
            </select><strong>:</strong>
            <select name="Minutos">
			<option value="S">S</option>
              <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if ($Minutos!="")
					{	
						if ($Minutos == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
            </select>
            </font></font></td>
          </tr>
		<?php  
			if ($activa_fecha2 == "S")
			{
        		echo '<tr> ';
	            echo '<td colspan="2">Fecha a Cual Agrupar</td>';
    	        echo '<td>';
				
				echo '<select name="dia2" size="1">';
				for ($i=1;$i<=31;$i++)
				{	
					if ($i == $dia2)
						echo "<option selected value= '".$i."'>".$i."</option>";				
					//else if ($i == date("j"))
					//		echo "<option selected value= '".$i."'>".$i."</option>";											
					else					
						echo "<option value='".$i."'>".$i."</option>";												
				}		

             	echo '</select>';
              	echo '<select name="mes2" size="1">';

		 		for($i=1;$i<13;$i++)
			  	{
					if ($i == $mes2)
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					//else if ($i == date("n"))
					//		echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					else
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}		  

    			echo '</select>';
              	echo '<select name="ano2" size="1">';

				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if  ($i == $ano2)
						echo "<option selected value ='$i'>$i</option>";
					//else if($i == date("Y"))
					//	echo "<option selected value ='$i'>$i</option>";
					else	
						echo "<option value='".$i."'>".$i."</option>";
				}

              	echo '</select>';
				echo '</td>';
        	  	echo '</tr>';
			}
		?>
		
		
          <tr> 
            <td width="141">N&deg; Hornada</td>
            <td width="120"><input name="txthornada" type="text" id="txthornada" size="10">
            <input name="btnbuscar" type="button" value="Ok" onClick="JavaScript:Posicionar(this.form)"></td>
            <td width="326"> 
              <?php
			
			echo '<select name="cmbhornada" id="select2" onChange="JavaScript:Buscar(this.form)">';
			echo '<option value="-1">SELECCIONAR</option>';
                	  	
			include("../principal/conectar_sea_web.php");
		
			if ($recargapag2 == "S") 			{
				//Si el estado = 0; la Hornada esta vigente.
				$consulta = "SELECT * FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = ".$cmbproducto." AND estado = 0";	
				$consulta = $consulta." ORDER BY RIGHT(hornada_ventana,4)";
				$rs = mysqli_query($link, $consulta);
				$var1 = $consulta;
				while ($row = mysqli_fetch_array($rs))
				{
					if ($row["hornada_ventana"] == $cmbhornada)
						echo '<option value="'.$row["hornada_ventana"].'" selected>'.substr($row["hornada_ventana"],6,4).'</option>';				
					else
						echo '<option value="'.$row["hornada_ventana"].'">'.substr($row["hornada_ventana"],6,4).'</option>';				
				}
			}
						
			include("../principal/cerrar_sea_web.php");
		?></select>
              <?php
				if ($recargapag3 == "S")
					echo '<input name="fecha_creacion" type="text" size="10" value="'.substr($cmbhornada,4,2).'/'.substr($cmbhornada,0,4).'" readonly>';
				else 
					echo '<input name="fecha_creacion" type="text" size="10" value="" readonly>';
			?>
              <font size="1"><font size="2">
              <?php
			if ($recargapag2 == "S")
			{
				echo '&nbsp;&nbsp;&nbsp;&nbsp;';
				if ($activa_fecha2 == "S")
					echo '<input type="checkbox" name="checkbox" style="background:#FFFFCC" onClick="Recarga5(this.form)" checked>';
				else
					echo '<input type="checkbox" name="checkbox" style="background:#FFFFCC" onClick="Recarga5(this.form)">';			  
              	echo 'Descobrizacion';
				
				echo '<input name="marcacheckbox" type="hidden" value="'.$activa_fecha2.'">';
			}
			//echo $var1;
		?>
            </font></font> </td>
          </tr>
        </table>
        <br>
        <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="257">Consulta Beneficios Cargados en la N.E</td>
            <td width="328">
            <input name="btnvar" type="button" id="btnvar" value="Ver Datos" onClick="JavaScript:VerDatos(this.form)"></td>
          </tr>
        </table>
        <br>
        <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
           <?php // <td width="142" height="20">Unidades Existentes</td> ?>
             <td width="142" height="20">Unidades Aprobadas</td> 
            <td width="132"> 
              <?php
			 
			if ($recargapag3 == "S")
			{
				$unidN = 0;   			
                
				if ($unid_rech >= $unidad_raf)
					$unid_rech = (int)$unid_rech - (int)$unidad_raf;
					else
					$unid_rech = 0;
					
				if ($txtunidstock >= $unid_rech)
				{
					$txtunidstock = (int)$txtunidstock - (int)$unid_rech;
				}
				else
				{
					$unidN = $unid_rech - $txtunidstock;
					$unid_rech = (int)$unid_rech - (int)$unidN;
					$txtunidstock = 0;
				}
				echo '<input name="txtunidstock" type="text" size="10" value="'.$txtunidstock.'" readonly>';
			}
			else 
				echo '<input name="txtunidstock" type="text" id="txtunidstock" size="10" readonly>';
		?>
            </td>
            <td width="152">Peso</td>
            <td width="147"> 
              <?php
			if ($recargapag3 == "S")
			{
				//echo '<input name="txtpesostock" type="text" size="10" value="'.round($txtunidstock * $pesopromedio).'" readonly>';
				$pesoN = 0;  
				if ($peso_rc >= $peso_raf)
					$peso_rc = (int)$peso_rc - (int)$peso_raf;
				else
					$peso_rc = 0; 
				if ($peso_faltante >= $peso_rc)
				{
					$peso_faltante = (int)$peso_faltante - (int)$peso_rc;
				}
				else
				{
					$pesoN = (int)$peso_rc - (int)$peso_faltante;
					$peso_rc = (int)$peso_rc - (int)$pesoN;
					$peso_faltante = 0;
				}

				echo '<input name="txtpesostock" type="text" size="10" value="'.$peso_faltante.'" readonly>';
			}
			else

				echo '<input name="txtpesostock" type="text" id="txtpesostock" size="10" readonly>';
		?>
            </td>
          </tr>
          <tr> 
            <td height="20">Unidades Rechazadas</td>
            <td>
			<?php
				if ($recargapag3 == "S")
					echo '<input name="unid_rech" type="text" size="10" value="'.$unid_rech.'" readonly>';
				else 
					echo '<input name="unid_rech" type="text" size="10" readonly>';
			?>
			</td>
            <td>Peso</td>
            <td>
			<?php
				if ($recargapag3 == "S")
				  	//$promrech = $peso_rc / $unid_rech;
					//echo '<input name="peso_rech" type="text" size="10" value="'.round($unid_rech * $pesopromedio).'" readonly>';
					echo '<input name="peso_rech" type="text" size="10" value="'.$peso_rc.'" readonly>';
				else 
					echo '<input name="peso_rech" type="text" size="10" readonly>';
			?>
			</td>
          </tr>
        </table>
        <br>

  
<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="142">Grupo</td>
            <td width="131"> 
              <?php	
	  		if ($cmbtipo == "2")
				echo '<select name="cmbgrupo" id="cmbgrupo">'; //onChange="JavaScript:Recarga4(this.form)"
			else
				echo '<select name="cmbgrupo" id="cmbgrupo">';
				
          	echo '<option value="-1">SELECCIONAR</option>';
        
			$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2004 ORDER BY cod_subclase";
			
			include("../principal/conectar_principal.php");
			$rs = mysqli_query($link, $consulta);
			include("../principal/cerrar_principal.php");
			
			while ($row = mysqli_fetch_array($rs))
			{
				if (($row["cod_subclase"] == $cmbgrupo) and ($recargapag4 == "S"))
					echo '<option value="'.$row["cod_subclase"].'" selected>N° '.$row["cod_subclase"].'</option>';
				else 
					echo '<option value="'.$row["cod_subclase"].'">N° '.$row["cod_subclase"].'</option>';
			}			
		?></select>
            </td>
            <?php
		 	if (($cmbtipo == 1) or ($cmbtipo == 3))
				echo '<td>Lado</td>';
			else 
				echo '<td>Cuba</td>';
		?>
            <td width="153"> 
              <?php
			if (($cmbtipo == 1) or ($cmbtipo == 3)) //Corrientes y Especiales
			{
				echo '<select name="campo1" id="campo1">';
				if (($campo1 == -1) and ($recargapag4 == "S"))
					echo '<option value="-1" selected>SELECCIONAR</option>';
				else
					echo '<option value="-1">SELECCIONAR</option>';
					
				if (($campo1 == "T") and ($recargapag4 == "S"))
					echo '<option value="T" selected>TIERRA</option>';
				else 
					echo '<option value="T">TIERRA</option>';
				
				if (($campo1 == "M") and ($recargapag4 == "S"))
					echo '<option value="M" selected>MAR</option>';
				else
					echo '<option value="M">MAR</option>';
					//poly
				if (($campo1 == "N") and ($recargapag4 == "S"))
					echo '<option value="N" selected>NORTE</option>';
				else 
					echo '<option value="N">NORTE</option>';
				
				if (($campo1 == "S") and ($recargapag4 == "S"))
					echo '<option value="S" selected>SUR</option>';
				else
					echo '<option value="S">SUR</option>';

				//poly
					
					
					
					
				echo '</select>';
			}
			else if ($cmbtipo == 2) //H. Madres
				 {
				 	//echo '<input name="txtcuba" type="text" size="10">';
					echo '<select name="campo1">';
					echo '<option value="-1">SELECCIONAR</option>';


					for ($i=1; $i<=42; $i++)				
					{
						if (($i == $campo1) and ($recargapag4 == "S"))
							echo '<option value="'.$i.'" selected>N° '.$i.'</option>';
						else 
							echo '<option value="'.$i.'">N° '.$i.'</option>';
					}
					
/*					
						$arreglo = array(); //Contiene las Cubas.
						$nombres = array();						
						$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2009";												
						
						include("../principal/conectar_principal.php");
						$rs3 = mysqli_query($link, $consulta);
						include("../principal/cerrar_principal.php");
						
						while ($row3 = mysqli_fetch_array($rs3))
						{
							$arreglo[] = $row3["cod_subclase"];
							$nombres[$row3["cod_subclase"]][0] = $row3[nombre_subclase];
							$nombres[$row3["cod_subclase"]][1] = 0; //0: Mostrar, 1: No Mostrar.
						}
						
						$valores = implode(",", $arreglo);					
						
						$consulta = "SELECT * FROM movimientos WHERE tipo_movimiento = 2 AND cod_producto = 17";
						$consulta = $consulta." AND numero_recarga = 0 AND campo2 = ".$cmbgrupo ;
						
						include("../principal/conectar_sea_web.php");
						$rs4 = mysqli_query($link, $consulta);
						include("../principal/cerrar_sea_web.php");
						
						while ($row4 = mysqli_fetch_array($rs4))
						{
							$nombres[$row4[campo1]][1] = 1;
						}
						
						reset($nombres);
						while (list($c1, $v1) = each($nombres))
						{
							if ($v1[1] == 0) //Mostrar
								echo '<option value="'.$c1.'">'.$v1[0].'</option>';
						}
*/						
					echo '</select>';					
				 }
		?>
            </td>
          </tr>
          <tr> 
            <td width="142">Unidades Benef.</td>
            <td><input name="txtunidbenef" type="text" id="txtunidbenef" size="10" onBlur="JavaScript:Verifica(this.form)">
              &nbsp; </td>
            <td width="153">Peso Benef.</td>
            <td width="147"><input name="txtpesobenef" type="text" id="txtpesobenef" size="10" readonly></td>
          </tr>
          <tr>
            <td>Peso Promedio</td>
            <td>
			<?php
				if ($recargapag4 == "S")
					echo '<input name="textfield" type="text" style="background:#FFFFCC" size="10" value="'.round((float)$pesopromedio,3).'" readonly></td>';
				else 
					echo '<input name="textfield" type="text" style="background:#FFFFCC" size="10" value="" readonly></td>';
				
			?>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>

<table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr> 
      <td height="16" colspan="2">Saldos</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td width="142">Unidades Aprobadas</td>
      <td width="132">
        <?php
			if ($mostrar == "S")
				echo '<input name="txtunidsaldo" type="text" size="10" value="'.$txtunidstock.'" readonly>';
			else 
				echo '<input name="txtunidsaldo" type="text" size="10" readonly>';
		?>
      </td>
      <td width="152">Peso</td>
      <td width="147">
        <?php
			if ($mostrar == "S")
				echo '<input name="txtpesosaldo" type="text" size="10" value="'.($txtunidstock * $pesopromedio).'" readonly>';
			 else 
				echo '<input name="txtpesosaldo" type="text" size="10" readonly>';
		?>
      </td>
    </tr>
	    <tr> 
      <td width="142">Unidades Rechazadas</td>
      <td width="132">
        <?php
			if ($mostrar == "S")
				echo '<input name="txtunidsaldor" type="text" size="10" value="'.$txtunidsaldor.'" readonly>';
			else 
				echo '<input name="txtunidsaldor" type="text" size="10" readonly>';
		?>
      </td>
      <td width="152">Peso</td>
      <td width="147">
        <?php
			if ($mostrar == "S")
				echo '<input name="txtpesosaldor" type="text" size="10" value="'.($txtunidsaldor * $pesopromedio).'" readonly>';
			 else 
				echo '<input name="txtpesosaldor" type="text" size="10" readonly>';
		?>
      </td>
    </tr>

  </table><br>

<?php 
	} 
?>
<table width="600" border="0" cellspacing="0" cellpadding="3">
    <tr>
    <td align="center"><input name="btngrabar" type="button" value="Grabar" style="width:60" onClick="JavaScript:Grabar(this.form)">
        <input name="btnlimpiar" type="button" value="Limpiar" style="width:60" onClick="JavaScript:Limpiar(this.form)">
        <input name="ModDatos" type="button" id="ModDatos" style="width:150" onClick="JavaScript:ModDatoss(this.form)" value="Modif. Unid. Aprob.">
              <?php //onClick="ModDatos();"   ?>
    <input name="btnsalir" type="button" id="btnsalir" style="width:60" value="Salir" onClick="JavaScript:Salir()"></td>
    </tr>
</table>

  
  	<?php
		//Campo Oculto
		echo '<input type="hidden" name="pesopromedio" value="'.$pesopromedio.'">';
	?></td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>

