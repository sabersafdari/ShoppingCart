@extends('website.app')

@section('main')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <article class="card-custom-2">
                    <div class="img-container">
                        <img src="{{ asset($product->image_url) }}" class="item-icon"
                             alt="Product Image">
                    </div>
                    <div class="content">
                        <h1 class="title">{{$product->title}}</h1>
                        <div class="footer">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-auto">
                                    <div class="price">{{number_format($product->price)}} $</div>
                                </div>
                                <div class="col-auto">
                                    <form method="post" action="{{route('addToCart', ['product'=>$product->id])}}">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            Add to cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            {{$product->body}}
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
@endsection
