<?php
	include("../principal/conectar_sec_web.php");
	$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$recarga = isset($_REQUEST["recarga"])?$_REQUEST["recarga"]:"";	
	$mostrar = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";	
	$activar = isset($_REQUEST["activar"])?$_REQUEST["activar"]:"";	
	$circuito = isset($_REQUEST["circuito"])?$_REQUEST["circuito"]:"";	
	$ano2   = isset($_REQUEST["ano2"])?$_REQUEST["ano2"]:date("Y");
	$mes2   = isset($_REQUEST["mes2"])?$_REQUEST["mes2"]:date("m");
	$dia2   = isset($_REQUEST["dia2"])?$_REQUEST["dia2"]:date("d");
	$cod_circuito  = isset($_REQUEST["cod_circuito"])?$_REQUEST["cod_circuito"]:"";
	$txtreferencial  = isset($_REQUEST["txtreferencial"])?$_REQUEST["txtreferencial"]:"";
	$cmbcircuito = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:"";
	
	if ($opcion=='G')
	{
		$fecha_ref=$ano2.'-'.$mes2.'-'.$dia2;
		$consulta="select ref_cir from ref_web.referenciales where cod_circuito='".$cod_circuito."' and fecha='".$fecha_ref."' ";
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{    
		   $actualiza = "UPDATE ref_web.referenciales set ref_cir ='".$txtreferencial."'";
		   $actualiza.= " where cod_circuito= '".$cod_circuito."' ";
		   echo $actualiza;
		   mysqli_query($link, $actualiza);
		}
		else{
			 $insertar = "INSERT INTO ref_web.referenciales (cod_circuito,ref_cir,fecha) "; 
			 $insertar = $insertar."VALUES ('".$cod_circuito."','".$txtreferencial."','".$fecha_ref."')";
			 echo $insertar;
			mysqli_query($link, $insertar);
		         
		   
		}		
	}  
	


?>

<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaCampos(f)
{
	if (f.txtrevision.value == "")
	{
		alert("Debe Ingresar Revision");
		return false;
	}
	
	if (f.txtcatodos.value == "")
	{
		alert("Debe Ingresar los Catodos Comerciales");
		return false;
	}
	
	if (f.txtdescobrizacion.value == "")
	{
		alert("Debe Ingresar la Descobrizacion");
		return false;
	}
	
	if (f.txtdespuntes.value == "")
	{
		alert("Debe Ingresar los Despuntes");
		return false;
	}
	
	return true;
}
/*****************/
function Grabar(f)
{
       		
		f.action = "ref_modifica_referencial.php?opcion=G&cod_circuito="+f.cmbcircuito.value+"&referencial="+f.txtreferencial.value;
		f.submit();
	
}
function Buscar()
{
	var  f=document.PopupProduccion;

	f.action='lectura_rectificador_proceso.php?opcion=B&mostrar=S';
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
function Modificar()
{
	var  f=document.PopupProduccion;
	 var fecha=f.ano1.value+"-"+f.mes1.value+"-"+f.dia1.value;

	f.action = "lectura_rectificador_proceso.php?opcion=M&rectificador="+f.txtrectificador.value+"&fecha="+fecha;
	f.submit();
	//alert(f.dia1.value);
	//alert(f.mes1.value);
	//alert(f.ano1.value);	

}
/*****************/
function Salir()
{
	window.close();
}
function Recarga1(opcion)
{	
	var f = document.PopupReferencial;
	if (opcion=='S')
	   {f.action = "ref_modifica_referencial.php?recarga=S"+"&circuito="+f.cmbcircuito.value;}
	f.submit();
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="PopupReferencial" action="" method="post">
  <table width="487" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
<td width="421" align="center" valign="middle"><table width="467" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="169"><font face="Arial, Helvetica, sans-serif">Fecha </font></td>
            <td colspan="2"><font size="2"> </select></font><font face="Arial, Helvetica, sans-serif"> 
              <select name="dia2" size="1" id="select2">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			for ($i=1;$i<=31;$i++)
			{	
				if (($i == $dia2))			
					echo '<option selected value="'.$i.'">'.$i.'</option>';				
				else if (($i == date("j")) and ($mostrar != "S")) 
						echo '<option selected value="'.$i.'">'.$i.'</option>';
				else					
					echo '<option value="'.$i.'">'.$i.'</option>';												
			}		
		?>
              </select>
              <select name="mes2" size="1" id="mes2">
                <?php
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes2))
					echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
				else if (($i == date("n")) && ($mostrar != "S"))
						echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
				else
					echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';			
			}		  
		?>
              </select>
              <select name="ano2" size="1" id="select4">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano2))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
              </select>
              </font></td>
          </tr>
          <tr> 
            <td>Circuito<font face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
            <td colspan="2"><font size="2">
              <select name="cmbcircuito" id="cmbcircuito"  onChange="Recarga1('S')">
                <option value="-1">SELECCIONAR</option>
                <?php
				$consulta = "SELECT * FROM sec_web.circuitos ";
				$consulta.= " ORDER BY cod_circuito";
				$rs = mysqli_query($link, $consulta);
				
				while ($row = mysqli_fetch_array($rs))
				{
		  			if  ($row["cod_circuito"] == $cmbcircuito)
						echo '<option value="'.$row["cod_circuito"].'" selected>Circuito '.$row["cod_circuito"].'</option>';
					else 
						echo '<option value="'.$row["cod_circuito"].'">Circuito '.$row["cod_circuito"].'</option>';
				}			
				
			?>
              </select>
              </font></td>
          </tr>
          <tr> 
            <td>Referencial</td>
            <?php $consulta="select ref_cir from ref_web.referenciales where cod_circuito='".$cmbcircuito."' and fecha='".$ano2.'-'.$mes2.'-'.$dia2."'";
			   $rs = mysqli_query($link, $consulta);
			   $row = mysqli_fetch_array($rs);
			   $ref_cir = isset($row['ref_cir'])?$row['ref_cir']:"";
			?>
            <td width="132"><input name="txtreferencial" type="text" size="10" value="<?php echo $ref_cir; ?>"> 
            <td width="148">&nbsp; 
        </table> 
        <br>
		<?php
	  		//Campo oculto.
			//echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
		
        <table width="462" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td align="center">
			    <input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="Grabar(this.form)">
                <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"></td>
          </tr>
        </table>
    </tr>
</table>	
</form>
<?php
	if ($activar!="")
	{
		echo '<script language="JavaScript">';		
		if ($fecha!="")
			/*echo 'alert("'.$fecha.'");';		*/
			
		//echo 'window.opener.document.frmPrincipal.action = "datos_consumo.php?fecha_ini='.$fecha.'";';
		//echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php include("../principal/cerrar_sec_web.php"); ?>


