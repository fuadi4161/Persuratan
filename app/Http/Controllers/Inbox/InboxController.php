<?php

namespace App\Http\Controllers\Inbox;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\User;
use App\Surat;
use Session;

class InboxController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexmasuk()
    {
        $surat = Surat::all();
        // $surat = Surat::all()
        // ->join('profil_user',['profil_user.user_id' => 'surat.kepada'])
        // ->join('users',['surat.kepada'=>'users.id'])
        // ->join('surat_disposisi',['surat_disposisi.user_id' => 'surat.kepada'])
        // ->select('surat.*','profil_user.nama','users.email','surat.perihal')
        // ->get();

        // dd($surat);

        return view('inbox.index', compact('surat'));
    }

    public function indexkeluar()
    {
        $surat = Surat::all();
        // $surat = Surat::all()
        // ->join('profil_user',['profil_user.user_id' => 'surat.kepada'])
        // ->join('users',['surat.kepada'=>'users.id'])
        // ->join('surat_disposisi',['surat_disposisi.user_id' => 'surat.kepada'])
        // ->select('surat.*','profil_user.nama','users.email','surat.perihal')
        // ->get();

        // dd($surat);

        return view('inbox.keluar', compact('surat'));
    }

    public function create()
    {
        $user = DB::table('users')->get();

        return view ('inbox.form', compact('user'));
        
    }

    public function store (Request $request)
    {
        $request->validate([
            'file' => 'mimes:pdf,jpg,png,jpeg',
        ]);

        DB::table('surat')->insert([
            'title' => $request->judul,
            'dari' => Auth::user()->email,
            'kepada' => $request->kepada,
            'perihal' => $request->perihal,
            'dokumen' => $request->file->getClientOriginalName(),
            'jenis_surat' => 2,
            'author_id' => Auth::user()->id,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        $file = $request->file;
    	$tujuan_upload = 'file/dokumen';
        $file->move($tujuan_upload,$file->getClientOriginalName());
        
        if ($file) {
            Session::flash('success', 'Surat Terkirim');
        } else {
            Session::flash('error', 'Surat Gagal Terkirim');
        }

        return redirect ('tenant/suratmasuk');
    }

    public function show ($id)
    {
        $surat = Surat::where('surat.id', $id)
        ->leftJoin('profil_user',['profil_user.user_id' => 'surat.kepada'])
        ->leftjoin('users',['surat.kepada'=>'users.id'])
        ->select('surat.*','profil_user.nama','users.email')
        ->get();
        $user = User::where('email', $id )->get();

        //dd($surat, $user);
        // return response()->json($surat);
        return view ('inbox.detail', compact('surat', 'user'));

    }

    public function edit($id)
    {
        $surat = Surat::findOrFail($id);
        
        $user = DB::table('users')->get();
        // $surat = Surat::where('id', '!=', $id)->orderBy('name', 'asc')->get();

        $this->data['surat'] = $surat;
        $this->data['user'] = $user;
        return view('inbox.edit', $this->data);
    }

    public function update(Request $request, Surat $surat)
    {
        Surat::where('id', $surat->id)
        ->update ([
            'title' => $request->judul,
            'dari' => Auth::user()->email,
            'kepada' => $request->kepada,
            'perihal' => $request->perihal,
            'dokumen' => $request->file->getClientOriginalName(),
            'author_id' => Auth::user()->id,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        $file = $request->file;
    	$tujuan_upload = 'file/dokumen';
        $file->move($tujuan_upload,$file->getClientOriginalName());
        
        if ($file) {
            Session::flash('success', 'Surat Berhasil Dirubah');
        } else {
            Session::flash('error', 'Surat Gagal Dirubah');
        }

    	return redirect ('/tenant/suratmasuk');
    }

    public function destroy($id)
    {
        $surat  = Surat::findOrFail($id);

        if ($surat->delete()) {
            Session::flash('success', 'Surat berhasil dihapus');
        }

        return redirect('/tenant/suratmasuk');
    }
}