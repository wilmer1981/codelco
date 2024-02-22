<script language="JavaScript">
function Salir()
{
	window.self.close();
}
</script>
<html>
<head>
<title>INFORME PROVEEDORES CUBAS</title>
<link href="../principal/estilos/css_ref_web.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php")?>

  <table width="93%" height="104" border="1" class="TablaPrincipal">
    <tr align="center" class="ColorTabla01"> 
      <td colspan="10">INFORME PROVEEDORES CUBAS</td>
    </tr>
	
    <tr>
 	  <td width="20%" align="center"> RUT PROVEEDOR</td>
      <td width="20%" align="center">NOMBRE PROVEEDOR</td>
      <td width="20%" align="center">CIRCUITO</td>
      <td width="20%" align="center">GRUPO</td>
	  <td width="20%" align="center">CUBA</td>
    </tr>
    <?php
						$Consulta="select cod_circuito,cod_grupo,cod_cuba,cod_proveedor from ref_web.cubas_proveedor order by cod_proveedor,cod_circuito,cod_grupo,cod_cuba";
						$rs1 = mysqli_query($link, $Consulta);
						while($row1 = mysqli_fetch_array($rs1))
						{
							echo "<td align='center'>".$row1[cod_proveedor]."&nbsp</td>\n";
							echo "<td align='center'>&nbsp</td>\n";
							echo "<td align='center'>".$row1[cod_circuito]."&nbsp</td>\n";
							echo "<td align='center'>".$row1["cod_grupo"]."&nbsp</td>\n";
							echo "<td align='center'>".$row1[cod_cuba]."&nbsp</td>\n";
							echo "</tr>\n";								
						}
		
					?>
 
  
<tr> 
      <td colspan="5" align="center"><input  type="button" name="btnsalir" value="salir" style="width:70" onClick="Salir()"></td>
</tr> 
</table>

  <?php include("../principal/pie_pagina.php");?>
  
  <p>&nbsp; </p>
</form>