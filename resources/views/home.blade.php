@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                        <h3>your api informations are :</h3>

                        <div>
                            <span >user=  {{auth()->user()->email}}</span>
                        </div>
                        <div>
                            <span >api_token=  {{auth()->user()->api_token}}</span>
                        </div>
                    <div>
                        <h3>apiname: make-directory</h3>
                        <p>method: get / post</p>
                        <p>arguments: directory_name,user,api_token</p>
                        <p>example:</p>
                        <p>http:://194.5.195.128/api/make-directory?directory_name=string&user={{auth()->user()->email}}&api_token={{auth()->user()->api_token}}</p>
                    </div>
                    <div>
                        <h3>apiname: create-file</h3>
                        <p>method: get / post</p>
                        <p>arguments: file_name,user,api_token</p>
                        <p>example:</p>
                        <p>http:://194.5.195.128/api/create-file?file_name=string&user={{auth()->user()->email}}&api_token={{auth()->user()->api_token}}</p>
                    </div>
                    <div>
                        <h3>apiname: get-running-processes</h3>
                        <p>method: get / post</p>
                        <p>arguments: user,api_token</p>
                        <p>example:</p>
                        <p>http:://194.5.195.128/api/get-running-processes?user={{auth()->user()->email}}&api_token={{auth()->user()->api_token}}</p>
                    </div>
                    <div>
                        <h3>apiname: get-directory-list</h3>
                        <p>method: get / post</p>
                        <p>arguments: user,api_token</p>
                        <p>example:</p>
                        <p>http:://194.5.195.128/api/get-directory-list?user={{auth()->user()->email}}&api_token={{auth()->user()->api_token}}</p>
                    </div>
                    <div>
                        <h3>apiname: get-file-list</h3>
                        <p>method: get / post</p>
                        <p>arguments: user,api_token</p>
                        <p>example:</p>
                        <p>http:://194.5.195.128/api/get-file-list?user={{auth()->user()->email}}&api_token={{auth()->user()->api_token}}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
