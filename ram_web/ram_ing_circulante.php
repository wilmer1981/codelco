<?php
$Aut  = isset($_REQUEST["Aut"])?$_REQUEST["Aut"]:"";
$radio  = isset($_REQUEST["radio"])?$_REQUEST["radio"]:"";
$recargapag = isset($_REQUEST["recargapag"])?$_REQUEST["recargapag"]:"";

$n_conjunto  = isset($_REQUEST["n_conjunto"])?$_REQUEST["n_conjunto"]:"";
$descripcion  = isset($_REQUEST["descripcion"])?$_REQUEST["descripcion"]:"";
$cod_lugar  = isset($_REQUEST["cod_lugar"])?$_REQUEST["cod_lugar"]:"";
$num_lugar  = isset($_REQUEST["num_lugar"])?$_REQUEST["num_lugar"]:"";

if(isset($_REQUEST["fecha_c"])){
	$fecha_c = $_REQUEST["fecha_c"];
}else{
	$fecha_c = "";
}

if(isset($_REQUEST["buscar"])){
	$buscar = $_REQUEST["buscar"];
}else{
	$buscar = "";
}

if(isset($_REQUEST["Proceso"])){
	$Proceso = $_REQUEST["Proceso"];
}else{
	$Proceso= "";
}

if(isset($_REQUEST["num_conjunto"])){
	$num_conjunto = $_REQUEST["num_conjunto"];
}else{
	$num_conjunto= "";
}

if(isset($_REQUEST["ano"])){
	$ano = $_REQUEST["ano"];
}else{
	$ano = date("Y");
}
if(isset($_REQUEST["dia"])){
	$dia = $_REQUEST["dia"];
}else{
	$dia = date("d");
}
if(isset($_REQUEST["mes"])){
	$mes = $_REQUEST["mes"];
}else{
	$mes = date("m");
}

$hr1 = isset($_REQUEST["hr1"])?$_REQUEST["hr1"]:"";
$mm1 = isset($_REQUEST["mm1"])?$_REQUEST["mm1"]:"";

$CodigoDeSistema = 7;
$CodigoDePantalla = 5;

 if($buscar == "S")
 {
	$consulta = "SELECT NUM_CONJUNTO,PESO_HUMEDO_MOVIDO FROM movimiento_conjunto WHERE FECHA_MOVIMIENTO = '$fecha_c' AND COD_EXISTENCIA = 02 AND COD_CONJUNTO = 03  AND NUM_CONJUNTO = '$n_conjunto'";

//	echo $consulta;
	include("../principal/conectar_ram_web.php");
	$rs = mysqli_query($link, $consulta);
	
	if($row = mysqli_fetch_array($rs))
	{	
	   $num_conjunto = $row["NUM_CONJUNTO"];
	   $peso_humedo = number_format(($row["PESO_HUMEDO_MOVIDO"]/1000),3,",","");
	            
		$consulta = "SELECT * FROM conjunto_ram WHERE cod_conjunto = 03 AND num_conjunto = $num_conjunto AND estado != 'f'";
		$rs1 = mysqli_query($link, $consulta);
	
		if($row1 = mysqli_fetch_array($rs1))
		{	
	   		$descripcion = $row1["descripcion"];
	  		$cod_lugar = $row1["cod_lugar"];
	   		$num_lugar = $row1["num_lugar"];
		}

	}
 
 }

 if($Proceso == "B")
 {
    if($num_conjunto != '')
	{
		$consulta = "SELECT * FROM conjunto_ram WHERE cod_conjunto = 03 AND num_conjunto = $num_conjunto AND estado != 'f'";
		include("../principal/conectar_ram_web.php");
		$rs = mysqli_query($link, $consulta);
		
		if($row = mysqli_fetch_array($rs))
		{	
		   $num_conjunto = $row["num_conjunto"];
		   $descripcion = $row["descripcion"];
		   $cod_lugar = $row["cod_lugar"];
		   $num_lugar = $row["num_lugar"];
		}
		else 
		{
			$Proceso = "N";	
		}
	}
	else 
	{
		$Proceso = "N";
	}
 }


?>
<html>

<head>
    <title>Ingreso De Circulante</title>
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


    function Buscar_Movimientos() {
        var f = formulario;
        f.action = "ram_ing_circulante.php?Proceso=V";
        f.submit();

    }

    function Nuevo_Dato() {
        var f = formulario;
        // f.action ="ram_ing_circulante.php";
        window.location = "ram_ing_circulante.php";
    }

    function Buscar_Conjunto() {
        var f = formulario;
        f.action = "ram_ing_circulante.php?Proceso=B";
        f.submit();

    }

    function Guardar_Datos() {
        var f = formulario;
        f.action = "ram_ing_circulante01.php?Proceso=G";
        f.submit();

    }

    function Modificar_Datos() {
        var f = formulario;
       // alert("Modificar_Datos33" + ValidaSeleccion(f, 'radio'));
        var Valores = ValidaSeleccion(f, 'radio');
       // alert("Modificar_Datos" + Valores);
        f.action = "ram_ing_circulante01.php?Proceso=M" + Valores;

        //f.action = "ram_ing_circulante01.php?Proceso=M&Valores=" + valores;
        f.submit();

    }

    function Eliminar_Datos() {
        var f = formulario;
        var valores = ValidaSeleccion(f, 'radio');

        f.action = "ram_ing_circulante01.php?Proceso=E" + valores;
        f.submit();

    }

    function salir_menu() {
        var f = formulario;
        f.action = "../principal/sistemas_usuario.php?CodSistema=7";
        f.submit();
    }

    function ValidaSeleccion(f, Nombre) {
        var LargoForm = f.elements.length;
        var Valores = "";
       // alert("NOMBRREE" + Nombre);
        for (i = 0; i < LargoForm; i++) {
            //alert(f.elements[i].name);
            if ((f.elements[i].name == Nombre) && (f.elements[i].checked == true)) {
               // alert("ENTRO" + f.elements[i + 1].value + " " + f.elements[i + 2].value);
                Valores = "&n_conjunto=" + f.elements[i + 1].value + "&fecha_c=" + f.elements[i + 2].value;

            }
        }
        //asegurarse que retornen todos los valores que se necesitan
//        alert(Valores);
        return Valores;
    }

    function Buscar() {
        var f = formulario;
        var valores = ValidaSeleccion(f, 'radio');

        f.action = "ram_ing_circulante.php?buscar=S&Proceso=V" + valores;
        f.submit();
    }
    </script>
    <link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">
    <style type="text/css">
    body {
        margin-left: 3px;
        margin-top: 3px;
        margin-right: 0px;
        margin-bottom: 0px;
    }
    </style>
</head>

<body>
    <form name="formulario" method="post">
        <?php include("../principal/encabezado.php")?>
        <?php include("../principal/conectar_principal.php") ?>

        <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
            <tr>
                <td align="center" valign="top">
                    <table width="700" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
                        <tr>
                            <td width="49"><img src="../principal/imagenes/left-flecha.gif" width="11"
                                    height="11">&nbsp;Fecha
                            </td>
                            <td width="205">
                                <font color="#000000" size="2">
                                    <select name="dia" size="1" style="font-face:verdana;font-size:10">
                                        <?php
			if($Proceso=='V' || $Proceso=='B')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia)
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				   if ($i==date("j"))
						{
						echo "<option selected value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }			
	?>
                                    </select>
                                </font>
                                <font color="#000000" size="2">
                                    <select name="mes" size="1" id="select" style="FONT-FACE:verdana;FONT-SIZE:10">
                                        <?php
											$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
											if($Proceso=='V' || $Proceso=='B')
											{
												for($i=1;$i<13;$i++)
												{
													if ($i==$mes)
													{				
													echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
													}			
													else
													{
													echo "<option value='$i'>".$meses[$i-1]."</option>\n";
													}
												}		
											}
											else
											{
												for($i=1;$i<13;$i++)
												{
													if ($i==date("n"))
													{				
													echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
													}			
													else
													{
													echo "<option value='$i'>".$meses[$i-1]."</option>\n";
													}
												}  			 
											} 	  
											  
										 ?>
                                    </select>
                                    <select name="ano" size="1" style="FONT-FACE:verdana;FONT-SIZE:10">
                                        <?php
										if($Proceso=='V' || $Proceso=='B')
										{
											for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
											{
												//if ($i==date("Y"))
												if ($i==$ano)
												{
												echo "<option selected value ='$i'>$i</option>";
												}
												else	
												{
												echo "<option value='".$i."'>".$i."</option>";
												}
											}
										}
										else
										{
											for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
											{
												if ($i==date("Y"))
												{
												echo "<option selected value ='$i'>$i</option>";
												}
												else	
												{
												echo "<option value='".$i."'>".$i."</option>";
												}
											 }   
										}	
									?>
                                    </select>
                                </font>
                            </td>
                            <td width="144"><input name="buscar_mov" type="button" id="buscar_mov" style="width:130"
                                    onClick="Buscar_Movimientos();" value="Buscar Movimientos"></td>
                            <td width="48"><img src="../principal/imagenes/left-flecha.gif" width="11"
                                    height="11">&nbsp;Hora</td>
                            <td width="221"><select name="hh">
                                    <?php
										for($i=0; $i<=23; $i++)
										{
											if (($recargapag == "S") && ($i == $hr1))
												echo '<option selected value ="'.$i.'">'.$i.'</option>';
											else if (($i == date("H")) && ($recargapag != "S"))
												echo '<option selected value="'.$i.'">'.$i.'</option>';
											else	
												echo '<option value="'.$i.'">'.$i.'</option>';
										}
									?>
                                </select>
                                :
                                <select name="mm">
                                    <?php
										for($i=0; $i<=59; $i++)
										{
											if (($recargapag == "S") && ($i == $mm1))
												echo '<option selected value ="'.$i.'">'.$i.'</option>';
											else if (($i == date("i")) && ($recargapag != "S"))
												echo '<option selected value ="'.$i.'">'.$i.'</option>';
											else	
												echo '<option value="'.$i.'">'.$i.'</option>';
										}
									?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table width="700" border="0" cellpadding="5" cellspacing="0" class="TablaDetalle">
                        <tr>
                            <td width="149"><img src="../principal/imagenes/left-flecha.gif" width="11"
                                    height="11">&nbsp;N&uacute;mero
                                Conjunto </td>
                            <td width="60">
                                <?php
								if($Proceso == "B" || $buscar == "S")
								{
									echo'<input name="num_conjunto" type="text" size="10" value="'.$num_conjunto.'" onKeyDown="TeclaPulsada()">';
								}			
								else
								{
									echo'<input name="num_conjunto" type="text" size="10" onKeyDown="TeclaPulsada()">';
								}
									
								?>
                            </td>
                            <td width="458"><input name="buscar" type="button" style="width:70" value="Buscar"
                                    onClick="Buscar_Conjunto();"></td>
                        </tr>
                        <tr>
                            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Nombre
                                Conjunto</td>
                            <td colspan="2">
                                <?php
								if($Proceso == "B" || $buscar == "S")
								{
									echo'<input name="descripcion" type="text" size="50" value="'.$descripcion.'" disabled>';
								}			
								else
								{
									echo'<input name="descripcion" type="text" size="50" disabled>';
								}
									
								?>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Lugar
                                Origen </td>
                            <td colspan="2">
                                <?php			   	          
								  include("../principal/conectar_ram_web.php");			   
								  if($Proceso == "B" || $buscar == "S")
								  { 
									  $consulta = "SELECT * FROM lugar_conjunto WHERE cod_tipo_lugar = $cod_lugar AND num_lugar = $num_lugar AND cod_estado != 'f'";
									  $rs = mysqli_query($link, $consulta);
									  
									  if($row = mysqli_fetch_array($rs))
									  {
											echo '<input type="text" name="lugar" value="'.$row["descripcion_lugar"].'" size="50" disabled>';
									  }
									  else
									  {	
											echo '<input type="text" name="lugar" size="50" disabled>';
									  }
								 }
								 else	
								 {	
									echo '<input type="text" name="lugar" size="50" disabled>';
								 }
								 ?>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Peso
                                Humedo a Mover</td>
                            <td colspan="2">
                                <?php
			if($buscar == "S")
			{
				echo'<input name="peso_humedo" type="text" size="10" value="'.$peso_humedo.'">';
			}			
			else
			{
				echo'<input name="peso_humedo" type="text" size="10">';
			}
				
   			?>
                                Tons. </td>
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
					echo'<input name="eliminar" type="button"  value="Eliminar" onClick="Eliminar_Datos();" style="width:70px">';				
				 }
				 else
				 {
				 	echo'<input name="modificar" type="button"  value="Modificar" style="width:70px" disabled>&nbsp;';
					echo'<input name="eliminar" type="button"  value="Eliminar" style="width:70px" disabled>';
				 }
				?>
                                    <input name="salir" type="button" style="width:70" onClick="salir_menu();"
                                        value="Salir">
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <table width="700" border="1" cellpadding="5" cellspacing="0" class="TablaDetalle">
                        <tr class="ColorTabla02">
                            <td colspan="6">
                                <div align="center"><strong>Datos Ingresados</strong></div>
                            </td>
                        </tr>
                        <tr class="ColorTabla01">
                            <td width="22">&nbsp;</td>
                            <td width="76">
                                <div align="center">Nro. Conj.</div>
                            </td>
                            <td width="217">
                                <div align="center">Descripci&oacute;n Conjunto</div>
                            </td>
                            <td width="93">
                                <div align="center">Peso Humedo</div>
                            </td>
                            <td width="229">
                                <div align="center">Lugar Destino</div>
                            </td>
                            <td width="80">
                                <div align="center">Tipo Ingreso</div>
                            </td>
                        </tr>

                        <?php
		if($Proceso == "V")
		{   
			if (strlen($mes) < 2)
			   $mes = '0'.$mes; 

			if (strlen($dia) < 2)
			   $dia = '0'.$dia; 

		    $fecha = $ano.'-'.$mes.'-'.$dia;
			$consulta = "SELECT NUM_CONJUNTO,FECHA_MOVIMIENTO,PESO_HUMEDO_MOVIDO,COD_LUGAR_DESTINO,LUGAR_DESTINO,ORIGEN FROM movimiento_conjunto WHERE left(FECHA_MOVIMIENTO,10) = '$fecha' AND COD_EXISTENCIA = 02 AND COD_CONJUNTO = 03";
			include("../principal/conectar_ram_web.php");						
			$rs = mysqli_query($link, $consulta);
		
			while($row = mysqli_fetch_array($rs))
			{
			  echo'<tr><td><center>';

  			  $valor = $row["NUM_CONJUNTO"].$row["FECHA_MOVIMIENTO"];	
			  
			  if($valor == $radio)
			  echo'<input type="radio" name="radio" value="'.$valor.'" onClick="Buscar();" checked>';
			  else
			  echo'<input type="radio" name="radio" value="'.$valor.'" onClick="Buscar();">';
			  echo'</center></td>';
			  
			  echo'<input type="hidden" name="conjunto" value="'.$row["NUM_CONJUNTO"].'">';
			  echo'<input type="hidden" name="fecha" value="'.$row["FECHA_MOVIMIENTO"].'">';	
			  
			  echo'<td><center>'.$row["NUM_CONJUNTO"].'</center></td>';

			  //consulto descripcion conjunto
			  $consulta = "SELECT descripcion FROM ram_web.conjunto_ram WHERE cod_conjunto = 03 AND num_conjunto = '".$row["NUM_CONJUNTO"]."' AND estado != 'f'";
			  $rs1 = mysqli_query($link, $consulta);

			  if($row1 = mysqli_fetch_array($rs1))
			  {
				  echo'<td><center>'.$row1["descripcion"].'</center></td>';
              }
			   
			  echo'<td><center>'.number_format(($row["PESO_HUMEDO_MOVIDO"]/1000),3,",","").'</center></td>';
			  $consulta = "SELECT descripcion_lugar FROM ram_web.lugar_conjunto WHERE cod_tipo_lugar = '".$row["COD_LUGAR_DESTINO"]."' AND num_lugar = '".$row["LUGAR_DESTINO"]."' AND cod_estado != 'f'";
			  $rs2 = mysqli_query($link, $consulta);
			  $descripcion_lugar ="";
			  if($row2 = mysqli_fetch_array($rs2))
			  { $descripcion_lugar =$row2["descripcion_lugar"];
			     echo'<td><center>&nbsp;'.$Aut." ".$descripcion_lugar.'</center></td>';
			  }
			  else 
			  {
			     echo'<td><center>&nbsp;'.$Aut." ".$descripcion_lugar.'</center></td>';
			  }
			  if($row["ORIGEN"]=='A')//INGRESADO POR SIPA PESAJE CIRCULANTES
			  		echo'<td><center>SIPA</center></td>';
				else
					echo'<td><center>MANUAL</center></td>';
			  echo "</tr>";		
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