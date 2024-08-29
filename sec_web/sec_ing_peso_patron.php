<?php 
	//include("../principal/conectar_sec_web.php");
	require("../principal/conectar_index.php");
	include("funciones_interfaces_codelco.php");
	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 81;
    $REMOTE_ADDR  = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$CookieRut   = $_COOKIE["CookieRut"];
	$msj         = isset($_REQUEST["msj"])?$_REQUEST["msj"]:"";
	$txtpeso     = isset($_REQUEST["txtpeso"])?$_REQUEST["txtpeso"]:"";
	$mensaje     = isset($_REQUEST["mensaje"])?$_REQUEST["mensaje"]:"";

?>

<html>
<head>
<title>Pesaje Patr&oacute;n</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
/*
 function LeerArchivo(valor)
{
	var ubicacion = "C:\\PesoMatic.txt";
	var valor="";
	var fso, f1, ts, s,retorno; 
	var ForReading = 1; 
	fso = new ActiveXObject("Scripting.FileSystemObject"); 
	if(fso.FileExists(ubicacion))
	{
          f = fso.OpenTextFile( ubicacion, ForReading); 
		  valor=f.Readline(); 
    }
	else
	{
       alert("No Existe archivo en :"+ubicacion);
	}
	valor=parseFloat(valor.replace(',','.').replace(' ',''));
	if (parseInt(valor))
	{
		valor=valor/10;
		//valor=valor.replace('.',',');
		valor=valor.toString().replace('.',',');
		
	}
	return(valor); 
}*/
/***************/
function Grabar()
{
	var f = document.frm1;	
	f.action = "sec_ing_peso_patron01.php?proceso=G";
	f.submit();
}

/***************/
function VerDatos()
{	
	var f = document.frm1;	

				//alert("else");*/
				window.open("sec_consulta_peso_patron_popup.php?Buscar=S","","top=195,left=180,width=600,height=360,scrollbars=no,resizable=no");
	
}
/***************/
function Limpiar()
{
	document.location = "sec_ing_peso_patron.php";	
}
/***************/
function Salir()
{		
	document.location = "../principal/sistemas_usuario.php?CodSistema=3";
}

function PesoAutomatico()
{
	setTimeout("CapturaPeso()",500);
}	
/*****************/
function CapturaPeso()
{
	var f = document.frm1;
	//f.txtpeso.value = LeerArchivo(f.txtpeso.value);
	
	//f.txtpeso.value = '<?php echo LeerArchivo('','PesoMatic.txt'); ?>'; 
	//setTimeout("CapturaPeso()",200);
	
	//valor = '<?php echo LeerArchivo('','PesoMatic.txt'); ?>'; 
	valor = '<?php echo LeerArchivo('configuracion_pesaje','PesoMatic_1.txt'); ?>';
	if(valor==''){
		alert("No existe el archivo...");
	}else{
		f.txtpeso.value = valor; 
	}

	setTimeout("CapturaPeso()",200);	
}
</script>
</head>
  <?php
		  	$Consulta = "SELECT * from proyecto_modernizacion.funcionarios ";
			$Consulta.= " WHERE rut='".$CookieRut."'";
			$Resp = mysqli_query($link, $Consulta);
			$Favoritos="";
			if ($Fila=mysqli_fetch_array($Resp))
			{
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
				
			}
	
			$IpUser=$_SERVER['REMOTE_ADDR'];
			$Nombre_Bascula="";
			$Cod_Bascula="";
		  	$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase=3112 and  valor_subclase1='".$IpUser."' ";
			$Resp=mysqli_query($link, $Consulta);			
			if ($Fila=mysqli_fetch_array($Resp))
			{
				$Nombre_Bascula=$Fila['nombre_subclase'];
				$Cod_Bascula=$Fila['cod_subclase'];
			}
			else
			{
				$mensaje="Su IP ".$IpUser.", no se encuentra registrada para realizar este tipo de pesaje.<br> Favor contactar con administrador";
				
			}
			
		  ?>
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0" onLoad="PesoAutomatico()">
<form name="frm1" action="" method="post">
<?php include("../principal/encabezado.php"); ?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="top">
	   
  <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
   <?php 
   if($mensaje!='')
   {
	?>
		<tr>
		  <td colspan="2" align="center"><strong><font color="#FF0000"><?php echo $mensaje;?></font></strong></td>
	   </tr>
	<?php
   }
   ?>
          <tr>
            <td width="113">B&aacute;scula Asignada</td>
            <td width="472"><?php echo $Cod_Bascula." - ".htmlentities($Nombre_Bascula);?></td>
          </tr>
          <tr> 
            <td>Peso Patr&oacute;n</td>
            <td><input name="txtpeso" readonly type="text" size="10" value="<?php echo $txtpeso;?>"></td>
          </tr>
          <tr> 
            <td>Responsable Ingreso</td>
            <td><?php echo htmlentities($NombreUser); ?></td>
          </tr>
        </table><br>

  <table width="600" border="0" cellspacing="0" cellpadding="3" class="TablaInterior">
    <tr>
            <td align="center"> 
        <?php 
	   if($mensaje!='')
	   {
			 ?><input name="btngrabarno" type="button"  value="Grabar"  disabled style="width:70" >
	   <?php
       }
	   else
	   {
		?><input name="btngrabar" type="button"  value="Grabar" style="width:70" onClick="Grabar()">
		<?php
	      }
		?>
      <input name="btnver" type="button" style="width:70" value="Ver Datos" onClick="VerDatos()">
       <input name="btnsalir" type="button"   value="Salir" style="width:70" onClick="Salir()"></td>
	         
          </tr>
  </table></td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>  
</form>
<?php
	switch($msj)
	{
		
		case '0':
		$mensaje="Registro realizado existosamente.";
		break;
		
		case '1':
		$mensaje="Su IP no cuenta con permisos para realizar este tipo de pesaje";
		break;

	case '2':
		$mensaje="El peso a registrar debe ser mayor a 0";
		break;
	case '3':
		$mensaje="Error al registrar el peso patron";
		break;
			echo '<script language="JavaScript"> alert("'.$mensaje.'") </script>';
		
	}
	if($msj!='')
	{
		echo '<script language="JavaScript"> alert("'.$mensaje.'") </script>';
	}
?>
</body>
</html>
