Attribute VB_Name = "Module1"
Global Conexion As New ADODB.Connection
Global Rs1 As New ADODB.Recordset
Global Rs2 As New ADODB.Recordset
Global Rs3 As New ADODB.Recordset
Global Rs4 As New ADODB.Recordset
Global Rs5 As New ADODB.Recordset
Global Consulta As String
Global Insertar As String
Public Sub Conectar()
'cambia conexion catodo por SecWeb cuando sea manual
Conexion.ConnectionString = "Provider=MSDASQL.1;Persist Security Info=False;Data Source=catodo"
Conexion.Open
End Sub

Public Sub Desconectar()
Conexion.Close
End Sub
