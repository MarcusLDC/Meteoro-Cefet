<!-- Arquivo grafico.php -->
<?php

// Verifica se os dados foram enviados via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexão com o banco de dados
    
        $dbname = "id17192650_estacaometeoro";
        $username = "id17192650_estagiometeoro";
        $password = "E5{V!%s<6_6#]9V8";
// Conexão com o banco de dados
$conn = mysqli_connect("localhost", $username, $password, $dbname);
    
    // Verifica se a conexão foi bem-sucedida
    if (!$conn) {
        die("Conexão falhou: " . mysqli_connect_error());
    }
    
    // Query para selecionar os dados filtrados
    $query = "SELECT * FROM info_esta WHERE codigo IN ('" . implode("', '", $_POST['codigo']) . "') ORDER BY DataHora DESC LIMIT 3000";
    
    // Executa a query
    $result = mysqli_query($conn, $query);
    
    // Verifica se a query foi bem-sucedida
    if (!$result) {
        die("Query falhou: " . mysqli_error($conn));
    }
    
    // Armazena os dados em um array
    $dados = array();
    while ($linha = mysqli_fetch_assoc($result)) {
        $dados[] = $linha;
    }

    // Fecha a conexão com o banco de dados
mysqli_close($conn);
}
?>