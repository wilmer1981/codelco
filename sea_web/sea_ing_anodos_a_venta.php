<?php 
$CodigoDeSistema = 2;
$CodigoDePantalla = 34;

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = "";
}
if(isset($_REQUEST["fecha_t"])) {
	$fecha_t = $_REQUEST["fecha_t"];
}else{
	$fecha_t = "";
}
if(isset($_REQUEST["Mensaje"])) {
	$Mensaje = $_REQUEST["Mensaje"];
}else{
	$Mensaje = "";
}
if(isset($_REQUEST["radio"])) {
	$radio = $_REQUEST["radio"];
}else{
	$radio = "";
}
if(isset($_REQUEST["cmbtipo"])) {
	$cmbtipo = $_REQUEST["cmbtipo"];
}else{
	$cmbtipo = "";
}
if(isset($_REQUEST["cmbproducto"])) {
	$cmbproducto = $_REQUEST["cmbproducto"];
}else{
	$cmbproducto = "";
}
if(isset($_REQUEST["dia_t"])) {
	$dia_t = $_REQUEST["dia_t"];
}else{
	$dia_t = date("d");
}
if(isset($_REQUEST["mes_t"])) {
	$mes_t = $_REQUEST["mes_t"];
}else{
	$mes_t =  date("m");
}
if(isset($_REQUEST["ano_t"])) {
	$ano_t = $_REQUEST["ano_t"];
}else{
	$ano_t =  date("Y");
}
if(isset($_REQUEST["dia_r"])) {
	$dia_r = $_REQUEST["dia_r"];
}else{
	$dia_r = date("d");
}
if(isset($_REQUEST["mes_r"])) {
	$mes_r = $_REQUEST["mes_r"];
}else{
	$mes_r =  date("m");
}
if(isset($_REQUEST["ano_r"])) {
	$ano_r = $_REQUEST["ano_r"];
}else{
	$ano_r =  date("Y");
}
$recargapag1 = isset($_REQUEST["recargapag1"])?$_REQUEST["recargapag1"]:"";
  /*if($Mensaje == 1)
  {
  	echo "<Script>
	alert('Datos Guardados');  
	</Script>"; 	
  }*/


?>
<html>
<head>
<title>&Aacute;nodos A Venta</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style></head>
<script language="JavaScript">

function recarga_opciones()
{
var f = formulario;
var LargoForm = f.elements.length;
     
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == "radio") && (f.elements[i].checked == true))
		{			 			 
           radio = f.elements[i].value;
			 f.action="sea_ing_anodos_a_venta.php?radio="+radio;
			 f.submit();

		}
    }		 
}

/************************/
function valida_valores()
{
var f = formulario;
var valores_hornada="", valores_unidades="", valores_peso="", valores_subproducto="", valores_producto="", valores="";
var LargoForm = f.elements.length;


    for (i = 0; i < LargoForm; i++)
	{
		 if(f.elements[i].name == 'unidades' && f.elements[i].value != '' && f.elements[i].value != 0)
         {
	    	valores_producto = valores_producto + f.elements[i-7].value +"/";     

	    	valores_subproducto = valores_subproducto + f.elements[i-6].value +"/";     
			
			valores_hornada = valores_hornada + f.elements[i-5].value +"/";

			valores_unidades = valores_unidades + f.elements[i].value +"/";
			
			valores_peso = valores_peso + f.elements[i+1].value +"/";
		 }
	}	 	

	    
	
	valores = "valores_unidades=" + valores_unidades + "&valores_peso=" + valores_peso + "&valores_hornada=" + valores_hornada + 
	          "&valores_subproducto=" + valores_subproducto + "&valores_producto=" + valores_producto;

	return valores;


}


/***********************/
function guardar_datos_R()
{
var f = formulario;
var LargoForm = f.elements.length;
var valores = valida_valores();
    
	if(f.cmbproducto.value == -1)
	 {  
	   alert("debe ingresar el producto");
	   f.cmbproducto.focus();
	   return
	 }

	
	 f.action="sea_ing_anodos_a_venta01.php?Proceso=G1&"+valores;
     f.submit();	
}

/***********************/
function guardar_datos_P()
{
var f = formulario;
var LargoForm = f.elements.length;
var valores = valida_valores();
    
	if(f.cmbproducto.value == -1)
	 {  
	   alert("debe ingresar el producto");
	   f.cmbproducto.focus();
	   return
	 }

	
	 f.action="sea_ing_anodos_a_venta01.php?Proceso=G2&"+valores;
     f.submit();	
}


/**************************/
function mostrar_datos()
{
var f = formulario;
var fecha_t;

	 fecha_t =  f.ano_t.value+"-"+f.mes_t.value+"-"+f.dia_t.value;
	 
	if(f.radio[0].checked == false && f.radio[1].checked == false)
	{
		alert("Debe escoger si �nodo es rechazado o Producci�n");
		return	
	}

	 if(f.cmbproducto.value == -1)
	 {  
	   alert("debe ingresar el producto");
	   return
	   f.cmbproducto.focus();
	 }


	 f.action="sea_ing_anodos_a_venta.php?Proceso=V&fecha_t="+fecha_t;
     f.submit();
}	 


function mostrar_datos2()
{
var f = formulario;
var fecha_t;

	 fecha_t =  f.ano_t.value+"-"+f.mes_t.value+"-"+f.dia_t.value;
	 
	 f.action="sea_ing_anodos_a_venta.php?Proceso=V&fecha_t="+fecha_t;
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

			   if (f.elements[i+2].value < 0)
				{
				f.elements[i-1].checked=false;
				f.elements[i].value="";
				calcula();
	
				alert("las unidades no pueden ser mayor a las unidades de stock");
				//f.elements[i-1].focus();
				return
				}
			
			//saldo = (f.elements[i+5].value * f.elements[i].value); 
			f.elements[i+1].value = Math.round((f.elements[i+5].value * f.elements[i].value)*1)/1;			
			f.elements[i+4].value = Math.round((f.elements[i+2].value * f.elements[i+5].value)*1)/1;
			
		}

	}
}


function Recarga1(f)
{
	f.action = "sea_ing_anodos_a_venta.php?recargapag1=S&cmbtipo=" + f.cmbtipo.value;
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

<body>
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
      <tr>
      <td align="center" valign="top">
  <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="2">Fecha A Venta</td>
            <td width="267"><select name="dia_r" size="1" style="font-face:verdana;font-size:10">
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
            <td width="155"> 
              <?php  
			    if($radio == 'R')
			    echo'<input type="radio" name="radio" value="R" checked onClick="mostrar_datos2();">';
				else
			    echo'<input type="radio" name="radio" value="R" onClick="mostrar_datos2();">';
              ?>
              �nodos Rechazados</td>
            <td width="203"> 
              <?php  
			    if($radio == 'P')
			    echo'&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="radio" value="P" checked onClick="mostrar_datos2();">';
                else
			    echo'&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="radio" value="P" onClick="mostrar_datos2();">';
			?>
              &Aacute;nodos Producidos</td>
          </tr>
        </table>
		<br>
        <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="98">Fecha Origen</td>
            <td colspan="4"> <select name="dia_t" size="1" style="font-face:verdana;font-size:10">
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
              </select> <select  name="mes_t" size="1" id="select" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              </select> <select name="ano_t" size="1" id="select2"  style="FONT-FACE:verdana;FONT-SIZE:10">
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
          </tr>
          <tr> 
            <td width="98">Tipo Anodo</td>
            <td width="157"> 
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
            <td width="83">Subproductos</td>
            <td width="220"> <select name="cmbproducto">
                <option value="-1">SELECCIONAR</option>
                <?php
				if($cmbtipo!=""){
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
						$consulta = "SELECT * FROM subproducto WHERE cod_producto = 17 AND cod_subproducto = '".$row["valor"]."' AND mostrar_sea = 'S'";
						$rs1 = mysqli_query($link, $consulta);					
						if ($row1 = mysqli_fetch_array($rs1))
						{
							if ($row1["cod_subproducto"] == $cmbproducto)
								echo '<option value="'.$row1["cod_subproducto"].'" selected>'.$row1["descripcion"].'</option>';
							else
								echo '<option value="'.$row1["cod_subproducto"].'">'.$row1["descripcion"].'</option>';
						}
					}
				}
				?>
              </select> </td>
            <td width="159"> <input name="buscar" type="button" style="width:70" value="Buscar" onClick="mostrar_datos();"> 
            </td>
          </tr>
        </table> <br>
		
        
       <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td><div align="center"><font color="#000000"> 
             <?php   
             if($Proceso == 'V' and $radio == 'R')
			  echo'<input name="guardar" type="button" style="width:70" value="A Venta" onClick="guardar_datos_R();">&nbsp;';
             elseif($Proceso == 'V' and $radio == 'P')
			  echo'<input name="guardar" type="button" style="width:70" value="A Venta" onClick="guardar_datos_P();">&nbsp;';

			 ?>
              <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
            
                </font></div></td>
          </tr>
        </table>

  <?php
  
  echo'
  <table width="750" cellpadding="3" cellspacing="0" border="0" bordercolor="#b26c4a" class="TablaPrincipal">
    <tr class="ColorTabla01">
      <td width="105" rowspan="2"><div align="center">Hornada</div></td>
      <td colspan="2"><div align="center">�nodos Para Venta</div></td>
      <td width="83" rowspan="2"><div align="center">Todas</div></td>
      <td colspan="2"><div align="center">Traspaso a Venta</div></td>
      <td colspan="2"><div align="center">Stock Final</div></td>
    </tr>
    <tr> 
      <td width="109"><div align="center">Unidades</div></td>
      <td width="83"><div align="center">Peso</div></td>
      <td width="103" ><div align="center">Unidades</div></td>
      <td width="84" ><div align="center">Peso</div></td>
      <td width="103" ><div align="center">Unidades</div></td>
      <td width="84" ><div align="center">Peso</div></td>
    </tr>';
  if($Proceso != 'V')
  {
   echo'</table>';        
  }
  if ($Proceso == 'V')
  {
		include("../principal/conectar_sea_web.php");
		include("funciones.php"); //funciones de stock		
	   $fecha = $ano_t.'-'.$mes_t.'-'.$dia_t;


     if($radio == 'R')
	 {
 	 $consulta8 = "SELECT distinct t1.hornada, t1.cod_subproducto, t1.cod_producto FROM movimientos as t1 inner join hornadas as t2 
	               ON t1.hornada = t2.hornada_ventana AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto   
	               WHERE t1.tipo_movimiento = 6 AND t1.fecha_movimiento =  '".$fecha."' AND t1.cod_producto = 17 AND 
				         t1.cod_subproducto = '".$cmbproducto."' AND t2.estado = 0"; 
    // $rs8 = mysqli_query($link, $consulta8);

     }else{
		$consulta8 = "SELECT distinct t1.hornada, t1.cod_subproducto, t1.cod_producto FROM movimientos as t1 inner join hornadas as t2 
						ON t1.hornada = t2.hornada_ventana AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto   
						WHERE t1.tipo_movimiento = 1 AND t1.fecha_movimiento = '".$fecha."' AND t1.cod_producto = 17 AND 
							t1.cod_subproducto = '".$cmbproducto."' AND t2.estado = 0"; 
	 }
/*
     elseif($radio == 'P') 	 
	 {
	 $consulta8 = "SELECT distinct t1.hornada, t1.cod_subproducto, t1.cod_producto FROM movimientos as t1 inner join hornadas as t2 
	               ON t1.hornada = t2.hornada_ventana AND t1.cod_producto = t2.cod_producto AND t1.cod_subproducto = t2.cod_subproducto   
	               WHERE t1.tipo_movimiento = 1 AND t1.fecha_movimiento = '".$fecha."' AND t1.cod_producto = 17 AND 
				         t1.cod_subproducto = '".$cmbproducto."' AND t2.estado = 0"; 

     $rs8 = mysqli_query($link, $consulta8);
	 }*/

	 $rs8 = mysqli_query($link, $consulta8);
     while ($row8 = mysqli_fetch_array($rs8))
	{	
   		$hornada=$row8["hornada"];
  		$producto=$row8["cod_producto"];
  		$subproducto=$row8["cod_subproducto"];
		
				

					//consulto peso en hornadas
                 if($radio == 'R')
				 {
				 	$consulta7 = "SELECT * FROM hornadas WHERE hornada_ventana = '".$hornada."' ";
					$consulta7 = $consulta7." and cod_producto = 17 and cod_subproducto = '".$cmbproducto."' ";
					$rs7 = mysqli_query($link, $consulta7);

					if ($row7 = mysqli_fetch_array($rs7))
					{
					$peso_unidad = $row7["peso_unidades"] / $row7["unidades"];
   				    $unidades = StockRechazo($hornada,$producto,$subproducto, $link);//llamo a la funcion de rechazos
					$peso = $unidades * $peso_unidad; 
					$peso = number_format($peso,1,"",""); 
					} 
					$saldo_unidades = $unidades;
					$saldo_peso = $unidades * $peso_unidad;

	             }
				
				 elseif($radio == 'P') 	 
				 {
				 	$consulta7 = "SELECT * FROM hornadas WHERE hornada_ventana = '".$hornada."' ";
					$consulta7 = $consulta7." and cod_producto = 17 and cod_subproducto = '".$cmbproducto."' ";
					$rs7 = mysqli_query($link, $consulta7);

					if ($row7 = mysqli_fetch_array($rs7))
					{
					$peso_unidad = $row7["peso_unidades"] / $row7["unidades"];
					$unidades = StockActual($hornada,$producto,$subproducto, $link);//llamo a la funcion de stock actual
					$peso = $unidades * $peso_unidad; 
					$peso = number_format($peso,1,"",""); 
					} 

				 }
		    				
												
			echo'<tr> 	
			  <td><center>
			  <input type="hidden" name="producto" size="10" value="'.$producto.'">
			  <input type="hidden" name="subproducto" size="10" value="'.$subproducto.'">
			  <input type="hidden" name="hornada" size="10" value="'.$hornada.'">
			  <input type="text" name="hornada_a" size="10" value="'.substr($hornada,6,6).'" disabled>
			  </center></td>
			  <td><center><input type="text" name="unidades_r" size="10" value="'.$unidades.'" disabled></center></td>
			  <td><center><input type="text" name="peso_r" size="10" value="'.number_format($peso,0,"","").'" disabled></center></td>
	    	  <td width="5%"><center><input type="checkbox" name="checkbox" onClick="traspasar_datos();"></center></td>
			  <td><center><input type="text" name="unidades" size="10" onBlur="calcula();"></center></td>
			  <td><center><input type="text" name="peso"size="10" disabled></center></td>			  
			  <td><center><input type="text" name="saldo_unidades"size="10" value="'.$unidades.'"disabled></center></td>
    		  <input type="hidden" name="stock_unidades" value="'.$unidades.'" >
			  <td><center><input type="text" name="saldo_peso" size="10" value="'.number_format($peso,0,0,"").'" disabled></center></td>
     		  <input type="hidden" name="peso_unidad" value="'.$peso_unidad.'" >			  
			</tr>';
    }	
 	 		
		  echo'</table>';	
}  
?>    </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
