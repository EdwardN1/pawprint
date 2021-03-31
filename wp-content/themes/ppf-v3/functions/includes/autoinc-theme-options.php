<?php

function pawprint_register_settings()
{
    add_option('paw-trust-col-1', '<h2>Left Column Content</h2><p>Enter your content here</p>');
    register_setting('paw_footer_management_group', 'paw-trust-col-1');
    add_option('paw-trust-col-2', '<h2>Right Column Content</h2><p>Enter your content here</p>');
    register_setting('paw_footer_management_group', 'paw-trust-col-2');
}

add_action('admin_init', 'pawprint_register_settings');

function pawprint_register_options_page()
{
    //Add to settings menu
    //add_options_page('Page Title', 'Plugin Menu', 'manage_options', 'myplugin', 'myplugin_options_page');
    // Add to admin_menu function
    add_menu_page(__('Pawprint Menu'), __('Pawprint Menu'), 'manage_options', 'ppf_menu', 'ppf_menu_options_page', get_template_directory_uri() . '/assets/img/pawprint-icon.png', 2);

}

add_action('admin_menu', 'pawprint_register_options_page');

function ppf_menu_options_page()
{
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <?php
        if (isset($_GET['tab'])) {
            $active_tab = sanitize_text_field($_GET['tab']);
        } else {
            $active_tab = 'footer_management';
        }
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=ppf_menu&tab=footer_management"
               class="nav-tab <?php echo $active_tab == 'footer_management' ? 'nav-tab-active' : ''; ?>">Footer
                Management</a>
            <a href="?page=ppf_menu&tab=header_management"
               class="nav-tab <?php echo $active_tab == 'header_management' ? 'nav-tab-active' : ''; ?>">Header
                Management</a>
            <a href="?page=ppf_menu&tab=options_management"
               class="nav-tab <?php echo $active_tab == 'options_management' ? 'nav-tab-active' : ''; ?>">Options</a>
            <?php
            $current_user = wp_get_current_user();
            $email = (string)$current_user->user_email;
            if ($email === 'edward@technicks.com'):?>
                <a href="?page=ppf_menu&tab=pawprint_restricted_settings"
                   class="nav-tab <?php echo $active_tab == 'pawprint_restricted_settings' ? 'nav-tab-active' : ''; ?>">Pawprint
                    Restricted Settings</a>
            <?php endif; ?>
        </h2>
        <?php if ($active_tab == 'footer_management'): ?>
            <h1>Footer Management</h1>
            <h2>
                Trust Section
            </h2>
            <form method="post" action="options.php">
                <?php settings_fields('paw_footer_management_group'); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="paw-trust-col-1">Column Left Content:</label></th>
                        <td>
                            <?php wp_editor(get_option('paw-trust-col-1'), 'trust-col-1-editor', $settings = array('textarea_name' => 'paw-trust-col-1')); ?>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="paw-trust-col-2">Column Right Content:</label></th>
                        <td>
                            <?php wp_editor(get_option('paw-trust-col-2'), 'trust-col-2-editor', $settings = array('textarea_name' => 'paw-trust-col-2')); ?>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        <?php endif; ?>
        <?php if ($active_tab == 'header_management'): ?>
            <h1>Header Management</h1>
        <?php endif; ?>
        <?php if ($active_tab == 'options_management'): ?>
            <h1>Options Management</h1>
        <?php endif; ?>
        <?php if ($email === 'edward@technicks.com'): ?>
            <?php if ($active_tab == 'pawprint_restricted_settings'): ?>
                <h1>Restricted Settings</h1>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php
}
