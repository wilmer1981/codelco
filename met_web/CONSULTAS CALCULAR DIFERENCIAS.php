				
<?
				$sql= "SELECT Sum(P_SECO) AS PESOSECO from enabalpmn_base where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN_BASE.NOM_PRODUCTO='$producto1') and (ENABALPMN_BASE.N_FLUJO='$txtflujo') and ENABALPMN_BASE.T_MOV='$select2' ";
				$sql1= "SELECT Sum(P_SECO) AS PESOSECO1 from enabal_base where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN_BASE.NOM_PRODUCTO='$producto1') and (ENABALPMN_BASE.N_FLUJO='$txtflujo') and ENABALPMN_BASE.T_MOV='$select2' ";

				 $consulta="Sum(F_COBRE) AS FINOCOBRE from enabalpmn_base where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN_BASE.NOM_PRODUCTO='$producto1') and  (ENABALPMN_BASE.N_FLUJO='$txtflujo') and ENABALPMN_BASE.T_MOV='$select2' ";
				 $consulta4="Sum(F_COBRE) AS FINOCOBRE1 from enabal_base where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN_BASE.NOM_PRODUCTO='$producto1') and  (ENABALPMN_BASE.N_FLUJO='$txtflujo') and ENABALPMN_BASE.T_MOV='$select2' ";

				 $consulta2=" Sum(F_PLATA) AS FINOPLATA	from enabalpmn_base where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN_BASE.NOM_PRODUCTO='$producto1') and  (ENABALPMN_BASE.N_FLUJO='$txtflujo') and ENABALPMN_BASE.T_MOV='$select2' ";
				 $consulta5=" Sum(F_PLATA) AS FINOPLATA1	from enabal_base where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN_BASE.NOM_PRODUCTO='$producto1') and  (ENABALPMN_BASE.N_FLUJO='$txtflujo') and ENABALPMN_BASE.T_MOV='$select2' ";

				 $consulta3= "Sum(F_ORO) AS FINOORO from enabalpmn_base where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN_BASE.NOM_PRODUCTO='$producto1') and  (ENABALPMN_BASE.N_FLUJO='$txtflujo') and ENABALPMN_BASE.T_MOV='$select2' ";
				 $consulta6= "Sum(F_ORO) AS FINOORO1 from enabal_base where (FECHA BETWEEN '$separador1[0]-$formato1-01' AND '$separador1[0]-$formato1-31') AND (ENABALPMN_BASE.NOM_PRODUCTO='$producto1') and  (ENABALPMN_BASE.N_FLUJO='$txtflujo') and ENABALPMN_BASE.T_MOV='$select2' ";

							$PESOBASE=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$PESOFINAL=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$PESODIF=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$FINOCOBREBASE=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$FINOCOBREFINAL=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$FINOCOBREDIF=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$FINOPLATABASE=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$FINOPLATAFINAL=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$FINOPLATADIF=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$FINOROBASE=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$FINOROFINAL=array("0","0","0","0","0","0","0","0","0","0","0","0");
							$FINORODIF=array("0","0","0","0","0","0","0","0","0","0","0","0");

				
				function PESOSECOENABAL($consulta,$consulta2)
				{
				$resultado=mysql_query($consulta)
				if($cod=mysql_fetch_array($resultado)
				{
					$PESOBASE[$j]=cod[PESOSECO];
				}
				$resultados=mysql_query($consulta2)
				if($codi=mysql_fetch_array($resultado)
				{
					$PESOFINAL[$j]=codi[PESOSECO1];
				}
				$PESODIF[$j]=$PESOBASE[$j] - $PESOFINAL[$j];
				$j=$j+1;
				}
				function PESOSECOENABALPMN($consulta,$consulta2)
				{
				$resultado=mysql_query($consulta)
				if($cod=mysql_fetch_array($resultado)
				{
					$PESOBASE[$j]=cod[PESOSECO];
				}
				$resultados=mysql_query($consulta2)
				if($codi=mysql_fetch_array($resultado)
				{
					$PESOFINAL[$j]=codi[PESOSECO1];
				}
				$PESODIF[$j]=$PESOBASE[$j] - $PESOFINAL[$j];
				$k=$k+1;
				}
				
				function FINOCOBREENABAL($consulta)
				{
				}
				function FINOPLATA($consulta)
				{
				}
				function FINORO($consulta)
				{
				}
				
				

				
?>