<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentStoreRequest;
use App\Http\Requests\AppointmentUpdateRequest;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

final class AppointmentController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array {
        return [
            'auth:sanctum',
            new Middleware('role:'.UserRole::ADMIN->value.'|'.UserRole::AGENT->value.'|'.UserRole::DOCTOR->value, only: ['update']),
            new Middleware('role:'.UserRole::ADMIN->value.'|'.UserRole::AGENT->value, except: ['update']),
        ];
    }

    public function index(Request $request): JsonResponse {
        $take = 10;
        $skip = 0;
        $page = 1;
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

        return response()->json(['status' => 'success', 'data' => $appointments, 'count' => $count]);

    }

    public function store(AppointmentStoreRequest $request): JsonResponse {
        $validated = $request->validated();
        $validated['status'] = AppointmentStatus::SCHEDULED;

        $appointment = Appointment::create($validated);

        return response()->json(['status' => 'success', 'data' => $appointment->load(['paitient:id,first_name,last_name,gender,phone_number,email', 'doctor'])]);
    }

    public function update(AppointmentUpdateRequest $request, Appointment $appointment): JsonResponse {
        $validated = $request->validated();

        if (! $request->status) {
            $validated['status'] = $appointment->status;
        }

        $appointment->update($validated);

        return response()->json(['status' => 'success', 'data' => $appointment->load(['paitient:id,first_name,last_name,gender,phone_number,email', 'doctor'])]);
    }

    public function destroy(Appointment $appointment): JsonResponse {
        $appointment->delete();

        return response()->json(['status' => 'success']);
    }
}
