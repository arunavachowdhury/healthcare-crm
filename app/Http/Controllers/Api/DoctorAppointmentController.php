<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

final class DoctorAppointmentController extends Controller
{
    public function __invoke(Request $request, Doctor $doctor): JsonResponse {
        $take = 10;
        $skip = 0;
        $page = 1;
        if ($request->has('page')) {
            $page = (int) $request->page;
        }
        if ($request->has('limit')) {
            $take = (int) $request->limit;
        }

        $user = Auth::user();

        if ($user->hasRole(UserRole::DOCTOR) && $user->doctor->id !== $doctor->id) {
            throw new UnauthorizedException(config('constants.HTTP_UNAUTHORIZED'), 'Unauthorized Access');
        }

        $skip = (int) $skip + ($page - 1) * $take;

        $data = Appointment::with(['paitient:id,first_name,last_name,gender,phone_number,email', 'doctor'])
            ->where('doctor_id', $doctor->id);

        $count = $data->count();

        $appointments = $data->orderByDesc('id')->take($take)->offset($skip)->get();

        return response()->json(['status' => 'success', 'data' => $appointments, 'count' => $count]);
    }
}
