<?php

namespace App\Http\Controllers\Api;

use App\Models\Paitient;
use Illuminate\Http\Request;
use App\Models\PaitientAudit;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PaitientAuditController extends Controller
{
    public function __invoke(Request $request, Paitient $paitient): JsonResponse
    {
        $audit_data = PaitientAudit::where('paitient_id', $paitient->id)->get();

        return response()->json(['status'=> 'success', 'data'=> $audit_data]);
    }
}
