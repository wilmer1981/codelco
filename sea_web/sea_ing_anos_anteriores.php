<?php 
  	include("../principal/conectar_sea_web.php");
  	include("funciones.php");
	
	$CodigoDeSistema = 2;
	$CodigoDePantalla = 57;

	if(isset($_REQUEST["g"])) {
		$g = $_REQUEST["g"];
	}else{
		$g =  "";
	}
	if(isset($_REQUEST["_v"])) {
		$_v = $_REQUEST["_v"];
	}else{
		$_v =  "";
	}
	if(isset($_REQUEST["AnosAnt"])) {
		$AnosAnt = $_REQUEST["AnosAnt"];
	}else{
		$AnosAnt =  "";
	}
	


	
if($g=='S')
{
	$Actualiza="UPDATE proyecto_modernizacion.clase set valor1='".$_v."' where cod_clase='2017'";
	mysqli_query($link, $Actualiza);
	$Msj='Mod';
}	

$Consulta="select valor1 from proyecto_modernizacion.clase where cod_clase='2017'";
$R=mysqli_query($link, $Consulta);
$AnosAnt=1;
if($F=mysqli_fetch_assoc($R))
	$AnosAnt=$F["valor1"];			
?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Proceso(Opc)
{
	var f=document.frm1;
	switch(Opc)
	{
		case "G":
			f.action = "sea_ing_anos_anteriores.php?g=S&_v="+f.AnosAnt.value;		
			f.submit();	
		break;	
		case "Mod":
			alert('Dato Modificado con Éxito')
		break;
	}
}
/**************/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2&Nivel=1&CodPantalla=30"
}
</script>
</head>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0" onLoad="Proceso('<?php echo $Msj;?>')">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
	  <td width="762" height="316" align="center" valign="top"> <br /><br />
        <table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr>
            <td colspan="2" class="ColorTabla01">Seleccione los a&ntilde;os anteriores a visualizar</td>
          </tr>
          <tr> 
            <td width="81" class="ColorTabla02">Cantidad</td>
            <td width="657">
            <select name="AnosAnt">
            <?php
			for($i=1;$i<=9;$i++)
			{
				if ($i == $AnosAnt)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			?>
            </select>
            </td>
          </tr>
        </table>
        <br>
        <br>
      <table width="450" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><input name="BtnCansultar2" type="button" value="Guardar" onClick="JavaScritp:Proceso('G')" style="width:70px">
            <input name="btnsalir" type="button" style="width:70;" value="Salir" onClick="JavaScritp:Salir()"></td>
        </tr>
      </table> </td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
<?php include("../principal/cerrar_sea_web.php") ?>
