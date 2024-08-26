<h1>Startseite</h1>
<p>Diese kleine Anwendung, demonstriert eine datenbankgestützte Webseite unter Verwendung eines schmalen Frameworks.</p>
<p>Unterstützt wird die Anwendung durch die beiden eingebundenen Frameworks <a href="https://www.jquery.com" target="_blank">jQuery</a>, für den Zugriff auf das Doucement Object Model, sowie <a href="https://www.getbootstrap.com" target="_blank">Bootstrap</a> für das responsive Design.</p>

<h2>Benutzung der Anwendung</h2>
<p>Da es sich hierbei nur um eine Demonstration handelt, sind die Möglichkeiten beschränkt. Benutzer können sich Anmelden und Registrieren. Jede An- und Abmeldung wird in der Datenbank gespeichert. Diese Vorgänge können über den Menüpunkt <strong>Statistik</strong> eingesehen werden.</p>

<h2>Prinzipielle Funktionsweise</h2>
<p>Jede Aktion über einen Link wird über einen JS-Eventhandler abgefangen (siehe /js/functions.js oder in den jeweiligen Templates der Komponenten) und per AJAX an den Server übertragen. Dort empfängt die Datei /ajax.php jeden Request und dirigiert anhand des gesendeten component-Keys (z. B. "content.show") die Anfrage an die entsprechende Komponente (im Ordner /components) weiter. die Komponenten sind grundsätzlich im MVC-Entwurfsmuster konzipiert. Im jeweiligen Controller (controller.php) der Komponente wird die entsprechende Methode des im AJAX-Request befindlichen component-Keys (z. B. "show") aufgerufen. Diese Methode leitet die Anfrage entsprechend an das Model (model.php) oder den View (view.php) weiter.</p>
<p>Das View selbst kann bei Bedarf ebenfalls Daten über das Model anfordern.</p>
<p>Die Daten, welche das Model bereitstellen oder auch speichern soll, können entweder aus der Datenbank oder der Session abgerufen oder dort gespeichert werden. Dazu bindet das Model die Klassen db.class.php und session.class.php (beide im Ordner /classes) ein.</p>
<p>Jedes Model, View und Controller werden von der Basis-Komponente (/components/base) abgeleitet. Die darin befindlichen abstrakten Klassen besitzen die wichtigsten einheitlichen Methoden, welche die konkreten Komponenten benötigen. Diese Vorgehensweise vereinfacht das Erstellen neuer Methoden.</p>
<h2>Ordnerstruktur</h2>
<?php
$this->getDirectory();
echo implode('', $this->directory);