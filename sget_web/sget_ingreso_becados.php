<? include("../principal/conectar_sget_web.php");
$readonly="";
$Titulo='Ingreso Becados';
$Consulta="SELECT * from sget_personal where rut='".$Rut."'";
$Resp=mysql_query($Consulta);
//echo $Consulta;
if($Fila=mysql_fetch_array($Resp))
{
	$Personal=$Fila["rut"]." ".$Fila["nombres"]." ".$Fila[ape_paterno]." ".$Fila[ape_materno];					
}
if($Proceso=='M')
{
	$Consulta="SELECT * from sget_becados where rut_becado='".$RutBec."' ";
	$Resp=mysql_query($Consulta);
	if($Fila=mysql_fetch_array($Resp))
	{
		$TxtRutPrv=substr($Fila[rut_becado],0,strlen($Fila[rut_becado])-2);
		$TxtDv=substr($Fila[rut_becado],strlen($Fila[rut_becado])-1);
		$TxtNombres=$Fila["nombres"];
		$TxtApePaterno=$Fila[ape_paterno];
		$TxtApeMaterno=$Fila[ape_materno];
		$TxtEdad=$Fila[edad];
		$readonly="readonly";
	}
}
?>
<html>
<head>
<title><? echo $Titulo;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript" src="funciones/sget_funciones.js"></script>
<script language="JavaScript">
function Proceso(Opcion)
{

	var f= document.FrmPopupProceso;
	var Veri=false
	switch(Opcion)
	{
		case "G":
			Veri=ValidaCampos();
			if (Veri==true)
			{
				f.action = "sget_ingreso_becados01.php?Selec="+Opcion
				f.submit();
			}
		break;
	}
}
function Salir()
{
	window.close();
}
function ValidaCampos()
{
	var f= document.FrmPopupProceso;
	var Res=true;
	if (f.TxtRutPrv.value=="")
	{
		alert("Debe Ingresar Run");
		f.TxtRutPrv.focus();
		Res=false;
		return;
	}
	if (f.TxtNombres.value=="")
	{
		alert("Debe Ingresar TxtNombres");
		f.TxtNombres.focus();
		Res=false;
		return;
	}
	if (f.TxtApePaterno.value=="")
	{
		alert("Debe Ingresar Apellido Paterno");
		f.TxtApePaterno.focus();
		Res=false;
		return;
	}
	return(Res);
	if (f.TxtApeMaterno.value=="")
	{
		alert("Debe Ingresar Apellido Materno");
		f.TxtApeMaterno.focus();
		Res=false;
		return;
	}
	return(Res);
}
function ModBecado(RutBec)
{
	var f= document.FrmPopupProceso;
	f.action = "sget_ingreso_becados.php?Proceso=M&RutBec="+RutBec;
	f.submit();
	
}
function EliBecado(RutBec)
{
	var f= document.FrmPopupProceso;
	f.action = "sget_ingreso_becados01.php?Selec=E&RutBec="+RutBec;
	f.submit();
	
}
</script>
</head>
<?
	echo '<body onLoad="document.FrmPopupProceso.TxtRutPrv.focus();">';
?>
<link href="estilos/css_sget_web.css" rel="stylesheet" type="text/css">
<form name="FrmPopupProceso" method="post" action="">
<input type="hidden" name="Rut" value="<? echo $Rut;?>">
  <table width="100%" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
	<td height="15"><img src="archivos/images/interior/esq1.gif" width="15" height="15"></td>
	<td width="212" height="15"background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15"></td>
	<td height="15"><img src="archivos/images/interior/esq2.gif" width="15" height="15"></td>
  </tr>
  <tr>
   <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
   <td>
   <table width="100%">
     <tr  align="left">
            <td class="formulario"><? echo "Personal: ".$Personal;?></td>
            <td align="right"><a href="JavaScript:Proceso('G')"><img src="archivos/btn_guardar.png" alt="Guardar"  border="0" align="absmiddle" /></a> <a href="JavaScript:Salir()"><img src="archivos/close.png"  alt="Cerrar " align="absmiddle" border="0"></a></td>
     </tr>
   </table>
<table width="100%" border="0" cellpadding="3" cellspacing="0" >
          <tr>
            <td colspan="2" class="TituloTablaNaranja"><? echo $Titulo;?> 
              <?
			 		echo '<input name="TxtCodigo" type="hidden"     value="'.$TxtCodigo.'" >';
			 	?>         </td>
          </tr>
          <tr>
            <td width="111" class="formulario">Run</td>
          <td width="382" ><?
			echo "<input name='TxtRutPrv'  $readonly type='text'   value='".$TxtRutPrv."' size='12' maxlength='8' onBlur=CalculaDv(this.form,'TxtRutPrv','TxtDv') onKeyDown=\"ValidaIngreso('S',false,this.form,'TxtDv')\">";//Numerico,Decimales,formulario,Salto
			?> <input name="TxtDv" type="text" <? echo $readonly;?> id="TxtDv" value="<? echo $TxtDv;?>"  size="3" maxlength="1">          </tr>
          <tr>
            <td class="formulario">Nombres</td>
            <td >  <input name="TxtNombres" type="text" id="TxtNombres" style="width:150" value="<? echo $TxtNombres; ?>" >          </td>
          </tr>
          <tr>
            <td class="formulario">Apellido&nbsp;Paterno </td>
            <td >  <input name="TxtApePaterno" type="text" id="TxtApePaterno" style="width:150" value="<? echo $TxtApePaterno; ?>" >          </td>
          </tr>
          <tr>
            <td class="formulario">Apellido&nbsp;Materno</td>
            <td ><input name="TxtApeMaterno" type="text" id="TxtApeMaterno" style="width:150" value="<? echo $TxtApeMaterno; ?>" ></td>
          </tr>
          <tr>
            <td class="formulario">Edad</td>
            <td ><input name="TxtEdad" type="text" style="width:30" value="<? echo $TxtEdad; ?>" maxlength="2" onKeyDown="TeclaPulsada(true)"></td>
          </tr>
        </table>
		<table width="100%" align="center" cellpadding="2" border="1" cellspacing="0">
        <tr>
          <td class="TituloTablaNaranja" colspan="6" align="center">Personas Becadas  </td>
        </tr>
        <tr>
		  <td width="5%" align="center" class="TituloCabecera">&nbsp;</td>
          <td width="15%" align="center" class="TituloCabecera">Rut Becado </td>
          <td width="25%" align="center" class="TituloCabecera">Nombres</td>
          <td width="20%" align="center" class="TituloCabecera">Apellido Paterno </td>
          <td width="20%" align="center" class="TituloCabecera">Apellido Materno </td>
		  <td width="10%" align="center" class="TituloCabecera">Edad</td>
        </tr>
		<?
		$Consulta="SELECT * from sget_becados where rut='".$Rut."' ";
		$Resp=mysql_query($Consulta);
		while($Fila=mysql_fetch_array($Resp))
		{
			echo "<tr>";
			echo "<td><a href=JavaScript:EliBecado('".$Fila[rut_becado]."')><img src='archivos/elim_hito.png'  alt='Eliminar' height='15' width='15' align='absmiddle' border='0'></a>";
			echo "<a href=JavaScript:ModBecado('".$Fila[rut_becado]."')><img src='archivos/btn_modificar.png'  alt='Modificar' height='15' width='15'  align='absmiddle' border='0'></a></td>";
			echo "<td>".$Fila[rut_becado]."</td>";
			echo "<td>".$Fila["nombres"]."</td>";
			echo "<td>".$Fila[ape_paterno]."</td>";
			echo "<td>".$Fila[ape_materno]."</td>";
			echo "<td>".$Fila[edad]."&nbsp;</td>";
			echo "</tr>";
		}
		?>
      </table>		
	  </td>

  <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3.gif" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15" height="15"><img src="archivos/images/interior/esq4.gif" width="15" height="15" /></td>
  </tr>
  </table>			
</form>
</body>
</html>
<? 
	echo "<script languaje='JavaScript'>";
	if ($Mensaje=='S')
		echo "alert('Este Registro ya Existe');";
	echo "</script>";
?>