<?php
$CodigoDeSistema = 2;
$CodigoDePantalla = 3;

if($Mensaje == "S")
{
	echo'<script>
	     alert("Datos Modificados");
		 </script>'; 
}

/***** BUSCAR GU�A ***********/

if ($mostrar=="S" || $mostrar == "S2")	
{

	include("../principal/conectar_rec_web.php");
		

	 if($mostrar == "S")		
	 {
		$guia = $guia_aux;
  	    $consulta = "SELECT GUIADP_A, FECHA_A, PATENT_A FROM recepciones WHERE GUIADP_A = $guia AND FECHA_A = '$fecha' AND C_PROD_A = '17' ";
		$result = mysqli_query($link, $consulta);
     }

	 if($mostrar == "S2")		
	 {
  	    $consulta = "SELECT GUIADP_A, FECHA_A, PATENT_A FROM recepciones WHERE GUIADP_A = $guia  AND C_PROD_A = '17' ";
		$result = mysqli_query($link, $consulta); 
		
		$mostrar = "S";
     }

	    if ($row = mysqli_fetch_array($result))
		{
			$fecha= $row['FECHA_A'];
			$ano = substr($fecha,0,4);
			$mes = substr($fecha,5,2);
			$dia = substr($fecha,8,2);
			$fecha_recep = $dia.'-'.$mes.'-'.$ano;
            $patente = $row['PATENT_A'];  
			$guia = $row['GUIADP_A'];
		}
		else
		{
			echo "<Script>
				alert('No Se Encontro Gu�a');  
				JavaScript:window.location = 'sea_ing_recep_ext.php';
				</Script>";        		
		}	
		
		
   include("../principal/conectar_sea_web.php");
   $consulta_g = "SELECT * from movimientos WHERE campo1 = '$guia' and campo2 = '$patente'";
   $rs_g = mysqli_query($link, $consulta_g);
   while($row_g = mysqli_fetch_array($rs_g))
   {	    
		 $Consulta = "SELECT * from movimientos WHERE tipo_movimiento = 2 AND hornada = $row_g["hornada"]";
		 $rs5 = mysqli_query($link, $Consulta);
		 if($row5 = mysqli_fetch_array($rs5))
		 {
			 $Consultar = "S";		
		 }
		 else
		    {
             $Modificar = "S";
			} 
         
         if($Consultar == "S")
		 {
           $Modificar = "N";		 
		   break;
		 } 		 
		 
   }		
		  include("../principal/conectar_rec_web.php");
	
		  $consulta_s = "SELECT SUM(PESONT_A) AS peso_t FROM recepciones WHERE GUIADP_A ='$guia'
						 and PATENT_A='$patente' and C_PROD_A = '17'";
		  $result_s = mysqli_query($link, $consulta_s);
		  if ($row_s = mysqli_fetch_array($result_s))
		  {
						$total_peso = $row_s[peso_t];
			
		  }	
		        
    
}	
	
?>

<html>
<head>
<title>Ingreso de Recepciones</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript">

function calcula_total_unidades()
{
var f = formulario;

	f.total_unidades.value = (f.unidades_corrientes.value *  1)  +  (f.unidades_especiales.value * 1) + (f.unidades_madres.value * 1);
}

function calcula_total_peso()
{
var f = formulario;

	f.peso_origen.value = (f.peso_corrientes.value *  1)  +  (f.peso_especiales.value * 1) + (f.peso_madres.value * 1);
}

function Insertar_Filas()
{
var f = formulario;

    if (f.filas.value > 30)
    {
		alert ("No puede ser Mayor a 30");
		f.filas.focus();
		return
    }

    if (f.guia.value=='')
    {
		alert ("Debe ingresar el N�mero de Gu�a");
		f.guia.focus();
		return
    }

    f.action="sea_ing_recep_ext.php?mostrar=S2&Agregar=S";
	f.submit();
}

function mostrar_guia()
{
var f = formulario;

 	if (isNaN(parseInt(f.guia.value)))			
	{
		alert("El N� Gu�a no es V�lido");
		f.guia.value = '';
		f.guia.focus();
		return
	}	

    f.action="sea_ing_recep_ext.php?mostrar=S2";
	f.submit();
}

function valida_valores()
{
var f = formulario;
var valor1,valor2,valores;
var valores_cmbanodos="", valores_lote="", valores_recargo=""; 
var valores_hornada="", valores_unidades="", valores_peso="";
var LargoForm = f.elements.length;

	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'cmbanodos')		
		{
			valores_cmbanodos = valores_cmbanodos + f.elements[i].value +"/";
		}
	}

	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'lote_ventana')		
		{
			valores_lote = valores_lote + f.elements[i].value +"/";
		}
	}

	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'recargo')		
		{
			valores_recargo = valores_recargo + f.elements[i].value +"/";
		}
	}

	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'hornada')		
		{
			valores_hornada = valores_hornada + f.elements[i].value +"/";
		}
	}
	
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'unidades')		
		{
			valores_unidades = valores_unidades + f.elements[i].value +"/";
		}
	}
	
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'peso')		
		{
			valores_peso = valores_peso + f.elements[i].value +"/";
		}
	}
     valor1 = "&valores_cmbanodos=" + valores_cmbanodos + "&valores_lote=" + valores_lote + "&valores_recargo=" + valores_recargo;
	 valor2 = "&valores_hornada=" + valores_hornada + "&valores_unidades=" + valores_unidades + "& valores_peso=" + valores_peso;

     valores= valor1 + valor2;
     return valores;
	
}
/**************************/
function calcula()
{
var f = formulario;
var suma_corrientes=0, suma_especiales=0, suma_hm=0;
var LargoForm = f.elements.length;
var peso_prom_c=0, peso_prom_h=0, peso_prom_e=0;

   peso_prom_c = f.peso_corrientes.value / f.unidades_corrientes.value;
   peso_prom_h = f.peso_madres.value / f.unidades_madres.value;
   peso_prom_e = f.peso_especiales.value /f.unidades_especiales.value;


   
for (i = 0; i < LargoForm; i++)
{
	if (f.elements[i].name == 'unidades')
	{
		 if(f.elements[i-4].value == -1)
		 {
		 alert("debe seleccionar el tipo de anodo");
		 f.elements[i-4].focus();
		 return
		 }
		   
		   
		  if(f.elements[i-4].value == 1 || f.elements[i-4].value == 2 || f.elements[i-4].value == 3 || f.elements[i-4].value == 13)
		  {
			f.elements[i+1].value = Math.round(peso_prom_c * f.elements[i].value);
			suma_corrientes = suma_corrientes*1 + f.elements[i].value*1;			
					

			   if (f.unidades_corrientes.value < suma_corrientes)
				{
				f.elements[i].value=0;
				f.elements[i+1].value=0;

				alert("No puede ser mayor al Total de Corrientes");
				f.elements[i].focus();
				return
				}

			
		   }

		  if (f.elements[i-4].value == 5 || f.elements[i-4].value == 6 || f.elements[i-4].value == 7 || f.elements[i-4].value == 14)
		  {
			   f.elements[i+1].value = Math.round(peso_prom_h * f.elements[i].value);
			   suma_hm = suma_hm*1 + f.elements[i].value*1;			

			   if (f.unidades_madres.value < suma_hm)
				{
				f.elements[i].value=0;
				f.elements[i+1].value=0;

				alert("No puede ser mayor al Total de Hojas Madres");
				f.elements[i].focus();
				return
				}

			
		   }

		if (f.elements[i-4].value == 9 || f.elements[i-4].value == 10 || f.elements[i-4].value == 12 || f.elements[i-4].value == 15)
		{
			f.elements[i+1].value = Math.round(peso_prom_e * f.elements[i].value);
			suma_especiales = suma_especiales*1 + f.elements[i].value*1;			

			   if (f.unidades_especiales.value < suma_especiales)
				{
				f.elements[i].value=0;
				f.elements[i+1].value=0;

				alert("No puede ser mayor al Total de Especiales");
				f.elements[i].focus();
				return
				}

			
		 }

	}

}

}

/****************************/
function guardar_datos()
{
var f = formulario;
var valores = valida_valores();          
var fecha;
var LargoForm = f.elements.length;
     
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'unidades')
		{
          if((f.elements[i].value == 0) || (f.elements[i].value == ''))
		  {
		  alert("Debe Ingresar Unidadades");
		  f.elements[i].focus();
		  return			
	      }	
		}
    }

   fecha=f.ano.value+"-"+f.mes.value+"-"+f.dia.value;
	    
        if (f.guia.value=='')
        {
                alert ("Debe ingresar el N�mero de Gu�a");
                f.guia.focus();
                return
        }
        
		fecha = "fecha="+fecha;
 
		f.action="sea_ing_recep_ext01.php?Proceso=G&"+fecha+valores;
        f.submit();
  		
}


function modificar_datos()
{
var f = formulario;
var valores = valida_valores();          
var fecha;
var LargoForm = f.elements.length;
     
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'unidades')
		{
          if((f.elements[i].value == 0) || (f.elements[i].value == ''))
		  {
		  alert("Debe Ingresar Unidadades");
		  f.elements[i].focus();
		  return			
	      }	
		}
    }

   fecha=f.ano.value+"-"+f.mes.value+"-"+f.dia.value;
	    
        if (f.guia.value=='')
        {
                alert ("Debe ingresar el N�mero de Gu�a");
                f.guia.focus();
                return
        }
        
		fecha = "fecha="+fecha;
 
		f.action="sea_ing_recep_ext01.php?Proceso=M&"+fecha+valores;
        f.submit();
  		
}

/**************************/
function buscar_datos()
{	
var f = formulario;
	 
    if (f.guia.value=='')
    {
		alert ("Debe ingresar el N�mero de Gu�a");
		f.guia.focus();
		return
    }
		else
		{
		f.total_peso.value='';
		f.action = "sea_ing_recep_ext.php?mostrar2=S";
		f.submit()  
		}
}

/*************************/
function Buscar_Lotes()
{
var f = formulario;
var valores = '';
var LargoForm = f.elements.length;


	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'lote_ventana')
		{
          if(f.elements[i].value == '')
		  {
		  alert("Debe Seleccionar Tipo de �nodo");
		  f.elements[i].focus();
		  return			
	      }	
		}
    }

	
	if (f.guia.value == "")
    {
        alert ("Debe buscar los datos antes de recepci�n");
        f.guia.focus();
               
    }
	else
	{ 
		for (i = 0; i < LargoForm; i++)
		{
			if (f.elements[i].name == 'lote_ventana')		
			{
				valores = valores + f.elements[i].value +"/";
			}
		}
	    
		f.action = "sea_ing_recep_ext.php?mostrar2=S&Buscar=S&valores="+valores;
		f.submit()  
	}
}	

/************************/
function buscar_guia()
{
	window.open("sea_ing_recep_ext03.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
}	

/*******************/
function Ver_Hornadas()
{
	window.open("sea_ing_recep_ext05.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");
}	

/***********************/
function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}	

function Ver_Recepciones()
{
var f = formulario;

       	window.open("sea_ing_recep_ext04.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");

}


</script>

<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"></head>

<body leftmargin="0" topmargin="2">
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <table width="770" border="0"  cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="middle">
    <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="16%" height="30"><font color="#333333" size="2">N&uacute;mero 
              Gu&iacute;a</font></td>
            <td colspan="3"> <font color="#333333" size="2"> 
              <input name="textfield" type="text" value="610456">
              <input name="mostrar" type="button" value="Ok" onClick="mostrar_guia();">
              </font><font color="#333333" size="2"> 
              <input name="buscar_g" type="button"  value="Buscar Gu�a" onClick="buscar_guia();">
              </font> <div align="left"></div></td>
            <td width="17%">Patente Cami&oacute;n</td>
            <td width="19%"><font color="#FFFFFF"> 
              <input name="textfield2" type="text" style="width:70px" value="rx-65-78">
              </font></td>
          </tr>
          <tr> 
            <td height="30"><font color="#333333" size="2">Fecha Recepci&oacute;n</font></td>
            <td colspan="5"><font color="#333333" size="2"> 
              <SELECT name="dia" size="1" style="background:#FFFFCC">
                <option SELECTed>31</option>
              </SELECT>
              <SELECT name="mes" size="1" style="background:#FFFFCC">
                <option SELECTed>SEPTIEMBRE</option>
              </SELECT>
              <SELECT name="ano" size="1" style="background:#FFFFCC">
                <option SELECTed>2003</option>
              </SELECT>
              </font><font color="#FFFFFF">&nbsp; </font></td>
          </tr>
          <tr> 
            <td height="26">Peso Recepci&oacute;n</td>
            <td width="18%"><font color="#333333" size="2"><strong> </strong> 
              <input name="textfield3" type="text" style="width:70px" value="27.590">
              <strong> </strong></font></td>
            <td width="13%"><font color="#333333" size="2"><strong>Total Unidades</strong></font></td>
            <td width="17%"><font color="#FFFFFF">&nbsp; </font><font color="#333333" size="2">&nbsp; 
              <input name="textfield4" type="text" style="width:70px" value="120">
              </font></td>
            <td><font color="#333333" size="2">Peso Origen</font></td>
            <td><font color="#333333" size="2"> 
              <input name="textfield5" type="text" style="width:70px" value="27.590">
              </font></td>
          </tr>
        </table >
	  <br>
        <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td> 
              <div align="center">
                <input type="submit" name="Submit" value="Enviar" style="width:70" onClick="salir_menu();">
                <input type="submit" name="Submit2" value="Enviar" style="width:70" onClick="salir_menu();">
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div>
              </td>
            <?php
			if($Consultar != "S" && $Modificar != "S")
			{
				echo'            
				<td width="15%"><div align="center">Nro. de Lotes</div></td>
				<td width="17%">			      
					  <input name="filas" type="text" size="5">
					  <input name="insertar" type="button" style="width:70" onClick="Insertar_Filas();" value="Insertar">
				</td>';
			}
			?>
          </tr>
        </table>
        <br>
        <table width="100%" cellpadding="3" cellspacing="0" border="1" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="34" height="20"> <div align="center">Nuevo</div></td>
            <td width="115"> <div align="center">Tipo de Anodo</div></td>
            <td width="79"> <div align="center">Lote Ventana</div></td>
            <td width="60"> <div align="center">Hornada</div></td>
            <td width="49"> <div align="center">Recargo</div></td>
            <td width="59"> <div align="center">Unid.</div></td>
            <td width="60"> <div align="center">Peso</div></td>
            <td width="74"> <div align="center">Lote Origen</div></td>
            <td width="75">Marca</td>
            <td width="70">Color</td>
          </tr>
          <tr align="center"> 
            <td> <input type="checkbox" name="checkbox" value="checkbox"> </td>
            <td> <SELECT name="SELECT">
                <option SELECTed>TIPO DE ANODO</option>
              </SELECT></td>
            <td><font color="#333333" size="2"> 
              <input name="textfield32" type="text" style="width:70px" value="307020">
              </font></td>
            <td>5890</td>
            <td>1</td>
            <td><font color="#333333" size="2"> 
              <input name="textfield33" type="text" style="width:50px" value="50">
              </font></td>
            <td>10.650</td>
            <td><font color="#333333" size="2"> 
              <input name="textfield34" type="text" style="width:70px" value="aaa-e34">
              </font></td>
            <td><font color="#333333" size="2"> 
              <input name="textfield35" type="text" style="width:70px" value="ROMACE">
              </font></td>
            <td> <SELECT name="SELECT2">
                <option SELECTed>ROJO</option>
              </SELECT></td>
          </tr>
          <tr align="center"> 
            <td> <input type="checkbox" name="checkbox" value="checkbox"> </td>
            <td> <SELECT name="SELECT">
                <option SELECTed>TIPO DE ANODO</option>
              </SELECT></td>
            <td><font color="#333333" size="2"> 
              <input name="textfield32" type="text" style="width:70px" value="307034">
              </font></td>
            <td>5670</td>
            <td>4</td>
            <td><font color="#333333" size="2"> 
              <input name="textfield33" type="text" style="width:50px" value="70">
              </font></td>
            <td>17.890</td>
            <td><font color="#333333" size="2"> 
              <input name="textfield34" type="text" style="width:70px" value="bba-e56">
              </font></td>
            <td><font color="#333333" size="2"> 
              <input name="textfield35" type="text" style="width:70px" value="CECEMA">
              </font></td>
            <td> <SELECT name="SELECT2">
                <option SELECTed>ROJO</option>
              </SELECT></td>
          </tr>
        </table> 
		
		<br>
        <table width="587" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="27%"><div align="left"><strong>&Aacute;nodos Corrientes</strong></div></td>
            <td width="18%">120</td>
            <td width="26%">Recepciones Ingresadas</td>
            <td width="29%"><input type="button" name="buscar_recepcionados" style="width:90" value="Ver Datos" onClick="Ver_Recepciones();"></td>
          </tr>
          <tr> 
            <td><strong>&Aacute;nodos Especiales</strong></td>
            <td>0</td>
            <td>Hornadas Ingresadas</td>
            <td><input type="button" name="buscar_hornadas" style="width:90" value="Ver Hornadas" onClick="Ver_Hornadas();"></td>
          </tr>
          <tr> 
            <td><strong>&Aacute;nodos H.Madres</strong></td>
            <td>0</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
