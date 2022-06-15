<?php

    $mesas = [
        "1" => [
            "numero" => "1",
            "estado" => "1"
        ],
        "2" => [
            "numero" => "2",
            "estado" => "0"
        ],
        "3" => [
            "numero" => "3",
            "estado" => "1"
        ]
    ];
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>diseño tpv</title>
</head>

<body>

    <ul style ="list-style-type: none">
    <?php foreach($mesas as $mesa): ?>
        <?php if ($mesa["estado"] == 1): ?>
            <li style = "   background-color:green;
                            margin:1rem;
                            padding:1rem;
                            width:50px;display:inline;"><?= $mesa['numero']; ?></<li>
        <?php else: ?>
            <li style = "   background-color:red;
                            margin:1rem;
                            padding:1rem;
                            width:50px;display:inline;"><?= $mesa['numero']; ?></<li>
        <?php endif; ?>
        
    <?php endforeach; ?>

    </ul>

</body>

</html>
 © 2020 Josh Goebel
Powered by Node.js, Express, Highlight.js, and Love.