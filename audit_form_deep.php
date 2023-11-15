<!DOCTYPE html>
<html>
<head>
    <title>Audit Form</title>  
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log("DOMContentLoaded event handler is executed.");

        // Function to show sections based on dropdown selections
        function showSections() {
            const incidentOrChange = document.getElementById('incidentOrChange').value;
            const processOrTechnical = document.getElementById('processOrTechnical').value;

            // Hide all sections first
            document.querySelectorAll('.section').forEach(section => {
                section.style.display = 'none';
            });

            // Show the selected section based on the dropdown values
            const sectionId = `${incidentOrChange}${processOrTechnical}Section`;
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            } else {
                console.error(`Section with ID '${sectionId}' not found.`);
            }
        }

        // Attach change event listeners to the incidentOrChange and processOrTechnical dropdowns
        const incidentOrChangeDropdown = document.getElementById('incidentOrChange');
        const processOrTechnicalDropdown = document.getElementById('processOrTechnical');

        incidentOrChangeDropdown.addEventListener('change', showSections);
        processOrTechnicalDropdown.addEventListener('change', showSections);

        // Initial call to set the initial section visibility
        showSections();

        // Select all the dropdowns in each section
        const dropdowns = document.querySelectorAll('select');

        // Attach change event listeners to each dropdown
        dropdowns.forEach(function (dropdown) {
            dropdown.addEventListener('change', calculateTotals);
        });

        // Function to calculate the total for a section
        function calculateSectionTotal(sectionId) {
            const section = document.getElementById(sectionId);
            const selectsInSection = section.querySelectorAll('select');
            let total = 0;

            selectsInSection.forEach(select => {
                total += parseFloat(select.value);
            });

            return total;
        }

        // Function to calculate totals
        function calculateTotals() {
            // Calculate totals for each section and update the corresponding input fields
            const incidentProcessTotal = calculateSectionTotal('incidentprocessSection');
            document.getElementById('investigationTotal').value = incidentProcessTotal;

            const incidentTechnicalTotal = calculateSectionTotal('incidenttechnicalSection');
            document.getElementById('incidentAnalysisTotal').value = incidentTechnicalTotal;

            const changeProcessTotal = calculateSectionTotal('changeprocessSection');
            document.getElementById('noteObtenueTotalChange').value = changeProcessTotal;

            const changeTechnicalTotal = calculateSectionTotal('changetechnicalSection');
            document.getElementById('scoreTotal').value = changeTechnicalTotal;

            // Calculate and update the Communication (Total) field
            const communicationTotal = calculateCommunicationTotal();
            document.getElementById('communicationTotal').value = communicationTotal;

            // Calculate and update the Resolution (Total) field
            const resolutionTotal = calculateResolutionTotal();
            document.getElementById('resolutionTotal').value = resolutionTotal;

            // Calculate and update the Note Obtenue (Total) field
            const noteObtenueTotal = calculateNoteObtenueTotal();
            document.getElementById('noteObtenueTotal').value = noteObtenueTotal;
        }

        // Function to calculate the "Acknowledgement of ticket" total
        function calculateAcknowledgementTotal() {
            const ticketAcknowledgement = parseFloat(document.getElementById('ticketAcknowledgement').value);

            // Set the total in the "Acknowledgement of ticket (Total)" input field
            document.getElementById('acknowledgementTotal').value = ticketAcknowledgement;
        }

        // Function to calculate the "Incident Analysis" total
        function calculateIncidentAnalysisTotal() {
            const incidentOCDScope = parseFloat(document.getElementById('incidentOCDScope').value);
            const incidentPriority = parseFloat(document.getElementById('incidentPriority').value);

            // Calculate the total for "Incident Analysis"
            const incidentAnalysisTotal = incidentOCDScope + incidentPriority;

            // Set the total in the "Incident Analysis (Total)" input field
            document.getElementById('incidentAnalysisTotal').value = incidentAnalysisTotal;
        }

        // Function to calculate the "Investigation" total 1
        function calculateInvestigationTotal() {
            const incidentRouted = parseFloat(document.getElementById('incidentRouted').value);
            const incidentTaskCreation = parseFloat(document.getElementById('incidentTaskCreation').value);

            // Calculate the total for "Investigation"
            const investigationTotal = incidentRouted + incidentTaskCreation;

            // Set the total in the "Investigation (Total)" input field
            document.getElementById('investigationTotal').value = investigationTotal;
        }

        // Function to calculate Communication (Total)
        function calculateCommunicationTotal() {
            const preciseCallSummary = parseFloat(document.getElementById('preciseCallSummary').value);
            const relanceTimelyManner = parseFloat(document.getElementById('relanceTimelyManner').value);
            const correctFollowUpMail = parseFloat(document.getElementById('correctFollowUpMail').value);

            // Calculate the total for "Communication"
            const communicationTotal = preciseCallSummary + relanceTimelyManner + correctFollowUpMail;

            return communicationTotal;
        }

        // Function to calculate Resolution (Total)
        function calculateResolutionTotal() {
            const correctCiInternalService = parseFloat(document.getElementById('correctCiInternalService').value);
            const changeResolutionTemplate = parseFloat(document.getElementById('changeResolutionTemplate').value);

            // Calculate the total for "Resolution"
            const resolutionTotal = correctCiInternalService + changeResolutionTemplate;

            return resolutionTotal;
        }

        calculateNoteObtenueTotal

        // Function to calculate the "Incident Analysis" total
        function calculateIncidentAnalysisTotal() {
            const understandsProblem = parseFloat(document.getElementById('understandsProblem').value);
            const understandsErrorMessages = parseFloat(document.getElementById('understandsErrorMessages').value);
            const rfiSentToUser = parseFloat(document.getElementById('rfiSentToUser').value);
            const preliminaryDiagnostics = parseFloat(document.getElementById('preliminaryDiagnostics').value);

            // Calculate the total for "Incident Analysis"
            const incidentAnalysisTotal =
                understandsProblem + understandsErrorMessages + rfiSentToUser + preliminaryDiagnostics;

            // Set the total in the "Incident Analysis (Total)" input field
            document.getElementById('incidentAnalysisTotal').value = incidentAnalysisTotal;
        }

        // Function to calculate the "Investigation" total
        function calculateInvestigationTotals() {
            const inDepthTroubleshooting = parseFloat(document.getElementById('inDepthTroubleshooting').value);
            const actionTakenForResolution = parseFloat(document.getElementById('actionTakenForResolution').value);

            // Calculate the total for "Investigation"
            const investigationTotal = inDepthTroubleshooting + actionTakenForResolution;

            // Set the total in the "Investigation (Total)" input field
            document.getElementById('investigationTotal').value = investigationTotal;
             }

        function calculateNoteObtenueTotal() {
            const acknowledgementOfTicket = parseFloat(document.getElementById('ticketAcknowledgement').value);
            const incidentAnalysisTotal = parseFloat(document.getElementById('incidentAnalysisTotal').value);
            const investigationTotal = parseFloat(document.getElementById('investigationTotal').value);
            const communicationTotal = parseFloat(document.getElementById('communicationTotal').value);
            const resolutionTotal = parseFloat(document.getElementById('resolutionTotal').value);

            console.log('acknowledgementOfTicket:', acknowledgementOfTicket);
            console.log('incidentAnalysisTotal:', incidentAnalysisTotal);
            console.log('investigationTotal:', investigationTotal);
            console.log('communicationTotal:', communicationTotal);
            console.log('resolutionTotal:', resolutionTotal);

            // Calculate the total for "Note Obtenue"
            const noteObtenueTotal =
                acknowledgementOfTicket + incidentAnalysisTotal + investigationTotal + communicationTotal + resolutionTotal;

            console.log('noteObtenueTotal:', noteObtenueTotal);

            // Set the total in the "Note Obtenue (Total)" input field
            document.getElementById('noteObtenueTotal').value = noteObtenueTotal;
        }

        // Function to calculate the "Score" total
        function calculateScoreTotal() {
            const qualificationPerformed = parseFloat(document.getElementById('qualificationPerformed').value);
            const correctQualification = parseFloat(document.getElementById('correctQualification').value);

            // Calculate the total for "Score"
            const scoreTotal = qualificationPerformed + correctQualification;

            // Set the total in the "Score (Total)" input field
            document.getElementById('scoreTotal').value = scoreTotal;
        }

       // Event listeners for changes in the selects for each section
        document.getElementById('ticketAcknowledgement').addEventListener('change', calculateNoteObtenueTotal);
        document.getElementById('incidentAnalysisTotal').addEventListener('input', calculateNoteObtenueTotal);
        document.getElementById('investigationTotal').addEventListener('input', calculateNoteObtenueTotal);
        document.getElementById('preciseCallSummary').addEventListener('change', calculateCommunicationTotal);
        document.getElementById('relanceTimelyManner').addEventListener('change', calculateCommunicationTotal);
        document.getElementById('correctFollowUpMail').addEventListener('change', calculateCommunicationTotal);
        document.getElementById('correctCiInternalService').addEventListener('change', calculateResolutionTotal);
        document.getElementById('changeResolutionTemplate').addEventListener('change', calculateResolutionTotal);


        // Initial call to calculate and set the initial totals
        calculateTotals();
    });
    
    </script> 
</head>
<body>
    <header>
        <?php include 'common.php'; ?>
    </header>
    <h1>Audit Form</h1>

    <form action="insert_data.php" method="post">
        <label for="incidentOrChange">Choose Incident or Change/Request:</label>
        <select id="incidentOrChange" name="incidentOrChange" >
            <option value="incident">Incident</option>
            <option value="change">Change/Request</option>
        </select>

        <label for="processOrTechnical">Choose Process or Technical:</label>
        <select id="processOrTechnical" name="processOrTechnical" >
            <option value="process">Process</option>
            <option value="technical">Technical</option>
        </select>

        <!-- Incident Process Section -->
        <div id="incidentprocessSection" class="section">
            <h2>Incident Process Section</h2>

            <!-- Question 1 -->
            <label for="ticketAcknowledgement">Ticket acknowledged within less than 15 minutes:</label>
            <select id="ticketAcknowledgement" name="ticketAcknowledgement" >
                <option value="0">0 (KO)</option>
                <option value="1">1 (AA)</option>
                <option value="2">2 (OK)</option>
            </select>
            <br>

            <!-- Question 2 -->
            <label for="incidentOCDScope">Does incident fall under OCD scope:</label>
            <select id="incidentOCDScope" name="incidentOCDScope" >
                <option value="0">0 (KO)</option>
                <option value="3.5">3.5 (AA)</option>
                <option value="7">7 (OK)</option>
            </select>
            <br>

            <!-- Question 3 -->
            <label for="incidentPriority">Priority of incident:</label>
            <select id="incidentPriority" name="incidentPriority" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Question 4 -->
            <label for="incidentRouted">Incident routed to the correct team:</label>
            <select id="incidentRouted" name="incidentRouted" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Question 5 -->
            <label for="incidentTaskCreation">Creation of incident task to the correct team:</label>
            <select id="incidentTaskCreation" name="incidentTaskCreation" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Total for Investigation -->
            <label for="investigationTotal">Investigation (Total):</label>
            <input type="text" id="investigationTotal" name="investigationTotal" readonly>
            <br>

            <!-- Question 7 -->
            <label for="preciseCallSummary">Precise call summary sent to user/Concise and clear language:</label>
            <select id="preciseCallSummary" name="preciseCallSummary" >
                <option value="0">0 (KO)</option>
                <option value="1.5">1.5 (AA)</option>
                <option value="3">3 (OK)</option>
            </select>
            <br>

            <!-- Question 8 -->
            <label for="relanceTimelyManner">Relance done in a timely manner:</label>
            <select id="relanceTimelyManner" name="relanceTimelyManner" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Question 9 -->
            <label for="correctFollowUpMail">Correct follow-up on mail:</label>
            <select id="correctFollowUpMail" name="correctFollowUpMail" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Total for Communication -->
            <label for="communicationTotal">Communication (Total):</label>
            <input type="text" id="communicationTotal" name="communicationTotal" readonly>
            <br>

            <!-- Question 11 -->
            <label for="correctCiInternalService">Correct CI, Internal service:</label>
            <select id="correctCiInternalService" name="correctCiInternalService" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Question 12 -->
            <label for="changeResolutionTemplate">Change to FIX / Correct Resolution template:</label>
            <select id="changeResolutionTemplate" name="changeResolutionTemplate" >
                <option value="0">0 (KO)</option>
                <option value="4">4 (AA)</option>
                <option value="8">8 (OK)</option>
            </select>
            <br>

            <!-- Total for Resolution -->
            <label for="resolutionTotal">Resolution (Total):</label>
            <input type="text" id="resolutionTotal" name="resolutionTotal" readonly>
            <br>

            <!-- Total for Note Obtenue -->
            <label for="noteObtenueTotal">Note Obtenue (Total):</label>
            <input type="text" id="noteObtenueTotal" name="noteObtenueTotal" readonly>
        </div>

        <!-- Incident Technical Section -->
        <div id="incidenttechnicalSection" class="section">
            <h2>Incident Technical Section</h2>

            <!-- Question 1 -->
            <label for="understandsProblem">Understands the problem reported by user:</label>
            <select id="understandsProblem" name="understandsProblem" >
                <option value="0">0 (KO)</option>
                <option value="5">5 (AA)</option>
                <option value="10">10 (OK)</option>
            </select>
            <br>

            <!-- Question 2 -->
            <label for="understandsErrorMessages">Understands error messages/diagnostics provided in ticket:</label>
            <select id="understandsErrorMessages" name="understandsErrorMessages" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Question 3 -->
            <label for="rfiSentToUser">RFI sent to user:</label>
            <select id="rfiSentToUser" name="rfiSentToUser" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Question 4 -->
            <label for="preliminaryDiagnostics">Preliminary diagnostics (Logs, Nslookup, Traceroute, etc.):</label>
            <select id="preliminaryDiagnostics" name="preliminaryDiagnostics" >
                <option value="0">0 (KO)</option>
                <option value="5">5 (AA)</option>
                <option value="10">10 (OK)</option>
            </select>
            <br>

            <!-- Total for Incident Analysis -->
            <label for="incidentAnalysisTotal">Incident Analysis (Total):</label>
            <input type="text" id="incidentAnalysisTotal" name="incidentAnalysisTotal" readonly>
            <br>

            <!-- Question 5 -->
            <label for="inDepthTroubleshooting">Ability to perform in-depth troubleshooting:</label>
            <select id="inDepthTroubleshooting" name="inDepthTroubleshooting" >
                <option value="0">0 (KO)</option>
                <option value="5">5 (AA)</option>
                <option value="10">10 (OK)</option>
            </select>
            <br>

            <!-- Question 6 -->
            <label for="actionTakenForResolution">Action taken for resolution:</label>
            <select id="actionTakenForResolution" name="actionTakenForResolution" >
                <option value="0">0 (KO)</option>
                <option value="5">5 (AA)</option>
                <option value="10">10 (OK)</option>
            </select>
            <br>
        </div>

        <!-- Change Process Section -->
        <div id="changeprocessSection" class="section">
            <h2>Change Process Section</h2>

            <!-- Question 1 -->
            <label for="validationZISO">Validation ZISO:</label>
            <select id="validationZISO" name="validationZISO" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Question 2 -->
            <label for="validationPSSL3">Validation PSS L3:</label>
            <select id="validationPSSL3" name="validationPSSL3" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Question 3 -->
            <label for="tagOnShortDescription">Tag on Short Description / Mail:</label>
            <select id="tagOnShortDescription" name="tagOnShortDescription" >
                <option value="0">0 (KO)</option>
                <option value="5">5 (AA)</option>
                <option value="10">10 (OK)</option>
            </select>
            <br>

            <!-- Question 4 -->
            <label for="mailSentForInfo">Mail sent for information needed:</label>
            <select id="mailSentForInfo" name="mailSentForInfo" >
                <option value="0">0 (KO)</option>
                <option value="5">5 (AA)</option>
                <option value="10">10 (OK)</option>
            </select>
            <br>

            <!-- Question 5 -->
            <label for="implementationTaskState">Implementation task not in closed complete state before compilation:</label>
            <select id="implementationTaskState" name="implementationTaskState" >
                <option value="0">0 (KO)</option>
                <option value="2.5">2.5 (AA)</option>
                <option value="5">5 (OK)</option>
            </select>
            <br>

            <!-- Question 6 -->
            <label for="customRequests">Custom Requests / Change:</label>
            <select id="customRequests" name="customRequests" >
                <option value="0">0 (KO)</option>
                <option value="7.5">7.5 (AA)</option>
                <option value="15">15 (OK)</option>
            </select>
            <br>

            <!-- Total for Note Obtenue -->
            <label for="noteObtenueTotalChange">Note Obtenue (Total):</label>
            <input type="text" id="noteObtenueTotalChange" name="noteObtenueTotalChange" readonly>
            <br>
        </div>

        <!-- Change Technical Section -->
        <div id="changetechnicalSection" class="section">
            <h2>Change Technical Section</h2>

            <!-- Question 1 -->
            <label for="qualificationPerformed">Qualification / Implementation performed correctly:</label>
            <select id="qualificationPerformed" name="qualificationPerformed" >
                <option value="0">0 (KO)</option>
                <option value="25">25 (AA)</option>
                <option value="50">50 (OK)</option>
            </select>
            <br>

            <!-- Question 2 -->
            <label for="correctQualification">Correct qualification/ Implementation for a specific request:</label>
            <select id="correctQualification" name="correctQualification" >
                <option value="0">0 (KO)</option>
                <option value="25">25 (AA)</option>
                <option value="50">50 (OK)</option>
            </select>
            <br>

            <!-- Total for Score -->
            <label for="scoreTotal">Score (Total):</label>
            <input type="text" id="scoreTotal" name="scoreTotal" readonly>
            <br>
        </div>

        <input type="submit" value="Submit">
    </form>

    
</body>
</html>
