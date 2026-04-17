<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::with('user')->latest()->get();

        return response()->json([
            'services' => $services,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => [
                'required',
                'string',
                'in:Web Development,Graphic Design,Photography,Video Editing,Writing & Editing,Tutoring,Music & Audio,Data Entry,Social Media Management,Translation'
            ],
            'rate' => ['required', 'numeric', 'min:0'],
            'rate_type' => [
                'required',
                'string',
                'in:per hour,per day,per week,per month,fixed'
            ],
            'photo' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $service = Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'rate' => $request->rate,
            'rate_type' => $request->rate_type,
            'photo' => $request->photo,
            'user_id' => auth('api')->id(),
        ]);

        $service->load('user');

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $service,
        ], 201);
    }

    public function show(Service $service): JsonResponse
    {
        $service->load('user');

        return response()->json([
            'service' => $service,
        ], 200);
    }

    public function favourite(Service $service): JsonResponse
    {
        $user = auth('api')->user();

        $alreadyFavourited = Favourite::where('user_id', $user->id)
            ->where('service_id', $service->id)
            ->exists();

        if ($alreadyFavourited) {
            return response()->json([
                'message' => 'Service already in favourites',
            ], 409);
        }

        Favourite::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
        ]);

        return response()->json([
            'message' => 'Service added to favourites',
        ], 201);
    }

    public function search(Request $request): JsonResponse
    {
        $query = Service::with('user');

        if ($request->filled('query')) {
            $search = $request->query('query');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'ILIKE', "%{$search}%")
                  ->orWhere('category', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->query('category'));
        }

        $services = $query->latest()->get();

        return response()->json([
            'services' => $services,
        ], 200);
    }
}