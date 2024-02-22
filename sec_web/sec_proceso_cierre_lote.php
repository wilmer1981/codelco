<?php 	include("../principal/conectar_sec_web.php");	
	$Matriz=explode('-',$_GET["NroBulto"]);	
	$CodBulto=$Matriz[0];
	$NumBulto=$Matriz[1];
	$Anio=$_GET["Anio"];
		$MensajeAux="";
	$Consulta ="Select * from lote_catodo where cod_bulto = '".$CodBulto."' AND num_bulto= '".$NumBulto."' and year(fecha_creacion_lote)='".date('Y')."'  and cod_estado='a'";
	$Mensaje='Proceso realizado correctamente. favor de cerrar mensaje';
	$Respuesta4=mysqli_query($link, $Consulta);
	if ($Fila4=mysqli_fetch_array($Respuesta4))
	{	
		$ConsultaGuiaNula="SELECT * FROM guia_despacho_emb WHERE cod_bulto ='".$CodBulto."' AND num_bulto='".$NumBulto."' AND Year(fecha_guia)='".date('Y')."' AND cod_estado<> 'A'";
		$Respuesta2=mysqli_query($link, $ConsultaGuiaNula);
		if ($Fila2=mysqli_fetch_array($Respuesta2))
		{
			$Mensaje="<strong><font color='#CE0000' size=+1>Debe ANULAR la Gu�a (".$Fila2['num_guia'].") que hace referencia al Lote $CodBulto-$NumBulto del año ".date('Y')." <br><br> Antes de Continuar</font></strong>";
		}
		else
		{
			ProcesarCierre();
		}
	}
	else
	{
		ProcesarCierre();	
	}
	
	function ProcesarCierre()
	{
		global $CodBulto;
		global $NumBulto;
		global $MensajeAux;
			//Consulto por los embarque_ventana antes del año actual
			$Consulta3 ="Select cod_bulto,num_bulto,corr_enm,year(fecha_embarque) as Anio,bulto_paquetes,bulto_peso,despacho_paquetes,despacho_peso from  embarque_ventana where cod_bulto = '".$CodBulto."' AND num_bulto= '".$NumBulto."' and year(fecha_embarque) < '".date('Y')."'";
			$Respuesta3=mysqli_query($link, $Consulta3);
			while ($Fila3=mysqli_fetch_array($Respuesta3))
			{
				$MensajeAux=$MensajeAux."<tr><td>".$Fila3[Anio]."</td><td>".$Fila3["corr_enm"]." </td><td>".$Fila3["cod_bulto"]."-".$Fila3["num_bulto"]."</td><td aling='center'>".$Fila3["bulto_paquetes"]."</td><td aling='right'>".$Fila3["bulto_peso"]."</td><td aling='center'>".$Fila3[despacho_paquetes]."</td><td aling='center'>".$Fila3[despacho_peso]."</td></tr>";
				
				//Consulto por el lote para obtenet los paquetes y dejar los paquetes cerrados.
				$Consulta2=" select * from  lote_catodo  WHERE cod_bulto = '".$Fila3["cod_bulto"]."' AND num_bulto = '".$Fila3["num_bulto"]."' AND corr_enm = '".$Fila3["corr_enm"]."'";
				$Respuesta2=mysqli_query($link, $Consulta2);
				while ($Fila2=mysqli_fetch_array($Respuesta2))
				{
					//Actualizo el Paquete con estado Cerrado
					$Actualizar=" UPDATE paquete_catodo set cod_estado='c' WHERE cod_paquete = '".$Fila2["cod_paquete"]."' AND num_paquete = '".$Fila2["num_paquete"]."' AND fecha_creacion_paquete = '".$Fila2[fecha_creacion_paquete]."'";
					mysqli_query($link, $Actualizar);	
				//	echo "Actualizar ".$Actualizar."<br>";
				}
				//Actualizo el Lote con estado Cerrado
				$Actualizar=" UPDATE lote_catodo set cod_estado='c' WHERE cod_bulto = '".$Fila3["cod_bulto"]."' AND num_bulto = '".$Fila3["num_bulto"]."' AND corr_enm = '".$Fila3["corr_enm"]."'";
			//	echo "Actualizar Lote  ".$Actualizar."<br>";
				mysqli_query($link, $Actualizar);
			}		
			//Igualo los pesos para los embarques_ventana  anteriores al a�o actual	
			$Actualizar="UPDATE embarque_ventana set despacho_paquetes=bulto_paquetes,despacho_peso=bulto_peso WHERE cod_bulto = '".$CodBulto."' AND num_bulto = '".$NumBulto."'  and year(fecha_embarque) < '".date('Y')."'";
			mysqli_query($link, $Actualizar);
		
			$Actualizar="UPDATE embarque_ventana set despacho_paquetes=0,despacho_peso=0 WHERE cod_bulto = '".$CodBulto."' AND num_bulto = '".$NumBulto."' and year(fecha_embarque) = '".date('Y')."'";
			mysqli_query($link, $Actualizar);
			//	echo "Actualizar ".$Actualizar."<br>";
	
	}
	
?>
<link href="../principal/estilos/css_cal_web.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<table width="370" height="190" border="0" cellpadding="0" cellspacing="0" class="TablaPrincipal" >
<tr><td align="center">
<?php echo $Mensaje; ?>
      </td></tr>
      
      <tr><td valign="top">
<?php
if($MensajeAux!='')
	$MensajeAux="<table bordercolor='#b26c4a' class='TablaDetalle' border=0 width=100% ><tr class='ColorTabla01'><td  aling='center' >A&ntilde;o</td><td  aling='center' >I.E.</td><td  aling='center' >Lote</td><td  aling='center' >Paquete</td><td  aling='center' >Peso</td><td  aling='center' >Paquete Desp.</td><td  aling='center' >Peso Desp.</td></tr>".$MensajeAux."</table>";
 echo $MensajeAux; ?>
      </td></tr>
      
            <tr><td align="center">
   <input name="BtnCerrar" type="button" id="BtnCerrar" style="width:60" onClick="window.close()" value="Cerrar">
			
      </td></tr>
      </table>
