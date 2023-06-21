<h3 class="drag-handle"><?php echo $title ?></h3>
<b><a class="close" href="#"><i class="icon-remove-circle"></i></a></b>
<div class="clear"></div>
<hr/>
<?php if (isset($errors['err'])) { ?>
    <div id="msg_error" class="error-banner"><?php echo Format::htmlchars($errors['err']); ?></div>
<?php } ?>
<form id="myForm" method="post" action="#">
<?php $change_password= explode("/",$path);
       $staff_id = $change_password[1];
?>
  <div class="quick-add">
    <?php if('change-password'!= $change_password[2]){ ?>
    <?php echo $form->asTable(); ?>
    <?php } elseif('change-password'==$change_password[2]) { ?>
      <input type="hidden" value="<?php echo $staff_id; ?>" name="staff_id">
      <input type="hidden" value="staff_change_password_custom" name="staff_change_password_custom">

      <table class="grid form">
        <caption> <div><small>Confirm your current password and enter a new password to continue</small></div>
        </caption>
        <tbody>
        <tr><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td></tr></tbody>
        <tbody>
            <tr> 
                <td class="cell" colspan="12" rowspan="1" style="" data-field-id="1">
                    <fieldset class="field " id="field_current_password" data-field-id="1">
                        <label class="required" for="current_password">
                        Current Password:                                <span class="error">*</span>
                        </label>
                        <input type="password" id="current_password" autofocus="" class="current_password" size="16" maxlength="30" placeholder="Current Password" name="current_password" value="">
                    </fieldset>
                </td>
            </tr>
            <tr>          
                <td class="cell" colspan="12" rowspan="1" style="padding-top: 20px" data-field-id="2">
                    <fieldset class="field " id="field_passwd1" data-field-id="2">
                        <label class="required" for="passwd1">
                            Enter a new password:                                
                            <span class="error">*</span>
                        </label>
                        <input type="password" id="passwd1" class="passwd1" size="16" maxlength="30" placeholder="New Password" name="passwd1" value="">
                    </fieldset>
                </td>
            </tr>
            <tr>          
                <td class="cell" colspan="12" rowspan="1" style="" data-field-id="3">
                    <fieldset class="field " id="field_passwd2" data-field-id="3">
                        <label class="required" for="passwd2">
                            Confirm Password:                                
                            <span class="error">*</span>
                        </label>
                        <input type="password" id="passwd2" class="passwd2" size="16" maxlength="30" placeholder="Confirm Password" name="passwd2" value="">
                    </fieldset>
                </td>
            </tr>
        </tbody>
    </table>
    <?php } ?>
  </div>
  <hr>
  <p class="full-width">
    <span class="buttons pull-left">
      <input type="reset" value="<?php  echo __('Reset'); ?>" />
      <input type="button" name="cancel" class="close"
        value="<?php echo __('Cancel'); ?>" />
    </span>
    <span class="buttons pull-right">
    
        <?php if('change-password'==$change_password[2]){ ?>    
          <input type="button" value="Ok" class="setPasswordValue" />
        <?php  } ?>
      <input type="submit" value="<?php echo $verb ?: __('Create'); ?>"  <?php if('change-password'==$change_password[2]){ ?> disabled class="updatePassword" <?php } ?> />
    </span>
  </p>
  <div class="clear"></div>
</form>
<script>
$(function(){
  // Handle form submission
  $('#myForm').submit(function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Perform any additional JavaScript logic or tasks
    // ...
    // ...
    var passwd1 = $('.passwd1').val();
    var passwd2 = $('.passwd2').val();
    const compareValue = passwd1.localeCompare(passwd2);

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

          var path = '<?php echo $path; ?>';
          $('#myForm').attr('action', '#'+path); // Set the new action value

          }
          else{
            alert('Passwords do not match');
            setTimeout(function () {
              location.reload();
            }, 2000);
          }
      }else{
            alert('New password and Confirm Password  field is require');
            setTimeout(function () {
              location.reload();
            }, 2000);
       }


 


  });
});

</script>

<script type="text/javascript">
$(function(){
  $(document).on('click','.setPasswordValue', function(){
    console.log('on change get value feom class current_password=');
    syncForCurrentPassword();
    syncForNewPasswordAndConfirmPassword();
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
    else{
      alert('current passwords field is require');
      setTimeout(function () {
        location.reload();
      }, 2000);
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
          
          if ($('.current_password').val() != '' && $('.current_password').val() != '' && $('.current_password').val() != '') {
                      $('.updatePassword').prop('disabled', false);
                      $('.setPasswordValue').hide();
                  } else {
                      $('.updatePassword').prop('disabled', true);
                  }
          }
          else{
            alert('Passwords do not match');
            setTimeout(function () {
              location.reload();
            }, 2000);
          }
      }else{
            alert('New password and Confirm Password  field is require');
            setTimeout(function () {
              location.reload();
            }, 2000);
       }

}

</script>
