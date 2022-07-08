<?php 
session_start();
$user = $this->users->UserGet($_SESSION["id-DOCS"]);
$load_lang = $user->lang;
$lang_json = file_get_contents("assets/lang/".$load_lang.".json");
$lang = json_decode($lang_json, true);
if (empty($_SESSION["id-DOCS"])) {
    header('Location: ?c=Login&a=Index');
}
?>