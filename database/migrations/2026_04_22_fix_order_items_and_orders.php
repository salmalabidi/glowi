<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── FIX 1 : Ajouter la colonne subtotal à order_items ──────────────
        if (!Schema::hasColumn('order_items', 'subtotal')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->decimal('subtotal', 10, 2)->default(0)->after('price');
            });
        }

        // ── FIX 2 : Recréer orders sans CHECK constraint (SQLite) ──────────
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('
                CREATE TABLE IF NOT EXISTS orders_new (
                    id         INTEGER  PRIMARY KEY AUTOINCREMENT NOT NULL,
                    user_id    INTEGER  NOT NULL,
                    total      NUMERIC  NOT NULL DEFAULT 0,
                    status     VARCHAR  NOT NULL DEFAULT "pending",
                    created_at DATETIME,
                    updated_at DATETIME,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )
            ');
            DB::statement('INSERT OR IGNORE INTO orders_new SELECT id, user_id, total, status, created_at, updated_at FROM orders');
            DB::statement('DROP TABLE orders');
            DB::statement('ALTER TABLE orders_new RENAME TO orders');
        }
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};