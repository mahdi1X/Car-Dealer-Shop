@php
    $admin_user = $admin_user ?? null;
@endphp

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $admin_user->name ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $admin_user->email ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Address</label>
    <input type="text" name="address" class="form-control" value="{{ old('address', $admin_user->address ?? '') }}">
</div>
<div class="mb-3">
    <label for="region">{{ __('Region') }}</label>
    <select id="region" name="region" class="form-select {{ $errors->has('region') ? 'is-invalid' : '' }}" required>
        <option value="">{{ __('Select Region') }}</option>
        @foreach (['Beirut', 'Mount Lebanon', 'North Lebanon', 'South Lebanon', 'Nabatieh', 'Bekaa', 'Baalbek-Hermel', 'Akkar'] as $region)
            <option value="{{ $region }}" {{ old('region') == $region || $admin_user->region == $region ? 'selected' : '' }}>
                {{ $region }}
            </option>
        @endforeach
    </select>
    @if ($errors->has('region'))
        <div class="invalid-feedback">{{ $errors->first('region') }}</div>
    @endif
</div>


<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>
