<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\tb_siswa;
use App\Models\tb_admin;
use App\Models\tb_dudi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class AuthenController extends Controller
{
    //Registration
    public function registrationSiswa()
    {
        return view('auth.registrationSiswa');
    }
    public function registerUserSiswa(Request $request)
    {
        // $request->validate([
        //     'name'=>'required',
        //     'email'=>'required|email:users',
        //     'password'=>'required|min:8|max:12'
        // ]);

        $siswa = new tb_siswa();
        $siswa->nis = $request->nis;
        $siswa->nama = $request->nama;
        $siswa->kelas = $request->kelas;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->angkatan = $request->angkatan;
        $siswa->jurusan = $request->jurusan;
        $siswa->save();
        

         $user = new User();
         $user->username = $siswa->nis;
         $user->password = $request->password;
         $user->role = 'siswa';
         $user->id_admin = null;
         $user->id_dudi =null;
         $user->id_siswa = $siswa->id;



        $result = $user->save();
        if($result){
            return back()->with('success','You have registered successfully.');
        } else {
            return back()->with('fail','Something wrong!');
        }
    }
    public function registrationDudi()
    {
        return view('auth.registrationDudi');
    }
    public function registerUserDudi(Request $request)
    {
        // $request->validate([
        //     'name'=>'required',
        //     'email'=>'required|email:users',
        //     'password'=>'required|min:8|max:12'
        // ]);

        $siswa = new tb_siswa();
        $siswa->nis = $request->nis;
        $siswa->nama = $request->nama;
        $siswa->kelas = $request->kelas;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->angkatan = $request->angkatan;
        $siswa->jurusan = $request->jurusan;
        $siswa->save();
        

         $user = new User();
         $user->username = $siswa->nis;
         $user->password = $request->password;
         $user->role = 'siswa';
         $user->id_admin = null;
         $user->id_dudi =null;
         $user->id_siswa = $siswa->id;



        $result = $user->save();
        if($result){
            return back()->with('success','You have registered successfully.');
        } else {
            return back()->with('fail','Something wrong!');
        }
    }
    public function registrationAdmin()
    {
        return view('auth.registrationAdmin');
    }
    public function registerUserAdmin(Request $request)
    {
        // $request->validate([
        //     'name'=>'required',
        //     'email'=>'required|email:users',
        //     'password'=>'required|min:8|max:12'
        // ]);

        $admin = new tb_admin();
        $admin->nama_admin = $request->nama_admin;
        $admin->no_telpon = $request->no_telpon;
        $admin->alamat = $request->alamat;
        
        $admin->save();
        

         $user = new User();
         $user->username = $admin->nama_admin;
         $user->password = $request->password;
         $user->role = 'admin';
         $user->id_admin = $admin->id;
         $user->id_dudi =null;
         $user->id_siswa = null;



        $result = $user->save();
        if($result){
            return back()->with('success','You have registered successfully.');
        } else {
            return back()->with('fail','Something wrong!');
        }
    }
    
    
    ////Login
    public function login()
    {
        return view('auth.login');
    }
    public function loginUser(Request $request)
    {
        $request->validate([            
            'username'=>'required',
            'password'=>'required|min:8|max:12'
        ]);

        $user = User::where('username','=',$request->username)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $request->session()->put('loginId', $user->id);
                return redirect('dashboard');
            } else {
                return back()->with('fail','Password not match!');
            }
        } else {
            return back()->with('fail','This email is not register.');
        }        
    }
    //// Dashboard
    public function dashboard()
    {
        // return "Welcome to your dashabord.";
        $data = array();
        if(Session::has('loginId')){
            $data = User::where('id','=',Session::get('loginId'))->first();
        }
        return view('dashboard',compact('data'));
    }
    ///Logout
    public function logout()
    {
        $data = array();
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect('login');
        }
    }
}
