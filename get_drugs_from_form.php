<?php
include_once "conn.php";

$sql = 'SELECT * FROM drugs JOIN formdrugs ON drugs.drug_id = formdrugs.drug_id WHERE form_id = ' . $_GET['form_id'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while (
        $row = $result->fetch_assoc()
    ) {
        echo '<div class="form-group ml-3">';
        echo '    <label for="drug_' .
            $row['drug_id'] .
            '">
            <input type="hidden" class="positiveForCheckBox" name="positiveForCheckBoxName" id="drugName_' .
            $row['drug_id'] .
            '" value="' .
            $row['drug_id'] .
            '">
            <input type="checkbox" class="positiveForCheckBox" name="positiveForCheckBox" id="drug_' .
            $row['drug_id'] .
            '" value="' .
            $row['drug_id'] .
            '">';
        echo '&emsp;' .
            $row['drug_nm'];
        echo '</label></div>';
    }
}
?>