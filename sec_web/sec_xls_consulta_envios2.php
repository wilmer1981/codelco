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

 	$CodigoDeSistema = 3;
	$CodigoDePantalla =28;
	include("../principal/conectar_sec_web.php");
		$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		//$Mostrar ='S';	
		$Orden  = isset($_REQUEST["Orden"])?$_REQUEST["Orden"]:"";
		$Mostrar= isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"S";
		$CmbMes = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date('m');
		$CmbAno = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date('Y');
?>
<html>
<head>

<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<form name="FrmProceso" method="post" action="">
    <table width="1000" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" left="5">
      <tr>
      <td width="883" align="left"> 
        <br>
		<br>
        <table width="1000" height="20" border="1" cellpadding="3" cellspacing="0">
          <tr> 
            <!--<td width="20"><div align="left"></div></td>-->
            <td width="31"align="center">Envio</td>
            <td width="46" align="left"><div align="center">I.E.</div></td>
            <td width="80" align="left"><div align="center">Eta.Programa</div></td>
            <td width="39" align="left"><div align="left">Num.Lote</div></td>
            <td width="26" align="left"><div align="left">Cant</div></td>
            <td width="30" align="left"><div align="left">Peso</div></td>
            <td width="46"><div align="center"></div>
              <div align="center">Marca Lote</div></td>
            <td width="56"><div align="center">Cliente</div></td>
            <td width="67" align="left"><div align="left">Sub Producto</div></td>
           <td width="48" align="rigth"><div align="right">Contrato</div></td>
		   <td width="41" align="rigth"><div align="right">Cuota</div></td>
		    <td width="60" align="rigth"><div align="right">Tipo.Contr.</div></td>
		   <td width="50" align="rigth"><div align="right">Nave</div></td>
            <td width="53" align="rigth"><div align="right">Paq.Desp</div></td>
            <td width="59"><div align="right">Peso.Desp</div></td>
           <td width="40">Cert</td>
           <td width="54"><div align="center">F.Confirmacion</div></td>
		   <td width="74"><div align="center">Usuario</div></td>
          </tr>
       <!-- </table>-->
        <?php
			if ($Mostrar=='S')
			{
				if (strlen($CmbMes)==1)
				{
					$CmbMes="0".$CmbMes;
				}
				$Fecha_Envio=$CmbAno."-".$CmbMes;
			
				//echo "<table width='876' border='1' cellpadding='1' cellspacing='0' class='tablainterior'>";
				$Consulta="SELECT * from sec_web.embarque_ventana t1 ";
				$Consulta.=" where t1.tipo <> 'V' and substring(t1.fecha_envio,1,7) ='".$Fecha_Envio."'	";
				if ($Orden=='PorEnvio')
				{
				$Consulta.="	order by  t1.num_envio desc ";
				}
				else
				{
					$Consulta.="	order by  t1.corr_enm desc ";
				}
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				$Cont=0;
				$Cont2=0;//WSO
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					
					$Cont++;
					$Guias="";
					$FechaDespacho="";
					$Usuario="";
					$FechaConf="";
					if($Cont=='1') 
					echo "<tr bgcolor='#FFFFFF'>"; 
					else
					echo "<tr bgcolor='#CCCCCC'>"; 
					//echo "<td width='18'><input name='checkbox' type='checkbox'  value='".$Fila["corr_enm"]."'></td>";
					echo "<td width='40' align='center'>".$Fila["num_envio"]."</td>";
					$Cont2++;
					$Consulta="SELECT * from sec_web.guia_despacho_emb where num_envio='".$Fila["num_envio"]."' ";
					$Consulta.=" and corr_enm='".$Fila["corr_enm"]."' and cod_estado != 'A'";
					//echo "CC".$Consulta;
					$Respuesta1=mysqli_query($link, $Consulta);  
					while($Fila1=mysqli_fetch_array($Respuesta1))
					{
						$Guias=$Guias.$Fila1["num_guia"]."-";
						$FechaDespacho=$Fila1["fecha_guia"];	
					}
					echo "<td width='46' onMouseOver='JavaScript:muestra(".$Cont2.");' onMouseOut='JavaScript:oculta(".$Cont2.");'>";
					echo "<div id='Txt".$Cont2."' style= 'position:Absolute; background-color:#fff4cf; visibility:hidden; border:solid 1px Black;width:350px'>\n";
					echo "</div>".$Fila["corr_enm"]."&nbsp;</td>";
					echo "<td width='80'>".$Fila["fecha_programacion"]."</td>";
				//	echo "<td width='60' align='center'>".$Fila["cod_bulto"]."','".$Fila["num_bulto"]."','".$Fila["corr_enm"]."')\">\n";
					echo "<td width='60' align='center'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."</td>";
					//echo "<td width='45' align='center'>".$Fila["cod_bulto"]."-".$Fila["num_bulto"]."</td>";
					echo "<td width='44' align='center'>".$Fila["bulto_paquetes"]."</td>";
					echo "<td width='41' align='center'>".$Fila["bulto_peso"]."&nbsp;</td>";
					$Consulta="SELECT distinct t1.cod_marca,t2.descripcion from sec_web.lote_catodo t1 ";   
					$Consulta.="inner join sec_web.marca_catodos t2 on t1.cod_marca=t2.cod_marca ";
					$Consulta.=" where corr_enm='".$Fila["corr_enm"]."' and cod_bulto='".$Fila["cod_bulto"]."' and num_bulto='".$Fila["num_bulto"]."'	";
					$Respuesta4=mysqli_query($link, $Consulta);
					$Fila4=mysqli_fetch_array($Respuesta4);
					if(!is_null($Fila4) && is_array($Fila4) && isset($Fila4["descripcion"])){
						$descrip= $Fila4["descripcion"];
					}else{
						$descrip= "";
					}
					//echo "<td width='74' align='center'>".$Fila4["descripcion"]."&nbsp;</td>";
					echo "<td width='74' align='center'>".$descrip."&nbsp;</td>";
					$Consulta="SELECT * from sec_web.nave where cod_nave ='".$Fila["cod_cliente"]."'";
					$Respuesta2=mysqli_query($link, $Consulta);
					if($Fila2=mysqli_fetch_array($Respuesta2))
					{
						$Cliente=$Fila2["nombre_nave"];
					}
					else
					{
						$Consulta="SELECT * from sec_web.cliente_venta where cod_cliente ='".$Fila["cod_cliente"]."'";
						$Respuesta2=mysqli_query($link, $Consulta);
						if($Fila2=mysqli_fetch_array($Respuesta2))
						{
							$Cliente=$Fila2["sigla_cliente"];
						}
					}
					echo "<td width='99' align='center'>".$Cliente."&nbsp;</td>";
					$Consulta="SELECT abreviatura from proyecto_modernizacion.subproducto where cod_producto='".$Fila["cod_producto"]."' ";
					$Consulta.=" and cod_subproducto='".$Fila["cod_subproducto"]."'	";
					$Respuesta6=mysqli_query($link, $Consulta);
					$Fila6=mysqli_fetch_array($Respuesta6);
					echo "<td width='90' align='left'>".$Fila6["abreviatura"]."&nbsp;</td>";
					$Consulta="SELECT cod_contrato,mes_cuota from sec_web.programa_enami where corr_enm='".$Fila["corr_enm"]."'";
					$Respuesta7=mysqli_query($link, $Consulta);
					if($Fila7=mysqli_fetch_array($Respuesta7))
					{
						echo "<td width='48' align='center'>".$Fila7["cod_contrato"]."&nbsp;</td>";
						echo "<td width='41' align='center'>".$Fila7["mes_cuota"]."&nbsp;</td>";
						echo "<td width='41' align='center'>VTA ENM</td>";				
					}
					else
					{
						$Consulta="SELECT cod_contrato,mes_cuota from sec_web.programa_codelco where corr_codelco='".$Fila["corr_enm"]."'";
						$Respuesta7=mysqli_query($link, $Consulta);
						if($Fila7=mysqli_fetch_array($Respuesta7))
						{
							echo "<td width='48' align='center'>".$Fila7["cod_contrato"]."&nbsp;</td>";
							echo "<td width='41' align='center'>".$Fila7["mes_cuota"]."&nbsp;</td>";
						}
						else
						{
							echo "<td width='48' align='center'>&nbsp;</td>";
							echo "<td width='41' align='center'>&nbsp;</td>";
						}
						$Consulta="SELECT cod_contrato_maquila from sec_web.programa_codelco where corr_codelco='".$Fila["corr_enm"]."' ";
						$Respuesta9=mysqli_query($link, $Consulta);
						$Fila9=mysqli_fetch_array($Respuesta9);
						echo "<td width='60' align='center'>".$Fila9["cod_contrato_maquila"]."&nbsp;</td>";
					}
					$Consulta="SELECT nombre_nave from sec_web.nave where cod_nave='".$Fila["cod_nave"]."'";
					$Respuesta8=mysqli_query($link, $Consulta);
					if($Fila8=mysqli_fetch_array($Respuesta8))
					{
						echo "<td width='60' align='center'>".$Fila8["nombre_nave"]."</td>";
					}
					else
					{
						echo "<td width='60' align='center'>&nbsp;</td>";
					}
					echo "<td width='55' align='center'>".$Fila["despacho_paquetes"]."&nbsp;</td>";
					echo "<td width='59' align='center'>".$Fila["despacho_peso"]."&nbsp;</td>";
					$Consulta="SELECT distinct num_certificado from sec_web.certificacion_catodos ";
					$Consulta.=" where corr_enm='".$Fila["corr_enm"]."' and year(fecha)= '".$CmbAno."' ";
					$Respuesta4=mysqli_query($link, $Consulta);
					//echo $Consulta."<br>";
					if($Fila4=mysqli_fetch_array($Respuesta4))
					{
						//echo "<td width='69' align='center'><a href=\"JavaScript:Certificado('".$Fila4["num_certificado"]."','".$Fila["corr_enm"]."')\">\n";
						echo "<td width='69' align='center'>".$Fila4["num_certificado"]."</td>\n";
					}
					else  
					{
						echo "<td width='69' align='center'>&nbsp;</td>";
					}
					$Consulta="SELECT t1.usuario,t1.fecha_confirmacion,t2.nombres,t2.apellido_paterno from sec_web.programa_codelco t1 ";
					$Consulta.=" inner join proyecto_modernizacion.funcionarios t2 on t1.usuario =t2.rut 	";
					$Consulta.=" where t1.corr_codelco='".$Fila["corr_enm"]."'  and not isnull(t1.usuario) ";
					$Respuesta5=mysqli_query($link, $Consulta);
					//echo $Consulta."<br>";
					if($Fila5=mysqli_fetch_array($Respuesta5))
					{
						$FechaConf=$Fila5["fecha_confirmacion"];
						$Usuario=substr($Fila5["nombres"],0,1)." ".$Fila5["apellido_paterno"];	
					}
					else
					{
						$Consulta="SELECT usuario,fecha_confirmacion,t2.nombres,t2.apellido_paterno from sec_web.programa_enami t1";
						$Consulta.=" inner join proyecto_modernizacion.funcionarios t2 on t1.usuario =t2.rut 	";
						$Consulta.=" where corr_enm='".$Fila["corr_enm"]."'  and not isnull(usuario) ";
						//echo $Consulta."<br>";
						$Respuesta6=mysqli_query($link, $Consulta);
						$Fila6=mysqli_fetch_array($Respuesta6);
						//$FechaConf=substr($Fila6["fecha_confirmacion"],0,10);
						$FechaConf=$Fila6["fecha_confirmacion"];
						$Usuario=substr($Fila6["nombres"],0,1)." ".$Fila6["apellido_paterno"];	
					}
					echo "<td width='100' align='center'>".$FechaConf."&nbsp;</td>";				
					echo "<td width='100' align='center'>".$Usuario."&nbsp;</td>";
					echo "</tr>";
					
					if($Cont=='2')
						$Cont=0;
				}
				echo "</table>";	
				$Guias="";
			}
		?>
   <!--   </td>
  </tr>-->
</table>
  </form>
  </center>
</body>
</html>
