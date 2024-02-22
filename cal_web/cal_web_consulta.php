<?php 
	$CodigoDeSistema = 1;
	$CodigoDePantalla = 3;
?>
<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$Rut =$CookieRut;
?>

<html>
<head>
<title>Untitled Document</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="post" action="">
    <?php include("../principal/encabezado.php")?>
  <table width="769" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
      <td width="757"><font size="1"><font size="1"><font size="2"> </font></font></font> 
        <table width="758" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="4"><div align="center">Consulta Multiple De Producto</div></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="2"> &nbsp;Producto &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font><font size="1"><font size="2"><strong> 
              <select name="CmbProductos" style="width:280" onChange="Proceso('R');">
                <option value='-1' selected>Seleccionar</option>
                <?php 
					
					$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbProductos==$Fila["cod_producto"])
						{
							echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
						else
						{

							echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}
					
					
					}
					echo $CmbProductos."<br>";
				?>
              </select>
              </strong></font></font><font size="2"><strong></strong></font></font></td>
            <td width="231"><strong> </strong></td>
          </tr>
          <tr> 
            <td colspan="3"><font size="1"><font size="2"><strong> </strong></font><font size="1"><font size="2">&nbsp;Sub 
              Producto&nbsp;<strong> </strong>&nbsp;</font></font><font size="2"><strong> 
              <select name="CmbSubProducto" style="width:280"  onChange="Proceso('R');" >
                <option value="-1" selected>Seleccionar</option>
                <?php
				//Pregunta si el valor del Combo es 1 osea Productos mineros si es 1 despliega como proveedor
				if ($CmbProductos == '1')
				{
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' and ((mostrar <> 16) or (mostrar <> 17)) "; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
						{
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						}
						else
						{
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}	
					}
				}
				else
				{
					$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."'"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbSubProducto == $Fila["cod_subproducto"])
						{
							echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
						}
						else
						{
							echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
						}	
					}
				}
				?>
              </select>
              </strong></font></font></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="102"><font size="1"><font size="2">Fecha Inicio<font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font></font></font></td>
            <td width="325"><font size="1"><font size="2"><font size="2"> 
              <select name="CmbDias" id="select13" size="1" style="font-face:verdana;font-size:10">
                <?php
			for ($i=1;$i<=31;$i++)
			{
				if ($i==date("j"))
				{
					echo "<option selected value= '".$i."'>".$i."</option>";
				}
				else
				{
				  echo "<option value='".$i."'>".$i."</option>";
				}
			  }
			?>
              </select>
              </font> <font size="2"> 
              <select name="CmbMes" size="1" id="select14" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
		  for($i=1;$i<13;$i++)
		  {
				if ($i==date("n"))
				{
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}
				else
				{
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
			}
		    ?>
              </select>
              </font> <font size="2"> 
              <select name="CmbAno" size="1" id="select15" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
			for ($i=date("Y");$i<=date("Y");$i++)
			{
				if ($i==date("Y"))
					{
						echo "<option selected value ='$i'>$i</option>";
					}
				else	
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
			}
			?>
              </select>
              </font><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
              </font></font></font></td>
            <td width="73"><div align="center"><font size="1"><font size="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <input name="BtnOk" type="submit" id="BtnOk2" value="Ok">
                </font></font></font></div></td>
            <td><div align="center"> </div></td>
          </tr>
          <tr>
            <td><font size="1"><font size="1"><font size="2">Fecha Termino</font></font></font></td>
            <td><font size="1"><font size="1"><font size="2">
              <select name="CmbDiasT" id="select22" size="1" style="font-face:verdana;font-size:10">
                <?php
			for ($i=1;$i<=31;$i++)
			{
				if ($i==date("j"))
				{
					echo "<option selected value= '".$i."'>".$i."</option>";
				}
				else
				{
				  echo "<option value='".$i."'>".$i."</option>";
				}
			}
			?>
              </select>
              </font> <font size="2"> 
              <select name="CmbMesT" size="1" id="select23" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
		  		for($i=1;$i<13;$i++)
		  		{
					if ($i==date("n"))
					{
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					}
					else
					{
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
					}	
		   		}
		   		?>
              </select>
              </font> <font size="2"> 
              <select name="CmbAnoT" size="1" id="select24" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if ($i==date("Y"))
					{
						echo "<option selected value ='$i'>$i</option>";
					}
					else	
					{
						echo "<option value='".$i."'>".$i."</option>";
					}
				}
				?>
              </select>
              </font></font><font size="2"></font></font></td>
            <td><div align="center">
                <input name="Btn Leyes" type="submit" id="Btn Leyes3" value="Leyes">
              </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><font size="1"><font size="1">Tipo Analisis</font></font></td>
            <td><font size="1"><font size="1"><font size="2"> <strong> 
              <select name="CmbPeriodo" style="width:130">
                <option value ='-1' selected>Seleccionar</option>\n";
                
                <?php  
			$Consulta = "select * from sub_clase where cod_clase = 2 order by cod_subclase";
			$Respuesta= mysqli_query($link, $Consulta);
			while ($Fila = mysqli_fetch_array($Respuesta))
				{
					/*if($CmbPeriodo==$Fila["cod_subclase"])
					{
						echo "<option value = '".$Fila["cod_subclase"]."' selected>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";					
					}
					else
					{*/
						echo "<option value = '".$Fila["cod_subclase"]."'>".ucwords(strtolower($Fila["nombre_subclase"]))."</option>\n";
					//}
				}
		?>
              </select>
              </strong></font></font></font></td>
            <td><div align="center"> </div></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="758" border="1" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
          <tr class="ColorTabla01">
            <td width="118">Producto</td>
            <td width="134">Sub-Producto</td>
            <td width="87"><div align="center">Leyes</div></td>
            <td width="106"><div align="center">Impurezas</div></td>
            <td width="109"><div align="center">Tipo Analisis</div></td>
            <td width="94"><div align="center">Fecha I</div></td>
            <td width="64"><div align="center">Fecha-T</div></td>
          </tr>
        </table>
        <br>
        <table width="758" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="303"><div align="center"> </div></td>
            <td width="95"><input name="BtnConsulrat" type="button" id="BtnSalir22" value="Generar" style="width:60" onClick="Proceso('S');"></td>
            <td width="338"><input name="BtnSalir" type="button" id="BtnSalir2" value="Salir" style="width:60" onClick="Proceso('S');"></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
