<?php

use App\Models\Meeting;
use App\Models\ProductMeeting;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/print', function () {
    $meeting = Meeting::find(request()->get('meeting'));
    $pdf = Pdf::loadView('print', [
        'meeting' => $meeting,
        'type' => request()->get('type'),
        'data' => request()->get('data'),
    ]);
    return $pdf->download(request()->get('type') . '-' . $meeting->region->name . '-' . $meeting->department->name . '-' . $meeting->start_time->format('m-d-y') . '.pdf');
})->name('print');

Route::get('download-buy-doc/{meeting}/{product}', function($meeting, $product) {
    $product_meeting = ProductMeeting::where('meeting_id', $meeting)->where('product_id', $product)->first();
    $file  = Storage::disk('public')->url($product_meeting->buy_doc_url);
    dd($file);
})->name('download-buy-doc');
