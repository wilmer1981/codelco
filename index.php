<script type="text/javascript">
	//var URLactual = window.location.href;
    //alert(URLactual);
/*
var URLactual = window.location;
alert(URLactual);
var pathname = window.location.pathname;
alert(pathname);
*/
const valores = window.location.search;
//alert("url:"+valores);
//Creamos la instancia
const urlParams = new URLSearchParams(valores);
//Accedemos a los valores
var mensaje = urlParams.get('mensaje');
//alert("valor mensaje: "+mensaje);

function javascript_to_php(mensaje) {
    //window.location.href = window.location.href + "?mensaje=" + jsVar1;
	window.location.href = window.location.href + "?mensaje=" + mensaje;
	//alert("alerta:"+window.location.href);
}
</script>
<?php
// comprobar si tenemos los parametros de la URL
if (isset($_REQUEST["mensaje"]) ) {
    $mensaje = $_REQUEST["mensaje"];
} else {
	$mensaje = "";
}

function getRealIP(){

	if (isset($_SERVER["HTTP_CLIENT_IP"])){
		//echo "entro:1";
		return $_SERVER["HTTP_CLIENT_IP"];

	}elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
		//echo "entro:2";
		return $_SERVER["HTTP_X_FORWARDED_FOR"];

	}elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
		//echo "entro:3";
		return $_SERVER["HTTP_X_FORWARDED"];

	}elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
		//echo "entro:4";
		return $_SERVER["HTTP_FORWARDED_FOR"];

	}elseif (isset($_SERVER["HTTP_FORWARDED"])){
		//echo "entro:5";
		return $_SERVER["HTTP_FORWARDED"];

	}else{
		//echo "entro:6";
		return $_SERVER["REMOTE_ADDR"];

	}
} 

session_start();
include("principal/conectar_index.php");
	//$IpUser=$HTTP_SERVER_VARS["REMOTE_ADDR"];	
	//$IpUser = $_SERVER['REMOTE_ADDR'];
	$IpUser = getRealIP();
	//$IpUser='10.56.44.189';
 	$Consulta = "select * from proyecto_modernizacion.funcionarios ";
	$Consulta.= " where pc='".$IpUser."'";
 	//echo "prueba:".$Consulta;
	//exit();
    $Resp=mysqli_query($link, $Consulta);
	$Recordar="";
	$txtrut="";
	$user="";
	if ($Fila=mysqli_fetch_array($Resp))
	{
		$txtrut=$Fila["rut"];
		$user  =$Fila["id_usuario"];
	}
	//if(isset($txtrut)){
	//if(!empty($txtrut)){ //si txtrut es diferente de vacio
	if($txtrut!="")
	{
		echo "Datos de Consulta <br>";
		echo "rrrrut: ".$txtrut;
		echo "<br>user: ".$user;
		echo "<br>";
	}

	setcookie("CookieRutAUX", "");
	setcookie("EncontroPortalX", "");
	$Encontro=""; // agregado por wso
	//if(isset($user))
	//if(!empty($user)) // si user no esta vacia
	if($user!="")
	{

		//echo "Ingreso Usuario existe<br><br>";
		$Consulta = "SELECT rut, password ";
		$Consulta.= " FROM proyecto_modernizacion.funcionarios ";
		$Consulta.= " WHERE UPPER(id_usuario) = '".strtoupper($user)."'"; //consulta en la tabla funcionarios

		//echo $Consulta;
		$rs = mysqli_query($link, $Consulta);
		if($row = mysqli_fetch_array($rs))
		{
			$Encontro='S';
			setcookie("CookieRutAUX", $row["rut"]);
			$CookieRutAUX=$row["rut"];
			setcookie("EncontroPortalX", "S");
			$EncontroPortalX='S';
			echo "<br><br>Encontro:".$EncontroPortalX;
			echo "<br>CookieRutAUX:".$CookieRutAUX;
			//include("index01.php");
		}
	}

	//Junio 2017 Traigo el parametro de cantidad máxima de intentos fallidos
	$ConsulMax="select valor from parametros_auditoria where codigo=1";
	$RespMax=mysqli_query($link, $ConsulMax);
	if($Fila=mysqli_fetch_assoc($RespMax))
		$maxIntentos = $Fila["valor"];
		//Junio 2017 Contador intentos fallidos por medio de cookies
		if($mensaje=="PI")
		{
			if (isset($_SESSION["rutIntento"]))
			{
				if ($_SESSION["rutIntento"]==$txtrut)
					$_SESSION["intentos"]++;
				else
				{
					$_SESSION["rutIntento"]=$txtrut;
					$_SESSION["intentos"]=1;
				}
			}else{
				$_SESSION["rutIntento"]=$txtrut;
				$_SESSION["intentos"]=1;
			}
		}else{
			$_SESSION["intentos"]=0;
		}
	


if($Encontro!='S')
{ 
?> 
<html>
<head>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" >
	<link rel="stylesheet" href="principal/estilos/css_principal.css">
	<title>Sistemas Informaticos Locales</title>
	<style type="text/css">
    	#login-externo { display:none; }
		#login-ldap { display:block; }
	</style>
	<script language="JavaScript">
		// FUNCION DE FOCO DE CAMPOS
		foco = ""; // PRIMERO NOMBRAR LOS CAMPOS DEL FORMULARIO
		netscape = "";
		ver = navigator.appVersion; len = ver.length;
		for(iln = 0; iln < len; iln++) if (ver.charAt(iln) == "(") break; 
			netscape = (ver.charAt(iln+1).toUpperCase() != "C");
			
			function keyDown(DnEvents) {
				// IE o netscape
				k = (netscape) ? DnEvents.which : window.event.keyCode;
				if (k == 13) { // preciona tecla enter
				if (foco == 'btnEntrar') {
					var f = document.frmPrincipal;
					var l = document.frmLdap;
					var rut    = f.txtrut.value;
					var passwd = f.txtpassword.value;
					var opc    = f.opcion.value;
					//alert("f.RUT:"+rut+"f.PASSWD:"+passwd+" f.OPCION:"+opc);
					if(rut==""){
						//alert("f.RUT:"+rut+"f.PASSWD:"+passwd+" f.OPCION:"+opc);
						if (ValidaCamposL())
						{
							//alert("Ingresando a index01");
							var rut    = l.txtrut.value;
							var passwd = l.txtpassword.value;
							var opc    = l.opcion.value;
							//alert("Cuenta:"+rut+" PASSWD:"+passwd+" OPCION:"+opc);
							l.action = "index01.php";
							l.submit();
						}
						/*
						if (l.txtrut.value == "")
						{
							alert("Debe Ingresar Cuenta");
							l.txtrut.focus();
							return false;
						}
						if (l.txtpassword.value == "")
						{
							alert("Debe Ingresar Password Red");
							l.txtpassword.focus();
							return false;
						}
						l.action = "index01.php";
						l.submit();
						return false;
						//return true; // envia cuando termina los campos
						*/
					}else{
						
						if (ValidaCamposE())
						{
							//alert("Ingresando a index01");
							var rut    = f.txtrut.value;
							var passwd = f.txtpassword.value;
							var opc    = f.opcion.value;
							//alert("RUT:"+rut+"PASSWD:"+passwd+" OPCION:"+opc);
							f.action = "index01.php";
							f.submit();
						}
						/*
						if (f.txtrut.value == "")
						{
							alert("Debe Ingresar Rut");
							f.txtrut.focus();
							return false;
						}
						if (f.txtpassword.value == "")
						{
							alert("Debe Ingresar Password");
							f.txtpassword.focus();
							return false;
						}
						f.action = "index01.php";
						f.submit();
						return false;
						*/
					}				

				} else {
					// si existen mas campos va para el proximo
					eval('document.frmPrincipal.' + foco + '.focus()');
					return false;
				}
			}
		}
		document.onkeydown = keyDown; // work together to analyze keystrokes
	</script>

<script language="JavaScript">
//var URLactual = window.location;
//alert(URLactual);
//var pathname = window.location.pathname;
//alert(pathname);
/*
const valores = window.location.search;
alert("url:"+valores);
//Creamos la instancia
const urlParams = new URLSearchParams(valores);
//Accedemos a los valores
var mensaje = urlParams.get('mensaje');
alert("valor mensaje: "+mensaje);
*/
function OcultarLogin() {
    var ldap = document.getElementById("login-ldap");
	var extn = document.getElementById("login-externo");

    if (ldap.style.display === "block") {
        ldap.style.display = "none";
		extn.style.display = "block";
    }else{
        ldap.style.display = "block";
		extn.style.display = "none";
	}
}

function ValidaCamposE()
{
	var f = document.frmPrincipal;
	if (f.txtrut.value == "")
	{
		alert("Debe Ingresar Rut");
		f.txtrut.focus();
		return false;
	}
	if (f.txtpassword.value == "")
	{
		alert("Debe Ingresar Password");
		f.txtpassword.focus();
		return false;
	}
	return true;
}
function ValidaCamposL()
{
	var l = document.frmLdap;
	if (l.txtrut.value == "")
	{
		alert("Debe Ingresar Cuenta");
		l.txtrut.focus();
		return false;
	}
	if (l.txtpassword.value == "")
	{
		alert("Debe Ingresar Password Red");
		l.txtpassword.focus();
		return false;
	}
	return true;
}
//*************************//
function Entrar(opt)
{
	var f = document.frmPrincipal;
	var l = document.frmLdap;
	if (opt == "E")
	{
		if (ValidaCamposE())
		{
			//alert("Ingresando a index01");
			var rut    = f.txtrut.value;
			var passwd = f.txtpassword.value;
			var opc    = f.opcion.value;
			//alert("RUT:"+rut+"PASSWD:"+passwd+" OPCION:"+opc);
		    f.action = "index01.php";
			f.submit();
		}
	}else if(opt == "L"){
		if (ValidaCamposL())
		{
			//alert("Ingresando a index01");
			var rut    = l.txtrut.value;
			var passwd = l.txtpassword.value;
			var opc    = l.opcion.value;
			//alert("Cuenta:"+rut+" PASSWD:"+passwd+" OPCION:"+opc);
			l.action = "index01.php";
			l.submit();
		}

	}else
	{
		f.action = "http://<?php echo HTTP_SERVER;?>";
		f.submit();
	}
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
//Junio 2017 Funcion que muestra feedback al usuario de su ingreso al sistema
//input: String
function verMensaje(Msj)
{	
	var f=document.frmPrincipal;
	var l=document.frmLdap;
	//alert("Opcion:"+l.opcion);

	var ldap = document.getElementById("login-ldap");
	var extn = document.getElementById("login-externo");
    /*
    if (ldap.style.display === "block") {
        ldap.style.display = "none";
		extn.style.display = "block";
    }else{
        ldap.style.display = "block";
		extn.style.display = "none";
	}*/
	opcionf = f.opcion;
	opcionl = l.opcion;
	if(Msj=='BLOQ')	//Bloqueo por intentos fallidos
	{
		document.getElementById("msjIntento").innerHTML = " <strong>La clave ha sido bloqueada por alcanzar el m\xE1ximo de intentos. Contacte al administrador</strong>";
	}
	if(Msj=='BQ')	//Cuenta bloqueada
	{
		document.getElementById("msjIntento").innerHTML = " <strong>Su clave se encuentra bloqueada. Contacte al administrador</strong>";
	}
	if(Msj=='PI')	//Contraseña incorrecta
	{

		var maxIntento = <?php echo json_encode($maxIntentos);?>;
		document.getElementById("msjIntento").innerHTML = " <strong>Datos incorrectos. Luego de "+maxIntento+" intentos la clave ser\xE1 bloqueada.(Intento <?php echo json_encode($_SESSION["intentos"]);?>)</strong>";
		f.txtpassword.focus();	
		ldap.style.display = "none";
		extn.style.display = "block";

	}	
	if(Msj=='UN')	//Usuario no existe
	{
		ldap.style.display = "none";
		extn.style.display = "block";
		document.getElementById("msjIntento").innerHTML = " <strong>Datos ingresados incorrectos.</strong>";
	}
	if(Msj=='LDAP')	//Cuenta LDAP no exite
	{
		document.getElementById("msjIntentoLdap").innerHTML = " <strong>No es posible validar su usuario. No posee nombre de red LDAP. Contacte al administrador.</strong>";
	}
	if(Msj=='NPLDAP')	//Credencial LDAP Invalido
	{
		document.getElementById("msjIntentoLdap").innerHTML = " <strong>Credencial de Red Invalido. Contacte al administrador.</strong>";
	}
	
	if(Msj=='' && opcionl=="Ldap" )	//por defecto
	{
		document.getElementById("msjIntentoLdap").innerHTML = "Ingrese Cuenta y Clave de Red";
	}else{
		document.getElementById("msjIntento").innerHTML = "Ingrese RUT y Clave de Sistema";
	}
	
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body leftmargin="3" topmargin="3" marginwidth="0" marginheight="0" onLoad="verMensaje('<?php echo $mensaje?>')" >
<?php
	//if ($Recordar!="")
	//	echo "onLoad=\"JavaScript:document.frmPrincipal.txtpassword.focus();\"";
	//else
	//	echo "onLoad=\"JavaScript:document.frmPrincipal.txtrut.focus();\"";
?>

<div style="position:absolute; left: 5px; top: 2px;">
  <TABLE width=770 height="44" border=0 cellPadding=0 cellSpacing=0>
    <TBODY>
      <TR> 
        <th valign="top"><img src="principal/imagenes/fondoarriba.jpg"></th>
      </TR>
    </TBODY>
  </TABLE>
</div>
<div style="position:absolute; left: 5px; top: 53px; width: 770;" class="TablaPrincipal2">
  <table width="760" border="0" cellspacing="0" cellpadding="0" class="TablaSinFondo">
    <tr>
      <td height="30" align="right"><table width="755">
            <tr valign="middle"> 
              <td width="312"><img src="principal/imagenes/fun_ref.gif" align="absmiddle"></td>
              <td width="206" align="right"><font color="#666666"><font face="Times New Roman, Times, serif">Servidor 
                <?php echo HTTP_SERVER;?>
              </font></font></td>
              <td width="221" align="right" valign="middle"><font size="2" face="Times New Roman, Times, serif">&nbsp; 
                </font><font color="#666666" face="Times New Roman, Times, serif"> 
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
                <?php echo $Dias[$str_dia]." ".$dia." de ".$Meses[$mes]." de ".$ano; ?>
                </font></td>
            </tr>
          </table></td>
    </tr>
  </table>
</div> 

<div style="position:absolute; left: 5px; top: 86px; width: 770px; height: 321px;">
  	<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
		<tr> 				
			<td height="316" align="center" valign="middle" background="principal/imagenes/fondo3.gif">
				<div style="position:absolute; left: 14px; top: 16px; width: 363px; height: 255px;"><img src="principal/imagenes/fondo_inicio.jpg"></div>
				    <form name="frmPrincipal" method="post" action="">
						<div id="login-externo" style="position:absolute; left: 470px; top: 83px; width: 279px; height: 150px;display: none;">
							<table width="207" border="0" cellpadding="2" cellspacing="0" class="TablaPrincipal3">
								<tr> 
									<td colspan="2"><?php //echo "User:".$user."<br>Var:".$EncontroPortalX."&nbsp;&nbsp;Coo:".$CookieRutAUX;?>&nbsp;</td>
								</tr>
								<tr> 
									<td width="111" height="21"><img src="principal/imagenes/img_rut.gif" ></td>
									<td width="99">
									<?php
									$txtrut="";
									$txtpassword="";
									?>
									<input name="txtrut" type="text" class="InputIni" onFocus="foco='txtpassword';" value="<?php echo $txtrut;?>" size="15" maxlength="15">
									</td>
								</tr>
								<tr> 
									<td><img src="principal/imagenes/img_pass.gif" ></td>
									<td><input name="txtpassword" type="password" class="InputIni" onFocus="foco='btnEntrar';" value="<?php echo $txtpassword;?>" size="15" maxlength="15"></td>
								</tr>
								<tr align="right" valign="middle">
									<td colspan="2"><a href="JavaScript:Entrar('E')"><img src="principal/imagenes/img_entrar.gif" border="0" ></a></td>
								</tr>
								<tr align="left" valign="middle">
									<td colspan="5"><div id="msjIntento" style="color:red;font-size:11px;font-weight:bold"></div></td>  
									<td><input name="maxIntentos" type="hidden" onFocus="foco='btnEntrar';" value="<?php echo $maxIntentos;?>" size="15" maxlength="15"></td>
									<td>
										<input name="intentos" type="hidden" onFocus="foco='btnEntrar';" value="<?php echo $_SESSION['intentos'];?>" size="15" maxlength="15">
										<input name="opcion" type="hidden" value="Ext">
									</td>
								</tr>
							</table><br>
							<table width="207" border="0" cellpadding="2" cellspacing="0">
							   <tr align="left" valign="middle">
									<td>
										<strong><a href="javascript:OcultarLogin();">¿Usuario LDAP?</a></strong>
									</td>
								</tr>
							</table>
						</div> 
					</form>
					<form name="frmLdap" method="post" action="">
						<div id="login-ldap" style="position:absolute; left: 470px; top: 83px; width: 279px; height: 150px;display:block;">
							<table width="207" border="0" cellpadding="2" cellspacing="0" class="TablaPrincipal3">
								<tr> 
									<td colspan="2"><?php //echo "User:".$user."<br>Var:".$EncontroPortalX."&nbsp;&nbsp;Coo:".$CookieRutAUX;?>&nbsp;</td>
								</tr>
								<tr> 
									<td width="111" height="21"><div style="color:white;font-size:11px;font-weight:bold;text-shadow: black 0.2em 0.2em 0.2em">CUENTA:</div></td>
									<td width="99">
									<?php
									$txtrut="";
									$txtpassword="";
									?>
									<input name="txtrut" type="text" class="InputIni" onFocus="foco='txtpassword';" value="<?php echo $txtrut;?>" size="15" maxlength="15">
									</td>
								</tr>
								<tr> 
									<td><div style="color:white;font-size:11px;font-weight:bold;text-shadow: black 0.2em 0.2em 0.2em">CONTRASEÑA:</div></td>
									<td><input name="txtpassword" type="password" class="InputIni" onFocus="foco='btnEntrar';" value="<?php echo $txtpassword;?>" size="15" maxlength="15"></td>
								</tr>
								<tr align="right" valign="middle">
									<td colspan="2"><a href="JavaScript:Entrar('L')"><img src="principal/imagenes/img_entrar.gif" border="0" ></a></td>
								</tr>
								<tr align="left" valign="middle">
									<td colspan="5">
										<div id="msjIntentoLdap" style="color:red;font-size:11px;font-weight:bold">Ingrese Cuenta y Clave de Red</div>
										<div style="color:red;font-size:11px;font-weight:bold"></div>
									</td>  
									<td><input name="maxIntentos" type="hidden" onFocus="foco='btnEntrar';" value="<?php echo $maxIntentos;?>" size="15" maxlength="15"></td>
									<td>
										<input name="intentos" type="hidden" onFocus="foco='btnEntrar';" value="<?php echo $_SESSION['intentos'];?>" size="15" maxlength="15">
										<input name="opcion" type="hidden" value="Ldap">
									</td>
								</tr>
							</table><br>
							<table width="207" border="0" cellpadding="2" cellspacing="0">
								<tr align="left" valign="middle">
									<td>
										<strong><!--<a href="#" id="sampleApp" onclick="OcultarLogin(); return false;">Click Here</a>-->
										<a href="javascript:OcultarLogin();">¿Usuario Externo?</a></strong>
									</td>
								</tr>
							</table>
						</div>
					</form>
				</div>
			</td>
		</tr>
  	</table>
</div>
<div style="position:absolute; left: 5px; top: 405px;">
  <TABLE width="770" height="23" border=0 cellPadding=3 cellSpacing=0>
    <TBODY>
      <TR> 
          <TH width="770" height="25" valign="bottom" noWrap background="principal/imagenes/fondoabajo_b.jpg"><table width="700" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="76">&nbsp;</td>
                <td width="10" valign="top">&nbsp;</td>
                <td width="143"><a href="mailto:pfari002@codelco.cl" style="text-decoration:none; color:#666666; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">&nbsp;Contacto</a></td>
                <td width="10">&nbsp;</td>
                <td width="143"><a href="http://www.codelco.cl" target="_blank" style="text-decoration:none; color:#666666; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">&nbsp;Web Codelco </a></td>
                <td width="12">&nbsp;</td>
                <td width="141"><a href="http://<?php echo HTTP_SERVER;?>/proyecto/intranet/" target="_blank" style="text-decoration:none; color:#666666; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">&nbsp;Intranet</a></td>
                <td width="10">&nbsp;</td>
                <td width="155"><a href="http://<?php echo HTTP_SERVER;?>/proyecto/" style="text-decoration:none; color:#666666; font-size:10px; font-family: Verdana, Arial, Helvetica, sans-serif;">&nbsp;Inicio</a></td>
              </tr>
            </table></TH>
      </TR>
    </TBODY>
  </TABLE>
  </div>
</form>
</body>
</html>
<?php
}
?>