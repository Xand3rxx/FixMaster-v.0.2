@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<span><img src="https://www.fixmaster.com.ng/wp-content/uploads/2020/11/fix-master-logo-straight.png" width="100" alt="FixMaster Logo"></span><br>
{{-- {{ config('app.name') }} --}}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
{{ config('app.name') }} © {{ date('Y') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
