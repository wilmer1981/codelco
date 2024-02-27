<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =28;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	if ($Mostrar=="S")
	{
		if ($Ver=="S")
		{
			$Consulta="SELECT * from sec_web.embarque_ventana where tipo <> 'V' and ";
			$Consulta.=" num_envio='".$Envio."' and fecha_envio='".$FechaEnvio."'  and ((rut_cliente ='') or  (isnull(rut_cliente)))	";
			$Respuesta3=mysqli_query($link, $Consulta);
			if($Fila3=mysqli_fetch_array($Respuesta3))
			{
				$Consulta="SELECT * from sec_web.prestador where cod_prestador_servicio='".$Receptor."' 	";
				$Respuesta2=mysqli_query($link, $Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				$RutCliente=$Fila2["rut"];
				$DescripcionReceptor=$Fila2["nombre"];
			}
			else
			{
				$Actualizar="UPDATE sec_web.embarque_ventana set cod_estiba='".$Receptor."'  where ";
				$Actualizar.="num_envio='".$Envio."' and fecha_envio='".$FechaEnvio."'	";
				mysqli_query($link, $Actualizar);
				
			}
		}
		$Consulta="SELECT * from sec_web.embarque_ventana t1 ";
		$Consulta.=" inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto  ";
		$Consulta.=" left  join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto			 ";
		$Consulta.=" left  join sec_web.nave t4 on t1.cod_nave=t4.cod_nave			 ";
		$Consulta.=" where t1.tipo <> 'V' and t1.num_envio='".$Envio."' and YEAR(fecha_envio) = year(now()) order by fecha_embarque desc  ";
		$Consulta.="Limit 0,1";
		$Respuesta=mysqli_query($link, $Consulta);
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$FechaEnvio=$Fila["fecha_envio"];
			$FechaEmbarque=$Fila["fecha_embarque"];
			$FechaProgramacion=$Fila["fecha_programacion"];
			$Descripcion=$Fila["descripcion"];
			$DescripcionPuerto=$Fila["nom_aero_puerto"];
			$DescripcionNave=$Fila["nombre_nave"];
			$TipoEmbarque=$Fila["tipo_embarque"];
			$SwSubCliente=$Fila["cod_sub_cliente"];
			$Cliente=$Fila["rut_cliente"];
			$FechaEnvio=$Fila["fecha_envio"];
		}
		else
		{
			$Consulta="SELECT * from sec_web.embarque_ventana t1 ";
			$Consulta.=" inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta.=" left  join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto			 ";
			$Consulta.=" left  join sec_web.nave t4 on t1.cod_nave=t4.cod_nave			 ";
			$Consulta.=" where t1.tipo <> 'V' and t1.num_envio='".$Envio."' and YEAR(fecha_envio) =  year(subdate(now(), interval 1 year)) order by fecha_embarque desc  ";
			$Consulta.="Limit 0,1";
			$Respuesta=mysqli_query($link, $Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$FechaEnvio=$Fila["fecha_envio"];
			$FechaEmbarque=$Fila["fecha_embarque"];
			$FechaProgramacion=$Fila["fecha_programacion"];
			$Descripcion=$Fila["descripcion"];
			$DescripcionPuerto=$Fila["nom_aero_puerto"];
			$DescripcionNave=$Fila["nombre_nave"];
			$TipoEmbarque=$Fila["tipo_embarque"];
			$SwSubCliente=$Fila["cod_sub_cliente"];
			$Cliente=$Fila["rut_cliente"];
			$FechaEnvio=$Fila["fecha_envio"];
		}
		
		if($TipoEmbarque!="T")
		{
			if(($Fila["cod_estiba"]!="")&&($SwSubCliente!=""))
			{
				$Consulta="SELECT * from sec_web.prestador where cod_prestador_servicio='".$Fila["cod_estiba"]."'";
				$Respuesta0=mysqli_query($link, $Consulta);
				$Fila0=mysqli_fetch_array($Respuesta0);
				$RutCliente=$Fila0["rut"];
				$DescripcionReceptor=$Fila0["nombre"];
				$Receptor=$Fila["cod_estiba"];
			}
		} 
		else
		{
			if ($SwSubCliente!="")
			{
				$Consulta="SELECT * from sec_web.sub_cliente_vta ";
				$Consulta.="where cod_sub_cliente='".$Fila["cod_sub_cliente"]."' and rut_cliente='".$Fila["rut_cliente"]."'	";
				$Resp1=mysqli_query($link, $Consulta);
				$Fil1=mysqli_fetch_array($Resp1);
				$Direccion=$Fil1["direccion"];
				$Ciudad=$Fil1["ciudad"];		
				$RutCliente=$Fil1["rut_cliente"];		
				
			}
		}
		$Consulta="SELECT * from sec_web.nave where cod_nave='".$Fila["cod_cliente"]."' 	";
		$Respuesta1=mysqli_query($link, $Consulta);
		if ($Fila1=mysqli_fetch_array($Respuesta1))
		{
			$DescripcionCliente=$Fila1["nombre_nave"];
			$ClienteSantiago=$Fila1["cod_nave"];
		}
		else
		{
			$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente='".$Fila["cod_cliente"]."' 	";
			$Respuesta1=mysqli_query($link, $Consulta);
			$Fila1=mysqli_fetch_array($Respuesta1);
			$DescripcionCliente=$Fila1["nombre_cliente"];
			$ClienteSantiago=$Fila1["cod_cliente"];
		}
		
	}
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
			eval("Txt" + numero + ".style.left = 355 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4){ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}
function Salir()
{
	var Frm=document.FrmProceso;
	Frm.action= "../principal/sistemas_usuario.php?CodSistema=3";
	Frm.submit();
}
function MostrarDatos()//N� Envio
{
	var Frm=document.FrmProceso;
	var E = frm.Envio.value;
	Frm.action="sec_autorizacion_despacho.php?Mostrar=S&Envio="+E;
	Frm.submit();
}
function Recarga()//N� Envio
{
	var Frm=document.FrmProceso;
	Frm.action="sec_autorizacion_despacho.php?Mostrar=S&Envio="+Frm.Envio.value+"&Receptor="+Frm.Receptor.value+"&FechaEnvio="+Frm.FechaEnvioO.value+"&Ver=S";
	Frm.submit();
}
function Autorizar()//N� Envio
{
	var Frm=document.FrmProceso;
	var Valores="";
	for (i=1;i<Frm.checkbox.length;i++)
	{
		Valores =Valores + Frm.checkbox[i].value + "//" ;
	}
	Valores=Valores.substr(0,Valores.length-2);
	if(Frm.RutClienteO.value=="")
	{
		alert("Debe Ingresar Cliente");
		return;
	} 
	Frm.action="sec_autorizacion_despacho01.php?Envio="+Frm.Envio.value+"&TipoEmbarque="+Frm.TipoEmbarqueO.value+"&Valores="+Valores+"&RutClinte="+Frm.RutClienteO.value+"&Proceso=Autorizar";
	Frm.submit();
}

function SubCliente()
{
	var Frm=document.FrmProceso;
	window.open("sec_subcliente.php?Envio="+Frm.Envio.value+"&FechaEnvio="+Frm.FechaEnvioO.value+"&ClienteSantiago="+Frm.ClienteSantiagoO.value,""," fullscreen=no,width=750,height=400,scrollbars=yes,resizable = yes");
}
function Cancelar()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_autorizacion_despacho01.php?Proceso=Cancelar";
	Frm.submit();
}
function Detalle()
{
	var Frm=document.FrmProceso;
	var ValoresIE="";
	var Checkeo=false;
	var sw=0;
	var Envio="";
	for (i=1;i<Frm.checkbox.length;i++)
	{
		if (Frm.checkbox[i].checked==true)
		{
			ValoresIE =ValoresIE + Frm.checkbox[i].value + "//" ;
			Checkeo=true;
			sw++;
		}	
	}
	if (Checkeo==false)
	{
		alert("No Hay Elementos Seleccionados ");
	}
	else
	{
		if (sw==1)
		{
			ValoresIE=ValoresIE.substr(0,ValoresIE.length-2);
			window.open("sec_detalle_transportista.php?ValoresIE="+ValoresIE+"&Envio="+Frm.Envio.value,""," fullscreen=no,width=480,height=300,scrollbars=yes,resizable = yes");
		}
		else
		{
			alert("Debe Seleccionar solo un elemento");
		}
	}
}
function Transporte()
{
	var Frm=document.FrmProceso;
	var LargoForm =Frm.elements.length;
	var ValoresIE="";
	var Checkeo=false;
	var sw=0;
	var dir="";
	for (i=1;i<Frm.checkbox.length;i++)
	{
		if (Frm.checkbox[i].checked==true)
		{
			ValoresIE =ValoresIE + Frm.checkbox[i].value + "//" ;
			Checkeo=true;
			sw++;
		}	
	}
	if (Checkeo==false)
	{
		alert("No Hay Elementos Seleccionados ");
	}
	else
	{
		ValoresIE=ValoresIE.substr(0,ValoresIE.length-2);
		dir=Frm.DireccionO.value.replace(/�/g," "); 
		dir=Frm.DireccionO.value.replace(/#/g," "); 
		window.open("sec_transportista.php?Envio="+Frm.Envio.value+"&ValoresIE="+ValoresIE+"&FechaEnvio="+Frm.FechaEnvioO.value+"&Ciudad="+Frm.CiudadO.value+"&RutC="+Frm.RutClienteO.value+"&SubCli="+Frm.CodSubClienteO.value,""," fullscreen=no,width=790,height=400,scrollbars=yes,resizable = yes");
	}
}
function AgregarCliente()//N� Envio
{
	var Frm=document.FrmProceso;
	var Valores="";
	var TipoEmbarque="";
	window.open("sec_ing_subcliente.php?Envio="+Frm.Envio.value+"&TipoEmbarque="+Frm.TipoEmbarqueO.value+"&Valores="+Valores+"&RutCliente="+Frm.RutClienteO.value,""," fullscreen=no,width=500,height=400,scrollbars=yes,resizable = yes");
}
function AgregarReceptor()//N� Envio
{
	var Frm=document.FrmProceso;
	var Valores="";
	var TipoEmbarque="";
	window.open("sec_ing_Receptor.php?Envio="+Frm.Envio.value+"&TipoEmbarque="+Frm.TipoEmbarqueO.value+"&Valores="+Valores+"&RutCliente="+Frm.RutClienteO.value,""," fullscreen=no,width=500,height=400,scrollbars=yes,resizable = yes");
}
function ActualizaFecha()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_autorizacion_despacho01.php?Proceso=ActualizaFecha";
	Frm.submit();
}
function Lote()
{
	var Frm=document.FrmProceso;
	Frm.action="sec_autorizacion_despacho01.php?Proceso=Lote";
	Frm.submit();
}
function Imprimir()
{
	var Frm=document.FrmProceso;
	var URL = "sec_autorizacion_despacho_imp.php?Mostrar=S&Envio="+Frm.Envio.value+"&TipoEmbarque="+Frm.TipoEmbarqueO.value;
	window.open(URL,""," fullscreen=no,width=800,height=600,scrollbars=yes,resizable = yes");
}
function Eliminar()
{
	var Frm=document.FrmProceso;
	var mensaje="";
	ValoresCheck=Recuperar();
	if (ValoresCheck!="")
	{
		mensaje=confirm("�Esta Seguro de quitar la relacion ?");
		if(mensaje==true)
		{
			ValoresCheck=ValoresCheck.substr(0,ValoresCheck.length-2);
			Frm.action="sec_autorizacion_despacho01.php?ValoresCheck="+ValoresCheck+"&Proceso=EliminarRelacion";
			Frm.submit();
		}
		else
		{
			return;
		}
	}
}
function Recuperar()
{
	var Frm=document.FrmProceso;
	var Valores="";
	var Encontro=false;
	var cont=0;
	for (i=1;i<Frm.checkbox.length;i++)
	{
		
		if (Frm.checkbox[i].checked)
		{
			Valores=Valores + Frm.checkbox[i].value +"//";
			Encontro=true;
			cont++;
		}
	}
	if(Encontro==true)
	{
		//alert(Valores);
		return(Valores);
	}
	else
	{
		alert("Debe Seleccionar un Elemento");
		return(Valores);
	}
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style><body onLoad="document.FrmProceso.Envio.focus();">
<form name="FrmProceso" method="post" action="">
<input name="TipoEmbarqueO" type="hidden" value="<?php echo $TipoEmbarque  ?>">
<input name="FechaEnvioO" type="hidden" value="<?php echo $FechaEnvio  ?>">
<input name="ClienteSantiagoO" type="hidden" value="<?php echo $ClienteSantiago  ?>">
 <?php include("../principal/encabezado.php")?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td width="758"
	><table width="754" border="0" class="TablaInterior">
          <tr> 
            <td width="27"><font size="2">&nbsp; </font></td>
            <td width="68"><font size="2">N&deg; Envio</font></td>
            <td width="191"><font size="1"><font size="2"> </font></font><font size="2"> 
              <input type="text" name="Envio" size="15" value="<?php echo $Envio  ?>">
              <input name="BtnOk" type="button" id="BtnOk" value="Ok" onClick="MostrarDatos();">
              </font></td>
            <td width="113">Fecha de Embarque</td>
            <td width="96"><?php echo $FechaEmbarque ?> </td>
            <td width="123">Fecha Programacion</td>
            <td width="103"><?php echo $FechaProgramacion ?></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>Producto</td>
            <td><?php echo $Descripcion?> </td>
            <?php
			if ($TipoEmbarque!="T")
			{
				echo "<td>Receptor</td>";
				echo "<td><input type='text' name='Receptor' size='10' value='$Receptor'> </td>";
				echo "<td colspan='2'> <input name='BtnOk' type='button'  value='OK' onClick='Recarga()'>";
				echo " ".$DescripcionReceptor." </td>";
			 }
			 else
			 {
			 	if (($SW!='2')||($SwCliente==""))
				{	
					echo "<td colspan='2'> <input name='BtnOk' type='button' style=width:'70'  value='SubCliente' onClick='SubCliente()'>";
			 	}
			 }
			 ?>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>Puerto</td>
            <td><?php echo $DescripcionPuerto ?></td>
            <td>Ciudad</td>
			<?php 
				if (isset($CodSubClienteO))
				{
					echo "<input name='CiudadO' type='hidden' value='".$Ciudad."'>";
					$CiudadO=$Ciudad;
				}
				else
				{ 
					$CiudadO=$Ciudad;
					echo "<input name='CiudadO' type='hidden' value='".$Ciudad."'>";
				}
		 	 ?>
		      <td colspan="3"><?php echo $CiudadO ?></td>
			 <?php 
				if (isset($CodSubClienteO))
				{
					echo "<input name='CodSubClienteO' type='hidden' value='".$SubCliente."'>";
					$CodSubClienteO=$SubCliente;
				}
				else
				{ 
					echo "<input name='CodSubClienteO' type='hidden' value='".$CodSubClienteO."'>";
				}
		 	 ?>
			<br>
		</tr>
          <tr> 
            <td>&nbsp;</td>
            <td>Nave</td>
            <td><?php echo $DescripcionNave  ?></td>
            <td>Direccion</td>
            <?php 
				
				if (isset($DireccionO))
				{
					
					$DireccionO=$Direccion;
					echo "<input name='DireccionO' type='hidden' value='".$Direccion."'>";
					$DireccionO=$Direccion;
				}
				else
				{ 
					
					$DireccionO=$Direccion;
					echo "<input name='DireccionO' type='hidden' value='".$Direccion."'>";
				}
		 	 ?>
			<td colspan="3"><?php echo $DireccionO ?></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>Cliente</td>
            <td><?php echo $DescripcionCliente ?></td>
            <td>Rut Cliente</td>
            <?php 
				if (isset($RutClienteO))
				{
					echo "<input name='RutClienteO' type='hidden' value='".$RutCliente."'>";
					$RutClienteO=$RutCliente;
				}
				else
				{ 
					$RutClienteO=$RutCliente;
					echo "<input name='RutClienteO' type='hidden' value='".$RutCliente."'>";
				}
		 	 ?>
			<td colspan="3"><?php echo $RutClienteO  ?></td>
            
          </tr>
        </table>
		<br>
          <table width="752" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="18"><div align="left"></div></td>
            <td width="87"align="center">Lote</td>
            <td width="55" align="left"><div align="center">Ins.Emb</div></td>
			<td width="74" align="left"><div align="center">Paq.Lote</div></td>
            <td width="82"><div align="center">Peso Lote</div></td>
            <td width="163"><div align="center"></div>
              <div align="center">Marca Lote</div></td>
            <td width="22">E.L</td>
            <td width="72">Paquet Desp</td>
            <td width="122">Peso Despachado</td>
          </tr>
        </table>
		<?php
			echo "<table width='750' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			$Consulta="SELECT * from sec_web.embarque_ventana where tipo <> 'V' and num_envio='".$Envio."' and fecha_envio='".$FechaEnvio."' ";
			echo "<input name='checkbox' type='hidden'  value=>";
			$Respuesta=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>"; 
				$ClientePrograma='';
				echo "<td width='18'><input name='checkbox' type='checkbox'  value='".$Fila["corr_enm"]."'></td>";
				echo "<td width='87' align='center'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."</td>";
				$Consulta="SELECT * from sec_web.programa_enami t1  ";
				$Consulta.=" inner join sec_web.nave t2 on t1.cod_cliente=t2.cod_nave	";
				$Consulta.=" where corr_enm='".$Fila["corr_enm"]."'	";
				$Respuesta3=mysqli_query($link, $Consulta);
				if($Fila3=mysqli_fetch_array($Respuesta3))
				{
					$ClientePrograma=$Fila3["nombre_nave"];
					$Encontro=true;
				}
				else
				{
					$Consulta="SELECT * from sec_web.programa_enami t1  ";
					$Consulta.=" inner join sec_web.cliente_venta t2 on t1.cod_cliente=t2.cod_cliente	";
					$Consulta.=" where corr_enm='".$Fila["corr_enm"]."'	";
					$Respuesta4=mysqli_query($link, $Consulta);
					if($Fila4=mysqli_fetch_array($Respuesta4))
					{
						$ClientePrograma=$Fila4["sigla_cliente"];
						$Encontro=true;
					}
				}
				$Consulta="SELECT * from sec_web.programa_codelco t1  ";
				$Consulta.=" inner join sec_web.nave t2 on t1.cod_cliente=t2.cod_nave	";
				$Consulta.=" where corr_codelco='".$Fila["corr_enm"]."'	";
				$Respuesta3=mysqli_query($link, $Consulta);
				if($Fila3=mysqli_fetch_array($Respuesta3))
				{
					$ClientePrograma=$Fila3["nombre_nave"];
					$Encontro=true;
				}
				else
				{
					$Consulta="SELECT * from sec_web.programa_codelco t1  ";
					$Consulta.=" inner join sec_web.cliente_venta t2 on t1.cod_cliente=t2.cod_cliente	";
					$Consulta.=" where corr_codelco='".$Fila["corr_enm"]."'	";
					$Respuesta4=mysqli_query($link, $Consulta);
					if($Fila4=mysqli_fetch_array($Respuesta4))
					{
						$ClientePrograma=$Fila4["sigla_cliente"];
						$Encontro=true;
					}
				}
				if($Encontro==true)
				{
					$Cont2++;
					echo "<td width='55' onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");' style=background:#CCCCCC>";
					echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:350px'>\n";
					echo "<font face='courier' color='#000000' size=1><b>Cliente: </b>".$ClientePrograma."</font><br>";
					echo "</div>".$Fila["corr_enm"]."&nbsp;</td>";
				}
				else
				{
					echo "<td width='55'>".$Fila["corr_enm"]."</td>";					
				}
				echo "<td width='74'>".$Fila["bulto_paquetes"]."</td>";
				echo "<td width='82' align='center'>".$Fila["bulto_peso"]."&nbsp;</td>";
				$Consulta="SELECT distinct t1.cod_marca,t2.descripcion from sec_web.lote_catodo t1 ";
				$Consulta.="inner join sec_web.marca_catodos t2 on t1.cod_marca=t2.cod_marca ";
				$Consulta.=" where corr_enm='".$Fila["corr_enm"]."' and cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'	";
				$Respuesta4=mysqli_query($link, $Consulta);
				$Fila4=mysqli_fetch_array($Respuesta4);
				echo "<td width='163' align='center'>".$Fila4["descripcion"]."&nbsp;</td>";
				echo "<td width='22' align='center'>".$Fila[cod_confirmado]."&nbsp;</td>";
				echo "<td width='72' align='center'>".$Fila["despacho_paquetes"]."&nbsp;</td>";
				echo "<td width='122' align='center'>".$Fila["despacho_peso"]."&nbsp;</td>";
				echo "</tr>";
				$SumaPaquetesEnvio=$SumaPaquetesEnvio+$Fila["bulto_paquetes"];
				$SumaPesoLoteEnvio=$SumaPesoLoteEnvio+$Fila["bulto_peso"];
				$SumaPaquetesDespachados=$SumaPaquetesDespachados+$Fila["despacho_paquetes"];
				$SumaPesoLoteDespachados=$SumaPesoLoteDespachados+$Fila["despacho_peso"];
				$Encontro=false;
			}
			echo "</table>";	
		?>
		
		
		
        <br>
        <table width="751" border="0" class="TablaInterior">
          <tr> 
            <td  align="center" width="169"><div align="left">Total Paquetes Envio: 
              </div></td>
            <td  align="center" width="170"> <div align="left"><?php echo $SumaPaquetesEnvio;  ?></div></td>
            <td  align="center" width="136"><div align="left">Total Peso Envio</div></td>
            <td  align="left" width="255"><?php echo $SumaPesoLoteEnvio ?></td>
          </tr>
          <tr> 
            <td  align="center"><div align="left">Total Paquetes Despachados</div></td>
            <td  align="left"><?php echo $SumaPaquetesDespachados ?></td>
            <td  align="center"><div align="left">Total Peso Despachado</div></td>
            <td  align="left"><?php echo $SumaPesoLoteDespachados ?></td>
          </tr>
        </table> 
        <br>
        <table width="751" border="0" class="TablaInterior">
          <tr> 
            <td  align="center" width="198"><div align="left"></div></td>
            <td  align="center" width="540"><div align="left"> 
                <?php
			  // if ($TipoEmbarque=="T")
			  // {
				 
				  if (($SW!='2')&&($SwSubCliente==""))
					{ 
						$Consulta="SELECT corr_enm from sec_web.embarque_ventana where tipo <> 'V' and num_envio='".$Envio."' and fecha_envio='".$FechaEnvio."'  ";
						$Respuesta=mysqli_query($link, $Consulta);
						$Encontro=false;
						while($Fila=mysqli_fetch_array($Respuesta))
						{
							$Consulta="SELECT * from sec_web.relacion_transporte_inst_embarque where corr_enm='".$Fila["corr_enm"]."'";
							$Respuesta1=mysqli_query($link, $Consulta);
							if ($Fila1=mysqli_fetch_array($Respuesta1))
							{
								$Encontro=true;
							}
							else
							{
								$Encontro=false;
							}
						}
						 if ($Encontro==true)
						 {
							 echo "<input name='BtnAutorizar' type='button'  style='width:60' value='Autorizar' onClick='Autorizar();' >&nbsp;";
						 }
					}	
						 echo "<input name='BtnTransporte' type='button'  style='width:70' value='Transporte' onClick='Transporte();'>&nbsp;";
					
			   	if ($TipoEmbarque=="T")
				{
					echo "<input name='BtnDetalle' type='button'  value='Detalle' style='width:60px;' onClick='Detalle();'>";
					echo "<input name='BtnNuevo' type='button' style='width:75px;' onClick='AgregarCliente();'  value='Mantenedor'>";
              	}
				else
				{
					echo "<input name='BtnDetalle' type='button'  value='Detalle' style='width:60px;' onClick='Detalle();'>";
					echo "<input name='BtnNuevo' type='button' style='width:75px;' onClick='AgregarReceptor();'  value='Mantenedor'>";
				}	
				?>
                <input name="BtnEliminar" type="button"  value="Eliminar" style="width:60px;" onClick="Eliminar('');">
				<input name="BtnCancelar" type="button" id="BtnCancelar" value="Cancelar" style="width:60px;" onClick="Cancelar('');">
                <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
                <!-- <input type="button" name="BtnSalir2" value="Fecha" style="width:60" onClick="ActualizaFecha();">-->
               <!-- <input type="button" name="BtnSalir2" value="Proceso" style="width:60" onClick="Lote();">-->
               <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:60px;" onClick="Imprimir();">
              </div></td>
          </tr>
        </table></td>
  </tr>
</table>
 <?php include("../principal/pie_pagina.php");
 
  		echo "<script languaje='JavaScript'>";
		echo "var frm=document.FrmProceso;";
		if ($Mensaje!='')
		{
			echo "alert('".$Mensaje."');";
		}
		if ($Mensaje2=='S')
		{
			echo "alert('El Envio ha sido Autorizado');";
		}
		echo "</script>"
  
  ?>
</form>
</body>
</html>
