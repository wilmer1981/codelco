<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
<title>Datos Finales - Calculo Blister Neto</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}

function Buscar(opt)
{	
	var f=document.form1;

	
	switch (opt)
	{
		case "S":
			f.action="CalcularBlisterDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "I":
			f.action="CalcularBlisterDF_excel.php?buscarOPT=I" ;
			f.submit();
			break;
	}
	
	
}

</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style></head>

<body>
<form name="form1" method="post" action="">
<?
	include("../principal/encabezado.php");
	include("conectar.php");
?>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>

  <table width="770" height="330" border="1" class="TablaPrincipal">
    <tr>
      <td valign="top"><table width="457" height="76" border="1" align="center">
        <tr align="center" class="Detalle03">
          <td height="21" colspan="2"><strong>Calcular Blister Neto</strong></td>
        </tr>
        <tr>
          <td width="221" height="21" align="center">Desde: <font color="#000000" size="2">
            <select name="mes" size="1" id="select7" style="FONT-FACE:verdana;FONT-SIZE:10">
              <?
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($buscarOPT=='S')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes)
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
              
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
            </select>
            <select name="ano" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
              <?
		if($buscarOPT=='S')
		{
			for ($i=date("Y")-10;$i<=date("Y")+1;$i++)	
			{
				if ($i==$ano)
				{
				echo "<option selected value ='$i'>$i</option>";
				}
				else	
				{
				echo "<option value='".$i."'>".$i."</option>";
				}
			}
		}
		else
		{
			for ($i=date("Y")-10;$i<=date("Y")+1;$i++)	
			{
				if ($i==date("Y"))
				{
				echo "<option selected value ='$i'>$i</option>";
				}
				else	
				{
				echo "<option value='".$i."'>".$i."</option>";
				}
			 }   
		}	
	?>
            </select>
</font></td>
          <td width="220" align="right"><div align="center">Hasta: <font color="#000000" size="2">
            <select name="mes2" size="1" id="select" style="FONT-FACE:verdana;FONT-SIZE:10">
              <?
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($buscarOPT=='S')
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes2)
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }		
		}
		else
		{
		    for($i=1;$i<13;$i++)
		    {
                if ($i==date("n"))
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  
  		  
     ?>
            </select>
            <select name="ano2" size="1"  style="FONT-FACE:verdana;FONT-SIZE:10">
              <?
	if($buscarOPT=='S')
	{
	    for ($i=date("Y")-10;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano2)
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-10;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }	
?>
            </select>
</font><strong>
              </strong></div></td>
          </tr>
        <tr align="center">
          <td height="24" colspan="2"><input  type="button" name="search" value="Buscar" onClick="Buscar('S')" style="width:70px ">
&nbsp;
<input  type="button" name="search" value="Planilla Excel" onClick="Buscar('I')" style="width:100px ">
&nbsp;
   
      <input type="submit" name="Submit6" value="Volver" style="width:70px " onClick="Volver()"></td>
        </tr>
      </table>
        <br>
        <table width="454" border="1" align="center" cellpadding="2" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01">
            <td width="128"> Peso Seco (Kg)</td>
          <td > Fino Cobre (Kg)</td>
		   <td > Fino Plata (gr)</td>
		   <td > Fino Oro (gr)</td>
          <?
			$FechaIni=$ano."-".$mes."-01";
			$FechaFin=$ano2."-".$mes2."-01";
		if($buscarOPT=="S")
		{		
		//SUMA DE OTROS FLUJOS (SE RESTA AL BLISTER TOTAL)
			$sql= "SELECT Sum(P_SECO) AS PESOSECO, Sum(F_COBRE) AS FINOCOBRE, Sum(F_PLATA) AS FINOPLATA, Sum(F_ORO) AS FINOORO from ENABAL where ((FECHA BETWEEN '$FechaIni' AND '$FechaFin') AND 
			(ENABAL.N_FLUJO=77 Or ENABAL.N_FLUJO=144 Or ENABAL.N_FLUJO=139 Or ENABAL.N_FLUJO=249 Or ENABAL.N_FLUJO=376 Or ENABAL.N_FLUJO=257 Or 
			ENABAL.N_FLUJO=88 Or ENABAL.N_FLUJO=150) AND (ENABAL.T_MOV=2))";
			
			
			//BLISTER TOTAL 
			$sqldos="SELECT Sum(P_SECO) AS Sseco, Sum(F_COBRE) AS Scobre, Sum(F_PLATA) AS Splata, Sum(F_ORO) AS Soro FROM ENABAL WHERE ((FECHA BETWEEN '$FechaIni' AND '$FechaFin') AND 
			ENABAL.N_FLUJO=40 AND ENABAL.T_MOV=2)";
						
			$resultados = mysql_query($sql);
			while($fila=mysql_fetch_array($resultados))
			{			
				$resultados2 = mysql_query($sqldos);
				while($fila2=mysql_fetch_array($resultados2))
				{													
					$pseco=$fila2[Sseco]-$fila[PESOSECO];
					$fcobre=$fila2[Scobre]-$fila[FINOCOBRE];
					$fplata=$fila2[Splata]-$fila[FINOPLATA];
					$foro=$fila2[Soro]-$fila[FINOORO];
					
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
					echo "<td>".$formato=number_format($pseco,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($fcobre,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($fplata,'0',',','.')."</td>";
					echo "<td>".$formato=number_format($foro,'0',',','.')."</td>";
					echo "</tr>";
					
					if($fila[PESOSECO]==0)
					{
						$uno=0;$dos=0;$tres=0;					
					}else{
						$uno=$fila2[Scobre]/$fila2[Sseco]*100;
						$dos=$fila2[Splata]/$fila2[Sseco]*1000;
						$tres=$fila2[Soro]/$fila2[Sseco]*1000;
					}
				
					echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>";
					echo "<td> LEYES </td>";
					echo "<td>".$english_format_number = number_format($uno, 2, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($dos, 3, ',', '')."</td>";
					echo "<td>".$english_format_number = number_format($tres, 3, ',', '')."</td>";
					echo "</tr>";											    				
	    		}
			}
		}
	?>
        </table>
        <table width="700" border="1" align="center" cellpadding="1" cellspacing="0" class="TablaDetalle">
          <tr align="center" class="ColorTabla01">
             <td>Fecha</td>
            <td width="47">Flujo</td>
            <td width="181">Producto</td>
            <td width="78">Peso Seco (Kg)</td>
            <td width="82">Fino Cobre (Kg)</td>
            <td width="79">Fino Plata (gr)</td>
            <td width="79">Fino Oro (gr)</td>
          </tr>
          <?
		  
		  $FechaIni=$ano."-".$mes."-01";
		  $FechaFin=$ano2."-".$mes2."-01";
	if ($buscarOPT=="S")
	{	  
	
		$consultas=  "SELECT DISTINCT FECHA FROM enabal WHERE  ((ENABAL.T_MOV='2' ) AND (ENABAL.N_FLUJO='40' Or ENABAL.N_FLUJO='77' Or ENABAL.N_FLUJO='144' Or ENABAL.N_FLUJO='139' Or ENABAL.N_FLUJO='249' Or ENABAL.N_FLUJO='376' Or ENABAL.N_FLUJO='257' Or ENABAL.N_FLUJO='88' Or ENABAL.N_FLUJO='150' ) AND (FECHA BETWEEN '$FechaIni' AND '$FechaFin'))";
		$RespFecha = mysql_query($consultas);
				while($FilaFecha=mysql_fetch_array($RespFecha))
					{
						$TotMesPSeco=0;$TotMesFCobre=0;$TotMesFPlata=0;$TotMesFOro=0;
						$consultas= "SELECT FECHA, T_MOV, N_FLUJO, NOM_PRODUCTO, P_SECO, F_COBRE, F_PLATA, F_ORO FROM ENABAL where ((FECHA='$FilaFecha["FECHA"]') AND
									(ENABAL.T_MOV='2') AND (ENABAL.N_FLUJO='40' Or ENABAL.N_FLUJO='77' Or ENABAL.N_FLUJO='144' Or ENABAL.N_FLUJO='139' Or ENABAL.N_FLUJO='249' Or ENABAL.N_FLUJO='376' 
									Or ENABAL.N_FLUJO='257' Or ENABAL.N_FLUJO='88' Or ENABAL.N_FLUJO='150' ))";
			
						$resultados = mysql_query($consultas);
						
						while($codigo=mysql_fetch_array($resultados))
							{
								echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFCC'>";
								
								echo "<td>".$codigo["FECHA"]."</td>";
								echo "<td>".$codigo[N_FLUJO]."</td>";
								echo "<td>".$codigo[NOM_PRODUCTO]."</td>";			
								echo "<td>".$formato=number_format($codigo[P_SECO],'0',',','.')."</td>";
								echo "<td>".$formato=number_format($codigo[F_COBRE],'0',',','.')."</td>";
								echo "<td>".$formato=number_format($codigo[F_PLATA],'0',',','.')."</td>";
								echo "<td>".$formato=number_format($codigo[F_ORO],'0',',','.')."</td>";
								echo "</tr>";
							}
						//SUMA DE OTROS FLUJOS (SE RESTA AL BLISTER TOTAL)
						
						$sql= "SELECT Sum(P_SECO) AS PESOSECO, Sum(F_COBRE) AS FINOCOBRE, Sum(F_PLATA) AS FINOPLATA, Sum(F_ORO) AS FINOORO from ENABAL WHERE ((FECHA='$FilaFecha["FECHA"]') AND 
						(ENABAL.N_FLUJO=77 Or ENABAL.N_FLUJO=144 Or ENABAL.N_FLUJO=139 Or ENABAL.N_FLUJO=249 Or ENABAL.N_FLUJO=376 Or ENABAL.N_FLUJO=257 Or 
						ENABAL.N_FLUJO=88 Or ENABAL.N_FLUJO=150) AND (ENABAL.T_MOV=2))";
				
				
						//BLISTER TOTAL 
						$sqldos="SELECT Sum(P_SECO) AS Sseco, Sum(F_COBRE) AS Scobre, Sum(F_PLATA) AS Splata, Sum(F_ORO) AS Soro FROM ENABAL WHERE ((FECHA='$FilaFecha["FECHA"]') AND 
						ENABAL.N_FLUJO=40 AND ENABAL.T_MOV=2)";
									
						$resultados = mysql_query($sql);
						$resultados2 = mysql_query($sqldos);
							
							while($fila=mysql_fetch_array($resultados))
								{			
								$mfcobre=$fila[FINOCOBRE];
								$mfplata=$fila[FINOPLATA];
								$mforo=$fila[FINOORO];
								}
							while($fila2=mysql_fetch_array($resultados2))
								{													
								$TPseco=$fila2[Sseco];
								$Tcobre=$fila2[Scobre];
								$Tplata=$fila2[Splata];
								$Toro=$fila2[Soro];
								}
								$BPSeco=0;$Bcobre=0;$Bplata=0;$Boro=0;$Lcobre=0;$Lplata=0;$Loro=0;
								$Bcobre=$Tcobre-$mfcobre;		//Blister Neto Cobre
								$Bplata=$Tplata-$mfplata;		//Blister Neto Plata
								$Boro=$Toro-$mforo;				//Blister Neto Oro
								$Lcobre =$Tcobre/$TPseco*100;	//Ley Cobre
								$BPSeco=$Bcobre/$Lcobre*100;	//Blister Neto Peso seco
								$Lplata=$Bplata/$BPSeco*1000;	//Ley Plata
								$Loro=$Boro/$BPSeco*1000;		//Ley Oro
								
								echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFFF'>";
								echo "<td>  </td>";
								echo "<td>  </td>";
								echo "<td  align='right'>BLISTER NETO</td>";
								echo "<td> ".$formato=number_format($BPSeco,'0',',','.')." </td>";			
								echo "<td>".$formato=number_format($Bcobre,'0',',','.')."</td>";
								echo "<td>".$formato=number_format($Bplata,'0',',','.')."</td>";
								echo "<td>".$formato=number_format($Boro,'0',',','.')."</td>";
								echo "</tr>";
								
								echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFFF'>";
								echo "<td>  </td>";
								echo "<td>  </td>";
								echo "<td  align='right'>LEY</td>";
								echo "<td> </td>";			
								echo "<td>".$formato=number_format($Lcobre,'2',',','.')."</td>";
								echo "<td>".$formato=number_format($Lplata,'2',',','.')."</td>";
								echo "<td>".$formato=number_format($Loro,'2',',','.')."</td>";
								echo "</tr>";
								}
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
