<?php
include("../principal/conectar_sea_web.php");

//Hornada=5964&Fecha=2023-11-9
if(isset($_REQUEST["Hornada"])) {
	$Hornada = $_REQUEST["Hornada"];
}else{
	$Hornada = "";
}
if(isset($_REQUEST["Fecha"])) {
	$Fecha = $_REQUEST["Fecha"];
}else{
	$Fecha = "";
}

?>

<html>
<head>
<title>Detalles</title>
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
  <div align="center"> 
  <?php 
  	$largo = strlen($Hornada);     
  ?>
  <table cellpadding="3" cellspacing="0" width="500" border="0" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla02"> 
	<?php 	
      	if($largo != 6)	
			echo'<td colspan="3"><div align="center">Detalle Hornada</div></td>';
		else
      	    echo'<td colspan="3"><div align="center">Detalle Lote</div></td>';
    ?>
	</tr>
    <tr> 
	<?php 	
      	if($largo != 6)	
	      echo'<td width="108" height="26">N&uacute;mero Hornada :</td>';
    	else
	      echo'<td width="108" height="26">N&uacute;mero Lote :</td>';
       
       
       
       
	?>		  
      <td width="121">
	  <strong>
	  <?php
	     echo $Hornada;
	  ?> 
	  </strong>
	  </td>
      <td width="251">&nbsp;</td>
    </tr>
  </table>
<?php
           $consulta = "SELECT distinct t2.descripcion FROM sea_web.movimientos t3,";
           $consulta = $consulta ."proyecto_modernizacion.subproducto t2 WHERE ";
           $consulta = $consulta ."t3.cod_producto = t2.cod_producto and t3.cod_subproducto= t2.cod_subproducto";
           $consulta = $consulta." and t3.lote_ventana = '".$Hornada."'";

			$rs = mysqli_query($link, $consulta);
			$descripcion="";
            if($row = mysqli_fetch_array($rs))
			{
                $descripcion = $row["descripcion"];
			}
            echo $descripcion;

if($largo != 6)
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

  <div align="center"> 
  <table cellpadding="0" cellspacing="0"  width="500" border="1" class="TablaDetalle">';  
 

 	include("../principal/conectar_sea_web.php");

					$consulta = "SELECT * FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '".$Fecha."' AND cod_producto = 17 AND right(hornada,4) = '".$Hornada."' "; 

					$rs = mysqli_query($link, $consulta);
					$total_unidades=0;
					$total_peso=0;
					while ($row = mysqli_fetch_array($rs))
					{	
						echo '<tr><td width="15%"><div align="center">'.$row["fecha_movimiento"].'</div></td>';

						$consulta = "SELECT * FROM relaciones WHERE hornada_ventana = '".$row["hornada"]."'"; 
						$rs3 = mysqli_query($link, $consulta);

                        if($row3 = mysqli_fetch_array($rs3))
			            {
						echo '<td width="20%"><div align="center">'.$row3["lote_origen"].'</div></td>';
						echo '<td width="20%"><div align="center">'.$row3["lote_ventana"].'</div></td>';
						}

						echo '<td width="15%"><div align="center">'.substr($row["hornada"],6,6).'</div></td>';
						echo '<td width="15%"><div align="center">'.$row["unidades"].'</div></td>';
						echo '<td width="15%"><div align="center">'.$row["peso"].'</div></td>';
						
						$total_unidades = $total_unidades + $row["unidades"];
						$total_peso = $total_peso + $row["peso"];
						
						echo'</tr>';				
					}
                     
    echo'<tr class="ColorTabla02">'; 
      		echo'<td width="70%" colspan="4"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td width="15%"><div align="center">'.$total_unidades.'</div></td>';
      		echo'<td width="15%"><div align="center">'.$total_peso.'</div></td>';
    echo'</tr>
  		</table></div>';  
}
if($largo == 6)
{
echo'<table cellpadding="3" cellspacing="0" width="500" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla01"> 
        <td width="15%"><div align="center">Fecha</div></td>
        <td width="20%"><div align="center">Lote Ventana</div></td>
        <td width="15%"><div align="center">Recargo</div></td>
        <td width="15%"><div align="center">Unidades</div></td>
        <td width="15%"><div align="center">Peso</div></td>
      </tr>
    </table>
  </div>

  <div align="center"> 
  <table cellpadding="0" cellspacing="0"  width="500" border="1" class="TablaDetalle">';  
 

 	include("../principal/conectar_sea_web.php");

					$consulta = "SELECT * FROM movimientos WHERE tipo_movimiento = 1 AND fecha_movimiento = '".$Fecha."' AND cod_producto = 16 AND lote_ventana = '".$Hornada."'"; 
					$rs = mysqli_query($link, $consulta);
                   
					while ($row = mysqli_fetch_array($rs))
					{	
						echo '<tr><td width="15%"><div align="center">'.$row["fecha_movimiento"].'</div></td>';
						echo '<td width="20%"><div align="center">'.$row["lote_ventana"].'</div></td>';
						echo '<td width="15%"><div align="center">'.$row["numero_recarga"].'</div></td>';
						echo '<td width="15%"><div align="center">'.$row["unidades"].'</div></td>';
						echo '<td width="15%"><div align="center">'.$row["peso"].'</div></td>';
						
						$total_unidades = $total_unidades + $row["unidades"];
						$total_peso = $total_peso + $row["peso"];
						
					    echo'</tr>';
					}
                     
    echo'<tr class="ColorTabla02">'; 
      		echo'<td width="70%" colspan="3"><strong>TOTAL ACUMULADO</strong></td>';
      		echo'<td width="15%"><div align="center">'.$total_unidades.'</div></td>';
      		echo'<td width="15%"><div align="center">'.$total_peso.'</div></td>';
    echo'</tr>
  		</table></div>';  
}
?>	
  <div align="left" style="position:absolute; top: 570px; left: 30px;">
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center">
		    <input name="btnvolver" type="button" style="width:110;" value=" <<   Volver Atras" onClick="JavaScript:window.history.back()"> 
		    <input name="btnimprimir" type="button" style="width:70;" value="Imprimir" onClick="JavaScript:Imprimir()"> 
            <input name="btnsalir" type="button" style="width:100" value="Cerrar Ventana" onClick="self.close()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
