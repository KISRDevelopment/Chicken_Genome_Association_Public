<!DOCTYPE html>
<html>
    <head>
        <?php
            include("htmlHead.html");
        ?>
        <link href="stylesheet.css" rel="stylesheet">
        <style>
            .d-flex{
				min-height: 100vh !important;
			}
			.css-selector {
			    background: linear-gradient(221deg, #050505, #262624, #000000, #737373);
			    background-size: 800% 800%;
			    
			    -webkit-animation: AnimationName 10s ease infinite;
			    -moz-animation: AnimationName 10s ease infinite;
			    animation: AnimationName 10s ease infinite;
			}

			@-webkit-keyframes AnimationName {
			    0%{background-position:99% 0%}
			    50%{background-position:2% 100%}
			    100%{background-position:99% 0%}
			}
			@-moz-keyframes AnimationName {
			    0%{background-position:99% 0%}
			    50%{background-position:2% 100%}
			    100%{background-position:99% 0%}
			}
			@keyframes AnimationName { 
			    0%{background-position:99% 0%}
			    50%{background-position:2% 100%}
			    100%{background-position:99% 0%}
			}
		</style>
    </head>
    <body>
        <div class="d-flex align-items-center justify-content-center bg-light css-selector">
            <div>
                <div class="card text-dark px-1 text-center py-3" style="background: rgba(255,255,255,1);">
                    <div class="card-title pt-3">
                        <h6 class="mt-3">Login</h6>
                    </div>
                    <?php
                                if(@$_GET['Empty']==true){
                            ?>
                                <div class="alert-light text-danger text-center py-2">
                                    Please enter your credentials
                                </div>			
                            <?php
                                }
                            ?>

                            <?php
                                if(@$_GET['Invalid']==true){
                            ?>
                                <div class="alert-light text-danger text-center py-2">
                                        Wrong username or password
                                    
                                </div>			
                            <?php
                                }
                            ?>
                    <div class="card-body py-3 mb-3">
                        <form  action="loginProcess" method="post">
                            <input type="text" name="uName"  placeholder="Username" class="form-control mt-3 mb-2">
                            <input type="password" name="pass" placeholder="Password" class="form-control mb-3">
                            <input type="submit" name="Login" value="Login" class="btn btn-success mt-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>
