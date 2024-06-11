<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            // Cria um slug
            $table->uuid('uuid');
            // Cria chave estrangeira, tabela user, campo id
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->longText('text');
            $table->timestamps();

            # Migration add_soft_deletes_to_notes
            #$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');

        # Migration add_soft_deletes_to_notes
        #$table->dropSoftDeletes();
    }
};
