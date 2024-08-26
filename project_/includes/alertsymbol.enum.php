<?php
namespace PROJECT\includes;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

enum AlertSymbol:string {
    case Danger = 'bi-bug';
    case Info = 'bi-info-circle';
    case Primary = 'bi-book';
    case Success = 'bi-check-circle';
    case Warning = 'bi-exclamation-triangle';
}