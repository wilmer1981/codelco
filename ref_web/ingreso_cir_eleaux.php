<?php
    $CodigoDeSistema = 10;
	$CodigoDePantalla = 16;
	
	include("../principal/conectar_ref_web.php");

	$fecha     = isset($_REQUEST["fecha"])?$_REQUEST["fecha"]:"";
	$dia1      = isset($_REQUEST["dia1"])?$_REQUEST["dia1"]:date("d");
	$mes1      = isset($_REQUEST["mes1"])?$_REQUEST["mes1"]:date("m");
	$ano1      = isset($_REQUEST["ano1"])?$_REQUEST["ano1"]:date("Y");

	if (isset($fecha))
	{
		$dia1 = intval(substr($fecha,8,2));
		$mes1 = intval(substr($fecha,5,2));
		$ano1 = intval(substr($fecha,0,4));
	}
	
?>
<html>
<head>
<title>Ingresos Jefe Turno</title>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ValorCheckBox(f)
{
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			return f.checkbox[i].value;
	}
}
/*****************/

function SeleccionarTodos(f)
{
	try{	
		if (f.checkbox[0].checked == true)
			valor = true
		else valor = false;

		for(i=1; i<f.checkbox.length; i++)	
			f.checkbox[i].checked = valor;
	}catch(e){
	}
}
/************************/
function ValoresChequeados(f)
{
	valores = "";
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			valores = valores + f.checkbox[i].value + '~';
	}
	return valores;
}
/************************/

function CantidadChecheado(f)
{
	cont = 0;
	for(i=1; i<f.checkbox.length; i++)	
	{
		if (f.checkbox[i].checked)
			cont++;
	}	
	return cont;
}
/*****************/
function Proceso(f,opc)
{
   
	linea = "opcion=" + opc;

	if (opc == '1')
	    window.open("ingreso_h2so4.php?"+linea,"","top=150,left=180,width=525,height=400,scrollbars=no,resizable = no");

	if (opc == '2')
	    window.open("ingreso_desc_parcial.php?"+linea,"","top=150,left=180,width=525,height=400,scrollbars=no,resizable = no");

	if (opc == '3')
	    window.open("ingreso_electrolito.php?"+linea,"","top=150,left=180,width=535,height=400,scrollbars=no,resizable = no");
		
	if (opc == '4')
	    window.open("ingreso_pte.php?"+linea,"","top=150,left=5,width=765,height=290,scrollbars=no,resizable = no");
			
}
/*****************/
function Proceso2(f,opc)
{

	var cantidad = 0;
	var valores	= "";
	var fecha = "";
	var AnoAux = f.ano1.value;
	var MesAux = "";
	var DiaAux = "";
	if (f.mes1.value <10)
		MesAux = "0"+f.mes1.value;
	else
		MesAux = f.mes1.value;
	if (f.dia1.value <10)
		DiaAux = "0"+f.dia1.value;
	else
		DiaAux = f.dia1.value;
	fecha = AnoAux+"-"+MesAux+"-"+DiaAux;

	if (opc == 'M')
	{
		for (i=1;i<f.elements.length;i++)
		{
			if ((f.elements[i].name = 'Chk01') && (f.elements[i].checked))
			{
				cantidad++;
				valores = f.elements[i].value;
			}
		}
		if (cantidad == 0)
		{
			alert("Seleccione una Casilla Para Modificar los Datos");
			return;
		}
		if (cantidad > 1)
		{
			alert("");
			return;
			
		}
		window.open("popup_h2so4.php?" + valores+"&txt_fecha="+fecha,"","top=195,left=160,width=440,height=166,scrollbars=no,resizable = no");
	}	
			
}
/*****************/
function Eliminar2(f)
{

	var cantidad = 0;
	var valores	= "";
	var fecha = "";
	var AnoAux = f.ano1.value;
	var MesAux = "";
	var DiaAux = "";
	if (f.mes1.value <10)
		MesAux = "0"+f.mes1.value;
	else
		MesAux = f.mes1.value;
	if (f.dia1.value <10)
		DiaAux = "0"+f.dia1.value;
	else
		DiaAux = f.dia1.value;
	fecha = AnoAux+"-"+MesAux+"-"+DiaAux;

	//if (opc == 'M')
	//{
		for (i=1;i<f.elements.length;i++)
		{
			if ((f.elements[i].name = 'Chk01') && (f.elements[i].checked))
			{
				cantidad++;
				valores = f.elements[i].value;
			}
		}
		if (cantidad == 0)
		{
			alert("Seleccione una Casilla para Eliminar los Datos");
			return;
		}
		
		else
	    
		{
			if (confirm("Esta Seguro de Eliminar los Datos Seleccionados"))
			{
				f.action = "proceso_h2so4.php?proceso=E&" + valores+"&txt_fecha="+fecha;
				f.submit();
			}
		}
		/*if (cantidad > 1)
		{
			alert("Datos Eliminados Correctamente");
			return;
			
		}*/
		//window.open("popup_h2so4.php?" + valores+"&txt_fecha="+fecha,"","top=195,left=160,width=440,height=166,scrollbars=no,resizable = no");
	//}	
			
}
/*****************/






/*{
    var cantidad = 0;
	var valores	= "";
	var fecha = "";
	var AnoAux = f.ano1.value;
	var MesAux = "";
	var DiaAux = "";
	if (f.mes1.value <10)
		MesAux = "0"+f.mes1.value;
	else
		MesAux = f.mes1.value;
	if (f.dia1.value <10)
		DiaAux = "0"+f.dia1.value;
	else
		DiaAux = f.dia1.value;
	fecha = AnoAux+"-"+MesAux+"-"+DiaAux;           

	var valores = ValoresChequeados(f);
	valores = valores.substr(0,valores.length-1);

	
	if (valores == "")	
	{
		alert("No Hay Casillas Seleccionadas");
		return;
	}
	else
	{
		if (confirm("Esta Seguro de Eliminar los Grupos Seleccionados"))
		{
			f.action = "proceso_h2so4.php?proceso=E&parametros=" + valores;
			f.submit();
		}
	}
}
*/
function Proceso3(f,opc)
{
	var cantidad = 0;
	var valores	= "";
	
	var cantidad = 0;
	var valores	= "";
	var fecha = "";
	var AnoAux = f.ano1.value;
	var MesAux = "";
	var DiaAux = "";
	if (f.mes1.value <10)
		MesAux = "0"+f.mes1.value;
	else
		MesAux = f.mes1.value;
	if (f.dia1.value <10)
		DiaAux = "0"+f.dia1.value;
	else
		DiaAux = f.dia1.value;
	fecha = AnoAux+"-"+MesAux+"-"+DiaAux;
	if (opc == 'M')
	{
		for (i=1;i<f.elements.length;i++)
		{
			if ((f.elements[i].name = 'Chk02') && (f.elements[i].checked))
			{
				cantidad++;
				valores = f.elements[i].value;
			}
		}
		if (cantidad == 0)
		{
			alert("Seleccione una Casilla para Modificar los Datos");
			return;
		}
		if (cantidad > 1)
		{
			alert("Tiene mas de un Casilla seleccionada");
			return;
		}
		window.open("popup_desc_parcial.php?"+ valores+"&txt_fecha="+fecha,"","top=195,left=160,width=440,height=166,scrollbars=no,resizable = no");
	}	
			
}
/*****************/

function Eliminar3(f)
{

	var cantidad = 0;
	var valores	= "";
	var fecha = "";
	var AnoAux = f.ano1.value;
	var MesAux = "";
	var DiaAux = "";
	if (f.mes1.value <10)
		MesAux = "0"+f.mes1.value;
	else
		MesAux = f.mes1.value;
	if (f.dia1.value <10)
		DiaAux = "0"+f.dia1.value;
	else
		DiaAux = f.dia1.value;
	fecha = AnoAux+"-"+MesAux+"-"+DiaAux;

	//if (opc == 'M')
	//{
		for (i=1;i<f.elements.length;i++)
		{
			if ((f.elements[i].name = 'Chk02') && (f.elements[i].checked))
			{
				cantidad++;
				valores = f.elements[i].value;
			}
		}
		if (cantidad == 0)
		{
			alert("Seleccione una Casilla para Eliminar los Datos");
			return;
		}
		
		else
	    
		{
			if (confirm("Esta Seguro de Eliminar los Datos Seleccionados"))
			{
				f.action = "proceso_dp.php?proceso=E&" + valores+"&txt_fecha="+fecha;
				f.submit();
			}
		}
		/*if (cantidad > 1)
		{
			alert("Datos Eliminados Correctamente");
			return;
			
		}*/
		//window.open("popup_h2so4.php?" + valores+"&txt_fecha="+fecha,"","top=195,left=160,width=440,height=166,scrollbars=no,resizable = no");
	//}	
			
}
/*****************/





/*{
	var valores = ValoresChequeados(f);
	valores = valores.substr(0,valores.length-1);

	
	if (valores == "")	
	{
		alert("No Hay Casillas Seleccionadas");
		return;
	}
	else
	{
		if (confirm("Esta Seguro de Eliminar los Grupos Seleccionados"))
		{
			f.action = "proceso_h2so4.php?proceso=E&parametros=" + valores;
			f.submit();
		}
	}
}
*/
function Proceso4(f,opc)
{
    var cantidad = 0;
	var valores	= "";
	var fecha = "";
	var AnoAux = f.ano1.value;
	var MesAux = "";
	var DiaAux = "";
	if (f.mes1.value <10)
		MesAux = "0"+f.mes1.value;
	else
		MesAux = f.mes1.value;
	if (f.dia1.value <10)
		DiaAux = "0"+f.dia1.value;
	else
		DiaAux = f.dia1.value;
	fecha = AnoAux+"-"+MesAux+"-"+DiaAux;

    if (opc == 'M')
	{
		for (i=1;i<f.elements.length;i++)
		{
			if ((f.elements[i].name = 'Chk03') && (f.elements[i].checked))
			{
				cantidad++;
				valores = f.elements[i].value;
			}
		}
		if (cantidad == 0)
		{
			alert("Seleccione una Casilla Para Modificar los Datos");
			return;
		}
		if (cantidad > 1)
		{
			alert("Tiene mas de una Casilla Seleccionada");
			return;
		}
		window.open("popup_electrolito.php?" + valores+"&fecha="+fecha,"","top=195,left=160,width=440,height=210,scrollbars=no,resizable = no");
	}	
			
}
/*****************/

function Eliminar4(f)
{

	var cantidad = 0;
	var valores	= "";
	var fecha = "";
	var AnoAux = f.ano1.value;
	var MesAux = "";
	var DiaAux = "";
	if (f.mes1.value <10)
		MesAux = "0"+f.mes1.value;
	else
		MesAux = f.mes1.value;
	if (f.dia1.value <10)
		DiaAux = "0"+f.dia1.value;
	else
		DiaAux = f.dia1.value;
	fecha = AnoAux+"-"+MesAux+"-"+DiaAux;

	//if (opc == 'M')
	//{
		for (i=1;i<f.elements.length;i++)
		{
			if ((f.elements[i].name = 'Chk01') && (f.elements[i].checked))
			{
				cantidad++;
				valores = f.elements[i].value;
			}
		}
		if (cantidad == 0)
		{
			alert("Seleccione una Casilla para Eliminar los Datos");
			return;
		}
		
		else
	    
		{
			if (confirm("Esta Seguro de Eliminar los Datos Seleccionados"))
			{
				f.action = "proceso_electrolito.php?proceso=E&" + valores+"&txt_fecha="+fecha;
				f.submit();
			}
		}
		/*if (cantidad > 1)
		{
			alert("Datos Eliminados Correctamente");
			return;
			
		}*/
		//window.open("popup_h2so4.php?" + valores+"&txt_fecha="+fecha,"","top=195,left=160,width=440,height=166,scrollbars=no,resizable = no");
	//}	
			
}
/*****************/





/*{
	var valores = ValoresChequeados(f);
	valores = valores.substr(0,valores.length-1);

	
	if (valores == "")	
	{
		alert("No Hay Casillas Seleccionadas");
		return;
	}
	else
	{
		if (confirm("Esta Seguro de Eliminar los Grupos Seleccionados"))
		{
			f.action = "proceso_h2so4.php?proceso=E&parametros=" + valores;
			f.submit();
		}
	}
}
*/
function Buscar()
{
	var f = document.frmPrincipal;
	f.action = 'ingreso_cir_eleaux.php?mostrar=S';

	f.submit();
}
/**********/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10&Nivel=1&CodPantalla=11";
}
/**********/
</script></head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php")?>
<?php

?>  
  <table width="770" height="158" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">


          <table width="734" border="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td><font face="Arial, Helvetica, sans-serif">Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              </font><font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif"> 
              <select name="dia1" size="1" >
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{
						if (isset($dia1))
						{
							if ($i == $dia1)
								echo '<option selected value="'.$i.'">'.$i.'</option>';	
							else	
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
						else
						{
							if ($i == date("j"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';	
							else	
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
					}
				?>
              </select>
              <select name="mes1" size="1" id="select2">
                <?php
					for($i=1;$i<13;$i++)
					{ 
						if (isset($mes1))
						{
							if ($i == $mes1)
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';	
							else	
								echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
						}
						else
						{
							if ($i == date("n"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';	
							else	
								echo '<option value="'.$i.'">'.$meses[$i-1].'</option>';
						}
					}
				?>
              </select>
              <select name="ano1" size="1" id="select3">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (isset($ano1))
						{
							if ($i == $ano1)
								echo '<option selected value="'.$i.'">'.$i.'</option>';	
							else	
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
						else
						{
							if ($i == date("Y"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';	
							else	
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
					}
				?>
              </select>
              </font><font face="Arial, Helvetica, sans-serif">&nbsp; </font> 
              <font face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
            <td width="110"><font face="Arial, Helvetica, sans-serif">
			 
              <input name="btnbuscar" type="button" value="Buscar" style="width:70" title="Busca datos segun fecha"  onClick="Buscar()">
              </font></td>
          </tr>
        </table>


	  

        <br>
        <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="103" height="18" align="left"> <div align="left"></div>
              <div align="left"> </div>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"><font face="Arial, Helvetica, sans-serif"> </font></div>
              <div align="center"></div>
              <div align="center"></div></td>
            <td colspan="3" align="center"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FFFFFF">&nbsp;&nbsp;AGREGADOS&nbsp; 
                H2SO4&nbsp; A &nbsp;CIRCUITOS</font></div></td>
          </tr>
          <tr class="ColorTabla01"> 
            <td height="21" align="left">&nbsp; </td>
            <td width="193" align="left">Turno</td>
            <td width="266" align="left">Circuito</td>
            <td width="165" align="left">Volumen</td>
          </tr>
        </table>
        <table width="730" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php
				if (strlen($dia1==1))
	   				$dia1='0'.$dia1;
				if (strlen($mes1==1))
	    			$mes1='0'.$mes1; 


			$fecha=$ano1."-".$mes1."-".$dia1;
    		if ($mostrar == "S")
			{
        			$consulta="select turno,circuito_h2so4,volumen_h2so4 from ref_web.electrolito where fecha='".$fecha."'";	
					$rs = mysqli_query($link, $consulta);
					while ($row = mysqli_fetch_array($rs))
					{
		    			//$consulta2="select turno,circuito_dp,volumen_dp from ref_web.desc_parcial where fecha='".$fecha."' and turno='".$row["turno"]."' ";	
						//$rs2=mysqli_query($link, $consulta2);
						//$row2 = mysqli_fetch_array($rs2);
						echo '<tr>';
						echo '<td width="63" height="25">';
						echo '<input type="checkbox" name="Chk01" value="Proceso=M&Turno='.$row["turno"].'&Circuito='.$row["circuito_h2so4"].'&Volumen='.$row["volumen_h2so4"].'"></td>';
		    			echo '<td width="200" align="center">'.$row["turno"].'</td>';
						echo '<td width="370" align="center">'.$row["circuito_h2so4"].'</td>';
						echo '<td width="400" align="center">'.$row["volumen_h2so4"].'</td>';
					}
		 				//header("Location:ingreso_cir_ele.php?m");
			}
?>
</table>				<p>&nbsp; </p>

        		<table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
  						<tr>
  		         				<td align="center"> <input name="btningresosh2so4" type="button" value="Nuevo H2SO4" style="width:120" onClick="Proceso(this.form,'1')">
        				     					    <input name="btnmodificar" type="button" id="btnmodificar" value="Modificar" style="width:70" onClick="Proceso2(this.form,'M')">
             										<input name="btneliminar" type="button" id="btneliminar" value="Eliminar"style="width:70"  onClick="Eliminar2(this.form)"> 
            </td>
	  					</tr>
				</table>
        		<p>&nbsp;</p>
         
        <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="103" height="21" align="left"> 
              <div align="left"></div>
              <div align="left"> </div>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"><font face="Arial, Helvetica, sans-serif"> </font></div>
              <div align="center"></div>
              <div align="center"></div></td>
            <td colspan="3" align="left"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ENVIO 
                A DESCOBIZACION &nbsp;PARCIAL </div></td>
          </tr>
          <tr class="ColorTabla01"> 
            <td height="21" align="left">&nbsp;</td>
            <td width="189" align="left">Turno</td>
            <td width="269" align="left">Circuito</td>
            <td width="166" align="left">Volumen</td>
          </tr>
        </table>
        <table width="730" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php
				if (strlen($dia1==1))
	   				$dia1='0'.$dia1;
				if (strlen($mes1==1))
	    			$mes1='0'.$mes1; 


			$fecha=$ano1."-".$mes1."-".$dia1;
    		if ($mostrar == "S")
			{
        				$consulta="select turno,circuito_dp,volumen_dp from ref_web.desc_parcial where fecha='".$fecha."'";	
						$rs = mysqli_query($link, $consulta);
						while ($row = mysqli_fetch_array($rs))
					{
		    			//$consulta2="select turno,circuito_dp,volumen_dp from ref_web.desc_parcial where fecha='".$fecha."' and turno='".$row["turno"]."' ";	
						//$rs2=mysqli_query($link, $consulta2);
						//$row2 = mysqli_fetch_array($rs2);
						echo '<tr>';
						echo '<td width="63" height="25">';
						echo '<input type="checkbox" name="Chk02" value="Proceso=M&Turno='.$row["turno"].'&Circuito='.$row["circuito_dp"].'&Volumen='.$row["volumen_dp"].'"></td>';
		    			echo '<td width="200" align="center">'.$row["turno"].'</td>';
						echo '<td width="370" align="center">'.$row["circuito_dp"].'</td>';
						echo '<td width="400" align="center">'.$row["volumen_dp"].'</td>';
					}
		 				//header("Location:ingreso_cir_ele.php?m");
			}
?>
</table>				<p>&nbsp; </p>

        		<table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
  						<tr>
  		         				<td align="center"> <input name="btningresosh2so4" type="button" value="Nuevo Desc.Parcial" style="width:120" onClick="Proceso(this.form,'2')">
        				     					    <input name="btnmodificar" type="button" id="btnmodificar" value="Modificar" style="width:70" onClick="Proceso3(this.form,'M')">
              										<input name="btneliminar2" type="button" id="btneliminar5" value="Eliminar"style="width:70"  onClick="Eliminar3(this.form)"> 
            </td>
	  					</tr>
				</table>
        <p>&nbsp;</p>
         
        <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="69" height="21" align="left"> 
              <div align="left"></div>
              <div align="left"> </div>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"></div>
              <div align="center"><font face="Arial, Helvetica, sans-serif"> </font></div>
              <div align="center"></div>
              <div align="center"></div></td>
            <td colspan="4" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ENVIO 
              A PLANTA DE TRATAMIENTO ELECTROLITO</td>
          </tr>
          <tr class="ColorTabla01"> 
            <td height="21" align="left">&nbsp;</td>
            <td width="146" align="left">Turno</td>
            <td width="187" align="left">Circuito</td>
            <td width="199" align="left">Destino</td>
            <td width="126" align="left">Volumen</td>
          </tr>
        </table>
        <table width="730" border="0" cellspacing="0" cellpadding="0" class="TablaInterior">
<?php
	if (strlen($dia1==1))
		$dia1='0'.$dia1;
	if (strlen($mes1==1))
		$mes1='0'.$mes1; 

	$fecha=$ano1."-".$mes1."-".$dia1;
	if ($mostrar == "S")
	{
		$consulta="SELECT turno,circuito_pte,destino_pte,volumen_pte FROM ref_web.tratamiento_electrolito WHERE fecha='".$fecha."'";	
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			//$consulta2="select turno,circuito_dp,volumen_dp from ref_web.desc_parcial where fecha='".$fecha."' and turno='".$row["turno"]."' ";	
			//$rs2=mysqli_query($link, $consulta2);
			//$row2 = mysqli_fetch_array($rs2);
			echo '<tr>';
			echo '<td width="63" height="25">';
			echo '<input type="checkbox" name="Chk03" value="Proceso=M&Turno='.$row["turno"].'&Circuito='.$row["circuito_pte"]. '&Destino='.$row["destino_pte"].'&Volumen='.$row["volumen_pte"].'"></td>';
			echo '<td width="1000" align="center">'.$row["turno"].'</td>';
			echo '<td width="1200" align="center">'.$row["circuito_pte"].'</td>';
			echo '<td width="1400" align="center">'.$row["destino_pte"].'</td>';
			echo '<td width="1600" align="center">'.$row["volumen_pte"].'</td>';
		}
				//header("Location:ingreso_cir_ele.php?m");
	}
?>
</table>				<p>&nbsp; </p>

        		<table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
  						<tr>
  		         				<td align="center"> <input name="btningresosh2so4" type="button" value="Nuevo Electrolito" style="width:120" onClick="Proceso(this.form,'3')">
        				     					    <input name="btnmodificar" type="button" id="btnmodificar" value="Modificar" style="width:70" onClick="Proceso4(this.form,'M')">
             										<input name="btneliminar" type="button" id="btneliminar" value="Eliminar"style="width:70"  onClick="Eliminar4(this.form)"> 
            </td>
	  					</tr>
				</table>
        <p>&nbsp;</p>
        <p> <font face="Arial, Helvetica, sans-serif"> 
          <input name ="btnSalir" type="button" onClick="JavaScript:Salir();" style="width:70" value="Salir">
          </font> </p></td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>