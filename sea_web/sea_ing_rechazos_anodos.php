<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 17;
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
function ValidaFilas(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	
	i = 13; //numero de elemento, en el que se ubica el checkbox.
	if (f.elements[i].name == Nombre)
	{
		while ((i < LargoForm) && (f.elements[i].name == Nombre))
		{
			j = i;
			if (f.elements[j].checked) //Verifica si el checkbox esta marcado
				Valores = Valores + 1 + '~'; //Marcado
			else 
				Valores = Valores + 0 + '~'; //No marcado
			
			j++;
			Valores = Valores + f.elements[j].value + '~'; //Select del tipo de defecto
			j++;

			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '~';
			else
				Valores = Valores + f.elements[j].value + '~'; //text de recuperados
			j++;
			
			if ((f.elements[j].value) == "")
				Valores = Valores + '0' + '/';
			else
				Valores = Valores + f.elements[j].value + '/'; // text de rechazos		
		
			i = i + 4;
		}
	}
	return Valores;
}
/*******************/
function Agregar(f)
{	
	if (f.cmbloteenami.value == 0)
		return;

	parametros = ValidaFilas(f,'checkbox');
	if (isNaN(parseInt(f.filas.value)))
		filas = 1;
	else
		filas = parseInt(f.filas.value) + 1;

	arreglo = f.cmbloteenami.value.split('~'); // lote_ventana - marca - lote_origen - hornada_ventana.
		
	linea = "&cmbsubprod=" + f.cmbsubprod.value + "&lote=" + arreglo[0] + "&loteorigen=" + arreglo[2] + "&marca=" + arreglo[1];
	linea = linea + "&mostrar=S&recargapag=S&verificatabla=S&agregafila=S&numero=" + filas + "&parametros=" + parametros;
	linea = linea + "&hornada=" + arreglo[3];			
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
	
		parametros = ValidaFilas(f,'checkbox');
		arreglo = f.cmbloteenami.value.split('~'); // lote_ventana - marca- lote_origen - hornada_ventana.
		linea = "cmbsubprod=" + f.cmbsubprod.value + "&lote=" + arreglo[0] + "&loteorigen=" + arreglo[2] + "&marca=" + arreglo[1];
		linea = linea + "&mostrar=S&recargapag=S&verificatabla=S&agregafila=N&numero=" + filas + "&parametros=" + parametros;
		linea = linea + "&hornada=" + arreglo[3];					
		f.action = "sea_ing_rechazos_anodos.php?" + linea;
		f.submit();
	}
}
/********************/
function Recarga1(f)
{
//	alert(f.cmbsubprod.options[f.cmbsubprod.SELECTedIndex].text);
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
	
	valores = ValidaFilas(f,'checkbox'); //Valida si hay alguna fila.
	if (valores == "")
	{
		alert("No Hay detalle a Ingresar");
		return false;
	}
	
	arreglo1 = valores.split('/') // Valida si algun tipo de defecto no esta seleccionado.
	for (i=0; i < arreglo1.length - 1; i++)
	{
		arreglo2 = arreglo1[i].split('~');
		if (arreglo2[1] == 'R')
		{
			alert("Debe Seleccionar el Tipo de Defecto");
			return false;
		}
	}
	
	return true;
}
/********************/
function Grabar(f)
{	
	if (ValidaCampos(f))
	{
		parametros = ValidaFilas(f,'checkbox');
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
	if (isset($mensaje))
		echo '<script langueage="JavaScript"> alert("'.$mensaje.'") </script>';
?>
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
<?php include("../principal/conectar_principal.php") ?> 

  <table width="770" border="0" cellpadding="5" cellspacing="0" background="../principal/imagenes/fondo3.gif" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">

  <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr>
      <td width="230"> Tipo Producto</td>
      <td width="253"><SELECT name="cmbproducto" id="cmbproducto">
          <option value="17">ANODOS</option>
        </SELECT></td>
    </tr>
    <tr>
      <td>Sub-Producto</td>
      <td><SELECT name="cmbsubprod" id="cmbsubprod" onChange="JavaScript:Recarga1(this.form)"> 
	  	<?php
        	echo '<option value="-1">SELECCIONAR</option>';
			$consulta = "SELECT * FROM subproducto WHERE cod_producto = 17 AND cod_subproducto NOT IN ('4','8','11') ORDER BY cod_producto";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if (($row["cod_subproducto"] == $cmbsubprod) and ($mostrar == "S"))
					echo '<option value="'.$row["cod_subproducto"].'" SELECTed>'.$row["descripcion"].'</option>';
				else
					echo '<option value="'.$row["cod_subproducto"].'">'.$row["descripcion"].'</option>';
			}
		?>
        </SELECT>
            </td>
    </tr>
  </table>
  <br>
  <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td colspan="2">Fecha</td>
            <td colspan="4"><font size="2"> 
              <SELECT name="dia" size="1">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($recargapag == "S") && ($i == $dia))			
					echo "<option SELECTed value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($recargapag != "S")) 
						echo "<option SELECTed value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
              </SELECT>
              </font> <font size="2"> 
              <SELECT name="mes" size="1" id="SELECT7">
                <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($recargapag == "S") && ($i == $mes))
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($recargapag != "S"))
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
              </SELECT>
              <SELECT name="ano" size="1">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($recargapag == "S") && ($i == $ano))
					echo "<option SELECTed value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($recargapag != "S"))
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
              </SELECT>
              </font></td>
          </tr>
          <tr> 
            <td height="24" colspan="2">Lote Enami - Marca - Lote Externo</td>
            <td colspan="4"><SELECT name="cmbloteenami" onChange="JavaScript:BuscarRechazo(this.form)">
                <?php
			include("../principal/cerrar_principal.php");
			include("../principal/conectar_sea_web.php");
			
			$consulta = "SELECT t1.lote_ventana , t1.marca , t1.lote_origen , t1.hornada_ventana ";
			$consulta = $consulta." FROM relaciones AS t1 INNER JOIN hornadas AS t2";
			$consulta = $consulta." ON t1.hornada_ventana = t2.hornada_ventana AND t1.cod_origen = t2.cod_subproducto";
			$consulta = $consulta." WHERE t2.cod_producto = 17 AND t1.cod_origen = ".$cmbsubprod;
			$rs = mysqli_query($link, $consulta);
			
			include("../principal/cerrar_sea_web.php");
			include("../principal/conectar_principal.php");
			
			echo '<option value="0">SELECCIONAR</option>';
			while ($row = mysqli_fetch_array($rs))
			{							
				$lote = $row[lote_ventana]."~".$row[marca]."~".$row[lote_origen]."~".$row[hornada_ventana];
				
				if (($lote == $cmbloteenami) and ($recargapag == "S"))
					echo '<option value="'.$row[lote_ventana].'~'.$row[marca].'~'.$row[lote_origen].'~'.$row[hornada_ventana].'" SELECTed>'.$row[lote_ventana].'-'.$row[marca].'-'.$row[lote_origen].'</option>';
				else
					echo '<option value="'.$row[lote_ventana].'~'.$row[marca].'~'.$row[lote_origen].'~'.$row[hornada_ventana].'">'.$row[lote_ventana].'-'.$row[marca].'-'.$row[lote_origen].'</option>';
			}          
		?>
              </SELECT> </td>
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
		 	include("../principal/cerrar_principal.php");
			include("../principal/conectar_sea_web.php");
			
			$consulta = "SELECT * FROM hornadas WHERE cod_producto = 17 AND cod_subproducto = ".$cmbsubprod;
			$consulta = $consulta." AND hornada_ventana = ".$hornada;      		
			$rs = mysqli_query($link, $consulta);
			if ($row = mysqli_fetch_array($rs))
			 	echo '<input name="txtunidades" type="text" value="'.$row["unidades"].'" size="10" disabled>';
			else
				echo '<input name="txtunidades" type="text" value="0" size="10" disabled>';
			
			include("../principal/cerrar_sea_web.php");
			include("../principal/conectar_principal.php");
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
					$valor = explode("~",substr($parametros,0,$i)); //checkbox - SELECT - text - text.
																 
					$parametros = substr($parametros,$i+1);
					$i = 0;			

					if ($valor[0] == 0) //Si es 1, la fila fue eliminada.
					{
						//Genera las filas que ya fueron ingresadas.
						echo '<tr>';
						echo '<td width="200"><input type="checkbox" name="checkbox" value="checkbox">';
					    echo '<SELECT name="SELECT">';					
					    echo '<option value="R">SELECCIONAR</option>';

						$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2008 ORDER BY cod_clase";
						$rs = mysqli_query($link, $consulta);
						while ($row = mysqli_fetch_array($rs))
						{
							if ($row["cod_subclase"] == $valor[1])
							    echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
							else
						    	echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
	
						}
						echo '</SELECT></td>';
						echo '<td width="200" align="center"><input type="text" name="text" value="'.$valor[2].'" size="10"></td>';
					    echo '<td width="200" align="center"><input type="text" name="text" value="'.$valor[3].'" size="10"></td>';
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
			echo '<td width="200"><input type="checkbox" name="checkbox" value="checkbox">';
			echo '<SELECT name="SELECT">';
		    echo '<option value="R">SELECCIONAR</option>';
		
			$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2008 ORDER BY cod_clase";
			$rs1 = mysqli_query($link, $consulta);
			while ($row1 = mysqli_fetch_array($rs1))
			{
			    echo '<option value="'.$row1["cod_subclase"].'">'.$row1["nombre_subclase"].'</option>';
			}		
		
			echo '</SELECT></td>';
			echo '<td width="200" align="center"><input type="text" name="text" size="10"></td>';
		    echo '<td width="200" align="center"><input type="text" name="text" size="10"></td>';
		    echo '</tr>';			
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
        <input name="btneliminar" type="button" value="Eliminar" style="width:60" onClick="JavaScript:Eliminar(this.form)">
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