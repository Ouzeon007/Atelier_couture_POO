<?php
namespace Ond\AtelierCouturePoo\Core;
class Validator
{
    public static array $errors = [];

    public static function isValide(): bool
    {
        return count(self::$errors) == 0;
    }

    public static function isEmpty(string $valueField, string $nameField, string $message = "le champ est obligatoire"): bool
    {
        if (empty($valueField)) {
            self::$errors[$nameField] = $message;
            return true;
        }
        return false;
    }
    public static function add(string $key, mixed $data)
    {
        self::$errors[$key] = $data;
    }

    public static function isEmail(string $valueField, string $nameField, string $message = "l'email n'est pas valide")
    {
        if (!filter_var($valueField, FILTER_VALIDATE_EMAIL)) {
            self::$errors[$nameField] = $message;
        }
    }
    public static function isPossitive(int $valueField, string $nameField, string $message = "la valeur doit etre positive"): bool
    {
        if ($valueField <= 0) {
            self::$errors[$nameField] = $message;
            return true;
        }
        return false;
    }
}
