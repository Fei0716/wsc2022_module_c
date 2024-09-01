<nav class="navbar navbar-expand-lg bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand text-white h2 my-auto" href="{{route("getAdminUsers")}}">Navbar scroll</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarScroll">
            <ul class="navbar-nav mx-auto my-2 my-lg-0 navbar-nav-scroll w-auto" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="{{route("getAdminUsers")}}">Admins</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="{{route("users.index")}}">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active text-white" aria-current="page" href="{{route("games.index")}}">Games</a>
                </li>

            </ul>
            <form class="d-flex align-items-center gap-2" action="{{route("logout")}}" method="post">
                @csrf
                <strong class="h6 text-white my-auto">{{Auth::user()->username}}</strong>
                <button class="btn btn-light" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>
