<?php
//define page title
$title = 'Demo';
//include header template
require('layout/header.php');
?>
    <div class="container">
           <div class="col-md-6 col-md-offset-3">
                <form role="form" method="POST" action="" autocomplete="off">
                    <h2>Please Sign Up</h2>
                    <hr>

                    <?php
                    //check for any errors
                    if(isset($error)){
                        foreach($error as $error){
                            echo '<p class="bg-danger">'.$error.'</p>';
                        }
                    }
                    ?>

                    <div class="form-group">
                        <input type="text" name="username" id="username" class="form-control input-lg" placeholder="User Name" value="<?php if(isset($error)&&isset($_POST['username'])){ echo $_POST['username']; } ?>" tabindex="1">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)&&isset($_POST['email'])){ echo $_POST['email']; } ?>" tabindex="2">
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="3">
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="4">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg active" tabindex="5"></div>
                    </div>
                </form>
            </div>
    </div>

<?php
//include header template
require('layout/footer.php');
?>