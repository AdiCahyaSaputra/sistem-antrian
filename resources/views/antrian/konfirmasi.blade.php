@extends('layout.main')

@section('content')
  <div class="karcis flex justify-center items-center h-screen">
    <div class="karcis-card border-b border-black py-4 px-10 flex flex-col items-center text-center" id="tytyd">
      <h1 class="text-xl font-bold">ANTREAN PPDB</h1>
      <p>Sekolah wijaya kusuma <br>
        Jl. Bandengan utara 80, <br> Penjaringan,
        Jakarta Utara, 14440</p>
      <div class="border-t-[5px] border-b-[5px] mt-2 border-black border-double border-spacing-10 w-full p-4">
        <h1 class="font-bold text-5xl">K0100</h1>
        <P class="text-3xl font-bold">LOKET <br> SD</P>
      </div>
      <p class="mt-2 text-xs">Sabtu, 20 juni 2023 / 10:30</p>
    </div>
  </div>

  <script>
    function printInfo() {
    var openWindow = window.open("", "title", "attributes");
    openWindow.document.write(document.getElementById('tytyd').innerHTML);
    openWindow.document.close();
    openWindow.focus();
    openWindow.print();
    openWindow.close();
}
// printInfo()
window.print();
  </script>
@endsection
