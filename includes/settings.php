<div class="wrap">
  <?php include 'page-header.php'; ?>
  
  <form method="post" action="options.php">
    <?php settings_fields( 'mailbuster-settings' ); ?>
    <?php do_settings_sections( 'mailbuster-settings' ); ?>
    
    <table class="form-table">
      <tr>
        <th scope="row"><?php echo __( 'Enabled', 'mailbuster' ) ?></th>
        <td><input type="checkbox" name="mailbuster_enabled" value="1" <?php echo get_option('mailbuster_enabled') === '1' ? 'checked' : '' ?> /></td>
      </tr>
      <tr>
        <th scope="row"><?php echo __( 'Email', 'mailbuster' ) ?></th>
        <td>
          <input type="text" name="mailbuster_to" value="<?php echo esc_attr( get_option('mailbuster_to') ); ?>" />
          <p><?php echo __('Email address which will catch all emails sent using wp_mail().', 'mailbuster' )?></p>
        </td>
      </tr>
      <tr>
        <th scope="row"><?php echo __( 'Prefix for the subject', 'mailbuster' ) ?></th>
        <td>
          <input type="text" name="mailbuster_subject" value="<?php echo esc_attr( get_option('mailbuster_subject') ); ?>" />
          <p><?php echo __('Add a prefix to the subject of the email (eg: "[mywebsite.com beta]")', 'mailbuster' )?>.<br />
          <?php echo __('The original recipient will be add at the end of the subject.', 'mailbuster' )?></p>
        </td>
      </tr>
      <tr>
        <th scope="row"><?php echo __( 'Pre-production domain patterns', 'mailbuster' ) ?></th>
        <td>
          <input type="text" name="mailbuster_preproduction_pattern" value="<?php echo esc_attr( get_option('mailbuster_preproduction_pattern') ); ?>" />
          <p><?php echo __('Add patterns of the local, pre production servers. Separate them by a comma.', 'mailbuster' )?></p>
        </td>
      </tr>

    </table>
    
    <?php submit_button(); ?>
    
  </form>
</div>
