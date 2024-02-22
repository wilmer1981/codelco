 <?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla = 9;
	include("../principal/conectar_sec_web.php");
	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$IE=$Datos2[0];
	}
	$Rut =$CookieRut;
	$AnoActual=date("Y");
	$Fecha_Hora = date("d-m-Y h:i");
	$Opcion=0;
	if ($Mostrar=="S")
	{
		$Consulta="select * from proyecto_modernizacion.sub_clase where cod_clase='3004' and cod_subclase='".$CmbCodBulto."' ";
		$Respuesta0=mysqli_query($link, $Consulta);
		$Fila0=mysqli_fetch_array($Respuesta0);
		$CodBulto=$Fila0["nombre_subclase"];
		$Consulta = "select * from sec_web.lote_catodo";
		$Consulta.= " where  cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."'";
		$Consulta.= " and YEAR(fecha_creacion_lote) = year(now()) and cod_estado='c'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Encontro=1;
		if($Fila=mysqli_fetch_array($Respuesta))
		{
			$Mensaje2="S";
			$Consulta="select count(*) as cantidad from sec_web.lote_catodo  ";	
			$Consulta.=" where cod_bulto='".$Fila["cod_bulto"]."'	and num_bulto='".$Fila["num_bulto"]."' and cod_estado='c'		";
			$Respuesta1=mysqli_query($link, $Consulta);
			$Fila1=mysqli_fetch_array($Respuesta1);
			$Cantidad=$Fila1[cantidad];
			$Consulta="select sum(num_unidades) as suma_unidades,sum(peso_paquetes) as suma_paquetes from sec_web.lote_catodo t1 ";
			$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
			$Consulta.=" and t1.num_paquete=t2.num_paquete ";
			$Consulta.=" where cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."' and cod_estado='c'	";
			$Respuesta2=mysqli_query($link, $Consulta);
			$Fila2=mysqli_fetch_array($Respuesta2);
			$SumaUnidades=$Fila2[suma_unidades];
			$SumaPeso=$Fila2[suma_paquetes];
		}
		else
		{	
			$Consulta = "select * from sec_web.lote_catodo";
			$Consulta.= " where  cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."'";
			$Consulta.= " and YEAR(fecha_creacion_lote) = year(now()) and cod_estado='a'";
			$Respuesta1=mysqli_query($link, $Consulta);
			if  ($Fila1=mysqli_fetch_array($Respuesta1))
			{
				//$Marca=$Fila1["cod_marca"];
				$ENM=$Fila1["corr_enm"];
				$Fecha=$Fila1["fecha_creacion_lote"];
				$Consulta="select count(*) as cantidad from sec_web.lote_catodo  ";	
				$Consulta.=" where cod_bulto='".$Fila1["cod_bulto"]."'	and num_bulto='".$Fila1["num_bulto"]."' and cod_estado='a'		";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				//$Cantidad=$Fila2[cantidad];
				$Consulta="select sum(num_unidades) as suma_unidades,sum(peso_paquetes) as suma_paquetes from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where cod_bulto='".$Fila1["cod_bulto"]."' and num_bulto='".$Fila1["num_bulto"]."' and t1.cod_estado='a' and t2.cod_estado='a'	";
				$Respuesta3=mysqli_query($link, $Consulta);
				$Fila3=mysqli_fetch_array($Respuesta3);
				//$SumaUnidades=$Fila3[suma_unidades];
				//$SumaPeso=$Fila3[suma_paquetes];
			}
			else
			{
				$Consulta = "select * from sec_web.lote_catodo";
				$Consulta.= " where  cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."'";
				$Consulta.= " and YEAR(fecha_creacion_lote) = year(subdate(now(), interval 1 year)) and cod_estado='c'";
				$Respuesta4 = mysqli_query($link, $Consulta);
				if ($Fila4=mysqli_fetch_array($Respuesta4))
				{
					$Marca="";
					$ENM="";	
				}
				else
				{	
					$Consulta="select * from sec_web.lote_catodo ";
					$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and cod_estado='a'  ";
					$Respuesta5=mysqli_query($link, $Consulta);
					if ($Fila5=mysqli_fetch_array($Respuesta5))
					{
						$Marca=$Fila5["cod_marca"];
						$ENM=$Fila5["corr_enm"];
						$Consulta="select count(*) as cantidad from sec_web.lote_catodo ";
						$Consulta.=" where cod_bulto='".$CodBulto."' and num_bulto='".$NumBulto."' and cod_estado='a'  ";
						$Respuesta6=mysqli_query($link, $Consulta);
						$Fila6=mysqli_fetch_array($Respuesta6);
						$Cantidad=$Fila6[cantidad];
						$Mensaje3="S";
						$mensaje = "El Lote esta  Abierto, Del A�o ,".substr($Fila5["fecha_creacion_lote"],0,4);
						$Opcion=1;
						$Fecha=$Fila5["fecha_creacion_lote"];
					}
					if ($Opcion=="0")
					{
						$Marca=$Fila5["cod_marca"];
						$ENM=$Fila5["corr_enm"];
						$Fecha = date("Y-m-d");
					}
				}
			}
		}
	}
if ($Ver=="N")
{
	$Mes=$Mes01;
	$Mes1=$Mes02;
	$NumBulto=$NumBulto01;
	$NumPaqueteI=$NumPaqueteI01;
	$NumPaqueteF=$NumPaqueteF01;
	$Marca=$Marquita;
	$Boton="N";
}
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	if (Frm.NumPaqueteI.value=="")
	{
		alert("Debe Ingresar Paquete Inicial");
		Frm.NumPaqueteI.focus();	
		return;
	}
	if (Frm.NumPaqueteF.value=="")
	{
		alert("Debe Ingresar Paquete Final");
		Frm.NumPaqueteF.focus();	
		return;
	}
	if (Frm.Marca.value=="")
	{
		alert("Debe Ingresar Marca");
		Frm.Marca.focus();	
		return;
	}
	/*if (Frm.ENM.value=="")
	{
		alert("Debe Ingresar Ins.Embarque");
		Frm.ENM.focus();	
		return;
	}*/
	if (parseInt(Frm.NumPaqueteI.value) > parseInt(Frm.NumPaqueteF.value))
	{
		alert("El Paquete Inicial es mayor que el Paquete Final");
		Frm.NumPaqueteI.focus();	
	}
	else
	{
		Frm.action="sec_conf_inicial_lotes_ep_proceso01.php?Proceso="+Proceso+"&CodBulto="+Frm.CmbCodBulto.value+"&NumBulto="+Frm.NumBulto.value+"&CodPaqueteI="+Frm.CmbCodPaqueteI.value +"&NumPaqueteI="+Frm.NumPaqueteI.value +"&NumPaqueteF="+Frm.NumPaqueteF.value+"&Marca="+Frm.Marca.value+"&ENM="+Frm.ENM.value+"&Estado="+Frm.CmbEstado.value;
		Frm.submit();
	}
}
function Salir()
{
	var Frm=document.FrmProceso;
	window.close();
}
function Recarga(Valores)
{
	var Frm=document.FrmProceso;
		
	Frm.action="sec_conf_inicial_lotes_ep.php?CodMesI="+Frm.CmbCodPaqueteI.value + "&Cargar=S&Valores="+Valores;
	Frm.submit();
}
function Recarga2(Valores)
{
	var Frm=document.FrmProceso;
	Frm.action="sec_conf_inicial_lotes_ep.php?NumBulto="+Frm.NumBulto.value+"&Mes1="+Frm.CmbCodPaqueteI.value+"&Mes="+Frm.CmbCodBulto.value+"&Mes2="+Frm.CmbCodPaqueteF.value+"&Mostrar=S&Valores="+Valores;
	Frm.submit();
}
function MostrarPaquetes(Mos,M1,NB,M)//variables Mostrar ,Mes1,NumBulto,Mes se utilizan para devolverse a al conf inicial de lotes y no perder valorse   
{
	var Frm=document.FrmProceso;
	Frm.action="sec_detalle_paquetes_disponibles.php?Mostrar="+Mos+"&NumBulto01="+NB+"&Mes1="+M1+"&Mes="+M;
	Frm.submit();
}
function Cancelar()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_conf_inicial_lotes_ep_proceso01.php?Proceso=C";
	Frm.submit();
}
function MarcaCatodos()
{
	var Frm=document.FrmProceso;
	window.open("sec_asignar_marca.php?CmbCodBulto="+Frm.CmbCodBulto.value+"&CmbCodPaqueteI="+Frm.CmbCodPaqueteI.value+"&CmbCodPaqueteF="+Frm.CmbCodPaqueteF.value+"&NumBulto="+Frm.NumBulto.value+"&NumPaqueteI="+Frm.NumPaqueteI.value+"&NumPaqueteF="+Frm.NumPaqueteF.value,""," fullscreen=no,width=700,height=400,scrollbars=yes,resizable = yes");
}

</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmProceso" method="post" action="">
<input name="FechaO" type="hidden" value="<?php echo $Fecha; ?>">
  <table width="663" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="754"><table width="651" border="0" class="TablaInterior">
          <tr> 
            <td width="37"><font size="2">&nbsp;</td>
            <td colspan="5"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Usuario:<strong> 
              <?php
				$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from proyecto_modernizacion.funcionarios where rut = '".$Rut."'";
				$Resultado= mysqli_query($link, $Consulta);
				if ($Fila =mysqli_fetch_array($Resultado))
				{	
					echo $Rut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
				}	  
				else
				{
					$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
					$Respuesta = mysqli_query($link, $Consulta);
					if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo $CookieRut." ".ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
			
				}
			  ?>
              </strong></font></font></td>
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="3">&nbsp;</td>
            <td width="22">&nbsp; </td>
            <td width="100">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2">N&deg; Serie Inicial Lote</td>
            <td colspan="6"> <select name="CmbCodBulto">
            <?php
				if ($Mostrar!="S")
				{	
					$Mes=date("n");
					$CmbCodBulto=$Mes;		
				}
				else
				{
					$CmbCodBulto=$Mes;		
				}
				$Consulta="select * from proyecto_modernizacion.sub_clase ";
				$Consulta.=" where cod_clase='3004' and cod_subclase between 1 and 12   ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					
					if ($CmbCodBulto==$Fila["cod_subclase"])
					{
						echo "<option value=".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";	
					}
					else
					{
						echo "<option value=".$Fila["cod_subclase"].">".$Fila["nombre_subclase"]."</option>";	
					}
				}
			?>
              </select>
              - 
              <input name="NumBulto" type="text" id="NumBulto"  value="<?php echo $NumBulto; ?>" onBlur="Recarga2('<?php echo $Valores; ?>');"> 
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2">N&deg; Serie Inicial Sub -Lote</td>
            <td colspan="6"> <select name="CmbCodPaqueteI" onChange="Recarga2('<?php echo $Valores; ?>');">
             <?php
				if ($Mostrar!="S")
				{
					$Mes1=date("n");
					$CmbCodPaqueteI=$Mes1;
				}
				else
				{
					$CmbCodPaqueteI=$Mes1;
				}
				$Consulta="select * from proyecto_modernizacion.sub_clase ";
				$Consulta.=" where cod_clase='3004' and cod_subclase between 1 and 12   ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCodPaqueteI==$Fila["cod_subclase"])
					{
						echo "<option value=".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";	
					}
					else
					{
						echo "<option value=".$Fila["cod_subclase"].">".$Fila["nombre_subclase"]."</option>";	
					}
				}
		    ?>
              </select>
              - 
              <input name="NumPaqueteI" type="text" id="NumPaqueteI" value="<?php  echo $NumPaqueteI;  ?>"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2">N&deg; Serie Final Sub -Lote</td>
            <td colspan="6"><select name="CmbCodPaqueteF">
                <?php
				if ($Mostrar!="S")
				{
					$Mes1=date("n");
					$CmbCodPaqueteF=$Mes1;
					$Consulta="select * from proyecto_modernizacion.sub_clase ";
					$Consulta.=" where cod_clase='3004' and cod_subclase between 1 and 12   ";
					$Respuesta=mysqli_query($link, $Consulta);
					while($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($CmbCodPaqueteF==$Fila["cod_subclase"])
						{
							echo "<option value=".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";	
						}
						else
						{
							echo "<option value=".$Fila["cod_subclase"].">".$Fila["nombre_subclase"]."</option>";	
						}
					}
				}
				else
				{
					$CmbCodPaqueteF=$Mes1;
					
					$Consulta="select * from proyecto_modernizacion.sub_clase ";
					$Consulta.=" where cod_clase='3004' and cod_subclase='".$CmbCodPaqueteF."'    ";
					$Respuesta=mysqli_query($link, $Consulta);
					$Fila=mysqli_fetch_array($Respuesta);
					if ($CmbCodPaqueteF==$Fila["cod_subclase"])
					{
						echo "<option value=".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";	
					}
				}
				?>
              </select>
              - 
              <input name="NumPaqueteF" type="text" id="NumPaqueteF3" value="<?php   echo $NumPaqueteF;  ?>"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2">Marca</td>
            <td colspan="6"> 
              <!--<input name="Marca" type="text"  id="Marca" value="<?php  echo $Marca;  ?>"> -->
              <?php
              if ($Boton!="N")
			  {
			  	echo "<input name='Marca' type='text'  value='$Marca'>";
				echo "<input name='BtnMarca' type='button'  style='width:50'  onClick='MarcaCatodos();' value='Marca'> ";
              }
			  else
			  {
			  	echo "<input name='Marca' type='text'   value='$Marca'>";
			  }
			?>
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2">Ins.Embarque</td>
            <td colspan="6"><input name="ENM" type="text" id="ENM"   value="<?php  echo $IE;?>" readonly></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td colspan="2">Estado</td>
            <td colspan="6"> <select name="CmbEstado">
                <?php
				$Consulta="select * from proyecto_modernizacion.sub_clase";
				$Consulta.=" where cod_clase='3003' and (cod_subclase='2' or cod_subclase='4')";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					
					if ($CmbEstado == $Fila["cod_subclase"])
					{
						echo "<option value='".$Fila["valor_subclase1"]."' selected>".$Fila["nombre_subclase"]."</option>";
					}
					else
					{
						echo "<option value='".$Fila["valor_subclase1"]."'>".$Fila["nombre_subclase"]."</option>";
					}
				}
				
				?>
              </select> &nbsp; </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="90">&nbsp;</td>
            <td width="79">&nbsp; </td>
            <td colspan="3">&nbsp;</td>
            <td width="90">&nbsp;</td>
            <td width="93">&nbsp;</td>
            <td width="189">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>Total Paquetes:</td>
            <td> 
              <?php
				echo $Cantidad;
			 ?>
            </td>
            <td colspan="3">Peso Total Paquetes:</td>
            <td> 
              <?php
				echo $SumaPeso;
			?>
            </td>
            <td>Total Unidades:</td>
            <td> 
              <?php	echo $SumaUnidades; ?>
            </td>
          </tr>
        </table>
        <br>
        <table width="652" border="0" class="TablaInterior">
          <tr> 
            <td  align="center" width="745"><input name="BtnNuevo" type="button" id="BtnNuevo" style="width:60" onClick="Cancelar();" value="Nuevo">
              <?php 
			 if ($Mensaje2!="S")
			 { 
			 	 echo 	"<input type='button' name='BtnGrabar' value='Grabar' style='width:60' onClick=\"Grabar('G','$Valores');\">";
			 }
			 ?>
              <input name="BtnVer" type="button" id="BtnVer" value="Ver Paquetes" onClick="MostrarPaquetes('<?php echo $Mostrar;?>','<?php echo $Mes1; ?>','<?php echo $NumBulto; ?>','<?php echo $Mes ?>');" >
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
<?php
  		echo "<script languaje='JavaScript'>";
		echo "var frm=document.FrmProceso;";
		if ($Mensaje=='S')
		{
			echo "alert('Esta Marca no Existe');";
			echo "frm.Marca.focus();";
		}
		if ($Mensaje1=='S')
		{
			echo "alert('El SubLote Inicial No existe');";
			echo "frm.NumPaqueteI.focus();";
		}
		if ($Mensaje2=='S')
		{
			echo "alert('El Lote esta cerrado ');";
			echo "frm.BtnNuevo.focus();";
		}
		if ($Mensaje3=='S')
		{
			echo "alert('".$mensaje."');";
			echo "frm.BtnNuevo.focus();";
		}
		if ($Mensaje4=='S')
		{
			echo "alert('El SubLote Final No Existe');";
			echo "frm.NumPaqueteF.focus();";
		}		
		if ($Mensaje5 != "")
		{
			echo "alert('".$Mensaje5."');";
			echo "frm.NumPaqueteI.focus();";
		}
		if ($Mensaje6 != "")
		{
			echo "alert('".$Mensaje6."');";
			echo "frm.NumPaqueteF.focus();";
		}
		if ($EncontroIns=="0")
		{
			echo "alert('La Instruccion de embarque No Existe');";
			echo "frm.ENM.focus();";
		}
		if ($Mensaje8!="")
		{
			echo "alert('".$Mensaje8."');";
			echo "frm.ENM.focus();";
		}
		if ($Mensaje9!="")
		{
			echo "alert('".$Mensaje9."');";
			echo "frm.BtnNuevo.focus();";
		}
		if ($Mensaje10!="")
		{
			echo "alert('".$Mensaje10."');";
			echo "frm.BtnNuevo.focus();";
		}
		if ($Mensaje11!="")
		{
			echo "alert('".$Mensaje11."');";
			echo "frm.BtnNuevo.focus();";
		}
		if ($Mensaje12!="")
		{
			echo "alert('".$Mensaje12."');";
			echo "frm.ENM.focus();";
		}
		if ($ENM!="")
		{
			echo "alert('Lote Ocupado por otra Instruccion de Embarque');";
			echo "frm.BtnNuevo.focus();";
		}
		echo "</script>";
	?>
  </form>
</body>
</html>
