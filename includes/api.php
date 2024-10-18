<?php

// fungsi untuk mengambil data
function fetchData($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

$url = "https://jsonplaceholder.typicode.com/posts";
$data = fetchData($url);

// mengembalikan data dalam bentuk json
header('Content-Type: application/json');

// mengembalikan data dalam bentuk json
echo $data;
