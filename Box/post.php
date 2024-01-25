<?php
session_start();

if (isset($_POST['search'])) {
    $box = $_POST['box'];

    $apiUrl = 'http://localhost:8080/Box/' . urlencode($box);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($statusCode == 200) {
        $Box = json_decode($response, true);

        // Store the data in a session variable
        $_SESSION['boxData'] = $Box;

        // Redirect to show.php
        header("Location: index.php");
        exit;
    } else {
        // Handle the case when the API request is not successful
        // For example, you can display an error message or log the issue
        echo "Error: Unable to retrieve data from the API. Please try again later.";
    
        // Alternatively, you can redirect to an error page
        header("Location: index.php");
        exit;
    }
}
?>
