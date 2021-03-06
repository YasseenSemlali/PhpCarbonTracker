
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Carbon Emission Tracker</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
       
        <!-- Styles -->
        <style>
            html, body {
               /*background-image:url('images/enviro.jpg');*/
               
                 background-image: url('http://blog.seagate.com/wp-content/uploads/2015/04/Global-strategy-for-environmental-sustainability.jpg');
                  background-size:auto;
                /*background-color: #fff;*/
               background-color: #9fdf9f;
                /*color: #636b6f;*/
                color:	#000000;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 39px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .fact{
                 text-align: center;
                 margin-left: 20%;
                margin-right: 20%;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Carbon Emission Tracker
                </div>

         
                <div>
                    <div>An Interesting Fact:</div>
                    <div class= "fact">
                       <p> <mark>Electricity = Carbon Dioxide </mark>– like it or not, every time you plug in, 
                        you are impacting the environment through carbon emissions. Power plants all over the world utilize fossil fuels, 
                        coal, and alternative energies such as nuclear, wind, water, and solar. Unfortunately there is still a carbon impact. 
                        Even discarded batteries from laptops or cell phones can leave a deadly impact in landfills. Consider unplugging for one day,
                        or even a few hours, each week. Find an activity that does not involve electricity, and enjoy it..</p> 
                    </div>
                    

                </div>
                
            </div>
        </div>
    </body>
</html>
