<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'évaluation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            width: 100%;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            justify-content: space-between; /* or any other value based on your layout needs */
        }
        .form-container {
            flex: 0 0 49%; /* Adjust the width as needed */
            /* margin: 20px; */
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        h3 {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            background-color: #333;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
        .guide-container {
            flex: 0 0 50%; /* Adjust the width as needed */
            /* margin: 20px; */
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
    <link rel="stylesheet" type="text/css" href="./css/common.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <script>
        $(document).ready(function() {
            $('#logoutLink').on('click', function(e) {
                e.preventDefault(); 
                showLogoutConfirmation();
            });

            function showLogoutConfirmation() {
                if (confirm("Are you sure you want to logout?")) {
                    logout();
                }
            }

            function logout() {
                $.ajax({
                    type: 'POST',
                    url: 'logout_script.php',
                    success: function (response) {
                        window.location.href = 'login.php';
                    }
                });
            }
        });

        //have to select in the form:
            <script>
  function validateForm() {
    const radioGroups = [
      'accueil',
      'ea',
      'repeter',
      'interrompt',
      'participe',
      'conforme',
      'explication_claire',
      'retranscrire',
      'c_fluide',
      'structure',
      'vocabulaire',
      'faute',
      'prononciation',
      'discours',
      'attente',
      'courtoisie',
      'conclusion',
      'interlocuteur',
      'conge'
    ];

    for (let i = 0; i < radioGroups.length; i++) {
      const group = document.getElementsByName(radioGroups[i]);
      let isChecked = false;

      for (let j = 0; j < group.length; j++) {
        if (group[j].checked) {
          isChecked = true; 
          break;
        }
      }

      if (!isChecked) {
        alert(`Please select one option for ${radioGroups[i]}`);
        return false;
      }
    }

    return true;
  }
</script>

    </script>
</body>
</html>

<!-- navigation bar -->
<head>
    <link href="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/css/orange-helvetica.min.css" rel="stylesheet" integrity="sha384-A0Qk1uKfS1i83/YuU13i2nx5pk79PkIfNFOVzTcjCMPGKIDj9Lqx9lJmV7cdBVQZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/css/boosted.min.css" rel="stylesheet" integrity="sha384-Q3wzptfwnbw1u019drn+ouP2GvlrCu/YVFXSu5YNe4jBpuFwU738RcnKa8PVyj8u" crossorigin="anonymous">
</head>
<header>
        <nav class="navbar navbar-dark bg-dark navbar-expand-lg header-minimized" aria-label="Global navigation - Minimized without title example">
            <div class="container-xxl">
                <div class="navbar-brand me-auto me-lg-4">
                    <a class="stretched-link" href="call_audit.php">
                        <img src="https://boosted.orange.com/docs/5.3/assets/brand/orange-logo.svg" width="50" height="50" alt="Orange Business" loading="lazy">
                    </a>
                </div>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target=".global-header-0" aria-controls="global-header-0.1 global-header-0.2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="global-header-0.1" class="navbar-collapse collapse me-lg-auto global-header-0">
                    <ul class="navbar-nav">
                        <?php
                        // Get the current file name (without directory path or parameters)
                        $currentPage = basename($_SERVER['PHP_SELF']);

                        // associative array of page names and their corresponding labels
                        $pages = array(
                            'call_audit.php' => 'New Call Audit',
                            'display_call_audit.php' => 'Call Audits',
                            'call_charts_audit.php' => 'Call Audit Charts'
                        );

                        // Loop through the pages and create navigation links
                        foreach ($pages as $page => $label) {
                            $isActive = ($currentPage === $page) ? 'active' : '';
                            echo '<li class="nav-item ' . $isActive . '"><a href="' . $page . '" class="nav-link">' . $label . '</a></li>';
                        }

                        ?>
                        <li class="nav-item"><a href="#" id="logoutLinkNavbar" class="nav-link">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
<br>
</header>

<script src="https://cdn.jsdelivr.net/npm/boosted@5.3.1/dist/js/boosted.bundle.min.js" integrity="sha384-0biCFbLg/2tCnFChlPpLx46RGI2/8UP1Uk6n0Q0ATM7D0SbB4s1yTQcOjLV96X3h" crossorigin="anonymous"></script>

<script>
        function showLogoutConfirmation() {
            if (confirm("Are you sure you want to logout?")) {
                logout();
            }
        }

        function logout() {
            // Perform the logout actions; destroying the session
            $.ajax({
                type: 'POST',
                url: 'logout_script.php',
                success: function (response) {
                    // Redirect to the login page after logout
                    window.location.href = 'login.php';
                }
            });
        }
</script>

</header>
<body>
    <h2>Call Audit</h2>
    <div class="container">
        <div class="form-container">
        <form action="process_call_audit.php" method="post" onsubmit="return validateForm()">
        <label for="date">Date:</label><br>
            <input type="date" id="date" name="date" required><br><br>

            <label for="time">Time:</label><br>
            <input type="time" id="time" name="time" required><br><br>

            <label for="employee_name">Employee Name:</label><br>
            <select id="employee_name" name="employee_name" required>
                <?php
                    include('dbconnect.php'); 
                    
                    // Fetch the names of employees from the staff table
                    $sql = "SELECT Name FROM staff";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $employee = $row["Name"];
                            echo "<option value='$employee'>$employee</option>";
                        }
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                ?>
            </select><br><br>
            <h3>Acceuil: Pondération : 5</h3>
            <label for="accueil">Respecte la phrase d'accueil en se présentant et présentant la société :</label><br>
            <input type="radio" id="accueil_ok" name="accueil" value="3">
            <label for="accueil_ok">A respecté tous les points(3)</label><br>
            <input type="radio" id="accueil_aa" name="accueil" value="1.5">
            <label for="accueil_aa">A respecté qu'une partie des points(1.5)</label><br>
            <input type="radio" id="accueil_ko" name="accueil" value="0">
            <label for="accueil_ko">Ne respecte aucun des points(0)</label><br><br>

            <h3>Ecoute Active: Pondération : 20</h3>
            <label for="ea">S'assure de bien saisir le/les besoin ou demande de son interlocuteur</label><br>
            <input type="radio" id="ea_ok" name="ea" value="6">
            <label for="ea_ok">A respecté tous les points(6)</label><br>
            <input type="radio" id="ea_aa" name="ea" value="3">
            <label for="ea_aa">A respecté qu'une partie des points(3)</label><br>
            <input type="radio" id="ea_ko" name="ea" value="0">
            <label for="ea_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="repeter">Ne fait pas répéter inutilement le client</label><br>
            <input type="radio" id="repeter_ok" name="repeter" value="5">
            <label for="repeter_ok">A respecté tous les points(5)</label><br>
            <input type="radio" id="repeter_aa" name="repeter" value="2.5">
            <label for="repeter_aa">A respecté qu'une partie des points(2.5)</label><br>
            <input type="radio" id="repeter_ko" name="repeter" value="0">
            <label for="repeter_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="interrompt">Le collaborateur n'interrompt pas son interlocuteur</label><br>
            <input type="radio" id="interrompt_ok" name="interrompt" value="4">
            <label for="interrompt_ok">A respecté tous les points(4)</label><br>
            <input type="radio" id="interrompt_aa" name="interrompt" value="2">
            <label for="interrompt_aa">A respecté qu'une partie des points(2)</label><br>
            <input type="radio" id="interrompt_ko" name="interrompt" value="0">
            <label for="interrompt_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="participe">Participe de manière active à la conversation</label><br>
            <input type="radio" id="participe_ok" name="participe" value="5">
            <label for="participe_ok">A respecté tous les points(5)</label><br>
            <input type="radio" id="participe_aa" name="participe" value="2.5">
            <label for="participe_aa">A respecté qu'une partie des points(2.5)</label><br>
            <input type="radio" id="participe_ko" name="participe" value="0">
            <label for="participe_ko">Ne respecte aucun des points(0)</label><br><br>

            <h3>Savoir Faire: Pondération : 20</h3>
            <label for="conforme">Transmets l'information complète et exacte au client conformément aux procédures établi</label><br>
            <input type="radio" id="conforme_ok" name="conforme" value="10">
            <label for="conforme_ok">A respecté tous les points(10)</label><br>
            <input type="radio" id="conforme_aa" name="conforme" value="5">
            <label for="conforme_aa">A respecté qu'une partie des points(5)</label><br>
            <input type="radio" id="conforme_ko" name="conforme" value="0">
            <label for="conforme_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="explication_claire">Arrive a donné une explication claire et la plus adaptée à son interlocuteur</label><br>
            <input type="radio" id="explication_claire_ok" name="explication_claire" value="5">
            <label for="explication_claire_ok">A respecté tous les points(5)</label><br>
            <input type="radio" id="explication_claire_aa" name="explication_claire" value="2.5">
            <label for="explication_claire_aa">A respecté qu'une partie des points(2.5)</label><br>
            <input type="radio" id="explication_claire_ko" name="explication_claire" value="0">
            <label for="explication_claire_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="retranscrire">Sait retranscrire verbalement les éléments de réponse (lecture de ticket/dossier)</label><br>
            <input type="radio" id="retranscrire_ok" name="retranscrire" value="5">
            <label for="retranscrire_ok">A respecté tous les points(5)</label><br>
            <input type="radio" id="retranscrire_aa" name="retranscrire" value="2.5">
            <label for="retranscrire_aa">A respecté qu'une partie des points(2.5)</label><br>
            <input type="radio" id="retranscrire_ko" name="retranscrire" value="0">
            <label for="retranscrire_ko">Ne respecte aucun des points(0)</label><br><br>

            <h3>Qualite du discours: Pondération : 25</h3>
            <label for="c_fluide">Arrive à faire une conversation et à se faire comprendre par son interlocuteur (conversation fluide)</label><br>
            <input type="radio" id="c_fluide_ok" name="c_fluide" value="8">
            <label for="c_fluide_ok">A respecté tous les points(8)</label><br>
            <input type="radio" id="c_fluide_aa" name="c_fluide" value="4">
            <label for="c_fluide_aa">A respecté qu'une partie des points(4)</label><br>
            <input type="radio" id="c_fluide_ko" name="c_fluide" value="0">
            <label for="c_fluide_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="structure">Utilise des phrases complètes et bien structurées tout au long de l'appel</label><br>
            <input type="radio" id="structure_ok" name="structure" value="5">
            <label for="structure_ok">A respecté tous les points(8)</label><br>
            <input type="radio" id="structure_aa" name="structure" value="2.5">
            <label for="structure_aa">A respecté qu'une partie des points(2.5)</label><br>
            <input type="radio" id="structure_ko" name="structure" value="0">
            <label for="structure_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="vocabulaire">Le collaborateur a un vocabulaire vaste et varié</label><br>
            <input type="radio" id="vocabulaire_ok" name="vocabulaire" value="3">
            <label for="vocabulaire_ok">A respecté tous les points(3)</label><br>
            <input type="radio" id="vocabulaire_aa" name="vocabulaire" value="1.5">
            <label for="vocabulaire_aa">A respecté qu'une partie des points(1.5)</label><br>
            <input type="radio" id="vocabulaire_ko" name="vocabulaire" value="0">
            <label for="vocabulaire_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="faute">Ne commet pas de faute de genre et de conjugaison</label><br>
            <input type="radio" id="faute_ok" name="faute" value="3">
            <label for="faute_ok">A respecté tous les points(3)</label><br>
            <input type="radio" id="faute_aa" name="faute" value="1.5">
            <label for="faute_aa">A respecté qu'une partie des points(1.5)</label><br>
            <input type="radio" id="faute_ko" name="faute" value="0">
            <label for="faute_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="prononciation">Arrive à avoir une prononciation et articulation nette (ne mâche pas ses mots)</label><br>
            <input type="radio" id="prononciation_ok" name="prononciation" value="3">
            <label for="prononciation_ok">A respecté tous les points(3)</label><br>
            <input type="radio" id="prononciation_aa" name="prononciation" value="1.5">
            <label for="prononciation_aa">A respecté qu'une partie des points(1.5)</label><br>
            <input type="radio" id="prononciation_ko" name="prononciation" value="0">
            <label for="prononciation_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="discours">Discours anglophone ou créolisé</label><br>
            <input type="radio" id="discours_ok" name="discours" value="3">
            <label for="discours_ok">A respecté tous les points(3)</label><br>
            <input type="radio" id="discours_aa" name="discours" value="1.5">
            <label for="discours_aa">A respecté qu'une partie des points(1.5)</label><br>
            <input type="radio" id="discours_ko" name="discours" value="0">
            <label for="discours_ko">Ne respecte aucun des points(0)</label><br><br>

            <h3>Mise en attente: Pondération : 5</h3>
            <label for="attente">Utilise la mise en attente de façon adéquate</label><br>
            <input type="radio" id="attente_ok" name="attente" value="3">
            <label for="attente_ok">A respecté tous les points(3)</label><br>
            <input type="radio" id="attente_aa" name="attente" value="1.5">
            <label for="attente_aa">A respecté qu'une partie des points(1.5)</label><br>
            <input type="radio" id="attente_ko" name="attente" value="0">
            <label for="attente_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="courtoisie">Fait preuve de courtoisie et informe l'interlocuteur de la mise en courtoisie</label><br>
            <input type="radio" id="courtoisie_ok" name="courtoisie" value="2">
            <label for="courtoisie_ok">A respecté tous les points(2)</label><br>
            <input type="radio" id="courtoisie_aa" name="courtoisie" value="1">
            <label for="courtoisie_aa">A respecté qu'une partie des points(1)</label><br>
            <input type="radio" id="courtoisie_ko" name="courtoisie" value="0">
            <label for="courtoisie_ko">Ne respecte aucun des points(0)</label><br><br>

            <h3>Conclusion et prise de congé: Pondération : 10</h3>
            <label for="conclusion">Résume les éléments clés de la conversation</label><br>
            <input type="radio" id="conclusion_ok" name="conclusion" value="2">
            <label for="conclusion_ok">A respecté tous les points(2)</label><br>
            <input type="radio" id="conclusion_aa" name="conclusion" value="1">
            <label for="conclusion_aa">A respecté qu'une partie des points(1)</label><br>
            <input type="radio" id="conclusion_ko" name="conclusion" value="0">
            <label for="conclusion_ko">Ne respecte aucun des points(0)</label><br><br>

            <label for="interlocuteur">S'assure d'avoir répondu à toutes les questions et demande de son interlocuteur</label><br>
            <input type="radio" id="interlocuteur_ok" name="interlocuteur" value="3">
            <label for="interlocuteur_ok">A respecté tous les points(3)</label><br>
            <input type="radio" id="interlocuteur_aa" name="interlocuteur" value="1.5">
            <label for="interlocuteur_aa">A respecté qu'une partie des points(1.5)</label><br>
            <input type="radio" id="interlocuteur_ko" name="interlocuteur" value="0">
            <label for="interlocuteur_ko">Ne respecte aucun des points(0)</label><br><br>
            
            <label for="conge">Prend congé de façon courtoise</label><br>
            <input type="radio" id="conge_ok" name="conge" value="5">
            <label for="conge_ok">A respecté tous les points(5)</label><br>
            <input type="radio" id="conge_aa" name="conge" value="2.5">
            <label for="conge_aa">A respecté qu'une partie des points(2.5)</label><br>
            <input type="radio" id="conge_ko" name="conge" value="0">
            <label for="conge_ko">Ne respecte aucun des points(0)</label><br><br>

            <input type="submit" value="Soumettre">
        </form>
    </div>
        <div class="guide-container">
            <div class="panel panel-default">
                <div class="panel-heading">Guide</div><br>
                <div class="panel-body">
                "Respecte la phrase d'accueil en se présentant et présentant la société<br>
                Le collaborateur accueille son interlocuteur de façon courtoise lorsqu’il :<br>
                1. Se présente de façon courtoise en nommant son prénom et le nom de la société de façon claire<br>
                2. Respecte la phrase d'accueil définie ""Orange Cyberdéfense, Bonjour ! PRÉNOM à votre écoute"""<br>
                "Identifie son interlocuteur<br>
                Le collaborateur identifie son interlocuteur correctement lorsqu’il :<br>
                1. Demande le numéro de ticket<br>
                2. Confirme le nom de son interlocuteur "<br>
                "Écoute active Pondération : 20"<br>
                "S'assure de bien saisir le/les besoin ou demande de son interlocuteur<br>
                Le collaborateur s’assure de bien saisir le/les besoins de son interlocuteur lorsqu’il :<br>
                1. Pose des questions pour approfondir le besoin ou confirmer l’information;<br>
                ""Il est possible qu’il ne soit pas nécessaire de poser des questions, si par<br>
                exemple la personne énonce clairement dès le début de l’appel son besoin"";<br>
                2. Reformule le besoin pour s’assurer de sa compréhension. Pour ce faire, il peut<br>
                utiliser des phrases comme :<br>
                Si j'ai bien compris, donc vous me dites, etc.."<br>
                "Ne fait pas répéter inutilement le client<br>
                Le collaborateur ne fait pas répéter inutilement son interlocuteur, lorsqu’il :<br>
                1. Ne fait répéter l'interlocuteur que lorsqu’il y a une incompréhension justifiée (bruits,<br>
                accents difficiles à comprendre, etc.);"<br>
                "Le collaborateur n'interrompt pas son interlocuteur<br>
                Le collaborateur n’interrompt pas son interlocuteur lorsqu’il :<br>
                1. Ne coupe pas la parole ;<br>
                2. Ne parle pas en même."<br>
                "Participe de manière active à la conversation<br>
                Le collaborateur participe de manière active à la conversation lorsqu’il :<br>
                1. A un temps de réaction adéquat suite aux propos du client;<br>
                2. A une réaction cohérente aux propos du client;<br>
                3. Signale sa présence en utilisant des mots tels que : « d’accord », « très bien »,« je vois »."<br>
                "Savoir faire Pondération : 20"<br>
                "Transmets l'information complète et exacte au client conformément aux procédures établi<br>
                Le collaborateur transmet l’information complète et exacte au client lorsqu’il :<br>
                1. Donne toutes les informations nécessaires pour répondre à la demande de son interlocuteur;<br>
                2. Donne l'information exacte.<br>
                Le tout doit être conforme aux outils de référence"<br>
                "Arrive a donné une explication claire et la plus adaptée à son interlocuteur<br>
                Le collaborateur donne les éléments de réponse attendu lorsqu'il :<br>
                1. Positionne de façon claire et cohérente les règles et procédures afférentes à la situation"<br>
                "Sait retranscrire verbalement les éléments de réponse (lecture de ticket/dossier)<br>
                Le collaborateur transmet les informations vus sur les outils lorsqu'il :<br>
                1. Arrive a énoncé en ses propres termes les élément lus sur les outils/ticket <br>
                2. Ne fait pas de lecture "<br>
                "Savoir être Pondération : 15"<br>
                "Adapte son discours en fonction de son interlocuteur<br>
                Le collaborateur s'adapte au rythme et au style de son interlocuteur lorsqu’il :<br>
                1. Identifie l’état d’esprit du client (préoccupé, pressé, neutre, calme, mécontent, etc.) et s’adapte au rythme et débit selon la situation."<br>
                "Fait preuve de compréhension vis a vis de la situation<br>
                Le collaborateur arrive a rassurer son interlocuteur fasse a une situation de mécontentement  lorsqu’il :<br>
                1. Réussit à transmettre par son ton de voix et évitant l'utilisation de la négation<br>
                Exemples :<br>
                Je comprend, C’est tout à fait compréhensible, Je suis désolé des désagréments que cette situation a pu vous causer, Sachez que mon objectif est de vous aider"<br>
                "Fait preuve de dynamisme:Le collaborateur fait preuve de dynamisme lorsqu’il :<br>
                1. Utilise un ton énergique et engageant;<br>
                2. Démontre qu’il est attentif en utilisant des mots de liaison ou de renforcement tels que : tout à fait, d’accord, oui, exactement, donc pour vous, cela signifie que;<br>
                3. Prend en charge la discussion et fait preuve d’initiative."<br>
                "Utilise les règles de courtoisie et fait preuve de professionnalisme<br>
                Le collaborateur utilise les règles de courtoisie habituelles et fait preuve de professionnalisme lorsqu’il :<br>
                1. Utilise adéquatement les formules de politesse et de courtoisie telles que : S’il-vous-plaît, puis-je, merci, je vous remercie, bien sûr, je vous en prie, pardon, vous permettez, au revoir, etc. ;<br>
                2. Démontre de la délicatesse et de l’habileté dans les rapports avec son interlocuteur"<br>
                "Utilise un débit et un ton approprié (sourire dans la voix)<br>
                Le collaborateur utilise un débit et un ton approprié lorsqu’il :<br>
                1. Adopte un ton chaleureux et sympathique.<br>
                2. Utilise un ton confiant;<br>
                3. Utilise un débit régulier, qui permet a son interlocuteur de comprendre le discours et d’avoir
                un rythme soutenu;<br>
                4. Module le ton de sa voix pour éviter d’être monocorde."<br>
                "Qualité du discours
                Pondération : 25"<br>
                "Arrive à faire une conversation et à se faire comprendre par son interlocuteur (conversation fluide)<br>
                Le collaborateur structure son appel de façon à en maximiser l’efficacité lorsqu’il :<br>
                1. Fait une bonne construction de phrase<br>
                2. Positionne de façon claire et cohérente les ponctuation"<br>
                "Utilise des phrases complètes et bien structurées tout au long de l'appel<br>
                Le collaborateur utilise un discours cohérent, concis et précis lorsqu’il :<br>
                1. Utilise des phrases courtes, claires et précises;<br>
                2. Utilise des phrases complètes et bien structurées tout au long de l'appel;<br>
                3. Utilise le présent "<br>
                "Le collaborateur a un vocabulaire vaste et varié<br>
                Le collaborateur utilise un bon vocabulaire lorsqu’il :<br>
                1. N'utilise pas tout le temps les mêmes mots pour décrire une situation ;<br>
                2. Varie son vocabulaire en fonction de l'appel "<br>
                "Ne commet pas de faute de genre et de conjugaison<br>
                Le collaborateur utilise un bon vocabulaire lorsqu’il :<br>
                1. Accorde correctement les genres grammatical ;<br>
                Exemple : ne dit pas ""la pare-feu, la nécessaire est faite, le ordinateur etc...""<br>
                2. Utilise correctement l'auxiliaire être et avoir<br>
                Exemple :  j'ai parti voir le ticket créer au lieu de, je suis allé voir le ticket."<br>
                "Arrive à avoir une prononciation et articulation nette (ne mâche pas ses mots)<br>
                Le collaborateur parle de façon audible lorsqu’il :<br>
                1. Utilise correctement les mots de liaisons ;<br>
                2. Prononce correctement les syllabes ;<br>
                3. Prononce les ""é"" lorsque celui-ci est accordé."<br>
                "Discours anglophone ou créolisé<br>
                Le collaborateur utilise un niveau de français approprié lorsqu’il :<br>
                1. Ne fais pas de traduction littérale de l'anglais ou créole vers le français ;<br>
                2. N'a pas un fort accent créolisé ou anglophone."<br>
                "Mise en attente
                Pondération : 5"<br>
                "Utilise la mise en attente de façon adéquate<br>
                Le collaborateur utilise adéquatement la mise en attente lorsqu’il :<br>
                1. Utilise efficacement l'attente pour retrouver les informations adéquates;<br>
                2. Fait une mise en attente injustifié (on l'entend parler à son collègue d'autre chose non-professionnelle.)<br>
                Non-applicable : si la mise en attente n’était pas nécessaire lors de l’appel"<br>
                "Fait preuve de courtoisie et informe l'interlocuteur de la mise en attente<br>
                Le collaborateur utilise adéquatement la mise en attente lorsqu’il :<br>
                1. Informe son interlocuteur l’attente;<br>
                2. Remercie son interlocuteur pour sa patience au retour de la mise en attente.<br>
                Non-applicable : si la mise en attente n’était pas nécessaire lors de l’appel"<br>
                "Conclusion et prise de congé
                Pondération : 5"<br>
                "Résume les éléments clés de la conversation<br>
                Le collaborateur a résumé les éléments clé de la conversation lorsqu’il :<br>
                1. Fait un retour sur les sujets abordés lors de l’appel ;<br>
                2. Et/ou sur les actions prises pour résoudre la situation.<br>
                Exemple : Comme je vous ai indiqué, je vous envoie les éléments par mail où je vous rappelle pour le suivi du ticket. "<br>
                "S'assure d'avoir répondu à toutes les questions et demande de son interlocuteur<br>
                Le collaborateur s’est assuré d’avoir répondu à toutes les attentes lorsqu’il :<br>
                1. Pose une question incitant son interlocuteur à énoncer d’autres besoins.<br>
                Exemples : Auriez-vous d’autres questions ? Y a-t-il autre chose avec laquelle je pourrais vous assister ?"<br>
                "Prend congé de façon courtoise<br>
                Le collaborateur prend congé de façon courtoise lorsqu’il :<br>
                1. Utilise une formule de politesse et un ton chaleureux.<br>
                Peut terminer avec une touche personnelle en lien avec les éléments mentionnés durant
                l’appel.<br>
                Exemple :  je vous souhaite un bon weekend, excellente fin de journée etc."<br>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
