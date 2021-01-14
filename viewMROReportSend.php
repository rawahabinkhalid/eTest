<?php

date_default_timezone_set('Asia/Karachi');
include 'conn.php';
// if (isset($_POST['clientNameFilter'])) {
$sql = 'SELECT employees.first_nm, employees.last_nm, employees.emp_id, account_nm, division_nm, divisions.address, divisions.city, divisions.state, divisions.zip, collection_date, reported_date, mro_received_date, type_nm, test.lab_id, result, test.form_id FROM test JOIN accounts ON accounts.account_id = test.account_id JOIN employees ON employees.emp_id = test.emp_id JOIN divisions ON divisions.division_id = employees.division_id JOIN testtype ON testtype.type_id = test.type_id LEFT JOIN invoice ON invoice.invoice_id = test.invoice_id WHERE test.test_id = ' . $_GET['id'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();

	include_once 'vendor/tecnickcom/tcpdf/tcpdf.php';
	$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('eTest');
	$pdf->SetTitle('Document1.pdf');
	$pdf->SetSubject('Document');
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(5, 5, 5);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	// $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
	// set default font subsetting mode
	$pdf->setFontSubsetting(true);
	// $pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	// Set font
	$pdf->SetFont('helvetica', '', 10, '', true);
	$pdf->AddPage();
	// $pdf->setCellPaddings(1, 1, 1, 1);
	// $pdf->setCellMargins(0, 0, 0, 0);

	$html = '';
	$invoiceNo = 0;
	$tbl = '';
	$html = <<<EOD
                    <table cellspacing="0" cellpadding="3" border="0">
                        <tr>
                            <td>
                                <h1 style="text-align: center; font-size: 12px;">MRO DETERMINATION / VERIFICATION REPORT</h1>
                            </td>
						</tr>
                    </table>

EOD;
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$html = <<<EOD
    <table cellspacing="0" cellpadding="3" border="0">
    <tr>
    <td>
    </td>
    </tr>
		<tr>
            <td style="font-size: 9.5px; width:25%; font-weight: bold;">
            Employee Name / Req #:
			</td>
            <td style="font-size: 9.5px; width:25%;">
EOD;
	$html .= $row['first_nm'] . ' ' . $row['last_nm'];
	$html .= <<<EOD
			</td>
            <td style="font-size: 9.5px; width:25%; font-weight: bold;">
            Soc. Sec. / Employee ID #:
			</td>
            <td style="font-size: 9.5px; width:25%;">
EOD;
	$html .= $row['emp_id'];
	$html .= <<<EOD
			</td>
		</tr>
		<tr>
            <td style="font-size: 9.5px; width:25%; font-weight: bold;">
            Employer Name:
			</td>
            <td style="font-size: 9.5px; width:75%;">
EOD;
	$html .= $row['account_nm'] . ' ' . $row['division_nm'];
	$html .= <<<EOD
			</td>
		</tr>
		<tr>
            <td style="font-size: 9.5px; width:25%; font-weight: bold;">
            Employer's Address:
			</td>
            <td style="font-size: 9.5px; width:75%;">
EOD;
	$html .= $row['address'] . ' ' . $row['city'] . ' ' . $row['state'] . ' ' . $row['zip'];
	$html .= <<<EOD
			</td>
		</tr>
		<tr>
            <td style="font-size: 9.5px; width:25%; font-weight: bold;">
            Date of Collection:
			</td>
            <td style="font-size: 9.5px; width:75%;">
EOD;
	$html .= date('F d, Y', strtotime(explode(' ', $row['collection_date'])[0]));
	$html .= <<<EOD
			</td>
		</tr>
		<tr>
            <td style="font-size: 9.5px; width:30%; font-weight: bold;">
            Date MRO COC copy Received:
			</td>
            <td style="font-size: 9.5px; width:20%;">
EOD;
	if (!is_null($row['mro_received_date']) && $row['mro_received_date'] != '')
		$html .= date('F d, Y', strtotime(explode(' ', $row['mro_received_date'])[0]));
	$html .= <<<EOD
			</td>
            <td style="font-size: 9.5px; width:30%; font-weight: bold;">
            Date Reported:
			</td>
            <td style="font-size: 9.5px; width:20%;">
EOD;
	// $html .= date('F d, Y', strtotime(explode(' ', $row['reported_date'])[0]));
	if (!is_null($row['reported_date']) && $row['reported_date'] != '')
		$html .= date('F d, Y', strtotime(explode(' ', $row['reported_date'])[0]));
	$html .= <<<EOD
			</td>
		</tr>
		<tr>
            <td style="font-size: 9.5px; width:25%; font-weight: bold;">
            Collection Facility:
			</td>
            <td style="font-size: 9.5px; width:75%;">
EOD;
	$sqlCompany = 'SELECT MAX(company_id), company.* FROM company';
	$resultCompany = $conn->query($sqlCompany);
	if ($resultCompany->num_rows > 0) {
		$rowCompany = $resultCompany->fetch_assoc();
		$html .= $rowCompany['company_nm'] . '<br>' . $rowCompany['address'] . '<br>' . $rowCompany['city'] . ', ' . $rowCompany['state'] . ' ' . $rowCompany['zip'];
	}
	$html .= <<<EOD
			</td>
		</tr>
		<tr>
            <td style="font-size: 9.5px; width:25%; font-weight: bold;">
            Laboratory:
			</td>
            <td style="font-size: 9.5px; width:75%;">
EOD;
	$sqlLab = 'SELECT * FROM lab WHERE lab_id = ' . $row['lab_id'];
	$resultLab = $conn->query($sqlLab);
	if ($resultLab->num_rows > 0) {
		$rowLab = $resultLab->fetch_assoc();
		$html .= $rowLab['lab_nm'] . '<br>' . $rowLab['address'] . '<br>' . $rowLab['city'] . ', ' . $rowLab['state'] . ' ' . $rowLab['zip'];
	}

	$html .= <<<EOD
			</td>
		</tr>
		<tr>
            <td style="font-size: 9.5px; width:25%; font-weight: bold;">
            Type of Test:
			</td>
            <td style="font-size: 9.5px; width:75%;">
EOD;
	$html .= $row['type_nm'];
	$html .= <<<EOD
			</td>
		</tr>
		<tr>
            <td style="font-size: 9.5px; width:100%;">
			</td>
		</tr>
		<tr>
            <td style="font-size: 8px; width:100%;">
            The results for the identified specimen are in accordance with the applicable screening confirmation cut-off levels established by the DHHS/NIDA/SAMHSA mandatory guidelines for the Federal and the State DRUG FREE workplace testing programs.
			</td>
		</tr>
	</table>
	
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<td style="font-size: 9.5px; width: 100%; font-weight: bold;">
			My final determination / verification is:
			</td>
		</tr>
        <tr>
            <td style="width: 2%;">
EOD;
	$style6 = array('width' => 0.25, 'color' => array(0, 0, 0));
	if ($row['result'] == 'N')
		$pdf->Circle(9, 119, 2.5, 0, 360, 'F', $style6);
	else
		$pdf->Circle(9, 119, 2.5, 0, 360, null, $style6);
	$html .= <<<EOD
			</td>
            <td style="width: 22%; font-weight: bold;">
            Negative
			</td>
            <td style="width: 2%;">
EOD;
	$style6 = array('width' => 0.25, 'color' => array(0, 0, 0));
	if ($row['result'] == 'P')
		$pdf->Circle(55, 119, 2.5, 0, 360, 'F', $style6);
	else
		$pdf->Circle(55, 119, 2.5, 0, 360, null, $style6);
	$html .= <<<EOD
			</td>
            <td style="width: 22%; font-weight: bold;">
            Positive for:
			</td>
            <td style="width: 2%;">
EOD;
	$style6 = array('width' => 0.25, 'color' => array(0, 0, 0));
	$pdf->Circle(102, 119, 2.5, 0, 360, null, $style6);
	$html .= <<<EOD
			</td>
            <td style="width: 22%; font-weight: bold;">
            Test Cancelled:
			</td>
            <td style="width: 2%;">
EOD;
	$style6 = array('width' => 0.25, 'color' => array(0, 0, 0));
	$pdf->Circle(148, 119, 2.5, 0, 360, null, $style6);
	$html .= <<<EOD
			</td>
            <td style="width: 22%; font-weight: bold;">
            Refusal to test:
			</td>
        </tr>
	</table>
EOD;
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$html = <<<EOD
	<table cellspacing="0" cellpadding="2" border="0">
EOD;
	$pdf->setCellHeightRatio(0.6);
	$sqlDrugs = 'SELECT * FROM drugs JOIN formdrugs ON drugs.drug_id = formdrugs.drug_id WHERE form_id = ' . $row['form_id'];
	$resultDrugs = $conn->query($sqlDrugs);
	if ($resultDrugs->num_rows > 0) {
		while ($rowDrugs = $resultDrugs->fetch_assoc()) {
			$html .= <<<EOD
        <tr>
            <td style="width: 3%;">
			</td>
            <td style="width: 22%; font-weight: bold;">
			</td>
            <td style="width: 2%; height: 1px;">
			<div style="border: 1px solid black"></div>
			</td>
			<td style="width: 63%;">
EOD;
			$html .= $rowDrugs['drug_nm'];
			$html .= <<<EOD
			</td>
		</tr>
EOD;
		}
	}
	$html .= <<<EOD
	</table>
EOD;
	$pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
	$pdf->setCellHeightRatio(1.25);
	$html = <<<EOD
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<td style="font-size: 9.5px; font-weight: bold; width: 100%">
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; font-weight: bold; width: 100%">
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px;">
			Dr. Emily Vives, MD, MRO<br>
			11183 S Orange Blossom Trail Ste#240D<br>
			Orlando, FL 32837-
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<td style="font-size: 9.5px; font-weight: bold; width: 100%">
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; font-weight: bold; width: 100%">
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; font-weight: bold; width: 100%">
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; font-weight: bold; width: 100%">
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; font-weight: bold; width: 70%">
			Signature:
			<span style="width: 5%; text-align: center;">
			</span>
			<span style="width: 100%; text-align: center;">
			<img src="uploads/signature.png" style="width: 150px;">
			</span>
			</td>
			<td style="font-size: 9.5px; font-weight: bold; width: 10%">
			Date:
EOD;
	$html .= <<<EOD
			</td>
			<td style="font-size: 9.5px; width: 20%">
EOD;
	$html .= date('F d, Y');
	$html .= <<<EOD
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; font-weight: bold; width: 100%">
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; font-weight: bold; width: 100%">
			</td>
		</tr>
		<tr>
			<td style="font-size: 12px; width: 100%; text-align: center">
			RETAIN THIS FORM IN THE EMPLOYEE PERSONNEL FILE
			</td>
		</tr>
	</table>
EOD;
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$pdf->AddPage();

	$pdf->deletePage(intval($pdf->getPage() . '/' . $pdf->getNumPages()));

	$pdf->Output(__DIR__ . 'Invoice No - ' . '.pdf', 'F');
	// $data = explode('filename="Invoice_No_-_.pdf"', $data)[1];
	// // $data = str_replace('data:application/pdf;base64, ', 'data:application/pdf;base64,',$data);
	// // $data = chunk_split($fileatt);
	// $data = chunk_split($data);

	// echo $data;



	require 'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;

	$mail->IsSMTP();
	$mail->SMTPDebug = 0;

	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.ipage.com"; // host name
	$mail->Port = 465;
	$mail->Username = "rawaha.khalid@matz.group"; //email id
	$mail->Password = "R@wahak23996";  //password

	$mail->setFrom('rawaha.khalid@matz.group', 'Admin'); //from email
	$email_array = explode(',', $_POST['email_send']);
	if (count($email_array) > 1) {
		for ($i = 0; $i < count($email_array); $i++) {
			$mail->addAddress($email_array[$i]); //same email id as line16
		}
	} else {
		$mail->addAddress($_POST['email_send']); //same email id as line16
	}
	$mail->addReplyTo('rawaha.khalid@matz.group');


	$mail->isHTML(true);
	$mail->Subject = $_POST['message_subject_send'];
	$mail->Body = $_POST['message_body_send'];
	// $mail->AddStringAttachment($data,'Application.pdf');
	$mail->AddAttachment(__DIR__ . 'Invoice No - ' . '.pdf', '', $encoding = 'base64', $type = 'application/pdf');

	if (!$mail->Send()) {
		echo 'Error occurred while sending mail';
		// echo "Mailer Error: ". $mail->ErrorInfo;
	} else { //  echo $_POST['email_send'];
		// header('location:landingscreen.php?account='.$_GET['account'].'&id=' . $_GET['id']);
		// header('location:contact.html?email_sent');
		echo "Email successfully sent!!";
	}
	// }
}
