<?php
  $CodigoDeSistema = 10;
	$CodigoDePantalla = 15;
   include("../principal/conectar_ref_web.php");

  $dia1      = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
  $mes1      = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
  $ano1      = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");

  $fecha       = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
  $recargapag1       = isset($_REQUEST["recargapag1"])?$_REQUEST["recargapag1"]:"";
  $mostrar       = isset($_REQUEST["mostrar"])?$_REQUEST["mostrar"]:"";
  $entarar       = isset($_REQUEST["entarar"])?$_REQUEST["entarar"]:"";
  $proceso       = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";

  if ((isset($ano1)) and (isset($dia1)) and (isset($mes1)))
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
      <TITLE>Ingreso a Pte</TITLE>
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
	f.action = "ingreso_pte.php?recargapag1=S";
	f.submit();
}
/**********/
function Guardar()
{
	/*if(Validaciones())
	{*/
		var f = document.frmPrincipal;
		f.action = "proceso_pte.php?proceso=G";
		f.submit();
     //}
}

/**********/
function Buscar()
{
	var f = document.frmPrincipal;
	f.action = "proceso_pte.php?proceso=B";
	f.submit();
}
/**********/
function Buscar2()
{
	var f = document.frmPrincipal;
	f.action = "proceso_pte.php?proceso=B"+"&entrar=N";
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
	                    	f.action = "proceso_pte.php?proceso=M";
    	                    f.submit();
                       }
                       break;
            
       }
	/*f.submit();*/
}
function Modificar1()
{
	var f = document.frmPrincipal;
	f.action = "ingreso_pte.php?mostrar=S&proceso=Mod";
	f.submit();
}



function Limpiar()
{
	document.location = "ingreso_pte.php";
}
</script>
</HEAD>
<BODY >
<FORM name="frmPrincipal" action="" method="post">
 <table width="740" border="0"  align="center"class="TablaPrincipal">
    <tr>
      <td width="6648"><br>
        <table width="644" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaInterior" >
          <tr> 
            <td width="47" align="center" class="ColorTabla01"><div align="center"></div></td>
            <td height="20" colspan="4" align="center" class="ColorTabla01"><div align="center"><strong>PRDUCCIONES 
                DEL <?php echo $dia1.'/'.$mes1.'/',$ano1?></strong><font face="Arial, Helvetica, sans-serif"> 
                <input name="dia1" type="hidden" value=<?php echo $dia1;?> size="2" style="text-align: center;background:ColorTabla01;color:white;" readonly >
                <input name="mes1" type="hidden" value=<?php echo $mes1;?> size="2" style="text-align: center;background:ColorTabla01;color:white;" readonly>
                <input name="ano1" type="hidden" value=<?php echo $ano1;?> size="4" style="text-align: center;background:ColorTabla01;color:white;" readonly>
                </font></div></td>
          </tr>
          <tr> 
            <td width="47" align="center" class="ColorTabla01">Turnos</td>
            <td width="106" height="15" align="center" class="ColorTabla01"> <div align="center"> 
                Reactores </div></td>
            <td width="82" align="center" class="ColorTabla01"> Sulfato de Cobre 
            </td>
            <td width="80" align="center" class="ColorTabla01"><div align="center">Arseniato 
                Ferico</div></td>
            <td width="97" align="center" class="ColorTabla01">Sales de Niquel</td>
          </tr>
          <tr> 
            <td height="20"><div align="center"> 
                <?php
					if ($mostrar == "S" && $txt_checkbox1 == '')
						echo '<input name="txt_turno1" type="hidden" value="'.$txt_turno1 .'" size="1" readonly>';
				    elseif($txt_checkbox1 == 1 || $mostrar != "S")
						echo '<input name="txt_turno1" type="hidden"" value="A" size="1" readonly>';
				?>
                A</div></td>
            <td align="center"> 
              <?php
				echo '<input name="txt_reactores1" type="text" value="'.$txt_reactores1.'" size="5">';
			?>
            </td>
            <td align="center"> 
              <?php
					echo '<input name="txt_sulfato_cobre1" type="text" value="'.$txt_sulfato_cobre1.'" size="5">';
			?>
            </td>
            <td align="center"> 
              <?php
					echo '<input name="txt_arseniato_ferico1" type="text" value="'.$txt_arseniato_ferico1.'" size="5">';
			?>
            </td>
            <td align="center"> <font face="Arial, Helvetica, sans-serif"> 
              <?php
						echo '<input name="txt_sales_niquel1" type="text" value="'.$txt_sales_niquel1.'" size="5">';
				?>
              </font> </td>
            <?php
					echo "<input name='txt_observacion1' type='hidden' id='textarea1' cols='25' value= '$txt_observacion1'>";
			  ?>
          </tr>
          <tr> 
            <td height="20"><div align="center"> 
                <?php
					if ($mostrar == "S" && $txt_checkbox2 == '')
						echo '<input name="txt_turno2" type="hidden" value="'.$txt_turno2.'" size="1" readonly>';
				    elseif($txt_checkbox2 == 2 || $mostrar != "S")
						echo '<input name="txt_turno2" type="hidden" value="B" size="1" readonly>';
				?>
                B</div></td>
            <td  align="center"> 
              <?php
					echo '<input name="txt_reactores2" type="text" value="'.$txt_reactores2.'" size="5">';
			?>
            </td>
            <td  align="center"> 
              <?php
					echo '<input name="txt_sulfato_cobre2" type="text" value="'.$txt_sulfato_cobre2.'" size="5">';
			?>
            </td>
            <td  align="center"> 
              <?php
					echo '<input name="txt_arseniato_ferico2" type="text" value="'.$txt_arseniato_ferico2.'" size="5">';
			?>
            </td>
            <td align="center"> <font face="Arial, Helvetica, sans-serif"> 
              <?php
						echo '<input name="txt_sales_niquel2" type="text" value="'.$txt_sales_niquel2.'" size="5">';
				?>
              </font> </td>
              <?php
					echo "<input name='txt_observacion2' type='hidden' id='textarea2' cols='25' value= '$txt_observacion2'>";
			  ?>
          </tr>
          <tr> 
            <td height="30"><div align="center"> 
                <?php
					if ($mostrar == "S" && $txt_checkbox3 == '')
						echo '<input name="txt_turno3" type="hidden" value="'.$txt_turno3.'" size="1" readonly>';
				    elseif($txt_checkbox3 == 3 || $mostrar != "S")
						echo '<input name="txt_turno3" type="hidden" value="C" size="1" readonly>';
				?>
                C</div></td>
            <td align="center"> 
              <?php
					echo '<input name="txt_reactores3" type="text" value="'.$txt_reactores3.'" size="5">';
			?>
            </td>
            <td align="center"> 
              <?php
					echo '<input name="txt_sulfato_cobre3" type="text" value="'.$txt_sulfato_cobre3.'" size="5">';
			?>
            </td>
            <td align="center"> 
              <?php
					echo '<input name="txt_arseniato_ferico3" type="text" value="'.$txt_arseniato_ferico3.'" size="5">';
			?>
            </td>
            <td align="center"> <font face="Arial, Helvetica, sans-serif"> 
              <?php
						echo '<input name="txt_sales_niquel3" type="text" value="'.$txt_sales_niquel3.'" size="5">';
				?>
              </font> </td>
              <?php
					echo "<input name='txt_observacion3' type='hidden' id='textarea3' cols='25' value= '$txt_observacion3'>";
			  ?>
          </tr>
        </table> <br>
      <tr>
      <td height="39" align="center"> <font face="Arial, Helvetica, sans-serif"> 
        <?php
  		  echo'<input name="modificar" type="button"  value="Guardar" onClick=Modificar("g"); style="width:70px">&nbsp;';
		?>
        </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font> <font face="Arial, Helvetica, sans-serif">&nbsp; 
        </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif">&nbsp;
        </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font>
		</td>
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
	if ($entrar=='S')
	    {
			echo"<script languaje='javascript'>";
			echo "Buscar2()";
			echo "</script>";
		}	
		
?>
