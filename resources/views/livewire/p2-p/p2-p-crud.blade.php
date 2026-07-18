 

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
                     
                                <th style='text-align:center'>P2P At</th>
                                <th style='text-align:left'>From</th>
                                <th style='text-align:left'>TO</th>
                                <th style='text-align:right'>Amount</th>
                                <th style='text-align:center'>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($p2ps as $p2p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style='text-align:center'>{{ $p2p->created_at->format('d M y, h:i A') }}</td>
                                    <td>{{ $p2p->sender->id ?? '' }} / {{ $p2p->sender->name ?? '' }}</td>
                                    <td>{{ $p2p->receiver->id ?? '' }} / {{ $p2p->receiver->name ?? '' }}</td>
                                    <td style='text-align:right'> {{ $p2p->amount ?? '' }}</td>
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