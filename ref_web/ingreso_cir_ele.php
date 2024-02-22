<?php
	
	include("../principal/conectar_ref_web.php");
	
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
	    window.open("ingreso_h2so4.php?"+linea,"","top=150,left=180,width=518,height=400,scrollbars=no,resizable = no");

	if (opc == '2')
	    window.open("ingreso_desc_parcial.php?"+linea,"","top=150,left=180,width=518,height=400,scrollbars=no,resizable = no");

	if (opc == '3')
	    window.open("ingreso_electrolito.php?"+linea,"","top=150,left=180,width=518,height=400,scrollbars=no,resizable = no");
		
	if (opc == '4')
	    window.open("ingreso_pte.php?"+linea,"","top=150,left=5,width=765,height=290,scrollbars=no,resizable = no");
		
	if (opc == 'M')
	{
		cantidad = CantidadChecheado(f);
		if (cantidad == 1)
		{
			linea = linea + "&txt_turno=" + ValorCheckBox(f);
		}
		else if (cantidad == 0)
		{
			alert("Debe Selecionar Una Casilla para Modificar");
			return;
		}
		else
		{
			alert("Hay mas de Una Casilla Marcada");
			return;
		}
	}	
		
	//window.open("proceso_cir_ele1.php?"+linea,"","top=195,left=180,width=437,height=360,scrollbars=no,resizable = no");
	
}
/*****************/

function Buscar()
{
	var f = document.frmPrincipal;
	f.action = 'ingreso_cir_ele.php?mostrar=S';

	f.submit();
}
/**********/
function Salir()
{
	document.location = "../principal/sistemas_usuario.php?CodSistema=10";
}
/**********/
</script></head>

<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="frmPrincipal" action="" method="post">
<?php include("../principal/encabezado.php")?>
<?php
?>  
  <table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr>
      <td width="762" align="center" valign="middle">


          <table width="734" border="0" cellpadding="3" class="TablaInterior">
          <tr> 
            <td width="453"><font face="Arial, Helvetica, sans-serif">Fecha&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              </font><font face="Arial, Helvetica, sans-serif">&nbsp; </font><font face="Arial, Helvetica, sans-serif"> 
              <select name="dia1" size="1" >
                <?php
					$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					for ($i=1;$i<=31;$i++)
					{
						if (($mostrar == "S") && ($i == $dia1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("j")) and ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select>
              <select name="mes1" size="1" id="select2">
                <?php
					for($i=1;$i<13;$i++)
					{
						if (($mostrar == "S") && ($i == $mes1))
							echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else if (($i == date("n")) && ($mostrar != "S"))
								echo '<option selected value="'.$i.'">'.$meses[$i-1].'</option>';
						else
							echo '<option value="'.$i.'">'.$meses[$i-1].'</option>\n';
					}
				?>
              </select>
              <select name="ano1" size="1" id="select3">
                <?php
					for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
					{
						if (($mostrar == "S") && ($i == $ano1))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else if (($i == date("Y")) && ($mostrar != "S"))
							echo '<option selected value="'.$i.'">'.$i.'</option>';
						else
							echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
              </select>
              </font></td>
            <td width="36"><font face="Arial, Helvetica, sans-serif">Turno </font></td>
            <td width="98"><font face="Arial, Helvetica, sans-serif"> 
              <select name="txt_turno">
                <option value='-1'>Seleccionar</option>
                <?php
					$Consulta="select distinct turno from ref_web.iniciales order by turno";
					$Respuesta = mysqli_query($link, $Consulta);
					while ($Fila=mysqli_fetch_array($Respuesta))
					{
						if ($txt_turno==$Fila[turno])
							echo "<option value='".$Fila[turno]."' selected>".$Fila[turno]."</option>";
						else
							echo "<option value='".$Fila[turno]."'>".$Fila[turno]."</option>";
		     		}
				?>
              </select>
              </font> <font face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
            <td width="110"><font face="Arial, Helvetica, sans-serif">
               <input name="btnbuscar" type="button" value="Buscar" style="width:70" title="Busca datos segun fecha"  onClick="Buscar()">
              </font></td>
          </tr>
        </table>


	  

        <br>
        <table width="730" border="0" cellspacing="0" cellpadding="0" bordercolor="#b26c4a" class="TablaDetalle">
          <tr class="ColorTabla01">
          <td width="58" height="20" align="left"><input type="checkbox" name="checkbox" value="" onClick="SeleccionarTodos(this.form)">
            </td>
            <td width="45" height="21"> <div align="center">Turno</div></td>
            <td width="125"><div align="center">Circuito</div></td>
            <td width="85"><div align="center">Volumen </div></td>
            <td width="95"><div align="center">Circuito</div></td>
            <td width="80"> <div align="center">Volumen</div></td>
            <td width="74"><div align="center"><font face="Arial, Helvetica, sans-serif"> 
                </font>Circuito</div></td>
            <td width="68"><div align="center">Destino</div></td>
            <td width="89"><div align="center">Volumen</div></td>
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
         /*$consulta="select turno,circuito_h2so4,volumen_h2so4 from ref_web.electrolito where fecha='".$fecha."' and turno='".$txt_turno."'";	*/
	
		$consulta = "select t1.turno,t1.circuito_h2so4,t1.volumen_h2so4,t2.circuito_dp,t2.volumen_dp,t3.destino_pte,t3.circuito_pte,t3.volumen_pte from ref_web.electrolito as t1";
        $consulta = $consulta." inner join ref_web.desc_parcial as t2 on t1.fecha=t2.fecha and t1.turno=t2.turno";
        $consulta = $consulta." inner join ref_web.tratamiento_electrolito as t3 on t2.fecha=t3.fecha and t2.turno=t3.turno";
        $consulta = $consulta." where t1.fecha = '".$fecha."'  and t1.turno = '".$txt_turno."'";
        //and t1.turno = '".$txt_turno."'
		/*echo $consulta."<br>";*/
		$rs = mysqli_query($link, $consulta);
		while ($row = mysqli_fetch_array($rs))
		{
			echo '<tr>';
			echo '<td width="63" height="25">';
			echo '<input type="checkbox" name="checkbox" value="'.$row[turno].'/'.$row[circuito_h2so4].'/'.$row[volumen_h2so4].'"></td>';
			echo '<td width="54" align="center">'.$row[turno].'</td>';
			echo '<td width="112" align="center">'.$row[circuito_h2so4].'</td>';
			echo '<td width="110" align="center">'.$row[volumen_h2so4].'</td>';
			echo '<td width="95" align="center">hola&nbsp</td>';
			echo '<td width="95" align="center">&nbsp</td>';
       		echo '<td width="95" align="center">&nbsp</td>';
            echo '<td width="95" align="center">&nbsp</td>';
			echo '<td width="95" align="center">&nbsp</td>';
			echo '</tr>';
		}
		 header("Location:ingreso_cir_ele.php?");
	}
?>
</table>


<br>
<table width="730" border="0" cellspacing="0" cellpadding="3" class="tablainterior">
  <tr>
            <td align="center"> <input name="btningresosh2so4" type="button" value="Nuevo H2SO4" style="width:120" onClick="Proceso(this.form,'1')">
              <input name="btningresosdesc.parcial" type="button" value="Nuevo Desc.Parcial" style="width:120" onClick="Proceso(this.form,'2')">
            <input name="btingresoselectrolito" type="button" value="Nuevo Electrolito  " style="width:120" onClick="Proceso(this.form,'3')">
            <input name="btingresospte" type="button" value="Nuevo PTE" style="width:120" onClick="Proceso(this.form,'4')">
            <input name="btnmodificar" type="button" id="btnmodificar" value="Modificar" style="width:70" onClick="Proceso(this.form,'M')">
            <input name="btnsalir" type="button" value="Salir" style="width:120" onClick="Salir()"></td>
  </tr>
</table>


</td>
</tr>
</table>
<?php include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
