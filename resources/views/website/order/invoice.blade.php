@extends('website.app')
@section('main')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            @if($cart->count > 0)
                <div class="col-lg-9">
                    <div class="card-custom-3">
                        <div class="table-responsive">
                            <table class="table align-middle cart-table">
                                <caption>فهرست محصولات سبد خرید</caption>
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Count</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cart->products as $key=>$item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <img style="max-height: 150px;max-width: 150px;" class="img-thumbnail"
                                                 src="{{ asset($item['product']->image_url) }}" alt="Product Image">
                                            <div class="title">{{$item['product']->title}}</div>
                                        </td>
                                        <td>
                                            <form action="{{route('updateCart', ['product'=>$item['product']->id])}}"
                                                  method="post">
                                                @csrf
                                                @method('PATCH')
                                                <div class="d-inline-block mg-1">
                                                    <input type="number" name="count" id="count" class="form-control"
                                                           value="{{$item['count']}}">
                                                </div>
                                                <div>
                                                    <button class="btn btn-warning">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td>{{number_format($item['product']->price)}} $</td>
                                        <td>{{number_format($item['product']->price * $item['count'])}} $</td>
                                        <td>
                                            <form
                                                action="{{route('removeFromCart', ['product'=>$item['product']->id])}}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="border p-3">
                        @if(!is_null($cart->address))
                        {{$cart->address}}
                        @else
                            هیچ آدرسی ثبت نکرده اید!
                        @endif
                    </div>
                    <div class="mt-3 card-custom-3 text-end">
                        <div class="col-auto">
                            {{number_format($cart->price)}} $
                        </div>
                    </div>
                    @if(!is_null($cart->address))
                        <form action="{{route('orderStore')}}" method="post">
                            @csrf
                            <button class="btn btn-success">Send ({{number_format($cart->price)}} $)</button>
                        </form>
                    @endif
                </div>
            @else
                <div class="col-auto" style="direction: rtl;">
                    <a class="btn btn-warning" href="{{route('home')}}">سبد خرید شما خالی است!</a>
                </div>
            @endif
        </div>
    </div>
@endsection
