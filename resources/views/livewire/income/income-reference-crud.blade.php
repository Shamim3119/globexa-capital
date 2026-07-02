 
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
                                <th style='text-align:center'>Client ID</th>
                                <th>Name</th>
                                <th style='text-align:center'>Invester ID</th>
                                <th >Name</th>
                                <th style='text-align:right'>Income</th>
                                <th style='text-align:center'>Invest At</th>
                                <th style='text-align:right'>Invest</th>
                                <th style='text-align:right'>Before Invest</th>
                                <th style='text-align:right'>After Invest</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($refIncomes as $income)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $income->client_id }}</td>
                            <td>{{ $income->client?->name }}</td>

                            <td>{{ $income->investment?->client_id }}</td>
                            <td>{{ $income->investment?->investor?->name }}</td>

                            <td class="text-end">
                                {{ number_format($income->amount,2) }}
                            </td>

                            <td class="text-center">
                                {{ optional($income->created_at)->format('d M Y, h:i A') }}
                            </td>
                            <td class="text-end">
                                {{ number_format($income->investment?->amount,2) }}
                            </td>
                            <td class="text-end">
                                {{ number_format($income->investment?->before_invest,2) }}
                            </td>
                            <td class="text-end">
                                {{ number_format($income->investment?->after_invest,2) }}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>