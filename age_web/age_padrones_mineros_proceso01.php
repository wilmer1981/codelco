<?php
	include("../principal/conectar_principal.php");
	
	$Fecha=date('Y-m-d');
	$Proceso = isset($_REQUEST['Proceso']) ? $_REQUEST['Proceso'] : '';

	$CmbProveedor = isset($_REQUEST['CmbProveedor']) ? $_REQUEST['CmbProveedor'] : '';
	$TxtCodMina   = isset($_REQUEST['TxtCodMina']) ? $_REQUEST['TxtCodMina'] : '';
	$TxtDescripcion = isset($_REQUEST['TxtDescripcion']) ? $_REQUEST['TxtDescripcion'] : '';
	$CmbTipoFaena   = isset($_REQUEST['CmbTipoFaena']) ? $_REQUEST['CmbTipoFaena'] : '';
	$TxtSierra      = isset($_REQUEST['TxtSierra']) ? $_REQUEST['TxtSierra'] : '';
	$TxtComuna      = isset($_REQUEST['TxtComuna']) ? $_REQUEST['TxtComuna'] : '';
	$TxtFecha       = isset($_REQUEST['TxtFecha']) ? $_REQUEST['TxtFecha'] : '';
	$TxtFechaPadron = isset($_REQUEST['TxtFechaPadron']) ? $_REQUEST['TxtFechaPadron'] : '';
	$Valores = isset($_REQUEST['Valores']) ? $_REQUEST['Valores'] : '';

	switch ($Proceso)
	{
		case "N"://INGRESAR MINA/PLANTA
			$consulta = "select * from sipa_web.minaprv where rut_prv= '".$CmbProveedor."' and cod_mina = '".$TxtCodMina."'  ";
			$result = mysqli_query($link,$consulta);
			$cont = mysqli_num_rows($result);
			if($cont==0){
				$Insertar="insert into sipa_web.minaprv (rut_prv,cod_mina,nombre_mina,ind_faena,sierra,comuna,fecha_padron) values (";
				$Insertar.="'$CmbProveedor','$TxtCodMina','$TxtDescripcion','$CmbTipoFaena','$TxtSierra','$TxtComuna','".substr($TxtFechaPadron,0,8)."')";
				echo $Insertar;
				mysqli_query($link, $Insertar);
			}
			break;
		case "M"://MODIFICAR MINA/PLANTA
			$Modificar="UPDATE sipa_web.minaprv set nombre_mina='$TxtDescripcion',sierra='$TxtSierra', ";
			$Modificar.="comuna='$TxtComuna',ind_faena='$CmbTipoFaena',fecha_padron='".substr($TxtFechaPadron,0,8)."' where cod_mina='$TxtCodMina' and rut_prv='$CmbProveedor'";
			//echo $Modificar;
			mysqli_query($link, $Modificar);
			break;
		case "E"://ELIMINAR MINA/PLANTA
			$Datos=explode('//',$Valores);
			foreach($Datos as $c => $v)
			{
				$Datos2=explode('~',$v);
				$Eliminar ="delete from sipa_web.minaprv where cod_mina='$Datos2[1]' and rut_prv='$Datos2[0]'";
				//echo $Eliminar."<br>";
				mysqli_query($link, $Eliminar);
			}	
			break;
	}
	if ($Proceso=="E")
		header("location:age_padrones_mineros.php");
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "window.opener.document.FrmPadronMinero.action='age_padrones_mineros.php';";
		echo "window.opener.document.FrmPadronMinero.submit();";
		echo "window.close();";
		echo "</script>";
	}
?>