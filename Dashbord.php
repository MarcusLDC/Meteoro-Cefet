<!DOCTYPE html>
<html>
<head>
    <title>Visualização de Dados</title>
</head>
<body>

<h2>Período de Dados</h2>
<form action="" method="post">
    Data de Início: <input type="text" name="data_inicio" value="<?php if (isset($data_inicio)) echo $data_inicio; ?>"> (dd/mm/aaaa)<br><br>
    Data de Fim: <input type="text" name="data_fim" value="<?php if (isset($data_fim)) echo $data_fim; ?>"> (dd/mm/aaaa)<br><br>
    <input type="submit" name="submit" value="Exibir Dados">
</form>
<br><br>

<h2>Gráfico de Temperatura e Umidade</h2>
<div style="width:800px; height:400px;">
    <?php echo $grafico_linhas->render(); ?>
</div>
<br><br>

<h2>Gráfico de Precipitação</h2>
<div style="width:800px; height:400px;">
    <?php echo $grafico_barras->render(); ?>
</div>

</body>
</html>
<?php

// Conecte-se ao banco de dados
$dbname = "id17192650_estacaometeoro";
$username = "id17192650_estagiometeoro";
$password = "E5{V!%s<6_6#]9V8";
$host = "localhost";


$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

// Verifique se os dados do formulário foram enviados
if (isset($_POST["submit"])) {
    $data_inicio = $_POST["data_inicio"];
    $data_fim = $_POST["data_fim"];

    // Selecione os dados da tabela com o período selecionado
    $sql = "SELECT codigo, DataHora, TA, RH, PR1HS FROM info_esta WHERE DataHora BETWEEN '$data_inicio' AND '$data_fim'";
    $result = mysqli_query($conn, $sql);
} else {
    // Selecione todos os dados da tabela
    $sql = "SELECT codigo, DataHora, TA, RH, PR1HS FROM info_esta ORDER BY DataHora DESC LIMIT 10000";
    $result = mysqli_query($conn, $sql);
}

// Armazene os dados em arrays separados para cada série
$data_hora = array();
$temperatura = array();
$umidade = array();
$precipitacao = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($data_hora, $row["DataHora"]);
        array_push($temperatura, $row["TA"]);
        array_push($umidade, $row["RH"]);
        array_push($precipitacao, $row["PR1HS"]);
    }
} else {
    echo "Não há dados na tabela.";
}

mysqli_close($conn);

// Inclua o arquivo de biblioteca de gráficos
include("lib/php-charts.php");

// Crie o gráfico de linhas
$grafico_linhas = new Charts();

$grafico_linhas->add_data_set($temperatura, "linha", "Temperatura");
$grafico_linhas->add_data_set($umidade, "linha", "Umidade");

$grafico_linhas->set_x_axis_title("Data e Hora");
$grafico_linhas->set_y_axis_title("Temperatura e Umidade");
$grafico_linhas->set_x_labels($data_hora);
$grafico_linhas->create("line");

// Crie o gráfico de barras
$grafico_barras = new Charts();

$grafico_barras->add_data_set($precipitacao, "bar", "Precipitação");

$grafico_barras->set_x_axis_title("Data e Hora");
$grafico_barras->set_y_axis_title("Precipitação");
$grafico_barras->set_x_labels($data_hora);
$grafico_barras->create("bar");

?>