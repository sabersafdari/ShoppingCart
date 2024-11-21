@extends('dashboard.layout')
@section('title', 'Product Edit')

@section('main')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card-custom-1">
                    <form action="{{route('dashboard.product.update',['product' => $product->id])}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Write title here..." value="{{old('title',$product->title)}}"
                                   aria-describedby="invalid-title">
                            <div id="invalid-title" class="invalid-feedback">
                                {{$errors->first('title')}}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" id="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   placeholder="Write price here..." value="{{old('price',$product->price)}}"
                                   aria-describedby="invalid-price">
                            <div id="invalid-price" class="invalid-feedback">
                                {{$errors->first('price')}}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="body" class="form-label">Body</label>
                            <textarea name="body" id="body"
                                      class="form-control @error('body') is-invalid @enderror"
                                      aria-describedby="invalid-body">{{old('body' ,$product->body)}}</textarea>
                            <div id="invalid-body" class="invalid-feedback">
                                {{$errors->first('body')}}
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="file" name="image" id="image"
                                   class="form-control @error('image') is-invalid @enderror"
                                   aria-describedby="invalid-image">
                            <div id="invalid-image" class="invalid-feedback">
                                {{$errors->first('image')}}
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
