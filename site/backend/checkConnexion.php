<?php
/**
 * Pour vérifier si un utilisateur est déjà connecté et le renvoyer sur la page
 * de connexion si ce n'est pas le cas.
 */

session_start();

if (!isset($_SESSION["idUser"])) { // non connecté
    echo "<script>location.href='../connexionCmpt.php';</script>";
    die();
}