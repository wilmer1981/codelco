<?php 	
	include("../principal/conectar_principal.php");

	if(isset($_REQUEST["Proceso"])){
		$Proceso = $_REQUEST["Proceso"];
	}else{
		$Proceso = "";
	}
	if(isset($_REQUEST["CmbTipo"])){
		$CmbTipo = $_REQUEST["CmbTipo"];
	}else{
		$CmbTipo = "";
	}
	if(isset($_REQUEST["Valores"])){
		$Valores = $_REQUEST["Valores"];
	}else{
		$Valores = "";
	}
	if(isset($_REQUEST["CmbRut"])){
		$CmbRut = $_REQUEST["CmbRut"];
	}else{
		$CmbRut = "";
	}
	if(isset($_REQUEST["R"])){
		$R = $_REQUEST["R"];
	}else{
		$R = "";
	}

	$EncontroCoincidencia = isset($_REQUEST["EncontroCoincidencia"])?$_REQUEST["EncontroCoincidencia"]:"";

	switch($Proceso)
	{
		case "N":
			break;
		case "M":
			$Datos2=explode('~',$Valores);
			$TxtCodigo1=$Datos2[0];
			$TxtCodigo2=$Datos2[1];

			//echo "codigo1:".$TxtCodigo1;
			//echo "<br>codigo2:".$TxtCodigo2;
			//eta consulta esta mal en la condicion
			$Consulta = "SELECT * from proyecto_modernizacion.funcionarios t1";
			$Consulta.=" INNER JOIN proyecto_modernizacion.sub_clase t2 ON t2.cod_clase='6002' AND t1.rut=t2.nombre_subclase ";
			$Consulta.=" WHERE t2.nombre_subclase='".$Datos2[0]."' AND t2.valor_subclase1='".$Datos2[1]."' order by apellido_paterno";
			
			//echo $Consulta."<br>";
			$Respuesta = mysqli_query($link, $Consulta);
			$Fila      = mysqli_fetch_array($Respuesta);
			$TxtCodigo    =$Fila["rut"];
			$TxtNombres   =$Fila["apellido_paterno"]." ".$Fila["apellido_paterno"]." ".$Fila["nombres"];
			$TxtApePaterno =$Fila["apellido_paterno"];
			$TxtApeMaterno =$Fila["apellido_materno"];
			if($R!='S') 
				$CmbTipo=$Fila["valor_subclase1"];
			//echo $CmbRut."<br>";
			break;	
	}	
?>
<html>
<head>
<script language="JavaScript">
function Grabar(Proceso,Valores)
{
	var Frm=document.FrmProceso;
	Frm.action="pmn_ingreso_funcionarios_proceso01.php?Proceso="+Proceso+"&TxtCodigo="+Valores;
	Frm.submit();
}
function Recarga(Proceso)
{
	var Frm=document.FrmProceso;
	if(Proceso=='N')
	{	
		Frm.action="pmn_ingreso_funcionarios_proceso.php?Proceso="+Proceso;
		Frm.submit();
	}	
	else
	{
		Frm.action="pmn_ingreso_funcionarios_proceso.php?Proceso="+Proceso+"&Valores="+Frm.Valores.value+"&R=S";
		Frm.submit();
	}
}

function Salir()
{
	window.close();
	
}
</script>
<title>Proceso</title>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<?php
	echo "<body leftmargin='3' topmargin='5' marginwidth='0' marginheight='0'>";
?>

<form name="FrmProceso" method="post" action="">
  <table width="71%" align="center"  border="0" cellpadding="0"  cellspacing="0">
    <tr>
      <td height="1%"><img src="archivos/images/interior/esq3.png"></td>
      <td width="98%"background="archivos/images/interior/arriba.png"><img src="archivos/images/interior/transparent.gif"></td>
      <td height="1%"><img src="archivos/images/interior/esq2.png"></td>
    </tr>
    <tr>
      <td width="1%" background="archivos/images/interior/izquierdo.png"></td>
      <td align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaInterior">
        <tr>
          <td width="96" class='TituloCabecera' colspan="2">Ingreso&nbsp;de&nbsp;Usuario</td>
        </tr>
        <?php
			 if($Proceso=='M')
			{	
				echo "<input type='hidden' name='Valores' value='".$Valores."'>";	  
				echo "<input type='hidden' name='TxtCodigo' value='".$TxtCodigo."'>";	  
		  ?>
        <tr>
          <td class="formulario">Nombres</td>
          <td><?php echo $TxtNombres;?></td>
        </tr>
        <?php
		  	}
		  ?>
        <tr>
          <td class="formulario">Tipo Operador</td>
          <td><?php
			echo "<select name='CmbTipo' style='width:300' onchange=Recarga('".$Proceso."')>";
			echo "<option value='-1'>Seleccionar</option>";
			$Consulta1="SELECT cod_subclase,nombre_subclase FROM proyecto_modernizacion.sub_clase ";
			$Consulta1.=" WHERE cod_clase='6004' AND cod_subclase='2' ORDER BY nombre_subclase";			
			$Resultado1=mysqli_query($link, $Consulta1);
			while ($Fila1=mysqli_fetch_array($Resultado1))
			{
				if ($CmbTipo==$Fila1["cod_subclase"])			
					echo "<option value=".$Fila1["cod_subclase"]." selected>".ucfirst(strtolower($Fila1["nombre_subclase"]))."</option>";
				else
					echo "<option value=".$Fila1["cod_subclase"].">".ucfirst(strtolower($Fila1["nombre_subclase"]))."</option>";
			}
			echo "</select>";
			?>
          </td>
        </tr>
		
        <tr>
          <td width="96" class="formulario">Rut</td>
          <td width="336">
			<?php
			if($Proceso=='M'){
				echo $TxtCodigo;
			}else{
					$Consulta="SELECT distinct t1.rut,t1.apellido_paterno,t1.apellido_materno,t1.nombres from proyecto_modernizacion.funcionarios t1 inner join ";
					$Consulta.="proyecto_modernizacion.sub_clase t2 on t2.cod_clase='6002' and t1.rut=t2.nombre_subclase where t2.valor_subclase1='".$CmbTipo."' order by apellido_paterno";
					$Resultado=mysqli_query($link, $Consulta);
					$In=""; //agaregado por wilmer
					while ($Fila=mysqli_fetch_array($Resultado))
						$In=$In."'".$Fila["rut"]."',";
					 if($In !='')
						$In=substr($In,0,strlen($In)-1);
					//echo $Consulta."<br>";								
					echo "<select name='CmbRut' style='width:320'>";
					echo "<option value='-1'>Seleccionar</option>";					
					$Consulta1="select distinct t1.rut,t1.apellido_paterno,t1.apellido_materno,t1.nombres from proyecto_modernizacion.funcionarios t1 ";
					$Consulta1.="where t1.rut not in($In) order by t1.apellido_paterno";
					//echo "<br>CONSULTA:".$Consulta1;					
					$Resultado1=mysqli_query($link, $Consulta1);
					while ($Fila1=mysqli_fetch_array($Resultado1))
					{
						if(strlen($Fila1["rut"])==9)
							$Rut='0'.$Fila1["rut"];	
						else
							$Rut=$Fila1["rut"];		

						$Nombre=ucfirst(strtolower($Fila1["apellido_paterno"]))." ".ucfirst(strtolower($Fila1["apellido_materno"]))." ".ucfirst(strtolower($Fila1["nombres"]));
						if ($CmbRut==$Fila1["rut"])			
							echo "<option value='".$Fila1["rut"]."' selected>".$Rut."-".strtoupper($Nombre)."</option>";
						else
							echo "<option value='".$Fila1["rut"]."'>".$Rut."-".strtoupper($Nombre)."</option>";
					}
					echo "</select>";  
			}	
			  //echo 	$In."<br>";
			  // echo $Consulta1."<br>";	
  			?>
          </td>
        </tr>
      </table>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" class="TablaInterior">
          <tr>
            <td  align="center" width="465"><a href="JavaScript:Grabar('<?php echo $Proceso;?>','<?php echo $Valores;?>')"><img src="archivos/btn_guardar.png" width="29" height="26" border="0" /></a>&nbsp; <a href="JavaScript:Salir()"><img src="archivos/btn_salir.png" width="25" height="25" border="0" alt="Cerrar" align="absmiddle" /></a> &nbsp; </td>
          </tr>
        </table>
      <p>&nbsp;</p></td>
      <td width="1%" background="archivos/images/interior/derecho.png"></td>
    </tr>
    <tr>
      <td width="1%"><img src="archivos/images/interior/esq1.png"></td>
      <td background="archivos/images/interior/abajo.png"><img src="archivos/images/interior/transparent.gif"></td>
      <td width="1%"><img src="archivos/images/interior/esq4.png"/></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
	if ($EncontroCoincidencia!="")
	{
		if ($EncontroCoincidencia==true)
		{
			echo "<script languaje='javascript'>";
			echo "var Frm=document.FrmProceso;";
			echo "alert('Codigo ya fue Ingresado');";
			echo "Frm.TxtCodigo.focus();";
			echo "</script>";
		}
	}
?>
