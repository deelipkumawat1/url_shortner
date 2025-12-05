<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MemberShortUrlExport implements FromCollection, WithHeadings
{
    protected $request;
    protected $member;
    protected $member_id;
    protected $admin_id;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(Request $request) {
        $this->request = $request;
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


    public function collection()
    {
        $query = ShortUrl::query();
        $query->where(['is_delete' => false, 'admin_id' => $this->admin_id, 'member_id' => $this->member_id])->orderBy('id', 'DESC');

        $dateFilter = $this->request->input('date_filter');
        $query = applyDateFilter($query, $dateFilter, null, null, 'created_at');


        $shortUrls = $query->orderBy('created_at', 'ASC')->get();

        return $shortUrls->map(function($url) {
            $shortUrl = request()->getSchemeAndHttpHost() .'/'. $url->s_url_code;
            return [
                'Short Url' => $shortUrl,
                'Long Url' => $url->long_url,
                'Hits' => $url->hits,
                'Created On' => Carbon::parse($url->created_at)->setTimezone('Asia/kolkata')->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array {
        return [
            'Short Url',
            'Long Url',
            'Hits',
            'Created On',
        ];
    }
}
