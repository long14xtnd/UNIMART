<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function lien_he(){
        $page = Page::where('name','LIKE','Liên hệ')->first();
        // dd($page);
        return view('home.page.lien_he',compact('page'));
    }

    public function huong_dan_mua_hang_online(){
        $page = Page::where('name','LIKE','Hướng dẫn mua hàng online')->first();
        // dd($page);
        return view('home.page.huong_dan_mua_hang_online',compact('page'));
    }

    public function fake_warning(){
        $page = Page::where('name','LIKE','Cảnh báo giả mạo')->first();
        // dd($page);
        return view('home.page.fake_warning',compact('page'));
    }

    public function quy_che_hoat_dong(){
        $page = Page::where('name','LIKE','Quy chế hoạt động')->first();
        // dd($page);
        return view('home.page.quy_che_hoat_dong',compact('page'));
    }

    public function chinh_sach_bao_hanh(){
        $page = Page::where('name','LIKE','Chính sách bảo hành-đổi trả')->first();
        // dd($page);
        return view('home.page.chinh_sach_bao_hanh',compact('page'));
    }

    public function chinh_sach_tra_gop(){
        $page = Page::where('name','LIKE','Chính sách trả góp')->first();
        // dd($page);
        return view('home.page.chinh_sach_tra_gop',compact('page'));
    }

    
    public function cau_hoi_thuong_gap(){
        $page = Page::where('name','LIKE','Câu hỏi thường gặp')->first();
        // dd($page);
        return view('home.page.cau_hoi_thuong_gap',compact('page'));
    }
}
