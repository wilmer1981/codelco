<?php
	include("../principal/conectar_principal.php");
	switch($Proc)
	{
		case "M":
			$Datos = explode("~~",$Valores);	
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase='15009' and cod_subclase='".$Datos[0]."'";
			$Resp = mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Resp))
			{
				$TxtLab=$Fila["nombre_subclase"];
				$TxtCod=$Fila["cod_subclase"];
				$CmbTipoCambio=$Fila["valor_subclase1"];
				$TxtValorCu=$Fila[valor_subclase2];
				$TxtValorAg=$Fila[valor_subclase3];
				$TxtValorAu=$Fila[valor_subclase4];
			}	
			break;
		case "N":
			$Consulta = "select ifnull(max(cod_subclase)+1,1) as cod from proyecto_modernizacion.sub_clase where cod_clase='15009' ";
			$Resp = mysqli_query($link, $Consulta);
			if($Fila=mysqli_fetch_array($Resp))
			{
				$TxtCod=$Fila[cod];
			}	
			break;
	}
?>
<html>
<head>
<title>Sistema de Agencia</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(opt)
{
	var f= document.frmPopUp;
	switch (opt)
	{
		case "G":
			if (f.TxtLab.value=="")
			{
				alert("Debe Ingresar Laboratorios");
				f.TxtLab.focus();
				return;
			}	
			f.action = "age_ing_laboratorio01.php?Proceso="+f.Proc.value;
			f.submit();
			break;		
		case "S":
			window.opener.document.frmPrincipal.action = "age_ing_laboratorio.php";
			window.opener.document.frmPrincipal.submit();
			window.close();
			break;
		case "R":
			f.action = "age_ing_laboratorio02.php";
			f.submit();
			break;
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>
<body leftmargin="3" topmargin="5">
<form name="frmPopUp" action="" method="post">
<input type="hidden" name="Proc" value="<?php echo $Proc?>">
<input type="hidden" name="TxtCod" value="<?php echo $TxtCod;?>">
        <br>
        <table width="450" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr align="center">
            <td colspan="2" class="Detalle01"><strong>LABORATORIOS</strong></td>
          </tr>
          <tr>
            <td class="Detalle02">Nombre Laboratorio: </td>
            <td><input type='text' name='TxtLab' value="<?php echo $TxtLab;?>" size="60">
</td>
          </tr>  
          <tr>
            <td width="131" class="Detalle02">Tipo Cambio: </td>
            <td width="300">
			<select name='CmbTipoCambio' style="width:80">
			<?php
				switch($CmbTipoCambio)
				{
					case "US":
						echo "<option value='US' selected>US$</option>";
						echo "<option value='UF'>UF</option>";
						echo "<option value='S'>$</option>";
						break;
					case "UF":
						echo "<option value='US'>US$</option>";
						echo "<option value='UF' selected>UF</option>";
						echo "<option value='S'>$</option>";
						break;
					case "S":
						echo "<option value='US'>US$</option>";
						echo "<option value='UF'>UF</option>";
						echo "<option value='S' selected>$</option>";
						break;
					default:
						echo "<option value='US' selected>US$</option>";
						echo "<option value='UF'>UF</option>";
						echo "<option value='S'>$</option>";
						break;
				}
			?>
			</select>&nbsp;</td>
          </tr>
          <tr>
            <td class="Detalle02">Valor Cu:</td>
            <td><input type='text' name='TxtValorCu' value="<?php echo $TxtValorCu;?>" size="15"></td>
          </tr>
          <tr>
            <td class="Detalle02">Valor Ag:</td>
            <td><input type='text' name='TxtValorAg' value="<?php echo $TxtValorAg;?>" size="15"></td>
          </tr>
          <tr>
            <td class="Detalle02">Valor Au:</td>
            <td><input type='text' name='TxtValorAu' value="<?php echo $TxtValorAu;?>" size="15">
</td>
          </tr>
          <tr>
            <td colspan="2" align="center"><input name="BtnGrabar" type="button" id="BtnGrabar" value="Grabar" style="width:70px " onClick="Proceso('G')">
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')"></td>
          </tr>
  </table>
</form>
</body>
</html>