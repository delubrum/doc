<?php 
session_start();
$user = $this->users->UserGet($_SESSION["id-CRB"]);
$load_lang = $user->lang;
$lang_json = file_get_contents("assets/lang/".$load_lang.".json");
$lang = json_decode($lang_json, true);
if (empty($_SESSION["id-CRB"])) {
    header('Location: ?c=Login&a=Index');
} else {
    if (!empty($this->init->lastCashbox()->closedAt)) {
    header('Location: ?c=Cashbox&a=Open');
    }
}
?>