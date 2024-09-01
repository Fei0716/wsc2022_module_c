@extends("layout.main")

@section("style")

@endsection
@section("content")
    <section aria-label="Section Users List" class="mt-5">
        <h1 class="mb-4 text-center">List of Users</h1>
        <table class="table table-dark table-borderless table-striped table-responsive-md table-hover">
            <tr>
                <th></th>
                <th>Username</th>
                <th>Registration Timestamp</th>
                <th>Last Login Timestamp</th>
                <th></th>
                <th></th>
            </tr>
            {{--            loop through each of the users--}}
            @foreach($users as $key => $u)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$u->username}}</td>
                    <td>{{$u->created_at}}</td>
                    <td>{{$u->last_login ?: "None"}}</td>
                    <td>
                        <a href="{{route("users.show", $u)}}" class="text-white">Visit Profile</a>
                    </td>
                    <td>
{{--                        if the user is blocked allow for unblock action--}}
                        @if($u->blocked_reason)
                            <form action="{{route('users.unblock' , $u)}}" method="post"  class="d-flex align-items-center gap-2 w-100">
                                @csrf
                                <div class="alert alert-danger my-auto flex-grow-1  badge">
                                    {{$u->blocked_reason}}
                                </div>
                                <button class="btn btn-success  h-auto d-block mt-auto flex-grow-1 " type="submit">Unblock</button>
                            </form>
                        @else
{{--                        if the user is not blocked allow for block action with a reason--}}
                            <form action="{{route('users.block' , $u)}}" method="post" class="d-flex gap-2">
                                @csrf
                                @method('DELETE')
                                <div>
                                    <label for="reason">Choose a reason:</label>
                                    <select name="reason" id="reason" class="form-select" required>
                                        <option value="spam">Spamming</option>
                                        <option value="cheat">Cheating</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <button class="btn btn-danger h-auto d-block mt-auto flex-grow-1 " type="submit">Block</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </section>

@endsection
