<?php

namespace App\Http\Controllers\Api;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Enums\AppointmentStatus;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentStoreRequest;
use App\Http\Requests\AppointmentUpdateRequest;

class AppointmentController extends Controller
{
    public function index(Request $request): JsonResponse 
    {
        $take = 10; $skip = 0; $page = 1;
        if ($request->has('page')) {
            $page = (int) $request->page;
        }
        if ($request->has('limit')) {
            $take = (int) $request->limit;
        }

        $skip = (int) $skip + ($page - 1) * $take;

        $data = Appointment::with(['paitient:id,first_name,last_name,gender,phone_number,email', 'doctor']);

        $count = $data->count();
        $appointments = $data->orderByDesc('id')->take($take)->skip($skip)->get();

        return response()->json(['status'=> 'success', 'data' => $appointments, 'count'=> $count]);
            
    }

    public function store(AppointmentStoreRequest $request): JsonResponse 
    {
        $validated = $request->validated();
        $validated['status'] = AppointmentStatus::SCHEDULED; 

        $appointment = Appointment::create($validated);

        return response()->json(['status'=> 'success', 'data'=> $appointment->load(['paitient:id,first_name,last_name,gender,phone_number,email', 'doctor'])]);
    }

    public function update(AppointmentUpdateRequest $request, Appointment $appointment): JsonResponse 
    {
        $validated = $request->validated();

        if(!$request->status) {
            $validated['status'] = $appointment->status;
        }

        $appointment->update($validated);

        return response()->json(['status'=> 'success', 'data'=> $appointment->load(['paitient:id,first_name,last_name,gender,phone_number,email', 'doctor'])]);
    }

    public function destroy(Appointment $appointment): JsonResponse 
    {
        $appointment->delete();

        return response()->json(['status'=> 'success']);
    }
    
}
