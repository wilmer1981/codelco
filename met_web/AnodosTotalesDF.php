<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
<title>Datos Finales - Anodos Totales</title>
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
	<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
</head>
<script language="javascript">
function Buscar(opt)
{	
	var f=document.form1;
/*
	if(f.txtfecha6.value=='')
	{
		alert ("Debe ingresar fecha de inicio");
		f.txtfecha6.focus();
		return false;
	}
	if(f.txtfecha7.value=='')
	{
		alert ("Debe ingresar fecha final");
		f.txtfecha7.focus();
		return false;
	}			
	*/
	switch (opt)
	{
		case "W":
			f.action="AnodosTotalesDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="AnodosTotalesDF_excel.php?buscarOPT=S" ;
			f.submit();
			break;
	}
	
	
}
function imprimir()
{
	var f=document.form1;
		f.BtnBusca.style.visibility='hidden';
		f.BtnImpri.style.visibility='hidden';
		f.BtnPlan.style.visibility='hidden';
		f.BtnVol.style.visibility='hidden';
		window.print();
		f.BtnBusca.style.visibility='';
		f.BtnImpri.style.visibility='';
		f.BtnPlan.style.visibility='';
		f.BtnVol.style.visibility='';
}
function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}


</script>
<body>
<form name="form1" method="post" action="">
<?
	include("../principal/encabezado.php");
	include("conectar.php");
?>

<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>


<table width="770" border="0" class="TablaPrincipal">
  <tr>
    <td width="920" height="100" valign="top">
      <table width="492" border="1" align="center">
        <tr align="center" class="Detalle03">
          <td colspan="2"><strong>Anodos Totales </strong></td>
        </tr>
        <tr>
          <td width="280" align="center">Desde: <font color="#000000" size="2">
            <select name="mes" size="1" id="select" style="FONT-FACE:verdana;FONT-SIZE:10">
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
                if ($i==date("n"))
				{				
				echo "<option selected value ='".$i."'>".$meses[$i-1]." </option>";
				echo"alert(".$mes.")";
				}			
				else
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
          </font> </td>
          <td width="289"><div align="center">Hasta: <font color="#000000" size="2">
              <select name="mes2" size="1" id="select2" style="FONT-FACE:verdana;FONT-SIZE:10">
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
          </font> </div></td>
        </tr>
      </table>
      <br>
      <table width="433" border="0" align="center">
        <tr>
          <td align="center"><input name="BtnBusca" type="button" id="BtnBusca" onClick="Buscar('W')"  value="Buscar">
              <input name="BtnImpri" type="button"   value="Imprimir" onClick="imprimir()">
              <input name="BtnPlan" type="button" id="BtnPlan" onClick="Buscar('E')"  value="Planilla Excel">
              <input name="BtnVol" type="button" id="BtnVol" style="width:70px " onClick="Volver()" value="Volver"></td>
        </tr>
      </table>     
	  <br>
	  
	  <table width="734" height="41" border="1" align="center" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td width="132"><center>PESO SECO (Kg)</center></td>
          <td width="136">FINO COBRE (Kg)</td>
          <td width="150">FINO PLATA (gr)</td>
          <td width="133">FINO ORO (gr)</td>
          <?
		  $FechaIni=$ano."-".$mes."-01";
		  $FechaFin=$ano2."-".$mes2."-01";
		  if ($buscarOPT=="S")
		  {
		  							
					$consult= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINOORO FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND (FECHA BETWEEN '$FechaIni' AND '$FechaFin'))";
					$resultados = mysql_query($consult);
					while($linea=mysql_fetch_array($resultados))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$formato=number_format($linea[PESOSECO],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($linea[FINOCOBRE],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($linea[FINOPLATA],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($linea[FINOORO],'0',',','.')."</td>";
						echo "</tr>";						
					
						if($linea[PESOSECO]==0)
						{
							$uno=0;$dos=0;$tres=0; 
						}else{
							$uno=$linea[FINOCOBRE]/$linea[PESOSECO]*100;
							$dos=$linea[FINOPLATA]/$linea[PESOSECO]*1000;
							$tres=$linea[FINOORO]/$linea[PESOSECO]*1000;
						}
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>LEY</td>";
						echo "<td>".$english_format_number = number_format($uno, 2, ',', '')."</td>";
						echo "<td>".$english_format_number = number_format($dos, 3, ',', '')."</td>";
						echo "<td>".$english_format_number = number_format($tres, 3, ',', '')."</td>";
						echo "</tr>";
					}
		}
		  
		  ?>
        </tr>
      </table>
	  <br>
	  <br>	  <table width="734" height="62" border="1" align="center" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td colspan="8"><div align="center">POR FECHA </div></td>
        </tr>
        <tr align="center" class="ColorTabla01">
          <td width="121" align="center" ><div align="center">Fecha</div></td>
          <td width="163"><div align="center">Peso Seco (Kg) </div></td>
          <td width="157"><div align="center">Fino Cobre (Kg) </div></td>
          <td width="124"><div align="center">Fino Plata (gr) </div></td>
          <td width="134"><div align="center">Fino Oro (gr) </div></td>
		  <? 
		  $FechaIni=$ano."-".$mes."-01";
		  $FechaFin=$ano2."-".$mes2."-01";
		
		  if ($buscarOPT=="S")
		  {			
				$consultas= "SELECT FECHA, SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO  FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND (FECHA BETWEEN '$FechaIni' AND '$FechaFin' )) GROUP BY FECHA";
				
					
					//$consultas= "SELECT * FROM enabal WHERE ((T_MOV='2') AND (N_FLUJO='92' OR N_FLUJO='93' OR N_FLUJO='95' OR N_FLUJO='99' OR N_FLUJO='129' OR N_FLUJO='131') AND FECHA ='$FilaFecha[FECHA]')";
					$resultados = mysql_query($consultas);
					while($codigo=mysql_fetch_array($resultados))
					{
							echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
							echo "<td>".$codigo[FECHA]."</td>";
							echo "<td>".$formato=number_format($codigo[PESOSECO],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[FINOCOBRE],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[FINOPLATA],'0',',','.')."</td>";
							echo "<td>".$formato=number_format($codigo[FINORO],'0',',','.')."</td>";
							echo "</tr>";
							echo"<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>";
							echo"</tr>";
					}
					
					
					
		}	
		  
		
		  ?>
        </tr>
  </table>
	  <br>    </td>
  </tr>
</table>
<?
	include("cerrarconexion.php");
	include("../principal/pie_pagina.php");
?>
</form>
</body>
</html>

