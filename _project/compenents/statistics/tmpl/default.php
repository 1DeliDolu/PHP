<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?= $this->title ?></title>
</head>
<body>
    <h1><?= $this->title ?></h1>
    <h2>Login Logs</h2>
    <ul>
        <?php foreach ($this->logins as $login): ?>
            <li><?= htmlspecialchars($login['timestamp']) ?>: <?= htmlspecialchars($login['details']) ?></li>
        <?php endforeach; ?>
    </ul>
    <h2>Logout Logs</h2>
    <ul>
        <?php foreach ($this->logouts as $logout): ?>
            <li><?= htmlspecialchars($logout['timestamp']) ?>: <?= htmlspecialchars($logout['details']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
