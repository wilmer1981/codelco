<?php 

	$Dia = $_REQUEST["Dia"];
	$Mes = $_REQUEST["Mes"];
	$Ano = $_REQUEST["Ano"];
	$Mensaje2 = $_REQUEST["Mensaje2"];
	$Ver = $_REQUEST["Ver"];
	$Valores = $_REQUEST["Valores"];

	$CmbDias = $_REQUEST["CmbDias"];
	$CmbMes = $_REQUEST["CmbMes"];
	$CmbAno = $_REQUEST["CmbAno"];


	if ($Ver=="S")
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmConfEnvio.action='sec_seleccion_num_envio_despacho.php?Dia=".$Dia."&Mes=".$Mes."&Ano=".$Ano."&Mensaje2=".$Mensaje2."&Envio=N';";
		echo "window.opener.document.FrmConfEnvio.submit();";
		echo "window.close();";
		echo "</script>";
	
	}
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 12;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

	$Datos=explode('//',$Valores);
	foreach($Datos as $Clave => $Valor)
	{
		$Datos2=explode('~~',$Valor);
		$FechaProgramada=$Datos2[0];
		$CodNave=$Datos2[1];
		$NombreNave=$Datos2[2];
		$CodAgAduanero=$Datos2[3];
		$CodAgEstiva=$Datos2[4];
		$FechaSantiago=$Datos2[5];
		$FechaEmbarqueVen=$Datos2[6];
		$CodServicio=$Datos2[7];
		$Consulta="SELECT nombre from sec_web.prestador where cod_prestador_servicio='".$CodAgAduanero."'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$NombreAgAduanero=$Fila["nombre"];
		$Consulta="SELECT nombre from sec_web.prestador where cod_prestador_servicio='".$CodAgEstiva."'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$NombreAgEstiva=$Fila["nombre"];
		$Consulta="SELECT nombre from sec_web.prestador where cod_prestador_servicio='".$CodServicio."'";
		$Respuesta=mysqli_query($link, $Consulta);
		$Fila=mysqli_fetch_array($Respuesta);
		$NombreAcopio=$Fila["nombre"];
	}

	$Consulta = "SELECT ifnull(max(num_envio),0) as NroMayor from sec_web.embarque_ventana  ";
	$Consulta.=" where YEAR(fecha_envio) = year(now()) and tipo <> 'V'	";
	$Respuesta=mysqli_query($link, $Consulta);
	$Fila=mysqli_fetch_array($Respuesta);
	$NumEnvio=$Fila[NroMayor]+1;			
?>
<html>
<head>
<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 100 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4) 
		{
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function RecuperarValores()
{
	var Frm=document.FrmConfEnvio;
	var Valores=new String();
	var Grabar ="";
	
	Grabar="S";
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		if (Frm.TxtDisp[i].value=='T')
		{
			Valores=Valores + Frm.OptSeleccionar[i].value +"//";
		}
		/*else
		{
			alert("Una o Mas Instrucciones no estan Disponibles");
			Valores="";
			return(Valores);	
		}*/	
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		Valores="";
		return(Valores);	
	}	
} 
function RecuperarValores2()
{
	var Frm=document.FrmConfEnvio;
	var Valores=new String();
	
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		if ((Frm.OptSeleccionar[i].checked==true)&&(Frm.TxtDisp[i].value==''))
		{
			Valores=Valores + Frm.OptSeleccionar[i].value +"//";
		}
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		Valores="";
		return(Valores);	
	}	
} 
function RecuperarValores3()
{
	var Frm=document.FrmConfEnvio;
	var Valores=new String();
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		if (Frm.OptSeleccionar[i].checked==true)
		{
			Valores=Valores + Frm.OptSeleccionar[i].value +"//";
		}
	}
	if (Valores!='')
	{
		Valores=Valores.substr(0,Valores.length-2);
		return(Valores);	
	}
	else
	{
		Valores="";
		return(Valores);	
	}	
} 

function Modificar()
{
	var Frm=document.FrmConfEnvio;
	var Valores="";
	
	Valores=RecuperarValores2();	
	if (Valores!="")
	{
		window.open("sec_conf_inicial_lotes_ep.php?Valores="+Valores,""," fullscreen=no,left=50,top=130,width=680,height=300,scrollbars=no,resizable = no");
	}	
}
function Recarga(Valores,CmbDias,CmbMes,CmbAno)
{
	var Frm=document.FrmConfEnvio;
	
	Frm.action="sec_confirmacion_num_envio.php?Buscar=S&Valores="+Valores+"&CmbDias="+CmbDias+"&CmbMes="+CmbMes+"&CmbAno="+CmbAno;	
	Frm.submit();
}
function Eliminar(Valores2)
{
	var Frm=document.FrmConfEnvio;
	var Valores="";
	var Resp ="";
	
	Resp=confirm('Esta Seguro de Quitar la Relacion IE Con el Lote');
	if (Resp==true)
	{
		Valores=RecuperarValores3();	
		if (Valores!="")
		{
			Frm.action="sec_confirmacion_num_envio01.php?Proceso=E&Valores="+Valores+"&Valores2="+Valores2;
			Frm.submit();
		}
	}		
}

function Grabar(Proceso,CmbDias,CmbMes,CmbAno)
{
	var Frm=document.FrmConfEnvio;
	var Valores="";

	if (Frm.TxtNumEnvio.value=='')
	{
		alert("Debe Ingresar Numero de Envio");
		Frm.TxtNumEnvio.focus();
		return;
	}
	if (Frm.CmbTipoProducto.value=='')
	{
		alert("Debe Seleccionar Producto");
		Frm.CmbTipoProducto.focus();
		return;
	}
	if (Frm.CmbTipoEmb.value=='-1')
	{
		alert("Debe Seleccionar Tipo Embarque");
		Frm.CmbTipoEmb.focus();
		return;
	}
	Valores=RecuperarValores()
	if (Valores!='')
	{
		Frm.action="sec_confirmacion_num_envio01.php?Proceso="+Proceso+"&TxtNumEnvio="+Frm.TxtNumEnvio.value+"&Valores="+Valores+"&CmbDias="+CmbDias+"&CmbMes="+CmbMes+"&CmbAno="+CmbAno;
		Frm.submit();
	}	
}

function Salir()
{
	var Frm=document.FrmConfEnvio;
	window.close();
}
function Asignar(dia,mes,ano)
{
	var Frm=document.FrmConfEnvio;
	var Instruccion="";
	Encontro=false;
	
	if (Frm.CmbTipoProducto.value=='-1')
	{
		alert('Debe Selecionar Producto');
		Frm.CmbTipoProducto.focus();
		return;
	}
	for (i=1;i<Frm.OptSeleccionar.length;i++)
	{
		if (Frm.OptSeleccionar[i].checked==true)
		{
			Instruccion=Instruccion + Frm.InsE[i].value;
			Encontro=true;
		}
	}
	if(Encontro==true)
	{
		window.open("sec_confirmacion_asignar_num_envio_enm.php?Instruccion="+Instruccion+"&Dia="+dia+"&Mes="+mes+"&Ano="+ano,"","top=195,left=180,fullscreen=no,width=430,height=180,scrollbars=yes,resizable = yes");
	}
	else
	{
		alert("Debe Seleccionar un elemento");
	}
}
</script>
<title>Confirmacion N� Envio</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConfEnvio" method="post" action="">
  <table width="760" height="350" border="0" class="TablaPrincipal" left="5" cellpadding="5" cellspacing="0">
    <tr>
      <td align="center"><br>
	  <div style="position:absolute; left: 15px; top: 25px; width: 750px; height: 140px; OVERFLOW: auto;" id="div2"> 
      <table width="730" border="1" cellpadding="2" cellspacing="0" class="tablainterior">
	  <?php
			echo "<tr>";
			echo "<td align='left'>N� ENVIO</td>";
			echo "<td align='left'><input type='text' name='TxtNumEnvio' style='width:50' maxlength='6' value='$NumEnvio' readonly>&nbsp;&nbsp;";
			echo "<SELECT name='CmbTipoProducto' style='width:300' onchange=\"Recarga('$Valores','$CmbDias','$CmbMes','$CmbAno');\">";
			echo "<option value='-1' SELECTed>Seleccionar</option>";
			$Consulta="SELECT t1.cod_producto,t1.cod_subproducto,t2.descripcion as producto,t3.descripcion as subproducto from sec_web.programa_enami t1";			
			$Consulta=$Consulta." left join proyecto_modernizacion.productos t2 on t1.cod_producto=t2.cod_producto ";
			$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t3 on t1.cod_producto=t3.cod_producto and t1.cod_subproducto=t3.cod_subproducto ";
			$Consulta=$Consulta." where t1.estado2 <> 'C' and eta_programada='".$FechaProgramada."' and cod_nave=".$CodNave." group by cod_producto,cod_subproducto";
			$Respuesta=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbTipoProducto==$Fila["cod_producto"]."~~".$Fila["cod_subproducto"])
				{
					echo "<option value='".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."' SELECTed>".$Fila["producto"]."-".$Fila["subproducto"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."'>".$Fila["producto"]."-".$Fila["subproducto"]."</option>";				
				}	
			}
			echo "</SELECT></td>";
			echo "<td align='left'>Acopio/Est/Terr(A/E/T)</td>";
			echo "<td align='left'>";
			echo "<SELECT name='CmbTipoEmb' style='width:90'>";
			echo "<option value='-1' SELECTed>Seleccionar</option>";
			echo "<option value='A'>Acopio</option>";
			echo "<option value='E'>Estiba</option>";
			echo "<option value='T'>Terreste</option>";		
			echo "</SELECT></td>";
			echo "</tr>";
			echo "<td align='left'>NAVE/CLIENTE</td>";
			echo "<td align='left' class='colortabla02'>$NombreNave&nbsp;</td>";
			echo "<td align='left'>Fecha Programa Stgo.</td>";
			echo "<td align='left' class='colortabla02'>$FechaSantiago</td>";
			echo "</tr>";
			echo "<td align='left'>Agencia Estiba</td>";
			echo "<td align='left' class='colortabla02'>$NombreAgEstiva&nbsp;</td>";
			echo "<td align='left'>Fecha Embarque Ventanas</td>";
			echo "<td align='left' class='colortabla02'>$FechaEmbarqueVen</td>";
			echo "</tr>";
			echo "<td align='left'>Agente Aduanero</td>";
			echo "<td align='left' class='colortabla02'>$NombreAgAduanero&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
			echo "<td align='left'>Agente Acopio</td>";
			echo "<td align='left' class='colortabla02'>$NombreAcopio&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
  ?>
	  </table></div>
	  <br>
	  <div style="position:absolute; left: 15px; top: 150px; width: 750px; height: 250px; OVERFLOW: auto;" id="div2">
	  <table width="730" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01">
			<td width='20' align="center">&nbsp;</td>
			<td width='130' align="center">Cliente</td>
			<td width='130' align="right">Pto.Destino</td>
			<td width='90' align="center">I.E</td>
			<td width='70' align="center">N� Lote</td>
			<td width='80' align="center">Programa</td>
			<td width='70' align="center">Peso Lote</td>
			<td width='60' align="center">Paq.Lote</td>
			<td width='180' align="center">Marca</td>
          </tr>
        </table></div>
		<div style="position:absolute; left: 15px; top: 170px; width: 750px; height: 255px; OVERFLOW: auto;" id="div2"> 
          <?php
			echo "<table width='730' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			//CONSULTA TABLA PROGRAMA ENAMI
			if ($Buscar=='S')
			{
				$Datos=explode('~~',$CmbTipoProducto);
				$CodProducto=$Datos[0];
				$CodSubProducto=$Datos[1];
				$Consulta="SELECT t1.cod_nave,t1.mes_cuota,t1.cod_contrato,fecha_disponible,t1.estado1,t1.estado2,t6.descripcion as producto,";
				$Consulta=$Consulta."t2.descripcion as subproducto,t3.nom_aero_puerto as pto_emb,t4.nom_aero_puerto as pto_destino,";
				$Consulta=$Consulta."t5.sigla_cliente,t1.eta_programada,t1.corr_enm,t1.cantidad_embarque,t1.num_prog_loteo,";
				$Consulta=$Consulta."t1.cod_producto,t1.cod_subproducto,t1.cod_cliente,t1.cod_puerto,cod_prestador_servicio,cod_prestador_servicio2,cod_servicio,";
				$Consulta=$Consulta."t1.num_viaje";
				$Consulta=$Consulta." from sec_web.programa_enami t1";
				$Consulta=$Consulta." left join proyecto_modernizacion.productos t6 on t1.cod_producto=t6.cod_producto ";
				$Consulta=$Consulta." left join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
				$Consulta=$Consulta." left join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto ";
				$Consulta=$Consulta." left join sec_web.puertos t4 on t1.cod_puerto_destino=t4.cod_puerto ";
				$Consulta=$Consulta." left join sec_web.cliente_venta t5 on t1.cod_cliente=t5.cod_cliente ";
				$Consulta=$Consulta." where t1.estado2 = 'T' and t1.eta_programada='".$FechaProgramada."' and t1.cod_nave='".$CodNave."' and t1.cod_producto='".$CodProducto."' and t1.cod_subproducto='".$CodSubProducto."'";
				$Resultado=mysqli_query($link, $Consulta);
				echo "<input type='hidden' name='OptSeleccionar'><input type='hidden' name='TxtDisp' ><input type='hidden' name='InsE' >";
				while ($Fila=mysqli_fetch_array($Resultado))
				{
					if ($Fila[estado1]=='R')//SE PREGUNTA SI ESTA RELACIONADO EL LOTE CON IE
					{
						$Consulta="SELECT t1.disponibilidad,t1.cod_estado,t3.descripcion as marca,t1.cod_bulto,t1.num_bulto,";
						$Consulta=$Consulta."sum(t2.peso_paquetes) as peso_preparado,sum(t1.num_paquete) as unidades,t1.cod_marca";
						$Consulta=$Consulta." from sec_web.lote_catodo t1 inner join sec_web.paquete_catodo t2 on ";
						$Consulta=$Consulta." t1.cod_paquete=t2.cod_paquete and t1.num_paquete =t2.num_paquete ";
						$Consulta=$Consulta." left join sec_web.marca_catodos t3 on t1.cod_marca=t3.cod_marca ";
						$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_enm"]." and t1.cod_estado='a' and t2.cod_estado='a' group by t1.corr_enm";
						//$Consulta=$Consulta." where t1.corr_enm=".$Fila["corr_enm"]." group by t1.corr_enm";
						$Respuesta2=mysqli_query($link, $Consulta);
						$Fila2=mysqli_fetch_array($Respuesta2);
						if (($Fila2["cod_bulto"]== "") || ($Fila2["num_bulto"]== ""))
							{
								$Mensaje3="Inst.Embarque No Asignada a Ningun Lote";
							}
								else
							{	
							$Consulta="SELECT count(*) as cantpaquetes from sec_web.lote_catodo";
							$Consulta=$Consulta." where cod_bulto='".$Fila2["cod_bulto"]."' and num_bulto=".$Fila2["num_bulto"]." and corr_enm=".$Fila["corr_enm"]." and cod_estado='a'";
							$Respuesta3=mysqli_query($link, $Consulta);
							$Fila3=mysqli_fetch_array($Respuesta3);
						    }
						$Consultap="SELECT * from sec_web.embarque_ventana where corr_enm ='".$Fila["corr_enm"]."'";
						$Respuestap=mysqli_query($link, $Consultap);
						$Filap=mysqli_fetch_array($Respuestap);
						if ($Filap["num_envio"]!="")
							{
								$Mensaje4="Inst.Embarque Con N� de Envio ".$Filap["num_envio"].", ya Asignado";
							}	
						
					}	
					$MostrarBoton=true;
					echo "<tr>"; 
					$Cont2++;
					$Campos=$Fila["corr_enm"]."~~".$Fila2["cod_bulto"]."~~".$Fila2["num_bulto"]."~~".$Fila["eta_programada"]."~~";
					$Campos=$Campos.$Fila["fecha_disponible"]."~~".$Fila2["peso_preparado"]."~~".$Fila3["cantpaquetes"]."~~";
					$Campos=$Campos.$Fila2["cod_marca"]."~~".$Fila["cod_producto"]."~~".$Fila["cod_subproducto"]."~~".$Fila["cod_cliente"]."~~";
					$Campos=$Campos.$Fila["cod_puerto"]."~~".$Fila["cod_prestador_servicio"]."~~".$Fila[cod_prestador_servicio2]."~~".$Fila["cod_servicio"]."~~";
					$Campos=$Campos.$Fila["cod_nave"]."~~".$Fila[num_viaje];
					echo "<td width='20'align='center'><input type='radio' name='OptSeleccionar' value='".$Campos."'><input type='hidden' name='TxtDisp' value='".substr($Fila2["disponibilidad"],0,1)."'><input type='hidden' name='InsE' value='".$Fila["corr_enm"]."'></td>"; 
					echo "<td width='150'>".$Fila["sigla_cliente"]."&nbsp;</td>";
					echo "<td width='100'>".$Fila["pto_destino"]."&nbsp;</td>";
					echo "<td width='40' onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' bgcolor='#cccccc'>";
					echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:550px'>\n";
					echo "<font face='courier' color='#000000' size=1><b>Producto:&nbsp;</b>".$Fila["producto"]."&nbsp;<b>Sub-Producto:&nbsp;</b>".$Fila["subproducto"]." </font><br>";
					echo "<font face='courier' color='#000000' size=1><b>Puerto Embarque: </b>".$Fila["pto_emb"]."&nbsp;<b>Contrato: </b>".$Fila["cod_contrato"]."&nbsp;<b>Cuota: </b>".$Fila["mes_cuota"]."</font><br>";
					echo "<font face='courier' color='#000000' size=1><b>Disponibilidad: </b>".$Fila2["disponibilidad"]."</font><br>";
					echo "</div>".$Fila["corr_enm"]."&nbsp;</td>";
					echo "<td width='60' align='right'>".$Fila2["cod_bulto"]."-".$Fila2["num_bulto"]."&nbsp;</td>";
					echo "<td width='90' align='right'>".$Fila[eta_programada]."&nbsp;</td>";				
					echo "<td width='60' align='right'>".$Fila2["peso_preparado"]."&nbsp;</td>";
					echo "<td width='60' align='right'>".$Fila3["cantpaquetes"]."&nbsp;</td>";
					echo "<td width='160' align='left'>".$Fila2["marca"]."&nbsp;</td>";
					$Fila2["cod_bulto"]="";
					$Fila2["num_bulto"]="";
					$Fila2["peso_preparado"]="";
					$Fila3["cantpaquetes"]="";
					$Fila2["marca"]="";
					$Fila2["disponibilidad"]="";
					echo "</tr>";
				}
				echo "</table>";
			}		
		?>
          
        </div>
        <br>
		<div style="position:absolute; left: 15px; top: 365px; width: 750px; height: 40px; OVERFLOW: auto;" id="div2"> 
          <table width="730" border="0" class="tablainterior">
          <tr>
              <td align="center">
				<!--<input type="button" name="BtnEliminar" value="Elim.Relacion " style="width:90" onClick="Eliminar('<?php echo $Valores; ?>');">-->
			  	<input type="button" name="BtnGrabar" value="Grabar" style="width:90" onClick="Grabar('G','<?php echo $CmbDias;?>','<?php echo $CmbMes;?>','<?php echo $CmbAno;?>');">
                <input type="button" name="BtnSalir" value="Salir" style="width:90" onClick="Salir();">
           		<input name='BtnAsignar' type='button' style='width:90' onClick="Asignar('<?php echo $CmbDias;?>','<?php echo $CmbMes;?>','<?php echo $CmbAno;?>');" value='Asignar'>		
				<!--<input name='BtnAsignar' type='button' style='width:90' onClick="Asignar('<?php echo $FechaProgramada ?>','<?php echo $CodNave  ?>','<?php echo $CodProducto ?>','<?php echo $CodSubProducto ?>');" value='Asignar'>-->
		      </td>
          </tr>
        </table></div><br></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
	if (isset($EncontroRelacion))
	{
		if ($EncontroRelacion==true)
		{
			echo "<script languaje='javascript'>";
			echo "alert('Uno o mas Elementos no fueron eliminados por tener grupos asociados');";	
			echo "</script>";
		}
	}
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."');";	
		echo "</script>";
	}
	if (isset($Mensaje3))
		{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje3."');";	
		echo "window.opener.document.FrmConfEnvio.action='sec_seleccion_num_envio_despacho.php?Mensaje=".$Mensaje3."&Envio=N';";
		echo "window.opener.document.FrmConfEnvio.submit();";
		echo "window.close();";
		echo "</script>";
		break;
	}
		if (isset($Mensaje4))
		{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje4."');";	
		echo "window.opener.document.FrmConfEnvio.action='sec_seleccion_num_envio_despacho.php?Mensaje=".$Mensaje4."&Envio=N';";
		echo "window.opener.document.FrmConfEnvio.submit();";
		echo "window.close();";
		echo "</script>";
		break;
	}

?>
