<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveLatlong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->double('lat', 15, 8)->after('city');
          $table->double('long', 15, 8)->after('lat');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('lat');
          $table->dropColumn('long');
      });
    }
}
