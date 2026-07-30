<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {

            // $table->string('api_provider')->nullable()->after('provider');

            $table->string('api_endpoint')->nullable()->after('api_provider');

            $table->string('service_code')->nullable()->after('api_endpoint');

            $table->string('api_key')->nullable()->after('service_code');

            $table->string('api_secret')->nullable()->after('api_key');

            $table->boolean('sandbox')->default(false)->after('api_secret');

        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {

            $table->dropColumn([
                'api_provider',
                'api_endpoint',
                'service_code',
                'api_key',
                'api_secret',
                'sandbox'
            ]);

        });
    }
};