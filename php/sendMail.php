
<?php

header('Content-Type: text/html; charset=UTF-8');


include_once (dirname(dirname(__FILE__)) . '/config.php');

//Initial response is NULL
$response = null;

//Initialize appropriate action and return as HTML response
if (isset($_POST["action"])) {
    $action = $_POST["action"];

    switch ($action) {
        case "SendMessage": {
            if (isset($_POST["email"]) && !empty($_POST["email"])) {

                $message = "Nom - prenom: " . htmlspecialchars($_POST["name"]) . "<br/>";
                $message .= "Mail: " . htmlspecialchars($_POST["email"]) . "<br/>";
                $message .= "Taille: " . htmlspecialchars($_POST["size"]) . "<br/>";
                $message .= "Poids: " . htmlspecialchars($_POST["weight"]) . "<br/>";
                $message .= "Objectifs et sur combien de temps: " . htmlspecialchars($_POST["objectifs"]) . "<br/>";
                $message .= "Pathologie: " . htmlspecialchars($_POST["pathologie"]) . "<br/>";
                $message .= "Disponibilites (par semaine): " . htmlspecialchars($_POST["dispos"]) . "<br/>";
                $message .= "Temps par entrainement: " . htmlspecialchars($_POST["temps"]) . "<br/>";
                $message .= "Regime alimentaire: " . htmlspecialchars($_POST["regime"]) . "<br/>";
                $message .= "Etat de forme: " . htmlspecialchars($_POST["forme"]) . "<br/>";
                $message .= "Preferences: " . htmlspecialchars($_POST["pref"]) . "<br/>";
                
                $subject = "Formulaire de contact"; // Définissez le sujet ici
                
                $response = (SendEmail($message, $subject, $_POST["name"], $_POST["email"], $email)) ? 'Message Sent' : "Sending Message Failed";
            } else {
                $response = "Sending Message Failed";
            }
        }
        break;
        default: {
            $response = "Invalid action is set! Action is: " . $action;
        }
    }
}




if (isset($response) && !empty($response) && !is_null($response)) {
    echo '{"ResponseData":' . json_encode($response) . '}';
}

function SendEmail($message, $subject, $name, $from, $to) {
    $isSent = false;
    // Content-type header
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Additional headers    
    $headers .= 'From: ' . $name .'<'.$from .'>';

    if (@mail($to, $subject, $message, $headers)) {
        $isSent = true;
    }
    return $isSent;
}


?>
