<?php

namespace App\Http\Controllers\Member;

use Exception;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShortUrlController extends Controller
{
    protected $member;
    protected $member_id;
    protected $admin_id;

    public function __construct() {
        $this->member = Auth::guard('member')->user();

        if($this->member) {
            $this->member_id = $this->member->id;
            $this->admin_id = $this->member->admin_id;
        }
        else {
            $this->member_id = null;
            $this->admin_id = null;
        }

    }
    public function index() {
        return view('member.url.url_list');
    }

    public function create() {

        $urls = ShortUrl::where(['is_delete' => false, 'admin_id' => $this->admin_id, 'member_id' => $this->member_id])->orderBy('id', 'DESC')->paginate(10);

        $data = [
            'urls' => $urls
        ];
        return view('member.url.url')->with($data);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'long_url' => 'required|url',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $shortCode = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZYZ0123456789'), 0, 6);

            $shortUrl = ShortUrl::create([
                's_url_code' => $shortCode,
                'long_url' => $request->long_url,
                'member_id' => $this->member_id,
                'admin_id' => $this->admin_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Short url added successfully!',
                'redirect' => route('member-url.create'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function status($id) {
        try {
            $id = Crypt::decrypt($id);

            $shortUrl = shortUrl::where(['admin_id' => $this->admin_id, 'is_delete' => false])->findOrFail($id);
            $shortUrl->status = $shortUrl->status ? 0 : 1;
            $shortUrl->save();

            return response()->json([
                'status' => true,
                'message' => $shortUrl->status ? 'Short Url activated successfully.' : 'Short Url blocked successfully.',
            ]);

        }
        catch (Exception $e) {
            session()->flash('error', 'Short Url not found');
            return response()->json([
                'status' => false,
                'message' => 'Short Url not found!',
                'redirect' => route('member-url.create'),
            ]);
        }
        catch (ModelNotFoundException $e) {
            session()->flash('error', 'Short Url not found');
            return response()->json([
                'status' => false,
                'message' => 'Short Url not found!',
                'redirect' => route('member-url.create'),
            ]);
        }
        catch (DecryptException $e) {
            session()->flash('error', 'Short Url not found');
            return response()->json([
                'status' => false,
                'message' => 'Short Url not found!',
                'redirect' => route('member-url.create'),
            ]);
        }
    }

    public function redirect($shortUrl) {
        $recored = ShortUrl::where('s_url_code', $shortUrl)->first();

        if(!$recored->status) {
            return redirect()->back()->with('error', 'Url is blocked');
        }
        // dd($recored);
        $recored->increment('hits');

        return redirect()->away($recored->long_url);
    }

}
