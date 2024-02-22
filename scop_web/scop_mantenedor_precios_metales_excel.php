<?
header("Content-Type:  application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../principal/conectar_scop_web.php");
include("funciones/scop_funciones.php");
$KoolControlsFolder="KoolPHPSuite/KoolControls";
require $KoolControlsFolder."/KoolAjax/koolajax.php";
$koolajax->scriptFolder = $KoolControlsFolder."/KoolAjax";

if($koolajax->isCallback)
{
	sleep(0); //Slow down 1s to see loading effect
}

echo $koolajax->Render();

?>
<html>
<head>
<title>Proceso Cobertura de Precios</title>
<form name="FrmPrincipal" method="post" action="">
<table width="100%" border="1" cellpadding="2" cellspacing="0" >
  <tr>
    <td width="20%" rowspan="2" align="center" class="TituloCabecera">A&ntilde;o/Mes</td>
    <td width="15%" colspan="2" align="center" class="TituloCabecera">Cu</td>
    <td width="15%" colspan="2" align="center" class="TituloCabecera">Ag</td>
    <td width="15%" colspan="2" align="center" class="TituloCabecera">Au</td>
  </tr>
  <tr>
    <td  align="center" class="TituloCabecera">Valor</td>
    <td  align="center" class="TituloCabecera">Unidad</td>
    <td  align="center" class="TituloCabecera">Valor</td>
    <td  align="center" class="TituloCabecera">Unidad</td>
    <td  align="center" class="TituloCabecera">Valor</td>
    <td  align="center" class="TituloCabecera">Unidad</td>
  </tr>
  <?
				$Consulta="select t1.cod_ley,t1.ano,t1.mes,t1.valor,t1.cod_unidad,t2.nombre_subclase as nom_ley,t3.nombre_subclase as nom_unidad from scop_precios_metales t1";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33003' and t1.cod_ley=t2.cod_subclase";
				$Consulta.=" inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='33004' and t1.cod_unidad=t3.cod_subclase";
				$Consulta.=" where ano='".$AnoAux."'";						
				$Consulta.=" group by ano,mes";						
				$Resp=mysql_query($Consulta);
				while($Fila=mysql_fetch_array($Resp))
				{						
						$Cod=$Fila["ano"]."~".$Fila["mes"];
					 echo "<tr bgcolor='#FFFFFF'>";
					   echo "<td align='left' >".$Fila["ano"]."/".$Meses[$Fila["mes"]-1]."</td>";
						for($i=1;$i<=3;$i++)
						{
							echo "<td align='right' >".number_format($ValorFino=BuscarValor($i,$Fila["ano"],$Fila["mes"],'v'),3,',','.')."</td>";
							echo "<td align='center' >".BuscarValor($i,$Fila["ano"],$Fila["mes"],'u')."</td>";
						}
					 echo "</tr>";							
			    }
			 ?>
</table>
<br>
</form>
</body>
</html>
<?
	echo "<script languaje='JavaScript'>";
	if ($Mensaje==1&&$Envio=='S')
		echo "alert('Registro Ingresado Exitosamente, Envio de Correo Exitoso');";
	if ($Mensaje==1&&$Envio=='N')
		echo "alert('Registro Ingresado Exitosamente, No Existen Correos para este Proceso');";
	if ($Mensaje==2)
		echo "alert('Este Registro Existe');";
	if ($Mensaje==3)
		echo "alert('Registro Modificado Exitosamente');";
	if ($Mensaje==4)
		echo "alert('Registro Eliminado Exitosamente');";
	echo "</script>";

function BuscarValor($CodLey,$Ano,$Mes,$Tipo)
{
	$Consulta="select t1.valor,t2.nombre_subclase from scop_precios_metales t1 inner join proyecto_modernizacion.sub_clase t2 on t2.cod_clase='33004' and t1.cod_unidad=t2.cod_subclase and t2.valor_subclase1=t1.cod_ley";
	$Consulta.=" where t1.ano='".$Ano."' and t1.mes='".$Mes."' and t1.cod_ley='".$CodLey."'";
	$Resp=mysql_query($Consulta);
	while($Fila=mysql_fetch_array($Resp))
	{
		$Nom_uni=$Fila["nombre_subclase"];
		$Valor=$Fila["valor"];
	}	
	if($Tipo=='v')
		return $Valor;
	else
		return $Nom_uni;	
}
?>
