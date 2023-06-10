@extends('layout.main')

@section('content')
<div class="p-8">

  @if(session('antrian-mentok'))
  <p>{{ session('antrian-mentok') }}</p>
  @endif

  <h1 class="text-lg font-bold">Panggil Peserta</h1>
  <div class="my-2">
    <p>Nomor Antrian <b>{{ $antrian->nomor_antrian}}</b></p>
    <p>Tanggal Pendaftaran <b>{{ $antrian->tanggal_pendaftaran }}</b></p>
    <p>Status <b>{{ $antrian->terpanggil }}</b></p>
  </div>

  @if($antrian->terpanggil === 'sudah')
  <button class="hidden" type="button" id="panggil-btn">Panggil</button>
  <form action="/seragam/antrian/lanjut/" class="hidden" method="post">
    @csrf
    <input type="hidden" name="antrian_id" value="{{$antrian->id }}" />
    <button type="submit" id="lanjut-btn" class="disabled:text-black/60 text-green-600 font-bold">Antrian Selanjutnya</button>
  </form>
  <form action="/seragam/antrian/lewati/" class="hidden" method="post">
    @csrf
    <input type="hidden" name="antrian_id" value="{{$antrian->id }}" />
    <button type="submit" id="lewati-btn" class="disabled:text-black/60 text-green-600 font-bold">Lewati Antrian</button>
  </form>

  <form action="/seragam/antrian/terpanggil" class="hidden" method="post">
    @method('PUT')
    @csrf
    <input type="hidden" name="antrian_id" value="{{ $antrian->id }}" />
    <button type="submit" id="terpanggil-btn" onclick="return confirm('Yakin? gk bisa di un-panggil lho ini')" class="disabled:text-black/60 text-green-600 font-bold">Antrian Sudah Terpanggil</button>
  </form>
  @else
  <button type="button" id="panggil-btn" class="disabled:text-black/60 text-red-600 font-bold">Panggil</button>
  <form action="/seragam/antrian/lanjut/" class="block" method="post">
    @csrf
    <input type="hidden" name="antrian_id" value="{{$antrian->id }}" />
    <button type="submit" id="lanjut-btn" class="disabled:text-black/60 text-green-600 font-bold">Antrian Selanjutnya</button>
  </form>
  <form action="/seragam/antrian/lewati/" class="block" method="post">
    @csrf
    <input type="hidden" name="antrian_id" value="{{$antrian->id }}" />
    <button type="submit" id="lewati-btn" class="disabled:text-black/60 text-green-600 font-bold">Lewati Antrian</button>
  </form>

  <form action="/seragam/antrian/terpanggil" class="block" method="post">
    @method('PUT')
    @csrf
    <input type="hidden" name="antrian_id" value="{{ $antrian->id }}" />
    <button type="submit" id="terpanggil-btn" onclick="return confirm('Yakin? gk bisa di un-panggil lho ini')" class="disabled:text-black/60 text-green-600 font-bold">Antrian Sudah Terpanggil</button>
  </form>
  @endif

  <a href="/seragam/antrian/belum" class="text-blue-600 hover:underline">Kembali Ke Menu Tadi</a>
</div>

<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script>
  const panggilBtn = document.getElementById('panggil-btn')
  const lanjutBtn = document.getElementById('lanjut-btn')
  const lewatiBtn = document.getElementById('lewati-btn')
  const terpanggilBtn = document.getElementById('terpanggil-btn')

  const antrian = {{ Js::from($antrian) }}

  const socket = io(`{{ env('SOCKET_IO_SERVER') }}`)

  panggilBtn.addEventListener('click', () => {
    socket.emit('play current antrian seragam audio', antrian)
  })

  lewatiBtn.addEventListener('click', () => {
    socket.emit('skip antrian', 'skip')
  })

  terpanggilBtn.addEventListener('click', () => {
    socket.emit('skip antrian', 'skip')
  })

  // socket.emit('change antrian seragam display', antrian)

  socket.on('change antrian seragam display loading', (antrian) => {
    panggilBtn.setAttribute('disabled', 'true')
    lanjutBtn.setAttribute('disabled', 'true')
    lewatiBtn.setAttribute('disabled', 'true')
    terpanggilBtn.setAttribute('disabled', 'true')
  })

  socket.on('change antrian seragam display complete', (antrian) => {
    panggilBtn.removeAttribute('disabled')
    lanjutBtn.removeAttribute('disabled')
    lewatiBtn.removeAttribute('disabled')
    terpanggilBtn.removeAttribute('disabled')
  })
</script>
@endsection