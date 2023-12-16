<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\{AparaturDesa, Category, Brand, Datakua, DataN6, Desa, Jabatan, Pekerjaan};
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\DB as FacadesDB;

class SelectDataController extends Controller
{

    public function __invoke(Request $request): Collection
    {
        $user = Brand::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get();

        return $user;
    }

    public function aparaturDesa(Request $request): Collection
    {
        return AparaturDesa::query()
            ->select('aparatur_desas.id', FacadesDB::raw("aparatur_desas.nama || ' - ' || jabatans.nama as nama_lengkap"))
            ->leftJoin('jabatans', 'aparatur_desas.jabatan_id', '=', 'jabatans.id')
            ->orderBy('aparatur_desas.nama')
            ->when(
                $request->desa_id,
                fn (Builder $query) => $query->where('aparatur_desas.desa_id', $request->desa_id)
            )
            ->when(
                $request->search,
                fn (Builder $query) => $query->where('aparatur_desas.nama', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('aparatur_desas.id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get();
    }


    public function jabatan(Request $request): Collection
    {

        return  Jabatan::query()
            ->select('id', 'nama')
            ->orderBy('nama')
            ->when(
                $request->tipe_jabatan,
                fn (Builder $query) => $query->where('tipe_jabatan', $request->tipe_jabatan)->orWhere('tipe_jabatan', 'Semua')
            )
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('nama', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )

            ->get();
    }

    public function datakua(Request $request): Collection
    {

        $data = Datakua::query()
            ->select('id', 'nama_kecamatan')
            ->orderBy('nama_kecamatan');

        if ($request->search) {
            $data->where('nama_kecamatan', 'like', "%{$request->search}%");
        }

        if ($request->exists('selected')) {
            $data->whereIn('id', $request->input('selected', []));
        } else {
            $data->limit(10);
        }

        $results = $data->get();


        $results->push(['id' => 'lainnya', 'nama_kecamatan' => 'Lainnya']);

        return $results;
    }

    public function datadesa(Request $request): Collection
    {

        return  Desa::query()
            ->select('id', 'nama_desa')
            ->orderBy('nama_desa')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('nama_desa', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get();
    }
    public function  pekerjaan(Request $request): Collection
    {

        return  pekerjaan::query()
            ->select('id', 'nama')
            ->orderBy('nama')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('nama', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get();
    }


    public function  n6(Request $request): Collection
    {

        return  DataN6::query()
            ->select('id', 'n6_nomor_surat_keluar')
            ->orderBy('n6_nomor_surat_keluar')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('n6_nomor_surat_keluar', 'like', "%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get();
    }
}
