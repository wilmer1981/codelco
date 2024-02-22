<?
include('conectar_ori.php');
include('funciones/siper_funciones.php');

?>
<html>
<head>
<title>Proceso de Inserci&oacute;n de Especificaciones</title>

<script language="javascript" src="funciones/funciones_java.js"></script>
<script language="javascript">
function Proceso(Opc)
{
	var f=document.FrmPrincipal;
	var Valor="";
	var Datos="";
	switch(Opc)
	{
		case "C":
				if(f.SelTarea.value!='')
				{					
					f.action='consulta_registro_historico_peligros.php?Pro=R&Buscar=S&NivelOrg='+f.SelTarea.value;
					f.submit();		
				}
				else
				{					
					f.action='consulta_registro_historico_peligros.php?Pro=R&Buscar=S';
					f.submit();		
				}
		break;
		case "S":
				window.location="../principal/sistemas_usuario.php?CodSistema=29";
		break;
	}	
}
</script>
<link href="estilos/siper_style.css" rel="stylesheet" type="text/css">
<form name="FrmPrincipal" method="post" action="">
<?
if($Clave=='abc321')
{
	$Consulta="SELECT CCONTACTO,CCONTROL,CAREA,CPELIGRO from sgrs_sipercontroles ";
	$Consulta.=" where CCONTROL='1' and CCONTACTO IN ('3', '9', '15', '16', '27', '26', '17', '31')";
	//$Consulta.=" where CCONTROL='1' and CCONTACTO IN ('31')";
	$Consulta.=" order by CCONTROL,CCONTACTO";
	//echo $Consulta;
	$Resultado=mysql_query($Consulta);$Cont=0;$Cont2=0;
	while ($Fila=mysql_fetch_array($Resultado))
	{
		/*$Consulta="SELECT CPELIGRO from sgrs_sipercontroles_obs ";
		$Consulta.=" where CCONTROL='".$Fila[CCONTROL]."' and CCONTACTO='".$Fila[CCONTACTO]."' and CAREA='".$Fila[CAREA]."' and CPELIGRO='".$Fila[CPELIGRO]."'";
		$Resultado2=mysql_query($Consulta);
		if($Fila2=mysql_fetch_assoc($Resultado2))
		{*/
			$Obs='';
			switch($Fila[CCONTACTO])
			{
				case "3"://Atrapamiento
					$Obs="ECF N&ordm; 8 Guardas y Protecciones de Equipos:<br><br>- Todo personal debe conocer los peligros y medidas de control con trabajo de equipos o partes m&oacute;viles.<br>		
					- No usar elementos susceptibles de ser atrapados.<br>		
					- Si por reparaci&oacute;n o mantenci&oacute;n deben ser retiradas las protecciones, al final del trabajo se deber&aacute;n reponer todas las protecciones y resguardos<br>		
					- Si el equipo o maquinaria se encuentra sin protecciones, se debe detener el equipo.<br>		
					- Todos los equipos, maquinas o sistemas con partes m&oacute;viles, deben disponer de protecciones y guardas.<br>		
					- Todos los equipos deben contar con sistema de detenci&oacute;n ante emergencia.<br>"; 			
				break;
				case "9"://Caida de altura
					$Obs="ECF N&ordm; 2 Trabajo en Altura F&iacute;sica:<br><br>- Presentar aptitudes t&eacute;cnicas, f&iacute;sicas, y psicol&oacute;gicas, evaluaci&oacute;n de salud vigente.<br>		
					- Personal para montaje de andamio debe estar entrenado.<br>		
					- Contar con procedimiento que regule trabajo en altura.<br>		
					- Sistemas de protecci&oacute;n contra caidas deben ser certificados.<br>		
					- Asegurar protecci&oacute;n de bordes y puntos de anclaje.<br>"; 			
				break;
				case "15"://Contacto con energía eléctrica
					$Obs="ECF N&ordm; 1 Aislaci&oacute;n, Bloqueo y Permiso de Trabajo:<br><br>-Presentar aptitudes t&eacute;cnicas, f&iacute;sicas, y psicol&oacute;gicas.<br>		
					- Para aislar y bloquear debe estar entrenado, registrado y autorizado.<br>		
					- Contar con un procedimiento que regule uso y aplicaci&oacute;n de bloqueos.<br>		
					- Las personas responsables del trabajo deben hacer personalmente los bloqueos.<br>		
					- Area debe documentar el inicio y t&eacute;rmino de toda intervenci&oacute;n, tanto de la instalaci&oacute;n como retiro.<br>		
					- Contar con permisos de trabajo especiales para intervenir equipos.<br>		
					- Los sistemas de bloqueos deber&aacute;n cumplir con ser personales y tener llaves unicas.<br>		
					- Todos los puntos de aislamiento y bloqueo deben estar identificados y reconocidos por el &aacute;rea.<br>		
					- Todos los elementos de bloqueo deben estar en buen estado.<br>"; 			
				break;
				case "16"://Contacto y/o exposición con temperaturas extremas
					$Obs="ECF N&ordm; 6 Materiales Fundidos:<br><br>- Presentar aptitudes, f&iacute;sicas, psicol&oacute;gicas y de salud vigente.<br>		
					- Trabajadores que desarrollen trabajos con materiales fundidos deben estar capacitados y autorizados.<br>		
					- Operadores de puente grua deben estar capacitados y autorizados.<br>		
					- Generar plan de transito personas y equipos.<br>		
					- Segregar los ambientes de trabajo, minimizando la interacci&oacute;n equipos pesados, livianos, materiales fundidos y personas.<br>		
					- Superficies con contacto de material fundido deben estar revestidas.<br>		
					- Colocarse barreras y se&ntilde;ales de advertencia sobre proyecci&oacute;n de material fundido.<br>"; 			
				break;
				case "17"://Contacto con sustancias químicas
					$Obs="ECF N&ordm; 9 Manejo de Sustancias Peligrosa:<br><br>- Trabajadores que transportan y manipulan sustancias peligrosas deben estar capacitados y autorizados.<br>		
					- Presentar aptitudes t&eacute;cnicas, f&iacute;sicas y psicol&oacute;gicas adecuadas.<br>		
					- Conocer y aplicar indicaciones de hoja de datos de seguridad.<br>		
					- Contar con procedimiento que regule ingreso, almacenamiento y manejo de sustancias peligrosas.<br>		
					- Disponer de sistemas de contencion local de derrames.<br>		
					- Tuberias de almacenamiento deben estar pintadas, identificadas o estampadas para identificacion y flujo.<br>		
					- Prohibici&oacute;n de fumar, comer y beber en lugares de manejo y almacenamiento de sustancias peligrosas.<br>		
					- Zonas de almacenamiento contar con sistema de control de incendios.<br>"; 			
				break;
				case "26"://Colisión de vehiculos o equipos móviles
					$Obs="ECF N&ordm; 3 Equipo Pesado y ECF N&ordm; 4 Veh&iacute;culo Liviano:<br><br>- Contar con plan de mantenimiento preventivo.<br>		
					- Sistema de control de licencias.<br>		
					- Contar con dispositivo detecci&oacute;n de fatiga y somnolencia.<br>		
					- Cu&ntilde;as para todos los equipos sobre neum&aacute;ticos.<br>		
					- Prohibido a los conductores abandonar el equipo mientras se encuentre el motor funcionando.<br>		
					- Numero de identificaci&oacute;n del vehiculo.<br>
					- Operadores capacitados, autorizados, con aptitudes t&eacute;cnicas, f&iacute;sicas y psicol&oacute;gicas.<br>                       
					- Aprobar curso manejo a la defensiva.<br>                    
					- Contar con un procedimiento que regule operaci&oacute;n de equipo pesado.<br>                               
					- Segregar los ambientes de trabajo, minimizando la interacci&oacute;n hombre-m&aacute;quina.<br>"; 			
				break;
				case "27"://Atropello
					$Obs="ECF N&ordm; 3 Equipo Pesado y ECF N&ordm 4 Veh&iacute;culo Liviano:<br><br>- Operadores capacitados, autorizados, con aptitudes tecnicas, fisicas y psicologicas.<br>		
					- Aprobar curso manejo a la defensiva.<br>		
					- Contar con un procedimiento que regule operaci&oacute;n de equipo pesado.<br>		
					- Segregar los ambientes de trabajo, minimizando la interacci&oacute;n hombre-maquina.<br>		
					- Contar con plan de mantenimiento preventivo.<br>		
					- Sistema de control de licencias.<br>		
					- Contar con dispositivo detecci&oacute;n de fatiga y somnolencia.<br>		
					- Cu&ntilde;as para todos los equipo sobre neum&aacute;ticos.<br>		
					- Prohibido a los conductores abandonar el equipo mientras se encuentre el motor funcionando.<br>		
					- Numero de identificaci&oacute;n del vehiculo.<br>"; 			
				break;
				case "31"://Incendio
					$Obs="ECF N&ordm; 12 Incendio:<br><br>- Conocer los sistemas de seguridad y protecci&oacute;n contra incendio de su &aacute;rea.<br>		
					- Cumplir protocolo de permiso de trabajo en caliente.<br>		
					- Disponer y mantener se&ntilde;alizaci&oacute;n de vias de evacuaci&oacute;n y salidas de emergencia.<br>		
					- Disponer de un mapa de riesgo de incendio.<br>		
					- Disponer de sistemas de extinci&oacute;n.<br>"; 			
				break;
				
			}
			$Insertar="INSERT INTO sgrs_sipercontroles_obs (CCONTACTO,CCONTROL,CAREA,CPELIGRO,TOBSERVACION) values ";	
			$Insertar.="('".$Fila[CCONTACTO]."','".$Fila[CCONTROL]."','".$Fila[CAREA]."','".$Fila[CPELIGRO]."','".$Obs."')";
			mysql_query($Insertar);
			//echo $Insertar."<br>";
			//$Cont++;
		/*}
		else
		{
		
		}*/
		$Cont2++;	
	}
	echo "Cantidad Total Contacto Peligro:".$Cont2;
	$Mensaje='Proceso Terminado';
}
else
{
	$Mensaje='Clave proceso Invalida';
}
?>
</form>
</body>
</html>
<?
echo "<script language='javascript'>";
if($Mensaje!='')
	echo "alert('".$Mensaje."');";
echo "</script>";
?>

