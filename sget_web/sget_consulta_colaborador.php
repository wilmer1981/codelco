<?
 $CodigoDeSistema = 30;
 $CodigoDePantalla = 17;
 include("../principal/conectar_sget_web.php");
 if(isset($Rut))
 	$TxtRut=$Rut;
?>
<html>
<head>
<title>Consulta Personal Colaborador</title>
<link href="../principal/estilos/css_principal.css" rel="stylesheet" type="text/css">
<script  language="JavaScript" src="../principal/funciones/funciones_java.js"></script>
<script language="JavaScript">
function Procesos(TipoP)
{
	var f = document.frmPrincipal;
	if (f.TxtRut.value=='' && f.TxtApePat=='' && f.TxtTarjeta=='')
	{
		alert("Debe Ingresar Rut, Apellido Paterno o Numenro Tarjeta");
		return;
	} 
	switch(TipoP)
	{
		case 'B'://Buscar
			if (f.TxtRut.value!='')
				f.action = "sget_consulta_colaborador.php?Recarga=S&PorRut=S";
				
			if (f.TxtApePat.value!='')
				f.action = "sget_consulta_colaborador.php?Recarga=S&PorRut=N";
				
			if  (f.TxtTarjeta.value!='')
			
				f.action = "sget_consulta_colaborador.php?Recarga=S&PorRut=T";
			f.submit();
			break;
			
		case "L":
				f.TxtRut.value=new String();
				f.TxtApePat.value=new String();
				f.action="sget_consulta_colaborador.php?Recarga=N";
				f.submit();
				break;
		case "I"://IMPRIMIR
			window.print();
			break;				
		case "S"://SALIR
			window.location="../principal/sistemas_usuario.php?CodSistema=30&Nivel=1&CodPantalla=22";
			break;
	}
	
}
function Detalle(Rut)
{
	var URL = "sget_detalle_persona.php?Rut="+Rut;
	window.open(URL,"","top=30,left=30,width=680,height=550,menubar=no,resizable=yes,scrollbars=yes");
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image:  url(../principal/imagenes/fondo3.gif);
}
-->
</style></head>
<body>
<form name="frmPrincipal" action="" method="post">
<? include("encabezado.php") ?>
  <table width="970"  align="center" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td width="820" height="313" align="center" valign="top">
	    <table width="850" border="1" cellpadding="3" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF" class="ColorTabla02">
            <td colspan="8"><strong>CONSULTA PERSONAL COLABORADOR </strong></td>
          </tr>
          <tr align="center" bgcolor="#FFFFFF">
            <td width="130" align="left" class="ColorTabla02">Buscar por Rut </td>
            <td width="167" align="left" class="ColorTabla02"><input type="text" name="TxtRut" value="<? echo $TxtRut;?>">
            </td>
            <td width="144" align="left" class="ColorTabla02">Buscar Ape. Paterno </td>
            <td width="282" align="left" class="ColorTabla02"><input type="text" name="TxtApePat" value="<? echo $TxtApePat;?>"></td>
            <td width="144" align="left" class="ColorTabla02">Buscar N� Tarjeta </td>
            <td width="167" align="left" class="ColorTabla02"><input name="TxtTarjeta" type="text" id="TxtTarjeta" value="<? echo $TxtTarjeta;?>"></td>
             <td width="180" align="left" class="ColorTabla02"><input name="BtnBuscar" type="button" style="width:70px;" onClick="Procesos('B')" value="Buscar"></td>
            <td width="180" align="left" class="ColorTabla02">        <input name="BtnSalir" type="button" style="width:70px;" onClick="Procesos('S')" value="Salir"></td>
         </tr>
          <tr align="center" bgcolor="#FFFFFF" class="ColorTabla02">
            <td colspan="8">&nbsp;</td>
          </tr>
        </table>
	    <br>
		  <table width="850" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
          <tr align="center" bgcolor="#FFFFFF" class="ColorTabla01">
		  	<td width="60" aling="center">Foto</td>
		    <td width="80" align="center">Rut</td>
			<td width="64" align="center">Tarjeta</td>
			<td width="130" align="center">Nombre</td>
			<td width="100" align="center">Apelli. Paterno</td>			
			<td width="100" align="center">Apelli. Materno</td>
			<td width="180" align="center">Empresa</td>
			<td width="30" align="center">Activo</td>
			<td width="50" align="center">Fec.Vig.Func.</td>
			<td width="70" align="center">Fec.Fin.Ctto.</td>
  </tr>	
			<?
			if ($Recarga=='S')
			{
				
				$Consulta="SELECT t1.rut,t1.nombres,t1.ape_paterno,t1.ape_materno,t1.nro_tarjeta,t1.estado,t1.fec_fin_ctto,t1.rut_empresa,";
				$Consulta.=" t1.cod_contrato,t2.razon_social from des_sget.sget_personal t1, des_sget.sget_contratistas t2 where t1.tipo in ('1','2') ";
				if($PorRut=='S')
				{
					$Consulta.=" and t1.rut like '%".$TxtRut."%'";
				}	
				if($PorRut=='N')
				{
					$Consulta.=" and t1.ape_paterno like '%".$TxtApePat."%'";
				}	
				if($PorRut=='T')
				{
					$Consulta.=" and t1.nro_tarjeta like '%".$TxtTarjeta."%'";
				}	

					
				$Consulta.=" and t1.rut_empresa = t2.rut_empresa";
				$Consulta.=" order by ape_paterno";
				//echo $Consulta."</br>";
				$Resp=mysqli_query($link, $Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{

					$Consulta="Select fecha_termino from des_sget.sget_contratos where cod_contrato = '".$Fila["cod_contrato"]."' and ";
					$Consulta.=" rut_empresa = '".$Fila[rut_empresa]."'";
					//echo $Consulta."</br>";
					$Rsp=mysqli_query($link, $Consulta);
					$Row=mysql_fetch_array($Rsp);
					$fechac = $Row[fecha_termino];
					$fechaf = $Fila[fec_fin_ctto];
					echo '<tr  bgcolor="#FFFFCC">';
					echo "<td align='center'><a href=javascript:Detalle('".$Fila["rut"]."')><img src=\"fotos/".$Fila["rut"].".jpg\" align=\"absmiddle\" border=\"0\" width='20' height='20'></a></td>";
					echo "<td>".$Fila["rut"]."</td>";
					echo "<td>".strtoupper($Fila[nro_tarjeta])."</td>";			
					echo "<td>".substr(strtoupper($Fila["nombres"]),0,20)."</td>";
					echo "<td>".strtoupper($Fila[ape_paterno])."</td>";
					echo "<td>".strtoupper($Fila[ape_materno])."&nbsp;</td>";
					echo "<td>".substr(strtoupper($Fila[razon_social]),0,30)."&nbsp;</td>";
					if ($Fila["estado"]=='A')
						echo "<td align='center'>SI</td>";
						else
						echo "<td  bgcolor='#FF0000' align='center'>NO</td>";
					echo "<td align='center'>".$fechaf."</td>";
					echo "<td align='center'>".$fechac."</td>";
					echo "</tr>";
				}
			}	
			?>
			
  </table><br>
  <table width="800" border="1" cellpadding="2" cellspacing="0" bgcolor="#000000" class="TablaInterior">
    <tr align="center" bgcolor="#FFFFFF">
      <td>
        <input name="BtnBuscar" type="button" style="width:70px;" onClick="Procesos('B')" value="Buscar">
        <input name="BtnImprimir" type="button"  style="width:70px;" onClick="Procesos('I')" value="Imprimir">
        <input name="BtnLimpiar" type="button" style="width:70px;" onClick="Procesos('L')" value="Limpiar">
        <input name="BtnSalir" type="button" style="width:70px;" onClick="Procesos('S')" value="Salir"></td>
    </tr>
  </table></td>
 </tr>
 </table>
 </td>
    </tr>
</table>
<? include ("pie_pagina.php") ?>   
</form>
</body>
</html>
