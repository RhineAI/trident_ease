<!DOCTYPE html>
<html lang="en">

<head>
    @include('templates.header')
</head>
<style>
    body {
        font-family: 'Open Sans'; 
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
