<?php

namespace App\Http\Controllers\Api;

use App\Models\Paitient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaitientRequest;
use App\Http\Requests\PaitientUpdateRequest;

class PaitientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Paitient::when($request->filter, function($query) use($request) {
            $query->whereAny([
                'first_name',
                'last_name',
                'phone_number'
            ], 'like', "{$request->filter}%");
        })->get();
        
        return response()->json(['status'=> 'success', 'data'=> $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaitientRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $paitient = Paitient::create($validated);

        return response()->json(['status'=> 'success', 'data'=> $paitient]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paitient $paitient): JsonResponse
    {
        return response()->json(['status'=> 'success', 'data'=> $paitient]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaitientUpdateRequest $request, Paitient $paitient): JsonResponse
    {
        $validated = $request->validated();

        $paitient->update($validated);

        return response()->json(['status'=> 'success', 'data'=> $paitient]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paitient $paitient): JsonResponse
    {
        $paitient->delete();

        return response()->json(['status'=> 'success']);
    }
}
