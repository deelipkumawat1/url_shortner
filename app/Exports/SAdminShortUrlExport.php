<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SAdminShortUrlExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    protected $admin;
    protected $member_id;
    protected $admin_id;
    protected $company_id;

    public function __construct(Request $request) {
        $this->admin = Auth::guard('admin')->user();
        $this->request = $request;
        if($this->admin) {
            $this->admin_id = $this->admin->id;
            $this->company_id = $this->admin->company_id;
        }
        else {
            // $this->member_id = null;
            $this->admin_id = null;
        }

    }


    public function collection()
    {
        $query = ShortUrl::query();
        $query->orderBy('id', 'DESC');

        $dateFilter = $this->request->input('date_filter');
        $query = applyDateFilter($query, $dateFilter, null, null, 'created_at');


        $shortUrls = $query->orderBy('created_at', 'ASC')->get();

        return $shortUrls->map(function($url) {
            $shortUrl = request()->getSchemeAndHttpHost() .'/'. $url->s_url_code;
            return [
                'Short Url' => $shortUrl,
                'Long Url' => $url->long_url,
                'Hits' => $url->hits,
                'Created By' => $url->member->name ?? $this->admin->name,
                'Created On' => Carbon::parse($url->created_at)->setTimezone('Asia/kolkata')->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array {
        return [
            'Short Url',
            'Long Url',
            'Hits',
            'Created By',
            'Created On',
        ];
    }
}
