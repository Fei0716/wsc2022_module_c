@extends("layout.main")

@section("style")

@endsection
@section("content")
    <section aria-label="Section Admins List" class="mt-5">
        <h1 class="mb-4 text-center">List of Admins</h1>

        <table class="table table-dark table-borderless table-striped table-responsive-md table-hover" >

            <tr>
                <th></th>
                <th>Username</th>
                <th>Created Timestamp</th>
                <th>Last Login Timestamp</th>
            </tr>

            @foreach($admins as $key => $a)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$a->username}}</td>
                    <td>{{$a->created_at}}</td>
                    <td>{{$a->last_login ?: "None"}}</td>
                </tr>
            @endforeach
        </table>
    </section>

@endsection
