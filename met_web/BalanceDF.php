<?php
	switch($ValorRadio)
	{
		case 'FUNDICION':
			$EstRadio1='checked';
			$EstRadio2='';
			$EstRadio3='';
			break;			
		case 'RAF':
			$EstRadio1='';
			$EstRadio2='checked';
			$EstRadio3='';
			break;	
		case 'REF':
			$EstRadio1='';
			$EstRadio2='';
			$EstRadio3='checked';		
			break;
		default:
			$EstRadio1='checked';
			$EstRadio2='';
			$EstRadio3='';
			break;			
	}		

	switch($ValorRadio2)
	{
		case 'PESOCOBRE':
			$EstadoRadio1='checked';
			$EstadoRadio2='';
			$EstadoRadio3='';
			$EstadoRadio4='';			
			break;			
		case 'FINOCOBRE':
			$EstadoRadio1='';
			$EstadoRadio2='checked';
			$EstadoRadio3='';
			$EstadoRadio4='';			
			break;	
		case 'FINOPLATA':
			$EstadoRadio1='';
			$EstadoRadio2='';
			$EstadoRadio3='checked';
			$EstadoRadio4='';					
			break;
		case 'FINOORO':
			$EstadoRadio1='';
			$EstadoRadio2='';
			$EstadoRadio3='';
			$EstadoRadio4='checked';					
			break;			
		default:
			$EstadoRadio1='checked';
			$EstadopRadio2='';
			$EstadoRadio3='';
			$EstadoRadio4='';			
			break;			
	}		
	
	

	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
<title>DATOS FINALES - BALANCE  </title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
</head>
<script language="javascript">

function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}
function AgregarFlujos(){
	var f=document.form1;
	f.action='../met_web/AgregarFlujos.php';
	f.submit();	
}

function ModificarEliminarFlujos(){
	var f=document.form1;
	f.action='../met_web/Modflujos.php';
	f.submit();	
}

function Generar(opt)
{
	var f=document.form1;
	
	var VRadio='';
	var VRadio2='';

	if(f.radiobutton[0].checked==true)
		VRadio=f.radiobutton[0].value;
	else if(f.radiobutton[1].checked==true)
		VRadio=f.radiobutton[1].value;	
	else if(f.radiobutton[2].checked==true)
		VRadio=f.radiobutton[2].value;	
	
	if(f.radiobutton2[0].checked==true)
		VRadio2=f.radiobutton2[0].value;
	else if(f.radiobutton2[1].checked==true)
		VRadio2=f.radiobutton2[1].value;	
	else if(f.radiobutton2[2].checked==true)
		VRadio2=f.radiobutton2[2].value;
	else if(f.radiobutton2[3].checked==true)
		VRadio2=f.radiobutton2[3].value;		
	
	switch (opt)
	{
		case "B":
			//f.action="BalanceDF.php?buscarOPT=S&ValorRadio=&ValorRadio2="+VRadio+VRadio2; 
			f.action="BalanceDF.php?buscarOPT=S&ValorRadio="+VRadio + "&ValorRadio2="+VRadio2; 			
			f.submit();
			break;
		case "E":
			f.action="BalanceDF_excel.php?buscarOPT=S&ValorRadio=&ValorRadio2="+VRadio+VRadio2; 
			f.submit();
			break;
	}	
}

</script>
<body>
<form name="form1" method="post" action="">
<?
	include("../principal/encabezado.php");
	include("conectar.php");
?>
  <table width="770" height="330" border="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="top"><table width="700" border="1" align="center">
        <tr>
          <td colspan="8"><div align="center" class="Detalle03"><strong>Balance</strong></div></td>
        </tr>
        <tr>
          <td width="115" rowspan="3">&nbsp;</td>
          <td width="20"><input name="radiobutton" type="radio" value="FUNDICION" <? echo $EstRadio1?> ></td>
          <td width="132">Fundicion</td>
          <td width="94"><div align="justify">A&ntilde;o
                  <select name="select">
                    <?php 
				for($i=1996;$i<=date("Y")+1;$i++)
				{
					if($select==$i)
						echo "<option selected value='".$i."'>".$i."</option>\n";
					else
						echo "<option value='".$i."'>".$i."</option>\n";						
				}
			?>
                  </select>
          </div></td>
          <td width="20"><input name="radiobutton2" type="radio" value="PESOSECO" <? echo $EstadoRadio1?>></td>
          <td width="65">Peso Seco </td>
          <td width="20"><input name="radiobutton2" type="radio" value="FINOCOBRE" <? echo $EstadoRadio2?>></td>
          <td width="156">Fino Cobre </td>
        </tr>
        <tr>
          <td><input name="radiobutton" type="radio" value="RAF" <? echo $EstRadio2?>></td>
          <td>RAF</td>
          <td><div align="center"></div></td>
          <td><input name="radiobutton2" type="radio" value="FINOPLATA" <? echo $EstadoRadio3?>></td>
          <td>Fino Plata </td>
          <td><input name="radiobutton2" type="radio" value="FINOORO" <? echo $EstadoRadio4?>></td>
          <td>Fino Oro </td>
        </tr>
        <tr>
          <td><input name="radiobutton" type="radio" value="REF" <? echo $EstRadio3?>></td>
          <td>Refineria Electrolitica</td>
          <td colspan="5"><div align="center">
          </div></td>
          </tr>
        <tr>
          <td colspan="8">&nbsp;</td>
          </tr>
        <tr>
          <td colspan="8"><div align="center">
              <input type="button" name="GenerarBalance" value="Generar Balance" onClick="Generar('B')">
              <input type="button" name="BtnAgregarFlujos" value="Agregar Flujos" onClick="AgregarFlujos()">
              <input type="button" name="BtnModificarEliminar" value="Modificar/Eliminar Flujos" onClick="ModificarEliminarFlujos()">
              <input type="submit" name="excel" value="Planilla Excel" onClick="Generar('E')">
              <input type="submit" name="Submit6" value="Volver" style="width:70px " onClick="Volver()">
          </div></td>
        </tr>
      </table>

   <?php 
		
		if($buscarOPT=="S")
		{	
			echo "<table width='1013' border='0' cellpadding='0' cellspacing='0' class='TablaDetalle'>";
			echo "<tr>";
			echo "<td align='center' width='1013'><strong>BALANCE PROCESO ".$radiobutton." A�O ".$select."</strong><td>";
			echo "</tr>";echo "<tr>";
			echo "<td align='center'><strong>".$radiobutton2."</strong><td>";
			echo "</tr>";				
			echo "<tr><td><br></td></tr>";
			echo "</table>";			
			
			echo "<table width='1013' border='1' cellpadding='0' cellspacing='0' class='TablaDetalle'>";									
			echo "<tr align='center' class='ColorTabla01'>";
          	echo "<td width='290'>Item</td>";
          	echo "<td width='100'> Enero </td>";
        	echo "<td width='100'> Febrero </td>";
        	echo "<td width='100'>Marzo</td>";
          	echo "<td width='100'>Abril</td>";
          	echo "<td width='100'>Mayo</td>";
          	echo "<td width='100'>Junio</td>";
          	echo "<td width='100'>Julio</td>";
          	echo "<td width='100'>Agosto</td>";
          	echo "<td width='100'>Septiembre</td>";
          	echo "<td width='100'>Octubre</td>";
          	echo "<td width='100'>Noviembre</td>";
          	echo "<td width='100'>Diciembre</td>";
          	echo "<td width='100'>Totales</td>";
  		 	echo "</tr>";
		
				
			// Determinar que proceso es seleccionado [Fundicion - RAF - Refineria Electolitica]
			$NumFlujo=DeterminarProceso($radiobutton);			
			$ExistenciaInicial=array();$FinalEntradas=array();
			$ExistenciaFinal=array();$FinalSalidas=array();
			
			// Determinar la existencia final para el proceso y el a&ntilde;o solicitado			
			$ExistenciaFinal=CalcularExistenciaFinal($select,$radiobutton,$radiobutton2,$NumFlujo);			
			// Determinar la existencia inicial para el proceso y el a&ntilde;o solicitado			
			$ExistenciaInicial=CalcularExistenciaInicial($select,$radiobutton,$radiobutton2,$NumFlujo,$ExistenciaFinal);

			$sentido='E';			
			$FinalEntradas=GenerarBalance($radiobutton,$radiobutton2,$sentido,$select,$ExistenciaInicial);			
			$sentido='S';
			$FinalSalidas=GenerarBalance($radiobutton,$radiobutton2,$sentido,$select,$ExistenciaFinal);
						
			MostrarDiferencias($FinalEntradas,$FinalSalidas);
		}
		
		function DeterminarProceso($radiobutton)
		{
			switch ($radiobutton)
			{
				case "FUNDICION":
					$consult="Select FLUJO from flujoitem,item where item.nom_item='EXISTENCIA FUNDICION' and item.cod_item=flujoitem.cod_item";
					$cons=mysql_query($consult);
					if($fila=mysql_fetch_array($cons))
					{
						$NumFlujo=$fila[FLUJO];
					}
					break;
					
				case "RAF":
					$consult="Select FLUJO from flujoitem,item where item.nom_item='EXISTENCIA RAF' and item.cod_item=flujoitem.cod_item";
					$cons=mysql_query($consult);
					if($fila=mysql_fetch_array($cons))
					{
						$NumFlujo=$fila[FLUJO];
					}
					break;
					
				case "REF":
					$consult="Select FLUJO from flujoitem,item where item.nom_item='EXISTENCIA REF' and item.cod_item=flujoitem.cod_item";
					$cons=mysql_query($consult);
					if($fila=mysql_fetch_array($cons))
					{
						$NumFlujo=$fila[FLUJO];
					}
					break;
				default: break;				
			}
			return $NumFlujo;
		}
		
		function CalcularExistenciaFinal($select,$radiobutton,$radiobutton2,$NumFlujo)
		{
			$efinal=array();
			for($i=1;$i<=12;$i++)
			{
				$fechaini=$select."-".$i."-01";
				$fechafin=$select."-".$i."-31";
				$cons1=DeterminarHojaBalance($fechaini,$fechafin,$radiobutton2,$NumFlujo);	
				$resultado=mysql_query($cons1);
				if($fila=mysql_fetch_array($resultado)){
					$efinal[$i-1]=$fila[CALCULO];
				}
			}
			return $efinal;									
		}		
						
		function CalcularExistenciaInicial($select,$radiobutton,$radiobutton2,$NumFlujo,$ExistenciaFinal)
		{
			$einicial=array();
			$select--;
			$fechaini=$select."-"."12"."-01";
			$fechafin=$select."-"."12"."-31";			
			$cons1=DeterminarHojaBalance($fechaini,$fechafin,$radiobutton2,$NumFlujo);																								
			$res1=mysql_query($cons1);
			if($fila=mysql_fetch_array($res1)){
				$einicial[0]=$fila[CALCULO];
			}					

			$select++;
			for($i=1;$i<=12;$i++)
			{
				// la existencia inicial del mes dado corresponde a la existencia final del mes anterior	
				$einicial[$i]=$ExistenciaFinal[$i-1];	
			}
			return $einicial;			
		}
		
		function DeterminarHojaBalance($fechaini,$fechafin,$radiobutton2,$NumFlujo)
		{
			switch ($radiobutton2)
			{
				case "PESOSECO":
					$cons1="Select sum(P_SECO) AS CALCULO from enabal where N_FLUJO='$NumFlujo' and T_MOV=3 and FECHA between '$fechaini' and '$fechafin'";
					break;
							
				case "FINOCOBRE":
					$cons1="Select sum(F_COBRE) AS CALCULO from enabal where N_FLUJO='$NumFlujo' and T_MOV=3 and FECHA between '$fechaini' and '$fechafin'";						
					break;					
				
				case "FINOPLATA":
					$cons1="Select sum(F_PLATA) AS CALCULO from enabal where N_FLUJO='$NumFlujo' and T_MOV=3 and FECHA between '$fechaini' and '$fechafin'";						
					break;
							
				case "FINOORO":
					$cons1="Select sum(F_ORO) AS CALCULO from enabal where N_FLUJO='$NumFlujo' and T_MOV=3 and FECHA between '$fechaini' and '$fechafin'";						
					break;
				
				default: break;												
			}		
			return $cons1;
		}		
								
		function GenerarBalance($radiobutton,$radiobutton2,$sentido,$select,$Existencia)
		{
			$TotalEntradas=array();$TotalSalidas=array();$meses=array(); $subtotal=array(); 
			if($sentido=='E')
			{
				echo "<tr>";
				echo "<td align='center'><strong>EXISTENCIA INICIAL ".$radiobutton."</strong></td>";
				for($i=1;$i<=12;$i++)
				{
					echo "<td><strong>".$formato=number_format($Existencia[$i-1],'0',',','.')."</strong></td>";
					$TotalEntradas[$i-1]=$TotalEntradas[$i-1]+$Existencia[$i-1];
				}				
				echo "</tr>";
				echo "<tr><td><br></td></tr>";
			}else if($sentido=='S')
			{
				echo "<tr>";
				echo "<td align='center'><strong>EXISTENCIA FINAL ".$radiobutton."</strong></td>";
				for($i=1;$i<=12;$i++)
				{
					echo "<td><strong>".$formato=number_format($Existencia[$i-1],'0',',','.')."</strong></td>"; 
					$TotalSalidas[$i-1]=$TotalSalidas[$i-1]+$Existencia[$i-1];	
				}				
				echo "</tr>";
				echo "<tr><td><br></td></tr>";
			
			}
 			//determinar la cantidad de grupos existentes
			$consulta1="Select distinct grupo from item where item.proceso='$radiobutton'  and item.ent_sal='$sentido'";
			$resultado1=mysql_query($consulta1);
			while($fila1=mysql_fetch_array($resultado1))
			{
				// seleccionar cod_item y nom_item de todos los items pertenecientes a un grupo en particular 
				$consulta2="Select cod_item, nom_item from item where item.proceso='$radiobutton' and item.ent_sal='$sentido' and item.grupo='$fila1["grupo"]'";
				$resultado2=mysql_query($consulta2);					
				while($fila2=mysql_fetch_array($resultado2))
				{
					// determinar el N de flujo para un item en particular
					$consulta3="Select flujo from flujoitem where flujoitem.cod_item='$fila2[cod_item]' ";
					$resultado3=mysql_query($consulta3);
					while($fila3=mysql_fetch_array($resultado3))
					{
						//para cada flujo determinar el pesoseco asociado durante 12 meses en base a la fecha entregada
						for($i=1;$i<=12;$i++)
						{
							$fechaini=$select."-".$i."-01";
							$fechafin=$select."-".$i."-31";
							
							switch ($radiobutton2)
							{
								case "PESOSECO":
									$consulta4 = "Select sum(P_SECO) AS CALCULO2 from ENABAL where ENABAL.N_FLUJO='$fila3["flujo"]' and ENABAL.T_MOV='2' and ENABAL.FECHA between '".$fechaini."' and '".$fechafin."'";														
									break;								
								case "FINOCOBRE":
									$consulta4="Select sum(F_COBRE) AS CALCULO2 from ENABAL where ENABAL.N_FLUJO='$fila3["flujo"]' and ENABAL.T_MOV='2' and ENABAL.FECHA between '".$fechaini."' and '".$fechafin."'";														
									break;
								case "FINOPLATA":
									$consulta4="Select sum(F_PLATA) AS CALCULO2 from ENABAL where ENABAL.N_FLUJO='$fila3["flujo"]' and ENABAL.T_MOV='2' and ENABAL.FECHA between '".$fechaini."' and '".$fechafin."'";														
									break;
								case "FINOORO":
									$consulta4="Select sum(F_ORO) AS CALCULO2 from ENABAL where ENABAL.N_FLUJO='$fila3["flujo"]' and ENABAL.T_MOV='2' and ENABAL.FECHA between '".$fechaini."' and '".$fechafin."'";														
									break;		
								default:	break;																			
							}								
							$totalmes=0;
							$resultado4=mysql_query($consulta4);
							if($fila4=mysql_fetch_array($resultado4))
							{
								$totalmes=$fila4[CALCULO2];
								$meses[$i-1]=$meses[$i-1]+$totalmes;
								$total2=$total2+$totalmes;
							}							
						}	
					}						
					echo "<tr>";
					echo "<td align='center'>".$fila2[nom_item]."</td>";						
					for($i=1;$i<=12;$i++)
					{	
						echo "<td>".$formato=number_format($meses[$i-1],'0',',','.')."</td>";
						$subtotal[$i-1]=$subtotal[$i-1]+$meses[$i-1];
						$meses[$i-1]=0;
					}
					echo "<td>".$formato=number_format($total2,'0',',','.')."</td>";
					echo "</tr>";
					$total2=0;
				} 
				echo "<tr><td><br></td></tr>";
				echo "<tr>";
				echo "<td align='center'><strong>SUBTOTAL</strong></td>";
				for($i=1;$i<=12;$i++)
				{
					echo "<td><strong>".$formato=number_format($subtotal[$i-1],'0',',','.')."</strong></td>";
					if($sentido=='E')
						$TotalEntradas[$i-1]=$TotalEntradas[$i-1]+$subtotal[$i-1];
					else if($sentido=='S')
						$TotalSalidas[$i-1]=$TotalSalidas[$i-1]+$subtotal[$i-1]; 
						
					$subtotal[$i-1]=0;
				}
				echo "</tr>";
				echo "<tr><td><br></td></tr>";
											
			} 
			// mostrando total acumulado
			echo "<tr>";
			
			if($sentido=='E')
			{
				echo "<td align='center'><strong>TOTAL ENTRADAS</strong></td>";
				for($i=1;$i<=12;$i++)
				{ 
					echo "<td><strong>".$formato=number_format($TotalEntradas[$i-1],'0',',','.')."</strong></td>";
				}
				echo "</tr>";
				echo "<tr><td><br></td></tr>";
				return $TotalEntradas;					
			}
			else if($sentido=='S')
			{ 
				echo "<td align='center'><strong>TOTAL SALIDAS</strong></td>";
				//$auxiliar=1; // variable de control
				for($i=1;$i<=12;$i++)
				{
					echo "<td><strong>".$formato=number_format($TotalSalidas[$i-1],'0',',','.')."</strong></td>";
				}
				echo "</tr>";
				echo "<tr><td><br></td></tr>";
				return $TotalSalidas;				
			}
			
		}
		
		function MostrarDiferencias($FinalEntradas,$FinalSalidas)
		{
			echo "<tr>";$Diferencias=array();
			echo "<td align='center'><strong>DIFERENCIAS</strong></td>";
			for($i=1;$i<=12;$i++)
			{
				$Diferencias[$i-1] = $FinalEntradas[$i-1] - $FinalSalidas[$i-1];
			}
			for($i=1;$i<=12;$i++)
			{
				echo "<td><strong>".$formato=number_format($Diferencias[$i-1],'0',',','.')."</strong></td>";
			}
			echo "</tr>";
			echo "<tr><td><br></td></tr>";					
		}

  ?>
  </table></td>
    </tr>
  </table>
<?
	include("cerrarconexion.php");
	include("../principal/pie_pagina.php");
?>
</form>
</body>
</html>
