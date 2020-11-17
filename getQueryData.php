<?php
include_once 'conn.php';

$data = $_POST['query'];
$sql = $data;
if($result = $conn->query($sql)) {
    if ($result->num_rows > 0) {
        echo '<table class="table">';
        echo '<thead><tr>';
        while ($col = $result->fetch_field()) {
            echo '<th>' . $col->name . '</th>';
        }
        echo '</tr></thead><tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody></table>';
    }
} else {
    echo $conn->error;
}
?>
