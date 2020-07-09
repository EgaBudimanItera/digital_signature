<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sertifikat</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=base_url()?>">Digital Signature</a></li>
        <li class="breadcrumb-item active">Sertifikat</li>
        <!-- <li class="breadcrumb-item " aria-current="page">Blank Page</li> -->
    </ol>
    </div>
    <div class="row mb-3">
             
       
        <!-- Area Chart -->
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <button class="btn btn-success float-right btn-tambah-file" ><i class="fas fa-plus"></i> Upload File</button>
                </div>
               
                <div class="card-body">     
                    
                    <table class="table table-striped table-bordered dataTableHoverRektor">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dokumen</th>
                                
                                <th>Tanggal Upload</th>
                                
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=1;
                                foreach($list as $l){
                            ?>
                            <tr>
                                <td><?=$no++;?></td>
                                <td><?=$l->nama_dokumen;?></td>
                                <td><?=$l->tanggal_kegiatan;?></td>
                                <td><a href="<?= base_url() ?>admin/preview_hasil/<?=$l->id_trans?>">Combine</a></td>
                                <!-- <td><a href="<?= base_url() ?>admin/print_qr/<?=$l->id_trans?>" class="btn btn-success" >Print Qr code</a></td> -->
                            </tr>
                            <?php
                                
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
