<?php 
$CodigoDeSistema = 2;
$CodigoDePantalla = 31;
?>
<html>
<head>
<title>Stock Anodos en piso de Raf</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function guardar_datos()
{
var f = formulario;   

f.action="sea_stock_piso_raf01.php?Proceso=G";
f.submit();
  		
}

/**********/
function modificar_datos()
{
var f = formulario;   

f.action="sea_stock_piso_raf01.php?Proceso=M";
f.submit();
  		
}


/**********/
function buscar_hornada()
{
var f = formulario;   

f.action="sea_stock_piso_raf.php?Proceso=B";
f.submit();
  		
}

/***********/
function recarga_hornada()
{
var f = formulario;   
var LargoForm = f.elements.length;
var hornada;


	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "radiohornada") && (f.elements[i].checked == true))
		{
			hornada = f.elements[i].value;             			
		}
	}


    
	f.action="sea_stock_piso_raf.php?Proceso=R&hornada="+hornada;
    f.submit();
  		
}

function calcula()
{
var f=formulario;

//Math.round((f.elements[i+5].value * f.elements[i].value)*1000)/1000;

 f.peso.value = Math.round((f.unidades.value * f.peso_promedio.value)*1)/1;

}

/***********/
function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}



</script>

<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body>
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="middle" >
    <table width="95%" class="TablaDetalle" cellpadding="3" cellspacing="0">
     <tr> 
	  <td width="152">Mes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font color="#000000" size="2"> 
        <SELECT name="mes" size="1" id="SELECT" style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B' || $Proceso =='R')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
        </SELECT>
        </font></td>
      <td width="122"><font color="#000000">A&ntilde;o</font><font color="#000000"> 
        <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
          <?php
	if($Proceso=='B' || $Proceso =='R')
	{
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
	}
	else
	{
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
    }	
?>
        </SELECT>
        </font><font color="#000000" size="2">&nbsp; </font></td>
      <td width="89"><font color="#000000"> 
        <input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_hornada();">
        </font></td>
      <td width="330">&nbsp;</td>
    </tr>
    </table>	
    <br>
    <table width="95%" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td width="22%">Hornada</td>
            <td width="18%"><SELECT name="cmbhornada" onChange="buscar_unidades();">
                <?php

            include("../principal/conectar_sea_web.php");
          	echo '<option value="-1">Hornada</option>';

            if($Proceso == 'R')
			{  

			$fecha_ini = $ano.'-'.$mes.'-01';
			$fecha_ter = $ano.'-'.$mes.'-31';
			
			$consulta = "SELECT * FROM movimientos WHERE tipo_movimiento = 4 AND hornada= $hornada and fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND unidades !=0";
			$rs = mysqli_query($link, $consulta);
             
				if ($row = mysqli_fetch_array($rs))				
				{
				    $peso = $row["peso"];
				    $unidades = $row["unidades"];
					if ($row[hornada] == $hornada)	
						echo '<option value="'.$row[hornada].'" SELECTed>'.$row[hornada].' </option>';
							else 
								echo '<option value="'.$row[hornada].'">'.$row[hornada].'</option>';
				}		  	
		  
		  	}	
    		?>
              </SELECT></td>
            <td width="19%">&nbsp;</td>
          </tr>
          <tr> 
            <td>Unidades</td>
            <td>
            <?php	
			if ($Proceso == 'R')
			{	
			//	echo '<input name="unidades" type="text" value="'.$unidades.'" size="10" onBlur="calcula()";>';				
            echo '<input name="unidades" type="text"  size="10" onBlur="calcula()";>';
			}
			else
            echo '<input name="unidades" type="text"  size="10">';
			?>
			</td>
            <td>Peso</td>
            <td width="41%">
              <?php	
			if ($Proceso == 'R')
			{	
			    $peso_promedio = $peso / $unidades;
				//echo '<input name="peso" type="text" value="'.$peso.'" size="10">';				
                echo '<input name="peso" type="text"  size="10">';
		        echo '<input type="hidden" name="peso_promedio" value="'.$peso_promedio.'" size="10">'; 

			}
			else
            echo '<input name="peso" type="text"  size="10">';
			?>
            </td>
          </tr>
          <tr> 
            <td colspan="4"><div align="center"> 
			<?php
			if ($Proceso!='R')
                echo '<input name="guardar" type="button" style="width:70" value="Guardar" onClick="guardar_datos();">';
            			
			if ($Proceso=='R')
			{	
                echo '<input name="modificar" type="button" style="width:70" value="Modificar" onClick="modificar_datos();">';
            } 
			?>
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div></td>
          </tr>
        </table>
	<br>
	<?php
	if($Proceso == 'B' || $Proceso == 'R' || $Proceso == 'R2')
	{	
		if($Proceso == 'B' || $Proceso == 'R')
			$fecha_ini = $ano.'-'.$mes.'-01';
			$fecha_ter = $ano.'-'.$mes.'-31';
	  
		echo '<table width="95%" class="TablaDetalle"  border="1" cellpadding="3" cellspacing="0">
		 <tr class="ColorTabla01"> 
				<td width="32%"><div align="center">N&deg; HORNADA</div></td>
				<td width="35%"><div align="center">UNIDADES</div></td>
				<td width="33%"><div align="center">PESO</div></td>
			  </tr>';

			$consulta3 = "SELECT * FROM movimientos WHERE tipo_movimiento = 4 AND cod_producto = 17 AND fecha_movimiento BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND unidades != 0";

		    include("../principal/conectar_sea_web.php");
			$rs3 = mysqli_query($link, $consulta3);
			while($fila = mysqli_fetch_array($rs3))
			{
				if($Proceso == 'R' and $radiohornada == $fila[hornada])
				echo '<tr><td><input type="radio" name="radiohornada" value="'.$fila[hornada].'" onClick="recarga_hornada();" checked>&nbsp'.$fila[hornada].'</td>';
				else
				echo '<tr><td><input type="radio" name="radiohornada" value="'.$fila[hornada].'" onClick="recarga_hornada();">&nbsp'.$fila[hornada].'</td>';

				echo '<td><center>'.$fila["unidades"].'</center></td>';
				echo '<td><center>'.number_format($fila["peso"],0,"","").'</center></td></tr>';
			}
        echo '</table>';
    }
	?>	
       </td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>  
  
</form>
</body>
</html>
