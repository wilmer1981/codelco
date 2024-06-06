<?php
include("../principal/conectar_principal.php"); 

	$CodigoDeSistema = 1;
	$CodigoDePantalla = 17;

	$CookieRut= $_COOKIE["CookieRut"];

	if(isset($_REQUEST["cmbproducto"])) {
		$cmbproducto = $_REQUEST["cmbproducto"];
	}else{
		$cmbproducto =  "";
	}
	if(isset($_REQUEST["cmbsubprod"])) {
		$cmbsubprod = $_REQUEST["cmbsubprod"];
	}else{
		$cmbsubprod =  "";
	}
	if(isset($_REQUEST["cmbloteenami"])) {
		$cmbloteenami = $_REQUEST["cmbloteenami"];
	}else{
		$cmbloteenami =  "";
	}
	
	if(isset($_REQUEST["lote"])) {
		$lote = $_REQUEST["lote"];
	}else{
		$lote =  "";
	}
	if(isset($_REQUEST["loteorigen"])) {
		$loteorigen = $_REQUEST["loteorigen"];
	}else{
		$loteorigen =  "";
	}
	if(isset($_REQUEST["marca"])) {
		$marca = $_REQUEST["marca"];
	}else{
		$marca =  "";
	}
	if(isset($_REQUEST["mostrar"])) {
		$mostrar = $_REQUEST["mostrar"];
	}else{
		$mostrar =  "";
	}
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
	if(isset($_REQUEST["txtrecuperados"])) {
		$txtrecuperados = $_REQUEST["txtrecuperados"];
	}else{
		$txtrecuperados =  "";
	}
	if(isset($_REQUEST["txtrechazos"])) {
		$txtrechazos = $_REQUEST["txtrechazos"];
	}else{
		$txtrechazos =  "";
	}
	
	if(isset($_REQUEST["hornada"])) {
		$hornada = $_REQUEST["hornada"];
	}else{
		$hornada =  "";
	}
	if(isset($_REQUEST["stropc"])) {
		$stropc = $_REQUEST["stropc"];
	}else{
		$stropc =  "";
	}

	if(isset($_REQUEST["dia"])) {
		$dia = $_REQUEST["dia"];
	}else{
		$dia =  date("d");
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
	if(isset($_REQUEST["mensaje"])) {
		$mensaje = $_REQUEST["mensaje"];
	}else{
		$mensaje = "";
	}



	$Consulta ="SELECT * FROM proyecto_modernizacion.sistemas_por_usuario WHERE rut = '".$CookieRut."'";
	
	$rs = mysqli_query($link, $Consulta); 
	$Acceso = 'S';
	if($row = mysqli_fetch_array($rs))
	{
		if($row["nivel"] != 1 && $row["nivel"] != 2)
		{
			$Acceso = 'N';
		}
	}			
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
</head>
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
/********************/
function OpcionChequeada()
{
	var f = document.frm1;
	StringOpc = '';
	for (i=0; i < f.opciones.length; i++)
	{
		if (f.opciones[i].checked == true)
			StringOpc = StringOpc + '1~';
		else
			StringOpc = StringOpc + '0~';
	}
	return StringOpc;
}
/********************/

function ValidaOpciones()
{
	var f = document.frm1;
	pos = f.PosicionInicial.value; //numero de elemento, en el que se ubica el checkbox.
	StringOpc = '';

	for (i=0; i < f.opciones.length; i++)
	{	
		if (f.opciones[i].checked == true)
		{
			if (f.opciones[i].disabled == false)			
			{
				StringOpc = StringOpc + '0~';
				StringOpc = StringOpc + f.opciones[i].value + '~';
				StringOpc = StringOpc + '~/';
			}
			else
			{				
				if (f.elements[pos].checked == true)
					StringOpc = StringOpc + '1~';
				else
					StringOpc = StringOpc + '0~';

				pos++;
				StringOpc = StringOpc + f.elements[pos].value + '~';
				pos++; 
				StringOpc = StringOpc + f.elements[pos].value + '~';
				pos++;
				StringOpc = StringOpc + f.elements[pos].value + '/';
				pos++;
			}
		}
	}

	return StringOpc;
}
/*******************/
function CantSelecionada()
{
	var f = document.frm1;
	var cont = 0;
	
	for (i=0; i < f.opciones.length; i++)
	{	
		if (f.opciones[i].checked == true)
			cont++;	
	}	
	return cont;
}
/*******************/
function DesactivaOpciones(Nombre)
{
	var f = document.frm1;
	var LargoForm = f.elements.length;
	
	i = parseInt(f.PosicionInicial.value); //numero de elemento, en el que se ubica el checkbox.
	if (f.elements[i].name == Nombre)
	{
		while ((i < LargoForm) && (f.elements[i].name == Nombre))		
		{
			if (f.elements[i].checked == true)
			{
				for (j=0; j < f.opciones.length; j++)
				{
					if (f.elements[i+1].value == f.opciones[j].value)
					{
						f.opciones[j].checked = false;
						break;
					}
				}
			}
			i = i + 4;
		}
	}
}	
/******************/
function Agregar(f)
{	
	if (f.cmbloteenami.value == 0)
		return;

	parametros = ValidaOpciones();
	stropc = OpcionChequeada();

	filas = CantSelecionada();		

	arreglo = f.cmbloteenami.value.split('~'); // lote_ventana - marca - lote_origen - hornada_ventana.
		
	linea = "&cmbsubprod=" + f.cmbsubprod.value + "&lote=" + arreglo[0] + "&loteorigen=" + arreglo[2] + "&marca=" + arreglo[1];
	linea = linea + "&mostrar=S&recargapag=S&verificatabla=S&agregafila=S&numero=" + filas + "&parametros=" + parametros;
	linea = linea + "&hornada=" + arreglo[3];			
	linea = linea + "&stropc=" + stropc;
	f.action = "sea_ing_rechazos_anodos.php?" + linea
	f.submit();
}
/******************/
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
	
		parametros = ValidaOpciones();
		DesactivaOpciones('checkbox');
		filas = CantSelecionada();
		stropc = OpcionChequeada();
		
		arreglo = f.cmbloteenami.value.split('~'); // lote_ventana - marca- lote_origen - hornada_ventana.
		linea = "cmbsubprod=" + f.cmbsubprod.value + "&lote=" + arreglo[0] + "&loteorigen=" + arreglo[2] + "&marca=" + arreglo[1];
		linea = linea + "&mostrar=S&recargapag=S&verificatabla=S&agregafila=N&numero=" + filas + "&parametros=" + parametros;
		linea = linea + "&hornada=" + arreglo[3];					
		linea = linea + "&stropc=" + stropc;		
		f.action = "sea_ing_rechazos_anodos.php?" + linea;
		f.submit();
	}
}
/********************/
function Recarga1(f)
{
//	alert(f.cmbsubprod.options[f.cmbsubprod.selectedIndex].text);
	linea = "cmbsubprod=" + f.cmbsubprod.value + "&mostrar=S";
	
	f.action = "sea_ing_rechazos_anodos.php?" + linea;
	f.submit(); 	
}
/*******************/
function Recarga2(f)
{
	if (f.cmbloteenami.value != 0)
	{
		arreglo = f.cmbloteenami.value.split('~'); //  lote_ventana - marca - lote_origen - hornada_ventana.
	
		linea = "cmbsubprod=" + f.cmbsubprod.value + "&dia=" + f.dia.value + "&mes=" + f.mes.value + "&ano=" + f.ano.value; 
		linea = linea + "&lote=" + arreglo[0] + "&loteorigen=" + arreglo[2] + "&marca=" + arreglo[1] + "&hornada=" + arreglo[3];
		linea = linea + "&mostrar=S&recargapag=S"; 	
		f.action = "sea_ing_rechazos_anodos.php?" + linea;
		f.submit(); 
	}
	else
	{
		linea = "cmbsubprod=" + f.cmbsubprod.value + "&mostrar=S";
		f.action = "sea_ing_rechazos_anodos.php?" + linea;
		f.submit();
	}
}
/*********************/
function ValidaCampos(f)
{
	if (f.cmbsubprod.value == -1)
	{
		alert("Debe Seleccionar Sub-Producto");
		return false;
	}
	
	if (f.cmbloteenami.value == 0)
	{	
		alert("Debe Seleccionar el Lote de Enami");
		return false;
	}
	
	if (isNaN(parseInt(f.txtrecuperados.value)) || (parseInt(f.txtrecuperados.value) < 0))
	{
		alert("El Total de Anodos Recuperables No es Valido");
		return false;		
	} 
	
	if ((isNaN(parseInt(f.txtrechazos.value))) || (parseInt(f.txtrechazos.value) < 0))
	{
		alert("El Total de Anodos Rechazados No es Valido");
		return false;		
	} 	
	
	if ((parseInt(f.txtrecuperados.value) + parseInt(f.txtrechazos.value)) > f.txtunidades.value)
	{
		alert("La Suma de los Recuperables y Rechazados no Puede Ser Mayor al Total Unidades");
		return false;
	}	
	
	cont = CantSelecionada(); //Valida si hay alguna fila.
	if (cont == 0)
	{
		alert("No Hay detalle a Ingresar");
		return false;
	}	
	
	return true;
}
/********************/
function Grabar(f)
{	
	if (ValidaCampos(f))
	{
		parametros = ValidaOpciones();
		parametros = parametros.substring(0,parametros.length - 1);
		
		linea = "proceso=G&parametros=" + parametros;
		f.action = "sea_ing_rechazos_anodos01.php?" + linea; 
		f.submit();		
	}
}
/*****************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=15";
}
/****************/
function BuscarRechazo(f)
{
	if (f.cmbloteenami.value != 0)
	{
		f.action = "sea_ing_rechazos_anodos01.php?proceso=B";
		f.submit();
	}	
	else
	{
		linea = "cmbsubprod=" + f.cmbsubprod.value + "&mostrar=S";
	
		f.action = "sea_ing_rechazos_anodos.php?" + linea;
		f.submit(); 		
	}
}
/******************/
function Limpiar()
{
	document.location = "sea_ing_rechazos_anodos.php";
}
/*****************/
function Eliminar(f)
{
	if (f.cmbloteenami.value == 0)
	{
		alert("Debe Seleccionar un Lote");
		return;
	}
	else
	{
		if (confirm("Esta Seguro que Quiere Eliminar los Rechazos del Lote Asociado"))
		{
			f.action = "sea_ing_rechazos_anodos01.php?proceso=E";
			f.submit();
		}
	}	
}
</script>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<?php
	if ($mensaje!="")
		echo '<script langueage="JavaScript"> alert("'.$mensaje.'") </script>';
?>
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" border="0" cellpadding="5" cellspacing="0" background="../principal/imagenes/fondo3.gif" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">

  <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr>
      <td width="230"> Tipo Producto</td>
      <td width="253"><select name="cmbproducto" id="cmbproducto">
          <option value="17">ANODOS</option>
        </select></td>
    </tr>
    <tr>
      <td>Sub-Producto</td>
      <td><select name="cmbsubprod" id="cmbsubprod" onChange="JavaScript:Recarga1(this.form)"> 
	  	<?php
        	echo '<option value="-1">SELECCIONAR</option>';
			$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = 17 AND cod_subproducto NOT IN ('4','8','11') ORDER BY cod_producto";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if (($row["cod_subproducto"] == $cmbsubprod) and ($mostrar == "S"))
					echo '<option value="'.$row["cod_subproducto"].'" selected>'.$row["descripcion"].'</option>';
				else
					echo '<option value="'.$row["cod_subproducto"].'">'.$row["descripcion"].'</option>';
			}
		?>
        </select>
            </td>
    </tr>
  </table>
  <br>
  <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td colspan="2">Fecha</td>
            <td colspan="4"><font size="2"> 
              <select name="dia" size="1">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($recargapag == "S") && ($i == $dia))			
					echo "<option selected value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($recargapag != "S")) 
						echo "<option selected value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
              </select>
              </font> <font size="2"> 
              <select name="mes" size="1" id="select7">
                <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($recargapag == "S") && ($i == $mes))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($recargapag != "S"))
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
				if (($recargapag == "S") && ($i == $ano))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($recargapag != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
              </select>
              </font></td>
          </tr>
          <tr> 
            <td height="24" colspan="2">Lote Enami - Marca - Lote Externo</td>
            <td colspan="4"><select name="cmbloteenami" onChange="JavaScript:BuscarRechazo(this.form)">
                <?php
		
			$consulta = "SELECT t1.lote_ventana , t1.marca , t1.lote_origen , t1.hornada_ventana ";
			$consulta = $consulta." FROM sea_web.relaciones AS t1 INNER JOIN sea_web.hornadas AS t2";
			$consulta = $consulta." ON t1.hornada_ventana = t2.hornada_ventana AND t1.cod_origen = t2.cod_subproducto";
			$consulta = $consulta." WHERE t2.cod_producto = 17 AND t1.cod_origen = '".$cmbsubprod."' ";
			$rs = mysqli_query($link, $consulta);
			
			
			echo '<option value="0">SELECCIONAR</option>';
			while ($row = mysqli_fetch_array($rs))
			{							
				$lote = $row["lote_ventana"]."~".$row["marca"]."~".$row["lote_origen"]."~".$row["hornada_ventana"];
				
				if (($lote == $cmbloteenami) and ($recargapag == "S"))
					echo '<option value="'.$row["lote_ventana"].'~'.$row["marca"].'~'.$row["lote_origen"].'~'.$row["hornada_ventana"].'" selected>'.$row["lote_ventana"].'-'.$row["marca"].'-'.$row["lote_origen"].'</option>';
				else
					echo '<option value="'.$row["lote_ventana"].'~'.$row["marca"].'~'.$row["lote_origen"].'~'.$row["hornada_ventana"].'">'.$row["lote_ventana"].'-'.$row["marca"].'-'.$row["lote_origen"].'</option>';
			}          
		?>
              </select> </td>
          </tr>
          <tr> 
            <td width="100">Marca</td>
            <td width="100"> 
              <?php
	  		if ($recargapag == "S")
			  	echo '<input name="txtmarca" type="text" value="'.$marca.'" size="10" disabled>';
			else
			  	echo '<input name="txtmarca" type="text" value="" size="10" disabled>';
	  	?>
            </td>
            <td width="100">Lote Externo </td>
            <td width="100"> 
              <?php					
			if ($recargapag == "S")
				echo '<input name="txtloteorigen" type="text" value="'.$loteorigen.'" size="10" disabled>';
			else
		    	echo '<input name="txtloteorigen" type="text" value="" size="10" disabled>';
		?>
            </td>
            <td width="100">Total Unidades</td>
            <td width="100"> 
              <?php
 		if ($recargapag == "S")
		{
			
			$consulta = "SELECT * FROM sea_web.hornadas WHERE cod_producto = 17 AND cod_subproducto = '".$cmbsubprod."' ";
			$consulta = $consulta." AND hornada_ventana = '".$hornada."' ";      		
			$rs = mysqli_query($link, $consulta);
			if ($row = mysqli_fetch_array($rs))
			 	echo '<input name="txtunidades" type="text" value="'.$row["unidades"].'" size="10" disabled>';
			else
				echo '<input name="txtunidades" type="text" value="0" size="10" disabled>';
			
		}
		else
			echo '<input name="txtunidades" type="text" value="" size="10">';
	?>
            </td>
          </tr>
        </table>
        <br>
        <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td>Total Recuperables</td>
            <td>
			<?php
				if ($recargapag == "S")
					echo '<input name="txtrecuperados" type="text" value="'.$txtrecuperados.'" size="10">';
				else
					echo '<input name="txtrecuperados" type="text" value="" size="10">';
			?>
			</td>
            <td>Total Rechazados</td>
            <td>
			<?php
				if ($recargapag == "S")
					echo '<input name="txtrechazos" type="text" value="'.$txtrechazos.'" size="10">';
				else
					echo '<input name="txtrechazos" type="text" value="" size="10">';
			?>
				</td>
          </tr>
        </table> 
        <br>
<table width="600" border="1" cellspacing="0" cellpadding="0">
           
			<?php
				$vector = explode('~',$stropc);
			
				$consulta = "SELECT count(*) AS cant FROM proyecto_modernizacion.sub_clase";
				$consulta.= " WHERE cod_clase = '2008'";			
				$rs = mysqli_query($link, $consulta);
				$row = mysqli_fetch_array($rs);
				$cant = $row["cant"];
				
				//Crea un campo que contiene la posicion inicial de las filas de detalle.
				echo '<input name="PosicionInicial" type="hidden" value="'.(14+$row["cant"]).'"';
			
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
				$consulta.= " WHERE cod_clase = '2008' ORDER BY cod_subclase";
				//echo $consulta;
				$rs = mysqli_query($link, $consulta);
				$cont = 0;
				while ($row = mysqli_fetch_array($rs))
				{				
					if ($cont % 5 == 0)
						echo '<tr>';
					echo '<td width="120">';
					//$codsubclase = isset($row["cod_subclase"]) ? $row["cod_subclase"] : '0';
					//if(isset($row["cod_subclase"])){
						$vect= isset($vector[$row["cod_subclase"]-1])?$vector[$row["cod_subclase"]-1]:0;
					//}//else{
					//	$vect= 0;
					//}
					//if ($vector[$row["cod_subclase"]-1] == 1)
					if ($vect == 1)
						echo '<input type="checkbox" name="opciones" value="'.$row["cod_subclase"].'" checked disabled>';
					else
						echo '<input type="checkbox" name="opciones" value="'.$row["cod_subclase"].'">';					
					
					echo $row["nombre_subclase"].'<td>';
					if (($cont == 5) or ($cant == 0))
					{
						echo '</tr>';
						$cont = 0;
					}
					$cont++;
					$cant--; 					
				}
			?>			    
        </table>
		<BR>		
        <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td>
			<input name="btnagregar" type="button" value="Agregar Detalle" style="width:100" onClick="JavaScript:Agregar(this.form)">  
			<input name="btnborrar" type="button" value="Elimina Detalle" style="width:100" onClick="JavaScript:Borrar(this.form)">
            </td>
          </tr>
        </table>
        <br>  

  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="ColorTabla01">
    <tr> 
      <td width="200" height="20" align="center">Tipo Defecto</td>
      <td width="200" align="center">Recuperables</td>
      <td width="200" align="center">Rechazados</td>
    </tr>
  </table>  
  
        <br>

<?php  
	if ($verificatabla == "S")
	{
		echo '<table width="600" border="1" cellspacing="0" cellpadding="0">';
    	$j = 0;
		$largo = strlen($parametros);
		while (($j < $numero) and ($largo != 0))
		{
			//Separa los parametros. (cod_defecto - recuperables - rechazos)
			for ($i=0; $i < $largo; $i++)
			{
				if (substr($parametros,$i,1) == "/")
				{				
					$valor = explode("~",substr($parametros,0,$i)); //checkbox - select - text - text.
																 
					$parametros = substr($parametros,$i+1);
					$i = 0;			

					if ($valor[0] == 0) //Si es 1, la fila fue eliminada.
					{
						//Genera las filas que ya fueron ingresadas.
						echo '<tr>';
						echo '<td width="200"><input type="checkbox" name="checkbox" value="checkbox">';
						echo '<input type="hidden" name="text" value="'.$valor[1].'">';
						
						$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2008 AND cod_subclase = '".$valor[1]."'";
						$rs = mysqli_query($link, $consulta);
						$row = mysqli_fetch_array($rs);
						echo $row["nombre_subclase"];					    

						echo '</td>';
						echo '<td width="200" align="center"><input type="text" name="text" value="'.$valor[2].'" size="10"></td>';
					    echo '<td width="200" align="center"><input type="text" name="text" value="'.$valor[3].'" size="10"></td>';
					    echo '</tr>';					
					}				
				}							
			}
			$j++;
	  	}  
		echo '</table>';
	}
?>
  
<?php
	//Campo Oculto.
	//Guarda la cantidas de filas.

	echo '<input type="hidden" name="filas" value="'.$numero.'">';
?> 
  
  
  <br>
  <table width="500" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td align="center"><input name="btngrabar" type="button" value="Grabar" style="width:60" onClick="JavaScript:Grabar(this.form)">
        <?php
		if($Acceso != "N")
        	echo'<input name="btneliminar" type="button" value="Eliminar" style="width:60" onClick="JavaScript:Eliminar(this.form)">';
        ?>
              <input name="btnlimpiar" type="button" value="Limpiar" style="width:60" onClick="JavaScript:Limpiar()">
              <input name="btnsalir" type="button" value="Salir" style="width:60" onClick="JavaScript:Salir()"></td>
    </tr>
  </table>

</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>    
</form>
</body>
</html>
<?php include("../principal/cerrar_principal.php") ?>