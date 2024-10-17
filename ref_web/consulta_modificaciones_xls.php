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
	$CookieRut = $_COOKIE["CookieRut"];
	$Rut =$CookieRut;
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Rut =$CookieRut;
	$Consulta = "select * from proyecto_modernizacion.sistemas_por_usuario where rut = '".$Rut."' and cod_sistema = '3'";
	$Respuesta =mysqli_query($link, $Consulta);
	if($Fila =mysqli_fetch_array($Respuesta))
	{
		$Nivel = $Fila["nivel"];
	}
	$CmbAno    = isset($_REQUEST["CmbAno"])?$_REQUEST["CmbAno"]:date("Y");
	$CmbMes    = isset($_REQUEST["CmbMes"])?$_REQUEST["CmbMes"]:date("m");
	$opcion    = isset($_REQUEST["opcion"])?$_REQUEST["opcion"]:"";
	$Mensaje   = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
	/*
	if (!isset($CmbAno))
	{
		$CmbAno=date('Y');
	}
	if (!isset($CmbMes))
	{
		$CmbMes=date('n');
	}
	else
	{*/
		$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase=3004 and cod_subclase ='".$CmbMes."' ";
		$Respuesta =mysqli_query($link, $Consulta);
		if($Fila =mysqli_fetch_array($Respuesta))
		{
			$Letra=$Fila["nombre_subclase"];
		}		
	//}
	?>
<HTML>
<HEAD>
<TITLE>Consulta modificaciones</TITLE>
<script language="JavaScript">
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=11";
}
/**********/
/**********/
function Excel()

{
						

	var  f=document.frmPrincipal;
	document.location = "../ref_web/consulta_modificaciones_xls.php";

/*	var AnoIni=f.CmbAno.value;
	var MesIni=f.MesIni.value;
	document.location = "../ref_web/consulta_modificaciones_xls.php?AnoIni="+AnoIni+"&MesIni="+MesIni+"&proceso=C";*/
}
/**********/
function Recarga()
{
	var Frm=document.frmPrincipal;
	
	Frm.action="consulta_modificaciones.php";
	Frm.submit();
	
}

function Proceso(opt)
{
	
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "C":
			alert ("aqui");
			f.action ="consulta_modificaciones.php";
			f.submit();
			break;
	}
}	
function Proceso1(f)
{
	var f = document.frmPrincipal;
	f.action = "consulta_movimientos.php";
	f.submit();
}
/***********************/
</script>
<FORM name="frmPrincipal" action="" method="post">
  <p align="center"><strong>Consulta Modificaciones</strong></p>
<table width="700" align="center" border="0" cellpadding="3" class="TablaInterior">
	<tr> 
        
      <td width="105"><strong>Fecha a Consultar</strong></td>
		<td width="104"> <font face="Arial, Helvetica, sans-serif"> 
		</td>
        <td width="302"> <div align="left"> </div>
          	<div align="left"><font face="Arial, Helvetica, sans-serif"> </font><font face="Arial, Helvetica, sans-serif">
			<input name="btnConsultar" type="button"  style="width:70;" onClick="JavaScript:Proceso('C')" value="Consultar"> 
		  </font></div></td>
      </tr>
    </table>
	<br>
          <font face="Arial, Helvetica, sans-serif"> </font></div></td>
	</tr>
    <tr> 
		<td height="88" align="center" >  
			<table align="center" width="800" height="27" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" class="TablaDetalle">
				<tr class="ColorTabla01"> 
					<td width="250" height="20" align="center"><strong>Nombre</strong></td>
          			<td width="175" height="20" align="center"><strong>Fecha Movimiento</strong></td>
          			<td width="175" height="20" align="center"><strong>Fecha Modificaci&oacute;n</strong></td>
					<td width="200" height="20" align="center"><strong>Observaciones</strong></td>
				</tr>
			</table>
    		<table align="center" width="800" height="27" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" class="TablaDetalle">
			<tr>
			<?php 
				
				$proceso = 'C';
				if ($proceso == "C")
				{ 
					if (strlen($CmbMes)==1)
					{
						$CmbMes="0".$CmbMes;
					}
					$FechaInicio=$CmbAno."-".$CmbMes."-01";
					$fecha_termino=$CmbAno."-".$CmbMes."-31";
					
					$nombre = "";
					$apellido_paterno = "";
					$apellido_materno = "";
					$consulta="select * from sec_web.cortes_refineria c1,ref_web.control_movimientos c2  where c1.fecha_desconexion = c2.fecha_movimiento and c2.fecha_modificacion between '".$FechaInicio."' and '".$fecha_termino."'  order by c1.fecha_desconexion asc";
					$respuesta = mysqli_query($link, $consulta);
					while ($fila = mysqli_fetch_array($respuesta))
					{
						$consulta1="select nombres,apellido_paterno,apellido_materno from proyecto_modernizacion.funcionarios where rut ='".$fila["rut_modificacion"]."'";
						$respuesta1 = mysqli_query($link, $consulta1);
						if ($fila1 = mysqli_fetch_array($respuesta1))													 
						{
							echo "<tr>";
							echo "<td width='250' align='center'>".$fila1["nombres"]. " " .$fila1["apellido_paterno"]. " " .$fila1["apellido_materno"]."</td>\n";
						}	
							$fecha1 = $fila["fecha_movimiento"];
							$fecha2 = $fila["fecha_modificacion"];
							echo "<td width='175' align='center'>".$fecha1."</td>\n";
          					echo "<td width='175'  align='center'>".$fecha2."</td>\n";
							echo "<td width='200' align='center'><strong>Modificado</strong></td>\n";
							//hasta aqui o.k.
							echo "</tr>";			
					}
				}		
			?>
          </table>
		  <br> 
		   <p align="center"><strong>Validaci&oacute;n Ingreso Datos Conexi&oacute;n Desconexi&oacute;n</strong></p>
 			
      <table width="600" height="27" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" class="TablaDetalle" >
        <tr class="ColorTabla01"> 
		
          <td width="200"  height="20" align="center"><strong>Fecha Movimiento</strong></td>

          <td width="400" height="20" align="center"><strong>Observaciones</strong></td>
         
        </tr>
      </table>
			<tr>
				<table align="center" width="600" height="27" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" class="TablaDetalle">
				<?php
					$consulta2="select * from sec_web.cortes_refineria c1  where c1.fecha_desconexion between '".$FechaInicio."' and '".$fecha_termino."' and kahdirc < kahdird  order by c1.fecha_desconexion asc";
					$respuesta2 = mysqli_query($link, $consulta2);
					while ($fila2 = mysqli_fetch_array($respuesta2))
					{
						echo "<tr>";
						echo "<td width='200' align='center'>".$fila2["fecha_desconexion"]."</td>\n";
						echo "<td width='400' align='left'><strong>Lectura Conexion < Lectura Desconexion </strong></td>\n";
						"</tr>";
					}	
							
					$consulta3="select * from sec_web.cortes_refineria c1  where c1.fecha_desconexion between '".$FechaInicio."' and '".$fecha_termino."' and fecha_conexion < fecha_desconexion  order by c1.fecha_desconexion asc";
					$respuesta3 = mysqli_query($link, $consulta3);
					while ($fila3 = mysqli_fetch_array($respuesta3))
					{
						echo "<tr>";
						echo "<td width='200' align='center'>".$fila3["fecha_desconexion"]."</td>\n";
						echo "<td width='400' align='left'><strong>Hora Conexion < Hora Desconexion</strong></td>\n";
					}	
					echo "</tr>";
					$contador = 0;	
					$consulta4=	"select  count(substring(fecha_desconexion,1,10)) as contador,fecha_desconexion as fecha_des from sec_web.cortes_refineria where substring(fecha_desconexion,1,10)between '".$FechaInicio."' and '".$fecha_termino."' and tipo_desconexion='C'  group by substring(fecha_desconexion,1,10) order by fecha_desconexion";
					$respuesta4 = mysqli_query($link, $consulta4);
					while ($fila4 = mysqli_fetch_array($respuesta4))
					{
						$contador = $fila4["contador"];
						$fecha_des = $fila4["fecha_des"]; 
						if ($contador > 6)
						{
							echo "<tr>";
							echo "<td width='200' align='center'>".$fecha_des."</td>\n";
							echo "<td width='400' align='left'><strong>Existen más de 6 desconexiones para este día</strong> </td>\n";
						}
					}
					echo "</tr>";	
					$grupos = 0;
					$consulta5 ="select  count(cod_grupo) as grupos,fecha_desconexion as fecha_des1, cod_grupo as grupo from sec_web.cortes_refineria where substring(fecha_desconexion,1,10) between '".$FechaInicio."' and '".$fecha_termino."' and tipo_desconexion='C' group by cod_grupo order by fecha_desconexion,cod_grupo";	
					$respuesta5 = mysqli_query($link, $consulta5);	 
					while ($fila5 = mysqli_fetch_array($respuesta5))
					{	
						$grupos = $fila5["grupos"];
						$fecha_des1 = $fila5["fecha_des1"];
					
						if ($grupos > 2)
						{
							echo "<tr>";
							echo "<td width='200' align='center'>".$fecha_des1."</td>\n";
							echo "<td width='400' align='left'><strong>Existen más de 2 desconexiones como Cambio para mismo grupo</strong></td>\n";
						}

					}
				?>
				</table>
			</tr>
     <p></p></tr>
	  
    <tr>
		<td height="30" align="center"> <div align="center"><font face="Arial, Helvetica, sans-serif"> 
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
  <font face="Arial, Helvetica, sans-serif"> 
  </font> <font face="Arial, Helvetica, sans-serif"></font><font face="Arial, Helvetica, sans-serif">
  </font> 
</FORM>
</HTML>
<?php
	if ($Mensaje!="")
	{
		echo "<script languaje='javascript'>";
		echo "alert('".$Mensaje."')";
		echo "</script>";
	}
?>
