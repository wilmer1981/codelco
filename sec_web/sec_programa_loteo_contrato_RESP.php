<?php 	
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
?>
<html>
<head>
<script language="JavaScript">
function RecuperarValores()
{
	var Frm=document.FrmProceso;
	var Valores=new String();	
	for (i=0;i<Frm.elements.length;i++)
	{
		if (Frm.elements[i].name == "NumIE")
		{		
			Valores=Valores + Frm.elements[i].value + "~~" + Frm.elements[i+1].value + "~~" + Frm.elements[i+2].value + "~~" + Frm.elements[i+3].value + "~~" + Frm.elements[i+4].value +"~~" + Frm.elements[i+5].value + "//";	
		}
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		Valores="";
		return(Valores);	
	}	
	
} 
function Grabar()
{
	var Frm=document.FrmProceso;
	var Valores="";
	Valores=RecuperarValores();
	if (Valores!='')
	{
		Frm.action = "sec_programa_loteo_proceso01.php?Proceso=MC&Valores="+Valores;
		Frm.submit();
	}
}
function Salir()
{
	window.opener.document.FrmProgLoteo.action = "sec_programa_loteo.php";
	window.opener.document.FrmProgLoteo.submit();
	window.close();
}
</script>
<title>Modificacion Contrato</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="563" height="119" border="0" align="center" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="481" border="1" align="center" cellpadding="3" cellspacing="0" >
          <tr align="center" class="ColorTabla01"> 
            <td width="69"><strong>I.E.</strong>&nbsp;&nbsp;</td>
            <td width="67"><strong>ENM/CODE</strong></td>
            <td width="81"><strong>CONTRATO</strong></td>
            <td width="43"><strong>CUOTA</strong></td>
            <td width="85">PUERTO EMB.</td>
            <td width="86">PUERTO DEST.</td>
          </tr>
          <?php	
	echo "<tr align='center'> \n";
		
	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$IE=$Datos2[0];
		$Tipo=$Datos2[1];
		switch ($Tipo)
		{
			case "E":
				$Tabla = "programa_enami";
				$Campo = "corr_enm";
				$Tit = "ENAMI";
				break;
			case "C":
				$Tabla = "programa_codelco";
				$Campo = "corr_codelco";
				$Tit = "CODELCO";
				break;
		}
		$Consulta = "select * from sec_web.".$Tabla." where ".$Campo." = '".$IE."'";
		$Respuesta = mysqli_query($link, $Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$Contrato = $Fila["cod_contrato"];
			$Cuota = $Fila["mes_cuota"];
			$PuertoEmb = $Fila["cod_puerto"];
			$PuertoDest = $Fila["cod_puerto_destino"];
		}
		echo "<td align='center'><input name='NumIE' type='hidden' value=".$IE.">";
		echo "<input name='EnmCode' type='hidden' value=".$Tipo.">".$IE."</td> \n";
		echo "<td align='center'>".$Tit."</td> \n";
		echo "<td align='center'><input name='Contrato' type='text' value='".$Contrato."' size='20' maxlength='20'></td>\n";
		echo "<td align='center'><select name='Cuota'>"; 
		echo "<option value='0'>Numero</option>";
		for ($i=1;$i<=12;$i++)
		{
			if ($i == $Cuota)
				echo "<option selected value='".$i."'>".$i."</option>";
			else
				echo "<option value='".$i."'>".$i."</option>";
		}
		echo "</select></td>\n";
		//PUERTO EMB
		$Consulta = "select * from sec_web.puertos";
		$Resp = mysqli_query($link, $Consulta);
		echo "<td align='center'><select name='PuertoEmb'>"; 
		echo "<option value='0'>Embarque</option>";
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($Fila["cod_puerto"] == $PuertoEmb)
				echo "<option selected value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]."-".$Fila["nom_aero_puerto"]."</option>";
			else
				echo "<option value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]."-".$Fila["nom_aero_puerto"]."</option>";
		}
		echo "</select></td>\n";
		$Consulta = "select * from sec_web.puertos";
		$Resp = mysqli_query($link, $Consulta);
		echo "<td align='center'><select name='PuertoDest'>"; 
		echo "<option value='0'>Destino</option>";
		while ($Fila = mysqli_fetch_array($Resp))
		{
			if ($Fila["cod_puerto"] == $PuertoDest)
				echo "<option selected value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]."-".$Fila["nom_aero_puerto"]."</option>";
			else
				echo "<option value='".$Fila["cod_puerto"]."'>".$Fila["cod_puerto"]."-".$Fila["nom_aero_puerto"]."</option>";
		}
		echo "</select></td>\n";
		echo "</tr>\n";
	}  
	
?>
        </table>
        <br>
        <table width="395" border="0" align="center">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar();">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>