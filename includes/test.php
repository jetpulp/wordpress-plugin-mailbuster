<div class="wrap">
  <?php include 'page-header.php'; ?>
  
  <p><?php echo __( 'This test sends an email using the standard wp_mail function.', 'mailbuster' ) ?></p>
  <form action="<?php echo admin_url('admin.php?page=mailbuster-test'); ?>" method="post">
    
    <?php wp_nonce_field('mailbuster_test_action'); ?>
    
    <table class="form-table">
        <tr>
          <th scope="row"><?php echo __( 'To', 'mailbuster' ) ?></th>
          <td><input type="email" name="to" value="<?php echo get_option('admin_email')?>"/></td>
        </tr>
        <tr>
          <th scope="row"><?php echo __( 'Message', 'mailbuster' ) ?></th>
          <td><textarea name="message" rows="5"><?php echo __( 'This is a test email from the Mailbuster plugin for Wordpress.', 'mailbuster' ) ?></textarea></td>
        </tr>
        <tr>
          <th></th>
          <td><button type="submit" class="button button-primary"><?php echo __( 'Send', 'mailbuster' ) ?></button></td>
        </tr>
    </table>
  </form>
</div>