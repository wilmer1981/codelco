<?php
	include("conectar_principal.php");	
	$CookieRut = $_COOKIE["CookieRut"];
	
	//agregado por WSO
	// comprobar si tenemos los parametros de la URL
	if(isset($_REQUEST["CodSistema"])){
		$CodSistema = $_REQUEST["CodSistema"];
	}else {
		$CodSistema = 0;
	}
	if(isset($_REQUEST["Nivel"])){
		$Nivel = $_REQUEST["Nivel"];
	}else {
		$Nivel = 0;
	}
	if(isset($_REQUEST["CodPantalla"])){
		$CodPantalla = $_REQUEST["CodPantalla"];
	}else {
		$CodPantalla = 0;
	}

	$modal=0;
	$consulta = "SELECT rut, password, fecha_cambio_password ";
	$consulta.= " FROM proyecto_modernizacion.funcionarios ";
	$consulta.= " WHERE rut = '".$CookieRut."'";
	
	$rs = mysqli_query($link, $consulta);

	if($row = mysqli_fetch_array($rs))
	{	
		//Junio 2017 Verifica si contraseña esta caducada o pronta a caducar.
		$Consulta = "select valor from parametros_auditoria where codigo=2";
		$Respuesta = mysqli_query($link,$Consulta);
		if ($Fila = mysqli_fetch_array($Respuesta))
		{
			$datediff = strtotime(date('Y-m-d')) - strtotime($row["fecha_cambio_password"]);
			$diasCaducidad = round($datediff / (60 * 60 * 24));
			$diasRestantes = $Fila["valor"]-$diasCaducidad;
			if($diasRestantes<=3 && $diasRestantes>=0)
			{
				$modal=1; 	//pwd pronta a caducar
			}
			if($diasRestantes<0)
			{	
				$modal=2;	//pwd caducada
			}									
		}			
	}
	else
	{
		header("Location:../index.php");
	}
	@setcookie("CookieOpcion",'2');
    //-------------------------------
	$Mensaje = fopen("mensaje.txt","w+");
	$Consulta = "select * from mensajes order by fecha desc";
	$Resultado = mysqli_query($link,$Consulta);
	$Salto = CHR(10);
	while ($Row = mysqli_fetch_array($Resultado))
	{
		$Fecha = $Row["fecha"];
		$Ano = SubStr($Fecha, 0, 4);
		$Mes = SubStr($Fecha, 5, 2);
		$Mes = $Mes - 1;
		$Dia = SubStr($Fecha, 8, 2);
		$Fecha_DMA = $Dia."/".$Meses[$Mes] ."/".$Ano;
		fwrite($Mensaje,$Fecha_DMA.":".$Salto);
		fwrite($Mensaje,$Row["mensaje"]."".$Salto);
		fwrite($Mensaje,$Salto."".$Salto);
	}
	fclose($Mensaje);

	//OBTENEMOS EL VALOR DE LA CLASE 8 SUBCLASE 1
	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase = '8' and cod_subclase='1' AND valor_subclase2='S'";
	$Respuesta = mysqli_query($link,$Consulta);
	$mensajeInterno["Desc1"] = '';
	if ($Fila = mysqli_fetch_array($Respuesta))
	{
		$mensajeInterno["Desc1"] = $Fila["nombre_subclase"];
		$mensajeInterno["Desc2"] = $Fila["valor_subclase1"];
	}
?>

<html>
<head>
<link rel="stylesheet" href="estilos/css_principal.css">
<title>Sistemas Informaticos Locales</title>
<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="JavaScript">
//Junio 2017 caducidad de contraseña
var modal = <?php echo json_encode($modal);?>;
switch(modal)
{
	case 1:
		var dias = <?php echo json_encode($diasRestantes);?>;
		if(dias==0)
			var msj = " Informamos que su contrase\u00F1a expira hoy.\n Presione Aceptar para actualizar su clave.";
		else
			var msj = " Informamos que en "+<?php echo json_encode($diasRestantes);?>+" d\xEDas expirar\xE1 su contrase\u00F1a.\n Presione Aceptar para actualizar su clave.";
		window.onload = function() {
			var cad = confirm(msj);
			if(cad==true)
				Password();
		}
		break;
	case 2:
		alert("Su contrase\u00F1a ha caducado.\nDebe actualizar su clave.");
		window.location="password02.php";
		break;					
	}

function Direcciona(sist, pant, url)
{
	var f = document.frmPrincipal;
	f.CodSist.value=sist;
	f.CodPant.value=pant;
	f.Pagina.value=url;
	f.action="direcciona.php";
	f.submit();
}
function CambiaEstilo(objeto,opcion)
{
	if (opcion == "2")
	{
		objeto.style.backgroundColor="#EFC621";
		objeto.style.border = "solid 1px #000000";
	}
	if (opcion == "1")
	{
		objeto.style.backgroundColor="";
		objeto.style.border = "none";
	}
}

function Password()
{
	window.open('password.php','','top=60px,left=50px,width=450px,height=250px');
}

function CerrarSesion()
{
	var f=document.frmPrincipal;
	window.location="sistemas_usuario01.php?Proceso=CS";
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type="text/css">
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
}
</style>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" method="post" action="">
<input type="hidden" value="" name="Pagina">
<input type="hidden" value="" name="CodSist">
<input type="hidden" value="" name="CodPant">
<div style="position:absolute; left: 5px; top: 2px;"> 
              <TABLE width=770 height="44" border=0 cellPadding=0 cellSpacing=0>
                <TBODY>
                  <TR> 
                    <th valign="top"><img src="imagenes/fondoarriba.jpg" width="770" height="50"></th>
                  </TR>
                </TBODY>
              </TABLE>
</div>
<div style="position:absolute; left: 5px; top: 53px; width: 770;">
  <table width="760" border="0" cellspacing="0" cellpadding="0" >
    <tr>
        <td height="30" align="right" ><table width="770" class="TablaPrincipal2">
            <tr valign="middle"> 
                <td width="271"><img src="imagenes/fun_ref.gif"></td>
                <td width="179" align="right">
				<font color="#666666">&nbsp;<font face="Times New Roman, Times, serif">Servidor: 
                <?php echo $IP_SERV;?></font></font>
			    </td>
                <td width="304" align="right">
				<font size="2" face="Times New Roman, Times, serif">&nbsp; </font>
				<font color="#666666" face="Times New Roman, Times, serif">&nbsp; 
                <?php
					if (isset($mensaje))
						echo '<script languege="JavaScript"> alert("'.$mensaje.'") </script>';
				?>
				<?php
					//FUNCION DE FECHA
					$str_dia = date("w");
					$str_dia = $str_dia;
					$dia = date("j");
					$mes = date("n");
					$mes = $mes - 1;
					$ano = date("Y");
					//FIN FUNCION DE FECHA
				?>
				<?php echo $Dias[$str_dia]." ".$dia." de ".$Meses[$mes]." de ".$ano.", ".date("H:i")." hrs"; ?>
                </font>
			    </td>
            </tr>
        </table></td>
    </tr>
  </table>
</div>  
<?php
if($mensajeInterno["Desc1"]!= '')
{
?>
	<div style="position:absolute; left: 5px; top: 90px; width: 770;">
	<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal2">
	<tr>
		<td><strong><?php echo $mensajeInterno["Desc1"];?></strong></td>
		<td><strong><a href="<?php echo $mensajeInterno["Desc2"];?>"><?php echo $mensajeInterno["Desc2"];?></a></strong></td>
	</tr>
	</table>
	</div>
	<div style="position:absolute; left: 5px; top: 116px; width: 810px; height: 303px;">
<?php
}else{
?>
	<div style="position:absolute; left: 5px; top: 86px; width: 810px; height: 303px;">
<?php
}
?>
    <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
      	<tr valign="middle"> 
        <td width="200" height="313" align="center" valign="top" background="imagenes/fondo3.gif">
		<div style="position:absolute; left: 18px; width: 198px; height: 220px; top: 60px;overflow:auto;">
			<table border="0" width="100%" cellpadding="3" cellspacing="0" class="menu">
			<?php
			//echo "RUT:".$CookieRut;
			$consulta = "SELECT cod_sistema, nivel FROM sistemas_por_usuario WHERE rut = '".$CookieRut."' order by cod_sistema";
			$rs = mysqli_query($link,$consulta);

			while ($row = mysqli_fetch_array($rs))	
			{

				$consulta = "SELECT * FROM sistemas WHERE cod_sistema = '".$row["cod_sistema"]."' ";
				$rs2  = mysqli_query($link,$consulta);
				$row2 = mysqli_fetch_array($rs2);

				echo "<tr><td>&nbsp;&nbsp;";
				echo "<a href='sistemas_usuario.php?CodSistema=".$row["cod_sistema"]."' target='_parent' class='Links01'>";
				echo "<img src='imagenes/vineta.gif' border='0' align='top'>";
				echo ucwords(strtolower($row2["descripcion"]));
				echo "</a>";
				echo "</td></tr>\n";
			}				
			?>                      
            </table>
        </div>
        <img src="imagenes/menu.gif" width="199" height="304"> 
        </td>
        <td width="546" height="316" align="center" valign="middle" background="imagenes/fondo3.gif">
		  <div style="position:absolute; left: 259px; top: 12px; width: 330px; height: 18px;">
            <table width="330" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="290" align="center">
				<?php
				 //echo "Codsistema:".$CodSistema;
				$CodSistema = $CodSistema * 1;
				if (isset($CodSistema) && ($CodSistema != 0))
				{
					if ($CodSistema < 10)
						$CodigoAux = "0".$CodSistema;
					else	
						$CodigoAux = $CodSistema;
					echo "<img src='imagenes/tit_sistema".$CodigoAux.".jpg'>";
				}
				?>
				</td>
                <td width="26" align="right">
				<?php
				//echo "Nivel:".$Nivel;
				if ((!isset($Nivel)) || ($Nivel == 0))
				{
					$SistemaAnterior = 0;
					$NivelAnterior = 0;
				}else{
					$SistemaAnterior = $CodSistema;
					$NivelAnterior = $Nivel - 1;
				}
				if (isset($CodSistema) && ($CodSistema != 0))
				{
					echo "<a href='sistemas_usuario.php?CodSistema=".$SistemaAnterior."&Nivel=".$NivelAnterior."'><img src='imagenes/atras.gif' border=0></a></td>\n";
				}
				?>
              </tr>
            </table>
	      </div>
		  <div style="position:absolute; left: 594px; top: 6px; width: 168px; height: 266px;">
		  <?php
		  	$Consulta = "select * from proyecto_modernizacion.funcionarios ";
			$Consulta.= " where rut='".$CookieRut."'";
			$Resp=mysqli_query($link,$Consulta);
			$Favoritos="";
						
			if ($Fila=mysqli_fetch_array($Resp))
			{
				$Favoritos=$Fila["favoritos"];
				$PrimerNombre=$Fila["nombres"];
				for ($i=0;$i<=strlen($PrimerNombre);$i++)
				{
					if (substr($PrimerNombre,$i,1)==" ")
					{
						$PrimerNombre=trim(substr($PrimerNombre,0,$i));
						break;
					}
				}
				$NombreUser = ucwords(strtolower($PrimerNombre))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".strtoupper(substr($Fila["apellido_materno"],0,1)).".";
				$Caduca=$Fila["caduca"];
			}
		  ?>
		  <table width="95%" border="0" cellpadding="2" cellspacing="1" bgcolor="#996600">
		  <tr>
		  <td colspan="2" align="center"><span class="Estilo1">Bienvenido
		    
		  </span></td>
		  </tr>
		  <tr>
		    <td colspan="2" bgcolor="#FFFFFF"><?php echo $NombreUser;?></td>
		    </tr>
		 <!-- <tr>
		    <td width="33%" bgcolor="#FFFFFF">Conectado:</td>
		    <td width="67%" bgcolor="#FFFFFF"><?php echo number_format($DifFechaHr,0,",","."); ?> hrs <?php echo number_format($DifFechaMin,0,",","."); ?>min </td>
		  </tr>-->
		  <tr align="center">
		    <td colspan="2" bgcolor="#FFFFFF">
			<a href="JavaScript:Password();"><img src="imagenes/llave01.gif" width="16" height="16" border="0" align="absmiddle"></a>&nbsp;<a href="JavaScript:Password();" style="color:#0000FF">Cambiar Password&nbsp;</a></td>
		    </tr>			
		  <tr align="center">
		    <td colspan="2" bgcolor="#FFFFFF"><a href="JavaScript:CerrarSesion();" style="color:#0000FF">Cerrar Sesi&oacute;n&nbsp;</a></td>
		    </tr>		
		  </table>
		  <br>
		  <table width="95%" border="0" cellpadding="2" cellspacing="1" bgcolor="#996600">
            <tr>
              <td colspan="2" align="center"><span class="Estilo1">&Uacute;ltimos Accesos </span></td>
            </tr>
			<?php
				$Consulta = "select * from proyecto_modernizacion.control_acceso ";
				$Consulta.= " where rut='".$CookieRut."' ";
				$Consulta.= " and sistema='0' ";
				$Consulta.= " order by fecha_hora desc ";
				$Consulta.= " limit 0,2";				
				$Resp=mysqli_query($link,$Consulta);
				$Color="#FFDF7C";
				while ($Fila=mysqli_fetch_array($Resp))
				{
					if ($Color=="#FFDF7C")
						$Color="#FFFFFF";
					else
						$Color="#FFDF7C";

					$FechaHora=substr($Fila["fecha_hora"],8,2)."/".substr($Fila["fecha_hora"],5,2)."/".substr($Fila["fecha_hora"],2,2)." ".substr($Fila["fecha_hora"],11,5);
					$PcAcceso=$Fila["ip"];
				?>
			    <tr bgcolor="<?php echo $Color; ?>">
			        <td>Fecha:</td>
				    <td><?php echo $FechaHora; ?></td>
			    </tr>
				<tr bgcolor="<?php echo $Color; ?>">
					  <td>IP:</td>
					  <td><?php echo $PcAcceso;?></td>
			    </tr>
 				<?php }?>
          </table>
		  <br>
		  <table width="95%" border="0" cellpadding="2" cellspacing="1" bgcolor="#996600">
            <tr>
              <td align="center"><span class="Estilo1">Acceso Directo </span></td>
            </tr>
           <?php
            //si exite Favoritos
			if(!empty($Favoritos)){
		   		$ArrFav = explode(";",$Favoritos);
				//while (list($k,$v)=each($ArrFav))
				foreach ($ArrFav as $k => $v)
				{					
					//$ArrPag=explode("-",$v); //WSO
					//$ArrPag=explode("-",$v[0]);		
					//var_dump($ArrPag);
					//echo "<br><br>";

					if(!empty($v)){
						$ArrPag=explode("-",$v[0]);//WSO
					}else{
						$ArrPag=explode("-",$v);//WSO
					}
					if(isset($ArrPag[0])){
						$ArrPag0=$ArrPag[0];
					}else{
						$ArrPag0="";
					}
					if(isset($ArrPag[1])){
						$ArrPag1=$ArrPag[1];
					}else{
						$ArrPag1="";
					}
					$Consulta="SELECT * FROM proyecto_modernizacion.pantallas ";
					$Consulta.= " WHERE cod_sistema='".$ArrPag0."' and cod_pantalla='".$ArrPag1."'";
					$Resp=mysqli_query($link, $Consulta);
						
					if ($Fila=mysqli_fetch_array($Resp))
					{
						//var_dump($Fila);
						echo "<tr bgcolor=\"#FFFFFF\">";
						echo "<td bgcolor=\"#FFFFFF\">";
						if ($Fila["estado"]=="N")
							echo "<font color='#999999'>".ucwords(strtolower($Fila["descripcion"]))."</font></tr></td>";
						else
							echo "<a href=\"JavaScript:Direcciona('".$Fila['cod_sistema']."','".$Fila['cod_pantalla']."','".$Fila["link"]."');\" class=\"Links02\">".substr(ucwords(strtolower($Fila["descripcion"])),0,20)."</a></tr></td>";
							//echo "<a href=\"JavaScript:Direcciona('".$row4['cod_sistema']."','".$row4['cod_pantalla']."','".$row4['link']."');\" class=\"Links02\">".ucwords(strtolower($row4["descripcion"]))."</a></tr></td>";
						echo "</td>";
						echo "</tr>";
						$CodPantalla = $Fila['cod_pantalla'];
					}
				}
			} //fin existe favoritos
			  ?>
          </table>
		  </div>
		  <div style="position:absolute; left: 259px; top: 12px; width: 330px; height: 18px;">
            <table width="330" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="290" align="center">
				<?php
				$CodSistema = $CodSistema * 1;
				if (isset($CodSistema) && ($CodSistema != 0))
				{
					if ($CodSistema < 10)
						$CodigoAux = "0".$CodSistema;
					else	$CodigoAux = $CodSistema;
					echo "<img src='imagenes/tit_sistema".$CodigoAux.".jpg'>";
				}
				?></td>
                <td width="26" align="right">
				<?php
				//echo "Nivel:".$Nivel;
				if ((!isset($Nivel)) || ($Nivel == 0))
				{
					$SistemaAnterior = 0;
					$NivelAnterior = 0;
				}
				else
				{
					$SistemaAnterior = $CodSistema;
					$NivelAnterior = $Nivel - 1;
				}
				if (isset($CodSistema) && ($CodSistema != 0))
				{
					echo "<a href='sistemas_usuario.php?CodSistema=".$SistemaAnterior."&Nivel=".$NivelAnterior."'><img src='imagenes/atras.gif' border=0></a></td>\n";
				}
				?>
              </tr>
            </table>
	      </div>
		  <div style="position:absolute; top:42px; left:260px; width:329px; height: 268px; overflow: auto;"> 
            <table border="0" width="100%" cellpadding="1" cellspacing="0" class="menu2">
				<tr><td>&nbsp;</td></tr>
                <?php
				    //echo "CodSistema:".$CodSistema."<br>";
					if (isset($CodSistema))
					{
						$Consulta = "SELECT * from sistemas_por_usuario where rut = '".$CookieRut."' and cod_sistema = ".$CodSistema." order by cod_sistema";
						$result = mysqli_query($link, $Consulta);
						if($row = mysqli_fetch_array($result)){
							$TipoUsuario = $row["nivel"]; 
							//$Nivel = $row["nivel"]; 
						}else{
							$TipoUsuario = 0;
						}	
						//echo "<br>TipoUsuario/Nivel:".$TipoUsuario."<br>";
						
						$consulta = "SELECT * from sistemas where cod_sistema = '".$CodSistema."' ";
						$result = mysqli_query($link, $consulta);

						if ($row = mysqli_fetch_array($result))
						{
							$ExisteNivel = true;
							if (!isset($Nivel))
							{
								$consulta = "select min(nivel_agrup) as nivel_agrup from acceso_menu";
								$consulta.= " where cod_sistema = '".$CodSistema."' ";
								$result2 = mysqli_query($link, $consulta);
	
								if ($row2 = mysqli_fetch_array($result2))
								{
									$Nivel = $row2["nivel_agrup"];
								}
								else
								{
									$ExisteNivel = false;
									if (($CodSistema != 0) && ($Nivel != 0))
										echo "NO HAY NIVELES DE MENÚ DEFINOS PARA EL SISTEMA";
								}
							}
							if (($ExisteNivel == true) && (isset($Nivel)))
							{
								if ($Nivel > 0)
								{
									
					
									$consulta = "SELECT * FROM pantallas";
									$consulta.= " WHERE cod_sistema = '".$CodSistema."' ";
									
									if (isset($CodPantalla))
										$consulta.= " and cod_pantalla = '".$CodPantalla."' ";
										$consulta.= " order by orden ";
										$result3 = mysqli_query($link, $consulta);
									if ($row3 = mysqli_fetch_array($result3))
									{
										echo "<tr>";
										echo "<td><img src='imagenes/ico_carpeta.gif'>&nbsp;<font  class='Links01'><strong>".ucwords(strtolower($row3["descripcion"]))."</strong></font></td></tr>\n";
									}
								}

								$consulta = "SELECT distinct(t1.cod_pantalla) as cod_pantalla";
								$consulta.= " FROM acceso_menu t1, pantallas t2";
								$consulta.= " WHERE t1.cod_sistema = '".$CodSistema."' "; 
								$consulta.= " AND t1.cod_sistema = t2.cod_sistema";
								$consulta.= " AND t1.cod_pantalla = t2.cod_pantalla";
								//$Consulta.= " where cod_sistema='".$Sistem."' and nivel='".$Nivel."'";

								if (isset($CodPantalla) || !(is_null($CodPantalla)) || ($CodPantalla != ""))
								{
									$consulta.= " AND t1.cod_pant_agrup ='".$CodPantalla."'";
								}
							
								$consulta.= " AND t1.nivel ='".$TipoUsuario."' ";
								$consulta.= " AND t1.nivel_agrup ='".$Nivel."' ";
								$consulta.= " ORDER BY t2.orden";

								//echo "consulta query:<BR>".$consulta."<br>";

								$result3 = mysqli_query($link, $consulta);

								//-------------CONTROL ACCESO USUARIOS---------------
								$HoraAcceso = date("Y-m-d H:i:s");
								//$IP_USER = $REMOTE_ADDR;

								//agregado por WSO
								$IP_USER   = $_SERVER['REMOTE_ADDR']; 
								$HTTP_HOST = $_SERVER['HTTP_HOST'];
								$Host      = $HTTP_HOST;

								//-------CONSULTA PC DEL CUAL SE ESTA ENTRANDO-------
								/*include("cerrar_principal.php");
								$link=mysql_connect("localhost","adm_sam","rhp19zt2");
								mysql_select_db("sam_bdweb_proyecto",$link);
								$Consulta = "Select * from ip where ip = '".$IP_USER."'";
								$Respuesta = mysqli_query($link, $Consulta);
								$Row = mysqli_fetch_array($Respuesta);
								$Host = $Row[HOSTNAME];
								mysqli_close($link);
								//----------------------------------------------------
								
								//-----------------GRABA EL ACCESO--------------------
								include("conectar_principal.php"); */
								$Insertar = "INSERT INTO control_acceso ";
								$Insertar.= " (fecha_hora, rut, ip, pc, sistema) ";
								$Insertar.= " VALUES ('".$HoraAcceso."', '".$CookieRut."', '".$IP_USER."', '".$Host."', '".$CodSistema."')";
								mysqli_query($link, $Insertar);

								//---------------------------------------------------
								while ($row3 = mysqli_fetch_array($result3))
								{		
									
									$Consulta = "SELECT * from pantallas where cod_pantalla = ".$row3["cod_pantalla"]." and cod_sistema = ".$CodSistema;
									//echo "Consulta:".$Consulta."<br>";
									$result4  = mysqli_query($link, $Consulta);
									$row4     = mysqli_fetch_array($result4);
									//echo "aqui se perdio un menu...";
									echo "<tr onMouseOver=\"CCA(this,'CL04')\" onMouseOut=\"CCA(this,'CL02')\"><td>&nbsp;&nbsp;&nbsp;";
									if ($row4["estado"]!="L")
									{
										switch ($row4["estado"])
										{
											case "T":
												echo "<img src='imagenes/img_trabajo.gif'>\n";
												break;
											case "N":
												echo "<img src='imagenes/img_no.gif'>\n";
												break;
										}
									}
									else
									{
										switch ($row4["tipo"])
										{
											case "0":
												echo "<img src='imagenes/img_no.gif'>\n";
												break;
											case "1":
												echo "<img src='imagenes/img_ingreso.gif' >\n";
												break;
											case "2":
												echo "<img src='imagenes/img_listado.gif' >\n";
												break;
											case "3":
												echo "<img src='imagenes/ico_carpeta.gif'>\n";
												break;
										}
									}
									if ($row4["estado"]=="N")
										echo "<font color='#999999'>".ucwords(strtolower($row4["descripcion"]))."</font></tr></td>";
									else
									 //echo "Link:".$row4['link'];
										echo "<a href=\"JavaScript:Direcciona('".$row4['cod_sistema']."','".$row4['cod_pantalla']."','".$row4['link']."');\" class=\"Links02\">".ucwords(strtolower($row4["descripcion"]))."</a></tr></td>";
								}
							}
						}
						else
						{
							if (($CodSistema != 0) && ($Nivel != 0))
								echo "<tr><td>SISTEMA NO ENCONTRADO</td></tr>";
						}
					}
				?>
            </table>
        </div></td>
      </tr>
    </table>
  </div>
  <?php
	if($mensajeInterno["Desc1"] != '')
	{
	  ?>
	  <div style="position:absolute; left: 5px; top: 435px;">
	  <?php
	}
	else
	{
	  ?>
	  <div style="position:absolute; left: 5px; top: 405px;">
	  <?php
	}
  ?>
    <TABLE width="770" height="23" border=0 cellPadding=3 cellSpacing=0>
      <TBODY>
        <TR>
          <TH width="760" height="25" valign="bottom" noWrap background="imagenes/fondoabajo_b.jpg"><table width="700" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="76">&nbsp;</td>
                <td width="10" valign="top"></td>
                <td width="143"><a href="mailto:pfari002@codelco.cl" style="text-decoration:none; color:#666666; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">&nbsp;Contacto</a></td>
                <td width="10"></td>
                <td width="143"><a href="http://www.codelco.cl" target="_blank" style="text-decoration:none; color:#666666; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">&nbsp;Web Codelco </a></td>
                <td width="12"></td>
                <td width="141"><a href="http://vevmwebp001/Intranet" target="_blank" style="text-decoration:none; color:#666666; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">&nbsp;Intranet</a></td>
                <td width="10"></td>
                <td width="155"><a href="http://<?php echo $IP_SERV;?>/proyecto/" style="text-decoration:none; color:#666666; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">&nbsp;Inicio</a></td>
              </tr>
          </table></TH>
        </TR>
      </TBODY>
    </TABLE>
  </div>
  
</form>
</body>
</html>
