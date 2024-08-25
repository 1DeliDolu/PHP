<?php
// lesen von per GET übertragenen Informationen -> superglobale Variable $_GET
var_dump($_GET);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forumaler per GET senden</title>
</head>
<body>
    <h1>Formulare mit GET</h1>
    <form action="form_get.php" method="get" enctype="text/plain">
        <label for="username">Benutzername</label>
        <input type="email" name="username" id="username" autocomplete="username">
        <label for="pass">Passwort</label>
        <input type="password" name="pass" id="pass" autocomplete="current_password">
        <button type="reset">zurücksetzen</button>
        <button type="submit" name="submit">Anmelden</button>
    </form>
    <?php
    // gebe übermittelte daten aus, wenn das formular gesendet wurde
    if(count($_GET) && array_key_exists('submit', $_GET) && array_key_exists('username', $_GET) && array_key_exists('pass', $_GET)) {
        printf('<p>Sie haben versucht sich als %s mit dem Kennwort %s anzumelden</p>', $_GET['username'], $_GET['pass']);
    }
    ?>
</body>
</html>