<?php
$host = "localhost";
$user = "id17192650_estagiometeoro";
$pass = "E5{V!%s<6_6#]9V8";
$db = "id17192650_estacaometeoro";
$con = mysqli_connect($host, $user, $pass, $db);
if (!$con) {
  die("Conexão falhou: " . mysqli_connect_error());
}

$sql = "SELECT * FROM tabela";
$result = mysqli_query($con, $sql);
?>

<?php
$now = time();
$intervalos = array(
    array("30 minutes ago", "Últimos 30 minutos"),
    array("1 hour ago", "Última 1 hora"),
    array("3 hours ago", "Última 3 horas"),
    array("12 hours ago", "Última 12 horas"),
    array("24 hours ago", "Últimas 24 horas"),
    array("48 hours ago", "Últimas 48 horas"),
    array("72 hours ago", "Últimas 72 horas")
);
$tempos = array();
foreach ($intervalos as $intervalo) {
    $inicio = strtotime($intervalo[0], $now);
    $fim = $now;
    $tempos[] = array($inicio, $fim, $intervalo[1]);
}
?>

<?php
$precipitacao_por_intervalo = array();
while ($row = mysqli_fetch_assoc($result)) {
    $timestamp = strtotime($row["Timestamp"]);
    $precipitacao = $row["Prec"];
    foreach ($tempos as $i => $intervalo) {
        if ($timestamp >= $intervalo[0] && $timestamp <= $intervalo[1]) {
            if (!isset($precipitacao_por_intervalo[$i])) {
                $precipitacao_por_intervalo[$i] = 0;
            }
            $precipitacao_por_intervalo[$i] += $precipitacao;
        }
    }
}
?>

<?php
$labels = array();
$valores = array();
foreach ($precipitacao_por_intervalo as $i => $precipitacao) {
    $labels[] = $tempos[$i][2];
    $valores[] = $precipitacao;
}
$data = array(
    "labels" => $labels,
    "datasets" => array(
        array(
            "label" => "Precipitação",
            "backgroundColor" => "#3e95cd",
            "data" => $valores
        )
    )
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gráfico de barra</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="grafico"></canvas>
    <script>
        var data = <?php echo json_encode($data); ?>;
        var options = {
            legend: { display: false },
            title: {
                display: true,
                text: 'Precipitação nos últimos intervalos de tempo'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };
        var ctx = document.getElementById("grafico").getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    </script>
</body>
</html>
