<?php
include_once('conn.php');

$preferencesData = json_decode($_POST['preferencesData']);
    $sql2 = 'UPDATE `preferences` SET `practitioner_id`='.$preferencesData->practitioner_default.',`lab_id`='.$preferencesData->lab_default.',`sample_id`='.$preferencesData->sampleType_default.',`type_id`='.$preferencesData->testType_default.',`reason_id`='.$preferencesData->testReason_default.'';
    if($conn->query($sql2)) {
        echo "The data has been uploaded.";
    } else {
        echo $conn->error;
        mysqli_close($conn);
    }
// }
?>