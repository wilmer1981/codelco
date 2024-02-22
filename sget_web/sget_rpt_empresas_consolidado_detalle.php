<? 
	include("../principal/conectar_sget_web.php");
	$FechaP = date("Y-m-d H:i:s");
?>
<html>
<head>
<title>Consulta de Marcaciones</title>
<link href="estilos/css_sget_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="javascript">
function Proceso(opt)
{
	var f=document.frmPrincipal;
	switch (opt)
	{
		case "I":
			window.print();
			break;
		case "S":
			window.close();
			break
	}
}
</script>
</head>
<body>
<table width="800" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq1em.png" width="15" height="15" /></td>
    <td width="949" height="15"background="archivos/images/interior/form_arriba.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="21" height="15"><img src="archivos/images/interior/esq2em.png" width="15" height="15" /></td>
  </tr>
  <tr>
    <td width="15" background="archivos/images/interior/form_izq3.png">&nbsp;</td>
    <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02" >
      <tr>
        <td align="left" class='formulario2'>&nbsp;</td>
        <td align="right" class='formulario2'><a href="JavaScript:Proceso('I')"><img src="archivos/Impresora2.png"   alt="Imprimir" border="0" align="absmiddle"  ></a> <a href="JavaScript:Proceso('S')"><img src="archivos/rechazado3.png" align="absmiddle" alt="Volver" border="0"></a> </td>
      </tr>
    </table>
        <table width="100%" align="center" cellpadding="2" cellspacing="0" class="ColorTabla02">
          <tr>
            <td height="17" class='formulario2'>Empresa</td>
            <td class="formulario2" ><?
					$Consulta = "SELECT * from sget_contratistas  ";
					$Consulta.= " where rut_empresa='".$RutEmp."'";
					//echo $Consulta;
					$Resp=mysql_query($Consulta); 
					if ($Fila=mysql_fetch_array($Resp)) 
					{ 
						echo $Fila["rut_empresa"]." - ".strtoupper($Fila["razon_social"]);
					}
			  ?>          </tr>
          <tr>
            <td width="123"class='formulario2'>Contrato</td>
          <td class='formulario2' >
		  <?
				$FechaActual=date("Y")."-".date("m")."-".date("d");
				$Consulta = "SELECT * from sget_contratos t1  ";
				$Consulta.= " where cod_contrato='".$Ctto."' ";
				$Consulta.= " order by cod_contrato asc";
				//echo $Consulta;
				$Resp=mysql_query($Consulta); 
				if ($Fila=mysql_fetch_array($Resp)) 
				{ 
					if ($FechaActual > $Fila["fecha_termino"]){
						$Estado="INACTIVO";$Color="red";}
					else{
						$Estado="ACTIVO";$Color="white";}
					echo $Fila["cod_contrato"]."&nbsp;&nbsp;&nbsp;Estado ".$Estado;
				}
		  ?>            </tr>
          <tr>
            <td class='formulario2'><span class="FilaAbeja2">Fecha de Busqueda</span></td>
            <td class='formulario2' > Desde&nbsp;<? echo $TxtFecha; ?> &nbsp;&nbsp;Hasta&nbsp;<? echo $TxtFechaH; ?></td>
          </tr>
          <tr>
            <td class='formulario2'>Personal</td>
            <td class='formulario2' >
			<?
				$Consulta = "SELECT * from sget_personal t1  ";
				$Consulta.= " where t1.rut='".$Run."' ";
				$Consulta.= " order by t1.ape_paterno, t1.ape_materno, t1.nombres";
				$Resp=mysql_query($Consulta); 
				//echo $Consulta;
				if ($Fila=mysql_fetch_array($Resp)) 
				{
					$Rut=substr($Fila["rut"],0,2).".".substr($Fila["rut"],2,3).".".substr($Fila["rut"],5,3)."-".substr($Fila["rut"],9,1);				
					$Nombre = ucwords(strtolower($Fila["ape_paterno"]." ".$Fila["ape_materno"]." ".$Fila["nombres"]));
					echo $Rut." ".$Nombre;
				}
			  ?></td>
          </tr>
      </table></td>
    <td width="15" background="archivos/images/interior/form_der.png">&nbsp;</td>
  </tr>
  <tr>
    <td width="15" height="15"><img src="archivos/images/interior/esq3em.png" width="15" height="15" /></td>
    <td height="15" background="archivos/images/interior/form_abajo.png"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="21" height="15"><img src="archivos/images/interior/esq4em.png" width="15" height="15" /></td>
  </tr>
</table><br>
<table width="800" align="center"  border="0" cellpadding="0"  cellspacing="0" class="TablaPricipalColor">
  <tr>
    <td><img src="archivos/images/interior/esq1em.gif" width="15" /></td>
    <td width="1188" background="archivos/images/interior/form_arriba.gif"><img src="archivos/images/interior/transparent.gif" width="4" /></td>
    <td ><img src="archivos/images/interior/esq2em.gif" width="15" /></td>
  </tr>
  <tr>
    <td background="archivos/images/interior/form_izq.gif">&nbsp;</td>
    <td>
	<table width="100%" border="1" align="center" cellpadding="2" cellspacing="0" >
	<tr>
	<td width="40%" align="center" class="TituloTablaVerde">Nro.Tarjeta</td>
	<td width="60%" align="center" class="TituloTablaVerde" >Fecha Hora (<? echo $Tipo;?>)</td>
	</tr>
	<?
	$Cont=0;
	$Consulta = "SELECT t3.nro_tarjeta,t3.fechahora from sget_personal as t1 ";
	$Consulta.= "inner join sget_personal_historia as t2 on t1.rut=t2.rut and t2.rut_empresa = '".$RutEmp."' and t2.cod_contrato = '".$Ctto."' ";
	switch($Estado)
	{
		case "1":
			$Consulta.=" and t2.activo='S' ";
		break;
		case "2":
			$Consulta.=" and t2.activo='N' ";
		break;
	}
	$Consulta.= "inner join uca_web.uca_accesos_personas as t3 on t2.rut=t3.rut ";
	$Consulta.= "and (t3.fechahora >= concat(t2.fecha_ingreso,' 00:00:00') and t3.fechahora <= concat(t2.fecha_termino,' 23:59:59'))"; 
	$Consulta.= "where t1.rut='".$Run."' and (t3.fechahora between '".$TxtFecha." 00:00:00' and '".$TxtFechaH." 23:59:59') and t3.tipo='".$Tipo."'";
	//$Consulta.= "group by t1.rut,t2.cod_contrato,t2.rut_empresa ";
	$Consulta.= "order by t3.fechahora";
	$RespMarcas=mysql_query($Consulta);
	//echo $Consulta."<br>";
	while($FilaMarcas=mysql_fetch_array($RespMarcas))
	{
		$Par=($Cont % 2);
		if($Par==1)
		{
			?>
			<tr class="FilaAbeja">
			<?
		}
		else
		{
			?>
			<tr class="FilaAbeja">
			<? 
		}
		$Cont++;
		?>
		<td align="center"><? echo $FilaMarcas[nro_tarjeta]; ?>&nbsp;</td>
		<td align="center"><? echo $FilaMarcas[fechahora]; ?>&nbsp;</td>
		</tr>
	<?
	}
	?>
	<tr>
	<td colspan="2">Cantidad de Registros:&nbsp;<? echo $Cont;?></td>
	</tr>
	</table>
	</td>
    <td width="15" background="archivos/images/interior/form_der.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="15"><img src="archivos/images/interior/esq3em.gif" width="15" height="15" /></td>
    <td height="1"background="archivos/images/interior/form_abajo.gif"><img src="archivos/images/interior/transparent.gif" width="4" height="15" /></td>
    <td width="15"><img src="archivos/images/interior/esq4em.gif" width="15" height="15" /></td>
  </tr>
</table>
</body>
</html>