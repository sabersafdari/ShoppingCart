@extends('website.app')

@section('js')
    <script>
        $(document).ready(function () {
            $('.ajax-form').submit(function (e) {
                e.preventDefault()
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    dataType: 'JSON',
                    data: {ajax: true},
                    success: function (result) {
                        console.log(result)
                        $('#cart-qty').removeClass('d-none').html(result.count)
                    },
                    error: function (result) {
                        console.log(2)
                    }
                })
            })
        })
    </script>
@endsection
@section('main')
    <div class="container mt-5 mb-5">
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-4 mb-3">
                    <article class="card-custom-1">
                        <a href="{{route('product.show',['product' => $product->id])}}" class="img-container">
                            <img src="{{ asset($product->image_url) }}" class="item-icon"
                                 alt="Product Image">
                        </a>
                        <div class="content">
                            <h1 class="title">{{$product->title}}</h1>
                            <p class="lead">
                                {{$product->Lead}}
                            </p>
                            <footer class="footer">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-auto">
                                        <a href="{{route('product.show',['product' => $product->id])}}"
                                           class="price">
                                            {{number_format($product->price)}} $
                                        </a>
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
                                <div class="row justify-content-center mt-3 pt-3 border-top">
                                    <div class="col-auto">
                                        <form method="post" action="{{route('addToCart', ['product'=>$product->id])}}"
                                              class="ajax-form">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">
                                                Add to cart with AJAX
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </footer>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
@endsection
