<? include("../principal/conectar_pcip_web.php");
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" >
  <tr>
   <td class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
	 <tr align="center">
	  
	   <td width="16%" class="TituloTablaVerde">Codigo Equipo </td>
	   <td width="84%" class="TituloTablaVerde">Equipos</td>
	 </tr>
	 <?

		$Consulta = "select t2.cod_equipo,t2.nom_equipo";
		$Consulta.= " from pcip_eec_equipos_por_sistema t1 inner join pcip_eec_equipos t2 on t1.cod_equipo=t2.cod_equipo";
		$Consulta.=" where t1.cod_sistema='".$Cod."'";
		$Consulta.= " order by cod_equipo ";
		$Resp = mysql_query($Consulta);
		//echo $Consulta;
			while ($Fila=mysql_fetch_array($Resp))
			{
			$Cod=$Fila["cod_equipo"];
			$Equipo=$Fila["nom_equipo"];
	 ?>
		 <tr class="FilaAbeja">   
		   <td align="center"><? echo $Cod; ?></td>
		   <td ><? echo $Equipo; ?></td>
		 </tr>
	 <?
			}
	 ?>
   </table></td>
  </tr>
</table>