<?php
namespace IAD\classes;

defined('_IAD') or die();

enum Stmt:string {
    case getPassword = 'SELECT `password` FROM user WHERE username = ?|s';
    case getAllUser = 'SELECT user FROM user';

    // gibt den ersten teil des cases zurück -> statement
    public function getQuery():string {
        return trim($this->splitStmt($this->value)[0]);
    }
    // gibt falls vorhanden, die typen für das statement oder eine leeren string zurück
    public function getTypes():string {
        return trim($this->splitStmt($this->value)[1] ?? '');
    }
    // teilt das statement in den ersten teil (query) und den zweiten teil (types)
    private function splitStmt(string $stmt):array {
        return explode('|', $stmt);
    }
}