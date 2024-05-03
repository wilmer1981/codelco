<?php 
ob_end_clean();
$file_name=basename($_SERVER['PHP_SELF']).".xls";
$userBrowser = $_SERVER['HTTP_USER_AGENT'];
$filename = "";
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

$FechaInicio     = isset($_REQUEST["FechaInicio"])?$_REQUEST["FechaInicio"]:"";
$FechaTermino    = isset($_REQUEST["FechaTermino"])?$_REQUEST["FechaTermino"]:"";
	
$txt_turno    = isset($_REQUEST["txt_turno"])?$_REQUEST["txt_turno"]:"";
$txt_turno1   = isset($_REQUEST["txt_turno1"])?$_REQUEST["txt_turno1"]:"";
$proceso    = isset($_REQUEST["proceso"])?$_REQUEST["proceso"]:"";
$opcion     = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";

 ?>
		
<HTML>
<HEAD>
      <TITLE> Informe Semanal Planta Tratamiento Electrolito</TITLE>
<script language="JavaScript">
function Imprimir(f)
{
	window.print();
}
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=7";
}
/***************/
function Proceso(f)
{
	var f = document.frmPrincipal;
	f.action = "informe_pte_02.php?proceso=C";
	f.submit();
}
function Excel()

{
	var  f=document.frmPrincipal;
	var FechaInicio=f.AnoIni.value+'-'+f.MesIni.value+'-'+f.DiaIni.value;
	var FechaTermino=f.AnoFin.value+'-'+f.MesFin.value+'-'+f.DiaFin.value;
	var txt_turno=f.txt_turno.value;
	var txt_turno1=f.txt_turno1.value;
	
		if (txt_turno==-1) 
		{
			alert ('Debe Seleccionar Turno');
			return;
		}
		else
		{	
			document.location ="Informe_pte_02_xls.php?FechaInicio="+FechaInicio+"&FechaTermino="+FechaTermino+"&txt_turno="+txt_turno+"&txt_turno1="+txt_turno1+"&proceso=C";
		}		
}
/**********/
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></HEAD>
<FORM name="frmPrincipal" action="" method="post">
  <?php /*include("../principal/encabezado.php");*/ ?>
  <?php
?>
 
          <p align="center"><font color="#0000FF"><strong>Informe Operacion Planta 
            Tratamiento Electrolito</strong></font><strong><font color="#0000FF" size="1"> 
            </font></strong></p>
          </div>
        <div align="left"> 
          <table width="969" border="0" cellpadding="3" class="TablaInterior">
            <tr> 
              <td width="95">Informe Desde</td>
              <td width="271"><?php echo $FechaInicio; ?></td>
              <td width="63"> <div align="left">Hasta</div></td>
              <td width="489"><?php echo $FechaTermino; ?></td>
            </tr>
            <tr> 
              <td>Turno</td>
              <td width="271"><font face="Arial, Helvetica, sans-serif"><?php echo $txt_turno; ?> 
                </font></td>
              <td width="63"> <div align="left">Turno</div></td>
              <td width="489"> <div align="left"><font face="Arial, Helvetica, sans-serif"> 
                  </font><font face="Arial, Helvetica, sans-serif"> 
                  <?php echo $txt_turno1; ?> </font></div></td>
            </tr>
          </table>
          
    <br>
    <p><font face="Arial, Helvetica, sans-serif"> </font></p>
  </div></td>
    </tr>
    <tr> 
      <td height="88" align="center" bordercolor="#0000FF"> <div align="left"> 
          
        <table width="969" height="62" border="0" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
              <td width="74" rowspan="3"><div align="center"><font color="#FFFFFF"><strong>fecha</strong></font></div></td>
              <td width="233" height="25"><div align="center"><strong>N&deg;Lixiviaciones</strong></div></td>
              <td height="25" colspan="3"><div align="center"><strong>Produccion</strong></div></td>
            </tr>
            <tr class="ColorTabla01"> 
              <td height="13"> <div align="center"></div>
                </td>
              <td height="13"> <div align="center"><strong>Sulfato Cu(sacos/dia)</strong></div></td>
              <td height="13"> <div align="center"><font color="#FFFFFF"><strong>Arseniato 
                Fe(sacos/dia)</strong></font></div></td>
              <td height="13"> <div align="center"><strong>Sales Cu-Ni(sacos/dia)</strong></div></td>
            </tr>
            <tr class="ColorTabla01"> 
              <td> 
                <table width="100%" border="1">
                <tr> 
                  <td width="20%" height="18"> <div align="center"><font color="#FFFFFF">TC</font></div></td>
                  <td width="20%"><div align="center"><font color="#FFFFFF">TA</font></div></td>
                  <td width="20%"><div align="center"><font color="#FFFFFF">TB</font></div></td>
                  <td width="40%"><font color="#FFFFFF">(Ciclos/d&iacute;a)</font></td>
                </tr>
              </table></td>
              <td width="220"><table width="100%" border="1">
                  <tr> 
                    <td width="20%"><div align="center"><font color="#FFFFFF">TC</font></div></td>
                    <td width="20%"><div align="center"><font color="#FFFFFF">TA</font></div></td>
                    <td width="20%"><div align="center"><font color="#FFFFFF">TB</font></div></td>
                    <td width="40%"><div align="center"><font color="#FFFFFF"><strong>Tot.Dia</strong></font></div></td>
                  </tr>
                </table></td>
              <td width="220"><table width="100%" border="1">
                  <tr> 
                    <td width="20%" height="17"><div align="center"><font color="#FFFFFF">TC</font></div></td>
                    <td width="20%"><div align="center"><font color="#FFFFFF">TA</font></div></td>
                    <td width="20%"><div align="center"><font color="#FFFFFF">TB</font></div></td>
                    <td width="40%"><div align="center"><font color="#FFFFFF"><strong>Tot.Dia</strong></font></div></td>
                  </tr>
                </table></td>
              <td width="220"><table width="100%" border="1">
                  <tr> 
                    <td width="20%"><div align="center"><font color="#FFFFFF">TC</font></div></td>
                    <td width="20%"><div align="center"><font color="#FFFFFF">TA</font></div></td>
                    <td width="20%"><div align="center"><font color="#FFFFFF">TB</font></div></td>
                    <td width="40%"><div align="center"><font color="#FFFFFF"><strong>Tot.Dia</strong></font></div></td>
                  </tr>
                </table></td>
            </tr>
          </table>
       

          <table width="969" border="1">
            <tr>
			<?php 
			     $cont_reactor=0;
				 $cont_sc=0;
				 $cont_af=0;
				 $cont_sn=0;
				 $cont_tur = 0;
				 $total_r=0; //WSO
				 $total_sc=0;
				 $total_af=0;
				 $total_sn=0;
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
						  echo "<td width='5%' align='center'><font color='blue'>$fecha</font></td>\n";
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
						  	 {$total_reactores=$row3["reactores2"]+$row4["reactores2"];
							  $total_r=$total_r+$total_reactores;
							  $cont_reactor=$cont_reactor+1;
							  echo "<td width='7%' align='center'></td>\n";
							  echo "<td width='5%' align='center'>".$row3["reactores2"]."</td>\n";
							  echo "<td width='5%' align='center'>".$row4["reactores2"]."</td>\n";
							  echo "<td width='10%' align='center' class='detalle01'>$total_reactores</td>\n";
							  echo "<td width='7%' align='center'></td>\n";
							  echo "<td width='5%' align='center'>".$row3["sulfato_cobre"]."</td>\n";
							  echo "<td width='5%' align='center'>".$row4["sulfato_cobre"]."</td>\n";
							  $cont_sc=$cont_sc+1;
							  $row2["sulfato_cobre"]=0;
							  $total_sacos1=$row2["sulfato_cobre"]+$row3["sulfato_cobre"]+$row4["sulfato_cobre"];
							  echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1</strong></font></td>\n";
							  echo "<td width='5%' align='center'></td>\n"; 
							  echo "<td width='5%' align='center'>".$row3["arseniato_ferico"]."</td>\n";
							  echo "<td width='5%' align='center'>".$row4["arseniato_ferico"]."</td>\n";
							  $cont_af=$cont_af+1;
							  $row2["arseniato_ferico"]=0;
							  $total_sacos2=$row2["arseniato_ferico"]+$row3["arseniato_ferico"]+$row4["arseniato_ferico"];
							  echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2</strong></font></td>\n";
							  echo "<td width='5%' align='center'></td>\n";
							  echo "<td width='4%' align='center'>".$row3["sales_niquel"]."</td>\n";
							  echo "<td width='4%' align='center'>".$row4["sales_niquel"]."</td>\n"; 
							  $cont_sn=$cont_sn+1;
							  $row2["sales_niquel"]=0;
							  $total_sacos3=$row2["sales_niquel"]+$row3["sales_niquel"]+$row4["sales_niquel"];
						      echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3</strong></font></td>\n";
						      $pasada='2';
							  $total_sc=$total_sc+$total_sacos1;
							  $total_af=$total_af+$total_sacos2;
							  $total_sn=$total_sn+$total_sacos3;
							  $cont_tur=$cont_tur+2;}
						  else if (($txt_turno=='B') and ($pasada2=='1'))
						          {$total_reactores=$row4["reactores2"];
								  $cont_reactor=$cont_reactor+1;
								  echo "<td width='7%' align='center'></td>\n";
								   echo "<td width='5%' align='center'></td>\n";
								   echo "<td width='5%' align='center'>".$row4["reactores2"]."</td>\n"; 
						           echo "<td width='10%' align='center' class='detalle01'>$total_reactores</td>\n";
								   echo "<td width='7%' align='center'></td>\n";
								   echo "<td width='5%' align='center'></td>\n";
								   echo "<td width='5%' align='center'>".$row4["sulfato_cobre"]."</td>\n"; 
								   $cont_sc=$cont_sc+1;
								   $row2["sulfato_cobre"]=0;
								   $row3["sulfato_cobre"]=0;
								   $total_sacos1=$row2["sulfato_cobre"]+$row3["sulfato_cobre"]+$row4["sulfato_cobre"];
            					   echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1</strong></font></td>\n";
								   echo "<td width='5%' align='center'></td>\n";
								   echo "<td width='5%' align='center'></td>\n";
	   							   echo "<td width='5%' align='center'>".$row4["arseniato_ferico"]."</td>\n";
								   $cont_af=$cont_af+1;
								   $row2["arseniato_ferico"]=0;
								   $row3["arseniato_ferico"]=0;
								   $total_sacos2=$row2["arseniato_ferico"]+$row3["arseniato_ferico"]+$row4["arseniato_ferico"];
							       echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2</strong></font></td>\n";								   
								   echo "<td width='5%' align='center'></td>\n";
								   echo "<td width='5%' align='center'></td>\n";
								   echo "<td width='4%' align='center'>".$row4["sales_niquel"]."</td>\n"; 
								   $cont_sn=$cont_sn+1;
	   							   $row2["sales_niquel"]=0;
								   $row3["sales_niquel"]=0;
								   $total_sacos3=$row2["sales_niquel"]+$row3["sales_niquel"]+$row4["sales_niquel"];
						           echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3</strong></font></td>\n";
								   $pasada2='2';
								   $total_r=$total_r+$total_reactores;
								   $total_sc=$total_sc+$total_sacos1;
							       $total_af=$total_af+$total_sacos2;
							       $total_sn=$total_sn+$total_sacos3;
								   $cont_tur=$cont_tur+1;}
						  else if (($txt_turno=='C') and ($pasada3=='1'))
						  			{$total_reactores=$row2["reactores2"]+$row3["reactores2"]+$row4["reactores2"];
									 $cont_reactor=$cont_reactor+1;
									 echo "<td width='7%' align='center'>".$row2["reactores2"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3["reactores2"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["reactores2"]."</td>\n";
						             echo "<td width='10%' align='center' class='detalle01'>$total_reactores</td>\n";
									 echo "<td width='7%' align='center'>".$row2["sulfato_cobre"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3["sulfato_cobre"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["sulfato_cobre"]."</td>\n";
									 $cont_sc=$cont_sc+1;
									 $total_sacos1=$row2["sulfato_cobre"]+$row3["sulfato_cobre"]+$row4["sulfato_cobre"];
						             echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1</strong></font></td>\n"; 
									 echo "<td width='5%' align='center'>".$row2["arseniato_ferico"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3["arseniato_ferico"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["arseniato_ferico"]."</td>\n"; 
									 $cont_af=$cont_af+1;
									 $total_sacos2=$row2["arseniato_ferico"]+$row3["arseniato_ferico"]+$row4["arseniato_ferico"];
							         echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2</strong></font></td>\n";								   
									 echo "<td width='5%' align='center'>".$row2["sales_niquel"]."</td>\n";
									 echo "<td width='5%' align='center'>".$row3["sales_niquel"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["sales_niquel"]."</td>\n";  
									 $cont_sn=$cont_sn+1;
									 $total_sacos3=$row2["sales_niquel"]+$row3["sales_niquel"]+$row4["sales_niquel"];
						             echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3</strong></font></td>\n";
									  $pasada3='2';
									  $total_r=$total_r+$total_reactores;
									  $total_sc=$total_sc+$total_sacos1;
							          $total_af=$total_af+$total_sacos2;
							          $total_sn=$total_sn+$total_sacos3;
									  $cont_tur=$cont_tur+3;}		     
						       else {
							         $total_reactores=$row2["reactores2"]+$row3["reactores2"]+$row4["reactores2"];
									  $cont_reactor=$cont_reactor+1;
									 echo "<td width='5%' align='center'>".$row2["reactores2"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3["reactores2"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["reactores2"]."</td>\n"; 
						             echo "<td width='10%' align='center' class='detalle01'>$total_reactores</td>\n";
							         echo "<td width='5%' align='center'>".$row2["sulfato_cobre"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3["sulfato_cobre"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["sulfato_cobre"]."</td>\n";
									 $cont_sc=$cont_sc+1;
									 $total_sacos1=$row2["sulfato_cobre"]+$row3["sulfato_cobre"]+$row4["sulfato_cobre"];
						             echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1</strong></font></td>\n"; 
									 echo "<td width='5%' align='center'>".$row2["arseniato_ferico"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3["arseniato_ferico"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["arseniato_ferico"]."</td>\n"; 
									 $cont_af=$cont_af+1;
									 $total_sacos2=$row2["arseniato_ferico"]+$row3["arseniato_ferico"]+$row4["arseniato_ferico"];
							         echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2</strong></font></td>\n";								   
									 echo "<td width='5%' align='center'>".$row2["sales_niquel"]."</td>\n";
									 echo "<td width='5%' align='center'>".$row3["sales_niquel"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["sales_niquel"]."</td>\n";  
									 $cont_sn=$cont_sn+1;
									 $total_sacos3=$row2["sales_niquel"]+$row3["sales_niquel"]+$row4["sales_niquel"];
						             echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3</strong></font></td>\n";
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
						 $mesm=substr($row_m["fecha_m"],5,2);
						 $diam=substr($row_m["fecha_m"],8,2);
						 $anom=substr($row_m["fecha_m"],0,4);
                         $fecham=$anom.'/'.$mesm.'/'.$diam; 
						 $consulta2="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						 $consulta2.="where fecha= '".$row_m["fecha_m"]."'  and turno='C' group by fecha";
						 $respuesta2 = mysqli_query($link, $consulta2);
						 $row2= mysqli_fetch_array($respuesta2);
						 $consulta3="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						 $consulta3.="where fecha= '".$row_m["fecha_m"]."'  and turno='A' group by fecha";
						 $respuesta3 = mysqli_query($link, $consulta3);
						 $row3= mysqli_fetch_array($respuesta3);
						 $consulta4="select distinct fecha,sum(reactores)as reactores2,sulfato_cobre,arseniato_ferico,sales_niquel from ref_web.pte ";
						 $consulta4.="where fecha= '".$row_m["fecha_m"]."'  and turno='B' group by fecha";
						 $respuesta4 = mysqli_query($link, $consulta4);
						 $row4= mysqli_fetch_array($respuesta4);
						 $pasada='1';
						 $pasada2='1';
						 $pasada3='1';
						 if ($txt_turno1=='A')
						     {  echo "<td width='5%' align='center'><font color='blue'>$fecham</font></td>\n";
							   $total_reactores=$row2["reactores2"]+$row3["reactores2"];
							   $cont_reactor=$cont_reactor+1;
							   $total_r=$total_r+$total_reactores;
							   echo "<td width='5%' align='center'>".$row2["reactores2"]."</td>\n"; 
							   echo "<td width='5%' align='center'>".$row3["reactores2"]."</td>\n";
							   echo "<td width='5%' align='center'></td>\n";
							   
						       echo "<td width='10%' align='center' class='detalle01'>$total_reactores</td>\n";
							   echo "<td width='5%' align='center'>".$row2["sulfato_cobre"]."</td>\n"; 
							   echo "<td width='5%' align='center'>".$row3["sulfato_cobre"]."</td>\n";
							   $cont_sc=$cont_sc+1; 
							   echo "<td width='5%' align='center'></td>\n";
							   $total_sacos1=$row2["sulfato_cobre"]+$row3["sulfato_cobre"];
						       echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1</strong></font></td>\n"; 
							   echo "<td width='5%' align='center'>".$row2["arseniato_ferico"]."</td>\n"; 
							   echo "<td width='5%' align='center'>".$row3["arseniato_ferico"]."</td>\n"; 
							   $cont_af=$cont_af+1;
							   echo "<td width='5%' align='center'></td>\n"; 
							   $total_sacos2=$row2["arseniato_ferico"]+$row3["arseniato_ferico"];
							   echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2</strong></font></td>\n";								   
							   echo "<td width='5%' align='center'>".$row2["sales_niquel"]."</td>\n";
							   echo "<td width='5%' align='center'>".$row3["sales_niquel"]."</td>\n"; 
							   $cont_sn=$cont_sn+1;
							   echo "<td width='5%' align='center'></td>\n";  
							   $total_sacos3=$row2["sales_niquel"]+$row3["sales_niquel"];
						       echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3</strong></font></td>\n";
							   $total_sc=$total_sc+$total_sacos1;
							   $total_af=$total_af+$total_sacos2;
							   $total_sn=$total_sn+$total_sacos3;
							   $cont_tur=$cont_tur+2;}
						 else if ($txt_turno1=='B')
						         {    echo "<td width='5%' align='center'><font color='blue'>$fecham</font></td>\n";
								     $total_reactores=$row2["reactores2"]+$row3["reactores2"]+$row4["reactores2"];
									 $cont_reactor=$cont_reactor+1;
									 $total_r=$total_r+$total_reactores;
									 echo "<td width='5%' align='center'>".$row2["reactores2"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3["reactores2"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["reactores2"]."</td>\n";
									 
						             echo "<td width='10%' align='center' class='detalle01'>$total_reactores</td>\n";
							         echo "<td width='5%' align='center'>".$row2["sulfato_cobre"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3["sulfato_cobre"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["sulfato_cobre"]."</td>\n";
									 $cont_sc=$cont_sc+1; 
									 $total_sacos1=$row2["sulfato_cobre"]+$row3["sulfato_cobre"]+$row4["sulfato_cobre"];
						             echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1</strong></font></td>\n"; 
									 echo "<td width='5%' align='center'>".$row2["arseniato_ferico"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row3["arseniato_ferico"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["arseniato_ferico"]."</td>\n"; 
									 $cont_af=$cont_af+1;
									 $total_sacos2=$row2["arseniato_ferico"]+$row3["arseniato_ferico"]+$row4["arseniato_ferico"];
							         echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2</strong></font></td>\n";								   
									 echo "<td width='5%' align='center'>".$row2["sales_niquel"]."</td>\n";
									 echo "<td width='5%' align='center'>".$row3["sales_niquel"]."</td>\n"; 
									 echo "<td width='5%' align='center'>".$row4["sales_niquel"]."</td>\n";  
									 $cont_sn=$cont_sn+1;
									 $total_sacos3=$row2["sales_niquel"]+$row3["sales_niquel"]+$row4["sales_niquel"];
						             echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3</strong></font></td>\n";
									  $total_sc=$total_sc+$total_sacos1;
							         $total_af=$total_af+$total_sacos2;
							         $total_sn=$total_sn+$total_sacos3;
									 $cont_tur=$cont_tur+3;}
						 else if ($txt_turno1=='C')
						          {   echo "<td width='5%' align='center'><font color='blue'>$fecham</font></td>\n";
								      $cont_reactor=$cont_reactor+1;
								     $total_reactores=$row2["reactores2"]+$row3["reactores2"]+$row4["reactores2"];
									 $total_r=$total_r+$total_reactores;
									 echo "<td width='5%' align='center'>".$row2["reactores2"]."</td>\n"; 
									 echo "<td width='5%' align='center'></td>\n"; 
									 echo "<td width='5%' align='center'></td>\n";
									 
						             echo "<td width='10%' align='center' class='detalle01'>$total_reactores</td>\n";
							         echo "<td width='5%' align='center'>".$row2["sulfato_cobre"]."</td>\n"; 
									 echo "<td width='5%' align='center'></td>\n"; 
									 echo "<td width='5%' align='center'></td>\n";
									 $cont_sc=$cont_sc+1; 
									 $total_sacos1=$row2["sulfato_cobre"];
						             echo "<td width='8%' align='center' class='detalle01'><font color='green'><strong>$total_sacos1</strong></font></td>\n"; 
									 echo "<td width='5%' align='center'>".$row2["arseniato_ferico"]."</td>\n"; 
									 echo "<td width='5%' align='center'></td>\n"; 
									 echo "<td width='5%' align='center'></td>\n";
									 $cont_af=$cont_af+1;  
									 $total_sacos2=$row2["arseniato_ferico"];
							         echo "<td width='6%' align='center' class='detalle01'><font color='green' ><strong>$total_sacos2</strong></font></td>\n";								   
									 echo "<td width='5%' align='center'>".$row2["sales_niquel"]."</td>\n";
									 echo "<td width='5%' align='center'></td>\n"; 
									 echo "<td width='5%' align='center'></td>\n";
									 $cont_sn=$cont_sn+1;   
									 $total_sacos3=$row2["sales_niquel"];
						             echo "<td width='10%' align='center'  class='detalle01'><font color='green'><strong>$total_sacos3</strong></font></td>\n";
									 $total_sc=$total_sc+$total_sacos1;
							         $total_af=$total_af+$total_sacos2;
							         $total_sn=$total_sn+$total_sacos3;
									 $cont_tur=$cont_tur+1;}		 	   
								  echo "</tr>\n";			 
					}
					echo "<td align='center'><font color='blue'>Totales&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
					echo "<td align='center'><font color='blue'>&nbsp</font></td>\n";
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
		  
        <table width="969" height="40" border="2" align="left">
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <td width="6%"><strong>Promedios</strong></td>
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
			else {$promedio_r=$total_r/ $cont_tur;
			      $promedio_r=number_format($promedio_r,"2",",",""); }    
		?>
            <td width='15%' align='center'></td>
            <td width='10%' align='center'><?php echo $promedio_r ?> ciclo/turno</td>
            <td width='15%' align='right'></td>
            <td width='9%' align='center'><?php echo $promedio_sc ?> s/turno</td>
            <td width='12%' align='right'></td>
            <td width='9%' align='center'><?php echo $promedio_af ?>s/turno</td>
            <td width='14%' align='right'></td>
            <td width='15%' align='center'><?php echo $promedio_sn ?> s/turno</td>
          </tr>
        </table>
        <p></p>
        <table width="55%" height="62" border="2" bordercolor="#0000FF" align="center">
          <tr> 
            <td colspan="2" bgcolor="#FFFFFF" class="ColorTabla01">Volumen 
              Electrolito</td>
            <td colspan="2" rowspan="2" bgcolor="#FFFFFF"> <div align="left"><strong>Carga 
                Reactor</strong></div></td>
            <td colspan="8" rowspan="2" bgcolor="#FFFFFF"> <div align="left"><strong>Razon 
                Prod. Sulfato de Cobre</strong></div></td>
            <td width="36%" rowspan="2" bgcolor="#FFFFFF"><strong>Elect. Tratado</strong></td>
          </tr>
          <tr> 
            <td width="12%" bgcolor="#FFFFFF" class="Detalle02"><strong>INT. I.</strong></td>
            <td width="9%" align="center" bgcolor="#FFFFFF" class="Detalle02">--</td>
          </tr>
          <tr bordercolor="#0000FF"> 
            <td bgcolor="#FFFFFF" class="Detalle02"><strong>INT. F.</strong></td>
            <td bgcolor="#FFFFFF" align="center" class="Detalle02">--</td>
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
            <td width="11%" bgcolor="#FFFFFF"><?php echo number_format($total_x/$cont_tur,"2",".",".");?>m3/turno</td>
          </tr>
          <tr> 
            <td bordercolor="#0000FF" bgcolor="#FFFFFF" class="Detalle02"><strong>Total 
              Procesado</strong></td>
            <?php
              echo "<td bordercolor='#0000FF' bgcolor='#FFFFFF' align='center' class='Detalle02'>$total_x</td>";
			?>
            <?php
			
            echo "<td colspan='2' bordercolor='#000000' bgcolor='#FFFFFF'></td>";
			?>
            <td colspan="8" bordercolor="#0000FF" bgcolor="#FFFFFF"></td>
            <td width="4%" bordercolor="#0000FF" bgcolor="#FFFFFF"></td>
          </tr>
        </table>
        <p></p>
        <table width="49%" height="48" border="0" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle" align="center">
          <tr class="ColorTabla01"> 
            <td width="27%" height="24" rowspan="2"> <div align="center"><strong>DESTINO</strong></div></td>
            <td colspan="7"><div align="center"><strong> CIRCUITO ORIGEN</strong></div></td>
          </tr>
          <tr class="ColorTabla01"> 
            <td width="12%"><div align="center"><strong>C1</strong></div></td>
            <td width="12%"><div align="center"><strong>C2</strong></div></td>
            <td width="12%"><div align="center"><strong>C3</strong></div></td>
            <td width="12%"><div align="center"><strong>C4</strong></div></td>
            <td width="12%"><div align="center"><strong>C5</strong></div></td>
            <td width="12%"><div align="center"><strong>C6</strong></div></td>
			<td width="12%"><div align="center"><strong>Total</strong></div></td>
          </tr>
        </table>
        <table width="49%" border="2" align="center">
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <?php
		            $consulta_circuito="select valor_subclase1,nombre_subclase from proyecto_modernizacion.sub_clase where cod_clase='3100' and valor_subclase1<='6' "; 
					$respuesta_circuito= mysqli_query($link, $consulta_circuito);
					$total_electrolito=0;
					$total_dp=0;
					/*************** WSO **************************/
					$row_elect_descuento_ter_proceso=array();
					$row_elect_descuento_ter_venta=array();
					//$row_elect_inicio_ter_proceso=array();
					$row_dp_total_fin=array();   
					$total_d_parcial_venta_c1 = 0;
					$total_d_parcial_venta_c2 = 0;
					$total_d_parcial_venta_c3 = 0;
					$total_d_parcial_venta_c4 = 0;
					$total_d_parcial_venta_c5 = 0;
					$total_d_parcial_venta_c6 = 0;
					$total_d_parcial_proceso_c1 = 0;
					$total_d_parcial_proceso_c2 = 0;
					$total_d_parcial_proceso_c3 = 0;
					$total_d_parcial_proceso_c4 = 0;
					$total_d_parcial_proceso_c5 = 0;
					$total_d_parcial_proceso_c6 = 0;		
					$total_dp_c1 = 0;
					$total_dp_c2 = 0;
					$total_dp_c3 = 0;
					$total_dp_c4 = 0;
					$total_dp_c5 = 0;
					$total_dp_c6 = 0;
					$total_c1 = 0;
					$total_c2 = 0;
					$total_c3 = 0;
					$total_c4 = 0;
					$total_c5 = 0;
					$total_c6 = 0;
					/**********************************************/
					while ($row_c= mysqli_fetch_array($respuesta_circuito))
					       {
	                    	    $consulta_elect_total_proceso="select sum(volumen_pte) as volumen_pte_total from ref_web.tratamiento_electrolito";
						        $consulta_elect_total_proceso.= " where fecha  between '".$FechaInicio."' and '".$FechaTermino."' and turno  in ('C','A','B') and destino_pte='Proceso' ";
					            $consulta_elect_total_proceso.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
						        $respuesta_elect_total_proceso = mysqli_query($link, $consulta_elect_total_proceso);
		                        $row_elect_total_proceso= mysqli_fetch_array($respuesta_elect_total_proceso);
								$consulta_elect_total_venta="select sum(volumen_pte) as volumen_pte_total from ref_web.tratamiento_electrolito";
						        $consulta_elect_total_venta.= " where fecha  between '".$FechaInicio."' and '".$FechaTermino."' and turno  in ('C','A','B') and destino_pte='Venta' ";
					            $consulta_elect_total_venta.= " and circuito_pte='".$row_c["nombre_subclase"]."' ";
						        $respuesta_elect_total_venta = mysqli_query($link, $consulta_elect_total_venta);
		                        $row_elect_total_venta= mysqli_fetch_array($respuesta_elect_total_venta);
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
									  $consulta_elect_descuento_inicio_proceso="select sum(volumen_pte) as volumen_pte_inicio from ref_web.tratamiento_electrolito";
									  $consulta_elect_descuento_inicio_proceso.= " where fecha ='".$FechaInicio."' and turno  in ('".$turnos_desc_inicio."') and destino_pte='Proceso'";
									  $consulta_elect_descuento_inicio_proceso.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									  $respuesta_elect_descuento_inicio_proceso= mysqli_query($link, $consulta_elect_descuento_inicio_proceso);
									  $row_elect_descuento_inicio_proceso= mysqli_fetch_array($respuesta_elect_descuento_inicio_proceso);
									  $consulta_elect_descuento_inicio_venta="select sum(volumen_pte) as volumen_pte_inicio from ref_web.tratamiento_electrolito";
									  $consulta_elect_descuento_inicio_venta.= " where fecha ='".$FechaInicio."' and turno  in ('".$turnos_desc_inicio."') and destino_pte='Venta'";
									  $consulta_elect_descuento_inicio_venta.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									  $respuesta_elect_descuento_inicio_venta = mysqli_query($link, $consulta_elect_descuento_inicio_venta);
									  $row_elect_descuento_inicio_venta= mysqli_fetch_array($respuesta_elect_descuento_inicio_venta);
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
									 $consulta_elect_descuento_ter_proceso="select sum(volumen_pte) as volumen_pte_ter from ref_web.tratamiento_electrolito";
									 $consulta_elect_descuento_ter_proceso.= " where fecha ='".$FechaTermino."' and turno  in ('".$turnos_desc_fin."') and destino_pte='Proceso'";
									 $consulta_elect_descuento_ter_proceso.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									 $respuesta_elect_descuento_ter_proceso = mysqli_query($link, $consulta_elect_descuento_ter_proceso);
									 $row_elect_descuento_ter_proceso= mysqli_fetch_array($respuesta_elect_descuento_ter_proceso);
									 $consulta_elect_descuento_ter_venta="select sum(volumen_pte) as volumen_pte_ter from ref_web.tratamiento_electrolito";
									 $consulta_elect_descuento_ter_venta.= " where fecha ='".$FechaTermino."' and turno  in ('".$turnos_desc_fin."') and destino_pte='Venta'";
									 $consulta_elect_descuento_ter_venta.= " and circuito_pte='".$row_c["nombre_subclase"]."'";
									 $respuesta_elect_descuento_ter_venta = mysqli_query($link, $consulta_elect_descuento_ter_venta);
									 $row_elect_descuento_ter_venta= mysqli_fetch_array($respuesta_elect_descuento_ter_venta);
									} 
								$total_electrolito=0;	

								$volumen_pte_ter_proceso    = isset($row_elect_descuento_ter_proceso["volumen_pte_ter"])?$row_elect_descuento_ter_proceso["volumen_pte_ter"]:0;   
							    $volumen_pte_ter_venta      = isset($row_elect_descuento_ter_venta["volumen_pte_ter"])?$row_elect_descuento_ter_venta["volumen_pte_ter"]:0;
								$volumen_pte_total_proceso  = isset($row_elect_total_proceso["volumen_pte_total"])?$row_elect_total_proceso["volumen_pte_total"]:0;
								$volumen_pte_total          = isset($row_elect_total_venta["volumen_pte_total"])?$row_elect_total_venta["volumen_pte_total"]:0;

								$total_electrolito = ($volumen_pte_total_proceso + $volumen_pte_total) -($row_elect_descuento_inicio_proceso["volumen_pte_inicio"]+$row_elect_descuento_inicio_venta["volumen_pte_inicio"])-($volumen_pte_ter_proceso + $volumen_pte_ter_venta);

								//$total_electrolito=($row_elect_total_proceso["volumen_pte_total"]+$row_elect_total_venta["volumen_pte_total"])-($row_elect_descuento_inicio_proceso["volumen_pte_inicio"]+$row_elect_descuento_inicio_venta["volumen_pte_inicio"])-($row_elect_descuento_ter_proceso["volumen_pte_ter"]+$row_elect_descuento_ter_venta["volumen_pte_ter"]);
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
						
							$total_desc_parcial_ini = isset($row_dp_total_ini["total_desc_parcial_ini"])?$row_dp_total_ini["total_desc_parcial_ini"]:0;
							$total_desc_parcial_fin = isset($row_dp_total_fin["total_desc_parcial_fin"])?$row_dp_total_fin["total_desc_parcial_fin"]:0;
							//$volumen_pte_total  = isset($row_elect_total_venta["volumen_pte_total"])?$row_elect_total_venta["volumen_pte_total"]:0;
							$volumen_pte_inicio = isset($row_elect_descuento_ter_venta["volumen_pte_inicio"])?$row_elect_descuento_ter_venta["volumen_pte_inicio"]:0;
							$volumen_pte_ter    = isset($row_elect_descuento_inicio_venta["volumen_pte_ter"])?$row_elect_descuento_inicio_venta["volumen_pte_ter"]:0;
							//$volumen_pte_total_proceso  = isset($row_elect_total_proceso["volumen_pte_total"])?$row_elect_total_proceso["volumen_pte_total"]:0;
							$volumen_pte_inicio_proceso = isset($row_elect_descuento_ter_proceso["volumen_pte_inicio"])?$row_elect_descuento_ter_proceso["volumen_pte_inicio"]:0;
							$volumen_pte_ter_proceso    = isset($row_elect_descuento_inicio_proceso["volumen_pte_ter"])?$row_elect_descuento_inicio_proceso["volumen_pte_ter"]:0;
							
							$total_desc_parcial  = isset($row_dp_total["total_desc_parcial"])?$row_dp_total["total_desc_parcial"]:0;
								
								
							$total_dp=0;	
							$total_dp = $total_desc_parcial - $total_desc_parcial_ini - $total_desc_parcial_fin;
							//$total_dp=$row_dp_total["total_desc_parcial"]-$row_dp_total_ini["total_desc_parcial_ini"]-$row_dp_total_fin["total_desc_parcial_fin"];
							/***************************************************************************************************************/
						 	 if ($row_c["nombre_subclase"]=='Circuito1')
							     {
									$total_c1 = $total_c1+($total_electrolito + $total_dp);
									$total_d_parcial_venta_c1   = $total_d_parcial_venta_c1 + $volumen_pte_total - $volumen_pte_inicio - $volumen_pte_ter;
									$total_d_parcial_proceso_c1 = $total_d_parcial_proceso_c1 + $volumen_pte_total_proceso - $volumen_pte_inicio_proceso - $volumen_pte_ter_proceso;								 
									$total_dp_c1 = $total_dp_c1 + $total_desc_parcial - $total_desc_parcial_ini - $total_desc_parcial_fin;

								}
							 else if ($row_c["nombre_subclase"]=='Circuito2')
									{
										$total_c2 = $total_c2+($total_electrolito + $total_dp);
										$total_d_parcial_venta_c2 = $total_d_parcial_venta_c2 + $volumen_pte_total - $volumen_pte_inicio - $volumen_pte_ter;
										$total_d_parcial_proceso_c2 = $total_d_parcial_proceso_c2 + $volumen_pte_total_proceso - $volumen_pte_inicio_proceso - $volumen_pte_ter_proceso;
										$total_dp_c2 = $total_dp_c2 + $total_desc_parcial - $total_desc_parcial_ini - $total_desc_parcial_fin;
									}
							      else if ($row_c["nombre_subclase"]=='Circuito3')
									      {
											$total_c3 = $total_c3+($total_electrolito + $total_dp);
											$total_d_parcial_venta_c3   = $total_d_parcial_venta_c3 + $volumen_pte_total - $volumen_pte_inicio - $volumen_pte_ter;
											$total_d_parcial_proceso_c3 = $total_d_parcial_proceso_c3 + $volumen_pte_total_proceso - $volumen_pte_inicio_proceso - $volumen_pte_ter_proceso;
											$total_dp_c3 = $total_dp_c3 + $total_desc_parcial - $total_desc_parcial_ini - $total_desc_parcial_fin;								 
										  }
								       else if ($row_c["nombre_subclase"]=='Circuito4')
									           {
											    $total_c4    = $total_c4 + ($total_electrolito + $total_dp);
												$total_d_parcial_venta_c4   = $total_d_parcial_venta_c4 + $volumen_pte_total - $volumen_pte_inicio - $volumen_pte_ter;
                                                $total_d_parcial_proceso_c4 = $total_d_parcial_proceso_c4 + $volumen_pte_total_proceso - $volumen_pte_inicio_proceso - $volumen_pte_ter_proceso;					 
												$total_dp_c4 = $total_dp_c4 + $total_desc_parcial - $total_desc_parcial_ini - $total_desc_parcial_fin;
											   }
										    else if ($row_c["nombre_subclase"]=='Circuito5')
									               {
													$total_c5 = $total_c5 + ($total_electrolito + $total_dp);
													$total_d_parcial_venta_c5   = $total_d_parcial_venta_c5 + $volumen_pte_total - $volumen_pte_inicio - $volumen_pte_ter;
												   // $total_d_parcial_proceso_c5 = $total_d_parcial_proceso_c5 + $volumen_pte_total_proceso - $volumen_pte_inicio_proceso - $row_elect_inicio_ter_proceso["volumen_pte_ter"];	
													$total_d_parcial_proceso_c5 = $total_d_parcial_proceso_c5 + $volumen_pte_total_proceso - $volumen_pte_inicio_proceso - $volumen_pte_ter_proceso;								 
													$total_dp_c5 = $total_dp_c5 + $total_desc_parcial - $total_desc_parcial_ini - $total_desc_parcial_fin;
												   }	
												  else if ($row_c["nombre_subclase"]=='Circuito6')
									                      {
															$total_c6=$total_c6+($total_electrolito + $total_dp);
															$total_d_parcial_venta_c6   = $total_d_parcial_venta_c6 + $volumen_pte_total - $volumen_pte_inicio - $volumen_pte_ter;
															$total_d_parcial_proceso_c6 = $total_d_parcial_proceso_c6 + $volumen_pte_total_proceso - $volumen_pte_inicio_proceso - $volumen_pte_ter_proceso;								 
															$total_dp_c6 = $total_dp_c6 + $total_desc_parcial - $total_desc_parcial_ini - $total_desc_parcial_fin;
														  }    
						   }
		  ?>
            <td width="27%"><strong>D. Parcial</strong></td>
            <td width="12%" align="center"><?php echo $total_dp_c1; ?></td>
            <td width="12%" align="center"><?php echo $total_dp_c2; ?></td>
            <td width="12%" align="center"><?php echo $total_dp_c3; ?></td>
            <td width="12%" align="center"><?php echo $total_dp_c4; ?></td>
            <td width="12%" align="center"><?php echo $total_dp_c5; ?></td>
            <td width="12%" align="center"><?php echo $total_dp_c6; ?></td>
			<td width="12%" align="center"><?php echo $total_dp_c1+$total_dp_c2+$total_dp_c3+$total_dp_c4+$total_dp_c5+$total_dp_c6; ?></td>
			
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <td width="27%"><strong>Proceso Pte.</strong></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c1; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c2; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c3; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c4; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c5; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c6; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_proceso_c1+$total_d_parcial_proceso_c2+$total_d_parcial_proceso_c3+$total_d_parcial_proceso_c4+$total_d_parcial_proceso_c5+$total_d_parcial_proceso_c6; ?></td>
          </tr>
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <td width="27%"><strong>Venta</strong></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c1; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c2; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c3; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c4; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c5; ?></td>
            <td width="12%" align="center"><?php echo $total_d_parcial_venta_c6; ?></td>
			<td width="12%" align="center"><?php echo $total_d_parcial_venta_c1+$total_d_parcial_venta_c2+$total_d_parcial_venta_c3+$total_d_parcial_venta_c4+$total_d_parcial_venta_c5+$total_d_parcial_venta_c6; ?></td>
          </tr>
          <tr bordercolor="#0000FF" bgcolor="#FFFFFF"> 
            <td width="27%"><strong>Total</strong></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c1+$total_d_parcial_venta_c1+$total_d_parcial_proceso_c1; ?></strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c2+$total_d_parcial_venta_c2+$total_d_parcial_proceso_c2; ?></strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c3+$total_d_parcial_venta_c3+$total_d_parcial_proceso_c3; ?></strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c4+$total_d_parcial_venta_c4+$total_d_parcial_proceso_c4; ?></strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c5+$total_d_parcial_venta_c5+$total_d_parcial_proceso_c5; ?></strong></font></td>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_dp_c6+$total_d_parcial_venta_c6+$total_d_parcial_proceso_c6; ?></strong></font></td>
			<?php $total_circuitos=$total_dp_c1+$total_d_parcial_venta_c1+$total_d_parcial_proceso_c1+$total_dp_c2+$total_d_parcial_venta_c2+$total_d_parcial_proceso_c2+$total_dp_c3+$total_d_parcial_venta_c3+$total_d_parcial_proceso_c3+$total_dp_c4+$total_d_parcial_venta_c4+$total_d_parcial_proceso_c4+$total_dp_c5+$total_d_parcial_venta_c5+$total_d_parcial_proceso_c5+$total_dp_c6+$total_d_parcial_venta_c6+$total_d_parcial_proceso_c6;?>
            <td width="12%" align="center"><font color='#FF0000'><strong><?php echo $total_circuitos;?></strong></font></td>
          </tr>
        </table>
		  <p></p>
          <table width="954"  border="1" cellpadding="0" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
            <tr class="ColorTabla01"> 
              <td colspan="3" ><div align="center"><font color="#FFFFFF"><strong>Novedades 
                  Relevantes </strong></font></div></td>
            </tr>
            <tr class="ColorTabla01"> 
              <td width="124" align="center"><strong>fecha</strong></td>
              <td width="88" align="center"><strong>Turno</strong></td>
              <td width="720" align="center"><strong>Observacion</strong></td>
            </tr>
			<?php $consulta="select * from ref_web.novedades_jefe_pte where fecha between '".$FechaInicio."' and '".$FechaTermino."' and pte='S' order by fecha";
			   //echo $consulta;
			   $respuesta = mysqli_query($link, $consulta);
 		       while ($row= mysqli_fetch_array($respuesta))
			        {
					   echo '<tr>';
					   echo '<td width="106" align="center" class="detalle01">'.$row["FECHA"].'</td>';
                       echo '<td width="88" align="center" >'.$row["TURNO"].'</td>';
                       echo '<td width="519" align="left" >'.$row["NOVEDAD"].'</td>';
					   echo '</tr>';
					
					
					}
			
			
			
			?>
          </table>
		  </div></td>
    </tr>
    <tr>

	<td height="30" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif">
        <input name="btnimprimir" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir(this.form)">
        <?php
	  		//Campo oculto.
			echo '<input name="opcion" type="hidden" size="40" value="'.$opcion.'">';
	  	?>
        <input type="button" name="btnexcel3" value="Excel" style="width:70" onClick="Excel()" title="Ejecutar Planilla Excel con datos de informes">
        <input name="btnsalir" type="button" style="width:70" value="Salir" onClick="Salir()">
        </font></div></td>
		  </tr>
    <tr> 
	  <td height="40" align="center" valign="middle"> <font face="Arial, Helvetica, sans-serif"> 
        </font><br>

 <?php /*include("../principal/pie_pagina.php");*/ ?>
  <font face="Arial, Helvetica, sans-serif"> 
  </font> <font face="Arial, Helvetica, sans-serif"> </font><font face="Arial, Helvetica, sans-serif"> 
  </font> 
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

