@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>{{ __('Register') }}</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input id="name" type="text"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                                    value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                                    value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password"
                                    required>
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                @endif
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-3">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required>
                            </div>

                            {{-- Region --}}
                            <div class="mb-3">
                                <label for="region" class="form-label">{{ __('Region') }}</label>
                                <select id="region" name="region"
                                    class="form-select {{ $errors->has('region') ? 'is-invalid' : '' }}" required>
                                    <option value="">{{ __('Select Region') }}</option>
                                    @foreach (['Beirut', 'Mount Lebanon', 'North Lebanon', 'South Lebanon', 'Nabatieh', 'Bekaa', 'Baalbek-Hermel', 'Akkar'] as $region)
                                        <option value="{{ $region }}"
                                            {{ old('region') == $region ? 'selected' : '' }}>
                                            {{ $region }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('region'))
                                    <div class="invalid-feedback">{{ $errors->first('region') }}</div>
                                @endif
                            </div>

                            {{-- Address --}}
                            <div class="mb-3">
                                <label for="address" class="form-label">{{ __('Address') }}</label>
                                <input id="address" type="text"
                                    class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address"
                                    value="{{ old('address') }}" required>
                                @if ($errors->has('address'))
                                    <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                                @endif
                            </div>

                            {{-- Payment Method --}}
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">{{ __('Payment Method') }}</label>
                                <select id="payment_method" name="payment_method" class="form-select">
                                    <option value="visa_card" {{ old('payment_method') == 'visa_card' ? 'selected' : '' }}>
                                        Visa Card</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                                    </option>
                                    <option value="bnpl" {{ old('payment_method') == 'bnpl' ? 'selected' : '' }}>BNPL
                                    </option>
                                </select>
                            </div>

                            {{-- Profile Picture --}}
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">{{ __('Profile Picture') }}</label>
                                <input id="profile_picture" type="file"
                                    class="form-control {{ $errors->has('profile_picture') ? 'is-invalid' : '' }}"
                                    name="profile_picture" accept="image/*">
                                @if ($errors->has('profile_picture'))
                                    <div class="invalid-feedback">{{ $errors->first('profile_picture') }}</div>
                                @endif
                            </div>

                            {{-- Submit --}}
                            <div class="mb-0">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
