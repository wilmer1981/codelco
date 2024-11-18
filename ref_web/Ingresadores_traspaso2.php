<?php
	include("../principal/conectar_ref_web.php");
	$fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$fecha     = ltrim($fecha);
	
	$recargapag = isset($_REQUEST["recargapag"])?$_REQUEST["recargapag"]:"";
	$dia1    = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
	$mes1    = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
	$ano1    = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
	$turno   = isset($_REQUEST["turno"])?$_REQUEST["turno"]:"";
	
	$TxtH2SO1A = isset($_REQUEST["TxtH2SO1A"])?$_REQUEST["TxtH2SO1A"]:"";
	$TxtH2SO2A = isset($_REQUEST["TxtH2SO2A"])?$_REQUEST["TxtH2SO2A"]:"";
	$TxtH2SO3A = isset($_REQUEST["TxtH2SO3A"])?$_REQUEST["TxtH2SO3A"]:"";
	$TxtH2SO4A = isset($_REQUEST["TxtH2SO4A"])?$_REQUEST["TxtH2SO4A"]:"";
	$TxtH2SO5A = isset($_REQUEST["TxtH2SO5A"])?$_REQUEST["TxtH2SO5A"]:"";
	$TxtH2SO6A = isset($_REQUEST["TxtH2SO6A"])?$_REQUEST["TxtH2SO6A"]:"";
	$TxtH2SOHMA = isset($_REQUEST["TxtH2SOHMA"])?$_REQUEST["TxtH2SOHMA"]:"";
	
	$TxtDescP1A = isset($_REQUEST["TxtDescP1A"])?$_REQUEST["TxtDescP1A"]:"";
	$TxtDescP2A = isset($_REQUEST["TxtDescP2A"])?$_REQUEST["TxtDescP2A"]:"";
	$TxtDescP3A = isset($_REQUEST["TxtDescP3A"])?$_REQUEST["TxtDescP3A"]:"";
	$TxtDescP4A = isset($_REQUEST["TxtDescP4A"])?$_REQUEST["TxtDescP4A"]:"";
	$TxtDescP5A = isset($_REQUEST["TxtDescP5A"])?$_REQUEST["TxtDescP5A"]:"";
	$TxtDescP6A = isset($_REQUEST["TxtDescP6A"])?$_REQUEST["TxtDescP6A"]:"";
	$TxtDescPHMA = isset($_REQUEST["TxtDescPHMA"])?$_REQUEST["TxtDescPHMA"]:"";
	
	$TxtElectP1A = isset($_REQUEST["TxtElectP1A"])?$_REQUEST["TxtElectP1A"]:"";
	$TxtElectP2A = isset($_REQUEST["TxtElectP2A"])?$_REQUEST["TxtElectP2A"]:"";
	$TxtElectP3A = isset($_REQUEST["TxtElectP3A"])?$_REQUEST["TxtElectP3A"]:"";
	$TxtElectP4A = isset($_REQUEST["TxtElectP4A"])?$_REQUEST["TxtElectP4A"]:"";
	$TxtElectP5A = isset($_REQUEST["TxtElectP5A"])?$_REQUEST["TxtElectP5A"]:"";
	$TxtElectP6A = isset($_REQUEST["TxtElectP6A"])?$_REQUEST["TxtElectP6A"]:"";
	$TxtElectPHMA = isset($_REQUEST["TxtElectPHMA"])?$_REQUEST["TxtElectPHMA"]:"";
	
	$TxtElectV1A = isset($_REQUEST["TxtElectV1A"])?$_REQUEST["TxtElectV1A"]:"";
	$TxtElectV2A = isset($_REQUEST["TxtElectV2A"])?$_REQUEST["TxtElectV2A"]:"";
	$TxtElectV3A = isset($_REQUEST["TxtElectV3A"])?$_REQUEST["TxtElectV3A"]:"";
	$TxtElectV4A = isset($_REQUEST["TxtElectV4A"])?$_REQUEST["TxtElectV4A"]:"";
	$TxtElectV5A = isset($_REQUEST["TxtElectV5A"])?$_REQUEST["TxtElectV5A"]:"";
	$TxtElectV6A = isset($_REQUEST["TxtElectV6A"])?$_REQUEST["TxtElectV6A"]:"";
	$TxtElectVHMA = isset($_REQUEST["TxtElectVHMA"])?$_REQUEST["TxtElectVHMA"]:"";
	
	
?>

<html>
<head>
<title>Modificacion Electrolito</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(f,opc,fecha)
{
	var Valor1='';
	var Valor2='';
	var Valor3='';
	var Valor4='';
	
	if (opc == 'G')
	{
		if(f.turno.value=='S')
		{
			alert('Debe Seleccionar Turno');
			f.turno.focus();
			return;
		}
		for(i=5;i<=11;i++)
		{
			Valor1=Valor1+f.elements[i].value+'~'
		}
		Valor1=Valor1.substring(0,(Valor1.length-1));
		for(i=12;i<=18;i++)
		{
			Valor2=Valor2+f.elements[i].value+'~'
		}
		Valor2=Valor2.substring(0,(Valor2.length-1));
		for(i=19;i<=25;i++)
		{
			Valor3=Valor3+f.elements[i].value+'~'
		}
		Valor3=Valor3.substring(0,(Valor3.length-1));
		for(i=26;i<=32;i++)
		{
			Valor4=Valor4+f.elements[i].value+'~'
		}
		Valor4=Valor4.substring(0,(Valor4.length-1));
		//alert(Valor1);alert(Valor2);alert(Valor3);alert(Valor4);
		f.action = "ingresadores_traspaso01.php?Proceso=G&Valor1="+Valor1+"&Valor2="+Valor2+"&Valor3="+Valor3+"&Valor4="+Valor4;
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
<p>&nbsp;</p><form name="frmPopup" action="" method="post">
  <table width="76%" border="1" align="center">
    <tr align="center" class="ColorTabla02">
      <td height="25" colspan="10"><span class="Estilo1">Ingreso de Traspasos y Adiciones a Electrolito <strong>(Volumen M3) </strong></span></td>
    </tr>
	<tr>
	<td height="25" colspan="10">
	<strong>Fecha</strong>	<select name="dia1" size="1" id="select17">
	<?php
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		for ($i=1;$i<=31;$i++)
		{	
			if (($recargapag == "S") && ($i == $dia1))			
				echo '<option selected value="'.$i.'">'.$i.'</option>';				
			else if (($i == date("j")) and ($recargapag != "S")) 
					echo '<option selected value="'.$i.'">'.$i.'</option>';
			else					
				echo '<option value="'.$i.'">'.$i.'</option>';												
		}		
	?>
    </select>
	<select name="mes1" size="1" id="select18">
    <?php
		for($i=1;$i<13;$i++)
		{
			if (($recargapag == "S") && ($i == $mes1))
				echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
			else if (($i == date("n")) && ($recargapag != "S"))
					echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
			else
				echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';			
		}		  
	?>
     </select>
	 <select name="ano1" size="1" id="select19">
     <?php
		for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
		{
			if (($recargapag == "S") && ($i == $ano1))
				echo '<option selected value="'.$i.'">'.$i.'</option>';
			else if (($i == date("Y")) && ($recargapag != "S"))
				echo '<option selected value="'.$i.'">'.$i.'</option>';
			else	
				echo '<option value="'.$i.'">'.$i.'</option>';
		}
	 ?>	
	 </select>
     <strong>Turno</strong><?php  
		          
					echo "<select name='turno'>";
					echo '<option value="S">Seleccionar</option>';
					$consulta="select nombre_subclase as turno from proyecto_modernizacion.sub_clase where cod_clase='1'";
					$respuesta = mysqli_query($link, $consulta);
					while ($fila1=mysqli_fetch_array($respuesta))
 					   {
						if ($turno==$fila1["turno"])
						   echo "<option value='".$fila1["turno"]."' selected>".$fila1["turno"]."</option>";
						else
							echo "<option value='".$fila1["turno"]."'>".$fila1["turno"]."</option>";
						}
					echo '</select>';
                   ?>	 
	 <input type="button" name="TxtGrabar" value="Grabar" onClick="Proceso(this.form,'G','')">
	 </td>
	</tr>
    <tr class="ColorTabla02">
      <td width="31%" align="left">&nbsp;</td>
      <td align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Circuito 1</FONT></td>
      <td align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Circuito 2</FONT></td>
      <td align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Circuito 3</FONT></td>
      <td align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Circuito 4</FONT></td>
      <td align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Circuito 5</FONT></td>
      <td align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000"> Circuito 6</FONT></td>
      <td align="center"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">HM</FONT></td>
    </tr>
    <tr>
      <td width="31%" align="left" class="ColorTabla02"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">H2SO4</FONT></td>
      <td align="center">		 <input name="TxtH2SO1A" type="text" value="<?php echo $TxtH2SO1A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');">                    </td>
      <td align="center">        <input name="TxtH2SO2A" type="text" value="<?php echo $TxtH2SO2A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');">                    </td>
      <td align="center">        <input name="TxtH2SO3A" type="text" value="<?php echo $TxtH2SO3A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtH2SO4A" type="text" value="<?php echo $TxtH2SO4A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtH2SO5A" type="text" value="<?php echo $TxtH2SO5A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtH2SO6A" type="text" value="<?php echo $TxtH2SO6A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtH2SOHMA" type="text" value="<?php echo $TxtH2SOHMA; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
    </tr>
    <tr>
      <td width="31%" align="left"  class="ColorTabla02"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Desc.Parcial</FONT></td>
      <td align="center">        <input name="TxtDescP1A" type="text" value="<?php echo $TxtDescP1A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtDescP2A" type="text" value="<?php echo $TxtDescP2A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtDescP3A" type="text" value="<?php echo $TxtDescP3A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtDescP4A" type="text" value="<?php echo $TxtDescP4A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtDescP5A" type="text" value="<?php echo $TxtDescP5A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');">                    </td>
      <td align="center">        <input name="TxtDescP6A" type="text" value="<?php echo $TxtDescP6A; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtDescPHMA" type="text" value="<?php echo $TxtDescPHMA; ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
    </tr>
    <tr>
      <td width="31%" align="left"  class="ColorTabla02"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Electrolito Proceso </FONT></td>
      <td align="center">        <input name="TxtElectP1A" type="text" value="<?php echo $TxtElectP1A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectP2A" type="text" value="<?php echo $TxtElectP2A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectP3A" type="text" value="<?php echo $TxtElectP3A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectP4A" type="text" value="<?php echo $TxtElectP4A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectP5A" type="text" value="<?php echo $TxtElectP5A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectP6A" type="text" value="<?php echo $TxtElectP6A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectPHMA" type="text" value="<?php echo $TxtElectPHMA ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
    </tr>
    <tr>
      <td align="left"  class="ColorTabla02"><FONT style="FONT-WEIGHT: bold; COLOR: #000000">Electrolito Venta </FONT></td>
      <td align="center">        <input name="TxtElectV1A" type="text" value="<?php echo $TxtElectV1A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectV2A" type="text" value="<?php echo $TxtElectV2A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectV3A" type="text" value="<?php echo $TxtElectV3A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectV4A" type="text" value="<?php echo $TxtElectV4A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectV5A" type="text" value="<?php echo $TxtElectV5A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectV6A" type="text" value="<?php echo $TxtElectV6A ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
      <td align="center">        <input name="TxtElectVHMA" type="text" value="<?php echo $TxtElectVHMA ?>" size="4" maxlength="4" onKeyDown="TeclaPulsada2('S',false,this.form,'');" >                    </td>
    </tr>
  </table>
</form>
<?php
	if (isset($activar))
	{
		echo '<script language="JavaScript">';		
		if (isset($mensaje))
			echo 'alert("'.$mensaje.'");';		
			
		echo 'window.opener.document.frmPrincipal.action = "ingreso_cir_eleaux.php?fecha='.$txt_fecha.'&mostrar=S";';
		echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>



