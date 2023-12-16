<?php

namespace App\Http\Controllers;

use App\Models\Village;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\District;

class GetLocationController extends Controller
{

    public function __invoke(Request $request): Collection
    {


        return  District::query()
        ->select('code', 'name')
        ->orderBy('name')
        ->when(
            $request->search,
            fn (Builder $query) => $query
                ->where('name', 'like', "%{$request->search}%")
        )
        ->when(
            $request->exists('selected'),
            fn (Builder $query) => $query->whereIn('code', $request->input('selected', [])),
            fn (Builder $query) => $query->limit(10)
        )
        ->get();
    }
    public function village(Request $request): Collection
    {

        return  Village::query()
            ->select('code', 'name')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('code', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get();



    }

}
