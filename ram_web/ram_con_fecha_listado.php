<?php include("../principal/conectar_ram_web.php");
if(isset($_REQUEST["Proceso"])){
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso= "";
}
if(isset($_REQUEST["Fecha"])){
	$Fecha = $_REQUEST["Fecha"];
}else{
	$Fecha= "";
}

if($Proceso == "E")
{
	$Eliminar = "DELETE FROM ram_web.control_listados WHERE fecha = '$Fecha'";
	mysqli_query($link, $Eliminar);
	
}


?>

<html>

<head>
    <title>Fechas de Listados Restringidos</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript">
    function ValidaSeleccion(Nombre) {
        var f = frmPoPup;
        var LargoForm = f.elements.length;
        var valor = "";
        for (i = 0; i < LargoForm; i++) {
            if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true)) {
                valor = f.elements[i].value;
            }
        }
        return valor;
    }
    //*********************//
    function Habilitar_Fecha(f) {
        var valor = ValidaSeleccion('radio');
        var f = frmPoPup;
        var fecha;

        if (valor != '') {
            f.action = "ram_con_fecha_listado.php?Proceso=E&Fecha=" + valor;
            f.submit();
        } else {
            alert('No hay Fecha Seleccionado');
            return
        }
    }

    /*function Habilitar_Fecha()
    {
    var f = formulario;

    		f.action = "ram_con_fecha_listado.php?Proceso=E";
    		f.submit();
    }*/
    </script>
    <link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
</head>

<body class="TablaPrincipal">
    <form name="frmPoPup" method="post" action="">
        <div align="center">

            <table cellpadding="3" cellspacing="0" width="250" border="1" bordercolor="#b26c4a" class="TablaPrincipal">
                <tr class="ColorTabla01">
                    <td align="center" colspan="3">Control Fecha Listado</td>
                </tr>
                <tr class="Detalle01">
                    <td width="64">&nbsp;</td>
                    <td width="372">&nbsp;&nbsp;&nbsp;&nbsp;Fecha</td>
                </tr>
                <?php
		$Consulta = "SELECT * FROM ram_web.control_listados where fecha != ''";
		$rs = mysqli_query($link, $Consulta);
		while($row = mysqli_fetch_array($rs))
		{
			echo '<tr>';
			echo '<td align="center"><input type="radio" name="radio" value="'.$row["fecha"].'"></td>';
			echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$row["fecha"].'</td>';
			echo '</tr>';					
		}
	?>
            </table>
            <p></p>
            <p></p>
            <p></p>
            <table cellpadding="3" cellspacing="0" width="250" border="0" align="center">
                <tr>
                    <td>
                        <div align="center">
                            <input name="hablitar" type="button" style="width:70;" value="Habilitar"
                                onClick="Habilitar_Fecha()">
                            <input name="btnsalir" type="button" style="width:100" value="Cerrar Ventana"
                                onClick="self.close()">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</body>

</html>
<?php include("../principal/cerrar_rec_web.php") ?>