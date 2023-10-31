<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_attributes', function (Blueprint $table) {

            $table->unsignedBigInteger('attribute_id')->after('id');
            $table->foreign('attribute_id')->references('id')->on('attributes');

            $table->string('value')->after('attribute_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->dropColumn('value');
        });
    }
};
