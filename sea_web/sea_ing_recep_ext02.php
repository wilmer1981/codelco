<?php include("../principal/conectar_sea_web.php")?>

<html>
<head>
<title>Selecci�n de Lotes</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function ValidaSeleccion(f,Nombre)
{
	var LargoForm = f.elements.length;
	var Valores = "";
	for (i = 0; i < LargoForm; i++)
	{
		if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true))
		{
			Valores =  Valores + f.elements[i+1].value + '/'; 
		}
	}
	return Valores;
}
//*********************//
function Enviar(f)
{
	var valor = ValidaSeleccion(f,'checkbox');
	
	if(valor != '')
	{
		window.opener.document.formulario.action = "sea_ing_recep_ext.php?mostrar2=S&mostrar3=S&valores="+valor;
		window.opener.document.formulario.submit();
		window.close();
    }
	else
	{
		alert('No hay Lotes Seleccionados');
		return
    }

}
</script>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
<form name="frmPoPup" method="post" action="">
 <div align="left">
 <table cellpadding="3" cellspacing="0" width="500" border="1" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla02"> 
      <td height="20" colspan="6"><div align="center"><strong>Lotes Ingresados</strong></div></td>
    </tr>
    <tr class="ColorTabla01"> 
      <td height="20" colspan="2"><div align="center">Lote Ventanas</div></td>
      <td width="23%"><div align="center">N&deg; Recargo</div></td>
      <td width="20%"><div align="center"> Hornada Vent.</div></td>
      <td width="23%"><div align="center">Lote Origen</div></td>
      <td width="15%"><div align="center">Marca</div></td>
    </tr>
  </table>
  </div>
  <div align="left" style="position:absolute; top: 58px"> 
  <table cellpadding="0" cellspacing="0"  width="500" border="1" class="TablaDetalle">  
	<?php 
	include("../principal/conectar_sea_web.php");
 
    $largo_lote = strlen($valores_lote);
	
    for ($i=0; $i < $largo_lote; $i++)
	{
		if (substr($valores_lote,$i,1) == "/")
		{				
			$nro_lote = substr($valores_lote,0,$i);				
			$valores_lote = substr($valores_lote,$i+1);
			$i=0;
			
					$nro_recargo = substr($valores_recargo,0,$j);				
					$valores_recargo = substr($valores_recargo,$j+1);
					$j=0;
					
					$consulta = "SELECT * FROM relaciones where lote_sipa = $nro_lote ORDER BY lote_ventana"; 
					$rs = mysqli_query($link, $consulta);
		
					while ($row = mysqli_fetch_array($rs))
					{	
					    //$hornada = substr(
						//echo '<td width="5%"><input type="checkbox" name="checkbox" value="'.$row[lote_ventana].'" ><input name="hornada" type="hidden" size="10" value="'.$row[hornada_ventana].'"></td>';
						echo '<tr><td width="19%"><input type="checkbox" name="checkbox" value="'.$row[lote_ventana].'" >&nbsp;<input name="hornada" type="hidden" size="10" value="'.$row[hornada_ventana].'">'.$row[lote_ventana].'</td>';
						echo '<td width="23%"><div align="center">'.$row["recargo"].'</div></td>';
						echo '<td width="20%"><div align="center">'.substr($row[hornada_ventana],6,6).'</div></td>';
						echo '<td width="23%"><div align="center">'.$row[lote_origen].'</div></td>';
						echo '<td><div align="center">'.$row[marca].'</div></td></tr>';
					 
					}
					

			

		}


	}	

	?>	
  </table>
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
