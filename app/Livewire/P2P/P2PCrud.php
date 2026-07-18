<?php

namespace App\Livewire\P2P;

use Livewire\Component;
use App\Models\P2P;

class P2PCrud extends Component
{

    public $p2ps;
    public $updateMode = false;
    public $activeTab = 'p2p';

    public function render()
    {

        $this->p2ps = P2P::with([
            'sender',
            'receiver'
        ])->get();

        return view('livewire.p2-p.p2-p-crud', [
            'p2ps' => $this->p2ps
        ])->layout('layouts.app', [
            'title' => 'P2P',
            'sub_title' => 'P2P List'
        ]);
    }
 
}
