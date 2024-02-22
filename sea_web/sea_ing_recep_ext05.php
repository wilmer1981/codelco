<?php include("../principal/conectar_sea_web.php")?>

<html>
<head>
<title>Busqueda de Datos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function buscar_hornada()
{
var f = frmPoPup;

    if(f.hornada.value == '')
	 {  
	   alert("Debe ingresar la Hornada");
	   f.hornada.focus();
	   return
	 }

	if (isNaN(parseInt(f.hornada.value)))			
	{
		alert("El N� Hornada no es V�lido");
		return false;
	}	

    f.action="sea_ing_recep_ext05.php?Proceso=B";
	f.submit();
}

function Imprimir()
{
	window.print();
}


</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <div align="left"> 
    
  <table cellpadding="3" cellspacing="0" width="500" border="0" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla02"> 
      <td colspan="3"><div align="center">Busqueda de Datos</div></td>
    </tr>
    <tr> 
      <td width="108" height="26">Nro Hornada</td>
      <td width="121">
        <?php
		if($Proceso == 'B')
			echo'<input name="hornada" type="text" value="'.$hornada.'" size="15">';
		else 	
			echo'<input name="hornada" type="text" size="15">';
        ?>
		</td>
      <td width="251"><input name="buscar" type="button" style="width:70" value="Buscar" onClick="buscar_hornada();"></td>
    </tr>
  </table>
<?php
if($Proceso == 'B')
{
echo'<table cellpadding="3" cellspacing="0" width="500" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla01"> 
        <td width="15%"><div align="center">Fecha</div></td>
        <td width="20%"><div align="center">Lote Origen</div></td>
        <td width="20%"><div align="center">Lote Ventana</div></td>
        <td width="15%"><div align="center">Hornada</div></td>
        <td width="15%"><div align="center">Unidades</div></td>
        <td width="15%"><div align="center">Peso</div></td>
      </tr>
    </table>
  </div>

  <div align="left" style="position:absolute; overflow:auto; top: 83px; height: 380px;"> 
  <table cellpadding="0" cellspacing="0"  width="500" border="1" class="TablaDetalle">';  
 

 	include("../principal/conectar_sea_web.php");

					$consulta = "SELECT * FROM movimientos WHERE tipo_movimiento = 1 AND cod_producto = 17 AND right(hornada,4) = $hornada"; 
					$rs = mysqli_query($link, $consulta);

					while ($row = mysqli_fetch_array($rs))
					{	
						echo '<tr><td width="15%"><div align="center">'.$row[fecha_movimiento].'</div></td>';

						$consulta = "SELECT * FROM relaciones WHERE hornada_ventana = $row[hornada]"; 
						$rs3 = mysqli_query($link, $consulta);

                        if($row3 = mysqli_fetch_array($rs3))
			            {
						echo '<td width="20%"><div align="center">'.$row3[lote_origen].'</div></td>';
						echo '<td width="20%"><div align="center">'.$row3[lote_ventana].'</div></td>';
						}

						echo '<td width="15%"><div align="center">'.substr($row[hornada],6,6).'</div></td>';
						echo '<td width="15%"><div align="center">'.$row["unidades"].'</div></td>';
						
					   $consulta = "SELECT * FROM hornadas where hornada_ventana = $row[hornada] AND cod_producto = 17"; 
					   $rs2 = mysqli_query($link, $consulta);
						
						if($row2 = mysqli_fetch_array($rs2))
						{
						   $peso_prom = $row2[peso_unidades] / $row2["unidades"];
						   $peso = round($row["unidades"] * $peso_prom);
						   echo '<td width="15%"><div align="center">'.$peso.'</div></td>';
					    }
						
						$total_unidades = $total_unidades + $row["unidades"];
						$total_peso = $total_peso + $peso;
					}
                     
    echo'</table>';
		             
   echo'<table cellpadding="0" cellspacing="0"  width="500" border="1" class="TablaDetalle">
        <tr>'; 
      		echo'<td width="70%"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td width="15%"><div align="center">'.$total_unidades.'</div></td>';
      		echo'<td width="15%"><div align="center">'.$total_peso.'</div></td>';
    echo'</tr>
  		</table></div>';  

}

?>	
  <div align="left" style="position:absolute; top: 475px; left: 24px;">
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center">
		    <input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="self.close()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
