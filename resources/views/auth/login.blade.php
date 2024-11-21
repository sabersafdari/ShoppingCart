@extends('website.app')

@section('title','Login')
@section('main')
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-lg-5">
                <div class="card-custom-3">
                    <h1 class="title-custom-1 text-center mb-4 pb-4 border-bottom">Login</h1>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            ...
                        </div>
                    @endif
                    <form action="{{route('loginSubmit')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" value="{{old('email')}}" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   aria-describedby="invalid-email">
                            <div id="invalid-email" class="invalid-feedback">
                                {{$errors->first('email')}}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" value="{{old('password')}}" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   aria-describedby="invalid-password">
                            <div id="invalid-password" class="invalid-feedback">
                                {{$errors->first('password')}}
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
