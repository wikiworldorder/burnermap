<?php
namespace BurnerMap\Controllers;

use DB;
use Illuminate\Http\Request;

use BurnerMap\Models\Totals;

use BurnerMap\Controllers\FaceController;

class OtherPages extends FaceController
{
    // Functions which prep and save the Welcome Page
    public function welcomeHome(Request $request)
    {
        $this->loadPage($request);
        $this->mainout .= view('vendor.burnermap.welcome')->render();
        return $this->printPage($request);
    }
    
    public function privacyPage(Request $request)
    {
        $this->loadPage($request, 'privacy');
        $this->mainout .= view('vendor.burnermap.privacy')->render();
        return $this->printPage($request);
    }
    
    public function tickets(Request $request)
    {
        $this->loadPage($request, 'tickets');
        //$this->completeNotif(7);
        if ($request->has('ticketSub') && trim($request->ticketType) != '') {
            $this->myBurn->ticketEdits++;
            $this->myBurn->ticketNeeds = $this->myBurn->ticketHas = 0;
            if ($this->myBurn->opts%7 == 0 && $request->ticketType == 'none') {
                $this->myBurn->opts = $this->myBurn->opts/7;
            } elseif ($this->myBurn->opts%7 > 0 && $request->ticketType != 'none') {
                $this->myBurn->opts = 7*$this->myBurn->opts;
            }
            if ($request->ticketType == 'need' && $request->has('howManyNeed') && intVal($request->howManyNeed) > 0) {
                $this->myBurn->ticketNeeds = intVal($request->howManyNeed);
            }
            if ($request->ticketType == 'have' && $request->has('howManyHave') && intVal($request->howManyHave) > 0) {
                $this->myBurn->ticketHas = intVal($request->howManyHave);
            }
            $this->myBurn->save();
            $this->clearFriendCaches();
            Totals::where('type', 'ticketExtra')->update([ 'value' => DB::table('Burners')->sum('ticketHas')   ]);
            Totals::where('type', 'ticketNeeds')->update([ 'value' => DB::table('Burners')->sum('ticketNeeds') ]);
            return redirect('/map?tickPop=' . (($this->myBurn->ticketNeeds > 0) ? "need" 
                : (($this->myBurn->ticketHas > 0) ? "have" : (($this->myBurn->opts%7 == 0) ? "help" : "none"))));
        }
        
        
        $currTickets = $this->myBurn->ticketNeeds;
        if ($currTickets == 0) $currTickets = $this->myBurn->ticketHas;
        $totTickets = [0, 0];
        $chk = Totals::where('type', 'ticketNeeds')->first();
        if ($chk && isset($chk->value)) $totTickets[0] = $chk->value;
        $chk = Totals::where('type', 'ticketExtra')->first();
        if ($chk && isset($chk->value)) $totTickets[1] = $chk->value;
        $this->mainout .= view('vendor.burnermap.tickets', [
            "myBurn"      => $this->myBurn,
            "currTickets" => $currTickets,
            "totTickets"  => $totTickets,
            "isAdmin"     => $GLOBALS["util"]->isAdmin
            ])->render();
        return $this->printPage($request);
    }
    
    public function ticketInstructHave(Request $request)
    {
        $this->mainout .= view('vendor.burnermap.tickets-instruct-have')->render();
        return $this->printPage($request);
    }
    
    public function ticketInstructNeed(Request $request)
    {
        $this->mainout .= view('vendor.burnermap.tickets-instruct-need')->render();
        return $this->printPage($request);
    }
    
    public function ticketInstructHelp(Request $request)
    {
        $this->mainout .= view('vendor.burnermap.tickets-instruct-help')->render();
        return $this->printPage($request);
    }
    
    public function bitcoinAddy(Request $request)
    {
        $this->mainout .= view('vendor.burnermap.bitcoin-address')->render();
        return $this->printPage($request);
    }
    
    
}