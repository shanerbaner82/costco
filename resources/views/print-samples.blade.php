<x-layouts.app>
    <div class="p-8 max-w-4xl mx-auto " style="font-family: 'Arial', 'Helvetica', sans-serif;">
        <!-- Header Info -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-family: 'Arial', 'Helvetica', sans-serif; font-size: 11pt; color: #333333;">
            <tr>
                <td style="padding: 10px; width: 150px; font-weight: 600;font-family: 'Arial', 'Helvetica', sans-serif;">Meeting Date:</td>
                <td style="padding: 10px;">{{$meeting->start_time->format('m/d/Y')}}</td>
                <td style="padding: 10px; width: 150px; font-weight: 600;">Buyers:</td>
                <td style="padding: 10px;">
                    @foreach($meeting->buyers as $buyer)
                        {{$buyer->name_position}}<br>
                    @endforeach
                </td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 10px; font-weight: 600;">Region:</td>
                <td style="padding: 10px;">{{$meeting->region->name}}</td>
                <td style="padding: 10px; font-weight: 600;">Sales Team:</td>
                <td style="padding: 10px;">
                    @foreach($meeting->users as $user)
                        {{$user->name}}<br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: 600;">Department:</td>
                <td style="padding: 10px;">{{$meeting->department->name}}</td>
                <td style="padding: 10px; font-weight: 600;">Vendors:</td>
                <td style="padding: 10px;">
                    @foreach($meeting->vendors as $vendor)
                        {{$vendor->name}}<br>
                    @endforeach
                </td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 10px; font-weight: 600;">Status:</td>
                <td style="padding: 10px;">{{$meeting->status}}</td>
                <td style="padding: 10px;"></td>
                <td style="padding: 10px;"></td>
            </tr>
        </table>

        <!-- Type and Data -->
        <div class="mt-8">
            <h2 class="text-lg font-semibold text-gray-800 ">{{$vendor->name}}</h2>
            <div class="prose max-w-none print:prose-sm">
                {!! $samples !!}
            </div>
        </div>
    </div>

</x-layouts.app>
