<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test KarmaPulse</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row" style="margin-top:3%;">
                <div class="col-md-10 col-md-offset-1" >
                    <h3>Colsultas a Base de Datos - Tweeter</h3> <br/>
                    <h4>Funciones</h4>
                    <ul>
                        <li><strong>F1: </strong><span>Devuelve el número de tweets, numero total de usuarios únicos, menciones únicas y hashtags únicos de una búsqueda.</span></li>
                        <li><strong>F2: </strong><span>Devuele el Top 10 de los hashtags con mayores apariciones de una  búsqueda.</span></li>
                        <li><strong>F3: </strong><span>Devuelve el porcentaje de retweets y tweets originales de una búsqueda.</span></li>
                    </ul><br/><br/>
                    <div class="col-md-6">
                        <form id="form" class="form-horizontal" method="GET" action="{{url('/search')}}">
                            <div class="form-group">
                                <label for="">Búsqueda</label>
                                <select class="form-control" name="searchId" required>
                                @foreach ($searches as $search)
                                    <option value="{{$search->_id}}">{{$search->_id}}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Fecha Inicial</label>
                                <input type="date" name="initialDate" class="form-control" id="" required >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail2">Fecha Final</label>
                                <input type="date" name="finalDate" class="form-control" id="" required>
                            </div>
                            <div class="form-group">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" onclick="changeSubmit(1)">F1</button>
                                    <button type="submit" class="btn btn-primary" onclick="changeSubmit(2)">F2</button>
                                    <button type="submit" class="btn btn-primary" onclick="changeSubmit(3)">F3</button>
                                </div>
                            </div>
                        </form>
                        <b>Nota: </b><span>El intervalo de fechas es considerado desde o hasta las 00:00:00 del día elegido</span>
                        <span>Es decir, si la fecha final es 01/01/2016 el tweet con fecha 01/01/2016 00:00:01 está fuera de rango.</span>
                    </div>
                    <div class="col-md-6">
                        @if (isset($query))
                            {{dump($query)}}
                        @endif
                        @if (isset($result))
                            {{dump($result)}}
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript">
            function changeSubmit( f ){
                $("#form").attr('action', '{{url('/search/f')}}'+f);
            }
        </script>
    </body>
</html>
