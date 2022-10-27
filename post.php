<?php
session_start();
date_default_timezone_set('Europe/Paris');
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
     
    $fp = fopen("log.html", 'a');

    if(strpos($text,"http") !== false) {
        fwrite($fp, "<div class='msgln'>(".date("H:i:s").") <b>".$_SESSION['name']."</b>: <br><a href='$text'>".stripslashes(htmlspecialchars($text))."</a><br><br></div>\n");
    } else {
        fwrite($fp, "<div class='msgln'>(".date("H:i:s").") <b>".$_SESSION['name']."</b>:<br>".stripslashes(htmlspecialchars($text))."<br><br></div>\n");
    }    
    fclose($fp);
}
?>