<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <a href="https://instagram.com/trident.startup" class="text-warning" style="text-decoration: none;"><b>TridentPOS</b></a> v1.2.0
  </div>
  <strong>Copyright &copy; <script>document.write(/\d{4}/.exec(Date())[0])</script> Trident Tech ( <a href="https://www.instagram.com/smooth_0702/" style="text-decoration: none;" target="_blank">Muhammad Fadhil Allifah</a> & <a href="https://www.instagram.com/_syahid.lhs/?hl=id" style="text-decoration: none;">Luhung Lugina</a> ). </strong> All rights reserved.
  
</footer>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- ./wrapper -->

{{-- SweetAlert2 --}}
{{-- <link rel="stylesheet" href="sweetalert2.min.css"> --}}
{{-- <script src="sweetalert2.all.min.js"></script> --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> --}}
<!-- JavaScript Bundle with Popper -->

<!-- jQuery -->
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/dist/js/adminlte.min.js"></script>
<script src="{{ asset('assets') }}/dist/js/demo.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.js"></script>
<script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="{{ asset('js') }}/sweetalert2.all.min.js"></script>

{{-- Toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- FlatPickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

{{-- Bootstrap Validator --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.min.js"></script> --}}


<script>
@if(session()->has('success'))
    toastr.success('{{ session('success') }}', 'TERIMA KASIH!'); 

    @elseif(session()->has('error'))

    toastr.error('{{ session('error') }}', 'GAGAL!'); 

    @elseif(session()->has('errorKasKeluar'))

    toastr.error('{{ session('errorKasKeluar') }}', 'Peringatan!'); 
    $('#modal-form').modal('show')
    $('#modal-form .modal-title').text('Kas Masuk');
@endif
</script>
<script>
  // let arrow = document.querySelectorAll(".arrow");
  // for (var i = 0; i < arrow.length; i++) {
  //   arrow[i].addEventListener("click", (e)=>{
  //  let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
  //  arrowParent.classList.toggle("showMenu");
  //   });
  // }
  // let sidebar = document.querySelector(".sidebar");
  // let sidebarBtn = document.querySelector(".bx-menu");
  // console.log(sidebarBtn);
  // sidebarBtn.addEventListener("click", ()=>{
  //   sidebar.classList.toggle("close");
  // });

  $(document).on('click', '.nav-item', function(e) {
    // console.log(this)
    $('.nav-item').removeClass('menu-is-opening menu-open');
    $('.nav-treeview').hide();
    // var content = document.getElementById('.nav-treeview');
    // content.style.display = "none";
    $(this).addClass('menu-is-opening menu-open');
    $(this).find('ul.nav.nav-treeview').show();
  })
</script>
<script>
  function restrictChar(e) {
      const input = e.target;
      const regex = new RegExp("^[<>?/|$=:;+}([){#]*$");

      input.addEventListener("beforeinput", (event) => {
      if (event.data != null && regex.test(event.data)) 
          event.preventDefault();
      });
  }
  
  function restrictWord(e) {
      const input = e.target;
      const regex = new RegExp("^[0-9_ ]*$");

      input.addEventListener("beforeinput", (event) => {
      if (event.data != null && !regex.test(event.data)) 
          event.preventDefault();
      });
  }
</script>
@stack('scripts')
