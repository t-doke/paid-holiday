<?php

date_default_timezone_set('Asia/Tokyo');

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

$dsn = "mysql:host=mysql-container;dbname=my_database;charset=utf8mb4";
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES, false
];

$pdo = new PDO($dsn, "user", "userpassword", $options);

define("SESSION_ACCOUNT", "SESSION_ACCOUNT");
define("SESSION_MESSAGE", "SESSION_MESSAGE");
define("SESSION_CSRF_TOKEN", "SESSION_CSRF_TOKEN");

define("MESSAGE_SIGNIN_SUCCESS", "サインインに成功しました。");
define("MESSAGE_SIGNIN_ERROR", "サインインに失敗しました。");
define("MESSAGE_SIGNUP_SUCCESS", "サインアップに成功しました。");
define("MESSAGE_SIGNUP_ERROR", "サインアップに失敗しました。");
define("MESSAGE_SIGNUP_ERROR_NOT_AVAILABLE_NAME", "この名前は使用できません。");

session_start();

function sign_in($account)
{
    session_regenerate_id();
    $_SESSION[SESSION_ACCOUNT] = $account;
}

function is_sign_in()
{
    return isset($_SESSION[SESSION_ACCOUNT]);
}

function sign_out()
{
    if (is_sign_in() === false) {
        return false;
    }

    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}

function get_account()
{
    if (is_sign_in() === false) {
        return false;
    }
    return $_SESSION[SESSION_ACCOUNT];
}

function get_account_id()
{
    $account = get_account();
    if ($account === false) {
        return false;
    }
    return $account["id"];
}

function get_account_name()
{
    $account = get_account();
    if ($account === false) {
        return false;
    }
    return $account["name"];
}

function set_message($message)
{
    $_SESSION[SESSION_MESSAGE] = $message;
}

function get_message()
{
    if (isset($_SESSION[SESSION_MESSAGE]) === false) {
        return false;
    }
    $message = $_SESSION[SESSION_MESSAGE];
    unset($_SESSION[SESSION_MESSAGE]);
    return $message;
}

function generate_csrf_token()
{
    $bytes = random_bytes(32);
    $token = bin2hex($bytes);
    $_SESSION[SESSION_CSRF_TOKEN] = $token;
    return $token;
}

function validate_csrf_token($token)
{
    if (isset($_SESSION[SESSION_CSRF_TOKEN]) === false) {
        return false;
    }
    $result = $_SESSION[SESSION_CSRF_TOKEN] === $token;
    unset($_SESSION[SESSION_CSRF_TOKEN]);
    return $result;
}
