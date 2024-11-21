<?php
	include("../principal/conectar_sec_web.php");
	$fecha   = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:date("Y-m-d");
	$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$Ano = substr($fecha,0,4);
	$Mes = substr($fecha,5,2);
	$Dia = substr($fecha,8,2);
	if ($opcion == "M")
	{
		$consulta = "SELECT * FROM ref_web.produccion WHERE cod_grupo = '1' AND fecha = '".$fecha."'";
			
		$rs = mysqli_query($link, $consulta);
		if ($row = mysqli_fetch_array($rs))
		{
			//$checkbox = '0';
			$Ano = substr($row["fecha"],0,4);
			$Mes = substr($row["fecha"],5,2);
			$Dia = substr($row["fecha"],8,2);		
			
		}
		$consulta2 = "SELECT * FROM ref_web.produccion WHERE cod_grupo = '2' AND fecha = '".$fecha."'";
		$rs2 = mysqli_query($link, $consulta2);
		$row2 = mysqli_fetch_array($rs2);
		
		$consulta7 = "SELECT * FROM ref_web.produccion WHERE cod_grupo = '7' AND fecha = '".$fecha."'";
		$rs7 = mysqli_query($link, $consulta7);
		$row7 = mysqli_fetch_array($rs7);
		
		$consulta8 = "SELECT * FROM ref_web.produccion WHERE cod_grupo = '8' AND fecha = '".$fecha."'";
		$rs8 = mysqli_query($link, $consulta8);
		$row8 = mysqli_fetch_array($rs8);
		
		
	}
	

?>

<html>
<head>
<title>Ingreso y Modificacion Detalle Hojas Madres</title>

<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValidaCampos(f)
{
	if (f.txtgrupo.value == "")
	{
		alert("Debe Ingresar el N del Grupo");
		return false;
	}
	
	if (f.cmbcircuito.value == -1)
	{
		alert("Debe Seleccionar el Circuito");
		return false;
	}
	
	if (f.cmbestado.value == -1)
	{
		alert("Debe Seleccionar el Estado");
		return false;
	}
	
	return true;
}
/*****************/
function Grabar(f,opc)

{
       var f=document.frmPopup;
	   var fecha=f.Ano.value+"-"+f.Mes.value+"-"+f.Dia.value;

        linea = "opcion=" + opc;
	    linea = linea + "&gruesas1=" + f.txtgruesas1.value + "&delgadas1=" + f.txtdelgadas1.value + "&granuladas1=" + f.txtgranuladas1.value;
        linea = linea + "&gruesas2=" + f.txtgruesas2.value + "&delgadas2=" + f.txtdelgadas2.value + "&granuladas2=" + f.txtgranuladas2.value;
		linea = linea + "&gruesas7=" + f.txtgruesas7.value + "&delgadas7=" + f.txtdelgadas7.value + "&granuladas7=" + f.txtgranuladas7.value;
		linea = linea + "&gruesas8=" + f.txtgruesas8.value + "&delgadas8=" + f.txtdelgadas8.value + "&granuladas8=" + f.txtgranuladas8.value;
		linea= linea+ "&recuperado=" +f.txtrecuperado.value;
		f.action = "proceso01.php?fecha="+fecha+"&proceso=G" + linea;
		f.submit();
	
}
function Grabar2(f,opc)

{
       var f=document.frmPopup;
	   var fecha=f.Ano.value+"-"+f.Mes.value+"-"+f.Dia.value;

        linea = "opcion=" + opc;
	    linea = linea + "&gruesas1=" + f.txtgruesas1.value + "&delgadas1=" + f.txtdelgadas1.value + "&granuladas1=" + f.txtgranuladas1.value;
        linea = linea + "&gruesas2=" + f.txtgruesas2.value + "&delgadas2=" + f.txtdelgadas2.value + "&granuladas2=" + f.txtgranuladas2.value;
		linea = linea + "&gruesas7=" + f.txtgruesas7.value + "&delgadas7=" + f.txtdelgadas7.value + "&granuladas7=" + f.txtgranuladas7.value;
		linea = linea + "&gruesas8=" + f.txtgruesas8.value + "&delgadas8=" + f.txtdelgadas8.value + "&granuladas8=" + f.txtgranuladas8.value;
		linea= linea+ "&recuperado=" +f.txtrecuperado.value;
		f.action = "proceso01.php?fecha="+fecha+"&proceso=N" + linea;
		f.submit();
	//alert (proceso.value); 
}
function Buscar(f)
{
	f.action = "sec_ing_grupo_electrolitico_proceso_ref.php?opcion2=B&txtgrupo=" + f.cmbfecha.value ;
	f.submit();
}


/****************/
function Salir(f)
{
    fecha=f.Ano.value+'-'+f.Mes.value+'-'+f.Dia.value;
	f.action = "prueba_hm.php?fecha="+fecha ;
	f.submit();
}

function Calcula(grupo,tipo_rechazos,dato_esta,tipo)
{
	var f=document.frmPopup;
	if (tipo=='G1')
	   {
	        f.txtgruesas1.value=Number(dato_esta.replace(',','.'))+Number(f.txtgruesas12.value.replace(',','.'));    
	   }
	 else if (tipo=='D1')
	          {
	            f.txtdelgadas1.value=Number(dato_esta.replace(',','.'))+Number(f.txtdelgadas12.value.replace(',','.'));    
	          }  
	        else if (tipo=='Gra1')
			       {
				    f.txtgranuladas1.value=Number(dato_esta.replace(',','.'))+Number(f.txtgranuladas12.value.replace(',','.'));    
				   }
                  else if (tipo=='G2')
	                    {
	                     f.txtgruesas2.value=Number(dato_esta.replace(',','.'))+Number(f.txtgruesas22.value.replace(',','.'));    
	                    }
	                   else if (tipo=='D2')
	                         {
	                           f.txtdelgadas2.value=Number(dato_esta.replace(',','.'))+Number(f.txtdelgadas22.value.replace(',','.'));    
	                         }  
	                        else if (tipo=='Gra2')
			                      {
				                    f.txtgranuladas2.value=Number(dato_esta.replace(',','.'))+Number(f.txtgranuladas22.value.replace(',','.'));    
				                   }
								   else if (tipo=='G7')
	                                      {
	                                       f.txtgruesas7.value=Number(dato_esta.replace(',','.'))+Number(f.txtgruesas72.value.replace(',','.'));    
	                                      }
	                                     else if (tipo=='D7')
	                                          {
	                                           f.txtdelgadas7.value=Number(dato_esta.replace(',','.'))+Number(f.txtdelgadas72.value.replace(',','.'));    
	                                          }  
	                                         else if (tipo=='Gra7')
			                                       {
				                                    f.txtgranuladas7.value=Number(dato_esta.replace(',','.'))+Number(f.txtgranuladas72.value.replace(',','.'));    
				                                    }
												    else if (tipo=='G8')
	                                                       {
	                                                        f.txtgruesas8.value=Number(dato_esta.replace(',','.'))+Number(f.txtgruesas82.value.replace(',','.'));    
	                                                       }
	                                                      else if (tipo=='D8')
	                                                             {
	                                                              f.txtdelgadas8.value=Number(dato_esta.replace(',','.'))+Number(f.txtdelgadas82.value.replace(',','.'));    
	                                                             }  
	                                                           else if (tipo=='Gra8')
			                                                          {
				                                                       f.txtgranuladas8.value=Number(dato_esta.replace(',','.'))+Number(f.txtgranuladas82.value.replace(',','.'));    
				                                                       } 
 																	else if (tipo=='Rec')
																	         {f.txtrecuperado.value=Number(dato_esta.replace(',','.'))+Number(f.txtrecuperado2.value.replace(',','.'));     }																	   	 
return;	
}
function TeclaPulsada (tecla) 
{ 
	var Frm=document.frmPopup;
	var teclaCodigo = event.keyCode; 
	if ((teclaCodigo != 188 )&&(teclaCodigo != 110 )&&(teclaCodigo != 190 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
	{
		if (((teclaCodigo != 8) && (teclaCodigo !=9)) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
}

function modifica(fecha,grupo,gruesas,delgadas,granuladas)
{
 
   window.open("modifica_rechazo.php?fecha="+fecha+"&grupo="+grupo,"","top=195,left=180,width=420,height=180,scrollbars=no,resizable = no");
  
}



</script>
</head>


<body background="../principal/imagenes/fondo3.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="frmPopup" action="" method="post">
  <table width="493" height="485" border="0" cellpadding="5" align="center" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="844" height="485" align="center" valign="top"> 
	     <table width="485" height="348" border="1" cellpadding="3" cellspacing="0">
          <tr> 
            <?php if ($opcion=='N')
		        { ?>
                  <td colspan="6"><div align="center"><font color="#0000FF"><strong>Ingreso Detalle Rechazos Hojas Madres</strong></font></div></td>
             <?php } else { ?>
                        <td colspan="6"> <div align="center"><strong><font color="#0000FF">Modificacion Detalle Rechazos Hojas Madres </font></strong></div></td>
                    <?php }?>
          </tr>
          <tr> 
            <td width="120">Fecha</td>
            <td colspan="5"><select name="Dia" style="width:50px;" disabled>
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
              </select> <select name="Mes" style="width:100px" disabled>
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
              </select> <select name="Ano" style="width:100px" disabled>
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
          <?php 
		  	$rechazo_gruesas = isset($row['rechazo_gruesas'])?$row['rechazo_gruesas']:"";	
			$rechazo_delgadas = isset($row['rechazo_delgadas'])?$row['rechazo_delgadas']:"";
			$rechazo_granuladas = isset($row['rechazo_granuladas'])?$row['rechazo_granuladas']:"";
		  if ($opcion == 'M')
						{ ?>
          <td colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo1</strong>
             
                <?php	 
						  
							echo "<input type='image' src='../principal/imagenes/ico_modif3.gif' width='29' height='24'   onClick=\"modifica('$fecha','1','".$rechazo_gruesas."','".$rechazo_delgadas."','".$rechazo_granuladas."');\" value='0' checked title='modifica los datos anteriormenta ingresados'>";
							
						}
					   ?>
              </div></td>
          </tr>
          <?php 
		  if ($opcion=='M') 
			   {?>
          <td><strong>Gruesas</strong></td>
          <td width="75"> <input name="txtgruesas1" type="text" size="10"   value="<?php echo $rechazo_gruesas; ?>"  style="text-align: center;background:grey;" readonly ></td>
          <td width="65"><strong>Delgadas</strong></td>
          <td width="65"> <input name="txtdelgadas1" type="text" size="10" value="<?php echo $rechazo_delgadas; ?>" style="text-align: center;background:grey;" readonly></td>
          <td width="87"><strong>Granuladas</strong></td>
          <td width="382"> <input name="txtgranuladas1" type="text" size="10" value="<?php echo $rechazo_granuladas; ?>" style="text-align: center;background:grey;" readonly></td>
          <?php } 
				 else  if ($opcion=='N')
				        { ?>
          <tr> 
            <td height="10" colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo 
                1</font></strong></div></td>
          </tr>
          <td><strong>Gruesas</strong></td>
          <td width="75"> <input name="txtgruesas1" type="text" size="10" value="<?php echo $rechazo_gruesas; ?>" ></td>
          <td width="65"><strong>Delgadas</strong></td>
          <td width="65"> <input name="txtdelgadas1" type="text" size="10" value="<?php echo $rechazo_delgadas; ?>" ></td>
          <td width="87"><strong>Granuladas</strong></td>
          <td width="382"> <input name="txtgranuladas1" type="text" size="10" value="<?php echo $rechazo_granuladas; ?>" ></td>
          <?php } ?>
          </tr>
          <?php 
			$rechazo_gruesas = isset($row2['rechazo_gruesas'])?$row2['rechazo_gruesas']:"";	
			$rechazo_delgadas = isset($row2['rechazo_delgadas'])?$row2['rechazo_delgadas']:"";
			$rechazo_granuladas = isset($row2['rechazo_granuladas'])?$row2['rechazo_granuladas']:"";
		  if ($opcion == 'M')
						{ ?>
                            <td colspan="6"><div align="center" class="ColorTabla01" ><strong>Grupo2</strong> 
                            <?php
			                echo "<input type='image' src='../principal/imagenes/ico_modif3.gif' width='29' height='24'   onClick=\"modifica('$fecha','2','".$rechazo_gruesas."','".$rechazo_delgadas."','".$rechazo_granuladas."');\" value='0' checked title='modifica los datos anteriormenta ingresados'>";
							//echo "<input name='Radio2' type='radio'   onClick=\"modifica('$fecha','2','".$row2[rechazo_gruesas]."','".$row2[rechazo_delgadas]."','".$row2[rechazo_granuladas]."');\" value='0' checked>";
							//echo "Modificar";
						}
						
						 ?>
            </div></td>
          </tr>
          <?php if ($opcion=='M')
		      {?>
          <td><strong>Gruesas</strong></td>
          <td> <input name="txtgruesas2" type="text" size="10" value="<?php echo $rechazo_gruesas; ?>" style="text-align: center;background:grey;" readonly></td>
          <td><strong>Delgadas</strong></td>
          <td> <input name="txtdelgadas2" type="text" size="10" value="<?php echo $rechazo_delgadas; ?>" style="text-align: center;background:grey;" readonly> 
          </td>
          <td><strong>Granuladas</strong></td>
          <td> <input name="txtgranuladas2" type="text" size="10" value="<?php echo $rechazo_granuladas; ?>" style="text-align: center;background:grey;" readonly></td>
          <?php } 
		         else if ($opcion=='N')
				         { ?>
          <tr> 
            <td height="10" colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo 
                2</font></strong></div></td>
          </tr>
          <td><strong>Gruesas</strong></td>
          <td> <input name="txtgruesas2" type="text" size="10" value="<?php echo $rechazo_gruesas; ?>" ></td>
          <td><strong>Delgadas</strong></td>
          <td> <input name="txtdelgadas2" type="text" size="10" value="<?php echo $rechazo_delgadas; ?>" ></td>
          <td><strong>Granuladas</strong></td>
          <td> <input name="txtgranuladas2" type="text" size="10" value="<?php echo $rechazo_granuladas; ?>" ></td>
          <?php } ?>
          </tr>
          <?php 
		    $rechazo_gruesas = isset($row7['rechazo_gruesas'])?$row7['rechazo_gruesas']:"";	
			$rechazo_delgadas = isset($row7['rechazo_delgadas'])?$row7['rechazo_delgadas']:"";
			$rechazo_granuladas = isset($row7['rechazo_granuladas'])?$row7['rechazo_granuladas']:"";
		  if ($opcion == 'M')
						{ ?>
          <td colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo7</strong> 
              <?php
						echo "<input type='image' src='../principal/imagenes/ico_modif3.gif' width='29' height='24'   onClick=\"modifica('$fecha','7','".$rechazo_gruesas."','".$rechazo_delgadas."','".$rechazo_granuladas."');\" value='0' checked title='modifica los datos anteriormenta ingresados'>";
						//	echo "<input name='Radio7' type='radio'   onClick=\"modifica('$fecha','7','".$row7[rechazo_gruesas]."','".$row7[rechazo_delgadas]."','".$row7[rechazo_granuladas]."');\" value='0' checked>";
						//	echo "Modificar";
						}
						
						 ?>
            </div></td>
          </tr>
          <?php if ($opcion=='M')
			    {?>
          <td><strong>Gruesas</strong></td>
          <td><input name="txtgruesas7" type="text" size="10" value="<?php echo $rechazo_gruesas; ?>" style="text-align: center;background:grey;" readonly> 
          </td>
          <td><strong>Delgadas</strong></td>
          <td><input name="txtdelgadas7" type="text" size="10" value="<?php echo $rechazo_delgadas; ?>" style="text-align: center;background:grey;" readonly> 
          </td>
          <td><strong>Granuladas</strong></td>
          <td><input name="txtgranuladas7" type="text" size="10" value="<?php echo $rechazo_granuladas; ?>" style="text-align: center;background:grey;" readonly> 
          </td>
          <?php }
				else if ($opcion=='N')
					         { ?>
          <tr> 
            <td height="10" colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo 
                7</font></strong></div></td>
          </tr>
          <td><strong>Gruesas</strong></td>
          <td> <input name="txtgruesas7" type="text" size="10" value="<?php echo $rechazo_gruesas; ?>" ></td>
          <td><strong>Delgadas</strong></td>
          <td> <input name="txtdelgadas7" type="text" size="10" value="<?php echo $rechazo_delgadas; ?>"></td>
          <td><strong>Granuladas</strong></td>
          <td> <input name="txtgranuladas7" type="text" size="10" value="<?php echo $rechazo_granuladas; ?>" ></td>
          <?php } ?>
          </tr>
          <?php 
		  
		    $rechazo_gruesas = isset($row8['rechazo_gruesas'])?$row8['rechazo_gruesas']:"";	
			$rechazo_delgadas = isset($row8['rechazo_delgadas'])?$row8['rechazo_delgadas']:"";
			$rechazo_granuladas = isset($row8['rechazo_granuladas'])?$row8['rechazo_granuladas']:"";
																
		  if ($opcion=='M')
		         { ?>
          <tr> <strong>
            <?php if ($opcion == 'M')
						{ ?>
                            <td height="20" colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo8</strong>
                             <?php
			                 echo "<input type='image' src='../principal/imagenes/ico_modif3.gif' width='29' height='24'   onClick=\"modifica('$fecha','8','".$rechazo_gruesas."','".$rechazo_delgadas."','".$rechazo_granuladas."');\" value='0' checked title='modifica los datos anteriormenta ingresados'>";
							//echo "<input name='Radio8' type='radio'   onClick=\"modifica('$fecha','8','".$row8[rechazo_gruesas]."','".$row8[rechazo_delgadas]."','".$row8[rechazo_granuladas]."');\" value='0' checked>";
							//echo "Modificar"; 
						}
						
						?>
          </tr>
          <tr> 
            <td height="20"><strong>Gruesas</strong></td>
            <td> <input name="txtgruesas8" type="text" size="10" value="<?php echo $rechazo_gruesas; ?>" style="text-align: center;background:grey;" readonly></td>
            <td><strong>Delgadas</strong></td>
            <td><input name="txtdelgadas8" type="text" size="10" value="<?php echo $rechazo_delgadas; ?>" style="text-align: center;background:grey;" readonly> 
            </td>
            <td><strong>Granuladas</strong></td>
            <td><input name="txtgranuladas8" type="text" size="10" value="<?php echo $rechazo_granuladas; ?>" style="text-align: center;background:grey;" readonly></td>
            <?php }
			  else if ($opcion=='N')
					      { ?>
          <tr> 
            <td height="10" colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo 
                8</font></strong></div></td>
          </tr>
          <td height="20"><strong>Gruesas</strong></td>
          <td> <input name="txtgruesas8" type="text" size="10" value="<?php echo $rechazo_gruesas; ?>" ></td>
          <td><strong>Deldadas</strong></td>
          <td> <input name="txtdelgadas8" type="text" size="10" value="<?php echo $rechazo_delgadas; ?>" ></td>
          <td><strong>Granuladas</strong></td>
          <td> <input name="txtgranuladas8" type="text" size="10" value="<?php echo $rechazo_granuladas; ?>" ></td>
          <?php } ?>
         
            <?php if ($opcion=='M')
			    { ?>
				 </tr>
          <td height="10" colspan="6"><div align="center" class="ColorTabla02"><font color="#FF0000"><strong>Nuevo 
              Detalle Rechazo Mismo Dia</strong></font></div></td>
          </tr>
          <tr> 
            <td height="10" colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo1</strong></div></td>
          </tr>
          <td height="20">Gruesas</td>
          <td> <?php echo "<input name='txtgruesas12' type='text'  value='$txtgruesas12' onBlur=\"Calcula( '".$row["cod_grupo"]."' ,'".$txtgruesas12."', '".$row[rechazo_gruesas]."','G1');\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
          <td>Delgadas</td>
          <td> <?php echo "<input name='txtdelgadas12' type='text'  value='$txtdesgadas12' onBlur=\"Calcula( '".$row["cod_grupo"]."' ,'".$txtdelgadas12."', '".$row[rechazo_delgadas]."','D1' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
          <td>Granuladas</td>
          <td> <?php echo "<input name='txtgranuladas12' type='text'  value='$txtgranuladas12' onBlur=\"Calcula( '".$row["cod_grupo"]."' ,'".$txtgranuladas12."', '".$row[rechazo_granuladas]."','Gra1' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
          </tr>
          <?php } ?>
          <?php if ($opcion=='M') 
		         { ?>
          <tr> 
            <td height="20" colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo 
                2</font></strong></div></td>
          </tr>
          <td height="20">Gruesas</td>
          <td><?php echo "<input name='txtgruesas22' type='text'  value='$txtgruesas22' onBlur=\"Calcula( '".$row2["cod_grupo"]."' ,'".$txtgruesas22."', '".$row2[rechazo_gruesas]."','G2' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
          <td>Delgadas</td>
          <td><?php echo "<input name='txtdelgadas22' type='text'  value='$txtdesgadas22' onBlur=\"Calcula( '".$row2["cod_grupo"]."' ,'".$txtdelgadas22."', '".$row2[rechazo_delgadas]."','D2' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
          <td>Granuladas</td>
          <td><?php echo "<input name='txtgranuladas22' type='text'  value='$txtgranuladas22' onBlur=\"Calcula( '".$row2["cod_grupo"]."' ,'".$txtgranuladas22."', '".$row2[rechazo_granuladas]."','Gra2' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
          </tr>
          <?php } ?>
          <?php if ($opcion=='M')
			       { ?>
          <tr> 
            <td height="20" colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo 
                7</font></strong></div></td>
          </tr>
          <td height="20">Gruesas</td>
          <td><?php echo "<input name='txtgruesas72' type='text'  value='$txtgruesas72' onBlur=\"Calcula( '".$row7["cod_grupo"]."' ,'".$txtgruesas72."', '".$row7[rechazo_gruesas]."','G7' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
          <td>Delgadas</td>
          <td> <?php echo "<input name='txtdelgadas72' type='text'  value='$txtdesgadas72' onBlur=\"Calcula( '".$row7["cod_grupo"]."' ,'".$txtdelgadas72."', '".$row7[rechazo_delgadas]."','D7' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
          <td>Granuladas</td>
          <td><?php echo "<input name='txtgranuladas72' type='text'  value='$txtgranuladas72' onBlur=\"Calcula( '".$row7["cod_grupo"]."' ,'".$txtgranuladas72."', '".$row7[rechazo_granuladas]."','Gra7' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
          </tr>
          <?php } ?>
          <?php if ($opcion=='M')
		        { ?>
					  <tr> 
						<td height="10" colspan="6"><div align="center" class="ColorTabla01"><strong>Grupo 8</font></strong></div></td>
					  </tr>
					  <tr> 
						<td height="5">Gruesas</td>
						<td><?php echo "<input name='txtgruesas82' type='text'  value='$txtgruesas82' onBlur=\"Calcula( '".$row8["cod_grupo"]."' ,'".$txtgruesas82."', '".$row8[rechazo_gruesas]."','G8' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
						<td>Delgadas</td>
						<td> <?php echo "<input name='txtdelgadas82' type='text'  value='$txtdesgadas82' onBlur=\"Calcula( '".$row8["cod_grupo"]."' ,'".$txtdelgadas82."', '".$row8[rechazo_delgadas]."','D8' );\" onKeyDown='TeclaPulsada()' size='10' >";?> 
						</td>
						<td>Granuladas</td>
						<td><?php echo "<input name='txtgranuladas82' type='text'  value='$txtgranuladas82' onBlur=\"Calcula( '".$row8["cod_grupo"]."' ,'".$txtgranuladas82."', '".$row8[rechazo_granuladas]."','Gra8' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
					  </tr>
					  
					  
					  <tr> 
						<td height="10" colspan="6"><div align="center" class="ColorTabla01"><strong>Recuperado</font></strong></div></td>
					  </tr>
					  <tr> 
						<td>&nbsp;</td>
						<?php $consulta_recuperado="select ifnull(recuperado,0) as recuperado from ref_web.recuperado where fecha='".$fecha."' " ;
						   $rs_r = mysqli_query($link, $consulta_recuperado);
						   $row_r = mysqli_fetch_array($rs_r);?>
						<td><input name="txtrecuperado" type="text" size="10" value="<?php echo $row_r[recuperado] ?>" style="text-align: center;background:grey;" readonly></td>
						
            <td>&nbsp;</td>
						<td>&nbsp;</td>
						
            <td><?php echo "<input name='txtrecuperado2' type='text'  value='$txtrecuperado2' onBlur=\"Calcula( '0','".$txtgranuladas2."', '".$row_r[recuperado]."','Rec' );\" onKeyDown='TeclaPulsada()' size='10' >";?></td>
						<td>&nbsp;</td>
					 </tr>
					  
		  
          <?php } 
		  
		  
		    if ($opcion=='N')
			
			  { ?>
			          <tr> 
						<td height="10" colspan="6"><div align="center" class="ColorTabla01"><strong>Recuperado</font></strong></div></td>
					  </tr>
		            <tr> 
				    <td height="5" colspan="3">Recuperado</td>
					<?php $consulta_recuperado="select ifnull(recuperado,0) as recuperado from ref_web.recuperado where fecha='".$fecha."' " ;
					$rs_r = mysqli_query($link, $consulta_recuperado);
					$row_r = mysqli_fetch_array($rs_r);?>
					<td><input name="txtrecuperado" type="text" size="10" value="<?php echo $row_r[recuperado] ?>" ></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					 </tr>
			<?php } ?>		  
        </table>
        <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
        <br>
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
		<?php if ($opcion=='N') 
		       { ?>
			     <td align="center"><input name="btnnuevo" type="button" style="width:70" value="Nuevo" onClick="JavaScrip:Grabar2(this.form,'N')">
			<?php } 
			else if ($opcion=='M') 
			          {?> 
                         <td align="center"><input name="btngrabar" type="button" style="width:70" value="Grabar" onClick="JavaScrip:Grabar(this.form,'G')">
					   <?php } ?> 
            <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="JavaScript:Salir(this.form)"></td>
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
			
		echo 'window.opener.document.frmPrincipal.action = "detalle_hojas_madres_rechazo.php";';
		echo 'window.opener.document.frmPrincipal.submit();';
		echo 'window.close();';		
		echo '</script>';
	}
?>
</body>
</html>
<?php 	include("../principal/cerrar_sec_web.php"); ?>


