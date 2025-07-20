<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paitient;
use App\Models\PaitientAudit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PaitientAuditController extends Controller
{
    public function __invoke(Request $request, Paitient $paitient): JsonResponse {
        $audit_data = PaitientAudit::where('paitient_id', $paitient->id)->get();

        return response()->json(['status' => 'success', 'data' => $audit_data]);
    }
}
