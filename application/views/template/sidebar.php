<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url()?>">
    <div class="sidebar-brand-icon">
      <!-- <img src="<?=base_url()?>assets/img/logo/logo2.png"> -->
    </div>
    <div class="sidebar-brand-text mx-3">Digital Signature</div>
  </a>
  <li class="nav-item <?=empty($link) || $link=='dashboard'?'active':''?>">
    <a class="nav-link " href="<?=base_url()?>admin">
      <i class="fas fa-check-square"></i>
      <span>Dashboard</span></a>
  </li>
  <hr class="sidebar-divider"> 
  <li class="nav-item <?=empty($link) || $link=='master'?'active':''?>">
    <a class="nav-link " href="<?=base_url()?>admin/master">
      <i class="fas fa-check-square"></i>
      <span>Master Signature</span></a>
  </li>
  <li class="nav-item <?=empty($link) || $link=='kehadiranunit'?'active':''?>">
    <a class="nav-link " href="<?=base_url()?>admin/transaksi">
      <i class="fas fa-check-square"></i>
      <span>Dokumen</span></a>
  </li>
   
</ul>
<!-- Sidebar -->