// JavaScript Document
//funcion que vuelve al menu principal del sistema
function salir()
{
	document.forms[0].action="../principal/sistemas_usuario.php?CodSistema=18";
	document.forms[0].submit();
}

//funcion que verifica si un popup esta abierto
function verificar_popup(popup)
{
	if(popup)
	{
		if(!popup.closed)
			popup.close();
	}
}