@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            <div class="card-header">
                <h3 class="card-title">{{$user->name}}</h3>
            </div>
            <div class="card-body">
                <div>住所</div>
                
                <div>{{$user->address}}</div>
            </div>
        </aside>
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                {{-- ユーザ詳細タブ --}}
                <li class="nav-item"><a href="#" class="nav-link">予約状況</a></li>
                <li class="nav-item"><a href="#" class="nav-link">診療時間設定</a></li>
                <li class="nav-item"><a href="#" class="nav-link">予約</a></li>
            </ul>
            <div class="">
                
                @foreach($consultaion_hours as $consultaion_hour)
                    {{$consultaion_hour}}
                @endforeach
                <table class="table clinic_table">
                    <tr>
                        <th></th>
                        @for($i = 0; $i<7; $i++)
                        <th>{{$weeks[$i]}}</th>
                        @endfor
                    </tr>
                   @foreach($timePeriods as $timePeriod)
                    <tr>
                        <td>{{$timePeriod}}</td>
                        @for($i = 0; $i<7; $i++)
                        <td>
                        <!--consultation_hoursのweekの値とtimeの値が同じものがあれば〇-->
                        @if(\Auth::user()->consultation_hours()->where('week', $weeks[$i])->where('time', $timePeriod)->exists())
                            {{ Form::open(['route' => ['clinic.closed', 'id' => $user->id],'method' => 'delete']) }} 
                                {{ Form::hidden('userId',$user->id) }}
                                {{ Form::hidden('week',$weeks[$i]) }}
                                {{ Form::hidden('time',$timePeriod) }}
                                {{ Form::submit('〇', ['class'=>'',]) }}
                            {{ Form::close() }}
                        @else
                            <!--なければ✕でフォーム送信-->
                            {{ Form::open(['route' => ['clinic.opened', 'id' => $user->id]]) }} 
                                {{ Form::hidden('userId',$user->id) }}
                                {{ Form::hidden('week',$weeks[$i]) }}
                                {{ Form::hidden('time',$timePeriod) }}
                                {{ Form::submit('✕', ['class'=>'',]) }}
                            {{ Form::close() }}
                        @endif
                        </td>
                        @endfor
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        
    </div>
@endsection