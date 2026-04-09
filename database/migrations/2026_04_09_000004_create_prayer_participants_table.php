<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrayerParticipantsTable extends Migration
{
    public function up()
    {
        Schema::create('prayer_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('church_id')->unsigned();
            $table->foreign('church_id')->references('id')->on('church')->onDelete('cascade');
            $table->bigInteger('prayer_id')->unsigned();
            $table->foreign('prayer_id')->references('id')->on('prayers')->onDelete('cascade');

            // Nullable — null for ANONYMOUS type
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->enum('participant_type', ['MEMBER', 'GUEST', 'ANONYMOUS'])->default('MEMBER');

            // For anonymous dedup: SHA-256 of IP + User-Agent
            $table->string('anon_hash', 64)->nullable();

            $table->timestamps();

            // Dedup: one lift per authenticated user per prayer
            $table->unique(['prayer_id', 'user_id']);

            // Dedup: one lift per anonymous fingerprint per prayer
            $table->index(['prayer_id', 'anon_hash']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('prayer_participants');
    }
}
