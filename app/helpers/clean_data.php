<?php
function cleanInput($data)
{
    global $conn;
    $cleanedData = [];

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $cleanedData[$key] = cleanInput($value);
        } else {
            $value = mysqli_real_escape_string($conn, $value);

            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

            $cleanedData[$key] = $value;
        }
    }

    return $cleanedData;
}