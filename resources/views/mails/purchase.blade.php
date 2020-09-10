@component('mail::message')

Compra coletiva <b>{{$purchase->name}}</b> está pronta para envio!

Obrigado,<br>
{{ config('app.name') }}
@endcomponent