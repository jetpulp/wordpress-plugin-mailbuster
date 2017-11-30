<h2>Mailbuster for Wordpress</h2>

<h2 class="nav-tab-wrapper">
  <a href="<?php echo admin_url('options-general.php?page=mailbuster-settings'); ?>" class="nav-tab <?php echo $_GET['page'] == 'mailbuster-settings' ? 'nav-tab-active' : ''?>"><?php echo __( 'Settings', 'mailbuster' ) ?></a>
  <a href="<?php echo admin_url('admin.php?page=mailbuster-test'); ?>" class="nav-tab <?php echo $_GET['page'] == 'mailbuster-test' ? 'nav-tab-active' : ''?>"><?php echo __( 'Run a test', 'mailbuster' ) ?></a>
</h2>