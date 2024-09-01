@extends("layout.main")

@section("style")
    <style>
        .hide{
            display: none;
        }
    </style>
@endsection
@section("content")
    <section aria-label="Section Game Detail" class="mt-5">
        <h1 class="mb-4 text-center">{{$game->title}}'s Scores</h1>

        <form action="{{route("scores.reset", $game)}}" method="post" class="mb-2">
            @csrf
            @method("DELETE")
            <button class="btn btn-danger" type="submit">Reset Scores</button>
        </form>
        @foreach($game->gameVersions as $v)
            <h2 class="mb-3">{{$v->version_name}}</h2>
            <table class="table table-dark table-borderless table-striped table-responsive-md table-hover">
                <tr>
                    <th></th>
                    <th>Username</th>
                    <th>Score</th>
                    <th></th>
                    <th></th>
                </tr>

                @foreach($v->scores()->get()->where("deleted_at", null)->sortByDesc("score")->values()  as $key => $s)
                    <tr>
                        <th>{{$key + 1}}</th>
                        <th>{{$s->user->username}}</th>
                        <th>{{$s->score}}</th>
                        <th>
                            <form action="{{route("scores.destroy", $s)}}" method="post">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger" type="submit">Delete This Score</button>
                            </form>
                        </th>

                        <th>
                            <form action="{{route("scores.deletePlayerScores", $s->user)}}" method="post">
                                @csrf
                                @method("DELETE")
                                <button class="btn btn-danger" type="submit">Delete Player's Scores</button>
                            </form>
                        </th>
                    </tr>
                @endforeach
            </table>
        @endforeach
    </section>

@endsection


