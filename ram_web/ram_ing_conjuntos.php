<?php
$CodigoDeSistema = 7;
$CodigoDePantalla = 3;

 if($buscar == "S")
 {	
	$consulta = "SELECT * FROM conjunto_ram WHERE num_conjunto = '$n_conjunto' AND fecha_creacion = '$fecha_c'";
    include("../principal/conectar_ram_web.php");
	$rs = mysqli_query($link, $consulta);
	
	if($row = mysqli_fetch_array($rs))
	{	
       $fecha = $row[fecha_creacion];
	   $cmbconjunto = $row["cod_producto"];
	   $cmbproducto = $row[cod_subproducto];
	   $num_conjunto = $row[num_conjunto];
	   $nombre_conjunto = $row["descripcion"];
	   $cmbestado = $row[estado];
	   $cmbtipo = $row[cod_lugar];
	   $cmblugar = $row[num_lugar];
	}	
 }

?>

<html>
<head>
<title>Creaci�n de Conjuntos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function TeclaPulsada() 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	var CantComas =0;

	//alert(teclaCodigo);	
	if (teclaCodigo == 13)
	{
		//Frm.CmbHoraInicio.focus();
	}
	else
	{
		if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo !=9))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		else
		{
			/*CantComas=Frm.TxtStockInicial[1].value.search(',');
			if (CantComas!=-1)
			{
				event.keyCode=46;
				return;
			}
			if ((Frm.TxtStockInicial[1].value.substr(Frm.TxtStockInicial[1].value.length-1,1)==",")||(Frm.TxtStockInicial[1].value.substr(Frm.TxtStockInicial[1].value.length-1,1)==""))
			{
				if ((teclaCodigo != 37)&&(teclaCodigo != 39))
				{
					event.keyCode=46;
				}	
			}*/
		}
	}	
} 

function TeclaPulsada1 () 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	var CantComas =0;
	
	//alert(teclaCodigo);
	
	if (teclaCodigo == 186 || teclaCodigo == 222 || teclaCodigo == 192)
	{
			   		event.keyCode=46;
	}

} 


function valida_campos()
{
var f=formulario;

    if(f.cmbconjunto.value == -1)
	{
		alert("Debe Ingresar Tipo de Conjunto");
		f.cmbconjunto.focus();
		return 1
	} 

    if(f.cmbproducto.value == -1)
	{
		alert("Debe Ingresar Producto");
		f.cmbproducto.focus();
		return 1
	} 

    if(f.num_conjunto.value == '')
	{
		alert("Debe Ingresar N�mero de Conjunto");
		f.num_conjunto.focus();
		return 1
	} 

    if(f.nombre_conjunto.value == '')
	{
		alert("Debe Ingresar Nombre del Conjunto");
		f.nombre_conjunto.focus();
		return 1
	} 

    if(f.cmbtipo.value == -1)
	{
		alert("Debe Ingresar Tipo Lugar");
		f.cmbtipo.focus();
		return 1
	} 

    if(f.cmblugar.value == -1)
	{
		alert("Debe Ingresar Lugar");
		f.cmblugar.focus();
		return 1
	} 

}

function Nuevo_Dato()
{
var f=formulario;
//    f.action ="ram_ing_conjuntos.php";
// 	f.submit();	
	window.location = "ram_ing_conjuntos.php";
}

function Guardar_Datos()
{
var f=formulario;
var fecha;
	
	fecha = f.fecha.value;
	
	if (valida_campos() != 1)
	{
		f.action = "ram_ing_conjuntos01.php?Proceso=G&fecha="+fecha;
		f.submit();
	}
}

function Eliminar_Datos()
{
var f=formulario;

	if (valida_campos() != 1)
	{
		f.action = "ram_ing_conjuntos01.php?Proceso=E";
		f.submit();
	}
}

function Modificar_Datos()
{
var f=formulario;
     
	if (valida_campos() != 1)
	{
		f.action = "ram_ing_conjuntos01.php?Proceso=M";
		f.submit();
	}
}


function Buscar_Datos()
{
var f=formulario;
 
	f.action = "ram_ing_conjuntos.php?Proceso=B";
	f.submit();
}

function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			Valores =  "&n_conjunto=" + f.elements[i+1].value + "&fecha_c=" + f.elements[i+2].value;
		}
	}
	return Valores;
}

function Buscar()
{
var f=formulario;
var valores = ValidaSeleccion(f,'radio');
  
	f.action = "ram_ing_conjuntos.php?Proceso=V&buscar=S"+valores;
	f.submit();
}

function Recarga_Estado()
{
var f=formulario;
 
	f.action = "ram_ing_conjuntos.php?Proceso=E";
	f.submit();
}

function mostrar_lugar()
{
var f=formulario;
    f.action ="ram_ing_conjuntos.php?Proceso=L";
	f.submit();
}

function mostrar_lugar2()
{
var f=formulario;
    f.action ="ram_ing_conjuntos.php?Proceso=L&buscar=S";
	f.submit();
}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=7";
	f.submit();
}
</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<style type="text/css">
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
<form name="formulario" method="post">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td align="center" valign="top" >
<table width="735" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Fecha Creaci&oacute;n</td>
            <td colspan="2">
			<strong>
			<?php  
				if($buscar != "S")
				{
					$dia = date("j");
					$mes = date("n");
					$ano = date("Y");
					
					if(strlen($dia) == 1)
						$dia = '0'.$dia;
					if(strlen($mes) == 1)
						$mes = '0'.$mes;
						
					$fecha_m = $dia.'-'.$mes.'-'.$ano;
					$fecha = $ano.'-'.$mes.'-'.$dia;
					echo $fecha_m;
					echo'<input name="fecha" type="hidden" value="'.$fecha.'" size="10"> ';
				}
				else
				{
					echo'<input name="fecha" type="hidden" value="'.$fecha.'" size="10"> ';
					$fecha = str_replace('.','-',$fecha);
					echo $fecha;
				}
            ?>
            </strong>
			</td>
          </tr>
          <tr> 
            <td width="130"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo de Conjunto</td>
            <td colspan="2"> 
              <?php
			  $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 7001";
			  include("../principal/conectar_principal.php"); 
				
			  echo'<select name="cmbconjunto" style="width:150" onChange="Recarga_Estado();">';

			  echo'<option value = "-1" selected>SELECCIONAR</option>'; 	          
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row["cod_subclase"] == $cmbconjunto)
					echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
				else
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
            </td>
          </tr>
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Producto</td>
            <td width="213"> 
              <?php
			  echo'<select name="cmbproducto" style="width:230">';              

			  echo'<option value = "-1" selected>SELECCIONAR</option>';
			  $consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE prod_ram = $cmbconjunto ORDER BY tipo_mov,descripcion";
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row[cod_subproducto] == $cmbproducto)
					echo '<option value="'.$row[cod_subproducto].'" selected>'.$row[tipo_mov].'-'.$row["descripcion"].'</option>';
				else
					echo '<option value="'.$row[cod_subproducto].'">'.$row[tipo_mov].'-'.$row["descripcion"].'</option>';
			  
			  }
			  if($cmbconjunto == "2")
			  {
					if ($cmbproducto == "10")
  			  			echo'<option value = "10" selected>Mezcla</option>';
					else	
  			  			echo'<option value = "10">Mezcla</option>';
		  	  } 	
			  echo'</select>';
			 ?>
            </td>
            <td width="371">&nbsp;</td>
          </tr>
        </table>
		  <br>
		  <table width="735" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td width="130"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;N&uacute;mero 
              Conjunto</td>
            <td width="54"> 
              <?php
			if($buscar == "S" || $Proceso == "L")
			{	
				echo'<input name="num_conjunto" type="text" size="5" value="'.$num_conjunto.'" onKeyDown="TeclaPulsada()">';

			}
			else
				echo'<input name="num_conjunto" type="text" size="5" onKeyDown="TeclaPulsada()">';
			?>
            </td>
            <td width="530"><input name="buscar" type="button" style="width:170" value="Ver Conjunto Ingresado" onClick="Buscar_Datos();"></td>
          </tr>
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Nombre 
              Conjunto</td>
            <td colspan="2"> 
              <?php
			if($buscar == "S" || $Proceso == "L")
			{
				echo'<input name="nombre_conjunto" type="text" size="60" value="'.$nombre_conjunto.'" onKeyDown="TeclaPulsada1()">';
			}
			else
				echo'<input name="nombre_conjunto" type="text" size="60" onKeyDown="TeclaPulsada1()">';
			?>
            </td>
          </tr>
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Estado 
              Conjunto</td>
            <td colspan="2"> 
              <?php
			  
			  echo'<select name="cmbestado" style="width:110">';
              echo'<option value = "-1" selected>SELECCIONAR</option>';
 	          
			  include("../principal/conectar_ram_web.php"); 
			  $consulta = "SELECT * FROM estado_conjunto ORDER BY cod_estado";
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row["cod_estado"] == 'p' && $cmbconjunto == '2' && $Proceso == 'E')
					echo '<option value="'.$row["cod_estado"].'" selected>'.$row[descripcion_estado].'</option>';
				elseif ($row["cod_estado"] == 'a' && $cmbconjunto == '1' && $Proceso == 'E')
					echo '<option value="'.$row["cod_estado"].'" selected>'.$row[descripcion_estado].'</option>';
                elseif ($row["cod_estado"] == $cmbestado && $buscar =="S") 
					echo '<option value="'.$row["cod_estado"].'" selected>'.$row[descripcion_estado].'</option>';
                elseif ($row["cod_estado"] == $cmbestado) 
					echo '<option value="'.$row["cod_estado"].'" selected>'.$row[descripcion_estado].'</option>';
				else
					echo '<option value="'.$row["cod_estado"].'">'.$row[descripcion_estado].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
            </td>
          </tr>
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo 
              Lugar </td>
            <td colspan="2"> 
              <?php
			  if($buscar == 'S')
			  	echo'<select name="cmbtipo" style="width:230" onChange="mostrar_lugar2();">';
              else
			  	echo'<select name="cmbtipo" style="width:230" onChange="mostrar_lugar();">';
			  echo'<option value = "-1" selected>SELECCIONAR</option>';
			  include("../principal/conectar_ram_web.php"); 
			  switch ($cmbconjunto)
			  {
			  	case 2:
					$consulta = "SELECT * FROM tipo_lugar WHERE cod_tipo_lugar > '13' ORDER BY cod_tipo_lugar";
					break;
			  	case 42:
					$consulta = "SELECT * FROM tipo_lugar WHERE cod_tipo_lugar < '14' ORDER BY cod_tipo_lugar";	
					break;
				default:
					$consulta = "SELECT * FROM tipo_lugar ORDER BY cod_tipo_lugar";
					break;	
			  }
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row[cod_tipo_lugar] == $cmbtipo)
					echo '<option value="'.$row[cod_tipo_lugar].'" selected>'.$row[descripcion_lugar].'</option>';
				else
					echo '<option value="'.$row[cod_tipo_lugar].'">'.$row[descripcion_lugar].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
            </td>
          </tr>
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Lugar</td>
            <td colspan="2"> 
              <?php			  
			  echo'<select name="cmblugar" style="width:150">';
              echo'<option value = "-1" selected>SELECCIONAR</option>';
 	          
			  include("../principal/conectar_ram_web.php"); 
			  $consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = $cmbtipo AND cod_estado != 'f'";
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row[num_lugar] == $cmblugar && $Proceso != "L")
					echo '<option value="'.$row[num_lugar].'" selected>'.$row[descripcion_lugar].'</option>';
				else
					echo '<option value="'.$row[num_lugar].'">'.$row[descripcion_lugar].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
            </td>
          </tr>
          <tr> 
            <td colspan="3"><div align="center"> 
                <?php
				 if($buscar != "S")
				 	echo'<input name="guardar" type="button" style="width:70" value="Guardar" onClick="Guardar_Datos();">';
                 else
				 {
					echo'<input name="nuevo" type="button"  value="Nuevo" onClick="Nuevo_Dato();" style="width:70px">&nbsp;';
				 	echo'<input name="guardar" type="button" style="width:70" value="Guardar" disabled>';
				 }
				?>
                <?php
				 if($buscar == "S")
				 {
					echo'<input name="modificar" type="button"  value="Modificar" onClick="Modificar_Datos();" style="width:70px">&nbsp;';				
					echo'<input name="Eliminar" type="button"  value="Eliminar" onClick="Eliminar_Datos();" style="width:70px">';
				 }
				 else
				 {
					echo'<input name="modificar" type="button"  value="Modificar" disabled>&nbsp;';
				    echo'<input name="Eliminar" type="button"  value="Eliminar" disabled>';
				 }
				?>
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div></td>
          </tr>
        </table>
		<br>
	    <table width="97%" border="1" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="4%">&nbsp;</td>
            <td width="11%"><div align="center">Nro Conjunto</div></td>
            <td width="29%"><div align="center">Descripci&oacute;n Conjunto</div>
              <div align="center"></div></td>
            <td width="6%"><div align="center">Estado</div></td>
            <td width="14%"><div align="center">Fecha Creaci&oacute;n</div></td>
            <td width="36%"><div align="center">Lugar</div></td>
          </tr>
          <?php
		if($Proceso == "V")
		{   
			$consulta = "SELECT * FROM conjunto_ram WHERE cod_conjunto = $cmbconjunto AND cod_producto = $cmbproducto AND fecha_creacion = '$fecha'";
			include("../principal/conectar_ram_web.php");
			$rs = mysqli_query($link, $consulta);
		
			while($row = mysqli_fetch_array($rs))
			{
			  $valor = $row[num_conjunto].$row[fecha_creacion];	
			  echo'<tr><td><center>';
			  if($valor == $radio)
			  echo '<input type="radio" name="radio" value="'.$valor.'" onClick="Buscar();" checked>';
			  else
			  echo'<input type="radio" name="radio" value="'.$valor.'" onClick="Buscar();">';
			  echo'</center></td>';
			 
			  echo'<input type="hidden" name="conjunto" value="'.$row[num_conjunto].'">';
			  echo'<input type="hidden" name="fecha_creacion" value="'.$row[fecha_creacion].'">';	
	
			  echo'<td><center>'.$row[num_conjunto].'</center></td>';
			  echo'<td><center>'.$row["descripcion"].'</center></td>';
			  echo'<td><center>'.$row[estado].'</center></td>';
			  echo'<td><center>'.$row[fecha_creacion].'</center></td>';
			  
			  $consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = $row[cod_lugar] AND num_lugar = $row[num_lugar]";
			  $rs2 = mysqli_query($link, $consulta);
			  if($row2 = mysqli_fetch_array($rs2))
			  {
			     echo'<td><center>'.$row2[descripcion_lugar].'</center></td></tr>';
			  } 
			}
		}

?>
<?php
		if($Proceso == "B")
		{   
			$consulta = "SELECT * FROM conjunto_ram WHERE num_conjunto = $num_conjunto";
			include("../principal/conectar_ram_web.php");
			$rs = mysqli_query($link, $consulta);

			 if($num_conjunto != '')
			 {		
				while($row = mysqli_fetch_array($rs))
				{
				  $valor = $row[num_conjunto].$row[fecha_creacion];	
				  echo'<tr><td><center>';
				  if($valor == $radio)
				  echo '<input type="radio" name="radio" value="'.$valor.'" onClick="Buscar();" checked>';
				  else
				  echo'<input type="radio" name="radio" value="'.$valor.'" onClick="Buscar();">';
				  echo'</center></td>';
				 
				  echo'<input type="hidden" name="conjunto" value="'.$row[num_conjunto].'">';
				  echo'<input type="hidden" name="fecha_creacion" value="'.$row[fecha_creacion].'">';	
							
				  echo'<td><center>'.$row[cod_conjunto].' - '.$row[num_conjunto].'</center></td>';
				  echo'<td><center>'.$row["descripcion"].'</center></td>';
				  echo'<td><center>'.$row[estado].'</center></td>';
				  echo'<td><center>'.$row[fecha_creacion].'</center></td>';
				  
				  $consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = $row[cod_lugar] AND num_lugar = $row[num_lugar]";
				  $rs2 = mysqli_query($link, $consulta);
				  if($row2 = mysqli_fetch_array($rs2))
				  {
					 echo'<td><center>'.$row2[descripcion_lugar].'</center></td></tr>';
				  } 
			   }
			}
		}

		?>
        </table>     </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
