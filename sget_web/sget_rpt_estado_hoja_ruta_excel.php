<?
include("../principal/conectar_sget_web.php");
include("funciones/sget_funciones.php");
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");	
?>
<html>
<head><title>Consulta Estados Hoja de Ruta Excel</title></head>
<body>
<form>
<table width="100%" border="1" cellpadding="0"  cellspacing="0">
<tr>
<td class="formulario">Empresa</td>
<td align="left" class="formulario">
	<?
	$Consulta = "SELECT * from sget_contratistas where rut_empresa='".$CmbEmpresa."'";
	$Resp=mysqli_query($link, $Consulta);
	while ($FilaTC=mysql_fetch_array($Resp))
	{
		echo FormatearNombre($FilaTC["razon_social"]);
	}
	?></td>
<td class="formulario">Nro Hoja Ruta </td>
<td align="left" class="formulario"><? echo $TxtHoja; ?></td>
</tr>
<tr>
<td class="formulario">Contrato</td>
<td align="left" class="formulario">
<?
$Consulta="SELECT * from sget_contratos where cod_contrato='".$CmbContrato."'";
$RespCtto=mysqli_query($link, $Consulta);
while($FilaCtto=mysql_fetch_array($RespCtto))
{
	echo $FilaCtto["cod_contrato"]."--->".FormatearNombre($FilaCtto["descripcion"]);
}
?>            </td>
<td width="21%" class="formulario">A&ntilde;o Ingreso </td>
<td align="left" class="formulario"><? echo $CmbAno; ?></td>
</tr>
<tr>
<td class="formulario">Estado</td>
<td align="left" class="formulario">
<?
$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30008' and cod_subclase='".$CmbEstado."'";
$Resp=mysqli_query($link, $Consulta);
while($Fila=mysql_fetch_array($Resp))
{
	echo $Fila["nombre_subclase"];
}
?>			</td>
<td class="formulario">&nbsp;</td>
<td class="formulario">&nbsp;</td>
</tr>
</table><br>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">		
       <tr>
         <td width="8%" align="center" class="TituloCabecera">Hoja Ruta </td>
          <td width="12%" align="center" class="TituloCabecera">Fecha Ingreso </td>
          <td width="7%" align="center" class="TituloCabecera">Contrato</td>
          <td width="20%" align="center" class="TituloCabecera">Empresa</td>
          <td width="18%" align="center" class="TituloCabecera">Adm.Codelco</td>
	      <td width="23%" align="center" class="TituloCabecera">Adm.Contratista</td>
		  <td width="23%" align="center" class="TituloCabecera">Hito</td>
      </tr>
  <?
$Cons='S';
if($Cons=='S')
{
	$Consulta = "SELECT * from sget_hoja_ruta ";
	$Consulta.=" where not isnull(num_hoja_ruta)  ";
	if($CmbEmpresa!='-1')
		$Consulta.=" and  rut_empresa='".$CmbEmpresa."' ";
	if($CmbContrato!='S')
		$Consulta.=" and  cod_contrato='".$CmbContrato."' ";
	if($TxtHoja!='')
		$Consulta.= " and num_hoja_ruta like ('%".trim($TxtHoja)."%') ";
	if($CmbAno!='T')
		$Consulta.= " and year(fecha_ingreso)= '".$CmbAno."' ";
	if($CmbEstado!='S')
	{
		$Consulta.= " and cod_estado_aprobado ='".$CmbEstado."'  ";	
	}
	else
		$Consulta.= " and cod_estado_aprobado <>'3' ";		
	$Consulta.= " order by num_hoja_ruta desc, cod_estado_aprobado asc   ";		
	//echo $Consulta;
	$Resp = mysqli_query($link, $Consulta);
	$cont=1;
	while ($Fila_HR=mysql_fetch_array($Resp))
	{
		?>     	
		<tr> 
    	<td ><? echo $Fila_HR["num_hoja_ruta"]."&nbsp;"; ?></td>
        <td ><? echo substr($Fila_HR["fecha_ingreso"],0,10)."&nbsp;"; ?>&nbsp;</td>
        <td ><? echo $Fila_HR["cod_contrato"]."&nbsp;"; ?></td>
        <td >
		<? 
		    $RazonSoc=DescripcionRazonSocial($Fila_HR["rut_empresa"]);
		  	echo FormatearNombre($RazonSoc)."&nbsp;"; ?></td>
          	<td >
			<?
		   	$VarCodelco=AdmCttoCodelco($Fila_HR["cod_contrato"]);
		   	$array=explode('~',$VarCodelco);
		   	echo FormatearNombre($array[1]).' '.FormatearNombre($array[2]).' '.FormatearNombre($array[3]);
	   		?>&nbsp;			</td>
          	<td >
			<? 
		  	$VarContratista=AdmCttoContratista($Fila_HR["cod_contrato"]);
	  	 	$array=explode('~',$VarContratista);
	   	 	echo ucfirst(strtolower($array[1])).' '.ucfirst(strtolower($array[2])).' '.ucfirst(strtolower($array[3]));
		  	?>
&nbsp;	  		</td>
			<td class="formulario">
			<?
			$Consulta = "SELECT max(fecha_hora) as fecha_hora from sget_reg_estados  ";
			$Consulta.= " where num_hoja_ruta='".$Fila_HR[num_hoja_ruta]."'";
			$Consulta.= " group by num_hoja_ruta ";
			$RespCrea=mysqli_query($link, $Consulta);
			$FilaCrea=mysql_fetch_array($RespCrea);
			
			$Consulta = "SELECT cod_estado,tipo from sget_reg_estados  ";
			$Consulta.= " where num_hoja_ruta='".$Fila_HR[num_hoja_ruta]."' and fecha_hora='".$FilaCrea["fecha_hora"]."'";
			$RespCrea=mysqli_query($link, $Consulta);
			if($FilaCrea=mysql_fetch_array($RespCrea))
			{
				if($FilaCrea["tipo"] =='E')
				{
					$Consulta="SELECT * from proyecto_modernizacion.sub_clase where cod_clase='30008' and cod_subclase ='".$FilaCrea["cod_estado"]."' ";
					$Resp2=mysqli_query($link, $Consulta);
					$Fila2=mysql_fetch_array($Resp2);
					{
						echo str_replace(' ','&nbsp;',$Fila2["nombre_subclase"]);
					}
				}
				else
				{
					$Consulta="SELECT * from sget_hitos where cod_hito='".$FilaCrea["cod_estado"]."' ";
					$Resp2=mysqli_query($link, $Consulta);
					$Fila2=mysql_fetch_array($Resp2);
					{
						echo str_replace(' ','&nbsp;',$Fila2[descrip_hito]);
					}
				}	
			}
			?>			</td>
  </tr>
  			<?		
  		$cont++;
	}
}
?>			
</table>
</body>
</form>
</html>