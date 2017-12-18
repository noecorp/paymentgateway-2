@extends('layouts.app')
<style type="text/css">


</style>
@section('content')


<div class="container">
    <div class="row" style="margin-top: 60px;">
   
        <div class="col-md-8  col-sm-8 col-lg-8 componentfloat" style="overflow:auto;">
            
            <div class="panel panel-default " >
                 

                <div class="panel-heading" >Dashboard</div>


                <passport-clients></passport-clients>
<passport-authorized-clients></passport-authorized-clients>
<passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4 componentfloat" style="overflow:auto;">

            <mobile-money></mobile-money>   
        </div>
    </div>
    <div class="row">
        
        <div class="col-sm-12 col-md-6 col-lg-6 componentfloat" style="overflow:auto;">

            <transaction-money></transaction-money>  
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 componentfloat" style="overflow:auto;">
        <CENTER><h1>SUBSCRIPTION</h1></CENTER>
        <div class="container"><subscription-money></subscription-money> </div>
             
        </div>

    </div>
</div>
@endsection

@section('script')
<!-- <script  src="js/vue.min.js"></script>

<script type="text/javascript" src="js/samplevue.js"></script>
 -->@endsection