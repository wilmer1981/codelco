	<html>
				<head>
					<script>
						setTimeout("reloj()",100);
						function reloj()
						{
							var tiempo=new Date();
							var hora=tiempo.getHours();
							var minuto=tiempo.getMinutes();
							var segundo=tiempo.getSeconds();
							var textohora=hora+":"+minuto+":"+segundo;
							caja.value=textohora;
							setTimeout("reloj()",500);
						}
					</script>
				</head>

				<body>
					<input type="text" name="caja" size="10">
				</body>
<html>
