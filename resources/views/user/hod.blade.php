@extends('layouts.Layout')

@section('title','View Hod')

@section('content')
<style>
textarea { width:250px !important; height:100px !important; }
</style>

<div class="generalHeader">
    View Hod
</div>
<body>
    {{ Form::open() }}
    @if(Session::has('error_message'))
        <div class="alert alert-danger">{{ Session::get('error_message') }}</div>
        {{Session::forget('error_message')}}
    @endif
    <br/>
 <div class="row">
    <div class="col-md-12 col-sm-12">
        <br><br>

        <table width="100%" cellpadding="5" cellspacing="5" id="hodsList" border="1"  class="table table-striped table-bordered dt-responsive" >
            <thead>
                <tr><th>S/N</th><th>Name</th><th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hods as $key=>$hod)
                <tr>
                <td>{{   $hod->hodid }}</td>
                <td>{{  $hod->hodname }}</td>
                <td class="td-limit">{{  $hod->hodemail }}</td>
                </tr>  
                @endforeach
            </tbody>
        </table>
        {!! $hods->render() !!}
    </div>
</div>   

</body>

@stop


<script type="text/javascript">
    //Pop up
function checkDelete(){
    return confirm('Are you sure?');
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
@include('layouts.datatables')
<script type="text/javascript">
  $(function($) {
  
  $('#hodsList').DataTable( {
  aaSorting : [[1, 'asc']],
    responsive: true,
  'paging':false,
  "bStateSave": true,
  "iCookieDuration": 365*60*60*24
});
  
  });
</script>