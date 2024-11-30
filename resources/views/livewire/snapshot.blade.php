<div>
    <div class="">
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block w-full py-2 align-middle">
                    <table class="w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th></th>
                            @foreach($regions as $region)
                                <th scope="col"
                                    class="py-3.5 text-center text-sm font-semibold text-gray-900 w-[12%] ">
                                    {{$region->name}}
                                </th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white px-10">
                        @foreach($vendors as $vendor)
                            <tr>
                                <td class="whitespace-nowrap py-4 text-sm font-medium text-gray-950 pl-4">
                                    {{$vendor->name}}
                                </td>
                                @foreach($regions as $region)
                                    <td class="whitespace-nowrap text-center  py-4 text-sm text-gray-500">
                                        @php
                                            $meetings = $vendor->meetings()->where('region_id', $region->id)->get();
                                        @endphp
                                        @if($meetings->isNotEmpty())
                                            @foreach($meetings as $meeting)
                                                <a href="{{route('filament.admin.resources.meetings.edit', ['record' => $meeting])}}"
                                                   class="text-blue-500 bold underline text-center ">
                                                    {{$meeting->start_time->format('M d')}} {{$meeting->department->name}}
                                                </a> <br/>
                                            @endforeach
                                        @else
                                            <p class="text-center">-</p>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
