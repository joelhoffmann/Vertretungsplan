# Vertetungsplan
Hier muss noch ein Bild rein

# Funktionsweise
Eine Textfile kann im Admin-Panel hochgeladen werden, welche in einer MySQL-Datanbank gespeichert wird. 

WICHTIG:
Die Textfile darf keine Änderungen enthalten, sondern muss immer alle Einträge enthalten, da im Upoload-Prozess in upload.php die Tabelle für eine bessere Performance komplett neu angelegt wird.

Anschließend wird in vertretungsplan.php die Datenbank nach Einträgen für heute und dem nächsten vorhandenem Tag durchsucht und klassenweise angezeigt.
Sind zu viele Einträge für einen Tag vorhanden, wird automatisch hoch und runter gescrollt. Dabei ist die Seite mit mehr Einträgen, die dardurch länger ist, der Master. Das heißt sie bestimmt wann die Richtung gewechselt wird.

# Welche Einträge werden mit aufgenommen?
Durch die Formatierung der GPUxx.txt Files von Untis werden nur die Einträge übernommen, welche in ihrem Bitfeld(Art) eine der folgenden Zahlen vorweisen kann:
* 0: Entfall
* 1: Betreuung
* 2: Sondereinsatz
* 3: Wegverlegung
* 6: Teilvertretung
* 7: Hinverlegung
* 16: Raumvertretung
* 18: Stunde ist unterrichtsfrei

Hinter Den Zahlen befindet sich aufgrund besserer Verständlichkeit die Bedeutung der einzelnen Zahlen. Dabei kann in einem Eintrag immer nur eine Zahl vorkommen.

# Anwendungsmöglichkeiten
Es ist momentan nur möglich den Vertretungsplan als Anzeige für die Schüler zu verwenden, da im Upload schon Einträge ohne Klasse und welche die nur für Lehrer interessant sind nicht aufgenommen werden.

# Nachrichten
Es können unter dem Vertretungsplan Nachrichten für eine bestimmte Zeit in durchlaufendem Text angezeigt werden. Diese sind dafür gedacht temporäre Ansagen anzeigen zu können und werden im Admin-Panel eingerichtet und nach ihrem Ablaufdatum und -Zeit gelöscht. 

# Extra Nachrichten
Extra Nachrichten sind dafür gedacht wichtige Nachrichten mit längerem Text oder Bild anzuzeigen. Ist eine Extra Nachricht vorhanden, wird immer zwischen Extra Nachricht und nächstem Tag gewechselt. In der Vorschau kann man eine 85% Darstellung der Nachricht sehen bevor sie abgeschickt wird.
Man kann bei einer Extra Nachricht nur ein Startdatum und ein Enddatum auswählen, ist das Ende erreicht werden der Eintrag und eventuell vorhande Bilder gelöscht

# Sicherheit
Die Datenbank und das Admin-Panel sind nicht extra durch Passwörter geschützt. Es ist unentbehrlich, dass auf Netzwerkebene Unbefugten der Zugang verhindert wird.



# Disclaimer
Der Vertretungsplan darf frei verwendet und abgeändert werden, allerdings übernehmen wir keine Haftung für etwatige Schäden die im Zusammenhang mit Benutzung dieser Software auftreten.
