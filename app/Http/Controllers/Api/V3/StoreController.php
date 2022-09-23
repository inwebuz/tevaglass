<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Store::class, 'store');
    }

    public function index(Request $request)
    {
        $quantity = (int)$request->input('quantity', 30);
        if ($quantity > 120 || $quantity < 1) {
            $quantity = 30;
        }

        $locale = app()->getLocale();
        $stores = Store::active()->withTranslation($locale)->orderBy('order')->paginate($quantity)->appends($request->all());
        return StoreResource::collection($stores);
    }

    public function show(Request $request, Store $store)
    {
        // $locale = app()->getLocale();
        $store->load('translations');
        return new StoreResource($store);
    }

    public function bulkUpdate(Request $request)
    {
        $this->authorize('create', Store::class);

        $result = [];
        $data = $request->validate([
            'data' => 'required|array',
        ]);
        $allowedFields = ['name', 'description', 'body', 'status', 'order', 'phone_number', 'email', 'address', 'landmark', 'work_hours', 'latitude', 'longitude', 'map_code'];
        foreach ($data['data'] as $value) {
            $rowResult = [
                'success' => false,
                'message' => '',
            ];
            $id = $value['id'] ?? '';
            $store = null;
            if ($id) {
                $store = Store::find($id);
            }
            if (!$store) {
                $rowResult['message'] = __('main.store_not_found');
            }
            $updateData = array_filter($value, function($key) use ($allowedFields) {
                return in_array($key, $allowedFields);
            }, ARRAY_FILTER_USE_KEY);

            // check update data
            if (isset($updateData['name'])) {
                $updateData['name'] = Str::limit($updateData['name'], 191, '');
                $updateData['slug'] = Str::slug($updateData['name']);
            }
            if (isset($updateData['description'])) {
                $updateData['description'] = Str::limit($updateData['description'], 50000, '');
            }
            if (isset($updateData['body'])) {
                $updateData['body'] = Str::limit($updateData['body'], 500000, '');
            }
            if (isset($updateData['status']) && !in_array($updateData['status'], [Store::STATUS_ACTIVE, Store::STATUS_INACTIVE])) {
                $updateData['status'] = Store::STATUS_INACTIVE;
            }
            if (isset($updateData['order'])) {
                $updateData['order'] = intval($updateData['order']);
            }
            if (isset($updateData['phone_number'])) {
                $updateData['phone_number'] = Str::limit($updateData['phone_number'], 191, '');
            }
            if (isset($updateData['email'])) {
                $updateData['email'] = Str::limit($updateData['email'], 191, '');
            }
            if (isset($updateData['address'])) {
                $updateData['address'] = Str::limit($updateData['address'], 50000, '');
            }
            if (isset($updateData['landmark'])) {
                $updateData['landmark'] = Str::limit($updateData['landmark'], 50000, '');
            }
            if (isset($updateData['work_hours'])) {
                $updateData['work_hours'] = Str::limit($updateData['work_hours'], 50000, '');
            }
            if (isset($updateData['latitude'])) {
                $updateData['latitude'] = floatval($updateData['latitude']);
            }
            if (isset($updateData['longitude'])) {
                $updateData['longitude'] = floatval($updateData['longitude']);
            }
            if (isset($updateData['map_code'])) {
                $updateData['map_code'] = Str::limit($updateData['map_code'], 50000, '');
            }

            // update
            $store->update($updateData);
            $rowResult['success'] = true;
            $rowResult['message'] = 'OK';
            $result[] = $rowResult;
        }
        return response()->json([
            'data' => $result,
        ]);
    }

    public function destroy(Request $request, Store $store)
    {
        # code...
    }
}
