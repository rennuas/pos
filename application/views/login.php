<!DOCTYPE html>
<html lang="en">

<head>

    <?php $this->load->view('templates/head'); ?>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    <?= $this->session->flashdata('login_msg'); ?>
                                    <?= validation_errors('<p class="text-center text-danger">', '</p>'); ?>
                                    <form class="user" action="<?= site_url('auth'); ?>" method="post">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" id="inputEmail" aria-describedby="emailHelp" placeholder="Masukan Username..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="inputPassword" placeholder="Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <?php $this->load->view('templates/scripts/scripts'); ?>

</body>

</html>