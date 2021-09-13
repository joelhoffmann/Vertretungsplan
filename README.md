# Vertetungsplan
Hier muss noch ein Bild rein

# Funktionsweise
Eine Textfile kann im Admin-Panel hochgeladen werden, welche in einer MySQL-Datanbank gespeichert wird. 
Die Textfile darf keine Änderungen enthalten, sondern muss immer alle Einträge enthalten, da im Upoload-Prozess in upload.php die Tabelle für eine bessere Performance komplett neu angelegt wird.
Anschließend wird in vertretungsplan.php die Datenbank nach Einträgen für heute und dem darauffolgenden vorhandenem Tag durchsucht und klassenweise angezeigt.

# Anwendungsmöglichkeiten
Es ist momentan nur möglich den Vertretungsplan als Anzeige für die Schüler zu verwenden, da im Upload schon Einträge ohne Klasse und welche die nur für Lehrer interessant sind nicht aufgenommen werden.

# Sicherheit
Die Datenbank und das Admin-Panel sind nicht extra durch Passwörter geschützt. Es ist unentbehrlich, dass auf Netzwerkebene Unbefugten der Zugang verhindert wird.

# Einstellmöglichkeiten eines Admin
Dem Admin ist es möglich im Admin-Panel unterschiedliche Parameter einzustellen.
Im Reiter System können die Farben angepasst werden um gegebenenfalls eine bessere Lesbarkeit zu erreichen.



# Disclaimer
Der Vertretungsplan darf frei verwendet werden, allerdings übernehmen wir keine Haftung für etwatige Schäden die im Zusammenhang mit Benutzung dieser Software auftreten
