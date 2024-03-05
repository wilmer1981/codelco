<?php 

include("../principal/conectar_ram_web.php");

if($Proceso == 'B2')
{
	        ob_end_clean();
        $file_name=basename($_SERVER['PHP_SELF']).".xls";
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];
        if ( preg_match( '/MSIE/i', $userBrowser ) ) {
        $filename = urlencode($filename);
        }
        $filename = iconv('UTF-8', 'gb2312', $filename);
        $file_name = str_replace(".php", "", $file_name);
        header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
        header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
        
        header("content-disposition: attachment;filename={$file_name}");
        header( "Cache-Control: public" );
        header( "Pragma: public" );
        header( "Content-type: text/csv" ) ;
        header( "Content-Dis; filename={$file_name}" ) ;
        header("Content-Type:  application/vnd.ms-excel");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
}
else
{
echo'<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">';
}
$CodigoDeSistema = 7;
$CodigoDePantalla = 9;

?>
<html>
<head>
<title>Informe Vida De Un Conjunto</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function TeclaPulsada() 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	var CantComas =0;

	//alert(teclaCodigo);	
	if (teclaCodigo == 13)
	{
		//Frm.CmbHoraInicio.focus();
	}
	else
	{
		if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo !=9))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		else
		{
			/*CantComas=Frm.TxtStockInicial[1].value.search(',');
			if (CantComas!=-1)
			{
				event.keyCode=46;
				return;
			}
			if ((Frm.TxtStockInicial[1].value.substr(Frm.TxtStockInicial[1].value.length-1,1)==",")||(Frm.TxtStockInicial[1].value.substr(Frm.TxtStockInicial[1].value.length-1,1)==""))
			{
				if ((teclaCodigo != 37)&&(teclaCodigo != 39))
				{
					event.keyCode=46;
				}	
			}*/
		}
	}	
} 


function buscar_conjunto_excel()
{
var f = formulario;
	
	if(f.cmbproducto.value == -1)
	{
		alert("Seleccione el Tipo de Conjunto");
    	f.cmbproducto.focus();
		return
	}

	f.action="ram_lst_mov_conjuntos.php?Proceso=B2";
	f.submit();
}

function buscar_conjunto()
{
var f = formulario;

	if(f.cmbproducto.value == -1)
	{
		alert("Seleccione el Tipo de Conjunto");
    	f.cmbproducto.focus();
		return
	}

    f.action="ram_lst_mov_conjuntos.php?Proceso=B";
	f.submit();
}

function Imprimir()
{
	window.print();
}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=7";
	f.submit();
}

</script>
<style type="text/css">
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
<form name="formulario" method="post" action="">

  <?php
	if($Proceso == 'B' || $Proceso == '')
  	 include("../principal/encabezado.php");

	 include("../principal/conectar_principal.php");
  
   if($Proceso == 'B' || $Proceso == '')
   {	 
  ?> 
  
<table width="770" height="313" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <tr>
  	<td height="313" align="center" valign="top">
	
	<table cellpadding="2" cellspacing="0" width="700" align="center" border="1" class="TablaInterior" >
          <tr class="ColorTabla02"> 
            <td colspan="5"><div align="center">Vida De Un Conjunto</div></td>
          </tr>
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Fecha 
              Inicio </td>
            <td colspan="2"> 
              <select name="dia">
                <?php
			if($Proceso=='B')
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

              <select name="mes">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
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
              <select name="ano">
                <?php
	if($Proceso=='B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano)
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
            </td>
            <td width="100"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Fecha 
              T&eacute;rmino</td>
            <td width="235">
              <select name="dia_t">
                <?php
			if($Proceso=='B')
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
              </select>
             
              <select name="mes_t">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
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
              </select>
              <select name="ano_t">
                <?php
	if($Proceso=='B')
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
              </select>
              </font></td>
          </tr>
		  <tr>
		  <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo Conjunto</td>
		  <td colspan="4">
		  <?php
		    echo '<SELECT name="cmbproducto">';
			if($cmbproducto == -1)
				echo '<option value="-1" selected>Seleccionar</option>';			  	
			else
				echo '<option value="-1">Seleccionar</option>';			  	
			if($cmbproducto == 1)
				echo '<option value="1" selected>Producto Minero</option>';			  	
			else
				echo '<option value="1">Producto Minero</option>';			  	
			if($cmbproducto == 3)
				echo '<option value="3" selected>Circulante</option>';			  	
			else
				echo '<option value="3">Circulante</option>';			  	
			if($cmbproducto == 2)
				echo '<option value="2" selected>Mezcla</option>';			  	
			else
				echo '<option value="2">Mezcla</option>';
			echo '</SELECT>';				  	
		  ?>
		  </td>
		  </tr>	
          <tr> 
            <td width="105"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Nro 
              Conjunto</td>
            <td width="80"> 
              <?php
			if($Proceso == 'B' || $num_conjunto != '')
				echo '<input name="num_conjunto" type="text" size="8" value="'.$num_conjunto.'" onKeyDown="TeclaPulsada()">';
            else		
				echo '<input name="num_conjunto" type="text" size="8" onKeyDown="TeclaPulsada()">';
			?>
            </td>
            <td colspan="3" align="center"><input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_conjunto();">
			              <input name="excel" type="button"  style="width:70" onClick="buscar_conjunto_excel();" value="Excel">			              <input name="btnimprimir2" type="button" style="width:70" value="Imprimir" onClick="Imprimir();"> 
              <input name="btnsalir2" type="button" style="width:70" value="Salir" onClick="salir_menu();"> 
            </td>
          </tr> 
        </table>
        <br>
	  <?php
		}
	  ?>
	   	  	        
    <?php
if($Proceso == 'B'|| $Proceso == 'B2')
{
	if(strlen($dia) == 1)
		$dia = '0'.$dia;
	
	if(strlen($mes) == 1)
		$mes = '0'.$mes;
		
	if(strlen($dia_t) == 1)
		$dia_t = '0'.$dia_t;
	
	if(strlen($mes_t) == 1)
		$mes_t = '0'.$mes_t;	

	$fecha_ini = date("Y-m-d",mktime(7,59,59,$mes,($dia),$ano));
	$fecha_ter = $ano_t.'-'.$mes_t.'-'.$dia_t;

	//echo $fecha_ini;
	$Consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = $cmbproducto AND num_conjunto = '$num_conjunto' AND estado != 'f' ";
	//echo "hola".$Consulta;
	$rs = mysqli_query($link, $Consulta);
	if($row = mysqli_fetch_array($rs))
	{
		$cod_conjunto = $row[cod_conjunto];
	 	echo'<table cellpadding="2" cellspacing="0" width="300" align="center" border="0" class="TablaDetalle" >';
	  	  echo'<tr class="ColorTabla02">';
          	 echo'<td colspan="6" align="center"><strong>Conjunto : '.$row[cod_conjunto].' - '.$row[num_conjunto].'</strong></td>';
          echo'</tr>';
	    echo'</table>';	  
	
					 
	    echo'<table cellpadding="2" cellspacing="0" width="700" align="center" border="1" class="TablaDetalle" >';
          echo'<tr class="ColorTabla01">';
		  	echo'<td align="center">Fecha</td>';
		  	echo'<td align="center">Tipo Movimiento</td>';
			echo'<td align="center">Conj Origen</td>';
		  	echo'<td align="center">Conj Destino</td>';
		  	echo'<td align="center">Stock Inicial</td>';
		  	echo'<td align="center">Movimiento</td>';
		  	echo'<td align="center">Stock Final</td>';
		  echo'</tr>';
		  		  
		  $Consulta = "SELECT cod_existencia,fecha_movimiento,num_conjunto,conjunto_destino,peso_humedo FROM ram_web.movimiento_proveedor WHERE cod_conjunto = $cod_conjunto
		  AND peso_humedo > 0 AND (cod_existencia = 02 OR cod_existencia = 13 OR cod_existencia = 1) AND left(fecha_movimiento,10) BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' AND num_conjunto = $num_conjunto order by fecha_movimiento";
	//	echo $Consulta;

		  $rs = mysqli_query($link, $Consulta);
	
			mysqli_query($link, "DROP TABLE ram_web.tmp_table");
		  $Crear_Tabla = "CREATE TEMPORARY TABLE ram_web.tmp_table (`cod_existencia` CHAR (2),`fecha_movimiento` DATETIME, `num_conjunto` INT (10) UNSIGNED DEFAULT '0', `con_cjto_destino` INT (10) UNSIGNED DEFAULT '0', `conjunto_destino` INT (10) UNSIGNED DEFAULT '0', `peso_humedo` DOUBLE  DEFAULT '0', `validacion` DOUBLE  DEFAULT '0')";
		  mysqli_query($link, $Crear_Tabla);
	
		  while ($row = mysqli_fetch_array($rs))
		  {		 		
				$Insertar = "INSERT INTO ram_web.tmp_table (cod_existencia,fecha_movimiento,num_conjunto,conjunto_destino,peso_humedo,validacion)";
				$Insertar = "$Insertar VALUES ('".$row["cod_existencia"]."','".$row[fecha_movimiento]."',$row[num_conjunto],$row[conjunto_destino],$row[peso_humedo],0)";
				mysqli_query($link, $Insertar);
		  }
		  
		  $Consulta = "SELECT cod_existencia,fecha_movimiento,num_conjunto,conjunto_destino,peso_humedo_movido,estado_validacion FROM ram_web.movimiento_conjunto WHERE cod_conjunto = $cod_conjunto
		  AND peso_humedo_movido > 0 AND cod_existencia != 02 AND (num_conjunto = $num_conjunto OR conjunto_destino = $num_conjunto) AND left(fecha_movimiento,10) BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' order by fecha_movimiento ASC";
		  $rs = mysqli_query($link, $Consulta);

		  while ($row = mysqli_fetch_array($rs))
		  {		 		
					$Insertar = "INSERT INTO ram_web.tmp_table (cod_existencia,fecha_movimiento,num_conjunto,conjunto_destino,peso_humedo,validacion)";
					$Insertar = "$Insertar VALUES ('".$row["cod_existencia"]."','".$row[fecha_movimiento]."',$row[num_conjunto],$row[conjunto_destino],$row["peso_humedo_movido"],$row["estado_validacion"])";
					mysqli_query($link, $Insertar);
		  }

/*		  $Consulta = "SELECT cod_existencia,fecha_movimiento,num_conjunto,conjunto_destino,peso_humedo_movido,estado_validacion FROM ram_web.movimiento_conjunto WHERE cod_conjunto = $cod_conjunto
		  AND peso_humedo_movido > 0 AND cod_existencia = 15 AND conjunto_destino = $num_conjunto AND left(fecha_movimiento,10) BETWEEN '".$fecha_ini."' AND '".$fecha_ter."' order by fecha_movimiento ASC";
		  $rs = mysqli_query($link, $Consulta);

		  while ($row = mysqli_fetch_array($rs))
		  {		 		
					$Insertar = "INSERT INTO ram_web.tmp_table (cod_existencia,fecha_movimiento,num_conjunto,conjunto_destino,peso_humedo,validacion)";
					$Insertar = "$Insertar VALUES ('".$row["cod_existencia"]."','".$row[fecha_movimiento]."',$row[num_conjunto],$row[conjunto_destino],$row["peso_humedo_movido"],$row["estado_validacion"])";
					mysqli_query($link, $Insertar);
		  }*/

   }
   else
   {
    $valores = 'cmbproducto='.$cmbproducto.'&num_conjunto='.$num_conjunto;    
	echo '<Script>
	alert("Sin Resultado");
	window.location="ram_lst_mov_conjuntos.php?'.$valores.'"; 
	</Script>'; 
   }

$fecha_aux = $fecha_ini;
while (date($fecha_aux) <= date($fecha_ter)) //Recorre los dias.
{
	$Consulta = "SELECT distinct fecha_movimiento,cod_existencia,num_conjunto,conjunto_destino FROM ram_web.tmp_table WHERE left(fecha_movimiento,10) = '$fecha_aux' AND cod_existencia <> 1 AND cod_existencia <> 13 ORDER BY fecha_movimiento";
	$rs = mysqli_query($link, $Consulta);	
	while($row = mysqli_fetch_array($rs))
	{
		$fecha = substr($row[fecha_movimiento],0,10);	
		echo '<tr>';				 
		echo '<td>'.$row[fecha_movimiento].'</td>';
		//consulto tipo movimiento
		$Consulta = "SELECT * FROM ram_web.atributo_existencia WHERE cod_existencia = $row["cod_existencia"]";
		$rs2 = mysqli_query($link, $Consulta);
		if($row2 = mysqli_fetch_array($rs2))
			echo'<td>'.strtoupper($row2[nombre_existencia]).'</td>';
			echo'<td align="center">'.$row[num_conjunto].'</td>';		  	
			echo'<td align="center">'.$row[conjunto_destino].'</td>';  
		if(($stock_ini == '' || $row["cod_existencia"] == 02 ) && ($stock_ini == '' || $row["cod_existencia"] == 06))
		{
				
			$Consulta = "SELECT SUM(peso_humedo) as peso_humedo FROM ram_web.tmp_table WHERE cod_existencia = 13
			AND num_conjunto = '".$row[num_conjunto]."' AND left(fecha_movimiento,10) = '".$fecha."' ";
			$rs1 = mysqli_query($link, $Consulta);
			if($row1 = mysqli_fetch_array($rs1))
			{
				$stock_ini = $row1[peso_humedo];
				if($stock_ini == 0)
					$stock_ini = $stock_final; 
				echo'<td align="right">'.number_format($stock_ini,0,",",".").'</td>';
			}
		}
		else
		{
			$stock_ini = $stock_final;
			echo'<td align="right">'.number_format($stock_ini,0,",",".").'</td>';				
		}
		if($row["cod_existencia"] == 2)
		{
			$Consulta = "SELECT SUM(peso_humedo) as peso_humedo FROM ram_web.tmp_table WHERE cod_existencia ='02'
			AND num_conjunto = ".$row[num_conjunto]." AND fecha_movimiento = '".$fecha."' ";
			$rs2 = mysqli_query($link, $Consulta);			
			if($row2 = mysqli_fetch_array($rs2))
			{
				$stock_recep = $row2[peso_humedo]; 
				$stock_final = $stock_ini * 1 + $row2[peso_humedo] * 1;	
				echo'<td align="right">'.number_format($stock_recep,0,",",".").'</td>';
			}
		}
		if($row["cod_existencia"] != 2)
		{
			$Consulta = "SELECT distinct (peso_humedo + validacion) as peso_humedo ";
			$Consulta.= " FROM ram_web.tmp_table WHERE num_conjunto = ".$row["num_conjunto"];
			$Consulta.= " AND conjunto_destino = ".$row["conjunto_destino"];
			$Consulta.= " AND cod_existencia = ".$row["cod_existencia"]." AND fecha_movimiento = '".$row["fecha_movimiento"]."'"; 
			$rs3 = mysqli_query($link, $Consulta);	
			if($row3 = mysqli_fetch_array($rs3))
			{
				$stock_benef = $row3[peso_humedo]; 
				
				if (($stock_ini=='') || ($row["cod_existencia"] == 15 && $row[conjunto_destino] == $num_conjunto))
				{
					$stock_final = $stock_ini * 1 + $row3[peso_humedo] * 1;
				}
				else
				{
					if(($row["cod_existencia"] == 15 || $row["cod_existencia"] == 06 || $row["cod_existencia"] == 05))
						$stock_final = ($stock_ini * 1) - ($row3[peso_humedo] * 1);			
				}
				if ($stock_final < 0)
				{
					$stock_benef = $stock_benef * 1 + $stock_final * 1;
					$stock_final = 0;		
				}
				echo'<td align="right">'.number_format($stock_benef,0,',','.').'</td>';
			}
		}	
		echo'<td align="right">'.number_format($stock_final,0,",",".").'</td>';
		echo '</tr>';		
	}
	//Incrementa la fecha en 1 Dia.
	$consulta = "SELECT DATE_ADD('".$fecha_aux."',INTERVAL 1 DAY) AS fecha";
	$rs10 = mysqli_query($link, $consulta);
	$row10 = mysqli_fetch_array($rs10);
	$fecha_aux = $row10["fecha"];						
}
}
?>
  </table>
	  </td>
	</tr>
</table>
 <?php 
 if($Proceso == 'B'|| $Proceso == '')
	include("../principal/pie_pagina.php");

 ?>  	
</form>
</body>
</html>
<?php include("../principal/cerrar_ram_web.php") ?>
