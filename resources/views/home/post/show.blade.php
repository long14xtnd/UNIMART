@extends('layouts.index')
@section('content')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Blog</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($list_posts as $post)
                        <li class="clearfix">
                            <a href="{{ route('posts.detail',$post->slug) }}" title="" class="thumb fl-left">
                                <img src="{{ url($post->post_thumb) }}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{ route('posts.detail',$post->slug) }}" title="" class="title">{{ $post->title }}</a>
                                <span class="create-date">{{ $post->created_at }}</span>
                                <p><strong>{{ $post->category->name }}</strong></p>
                                
                            </div>
                        </li>
                        @endforeach
                       
                        
                    </ul>
                </div>
            </div>
            {{$list_posts->links()}}
            {{-- <div class="section" id="paging-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">1</a>
                        </li>
                        <li>
                            <a href="" title="">2</a>
                        </li>
                        <li>
                            <a href="" title="">3</a>
                        </li>
                    </ul>
                </div>
            </div> --}}
        </div>
        <div class="sidebar fl-left">
            @include('home.inc.product_selling')
            @include('home.inc.banner')
        </div>
    </div>
</div>
@endsection
