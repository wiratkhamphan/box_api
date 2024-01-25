<?php
session_start();

error_log('show.php accessed');  // Log information

if (isset($_SESSION['boxData'])) {
    $boxData = $_SESSION['boxData'];

    // Check if array keys exist before accessing them
    $id = isset($boxData['ID']) ? $boxData['ID'] : '';
    $appress = isset($boxData['Appress']) ? $boxData['Appress'] : '';
    $box = isset($boxData['Box']) ? $boxData['Box'] : '';

    // Use the variables in your HTML
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Appress</th><th>Box</th></tr>";
    echo "<tr>";
    echo "<td>{$id}</td>";
    echo "<td>{$appress}</td>";
    echo "<td>{$box}</td>";
    echo "</tr>";
    echo "</table>";

    // Clear the session variable after displaying
    unset($_SESSION['boxData']);
} else {
    // Display a table with a "No data received" message
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Appress</th><th>Box</th></tr>";
    echo "<tr>";
    echo "<td></td>";
    echo "<td>No data received.</td>";
    echo "<td></td>";
    echo "</tr>";
    echo "</table>";
}
?>
