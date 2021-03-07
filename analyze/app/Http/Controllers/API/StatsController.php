<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SelectStatsRequest;
use App\Http\Resources\StatResource;
use App\Stat;

class StatsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param $id
     * @return StatResource|\Illuminate\Http\JsonResponse
     */
    public function show(SelectStatsRequest $request, $id)
    {
        $search = $request->input('search');
        $sort = $request->input('sort') == 'min' ? 'asc' : 'desc';
        $perPage = (($request->input('per_page') >= 10 && $request->input('per_page') <= 100) ? $request->input('per_page') : config('settings.paginate'));

        $stat = Stat::selectRaw('`value`, SUM(`count`) as `count`')
            ->where([['website_id', '=', $id], ['name', '=', $request->input('name')]])
            ->when($search, function($query) use ($search) {
                return $query->searchValue($search);
            })
            ->whereBetween('date', [$request->input('from'), $request->input('to')])
            ->groupBy('value')
            ->orderBy('count', $sort)
            ->paginate($perPage)
            ->appends(['name' => $request->input('name'), 'search' => $search, 'sort' => $sort, 'per_page' => $perPage, 'from' => $request->input('from'), 'to' => $request->input('to')]);

        if ($stat) {
            return StatResource::make($stat);
        }

        return response()->json([
            'message' => 'Resource not found.',
            'status' => 404
        ], 404);
    }
}
