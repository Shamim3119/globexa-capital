 

<div>
    <br>
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
                     
                                <th>Transfer By</th>
                                <th style='text-align:center'>Transfer At</th>
                                <th style='text-align:center'>Anount</th>
                                <th style='text-align:right'>Before Incone</th>
                                <th style='text-align:right'>After Incone</th>
                                <th style='text-align:right'>Before Deposit</th>
                                <th style='text-align:right'>After Deposit</th>
                                <th style='text-align:center'>Status</th>

 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transfers as $transfer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transfer->member->id ?? '' }} / {{ $transfer->member->name ?? '' }}</td>
                                    <td style='text-align:center'>{{ $transfer->created_at->format('d M y, h:i A') }}</td>

                                    <td style='text-align:right'> {{ $transfer->amount ?? '' }}</td>

                                    <td style='text-align:right'>
                                        {{ $transfer->bofore_incom ?? '' }}
                                    </td>
                                     <td style='text-align:right'>
                                        {{ $transfer->after_incom ?? '' }}
                                    </td>
                                    <td style='text-align:right'> {{ $transfer->before_deposit ?? '' }}</td>
                                    <td style='text-align:right'> {{ $transfer->after_deposit ?? '' }}</td>
                                    <td style='text-align:center; color:green;'>Success</td>
          
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

 
 
 
 


</div>