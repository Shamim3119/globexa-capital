 
<div>
    @include('livewire.income.tab-menu')
 
    <div class='row'>
        <div class='col-12 col-md-12 col-lg-12'>


            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} List</div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mt-3">

                        <thead>
                            <tr>
                                <th style="width:2%">SL</th>
                                <th>Deposit By</th>
                                <th style='text-align:center'>Deposit At</th>
                                <th style='text-align:right'>Amount</th>
                                <th style='text-align:right'>Exch. Amt.</th>
                                <th style='text-align:center'>Currency</th>
                                <th style='text-align:center'>Slip</th>
                                <th style='text-align:center'>Account</th>
              
                                <th style='text-align:center'>Accept At</th>
                                <th style='text-align:center'>Status</th>
                            </tr>
                        </thead>
                        <tbody>
 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>