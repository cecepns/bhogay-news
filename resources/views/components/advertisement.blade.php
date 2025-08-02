@php
    $ad = App\Models\Ad::getActiveBySize($size);
@endphp

@if($ad && $ad->script)
    <div class="advertisement-container" data-size="{{ $size }}">
        {!! $ad->getScriptForDisplay() !!}
    </div>
@endif 