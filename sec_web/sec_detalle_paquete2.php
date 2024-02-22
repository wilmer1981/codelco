<?php 
include("../principal/conectar_pmn_web.php");

$Codigo   = isset($_REQUEST["Codigo"])?$_REQUEST["Codigo"]:"";
$Numero   = isset($_REQUEST["Numero"])?$_REQUEST["Numero"]:"";
$IE       = isset($_REQUEST["IE"])?$_REQUEST["IE"]:"";
$MesI   = isset($_REQUEST["MesI"])?$_REQUEST["MesI"]:"";
$NumI   = isset($_REQUEST["NumI"])?$_REQUEST["NumI"]:"";
$MesF   = isset($_REQUEST["MesF"])?$_REQUEST["MesF"]:"";
$NumF   = isset($_REQUEST["NumF"])?$_REQUEST["NumF"]:"";

?>
<html>
<head>
<title>Paquetes</title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt,A)//Opcion y la ornada
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			window.close();
		break;
		case "E":
			Eliminar(A);
			break;
	}
}
</script>
</head>
<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
<input name="NumI" type="hidden" value="<?php echo $NumI  ?>">
<input name="NumF" type="hidden" value="<?php echo $NumF  ?>">
<input name="MesI" type="hidden" value="<?php echo $MesI  ?>">
  <table width="544" border="0">
    <tr> 
      <td width="538"><table width="538" border="0" cellpadding="1" cellspacing="1" class="TablaInterior">
          <tr> 
            <td width="45">&nbsp;</td>
            <td colspan="4"> <div align="right"> &nbsp; 
                <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
              </div></td>
            <td width="218">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="35">Lote :</td>
            <td width="61">
			<?php
			echo $Codigo;
			echo "-";
			echo $Numero;
			echo "<input name='CodigoO' type='hidden' value='$Codigo'>";
			echo "<input name='NumeroO' type='hidden' value='$Numero'>";
			?>
			&nbsp;</td>
            <td width="87">Sub Lote Inicial</td>
            <td width="73">
			<?php
			echo $MesI;
			echo "-";
			echo $NumI;
			
			?>
			&nbsp;</td>
            <td>Sub Lote Final:
              <?php
			echo $MesF;
			echo "-";
			echo $NumF;
			
			?>
            </td>
          </tr>
        </table>
        <br>
        <table width="536" border="0" cellpadding="3" cellspacing="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
           <!-- <td width="20">&nbsp; -->
            <td width="90"><div align="center">Serie Paquete</div></td>
            <td width="57"><div align="center">Peso</div></td>
            <td width="113"><div align="center">Unidades</div></td>
            <td width="106"><div align="center">Estado</div></td>
            <td width="204"> <div align="center">Cod Producto</div></td>
          </tr>
        </table> </td>
    </tr>
  </table>
  <table width="536" border='1' cellpadding='3' cellspacing='0'>
    <?php  
	$Consulta=" SELECT t1.cod_paquete,t1.num_paquete,t1.cod_producto,t1.num_unidades,t1.peso_paquetes,t1.cod_estado,t1.fecha_creacion_paquete ";
	$Consulta.=" from sec_web.paquete_catodo t1";
	$Consulta.=" inner join sec_web.lote_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
	$Consulta.=" where (t2.num_paquete between '".$NumI."' and '".$NumF."' and t1.cod_estado=t2.cod_estado) and t2.cod_paquete='".$MesI."'";
	$Consulta.=" and corr_enm=".$IE." and cod_bulto='".$Codigo."' and num_bulto='".$Numero."'";
	$Consulta.=" and t1.fecha_creacion_paquete = t2.fecha_creacion_paquete";
	$Consulta.=" order by	t1.cod_paquete,t1.num_paquete	";
	//echo $Consulta;
	$Respuesta=mysqli_query($link, $Consulta);
	$SumaPeso=0; //WSO
	$SumaUnidades=0; //WSO
	while ($Fila=mysqli_fetch_array($Respuesta))
	{
		echo "<tr>";
			echo "<td width='90'>".$Fila["cod_paquete"]."-".$Fila["num_paquete"]."</td> ";
			echo "<td width='57'>".$Fila["peso_paquetes"]."</td> ";	
			echo "<td width='113'>".$Fila["num_unidades"]."</td> ";
			if ($Fila["cod_estado"]=="c")
			{
				$Estado="Cerrado";
			}
			else
			{
				$Estado="Abierto";
			}
			echo "<td width='57'>".$Estado."</td> ";		
			echo "<td width='204'>".$Fila["cod_producto"]."</td> ";	
		echo "</tr>";
		$SumaPeso    = $SumaPeso + $Fila["peso_paquetes"];
		$SumaUnidades= $SumaUnidades + $Fila["num_unidades"];
	}
	echo "<tr>";
	echo "<td width='90'><strong>Total</strong></td>";
	echo "<td width='57'><strong>".$SumaPeso."</strong></td> ";		
	echo "<td width='113'><strong>".$SumaUnidades."</strong></td> ";	
	echo "<td width='57'>&nbsp;</td>";
	echo "<td width='204'>&nbsp;</td>";
	echo "</tr>";
	?>
  </table>
	<?php
		echo "<script languaje='JavaScript'>";
		echo "var frm=document.FrmProceso;";
		if ($Mensaje=='S')
		{
			echo "alert('Este Lote esta Asociado a una Inst Embarque');";
		}		
		echo "</script>"
  	?>
</form>
</body>
</html>
