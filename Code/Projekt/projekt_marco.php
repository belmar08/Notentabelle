<?php
/*
@author Marco <marco@belk.one>
@copyright 2024 Marco Belk
@version 1.0.0
@license OpenGL
*/

// Funktion zum Berechnen des Durchschnitts
function berechnenSchnitt($noten)
{
    $summe = array_sum($noten); // Summe sind alle Noten zusammengerechnet
    return $summe / count($noten); // Durchschnittswert wird zurückgegeben
}

// Fragt nach Notenanzahl
function eingabeMehrererNoten($fachname)
{
    $noten = [];
    $anzahl = (int) readline("Wie viele Noten gibt es für $fachname? ");

    // Schleife für Noten eingabe
    for ($i = 1; $i <= $anzahl; $i++) {
        $note = (float) readline("$fachname Note $i: ");
        $noten[] = $note;
    }

    return round(berechnenSchnitt($noten), 2); // Durchschnitt für das Fach wird berechnet.
}

// Durch nachfrage an Kevin und mit PHP Manual gelöst.
echo ("\n       Menü\n*****************");
echo ("\nNoten eintragen (1)\nNoten Übersicht (2)\n*****************\n\n");

$Menü = strtolower(readline("auswahl: "));
print ("\n");

//Noten eintragen
if ($Menü == "1") {
    system("clear");
    // Eingabe der Noten für M231
    echo ("Notentabelle\n");
    (float) $M231_LB1 = readline("M231 LB1: ");
    (float) $M231_LB2 = readline("M231 LB2: ");
    (float) $M231_LB3 = readline("M231 LB3: ");
    $M231 = round(berechnenSchnitt([$M231_LB1, $M231_LB2, $M231_LB3]), 2); // Durchschnitt für M231

    // Eingabe der Noten für M117
    (float) $M117_LB1 = readline("M117 LB1: ");
    (float) $M117_LB2 = readline("M117 LB2: ");
    (float) $M117_LB3 = readline("M117 LB3: ");
    $M117 = round(berechnenSchnitt([$M117_LB1, $M117_LB2, $M117_LB3]), 2); // Durchschnitt für M117

    // Eingabe der weiteren Noten, mit Möglichkeit für mehrere Noten pro Fach.
    $Mathe = eingabeMehrererNoten("Mathe");
    $Englisch = eingabeMehrererNoten("Englisch");
    $Sport = eingabeMehrererNoten("Sport");
    $Gesellschaft = eingabeMehrererNoten("Gesellschaft");
    $SpracheundKommunikation = eingabeMehrererNoten("Sprache und Kommunikation");

    // Noten in ein Array für die Durchschnittsberechnung
    $alleNoten = [$M231, $M117, $Mathe, $Englisch, $Sport, $Gesellschaft, $SpracheundKommunikation];

    // Berechnung des Gesamtdurchschnitts und Ausgabe
    $GesamterDurchschnitt = round(berechnenSchnitt($alleNoten), 2);
    echo "\nDurchschnitt für M231: $M231\n";
    echo "Durchschnitt für M117: $M117\n";
    echo "Durchschnitt für Mathe: $Mathe\n";
    echo "Durchschnitt für Englisch: $Englisch\n";
    echo "Durchschnitt für Sport: $Sport\n";
    echo "Durchschnitt für Gesellschaft: $Gesellschaft\n";
    echo "Durchschnitt für Sprache und Kommunikation: $SpracheundKommunikation\n";
    echo "Gesamter Durchschnitt: $GesamterDurchschnitt\n";

    // Sobald der Durchschnitt aller Noten = 4 oder höher ist. Zeigt es Text 1 an, sonst (falls unter 4) zeigt es Text 2 an.
    if ($GesamterDurchschnitt >= 4.0) {
        echo "Herzlichen Glückwunsch, Sie haben bestanden!\n"; // Text 1
    } else {
        echo "Leider haben Sie nicht bestanden.\n"; // Text 2
    }

    // Ergebnisse in eine Datei speichern
    $file = fopen("noten_bericht.txt", "w");

    if ($file) {
        fwrite($file, "Durchschnitt für M231: $M231\n");
        fwrite($file, "Durchschnitt für M117: $M117\n");
        fwrite($file, "Durchschnitt für Mathe: $Mathe\n");
        fwrite($file, "Durchschnitt für Englisch: $Englisch\n");
        fwrite($file, "Durchschnitt für Sport: $Sport\n");
        fwrite($file, "Durchschnitt für Gesellschaft: $Gesellschaft\n");
        fwrite($file, "Durchschnitt für Sprache und Kommunikation: $SpracheundKommunikation\n");
        fwrite($file, "Gesamter Durchschnitt: $GesamterDurchschnitt\n");

        if ($GesamterDurchschnitt >= 4.0) {
            fwrite($file, "Herzlichen Glückwunsch, Sie haben bestanden!\n");
        } else {
            fwrite($file, "Leider haben Sie nicht bestanden.\n");
        }

        fclose($file);
        echo "Die Ergebnisse wurden in 'noten_bericht.txt' gespeichert.\n";
    } else {
        echo "Fehler: Die Datei konnte nicht erstellt werden.\n";
    }
}

//Noten Übersicht
// Durch nachfrage an Kevin und mit PHP Manual gelöst.
if ($Menü == "2") {
    system("clear");
    $file = "noten_bericht.txt";
    $fp = fopen($file, "r");

    if ($fp) {
        while (($buffer = fgets($fp, 4096)) !== false) {
            echo $buffer;
        }

        fclose($fp);
    } else {
        echo "Failed to open file: $file";
    }
}
?>
