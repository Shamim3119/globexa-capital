<?php

namespace App\Livewire\Deposit;

use Livewire\Component;
use App\Models\Deposit;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class DepositCrud extends Component
{

    public $deposits;
    public $updateMode = false;
    public $activeTab = 'deposit';

    public $selectedDepositId;
    public $selectedStatus;
    public $selectedDeposit;  

    public function openStatusModal($id)
    {
        $this->selectedDepositId = $id;
        $this->selectedStatus = '';

        $this->selectedDeposit = Deposit::with([
            'depositer',
            'account.operator.currency',
            'status'
        ])->find($id);

        $this->dispatch('openStatusModal');
    }



    public function updateStatus()
    {
        DB::beginTransaction();

        try {

            $deposit = Deposit::find($this->selectedDepositId);

            if (!$deposit) {
                session()->flash('error', 'Deposit not found.');
                return;
            }

            // Only Pending deposits can be updated
            if ($deposit->status_id != 1) {
                session()->flash('error', 'This deposit has already been processed.');
                return;
            }

            $deposit->status_id = $this->selectedStatus;
            $deposit->accept_at = now();
            $deposit->save();

            // If Accepted
            if ($this->selectedStatus == 2) {

                $client = Client::find($deposit->deposit_by);

                if ($client) {
                    $client->deposit_balance += $deposit->amount;
                    $client->save();
                }
            }

            DB::commit();

            $this->dispatch('closeStatusModal');

            session()->flash('success', 'Status updated successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            session()->flash('error', $e->getMessage());
        }
    }

    public function render()
    {
        $this->deposits = Deposit::with([
            'depositer',
            'account.operator.currency',
            'status'
        ])->get();

        return view('livewire.deposit.deposit-crud', [
            'deposits' => $this->deposits
        ])->layout('layouts.app', [
            'title' => 'Deposit',
            'sub_title' => 'Deposit List'
        ]);
    }
}
