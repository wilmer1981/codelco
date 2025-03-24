<?php

$CodigoDeSistema = 2;
$CodigoDePantalla = 35;

$Proceso       = isset($_REQUEST["Proceso"])?$_REQUEST["Proceso"]:"";
$listados      = isset($_REQUEST["listados"])?$_REQUEST["listados"]:"";
$cmbmovimiento = isset($_REQUEST["cmbmovimiento"])?$_REQUEST["cmbmovimiento"]:"";
$cmblistados   = isset($_REQUEST["cmblistados"])?$_REQUEST["cmblistados"]:"";
$cmborigen = isset($_REQUEST["cmborigen"])?$_REQUEST["cmborigen"]:"";
$cmbrestos = isset($_REQUEST["cmbrestos"])?$_REQUEST["cmbrestos"]:"";
$cmbanodos = isset($_REQUEST["cmbanodos"])?$_REQUEST["cmbanodos"]:"";
$cmbtipo = isset($_REQUEST["cmbtipo"])?$_REQUEST["cmbtipo"]:"";
$cmbproducto = isset($_REQUEST["cmbproducto"])?$_REQUEST["cmbproducto"]:"";
$recargapag1= isset($_REQUEST["recargapag1"])?$_REQUEST["recargapag1"]:"";

?>

<html>
<head>
<title>Listado &Aacute;nodos Rechazados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<script language="JavaScript">

function listar_datos()
{
var f=formulario;

	if(f.cmbtipo.value == -1)
	 {  
	   alert("debe ingresar el tipo de producto");
	   f.cmbtipo.focus();
	   return
	 }

	if(f.cmbproducto.value == -1)
	 {  
	   alert("debe ingresar el producto");
	   f.cmbproducto.focus();
	   return
	 }

    f.action = "sea_listado_rechazos.php";
    f.submit()
}

function Recarga1(f)
{
	f.action = "sea_listador_rechazos.php?recargapag1=S&cmbtipo=" + f.cmbtipo.value;
	f.submit()
}

function salir_menu()
{
var f=formulario;
    f.action ="../principal/sistemas_usuario.php?CodSistema=2";
	f.submit();
}

</script>
</head>
<link href="../principal/estilos/css_sea_web.css" rel="stylesheet" type="text/css"></head>

<body>
<form name="formulario" method="post" action="">
  <?php include("../principal/encabezado.php")?>
  <?php include("../principal/conectar_principal.php") ?>
<table width="770" border="0" cellpadding="5" cellspacing="0" class="TablaPrincipal">
    <tr> 
      <td align="center" valign="middle">
  <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td width="98">Fecha Rechazo</td>
            <td colspan="3"> <SELECT name="dia_t" size="1" style="font-face:verdana;font-size:10">
                <?php      
			if($Proceso=='V' || $recargapag1=='S')
			{
    			for ($i=1;$i<=31;$i++)
				{
 				   if ($i==$dia_t)
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
			}
			else
			{
				for ($i=1;$i<=31;$i++)
				{
	   				   if ($i==date("j"))
						{
						echo "<option SELECTed value= '".$i."'>".$i."</option>";
						}
						else
						{						
					  echo "<option value='".$i."'>".$i."</option>";
						}		    		
 				}
		   }
		?>
              </SELECT> <SELECT  name="mes_t" size="1" id="SELECT" style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php	           
        $meses =array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");			
		if ($Proceso=='V' || $recargapag1=='S')
		{
		
		    for($i=1;$i<13;$i++)
		    {
                if ($i==$mes_t)
				{				
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
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
				echo "<option SELECTed value ='".$i."'>".$meses[$i-1]." </option>";
				}			
				else
				{
				echo "<option value='$i'>".$meses[$i-1]."</option>\n";
				}
		    }  			 
	    } 	  

    ?>
              </SELECT> <SELECT name="ano_t" size="1" id="SELECT2"  style="FONT-FACE:verdana;FONT-SIZE:10">
                <?php            
	if($Proceso=='V' || $recargapag1=='S')
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==$ano_t)
			{
			echo "<option Selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
        }
	}
	else
	{
	    for ($i=date("Y")-1;$i<=date("Y")+1;$i++)	
	    {
            if ($i==date("Y"))
			{
			echo "<option Selected value ='$i'>$i</option>";
			}
			else	
			{
			echo "<option value='".$i."'>".$i."</option>";
			}
         }   
    }
	?>
              </SELECT> </td>
          </tr>
          <tr> 
            <td width="98">Tipo Anodo</td>
            <td width="157"> 
              <?php
		    echo '<SELECT name="cmbtipo" id="cmbtipo" onChange="JavaScript:Recarga1(this.form)">';
           
			if ($cmbtipo == "-1")
				echo '<option value="-1" SELECTed>SELECCIONAR</option>';
			else 
				echo '<option value="-1">SELECCIONAR</option>';
		  	if ($cmbtipo == "1")
		  		echo '<option value="1" SELECTed>ANODOS CORRIENTE</option>';
			else 
				echo '<option value="1">ANODOS CORRIENTE</option>';
			if ($cmbtipo == "2")	
				echo '<option value="2" SELECTed>ANODOS HOJAS MADRES</option>';
			else 
				echo '<option value="2">ANODOS HOJAS MADRES</option>';
			if ($cmbtipo == "3")	
				echo '<option value="3" SELECTed>ANODOS ESPECIALES</option>';
			else 
				echo '<option value="3">ANODOS ESPECIALES</option>';							
		    ?>
            </td>
            <td width="83">Subproductos</td>
            <td> <SELECT name="cmbproducto">
                <option value="-1">SELECCIONAR</option>
                <?php
			include("../principal/conectar_principal.php");
				
				if ($cmbtipo == 1) //Corrientes
					$consulta = "SELECT valor_subclase1 AS valor FROM sub_clase WHERE cod_clase = 2002";
				else if ($cmbtipo == 2) //H. Madres
						$consulta = "SELECT valor_subclase2 AS valor FROM sub_clase WHERE cod_clase = 2002";
				else if ($cmbtipo == 3) //Especiales
						$consulta = "SELECT valor_subclase3 AS valor FROM sub_clase WHERE cod_clase = 2002";
					
				$rs = mysqli_query($link, $consulta);
				while ($row = mysqli_fetch_array($rs))
				{
					$consulta = "SELECT * FROM subproducto WHERE cod_producto = 17 AND cod_subproducto = '".$row["valor"]."'";
					$rs1 = mysqli_query($link, $consulta);					
					$row1 = mysqli_fetch_array($rs1);
					if ($row1["cod_subproducto"] == $cmbproducto)
						echo '<option value="'.$row1["cod_subproducto"].'" SELECTed>'.$row1["descripcion"].'</option>';
					else
						echo '<option value="'.$row1["cod_subproducto"].'">'.$row1["descripcion"].'</option>';									
				}
		?>
              </SELECT> </td>
          </tr>
        </table>
        <br> <table width="750" cellpadding="3" cellspacing="0" class="TablaInterior">
          <tr> 
            <td><div align="center"><font color="#000000"> 
			  <input name="listar" type="button" style="width:70" value="Listar" onClick="listar_datos();">&nbsp;
              <input name="salir" type="button" style="width:70" onClick="salir_menu();" value="Salir">
                </font></div></td>
          </tr>
        </table>
        
      </td>
    </tr>
  </table>
  <?php include("../principal/pie_pagina.php")?>  
</form>
</body>
</html>
