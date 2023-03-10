<?php

// Configurações de acesso ao banco de dados
$dbname = "id17192650_estacaometeoro";
$username = "id17192650_estagiometeoro";
$password = "E5{V!%s<6_6#]9V8";

// Conectando ao banco de dados
$conn = mysqli_connect("localhost", $username, $password, $dbname);

// Verificando se houve erro na conexão
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

// Consulta SQL para obter os dados de precipitação nos diferentes intervalos de tempo
$sql = "SELECT e.Estacao,
(SELECT SUM(Prec) FROM tabela WHERE Estacao = e.Estacao AND Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 30 MINUTE) AND NOW()) as '30min',
(SELECT SUM(Prec) FROM tabela WHERE Estacao = e.Estacao AND Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 1 HOUR) AND NOW()) as '1h',
(SELECT SUM(Prec) FROM tabela WHERE Estacao = e.Estacao AND Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 3 HOUR) AND NOW()) as '3h',
(SELECT SUM(Prec) FROM tabela WHERE Estacao = e.Estacao AND Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 12 HOUR) AND NOW()) as '12h',
(SELECT SUM(Prec) FROM tabela WHERE Estacao = e.Estacao AND Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 24 HOUR) AND NOW()) as '24h',
(SELECT SUM(Prec) FROM tabela WHERE Estacao = e.Estacao AND Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 48 HOUR) AND NOW()) as '48h',
(SELECT SUM(Prec) FROM tabela WHERE Estacao = e.Estacao AND Timestamp BETWEEN DATE_SUB(NOW(), INTERVAL 72 HOUR) AND NOW()) as '72h'
FROM tabela e
GROUP BY Estacao";

// Executando a consulta
$result = mysqli_query($conn, $sql);

// Verificando se houve erro na execução da consulta
if (!$result) {
    die("Erro na consulta: " . mysqli_error($conn));
}

// Criando a tabela HTML para exibir os resultados
echo "<table border='1'>";
echo "<tr><th>Estação</th><th>30min</th><th>1h</th><th>3h</th><th>12h</th><th>24h</th><th>48h</th><th>72h</th></tr>";

// Loop para exibir os dados de cada estação
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row["Estacao"] . "</td>";
    echo "<td>" . number_format($row["30min"], 2, '.', '') . "</td>";
    echo "<td>" . number_format($row["1h"], 2, '.', '') . "</td>";
    echo "<td>" . number_format($row["3h"], 2, '.', '') . "</td>";
    echo "<td>" . number_format($row["12h"], 2, '.', '') . "</td>";
    echo "<td>" . number_format($row["24h"], 2, '.', '') . "</td>";
    echo "<td>" . number_format($row["48h"], 2, '.', '') . "</td>";
    echo "<td>" . number_format($row["72h"], 2, '.', '') . "</td>";
    echo "</tr>";
}

// Fechando a tabela HTML
echo "</table>";

// Fechando a conexão com o banco de dados
mysqli_close($conn);
?>