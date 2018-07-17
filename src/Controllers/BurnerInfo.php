<?php
namespace BurnerMap\Controllers;

use BurnerMap\Models\BlockUsers;

class BurnerInfo
{
    public $userMod         = 0; // UserID%10 used to group cached blobs of content
    public $myFriends       = [];
    public $allPastFrnds    = null;
    public $myBlocks        = [];
    public $theirBlocks     = [];
    public $myCamp          = null;
    public $myVillage       = null;
    public $myCampHasCoords = false;
    
    public function loadBlocks($user)
    {
        $this->myBlocks = $this->theirBlocks = [];
        $chk = BlockUsers::where('user', $user)
            ->first();
        if ($chk && isset($chk->blocks) && trim($chk->blocks) != '') {
            $this->myBlocks = $GLOBALS["util"]->mexplode(',', $chk->blocks);
        }
        $chk = BlockUsers::where('blocks', 'LIKE', ',' . $user . ',')
            ->get();
        if ($chk->isNotEmpty()) {
            foreach ($chk as $block) $this->theirBlocks[] = $block->user;
        }
        return true;
    }
    
    public function getMapFriends($user = -1)
    {
        $mappers = (($user > 0) ? $user : '') . $this->allPastFrnds->friendUsers;
        $blocks = $GLOBALS["util"]->mexplode(',', $this->allPastFrnds->hideUsers);
        if (sizeof($blocks) > 0) {
            foreach ($blocks as $block) $mappers = str_replace(',' . $block . ',', ',', $mappers);
        }
        return $GLOBALS["util"]->mexplode(',', $mappers);
    }
    
}