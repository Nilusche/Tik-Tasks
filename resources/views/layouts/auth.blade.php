<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/loader.css">
    <title>Login</title>


    <style media="screen">
        *,
        *:before,
        *:after{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Chakra Petch', sans-serif;
        }

        .background{
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%,-50%);
            left: 50%;
            top: 50%;
        }
        .sphere {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        #bluesphere{
            background: linear-gradient(
                    #6FC5CD,
                    #00666d
            );
            left: 220px;
            top: -80px;
        }

        #redsphere{
            background: linear-gradient(
                    to right,
                    #E62755,
                    #a20043
            );
            left: -160px;
            bottom: -80px;
        }
        .loginform{
            height: 520px;
            width: 400px;
            background-color: rgba(205,205,205,0.13);
            position: absolute;
            transform: translate(-50%,-50%);
            top: 50%;
            left: 40%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(90,90,90,0.1);
            box-shadow: 0 0 40px rgba(8,7,16,0.6);
            padding: 50px 35px;
        }
        .loginform *{
            font-family: 'Chakra Petch', sans-serif;
            color: #000000;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }
        .loginuber{
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }

        .labelinput{
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }

        .loginput{
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(0,0,0,0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }
        ::placeholder{
            color: #727272;
        }
        #loginbutton{
            margin-top: 50px;
            width: 100%;
            background-color: #000000;
            color: #ffffff;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        #loginbutton:hover {
            background-color: rgba(0, 0, 0, 0.07);
            color: black;
        }
        .grid {
            position: absolute;
            height: 520px;
            width: 600px;
            display: grid;
            grid-template-columns: 66.6% auto;
            top: 15%;
            left: 27%;

        }
        .logo {

            position: absolute;
            top: 56%;
            left: 107%;
            transform: translate(-50%,-50%);


        }

        #loginfail {
            height: 70px;
            margin-top:25px;
            margin-bottom:-50px;
        }
        .invalid-feedback{
            color:#E62755;
        }
        .check{
            margin-top:25px;
            margin-bottom:-50px;
        }
    </style>
</head>
<body>
@yield('content')

@yield('loader')
@yield('scripts')

</body>
</html>
