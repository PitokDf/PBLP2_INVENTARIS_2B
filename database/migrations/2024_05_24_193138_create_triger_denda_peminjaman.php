<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER hitung_denda BEFORE UPDATE ON peminjaman
            FOR EACH ROW
            BEGIN
                IF NEW.tgl_pengembalian > NEW.batas_pengembalian THEN
                    SET NEW.denda = DATEDIFF(NEW.tgl_pengembalian, NEW.batas_pengembalian) * 1500;
                ELSE
                    SET NEW.denda = 0;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS hitung_denda');
    }
};