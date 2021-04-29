@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Pengelolaan Product</h1>
@stop

@section('content')
    <div class="container">
        <div class="row justifly-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Pengelolaan Product') }}</div>

                    <div class="card-body">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#tambahProductModal"><i class="fa fa-plus"></i>Tambah Data</button>
                        <hr/>
                        <table id="table-data" class="table table-borderer">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NAMA</th>
                                    <th>QTY</th>
                                    <th>MEREK</th>
                                    <th>KATEGORI</th>
                                    <th>PHOTO</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->qty }}</td>
                                        <td>{{ $product->brands->name }}</td>
                                        <td>{{ $product->categories->name }}</td>
                                        <td>
                                            @if ($product->photo !== null)
                                                <img src="{{ asset('storage/photo_product/'.$product->photo) }}" width="100px">
                                            @else
                                                [Gambar tidak tersedia]
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="basic example">
                                                <button type="button" id="btn-edit-product" class="btn btn-success" data-toggle="modal" data-target="#editProductModal" data-id="{{ $product->id }}">Edit</button>
                                                <button type="button" id="btn-delete-product" class="btn btn-danger" data-toggle="modal" data-target="#deleteProductModal" data-id="{{ $product->id }}">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tambah Data --}}
    <div class="modal fade" id="tambahProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('product.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">NAMA</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="qty">QTY</label>
                            <input type="number" class="form-control" name="qty" id="qty" required>
                        </div>
                        <div class="form-group">
                            <label for="brands_id">Merek</label>
                            <select id="brands_id" class="form-control" name="brands_id">
                                @foreach($brands as $brand)
                                <option  class="form-control" name="brands_id" value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categories_id">Kategori</label>
                            <select id="categories_id" class="form-control" name="categories_id">
                                @foreach($categories as $categorie)
                                <option name="categories_id" value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="photo">PHOTO</label>
                            <input type="file" class="form-control" name="photo" id="photo" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Data --}}
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('product.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-name">NAMA</label>
                                <input type="text" class="form-control" name="name" id="edit-name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-qty">QTY</label>
                                <input type="text" class="form-control" name="qty" id="edit-qty" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-brands_id">Merek</label>
                                <select id="edit-brands_id" class="form-control" name="brands_id">
                                    @foreach($brands as $brand)
                                    <option  class="form-control" name="brands_id" value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit-categories_id">Kategori</label>
                                <select id="edit-categories_id" class="form-control" name="categories_id">
                                    @foreach($categories as $categorie)
                                    <option name="categories_id" value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" id="image-area"></div>
                            <div class="form-group">
                                <label for="edit-photo">Photo</label>
                                <input type="file" class="form-control" name="photo" id="edit-cover">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="edit-id">
                    <input type="hidden" name="old_photo" id="edit-old-cover">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    {{-- delete data brand --}}
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus data tersebut?
                    <form action="{{ route('product.delete') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" id="delete-id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(function(){
            $(document).on('click', '#btn-edit-product', function(){
                let id = $(this).data('id');
                $('#image-area').empty();
                $.ajax({
                    type: "get",
                    url: baseurl+'/ajax/dataProduct/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-id').val(res.id);
                        $('#edit-name').val(res.name);
                        $('#edit-qty').val(res.qty);
                        $('#edit-brands_id').val(res.brands_id);
                        $('#edit-categories_id').val(res.categories_id);
                        $('#edit-old-photo').val(res.photo);
                        if (res.cover !== null){
                            $('#image-area').append(`<img src="${baseurl}/storage/photo_product/${res.photo}" width="200px"/>`);
                            //$('image-area').append("<img src='"+baseurl+"/storage/photo_product/"+res.photo+"' width='200px'>");
                        } else {
                            $('#image-area').append('[Gambar tidak Tersedia]');
                        }
                    }
                })
            })
        })
        $(document).on('click', '#btn-delete-product', function(){
            let id = $(this).data('id');

            $('#delete-id').val(id);
        });
    </script>
@stop