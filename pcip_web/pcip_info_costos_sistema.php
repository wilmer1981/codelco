<? include("../principal/conectar_pcip_web.php");
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" >
  <tr>
   <td class="formulario2">
   <table width="100%" border="1" cellpadding="4" cellspacing="0" >
	 <tr align="center">
	   <td width="16%" class="TituloTablaVerde">Código C.Costo</td>
	   <td width="84%" class="TituloTablaVerde">Descripción del Area</td>
	 </tr>
	 <?
		$Consulta = "select t1.cod_cc,t1.descrip_area from pcip_eec_centros_costos_por_sistema t2 inner join pcip_eec_centro_costos t1 on";			
		$Consulta.=" t1.cod_cc=t2.cod_cc where t2.cod_sistema='".$Cod."' order by t1.cod_cc";
		$Resp = mysql_query($Consulta);
		//echo $Consulta;
			while ($Fila=mysql_fetch_array($Resp))
			{
			$Cod=$Fila["cod_cc"];
			$Area=$Fila["descrip_area"];
	 ?>
		 <tr class="FilaAbeja">   
		   <td align="center"><? echo $Cod; ?></td>
		   <td ><? echo $Area; ?></td>
		 </tr>
	 <?
			}
	 ?>
   </table>
   </td>
  </tr>
</table>