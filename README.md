Exemple de requetes :

Liste des praticiens :<br>
http://localhost:6080/praticiens <br>
http://localhost:6080/praticiens?specialite=1&ville=Paris

Détail d'un praticien :<br>
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363

Consulter un RDV :<br>
http://localhost:6080/rdvs/737c4813-b4e4-3634-baee-0a8698625672

Les créneaux occupés sur une date :<br>
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/rdvs?debut=2025-12-01&fin=2025-12-02 <br>
avec heures :<br>
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/rdvs?debut=2025-12-01%2009:00:00&fin=2025-12-01%2018:30:00

Agenda d'un pratictien :<br>
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/agenda <br>
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/agenda?debut=2025-12-01&fin=2025-12-02

Annuler un RDV (POST):<br>
http://localhost:6080/rdvs/737c4813-b4e4-3634-baee-0a8698625672/annuler

L'inscription est possible via PostMan et Bruno :<br>
http://localhost:6080/signin<br> Avec le body :<br>
{<br>
"email": "Marine.Paul@hotmail.fr",<br>
"password": "Marine.Paul"<br>
}