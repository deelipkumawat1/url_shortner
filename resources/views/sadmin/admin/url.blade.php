@extends('sadmin.layouts.app_sadmin')

@push('sadmin.title', 'All Short Urls')

@push('sadmin.customCss')

@endpush

@section('sadmin.content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Short Urls</h1>
                </div>
                {{-- <div class="col-sm-6 text-right">
                    <a href="{{ route('member-url.index') }}" class="btn btn-primary">Back</a>
                </div> --}}
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

        <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div id="message"></div>
            <div class="container-fluid">
                {{-- @include('alert') --}}

                {{-- Fatch Shippings --}}
                <div class="card">

                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <form id="searchForm" method="GET" action="#">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="date_filter" class="form-control">
                                                    <option value="">-- Date Range --</option>
                                                    <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Last Month</option>
                                                    <option value="last_week" {{ request('date_filter') == 'last_week' ? 'selected' : '' }}>Last Week</option>
                                                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>today</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                            <a href="{{ route('shortUrls.index') }}" class="btn btn-secondary ml-2">
                                                <i class="fas fa-sync-alt"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                                <a href="{{ route('sadmin-admin.download', request()->all()) }}" class="btn btn-success ml-2 mb-3">Download</a>

                            </div>

                        </div>
                        <div class="col-12">
                            <div class="table-responsive">

                                <table class="table table-hover text-nowrap" id="mainTable">
                                    <tr>
                                        <th>#</th>
                                        <th>Short Url</th>
                                        <th>Long Url</th>
                                        <th>Hits</th>
                                        <th>Created By</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Created On</th>
                                    </tr>

                                    @php
                                        $i = ($urls->currentpage() - 1) * $urls->perpage() + 1
                                    @endphp

                                    @if ($urls->isNotEmpty())
                                        @foreach ($urls as $url)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                @php
                                                    $shortUrl = request()->getSchemeAndHttpHost() .'/s/'. $url->s_url_code;
                                                @endphp
                                                <td>
                                                    <a href="{{ route('member-url.redirect', $url->s_url_code) }}" target="_blank">{{ $shortUrl }}</a> <a href="javascript:void(0);" onclick="copyShortUrl('{{ $shortUrl }}')" class="text-warning ms-2">copy link</a>
                                                </td>
                                                <td>{{ $url->long_url }}</td>
                                                <td>{{ $url->hits }}</td>
                                                @if ($url->member)
                                                    <td>{{ $url->member->name .' ('.$url->member->role . ')' ?? 'N/A' }}</td>
                                                @else
                                                    <td>{{ $url->admin->name .' ('.$url->admin->role .')' ?? 'N/A' }}</td>
                                                @endif




                                                {{-- <td>
                                                    @if($url->status)
                                                        <button class="btn btn-success btn-sm toggle-status"
                                                            data-id="{{ Crypt::encrypt($url->id) }}">Active</button>
                                                    @else
                                                        <button class="btn btn-danger btn-sm toggle-status"
                                                            data-id="{{ Crypt::encrypt($url->id) }}">Block</button>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    {{ \Carbon\Carbon::parse($url->created_at)->setTimezone('Asia/Kolkata')->format('d-m-Y') }}
                                                </td>
                                                {{-- <td>
                                                    <a href="{{ route('category.edit', Crypt::encrypt($cat->id)) }}"
                                                        class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="javascript:void(0);" onclick="deleteCategory('{{ Crypt::encrypt($cat->id) }}')"
                                                        class="btn btn-danger btn-sm">Delete</a>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No Short urls found</td>
                                        </tr>
                                    @endif
                                </table>
                                {{ $urls->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
@endsection

@push('admin.customJs')
    <script>
        function copyShortUrl(url) {
            navigator.clipboard.writeText(url).then(function() {
                alert('Link Copied: ', + url);
            }).catch(function() {
                alert('Failed to copy');
            });
        }
        $(document).ready(function() {
            $('#shortUrlForm').submit(function(e) {
                e.preventDefault();

                let $submitBtn = $("#submitBtn");

                $submitBtn.prop('disabled', true);

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('admin-url.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $submitBtn.prop('disabled', false);

                        if(response.status == true) {
                            // setTimeout(function() {
                                window.location.href = response.redirect;
                            // }, 1000);
                        }
                        else {
                            let errors = response.errors;
                            $('.errors').removeClass('invalid-feedback').html("");
                            $("input[type='text'], input[type='file'], select").removeClass('is-invalid');

                            if(errors) {
                                $.each(errors, function(key, value) {
                                    $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value[0]);
                                });
                            }

                        }

                    },
                    error: function (xhr, status, error) {
                        $submitBtn.prop('disabled', false);

                        console.error("AJAX Error:", status, error);
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                let $field = $(`#${key}`);
                                $field.addClass('is-invalid');
                                $field.siblings('p.errors').addClass('invalid-feedback')
                                    .html(value[0]);
                            });
                        } else {
                            alert(
                                "Server error. Please contact the administrator or try again later."
                            );
                        }
                    }

                });
            });
        });

        $('.toggle-status').click(function () {
            let urlId = $(this).data('id');
            let button = $(this);

            $.ajax({
                url: "/admin/short-url/status/" + urlId,
                type: 'put',
                success: function (response) {
                    if (response.status == true) {
                        button.toggleClass('btn-success btn-danger');
                        button.text(button.text() === 'Active' ? 'Block' : 'Active');

                    }
                    else {
                        window.location.href = "{{ route('admin-url.create') }}";
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);

                }
            });
        });
    </script>
@endpush

