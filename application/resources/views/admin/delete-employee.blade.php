@extends('layouts.default')

    @section('meta')
        <title>Employees | Workday Time Clock</title>
        <meta name="description" content="Workday view employees, delete employees, edit employees, add employees">
    @endsection

    @section('content')
    
    <div class="container-fluid">
        <div class="row">
            <div class="box box-success col-md-6">
            <div class="box-header with-border">{{ __('Message') }}</div>
                <div class="box-body">
                    <form action="{{ url('profile/delete/employee') }}" class="ui form" method="post" accept-charset="utf-8">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="@isset($id) {{$id}} @endisset">
                        <div class="field">
                            <div class="ui header" style="margin:0">{{ __('Are you sure?') }}</div>
                        
                            <p>{{ __("Be careful, this action cannot be undone! Employee’s attendance, schedules, leave, and user account will be removed") }}</p>
                        </div>
                        <div class="field">
                            <a href="{{ url('employees') }}" class="ui black deny button">{{ __('No') }}</a>
                            <button class="ui positive button approve" type="submit" name="submit"><i class="ui checkmark icon"></i>{{ __('Yes') }}</button>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>

    @endsection
