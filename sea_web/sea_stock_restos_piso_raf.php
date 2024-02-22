<?php 
$CodigoDeSistema = 2;
$CodigoDePantalla = 32;

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = "";
}

if(isset($_REQUEST["Mensaje"])) {
	$Mensaje = $_REQUEST["Mensaje"];
}else{
	$Mensaje = "";
}
if(isset($_REQUEST["tipo"])) {
	$tipo = $_REQUEST["tipo"];
}else{
	$tipo = "";
}
if(isset($_REQUEST["fecha"])) {
	$fecha = $_REQUEST["fecha"];
}else{
	$fecha = "";
}
if(isset($_REQUEST["cmbgrupo"])) {
	$cmbgrupo = $_REQUEST["cmbgrupo"];
}else{
	$cmbgrupo = "";
}


if(isset($_REQUEST["dia2"])) {
	$dia2 = $_REQUEST["dia2"];
}else{
	$dia2 = date("d");
}
if(isset($_REQUEST["mes2"])) {
	$mes2 = $_REQUEST["mes2"];
}else{
	$mes2 =  date("m");
}
if(isset($_REQUEST["ano2"])) {
	$ano2 = $_REQUEST["ano2"];
}else{
	$ano2 =  date("Y");
}


if(isset($_REQUEST["dia"])) {
	$dia = $_REQUEST["dia"];
}else{
	$dia = date("d");
}
if(isset($_REQUEST["mes"])) {
	$mes = $_REQUEST["mes"];
}else{
	$mes =  date("m");
}
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano =  date("Y");
}
if(isset($_REQUEST["Encontrado"])) {
	$Encontrado = $_REQUEST["Encontrado"];
}else{
	$Encontrado =  "";
}
if(isset($_REQUEST["Encontrado2"])) {
	$Encontrado2 = $_REQUEST["Encontrado2"];
}else{
	$Encontrado2 =  "";
}


 /* if($Mensaje == 1)
  {
  	echo "<Script>
	alert('Datos Guardados');  
	</Script>"; 	
  }*/

  if($Mensaje == 2)
  {
  	echo "<Script>
	alert('Datos Modificados');  
	</Script>"; 	
  }

  include("../principal/conectar_sea_web.php");
?>
<html>
<head>
<title>Stock Anodos en piso de Raf</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function valida_valores()
{
var f = formulario;
var valores_hornada="", valores_unidades="", valores_peso="", valores_subproducto="", valores="";
var LargoForm = f.elements.length;

	
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'subproducto')		
		{
			valores_subproducto = valores_subproducto + f.elements[i].value +"/";
		}
	}
	
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'hornada')		
		{
			valores_hornada = valores_hornada + f.elements[i].value +"/";
		}
	}
	
/*	
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'porcent_unidades')		
		{
			valores_unidades = valores_unidades + f.elements[i].value +"/";
		}
	}
	
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'porcent_peso')		
		{
			valores_peso = valores_peso + f.elements[i].value +"/";
		}
	}*/

	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'peso_t')		
		{
			valores_peso = valores_peso + f.elements[i].value +"/";
		}
	}
	
	valores = "unidades=" + f.unidades.value + "&valores_unidades=" + valores_unidades + "&valores_peso=" + valores_peso + "&valores_hornada=" + valores_hornada + "&valores_subproducto=" + valores_subproducto;
	return valores;


}

/*************************/
function guardar_datos()
{
var f = formulario;   
var valores = valida_valores();
var valor_unid;

   if (f.unidades.value == 0 || f.unidades.value == '')
   {  
      alert("Debe ingresar Unidades");
      f.unidades.focus();
      return
   }
   else
   {

	  valor_unid = "unidades=" + f.unidades.value;
      f.action="sea_stock_restos_piso_raf01.php?Proceso=G&"+valor_unid; 
      f.submit();
   }		
}

/************************/
function modificar_datos()
{
var f = formulario;   
var valores = valida_valores();

   if (f.peso.value == 0 || f.peso.value == '')
   {  
      alert("Debe ingresar el Peso");
      f.peso.focus();
      return
   }
   else
   {
      f.action="sea_stock_restos_piso_raf01.php?Proceso=M&"+valores; 
      f.submit();
   }		
}
/******************/
function eliminar_datos()
{
var f = formulario;   
var valores = valida_valores();

	if (confirm("Esta seguro de Eliminar el Movimiento")) 
	{
      f.action="sea_stock_restos_piso_raf01.php?Proceso=E&"+valores; 
      f.submit();
 	}		
}

/**********/
function buscar_grupos()
{
var f = formulario;   
var fecha;

	fecha =  f.ano.value+"-"+f.mes.value+"-"+f.dia.value;
	
	f.action="sea_stock_restos_piso_raf.php?tipo=T&Proceso=B&fecha="+fecha;
	f.submit();
  		
}
/*******************/
function BuscarGrupos2(f)
{
	f.action="sea_stock_restos_piso_raf.php?tipo=P&Proceso=B&fecha=" + f.ano2.value + "-" + f.mes2.value + "-" + f.dia2.value;
	f.submit();	
}

/***************/
function Ver_Stock()
{
var f = formulario;   

f.action="sea_lst_stock_piso.php?Proceso=V&";
f.submit();
  		
}


/***********/
function recargar_datos(f)
{
var LargoForm = f.elements.length;
var hornada;

	if (f.tipo2.value == "P")
		fecha = f.ano2.value + "-" + f.mes2.value + "-" + f.dia2.value;
	else
		fecha = f.ano.value + "-" + f.mes.value + "-" + f.dia.value;

	arreglo = f.cmbgrupo.value.split('/');
	
   	f.action="sea_stock_restos_piso_raf.php?Proceso=R&tipo=" + f.tipo2.value + "&fecha=" + fecha + "&fecha_traspaso=" + arreglo[0];
    f.submit();
		
}

function calcula()
{
var f=formulario;
var porcentaje_peso;     
var porcentaje_unidades;
    
   porcentaje_peso = f.peso.value * 100 / f.peso_t.value;

   porcentaje_unidades = f.unidades_t.value * porcentaje_peso / 100;
   
   f.unidades.value = Math.round(porcentaje_unidades * 1)/1;

 //f.peso.value = Math.round((f.unidades.value * f.peso_promedio.value)*1)/1;

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
  
  <?php
	echo '<input name="tipo2" type="hidden" value="'.$tipo.'">';
  ?>

  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="776" align="center" valign="top" >
    <table width="95%" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr>
            <td height="40">Fecha de Piso RAF</td>
            <td><font color="#000000" size="2">
			<?php
				echo '<input name="dia2" type="hidden" value="1">';
			?>
			
              <SELECT name="mes2">
       <?php
       $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B' || $Proceso =='R')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes2)
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
              </font><font color="#000000"> 
              <SELECT name="ano2">
                <?php
	if($Proceso=='B' || $Proceso =='R')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano2)
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
              </font></td>
            <td><font color="#000000">
              <input name="buscar3" type="button" style="width:70" value="Buscar" onClick="BuscarGrupos2(this.form);">
              </font></td>
            <td width="289"><font color="#000000">
              <input name="buscar2" type="button" style="width:120" value="Ver Stock en Piso" onClick="Ver_Stock();">
              </font></td>
          </tr>
          <tr> 
            <td height="30">Fecha<font color="#000000" size="2">&nbsp; Traspaso</font></td>
            <td><font color="#000000" size="2"> 
              <SELECT name="dia" size="1" style="font-face:verdana;font-size:10">
                <?php
		if ($Proceso=='B' || $Proceso =='R')
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
              </font><font color="#000000" size="2"> 
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
              </font><font color="#000000"> 
              <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
	if($Proceso=='B' || $Proceso =='R')
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
              </font><font color="#000000" size="2">&nbsp;</font></td>
            <td><font color="#000000"> 
              <input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_grupos();">
              </font></td>
            <td><font color="#000000">&nbsp; </font></td>
          </tr>
          <tr> 
            <td width="116" height="30"><font color="#000000">Grupo</font></td>
            <td width="204"><font color="#000000" size="2"> 
              <?php
			
			
			//$fecha = $ano.'-'.$mes.'-'.$dia;
			echo'<SELECT name="cmbgrupo" onChange="recargar_datos(this.form);">';
			echo '<option value="-1">Grupo</option>';
	
			//$consulta = "SELECT distinct campo2 FROM movimientos where fecha_movimiento = '$fecha' AND tipo_movimiento = 4 AND campo2 != ''";
			if ($tipo == "T")
			{
				$consulta = "SELECT '0000-00-00' as fecha_trasp ,campo2, SUM(peso) AS peso, CASE WHEN LENGTH(campo2)=1 THEN CONCAT('0',campo2) ELSE campo2 END AS orden";
				$consulta = $consulta." FROM sea_web.movimientos";
				$consulta = $consulta." WHERE tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND campo2 <> ''";
				$consulta = $consulta." GROUP BY campo2";
				$consulta = $consulta." ORDER BY orden";
			
			}
			else if ($tipo == "P")
				{
					$consulta = "SELECT grupo AS campo2, SUM(peso) AS peso,fecha_trasp FROM sea_web.stock_piso_raf";
					$consulta = $consulta." WHERE fecha = '".$fecha."' AND grupo <> 0";
					$consulta = $consulta." GROUP BY grupo,fecha_trasp";
				}			
			//echo '<option>'.$consulta.'</option>';
			
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				$valor = $row["fecha_trasp"].'/'.$row["campo2"];			
				if (($valor == $cmbgrupo) and ($Proceso == 'R'))
					echo '<option value="'.$row["fecha_trasp"].'/'.$row["campo2"].'" SELECTed>N� '.$row["campo2"].' - '.$r["peso"].'</option>';
				else
					echo '<option value="'.$row["fecha_trasp"].'/'.$row["campo2"].'">N� '.$row["campo2"].' - '.$r["peso"].'</option>';
					
				//echo '<option>'.substr($cmbgrupo,11,2).'</option>';
			}
            echo '</SELECT>';
			//echo $consulta;
			?>
              </font></td>
            <td width="84">&nbsp;</td>
            <td> <font color="#000000">&nbsp; </font></td>
          </tr>
        </table>	
    <br>
	
<?php
if($Proceso == 'R')
{  
     echo'<table width="95%" class="TablaDetalle" cellpadding="3" cellspacing="0">';
	 echo'<tr><td>Unidades Traspasadas</td><td>';
			

	// consulto las hornadas generadas en traspaso a raf   
	$consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso FROM sea_web.movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND campo2= '".substr($cmbgrupo,11,2)."' AND cod_producto = 19"; 

	$rs = mysqli_query($link, $consulta);

	if($row = mysqli_fetch_array($rs))
	{
		$unidades_g = $row["unidades"];			  
		$unidades_grupo = $row["unidades"];

		$peso_g = $row["peso"];
		$peso_grupo = $row["peso"];

		$Encontrado = 'S';
		$Encontrado2 = 'N';
	}
	
	//consulto si hay ya unidades en stock piso
	$consulta1 = "SELECT SUM(unidades) AS unid, SUM(peso) AS pes FROM sea_web.stock_piso_raf Where fecha_trasp = '".$fecha."' AND grupo= '".substr($cmbgrupo,11,2)."' AND cod_producto = 19"; 
	$rs1 = mysqli_query($link, $consulta1);
				  
	if($row1 = mysqli_fetch_array($rs1))
	{ 		   
		if ($row1["unid"] > 0)
			$Encontrado2 = 'S';

		$unidades_grupo = $unidades_grupo - $row1["unid"];
		if($unidades_grupo <= 0)
			$unidades_grupo = 0;
				  
		$peso_grupo = $peso_grupo - $row1["pes"];  
		if($peso_grupo <= 0)
			$peso_grupo = 0;
					
	}


	echo'<input type="text" name="unidades_t" size="10" value="'.$unidades_grupo.'" Readonly>';
	echo'</td><td>Peso Traspasado</td><td width="15%">';
    echo '<input name="peso_t" type="text" value="'.$peso_grupo.'" size="10" Readonly>';
    echo'</td></tr><tr><td width=20%><strong>Peso en Piso</strong></td><td width=20%">';
	echo '<input name="unidades" type="hidden" value=""size="10">';
    echo '<input name="peso" type="text" value="" size="10" onBlur="calcula()";>';
    echo '<input name="peso_promedio" type="hidden" value="'.$peso_prom.'" size="10">';
			
    echo'</td><td width=15%></td><td width=20%">';
    echo'</td></tr></table>';
}		
?>
		<br>
        <table width="95%" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td colspan="4"><div align="center"> 
			<?php
            			
			//if ($Encontrado == 'S' && $Encontrado2 != 'S')			
			if (($tipo == "T") and ($Encontrado2 != "S"))
            {
			    echo '<input name="guardar" type="button" style="width:70" value="Guardar" onClick="guardar_datos();">&nbsp;';
			}
			
			//if ($Encontrado2 == 'S')
			if ($tipo == "P")
            {
			    //echo '<input name="modificar" type="button" style="width:70" value="Modificar" onClick="modificar_datos();">&nbsp;';
			    echo '<input name="Eliminar" type="button" style="width:70" value="Eliminar" onClick="eliminar_datos();">';
			}
			?>
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div></td>
          </tr>
        </table>
	<?php

if($Encontrado == 'S')
{	
//	 $fecha = $ano.'-'.$mes.'-'.$dia;

	 if ($tipo == "T")
		 $consulta = "SELECT distinct hornada,cod_subproducto FROM sea_web.movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND campo2= '".substr($cmbgrupo,11,2)."' AND cod_producto = 19"; 
	 else
	 {
	 	$consulta = "SELECT DISTINCT hornada,cod_subproducto FROM sea_web.stock_piso_raf WHERE fecha = '".$fecha."' AND grupo = '".substr($cmbgrupo,11,2)."' AND cod_producto = 19";		
		$consulta = $consulta." AND fecha_trasp = '".$fecha_traspaso."'";
	}
		
	 //echo $consulta."<br>";
	 $rs = mysqli_query($link, $consulta);
	 while($row = mysqli_fetch_array($rs))
	 {
				$i = $i + 1;
				$hornada = $row["hornada"];
			
				echo'<input name="a['.$i.']" type="hidden" size="8">';
				echo '<input type="hidden" name="fecha_p['.$i.']" value="'.$fecha.'">';
				echo '<input type="hidden" name="subproducto['.$i.']" value="'.$row["cod_subproducto"].'">';
				echo '<input type="hidden" name="hornada['.$i.']" value="'.$hornada.'">';
			
				 $consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso FROM sea_web.movimientos Where tipo_movimiento = 4 AND hornada = '".$hornada."'
				              AND fecha_movimiento = '".$fecha."' AND campo2= '".substr($cmbgrupo,11,2)."' AND cod_producto = 19"; 
				 
				 $rs1 = mysqli_query($link, $consulta);
				 if($row1 = mysqli_fetch_array($rs1))
				 {
				 	$unidades = $row1["unidades"];
				 	$peso = $row1["peso"];					
				 }				
                echo '<input type="hidden" name="unidades_a['.$i.']" value='.$unidades.'>';   
				echo '<input type="hidden" name="peso_a['.$i.']" value='.number_format($peso,0,"","").'>';
                
				/*porcentaje de unidades
				if ($unidades_g != 0)
				$porcent_unid = ($peso_grupo * 100) / $unidades_g;
				echo '<input type="text" name="porcent_unidades['.$i.']" value='.$porcent_unid.'>';

				//porcentaje de peso 
				if ($peso_g != 0)
				$porcent_pes = ($peso * 100) / $peso_g;
				echo '<input type="text" name="porcent_peso['.$i.']" value='.$porcent_pes.'><br>';*/

    }
	



        //detalle de stock en piso del grupo         
		if ($tipo == "T")
			$consulta4 = "SELECT SUM(unidades) AS unid_piso, SUM(peso) AS peso_piso FROM sea_web.stock_piso_raf WHERE cod_producto = 19 AND fecha_trasp = '".$fecha."' AND grupo = '".substr($cmbgrupo,11,2)."'";	
		else 
			$consulta4 = "SELECT SUM(unidades) AS unid_piso, SUM(peso) AS peso_piso FROM sea_web.stock_piso_raf WHERE cod_producto = 19 AND fecha = '".$fecha."' AND grupo = '".substr($cmbgrupo,11,2)."' AND fecha_trasp = '".substr($cmbgrupo,0,10)."'";			
		
		//echo $consulta4."<br>";
		$rs4 = mysqli_query($link, $consulta4);
		if($row4 = mysqli_fetch_array($rs4))
	    {
           if($row4["unid_piso"] > 0)
		   {		
				echo '<br><table width="95%" class="TablaDetalle"  border="1" cellpadding="3" cellspacing="0">
				 <tr class="ColorTabla01"> 
						<td colspan="4"><div align="center">Restos en Piso</div></td>
					  </tr>';
			
				echo' <tr class="ColorTabla02">'; 
				  echo '<td width="23%"><div align="center">FECHA</div></td>';
				  echo '<td width="23%"><div align="center">GRUPO</div></td>';
//				  echo '<td width="23%"><div align="center">UNIDADES</div></td>';
				  echo '<td width="23%"><div align="center">PESO</div></td>';
			    echo '</tr>';
			
						echo '<tr><td><center>'.$fecha.'</center></td>';
						echo '<td><center>'.substr($cmbgrupo,11,2).'</center></td>';
//						echo '<td><center>'.$row4["unid_piso"].'</center></td>';
						echo '<td><center>'.number_format($row4["peso_piso"],0,"","").'</center></td></tr>';
					
				echo '</table>';
           }
	   }

}


?>      </td>
  </tr>
</table>
  <?php include("../principal/pie_pagina.php")?>  
  
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
