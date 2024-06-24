<?php
use Ond\AtelierCouturePoo\Core\Session;
use Ond\AtelierCouturePoo\Core\Autorisation;
function add_classe_hidden(string $fieldName): void
{
    echo (isset(Session::get("errors")[$fieldName]) ? "" : "hidden");
}
function add_classe_hidden_lien(string $roleName): void
{
    echo (Autorisation::hasRole($roleName)) ? "" : "hidden";
}
function dd(mixed $data)
{
    dump($data);die;
}

function dump(mixed $data)
{
    echo ("<pre>");
    var_dump($data);
    echo ("</pre>");

}
function add_classe_invalid(string $fieldName): void
{
    echo (isset(Session::get("errors")[$fieldName]) ? "bg-purple-200 border-red-500 dark:bg-purple-200/30" : "");
}
