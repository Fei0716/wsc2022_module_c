@extends("layout.main")

@section("style")
    <style>
        .hide{
            display: none;
        }
    </style>
@endsection
@section("content")
    <section aria-label="Section Games List" class="mt-5">
        <h1 class="mb-4 text-center">List of Games</h1>

        <input type="search" name="filter" id="filter" placeholder="Search for games with their titles....." class="form-control mb-3 w-50 mx-auto">
        <table class="table table-dark table-borderless table-striped table-responsive-md table-hover" id="table-games">
            <tr>
                <th></th>
                <th>Title</th>
                <th>Description</th>
                <th>Thumbnail</th>
                <th>Author</th>
                <th>Version Timestamps</th>
                <th></th>
                <th></th>
            </tr>
            {{--            loop through each of the users--}}
            @foreach($games as $key => $g)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td class="title">{{$g->title}}</td>
                    <td>{{$g->description}}</td>
                    <td>
                        @if($g->thumbnail)
                            <img src="{{asset($g->thumbnail)}}" alt="Game Thumbnail">
                        @else
                            None
                        @endif
                    </td>
                    <td>{{$g->author->username}}</td>
                    <td>
                        <ul>
                            @foreach($g->gameVersions as $v)
                                <li>{{$v->version_name}} {{$v->created_at}}</li>

                            @endforeach
                        </ul>

                    </td>
                    <td>
                        <a href="{{route("games.show", $g)}}" class="text-white">Visit Game Page</a>
                    </td>
                    <td>
                        @if($g->deleted_at)
                            <div class="badge alert alert-danger">
                                Deleted
                            </div>
                        @else
                            <form action="{{route("games.destroy", $g)}}" method="post">
                                @csrf
                                @method("DELETE")

                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </section>

@endsection


@section("script")
    <script>
        const table = document.querySelector("#table-games");
        const filter = document.querySelector("#filter");

        filter.addEventListener("input", (e)=>{
            let value = e.target.value;
            console.log(value);
            document.querySelectorAll("tr:has(td)").forEach( (el)=>{
                //check whether it contains the search value
                if(!el.querySelector(".title").textContent.toLowerCase().includes(value)){
                    el.classList.add("hide");
                }else{
                    if(el.classList.contains("hide")){
                        el.classList.remove("hide");
                    }
                }
            });


        });

    </script>
@endsection
