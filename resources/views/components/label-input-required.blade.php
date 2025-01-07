@props(['value'])

<span>{{ $value ?? $slot }} <span class="text-error">*</span></span>
