<?php
include('dbconnect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect values from the form
    $date = $_POST['date'];
    $time = $_POST['time'];
    $employee_name = $_POST['employee_name'];
    $accueil = $_POST['accueil'];
    $ea = $_POST['ea'];
    $repeter = $_POST['repeter'];
    $interrompt = $_POST['interrompt'];
    $participe = $_POST['participe'];
    $conforme = $_POST['conforme'];
    $explication_claire = $_POST['explication_claire'];
    $retranscrire = $_POST['retranscrire'];
    $c_fluide = $_POST['c_fluide'];
    $structure = $_POST['structure'];
    $vocabulaire = $_POST['vocabulaire'];
    $faute = $_POST['faute'];
    $prononciation = $_POST['prononciation'];
    $discours = $_POST['discours'];
    $attente = $_POST['attente'];
    $courtoisie = $_POST['courtoisie'];
    $conclusion = $_POST['conclusion'];
    $interlocuteur = $_POST['interlocuteur'];
    $conge = $_POST['conge'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO call_audit_data (date, time, employee_name, accueil, ea, repeter, interrompt, participe, conforme, explication_claire, retranscrire, c_fluide, structure, vocabulaire, faute, prononciation, discours, attente, courtoisie, conclusion, interlocuteur, conge) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssssssss", $date, $time, $employee_name, $accueil, $ea, $repeter, $interrompt, $participe, $conforme, $explication_claire, $retranscrire, $c_fluide, $structure, $vocabulaire, $faute, $prononciation, $discours, $attente, $courtoisie, $conclusion, $interlocuteur, $conge);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Form submitted successfully.";
                // Redirect to call_audit.php
        header("Location: call_audit.php");
                exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}
?>
