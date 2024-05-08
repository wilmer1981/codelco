<?
	include("conectar2.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Datos=str_replace('**',' ',$Datos);
	$Datos2=explode('~',$Datos);
	$sql="select distinct(t1.RUT),t1.NOMBRES,t1.APELLIDO_PATERNO,t1.APELLIDO_MATERNO, t1.fecha_nacimiento, ";
	$sql.=" t1.anexo,t1.cod_cargo,t3.CODIGO_CARGO,t3.cargo,t1.cod_centro_costo,t2.nombre_centro_costo, t2.cod_area, t4.area ";
	$sql.=" from bd_rrhh.antecedentes_personales t1 ";
	$sql.=" left join bd_rrhh.centros t2 on t1.cod_centro_costo=t2.cod_centro_costo ";
	$sql.=" left join bd_rrhh.cargo t3 on t1.COD_CARGO=t3.CODIGO_CARGO ";
	$sql.=" left join bd_rrhh.areas t4 on t2.cod_area=t4.cod_area ";
	$sql.=" where t1.rut='".$RutFun."'";
	$Resp=mysql_query($sql);	
	while($Fila=mysql_fetch_array($Resp))
	{
		$Rut=$Fila["RUT"];
		$Nombres=ucwords(strtolower($Fila["NOMBRES"]))." ".ucwords(strtolower($Fila["APELLIDO_PATERNO"]))." ".ucwords(strtolower($Fila["APELLIDO_MATERNO"]));
		$Cargo=$Fila["cargo"];	  
		$Area=$Fila["area"];
		$CodCCosto=$Fila["cod_centro_costo"]." - ".$Fila["nombre_centro_costo"];	
		if ($Fila["anexo"]!="0" && $Fila["anexo"]!="")  
			$Anexo=$Fila["anexo"];	  
		else
			$Anexo="-";	  
		$FecNac=substr($Fila["fecha_nacimiento"],8,2)." de ".$Meses[intval(substr($Fila["fecha_nacimiento"],5,2))-1];	  
	}
?>
<html>
<script language="javascript">
function Salir()
{
	window.close();
}
</script>
	<head>
		<title>Datos Funcionario</title>
		<link href="js/style_new.css" rel=stylesheet>		
	    <style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 16px;
}
-->
        </style>
	</head>
<body>
<table width="450" border="0" align="center" cellPadding="1" cellSpacing="0" class="BordeTabla">
    <tr align="center">
      <td width="93" rowspan="2" class="BordeBajo"><?
			echo "<img width='117' height='129' src='http://10.56.11.6/bd_rrhh/fotos/".$Rut.".JPG'>";
	?></td>
      <td width="344" class="cab_tabla">Datos de Persona</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td align="center" class="BordeBajo"><? echo $Nombres;?></td>
    </tr>
    <tr>
        <td class="texto_bold">Cargo:</td>
        <td class="BordeBajo"><? echo $Cargo;?></td>
  </tr>
    <tr>
        <td class="texto_bold">Area:</td>
        <td class="BordeBajo"><? echo $Area;?></td>
  </tr>
    <tr>
        <td class="texto_bold">C.Costo:</td>
        <td class="BordeBajo"><? echo $CodCCosto;?></td>
  </tr>
    <tr>
        <td height="22" class="texto_bold">Anexo:</td>
        <td class="BordeBajo"><? echo $Anexo;?></td>
  </tr>
    <tr>
        <td class="texto_bold">Cumplea&ntilde;os:</td>
		<td class="BordeBajo"><? echo $FecNac;?></td>
  </tr>
    <tr align="center">
      <td height="30" colspan="2" class="BordeBajo">	  <input name="BtnCerrar" type="button" id="BtnCerrar" value="Cerrar" style="width:70px " onClick="window.close()">
      <input name="BtnImprimir" type="button" id="BtnImprimir" value="Imprimir" style="width:70px " onClick="window.print();"></td>
  </tr>
</table>
</body>
</html>
