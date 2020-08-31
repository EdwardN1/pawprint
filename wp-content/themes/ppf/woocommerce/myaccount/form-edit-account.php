<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );

if(isset($_GET['delete-account'])){
    wp_delete_user($_GET['delete-account']);
    ?>
    <script>
        window.location.href = '<?=get_site_url()?>'
    </script>
    <?php
}

?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" enctype="multipart/form-data" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

    <p>Use this page to manage your account settings including your profile picture and to change your password</p>
    <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
        <label for="account_profile_pic"><?php esc_html_e( 'Profile Pic', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
        <?php
            $profile_pic = get_user_meta($user->ID , 'account_profile_pic' , true);
            $profile_image = wp_get_attachment_url($profile_pic);
        ?>
        <span class="account_profile_pic_toggle" style="background: #eee url('<?=$profile_image?>')" title="<?=basename($profile_image)?>">
            <input type="file" accept="image/*" name="account_profile_pic" id="account_profile_pic">
        </span>
        <input type="hidden" name="account_profile_pic_id" <?=(isset($profile_pic)) ? 'value="'.$profile_pic.'"' : ''?>>
    </p>
    <br clear="all"/>

	<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
		<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
		<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
	</p>
	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
	</p>
	<div class="clear"></div>

	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	</p>

    <hr>

    <?php $hear = get_user_meta($user->ID , '_hear' , true); ?>

    <p>
        <label for="">Where did you first hear about us?</label>
        <div class="woocommerce-checkboxes">
            <label for=""><input type="radio" name="hear" value="Facebook" <?=($hear == "Facebook") ? 'checked' : ''?>> Facebook</label>
            <label for=""><input type="radio" name="hear" value="Twitter" <?=($hear == "Twitter") ? 'checked' : ''?>> Twitter</label>
            <label for=""><input type="radio" name="hear" value="Instagram" <?=($hear == "Instagram") ? 'checked' : ''?>> Instagram</label>
            <label for=""><input type="radio" name="hear" value="Internet Search" <?=($hear == "Internet Search") ? 'checked' : ''?>> Internet Search</label>
            <br clear="all">
            <label for="">
                <input type="radio" name="hear" value="Other" <?=($hear == "Other") ? 'checked' : ''?>> Other (please specify)
                <input type="text" name="hear_other">
            </label>
        </div>
    </p>

    <?php $groups = get_user_meta($user->ID , '_groups' , true); $groups = json_decode($groups); ?>

    <p>
        <label for="">Which groups do you order for? (Select all relevant options)</label>
        <div class="woocommerce-checkboxes">
            <label for=""><input type="checkbox" name="groups[]" value="Scouting" <?=(in_array('Scouting' , $groups)) ? 'checked' : ''?>> Scouting</label>
            <label for=""><input type="checkbox" name="groups[]" value="Girlguiding" <?=(in_array('Girlguiding' , $groups)) ? 'checked' : ''?>> Girlguiding</label>
            <label for=""><input type="checkbox" name="groups[]" value="Home Education" <?=(in_array('Home Education' , $groups)) ? 'checked' : ''?>> Home Education</label>
            <label for=""><input type="checkbox" name="groups[]" value="Child Minding" <?=(in_array('Child Minding' , $groups)) ? 'checked' : ''?>> Child Minding</label>
            <label for=""><input type="checkbox" name="groups[]" value="School/Education" <?=(in_array('School/Education' , $groups)) ? 'checked' : ''?>> School/Education</label>
            <br clear="all">
            <label for=""><input type="checkbox" name="groups[]" value="Other" <?=(in_array('Other' , $groups)) ? 'checked' : ''?>> Other (please specify) <input type="text" name="groups_other"></label>
        </div>
    </p>

    <?php $ages = get_user_meta($user->ID , '_ages' , true); $ages = json_decode($ages); ?>

    <p>
        <label for="">Which age groups do you order for? (Select all relevant options)</label>
        <div class="woocommerce-checkboxes">
            <label for=""><input type="checkbox" name="ages[]" value="3-5" <?=(in_array('3-5' , $ages)) ? 'checked' : ''?>> 3 - 5</label>
            <label for=""><input type="checkbox" name="ages[]" value="5-7" <?=(in_array('5-7' , $ages)) ? 'checked' : ''?>> 5 - 7</label>
            <label for=""><input type="checkbox" name="ages[]" value="7-11" <?=(in_array('7-11' , $ages)) ? 'checked' : ''?>> 7 - 11</label>
            <label for=""><input type="checkbox" name="ages[]" value="11-14" <?=(in_array('11-14' , $ages)) ? 'checked' : ''?>> 11 - 14</label>
            <label for=""><input type="checkbox" name="ages[]" value="14-18" <?=(in_array('14-18' , $ages)) ? 'checked' : ''?>> 14 - 18</label>
            <label for=""><input type="checkbox" name="ages[]" value="18+" <?=(in_array('18+' , $ages)) ? 'checked' : ''?>> 18+</label>
        </div>
    </p>

    <hr>

	<fieldset>
		<legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
		</p>
	</fieldset>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
        <a href="javascript:void(0);" class="woocommerce-Button button delete-account" onclick="if(confirm('Are you sure you would like to delete your account')) { window.location.href = '<?=get_site_url().'/my-account/edit-account/?delete-account='.get_current_user_id()?>'; }else{  }">Delete Account</a>
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
