<?php
$host = "localhost";
$user = "id17192650_estagiometeoro";
$pass = "E5{V!%s<6_6#]9V8";
$db = "id17192650_estacaometeoro";
$con = mysqli_connect($host, $user, $pass, $db);
if (!$con) {
  die("Conexão falhou: " . mysqli_connect_error());
}

// Consulta SQL para recuperar os dados de precipitação para todas as estações
$sql = "SELECT Estacao, Prec, Timestamp FROM tabela";
$result = mysqli_query($con, $sql);

// Inicializa um array vazio para armazenar os totais de precipitação para cada estação
$precipitacao_por_estacao = array();

// Loop pelos resultados da consulta
while ($row = mysqli_fetch_assoc($result)) {
    // Extrai os valores de Estacao, Prec e Timestamp do resultado da consulta
    $estacao = $row["Estacao"];
    $precipitacao = $row["Prec"];
    $timestamp = strtotime($row["Timestamp"]);

    // Verifica em qual intervalo de tempo o registro se enquadra
    $agora = time();
    $delta = $agora - $timestamp;
    if ($delta <= 1800) {  // últimos 30 minutos
        $intervalo = "30 min";
    } elseif ($delta <= 3600) {  // última hora
        $intervalo = "1 hora";
    } elseif ($delta <= 10800) {  // últimas 3 horas
        $intervalo = "3 horas";
    } elseif ($delta <= 43200) {  // últimas 12 horas
        $intervalo = "12 horas";
    } elseif ($delta <= 86400) {  // últimas 24 horas
        $intervalo = "24 horas";
    } elseif ($delta <= 172800) {  // últimas 48 horas
        $intervalo = "48 horas";
	} elseif ($delta <= 259200) {  // últimas 72 horas
        $intervalo = "72 horas";
    }

    // Adiciona a precipitação ao total para a estação e o intervalo de tempo correspondente
    if (!isset($precipitacao_por_estacao[$estacao])) {
        $precipitacao_por_estacao[$estacao] = array(
            "30 min" => 0,
            "1 hora" => 0,
            "3 horas" => 0,
            "12 horas" => 0,
            "24 horas" => 0,
            "48 horas" => 0,
            "72 horas" => 0,
        );
    }
    $precipitacao_por_estacao[$estacao][$intervalo] += $precipitacao;
}

// Formata os resultados em um array que pode ser plotado em um gráfico de barras
$labels = array("30 min", "1 hora", "3 horas", "12 horas", "24 horas", "48 horas", "72 horas");
$dados = array();
foreach ($precipitacao_por_estacao as $estacao => $precipitacao) {
    $dados_estacao = array();
    foreach ($labels as $intervalo) {
        $dados_estacao[] = $precipitacao[$intervalo];
    }
    $dados[] = array(
        "label" => $estacao,
        "data" => $dados_estacao,
    );
}

// Converte os dados em formato JSON para que possa ser utilizado no JavaScript
$json_data = json_encode(array(
    "labels" => $labels,
    "datasets" => $dados,
));

// Fecha a conexão com o banco de dados
mysqli_close($con);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Gráfico de precipitação</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myChart"></canvas>
    <script>
        // Obtém os dados JSON gerados pelo código PHP
        var jsonData = <?php echo $json_data; ?>;
        
        // Cria um novo gráfico de barras utilizando a biblioteca Chart.js
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: jsonData,
            options: {
                responsive: true,
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>