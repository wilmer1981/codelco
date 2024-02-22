<?php 
$CodigoDeSistema=2; 
if(isset($_REQUEST["mes"])) {
	$mes = $_REQUEST["mes"];
}else{
	$mes =  date("m");
}
if(isset($_REQUEST["ano"])) {
	$ano = $_REQUEST["ano"];
}else{
	$ano =  date("Y");
}
if(isset($_REQUEST["mostrar"])) {
	$mostrar = $_REQUEST["mostrar"];
}else{
	$mostrar = "";
}

?>
<html>
<head>
<title>Sistema de Anodos</title>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=2";
}
/**********************/
function Proceso(f,valor)
{
	window.open("sea_cierra_mes_popup.php?mes=" + f.mes.value + "&ano=" + f.ano.value + "&valor=" + valor, "","top=200 left=200 menubar=no resizable=no width=403 height=205");
}
</script>
</head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="762" align="center" valign="top">

<table width="500" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="259" height="23">Mes De Cierre</td>
            <td width="326"> <select name="mes" size="1">
                <?php
			$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<13;$i++)
		  	{
				if (($mostrar == "S") && ($i == $mes))
					echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else if (($i == date("n")) && ($mostrar != "S"))
						echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				else
					echo "<option value='$i'>".$meses[$i-1]."</option>\n";			
			}		  
		?>
              </select> <select name="ano" size="1">
                <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (($mostrar == "S") && ($i == $ano))
					echo "<option selected value ='$i'>$i</option>";
				else if (($i == date("Y")) && ($mostrar != "S"))
					echo "<option selected value ='$i'>$i</option>";
				else	
					echo "<option value='".$i."'>".$i."</option>";
			}
		?>
              </select> </td>
          </tr>
        </table>
        <br>
        <table width="500" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="601" align="center"><input name="btnabrir" type="button" style="width:70" value="Abrir Mes" onClick="Proceso(this.form,0)"> 
              <input name="btncerrar" type="button"  value="Cerrar Mes" style="width:70" onClick="Proceso(this.form,1)">
              <input name="btnsalir" type="button"  value="Salir" style="width:70" onClick="Salir()"></td>
          </tr>
        </table> <br></td>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?> 
</form>
</body>
</html>
