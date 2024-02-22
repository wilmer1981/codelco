<?php
$CodigoDeSistema = 2;
?>
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">

<script language="JavaScript">
function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}	
</script>

</head> 

<body>
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
  <td align="center" valign="middle" >
	  <table width="700" border="0" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td width="203">&nbsp;</td>
            <td width="47">Fecha</td>
            <td width="429"><font color="#000000" size="2"> 
              <SELECT name="dia" size="1" style="font-face:verdana;font-size:10">
                <?php
			if($generar_h=='S')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
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
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
              </SELECT>
              </font> <font color="#000000" size="2"> 
              <SELECT name="mes" size="1" id="SELECT7" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($generar_h=='S')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
              </SELECT>
              <SELECT name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
	if($generar_h=='S')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option SELECTed value ='$i'>$i</option>";
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
			echo "<option SELECTed value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
              </SELECT>
              </font></td>
          </tr>
        </table>
	  <br> 
	  <table width="700" border="1" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr class="ColorTabla01"> 
            <td width="20">&nbsp;</td>
            <td width="48"><div align="center">Guia</div></td>
            <td width="78"><div align="center">Lote Ventana</div></td>
            <td width="80"><div align="center">Nro. Recargo</div></td>
            <td width="69"><div align="center">Unidades</div></td>
            <td width="74"><div align="center">Peso</div></td>
            <td width="66"><div align="center">Lote Origen</div></td>
            <td width="214"><div align="center">Marca</div></td>
          </tr>
          <tr> 
            <td><input type="checkbox" name="checkbox" value="checkbox"></td>
            <td><div align="center">610390</div></td>
            <td><div align="center">309002</div></td>
            <td><div align="center">1</div></td>
            <td><div align="center">
                <input type="text" name="textfield" size='10'>
              </div></td>
            <td><div align="center">
                <input type="text" name="textfield3" size='10'>
              </div></td>
            <td><div align="center">
                <input type="text" name="textfield4" size='10'>
              </div></td>
            <td>
              <?php
		if ($mostrar == "S")
			echo '<input name="txtmarca" type="text" size="10" value="'.$txtmarca.'" disabled>';
		else 
			echo '<input name="txtmarca" type="text" size="10" disabled>';
	?>
              <SELECT name="cmbcolor" id="SELECT5">
                <option value="-1">SELECCIONAR</option>
                <?php
		  	echo '<option value="/">NINGUNO</option>';
			
		  	$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2011 ORDER BY nombre_subclase";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
	         	echo '<option value="'.$row["cod_subclase"].'/'.$row["valor_subclase1"].'">'.$row["nombre_subclase"].'</option>';
			}
		  ?>
              </SELECT> <input name="btnok" type="button" value="Ok" onClick="JavaScript:Agregar(this.form)"></td>
          </tr>
          <tr> 
            <td><input type="checkbox" name="checkbox2" value="checkbox"></td>
            <td><div align="center">610350</div></td>
            <td><div align="center">309007</div></td>
            <td><div align="center">2</div></td>
            <td><div align="center">
                <input type="text" name="textfield2" size='10'>
              </div></td>
            <td><div align="center">
                <input type="text" name="textfield5" size='10'>
              </div></td>
            <td><div align="center">
                <input type="text" name="textfield6" size='10'>
              </div></td>
            <td>
              <?php
		if ($mostrar == "S")
			echo '<input name="txtmarca" type="text" size="10" value="'.$txtmarca.'" disabled>';
		else 
			echo '<input name="txtmarca" type="text" size="10" disabled>';
	?>
              <SELECT name="SELECT" id="SELECT">
                <option value="-1">SELECCIONAR</option>
                <?php
		  	echo '<option value="/">NINGUNO</option>';
			
		  	$consulta = "SELECT * FROM proyecto_modernizacion.sub_clase WHERE cod_clase = 2011 ORDER BY nombre_subclase";		
			$rs = mysqli_query($link, $consulta);
			while ($row = mysqli_fetch_array($rs))
			{
	         	echo '<option value="'.$row["cod_subclase"].'/'.$row["valor_subclase1"].'">'.$row["nombre_subclase"].'</option>';
			}
		  ?>
              </SELECT> <input name="btnok2" type="button" value="Ok" onClick="JavaScript:Agregar(this.form)"></td>
          </tr>
        </table>
		<br>
        <table width="700" border="0" class="TablaDetalle" cellpadding="3" cellspacing="0">
          <tr> 
            <td><div align="center"><font color="#000000" size="2">&nbsp; 
                <input name="grabar" type="button" style="width:70" value="Grabar">
                <input name="distribuir" type="button" style="width:70" value="Distribuir">
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
                </font></div></td>
          </tr>
        </table></td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
