<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    @include('layouts.header')
    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
              <h1 class="jumbotron-heading"></h1>
              <p class="lead text-muted">قم بمشاركة جميع صورك وفيديوهاتك أنت وأصدقائك من خلال شبكة انستغرام حسوب</p>
              <p style="direction: rtl;">
                <a href="#" class="btn btn-secondary my-2">الرئيسية</a>
                <a href="#" class="btn btn-secondary my-2">المتابعين</a>
                <a href="#" class="btn btn-secondary my-2">المستخدمين</a>
                <a href="{{url('user/posts')}}" class="btn btn-{{ isset($active_profile) ? $active_profile : 'secondary' }} my-2">المنشورات</a>
              </p>
            </div>
        </section>    
        @yield('content')
    </main>
    @include('layouts.footer')
</html>
