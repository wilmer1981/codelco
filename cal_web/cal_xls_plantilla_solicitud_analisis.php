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
$Rut1 =$CookieRut;
$CodigoDeSistema = 1;
$CodigoDePantalla = 5;
$Leyes=array();
$Impurezas=array();
$i=0;
$f=0;


if(isset($_REQUEST["Mostrar"])) {
	$Mostrar = $_REQUEST["Mostrar"];
}else{
	$Mostrar = "";
}
if(isset($_REQUEST["CmbProductos"])) {
	$CmbProductos = $_REQUEST["CmbProductos"];
}else{
	$CmbProductos = "";
}
if(isset($_REQUEST["CmbSubProducto"])) {
	$CmbSubProducto = $_REQUEST["CmbSubProducto"];
}else{
	$CmbSubProducto = "";
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
			frm.action="cal_con_plantilla_solicitud_analisis.php";
			frm.submit();
			break;	
		case "B":
			frm.action="cal_con_plantilla_solicitud_analisis.php?Mostrar=S";
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
	frm.action="cal_xls_plantilla_solicitud_analisis.php?Mostrar=S";
	frm.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmConsultaRecepcion" method="post" action="">
<tr> <td width="756"></tr>
  <tr>
    <table width="795" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
      <tr> 
        <td width="81"><div align="left"><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            Usuario:</font></font></div></td>
        <td width="280"><strong> 
		
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
         	<td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:<strong> 
         	</strong></font></font></td>
         	<td><font size="1"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
         <?php echo $Fecha_Hora;?>
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
      <tr> 
        <td height="31">Producto</td>
        <td><font size="1"><font size="1"><font size="2"><strong> 
				
				<select name="CmbProductos" style="width:280" onChange="Proceso('R');">
				
			<?php
          //  <option value='-1' selected>Todos</option>?>
            <?php
			$Consulta="select cod_producto,descripcion from proyecto_modernizacion.productos order by descripcion"; 
			$Respuesta = mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				if ($CmbProductos==$Fila["cod_producto"])
				{
					echo "<option value = '".$Fila["cod_producto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
				}
				else
				{

					//echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
				}
			}
			?>
          </select>
          </strong></font></font></font><font size="2">&nbsp; </font> </td>
        <td width="93"><div align="right">
            <input name="BtnBuscar" type="button" id="BtnBuscar" style="width:70"value="Buscar" onClick="Proceso('B');">
          </div></td>
		  
        <td width="314"><input name="BtnExcel" type="button" id="BtnExcel" value="Excel" style="width:70" onClick="Excel('');">
          <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70" onClick="Imprimir();"> 
          <input name="BtnSalir2" type="button" id="BtnSalir2" value="Salir" style="width:70" onClick="Proceso('S');">
        </td>
      	</tr>
      	<tr> 
		
      	  <td height="31"><font size="1"><font size="2">Sub Producto</font></font></td>
      	  <td><font size="1"><font size="2"><strong>
      	  <select name="CmbSubProducto" style="width:280"  onChange="Proceso('R');" >
		  <?php
      	//  <option value="-1" selected>Seleccionar</option>?>
		  
		<?php
				//Pregunta si el valor del Combo es 1 osea Productos mineros si es 1 despliega como proveedor
				$Consulta="select cod_subproducto,descripcion from proyecto_modernizacion.subproducto where cod_producto = '".$CmbProductos."' "; 
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
					{
						echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
					}
					else
					{
					//	echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
					}	
				}
				
		?>
        </select>
        </strong></font></font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr> 
        <td height="31">&nbsp;</td>
        <td> <div align="left"><strong> </strong> </div></td>
        <td colspan="2">&nbsp; </td>
      </tr>
    </table>
    <br>
	<table width="950" border="1" cellpadding="0" cellspacing="0" >
        <tr class="ColorTabla01">
		<?php
	    	//<td width="15"><div align="center">&nbsp;</div></td>?>
		<td width="80"><div align="center">Fecha</div></td>  
		<td width="50"><div align="center">Num. Muestra</div></td>  	
        	<td width="100"><div align="center">Nombre Plantilla</div></td>
        	<td width="100" height="20"><div align="center">Centro Costo</div></td>
        	<td width="100"><div align="center">Producto</div></td>
        	<td width="100"><div align="center">SubProducto</div></td>
        	<td width="150"><div align="center">Leyes</div></td>
			<td width="400"><div align="center">Impurezas</div></td>
		</tr>
      <?php


	if ($Mostrar=="S")
	{
	 	$Consulta ="select t1.fecha_hora,1,10,t1.id_muestra,t1.descripcion,t1.cod_ccosto,t2.abreviatura as DesP,t3.abreviatura as DesSub,t1.cod_area from cal_web.plantilla_solicitud_analisis t1 ";
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
			//$Rut = $Fila["rut_funcionario"]
			$Muestra = $Fila["id_muestra"];
			$Fecha1   = substr($Fila["fecha_hora"],0,10); 
			$Fecha   = $Fila["fecha_hora"]; 			
			echo"<td> $Fecha1 </td>";
			echo "<input name = 'Muestra' type= 'hidden' value ='".$Muestra."'>";
			//echo "<td><input name='checkbox' type='checkbox'></td>";
			echo"<td> $Muestra </td>"; 	
			echo  "<td>".$cont.'.-'.' '.$Fila["descripcion"]."</td>";
			//echo "<td>".$Fila["nombre_plantilla"]."</td>";
			$Consulta ="select descripcion as des from proyecto_modernizacion.centro_costo where centro_costo = '".$Fila["cod_ccosto"]."' ";
			$Resp=mysqli_query($link, $Consulta);
			$Fil=mysqli_fetch_array($Resp);
			echo "<td>".$Fil["des"]."</center></td>";
			echo "<td>".$Fila["DesP"]."</td>";
			echo "<td>".$Fila["DesSub"]."</td>";
			//aqui lleno arreglo con leyes e impurezas
			$Consulta1 = "select * from cal_web.plantilla_solicitud_analisis where fecha_hora = '".$Fecha."' and id_muestra = '".$Muestra."'";   
			$Res1 =mysqli_query($link, $Consulta1);
			$Filap = mysqli_fetch_array($Res1);
			$LeyesAux=$Filap["leyes"];
			$ImpurezasAux=$Filap["impurezas"];
			$var=explode("//",$LeyesAux);
			$num=count($var);
			$jj = 1;
			$Leyes1 = " ";
			for ($l = 0;$jj <($num);)
			{
				list($ley,$unidad)=explode("~~",$var[$l]);
					//echo "ley".$ley;
					//echo "_Unidad".$unidad;
					$Consulta="select t1.abreviatura as AbrevLey,t2.abreviatura as AbrevUnidad from"; 
					$Consulta.=" proyecto_modernizacion.leyes t1,proyecto_modernizacion.unidades t2";
					$Consulta.=" where t1.cod_leyes = '".$ley."' and t2.cod_unidad = '".$unidad."'";
					//echo"<td> $Consulta </td>";
					$Res2 = mysqli_query($link, $Consulta);
					$Filaj=mysqli_fetch_array($Res2);
					$Leyes1 = $Leyes1." ".$Filaj["AbrevLey"]."(".$Filaj["AbrevUnidad"].") ";
					$l++;
					$jj = $jj + 1;
			}
			echo "<td>".$Leyes1."</td>";
			//$Leyes1 = " ";
			//aqui impurezas
			$var1=explode("//",$ImpurezasAux);
			$num1=count($var1);
			$jjj = 1;
			$Impureza1 = " ";
			for ($ll = 0;$jjj <($num1);)
			{
				list($impureza,$unid)=explode("~~",$var1[$ll]);
					//echo"Impureza".$impureza;
					//echo "UnidadImp".$unid; 
					$Consulta="select t1.abreviatura as AbrevImp,t2.abreviatura as UnidadImp from";
					$Consulta.=" proyecto_modernizacion.leyes t1,proyecto_modernizacion.unidades t2";
					$Consulta.=" where t1.cod_leyes = '".$impureza."' and t2.cod_unidad = '".$unid."'";
					$Res22 = mysqli_query($link, $Consulta);
					$Filajj=mysqli_fetch_array($Res22);
					$Impureza1 = $Impureza1." ".$Filajj["AbrevImp"]."(".$Filajj["UnidadImp"].") ";
					$ll++;
					$jjj = $jjj + 1;
			}
			echo "<td>".$Impureza1."</td>";
			//$Impureza1 = " ";
			//hasta aqui impurezas
		}
	}
	?>
    </table>
    <br>
    <table width="793" border="0" cellpadding="3" cellspacing="0" class="TablaInterior" >
      <tr> 
        <td width="314"><div align="right"> </div></td>
        <td width="160"><div align="center"> </div>
          <div align="center"> 
            <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" style="width:70" onClick="Proceso('S');">
          </div></td>
        <td width="116">&nbsp;</td>
        <td width="176">&nbsp;</td>
      </tr>
    </table></td>
    </tr>
</form>
</body>
</html>
