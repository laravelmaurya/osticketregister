<style>
.alert.danger {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.alert.success {background-color: #04AA6D;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>

<!-- <div class="alert danger">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
</div> -->

<div class="alert <?php if(isset($success_msg)){ echo 'success'; }elseif(isset($error_msg)){ echo 'danger'; }elseif(isset($info_msg)){ echo 'info'; }elseif(isset($warning_msg)){ echo 'warning'; } ?>">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong><?php if(isset($success_msg)){ echo 'Success'; }elseif(isset($error_msg)){ echo 'Danger'; }elseif(isset($info_msg)){ echo 'Info'; }elseif(isset($info_msg)){ echo 'Warning'; } ?>!</strong>
  <?php if(isset($success_msg)){ echo $success_msg; }elseif(isset($error_msg)){ echo $error_msg; }elseif(isset($info_msg)){ echo $info_msg; }elseif(isset($warning_msg)){ echo $warning_msg; } ?>
</div>