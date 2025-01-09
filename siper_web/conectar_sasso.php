<?php
     include_once('../principal/config.inc.php');
	//$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD);
	//mysql_select_db("sgrv", $link);
	
	$link = mysqli_connect(CONEXION_HOST_BD,CONEXION_HOST_USER,CONEXION_HOST_PWD,"sgrv") or die ("Error al conectar con el servidor");
	
	$CookieRut   = isset($_COOKIE['CookieRut'])?$_COOKIE['CookieRut']:"";
	if ($CookieRut!="")
	{
		/*$DifFecha=0;
		$ConsultaPass = "select max(fecha_hora) as fecha_hora from proyecto_modernizacion.control_acceso ";
		$ConsultaPass.= " where rut='".$CookieRut."' and sistema='0'";
		$RespPass=mysqli_query($link,$ConsultaPass);
		if ($FilaPass=mysqli_fetch_array($RespPass))
		{
			$Fecha1 = $FilaPass["fecha_hora"];
			$Fecha2 = date("Y-m-d H:i:s");
			$DifFecha=0;
			//echo $Fecha1."<br>";
			$AnoAux=substr($Fecha1,0,4);
			$MesAux=substr($Fecha1,5,2);
			$DiaAux=substr($Fecha1,8,2);
			$HoraAux=substr($Fecha1,11,2);
			$MinutoAux=substr($Fecha1,14,2);
			$SegundoAux=substr($Fecha1,17,2);
			//echo $Fecha2."<br>";
			$AnoAux2=substr($Fecha2,0,4);
			$MesAux2=substr($Fecha2,5,2);
			$DiaAux2=substr($Fecha2,8,2);
			$HoraAux2=substr($Fecha2,11,2);
			$MinutoAux2=substr($Fecha2,14,2);
			$SegundoAux2=substr($Fecha2,17,2);
			$Fecha1=mktime($HoraAux, $MinutoAux, 0, $MesAux, $DiaAux, $AnoAux);
			$Fecha2=mktime($HoraAux2, $MinutoAux2, 0, $MesAux2, $DiaAux2, $AnoAux2);
			$DifFecha=$Fecha2-$Fecha1;
			$Horas = intval($DifFecha / 3600); 
			$Min = intval(($DifFecha-$Horas*3600)/60); 
			$DifFechaHr = $Horas;
			$DifFechaMin = $Min;
			$ValidaTime=true;
			$ConsultaPass2="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'";
			$RespPass2=mysqli_query($link,$ConsultaPass2);			
			if ($FilaPass2=mysqli_fetch_array($RespPass2))
			{
				if ($FilaPass2["caduca"]=="N")
					$ValidaTime=false;
			}
			if (($DifFechaHr>0 && $ValidaTime==true) || ($DifFechaMin>60 && $ValidaTime==true))
			{
				echo "<script languaje='JavaScript'>";
				echo "top.location = '../principal/caducado.php?Fecha0=$FilaPass[fecha_hora]&Proceso=T_Fuera&DifFechaHr=$DifFechaHr&DifFechaMin=$DifFechaMin';";
				echo "</script>";
			}
			else
			{
				$ActualizaPass = "update proyecto_modernizacion.control_acceso set fecha_hora='".date("Y-m-d H:i:s")."' ";
				$ActualizaPass.= " where rut='".$CookieRut."' and sistema='0' and fecha_hora='".$FilaPass["fecha_hora"]."'";
				mysqli_query($link,$ActualizaPass);				
			}
		}*/	
	}
	else
	{
		echo "<script languaje='JavaScript'>";
		echo "top.location = '../index.php';";
		echo "</script>";
	}	
	
?>
