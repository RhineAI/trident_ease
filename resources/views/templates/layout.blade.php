<!DOCTYPE html>
<html lang="en">

<head>
    @include('templates.header')
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;1,100;1,200;1,300&display=swap');
    body {
        font-family: 'Tw Cen MT', sans-serif;
    }
</style>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        @include('templates.navbar')

        @include('templates.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('templates.content')
        </div>
        <!-- /.content-wrapper -->

        @include('templates.footer')
    </div>

</body>

</html>
