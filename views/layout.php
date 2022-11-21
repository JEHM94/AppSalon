<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AppSalón</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
</head>

<body>
    <div class="contenedor-app">
        <a href="/">
            <div class="imagen"> </div>
        </a>
        <div class="app">
            <?php echo $contenido; ?>
        </div> <!-- .app -->
    </div> <!-- .contenedor-app -->

    <?php echo $script ?? ''; ?>

</body>

</html>