<?php include("../principal/conectar_ref_web.php"); ?>
<HTML>
<HEAD>
      <TITLE> Ingresos H2so4 </TITLE>
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
	f.action = "ingreso_cat_ini.php?recargapag1=S";
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
function Guardar()
{
	var f = document.frmPrincipal;
	f.action = "h2so4_01.php?proceso=G";
	f.submit();
}

/**********/
function Agregar(f)
{
		parametros = ValidaFilas(f,'checkbox');
		if (isNaN(parseInt(f.filas.value)))
			filas = 1;
		else
			filas = parseInt(f.filas.value) + 1;
	
		linea = "recargapag=S&verificatabla=S&agregafila=S&numero=" + filas + "&parametros=" + parametros + "&buscar=S&mostrar=S";
		linea = linea + "&cmbhornada=" + f.cmbhornada.value + "&ano1=" + f.ano1.value + "&mes1=" + "&dia1=" + f.dia1.value;
		linea = linea + "&hr1=" + f.hr1.value + "&mm1=" + f.mm1.value + "&ano2=" + f.ano2.value + "&mes2=" + f.mes2.value + "&dia2=" + f.dia2.value; 
		linea = linea + "&hr2=" + f.hr2.value + "&mm2=" + f.mm2.value;
		linea = linea + "&recup4=" + f.recup4.value + "&recha4=" + f.recha4.value + "&prod4=" + f.prod4.value;
		f.action = "sea_ing_rechazos_anodos_ven.php?" + linea;
		f.submit();*/
	}
function Verifica(f,t)
{
	if (parseInt(t.value) < 0)	
	{
		alert("El Valor No Es Valido")
		t.focus();
		return;
	}
	else
		Calcular(f,'var');
}	
function Buscar()
{
	var f = document.frmPrincipal;
	f.action = "h2so4_01.php?proceso=B";
	f.submit();
}
/**********/
function Modificar()
{
	var f = document.frmPrincipal;
	f.action = "h2so4_01.php?proceso=M";
	f.submit();
}
</script>
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
</HEAD>
<BODY >
<FORM name="frmPrincipal" action="" method="post">

  <?php
?>
  <table width="486" height="10" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td align="center"><p align="left"><font face="Arial, Helvetica, sans-serif">Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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
      <td width="164" height="29" align="center"><div align="left"><font face="Arial, Helvetica, sans-serif">Turno 
          &nbsp;&nbsp;</font></div></td>
      <td width="321" align="center"><div align="left"> <font face="Arial, Helvetica, sans-serif"> 
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
          </font></div></td>
    </tr>
    <tr> 
      <td colspan="2" align="center"><div align="left"></div>
        <div align="left"><font face="Arial, Helvetica, sans-serif"> </select> 
          <input name="btnagregar" type="button" value="Agregar Detalle" style="width:100" onClick="JavaScript:Agregar(this.form)">
          <input name="btnborrar" type="button" value="Eliminar Detalle" style="width:100" onClick="JavaScript:Borrar(this.form)">
          </font></div></td>
    </tr>
    <tr> 
      <td colspan="2" align="center">
<table width="495" border="1" cellspacing="0" cellpadding="3">
          <tr> 
            <td width="240" align="center">Circuito</td>
            <td width="237" align="center">Volumen</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td colspan="2" align="center"> 
        <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
        <?php  
	include("../principal/conectar_principal.php");
	
	if ($verificatabla == "S")
	{
		echo '<table width="750" border="1" cellspacing="0" cellpadding="0" class="ColorTabla02">';
    	$j = 0;
		$largo = strlen($parametros);
		while (($j < $numero) and ($largo != 0))
		{
			//Separa los parametros. (cod_defecto - recuperables - rechazos)
			for ($i=0; $i < $largo; $i++)
			{
				if (substr($parametros,$i,1) == "/")
				{				
					$valor = explode("-",substr($parametros,0,$i)); //checkbox - select - text - text.
																 
					$parametros = substr($parametros,$i+1);
					$i = 0;			

					if ($valor[0] == 0) //Si es 1, la fila fue eliminada.
					{
						//Genera las filas que ya fueron ingresadas.
					  	echo '<tr>';
				   		echo '<td width="155"><input type="checkbox" name="checkbox" value="checkbox">';
						echo '<select name="select">';
					    echo '<option value="R">SELECCIONAR</option>';

						$consulta = "SELECT * FROM cod_circuito from sec_web.circuitos";
						$rs = mysqli_query($link, $consulta);
						while ($row = mysqli_fetch_array($rs))
						{
							if ($row["cod_subclase"] == $valor[1])
							    echo '<option value="'.$row[cod_circuito].'" selected>'.$row[cod_circuito].'</option>';
							else
						    	echo '<option value="'.$row[cod_circuito].'">'.$row[cod_circuito].'</option>';
	
						}
						echo '</select></td>';
			    		echo '<td width="72" align="center"><input type="text" name="var"  value="'.$valor[2].'" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
			    		echo '<td width="73" align="center"><input type="text" name="text" value="'.$valor[3].'" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
				   		echo '</tr>';					
					}				
					else 
						$numero = $numero - 1;
				}			
			}
			$j++;
	  	}
		if ($agregafila == "S")
		{
			//Genra la fila nueva.
		  	echo '<tr>';
    		echo '<td width="155"><input type="checkbox" name="checkbox" value="checkbox">';
			echo '<select name="select">';
		    echo '<option value="R">SELECCIONAR</option>';
		
			$consulta = "SELECT * FROM cod_circuito from sec_web.circuitos";
			$rs1 = mysqli_query($link, $consulta);
			while ($row1 = mysqli_fetch_array($rs1))
			{
			    echo '<option value="'.$row1[cod_circuito].'">'.$row1[cod_circuito].'</option>';
			}		
			echo '</select></td>';

    		echo '<td width="72" align="center"><input type="text" name="var"  size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
    		echo '<td width="73" align="center"><input type="text" name="text" size="8" onBlur="JavaScript:Verifica(this.form,this)"></td>';
    		echo '</tr>';
		}  
		echo '</table><br>';	
	}
	
	include("../principal/cerrar_principal.php");
?>
      </td>
    </tr>
    <tr> 
      <td colspan="2" align="center"><div align="left"></div>
        <table width="487" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
          <tr> 
            <td width="301" height="29" align="center"> <div align="center">&nbsp; 
                &nbsp; 
                <input name="btnguardar" type="button" style="width:70" value="Guardar" onClick="Guardar(this.form)">
                <font face="Arial, Helvetica, sans-serif"> 
                <input name ="btnModificar" type="button" style="width:70"onClick="Modificar()" value="Modificar">
                </font> 
                <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
              </div></td>
          </tr>
        </table> </td>
    </tr>
    <tr> 
      <td height="52" colspan="2" align="center"> 
        <div align="left"></div>
        <div align="left"></div>
        <br>
      </td>
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
