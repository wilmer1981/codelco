<?php 
$CodigoDeSistema = 2;
$CodigoDePantalla = 12;
?>
<html>
<head>
<title>�nodos Rechazados A RAF</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<script language="JavaScript">

/************************/
function valida_valores()
{
var f = formulario;
var valores_hornada="", valores_unidades="", valores_peso="", valores_subproducto="", valores_unidades_a="", valores_peso_a="", valores="";
var LargoForm = f.elements.length;


    for (i = 0; i < LargoForm; i++)
	{
		 if(f.elements[i].name == 'unidades' && f.elements[i].value != '' && f.elements[i].value != 0)
         {
	    	valores_subproducto = valores_subproducto + f.elements[i-6].value +"/";     
			
			valores_hornada = valores_hornada + f.elements[i-5].value +"/";

			if ((f.elements[i-3].value - f.elements[i].value) < 0)
    	    { 
		 	  valores_unidades = valores_unidades + f.elements[i].value +"/";
   			  valores_peso = valores_peso + f.elements[i+1].value +"/";
			  //valores_unidades = valores_unidades + f.elements[i-3].value +"/";
   			  //valores_peso = valores_peso + f.elements[i-2].value +"/";
			  
			  valores_unidades_a = valores_unidades_a + f.elements[i].value - f.elements[i-3].value  +"/";
              valores_peso_a = valores_peso_a + f.elements[i+1].value - f.elements[i-2].value  +"/"
            }
			else
			{
		 	  valores_unidades = valores_unidades + f.elements[i].value +"/";
   			  valores_peso = valores_peso + f.elements[i+1].value +"/";
	        }
		 }
	}	 	

	    
	
	valores = "valores_unidades=" + valores_unidades + "&valores_peso=" + valores_peso + "&valores_unidades_a=" + valores_unidades_a +
	          "&valores_peso_a=" + valores_peso_a + "&valores_hornada=" + valores_hornada + "&valores_subproducto=" + valores_subproducto;
	
	return valores;


}


/***********************/
function guardar_datos()
{
var f = formulario;
var LargoForm = f.elements.length;
var valores = valida_valores();
    
	if(f.cmbtipo.value == -1)
	 {  
	   alert("debe ingresar el tipo de producto");
	   f.cmbtipo.focus();
	   return
	 }

	if(f.cmbproducto.value == -1)
	 {  
	   alert("debe ingresar el producto");
	   f.cmbproducto.focus();
	   return
	 }


	
	 f.action="sea_ing_anodos_trasp_raf01.php?Proceso=G&"+valores;
     f.submit();	
}


/**************************/
function mostrar_datos()
{
var f = formulario;
var fecha_t;

	 fecha_t =  f.ano_t.value+"-"+f.mes_t.value+"-"+f.dia_t.value;
	 
	if(f.cmbtipo.value == -1)
	 {  
	   alert("debe ingresar el tipo de producto");
	   f.cmbtipo.focus();
	   return
	 }

	 if(f.cmbproducto.value == -1)
	 {  
	   alert("debe ingresar el producto");
	   f.cmbproducto.focus();
	   return
	 }

	 f.action="sea_ing_anodos_trasp_raf.php?Proceso=V&fecha_t="+fecha_t;
     f.submit();
}	 
/***************************/
function Buscar(f)
{
	fecha_t =  f.ano_t.value+"-"+f.mes_t.value+"-"+f.dia_t.value;

	if(f.cmbtipo.value == -1)
	 {  
	   alert("Debe ingresar el tipo de producto");
	   f.cmbtipo.focus();
	   return
	 }

	 if(f.cmbproducto.value == -1)
	 {  
	   alert("Debe ingresar el producto");
	   f.cmbproducto.focus();
	   return
	 }
	 
	 if (f.txthornada.value == "")
	 {
	 	alert("Debe Ingresar la Hornada");
		return;
	 }

 	 f.action="sea_ing_anodos_trasp_raf.php?Proceso=V&fecha_t=" + fecha_t + "&buscar_hornada=S";
     f.submit();
}
/***************************/
function traspasar_datos()
{
	var f = formulario;
	var LargoForm = f.elements.length;
     
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == 'checkbox') && (f.elements[i].checked == true))
		{
			f.elements[i+1].value = f.elements[i-2].value; 
			f.elements[i+2].value = f.elements[i-1].value; 
			
		}
		if ((f.elements[i].name == 'checkbox') && (f.elements[i].checked == false))
		{
			f.elements[i+1].value = ''; 
			f.elements[i+2].value = ''; 
		}
	}
	calcula();
}

/*********************/
function calcula()
{

	var f = formulario;
	var saldo;
	var LargoForm = f.elements.length;

	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'unidades')
		{

			f.elements[i+2].value = f.elements[i+3].value - f.elements[i].value;			
			
               
   			  if (f.elements[i-3].value - f.elements[i].value < 0)
			  {
                 if (f.elements[i-8].value == '')
			     {					
						f.elements[i-1].checked=false;	
						
						if(confirm("Esta Considerando M�s Unidades de las Rechazadas � Desea Continuar ?"))
						{
						  f.elements[i-8].value = "falso";
						} 
						else
						{
  		  				  f.elements[i].value="";
						}
					
				  }	
				     
			  }

               saldo = f.elements[i+3].value * 1 + f.elements[i-3].value *1;

			   if (saldo - f.elements[i].value < 0)
				{
				f.elements[i].value="";
				calcula();
	
				alert("las unidades no pueden ser mayor a las unidades de stock");
				//f.elements[i-1].focus();
				return
				}
			

			f.elements[i+1].value = Math.round((f.elements[i+5].value * f.elements[i].value)*1)/1;			
			
			
			f.elements[i+4].value = Math.round((f.elements[i+2].value * f.elements[i+5].value)*1)/1;
			
			if(f.elements[i+4].value < 0)
			{ 
			  f.elements[i+4].value = 0;
			  f.elements[i+2].value = 0;
			} 
		}

	}
}


function Recarga1(f)
{
	f.action = "sea_ing_anodos_trasp_raf.php?recargapag1=S&cmbtipo=" + f.cmbtipo.value;
	f.submit()
}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}

</script>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"></head>

<body leftmargin="0" topmargin="2">
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
      <tr>
      <td align="center" valign="middle">
  <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="2">Fecha Reproceso</td>
            <td width="200"><select name="dia_r" size="1" style="font-face:verdana;font-size:10">
                <?php      
			if($Proceso=='V' || $recargapag1=='S')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia_r)
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
              </select> <select  name="mes_r" size="1" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php	           
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V' || $recargapag1=='S')
		{
		
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes_r)
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
              </select> <select name="ano_r" size="1" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php            
	if($Proceso=='V' || $recargapag1=='S')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano_r)
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
              </select></td>
            <td width="425">&nbsp;</td>
          </tr>
        </table>
		<br>
        <br>
        <table width="750" border="0" cellspacing="0" cellpadding="3" class="TablaDetalle">
          <tr> 
            <td width="102">Tipo Anodo</td>
            <td width="196"> 
              <?php
		    echo '<select name="cmbtipo" id="cmbtipo" onChange="JavaScript:Recarga1(this.form)">';
           
			if ($cmbtipo == "-1")
				echo '<option value="-1" selected>SELECCIONAR</option>';
			else 
				echo '<option value="-1">SELECCIONAR</option>';
		  	if ($cmbtipo == "1")
		  		echo '<option value="1" selected>ANODOS CORRIENTE</option>';
			else 
				echo '<option value="1">ANODOS CORRIENTE</option>';
			if ($cmbtipo == "2")	
				echo '<option value="2" selected>ANODOS HOJAS MADRES</option>';
			else 
				echo '<option value="2">ANODOS HOJAS MADRES</option>';
			if ($cmbtipo == "3")	
				echo '<option value="3" selected>ANODOS ESPECIALES</option>';
			else 
				echo '<option value="3">ANODOS ESPECIALES</option>';							
		    ?>
            </td>
            <td width="141">Subproductos</td>
            <td width="284"><select name="cmbproducto">
                <option value="-1">SELECCIONAR</option>
                <?php
			include("../principal/conectar_principal.php");
				
				if ($cmbtipo == 1) //Corrientes
					$consulta = "SELECT valor_subclase1 AS valor FROM sub_clase WHERE cod_clase = 2002";
				else if ($cmbtipo == 2) //H. Madres
						$consulta = "SELECT valor_subclase2 AS valor FROM sub_clase WHERE cod_clase = 2002";
				else if ($cmbtipo == 3) //Especiales
						$consulta = "SELECT valor_subclase3 AS valor FROM sub_clase WHERE cod_clase = 2002";
					
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					$consulta = "SELECT * FROM subproducto WHERE cod_producto = 17 AND cod_subproducto = '".$row["valor"]."'";
					$rs1 = mysqli_query($link, $consulta);					
					$row1 = mysqli_fetch_array($rs1);
					if ($row1["cod_subproducto"] == $cmbproducto)
						echo '<option value="'.$row1["cod_subproducto"].'" selected>'.$row1["descripcion"].'</option>';
					else
						echo '<option value="'.$row1["cod_subproducto"].'">'.$row1["descripcion"].'</option>';									
				}
		?>
              </select></td>
          </tr>
        </table>
        <br>
        <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="98">Fecha Rechazo</td>
            <td colspan="3"> <select name="dia_t" size="1" style="font-face:verdana;font-size:10">
                <?php      
			if($Proceso=='V' || $recargapag1=='S')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia_t)
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
              </select> <select  name="mes_t" size="1" id="select3" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php	           
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V' || $recargapag1=='S')
		{
		
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes_t)
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
              </select> <select name="ano_t" size="1" id="select4"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php            
	if($Proceso=='V' || $recargapag1=='S')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano_t)
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
              </select> </td>
            <td width="321"><input name="buscar" type="button" style="width:70" value="Buscar" onClick="mostrar_datos();">
              &nbsp;&nbsp;*Fecha Realizada Por Calidad</td>
          </tr>
        </table>
        <br>
        <table width="750" border="0" cellspacing="0" cellpadding="3" class="TablaDetalle">
          <tr> 
            <td width="97">N&deg; Hornada</td>
            <td width="310"><input name="txthornada" type="text" id="txthornada" size="10"></td>
            <td width="322"><input name="btnbuscar" type="button" value="Buscar" style="width:70" onClick="Buscar(this.form)"></td>
          </tr>
        </table>
        <br>
		
        
       <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td><div align="center"><font color="#000000"> 
             <?php   
             if ($Proceso == 'V')
			  echo'<input name="guardar" type="button" style="width:70" value="Traspasar" onClick="guardar_datos();">&nbsp;';
             ?>
              <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
            
                </font></div></td>
          </tr>
        </table>
  <br>
  <?php
  if ($Proceso == 'V')
  {
    
	echo '<table width="750" cellpadding="3" cellspacing="0" border="0" bordercolor="#b26c4a" class="TablaPrincipal">';
	echo '<tr class="ColorTabla01">';
	echo '<td width="105" rowspan="2"><div align="center">Hornada</div></td>';
	  
	echo '<td colspan="2"><div align="center">�nodos Rechazados</div></td>';
	echo '<td width="83" rowspan="2"><div align="center">Todas</div></td>';
	echo '<td colspan="2"><div align="center">Traspaso a Raf</div></td>';
	echo '<td colspan="2"><div align="center">Stock Final</div></td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td width="109"><div align="center">Unidades</div></td>';
	echo '<td width="83"><div align="center">Peso</div></td>';
	echo '<td width="103" ><div align="center">Unidades</div></td>';
	echo '<td width="84" ><div align="center">Peso</div></td>';
	echo '<td width="103" ><div align="center">Unidades</div></td>';
	echo '<td width="84" ><div align="center">Peso</div></td>';
	echo '</tr>';
         
		include("../principal/conectar_sea_web.php");
		include("funciones.php");
	   $fecha = $ano_t.'-'.$mes_t.'-'.$dia_t;

	if ($buscar_hornada == "S")
	{
		$consulta8 = "SELECT cod_producto,cod_subproducto,hornada_ventana AS hornada FROM hornadas";
		$consulta8 = $consulta8." WHERE cod_producto = 17 AND cod_subproducto = ".$cmbproducto." AND RIGHT(hornada_ventana,4) = ".$txthornada;
		$consulta8 = $consulta8." ORDER BY hornada_ventana DESC";
	}
	else
	{
		$consulta8 = "SELECT distinct t1.hornada, t1.cod_subproducto, t1.cod_producto FROM movimientos as t1 inner join hornadas as t2"; 
		$consulta8 = $consulta8." ON t1.hornada = t2.hornada_ventana AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto";   
		$consulta8 = $consulta8." WHERE t1.tipo_movimiento = 6 AND t1.fecha_movimiento =  '$fecha' AND t1.cod_producto = 17 AND"; 
		$consulta8 = $consulta8." t1.cod_subproducto = $cmbproducto AND t2.estado = 0"; 
	}
	
	
	echo $consulta8."<br>";						 
       
	 $rs8 = mysqli_query($link, $consulta8);
	
     while ($row8 = mysqli_fetch_array($rs8))
	{	
			$stockunidad = StockActual($row8[hornada],17,$cmbproducto) + StockRechazo($row8[hornada],17,$cmbproducto);
			
			if($stockunidad <= 0)
			{
				CambiaEstadoHornada($row8[hornada],17,$cmbproducto);
	
			}
			else		
			{
					$hornada=$row8[hornada];
					$subproducto=$row8["cod_subproducto"];		
					$producto=$row8["cod_producto"];		
				
					$unidades = StockRechazo($hornada,$producto,$subproducto);//llamo a la funcion de rechazos
					$stock_actual = StockActual($hornada,$producto,$subproducto);//llamo a la funcion de stock                 
	
					//consulto peso en hornadas  
					$consulta7 = "SELECT * FROM hornadas WHERE hornada_ventana = ".$hornada;
					$consulta7 = $consulta7." and cod_producto = 17 and cod_subproducto = $cmbproducto";
					$rs7 = mysqli_query($link, $consulta7);
	
					if ($row7 = mysqli_fetch_array($rs7))
					{
					$peso_unidad = $row7[peso_unidades] / $row7["unidades"];
					$peso = $unidades * $peso_unidad; 
					$peso = number_format($peso,1,"",""); 
					} 
					$saldo_unidades = $stock_actual;
					$saldo_peso = $stock_actual * $peso_unidad;
							
					//Si busca por hornada y no tiene rechazos en Anodos Rechazados asignar el stock.
					if (($buscar_hornada == "S") and ($unidades == 0))	
					{
						$unidades = $stock_actual;
						$peso = $saldo_peso;
					}
													
				echo'<tr> 	
				  <td><center>
				  <input type="hidden" name="confirmar" size="10">
				  <input type="hidden" name="stock_actual" size="10" value="'.$stock_actual.'">
				  <input type="hidden" name="subproducto" size="10" value="'.$subproducto.'">
				  <input type="hidden" name="hornada" size="10" value="'.$hornada.'">
				  <input type="text" name="hornada_a" size="10" value="'.substr($hornada,6,6).'" disabled>
				  </center></td>
				  <td><center><input type="text" name="unidades_r" size="10" value="'.$unidades.'" disabled></center></td>
				  <td><center><input type="text" name="peso_r" size="10" value="'.number_format($peso,0,"","").'" disabled></center></td>
				  <td width="5%"><center><input type="checkbox" name="checkbox" onClick="traspasar_datos();"></center></td>
				  <td><center><input type="text" name="unidades" size="10" onBlur="calcula();"></center></td>
				  <td><center><input type="text" name="peso"size="10" disabled></center></td>			  
				  <td><center><input type="text" name="saldo_unidades"size="10" value="'.$saldo_unidades.'"disabled></center></td>
				  <input type="hidden" name="stock_unidades" value="'.$saldo_unidades.'" >
				  <td><center><input type="text" name="saldo_peso" size="10" value="'.number_format($saldo_peso,0,0,"").'" disabled></center></td>
				  <input type="hidden" name="peso_unidad" value="'.$peso_unidad.'" >			  
				</tr>';
           }

	  }	
 	 		
		  echo'</table>';	
 }  
 
	echo '<input name="buenos_raf" type="text" value="'.$buscar_hornada.'">';
?>

    </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
