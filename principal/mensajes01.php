<?php 
include("conectar_principal.php");
	/*if($Proceso=='Func')
	{
		/*$Consulta="select * from proyecto_modernizacion.centro_rrhh  ";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Resp))
		{
			$CodCentro= str_replace(".","",$Fila[COD_CENTRO_COSTO]) ;
			$CodCentro= substr($CodCentro,3,4) ;
			//echo "cod_centro".$CodCentro."<br>";
			$Actualizar=" UPDATE proyecto_modernizacion.centro_costo set cod_area='".$Fila[COD_AREA]."'  ";
			$Actualizar.=" where centro_costo_enm ='".$CodCentro."'";
			mysqli_query($link, $Actualizar);
			echo $Actualizar."<br>";
		}*/
		/*$Consulta="select * from proyecto_modernizacion.antecedentes_personales ";
		$Resp=mysqli_query($link, $Consulta);
		while($Fila=mysqli_fetch_array($Resp)) 	
		{
			$Consulta="select  * from proyecto_modernizacion.funcionarios where  rut ='".$Fila[RUT]."'";
			$Resp1=mysqli_query($link, $Consulta);
			if($Fila1=mysqli_fetch_array($Resp1))
			{
				$Actualizar=" UPDATE  proyecto_modernizacion.funcionarios set  ";
				$Actualizar.=" anexo='".$Fila[ANEXO]."' , fecha_nacimiento='".$Fila[FECHA_NACIMIENTO]."', ";
				$Actualizar.=" cod_cargo='".$Fila[COD_CARGO]."',foto='".$Fila[FOTO]."'   ";
				$Actualizar.=" where rut='".$Fila[RUT]."'";
				mysqli_query($link, $Actualizar);
				echo $Actualizar."<br>";
			}
			else
			{
				$insertar="insert into proyecto_modernizacion.funcionarios ";
				$insertar.=" (rut,apellido_paterno,apellido_materno,nombres,   ";
				$insertar.=" cod_centro_costo,anexo,fecha_nacimiento,cod_cargo,foto,rrhh)values ";
				$insertar.="( '".$Fila[RUT]."', '".$Fila["apellido_paterno"]."','".$Fila[APELLIDO_MATERNO]."', ";
				$insertar.=" '".$Fila["nombres"]."','".$Fila[COD_CENTRO_COSTO]."','".$Fila[ANEXO]."','".$Fila[FECHA_NACIMIENTO]."',";
				$insertar.=" '".$Fila[COD_CARGO]."', '".$Fila[FOTO]."' ,'S' )";
				mysqli_query($link, $insertar);
				echo $insertar."<br>";
			}
		}
	}

*/



/*if ($Proceso == "A")
{

	/*$Consulta=" select *,count(*) as cantidad ";
	$Consulta.=" from cal_web.registro_leyes where rut_funcionario in ('00000000-1','00000000-2') ";
	$Consulta.=" and left(fecha_hora,7)='".$Ano."-".str_pad($Mes,2,"0",STR_PAD_LEFT)."' group by   nro_solicitud,recargo,rut_funcionario, ";
	$Consulta.=" cod_leyes,cod_unidad,valor,candado order by cantidad desc ";
	$Respuesta=mysqli_query($link, $Consulta);
	echo $Consulta."<br>";
	while($Fila=mysqli_fetch_array($Respuesta))
	{
		if($Fila[cantidad] > 1)
		{
			$Eliminar ="delete from cal_web.registro_leyes where rut_funcionario='".$Fila[rut_funcionario]."'  ";
			$Eliminar.=" and recargo='".$Fila["recargo"]."' and nro_solicitud='".$Fila["nro_solicitud"]."' and cod_leyes='".$Fila["cod_leyes"]."' ";
			$Eliminar.=" and cod_unidad='".$Fila["cod_unidad"]."' ";
			mysqli_query($link, $Eliminar);
			echo $Eliminar."<br>";
			//$FechaHora=substr($Fila["fecha_hora"]
			$Insertar=" INSERT INTO cal_web.registro_leyes ";
		    $Insertar.=" (rut_funcionario, fecha_hora, nro_solicitud, recargo, ";
			$Insertar.=" cod_leyes, valor, peso_humedo, peso_seco, cod_unidad, candado, signo, rut_proceso) ";
			$Insertar.=" VALUES ";
			$Insertar.="  ('".$Fila[rut_funcionario]."', '".$Fila["fecha_hora"]."','".$Fila["nro_solicitud"]."', '".$Fila["recargo"]."', ";
			$Insertar.="  '".$Fila["cod_leyes"]."', '".str_replace($Fila["valor"],",",".")."', 0, 0, '".$Fila["cod_unidad"]."', '".$Fila[candado]."', '".$Fila["signo"]."', '".$Fila[rut_proceso]."') ";
			mysqli_query($link, $Insertar);
			echo $Insertar."<br>";
		}
	}*/
		

//}	
	
	
/*	
	
	
	
	$Consulta="select * from proyecto_modernizacion.centro_costo where centro_costo_enm  <> 'NUEVO' ";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Resp))
	{
		$Actualizar=" UPDATE cal_web.solicitud_analisis set cod_ccosto='".$Fila[CENTRO_COSTO]."'  ";
		$Actualizar.=" where cod_ccosto ='".$Fila[centro_costo_enm]."' and fecha_hora between '2006-05-01 14:43:44' and '2006-07-26 15:43:49' ";
		mysqli_query($link, $Actualizar);
		echo "*********************"."<br>";
		echo "act".$Actualizar."<br>";
		$Actualizar=" UPDATE cal_web.plantilla_solicitud_analisis set cod_ccosto='".$Fila[CENTRO_COSTO]."'  ";
		$Actualizar.=" where cod_ccosto ='".$Fila[centro_costo_enm]."'";
		mysqli_query($link, $Actualizar);
		echo "*********************"."<br>";
		echo "act".$Actualizar."<br>";
		
		
		/*$Actualizar=" UPDATE proyecto_modernizacion.centro_costos2 set DESCRIPCION='".$Fila["descripcion"]." "."(".$Fila[centro_costo_enm].")"."'  ";
		$Actualizar.=" where CENTRO_COSTO ='".$Fila[CENTRO_COSTO]."'";
		mysqli_query($link, $Actualizar);*/
/*	}
}*/

/*if($Proceso=='IdUsuario')
{
	$Consulta="select * from proyecto_modernizacion.cuentas  ";
	$Resp=mysqli_query($link, $Consulta);
	while($Fila=mysqli_fetch_array($Resp))
	{
		$Rut=str_pad($Fila[RUT],8,'0',l_pad).'-'.$Fila[DV];
		$Actualizar ="UPDATE  proyecto_modernizacion.funcionarios  set id_usuario='".$Fila[CUENTA]."' ";
		$Actualizar.=" where rut='".$Rut."'";
		mysqli_query($link, $Actualizar);
	}
}*/
$CookieRut   = $_COOKIE["CookieRut"];
$Proceso     = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$mensaje     = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";
$NumMensaje  = isset($_REQUEST["NumMensaje"])?$_REQUEST["NumMensaje"]:"";
$PrintMensaje = isset($_REQUEST["PrintMensaje"])?$_REQUEST["PrintMensaje"]:"";


if ($Proceso == "S")
{
	header("location:sistemas_usuario.php?CodSistema=99");
}
	//FECHA
	$dia_actual=date("j"); //ENTREGA NUMERO DE DIA SIN CERO (1-31)
    $mes_actual=date("n"); //ENTREGA NUMERO DE MES SIN CERO (1-12)
	$ano_actual=date("Y"); //ENTREGA NUMERO DE A�O DE 4 DIGITOS (2002)
	//Formatea FECHA
	
	$FechaActual=$ano_actual."-".$mes_actual."-".$dia_actual;
	if ($Proceso == 'Ingresar')
	{
		$Insertar = "INSERT into mensajes(fecha,funcionario,mensaje) VALUES('".$FechaActual."','".$CookieRut."','".$mensaje."')";
		mysqli_query($link, $Insertar);
	}
	if ($Proceso == 'Eliminar')
	{
		$Eliminar = "DELETE from mensajes where numero_mensaje = '".$NumMensaje."'";
		mysqli_query($link, $Eliminar);
		Header("Location:mensajes.php?Proceso=2");
		exit;
	}
	if (mysqli_errno($link)==0)
  	{
		if ($Proceso == 'Ingresar')
		{
			$PrintMensaje = "Mensaje Insertado Existosamente.";
		}
		if ($Proceso == 'Eliminar')
		{
			$PrintMensaje = "Mensaje Eliminado Existosamente.";
		}
  	}
  	else
  	{
      	if (mysqli_errno($link)==1062)
      	{
          	$PrintMensaje="No se ha Ingresado por que el Código <br>Ya existe";
      	}
      	else
      	{
           	$numerror=mysqli_errno($link);
           	$descrerror=mysqli_error($link);
           	$PrintMensaje="no ha sido realizar la Operaci�n por que se ha producido un error <br> n� $numerror que corresponde a: $descrerror  <br>";
      	}
  	}
?>
<html>
<head>
	<title>Sistemas Informaticos Locales</title>
	<link href="estilos/css_principal.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Volver()
{
	frmPrincipal.action = "mensajes.php";
	frmPrincipal.submit();
}

function Salir()
{
	frmPrincipal.action = "sistemas_usuario.php?CodSistema=99";
	frmPrincipal.submit();
}
</script> 
	
</head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php include("encabezado.php");?>
  <table width="770" border="1" cellspacing="0" cellpadding="0" class="TablaPrincipal">
    <tr>
      <td height="316" align="center" valign="middle"> 
        <?php
			echo "<b><center></center><font size=3 face=verdana color=#336699>$PrintMensaje</font></center></b>\n";
		?>
        <br>
        <br>
        <br>
        <input name="BtnVolver" type="button" id="BtnVolver" value="Volver" onClick="Volver();" style="width:70px;">
          <input name="BtnSalir" type="button" id="BtnSalir" value="Salir" onClick="Salir();" style="width:70px;">
      </td>
    </tr>
  </table>

<?php include("pie_pagina.php");?>
</form>
</body>
</html>
