<?php
	include("../principal/conectar_sec_web.php");
	
	
	if ($opcion2 == "B")
	{    
	     $consulta_rectificador="select distinct max(fecha) as fecha1,cod_rectificador from ref_web.rectificadores where fecha <='".$Ano."-".$Mes."-".$Dia."' and cod_rectificador='".$txtrectificador."'  group by cod_rectificador order by cod_rectificador ";
		 $rs_rectificador=mysqli_query($link, $consulta_rectificador);	
	     $row_rectificador = mysqli_fetch_array($rs_rectificador);
	
	     $consulta_datos="SELECT max(fecha),cod_rectificador,descripcion_rectificador,Corriente_aplicada ";
         $consulta_datos.="FROM ref_web.rectificadores "; 
         $consulta_datos.="where cod_rectificador='".$txtrectificador."' and fecha='".$row_rectificador[fecha1]."' group by cod_rectificador";
		 $respuesta_datos=mysqli_query($link, $consulta_datos);
	     $row1 = mysqli_fetch_array($respuesta_datos);
		 $mostrar = "S";
	}
	if ($opcion == "N")
	{
		$consulta2 = "SELECT IFNULL(MAX(cod_rectificador)+1,1) AS cod_rectificador2 FROM ref_web.rectificadores";
		$rs12 = mysqli_query($link, $consulta2);
		$row1 = mysqli_fetch_array($rs12);
		$txtrectificador = $row1[cod_rectificador2];
		if (strlen($txtrectificador)==1)
			{
			 $txtrectificador='0'.$txtrectificador;
			}
		//echo $grupo;
	}	
?>

<html>
<head>
<title>Ingreso Rectificadores</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaCampos(f)
{
	if (f.txtrectificador.value == "")
	{
		alert("Debe Ingresar el N del rectifiucador");
		return false;
	}
	
	if (f.txtaplicada.value == "")
	{
		alert("Debe ingresar corriente aplicada");
		return false;
	}
	
	
	
	return true;
}
/*****************/
function Grabar(f)
{
	if (ValidaCampos(f))
	{
		f.action = "ref_ing_rectificadores_proceso01.php?proceso=G&txtrectificador=" + f.txtrectificador.value + "&opcion=" + f.opcion.value;
		f.submit();
	}
}
function Buscar(f)
{
	f.action = "sec_ing_grupo_electrolitico_proceso_ref.php?opcion2=B&txtrectificador=" + f.txtrectificador.value ;
	f.submit();
}


/****************/
function Salir()
{
	window.close();
}
</script>
</head>


<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPopup" action="" method="post">
  <table width="441" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
<tr>
  <td width="429" align="center" valign="middle">
  
  <table width="423" border="1" cellspacing="0" cellpadding="3">
          <tr> 
            <td>Fecha</td>
            <td> <select name="Dia" style="width:50px;">
                <?php
						for ($i = 1;$i <= 31; $i++)
						{
							if (isset($Dia))
							{
								if ($Dia == $i)
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
							else
							{
								if ($i == date("j"))
									echo "<option selected value='".$i."'>".$i."</option>\n";
								else	echo "<option value='".$i."'>".$i."</option>\n";
							}
						}
					  ?>
              </select> <select name="Mes" style="width:100px">
                <?php
				$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				for ($i=1;$i<=12;$i++)
				{
					if (isset($Mes))
					{
						if ($i == $Mes)
							echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
					else
					{
						if ($i == date("n"))
							echo "<option value='".$i."' selected>".$Meses[$i-1]."</option>\n";
						else
							echo "<option value='".$i."'>".$Meses[$i-1]."</option>\n";
					}
				}
			?>
              </select> <select name="Ano" style="width:100px">
                <?php				
				for ($i=(date("Y")-1);$i<=(date("Y")+1);$i++)
				{
					if (isset($Ano))
					{
						if ($i == $Ano)
							echo "<option value='".$i."' selected>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
					else
					{
						if ($i == date("Y"))
							echo "<option value='".$i."' selected>".$i."</option>\n";
						else
							echo "<option value='".$i."'>".$i."</option>\n";
					}
				}
			?>
              </select> </td>
          </tr>
          <tr> 
            <td width="137">N&deg; Rectificador</td>
            <td width="268"> 
              <?php
			    $consulta="SELECT distinct cod_rectificador FROM ref_web.rectificadores where cod_rectificador='".$txtrectificador."' group by cod_rectificador ";
				$rs = mysqli_query($link, $consulta);
				$rows = mysqli_fetch_array($rs);
            	if ($mostrar == "S")
				{
					if ($opcion == "M")
				  		echo '<input name="txtrectificador" type="hidden" size="10" value="'.$txtrectificador.'" >'.$txtrectificador;
					else
						echo '<input name="txtrectificador" type="text" size="10" value="'.$txtrectificador.'">';						
				}
				else
				{
				  	echo '<input name="txtrectificador" type="text" size="10" value="'.$txtrectificador.'">';					
				}
			?>
            </td>
          </tr>
          <tr> 
            <td>Corriente Aplicada</td>
            <td><input name="txtaplicada" type="text" size="10" value="<?php echo $row1[Corriente_aplicada] ?>"></td>
          </tr>
          <tr> 
            <td>Descripcion Rectificador</td>
            <td><input name="txtdescripcion" type="text" size="20" value="<?php echo $row1[descripcion_rectificador] ?>"></td>
          </tr>
        </table> 
	  	<?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
	  
        <br>
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="JavaScrip:Grabar(this.form)">
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="JavaScript:Salir()"></td>
        </tr>
      </table></td>
	  
</tr>
</table>	  
</form>
<?php
	if (isset($activar))
	{
		echo '<script language="JavaScript">';		
		if (isset($mensaje))
			echo 'alert("'.$mensaje.'");';		
			
		echo 'window.opener.document.frmPrincipal.action = "ref_ing_rectificadores.php";';
		echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>


