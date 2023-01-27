@extends('templates.layout')

@section('title')
<title>Import Barang | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Import Barang
@endsection

@section('breadcrumb')
@parent
Import Barang
@endsection

@push('styles')

@endpush


@section('contents')

<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
    
                <div class="box-header with-border mb-3">
                    {{-- <button onclick="addForm('{{ route('admin.barang.store') }}')" class="btn btn-primary mx-2 my-3"><i
                            class="fa fa-plus-circle"></i>
                        Tambah</button> --}}
                    {{-- <button type="button" class="btn btn-success mx-2 my-3" data-toggle="modal" data-target="#importBarang">
                        Import Merek
                    </button> --}}
                    <div class="text-center">
                        <button type="button" class="btn btn-success mx-2 my-3" data-toggle="modal" data-target="#importBarang">
                            Import Barang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@include('barang.formImport')
@endsection