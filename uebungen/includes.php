<?php

# EXTERNE DATEIEN (classes, functions, etc) einbinden

// require: Datei muss unbedingt eingebunden werden - bei Fehler "Fatal ERROR"
require('functions.php');
// include: Es wird versucht die Datei einzubinden - bei Fehler "Warning"
include('output.php');

// _once: bindet die Datei nur ein, wenn noch nicht erfolgt; sonst wie oben
require_once('functions.php');
include_once('functions.php');

