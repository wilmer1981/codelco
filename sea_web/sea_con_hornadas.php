<?php
 $valores = isset($_REQUEST["valores"])?$_REQUEST["valores"]:"";
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal">
<form name="frm1" action="" method="post">

<div style="position:absolute; left: 25px; top: 30px;" id="div1">
<table width="450" border="1" cellspacing="0" cellpadding="0" class="TituloTabla">
  <tr>
      <td height="20" align="center">Hornadas Generadas</td>
  </tr>
</table>
</div>
<div style="position:absolute; left: 25px; top: 68px; width: 452px; height: 25px;" id="div2">
<table width="450" border="1" cellspacing="0" cellpadding="0" class="ColorTabla01">
  <tr>
      <td width="150" height="20" align="center">Hornada</td>
      <td width="150" align="center">Unidades</td>
      <td width="150" align="center">Peso</td>
  </tr>
</table>
</div>

<div style="position:absolute; left: 25px; top: 88px; width: 453px; height: 84px;" id="div3">
<table width="450" border="1" cellspacing="0" cellpadding="0" class="ColorTabla02">
<?php
	$parametros = $valores;
	//Separa los parametros (hornada-unidades-peso).
	//echo $valores."<br>";
	$cont = 0;
	$tabla = array();
	$largo = strlen($parametros);
	for ($i=0; $i < $largo; $i++)
	{
		if (substr($parametros,$i,1) == "/")
		{				
			$valor = substr($parametros,0,$i);
											
			$pos = strpos($valor,"-"); //el N de la cuba
			$hornada = substr($valor,0,$pos);
			$valor = substr($valor,$pos+1,strlen($valor));					
				
			$pos = strpos($valor,"-"); //unidades
			$unidades = substr($valor,0,$pos);
			$valor = substr($valor,$pos+1,strlen($valor));
				
			$peso = $valor; //peso
			$tabla[] = array($hornada, $unidades, $peso);
											
			$parametros = substr($parametros,$i+1);
			$i = 0;			

		}				
	}	
	
	foreach($tabla as $clave => $valor)
	{
		echo '<tr>';
    	echo '<td width="150" height="20" align="center">'.substr($valor[0],6,6).'</td>';
	    echo '<td width="150" align="center">'.$valor[1].'</td>';
    	echo '<td width="150" align="center">'.round($valor[2]).'</td>';
	  	echo '</tr>';
	}
?>
</table>
</div>

<div style="position:absolute; left: 25px; top: 198px; width: 451px; height: 30px;" id="div4">
<table width="450" border="0" cellspacing="0" cellpadding="0">
  <tr>
      <td align="center"><input name="btnsalit" type="button" value="Salir" style="width=60" onClick="self.close()"></td>
  </tr>  
</table>
</div>

</form>
</body>
</html>
