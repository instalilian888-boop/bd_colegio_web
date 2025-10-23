<?php
// index.php

// Datos de conexión a AlwaysData
$host = 'mysql-alexagon08.alwaysdata.net';
$db   = 'alexagon08_bd_colegioo';
$user = 'alexagon08_bd_colegioo';
$pass = 'contrasena2109_2008'; // Cambia esto por tu contraseña real

// Conexión a la base de datos usando PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Consulta para obtener los primeros 100 registros
$stmt = $pdo->query("SELECT * FROM personas LIMIT 100"); // Cambia 'personas' si tu tabla tiene otro nombre
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registros de BD Colegio</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1 style="text-align:center;">100 Registros de la BD Colegio</h1>
    <table>
        <tr>
            <?php foreach(array_keys($registros[0]) as $columna): ?>
                <th><?= htmlspecialchars($columna) ?></th>
            <?php endforeach; ?>
        </tr>
        <?php foreach($registros as $fila): ?>
            <tr>
                <?php foreach($fila as $valor): ?>
                    <td><?= htmlspecialchars($valor) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
