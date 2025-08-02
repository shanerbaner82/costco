<x-filament::page>
    <x-filament::card>
        <h2 class="text-xl font-bold mb-4">Meetings with Samples</h2>

        @forelse ($meetings as $meeting)
            <div class="mb-6 border-b pb-4">
                <div class="font-semibold">
                    @if($meeting->start_time)
                        Meeting on {{ $meeting->start_time->format('F j, Y') }} (Status: {{ $meeting->status }})
                    @endif
                </div>

                @foreach ($meeting->vendors as $vendor)
                    <div class="border border-gray-300 rounded mb-10 p-4 mb-6">
                        @if (! empty($vendor->pivot->samples))
                            <strong class="text-xl">{{ $vendor->name }}</strong> <br/>
                            <br/>{!! $vendor->pivot->samples !!}
                        @endif
                    </div>
                @endforeach
            </div>
        @empty
            <p>No meetings found.</p>
        @endforelse
    </x-filament::card>
</x-filament::page>
