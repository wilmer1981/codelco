<? include("../principal/conectar_pcip_web.php");
?>
		<table width="100%" border="0" cellpadding="3" cellspacing="0" >
          <tr>
           <td class="formulario2"><table width="100%" border="1" cellpadding="4" cellspacing="0" >
             <tr align="center">
              
               <td width="16%" class="TituloTablaVerde">Código Indicador</td>
               <td width="35%" class="TituloTablaVerde">Descripción Indicador </td>
			   <td width="36%" class="TituloTablaVerde">Divisor Indicador</td>
               <td width="13%" class="TituloTablaVerde">Vigente</td>			   
             </tr>
             <?
				$Consulta = "select t1.cod_indicador,t1.nom_indicador,t1.vigente,t3.nombre_subclase as nom_divisor from pcip_eec_sistemas_por_indicadores t2 inner join pcip_eec_indicadores t1 on";			
				$Consulta.=" t1.cod_indicador=t2.cod_indicador inner join proyecto_modernizacion.sub_clase t3 on t3.cod_clase='31011' and t2.cod_divisor=t3.cod_subclase where t2.cod_sistema='".$Cod."' order by t1.cod_indicador";
				$Resp = mysql_query($Consulta);
				//echo $Consulta;
				    while ($Fila=mysql_fetch_array($Resp))
				    {
					$Cod=$Fila["cod_indicador"];
					$Ind=$Fila["nom_indicador"];
					$Div=$Fila["nom_divisor"];
					$Vig=$Fila["vigente"];					
			 ?>
				 <tr class="FilaAbeja">   
				   <td align="center"><? echo $Cod; ?></td>
				   <td ><? echo $Ind; ?></td>
				   <td ><? echo $Div; ?></td>
				   <td align="center"><? echo $Vig; ?></td>
				 </tr>
             <?
					}
         	 ?>
           </table></td>
          </tr>
       </table>