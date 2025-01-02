<?php

namespace App\Filament\Resources\MeetingResource\Pages;

use App\Filament\Resources\MeetingResource;
use App\Models\Product;
use App\Models\Vendor;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

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
//    protected function mutateFormDataBeforeCreate(array $data): array
//    {
//        $vendors = collect(Arr::get($data, 'vendors'));
//        $products = $vendors->pluck('products')->flatten()->toArray();
//        $vendors = $vendors->pluck('vendor_id')->toArray();
//
//        unset($data['vendors']);
//
//        $data['vendors'] = implode(',', $vendors);
//        $data['products'] = implode(',', $products);
//
//        return $data;
//    }
}
