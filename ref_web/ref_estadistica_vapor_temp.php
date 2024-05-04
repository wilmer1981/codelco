<?php
	include("../principal/conectar_principal.php");

	$DiaIni     = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d"); 
	$MesIni     = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");  
	$AnoIni     = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y"); 
	$DiaFin     = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d"); 
	$MesFin     = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m"); 
	$AnoFin     = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y"); 

	$cmbcircuito     = isset($_REQUEST["cmbcircuito"])?$_REQUEST["cmbcircuito"]:""; 
	$buscar     = isset($_REQUEST["buscar"])?$_REQUEST["buscar"]:""; 
	$opcion     = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:""; 
	
	if ($DiaIni < 10)
		$DiaIni = "0".$DiaIni;
	if ($MesIni < 10)
		$MesIni = "0".$MesIni;
	if ($DiaFin < 10)
		$DiaFin = "0".$DiaFin;
	if ($MesFin < 10)
		$MesFin = "0".$MesFin;
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
?>
<html>
<head>
<title>Informe Estadistica Temperaturas y Vapor</title>
<link href="../Principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function Recarga1(opcion)
{	
	var f = document.frmPrincipal;
	//alert(opcion);
    if (f.opcion[0].checked)
	    {
		   //alert("hola1");
		  f.action = "ref_estadistica_vapor_temp.php?opcion=T"+"&cmbcircuito=1";
		}	
	else if (f.opcion[1].checked)
	        {
			 //alert("hola2");
	         f.action = "ref_estadistica_vapor_temp.php?opcion=V"+"&cmbcircuito=1";
	        }
			   
    f.submit();
}
function Buscar()
{
 var f = document.frmPrincipal;
 if (f.opcion[0].checked)
	    {
		  opcion="T";
		}	
	else if (f.opcion[1].checked) 
	        {
	         opcion="V";
	        }
 f.action = "ref_estadistica_vapor_temp.php?cmbcircuito="+f.cmbcircuito.value+"&buscar=S"+"&opcion="+opcion;
 f.submit();
}
function Imprimir(f)
{
	window.print();
}
function Salir(f)
{
 f.action ="../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
 f.submit();
}
function Excel(opcion,circuito,FechaInicio,FechaTermino)

{
var f = document.frmPrincipal;
 if (f.opcion[0].checked)
	    {
		  opcion="T";
		}	
	else if (f.opcion[1].checked)
	        {
	         opcion="V";
	        }
 f.action = "ref_estadistica_vapor_temp_xls.php?cmbcircuito="+f.cmbcircuito.value+"&buscar=S"+"&opcion="+opcion;
 f.submit();
}
function Grafico(opcion,circuito,FechaInicio,FechaTermino)
{
  var f = document.frmPrincipal;
  var URL ="../ref_web/ref_grafico_estadistica_temp_vapor.php?FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino+"&cmbcircuito="+circuito+"&opcion="+opcion;
 //window.open(URL,"","menubar=no resizable=no top=50 left=200 width=930 height=750 scrollbars=no");
  window.open(URL,"","menubar=no resizable=no top=30 left=20 width=920 height=700 scrollbars=no");


}
</script>
</head>
<body background="../Principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
  <table width="750" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
    <tr align="center" > 
      <td colspan="6" class="ColorTabla01"><strong>INFORME ESTADISTICAS DE TEMPERATURA 
        Y VAPOR</strong></td>
    </tr>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
    <tr> 
      <td width="132">Fecha Inicio:</td>
      <td colspan="2"><select name="DiaIni" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
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
        </select> <select name="MesIni" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoIni" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select></td>
      <td width="97">Fecha Termino:</td>
      <td width="281"><select name="DiaFin" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
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
        </select> <select name="MesFin" style="width:90px;">
          <?php
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoFin" style="width:60px;">
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select> </td>
    </tr>
    <tr align="center"> 
      <td height="10" colspan="5"> 
    <tr> 
      <td width="132" height="11">Temperaturas 
        <?php 
			if ($opcion=='T')
		      {  ?>
                    <input type="radio" name="opcion" value="T" onClick="Recarga1('T')" checked></td>
      		<?php }
	         else { ?>
      				<input type="radio" name="opcion" value="T"  onClick="Recarga1('T')"></td>
      <?php } ?>
      <td width="181"> Vapor 
        <?php 
			    if ($opcion=='V')
			      {  ?>
        			<input type="radio" name="opcion" value="V" onClick="Recarga1('V')" checked></td>
      			<?php } 
	            else { ?>
      					<input type="radio" name="opcion" value="V" onClick="Recarga1('V')"></td>
      			  <?php }  ?>
    </tr>
    <tr> 
      <td height="12">Circuito </td>
      <TD width="36" rowspan="2"><b> 
        <select name="cmbcircuito" id="select2">
          <?php if ($opcion=='T')
			        { 
					    $circuitos_temp=array('1','2','3','4','5','6','7','HM','Parcial' );
						for ($i = 1;$i <= 8; $i++)
						{
							if (isset($cmbcircuito))
							{
								if ($cmbcircuito == $i)
									echo "<option selected value='".$i."'>".ucwords(strtolower($circuitos_temp[$i - 1]))."</option>\n";
								else	echo "<option value='".$i."'>".ucwords(strtolower($circuitos_temp[$i - 1]))."</option>\n";
							}
						}
				     }	
	               else if ($opcion=='V')
				           {  
					        $circuitos_vapor=array('Matriz Entrada','1 al 4','5','6','7');
						    for ($i = 1;$i <= 5; $i++)
						        {
							     if (isset($cmbcircuito))
							        {
								     if ($cmbcircuito == $i)
									     echo "<option selected value='".$i."'>".ucwords(strtolower($circuitos_vapor[$i - 1]))."</option>\n";
								     else	echo "<option value='".$i."'>".ucwords(strtolower($circuitos_vapor[$i - 1]))."</option>\n";
							        }
						        }
		                   } 
						
				?>
        </select>
        </b></TD>
      <TD width="181" colspan="1" rowspan="2"><input name="buscar" type="button" value="buscar" onClick="Buscar()" ></TD>
      <td height="12"> 
        <input name="grafico" type="button" value="Graficar" onClick="Grafico('<?php echo $opcion; ?>','<?php echo $cmbcircuito; ?>','<?php echo $FechaInicio; ?>','<?php echo $FechaTermino;?>')" ></td>
    </tr>
  </table>
  </td></p>
      <td colspan="2"></td></tr>
  </table>
<table width="955" align="center">
 <?php 
    if ($buscar=='S')
        {	   
          if ($opcion=='T')
		     {
			   if ($cmbcircuito==1)
			      {
				   $parametros='FECHA,sum(TEMP1) as valor1,sum(TEMP2) as valor2';
				  }
				else if ($cmbcircuito==2)
			            {
				         $parametros='FECHA,sum(TEMP3) as valor1,sum(TEMP4) as valor2';
				        } 
					 else if ($cmbcircuito==3)
			                 {
				              $parametros='FECHA,sum(TEMP5) as valor1,sum(TEMP6) as valor2';
				             }
				     	  else if ($cmbcircuito==4)
			                     {
				                  $parametros='FECHA,sum(TEMP7) as valor1,sum(TEMP8) as valor2';
				                 }
							   else if ($cmbcircuito==5)
			                     {
				                  $parametros='FECHA,sum(TEMP9) as valor1,sum(TEMP10) as valor2';
				                 }
							   		else if ($cmbcircuito==6)
			                     			{
				                  			 $parametros='FECHA,sum(TEMP11) as valor1,sum(TEMP12) as valor2';
				                 			}
										 else if ($cmbcircuito==7)
			                                     {
				                                  $parametros='FECHA,sum(TEMP17) as valor1,sum(TEMP18) as valor2';
				                                 }  	  	 	
							   	   	  	 	  else if ($cmbcircuito==8)
			                                          {
				                                       $parametros='FECHA,sum(TEMP15) as valor1,sum(TEMP16) as valor2';
				                                      }  	  	  	  	 	   	  	 
			    $consulta_aux="select ".$parametros." from ref_web.temperaturas where ";
			   $consulta_fecha="select distinct FECHA from ref_web.temperaturas where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."' order by FECHA";
			 }
		 else if ($opcion=='V')
		         {
				   if ($cmbcircuito==1)
			          {
				       $parametros='FECHA,sum(TEMP1) as valor1,sum(PRE1) as valor2';
				      }
				   else if ($cmbcircuito==2)
			               { 
				            $parametros='FECHA,sum(TEMP2) as valor1,sum(PRE2) as valor2';
				           } 
					    else if ($cmbcircuito==3)
			                    {
				                 $parametros='FECHA,sum(TEMP3) as valor1,sum(PRE3) as valor2';
				                }
				     	     else if ($cmbcircuito==4)
			                         {
				                      $parametros='FECHA,sum(TEMP4) as valor1,sum(PRE4) as valor2';
				                    }
								 else if ($cmbcircuito==5)
										 {
										  $parametros='FECHA,sum(TEMP5) as valor1,sum(PRE5) as valor2';
										}

			   $consulta_fecha="select distinct FECHA from ref_web.vapor where fecha between '".$AnoIni.'-'.$MesIni.'-'.$DiaIni."' and '".$AnoFin.'-'.$MesFin.'-'.$DiaFin."' order by FECHA";			   
			   $consulta_aux="select ".$parametros." from ref_web.vapor where ";
			  } 
		      echo '<tr align="center">';
			  echo '<td>';
			  echo '<table width="756" border="2" cellspacing="2" cellpadding="2" bordercolor="#b26c4a" class="TablaDetalle">';
              echo '<tr class="ColorTabla01">';
			  if ($opcion=='T')
			     {echo '<td colspan="7" align="center"><strong>Circuito&nbsp;'.$circuitos_temp[$cmbcircuito-1].'</strong></td>';}
			  else {echo '<td colspan="7" align="center"><strong>Circuito&nbsp;'.$circuitos_vapor[$cmbcircuito-1].'</strong></td>';}	 
              echo '</tr>';
              echo '<tr class="ColorTabla01">';
              echo '<td width="119" rowspan="2" align="center"><strong>&nbsp;</strong><strong></strong><strong>Fecha</strong><strong></strong></td>';
              echo '<td colspan="2" align="center"><strong>Turno C</strong><strong></strong></td>';
              echo '<td colspan="2" align="center"><strong>Turno A</strong></td>';
              echo '<td colspan="2" align="center"><strong>Turno B</strong></td>';
              echo '</tr>';
              echo '<tr class="ColorTabla01">';
			  if ($opcion=='T')
			     {
				  echo '<td width="86" align="center"><strong>Temperatura Entrada(�C)</strong></td>';
				  echo '<td width="80" align="center"><strong>Termperatura Salida(�C)</strong></td>';
				  echo '<td width="113" align="center"><strong>Temperatura Entrada(�C)</strong></td>';
				  echo '<td width="99" align="center"><strong>Termperatura Salida(�C)</strong></td>';
				  echo '<td width="99" align="center"><strong>Temperatura Entrada(�C)</strong></td>';
				  echo '<td width="99" align="center"><strong>Termperatura Salida(�C)</strong></td>';
				 } 
				else { echo '<td width="113" align="center"><strong>Temperatura(�C)</strong></td>';
					   echo '<td width="99" align="center"><strong>Presion(Bar)</strong></td>';
					   echo '<td width="113" align="center"><strong>Temperatura(�C)</td>';
					   echo '<td width="99" align="center"><strong>Presion(Bar)</strong></td>';
					   echo '<td width="113" align="center"><strong>Temperatura(�C)</strong></td>';
					   echo '<td width="99" align="center"><strong>Presion(Bar)</strong></td>';} 
              echo '</tr>';
        
			  //echo $consulta_fecha;
			  $respuesta_fecha=mysqli_query($link, $consulta_fecha);
			  while ($row_fecha = mysqli_fetch_array($respuesta_fecha))
			       {
				     $consulta=$consulta_aux." FECHA='".$row_fecha["FECHA"]."' and TURNO='C' group by FECHA,turno order by FECHA,TURNO,INSTANTE ";
					 //echo $consulta."<br>";
				     $respuesta=mysqli_query($link, $consulta);
					 $row = mysqli_fetch_array($respuesta);
					 $total1=$row["valor1"]/3;
					 $total2=$row["valor2"]/3;
					 $consulta=$consulta_aux." FECHA='".$row_fecha["FECHA"]."' and TURNO='A' group by FECHA,turno order by FECHA,TURNO,INSTANTE ";
					 //echo $consulta."<br>";
				     $respuesta=mysqli_query($link, $consulta);
					 $row = mysqli_fetch_array($respuesta);
				     $total3=$row["valor1"]/3;
				     $total4=$row["valor2"]/3;
					 $consulta=$consulta_aux." FECHA='".$row_fecha["FECHA"]."' and TURNO='B' group by FECHA,turno order by FECHA,TURNO,INSTANTE ";
					 //echo $consulta."<br>";
				     $respuesta=mysqli_query($link, $consulta);
					 $row = mysqli_fetch_array($respuesta);
				     $total5=$row["valor1"]/3;
				     $total6=$row["valor2"]/3;
					echo '<tr>';
					echo '<td width="120" align="center" class=detalle01><strong>'.$row_fecha["FECHA"].'</strong><strong></strong></td>';
				    echo '<td align="center">'.number_format($total1,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total2,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total3,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total4,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total5,"1",".",".").'</td>';
					echo '<td align="center">'.number_format($total6,"1",".",".").'</td>';
				   }
	    }	  
 ?>
      </table>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td align="center"><input name="btnimprimir2" type="button" value="Excel" style="width:70;" onClick="JavaScript:Excel('<?php echo $opcion; ?>','<?php echo $cmbcircuito; ?>','<?php echo $FechaInicio; ?>','<?php echo $FechaTermino;?>')"> 
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)"> 
      <input name="btnsalir" type="button" style="width:70" onClick="JavaScript:Salir(this.form)" value="Salir"></td>
  </tr>
</table>
</form>
</body>
</html>
