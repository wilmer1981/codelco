<?php 
	$CodigoDeSistema=99;
	$CodigoDePantalla=6;
	
	include("conectar_principal.php");

	if(isset($_GET["Proceso"])){
		$Proceso = $_GET["Proceso"];
	}else{
		$Proceso = "";
	}

	$consulta="SELECT * from funcionarios where rut='".$CookieRut."'";
	$result=mysqli_query($link, $consulta);
	while ($row=mysqli_fetch_array($result))
	{
		$nombre = strtoupper(substr($row["nombres"],0,1)).". ".ucwords(strtolower($row["apellido_paterno"]));
	}
?>
<html>
<head>
	<title>Sistemas Informaticos Locales</title>
<link href="estilos/css_principal.css" type="text/css" rel="stylesheet">

<Script language="JavaScript">
function Enviar(forma,proceso)
{
	if (proceso == 1)
	{
		if (forma.mensaje.value == '')
		{
			alert ("Debe Ingresar Texto para Grabar");
			forma.mensaje.focus();
			return;
		}
		else
		{
			forma.action = 'mensajes01.php?Proceso=Ingresar';
			forma.submit();
		}
	}
	if (proceso == 2)
	{
		var checkeado=0;
        for (i=0;i<forma.length;i++)
        {
            if ((forma.elements[i].name=="id") && (forma.elements[i].checked))
            {
                checkeado=1;
                var cont=i;
            }
        }
        if (checkeado==0)
        {
            alert("Debe seleccionar un Registro para Eliminar");
            return ;
        }
        forma.action='mensajes01.php?Proceso=Eliminar&NumMensaje=' + forma.elements[cont].value;
        forma.submit ();
	}
}

function Salir()
{
	frm_principal.action = "mensajes01.php?Proceso=S";
	frm_principal.submit();
}
function Actualiza()
{
	frm_principal.action = "mensajes01.php?Proceso=A";
	frm_principal.submit();
}
function IdUsuario()
{
	frm_principal.action = "mensajes01.php?Proceso=IdUsuario";
	frm_principal.submit();
}
function Funcionarios()
{
	//var Frm=document.FrmProceso;
	frm_principal.action ="mensajes01.php?Proceso=Func";
	frm_principal.submit();
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">

body {
	margin-left: 3px;
	margin-top: 3px;
	margin-right: 0px;
	margin-bottom: 0px;
}

</style></head>
<body>
<form name="frm_principal" action="" method="post">
<?php include("encabezado.php");?>
  <table width="770" border="0" cellspacing="0" cellpadding="3" class="TablaPrincipal">
    <tr>
      <td height="316" align="center" valign="top"><select name="Mes">
        <?php
			$Meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");				
		 	for($i=1;$i<=12;$i++)
		  	{
				if (!isset($Mes))
				{
					if ($i == date("n"))
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";
				}
				else
				{
					if ($i == $Mes)
						echo "<option selected value ='".$i."'>".$Meses[$i-1]." </option>";
					else	
						echo "<option value ='".$i."'>".$Meses[$i-1]." </option>";						
				}				
			}		  
		?>
      </select>
        <select name="Ano" size="1">
          <?php
			for ($i=date("Y")-1;$i<=date("Y")+1;$i++)
			{
				if (!isset($Ano))
				{
					if ($i == date("Y"))
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";
				}
				else
				{
					if ($i == $Ano)
						echo "<option selected value ='".$i."'>".$i." </option>";
					else	
						echo "<option value ='".$i."'>".$i." </option>";						
				}				
			}		
		?>
        </select>        <br> 
        <?php 
	if (($Proceso != 1) && ($Proceso != 2) && ($Proceso != 3))
	{		
		echo "<table width='50%' border=1 cellspacing=1 cellpadding=2 align='center' class='TablaDetalle'>\n";
		  echo "<tr class='ColorTabla01'>\n";
		    echo "<td align='center'><a href='mensajes.php?Proceso=1'><font color='white'>Ingresar<font></a></td>\n";
		    echo "<td align='center'><a href='mensajes.php?Proceso=2'><font color='white'>Eliminar<font></a></td>\n";
			echo "<td align='center'><a href='mensajes.php?Proceso=3'><font color='white'>Consultar<font></a></td>\n";
		  echo "</tr>\n";
		echo "</table>\n";
	}
	echo "<br>\n";
	if ($Proceso == 1)
	{
	echo "<br><strong>Ingreso de Mensajes</strong><br>\n";
    echo "<br>\n";
  	echo "<table width='80%' border=1 cellspacing=1 cellpadding=2 align='center'>\n";
    	echo "<tr>\n";
      		echo "<td><div align='left'><b>Mensaje / Informaci&oacute;n:</b></td>\n";
			echo "<td width='66%' valign='top'><textarea name='mensaje' cols=70 rows=7></textarea></td>\n";
	  echo "</tr>\n";
	echo "</table>\n";
  	echo "<br>\n";
    echo "<br>\n";
    echo "<input type='button' value='Ingresar' onclick='JavaScript: Enviar(this.form,1)' style='width:70px;'>\n";
	}
	// ELIMINAR MENSAJES
	if ($Proceso == 2)
	{
    echo "<br>\n";
	echo "<strong>Eliminaci&oacute;n Mensajes</strong><br>\n";
    echo "<br>\n";
  	echo "<table width='720' border=1 cellspacing=0 cellpadding=3 class='TablaDetalle'>\n";
    echo "<tr class='Colortabla01'>\n";
		echo "<td width='70' align='center'><input type='button' value='Eliminar' onclick='JavaScript: Enviar(this.form,2)'></td>\n";
      	echo "<td width='100'>Fecha</td>\n";
      	echo "<td width='120'>Funcionario</td>\n";
      	echo "<td width='430'>Mensaje</td>\n";
    echo "</tr>\n";
	$Encontro = 'NO';
	$consulta = "Select * from mensajes Order by fecha desc";
	$result = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($result))
	{
		$Encontro = 'SI';
  		echo "<tr>\n";
			echo "<td align='center'><input type='radio' name='id' value='".$row["numero_mensaje"]."'></td>\n";
	    	echo "<td align='center'>".$row["fecha"]."</td>\n";
			$consulta_fun = "select * from funcionarios where rut = '".$row["funcionario"]."'";
			$result_fun = mysqli_query($link, $consulta_fun);
			while ($row_fun = mysqli_fetch_array($result_fun))
			{
				echo "<td align='left'>".strtoupper(substr($row_fun["nombres"],0,1)).". ".ucwords(strtolower($row_fun["apellido_paterno"]))."</td>\n";
			}	    	
    		echo "<td align='left'>".$row["mensaje"]."</td>\n";
	  	echo "</tr>\n";
	}
	if ($Encontro == 'NO')
  	{
  		echo "<tr>\n";
			echo "<td>&nbsp;</td>\n";
	    	echo "<td>&nbsp;</td>\n";
	    	echo "<td>&nbsp;</td>\n";
    		echo "<td>&nbsp;</td>\n";
	  	echo "</tr>\n";
  	}
	echo "</table>\n";
	echo "<br><br>";
	}
	//CONSULTAR
	if ($Proceso == 3)
	{
    echo "<br>\n";
	echo "<strong>Consulta de Mensajes</strong><br><br>\n";
  	echo "<table width='720' border=1 cellspacing=0 cellpadding=3 class='TablaDetalle'>\n";
    echo "<tr class='ColorTabla01'>\n";		
      	echo "<td width='100'>Fecha</td>\n";
      	echo "<td width='120'>Funcionario</td>\n";
      	echo "<td width='500'>Mensaje</td>\n";
    echo "</tr>\n";
	$Encontro = 'NO';
	$consulta = "SELECT * from mensajes Order by fecha desc";
	$result = mysqli_query($link, $consulta);
	while ($row = mysqli_fetch_array($result))
	{
		$Encontro = 'SI';
  		echo "<tr>\n";			
	    	echo "<td align='center'>".$row["fecha"]."</td>\n";
			$consulta_fun = "SELECT * from funcionarios where rut = '".$row["funcionario"]."'";
			$result_fun = mysqli_query($link, $consulta_fun);
			while ($row_fun = mysqli_fetch_array($result_fun))
			{
				echo "<td>".strtoupper(substr($row_fun["nombres"],0,1)).". ".ucwords(strtolower($row_fun["apellido_paterno"]))."</td>\n";
			}	    	
    		echo "<td>".$row["mensaje"]."</td>\n";
	  	echo "</tr>\n";
	}
	if ($Encontro == 'NO')
  	{
  		echo "<tr>\n";
	    	echo "<td width=20%>&nbsp;</td>\n";
	    	echo "<td width=20%>&nbsp;</td>\n";
    		echo "<td width=20%>&nbsp;</td>\n";
	  	echo "</tr>\n";
  	}
	echo "</table>\n";
	echo "<br><br>";
	}
  ?>
<input name="BtSalir" type="button" id="BtSalir" value="Salir" onClick="Salir();" style="width:70px;">
<!--<input name="BtIdUsuario" type="button" id="BtIdUsuario" value="IdUsuario" onClick="IdUsuario();" style="width:70px;">-->
<input name="BtSalir" type="button" id="BtSalir" value="NO APRETAR" onClick="Actualiza();" style="width:70px;">
<!--<input name="BtnFuncionario" type="button" id="BtnFuncionario" value="Funcionarios" onClick="Funcionarios();">->      </td>
    </tr>
  </table>
  <?php include("pie_pagina.php");?>
  </center>
</form>
</body>
</html>
