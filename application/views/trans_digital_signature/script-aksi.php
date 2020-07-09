
<script>
    $(document).ready(function(){
        $(document).on('click', '.btn-tambah-file', function(e){
            e.preventDefault();
            $('#modal-aksi').modal();
            var id  = $(this).attr('id');
            
            $('#aksi').val('tambah');
             $('#id_trans').val(id);
        });

        $(document).on('submit', '#form-upload-file', function(e){
            e.preventDefault();
            var data = new FormData(document.getElementById('form-upload-file'));
            $('.notif').html('Loading...');
            $(':input[type="submit"]').prop('disabled', true);
            var aksi = $('#aksi').val();
            if(aksi == 'tambah'){
                $.ajax({
                    url: '<?=base_url()?>admin/simpan_trans',
                    type: 'POST',
                    data: data,
                    dataType: 'JSON',
                    processData: false, 
	                contentType: false,
                    success: function(msg){
                        if(msg.status == 'success'){
                            $('.notif').html(msg.text);
                            location.reload();
                        }else if(msg.status == 'failed'){
                            $('.notif').html(msg.text);
                            $(':input[type="submit"]').prop('disabled', false);
                        }
                    }
                });
            }else{
                $.ajax({
                    url: '<?=base_url()?>admin/ubah_trans',
                    type: 'POST',
                    data: data,
                    dataType: 'JSON',
                    success: function(msg){
                        if(msg.status == 'success'){
                            $('.notif').html(msg.text);
                            location.reload();
                        }else if(msg.status == 'failed'){
                            $('.notif').html(msg.text);
                            $(':input[type="submit"]').prop('disabled', false);
                        }
                    }
                });
            }
            
        });
    });
</script>