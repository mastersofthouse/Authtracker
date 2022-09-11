<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('ip')->nullable();
                $table->json('ip_info')->nullable();
                $table->json('device')->nullable();
            });
            $table->after('updated_at', function ($table) {
                $table->softDeletes();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropColumn([
                'user_agent',
                'ip',
                'ip_data',
                'device_type',
                'device',
                'platform',
                'browser',
                'city',
                'region',
                'country',
                'expires_at',
                'deleted_at',
            ]);
        });
    }
}
