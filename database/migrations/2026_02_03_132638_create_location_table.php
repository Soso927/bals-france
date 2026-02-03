<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            
            $table->enum('type', ['distributeur', 'installateur', 'showroom'])
                  ->comment('Type de point BALS');
            
            $table->string('nom')->comment('Nom du distributeur/installateur');
            $table->text('adresse')->comment('Adresse complète');
            $table->string('ville', 100);
            $table->string('code_postal', 10);
            $table->string('region', 100)->nullable()->comment('Région française');
            
            $table->decimal('latitude', 10, 8)->comment('Latitude GPS');
            $table->decimal('longitude', 11, 8)->comment('Longitude GPS');
            
            $table->string('telephone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('site_web')->nullable();
            
            $table->text('description')->nullable()->comment('Description détaillée');
            $table->json('produits_disponibles')->nullable()
                  ->comment('Liste des produits disponibles (JSON array)');
            
            $table->json('horaires')->nullable();
            
            $table->boolean('actif')->default(true)->comment('Visible sur la carte ?');
            $table->string('reference_interne', 50)->nullable()
                  ->comment('Référence BALS interne');
            
            $table->timestamps();
            
            $table->index(['type', 'actif']);
            $table->index('ville');
            $table->index('code_postal');
            $table->index(['latitude', 'longitude']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};