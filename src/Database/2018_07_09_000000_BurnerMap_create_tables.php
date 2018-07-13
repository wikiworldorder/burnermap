<?php 
// generated from /resources/views/vendor/survloop/admin/db/export-laravel-gen-migration.blade.php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SLCreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
    	Schema::create('AllPastUsers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->string('name', 100)->nullable();
			$table->string('playaName', 100)->nullable();
			$table->integer('totFriends')->nullable();
			$table->timestamps();
		});
    	Schema::create('AllPastUsersDel', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->string('name', 100)->nullable();
			$table->string('playaName', 100)->nullable();
			$table->integer('totFriends')->nullable();
			$table->timestamps();
		});
		
    	Schema::create('BurnerCamps', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 150)->nullable();
			$table->integer('x')->default(0);
			$table->integer('y')->default(0);
			$table->string('addyClock', 50)->default('?:??');
			$table->string('addyLetter', 50)->default('???');
			$table->string('addyLetter2', 50)->default('???');
			$table->integer('size')->default(0);
			$table->string('who', 50)->nullable();
			$table->text('needCampers')->nullable();
			$table->integer('villageID')->default(0);
			$table->integer('apiID')->default(-3);
			$table->timestamps();
		});
        DB::raw("ALTER TABLE `BurnerCamps` CHANGE `name` `name` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
            Schema::create('BurnerCamps' . $year, function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('name', 150)->nullable();
                $table->integer('x')->default(0);
                $table->integer('y')->default(0);
                $table->string('addyClock', 50)->default('?:??');
                $table->string('addyLetter', 50)->default('???');
                $table->string('addyLetter2', 50)->default('???');
                $table->integer('size')->default(0);
                $table->string('who', 50)->nullable();
                $table->text('needCampers')->nullable();
                $table->integer('villageID')->default(0);
                $table->integer('apiID')->default(-3);
                $table->timestamps();
                DB::raw("ALTER TABLE `BurnerCamps" . $year . "` CHANGE `name` `name` TEXT "
                    . "CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
            });
        }
        
    	Schema::create('BurnerFriends', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->binary('friends')->nullable();
			$table->timestamps();
		});
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
            Schema::create('BurnerFriends' . $year, function(Blueprint $table)
            {
                $table->increments('id');
                $table->bigInteger('user')->unsigned();
                $table->binary('friends')->nullable();
                $table->timestamps();
            });
		}
    	Schema::create('BurnerPastFriendUsers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->binary('friendUsers')->nullable();
            $table->integer('tot')->nullable();
			$table->timestamps();
		});
		
    	Schema::create('Burners', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->string('name', 100)->nullable();
			$table->string('playaName', 100)->nullable();
			$table->string('yearStatus', 20)->nullable();
			$table->string('addyClock', 50)->default('?:??');
			$table->string('addyLetter', 50)->default('???');
			$table->string('addyLetter2', 50)->default('???');
			$table->integer('x')->default(0);
			$table->integer('y')->default(0);
			$table->binary('notes')->nullable();
			$table->binary('privateNotes')->nullable();
			$table->string('dateArrive', 5)->nullable();
			$table->string('dateDepart', 5)->nullable();
			$table->string('email', 100)->nullable();
			$table->tinyInteger('emailRemind')->nullable();
			$table->string('camp', 200)->nullable();
			$table->integer('campID')->nullable();
			$table->integer('villageID')->nullable();
			$table->integer('edits')->nullable();
			$table->integer('opts')->nullable();
			$table->integer('messages')->nullable();
			$table->integer('ticketEdits')->nullable();
			$table->integer('ticketHas')->nullable();
			$table->integer('ticketNeeds')->nullable();
			$table->string('browser', 200)->nullable();
			$table->string('ip', 200)->nullable();
			$table->timestamps();
		});
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
            Schema::create('Burners', function(Blueprint $table)
            {
                $table->increments('id');
                $table->bigInteger('user')->unsigned();
                $table->string('name', 100)->nullable();
                $table->string('playaName', 100)->nullable();
                $table->string('yearStatus', 20)->nullable();
                $table->string('addyClock', 50)->default('?:??');
                $table->string('addyLetter', 50)->default('???');
                $table->string('addyLetter2', 50)->default('???');
                $table->integer('x')->default(0);
                $table->integer('y')->default(0);
                $table->binary('notes')->nullable();
                $table->binary('privateNotes')->nullable();
                $table->string('dateArrive', 5)->nullable();
                $table->string('dateDepart', 5)->nullable();
                $table->string('email', 100)->nullable();
                $table->tinyInteger('emailRemind')->nullable();
                $table->string('camp', 200)->nullable();
                $table->integer('campID')->nullable();
                $table->integer('villageID')->nullable();
                $table->integer('edits')->nullable();
                $table->integer('opts')->nullable();
                $table->integer('messages')->nullable();
                $table->integer('ticketEdits')->nullable();
                $table->integer('ticketHas')->nullable();
                $table->integer('ticketNeeds')->nullable();
                $table->string('browser', 200)->nullable();
                $table->string('ip', 200)->nullable();
                $table->timestamps();
            });
        }
    	Schema::create('BurnersDel', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->string('name', 100)->nullable();
			$table->string('playaName', 100)->nullable();
			$table->string('yearStatus', 20)->nullable();
			$table->string('addyClock', 50)->default('?:??');
			$table->string('addyLetter', 50)->default('???');
			$table->string('addyLetter2', 50)->default('???');
			$table->integer('x')->default(0);
			$table->integer('y')->default(0);
			$table->binary('notes')->nullable();
			$table->binary('privateNotes')->nullable();
			$table->string('dateArrive', 5)->nullable();
			$table->string('dateDepart', 5)->nullable();
			$table->string('email', 100)->nullable();
			$table->tinyInteger('emailRemind')->nullable();
			$table->string('camp', 200)->nullable();
			$table->integer('campID')->nullable();
			$table->integer('villageID')->nullable();
			$table->integer('edits')->nullable();
			$table->integer('opts')->nullable();
			$table->integer('messages')->nullable();
			$table->integer('ticketEdits')->nullable();
			$table->integer('ticketHas')->nullable();
			$table->integer('ticketNeeds')->nullable();
			$table->string('browser', 200)->nullable();
			$table->string('ip', 200)->nullable();
			$table->timestamps();
		});
        
    	Schema::create('BurnerVillages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 150)->nullable();
			$table->integer('x')->default(0);
			$table->integer('y')->default(0);
			$table->string('addyClock', 50)->default('?:??');
			$table->string('addyLetter', 50)->default('???');
			$table->string('addyLetter2', 50)->default('???');
			$table->integer('size')->nullable();
			$table->string('who', 50)->nullable();
			$table->timestamps();
		});
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
            Schema::create('BurnerVillages' . $year, function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('name', 150)->nullable();
                $table->integer('x')->default(0);
                $table->integer('y')->default(0);
                $table->string('addyClock', 50)->default('?:??');
                $table->string('addyLetter', 50)->default('???');
                $table->string('addyLetter2', 50)->default('???');
                $table->integer('size')->nullable();
                $table->string('who', 50)->nullable();
                $table->timestamps();
            });
		}
		
    	Schema::create('CacheAuto', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('typing', 250)->nullable();
			$table->binary('blobber')->nullable();
			$table->timestamps();
		});
    	Schema::create('CacheBlobs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type', 100)->nullable();
			$table->bigInteger('user')->unsigned();
			$table->binary('friends')->nullable();
			$table->binary('blobber')->nullable();
			$table->string('uniqueKey', 250)->nullable();
			$table->timestamps();
		});
		for ($mod = 0; $mod < 10; $mod++) {
            Schema::create('CacheBlobs' . $mod, function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('type', 100)->nullable();
                $table->bigInteger('user')->unsigned();
                $table->binary('friends')->nullable();
                $table->binary('blobber')->nullable();
                $table->string('uniqueKey', 250)->nullable();
                $table->timestamps();
            });
		}
    	Schema::create('CoordConvert', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('addyClock', 50)->default('?:??');
			$table->string('addyLetter', 50)->default('???');
			$table->integer('x')->default(0);
			$table->integer('y')->default(0);
			$table->timestamps();
		});
    	Schema::create('JerkCheck', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->string('campEdits', 250)->nullable();
			$table->string('alter', 50)->nullable();
			$table->timestamps();
		});
		
    	Schema::create('NetCampTots', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('campID')->nullable();
			$table->integer('influence')->nullable();
			$table->double('infPerMem')->nullable();
			$table->timestamps();
		});
    	Schema::create('NetDists', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('camp1')->nullable();
			$table->text('tblRow')->nullable();
			$table->timestamps();
		});
    	Schema::create('NetLinks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('camp1')->nullable();
			$table->integer('camp2')->nullable();
			$table->integer('bond')->nullable();
			$table->timestamps();
		});
    	Schema::create('NetUserTots', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->integer('friends')->nullable();
			$table->integer('mapFriends')->nullable();
			$table->integer('camps')->nullable();
			$table->timestamps();
		});
		
    	Schema::create('OfficialCampsAPI', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('uid', 100)->nullable();
			$table->string('name', 255)->nullable();
			$table->string('url', 255)->nullable();
			$table->text('description')->nullable();
			$table->string('hometown', 255)->nullable();
			$table->string('addyClock', 50)->nullable();
			$table->string('addyLetter', 50)->nullable();
			$table->timestamps();
		});
		DB::raw("ALTER TABLE `OfficialCampsAPI` CHANGE `description` `description` TEXT "
		    . "CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
		foreach (['description', 'name', 'hometown'] as $tbl) {
            DB::raw("ALTER TABLE `OfficialCampsAPI` CHANGE `" . $tbl . "` `" . $tbl . "` TEXT "
                . "CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
        }
		
    	Schema::create('PageEdits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->binary('dump')->nullable();
			$table->timestamps();
		});
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
            Schema::create('PageEdits' . $year, function(Blueprint $table)
            {
                $table->increments('id');
                $table->bigInteger('user')->unsigned();
                $table->binary('dump')->nullable();
                $table->timestamps();
            });
        }
    	Schema::create('PageLoads', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user')->unsigned();
			$table->bigInteger('currUser')->unsigned();
			$table->string('page', 250)->nullable();
			$table->string('ip', 50)->nullable();
			$table->string('browser', 250)->nullable();
			$table->dateTime('date')->nullable();
			$table->timestamps();
		});
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
            Schema::create('PageLoads' . $year, function(Blueprint $table)
            {
                $table->increments('id');
                $table->bigInteger('user')->unsigned();
                $table->bigInteger('currUser')->unsigned();
                $table->string('page', 250)->nullable();
                $table->string('ip', 50)->nullable();
                $table->string('browser', 250)->nullable();
                $table->dateTime('date')->nullable();
                $table->timestamps();
            });
        }
    	Schema::create('PageStats', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('day')->nullable();
			$table->integer('loads')->default(0);
			$table->integer('loadsU')->default(0);
			$table->integer('edits')->default(0);
			$table->integer('editsU')->default(0);
			$table->integer('newUsers')->default(0);
			$table->timestamps();
		});
		
    	Schema::create('TextSettings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type', 50)->nullable();
			$table->integer('year')->nullable();
			$table->string('value', 255)->nullable();
			$table->timestamps();
		});
		
    	Schema::create('Totals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('type', 50)->nullable();
			$table->integer('value')->default(0);
			$table->timestamps();
		});
		
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
    	Schema::drop('AllPastUsers');
    	Schema::drop('AllPastUsersDel');
    	Schema::drop('BurnerCamps');
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
		    Schema::drop('BurnerCamps' . $year);
		}
    	Schema::drop('BurnerFriends');
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
		    Schema::drop('BurnerFriends' . $year);
		}
    	Schema::drop('BurnerPastFriendUsers');
    	Schema::drop('Burners');
    	Schema::drop('BurnersDel');
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
		    Schema::drop('Burners' . $year);
		}
    	Schema::drop('BurnerVillages');
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
		    Schema::drop('BurnerVillages' . $year);
		}
    	Schema::drop('CacheAuto');
    	Schema::drop('CacheBlobs');
		for ($mod = 0; $mod < 10; $mod++) {
		    Schema::drop('CacheBlobs' . $mod);
		}
    	Schema::drop('CoordConvert');
    	Schema::drop('JerkCheck');
    	Schema::drop('NetCampTots');
    	Schema::drop('NetDists');
    	Schema::drop('NetLinks');
    	Schema::drop('NetUserTots');
    	Schema::drop('OfficialCampsAPI');
    	Schema::drop('PageEdits');
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
		    Schema::drop('PageEdits' . $year);
		}
    	Schema::drop('PageLoads');
		for ($year = 2011; $year < intVal(date("Y")); $year++) {
		    Schema::drop('PageLoads' . $year);
		}
    	Schema::drop('PageStats');
    	Schema::drop('TextSettings');
    	Schema::drop('Totals');
    }
}

        