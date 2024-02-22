<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 138;
	
	include("../principal/conectar_pmn_web.php");
	
	$unidad = array('100'=>'%','1000'=>'K/T', '1000000'=>'g/T');
	$signos = array('+'=>'+','-'=>'-');
	
	if ($opc == "B")
	{
		if ($signo == '1')
			$signo = '+';
		else if ($signo == '2')
				$signo = '-';
			else $signo = '';
		
		
		$consulta = "SELECT * FROM pmn_web.productos_por_movimientos";			
		$consulta.= " WHERE tipo_mov = '".$cmbmovimiento."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
		$consulta.= " AND fecha = '".$fecha."' AND id = '".$id."' AND signo = '".$signo."'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);		

		$txtid = $row[id];
		$txtpeso = number_format($row[peso_seco],3,",","");
		$radiotipo = $row[signo];

		$txtleycu = number_format($row[fino_cu],3,",","");
		$txtleyag = number_format($row[fino_ag],3,",","");
		$txtleyau = number_format($row[fino_au],3,",","");
		$cmbunidcu = $row[unid_cu];
		$cmbunidag = $row[unid_ag];		
		$cmbunidau = $row[unid_au];
		
		$cmbsignocu = $row[signo_cu];
		$cmbsignoag = $row[signo_ag];		
		$cmbsignoau = $row[signo_au];	
		
		$vector = explode('-', $fecha);
		$ano = $vector[0];
		$mes = $vector[1];
		$dia = $vector[2];			
	}
	
	if ($opc == 'B2')
	{
		$consulta = "SELECT * FROM pmn_web.relacion_flujo";
		$consulta.= " WHERE flujo = '".$txtflujo."'";
		//echo $consulta."<br>";		
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			$recargapag1 = 'S';
			$recargapag2 = 'S';
			$recargapag3 = 'S';
			
			$cmbproducto = $row["cod_producto"];
			$cmbsubproducto = $row["cod_subproducto"];
			$cmbmovimiento = $row[tipo_mov];
			$radiotipo = $row[signo];
		}
		else	
			$cmbmovimiento = '';
	}
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Recarga1()
{
	var f = document.frmPrincipal;
	
	if (f.cmbmovimiento.value == -1)
		f.action = "pmn_ing_productos_por_movimientos.php";
		//document.location = "pmn_ing_productos_por_movimientos.php";
	else
		f.action = "pmn_ing_productos_por_movimientos.php?recargapag1=S&cmbmovimiento=" + f.cmbmovimiento.value;
		//document.location = "pmn_ing_productos_por_movimientos.php?recargapag1=S&cmbmovimiento=" + f.cmbmovimiento.value;

	
	f.submit();
}
/****************/
function Recarga2()
{
	var f = document.frmPrincipal;
	
	f.action = "pmn_ing_productos_por_movimientos.php?recargapag1=S&recargapag2=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value;
	f.submit();
}
/*****************/
function Recarga3()
{
	var f = document.frmPrincipal;

	f.action = "pmn_ing_productos_por_movimientos.php?recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;	
	f.submit();	
}
/****************/
function Recarga4()
{
	var f = document.frmPrincipal;
		
	linea = "recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value;
	linea = linea + "&cmbsubproducto=" + f.cmbsubproducto.value; 
		
	f.action = "pmn_ing_productos_por_movimientos.php?" + linea ;
	f.submit();			
}
/****************/
function BuscaFlujo()
{
	var f = document.frmPrincipal;
	
	f.action = "pmn_ing_productos_por_movimientos.php?opc=B2";
	f.submit();			
}
/****************/
function ValidaCampos()
{
	var f = document.frmPrincipal;

	if (f.cmbmovimiento.value == -1)
	{
		alert("Debe Seleccionar El Tipo Movimiento");		
		return false;
	}
	
	if (f.cmbproducto.value == -1)
	{
		alert("Debe Seleccionar El Producto");
		return false;
	}	
	
	if (f.cmbsubproducto.value == -1)
	{
		alert("Debe Seleccionar El SubProducto");
		return false;
	}
	
	//if (f.cmbmovimiento.value == 99) or (f.cmbmovimiento.value == 1)
	//{	
		if ((f.radiotipo[0].checked == false) && (f.radiotipo[1].checked == false))
		{
			alert("Debe seleccionar El Tipo Ajuste (+  -)");			
			f.radiotipo[0].focus();			
			return false;			
		}		
	//}
	
	if (f.txtid.value == "")
	{
		alert("Debe Ingresar La Identificacion Del Producto");
		f.txtid.focus();
		return false;
	}	
	
	if (isNaN(parseInt(f.txtpeso.value)))
	{
		alert("El Peso No Es Valido");
		f.txtpeso.focus();
		return false;
	}
	
	if (isNaN(parseInt(f.txtleycu.value)))
	{
		alert("La Ley de Cu No Es Valida");
		f.txtleycu.focus();
		return false;
	}

	if (isNaN(parseInt(f.txtleyag.value)))
	{
		alert("La Ley de Ag No Es Valida");
		f.txtleyag.focus();
		return false;
	}		
	
	if (isNaN(parseInt(f.txtleyau.value)))
	{
		alert("La Ley de Au No Es Valida");
		f.txtleyau.focus();
		return false;
	}
	
	return true;
}
/******************/
function Grabar()
{	
	var f = document.frmPrincipal;
	
	if (ValidaCampos())
	{
		f.action = "pmn_ing_productos_por_movimientos01.php?proceso=G";
		f.submit();
	}
}
/******************/
function Modificar()
{	
	var f = document.frmPrincipal;
	
	if (ValidaCampos())
	{
		f.action = "pmn_ing_productos_por_movimientos01.php?proceso=M";
		f.submit();
	}
}
/******************/
function Eliminar()
{	
	var f = document.frmPrincipal;
	
	if (confirm("Esta Seguro De Eliminar El Registro"))
	{
		f.action = "pmn_ing_productos_por_movimientos01.php?proceso=E";
		f.submit();
	}
}
/******************/
function Consultar()
{
	var f = document.frmPrincipal;
	
	if (f.cmbmovimiento.value == -1)
	{
		alert("Debe Seleccionar El Tipo Movimiento");
		return false;
	}
	
	if (f.cmbproducto.value == -1)
	{
		alert("Debe Seleccionar El Producto");
		return false;
	}	
	
	if (f.cmbsubproducto.value == -1)
	{
		alert("Debe Seleccionar El SubProducto");
		return false;
	}

	var linea = 'cmbmovimiento=' + f.cmbmovimiento.value + '&cmbproducto=' + f.cmbproducto.value + '&cmbsubproducto=' + f.cmbsubproducto.value;
	
	window.open("pmn_ing_productos_por_movimientos_popup.php?"+linea,"","top=100,left=80,width=790,height=380,scrollbars=no,resizable=no");
}
/******************/
function Cancelar()
{
	document.location = 'pmn_ing_productos_por_movimientos.php';	
}
/******************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=139";
}
/****************/
function TeclaPulsada(salto)
{
	var f = document.frmPrincipal;
	var teclaCodigo = event.keyCode; 
	
	if (teclaCodigo == 13)
	{
		switch (salto) {
			case 0: f.txtid.focus();
					break;
			case 1: f.txtpeso.focus();
					break;
			case 2: f.cmbsignocu.focus();
					break;
			case 3: f.txtleycu.focus();
					break;
			case 4: f.cmbunidcu.focus();
					break;
			case 5: f.cmbsignoag.focus();
					break;					
			case 6: f.txtleyag.focus();
					break;
			case 7: f.cmbunidag.focus();
					break;
			case 8: f.cmbsignoau.focus();
					break;
			case 9: f.txtleyau.focus();
					break;
			case 10: f.cmbunidau.focus();
					break;
			case 11: f.btngrabar.focus();
					break;
			case 20: BuscaFlujo();
					break;
		}
	}
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>
<?php
	//Campos Ocultos.
	echo '<input name="fecha_aux" type="hidden" value="'.$fecha.'">';
	echo '<input name="tipo_aux" type="hidden" value="'.$cmbmovimiento.'">';	
	echo '<input name="prod_aux" type="hidden" value="'.$cmbproducto.'">';
	echo '<input name="subprod_aux" type="hidden" value="'.$cmbsubproducto.'">';	
	echo '<input name="id_aux" type="hidden" value="'.$txtid.'">';
	echo '<input name="signo_aux" type="hidden" value="'.$radiotipo.'">';								
?>
<table width="770" border="0" class="TablaPrincipal">
<tr>
<td>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="196" align="left">Fecha</td>
            <td width="389" align="left">               
                <?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		echo '<select name="dia" size="1">';
		for ($i=1;$i<=31;$i++)
		{	
			if (($recargapag1 == "S") && ($i == $dia))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($recargapag1 != "S")) 
					echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}
		echo '</select>';

	?>
          <select name="mes" size="1">
                <?php
		for($i=1;$i<13;$i++)
		{
			if (($recargapag1 == "S") && ($i == $mes))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($recargapag1 != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
              </select> <select name="ano" size="1">
                <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag1 == "S") && ($i == $ano))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($recargapag1 != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
              </select></td>
          </tr>
        </table>
        <br>
        <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="143">Tipo Movimiento</td>
            <td width="46" align="center"><input name="txtflujo" type="text" id="txtflujo" size="5" onKeyDown="TeclaPulsada(20)" <?php echo $bloquea ?>></td>
            <td colspan="2"> 
              <?php
				echo '<select name="cmbmovimiento" id="cmbmovimiento" onChange="Recarga1()" '.$bloquea.'>';
			?>
              <option value="-1">SELECCIONAR</option> 
              <?php
				$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
				$consulta.= " WHERE cod_clase = '6009'";
				$consulta.= " ORDER BY cod_subclase";				
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					if ($row["cod_subclase"] == $cmbmovimiento)
						echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
					else
						echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
				}
			?></select>
              </td>
          </tr>
          <tr> 
            <td colspan="2">Producto</td>
            <td colspan="2"> 
              <?php
				echo '<select name="cmbproducto" onChange="Recarga2()" '.$bloquea.'>';
			?>
              <option value="-1">SELECCIONAR</option> 
              <?php
			 	if ($recargapag1 == "S")
				{
					$consulta = "SELECT t2.cod_producto,t2.descripcion";
					$consulta.= " FROM proyecto_modernizacion.subproducto AS t1";
					$consulta.= " INNER JOIN proyecto_modernizacion.productos AS t2";
					$consulta.= " ON t1.cod_producto = t2.cod_producto AND t1.tipo_mov_pmn LIKE '%".$cmbmovimiento."%'";
					$consulta.= " GROUP BY t1.cod_producto";
					
					$rs = mysqli_query($link, $consulta);					
					while ($row = mysqli_fetch_array($rs))
					{
						if (($row["cod_producto"] == $cmbproducto) and ($recargapag2 == "S"))
							echo '<option value="'.$row["cod_producto"].'" selected>'.$row["descripcion"].'</option>';
						else
							echo '<option value="'.$row["cod_producto"].'">'.$row["descripcion"].'</option>';
					}
				}
			?></select>
              </td>
          </tr>
          <tr> 
            <td colspan="2">SubProducto</td>
            <td width="286"> 
              <?php
				echo '<select name="cmbsubproducto" onChange="Recarga3()" '.$bloquea.'>';
			?>
              <option value="-1">SELECCIONAR</option> 
              <?php
					if ($recargapag2 == "S")
					{
						$consulta = "SELECT * FROM proyecto_modernizacion.subproducto";
						$consulta.= " WHERE cod_producto = '".$cmbproducto."' AND tipo_mov_pmn LIKE '%".$cmbmovimiento."%'";															
					
						$rs1 = mysqli_query($link, $consulta);						
						while ($row1 = mysqli_fetch_array($rs1))
						{	
							if ($row1["cod_subproducto"] == $cmbsubproducto)
								echo '<option value="'.$row1["cod_subproducto"].'" selected>'.$row1["descripcion"].'</option>';
							else
								echo '<option value="'.$row1["cod_subproducto"].'">'.$row1["descripcion"].'</option>';
						}
					}
				?></select>
              </td>
            <td width="98"><strong>Flujo: 
              <?php
				if ($recargapag3 == "S")
				{
					$consulta = "SELECT * FROM pmn_web.relacion_flujo";
					$consulta.= " WHERE tipo_mov = '".$cmbmovimiento."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					if ($cmbmovimiento == '99')
						$consulta.= " AND signo = '".$radiotipo."'";
					//echo $consulta."<br>";
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs))
					{
						echo $row["flujo"];
					}
				}
			?>
            </strong></td>
          </tr>
        </table> 
        <br>
        <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <?php		  
           // if (($cmbmovimiento == '99') or ($cmbmovimiento == '1'))
			//{	
				echo '<tr>';
				echo '<td>Tipo Ajuste:</td>';
            	echo '<td>';

				if ($cmbmovimiento == '99')
					$onclick = "Recarga4()";

				if ($radiotipo == '-')
				{
					echo '<input name="radiotipo" type="radio" value="+" onClick="'.$onclick.'" onKeyDown="TeclaPulsada(0)">(+) Positivo &nbsp;&nbsp;';
            		echo '<input name="radiotipo" type="radio" value="-" checked onClick="'.$onclick.'" onKeyDown="TeclaPulsada(0)">(-) Negativo</td>';
				}
				else if ($radiotipo == '+')
				{
					echo '<input name="radiotipo" type="radio" value="+" checked onClick="'.$onclick.'" onKeyDown="TeclaPulsada(0)">(+) Positivo &nbsp;&nbsp;';
            		echo '<input name="radiotipo" type="radio" value="-" onClick="'.$onclick.'" onKeyDown="TeclaPulsada(0)">(-) Negativo</td>';					
				}
				else
				{
					echo '<input name="radiotipo" type="radio" value="+" onClick="'.$onclick.'" onKeyDown="TeclaPulsada(0)">(+) Positivo &nbsp;&nbsp;';
            		echo '<input name="radiotipo" type="radio" value="-" onClick="'.$onclick.'" onKeyDown="TeclaPulsada(0)">(-) Negativo</td>';				
				}
				
				echo '</td>';
	            echo '<td colspan="2">&nbsp;</td>';
				echo '</tr>';
			//}
			?>
          <tr> 
            <td width="124">Identificacion:</td>
            <td width="241"> 
              <?php
				if ($mostrar == "S")	
					echo '<input name="txtid" type="text" id="txtid" value="'.$txtid.'" readonly>';				
				else
					echo '<input name="txtid" type="text" id="txtid" value="'.$txtid.'" size="30" onKeyDown="TeclaPulsada(1)">';
			?>
            </td>
            <td width="214">&nbsp;</td>
          </tr>
          <tr> 
            <td>Peso Seco:</td>
            <td><input name="txtpeso" type="text" id="txtpeso" onKeyDown="TeclaPulsada(2)" value="<?php echo $txtpeso ?>" size="15" maxlength="12">
              (Kg.)</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="400" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="107">Fino Cu:</td>
            <td width="278">
			
			<?php
            //if (($cmbmovimiento == '99') or ($cmbmovimiento == '1'))
			//{
				echo '<select name="cmbsignocu" id="cmbsignocu" onKeyDown="TeclaPulsada(3)">';
				reset($signos);			
				while(list($c,$v) = each($signos))
				{
					if ($cmbsignocu == $v)
						echo '<option value="'.$v.'" selected>'.$v.'</option>';
					else
						echo '<option value="'.$v.'">'.$v.'</option>';
				}
              	echo '</select>';
			//}
			?>

              <input name="txtleycu" type="text" id="txtleycu" onKeyDown="TeclaPulsada(4)" value="<?php echo $txtleycu ?>" size="15" maxlength="12">
              <select name="cmbunidcu" onKeyDown="TeclaPulsada(5)">
			  <?php
				reset($unidad);
				while(list($c,$v) = each($unidad))
				{
					if ($c == $cmbunidcu)
						echo '<option value="'.$c.'" selected>'.$v.'</option>';
					else
						echo '<option value="'.$c.'">'.$v.'</option>';
				}

			  ?>
				</select>
 </td>
			<!--
            <td width="64">Fino Cu:</td>
            <td width="121"><input name="txtfinocu" type="text" id="txtfinocu" size="15" maxlength="12" onKeyDown="TeclaPulsada(true)" value="<?php echo $txtfinocu ?>"></td>
			-->
          </tr>
          <tr> 
            <td>Fino Ag:</td>
            <td>
			<?php
            	//if (($cmbmovimiento == '99') or ($cmbmovimiento == '1'))			
				//{
					echo '<select name="cmbsignoag" onKeyDown="TeclaPulsada(6)">';
					reset($signos);
					while(list($c,$v) = each($signos))
					{
						if ($cmbsignoag == $v)
							echo '<option value="'.$v.'" selected>'.$v.'</option>';
						else
							echo '<option value="'.$v.'">'.$v.'</option>';
					}
					echo '</select>';
				//}				
			?>

              <input name="txtleyag" type="text" id="txtleyag" onKeyDown="TeclaPulsada(7)" value="<?php echo $txtleyag ?>" size="15" maxlength="12">
              <select name="cmbunidag" onKeyDown="TeclaPulsada(8)">
			  <?php
			  	reset($unidad);			  
			 	while(list($c,$v) = each($unidad))
				{
					if ($c == $cmbunidag)
						echo '<option value="'.$c.'" selected>'.$v.'</option>';
					else
						echo '<option value="'.$c.'">'.$v.'</option>';
				}
			  ?>			  
              </select> </td>
			<!--			
            <td>Fino Ag:</td>
            <td><input name="txtfinoag" type="text" id="txtfinoag" size="15" maxlength="12" onKeyDown="TeclaPulsada(true)" value="<?php echo $txtfinoag ?>"></td>
			-->			
          </tr>
          <tr> 
            <td>Fino Au:</td>
            <td> 
			<?php
            	//if (($cmbmovimiento == '99') or ($cmbmovimiento == '1'))
				//{			
					echo '<select name="cmbsignoau" onKeyDown="TeclaPulsada(9)">';
					reset($signos);
					while(list($c,$v) = each($signos))
					{
						if ($cmbsignoau == $v)
							echo '<option value="'.$v.'" selected>'.$v.'</option>';
						else
							echo '<option value="'.$v.'">'.$v.'</option>';
					}
              		echo '</select>';
				//}
			?>

              <input name="txtleyau" type="text" id="txtleyau" onKeyDown="TeclaPulsada(10)" value="<?php echo $txtleyau ?>" size="15" maxlength="12">
              <select name="cmbunidau" onKeyDown="TeclaPulsada(11)">
			  <?php
			  	reset($unidad);			  
			 	while(list($c,$v) = each($unidad))
				{
					if ($c == $cmbunidau)
						echo '<option value="'.$c.'" selected>'.$v.'</option>';
					else
						echo '<option value="'.$c.'">'.$v.'</option>';
				}
			  ?>			  
              </select> </td>
			<!--						
            <td>Fino Au:</td>
            <td><input name="txtfinoau" type="text" id="txtfinoau" size="15" maxlength="12" onKeyDown="TeclaPulsada(true)" value="<?php echo $txtfinoau ?>"></td>
			-->			
          </tr>
        </table> 
        <br>
        <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td align="center"> 
              <?php
				if ($opc == "B")
					echo '<input name="btnmodificar" type="button" value="Modificar" style="width:70" onClick="Modificar()">';
				else
					echo '<input name="btngrabar" type="button" value="Grabar" style="width:70" onClick="Grabar()">';
			?>
              <input name="btneliminar" type="button" value="Eliminar" style="width:70" onClick="Eliminar()"> 
              <input name="btnconsultar" type="button" value="Consultar" style="width:70" onClick="Consultar()">
              <input name="btncancelar" type="button" style="width:70" value="Cancelar" onClick="Cancelar()"> 
              <input name="btnsalir" type="button" value="Salir" style="width:70" onClick="Salir()"></td>
          </tr>
        </table> 
      </td>
</tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php 	include("../principal/cerrar_pmn_web.php"); ?>