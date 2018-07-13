<?php
namespace BurnerMap\Controllers;

use DB;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use BurnerMap\Models\BurnerCamps;
use BurnerMap\Models\OfficialCampsAPI;
use BurnerMap\Models\Totals;

use BurnerMap\Controllers\FaceController;

class AdminImportExport extends FaceController
{
    protected $uList = [];
    
    public function newYearArchiving(Request $request)
    {
        $this->loadPage('admin');
        $msg = '';
        $y = intVal(date("Y"));
        $lastY = $y-1;
        if (Schema::hasTable('BurnerCamps' . $lastY)) {
            $msg .= '<div class="adminSpacer"><i>This year\'s data has already been reset.</i></div>';
        } else {
            Schema::create('Burners' . $lastY, function(Blueprint $table)
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
            Schema::create('BurnerCamps' . $lastY, function(Blueprint $table)
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
                DB::raw("ALTER TABLE `BurnerCamps" . $lastY . "` CHANGE `name` `name` TEXT "
                    . "CHARACTER SET utf8mb4 COLLATE utf8mb4_bin");
            });
            Schema::create('BurnerFriends' . $lastY, function(Blueprint $table)
            {
                $table->increments('id');
                $table->bigInteger('user')->unsigned();
                $table->binary('friends')->nullable();
                $table->timestamps();
            });
            Schema::create('BurnerVillages' . $lastY, function(Blueprint $table)
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
            Schema::create('PageEdits' . $lastY, function(Blueprint $table)
            {
                $table->increments('id');
                $table->bigInteger('user')->unsigned();
                $table->binary('dump')->nullable();
                $table->timestamps();
            });
            Schema::create('PageLoads' . $lastY, function(Blueprint $table)
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
            $qmen = [];
            $qmen[] = "INSERT INTO `Burners".$lastY."` (`id`, `user`, `name`, `playaName`, `camp`, `addyClock`, "
                . "`addyLetter`, `addyLetter2`, `notes`, `x`, `y`, `email`, `emailRemind`, `campID`, "
                . "`browser`, `edits`, `opts`, `ip`, `privateNotes`, `messages`, `ticketEdits`, "
                . "`ticketNeeds`, `ticketHas`, `dateArrive`, `dateDepart`, `yearStatus`, `villageID`) SELECT `id`, "
                . "`user`, `name`, `playaName`, `camp`, `addyClock`, `addyLetter`, `addyLetter2`, `notes`, "
                . "`x`, `y`, `email`, `emailRemind`, `campID`, `browser`, `edits`, `opts`, "
                . "`ip`, `privateNotes`, `messages`, `ticketEdits`, `ticketNeeds`, `ticketHas`, `dateArrive`, "
                . "`dateDepart`, `yearStatus`, `villageID` FROM `Burners`";
            $qmen[] = "INSERT INTO `burnerFriends".$lastY."` (`id`, `user`, `friends`) SELECT `id`, `user`, `friends` "
                . "FROM `burnerFriends`";
            $qmen[] = "INSERT INTO `burnerCamps".$lastY."` (`id`, `name`, `x`, `y`, `addyClock`, `addyLetter`, "
                . "`addyLetter2`, `size`, `who`, `needCampers`, `villageID`, `apiID`) SELECT `id`, `name`, `x`, `y`, "
                . "`addyClock`, `addyLetter`, `addyLetter2`, `size`, `who`, `needCampers`, `villageID`, `apiID` "
                . "FROM `burnerCamps`";
            $qmen[] = "INSERT INTO `burnerVillages".$lastY."` (`id`, `name`, `x`, `y`, `addyClock`, `addyLetter`, "
                . "`addyLetter2`, `size`, `who`) SELECT `id`, `name`, `x`, `y`, `addyClock`, `addyLetter`, "
                . "`addyLetter2`, `size`, `who` FROM `burnerVillages`";
            $qmen[] = "INSERT INTO `pageLoads".$lastY."` (`id`, `user`, `currUser`, `page`, `ip`, `browser`, `date`) "
                . "SELECT `id`, `user`, `currUser`, `page`, `ip`, `browser`, `date` FROM `pageLoads` "
                . "WHERE `date` < '".$y."-01-01 00:00:00'";
            $qmen[] = "INSERT INTO `pageEdits".$lastY."` (`id`, `user`, `date`, `dump`) SELECT `id`, `user`, `date`, "
                . "`dump` FROM `pageEdits` WHERE `date` < '".$y."-01-01 00:00:00'";
            foreach ($qmen as $q) {
                $msg .= $q . '<br /><br />';
                DB::raw($q);
            }
            PageLoads::where('created_at', '<', $y . '-01-01 00:00:00')
                ->delete();
            PageEdits::where('created_at', '<', $y . '-01-01 00:00:00')
                ->delete();
            DB::table('Burners')->truncate();
            DB::table('BurnerFriends')->truncate();
            DB::table('BurnerCamps')->truncate();
            DB::table('BurnerVillages')->truncate();
            DB::table('BurnerPastFriendUsers')->truncate();
            DB::table('JerkCheck')->truncate();
            DB::table('CacheBlobs')->truncate();
            for ($i=0; $i<10; $i++) $qmen[] = DB::table('CacheBlobs' . $i)->truncate();
            Totals::whereIn('type', ['ticketExtra', 'ticketNeeds', 'totActiveCamps', 'avgCampSize'])
                ->update([ 'value' => 0 ]);
        }
        $this->mainout .= view('vendor.burnermap.admin.new-year-archiving', [ "msg" => $msg ])->render();
        return $this->printPage($request);
    }
    
    public function apiImport(Request $request)
    {
        $this->loadPage('admin');
        $msg = '';
        $apiFld = '../storage/app/imports';
        $apiFile = 'BORG-API-' . date("Y") . '.json';
        $apiURL = $apiFld . '/' . $apiFile;
        
        if ($request->has('upload')) {
            
            if ($request->hasFile('json')) {
                if (file_exists($apiFile)) Storage::delete($apiFile);
                if ($request->file('json')->storeAs('imports', $apiFile)) {
                    $msg = '<h2>Upload Successful!</h2>';
                    $log = $this->loadLog('api-uploaded');
                    $log->update([ 'value' => time() ]);
                } else {
                    $msg = '<h2>Upload Failed.</h2>';
                }
            } else {
                $msg = '<h2>Upload Failed.</h2>';
            }
            
        } elseif ($request->has('runImport')) {
            
            $msg .= '<a href="?mergeImport=1" class="admMenu" style="font-size: 30pt;"><i>'
                . 'YES, NOW MERGE THE IMPORT</i></a>';
            $stateJSON = json_decode(file_get_contents($apiURL), TRUE);
            if (sizeof($stateJSON) > 0) {
                DB::table('OfficialCampsAPI')->truncate();
                foreach ($stateJSON as $j => $rec) {
                    $camp = new OfficialCampsAPI;
                    $camp->uid         = $rec["uid"];
                    $camp->name        = $rec["name"];
                    $camp->url         = $rec["url"];
                    $camp->description = $rec["description"];
                    $camp->hometown    = $rec["hometown"];
                    $camp->save();
                    $msg .= ', ' . $rec["name"];
                }
                $log = $this->loadLog('api-run-import');
                $log->update([ 'value' => time() ]);
            }
            
        } elseif ($request->has('mergeImport')) {
            
            $updates = [0, 0];
            $apis = OfficialCampsAPI::get();
            if ($apis->isNotEmpty()) {
                foreach ($apis as $a) {
                    $camp = BurnerCamps::where('name', 'LIKE', $a->name)
                        ->first();
                    if ($camp) {
                        $camp->apiID = $a->id;
                        $camp->save();
                        $updates[0]++;
                    } else {
                        $camp = new BurnerCamps;
                        $camp->name  = $a->name;
                        $camp->apiID = $a->id;
                        $camp->save();
                        $updates[1]++;
                    }
                }
            }
            $msg .= '<br />' . number_format($updates[0]) . ' updated camp records, ' 
                . number_format($updates[1]) . ' inserted camps';
            $log = $this->loadLog('api-merge-import');
            $log->update([ 'value' => time() ]);
            
        } else {
            
            if (file_exists($apiURL)) {
                $msg = '<center>Now that you\'ve uploaded this year\'s import...</center><br />'
                    . '<a href="?runImport=1" class="admMenu" style="font-size: 30pt;"><i>'
                    . 'Import This Year\'s Camps API</i></a><br /><br />';
            }
            
        }
        $this->mainout .= view('vendor.burnermap.admin.import-export', [ "msg" => $msg ])->render();
        return $this->printPage($request);
    }
    
    protected function loadLog($type)
    {
        $log = Totals::where('type', $type)
            ->first();
        if (!$log) {
            $log = new Totals;
            $log->type = $type;
            $log->save();
        }
        return $log;
    }
    
    public function exportNewEmails(Request $request)
    {
        $this->loadPage('admin');
        $csvOut = '';
        $this->uList = [];
        $msg = $this->loadEmails() . $this->loadEmails('' . (intVal(date("Y"))-1) . '');
        foreach ($this->uList as $u) {
            $chk = DB::connection('mysqlPhpList')
                ->table('phplist_user_user')
                ->select('id')
                ->where('email', 'LIKE', $u[0])
                ->first();
            if (!$chk) $csvOut .= $u[0] . ',' . $u[1] . "\n";
        }
        $this->mainout .= view('vendor.burnermap.admin.export-new-emails', [
            "msg"    => $msg,
            "csvOut" => $csvOut
            ])->render();
        return $this->printPage($request);
    }
    
    protected function loadEmails($year = '')
    {
        $msg = '';
        $regEx = "/[^a-zA-Z0-9\s@_.\-\+]/";
        eval("\$chk = BurnerMap\\Models\\Burners" . $year . "::select('user', 'email', 'name', 'playaName')
            ->whereNotNull('email')
            ->where('email', 'NOT LIKE', '')
            ->get();");
        if ($chk->isNotEmpty()) {
            foreach ($chk as $u) {
                if (trim($u->email) != '' && strpos($u->email, '@') !== false) {
                    $pos = strpos($u["name"], ' ');
                    $first = substr($u["name"], 0, $pos);
                    $name = ((trim($u["playaName"]) != '') ? $u["playaName"] : $first);
                    $tmp = $GLOBALS["util"]->mexplode(',', $u->email);
                    foreach ($tmp as $t) {
                        if ($t != preg_replace($regEx, "", $t)) {
                            $msg .= 'EEP!... ' . $t . ' -) ' . preg_replace($regEx, "", $t) . '<br />';
                            $t = preg_replace($regEx, "", $t);
                        }
                        $this->uList[] = [trim($t), trim(preg_replace($regEx, "", $name))];
                    }
                }
            }
        }
        return $msg;
    }
    
}