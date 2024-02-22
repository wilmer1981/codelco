<?php include("../principal/conectar_sea_web.php") ?> 
<?php 
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 1;
	
	
	if ($recargapag == "S") 
	{	
		//Consulta el ciclo mayor.
		$consulta = "SELECT IFNULL(MAX(ciclo),0) AS ciclo FROM sea_web.relaciones WHERE cod_origen = ".$cmbanodos;
		 echo $consulta."<br>";
		
		$rs3 = mysqli_query($link, $consulta);
		$row3 = mysqli_fetch_array($rs3);
	
		//Consulta Hornada en la tabla Relaciones
		$consulta = "SELECT MAX(hornada_ventana) AS hornada_max FROM sea_web.relaciones";
		$consulta = $consulta." WHERE cod_origen = ".$cmbanodos." AND ciclo = ".$row3[ciclo];
		//echo $consulta."<br>";
		
		$rs2 = mysqli_query($link, $consulta);
		$row2 = mysqli_fetch_array($rs2);

		if ((is_null($row2[hornada_max])) or (substr($row2[hornada_max],7,3) == '999'))
		{
			//Hornada de Incio
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2005 AND cod_subclase = ".$cmbanodos;
			$rs1 = mysqli_query($link, $consulta);
			$row1 = mysqli_fetch_array($rs1);
			$txthornada = $row1["valor_subclase1"];								
		}
		else
		{
			$txthornada = substr(($row2[hornada_max] + 1),6,6);
		}
	}
?>

<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript"> 
function ValidaCampos(f)
{
	if (f.cmbanodos.value == -1)
	{
		alert("Debe Seleccionar El Origen de los Anodos");
		return false;
	}
		
	if (f.txtlote.value == "")
	{	
		alert("Debe Ingresar N° de Lote");
		return false;
	}

	if (isNaN(parseInt(f.txtlote.value)))			
	{
		alert("El N° Lote no es Válido");
		return false;
	}	
	
	if (f.txthornada.value == "")
	{
		alert("Debe Ingresar N° de Hornada Ventana");
		return false;		
	}
	
	if (isNaN(parseInt(f.txthornada.value)))			
	{
		alert("El N° Hornada Ventana no es Válida");
		return false;
	}	
	
	if (f.txtorigen.value == "")		
	{
		alert("Debe Ingresar Lote Origen");
		return false;
	}
	
	if (f.txtmarca.value == "")
	{
		alert("Debe Ingresae Marca");
		return false;
	}
	
	return true;	
}
function Buscar(f)
{
	if (f.txtlote.value == "")
		alert("Debe Ingresar el N° de Lote");		
	else if (isNaN(parseInt(f.txtlote.value)))			
		{
			alert("El N° Lote no es Válido");
			return false;
		}	
		else
		{		
			f.action = "sea_ing_lotes01.php?proceso=B&txtlote=" + f.txtlote.value;
			f.submit()
		}
}
/*********************/
function BuscarLoteSipa(f)
{
	if (f.txtlote.value == "")
	{	
		alert("Debe Ingresar el Lote Ventanas");
		return;
	}
	
	window.open("sea_con_lotes_sipa.php?cmbanodos=" + f.cmbanodos.value, "","menubar=no resizable=no width=570 height=400");
	
}
//*******************/
function Grabar(f)
{
	if (ValidaCampos(f))
	{
		if (f.opc.value == "")
			linea = "opcion=N";
		else 
			linea = "opcion=" + f.opc.value;
			
		linea = linea + "&proceso=G&txtmarca=" + f.txtmarca.value + "&txtlote=" + f.txtlote.value;
		f.action = "sea_ing_lotes01.php?" + linea;
		f.submit();
	}
}
//******************//
function Eliminar(f)
{
	if (f.txtlote.value == "")
	{
		alert("Debe Ingresar N° Lote");
		return false;
	}
	else if (isNaN(parseInt(f.txtlote.value)))			
		{
			alert("El N° Lote no es Válido");
			return false;
		}
			
	if (confirm("Esta Seguro que Quiere Eliminar el Lote"))
	{
		f.action = "sea_ing_lotes01.php?proceso=E" + "&txtlote=" + f.txtlote.value;;
		f.submit();
	}
}
//*******************//
function Limpiar(f)
{
	document.location = "sea_ing_lotes.php";
}
//******************//
function Consultar(f)
{
	
	if (f.cmbanodos.value == -1)
	{
		alert("Debe Seleccionar el Origen del Anodo");
		return;
	}
	else 
		
		
		window.open("sea_con_lotes.php?mesl=" + f.mes.value + "&anol=" + f.ano.value +"&cmbanodos=" + f.cmbanodos.value, "","menubar=no resizable=no width=600 height=320");
} 
//******************//
function Recargar(f)
{
/*	if (f.cmbanodos.value == -1)
	{
		document.location = "sea_ing_lotes.php";
		alert(f.cmbanodos.value);
	}
		
*/
	
	linea = "cmbanodos=" + f.cmbanodos.value + "&recargapag=S";
	f.action = "sea_ing_lotes.php?" + linea;
	f.submit();	
}
/******************/
function Agregar(f)
{
	arreglo = f.cmbcolor.value.split('/'); //0: cod_color, 1: abreviacion.
	
	if (arreglo[0] == -1)
	{
		alert("Debe Seleccionar un Color");
		return;
	}
	
	if (arreglo[1] == 0)
		document.frmPrincipal.txtmarca.value = "";
	else 
		document.frmPrincipal.txtmarca.value = f.txtmarca.value + arreglo[1];				 
}
/******************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2"
}
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
<?php
	if (isset($mensaje))
		echo '<script language=JavaScript> alert("'.$mensaje.'") </script>';
?>

<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>

  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="776" align="center" valign="middle">

<table width="558" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="137">Origen Anodos</td>
            <td width="135"> <SELECT name="cmbanodos" id="SELECT4" onChange="JavaScript:Recargar(this.form)">
                <?php
          	echo '<option value="-1">SELECCIONAR</option>';
			$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE ((cod_producto = 17 AND cod_subproducto not in (4,8,11)) or (cod_producto='16' and cod_subproducto='4')) AND mostrar_sea = 'S' ORDER BY cod_producto,descripcion";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{				
	          	if ($row["cod_subproducto"] == $cmbanodos)	
					echo '<option value="'.$row["cod_subproducto"].'" SELECTed>'.$row["descripcion"].'</option>';
				else 
					echo '<option value="'.$row["cod_subproducto"].'">'.$row["descripcion"].'</option>';
			}			
		?>
              </SELECT> </td>
			  <td>
			
              </font> <font color="#000000" size="2"> 
              <SELECT name="mes" size="1" id="SELECT7" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	 	  
  		  
     ?>
              </SELECT> 

			  </td>
			  <td>   
			   <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php

	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    			
?>
              </SELECT>
             
			  </td>
          </tr>
          <tr> 
            <td>N&deg; Lote Ventana</td>
            <td> 
              <?php
		if (($bloquear == "S") and ($mostrar == "S"))
			echo '<input name="txtlote" type="text" size="10" value="'.$txtlote.'" readonly>';		
		else 
			echo '<input name="txtlote" type="text" size="10">';
	?>
            </td>
          </tr>
          <tr> 
            <td>N&deg; Hornada Ventana</td>
            <td><input name="txthornada" type="text" size="10" value="<?php echo $txthornada ?>"></td>
          </tr>
          <tr> 
            <td>Lote Origen</td>
            <td> 
              <?php
		if ($mostrar == "S")	
			echo '<input name="txtorigen" type="text" size="10" value="'.$txtorigen.'"></td>';
		else 
			echo '<input name="txtorigen" type="text" size="10" id="txtorigen"></td>';
	?>
            </td>
          </tr>
          <tr> 
            <td>Marca</td>
            <td> 
              <?php
		if ($mostrar == "S")
			echo '<input name="txtmarca" type="text" size="10" value="'.$txtmarca.'" readonly>';
		else 
			echo '<input name="txtmarca" type="text" size="10" disabled>';
	?>
              <SELECT name="cmbcolor" id="SELECT5">
                <option value="-1">SELECCIONAR</option>
                <?php
		  	echo '<option value="/">NINGUNO</option>';
			
		  	$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2011 ORDER BY nombre_subclase";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
	         	echo '<option value="'.$row["cod_subclase"].'/'.$row["valor_subclase1"].'">'.$row["nombre_subclase"].'</option>';
			}
		  ?>
              </SELECT> <input name="btnok" type="button" value="Ok" onClick="JavaScript:Agregar(this.form)"> 
            </td>
          </tr>
        </table>
  <br>
  <table width="501" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td width="492" align="center"><input name="btngrabar" type="button" value="Grabar" style="width:70" onClick="JavaScript:Grabar(this.form)">
        <input name="btneliminar" type="button" value="Eliminar" style="width:70" onClick="JavaScript:Eliminar(this.form)">
        <input name="btnconsultar" type="button" value="Consultar" style="width:70" onClick="JavaScript:Consultar(this.form)">
        <input name="btnlimpiar" type="button" value="Limpiar" style="width:70" onClick="JavaScript:Limpiar(this.form)">
        <input name="btnsalir" type="button" value="Salir" style="width:70" onClick="JavaScript:Salir()"></td>
    </tr>
  </table>
  
  	<?php
  		//Campos Ocultos.
		echo '<input name="ocultar" type="hidden" value="'.$ocultar.'">';
		echo '<input name="bloquear" type="hidden" value="'.$bloquear.'">';
		echo '<input name="opc" type="hidden" value="'.$opc.'">';
 	?>
  
</td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>