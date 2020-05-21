<!DOCTYPE html>

<html>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">

<style>

body {
font-family: Arial, Helvetica, sans-serif;
}

form {
border: 3px solid #f1f1f1;
}


input[type=text], input[type=password] {

    width: 100%;

    padding: 12px 20px;

    margin: 8px 0;

    display: inline-block;

    border: 1px solid #ccc;

    box-sizing: border-box;

}


button {

    background-color: #4CAF50;

    color: white;

    padding: 14px 20px;

    margin: 8px 0;

    border: none;

    cursor: pointer;

    width: 100%;

}


button:hover {

    opacity: 0.8;

}


.cancelbtn {

    width: auto;

    padding: 10px 18px;

    background-color: #f44336;

}


.container {

    padding: 16px;

}


span.psw {

    float: right;

    padding-top: 16px;

}


/* Change styles for span and cancel button on extra small screens */

@media screen and (max-width: 300px) {

    span.psw {

       display: block;

       float: none;

    }

    .cancelbtn {

       width: 100%;

    }

}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
function fp() {
	alert("And you expect me to remember it?");
}

$(document).ready(function() {
    if (document.cookie != "") {
	window.location = "home.php";
    }

    $("#myform").submit(function() {
	if ($("#username").val() != "" && $("#password").val() != "") {
	var data = {username: $("#username").val(), password: $("#password").val()};
        $.ajax({

            type: "POST",
            url: "/post.php",
	    dataType: "text",
            data: data,
            success: function(results) {
		if (results === "") {
		    alert("Failed to connect to server.");
		} else if (results === "-1") {
		    alert("Invalid credentials! Please try again!");
		} else {
		    document.cookie = "session=" + results;
		    window.location = "home.php";
		}
            },
	    error: function(err) { alert("Failed to connect to server."); }
        });
	} else {
	    alert("Please enter a username and password!");
	}

        return false;

    });


});

</script>


</head>

<body>


<h2>Welcome to DSPC!</h2>


<form id="myform">

  <div class="container">

    <label for="uname"><b>Username</b></label>

    <input type="text" placeholder="Enter Username" name="uname" id="username" required>


    <label for="psw"><b>Password</b></label>

    <input type="password" placeholder="Enter Password" name="psw" id="password" required>

        
    <button type="submit">Login</button>

    <label>

      <input type="checkbox" checked="checked" name="remember"> Remember me

    </label>

  </div>


  <div class="container" style="background-color:#f1f1f1">

    <button type="button" class="cancelbtn">Cancel</button>

    <span class="psw">Forgot <a href="#" onclick="fp()">password?</a></span>

  </div>

</form>

<a href="scores.php">Don't have an account? See the current scores here!</a>

</body>

</html>
