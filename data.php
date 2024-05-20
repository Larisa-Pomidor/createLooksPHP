<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = $_POST['data'];
    file_put_contents('data.json', json_encode($data));
    echo 'Data saved successfully';
} else {
    echo 'Invalid request';
}
?>