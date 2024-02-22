<?php
$CodigoDeSistema = 7;
$CodigoDePantalla = 7;

$Ayer = date("Y-m-d", mktime(0,0,0,date("m"),(date("d")-1),date("Y")));
$DiaAyer = intval(substr($Ayer,8,2));
$MesAyer = intval(substr($Ayer,5,2));
$AnoAyer = intval(substr($Ayer,0,4));


include("../principal/conectar_ram_web.php");

$fecha = $ano.'-'.$mes.'-'.$dia;

	if($Proceso1 == "W" || $Proceso1 == "E")//mov por dia
	{
	 	$Consulta = "SELECT * FROM ram_web.control_listados WHERE fecha = '".$fecha."' AND control = 1";
		$RS = mysqli_query($link, $Consulta);
		
		if ($row = mysqli_fetch_array($RS)) //Existe.
		{

			echo '<script languege="JavaScript">';
			echo 'if (confirm("Datos No Oficiales Desea Continuar"))';
			echo '{';
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia;
			if($Proceso1 == "W")
				echo 'document.location = "ram_lst_mov_del_dia.php?'.$linea.'";';
			else
				echo 'document.location = "ram_xls_mov_del_dia.php?'.$linea.'";';
			echo '}';
			echo 'else';
			echo '{';
			$linea = "Proceso=R&ano=".$ano."&mes=".$mes."&dia=".$dia."&cmbconsulta=".$cmbconsulta;
			echo 'document.location = "ram_generador_consultas_usuarios.php?'.$linea.'"';
			echo '}';
			echo '</script>';				
		}
		else
		{
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia;
			if($Proceso1 == "W")
				header("location:ram_lst_mov_del_dia.php?".$linea);
			else
				header("location:ram_xls_mov_del_dia.php?".$linea);
		}			

	}
	
	
	if($Proceso2 == "W" || $Proceso2 == "E")//mov por turno
	{
	 	$Consulta = "SELECT * FROM ram_web.control_listados WHERE fecha = '".$fecha."' AND control = 1";
		$RS = mysqli_query($link, $Consulta);
		
		if ($row = mysqli_fetch_array($RS)) //Existe.
		{

			echo '<script languege="JavaScript">';
			echo 'if (confirm("Datos No Oficiales Desea Continuar"))';
			echo '{';
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia."&cmbturno=".$cmbturno;
			if($Proceso2 == "W")
				echo 'document.location = "ram_lst_turno_lugar.php?'.$linea.'";';
			else
				echo 'document.location = "ram_xls_turno_lugar.php?'.$linea.'";';
			echo '}';
			echo 'else';
			echo '{';
			$linea = "Proceso=R&ano=".$ano."&mes=".$mes."&dia=".$dia."&cmbconsulta=".$cmbconsulta."&cmbturno=".$cmbturno;
			echo 'document.location = "ram_generador_consultas_usuarios.php?'.$linea.'"';
			echo '}';
			echo '</script>';				
		}
		else
		{
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia."&cmbturno=".$cmbturno;
			if($Proceso2 == "W")
				header("location:ram_lst_turno_lugar.php?".$linea);
			else
				header("location:ram_xls_turno_lugar.php?".$linea);
		}			

	}


	if($Proceso3 == "W" || $Proceso3 == "E")//Informe Diario
	{
	 	$Consulta = "SELECT * FROM ram_web.control_listados WHERE fecha = '".$fecha."' AND control = 1";
		$RS = mysqli_query($link, $Consulta);
		
		if ($row = mysqli_fetch_array($RS)) //Existe.
		{

			echo '<script languege="JavaScript">';
			echo 'if (confirm("Datos No Oficiales Desea Continuar"))';
			echo '{';
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia;
			if($Proceso3 == "W")
				echo 'document.location = "ram_lst_inf_diario.php?'.$linea.'";';
			else
				echo 'document.location = "ram_xls_inf_diario.php?'.$linea.'";';
			echo '}';
			echo 'else';
			echo '{';
			$linea = "Proceso=R&ano=".$ano."&mes=".$mes."&dia=".$dia."&cmbconsulta=".$cmbconsulta;
			echo 'document.location = "ram_generador_consultas_usuarios.php?'.$linea.'"';
			echo '}';
			echo '</script>';				
		}
		else
		{
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia;
			if($Proceso3 == "W")
				header("location:ram_lst_inf_diario.php?".$linea);
			else
				header("location:ram_xls_inf_diario.php?".$linea);
		}			

	}
	


	if($Proceso4 == "W" || $Proceso4 == "E")//mov mezclas
	{
	 	$Consulta = "SELECT * FROM ram_web.control_listados WHERE fecha = '".$fecha."' AND control = 1";
		$RS = mysqli_query($link, $Consulta);
		
		if ($row = mysqli_fetch_array($RS)) //Existe.
		{

			echo '<script languege="JavaScript">';
			echo 'if (confirm("Datos No Oficiales Desea Continuar"))';
			echo '{';
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia."&ano2=".$ano2."&mes2=".$mes2."&dia2=".$dia2;
			if($Proceso4 == "W")
				echo 'document.location = "ram_lst_mov_acum.php?'.$linea.'";';
			else
				echo 'document.location = "ram_xls_mov_acum.php??'.$linea.'";';
			echo '}';
			echo 'else';
			echo '{';
			$linea = "Proceso=R&ano=".$ano."&mes=".$mes."&dia=".$dia."&ano2=".$ano2."&mes2=".$mes2."&dia2=".$dia2."&cmbconsulta=".$cmbconsulta;
			echo 'document.location = "ram_generador_consultas_usuarios.php?'.$linea.'"';
			echo '}';
			echo '</script>';				
		}
		else
		{
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia."&ano2=".$ano2."&mes2=".$mes2."&dia2=".$dia2;
			if($Proceso4 == "W")
				header("location:ram_lst_mov_acum.php?".$linea);
			else
				header("location:ram_xls_mov_acum.php?".$linea);
		}			

	}


	if($Proceso5 == "W" || $Proceso5 == "E")//mov mezclas
	{
	 	$Consulta = "SELECT * FROM ram_web.control_listados WHERE fecha = '".$fecha."' AND control = 1";
		$RS = mysqli_query($link, $Consulta);
		
		if ($row = mysqli_fetch_array($RS)) //Existe.
		{

			echo '<script languege="JavaScript">';
			echo 'if (confirm("Datos No Oficiales Desea Continuar"))';
			echo '{';
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia;
			if($Proceso5 == "W")
				echo 'document.location = "ram_lst_mezcla.php?'.$linea.'";';
			else
				echo 'document.location = "ram_xls_mezcla.php?'.$linea.'";';
			echo '}';
			echo 'else';
			echo '{';
			$linea = "Proceso=R&ano=".$ano."&mes=".$mes."&dia=".$dia."&cmbconsulta=".$cmbconsulta;
			echo 'document.location = "ram_generador_consultas_usuarios.php?'.$linea.'"';
			echo '}';
			echo '</script>';				
		}
		else
		{
			$linea = "generador=2&ano=".$ano."&mes=".$mes."&dia=".$dia;
			if($Proceso5 == "W")
				header("location:ram_lst_mezcla.php?".$linea);
			else
				header("location:ram_xls_mezcla.php?".$linea);
		}			

	}


?>
<html>
<head>
<title>Consultas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">

<script language="JavaScript">

function Ejecutar_Ayer()
{ 
var f = formulario;
	
	f.dia.value = f.DiaAyer.value;
	f.mes.value = f.MesAyer.value;
	f.ano.value = f.AnoAyer.value;		

	if(f.cmbconsulta.value == -1)
	{
		alert("Debe Escoger Tipo de Consulta");
		f.cmbconsulta.focus();
		return
	}

	if(f.cmbconsulta.value == 1)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso1=W";
		f.submit();
	}

	if(f.cmbconsulta.value == 2)
	{
		if(f.cmbturno.value != -1)
		{
			f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso2=W";
			f.submit();
		}
		else
		{
			alert("Debe Escoger Turno");
			f.cmbturno.focus();
			return
		}
			
	}

	if(f.cmbconsulta.value == 3)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso3=W";
		f.submit();
	}

	if(f.cmbconsulta.value == 4)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso4=W";
		f.submit();
	}

	if(f.cmbconsulta.value == 5)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso5=W";
		f.submit();
	}


}

function Ejecutar_Web()
{ 
var f = formulario;
	

	if(f.cmbconsulta.value == -1)
	{
		alert("Debe Escoger Tipo de Consulta");
		f.cmbconsulta.focus();
		return
	}

	if(f.cmbconsulta.value == 1)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso1=W";
		f.submit();
	}

	if(f.cmbconsulta.value == 2)
	{
		if(f.cmbturno.value != -1)
		{
			f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso2=W";
			f.submit();
		}
		else
		{
			alert("Debe Escoger Turno");
			f.cmbturno.focus();
			return
		}
			
	}

	if(f.cmbconsulta.value == 3)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso3=W";
		f.submit();
	}

	if(f.cmbconsulta.value == 4)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso4=W";
		f.submit();
	}

	if(f.cmbconsulta.value == 5)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso5=W";
		f.submit();
	}


}

function Ejecutar_Excel()
{ 
var f = formulario;
	
	if(f.cmbconsulta.value == -1)
	{
		alert("Debe Escoger Tipo de Consulta");
		f.cmbconsulta.focus();
		return
	}
	
	if(f.cmbconsulta.value == 1)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso1=E";
		f.submit();
	}

	if(f.cmbconsulta.value == 2)
	{
		if(f.cmbturno.value != -1)
		{
			f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso2=E";
			f.submit();
		}
		else
		{
			alert("Debe Escoger Turno");
			f.cmbturno.focus();
			return
		}
			
	}

	if(f.cmbconsulta.value == 3)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso3=E";
		f.submit();
	}

	if(f.cmbconsulta.value == 4)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso4=E";
		f.submit();
	}

	if(f.cmbconsulta.value == 5)
	{
		f.action = "ram_generador_consultas_usuarios.php?Proceso=R&Proceso5=E";
		f.submit();
	}


}


function Recarga()
{
var f=formulario;
    f.action ="ram_generador_consultas_usuarios.php?Proceso=R";
	f.submit();
}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=7";
	f.submit();
}

</script>
</head>

<body leftmargin="0" topmargin="2">
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?> 
  
<input type="hidden" name="DiaAyer" value="<?php echo $DiaAyer; ?>">
<input type="hidden" name="MesAyer" value="<?php echo $MesAyer; ?>">
<input type="hidden" name="AnoAyer" value="<?php echo $AnoAyer; ?>">
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <tr>
    <td width="762" height="313" align="center" valign="middle">

		<table width="700" border="1" align="center" cellpadding="3" cellspacing="0" class="TablaDetalle">
		<tr align="center" class="ColorTabla01">
          <td colspan="4"><strong>CONSULTAS RAM </strong></td>
        </tr>
          <tr> 
            <td width="130"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo 
              de Consulta:</td>
            <td colspan="3"> 
              <?php
		  echo'<select name="cmbconsulta" style="width:200" onChange="Recarga();">';
          	echo'<option value="-1" selected>Seleccionar</option>';
           
		    if($cmbconsulta == "1")
          		echo'<option value="1" selected>Movimientos Totales por Día</option>';
            else 	
          		echo'<option value="1">Movimientos Totales por Día</option>';

            if($cmbconsulta == "2")
				echo'<option value="2" selected>Movimientos Por Lugar/Turno</option>';
			else
				echo'<option value="2">Movimientos Por Lugar/Turno</option>';

            if($cmbconsulta == "3")
          		echo'<option value="3" selected>Informe Diario</option>';
			else
          		echo'<option value="3">Informe Diario</option>';

            if($cmbconsulta == "4")
          		echo'<option value="4" selected>Movimientos Acumulados</option>';
			else
          		echo'<option value="4">Movimientos Acumulados</option>';

            if($cmbconsulta == "5")
          		echo'<option value="5" selected>Movimientos de Mezclas</option>';
			else
          		echo'<option value="5">Movimientos de Mezclas</option>';

          echo'</select>';
		  ?>
            </td>
          </tr>
          <tr> 
            <td width="130"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">
			&nbsp;Fecha
			<?php if($cmbconsulta == "4")
				 echo "Ini";
			?> :
</td>
            <td width="235">
     <?php
             echo '<select name="dia" size="1" style="font-face:verdana;font-size:10">';
			if($Proceso=='V' || $Proceso=='R')
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
           echo'</select>';
	?>               
              <select name="mes" size="1" id="select" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V' || $Proceso=='R')
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
              <select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php
	if($Proceso=='V' || $Proceso=='R')
	{
	    for ($i=date("Y")-3;$i<=date("Y")+1;$i++)	
	    {
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
	    for ($i=date("Y")-3;$i<=date("Y")+1;$i++)	
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
              </select></td>
            <td width="100">
<?php
	if($cmbconsulta == "4")
		echo' <img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Fecha Ter&nbsp;:';
	else
	{
		if($cmbconsulta == "2")
		{
			echo'<img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Turno&nbsp;:';
		}
		else
			echo "&nbsp;";
	}
?>
	</td>
            <td width="252">
<?php 
  if($cmbconsulta == "4")
  {
       echo '<select name="dia2" size="1" style="font-face:verdana;font-size:10">';
			if($Proceso=='V')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia2)
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
           echo'</select>';

      echo'<select name="mes2" size="1">';
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes2)
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
  		  
    echo '</select>';

    echo '<select name="ano2" size="1">';

	if($Proceso=='V')
	{
	    for ($i=date("Y")-3;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano2)
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
	    for ($i=date("Y")-3;$i<=date("Y")+1;$i++)	
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
    echo '</select>';
 }			  			
 else
 {
 	if($cmbconsulta == "2")
	{
		echo'<select name="cmbturno">';
		echo'<option value="-1" selected>Seleccionar</option>';
		echo'<option value="A">Turno A</option>';
		echo'<option value="B">Turno B</option>';
		echo'<option value="C">Turno C</option>';
		echo'</select>';
	}
	else
	{
		echo "&nbsp;";
	}
 }  
?>
		  </td>
          </tr>
  </table>  
		<br>		<table width="700" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
		  <tr> 
            <td><div align="center">	         		
			    <?php
	             if($cmbconsulta != "4")
				 {				
				?>
				  <input name='BtnAyer' type='button' id="BtnAyer" style='width:70px' onClick="Ejecutar_Ayer();" value='Ayer'>
                
				<?php } ?>  
                <input name="ejecutar_web" type="button"  value="Listar Web" style="width:80" onClick="Ejecutar_Web();">
                <input name="ejecutar_excel" type="button"  value="Listar Excel" style="width:80" onClick="Ejecutar_Excel();">                				
				<input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div></td>
          </tr>
  </table></td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php")?>  
		
</form>
</body>
</html>
