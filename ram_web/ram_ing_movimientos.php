<?php
$CodigoDeSistema = 7;
$CodigoDePantalla = 4;

$estado_val = 0;
if($Proceso == "M")
{

	$ano = substr($fecha,0,4);
	$mes = substr($fecha,5,2);
	$dia = substr($fecha,8,2);
	
	$hh = substr($fecha,11,2);
	$mm = substr($fecha,14,2);
//	echo "hola ".$fecha;

	$cmbmovimiento = $cmbmovimiento_aux;

	$num_conjunto = $num_conjunto_aux; 
	$cmbtipo = $cmbtipo_aux;
	$nombre_conjunto = $nombre_conjunto_aux;
    $stock = $stock_aux;
	$cod_lugar = $cod_lugar_aux;
	$num_lugar = $num_lugar_aux;
	$lugar_origen = $lugar_origen_aux;

	$num_conjunto_d = $num_conjunto_d_aux;
	$cmbtipo_d = $cmbtipo_d_aux;
	$nombre_conjunto_d = $nombre_conjunto_d_aux;
	$cod_lugar_d = $cod_lugar_d_aux;
	$num_lugar_d = $num_lugar_d_aux;
	$lugar_destino = $lugar_destino_aux;

    $peso_humedo = $peso_humedo_aux;
	$estado_val = $estado_val_aux;
}

if($Proceso == "B")
{
    include("../principal/conectar_ram_web.php");

    if($num_conjunto_aux != '' || $num_conjunto != '')
	{
		$consulta = "SELECT * FROM conjunto_ram WHERE cod_conjunto = $cmbtipo AND num_conjunto = $num_conjunto AND estado !='f'";
		$rs = mysqli_query($link, $consulta);
	   
		if($mostrar == "S")
		{
			$num_conjunto = $num_conjunto_aux;
			$cmbtipo = $cmbtipo_aux;
			$consulta = "SELECT * FROM conjunto_ram WHERE cod_conjunto = $cmbtipo AND num_conjunto = $num_conjunto AND estado !='f'";
			$rs = mysqli_query($link, $consulta);	
		}
		
		if($row = mysqli_fetch_array($rs))
		{	
		   $cmbtipo = $row[cod_conjunto];
		   $num_conjunto = $row[num_conjunto];
		   $nombre_conjunto = $row["descripcion"];
		   $cmbestado = $row[estado];
		   $cod_lugar = $row[cod_lugar];
		   $num_lugar = $row[num_lugar];
		   $stock = $row[peso_conjunto];
		   
		   if($stock == 0 || $stock == '')
		   {
		   		$stock = 0;	
		   		$estado_val = 1;
		   }	
		   $consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = $cod_lugar AND num_lugar = $num_lugar ";
		   $rs2 = mysqli_query($link, $consulta);
		   
		   if($row2 = mysqli_fetch_array($rs2))
		   {
				$lugar_origen = $row2[descripcion_lugar];
		   }
	
		}
	}
	else
	{
		$Proceso = "N";
	}
	

}

if($Proceso2 == "B")
{
    include("../principal/conectar_ram_web.php");
    if($num_conjunto_aux_d != '' || $num_conjunto_d != '')
	{
		$consulta = "SELECT * FROM conjunto_ram WHERE cod_conjunto = $cmbtipo_d AND num_conjunto = $num_conjunto_d AND estado !='f'";
		$rs3 = mysqli_query($link, $consulta);
		if($mostrar2 == "S")
		{
			$num_conjunto_d = $num_conjunto_aux_d;
			$cmbtipo_d = $cmbtipo_aux_d;
			$consulta = "SELECT * FROM conjunto_ram WHERE cod_conjunto = $cmbtipo_d AND num_conjunto = $num_conjunto_d AND estado !='f'";
			$rs3 = mysqli_query($link, $consulta);	
		}
	
		if($row3 = mysqli_fetch_array($rs3))
		{	
		   $cmbtipo_d = $row3[cod_conjunto];
		   $num_conjunto_d = $row3[num_conjunto];
		   $nombre_conjunto_d = $row3["descripcion"];
		   $cmbestado = $row3[estado];
		   $cod_lugar_d = $row3[cod_lugar];
		   $num_lugar_d = $row3[num_lugar];
		   $stock_d = $row3[peso_conjunto];
	
		   $consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = $cod_lugar_d AND num_lugar = $num_lugar_d ";
		   $rs4 = mysqli_query($link, $consulta);
		   
		   if($row4 = mysqli_fetch_array($rs4))
		   {
				$lugar_destino = $row4[descripcion_lugar];
		   }
	
		}
	}
	else
	{
		$Proceso2 = "N";
	}
		

}

?>
<html>
<head>
<title>Ingreso de Movimientos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Buscar_Conjuntos()
{
var f=formulario;

	if(f.cmbmovimiento.value == -1)
	{
		alert("Debe escoger Tipo de Moviminento");
		f.cmbmovimiento.focus()
		return
	}

    f.action ="ram_ing_movimientos.php?Proceso=B&Proceso2=B";
	f.submit();

}

function Buscar_Conjuntos_Destino()
{
var f=formulario;
    f.action ="ram_ing_movimientos.php?Proceso2=B&Proceso=B";
	f.submit();

}

function Ver_Datos()
{
	var f = formulario;	

	if(f.cmbmovimiento.value == -1)
	{
		alert("Debe escoger Tipo de Moviminento");
		f.cmbmovimiento.focus()
		return
	}
	
	valores = "ano=" + f.ano.value + "&mes=" + f.mes.value + "&dia=" + f.dia.value + "&movimiento=" + f.cmbmovimiento.value;
	
    window.open("ram_ing_movimientos02.php?"+valores , "","menubar=no resizable=no Top=50 Left=200 width=770 height=500 scrollbars=no");
}

function Guardar_Datos()
{
var f=formulario;
//var cod_lugar = f.cod_lugar.value;
//var num_lugar = f.num_lugar.value;
//var cod_lugar_d = f.cod_lugar_d.value;
//var num_lugar_d = f.num_lugar_d.value;
//var valores;
	
	if(f.cmbmovimiento.value == -1)
	{
		alert("Debe Escoger Tipo de Movimiento");
		f.cmbmovimiento.focus()
		return
	}			

	if(f.lugar_origen.value == '' || f.nombre_conjunto.value == '' || f.nombre_conjunto_d.value == '' || f.lugar_destino.value == '')
	{
		alert("Datos No Habilitados");
		return
	}

//	valores = "&cod_lugar=" + cod_lugar + "&num_lugar="	+ num_lugar + "&cod_lugar_d=" + cod_lugar_d + "&num_lugar_d="	+ num_lugar_d;	
//	f.action = "ram_ing_movimientos01.php?Proceso=G"+valores;
	f.action = "ram_ing_movimientos01.php?Proceso=G";
	f.submit();
}

function Modificar_Datos()
{
var f=formulario;
//var fecha_aux = f.fecha_aux.value;
var cod_lugar = f.cod_lugar.value;
var num_lugar = f.num_lugar.value;
var cod_lugar_d = f.cod_lugar_d.value;
var num_lugar_d = f.num_lugar_d.value;
var valores;

	valores = "&fecha=" + f.fecha_aux.value + "&cod_lugar=" + cod_lugar + "&num_lugar="	+ num_lugar + "&cod_lugar_d=" + cod_lugar_d + "&num_lugar_d="	+ num_lugar_d;	
	f.action = "ram_ing_movimientos01.php?Proceso=M"+valores;
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
<table width="700" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td width="104">Fecha Movimiento</td>
            <td width="203"><font color="#000000" size="2"> 
              <select name="dia" size="1" style="font-face:verdana;font-size:10">
                <?php
			if($Proceso=='B' || $Proceso == "M")
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
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
		   }			
	?>
              </select>
              </font> <font color="#000000" size="2"> 
              <select name="mes" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B' || $Proceso == "M")
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
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
	    } 	  
  		  
     ?>
              </select>
              <select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
	if($Proceso=='B' || $Proceso == "M")
	{
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
	}
	else
	{
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
    }	
?>
              </select>
              </font></td>
            <td width="133"><input name='Ver_Movimientos' type='button' style="width:110" value='Ver Movimientos' onClick='Ver_Datos();'></td>
            <td width="27"><font color="#000000" size="2">Hora</font></td>
            <td width="200"><select name="hh" id="select5">
                <?php
            if ($Proceso=="B" || $Proceso == "M")
                 {
		echo '<option selected value ="'.$hh.'">'.$hh.'</option>';
                 }
                else
                  {
		 	for($i=0; $i<=23; $i++)
			{
				if (($recargapag == "S") && ($i == $hh))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if ((($i == date("H")) && ($recargapag != "S")))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		 }
		?>
              </select>
              : 
              <select name="mm" id="select6">
                <?php
                if ($Proceso=="B" || $Proceso == "M")
                 {
		echo '<option selected value ="'.$mm.'">'.$mm.'</option>';
                 }
                else
                  {
		 for($i=0; $i<=59; $i++)
			{
				if (($recargapag == "S") && ($i == $mm))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($recargapag != "S" || $Proceso == "M"))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		  }	
		?>
              </select> </td>
          </tr>
        </table>
	  <br>
	  <table width="279" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td width="111"><strong>Tipo Movimiento</strong></td>
            <td width="146" colspan="2"> 
              <?php
			  
			  echo'<select name="cmbmovimiento" style="width:170">';
              echo'<option value = "-1" selected>SELECCIONAR</option>';
 	          
			  $consulta = "SELECT * FROM ram_web.atributo_existencia WHERE cod_existencia IN ('03','05','06','15')";
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row["cod_existencia"] == $cmbmovimiento AND ($Proceso2 == "B" || $Proceso == "B" || $Proceso == "M"))
					echo '<option value="'.$row["cod_existencia"].'" selected>'.$row[nombre_existencia].'</option>';
				else
					echo '<option value="'.$row["cod_existencia"].'">'.$row[nombre_existencia].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
            </td>
          </tr>
      </table>
	  <br>
	  <table width="700" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td colspan="7" class="ColorTabla01">Datos Orig&eacute;n</td>
          </tr>
          <tr> 
            <td>Tipo Conjunto</td>
            <td width="171"> 
              <?php
			  
			  echo'<select name="cmbtipo" style="width:150">';
              echo'<option value = "-1" selected>SELECCIONAR</option>';
 	          
			  include("../principal/conectar_principal.php"); 
			  $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 7001";
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				$valor = $row["cod_subclase"];
				if($valor == 42)				
					$valor = 3;

				if ($valor == $cmbtipo)
					echo '<option value="'.$valor.'" selected>'.$row["nombre_subclase"].'</option>';
				else
					echo '<option value="'.$valor.'">'.$row["nombre_subclase"].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
            </td>
            <td width="95"><font color="#000000" size="2">Conjunto Origen </font></td>
            <td width="64"> 
              <?php
			if($Proceso == "B" || $Proceso == "M")
			{	
				echo'<input name="num_conjunto" type="text" size="10" value="'.$num_conjunto.'">';

			}
			else
				echo'<input name="num_conjunto" type="text" size="10">';
			?>
            </td>
            <td width="65"> <input name="buscar" type="button" value="Ok" onClick="Buscar_Conjuntos();"> 
            </td>
            <td width="34">Stock</td>
            <td width="96"><?php echo'<input name="stock" type="text" size="10" value="'.$stock.'" ReadOnly>'; ?></td>
          </tr>
          <tr> 
            <td width="130">Nombre Conjunto</td>
            <td colspan="6"> 
              <?php
			if($Proceso == "B" || $Proceso == "M")
			{	
				echo'<input name="nombre_conjunto" type="text" size="52" value="'.$nombre_conjunto.'" disabled>';

			}
			else
				echo'<input name="nombre_conjunto" type="text" size="52">';
			?>
            </td>
          </tr>
          <tr> 
            <td>Lugar Origen</td>
            <td colspan="6"> 
              <?php
			if($Proceso == "B" || $Proceso == "M")
			{	
				echo'<input name="cod_lugar" type="hidden" size="30" value="'.$cod_lugar.'">';
				echo'<input name="num_lugar" type="hidden" size="30" value="'.$num_lugar.'">';
				echo'<input name="lugar_origen" type="text" size="40" value="'.$lugar_origen.'" disabled>';

			}
			else
				echo'<input name="lugar_origen" type="text" size="40">';
			?>
            </td>
          </tr>
        </table>
	  <br>
	  <table width="700" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td colspan="7" class="ColorTabla01">Datos Destino </td>
          </tr>
          <tr> 
            <td width="131">Tipo Conjunto</td>
            <td width="164"> 
              <?php
			  
			  echo'<select name="cmbtipo_d" style="width:150">';
              echo'<option value = "-1" selected>SELECCIONAR</option>';
 	          
			  include("../principal/conectar_principal.php"); 
		
			  if($cmbtipo == '1')
			  {
				  $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 7001 AND cod_subclase = 2";
				  $rs = mysqli_query($link, $consulta);
			  }		  
			  elseif($cmbtipo == '3' && $cmbmovimiento == '06')
			  {
				  $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 7001 AND cod_subclase = 2";
				  $rs = mysqli_query($link, $consulta);
			  }		  
			  elseif($cmbtipo == '3' && $cmbmovimiento == '15')
			  {
				  $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 7001 AND cod_subclase = 42";
				  $rs = mysqli_query($link, $consulta);
			  }
			  else		  
			  {
			      $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 7001";
				  $rs = mysqli_query($link, $consulta);
			  }
			  
			  while($row = mysqli_fetch_array($rs))
			  {				

				$valor_d = $row["cod_subclase"];
				if($valor_d == 42)				
					$valor_d = 3;

				if ($valor_d == $cmbtipo_d)
					echo '<option value="'.$valor_d.'" selected>'.$row["nombre_subclase"].'</option>';
				else
					echo '<option value="'.$valor_d.'">'.$row["nombre_subclase"].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
            </td>
            <td width="99"><font color="#000000" size="2">Conjunto Destino</font></td>
            <td width="62"> 
              <?php
			if($Proceso2 == "B" || $Proceso == "M")
			{	
				echo'<input name="num_conjunto_d" type="text" size="10" value="'.$num_conjunto_d.'">';

			}
			else
				echo'<input name="num_conjunto_d" type="text" size="10">';
			?>
            </td>
            <td width="68"><input name="buscar2" type="button" value="Ok" onClick="Buscar_Conjuntos_Destino();"> 
            </td>
            <td width="34">&nbsp;</td>
            <td width="97"><?php //echo'<input name="stock_d" type="text" size="10" value="'.$stock_d.'" disabled>'; ?></td>
          </tr>
          <tr> 
            <td>Nombre Conjunto</td>
            <td colspan="6"> 
              <?php
			if($Proceso2 == "B" || $Proceso == "M")
			{	
				echo'<input name="nombre_conjunto_d" type="text" size="52" value="'.$nombre_conjunto_d.'" disabled>';

			}
			else
				echo'<input name="nombre_conjunto_d" type="text" size="52">';
			?>
            </td>
          </tr>
          <tr> 
            <td>Lugar Destino</td>
            <td colspan="6"> 
              <?php
			if($Proceso2 == "B" || $Proceso == "M")
			{	
				echo'<input name="cod_lugar_d" type="hidden" size="30" value="'.$cod_lugar_d.'">';
				echo'<input name="num_lugar_d" type="hidden" size="30" value="'.$num_lugar_d.'">';
				echo'<input name="lugar_destino" type="text" size="40" value="'.$lugar_destino.'" disabled>';

			}
			else
				echo'<input name="lugar_destino" type="text" size="40">';
			?>
            </td>
          </tr>
        </table>
      <br>
	  <table width="406" height="28" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
          <tr> 
            <td width="56" height="25">Validaci&oacute;n</td>
            <td width="20">
			<?php			
			  if($estado_val == 1)
			  	echo '<input type="checkbox" name="checkbox" checked>';
			  if($estado_val == 0)
			  	echo '<input type="checkbox" name="checkbox">';
             ?>
			</td>
			<td width="38">&nbsp;</td>
            <td width="145">Peso Humedo a Mover</td>
            <td width="62"> 
              <?php 
			  if($Proceso == "M")	
				  echo'<input name="peso_humedo" type="text" size="10" value="'.number_format($peso_humedo/1000,3,",","").'">';
			  else 	 
				  echo'<input name="peso_humedo" type="text" size="10">';
              ?>
            </td>
            <td width="46">Tons </td>
          </tr>
        </table>
	  <br>
	  <table width="700" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">	  	  
          <tr> 
            <td colspan="3"><div align="center"> 
			<?php
				 if($fecha != '')
				 {				
					 echo'<input name="modificar" type="button" style="width:70" value="Modificar" onClick="Modificar_Datos();">';
				     echo'<input name="fecha_aux" type="hidden" size="30" value="'.$fecha.'">';
                 }
				 else
				 {
					 echo'<input name="guardar" type="button" style="width:70" value="Guardar" onClick="Guardar_Datos();">';
            	 }
			 ?>   <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div></td>
          </tr>
        </table>     </td>
  </tr>
</table>
<?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
