<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection code here
    include('dbconnect.php'); // Replace with your actual database connection code

    // Array to store values from the form
    $formValues = [];

    // Define the keys for the form values
    $keys = ['incidentOrChange', 'processOrTechnical', 'ticketAcknowledgement', 'incidentAnalysisTotal', 'investigationTotal', 'preciseCallSummary', 'relanceTimelyManner', 'correctFollowUpMail', 'correctCiInternalService', 'changeResolutionTemplate', 'noteObtenueTotal', 'communicationTotal', 'resolutionTotal', 'incidentOCDScope', 'incidentPriority', 'incidentRouted', 'incidentTaskCreation', 'understandsProblem', 'understandsErrorMessages', 'rfiSentToUser', 'preliminaryDiagnostics', 'inDepthTroubleshooting', 'actionTakenForResolution', 'validationZISO', 'validationPSSL3', 'tagOnShortDescription', 'mailSentForInfo', 'implementationTaskState', 'customRequests', 'qualificationPerformed', 'correctQualification'];

    // Store values from $_POST into $formValues
    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            $formValues[] = $_POST[$key];
        } else {
            $formValues[] = 0; // or any default value you prefer
        }
    }

    // Build the placeholders for the prepared statement
    $placeholders = rtrim(str_repeat('?,', count($formValues)), ',');
    // Build the SQL query
    $sql = "INSERT INTO form_data (ticketAcknowledgement, incidentAnalysisTotal, investigationTotal, preciseCallSummary, relanceTimelyManner, correctFollowUpMail, correctCiInternalService, changeResolutionTemplate, noteObtenueTotal, communicationTotal, resolutionTotal, incidentOCDScope, incidentPriority, incidentRouted, incidentTaskCreation, understandsProblem, understandsErrorMessages, rfiSentToUser, preliminaryDiagnostics, inDepthTroubleshooting, actionTakenForResolution, validationZISO, validationPSSL3, tagOnShortDescription, mailSentForInfo, implementationTaskState, customRequests, qualificationPerformed, correctQualification) 
    VALUES ($placeholders)";
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters with the form values
    $incidentOrChange = isset($_POST['incidentOrChange']) ? $_POST['incidentOrChange'] : "incident";
    $processOrTechnical = isset($_POST['processOrTechnical']) ? $_POST['processOrTechnical'] : "technical";
    $ticketAcknowledgement = isset($_POST['ticketAcknowledgement']) ? $_POST['ticketAcknowledgement'] : 0;
    $incidentAnalysisTotal = isset($_POST['incidentAnalysisTotal']) ? $_POST['incidentAnalysisTotal'] :0;
    $investigationTotal = isset($_POST['investigationTotal']) ? $_POST['investigationTotal'] :0;
    $preciseCallSummary = isset($_POST['preciseCallSummary']) ? $_POST['preciseCallSummary'] :0;
    $relanceTimelyManner = isset($_POST['relanceTimelyManner']) ? $_POST['relanceTimelyManner'] :0;
    $correctFollowUpMail = isset($_POST['correctFollowUpMail']) ? $_POST['correctFollowUpMail'] :0;
    $correctCiInternalService = isset($_POST['correctCiInternalService']) ? $_POST['correctCiInternalService'] :0;
    $changeResolutionTemplate = isset($_POST['changeResolutionTemplate']) ? $_POST['changeResolutionTemplate'] :0;
    $noteObtenueTotal = isset($_POST['noteObtenueTotal']) ? $_POST['noteObtenueTotal'] :0;
    $communicationTotal = isset($_POST['communicationTotal']) ? $_POST['communicationTotal'] :0;
    $resolutionTotal = isset($_POST['resolutionTotal']) ? $_POST['resolutionTotal'] :0;
    $incidentOCDScope = isset($_POST['incidentOCDScope']) ? $_POST['incidentOCDScope'] :0;
    $incidentPriority = isset($_POST['incidentPriority']) ? $_POST['incidentPriority'] :0;
    $incidentRouted = isset($_POST['incidentRouted']) ? $_POST['incidentRouted'] :0;
    $incidentTaskCreation = isset($_POST['incidentTaskCreation']) ? $_POST['incidentTaskCreation'] :0;
    $understandsProblem = isset($_POST['understandsProblem']) ? $_POST['understandsProblem'] :0;
    $understandsErrorMessages = isset($_POST['understandsErrorMessages']) ? $_POST['understandsErrorMessages'] :0;
    $rfiSentToUser = isset($_POST['rfiSentToUser']) ? $_POST['rfiSentToUser'] :0;
    $preliminaryDiagnostics = isset($_POST['preliminaryDiagnostics']) ? $_POST['preliminaryDiagnostics'] :0;
    $inDepthTroubleshooting = isset($_POST['inDepthTroubleshooting']) ? $_POST['inDepthTroubleshooting'] :0;
    $actionTakenForResolution = isset($_POST['actionTakenForResolution']) ? $_POST['actionTakenForResolution'] :0;
    $validationZISO = isset($_POST['validationZISO']) ? $_POST['validationZISO'] :0;
    $validationPSSL3 = isset($_POST['validationPSSL3']) ? $_POST['validationPSSL3'] :0;
    $tagOnShortDescription = isset($_POST['tagOnShortDescription']) ? $_POST['tagOnShortDescription'] :0;
    $mailSentForInfo = isset($_POST['mailSentForInfo']) ? $_POST['mailSentForInfo'] :0;
    $implementationTaskState = isset($_POST['implementationTaskState']) ? $_POST['implementationTaskState'] :0;
    $customRequests = isset($_POST['customRequests']) ? $_POST['customRequests'] :0;
    $qualificationPerformed = isset($_POST['qualificationPerformed']) ? $_POST['qualificationPerformed'] :0;
    $correctQualification = isset($_POST['correctQualification']) ? $_POST['correctQualification'] :0;

        // Before preparing the statement, add this to check the values
    var_dump(
        $incidentOrChange,
        $processOrTechnical,
        $ticketAcknowledgement,
        $incidentAnalysisTotal,
        $investigationTotal,
        $preciseCallSummary,
        $relanceTimelyManner,
        $correctFollowUpMail,
        $correctCiInternalService,
        $changeResolutionTemplate,
        $noteObtenueTotal,
        $communicationTotal,
        $resolutionTotal,
        $incidentOCDScope,
        $incidentPriority,
        $incidentRouted,
        $incidentTaskCreation,
        $understandsProblem,
        $understandsErrorMessages,
        $rfiSentToUser,
        $preliminaryDiagnostics,
        $inDepthTroubleshooting,
        $actionTakenForResolution,
        $validationZISO,
        $validationPSSL3,
        $tagOnShortDescription,
        $mailSentForInfo,
        $implementationTaskState,
        $customRequests,
        $qualificationPerformed,
        $correctQualification
    );

if ($stmt) {
    // Dynamically bind the values
    $types = str_repeat('s', count($formValues)); // Assuming all values are strings
    $stmt->bind_param($types, ...$formValues);

    // Execute the statement
    if ($stmt->execute()) {
        echo 'Data inserted successfully!';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle the case where the statement preparation failed
    echo 'Error: ' . $conn->error;
}

// Close the database connection
$conn->close();
} else {
// Redirect or display an error message if the form is not submitted
echo 'Form submission error.';
}
?>
