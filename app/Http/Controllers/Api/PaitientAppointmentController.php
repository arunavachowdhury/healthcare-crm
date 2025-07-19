<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Models\Paitient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PaitientAppointmentController extends Controller
{
    public function __invoke(Request $request, Paitient $paitient): JsonResponse
    {
        $take = 10; $skip = 0; $page = 1;
        if ($request->has('page')) {
            $page = (int) $request->page;
        }
        if ($request->has('limit')) {
            $take = (int) $request->limit;
        }

        $user = Auth::user();

        if($user->hasRole(UserRole::PAITIENT) && $user->paitient->id !== $paitient->id) {
            throw new UnauthorizedException(config('constants.HTTP_UNAUTHORIZED'), 'Unauthorized Access');
        }

        $skip = (int) $skip + ($page - 1) * $take;

        $data = Appointment::with(['paitient:id,first_name,last_name,gender,phone_number,email', 'doctor'])
                            ->when($user->hasRole(UserRole::DOCTOR), function($query) use($user) {
                                $query->where('doctor_id', $user->doctor->id);
                            })
                            ->where('paitient_id', $paitient->id);
        $count = $data->count();

        $appointments = $data->orderByDesc('id')->take($take)->offset($skip)->get();

        return response()->json(['status'=> 'success', 'data' => $appointments, 'count'=> $count]);
    }
}
