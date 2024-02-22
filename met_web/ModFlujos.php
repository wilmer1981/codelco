<?php
	switch($ValorRadio)
	{
		case 'FUNDICION':
			$EstRadio1='checked';
			$EstRadio2='';
			$EstRadio3='';
			break;			
		case 'RAF':
			$EstRadio1='';
			$EstRadio2='checked';
			$EstRadio3='';
			break;	
		case 'REF':
			$EstRadio1='';
			$EstRadio2='';
			$EstRadio3='checked';		
			break;
		default:
			$EstRadio1='checked';
			$EstRadio2='';
			$EstRadio3='';
			break;			
	}		
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" type="text/css" href="../principal/estilos/css_principal.css">
</head>

<script language="javascript">
function Buscar()
{	
	var f=document.form1;
	
	var VRadio='';

	if(f.radio[0].checked==true)
		VRadio=f.radio[0].value;
	else if(f.radio[1].checked==true)
		VRadio=f.radio[1].value;	
	else if(f.radio[2].checked==true)
		VRadio=f.radio[2].value;	
			
	f.action="ModFlujos.php?buscarOPT=S&ValorRadio="+VRadio ;
	//f.action="ModFlujos.php?buscarOPT=S" ;
	f.submit();		
}

function VolverBalance()
{
	var f=document.form1;
	f.action='../met_web/BalanceDF.php';
	f.submit();
}

function Salir()
{
	var f=document.form1;
	f.action='../principal/sistemas_usuario.php?CodSistema=25&Nivel=1&CodPantalla=2';
	f.submit();	
}

function popUp(URL)
 {
day = new Date();
id = day.getTime();
//eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=1280,height=1024');");
       	window.open("ModEliminar.php", "","menubar=no resizable=no Top=50 Left=200 width=1280 height=1024 scrollbars=no");

}

function popUp(URL,Datos) 
{
	URL='ModEliminar.php?Valores='+Datos;
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=170,left = 212,top = 284');");
}

</script>
<body>
<form name="form1" method="post" action="">
<?php
	include("../principal/encabezado.php");
	include("conectar.php");
?>
  <table width="770" height="330" border="0" class="TablaPrincipal">
    <tr>
      <td align="center" valign="top">&nbsp;

      <table width="448" border="1" align="center">
        <tr class="Detalle03">
          <td colspan="3"><div align="center">Modificar - Eliminar Flujos </div></td>
          </tr>
        <tr>
          <td width="133"><div align="center">
                <input name="radio" type="radio" value="FUNDICION" <? echo $EstRadio1?> >
            Fundicion</div></td>
          <td width="137"><div align="center">
                <input name="radio" type="radio" value="RAF" <? echo $EstRadio2?> >
            RAF</div></td>
          <td width="156"><div align="center">
                <input name="radio" type="radio" value="REF" <? echo $EstRadio3?> >
            Refineria Electrolitica </div></td>
          </tr>
        <tr>
          <td colspan="3"><div align="center">
            <input name="BtnSalir" type="button" id="Button" value="Buscar" onClick="Buscar()">
            <input type="hidden" name="Modificar" value="Modificar" onClick="javascript:popUp('Modificar.php')" >
            <input type="button" name="BtnVolver" value="Ir a Balance" onClick="VolverBalance()">
            <input type="button" name="BtnSalir" value="Salir" onClick="Salir()">
          </div></td>
		  </tr>
	  </table>
	
	<?php
		if($buscarOPT=="S")
		{
		    $Arreglo=array('E','S');
			for($k=0;$k<2;$k++)
			{
				echo "<br>";$i=0;		
				$consulta1="Select distinct grupo from item where item.proceso='$radio' and item.ent_sal='$Arreglo[$k]'";
				$resultado1=mysql_query($consulta1);
				while($fila1=mysql_fetch_array($resultado1))
				{
					echo "<table width='390' border='1' align='center'>";
					echo "<tr bgcolor='#FFFFCC'>";
					echo "<td width='300' align='center'><strong>Grupo: ".$fila1["grupo"]."</strong> </td>";
					echo "<td width='70' align='center'><strong>Flujo (s) Asociados</strong></td>";
					echo "<td width='70' align='center'><strong>Seleccionar</strong></td>";
					echo "</tr>";
					// seleccionar cod_item y nom_item de todos los items pertenecientes a un grupo en particular 
					$consulta2="Select cod_item, nom_item from item where item.proceso='$radio' and item.ent_sal='$Arreglo[$k]' and item.grupo='$fila1["grupo"]'";
					$resultado2=mysql_query($consulta2);					
					while($fila2=mysql_fetch_array($resultado2))
					{					
						// determinar el N de flujo para un item en particular
						$consulta3="Select flujo from flujoitem where flujoitem.cod_item='$fila2[cod_item]' ";
						$resultado3=mysql_query($consulta3);					
						while($fila3=mysql_fetch_array($resultado3))
						{
							echo "<tr>";
							if($aux!=$fila2[nom_item])
							{
								echo "<td width='300'><strong>".$fila2[nom_item]."</strong></td>";
							}else{
								echo "<td width='300' align='right'> + </td>";
							}
							$aux=$fila2[nom_item];
							$elFlujo=$i;
							$modificar=$i;
							$datos=$aux."~".$fila3["flujo"]."~".$fila2[cod_item]."~".$radio;
							echo "<td width='50'><input name='".$elFlujo."' type='text' value='".$fila3["flujo"]."' size='12' disabled></td>";						 
							//echo "<td width='50'><input name='radiobutton' type='radio' value='".$modificar."' onclick='Habilitar($elFlujo)'></td>";
							echo "<td width='50' align='center'><input name='radiobutton' type='radio' value='$datos' onclick=\"popUp('','$datos')\"></td>";
							//echo "<td width='50'> Modificar</td>";
							//echo "<td width='50'>".$fila3["flujo"]."</td>";						
							echo "</tr>";
							$i++;		
						}										
					}	
					echo "<br>";				
				}
				echo "</table>";
				
				
			}
		}
	?>	  </td>
    </tr>
  </table>
<?
	include("cerrarconexion.php");
	include("../principal/pie_pagina.php");
?>
</form>
</body>
</html>
