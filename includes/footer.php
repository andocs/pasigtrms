<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top" style="background-color: #05269E">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="login.html">Logout</a>
      </div>
    </div>
  </div>
</div>
-->

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.js"></script>

<!-- Demo scripts for this page-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="js/main.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/b-3.1.0/b-colvis-3.1.0/b-html5-3.1.0/b-print-3.1.0/datatables.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    <?php
    if (isset($_SESSION['toast'])) {
      $toast = $_SESSION['toast'];
      unset($_SESSION['toast']);
      $toastTypeClass = '';
      switch ($toast['type']) {
        case 'success':
          $toastTypeClass = 'bg-success text-white';
          break;
        case 'error':
          $toastTypeClass = 'bg-danger text-white';
          break;
        case 'warning':
          $toastTypeClass = 'bg-warning text-dark';
          break;
        case 'info':
          $toastTypeClass = 'bg-info text-white';
          break;
        default:
          $toastTypeClass = 'bg-secondary text-white';
      }
    ?>
      var toastElement = document.getElementById('toast');
      var toastClasses = '<?php echo $toastTypeClass; ?>'.split(' ');
      toastElement.classList.add(...toastClasses);

      document.getElementById('toast-body').innerText = '<?php echo addslashes($toast['message']); ?>';

      var toast = new bootstrap.Toast(toastElement);
      toast.show();
    <?php } ?>
  });
</script>
</body>

</html>