@extends('layouts.app')

@section("title", "Home")

@section('content')
    @include("includes.hero-slider")

    @include("includes.banner-area-1")

    <!-- Product Area Start -->
    <div class="product-area section-pb section-pt-30">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h4>Available Products</h4>
                    </div>
                </div>
            </div>

            <div class="row product-active-lg-4">
                @foreach($products as $product)
                    <div class="col-lg-12">
                        <!-- single-product-area start -->
                        <div class="single-product-area mt-30">
                            <div class="product-thumb">
                                @php
                                    if(file_exists('admin/images/products/'.$product->productPictures()->first()->picture))
                                        $picturePath = asset('admin/images/products/'.$product->productPictures()->first()->picture);
                                    else
                                        $picturePath = asset('admin/images/default-watch-picture.gif');
                                @endphp
                                <a href="{{ route('shop.product.detail', [$product->id]) }}">
                                    <img class="primary-images"
                                         src="{{ $picturePath }}"
                                         alt="">
                                </a>
                                @auth
                                    @php
                                        $count = auth()->user()->wishLists()->whereProductId($product->id)->count();
                                    @endphp
                                    <a class="wishlist-icon" href="javascript:void(0)" data-is-added="0"
                                       data-product-id="{{ $product->id }}">
                                            <span class="product-item-icon-heart">
                                            <i class="fa @if($count) fa-heart @else fa-heart-o @endif"
                                               aria-hidden="true"></i>
                                        </span>
                                    </a>
                                @else
                                    <a href="javascript:void(0)" onclick="showLoginDialog()">
                                            <span class="product-item-icon-heart">
                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                @endauth


                                <div class="label-product label_new">New</div>
                            </div>
                            <div class="product-caption text-left pl-2">
                                <h4 class="product-name"><a

                                        href="{{ route('shop.product.detail', [$product->id]) }}">{{str_limit($product->name, 30)}}</a>
                                </h4>
                                <div class="price-box">
                                    @if($product->status->id==3)
                                        <span class="bg-success indicator" title="Available now"></span>
                                    @elseif($product->status->id==4)
                                        <span class="bg-warning indicator" title="Not Available"></span>
                                    @elseif($product->status->id==9)
                                        <span class="bg-danger indicator" title="Canceled"></span>
                                    @endif
                                    <span
                                        class="new-price text-float-left ">{{ $product->currency->symbol }}{{ $product->price }}</span>
                                </div>
                                <div class="text-muted text-xs" style="font-size: 10px;">
                                    @if(intval($product->shipping_cost) == 0)
                                        Free Shipping
                                    @else
                                        Shipping Cost: ${{ $product->shipping_cost }}
                                    @endif
                                </div>
                                
                                
                                @php
                                    $count = $product->productRatings()->count();
                                    $avgRating = round($product->productRatings()->avg('rating'), 1);
                                    $total = 5;
                                    $diff = $total - $avgRating;
                                    $difff = fmod($avgRating,1);
                                @endphp
                                <div class="text-nowrap">
                                    @for($i=1; $i <= $total; $i++)
                                        @if($i <= $avgRating)
                                            <span class="product-rating"><i class="fa fa-star"
                                                                            aria-hidden="true"></i></span>
                                        @elseif($difff > 0 && $difff < 1)
                                            <span class="product-rating"><i class="fa fa-star-half-o"
                                                                            aria-hidden="true"></i></span>
                                            @php $difff = round($difff, 0) @endphp
                                        @else
                                            <span class="product-rating"><i class="fa fa-star-o"
                                                                            aria-hidden="true"></i></span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <!-- single-product-area end -->
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Product Area End -->
    @include("includes.banner-area-2")
    @include("includes.brands")
{{--    @include("includes.newsletter")--}}
@endsection
