<?php 	
	include("../principal/conectar_sec_web.php");

	if($Proceso=='M')
	{
		$consulta = "SELECT * FROM sec_web.recepcion_catodo_externo";
		$consulta.= " WHERE lote_origen = '".str_pad($LoteMod,8,'0',STR_PAD_LEFT)."' AND recargo = '".$RecMod."'";
		//echo "CCCC".$consulta;
		$rs = mysqli_query($link, $consulta);
		//echo $consulta."<br>";
		
		if ($row = mysqli_fetch_array($rs))
		{
			$Msj=1;
		}
		else
		{ 
			
			$consulta = "SELECT * FROM sipa_web.recepciones";
			$consulta.= " WHERE lote = '".str_pad($LoteMod,8,'0',STR_PAD_LEFT)."' AND recargo = '".$RecMod."' AND cod_subproducto = '18'";
			//echo $consulta."<br>";
			
			$rs1 = mysqli_query($link, $consulta);
			if ($row1 = mysqli_fetch_array($rs1))
			{
				//ACTUALIZAR LOTE Y DETALLE EN SEC
				$Actualizar="UPDATE sec_web.recepcion_catodo_externo set lote_origen='".$LoteMod."', recargo='".$RecMod."' where lote_origen='".$Lote."' and recargo='".$Rec."'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
				$Actualizar="UPDATE sec_web.paquete_catodo_externo set lote_origen='".$LoteMod."', recargo='".$RecMod."' where lote_origen='".$Lote."' and recargo='".$Rec."'";
				mysqli_query($link, $Actualizar);
				//echo $Actualizar."<br>";
				$Msj=2;
			}
			else			
				$Msj=3;	
		}
			
		
	}
	
?>
<html>
<head>
<script language="JavaScript">
function Modificar()
{
	var f=document.FrmModifLote;
		
	if (confirm('Esta Seguro de Modificar Lote'))
	{
		if(f.LoteMod.value=='')
		{
			alert('Debe ingresar lote a modificar');
			return;	
		}
		if(f.RecMod.value=='')
		{
			alert('Debe ingresar recargo a modificar');
			return;	
		}
		f.action="sec_ing_produccion_popup1_mod_lote.php?Proceso=M&LoteMod="+f.LoteMod.value+'&RecMod='+f.RecMod.value;
		f.submit();
		
	}	
}

function Salir()
{
	window.opener.document.frmPopUp.action = "sec_ing_produccion_popup1.php?mostrar=S";
	window.opener.document.frmPopUp.submit();	
	window.close();
}
</script>
<title>Modificar Lote</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
.Estilo4 {color: #CC0000}
-->
</style>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
 <form name="FrmModifLote" method="post" action="">
 <table width="350" height="185" border="0" left="5" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr><td class="ColorTabla02"><strong>Modificar Lote</strong></td></tr>
    <tr>
	<td align="center"><br>
	  <br>
		<table width="346" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
		  <tr>
		    <td width="99">Lote a Modificar</td>
		    <td><input name="Lote" type="text" value="<?php echo $Lote; ?>" size="10" readonly>-<input name="Rec" type="text" maxlength="6" value="<?php echo $Rec; ?>" size="3" readonly></td>
	      </tr>

		  <tr>
		    <td width="99">Lote Nuevo</td>
		    <td><input name="LoteMod" type="text" maxlength="8" value="<?php echo $LoteMod; ?>" size="10">-<input name="RecMod" type="text" maxlength="2" value="<?php echo $RecMod; ?>" size="3"></td>
	      </tr>
		</table>
        <br><br>
		<table width="350" border="0" class="tablainterior">
          <tr>
			<td width="491" align="center">
			<input type="button" name="BtnOK" value="Modificar" style="width:70" onClick="Modificar();">
			<input type="button" name="BtnSalir" value="Salir" style="width:70" onClick="Salir();">
			</td>
		  </tr>
		</table>
	</td>
  </tr>
  </table>

<?phpPHP
if($Msj==1)
{
?>
<script language="javascript">
alert("Lote y recargo ya fue ingresado al sistema");
</script>
<?php
}
if($Msj==2)
{
	echo "<script language='javascript'>";
	echo "alert('Lote Modificado Exitosamente');";
	echo "window.opener.document.frmPopUp.action = 'sec_ing_produccion_popup1.php?mostrar=S';";
	echo "window.opener.document.frmPopUp.submit();";	
	echo "window.close();";
	echo "</script>";	
}
if($Msj==3)
{
?>
<script language="javascript">
alert("Lote y recargo no se existe en sistema SIPA");
</script>
<?php	
}
?>

</form>
</body>
</html>
