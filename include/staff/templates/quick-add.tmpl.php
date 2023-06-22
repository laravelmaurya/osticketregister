<h3 class="drag-handle"><?php echo $title ?></h3>
<b><a class="close" href="#"><i class="icon-remove-circle"></i></a></b>
<div class="clear"></div>
<hr/>
<?php if (isset($errors['err'])) { ?>
    <div id="msg_error" class="error-banner"><?php echo Format::htmlchars($errors['err']); ?></div>
<?php } ?>
<form method="post" action="#<?php echo $path; ?>">
<?php $change_password= explode("/",$path);
       $staff_id = $change_password[1];
?>

  <div class="quick-add">
    
    <?php 
    if('change-password'!=$change_password[2] and 'set-password'!=$change_password[2]) {
      echo 'change'.'cp = '.$change_password[2];
      echo 'set'.'sp = '.$change_password[2];
      echo $form->asTable(); 
    }elseif('change-password'==$change_password[2]) { ?>
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
                        Current Password: <span class="error">*</span>
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
    <?php }elseif('set-password'==$change_password[2]) { ?>
      <input type="hidden" value="<?php echo $staff_id; ?>" name="staff_id">
      <input type="hidden" value="staff_set_password_custom" name="staff_set_password_custom">

      <table class="grid form">
        <tbody>
        <tr><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td><td style="width:8.3333%"></td></tr></tbody>
        <tbody>
            <tr>
              <td class="cell" colspan="12" rowspan="1" style="" data-field-id="1">
                <fieldset class="field " id="" data-field-id="1">
                <label class="" for="_e143db0def1e9c">
                &nbsp;
                    <label class="checkbox">
                      <input class="send-agent-password-reset-email" type="checkbox" name="_field-checkboxes[]" checked="checked">
                      Send the agent a password reset email
                    </label>
                </label>
                </fieldset>
              </td>
            </tr>
            <tr class="set-password-field">          
                <td class="cell " colspan="12" rowspan="1" style="padding-top: 20px" data-field-id="2">
                    <fieldset class="field " id="field_passwd1" data-field-id="2">
                        <label class="required" for="passwd1">
                            Enter a new password:                                
                            <span class="error">*</span>
                        </label>
                        <input type="password" id="passwd1" class="passwd1" size="16" maxlength="30" placeholder="New Password" name="passwd1" value="">
                    </fieldset>
                </td>
            </tr>
            <tr class="set-password-field">          
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
      <input  type="reset" value="<?php  echo __('Reset'); ?>"  <?php if('change-password'==$change_password[2] || 'set-password'==$change_password[2] ){ ?>  id="reset_password"  <?php  } ?> />
      <input type="button" name="cancel" class="close"
        value="<?php echo __('Cancel'); ?>" />
    </span>
    <span class="buttons pull-right">
    
        <?php if('change-password'==$change_password[2] || 'set-password'==$change_password[2] ){ ?>    
          <input type="button" value="Ok" class="setPasswordValue" />
  
          <!-- <a id="refresh" href="#" style="display:none"><?php  //echo __('refresh'); ?></a> -->
        <?php  } ?>
      <input type="submit" value="<?php echo $verb ?: __('Create'); ?>"  <?php if('change-password'==$change_password[2] || 'set-password'==$change_password[2]){ ?> disabled class="set-password-disable-check updatePassword" <?php } ?> />
    </span>
  </p>
  <div class="clear"></div>
</form>

<script type="text/javascript">

// $(function(){

//   $(document).on('click','#refresh', function(){
//     location.reload();

//   });

//   $(document).on('keypress','.passwd1,.passwd2', function(){
//     var change_password = "<?php // echo $change_password[2]; ?>";
//     if('set-password'==change_password){
//             $('.updatePassword').prop('disabled', true);
//     }

//   });

//   $(document).on('keypress','.current_password,.passwd1,.passwd2', function(){
//     var change_password = "<?php // echo $change_password[2]; ?>";
//     if('change-password'==change_password){
//       $('.updatePassword').prop('disabled', true);
//     }
//   })
// });



$(function(){
    var change_password = "<?php  echo $change_password[2]; ?>";
    
    if('set-password'==change_password){
    
      $('.updatePassword').prop('disabled', true);

      $('.set-password-field,.setPasswordValue').hide();
      $('.send-agent-password-reset-email').val(1);
      $('.set-password-disable-check').removeClass('updatePassword');

      $('.set-password-disable-check').prop('disabled', false);

      $(document).on('click','.send-agent-password-reset-email', function(){
              var isChecked = $(this).is(':checked');
              // Update the checked attribute based on the current state
              if (isChecked) {
                
                    console.log('Checkbox  is checked');
                    
                    $(this).prop('checked', true);
                    $(this).val(1);

                    $('.set-password-field,.setPasswordValue').hide();
                    $('.updatePassword').prop('disabled',false);
                    $('.set-password-disable-check').removeClass('updatePassword');

              
              } else {
              
                    // Checkbox 1 is unchecked
                    console.log('Checkbox  is unchecked');
                    
                    $(this).prop('checked', false);
                    $(this).val(2);
                    $('.set-password-field,.setPasswordValue').show();
                    $('.set-password-disable-check').addClass('updatePassword');
                    // $('.set-password-disable-check').attr('disabled','true');
                    $('.updatePassword').prop('disabled', true);
              }
        });
     }
});

$(function(){
  $(document).on('click','#reset_password', function(){
    $('.set-password-field,.setPasswordValue').hide();
      $('.updatePassword').prop('disabled',false);
      $('.set-password-disable-check').removeClass('updatePassword');
  });
});
$(function(){
  $(document).on('click','.setPasswordValue', function(){
    console.log('on change get value feom class current_password=');
    var change_password = "<?php echo $change_password[2]; ?>";
    if('set-password'!=change_password){
      syncForCurrentPassword();
    }
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

          var change_password = "<?php echo $change_password[2]; ?>";
          
               if('set-password'!=change_password){
                    if ($('.current_password').val() != '' && $('.passwd1').val() != '' && $('.passwd2').val() != '') {
                        $('.updatePassword').prop('disabled', false);
                        $('.setPasswordValue').hide();
                        $('#refresh').show();
                    } else {
                        $('.updatePassword').prop('disabled', true);
                    }
                }else{
                  if ($('.passwd1').val() != '' && $('.passwd2').val() != '') {
                        $('.updatePassword').prop('disabled', false);
                        $('.setPasswordValue').hide();
                        $('.refresh').show();
                    } else {
                        $('.updatePassword').prop('disabled', true);
                    }
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
