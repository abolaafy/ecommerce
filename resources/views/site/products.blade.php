@extends('layouts.site')

@section('content')

    <nav data-depth="3" class="breadcrumb-bg">
        <div class="container no-index">
            <div class="breadcrumb">

                <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="{{route('home')}}">
                            <span itemprop="name">Home</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </li>
                    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="36-mini-speaker.html">
                            <span itemprop="name">{{$category }}</span>
                        </a>
                        <meta itemprop="position" content="3">
                    </li>
                </ol>

            </div>
        </div>
    </nav>
    <div class="container no-index">
        <div class="row">
            <div id="content-wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <section id="main">
                    <div class="block-category hidden-sm-down">
                        <h1 class="h1">{{$category }}</h1>
                    </div>
                    <section id="products" >
                        <div id="nav-top">

                            <div id="js-product-list-top" class="row products-selection">
                                <div class="col-md-6 col-xs-6">
                                    <div class="change-type">
                                        <span class="grid-type active" data-view-type="grid"><i
                                                class="fa fa-th-large"></i></span>
                                        <span class="list-type" data-view-type="list"><i class="fa fa-bars"></i></span>
                                    </div>
                                    <div class="hidden-sm-down total-products">
                                        <p>There are {{-- count($products)??'0' --}} products.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="d-flex sort-by-row justify-content-end">

                                        <span class="hidden-sm-down sort-by">Sort by:</span>
                                        <div class="products-sort-order dropdown">
                                            <a class="select-title" rel="nofollow" data-toggle="dropdown"
                                               aria-haspopup="true" aria-expanded="false">
                                                <span>Relevance</span>
                                                <i class="material-icons pull-xs-right">&#xE5C5;</i>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a rel="nofollow"
                                                   href="36-mini-speaker-27.html?home=home_3&amp;order=product.position.asc"
                                                   class="select-list current js-search-link">
                                                    Relevance
                                                </a>
                                                <a rel="nofollow"
                                                   href="36-mini-speaker-28.html?home=home_3&amp;order=product.name.asc"
                                                   class="select-list js-search-link">
                                                    Name, A to Z
                                                </a>
                                                <a rel="nofollow"
                                                   href="36-mini-speaker-29.html?home=home_3&amp;order=product.name.desc"
                                                   class="select-list js-search-link">
                                                    Name, Z to A
                                                </a>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>


                        <div id="categories-product">
                            <div id="js-product-list">
                                <div class="products product_list grid row" data-default-view="grid">
                                            @isset($products)

                                            @foreach ($products as $item)

                                            <div class="item  col-lg-4 col-md-6 col-xs-12 text-center no-padding">
                                                <div style="width: 300px;
                                                height: 400px;" class="product-miniature js-product-miniature item-one"
                                                     data-id-product="22" data-id-product-attribute="408" itemscope=""
                                                     itemtype="http://schema.org/Product">
                                                    <div class="thumbnail-container">
                                                        <a href="{{ route('product.details',$item->slug) }}"
                                                            class="thumbnail product-thumbnail two-image">
                                                             <img class="img-fluid image-cover"
                                                             <?php
                                                                    $img1 = $item->images[0]->img ?? 'null';
                                                                    $img2 = $item->images[1]->img ?? 'null';
                                                             ?>
                                                                  src="{{asset ('site/images/'. $img1) }}"
                                                                  alt=""
                                                                  data-full-size-image-url="{{ asset('site/images/'.$img1) }}"
                                                                  width="200" height="300">
                                                             <img class="img-fluid image-secondary"
                                                                  src="{{ asset('site/images/'.$img2)}}"
                                                                  alt=""
                                                                  data-full-size-image-url="{{ asset('site/images/'.$img2) }}"
                                                                  width="200" height="400">
                                                         </a>


                                                        <div class="product-flags new">New</div>
                                                    </div>
                                                    <div class="product-description">
                                                        <div class="product-groups">

                                                            <div class="category-title"><a
                                                                    href="">Audio</a>
                                                            </div>

                                                            <div class="group-reviews">
                                                                <div class="product-comments">
                                                                    <div class="star_content">
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="star"></div>
                                                                        <div class="starf"></div>
                                                                    </div>
                                                                    <span>0 comments</span>
                                                                </div>


                                                                <div class="info-stock ml-auto">
                                                                    <label class="control-label">Availability:</label>
                                                                    <i class="fa fa-check-square-o"
                                                                       aria-hiddjen="true"></i>
                                                                    {{ $item->in_stock  ?'instock':'outofstock' }}
                                                                </div>
                                                            </div>

                                                            <div class="product-title" itemprop="name"><a
                                                                    href="{{ route('product.details',$item-> slug) }}">{{ $item->name }}</a></div>

                                                            <div class="product-group-price">
                                                                <div class="product-price-and-shipping">
                                                                    <span itemprop="price"
                                                                          class="price">
                                                                          @if (is_null($item->discount_price ))
                                                                                   {{$item->price }}
                                                                         @else
                                                                          <?php

                                                                          echo   '  <small style="text-decoration: line-through; color: #a3a3a3;font-weight: 500;" class="old-price">  '.$item->price.'</small>  '.$item->discount_price;

                                                               ?>
                                                                          @endif
                                                                          جنيه
                                                                </div>
                                                            </div>

                                                            <div class="product-desc" itemprop="desciption">
                                                                {!! $item->short_description !!}
                                                            </div>
                                                        </div>
                                                        <div class="product-buttons d-flex justify-content-center"
                                                             itemprop="offers" itemscope=""
                                                             itemtype="http://schema.org/Offer">
                                                            <form
                                                                action=""
                                                                method="post" class="formAddToCart">
                                                                @csrf
                                                                <input type="hidden" name="id_product"
                                                                       value="{{-- $product->id --}}">
                                                                <a class="add-to-cart cart-addition" data-product-id="{{$item->id }}" data-product-slug="{{-- $product->slug --}}" href="#"
                                                                   data-button-action="add-to-cart"><i
                                                                        class="novicon-cart"></i><span>Add to cart</span></a>
                                                            </form>

                                                            <a  onclick="addWishlist({{$item->id}})" id="addToWishlist{{$item->id}}" class="addToWishlist  wishlistProd_22" style="cursor:pointer;"

                                                            >
                                                                <i class="fa fa-heart"></i>
                                                                <span>Add to Wishlist</span>
                                                        </a>

                                                            <a href="#" onclick="openItemDetail({{$item->id}});" class="quick-view hidden-sm-down"
                                                               data-product-id="{{$item->id}}">
                                                                <i class="fa fa-search"></i><span> Quick view</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @include('site/includes/alerts/product-details' ,$item)
                                            @endforeach
                                            @endisset


                            </div>

                        </div>


                        <div id="js-product-list-bottom">

                            <nav class="pagination row justify-content-around">
                                <div class="col col-xs-12 col-lg-6 col-md-12">

    <span class='showing'>
    Showing 1-4 of 4 item(s)
    </span>

                                </div>
                                <div class="col col-xs-12 col-lg-6 col-md-12">

                                    <ul class="page-list">
                                        <li class="current">
                                            <a rel="nofollow"
                                               href="36-mini-speaker-27.html?home=home_3&amp;order=product.position.asc"
                                               class="disabled js-search-link">
                                                1
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </section>
                </section>
            </div>
        </div>
    </div>

    @include('site.includes.alerts.not-logged')
    @include('site.includes.alerts.alert')   <!-- we can use only one with dynamic text -->
    @include('site.includes.alerts.alert2')
@stop

@section('scripts')

<script src="http://localhost/shop7/public/site/js/jquery-3.6.0.min.js"></script>
    <script>

         function openItemDetail (id)
        {
                document.getElementById('detailItem'+id).style.display='block';

        }

        function closeItemDetail (id)
        {
                document.getElementById('detailItem'+id).style.display='none';
        }
        function addWishlist (item_id)
        {
            @guest
            $(".not-loggedin-modal").show();
            @endguest
            @auth('site')
            $.ajax(
             {
                type: 'post',
                url: "{{Route('wishlist.store') }}",
                data: {
                         'item_id':item_id,
                         '_token':"{{ csrf_token() }}"
                       },

                success: function (data)
                {

                    if(data.sataus && data.wishlist )
                    {
                        console.log(data);
                        $(".alert-modal2").show();
                        $(".text-message").html('تمت إضافة المنتج إلى قائمة المفضلة بنجاح');

                        $(".count-Wishlists").html(1 + + $(".count-Wishlists").html()  );
                    }
                    else if (data.sataus && !data.wishlist )
                    {
                        $(".text-message").html('تمت إضافة هذا المنتج من قبل إلى قائمة المفضلة');

                        $(".alert-modal2").show();
                    }
                }
            });
            @endauth

        }
        $(".close-login-alert").click(function(){
            $(".not-loggedin-modal").hide();
        });
        $(".closeMessage").click(function(){
            $(".alert-modal2").hide();
        });

        $(".add-to-cart").click(function(el)
        {
            el.preventDefault();

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
              });
            $.ajax({
                type: 'post',
                url: "{{ route('cart.store')}}",
                data: {
                    'item_id': $(this).attr('data-product-id'),
                    //'_token': "{{ csrf_token() }}",

                },
                success: function (data)
                {
                   if (data.sataus)
                   {
                       if(data.cart)
                       {
                            $(".alert-modal2").show();
                            $(".text-message").html('تمت إضافة المنتج إلى قائمة المشتريات بنجاح');
                            $(".cart-items-count").html (1 + +  $(".cart-items-count").html ()  );

                       }
                       else
                       {

                            $(".text-message").html('تمت إضافة هذا المنتج من قبل إلى قائمة المشتريات');
                            $(".alert-modal2").show();
                       }
                   }
                }
            });
        });
        /*
        $(document).on('click', '.addToWishlist', function (e)
        {
            e.preventDefault();
            console.log("Go TO rafeh ====> ")
        });

/ *

        $(document).on('click', '.cart-addition', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'post',
                url: "{{-- Route('site.cart.add') --}}",
                data: {
                    'product_id': $(this).attr('data-product-id'),
                    'product_slug' : $(this).attr('data-product-slug'),
                },
                success: function (data) {

                }
            });
        });
*/

  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

@stop

