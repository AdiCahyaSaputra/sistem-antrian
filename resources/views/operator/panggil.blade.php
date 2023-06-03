@extends('layout.main')

@section('content')
<div>

  @if(session('antrian-mentok'))
  <p>{{ session('antrian-mentok') }}</p>
  @endif

  <a href="/operator/antrian/jenjang/{{ $antrian->jenjang }}/belum" class="text-blue-600 hover:underline">Kembali Ke Menu Tadi</a>

  <h1 class="text-lg font-bold">Panggil Peserta</h1>
  <div class="my-2">
    <p>Nomor Antrian <b>{{ $antrian->nomor_antrian}}</b></p>
    <p>Jenjang <b>{{ $antrian->jenjang}}</b></p>
    <p>Tanggal Pendaftaran <b>{{ $antrian->tanggal_pendaftaran }}</b></p>
    <p>Status <b>{{ $antrian->terpanggil }}</b></p>
  </div>

  @if($antrian->terpanggil === 'sudah')
  <button class="disabled:text-black/60" type="button" id="panggil-btn" disabled>Panggil</button>
  @else
  <button type="button" id="panggil-btn" class="disabled:text-black/60 text-red-600 font-bold">Panggil</button>
  @endif

  <form action="/operator/antrian/lanjut/" method="post">
    @csrf
    <input type="hidden" name="antrian_id" value="{{$antrian->id }}" />
    <button type="submit" class="text-green-600 font-bold">Antrian Selanjutnya</button>
  </form>

  <form action="/operator/antrian/lewati/" method="post">
    @csrf
    <input type="hidden" name="antrian_id" value="{{$antrian->id }}" />
    <button type="submit" class="text-green-600 font-bold">Lewati Antrian</button>
  </form>

  <form action="/operator/antrian/terpanggil" method="post">
    @method('PUT')
    @csrf
    <input type="hidden" name="antrian_id" value="{{ $antrian->id }}" />
    <input type="hidden" name="antrian_jenjang" value="{{ $antrian->jenjang }}" />
    <button type="submit" onclick="return confirm('Yakin? gk bisa di un-panggil lho ini')" class="text-green-600 font-bold">Antrian Sudah Terpanggil</button>
  </form>

  <form action="/operator/antrian/lanjut/bendahara" method="post">
    @csrf
    <input type="hidden" name="antrian_id" value="{{ $antrian->id }}" />
    <input type="hidden" name="antrian_jenjang" value="{{ $antrian->jenjang }}" />
    <button type="submit" class="text-blue-600 font-bold">Lanjut Ke Bendahara</button>
  </form>

</div>

<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script>
  const panggilBtn = document.getElementById('panggil-btn')

  const antrian = {{ Js::from($antrian) }}

  const socket = io(`{{ env('SOCKET_IO_SERVER') }}`)

  panggilBtn.addEventListener('click', () => {
    socket.emit('play current antrian audio', antrian)
  })

  socket.emit('change antrian display', antrian)

  socket.on('change antrian display loading', (antrian) => {
    panggilBtn.setAttribute('disabled', 'true')
  })

  socket.on('change antrian display complete', (antrian) => {
    panggilBtn.removeAttribute('disabled')
  })
</script>
@endsection
