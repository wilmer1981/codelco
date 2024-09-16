<?php
	$CodigoDeSistema = 24;
	$CodigoDePantalla = 8;
	include("../principal/conectar_principal.php");	


	$Ordenar       = isset($_REQUEST["Ordenar"])?$_REQUEST["Ordenar"]:"";
	$Buscar        = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$TipoBusqueda  = isset($_REQUEST["Ordenar"])?$_REQUEST["TipoBusqueda"]:"";

?>
<html>
<head>
<title>AGE-Conjunto Grupo</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Proceso(TipoProceso)
{
	var f = document.frmPrincipal;
	var Datos="";
	
	switch(TipoProceso)
	{
		case 'N'://NUEVO GRUPO
			window.open("rec_grupos_producto_proceso.php?Proceso=N","","top=0,left=1,width=760,height=460,scrollbars=no,resizable=yes");
			break;
		case 'M'://MODIFICAR GRUPO
			if(SoloUnElementoCheck())
			{
				Datos=RecuperarValoresCheckeado();
				window.open("rec_grupos_producto_proceso.php?Proceso=M&Valor="+Datos,"","top=0,left=1,width=760,height=460,scrollbars=no,status=yes,resizable=yes");
			}	
			break;
		case 'E'://ELIMINAR GRUPO
			if(confirm('Esta Seguro de Eliminar el Grupo'))
			{
				Datos=RecuperarValoresCheckeado();
				f.action='rec_grupos_producto_proceso01.php?Proceso=E&Valor='+Datos;
				f.submit();
			}	
			break;
		case 'S'://SALIR
			document.location = "../principal/sistemas_usuario.php?CodSistema=24";
			break;
	}
	
}
function RecuperarValoresCheckeado()
{
	var f = document.frmPrincipal;
	var Valores="";
	
	for (i=1;i<f.CheckProducto.length;i++)
	{
		if (f.CheckProducto[i].checked==true)
			Valores=Valores + f.CheckProducto[i].value+"//";
	}
	Valores=Valores.substr(0,Valores.length-2);
	return(Valores);
}
function SoloUnElementoCheck()
{
	var f = document.frmPrincipal;
	var CantCheck=0;
	for (i=1;i<f.CheckProducto.length;i++)
	{
		if (f.CheckProducto[i].checked==true)
			CantCheck=CantCheck+1;
	}
	if (CantCheck > 1||CantCheck==0)
	{
		if(CantCheck==0)
			alert("Debe Seleccionar un Elemento");
		else
			alert("Debe Seleccionar solo un Elemento");
		return(false);
	}
	else
		return(true);
}	
function Recarga(Tipo)
{
	var f = document.frmPrincipal;
	switch(Tipo)
	{
		case '1'://
			f.action='rec_grupos_producto.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '2'://
			f.action='rec_grupos_producto.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '3'://
			f.action='rec_grupos_producto.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
		case '5'://
			f.action='rec_grupos_producto.php?Buscar=S&TipoBusqueda='+Tipo;
			break;
	}
	f.submit();		
}
function OrdenadoPor(Tipo,TipoBusqueda)
{
	var f = document.frmPrincipal;
	switch(Tipo)
	{
		case "C"://CONJUNTO
			f.action='rec_grupos_producto.php?Buscar=S&Ordenar='+Tipo+"&TipoBusqueda="+TipoBusqueda;
			break;
		case "G"://GRUPO
			f.action='rec_grupos_producto.php?Buscar=S&Ordenar='+Tipo+"&TipoBusqueda="+TipoBusqueda;
			break;
		case "D"://DESCRIPCION
			f.action='rec_grupos_producto.php?Buscar=S&Ordenar='+Tipo+"&TipoBusqueda="+TipoBusqueda;
			break;
	}
	f.submit();
}
function MostrarPrv(Grupo)
{
	window.open("rec_grupos_producto_lista.php?Grupo="+Grupo,"","top=30,left=100,width=500,height=400,scrollbars=yes,resizable=yes");	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo1 {
	color: #000000;
	font-weight: bold;
}
</style></head>

<body>
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php") ?>
  <table width="770" height="330" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td align="center" valign="top">
	    <table width="500" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF">
            <td width="694" colspan="6"><span class="Estilo1">
            Ingreso de Producto por Grupo </span></td>
          </tr>
	    </table><br>
		<table width="500" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">  
          <tr align="center" bgcolor="#FFFFFF">
            <td>
			<input name="BtnNuevo" type="button" style="width:100px;" value="Nuevo Grupo" onClick="Proceso('N')">
			<input name="BtnModificar" type="button" style="width:100px;" value="Modificar Grupo" onClick="Proceso('M')">
			<input name="BtnEliminar" type="button" style="width:100px;" value="Eliminar Grupo" onClick="Proceso('E')">
			<input name="BtnSalir" type="button" style="width:100px;" value="Salir" onClick="Proceso('S')">
			</td>
          </tr>
	    </table>
	    <br>
		<table width="500" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" class="ColorTabla01">
			<td width="20">&nbsp;</td>
			<td width="80"><a href="JavaScript:OrdenadoPor('G','<?php echo $TipoBusqueda;?>')">Cod_Grupo</a></td>
			<td width="320"><a href="JavaScript:OrdenadoPor('D','<?php echo $TipoBusqueda;?>')">Descripcion Grupo </a></td>
			<td width="80">Abast.Minero</td>
          </tr>
		  <?php
		  	$Buscar='S';
		  	if($Buscar=='S')
			{
				switch($Ordenar)
				{
					case "G":
						$OrderBy='cod_grupo';
						break;
					case "D":
						$OrderBy='descripcion_grupo';
						break;
					default:
						$OrderBy='cod_grupo';
						break;
				}
				$Consulta="SELECT * from sipa_web.grupos_productos ";
				/*switch($TipoBusqueda)
				{
					case "1":
						$Consulta.="where t1.PATENT_A like '".$TxtPatente."%' ";
						break;
					case "2":
						$Consulta.="where t1.R_PROV_A ='".$CmbProveedor."' ";
						break;
					case "3":
						$Consulta.="where t1.C_PROD_A ='".$CmbSubProducto."' ";
						break;
				}*/
				$Consulta.=" order by ".$OrderBy;
				//echo $Consulta;
				$RespConj=mysqli_query($link, $Consulta);
				echo "<input type='hidden' name='CheckProducto'>";
				while($FilaProd=mysqli_fetch_array($RespConj))
				{
					echo "<tr bgcolor=\"#FFFFFF\">";
					$Datos=$FilaProd["cod_grupo"];
					echo "<td><input type='checkbox' name='CheckProducto' value='$Datos'></td>";
					echo "<td align='center'>".str_pad($FilaProd["cod_grupo"],5,0,STR_PAD_LEFT)."</td>";
					echo "<td><a href='JavaScript:MostrarPrv(".$FilaProd["cod_grupo"].")'>".$FilaProd["descripcion_grupo"]."</a></td>";
					echo "<td align='center'>".$FilaProd["abast_minero"]."</td>";
					echo "</tr>";
				}
			}			  
		  ?>
        </table>
	    <br></td>
 </tr>
</table>
</tr>
</table>
<?php include ("../principal/pie_pagina.php") ?>   
</form>
</body>
</html>
