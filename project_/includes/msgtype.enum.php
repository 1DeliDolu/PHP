<?php
namespace Project\includes;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

enum Msgtype:string {
    case Primary = "primary";
    case Success = "success";
    case Info = "info";
    case Warning = "warning";
    case Danger = "danger";
}