@extends('dashboard.layout')
@section('title', 'Product Index')
@section('main')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card-custom-1">
                    <div class="table-responsive">
                        <table class="table">
                            <caption>
                                List of products |
                                <a href="{{route('dashboard.product.create')}}" class="btn btn-sm btn-success d-inline-block ml-2">
                                    Create
                                    <i class="fa fa-plus"></i>
                                </a>
                            </caption>
                            <thead>
                            <tr class="text-center">
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Price</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr class="text-center">
                                    <th scope="row">{{$loop->iteration}}</th>
                                    <td>{{$product->title}}</td>
                                    <td>{{number_format($product->price)}}</td>
                                    <td>
                                        <img style="max-height: 150px;max-width: 150px;" class="img-thumbnail"
                                             src="{{ asset($product->image_url) }}" alt="Product Image">
                                    </td>
                                    <td>
                                        <a class="btn btn-warning" href="{{route('dashboard.product.edit',['product' => $product->id])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form class="d-inline-block ml-2"
                                            action="{{route('dashboard.product.destroy',['product' => $product->id])}}"
                                            method="post">
                                            @csrf
                                            @method('destroy')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-center mt-2">
                        <div class="col-auto">
                            {{$products->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
