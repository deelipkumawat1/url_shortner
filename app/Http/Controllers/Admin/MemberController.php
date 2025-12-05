<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use App\Mail\MemberInvidationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    protected $admin;
    protected $member_id;
    protected $admin_id;
    protected $company_id;

    public function __construct() {
        $this->admin = Auth::guard('admin')->user();

        if($this->admin) {
            $this->admin_id = $this->admin->id;
            $this->company_id = $this->admin->company_id;
            // $this->member_id = $this->member->id;
        }
        else {
            // $this->member_id = null;
            $this->admin_id = null;
        }

    }
    public function index(Request $request) {

        // dd($this->company_id);
        $query = User::query();
        $query->where('company_id' , $this->company_id)
            ->withCount([
                    'shortUrlsByAdmin as admin_urls_count',
                    'shortUrlsByMember as member_urls_count',
                ])
            ->withSum('shortUrlsByAdmin as admin_hits_sum', 'hits')
            ->withSum('shortUrlsByMember as member_hits_sum', 'hits')
            // ->withSum(['shortUrlsByAdmin as admin_hits_sum' => 'hits',
            //     'shortUrlsByMember as member_hits_sum' => 'hits',
            // ])
        ->orderBy('id', 'DESC');

        $dateFilter = $request->input('date_filter');
        $query = applyDateFilter($query, $dateFilter, null, null, 'created_at');

        $users = $query->paginate(10)->appends($request->only('date_filter'));

        $data = [
            'users' => $users,
        ];

        // dd($data);
        return view('admin.member.member')->with($data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,member',
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
                'role' => $request->role,
                'password' => Hash::make($password),
                'admin_id' => $this->admin_id,
                'company_id' => $this->company_id,
            ]);

            $app_name = "Url Shortner";
            $login_url = route('login.index');

            Mail::to($request->email)->send(
                new MemberInvidationMail($request->name, $request->email, $password, $request->role, $app_name, $login_url)
            );

            return response()->json([
                'status' => true,
                'message' => 'Member added successfully!',
                'redirect' => route('admin-member.index'),
            ]);
        } catch (Exception $e) {
             return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                // 'redirect' => route('admin-member.index'),
            ]);
        }
    }

    public function memberUrl(Request $request, $id) {
        $id = Crypt::decrypt($id);

        $user = User::findOrFail($id);

        $query = ShortUrl::query();

        if($user->role == 'admin') {
            $query->where('admin_id', $user->id)->whereNull('member_id');
        }

        if($user->role == 'member') {
            $query->where('member_id', $user->id);
        }


        $query->with('member', 'admin')->orderBy('id', 'DESC');

        $dateFilter = $request->input('date_filter');
        $query = applyDateFilter($query, $dateFilter, null, null, 'created_at');



        $urls = $query->paginate(10)->appends($request->only('date_filter'));

        $data = [
            'urls' => $urls,
            'user' => $user,
        ];

        // dd($data);

        return view('admin.url.member_urls')->with($data);
    }
}
