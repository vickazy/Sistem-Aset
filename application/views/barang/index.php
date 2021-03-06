<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage
      <small>Barang</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Barang</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <?php if(in_array('createBarang', $user_permission)): ?>
          <a href="<?php echo base_url('barang/create') ?>" class="btn btn-primary">Tambah Barang</a>
        <?php endif; ?>
          <a href="<?php echo base_url('barang/export_excel') ?>" class="btn btn-success">Export Data Barang</a>
          <a href="<?php echo base_url('barang/download_excel') ?>" class="btn btn-danger">Format Import Excel</a>
          <br /><br />

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Daftar Barang</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="manageTable" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</>
                <th>Nama Barang</th>
                <th>Kode Barang</th>
                <th>Tahun Perolehan</th>
                <th>Penanggung Jawab</th>
                <th>Merk</th>
                <th>Ruang</th>
                <th>Gedung</th>
                <th>Kondisi</th>
                <?php if(in_array('updateBarang', $user_permission) || in_array('deleteBarang', $user_permission)): ?>
                  <th>Tindakan</th>
                <?php endif; ?>
              </tr>
              </thead>

            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php if(in_array('deleteBarang', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hapus Barang</h4>
      </div>

      <form role="form" action="<?php echo base_url('barang/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Apakah Anda Yakin Ingin Menghapus Barang Ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Tidak</button>
          <button type="submit" class="btn btn-default">Hapus</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<script type="text/javascript">
var manageTable;
var base_url = "<?= base_url(); ?>";

$(document).ready(function() {
  $("#mainBarangNav").addClass('active');
  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'barang/ambilDataBarang',
    'order': [],
  });
});

// remove functions   
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { barang_id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}


</script>
