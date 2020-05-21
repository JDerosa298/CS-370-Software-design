<!DOCTYPE html>
<html>
<head>
<style type = "text/css">
body {
margin: 0px;
padding: 0px;
background-color: #ccc;
text-align: center;
}
#problem {
margin: 10px 50px;
border: 1px solid black;
height: 250px;
padding: 10px;
text-align: left;
overflow: scroll;
}
button {
background-color: #4CAF50;
color: white;
padding: 14px 20px;
border: none;
cursor: pointer;
margin: 5px;
}
#logout {
float: right;
background-color: #f44336;
padding: 10px 28px;
margin: 10px;
}
button:hover {
opacity: 0.8;
}
#header {
padding: 5px;
background-color: #003399;
color: white;
margin: 0px;
vertical-align: middle;
}
#content {
padding: 10px 50px;
margin: 0px 10%;
background-color: white;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}
function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}
function refresh() {
    window.location="home.php";
}
function thing() {
if (document.cookie === "") {
window.location = "index.php";
}
	var data = {session: getCookie("session"), query: "data"};
	var name = "";
	var score = 0;
	var question = "";
	var userType = "user";
        $.ajax({

            type: "POST",
            url: "/post.php",
	    dataType: "text",
            data: data,
            success: function(results) {
		if (results === "") {
		    document.getElementById("welcome").innerHTML = "Invalid Data Received!";
		} else if (results === "-1") {
		    document.getElementById("welcome").innerHTML = "Invalid session! Please log back in!";
		} else {
		    var res = results.split(";");
		    var msg = "";
		    var grading = false;
                    document.getElementById("welcome").innerHTML = "Welcome to the Shak, " + res[1] + "!";
		    if (res[0] === "USER") {
			if (status === "SUCCESS") {
			    grading = true;
			    document.getElementById("content").innerHTML = "<h1>Grading your submission...</h1>";
                            var data = {session: getCookie("session"), query: "grade", file: fname};
                            $.ajax({
                                type: "POST",
                                url: "/post.php",
                                dataType: "text",
                                data: data,
                                success: function(results) {
                                    if (results === "-1") {
					document.getElementById("content").innerHTML = '<h1>Program failed to compile! Grade received: 0</h1><br><button name="next" onclick="refresh()">Next Question</button>';
                                    } else {
                                        document.getElementById("content").innerHTML = '<h1>Your program was successfully graded! Grade received: ' + results + '</h1><br><button name="next" onclick="refresh()">Next Question</button>';
                                    }
                                },
                                error: function(err) { console.log("Failed to connect to server."); }
                            });
			} else if (status === "INVALID") {
			    msg = "<p>Invalid file type! Please upload .c, .cpp, or .py files only!</p>";
			} else if (status === "SIZE") {
			    msg = "<p>Uploaded file must be less than 1 MB!</p>"
			}
			if (!grading) {
			    document.getElementById("content").innerHTML = '<h2 id="score">Your current score is: ' + res[3] + '</h2><h2>Your question is:</h2><p id="problem">' + res[2].replace(/%3B/g, ";") + (res[2] == 'You\'ve solved all available problems!' ? '' : '</p><h3>Submit your answer:</h3><form action="home.php" method="post" enctype="multipart/form-data"><title> Please upload a file </title><tr><td align = "center"><input type="file" name="fileToUpload" id="uploader" required></td></tr><p><button type="submit" name="submit">Submit</button></p></form>') + msg;
			}
		    } else {
                        if (status === "SUCCESS") {
                            msg = "<p>New problem successfully uploaded!</p>"
                            var data = {session: getCookie("session"), query: "judge", problem: problem, file: fname};
                            $.ajax({
                                type: "POST",
                                url: "/post.php",
                                dataType: "text",
                                data: data,
                                success: function(results) {
                                    if (results === "success") {
                                        console.log("Problem successfully registered!");
                                    } else {
                                        console.log("Failed to connect to server.");
                                    }
                                },
                                error: function(err) { console.log("Failed to connect to server."); }
                            });
                        } else if (status === "INVALID") {
                            msg = "<p>Invalid file type! Please upload .c, .cpp, or .py files only!</p>";
                        } else if (status === "SIZE") {
                            msg = "<p>Uploaded file must be less than 1 MB!</p>"
                        }
			document.getElementById("welcome").innerHTML = "Welcome to the Shak, " + res[1] + "!";
			document.getElementById("content").innerHTML = '<h2>Add A Question:</h2><form action="home.php" method="post" enctype="multipart/form-data" id="judgeForm"><textarea name="textProblem" cols="80" rows="20" placeholder="Type your question here." id="problem" required></textarea><br><input type="file" name="fileToUpload" id="uploader" required><br><button type="submit">Submit</button><button type="button" id="reset">Reset Questions</button></form><br><br><h1>Register a user:</h1><form id="userRegistration"><label for="uname"><b>Username: </b></label><input type="text" placeholder="Enter Username" name="uname" id="username" required><br><label for="psw"><b>Password:  </b></label><input type="password" placeholder="Enter Password" name="psw" id="password" required><br><button type="submit">Register User</button></form>' + msg;
		        $("#userRegistration").submit(function() {
		            if ($("#username").val() != "" && $("#password").val() != "") {
		                var data = {session: getCookie("session"), query: "register", username: $("#username").val(), password: $("#password").val()};
		                $.ajax({
		                    type: "POST",
		                    url: "/post.php",
		                    dataType: "text",
		                    data: data,
		                    success: function(results) {
		                        if (results === "") {
        		                    alert("Failed to connect to server.");
	        	                } else if (results === "-1") {
		                            alert("A user already exists with this username!");
		                        } else {
		                            alert("Successfully registered new user!");
					    document.getElementById("username").value = "";
					    document.getElementById("password").value = "";
		                        }
		                    },
		                    error: function(err) { alert("Failed to connect to server."); }
		                });
		            } else {
		                alert("Please enter a username and password!");
		            }
		            return false;
		        });
			$("#reset").click(function() {
			    var data = {session: getCookie("session"), query: "reset"};
			    $.ajax({
			        type: "POST",
			        url: "/post.php",
			        dataType: "text",
			        data: data,
			        success: function(results) {
			            if (results === "success") {
			                alert("Successfully reset questions.");
			            } else {
			                alert("Failed to connect to server.");
			            }
			        },
			        error: function(err) { alert("Failed to connect to server."); }
			    });
			    return false;
			});
		    }
                    $('#uploader').bind('change', function() {
                        var fileSize = this.files[0].size/1024/1024;
                        if (fileSize > 1) {
                            alert('Uploaded file size must not exceed 1MB!');
                            $('#uploader').val('');
                        }
                    });
		}
            },
	    error: function(err) { alert("Failed to connect to server."); }
        });
}
$(document).ready(function() {
$("#logout").click(function() {
    var data = {session: getCookie("session"), query: "logout"};
    $.ajax({
        type: "POST",
        url: "/post.php",
        dataType: "text",
        data: data,
        success: function(results) {
            if (results === "-1") {
		document.cookie = "session=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
                window.location = "index.php";
            } else {
                alert("Failed to connect to server.");
            }
        },
        error: function(err) { alert("Failed to connect to server."); }
    });
    return false;
});
});
</script>
</head>
<body onload="thing()">
<div id="header">
<button id="logout">Logout</button>
<h1 id="welcome">Welcome to the Shak!</h1>
</div>
<div id = "content">
<h1>Loading...</h1>
<?PHP
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
if(!empty ($_FILES ['fileToUpload'])) {
        $filePath = $_SERVER['HOME'] . '/dspc/';
	$fileName = $_FILES['fileToUpload']['name'];
        $ext = end((explode('.', $fileName)));
	if ($_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
		if ($ext === 'py' || $ext === 'cpp' || $ext === 'c') {
			if ($_FILES['fileToUpload']['size'] < 1048576) {
				$name = generateRandomString(20) . '.' . $ext;
				echo '<script type="text/javascript">var fname = "' . $name . '";</script>';
        			$filePath = $filePath . $name;
        			move_uploaded_file ($_FILES ['fileToUpload']['tmp_name'], $filePath);
				$problem = $_POST['textProblem'];
				$problem = str_replace('\\', '\\\\', str_replace('`', '&backtick', $problem));
                                echo '<script type="text/javascript">var problem = `' . $problem . '`;</script>';
        			echo '<script type="text/javascript">var status = "SUCCESS";</script>';
				$_FILES['fileToUpload'] = NULL;
			} else {
				echo '<script type="text/javascript">var status = "SIZE";</script>';
			}
		} else {
			echo '<script type="text/javascript">var status = "INVALID";</script>';
		}
	} else {
		echo '<script type="text/javascript">var status = "SIZE";</script>';
	}
} else {
	echo '<script type="text/javascript">var status = "";</script>';
}
?>
</div>
</body>
</html>
