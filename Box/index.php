<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GETbox</title>
</head>
<body>
    <form method="post" action="post.php">
        <label for="ID" >ID box</label>
        <input type="text" id="box" name="box"><br>
        <button type="submit" name="search" class="btn btn-default">ค้นหา</button>
    </form>

    <?php
    include("show.php");
    ?>
</body>
</html>
