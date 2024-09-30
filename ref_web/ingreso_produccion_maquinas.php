<?php 
 $CodigoDeSistema = 10;
 $CodigoDePantalla = 11;

 include("../principal/conectar_ref_web.php"); 
$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
$ano1   = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:"";
$mes1   = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:"";
$dia1   = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:"";
$mostrar = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
$txt_checkbox1 = isset($_REQUEST["txt_checkbox1"])?$_REQUEST["txt_checkbox1"]:"";
$txt_checkbox2 = isset($_REQUEST["txt_checkbox2"])?$_REQUEST["txt_checkbox2"]:"";
$txt_checkbox3 = isset($_REQUEST["txt_checkbox3"])?$_REQUEST["txt_checkbox3"]:"";
$txt_checkbox4 = isset($_REQUEST["txt_checkbox4"])?$_REQUEST["txt_checkbox4"]:"";
$txt_turno = isset($_REQUEST["txt_turno"])?$_REQUEST["txt_turno"]:"";
$txt_turno1 = isset($_REQUEST["txt_turno1"])?$_REQUEST["txt_turno1"]:"";
$txt_turno2 = isset($_REQUEST["txt_turno2"])?$_REQUEST["txt_turno2"]:"";
$txt_turno3 = isset($_REQUEST["txt_turno3"])?$_REQUEST["txt_turno3"]:"";
$txt_stock = isset($_REQUEST["txt_stock"])?$_REQUEST["txt_stock"]:"";
$entrar = isset($_REQUEST["entrar"])?$_REQUEST["entrar"]:"";
$Mensaje = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
$txt_mfci = isset($_REQUEST["txt_mfci"])?$_REQUEST["txt_mfci"]:"";
$txt_mfci1 = isset($_REQUEST["txt_mfci1"])?$_REQUEST["txt_mfci1"]:"";
$txt_mfci2 = isset($_REQUEST["txt_mfci2"])?$_REQUEST["txt_mfci2"]:"";
$txt_mfci3 = isset($_REQUEST["txt_mfci3"])?$_REQUEST["txt_mfci3"]:"";
$txt_mdb1 = isset($_REQUEST["txt_mdb1"])?$_REQUEST["txt_mdb1"]:"";
$txt_mdb2 = isset($_REQUEST["txt_mdb2"])?$_REQUEST["txt_mdb2"]:"";
$txt_mdb3 = isset($_REQUEST["txt_mdb3"])?$_REQUEST["txt_mdb3"]:"";
$txt_mco1 = isset($_REQUEST["txt_mco1"])?$_REQUEST["txt_mco1"]:"";
$txt_mco2 = isset($_REQUEST["txt_mco2"])?$_REQUEST["txt_mco2"]:"";
$txt_mco3 = isset($_REQUEST["txt_mco3"])?$_REQUEST["txt_mco3"]:"";

$txt_observacion1 = isset($_REQUEST["txt_observacion1"])?$_REQUEST["txt_observacion1"]:"";
$txt_observacion2 = isset($_REQUEST["txt_observacion2"])?$_REQUEST["txt_observacion2"]:"";
$txt_observacion3 = isset($_REQUEST["txt_observacion3"])?$_REQUEST["txt_observacion3"]:"";

$txt_rechazo_cat_ini = isset($_REQUEST["txt_rechazo_cat_ini"])?$_REQUEST["txt_rechazo_cat_ini"]:"";
$txt_rechazo_cat_ini_a = isset($_REQUEST["txt_rechazo_cat_ini_a"])?$_REQUEST["txt_rechazo_cat_ini_a"]:"";
$txt_rechazo_cat_ini_b = isset($_REQUEST["txt_rechazo_cat_ini_b"])?$_REQUEST["txt_rechazo_cat_ini_b"]:"";
$txt_rechazo_cat_ini_c = isset($_REQUEST["txt_rechazo_cat_ini_c"])?$_REQUEST["txt_rechazo_cat_ini_c"]:"";
$txt_rechazo_lam_ini   = isset($_REQUEST["txt_rechazo_lam_ini"])?$_REQUEST["txt_rechazo_lam_ini"]:"";
$txt_rechazo_lam_ini_a   = isset($_REQUEST["txt_rechazo_lam_ini_a"])?$_REQUEST["txt_rechazo_lam_ini_a"]:"";
$txt_rechazo_lam_ini_b   = isset($_REQUEST["txt_rechazo_lam_ini_b"])?$_REQUEST["txt_rechazo_lam_ini_b"]:"";
$txt_rechazo_lam_ini_c   = isset($_REQUEST["txt_rechazo_lam_ini_c"])?$_REQUEST["txt_rechazo_lam_ini_c"]:"";
$txt_catodos_en_renovacion   = isset($_REQUEST["txt_catodos_en_renovacion"])?$_REQUEST["txt_catodos_en_renovacion"]:"";
$txt_catodos_en_renovacion_a = isset($_REQUEST["txt_catodos_en_renovacion_a"])?$_REQUEST["txt_catodos_en_renovacion_a"]:"";
$txt_catodos_en_renovacion_b = isset($_REQUEST["txt_catodos_en_renovacion_b"])?$_REQUEST["txt_catodos_en_renovacion_b"]:"";
$txt_catodos_en_renovacion_c = isset($_REQUEST["txt_catodos_en_renovacion_c"])?$_REQUEST["txt_catodos_en_renovacion_c"]:"";

  if ($ano1!="" and $dia1!="" and $mes1!="")
	 {
	  $fecha=$ano1.'-'.$mes1.'-'.$dia1;
	 }
  else{
       $ano1=substr($fecha,0,4);
	   $mes1=substr($fecha,5,2);
	   $dia1=substr($fecha,8,2);
      }	 
  
?>
<HTML>
<HEAD>
      <TITLE>Ingreso Produccion Maquinas</TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=11";
}
/**********/
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	f.action = "ingreso_produccion_maquinas.php?recargapag1=S";
	f.submit();
}
/**********/
function Guardar()
{
	/*if(Validaciones())
	{*/
		var f = document.frmPrincipal;
		f.action = "proceso_produccion_maquinas.php?proceso=G";
		f.submit();
     //}  
}

/**********/
function Buscar()
{
	//alert(vez1);
	var f = document.frmPrincipal;
	f.action = "proceso_produccion_maquinas.php?proceso=B";
	f.submit();
	
}
/**********/
function Buscar2( )
{
	//alert(proceso);
	var f = document.frmPrincipal;
	f.action = "proceso_produccion_maquinas.php?proceso=B"+"&entrar=N";
	f.submit();
	
}
/**********/

function Modificar(tipoa,fecha)
{
	var f = document.frmPrincipal;
	
		 switch (tipoa)
	   {
            
             case 'g':  var H = confirm("Desea guardar los datos");
                        if (H == true)
                        {
	                    	f.action = "proceso_produccion_maquinas.php?proceso=M"+"&fecha="+fecha;
    	                    f.submit();
                       }
                       break;
            
       }
	/*f.action = "proceso_produccion_maquinas.php?proceso=M";*/
	/*f.submit();*/
}
function Modificar1()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_produccion_maquinas.php?mostrar=S&proceso=Mod";
	f.submit();
}

function Limpiar()
{
	document.location = "ingreso_produccion_maquinas.php";
}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmPrincipal;
	var teclaCodigo = event.keyCode; 
	if ( (teclaCodigo==188)||(teclaCodigo==190)|| (teclaCodigo==56)||(teclaCodigo==57)||(teclaCodigo==20)||(teclaCodigo==9)||(teclaCodigo==8)||(teclaCodigo==16)
	   || ((teclaCodigo>47)&&(teclaCodigo<58))||((teclaCodigo>36)&&(teclaCodigo<41))||(teclaCodigo==32) 
	   || (((teclaCodigo>64)&&(teclaCodigo<91)) || ((teclaCodigo>96)&&(teclaCodigo<123)))  )
	{
	    
	}
	else {
	      event.keyCode=46;
	      alert('Caracter no Permitido');
	     }
}
function Calcula(linea)
{
	var f=document.frmPrincipal;
	if (linea=='catini')
	  {
	   f.txt_rechazo_cat_ini.value=Number(f.txt_rechazo_cat_ini_a.value.replace(',','.'))+Number(f.txt_rechazo_cat_ini_b.value.replace(',','.'))+Number(f.txt_rechazo_cat_ini_c.value.replace(',','.'));    
	  }
	 if (linea=='lamini')  
	  {
	   f.txt_rechazo_lam_ini.value=Number(f.txt_rechazo_lam_ini_a.value.replace(',','.'))+Number(f.txt_rechazo_lam_ini_b.value.replace(',','.'))+Number(f.txt_rechazo_lam_ini_c.value.replace(',','.'));    
	  }
	if (linea=='catren') 
	  {  
	   f.txt_catodos_en_renovacion.value=Number(f.txt_catodos_en_renovacion_a.value.replace(',','.'))+Number(f.txt_catodos_en_renovacion_b.value.replace(',','.'))+Number(f.txt_catodos_en_renovacion_c.value.replace(',','.'));    
	  } 
return;	
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>
<BODY leftmargin="3" topmargin="2" marginwidth="0" marginheight="0" >
<FORM name="frmPrincipal" action="" method="post">
  <table width="739" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="756" align="center">
	  <table width="724" border="0" cellpadding="3" class="ColorTabla01">
          <tr> 
            <td width="85" align="center"><font face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>		
            <td width="175"><div align="left"> </div></td>
            <td width="438" ><strong>Ingreso Produccion Maquinas del <?php echo $dia1.'-'.$mes1.'-'.$ano1;?><font face="Arial, Helvetica, sans-serif"> 
              <input name="dia1" type="hidden" value=<?php echo $dia1;?> size="2" style="text-align: center;background:ColorTabla01;color:white;" readonly >
              <input name="mes1" type="hidden" value=<?php echo $mes1;?> size="2" style="text-align: center;background:ColorTabla01;color:white;" readonly>
              <input name="ano1" type="hidden" value=<?php echo $ano1;?> size="4" style="text-align: center;background:ColorTabla01;color:white;" readonly>
              </font></strong></td>
          </tr>
        </table>
        <br> 
        <table width="731" border="0" cellspacing="0" cellpadding="3" class="ColorTabla01">
          <tr> 
            <td width="79" height="20" rowspan="2" align="center"><div align="center"><ur> 
              </div>
              <div align="center">&nbsp;Turnos</div></td>
            <td height="13" colspan="3" align="center"><div align="center">P &nbsp;R&nbsp;O 
                &nbsp;D&nbsp;&nbsp;U&nbsp;C&nbsp;C&nbsp;I&nbsp;O&nbsp;N&nbsp;E&nbsp;S&nbsp;</div></td>
            <td width="336" rowspan="2" align="center"><div align="center">&nbsp;Observaciones</div></td>
          </tr>
          <tr> 
            <td width="90" height="15" align="center"> <div align="center">MFCI</div>
              <div align="left"></div></td>
            <td width="95" align="center">MCB</td>
            <td width="101" align="center"><div align="center">MCO</div></td>
          </tr>
        </table>
        <table width="733" border="0" align="center" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="79" height="20"> <div align="center">
                <?php
			$fecha=$ano1."-".$mes1."-".$dia1;
			//echo "fecha :" .$fecha."-".$txt_turno."-Hola";
   			 if ($mostrar == "S")
			{



      $consulta="select turno,circuito_h2so4,volumen_h2so4 from ref_web.electrolito where fecha='".$fecha."' and turno='".$txt_turno."'";
			$rs = mysqli_query($link, $consulta);

			while ($row = mysqli_fetch_array($rs))
			{
				/*echo '<tr>';
				echo '<td width="63" height="25">';
				echo '<input type="checkbox" name="checkbox" value="'.$row[turno].'/'.$row[produccion_mfci].'/'.$row[produccion_mcb].'/'.$row[produccion_mco].'"></td>';
				echo '<td width="54" align="center">'.$row[turno].'</td>';
				echo '<td width="112" align="center">'.$row[produccion_mfci].'</td>';
				echo '<td width="110" align="center">'.$row[produccion_mcb].'</td>';
				echo '<td width="110" align="center">'.$row[produccion_mco].'</td>';
				echo '<td width="95" align="center">&nbsp</td>';
				echo '<td width="95" align="center">&nbsp</td>';
       			echo '<td width="95" align="center">&nbsp</td>';
            	echo '<td width="95" align="center">&nbsp</td>';
				echo '<td width="95" align="center">&nbsp</td>';
				echo '</tr>';*/
		}
		 //header("Location:ingreso_cir_ele.php?m");
	}
			?>
              </div>
              <div align="center">&nbsp;&nbsp; 
                <?php
					if ($mostrar == "S" && $txt_checkbox1 == '')
						echo '<input name="txt_turno1" type="hidden" value="'.$txt_turno1 .'" size="1" readonly>';
				    elseif($txt_checkbox1 == 1 || $mostrar != "S")
						echo '<input name="txt_turno1" type="hidden" value="A" size="1" readonly>';
				?>
                A</div></td>
            <td align="center"> 
              <?php
				echo '<input name="txt_mfci1" type="text" value="'.$txt_mfci1.'" size="5">';

			?>
            </td>
            <td align="center"> 
              <?php
				echo '<input name="txt_mdb1" type="text" value="'.$txt_mdb1.'" size="5">';

			?>
            </td>
            <td width="103" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif">&nbsp; 
                &nbsp; 
                <?php
				 echo '<input name="txt_mco1" type="text" value="'.$txt_mco1.'" size="5">';
			?>
                &nbsp; </font> <font face="Arial, Helvetica, sans-serif">&nbsp; 
                </font> </div></td>
            <td width="334" align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php
					echo "<textarea name='txt_observacion1' type='text' id='textarea1' onKeyDown='TeclaPulsada()' cols='40' value= '$txt_observacion1'>$txt_observacion1</textarea>";
			  ?>
              </font></td>
          </tr>
          <tr> 
            <td height="20"><div align="center"> </div>
              <div align="center"> &nbsp;&nbsp; 
                <?php
					if ($mostrar == "S" && $txt_checkbox2 == '')
						echo '<input name="txt_turno2" type="hidden" value="'.$txt_turno2.'" size="1" readonly>';
				    elseif($txt_checkbox2 == 2 || $mostrar != "S")
						echo '<input name="txt_turno2" type="hidden" value="B" size="1" readonly>';
				?>
                B</div></td>
            <td width="90" align="center"> 
              <?php
					echo '<input name="txt_mfci2" type="text" value="'.$txt_mfci2.'" size="5">';

			?>
            </td>
            <td width="94" align="center"> 
              <?php
					echo '<input name="txt_mdb2" type="text" value="'.$txt_mdb2.'" size="5">';

			?>
            </td>
            <td align="center"> 
              <?php
				echo '<input name="txt_mco2" type="text" value="'.$txt_mco2.'" size="5">';

			?>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"></div></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php
					echo "<textarea name='txt_observacion2' type='text' id='textarea2' onKeyDown='TeclaPulsada()' cols='40' value= '$txt_observacion2'>$txt_observacion2</textarea>";
			  ?>
              </font></td>
          </tr>
          <tr> 
            <td> <div align="center"> </div>
              <div align="center"> </div>
              <div align="center"></div>
              <div align="center"> </div>
              <div align="center"> 
                <div align="center">&nbsp;&nbsp; 
                  <?php
					if ($mostrar == "S" && $txt_checkbox3 == '')
						echo '<input name="txt_turno3" type="hidden" value="'.$txt_turno3.'" size="1" readonly>';
				    elseif($txt_checkbox3 == 3 || $mostrar != "S")
						echo '<input name="txt_turno3" type="hidden" value="C" size="1" readonly>';
				?>
                  C </div>
              </div></td>
            <td> <div align="center"> 
                <?php
					echo '<input name="txt_mfci3" type="text" value="'.$txt_mfci3.'" size="5">';

			?>
              </div></td>
            <td> <div align="center"> 
                <?php
					echo '<input name="txt_mdb3" type="text" value="'.$txt_mdb3.'" size="5">';

			?>
              </div></td>
            <td> <div align="center"> 
                <?php
					echo '<input name="txt_mco3" type="text" value="'.$txt_mco3.'" size="5">';

			?>
              </div></td>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif"> 
                <?php
					echo "<textarea name='txt_observacion3' type='text' id='textarea3' onKeyDown='TeclaPulsada()' cols='40' value= '$txt_observacion3'>$txt_observacion3</textarea>";
			  ?>
                </font></div></td>
          </tr>
        </table>
        <br>
        <table width="739" height="110" border="1" cellpadding="0" cellspacing="0" class="TablaInterior">
          <tr> 
            <td height="20" colspan="5" align="center" class="ColorTabla01"><div align="center"></div>
              <div align="center"> Detalle Stock Produccion Maquinas</div></td>
          </tr>
          <tr class="ColorTabla01"> 
            <td width="274"> <div align="center"></div>
              <div align="left"></div>
              <div align="left"><font face="Arial, Helvetica, sans-serif"> </font></div></td>
            <td width="118" align="center"><font face="Arial, Helvetica, sans-serif"><strong>A</strong></font></td>
            <td width="113" align="center"><strong>B</strong></td>
            <td width="110" align="center"><strong>C</strong></td>
            <td width="111" align="center"><strong>Total</strong></td>
          </tr>
          <tr> 
            <td>
                <div align="center"><font face="Arial, Helvetica, sans-serif"> 
                  </font></div>
                Rechazo Catodos Iniciales en MFCI</td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_rechazo_cat_ini_a' type='text' onBlur=\"Calcula('catini');\" value='$txt_rechazo_cat_ini_a' size='5'>"; 
			  ?>
              </font></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_rechazo_cat_ini_b' type='text' onBlur=\"Calcula('catini');\" value='$txt_rechazo_cat_ini_b' size='5'>"; 
			  ?>
              </font></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_rechazo_cat_ini_c' type='text' onBlur=\"Calcula('catini');\" value='$txt_rechazo_cat_ini_c' size='5'>"; 
			  ?>
              </font></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_rechazo_cat_ini' type='text' value='$txt_rechazo_cat_ini' size='5' readonly>"; 
			  ?>
              </font></td>
          </tr>
          <tr> 
            <td><div align="left">Rechazo Diario Laminas Iniciales en MFCI</div></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_rechazo_lam_ini_a' type='text' onBlur=\"Calcula('lamini');\" value='$txt_rechazo_lam_ini_a' size='5'>"; 
			  ?>
              </font></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_rechazo_lam_ini_b' type='text' onBlur=\"Calcula('lamini');\" value='$txt_rechazo_lam_ini_b' size='5'>"; 
			  ?>
              </font></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_rechazo_lam_ini_c' type='text' onBlur=\"Calcula('lamini');\" value='$txt_rechazo_lam_ini_c' size='5'>"; 
			  ?>
              </font></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo '<input name="txt_rechazo_lam_ini" type="text" value="'.$txt_rechazo_lam_ini.'" size="5" readonly>'; 
			  ?>
              </font></td>
          </tr>
          <tr> 
            <td height="21"> <div align="center"> 
                <div align="left">Rechazo Catodos Iniciales en Renovacion</div>
              </div></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_catodos_en_renovacion_a' type='text' onBlur=\"Calcula('catren');\" value='$txt_catodos_en_renovacion_a' size='5'>"; 
			  ?>
              </font></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_catodos_en_renovacion_b' type='text' onBlur=\"Calcula('catren');\" value='$txt_catodos_en_renovacion_b' size='5'>"; 
			  ?>
              </font></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo "<input name='txt_catodos_en_renovacion_c' type='text' value='$txt_catodos_en_renovacion_c' onBlur=\"Calcula('catren');\"  size='5'>"; 
			  ?>
              </font></td>
            <td align="center"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				echo '<input name="txt_catodos_en_renovacion" type="text" value="'.$txt_catodos_en_renovacion.'" size="5" readonly>'; 
			  ?>
              </font></td>
          </tr>
          <tr> 
            <td height="21"> <div align="left"> 
                <div align="center"> </div>
                <div align="center"></div>
                <div align="left"></div>
                <font face="Arial, Helvetica, sans-serif"> Stock Inicio Dia (8 
                AM)</font></div></td>
            <td colspan="4"><font face="Arial, Helvetica, sans-serif"> 
              <?php 
				if ($mostrar=="S" && $txt_checkbox4== '')
					echo '<input name="txt_stock" type="text" value="'.$txt_stock.'" size="5" >';
				elseif($txt_checkbox4 == 4 || $mostrar != "S")
					echo '<input name="txt_stock" type="text" value="'.$txt_stock.'" size="5">'; 
			?>
              </font></td>
          </tr>
        </table>
        
      </td>
    </tr>
    <tr> 
      <td height="42" align="center"> <table width="520" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr> 
            <td width="511" height="29" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif"> 
                </font><font face="Arial, Helvetica, sans-serif">
              
                <?php
				  echo'<input name="modificar" type="button"  value="Guardar" onClick=Modificar("g","'.$fecha.'"); style="width:70px">&nbsp;';
				?>
                </font> <font face="Arial, Helvetica, sans-serif"> </font> <font face="Arial, Helvetica, sans-serif">&nbsp; 
                </font> &nbsp; &nbsp;</div></td>
          </tr>
        </table>
        
      </td>
    </tr>
  </table>
</FORM>
</BODY>
</HTML>
<?php
	if ($Mensaje!="")
	{
		echo"<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	}
	
	if ($entrar=='S')
	    {
			echo"<script languaje='javascript'>";
			echo "Buscar2()";
			echo "</script>";
		}	
		
?>
