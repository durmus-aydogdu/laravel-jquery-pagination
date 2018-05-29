@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users</div>
                    <div class="card-body">
                        <table>
                            <th>Name</th>
                            <th>Email</th>
                            <tbody id="users"></tbody>
                        </table>
                        <div id="pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        var current_page = 1;

        $(document).ready(function (e) {
            showUsers();
        });

        function showUsers() {
            $.post('users', {
                '_token': $('meta[name=csrf-token]').attr('content'),
                _method : 'POST',
                page: current_page
            })
                .done(function(data) {
                    var total_page = data.last_page;
                    if (total_page > 1) {
                        $('#pagination').twbsPagination({
                            totalPages: total_page,
                            visiblePages: 7,
                            onPageClick: function (event, pageL) {
                                if (current_page != pageL) {
                                    current_page = pageL;
                                    showUsers();
                                }
                            }
                        });
                    }
                    var users = '';
                    $.each(data.data, function (key, value) {
                        users += '<tr>';
                        users += '<td>' +value.name+ '</td>';
                        users += '<td>' +value.email+ '</td>';
                        users += '</tr>';
                    });
                    $("#users").html(users);
                })

                .fail(function(data) {
                    if (data.responseJSON.message) {
                        window.alert(data.responseJSON.message);
                    }
                    else {
                        window.alert(data.responseJSON);
                    }
                });
        }
    </script>
@endsection