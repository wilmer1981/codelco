<?Php
	$CodigoDeSistema=19;
	$CodigoDePantalla=5;	
?>
<!-----------------------------------------  Inicio Html  ------------------------------------------------->
<html>
<head>
	<title>Estadistica de Gr&aacute;ficos</title>
	<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<script language="JavaScript">
		/****Funcion de PopUp_grafico A******/
		function popup_grafico(letra)
		{
			var f = document.form1;
			<!------------------  Valor  UF por Año  ------------------------------------------------------------------->
			if (letra =="A"){
				window.open("graficos/graf_valor_uf.php","valor_uf"," fullscreen=no,left=165,top=100,width=540,height=340,scrollbars=yes,resizable = no");
			}
			<!------------------  Nª de Accidentes por Centro de Costo  ------------------------------------------------------------------->
			if (letra =="B"){
				window.open("graficos/graf_acc_x_cc.php","acc_x_cc"," fullscreen=no,left=165,top=100,width=600,height=360,scrollbars=yes,resizable = no");
			}
			<!------------------  Nª de Accidentes por Mes ------------------------------------------------------------------->
		/*	if (letra=="C"){
				window.open("");
			}	*/
		}
		<!---------------------------- Funcion Proceso (Salir)  ----------------------------------------------->
		function Proceso(opt)
		{
			var f = document.form1;
			switch (opt)
			{
				case "S":
					f.action = "../principal/sistemas_usuario.php?CodSistema=19";
					f.submit();
					break;
			}
		}
		<!----------------- FIN DE FUNCIONES --------------------------------------------------------->
	</script>
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>
<!-------------------------------------- Cuerpo Principal  ---------------------------------------------------->
<body>
<form name="form1" method="post" action="">
	<? include("../principal/encabezado.php");?>
	<div align="left">
	    <!--------------------------------Tabla Principal ---------------------------------->
		<table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
    	  <tr>
        	<td height="313" valign="top">     			
				<p align="center" class="Titulo1"><br>
				  <b>Gr&aacute;ficos </b>
				</p>
				 <!------------------------  Botones de Selecion de Gráficos  ---------------------------->
				<table width='50%' border=1 cellspacing=1 cellpadding=2 align='center' class='TablaDetalle'>
					<tr class='ColorTabla01'>
						<td align='center'><a href="JavaScript:popup_grafico('A')"><font color="#FFFFFF">Valor UF por A&ntilde;o<font></a></td>
						<td align='center'><a href="JavaScript:popup_grafico('B')"><font color="#FFFFFF">N&ordm; Accidentes por CC<font></a></td>
						<td align='center'><a href="JavaScript:popup_grafico('C')"><font color="#FFFFFF">N&ordm; Accidentes por Mes<font></a></td>
					</tr>
				</table>
				<br>
				<!------------------------  Formulario para el Boton Salir Proceso ----------------------->
	 		    
			       <center>
					  <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70px " onClick="Proceso('S')">				  
				   </center>
	  			
			</td>
		  </tr>
		</table>
	    <!------------------------------Fin Tabla Principal ---------------------------------->
	  <? include("../principal/pie_pagina.php");?>
</form>	  	  
</body>
</html>
