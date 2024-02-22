<?php include("../principal/conectar_sea_web.php");

if(isset($_REQUEST["fecha_p"])) {
	$fecha_p = $_REQUEST["fecha_p"];
}else{
	$fecha_p = "";
}

?>

<html>
<head>
<title>Selecci�n de Hornada</title>

<script language="JavaScript">
function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			Valores =  f.elements[i].value;
		}
	}
	return Valores;
}
//*********************//
function Enviar(f)
{
	var valor = ValidaSeleccion(f,'radio');
	var f = frmPoPup;
	
	if(valor != '')
	{
	window.opener.document.formulario.hornada_m.value = valor;
	window.opener.document.formulario.action = "sea_ing_restoshojas_nave.php?mostrar=S&valor="+valor;
	window.opener.document.formulario.submit();	
	window.close();
    }
	else
	{
		alert('No Seleccionado la Hornada');
		return
    }
	
}
</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
  <div > 
    <div align="left"></div>
    <table cellpadding="3" cellspacing="0" width="500" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
      <tr class="ColorTabla02"> 
        <td height="20" colspan="5"><div align="center"><strong>Seleccionar Hornada</strong></div></td>
      </tr>
      <tr class="ColorTabla01"> 
        <td width="100"><div align="center">Fecha Prod.</div></td>
        <td width="100"><div align="center">Hornada</div></td>
        <td width="100"><div align="center">Grupo</div></td>
        <td width="100"><div align="center">Unidades</div></td>
        <td width="100"><div align="center">Peso</div></td>
      </tr>
    </table>
	</div>
		
      
  <div align="left" style="position:absolute; overflow:auto; top: 58px; height: 260px; "> 
    <div align="center"> 
      <table cellpadding="0" cellspacing="0"  width="500" border="1" class="TablaDetalle">
	<?php
	 $consulta1 = "SELECT distinct hornada FROM movimientos Where cod_producto = 19 AND tipo_movimiento = 3 AND cod_subproducto !=4 
				   AND fecha_movimiento = '".$fecha_p."' AND campo1 != 'M' AND campo1 != 'T'"; 
	 $rs1 = mysqli_query($link, $consulta1);
     while ($row1 = mysqli_fetch_array($rs1))
     {   
         $hornada = $row1["hornada"];
		 $consulta = "SELECT * FROM hornadas Where cod_producto = 19 AND hornada_ventana = '".$hornada."' "; 
		 $rs = mysqli_query($link, $consulta);
		 while ($row = mysqli_fetch_array($rs))
		 {   
	    	echo '<tr><td width="96"><input type="radio" name="radio" value="'.$row["hornada_ventana"].'" >&nbsp;'.$fecha_p.'</td>';
      		echo '<td width="102"><div align="center">'.substr($row["hornada_ventana"],6,6).'</div></td>';

		    $consulta2 = "SELECT * FROM movimientos WHERE fecha_movimiento = '".$fecha_p."' and cod_producto = 19 and hornada = '".$row["hornada_ventana"]."'
			              and cod_subproducto = '".$row["cod_subproducto"]."' "; 
 		    $rs2 = mysqli_query($link, $consulta2);
            if($row2= mysqli_fetch_array($rs2))
			{
   	  	  	echo '<td width="100"><div align="center">'.$row2["campo2"].'</div></td>';
            }

		    $consulta3 = "SELECT SUM(unidades) as unidades_s FROM movimientos WHERE tipo_movimiento = 2 and 
			              cod_producto = 19 and hornada = '".$row["hornada_ventana"]."' and cod_subproducto = '".$row["cod_subproducto"]."' "; 
 		    $rs3 = mysqli_query($link, $consulta3);
//			echo $consulta3;
            if($row3 = mysqli_fetch_array($rs3))			
			{
			$saldo_u = $row["unidades"] - $row3["unidades_s"];
	      	echo '<td width="102"><div align="center">'.$saldo_u.'</div></td>';
            } 

		    $consulta4 = "SELECT unidades,peso_unidades FROM hornadas WHERE cod_producto = 19 and hornada_ventana = '".$row["hornada_ventana"]."' and cod_subproducto = '".$row["cod_subproducto"]."' "; 
 		    $rs4 = mysqli_query($link, $consulta4);
            if($row4= mysqli_fetch_array($rs4))			
			{
			$peso_prom = $row4["peso_unidades"] / $row4["unidades"];
			
			$saldo_p = $saldo_u * $peso_prom;
			
			$saldo_p = round($saldo_p);

			if ($saldo_p < 0) 
			$saldo_p = 0;

	      	echo '<td width="98"><div align="center">'.$saldo_p.'</div></td></tr>';
            } 
             
		}
	}	
	?>
      </table>
    </div>
  </div>
  <div align="left" style="position:absolute; top: 320px">
    <table cellpadding="3" cellspacing="0" width="500" border="0" align="center">
      <tr>
        <td> <div align="center"> 
            <input name="btnaceptar" type="button" style="width:70" value="Aceptar" onClick="JavaScript:Enviar(this.form)">
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="self.close()">
          </div></td>
      </tr>
    </table>
  </div>
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>