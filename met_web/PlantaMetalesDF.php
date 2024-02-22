<?
	$CodigoDeSistema=25;
	$CodigoDePantalla=3;
?>
<html> 
<head>
<title>Datos Finales - Flujos Historicos Fundicion</title>
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
.Estilo1 {color: #FFFFFF}
-->
</style></head>
<script language="javascript">
function Buscar(opt)
{	
	var f=document.form1;
	
	
	switch (opt)
	{
		case "W":
			f.action="PlantaMetalesDF.php?buscarOPT=S" ;
			f.submit();
			break;
		case "E":
			f.action="PlantaMetalesDF_excel.php?buscarOPT=S" ;
			f.submit();
			break;
	}
	
	
}
function Recarga()
{	
	var f=document.form1;
	f.action="PlantaMetalesDF.php?buscarOPT=S&txtflujo="+f.productos.value ;
	f.submit();
}
function Rescatar()
{
	var f=document.form1;
	var Flujo ='';
	Flujo=f.productos.value.split('~');
 	//alert(Flujo[0]);
 	//alert(Flujo[1]);
	f.txtflujo.value=Flujo[0];

	f.TxtNomProd.value=f.productos.options[f.productos.selectedIndex].text;
alert ("N�mero de Flujo s�lo acepta el ingreso de n�meros");
		

}
function Traer()
{
	var f=document.form1;
	var Flujo ='';
	var m ='';
	var t='';
	Flujo=f.cbxproducto.value.split('-');
 	f.txtflujo.value=Flujo[0];
	t=Flujo[2];
    f.select2.options[t-2].selected = true 
	f.TxtNomProd.value=f.cbxproducto.options[f.cbxproducto.selectedIndex].text;

		buscarpro();

}

function Volver(){
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}

</script>
<script language="javascript">
function buscarpro()
{	
	var f=document.form1;
	f.action="PlantaMetalesDF.php?buscarproOPT=S" ;
	f.submit();
}
function buscarproD()
{	
	var f=document.form1;
	
	f.action="PlantaMetalesDF.php?buscarproOPT=S" ;
	f.submit();
	
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
</script>
<body>
<form name="form1" method="post" action="">

<DIV id=popCal style="BORDER-TOP:solid 1px #000000;BORDER-BOTTOM:solid 2px #000000;BORDER-LEFT:solid 1px #000000;
BORDER-RIGHT:solid 2px #000000; VISIBILITY: hidden; POSITION: absolute" onclick=event.cancelBubble=true>
<IFRAME name=popFrame src="popcjs.htm" frameBorder=0 width=160 scrolling=no height=180></IFRAME></DIV>
<?
include("../principal/encabezado.php");
include("conectar.php");
?>
<table width="770" height="330" border="0" class="TablaPrincipal">
  <tr>
    <td align="center" valign="top" class="TablaPrincipal"><p>&nbsp;</p>
      <table width="640" height="164" border="1" align="center" cellpadding="2" cellspacing="0">
        <tr align="center" class="Detalle03">
          <td height="18" colspan="7"><strong>Flujos Historicos Planta de Metales Nobles</strong> </td>
        </tr>
        <tr class="TablaPrincipal">
          <td width="97" height="12">N&uacute;mero de Flujo: </td>
          <td width="96"><p>
                <input name="txtflujo" type="text" id="txtflujo2" size="2" value="<? echo $txtflujo;?>">
</p>
            <td colspan="2" rowspan="2">              <input name="Button" type="submit" id="Button4" value="Buscar Producto" onClick="buscarpro()">          
            <td width="255" colspan="3" rowspan="2"><select name="productos" onChange="Rescatar()" >
                <?
				
		$sql1 = "SELECT DISTINCT NOM_PRODUCTO,N_FLUJO FROM enabalpmn ";
		if($txtflujo!='')
		//$sql1.= "where N_FLUJO='".$txtflujo."'";
		$sql1.= "where N_FLUJO='".$txtflujo."' and t_mov='".$select2."'";
		$resultados = mysql_query($sql1);
		while($columna=mysql_fetch_array($resultados))
		{
			if($productos==$columna[N_FLUJO]."~".$columna[NOM_PRODUCTO])
			{
				echo "<option value='".$columna[N_FLUJO]."~".$columna[NOM_PRODUCTO]."'selected>".$columna[NOM_PRODUCTO]."</option>";
				$TxtNomProd=$columna[NOM_PRODUCTO];
			}	
			else
				echo "<option value='".$columna[N_FLUJO]."~".$columna[NOM_PRODUCTO]."'>".$columna[NOM_PRODUCTO]."</option>";
		}
	?>
              </select>
            <input name="TxtNomProd" type="hidden" value="<? echo $TxtNomProd;?>"></td>
        </tr>
        <tr class="TablaPrincipal">
          <td height="12">Tipo Movimiento: </td>
          <td><select name="select2" size="1">
            <?
	switch ($select2)
	{
		case '2':
			echo "<option selected>2</option>\n";
            echo "<option>3</option>\n";
			break;
		case '3':
			echo "<option>2</option>\n";
            echo "<option selected>3</option>\n";
			break;
		default:
			echo "<option selected>2</option>\n";
            echo "<option>3</option>\n";
			break;
	}
?>
          </select>          </tr>
        
          <tr class="TablaPrincipal">
            <td height="26" align="center"><div align="left">Buscar:</div></td>
            <td height="26" colspan="6" align="center"><div align="left">
                <input name="txtproducto" type="text" id="txtproducto6" size="20" value="<? echo $txtproducto;?>">
                <input name="ButtonT" type="submit" id="ButtonT6" value="Buscar" onClick="buscarproD()">
            <select name="cbxproducto"  onChange="Traer()">
                  <option value="S">Flujo | Mov. | Descripcion</option>
                  <?
		$sql1 = "SELECT DISTINCT N_FLUJO, NOM_PRODUCTO, T_MOV FROM enabalpmn WHERE (NOM_PRODUCTO LIKE '$txtproducto%') ORDER BY NOM_PRODUCTO";
	
		
		$resultados = mysql_query($sql1);
		while($Fila=mysql_fetch_array($resultados))
			{		
				echo "<option value='".$Fila[N_FLUJO]."-".$Fila[NOM_PRODUCTO]."-".$Fila[T_MOV]."'>  " .str_pad($Fila[N_FLUJO],3,'0',STR_PAD_LEFT)." - ".$Fila[T_MOV]." - ".$Fila[NOM_PRODUCTO]."</option>";
			
			}	
		
		
	?>
                </select>
              </div>              </td>
          </tr>
          <tr class="TablaPrincipal">
            <td height="26" colspan="3" align="center"><div align="left"><font size="2">Desde: 
                    <select name="mes" size="1" id="select3" style="FONT-FACE:verdana;FONT-SIZE:10">
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
                  <font size="2">
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
                    </font></font>                                             </div></td>
            <td height="26" colspan="4" align="center"><div align="left">Hasta:<font color="#000000" size="2">
              <select name="mes2" size="1" id="select6" style="FONT-FACE:verdana;FONT-SIZE:10">
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
              <select name="ano2" size="1" class="TablaPrincipal2"  style="FONT-FACE:verdana;FONT-SIZE:10">
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
            </font><font color="#000000" size="2">            </font>            </div></td>
          </tr>
          <tr class="TablaPrincipal">
            <td height="26" colspan="7" align="center">&nbsp;              </td>
        </tr>
          <tr class="TablaPrincipal">
            <td height="26" colspan="7" align="center"><input name="BtnBusca" type="button" id="BtnBusca2" onClick="Buscar('W')" value="Buscar">
              <input name="BtnImpri" type="submit" id="BtnImpri" value="Imprimir" onClick="imprimir()">
              <input name="BtnPlan" type="submit" id="BtnPlan" value="PlanillaExcel" onClick="Buscar('E')">
              <input name="BtnVol" type="submit" id="BtnVol2" style="width:70px " onClick="Volver()" value="Volver"></td>
          </tr>  
        <?
	
	if ($buscarproOPT=="S")
	{
		$sql = "SELECT NOM_PRODUCTO FROM enabalpmn where N_FLUJO='$txtflujo'"; 
		$resultados = mysql_query($sql);
		if($columna=mysql_fetch_array($resultados))
		{
			//echo "<option name=productos selected>".$columna[NOM_PRODUCTO]."</option>";
		}
	}	
	?>
        <br>
        <br>
      </table>
        <p>&nbsp;</p>        
        <table width="484" border="1" align="center" class="TablaDetalle">
          <tr class="ColorTabla01">
            <td width="105">Peso Seco (Kg) </td>
            <td width="123">Fino Cobre (Kg) </td>
            <td width="128">Fino Plata (gr) </td>
            <td width="100">Fino Oro (gr)  </td>
          </tr>
          <?
		  
	if ($buscarOPT=="S")
		{		  
				  $FechaIni=$ano."-".$mes."-01";
				  $FechaFin=$ano2."-".$mes2."-01";
	
		$sql = "SELECT SUM(P_SECO) as PESOSECO, SUM(F_COBRE) as FINOCOBRE, SUM(F_PLATA) as FINOPLATA, SUM(F_ORO) as FINORO FROM enabalpmn where ((N_FLUJO='$txtflujo') AND (NOM_PRODUCTO='$TxtNomProd') AND (T_MOV='$select2') AND (FECHA BETWEEN '$FechaIni' and '$FechaFin'))"; 
		
		$resultados = mysql_query($sql);
		while($linea=mysql_fetch_array($resultados))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
			echo "<td>".$formato=number_format($linea[PESOSECO],0,',','.')."</td>";
		    echo "<td>".$formato=number_format($linea[FINOCOBRE],0,',','.')."</td>";
			echo "<td>".$formato=number_format($linea[FINOPLATA],0,',','.')."</td>";
			echo "<td>".$formato=number_format($linea[FINORO],0,',','.')."</td>";
			echo "</tr>";
			if($linea[PESOSECO]==0)
			{
				$uno=0;$dos=0;$tres=0;					
			}
			else
			{
				$uno=$linea[FINOCOBRE]/$linea[PESOSECO]*100;
				$dos=$linea[FINOPLATA]/$linea[PESOSECO]*1000;
				$tres=$linea[FINORO]/$linea[PESOSECO]*1000;
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
        </table>
        <br>
        <table width="578" border="1" align="center" class="TablaDetalle">
          <tr align="center" class="ColorTabla01">
            <td width="135">Fecha</td>
            <td width="107">Peso Seco (Kg) </td>
            <td width="114">Fino Cobre (Kg) </td>
            <td width="94">Fino Plata (gr) </td>
            <td width="94">Fino Oro (gr) </td>
          </tr>
          <?
	if ($buscarOPT=="S")
	{
				  $FechaIni=$ano."-".$mes."-01";
				  $FechaFin=$ano2."-".$mes2."-01";
	
		$sql = "SELECT * FROM enabalpmn where N_FLUJO='$txtflujo' AND  T_MOV='$select2' and NOM_PRODUCTO='$TxtNomProd' and FECHA BETWEEN ' $FechaIni' and '$FechaFin' ORDER BY FECHA"; 	
		$resultados = mysql_query($sql);
		while($fila=mysql_fetch_array($resultados))
		{
			echo "<tr bordercolor='#FFCC00' bgcolor='#FFFFEA' align='center'>" ;
			echo "<td>".substr($fila[FECHA],0,7)."</td>";				
			echo "<td>".$formato=number_format ($fila[P_SECO],'0',',','.')."</td>";
			echo "<td>".$formato=number_format ($fila[F_COBRE],'0',',','.')."</td>";
			echo "<td>".$formato=number_format ($fila[F_PLATA],'0',',','.')."</td>";
			echo "<td>".$formato=number_format ($fila[F_ORO],'0',',','.')."</td>";
			echo "</tr>";
			
		      }
		 }
	
	?>
      </table></td>
  </tr>
</table>
<p class="NoSelec">&nbsp;</p>
</form>
<?
	include("cerrarconexion.php");
	include("../principal/pie_pagina.php");
?>
</body>
</html>
