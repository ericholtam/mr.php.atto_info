<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class AttoInfoInit extends Migration
{
    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->create('atto_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number')->unique();
            $table->string('channel')->nullable();
            $table->string('model')->nullable();
            $table->string('port_state')->nullable();
            $table->string('port_address')->nullable();
            $table->string('driver_version')->nullable();
            $table->string('firmware_version')->nullable();
            $table->string('flash_version ')->nullable();

            $table->index('channel');
            $table->index('model');
            $table->index('port_state');
            $table->index('port_address');
            $table->index('driver_version');
            $table->index('firmware_version');
            $table->index('flash_version');
        });
    }
    
    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->dropIfExists('atto_info');
    }
}
