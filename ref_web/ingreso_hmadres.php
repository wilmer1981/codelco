<?php 
  
   include("../principal/conectar_ref_web.php"); 
   $consulta_fecha="select left(SYSDATE(),10) as fecha ";
   $respuesta_fecha =mysqli_query($link, $consulta_fecha);
   $row1=mysqli_fetch_array($respuesta_fecha);
   $fecha=$row1["fecha"];
   $insertar1="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
   $insertar1 = $insertar1."values ('".$fecha."','1','0','0','0','0','0')";
   mysqli_query($link, $insertar1);
   $insertar2="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
   $insertar2 = $insertar2."values ('".$fecha."','2','0','0','0','0','0')";
   mysqli_query($link, $insertar2);
   $insertar3="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
   $insertar3 = $insertar3."values ('".$fecha."','7','0','0','0','0','0')";
   mysqli_query($link, $insertar3);
   $insertar4="insert into ref_web.produccion(fecha,cod_grupo,rechazo_delgadas,rechazo_granuladas,rechazo_gruesas,total_recuperado,observacion)";
   $insertar4 = $insertar4."values ('".$fecha."','8','0','0','0','0','0')";
   mysqli_query($link, $insertar4);
   $insertar5="insert into ref_web.detalle_produccion(fecha,stock,lectura_rectificador)";
   $insertar5 = $insertar5."values ('".$fecha."','0','0')";	
   mysqli_query($link, $insertar5);
?>

<html>
<head>
      <title>Ingreso de Hojas Madres</TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  
<script language="JavaScript">
function Salir()
{
	window.close();
}
/**********/
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	f.action = "ingreso_hmadres.php?recargapag1=S";
	f.submit();
}
/**********/
function Guardar()
{
	/*if(Validaciones())
	{*/
		var f = document.frmPrincipal;
		f.action = "proceso_hmadres.php?proceso=G";
		f.submit();
     //}  
}
/**********/
function Buscar()
{
	var f = document.frmPrincipal;
	f.action = "proceso_hmadres.php?proceso=B";
	f.submit();
}
/**********/
function Modificar(tipoa)
{
	var f = document.frmPrincipal;
	/*f.action = "proceso_hmadres.php?proceso=M";
	alert("Esta seguro que desea guardar los datos");*/
	 switch (tipoa)
	   {
            
             case 'g':  var H = confirm("Desea guardar los datos");
                        if (H == true)
                        {
	                    	f.action = "proceso_hmadres.php?proceso=M";
    	                    f.submit();
                       }
                       break;
            
       }
	f.submit();
}
function Modificar1()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_hmadres.php?mostrar=S&proceso=Mod";
	f.submit();
}
function Limpiar()
{
	document.location = "ingreso_hmadres.php";
}
</script>
</HEAD>
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<FORM name="frmPrincipal" action="" method="post">

  <table width="464" border="0" class="TablaPrincipal">
    <tr> 
      <td width="754"><table width="453" border="0"  cellpadding="0">
          <tr> 
            <td width="88"><font face="Arial, Helvetica, sans-serif"> Fecha </font></td>
            <td width="650" colspan="2"><div align="left"><font face="Arial, Helvetica, sans-serif">
                <select name="dia1" size="1" >
                  <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{
						if (($mostrar == "S") && ($i == $dia1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("j")) and ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
                </select>
                <select name="mes1" size="1" id="select3">
                  <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S" ))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';
					}
				?>
                </select>
                <select name="ano1" size="1" id="select4">
                  <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
                </select>
                <input name="btnbuscar" type="button" value="Buscar" style="width:70" title="Busca datos segun fecha"  onClick="Buscar()">
                </font> </div>
				</td>
          </tr>
        </table>
<br>
	<table width="449" border="0"  cellpadding="3" cellspacing="0" class="TablaInterior" >
          <tr> 
            <td width="63" height="20" rowspan="2" align="center" class="ColorTabla01"><div align="center">Modificar<ur> 
              </div></td>
            <td width="85" rowspan="2" align="center" class="ColorTabla01"><div align="center">Grupos</div></td>
            <td height="13" colspan="4" align="center" class="ColorTabla01"><div align="center">DETALLE 
                RECHAZO LAMINAS HM</div></td>
            <td width="169" rowspan="2" align="center" class="ColorTabla01"><div align="center">Observaciones</div></td>
          </tr>
          <tr> 
            <td width="84" height="15" align="center" class="ColorTabla01"> <div align="center"> Delgadas </div></td>
            <td width="88" align="center" class="ColorTabla01"> Granuladas </td>
            <td width="80" align="center" class="ColorTabla01"><div align="center"> Gruesas</div></td>
            <td width="91" align="center" class="ColorTabla01">Recuperado</td>
          </tr>
          <tr> 
            <td height="20"> <div align="center"> 
			    
                <?php 				  	
				  if ($mostrar == "S" || $proceso == '')
			          echo'<input type="radio" name="txt_checkbox1" value="1" onClick="Modificar1()" >';
				  elseif($proceso == "Mod" && $txt_checkbox1 == 1)
				      echo '<input type="radio" name="txt_checkbox1" value="1" checked >';  
                ?>
              </div></td>
            <td><div align="center"> 
                <?php 
					if ($mostrar == "S" && $txt_checkbox1 == '')
						echo '<input name="txt_grupo1" type="hidden" value="'.$txt_grupo1.'" size="1" readonly >';
				    elseif($txt_checkbox1 == 1 || $mostrar != "S")
						echo '<input name="txt_grupo1" type="hidden" value="1" size="1" readonly>';
				?>
                 1</div></td>
            <td align="center"> 
              <?php 
				if ($mostrar=="S" && $txt_checkbox1 == '')
					echo '<input name="txt_delgadas1" type="text" readonly  value="'.$txt_delgadas1.'" size="5" style="text-align:center;background:grey;">';
				elseif($txt_checkbox1 == 1 || $mostrar != "S")
					echo '<input name="txt_delgadas1" type="text" value="'.$txt_delgadas1.'" size="5">'; 
				
			?>
            </td>
            <td align="center"> 
              <?php 
				if ($mostrar=="S" && $txt_checkbox1 == '')
					echo '<input name="txt_granuladas1" type="text" readonly value="'.$txt_granuladas1.'" size="5" style="text-align:center;background:grey;">';
				elseif($txt_checkbox1 == 1 || $mostrar != "S")
					echo '<input name="txt_granuladas1" type="text" value="'.$txt_granuladas1.'" size="5">'; 
			?>
            </td>
            <td align="center"> 
              <?php 	
				if ($mostrar == "S" && $txt_checkbox1 == '')
					echo '<input name="txt_gruesas1" type="text" readonly  value="'.$txt_gruesas1.'" size="5" style="text-align:center;background:grey;">';
				elseif($txt_checkbox1 == 1 || $mostrar != "S")
					echo '<input name="txt_gruesas1" type="text" value="'.$txt_gruesas1.'" size="5">';
			?>
            </td>
            <td align="center"> <font face="Arial, Helvetica, sans-serif"> 
              <?php 
			    	if ($mostrar == "S" && $txt_checkbox1 == '')
						echo '<input name="txt_total_recuperado1" type="text" readonly   value="'.$txt_total_recuperado1.'" size="5" style="text-align:center;background:grey;">';
   			        elseif($txt_checkbox1 == 1 || $mostrar != "S")
						echo '<input name="txt_total_recuperado1" type="text" value="'.$txt_total_recuperado1.'" size="5">';
				?>
              </font> </td>
            <td width="169" align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php
			  	if ($mostrar == "S" && $txt_checkbox1 == '')	
					echo "<textarea name='txt_observacion1' type='text' id='textarea2' cols='25' value= '$txt_observacion1' readonly >$txt_observacion1</textarea>";
				else
					echo "<textarea name='txt_observacion1' type='text' id='textarea2' cols='25' value= '$txt_observacion1'>$txt_observacion1</textarea>";
			  ?>
              </font></td>
          </tr>
          <tr> 
            <td height="20"><div align="center"> 
                <?php 
				  if ($mostrar == "S" || $proceso == '')
			          echo'<input type="radio" name="txt_checkbox2" value="2" onClick="Modificar1()">';
				  elseif($proceso == "Mod" && $txt_checkbox2 == 2)
				      echo '<input type="radio" name="txt_checkbox2" value="2" checked>';  
                ?>
              </div></td>
            <td height="20"><div align="center"> 
                <?php 
					if ($mostrar == "S" && $txt_checkbox2 == '')
						echo '<input name="txt_grupo2" type="hidden" value="'.$txt_grupo2.'" size="1" readonly>';
				    elseif($txt_checkbox2 == 2 || $mostrar != "S")
						echo '<input name="txt_grupo2" type="hidden" value="2" size="1" readonly>';
				?>
                 2</div></td>
            <td width="84" align="center"> 
              <?php 
				if ($mostrar=="S" && $txt_checkbox2 == '')
					echo '<input name="txt_delgadas2" type="text" readonly value="'.$txt_delgadas2.'" size="5" style="text-align: center;background:grey;">';
				elseif($txt_checkbox2 == 2 || $mostrar != "S")
					echo '<input name="txt_delgadas2" type="text" value="'.$txt_delgadas2.'" size="5">'; 
			?>
            </td>
            <td width="88" align="center"> 
              <?php 
				if ($mostrar=="S" && $txt_checkbox2 == '')
					echo '<input name="txt_granuladas2" type="text"  readonly value="'.$txt_granuladas2.'" size="5" style="text-align: center;background:grey;">';
				elseif($txt_checkbox2 == 2 || $mostrar != "S")
					echo '<input name="txt_granuladas2" type="text" value="'.$txt_granuladas2.'" size="5">'; 
			?>
            </td>
            <td width="80" align="center"> 
              <?php 	
				if ($mostrar == "S" && $txt_checkbox2 == '')
					echo '<input name="txt_gruesas2" type="text" readonly value="'.$txt_gruesas2.'" size="5" style="text-align: center;background:grey;">';
				elseif($txt_checkbox2 == 2 || $mostrar != "S")
					echo '<input name="txt_gruesas2" type="text" value="'.$txt_gruesas2.'" size="5">';
			?>
            </td>
            <td width="91" align="center"> <font face="Arial, Helvetica, sans-serif"> 
              <?php 
			    	if ($mostrar == "S" && $txt_checkbox2 == '')
						echo '<input name="txt_total_recuperado2" type="text" readonly value="'.$txt_total_recuperado2.'" size="5" style="text-align: center;background:grey;">';
   			        elseif($txt_checkbox2 == 2 || $mostrar != "S")
						echo '<input name="txt_total_recuperado2" type="text" value="'.$txt_total_recuperado2.'" size="5">';
				?>
              </font> </td>
            <td align="center"><font face="Arial, Helvetica, sans-serif">
              <?php
			  	if ($mostrar == "S" && $txt_checkbox2 == '')	
					echo "<textarea name='txt_observacion2' type='text' id='textarea2' cols='25' value= '$txt_observacion2' readonly>$txt_observacion2</textarea>";
				else
					echo "<textarea name='txt_observacion2' type='text' id='textarea2' cols='25' value= '$txt_observacion2'>$txt_observacion2</textarea>";
			  ?>
              </font></td>
          </tr>
          <tr> 
            <td height="30"><div align="center"> 
                <?php 
				  if ($mostrar == "S" || $proceso == '')
			          echo'<input type="radio" name="txt_checkbox3" value="3" onClick="Modificar1()">';
				  elseif($proceso == "Mod" && $txt_checkbox3 == 3)
				      echo '<input type="radio" name="txt_checkbox3" value="3" disabled>';
                ?>
              </div></td>
            <td height="30"><div align="center"> 
                <?php 
					if ($mostrar == "S" && $txt_checkbox3 == '')
						echo '<input name="txt_grupo3" type="hidden" value="'.$txt_grupo3.'" size="1" readonly>';
				    elseif($txt_checkbox3 == 3 || $mostrar != "S")
						echo '<input name="txt_grupo3" type="hidden" value="7" size="1" readonly>';
				?>
                 7</div></td>
            <td align="center"> 
              <?php 
				if ($mostrar=="S" && $txt_checkbox3 == '')
					echo '<input name="txt_delgadas3" type="text" readonly value="'.$txt_delgadas3.'" size="5"style="text-align: center;background:grey;">';
				elseif($txt_checkbox3 == 3 || $mostrar != "S")
					echo '<input name="txt_delgadas3" type="text" value="'.$txt_delgadas3.'" size="5">'; 
			?>
            </td>
            <td align="center"> 
              <?php 
				if ($mostrar=="S" && $txt_checkbox3 == '')
					echo '<input name="txt_granuladas3" type="text" readonly value="'.$txt_granuladas3.'" size="5" style="text-align: center;background:grey;">';
				elseif($txt_checkbox3 == 3 || $mostrar != "S")
					echo '<input name="txt_granuladas3" type="text" value="'.$txt_granuladas3.'" size="5">'; 
			?>
            </td>
            <td align="center"> 
              <?php 	
				if ($mostrar == "S" && $txt_checkbox3 == '')
					echo '<input name="txt_gruesas3" type="text" readonly value="'.$txt_gruesas3.'" size="5" style="text-align: center;background:grey;">';
				elseif($txt_checkbox3 == 3 || $mostrar != "S")
					echo '<input name="txt_gruesas3" type="text" value="'.$txt_gruesas3.'" size="5">';
			?>
            </td>
            <td align="center"> <font face="Arial, Helvetica, sans-serif"> 
              <?php 
			    	if ($mostrar == "S" && $txt_checkbox3 == '')
						echo '<input name="txt_total_recuperado3" type="text" readonly value="'.$txt_total_recuperado3.'" size="5" style="text-align: center;background:grey;">';
   			        elseif($txt_checkbox3 == 3 || $mostrar != "S")
						echo '<input name="txt_total_recuperado3" type="text" value="'.$txt_total_recuperado3.'" size="5">';
				?>
              </font> </td>
            <td align="center"><font face="Arial, Helvetica, sans-serif">
              <?php
			  	if ($mostrar == "S" && $txt_checkbox3 == '')	
					echo "<textarea name='txt_observacion3' type='text' id='textarea3' cols='25' value= '$txt_observacion3' readonly>$txt_observacion3</textarea>";
				else
					echo "<textarea name='txt_observacion3' type='text' id='textarea3' cols='25' value= '$txt_observacion3'>$txt_observacion3</textarea>";
			  ?>
              </font></td>
          </tr>
          <tr> 
            <td height="30"><div align="center"> 
                <?php 
				  if ($mostrar == "S" || $proceso == '')
			          echo'<input type="radio" name="txt_checkbox4" value="4" onClick="Modificar1()">';
				  elseif($proceso == "Mod" && $txt_checkbox4 == 4)
				      echo '<input type="radio" name="txt_checkbox4" value="4" checked>';  
                ?>
              </div></td>
            <td width="85" height="30"><div align="center"> 
                <?php 
					if ($mostrar == "S" && $txt_checkbox4 == '')
						echo '<input name="txt_grupo4" type="hidden" value="'.$txt_grupo4 .'" size="1" readonly>';
				    elseif($txt_checkbox4 == 4 || $mostrar != "S")
						echo '<input name="txt_grupo4" type="hidden" value="8" size="1" readonly>';
				?>
                 8</div></td>
            <td align="center"> 
              <?php 
				if ($mostrar=="S" && $txt_checkbox4 == '')
					echo '<input name="txt_delgadas4" type="text" readonly value="'.$txt_delgadas4.'" size="5"  style="text-align: center;background:grey;">';
				elseif($txt_checkbox4 == 4 || $mostrar != "S")
					echo '<input name="txt_delgadas4" type="text" value="'.$txt_delgadas4.'" size="5">'; 
			?>
            </td>
            <td align="center"> 
              <?php 
				if ($mostrar=="S" && $txt_checkbox4 == '')
					echo '<input name="txt_granuladas4" type="text" readonly value="'.$txt_granuladas4.'" size="5"  style="text-align: center;background:grey;">';
				elseif($txt_checkbox4 == 4 || $mostrar != "S")
					echo '<input name="txt_granuladas4" type="text" value="'.$txt_granuladas4.'" size="5">'; 
			?>
            </td>
            <td align="center"> 
              <?php 	
				if ($mostrar == "S" && $txt_checkbox4 == '')
					echo '<input name="txt_gruesas4" type="text" readonly value="'.$txt_gruesas4.'" size="5"  style="text-align: center;background:grey;">';
				elseif($txt_checkbox4 == 4 || $mostrar != "S")
					echo '<input name="txt_gruesas4" type="text" value="'.$txt_gruesas4.'" size="5">';
			?>
            </td>
            <td align="center"> <font face="Arial, Helvetica, sans-serif"> 
              <?php 
			    	if ($mostrar == "S" && $txt_checkbox4 == '')
						echo '<input name="txt_total_recuperado4" type="text" readonly value="'.$txt_total_recuperado4.'" size="5"  style="text-align: center;background:grey;">';
   			        elseif($txt_checkbox4 == 4 || $mostrar != "S")
						echo '<input name="txt_total_recuperado4" type="text" value="'.$txt_total_recuperado4.'" size="5">';
				?>
              </font> </td>
            <td align="center"><font face="Arial, Helvetica, sans-serif">
              <?php
			  	if ($mostrar == "S" && $txt_checkbox4 == '')	
					echo "<textarea name='txt_observacion4' type='text' id='textarea4' cols='25' value= '$txt_observacion4' readonly>$txt_observacion4 </textarea>";
				else
					echo "<textarea name='txt_observacion4' type='text' id='textarea4' cols='25' value= '$txt_observacion4'>$txt_observacion4</textarea>";
			  ?>
              </font></td>
          </tr>
        </table>
<br>
          <table width="457" border="0" cellpadding="3" cellspacing="0">
          <td width="65" height="20" align="center" class="ColorTabla01"><div align="center">Modificar<ur>
              </div></td>
            <td width="380" align="center" class="ColorTabla01"><div align="center"> Detalle
                Stock Produccion Maquinas</div></td>
          </tr>
        </table>
        <table width="457" border="0"  cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td> <div align="center"> 
                <?php 
				  if ($mostrar == "S" || $proceso == '')
			          echo'<input type="radio" name="txt_checkbox5" value="5" onClick="Modificar1()">';
				  elseif($proceso == "Mod" && $txt_checkbox5 == 5)
				      echo '<input type="radio" name="txt_checkbox5" value="5" checked>';  
                ?>
              </div></td>
            <td><div align="center"></div>
              <div align="left"></div>
              <font face="Arial, Helvetica, sans-serif">&nbsp; </font> <div align="left"></div>
              <div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div>
              <font face="Arial, Helvetica, sans-serif"> Stock </font></td>
            <td><font face="Arial, Helvetica, sans-serif"> &nbsp;&nbsp;&nbsp; 
              <?php 
				if ($mostrar=="S" && $txt_checkbox5== '')
					echo '<input name="txt_stock" type="text" readonly value="'.$txt_stock.'" size="9" style="text-align:center;background:grey;">';
				elseif($txt_checkbox5 == 5 || $mostrar != "S")
					echo '<input name="txt_stock" type="text" value="'.$txt_stock.'" size="9">'; 
			?>
              </font></td>
          </tr>
          <tr> 
            <td width="47" height="28"> 
              <div align="center"> 
                <?php 
				  if ($mostrar == "S" || $proceso == '')
			          echo'<input type="radio" name="txt_checkbox6" value="6" onClick="Modificar1()">';
				  elseif($proceso == "Mod" && $txt_checkbox6 == 6)
				      echo '<input type="radio" name="txt_checkbox6" value="6" checked>';  
                ?>
              </div>
              <div align="center"> </div></td>
            <td width="135">Lectura Rectificador 1 5:00 AM</td>
            <td width="254"><font face="Arial, Helvetica, sans-serif"> &nbsp;&nbsp;&nbsp; 
              <?php 
				if ($mostrar=="S" && $txt_checkbox6== '')
					echo '<input name="txt_lectura_rectificador" type="text" readonly value="'.$txt_lectura_rectificador.'" size="9" style="text-align:center;background:grey;">';
				elseif($txt_checkbox6 == 6 || $mostrar != "S")
					echo '<input name="txt_lectura_rectificador" type="text" value="'.$txt_lectura_rectificador.'" size="9">'; 
			?>
              </font><font face="Arial, Helvetica, sans-serif"> &nbsp;&nbsp;&nbsp; 
              </font><font face="Arial, Helvetica, sans-serif">&nbsp;</font><font face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
          </tr>
        </table>
    <tr> 
      <td > <font face="Arial, Helvetica, sans-serif">&nbsp; </font>
        <table width="456" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr> 
            <td width="447" height="26" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif"> 
                </font><font face="Arial, Helvetica, sans-serif"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <?php
				 /*if($mostrar == "S")
				 {*/
					echo'<input name="modificar" type="button"  value="Guardar" onClick=Modificar("g"); style="width:70px">&nbsp;';
				 /*}*/
				/* else
				 {
					echo'<input name="modificar" type="button"  value="Modificar" disabled>&nbsp;';
				 }*/
				?>
                </font> <font face="Arial, Helvetica, sans-serif"> </font> <font face="Arial, Helvetica, sans-serif"> 
                <input name ="btnSalir2" type="button" onClick="JavaScript:Salir();" style="width:70" value="Salir">
                </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif">&nbsp; 
                </font> <font face="Arial, Helvetica, sans-serif"></font><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>
          </tr>
        </table> </td>
    </tr>
  </table>

</FORM>
</BODY>
</HTML>
<?php
	if (isset($Mensaje))
	{
		echo"<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	}
?>
