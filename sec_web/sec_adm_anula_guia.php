<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 76;
	include("../principal/conectar_principal.php");
	//$link = mysql_connect('10.56.11.7','adm_bd','672312');
	//mysql_select_db("sec_web", $link);	
	
	global $descripcion_puerto,$aux_nombre_marca;

	$Buscar   = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$TxtGuia  = isset($_REQUEST["TxtGuia"])?$_REQUEST["TxtGuia"]:"";
	$Msj      = isset($_REQUEST["Msj"])?$_REQUEST["Msj"]:"";

	$Existe='N';
	$FechaGuia="0000-00-00";
	$Numenvio="";
	$InsEmb="";
	$Tara=0; // agregado WSO
	if($Buscar=='S')
	{
       $Consulta="SELECT * FROM sec_web.GUIA_DESPACHO_EMB WHERE NUM_GUIA = '".$TxtGuia."' and (cod_estado = 'I' or cod_estado = 'A') order by fecha_guia desc ";
	   $R=mysqli_query($link, $Consulta);
	   if(mysqli_num_rows($R)==0)
	   {
            $Msj="Nº Guía No Existe, Reingrese...";
            $TxtGuia= "";
	   }
       else
	   {
		   $F=mysqli_fetch_assoc($R);
           $control_guia =$F["cod_estado"];

           if($control_guia == "A")
		   {
                $Msj="Guía fué Anulada, Reingrese...";
                $TxtGuia= "";
		   }
		   else
		   {
			    if($F["cod_estado"]!='')
                    $FechaGuia = $F["fecha_guia"];
                else
                    $FechaGuia = "0000-00-00";

                $Existe='S';
                $Patente1 = $F["patente_guia"];
                $CodLote = $F["cod_bulto"];
                $NumLote = $F["num_bulto"];
                $RutChofer = $F["rut_chofer"];
                $Numenvio = $F["num_envio"];
                $InsEmb = $F["corr_enm"];
            
                $Consulta= "select * from sec_web.embarque_ventana where num_envio = ".$F["num_envio"]." and ";
                $Consulta.= " corr_enm = ".$F["corr_enm"]." and cod_bulto = '".$CodLote."'  and num_bulto = '".$NumLote."'";
				//echo $Consulta;
                $R2=mysqli_query($link, $Consulta);
                if($F2=mysqli_fetch_assoc($R2))
				{
                    $despacho_paquetes_aux = $F2["despacho_paquetes"];
                    $despacho_peso_aux = $F2["despacho_peso"];
					if($F2["cod_estado"]!='')
                        $e_lote = $F2["cod_estado"];
                    else
                        $e_lote = "";
					if($F2["cod_puerto"]=='')
                       $aux_puerto = "0";
                    else
                       $aux_puerto = $F2["cod_puerto"];
					if($F2["cod_cliente"]=='')
                        $aux_cliente = "*";
                    else
                        $aux_cliente = $F2["cod_cliente"];
					
					$estado_lote="";$nombre_transportista="";
					$tara="";$patente_acoplado="";$nombre_chofer = "";
                    poner_estado_lote($e_lote,$estado_lote);
                    sacar_datos_personas($Patente1,$RutChofer,$nombre_transportista,$tara,$patente_acoplado,$nombre_chofer,$link);
                    $Cliente=sacar_cliente($F2["cod_cliente"],$link);
                    if($F2["tipo_enm_code"] == "E")
					{
                        $titulo = "       ENAMI";
                        $Msj="Revise Formulario Impresora...\nGuía Despacho ENAMI";
				    }
				    else
				    {
                        $titulo= "       CODELCO";
                        $Msj="Revise Formulario Impresora...\nGuía Despacho CODELCO";
					}
                    sacar_marca($NumLote,$CodLote,$aux_puerto,$link);
			   }
		   }
	   }
	}	
?>
<html>
<head>
<script language="JavaScript">
function Proceso(Opt,f)
{
	var Frm=document.FrmIngreso;
	switch (Opt)
	{
		case "S":
			Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=65";
			Frm.submit();	
		break;
		case "B":
			if(Frm.TxtGuia.value=='')
			{
				alert('<?php echo "Debe ingresar Guía";?>');
				Frm.TxtGuia.focus();
				return;	
			}
			Frm.action= "sec_adm_anula_guia.php?Proceso="+Opt+"&Buscar=S";
	 		Frm.submit();
		break;
		case "Anula"://ANULAR
			if(Frm.CodLote.value=='' || Frm.NumLote.value=='')
			{
				alert('<?php echo "¿Id Lote y/o Número Lote no existe por favor revisar.";?>');
				return;
			}
			if(Frm.Numenvio.value=='')	
			{
				alert('<?php echo "¿Número de envío no existe por favor revisar.";?>');
				return;
			}
			if(Frm.InsEmb.value=='')	
			{
				alert('<?php echo "¿Instrucción de embarque no existe por favor revisar.";?>');
				return;
			}		
			var msg = confirm('<?php echo "¿Esta Seguro De Anular Guía N° ";?>'+Frm.TxtGuia2.value+'<?php echo " ?";?>');
			if (msg==true)
			{	Frm.action= "sec_adm_anula_guia01.php";
		 		Frm.submit();
				}
		break;
	}
}
function Mensaje(Msj)
{
	if(Msj=='Anulada')	
		alert('<?php echo 'Guía anulada';?>');
	else
	{	
		if(Msj!='')	
			alert(Msj);
	}
}
</script>
<title>Anulaci&oacute;n de Gu&iacute;a</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0" onLoad="Mensaje('<?php echo $Msj;?>')">
<form name="FrmIngreso" method="post" action="">
<input type="hidden" name="despacho_paquetes_aux" id="despacho_paquetes_aux" value="<?php echo $despacho_paquetes_aux;?>" />
<input type="hidden" name="despacho_peso_aux" id="despacho_peso_aux" value="<?php echo $despacho_peso_aux;?>" />
<input type="hidden" name="Numenvio" id="Numenvio" value="<?php echo $Numenvio;?>" />
<input type="hidden" name="InsEmb" id="InsEmb" value="<?php echo $InsEmb;?>" />
<!--<input type="hidden" name="InsEmb" id="InsEmb" value="<?php //echo $InsEmb;?>" />-->
<input type="hidden" name="CodLote" id="CodLote" value="<?php echo $CodLote;?>" />
<input type="hidden" name="NumLote" id="NumLote" value="<?php echo $NumLote;?>" />
<input type="hidden" name="TxtGuia2" id="TxtGuia2" value="<?php echo $TxtGuia;?>" />

<?php include("../principal/encabezado.php");?>
<table class="TablaPrincipal" width="750px" height="500px" cellpadding="0" cellspacing="0" >
<tr>
<td width="100%" align="center" valign="top"><br>
    <table width="90%"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
      <tr class="ColorTabla02">
        <td colspan="8"><STRONG>ANULACI&Oacute;N DE GU&Iacute;A</STRONG></td>
      </tr>
    <tr> 
      <td width="92" align="left" class="Cabecera">N&uacute;mero de Gu&iacute;a</td>
      <td align="left" valign="top" colspan="3"><input type="text" name="TxtGuia" id="TxtGuia" size="10" value="<?php echo $TxtGuia;?>" />        <input type="button" onClick="Proceso('B')" value="Buscar" /></td>
      <td width="92">N&uacute;mero de envio</td><td width="53"><?php echo $Numenvio;?>&nbsp;</td>
      <td width="82">Ins. Embarque</td><td width="74"><?php echo $InsEmb;?>&nbsp;</td>
    </tr>
    <?php
    if($Existe=='S')
	{
		?>
        <tr>
          <td width="92">Fecha</td><td width="92"><?php echo $FechaGuia;?>&nbsp;</td>
          <td width="86">Patente cami&oacute;n</td><td width="51"><?php echo $Patente1;?>&nbsp;</td>
          <td width="92">Patente Acoplado</td><td width="53"><?php echo $patente_acoplado;?>&nbsp;</td>
          <td width="82">N&uacute;mero Lote</td><td width="74"><?php echo $CodLote." - ".$NumLote;?>&nbsp;</td>
        </tr>    
        <tr>
          <td width="92">Transportista</td><td colspan="3"><?php echo $nombre_transportista;?>&nbsp;</td>
          <td width="92">Nombre chofer</td><td colspan="3"><?php echo $nombre_chofer;?>&nbsp;</td>
        </tr>    
        <tr>
          <td width="92">Puerto</td><td width="92" colspan="7"><?php echo $descripcion_puerto;?>&nbsp;</td>
        </tr>    
        <?php	
	}
	?>
    </table><br>
    <table>
    <tr> 
      <td height="313" colspan="3" align="center" valign="top"> 
	  
	    <table width="90%" border="1" cellpadding="2" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
        <tr class="ColorTabla01">
        	<td colspan="5" align="center">Datos Paquetes</td>
        </tr>
        <tr class="ColorTabla01">
        	<td width="47" align="center">Cod. Paquetes</td>
        	<td width="63" align="center">Cod. Paquetes</td>
        	<td width="80" align="center">Peso Paquetes</td>
        	<td width="132" align="center">Marca Paquetes</td>
        	<td width="53" align="center">Unidades</td>
     	</tr>
        <?php
			$Consulta ="select p.fecha_creacion_paquete,d.cod_paquete, d.num_paquete, p.peso_paquetes, p.num_unidades ";
			$Consulta.=" from  sec_web.paquete_catodo p, sec_web.det_guia_despacho_emb d where p.cod_paquete = d.cod_paquete ";
			$Consulta.=" and p.num_paquete = d.num_paquete and p.num_guia = d.num_guia and p.fecha_embarque=d.fecha_guia and p.num_guia = '".$TxtGuia."' ";
			$Consulta.=" and d.fecha_guia = '".$FechaGuia."'";
		//	echo $Consulta."<br>";
			$R=mysqli_query($link, $Consulta);
			$Contador=mysqli_num_rows($R);
			$PesoNeto=0;
			$TotUni=0;
			while($Listar=mysqli_fetch_assoc($R))
			{
				$strcodpaquete = $Listar["cod_paquete"];
				$strnumpaquete = $Listar["num_paquete"];
				$strpeso = $Listar["peso_paquetes"];
				$strunidad = $Listar["num_unidades"];
				$FechaCreaPqte = $Listar["fecha_creacion_paquete"];
				?>
                	<tr bgcolor='#FFFFFF'>
                    <td><?php echo $strcodpaquete;?></td>
                    <td align="right"><?php echo $strnumpaquete;?></td>
                    <td align="right"><?php echo number_format($strpeso,0,',','.');?></td>
                    <td><?php echo $aux_nombre_marca;?></td>
                    <td align="right"><?php echo $strunidad;?></td>
                    </tr>
                <?php	
				$PesoNeto=$PesoNeto+$strpeso;
				$TotUni=$TotUni+$strunidad;
			}
		?>
     	</table>

		<?php
        if($Existe=='S')
        {
            ?><br />
            <input type="hidden" name="contador" id="contador" value="<?php echo $Contador;?>" />
            <input type="hidden" name="aux_peso_neto" id="aux_peso_neto" value="<?php echo $PesoNeto;?>" />
            <table width="90%"  border="1" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
              <tr class="ColorTabla02">
                <td colspan="10"><STRONG>TOTALES</STRONG></td>
              </tr>
            <tr>
              <td width="94">Total Paquetes</td><td width="74" align="right" class="ColorTabla02"><?php echo $Contador;?>&nbsp;</td>
              <td width="83">Peso Neto</td><td width="72" align="right" class="ColorTabla02"><?php echo number_format($PesoNeto,0,',','.');?>&nbsp;</td>
              <td width="105">Total Unidades</td><td width="56" align="right" class="ColorTabla02"><?php echo number_format($TotUni,0,',','.');?>&nbsp;</td>
              <td width="84">Tara Cami&oacute;n</td><td width="73" align="right" class="ColorTabla02"><?php echo number_format($Tara,0,',','.');?>&nbsp;</td>
              <td width="84">Peso Total</td><td width="73" align="right" class="ColorTabla02"><?php echo number_format($PesoNeto+$Contador,0,',','.');?>&nbsp;</td>
            </tr>    
            </table>
            <?php	
        }
        ?>

        <br />
        <table width="200" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td> <div align="center">
              <input name="BtnExcel" type="button"  value="Anular Gu&iacute;a" style="width:80px;" onClick="Proceso('Anula');">
                <input name="BtnSalir2" type="button" id="BtnSalir" value="Salir" style="width:60px;" onClick="Proceso('S');">
              </div></td>
          </tr>
        </table>
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
<?php
function sacar_datos_personas($Patente,$Rut,$nombre_transportista,$tara,$patente_acoplado,$nombre_chofer,$link)
{  
    $p = "select * from sec_web.transporte_persona where patente_camion = '".$Patente."'  and rut_chofer = '".$Rut."'";
    $R=mysqli_query($link, $p);
    if($F=mysqli_fetch_assoc($R))
	{
        $wrut_trans = $F["rut_transportista"];
        $t = "select * from sec_web.transporte  where rut_transportista = '".$wrut_trans."'  and patente_transporte = '".$Patente."'";            
		$R2=mysqli_query($link, $t);
		if($F=mysqli_fetch_assoc($R2))
		{
			$nombre_transportista = $F["nombre_transportista"];
			$tara = $F["peso_tara_transporte"];
			$patente_acoplado= $F["acoplado_camion"];
			$c = "select * from sec_web.persona  where rut_persona = '".$Rut."' ";
			//echo $c."<br>";
			$R3=mysqli_query($link, $c);
			if($F3=mysqli_fetch_assoc($R3))
					$nombre_chofer = $F3["nombre_persona"];
		}
	}
}
function poner_estado_lote($e_lote,$estado_lote)
{
	if($e_lote == "a")
		$estado_lote = "INICIO DEL LOTE ";
	elseif($e_lote=='b')
		$estado_lote = "TÉRMINO DEL LOTE ";
	elseif($e_lote=='c')
		$estado_lote = "LOTE COMPLETO ";
	elseif($e_lote=='d')
		$estado_lote = "INICIO DEL LOTE Y ENVIO ";
	elseif($e_lote=='e')
		$estado_lote = "TÉRMINO DEL LOTE Y ENVIO ";
	elseif($e_lote=='f')
		$estado_lote = "CONTINUACIÓN ";
	
}
function sacar_cliente($aux_cliente,$link)
{
	$aux = $aux_cliente;
	$Cliente="";
	if($aux == "0")
	{
		$Consulta = "select  cod_nave, nombre_nave from sec_web.nave where cod_nave = '".$aux_cliente."'";
		$R=mysqli_query($link, $Consulta);
		$F=mysqli_fetch_assoc($R);
		$strcodnave = $F["cod_nave"];
		$strnombrenave = $F["nombre_nave"];
		$Cliente= $strnombrenave;		
	}
	else
	{
		$Consulta = "select  cod_cliente, nombre_cliente from sec_web.cliente_venta where cod_cliente = '".$aux_cliente."'";
		$R=mysqli_query($link, $Consulta);
		if($R=mysqli_fetch_assoc($R))
		{
			$strcodcliente = $F["cod_cliente"];
			$strnombre = $F["nombre_cliente"];
			$Cliente = $strnombre;
		}
	}
	return($Cliente);
}
function sacar_marca($num_lote,$cod_lote,$aux_puerto,$link)
{
	global $descripcion_puerto,$aux_nombre_marca;
    // $Consulta = "SELECT  l.cod_marca, m.descripcion FROM sec_web.marca_catodos m, lote_catodo l where l.cod_bulto = '".$cod_lote."' ";
    // $Consulta.= " and l.num_bulto = '".$num_lote." ' and l.cod_marca = m.cod_marca";
	$Consulta = "SELECT  l.cod_marca, m.descripcion FROM sec_web.marca_catodos m";
	$Consulta.= " INNER JOIN sec_web.lote_catodo l ON l.cod_marca = m.cod_marca ";
	$Consulta.= " WHERE l.cod_bulto = '".$cod_lote."' ";
    $Consulta.= " AND l.num_bulto = '".$num_lote."' ";
    $R=mysqli_query($link, $Consulta);
	$F=mysqli_fetch_assoc($R);
    $strcodmarca = $F["cod_marca"];
    $strnombre_marca = $F["descripcion"];
    $aux_nombre_marca = $strnombre_marca;
    if($aux_puerto <> "0" && $aux_puerto <> "")
	{
        //$Consulta = "select  e.cod_puerto, p.nom_aero_puerto from embarque_ventana e, puertos p where e.cod_bulto = '".$cod_lote."' ";
        //$Consulta.=" and e.num_bulto = '".$num_lote." ' and e.cod_puerto = '".$aux_puerto." ' and e.cod_puerto = p.cod_puerto";
		$Consulta = "SELECT  e.cod_puerto, p.nom_aero_puerto FROM sec_web.embarque_ventana e ";
		$Consulta.= " INNER JOIN sec_web.puertos p ON e.cod_puerto = p.cod_puerto";
		$Consulta.= " WHERE e.cod_bulto = '".$cod_lote."' ";
        $Consulta.="  AND e.num_bulto = '".$num_lote."' AND e.cod_puerto = '".$aux_puerto."' ";
        $R=mysqli_query($link, $Consulta);
		$F2=mysqli_fetch_assoc($R);
        $strcodpuerto = $F2["cod_puerto"];
        $strpuerto = $F2["nom_aero_puerto"];
        $aux_nombre_puerto = $strpuerto;
        $descripcion_puerto = $aux_nombre_puerto;
	}
    else
        $descripcion_puerto= "SIN PUERTO";		
}

?>