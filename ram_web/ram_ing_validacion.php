<?php

$CodigoDeSistema = 7;
$CodigoDePantalla = 6;

          $Proceso = 'B';
		  include("../principal/conectar_ram_web.php"); 
		  $Consulta = "SELECT * FROM parametros";
		  $rs = mysqli_query($link, $Consulta);
		  
		  if($row = mysqli_fetch_array($rs)) 
		  {
            $ano1 = substr($row["fecha_ini_rec"],0,4);
            $mes1 = substr($row["fecha_ini_rec"],5,2);
            $dia1 = substr($row["fecha_ini_rec"],8,2);
            $hr1 = substr($row["fecha_ini_rec"],11,2);
            $min1 = substr($row["fecha_ini_rec"],14,2);

            $ano2 = substr($row["fecha_ter_rec"],0,4);
            $mes2 = substr($row["fecha_ter_rec"],5,2);
            $dia2 = substr($row["fecha_ter_rec"],8,2);
            $hr2 = substr($row["fecha_ter_rec"],11,2);
            $min2 = substr($row["fecha_ter_rec"],14,2);

            $ano3 = substr($row["fecha_ini_tra"],0,4);
            $mes3 = substr($row["fecha_ini_tra"],5,2);
            $dia3 = substr($row["fecha_ini_tra"],8,2);
            $hr3= substr($row["fecha_ini_tra"],11,2);
            $min3 = substr($row["fecha_ini_tra"],14,2);

            $ano4 = substr($row["fecha_ter_tra"],0,4);
            $mes4 = substr($row["fecha_ter_tra"],5,2);
            $dia4 = substr($row["fecha_ter_tra"],8,2);
            $hr4 = substr($row["fecha_ter_tra"],11,2);
            $min4 = substr($row["fecha_ter_tra"],14,2);
		  }	
          
?>
<html>

<head>
    <title>Validaci&oacute;n de Informaci&oacute;n</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript">
    function Recargar() {
        var f = formulario;
        f.action = "ram_ing_validacion.php?Proceso=R";
        f.submit();

    }

    function Buscar_Datos() {
        var f = formulario;
        f.action = "ram_ing_validacion.php?Proceso=B";
        f.submit();

    }

    function Guardar_Datos() {
        var f = formulario;
        f.action = "ram_ing_validacion01.php?Proceso=G";
        f.submit();

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
                <td width="763" align="center" valign="top">
                    <table width="760" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
                        <tr class="ColorTabla01">
                            <td height="18" colspan="4">
                                <div align="center">Parametros Fechas</div>
                            </td>
                        </tr>
                        <tr class="ColorTabla02">
                            <td colspan="4"><strong>Recepci&oacute;n</strong></td>
                        </tr>
                        <tr>
                            <td width="100" height="28">Fecha Inicio</td>
                            <td width="233">
                                <select name="dia1">
                                    <?php
			if($Proceso=='B')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia1)
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
                                </select> <select name="mes1">

                                    <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes1)
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
                                </select> <select name="ano1">

                                    <?php
	if($Proceso=='B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano1)
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
                            </td>
                            <td width="88">Hora Inicio</td>
                            <td width="315"><select name="hr1">
                                    <?php
		 	for($i=0; $i<=23; $i++)
			{
				if (($Proceso == "B") && ($i == $hr1))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($Proceso != "B"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
                                </select>
                                :
                                <select name="min1">
                                    <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($Proceso == "B") && ($i == $min1))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($Proceso != "B"))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td height="26">Fecha T&eacute;rmino</td>
                            <td> <select name="dia2">
                                    <?php
			if($Proceso=='B')
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
	?>
                                </select> <select name="mes2">
                                    <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
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
  		  
     ?>
                                </select> <select name="ano2">
                                    <?php
	if($Proceso=='B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
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
                                </select></td>
                            <td>Hora T&eacute;rmino</td>
                            <td><select name="hr2">
                                    <?php
		 	for($i=0; $i<=23; $i++)
			{
				if (($Proceso == "B") && ($i == $hr2))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($Proceso != "B"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
                                </select>
                                :
                                <select name="min2">
                                    <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($Proceso == "B") && ($i == $min2))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($Proceso != "B"))
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
                    <table width="760" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
                        <tr class="ColorTabla02">
                            <td colspan="4"><strong>Traspaso</strong></td>
                        </tr>
                        <tr>
                            <td width="98">Fecha Inicio</td>
                            <td width="235"> <select name="dia3">
                                    <?php
			if($Proceso=='B')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia3)
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
                                </select> <select name="mes3">
                                    <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes3)
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
                                </select> <select name="ano3">
                                    <?php
	if($Proceso=='B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano3)
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
                                </select> </td>
                            <td width="87">Hora Inicio</td>
                            <td width="316"><select name="hr3">
                                    <?php
		 	for($i=0; $i<=23; $i++)
			{
				if (($Proceso == "B") && ($i == $hr3))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($Proceso != "B"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
                                </select>
                                :
                                <select name="min3">
                                    <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($Proceso == "B") && ($i == $min3))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($Proceso != "B"))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Fecha T&eacute;rmino</td>
                            <td> <select name="dia4">
                                    <?php
			if($Proceso=='B')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia4)
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
                                </select> <select name="mes4">
                                    <?php
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='B')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes4)
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
                                </select> <select name="ano4">
                                    <?php
	if($Proceso=='B')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano4)
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
                                </select></td>
                            <td>Hora T&eacute;rmino</td>
                            <td><select name="hr4" id="select9">
                                    <?php
		 	for($i=0; $i<=23; $i++)
			{
				if (($Proceso == "B") && ($i == $hr4))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("H")) && ($Proceso != "B"))
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				else	
					echo '<option value="'.$i.'">'.$i.'</option>';
			}
		?>
                                </select>
                                :
                                <select name="min4">
                                    <?php
		 	for($i=0; $i<=59; $i++)
			{
				if (($Proceso == "B") && ($i == $min4))
					echo '<option selected value ="'.$i.'">'.$i.'</option>';
				else if (($i == date("i")) && ($Proceso != "B"))
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
                    <table width="760" border="0" cellpadding="3" cellspacing="0" class="TablaDetalle">
                        <tr>
                            <td colspan="4">
                                <div align="center">
                                    <input name="Guardar" type="button" value="Guardar" onClick="Guardar_Datos();"
                                        style="width:70px">
                                    <input name="salir" type="button" style="width:70" onClick="salir_menu();"
                                        value="Salir">
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php include("../principal/pie_pagina.php")?>

    </form>
</body>

</html>