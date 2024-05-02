<?php 
	include("../principal/conectar_sec_web.php");
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 2;
?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(f)
{
	f.action = "sec_ing_cubas_proveedor.php?recargapag1=S";
	f.submit();
}
/******************/
function Recarga2(f)
{	
	f.action = "sec_ing_cubas_proveedor.php?recargapag1=S&recargapag2=S";
	f.submit();
}
/******************/
function Recarga3(f)
{	
	f.action = "sec_ing_cubas_proveedor.php?recargapag1=S&recargapag2=S&recargapag3=S";
	f.submit();
}
/******************/
function Grabar(f)
{
	f.action = "sec_ing_cubas_proveedor01.php?proceso=G";
	f.submit();
}
/******************/
function Limpiar()
{
	document.location = "sec_ing_cubas_proveedor.php";
}
/******************/
function Salir()
{		
	document.location = "../principal/sistemas_usuario.php?CodSistema=3";
}
</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php")?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">

<table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaDetalle">
  <tr>
    <td width="194">Circuito</td>
    <td width="300">
	<SELECT name="cmbcircuito" id="cmbcircuito" onChange="Recarga1(this.form)">
    <option value="-1">SELECCIONAR</option>
	<?php
		$consulta = "SELECT * FROM sec_web.circuitos ORDER BY cod_circuito";
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{	
			if ($row["cod_circuito"] == $cmbcircuito)
				echo '<option value="'.$row["cod_circuito"].'" SELECTed>'.$row["descripcion_circuito"].'</option>';
			else 
				echo '<option value="'.$row["cod_circuito"].'">'.$row["descripcion_circuito"].'</option>';
		}
	?>
    </SELECT></td>
  </tr>
  <tr>
    <td>Grupo</td>
    <td>
	<SELECT name="cmbgrupo" onChange="Recarga2(this.form)">
	<option value="-1">SELECCIONAR</option>
	<?php
		if ($recargapag1 == "S")
		{
			$consulta = "SELECT * FROM sec_web.grupo_electrolitico";
			$consulta.= " WHERE cod_circuito = '".$cmbcircuito."'";
			$consulta.= " ORDER BY cod_grupo"; 
			$rs1 = mysqli_query($link, $consulta);
			while ($row1 = mysqli_fetch_array($rs1))
			{
				if ($row1["cod_grupo"] == $cmbgrupo)
					echo '<option value="'.$row1["cod_grupo"].'" SELECTed>'.$row1["cod_grupo"].'</option>';
				else
					echo '<option value="'.$row1["cod_grupo"].'">'.$row1["cod_grupo"].'</option>';
			}
		}
	?>
     </SELECT></td>
  </tr>
  <tr>
    <td>Cuba</td>
    <td>
	<SELECT name="cmbcuba" onChange="Recarga3(this.form)">
	<option value="-1">SELECCIONAR</option>
	<?php
		if ($recargapag2 == "S") 
		{	
			$consulta = "SELECT * FROM sec_web.grupo_electrolitico";
			$consulta.= " WHERE cod_grupo = '".$cmbgrupo."'";
			$rs3 = mysqli_query($link, $consulta);
			$row3 = mysqli_fetch_array($rs3);
			$tope = $row3[num_cubas_tot];
			for ($i=1; $i<=$tope; $i++)
			{	
				if (strlen($i) == 1)
					$num = '0'.$i;
				else 
					$num = $i;
				
				if ($i == $cmbcuba)
					echo '<option value="'.$num.'" SELECTed>N� '.$num.'</option>';
				else	
					echo '<option value="'.$num.'">N� '.$num.'</option>';
			}
		}
	?>
    </SELECT></td>
  </tr>
  <tr>
    <td>Proveedor</td>
            <td><SELECT name="cmbproveedor">
                <option value="-1">SELECCIONAR</option>
				<?php
					$consulta = "SELECT * FROM sec_web.cubas_proveedor";
					$consulta.= " WHERE cod_circuito = '".$cmbcircuito."' AND cod_grupo = '".$cmbgrupo."' AND cod_cuba = '".$cmbcuba."'";
					$rs5 = mysqli_query($link, $consulta);
					if ($row5 = mysqli_fetch_array($rs5))
						$cmbproveedor = $row5[cod_proveedor];
					else
						$cmbproveedor = "";					
					
					$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase";
					$consulta.= " WHERE cod_clase = 3006";
					$rs4 = mysqli_query($link, $consulta);
					while ($row4 = mysqli_fetch_array($rs4))
					{	
						if ($row4["valor_subclase1"] == $cmbproveedor)
							echo '<option value="'.$row4["valor_subclase1"].'" SELECTed>'.$row4["nombre_subclase"].'</option>';
						else
							echo '<option value="'.$row4["valor_subclase1"].'">'.$row4["nombre_subclase"].'</option>';						
					}					
				?>
              </SELECT></td>
  </tr>
</table>
<br>
<table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaDetalle">
  <tr>
    <td align="center"><input name="btngrabar" type="button" value="Grabar" style="width=70" onClick="Grabar(this.form)">
              <input name="btnlimpiar" type="button" value="Limpiar" style="width=70" onClick="Limpiar()"> 
              <input name="btnsalir" type="button" value="Salir" style="width=70" onClick="Salir()"></td>
  </tr>
</table>

</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
