<form>
    <fieldset>
        <legend><?= $this->title ?? '' ?></legend>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="username" placeholder="Benutzername">
            <label for="username">Benutzername</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="pass" placeholder="Passwort">
            <label for="pass">Passwort</label>
        </div>
    </fieldset>
    <fieldset><?= implode('', $this->buttons ?? []) ?></fieldset>
    <script>
        <?= implode('', $this->scripts ?? []) ?>
    </script>
</form>