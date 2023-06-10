<?php

use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


Route::get('flights', [FlightController::class, 'index'])->name('flight_index');

Route::post('tickets', [TicketController::class, 'store'])->name('ticket_store');
Route::put('tickets/{ticket:uuid}', [TicketController::class, 'put'])->name('ticket_put');
