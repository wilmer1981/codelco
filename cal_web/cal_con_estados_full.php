<?php
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 68;
	set_time_limit(1000);
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["ChkSolicitud"])) {
		$ChkSolicitud = $_REQUEST["ChkSolicitud"];
	}else{
		$ChkSolicitud="S";
	}
	if(isset($_REQUEST["Busq"])) {
		$Busq = $_REQUEST["Busq"];
	}else{
		$Busq="";
	}
	if(isset($_REQUEST["Mostrar"])) {
		$Mostrar = $_REQUEST["Mostrar"];
	}else{
		$Mostrar ="";
	}
	if(isset($_REQUEST["CmbProductos"])) {
		$CmbProductos = $_REQUEST["CmbProductos"];
	}else{
		$CmbProductos ="";
	}
	if(isset($_REQUEST["CmbSubProducto"])) {
		$CmbSubProducto = $_REQUEST["CmbSubProducto"];
	}else{
		$CmbSubProducto ="";
	}
	if(isset($_REQUEST["Proveedor"])) {
		$Proveedor = $_REQUEST["Proveedor"];
	}else{
		$Proveedor ="";
	}
	if(isset($_REQUEST["TxtFiltroPrv"])) {
		$TxtFiltroPrv = $_REQUEST["TxtFiltroPrv"];
	}else{
		$TxtFiltroPrv ="";
	}
	
	
	if(isset($_REQUEST["CmbSeleccion"])) {
		$CmbSeleccion = $_REQUEST["CmbSeleccion"];
	}else{
		$CmbSeleccion ="";
	}
	if(isset($_REQUEST["CmbEstado"])) {
		$CmbEstado = $_REQUEST["CmbEstado"];
	}else{
		$CmbEstado ="";
	}
	
	if(isset($_REQUEST["Mes"])) {
		$Mes = $_REQUEST["Mes"];
	}else{
		$Mes = date("m");
	}
	if(isset($_REQUEST["Ano"])) {
		$Ano = $_REQUEST["Ano"];
	}else{
		$Ano = date("Y");
	}
	if(isset($_REQUEST["Orden"])) {
		$Orden = $_REQUEST["Orden"];
	}else{
		$Orden ="";
	}

	
?>
<html>
<head>
<title>CAL- Estados Solicitudes</title>
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(opt,valor)
{
	var f = document.frmPrincipal;
	switch (opt)
	{		
		case "S":
			f.action = "../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
			f.submit();
			break;
		case "I":
			window.print();
			break;		
		case "R":
			f.action = "cal_con_estados_full.php";
			f.submit(); 
			break;
		case "C":
			if(f.CmbSeleccion.value=='-1')
			{
				alert("Debe Seleccionar Select. Por.");
				f.CmbSeleccion.focus();
				return;
			}
			f.action = "cal_con_estados_full.php?Mostrar=S";
			f.submit(); 
			break;
		case "E":
			if(f.CmbSeleccion.value=='1')
			{
				URL='cal_con_estados_full_excel.php?Mes='+f.Mes.value+'&Ano='+f.Ano.value+'&CmbProductos='+f.CmbProductos.value+'&CmbSubProducto='+f.CmbSubProducto.value+'&Proveedor='+f.Proveedor.value+'&CmbEstado='+f.CmbEstado.value+'&Orden=<?php echo $Orden; ?>';
				window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
			}
			else
			{
				URL='cal_con_estados_full_excel.php?Mes='+f.Mes.value+'&Ano='+f.Ano.value+'&CmbProductos='+f.CmbProductos.value+'&CmbSubProducto='+f.CmbSubProducto.value+'&CmbEstado='+f.CmbEstado.value+'&Orden=<?php echo $Orden; ?>';
				window.open(URL,"","top=30,left=30,width=1000,height=550,status=yes,menubar=yes,resizable=yes,scrollbars=yes");
			}
			break;		
		case "O": //ORDENA
			f.action = "cal_con_estados_full.php?Mostrar=S&Orden=" + valor;
			f.submit();
			break;
	}	
}

function Historial(SA,Rec)
{
	window.open("cal_con_registro_leyes_solo.php?SA="+ SA+"&Recargo="+Rec,"","top=50,left=10,width=790,height=450,scrollbars=yes,resizable = yes");					
}

function DetalleAnalisis(SA,Rec)
{
	window.open("cal_con_detalle_leyes.php?SA="+ SA+"&Recargo="+Rec,"","top=70,left=50,width=400,height=430,scrollbars=yes,resizable = yes");					
}
function Recarga3()
{
	var Frm = document.frmPrincipal;
	Frm.action="cal_con_estados_full.php?Busq=S";
	Frm.submit();	
}
</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<input type="hidden" name="Valores" value="">
<input type="hidden" name="Sistema" value="<?php echo $Sistema; ?>">
<?php include("../principal/encabezado.php")?>
<table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
  <tr>
    <td width="761" align="center" valign="middle"><table width="850" border="1" cellspacing="0" cellpadding="3" class="TablaInterior">
      <tr align="center">
        <td height="23" colspan="4" class="ColorTabla02"><strong>ESTADOS DE SOLICITUDES</strong></td>
      </tr>
      <tr>
        <td width="68" height="23" align="right">Periodo:</td>
        <td colspan="3"><select name="Mes">
            <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
          </select>
            <select name="Ano" size="1">
              <?php
			for ($i=date("Y")-4;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
            </select>
        </td>
      </tr>
      <tr>
        <td height="23" align="right">Selec. Por.</td>
        <td width="291" height="23" colspan="3"><select name="CmbSeleccion" style="width:250" onChange="Proceso('R')">
            <option class="NoSelec" value="-1">Seleccionar</option>
            <?php 					
				switch($CmbSeleccion)
				{
					case "1":
						echo "<option selected value='1'>Producto Minero</option>";
						$CmbProductos='1';
						echo "<option  value='2'>Otros Productos</option>";
					break;
					case "2":
						echo "<option value='1'>Producto Minero</option>";
						echo "<option selected value='2'>Otros Productos</option>";
					break;
					default:
						echo "<option value='1'>Producto Minero</option>";
						echo "<option value='2'>Otros Productos</option>";
					break;
				}
			?>
        </select></td>
      </tr>
      <tr>
        <td height="23" align="right">Producto:</td>
        <td width="291" height="23" colspan="3"><select name="CmbProductos" style="width:250" onChange="Proceso('R')">
            <option class="NoSelec" value="S">TODOS</option>
            <?php 		
				if($CmbSeleccion!='-1')
				{
					$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos";
					if($CmbSeleccion=='1')
						$Consulta.=" where cod_producto='1'"; 
					if($CmbSeleccion!='1'&&$CmbSeleccion!='-1')
						$Consulta.=" where cod_producto not in('1')"; 
					$Consulta.=" order by descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
							echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						else
							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				}
			?>
          </select>
            <?php //echo $Consulta;?></td>
      </tr>
      <tr>
        <td height="23" align="right">SubProducto:</td>
        <td height="23" colspan="3"><select name="CmbSubProducto" style="width:250" onChange="Proceso('R')">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				if($CmbSeleccion!='-1'&&$CmbProductos!='S')
				{
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' order by descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						else
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
				}
			?>
        </select></td>
      </tr>
      <?php
		if($CmbProductos=='1')
		{
		?>
      <tr>
        <td height="23" align="right">Proveedores</td>
        <td width="291" height="23"><select name="Proveedor" style="width:300" onChange="Proceso('R')">
            <option class="NoSelec" value="S">TODOS</option>
            <?php
				$Consulta = "select distinct * from sipa_web.proveedores t1 inner join age_web.relaciones t2 ";
				$Consulta.= " on t1.rut_prv=t2.rut_proveedor ";
				$Consulta.= " where  t2.cod_producto='".$CmbProductos."'";
				if($Busq=='S'&&$TxtFiltroPrv!='')
				   $Consulta.= " and t1.nombre_prv like '%".$TxtFiltroPrv."%' "; 				
				$Consulta.= " group by rut_prv order by t1.nombre_prv";
				$Resp = mysqli_query($link, $Consulta);
				while ($Fila = mysqli_fetch_array($Resp))
				{
					if ($Proveedor == $Fila["rut_prv"])
						echo "<option selected value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
					else
						echo "<option value='".$Fila["rut_prv"]."'>".str_pad($Fila["rut_prv"],10,"0",STR_PAD_LEFT)."-".$Fila["nombre_prv"]."</option>\n";
				}
			?>
        </select></td>
        <td width="87" height="23" align="right">Filtro Prv</td>
        <td width="269" height="23"><input type="text" name="TxtFiltroPrv" size="10" value="<?php echo $TxtFiltroPrv;?>">
            <input name="BtnOkA2" type="button" value="Ok" onClick="Recarga3()"></td>
      </tr>
      <?php
		}
		?>
      <tr>
        <td height="30" align="right">Ver Estado:</td>
        <td height="30"><select name="CmbEstado" style="width:220"  >
            <option value="S" selected>Todas</option>
            <?php
			 $Consulta =  "select * from proyecto_modernizacion.sub_clase ";
			 $Consulta.= " where cod_clase = '1002' ";
			 $Consulta.= " and cod_subclase in('1','2','3','4','5','6','7','8','13','16')";
			 $Resultado = mysqli_query($link, $Consulta);
			 while ($Fila =mysqli_fetch_array ($Resultado))
			 {
				if ($CmbEstado == $Fila["cod_subclase"])
					echo"<option selected value='".$Fila["cod_subclase"]."'>".str_pad($Fila["cod_subclase"],2,'0',STR_PAD_LEFT)." - ".$Fila["nombre_subclase"]."</option>";
				else
					echo"<option value='".$Fila["cod_subclase"]."'>".str_pad($Fila["cod_subclase"],2,'0',STR_PAD_LEFT)." - ".$Fila["nombre_subclase"]."</option>";
			}
			 ?>
        </select></td>
        <td height="30" colspan="2"><table width="300" border="0" align="center" cellpadding="1" cellspacing="0">
            <tr>
              <td width="50" bgcolor="#FFFFFF">&nbsp;</td>
              <td>Finalizada</td>
              <td width="50" bgcolor="#FFFF00">&nbsp;</td>
              <td>No Finalizada </td>
            </tr>
        </table></td>
      </tr>
      <tr align="center">
        <td height="30" colspan="4"><input name="btnconsultar" type="button" value="Consultar" onClick="Proceso('C')" style="width:70px;">
            <input name="BtnExcel" type="button" id="BtnExcel" style="width:70px;" onClick="Proceso('E')" value="Excel">
            <input name="BtnImprimir" type="button" id="BtnImprimir" style="width:70px;" onClick="Proceso('I')" value="Imprimir">
            <input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:70px;" onClick="Proceso('S')"></td>
      </tr>
    </table>
      <br>
      <br>
      <?php		
		if ($Mostrar=="S")
		{
			if($CmbSeleccion=='1')
				include('cal_con_estados_full_producto_minero.php');
			else
				include('cal_con_estados_full_otros_productos.php');	
		}//FIN MOSTRAR = S	
		?><br>
    </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
