<?php
	$CodigoDeSistema = 6;
	$CodigoDePantalla = 140;
	
	include("../principal/conectar_pmn_web.php");	
?>
<html>
<head>
<title>PMN - Tipo Movimiento</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1()
{
	var f = document.frmPrincipal;
	
	if (f.cmbmovimiento.value == -1)
		f.action = "pmn_con_tipo_movimiento.php";
	else
		f.action = "pmn_con_tipo_movimiento.php?recargapag1=S&cmbmovimiento=" + f.cmbmovimiento.value;
	f.submit();
}
/***************/
function Recarga2()
{	
	var f = document.frmPrincipal;
	
	document.location = "pmn_con_tipo_movimiento.php?recargapag1=S&recargapag2=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&ano1=" + f.ano1.value + "&mes1=" + f.mes1.value;
	
		
//	f.action = "pmn_con_tipo_movimiento.php?recargapag1=S&recargapag2=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value;
//	f.submit();	
}
/***************/
function Recarga3()
{
	var f = document.frmPrincipal;
	
	f.action = "pmn_con_tipo_movimiento.php?recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value;
	f.submit();		
}
/****************/
function ValidaCampos()
{
	var f = document.frmPrincipal;
	
	if (f.cmbmovimiento.value == -1)
	{	
		alert("Debe Seleccionar Tipo Movimiento");
		return false;
	}
	
	if (f.cmbproducto.value == -1)
	{	
		alert("Debe Seleccionar El Producto");
		return false;
	}	
	
	if (f.cmbsubproducto.value == -1)
	{	
		alert("Debe Seleccionar El Subproducto");
		return false;		
	}	
	
	return true; 
}
/*****************/
function Consultar()
{
	var f = document.frmPrincipal;
	if (ValidaCampos()) 
	{
		if (f.mes1.value < 10)
			mes = '0' + f.mes1.value;
		else
			mes = f.mes1.value;
			
		var linea = "FechaIni=" + f.ano1.value + '-' + mes + '-01' + "&FechaFin=" + f.ano1.value + '-' + mes + '-31';
	
		if (f.cmbmovimiento.value == 1) //Recepcion.
		{		
			if ((f.cmbproducto.value == '25') && (f.cmbsubproducto.value == '5')) //Bad Codelco.
				f.action = "pmn_con_balance_recepcion_bad_codelco.php?" + linea;
			else	
			if ((f.cmbproducto.value == '25') && (f.cmbsubproducto.value == '1')) //Bad Ventana.
				f.action = "pmn_con_balance_recepcion_bad_ventana.php?" + linea;				
			else	
			if ((f.cmbproducto.value == '34') && (f.cmbsubproducto.value == '3')) //Oro Compra.
				f.action = "pmn_con_balance_recepcion_oro_compra.php?" + linea;
			else	
			if ((f.cmbproducto.value == '44') && (f.cmbsubproducto.value == '3')) //Metal Dore Florida.
				f.action = "pmn_con_balance_recepcion_metal_dore_florida.php?" + linea;
			else	
			if ((f.cmbproducto.value == '44') && (f.cmbsubproducto.value == '2')) //Metal Dore Can-Can.
				f.action = "pmn_con_balance_recepcion_metal_dore_cancan.php?" + linea;
			else				
				//Otros Productos.	
				f.action = "pmn_con_balance_productos_adicionales.php?" + linea;								
		}
		else
		if (f.cmbmovimiento.value == 2) //Beneficio.
		{
			if ((f.cmbproducto.value == '25') && (f.cmbsubproducto.value == '1')) //Bad Ventana.
				f.action = "pmn_con_balance_beneficio_bad_ventana.php?" + linea;
			else	
			if ((f.cmbproducto.value == '25') && (f.cmbsubproducto.value == '5')) //Bad Codelco.
				f.action = "pmn_con_balance_beneficio_bad_codelco.php?" + linea;
			else
			if ((f.cmbproducto.value == '44') && (f.cmbsubproducto.value == '1')) //Metal Dore Ventana.
				f.action = "pmn_con_balance_beneficio_metal_dore_ventana.php?" + linea;										
			else
				//Otros Productos.	
				f.action = "pmn_con_balance_productos_adicionales.php?" + linea;			
		}
		else
		if (f.cmbmovimiento.value == 3) //Produccion.
		{
			if ((f.cmbproducto.value == '29') && (f.cmbsubproducto.value == '4')) //Plata Electrolitica.
				f.action = "pmn_con_balance_produccion_plata.php?" + linea;
			else	
			if ((f.cmbproducto.value == '34') && (f.cmbsubproducto.value == '2')) //Oro Electrolitico.
				f.action = "pmn_con_balance_produccion_oro.php?" + linea;
			else	
			if ((f.cmbproducto.value == '26') && (f.cmbsubproducto.value == '2')) //Barro Aurifero Lixiviado.
				f.action = "pmn_con_balance_produccion_barro_aurifero.php?" + linea;
			else	
			if ((f.cmbproducto.value == '26') && (f.cmbsubproducto.value == '1')) //Barro Aurifero Crudo.
				f.action = "pmn_con_balance_produccion_barro_aurifero_crudo.php?" + linea;
			else
			if ((f.cmbproducto.value == '47') && (f.cmbsubproducto.value == '1')) //Teluro.
				f.action = "pmn_con_balance_produccion_teluro.php?" + linea;										
			else	
			if ((f.cmbproducto.value == '31') && (f.cmbsubproducto.value == '1')) //Selenio.
				f.action = "pmn_con_balance_produccion_selenio.php?" + linea;
			else	
			if ((f.cmbproducto.value == '33') && (f.cmbsubproducto.value == '2')) //Platino-Paladio.
				f.action = "pmn_con_balance_produccion_platino_paladio.php?" + linea;
			else	
			if ((f.cmbproducto.value == '28') && (f.cmbsubproducto.value == '1')) //Escoria Fusion.
				f.action = "pmn_con_balance_produccion_escoria.php?" + linea;
			else
			if ((f.cmbproducto.value == '44') && (f.cmbsubproducto.value == '1')) //Metal Dore Ventana.
				f.action = "pmn_con_balance_recepcion_metal_dore_ventana.php?" + linea;			
			else
				//Otros Productos.	
				f.action = "pmn_con_balance_productos_adicionales.php?" + linea;																			
		}
		else
		if (f.cmbmovimiento.value == 4) //Embarque.
		{		
			if ((f.cmbproducto.value == '28') && (f.cmbsubproducto.value == '1')) //Esc. Fusion.
				f.action = "pmn_con_balance_embarque_escoria.php?" + linea;
			else			
			if ((f.cmbproducto.value == '29') && (f.cmbsubproducto.value == '4')) //Plata.
				f.action = "pmn_con_balance_embarque_plata.php?" + linea;
			else
			if ((f.cmbproducto.value == '31') && (f.cmbsubproducto.value == '1')) //Selenio.
				f.action = "pmn_con_balance_embarque_selenio.php?" + linea;
			else
		if ((f.cmbproducto.value == '33') && (f.cmbsubproducto.value == '2')) //Paladio Platino.
				f.action = "pmn_con_balance_embarque_platino_paladio.php?" + linea;
			else
			if ((f.cmbproducto.value == '34') && (f.cmbsubproducto.value == '2')) //Oro.
				f.action = "pmn_con_balance_embarque_oro.php?" + linea;
			else	
			if ((f.cmbproducto.value == '47') && (f.cmbsubproducto.value == '1')) //TELURO.
				f.action = "pmn_con_balance_embarque_teluro.php?" + linea;
			else													
				f.action = "pmn_con_balance_productos_adicionales.php?" + linea;//Otros Productos.									
		}						
		f.submit();
	}
}
/*******************/
function Excel()
{
	var f = document.frmPrincipal;
	if (ValidaCampos()) 
	{
		if (f.mes1.value < 10)
			mes = '0' + f.mes1.value;
		else
			mes = f.mes1.value;
			
		var linea = "FechaIni=" + f.ano1.value + '-' + mes + '-01' + "&FechaFin=" + f.ano1.value + '-' + mes + '-31';
	
		if (f.cmbmovimiento.value == 1) //Recepcion.
		{
			if ((f.cmbproducto.value == '25') && (f.cmbsubproducto.value == '5')) //Bad Codelco.
				f.action = "pmn_xls_balance_recepcion_bad_codelco.php?" + linea;
			else	
			if ((f.cmbproducto.value == '25') && (f.cmbsubproducto.value == '1')) //Bad Ventana.
				f.action = "pmn_xls_balance_recepcion_bad_ventana.php?" + linea;				
			else	
			if ((f.cmbproducto.value == '34') && (f.cmbsubproducto.value == '3')) //Oro Compra.
				f.action = "pmn_xls_balance_recepcion_oro_compra.php?" + linea;
			else	
			if ((f.cmbproducto.value == '44') && (f.cmbsubproducto.value == '3')) //Metal Dore Florida.
				f.action = "pmn_xls_balance_recepcion_metal_dore_florida.php?" + linea;
			else	
			if ((f.cmbproducto.value == '44') && (f.cmbsubproducto.value == '2')) //Metal Dore Can-Can.
				f.action = "pmn_xls_balance_recepcion_metal_dore_cancan.php?" + linea;				
			else
				//Otros Productos.	
				f.action = "pmn_xls_balance_productos_adicionales.php?" + linea;											
		}
		else
		if (f.cmbmovimiento.value == 2) //Beneficio.
		{
			if ((f.cmbproducto.value == '25') && (f.cmbsubproducto.value == '1')) //Bad Ventana.
				f.action = "pmn_xls_balance_beneficio_bad_ventana.php?" + linea;
			else	
			if ((f.cmbproducto.value == '25') && (f.cmbsubproducto.value == '5')) //Bad Codelco.
				f.action = "pmn_xls_balance_beneficio_bad_codelco.php?" + linea;
			else
			if ((f.cmbproducto.value == '44') && (f.cmbsubproducto.value == '1')) //Metal Dore Ventana.
				f.action = "pmn_xls_balance_beneficio_metal_dore_ventana.php?" + linea;										
			else
				//Otros Productos.	
				f.action = "pmn_xls_balance_productos_adicionales.php?" + linea;										
		}
		else		
		if (f.cmbmovimiento.value == 3) //Produccion.
		{
			if ((f.cmbproducto.value == '29') && (f.cmbsubproducto.value == '4')) //Plata Electrolitica.
				f.action = "pmn_xls_balance_produccion_plata.php?" + linea;
			else	
			if ((f.cmbproducto.value == '34') && (f.cmbsubproducto.value == '2')) //Oro Electrolitico.
				f.action = "pmn_xls_balance_produccion_oro.php?" + linea;
			else	
			if ((f.cmbproducto.value == '26') && (f.cmbsubproducto.value == '2')) //Barro Aurifero.
				f.action = "pmn_xls_balance_produccion_barro_aurifero.php?" + linea;
			else	
			if ((f.cmbproducto.value == '26') && (f.cmbsubproducto.value == '1')) //Barro Aurifero Crudo.
				f.action = "pmn_xls_balance_produccion_barro_aurifero_crudo.php?" + linea;				
			else
			if ((f.cmbproducto.value == '47') && (f.cmbsubproducto.value == '1')) //Teluro.
				f.action = "pmn_xls_balance_produccion_teluro.php?" + linea;										
			else	
			if ((f.cmbproducto.value == '31') && (f.cmbsubproducto.value == '1')) //Selenio.
				f.action = "pmn_xls_balance_produccion_selenio.php?" + linea;
			else	
			if ((f.cmbproducto.value == '33') && (f.cmbsubproducto.value == '2')) //Platino-Paladio.
				f.action = "pmn_xls_balance_produccion_platino_paladio.php?" + linea;
			else	
			if ((f.cmbproducto.value == '28') && (f.cmbsubproducto.value == '1')) //Escoria Fusion.
				f.action = "pmn_xls_balance_produccion_escoria.php?" + linea;
			else
			if ((f.cmbproducto.value == '44') && (f.cmbsubproducto.value == '1')) //Metal Dore Ventana.
				f.action = "pmn_xls_balance_recepcion_metal_dore_ventana.php?" + linea;
			else
				//Otros Productos.	
				f.action = "pmn_xls_balance_productos_adicionales.php?" + linea;																				
		}				
		else		
		if (f.cmbmovimiento.value == 4) //Embarque.
		{		
			if ((f.cmbproducto.value == '28') && (f.cmbsubproducto.value == '1')) //Esc. Fusion.
				f.action = "pmn_xls_balance_embarque_escoria.php?" + linea;
			else			
			if ((f.cmbproducto.value == '29') && (f.cmbsubproducto.value == '4')) //Plata.
				f.action = "pmn_xls_balance_embarque_plata.php?" + linea;
			else
			if ((f.cmbproducto.value == '31') && (f.cmbsubproducto.value == '1')) //Selenio.
				f.action = "pmn_xls_balance_embarque_selenio.php?" + linea;
			else
			if ((f.cmbproducto.value == '33') && (f.cmbsubproducto.value == '2')) //Paladio Platino.
				f.action = "pmn_xls_balance_embarque_platino_paladio.php?" + linea;
			else
			if ((f.cmbproducto.value == '34') && (f.cmbsubproducto.value == '2')) //Oro.
				f.action = "pmn_xls_balance_embarque_oro.php?" + linea;
			else	
			if ((f.cmbproducto.value == '47') && (f.cmbsubproducto.value == '1')) //TELURO.
				f.action = "pmn_xls_balance_embarque_teluro.php?" + linea;
			else													
				f.action = "pmn_xls_balance_productos_adicionales.php?" + linea;//Otros Productos.									
		}
		else
			//Otros Productos.	
			f.action = "pmn_xls_balance_productos_adicionales.php?" + linea;							
				
		f.submit();		
	}
}
/*******************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=6&Nivel=1&CodPantalla=120";
}
</script>
</head>

<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<?php include("../principal/encabezado.php")?>

<table width="770" border="0" class="TablaPrincipal">
<tr>
<td height="330">
<table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="127">TIPO MOVIMIENTO</td>
            <td colspan="2"> <select name="cmbmovimiento"  onChange="Recarga1()">
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
			?>
              </select></td>
            <td>FLUJO:
			<?php
				if ($recargapag3 == "S")
				{
					$consulta = "SELECT * FROM pmn_web.relacion_flujo";
					$consulta.= " WHERE tipo_mov = '".$cmbmovimiento."' AND cod_producto = '".$cmbproducto."' AND cod_subproducto = '".$cmbsubproducto."'";
					//if ($cmbmovimiento == '99')
					//	$consulta.= " AND signo = '".$radiotipo."'";
					//echo $consulta."<br>";
					$rs = mysqli_query($link, $consulta);
					if ($row = mysqli_fetch_array($rs))
					{
						echo $row["flujo"];
					}
				}			
			?>
			</td>
          </tr>
          <tr> 
            <td>PRODUCTO </td>
            <td colspan="3"><select name="cmbproducto" onChange="Recarga2()">
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
			?>
              </select></td>
          </tr>
          <tr> 
            <td>SUBPRODUCTO</td>
            <td colspan="3"><select name="cmbsubproducto" onChange="Recarga3()">
                <option value="-1">SELECCIONAR</option>
                <?php
				if ($recargapag2 == "S")
				{
					$consulta = "SELECT * FROM proyecto_modernizacion.subproducto";
					$consulta.= " WHERE cod_producto = '".$cmbproducto."' AND tipo_mov_pmn LIKE '%".$cmbmovimiento."%'";
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
						if ($row["cod_subproducto"] == $cmbsubproducto)
							echo '<option value="'.$row["cod_subproducto"].'" selected>'.$row["descripcion"].'</option>';
						else
							echo '<option value="'.$row["cod_subproducto"].'">'.$row["descripcion"].'</option>';
					}
				}
			?>
              </select></td>
          </tr>
          <tr> 
            <td>PERIODO</td>
            <td width="198"> 
              <?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	 	
		
		/*
		echo '<select name="dia1" size="1">';
		for ($i=1;$i<=31;$i++)
		{	
			if (($recargapag1 == "S") && ($i == $dia1))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($recargapag1 != "S")) 
					echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}
		*/
		
	?></select>
              <select name="mes1" size="1">
                <?php
		for($i=1;$i<13;$i++)
		{
			if (($recargapag1 == "S") && ($i == $mes1))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($recargapag1 != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
              </select> <select name="ano1" size="1">
                <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag1 == "S") && ($i == $ano1))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($recargapag1 != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
              </select></td>
            <td width="22">&nbsp;</td>
            <td width="226"> 
              <?php
				/*
			?>
              <select name="dia2" size="1">
                <?php	
		for ($i=1;$i<=31;$i++)
		{	
			if (($recargapag1 == "S") && ($i == $dia2))			
				echo "<option selected value= '".$i."'>".$i."</option>";				
			else if (($i == date("j")) and ($recargapag1 != "S")) 
					echo "<option selected value= '".$i."'>".$i."</option>";											
			else					
				echo "<option value='".$i."'>".$i."</option>";												
		}
	?>
              </select> <select name="mes2" size="1">
                <?php
		for($i=1;$i<13;$i++)
		{
			if (($recargapag1 == "S") && ($i == $mes2))
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else if (($i == date("n")) && ($recargapag1 != "S"))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
			else
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
		}		  
	?>
              </select> <select name="ano2" size="1">
                <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag1 == "S") && ($i == $ano2))
				echo "<option selected value ='$i'>$i</option>";
			else if (($i == date("Y")) && ($recargapag1 != "S"))
				echo "<option selected value ='$i'>$i</option>";
			else	
				echo "<option value='".$i."'>".$i."</option>";
		}
	?>
              </select> 
              <?php
			  	  */
			  ?>
            </td>
          </tr>
          <tr> 
            <td>CALCULOS </td>
            <td><input name="TipoCalculo" type="radio" value="L" checked>
              Leyes 
              <input name="TipoCalculo" type="radio"  value="F">
              Finos</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>

        <br>
        <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr>
            <td align="center">
<input name="btnconsultar" type="button" id="btnconsultar" value="Consultar" style="width:70" onClick="Consultar()">
              <input name="btnexcel" type="button" id="btnexcel" value="Excel" style="width:70" onClick="Excel()">
              <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width:70" onClick="Salir()">
            </td>
          </tr>
      </table> </td>
</tr>
</table>

<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
<?php 	include("../principal/cerrar_pmn_web.php"); ?>
