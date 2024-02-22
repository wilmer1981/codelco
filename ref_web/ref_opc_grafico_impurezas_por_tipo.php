<?php
	include("../principal/conectar_sec_web.php");
	$consulta = "select count(cod_leyes) as contador from ref_web.leyes";
	$Respuesta = mysqli_query($link, $consulta);
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
	echo "conrador : ".$Fila[contador];
	}

?>
<html>
<head>
<title>Seleccion de Leyes para Grafico</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Grafico()
{
  var  f=document.frmPopup;
  var DiaIni=f.DiaIni.value;
  var MesIni=f.MesIni.value;
  var AnoIni=f.AnoIni.value;
  var DiaFin=f.DiaFin.value;
  var MesFin=f.MesFin.value;
  var AnoFin=f.AnoFin.value;
  var Valores = "";
  var cont=0;
  for (i=1;i<f.elements.length;i++)
	{
	  if (cont<3)
	   {
		if (f.elements[i].type=="checkbox" && f.elements[i].name.substring(0,8)=="checkbox" && f.elements[i].checked==true)
		 {
			if (cont==0)
			   {
			    var ley1=f.elements[i].value;
			   }
			if (cont==1)
			   {
			    var ley2=f.elements[i].value;
			   }
			if (cont==2)
			   {
			    var ley3=f.elements[i].value;
			   }     
			cont++;
		 }
	   }	 	
	}
	
	
	if ((ley1 == "")&&(ley2 == "")&&(ley3 ==""))
	{
		alert("seleccione algo");
		return;
	}
	else
	{
		var largo = Valores.length;
		Valores = Valores.substring(0,largo - 1)
		//alert (Valores);
	}
	
  	Mensaje = confirm("Solo se mostrara el garfico con las primeras 3 leyes que seleccione.¿Esta seguro de las leyes seleccionadas?");
    
		if (Mensaje==false)
		{
		 return;
		}
        else
        {
		  window.open("ref_grafico_impurezas_electrolito.php?AnoIni="+AnoIni+"&MesIni="+MesIni+"&DiaIni="+DiaIni+"&AnoFin="+AnoFin+"&MesFin="+MesFin+"&DiaFin="+DiaFin+"&cmbcircuito="+f.cmbcircuito.value+"&ley1="+ley1+"&ley2="+ley2+"&ley3="+ley3,"","menubar=no resizable=no top=70 left=150 width=940 height=650 scrollbars=no");
	    }
}
/****************/
function Salir()
{
	window.close();
}
</script>
</head>
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPopup" action="" method="post">
  <table width="738" height="94" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="786" height="92" colspan="8" align="left" valign="left"> 
	  <table width="728" border="1" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="210">Fecha Inicio: <?php echo $DiaIni.'-'.$MesIni.'-'.$AnoIni?>
			<input name="DiaIni" type="hidden" value="<?php echo $DiaIni;?>">
			<input name="MesIni" type="hidden" value="<?php echo $MesIni;?>">
			<input name="AnoIni" type="hidden" value="<?php echo $AnoIni;?>"></td>
            <td width="259">Fecha Termino:<?php echo $DiaFin.'-'.$MesFin.'-'.$AnoFin?>
			<input name="DiaFin" type="hidden" value="<?php echo $DiaFin;?>">
			<input name="MesFin" type="hidden" value="<?php echo $MesFin;?>">
			<input name="AnoFin" type="hidden" value="<?php echo $AnoFin;?>"></td>
            <td width="88">Circuito:<?php echo $cmbcircuito;?>
			<input name="cmbcircuito" type="hidden" value="<?php echo $cmbcircuito;?>"></td>
            <td width="137"><input name="grafico" type="button" value="Grafico" onClick="Grafico()">
              <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Salir()" value="Salir"></td>
          </tr>
          <tr> 
            <table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="TablaDetalle">
              <tr class="ColorTabla01"> 
                <td width="200" align="center" colspan="8"><div align="center"><strong>Seleccione 
                    Elementos para Grafico</strong></div></td>
              </tr>
              <tr> 
                <td width="47" align="center"><fieldset><legend><strong>Cu</strong></legend><input type="checkbox" name="checkbox1" value="02"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>As</strong></legend><input type="checkbox" name="checkbox2" value="08"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Sb</strong></legend><input type="checkbox" name="checkbox3" value="09"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Zn</strong></legend><input type="checkbox" name="checkbox4" value="10"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>SS</strong></legend><input type="checkbox" name="checkbox5" value="72"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Bi</strong></legend><input type="checkbox" name="checkbox6" value="27"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Fe</strong></legend><input type="checkbox" name="checkbox7" value="31"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Ni</strong></legend><input type="checkbox" name="checkbox8" value="36"></fieldset></td>
              </tr>
              <tr> 
                <td width="47" align="center"><fieldset><legend><strong>Pb</strong></legend><input type="checkbox" name="checkbox9" value="39"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Se</strong></legend><input type="checkbox" name="checkbox10" value="40"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Te</strong></legend><input type="checkbox" name="checkbox11" value="44"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Cl</strong></legend><input type="checkbox" name="checkbox12" value="50"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Ca</strong></legend><input type="checkbox" name="checkbox13" value="56"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>Mg</strong></legend><input type="checkbox" name="checkbox14" value="60"></fieldset></td>
                <td width="47" align="center"><fieldset><legend><strong>H2SO4</strong></legend><input type="checkbox" name="checkbox15" value="22"></fieldset></td>
                <td width="47">&nbsp;</td>
            </table>
          </tr>
        </table>
    </tr>
  </table>	  
</form>
</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>


