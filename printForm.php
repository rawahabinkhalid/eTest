<?php

date_default_timezone_set('Asia/Karachi');
include_once '../conn.php';

// if (isset($_POST['clientNameFilter'])) {
include_once '../vendor/tecnickcom/tcpdf/tcpdf.php';
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
$sql = 'SELECT * FROM lsuform WHERE Id = ' . $_GET['id'];
$result = $conn->query($sql);
if($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	// print_r($row);
	$html = '';
	$invoiceNo = 0;
	$tbl = '';
	$html = <<<EOD
                    <table cellspacing="0" cellpadding="3" border="0">
                        <tr>
                            <td>
                                <h1 style="text-align: center; font-size: 12px;">AGREEMENT TO SUBMIT TO AN ALCOHOL AND/OR DRUG TEST AND AUTHORIZATION FOR THE RELEASE OF TEST RESULTS</h1>
                            </td>
						</tr>
						<tr>
                            <td>
							I have been requested by <b><u>                 LSUHSC                 </u></b> to submit to an alcohol and/or drug test.<br>(Referring Source)
                            </td>
						</tr>
						<tr>
                            <td style="font-size: 9px;">
							I have been informed and I understand that my agreement to submit to the requested alcohol and/or drug test is completely voluntary on my part and that I have the right to refuse to submit to the test(s). I am aware and have been told that my refusal to submit to the tests will make me ineligible to be considered for employment and I will be disqualified from employment to an LSUHSC facility for up to one year or may be grounds for disciplinary action against me up to and including termination/expulsion. I am aware that if I refuse to submit to drug screening or if my test is positive, I will be disqualified for employment or appointment. Additionally, a prospective employee who intentionally tampers with the sample, the chain of custody (COC), identification procedures, or test results may be disqualified from employment for a period of three years.
                            </td>
						</tr>
						<tr>
                            <td style="font-size: 9px;">
							I understand that if the Medical Review Officer (MRO) (and/or the MRO agent and/or staff) or Drug Testing Coordinator (DTC) calls me about my drug test results I should call them back immediately. <b>I understand that if I do not contact and talk with the MRO</b> (and/or the MRO agent and/or staff) <b>then I have turned down the opportunity to discuss the results and the MRO</b> (and/or the MRO agent and/or staff) <b>will report my drug test as a positive.</b>
							</td>
						</tr>
						<tr>
							<td style="font-size: 9px;">
							I have been informed and am aware that the results of the alcohol and/or drug test(s) are protected by confidentiality requirements for alcohol and drug patient records under Federal laws and regulations. Therefore, I voluntarily agree to the below stated release of the test results.
                            </td>
						</tr>
						<tr>
							<td style="font-size: 9px;">
							I, <u style="font-size: 8px; padding-bottom: 10px">
EOD;
	$html .= $row['FirstName'] . ' ' . $row['LastName'] . '_____________';
	$html .= <<<EOD
							</u>(please print), authorize the MRO (and/or the MRO agent and/or staff) and the DTC who will receive the results of my alcohol and/or drug test to disclose the results of the test(s) to the appropriate Human Resource Director, my supervisor (as appropriate for employees, students, non-employees, or job applicants), the Administrative Body over me, and/or their designee for the purpose of determining the appropriateness of my eligibility for continued employment/enrollment. I authorize the above individuals and/or their designee to disclose those results to other Human Resource Directors, divisions, hospitals, facilities or their designees within the LSUHSC, and to other state and federal agencies, including the Department of State Civil Service, and LSU Health Care Network if appropriate, and /or to the above mentioned referring source.
							</td>
						</tr>
						<tr>
							<td style="font-size: 9px;">
							I understand that the MRO (and/or the MRO staff) may inform the Human Resource Director, my supervisor (as appropriate for employees, students, non-employees, or job applicants), the Administrative Body over me, their designee and/or above referring source of any legally obtained prescription medication I may be taking if it is felt that the usage of this medication(s) can or has compromised my fitness for duty in my capacity as an employee, student, or non-employee.
							</td>
						</tr>
						<tr>
							<td style="font-size: 9px;">
							I also understand that withdrawal of this permission prior to, or any time after, the release of the results of the alcohol and/or drug test to the above named individuals is grounds for terminating my employment/enrollment.
							</td>
						</tr>
						<tr>
							<td style="font-size: 9px;">
							I also understand that withdrawal of this permission prior to, or any time after, the release of the results of the alcohol and/or drug test to the above named individuals is grounds for terminating my employment/enrollment.
							</td>
                        </tr>
						<tr>
							<td>
							Daytime Phone # _____________________________ Evening Phone # _____________________________
							</td>
                        </tr>
						<tr>
							<td>
							Date of Birth _________________________________ Social Security # <u style="font-size: 8px;">__
EOD;
	$html .= $row['SSN'];
	// $html .= '<span style="font-color; black">';
	for ($i = strlen($row['SSN']); $i < 35; $i++)
		$html .= '_';
	// $html .= '</span>';
	$html .= <<<EOD
							</u></td>
                        </tr>
						<tr>
							<td>
							Street Address _________________________________________________________________________________
							</td>
                        </tr>
						<tr>
							<td>
							City ______________________________<span style="white-space: normal;">             </span>State _______________<span style="white-space: normal;">             </span>Zip Code ________________________________
							</td>
                        </tr>
						<tr>
							<td>
							Signature: ___________________________________________________<span style="white-space: normal;">             </span>Date: ____________________
							</td>
                        </tr>
						<tr>
							<td>
							Witness Signature: _____________________________________________ Date: ____________________
							</td>
						</tr>
						<tr>
							<td style="font-size: 9px"><b>
							* * * * * * * * * * TO BE COMPLETED BY LSUHSC-NO DESIGNATED AUTHORITY ONLY ** * * * * * * * *
							</b></td>
						</tr>
						<tr>
							<td>
							Collection Deadline: <u style="font-size: 8px;">__
EOD;
	$html .= date('m/d/Y', strtotime($row['Deadline']));
	for ($i = strlen(date('m/d/Y', strtotime($row['Deadline']))); $i < 50; $i++)
		$html .= '_';
	$html .= <<<EOD
							</u></td>
						</tr>
						<tr>
							<td>
							Dept: <u style="font-size: 8px;">__
EOD;
	$html .= $row['Dept'];
	for ($i = strlen($row['Dept']); $i < 45; $i++)
		$html .= '_';
	$html .= <<<EOD
							</u> Peoplesoft # <u style="font-size: 8px;">__
EOD;
	$peopleSoft = $row['Account'] . '-' . $row['Fund'] . '-' . $row['Department'] . '-' . $row['Program'] . '-' . $row['Class'] . '-' . $row['Project'];
	$html .= $peopleSoft;
	for ($i = strlen($peopleSoft); $i < 45; $i++)
		$html .= '_';
	$html .= <<<EOD
							</u>
							</td>
						</tr>
						<tr>
							<td>
							Designated Administrative Body:  <u style="font-size: 8px;">__
EOD;
	$html .= $row['Contact'];
	for ($i = strlen($row['Contact']); $i < 55; $i++)
		$html .= '_';
	$html .= <<<EOD
							</u></td>
                        </tr>
						<tr>
							<td>
							Email Address for Results: <u style="font-size: 8px;">__
EOD;
	$html .= $row['Email'];
	for ($i = strlen($row['Email']); $i < 60; $i++)
		$html .= '_';
	$html .= <<<EOD
							</u>
							</td>
                        </tr>
						<tr>
							<td style="font-size: 8px; text-align:justify;">
							“This consent form is subject to revocation at anytime except to the extent that the program which is to make the disclosure has already taken action in reliance on it. If not previously revoked this consent will terminate upon conclusion of any proceedings, administrative, judicial or internal, as to which the test results are sought to be used.”
							</td>
						</tr>
						<tr>
							<td style="font-size: 8px; text-align:justify">
							NOTE: To the Party receiving this information: This information has been disclosed to you from the records whose confidentiality is protected by federal law. Federal regulations (42 CFR Part 2.31(a)(2)) prohibit you from making any further disclosure of it without the specific written consent of the person to whom it pertains, or as otherwise permitted by such regulations. A general authorization for the release of medical or other information is not for this purpose.
     						</td>
						</tr>
						<tr>
							<td style="font-size: 8px; text-align: right; font-weight: bold;">
							Campus Health/forms/2017_03_14
							</td>
                        </tr>


EOD;
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

	$pdf->AddPage();
	$pdf->SetMargins(5, 0, 5);
	$html = <<<EOD
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
				<h1 style="text-align: center; font-size: 12px;">LSUHSC NEW ORLEANS CAMPUS POST JOB OFFER DRUG TESTING INSTRUCTIONS FOR JOB CANDIDATES & HOUSE OFFICERS</h1>
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px;">
			The following is being provided to you in order to comply with the Louisiana State University Health Sciences Center, New Orleans (LSUHSC-NO) campus Substance Abuse Policy. LSUHSC-NO requires drug testing of all full time faculty, staff, residents, and employees once a job has been offered. If you have accepted the job, please follow these steps closely. Failure to comply with these guidelines could result in ineligibility for employment. If you have any questions please call the contact name listed below.
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px;">
			LSUHSC-NO has established several <i>Pre-Authorized Collections Site</i> within Louisiana and the New Orleans Metropolitan Area that are able to do the drug test. LSUHSC-NO additionally has established a <i>Call for Authorization Collection Site</i> with <b>RN Expertise</b> which allows individuals to be tested at sites out side of Louisiana and in areas which may be more convenient for our prospective employees. LSUHSC-NO will pay for a drug test performed at another location only if prior authorization is obtained. You will have five (5) working days to obtain this drug test after notification.
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px;">
			Please follow the sets of instructions carefully.
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px;">
			<b>1. PRE-AUTHORIZED COLLECTION SITES (New Orleans, Baton Rouge, Lafayette, Lake Charles, Bogalusa).</b>
			<ol type="A">
			<li>
			Go to Human Resources or the business office manager or designee of the department who has offered you employment, contact name is listed below. They will provide you with a <i>“Drug Testing Notification”</i> form, Chain of Custody (COC) form and an <i>“Agreement To Submit To An Alcohol And/Or Drug Test And Authorization For The Release Of Test Results”</i> form.
			</li>
			<li>
			The <i>“Drug Testing Notification”</i> form will have the name and location of the collection site that you will need to go to have the test completed.
			</li>
			<li>
			You need to complete and sign the enclosed <i>“Agreement To Submit To An Alcohol And/Or Drug Test And Authorization For The Release Of Test Results”</i> form. Give the signed completed form to the contact name listed below.
			</li>
			<li>
			Take the <i>“Drug Testing Notification”</i> form, the Chain of Custody form and one of the following forms of identification with you to the collection site: 1) valid driver’s license, 2) valid picture state identification, or 3) passport to the collection site and proceed with the test.
			</li>
			</ol>
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px;">
			<b>2. CALL FOR AUTHORIZATION COLLECTION SITE (Out of state and special requests within Louisiana)</b>
			<ol type="A">
			<li>
			If you have not done so, you need to inform Human Resources or the business office manager or designee of the department who is hiring you, contact name listed below, if you are out of state or unable to go to the LSUHSC-NO Pre-Authorized Collection site.
			</li>
			<li>
			The contact name listed below will send you a <b><i>“Drug Testing Notification”</i></b> form and an <i>“Agreement To Submit To An Alcohol And/Or Drug Test And Authorization For The Release Of Test Results”</i> form.
			</li>
			<li>
			You MUST complete the enclosed <i>Agreement To Submit To An Alcohol And/Or Drug Test And Authorization For The Release Of Test Results”</i>, and mail the signed original to the contact name below.
			</li>
			<li>
			After steps 2A, 2B, and 2C are complete, verify with the contact name listed below that the <i>“Agreement To Submit To An Alcohol And/Or Drug Test And Authorization For The Release Of Test Results”</i> form has been received. <b>You will need to schedule your test by the test deadline date provided by your department.</b> You can go to <a href="www.labcorp.com" target="_blank">www.labcorp.com</a> to locate the approved LabCorp collection site nearest you. There you may schedule a time for your test. If there are no LabCorp collection site within 35 miles, or if you need further assistance, contact <b>RN Expertise</b> at <b>(407) 865-6544</b> who will locate an approved collection site for you.
			</li>
			<li>
			Once you receive the Chain of Custody form, take it and the <i>Drug Testing Notification</i> Form with you to the assigned collection site.
			</li>
			<li>
			You must present at the collection site one of the following forms of identification: 1) valid driver’s license, 2) valid picture state identification, or 3) passport.
			</li>
			</ol>
			</td>
		</tr>

		<tr>
			<td style="font-size: 9.5px;">
			3. All drug test results will be sent to a Medical Review Officer (MRO). Once the results have been verified by the MRO the appropriate Authorized Designated Body will be notified. If the MRO or the Drug Testing Coordinator (DTC) from the New Orleans campus calls you about your drug test results, you need to call them back immediately. If you fail to contact them within 72 hours, the results will be sent without confirmation.
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px;">
			4. Questions concerning your hiring and your “Agreement To Submit To An Alcohol And/Or Drug Test And Authorization For The Release Of Test Results” form should be directed to: (Contact Information To be completed by Program Office)
			</td>
		</tr>
		<tr>
			<td>
			Contact Name: __________________________________ Department: <u style="font-size: 8px;">__
EOD;
	$html .= $row['Dept'];
	for ($i = strlen($row['Dept']); $i < 40; $i++)
		$html .= '_';
	$html .= <<<EOD
							</u></td>
		</tr>
		<tr>
			<td>
			Phone: _______________________ Fax: ________________________ Email: <u style="font-size: 8px;">__
EOD;
	$html .= $row['Email'];
	for ($i = strlen($row['Email']); $i < 32; $i++)
		$html .= '_';
	$html .= <<<EOD
							</u>
			</td>
		</tr>
		<tr>
			<td>
			Address: _____________________________________________________________________________________
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td style="font-size: 8px; text-align: right;">
			Worksite Health / form/ RV April 4, 2017
			</td>
		</tr>


EOD;
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$pdf->AddPage();

	$pdf->SetMargins(5, 0, 5);
	$html = <<<EOD
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
				<h1 style="text-align: center; font-size: 12px;">DRUG TESTING NOTIFICATION FORM</h1>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<td style="font-size: 9.5px; background-color:grey; width:50%;">
			<b>Section 1: Employer</b>
			</td>
			<td style="font-size: 9.5px; background-color:grey; width:50%;">
			<b>MRO</b>
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; width:50%;">
			<b style="font-size: 12px;">LSUHSC-New Orleans Employee</b>
			<br>
			DER: Scott Embley
			<br>
			691 Douglas Ave. Ste. 101
			<br>
			Altamonte Springs, FL. 32714
			<br>
			Ph# 407-865-6544 Fax # 407-865-7993
			</td>
			<td style="font-size: 9.5px; width:50%;">
			<br>
			<br>
			RN Expertise, Inc.
			<br>
			214 Hickman Drive Ste. 102
			<br>
			Sanford, FL. 32771
			<br>
			Ph# 407-865-6544 Fax # 407-865-7993
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<td style="font-size: 9.5px; background-color:grey;">
			<b>Section 2<i>(To be completed by Employer)</i></b>
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px;">
			Complete the employee information in Section 2 and check the appropriate boxes in Section 3. Incomplete or incorrect information may cause reporting delays
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px;">
			This form and a picture identification card must be presented to the drug testing collector. You are required to undergo urine drug testing as a condition of hiring. You must have the drug screen on the appointment date and with in the specified hours listed below.
			</td>
		</tr>
		<tr>
			<td style="text-decoration: underline">
			___________________________________________________________________________________________________
			</td>
		</tr>
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td>
			Applicant/Employee Name: <u style="font-size: 8px; padding-bottom: 10px">__
EOD;
	$html .= $row['FirstName'] . ' ' . $row['LastName'];
	for ($i = strlen($row['FirstName'] . ' ' . $row['LastName']); $i < 45; $i++)
		$html .= '_';
	$html .= <<<EOD
			</u></td>
		</tr>
		<tr>
			<td>
			Chain of Custody #:<u style="font-size: 8px; padding-bottom: 10px">__
EOD;
	$html .= $row['Specimen'];
	for ($i = strlen($row['Specimen']); $i < 45; $i++)
		$html .= '_';
	$html .= <<<EOD
			</u></td>
		</tr>
		<tr>
			<td>
			Social Security Number:<u style="font-size: 8px; padding-bottom: 10px">__
EOD;
	$html .= $row['SSN'];
	for ($i = strlen($row['SSN']); $i < 45; $i++)
		$html .= '_';
	$html .= <<<EOD
			</u></td>
		</tr>
		<tr>
			<td>
			Name & Location of Collection: <u style="font-size: 8px; padding-bottom: 10px">__
EOD;
	$html .= $row['Collection'];
	for ($i = strlen($row['Collection']); $i < 45; $i++)
		$html .= '_';
	$html .= <<<EOD
			</u></td>
		</tr>
		<tr>
			<td>
			Collection Deadline* <u style="font-size: 8px;">__
EOD;
	$html .= date('m/d/Y', strtotime($row['Deadline']));
	for ($i = strlen(date('m/d/Y', strtotime($row['Deadline']))); $i < 45; $i++)
		$html .= '_';
	$html .= <<<EOD
							</u></td>
		</tr>
		<tr>
			<td style="text-align: center">
			* For testing out side of Louisiana testing must be completed within 24 hours after receiving COC.
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; background-color:grey;">
			<b>Section 3<i>(To be completed by Employer)</i></b>
			</td>
		</tr>
	</table>
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<td style="font-size: 9.5px; width: 50%">
			THE PURPOSE OF THIS TEST IS FOR (Check One)
			</td>
			<td style="font-size: 9.5px; width: 4%">
			<div style="width: 5px; height: 5px; border: 2px solid black"></div>
			<div style="width: 5px; height: 5px; border: 2px solid black"></div>
			</td>
			<td style="font-size: 9.5px; width: 21%">
			Pre-Employment
			<br>
			<br>
			Random
			</td>
			<td style="font-size: 9.5px; width: 4%">
			<div style="width: 5px; height: 5px; border: 2px solid black"></div>
			<div style="width: 5px; height: 5px; border: 2px solid black"></div>
			</td>
			<td style="font-size: 9.5px; width: 21%">
			Post Accident / For Cause
			<br>
			<br>
			Other / Monitoring
			</td>

		</tr>
	</table>
	<table cellspacing="0" cellpadding="3" border="0">
		<tr>
			<td style="font-size: 9.5px;">
			<b>Check the Boxes that Apply:</b>
			</td>
		</tr>
	</table>
	<table cellspacing="5" cellpadding="3" border="0">
		<tr>
			<td style="font-size: 9.5px; width: 4%; height: 100px">
			<div style="width: 5px; height: 5px; border: 2px solid black"></div>
			<br>
			<br>
			<div style="width: 5px; height: 5px; border: 2px solid black"></div>
			<br>
			<br>
			<div style="width: 5px; height: 5px; border: 2px solid black"></div>
			</td>
			<td style="font-size: 9.5px; width: 37%;">
			Non-DOT 7 Panel + Oxycodone (Standard Pre-Employment)
			<br>
			<br>
			Non-DOT Breath Alcohol
			(Post- Accident or Reason. Suspicion)
			<br>
			<br>
			<br>
			<br>
			10+MDMA+Oxy
			</td>
			<td style="font-size: 9.5px; width: 4%">
			</td>
			<td style="font-size: 9.5px; width: 4%">
			<div style="width: 5px; height: 5px; border: 2px solid black"></div>
			<br>
			<br>
			<div style="width: 5px; height: 5px; border: 2px solid black"></div>
			</td>
			<td style="font-size: 9.5px; width: 42%">
			<br>
			Non-DOT MedPro B + Propofol
			<br>
			<br>
			<br>
			<br>
			EtG
			Add On or Stand Alone
			</td>
		</tr>
		<tr>
			<td style="width: 100%">
			<b>Fax Copy 2 of the COC to the MRO @ (407) 865-7993</b>
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; background-color:grey;">
			<b>Section 4 Breath Alcohol Information</b>
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; width: 25%;">
			<b>If test result is negative:</b>
			</td>
			<td style="font-size: 9.5px; width: 75%;">
			Fax to the DER @ (504) 568-3892 AND to RN Expertise @ (407) 865-7993
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; width: 25%;">
			<b>If test result is positive:</b>
			</td>
			<td style="font-size: 9.5px; width: 75%;">
			<u><i>IMMEDIATELY</i></u> Contact the DER (504) 568-8888 <b>and</b>
			Fax to RN Expertise @ (407) 865-7993
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; width: 100%;">
			<b>If DER is unavailable and cannot be reached by the B.A.T., contact the RN Expertise Account Manager immediately at 407-865-6544 for assistance in reaching DER.</b>
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; width: 100%; text-align: right">
			</td>
		</tr>
		<tr>
			<td style="font-size: 9.5px; width: 100%; text-align: right">
			Drug Testing Notification Form RV 4 March 14, 2017
			</td>
		</tr>

	</table>
		

EOD;
	$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
	$pdf->AddPage();

	$pdf->deletePage(intval($pdf->getPage() . '/' . $pdf->getNumPages()));
	// <td border="1" style="width: 44%; border-left: 0px solid white"><br><br>
	// <td border="1" style="width: 18%; border-right: 0px solid white">

	$pdf->Output('Invoice No - ' . '.pdf');
}
?>