<?php
 include("../principal/conectar_sea_web.php");

if(isset($_REQUEST["Proceso"])) {
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso = "";
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

if(isset($_REQUEST["cmbproductos"])) {
	$cmbproductos = $_REQUEST["cmbproductos"];
}else{
	$cmbproductos = "";
}
$hornada_aux = isset($_REQUEST["hornada_aux"])?$_REQUEST["hornada_aux"]:"";

 $fecha = $ano.'-'.$mes.'-'.$dia;	
 $FechaInicio=$ano.'-'.$mes.'-'.$dia." 08:00:00";
 $FechaTermino =date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano))." 07:59:59";
 $fecha2 = date("Y-m-d", mktime(1,0,0,$mes,($dia +1),$ano));

 if($Proceso == "E")
 {
	 $Eliminar ="DELETE FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 16 ";
	 $Eliminar.="AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."'";	 
	 $Eliminar.="AND hornada = $hornada_aux";
  	 mysqli_query($link, $Eliminar); 			
 }

 if($Proceso == "E1")
 {
	 $Eliminar ="DELETE FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 18 ";
	 $Eliminar.="AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."' ";	 
	 $Eliminar.="AND hornada = $hornada_aux";
  	 mysqli_query($link, $Eliminar); 			
 }

 if($Proceso == "E2")
 {
	 $Eliminar ="DELETE FROM sea_web.movimientos WHERE tipo_movimiento = 4 AND cod_producto = 48 ";
	 $Eliminar.="AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."' ";	 
	 $Eliminar.="AND hornada = $hornada_aux";
  	 mysqli_query($link, $Eliminar); 			
 }

?>

<html>
<head>
<title>Busqueda de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function Proceso(opt)
{
	var f = document.frmPoPup;
	switch (opt)
	{
		case 0:
			Eliminar;
			break;
		case 1:
			Eliminar1;
			break;
		case 2:
			Eliminar2;
			break;
	}
}
function ValidaSeleccion(Nombre)
{
	var f = frmPoPup;
	var LargoForm = f.elements.length;
	var valor = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			valor = f.elements[i].value;
		}
	}
	return valor;
}
//*********************//
function Eliminar()
{
	var valor = ValidaSeleccion('radio');
	var f = frmPoPup;
	var fecha;
	
	if(valor != '')
	{
	    f.action="sea_ing_anodos_trasp_raf02.php?Proceso=E&hornada_aux="+valor;
		f.submit();
    }
	else
	{
		alert('No hay Movimiento Seleccionado');
		return
    }
}

function Eliminar1()
{
	var valor = ValidaSeleccion('radio');
	var f = frmPoPup;
	var fecha;
	
	if(valor != '')
	{
	    f.action="sea_ing_anodos_trasp_raf02.php?Proceso=E1&hornada_aux="+valor;
		f.submit();
    }
	else
	{
		alert('No hay Movimiento Seleccionado');
		return
    }
}

function Eliminar2()
{
	var valor = ValidaSeleccion('radio');
	var f = frmPoPup;
	var fecha;
	
	if(valor != '')
	{
	    f.action="sea_ing_anodos_trasp_raf02.php?Proceso=E2&hornada_aux="+valor;
		f.submit();
    }
	else
	{
		alert('No hay Movimiento Seleccionado');
		return
    }
}

function buscar_datos()
{
var f = frmPoPup;

    f.action="sea_ing_anodos_trasp_raf02.php?Proceso=B";
	f.submit();
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <div align="left"> 
    <table width="500" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaPrincipal" >
      <tr class="ColorTabla02"> 
        <td colspan="3"><div align="center">Busqueda de Datos</div></td>
      </tr>
      <tr> 
        <td width="108" height="32">Fecha Busqueda</td>
        <td width="213"><font color="#000000" size="2"> 
          <select name="dia" size="1" style="font-face:verdana;font-size:10">
            <?php
			if($Proceso=='B' || $Proceso=='E')
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
          </select>
          </font> 
          <select name="mes" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
            <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B' || $Proceso=='E')
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
          </select>
          <select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
            <?php
	if($Proceso=='B' || $Proceso=='E')
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
          </select>
      <tr>
		 	<td>Producto</td>
		 	<td>
		    <select name="cmbproductos" style="width:200">
			<?php
            echo '<option  value = "-1" selected>VER TODOS</option>';			
			$consulta = "SELECT * FROM subproducto WHERE cod_producto = '17'";
   	        include("../principal/conectar_principal.php");
			$rs = mysqli_query($link, $consulta);

			while ($row = mysqli_fetch_array($rs))
			{			
			if ($row['cod_subproducto'] == $cmbproductos and ($Proceso == 'B'))
				echo '<option value="'.$row['cod_subproducto'].'" selected>'.$row['abreviatura'].'</option>';
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
					echo '<option value="16'.$row["cod_subclase"].'" selected>'.$row["nombre_subclase"].'</option>';
				else 
					echo '<option value="16'.$row["cod_subclase"].'">'.$row["nombre_subclase"].'</option>';
			}	
			echo '<option value="0">--------------------</option>';
			
			//CATODOS
			$Consulta="select * from subproducto where cod_producto = 18 and cod_subproducto in(2,4,5,6,8,9,10)"; 
			$rs = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($rs))
			{
				if ($cmbproductos == '18'.$Fila["cod_subproducto"])
				{
					echo "<option value = '18".$Fila["cod_subproducto"]."' selected>".$Fila["descripcion"]."</option>\n";
				}
				else
				{
					echo "<option value = '18".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
				}	
			}	
			
			echo '<option value="0">--------------------</option>';

			//LAMINAS
			//mf $Consulta="select * from subproducto where cod_producto = 48 and cod_subproducto in(1,2,3,7,10)";
			$Consulta="select * from subproducto where cod_producto = 48 and cod_subproducto in(1,2,3,7,10,8,9)";
			
			$rs = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($rs))
			{
				if ($cmbproductos == '48'.$Fila["cod_subproducto"])
				{
					echo "<option value = '48".$Fila["cod_subproducto"]."' selected>".$Fila["descripcion"]."</option>\n";
				}
				else
				{
					echo "<option value = '48".$Fila["cod_subproducto"]."'>".$Fila["descripcion"]."</option>\n";
				}	
			}					
					
			?>
			</select>
			</td>
        <td width="159">&nbsp;</td>
      </tr>
      <tr align="center">
        <td colspan="3"><input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_datos();">         
		<?php
			$codigo = substr($cmbproductos,0,2);
		 	if($codigo == 16)
			  echo'<input name="btneliminar" type="button" style="width:70" value="Eliminar" onClick="Eliminar()">';		 
		 	if($codigo == 18)
			  echo'<input name="btneliminar" type="button" style="width:70" value="Eliminar" onClick="Eliminar1()">';		
		 	if($codigo == 48)
			  echo'<input name="btneliminar" type="button" style="width:70" value="Eliminar" onClick="Eliminar2()">';
		 ?>
          <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="self.close()"></td>
      </tr>
    </table>
<?php
/*$FechaInicio=$ano.'-'.$mes.'-'.$dia." 08:00:00";
$FechaTermino =date("Y-m-d", mktime(0,0,0,$mes,($dia +1),$ano))." 07:59:59";
$fecha2 = date("Y-m-d", mktime(0,0,0,$mes,($dia +1),$ano));*/

if (($Proceso == 'B' && $codigo != 16 && $codigo != 18 && $codigo != 48) || $cmbproductos == -1)
{
	$fecha = $ano.'-'.$mes.'-'.$dia;
	$arreglo = array();
	$consulta = "SELECT distinct cod_producto, cod_subproducto, flujo FROM proyecto_modernizacion.relacion_prod_flujo_nodo ";
	$consulta.= " WHERE cod_producto = 17 ";
	if ($cmbproductos != -1)
		$consulta.= " AND cod_subproducto = '".$cmbproductos."' ";
	$consulta.= " AND cod_proceso = 4";
	$consulta.= " order by cod_producto, cod_subproducto";
	//echo $consulta;
	$rs1 = mysqli_query($link, $consulta);		
	while ($row1 = mysqli_fetch_array($rs1))
	{
		$arreglo[] = array($row1["flujo"], $row1["cod_producto"], $row1["cod_subproducto"]);
	}
   	$largo = 500; //Largo de la Tabla.
	echo '<table width="'.$largo.'"  border="1" cellspacing="0" cellpadding="0" align="center">';
	if ($cmbproductos == -1)
		echo "<tr><td align='center' colspan='8'>";
	else
		echo "<tr><td align='center' colspan='7'>";
	echo "ANODOS</td></tr>";
	echo '<tr class="ColorTabla01">';
	if ($cmbproductos == -1)
		echo '<td width="130" align="center">PRODUCTO</td>';
	echo '<td width="70" align="center">FECHA</td>';
	echo '<td width="70" align="center">N&deg; HORNADA</td>';
	echo '<td width="70"align="center">CANTIDAD</td>';
	echo '<td width="70" align="center">PESO<br>KGS.</td>';
	echo '<td width="70" align="center">As</td>';
	echo '<td width="70" align="center">Sb</td>';
	echo '<td width="70" align="center">Bi</td></tr>';

	// Saca todos los movimientos de recepcion afectados.
	reset($arreglo);
	//while (list($clave, $valor) = each($arreglo)) // (0: flujo, 1: cod_producto, 2: cod_subproducto, 3: horno_inicial)
	foreach ($arreglo as $clave =>$valor) 
	{
		$ContReg=0;$TotAS=0;$TotSB=0;$TotBI=0;$ContRegAS=0;$ContRegSB=0;$ContRegBI=0;
		$consulta = "SELECT distinct hornada FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 4 ";
		$consulta = $consulta." AND cod_producto = '".$valor[1]."' ";		
		$consulta = $consulta." AND cod_subproducto = '".$valor[2]."'";
		$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
        $consulta = $consulta." ORDER BY hornada";
		$rs2 = mysqli_query($link, $consulta);						       	   
		//Crea el detalle.
		$TieneDet = false;								
		while ($row2 = mysqli_fetch_array($rs2))
		{		
			$TieneDet = true;
			echo "<tr>\n";										  
			if ($cmbproductos == -1)
			{
				$Consulta = "select * from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto = '".$valor[1]."' and cod_subproducto = '".$valor[2]."'";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					echo "<td>".strtoupper($Fila["abreviatura"])."</td>\n";
				}
				else
				{
					echo "<td>&nbsp;</td>\n";
				}
			}
			echo '<td width="130"><center>'.$fecha.'</center></td>';
			echo '<td width="130" align="center">'.substr($row2["hornada"],6,6).'</td>';
			echo '<td width="130" align="center">';
			$consulta = "SELECT SUM(unidades) as unidades FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = '".$valor[1]."' AND cod_subproducto = '".$valor[2]."'";
			$consulta = $consulta." AND hornada = '".$row2["hornada"]."' AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."' ";
			$rs_u = mysqli_query($link, $consulta);
			if($row_u = mysqli_fetch_array($rs_u))
			{ 
				echo $row_u["unidades"].'</td>';
			}
			echo '<td width="130" align="center">';
			$consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = '".$valor[1]."' AND cod_subproducto = '".$valor[2]."'";
			$consulta = $consulta." AND hornada = '".$row2["hornada"]."' AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '".$FechaInicio."' and '".$FechaTermino."' ";
			$rs_p = mysqli_query($link, $consulta);
			if($row_p = mysqli_fetch_array($rs_p))
			{ 
				echo $row_p["peso"]."</td>";
			}
			$Encontro=false;
			$Consulta="select * from sea_web.leyes_por_hornada where hornada = '".$row2["hornada"]."' and cod_leyes in ('08', '09', '27') and cod_producto = '".$valor[1]."' and cod_subproducto = '".$valor[2]."'";
			$Resp=mysqli_query($link, $Consulta);
			while($Fila=mysqli_fetch_array($Resp))
			{
				$Encontro=true;
				echo '<td width="40" align="center">&nbsp;'.number_format($Fila["valor"],2,',','.').'</td>';
				switch($Fila["cod_leyes"])
				{
					case "08":
						$TotAS=$TotAS+$Fila["valor"];
						$ContRegAS++;
						break;
					case "09":
						$TotSB=$TotSB+$Fila["valor"];
						$ContRegSB++;
						break;
					case "27":
						$TotBI=$TotBI+$Fila["valor"];
						$ContRegBI++;
						break;
				}
			}
			if($Encontro==false)
			{
				echo '<td width="50" align="center">&nbsp;</td>';
				echo '<td width="50" align="center">&nbsp;</td>';
				echo '<td width="50" align="center">&nbsp;</td>';				
			}
			$ContReg++;
			echo "</tr>\n";
		}		
		//TOTALES
		if ($TieneDet)
		{
			$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) as peso";
			$consulta.= " FROM sea_web.movimientos";
			$consulta.= " WHERE tipo_movimiento = 4 AND cod_producto = '".$valor[1]."' AND cod_subproducto = '".$valor[2]."'";
			$consulta.= " AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs3 = mysqli_query($link, $consulta);
			if ($cmbproductos==-1) 
				echo "<tr class='ColorTabla02'><td width='260' colspan='3'>"; 
			else
				echo "<tr class='ColorTabla02'><td width='260' colspan='2'>"; 	
			echo "TOTAL PRODUCTO</td>";				
			$row3 = mysqli_fetch_array($rs3);
			if (!is_null($row3["unid"]))					
			{  
				
				if ($ContRegAS==0)
				{
					$ContRegAS=1;
				}
				if ($ContRegSB==0)
				{
					$ContRegSB=1;
				}
				if ($ContRegBI==0)
				{
					$ContRegBI=1;
				}
				echo '<td width="130" align="center">'.$row3["unid"].'</td>';
				echo '<td width="130" align="center">'.number_format($row3["peso"],0,'','').'</td>';
				echo '<td width="100" align="center">'.number_format($TotAS/$ContRegAS,2,',','.').'</td>';
				echo '<td width="100" align="center">'.number_format($TotSB/$ContRegSB,2,',','.').'</td>';
				echo '<td width="100" align="center">'.number_format($TotBI/$ContRegBI,2,',','.').'</td>';
			} 	
			echo "</tr>\n";	   				
		}
	}
	echo "</table><br>\n";	
}

$SubProd = $cmbproductos;
//echo " Subprod mf ".$SubProd;

//BLISTER
if ((($Proceso == 'B' || $Proceso == 'E') && $codigo == 16) || $cmbproductos == -1)
{
	$fecha = $ano.'-'.$mes.'-'.$dia;
	$cmbproductos = substr($cmbproductos,2,1) ;
   	$largo = 500; //Largo de la Tabla.
	echo '<table width="'.$largo.'"  border="1" cellspacing="0" cellpadding="0" align="center">';
	if ($SubProd == -1)
		echo "<tr><td align='center' colspan='6'>";
	else
		echo "<tr><td align='center' colspan='5'>";
	echo "BLISTER</td></tr>";
	echo '<tr class="ColorTabla01"><td width="50" align="center">&nbsp;</td>';
	if ($SubProd == -1)
		echo '<td width="130" align="center">PRODUCTO</td>';
	echo '<td width="130" align="center">FECHA</td>';
	echo '<td width="130" align="center">LOTE/HORNADA</td>';
	echo '<td width="130"align="center">CANTIDAD</td>';
	echo '<td width="130" align="center">PESO<br>KGS.</td></tr>';
	// Saca todos los movimientos de recepcion afectados.   
    $consu = "SELECT * FROM proyecto_modernizacion.subproducto ";
	$consu.= " where cod_producto = 16 ";
	if ($SubProd != -1)
		$consu.= " and ap_subproducto = '".$cmbproductos."'";
	$consu.= "order by cod_producto, cod_subproducto";
    $rsj = mysqli_query($link, $consu);
    while($rowj = mysqli_fetch_array($rsj))
    {        
        $cmbproductos  = $rowj['cod_subproducto'];
	    $consulta = "SELECT distinct hornada FROM sea_web.movimientos";
	    $consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 16 and cod_subproducto = '".$rowj["cod_subproducto"]."'";
	    $consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
	    $consulta = $consulta." ORDER BY hornada";
	    $rs2 = mysqli_query($link, $consulta);
	    //Crea el detalle.
		$control_mov  = 0;	   
	    while ($row2 = mysqli_fetch_array($rs2))
	    {
		    $control_mov = $control_mov + 1;
			echo '<tr>';
			if ($SubProd==-1)
			{
				$Consulta = "select * from proyecto_modernizacion.subproducto ";
				$Consulta.= " where cod_producto = '".$rowj['cod_producto']."' and cod_subproducto = '".$rowj['cod_subproducto']."'";
				$Resp = mysqli_query($link, $Consulta);
				if ($Fila = mysqli_fetch_array($Resp))
				{
					echo '<td align="center"><input type="radio" name="radio" value="'.$row2["hornada"].'"></td>';
					echo '<td align="center">'.strtoupper($Fila["abreviatura"]).'</td>';
				}
				else
				{
					echo '<td align="center"><input type="radio" name="radio" value="'.$row2["hornada"].'"></td>';
					echo '<td align="center">&nbsp;</td>';
				}
				echo '<td align="center">'.$fecha.'</td>';
			}
			else
			{
				echo '<td align="center"><input type="radio" name="radio" value="'.$row2["hornada"].'"></td>';
				echo '<td align="center">'.$fecha.'</td>';
			}
			
			// mf ***
			if ((strlen($row2["hornada"]) == 3) && $rowj["cod_subproducto"] == 24)
			{
				echo '<td width="130" align="center">'.$row2["hornada"].'</td>';
			}
			else
			{
				echo '<td width="130" align="center">'.substr($row2["hornada"],3,6).'</td>';
			}
			// ***
			echo '<input type="hidden" name="hornada" value="'.$row2["hornada"].'">';
			echo '<td width="130" align="center">';		
			$consulta = "SELECT SUM(unidades) as unidades FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 16 and cod_subproducto = '".$rowj["cod_subproducto"]."'";
			$consulta = $consulta." AND hornada = '".$row2["hornada"]."' AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs_u = mysqli_query($link, $consulta);
			if($row_u = mysqli_fetch_array($rs_u))
			{ 
					echo $row_u["unidades"].'</td>';
			}
			echo '<td width="130" align="center">';
			$consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 16 and cod_subproducto = '".$rowj["cod_subproducto"]."'";
			$consulta = $consulta." AND hornada = '".$row2["hornada"]."' AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs_p = mysqli_query($link, $consulta);
			if($row_p = mysqli_fetch_array($rs_p))
			{ 
				echo $row_p["peso"]."</td>\n";
			}
			echo "</tr>\n";
	    }
		//TOTALES BLISTER		
		if ($control_mov != 0)
		{	
			$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) as peso";
			$consulta = $consulta." FROM sea_web.movimientos";
			$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 16 and cod_subproducto = '".$rowj["cod_subproducto"]."'";
			$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
			$rs3 = mysqli_query($link, $consulta);
			if ($SubProd == -1)
				echo "<tr class='ColorTabla02'><td width='260' colspan='4'>";
			else
				echo "<tr class='ColorTabla02'><td width='260' colspan='3'>";
			echo "TOTAL PRODUCTO</td>";				
			$row3 = mysqli_fetch_array($rs3);
			if (!is_null($row3["unid"]))					
			{  
				echo "<td width='130' align='center'>".$row3["unid"]."</td>";
				echo "<td width='130' align='center'>".number_format($row3["peso"],0,'','')."</td>";				
			} 	
			echo "</tr>\n";
		}			
     }
	 echo "</table><br>";
}

if ((($Proceso == 'B' || $Proceso == 'E') && $codigo == 18) || $SubProd == -1)//CATODOS
{
	$fecha = $ano.'-'.$mes.'-'.$dia;
   	$largo = 500; //Largo de la Tabla.
	echo '<table width="'.$largo.'"  border="1" cellspacing="0" cellpadding="0" align="center">';
	if ($SubProd == -1)
		echo "<tr><td align='center' colspan='6'>";
	else
		echo "<tr><td align='center' colspan='5'>";
	echo "CATODOS</td></tr>";
	echo '<tr class="ColorTabla01"><td width="50" align="center">&nbsp;</td>';
	if ($SubProd == -1)
		echo '<td width="130" align="center">PRODUCTO</td>';
	echo '<td width="130" align="center">FECHA</td>';
	echo '<td width="130" align="center">LOTE/HORNADA</td>';
	echo '<td width="130"align="center">CANTIDAD</td>';
	echo '<td width="130" align="center">PESO<br>KGS.</td></tr>';
	$subproducto = substr($cmbproductos,2,2);
	$consulta = "SELECT distinct cod_producto, cod_subproducto, hornada FROM sea_web.movimientos";
	$consulta.= " WHERE tipo_movimiento = 4 AND cod_producto = 18 ";
	if ($SubProd != -1)
		$consulta.= " AND cod_subproducto = '".$subproducto."'";
	$consulta.= " AND fecha_movimiento between '".$fecha."' and '".$fecha2."' ";
	$consulta.= " AND hora between '$FechaInicio' and '$FechaTermino'";
	$consulta.= " ORDER BY hornada";
	//echo $consulta."<br>";
	$rs2 = mysqli_query($link, $consulta);						       	   
	//Crea el detalle.	
	$TieneDet = false;					
	while ($row2 = mysqli_fetch_array($rs2))
	{
		$TieneDet = true;															  
		echo "<tr>";
		if ($SubProd==-1)
		{
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto = '".$row2["cod_producto"]."' and cod_subproducto = '".$row2["cod_subproducto"]."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				echo '<td align="center"><input type="radio" name="radio" value="'.$row2["hornada"].'"></td>';
				echo '<td align="center">'.strtoupper($Fila["abreviatura"]).'</td>';
			}
			else
			{
				echo '<td align="center"><input type="radio" name="radio" value="'.$row2["hornada"].'"></td>';
				echo '<td align="center">&nbsp;</td>';
			}			
			echo '<td align="center">'.$fecha.'</td>';
		}
		else
		{
			echo '<td align="center"><input type="radio" name="radio" value="'.$row2["hornada"].'"></td>';
			echo '<td align="center">'.$fecha.'</td>';
		}				
		echo '<td width="130" align="center">'.substr($row2["hornada"],6,6).'</td>';
		echo '<input type="hidden" name="hornada" value="'.$row2["hornada"].'">';
		echo '<td width="130" align="center">';		
		$consulta = "SELECT SUM(unidades) as unidades FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 18 AND cod_subproducto = '".$row2["cod_subproducto"]."'";
		$consulta = $consulta." AND hornada = '".$row2["hornada"]."' AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
		$rs_u = mysqli_query($link, $consulta);
		if($row_u = mysqli_fetch_array($rs_u))
		{ 
			echo $row_u["unidades"].'</td>';
		}
		echo '<td width="130" align="center">';
		$consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 18 AND cod_subproducto = '".$row2["cod_subproducto"]."'";
		$consulta = $consulta." AND hornada = '".$row2["hornada"]."' AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
		$rs_p = mysqli_query($link, $consulta);
		if($row_p = mysqli_fetch_array($rs_p))
		{ 
			echo $row_p["peso"]."</td>";
		}
		echo "</tr>";
	}			
	//TOTALES CATODOS
	if ($TieneDet)
	{
		if ($SubProd == -1)
			echo '<tr class="ColorTabla02"><td width="260" colspan="4">'; 
		else
			echo '<tr class="ColorTabla02"><td width="260" colspan="3">'; 
		echo "TOTAL PRODUCTO</td>";		
		$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) as peso";
		$consulta = $consulta." FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 18 ";
		if ($SubProd != -1)
			$consulta = $consulta." AND cod_subproducto = '".$subproducto."'";
		$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
		$rs3 = mysqli_query($link, $consulta);	
		$row3 = mysqli_fetch_array($rs3);
		if (!is_null($row3["unid"]))					
		{  
			echo '<td width="130" align="center">'.$row3["unid"].'</td>';
			echo '<td width="130" align="center">'.number_format($row3["peso"],0,'','').'</td>';		
		} 
	}
	echo '</tr></table><br>';	   				
}

//LAMINAS
if ((($Proceso == 'B' || $Proceso == 'E') && $codigo == 48) || $SubProd == -1)
{
	$fecha = $ano.'-'.$mes.'-'.$dia;
   	$largo = 500; //Largo de la Tabla.
	echo '<table width="'.$largo.'"  border="1" cellspacing="0" cellpadding="0" align="center">';
	if ($SubProd == -1)
		echo "<tr><td align='center' colspan='6'>";
	else
		echo "<tr><td align='center' colspan='5'>";
	echo "DESPUNTES Y LAMINAS</td></tr>";
	echo '<tr class="ColorTabla01"><td width="50" align="center">&nbsp;</td>';
	if ($SubProd == -1)
		echo '<td width="130" align="center">PRODUCTO</td>';
	echo '<td width="130" align="center">FECHA</td>';
	echo '<td width="130" align="center">LOTE/HORNADA</td>';
	echo '<td width="130"align="center">CANTIDAD</td>';
	echo '<td width="130" align="center">PESO<br>KGS.</td></tr>';
	$subproducto = substr($cmbproductos,2,2);
	$consulta = "SELECT distinct cod_producto, cod_subproducto, hornada FROM sea_web.movimientos";
	$consulta.= " WHERE tipo_movimiento = 4 ";
	$consulta.= " AND cod_producto = 48 ";
	if ($SubProd != -1)
		$consulta.= " AND cod_subproducto = '".$subproducto."'";
	$consulta.= " AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
	$consulta.= " ORDER BY hornada";
	$rs2 = mysqli_query($link, $consulta);						       	   
	//Crea el detalle.		
	$TieneDet = false;			
	while ($row2 = mysqli_fetch_array($rs2))
	{		
		$TieneDet = true;											  
		echo "<tr>";
		if ($SubProd == -1)
		{
			$Consulta = "select * from proyecto_modernizacion.subproducto ";
			$Consulta.= " where cod_producto = '".$row2["cod_producto"]."' and cod_subproducto = '".$row2["cod_subproducto"]."'";
			$Resp = mysqli_query($link, $Consulta);
			if ($Fila = mysqli_fetch_array($Resp))
			{
				echo '<td align="center"><input type="radio" name="radio" value="'.$row2["hornada"].'"></td>';
				echo '<td align="center">'.strtoupper($Fila["abreviatura"]).'</td>';			
			}
			else
			{
				echo '<td align="center"><input type="radio" name="radio" value="'.$row2["hornada"].'"></td>';
				echo '<td align="center">&nbsp;</td>';
			}			
			echo '<td align="center">'.$fecha.'</td>';
		}
		else
		{			
			echo '<td align="center"><input type="radio" name="radio" value="'.$row2["hornada"].'"></td>';
			echo '<td align="center">'.$fecha.'</td>';
		}		
		echo '<td width="130" align="center">'.substr($row2["hornada"],6,6).'</td>';
		echo '<input type="hidden" name="hornada" value="'.$row2["hornada"].'">';
		echo '<td width="130" align="center">';		
		$consulta = "SELECT SUM(unidades) as unidades FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 48 AND cod_subproducto = '".$row2["cod_subproducto"]."'";
		$consulta = $consulta." AND hornada = '".$row2["hornada"]."' AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
		$rs_u = mysqli_query($link, $consulta);
		if($row_u = mysqli_fetch_array($rs_u))
		{ 
				echo $row_u["unidades"]."</td>";
		}
		echo '<td width="130" align="center">';
		$consulta = "SELECT SUM(peso) as peso FROM sea_web.movimientos";
		$consulta = $consulta." WHERE tipo_movimiento = 4 AND cod_producto = 48 AND cod_subproducto = '".$row2["cod_subproducto"]."'";
		$consulta = $consulta." AND hornada = '".$row2["hornada"]."' AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
		$rs_p = mysqli_query($link, $consulta);
		if($row_p = mysqli_fetch_array($rs_p))
		{ 
			echo $row_p["peso"]."</td>";
		}
		echo "</tr>";
	}	
	//TOTALES
	if ($TieneDet)
	{
		$consulta = "SELECT SUM(unidades) AS unid, SUM(peso) as peso";
		$consulta.= " FROM sea_web.movimientos";
		$consulta.= " WHERE tipo_movimiento = 4 ";
		$consulta.= " AND cod_producto = 48 ";
		if ($SubProd != -1)
			$consulta.= " AND cod_subproducto = '".$subproducto."'";
		$consulta = $consulta." AND fecha_movimiento between '".$fecha."' and '".$fecha2."' and hora between '$FechaInicio' and '$FechaTermino'";
		$rs3 = mysqli_query($link, $consulta);
		if ($SubProd == -1)
			echo "<tr class='ColorTabla02'><td width='260' colspan='4'>";
		else
			echo "<tr class='ColorTabla02'><td width='260' colspan='3'>"; 
		echo "TOTAL PRODUCTO</td>";		
		$row3 = mysqli_fetch_array($rs3);
		if (!is_null($row3["unid"]))
		{ 
			echo "<td width='130' align='center'>".$row3["unid"]."</td>";
			echo "<td width='130' align='center'>".number_format($row3["peso"],0,'','')."</td>";		
		}
	}
	echo "</tr></table><br>";	   				
}
?>	
  </table>
  </div>
  
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
