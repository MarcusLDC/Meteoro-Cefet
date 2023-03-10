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
$sql = "SELECT Estacao, Prec, Timestamp FROM tabela WHERE Timestamp >= DATE_SUB(NOW(), INTERVAL 30 MINUTE)";
$result = mysqli_query($con, $sql);

// Inicializa um array vazio para armazenar os totais de precipitação para cada estação
$precipitacao_por_estacao = array();

$intervalos = array(
    array("30 minutes ago", "Últimos 30 minutos"),
    array("1 hour ago", "Última 1 hora"),
    array("3 hours ago", "Última 3 horas"),
    array("12 hours ago", "Última 12 horas"),
    array("24 hours ago", "Últimas 24 horas"),
    array("48 hours ago", "Últimas 48 horas"),
    array("72 hours ago", "Últimas 72 horas")
);
// Loop pelos resultados da consulta
while ($row = mysqli_fetch_assoc($result)) {
    $estacao = $row['Estacao'];
    $timestamp = strtotime($row['Timestamp']);
    $prec = floatval($row['Prec']);

    // Adiciona a precipitação aos intervalos de tempo correspondentes
    foreach ($intervalos as $i => $intervalo) {
        if ($timestamp > $intervalo) {
            $precipitacao_total[$estacao][$i] += $prec;
        }
    }
}

// Formata os dados em um array que pode ser plotado em um gráfico de barras
$data = array(
    'labels' => array('Últimos 30 minutos', 'Última 1 hora', 'Última 3 horas', 'Última 12 horas', 'Últimas 24 horas', 'Últimas 48 horas', 'Últimas 72 horas'),
    'datasets' => array()
);


// Converte o array em um objeto JSON que pode ser utilizado na criação do gráfico
$json_data = json_encode($data);


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