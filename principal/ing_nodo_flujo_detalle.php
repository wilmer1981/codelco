<?php
	//include("../principal/conectar_comet_web.php");
	include("../principal/conectar_principal.php");
	//opc=M&nodo=1001&sistema=CCU&flujo=100&tipo2=E
	if(isset($_REQUEST["opc"])){
		$opc=$_REQUEST["opc"];
	}else{
		$opc="";
	}

	if(isset($_REQUEST["sistema"])){
		$sistema=$_REQUEST["sistema"];
	}else{
		$sistema="";
	}
	if(isset($_REQUEST["nodo"])){
		$nodo=$_REQUEST["nodo"];
	}else{
		$nodo="";
	}
	if(isset($_REQUEST["flujo"])){
		$flujo=$_REQUEST["flujo"];
	}else{
		$flujo="";
	}
	if(isset($_REQUEST["tipo2"])){
		$tipo2=$_REQUEST["tipo2"];
	}else{
		$tipo2="";
	}
	if(isset($_REQUEST["recargapag1"])){
		$recargapag1=$_REQUEST["recargapag1"];
	}else{
		$recargapag1="";
	}
	if(isset($_REQUEST["recargapag2"])){
		$recargapag2=$_REQUEST["recargapag2"];
	}else{
		$recargapag2="";
	}
	if(isset($_REQUEST["recargapag3"])){
		$recargapag3=$_REQUEST["recargapag3"];
	}else{
		$recargapag3="";
	}


	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$SistemasRel = array('CCU'=>'CCU', 'PMN'=>'PMN');
	$consulta = "SELECT * FROM proyecto_modernizacion.nodos";
	$consulta.= " WHERE cod_nodo = '".$nodo."' AND sistema = '".$sistema."'";
	$rs2 = mysqli_query($link, $consulta);
	$row2 = mysqli_fetch_array($rs2);
	switch ($row2["tipo_balance"])
	{
	   case "PMN":
	   	$OrigenCalculo='1';
	   	break;
	   case "CCU":
	   	if ($nodo=='93')
			$OrigenCalculo='1';
		else
			$OrigenCalculo='2';	
	   	break;
	}
	  if(!isset($CmbAno))
	  {
		$CmbAno=date('Y');
		$CmbMes=date('n');
	  }
	$HabilitaMesYAno= 'disabled';
	$HabilitarGrabar='';
	$Bloq3 = '';
	$txtflujo ="";
	$txtdescripcion ="";
	$RadTipo2 = "";
	$RadTipo1 = '';
	if ($opc == 'M')
	{
		$consulta = "SELECT * FROM proyecto_modernizacion.flujos";
		$consulta.= " WHERE nodo = '".$nodo."' AND sistema = '".$sistema."' AND cod_flujo = '".$flujo."'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);

		$txtflujo = $row["cod_flujo"];
		$txtdescripcion = $row["descripcion"];
		$cmbtabla = $row["tabla"];
		$txtsuma = $row["suma"];
		$txtresta = $row["resta"];
		if ($row["tipo"] == 'E')
			$RadTipo1 = 'checked';
		else
			$RadTipo2 = 'checked';
		if ($row["calcular"] == 'S')
			$RadCalcula1 = 'checked';
		else
		{
			$RadCalcula2 = 'checked';
			$Bloq1 = 'disabled';
		}
		$Bloq3 = 'readonly';
		if($recargapag1=='S'||$recargapag2=='S'||$recargapag3=='S')
		{
			echo '';
		}	
		else
		{
			$consulta = "SELECT * FROM pmn_web.relacion_flujo";
			$consulta.= " WHERE nodo = '".$nodo."' AND flujo = '".$flujo."'";
			$rs2 = mysqli_query($link, $consulta);
			if($row2 = mysqli_fetch_array($rs2))
			{
				$cmbproducto=$row2["cod_producto"];
				$cmbsubproducto=$row2["cod_subproducto"];
				$cmbmovimiento=$row2["tipo_mov"];
				$recargapag1='S';
				$recargapag2='S';
				$recargapag3='S';
			}
		}	
	}
	else
	{
		$RadTipo1 = 'checked';
		$RadCalcula2 = 'checked';
		$Bloq1 = 'disabled';
		$Bloq2 = 'disabled';		
		$CheckValorizacion = 'checked';		
		$HabilitaNodoProceso = 'disabled';
	}
?>
<html>
<head>
<title>Ingreso Flujo</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Bloquea1()
{
	var f = document.FrmDetalle;
	
	if (f.radiocalcula[0].checked == true)
		valor = false;
	else
		valor = true;
		
	f.txtsuma.disabled = valor;
	f.txtresta.disabled = valor;
}
/*****************/
function HabilitaNodo()
{	
	var f = document.FrmDetalle;
	
	if (f.absorve_maq.checked == true)	
		f.nodo_proceso.disabled = false;
	else 
		f.nodo_proceso.disabled = true;	
}
function HabilitaMesAno()
{	
	var f = document.FrmDetalle;
	
	if (f.insertar_mes.checked == true)	
	{
		f.CmbMes.disabled = false;
		f.CmbAno.disabled = false;
	}	
	else 
	{
		f.CmbMes.disabled = true;
		f.CmbAno.disabled = true;	
	}	
}

/******************/
function Valida()
{
	var f = document.FrmDetalle;
	
	if (f.txtflujo.value == "")
	{
		alert("Debe Ingresar Flujo");
		return false;
	}
	
	if (f.txtdescripcion.value == "")
	{	
		alert("Debe Ingresar Descripcion");
		return false;
	}
	
	return true;
}
/******************/
function Proceso(opc)
{
	var f = document.FrmDetalle;
	var linea = "sistema=" + f.sistema.value + "&nodo=" + f.nodo.value;
	
	switch (opc) {
		case 'G':
			if (Valida())
			{
				linea = linea + "&proceso=GF"
				f.action = "ing_nodo_flujo01.php?" + linea;
				f.submit();
			}
			break;
						
		case 'M':
			if (Valida())
			{
				linea = linea + "&proceso=MF"
				f.action = "ing_nodo_flujo01.php?" + linea;
				f.submit();			
			}
			break;
			
		case 'E':
			if(confirm('Esta Seguro de Eliminar el Flujo'))
			{
				linea = linea + "&proceso=EF"
				f.action = "ing_nodo_flujo01.php?" + linea;
				f.submit();
			}				
			break;
			
		case 'B':
			window.open("ing_nodo_flujo_detalle_popup.php?" + linea,"","top=100,left=135,width=500,height=350,scrollbars=yes,resizable=no");
			break;
			
		case 'C':
			document.location = "ing_nodo_flujo_detalle.php?" + linea;
			break;
			
		case 'S':
			window.close();
			break;			
	}
}
function Recarga1(opc)
{
	var f = document.FrmDetalle;
	
	if (f.cmbmovimiento.value == -1)
		f.action = "ing_nodo_flujo_detalle.php?opc="+opc+"&flujo="+f.txtflujo.value;
	else
		f.action = "ing_nodo_flujo_detalle.php?recargapag1=S&cmbmovimiento=" + f.cmbmovimiento.value+"&opc="+opc+"&flujo="+f.txtflujo.value;
	f.submit();
}
function Recarga2(opc)
{
	var f = document.FrmDetalle;
	
	f.action = "ing_nodo_flujo_detalle.php?recargapag1=S&recargapag2=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value+"&opc="+opc+"&flujo="+f.txtflujo.value;
	f.submit();
}
/*****************/
function Recarga3(opc)
{
	var f = document.FrmDetalle;

	f.action = "ing_nodo_flujo_detalle.php?recargapag1=S&recargapag2=S&recargapag3=S&cmbmovimiento=" + f.cmbmovimiento.value + "&cmbproducto=" + f.cmbproducto.value + "&cmbsubproducto=" + f.cmbsubproducto.value+"&opc="+opc+"&flujo="+f.txtflujo.value;	
	f.submit();	
}

</script>
<?php
	$consulta = "SELECT cod_subclase FROM proyecto_modernizacion.sub_clase";
	$consulta.= " WHERE cod_clase = '14000' AND valor_subclase2 = 'H'";
	$rs2 = mysqli_query($link, $consulta);
	while ($row2 = mysqli_fetch_array($rs2))
		$Vector2[] = $row2["cod_subclase"];

	echo '<script language="JavaScript">';
	echo 'function Bloquea2()';
	echo '{';
	echo '	var f = document.FrmDetalle;';
	echo '	var valores = "'.implode(',',$Vector2).'";';
	echo '	var vector = valores.split(",");';
	echo '	valor = true;';
	echo '	for(i=0; i< vector.length; i++)';
	echo '	{';
	echo '		if (vector[i] == f.cmbtipocalculo.value)';
	echo '		{';
	echo '			valor = false;';
	echo '			break;';
	echo '		}';
	echo '	}';
	echo '	f.cmbsistamarel.disabled = valor;';
	echo '	f.txtnodorel.disabled = valor;';
	echo '	f.txtflujorel.disabled = valor';
	echo '}';
	echo '</script>';
?>

</head>
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmDetalle" action="" method="post">
<table width="700" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr>
      <td align="center">Ingreso De Flujo Asociado Al Nodo</td>
  </tr>
</table>
<br>
  <table width="700" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr> 
	<?php
		echo '<input name="nodo" type="hidden" value="'.$nodo.'">';
		echo '<input name="sistema" type="hidden" value="'.$sistema.'">';
		echo '<input name="tipo" type="hidden" value="'.$tipo2.'">';
		
		$consulta = "SELECT descripcion,sistema,virtual as esvirtual FROM proyecto_modernizacion.nodos";
		$consulta.= " WHERE cod_nodo = '".$nodo."' AND sistema = '".$sistema."'";
		//echo $consulta."<br>";
		$rs = mysqli_query($link, $consulta);
		$row = mysqli_fetch_array($rs);
		if ($row["esvirtual"]=='S')
		{
			$CheckVirtual = 'checked';		
		}
	?>
     <td width="40">Nodo:</td>
     <td width="323" align="left"><?php echo $row["descripcion"] ?></td>
     <td width="52">Sistema:</td>
     <td width="158" align="left"><?php echo $sistema ?></td>	
    </tr>
  </table>
<br>
  <table width="700" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr> 
      <td width="91">Flujo</td>
      <td width="108"><input name="txtflujo" type="text" value="<?php echo $txtflujo ?>"  size="10" <?php echo $Bloq3 ?>></td>
      <td width="121">&nbsp;</td>
      <td>&nbsp; </td>
      <td width="84">&nbsp;</td>
      <td width="82">&nbsp;</td>
    </tr>
    <tr> 
      <td>Descripcion</td>
      <td colspan="2"><input name="txtdescripcion" type="text" value="<?php echo $txtdescripcion ?>" size="50"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>Tipo</td>
      <td colspan="2"><input name="radiotipo" type="radio" value="E" <?php echo $RadTipo1 ?>>
        Entrada&nbsp;&nbsp;&nbsp; <input type="radio" name="radiotipo" value="S" <?php echo $RadTipo2 ?>>
        Salida
		</td>
      <td colspan="3">
      </td>
    </tr>
  </table>
  <br>
  <?php
	if ($sistema == 'PMN')  
	{
  
  ?>
  <table width="698" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr>
      <td colspan="2">Tipo Movimiento</td>
      <td colspan="2">
        <?php
				echo "<select name='cmbmovimiento' onChange=Recarga1('$opc') $bloquea>";
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
			?>
      </td>
    </tr>
    <tr>
      <td colspan="2">Producto</td>
      <td colspan="2">
        <?php
				echo "<select name='cmbproducto' onChange=Recarga2('$opc') $bloquea>";
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
				echo"</select>";
			?>
      </td>
    </tr>
    <tr>
      <td colspan="2">SubProducto</td>
      <td width="331">
        <?php
				echo "<select name='cmbsubproducto' onChange=Recarga3('$opc') $bloquea>";
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
					echo"</select>";
				?>
      </td>
      <td width="244"><strong>Flujo:
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
						$FlujoAsig=$row["flujo"];
						if($opc != 'M')
							$HabilitarGrabar='disabled';
					}
				}
				echo"</select>";
			?>
      </strong></td>
    </tr>
  </table><br>
<?php 
	}
	if ($sistema == 'PMN')  
	{
?>  
  <table width="700" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
    <tr> 
      <td>Rescatar Datos (Tabla)</td>
      <td colspan="3"><select name="cmbtabla">
          <?php
	  	$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
		$consulta.= " WHERE cod_clase = '6014'";
		$rs = mysqli_query($link, $consulta);
		while($row = mysqli_fetch_array($rs))
		{	
			if ($row["cod_subclase"] == $cmbtabla)
				echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
			else
				echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';						
		}
	  ?>
        </select></td>
    </tr>
    <tr> 
      <td width="134" height="21">Flujo Se Calcula</td>
      <td colspan="3"><input type="radio" name="radiocalcula" value="S" onClick="Bloquea1()" <?php echo $RadCalcula1 ?>>
        SI&nbsp;&nbsp; <input name="radiocalcula" type="radio" value="N" onClick="Bloquea1()" <?php echo $RadCalcula2 ?>>
        NO</td>
    </tr>
    <tr> 
      <td>Flujos Suma (Ent.)</td>
      <td width="166"><input name="txtsuma" type="text" value="<?php echo $txtsuma ?>" <?php echo $Bloq1 ?>></td>
      <td width="104">Flujos Resta (Sal.)</td>
      <td width="170"><input name="txtresta" type="text" value="<?php echo $txtresta ?>" <?php echo $Bloq1 ?>></td>
    </tr>
  </table>  
  <br>
<?php 
	}
?>  
<table width="700" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
  <tr>
    <td align="center">
	<?php
		if ($opc == 'M')
			echo '<input name="btnmodificar" type="button" value="Modificar" style="width=90" onClick="Proceso(\'M\')" '.$HabilitarGrabar.'>';		
		else
			echo '<input name="btnagrabar" type="button" value="Grabar" style="width=90" onClick="Proceso(\'G\')"'.$HabilitarGrabar.'>';
	?>
      <input name="btneliminar" type="button" id="btneliminar" value="Eliminar" style="width=90" onClick="Proceso('E')">
      <input name="btnconsultar" type="button" id="btnconsultar" value="Consultar" style="width=90" onClick="Proceso('B')">
        <input name="btncancelar" type="button" id="btncancelar" value="Cancelar" style="width=90" onClick="Proceso('C')">
        <input name="btnsalir" type="button" id="btnsalir" value="Salir" style="width=90" onClick="Proceso('S')"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
	if($HabilitarGrabar=='disabled'&& $opc != 'M')
	{
		echo "<script language='JavaScript'>";
		echo "alert('Tipo Movimiento,Prod y Subprod Ya Asignado al Flujo:$FlujoAsig')";
		echo "</script>";
	}	
?>