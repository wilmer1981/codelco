<?php
	$CodigoDeSistema=24;
	$CodigoDePantalla=3;
	include("../principal/conectar_principal.php");
	include("funciones.php");


	if(isset($_REQUEST["Dir"])){
		$Dir=$_REQUEST["Dir"];
	}else{
		$Dir="";
	}

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

/*
$directorio = "C:/";
$ficheros1  = scandir($directorio);
$ficheros2  = scandir($directorio, 1);
 
print_r($ficheros1);
print_r($ficheros2);
*/
echo "<br>Direc:".$Dir;
	
$Tolerancia=ToleranciaPesaje($link);
?>	
<html><head>
<title>Lectura de Romana</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<script language="javascript" src="../principal/funciones/funciones_java.js"></script>
<script language="javascript">
 function LeerArchivo(valor)
{
	var ubicacion = "C:\\PesoMatic.txt";
	//var ubicacion = "C:/PesoMatic.txt";
	//alert("No Existe archivo en: "+ubicacion ) 
var valor="";
	var fso, f1, ts, s,retorno; 
		var ForReading = 1; 
	fso = new ActiveXObject("Scripting.FileSystemObject"); 
	if(fso.FileExists(ubicacion)){
          f = fso.OpenTextFile( ubicacion, ForReading); 
		  valor=f.Readline(); 
        } else {
       alert("No Existe archivo en: "+ubicacion ) 
	
	   }
		return(valor); 
}

 function LeerArchivo2(valor)
{
	var ubicacion = "C:\\PesoMatic2.txt";
	//var ubicacion = "C:/PesoMatic2.txt";
	var valor="";
	var fso, f1, ts, s,retorno; 
		var ForReading = 1; 
	fso = new ActiveXObject("Scripting.FileSystemObject"); 
	if(fso.FileExists(ubicacion)){
          f = fso.OpenTextFile( ubicacion, ForReading); 
		  valor=f.Readline(); 
        } else {
       alert("No Existe archivo en: "+ubicacion ) 
	
	   }
		return(valor); 
}

 function LeerRomana(Rom)
{
	var ubicacion = "C:\\PesaMatic\\ROMANA.txt";
	//var ubicacion = "C:/PesaMatic/ROMANA.txt";
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
	return(valor); 
}
var ROMA=LeerRomana('');
function Redirecciona(Pag)
{	
	var Bloq1='';
	var Bloq2='';
	var f = document.FromSelecRomana;
	ROMA=LeerRomana('');
	var Bas2=LeerArchivo('');
	var Bas1=LeerArchivo2('');
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
<body onLoad="Redirecciona('<?php echo $Dir;?>')">
<form action="" method="post" name="FromSelecRomana" >
</form>
</body>
</head>
</html>