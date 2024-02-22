<?php 
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 12;
	
	include("funciones.php");
	include("../principal/conectar_sea_web.php");
	$FechaC = Date("Y-m-d");
	
?>

<html>
<head>
<title>Traspaso RAF</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(f)
{
	f.action = "traspaso_raf.php?recargapag1=S&cmbtipo=" + f.cmbtipo.value;
	f.submit()	
}
/****************/
function Valida1(f,b)
{
	if (f.cmbtipo.value == -1)
	{	
		alert("Debe Seleccionar el Tipo de Anodo");
		return false;
	}
	
	if (f.cmbproducto.value == -1)
	{	
		alert("Debe Seleccionar el Sub-Producto");
		return false;		
	}
	
	if (b == 2)
	{
		if (f.txthornada.value == "")
		{	
			alert("Debe Ingresar la Hornada");
			return false;
		}
	}
	
	return true;
}
/**************/
function Buscar(f,b)
{
	if (Valida1(f,b))
	{
		parametros = "recargapag1=S&recargapag2=S&cmbtipo=" + f.cmbtipo.value + "&cmbproducto=" + f.cmbproducto.value + "&boton=" + b ;
		parametros = parametros + "&fecha=" + f.ano2.value + "-" + f.mes2.value + "-" + f.dia2.value;
		//alert (parametros);
		f.action = "traspaso_raf.php?" + parametros;
		f.submit();
	}
}
/**********/
function Mover(f,c,pos)
{
	var promedio;
/*	for(i=0; i<f.elements.length; i++)
	{
		alert(i+ "  " + f.elements[i].name);
	}

alert(pos);*/

	if (c.checked == true)
	{
		f.elements[pos+1].value = f.elements[pos-4].value;
		f.elements[pos+2].value = f.elements[pos-3].value;
		f.elements[pos-2].value = 0;
		f.elements[pos-1].value = 0;
		f.elements[pos+3].value = f.elements[pos+5].value;
		f.elements[pos+4].value = f.elements[pos+6].value
	}
	else
	{
		f.elements[pos-2].value = f.elements[pos-4].value;
		f.elements[pos-1].value = f.elements[pos-3].value;
		f.elements[pos+1].value = "";
		f.elements[pos+2].value = "";
		f.elements[pos+3].value = f.elements[pos+5].value;
		f.elements[pos+4].value = f.elements[pos+6].value
	}
	promedio = Math.round(f.elements[pos+6].value / f.elements[pos+5].value * 100000) / 100000;
	f.peso_prom.value = Math.round(promedio * 100)/100;

}
/*****************/
function Calcula(f,pos)
{
	var promedio = Math.round(f.elements[pos+5].value / f.elements[pos+4].value * 100000) / 100000;

	if (f.elements[pos].value < 0)
	{
		alert("Las Unidades Ingresadas No Son Validas");
		f.elements[pos].focus();
		return;		
	}

	if (f.elements[pos].value != "")
	{		
		if ((f.elements[pos].value * 1) > (f.elements[pos+2].value * 1))
		{
					alert("Las Unidades A Traspasar No Deben Ser Mayor Que El Stock: ");
					f.elements[pos].focus();
					return;
		}			
		
		if ((f.elements[pos].value * 1) > (f.elements[pos-5].value * 1))
		{
			if (confirm("Esta Considerando Unidades Que No Estan Rechazadas, �Desea Continuar? "))
			{
					f.elements[pos-5].value = 0;
					f.elements[pos-4].value = 0;
					f.elements[pos-3].value = 0;
					f.elements[pos-2].value = 0;
					f.elements[pos+2].value = parseInt(f.elements[pos+2].value) - parseInt(f.elements[pos].value);
					f.elements[pos+1].value = Math.round(f.elements[pos].value * promedio * 1) / 1;
					f.elements[pos+3].value = parseInt(f.elements[pos+5].value) - parseInt(f.elements[pos+1].value);
			}
			else
			{
					f.elements[pos].focus();
					return;
			}

		}	
		else
		{
			f.elements[pos-3].value = f.elements[pos-5].value - f.elements[pos].value;
			f.elements[pos-2].value = Math.round(f.elements[pos-3].value * promedio * 1)/ 1; 
			f.elements[pos+1].value = Math.round(f.elements[pos].value * promedio * 1) / 1;
			f.elements[pos+2].value = f.elements[pos+4].value;
			f.elements[pos+3].value = f.elements[pos+5].value;
		}
	}
	else
	{	
		f.elements[pos+1].value = "";
		f.elements[pos-3].value = f.elements[pos-5].value;
		f.elements[pos-2].value = f.elements[pos-4].value;
		f.elements[pos+2].value = f.elements[pos+4].value;
		f.elements[pos+3].value = f.elements[pos+5].value;
	}	
	
	f.peso_prom.value = Math.round(promedio * 100)/100;
}
/******************/
function ver_datos()
{
var f = frm1;

   	window.open("sea_ing_anodos_Trasp_raf02.php", "","menubar=no resizable=yes Top=50 Left=200 width=550 height=500 scrollbars=yes");

}

/********************/
function Grabar(f)
{	
	f.action = "traspaso_raf01.php?proceso=G";
	f.submit()
}
/*********************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2";
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
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
<?php include("../principal/encabezado.php") ?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="top">

<form name="frm1" action="" method="post">


        <table width="750" border="0" class="TablaDetalle">
          <tr> 
            <td width="109">Fecha Reproceso</td>
            <td width="228"><font size="2"> 
              <select name="dia1" size="1" id="dia1">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($recargapag1 == "S") && ($i == $dia1))
					echo "<option selected value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($recargapag1 != "S")) 
						echo "<option selected value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
              </select>
              </font> <font size="2"> 
              <select name="mes1" size="1">
                <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($recargapag1 == "S") && ($i == $mes1))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($recargapag1 != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
              </select>
              <select name="ano1" size="1" id="ano1">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($recargapag1 == "S") && ($i == $ano1))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($recargapag1 != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
              </select>
              </font></td>
            <td width="145">Ver Datos Ingresados</td>
            <td width="247"><font color="#000000">
              <input type="button" name="Ver" value="Ver Traspasados" onClick="ver_datos();">
              </font></td>
          </tr>
        </table>
  <br>
  <br>
<table width="750" border="0" class="TablaDetalle">
          <tr> 
            <td width="112">Productos</td>
      <td width="229"> 
        <select name="cmbtipo" id="cmbtipo" onChange="JavaScript:Recarga1(this.form)">
            <?php
			if ($cmbtipo == "-1")
				echo '<option value="-1" selected>SELECCIONAR</option>';
			else 
				echo '<option value="-1">SELECCIONAR</option>';

				echo '<option value="0">--------------------</option>';

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

				echo '<option value="0">--------------------</option>';
			
			//BLISTER
			$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 16 ORDER BY cod_subclase";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{				
	          	if ('16'.$row["cod_subclase"] == $cmbtipo)	
					echo '<option value="16'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
				else 
					echo '<option value="16'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}	


			echo '<option value="0">--------------------</option>';
			if ($cmbtipo == "181")	
				echo '<option value="181" selected>CATODOS</option>';
			else 
				echo '<option value="181">CATODOS</option>';
			
			if ($cmbtipo == "481")	
				echo '<option value="481" selected>LAMINAS Y DESPUNTE</option>';
			else 
				echo '<option value="481">LAMINAS Y DESPUNTE</option>';
/*			
			if ($cmbtipo == "486")	
				echo '<option value="486" selected>LAMINAS STANDART </option>';
			else 
				echo '<option value="486">LAMINAS STANDART </option>';
*/
			if ($cmbtipo == "661")	
				echo '<option value="661" selected>LAMINAS APROBADAS</option>';
			else 
				echo '<option value="661">LAMINAS APROBADAS</option>';				
		

											
		?>
          </select></td>
      <td width="145">Sub-Producto</td>
      <td width="246"> 
        <select name="cmbproducto" onChange="JavaScript:Recarga1(this.form)">
            <option value="-1">SELECCIONAR</option>
            <?php
			if (($recargapag1 == "S") and ($cmbtipo != -1))
			{				
				if ($cmbtipo == 1) //Corrientes
					$consulta = "SELECT valor_subclase1 AS valor FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002";
				else if ($cmbtipo == 2) //H. Madres
						$consulta = "SELECT valor_subclase2 AS valor FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002";
				else if ($cmbtipo == 3) //Especiales
						$consulta = "SELECT valor_subclase3 AS valor FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2002";
					
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					$consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE cod_producto = 17 AND cod_subproducto = '".$row["valor"]."' AND mostrar_sea ='S'";
					$rs1 = mysqli_query($link, $consulta);					
					if ($row1 = mysqli_fetch_array($rs1))
					{
						if ($row1["cod_subproducto"] == $cmbproducto)
							echo '<option value="'.$row1["cod_subproducto"].'" selected>'.$row1["descripcion"].'</option>';
						else
							echo '<option value="'.$row1["cod_subproducto"].'">'.$row1["descripcion"].'</option>';									
					}
				}

			//BLISTER	
			$codigo = substr($cmbtipo,0,2);
		  	if($codigo == 16)
		  	{
				$apellido = substr($cmbtipo,2,2);
				$Consulta="select * from subproducto where cod_producto = 16 and ap_subproducto = $apellido"; 
				$rs = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($rs))
				{
					if ($cmbproducto == '16'.$Fila["cod_subproducto"])
					{
						echo "<option value = '16".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value = '16".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}	
				}				
								
			}

            //CATODOS
			$codigo = substr($cmbtipo,0,2);
		  	if($codigo == 18)
		  	{
				$Consulta="select * from subproducto where cod_producto = 18 and cod_subproducto in(2,4,5,6,8,9,10,46,16,17)"; 
				$rs = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($rs))
				{
					if ($cmbproducto == '18'.$Fila["cod_subproducto"])
					{
						echo "<option value = '18".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value = '18".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}	
				}				
			}

            //LAMINAS Y DESP.
			$codigo = substr($cmbtipo,0,2);
		  	if($codigo == 48)
		  	{
				$Consulta="select * from subproducto where cod_producto = 48 and cod_subproducto in(1,2,3,6,7,10,11)";
				$rs = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($rs))
				{
					if ($cmbproducto == '48'.$Fila["cod_subproducto"])
					{
						echo "<option value = '48".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value = '48".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}	
				}				
								
			}
			
			//LAMINAS A N.E.
			$codigo = substr($cmbtipo,0,2);
		  	if($codigo == 66)
		  	{
				$Consulta="select * from subproducto where cod_producto = 66 ";
				$rs = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($rs))
				{
					if ($cmbproducto == '66'.$Fila["cod_subproducto"])
					{
						echo "<option value = '66".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}
					else
					{
						echo "<option value = '66".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}	
				}				
								
			}			
		}
		?>
          </select></td>
  </tr>
</table>
  <br>
  <table width="750" border="0" class="TablaDetalle">
<tr>
      <td width="111">F. Recep-Recha</td>
      <td width="231"><font size="2"> 
              <select name="dia2" size="1" id="dia2">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($recargapag1 == "S") && ($i == $dia2))
					echo "<option selected value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($recargapag1 != "S")) 
						echo "<option selected value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
              </select>
              </font> <font size="2"> 
              <select name="mes2" size="1">
                <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($recargapag1 == "S") && ($i == $mes2))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($recargapag1 != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
              </select>
              <select name="ano2" size="1" id="ano2">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($recargapag1 == "S") && ($i == $ano2))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($recargapag1 != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
              </select>
        </font></td>
      <td width="394"><input name="btnbuscar" type="button" value="Buscar" onClick="Buscar(this.form,1)">
        &nbsp;&nbsp;* Fecha de Rechazo Por Calidad o Recepci�n de Blister</td>
    </tr>
  </table>
  <br>
        <table width="750" border="0" class="TablaDetalle">
          <tr> 
            <td width="109">N&ordm; Hornada-Lote</td>
            <td width="229"> 
              <?php	
			   $largo = strlen($mes1);
			   if ($largo==1)
			   {
			        $mes1 = "0$mes1";
			   }
			   $largo = strlen($dia1);
			   if ($largo==1)
			   {
			        $dia1 = "0$dia1";
			   }
			   	
			   //ANODOS
			   if($codigo != 16 && $codigo != 18 && $codigo != 48 && $codigo != 66)
			   	    echo'<input name="txthornada" type="text" value="'.$txthornada.'" size="10">';

				
		       $codigo = substr($cmbtipo,0,2);				
			   //BLISTER

			   if($codigo == 16 && $recargapag2 == "S") 
			   {
				       
				   $fecha = $ano1."-".$mes1."-".$dia1;
				   if (strlen($mes2)==1)
				   		$mes2 = "0".$mes2;
				   if (strlen($dia2)==1)
				   		$dia2 = "0".$dia2;	
				   $fecha2 = $ano2."-".$mes2."-".$dia2;	
		           $subproducto = substr($cmbproducto,2,1);

				   echo'<select name="txthornada" onChange="Buscar(this.form,2)">';
				   echo'<option value="0" selected>Seleccionar</option>';
				   $Consulta = "SELECT distinct hornada FROM sea_web.movimientos WHERE cod_producto = 16 AND cod_subproducto = '".$subproducto."' AND fecha_movimiento <= '".$FechaC."'";
				   $Consulta.=" order by hornada ";
				   $A1 = $Consulta;
				   $rs = mysqli_query($link, $Consulta);
				   while($fila = mysqli_fetch_array($rs))
				   {			   
						$hornada = substr($fila[hornada],2,8);
						//Recep
						$Consulta = "SELECT ifnull(SUM(unidades),0) as unid, ifnull(SUM(peso),0) as peso FROM sea_web.movimientos WHERE tipo_movimiento = 1 AND cod_producto  = 16 AND hornada = '".$fila[hornada]."'";
						$Consulta.=" and cod_subproducto = '".$subproducto."' and fecha_movimiento <= '".$FechaC."'";
						$A2 = $Consulta;
						$unid_recep = 0;
						$unid_trasp = 0;
						$saldo_unidad = 0;
						$rs9 = mysqli_query($link, $Consulta);
						if($row9 = mysqli_fetch_array($rs9))
						{
							$unid_recep = $row9[unid];
						}												
						//Trasp-Benef
						$Consulta = "SELECT ifnull(SUM(unidades),0) as unid, ifnull(SUM(peso),0) as peso FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto  = 16 AND hornada = '".$fila[hornada]."'";
						$Consulta.=" and cod_subproducto = '".$subproducto."' and fecha_movimiento <= '".$FechaC."'";
						 $A3 = $Consulta;
						$rs8 = mysqli_query($link, $Consulta);
						if($row8 = mysqli_fetch_array($rs8))
						{
							$unid_trasp = $row8[unid];
						}												
						$saldo_unidad = ($unid_recep - $unid_trasp);
						if($saldo_unidad > 0)
						{						 
							if($txthornada == $hornada)
								echo'<option value="'.$hornada.'" selected>'.$hornada.'</option>';
							else
								echo'<option value="'.$hornada.'">'.$hornada.'</option>';
						}
				   }
				   echo'</select>';
			   }	   
				
			   //CATODOS
			   if($codigo == 18)
			   {
				   $fecha = $ano1."-".$mes1."-".$dia1;	
		           $subproducto = substr($cmbproducto,2,2);
				   echo'<select name="txthornada" onChange="Buscar(this.form,2)">';
				   echo'<option value="0" selected>Seleccionar</option>';
				   $Consulta = "SELECT distinct hornada FROM sec_web.traspaso WHERE cod_producto = 18 AND cod_subproducto = '$subproducto' AND fecha_traspaso <= '$fecha' and sw = 1";
       				//echo $Consulta;
				   $rs = mysqli_query($link, $Consulta);
				   while($fila = mysqli_fetch_array($rs))
				   {			   
						//Catodos
						$unid_cat = 0;
						$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as peso FROM sec_web.traspaso WHERE cod_producto  = 18 AND hornada = $fila[hornada]";
						$rs9 = mysqli_query($link, $Consulta);
						if($row9 = mysqli_fetch_array($rs9))
						{
							$unid_cat = $row9[unid];
						}				
						echo "unid_cat".$unid_cat;
						//Trasp-Benef
						$unid_trasp = 0;
						$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as peso FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto  = 18 AND hornada = $fila[hornada]";
						$rs8 = mysqli_query($link, $Consulta);
						if($row8 = mysqli_fetch_array($rs8))
						{
							$unid_trasp = $row8[unid];
						}												
						
						if(($unid_cat - $unid_trasp) > 0)
						{
							if (strlen($fila[hornada])==13)
							{
	                           $hornada = substr($fila[hornada],6,7);
							}
							else
							{
								$hornada = substr($fila[hornada],6,6);
							}
							$fechor  = substr($fila[hornada],0,6);
							if($txthornada == $hornada)
								echo'<option value="'.$hornada.'" selected>'.$hornada.'</option>';
							else
								echo'<option value="'.$hornada.'">'.$hornada.'</option>';
						}		
				   }
				   echo'</select>';
			   }	   

			   //LAMINAS Y DESP.
			   if($codigo == 48)
			   {	
				   $fecha = $ano1.'-'.$mes1.'-'.$dia1;	
		           $subproducto = substr($cmbproducto,2,2);

				   echo'<select name="txthornada" onChange="Buscar(this.form,2)">';
				   echo'<option value="0" selected>Seleccionar</option>';
				   $Consulta = "SELECT distinct hornada FROM sec_web.traspaso WHERE cod_producto = 48 AND cod_subproducto = $subproducto AND fecha_traspaso <= '$fecha' and sw = 1";
				   $rs = mysqli_query($link, $Consulta);
				   while($fila = mysqli_fetch_array($rs))
				   {			   
						//Laminas
						$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as peso FROM sec_web.traspaso WHERE cod_producto  = 48 AND hornada = $fila[hornada]";
					
						$rs9 = mysqli_query($link, $Consulta);
						if($row9 = mysqli_fetch_array($rs9))
						{
							$unid_cat = $row9[unid];
						}												
						//Trasp-Benef
						$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as peso FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto  = 48 AND hornada = $fila[hornada]";
						
						$rs8 = mysqli_query($link, $Consulta);
						if($row8 = mysqli_fetch_array($rs8))
						{
							$unid_trasp = $row8[unid];
						}												
						
						if(($unid_cat - $unid_trasp) > 0)
						{
							//$hornada = substr($fila[hornada],6,6);
							$hornada = substr($fila[hornada],6);
							$fechor  = substr($fila[hornada],0,6);
							if($txthornada == $hornada)
								echo'<option value="'.$hornada.'" selected>'.$hornada.'</option>';
							else
								echo'<option value="'.$hornada.'">'.$hornada.'</option>';
						}
					}								
			   }	   
			   
			   //LAMINAS.
			   if($codigo == 66)
			   {	
				   $fecha = $ano1.'-'.$mes1.'-'.$dia1;	
		           $subproducto = substr($cmbproducto,2,2);

				   echo'<select name="txthornada" onChange="Buscar(this.form,2)">';
				   echo'<option value="0" selected>Seleccionar</option>';
				   $Consulta = "SELECT distinct hornada FROM sec_web.traspaso WHERE cod_producto = 66 AND cod_subproducto = $subproducto AND fecha_traspaso <= '$fecha' and sw = 1";
				   $rs = mysqli_query($link, $Consulta);
				   while($fila = mysqli_fetch_array($rs))
				   {			   
						//Laminas
						$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as peso FROM sec_web.traspaso WHERE cod_producto  = 66 AND hornada = $fila[hornada]";

						$rs9 = mysqli_query($link, $Consulta);
						if($row9 = mysqli_fetch_array($rs9))
						{
							$unid_cat = $row9[unid];
						}												
						//Trasp-Benef
						$Consulta = "SELECT SUM(unidades) as unid, SUM(peso) as peso FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto  = 66 AND hornada = $fila[hornada]";
						$rs8 = mysqli_query($link, $Consulta);
						if($row8 = mysqli_fetch_array($rs8))
						{
							$unid_trasp = $row8[unid];
						}												
						
						if(($unid_cat - $unid_trasp) > 0)
						{
							$hornada = substr($fila[hornada],6,6);
							$fechor  = substr($fila[hornada],0,6);
							if($txthornada == $hornada)
								echo'<option value="'.$hornada.'" selected>'.$hornada.'</option>';
							else
								echo'<option value="'.$hornada.'">'.$hornada.'</option>';
						}
					}								
			   }	   			   

			?></td>
            <td width="65"><input name="btnbuscar" type="button" value="Buscar" onClick="Buscar(this.form,2)"></td>
            <td width="88">Peso Promedio</td>
            <td width="234">
			<?php
				if ($recargapag2 == "S")
					echo '<input name="peso_prom" type="text" style="background:#FFFFCC" size="10" value="'.round($pesopromedio,2).'" readonly></td>';
				else 
					echo '<input name="peso_prom" type="text" style="background:#FFFFCC" size="10" value="" readonly></td>';
				
			?>			
			</td>
          </tr>
        </table>
  <br>
  <table width="750" border="0" class="TablaDetalle">
<tr>
      <td align="center">
	  <?php
		if ($recargapag2 == "S")
		{
			echo'<input name="btngrabar" type="button" style="width=70" value="Grabar" onClick="Grabar(this.form)">';
		}
	  ?>	
	<input name="btnsaalir" type="button"  style="width=70" value="Salir" onClick="Salir()"></td>
    </tr>
  </table>
<?php
	if ($recargapag2 == "S")
	{
        $codigo = substr($cmbtipo,0,2);
		$subproducto = substr($cmbproducto,2,2);
		
		if($codigo == "16")//BLISTER
		{
		  echo'<br><table width="750" border="0" class="TablaDetalle">
				<tr class="ColorTabla01"> 
					<td width="83" rowspan="2" align="center">Lote/Horn.</td>
					<td colspan="2" align="center">Blister Recepcionado</td>
					<td width="83" rowspan="2" align="center">Todas</td>
					<td colspan="2" align="center">Traspaso RAF</td>
					<td colspan="2" align="center">Stock Final</td>
				</tr>
				<tr> 
					<td width="87" align="center">Unidades</td>
					<td width="95" align="center">Peso</td>
					<td width="91" align="center">Unidades</td>
					<td width="87" align="center">Peso</td>
					<td width="93" align="center">Unidades</td>
					<td width="97" align="center">Peso</td>
				</tr>';
		}
		if($codigo != "16" && $codigo != "48" && $codigo != "18" && $codigo != 66)//ANODOS
		{
		  echo'<br><table width="750" border="0" class="TablaDetalle">
				<tr class="ColorTabla01"> 
					<td width="83" rowspan="2" align="center">Hornada</td>
					<td colspan="2" align="center">Anodos Rechazados</td>
					<td width="83" rowspan="2" align="center">Todas</td>
					<td colspan="2" align="center">Traspaso RAF</td>
					<td colspan="2" align="center">Stock Final</td>
				</tr>
				<tr> 
					<td width="87" align="center">Unidades</td>
					<td width="95" align="center">Peso</td>
					<td width="91" align="center">Unidades</td>
					<td width="87" align="center">Peso</td>
					<td width="93" align="center">Unidades</td>
					<td width="97" align="center">Peso</td>
				</tr>';
		}
		if($codigo == "18" || $codigo == "48" || $codigo == "66")//CATODOS , DESPUNTES, LAMINAS
		{
		  echo'<br><table width="750" border="0" class="TablaDetalle">
				<tr class="ColorTabla01"> 
					<td width="83" rowspan="2" align="center">Lote/Horn.</td>
					<td colspan="2" align="center">Catodos A Raf</td>
					<td width="83" rowspan="2" align="center">Todas</td>
					<td colspan="2" align="center">Traspaso RAF</td>
					<td colspan="2" align="center">Stock Final</td>
				</tr>
				<tr> 
					<td width="87" align="center">Unidades</td>
					<td width="95" align="center">Peso</td>
					<td width="91" align="center">Unidades</td>
					<td width="87" align="center">Peso</td>
					<td width="93" align="center">Unidades</td>
					<td width="97" align="center">Peso</td>
				</tr>';
		}
		if ($boton == "1")
		{
			
			//BLISTER
			if($codigo == "16") 			
			{
				$consulta = "SELECT hornada, cod_subproducto, cod_producto FROM sea_web.movimientos"; 
				$consulta = $consulta." WHERE tipo_movimiento = 1  AND cod_producto = 16"; 
				$consulta = $consulta." AND cod_subproducto = '".$subproducto."' and fecha_movimiento <= '".$FechaC."'";
				
			}
			else
			{
				$consulta = "SELECT hornada, cod_subproducto, cod_producto FROM sea_web.movimientos"; 
				$consulta = $consulta." WHERE tipo_movimiento = 44 AND fecha_movimiento = '".$fecha."' AND cod_producto = 17"; 
		  		$consulta = $consulta." AND cod_subproducto = ".$cmbproducto;
				//echo "Hola".$consulta."<br>";
			}
		}
		else
		{

			if($codigo == "16" && $recargapag2 == "S")//BLISTER 			
			{
				if ($subproducto==4)
				{
					$consulta = "SELECT hornada,cod_subproducto,cod_producto,0 FROM sea_web.movimientos";
					$consulta.=" WHERE cod_producto = 16 AND cod_subproducto = ".$subproducto." AND right(hornada,8) = '".$txthornada."'";
					$consulta.=" and tipo_movimiento = 1 and fecha_movimiento <= '".$FechaC."'";
				}
				else
				{
					$consulta = "SELECT IFNULL(MAX(hornada_ventana),0) AS hornada FROM sea_web.hornadas";
					$consulta.=" WHERE cod_producto = 16 AND cod_subproducto = ".$subproducto." AND right(hornada_ventana,6) = '".$txthornada."'";
					$consulta.=" and fecha_movimiento <= '".$fecha2."'";
				}
			}
			if($codigo != "16" && $codigo != "48" && $codigo != "18" && $codigo != "66")//ANODOS			
			{
				$consulta = "SELECT IFNULL(MAX(hornada_ventana),0) AS hornada FROM sea_web.hornadas";
				$consulta = $consulta." WHERE cod_producto = 17 AND cod_subproducto = ".$cmbproducto." AND SUBSTRING(hornada_ventana,3,10) = ".$txthornada;

				//echo $consulta."<br>";
			}			
			if($codigo == "18")//CATODOS			
			{
				$consulta = "SELECT IFNULL(MAX(hornada),0) AS hornada FROM sec_web.traspaso";
				$consulta = $consulta." WHERE cod_producto = 18 AND cod_subproducto = ".$subproducto." AND substring(hornada,7) = '".$txthornada."'";
				//echo $consulta."<br>";
			}			
			if($codigo == "48")//LAMINAS			
			{
				$consulta = "SELECT IFNULL(MAX(hornada),0) AS hornada FROM sec_web.traspaso";
				$consulta = $consulta." WHERE cod_producto = 48 AND cod_subproducto = ".$subproducto."  AND SUBSTRING(hornada,7) = ".$txthornada;

			}
			if($codigo == "66")//LAMINAS APROBADAS.
			{
				$consulta = "SELECT IFNULL(MAX(hornada),0) AS hornada FROM sec_web.traspaso";
				$consulta = $consulta." WHERE cod_producto = 66 AND cod_subproducto = ".$subproducto."  AND SUBSTRING(hornada,7) = ".$txthornada;
				
				
			}						
		}
		if($codigo != "16"  && $codigo != "48" && $codigo != "18" && $codigo != "66")
		{
            //echo "ll".$consulta."</br>";
			$rs2 = mysqli_query($link, $consulta);
			$i = 0;
			$pos = 20;		
			while ($row2 = mysqli_fetch_array($rs2))
			{

				$anodos_rechazados = 0;// StockRechazo($row2[hornada],17,$cmbproducto);//llamo a la funcion de rechazos
				$peso_rechazado = 0;
			    if ($cmbproducto=='4' || $cmbproducto =='8')
				{

					$consulta ="select ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso from sea_web.movimientos where tipo_movimiento = '44' and ";
					$consulta.=" cod_producto = '17' and cod_subproducto = '".$cmbproducto."' and  hornada = ".$row2[hornada];
					$resC = mysqli_query($link, $consulta);
					//echo $consulta;
					if ($Fila = mysqli_fetch_array($resC))
					{
						$anodos_rechazados = $Fila["unidades"];
						$peso_rechazado = $Fila["peso"];
					}
					$consultaT ="select ifnull(sum(unidades),0) as unidades, ifnull(sum(peso),0) as peso from sea_web.movimientos where tipo_movimiento = '4' and ";
					$consultaT.=" cod_producto = '17' and cod_subproducto = '".$cmbproducto."' and  hornada = ".$row2[hornada];
					//echo $consultaT;
					$resCT = mysqli_query($link, $consultaT);
					if ($FilaT = mysqli_fetch_array($resCT))
					{
						if (($anodos_rechazados > 0) && ($anodos_rechazados >= $FilaT["unidades"]))
						{
							$anodos_rechazados = $anodos_rechazados - $FilaT["unidades"];
							$peso_rechazado = $peso_rechazado - $FilaT["peso"];
						}
					}
			
				}
				$anodos_buenos = StockActual($row2[hornada],17,$cmbproducto);//llamo a la funcion de stock
				if ($anodos_buenos == 0)
				{
					$anodos_rechazados = 0;
					$peso_rechazado = 0;
				}
				$peso_faltante = PesoFaltante(17,$cmbproducto,$row2[hornada]);			
				echo '<tr>';
				echo '<td align="center"><input name="hornada['.$i.']" type="hidden" value="'.$row2[hornada].'">'.substr($row2[hornada],6,4);			
				echo '<input name="unid_aux['.$i.']" type="hidden" size="10" value="'.$anodos_rechazados.'">';
				echo '<input name="peso_aux['.$i.']" type="hidden" size="10" value="'.$peso_rechazado.'"></td>';							
				echo '<td align="center"><input name="unid_recha['.$i.']" type="text" size="10" value="'.$anodos_rechazados.'" readonly></td>';
				echo '<td align="center"><input name="peso_recha['.$i.']" type="text" size="10" value="'.$peso_rechazado.'" readonly></td>';			
	
				echo '<td align="center"><input name="checkbox['.$i.']" type="checkbox" onClick="Mover(this.form,this,'.$pos.')"></td>';
				echo '<td align="center"><input name="unid_trasp['.$i.']" type="text" size="10" onBlur="Calcula(this.form,'.($pos+1).')"></td>';
				echo '<td align="center"><input name="peso_trasp['.$i.']" type="text" size="10"></td>';
				echo '<td align="center"><input name="unid_stock['.$i.']" type="text" size="10" value="'.$anodos_buenos.'" readonly></td>';
				echo '<td align="center"><input name="peso_stock['.$i.']" type="text" size="10" value="'.$peso_faltante.'" readonly></td>';
				
			
				echo '<input name="unid_final['.$i.']" type="hidden" size="10" value="'.$anodos_buenos.'">';
				echo '<input name="peso_stock['.$i.']" type="hidden" size="10" value="'.$peso_faltante.'">';
				
				
				echo '</tr>';
				$i++;
				$pos = 13;
			}
		}
		if($codigo == 16)//BLISTER
		{
			$rs2 = mysqli_query($link, $consulta);
			$i = 0;
			$pos = 20;
			//echo $consulta;
			$subproducto = substr($cmbproducto,2,2);		
			if ($row2 = mysqli_fetch_array($rs2))
			{
				$stock_unidades = 0;
				$stock_peso = 0;
				$consulta = "SELECT ifnull(SUM(unidades),0) as unidades, ifnull(SUM(peso),0) as peso_unidades FROM sea_web.movimientos WHERE fecha_movimiento <= '$fecha2' AND tipo_movimiento = 1 AND cod_producto = 16 AND hornada = ".$row2[hornada] ;
				//echo "hola2".$consulta;
				$rs4 = mysqli_query($link, $consulta);
				 if($row4 = mysqli_fetch_array($rs4))
				 {			
						$stock_unidades = $row4["unidades"];
						$stock_peso = $row4[peso_unidades];
						
					$consulta = "SELECT ifnull(SUM(unidades),0) as unidades, ifnull(SUM(peso),0) as peso FROM sea_web.movimientos WHERE fecha_movimiento <= '$fecha2' AND cod_producto = 16 AND tipo_movimiento = 4 AND hornada = ".$row2[hornada];
					//echo "hola3".$consulta;
					$rs3 = mysqli_query($link, $consulta);
					if($row3 = mysqli_fetch_array($rs3))
					{
						$stock_unidades = $stock_unidades - $row3["unidades"];
						$stock_peso =  $stock_peso - $row3["peso"];
					}	
					
					if ($stock_unidades > 0)
					{
						echo '<tr>';
							echo '<td align="center"><input name="hornada['.$i.']" type="hidden" value="'.$row2[hornada].'">'.substr($row2[hornada],2,8);			
							echo '<input name="unid_aux['.$i.']" type="hidden" size="10" value="'.$stock_unidades.'">';
							echo '<input name="peso_aux['.$i.']" type="hidden" size="10" value="'.$stock_peso.'"></td>';							
							echo '<td align="center"><input name="unid_recha['.$i.']" type="text" size="10" value="'.$stock_unidades.'" readonly></td>';
							echo '<td align="center"><input name="peso_recha['.$i.']" type="text" size="10" value="'.$stock_peso.'" readonly></td>';
				
							echo '<td align="center"><input name="checkbox['.$i.']" type="checkbox" onClick="Mover(this.form,this,'.$pos.')"></td>';
							echo '<td align="center"><input name="unid_trasp['.$i.']" type="text" size="10" onBlur="Calcula(this.form,'.($pos+1).')"></td>';
							echo '<td align="center"><input name="peso_trasp['.$i.']" type="text" size="10"></td>';
					
							echo '<td align="center"><input name="unid_stock['.$i.']" type="text" size="10" value="'.$stock_unidades.'" readonly></td>';
							echo '<td align="center"><input name="peso_stock['.$i.']" type="text" size="10" value="'.$stock_peso.'" readonly></td>';
						
					
							echo '<input name="unid_final['.$i.']" type="hidden" size="10" value="'.$stock_unidades.'">';
							echo '<input name="peso_stock['.$i.']" type="hidden" size="10" value="'.$stock_peso.'">';
						
						
						echo '</tr>';
						$i++;
						$pos = 13;
					}
				}
		
			}			
	
		}

		if($codigo == 18)//CATODOS
		{
			$rs2 = mysqli_query($link, $consulta);
			$i = 0;
			$pos = 20;

			$subproducto = substr($cmbproducto,2,2);		
			if ($row2 = mysqli_fetch_array($rs2))
			{
				$stock_unidades = 0;
				$stock_peso = 0;
				$fecha2 = $ano1.'-'.$mes1.'-'.$dia1;
				$txthorno = substr($row2[hornada],6);
				$consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso_unidades FROM sec_web.traspaso WHERE fecha_traspaso <= '$fecha2' AND cod_producto = 18 AND cod_subproducto = $subproducto";
				if ($txthorno=='100108')
				{
					$jcf = 1;
					$consulta.= " AND hornada = '200808100108'";
				}
				else
				{
					$consulta.= " and hornada = '".$row2[hornada]."'";
				}
				$rs4 = mysqli_query($link, $consulta);
				//echo $consulta."--".$txthorno;
	
				 if($row4 = mysqli_fetch_array($rs4))
				 {			
					if ($jcf==1)
					{
						$consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso FROM sea_web.movimientos WHERE fecha_movimiento <= '$fecha2' AND cod_producto = 18 AND cod_subproducto = $subproducto AND tipo_movimiento = 4 AND hornada = '200808100108'";
					}
					else
					{
						$consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso FROM sea_web.movimientos WHERE fecha_movimiento <= '$fecha2' AND cod_producto = 18 AND cod_subproducto = $subproducto AND tipo_movimiento = 4 AND hornada = ".$row2[hornada];
					}
					$rs3 = mysqli_query($link, $consulta);
					if($row3 = mysqli_fetch_array($rs3))
					{
						$stock_unidades = $row4["unidades"] - $row3["unidades"];
						$stock_peso = $row4[peso_unidades] - $row3["peso"];
					}	
					echo '<tr>';
						if (strlen($row2[hornada])==12)
						{
							echo '<td align="center"><input name="hornada['.$i.']" type="hidden" value="'.$row2[hornada].'">'.substr($row2[hornada],6,6);	
						}
						else
						{		
							echo '<td align="center"><input name="hornada['.$i.']" type="hidden" value="'.$row2[hornada].'">'.substr($row2[hornada],6,7);	
						}
						echo '<input name="unid_aux['.$i.']" type="hidden" size="10" value="'.$stock_unidades.'">';
						echo '<input name="peso_aux['.$i.']" type="hidden" size="10" value="'.$stock_peso.'"></td>';							
						echo '<td align="center"><input name="unid_recha['.$i.']" type="text" size="10" value="'.$stock_unidades.'" readonly></td>';
						echo '<td align="center"><input name="peso_recha['.$i.']" type="text" size="10" value="'.$stock_peso.'" readonly></td>';
				
						echo '<td align="center"><input name="checkbox['.$i.']" type="checkbox" onClick="Mover(this.form,this,'.$pos.')"></td>';
						echo '<td align="center"><input name="unid_trasp['.$i.']" type="text" size="10" onBlur="Calcula(this.form,'.($pos+1).')"></td>';
						echo '<td align="center"><input name="peso_trasp['.$i.']" type="text" size="10"></td>';
					
						echo '<td align="center"><input name="unid_stock['.$i.']" type="text" size="10" value="'.$stock_unidades.'" readonly></td>';
						echo '<td align="center"><input name="peso_stock['.$i.']" type="text" size="10" value="'.$stock_peso.'" readonly></td>';
						
					
						echo '<input name="unid_final['.$i.']" type="hidden" size="10" value="'.$stock_unidades.'">';
						echo '<input name="peso_stock['.$i.']" type="hidden" size="10" value="'.$stock_peso.'">';
						
						
						echo '</tr>';
						$i++;
						$pos = 13;
				}
		
			}			
	
		}
		if($codigo == 48)//LAMINAS
		{
			$rs2 = mysqli_query($link, $consulta);
			$i = 0;
			$pos = 20;

			$subproducto = substr($cmbproducto,2,2);		
			if ($row2 = mysqli_fetch_array($rs2))
			{
				$stock_unidades = 0;
				$stock_peso = 0;
				$fecha2 = $ano1.'-'.$mes1.'-'.$dia1;
				$consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso_unidades FROM sec_web.traspaso WHERE fecha_traspaso <= '$fecha2' AND cod_producto = 48 AND cod_subproducto = $subproducto AND hornada = ".$row2[hornada] ;
				$rs4 = mysqli_query($link, $consulta);

	
				 if($row4 = mysqli_fetch_array($rs4))
				 {			

					$consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso FROM sea_web.movimientos WHERE fecha_movimiento <= '$fecha2' AND cod_producto = 48 AND cod_subproducto = $subproducto AND tipo_movimiento = 4 AND hornada = ".$row2[hornada];
					$rs3 = mysqli_query($link, $consulta);
					if($row3 = mysqli_fetch_array($rs3))
					{
						$stock_unidades = $row4["unidades"] - $row3["unidades"];
						$stock_peso = $row4[peso_unidades] - $row3["peso"];
					}	
					echo '<tr>';
						echo '<td align="center"><input name="hornada['.$i.']" type="hidden" value="'.$row2[hornada].'">'.substr($row2[hornada],6,6);			
						echo '<input name="unid_aux['.$i.']" type="hidden" size="10" value="'.$stock_unidades.'">';
						echo '<input name="peso_aux['.$i.']" type="hidden" size="10" value="'.$stock_peso.'"></td>';							
						echo '<td align="center"><input name="unid_recha['.$i.']" type="text" size="10" value="'.$stock_unidades.'" readonly></td>';
						echo '<td align="center"><input name="peso_recha['.$i.']" type="text" size="10" value="'.$stock_peso.'" readonly></td>';
				
						echo '<td align="center"><input name="checkbox['.$i.']" type="checkbox" onClick="Mover(this.form,this,'.$pos.')"></td>';
						echo '<td align="center"><input name="unid_trasp['.$i.']" type="text" size="10" onBlur="Calcula(this.form,'.($pos+1).')"></td>';
						echo '<td align="center"><input name="peso_trasp['.$i.']" type="text" size="10"></td>';
					
						echo '<td align="center"><input name="unid_stock['.$i.']" type="text" size="10" value="'.$stock_unidades.'" readonly></td>';
						echo '<td align="center"><input name="peso_stock['.$i.']" type="text" size="10" value="'.$stock_peso.'" readonly></td>';
						
					
						echo '<input name="unid_final['.$i.']" type="hidden" size="10" value="'.$stock_unidades.'">';
						echo '<input name="peso_stock['.$i.']" type="hidden" size="10" value="'.$stock_peso.'">';
						
						
						echo '</tr>';
						$i++;
						$pos = 13;
				}
		
			}			
	
		}
		
		//LAMIANAS APROBADAS.
		if($codigo == 66)//LAMINAS
		{
			$rs2 = mysqli_query($link, $consulta);
			$i = 0;
			$pos = 20;

			$subproducto = substr($cmbproducto,2,2);		
			if ($row2 = mysqli_fetch_array($rs2))
			{
				$stock_unidades = 0;
				$stock_peso = 0;
				$fecha2 = $ano1.'-'.$mes1.'-'.$dia1;
				$consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso_unidades FROM sec_web.traspaso WHERE fecha_traspaso <= '$fecha2' AND cod_producto = 66 AND cod_subproducto = $subproducto AND hornada = ".$row2[hornada] ;
				//echo $consulta."<br>";
				$rs4 = mysqli_query($link, $consulta);

	
				 if($row4 = mysqli_fetch_array($rs4))
				 {			

					$consulta = "SELECT SUM(unidades) as unidades, SUM(peso) as peso FROM sea_web.movimientos WHERE fecha_movimiento <= '$fecha2' AND cod_producto = 66 AND cod_subproducto = $subproducto AND tipo_movimiento = 4 AND hornada = ".$row2[hornada];
					$rs3 = mysqli_query($link, $consulta);
					if($row3 = mysqli_fetch_array($rs3))
					{
						$stock_unidades = $row4["unidades"] - $row3["unidades"];
						$stock_peso = $row4[peso_unidades] - $row3["peso"];
					}	
					echo '<tr>';
						echo '<td align="center"><input name="hornada['.$i.']" type="hidden" value="'.$row2[hornada].'">'.substr($row2[hornada],6,6);			
						echo '<input name="unid_aux['.$i.']" type="hidden" size="10" value="'.$stock_unidades.'">';
						echo '<input name="peso_aux['.$i.']" type="hidden" size="10" value="'.$stock_peso.'"></td>';							
						echo '<td align="center"><input name="unid_recha['.$i.']" type="text" size="10" value="'.$stock_unidades.'" readonly></td>';
						echo '<td align="center"><input name="peso_recha['.$i.']" type="text" size="10" value="'.$stock_peso.'" readonly></td>';
				
						echo '<td align="center"><input name="checkbox['.$i.']" type="checkbox" onClick="Mover(this.form,this,'.$pos.')"></td>';
						echo '<td align="center"><input name="unid_trasp['.$i.']" type="text" size="10" onBlur="Calcula(this.form,'.($pos+1).')"></td>';
						echo '<td align="center"><input name="peso_trasp['.$i.']" type="text" size="10"></td>';
					
						echo '<td align="center"><input name="unid_stock['.$i.']" type="text" size="10" value="'.$stock_unidades.'" readonly></td>';
						echo '<td align="center"><input name="peso_stock['.$i.']" type="text" size="10" value="'.$stock_peso.'" readonly></td>';
						
					
						echo '<input name="unid_final['.$i.']" type="hidden" size="10" value="'.$stock_unidades.'">';
						echo '<input name="peso_stock['.$i.']" type="hidden" size="10" value="'.$stock_peso.'">';
						
						
						echo '</tr>';
						$i++;
						$pos = 13;
				}
		
			}			
	
		}				
		echo'</table>';

	}
?>
  
<?php
	//Campo Oculto.
	echo '<input name="tipo_boton" type="hidden" value="'.$boton.'">';
?>  
</form></td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</body>
</html>
<?php 	include("../principal/cerrar_sea_web.php") ?>
