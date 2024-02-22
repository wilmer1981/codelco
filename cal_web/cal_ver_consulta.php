<?php
include("../principal/conectar_principal.php");
$CookieRut= $_COOKIE["CookieRut"];
$Rut =$CookieRut;	

if(isset($_REQUEST["Enabal"])) {
	$Enabal = $_REQUEST["Enabal"];
}else{
	$Enabal =  "";
}


?>
<html>
<head>
<title>Consulta</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function TeclaPulsada (tecla) 
{ 
	var Frm=document.FrmRetalla;
	var teclaCodigo = event.keyCode; 

	if (teclaCodigo == 13)
	{
		Frm.BtnOk.focus();
	}
	else
	{
		if ((teclaCodigo != 188 )&&(teclaCodigo != 37)&&(teclaCodigo != 39))
		{
			if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
			{
			   if ((teclaCodigo < 96) || (teclaCodigo > 105))
			   {
			   		event.keyCode=46;
			   }		
			}   
		}
		else
		{
			if ((Frm.TxtValor.value.substr(Frm.TxtValor.value.length-1,1)==",")||(Frm.TxtValor.value.substr(Frm.TxtValor.value.length-1,1)==""))
			{
				if ((teclaCodigo != 37)&&(teclaCodigo != 39))
				{
					event.keyCode=46;
				}	
			}
		}
	}	
} 
function Grabar(Rut,SA,Rec)
{
	var frm =document.FrmRetalla;	 
	 if ((frm.TxtValor.value=="") && (frm.TxtValor.value <=0))
	{
		alert("Debe Ingresar Valor Retalla");
		frm.TxtValor.focus();
		return;
	}
	frm.action="cal_retalla01?Rut="+ Rut + "&SA="+ SA + "&Rec="+ Rec;
	frm.submit(); 
}
function MostrarLeyes(Sol,Recargo)
{
	
	var Frm=document.FrmSolicitud;
	window.open("cal_leyes_por_solicitud_retalla.php?Sol="+Sol+"&Rec="+Recargo +"&Opcion=3",""," fullscreen=yes,width=800,height=600,scrollbars=yes,resizable = yes");		
}	
function Salir()
{
	window.close();
}
function Recuperar(E)
{
	var frm=document.FrmRetalla;
	var LargoForm = frm.elements.length;
	var Pro="";
	var Sub="";
	var P="";
	var CheckeoSolicitud="";
	var cod_consulta="";
	var Codigo="";
	var Cont=0;
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "CheckConsulta") && (frm.elements[i].checked == true))
		{
			Codigo = frm.elements[i+0].value;
			Cont++;
		}
	}
	if (Cont > 1 )
	{
		alert("Debe Seleccionar un Solo elemento");
		return;
	}
	if (Cont == 0 )
	{
		alert("Debe Seleccionar un elemnto")		
		return;
	}
	frm.action="cal_con_leyes_producto01.php?cod_consulta="+Codigo + "&Salir=4&Enabal="+E;
	frm.submit();
}
function Eliminar(E)
{
	var frm=document.FrmRetalla;
	var LargoForm = frm.elements.length;
	var Codigo="";
	var Encontro=false;
	for (i=0;i < LargoForm;i++)
	{ 
		if ((frm.elements[i].name == "CheckConsulta") && (frm.elements[i].checked == true))
		{
			Codigo = Codigo  + frm.elements[i+0].value + "//";
			Encontro=true;
		}
	}
	if (Encontro == false )
	{
		alert("Debe Seleccionar un elemnto")		
		return;
	}
	frm.action="cal_con_leyes_producto01.php?Codigos="+Codigo + "&Salir=5&Enabal="+E;
	frm.submit();
}

</script>
</head>

<body background="../principal/imagenes/fondo3.gif" >
<form name="FrmRetalla" method="post" action="">
  <table width="671" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="659"><table width="656" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="641" colspan="2"><div align="center"><strong>Consulta</strong></div></td>
          </tr>
        </table>
        <br>
        <table width="657" border="1" bordercolor="#b26c4a">
          <tr class="ColorTabla01"> 
            <td width="17">&nbsp;</td>
            <td width="86">Fecha</td>
            <td width="184">Nombre Consulta</td>
            <td><div align="center">Producto/SubProducto</div></td>
          </tr>
        	<?php
			$Consulta ="SELECT distinct(cod_consulta),fecha,nombre_consulta from cal_web.consulta" ;
   //where rut_funcionario='".$Rut."'";
			$Respuesta1=mysqli_query($link, $Consulta);
			while($Fila1=mysqli_fetch_array($Respuesta1))
			{	
				$Prod='';
				$SubProd='';
				echo "<tr>";
				//echo "<td width='17'><input name='CheckConsulta' type='radio' value='".$Fila1["cod_consulta"]."' onClick=\"Recuperar('');\"></td>";
				echo "<td width='17'><input name='CheckConsulta' type='checkbox' value='".$Fila1["cod_consulta"]."'></td>";
				echo "<td width='86'>".$Fila1["fecha"]."<input name='CodConsulta' type='hidden' value='".$Fila1["cod_consulta"]."'></td>";
				echo "<td width='184'>".$Fila1["nombre_consulta"]."</td>";
				echo "<td width='184'>";
				$Consulta="select t1.cod_producto,t1.cod_subproducto,t2.cod_producto,t3.cod_subproducto,t2.abreviatura as AbrevP,t3.abreviatura as AbrevS from cal_web.consulta t1 ";
				$Consulta.="inner join proyecto_modernizacion.productos t2 on t2.cod_producto=t1.cod_producto ";
				$Consulta.="inner join proyecto_modernizacion.subproducto t3 on t3.cod_producto=t1.cod_producto and t3.cod_subproducto=t1.cod_subproducto ";
				$Consulta.=" where cod_consulta = '".$Fila1["cod_consulta"]."'  and t1.rut_funcionario='".$Rut."' ";
				//echo $Consulta."<br>";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					$PsP=$Fila["AbrevP"].'/'.$Fila["AbrevS"];
					echo $PsP."<br>";
					$Prod=$Prod.$Fila["cod_producto"].'-';
					$SubProd=$SubProd.$Fila["cod_subproducto"].'-';
				}
				echo "</td>";
				echo "</tr>";
			}
			?>
		
		
		</table>
        <br>
        <table width="659" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="287"><div align="right">
                <input name="BtnOk" style="width:60" type="button" id="BtnOk" value="Ok" onClick="Recuperar('<?php echo $Enabal;  ?>');">
              </div></td>
            <td width="38"><input name="BtnSalir" style="width:60" type="button" id="BtnSalir" value="Salir" onClick="Salir();"></td>
            <td width="313"><input name="BtnEliminar" style="width:60" type="button" id="BtnEliminar" value="Eliminar" onClick="Eliminar('<?php echo $Enabal;  ?>');"></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>
