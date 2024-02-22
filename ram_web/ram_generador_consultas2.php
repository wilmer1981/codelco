<?php
$CodigoDeSistema = 7;
$CodigoDePantalla = 7;
?>
<html>
<head>
<title>Consultas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">

<script language="JavaScript">
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
		f.action = "ram_lst_mov_del_dia.php";
		f.submit();
	}
	
	if(f.cmbconsulta.value == 2)
	{
		if(f.cmbturno.value != -1)
		{
			f.action = "ram_lst_turno_lugar.php";
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
		f.action = "ram_lst_inf_diario2.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 4)
	{
		f.action = "ram_lst_mov_acum2.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 5)
	{
		f.action = "ram_lst_mezcla.php";
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
		f.action = "ram_xls_mov_del_dia.php";
		f.submit();
	}
	
	if(f.cmbconsulta.value == 2)
	{
		if(f.cmbturno.value != -1)
		{
			f.action = "ram_xls_turno_lugar.php";
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
		f.action = "ram_xls_inf_diario.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 4)
	{
		f.action = "ram_xls_mov_acum.php";
		f.submit();
	}

	if(f.cmbconsulta.value == 5)
	{
		f.action = "ram_xls_mezcla.php";
		f.submit();
	}


}


function Recarga()
{
var f=formulario;
    f.action ="ram_generador_consultas2.php?Proceso=R";
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
  
<table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
  <tr>
  	<td align="center" valign="middle">
		<table width="700" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
          <tr> 
            <td width="128"><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Tipo 
              de Consulta</td>
            <td width="211"> 
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
            <td width="90">&nbsp;</td>
            <td width="252">&nbsp;</td>
          </tr>
          <tr> 
            <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">
			&nbsp;Fecha
			<?php if($cmbconsulta == "4")
				 echo "Ini";
			?>
			</td>
            <td><font color="#000000" size="2"> 
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
              </font> <font color="#000000" size="2"> 
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
              </select>
              </font></td>
<?php
 if($cmbconsulta == "4")
 {	   echo' <td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Fecha Ter</td>
 	   <td>'; 
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

    echo '</select>
              </td>';
 }			  			  
?>
			<?php
			if($cmbconsulta == 2)
			{
				echo'<td><img src="../principal/imagenes/left-flecha.gif" width="11" height="11">&nbsp;Turno</td>';
				echo'<td>';
				echo'<select name="cmbturno">';
					echo'<option value="-1" selected>Seleccionar</option>';
					echo'<option value="A">Turno A</option>';
					echo'<option value="B">Turno B</option>';
					echo'<option value="C">Turno C</option>';
				echo'</select>';
			}
		  ?>
		  </td>
          </tr>
		</table>  
		<br>
		<table width="700" border="0" cellspacing="0" cellpadding="2" class="TablaDetalle">
		  <tr> 
            <td><div align="center">
                <input name="ejecutar_web" type="button"  value="Listar Web" style="width:80" onClick="Ejecutar_Web();">
                <input name="ejecutar_excel" type="button"  value="Listar Excel" style="width:80" onClick="Ejecutar_Excel();">
                <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
              </div></td>
          </tr>
        </table>
     </td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php")?>  
		
</form>
</body>
</html>
