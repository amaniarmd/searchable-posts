<?php

use App\Enumerations\CommonFields;
use App\Enumerations\Post\Fields;
use App\Enumerations\Tables;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string(Fields::TITLE->value);
            $table->text(Fields::BODY->value);
            $table->unsignedBigInteger(Fields::CATEGORY_ID->value);
            $table->timestamps();

            $table->foreign(Fields::CATEGORY_ID->value)->references(CommonFields::ID->value)->on(Tables::CATEGORIES->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
