<? 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 37;
	include("../principal/conectar_sec_web.php");
	$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");	

?>
<html>
<head>

<script language="JavaScript">
var OK;
var OTS = "";
ns4 = (document.layers)? true:false
ie4 = (document.all)? true:false
function muestra(numero) 
{
 	if (ns4){ 
 		eval("document. " + numero + ".visibility = 'show'");
	}
 	else	{
		if (ie4) {
			eval("Txt" + numero + ".style.visibility = 'visible'");
			eval("Txt" + numero + ".style.left = 100 ");
		}
	}
}
function oculta(numero) 
{
	if (ns4)
	{ 
 		eval("document. " + numero + ".visibility = hide'");
	}
 	else	
	{
		if (ie4) 
		{
			eval("Txt" + numero + ".style.visibility = 'hidden'");
		}
	}
}

function Imprimir()
{
	var Frm=document.FrmConsultaPatron;
	
	window.print();	
}
function Excel(Tipo)
{
	var Frm=document.FrmConsultaPatron;
	
	Frm.action="sec_consulta_peso_patron_excel.php";
	Frm.submit();

}
function Buscar()
{
	var Frm=document.FrmConsultaPatron;
	Frm.action="sec_consulta_peso_patron.php?Buscar=S";
	Frm.submit();
	
}

function Salir()
{
	var Frm=document.FrmConsultaPatron;
	Frm.action="../principal/sistemas_usuario.php?CodSistema=3&Nivel=1&CodPantalla=15";
	Frm.submit();
	
}
</script>
<title>Consulta Peso Patr&oacute;n</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaPatron" method="post" action="">
  <? include("../principal/encabezado.php")?>
  
 <table width="768" height="350" border="0" class="TablaPrincipal" left="6" cellpadding="6" cellspacing="0">
	  <tr>
      <td width="754"  align="center" valign="top"><br>
	  <table width="730" border="0">
      <tr>
      <td width="86">Fecha Inicio: </td>
      <td width="259"><select name="DiaIni" id="DiaIni" style="width:50px;">
          <?
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesIni" id="MesIni" style="width:90px;">
          <?
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesIni))
			{
				if ($MesIni == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoIni" id="AnoIni" style="width:60px;">
          <?
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoIni))
			{
				if ($AnoIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select></td>
      <td width="119">Fecha Termino:</td>
      <td width="265"><select name="DiaFin" id="DiaFin"  style="width:50px;">
          <?
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaFin))
			{
				if ($DiaFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("j"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesFin"  id="MesFin" style="width:90px;">
          <?
		for ($i = 1;$i <= 12; $i++)
		{
			if (isset($MesFin))
			{
				if ($MesFin == $i)
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
			else
			{
				if ($i == date("n"))
					echo "<option selected value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
				else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
			}
		}
		?>
        </select> <select name="AnoFin"  id="AnoFin" style="width:60px;">
          <?
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("Y"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
		?>
        </select></td>
    </tr>
    <tr>
    
    <td width="119">B&aacute;scula:</td>
     <td  colspan="3"><select name="CmbBascula"  id="CmbBascula" >
         <option selected value='T'>TODOS</option>
      		<?
			
			$Consulta = "select * from proyecto_modernizacion.sub_clase where cod_clase=3112";
			$Resp=mysqli_query($link, $Consulta);
			while ($Fila=mysqli_fetch_array($Resp))	
			{
				if ($Fila['cod_subclase'] == $CmbBascula)
					echo '<option value="'.$Fila['cod_subclase'].'" selected>'.$Fila['nombre_subclase'].'</option>';
				else 
					echo '<option value="'.$Fila['cod_subclase'].'">'.$Fila['nombre_subclase'].'</option>';
			}	
			
			?>			
              </select>
    
    </tr>
    <tr> 
      <td colspan="4" align="center"> <input name="btnConsultar" type="button" id="btnConsultar" style="width:70;" onClick="JavaScript:Buscar()" value="Consultar"> 
        <input name="btnimprimir2" type="button" value="Imprimir" style="width:70;" onClick="JavaScript:Imprimir()">
        <input name="btnExcel" type="button" id="btnExcel" style="width:70;" onClick="JavaScript:Excel('E')" value="Excel">
        <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Salir()" value="Salir"> 
      </td>
    </tr>
  </table>
  <? if($Buscar=='S')
  {
	  
	  
	 		 if (strlen($MesIni)==1)
			{
				$MesIni="0".$MesIni;
			}
			if (strlen($DiaIni)==1)
			{
				$DiaIni="0".$DiaIni;
			}
			if (strlen($MesFin)==1)
			{
				$MesFin="0".$MesFin;
			}
			if (strlen($DiaFin)==1)
			{
				$DiaFin="0".$DiaFin;
			}
			$Fechainiturno=$AnoIni."-".$MesIni."-".$DiaIni." 08:00:00";
			$Fechafturno=$AnoFin."-".$MesFin."-".$DiaFin." 23:59:59";
	  ?>
        <br>
        <table width="730" border="1" align="center" cellpadding="2" cellspacing="1"  class="TablaDetalle">
         <tr> 
             <td colspan="9"><div align="center">Periodo: <strong>Desde :</strong><? echo $Fechainiturno;?>  <strong>Hasta :</strong><? echo $Fechafturno;?></div></td>
 
          </tr>
          <tr class="ColorTabla01"> 
             <td width="26">&nbsp;</td>
             <td width="141"><div align="center">Fecha/Hora Registro</div></td>
            <td width="164"><div align="center">B&aacute;scula</div></td>
            <td width="131"><div align="center">Peso</div></td>
            <td width="299"><div align="center">Funcionario</div></td>
     
            </tr>
         
			<?  
			$cont = 1;			
			$Consulta1=" select t1.*,t2.nombres,t2.apellido_paterno,t2.apellido_materno from sec_web.sec_registro_peso_patron t1 left join proyecto_modernizacion.funcionarios t2 on t1.usuario=t2.rut ";
			$Consulta1.=" where (t1.fecha_registro  BETWEEN  '".$Fechainiturno."' and  '".$Fechafturno."' )";
			if($CmbBascula!='T')
				$Consulta1.=" and id_bascula = '".$CmbBascula."'";	
			$Consulta1.=" ORDER BY fecha_registro ASC ";
		   $Respuesta=mysqli_query($link, $Consulta1);
			while ($Fila=mysqli_fetch_array($Respuesta))
			{
					
				$PrimerNombre=$Fila["nombres"];
				for ($i=0;$i<=strlen($PrimerNombre);$i++)
				{
					if (substr($PrimerNombre,$i,1)==" ")
					{
						$PrimerNombre=trim(substr($PrimerNombre,0,$i));
						break;
					}
				}
				$NombreUser = ucwords(strtolower($PrimerNombre))." ".ucwords(strtolower($Fila["apellido_paterno"]))." ".strtoupper(substr($Fila["apellido_materno"],0,1)).".";
				?>
                <tr>
				<td><? echo $cont;?></td>
				<td><? echo $Fila[fecha_registro];?></td>
				<td><? echo $Fila[descripcion];?></td>
				<td align="right"><? echo number_format($Fila[peso],1,',','.');?></td>
				<td><? echo $NombreUser;?></td>
				</tr>
				<?	
				$cont++;
			}
			
			?>
        </table> 
        
        <? }
		?>
        </td>
    </tr>
  </table>
  <? include("../principal/pie_pagina.php")?>
</form>
</body>
</html>
