<?php

$CodigoDeSistema = 2;
$CodigoDePantalla = 11;

$CookieRut = $_COOKIE["CookieRut"];

if(isset($_REQUEST["checkbox"])) {
	$checkbox = $_REQUEST["checkbox"];
}else{
	$checkbox = "";
}
if(isset($_REQUEST["cmbhornos"])) {
	$cmbhornos = $_REQUEST["cmbhornos"];
}else{
	$cmbhornos = "";
}
if(isset($_REQUEST["generar_h"])) {
	$generar_h = $_REQUEST["generar_h"];
}else{
	$generar_h = "";
}

if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano = "";
}
if(isset($_REQUEST["mes"])) {
	$mes= $_REQUEST["mes"];
}else{
	$mes = "";
}
if(isset($_REQUEST["dia"])) {
	$dia= $_REQUEST["dia"];
}else{
	$dia = "";
}
if(isset($_REQUEST["Color"])) {
	$Color= $_REQUEST["Color"];
}else{
	$Color = "";
}

if(isset($_REQUEST['cmbhornos'])){
	$num_hornada=$_REQUEST['cmbhornos'];
 }else{
	$num_hornada=0;
 }


 

$Hora=date('G');
$Min=date('i');

if(!isset($hora))
{
	if(intval($Hora)>=0 && intval($Hora)<8)
	{
		$hora="07";
		$minuto="59";
	}
	if(intval($Hora)>=8 && intval($Hora)<16)
	{
		$hora="15";
		$minuto="59";
	}
	if(intval($Hora)>=16 && intval($Hora)<=23)
	{
		$hora="23";
		$minuto="59";
	}
}	

function ObtenerNroHornada($horno, $link)
{
	$ValorHornadaSecuencia=0;
	$consulta = "SELECT valor_subclase3 as NroHornada FROM proyecto_modernizacion.sub_clase WHERE  cod_clase = '2006' and cod_subclase='".$horno."'";
	$rs = mysqli_query($link, $consulta); 
	if($row = mysqli_fetch_array($rs))
	{
		$ValorHornadaSecuencia=$row["NroHornada"];
	}
	return $ValorHornadaSecuencia;
}

//Verifica Usuario para Reinicio de Hornada
if($checkbox == "on")
{
	$consulta ="SELECT * FROM sistemas_por_usuario WHERE rut = '".$CookieRut."'";
	include("../principal/conectar_principal.php"); 
	$rs = mysqli_query($link, $consulta); 
	if($row = mysqli_fetch_array($rs))
	{
		if($row["nivel"] != 1)
		{
		 echo'<script>
		      alert("No tiene Permiso para Realizar esta Operaci�n");
			  JavaScript:window.location = "sea_ing_prod_vent.php";
			  </script>';
		}
		else
		{
			
			$actualizar = "UPDATE proyecto_modernizacion.sub_clase SET valor_subclase3=valor_subclase2 WHERE  cod_clase = '2006' and cod_subclase='".$cmbhornos."'";
			mysqli_query($link, $actualizar);

		}
	}

}
/******************** -- GENERA HORNADA -- ********************************************/
  if($generar_h=='S')
  { 
  	    include("../principal/conectar_principal.php"); 

		$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2005 and cod_subclase=4";
		//echo $consulta;
		$rs = mysqli_query($link, $consulta);
  		   if($row = mysqli_fetch_array($rs))
		   {
		    $horno1=$row['valor_subclase1'];
		    $horno2=$row['valor_subclase2'];
		    $horno3=$row['valor_subclase3'];
			
			$fecha = $ano."-".$mes."-".$dia;

			if (strlen($mes) == 1)
			$mes = "0".$mes;
			
			$horno1 = $ano.$mes.$horno1;
			$horno2 = $ano.$mes.$horno2;
			$horno3 = $ano.$mes.$horno3;
			
          }

         include("../principal/conectar_sea_web.php"); 
		
		 
		 //if(isset($_REQUEST['cmbhornos'])){
			$num_hornada=ObtenerNroHornada($cmbhornos, $link);
		// }else{
		//	$num_hornada=0;
		 //}
		
		/*
		 $consulta = "Select MAX(hornada_ventana) AS hornada_max FROM hornadas WHERE cod_producto=17 AND cod_subproducto IN (4,8,11) AND right(hornada_ventana,4) like '4%'";
		 $consulta.=" and left(hornada_ventana,4) = '".$ano."'";
	
		 $consulta="SELECT valor_subclase2 FROM proyecto_modernizacion.sub_clase WHERE cod_clase = '2006' AND cod_subclase = '".$cmbhornos."' ";
		 
		 
		  if($cmbhornos == 4)
		  {
		 	//$cmbhornos4 = $cmbhornos."0"; //se coloca por inicio de hornada despues de mantencion
			
			$consulta = "Select MAX(hornada_ventana) AS hornada_max FROM hornadas WHERE cod_producto=17 AND cod_subproducto IN (4,8,11) AND right(hornada_ventana,4) like '4%'";
			$consulta.=" and left(hornada_ventana,4) = '".$ano."'";
			
		
		 }
		 else
		 {
		 	$consulta = "Select MAX(hornada_ventana) AS hornada_max FROM hornadas WHERE cod_producto=17 AND cod_subproducto IN (4,8,11) AND right(hornada_ventana,4) LIKE '$cmbhornos%'";
		  }
		  //echo $consulta;	
		 $rs= mysqli_query($link, $consulta);

		  if($row = mysqli_fetch_array($rs))
		  {	
			
				if($cmbhornos == 1)
				{
					 if (is_null($row[hornada_max]))			  
					   $num_hornada = substr($horno1,6,6); 	
					 elseif($checkbox == on)
					   $num_hornada = substr($horno1,6,6);
					 else
					   $num_hornada = substr($row[hornada_max]+1,6,6);
				}
	
				if($cmbhornos == 2)
				{
					 if (is_null($row[hornada_max]))			  
					   $num_hornada = substr($horno2,6,6); 	
					 elseif($checkbox == on)
					   $num_hornada = substr($horno2,6,6);
					 else  
					   $num_hornada = substr($row[hornada_max]+1,6,6);
					   
				}
	
				if($cmbhornos == 4)
				{
					 if (is_null($row[hornada_max]))			  
					   $num_hornada = substr($horno3,6,6); 	
					 elseif($checkbox == on)
					   $num_hornada = substr($horno3,6,6);
					 else  
					   $num_hornada = substr($row[hornada_max]+1,6,6);
					 
				}

		 } 	
*/

   }	     
	/* Se comenta deacuerdo a solicitud enviada 14-10-2020
	if ($num_hornada==4000)
	{
		$num_hornada = 4001;
	}
	*/
  


?>

<html>
<head>
<title>Producci�n de �nodos Ventana</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript">

function guardar_datos()
{
	var f = formulario;      
    var valido = ""; 
	    if (f.num_hornada.value =='' )
        {
                alert ("Debe Ingresar N�mero de Hornada");
                f.num_hornada.focus();
                return
        }
		 if (f.cmbhornos.value =='-1' )
        {
                alert ("Debe Ingresar N�mero de Hornos");
                f.cmbhornos.focus();
                return
        }
	//var largo2 = f.mes.value.length;
	//if (largo2==1)
	//	var mesn = "0"+f.mes.value;
	//f.mes.value = mesn;
	//valido = f.ano.value+""+f.mes.value+""+f.num_hornada.value;
	//if (valido.length < 8)
	//{
	//	alert ("Revise numeracion de hornada " + valido)
	//	return;
     //} 
	    if (f.hora.value =='' || f.hora.value == 0)
        {
                alert ("Debe ingresar Hora ");
         
                return
        }

	   	    if (f.minuto.value =='')
        {
                alert ("Debe ingresar Minutos ");
            
                return
        }

	   
	    if (f.uni_hornada.value =='' || f.uni_hornada.value == 0)
        {
                alert ("Debe Ingresar Unidades de la Hornada");
               // f.uni_hornada.focus();
                return
        }

        if (f.peso_hornada.value =='' || f.peso_hornada.value == 0)
        {
                alert ("Debe ingresar el Peso de Hornada");
              //  f.peso_hornada.focus();
                return
        }



		/*if ((f.uni_rechazo_hm.value * 1) > (f.uni_hojas_madres.value * 1))
		{
			alert("Unidades Rechazadas HM no pueden ser mayor que unidades produci�n");
				return
		}			 

		if ((f.peso_rechazo_hm.value * 1) > (f.peso_hojas_madres.value * 1))
		{
			alert("Peso Rechazado HM no pueden ser mayor que peso produci�n");
				return
		}			 

		if ((f.uni_rechazo_cte.value * 1) > (f.uni_corrientes.value * 1))
		{
			alert("Unidades Rechazado CTE no pueden ser mayor que peso produci�n");
				return
		}			 


        if ((f.peso_rechazo_cte.value * 1) > (f.peso_corrientes.value * 1))
		{
			alert("Peso Rechazado CTE no pueden ser mayor que peso produci�n");
				return
		}			 */

		f.action="sea_ing_prod_vent01.php?proceso=G";
        f.submit();
  		
}
function TeclaPulsada1(salto) 
{ 
	var f = formulario;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}
function valida_hora()
{
	var f = formulario;
		
	var largo = f.hora.value.length;
		if (largo == 1)
			f.hora.value = "0"+f.hora.value;

	
	
}

function valida_minuto()
{
		var f = formulario;
		
		var largo1 = f.minuto.value.length;
		if (largo1 == 1)
			f.minuto.value = "0"+f.minuto.value;

	
}

function ver_datos()
{
var f = formulario;

       	window.open("sea_ing_prod_vent02.php", "","menubar=no resizable=no Top=50 Left=200 width=520 height=500 scrollbars=no");

}

/************************/
function generar_hornada(f)
{    
	 if(f.checkbox.checked == true)	 
	 {
	   if(f.cmbhornos.value == -1)
	   {
          alert("Debe Escoger un Horno Antes");
		  f.cmbhornos.focus();
		  return
		  
	   }	 
	   if(confirm("Reiniciar� La Hornada �Desea Continuar?"))
	   {
	   	 f.action="sea_ing_prod_vent.php?generar_h=S";
	   	 f.submit();
	   }	   
	   else
	   {
	     f.checkbox.checked = false 
	     return	
	   }	 
	 }
	 
	 if(f.cmbhornos.value != -1)
	 {
	   f.action="sea_ing_prod_vent.php?generar_h=S";
	   f.submit();
	 } 
	 else
	 {
	    f.num_hornada.value='';
	 }
}

/***************************/
function TeclaPulsada2(valor) 
{ 
	var f = formulario;
	var teclaCodigo = event.keyCode; 
	switch (valor)
	{
		case 'HM':
			var pesohm =  (f.peso_hojas_madres.value * 1);
			var unidhm =  (f.uni_hojas_madres.value * 1);
			var unirechhm = (f.uni_rechazo_hm.value * 1);
			f.peso_rechazo_hm.value = 0;
			f.peso_rechazo_hm.value = parseInt((pesohm / unidhm) * unirechhm);
			suma_unidad();
			f.uni_corrientes.focus();
			break;
		case 'AC':
			var pesocte = (f.peso_corrientes.value * 1);
			var unidcte = (f.uni_corrientes.value * 1);
			var unirechcte = (f.uni_rechazo_cte.value * 1);
			f.peso_rechazo_cte.value = 0;
			f.peso_rechazo_cte.value = parseInt((pesocte / unidcte) * unirechcte);
			suma_unidad();
			f.guardar.focus();
			break;
	}				
}

function suma_unidad(f)
{
var total_unidades=0;
var total_peso=0;

 total_unidades=(formulario.uni_hojas_madres.value * 1) + (formulario.uni_rechazo_hm.value * 1) + (formulario.uni_corrientes.value * 1) + (formulario.uni_rechazo_cte.value * 1); 
 total_peso=(formulario.peso_hojas_madres.value * 1) + (formulario.peso_rechazo_hm.value * 1) + (formulario.peso_corrientes.value * 1) + (formulario.peso_rechazo_cte.value * 1);
 
 document.formulario.uni_hornada.value=total_unidades;
 document.formulario.peso_hornada.value=total_peso;

}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}

function valida()
{
	var f=formulario;
	var malo = 0;
	if (f.cmbhornos.value == 1)
	{

	    if (f.num_hornada.value < 1000 || f.num_hornada.value > 1999)
		{   
			malo = 1;
			alert("Esta Fuera del Rango del Horno"); 
		   	f.num_hornada.focus();
		   	f.action="sea_ing_prod_vent.php?generar_h=S";
		   	f.submit();
		}   		    

    } 

	if (f.cmbhornos.value == 2)
	{
	    if (f.num_hornada.value < 2000 || f.num_hornada.value > 3999)
		{   
			malo = 1;
		   	alert("Esta Fuera del Rango del Horno"); 
		   	f.num_hornada.focus();
		   	f.action="sea_ing_prod_vent.php?generar_h=S";
		   	f.submit();
		}   		    

    } 

	if (f.cmbhornos.value == 4 || f.cmbhornos.value == 3)
	{
	    if (f.num_hornada.value < 4000 || f.num_hornada.value > 4999)
		{   
			malo = 1;
		   	alert("Esta Fuera del Rango del Horno"); 
		   	f.num_hornada.focus();
		   	f.action="sea_ing_prod_vent.php?generar_h=S";
		   	f.submit();
		}   		    

    } 
	if (malo==1)
	{
		alert("hornada fuera de Rango, reingrese");
		f.num.hornada.focus();
		f.action="sea_ing_prod_vent.php?generar_h=S";
		f.submit();
	}
	else
	{
		f.action="sea_ing_prod_vent.php?Color=S";
		f.submit();
	}
	
}

</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>

<body>
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="top" >
    <table width="100%" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td width="32%">Fecha Producci&oacute;n</td>
            <td colspan="3"><font color="#000000" size="2"> 
              <SELECT name="dia" size="1" style="font-face:verdana;font-size:10">
                <?php
			if($generar_h=='S' || $Color == 'S')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
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
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
              </SELECT>
              </font> <font color="#000000" size="2"> 
              <SELECT name="mes" size="1" id="SELECT7" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($generar_h=='S' || $Color == 'S')
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
              <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
	if($generar_h=='S' || $Color == 'S')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano)
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
              <input name='ver' type='button' style="width:80" value='Ver Datos' onClick='ver_datos();'>
</font></td>
            <td width="22%"> 
              <?php
			if($checkbox == "on")
				echo '<input type="checkbox" name="checkbox" onClick="generar_hornada(this.form)" checked>';
			else
				echo '<input type="checkbox" name="checkbox" onClick="generar_hornada(this.form)">';
            
			?>
              Reiniciar Hornada</td>
          </tr>
          <tr class="boxcontent"> 
            <td><font color="#000000">Hornos</font></td>
            <td><font color="#000000"> 
              <SELECT name="cmbhornos" id="cmbhornos" onChange="generar_hornada(this.form)">
                <?php
            
				include("../principal/conectar_principal.php");
				echo '<option value="-1">SELECCIONAR</option>';
				$consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2006 ORDER BY cod_subclase";
				
				$rs = mysqli_query($link, $consulta);
		
					while ($row = mysqli_fetch_array($rs))
					{
						if ($row["cod_subclase"] == $cmbhornos)	
							echo '<option value="'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
							else 
								echo '<option value="'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
					
					}

           					
				?>
              </SELECT>
              </font></td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr class="boxcontent"> 
            <td><font color="#000000">N&uacute;mero de Hornada</font></td>
            <td width="18%"> <font color="#000000"> 
        <?php 
		if($generar_h=='S' || $Color == 'S'){
			echo "<input name='num_hornada' type='text' id='num_hornada' size='10'  value='".$num_hornada."'  onBlur='valida();'>";
		}else{
			echo "<input name='num_hornada' type='text' id='num_hornada' size='10'  value='0' disabled onBlur='valida();'>";
		}

		?>
</font><font size="2">&nbsp;
</font><font color="#000000">&nbsp;              </font></td>
            <td width="8%">Colores </td>
            <td width="20%">
              <?php
			    $colores="";
			    if(($num_hornada != '' && $num_hornada != 0 ) || $generar_h=='S' || $Color=='S')
				{
				   $num1 = substr($num_hornada,0,1);
				   $num2 = substr($num_hornada,2,1);
				   $num3 = substr($num_hornada,3,1);
				   
   				   $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2011 AND cod_subclase = '".$num3."' ";
			  	   include("../principal/conectar_principal.php"); 
				   $rs = mysqli_query($link, $consulta);
				
				   if(strlen($num_hornada) == 4)
				   {

					   if($row = mysqli_fetch_array($rs))
					   {
						   $colores = $row["valor_subclase1"].' '. $colores;	
					   }
				   }
   				   
				   $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2011 AND cod_subclase = '".$num2."' ";
			  	   include("../principal/conectar_principal.php"); 
				   $rs = mysqli_query($link, $consulta);
				   
				   if(strlen($num_hornada) == 4)
				   {
					   if($row = mysqli_fetch_array($rs))
					   {
						   $colores = $row["valor_subclase1"] .' '. $colores;	
					   }
				   }	
   				   
				   $consulta = "SELECT * FROM sub_clase WHERE cod_clase = 2011 AND cod_subclase = '".$num1."' ";
			  	   include("../principal/conectar_principal.php"); 
				   $rs = mysqli_query($link, $consulta);
				   
				   if(strlen($num_hornada) == 4)
				   {
					   if($row = mysqli_fetch_array($rs))
					   {
						   $colores = $row["valor_subclase1"] .' '. $colores;	
					   }
				   }					    
				}  
				echo "<input name='colores' type='text' size='10' value='$colores' disabled>"; 

			?>
            </td>
            <td><font color="#000000">
              Hora :
		<input type="text" name="hora" size="3" onKeyDown="TeclaPulsada1('minuto')" value="<?php echo $hora;?>" onBlur="valida_hora(this.form)" >
Minu.:
<input type="text" name="minuto" size="3" onKeyDown="TeclaPulsada1('uni_hojas_madres')" value="<?php echo $minuto;?>" onBlur="valida_minuto(this.form)"  >
</font></td>
          </tr>
        </table>
	  <br>
	  
    <table width="100%" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
      <tr class="ColorTabla01"> 
            <td colspan="2"><div align="center">Unidades</div></td>
            <td colspan="2"><div align="center">Peso</div></td>
          </tr>
          <tr> 
            <td width="32%"><font size="2">Unidades de Hojas Madres</font></td>
            <td width="18%"> <font size="2">
            <input name='uni_hojas_madres' type='text' id='uni_hojas_madres' size='10' onKeyDown="TeclaPulsada1('peso_hojas_madres')"  onBlur='suma_unidad(this.form);'>
			</font></td>
            <td><font size="2">Peso Hojas Madres</font></td>
            <td width="26%" colspan="-1"> <input name='peso_hojas_madres' type='text' id='peso_hojas_madres' size='10' onKeyDown="TeclaPulsada1('uni_rechazo_hm')"  onBlur='suma_unidad(this.form);'> 
            </td>
          </tr>
          <tr> 
            <td>Unidades Rechazo Hoja Madres </td>
            <td> <font size="2"> 
            <?php //echo  '<input name='uni_rechazo_hm' type='text' id='uni_rechazo_hm' size='10'onKeyDown="TeclaPulsada1('peso_rechazo_hm')"  onBlur='suma_unidad(this.form);'>'; ?>
              <input name='uni_rechazo_hm' type='text' id='uni_rechazo_hm' size='10' onChange="TeclaPulsada2('HM')"  onBlur='suma_unidad(this.form);'>
              </font></td>
            <td><font size="2">Peso Rechazo Hoja Madres </font></td>
            <?php //echo '<td> <input name='peso_rechazo_hm' type='text' id='peso_rechazo_hm' size='10' onKeyDown="TeclaPulsada1('uni_corrientes')" onBlur='suma_unidad(this.form);'>'; ?> 
            <td> <input name='peso_rechazo_hm' type='text' id='peso_rechazo_hm' size='10' > 
            </td>
          </tr>
          <tr> 
            <td><font size="2">Unidades Corrientes </font></td>
            <td> <font size="2"> 
              <input name='uni_corrientes' type='text' id='uni_corrientes' size='10' onKeyDown="TeclaPulsada1('peso_corrientes')" onBlur='suma_unidad(this.form);'>
              </font></td>
            <td><font size="2">Peso Corrientes</font></td>
            <td colspan="-1"> <input name='peso_corrientes' type='text' id='peso_corrientes' size='10' onKeyDown="TeclaPulsada1('uni_rechazo_cte')" onBlur='suma_unidad(this.form);'> 
            </td>
          </tr>
		  <tr> 
            <td><font size="2">Unidades Rechazo Corrientes </font></td>
            <td> <font size="2"> 
              <input name='uni_rechazo_cte' type='text' id='uni_rechazo_cte' size='10' onChange="TeclaPulsada2('AC')" onBlur='suma_unidad(this.form);'>
              </font></td>
            <td><font size="2">Peso Rechazo Corrientes </font></td>
            <td colspan="-1"> <input name='peso_rechazo_cte' type='text' id='peso_rechazo_cte' size='10'> 
            </td>
          </tr>
          <tr> 
            <td><font size="2"><strong>Unidades Total Hornada</strong></font></td>
            <td> <font size="2"> 
              <input name='uni_hornada' type='text' id='uni_hornada' size='10'>
              </font></td>
            <td><font size="2"><strong>Peso Total Hornada</strong></font></td>
            <td colspan="-1"><input name='peso_hornada' type='text' id='peso_hornada' size='10'></td>
          </tr>
          <tr> 
            <td colspan="4"><div align="center"> 
            <input name='guardar' type='button' style="width:70" value='Guardar' onClick='guardar_datos();'>

            <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div></td>
          </tr>
        </table>    </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
