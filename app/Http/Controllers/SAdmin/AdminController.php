<?php

namespace App\Http\Controllers\SAdmin;

use Exception;
use App\Models\User;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use App\Mail\MemberInvidationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SAdminShortUrlExport;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(Request $request) {
        $query = User::query();
        $query->where('admin_id', null)->where('role', '!=', 's_admin')->where('role', 'admin')
            ->withCount(['shortUrlByCompany', 'usersByCompany'])
            ->withSum('shortUrlByCompany as totalhits', 'hits')
        ->orderBy('id', 'DESC');

        // $query->shortUrlByCompany()->count();
        //  $query->usersByCompany()->count();

        $dateFilter = $request->input('date_filter');
        $query = applyDateFilter($query, $dateFilter, null, null, 'created_at');

        $users = $query->paginate(10)->appends($request->only('date_filter'));

        // $users->map(function($userHit) {
        //     return [
        //         $userHit->shortUrlsByAdmin->hits
        //     ];
        // });

        $data = [
            'users' => $users,
            // 'totalUrls' => $totalUrls,
            // 'totalUsers' => $totalUsers,
        ];

        // dd($data);
        return view('sadmin.admin.admin')->with($data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        // dd($this->admin_id, $this->company_id);
        // die;

        try {
            $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ0123456789'), 0, 6);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'admin',
                'password' => Hash::make($password),

            ]);

            $user->update([
                'company_id' => $user->id,
            ]);

            $app_name = "Url Shortner";
            $login_url = route('login.index');

            Mail::to($request->email)->send(
                new MemberInvidationMail($request->name, $request->email, $password, $user->role, $app_name, $login_url)
            );

            return response()->json([
                'status' => true,
                'message' => 'Member added successfully!',
                'redirect' => route('sadmin-admin.index'),
            ]);
        } catch (Exception $e) {
             return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                // 'redirect' => route('admin-member.index'),
            ]);
        }
    }

    public function adminUrl(Request $request, $id) {
        $id = Crypt::decrypt($id);

        $adminId = User::findOrFail($id);

        $query = ShortUrl::query();
        $query->where('company_id', $adminId->company_id)->with('member')->orderBy('id', 'DESC');

        $dateFilter = $request->input('date_filter');
        $query = applyDateFilter($query, $dateFilter, null, null, 'created_at');



        $urls = $query->paginate(10)->appends($request->only('date_filter'));

        $data = [
            'urls' => $urls,
            'adminId' => $adminId
        ];

        return view('sadmin.admin.url_admin')->with($data);
    }

    public function shortUrls(Request $request) {
        $query = ShortUrl::query();
        $query->with('member', 'admin')->orderBy('id', 'DESC');

        $dateFilter = $request->input('date_filter');
        $query = applyDateFilter($query, $dateFilter, null, null, 'created_at');



        $urls = $query->paginate(10)->appends($request->only('date_filter'));

        $data = [
            'urls' => $urls
        ];

        // dd($data);

        return view('sadmin.admin.url')->with($data);
    }

    public function exportUrlReport(Request $request) {
        return Excel::download(new SAdminShortUrlExport($request), 'sadmin_short_urls.xlsx');
    }
}
