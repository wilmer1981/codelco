<?php 	
	$CodigoDeSistema = 3;
	$CodigoDePantalla = 37;
	include("../principal/conectar_sec_web.php");

	$Buscar     = isset($_REQUEST["Buscar"])?$_REQUEST["Buscar"]:"";
	$CmbBascula = isset($_REQUEST["CmbBascula"])?$_REQUEST["CmbBascula"]:"";

	$DiaIni = isset($_REQUEST["DiaIni"])?$_REQUEST["DiaIni"]:date("d");
	$MesIni = isset($_REQUEST["MesIni"])?$_REQUEST["MesIni"]:date("m");
	$AnoIni = isset($_REQUEST["AnoIni"])?$_REQUEST["AnoIni"]:date("Y");

	$DiaFin = isset($_REQUEST["DiaFin"])?$_REQUEST["DiaFin"]:date("d");
	$MesFin = isset($_REQUEST["MesFin"])?$_REQUEST["MesFin"]:date("m");
	$AnoFin = isset($_REQUEST["AnoFin"])?$_REQUEST["AnoFin"]:date("Y");

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


function Buscar()
{
	var Frm=document.FrmConsultaPatron;
	Frm.action="sec_consulta_peso_patron_popup.php?Buscar=S";
	Frm.submit();
	
}

function Salir()
{
	window.close();
	
}
</script>
<title>Consulta Peso Patr&oacute;n</title>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<body leftmargin="3" topmargin="5" marginwidth="0" marginheight="0">
<form name="FrmConsultaPatron" method="post" action="">

  
 <table width="100%" height="350" border="0" class="TablaPrincipal" left="6" cellpadding="6" cellspacing="0">
	  <tr>
      <td align="center" valign="top"><br>
	  <table border="0">
      <tr>
      <td >Fecha Inicio: </td>
      <td><select name="DiaIni" id="DiaIni" style="width:50px;">
          <?php
	  	for ($i = 1;$i <= 31; $i++)
		{
			if (isset($DiaIni))
			{
				if ($DiaIni == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
			else
			{
				if ($i == date("d"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else
					echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesIni" id="MesIni" style="width:90px;">
          <?php
		  		for ($i = 1;$i <= 12; $i++)
				  {
					  if (isset($MesIni))
					  {
						  if ($MesIni == $i)
							  echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						  else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					  }
					  else
					  {
						  if ($i == date("n"))
							  echo "<option SELECTed value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
						  else	echo "<option value='".$i."'>".ucwords(strtolower($Meses[$i - 1]))."</option>\n";
					  }
				  }
		?>
        </select> <select name="AnoIni" id="AnoIni" style="width:60px;">
          <?php
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
      <td >Fecha Termino:</td>
      <td ><select name="DiaFin" id="DiaFin"  style="width:50px;">
          <?php
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
				if ($i == date("d"))
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	echo "<option value='".$i."'>".$i."</option>\n";
			}
		}
	  ?>
        </select> <select name="MesFin"  id="MesFin" style="width:90px;">
          <?php
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
          <?php
		for ($i = (date("Y") - 1);$i <= (date("Y") + 1); $i++)
		{
			if (isset($AnoFin))
			{
				if ($AnoFin == $i)
					echo "<option selected value='".$i."'>".$i."</option>\n";
				else	
					echo "<option value='".$i."'>".$i."</option>\n";
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
    
    <td >B&aacute;scula:</td>
     <td  colspan="3"><select name="CmbBascula"  id="CmbBascula" >
         <option selected value='T'>TODOS</option>
      		<?php
			
			$Consulta = "SELECT * from proyecto_modernizacion.sub_clase where cod_clase=3112";
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
        <input name="btnsalir2" type="button" style="width:70" onClick="JavaScript:Salir()" value="Salir"> 
      </td>
    </tr>
  </table>
  <?php if($Buscar=='S')
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
        <table width="100%" border="1" align="center" cellpadding="2" cellspacing="1"  class="TablaDetalle">
         <tr> 
             <td colspan="5"><div align="center">Periodo: <strong>Desde :</strong><?php echo $Fechainiturno;?>  <strong>Hasta :</strong><?php echo $Fechafturno;?></div></td>
          </tr>
          <tr class="ColorTabla01"> 
             <td >&nbsp;</td>
             <td ><div align="center">Fecha/Hora Registro</div></td>
            <td ><div align="center">B&aacute;scula</div></td>
            <td><div align="center">Peso</div></td>
            <td ><div align="center">Funcionario</div></td>
     
            </tr>
         
			<?php  
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
				<td><?php echo $cont;?></td>
				<td><?php echo $Fila["fecha_registro"];?></td>
				<td><?php echo $Fila["descripcion"];?></td>
				<td align="right"><?php echo number_format($Fila["peso"],1,',','.');?></td>
				<td><?php echo $NombreUser;?></td>
				</tr>
				<?php	
				$cont++;
			}
			
			?>
        </table> 
        
        <?php }
		?>
        </td>
    </tr>
  </table>
</form>
</body>
</html>
