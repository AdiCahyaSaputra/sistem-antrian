@extends('layout.main')

@section('content')
<div>
  @if(session('update-error'))
  <p>{{ session('update-error') }}</p>
  @endif

  @if(session('update-success'))
  <p>{{ session('update-success') }}</p>
  @endif

  @if(session('create-success'))
  <p>{{ session('create-success') }}</p>
  @endif

  @if(session('create-error'))
  <p>{{ session('create-error') }}</p>
  @endif

  <h1>Pilih Jenjang</h1>
  <ul>

    @foreach($jenjang as $j)
    <li>
      <a href="/operator/antrian/jenjang/{{ $j }}/belum">{{ $j }}</a>
    </li>
    @endforeach

  </ul>
  <a href="/bendahara/antrian/belum">Antrian Bendahara</a>

</div>
@endsection
