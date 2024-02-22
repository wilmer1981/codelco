<?php include("../principal/conectar_ref_web.php"); 
  if (!isset($fecha))
     {
	  $consulta_fecha_ter="SELECT LEFT(sysdate(),10) as fecha_fin";
	  $respuesta_fecha_ter = mysqli_query($link, $consulta_fecha_ter);
	  $Fila_fecha_ter=mysqli_fetch_array($respuesta_fecha_ter);
	  $FechaTermino = $Fila_fecha_ter[fecha_fin];
	 } 
  else {
        $FechaTermino = $fecha;
       }
  $consulta_fecha_ini="SELECT  SUBDATE('$FechaTermino',INTERVAL 7 DAY) as fecha_inicio";
  $resultado_fecha_ini=mysqli_query($link, $consulta_fecha_ini);
  $Fila_fecha_ini = mysqli_fetch_array($resultado_fecha_ini);
  $FechaInicio = $Fila_fecha_ini[fecha_inicio];
  $txt_turno='C';
  $txt_turno1='B';  
  $proceso='C';	
?>
		
<HTML>
<HEAD>
<TITLE> Informe Semanal Planta Tratamiento Electrolito</TITLE>
<link href="../principal/estilos/css_sea_web.css" type="text/css" rel="stylesheet">	  	  
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
/**********/
function Proceso(f)
{
	var f = document.frmPrincipal;
	f.action = "informe_pte.php?proceso=C";
	f.submit();
}
/**********/
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>
<BODY background="../principal/imagenes/fondo3.gif" >
<FORM name="frmPrincipal" action="" method="post">
 <table width="723" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="721" height="100" align="center" valign="top"> <div align="center"></div>
 
          <p align="center"><font color="#0000FF"><strong>Informe Operacion Planta 
            Tratamiento Electrolito</strong></font><strong><font color="#0000FF" size="1"> 
            </font></strong></p>
          </div>
        <div align="left"> 
          <table width="720" border="0" cellpadding="3" class="TablaInterior">
            <tr> 
              <td width="143"> <strong>Desde:<?php echo $FechaInicio; ?></strong></td>
              <td width="210"><strong>Turno:<?php echo $txt_turno;?></strong></td>
              <td width="124"> <div align="left"><strong>Hasta: <?php echo $FechaTermino;?></strong></div>
                <div align="left"> </div></td>
              <td width="206"><strong>Turno:<?php echo $txt_turno1;?></strong></td>
            </tr>
            <tr> 
              <td colspan="4"><font face="Arial, Helvetica, sans-serif">&nbsp; </font> 
                <div align="left"></div>
                <div align="left"><font face="Arial, Helvetica, sans-serif"> </font><font face="Arial, Helvetica, sans-serif"> 
                  </font></div></td>
            </tr>
          </table>
          <font face="Arial, Helvetica, sans-serif"> </font></div></td>
    </tr>
    <tr> 
      <td height="88" align="center" bordercolor="#0000FF"> <div align="left"> 
          <table width="720" height="62" border="0" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td width="67" rowspan="3"><div align="center"><font color="#FFFFFF"><strong>fecha</strong></font></div></td>
              <td width="95" height="25"><div align="center"><strong>N&deg;Lixiviaciones</strong></div></td>
              <td height="25" colspan="3"><div align="center"><strong>Produccion</strong></div></td>
            </tr>
            <tr class="ColorTabla01"> 
              <td height="13"> <div align="center"></div></td>
              <td height="13"> <div align="center"><strong>Sulfato Cu(sacos/dia)</strong></div></td>
              <td height="13"> <div align="center"><font color="#FFFFFF"><strong>Arseniato 
                  Fe(sacos/dia)</strong></font></div></td>
              <td height="13"> <div align="center"><strong>Sales Cu-Ni(sacos/dia)</strong></div></td>
            </tr>
            <tr class="ColorTabla01"> 
              <td> <table width="110%" border="1">
                  <tr> 
                    <td height="18"> <div align="center"><font color="#FFFFFF">(Ciclos/d&iacute;a)</font></div></td>
                  </tr>
                </table></td>
              <td width="185"><table width="100%" border="1">
                  <tr> 
                    <td width="21%"><div align="center"><font color="#FFFFFF">TC</font></div></td>
                    <td width="19%"><div align="center"><font color="#FFFFFF">TA</font></div></td>
                    <td width="25%"><div align="center"><font color="#FFFFFF">TB</font></div></td>
                    <td width="35%"><div align="center"><font color="#FFFFFF"><strong>Tot.Dia</strong></font></div></td>
                  </tr>
                </table></td>
              <td width="171"><table width="100%" border="1">
                  <tr> 
                    <td width="22%"><div align="center"><font color="#FFFFFF">TC</font></div></td>
                    <td width="25%"><div align="center"><font color="#FFFFFF">TA</font></div></td>
                    <td width="23%"><div align="center"><font color="#FFFFFF">TB</font></div></td>
                    <td width="30%"><div align="center"><font color="#FFFFFF"><strong>Tot.Dia</strong></font></div></td>
                  </tr>
                </table></td>
              <td width="199"><table width="100%" border="1">
                  <tr> 
                    <td width="19%"><div align="center"><font color="#FFFFFF">TC</font></div></td>
                    <td width="20%"><div align="center"><font color="#FFFFFF">TA</font></div></td>
                    <td width="21%"><div align="center"><font color="#FFFFFF">TB</font></div></td>
                    <td width="40%"><div align="center"><font color="#FFFFFF"><strong>Tot.Dia</strong></font></div></td>
                  </tr>
                </table></td>
            </tr>
          </table>
          <table width="720" border="1">
            <tr> 
			<?php 
			     $cont_reactor=0;
				 $cont_sc=0;
				 $cont_af=0;
				 $cont_sn=0;
				 $cont_tur;
			   	 if ($proceso == "C")
              	 {
				  	
	    			$consulta = "select distinct fecha from ref_web.pte";
					$consulta.= " where fecha between '".$FechaInicio."' and '".$FechaTermino."' and fecha < '".$FechaTermino."'";
					$consulta.= " order by fecha";
					//echo $consulta;
					$respuesta = mysqli_query($link, $consulta);
					    $pasada='1';
						$pasada2='1';
						$pasada3='1';
						while ($row= mysqli_fetch_array($respuesta))
						 {
						  $mes=substr($row["fecha"],5,2);
						  $dia=substr($row["fecha"],8,2);
						  $ano=substr($row["fecha"],0,4);
                          $fecha=$ano.'/'.$mes.'/'.$dia; 						
						  echo "<td width='5%' align='center'><font color='blue'>$fecha&nbsp;</font></td>\n";
						  $consulta2="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						  $consulta2.="where fecha= '".$row["fecha"]."'  and turno='C' group by fecha";
						  $respuesta2 = mysqli_query($link, $consulta2);
						  $row2= mysqli_fetch_array($respuesta2);
						  $consulta3="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						  $consulta3.="where fecha= '".$row["fecha"]."'  and turno='A' group by fecha";
						  $respuesta3 = mysqli_query($link, $consulta3);
						  $row3= mysqli_fetch_array($respuesta3);
						  $consulta4="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						  $consulta4.="where fecha= '".$row["fecha"]."'  and turno='B' group by fecha";
						  $respuesta4 = mysqli_query($link, $consulta4);
						  $row4= mysqli_fetch_array($respuesta4);
						  if (($txt_turno=='A') and ($pasada=='1'))
						  	 {$total_reactores=$row3[reactores2]+$row4[reactores2];
							  $total_r=$total_r+$total_reactores;
							  $cont_reactor=$cont_reactor+1;
							  echo "<td width='10%' align='center' class='detalle01'>$total_reactores&nbsp;</td>\n";
							  echo "<td width='7%' align='center'>&nbsp;</td>\n";
							  echo "<td width='5%' align='center'>".$row3[sulfato_cobre]."&nbsp;</td>\n";
							  echo "<td width='5%' align='center'>".$row4[sulfato_cobre]."&nbsp;</td>\n";
							  $cont_sc=$cont_sc+1;
							  $row2[sulfato_cobre]=0;
							  $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
							  echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1&nbsp;</strong></font></td>\n";
							  echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
							  echo "<td width='5%' align='center'>".$row3[arseniato_ferico]."&nbsp;</td>\n";
							  echo "<td width='5%' align='center'>".$row4[arseniato_ferico]."&nbsp;</td>\n";
							  $cont_af=$cont_af+1;
							  $row2[arseniato_ferico]=0;
							  $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
							  echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2&nbsp;</strong></font></td>\n";
							  echo "<td width='5%' align='center'>&nbsp;</td>\n";
							  echo "<td width='4%' align='center'>".$row3[sales_niquel]."&nbsp;</td>\n";
							  echo "<td width='4%' align='center'>".$row4[sales_niquel]."&nbsp;</td>\n"; 
							  $cont_sn=$cont_sn+1;
							  $row2[sales_niquel]=0;
							  $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						      echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3&nbsp;</strong></font></td>\n";
						      $pasada='2';
							  $total_sc=$total_sc+$total_sacos1;
							  $total_af=$total_af+$total_sacos2;
							  $total_sn=$total_sn+$total_sacos3;
							  $cont_tur=$cont_tur+2;}
						  else if (($txt_turno=='B') and ($pasada2=='1'))
						          {$total_reactores=$row4[reactores2];
								  $cont_reactor=$cont_reactor+1;
						           echo "<td width='10%' align='center' class='detalle01'>$total_reactores&nbsp;</td>\n";
								   echo "<td width='7%' align='center'>&nbsp;</td>\n";
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
								   echo "<td width='5%' align='center'>".$row4[sulfato_cobre]."&nbsp;</td>\n"; 
								   $cont_sc=$cont_sc+1;
								   $row2[sulfato_cobre]=0;
								   $row3[sulfato_cobre]=0;
								   $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
            					   echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1&nbsp;</strong></font></td>\n";
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
	   							   echo "<td width='5%' align='center'>".$row4[arseniato_ferico]."&nbsp;</td>\n";
								   $cont_af=$cont_af+1;
								   $row2[arseniato_ferico]=0;
								   $row3[arseniato_ferico]=0;
								   $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
							       echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2&nbsp;</strong></font></td>\n";								   
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
								   echo "<td width='5%' align='center'>&nbsp;</td>\n";
								   echo "<td width='4%' align='center'>".$row4[sales_niquel]."&nbsp;</td>\n"; 
								   $cont_sn=$cont_sn+1;
	   							   $row2[sales_niquel]=0;
								   $row3[sales_niquel]=0;
								   $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						           echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3&nbsp;</strong></font></td>\n";
								   $pasada2='2';
								   $total_r=$total_r+$total_reactores;
								   $total_sc=$total_sc+$total_sacos1;
							       $total_af=$total_af+$total_sacos2;
							       $total_sn=$total_sn+$total_sacos3;
								   $cont_tur=$cont_tur+1;}
						  else if (($txt_turno=='C') and ($pasada3=='1'))
						  			{$total_reactores=$row2[reactores2]+$row3[reactores2]+$row4[reactores2];
									 $cont_reactor=$cont_reactor+1;
						             echo "<td width='10%' align='center' class='detalle01'>$total_reactores&nbsp;</td>\n";
									 echo "<td width='7%' align='center'>".$row2[sulfato_cobre]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3[sulfato_cobre]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[sulfato_cobre]."&nbsp;</td>\n";
									 $cont_sc=$cont_sc+1;
									 $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
						             echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1&nbsp;</strong></font></td>\n"; 
									 echo "<td width='5%' align='center'>".$row2[arseniato_ferico]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3[arseniato_ferico]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[arseniato_ferico]."&nbsp;</td>\n"; 
									 $cont_af=$cont_af+1;
									 $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
							         echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2&nbsp;</strong></font></td>\n";								   
									 echo "<td width='5%' align='center'>".$row2[sales_niquel]."&nbsp;</td>\n";
									 echo "<td width='5%' align='center'>".$row3[sales_niquel]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[sales_niquel]."&nbsp;</td>\n";  
									 $cont_sn=$cont_sn+1;
									 $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						             echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3&nbsp;</strong></font></td>\n";
									  $pasada3='2';
									  $total_r=$total_r+$total_reactores;
									  $total_sc=$total_sc+$total_sacos1;
							          $total_af=$total_af+$total_sacos2;
							          $total_sn=$total_sn+$total_sacos3;
									  $cont_tur=$cont_tur+3;}		     
						       else {
							         $total_reactores=$row2[reactores2]+$row3[reactores2]+$row4[reactores2];
									  $cont_reactor=$cont_reactor+1;
						             echo "<td width='10%' align='center' class='detalle01'>$total_reactores&nbsp;</td>\n";
							         echo "<td width='5%' align='center'>".$row2[sulfato_cobre]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3[sulfato_cobre]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[sulfato_cobre]."&nbsp;</td>\n";
									 $cont_sc=$cont_sc+1;
									 $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
						             echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1&nbsp;</strong></font></td>\n"; 
									 echo "<td width='5%' align='center'>".$row2[arseniato_ferico]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3[arseniato_ferico]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[arseniato_ferico]."&nbsp;</td>\n"; 
									 $cont_af=$cont_af+1;
									 $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
							         echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2&nbsp;</strong></font></td>\n";								   
									 echo "<td width='5%' align='center'>".$row2[sales_niquel]."&nbsp;</td>\n";
									 echo "<td width='5%' align='center'>".$row3[sales_niquel]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[sales_niquel]."&nbsp;</td>\n";  
									 $cont_sn=$cont_sn+1;
									 $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						             echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3&nbsp;</strong></font></td>\n";
									  $total_r=$total_r+$total_reactores;
									 $total_sc=$total_sc+$total_sacos1;
							         $total_af=$total_af+$total_sacos2;
							         $total_sn=$total_sn+$total_sacos3;
									 $cont_tur=$cont_tur+3;}
						  echo "</tr>\n";
						}
						 $consulta_max_fecha="select max(fecha) as fecha_m from ref_web.pte where fecha='".$FechaTermino."'";
					     $respuesta_m = mysqli_query($link, $consulta_max_fecha);
					     $row_m= mysqli_fetch_array($respuesta_m);
						 $mesm=substr($row_m[fecha_m],5,2);
						 $diam=substr($row_m[fecha_m],8,2);
						 $anom=substr($row_m[fecha_m],0,4);
                         $fecham=$anom.'/'.$mesm.'/'.$diam; 
						 $consulta2="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						 $consulta2.="where fecha= '".$row_m[fecha_m]."'  and turno='C' group by fecha";
						 $respuesta2 = mysqli_query($link, $consulta2);
						 $row2= mysqli_fetch_array($respuesta2);
						 $consulta3="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						 $consulta3.="where fecha= '".$row_m[fecha_m]."'  and turno='A' group by fecha";
						 $respuesta3 = mysqli_query($link, $consulta3);
						 $row3= mysqli_fetch_array($respuesta3);
						 $consulta4="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						 $consulta4.="where fecha= '".$row_m[fecha_m]."'  and turno='B' group by fecha";
						 $respuesta4 = mysqli_query($link, $consulta4);
						 $row4= mysqli_fetch_array($respuesta4);
						 $pasada='1';
						 $pasada2='1';
						 $pasada3='1';
						 if ($txt_turno1=='A')
						     {  echo "<td width='5%' align='center'><font color='blue'>$fecham&nbsp;</font></td>\n";
							   $total_reactores=$row2[reactores2]+$row3[reactores2];
							   $cont_reactor=$cont_reactor+1;
							   $total_r=$total_r+$total_reactores;
						       echo "<td width='10%' align='center' class='detalle01'>$total_reactores&nbsp;</td>\n";
							   echo "<td width='5%' align='center'>".$row2[sulfato_cobre]."&nbsp;</td>\n"; 
							   echo "<td width='5%' align='center'>".$row3[sulfato_cobre]."&nbsp;</td>\n";
							   $cont_sc=$cont_sc+1; 
							   echo "<td width='5%' align='center'>&nbsp;</td>\n";
							   $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre];
						       echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1&nbsp;</strong></font></td>\n"; 
							   echo "<td width='5%' align='center'>".$row2[arseniato_ferico]."&nbsp;</td>\n"; 
							   echo "<td width='5%' align='center'>".$row3[arseniato_ferico]."&nbsp;</td>\n"; 
							   $cont_af=$cont_af+1;
							   echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
							   $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico];
							   echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2&nbsp;</strong></font></td>\n";								   
							   echo "<td width='5%' align='center'>".$row2[sales_niquel]."&nbsp;</td>\n";
							   echo "<td width='5%' align='center'>".$row3[sales_niquel]."&nbsp;</td>\n"; 
							   $cont_sn=$cont_sn+1;
							   echo "<td width='5%' align='center'>&nbsp;</td>\n";  
							   $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel];
						       echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3&nbsp;</strong></font></td>\n";
							   $total_sc=$total_sc+$total_sacos1;
							   $total_af=$total_af+$total_sacos2;
							   $total_sn=$total_sn+$total_sacos3;
							   $cont_tur=$cont_tur+2;}
						 else if ($txt_turno1=='B')
						         {    echo "<td width='5%' align='center'><font color='blue'>$fecham&nbsp;</font></td>\n";
								     $total_reactores=$row2[reactores2]+$row3[reactores2]+$row4[reactores2];
									 $cont_reactor=$cont_reactor+1;
									 $total_r=$total_r+$total_reactores;
						             echo "<td width='10%' align='center' class='detalle01'>$total_reactores&nbsp;</td>\n";
							         echo "<td width='5%' align='center'>".$row2[sulfato_cobre]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3[sulfato_cobre]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[sulfato_cobre]."&nbsp;</td>\n";
									 $cont_sc=$cont_sc+1; 
									 $total_sacos1=$row2[sulfato_cobre]+$row3[sulfato_cobre]+$row4[sulfato_cobre];
						             echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1&nbsp;</strong></font></td>\n"; 
									 echo "<td width='5%' align='center'>".$row2[arseniato_ferico]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3[arseniato_ferico]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[arseniato_ferico]."&nbsp;</td>\n"; 
									 $cont_af=$cont_af+1;
									 $total_sacos2=$row2[arseniato_ferico]+$row3[arseniato_ferico]+$row4[arseniato_ferico];
							         echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2&nbsp;</strong></font></td>\n";								   
									 echo "<td width='5%' align='center'>".$row2[sales_niquel]."&nbsp;</td>\n";
									 echo "<td width='5%' align='center'>".$row3[sales_niquel]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4[sales_niquel]."&nbsp;</td>\n";  
									 $cont_sn=$cont_sn+1;
									 $total_sacos3=$row2[sales_niquel]+$row3[sales_niquel]+$row4[sales_niquel];
						             echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3&nbsp;</strong></font></td>\n";
									  $total_sc=$total_sc+$total_sacos1;
							         $total_af=$total_af+$total_sacos2;
							         $total_sn=$total_sn+$total_sacos3;
									 $cont_tur=$cont_tur+3;}
						 else if ($txt_turno1=='C')
						          {   echo "<td width='5%' align='center'><font color='blue'>$fecham&nbsp;</font></td>\n";
								      $cont_reactor=$cont_reactor+1;
								     $total_reactores=$row2[reactores2]+$row3[reactores2]+$row4[reactores2];
									 $total_r=$total_r+$total_reactores;
						             echo "<td width='10%' align='center' class='detalle01'>$total_reactores&nbsp;</td>\n";
							         echo "<td width='5%' align='center'>".$row2[sulfato_cobre]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n";
									 $cont_sc=$cont_sc+1; 
									 $total_sacos1=$row2[sulfato_cobre];
						             echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1&nbsp;</strong></font></td>\n"; 
									 echo "<td width='5%' align='center'>".$row2[arseniato_ferico]."&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n";
									 $cont_af=$cont_af+1;  
									 $total_sacos2=$row2[arseniato_ferico];
							         echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2&nbsp;</strong></font></td>\n";								   
									 echo "<td width='5%' align='center'>".$row2[sales_niquel]."&nbsp;</td>\n";
									 echo "<td width='5%' align='center'>&nbsp;</td>\n"; 
									 echo "<td width='5%' align='center'>&nbsp;</td>\n";
									 $cont_sn=$cont_sn+1;   
									 $total_sacos3=$row2[sales_niquel];
						             echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3&nbsp;</strong></font></td>\n";
									 $total_sc=$total_sc+$total_sacos1;
							         $total_af=$total_af+$total_sacos2;
							         $total_sn=$total_sn+$total_sacos3;
									 $cont_tur=$cont_tur+1;}		 	   
								  echo "</tr>\n";			 
					}
					echo "<td align='center'><font color='blue'>Totales&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>$total_r&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>$total_sc&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>$total_af&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";	  
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
		    		echo "<td align='center' ><font color='blue'>$total_sn&nbsp</font></td>\n";	  	  	  
			?>  
          </table>
		 <p>&nbsp;</p>
        <table width="100%" border="2">
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <td width="7%"><strong>Promedios</strong></td>
			<?php
			//$javier=$cont_sc+$cont_af+$cont_sn-2;
			//echo $cont_tur;
			if ($cont_sc==0)
			   {$promedio_sc=0; }
			else{$promedio_sc=$total_sc/$cont_tur;
			     $promedio_sc=number_format($promedio_sc,"2",",","");}   
			if ($cont_af==0)
			   {$promedio_af=0;}
			else {$promedio_af=$total_af/$cont_tur;
			      $promedio_af=number_format($promedio_af,"2",",","");}
			if ($cont_sn==0)
			   {$promedio_sn=0;}
			else {$promedio_sn=$total_sn/$cont_tur;
			      $promedio_sn=number_format($promedio_sn,"2",",","");}
			if ($cont_reactor==0)
			   {$promedio_r=0;}
			else {$promedio_r=$total_r/ $cont_reactor;
			      $promedio_r=number_format($promedio_r,"2",",",""); }                        
			echo "<td width='11%' align='center'>$promedio_r&nbsp;</td>";
			echo "<td width='15%' align='center'>&nbsp;</td>";
            echo "<td width='9%' align='right'>$promedio_sc s/turno&nbsp;</td>";
			echo "<td width='14%' align='center'>&nbsp;</td>";
            echo "<td width='9%' align='right'>$promedio_af s/turno&nbsp;</td>";
			echo "<td width='15%' align='center'>&nbsp;</td>";
            echo "<td width='11%' align='right'>$promedio_sn s/turno&nbsp;</td>";
			?>
          </tr>
        </table>
		 <p>&nbsp;</p>
          <table width="720" height="62" border="2" bordercolor="#0000FF">
            <tr> 
              <td width="7%" bgcolor="#FFFFFF"><strong>INT. I.</strong></td>
              <td width="5%" bgcolor="#FFFFFF">&nbsp;</td>
              <td colspan="2" bgcolor="#FFFFFF"> <div align="left"><strong>Carga 
                  Reactor</strong></div></td>
              <td colspan="8" bgcolor="#FFFFFF"> <div align="left"><strong>Razon 
                  Prod.</strong></div></td>
              <td width="37%" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr bordercolor="#0000FF"> 
              <td bgcolor="#FFFFFF"><strong>INT. F.</strong></td>
              <td bgcolor="#FFFFFF">&nbsp;</td>
              <td colspan="2" bgcolor="#FFFFFF"> 
                <?php
			 $total_x=($total_r*11.4);
            echo  "<div align='left'><font color='#FF0000'><strong>11,4 m3/ciclo</strong></font></div></td>";
			if ($total_x==0)
			   {$Razon_prod=0;}
			 else{$Razon_prod=($total_sc/$total_x);
			      $Razon_prod=number_format($Razon_prod,"2",",","");}
            echo "<td colspan='8' bgcolor='#FFFFFF'><font color='#FF0000'><strong>$Razon_prod sacos/m3 </strong></font></td>";
			?>
              <td width="5%" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr> 
              <td bordercolor="#0000FF" bgcolor="#FFFFFF"><strong>Total</strong></td>
              <?php
              echo "<td bordercolor='#0000FF' bgcolor='#FFFFFF' align='center'>$total_x&nbsp;</td>";
			?>
              <?php
			
            echo "<td colspan='2' bordercolor='#000000' bgcolor='#FFFFFF'>&nbsp;</td>";
			?>
              <td colspan="8" bordercolor="#0000FF" bgcolor="#FFFFFF">&nbsp;</td>
              <td width="4%" bordercolor="#0000FF" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
          </table>
		   <p>&nbsp;</p>
          <table width="100%" border="2">
            <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
              <?php
		            $consulta_circuito="select valor_subclase1,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='3100' and valor_subclase1<='6' "; 
					$respuesta_circuito= mysqli_query($link, $consulta_circuito);
					$total_electrolito=0;
					$total_dp=0;
					while ($row_c= mysqli_fetch_array($respuesta_circuito))
					       {
							    $consulta_elect_total="select sum(volumen_pte) as volumen_pte_total from ref_web.tratamiento_electrolito";
						        $consulta_elect_total.= " where fecha  between '".$FechaInicio."' and '".$FechaTermino."' and turno  in ('C','A','B')";
					            $consulta_elect_total.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
						        $respuesta_elect_total = mysqli_query($link, $consulta_elect_total);
		                        $row_elect_total= mysqli_fetch_array($respuesta_elect_total);
								//echo $consulta_elect_total."<br>";
								$consulto='S';
								if ($txt_turno=='A')
								   {
								     $turnos_desc_inicio="C";
								   }
								else if ($txt_turno=='B')
								        {
										  $turnos_desc_inicio="C','A";
										}  
									  else {
									         $consulto='N';
									       }
								if ($consulto!='N')
								    {		   	 
									  $consulta_elect_descuento_inicio="select sum(volumen_pte) as volumen_pte_inicio from ref_web.tratamiento_electrolito";
									  $consulta_elect_descuento_inicio.= " where fecha ='".$FechaInicio."' and turno  in ('".$turnos_desc_inicio."')";
									  $consulta_elect_descuento_inicio.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									  $respuesta_elect_descuento_inicio = mysqli_query($link, $consulta_elect_descuento_inicio);
									  $row_elect_descuento_inicio= mysqli_fetch_array($respuesta_elect_descuento_inicio);
									  //echo $consulta_elect_descuento_inicio."<br>";
								    }
							    $consulto='S';		
								if ($txt_turno1=='A')
								   {
								    $turnos_desc_fin="B";
								   }
								else if ($txt_turno1=='C')
								        {
										  $turnos_desc_fin="A','B";
										}
								      else {
									        $consulto='N';
									       }
								 if ($consulto!='N')
								    {		   
									 $consulta_elect_descuento_ter="select sum(volumen_pte) as volumen_pte_ter from ref_web.tratamiento_electrolito";
									 $consulta_elect_descuento_ter.= " where fecha ='".$FechaTermino."' and turno  in ('".$turnos_desc_fin."')";
									 $consulta_elect_descuento_ter.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									 $respuesta_elect_descuento_ter = mysqli_query($link, $consulta_elect_descuento_ter);
									 $row_elect_descuento_ter= mysqli_fetch_array($respuesta_elect_descuento_ter);
									 //echo $consulta_elect_descuento_ter."<br>";
									} 
								$total_electrolito=0;			   
							    $total_electrolito=$row_elect_total[volumen_pte_total]-$row_elect_descuento_inicio[volumen_pte_inicio]-$row_elect_descuento_ter[volumen_pte_ter];
							/***************************************************************************************************************/

							    $consulta_dp_total="select sum(volumen_dp) as total_desc_parcial from ref_web.desc_parcial";
						        $consulta_dp_total.= " where fecha  between '".$FechaInicio."' and '".$FechaTermino."' and turno  in ('C','A','B')";
					            $consulta_dp_total.= " and circuito_dp='".$row_c["nombre_subclase"]."'";
								//echo $consulta_dp_total."<br>";
								$respuesta_dp_total = mysqli_query($link, $consulta_dp_total);
         						$row_dp_total= mysqli_fetch_array($respuesta_dp_total);
								$consulto='S';
								if ($txt_turno=='A')
								   {
								     $turnos_desc_inicio="C";
								   }
								else if ($txt_turno=='B')
								        {
										  $turnos_desc_inicio="C','A";
										}  
									  else {
									         $consulto='N';
									       }
								
								if ($consulto!='N')
								    {		   	 
								     $consulta_dp_total_ini="select sum(volumen_dp) as total_desc_parcial_ini from ref_web.desc_parcial";
						             $consulta_dp_total_ini.= " where fecha = '".$FechaInicio."' and turno  in ('".$turnos_desc_inicio."')";
					                 $consulta_dp_total_ini.= " and circuito_dp='".$row_c["nombre_subclase"]."'";
									 //echo $consulta_dp_total_ini."<br>";
								     $respuesta_dp_total_ini = mysqli_query($link, $consulta_dp_total_ini);
         						     $row_dp_total_ini= mysqli_fetch_array($respuesta_dp_total_ini);
									} 
								$consulto='S';	
								if ($txt_turno1=='A')
								   {
								    $turnos_desc_fin="B";
								   }
								else if ($txt_turno1=='C')
								        {
										  $turnos_desc_fin="A','B";
										}
								      else {
									        $consulto='N';
									       }	
								if ($consulto!='N')
								    {		   	 
								      $consulta_dp_total_fin="select sum(volumen_dp) as total_desc_parcial_fin from ref_web.desc_parcial";
						              $consulta_dp_total_fin.= " where fecha = '".$FechaTermino."' and turno in ('".$turnos_desc_fin."')";
					                  $consulta_dp_total_fin.= " and circuito_dp='".$row_c["nombre_subclase"]."'";
								      $respuesta_dp_total_fin = mysqli_query($link, $consulta_dp_total_fin);
         						      $row_dp_total_fin= mysqli_fetch_array($respuesta_dp_total_fin);
								      //echo $consulta_dp_total_fin."<br>";
								    }
								
								
								
								
							$total_dp=0;	
							$total_dp=$row_dp_total[total_desc_parcial]-$row_dp_total_ini[total_desc_parcial_ini]-$row_dp_total_fin[total_desc_parcial_fin];
							/***************************************************************************************************************/
						 	 if ($row_c["nombre_subclase"]=='Circuito1')
							     {$total_c1=$total_c1+($total_electrolito + $total_dp);}
							 else if ($row_c["nombre_subclase"]=='Circuito2')
									{$total_c2=$total_c2+($total_electrolito + $total_dp);}
							      else if ($row_c["nombre_subclase"]=='Circuito3')
									      {$total_c3=$total_c3+($total_electrolito + $total_dp);}
								       else if ($row_c["nombre_subclase"]=='Circuito4')
									          {$total_c4=$total_c4+($total_electrolito + $total_dp);}
										    else if ($row_c["nombre_subclase"]=='Circuito5')
									               {$total_c5=$total_c5+($total_electrolito + $total_dp);}	
												  else if ($row_c["nombre_subclase"]=='Circuito6')
									                  {$total_c6=$total_c6+($total_electrolito + $total_dp);}    
						   
						   }
					
		  
		    
		  ?>
              <td height="17"><strong>Descarte electrolito (m3)</strong></td>
              <?php
            echo "<td><strong>TOTAL</strong>";
			$total=$total_c1+$total_c2+$total_c3+$total_c4+$total_c5+$total_c6;
			echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total</strong></font></td>";
			 
            
			/*echo "<td colspan='8' bgcolor='#FFFFFF'><font color='#FF0000'><strong>$Razon_prod sacos/m3 </strong></font></td>";*/
			echo "<td>C1";    
			echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c1</strong></font></td>";
			
			
            echo "<td>C2";   
			echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c2</strong></font></td>";
            echo "<td>C3";
			echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c3</strong></font></td>";
            echo "<td>C4";
			echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c4</strong></font></td>";
            echo "<td>C5";
			echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c5</strong></font></td>";
            echo "<td>C6";
			echo "<div align='right'><bgcolor='#FFFFFF'><font color='#FF0000'><strong>$total_c6</strong></font></td>";
			?>
            </tr>
          </table>
   
		  <p>&nbsp;</p>
          <table width="720"  border="1" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td colspan="3" ><div align="center"><font color="#FFFFFF"><strong>Novedades 
                  Relevantes </strong></font></div></td>
            </tr>
            <tr class="ColorTabla01"> 
              <td width="124" align="center"><strong>fecha</strong></td>
              <td width="88" align="center"><strong>Turno</strong></td>
              <td width="499" align="center"><strong>Observacion</strong></td>
            </tr>
			<?php $consulta="select * from ref_web.novedades_jefe_pte where fecha between '".$FechaInicio."' and '".$FechaTermino."' and pte='S' order by fecha";
			   //echo $consulta;
			   $respuesta = mysqli_query($link, $consulta);
 		       while ($row= mysqli_fetch_array($respuesta))
			        {
					   echo '<tr>';
					   echo '<td width="106" align="center" class="detalle01">'.$row[FECHA].'</td>';
                       echo '<td width="88" align="center" >'.$row[TURNO].'</td>';
                       echo '<td width="519" align="left" >'.$row[NOVEDAD].'</td>';
					   echo '</tr>';
					
					
					}
			
			
			
			?>
          </table>
          <p>&nbsp;</p>
        </div></td>
    </tr>
    <tr>

	<td height="30" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif"> 
          <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
          </font></div></td>
		  </tr>
    <tr> 
	  <td height="40" align="center" valign="middle"> <font face="Arial, Helvetica, sans-serif">&nbsp; 
        </font><br>

   <font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
  </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif">&nbsp; 
  </font> 
  </td>
  </tr>
  </table>
</FORM>
</BODY>
</HTML>
<?php
	if (isset($Mensaje))
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	
	}
?>

