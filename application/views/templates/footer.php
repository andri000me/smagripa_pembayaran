<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="http://adminlte.io">SMK PGRI PAKISAJI</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url() ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url() ?>assets/plugins/toastr/toastr.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= base_url() ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?= base_url() ?>assets/dist/js/demo.js"></script>

<!-- ChartJS -->
<script src="<?= base_url() ?>assets/plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="<?= base_url() ?>assets/dist/js/pages/dashboard2.js"></script>
<!-- page script Table -->
<!-- Select2 -->
<script src="<?= base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>

<script>
    $(function() {
        $('#example1').DataTable();
        $('.select2').select2()
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
    // modal Pembayaran DPP
    $(document).ready(function() {
        $('#SiswaBelumLunas').change(function() {
            let nisn = $('#SiswaBelumLunas').find(':selected').val();
            $.ajax({
                type: 'post',
                url: '<?= base_url() ?>DataPembayaranDPP/detail_siswa/true',
                data: {
                    "nisn": nisn
                },
                success: function(data) {
                    var dataSiswa = JSON.parse(data);
                    $('#jurusan_kelas').val(dataSiswa.nama_jurusan);
                    $('#jumlahAngsuran').val(dataSiswa.jumlah_angsuran);
                    $('#nominal').val(dataSiswa.nominal_dpp);
                    $('#nominalAngsuran').val(dataSiswa.nominal_dpp / dataSiswa.jumlah_angsuran);
                    var dataAngsuran = dataSiswa.angsuran;
                    var html = '<table class="table table-bordered">';
                    html += `
                        <tr>
                            <td colspan="` + dataSiswa.jumlah_angsuran + `">
                            Detail Angsuran
                            </td>
                        </tr>
                        `;
                    html += '<tr>';
                    for (let index = 1; index <= dataSiswa.jumlah_angsuran; index++) {
                        if (dataAngsuran != false) {
                            if (dataAngsuran.includes(index + "")) {
                                console.log('ketemu');
                                html += `
                                        <td> 
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked disabled>
                                                <label class="form-check-label" >
                                                Angsuran Ke-` + index + ` (lunas)
                                                </label>
                                            </div>
                                        </td>
                                        `;
                            } else {
                                html += `
                                        <td> 
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="angsuran[]" id='chkAngsuran' value="` + index + `" >
                                                <label class="form-check-label">
                                                Angsuran Ke-` + index + `
                                                </label>
                                            </div>
                                        </td>
                                        `;
                            }
                        } else {
                            html += `
                                        <td> 
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="angsuran[]" id='chkAngsuran' value="` + index + `" >
                                                <label class="form-check-label">
                                                Angsuran Ke-` + index + `
                                                </label>
                                            </div>
                                        </td>
                                        `;
                        }
                    }
                    html += '</tr>';
                    html += '</table>';
                    $('#DetailPembaryaran').html(html);
                    $('#btnSaveAngsuran').removeAttr('disabled');
                }
            })
        });
        // modal pembayaran SPP
        $('#bayarSPP').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var nisn = button.data('nisn') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            $.ajax({
                type: 'post',
                url: '<?= base_url() ?>DataPembayaranSPP/searchSiswa',
                data: {
                    'nisn': nisn
                },
                success: function(data) {
                    var dataSiswa = JSON.parse(data);
                    modal.find('#dataNISN').text(dataSiswa.nisn)
                    modal.find('#dataNama').text(dataSiswa.nama_siswa)
                    modal.find('#dataJurusan').text(dataSiswa.kode_jurusan)
                    modal.find('#dataJenisSPP').text(dataSiswa.kategori)
                    modal.find('#dataNominalSPP').text('Rp. ' + dataSiswa.nominal_jenis)
                    modal.find('#dataDaftarTagihan').html(dataSiswa.list_tagihan)
                }
            })
        })

    });
</script>


</body>

</html>