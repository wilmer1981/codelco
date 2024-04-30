<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html>
<head>
<title>Datos Base - Anodos Rechazados</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
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
	}*/		
			
	switch (opt)
	{
		case "W":
			f.action="AnodosRechazadosDB.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="AnodosRechazadosDB_excel.php?buscarOPT=S" ;
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
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=1';
	f.submit();	
}

</script>
<body>
<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<form name="form1" method="post" action="">
<?
	include("../principal/encabezado.php");
	include("conectar.php");
?>
  <table width="770" height="330" border="0" class="TablaPrincipal">
  <tr>
    <td width="911" align="center" valign="top">
      <table width="488" border="1">
        <tr align="center" class="Detalle03">
          <td colspan="2"><strong>Anodos Rechazados </strong></td>
        </tr>
        <tr>
          <td width="257"><div align="center">Desde:
              <font color="#000000" size="2">
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
</font>                </div></td>
          <td width="215"><div align="center">Hasta: <font color="#000000" size="2">
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
</font> </div></td>
          </tr>
        <tr>
          <td colspan="2"><div align="center">
                <input name="BtnBusca" type="button" id="BtnBusca" onClick="Buscar('W')"  value="Buscar">            
                <input name="BtnImpri" type="button"  value="Imprimir" onClick="imprimir()">            
                <input name="BtnPlan" type="button" id="BtnPlan" onClick="Buscar('E')"  value="Planilla Excel">            
                <input name="BtnVol" type="submit" id="BtnVol" style="width:70px " onClick="Volver()" value="Volver">
          </div></td>
          </tr>
      </table>
	  <br>
	  <br>
	  
	  <table width="571" border="1" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td colspan="4">ANODOS RECHAZADOS </td>
        </tr>
        <tr class="ColorTabla01">
          <td width="132">PESO SECO (Kg) </td>
          <td width="136">FINO COBRE (Kg) </td>
          <td width="131">FINO PLATA (gr) </td>
          <td width="144">FINO ORO (gr) </td>
		  
		  <?
		  if ($buscarOPT=="S")
		  {
					$FechaIni=$ano."-".$mes."-01";
					$FechaFin=$ano2."-".$mes2."-01";
					$consultar= "SELECT SUM(P_SECO) AS PESOSECO, SUM(F_COBRE) AS FINOCOBRE,SUM(F_PLATA) AS FINOPLATA, SUM(F_ORO) AS FINORO FROM enabal_base WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin') ORDER BY N_FLUJO";
					$resultados = mysql_query($consultar);
					if($lineas=mysql_fetch_array($resultados))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$formato=number_format($lineas[PESOSECO],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($lineas[FINOCOBRE],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($lineas[FINOPLATA],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($lineas[FINORO],'0',',','.')."</td>";
						echo "</tr>";
						if($lineas[PESOSECO]==0)
							{
								$uno=0;$dos=0;$tres=0;				
							}
						else
							{
								$uno=$lineas[FINOCOBRE]/$lineas[PESOSECO]*100;
								$dos=$lineas[FINOPLATA]/$lineas[PESOSECO]*1000;
								$tres=$lineas[FINORO]/$lineas[PESOSECO]*1000;						
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
	  <br>
	  <table width="700" border="1" class="TablaDetalle">
        <tr align="center" class="ColorTabla01">
          <td width="140">Fecha</td>
          <td width="35">Flujo </td>
          <td width="293">Nombre Producto </td>
          <td width="82">Peso Seco (Kg) </td>
          <td width="96">Fino Cobre (Kg) </td>
          <td width="85">Fino Plata (gr) </td>
          <td width="84">Fino Oro (gr)</td>
		  <?
		  if ($buscarOPT=="S")
		  {
				$FechaIni=$ano."-".$mes."-01";
				$FehchaFin=$ano2."-".$mes2."-01";
				$consultas= "SELECT * FROM enabal_base WHERE ((T_MOV='2') AND (N_FLUJO='404' OR N_FLUJO='402' OR N_FLUJO='145') AND FECHA BETWEEN '$FechaIni' AND '$FechaFin')";
				$resultados = mysql_query($consultas);
				while($codigo=mysql_fetch_array($resultados))
					{
						echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
						echo "<td>".$codigo["FECHA"]."</td>";
						echo "<td>".$codigo[N_FLUJO]."</td>";
						echo "<td>".$codigo[NOM_PRODUCTO]."</td>";
						echo "<td>".$formato=number_format($codigo[P_SECO],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($codigo[F_COBRE],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($codigo[F_PLATA],'0',',','.')."</td>";
						echo "<td>".$formato=number_format($codigo[F_ORO],'0',',','.')."</td>";
						echo "</tr>";
				}
		  }
		  ?>
        </tr>
      </table>
	  <br>
  </table>
	<?
		include("cerrarconexion.php");
		include("../principal/pie_pagina.php");
	?>
</form>
    </td>
  </tr>


</body>
</html>
