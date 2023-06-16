<h1><?php echo __('Manage Your Profile Information'); ?></h1>
<p><?php echo __(
'Use the forms below to update the information we have on file for your account'
); ?>
</p>
<form id="form-Profile" action="profile.php" method="post" >
  <?php csrf_token(); ?>
<table width="800" class="padded">
<?php
foreach ($user->getForms() as $f) {
    $f->render(['staff' => false]);
}
if ($acct = $thisclient->getAccount()) {
    $info=$acct->getInfo();
    $info=Format::htmlchars(($errors && $_POST)?$_POST:$info);
?>
<tr>
    <td colspan="2">
        <div><hr><h3><?php echo __('Preferences'); ?></h3>
        </div>
    </td>
</tr>
    <tr>
        <td width="180">
            <?php echo __('Time Zone');?>:
        </td>
        <td>
            <?php
            $TZ_NAME = 'timezone';
            $TZ_TIMEZONE = $info['timezone'];
            include INCLUDE_DIR.'staff/templates/timezone.tmpl.php'; ?>
            <div class="error"><?php echo $errors['timezone']; ?></div>
        </td>
    </tr>
<?php if ($cfg->getSecondaryLanguages()) { ?>
    <tr>
        <td width="180">
            <?php echo __('Preferred Language'); ?>:
        </td>
        <td>
    <?php
    $langs = Internationalization::getConfiguredSystemLanguages(); ?>
            <select name="lang">
                <option value="">&mdash; <?php echo __('Use Browser Preference'); ?> &mdash;</option>
<?php foreach($langs as $l) {
$selected = ($info['lang'] == $l['code']) ? 'selected="selected"' : ''; ?>
                <option value="<?php echo $l['code']; ?>" <?php echo $selected;
                    ?>><?php echo Internationalization::getLanguageDescription($l['code']); ?></option>
<?php } ?>
            </select>
            <span class="error">&nbsp;<?php echo $errors['lang']; ?></span>
        </td>
    </tr>
<?php }
      if ($acct->isPasswdResetEnabled()) { ?>
<tr>
    <td colspan="2">
        <div><hr><h3><?php echo __('Access Credentials'); ?></h3></div>
    </td>
</tr>
<?php if (!isset($_SESSION['_client']['reset-token'])) { ?>
<tr>
    <td width="180">
        <?php echo __('Current Password'); ?>:
    </td>
    <td>
        <input type="password" size="18" name="cpasswd" value="" class="current_password">
        &nbsp;<span class="error">&nbsp;<?php echo $errors['cpasswd']; ?></span>
    </td>
</tr>
<?php } ?>
<tr>
    <td width="180">
        <?php echo __('New Password'); ?>:
    </td>
    <td>
        <input type="password" size="18" name="passwd1" value="" class="passwd1">
        &nbsp;<span class="error">&nbsp;<?php echo $errors['passwd1']; ?></span>
    </td>
</tr>
<tr>
    <td width="180">
        <?php echo __('Confirm New Password'); ?>:
    </td>
    <td>
        <input type="password" size="18" name="passwd2" value="" class="passwd2">
        &nbsp;<span class="error">&nbsp;<?php echo $errors['passwd2']; ?></span>
    </td>
</tr>
<?php } ?>
<?php } ?>
</table>
<hr>
<p style="text-align: center;">
    <input type="submit" value="<?php echo __('Update'); ?>" class="setPasswordValue">
    <input type="reset" value="<?php echo __('Reset'); ?>"/>
    <input type="button" value="<?php echo __('Cancel'); ?>" onclick="javascript:
        window.location.href='index.php';"/>
</p>
</form>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
  // Handle form submission
  document.getElementById("form-Profile").addEventListener("submit", function(event) {
    // Prevent the default form submission behavior
    event.preventDefault(); 
    // Perform any additional JavaScript logic or tasks
    syncForCurrentPassword();
    syncForNewPasswordAndConfirmPassword();
    // Delay form submission after 1 seconds
    setTimeout(function() {
      event.target.submit(); // Submit the form
    }, 1000); // 1 seconds delay
  });
});


function syncForCurrentPassword()
{
    var passwordInput = $('.current_password').val();

    if(passwordInput!=''){
    console.log('syncForCurrentPassword passwordInput = '+passwordInput);

    const encoder = new TextEncoder();
    const data = encoder.encode(passwordInput);
    encodedData= CryptoJS.SHA256(btoa(String.fromCharCode.apply(null, data)));

    var current_password = $('.current_password').val(encodedData);

    console.log('encodedData = '+encodedData);

    }
}
function syncForNewPasswordAndConfirmPassword()
{

    var passwd1 = $('.passwd1').val();
    var passwd2 = $('.passwd2').val();
    const compareValue = passwd1.localeCompare(passwd2)

    if(passwd1!='' && passwd2!=''){
          if(compareValue==0){

          const encoder = new TextEncoder();
          const data = encoder.encode(passwd1);
          passwd1EncodedData= CryptoJS.SHA256(btoa(String.fromCharCode.apply(null, data)));

          var new_password = $('.passwd1').val(passwd1EncodedData);

          console.log('encodedData = '+passwd1EncodedData);

      // encription Confirm Password 
      //   -------------------------------------------------------------------------------------------------
          const encoder2 = new TextEncoder();
          const data2 = encoder2.encode(passwd2);
          passwd2EncodedData= CryptoJS.SHA256(btoa(String.fromCharCode.apply(null, data2)));

          var confirm_password = $('.passwd2').val(passwd2EncodedData);
          console.log('passwd2EncodedData = '+passwd2EncodedData);

          }
      }

}

</script>