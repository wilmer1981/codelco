<?php
$CodigoDeSistema = 2;
$CodigoDePantalla = 3;

/***** BUSCAR GU�A ***********/
if ($mostrar=="S" || $mostrar2 == "S")	
{
    $valores_lote='';
	include("../principal/conectar_rec_web.php");

	 if($mostrar2 == "S")		
	 {
  	    if($guia == '')
		$guia = $guia_aux;

		$consulta = "SELECT GUIADP_A, FECHA_A, PATENT_A, LOTE_A, RECARG_A FROM recepciones WHERE PATENT_A = '$patente' AND GUIADP_A = $guia  AND FECHA_A = '$fecha' AND C_PROD_A = '17' ";
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
			$recargo = $row[RECARG_A];
	
	  	    $consulta = "SELECT distinct LOTE_A FROM recepciones WHERE FECHA_A = '$fecha' AND PATENT_A = '$patente' AND GUIADP_A = $guia  AND C_PROD_A = '17' ";
	        $rs = mysqli_query($link, $consulta);
			while($row2 = mysqli_fetch_array($rs))
			{  		
			     $valores_lote = $row2['LOTE_A'].'/'.$valores_lote;
			}
		}
		  include("../principal/conectar_rec_web.php");
	
		  $consulta_s = "SELECT SUM(PESONT_A) AS peso_t FROM recepciones WHERE GUIADP_A = $guia AND FECHA_A = '$fecha' 
						 and PATENT_A='$patente' and C_PROD_A = '17'";
		  $result_s = mysqli_query($link, $consulta_s);
		  if ($row_s = mysqli_fetch_array($result_s))
		  {
				$peso_recepcion = $row_s[peso_t];
			
		  }	
		         
   include("../principal/conectar_sea_web.php");
   $consulta_g = "SELECT * from movimientos WHERE campo1 = '$guia' and campo2 = '$patente'";
   $rs_g = mysqli_query($link, $consulta_g);
   while($row_g = mysqli_fetch_array($rs_g))
   {	    
		 $Consulta = "SELECT * from movimientos WHERE tipo_movimiento = 6 AND hornada = $row_g[hornada]";
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

}	
?>

<html>
<head>
<title>Distribuci�n de Recepciones</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript">
var fila = 12; //Posicion Inicial de la Fila.
var col = 13;

function calcula_total_unidades()
{
var f = formulario;

	f.total_unidades.value = (f.unidades_corrientes.value *  1)  +  (f.unidades_especiales.value * 1) + (f.unidades_madres.value * 1);
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

    f.action="sea_ing_recep_ext.php?mostrar2=S&Agregar=S";
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
	 valor2 = "&valores_hornada=" + valores_hornada + "&valores_unidades=" + valores_unidades + "&valores_peso=" + valores_peso;

     valores= valor1 + valor2;
     return valores;
	
}
/**************************/
function calcula_peso()
{
var f = formulario;
var LargoForm = f.elements.length;
var peso_prom = 0;
var suma = 0;

    peso_prom = f.total_peso.value / f.total_unidades.value;

	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'unidades')
		{
	
			suma = suma * 1 + f.elements[i].value * 1;			
						
			if (f.total_unidades.value < suma)
			{
				f.elements[i].value=0;
				f.elements[i+1].value=0;
	
				alert("No puede ser mayor al Total de Unidades");
				f.elements[i].focus();
				return
			 }
			 else
			 {
				f.elements[i+1].value = Math.round(f.elements[i].value * peso_prom);
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
	    
        if (f.guia.value=='')
        {
                alert ("Debe ingresar el N�mero de Gu�a");
                f.guia.focus();
                return
        }
        
 
		f.action="sea_ing_recep_ext01.php?Proceso=M&"+valores;
        f.submit();
  		
}
/************************/
function AlgunChequeado()
{
var f = formulario;

	try{
		pos = fila; //Posicion del Checkbox que Indica la Primera Fila.
		largo = f.elements.length;
		for (i=pos; i<largo; i=i+col)
		{	
			if (f.elements[i].type != 'checkbox')
				return false;
			else if (f.elements[i].checked == true)
					return true;
		}	
		return false;
	}catch(e){	
		return false;
	}
}

function Eliminar_Datos()
{
var f=formulario;
var valor = AlgunChequeado();


	if(valor != false)
	{
		f.action="sea_ing_recep_ext01.php?Proceso=E";
		f.submit();
	}
	else
	{
   	    alert('No hay Datos Seleccionados');
		return
	}
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
	
	if (f.guia.value == "")
    {
        alert ("Debe Ingresar los datos antes de recepci�n");
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
	    
		f.action = "sea_ing_guia_nueva.php?Buscar=S&valores="+valores;
		f.submit()  
	}
}	



</script>

<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"></head>

<body leftmargin="0" topmargin="2">
<form name="formulario" method="post" action="">
  <table width="770" border="0"  cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="middle">
    <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="18%" height="30">N&uacute;mero Gu&iacute;a</td>
            <td width="19%"> <?php
		  if($mostrar=='S' || $mostrar2=='S' || $Agregar=='S')		  	
          echo "<input name='guia' type='text' size='10' value='$guia'>";
          else
		  echo "<input name='guia' type='text' size='10'>";		  
		  ?>
            </td>
            <td>Patente Cami&oacute;n</td>
            <td>
              <?php
		  if($mostrar=='S' || $mostrar2=='S' || $Agregar=='S')		  	
			    echo '<input name="patente" type="text" size="10" value="'.$patente.'">';
   		     ?>
            </td>
            <td>&nbsp; </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="30">Fecha Recepci&oacute;n</td>
            <td colspan="5"> <select name="dia" size="1" style="background:#FFFFCC">
                <?php
		  if($mostrar=='S' || $mostrar2=='S' || $Agregar=='S')		  	
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
              </select> <select name="mes" size="1" style="background:#FFFFCC">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		  if($mostrar=='S' || $mostrar2=='S' || $Agregar=='S')		  	
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
              </select> <select name="ano" size="1" style="background:#FFFFCC">
                <?php
    if($mostrar=='S' || $mostrar2=='S' || $Agregar=='S')		  	
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
              </select> </td>
          </tr>
          <tr> 
            <td height="26">Peso Recepci&oacute;n</td>
            <td><font color="#333333" size="2"> <?php
		  if($mostrar=='S' || $mostrar2=='S' || $Agregar=='S')		  	
          echo'<input name="peso_recepcion" type="text" size="10" value="'.$peso_recepcion.'" style="background:#FFFFCC">';
		  else
          echo'<input name="peso_recepcion" type="text" size="10" style="background:#FFFFCC">';
		  ?>
              </font></td>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td height="26"><strong>Total Unidades</strong></td>
            <td> <?php
		  if($mostrar=='S' || $mostrar2=='S' || $Agregar=='S')		  	
          echo'<input name="total_unidades" type="text" size="10" value="'.$total_unidades.'">';
		  else
          echo'<input name="total_unidades" type="text" size="10">';
		  ?>
            </td>
            <td width="14%"><strong>Total Peso</strong></td>
            <td width="11%"> 
              <?php
		  if($mostrar=='S' || $mostrar2=='S' || $Agregar=='S')		  	
          echo'<input name="total_peso" type="text" size="10" value="'.$peso_recepcion.'">';
		  else
          echo'<input name="total_peso" type="text" size="10">';
		  ?>
            </td>
            <td width="23%">&nbsp;</td>
            <td width="15%"><font color="#333333" size="2">&nbsp; </font></td>
          </tr>
        </table >
	  <br>
        <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td> 
              <div align="center">
                <?php
				if($Modificar != "S")				
					echo'<input name="guardar" type="button"  style="width:70" onClick="guardar_datos();" value="Guardar">';
                else
				{
					echo'<input name="modificar" type="button"  style="width:70" onClick="modificar_datos();"  value="Modificar">&nbsp;';
					echo'<input name="eliminar" type="button"  style="width:70" onClick="Eliminar_Datos();"  value="Eliminar">';
                }
				?>
				<input name="cerrar" type="button" style="width:70" onClick="self.close()" value="Cerrar">
              </div>
              </td>
          </tr>
        </table>
        <br>
        <table width="100%" cellpadding="3" cellspacing="0" border="1" class="TablaDetalle">
          <tr> 
             <?php
				if($Modificar != "S")
				{
				echo'         
				
					<td height="20" colspan="3"><div align="center">
						<input name="busca_lotes" type="submit" id="busca_lotes" value="Buscar Lotes" onClick="Buscar_Lotes();">
					  </div></td>
				   
		              <td height="20" colspan="2">Agregar Nuevos Lotes</td>
        		      <td colspan="3"> 
					  <input name="filas" type="text" size="5" value="'.$filas.'">
					  <input name="insertar" type="button" style="width:70" onClick="Insertar_Filas();" value="Insertar">';
				}
			?>
            </td>
          </tr>
          <tr align="center" class="ColorTabla01"> 
            <td width="213" height="20"> <div align="center"></div>
              <div align="center">Tipo de Anodo</div></td>
            <td width="65"> <div align="center">Lote V.</div></td>
            <td width="70"> <div align="center">Hornada</div></td>
            <td width="65"> <div align="center">Recargo</div></td>
            <td width="67"> <div align="center">Unid.</div></td>
            <td width="72"> <div align="center">Peso</div></td>
            <td width="68"> <div align="center">Lote O.</div></td>
            <td width="71"> <div align="center">Marca</div></td>
          </tr>
          <?php
		 
if(($mostrar=='S' || $Agregar =='S') && $Buscar != "S" && $Modificar != "S")	
{
  $largo_lote = strlen($valores_lote);
	
  for ($i=0; $i < $largo_lote; $i++)
  {	
	if (substr($valores_lote,$i,1) == "/")
	{				
			$lote_ventana = substr($valores_lote,0,$i);				
			$valores_lote = substr($valores_lote,$i+1);
			$i=0;

		  if($lote_ventana != '')
		  {
			  $consulta = "SELECT * FROM relaciones WHERE lote_ventana = $lote_ventana";
              include("../principal/conectar_sea_web.php");
			  $rs = mysqli_query($link, $consulta);
			  if ($row = mysqli_fetch_array($rs))
			  {
				  $cmbanodos = $row["cod_origen"];
				  $hornada = $row[hornada_ventana];		 
				  $lote_origen = $row[lote_origen];
				  $marca = $row['marca'];		 
			  }
			  else
			  {
			  } 	
		  }	
		
          echo'<tr align="center">';
          echo'<td>';
			echo'<select name="cmbanodos" style="width:200" style="background:#FFFFCC">';           
			echo '<option value="-1" selected>Seleccionar</option>';

			$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' and cod_subproducto in(1,2,3,5,6,7,9,10,12,13,14,15)";
	        include("../principal/conectar_principal.php");
			$rs2 = mysqli_query($link, $consulta);
		   
			while($row2 = mysqli_fetch_array($rs2))						
			{			
			if ($row2['cod_subproducto'] == $cmbanodos)
				echo '<option value="'.$row2['cod_subproducto'].'" selected>'.$row2['descripcion'].'</option>';
			else 
				echo '<option value="'.$row2['cod_subproducto'].'">'.$row2['descripcion'].'</option>';
			}

			 echo"</select>";
            
			echo'</td>';
            echo'<td><input name="lote_ventana" type="text" style="width:50px" value="'.$lote_ventana.'"></td>';
            echo'<td><input name="hornada_ventana" type="text" style="width:50px" value="'.substr($hornada,6,6).'"></td>';
            echo'<td><input name="recargo" type="text" style="width:50px" value="'.$recargo.'"></td>';
            echo'<td><input name="unidades" type="text" style="width:50px" value="'.$unidades.'" onBlur="calcula_peso();"></td>';
            echo'<td><input name="peso" type="text" style="width:60px" value="'.$peso.'"></td>';
            echo'<td><input name="lote_origen" type="text"  style="width:60px" value="'.$lote_origen.'"></td>';
   			echo'<td><input name="marca" type="text" size="10" value="'.$marca.'"></td>';
            echo'</td>
          </tr>';
			  echo'<input name="hornada" type="hidden" size="12" value="'.$hornada.'">';

     }		  

  }
}

if($Agregar == "S" )
{
	for($i=1; $i<=$filas ;$i++)
	{        
          echo'<tr align="center">';
          echo'<td>';
			echo'<select name="cmbanodos" style="width:200" style="background:#FFFFCC">';           
			echo '<option value="-1" selected>Seleccionar</option>';

			$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' and cod_subproducto in(1,2,3,5,6,7,9,10,12,13,14,15)";
	        include("../principal/conectar_principal.php");
			$rs2 = mysqli_query($link, $consulta);
		   
			while($row2 = mysqli_fetch_array($rs2))						
			{			
			if ($row2['cod_subproducto'] == $cmbanodos)
				echo '<option value="'.$row2['cod_subproducto'].'" selected>'.$row2['descripcion'].'</option>';
			else 
				echo '<option value="'.$row2['cod_subproducto'].'">'.$row2['descripcion'].'</option>';
			}

			 echo"</select>";
            
			echo'</td>';
            echo'<td><input name="lote_ventana" type="text" style="width:50px" onBlur="Buscar_Lotes();"></td>';
            echo'<td><input name="hornada" type="text" style="width:50px"></td>';
            echo'<td><input name="recargo" type="text" style="width:50px"></td>';
            echo'<td><input name="unidades" type="text" style="width:50px" onBlur="calcula_peso();"></td>';
            echo'<td><input name="peso" type="text" style="width:60px"></td>';
            echo'<td><input name="lote_origen" type="text"  style="width:60px"></td>';
   			echo'<td><input name="marca" type="text" size="10"></td></tr>';
	}
}

if($Buscar == "S" && $Modificar != "S")
{

	$largo_v = strlen($valores);
	for ($i=0; $i < $largo_v; $i++)
	{

		 $cmbanodos = '';
		 $lote_ventana = '';
		 $lote_origen = '';	
		 $hornada = '';
		 $recargo = '';
		 $marca = '';
		if (substr($valores,$i,1) == "/")
		{				            
			$valor = substr($valores,0,$i);				
			$valores= substr($valores,$i+1);
			$i = 0;
			$j = $j + 1;
			include("../principal/conectar_sea_web.php");
		   
		  if($valor != '')	
		  {
			$consulta = "SELECT * FROM relaciones WHERE lote_ventana = $valor ";
			$result = mysqli_query($link, $consulta);
		 
			if ($row = mysqli_fetch_array($result))
			{
			 $cmbanodos = $row[cod_origen];
			 $lote_ventana = $row["lote_ventana"];
			 $lote_origen = $row[lote_origen];	
			 $hornada = $row[hornada_ventana];
			 $recargo = $row["recargo"];
			 $marca = $row[marca];
			}
		  }						

		  echo'<tr align="center"> 
				<td>';
				echo'<select name="cmbanodos" style="width:200" style="background:#FFFFCC">';           
				echo '<option value="-1" selected>Seleccionar</option>';
		
				$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' and cod_subproducto in(1,2,3,5,6,7,9,10,12,13,14,15)";
				include("../principal/conectar_principal.php");
				$rs2 = mysqli_query($link, $consulta);
			   
				while($row2 = mysqli_fetch_array($rs2))						
				{			
				if ($row2['cod_subproducto'] == $cmbanodos)
					echo '<option value="'.$row2['cod_subproducto'].'" selected>'.$row2['descripcion'].'</option>';
				else 
					echo '<option value="'.$row2['cod_subproducto'].'">'.$row2['descripcion'].'</option>';
				}
		
				 echo"</select>";
				
				echo'</td>';
				echo'<td><div align="center">
				      <input name="lote_ventana" type="text" value="'.$lote_ventana.'" style="width:50px"> 
				</div></td>';
				
				echo'<td><div align="center"> 
					<input name="hornada_ventana" type="text" value="'.substr($hornada,6,6).'" style="width:50px">
				</div></td>';
				
				$fecha = $ano.'-'.$mes.'-'.$dia;
                $consulta3 = "SELECT RECARG_A FROM recepciones WHERE GUIADP_A = $guia  AND C_PROD_A = '17' AND FECHA_A = '$fecha' AND PATENT_A = '$patente'";
				include("../principal/conectar_rec_web.php");                
				$rs3 = mysqli_query($link, $consulta3);
				
				if($row3 = mysqli_fetch_array($rs3))
				{
					$recargo = $row3[RECARG_A];
					echo'<td><div align="center"> 
						<input name="recargo" type="text" value="'.$recargo.'" style="width:50px">
					</div></td>';
				}
				else
					$recargo = '';
				echo'<td><div align="center"> 
					<input name="unidades" type="text" value="'.$unidades.'" onBlur="calcula_peso();" style="width:50px">
				</div></td>';
				
				echo'<td><div align="center">
					<input name="peso" type="text" value="'.$peso.'" style="width:60px">
				</div></td>';
				
				echo'<td><div align="center">
					<input name="lote_origen" type="text" value="'.$lote_origen.'" style="width:60px">
				</div></td>';
				
				echo'<td><div align="center">
					<input name="marca" type="text" size="10" value="'.$marca.'">
				</div></td>
			  </tr>';
			  
			  echo'<input name="hornada" type="hidden" size="12" value="'.$hornada.'">';

		}	  
	}					  

}	  

if($Modificar == "S")
{
	include("../principal/conectar_sea_web.php");
	$consulta = "SELECT * FROM movimientos WHERE campo1 = $guia and campo2 = '$patente'";
	$rs = mysqli_query($link, $consulta);

	while($row = mysqli_fetch_array($rs))
	{
      $i = $i + 1;
	  $cmbanodos = $row["cod_subproducto"];
	  $hornada = $row[hornada];
	  $recargo = $row[numero_recarga];
	  $unidades = $row["unidades"];
	  $peso = $row["peso"];
	  
	  $consulta = "SELECT * FROM relaciones WHERE hornada_ventana = $hornada";
	  include("../principal/conectar_sea_web.php");
	  $rs3 = mysqli_query($link, $consulta);
	  
	  if($row3 = mysqli_fetch_array($rs3))
	  {
	  	$lote_ventana = $row3["lote_ventana"];
	  	$lote_origen = $row3[lote_origen];
	    $marca = $row3[marca];
	  }		
	  
	  echo'<tr>'; 
			echo'<input name="a['.$i.']" type="hidden" size="8">';
			echo'<td>';
			echo'<input type="checkbox" name="checkbox['.$i.']" value="'.$hornada.'">';
			echo'<select name="cmbanodos['.$i.']" style="width:200">';           
			echo '<option value="-1" selected>Seleccionar</option>';

			$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' and cod_subproducto in(1,2,3,5,6,7,9,10,12,13,14,15)";
            include("../principal/conectar_principal.php");
			$rs2 = mysqli_query($link, $consulta);
		   
			while($row2 = mysqli_fetch_array($rs2))						
			{			
			if ($row2['cod_subproducto'] == $cmbanodos)
				echo '<option value="'.$row2['cod_subproducto'].'" selected>'.$row2['descripcion'].'</option>';
			else 
				echo '<option value="'.$row2['cod_subproducto'].'">'.$row2['descripcion'].'</option>';
			}

			 echo"</select>";
			
			echo'</td>';
			echo'<td><div align="center"> 
			     <input name="lote_ventana['.$i.']" type="text" size="10" value="'.$lote_ventana.'"> 
			</div></td>';
			
			echo'<td><div align="center"> 
				<input name="hornada_vent['.$i.']" type="text" size="10" value="'.substr($hornada,6,6).'">
			</div></td>';
			
			echo'<td><div align="center"> 
				<input name="recargo['.$i.']" type="text" size="5" value="'.$recargo.'">
			</div></td>';
			
			echo'<td><div align="center"> 
				<input name="unidades['.$i.']" type="text" size="10" value="'.$unidades.'" onBlur="calcula_peso();">
 			    <input name="unidades_ant['.$i.']" type="hidden" size="5" value="'.$unidades.'">
			</div></td>';
			
			echo'<td><div align="center">
				<input name="peso['.$i.']" type="text" size="10" value="'.number_format($peso,0,'','').'">
 			    <input name="peso_ant['.$i.']" type="hidden" size="5" value="'.number_format($peso,0,'','').'">
			</div></td>';
			
			echo'<td><div align="center">
				<input name="lote_origen['.$i.']" type="text" size="10" value="'.$lote_origen.'">
			</div></td>';
			
			echo'<td><div align="center">
				<input name="marca['.$i.']" type="text" size="10" value="'.$marca.'">
			</div></td>
		  </tr>';

			echo'<input name="hornada['.$i.']" type="hidden" size="12" value="'.$hornada.'">';

	}	  


}
?>
        </table> 
		
		<br>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
