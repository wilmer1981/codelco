<?php
	include("../principal/conectar_ref_web.php");
	$fecha_hoy=ltrim($fecha);
	  
	
?>
  
<html>
<head>
<title>Modificacion Electrolito</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">

function TeclaPulsada1(salto) 
{ 

	var f = frmPopup;
	var teclaCodigo = event.keyCode; 	
	if (teclaCodigo == 13)
	{		
		eval("f." + salto + ".focus();");
	}
}
function Proceso(f,opc,fecha)
{
	var f = frmPopup;
	var Valor1='';
	var Valor2='';
	var Valor3='';
	var Valor4='';
	var jefe =' ';
	if (opc == 'G')
	{
		var jefe=f.nombre2.value;
	
		for(i=5;i<=10;i++)
		{
			var val_control = f.elements[i].value.replace(",",".");
				//alert(val_control + f.elements[i].value);
		
			if (val_control < 10 || val_control > 25 || val_control ==0.00)
			{
				alert ("Valor fuera de Rango, debe estar entre 10 y 25");
				 f.elements[i].value=0.00;
				  f.elements[i].focus();
				 return;
			}
			Valor1=Valor1+val_control+'~'
			
			//Valor1=Valor1+f.elements[i].value+'~'
			
		}
		Valor1=Valor1.substring(0,(Valor1.length-1));
		for(i=13;i<=18;i++)
		{
			var val_control1 = f.elements[i].value;
			//alert(val_control1 + f.elements[i].value);
			//if (f.elements[i].value.replace(",",".") < 0 || f.elements[i].value.replace(",",".") > 6)
			if (val_control1 < 0 || val_control1 > 6)
			{
				alert ("Valor fuera de Rango, debe estar entre 0 y 6 ");
				 f.elements[i].value=0;
				  f.elements[i].focus();
				 return;
			}
			Valor2=Valor2+val_control1+ '~'
			//Valor2=Valor2+f.elements[i].value+'~'
		}
		Valor2=Valor2.substring(0,(Valor2.length-1));
		//alert(f.elements[i].value + " "+ i);
		//f.action = "ingresadores_informacion01.php?Proceso=G&jefe="+jefe+"&Valor1="+Valor1+"&Valor2="+Valor2; 
		f.action = "ingresadores_informacion01.php?Proceso=G&fecha=2009-01-12&jefe=Maria isabel Espindola Lara";
        f.submit();
	}	
}
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
</head>


<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<body onLoad="document.frmPopup.Txtrect1.focus();">

<p>&nbsp;</p><form name="frmPopup" action="" method="post">
  <table width="86%" border="1" align="center">
    <tr align="center" class="ColorTabla02">
      <td height="25" colspan="11"><span class="Estilo1">Ingreso de Carga de Rectificadores (KA)</span></td>
    </tr>
    <tr>
	<?php
	/*
      <td height="25" colspan="10"> <strong>Fecha</strong>
	
	
          <strong>Jefe Turno : </strong>
          <?php  
	 			$consulta="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'  ";
				$rss = mysqli_query($link, $consulta);
				$rows = mysqli_fetch_array($rss);
				$nombre2=$rows["nombres"]." ".$rows["apellido_paterno"]." ".$rows["apellido_materno"];
				echo "<input type='hidden' name='nombre2' value='".$nombre2."'>"; 

		        echo "<strong>Sr. ".strtoupper($rows["nombres"])."&nbsp;".strtoupper($rows["apellido_paterno"])."&nbsp;".strtoupper($rows["apellido_materno"])."</strong>";
				
          ?>
          <input type="button" name="TxtGrabar" value="Grabar" onClick="Proceso(this.form,'G','')">
	*/
	?>
</td>
    </tr>
    <tr>
      <td height="25" colspan="11"><span class="Estilo1"> &nbsp;</span></td>
    </tr>
    <tr class="ColorTabla02">
      <td width="62" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Rect. 1</font></td>
      <td width="62" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Rect. 2</font></td>
      <td width="62" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Rect. 3</font></td>
      <td width="63" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Rect. 4</font></td>
      <td width="63" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Rect. 5</font></td>
      <td width="73" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000"> Rect. 6</font></td>
	  <td width="67" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000"> Gru.49</font></td>
      <td width="144" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000"> Fecha Ultima Modif.</font></td>
      <td width="209" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000"> Jefe de Turno</font></td>
    </tr>			

		<?php
		$consulta_rectificador="select distinct max(fecha) as fecha1 from ref_web.rectificador_modificado";
		$rs_rectificador=mysqli_query($link, $consulta_rectificador);	
		//echo "VVV".$consulta_rectificador;
		if ($row1 = mysqli_fetch_array($rs_rectificador))
		{
			

			$fecha1= $row1[fecha1];
			$consulta_datos="SELECT cod_rectificador,corriente_aplicada,jefe_turno ";
	     	$consulta_datos.=" FROM ref_web.rectificador_modificado"; 
	     	$consulta_datos.=" where fecha ='".$row1[fecha1]."'  order by cod_rectificador";
			
			$rs=mysqli_query($link, $consulta_datos);	
			while ($row3 = mysqli_fetch_array($rs))
	   		{  
			$nombre = $row3[jefe_turno];
				switch($row3[cod_rectificador]) 
				{
					case "1":
						$Txtrect1= $row3[corriente_aplicada];
					break;	
					case "2":
						$Txtrect2= $row3[corriente_aplicada];
					break;	
					case "3":
						$Txtrect3= $row3[corriente_aplicada];
					break;	
					case "4":
						$Txtrect4= $row3[corriente_aplicada];
					break;	
					case "5":
						$Txtrect5= $row3[corriente_aplicada];
					break;	
					case "6":
						$Txtrect6= $row3[corriente_aplicada];
					break;	
					case "49":
						$Txtgrupo49= $row3[corriente_aplicada];
					break;	

				}
			}
		}		
?>
	<tr>
      <td align="center"><input name="Txtrect1" type="text" id="Txtrect1" readonly=""  value="<?php echo number_format($Txtrect1,1,',',''); ?>"  size="4"  maxlength="4"></td>
      <td align="center"><input name="Txtrect2"  type="text" id="Txtrect2" readonly=""  value="<?php echo number_format($Txtrect2,1,',',''); ?>"  size="4" maxlength="4"></td>
      <td align="center"><input name="Txtrect3"  type="text" id="Txtrect3" readonly=""  value="<?php echo number_format($Txtrect3,1,',',''); ?>" size="4"  maxlength="4" ></td>
      <td align="center"><input name="Txtrect4"  type="text" id="Txtrect4" readonly=""  value="<?php echo number_format($Txtrect4,1,',',''); ?>"  size="4"  maxlength="4" ></td>
      <td align="center"><input name="Txtrect5"  type="text" id="Txtrect5" readonly=""  value="<?php echo number_format($Txtrect5,1,',',''); ?>"  size="4" maxlength="4" ></td>
      <td align="center"><input name="Txtrect6"  type="text" id="Txtrect6" readonly="" value="<?php echo number_format($Txtrect6,1,',',''); ?>"  size="4" maxlength="4" ></td>
	  <td align="center"><input name="Txtgrupo49"  type="text" id="Txtgrupo49" readonly="" value="<?php echo number_format($Txtgrupo49,1,',',''); ?>"  size="4" maxlength="4" ></td>
	 <?php
		if ($nombre=="")
		{
			$fecha1=$fecha_hoy;
			$nombre= $rows["nombres"]." ".$rows["apellido_paterno"]." ".$rows["apellido_materno"];
		}	
		$Txtjefe1=$nombre;  
	  ?> 
	<?php
      echo '<td align="center"><input name="Txtfecha" readonly=""  type="text" id="Txfecha"  value="'.$fecha1.'"  size="14"  ></td>';
	  echo '<td align="center"><input name="Txtjefe" readonly="" type="text" id="Txfjefe"  value="'.$Txtjefe1.'" size="40"  ></td>';
	?>																							
    </tr>
	

    <tr>
      <td height="25" colspan="10"><span class="Estilo1"> &nbsp;</span></td>
    </tr>
    <tr align="center" class="ColorTabla02">
      <td height="25" colspan="10"><span class="Estilo1">Ingreso Cubas de Descobrizaci&oacute;n </span></td>
    </tr>
    <tr>
      <td height="25" colspan="10"><span class="Estilo1"> &nbsp;</span></td>
    </tr>
    <tr class="ColorTabla02">
      <td width="62" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Cir. 1</font></td>
      <td width="62" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Cir. 2</font></td>
      <td width="62" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Cir. 3</font></td>
      <td width="63" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Cir. 4</font></td>
      <td width="63" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000">Cir. 5</font></td>
      <td width="73" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000"> Cir. 6</font></td>
	   <td width="67" align="center"> &nbsp;</span></td>
	  <td width="144" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000"> Fecha Ultima Modif.</font></td>
      <td width="209" align="center"><font style="FONT-WEIGHT: bold; COLOR: #000000"> Jefe de Turno</font></td>
	  </tr>
	  
	  		<?php
		$consulta ="select distinct max(fecha) as fecha2 from ref_web.cubas_descobrizacion";
		$rs_cuba=mysqli_query($link, $consulta);	
		//echo "VVV".$consulta_rectificador;
		if ($row2 = mysqli_fetch_array($rs_cuba))
		{
			$fecha2= $row2[fecha2];
			$consulta ="SELECT cod_cuba,corriente_aplicada, jefe_turno ";
	     	$consulta.=" FROM ref_web.cubas_descobrizacion"; 
	     	$consulta.=" where fecha ='".$row2[fecha2]."'  order by cod_cuba";
			
			$rs1=mysqli_query($link, $consulta);	
			while ($row2 = mysqli_fetch_array($rs1))
	   		{  
				switch($row2[cod_cuba]) 
				{
					case "1":
						$Txtcir1= $row2[corriente_aplicada];
					break;	
					case "2":
						$Txtcir2= $row2[corriente_aplicada];
					break;	
					case "3":
						$Txtcir3= $row2[corriente_aplicada];
					break;	
					case "4":
						$Txtcir4= $row2[corriente_aplicada];
					break;	
					case "5":
						$Txtcir5= $row2[corriente_aplicada];
					break;	
					case "6":
						$Txtcir6= $row2[corriente_aplicada];
					break;	

				}
			}
		}		
				
?>
    <tr>					
      <td align="center"><input name="Txtcir1" type="text" id="Txtcir1" readonly="" value="<?php echo number_format($Txtcir1,0,'',''); ?>" size="4" maxlength="4"></td>
      <td align="center"><input name="Txtcir2" type="text" id="Txtcir2" readonly=""  value="<?php echo number_format($Txtcir2,0,'',''); ?>" size="4" maxlength="4"></td>
      <td align="center"><input name="Txtcir3" type="text" id="Txtcir3" readonly=""  value="<?php echo number_format($Txtcir3,0,'',''); ?>" size="4" maxlength="4" ></td>
      <td align="center"><input name="Txtcir4" type="text" id="Txtcir4" readonly=""  value="<?php echo number_format($Txtcir4,0,'',''); ?>" size="4" maxlength="4" ></td>
      <td align="center"><input name="Txtcir5" type="text" id="Txtcir5" readonly=""  value="<?php echo number_format($Txtcir5,0,'',''); ?>" size="4" maxlength="4" ></td>
      <td align="center"><input name="Txtcir6" type="text" id="Txtcir6" readonly=""  value="<?php echo number_format($Txtcir6,0,'',''); ?>" size="4" maxlength="4" ></td>

	 <?php
	
		if ($nombre=="")
		{
			$fecha1 = $fecha_hoy;
			$nombre= $rows["nombres"]." ".$rows["apellido_paterno"]." ".$rows["apellido_materno"];	
		}
		$Txtjefe2=$nombre;  
	  ?> 
	  
	  	<?php
		echo '<td width="18" align="center"> &nbsp;</span></td>';
      echo '<td align="center"><input name="Txtfecha1" readonly="" type="text" id="Txfecha1"  value="'.$fecha1.'"  size="14"  ></td>';
	  echo '<td align="center"><input name="Txtjefe1" readonly=""  type="text" id="Txfjefe1"  value="'.$Txtjefe2.'" size="40"  ></td>';
	?>																							

    </tr>
  </table>
  </table>
</form>
<?php

	if (isset($activar))
	{
		echo '<script language="JavaScript">';		
		if (isset($mensaje))
			echo 'alert("'.$mensaje.'");';		
			
		echo 'window.opener.document.frmPopup.action = "ingresadores_informacion.php?fecha='.$txt_fecha.'&mostrar=S";';
		echo 'window.opener.document.frmPopup.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>



