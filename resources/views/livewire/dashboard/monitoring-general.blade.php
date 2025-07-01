<div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h4 class="card-title">Monitoring Present By HSE Date {{ $dateString }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12" wire:loading>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 table-responsive" wire:loading.remove>
                    <table class="table table-bordered table-striped table-hover align-middle table-sm">
                        <thead>
                            <tr class="text-center align-middle">
                                <th rowspan="2">No</th>
                                <th rowspan="2">Group</th>
                                <th rowspan="2">HSE Name</th>
                                @foreach ($timeTypes as $type)
                                    <th scope="col" colspan="6">{{ str_pad($type, 2, '0', STR_PAD_LEFT) . ':00' }}
                                    </th>
                                @endforeach
                            </tr>
                            <tr class="text-center align-middle">
                                @foreach ($timeTypes as $type)
                                    <th class="text-center">H</th>
                                    <th class="text-center">S</th>
                                    <th class="text-center">TK</th>
                                    <th class="text-center">PS</th>
                                    <th class="text-center">C</th>
                                    <th class="text-center">T</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monitoringData as $group)
                                @foreach ($group['users'] as $user)
                                    <tr>
                                        <td class="text-center">{{ $loop->parent->iteration }}</td>
                                        <td class="text-center">{{ $group['group_name'] }}
                                            ({{ $group['supervisor_name'] }})
                                        </td>
                                        <td class="text-center">{{ $user['user_name'] }}</td>
                                        @foreach ($user['types'] as $typeData)
                                            <td class="text-center">{{ $typeData['H'] }}</td>
                                            <td class="text-center">{{ $typeData['S'] }}</td>
                                            <td class="text-center">{{ $typeData['TK'] }}</td>
                                            <td class="text-center">{{ $typeData['PS'] }}</td>
                                            <td class="text-center">{{ $typeData['C'] }}</td>
                                            <td class="text-center">{{ $typeData['T'] }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" colspan="3">Total</th>
                                @foreach ($timeTypes as $type)
                                    @php $formattedTime = str_pad($type, 2, '0', STR_PAD_LEFT); @endphp
                                    <th class="text-center">{{ $totals[$formattedTime]['H'] }}</th>
                                    <th class="text-center">{{ $totals[$formattedTime]['S'] }}</th>
                                    <th class="text-center">{{ $totals[$formattedTime]['TK'] }}</th>
                                    <th class="text-center">{{ $totals[$formattedTime]['PS'] }}</th>
                                    <th class="text-center">{{ $totals[$formattedTime]['C'] }}</th>
                                    <th class="text-center">{{ $totals[$formattedTime]['T'] }}</th>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-12 mt-2">
                    <p class="text-muted font-size-10">Keterangan : <br>
                        H = Hadir <br>
                        S = Sakit <br>
                        TK = Tanpa Keterangan <br>
                        PS = Pindah Supervisor <br>
                        C = Cuti <br>
                        T = Training
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
