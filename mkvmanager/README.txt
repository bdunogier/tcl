==============
MKV Auto-merge
==============

Id�e de base
============
Le merge est effectu� par un crontab/daemon qui d�pile une queue de conversions.
Apr�s le merge, le symlink vers aggregateshare est automatiquement fait, et le
fichier original est supprim� apr�s v�rification.
L'ajout d'�l�ments � la queue est effectu� par un autre script.

Composantes
===========

DB
--
BDD SQLite mergequeue.db[#] avec table .

SQL Create statement[#][#]::
	CREATE TABLE commands (time INTEGER PRIMARY KEY, command TEXT, pid INTEGER);

.. [#] TODO: d�placer dans un autre dossier
.. [#] TODO: ajouter champ status. 0 = todo, 1 = done, 2 = erreur
.. [#] TODO: ajouter champ message. Contient l'erreur si status = 1, ou la sortie de la commande en cas de succ�s

Cron/Daemon
-----------

Au d�marrage, compte les conversions en attente (status = 0) dans mergequeue.
Si conversion(s) trouv�e(s), les prend une par une, et effectue la conversion.

Doit �tre ex�cut� en tant que root:
* demande les droits media pour stocker et linker
* demande les droits download pour supprimer l'original

Alternative: utilisateur conjoint download/media !

Script de queue
---------------

Convertisseur de commande windows + smb => linux / fs local.
D�tecte le type de video (TV Show / Movie) d'apr�s le chemin.
Script actuel: tools/mkvmerge.php
Peut d�j� stocker une commande en queue, reste � traiter le sudo (supprimer)