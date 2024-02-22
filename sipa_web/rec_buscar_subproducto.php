<?php
  include("../principal/conectar_principal.php");

  if(isset($_REQUEST["Buscar"])){
		$Buscar=$_REQUEST["Buscar"];
	}else{
		$Buscar="";
	}

  if(isset($_REQUEST["TxtBusqueda"])){
		$TxtBusqueda = $_REQUEST["TxtBusqueda"];
	}else{
		$TxtBusqueda = "";
	}
  	
?>
<html>
<head>
<script language="JavaScript">

function Buscar()
{

	var Frm=document.FrmBuscarSolicitud;
    Frm.action= "rec_buscar_subproducto.php?Buscar=S";
	Frm.submit();
}		
</script>
<title>Buscar Sub-Producto</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
</head>
<body background="../principal/imagenes/fondo3.gif">

<form action="" method="post" name="FrmBuscarSolicitud" id="FrmBuscarSolicitud">
  <table width="516" border="0" cellpadding="5" class="tablaprincipal">
    <tr> 
      <td>
		<table width="500" border="0" cellpadding="5" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="86" height="30"><div align="right">Sub-Producto</div></td>
            <td width="576"><font size="2">&nbsp; </font> <font size="2">&nbsp; 
              </font><font size="2"> 
              <input type="text" name="TxtBusqueda" maxlength="40" style="width:150">
              &nbsp; 
              <input name="BtnBuscar" type="button" id="BtnBuscar" value="Buscar" onClick="Buscar();" style="width:60">
              <input name="BtnBuscar2" type="button" id="BtnSalir" value ="Salir" style="width:60" onClick="javascript:window.close();">
              </font></td>
          </tr>
        </table>
        <br> 
        <table width="500" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr class="ColorTabla01"> 
            <td> <div align="center"></div>
              <div align="center"><strong>Producto</strong></div></td>
            <td> <div align="center"><strong>SubProducto</strong></div>
              <div align="center"></div></td>
          </tr>
     <?php
		if (isset($Buscar))
		{
			include ("../Principal/conectar_cal_web.php");	   
			$Consulta = "SELECT t1.descripcion as nomproducto,t2.descripcion as nomsubproducto from proyecto_modernizacion.productos t1";
			$Consulta = $Consulta." inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto = t2.cod_producto ";
			$Consulta = $Consulta." where t2.descripcion like '%".$TxtBusqueda."%' order by nomproducto,nomsubproducto";
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr bgcolor='#FFFFFF'>\n";
				echo "<td>".ucwords(strtolower($Fila["nomproducto"]))."&nbsp;</td>\n";
				echo "<td>".ucwords(strtolower($Fila["nomsubproducto"]))."&nbsp;</td>\n";
				echo "</tr>";
			}		
		}		
	?>
        </table></td>
    </tr>
  </table>
</form>
<br>
<br>
<br>
</body>
</html>
