<?php 
	ob_end_clean();
	$file_name=basename($_SERVER['PHP_SELF']).".xls";
	$userBrowser = $_SERVER['HTTP_USER_AGENT'];
	$filename="";
	if ( preg_match( '/MSIE/i', $userBrowser ) ) {
	$filename = urlencode($filename);
	}
	$filename = iconv('UTF-8', 'gb2312', $filename);
	$file_name = str_replace(".php", "", $file_name);
	header("<meta http-equiv='X-UA-Compatible' content='IE=Edge'>");
	header("<meta http-equiv='content-type' content='text/html;charset=uft-8'>");
	
	header("content-disposition: attachment;filename={$file_name}");
	header( "Cache-Control: public" );
	header( "Pragma: public" );
	header( "Content-type: text/csv" ) ;
	header( "Content-Dis; filename={$file_name}" ) ;
	header("Content-Type:  application/vnd.ms-excel");
 	header("Expires: 0");
  	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	include("../principal/conectar_ref_web.php");

	$proceso  = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
	$opcion  = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";

	$AnoIni  = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");
	$MesIni  = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$DiaIni  = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
	$AnoFin  = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");
	$MesFin  = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$DiaFin  = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");
	
	if (strlen($DiaIni)==1)
		$DiaIni = "0".$DiaIni;
	if (strlen($MesIni)==1)
		$MesIni = "0".$MesIni;
	if (strlen($DiaFin)==1)
		$DiaFin = "0".$DiaFin;
	if (strlen($MesFin)==1)
		$MesFin = "0".$MesFin;
	
 	$FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
	$FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;

?>

		
<HTML>
<HEAD>
      <TITLE> Informe Semanal Planta Tratamiento Electrolito</TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>
<BODY background="../principal/imagenes/fondo3.gif" >
<FORM name="frmPrincipal" action="" method="post">
           
  <p align="center"><font color="#0000FF"><strong>InformeRechazos Catodos Comerciales </strong></font></p>
          </div>
        
  <div align="left"> <font face="Arial, Helvetica, sans-serif"> </font></div>
  </td>
    </tr>
    <tr> 
      <td height="88" align="center" bordercolor="#0000FF"> <div align="left"> 
          
        <table width="958" height="25" border="2" cellpadding="2" cellspacing="2" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="83" height="22"> 
              <div align="center"><font color="#FFFFFF">fecha</font></div></td>
            <td width="71"><font color="#FFFFFF"><strong>Circuito</strong></font></td>
            <td width="70"> 
              <div align="center"><strong>Grupo</strong></div>
              <div align="center"></div></td>
            <td width="73"> 
              <div align="center"><strong>Turno</strong></div>
              <div align="center"></div>
              <div align="center"><font color="#FFFFFF"></font></div>
              <div align="center"></div></td>
            <td width="73"> 
              <div align="center">NE</div></td>
            <td width="70"> 
              <div align="center">ND</div></td>
            <td width="68"> 
              <div align="center">RA</div></td>
            <td width="71"> 
              <div align="center">CL</div></td>
            <td width="70"> 
              <div align="center">CS</div></td>
            <td width="70"> 
              <div align="center">QU</div></td>
            <td width="70"> 
              <div align="center">RE</div></td>
            <td width="70"> 
              <div align="center">AI</div></td>
            <td width="74"> 
              <div align="center">OT</div></td>
            <td width="68"><div align="center">Total Rechazos</div></td>
			<td width="68"><div align="center">Recuperado Menor</div></td>
            <td width="66"><div align="center">Recuperado Mayor</div></td>
          </tr>
        </table>
       

          <table width="958" border="1">
            <tr>
			<?php $proceso='C';
			    if ($proceso == "C")
              	   {
					   $FechaInicio = $AnoIni."-".$MesIni."-".$DiaIni;
					   $FechaTermino = $AnoFin."-".$MesFin."-".$DiaFin;
					   $Consulta_fecha ="select  distinct fecha from cal_web.rechazo_catodos as t1 " ;
					   $Consulta_fecha.="where t1.fecha between '".$FechaInicio."' and '".$FechaTermino."'";
					   $Respuesta_fecha = mysqli_query($link, $Consulta_fecha);
					   
					   	$total_ne=0;//WSO
						$total_nd=0; $total_ra=0; $total_cl=0; $total_cs=0;
						$total_qu=0;
						$total_re=0;
						$total_ai=0;
						$total_ot=0;
						$total_total_rechazos=0; $total_menor=0; $total_recuperados=0;
						   
					   while($Fila_fecha = mysqli_fetch_array($Respuesta_fecha))
					   {
			                 $Consulta ="select  grupo,turno,ifnull(sum(unid_recup),0) as recuperado_tot, ifnull(sum(recup_menor),0) as recuperado_menor,ifnull(sum(estampa),0) as ne, ifnull(sum(dispersos),0) as nd, ifnull(sum(rayado),0) as ra, ";
					         $Consulta.="ifnull(sum(cordon_superior),0) as cs, ifnull(sum(cordon_lateral),0) as cl, ifnull(sum(quemados),0) as qu, ifnull(sum(redondos),0) as re, ifnull(sum(aire),0) as ai, ifnull(sum(otros),0) as ot ";
							 $Consulta.=" from cal_web.rechazo_catodos as t1 where fecha= '".$Fila_fecha["fecha"]."' group by grupo order by fecha,grupo,turno";
							 $Respuesta2 = mysqli_query($link, $Consulta);
					         $pasada='S';
					         while ($Fila2 = mysqli_fetch_array($Respuesta2))
							  {
									 echo "<tr>\n";
									 if (strlen($Fila2["grupo"])==1)
										{$Fila2["grupo"]='0'.$Fila2["grupo"];}
										$consulta2="select distinct cod_circuito from sec_web.grupo_electrolitico2 where cod_grupo='".$Fila2["grupo"]."'";
										$Respuesta3 = mysqli_query($link, $consulta2);
										$Fila3 = mysqli_fetch_array($Respuesta3);
										
										if ($pasada=='S')
										   {    
												echo "<td width='120' align='center' class='detalle01'><font color='blue'><a href=\"JavaScript:detalle('".$Fila_fecha["fecha"]."','".$Fila2["grupo"]."','".$Fila2["turno"]."')\">\n";
												echo $Fila_fecha["fecha"]."</td>\n";
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila3["cod_circuito"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["grupo"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["turno"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["ne"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["nd"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["ra"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["cl"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["cs"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["qu"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["re"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["ai"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["ot"]."&nbsp</font></td>\n";	
												$total_rechazos = $Fila2["nd"]+$Fila2["ne"]+$Fila2["ra"]+$Fila2["cl"]+$Fila2["cs"]+$Fila2["ot"];  
												$total_rechazos = $total_rechazos+$Fila2["qu"]+$Fila2["re"]+$Fila2["ai"]; 
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>$total_rechazos&nbsp</font></td>\n";
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["recuperado_menor"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center' class='detalle01'><font color='blue'>".$Fila2["recuperado_tot"]."&nbsp</font></td>\n";
												$total_nd=$total_nd+$Fila2["nd"];
												$total_ne=$total_ne+$Fila2["ne"];
												$total_ra=$total_ra+$Fila2["ra"];
												$total_cl=$total_cl+$Fila2["cl"];
												$total_cs=$total_cs+$Fila2["cs"];
												$total_qu=$total_qu+$Fila2["qu"];
												$total_re=$total_re+$Fila2["re"];
												$total_ai=$total_ai+$Fila2["ai"];
												$total_ot=$total_ot+$Fila2["ot"];
												$total_total_rechazos = $total_total_rechazos+$total_rechazos;
												$total_menor       = $total_menor      +$Fila2["recuperado_menor"];
												$total_recuperados = $total_recuperados+$Fila2["recuperado_tot"];
												echo "</tr>\n";
												$pasada='N';
											}
										else{ echo "<td width='120' align='center' class='detalle01'><font color='blue'><a href=\"JavaScript:detalle('".$Fila_fecha["fecha"]."','".$Fila2["grupo"]."','".$Fila2["turno"]."')\">\n";
												echo $Fila_fecha["fecha"]."</td>\n";
												echo "<td width='120' align='center'><font color='black'>".$Fila3["cod_circuito"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center'><font color='black'>".$Fila2["grupo"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center'><font color='black'>".$Fila2["turno"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center'><font color='black'>".$Fila2["ne"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center'><font color='black'>".$Fila2["nd"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center'><font color='black'>".$Fila2["ra"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center'><font color='black'>".$Fila2["cl"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center'><font color='black'>".$Fila2["cs"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center'><font color='black'>".$Fila2["qu"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center'><font color='black'>".$Fila2["re"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center'><font color='black'>".$Fila2["ai"]."&nbsp</font></td>\n";	  
												echo "<td width='120' align='center'><font color='black'>".$Fila2["ot"]."&nbsp</font></td>\n";	
												$total_rechazos=$Fila2["nd"]+$Fila2["ne"]+$Fila2["ra"]+$Fila2["cl"]+$Fila2["cs"]+$Fila2["ot"]; 
												$total_rechazos=$total_rechazos+$Fila2["qu"]+$Fila2["re"]+$Fila2["ai"];  
												echo "<td width='120' align='center'><font color='black'>$total_rechazos&nbsp</font></td>\n";
												echo "<td width='120' align='center'<font color='black'>".$Fila2["recuperado_menor"]."&nbsp</font></td>\n";
												echo "<td width='120' align='center'><font color='black'>".$Fila2["recuperado_tot"]."&nbsp</font></td>\n";
												$total_nd=$total_nd+$Fila2["nd"];
												$total_ne=$total_ne+$Fila2["ne"];
												$total_ra=$total_ra+$Fila2["ra"];
												$total_cl=$total_cl+$Fila2["cl"];
												$total_cs=$total_cs+$Fila2["cs"];
												$total_qu=$total_qu+$Fila2["qu"];
												$total_re=$total_re+$Fila2["re"];
												$total_ai=$total_ai+$Fila2["ai"];
												$total_ot=$total_ot+$Fila2["ot"];
												$total_total_rechazos=$total_total_rechazos+$total_rechazos;
												$total_menor      =$total_menor      +$Fila2["recuperado_menor"];
												$total_recuperados=$total_recuperados+$Fila2["recuperado_tot"];
												echo "</tr>\n";
												$pasada='S';}		
										}
								}		
								echo "<td width='120' align='center' class='detalle01'><font color='red'>---&nbsp</font></td>\n";
								echo "<td width='120' align='center' class='detalle01'><font color='red'>Totales&nbsp</font></td>\n";
								echo "<td width='120' align='center' class='detalle01'><font color='red'>---&nbsp</font></td>\n";
								echo "<td width='120' align='center' class='detalle01'><font color='red'>---&nbsp</font></td>\n";
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_ne&nbsp</font></td>\n";
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_nd&nbsp</font></td>\n";
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_ra&nbsp</font></td>\n";
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_cl&nbsp</font></td>\n";	  
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_cs&nbsp</font></td>\n";	  
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_qu&nbsp</font></td>\n";	  
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_re&nbsp</font></td>\n";	  
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_ai&nbsp</font></td>\n";	  
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_ot&nbsp</font></td>\n";	
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_total_rechazos&nbsp</font></td>\n";
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_menor&nbsp</font></td>\n";
								echo "<td width='120' align='center' class='detalle01'><font color='red'>$total_recuperados&nbsp</font></td>\n";
								
					     }		  	  
								  
			?>  
          </table>
		  
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
		  </div></td> 
    </tr>
    <tr>

	<td height="30" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif"> 
        </font></div></td>
		  </tr>
    <tr> 
	  <td height="40" align="center" valign="middle"> <font face="Arial, Helvetica, sans-serif">&nbsp; 
        </font><br>

 
  <font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif">&nbsp; 
  </font> 
</FORM>
</BODY>
</HTML>


