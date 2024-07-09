<?php 
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 6;

	$modificar = isset($_REQUEST["modificar"])?$_REQUEST["modificar"]:"";
	$mostrar   = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
	$cmbgrupo  = isset($_REQUEST["cmbgrupo"])?$_REQUEST["cmbgrupo"]:"";
	$Hora      = isset($_REQUEST["Hora"])?$_REQUEST["Hora"]:date("G");
	$Minutos   = isset($_REQUEST["Minutos"])?$_REQUEST["Minutos"]:date("i");
	$fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$hornada2  = isset($_REQUEST["hornada2"])?$_REQUEST["hornada2"]:"";
	$hornada_aux = isset($_REQUEST["hornada_aux"])?$_REQUEST["hornada_aux"]:"";
	$activar     = isset($_REQUEST["activar"])?$_REQUEST["activar"]:"";
	$bloquear    = isset($_REQUEST["bloquear"])?$_REQUEST["bloquear"]:"";

	$dia = isset($_REQUEST["dia"])?$_REQUEST["dia"]:date("d");
	$mes = isset($_REQUEST["mes"])?$_REQUEST["mes"]:date("m");
	$ano = isset($_REQUEST["ano"])?$_REQUEST["ano"]:date("Y");
	$parametros = isset($_REQUEST["parametros"])?$_REQUEST["parametros"]:"";
	$cant_cubas = isset($_REQUEST["cant_cubas"])?$_REQUEST["cant_cubas"]:"";
	$txtunid1 = isset($_REQUEST["txtunid1"])?$_REQUEST["txtunid1"]:"";
	$txtpeso1 = isset($_REQUEST["txtpeso1"])?$_REQUEST["txtpeso1"]:"";
	$txtpesoproduccion = isset($_REQUEST["txtpesoproduccion"])?$_REQUEST["txtpesoproduccion"]:"";
	$total_prod = isset($_REQUEST["total_prod"])?$_REQUEST["total_prod"]:"";
	$valores    = isset($_REQUEST["valores"])?$_REQUEST["valores"]:"";

	$HoraAux=date('G');
	$MinAux=date('i');
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

	if ($modificar == "S")
	{
		
		$linea = "proceso=B2&hornada=".$hornada2."&cmbgrupo=".$cmbgrupo."&fecha=".$fecha;
		//echo $linea;
		echo '<script language="JavaScript">';
		echo 'document.location = "sea_ing_prod_restos_anodos_hm01.php?'.$linea.'";';
		echo '</script>';
	}
?>
<html>
<head>
<title>SISTEMA DE ANODOS - SEA-WEB</title>
<link rel="stylesheet" href="../principal/estilos/css_sea_web.css" type="text/css">
<script language="JavaScript">

function Buscar(f)
{
	//alert (FechaB);
	var param='';
	if (f.cmbgrupo.value != -1)
	{
		//f.action = "sea_ing_prod_restos_anodos_hm01.php?proceso=B&pdia="+f.dia.value+"&pmes="+f.mes.value+"&pano="+f.ano.value;
		f.action = "sea_ing_prod_restos_anodos_hm01.php?proceso=B&pdia="+f.dia.value+"&pmes="+f.mes.value+"&pano="+f.ano.value;
		f.submit();
	}
	else
	{
		f.action = "sea_ing_prod_restos_anodos_hm.php";
		f.submit();		
	}
}
/*********************/
function Buscar2(f)
{	
	if (f.cmbgrupo.value == -1)
	{
		alert("Debe Selecionar el Grupo");
		return;
	}
	
	linea = 'proceso=B2&fecha=' + f.ano.value + '-' + f.mes.value + '-' + f.dia.value + '&cmbgrupo=' + f.cmbgrupo.value;

	window.open("sea_hornadas_hm_produccidas.php?" + linea, "","menubar=no resizable=no width=500 height=300");	
}
/********************/
function Calcular(valor, op, f)
{	
	unidades = parseInt(f.txtunid1.value);
	peso = parseFloat(f.txtpeso1.value);
	arreglo = valor.split("~");

	if (op == 'S')
	{
		totalunid = unidades + parseInt(arreglo[1]);
		totalpeso = peso + parseFloat(arreglo[2]);
	}
	else
	{
		totalunid = unidades - parseInt(arreglo[1]);
		totalpeso = peso - parseFloat(arreglo[2]);		
	}
	
	document.frmProduccion.txtunid1.value = totalunid;
	document.frmProduccion.txtpeso1.value = Math.round(totalpeso);	
}
/*********************/
function Verificar(f,c)
{
	if (c.checked)
	{
		if (ValidaFechas(f,c.value))
			Calcular(c.value,'S',f) //Suma 
		else 
			c.checked = false;
	}	
	else
		Calcular(c.value,'R',f) //Resta		
}
/*******************/
function ValidaFechas(f,valor)
{
	meses = Array(31,28,31,30,31,30,31,31,30,31,30,31);

	var arreglo1 = valor.split('~');
	var arreglo2 = arreglo1[3].split('-'); //0: año, 1: mes, 2: dia; Fecha de Carga(Cuba).

	//Fecha1: fecha de produccion.
	//Fecha2: fecha de carga cuba.

	//Ano Anterior, de ambas fechas.
	//if (((parseInt(f.ano.value)-1) % 4) == 0)
	//	fecha1 = 366;
	//else 
	//	fecha1 = 365;
		
	//if (((parseInt(arreglo2[0])-1) % 4) == 0)
	//	fecha2 = 366;
	//else
	//	fecha2 = 365;


	//Mes Anterior, de ambas fechas.		
	//for(i=0; i<= (parseInt(f.mes.value)-1); i++)		
	//{	
	//	if ((i == 1) && ((parseInt(f.ano.value) % 4) == 0))
	//		fecha1 = fecha1 + 29;
	//	else
	//		fecha1 = fecha1 + meses[i];
	//}

	
	//for (i=0; i<= (parseInt(arreglo2[1]))-1; i++)
	//{
	//	if ((i==1) && ((parseInt(arreglo2[0]) % 4) == 0))		
	//		fecha2 = fecha2 + 29;
	//	else
	//		fecha2 = fecha2 + meses[i];
	//}
	
	//Dia actual, de ambas fechas.
	//fecha1 = fecha1 + parseInt(f.dia.value); //Fecha1: fecha de la cuba.
	//fecha2 = fecha2 + parseInt(arreglo2[2]); //Fecha2: fecha de produccion.

	var ano2 = parseInt(arreglo2[0]) * 1;
	var mes2 = parseInt(arreglo2[1]) * 1;
	var dia2 = arreglo2[2] * 1;
	var ano1 = parseInt(f.ano.value) * 1;
	var mes1 = parseInt(f.mes.value) * 1;
	var dia1 = parseInt(f.dia.value) * 1;
	fecha2 = (ano2 * 360) + (mes2 * 30) + dia2;
	fecha1 =(ano1 * 360) + (mes1 * 30) + dia1;
	var diferencia = (fecha1 - fecha2) + 1;
	
	if (diferencia <= 14)
		if (confirm("Esta Carga Tiene " + diferencia + " Dias �Esta Seguro de Incluir en la Produccion?"))
			return true;
		else 
			return false;
	else
		return true;
}
/********************/
function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			arreglo = f.elements[i].value.split("~");
			Valores = Valores + arreglo[0] + '~' + arreglo[1] + '~' + arreglo[2] + '~' + arreglo[3] + '/';
		}
	}
	return Valores;
}
/*********************/
function Crear(f)
{
	var parametros = ValidaSeleccion(f,'checkbox');
	if (parametros == "")
	{
		alert("No Hay Cubas Seleccionadas para Producir");
		return;
	}
	
	if (f.txtpesoproduccion.value == "")
	{
		alert("Debe Ingresar el Peso de Produccion");
		return;
	}

	if ((isNaN(parseInt(f.txtpesoproduccion.value))) || (parseInt(f.txtpesoproduccion.value) <= 0))
	{
		alert("El Peso de Produccion no es Valido");
		return;
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
	linea = "proceso=G&txtunid1=" + f.txtunid1.value + "&txtpeso1=" + f.txtpeso1.value + "&parametros=" + parametros;
	f.action = "sea_ing_prod_restos_anodos_hm01.php?" + linea;
	f.submit();

}
/*************************/
function Eliminar(f)
{
	if (confirm("Esta Seguro de Eliminar La Produccion, Los Beneficios y Sus Traspaso Asociados"))
	{
		f.action = "sea_ing_prod_restos_anodos_hm01.php?proceso=E";
		f.submit();
	}
}
/**************************/
function Modificar(f)
{
	if (f.txtpesoproduccion.value == "")
	{
		alert("Debe Ingresar el Peso de Produccion");
		return;
	}

	if ((isNaN(parseInt(f.txtpesoproduccion.value))) || (parseInt(f.txtpesoproduccion.value) <= 0))
	{
		alert("El Peso de Produccion no es Valido");
		return;
	}
	
	linea = "proceso=M&txtunid1=" + f.txtunid1.value + "&txtpeso1=" + f.txtpeso1.value
	f.action = "sea_ing_prod_restos_anodos_hm01.php?" + linea;
	f.submit();	
}

/***************/
function Ver_Datos(f)
{
	window.open("sea_ing_prod.php", "","menubar=no resizable=no width=540 height=380");
}

/**************************/
function Limpiar()
{
	document.location = "sea_ing_prod_restos_anodos_hm.php";
}
/*******************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2";
}
</script>
</head>

<body leftmargin="3" topmargin="5">

<form name="frmProduccion" method="post" action="">
<?php include("../principal/encabezado.php") ?>
<?php include("../principal/conectar_principal.php") ?> 

  <table width="770" height="500" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="middle">

<div style="position:absolute; left: 15px; top: 70px; width: 740;">
          <table width="740" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
            <tr> 
              <td width="109">Fecha Produccion</td>
              <td width="293"> <SELECT name="dia" size="1">
                  <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia))			
					echo "<option SELECTed value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo "<option SELECTed value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
                </SELECT> <SELECT name="mes" size="1" id="SELECT7">
                  <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes))
					echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
                </SELECT> <SELECT name="ano" size="1">
                  <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano))
					echo "<option SELECTed value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option SELECTed value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
                </SELECT>&nbsp;<font size="1"><font size="2">
                <SELECT name="Hora">
                  <option value="S">S</option>
                  <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($Hora))
					{	
						if ($Hora == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
                </SELECT>
                <strong>:</strong>
                <SELECT name="Minutos">
                  <option value="S">S</option>
                  <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($Minutos))
					{	
						if ($Minutos == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option SELECTed value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
                </SELECT>
                </font></font> </td>

              <td width="43">Grupo</td>
              <td width="138"> <SELECT name="cmbgrupo" id="cmbgrupo" onChange="JavaScript:Buscar(this.form)">
                <option value="-1">SELECCIONAR</option>
                <?php			
			$consulta = "SELECT DISTINCT t1.campo2 AS grupo, t2.nombre_subclase AS nombre FROM sea_web.movimientos AS t1";
			$consulta = $consulta." INNER JOIN  proyecto_modernizacion.sub_clase AS t2";
			$consulta = $consulta." ON t1.campo2 = t2.cod_subclase";
			$consulta = $consulta." WHERE t1.tipo_movimiento = 2 AND t2.cod_clase = 2004 AND t1.campo1 NOT IN ('T','M')";
			$consulta = $consulta." AND t1.numero_recarga = 0 ORDER BY t2.cod_subclase";
			$var= $consulta;
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if (($mostrar == "S") and ($row["grupo"] == $cmbgrupo))
					echo '<option value="'.$row["grupo"].'" SELECTed>N° '.$row["grupo"].'</option>';
				else 
					echo '<option value="'.$row["grupo"].'">N° '.$row["grupo"].'</option>';
			}			
		?>
              </SELECT> </td>
              <td width="124"><input name="btnbuscar" type="button" value="Buscar" onClick="JavaScript:Buscar2(this.form)"></td>
            </tr>
          </table>
</div>

<?php 	
//echo "VV".$var;
	if ($mostrar == "S") 
	{ 
	
		$totalcubas = 42;
		//Inicializa Tabla
		for ($i=1; $i <= $totalcubas; $i++)
		{
			$tabla[$i][0] = 0;
		}
	
		//Separa los parametros (cuba-unidades-peso-fecha_carga).
		$largo = strlen($parametros);

		for ($i=0; $i < $largo; $i++)
		{
		
		
			if (substr($parametros,$i,1) == "/")
			{				
				$valor = substr($parametros,0,$i);
												
				$pos = strpos($valor,"~"); //el N de la cuba
				$cuba = substr($valor,0,$pos);
				$valor = substr($valor,$pos+1,strlen($valor));					
				
				$pos = strpos($valor,"~"); //unidades
				$unidades = substr($valor,0,$pos);
				$valor = substr($valor,$pos+1,strlen($valor));
				
				$pos = strpos($valor,"~"); //peso
				$peso = substr($valor,0,$pos); 
				$valor = substr($valor,$pos+1,strlen($valor));
				
				$fecha_mov = $valor; //fecha de carga.
							
				$parametros = substr($parametros,$i+1);
				$i = 0;			
				$tabla[$cuba][0] = $unidades;
				$tabla[$cuba][1] = $peso;
				$tabla[$cuba][2] = $fecha_mov;				
			}				
		}	
				
		//Construye la tabla con las cubas.
		$filas = intval($cant_cubas/7) + 1;

/*		
		while(list($c,$v) = each($tabla))
		{
			echo $c."<br>";
		}
		
		
		//Escribe el maximo de cubas.
		for ($i=1; $i<= 42; $i++)
		{
			$tabla[$i][0] = 40;
			$tabla[$i][2] = "2003-07-1";
		}
		$cant_cubas = 42;
		$filas = 7;				
*/		
//echo "FFF".$filas."-".$num_cuba."-".$cant_cubas;
		echo '<div style="position:absolute; top: 120px; left: 30px; width: 720px; height: 330px; OVERFLOW: auto;" id="div3">'; 
    	echo '<table width="700" border="0" cellpadding="0" cellspacing="0">';		
		$indice = 1; //de la tabla
		$num_cuba = 0;
		$i = 1;
	
		while (($i <= $filas) and ($num_cuba < $cant_cubas))
		{			
	    	echo '<tr>'; 
			$sw = "S";
			
			while (($indice <= $totalcubas) and ($sw == "S"))
			{
			//echo "NN".$tabla[$indice][0]."--".$tabla[$indice][2]."--".$tabla[$indice][1]."--".$totalcubas."--".$indice;
				if ($tabla[$indice][0] != 0)
				{ 
					//Muestra foto con la cantidad de anodos en al cuba.
					$foto = "../principal/imagenes/anodo";
					if (strlen($tabla[$indice][0]) == 1)
						$foto = $foto."0";
						
					$foto = $foto.$tabla[$indice][0].".jpg";
					$fecha_mov = explode("-",$tabla[$indice][2]); //0: ano, 1: mes, 2: dia.
					
	    			echo '<td height="110"><center>Cuba '.$indice.'<br><img src="'.$foto.'" hspace="0" vspace="4"><br>';
					printf("%'02d", $fecha_mov[2]);
					echo ("/");
					printf("%'02d", $fecha_mov[1]);
					echo ("/");
					printf($fecha_mov[0]);
					echo '<br>';
					if ($bloquear == "S")
						echo '<input type="checkbox" name="checkbox" value="'.$indice.'~'.$tabla[$indice][0]."~".$tabla[$indice][1]."~".$tabla[$indice][2].'" onClick="JavaScript:Verificar(this.form,this)" disabled>';
					else 
						echo '<input type="checkbox" name="checkbox" value="'.$indice.'~'.$tabla[$indice][0]."~".$tabla[$indice][1]."~".$tabla[$indice][2].'" onClick="JavaScript:Verificar(this.form,this)">';
					
					echo '</center></td>';
					$num_cuba++;
				}

				if ((intval($num_cuba/7) == ($i*1)) or ($num_cuba == $cant_cubas))	
				{
					$sw = "N";
				}

				$indice++;
			}
    		echo '</tr>';
			$i++;		
		}
		
		echo '</table>';
		echo '</div>';  
		
	} 
	else
	{
		//Muestra una foto
		echo '<div style="position:absolute; left: 190px; top: 150px;" id="div6">'; 
		echo '<table border="0" cellspacing="0" cellpadding="0" align="center">';
		echo '<tr><td width="200" height="200"><img src="../principal/imagenes/anodo_hm.gif"></td></tr>';
		echo '</table>';
		echo '</div>';
	}
?> 

  <div style="position:absolute; left: 15px; top: 480px; width: 740px; height: 24px;" id="div4"> 
          <table width="740" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
            <tr> 
              <td width="100" height="20">Peso Produccion</td>
              <td width="124">
			<?php 
			  	if ($mostrar == "S")	
					echo '<input name="txtpesoproduccion" type="text" value="'.$total_prod.'" size="10">';
				else 
					echo '<input name="txtpesoproduccion" type="text" size="10">';
			?>
				
				</td>
              <td width="158">Unidades Cargadas</td>
              <td width="104">
                <?php 
          	if ($mostrar == "S")
				echo '<input name="txtunid1" type="text" value="'.$txtunid1.'" size="10" readonly>';				
		  	else
				echo '<input name="txtunid1" type="text" value="0" size="10" readonly>';
		?>
              </td>
              <td width="103">Peso Carga</td>
              <td width="112"> 
                <?php
			if ($mostrar == "S")
          		echo '<input name="txtpeso1" type="text" value="'.$txtpeso1.'" size="10" readonly>';
			else 
          		echo '<input name="txtpeso1" type="text" value="0" size="10" readonly>';
		?>
            </tr>
          </table>
</div>

        <?php
	if ($activar!="")
		echo '<script language="JavaScript"> window.open("sea_con_hornadas.php?valores='.$valores.'", "","menubar=no resizable=no width=500 height=250") </script>';
?>

<div style="position:absolute; width: 740px; left: 15px; top: 519px; height: 24px;" id="dd">
          <table width="740" border="0" cellspacing="0" cellpadding="0">
            <tr><td align="center">
			<?php
			  	if ($bloquear == "S")
				{	
					//echo '<input name="hornada_aux" type="hidden" size="10" value="'.substr($hornada_aux,6,6).'"style="background:#FFFFCC" readonly>';
					echo '<input name="hornada" type="hidden" size="10" value="'.$hornada_aux.'">';
				}
				//else 
				//	echo '<input name="hornada_aux" type="text" size="10" style="background:#FFFFCC">';
			?>
			<?php
              	if ($bloquear == "S")
				{
					echo '<input name="btncrear" type="button" value="Modificar Hornada" style="width=115" onClick="JavaScript:Modificar(this.form)">&nbsp;';
					echo '<input name="btneliminar" type="button" value="Eliminar Produccion" onClick="JavaScript:Eliminar(this.form)" style="width=115">';
				}
				else
					echo '<input name="btncrear" type="button" value="Crear Hornada" style="width=115" onClick="JavaScript:Crear(this.form)">';
			?>
                <input name="btnlimpiar" type="button" style="width=115" value="Limpiar" onClick="JavaScript:Limpiar()"> 
              	<input name="ver datos" type="button" style="width=115" onClick="JavaScript:Ver_Datos(this.form)" value="Ver Datos">
                <input name="btnsalir" type="button" style="width=115" value="Salir" onClick="JavaScript:Salir()">
            </td></tr>
          </table> 
</div>
		</td>
</tr>
		<?php
			//campo oculto.
			echo '<input type="hidden" name="fecha_aux" value="'.$ano."-".$mes."-".$dia.'">';
		?>
</table>
<?php include ("../principal/pie_pagina.php") ?> 

</form>
</body>
</html>
<?php include("../principal/cerrar_principal.php") ?>