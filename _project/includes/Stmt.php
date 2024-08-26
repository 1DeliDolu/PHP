<?php
namespace PROJECT\includes;

abstract class Stmt {
    const getCountUserMail = 'SELECT COUNT(*) AS CountUser FROM users WHERE email = ?';
    const getUser = 'SELECT COUNT(*) AS CountUser FROM users WHERE email = ? AND password = ?';
    const setUser = 'INSERT INTO users (email, password, first_name, last_name) VALUES (?, ?, ?, ?)';
}
