@props(['headers' => [], 'data' => [], 'actions' => true])

<div class="card shadow-lg border-0">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        @foreach($headers as $header)
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 {{ $loop->first ? 'ps-4' : '' }}">
                                {{ $header }}
                            </th>
                        @endforeach
                        @if($actions)
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>
