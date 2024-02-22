<?php 	
	include("../principal/conectar_principal.php");
	$meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	
	
	switch($Proceso)
	{
		case "N":
			/*$Consulta = "select max(num_prog_loteo) as CodMayor from sec_web.programa_loteo";
			$Resultado = mysqli_query($link, $Consulta);
			if ($Fila=mysqli_fetch_array($Resultado))
			{
				$NroPrg=$Fila[CodMayor]+1;	
			}
			else
			{
				$NroPrg=1;	
			}*/
			break;
		case "M":
			/*$Datos=explode('~~',$Valores);
			for ($i=0;$i<=strlen($Datos);$i++)
			{
				if (substr($Datos,$i,2)=="//")
				{
					$CodDescripcion=substr($Datos,0,$i);
					for ($j=0;$j<=strlen($CodDescripcion);$j++)
					{
						if (substr($CodDescripcion,$j,2)=="~~")
						{
							$Codigo=substr($CodDescripcion,0,$j);
							$Descripcion=substr($CodDescripcion,$j+2);
						}	
					}
					$Datos=substr($Datos,$i+2);
					$i=0;
				}
			}*/
			break;	
	}	

?>
<html>
<head>
<script language="JavaScript">
function SoloNumeros() 
{ 
	var Frm=document.FrmProceso;
	var teclaCodigo = event.keyCode; 
	
	if ((teclaCodigo != 37)&&(teclaCodigo != 39)&&(teclaCodigo !=9))
	{
		if ((teclaCodigo != 8) && (teclaCodigo < 48) || (teclaCodigo > 57))
		{
		   if ((teclaCodigo < 96) || (teclaCodigo > 105))
		   {
				event.keyCode=46;
		   }		
		}   
	}
} 

function Validar(Tipo)
{
	var Frm=document.FrmProceso;
	var CodLote="";
	
	if (Frm.TxtIE.value=="")
	{
		alert("Debe Ingresar Instruccion Embarque");
		Frm.TxtIE.focus();
		return;
	}
	switch (Tipo)
	{
		case "IE":
			Frm.action="sec_relacion_instruccion_emb_lote_proceso01.php?Proceso=V1&TxtIE="+Frm.TxtIE.value;
			break;
		case "NL":
			if (Frm.TxtNumLote.value=="")
			{
				alert("Debe Ingresar Numero de Lote");
				Frm.TxtNumLote.focus();
				return;
			}
			LetraLote=Frm.CmbCodLote.options[Frm.CmbCodLote.selectedIndex].text;
			Frm.action="sec_relacion_instruccion_emb_lote_proceso01.php?Proceso=V2&TxtIE="+Frm.TxtIE.value+"&LetraLote="+LetraLote+"&MesLote="+Frm.CmbCodLote.value+"&TxtNumLote="+Frm.TxtNumLote.value;
			break;
	}
	Frm.submit();
}
function Buscar(Tipo)
{
	var Frm=document.FrmProceso;
		
	switch (Tipo)
	{
		case "IE":
			break;
		case "NL":
			break;
	}
}
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	
	if (Frm.TxtIE.value=='')
	{
		alert("Debe Ingresar Instruccion de Embarque");
		Frm.TxtIE.focus();
		return;
	}
	if (Frm.TxtNumLote.value=='')
	{
		alert("Debe Ingresar Lote");
		Frm.TxtNumLote.focus();
		return;
	}
	LetraLote=Frm.CmbCodLote.options[Frm.CmbCodLote.selectedIndex].text;
	Frm.action="sec_relacion_instruccion_emb_lote_proceso01.php?Proceso="+Proceso+"&TxtNumLote="+Frm.TxtNumLote.value+"&LetraLote="+LetraLote;
	Frm.submit();
	
}
function Salir()
{
	window.close();
}
</script>
<title>Proceso</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body onload="document.FrmProceso.TxtIE.focus()" background="../principal/imagenes/fondo3.gif" leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmProceso" method="post" action="">
  <table width="407" height="157" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal" left="5">
    <tr>
    <td><table width="395" border="1" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="113">&nbsp;</td>
            <td width="272" align="right"><strong>Fecha:&nbsp;<?php echo date('Y:m:d')?></strong>&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr> 
            <td>Inst.Embarque</td>
            <td> 
			<?php
				echo "<input type='text' name='TxtIE' onkeyDown='SoloNumeros();' style='width:60' maxlength='6' value='$CodIE'>&nbsp;&nbsp;";					
				echo "<input type='button' name='BtnOk' value='Ok' onclick=\"Validar('IE')\">&nbsp;";
				echo "<input type='button' name='BtnBuscarIE' value='Buscar' onclick=Buscar('IE')>";//BUSCAR LOTE					
			?>
            </td>
          </tr>
          <tr> 
            <td>Eta Embarque</td>
            <td>
			<?php
				echo "<input type='text' name='TxtFechaEmb' style='width:80' maxlength='6' value='$FechaEmb' readonly>";					
			?>
			</td>
          </tr>
          <tr> 
            <td>Peso Programado</td>
            <td>
			<?php	if (isset($CantEmb))
				{
					$CantEmbKilos=($CantEmb*1000);
				}
				if ($CantEmb==0)
				{
					$CantEmbKilos='';
				}
				echo "<input type='text' name='TxtCantEmb' style='width:60' maxlength='6' value='$CantEmbKilos' readonly>&nbsp;&nbsp;Ton.";					
			?>
			</td>
          </tr>
          <tr> 
            <td>Cliente</td>
            <td><strong>
			<?php
				echo $NombreCliente."&nbsp";
				echo "<input type='hidden' name='CodCliente' value='$CodCliente'>";									
			?>
			</strong>
			</td>
          </tr>
          <tr> 
            <td>Codigo Lote</td>
            <td>
			<?php
				echo "<select name='CmbCodLote'>";
				if ($MesActual=='S')
				{
					$Mes=date("n");
				}
				else
				{
					$Mes=$MesSelec;
				}
				$CmbCodLote=$Mes;		
				$Consulta="select * from proyecto_modernizacion.sub_clase ";
				$Consulta.=" where cod_clase='3004' and cod_subclase between 1 and 12   ";
				$Respuesta=mysqli_query($link, $Consulta);
				while($Fila=mysqli_fetch_array($Respuesta))
				{
					if ($CmbCodLote==$Fila["cod_subclase"])
					{
						echo "<option value=".$Fila["cod_subclase"]." selected>".$Fila["nombre_subclase"]."</option>";	
					}
					else
					{
						echo "<option value=".$Fila["cod_subclase"].">".$Fila["nombre_subclase"]."</option>";	
					}
				}
				echo "</select>&nbsp;&nbsp;N� Lote&nbsp;&nbsp;";			
				echo "<input type='text' name='TxtNumLote' onkeyDown='SoloNumeros();' style='width:60' maxlength='6' value='$NumLote'>&nbsp;&nbsp;";
				echo "<input type='button' name='BtnOk2' value='Ok' onclick=Validar('NL')>&nbsp;";						
				//echo "<input type='button' name='BtnBuscarLote' value='Buscar' onclick=Buscar('NL')>";//BUSCAR LOTE					
			?>
			</td>
          </tr>
          <tr> 
            <td>Cantidad Paquete</td>
            <td>
			<?php
				echo "<input type='text' name='TxtCantPaquete' style='width:60' maxlength='2' value='$CantPaquetes' readonly>";
			?>
			</td>
          </tr>
          <tr> 
            <td>Peso Lote</td>
            <td>
			<?php
				echo "<input type='text' name='TxtPesoLote' style='width:80' maxlength='2' value='$PesoLote' readonly>&nbsp;&nbsp;Kgr.";
			?>
			</td>
          </tr>
          <tr> 
            <td>Unidades Paquete</td>
            <td>
			<?php
				echo "<input type='text' name='TxtUnidPaquete' style='width:80' maxlength='2' value='$UnidadPaquete' readonly>";
			?>
			</td>
          </tr>
          <tr>
            <td>Marca del Lote</td>
            <td>
			<?php
				echo "<input type='text' name='TxtMarcaLote' style='width:200' maxlength='2' value='$MarcaLote' readonly>";
				echo "<input type='hidden' name='CodMarcaLote' value='$CodMarca' readonly>";
			?>
			</td>
          </tr>
        </table>
        <br>
        <table width="395" border="1" cellpadding="2" cellspacing="0">
          <tr> 
            <td  align="center" width="509"><input type="button" name="BtnGrabar" value="Grabar" style="width:60" onClick="Grabar('G','<?php echo $Valores;?>')">
              <input type="button" name="BtnSalir" value="Salir" style="width:60" onClick="Salir();">
              &nbsp; </td>
          </tr>
        </table> </td>
  </tr>
</table>
  </form>
</body>
</html>
<?php
	if (isset($Error))
	{
		echo "<script languaje='javascript'>";
		echo "alert('$Error');";	
		echo "</script>";
	}
?>