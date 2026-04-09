<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestructureSermonsLinksTable extends Migration
{
    public function up()
    {
        // Add new columns only if they don't exist yet
        Schema::table('sermons_links', function (Blueprint $table) {
            if (!Schema::hasColumn('sermons_links', 'title'))      $table->string('title')->nullable()->after('sermons_id');
            if (!Schema::hasColumn('sermons_links', 'video_link')) $table->text('video_link')->nullable()->after('title');
            if (!Schema::hasColumn('sermons_links', 'audio_link')) $table->text('audio_link')->nullable()->after('video_link');
            if (!Schema::hasColumn('sermons_links', 'pdf_link'))   $table->text('pdf_link')->nullable()->after('audio_link');
        });

        // Migrate existing data: map old type+url into the new columns
        if (Schema::hasColumn('sermons_links', 'type')) {
            DB::table('sermons_links')->whereNull('deleted_at')->orderBy('id')->each(function ($row) {
                $update = [];
                if ($row->type === 'video')    $update['video_link'] = $row->url;
                if ($row->type === 'audio')    $update['audio_link'] = $row->url;
                if ($row->type === 'document') $update['pdf_link']   = $row->url;
                if (!empty($update)) {
                    DB::table('sermons_links')->where('id', $row->id)->update($update);
                }
            });
        }

        // Drop old columns
        Schema::table('sermons_links', function (Blueprint $table) {
            $drops = [];
            if (Schema::hasColumn('sermons_links', 'type'))     $drops[] = 'type';
            if (Schema::hasColumn('sermons_links', 'location')) $drops[] = 'location';
            if (Schema::hasColumn('sermons_links', 'url'))      $drops[] = 'url';
            if (!empty($drops)) $table->dropColumn($drops);
        });
    }

    public function down()
    {
        Schema::table('sermons_links', function (Blueprint $table) {
            $table->enum('type', ['audio', 'video', 'document'])->nullable()->after('sermons_id');
            $table->text('location')->nullable()->after('type');
            $table->text('url')->after('location');
        });

        Schema::table('sermons_links', function (Blueprint $table) {
            $table->dropColumn(['title', 'video_link', 'audio_link', 'pdf_link']);
        });
    }
}
