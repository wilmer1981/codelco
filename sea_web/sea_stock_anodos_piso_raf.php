<?php 
$CodigoDeSistema = 2;
$CodigoDePantalla = 31;
if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = "";
}
if(isset($_REQUEST["spro"])) {
	$spro = $_REQUEST["spro"];
}else{
	$spro = "";
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


if(isset($_REQUEST["Mensaje"])) {
	$Mensaje = $_REQUEST["Mensaje"];
}else{
	$Mensaje = "";
}
if(isset($_REQUEST["cmbhornada"])) {
	$cmbhornada = $_REQUEST["cmbhornada"];
}else{
	$cmbhornada = "";
}

if(isset($_REQUEST["cmbproductos"])) {
	$cmbproductos = $_REQUEST["cmbproductos"];
}else{
	$cmbproductos = "";
}


if(isset($_REQUEST["Encontrado"])) {
	$Encontrado = $_REQUEST["Encontrado"];
}else{
	$Encontrado = "";
}
if(isset($_REQUEST["Encontrado2"])) {
	$Encontrado2 = $_REQUEST["Encontrado2"];
}else{
	$Encontrado2 = "";
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

?>
<html>
<head>
<title>Stock Anodos en piso de Raf</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function valida_valores()
{
var f = formulario;
var LargoForm = f.elements.length;
var valor;

	
	for (i = 0; i < LargoForm; i++)
	{
		if (f.elements[i].name == 'subproducto')		
		{
			valor = f.elements[i].value;
		}
	}
	

	return valor;


}

/*************************/
function guardar_datos()
{
var f = formulario;   
var shornada = f.shornada.value;
var valor = valida_valores();

   if (f.unidades.value == 0 || f.unidades.value == '')
   {  
      alert("Debe ingresar Unidades");
      f.unidades.focus();
      return
   }
   else
   {
   f.action="sea_stock_anodos_piso_raf01.php?Proceso=G&cmbsubproducto="+valor+"&shornada="+shornada; 
   f.submit();

   }		
}

/************************/
function modificar_datos()
{
var f = formulario;   
var valor = valida_valores();

   if (f.unidades.value == 0 || f.unidades.value == '')
   {  
      alert("Debe ingresar Unidades");
      f.unidades.focus();
      return
   }
   else
   {
      f.action="sea_stock_anodos_piso_raf01.php?Proceso=M&subproducto="+valor; 
      f.submit();
   }		
}
/************************/
function eliminar_datos()
{
var f = formulario;   
var valor = valida_valores();

      f.action="sea_stock_anodos_piso_raf01.php?Proceso=E&subproducto="+valor; 
      f.submit();
}


/**********/
function buscar_hornada()
{
var f = formulario; 
  
   if (f.cmbproductos.value == -1)
   {  
      alert("Debe Seleccionar Producto");
      f.cmbproductos.focus();
      return
   }
   var spro;
  //alert(f.cmbproductos.value);
	if(f.cmbproductos.value.substring(0,2) == "16" || f.cmbproductos.value.substring(0,2) == "18" || f.cmbproductos.value.substring(0,2) == "48")
	{ 
   		spro=0;
   		spro = f.cmbsubproducto.value;
	}
   
   f.action="sea_stock_anodos_piso_raf.php?Proceso=B&spro="+spro;

   f.submit();
 
}

/***************/
function Ver_Stock()
{
var f = formulario;   

f.action="sea_lst_stock_piso.php?Proceso=V1";
f.submit();
  		
}

/***********/
function recarga_datos()
{
    var f = formulario;
   	f.action="sea_stock_anodos_piso_raf.php?Proceso=R"
    f.submit();
}
function recarga_datos2()
{
         var f = formulario;
			
         pprod = f.cmbsubproducto.value;
         f.action="sea_stock_anodos_piso_raf.php?Proceso=R&pprod="+pprod;
		 
         f.submit();
}

/***********/
function Recarga_Productos()
{
var f = formulario;   

	f.action="sea_stock_anodos_piso_raf.php?Proceso=R1";
    f.submit();
  		
}

/*******************/
function calcula()
{
var f=formulario;
     

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
  <?php echo'<input type="hidden" name="apellido">';
     echo'<input type="hidden" name="prodpas">'; ?>

  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="top" >
    <table width="95%" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td>Fecha Traspaso </td>
            <td>
              <SELECT name="dia">
                <?php
		if ($Proceso=='B' || $Proceso =='R' || $Proceso =='R1')
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
              <SELECT name="mes">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B' || $Proceso =='R' || $Proceso =='R1')
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
              <SELECT name="ano">
                <?php
	if($Proceso=='B' || $Proceso =='R' || $Proceso =='R1')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
			if (isset($ano))
			{
				if ($ano == $i)
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option SELECTed value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
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
            </td>
            <td>Producto</td>
            <td>
              <?php
			echo '<SELECT name="cmbproductos" style="width:150" onChange="Recarga_Productos()">
            <option  value = "-1" SELECTed>Seleccionar</option>';
			$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17' AND mostrar_sea = 'S'";
   	        include("../principal/conectar_principal.php");
			$rs = mysqli_query($link, $consulta);
            //echo $consulta;
			while ($row = mysqli_fetch_array($rs))
			{
			if ($row['cod_subproducto'] == $cmbproductos and ($Proceso == 'B' || $Proceso =='R' || $Proceso =='R1'))
				echo '<option value="'.$row['cod_subproducto'].'" SELECTed>'.$row['abreviatura'].'</option>';
			else 
				echo '<option value="'.$row['cod_subproducto'].'">'.$row['abreviatura'].'</option>';
			}

			echo '<option value="0">--------------------</option>';
			//BLISTER
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 16 ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{				
	          	if ('16'.$row["cod_subclase"] == $cmbproductos)	
					echo '<option value="16'.$row["cod_subclase"].'" SELECTed>'.$row["nombre_subclase"].'</option>';
                    else
					echo '<option value="16'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
            }
            echo '<option value="0">--------------------</option>';
	        if ($cmbproductos == "181")
				 echo '<option value="181" SELECTed>CATODOS</option>';
	        else
		         echo '<option value="181">CATODOS</option>';

            if ($cmbproductos == "481")
				  echo '<option value="481" SELECTed>LAMINAS Y DESPUNTE</option>';
            else
				  echo '<option value="481">LAMINAS Y DESPUNTE</option>';
            echo'</SELECT></td>';
          ?>
            </td>
            <td width="76"><input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_hornada();"></td>
          </tr>
          <tr> 
            <td width="88" height="26"><font color="#000000">Horn/Unid/peso</font></td>
            <td width="225"><font color="#000000">
              <?php
			  
			$codigo = substr($cmbproductos,0,2); 
			
            if ($Proceso=='B')
            {
               // $apellido = $row["cod_subproducto"];		//desactivado WSO		
                $apellido = substr($spro,2,2);
            }
            else
            {
                $apellido = substr($cmbproductos,2,2);
			
            }

		  
            if(($codigo==16)||($codigo==18)||($codigo==48))
            {
				
			         echo'<SELECT name="cmbhornada" onChange="recarga_datos2();">';
             }
             else
             {
                     echo'<SELECT name="cmbhornada" onChange="recarga_datos();">';
             }
			$fecha = $ano.'-'.$mes.'-'.$dia;
			
			include("../principal/conectar_sea_web.php");
			echo '<option value="-1">Horn/lote</option>';
     		
			if($codigo == 16)
			{
				$consulta = "SELECT distinct hornada FROM movimientos where tipo_movimiento = 4 AND cod_producto = 16
							 AND cod_subproducto = '".$apellido."' AND fecha_movimiento = '".$fecha."' ";
			}
			if($codigo == 18)
			{
				$consulta = "SELECT distinct hornada FROM movimientos where tipo_movimiento = 4 AND cod_producto = 18
							 AND cod_subproducto = '".$apellido."' AND fecha_movimiento = '".$fecha."' ";
			}
			if($codigo == 48)
			{
				$consulta = "SELECT distinct hornada FROM movimientos where tipo_movimiento = 4 AND cod_producto = 48
							 AND cod_subproducto = '".$apellido."' AND fecha_movimiento = '".$fecha."' ";
			}
			if($codigo != 48 && $codigo != 18 && $codigo != 16)
			{
				$consulta = "SELECT distinct hornada FROM movimientos where tipo_movimiento = 4 AND cod_producto = 17
				             AND cod_subproducto = '".$cmbproductos."' AND fecha_movimiento = '".$fecha."' ";
			}
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
			
				if($codigo == 16)
				{
				 	$consulta = "SELECT unidades,peso FROM movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND hornada= '".$row["hornada"]."' AND cod_producto = 16 AND cod_subproducto = '".$apellido."' ";
				    $rs2 = mysqli_query($link, $consulta);
				    if($row2 = mysqli_fetch_array($rs2))
				    {

					   if ($row["hornada"] == $cmbhornada and $Proceso=='R')
						  echo '<option value="'.$row["hornada"].'" SELECTed>'.substr($row["hornada"],3,6).' - '.$row2["unidades"].' - '.$row2["peso"].'</option>';
					   else
						  echo '<option value="'.$row["hornada"].'">'.substr($row["hornada"],3,6).' - '.$row2["unidades"].' - '.$row2["peso"].'</option>';
				    }
				}
				if($codigo == 18)
				{
				 	$consulta = "SELECT unidades,peso FROM movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND hornada= '".$row["hornada"]."' AND cod_producto = 18 AND cod_subproducto = '".$apellido."' ";
				    $rs2 = mysqli_query($link, $consulta);
				    if($row2 = mysqli_fetch_array($rs2))
				    {
					   if ($row["hornada"] == $cmbhornada and $Proceso=='R')
						  echo '<option value="'.$row["hornada"].'" SELECTed>'.substr($row["hornada"],6,6).' - '.$row2["unidades"].' - '.$row2["peso"].'</option>';
					   else
						  echo '<option value="'.$row["hornada"].'">'.substr($row["hornada"],6,6).' - '.$row2["unidades"].' - '.$row2["peso"].'</option>';
				    }
				}
				if($codigo == 48)
				{
				 	$consulta = "SELECT unidades,peso FROM movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND hornada= '".$row["hornada"]."' AND cod_producto = 48 AND cod_subproducto = '".$apellido."' ";
				    $rs2 = mysqli_query($link, $consulta);
				    if($row2 = mysqli_fetch_array($rs2))
				    {

					   if ($row["hornada"] == $cmbhornada and $Proceso=='R')
						  echo '<option value="'.$row["hornada"].'" SELECTed>'.substr($row["hornada"],6,6).' - '.$row2["unidades"].' - '.$row2["peso"].'</option>';
					   else
						  echo '<option value="'.$row["hornada"].'">'.substr($row["hornada"],6,6).' - '.$row2["unidades"].' - '.$row2["peso"].'</option>';
				    }
				}
				if($codigo != 48 && $codigo != 18 && $codigo != 16)
				{
				 	$consulta = "SELECT unidades,peso FROM movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND hornada= '".$row["hornada"]."' AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' ";
				    $rs2 = mysqli_query($link, $consulta);
				    if($row2 = mysqli_fetch_array($rs2))
				    {

					   if ($row["hornada"] == $cmbhornada and $Proceso=='R')
						  echo '<option value="'.$row["hornada"].'" SELECTed>'.substr($row["hornada"],6,6).' - '.$row2["unidades"].' - '.$row2["peso"].'</option>';
					   else
						  echo '<option value="'.$row["hornada"].'">'.substr($row["hornada"],6,6).' - '.$row2["unidades"].' - '.$row2["peso"].'</option>';
				    }
				}	
			}
		
            echo '</SELECT>';
			//echo $consulta;
			?>
              </font><font color="#000000" size="2">&nbsp; </font></td>
			<?php
			if($codigo == 16 || $codigo == 18 || $codigo == 48)				
	             echo'<td width="48">Subproducto</td>';
 			else
	             echo'<td width="48">&nbsp;</td>';
	        ?>
			<td width="185">
			<?php
				//BLISTER		

				if($codigo == 16 || $codigo == 18 || $codigo == 48)
				{
					echo '<SELECT name="cmbsubproducto">';
					echo '<option value="-1">Seleccionar</option>';
					
					if($codigo == 16)
					{
						
						$apellido = substr($cmbproductos,2,2);
						$Consulta="SELECT * from proyecto_modernizacion.subproducto where cod_producto = 16 and ap_subproducto = '".$apellido."'"; 
						$rs = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($rs))
						{
							if ($cmbsubproducto == '16'.$Fila["cod_subproducto"])
							{
								echo "<option value = '16".$Fila["cod_subproducto"]."' SELECTed>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
							}
							else
							{
								echo "<option value = '16".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
							}	
						}
					}	
					if($codigo == 18)
					{
						$Consulta="SELECT * from proyecto_modernizacion.subproducto where cod_producto = 18 and cod_subproducto in(2,4,5,6,8,9,10,16,17,18,46,49,54,7,53)"; 
						$rs = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($rs))
						{
							if ($cmbsubproducto == '18'.$Fila["cod_subproducto"])
							{
								echo "<option value = '18".$Fila["cod_subproducto"]."' SELECTed>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
							}
							else
							{
								echo "<option value = '18".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
							}	
						}				
					}
					//LAMINAS Y DESP.
					if($codigo == 48)
					{
						// MFM $Consulta="SELECT * from proyecto_modernizacion.subproducto where cod_producto = 48 and cod_subproducto in(1,2,3,7,10)"; 
						$Consulta="SELECT * from proyecto_modernizacion.subproducto where cod_producto = 48 and cod_subproducto in(1,2,3,7,10, 8,9,11)"; 
												
						$rs = mysqli_query($link, $Consulta);
						while ($Fila=mysqli_fetch_array($rs))
						{
							if ($cmbsubproducto == '48'.$Fila["cod_subproducto"])
							{
								echo "<option value = '48".$Fila["cod_subproducto"]."' SELECTed>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
							}
							else
							{
								echo "<option value = '48".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
							}	
						}				
										
					}
													
					echo '</SELECT>'; 				
				}	
				
						
			?>
			</td>
            <td width="113"><font color="#000000"> 
              <input name="buscar2" type="button" style="width:70" value="Ver Stock" onClick="Ver_Stock();">
              </font></td>
          </tr>
        </table>	
    <br>
	
<?php
if($Proceso == 'R')
{  
     echo'<table width="95%" class="TablaDetalle" cellpadding="3" cellspacing="0">';
	 echo'<tr> 
            <td>Saldo Unid. Traspasadas</td>
            <td>';
			
		    $fecha = $ano.'-'.$mes.'-'.$dia;
			$codigo = substr($cmbproductos,0,2);
            if (($Proceso=='R')&&($codigo<>17))
            {
                $apellido = substr($pprod,2,2);
            }
            else
            {
			    $apellido = substr($cmbproductos,2,2);
            }
 		    include("../principal/conectar_sea_web.php");
             //consulto las hornadas generadas en traspaso a raf   
            if($codigo == 16)
  	           $consulta = "SELECT hornada,unidades,peso,cod_subproducto FROM movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND hornada= '".$cmbhornada."' AND cod_producto = 16 AND cod_subproducto = '".$apellido."' ";
            if($codigo == 18)
  	           $consulta = "SELECT hornada,unidades,peso,cod_subproducto FROM movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND hornada= '".$cmbhornada."' AND cod_producto = 18 AND cod_subproducto = '".$apellido."' ";
            if($codigo == 48)
  	           $consulta = "SELECT hornada,unidades,peso,cod_subproducto FROM movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND hornada= '".$cmbhornada."' AND cod_producto = 48 AND cod_subproducto = '".$apellido."' ";
            if($codigo != 16 && $codigo != 18 && $codigo != 48)
  	           $consulta = "SELECT hornada,unidades,peso,cod_subproducto FROM movimientos Where tipo_movimiento = 4 AND fecha_movimiento = '".$fecha."' AND hornada= '".$cmbhornada."' AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' ";
			
			//echo "uno".$consulta."<br>";
			//$Encontrado = 'N';
			//$Encontrado2 = 'S';
		     $rs = mysqli_query($link, $consulta);
			 if($row = mysqli_fetch_array($rs))
			 {
			      			  
				  $unidades_hornada = $row["unidades"];
				  $peso_hornada = $row["peso"];
				  $hornada = $row["hornada"];
				  $subproducto = $row["cod_subproducto"];	
				  
				  $peso_prom = $peso_hornada / $unidades_hornada;			 
                 //consulto por el peso de cada hornada en tablas hornadas
/*				 $consulta2 = "SELECT * FROM hornadas Where cod_producto = 17 AND hornada_ventana = ".$row["hornada"]; 
				 $rs2 = mysqli_query($link, $consulta2);
				 if($row2 = mysqli_fetch_array($rs2))
				 { 
                    $peso_prom = $row2["peso_unidades"] / $row2["unidades"];
				 } */	
                 $Encontrado = 'S';
				 $Encontrado2 = 'N';
             }

				  //consulto si hay ya unidades en stock piso
                if($codigo == 16)
				  $consulta1 = "SELECT SUM(unidades) AS unid, SUM(peso) AS pes FROM stock_piso_raf Where fecha = '".$fecha."' AND hornada = '".$cmbhornada."' AND cod_producto = 16 AND cod_subproducto = '".$apellido."' ";
                if($codigo == 18)
				  $consulta1 = "SELECT SUM(unidades) AS unid, SUM(peso) AS pes FROM stock_piso_raf Where fecha = '".$fecha."' AND hornada = '".$cmbhornada."' AND cod_producto = 18 AND cod_subproducto = '".$apellido."' ";
                if($codigo == 48)
				  $consulta1 = "SELECT SUM(unidades) AS unid, SUM(peso) AS pes FROM stock_piso_raf Where fecha = '".$fecha."' AND hornada = '".$cmbhornada."' AND cod_producto = 48 AND cod_subproducto = '".$apellido."' ";
                if($codigo != 16 && $codigo != 18 && $codigo != 48)
				  $consulta1 = "SELECT SUM(unidades) AS unid, SUM(peso) AS pes FROM stock_piso_raf Where fecha = '".$fecha."' AND hornada = '".$cmbhornada."' AND cod_producto = 17 AND cod_subproducto = '".$cmbproductos."' ";

				 //echo "dos".$consulta1."<br>";
				  $rs1 = mysqli_query($link, $consulta1);
            
				  if($row1 = mysqli_fetch_array($rs1))
				  { 
				   
				   if ($row1["unid"] > 0)
				   $Encontrado2 = 'S';
				   $shornada = $cmbhornada;
				   $unidades_hornada = $unidades_hornada - $row1["unid"];
 				    if($unidades_hornada <= 0)
				     $unidades_hornada = 0;
				  
				   $peso_hornada = $peso_hornada - $row1["pes"];  
				    if($peso_hornada <= 0)
				     $peso_hornada = 0;
					
				  }
		         echo'<input type="hidden" name="shornada" size="10" value="'.$shornada.'" disabled>';
		         echo'<input type="hidden" name="subproducto" size="10" value="'.$subproducto.'" disabled>';
		         echo'<input type="text" name="unidades_t" size="10" value="'.$unidades_hornada.'" Readonly';
				 
             echo'</td>
            <td>Saldo Peso Traspasado</td>
            <td width="15%">';
                echo '<input name="peso_t" type="text" value="'.number_format($peso_hornada,0,"","").'" size="10" Readonly>';
       echo'</td>
		  </tr>
		  <tr>	
            <td width=20%><strong>Unidades en Piso</strong></td>
            <td width=20%">';
                echo '<input name="unidades" type="text" value=""size="10" onBlur="calcula()";>';
       echo'</td>

            <td width=15%><strong>Peso en Piso</strong></td>
            <td width=20%">';
                echo '<input name="peso" type="text" value="" size="10">';
                echo '<input name="peso_promedio" type="hidden" value="'.$peso_prom.'" size="10">';
       echo'</td>

          </tr>
        </table>';
}		
?>
		<br>
        <table width="95%" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td colspan="4"><div align="center"> 
			<?php
            			
			if ($Encontrado == 'S' && $Encontrado2 != 'S')
            {
			    echo '<input name="guardar" type="button" style="width:70" value="Guardar" onClick="guardar_datos();">&nbsp;';
			}
			
			if ($Encontrado2 == 'S')
            {
			    //echo '<input name="modificar" type="button" style="width:70" value="Modificar" onClick="modificar_datos();">&nbsp;';
			    echo '<input name="Eliminar" type="button" style="width:70" value="Eliminar" onClick="eliminar_datos();">';
			}
			?>
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
                <font color="#000000"> </font></div></td>
          </tr>
        </table>
	<?php
if($Encontrado == 'S')
{	
     include("../principal/conectar_sea_web.php");
	 $fecha = $ano.'-'.$mes.'-'.$dia;
       //detalle de stock en piso del grupo         
		if(substr($cmbproductos,0,2) == 16)
		{
			$apellido = substr($cmbproductos,2,2);
			$consulta4 = "SELECT SUM(unidades) AS unid_piso, SUM(peso) AS peso_piso FROM stock_piso_raf WHERE fecha = '".$fecha."' AND cod_producto = 16 AND
						 cod_subproducto = '".$apellido."'  AND hornada = '".$cmbhornada."' ";
		}
		if(substr($cmbproductos,0,2) == 18)
		{
			$apellido = substr($cmbproductos,2,2);
			$consulta4 = "SELECT SUM(unidades) AS unid_piso, SUM(peso) AS peso_piso FROM stock_piso_raf WHERE fecha = '".$fecha."' AND cod_producto = 18 AND
						 cod_subproducto = '".$apellido."'  AND hornada = '".$cmbhornada."'";
		}
		if(substr($cmbproductos,0,2) == 48)
		{
			$apellido = substr($cmbproductos,2,2);
			$consulta4 = "SELECT SUM(unidades) AS unid_piso, SUM(peso) AS peso_piso FROM stock_piso_raf WHERE fecha = '".$fecha."' AND cod_producto = 48 AND
						 cod_subproducto = '".$apellido."'  AND hornada = '".$cmbhornada."'";
		}
		if(substr($cmbproductos,0,2) != 48 && substr($cmbproductos,0,2) != 18 && substr($cmbproductos,0,2) != 16)
		{
			$consulta4 = "SELECT SUM(unidades) AS unid_piso, SUM(peso) AS peso_piso FROM stock_piso_raf WHERE fecha = '".$fecha."' AND cod_producto = 17 AND
		  				  cod_subproducto = '".$cmbproductos."'  AND hornada = '".$cmbhornada."'";
		}
	    $rs4 = mysqli_query($link, $consulta4);
        //echo "tres".$consulta4."<br>";
		if($row4 = mysqli_fetch_array($rs4))
	    {
           if($row4["unid_piso"] > 0)
		   {		
				echo '<br><table width="95%" class="TablaDetalle"  border="1" cellpadding="3" cellspacing="0">
				 <tr class="ColorTabla01"> 
						<td colspan="4"><div align="center">�nodos en Piso</div></td>
					  </tr>';
			
				echo' <tr class="ColorTabla02"> 
						<td width="23%"><div align="center">FECHA</div></td>
						<td width="23%"><div align="center">HORNADA</div></td>
						<td width="23%"><div align="center">UNIDADES</div></td>
						<td width="23%"><div align="center">PESO</div></td>
					  </tr>';
			
						echo '<tr><td><center>'.$fecha.'</center></td>';
						if(substr($cmbproductos,0,2) == 16)
							echo '<td><center>'.substr($cmbhornada,3,6).'</center></td>';
						else
							echo '<td><center>'.substr($cmbhornada,6,6).'</center></td>';
						echo '<td><center>'.$row4["unid_piso"].'</center></td>';
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
