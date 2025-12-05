@extends('sadmin.layouts.app_sadmin')

@push('sadmin.title', 'Invite Admin')

@push('sadmin.customCss')

@endpush

@section('sadmin.content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invite Admin</h1>
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
            <form id="adminInviteForm">
                <div class="card col-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Nikhi Kumar">
                                    <p class="errors"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email">email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="example@email.com">
                                    <p class="errors"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-2 pl-4">
                        <button class="btn btn-primary" id="submitBtn" type="submit">Send Invite</button>
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
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h2>Team Members</h2>

                        </div>
                        {{--
                        <div class="col-md-4">
                            <label class="mr-2">Show entries:</label>
                            <div class="btn-group" role="group">
                                <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 5])) }}"
                                    class="btn btn-sm {{ request('per_page') == 5 || (!request('per_page') && 5 == 10) ? 'btn-primary' : 'btn-outline-primary' }}">5</a>
                                <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 10])) }}"
                                    class="btn btn-sm {{ request('per_page') == 10 || (!request('per_page') && 10 == 10) ? 'btn-primary' : 'btn-outline-primary' }}">10</a>
                                <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 20])) }}"
                                    class="btn btn-sm {{ request('per_page') == 20 ? 'btn-primary' : 'btn-outline-primary' }}">20</a>
                                <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 50])) }}"
                                    class="btn btn-sm {{ request('per_page') == 50 ? 'btn-primary' : 'btn-outline-primary' }}">50</a>
                                <a href="{{ route('category.index', array_merge(request()->except('per_page', 'page'), ['per_page' => 100])) }}"
                                    class="btn btn-sm {{ request('per_page') == 100 ? 'btn-primary' : 'btn-outline-primary' }}">100</a>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-12">
                        <div class="table-responsive">

                            <table class="table table-hover text-nowrap" id="mainTable">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-center">Users</th>
                                    <th class="text-center">Total Generated Urls</th>
                                    <th class="text-center">Total Url Hits</th>
                                    {{-- <th>Created On</th> --}}
                                </tr>

                                @php
                                    $i = ($users->currentpage() - 1) * $users->perpage() + 1
                                @endphp

                                @if ($users->isNotEmpty())
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td><a href="{{ route('sadmin-admin.adminUrl', Crypt::encrypt($user->id)) }}">{{ $user->name }}</a></td>
                                            <td>{{ $user->email }}</td>
                                            <td class="text-center">{{ $user->users_by_company_count }}</td>
                                            <td class="text-center">{{ $user->short_url_by_company_count }}</td>
                                            <td class="text-center">{{ $user->totalhits ?? 0 }}</td>

                                            {{-- <td>
                                                <a href="{{ route('admin-url.redirect', $url->s_url_code) }}" target="_blank">{{
                                                    $shortUrl }}</a> <a href="javascript:void(0);"
                                                    onclick="copyShortUrl('{{ $shortUrl }}')" class="text-warning ms-2">copy
                                                    link</a>
                                            </td>
                                            <td>{{ $url->long_url }}</td>
                                            <td>{{ $url->hits }}</td>
                                            <td>{{ $url->member->name ?? 'N/A' }}</td>
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
                                                {{
                                                \Carbon\Carbon::parse($url->created_at)->setTimezone('Asia/Kolkata')->format('d-m-Y')
                                                }}
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No Short users found</td>
                                    </tr>
                                @endif
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@push('sadmin.customJs')
    <script>

        $(document).ready(function () {
            $('#adminInviteForm').submit(function (e) {
                e.preventDefault();

                let $submitBtn = $("#submitBtn");

                $submitBtn.prop('disabled', true);

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('sadmin-admin.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $submitBtn.prop('disabled', false);

                        if (response.status == true) {
                            // setTimeout(function() {
                            window.location.href = response.redirect;
                            // }, 1000);
                        }
                        else {
                            let errors = response.errors;
                            $('.errors').removeClass('invalid-feedback').html("");
                            $("input[type='text'], input[type='file'], select").removeClass('is-invalid');

                            if (errors) {
                                $.each(errors, function (key, value) {
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
