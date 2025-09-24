Exemple de requetes :

Liste des praticiens :
http://localhost:6080/praticiens

Détail d'un praticien :
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363

Consulter un RDV :
http://localhost:6080/rdv/737c4813-b4e4-3634-baee-0a8698625672

Les créneaux occupés sur une date :
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/rdv/occupes?debut=2025-12-01&fin=2025-12-02
avec heures :
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/rdv/occupes?debut=2025-12-01%2009:00:00&fin=2025-12-01%2018:30:00

Agenda d'un pratictien :
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/agenda
http://localhost:6080/praticiens/4305f5e9-be5a-4ccf-8792-7e07d7017363/agenda?debut=2025-12-01&fin=2025-12-02

Annuler un RDV :
http://localhost:6080/rdv/737c4813-b4e4-3634-baee-0a8698625672/annuler
