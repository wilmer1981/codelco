<?
include('conectar_ori.php');
if(!isset($Navega))
{
	$Navega=",0,";
	$Estado='C';
}
?><head>
<!--<script language="JavaScript" type="text/javascript" src="ajax.js"></script>-->
<title>Organica</title>
<script language="JavaScript">
function BuscaHijos(Codigo,Filtro)
{
	var f=document.FrmOrganica;
	var Estados='';
	
	f.Navega.value=Codigo;
	//f.SelTarea.value='';
	f.Estado.value=Codigo;
	if(Filtro!='S')
	  f.SelTarea.value='';
	var EstadoItem='';
	
	EstadoItem=f.Estado.value.split(",");
	for (var i=0;i<EstadoItem.length;i++)
	{
		if(EstadoItem[i]!='')
			Estados=Estados+"A,";
	}
	f.Estado.value=Estados.substr(Estados,Estados.length-2,2);
	f.Estado.value=f.Estado.value+"C";
	
	f.action='organica_mantenedor.php';
	f.submit();
	top.frames['Procesos'].location='procesos_mantenedor.php';
	f.submit();	
}
function BuscaItem()
{
	var f=document.FrmOrganica;
	
	top.frames['Cabecera'].document.FrmCabecera.TxtBuscaTarea.value='';
	f.SelTarea.value=top.frames['Cabecera'].document.FrmCabecera.CmbTareas.value;
	if(top.frames['Cabecera'].document.FrmCabecera.CmbTareas.value!='S')
	{
		BuscaHijos(top.frames['Cabecera'].document.FrmCabecera.CmbTareas.value,'S')
		top.frames['Procesos'].location='procesos_mantenedor.php?&MostrarCmb=S&CodSelTarea='+f.SelTarea.value+'&TipoPestana='+top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value;
		f.submit();	
	}	
}
function BuscaItem2(Cod,Msj)
{
	var f=document.FrmOrganica;
	
	//BuscaHijos(Cod,'S')
	top.frames['Procesos'].location='procesos_mantenedor.php?MostrarCmb=S&CodSelTarea='+f.SelTarea.value+'&TipoPestana='+top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value+'&Msj='+Msj;
	f.submit();	
	
}
function SelecItem(Codigo)
{
	var f=document.FrmOrganica;
	
	//alert(Codigo);
	f.Navega.value=Codigo;
}
function ItemSelec(Codigo)
{
	var f=document.FrmOrganica;
	
	f.SelTarea.value=Codigo;
	top.frames['Procesos'].location='procesos_mantenedor.php?CodSelTarea='+f.SelTarea.value+'&MostrarCmb=S&TipoPestana='+top.frames['Cabecera'].document.FrmCabecera.PestanaActiva.value;
	f.submit();	
}
</script>
</head>

<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<body>
<form name='FrmOrganica' method="post">
<input type="hidden" value="<? echo $Navega;?>" name="Navega">
<input type="hidden" value="<? echo $Estado;?>" name="Estado">
<input type="hidden" value="<? echo $SelTarea;?>" name="SelTarea">
<div style='position:absolute; left:10px; top:10px; width:100%; height:450; OVERFLOW:auto;' id='OrganicaGen'>
<table border='0' cellpadding='0' cellspacing='0' >
<?
include('funciones/siper_funciones.php');
CrearArbol($Navega,$Estado,$SelTarea,$CookieRut,'N');
?>
</table></div>
</form>
</body>
</html>