<?php include("../principal/conectar_ref_web.php"); ?>
<HTML>
<HEAD>
      <TITLE> Ingresos a PTE </TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  
<script language="JavaScript">
function Salir()
{
	window.close();
}
/**********/
function Recarga1()
{	
	var f = document.frmPrincipal;
	f.action = "pte01.php?recargapag1=S";
	f.submit();
}
/**********/
function Recarga2()
{	
	var f = document.frmPrincipal;
	f.action = "ingreso_cat_ini02.php?recargapag2=S";
	f.submit();
}
/**********/
function Grabar()
{
	var f = document.frmPrincipal;
	f.action = "pte01.php?proceso=G";
	f.submit();
}

/**********/
function Buscar()
{
	var f = document.frmPrincipal;
	f.action = "pte01.php?proceso=B";
	f.submit();
}
/**********/
function Modificar()
{
	var f = document.frmPrincipal;
	f.action = "pte01.php?proceso=M";
	f.submit();
}
</script>
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
</HEAD>
<BODY >
<FORM name="frmPrincipal" action="" method="post">
  <?php
?>
  <table width="433" height="174" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td align="center"><p><font face="Arial, Helvetica, sans-serif">Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          </font></p></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
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
          <select name="mes1" size="1" id="mes1">
            <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
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
          <input name="btnbuscar" type="button" id="btnbuscar" value="Buscar" onClick="Buscar()">
          </font></div></td>
    </tr>
    <tr> 
      <td width="123" height="29" align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">Turno 
          &nbsp;&nbsp;</font></div></td>
      <td width="367" align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <select name="txt_turno">
            <option value='-1'>Seleccionar</option>
            <?php
					$Consulta="select distinct turno from catodos_iniciales.iniciales order by turno"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($txt_turno==$Fila[turno])
							echo "<option value='".$Fila[turno]."' selected>".$Fila[turno]."</option>";
						else
							echo "<option value='".$Fila[turno]."'>".$Fila[turno]."</option>";
		     		}
				?>
          </select>
          </font> </div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">Destino</font></div></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <select name="txt_destino_pte">
            <option value="-1">Seleccionar</option>
            <option value="Venta">Venta</option>
            <option value="Proceso">Proceso</option>
          </select>
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><p align="left"><font face="Arial, Helvetica, sans-serif">Circuito</font><font face="Arial, Helvetica, sans-serif">&nbsp; 
          </font><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;</font></p></td>
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif"> 
          <select name="txt_circuito_pte">
            <option value='-1'>Seleccionar</option>
            <?php
					$Consulta="select distinct cod_circuito from sec_web.circuitos order by cod_circuito"; 
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($txt_circuitos==$Fila[cod_circuito])
							echo "<option value='".$Fila[cod_circuito]."' selected>".$Fila[cod_circuito]."</option>";
						else
							echo "<option value='".$Fila[cod_circuito]."'>".$Fila[cod_circuito]."</option>";
		     		}
				?>
          </select>
          </font></div></td>
    </tr>
    <tr> 
      <td align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">Volumen</font> 
          <font face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
      <td align="center"><div align="left"> 
          <input name="txt_volumen_pte" type="text" size="10" value="<?php echo $row[volumen_pte]?>">
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" align="center" valign="middle"> 
        <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
        <br> <table width="500" border="0" cellspacing="0" cellpadding="3">
          <tr> 
            <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="Grabar(this.form)">
              <font face="Arial, Helvetica, sans-serif">
              <input name ="btnModificar" type="button" style="width:70"onClick="Modificar()" value="Modificar">
              </font>
<input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()"> 
            </td>
          </tr>
        </table></td>
    </tr>
  </table>
  <font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif"> 
  </font> 
</FORM>
</BODY>
</HTML>
<?php
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	
	}
?>