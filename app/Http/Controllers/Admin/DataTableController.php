<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Villa;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DataTableController extends Controller
{
    public function dataVilla(Request $request)
    {
        $villas = Villa::orderBy('id', 'desc')->get();
        if($request->has('id')){
            $villas = Villa::whereUuid($request->id)->get();
        }
        return datatables()->of($villas)
            ->addColumn('action', function($villa){
                return '
                    <a href="'.route('villas.edit', $villa->uuid).'" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-sm" onclick="deleteData(\''.$villa->uuid.'\')">
                        <i class="fa fa-trash"></i>
                    </button>
                ';
            })
            ->editColumn('deskripsi', function($villa){
                // ignore html
                $deskripsi = strip_tags($villa->deskripsi);
                return str()->limit($deskripsi, 30);
            })
            ->editColumn('foto', function($villa){
                // edit foto to base64
                $path = asset('/uploads/images/villas/' . $villa->foto);
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                return '<img data-path="'.$path.'" class="foto-villa" src="'.$base64.'" width="100px">';
            })
            ->addColumn('foto_path', function($villa){
                return asset('/uploads/images/villas/' . $villa->foto);
            })
            ->editColumn('harga_sewa', function($villa){
                return 'Rp. '.number_format($villa->harga_sewa, 0, ',', '.');
            })
            ->rawColumns(['action', 'foto'])
            ->make(true);
    }

    public function dataBookingVilla()
    {
        $bookings = Booking::orderByDesc('id')->get();
        return datatables()->of($bookings)
        ->addColumn('nama_villa', function($booking){
            return Str::title($booking->villa->nama_villa);
        })
        ->editColumn('nama_pemesan', fn($booking) => Str::title($booking->nama_pemesan))
        ->editColumn('status_pembayaran', function($booking){
            $html = '';
            if($booking->status_pembayaran == 'belum bayar'){
                $html = '<span class="badge badge-danger">Belum dibayar</span>';
            } else {
                $html = '<span class="badge badge-success">Sudah dibayar</span>';
            }

            return $html;
        })
        ->editColumn('total_bayar', fn($booking) => 'Rp. '.number_format($booking->total_bayar, 0, ',', '.'))
        ->addColumn('action', function($booking){
            $path = route('villa.detail', $booking->villa->uuid);
            if(Auth::user()->role == 'admin'){
                $path = route('villas.index') . '?id=' . $booking->villa->uuid;
            }
            $html = '<a href="'.$path.'" title="Lihat villa" class="btn btn-info btn-sm">
                    <i class="fa fa-eye"></i>
                </a>
                <button class="btn btn-danger btn-sm" title="Batalkan" onclick="deleteData(\''.$booking->uuid.'\')">
                    <i class="fa fa-trash"></i>
                </button>';
            if(Auth::user()->role != 'admin' && $booking->status_pembayaran == 'belum bayar'){
                $midtrans = new CreateSnapTokenService($booking);
                $snaptoken = $midtrans->getSnapToken();
                $html .= '<button class="btn btn-primary btn-sm" title="Bayar sewa" onclick="bayarSewa(\''.$snaptoken.'\', \''.$booking->uuid.'\')">
                Bayar
            </button>';
            }

            return $html;
        })
        ->rawColumns(['action', 'status_pembayaran'])
        ->make(true);
    }
}
