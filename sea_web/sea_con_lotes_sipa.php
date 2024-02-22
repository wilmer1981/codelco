<?php include("../principal/conectar_sea_web.php") ?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Buscar(f)
{
	var linea = "mostrar=S&dia=" + f.dia.value + "&mes=" + f.mes.value + "&ano=" + f.ano.value;
	f.action = "sea_con_lotes_sipa.php?" + linea;
	f.submit();
}
/*****************/
function Enviar(r)
{		
	window.opener.document.frmPrincipal.txtlotesipa.value = r.value;
	window.close();
}
/***********/
function Salir()
{	
	window.close();
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="TablaPrincipal"> 
<form name="form1" method="post" action="">
<div style="position:absolute; left: 25px; top: 14px; width: 500px; height: 25px;" id="div1">
  <table width="500" height="25" border="0" align="center" cellpadding="0" cellspacing="0" class="ColorTabla01">
    <tr>
      <td align="center">Seleccione el Lote relacionado con el SIPA</td>
    </tr>
  </table>
</div>    
  
<div style="position:absolute; left: 25px; top: 49px; width: 500px; height: 25px;" id="div2">
  <table width="500" height="25" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
    <tr> 
      <td width="79">Fecha </td>
      <td width="315"><font size="2"> 
        <select name="dia" size="1">
          <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($mostrar == "S") && ($i == $dia))			
					echo "<option selected value= '".$i."'>".$i."</option>";				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo "<option selected value= '".$i."'>".$i."</option>";											
				else					
					echo "<option value='".$i."'>".$i."</option>";												
			}		
		?>
        </select>
        </font> <font size="2"> 
        <select name="mes" size="1" id="select7">
          <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
        </select>
        <select name="ano" size="1">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
        </select>
        &nbsp; 
        <input name="btnbuscar" type="button" value="Buscar" onClick="Buscar(this.form)">
        </font></td>
    </tr>
  </table>
</div>  
  
<div style="position:absolute; left: 25px; top: 94px; width: 500px; height: 25px;" id="div3">
  <table width="500" height="25" border="0" align="center" cellpadding="0" cellspacing="0" class="ColorTabla01">
    <tr> 
        <td width="200" align="center">N° Guia</td>
        <td width="150" align="center">Lote SIPA</td>
        <td width="150" align="center">Recargo</td>
    </tr>
  </table>
</div>
  
  <div style="position:absolute; left: 23px; top: 119px; OVERFLOW: auto; width: 520; height: 200;" id="div4">
  <table width="500" align="center" border="1" cellspacing="0" cellpadding="0">
  	<?php
		if ($mostrar == "S")
		{
			$fecha = $ano."-".$mes."-".$dia;
			
			$consulta = "SELECT * FROM sipa_web.recepciones WHERE fecha = '".$fecha."'";
			$consulta = $consulta." ORDER BY guia_despacho";
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
				echo '<tr>';
				echo '<td width="200"><input name="radio" type="radio" value="'.$row[lote].'" onClick="Enviar(this)">'.$row[GUIADP_A].'</td>';
				echo '<td width="150" align="center">'.$row[lote].'</td>';
				echo '<td width="150" align="center">'.$row["recargo"].'</td>';
				echo '</tr>';
			}
		}
	?>
  </table>
  </div>
  
<div style="position:absolute; left: 25px; top: 350px; width: 500px; height: 24px;" id="div5">
<table width="500" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td height="15" align="center"><input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
  </tr>
</table>  
</div>    
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>