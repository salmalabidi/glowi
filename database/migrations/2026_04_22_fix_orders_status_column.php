<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SQLite ne supporte pas ALTER COLUMN.
     * On recrée la table orders sans la CHECK constraint sur status.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // 1. Créer une table temporaire avec le bon schéma (sans CHECK constraint)
            DB::statement('
                CREATE TABLE orders_new (
                    id        INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
                    user_id   INTEGER  NOT NULL,
                    total     NUMERIC  NOT NULL DEFAULT 0,
                    status    VARCHAR  NOT NULL DEFAULT "pending",
                    created_at DATETIME,
                    updated_at DATETIME,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )
            ');

            // 2. Copier les données existantes
            DB::statement('INSERT INTO orders_new SELECT id, user_id, total, status, created_at, updated_at FROM orders');

            // 3. Supprimer l'ancienne table
            DB::statement('DROP TABLE orders');

            // 4. Renommer la nouvelle table
            DB::statement('ALTER TABLE orders_new RENAME TO orders');

        } else {
            // MySQL / PostgreSQL : simple changement de type
            Schema::table('orders', function (Blueprint $table) {
                $table->string('status')->default('pending')->change();
            });
        }
    }

    public function down(): void
    {
        // Rétablir l'état précédent si nécessaire
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('confirmed')->change();
        });
    }
};