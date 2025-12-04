@extends('member.layouts.app_member')

@push('member.title', 'Generate Url')

@push('member.customCss')

@endpush

@section('member.content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Generate Url</h1>
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
        <div class="container-fluid">
            <form id="shortUrlForm">
                <div class="card col-6">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="long_url">Long<span class="text-danger">*</span></label>
                                    <input type="text" name="long_url" id="long_url" class="form-control"
                                        placeholder="https://url.com/example">
                                    <p class="errors"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pl-4">
                        <button class="btn btn-primary" id="submitBtn" type="submit">Generate</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

        <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div id="message"></div>
            <div class="container-fluid">
                {{-- @include('alert') --}}

                {{-- Fatch Shippings --}}
                <div class="card">

                    <div class="card-body">
                        {{-- <div class="row mb-3">
                            <div class="col-md-8">
                                <form id="searchForm" method="GET" action="#">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="text" name="search" class="form-control" placeholder="Search by title..." value="{{ request('search') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select name="status" class="form-control">
                                                    <option value="">-- Select Status --</option>
                                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Block</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i> Search
                                            </button>
                                            <a href="{{ route('category.index') }}" class="btn btn-secondary ml-2">
                                                <i class="fas fa-sync-alt"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <label class="mr-2">Show entries:</label>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 5])) }}" class="btn btn-sm {{ request('per_page') == 5 || (!request('per_page') && 5 == 10) ? 'btn-primary' : 'btn-outline-primary' }}">5</a>
                                    <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 10])) }}" class="btn btn-sm {{ request('per_page') == 10 || (!request('per_page') && 10 == 10) ? 'btn-primary' : 'btn-outline-primary' }}">10</a>
                                    <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 20])) }}" class="btn btn-sm {{ request('per_page') == 20 ? 'btn-primary' : 'btn-outline-primary' }}">20</a>
                                    <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 50])) }}" class="btn btn-sm {{ request('per_page') == 50 ? 'btn-primary' : 'btn-outline-primary' }}">50</a>
                                    <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 100])) }}" class="btn btn-sm {{ request('per_page') == 100 ? 'btn-primary' : 'btn-outline-primary' }}">100</a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-12">
                            <div class="table-responsive">

                                <table class="table table-hover text-nowrap" id="mainTable">
                                    <tr>
                                        <th>#</th>
                                        <th>Short Url</th>
                                        <th>Long Url</th>
                                        <th>Hits</th>
                                        <th>Status</th>
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
                                                    <a href="{{ route('member-url.redirect', $url->s_url_code) }}" target="_blank">{{ $shortUrl }}</a>
                                                </td>
                                                <td>{{ $url->long_url }}</td>
                                                <td>{{ $url->hits }}</td>
                                                <td>
                                                    @if($url->status)
                                                        <button class="btn btn-success btn-sm toggle-status"
                                                            data-id="{{ Crypt::encrypt($url->id) }}">Active</button>
                                                    @else
                                                        <button class="btn btn-danger btn-sm toggle-status"
                                                            data-id="{{ Crypt::encrypt($url->id) }}">Block</button>
                                                    @endif
                                                </td>
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
                                            <td colspan="5" class="text-center">No Category found</td>
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

@push('member.customJs')
    <script>
        $(document).ready(function() {
            $('#shortUrlForm').submit(function(e) {
                e.preventDefault();

                let $submitBtn = $("#submitBtn");

                $submitBtn.prop('disabled', true);

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('member-url.store') }}",
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
                url: "/member/short-url/status/" + urlId,
                type: 'put',
                success: function (response) {
                    if (response.status == true) {
                        button.toggleClass('btn-success btn-danger');
                        button.text(button.text() === 'Active' ? 'Block' : 'Active');

                    }
                    else {
                        window.location.href = "{{ route('member-url.create') }}";
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);

                }
            });
        });
    </script>
@endpush
