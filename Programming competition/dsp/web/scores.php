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
<script type = "text/javascript">
function loadScores() {
    var data = {query: "scores"};
    $.ajax({
        type: "POST",
        url: "/post.php",
        dataType: "text",
        data: data,
        success: function(results) {
            document.getElementById("scores").innerHTML = results;
        },
        error: function(err) { alert("Failed to connect to server!"); }
    });
}
</script>
</head>
<body onload="loadScores()">
<div id="header">
<h1>Leaderboard</h1>
</div>
<div id="content">
<h2 id="scores">
Loading...
</h2>
</div>
</body>
</html>
