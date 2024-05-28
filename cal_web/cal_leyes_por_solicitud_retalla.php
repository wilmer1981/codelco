<?php
	include("../principal/conectar_principal.php");
	$CookieRut=$_COOKIE["CookieRut"];
	$Rut=$CookieRut;

	if(isset($_REQUEST["Opcion"])) {
		$Opcion = $_REQUEST["Opcion"];
	}else{
		$Opcion = "";
	}
	if(isset($_REQUEST["Rec"])) {
		$Rec = $_REQUEST["Rec"];
	}else{
		$Rec = "";
	}
	if(isset($_REQUEST["Sol"])) {
		$Sol = $_REQUEST["Sol"];
	}else{
		$Sol = "";
	}
	

	if ($Opcion =='3')
	{
		if ($Rec == 'N')
		{
			$Consulta ="select fecha_hora,id_muestra,rut_funcionario from cal_web.solicitud_analisis where nro_solicitud = '".$Sol."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila1=mysqli_fetch_array($Respuesta);
			$SA_Aux=$Fila1["id_muestra"].'~~'.$Fila1["fecha_hora"].'//';
			$Rut=$Fila1["rut_funcionario"];
		}
		else 
		{
			$Consulta ="select fecha_hora,id_muestra,rut_funcionario  from cal_web.solicitud_analisis where nro_solicitud = '".$Sol."' and recargo = '".$Rec."'";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila1=mysqli_fetch_array($Respuesta);
			$SA_Aux=$Fila1["id_muestra"].'~~'.$Fila1["fecha_hora"].$Rec.'//';
			$SolAut='S';
			$Rut=$Fila1["rut_funcionario"];
			$Recargo=$Rec;
		}	
	}
	else
	{
		$SA_Aux=$Valores;
	}
	$Leyes=array();
	$Impurezas=array();
	$i=0;
	$f=0;
	if (!isset($SolAut))
	{
		for ($j = 0;$j <= strlen($SA_Aux); $j++)
		{
			if (substr($SA_Aux,$j,2) == "//")
			{
				$MuestraFecha = substr($SA_Aux,0,$j);
				for ($x=0;$x<=strlen($MuestraFecha);$x++)
				{
					if (substr($MuestraFecha,$x,2) == "~~")
					{
						$Muestra = substr($SA_Aux,0,$x);			
						$Fecha = substr($SA_Aux,$x+2,19);
						$Consulta="select leyes,impurezas from cal_web.solicitud_analisis where rut_funcionario = '".$Rut."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'"; 
						$Respuesta = mysqli_query($link, $Consulta);
						$Fila=mysqli_fetch_array($Respuesta);
						$LeyesAux=$Fila[leyes];
						for ($l = 0;$l <= strlen($LeyesAux); $l++)
						{
							if (substr($LeyesAux,$l,2) == "//")
							{
								$LeyUnidad = substr($LeyesAux,0,$l);
								for ($m=0;$m<=strlen($LeyUnidad);$m++)
								{
									if (substr($LeyUnidad,$m,2) == "~~")
									{
										$Leyes[$i][0]=substr($LeyUnidad,0,$m);
										$Leyes[$i][1]=substr($LeyUnidad,$m+2);
										$i=$i+1;			
									}
								}
								$LeyesAux=substr($LeyesAux,$l+2);
								$l=0;
							}
						}
						$ImpurezasAux=$Fila[impurezas];
						for ($l = 0;$l <= strlen($ImpurezasAux); $l++)
						{
							if (substr($ImpurezasAux,$l,2) == "//")
							{
								$ImpUnidad = substr($ImpurezasAux,0,$l);
								for ($m=0;$m<=strlen($ImpUnidad);$m++)
								{
									if (substr($ImpUnidad,$m,2) == "~~")
									{
										$Impurezas[$f][0]=substr($ImpUnidad,0,$m);
										$Impurezas[$f][1]=substr($ImpUnidad,$m+2);
										$f=$f+1;
									}
								}
								$ImpurezasAux=substr($ImpurezasAux,$l+2);
								$l=0;
							}
						}
					}
				}
				$SA_Aux = substr($SA_Aux,$j + 2);
				$j = 0;
			}
		}
	}
	else
	{
		for ($j = 0;$j <= strlen($SA_Aux); $j++)
		{
			if (substr($SA_Aux,$j,2) == "//")
			{
				$MuestraFechaRecargo = substr($SA_Aux,0,$j);
				for ($x=0;$x<=strlen($MuestraFechaRecargo);$x++)
				{
					if (substr($MuestraFechaRecargo,$x,2) == "~~")
					{
						$Muestra = substr($SA_Aux,0,$x);			
						$Fecha = substr($SA_Aux,$x+2,19);
						$Recargo=substr($MuestraFechaRecargo,$x+21,strlen($MuestraFechaRecargo));
						if ($Recargo=='N')//AUTOMATICA SIN RECARGOS
						{
							$Consulta="select leyes,impurezas from cal_web.solicitud_analisis where rut_funcionario = '".$Rut."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."'"; 
							$Respuesta = mysqli_query($link, $Consulta);
							$Fila=mysqli_fetch_array($Respuesta);
							$LeyesAux=$Fila[leyes];
							for ($l = 0;$l <= strlen($LeyesAux); $l++)
							{
								if (substr($LeyesAux,$l,2) == "//")
								{
									$LeyUnidad = substr($LeyesAux,0,$l);
									for ($m=0;$m<=strlen($LeyUnidad);$m++)
									{
										if (substr($LeyUnidad,$m,2) == "~~")
										{
											$Leyes[$i][0]=substr($LeyUnidad,0,$m);
											$Leyes[$i][1]=substr($LeyUnidad,$m+2);
											$i=$i+1;			
										}
									}
									$LeyesAux=substr($LeyesAux,$l+2);
									$l=0;
								}
							}

							$ImpurezasAux=$Fila[impurezas];
							for ($l = 0;$l <= strlen($ImpurezasAux); $l++)
							{
								if (substr($ImpurezasAux,$l,2) == "//")
								{
									$ImpUnidad = substr($ImpurezasAux,0,$l);
									for ($m=0;$m<=strlen($ImpUnidad);$m++)
									{
										if (substr($ImpUnidad,$m,2) == "~~")
										{
											$Impurezas[$f][0]=substr($ImpUnidad,0,$m);
											$Impurezas[$f][1]=substr($ImpUnidad,$m+2);
											$f=$f+1;			
										}
									}
									$ImpurezasAux=substr($ImpurezasAux,$l+2);
									$l=0;
								}
							}

						}
						else//AUTOMATICA CON RECARGOS
						{
							$Consulta="select leyes,impurezas from cal_web.solicitud_analisis where rut_funcionario = '".$Rut."' and id_muestra='".$Muestra."' and fecha_hora ='".$Fecha."' and recargo='".$Recargo."'"; 
							$Respuesta = mysqli_query($link, $Consulta);
							$Fila=mysqli_fetch_array($Respuesta);
							$LeyesAux=$Fila[leyes];
							for ($l = 0;$l <= strlen($LeyesAux); $l++)
							{
								if (substr($LeyesAux,$l,2) == "//")
								{
									$LeyUnidad = substr($LeyesAux,0,$l);
									for ($m=0;$m<=strlen($LeyUnidad);$m++)
									{
										if (substr($LeyUnidad,$m,2) == "~~")
										{
											$Leyes[$i][0]=substr($LeyUnidad,0,$m);
											$Leyes[$i][1]=substr($LeyUnidad,$m+2);
											$i=$i+1;
										}
									}
									$LeyesAux=substr($LeyesAux,$l+2);
									$l=0;
								}
							}			
							$ImpurezasAux=$Fila[impurezas];
							for ($l = 0;$l <= strlen($ImpurezasAux); $l++)
							{
								if (substr($ImpurezasAux,$l,2) == "//")
								{
									$ImpUnidad = substr($ImpurezasAux,0,$l);
									for ($m=0;$m<=strlen($ImpUnidad);$m++)
									{
										if (substr($ImpUnidad,$m,2) == "~~")
										{
											$Impurezas[$f][0]=substr($ImpUnidad,0,$m);
											$Impurezas[$f][1]=substr($ImpUnidad,$m+2);
											$f=$f+1;			
										}
									}
									$ImpurezasAux=substr($ImpurezasAux,$l+2);
									$l=0;
								}
							}
						}
					}
				}
				$SA_Aux = substr($SA_Aux,$j + 2);
				$j = 0;
			}
		}				
	}
?>
<html>
<head>
<script language="JavaScript">
function activar(Opcion)
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
	
	switch (Opcion)
	{
		case "1":
		
			for (i=0;i < LargoForm;i++)
			{
				if ((frm.elements[i].name == "checkLeyes") || (frm.elements[i].name == "checkImpurezas"))
				{
					if (frm.checkTodos.checked == true)
					{
						frm.elements[i].checked = true;
						/*frm.checkLey.checked == true;
						frm.checkImp.checked == true;
						frm.checkFis.checked == true;*/
					}
					else
					{
						frm.elements[i].checked = false;
						/*frm.checkLey.checked == false;
						frm.checkImp.checked == false;
						frm.checkFis.checked == false;*/
					}
				}
			}
			break;
		case "2":
			for (i=0; i< LargoForm; i++ )
			{
				if (frm.elements[i].name == "checkLeyes")
				{
					if (frm.checkLey.checked == true)
					{
						frm.elements[i].checked = true;
					}
					else
					{
						frm.elements[i].checked = false;
					}
				}
			}
			break;
		case "3":
			for (i=0; i< LargoForm; i++ )
			{
				if (frm.elements[i].name == "checkImpurezas")
				{
					if (frm.checkImp.checked == true)
					{
						frm.elements[i].checked = true;
					}
					else
					{
						frm.elements[i].checked = false;
					}
				}
			}
			break;
	}			
}	

function Validar(valores,Personalizar,Productos,SubProducto,NombrePlantilla,CodPlantilla,Modificando,S)
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
    var checkeoLeyes=false;
	var checkeoImpurezas=false;
	var checkeoLeyesFisicas=false;
	var ValoresLeyes="";
	var ValoresImpurezas="";
	var ValoresLeyesFisicas="";
	var Unidades= "";
	
	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkLeyes") && (frm.elements[i].checked == true))
			{
			checkeoLeyes= true;
			ValoresLeyes = ValoresLeyes + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
		if ((frm.elements[i].name == "checkImpurezas") && (frm.elements[i].checked == true))
			{
			checkeoImpurezas=true;
			ValoresImpurezas = ValoresImpurezas + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
		if ((frm.elements[i].name == "checkFisicas") && (frm.elements[i].checked == true))
			{
			checkeoLeyesFisicas=true;
			ValoresLeyesFisicas = ValoresLeyesFisicas + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
	}
	if ((checkeoLeyes==false)&&(checkeoImpurezas == false)&& (checkeoLeyesFisicas == false))
	{
		alert ("Debe Seleccionar alguna Ley ");
		return;
	}
	else
	{
		if (Personalizar=='S')
		{
			frm.action="cal_leyes_por_solicitud01.php?ValoresLeyes=" + ValoresLeyes + "&ValoresImpurezas=" + ValoresImpurezas+ "&ValoresLeyesFisicas=" + ValoresLeyesFisicas+"&Personalizar=" +Personalizar+"&Productos="+Productos+"&SubProducto="+SubProducto+"&NombrePlantilla="+NombrePlantilla+"&CodPlantilla="+CodPlantilla+"&Salir="+S;
			frm.submit();				
		}
		else
		{
			frm.action="cal_leyes_por_solicitud01.php?ValoresLeyes=" + ValoresLeyes + "&ValoresImpurezas=" + ValoresImpurezas+ "&ValoresLeyesFisicas=" + ValoresLeyesFisicas+ "&Muestras=" + valores+"&Modificando="+Modificando+"&Productos="+Productos+"&SubProducto="+SubProducto+"&Salir="+S;
			frm.submit();				
		}	
	}
}	
function ValidarAux(valores,SolAut,Productos,SubProducto,BuscarDetalle,BuscarPrv,CmbRutPrv,Modificando,VolverAEsp)
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
    var checkeoLeyes=false;
	var checkeoImpurezas=false;
	var checkeoLeyesFisicas=false;
	var ValoresLeyes="";
	var ValoresImpurezas="";
	var Unidades= "";

	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkLeyes") && (frm.elements[i].checked == true))
			{
			checkeoLeyes= true;
			ValoresLeyes = ValoresLeyes + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
		if ((frm.elements[i].name == "checkImpurezas") && (frm.elements[i].checked == true))
			{
			checkeoImpurezas=true;
			ValoresImpurezas = ValoresImpurezas + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
		if ((frm.elements[i].name == "checkFisicas") && (frm.elements[i].checked == true))
			{
			checkeoLeyesFisicas=true;
			ValoresLeyesFisicas = ValoresLeyesFisicas + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
	}
	if ((checkeoLeyes==false)&&(checkeoImpurezas == false)&& (checkeoLeyesFisicas == false))
	{
		alert ("Debe Seleccionar alguna Ley ");
		return;
	}
	else
	{
		frm.action="cal_leyes_por_solicitud01.php?Muestras="+valores+"&ValoresLeyes="+ValoresLeyes+"&ValoresImpurezas="+ValoresImpurezas+"&SolAut="+SolAut+"&Productos="+Productos+"&SubProducto="+SubProducto+"&BuscarDetalle="+BuscarDetalle+"&BuscarPrv="+BuscarPrv+"&CmbRutPrv="+CmbRutPrv+"&Modificando="+Modificando+"&VolverAEsp="+VolverAEsp;
		frm.submit();				
	}
}	
function ValidarRetalla(Sol,Recargo)
{
	var frm=document.FrmIngreso;
	var LargoForm = frm.elements.length;
    var checkeoLeyes=false;
	var checkeoImpurezas=false;
	var checkeoLeyesFisicas=false;
	var ValoresLeyes="";
	var ValoresImpurezas="";
	var ValoresLeyesFisicas="";
	var Unidades= "";

	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name == "checkLeyes") && (frm.elements[i].checked == true))
			{
			checkeoLeyes= true;
			ValoresLeyes = ValoresLeyes + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
		if ((frm.elements[i].name == "checkImpurezas") && (frm.elements[i].checked == true))
			{
			checkeoImpurezas=true;
			ValoresImpurezas = ValoresImpurezas + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
		if ((frm.elements[i].name == "checkFisicas") && (frm.elements[i].checked == true))
			{
			checkeoLeyesFisicas=true;
			ValoresLeyesFisicas = ValoresLeyesFisicas + frm.elements[i].value + "~~" + frm.elements[i+1].value + "//" ;
			}
	}
	if ((checkeoLeyes==false)&&(checkeoImpurezas == false)&& (checkeoLeyesFisicas == false))
	{
		alert ("Debe Seleccionar alguna Ley ");
		return;
	}
	else
	{
		
		frm.action="cal_leyes_por_solicitud_retalla01.php?Sol="+Sol +"&Rec="+Recargo +"&ValoresLeyes="+ValoresLeyes+"&ValoresImpurezas="+ValoresImpurezas+"&ValoresLeyesFisicas="+ValoresLeyesFisicas+"&Opcion=4";
		frm.submit();				
	}
}	
</script>

<title>Seleccion de Leyes e Impurezas</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
</head>
<body><center>
<form name="FrmIngreso" method="post" action="">
<table width="600" height="228" border="0" cellpadding="5" class="tablaprincipal">
<td>
	<table width="600" border="0" cellpadding="0" class="ColorTabla01">
  	<tr>
              <td><div align="center"><strong>INGRESO DE LEYES</strong></div></td>
  	</tr>
	</table><br>
          <table width="600" border="0" cellpadding="0" class="TablaInterior">
            <tr> 
              <td width="185"><strong> 
                <input name="checkTodos" type="checkbox" onClick="JavaScript:activar('1');" value="">
                Todos </strong></td>
              <td width="381"><input name="BtnBorrar" type="SUBMIT"  value="Borrar"style="width:60">
			  	<?php
                	if ($Opcion ==3)
				{
					echo "<input name='BtnOk' type='button'  value='Ok' style='width:60' onClick=\"ValidarRetalla('$Sol','$Rec');\">";				
				}	
				else
				{	
					
					if (!isset($SolAut))
					{
						echo "<input name='BtnOk' type='button'  value='Ok' style='width:60' onClick=\"Validar('$Valores','$Personalizar','$Productos','$SubProducto','$NombrePlantilla','$CodPlantilla','$Modificando','$Salir');\">";
					}
					else
					{
						echo "<input name='BtnOk' type='button'  value='Ok' style='width:60' onClick=\"ValidarAux('$Valores','$SolAut','$Productos','$SubProducto','$BuscarDetalle','$BuscarPrv','$CmbRutPrv','$Modificando','$VolverAEsp');\">";
					}	
                }
				?>
				<input name="BtnSalir" type="Button"  value="Salir" style="width:60" onClick="JavaScript:window.close();"></td>
            </tr>
          </table><br>

	      <table width="600" height="23" border="0" class="ColorTabla01" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="29" ><div align="left"><strong> 
                  <input name="checkLey" type="checkbox" id="checkLey" onClick="JavaScript:activar('2');" value="">
                  </strong>Todos</div></td>
              <td width="251" ><div align="center">Leyes</div></td>
              <td width="163" >&nbsp;</td>
            </tr>
          </table>
          
            <?php
	  			echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
				echo "<tr>";
				$cont=1;	 
				$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes = 0 order by  t1.abreviatura";
				$Resultado = mysqli_query($link, $Consulta);
				while ($Fila =mysqli_fetch_array($Resultado))
				{
			 		if($cont==5) 
					{
						echo '</tr>';
						echo '<tr>';
						$cont=1;
			    	}
					$Encontro=false;
					reset($Leyes);
					for ($i=0;$i<count($Leyes);$i++)
					{
						if ($Fila["cod_leyes"]== $Leyes[$i][0])
						{
							$Ley=$Leyes[$i][0];
							$Unidad=$Leyes[$i][1];
							$Encontro=true;
							break;
						}					
					}
					if ($Encontro== false)
     				{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];
						echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";					
					}
					else
					{
						echo "<td width='150' align='left'><input type='checkbox' name ='checkLeyes' value='".$Fila["cod_leyes"]."' checked>".$Fila["abrev"];
						echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
					}
					echo '</td>';
					$cont =$cont+ 1;
				}
				echo "</table>";
				?>
          <br>
          <table width="600" class="ColorTabla01" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="23"><div align="left"><strong> 
                  <input name="checkImp" type="checkbox" id="checkImp" onClick="JavaScript:activar('3');" value="">
                  </strong>Todos<strong></strong></div></td>
              <td width="252"><div align="center">Impurezas</div></td>
              <td width="162">&nbsp;</td>
            </tr>
          </table>
		  
   		  <?php
			echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
			echo"<tr>";
			$cont=1;	 
			$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes = 1 order by t1.abreviatura";
			$Resultado = mysqli_query($link, $Consulta);
			while ($Fila =mysqli_fetch_array($Resultado))
			{
				if($cont==5) 
				{
					echo '</tr>';
					echo '<tr>';
					$cont=1;
				}
				$Encontro=false;
				reset($Impurezas);
				for ($i=0;$i<count($Impurezas);$i++)
				{
					if ($Fila["cod_leyes"]== $Impurezas[$i][0])
					{
						$Unidad=$Impurezas[$i][1];
						$Encontro=true;
						break;
					}					
				}
				if ($Encontro == false)
   				{
					echo "<td width='150' align='left'><input type='checkbox' name ='checkImpurezas' value='".$Fila["cod_leyes"]."'>".$Fila["abrev"];		
					echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";
				}
				else
				{
					echo "<td width='150' align='left'><input type='checkbox' name ='checkImpurezas' value='".$Fila["cod_leyes"]."' checked>".$Fila["abrev"];						
					echo "<input type ='hidden' name='TxtUnidad' value='$Unidad'>";
				}	
				echo "</td>";
				$cont =$cont+ 1;
			}
    		echo"</table>";
		 ?>
       <!--   <table width="600" class="ColorTabla01" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a">
            <tr> 
              <td width="164" height="23"><div align="left"><strong> 
                  <input name="checkFis" type="checkbox" onClick="JavaScript:activar();" value="">
                  </strong>Todos<strong></strong></div></td>
              <td width="252"><div align="center">Leyes Fisicas</div></td>
              <td width="162">&nbsp;</td>
            </tr>
          </table>-->
		  
   		  <?php
			/*echo "<table width='600' border='1' cellpadding='3' cellspacing='0' bordercolor='#b26c4a'>";
			echo"<tr>";
			$cont=1;	 
			$Consulta  = "select t1.cod_leyes,t1.tipo_leyes,t1.abreviatura as abrev,t1.cod_unidad,t2.abreviatura as abrev2 from leyes t1 inner join unidades t2 on t1.cod_unidad = t2.cod_unidad where t1.tipo_leyes =3 order by t1.abreviatura";
			$Resultado = mysqli_query($link, $Consulta);
			while ($Fila =mysqli_fetch_array($Resultado))
			{
				if($cont==5) 
				{
					echo '</tr>';
					echo '<tr>';
					$cont=1;
				}
				echo "<td width='150' align='left'><input type='checkbox' name ='checkFisicas' value='".$Fila["cod_leyes"]."'>".$Fila[abrev];		
				echo "<input type ='hidden' name='TxtUnidad' value='".$Fila["cod_unidad"]."'>";
				
				echo "</td>";
				$cont =$cont+ 1;
			}
    		echo"</table>";*/
		 ?>
		  
</td>		  
</tr>
</table>

	<p>&nbsp; </p>

</form></center>
</body>
</html>
