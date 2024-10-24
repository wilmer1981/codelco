<?php

if(isset($_REQUEST["buscar"])){
	$buscar = $_REQUEST["buscar"];
}else{
	$buscar = "";
}
if(isset($_REQUEST["radio"])){
	$radio = $_REQUEST["radio"];
}else{
	$radio= "";
}
if(isset($_REQUEST["Proceso"])){
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso= "";
}
if(isset($_REQUEST["num_lugar"])){
	$num_lugar = $_REQUEST["num_lugar"];
}else{
	$num_lugar= "";
}
if(isset($_REQUEST["cmbtipo"])){
	$cmbtipo = $_REQUEST["cmbtipo"];
}else{
	$cmbtipo = "";
}//cmbestado
if(isset($_REQUEST["cmbestado"])){
	$cmbestado = $_REQUEST["cmbestado"];
}else{
	$cmbestado = "";
}
$mensaje      = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";

$CodigoDeSistema = 7;
$CodigoDePantalla = 1;

 if($buscar == "S")
 {
	$consulta = "SELECT * FROM lugar_conjunto WHERE num_lugar = $radio AND cod_tipo_lugar = $cmbtipo";
    include("../principal/conectar_ram_web.php");
	$rs = mysqli_query($link, $consulta);
	
	if($row = mysqli_fetch_array($rs))
	{	
       $num_lugar = $row["num_lugar"];
	   $descripcion = $row["descripcion_lugar"];
	   $cmbestado = $row["cod_estado"];
	}
 }
?>
<html>

<head>
    <title>Creaci&oacute;n de Lugares</title>
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
        window.location = "ram_creacion_lugar.php";
    }

    function valida_campos() {
        var f = formulario;

        if (f.cmbtipo.value == -1) {
            alert("Debe Ingresar Tipo de Lugar");
            f.cmbtipo.focus();
            return 1
        }

        if (f.num_lugar.value == '') {
            alert("Debe Númuero del Lugar");
            f.num_lugar.focus();
            return 1
        }

        if (f.descripcion.value == '') {
            alert("Debe Ingresar Decripción del Lugar");
            f.descripcion.focus();
            return 1
        }

        if (f.cmbestado.value == -1) {
            alert("Debe Ingresar Estado del Conjunto");
            f.cmbestado.focus();
            return 1
        }

    }


    function Buscar() {
        var f = formulario;

        f.action = "ram_creacion_lugar.php?Proceso=V&buscar=S";
        f.submit();
    }

    function Guardar_Datos() {
        var f = formulario;

        if (valida_campos() != 1) {
            f.action = "ram_creacion_lugar01.php?Proceso=G";
            f.submit();
        }
    }

    function Eliminar_Datos() {
        var f = formulario;

        if (valida_campos() != 1) {
            f.action = "ram_creacion_lugar01.php?Proceso=E";
            f.submit();
        }
    }

    function Modificar_Datos() {
        var f = formulario;

        if (valida_campos() != 1) {
            f.action = "ram_creacion_lugar01.php?Proceso=M";
            f.submit();
        }
    }

    function mostrar() {
        var f = formulario;

        f.action = "ram_creacion_lugar.php?Proceso=V";
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
        margin-right: 00px;
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
                            <td width="102"><img src="../principal/imagenes/left-flecha.gif" width="11"
                                    height="11">&nbsp;Tipo Lugar</td>
                            <td width="224">
                                <?php
			  
			  echo'<select name="cmbtipo" style="width:230" onChange="mostrar();">';
              echo'<option value = "-1" selected>SELECCIONAR</option>';
 	          
			  include("../principal/conectar_ram_web.php");
 		  	  $consulta = "SELECT * FROM tipo_lugar ORDER BY cod_tipo_lugar";
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row["cod_tipo_lugar"] == $cmbtipo)
					echo '<option value="'.$row["cod_tipo_lugar"].'" selected>'.$row["descripcion_lugar"].'</option>';
				else
					echo '<option value="'.$row["cod_tipo_lugar"].'">'.$row["descripcion_lugar"].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
                            </td>
                            <td width="320">&nbsp;</td>
                        </tr>
                        <tr>
                            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;N&uacute;mero
                                Lugar</td>
                            <td colspan="2">
                                <?php			
			if($buscar == "S")			 
				echo'<input name="num_lugar" type="text" value="'.$num_lugar.'" size="5" onKeyDown="TeclaPulsada()">';
			else	
				echo'<input name="num_lugar" type="text" size="5" onKeyDown="TeclaPulsada()">';
			?>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="../principal/imagenes/left-flecha.gif" width="11"
                                    height="11">&nbsp;Descripci&oacute;n</td>
                            <td colspan="2">
                                <?php
			if($buscar == "S")			 
				echo'<input name="descripcion" type="text" value="'.$descripcion.'" size="50"> ';
			else
				echo'<input name="descripcion" type="text" size="50"> ';
			?>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Estado
                            </td>
                            <td colspan="2">
                                <?php
			  
			  echo'<select name="cmbestado" style="width:110">';
              echo'<option value = "-1" selected>SELECCIONAR</option>';
 	          
			  include("../principal/conectar_ram_web.php"); 
			  $consulta = "SELECT * FROM estado_conjunto ORDER BY cod_estado";
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row["cod_estado"] == $cmbestado)
					echo '<option value="'.$row["cod_estado"].'" selected>'.$row["cod_estado"].' - '.$row["descripcion_estado"].'</option>';
				else
					echo '<option value="'.$row["cod_estado"].'">'.$row["cod_estado"].' - '.$row["descripcion_estado"].'</option>';									
			  
			  }		  
			  echo'</select>';
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
                                    <input name="salir" type="button" style="width:70" onClick="salir_menu();"
                                        value="Salir">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table width="88%" class="TablaDetalle" cellpadding="3" cellspacing="0" border="1">
                        <tr class="ColorTabla01">
                            <td width="44">&nbsp;</td>
                            <td width="149">
                                <div align="center">Num Lugar</div>
                            </td>
                            <td width="270">
                                <div align="center">Descripci&oacute;n Lugar</div>
                            </td>
                            <td width="169">
                                <div align="center">Estado</div>
                            </td>
                        </tr>
                        <?php
			if($Proceso == "V")
			{
$consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = '".$cmbtipo."' ORDER BY num_lugar";				include("../principal/conectar_ram_web.php");
				$rs = mysqli_query($link, $consulta);
			
				while($row = mysqli_fetch_array($rs))
				{
				  echo'<tr><td><center>';
				  if($row["num_lugar"] == $num_lugar)
				  echo'<input type="radio" name="radio" value="'.$row["num_lugar"].'" onClick="Buscar();" checked>';
				  else
				  echo'<input type="radio" name="radio" value="'.$row["num_lugar"].'" onClick="Buscar();">';
				  echo'</center></td>';
				  echo'<td><center>'.$row["num_lugar"].'</center></td>';
				  echo'<td><center>'.$row["descripcion_lugar"].'</center></td>';
				  echo'<td><center>'.$row["cod_estado"].'</center></td></tr>';
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