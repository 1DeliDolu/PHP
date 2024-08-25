<?php
// lesen von per GET übertragenen Informationen -> superglobale Variable $_POST
var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forumaler per POST senden</title>
</head>
<body>
    <h1>Formulare mit POST</h1>
    <form action="form_post.php" method="post" enctype="multipart/form-data">
        <label for="username">Benutzername</label>
        <input type="email" name="username" id="username" autocomplete="username">
        <label for="pass">Passwort</label>
        <input type="password" name="pass" id="pass" autocomplete="current_password">
        <button type="reset">zurücksetzen</button>
        <button type="submit" name="submit">Anmelden</button>
    </form>
    <?php
    // gebe übermittelte daten aus, wenn das formular gesendet wurde
    if(count($_POST) && array_key_exists('submit', $_POST) && array_key_exists('username', $_POST) && array_key_exists('pass', $_POST)) {
        printf('<p>Sie haben versucht sich als %s mit dem Kennwort %s anzumelden</p>', $_POST['username'], $_POST['pass']);
    }
    ?>
</body>
</html>