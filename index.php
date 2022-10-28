<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Chat Intercontrat</title>
    <link type="text/css" rel="stylesheet" href="style.css" />
</head>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">

// jQuery Document
$(document).ready(function(){
    //If user wants to end session
	$("#exit").click(function(){
		var exit = confirm("Tu nous quittes ?");
		if(exit==true){window.location = 'index.php?logout=true';}		
	});
        
    setInterval (loadLog, 1000);	//Reload file every x ms

    //If user submits the form
	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
        if (clientmsg != '') {
		    $.post("post.php", {text: clientmsg});				
		    $("#usermsg").attr("value", "");
        }
		return false;
	});

    //Load the file containing the chat log
	function loadLog(){		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
		$.ajax({
			url: "log1.html",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				//Auto-scroll			
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
});

// Handle music player
function Play() {
    var myAudio = document.getElementById("player");
    if(myAudio.paused) {
        myAudio.play();
    }
    else {
        myAudio.pause();
    }
}
</script>

<?php
session_start();
/*$ActiveUsers = array();*/

function loginForm(){
    echo'
    <div id="loginform">
    <form action="index.php" method="post">
        <p>Please enter your name to continue:</p>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" />
        <p class="blink"><input id="enter" type="Submit" src="data/enter.png" name="enter" value="ENTER"/></p>
    </form>
    </div>
    <div class="msgln" style="font-size: 300%;"><br><br><br><br><br><br><br><br><b>RECHERCHE EXPERT PHP</b><br></div>
    ';
}
 
if(isset($_POST['name'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        /*$nbUsers=count($ActiveUsers);
        $ActiveUsers[$nbUsers] = stripslashes(htmlspecialchars($_POST['name']));
        $_SESSION['id'] = count($ActiveUsers);*/
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }

    //Simple enter message
    $fp = fopen("log1.html", 'a');
    fwrite($fp, "<div class='msgln'><i>". $_SESSION['name'] ." a rejoint la session.</i><br></div>\n");
    fclose($fp);
}

if(isset($_GET['logout'])){ 
    //Simple exit message
    $fp = fopen("log1.html", 'a');
    fwrite($fp, "<div class='msgln'><i>". $_SESSION['name'] .", petit ange parti trop tot</i><br></div>\n");
    fclose($fp);
    unset($ActiveUsers[$_SESSION['id']]);     
    session_destroy();
    header("Location: index.php"); //Redirect the user
}
?>

<?php
if(!isset($_SESSION['name'])){
    loginForm();
}
else{
        /*$nbUsers=count($ActiveUsers);

        for($i = 0; $i < $nbUsers; $i++) {
            echo $ActiveUsers[$i];
            echo '</ br>';
        }*/
?>

<div id="logo">
    <a href="index.php"><img src="data/SolutekWave.png"></a>
</div>
<!--<div id="rooms">
    <img class="clope" src="data/clope.png">
</div>-->
<div>  
    <div id="exit">
        <a id="exit" href="#"><p class=blink> Exit Game</p></a>  
    </div>
    <div id="github">
        <a href="https://github.com/MaximeEncrenaz/Tchaaat" target="_blank"><img src="/data/github.png" style="width:120px;height:60px"></a>  
    </div>

    <div id="wrapper">
        <div id="audio">
            <audio id="player" controls autoplay>
                <source src="data/BO (Pablo Bozzi _Take Off_ edit).mp3" type="audio/mp3">
            </audio>
            <button id="MuteButton" onclick='Play()'>
                <p class="msgln" style="font-style: italic;font-size:80%;">Pablo Bozzi remix <br> Endrick Schroeder feat. Jul<br></p>
                <img src="data/Mute.png" style="width:200px;height:200px">
            </button>
        </div>
        <div id="chatbox">
        <?php
            if(file_exists("log1.html") && filesize("log1.html") > 0){
                $handle = fopen("log1.html", "r");
                $contents = fread($handle, filesize("log1.html"));
                fclose($handle);
                echo $contents;
            }
        ?>
        </div>
     
        <form name="message" action="">
            <input name="submitmsg" type="image" src="/data/send.png" id="submitmsg" value="Envoyer" alt="Submit"/>
            <p class=usermsg><input name="usermsg" type="text" placeholder="Enter a message here..." id="usermsg" size="63" /></p>
        </form>
    </div>
</div> 

<?php
}
?>

</body>
</html>