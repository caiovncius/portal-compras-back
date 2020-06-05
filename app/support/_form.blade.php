@if(!$pp)
@php 
  $file = isset($data) ? [] : ['required']; 
@endphp
<div class="col-sm-12 row">
  <h4>Localização</h4>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('lc_pc', 'Pc', ['class' => '']) !!} <br>
    @if(isset($data) && $data->lc_pc) <img src="{{url('storage/support/'.$data->lc_pc)}}" width="50px" height="30px" style="margin-bottom: 5px;"> @endif
    {!! Form::file('lc_pc', $file) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('lc_mobile', 'Mobile', ['class' => '']) !!} <br>
    @if(isset($data) && $data->lc_mobile) <img src="{{url('storage/support/'.$data->lc_mobile)}}" width="50px" height="30px" style="margin-bottom: 5px;"> @endif
    {!! Form::file('lc_mobile', $file) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('lc_url', 'Como chegar', ['class' => '']) !!}
    {!! Form::text('lc_url', old('lc_url'), ['class' => 'form-control required']) !!}
  </div>
</div>
<div class="col-sm-12 row">
  <h4>Downloads</h4>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    @php
      $name = isset($data) ? ' - '.$data->file1 : '';
    @endphp
    {!! Form::label('file1', 'Arquivo Book'.$name, ['class' => '']) !!}<br>
    {!! Form::file('file1', $file) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    @php
      $name = isset($data) ? ' - '.$data->file2 : '';
    @endphp
    {!! Form::label('file2', 'Arquivo Tabela'.$name, ['class' => '']) !!}<br>
    {!! Form::file('file2', $file) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('email', 'Email', ['class' => '']) !!}
    {!! Form::text('email', old('email'), ['class' => 'form-control required']) !!}
  </div>
</div>
<div class="col-sm-12 row">
  <h4>Compre Online</h4>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('co_txt', 'Subtítulo', ['class' => '']) !!}
    {!! Form::textarea('co_txt', old('co_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-2">
  <div class="form-group mb-2">
    {!! Form::label('co_bt_txt', 'Botão Texto', ['class' => '']) !!}
    {!! Form::text('co_bt_txt', old('co_bt_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-3">
  <div class="form-group mb-3">
    {!! Form::label('co_bt_url', 'Botão Url', ['class' => '']) !!}
    {!! Form::text('co_bt_url', old('co_bt_url'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-3">
  <div class="form-group mb-3">
    {!! Form::label('co_bt_ico', 'Botão Ícone', ['class' => '']) !!} <br>
    <a class="btn btn-primary" data-toggle="collapse" href="#icon_bt" aria-expanded="false">Selecionar</a>
    @if(isset($data) && $data->co_bt_ico) <i class="icon {{$data->co_bt_ico}}"></i> @endif
  </div>
</div>

<div class="col-12">
  <div class="collapse multi-collapse" id="icon_bt">
    @include('admin.partials._icons', ['name' => 'co_bt_ico', 'collapseId' => 'icon_bt'])
  </div>
</div>
<div class="col-sm-12 col-md-6">
  <div class="form-group mb-6">
    {!! Form::label('', 'Passo 1', ['class' => '']) !!}
    {!! Form::text('co_1_txt', old('co_1_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-6">
  <div class="form-group mb-6">
    {!! Form::label('&nbsp;') !!}<br>
    @if(isset($data) && $data->co_1_ico) <img src="{{url('storage/support/'.$data->co_1_ico)}}" width="50px" height="30px" style="margin-bottom: 5px;"> @endif
    {!! Form::file('co_1_ico', $file) !!}
  </div>
</div>

<div class="col-sm-12 col-md-6">
  <div class="form-group mb-6">
    {!! Form::label('', 'Passo 2', ['class' => '']) !!}
    {!! Form::text('co_2_txt', old('co_2_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-6">
  <div class="form-group mb-6">
    {!! Form::label('&nbsp;') !!}<br>
    @if(isset($data) && $data->co_2_ico) <img src="{{url('storage/support/'.$data->co_2_ico)}}" width="50px" height="30px" style="margin-bottom: 5px;"> @endif
    {!! Form::file('co_2_ico', $file) !!}
  </div>
</div>

<div class="col-sm-12 col-md-6">
  <div class="form-group mb-6">
    {!! Form::label('', 'Passo 3', ['class' => '']) !!}
    {!! Form::text('co_3_txt', old('co_3_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-6">
  <div class="form-group mb-6">
    {!! Form::label('&nbsp;') !!}<br>
    @if(isset($data) && $data->co_3_ico) <img src="{{url('storage/support/'.$data->co_3_ico)}}" width="50px" height="30px" style="margin-bottom: 5px;"> @endif
    {!! Form::file('co_3_ico', $file) !!}
  </div>
</div>

<div class="col-sm-12 row">
  <h4>Fale Conosco</h4>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_1_txt', 'Botão 1 Texto', ['class' => '']) !!}
    {!! Form::text('fc_1_txt', old('fc_1_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_1_url', 'Botão 1 Url', ['class' => '']) !!}
    {!! Form::text('fc_1_url', old('fc_1_url'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_1_ico', 'Botão 1 Ícone', ['class' => '']) !!} <br>
    <a class="btn btn-primary" data-toggle="collapse" href="#icon_1" aria-expanded="false">Selecionar</a>
    @if(isset($data) && $data->fc_1_ico) <i class="icon {{$data->fc_1_ico}}"></i> @endif
    {{-- {!! Form::radio('fc_1_ico','name', false) !!} --}}

  </div>
</div>

<div class="col-12">
  <div class="collapse multi-collapse" id="icon_1">
    @include('admin.partials._icons', ['name' => 'fc_1_ico', 'collapseId' => 'icon_1'])
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_2_txt', 'Botão 2 Texto', ['class' => '']) !!}
    {!! Form::text('fc_2_txt', old('fc_2_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_2_url', 'Botão 2 Url', ['class' => '']) !!}
    {!! Form::text('fc_2_url', old('fc_2_url'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_2_ico', 'Botão 2 Ícone', ['class' => '']) !!} <br>
    <a class="btn btn-primary" data-toggle="collapse" href="#icon_2" aria-expanded="false">Selecionar</a>
    @if(isset($data) && $data->fc_2_ico) <i class="icon {{$data->fc_2_ico}}"></i> @endif
    {{-- {!! Form::file('fc_2_ico', $file) !!} --}}
  </div>
</div>

<div class="col-12">
  <div class="collapse multi-collapse" id="icon_2">
    @include('admin.partials._icons', ['name' => 'fc_2_ico', 'collapseId' => 'icon_2'])
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_3_txt', 'Botão 3 Texto', ['class' => '']) !!}
    {!! Form::text('fc_3_txt', old('fc_3_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_3_url', 'Botão 3 Url', ['class' => '']) !!}
    {!! Form::text('fc_3_url', old('fc_3_url'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_3_ico', 'Botão 3 Ícone', ['class' => '']) !!} <br>
    <a class="btn btn-primary" data-toggle="collapse" href="#icon_3" aria-expanded="false">Selecionar</a>
    @if(isset($data) && $data->fc_3_ico) <i class="icon {{$data->fc_3_ico}}"></i> @endif
    {{-- {!! Form::file('fc_3_ico', $file) !!} --}}
  </div>
</div>

<div class="col-12">
  <div class="collapse multi-collapse" id="icon_3">
    @include('admin.partials._icons', ['name' => 'fc_3_ico', 'collapseId' => 'icon_3'])
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_4_txt', 'Botão 4 Texto', ['class' => '']) !!}
    {!! Form::text('fc_4_txt', old('fc_4_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_4_url', 'Botão 4 Url', ['class' => '']) !!}
    {!! Form::text('fc_4_url', old('fc_4_url'), ['class' => 'form-control required']) !!}
  </div>
</div>

<div class="col-sm-12 col-md-4">
  <div class="form-group mb-4">
    {!! Form::label('fc_4_ico', 'Botão 4 Ícone', ['class' => '']) !!} <br>
    <a class="btn btn-primary" data-toggle="collapse" href="#icon_4" aria-expanded="false">Selecionar</a>
    @if(isset($data) && $data->fc_4_ico) <i class="icon {{$data->fc_4_ico}}"></i> @endif
    {{-- {!! Form::file('fc_4_ico', $file) !!} --}}
  </div>
</div>

<div class="col-12">
  <div class="collapse multi-collapse" id="icon_4">
    @include('admin.partials._icons', ['name' => 'fc_4_ico', 'collapseId' => 'icon_4'])
  </div>
</div>

<div class="col-sm-12 col-md-12">
  <div class="form-group mb-12">
    {!! Form::label('tl_txt', 'Texto legal', ['class' => '']) !!}
    {!! Form::textarea('tl_txt', old('tl_txt'), ['class' => 'form-control required']) !!}
  </div>
</div>
@else
<div class="col-sm-12 col-md-12">
  <div class="form-group mb-12">
    {!! Form::textarea('pc_txt', old('pc_txt'), ['class' => 'form-control required', 'id' => 'pc']) !!}
  </div>
</div>
@endif

@include('admin.partials._ckeditor', ['id' => 'pc'])
