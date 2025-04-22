@extends('adminlte::auth.login')


@section('css')
    <style>
        body {
            background-image: url('/assets/images/login_1.jpg');
            background-size: cover;
            background-position: center;

        }

        .login-logo a,
        .register-logo a {
            color: #FFF;
        }
    </style>
@stop


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            register = document.getElementsByClassName('card-footer');
            register[0].children[1].classList.add('d-none');
            passimage = $('.fa-lock');
            passimage.attr('id', 'passimage');
            passimage[0].classList.remove('fa-lock');
            passimage[0].classList.add('fa-eye');

            pass = document.getElementsByName('password')
            $('.icheck-primary').addClass('d-none');

            $(document).on('click', '#passimage', function() {
                passwordInput = document.getElementsByName('password');
                icon = passimage[0];
                if (passwordInput[0].type === 'password') {
                    passwordInput[0].type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput[0].type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');

                }
            });

        });
    </script>
@stop
