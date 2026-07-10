<?php

namespace App\Livewire\Refund;
use App\Models\Refund;
use App\Models\Client;
use App\Models\Investment;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class RefundCrud extends Component
{

    public $refunds;
    public $updateMode = false;
    public $activeTab = 'refund';

    public $selectedRefundId;
    public $selectedStatus;
    public $selectedRefund;  

 
    public function openStatusModal($id)
    {
        $this->selectedRefundId = $id;
        $this->selectedStatus = '';

        $this->selectedRefund = Refund::with([
            'member',
            'status'
        ])->find($id);

        $this->dispatch('openStatusModal');
    }


    public function updateStatus()
    {
        DB::beginTransaction();

        try {

            $refund = Refund::find($this->selectedRefundId);

            if (!$refund) {
                session()->flash('error', 'Refund not found.');
                return;
            }

            // Only Pending refunds can be updated
            if ($refund->status_id != 1) {
                session()->flash('error', 'This refund has already been processed.');
                return;
            }

            $refund->status_id = $this->selectedStatus;
            $refund->accept_at = now();
            $refund->save();

            // If Accepted
            if ($this->selectedStatus == 2) {

                // Update Investment
                $investment = Investment::find($refund->investment_id);

                if ($investment) {
                    $investment->inactive = 1;
                    $investment->save();
                }

                // Update Client Balance
                $client = Client::find($refund->client_id);

                if ($client) {
                    $client->investment_balance -= $refund->amount;
                    $client->income_balance += $refund->return_amount;
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
        $this->refunds = Refund::with([
            'member',
            'status'
        ])->get();

        return view('livewire.refund.refund-crud', [
            'refunds' => $this->refunds
        ])->layout('layouts.app', [
            'title' => 'Refund',
            'sub_title' => 'Refund List'
        ]);
    }
}
