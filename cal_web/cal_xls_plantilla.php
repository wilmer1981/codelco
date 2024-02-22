<?php         ob_end_clean();
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
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y h:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 5;


if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar =  "";
}
if(isset($_REQUEST["CmbProductos"])) {
	$CmbProductos = $_REQUEST["CmbProductos"];
}else{
	$CmbProductos =  "";
}
if(isset($_REQUEST["CmbSubProducto"])) {
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
}else{
	$CmbSubProducto =  "";
}
if(isset($_REQUEST["LimitIni"])) {
	$LimitIni = $_REQUEST["LimitIni"];
}else{
	$LimitIni =  0;
}
if(isset($_REQUEST["LimitFin"])) {
	$LimitFin = $_REQUEST["LimitFin"];
}else{
	$LimitFin =  10;
}

?>
<html>
<head>
<title></title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
//function Proceso(Opcion,FechaAtencion)
function Proceso(Opcion)
{
	var frm=document.FrmConsultaRecepcion;
	switch (Opcion)
	{
		case "R":
			frm.action="cal_con_plantilla.php";
			frm.submit();
			break;	
		case "B":
			frm.action="cal_con_plantilla.php?Mostrar=S";
			frm.submit();
			break;
		case "E":
			ValidarCertificado();
			break;
		case "S":
			Salir();
			break;	
	}	
}
function Salir()
{
	var frm =document.FrmConsultaRecepcion;
	frm.action="../principal/sistemas_usuario.php?CodSistema=1&Nivel=1&CodPantalla=22";
	frm.submit(); 
}
function Recarga(URL,LimiteIni)
{
	var frm=document.FrmConsultaRecepcion;
	frm.LimitIni.value = LimiteIni;
	frm.action=URL + "?LimitIni=" + LimiteIni;
	frm.submit(); 
}
function Excel()
{
	var frm=document.FrmConsultaRecepcion;
	frm.action="cal_xls_plantilla.php?Mostrar=S";
	frm.submit();
}


</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<form name="FrmConsultaRecepcion" method="post" action="">
<?php
/*
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 10;*/
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">
  <tr> <td width="756"></tr>
  <tr>
    <table width="761" border="0" cellpadding="3" cellspacing="0">
      <tr> 
        <td width="89"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            Usuario:</font></font></div></td>
        <td><strong> 
          <?php
		$Consulta ="select rut,apellido_paterno,apellido_materno,nombres from funcionarios where rut = '".$Rut."'";
	  	$Resultado= mysqli_query($link, $Consulta);
		if ($Fila =mysqli_fetch_array($Resultado))
		{	
			echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"])); 
		}	  
	  	else
			{
		  		$Consulta = "select  * from proyecto_modernizacion.Administradores where rut = '".$Rut."'";
				$Respuesta = mysqli_query($link, $Consulta);
				if ($Fila=mysqli_fetch_array($Respuesta))
					{
						echo ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
					}
		
			}
		  ?>
          </strong></td>
        <td width="98"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:<strong> 
          </strong></font></font></td>
        <td width="312"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
          <?php echo $Fecha_Hora ?>
          </strong>&nbsp; <strong> 
          <?php
			if (!isset($FechaHora))
  			{
				echo "<input name='FechaHora' type='hidden' value='".date('Y-m-d H:i')."'>";
				$FechaHora=date('Y-m-d H:i');
 			}
  			else
  			{ 
				echo "<input name='FechaHora' type='hidden' value='".$FechaHora."'>";
  			}
		  ?>
          </strong></font></font></td>
      </tr>
    </table>
    <br>
    <table width="1106" border="1" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="208"><div align="center">Nombre Plantilla</div></td>
        <td width="89" height="20"><div align="center">Originador</div></td>
        <td width="125"><div align="center">Producto</div></td>
        <td width="111"><div align="center">SubProducto</div></td>
        <td width="561"><div align="center">Leyes</div></td>
      </tr>
      <?php
	if ($Mostrar=="S")
	{
		$Consulta ="select t1.nombre_plantilla,t1.cod_plantilla,t2.abreviatura as DesP,t3.abreviatura as DesSub,t1.tipo_plantilla,t1.rut_funcionario from cal_web.plantillas t1 ";
		$Consulta.=" inner join proyecto_modernizacion.productos t2 on t1.cod_producto = t2.cod_producto  ";
		$Consulta.=" inner join proyecto_modernizacion.subproducto t3 on t2.cod_producto = t3.cod_producto and t1.cod_subproducto = t3.cod_subproducto  ";		
		if (($CmbProductos != '-1')&&($CmbSubProducto !='-1'))
		{
			$Consulta.=" where t1.cod_producto = '".$CmbProductos."' and t1.cod_subproducto = '".$CmbSubProducto."' order by t1.cod_producto,t1.cod_subproducto  ";	
		} 
		if (($CmbProductos != '-1')&&($CmbSubProducto =='-1'))
		{
			$Consulta.=" where t1.cod_producto = '".$CmbProductos."' order by t1.cod_producto,t1.cod_subproducto ";	
		}
		if (($CmbProductos == '-1')&&($CmbSubProducto =='-1'))
		{
			$Consulta.=" order by t1.cod_producto,t1.cod_subproducto "; 
		}
		//echo $Consulta."<br>"; 
		$Respuesta = mysqli_query($link, $Consulta);
		$cont = 1;
		while($Fila=mysqli_fetch_array($Respuesta))
		{
			echo "<tr>";
				echo "<td>".$cont.'.-'.' '.$Fila["nombre_plantilla"]."</td>";
				if ($Fila["tipo_plantilla"] == 'P')
				{
					$Consulta ="select * from proyecto_modernizacion.funcionarios where rut = '".$Fila["rut_funcionario"]."' ";
					$Resp=mysqli_query($link, $Consulta);
					$Fil=mysqli_fetch_array($Resp);
					echo "<td>".substr($Fil["nombres"],0,1).".".$Fil["apellido_paterno"]."</center></td>";
				}
				else
				{
					echo "<td>Generica</td>";
				}
				echo "<td>".$Fila["DesP"]."</td>";
				echo "<td>".$Fila["DesSub"]."</td>";	
				$Consulta="select t3.abreviatura as AbrevLey,t4.abreviatura as AbrevUnidad from cal_web.plantillas t1 ";
				$Consulta.=" inner join cal_web.leyes_por_plantillas t2 on t1.cod_plantilla = t2.cod_plantilla and t1.rut_funcionario = t2.rut_funcionario "; 
				$Consulta.=" inner join proyecto_modernizacion.leyes t3 on t2.cod_leyes = t3.cod_leyes 	";
				$Consulta.=" inner join proyecto_modernizacion.unidades t4 on t2.cod_unidad = t4.cod_unidad ";
				if (($CmbProductos != '-1') && ($CmbSubProducto != '-1'  ))
				{
					$Consulta.=" where t2.cod_plantilla = ".$Fila["cod_plantilla"]." and t1.cod_producto = '".$CmbProductos."' and t1.cod_subproducto = '".$CmbSubProducto."'";				
				}
				
				if  (($CmbProductos != '-1') && ($CmbSubProducto == '-1'  ))
				{
					$Consulta.=" where t2.cod_plantilla = ".$Fila["cod_plantilla"]." and t1.cod_producto = '".$CmbProductos."' ";
				}
				else
				if  (($CmbProductos == '-1') && ($CmbSubProducto == '-1'  ))
				{
					$Consulta.=" where t2.cod_plantilla = ".$Fila["cod_plantilla"];
				}
				//echo $Consulta."<br>"; 
				$Respuesta1 = mysqli_query($link, $Consulta);
				$Leyes="";
				while($Fila1=mysqli_fetch_array($Respuesta1))
				{
					$Leyes= $Leyes." ".$Fila1["AbrevLey"]." ".$Fila1["AbrevUnidad"]." "."-";
				}		
				echo "<td>".$Leyes."</td>";	
				//$Leyes="";
			echo "</tr>";
			$cont = $cont + 1;
		}
	}
	?>
    </table>
    <br>
    <table width="761" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
      <tr> 
        <td width="314"><div align="right"> </div></td>
        <td width="160"><div align="center"> </div>
          <div align="center"> 
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');">
          </div></td>
        <td width="116">&nbsp;</td>
        <td width="144">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
</form>
</body>
</html>
