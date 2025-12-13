DROP TABLE IF EXISTS "indisponibilite";
CREATE TABLE "public"."indisponibilite" (
    "id" uuid DEFAULT gen_random_uuid() NOT NULL,
    "praticien_id" uuid NOT NULL,
    "date_debut" timestamp NOT NULL,
    "date_fin" timestamp NOT NULL,
    "raison" character varying(256),
    "date_creation" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "indisponibilite_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "indisponibilite_praticien_fk" FOREIGN KEY ("praticien_id") REFERENCES "praticien"("id") ON DELETE CASCADE
) WITH (oids = false);

CREATE INDEX "indisponibilite_praticien_idx" ON "public"."indisponibilite" ("praticien_id");
CREATE INDEX "indisponibilite_dates_idx" ON "public"."indisponibilite" ("date_debut", "date_fin");

