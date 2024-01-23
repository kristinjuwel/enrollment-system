<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfIdToSubjects extends Migration
{
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('prof_id')->nullable();
            $table->foreign('prof_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['prof_id']);
            $table->dropColumn('prof_id');
        });
    }
}
