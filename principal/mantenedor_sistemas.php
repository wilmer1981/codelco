<?php 
   include("conectar_principal.php");

    if(isset($_GET["Error"])){
		$Error = $_GET["Error"];
	}else{
		$Error = "";
	}

	$CodigoDeSistema = 99;
	$CodigoDePantalla = 1;
?>
<html>
<head>
<title>Mantenedor de Sistemas</title>
<link href="estilos/css_principal.css" rel="stylesheet" type="text/css">
<style>

#postit{
position:absolute;
width:330;
padding:5px;
background-color:#006699;
border:2px solid black;
visibility:hidden;
z-index:500;
cursor:hand;
}

</style>
<script language="javascript" src="funciones/funciones_java.js"></script>
<Script language="JavaScript">
function Proceso(opt,valor)
{
	var f = document.FrmMantenedor;     
	var Valores = ""; 	
	switch (opt)
	{
		case "DU":
			window.open("ing_usuario.php?Proceso=NS&Sistema=" + valor,"","top=50,left=30,width=600,height=450,scrollbars=yes,resizable = yes");					
			break;
		case "DN":
			window.open("ing_niveles.php?Proceso=NS&Sistema=" + valor,"","top=50,left=30,width=600,height=450,scrollbars=yes,resizable = yes");					
			break;
		case "NS":
			window.open("ing_sistema.php?Proceso=NS","","top=50,left=30,width=500,height=400,scrollbars=yes,resizable = yes");					
			break;
		case "MS":
			for (i=0; i < f.elements.length; i++)
			{
				if ((f.elements[i].name == "CodSistema") && (f.elements[i].checked == true))
				{
					Valores = f.elements[i].value;
					break;			
				}
			}
			if (Valores=="")
			{
				alert("Seleccione un Sistema a Modificar");
				return;
			}
			else
			{
				window.open("ing_sistema.php?Proceso=MS&Sistema=" + Valores,"","top=50,left=30,width=500,height=400,scrollbars=yes,resizable = yes");					
			}
			break;
		case "ES":
			for (i = 0; i < f.elements.length; i++)
			{
				if ((f.elements[i].name == "CodSistema") && (f.elements[i].checked == true))
				{
					Valores = Valores + f.elements[i].value + "/";
				}
			}
			if (Valores=="")
			{
				alert("No hay ningun Sistema Seleccionado para Eliminar");
				return;
			}
			else
			{
				var msg=confirm("�Seguro que desea Eliminar Estos Sistemas\nPara Eliminar un sistema debe primero\nEliminar todo lo relacionado a el\n(Usuarios, Pantallas, Niveles)?");
				if (msg==true)
				{
					var Largo = Valores.length;
					Valores = Valores.substring(0,Largo-1);				
					f.action = "mantenedor_sistemas01.php?Proceso=ES&Valores=" + Valores;
					f.submit();
				}				
				else
				{
					return;
				}
			}
			break;
		case "S":
			f.action = "sistemas_usuario.php?CodSistema=99&Nivel=0";
			f.submit();
			break;
		case "O":
			f.action = "mantenedor_sistemas.php?Orden=" + valor;
			f.submit();
			break;
	}	
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">

body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FFFFFF;
}
a:visited {
	color: #FFFFFF;
}
a:hover {
	color: #FFFFFF;
}
a:active {
	color: #FFFF00;
}

</style>
</head>
<body>
<form name="FrmMantenedor" method="post" action="">
<?php include("encabezado.php");?>
  <div align="left"> 
    <table width="770" border="0" cellspacing="0" cellpadding="5" class="TablaPrincipal">
      <tr>
        <td height="313" valign="top"><table width="700" border="0" align="center" cellpadding="2" cellspacing="0" class="TablaInterior">
            <tr align="center" valign="middle"> 
              <td>&nbsp; <input name="BtnNuevoSist" type="button" style="width:100px" onClick="Proceso('NS')"  value="Nuevo Sistema"> 
                <input name="BtnModificar" type="button" value="Modificar" onClick="Proceso('MS')" style="width:70px">                <input name="BtnEliminar" type="button" id="Eliminar2" value="Eliminar" onClick="Proceso('ES')" style="width:70px">
                &nbsp; <input name="BtnSalir" type="button" value="Salir" style="width:70px" onClick="Proceso('S')">
            </td>
            </tr>
          </table>
          <br> 
        <table width="550" border="1" align="center" cellpadding="1" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01"> 
            <td width="1%" height="20"><strong>Mod/Eli</strong></td>
            <td width="10%"><strong><a href="JavaScript:Proceso('O','C');">C�digo</a></strong></td>
            <td width="30%"><strong><a href="JavaScript:Proceso('O','N');">Nombre del Sistema</a></strong></td>
            <td width="35%"><strong><a href="JavaScript:Proceso('O','D');">Descripci&oacute;n del Sistema</a></strong></td>
            <td width="10%"><strong>Anexo</strong></td>
            <td width="8%"><strong>Usuarios</strong></td>
            <td width="6%"><strong>Niveles</strong></td>
          </tr>
<?php 
	$Consulta = "select  * from proyecto_modernizacion.sistemas ";
	if (!isset($Orden))
	{
		$Consulta.= " order by cod_sistema";
	}
	else
	{
		switch ($Orden)
		{
			case "C":
				$Consulta.= " order by cod_sistema";
				break;
			case "N":
				$Consulta.= " order by nombre";
				break;
			case "D":
				$Consulta.= " order by descripcion";
				break;
		}
	}
	$Respuesta = mysqli_query($link,$Consulta);
	$ColorTabla = "ColorTabla02";
	while($Fila = mysqli_fetch_array($Respuesta))
	{
		if ($ColorTabla=="ColorTabla02")
			$ColorTabla="";
		else	
			$ColorTabla="ColorTabla02";			
		echo "<tr onMouseOver=\"CCA(this,'CL01')\" onMouseOut=\"CCA(this,'CL02')\">\n";// class='".$ColorTabla."'>\n";
		echo "<td align='center'><input type='checkbox' name='CodSistema' value='".$Fila["cod_sistema"]."' onClick=\"JavaScript:CCA(this,'CL03')\"></td>\n";
		echo "<td align='center'>".str_pad($Fila["cod_sistema"],2,"0",STR_PAD_LEFT)."</td>\n";
		echo "<td align='center'>".$Fila["nombre"]."</td>\n";
		echo "<td>".ucwords(strtolower($Fila["descripcion"]))."</td>\n";
		if ($Fila["cierre"] == "S")
			echo "<td align='center'>SI</td>\n";
		else
			echo "<td align='center'>NO</td>\n";
		echo "<td align='center'><a href=\"JavaScript:Proceso('DU','".$Fila["cod_sistema"]."')\"><img src='imagenes/Usuarios.gif' width='20' height='20' border='0'></a></td>\n";
		echo "<td align='center'><a href=\"JavaScript:Proceso('DN','".$Fila["cod_sistema"]."')\"><img src='imagenes/llave01.gif' width='16' height='16' border='0'></a></td>\n";
		echo "</tr>";
	}
?>
        </table></td>
      </tr>
    </table>
<?php include("pie_pagina.php");?>
</form>
</body>
</html>
<?php
if ($Error == "S")
{
		echo "<div id='postit' style='left:250px;top:100px'>\n";
		echo "<font color='#FFFFFF'><b>".$Mensaje."</b></font><br><br>";		
		echo "&nbsp;&nbsp;<div align='center'><a href='JavaScript:closeit();'><font color='#FFFFFF'><b>CERRAR</b></font></a>\n";
		echo "</font></div>";
		echo "</div>";
echo "<script>\n";
	//
	echo "var once_per_browser=0\n";
	//
	///No modifiques lo que sigue///
	//
	echo "var ns4=document.layers\n";
	echo "var ie4=document.all\n";
	echo "var ns6=document.getElementById&&!document.all\n";
	//
	echo "if (ns4)\n";
	echo "crossobj=document.layers.postit\n";
	echo "else if (ie4||ns6)\n";
	echo "crossobj=ns6? document.getElementById('postit') : document.all.postit\n";
	//
	//
	echo "function closeit(){\n";
	echo "if (ie4||ns6)\n";
	echo "crossobj.style.visibility='hidden'\n";
	echo "else if (ns4)\n";
	echo "crossobj.visibility='hide'\n";
	echo "}\n";
	//
	echo "function get_cookie4(Name) {\n";
	  echo "var search = Name + '='\n";
	  echo "var returnvalue = '';\n";
	  echo "if (document.cookie4.length > 0) {\n";
		echo "offset = document.cookie4.indexOf(search)\n";
		echo "if (offset != -1) {\n"; // if cookie4 exists
		  echo "offset += search.length\n";
		  // set index of beginning of value
		  echo "end = document.cookie4.indexOf(';', offset);\n";
		  // set index of end of cookie4 value
		  echo "if (end == -1)\n";
			 echo "end = document.cookie4.length;\n";
		  echo "returnvalue=unescape(document.cookie4.substring(offset, end))\n";
		  echo "}\n";
	   echo "}\n";
	  echo "return returnvalue;\n";
	echo "}\n";
	//
	echo "function showornot(){\n";
	echo "if (get_cookie4('postdisplay')==''){\n";
	echo "showit()\n";
	echo "document.cookie4='postdisplay=yes'\n";
	echo "}\n";
	echo "}\n";
	//
	echo "function showit(){\n";
	echo "if (ie4||ns6)\n";
	echo "crossobj.style.visibility='visible'\n";
	echo "else if (ns4)\n";
	echo "crossobj.visibility='show'\n";
	echo "}\n";
	//
	echo "if (once_per_browser)\n";
	echo "showornot()\n";
	echo "else\n";
	echo "showit()\n";
	//
	echo "</script>\n";
	//
	echo "<script language='JavaScript1.2'>\n";
	//
	//funci�n arrastrar y soltar para ie4+ y NS6////
	echo "function drag_drop(e){\n";
	echo "if (ie4&&dragapproved){\n";
	echo "crossobj.style.left=tempx+event.clientX-offsetx\n";
	echo "crossobj.style.top=tempy+event.clientY-offsety\n";
	echo "return false\n";
	echo "}\n";
	echo "else if (ns6&&dragapproved){\n";
	echo "crossobj.style.left=tempx+e.clientX-offsetx\n";
	echo "crossobj.style.top=tempy+e.clientY-offsety\n";
	echo "return false\n";
	echo "}\n";
	echo "}\n";
	//
	echo "function initializedrag(e){\n";
	echo "if (ie4&&event.srcElement.id=='postit'||ns6&&e.target.id=='postit'){\n";
	echo "offsetx=ie4? event.clientX : e.clientX\n";
	echo "offsety=ie4? event.clientY : e.clientY\n";
	//
	echo "tempx=parseInt(crossobj.style.left)\n";
	echo "tempy=parseInt(crossobj.style.top)\n";
	//
	echo "dragapproved=true\n";
	echo "document.onmousemove=drag_drop\n";
	echo "}\n";
	echo "}\n";
	echo "document.onmousedown=initializedrag\n";
	echo "document.onmouseup=new Function('dragapproved=false')\n";
	// \n";
	echo "</script>\n";
	// FIN DEL SCRIPT\n";
}//FIN MENSAJE
?>