<?php
// File: database/migrations/XXXX_XX_XX_add_committee_id_to_committees_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Committee;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Add column without unique constraint first
        Schema::table('committees', function (Blueprint $table) {
            $table->string('committee_id')->nullable()->after('id');
        });

        // Step 2: Assign committee IDs to existing records
        $committees = Committee::all();
        foreach ($committees as $index => $committee) {
            $committee->committee_id = 'COM' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            $committee->save();
        }

        // Step 3: Now make it unique and not nullable
        Schema::table('committees', function (Blueprint $table) {
            $table->string('committee_id')->unique()->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('committees', function (Blueprint $table) {
            $table->dropColumn('committee_id');
        });
    }
};