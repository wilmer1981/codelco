<?php  include("funciones.php");
$CodigoDeSistema = 2;
$CodigoDePantalla = 10;

if(isset($_REQUEST["mostrar"])) {
	$mostrar = $_REQUEST["mostrar"];
}else{
	$mostrar = "";
}
if(isset($_REQUEST["Hora"])) {
	$Hora = $_REQUEST["Hora"];
}else{
	$Hora = date("G");
}
if(isset($_REQUEST["Minutos"])) {
	$Minutos = $_REQUEST["Minutos"];
}else{
	$Minutos = date("i");
}
if(isset($_REQUEST["dia_p"])) {
	$dia_p = $_REQUEST["dia_p"];
}else{
	$dia_p = date("d");
}
if(isset($_REQUEST["mes_p"])) {
	$mes_p = $_REQUEST["mes_p"];
}else{
	$mes_p =  date("m");
}
if(isset($_REQUEST["ano_p"])) {
	$ano_p = $_REQUEST["ano_p"];
}else{
	$ano_p =  date("Y");
}

if(isset($_REQUEST["activa_fecha2"])) {
	$activa_fecha2 = $_REQUEST["activa_fecha2"];
}else{
	$activa_fecha2 = "";
}

if(isset($_REQUEST["dia_b"])) {
	$dia_b = $_REQUEST["dia_b"];
}else{
	$dia_b = date("d");
}
if(isset($_REQUEST["mes_b"])) {
	$mes_b = $_REQUEST["mes_b"];
}else{
	$mes_b =  date("m");
}
if(isset($_REQUEST["ano_b"])) {
	$ano_b = $_REQUEST["ano_b"];
}else{
	$ano_b =  date("Y");
}

if(isset($_REQUEST["cmblado"])) {
	$cmblado = $_REQUEST["cmblado"];
}else{
	$cmblado =  "";
}
if(isset($_REQUEST["cmbgrupo_d"])) {
	$cmbgrupo_d = $_REQUEST["cmbgrupo_d"];
}else{
	$cmbgrupo_d =  "";
}

if(isset($_REQUEST["hornada"])) {
	$hornada = $_REQUEST["hornada"];
}else{
	$hornada = "";
}
if(isset($_REQUEST["hornada_m"])) {
	$hornada_m = $_REQUEST["hornada_m"];
}else{
	$hornada_m = "";
}
if(isset($_REQUEST["cmbgrupo_o"])) {
	$cmbgrupo_o = $_REQUEST["cmbgrupo_o"];
}else{
	$cmbgrupo_o = "";
}
if(isset($_REQUEST["unidades"])) {
	$unidades = $_REQUEST["unidades"];
}else{
	$unidades = "";
}
if(isset($_REQUEST["peso"])) {
	$peso = $_REQUEST["peso"];
}else{
	$peso = "";
}

if(isset($_REQUEST["saldo_unidades"])) {
	$saldo_unidades = $_REQUEST["saldo_unidades"];
}else{
	$saldo_unidades = "";
}
if(isset($_REQUEST["subproducto"])) {
	$subproducto = $_REQUEST["subproducto"];
}else{
	$subproducto = "";
}
if(isset($_REQUEST["peso_unidad"])) {
	$peso_unidad = $_REQUEST["peso_unidad"];
}else{
	$peso_unidad = 0;
}
if(isset($_REQUEST["saldo_p"])) {
	$saldo_p = $_REQUEST["saldo_p"];
}else{
	$saldo_p = 0;
}

	$HoraAux=date('G');
	$MinAux=date('i');
	if($Hora=="")
	{
		if(intval($HoraAux)>=0&&intval($HoraAux)<8)
		{
			$Hora="07";
			$Minutos="59";
		}
		if(intval($HoraAux)>=8&&intval($HoraAux)<16)
		{
			$Hora="15";
			$Minutos="59";
		}
		if(intval($HoraAux)>=16&&intval($HoraAux)<=23)
		{
			$Hora="23";
			$Minutos="59";
		}
	}	

	include("../principal/conectar_sea_web.php");
    
	if ($mostrar == "S" && $hornada_m != '')	 
	{
			if(strlen($hornada_m) > 6)
				$hornada_m = substr($hornada_m,6,6);
				
			$consulta = "SELECT * FROM hornadas WHERE substring(hornada_ventana,7,6) = '".$hornada_m."' and cod_producto = 19 and cod_subproducto in('5','6','7','8','14')";
			$consulta = $consulta." order by hornada_ventana desc limit 0,1";
			//echo $consulta."<br>";
			$result = mysqli_query($link, $consulta);
			
				if ($row = mysqli_fetch_array($result))
				{
			        $consulta3 = "SELECT * FROM movimientos WHERE hornada = '".$row["hornada_ventana"]."' and cod_producto = 19 and 
					             cod_subproducto in('5','6','7','8','14') and tipo_movimiento = 3";
					//echo $consulta3."<br>";
					$result3 = mysqli_query($link, $consulta3);
					
                  	if($row3= mysqli_fetch_array($result3))
				   	{ 
						$fecha = $row3['fecha_movimiento'];
						$cmbgrupo_o = $row3['campo2'];
						$hornada = $row["hornada_ventana"];
						$subproducto = $row3['cod_subproducto'];
						$unidades = $row["unidades"];
						$peso = $row["peso_unidades"];
											
						$ano_p = substr($fecha,0,4);
						$mes_p = substr($fecha,5,2);
						$dia_p = substr($fecha,8,2);
						$peso_unidad=$peso/$unidades;
						$peso_unidad = number_format($peso_unidad,3,".",",");
					}					

 					$consulta = "SELECT SUM(unidades) AS unidadesmov FROM movimientos WHERE substring(hornada,7,6) = '".$hornada_m."' ";
   			        $consulta = $consulta." AND tipo_movimiento in(2,4) AND cod_producto = 19 and cod_subproducto in('5','6','7','8','14')";
					$rs2 = mysqli_query($link, $consulta);
					
			        
						if($row2 = mysqli_fetch_array($rs2))
						{	
						$saldo_unidades = ($row2["unidadesmov"] - $unidades)*-1; 
						//$saldo_p= (($peso_unidad * $row2["unidadesmov"]) - $peso)*-1;
						$saldo_p = PesoFaltante(19,$subproducto,$hornada,$link);
						   if($saldo_p < 0)
						      $saldo_p = 0;
						   if($saldo_unidades < 0)
						      $saldo_unidades=0;		 	  
						}					

				}
          
	}
	else
		$mostrar = "N";
	
	
?>

<html>
<head>
<title>Sistema de Anodos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function guardar_datos()
{
var f=formulario;
var subproducto= f.subproducto.value;
var hornada = f.hornada.value;
var valores;

    if (f.cmbgrupo_d.value == -1)
	{
	    alert ("Debe ingresar el Grupo");
		f.cmbgrupo_d.focus();
		return
	}	

    if (f.cmblado.value == -1)
	{
	    alert ("Debe ingresar el Lado");
		f.cmblado.focus();
		return
	}	

    if (f.unidad_beneficio.value == '')
	{
	    alert ("Debe ingresar la Unidad de Beneficio");
		f.unidad_beneficio.focus();
		return
	}	

    if (f.peso_beneficio.value == '')
	{
	    alert ("Debe ingresar el Peso de Beneficio");
		f.peso_beneficio.focus();
		return
	}	
	
    if (f.saldo_unidades.value == '')
	{
	    alert ("Debe ingresar el Saldo disponible de Unidades");
		f.saldo_unidades.focus();
		return
	}	
	if(f.Hora.value=='S')
	{
		alert("Debe Seleccionar Hora Valida");
		f.Hora.focus();
		return;
	}
	if(f.Minutos.value=='S')
	{
		alert("Debe Seleccionar Minutos Validos");
		f.Minutos.focus();
		return;
	}	
/*
    if (f.saldo_peso.value == 0)
	{
	    alert ("El Saldo No es Suficiente");
		f.saldo_peso.focus();
		return
	}	
*/	
	if (calcula(f) ==false)
		return;
	
	 valores = "&hornada=" + hornada + "&subproducto=" + subproducto; 
	 if (f.checkbox.checked == true)
	 	valores = valores + "&marcacheckbox=S";
	else
		valores = valores + "&marcacheckbox=N";
		
	 f.action = "sea_ing_restoshojas_nave01.php?proceso=G"+valores;
	 f.submit()  
	
}
/*****************************/
function ver_datos()
{
var f = formulario;

       	window.open("sea_ing_restoshojas03.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");

}


/***************************/
function consultar_datos()
{
var f = formulario;
var fecha_p;

	 fecha_p =  f.ano_p.value+"-"+f.mes_p.value+"-"+f.dia_p.value;
   	 window.open("sea_ing_restoshojas_nave02.php?fecha_p="+fecha_p, "","menubar=no resizable=no Top=50 Left=200 width=540 height=350 scrollbars=no");

}

/**************************/
function buscar_hornada()
{
var f = formulario;
var hornada = f.hornada_m.value;

      f.action = "sea_ing_restoshojas_nave.php?mostrar=S";
	  f.submit(); 
}

/****************************/
function carga_hornada()
{
var f = formulario;
     
      f.action = "sea_ing_restoshojas_nave.php";
	  f.submit();  
}


/**************************/
function calcula(f)
{
/*
  var peso_b;
  var saldo;
 
    if(f.unidad_beneficio.value > 42)
	{
	  alert("Unidades de Beneficio no pueden ser Mayor a 42");
	  f.unidad_beneficio.value = 0;
	  f.unidad_beneficio.focus();
	  return
	} 

	document.formulario.saldo_unidades.value = (f.stock_unidades.value - f.unidad_beneficio.value);
	peso_b = (f.unidad_beneficio.value * f.peso_unidad.value);
	saldo = (f.peso_unidad.value * f.saldo_unidades.value);


	document.formulario.peso_beneficio.value = Math.round(peso_b*1)/1;
	document.formulario.saldo_peso.value = Math.round(saldo*1)/1;
    
	if(document.formulario.saldo_unidades.value == 0)
	{
	   document.formulario.saldo_peso.value=0;
	}
	if(document.formulario.saldo_unidades.value < 0)
      {
	  document.formulario.unidad_beneficio.value="";	 
	  document.formulario.peso_beneficio.value=0;
	  document.formulario.saldo_unidades.value=f.stock_unidades.value;
  	  document.formulario.saldo_peso.value=f.peso.value;

	  alert("Unidades de Beneficio no pueden ser Mayor al Stock en Saldo");
	  f.unidad_beneficio.focus();
	  return
	  }
*/
	
	if ((isNaN(parseInt(f.unidad_beneficio.value))) || (parseInt(f.unidad_beneficio.value) < 1) || (parseInt(f.unidad_beneficio.value) > parseInt(f.stock_unidades.value)))	{
		alert("Unidades a Beneficiar No Son V�lidas");
		return false;
	}

    if(f.unidad_beneficio.value > 42)
	{
	  alert("Unidades de Beneficio no pueden ser Mayor a 42");
	  f.unidad_beneficio.focus();
	  return false;
	} 
				
	if (parseInt(f.unidad_beneficio.value) == parseInt(f.stock_unidades.value))
		document.formulario.peso_beneficio.value = f.peso.value;
	else
		document.formulario.peso_beneficio.value = Math.round(parseInt(f.unidad_beneficio.value) * f.peso_unidad.value);
	
	document.formulario.saldo_unidades.value = (f.stock_unidades.value - f.unidad_beneficio.value);
	document.formulario.saldo_peso.value = parseInt(f.peso.value) - parseInt(f.peso_beneficio.value);
	
	return true;
}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}	
/******************/
function Recarga5(f)
{
	if (f.checkbox.checked == true)	
	{
		parametros = "activa_fecha2=S&mostrar=S&hornada_m=" + f.hornada.value;
	
		f.action = "sea_ing_restoshojas_nave.php?" + parametros;
		f.submit();		
	}
	else
	{
		parametros = "activa_fecha2=N&mostrar=S&hornada_m=" + f.hornada.value;
		f.action = "sea_ing_restoshojas_nave.php?" + parametros;
		f.submit();
		//document.location = "sea_ing_restoshojas_nave.php?" + parametros;
	}
}
</script>


<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="middle"> <table width="95%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td width="27%"><strong>B&uacute;squeda de Beneficios</strong></td>
            <td width="73%"><font color="#000000">
              <input type="button" name="Ver" value="Ver Beneficiados" onClick="ver_datos();">
              </font></td>
          </tr>
        </table>
		<br>
        <table width="95%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td colspan="5"><strong>Datos Origen</strong></td>
          </tr>
          <tr> 
            <td>Hornada a Buscar</td>
            <td width="9%"> 
              	<?php
				if ($mostrar == "S")
				{
					echo '<input type="hidden" name="hornada" size="10" value="'.$hornada.'">';
					echo '<input type="text" name="hornada_m" size="10" value="'.substr($hornada,6,6).'">';
				}
				else
					echo '<input type="text" name="hornada_m" size="10"';
				?>
            </td>
            <td width="35%"><input name="consulta" type="button" style="width:70" onClick="buscar_hornada();" value="Buscar"></td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td><font color="#000000" size="2">Fecha Producci&oacute;n</font></td>
            <td colspan="2"> <select name="dia_p" size="1" style="font-face:verdana;font-size:10">
                <?php
						if($mostrar=='S')
						{
							for ($i=1;$i<=31;$i++)
							{
							if ($i==$dia_p)
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
              </select> <select name="mes_p" size="1" id="select4" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
					if ($mostrar=='S')
					{
					
						for($i=1;$i<13;$i++)
						{
							if ($i==$mes_p)
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
              </select> <select name="ano_p" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
					if($mostrar=='S')
					{
						for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
						{
							if ($i==$ano_p)
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
              <font size="1"><font size="2">
              </font></font> </td>
            <td colspan="2"><input name="consulta2" type="button" style="width:140" onClick="consultar_datos();" value="Buscar Hornadas"></td>
          </tr>
          <tr> 
            <td>Grupo</td>
            <td colspan="2"> 
              <?php
				if ($mostrar == "S")
					echo '<input type="text" name="cmbgrupo_o" size="4" value="Nº '.$cmbgrupo_o.'" Readonly>';
				else
					echo '<input type="text" name="cmbgrupo_o" size="4" Readonly>';
 		 ?>
            </td>
            <td width="12%">&nbsp;</td>
            <td width="17%">&nbsp; </td>
          </tr>
          <tr> 
            <td width="27%"><font color="#000000">Unidades Origen</font></td>
            <td colspan="2"> <font color="#000000"> 
              <?php
		if($mostrar=='S')
		echo"<input name='unidades_o' type='text' id='unidades_o' size='10' value='".$unidades."'>";
		else
		echo"<input name='unidades_o' type='text' id='unidades_o' size='10'>";
		?>
              </font></td>
            <td><font color="#000000">Peso Origen</font></td>
            <td> <font color="#000000"> 
              <?php
		if($mostrar=='S')
		echo"<input name='peso_o' type='text' id='peso_o' size='10' value='".$peso."'>";
		else
  		echo"<input name='peso_o' type='text' id='peso_o' size='10'>";
    	?>
            </td>
          </tr>
        </table>
      
	 <br> 
    <table width="95%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td colspan="7"><strong>Datos Destino</strong></td>
          </tr>
          <tr> 
            <td width="27%"><font color="#000000" size="2">Fecha Beneficio</font></td>
            <td width="43%"><font color="#000000" size="2"> 
              <select name="dia_b" size="1" style="font-face:verdana;font-size:10">
                <?php
						if($mostrar=='S')
						{
							for ($i=1;$i<=31;$i++)
							{
							if ($i==$dia_b)
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
              <select name="mes_b" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
					if ($mostrar=='S')
					{
						for($i=1;$i<13;$i++)
						{
							if ($i==$mes_b)
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
              <select name="ano_b" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
					if($mostrar=='S')
					{
						for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
						{
							if ($i==$ano_b)
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
               </font><font size="1"><font size="2">
               <select name="Hora">
                 <option value="S">S</option>
                 <?php
				for ($i=0;$i<=23;$i++)
				{
					if ($i<10)
						$Valor = "0".$i;
					else	$Valor = $i;
					if (isset($Hora))
					{	
						if ($Hora == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($HoraActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
               </select>
               <strong>:</strong>
               <select name="Minutos">
                 <option value="S">S</option>
                 <?php
				for ($i=0;$i<=59;$i++)
				{
				if ($i<10)
					$Valor = "0".$i;
				else
					$Valor = $i;
					if (isset($Minutos))
					{	
						if ($Minutos == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else	
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
					else
					{	
						if ($MinutoActual == $Valor)
							echo "<option selected value='".$Valor."'>".$Valor."</option>\n";
						else
							echo "<option value='".$Valor."'>".$Valor."</option>\n";		
					}
				}
				?>
               </select>
               </font></font></td>
            <td colspan="2">&nbsp; 
              <?php
		if ($mostrar == "S")	  
		{
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
			if ($activa_fecha2 == "S")
				echo '<input type="checkbox" name="checkbox" style="background:#FFFFCC" onClick="Recarga5(this.form)" checked>';
			else
				echo '<input type="checkbox" name="checkbox" style="background:#FFFFCC" onClick="Recarga5(this.form)">';			  
           	echo 'Descobrizacion';
				
			echo '<input name="marcacheckbox" type="hidden" value="'.$activa_fecha2.'">';
		}
		?>
            </td>
            <td width="15%" colspan="3"><font color="#000000">&nbsp;</font></td>
          </tr>
		<?php  
			if ($activa_fecha2 == "S")
			{
        		echo '<tr> ';
	            echo '<td>Fecha a Cual Agrupar</td>';
    	        echo '<td>';
				
				echo '<select name="dia2" size="1">';
				for ($i=1;$i<=31;$i++)
				{	
					if ($i == $dia2)
						echo "<option selected value= '".$i."'>".$i."</option>";				
					else if ($i == date("j"))
							echo "<option selected value= '".$i."'>".$i."</option>";											
					else					
						echo "<option value='".$i."'>".$i."</option>";												
				}		

             	echo '</select>';
              	echo '<select name="mes2" size="1">';

		 		for($i=1;$i<13;$i++)
			  	{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					else if ($i == $mes)
							echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
					else
						echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}		  

    			echo '</select>';
              	echo '<select name="ano2" size="1">';

				for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
				{
					if ($i == date("Y"))
						echo "<option selected value ='$i'>$i</option>";
					else if ($i == $ano2)
						echo "<option selected value ='$i'>$i</option>";
					else	
						echo "<option value='".$i."'>".$i."</option>";
				}

              	echo '</select>';
				echo '</td>';
				echo '<td></td>';				
        	  	echo '</tr>';
			}
		?>			
          <tr> 
            <td><font color="#000000" size="2">Grupo</font></td>
            <td> <font color="#000000"> 
              <select name="cmbgrupo_d">
                <?php
			include("../principal/conectar_principal.php");
			echo '<option value="-1">Grupo</option>';
			$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2004 ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				if (($mostrar == "S") and ($row["cod_subclase"] == $cmbgrupo_d))
					echo '<option value="'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
				else
					echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}
		?>
              </select>
              </font></td>
            <td colspan="2"><font color="#000000" size="2">Lado</font></td>
            <td colspan="3"> <font color="#000000"> 
              <select name="cmblado" id="select2">
                <?php
	  		if ($mostrar == "S") 
			{		
				if ($cmblado == "-1")
					echo '<option value="-1" selected>Lado</option>';
				else 
					echo '<option value="-1">Lado</option>';
				if ($cmblado == "M")
    	    		echo '<option value="M" selected>MAR</option>';
				else
					echo '<option value="M">MAR</option>';	
				if ($cmblado == "T")
					echo  '<option value="T" selected>TIERRA</option>';
				else
					echo  '<option value="T">TIERRA</option>';
				if ($cmblado == "N")
					echo  '<option value="T" selected>NORTE</option>';
				else
					echo  '<option value="T">NORTE</option>';
					
				if ($cmblado == "S")
					echo  '<option value="T" selected>SUR</option>';
				else
					echo  '<option value="T">SUR</option>';
	
	
					
			}
			else 
			{
				echo '<option value="-1">Lado</option>';
				echo '<option value="M">MAR</option>';
				echo  '<option value="T">TIERRA</option>';
				echo  '<option value="N">NORTE</option>';
				echo  '<option value="S">SUR</option>';

			}
		?>
              </select>
              </font></td>
          </tr>
          <tr> 
            <td><font color="#000000" size="2">Unidad Beneficio</font></td>
            <td> <font color="#000000"> 
              <?php
		if($mostrar=='S')
		echo "<input name='unidad_beneficio' type='text' id='unidad_beneficio' size='10' value='' onBlur='calcula(this.form)'>";
		else
		echo "<input name='unidad_beneficio' type='text' id='unidad_beneficio' size='10' Readonly>";
		?>
              </font></td>
            <td colspan="2"><font color="#000000" size="2">Peso Beneficio</font></td>
            <td colspan="3"> <font color="#000000"> 
              <?php
		if($mostrar=='S')
		echo "<input name='peso_beneficio' type='text' id='peso_beneficio' size='10' value=''>";
		else
		echo "<input name='peso_beneficio' type='text' id='peso_beneficio' size='10' Readonly>";
		?>
              </font></td>
          </tr>
        </table>
	<br>
        <table width="95%" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td colspan="6"><strong>Saldos</strong></td>
          </tr>
          <tr> 
            <td width="27%">Saldo Unidades</td>
            <td width="43%"><font color="#000000"> 
              <?php
		if($mostrar=='S')
		{
		echo "<input name='stock_unidades' type='hidden' id='stock_unidades' size='10' value='".$saldo_unidades."'>";
		echo "<input name='saldo_unidades' type='text' id='saldo_unidades' size='10' value='".$saldo_unidades."' Readonly>";
		}
		else
		echo "<input name='saldo_unidades' type='text' id='saldo_unidades' size='10' Readonly>";
		?>
              </font></td>
            <td width="18%">Saldo Peso</td>
            <td width="12%" colspan="3"><font color="#000000"> 
              <?php
		if($mostrar=='S')
		{
		echo '<input name="subproducto" type="hidden" value="'.$subproducto.'" size="10" >';
		echo '<input name="peso_unidad" type="hidden" value="'.$peso_unidad.'" size="10" >';
		echo '<input name="peso" type="hidden" value="'.number_format($saldo_p,0,"","").'" size="10" >';
		echo '<input name="saldo_peso" type="text" value="'.number_format($saldo_p,0,"","").'" size="10" Readonly>';
		}
		else
			echo "<input name='saldo_peso' type='text' size='10' Readonly>";
		?>
              </font></td>
          </tr>
          <tr> 
            <td><div align="center"><font color="#000000"> </font></div></td>
            <td><div align="right"><font color="#000000"> 
                <input name="guardar" type="button" style="width:70" onClick="JavaScript:guardar_datos(this.form)" value="Guardar">
				<!--<input name="ver datos" type="button" style="width=115" onClick="JavaScript:Ver_Datos(this.form)" value="Ver Datos">-->
                <input name="salir" type="button" style="width:70" onClick="salir_menu()" value="Salir">
                </font></div></td>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table> 
	</td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
