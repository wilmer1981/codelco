<?php
include("../principal/conectar_principal.php");
$Fecha_Hora = date("d-m-Y H:i");
$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;
$Rut1 =$CookieRut;
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
if(isset($_REQUEST["producto"])) {
	$producto = $_REQUEST["producto"];
}else{
	$producto =  "";
}
if(isset($_REQUEST["sproducto"])) {
	$sproducto = $_REQUEST["sproducto"];
}else{
	$sproducto =  "";
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
		case "Z":
		 	var sw=0;
			var Plantilla = 0;
			
			
			
			var elimina_pla = " ";
			var p=frm.CmbProductos.value;
			var s=frm.CmbSubProducto.value;
			for (i=0;i<frm.checkbox.length;i++)
			{
			   if (frm.checkbox[i].checked==true)
				{
					Plantilla =frm.Plantilla[i].value;	
					Rut = frm.Rut[i].value;
					elimina_pla = elimina_pla+"//"+Rut+":"+Plantilla; 	
					
					sw=sw+1;
					}
			}
			if (sw!=0)
				{
				frm.action="cal_quimico_plantilla01.php?Opcion=Z&prod="+p+"&sprod="+s+"&elimina_pla=" + elimina_pla;
					//alert (frm.action);
					frm.submit();
				break;
				}
				else
				{
				alert("No Hay Elementos Seleccionados ");
					
				}	
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
function Imprimir()
{
	window.print();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body background="../principal/imagenes/fondo3.gif">
<form name="FrmConsultaRecepcion" method="post" action="">
<?php
/*
	if (!isset($LimitIni))
		$LimitIni = 0;
	if (!isset($LimitFin))
		$LimitFin = 10;*/
?>
<input type="hidden" name="LimitIni" value="<?php echo $LimitIni; ?>">

<input type="hidden" name="Rut1" value="<?php echo $Rut1; ?>">


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
      <tr> 
        <td height="31">Producto</td>
        <td><font size="1"><font size="1"><font size="2"><strong> 
          <select name="CmbProductos" style="width:280" onChange="Proceso('R');">
            <option value='-1' selected>Todos</option>
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

					echo "<option value = '".$Fila["cod_producto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
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
 		  <input name="BtnEliminar" type="button" id="Bteliminar" value="Eliminar" style="width:70" onClick="Proceso('Z');">
		</td>
      	</tr>
      	<tr> 
        <td height="31"><font size="1"><font size="2">Sub Producto</font></font></td>
        <td><font size="1"><font size="2"><strong>
          <select name="CmbSubProducto" style="width:280"  onChange="Proceso('R');" >
            <option value="-1" selected>Seleccionar</option>
            <?php
				//Pregunta si el valor del Combo es 1 osea Productos mineros si es 1 despliega como proveedor
				$Consulta="select cod_subproducto,descripcion from subproducto where cod_producto = '".$CmbProductos."' "; 
				$Respuesta = mysqli_query($link, $Consulta);
				while ($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbSubProducto == $Fila["cod_subproducto"])
					{
						echo "<option value = '".$Fila["cod_subproducto"]."' selected>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";				
					}
					else
					{
						echo "<option value = '".$Fila["cod_subproducto"]."'>".ucwords(strtolower($Fila["descripcion"]))."</option>\n";
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
    <table width="900" border="1" cellpadding="0" cellspacing="0" >
      <tr class="ColorTabla01">
	  	<td width="15"><div align="center">&nbsp;</div></td>
		<td width="60"><div align="center!">Nº Plantilla</div></td>  	
        <td width="200"><div align="center">Nombre Plantilla</div></td>
        <td width="89" height="20"><div align="center">Originador</div></td>
        <td width="125"><div align="center">Producto</div></td>
        <td width="111"><div align="center">SubProducto</div></td>
        <td width="561"><div align="center">Leyes</div></td>
      </tr>
      <?php
	
	  
	if ($Mostrar=="S")
	{
	 
	  
		$Consulta ="select STRAIGHT_JOIN t1.rut_funcionario,t1.nombre_plantilla,t1.cod_plantilla,t2.abreviatura as DesP,t3.abreviatura as DesSub,t1.tipo_plantilla,t1.rut_funcionario from cal_web.plantillas t1 ";
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
			$Rut = $Fila["rut_funcionario"];
			$Plantilla = $Fila["cod_plantilla"];
			
			//echo $Plantilla;
			echo "<input name = 'Plantilla' type= 'hidden' value ='".$Plantilla."'>";
			echo "<input name = 'Rut' type='hidden' value='".$Rut."'>";
			echo "<td><input name='checkbox' type='checkbox'></td>";
			//hoy
			echo"<td> $Plantilla </td>"; 	
			echo  "<td>".$cont.'.-'.' '.$Fila["nombre_plantilla"]."</td>";
			//echo "<td>".$Fila["nombre_plantilla"]."</td>";
			    if ($Fila["tipo_plantilla"] == 'P')
				{   
					$Consulta ="select * from proyecto_modernizacion.funcionarios where rut = '".$Fila["rut_funcionario"]."' ";
					$Resp=mysqli_query($link, $Consulta);
					$Fil=mysqli_fetch_array($Resp);
					$nombres          = isset($Fil["nombres"])?$Fil["nombres"]:"";
			        $apellido_paterno = isset($Fil["apellido_paterno"])?$Fil["apellido_paterno"]:"";
					echo "<td>".substr($nombres,0,1).".".$apellido_paterno."</center></td>";
				}
				else
				{
					echo "<td>Generica</td>";
				}
				echo "<td>".$Fila["DesP"]."</td>";
				echo "<td>".$Fila["DesSub"]."</td>";	
				$Consulta="select STRAIGHT_JOIN  t3.abreviatura as AbrevLey,t4.abreviatura as AbrevUnidad from cal_web.plantillas t1 ";
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
	<?php
	//aqui vuelvo de eliminar
		if ($Mostrar=="J")
	{
	 	$CmbProductos = $producto;
		$CmbSubProducto=$sproducto;
	  
		$Consulta ="select STRAIGHT_JOIN t1.rut_funcionario,t1.nombre_plantilla,t1.cod_plantilla,t2.abreviatura as DesP,t3.abreviatura as DesSub,t1.tipo_plantilla,t1.rut_funcionario from cal_web.plantillas t1 ";
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
			$Rut = $Fila["rut_funcionario"];
			$Plantilla = $Fila["cod_plantilla"];
			
			//echo $Plantilla;
			echo "<input name = 'Plantilla' type= 'hidden' value ='".$Plantilla."'>";
			echo "<input name = 'Rut' type='hidden' value='".$Rut."'>";
			echo "<td><input name='checkbox' type='checkbox'></td>";
			
			echo"<td> $Plantilla </td>"; 	
				
			echo "<td>".$cont.'.-'.' '.$Fila["nombre_plantilla"]."</td>";
			
			//echo "<td>".$Fila["nombre_plantilla"]."</td>";
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
				$Consulta="select STRAIGHT_JOIN t3.abreviatura as AbrevLey,t4.abreviatura as AbrevUnidad from cal_web.plantillas t1 ";
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


	  
	
	//hasta aqui
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
