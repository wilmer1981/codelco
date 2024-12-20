<?php 	
 	$CodigoDeSistema = 3;
	$CodigoDePantalla =28;
	include("../principal/conectar_sec_web.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$CookieRut = $_COOKIE['CookieRut'];
	$Rut =$CookieRut;
	$Fecha_Hora = date("d-m-Y h:i");
	$Fecha1 = date("Y-m-d");
	$Fecha2 = date("Y-m-d", mktime(1,0,0,intval(substr($Fecha1, 5, 2)) - 9,intval(substr($Fecha1, 8, 2)),intval(substr($Fecha1, 0, 4))));
	
	$Envio   = isset($_REQUEST["Envio"])?$_REQUEST["Envio"]:"";
	$Mostrar   = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";
	$Ver          = isset($_REQUEST["Ver"])?$_REQUEST["Ver"]:"";
	$FechaEnvio   = isset($_REQUEST["FechaEnvio"])?$_REQUEST["FechaEnvio"]:"";
	$Receptor   = isset($_REQUEST["Receptor"])?$_REQUEST["Receptor"]:"";
	$TipoEmbarque  = isset($_REQUEST["TipoEmbarque"])?$_REQUEST["TipoEmbarque"]:"";
	
	$DireccionO = isset($_REQUEST["DireccionO"])?$_REQUEST["DireccionO"]:"";
	$RutClienteO  = isset($_REQUEST["RutClienteO"])?$_REQUEST["RutClienteO"]:"";
	$CodSubClienteO  = isset($_REQUEST["CodSubClienteO"])?$_REQUEST["CodSubClienteO"]:"";

	$RutCliente  = isset($_REQUEST["RutCliente"])?$_REQUEST["RutCliente"]:"";
	$Ciudad  = isset($_REQUEST["Ciudad"])?$_REQUEST["Ciudad"]:"";
	$Direccion = isset($_REQUEST["Direccion"])?$_REQUEST["Direccion"]:"";
	$Receptor     = isset($_REQUEST["Receptor"])?$_REQUEST["Receptor"]:"";
	$DescripcionReceptor     = isset($_REQUEST["DescripcionReceptor"])?$_REQUEST["DescripcionReceptor"]:"";
	if ($Mostrar=="S")
	{
		if ($Ver=="S")
		{
			$Consulta="select * from sec_web.embarque_ventana where ";
			$Consulta.=" num_envio='".$Envio."' and tipo <> 'V' and fecha_envio='".$FechaEnvio."'  and ((rut_cliente ='') or  (isnull(rut_cliente)))	";
			$Respuesta3=mysqli_query($link,$Consulta);
			if($Fila3=mysqli_fetch_array($Respuesta3))
			{
				$Consulta="select * from sec_web.prestador where cod_prestador_servicio='".$Receptor."' 	";
				$Respuesta2=mysqli_query($link,$Consulta);
				$Fila2=mysqli_fetch_array($Respuesta2);
				$RutCliente=$Fila2["rut"];
				$DescripcionReceptor=$Fila2["nombre"];
			}
			else
			{
				$Actualizar="update sec_web.embarque_ventana set cod_estiba='".$Receptor."'  where ";
				$Actualizar.="num_envio='".$Envio."' and tipo <> 'V' and fecha_envio='".$FechaEnvio."'	";
				mysqli_query($link,$Actualizar);
			}
		}
		$Consulta="select * from sec_web.embarque_ventana t1 ";
		$Consulta.=" inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto  ";
		$Consulta.=" left  join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto			 ";
		$Consulta.=" left  join sec_web.nave t4 on t1.cod_nave=t4.cod_nave			 ";
		$Consulta.=" where t1.num_envio='".$Envio."' and tipo <> 'V' and YEAR(fecha_envio) = year(now()) order by fecha_embarque desc  ";
		$Consulta.="Limit 0,1";
		$Respuesta=mysqli_query($link,$Consulta);
		$cod_estiba = "";
		$cod_cliente = "";
		if ($Fila=mysqli_fetch_array($Respuesta))
		{
			$FechaEnvio=isset($Fila["fecha_envio"])?$Fila["fecha_envio"]:"0000-00-00";
			$FechaEmbarque=isset($Fila["fecha_embarque"])?$Fila["fecha_embarque"]:"0000-00-00";
			$FechaProgramacion=isset($Fila["fecha_programacion"])?$Fila["fecha_programacion"]:"0000-00-00";
			$Descripcion=isset($Fila["descripcion"])?$Fila["descripcion"]:"";
			$DescripcionPuerto=isset($Fila["nom_aero_puerto"])?$Fila["nom_aero_puerto"]:"";
			$DescripcionNave=isset($Fila["nombre_nave"])?$Fila["nombre_nave"]:"";
			$TipoEmbarque=isset($Fila["tipo_embarque"])?$Fila["tipo_embarque"]:"·";
			$SwSubCliente=isset($Fila["cod_sub_cliente"])?$Fila["cod_sub_cliente"]:"";
			$Cliente=isset($Fila["rut_cliente"])?$Fila["rut_cliente"]:"";
			$cod_estiba = isset($Fila["cod_estiba"])?$Fila["cod_estiba"]:"";
			$cod_cliente = isset($Fila["cod_cliente"])?$Fila["cod_cliente"]:"";
		}
		else
		{
			$Consulta="select * from sec_web.embarque_ventana t1 ";
			$Consulta.=" inner join proyecto_modernizacion.subproducto t2 on t1.cod_producto=t2.cod_producto and t1.cod_subproducto=t2.cod_subproducto ";
			$Consulta.=" left  join sec_web.puertos t3 on t1.cod_puerto=t3.cod_puerto			 ";
			$Consulta.=" left  join sec_web.nave t4 on t1.cod_nave=t4.cod_nave			 ";
			$Consulta.=" where t1.num_envio='".$Envio."' and tipo <> 'V'  and YEAR(fecha_envio) =  year(subdate(now(), interval 1 year)) order by fecha_embarque desc  ";
			$Consulta.="Limit 0,1";
			$Respuesta=mysqli_query($link,$Consulta);
			$Fila=mysqli_fetch_array($Respuesta);
			$FechaEnvio=isset($Fila["fecha_envio"])?$Fila["fecha_envio"]:"0000-00-00";
			$FechaEmbarque=isset($Fila["fecha_embarque"])?$Fila["fecha_embarque"]:"0000-00-00";
			$FechaProgramacion=isset($Fila["fecha_programacion"])?$Fila["fecha_programacion"]:"0000-00-00";
			$Descripcion=isset($Fila["descripcion"])?$Fila["descripcion"]:"";
			$DescripcionPuerto=isset($Fila["nom_aero_puerto"])?$Fila["nom_aero_puerto"]:"";
			$DescripcionNave=isset($Fila["nombre_nave"])?$Fila["nombre_nave"]:"";
			$TipoEmbarque=isset($Fila["tipo_embarque"])?$Fila["tipo_embarque"]:"·";
			$SwSubCliente=isset($Fila["cod_sub_cliente"])?$Fila["cod_sub_cliente"]:"";
			$Cliente=isset($Fila["rut_cliente"])?$Fila["rut_cliente"]:"";
			$cod_estiba = isset($Fila["cod_estiba"])?$Fila["cod_estiba"]:"";
			$cod_cliente = isset($Fila["cod_cliente"])?$Fila["cod_cliente"]:"";
		}
		if($TipoEmbarque!="T")
		{
			if(($cod_estiba!="")&&($SwSubCliente!=""))
			{
				$Consulta="select * from sec_web.prestador where cod_prestador_servicio='".$Fila["cod_estiba"]."'";
				$Respuesta0=mysqli_query($link,$Consulta);
				$Fila0=mysqli_fetch_array($Respuesta0);
				$RutCliente=$Fila0["rut"];
				$DescripcionReceptor=$Fila0["nombre"];
				$Receptor=$cod_estiba;
				//$Receptor=$Fila["cod_estiba"];
			}
		} 
		else
		{   
			if ($SwSubCliente!="")
			{
				$Consulta="select * from sec_web.sub_cliente_vta ";
				$Consulta.="where cod_sub_cliente='".$Fila["cod_sub_cliente"]."' and rut_cliente='".$Fila["rut_cliente"]."'	";
				$Resp1=mysqli_query($link,$Consulta);
				$Fil1=mysqli_fetch_array($Resp1);
				$Direccion=$Fil1["direccion"];
				$Ciudad=$Fil1["ciudad"];		
				$RutCliente=$Fil1["rut_cliente"];		
			}
		}
		
		$Consulta="select * from sec_web.nave where cod_nave='".$cod_cliente."' 	";
		$Respuesta1=mysqli_query($link,$Consulta);
		if ($Fila1=mysqli_fetch_array($Respuesta1))
		{
			$DescripcionCliente=$Fila1["nombre_nave"];
			$ClienteSantiago=$Fila1["cod_nave"];
		}
		else
		{
			$Consulta="select * from sec_web.cliente_venta where cod_cliente='".$Fila["cod_cliente"]."' 	";
			$Respuesta1=mysqli_query($link,$Consulta);
			$Fila1=mysqli_fetch_array($Respuesta1);
			$DescripcionCliente=$Fila1["nombre_cliente"];
			$ClienteSantiago=$Fila1["cod_cliente"];
		}
	}
?>
<html>
<head>
<script language="JavaScript">
function Salir()
{
	window.close();
}
function Imprimir()
{
	window.print();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmProceso" method="post" action="">
<input name="TipoEmbarqueO" type="hidden" value="<?php echo $TipoEmbarque  ?>">
<input name="FechaEnvioO" type="hidden" value="<?php echo $FechaEnvio  ?>">
<input name="ClienteSantiagoO" type="hidden" value="<?php echo $ClienteSantiago  ?>">
  <table width="620" border="0" class="TablaInterior">
    <tr> 
      <td width="27"><font size="2">&nbsp; </font></td>
      <td width="68"><font size="2">N&deg; Envio</font></td>
      <td width="191"><font size="1"><font size="2"> </font></font><font size="2"> 
        <?php echo $Envio  ?> 
        <input type="hidden" name="Envio" size="15" value="<?php echo $Envio  ?>">
        </font></td>
      <td width="113">Fecha de Embarque</td>
      <td width="100"><?php echo $FechaEmbarque ?> </td>
      <td width="92">&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>Producto</td>
      <td><?php echo $Descripcion?> </td>
      <td>Fecha Programacion</td>
      <td><?php echo $FechaProgramacion ?></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>Puerto</td>
      <td><?php echo $DescripcionPuerto ?></td>
      <td>Ciudad</td>
       <?php 
		if ($CodSubClienteO!="")
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
      <td colspan="2"><?php echo $CiudadO ?></td>
      <?php 
		if ($CodSubClienteO!="")
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
		if ($DireccionO!="")
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
      <td colspan="2"><?php echo $DireccionO ?></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>Cliente</td>
      <td><?php echo $DescripcionCliente ?>&nbsp;&nbsp;
	  <?php
		if ($ClienteSantiago=='45')
			echo "O.C.:".$Fila[orden_compra]; 
		?>
	      </td>
      <td>Rut Cliente</td>
       <?php 
		if ($RutClienteO!="")
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
      <td colspan="2"> 
        <?php 
	 	 echo $RutClienteO." ".$DescripcionReceptor;  
	    ?>
      </td>
    </tr>
  </table>
  <br>
  <table width="620" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
    <tr class="ColorTabla01"> 
      <!--<td width="18"><div align="left"></div></td>-->
      <td width="75"align="center">Lote</td>
      <td width="53" align="left"><div align="center">Ins.Emb</div></td>
      <td width="49" align="left"><div align="center">Paq.Lote</div></td>
      <td width="58"><div align="center">Peso Lote</div></td>
	  <td width="82"><div align="center">Unidades Lote</div></td>

      <td width="148"><div align="center"></div>
        <div align="center">Marca Lote</div></td>
      <td width="21">E.L</td>
      <td width="82">Paquet Desp</td>
      <td width="83">Peso Desp</td>
    </tr>
  </table>
  <?php
			$SumaUnidadesLoteDespachados=0;
			$SumaPaquetesEnvio=0;
			$SumaPesoLoteEnvio=0;
			$SumaPaquetesDespachados=0;
			$SumaPesoLoteDespachados=0;
			$SumaUnidadesEnvio=0;
			echo "<table width='620' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
			$Consulta="select * from sec_web.embarque_ventana where num_envio='".$Envio."' and tipo <> 'V'  and fecha_envio='".$FechaEnvio."' ";
			echo "<input name='checkbox' type='hidden'  value=>";
			$Respuesta=mysqli_query($link,$Consulta);
			$Encontro=0;$Encontro2=0;
			$Num=0;
			$Transportista="";
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>"; 
				$ClientePrograma='';
				echo "<td width='75' align='center'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."</td>";
				$Consulta="select * from sec_web.programa_enami t1  ";
				$Consulta.=" inner join sec_web.nave t2 on t1.cod_cliente=t2.cod_nave	";
				$Consulta.=" where corr_enm='".$Fila["corr_enm"]."'	";
				$Respuesta3=mysqli_query($link,$Consulta);
				if($Fila3=mysqli_fetch_array($Respuesta3))
				{
					$ClientePrograma=$Fila3["nombre_nave"];
					$Encontro=true;
					$Encontro2=1;
				}
				else
				{
					$Consulta="select * from sec_web.programa_enami t1  ";
					$Consulta.=" inner join sec_web.cliente_venta t2 on t1.cod_cliente=t2.cod_cliente	";
					$Consulta.=" where corr_enm='".$Fila["corr_enm"]."'	";
					$Respuesta4=mysqli_query($link,$Consulta);
					if($Fila4=mysqli_fetch_array($Respuesta4))
					{
						$ClientePrograma=$Fila4["sigla_cliente"];
						$Encontro=true;
						$Encontro2=1;
					}
				}
				$Consulta="select * from sec_web.programa_codelco t1  ";
				$Consulta.=" inner join sec_web.nave t2 on t1.cod_cliente=t2.cod_nave	";
				$Consulta.=" where corr_codelco='".$Fila["corr_enm"]."'	";
				$Respuesta3=mysqli_query($link,$Consulta);
				if($Fila3=mysqli_fetch_array($Respuesta3))
				{
					$ClientePrograma=$Fila3["nombre_nave"];
					if ($Fila3["cod_contrato_maquila"]== 'MAQ ENM')
					{
						$Encontro2=1;
					}
					else
					{	
						$Encontro2=2;
					}	
					$Encontro=true;
					
				}
				else
				{
					$Consulta="select * from sec_web.programa_codelco t1  ";
					$Consulta.=" inner join sec_web.cliente_venta t2 on t1.cod_cliente=t2.cod_cliente	";
					$Consulta.=" where corr_codelco='".$Fila["corr_enm"]."'	";
					$Respuesta4=mysqli_query($link,$Consulta);
					if($Fila4=mysqli_fetch_array($Respuesta4))
					{
						$ClientePrograma=$Fila4["sigla_cliente"];
						if ($Fila4["cod_contrato_maquila"]== 'MAQ ENM')
						{
							$Encontro2=1;
						}
						else
						{	
							$Encontro2=2;
						}	
						$Encontro=true;
						//$Encontro2=2;
					}
				}
				if($Encontro==true)
				{
					$Cont2++;
					echo "<td width='53'>".$Fila["corr_enm"]."&nbsp;</td>";
				}
				else
				{
					echo "<td width='53'>".$Fila["corr_enm"]."</td>";					
				}
				
				//aqui sacar las unidades de los paquetes 06-02-2009
				
				$Consulta="select sum(num_unidades) as suma_unidades,sum(peso_paquetes) as suma_paquetes, t2.cod_subproducto as cod_subproducto1 from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."' and  ";
				$Consulta.=" year(fecha_creacion_lote) between  '".$Fecha2."' and '".$Fecha1."'  and  corr_enm = '".$Fila["corr_enm"]."'";
				$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete  and t1.cod_estado=t2.cod_estado";
                $Consulta.=" group by t2.cod_producto";
				//echo "CCC".$Consulta;
				$Respuestapoly=mysqli_query($link,$Consulta);
				if ($Filapoly=mysqli_fetch_array($Respuestapoly))
				{
					$SumaUnidades=$Filapoly["suma_unidades"];
					$SumaUnidadesEnvio = $SumaUnidadesEnvio + $Filapoly["suma_unidades"];
				}	
				echo "<td width='49'>".$Fila["bulto_paquetes"]."</td>";
				echo "<td width='58' align='center'>".$Fila["bulto_peso"]."&nbsp;</td>";
				echo "<td width='82' bgcolor='#FF9900' align='center'>".$SumaUnidades."&nbsp;</td>";

				$Consulta="select distinct t1.cod_marca,t2.descripcion from sec_web.embarque_ventana t1 ";
				$Consulta.="inner join sec_web.marca_catodos t2 on t1.cod_marca=t2.cod_marca ";
				$Consulta.=" where corr_enm='".$Fila["corr_enm"]."' and tipo <> 'V' and cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'	";
				$Respuesta4=mysqli_query($link,$Consulta);
				$Fila4=mysqli_fetch_array($Respuesta4);
				echo "<td width='148' align='center'>".$Fila4["descripcion"]."&nbsp;</td>";
				echo "<td width='21' align='center'>".$Fila["cod_confirmado"]."&nbsp;</td>";
				echo "<td width='82' align='center'>".$Fila["despacho_paquetes"]."&nbsp;</td>";
				echo "<td width='83' align='center'>".$Fila["despacho_peso"]."&nbsp;</td>";
				echo "</tr>";
				$SumaPaquetesEnvio=$SumaPaquetesEnvio+$Fila["bulto_paquetes"];
				$SumaPesoLoteEnvio=$SumaPesoLoteEnvio+$Fila["bulto_peso"];
				$SumaPaquetesDespachados=$SumaPaquetesDespachados+$Fila["despacho_paquetes"];
				$SumaPesoLoteDespachados=$SumaPesoLoteDespachados+$Fila["despacho_peso"];
				
				//busca cantidad de unidades del lote poly 06-01-2009
				$Consulta="select sum(num_unidades) as suma_unidades,sum(peso_paquetes) as suma_paquetes, t2.cod_subproducto as cod_subproducto1 from sec_web.lote_catodo t1 ";
				$Consulta.=" inner join sec_web.paquete_catodo t2 on t1.cod_paquete=t2.cod_paquete ";
				$Consulta.=" and t1.num_paquete=t2.num_paquete ";
				$Consulta.=" where cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."' and  ";
				$Consulta.=" year(fecha_creacion_lote) between  '".$Fecha2."' and '".$Fecha1."'  and  corr_enm = '".$Fila["corr_enm"]."'";
				$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_estado = 'c' and t1.cod_estado=t2.cod_estado";
                $Consulta.=" group by t2.cod_producto";
				$Respuestacerrados=mysqli_query($link,$Consulta);
				if ($Filacerrados=mysqli_fetch_array($Respuestacerrados))
				{
					$SumaUnidadesLoteDespachados  = $SumaUnidadesLoteDespachados + $Filacerrados["suma_unidades"];					
				}				
				
				$Encontro=false;
				$Consulta="select distinct t2.nombre_transportista,t1.rut_transportista from sec_web.relacion_transporte_inst_embarque t1 ";
				$Consulta.=" inner join sec_web.transporte t2 on t1.rut_transportista=t2.rut_transportista 	";
				$Consulta.=" where corr_enm='".$Fila["corr_enm"]."'";
				//echo $Consulta;
				$Respuesta5=mysqli_query($link,$Consulta);
				while($Fila5=mysqli_fetch_array($Respuesta5))
				{
					if ($Num==0)
					{	
						$RutTransportistaAnt=$Fila5["rut_transportista"];
						$Transportista=$Fila5["nombre_transportista"]."-";
					}
					else
					{
						if(($RutTransportistaAnt) <> ( $Fila5["rut_transportista"]))
						{
							
							$Transportista=$Transportista.$Fila5["nombre_transportista"]."-";
						}
					}
					$RutTransportistaAnt=$Fila5["rut_transportista"];
					$Num++;
				}
			}
			echo "</table>";	
		?>
  <br>
  
          <table width="620" border="0" class="TablaInterior">
          <tr>
            <td  align="center" width="120"><div align="left">Total Paquetes Envio: </div></td>
            <td  align="center" width="70">
              <div align="left"><?php echo $SumaPaquetesEnvio;  ?></div></td>
            <td  align="center" width="120"><div align="left">Total Peso Envio</div></td>
            <td  align="left" width="70"><?php echo $SumaPesoLoteEnvio ?></td>
			
			<td  align="center" width="120"><div align="left">Total Unidades Envio</div></td>
            <td  align="left" width="70"><?php echo $SumaUnidadesEnvio ?></td>
          </tr>
          <tr>
            <td  align="center" width="120"><div align="left">Total Paquetes Desp.</div></td>
            <td  align="left" width="70"><?php echo $SumaPaquetesDespachados ?></td>
            <td  align="center" width="120"><div align="left">Total Peso Desp.</div></td>
            <td  align="left" width="70"><?php echo $SumaPesoLoteDespachados ?></td>
			
			<td  align="center" width="120"><div align="left">Total Unidades Desp.</div></td>
            <td  align="left" width="70"><?php echo $SumaUnidadesLoteDespachados ?></td>
          </tr>
        </table>
        <br>

<?php    
if ($Encontro2=="1")
{
	echo "ENAMI"."<br>";
	echo "Transportistas".":".$Transportista."<br>";
}
else
{
	echo "CODELCO"."<br>";
	echo "Transportistas".":".$Transportista."<br>";
}
?>  
  <center>
  </center>
  </form>
</body>
</html>
