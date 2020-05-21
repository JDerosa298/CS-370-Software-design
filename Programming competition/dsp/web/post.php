<?php
$url = 'http://localhost:27165/login';
$data = array_merge(array("addr=".$_SERVER['REMOTE_ADDR']), $_POST);

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo $result;
?>
