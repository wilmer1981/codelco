<?php 
include("../principal/conectar_principal.php");
// Ano=2022&subproducto=11&Codigo=J&Numero=50000&MesI=J&NumI=50000&MesF=J&NumF=50003&Ano=2022
$Ano          = isset($_REQUEST["Ano"])?$_REQUEST["Ano"]:"";
$Mes          = isset($_REQUEST["Mes"])?$_REQUEST["Mes"]:"";
$subproducto  = isset($_REQUEST["subproducto"])?$_REQUEST["subproducto"]:"";
$Codigo  = isset($_REQUEST["Codigo"])?$_REQUEST["Codigo"]:"";
$Numero  = isset($_REQUEST["Numero"])?$_REQUEST["Numero"]:"";
$MesI    = isset($_REQUEST["MesI"])?$_REQUEST["MesI"]:"";
$NumI    = isset($_REQUEST["NumI"])?$_REQUEST["NumI"]:"";
$MesF    = isset($_REQUEST["MesF"])?$_REQUEST["MesF"]:"";
$NumF    = isset($_REQUEST["NumF"])?$_REQUEST["NumF"]:"";

$Mensaje  = isset($_REQUEST["Mensaje"])?$_REQUEST["Mensaje"]:"";
$Mostrar  = isset($_REQUEST["Mostrar"])?$_REQUEST["Mostrar"]:"";

?>
<html>
<head>
<title>Detalle de SubLotes </title>
<link href="../principal/estilos/css_pmn_web.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
function Proceso(opt)
{
	var f = document.frmConsulta;
	switch (opt)
	{
		case "S":
			window.close();
		break;
	}
}
function ModificarFecha(subprod)
{
	var frm = document.frmConsulta;
	var LargoForm = frm.elements.length;
	var DatosAux="";
	var CheckeoPaquete=false;
	var ValoresPaquetes="";
	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name =="checkbox") && (frm.elements[i].checked == true))
		{
			CheckeoPaquete= true;
			DatosAux=frm.elements[i].value.split('//');
			if(DatosAux[3]=='a')
				ValoresPaquetes = ValoresPaquetes + frm.elements[i].value +"@@";
			else
				alert('Paquete '+DatosAux[0]+"-"+DatosAux[1]+" Cerrado, No se puede Modificar Fecha");
		}
	}
	if (CheckeoPaquete==false)
	{
		alert("Debe seleccionar un elemento");
		return;
	}
	if (ValoresPaquetes=="")
	{
		return;
	}
	//alert(ValoresPaquetes);
	ValoresPaquetes=ValoresPaquetes.substr(0,ValoresPaquetes.length-2);
	window.open("sec_modificar_fecha_paquetes.php?Valores="+ValoresPaquetes+"&CodigoLote="+frm.CodigoO.value+"&NumeroLote="+frm.NumeroO.value+"&Ano="+frm.AnoAux.value+"&subproducto="+subprod,"","top=195,left=180,fullscreen=no,width=470,height=230,scrollbars=yes,resizable = yes");
}
function Recuperar()
{
	var frm = document.frmConsulta;
	var LargoForm = frm.elements.length;
	var CheckeoPaquete=false;
	var ValoresPaquetes="";
	for (i=0;i < LargoForm;i++)
	{
		if ((frm.elements[i].name =="checkbox") && (frm.elements[i].checked == true))
		{
			CheckeoPaquete= true;
			ValoresPaquetes = ValoresPaquetes + frm.elements[i].value +"@@";
		}
	}
	if (CheckeoPaquete==false)
	{
		alert("Debe seleccionar un elemento");
	}
	else
	{
		ValoresPaquetes=ValoresPaquetes.substr(0,ValoresPaquetes.length-2);
		window.open("sec_cambio_grupo.php?NumI="+frm.NumI.value+"&NumF="+frm.NumF.value +"&MesI="+frm.MesI.value+"&Valores="+ValoresPaquetes+"&CodigoLote="+frm.CodigoO.value+"&NumeroLote="+frm.NumeroO.value+"&Ano="+frm.AnoAux.value,"","top=195,left=180,fullscreen=no,width=200,height=100,scrollbars=yes,resizable = yes");
		//window.open("sec_detalle_paquete.php?Ano="+Frm.CmbAno.value+"&subproducto="+sub_producto+"&Codigo="+CodBulto +"&Numero="+NumBulto+"&MesI="+MesI+"&NumI="+NumI+"&MesF="+MesF+"&NumF="+NumF+"&Ano="+Frm.CmbAno.value,""," fullscreen=no,width=680,height=400,scrollbars=yes,resizable = yes");
	}
}
function CheckearTodo()
{
	var Frm=document.frmConsulta;
	try
	{
		Frm.checkbox[0];
		for (i=0;i<Frm.checkbox.length;i++)
		{
			if (Frm.CheckTodos.checked==true)
			{
				Frm.checkbox[i].checked=true;
			}
			else
			{
				Frm.checkbox[i].checked=false;
			}	
		}
	}
	catch (e)
	{
	}
}

</script>
</head>

<body background="../principal/imagenes/fondo3.gif">
<form name="frmConsulta" action="" method="post">
<input name="NumI" type="hidden" value="<?php echo $NumI  ?>">
<input name="NumF" type="hidden" value="<?php echo $NumF  ?>">
<input name="MesI" type="hidden" value="<?php echo $MesI  ?>">
<input name="AnoAux" type="hidden" value="<?php echo $Ano  ?>">
  <table width="634" border="0" align="center">
    <tr> 
      <td width="628"><table width="627" border="0" align="center" cellpadding="1" cellspacing="1" class="TablaInterior">
          <tr> 
            <td colspan="6"> <div align="center"> 
                <input name="BtnGrupo" type="button" style="width:70px" value="Grupo" onClick="Recuperar();">
                <input name="BtnModFecha" type="button" style="width:80px" value="Mod.Fecha" onClick="ModificarFecha('<?php echo $subproducto;?>');">
                <input type="button" name="btnCerrar" value="Cerrar" onClick="Proceso('S');" style="width:70px">
              </div></td>
          </tr>
          <tr> 
            <td width="45">&nbsp;</td>
            <td width="35">Lote :</td>
            <td width="61"> 
              <?php
			echo $Codigo;
			echo "-";
			echo $Numero;
			echo "<input name='CodigoO' type='hidden' value='$Codigo'>";
			echo "<input name='NumeroO' type='hidden' value='$Numero'>";
			?>
              &nbsp;</td>
            <td width="87">Sub Lote Inicial</td>
            <td width="73"> 
              <?php
			echo $MesI;
			echo "-";
			echo $NumI;
			
			?>
              &nbsp;</td>
            <td width="307">Sub Lote Final: 
              <?php
			echo $MesF;
			echo "-";
			echo $NumF;
			
			?>
            </td>
          </tr>
        </table>
        <br>
        <table width="628" border="1" align="center" cellpadding="2" cellspacing="1"  class="TablaDetalle">
          <tr class="ColorTabla01"> 
            <td width="15"><input name="CheckTodos" type="checkbox" style="width:20" onClick="CheckearTodo()"></td>
            <td width="80"><div align="center">Serie Paquete</div></td>
            <td width="60"><div align="center">Peso</div></td>
            <td width="50"><div align="center">Unid.</div></td>
            <td width="66"><div align="center">Estado</div></td>
            <td width="81"><div align="center">Cod Producto</div></td>
            <td width="64"><div align="center">Grupo</div></td>
            <td width="148"><div align="center">F.Creacion</div></td>
          </tr>
			<?php  
			$cont = 0;
			$Consulta=" SELECT t1.hora,t1.cod_paquete,t1.cod_subproducto,t1.num_paquete,t1.cod_producto,t1.num_unidades,t1.cod_grupo,t1.peso_paquetes,t1.cod_estado,t1.fecha_creacion_paquete ";
			$Consulta.=" from sec_web.paquete_catodo t1";
			$Consulta.=" inner join sec_web.lote_catodo t2 on t1.cod_paquete=t2.cod_paquete and t1.num_paquete=t2.num_paquete ";
			$Consulta.=" where (t2.num_paquete between '".$NumI."' and '".$NumF."' and t1.cod_estado=t2.cod_estado) and t2.cod_paquete='".$MesI."'";
			$Consulta.=" AND substring(fecha_creacion_lote,1,4)='".$Ano."' and cod_bulto='".$Codigo."' and num_bulto='".$Numero."'"; 
			$Consulta.=" AND t1.fecha_creacion_paquete = t2.fecha_creacion_paquete and t1.cod_subproducto = '".$subproducto."'";	
			$Consulta.=" order by	t1.cod_paquete,t1.num_paquete	";
			//echo $Consulta."<br>";
			$Respuesta=mysqli_query($link, $Consulta);
			$SumaPeso=0;
			$SumaUnidades=0;
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
				echo "<tr>";
					echo '<td><input name="checkbox" type="checkbox" style="width:20" value="'.$Fila["cod_paquete"]."//".$Fila["num_paquete"]."//".$Fila["fecha_creacion_paquete"]."//".$Fila["cod_estado"].'"><input type="hidden" value="'.$Fila["fecha_creacion_paquete"].'"></td>';		
					echo "<td>".$Fila["cod_paquete"]."-".$Fila["num_paquete"]."</td> ";
					echo "<td align='right'>".$Fila["peso_paquetes"]."</td> ";	
					echo "<td align='right'>".$Fila["num_unidades"]."</td> ";
					if ($Fila["cod_estado"]=="c")
					{
						$Estado="Cerrado";
					}
					else
					{
						$Estado="Abierto";
					}
					echo "<td>".$Estado."</td> ";		
					$Consulta="SELECT * from proyecto_modernizacion.subproducto ";
					$Consulta.=" where cod_producto='".$Fila["cod_producto"]."' and cod_subproducto='".$Fila["cod_subproducto"]."' ";
					$Respuesta1=mysqli_query($link, $Consulta);
					$Fila1=mysqli_fetch_array($Respuesta1);
					echo "<td>".$Fila1["abreviatura"]."</td> ";	
					echo "<td>Grupo &nbsp;".$Fila["cod_grupo"]."</td> ";
					echo "<td align='center'>".$Fila["fecha_creacion_paquete"]." ".$Fila["hora"]."</td> ";				
				echo "</tr>";
				$SumaPeso=$SumaPeso+$Fila["peso_paquetes"];
				$SumaUnidades=$SumaUnidades+$Fila["num_unidades"];
				$cont++;
			}
			echo "<tr class='Detalle01'>";
			echo "<td>".$cont."</td>";
			echo "<td><strong>Total</strong></td>";
			echo "<td align='right'><strong>".$SumaPeso."</strong></td> ";		
			echo "<td align='right'><strong>".$SumaUnidades."</strong></td> ";	
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "</tr>";
			?>
        </table> </td>
    </tr>
  </table>
	<?php
		echo "<script languaje='JavaScript'>";
		echo "var frm=document.FrmProceso;";
		if ($Mensaje=='S')
		{
			echo "alert('Este Lote esta Asociado a una Inst Embarque');";
		}		
		echo "</script>"
  	?>
</form>
</body>
</html>
