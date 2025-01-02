<?php

use App\Models\Meeting;
use Illuminate\Support\Facades\Route;

Route::get('/print', function () {
    $meeting = Meeting::find(request()->get('meeting'));
    $pdf = Pdf::loadView('print', [
        'meeting' => $meeting,
        'type' => request()->get('type'),
        'data' => request()->get('data'),
    ]);
    return $pdf->download(request()->get('type') . '-' . $meeting->region->name . '-' . $meeting->department->name . '-' . $meeting->start_time->format('m-d-y') . '.pdf');
})->name('print');
