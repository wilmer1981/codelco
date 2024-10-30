<?php 
include("../principal/conectar_ram_web.php");

if(isset($_REQUEST["cmbtipo"])){
	$cmbtipo = $_REQUEST["cmbtipo"];
}else{
	$cmbtipo = "";
}
if(isset($_REQUEST["cmbestado"])){
	$cmbestado = $_REQUEST["cmbestado"];
}else{
	$cmbestado = "";
}
if(isset($_REQUEST["Proceso"])){
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso= "";
}
if(isset($_REQUEST["cmbproducto"])){
	$cmbproducto = $_REQUEST["cmbproducto"];
}else{
	$cmbproducto= "";
}
if(isset($_REQUEST["num_conjunto"])){
	$num_conjunto = $_REQUEST["num_conjunto"];
}else{
	$num_conjunto= "";
}

$CodigoDeSistema = 7;
$CodigoDePantalla = 8;

/*if($Proceso == "B2")
{
	$Consulta = "SELECT * FROM ram_web.conjunto_ram WHERE num_conjunto = ".$num_conjunto;
	$rs2 = mysqli_query($link, $Consulta);
	
	if($row2 = mysqli_fetch_array($rs2))
	{
		$cmbtipo = $row2[cod_conjunto];
		$cmbproducto = $row2[cod_subproducto];
	}
}*/
?>
<html>

<head>
    <title>Busqueda de Conjuntos</title>
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

    function Recarga() {
        var f = formulario;

        f.action = "ram_lst_conjuntos.php";
        f.submit();
    }

    function buscar_conjunto() {
        var f = formulario;

        if (f.cmbtipo.value == -1) {
            alert("Debe Seleccionar Tipo Conjunto");
            f.cmbtipo.focus();
            return
        }

        if (f.cmbproducto.value == -1) {
            alert("Debe Seleccionar Tipo Producto");
            f.cmbproducto.focus();
            return
        }

        f.action = "ram_lst_conjuntos.php?Proceso=B";
        f.submit();
    }

    function buscar_conjunto2() {
        var f = formulario;

        if (f.cmbtipo.value == -1) {
            alert("Debe Seleccionar Tipo Conjunto");
            f.cmbtipo.focus();
            return
        }
        f.action = "ram_lst_conjuntos.php?Proceso=B2";
        f.submit();
    }

    function Imprimir() {
        window.print();
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
                <td width="776" align="center" valign="top">

                    <table cellpadding="3" cellspacing="0" width="666" align="center" border="0" bordercolor="#b26c4a"
                        class="TablaPrincipal">
                        <tr class="ColorTabla02">
                            <td colspan="5">
                                <div align="center">Consulta de Conjuntos</div>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo
                                de Conjunto</td>
                            <td colspan="2">
                                <?php
			  
			  echo'<select name="cmbtipo" style="width:150" onChange="Recarga();">';
			if($cmbtipo == -1)
				echo '<option value="-1" selected>Seleccionar</option>';			  	
			else
				echo '<option value="-1">Seleccionar</option>';			  	
			if($cmbtipo == 1)
				echo '<option value="1" selected>Producto Minero</option>';			  	
			else
				echo '<option value="1">Producto Minero</option>';			  	
			if($cmbtipo == 3)
				echo '<option value="3" selected>Circulante</option>';			  	
			else
				echo '<option value="3">Circulante</option>';			  	
			if($cmbtipo == 2)
				echo '<option value="2" selected>Mezcla</option>';			  	
			else
				echo '<option value="2">Mezcla</option>';			  	
			  echo'</select>';
			 ?>
                            </td>
                            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Estado
                                Conjunto</td>
                            <td>
                                <?php
			  
			  echo'<select name="cmbestado" style="width:110">';
              echo'<option value = "-1" selected>Todos</option>';
 	          
			  include("../principal/conectar_ram_web.php"); 
			  $consulta = "SELECT * FROM estado_conjunto ORDER BY cod_estado";
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row["cod_estado"] ==  $cmbestado)
					echo '<option value="'.$row["cod_estado"].'" selected>'.$row["descripcion_estado"].'</option>';
				else
					echo '<option value="'.$row["cod_estado"].'">'.$row["descripcion_estado"].'</option>';									
			  
			  }		  
			  echo'</select>';
			 ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="26"><img src="../principal/imagenes/left-flecha.gif" width="11"
                                    height="11">&nbsp;Producto</td>
                            <td colspan="2">
                                <?php
			  echo'<select name="cmbproducto" style="width:230">';              

			  echo'<option value = "-1" selected>SELECCIONAR</option>';
			  $prod = $cmbtipo;
			  if($prod == 3)
			  	$prod = 42;
			  $consulta = "SELECT * FROM proyecto_modernizacion.subproducto WHERE prod_ram = '".$prod."' ORDER BY cod_subproducto";
			  $rs = mysqli_query($link, $consulta);
			  
			  while($row = mysqli_fetch_array($rs))
			  {
				if ($row["cod_subproducto"] == $cmbproducto)
					echo '<option value="'.$row["cod_subproducto"].'" selected>'.$row["descripcion"].'</option>';
				else
					echo '<option value="'.$row["cod_subproducto"].'">'.$row["descripcion"].'</option>';									
			  
			  }
			  if($cmbtipo == "2")
			  {
					if ($cmbproducto == "10")
  			  			echo'<option value = "10" selected>Mezcla</option>';
					else	
  			  			echo'<option value = "10">Mezcla</option>';
		  	  } 	
			  echo'</select>';
			 ?>
                            </td>
                            <td><input name="buscar" type="button" style="width:70" value="Buscar"
                                    onClick="buscar_conjunto();"></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="120" height="26"><img src="../principal/imagenes/left-flecha.gif" width="11"
                                    height="11">&nbsp;N&deg;
                                Conjunto</td>
                            <td width="102">
                                <?php
			if($Proceso == "B2")
			{	
				echo'<input name="num_conjunto" type="text" size="5" value="'.$num_conjunto.'" onKeyDown="TeclaPulsada()">';

			}
			else
				echo'<input name="num_conjunto" type="text" size="5" onKeyDown="TeclaPulsada()">';
			?>
                            </td>
                            <td width="103"><input name="buscar2" type="button" style="width:70" value="Buscar"
                                    onClick="buscar_conjunto2();"></td>
                            <td width="144">&nbsp;</td>
                            <td width="171"> <input name="btnimprimir2" type="button" style="width:70" value="Imprimir"
                                    onClick="Imprimir();">
                                <input name="btnsalir2" type="button" style="width:70" value="Salir"
                                    onClick="salir_menu();">
                            </td>
                        </tr>
                    </table>
                    <?php
if($Proceso == 'B')
{
	$dia = date("j");
	$mes = date("n");
	$ano = date("Y");
	
	$fecha = $ano.'-'.$mes.'-'.$dia;
    echo'<table cellpadding="3" cellspacing="0" width="666" border="1" align="center" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla01"> 
      <td height="10%"><div align="center">Nro. Conj</div></td>
      <td width="30%"><div align="center">Nombre Conjunto</div></td>
      <td width="15%"><div align="center">Fecha Creaci&oacute;n</div></td>
      <td width="5%"><div align="center">Est.</div></td>
      <td width="30%"><div align="center">Lugar</div></td>
      <td width="10%"><div align="center">Exist.</div></td>
    </tr>';
 
	                include("../principal/conectar_ram_web.php");
					if ($cmbestado == -1)
					$consulta = "SELECT * FROM conjunto_ram where cod_conjunto = $cmbtipo AND cod_subproducto = $cmbproducto ORDER BY num_conjunto";
					else
					$consulta = "SELECT * FROM conjunto_ram where cod_conjunto = $cmbtipo AND cod_subproducto = $cmbproducto AND estado = '$cmbestado' ORDER BY num_conjunto";

					$rs = mysqli_query($link, $consulta);

					while ($row = mysqli_fetch_array($rs))
					{
						echo '<tr><td width="10%"><div align="center">'.$row["num_conjunto"].'</div></td>';
						echo '<td width="30%"><div align="center">'.$row["descripcion"].'</div></td>';
						echo '<td width="15%"><div align="center">'.$row["fecha_creacion"].'</div></td>';
						echo '<td width="5%"><div align="center">'.$row["estado"].'</div></td>';
					
					    $consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = '".$row["cod_lugar"]."' AND num_lugar = '".$row["num_lugar"]."' ";
					    $rs2 = mysqli_query($link, $consulta);
					   
					    if($row2 = mysqli_fetch_array($rs2))
					    {
							$lugar_origen = $row2["descripcion_lugar"];
	   						echo '<td width="30%"><div align="center">'.$lugar_origen.'</div></td>';
						}
						else
						{
	   						echo '<td width="30%"><div align="center">&nbsp;</div></td>';
						} 
						
						if($row["estado"] != 'f')
						{
							//Existencia Final
							$consulta ="SELECT peso_conjunto FROM ram_web.conjunto_ram WHERE cod_conjunto = $cmbtipo AND num_conjunto = '".$row["num_conjunto"]."'";
							$rs2 = mysqli_query($link, $consulta);

							if($row2 = mysqli_fetch_array($rs2))
							{
									echo '<td width="10%"><div align="center">&nbsp;'.$row2["peso_conjunto"].'</div></td></tr>';
							}
							else
							{
									echo '<td width="10%"><div align="center">0</div></td></tr>';
							}
						}
						else
						{
							echo '<td width="10%"><div align="center">0</div></td></tr>';
						}

					}
		
              echo '</table>';
}



//Por numero de Conjunto
if($Proceso == 'B2')
{
	$dia = date("j");
	$mes = date("n");
	$ano = date("Y");
	
	$fecha = $ano.'-'.$mes.'-'.$dia;
    echo'<table cellpadding="3" cellspacing="0" width="666" border="1" align="center" bordercolor="#b26c4a" class="TablaPrincipal" >
    <tr class="ColorTabla01"> 
      <td height="10%"><div align="center">Nro. Conj</div></td>
      <td width="30%"><div align="center">Nombre Conjunto</div></td>
      <td width="15%"><div align="center">Fecha Creaci&oacute;n</div></td>
      <td width="5%"><div align="center">Est.</div></td>
      <td width="30%"><div align="center">Lugar</div></td>
      <td width="10%"><div align="center">Exist.</div></td>
    </tr>';
	//$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = $cmbtipo AND num_conjunto = $num_conjunto";	
	//echo $consulta;
	//$rs = mysqli_query($link, $consulta);
	if($num_conjunto != '' && is_numeric($num_conjunto))
	//if($num_conjunto != '')
	 {	
	$consulta = "SELECT * FROM ram_web.conjunto_ram WHERE cod_conjunto = $cmbtipo AND num_conjunto = $num_conjunto";	
	//echo $consulta;
	$rs = mysqli_query($link, $consulta); 
		while($row = mysqli_fetch_array($rs))
		{
		    echo'<tr> ';
			  echo '<td>'.$row["cod_conjunto"].' - '.$row["num_conjunto"].'</div></td>';
			  echo '<td>'.$row["descripcion"].'</td>';
			  echo '<td>'.$row["fecha_creacion"].'</td>';
			  echo '<td>'.$row["estado"].'</td>';
			  
			  $consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = '".$row["cod_lugar"]."' AND num_lugar = '".$row["num_lugar"]."' ";
			  $rs2 = mysqli_query($link, $consulta);
			   
			  if($row2 = mysqli_fetch_array($rs2))
			  {
				 $lugar_origen = $row2["descripcion_lugar"];
				 echo '<td>'.$lugar_origen.'</td>';
			  }
			  else
			  {
				 echo '<td>&nbsp;</td>';
			  } 
	
				if($row["estado"] != 'f')
				{
					//Existencia Final
					$consulta ="SELECT peso_conjunto FROM ram_web.conjunto_ram WHERE cod_conjunto = $cmbtipo AND num_conjunto = '".$row["num_conjunto"]."'";
					$rs2 = mysqli_query($link, $consulta);
	
					if($row2 = mysqli_fetch_array($rs2))
					{
							echo '<td width="10%"><div align="center">&nbsp;'.$row2["peso_conjunto"].'</div></td></tr>';
					}
					else
					{
							echo '<td width="10%"><div align="center">0</div></td></tr>';
					}
				}
				else
				{
					echo '<td width="10%"><div align="center">0</div></td></tr>';
				}


		}
	}	
echo'</table>';
} 

?>
                </td>
            </tr>
        </table>
        <?php include("../principal/pie_pagina.php")?>
    </form>
</body>

</html>
<?php include("../principal/cerrar_ram_web.php") ?>