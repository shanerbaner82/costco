<?php

namespace App\Filament\Resources\MeetingResource\Pages;

use App\Filament\Resources\MeetingResource;
use App\Models\Product;
use App\Models\Vendor;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;

//    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
//    {
//        $vendors = Vendor::query()->whereIn('id', explode(',', $data['vendors']))->get();
//        $products = Product::query()->whereIn('id', explode(',', $data['products']))->get();
//
//        unset($data['vendors']);
//        unset($data['products']);
//
//        $meeting = parent::handleRecordCreation($data);
//
//        foreach ($vendors as $vendor) {
//            $meeting->vendors()->attach($vendor);
//        }
//
//        foreach ($products as $product) {
//            $meeting->products()->attach($product);
//        }
//
//
//        return $meeting;
//    }
//
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $meeting = Carbon::parse($data['meeting_date'])->format('m/d/Y');

        if(isset($data['kitchen_time'])) {
            $data['kitchen_time'] = Carbon::make($meeting . ' ' . Carbon::parse($data['kitchen_time'])->format('H:i:s'));
        }

        if(isset($data['start_time'])) {
            $data['start_time'] = Carbon::make($meeting . ' ' . Carbon::parse($data['start_time'])->format('H:i:s'));
        }
        if(isset($data['end_time'])) {
            $data['end_time'] = Carbon::make($meeting . ' ' . Carbon::parse($data['end_time'])->format('H:i:s'));
        }
        return $data;
    }
}
