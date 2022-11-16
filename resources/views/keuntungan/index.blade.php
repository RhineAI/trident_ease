@extends('templates.layout')

@section('title')
<title>Keuntungan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Keuntungan
@endsection

@section('breadcrumb')
@parent
Keuntungan
@endsection

@push('styles')

@endpush

@section('contents')
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
                <div class="box-body table-responsive ">
                    <h2 class="text-center mt-3 mb-4">Set Keuntungan</h2>
                    @if (auth()->user()->hak_akses == 'admin')
                        <form action="{{ route('admin.keuntungan.store') }}" method="POST">
                    @elseif (auth()->user()->hak_akses == 'owner')
                        <form action="{{ route('owner.keuntungan.store') }}" method="POST">
                    @endif
                        @csrf
                        <div class="form-group row">
                            <div class="form-group col-md-11" style="margin: auto;" >
                                <label for="keuntungan">Persen Keuntungan</label>
                                <div class='input-group-prepend input-primary'>
                                    <input type="number" min="1" max="100" class="form-control" id="keuntungan"
                                        placeholder="Jumlah keuntungan yang ingin anda ambil" name="keuntungan"  autocomplete="off"><span
                                        class='input-group-text'>%</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group col-md-11" style="margin: auto;" >
                                <label for="id_kategori">Target Kategori</label>
                                <select class="form-control" name="id_kategori" id="id_kategori">
                                    <option value="" disabled="disabled" selected="true">Choose Kategori</option>
                                    <option value="semua">Semua Kategori</option>
                                    @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="form-group col-md-11" style="margin: auto;" >
                                <label for="id_merek">Target Merek</label>
                                <select class="form-control" name="id_merek" id="id_merek">
                                    <option value="" disabled="disabled" selected="true">Choose Merek</option>
                                    <option value="semua">Semua Merek</option>
                                    @foreach ($merek as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 mb-4 mx-5 box-footer" style="float: right; background-color:white;">
                            <button type="submit" class="btn btn-outline-primary" id="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <div class="card-body">
 
</div> --}}
@endsection