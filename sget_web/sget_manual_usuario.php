<?
	echo "<script language='JavaScript'>";
	echo "window.open('Manual_Usuario_SGET.pdf','',top=30,toolbar=0,resizable=0,menubar=0,status=1,width=660,height=200,scrollbars=1);";
	echo "</script>";
?>
<html>
<head>
<title>Manual de Usuario</title>
<script language="JavaScript">

function Procesos(TipoProceso)
{
	var Frm = document.frmPrincipal;

	switch(TipoProceso)
	{
		case 'I'://IMPRIMIR
			Frm.BtnImprimir.style.visibility='hidden';
			window.print();
			Frm.BtnImprimir.style.visibility='';			
			break;
	}		
}
</script>
</head>
<body onLoad="document:location.href='Manual_Usuario_SGET.pdf  target='_blank'">
<form name="frmPrincipal" action="" method="post" >
<a href="Manual_Usuario_SGET.pdf"  target="_blank"><img src="imagenes/acrobat.png" alt='Manual de Usuario' width="25" height="25" border="0"></a>
</form>
</body>
</html>