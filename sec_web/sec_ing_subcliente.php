<?php
include("../principal/conectar_principal.php");
if ($Mostrar=="S")
{
	$Consulta="select * from sec_web.nave t1 ";
	$Consulta.="left join sec_web.sub_cliente_vta t2 ";
	$Consulta.="on t1.cod_nave=CEILING(t2.cod_cliente) ";
	$Consulta.=" where cod_nave=CEILING('".$CmbNave."') ";
	$Respuesta=mysqli_query($link, $Consulta);
	if($Fila=mysqli_fetch_array($Respuesta))
	{
		$CodCliente=$Fila["cod_cliente"];
		$Descripcion=$Fila["nombre_nave"];
		$NombreCliente=$Fila["nombre_nave"];;
		$RutIngCliente=$Fila["rut_cliente"];
		$Ciudad="";
		$Comuna="";
		$Direccion="";
	}
	if($Ver=="S")
	{
		$Consulta="select * from sec_web.sub_cliente_vta where ";
		$Consulta.=" cod_cliente=CEILING('".$CodCliente."')	";
		$Consulta.=" and cod_sub_cliente=CEILING('".$CodSubCliente."')	";
		$Respuesta1=mysqli_query($link, $Consulta);
		if($Fila1=mysqli_fetch_array($Respuesta1))
		{
			$RutIngCliente=$Fila1["rut_cliente"];
			$Ciudad=$Fila1[ciudad];
			$Comuna=$Fila1["comuna"];
			$Direccion=$Fila1["direccion"];
		}
		else
		{
			$Ciudad="";
			$Comuna="";
			$Direccion="";
		}
	}
}
?>
<html>
<head>
<title>Ingreso SubCliente</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
function Grabar()
{
	var frm =document.FrmIngreso;	 
	var nombre="";
	var dir="";
	if(frm.RutCliente.value=="")
	{
		alert("Debe Ingresar Rut Cliente");
		frm.RutCliente.focus();
		return;
	}
	if(frm.NombreCliente.value=="")
	{
		alert("Debe Ingresar Nombre Cliente");
		frm.NombreCliente.focus();
		return;
	}
	if(frm.CodSubCliente.value=="")
	{
		alert("Debe Ingresar Codigo SubCliente");
		frm.CodSubCliente.focus();
		return;
	}
	if(frm.Ciudad.value=="")
	{
		alert("Debe Ingresar Ciudad");
		frm.Ciudad.focus();
		return;
	}
	if(frm.Comuna.value=="")
	{
		alert("Debe Ingresar Comuna");
		frm.Comuna.focus();
		return;
	}
	if(frm.Direccion.value=="")
	{
		alert("Debe Ingresar Direccion");
		frm.Direccion.focus();
		return;
	}
	dir=frm.Direccion.value.replace(/�/g," "); 
	dir=frm.Direccion.value.replace(/#/g," "); 
	nombre=frm.NombreCliente.value.replace(/�/gi,"N");
	nombre=frm.NombreCliente.value.replace(/�/gi,"n");  
	frm.action="sec_autorizacion_despacho01.php?CodCliente="+frm.CodCliente.value +"&CodSubCliente="+frm.CodSubCliente.value+"&RutCliente="+frm.RutCliente.value+"&Ciudad="+frm.Ciudad.value+"&Comuna="+frm.Comuna.value+"&Direccion="+frm.Direccion.value+"&NombreCliente="+nombre+"&Proceso=AgregarSubCliente";
	frm.submit(); 

}
function Salir()
{
	var frm =document.FrmIngreso;	 
	window.close();
}
function BuscarCodigo()
{
	var frm =document.FrmIngreso;	 
	frm.action="sec_ing_subcliente.php?Mostrar=S";
	frm.submit(); 
}
function BuscarSubCliente(B)
{
	var frm =document.FrmIngreso;
	if(B=="S")
	{	 
		frm.action="sec_ing_subcliente.php?Bloquear="+B;
		frm.submit(); 
	}
	else
	{
		frm.action="sec_ing_subcliente.php?Mostrar=S&Ver=S&CodCliente="+frm.CodCliente.value;
		frm.submit(); 
	}
	
}
function Nuevo()
{
	var frm =document.FrmIngreso;	 
	frm.action="sec_ing_subcliente.php?Bloquear=S";
	frm.submit(); 
}
function Cancelar()
{
	var frm =document.FrmIngreso;	 
	frm.action="sec_ing_subcliente.php";
	frm.submit(); 
}
</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="FrmIngreso" method="post" action="">
  <table width="435" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5" >
    <tr>
      <td width="552"><table width="423" height="148" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td colspan="4"><div align="center">Ingreso Otros Destinos</div></td>
          </tr>
          <tr> 
            <td height="18" colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <?php
			if ($Bloquear!="S")
			{
			  echo "<td>Cliente</td>";
              echo"	<td colspan='3'>:";
              echo"<select name='CmbNave' onChange='BuscarCodigo();'>";
			  echo "<option value='-1'>Seleccionar</option>";
			  $Consulta="select * from sec_web.nave WHERE ventanas='S' order by nombre_nave ";
			  $Respuesta=mysqli_query($link, $Consulta);
			  while($Fila=mysqli_fetch_array($Respuesta))
			  {
				if($CmbNave==$Fila["cod_nave"])
				{
					echo "<option value='".$Fila["cod_nave"]."' selected>".$Fila["nombre_nave"]."</option>";
				}
				else
				{
					echo "<option value='".$Fila["cod_nave"]."'>".$Fila["nombre_nave"]."</option>";
				} 
			  }
			  echo"</select></td>";
			  }
			 ?> 
          </tr>
          <tr> 
            <td width="97"><div align="left">Cod Cliente</div></td>
            <td width="98"><div align="left">: 
                <?php
			 if($Bloquear=="S")
			 {
			 	$Consulta="select max(CEILING(cod_nave)) as mayor  from sec_web.nave  ";
				$Respuesta3=mysqli_query($link, $Consulta);
				$Fila3=mysqli_fetch_array($Respuesta3);
				$Mayor=$Fila3["mayor"]+1;
			 	$CodCliente=$Mayor;
			 }
			 
			 ?>
                <input name="CodCliente" type="text" id="CodCliente" style="width:80" value="<?php  echo $CodCliente    ?>" >
              </div></td>
            <td width="116">&nbsp;</td>
            <td width="85">&nbsp;</td>
          </tr>
          <tr> 
            <td height="18">Nombre Cliente</td>
            <td colspan="2">: 
              <input name="NombreCliente" type="text" id="NombreCliente2"  style="width:200" value="<?php  echo $NombreCliente   ?>" > 
            </td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="22"> <div align="left">Cod SubCliente</div></td>
            <td>: 
            <?php
			if($Bloquear=="S")
			{
			  echo "<input name='CodSubCliente' type='text'  style='width:80' value='$CodSubCliente'></td>";
            }
			else
			{
				echo "<input name='CodSubCliente' type='text' onBlur=\"BuscarSubCliente('$Bloquear');\" style='width:80' value='$CodSubCliente'></td>";
			}
			?>
			<td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="22">Rut Cliente</td>
            <td><div align="left">: 
                <input name="RutCliente" type="text" id="RutCliente" style="width:80" value="<?php echo $RutIngCliente  ?>">
              </div></td>
            <td>(Debe Ingresar el -)</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="22">Ciudad</td>
            <td><div align="left">: 
                <input name="Ciudad" type="text" id="Ciudad" style="width:80" value="<?php echo $Ciudad ?>">
              </div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="22">Comuna</td>
            <td>: 
              <input name="Comuna" type="text" id="Comuna" style="width:80" value="<?php echo $Comuna ?>"> 
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="22">Direccion</td>
            <td colspan="2">: 
              <input name="Direccion" type="text" id="Direccion" style="width:200" value="<?php echo $Direccion?>"></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="425" border="0" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td> <div align="center">
                <input name="BtnNuevo" type="button" style="width:50"  id="BtnNuevo" value="Nuevo" onClick="Nuevo('')" >
                <input name="BtnGrabar" type="button" style="width:50"  id="BtnGrabar" value="Grabar" onClick="Grabar('')" >
                <input name="BtnCancelar" type="button" style="width:60"  id="BtnCancelar" value="Cancelar" onClick="Cancelar('')" >
                <input name="BtnSalir" style="width:50" type="button" id="BtnSalir" value="Salir" onClick="Salir();">
              </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
<?php
	echo "<script languaje='JavaScript'>";
	echo "var frm=document.FrmIngreso;";
	if ($Mensaje!='')
	{
		echo "alert('".$Mensaje."');";
	}
	echo "</script>"
?>

</form>
</body>
</html>
