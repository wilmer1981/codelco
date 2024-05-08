<?
	include("conectar3.php");
	$Meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	$Datos=str_replace('**',' ',$Datos);
	$Datos2=explode('~',$Datos);
	$sql="select distinct(t1.rut),t1.nombres,t1.apellido_paterno,t1.apellido_materno, t1.fecha_nacimiento, ";
	$sql.=" t1.anexo,t1.cod_cargo,t1.cod_centro_costo ";
	$sql.=" from proyecto_modernizacion.funcionarios t1 ";
	/*$sql.=" left join bd_rrhh.centros t2 on t1.cod_centro_costo=t2.cod_centro_costo ";
	$sql.=" left join bd_rrhh.cargo t3 on t1.COD_CARGO=t3.CODIGO_CARGO ";
	$sql.=" left join bd_rrhh.areas t4 on t2.cod_area=t4.cod_area ";*/
	$sql.=" where t1.rut='".$RutFun."'";
	$Resp=mysql_query($sql);	
	while($Fila=mysql_fetch_array($Resp))
	{
		$Rut=$Fila["rut"];
		$Nombres=ucwords(strtolower($Fila["nombres"]))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".ucwords(strtolower($Fila["apellido_materno"]));
		$Consulta="select * from proyecto_modernizacion.cargo where CODIGO_CARGO ='".$Fila[cod_cargo]."' ";
		$Res=mysql_query($Consulta);
		if($Fila1=mysql_fetch_array($Res))
			$Cargo=$Fila1["CARGO"];
		else
			$Cargo="No Definido";
		$CodCentro= str_replace(".","",$Fila[cod_centro_costo]) ;
		$CodCentro= substr($CodCentro,3,4) ;	
		
		//$Cargo=$Fila["cargo"];	  
		$Area=$Fila["area"];
		$Consulta="select * from proyecto_modernizacion.centro_costo where  centro_costo_enm='".$CodCentro."' ";
		$Res2=mysql_query($Consulta);
		if($Fila2=mysql_fetch_array($Res2))
		{
			$CodCCosto=$Fila2["CENTRO_COSTO"]." - ".$Fila2["DESCRIPCION"];	
			$Consulta="select * from proyecto_modernizacion.areas where  COD_AREA='".$Fila2[cod_area]."' ";
			$Res3=mysql_query($Consulta);
			if($Fila3=mysql_fetch_array($Res3))
			{
				$Area=$Fila3["AREA"];
			}
			else
				$Area="-";
		}
		else
			$CodCCosto="-";	
		
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
			echo "<img width='117' height='129' src='http://".HTTP_SERVER."/uca_web/fotos/".$Rut.".JPG'>";
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
