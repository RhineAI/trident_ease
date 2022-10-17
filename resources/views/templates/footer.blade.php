<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0
    </div>
    <strong>Copyright &copy; <script>document.write(/\d{4}/.exec(Date())[0])</script> <a href="https://www.instagram.com/smooth_0702/">Muhamad Fadhil Allifah</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/dist/js/adminlte.min.js"></script>
{{-- <script src="{{ asset('assets') }}/dist/js/demo.js"></script> --}}
<script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="{{ asset('js') }}/sweetalert2.all.min.js"></script>

{{-- Toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script src="{{ asset('assets') }}/vendor/chart.js/Chart.min.js"></script>
<script src="{{ asset('assets') }}/js/chart-area-demo.js"></script> 

<script>
  @if(session()->has('success'))
      toastr.success('{{ session('success') }}', 'TERIMA KASIH!'); 

      @elseif(session()->has('error'))

      toastr.error('{{ session('error') }}', 'GAGAL!'); 
  @endif
</script>
@stack('scripts')
