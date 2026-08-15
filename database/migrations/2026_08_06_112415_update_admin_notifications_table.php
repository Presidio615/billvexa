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
        Schema::table('admin_notifications', function (Blueprint $table) {
            //
            $table->string('recipient_type')->after('message');

            $table->string('recipient')->nullable()->after('recipient_type');

            $table->boolean('push')->default(true);

            $table->boolean('email')->default(false);

            $table->boolean('sms')->default(false);

            $table->string('status')->default('Pending');

            $table->renameColumn('admin_id', 'created_by');

            $table->dropColumn([
                'link',
                'is_read',
            ]);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_notifications', function (Blueprint $table) {
            //
            $table->renameColumn('created_by', 'admin_id');

            $table->dropColumn([
                'recipient_type',
                'recipient',
                'push',
                'email',
                'sms',
                'status',
            ]);

            $table->string('link')->nullable();

            $table->boolean('is_read')->default(false);

        });
    }
};
