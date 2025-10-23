<!doctype html>
<html lang="vi">
@include('admin.layout.components.head')

<body>
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    @include('admin.layout.components.nav')
    @include('admin.layout.components.header')
    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>
    @include('admin.layout.components.footer')
    @include('admin.layout.components.script')
</body>

</html>
