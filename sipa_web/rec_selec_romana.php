<?php
	$CodigoDeSistema=24;
	$CodigoDePantalla=3;
	include("../principal/conectar_principal.php");
	include("funciones.php");

	$Dir  = isset($_REQUEST["Dir"])?$_REQUEST["Dir"]:"";
	$tipo = isset($_REQUEST["tipo"])?$_REQUEST["tipo"]:"";
	$Frm  = isset($_REQUEST["Frm"])?$_REQUEST["Frm"]:"";

	$COMPUTERNAME =  getenv("COMPUTERNAME"); //nombre de la PC : WSALDANA-PERU
	/*
		if(isset($_REQUEST["RNA"])){
			$RNA=$_REQUEST["RNA"];
		}else{
			$RNA="";
		}
		if(isset($_REQUEST["Bloq1"])){
			$Bloq1=$_REQUEST["Bloq1"];
		}else{
			$Bloq1="";
		}
		if(isset($_REQUEST["Bloq2"])){
			$Bloq2=$_REQUEST["Bloq2"];
		}else{
			$Bloq2="";
		}
	*/

/*
$directorio = "C:/";
$ficheros1  = scandir($directorio);
$ficheros2  = scandir($directorio, 1);
 
print_r($ficheros1);
print_r($ficheros2);
*/
//echo "<br>Direc:".$Dir;
	
$Tolerancia=ToleranciaPesaje($link);

//$ROMA = LeerArchivo('PesaMatic','ROMANA.txt');
$ROMA = LeerRomana($COMPUTERNAME,$link);
if($ROMA==1){
	$Bas1 = LeerArchivo('configuracion_pesaje','PesoMatic_1.txt');
	$Bas2 = LeerArchivo('configuracion_pesaje','PesoMatic2_1.txt');
}
if($ROMA==2){
	$Bas1 = LeerArchivo('configuracion_pesaje','PesoMatic_2.txt');
	$Bas2 = LeerArchivo('configuracion_pesaje','PesoMatic2_2.txt');
}

//$Bas1 = LeerArchivo('','PesoMatic.txt');
//$Bas2 = LeerArchivo('','PesoMatic2.txt');

/*
echo "Tolerancia:".$Tolerancia;
echo "<br>ROMA:".$ROMA;
echo "<br>Bas1:".$Bas1;
echo "<br>Bas2:".$Bas2;
*/

//exit();
?>	
<html><head>
<title>Lectura de Romana</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
	function Redirecciona(Pag,ROMA,Bas1,Bas2)
	{	
		var Bloq1='';
		var Bloq2='';
		var f = document.FromSelecRomana;

		if(Bas1 > parseInt('<?php echo $Tolerancia; ?>'))
		{
			Bloq1='S';
		}
		if(Bas2 > parseInt('<?php echo $Tolerancia; ?>'))
		{
			Bloq2='S';
		}
		f.action= Pag+".php?RNA="+ROMA+"&Bloq1="+Bloq1+"&Bloq2="+Bloq2;
		//alert(f.action);
		f.submit();	
	}
</script>
<body onLoad="Redirecciona('<?php echo $Dir;?>','<?php echo $ROMA;?>','<?php echo $Bas1;?>','<?php echo $Bas2;?>')">
<form action="" method="post" name="FromSelecRomana" >
</form>
</body>
</head>
</html>