<?php include("../principal/conectar_ref_web.php");
	$Diah = date("d");
	$Mesh = date("n");
	$Anoh = date("Y");
	$fechah=$Anoh.'-'.$Mesh.'-'.$Diah;
	//echo $fechah;

    $consulta="select * from proyecto_modernizacion.funcionarios where rut='".$CookieRut."'  ";
	$rss = mysqli_query($link, $consulta);
	$rows = mysqli_fetch_array($rss);
    $nombre=$rows["nombres"]." ".$rows["apellido_paterno"]." ".$rows["apellido_materno"];
	if ($Proceso2=="MM")
	{
		$Datos=explode("~~",$Valores);
		$numdatos=count($Datos);	
		for ($i=0;$i<$numdatos;$i++)
		{
			$dato1=$Datos[$i];
			$valor=split('[%]',$dato1);
			$l = strlen($valor[1]);
			if ($l > 2)
			{
			  	$revisa ="Select * from ref_web.requrimiento where cod_novedad = '".$valor[0]."'";
				$resp=mysqli_query($link, $revisa);
				if ($row2 = mysqli_fetch_array($resp))
				{
					$actualice="UPDATE ref_web.requrimiento set atencion = '".$valor[1]."', fecha = '".$fechah."',usuario = '".$nombre."'";
					$actualice.=" where cod_novedad = '".$valor[0]."'";
					mysqli_query($link, $actualice);
				}
				else
				{
					$inserta="insert into ref_web.requrimiento (cod_novedad, atencion, fecha, usuario)";
					$inserta.=" values('".$valor[0]."','".$valor[1]."','".$fechah."','".$nombre."')";
					mysqli_query($link, $inserta);
				}			  
			}
      }
      $Datos2=explode("~~",$Valores2);
	  $num=count($Datos2);	
	
	  for ($i=0;$i<$num;$i++)
	  {
		$revisa ="Select * from ref_web.requrimiento where cod_novedad = '".$Datos2[$i]."'";
		$resp=mysqli_query($link, $revisa);
		if ($row2 = mysqli_fetch_array($resp))
			{
				$delete="delete from ref_web.requrimiento  where cod_novedad = '".$Datos2[$i]."'";
				mysqli_query($link, $delete);
			}
      }
  }
	header ("location:ref_informe_mantencion_resp.php?fecha=".$fechah);

?> 		
