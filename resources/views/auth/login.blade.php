@extends("layout.main")

@section("style")
    <style>
        #form-login{
            width: 400px;
            margin: 0 auto;
        }
    </style>
@endsection
@section("content")
    <section aria-label="Section Login Form" class="my-auto">

        <h1 class="text-center mb-4">Worldskills Games Admin Portal</h1>
        <form action="{{route("login")}}" class="card p-3 shadow-sm" id="form-login" method="post">
            @csrf
            <div class="mb-2">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control @error("username") is-invalid @enderror">
                @error("username")
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control @error("password") is-invalid @enderror">
                @error("password")
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>

            <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                <button type="submit"  class="btn btn-dark w-100">
                    Login
                </button>
                <button type="reset"  class="btn btn-outline-dark w-100">
                    Reset
                </button>
            </div>
        </form>
    </section>

@endsection
