<?php

require_once(INCLUDE_DIR . 'class.staff.php');

class StaffAjaxAPI extends AjaxController {

  /**
   * Ajax: GET /staff/<id>/set-password
   *
   * Uses a dialog to add a new department
   *
   * Returns:
   * 200 - HTML form for addition
   * 201 - {id: <id>, name: <name>}
   *
   * Throws:
   * 403 - Not logged in
   * 403 - Not an administrator
   * 404 - No such agent exists
   */

   function setPasswordb($id) {
    global $ost, $thisstaff;

      if (!$thisstaff)
          Http::response(403, 'Agent login required');
      if (!$thisstaff->isAdmin())
          Http::response(403, 'Access denied');
      if ($id && !($staff = Staff::lookup($id)))
          Http::response(404, 'No such agent');

        $staff_set_password_custom = $_POST['staff_set_password_custom'];

        if('staff_set_password_custom' == $staff_set_password_custom){
            $ia= include(INCLUDE_DIR.'staff/db/config.php');
            session_start();
            // Set session variables
            $success_msg = $_SESSION['success'];
            $error_msg = $_SESSION['error'] = array();
            $current_password = $_POST['current_password'];
            $passwd1 = $_POST['passwd1'];
            $passwd2 = $_POST['passwd2'];
            $staff_id = $_POST['staff_id'];
            if(isset($passwd1) && isset($passwd2)){
            $compare_password = strcmp($passwd1,$passwd2);
            if($compare_password == 0){
                $query_select = "SELECT * FROM ost_staff where  staff_id=$staff_id";

                $result = mysqli_query($con, $query_select);
                if($result){
        
                    if( mysqli_num_rows($result) > 0){
                       
                        $query_update = "UPDATE ost_staff SET passwd='$passwd1' , change_passwd=1 WHERE staff_id=$staff_id";
  
                        $query_update_run = mysqli_query($con,$query_update);
                        $success_msg = 'Successfully updated';
                    ?>
                    <script type="text/javascript">
                        alert('Successfully updated');
                        setTimeout(function () {
                        location.reload();
                        }, 2000);
                    </script>
                    <?php
                    }else{
                        $error_msg = 'something wrong.';
                        ?>
                        <script type="text/javascript">
                        alert('something wrong. ');
                        setTimeout(function () {
                        location.reload();
                        }, 2000);
                    </script>
                    <?php }
            
                }
           }else{
            $error = 'Passwords do not match.';
            ?>
            <script type="text/javascript">
            alert('Passwords do not match');
            setTimeout(function () {
            location.reload();
            }, 2000);
           </script>
        <?php 
           }
         }
         else{
            $error = 'All field is require.';
            ?>
            <script type="text/javascript">
            $('.updatePassword').prop('disabled', true);
           
            alert('All field is require');
            setTimeout(function () {
            location.reload();
            }, 2000);
           </script>
        <?php 
          }
        }
    $form = new PasswordResetForm($_POST);
    $errors = array();

    

    $title = __("Set Agent Password");
    $verb = $id == 0 ? __('Set') : __('Update');
    $path = ltrim(Osticket::get_path_info(), '/');

    include STAFFINC_DIR . 'templates/quick-add.tmpl.php';
}
  function setPassword($id) {
      global $ost, $thisstaff;

      if (!$thisstaff)
          Http::response(403, 'Agent login required');
      if (!$thisstaff->isAdmin())
          Http::response(403, 'Access denied');
      if ($id && !($staff = Staff::lookup($id)))
          Http::response(404, 'No such agent');

      $form = new PasswordResetForm($_POST);
      $errors = array();
      if (!$_POST && isset($_SESSION['new-agent-passwd']))
          $form->data($_SESSION['new-agent-passwd']);
        //   echo'<pre>POST_data ='; print_r($_POST);die;
      if ($_POST && $form->isValid()) {
          $clean = $form->getClean();
        //   echo'<pre>post ='; print_r($_POST);die;
          try {
              // Validate password
              if (!$clean['welcome_email'])
                  Staff::checkPassword($clean['passwd1'], null);
              if ($id == 0) {
                  // Stash in the session later when creating the user
                  $_SESSION['new-agent-passwd'] = $clean;
                  Http::response(201, 'Carry on');
              }
              if ($clean['welcome_email']) {
                  $staff->sendResetEmail();
              }
              else {
                  $staff->setPassword($clean['passwd1'], null);
                            // echo'<pre>passwd1 ='.$clean['passwd1'];
                  if ($clean['change_passwd'])
                            //    echo'<pre>change_passwd ='.$clean['change_passwd'];die;
                      $staff->change_passwd = 1;
              }
              if ($staff->save())
                  Http::response(201, 'Successfully updated');
          }
          catch (BadPassword $ex) {
              if ($passwd1 = $form->getField('passwd1'))
                  $passwd1->addError($ex->getMessage());
          }
          catch (PasswordUpdateFailed $ex) {
              $errors['err'] = __('Password update failed:').' '.$ex->getMessage();
          }
      }

      $title = __("Set Agent Password");
      $verb = $id == 0 ? __('Set') : __('Update');
      $path = ltrim(Osticket::get_path_info(), '/');

      include STAFFINC_DIR . 'templates/quick-add.tmpl.php';
  }

    function changePassword($id) {
        global $cfg, $ost, $thisstaff;
        if (!$thisstaff)
            Http::response(403, 'Agent login required');
        if (!$id || $thisstaff->getId() != $id)
            Http::response(404, 'No such agent');

            $staff_change_password_custom = $_POST['staff_change_password_custom'];

        if('staff_change_password_custom' == $staff_change_password_custom){
            $ia= include(INCLUDE_DIR.'staff/db/config.php');
            session_start();
            // Set session variables
            $success_msg = $_SESSION['success'];
            $error_msg = $_SESSION['error'] = array();
            $current_password = $_POST['current_password'];
            $passwd1 = $_POST['passwd1'];
            $passwd2 = $_POST['passwd2'];
            $staff_id = $_POST['staff_id'];
            if(isset($passwd1) && isset($passwd2)){
            $compare_password = strcmp($passwd1,$passwd2);
            if($compare_password == 0){
                $query_select = "SELECT * FROM ost_staff where passwd = '$current_password' and  staff_id=$staff_id";

                $result = mysqli_query($con, $query_select);
                if($result){
        
                    if( mysqli_num_rows($result) > 0){
                       
                        $query_update = "UPDATE ost_staff SET passwd='$passwd1' , change_passwd=0 WHERE staff_id=$staff_id";
  
                        $query_update_run = mysqli_query($con,$query_update);
                        $success_msg = 'Successfully updated';
                    ?>
                    <script type="text/javascript">
                        alert('Successfully updated');
                        setTimeout(function () {
                        location.reload();
                        }, 2000);
                    </script>
                    <?php
                    }else{
                        $error_msg = 'Current password is incorrect.';
                        ?>
                        <script type="text/javascript">
                        alert('Current password is incorrect.');
                        setTimeout(function () {
                        location.reload();
                        }, 2000);
                    </script>
                    <?php }
            
                }
           }else{
            $error = 'Passwords do not match.';
            ?>
            <script type="text/javascript">
            alert('Passwords do not match');
            setTimeout(function () {
            location.reload();
            }, 2000);
           </script>
        <?php 
           }
         }
         else{
            $error = 'All field is require.';
            ?>
            <script type="text/javascript">
            $('.updatePassword').prop('disabled', true);
           
            alert('All field is require');
            setTimeout(function () {
            location.reload();
            }, 2000);
           </script>
        <?php 
          }
        }
        $form = new PasswordChangeForm($_POST);
        $errors = array();

        

        $title = __("Change Password");
        $verb = __('Update');
        $path = ltrim(Osticket::get_path_info(), '/');

        include STAFFINC_DIR . 'templates/quick-add.tmpl.php';
    }

    function getAgentPerms($id) {
        global $thisstaff;

        if (!$thisstaff)
            Http::response(403, 'Agent login required');
        if (!$thisstaff->isAdmin())
            Http::response(403, 'Access denied');
        if (!($staff = Staff::lookup($id)))
            Http::response(404, 'No such agent');

        return $this->encode($staff->getPermissionInfo());
    }

    function resetPermissions() {
        global $ost, $thisstaff;

        if (!$thisstaff)
            Http::response(403, 'Agent login required');
        if (!$thisstaff->isAdmin())
            Http::response(403, 'Access denied');

        $form = new ResetAgentPermissionsForm($_POST);

        if (@is_array($_GET['ids'])) {
            $perms = new RolePermission(null);
            $selected = Staff::objects()->filter(array('staff_id__in' => $_GET['ids']));
            foreach ($selected as $staff)
                // XXX: This maybe should be intersection rather than union
                $perms->merge($staff->getPermission());
            $form->getField('perms')->setValue($perms->getInfo());
        }

        if ($_POST && $form->isValid()) {
            $clean = $form->getClean();
            Http::response(201, $this->encode(array('perms' => $clean['perms'])));
        }

        $title = __("Reset Agent Permissions");
        $verb = __("Continue");
        $path = ltrim(Osticket::get_path_info(), '/');

        include STAFFINC_DIR . 'templates/reset-agent-permissions.tmpl.php';
    }

    function changeDepartment() {
        global $ost, $thisstaff;

        if (!$thisstaff)
            Http::response(403, 'Agent login required');
        if (!$thisstaff->isAdmin())
            Http::response(403, 'Access denied');

        $form = new ChangeDepartmentForm($_POST);

        // Preselect reasonable dept and role based on the current  settings
        // of the received staff ids
        if (@is_array($_GET['ids'])) {
            $dept_id = null;
            $role_id = null;
            $selected = Staff::objects()->filter(array('staff_id__in' => $_GET['ids']));
            foreach ($selected as $staff) {
                if (!isset($dept_id)) {
                    $dept_id = $staff->dept_id;
                    $role_id = $staff->role_id;
                }
                elseif ($dept_id != $staff->dept_id)
                    $dept_id = 0;
                elseif ($role_id != $staff->role_id)
                    $role_id = 0;
            }
            $form->getField('dept_id')->setValue($dept_id);
            $form->getField('role_id')->setValue($role_id);
        }

        if ($_POST && $form->isValid()) {
            $clean = $form->getClean();
            Http::response(201, $this->encode($clean));
        }

        $title = __("Change Primary Department");
        $verb = __("Continue");
        $path = ltrim(Osticket::get_path_info(), '/');

        include STAFFINC_DIR . 'templates/quick-add.tmpl.php';
    }

    function setAvatar($id) {
        global $thisstaff;

        if (!$thisstaff)
            Http::response(403, 'Agent login required');
        if ($id != $thisstaff->getId() && !$thisstaff->isAdmin())
            Http::response(403, 'Access denied');
        if ($id == $thisstaff->getId())
            $staff = $thisstaff;
        else
            $staff = Staff::lookup((int) $id);

        if (!($avatar = $staff->getAvatar()))
            Http::response(404, 'User does not have an avatar');

        if ($code = $avatar->toggle())
          return $this->encode(array(
            'img' => (string) $avatar,
            // XXX: This is very inflexible
            'code' => $code,
          ));
    }

    function configure2FA($staffId, $id=0) {
        global $thisstaff;
        if (!$thisstaff)
            Http::response(403, 'Agent login required');
        if ($staffId != $thisstaff->getId())
            Http::response(403, 'Access denied');
        if ($id && !($auth= Staff2FABackend::lookup($id)))
            Http::response(404, 'Unknown 2FA');

        $staff = $thisstaff;
        $info = array();
        if ($auth) {
            // Simple state machine to manage settings and verification
            $state = @$_POST['state'] ?: 'validate';
            switch ($state) {
                case 'verify':
                    try {
                        $form = $auth->getInputForm($_POST);
                        if ($_POST && $form
                                && $form->isValid()
                                && $auth->validate($form, $staff)) {
                            // Mark the settings as verified
                            if (($config = $staff->get2FAConfig($auth->getId()))) {
                                $config['verified'] = time();
                                $staff->updateConfig(array(
                                            $auth->getId() => JsonDataEncoder::encode($config)));
                            }
                            // We're done here
                            $auth = null;
                            $info['notice'] = __('Setup completed successfully');
                        } else {
                            $info['error'] = __('Unable to verify the token - try again!');
                        }
                    } catch (ExpiredOTP $ex) {
                        // giving up cleanly
                        $info['error'] = $ex->getMessage();
                        $auth = null;
                    }
                    break;
                case 'validate':
                default:
                    $config = $staff->get2FAConfig($auth->getId());
                    $vars = $_POST ?: $config['config'] ?: array('email' => $staff->getEmail());
                    $form = $auth->getSetupForm($vars);
                    if ($_POST && $form && $form->isValid()) {
                        if ($config['config'] && $config['config']['external2fa'])
                            $external2fa = true;

                        // Save the setting based on setup form
                        $clean = $form->getClean();
                        if (!$external2fa) {
                            $config = ['config' => $clean, 'verified' => 0];
                            $staff->updateConfig(array(
                                        $auth->getId() => JsonDataEncoder::encode($config)));
                        }

                        // Send verification token to the user
                        if ($token=$auth->send($staff)) {
                            // Transition to verify state
                            $form =  $auth->getInputForm($vars);
                            $state = 'verify';
                            $info['notice'] = __('Token sent to you!');
                        } else {
                            // Generic error TODO: better wording
                            $info['error'] = __('Error sending Token - double check entry');
                        }
                    }
            }
        }

        include STAFFINC_DIR . 'templates/2fas.tmpl.php';
    }

    function reset2fA($staffId) {
        global $thisstaff;

        if (!$thisstaff)
            Http::response(403, 'Agent login required');
        if (!$thisstaff->isAdmin())
            Http::response(403, 'Access denied');

        $default_2fa = ConfigItem::getConfigsByNamespace('staff.'.$staffId, 'default_2fa');

        if ($default_2fa)
            $default_2fa->delete();
    }
}
