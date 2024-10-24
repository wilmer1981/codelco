<?php
$Proceso = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$buscar  = isset($_REQUEST["buscar"])?$_REQUEST["buscar"]:"";
$radio   = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";
$cod_tipo_lugar = isset($_REQUEST["cod_tipo_lugar"])?$_REQUEST["cod_tipo_lugar"]:"";
$cod_tipo       = isset($_REQUEST["cod_tipo"])?$_REQUEST["cod_tipo"]:"";
$descripcion    = isset($_REQUEST["descripcion"])?$_REQUEST["descripcion"]:"";
$mensaje        = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
	
$CodigoDeSistema = 7;
$CodigoDePantalla = 2;

 if($buscar == "S")
 {
	$consulta = "SELECT * FROM tipo_lugar WHERE cod_tipo_lugar = $radio";
    include("../principal/conectar_ram_web.php");
	$rs = mysqli_query($link, $consulta);
	
	if($row = mysqli_fetch_array($rs))
	{	
       $cod_tipo    = $row["cod_tipo_lugar"];
	   $descripcion = $row["descripcion_lugar"];
	}
 }
?>
<html>

<head>
    <title>Creaci&oacute;n de Tipo de Lugares</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript">
    function TeclaPulsada() {
        var Frm = document.FrmProceso;
        var teclaCodigo = event.keyCode;
        var CantComas = 0;

        //alert(teclaCodigo);	
        if (teclaCodigo == 13) {
            //Frm.CmbHoraInicio.focus();
        } else {
            if ((teclaCodigo != 188) && (teclaCodigo != 110) && (teclaCodigo != 190) && (teclaCodigo != 37) && (
                    teclaCodigo != 39) && (teclaCodigo != 9)) {
                if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57)) {
                    if ((teclaCodigo < 96) || (teclaCodigo > 105)) {
                        event.keyCode = 46;
                    }
                }
            } else {
                /*CantComas=Frm.TxtStockInicial[1].value.search(',');
                if (CantComas!=-1)
                {
                	event.keyCode=46;
                	return;
                }
                if ((Frm.TxtStockInicial[1].value.substr(Frm.TxtStockInicial[1].value.length-1,1)==",")||(Frm.TxtStockInicial[1].value.substr(Frm.TxtStockInicial[1].value.length-1,1)==""))
                {
                	if ((teclaCodigo != 37)&&(teclaCodigo != 39))
                	{
                		event.keyCode=46;
                	}	
                }*/
            }
        }
    }


    function Nuevo_Dato() {
        var f = formulario;
        window.location = "ram_ing_tipo_lugar.php";
    }

    function valida_campos() {
        var f = formulario;

        if (f.cod_tipo.value == '') {
            alert("Debe Ingresar Tipo de Lugar");
            f.cod_tipo.focus();
            return 1
        }

        if (f.descripcion.value == '') {
            alert("Debe Ingresar Decripción del Lugar");
            f.descripcion.focus();
            return 1
        }


    }


    function Buscar() {
        var f = formulario;

        f.action = "ram_ing_tipo_lugar.php?Proceso=V&buscar=S";
        f.submit();
    }

    function Guardar_Datos() {
        var f = formulario;

        if (valida_campos() != 1) {
            f.action = "ram_ing_tipo_lugar01.php?Proceso=G";
            f.submit();
        }
    }

    function Eliminar_Datos() {
        var f = formulario;

        if (valida_campos() != 1) {
            f.action = "ram_ing_tipo_lugar01.php?Proceso=E";
            f.submit();
        }
    }

    function Modificar_Datos() {
        var f = formulario;

        if (valida_campos() != 1) {
            f.action = "ram_ing_tipo_lugar01.php?Proceso=M";
            f.submit();
        }
    }

    function mostrar() {
        var f = formulario;

        f.action = "ram_ing_tipo_lugar.php?Proceso=V";
        f.submit();
    }

    function salir_menu() {
        var f = formulario;
        f.action = "../principal/sistemas_usuario.php?CodSistema=7";
        f.submit();
    }
    </script>
    <link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
    <style type="text/css">
    <!--
    body {
        margin-left: 3px;
        margin-top: 3px;
        margin-right: 0px;
        margin-bottom: 0px;
    }
    -->
    </style>
</head>

<body>
    <form name="formulario" method="post" action="">
        <?php include("../principal/encabezado.php")?>
        <?php include("../principal/conectar_principal.php") ?>

        <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
            <tr>
                <td align="center" valign="top">
                    <table width="88%" class="TablaDetalle" cellpadding="3" cellspacing="0">
                        <tr>
                            <td width="146"><img src="../principal/imagenes/left-flecha.gif" width="11"
                                    height="11">&nbsp;C&oacute;digo Tipo Lugar</td>
                            <td width="103">
                                <?php			
								if($buscar == "S")			 
									echo'<input name="cod_tipo" type="text" value="'.$cod_tipo.'" size="4" onKeyDown="TeclaPulsada()">';
								else
									echo'<input name="cod_tipo" type="text" size="4" onKeyDown="TeclaPulsada()">';
								?>
                            </td>
                            <td width="397">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><img src="../principal/imagenes/left-flecha.gif" width="11"
                                    height="11">&nbsp;Descripcion Tipo Lugar</td>
                            <td colspan="2">
                                <?php			
			if($buscar == "S")			 
				echo'<input name="descripcion" type="text" value="'.$descripcion.'" size="50">';
			else
				echo'<input name="descripcion" type="text" size="50">';
			?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div align="center">
                                    <?php
				 if($buscar != "S")
				 	echo'<input name="guardar" type="button" style="width:70" value="Guardar" onClick="Guardar_Datos();">';
                 else
				 {
					echo'<input name="nuevo" type="button"  value="Nuevo" onClick="Nuevo_Dato();" style="width:70px">&nbsp;';
				 	echo'<input name="guardar" type="button" style="width:70" value="Guardar" disabled>';
				 }
				?>
                                    <?php
				 if($buscar == "S")
				 {
					echo'<input name="modificar" type="button"  value="Modificar" onClick="Modificar_Datos();" style="width:70px">&nbsp;';				
					echo'<input name="Eliminar" type="button"  value="Eliminar" onClick="Eliminar_Datos();" style="width:70px">';
				 }
				 else
				 {
					echo'<input name="modificar" type="button"  value="Modificar" disabled>&nbsp;';
				    echo'<input name="Eliminar" type="button"  value="Eliminar" disabled>';
				 }
				?>
                                    <input name="detalle" type="button" value="Ver Detalle" onClick="mostrar();"
                                        style="width:80px">
                                    <input name="salir" type="button" style="width:70" onClick="salir_menu();"
                                        value="Salir">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table width="88%" class="TablaDetalle" cellpadding="3" cellspacing="0" border="1">
                        <tr class="ColorTabla01">
                            <td width="4%">&nbsp;</td>
                            <td width="36%">
                                <div align="center">Codigo Tipo</div>
                            </td>
                            <td width="60%">
                                <div align="center">Descripci&oacute;n Lugar</div>
                            </td>
                        </tr>
                        <?php
if($Proceso == "V")
{
	$consulta = "SELECT * FROM tipo_lugar ORDER BY cod_tipo_lugar";
    include("../principal/conectar_ram_web.php");
	$rs = mysqli_query($link, $consulta);

	while($row = mysqli_fetch_array($rs))
	{
	  echo'<tr><td><center>';
	  if($row["cod_tipo_lugar"] == $cod_tipo)
	  echo'<input type="radio" name="radio" value="'.$row["cod_tipo_lugar"].'" onClick="Buscar();" checked>';
	  else
	  echo'<input type="radio" name="radio" value="'.$row["cod_tipo_lugar"].'" onClick="Buscar();">';
  	  echo'</center></td>';
	  echo'<td><center>'.$row["cod_tipo_lugar"].'</center></td>';
	  echo'<td><center>'.$row["descripcion_lugar"].'</center></td></tr>';
	}
}

?>
                    </table>
                </td>
            </tr>
        </table>
        <?php include("../principal/pie_pagina.php")?>

    </form>
</body>

</html>
<?php
	if ($mensaje!="")
	{

			echo "<script languaje='javascript'>";
			echo "alert('".$mensaje."');";	
			echo "</script>";
	}
?>