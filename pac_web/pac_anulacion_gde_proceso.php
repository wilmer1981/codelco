<?php 	
	
	$CodigoDeSistema = 9;
	$CodigoDePantalla = 1;
	include("../principal/conectar_pac_web.php");

	$Consulta = "select * from proyecto_modernizacion.funcionarios ";
			$Consulta.= " where rut='".$CookieRut."'";
			$Resp=mysqli_query($link, $Consulta);
			$Favoritos="";
			if ($Fila=mysqli_fetch_array($Resp))
			{
				$Favoritos=$Fila["favoritos"];
				$PrimerNombre=$Fila["nombres"];
				for ($i=0;$i<=strlen($PrimerNombre);$i++)
				{
					if (substr($PrimerNombre,$i,1)==" ")
					{
						$PrimerNombre=trim(substr($PrimerNombre,0,$i));
						break;
					}
				}
				$NombreUser = ucwords(strtolower($PrimerNombre))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".strtoupper(substr($Fila["apellido_materno"],0,1)).".";
				$Caduca=$Fila["caduca"];
			}

	$NG = substr(str_replace("//","-",$Valores),0,-1);

?>
<html>
<head>
<script language="JavaScript">



function Grabar(Proceso)
{
	var Frm=document.FrmProceso;

	if (Frm.TxtObs.value == "")
	{
		alert("Debe Ingresar la Observación de anulación")
		Frm.TxtObs.focus();
		return;
	}
	
	Frm.action="pac_guia_despacho_proceso01.php?Proceso="+Proceso+"&NG="+Frm.NG.value;
	Frm.submit();


	
}
function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">


<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
<!--   	    <?phpecho " DIVSAP->".$DivSap;
		echo " ALMACEN->".$TxtAlmacenSap;
		echo " SELLOS->".$TxtSellos;
		echo " Producto->".$CmbProd;
		echo " Unidad->".$CmbUnidad;
		echo " Originador->".$CmbOri;?> -->
    <tr>
    <td><table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td>
            	<input type="hidden" name="hdn_rut" id="hdn_rut" value="<?php echo $CookieRut; ?>">Funcionario</td>
            <td> 
            	<strong><?php echo $NombreUser;?></strong>
            </td>
          </tr>
          <tr> 
            <td>Nro Gu&iacute;a</td>
            <td>
            <input type="hidden" name="NG" id="NG" value="<?php echo $NG; ?>"> 
            <strong><?php echo $NG;?></strong>
            </td>
        </tr>
          <tr>
            <td>Observaci&oacute;n</td>
            <td>
            <textarea name="TxtObs" id="TxtObs" rows="4" cols="30"></textarea>
            </td>
          </tr>
        </table>
        <br>
        <table width="395" border="0" cellpadding="5" class="TablaInterior">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('A')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
