@extends('admin.layouts.default')

@section('content')

{!! Form::model($data, ['method' => 'POST', 'role' => 'form', 'class' => 'form', 'route' => ['adm.support.update', $data->id], 'files' => true]) !!}
<section class="section">
  <div class="section-header mb-0">
    <h1>{{$title}}</h1>
    <div class="section-header-button mr-2">
    </div>
  </div>

  <div class="section-options">
    <div class="text-right mb-2">
      
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header -warning">
            <h4>
              <i class="fas fa-info-circle lga"></i>
              Dados pessoais
            </h4>
          </div>
          <div class="card-body">
            <div class="row">
              @include('admin.support._form')

              <a href="{{ route('adm.support.show') }}" class="btn btn-danger btn-lg btn-icon mr-1" title="Voltar"><i class="fas fa-angle-left"></i> Voltar</a>
              <button type="submit" class="btn btn-icon icon-left btn-success btn-lg"><i class="fas fa-check"></i> Salvar</button>
            </div>
          </div>

        </div>
      </div>
  </div>
</section>
{!! Form::close() !!}

@endsection
