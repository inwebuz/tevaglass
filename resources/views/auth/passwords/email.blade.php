@extends('layouts.app')
@section('seo_title', __('main.reset_password'))

@section('content')

<main class="main">

    <section class="content-header">
        <div class="container">
            @include('partials.breadcrumbs')
        </div>
    </section>

    <div class="container py-4 py-lg-5">
        <h1>{{ __('main.reset_password') }}</h1>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="login_form_inner">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">{{ __('main.form.email') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('main.send_password_reset_link') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

@endsection
